<?php




add_action( 'admin_menu', 'deactiv_options_panel' ); // hook so we can add menus to our admin left-hand menu

/**
 * Create the administration menus in the left-hand nav and load the JavaScript conditionally only on that page
 */
function deactiv_options_panel(){
	$deactiv_page = add_submenu_page( 'plugins.php', 'Bulk Deactivate', 'Bulk Deactivate', 'manage_options', 'deactivate', 'deactiv_deactivate');

	// Load the JS conditionally
	add_action( 'load-' . $deactiv_page, 'deactiv_load_admin' );


}

// This function is only called when our plugin's page loads!
function deactiv_load_admin(){
	// Unfortunately we can't just enqueue our scripts here - it's too early. So register against the proper action hook to do it
	add_action( 'admin_enqueue_scripts', 'deactiv_enqueue_admin_js' );
	add_action( 'admin_enqueue_scripts', 'deactiv_enqueue_admin_css' );

}

function deactiv_enqueue_admin_js(){
	wp_enqueue_script( 'jquery' );
	// wp_enqueue_script( 'jquery-ui-tabs' );


	wp_enqueue_script( 'chosen', plugins_url('/libs/chosen/chosen.jquery.min.js', dirname(__FILE__)), array( 'jquery', 'jquery' ) );
}


function deactiv_enqueue_admin_css(){

	wp_register_style( 'deactiv', plugins_url('/assets/css/deactiv.css', dirname(__FILE__)), false, '1.0.0' );
	wp_register_style( 'chosencss', plugins_url('/libs/chosen/chosen.css', dirname(__FILE__)), false, '1.0.0' );
	wp_enqueue_style( 'deactiv' );
	wp_enqueue_style( 'chosencss' );

}








function deactiv_deactivate(){
	echo '<div class="wrap"><div id="icon-options-general" class="icon32"><br></div>
                <h2>Bulk Deactivate</h2></div>';
	require_once('deactivate.php');

}





?>