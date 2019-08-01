<?php
/**
 * Plugin Name: Sidetrack Dev Tools
 * Description: A set of tools to assist the development process of WordPress websites.
 * Author: pbrocks
 * Author URI: https://github.com/SidetrackStudio/sidetrack-dev-tools
 * Version: 1.0.4
 * License: GPLv2
 * Text Domain: sidetrack-dev-tools
 *
 * @since sidetrack-dev-tools 1.0
 */

defined( 'ABSPATH' ) || die( 'File cannot be accessed directly' );

if ( file_exists( __DIR__ . '/inc' ) && is_dir( __DIR__ . '/inc' ) ) {
	/**
	 * Include all php files in /inc directory.
	 */
	foreach ( glob( __DIR__ . '/inc/*.php' ) as $filename ) {
		require $filename;
	}
}
if ( file_exists( __DIR__ . '/inc/classes' ) && is_dir( __DIR__ . '/inc/classes' ) ) {
	/**
	 * Include all php files in /inc/classes directory.
	 */
	foreach ( glob( __DIR__ . '/inc/classes/*.php' ) as $filename ) {
		require $filename;
	}
}

/**
 * Setup WordPress localization support
 *
 * @since 4.0
 */
function sidetrack_dev_tools_load_textdomain() {
	load_plugin_textdomain( 'sidetrack-dev-tools', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'sidetrack_dev_tools_load_textdomain' );


/**
 * Show action links on the plugin screen.
 *
 * @param    mixed $links Plugin Action links
 *
 * @return    array
 *
 * @since 4.0
 */
function sidetrack_dev_tools_plugin_action_links( $links ) {
	$action_links = [
		'getting_started' => '<a href="' . esc_url( admin_url( 'options-general.php?page=sidetrack-dev-tools-settings.php' ) ) . '" title="' . esc_attr__( 'Get started with Sidetrack Dev Tools', 'sidetrack-dev-tools' ) . '">' . esc_html__( 'Getting Started', 'sidetrack-dev-tools' ) . '</a>',
	];
	return array_merge( $action_links, $links );
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'sidetrack_dev_tools_plugin_action_links' );
/**
 * Show row meta on the plugin screen.
 *
 * @param    mixed $links Plugin Row Meta
 * @param    mixed $file  Plugin Base file
 *
 * @return    array
 *
 * @since  4.0
 */
function sidetrack_dev_tools_plugin_row_meta( $links, $file ) {
	if ( strpos( $file, 'sidetrack-dev-tools.php' ) !== false ) {
		$new_links = array(
			'<a href="' . esc_url( 'https://github.com/SidetrackStudio/sidetrack-dev-tools/readme.md' ) . '" title="' . esc_attr( __( 'View Sidetrack Studio Documentation', 'sidetrack-dev-tools' ) ) . '">' . __( 'Docs', 'sidetrack-dev-tools' ) . '</a>',
			'<a href="' . esc_url( 'https://github.com/SidetrackStudio/sidetrack-dev-tools' ) . '" title="' . esc_attr( __( 'Visit Sidetrack Studio Repo', 'sidetrack-dev-tools' ) ) . '">' . __( 'Sidetrack Studio Support', 'sidetrack-dev-tools' ) . '</a>',
		);
		$links     = array_merge( $links, $new_links );
	}
	return $links;
}

add_filter( 'plugin_row_meta', 'sidetrack_dev_tools_plugin_row_meta', 10, 2 );
