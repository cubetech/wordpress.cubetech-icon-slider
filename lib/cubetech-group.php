<?php
function cubetech_icon_slider_create_taxonomy() {

	$labels = array(
		'name'                => __( 'Slidergruppen', 'cubetech-icon-slider'),
		'singular_name'       => __( 'Slidergruppe', 'cubetech-icon-slider' ),
		'search_items'        => __( 'Gruppen durchsuchen', 'cubetech-icon-slider' ),
		'all_items'           => __( 'Alle Slidergruppen', 'cubetech-icon-slider' ),
		'edit_item'           => __( 'Slidergruppe bearbeiten', 'cubetech-icon-slider' ), 
		'update_item'         => __( 'Slidergruppe aktualisiseren', 'cubetech-icon-slider' ),
		'add_new_item'        => __( 'Neue Slidergruppe hinzufügen', 'cubetech-icon-slider' ),
		'new_item_name'       => __( 'Gruppenname', 'cubetech-icon-slider' ),
		'menu_name'           => __( 'Slidergruppe', 'cubetech-icon-slider' )
	);

	$args = array(
		'hierarchical'        => true,
		'labels'              => $labels,
		'show_ui'             => true,
		'show_admin_column'   => true,
		'query_var'           => true,
		'rewrite'             => array( 'slug' => 'cubetech_icon_slider' ),
		'sortable'			  => true,
		'sort'				  => true,
	);

	register_taxonomy( 'cubetech_icon_slider_group', array( 'cubetech_icon_slider' ), $args );
	flush_rewrite_rules();
}

add_action('init', 'cubetech_icon_slider_create_taxonomy');

?>