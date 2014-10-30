<?php
	
	
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

    if($_GET['action'] == 'deactivate'){
        de_plug();
    }elseif($_GET['action'] == 'activate'){
		newSaved();
    }


// Saved Plugins

function savedPlugins() {

	$savedPlugins = get_option('savedPlugins');
	if ($savedPlugins) :
		echo '<ul class="chk-container">';
		echo '<form>';
		echo '<input type="submit" value="Activate Selected Plugins" />';
		echo '<br /><br />';
		echo '<li><input type="checkbox" id="selecctall" checked="checked"/><strong>Selecct / De-select All</strong></li>';

			foreach($savedPlugins as $plugin => $value) {
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

function get_plugin_file(  ) {
	
	$n = 1;
    require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
    $plugins = get_plugins();
    foreach( $plugins as $plugin_file => $plugin_info ) {
        
        $base_name = plugin_basename( $plugin_file );
        echo '<option name="exception' . $n .'" value="' . $base_name . '">';
        echo $base_name;
		echo '</option>';
		$n++;
    }
    return null;


}



// Activating Plugins


function newSaved() {
	$savedPlugins = get_option('savedPlugins');
	$chosenPlugins = $_GET['plugins'];
	$filteredUpdate = array_diff($savedPlugins, $chosenPlugins);
	
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
   	update_option('savedPlugins', $filteredUpdate);


   
   }


// Deactivating Plugins


function de_plug() {

	$savedPlugins = get_option('savedPlugins');	
	$active_plugins = get_option('active_plugins');
	$exclude_file_main = "plugin-deactivate/plugin-deactivate.php";	

	$exclude_file_1 = $_GET['exception1'];
	$exclude_file_2 = $_GET['exception2'];
	$exclude_file_3 = $_GET['exception3'];
	$exclude_file_4 = $_GET['exception4'];
	$exclude_file_5 = $_GET['exception5'];
	$exclude_file_6 = $_GET['exception6'];
	$exclude_file_7 = $_GET['exception7'];
	
	
	
	
	
	$exclude = array($exclude_file_main,$exclude_file_1, $exclude_file_2, $exclude_file_3, $exclude_file_4, $exclude_file_5,$exclude_file_6,$exclude_file_7,$exclude_file_8,$exclude_file_9);
	
	
	
	
	$exceptionselect=$_GET['exceptionselect'];
	var_dump($exceptionselect);
	
	
	
	$filtered = array_diff($active_plugins, $exceptionselect);

	add_option('savedPlugins', $filtered);
	
	if ($_GET['save'] == 'nochanges') {
	
		echo 'Saved Plugins not updated';
		
		}
		
		elseif ($_GET['save'] == 'update') {
		
			$updateList = array_merge($filtered, $savedPlugins);
			update_option('savedPlugins', $updateList);

	
	} else {
		
		update_option('savedPlugins', $filtered);
		
	
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

<script type="text/javascript">

// http://jesin.tk/dynamic-textbox-jquery-php/

jQuery(document).ready(function($){
    $('.my-form .add-box').click(function(){
        var n = $('.text-box').length + 1;
        if( 20 < n ) {
            alert('Limited to 20 Plugins - Come on you don\'t need that many!');
            return false;
        }
        var box_html = $('<p class="text-box">\n\
			<label for="box' + n + '"><span class="box-number">' + n + '.</span></label>\n\
			<input type="text" name="bamboo_setting[req_plugins_arr][multiarray][' + n + '][name]" value="" id="box' + n + '" />\n\
			<a href="#" class="remove-box">Remove</a></p>');
        box_html.hide();
        $('.my-form p.text-box:last').after(box_html);
        box_html.fadeIn('slow');
        return false;
    });
    $('.my-form').on('click', '.remove-box', function(){
        $(this).parent().css( 'background-color', '#FF6C6C' );
        $(this).parent().fadeOut("slow", function() {
            $(this).remove();
            $('.box-number').each(function(index){
                $(this).text( index + 1 );
            });
        });
        return false;
    });

    $('.my-form .domain-add-box').click(function(){
        var n = $('.domain-text-box').length + 1;
        if( 20 < n ) {
            alert('Limited to 20 Plugins - Come on you don\'t need that many!');
            return false;
        }

        var box_html = $('<p class="domain-text-box">\n\
			<label for="box1">Domain Name <span class="domain-box-number">' + n + '</span></label>\n\
			<input type="text" name="bamboo_setting[allowed_domains_arr][multiarray][]" value="" id="domain-box' + n + '" />\n\
			<a href="#" class="remove-box">Remove</a></p>');
        box_html.hide();
        $('.my-form p.domain-text-box:last').after(box_html);
        box_html.fadeIn('slow');
        return false;
    });


});
</script>

<div class="bb_twocol my-form">
<h3>Deactivate Plugins</h3>

<p>Deactivated plugins are saved in a list below and can then be activated again. If you want some plugins to remain .</p>

<form>
	<input type="hidden" name="action" value="deactivate">
	
	<h4>Exceptions</h4>
	<p>Any plugins added here will not be deactivated</p>
	<!--
	<input type="text" name="exception2" value="bamboo/bamboo.php"><br>
	<input type="text" name="exception3" value="" placeholder="plugin-slug/plugin-name.php"><br>
	<input type="text" name="exception4" value="" placeholder="add your plugins here"><br>
	-->
	<hr>

<!--
<?php	

	if (!empty($default_plugins)) {
	$i = 1;
	foreach ($default_plugins as $key => $values) :
		?>

		<p class="text-box">
			<label for="box<?php echo $key+1; ?>"><span class="box-number"><?php echo $key+1; ?>.</span>
			<input type="text" name="exception<?php echo $i; ?>" value="<?php echo $values['name']; ?>" id="box<?php echo $key+1; ?>" />
			</label>

			<?php echo ( 0 == $key ? '' : '<a href="#" class="remove-box">Remove</a>' ); ?>
		</p>
		<?php
		 $i++;
	endforeach;
	echo '<p><a href="#" class="add-box">Add More</a></p>';
} else {

	global $BambooPlugin;

    ?>
        <p class="text-box">
            <label for="box1">Name <span class="box-number">1</span></label>
            <input type="text" name="<?php echo $default_plugins; ?>[0][name]" value="" id="box1" />

        </p>
	<p><a href="#" class="add-box">Add More</a></p>
<?php
    }



?>	
-->

<hr>

<h5>Beta</h5>


<select name="exceptionselect[]" multiple="multiple">
	<?php get_plugin_file(); ?>
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


<?php savedPlugins(); ?>

</div>