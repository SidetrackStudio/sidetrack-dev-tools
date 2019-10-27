<?php
/**
 *
 */

add_action( 'wp_enqueue_scripts', 'sidetrack_dev_tools_window_size' );
function sidetrack_dev_tools_window_size() {
	wp_register_script( 'sidetrack-window-size', plugins_url( 'js/sidetrack-dev-tools.js', __FILE__ ), [], time(), true );

	if ( true === Sidetrack_Studio_Dev_Customizer::filter_boolean_toggle( 'toggle_on_ss_dev_vanilla_size' ) ) {
		wp_enqueue_script( 'sidetrack-window-size' );
	}
}
