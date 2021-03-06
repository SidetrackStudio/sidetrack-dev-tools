<?php

/**
 * Tabbed Settings Page
 */

add_action( 'init', 'ss_dev_admin_init' );
add_action( 'admin_menu', 'ss_dev_settings_page_init', 13 );

function ss_dev_admin_init() {
	$settings = get_option( 'ss_dev_tabbed_settings' );
	if ( empty( $settings ) ) {
		$settings = array(
			'ss_dev_intro'     => 'Some intro text for the home page',
			'ss_dev_tag_class' => false,
			'ss_dev_ga'        => false,
		);
		add_option( 'ss_dev_tabbed_settings', $settings, '', 'yes' );
	}
}
// Notice: Undefined index: ss-dev-settings-submit in /app/public/wp-content/plugins/sidetrack-dev-tools/inc/sidetrack-tabbed-settings.php on line 30
function ss_dev_settings_page_init() {
	$plugin_data = get_ss_dev_setup_data();
	// $settings_page = add_dashboard_page( $plugin_data['Name'] . ' Settings', $plugin_data['Name'] . ' Settings', 'manage_options', 'sidetrack-settings', 'ss_dev_settings_page' );
	$settings_page = add_submenu_page( 'ss-dev-dashboard.php', 'Sidetrack Settings', 'Sidetrack Settings', 'manage_options', 'sidetrack-settings', 'ss_dev_settings_page' );
	add_action( "load-{$settings_page}", 'ss_dev_load_settings_page' );
}

function ss_dev_load_settings_page() {
	if ( isset( $_POST['ss-dev-settings-submit'] ) && 'Y' === $_POST['ss-dev-settings-submit'] ) {
		check_admin_referer( 'ss-dev-settings-page' );
		ss_dev_save_tabbed_settings();
		$url_parameters = isset( $_GET['tab'] ) ? 'updated=true&tab=' . $_GET['tab'] : 'updated=true';
		wp_redirect( admin_url( 'index.php?page=sidetrack-settings&' . $url_parameters ) );
		exit;
	}
}

function ss_dev_save_tabbed_settings() {
	global $pagenow;
	$settings = get_option( 'ss_dev_tabbed_settings' );

	if ( $pagenow == 'index.php' && $_GET['page'] == 'sidetrack-settings' ) {
		if ( isset( $_GET['tab'] ) ) {
			$tab = $_GET['tab'];
		} else {
			$tab = 'homepage';
		}

		switch ( $tab ) {
			case 'general':
				$settings['ss_dev_tag_class'] = $_POST['ss_dev_tag_class'];
				break;
			case 'footer':
				$settings['ss_dev_ga'] = $_POST['ss_dev_ga'];
				break;
			case 'homepage':
				$settings['ss_dev_intro'] = $_POST['ss_dev_intro'];
				break;
		}
	}
	if ( ! current_user_can( 'unfiltered_html' ) ) {
		if ( $settings['ss_dev_ga'] ) {
			$settings['ss_dev_ga'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['ss_dev_ga'] ) ) );
		}
		if ( $settings['ss_dev_intro'] ) {
			$settings['ss_dev_intro'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['ss_dev_intro'] ) ) );
		}
	}

	$updated = update_option( 'ss_dev_tabbed_settings', $settings );
}

function ss_dev_admin_tabs( $current = 'homepage' ) {
	$tabs  = array(
		'homepage' => 'Home',
		'general'  => 'General',
		'footer'   => 'Footer',
	);
	$links = array();
	echo '<div id="icon-themes" class="icon32"><br></div>';
	echo '<h2 class="nav-tab-wrapper">';
	foreach ( $tabs as $tab => $name ) {
		$class = ( $tab == $current ) ? ' nav-tab-active' : '';
		echo "<a class='nav-tab$class' href='?page=sidetrack-settings&tab=$tab'>$name</a>";

	}
	echo '</h2>';
}

function get_ss_dev_setup_data() {
	$plugin_data['Name'] = 'Sidetrack';
	return $plugin_data;
}


function ss_dev_settings_page() {
	global $wpdb;
	echo '<div class="wrap">';
	echo '<h2>' . ucwords( preg_replace( '/_+/', ' ', __FUNCTION__ ) ) . '</h2>';

	echo '</div>';
}


