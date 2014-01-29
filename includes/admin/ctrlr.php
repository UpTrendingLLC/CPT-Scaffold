<?php

//Disallow direct access
if(!defined('WPSCAFF_DIRECTORY')) {
	die('Direct Access Not Allowed');
}

function WPSCAFF_Render_CTRLR() {

    $show_message = false;
    if(isset($_GET['message'])) {
        $show_message = true;
        switch($_GET['message'])
        {
            case 1:
                $message = '<p>' . __('Controller Created Succesfully', 'WPSCAFF') . '</p>';
                break;
            default:
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
    <form method="post" action="?page=<?php echo $_REQUEST['page'];?>&amp;render=ctrlr">
        <?php
        if ( function_exists('wp_nonce_field') )  {
            wp_nonce_field('wpscaff_new-ctrlr');
        }
        ?>
        <input type="hidden" name="new_type" value="ctrlr" />

        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <th scope="row">
                        <label for="ctrlr_type"><?php _e('Controller Type', 'WPSCAFF'); ?>:</label>
                    </th>
                    <td>
                        <select name="ctrlr_type" id="ctrlr_type">
                            <option value="pt">Post Type</option>
                            <option value="tax">Taxonomy</option>
                            <option value="slug">Post Slug</option>
                        </select>
                        <p class="description"><strong>Post Type:</strong> A built in or custom post type, optionally specify a post slug as well.</p>
                        <p class="description"><strong>Taxonomy:</strong> A built in or custom taxonomy, optionall specify a term slug as well.</p>
                        <p class="description"><strong>Post Slug:</strong> A page, post, or custom post, identified by its slug.</p>
                    </td>
                </tr>
                <tr valign="top" class="posttype_tr">
                    <th scope="row">
                        <label for="posttype"><?php _e('Post Type', 'WPSCAFF'); ?>:</label>
                    </th>
                    <td>
                        <select name="posttype" id="posttype">
                            <option value=""></option>
                        <?php
                            $args = array(
                                'public' => true
                            );
                            $post_types = get_post_types( $args, 'names' ); 

                            foreach ( $post_types  as $post_type )
                            {
                                echo '<option value="' . $post_type . '">' . $post_type . '</option>';
                            }
                        ?>
                        </select>
                        <p class="description">Select a post type for your new controller</p>
                    </td>
                </tr>
                <tr valign="top" class="slug_tr">
                    <th scope="row">
                        <label for="slug"><?php _e('Page Slug', 'WPSCAFF'); ?>:</label>
                    </th>
                    <td>
                        <input type="text" name="slug" id="slug" placeholder="eg. 'about-us'" autocomplete="off" />
                        <p class="description"><span class="optional">Optional: </span>Enter a page slug for your new controller</p>
                    </td>
                </tr>
                <tr valign="top" class="taxonomy_tr">
                    <th scope="row">
                        <label for="taxonomy"><?php _e('Taxonomy', 'WPSCAFF'); ?>:</label>
                    </th>
                    <td>
                        <select name="taxonomy" id="taxonomy">
                            <option value=""></option>
                        <?php
                            $args = array(
                                'public' => true
                            );
                            $taxonomies = get_taxonomies( $args, 'names' ); 

                            foreach ( $taxonomies  as $taxonomy )
                            {
                                echo '<option value="' . $taxonomy . '">' . $taxonomy . '</option>';
                            }
                        ?>
                        </select>
                        <p class="description">Select the taxonomy for your new controller</p>
                    </td>
                </tr>
                <tr valign="top" class="taxonomy_term_tr">
                    <th scope="row">
                        <label for="taxonomy_term"><?php _e('Taxonomy Term', 'WPSCAFF'); ?>:</label>
                    </th>
                    <td>
                        <select name="taxonomy_term" id="taxonomy_term">
                            <option value=""></option>
                        </select>
                        <p class="description">Optional: Select the taxonomy term your new controller</p>
                    </td>
                </tr>
            </tbody>
        </table>

        <br />

        <div id="files_to_create" class="ctrlr">
            <h4>The following file will be created:</h4>
            <p class="controller"><?php echo FABRIC_CONTROLLERS; ?><span></span></p>
        </div>

    <?php submit_button('Create Custom Controller', 'primary', false); ?>
    </form>
    <?php

}