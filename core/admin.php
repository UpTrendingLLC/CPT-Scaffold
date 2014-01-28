<?php

//Disallow direct access
if(!defined('WPSCAFF_DIRECTORY')) {
	die('Direct Access Not Allowed');
}

/*************************** REGISTER THE ADMIN PAGE ****************************
 ********************************************************************************/

function WPSCAFF_Admin_Options_Menu() {
    global $WPSCAFF_management_page;
    $WPSCAFF_management_page = add_management_page( 'WP Scaffolding', 'WP Scaffolding', 'edit_pages', 'wp-scaffolding', 'WPSCAFF_render_admin_page' );
}
add_action( 'admin_menu', 'WPSCAFF_Admin_Options_Menu', 10 );

function WPSCAFF_render_admin_page() {

    $admin_page = (isset($_GET['render'])) ? $_GET['render'] : 'cpt';
    ?>
    <div id="icon-users" class="icon32"><br/></div>
    <h2>WP Scaffolding</h2>
    <h3 class="nav-tab-wrapper">
        <a href="?page=<?php echo $_REQUEST['page'];?>&render=cpt" class="nav-tab <?php if($admin_page == 'cpt'){echo 'nav-tab-active';} ?>"><?php _e('New Post Type', 'WPSCAFF'); ?></a>
        <a href="?page=<?php echo $_REQUEST['page'];?>&render=tax" class="nav-tab <?php if($admin_page == 'tax'){echo 'nav-tab-active';} ?>"><?php _e('New Taxonomy', 'WPSCAFF'); ?></a>
        <a href="?page=<?php echo $_REQUEST['page'];?>&render=ctrlr" class="nav-tab <?php if($admin_page == 'ctrlr'){echo 'nav-tab-active';} ?>"><?php _e('New Custom Controller', 'WPSCAFF'); ?></a>
    </h3>

    <?php
    switch($admin_page)
    {
        case 'cpt':
            require_once(WPSCAFF_DIRECTORY . '/includes/admin/cpt.php');
            WPSCAFF_Render_CPT();
            break;

        case 'tax':
            require_once(WPSCAFF_DIRECTORY . '/includes/admin/tax.php');
            WPSCAFF_Render_TAX();
            break;

        case 'ctrlr':
            require_once(WPSCAFF_DIRECTORY . '/includes/admin/ctrlr.php');
            WPSCAFF_Render_CTRLR();
            break;

        case 'error':
            require_once(WPSCAFF_DIRECTORY . '/includes/admin/error.php');
            WPSCAFF_Render_Error();
            break;
    }

}

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
add_action('load-tools_page_wp-scaffolding', 'WPSCAFF_save_options');

function WPSCAFF_scripts( $hook ) {

    if( 'tools_page_wp-scaffolding' != $hook )
        return;

    wp_enqueue_script( 'scaffolding-js', WPSCAFF_PUBLIC_PATH . 'includes/assets/wp_scaffolding.js' );
    wp_enqueue_style( 'scaffolding-css', WPSCAFF_PUBLIC_PATH . 'includes/assets/wp_scaffolding.css' );
}
add_action( 'admin_enqueue_scripts', 'WPSCAFF_scripts' );

function WPSCAFF_get_taxonomies() {
    return get_taxonomies( array(), 'names' );
}

