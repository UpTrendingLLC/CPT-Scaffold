<?php

//Disallow direct access
if(!defined('WPSCAFF_DIRECTORY')) {
	die('Direct Access Not Allowed');
}

function WPSCAFF_Render_Error() {

    $fabric         = isset( $_GET['fabric'] )      ? $_GET['fabric']       : false;
    $views          = isset( $_GET['views'] )       ? $_GET['views']        : false;
    $posttypes      = isset( $_GET['posttypes'] )   ? $_GET['posttypes']    : false;
    $taxonomy       = isset( $_GET['taxonomy'] )    ? $_GET['taxonomy']     : false;
    $controllers    = isset( $_GET['controllers'] ) ? $_GET['controllers']  : false;

	?>
    
    <?php if( $fabric ) { ?>
    <div class="error">
        <p>It appears that Fabric is not active, or is missing functionality required for WP Scaffolding to run.</p>
    </div>
    <?php } ?>

    <?php if( $views ) { ?>
    <div class="error">
        <?php if( 1 == $views ) { ?>
        <p>It appears that the views directory does not exist. Expected path: <?php echo FABRIC_VIEWS; ?></p>
        <?php } else { ?>
        <p>It appears that the views directory is not writable. File permissions: <?php echo fileperms(FABRIC_CPT_DIR); ?></p>
        <?php } ?>
    </div>
    <?php } ?>

    <?php if( $posttypes ) { ?>
    <div class="error">
        <?php if( 1 == $posttypes ) { ?>
        <p>It appears that the custom post types directory does not exist. Expected path: <?php echo FABRIC_CPT_DIR; ?></p>
        <?php } else { ?>
        <p>It appears that the custom post types directory is not writable. File permissions: <?php echo fileperms(FABRIC_CPT_DIR); ?></p>
        <?php } ?>
    </div>
    <?php } ?>

    <?php if( $taxonomy ) { ?>
    <div class="error">
        <?php if( 1 == $taxonomy ) { ?>
        <p>It appears that the custom taxonomies directory does not exist. Expected path: <?php echo FABRIC_TAX_DIR; ?></p>
        <?php } else { ?>
        <p>It appears that the custom taxonomies directory is not writable. File permissions: <?php echo fileperms(FABRIC_TAX_DIR); ?></p>
        <?php } ?>
    </div>
    <?php } ?>

    <?php if( $controllers ) { ?>
    <div class="error">
        <?php if( 1 == $controllers ) { ?>
        <p>It appears that the controllers directory does not exist. Expected path: <?php echo FABRIC_CONTROLLERS; ?></p>
        <?php } else { ?>
        <p>It appears that the controllers directory is not writable. File permissions: <?php echo fileperms(FABRIC_CONTROLLERS); ?></p>
        <?php } ?>
    </div>
    <?php } ?>
    
    <?php
}