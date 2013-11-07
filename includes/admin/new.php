<?php

//Disallow direct access
if(!defined('WPSCAFF_DIRECTORY')) {
	die('Direct Access Not Allowed');
}

function WPSCAFF_Render_New() {

    $show_message = false;
    if($_POST['create-cpt']) {
        $show_message = true;
    }

	?>
    <?php if($show_message) { ?>
    <div id="message" class="updated">
        <p><?php _e('CPT Created Succesfully', 'WPSCAFF'); ?></p>
    </div>
    <?php } ?>
    <form method="post" action="?page=<?php echo $_REQUEST['page'];?>&render=new">
        <?php
        if ( function_exists('wp_nonce_field') )  {
            wp_nonce_field('wpscaff_new-cpt');
        }
        ?>

        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <th scope="row">
                        <label for="cpt_singular"><?php _e('Singular Name', 'WPSCAFF'); ?>:</label>
                    </th>
                    <td>
                        <input type="text" name="cpt_singular" id="cpt_singular" placeholder="eg. Octopus" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="cpt_plural"><?php _e('Plural Name', 'WPSCAFF'); ?>:</label>
                    </th>
                    <td>
                        <input type="text" name="cpt_plural" id="cpt_plural" placeholder="eg. Octopi" />
                    </td>
                </tr>
            </tbody>
        </table>

        <br />

    <?php submit_button('Create CPT', 'primary', 'create-cpt'); ?>
    </form>
    <?php

}