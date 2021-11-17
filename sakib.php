<?php
/*
Plugin Name: Sakib For Elementor
Plugin URI: https://github.com/masumskaib396/sakib-for-elementor
Description: The Sakib is an Elementor helping plugin that will make your designing work easier.
Our specialities are custom CSS, Nested section, Creative Buttons.
Version: 1.0.0
Author: sakib
Author URI: https://profiles.wordpress.org/sakib
License: GPLv2 or later
Text Domain: sakib-addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//Set plugin version constant.
define( 'SAKIB_VERSION', '1.0.0');

/* Set constant path to the plugin directory. */
define( 'SAKIB_WIDGET', trailingslashit( plugin_dir_path( __FILE__ ) ) );
// Plugin Function Folder Path
define( 'SAKIB_WIDGET_INC', plugin_dir_path( __FILE__ ) . 'inc/' );

// Plugin Extensions Folder Path
define( 'SAKIB_WIDGET_EXTENSIONS', plugin_dir_path( __FILE__ ) . 'extensions/' );

// Plugin Widget Folder Path
define( 'SAKIB_WIDGET_DIR', plugin_dir_path( __FILE__ ) . 'widgets/' );

// Assets Folder URL
define( 'SAKIB_ASSETS_PUBLIC', plugins_url( 'assets', __FILE__ ) );

// Assets Folder URL
define( 'SAKIB_ASSETS_VERDOR', plugins_url( 'assets/vendor', __FILE__ ) );


require_once( SAKIB_WIDGET_INC . 'helper-function.php');
require_once( SAKIB_WIDGET . 'base.php' );

?>
