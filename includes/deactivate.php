<?php
	
// default plugins
	
	
$default_plugins = Array(
		0 => array(
			'name' => 'woocommerce/woocommerce.php',
		) ,
		1 => array(
			'name' => 'bamboo/bamboo.php',
		),
		2 => array(
			'name' => 'wordpress-seo/wordpress-seo.php',
		) ,
);

// Page Logic

$deactiv_action = isset($_GET['action']) ? $_GET['action'] : '';


    if($deactiv_action == 'deactivate'){
        deactiv_de_plug();
    }
    
    elseif($deactiv_action == 'activate'){
		deactiv_newSaved();
    }
    


// Saved Plugins

function deactiv_saved_plugins() {

	$deactiv_saved_plugins = get_option('deactiv_saved_plugins');
	if ($deactiv_saved_plugins) :
		echo '<ul class="chk-container">';
		echo '<form>';
		echo '<input type="submit" value="Activate Selected Plugins" />';
		echo '<br /><br />';
		echo '<li><input type="checkbox" id="selecctall" checked="checked"/><strong>Selecct / De-select All</strong></li>';

			foreach($deactiv_saved_plugins as $plugin => $value) {
				echo '<li><input class="checkbox1" type="checkbox" name="plugins[]" value="' .$value. '" checked="checked">' . $value . "</li>";
			}


		echo '<input type="hidden" name="action" value="activate"><br>';
		echo '<input type="hidden" name="page" value="deactivate">';
		echo '</form>';
		echo '</ul>';
		else: echo '<strong>There are no saved plugins - Deactivate first</strong>';
		endif;

}


// Get Plugin Details

function deactiv_get_plugin_file(  ) {
	
	$n = 1;
    require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
    $plugins = get_plugins();
    foreach( $plugins as $plugin_file => $plugin_info ) {
        
        $base_name = plugin_basename( $plugin_file );
        
        if ( is_plugin_active( $base_name ) ) {
	        echo '<option name="exception' . $n .'" value="' . $base_name . '">';
	        echo $base_name;
			echo '</option>';
			$n++;
		}
    }
    return null;


}



// Activating Plugins


function deactiv_newSaved() {
	$deactiv_saved_plugins = get_option('deactiv_saved_plugins');
	$chosenPlugins = $_GET['plugins'];
	$filteredUpdate = array_diff($deactiv_saved_plugins, $chosenPlugins);
	
	echo '<div class="updated"><p>Plugins Activated</p>';      
		
		$n = 0;
		foreach($chosenPlugins as $plugin) {
			activate_plugin($plugin);
			$n++;
			echo $plugin . ' | ';
	    }
		echo '<br /><br /><strong>Total Activated: '. $n . '</strong>';
		$n = 0;
    echo '</div>';
   	update_option('deactiv_saved_plugins', $filteredUpdate);


   
   }


// Deactivating Plugins


function deactiv_de_plug() {

	$deactiv_saved_plugins = get_option('deactiv_saved_plugins');	
	$active_plugins = get_option('active_plugins');
	$exclude_file_main = array("bulk-deactivate/bulk-deactivate.php");	

	$exceptionselect = (isset($_GET['exceptionselect']) && $_GET['exceptionselect'] != '') ? $_GET['exceptionselect'] : array();	
	$exclude = array_merge($exclude_file_main,$exceptionselect);
	$filtered = array_diff($active_plugins, $exclude);

	add_option('deactiv_saved_plugins', $filtered);
	
	if ($_GET['save'] == 'nochanges') {
	
		echo 'Saved Plugins not updated';
		
		}
		
		elseif ($_GET['save'] == 'update') {
		
			$updateList = array_merge($filtered, $deactiv_saved_plugins);
			update_option('deactiv_saved_plugins', $updateList);

	
	} else {
		
		update_option('deactiv_saved_plugins', $filtered);
		
	
	}
	
	deactivate_plugins( $filtered );
	
	
	    echo '<div class="updated">
		      <p>Plugins Deactivated</p>';
	
					$n = 0;
				    foreach($filtered as $key => $value) {
				        //$string = explode('/',$value); // Folder name will be displayed
				        echo $value . ' | ';
				        $n++;
				    }
					echo '<br /><br /><strong>Total Deactivated: '. $n . '</strong>';				    
				    $n = 0;
				    
	  
			echo '</div>';

}

?>
<script>
	jQuery(function(){
       jQuery('.chosen-select').chosen();
       jQuery('.chosen-select-deselect').chosen({ allow_single_deselect: true }); 
});
</script>

<div class="bb_twocol my-form">
<h3>Deactivate Plugins</h3>

<p>Deactivated plugins are saved in a list below and can then be activated again. If you want some plugins to remain .</p>

<form class="exception-list">
	<input type="hidden" name="action" value="deactivate">
	
	<h4>Exceptions</h4>
	<p>Plugins selected here will not be deactivated.</p>
	<hr>

		<select class="chosen-select" name="exceptionselect[]" multiple="multiple">
			<?php deactiv_get_plugin_file(); ?>
		</select>
		
	<hr>

	<h4>Advanced List Settings</h4>
	<p>The below settings control if the plugin list is overwritten</p>	
	
	<div class="bb-plugins"><input type="radio" name="save" value="overwrite" checked="checked">Overwrite Plugins List<br></div>
	<div class="bb-plugins"><input type="radio" name="save" value="nochanges">Leave Plugins List<br></div>
	<div class="bb-plugins"><input type="radio" name="save" value="update">Update Saved Plugins List<br></div>
	
	<input type="hidden" name="page" value="deactivate">
	<br>
	<input type="submit" value="Deactivate Plugins" /> 
	<br>

</form>

<hr>
</div>
<div class="bb_twocol last">

<h3>Activate Saved Plugins</h3>
<p>Select plugins to be activated. Once activated they will be removed from the save list.</p>


<?php deactiv_saved_plugins(); ?>

</div>