function ss_dev_settings_page1() {
	global $pagenow;
	$settings    = get_option( 'ss_dev_tabbed_settings' );
	$plugin_data = get_ss_dev_setup_data();
	?>
	
	<div class="wrap">
		<h2><?php echo $plugin_data['Name']; ?> Settings</h2>
		<style type="text/css">
		h1, p {
			margin: 0 0 1em 0;
		}

		/* no grid support? */
		.sidebar {
			float: left;
			/*width: 19.1489%;*/
		}

		.content {
			float: right;
			/*width: 79.7872%;*/
		}

		/* make a grid */
		.grid-wrapper {
			/*max-width: 940px;*/
			margin: 0 auto;
			display: grid;
			grid-template-columns: 1fr 4fr;
			grid-gap: .5rem;
		}

		.grid-wrapper > * {
			background-color: mintcream;
			color: maroon;
			border-radius: .2rem;
			padding: 1rem;
			font-size: 150%;
			/* needed for the floated layout*/
			margin-bottom: .5rem;
		}

		.header, .footer {
			grid-column: 1 / -1;
			/* needed for the floated layout */
			clear: both;
		}


		/* We need to set the widths used on floated items back to auto, and remove the bottom margin as when we have grid we have gaps. */
		@supports (display: grid) {
			.grid-wrapper > * {
				width: auto;
				margin: 0;
			}
		}
	</style>
	<?php
	if ( 'true' == esc_attr( $_GET['updated'] ) ) {
		echo '<div class="updated" ><p> Settings updated.</p></div>';
	}

	if ( isset( $_GET['tab'] ) ) {
		ss_dev_admin_tabs( $_GET['tab'] );
	} else {
		ss_dev_admin_tabs( 'homepage' );
	}
	?>

	<div id="poststuff">
		<div class="grid-wrapper">
			<header class="header">My header</header>
			<form method="post" action="<?php admin_url( 'index.php?page=sidetrack-settings' ); ?>">
				<?php
				wp_nonce_field( 'ss-dev-settings-page' );

				if ( $pagenow == 'index.php' && $_GET['page'] == 'sidetrack-settings' ) {

					if ( isset( $_GET['tab'] ) ) {
						$tab = $_GET['tab'];
					} else {
						$tab = 'homepage';
					}

					echo '<table class="form-table">';
					switch ( $tab ) {
						case 'general':
							?>

						<aside class="sidebar">Sidebar<label for="ss_dev_tag_class">Tags with CSS classes:</label></aside>						
						<article class="content">
							<h1>2 column, header and footer</h1>
							<p>
								<input id="ss_dev_tag_class" name="ss_dev_tag_class" type="checkbox" 
								<?php
								if ( $settings['ss_dev_tag_class'] ) {
									echo 'checked="checked"';}
								?>
									value="true" /> 
									<span class="description">Output each post tag with a specific CSS class using its slug.</span>
								</p>
							</article>
							<?php
							break;
						case 'footer':
							?>
							<aside class="sidebar">Sidebar<label for="ss_dev_ga">Insert tracking code:</label></aside>						
							<article class="content">
								<h1>2 column, header and footer</h1>
								<p>
									<textarea id="ss_dev_ga" name="ss_dev_ga" cols="60" rows="5"><?php echo esc_html( stripslashes( $settings['ss_dev_ga'] ) ); ?></textarea><br/>
									<span class="description">Enter your Google Analytics tracking code:</span>
								</p>
							</article>
							<?php
							break;
						case 'homepage':
							?>
							<aside class="sidebar">Sidebar<label for="ss_dev_intro">Introduction</label></aside>						
							<article class="content">
								<h1>2 column, header and footer</h1>
								<p>
									<textarea id="ss_dev_intro" name="ss_dev_intro" cols="60" rows="5" ><?php echo esc_html( stripslashes( $settings['ss_dev_intro'] ) ); ?></textarea><br/>
									<span class="description">Enter the introductory text for the home page:</span>
								</p>
							</article>
							<?php
							break;
					}
						echo '</table>';
				}
				?>
					<footer class="footer">My footer
						<p class="submit" style="clear: both;">
							<input type="submit" name="Submit"  class="button-primary" value="Update Settings" />
							<input type="hidden" name="ss-dev-settings-submit" value="Y" />
						</p>
					</footer>
				</form>
			</div>
		</div>
	</div>
	<?php
}

