<?php

function register_taxonomy_%1$s() {

	$%1$s_args = array(
		'label' 				=> %3$s,
		'labels'				=> array(
				'singular_name' => %2$s
			),
		'public'				=> %4$s,
		'show_ui'				=> %5$s,
		'show_in_nav_menus'		=> %6$s,
		'show_admin_column'		=> %7$s,
		'hierarchical'			=> %8$s,
		'rewrite'				=> array(
				'slug'	=> %9$s
			),
		'query_var'				=> 'tax_%1$s'
	);

	register_taxonomy( '%1$s', null, $%1$s_args );
}
add_action('init', 'register_taxonomy_%1$s', 0);