<?php


/**
 * Plugin Name: Plugin Bulk Deactivate
 * Plugin URI: http://raison.co/
 * Description: Quickly deactivate and activate all your plugins
 * Author: raisonon
 * Author URI: http://www.raison.co/
 * Version: 0.2.1
 * License: GPLv2 or later
 * Text Domain: woocommerce-taxtog
 */
 
 
// set paths
   
define('DEACTIV_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));
define('DEACTIV_DIR', WP_PLUGIN_DIR . '/' . DEACTIV_NAME);
define('DEACTIV_URL', WP_PLUGIN_URL . '/' . DEACTIV_NAME);

// set version from plugin version

function deactiv_get_version() {
	if ( ! function_exists( 'get_plugins' ) )
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	$plugin_folder = get_plugins( '/' . plugin_basename( dirname( __FILE__ ) ) );
	$plugin_file = basename( ( __FILE__ ) );
	return $plugin_folder[$plugin_file]['Version'];
}

// set DEACTIV version

//define('DEACTIV_VERSION_KEY', 'DEACTIV_VERSION');
define('DEACTIV_VERSION_NUM', deactiv_get_version());
add_option('DEACTIV_VERSION_KEY', 'DEACTIV_VERSION_NUM');     




// Enqueue Scripts

 

function deactiv_stylesheet() {
		wp_register_style( 'DEACTIV-css', DEACTIV_URL . '/assets/css/deactiv.css', array(), DEACTIV_VERSION_NUM, 'all' );
		wp_enqueue_style( 'DEACTIV-css' );
	} // End woo_shortcode_stylesheet()


add_action( 'admin_enqueue_scripts', 'deactiv_stylesheet', 25 );


function register_deactiv_script() {
	wp_register_script('deactiv-js', DEACTIV_URL . '/assets/js/deactiv.js', array('jquery'), DEACTIV_VERSION_NUM, true);
}


function print_deactiv_head() {
	wp_print_scripts('deactiv-js');
}


/*
add_action('admin_init', 'register_DEACTIV_script');
add_action('admin_print_scripts', 'print_DEACTIV_head');
*/







// includes

include_once('includes/init.php');

 
 
 
 
 
 
 
 
 
 
 
?>