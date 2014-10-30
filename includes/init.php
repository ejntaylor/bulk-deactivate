<?php
	
	// Add Menu Items
function deactiv_options_panel(){
  
  // add sub-menus
  add_submenu_page( 'plugins.php', 'Bulk Deactivate', 'Bulk Deactivate', 'manage_options', 'deactivate', 'deactiv_deactivate');


}

add_action('admin_menu', 'deactiv_options_panel');




function deactiv_deactivate(){
                echo '<div class="wrap"><div id="icon-options-general" class="icon32"><br></div>
                <h2>Bulk Deactivate</h2></div>';
				require_once('deactivate.php');

}



?>