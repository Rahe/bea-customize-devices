<?php

class BEA_Customize_Devices_Main {


	/**
	 * @var BEA_Customize_Devices_Main
	 */
	private static $instance;

	/**
	 * The sizes to use for the portrait
	 *
	 * @var array
	 */
	private static $sizes = array(
		array(
			'title' => 'Desktop',
			'icon' => 'dashicons-desktop',
			'class' => 'default active',
			'size' => '100%'
		),
		array(
			'title' => 'Tablet landscape mode',
			'icon' => 'dashicons-tablet',
			'class' => 'landscape-tablet rotate-right',
			'size' => '1024px'
		),
		array(
			'title' => 'Tablet portrait mode',
			'icon' => 'dashicons-tablet',
			'class' => 'portrait-tablet',
			'size' => '768px'
		),
		array(
			'title' => 'Smartphone landscape mode',
			'icon' => 'dashicons-smartphone',
			'class' => 'landscape-smartphone rotate-left',
			'size' => '480px'
		),
		array(
			'title' => 'Smartphone portrait mode',
			'icon' => 'dashicons-smartphone',
			'class' => 'portrait-smartphone',
			'size' => '320px'
		),
	);

	/**
	 * @access private
	 */
	private function __construct() {
		self::$instance = $this;

		add_action( 'customize_controls_print_footer_scripts', array( __CLASS__, 'js_template' ), 1 );
		add_action( 'customize_controls_print_footer_scripts', array( __CLASS__, 'enqueue_scripts' ), 2 );
	}

	/**
	 * @return BEA_Customize_Devices_Main
	 * @author Nicolas Juen
	 */
	public static function get_instance( ) {
		if( is_null( self::$instance ) ) {
			self::$instance = new BEA_Customize_Devices_Main();
		}

		return self::$instance;
	}

	/**
	 * Return the sizes filtered
	 *
	 * @return mixed|void
	 * @author Nicolas Juen
	 */
	private static function get_sizes() {
		return apply_filters( 'bea_customize_devices_sizes', self::$sizes );
	}

	/**
	 * Enqueue and localize the script
	 *
	 * @author Nicolas Juen
	 */
	public static function enqueue_scripts() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG === true ? '' : '.min' ;

		wp_enqueue_style( 'bea-customize-devices-admin', BEA_CUSTOM_DEVICES_URL . '/assets/css/admin'.$suffix.'.css' );

		wp_enqueue_script(
			'bea-customize-devices-admin',			//Give the script an ID
			BEA_CUSTOM_DEVICES_URL . '/assets/js/admin'.$suffix.'.js',//Point to file
			array( 'jquery', 'underscore', 'backbone' ),	//Define dependencies
			BEA_CUSTOM_DEVICES_VERSION, //Define a version (optional)
			true //Put script in footer?
		);

		wp_localize_script( 'bea-customize-devices-admin', 'bea_customize_devices', array( 'sizes' => self::get_sizes() ) );

	}

	/**
	 * Javascript templates
	 *
	 * @author Nicolas Juen
	 */
	public static function js_template() {
		include( BEA_CUSTOM_DEVICES_DIR.'views/js-templates.tpl' );
	}
}