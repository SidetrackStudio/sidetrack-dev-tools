<?php

defined( 'ABSPATH' ) || die( 'File cannot be accessed directly' );

if ( class_exists( 'Sidetrack_Studio_Dev_Customizer' ) ) {
	new Sidetrack_Studio_Dev_Customizer();
}
class Sidetrack_Studio_Dev_Customizer {

	public function __construct() {
		add_action( 'customize_register', array( $this, 'ss_dev_customizer_manager' ) );
	}

	/**
	 * [ss_dev_customizer_manager description]
	 *
	 * @param [type] $customizer_additions [description]
	 * @return [type]             [description]
	 */
	public function ss_dev_customizer_manager( $customizer_additions ) {
		$this->ss_dev_wp_control_panel( $customizer_additions );
		$this->ss_dev_wp_controls_section( $customizer_additions );
	}

	/**
	 * [ss_dev_wp_control_panel description]
	 *
	 * @param [type] $customizer_additions [description]
	 * @return [type]             [description]
	 */
	private function ss_dev_wp_control_panel( $customizer_additions ) {
		$customizer_additions->add_panel(
			'ss_dev_wp_control_panel',
			array(
				'title'       => __( 'SS dev Control Panel', 'sidetrack-dev-tools' ),
				'description' => __( 'SS dev Control Panel', 'sidetrack-dev-tools' ),
				'priority'    => 1,
			)
		);
	}
	/**
	 * The ss_dev_wp_controls_section function adds a new section
	 * to the Customizer to display the settings and
	 * controls that we build.
	 *
	 * @param  [type] $customizer_additions [description]
	 * @return [type]             [description]
	 */
	private function ss_dev_wp_controls_section( $customizer_additions ) {

		$customizer_additions->add_section(
			'ss_dev_wp_controls_section',
			array(
				'title'       => __( 'SS dev Section', 'sidetrack-dev-tools' ),
				'priority'    => 6,
				'panel'       => 'ss_dev_wp_control_panel',
				'description' => __(
					'Use these Controls to set up SS dev',
					'sidetrack-dev-tools'
				),
			)
		);
		/**
		 * Adding a Checkbox Toggle
		 */
		if ( ! class_exists( 'Customizer_Toggle_Control' ) ) {
			require_once dirname( __DIR__ ) . '/controls/checkbox/toggle-control.php';
		}

		// $key = preg_replace( '/-+/', '_', $key );
		$customizer_additions->add_setting(
			'toggle_on_ss_dev_wp_code',
			array(
				'default'   => true,
				'type'      => 'option',
				'transport' => 'refresh',
			)
		);

		$customizer_additions->add_control(
			new Customizer_Toggle_Control(
				$customizer_additions,
				'toggle_on_ss_dev_wp_code',
				array(
					'label'       => __( 'Turn off SS dev tracking code', 'sidetrack-dev-tools' ),
					'description' => __(
						'The default setting is on. This option allows you to turn this code off, if need be.',
						'sidetrack-dev-tools'
					),
					'section'     => 'ss_dev_wp_controls_section',
					'settings'    => 'toggle_on_ss_dev_wp_code',
					'type'        => 'ios',
					'priority'    => 1,
				)
			)
		);

		$customizer_additions->add_setting(
			'ss_dev_wp_uet_code',
			array(
				'type'      => 'option',
				'transport' => 'refresh',
			)
		);
		$customizer_additions->add_control(
			'ss_dev_wp_uet_code',
			array(
				'label'       => __( 'SS dev tracking Tag ID', 'sidetrack-dev-tools' ),
				'type'        => 'text',
				'settings'    => 'ss_dev_wp_uet_code',
				'section'     => 'ss_dev_wp_controls_section',
				'description' => __(
					'Get your code from <a href="https://help.ss_dev_wpads.microsoft.com/#apex/3/en/56687/2" target="_blank">help.ss_dev_wpads.microsoft.com</a>',
					'sidetrack-dev-tools'
				),
			)
		);

		$customizer_additions->add_section(
			'ss_dev_wp_controls_second',
			array(
				'title'       => __( 'SS dev 2nd Section', 'sidetrack-dev-tools' ),
				'priority'    => 6,
				'panel'       => 'ss_dev_wp_control_panel',
				'description' => __(
					'Use these Controls to set up SS dev',
					'sidetrack-dev-tools'
				),
			)
		);

		$customizer_additions->add_setting(
			'some_checkout_page',
			array(
				'type'      => 'option',
				'transport' => 'refresh',
			)
		);
		$customizer_additions->add_control(
			'some_checkout_page',
			array(
				'label'       => __( 'The Checkout Page', 'sidetrack-dev-tools' ),
				'type'        => 'dropdown-pages',
				'settings'    => 'some_checkout_page',
				'section'     => 'ss_dev_wp_controls_second',
				'description' => __(
					'Select your checkout page',
					'sidetrack-dev-tools'
				),
			)
		);

		$customizer_additions->add_setting(
			'ss_dev_wp_currency_code',
			array(
				'default'   => 'USD',
				'type'      => 'option',
				'transport' => 'refresh',
			)
		);
		$customizer_additions->add_control(
			'ss_dev_wp_currency_code',
			array(
				'label'       => __( 'SS dev Currency Code', 'sidetrack-dev-tools' ),
				'type'        => 'select',
				'choices'     => array(
					'AED' => __( 'United Arab Emirates Dirham', 'sidetrack-dev-tools' ),
					'ALL' => __( 'Albanian Lek', 'sidetrack-dev-tools' ),
				),
				'settings'    => 'ss_dev_wp_currency_code',
				'section'     => 'ss_dev_wp_controls_second',
				'description' => __(
					'Choose your currency code from the dropdown select.',
					'sidetrack-dev-tools'
				),
			)
		);

		$customizer_additions->add_setting(
			'toggle_on_ss_dev_wp_debug',
			array(
				'default'   => false,
				'type'      => 'option',
				'transport' => 'refresh',
			)
		);

		$customizer_additions->add_control(
			new Customizer_Toggle_Control(
				$customizer_additions,
				'toggle_on_ss_dev_wp_debug',
				array(
					'label'       => __( 'Turn on debug code', 'sidetrack-dev-tools' ),
					'description' => __(
						'The default setting is off. This option allows you to turn this code off, if need be.',
						'sidetrack-dev-tools'
					),
					'section'     => 'ss_dev_wp_controls_section',
					'settings'    => 'toggle_on_ss_dev_wp_debug',
					'type'        => 'ios',
					'priority'    => 41,
				)
			)
		);

	}
}
