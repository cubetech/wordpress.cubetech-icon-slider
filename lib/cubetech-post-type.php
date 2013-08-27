<?php

function cubetech_icon_slider_create_post_type() {
	register_post_type('cubetech_icon_slider',
		array(
			'labels' => array(
				'name' => __('Icon Slider'),
				'singular_name' => __('Inhalt'),
				'add_new' => __('Inhalt hinzufügen'),
				'add_new_item' => __('Neuer Inhalt hinzufügen'),
				'edit_item' => __('Inhalt bearbeiten'),
				'new_item' => __('Neuer Inhalt'),
				'view_item' => __('Inhalt betrachten'),
				'search_items' => __('Inhalt durchsuchen'),
				'not_found' => __('Keine Inhalte gefunden.'),
				'not_found_in_trash' => __('Keine Inhalte gefunden.')
			),
			'capability_type' => 'post',
			'public' => true,
			'has_archive' => false,
			'rewrite' => array('slug' => 'icon-slider', 'with_front' => false),
			'show_ui' => true,
			'menu_position' => '20',
			'menu_icon' => null,
			'hierarchical' => true,
			'supports' => array('title', 'editor', 'thumbnail')
		)
	);
	flush_rewrite_rules();
}

add_action('init', 'cubetech_icon_slider_create_post_type', 99);

?>
