<?php

use \Elementor\Plugin as Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

final class Sakib_Extension {

	const VERSION = '1.0.0';
	const MINIMUM_ELEMENTOR_VERSION = '2.6.0';
	const MINIMUM_PHP_VERSION = '5.6';


	private static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}


	public function __construct() {

		add_action( 'init', [ $this, 'i18n' ] );
		add_action( 'plugins_loaded', [ $this, 'init' ] );

	}

	public function i18n() {
		load_plugin_textdomain( 'sakib' );
	}



	public function init() {
		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}
		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		//add_action( 'elementor/editor/after_enqueue_styles', array ( $this, 'pawelements_editor_styles' ) );
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
		add_action( 'elementor/elements/categories_registered',[$this,'register_new_category']);
		add_action( 'wp_enqueue_scripts', array( $this, 'sakib_register_frontend_styles' ), 10 );
		add_action( 'elementor/frontend/after_register_scripts', [$this, 'widget_scripts'] );
		add_action( 'elementor/frontend/before_register_scripts', [ $this, 'sakib_register_frontend_scripts' ] );

	}

	/**
	 * Load Frontend Script
	 *
	*/
	public function sakib_register_frontend_scripts(){
		wp_enqueue_style(
			'sakib-addons-style',
			SAKIB_ASSETS_PUBLIC .'/css/widget-style.css',
			null,SAKIB_VERSION,
		);

	}

	function widget_scripts(){
		wp_enqueue_script(
			'sakib-main-js',
			SAKIB_ASSETS_PUBLIC .'/js/main.js',
			['jquery'], SAKIB_VERSION, true
		);
	}


	/**
	 * Load Frontend Styles
	 *
	*/
	public function sakib_register_frontend_styles(){
        wp_enqueue_style( 'themify-icons',
             SAKIB_ASSETS_PUBLIC . '/vendor/themify-icons/themify-icons.css',
              null, SAKIB_VERSION
        );

	}

	/**
	 * Widgets Catgory
	 *
	*/
	public function register_new_category($manager){
	   $manager->add_category('sakib',
			[
				'title' => __( 'Sakib Elementor Helper  Addons', 'sakib' ),
			]);
	}

	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'sakib' ),
			'<strong>' . esc_html__( 'Elementor Pawelements Extension', 'sakib' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'sakib' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'sakib' ),
			'<strong>' . esc_html__( 'Elementor sakib Extension', 'sakib' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'sakib' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'sakib' ),
			'<strong>' . esc_html__( 'Elementor Sakib Extension', 'sakib' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'sakib' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	public function init_widgets() {

		$widgets_manager = \Elementor\Plugin::instance()->widgets_manager;


		//Include Widget files
		require_once( SAKIB_WIDGET_DIR . 'Button/widget.php' );


		require_once( SAKIB_WIDGET_DIR . 'woo-category-tab.php' );
	}
}
Sakib_Extension::instance();
