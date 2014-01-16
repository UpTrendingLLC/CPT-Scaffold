<?php

//Disallow direct access
if(!defined('WPSCAFF_DIRECTORY')) {
    die('Direct Access Not Allowed');
}

function WPSCAFF_listener() {

	if( !isset( $_POST['new_type'] ) )
		return;

    if( 'cpt' == $_POST['new_type'] )
        WPSCAFF_setup_new_cpt( $_POST );

    if( 'tax' == $_POST['new_type'] )
        WPSCAFF_setup_new_tax( $_POST );

}
add_action('load-tools_page_wp-scaffolding', 'WPSCAFF_listener');

function WPSCAFF_setup_new_cpt( $post_values ) {

    check_admin_referer('wpscaff_new-cpt');

    // Set initial value of all CPT args to false
    $singular = $plural = $public = $exclude_from_search = $show_ui = $show_in_nav_menus = $has_archive = $supports = $taxonomies = 'false';

    // Import variables from $post_values (only if they are already set above)
    extract( $post_values, EXTR_IF_EXISTS );

    // Convert taxonimies and supports into strings
    $supports = ( 'false' != $supports ) ? "'" . implode( "', '", (array) $supports ) . "'" : '';
    $taxonomies = ( 'false' != $taxonomies ) ? "'" . implode( "', '", (array) $taxonomies ) . "'" : '';

    $result = WPSCAFF_process_new_cpt( $singular, $plural, $public, $exclude_from_search, $show_ui, $show_in_nav_menus, $has_archive, $supports, $taxonomies );

    wp_redirect( admin_url( '/tools.php?page=wp-scaffolding&return=cpt&flush=' . $result ) ); exit;
}

function WPSCAFF_setup_new_tax( $post_values ) {

    check_admin_referer('wpscaff_new-tax');

    // Set initial value of all CPT args to false
    $singular = $plural = $public = $show_ui = $show_in_nav_menus = $show_admin_column = $hierarchical = 'false';

    // Import variables from $post_values (only if they are already set above)
    extract( $post_values, EXTR_IF_EXISTS );

    $result = WPSCAFF_process_new_tax( $singular, $plural, $public, $show_ui, $show_in_nav_menus, $show_admin_column, $hierarchical );

    wp_redirect( admin_url( '/tools.php?page=wp-scaffolding&return=tax&flush=' . $result ) ); exit;
}

function WPSCAFF_process_new_cpt( $singular, $plural, $public, $exclude_from_search, $show_ui, $show_in_nav_menus, $has_archive, $supports, $taxonomies ) {

    // Sanatize strings for CPT name and Rewrite Slug
    $name = WPSCAFF_sanatize_string( $singular, 20 );
    $rewrite_slug = WPSCAFF_sanatize_string( $plural );

    // Check for duplicate CPT name
    if( true == WPSCAFF_check_duplicates( 'cpt', $name ) )
        return;

    // Make strings translatable in generated file, but not here
    $singular = WPSCAFF_make_string_translatable( $singular );
    $plural = WPSCAFF_make_string_translatable( $plural );
    $rewrite_slug = WPSCAFF_make_string_translatable( $rewrite_slug );

    // Build our CPT from template
    $custom_post_type = WPSCAFF_build_template( 'cpt-template', array( $name, $singular, $plural, $public, $exclude_from_search, $show_ui, $show_in_nav_menus, $has_archive, $supports, $taxonomies, $rewrite_slug ), false );

    // Build our Controller from template
    $controller = WPSCAFF_build_template( 'controller-template', array( ucfirst($name), $singular, $plural ), false );

    // Build our Views from template
    $single = WPSCAFF_build_template( 'single-template', array( $name, $singular, $plural ), false );

    if( 'true' == $has_archive ) {
        $archive = WPSCAFF_build_template( 'archive-template', array( $name, $singular, $plural ), false );
    } else {
        $archive = false;
    }

    // Write CPT, Controller, and Views to disk
    $result = WPSCAFF_write_files( $name, array( 'cpt' => $custom_post_type, 'cpt_controller' => $controller, 'cpt_single' => $single, 'cpt_archive' => $archive ) );

    return $result;
}

function WPSCAFF_process_new_tax( $singular, $plural, $public, $show_ui, $show_in_nav_menus, $show_admin_column, $hierarchical ) {

    // Sanatize strings for tax name and Rewrite Slug
    $name = WPSCAFF_sanatize_string( $singular, 20 );
    $rewrite_slug = WPSCAFF_sanatize_string( $plural );

    // Check for duplicate tax name
    if( true == WPSCAFF_check_duplicates( 'tax', $name ) )
        return;

    // Make strings translatable in generated file, but not here
    $singular = WPSCAFF_make_string_translatable( $singular );
    $plural = WPSCAFF_make_string_translatable( $plural );
    $rewrite_slug = WPSCAFF_make_string_translatable( $rewrite_slug );

    // Build our tax from template
    $taxonomy = WPSCAFF_build_template( 'tax-template', false, array( $name, $singular, $plural, $public, $show_ui, $show_in_nav_menus, $show_admin_column, $hierarchical, $rewrite_slug ) );

    // Write tax to disk
    $result = WPSCAFF_write_files( $name, array( 'tax' => $taxonomy ) );

    return $result;
}

function WPSCAFF_flush_permalinks() {

    if( !isset( $_GET['flush'] ) || !isset( $_GET['return'] ) )
        return;

    $return = $_GET['return'];

    global $wp_rewrite;
    flush_rewrite_rules();

    wp_redirect( admin_url( '/tools.php?page=wp-scaffolding&render='.$return.'&message=1' ) ); exit;
}
add_action( 'load-tools_page_wp-scaffolding', 'WPSCAFF_flush_permalinks' );

