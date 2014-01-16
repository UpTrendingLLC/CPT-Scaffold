<?php

function register_cpt_%1$s() {

	$%1$s_args = array(
		'label' 				=> %3$s,
		'labels'				=> array(
				'singular_name' => %2$s
			),
		'public'				=> %4$s,
		'exclude_from_search'	=> %5$s,
		'show_ui'				=> %6$s,
		'show_in_nav_menus'		=> %7$s,
		'has_archive'			=> %8$s,
		'supports'				=> array(%9$s),
		'taxonomies'			=> array(%10$s),
		'rewrite'				=> array(
				'slug'	=> %11$s
			),
		'query_var'				=> 'cpt_%1$s'
	);

	register_post_type( '%1$s', $%1$s_args );
}
add_action('init', 'register_cpt_%1$s');