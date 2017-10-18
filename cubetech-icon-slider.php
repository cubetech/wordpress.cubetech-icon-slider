<?php
/**
 * Plugin Name: cubetech Icon Slider
 * Plugin URI: https://github.com/cubetech/wordpress.cubetech-icon-slider
 * Description: cubetech Icon Slider - simple icon/content slider with featured images
 * Version: 1.1
 * Author: cubetech GmbH
 * Author URI: http://www.cubetech.ch
 */

include_once('lib/cubetech-install.php');
include_once('lib/cubetech-metabox.php');
include_once('lib/cubetech-post-type.php');
include_once('lib/cubetech-settings.php');
include_once('lib/cubetech-shortcode.php');

add_image_size('cubetech-icon-slider-thumb', 231, 124, true);

wp_enqueue_script('jquery');
wp_register_script('cubetech_icon_slider_js', plugin_dir_url(__FILE__) . 'assets/js/cubetech-icon-slider.js', 'jquery');
wp_enqueue_script('cubetech_icon_slider_js');

add_action('wp_enqueue_scripts', 'cubetech_icon_slider_add_styles');

function cubetech_icon_slider_add_styles()
{
	wp_register_style('cubetech-icon-slider-css', plugin_dir_url(__FILE__) . 'assets/css/cubetech-icon-slider.css');
	wp_enqueue_style('cubetech-icon-slider-css');
}

/* Add button to TinyMCE */
function cubetech_icon_slider_addbuttons()
{

	if ((! current_user_can('edit_posts') && ! current_user_can('edit_pages'))) {
		return;
	}
	
	if (get_user_option('rich_editing') == 'true') {
		add_filter("mce_external_plugins", "add_cubetech_icon_slider_tinymce_plugin");
		add_filter('mce_buttons', 'register_cubetech_icon_slider_button');
		add_action('admin_footer', 'cubetech_icon_slider_dialog');
	}
}
 
function register_cubetech_icon_slider_button($buttons)
{
	array_push($buttons, "|", "cubetech_icon_slider_button");
	return $buttons;
}
 
function add_cubetech_icon_slider_tinymce_plugin($plugin_array)
{
	$plugin_array['cubetech_icon_slider'] = plugin_dir_url(__FILE__) . 'assets/js/cubetech-icon-slider-tinymce.js';
	return $plugin_array;
}

add_action('init', 'cubetech_icon_slider_addbuttons');

function cubetech_icon_slider_dialog()
{

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
			<p><input type="submit" class="button-primary" value="Icon Slider einfügen" onClick="tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[cubetech-icon-slider]'); tinyMCEPopup.close();" /></p>
		</div>
	</div>
	<?php
}

?>
