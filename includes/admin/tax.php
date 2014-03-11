<?php

//Disallow direct access
if(!defined('WPSCAFF_DIRECTORY')) {
	die('Direct Access Not Allowed');
}

function WPSCAFF_Render_TAX() {

    $show_message = false;
    if(isset($_GET['message'])) {
        $show_message = true;
        switch($_GET['message'])
        {
            case 1:
                $message = '<p>' . __('Taxonomy Created Succesfully', 'WPSCAFF') . '</p>';
                break;
            default:
                $message = '<p>' . __('There was a Problem!', 'WPSCAFF') . '</p>';
                break;
        }
    }

	?>

    <div class="wrap">

        <h3><?php _e('New Taxonomy', 'WPSCAFF'); ?></h3>

        <?php if($show_message) { ?>
        <div id="message" class="updated">
            <?php echo $message; ?>
        </div>
        <?php } ?>
        <form method="post" action="?page=<?php echo $_REQUEST['page'];?>&amp;render=tax">
            <?php
            if ( function_exists('wp_nonce_field') )  {
                wp_nonce_field('wpscaff_new-tax');
            }
            ?>
            <input type="hidden" name="new_type" value="tax" />

            <table class="form-table">
                <tbody>
                    <tr valign="top">
                        <th scope="row">
                            <label for="singular"><?php _e('Singular Name', 'WPSCAFF'); ?>:</label>
                        </th>
                        <td>
                            <input type="text" name="singular" id="singular" placeholder="eg. 'Genre'" autocomplete="off" />
                            <p class="description">Please use TitleCase, no spaces, no underscores!</p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="plural"><?php _e('Plural Name', 'WPSCAFF'); ?>:</label>
                        </th>
                        <td>
                            <input type="text" name="plural" id="plural" placeholder="eg. 'Genres'" autocomplete="off" />
                            <p class="description">Please use TitleCase, no spaces, no underscores!</p>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div id="expanded_options">
                <a id="expanded_options_toggle">Arguments <i class="dashicons dashicons-arrow-right"></i></a>
                <table class="form-table">
                    <tbody>
                        <tr valign="top">
                            <th scope="row">
                                <label for="public"><?php _e('Public', 'WPSCAFF'); ?>:</label>
                            </th>
                            <td>
                                <input type="checkbox" value="true" name="public" id="public" checked="checked" />
                                <p class="description">Should this taxonomy be exposed in the admin UI.</p>
                            </td>
                        </tr>

                        <tr valign="top">
                            <th scope="row">
                                <label for="show_ui"><?php _e('Show UI', 'WPSCAFF'); ?>:</label>
                            </th>
                            <td>
                                <input type="checkbox" value="true" name="show_ui" id="show_ui" checked="checked" />
                                <p class="description">Whether to generate a default UI for managing this taxonomy in the admin.</p>
                            </td>
                        </tr>

                        <tr valign="top">
                            <th scope="row">
                                <label for="show_in_nav_menus"><?php _e('Show In Nav Menus', 'WPSCAFF'); ?>:</label>
                            </th>
                            <td>
                                <input type="checkbox" value="true" name="show_in_nav_menus" id="show_in_nav_menus" checked="checked" />
                                <p class="description">Whether this taxonomy is available for selection in navigation menus.</p>
                            </td>
                        </tr>

                        <tr valign="top">
                            <th scope="row">
                                <label for="show_admin_column"><?php _e('Show Admin Column', 'WPSCAFF'); ?>:</label>
                            </th>
                            <td>
                                <input type="checkbox" value="true" name="show_admin_column" id="show_admin_column" checked="checked" />
                                <p class="description">Whether to allow automatic creation of taxonomy columns on associated post-types.</p>
                            </td>
                        </tr>

                        <tr valign="top">
                            <th scope="row">
                                <label for="hierarchical"><?php _e('Hierarchical', 'WPSCAFF'); ?>:</label>
                            </th>
                            <td>
                                <input type="checkbox" value="true" name="hierarchical" id="hierarchical" checked="checked" />
                                <p class="description">Is this taxonomy hierarchical (have descendants) like categories or not hierarchical like tags.</p>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <br />

            <div id="files_to_create" class="tax">
                <h4>The following file will be created:</h4>
                <p class="taxonomy"><?php echo FABRIC_TAX_DIR; ?><span></span></p>
            </div>

        <?php submit_button('Create Taxonomy', 'primary', false); ?>
        </form>
    </div>
    <?php

}