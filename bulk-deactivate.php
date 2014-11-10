<?php


/**
 * Plugin Name: Plugin Bulk Deactivate
 * Plugin URI: http://raison.co/
 * Description: Quickly deactivate and activate all your plugins
 * Author: raisonon
 * Author URI: http://www.raison.co/
 * Version: 0.2.3
 * License: GPLv2 or later
 * Text Domain: deactiv
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




// includes

include_once('includes/init.php');

 
 
 
?>