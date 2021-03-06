<?php
function cubetech_icon_slider_shortcode($atts)
{
	extract(shortcode_atts(array(
		'orderby' 		=> 'menu_order',
		'order'			=> 'asc',
		'numberposts'	=> 999,
		'offset'		=> 0,
		'poststatus'	=> 'publish',
	), $atts));
	
	$return = '';

	$return .= '<div class="cubetech-icon-slider-container">';
	
	if (get_option('cubetech_icon_slider_show_groups') != false) {
		$return .= '<h2>' . $tax->name . '</h2>';
	}
	
	$args = array(
		'posts_per_page'  	=> 999,
		'numberposts'     	=> $numberposts,
		'offset'          	=> $offset,
		'orderby'         	=> $orderby,
		'order'           	=> $order,
		'post_type'       	=> 'cubetech_icon_slider',
		'post_status'     	=> $poststatus,
		'suppress_filters' 	=> true,
	);
		
	$posts = get_posts($args);
	
	$return .= cubetech_icon_slider_content($posts);
	
	$return .= '<div class="cubetech-icon-slider-clear">';
	
	if (get_option('cubetech_icon_slider_show_hr') != false) {
		$return .= '<hr />';
	}
	
	$return .= '</div></div>';
		
	return $return;
}

add_shortcode('cubetech-icon-slider', 'cubetech_icon_slider_shortcode');

function cubetech_icon_slider_content($posts)
{

	$contentreturn = '<ul class="cubetech-icon-slider">';
	$slidercontent = '<div class="cubetech-icon-slider-content">';
	
	$iterator = 0;
	
	foreach ($posts as $post) {
		$post_meta_data = get_post_custom($post->ID);
		
		$title = '<h3 class="cubetech-icon-slider-title">' . $post->post_title . '</h3>';
		
		$image = get_the_post_thumbnail($post->ID, 'cubetech-icon-slider-thumb', array('class' => 'cubetech-icon-slider-thumb cubetech-icon-slider-slide-' . $iterator ));
		$secondimage = false;
		
		$link = '';

		if (isset($post_meta_data['cubetech_icon_slider_externallink'][0]) && $post_meta_data['cubetech_icon_slider_externallink'][0] != '') {
			$link = '<span class="cubetech-icon-slider-link"><a href="' . $post_meta_data['cubetech_icon_slider_externallink'][0] . '" target="_blank">' . get_option('cubetech_icon_slider_link_title') . '</a></span>';
		} elseif ($post_meta_data['cubetech_icon_slider_links'][0] != '' && $post_meta_data['cubetech_icon_slider_links'][0] != 'nope' && $post_meta_data['cubetech_icon_slider_links'][0] > 0) {
			$link = '<span class="cubetech-icon-slider-link"><a href="' . get_permalink($post_meta_data['cubetech_icon_slider_links'][0]) . '">' . get_option('cubetech_icon_slider_link_title') . '</a></span>';
		}

		$args = array(
			'post_type' => 'attachment',
			'numberposts' => null,
			'post_status' => null,
			'post_parent' => $post->ID,
			'exclude' => get_post_thumbnail_id($post->ID),
		);
		$attachments = get_posts($args);
			
		if (count($attachments) > 0) {
			foreach ($attachments as $a) {
				$attachments = (Array)$a;
				break;
			}
			$secondimage .= wp_get_attachment_image($attachments['ID'], 'cubetech-icon-slider-thumb', false, array('class' => 'cubetech-icon-slider-thumb-second cubetech-icon-slider-slide-' . $iterator . '-second' ));
		}
		
		$ebooklink = '<a id="ebookbutton" target="__blank" href="/assets/spitalloesung/">Broschüre dynamicMED</a>';
		
		
		
		$contentreturn .= '
		<li class="cubetech-icon-slider-icon cubetech-icon-slider-slide-' . $iterator . '">
			' . $image . '
			' . $secondimage . '
			<p>' . $post_meta_data['cubetech_icon_slider_imagetitle'][0] . '</p>
			<span class="cubetech-icon-slider-thumb-active-icon">&nbsp;</span>
		</li>';
		
		if ($post->ID == 395) :
			$slidercontent .= '
		<div class="cubetech-icon-slider-slide" id="cubetech-icon-slider-slide-' . $iterator . '">
			' . $title . '
			<p>' . $post->post_content . '</p>
			<p>' . $link . $ebooklink . '</p>
		</div>';
		else :
			$slidercontent .= '
		<div class="cubetech-icon-slider-slide" id="cubetech-icon-slider-slide-' . $iterator . '">
			' . $title . '
			<p>' . $post->post_content . '</p>
			<p>' . $link . '</p>
		</div>';
		endif;
		
		
		
		$iterator++;
	}
	
	
	return $contentreturn . '<li class="cubetech-icon-slider-empty">&nbsp;</li><hr /></ul> ' . $slidercontent . '</div>';
}
