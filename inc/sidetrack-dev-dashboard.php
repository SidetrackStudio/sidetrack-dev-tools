<?php
/**
 * Project: Sidetrack Dev Tools
 */
/**
 * Add a page to the dashboard menu.
 *
 * @since 1.0.0
 *
 * @return array
 */
add_action( 'admin_menu', 'ss_dev_dashboard' );
function ss_dev_dashboard() {
	$slug  = preg_replace( '/_+/', '-', __FUNCTION__ );
	$label = ucwords( preg_replace( '/_+/', ' ', __FUNCTION__ ) );
	add_dashboard_page( __( $label, 'sidetrack-dev-tools' ), __( $label, 'sidetrack-dev-tools' ), 'manage_options', $slug . '.php', 'ss_dev_dashboard_page' );
	$settings_page = add_dashboard_page( __( $label . '-dev', 'sidetrack-dev-tools' ), __( $label . '-dev', 'sidetrack-dev-tools' ), 'manage_options', $slug . '-dev.php', 'ss_dev_dashboard_page' );
	add_action( "load-{$settings_page}", 'ss_dev_load_settings_page' );
}


/**
 * Debug Information
 *
 * @since 1.0.0
 *
 * @param bool $html Optional. Return as HTML or not
 *
 * @return string
 */
function ss_dev_dashboard_page() {
	global $wpdb;
	echo '<div class="wrap">';
	echo '<h2>' . ucwords( preg_replace( '/_+/', ' ', __FUNCTION__ ) ) . '</h2>';
	$screen         = get_current_screen();
	$site_theme     = wp_get_theme();
	$site_prefix    = $wpdb->prefix;
	$prefix_message = '$site_prefix = ' . $site_prefix;
	if ( is_multisite() ) {
		$network_prefix  = $wpdb->base_prefix;
		$prefix_message .= '<br>$network_prefix = ' . $network_prefix;
	}

	echo '<div class="add-to-ss-dev-dash" style="background:aliceblue;padding:1rem 2rem;">';
	do_action( 'add_to_ss_dev_dash' );
	echo '</div>';

	echo '<h4 style="color:rgba(250,128,114,.7);">Current Screen is <span style="color:rgba(250,128,114,1);">' . $screen->id . '</span></h4>';

	echo 'Your WordPress version is ' . get_bloginfo( 'version' ) . '<br>';
	echo 'DB prefix is ' . $site_prefix . '<br>';
	echo 'PHP version is ' . phpversion() . '<br>';

	$site_theme = wp_get_theme();
	echo '<h4>Theme is ' . sprintf(
		__( '%1$s and is version %2$s', 'text-domain' ),
		$site_theme->get( 'Name' ),
		$site_theme->get( 'Version' )
	) . '</h4>';
	echo '<h4>Templates found in ' . get_template_directory() . '</h4>';
	echo '<h4>Stylesheet found in ' . get_stylesheet_directory() . '</h4>';
	echo '</div>';
}

add_action( 'add_to_ss_dev_dash', 'adding_to_ss_dev_dashboard_page' );

/**
 * Debug Information
 *
 * @since 1.0.0
 *
 * @param bool $html Optional. Return as HTML or not
 *
 * @return string
 */
function adding_to_ss_dev_dashboard_page() {
	echo '<h2>' . ucwords( preg_replace( '/_+/', ' ', __FUNCTION__ ) ) . '</h2>';
	echo '<h3>Add more info here</h3>';
}
add_action( 'add_to_ss_dev_dash', 'request_something_to_ss_dev' );
function request_something_to_ss_dev() {
	if ( isset( $_REQUEST['action'] ) && 'show_info' === $_REQUEST['action'] ) {
		echo 'pinged import file<br>';
	} else {
		echo 'import file does not exist<br>';
	}
}

add_action( 'add_to_ss_dev_dash', 'search_something_for_ss_dev' );
function search_something_for_ss_dev() {
	$current_url = home_url( add_query_arg( null, null ) );
	echo '<h4>$current_url = ' . $current_url . '</h4>';
	$add_query_arg = esc_url( add_query_arg( 'foo', 'bar' ) );
	echo '<h4>$add_query_arg = ' . $add_query_arg . '</h4>';

	echo '<br>We should have a button <a href="' . esc_url( add_query_arg( 'action', 'show_info' ) ) . '"><button>Click to add query arguments</button></a><br>';

}
