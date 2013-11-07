<?php

//Disallow direct access
if(!defined('WPSCAFF_DIRECTORY')) {
	die('Direct Access Not Allowed');
}

function WPSCAFF_Render_Options() {

    $wpscaff_options = get_option('WPSCAFF_options');
    $show_message = false;
    if($_POST['save-options']) {
        $show_message = true;
    }

	?>
    <?php if($show_message) { ?>
    <div id="message" class="updated">
        <p><?php _e('Options Saved Successfully', 'WPSCAFF'); ?></p>
    </div>
    <?php } ?>
    <form method="post" action="?page=<?php echo $_REQUEST['page'];?>&render=options">
        <?php
        if ( function_exists('wp_nonce_field') )  {
            wp_nonce_field('wpscaff_options');
        }
        ?>

        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <th scope="row">
                        <label for="enable_all"><?php _e('Post Type Prefix', 'WPSCAFF'); ?>:</label>
                    </th>
                    <td>
                        <input type="text" name="cpt_prefix" id="cpt_prefix" value="<?php echo $wpscaff_options['cpt_prefix']; ?>" />
                        <p class="description"><?php _e('Leave blank if you do not want to use a prefix', 'WPSCAFF'); ?></p>
                    </td>
                </tr>
            </tbody>
        </table>

        <br />

    <?php submit_button('Save Options', 'primary', 'save-options'); ?>
    </form>
    <?php

}