<?php
/**
 * Plugin Name: cubetech Icon Slider
 * Plugin URI: http://www.cubetech.ch
 * Description: cubetech Icon Slider - simple icon/content slider with featured images
 * Version: 1.0
 * Author: cubetech GmbH
 * Author URI: http://www.cubetech.ch
 */

include_once('lib/cubetech-install.php');
include_once('lib/cubetech-group.php');
include_once('lib/cubetech-metabox.php');
include_once('lib/cubetech-post-type.php');
include_once('lib/cubetech-settings.php');
include_once('lib/cubetech-shortcode.php');

add_image_size( 'cubetech-icon-slider-thumb', 203, 203, true );

wp_enqueue_script('jquery');
wp_register_script('cubetech_icon_slider_js', plugins_url('assets/js/cubetech-icon-slider.js', __FILE__), 'jquery');
//wp_enqueue_script('cubetech_icon_slider_js');

add_action('wp_enqueue_scripts', 'cubetech_icon_slider_add_styles');

function cubetech_icon_slider_add_styles() {
	wp_register_style('cubetech-icon-slider-css', plugins_url('assets/css/cubetech-icon-slider.css', __FILE__) );
	wp_enqueue_style('cubetech-icon-slider-css');
}

/* Add button to TinyMCE */
function cubetech_icon_slider_addbuttons() {

	if ( (! current_user_can('edit_posts') && ! current_user_can('edit_pages')) )
		return;
	
	if ( get_user_option('rich_editing') == 'true') {
		add_filter("mce_external_plugins", "add_cubetech_icon_slider_tinymce_plugin");
		add_filter('mce_buttons', 'register_cubetech_icon_slider_button');
		add_action( 'admin_footer', 'cubetech_icon_slider_dialog' );
	}
}
 
function register_cubetech_icon_slider_button($buttons) {
   array_push($buttons, "|", "cubetech_icon_slider_button");
   return $buttons;
}
 
function add_cubetech_icon_slider_tinymce_plugin($plugin_array) {
	$plugin_array['cubetech_icon_slider'] = plugins_url('assets/js/cubetech-icon-slider-tinymce.js', __FILE__);
	return $plugin_array;
}

add_action('init', 'cubetech_icon_slider_addbuttons');

function cubetech_icon_slider_dialog() { 

	$args=array(
		'hide_empty' => false,
		'orderby' => 'name',
		'order' => 'ASC'
	);
	$taxonomies = get_terms('cubetech_icon_slider_group', $args);

	?>
	<style type="text/css">
		#cubetech_icon_slider_dialog { padding: 10px 30px 15px; }
	</style>
	<div style="display:none;" id="cubetech_icon_slider_dialog">
		<div>
			<p>Wählen Sie bitte die einzufügende Slider-Gruppe:</p>
			<p><select name="taxonomy" id="cubetech_icon_slider_taxonomy">
				<option value="">Bitte Gruppe auswählen</option>
				<option value="all">Alle anzeigen</option>
				<?php
				foreach($taxonomies as $tax) :
					echo '<option value="' . $tax->term_id . '">' . $tax->name . '</option>';
				endforeach;
				?>
			</select></p>
			<p><input type="checkbox" name="content" id="cubetech_icon_slider_hide_content" value="true"> Content verbergen</p>
		</div>
		<div>
			<p><input type="submit" class="button-primary" value="Icon Slider einfügen" onClick="if ( jQuery('#cubetech_icon_slider_taxonomy')[0].selectedOptions[0].value != '') { tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[cubetech-icon-slider group=' + jQuery('#cubetech_icon_slider_taxonomy')[0].selectedOptions[0].value + ' hidecontent=' + jQuery('#cubetech_icon_slider_hide_content').prop('checked') + ']'); tinyMCEPopup.close(); }" /></p>
		</div>
	</div>
	<?php
}

?>
