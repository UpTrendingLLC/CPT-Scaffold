<?php

//Disallow direct access
if(!defined('WPSCAFF_DIRECTORY')) {
	die('Direct Access Not Allowed');
}


/*************************** REGISTER THE ADMIN PAGE ****************************
 ********************************************************************************/

function WPSCAFF_Admin_Options_Menu() {
    global $WPSCAFF_management_page;
    $WPSCAFF_management_page = add_theme_page( 'WP Scaffolding', 'WP Scaffolding', 'edit_pages', 'wp-scaffolding', 'WPSCAFF_render_admin_page' );
}
add_action( 'admin_menu', 'WPSCAFF_Admin_Options_Menu', 10 );

function WPSCAFF_render_admin_page() {

    $admin_page = (isset($_GET['render'])) ? $_GET['render'] : 'new';
    ?>
    <div id="icon-users" class="icon32"><br/></div>
    <h2>CPT Scaffolding</h2>
    <h3 class="nav-tab-wrapper">
        <a href="?page=<?php echo $_REQUEST['page'];?>&render=new" class="nav-tab <?php if($admin_page == 'new'){echo 'nav-tab-active';} ?>"><?php _e('New CPT', 'WPSCAFF'); ?></a>
        <a href="?page=<?php echo $_REQUEST['page'];?>&render=options" class="nav-tab <?php if($admin_page == 'options'){echo 'nav-tab-active';} ?>"><?php _e('Options', 'WPSCAFF'); ?></a>
    </h3>

    <?php
    switch($admin_page)
    {
        case 'new':
            require_once(WPSCAFF_DIRECTORY . '/includes/admin/new.php');
            WPSCAFF_Render_New();
            break;
        case 'options':
            require_once(WPSCAFF_DIRECTORY . '/includes/admin/options.php');
            WPSCAFF_Render_Options();
            break;
    }

}
?>
