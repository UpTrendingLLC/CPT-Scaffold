<?php

//Disallow direct access
if(!defined('WPSCAFF_DIRECTORY')) {
	die('Direct Access Not Allowed');
}

function WPSCAFF_process_new_cpt( $singular, $plural ) {

	$results = array();

	// Get prefix for CPT's
    $wpscaff_options = get_option('wpscaff_options');
    $prefix = $wpscaff_options['cpt_prefix'];

    $name = $prefix.$singular;

	// Sanitize CPT Name
	$name = strtolower($name); // No Capitals
	$name = str_replace(' ', '-', $name); // No Spaces
	$name = substr($name, 0, 20); // Max 20 Chars

	// Check for duplicate CPT name
	if( TRUE == WPSCAFF_check_duplicates( $name ) )
		return;

	// Build our CPT from template
	$custom_post_type = WPSCAFF_build_cpt( $name, $singular, $plural );

	// Write our CPT to the CPT directory
	$results[] = WPSCAFF_write_cpt( $name, $custom_post_type );

	// Create our controller and view
	$results[] = WPSCAFF_write_templates( $name );


	// Flush rules so that our new CPT pages work without resaving permalinks
	flush_rewrite_rules();

	return $result;

}

function WPSCAFF_check_duplicates( $name ) {

    $duplicate_check = post_type_exists( $name );

	return $duplicate_check;

}

function WPSCAFF_build_cpt( $name, $singular, $plural ) {

	$template = file_get_contents(WPSCAFF_DIRECTORY . '/includes/cpt-template.php');

	// Format template for our new CPT
	$formatted_cpt = sprintf( $template, $name, $singular, $plural );

	return $formatted_cpt;

}

function WPSCAFF_write_cpt( $name, $contents ) {

	file_put_contents(FABRIC_CPT_DIR . $name . '.php', $contents);

}

function WPSCAFF_write_templates( $name ) {

	file_put_contents(FABRIC_CONTROLLERS . $name . '.php', $contents);

	file_put_contents(FABRIC_VIEWS . 'single-' .$name . '.php', $contents);
	file_put_contents(FABRIC_VIEWS . 'archive-' .$name . '.php', $contents);

}

function WPSCAFF_new_listener() {

	if( !isset($_GET['page']) || $_GET['page'] != 'wp-scaffolding')
		return;

	if( !isset( $_POST['create-cpt'] ) )
		return;

    check_admin_referer('wpscaff_new-cpt');

	$single = $_POST['cpt_singular'];
	$plural = $_POST['cpt_plural'];

	WPSCAFF_process_new_cpt( $single, $plural );
}
add_action('admin_init', 'WPSCAFF_new_listener');


function WPSCAFF_save_options() {

	if( !isset( $_POST['save-options'] ) )
		return;

    check_admin_referer('wpscaff_options');

    unset($_POST['save-options']);
    unset($_POST['_wpnonce']);
    unset($_POST['_wp_http_referer']);

    $wpscaff_options = get_option('wpscaff_options');

    foreach($_POST as $key => $option)
    {
        $wpscaff_options[$key] = $option;
    }
    
    update_option('wpscaff_options', $wpscaff_options);

    return $wpscaff_options;

}
add_action('load-appearance_page_wp-scaffolding', 'WPSCAFF_save_options');
