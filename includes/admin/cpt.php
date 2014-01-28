<?php

//Disallow direct access
if(!defined('WPSCAFF_DIRECTORY')) {
	die('Direct Access Not Allowed');
}

function WPSCAFF_Render_CPT() {

    $show_message = false;
    if(isset($_GET['message'])) {
        $show_message = true;
        switch($_GET['message'])
        {
            case 1:
                $message = '<p>' . __('CPT Created Succesfully', 'WPSCAFF') . '</p>';
                break;
            case 2:
                $message = '<p>' . __('There was a Problem!', 'WPSCAFF') . '</p>';
                break;
        }
    }

	?>
    <?php if($show_message) { ?>
    <div id="message" class="updated">
        <?php echo $message; ?>
    </div>
    <?php } ?>
    <form method="post" action="?page=<?php echo $_REQUEST['page'];?>&amp;render=cpt">
        <?php
        if ( function_exists('wp_nonce_field') )  {
            wp_nonce_field('wpscaff_new-cpt');
        }
        ?>
        <input type="hidden" name="new_type" value="cpt" />

        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <th scope="row">
                        <label for="singular"><?php _e('Singular Name', 'WPSCAFF'); ?>:</label>
                    </th>
                    <td>
                        <input type="text" name="singular" id="singular" placeholder="eg. 'Product'" autocomplete="off" />
                        <p class="description">Please use TitleCase, no spaces, no underscores!</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="plural"><?php _e('Plural Name', 'WPSCAFF'); ?>:</label>
                    </th>
                    <td>
                        <input type="text" name="plural" id="plural" placeholder="eg. 'Products'" autocomplete="off" />
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
                            <p class="description">Whether a post type is intended to be used publicly either via the admin interface or by front-end users.</p>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row">
                            <label for="exclude_from_search"><?php _e('Exclude from Search', 'WPSCAFF'); ?>:</label>
                        </th>
                        <td>
                            <input type="checkbox" value="true" name="exclude_from_search" id="exclude_from_search" />
                            <p class="description">Whether to exclude posts with this post type from front end search results.</p>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row">
                            <label for="show_ui"><?php _e('Show UI', 'WPSCAFF'); ?>:</label>
                        </th>
                        <td>
                            <input type="checkbox" value="true" name="show_ui" id="show_ui" checked="checked" />
                            <p class="description">Whether to generate a default UI for managing this post type in the admin.</p>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row">
                            <label for="show_in_nav_menus"><?php _e('Show In Nav Menus', 'WPSCAFF'); ?>:</label>
                        </th>
                        <td>
                            <input type="checkbox" value="true" name="show_in_nav_menus" id="show_in_nav_menus" checked="checked" />
                            <p class="description">Whether post_type is available for selection in navigation menus.</p>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row">
                            <label for="has_archive"><?php _e('Has Archive', 'WPSCAFF'); ?>:</label>
                        </th>
                        <td>
                            <input type="checkbox" value="true" name="has_archive" id="has_archive" checked="checked" />
                            <p class="description">Enables post type archives and creates archive-{$post-type}.php</p>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row">
                            <label for="supports"><?php _e('Supports', 'WPSCAFF'); ?>:</label>
                        </th>
                        <td>
                            <select multiple name="supports[]" id="supports">
                                <option value="title" selected="selected">title</option>
                                <option value="editor" selected="selected">editor</option>
                                <option value="author">author</option>
                                <option value="thumbnail">thumbnail</option>
                                <option value="excerpt">excerpt</option>
                                <option value="trackbacks">trackbacks</option>
                                <option value="custom-fields'">custom-fields'</option>
                                <option value="comments">comments</option>
                                <option value="revisions">revisions</option>
                                <option value="page-attributes">page-attributes</option>
                                <option value="post-formats">post-formats</option>
                            </select>
                            <p class="description">Which meta boxes are available for input.</p>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row">
                            <label for="taxonomies"><?php _e('Taxonomies', 'WPSCAFF'); ?>:</label>
                        </th>
                        <td>
                            <select multiple name="taxonomies[]" id="taxonomies">
                            <?php
                            foreach ( WPSCAFF_get_taxonomies() as $taxonomy )
                            {
                                ?>
                                <option value="<?php echo $taxonomy; ?>"><?php echo $taxonomy; ?></option>
                                <?php
                            }
                            ?>
                            </select>
                            <p class="description">Registered taxonomies that will be used with this post type.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <br />

        <div id="files_to_create" class="cpt">
            <h4>The following files will be created:</h4>
            <p class="posttype"><?php echo FABRIC_CPT_DIR; ?><span></span></p>
            <p class="controller"><?php echo FABRIC_CONTROLLERS; ?><span></span></p>
            <p class="single-view"><?php echo FABRIC_VIEWS; ?><span></span></p>
            <p class="archive-view"><?php echo FABRIC_VIEWS; ?><span></span></p>
        </div>

    <?php submit_button('Create Post Type', 'primary', false); ?>
    </form>
    <?php

}