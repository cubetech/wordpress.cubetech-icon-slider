<?php
function cubetech_icon_slider_shortcode($atts)
{
	extract(shortcode_atts(array(
		'group'			=> false,
		'hidecontent'	=> false,
		'orderby' 		=> 'menu_order',
		'order'			=> 'asc',
		'numberposts'	=> 999,
		'offset'		=> 0,
		'poststatus'	=> 'publish',
	), $atts));
	
	$taxargs = false;
	if($group != false && $group != 'all') {
		$taxargs = array(
		    array(
		        'taxonomy' => 'cubetech_icon_slider_group',
		        'terms' => $group,
		        'field' => 'id',
		    )
		);
	}
	
	$return = '';	

	$return .= '<div class="cubetech-icon-slider-container">';
	
	$args = array(
		'posts_per_page'  	=> 999,
		'numberposts'     	=> $numberposts,
		'offset'          	=> $offset,
		'orderby'         	=> $orderby,
		'order'           	=> $order,
		'post_type'       	=> 'cubetech_icon_slider',
		'post_status'     	=> $poststatus,
		'suppress_filters' 	=> false,
		'tax_query' 		=> $taxargs,
	);
		
	$posts = get_posts($args);
	
	$return .= cubetech_icon_slider_content($posts, $hidecontent);
	
	$return .= '<div class="cubetech-icon-slider-clear">';
	
	if ( get_option('cubetech_icon_slider_show_hr') != false )
		$return .= '<hr />';
	
	$return .= '</div></div>';
		
	return $return;

}

add_shortcode('cubetech-icon-slider', 'cubetech_icon_slider_shortcode');

function cubetech_icon_slider_content($posts, $hidecontent = false) {

	$contentreturn = '<ul class="cubetech-icon-slider">';
	$slidercontent = '<div class="cubetech-icon-slider-content">';
	
	$i = 0;
	
	foreach ($posts as $post) {
	
		$post_meta_data = get_post_custom($post->ID);
		$terms = wp_get_post_terms($post->ID, 'cubetech_icon_slider_group');
		$function = $post_meta_data['cubetech_icon_slider_function'][0];
		$edu = $post_meta_data['cubetech_icon_slider_edu'][0];
		$mail = $post_meta_data['cubetech_icon_slider_mail'][0];
		$phone = $post_meta_data['cubetech_icon_slider_phone'][0];
		
		$titlelink = array('', '');
		
		$title = '<h3 class="cubetech-icon-slider-title">' . $post->post_title . '</h3>';
		
		$image = get_the_post_thumbnail( $post->ID, 'cubetech-icon-slider-thumb', array('class' => 'cubetech-icon-slider-thumb cubetech-icon-slider-slide-' . $i ) );
		$secondimage = false;
		
		$link = '';

		if(isset($post_meta_data['cubetech_icon_slider_externallink'][0]) && $post_meta_data['cubetech_icon_slider_externallink'][0] != '')
			$link = '<span class="cubetech-icon-slider-link"><a href="' . $post_meta_data['cubetech_icon_slider_externallink'][0] . '" target="_blank">' . get_option('cubetech_icon_slider_link_title') . '</a></span>';
		elseif ( $post_meta_data['cubetech_icon_slider_links'][0] != '' && $post_meta_data['cubetech_icon_slider_links'][0] != 'nope' && $post_meta_data['cubetech_icon_slider_links'][0] > 0 )
			$link = '<span class="cubetech-icon-slider-link"><a href="' . get_permalink( $post_meta_data['cubetech_icon_slider_links'][0] ) . '">' . get_option('cubetech_icon_slider_link_title') . '</a></span>';

		$args = array(
		    'post_type' => 'attachment',
		    'numberposts' => null,
		    'post_status' => null,
		    'post_parent' => $post->ID,
		    'exclude' => get_post_thumbnail_id($post->ID),
		);
		$attachments = get_posts($args);
			
		if ( count($attachments) > 0 ) {
			foreach($attachments as $a) {
				$attachments = (Array)$a;
				break;
			}
			$secondimage .= wp_get_attachment_image($attachments['ID'], 'cubetech-icon-slider-thumb', false, array('class' => 'cubetech-icon-slider-thumb-second cubetech-icon-slider-slide-' . $i . '-second' ) );
		}

		$contentreturn .= '
		<li class="cubetech-icon-slider-icon cubetech-icon-slider-slide-' . $i . '">
			' . $image . '
			' . $secondimage . '
			<p>' . $post_meta_data['cubetech_icon_slider_imagetitle'][0] . '</p>
			<span class="cubetech-icon-slider-thumb-active-icon">&nbsp;</span>
		</li>';
		
		$slidercontent .= '
		<div class="cubetech-icon-slider-slide" id="cubetech-icon-slider-slide-' . $i . '">
			' . $title . '
			<p>' . __(nl2br($post->post_content)) . '</p>
			<p>' . $link . '</p>
		</div>';
		
		$i++;

	}
	
	if($hidecontent == 'true')
		$slidercontent = '';
	else
		$slidercontent = $slidercontent . '</div>';
	
	return $contentreturn . '</ul> ' . $slidercontent;
	
}
?>
