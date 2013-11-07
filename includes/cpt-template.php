<?php

function register_cpt_%1$s() {
	register_post_type( '%1$s',
		array(
			'labels' => array(
				'name' => __( '%3$s' ),
				'singular_name' => __( '%2$s' ),
				'plural_name' => __( '%3$s' )
			),
		'public' => true,
		'has_archive' => true,
		)
	);
}
add_action('init', 'register_cpt_%1$s');