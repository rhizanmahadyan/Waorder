<?php

add_action('init', 'waorder_slider');
function waorder_slider()
{
    if( waorder_lislis() !== 'active' ) return;
    register_post_type('slider', // Register Custom Post Type
        array(
        'labels' => array(
            'name'               => __('Slider', 'waorder'), // Rename these to suit
            'singular_name'      => __('Slider', 'waorder'),
            'add_new'            => __('Add New', 'waorder'),
            'add_new_item'       => __('Add New Slider', 'waorder'),
            'edit'               => __('Edit', 'waorder'),
            'edit_item'          => __('Edit Slider', 'waorder'),
            'new_item'           => __('New Slider', 'waorder'),
            'view'               => __('View Slider', 'waorder'),
            'view_item'          => __('View Slider', 'waorder'),
            'search_items'       => __('Search Slider', 'waorder'),
            'not_found'          => __('No Sliders found', 'waorder'),
            'not_found_in_trash' => __('No Sliders found in Trash', 'waorder')
        ),
        'public' => false,
        'show_ui' => true,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'hierarchical' => false,
        'has_archive' => false,
        'supports' => array(
            'title',
        ),
        'can_export' => true,
        'menu_icon' => 'dashicons-images-alt2',
    ));
}

/*
 * Add a meta box
 */
add_action( 'add_meta_boxes', 'waorder_slider_metabox', 10, 2 );
function waorder_slider_metabox( $post_type, $post ) {
    add_meta_box('waorder_slider_galery',
        'Upload Image',
        'waorder_slider_image_metabox_view',
        'slider',
        'normal',
        'default' );

    add_meta_box('waorder_slider_mp_link',
        'Publish',
        'waorder_slider_publish_metabox_view',
        'slider',
        'side',
        'low' );
}
function waorder_slider_publish_metabox_view($post){
    wp_nonce_field('noncenonce','waordernonce');
    ?>
    <div class="waorder">
        <div class="order-customer waorder-clearfix">
            <p>
                <label style="font-weight:bold">Setatus Order</label><br/>
                <select name="slider_status" style="width: 100%">
                    <option value="publish" <?php if($post->post_status == 'publish'){echo 'selected="selected"';} ?>>Publish</option>
                    <option value="draft" <?php if($post->post_status == 'draft'){echo 'selected="selected"';} ?>>Draft</option>
                </select>
            </p>
            <p>
                <button type="submit" style="width: 100%;" class="button button-primary button-hero">Simpan Perubahan</button>
            </p>
        </div>
    </div>
    <?php
}

function waorder_slider_image_metabox_view( $post ) {

    wp_nonce_field('noncenonce','waordernonce');

    $url = get_post_meta($post->ID, 'slider_image', true);
    wp_enqueue_media();
    ?>

    <div class="waorder">
        <p>
            Image atau Gambar harus berukuran 1080px X 400px
        </p>
        <p>
            <img style="width:100%;" class="slider_image_preview" src="<?php echo $url; ?>"/><br/><br/>
            <input type="hidden" class="slider_image" name="slider_image" value="<?php echo $url; ?>"/>
            <button type="button" onclick="waorderMediaOpen(this);" class="button" href="#" data-uploader-title="Add image" data-uploader-button-text="Add image" selector=".slider_image" preview=".slider_image_preview"><?php if($url){ echo 'Change Image';}else{echo 'Add image'; }?></button>
        </p>
        <p>
            <label>Slider Link</label>
            <input type="text" style="width:100%" name="slider_link" value="<?php echo get_post_meta($post->ID, 'slider_link', true); ?>" placeholder="https://www.waorder.id"/>
    </div>
<?php
}
/*
 * Save Meta Box data
 */
add_action('save_post', 'waorder_slider_metabox_save');
function waorder_slider_metabox_save( $post_id ) {

    global $wpdb;

    if ( !isset( $_POST['waordernonce'] ) ) {
        return $post_id;
    }

    if ( !wp_verify_nonce( $_POST['waordernonce'], 'noncenonce') ) {
        return $post_id;
    }

    if ( isset( $_POST[ 'slider_image' ] ) ) {
        update_post_meta( $post_id, 'slider_image', esc_url_raw($_POST['slider_image']) );
    }
    if ( isset( $_POST[ 'slider_link' ] ) ) {
        update_post_meta( $post_id, 'slider_link', esc_url_raw($_POST['slider_link']) );
    }

    if ( isset( $_POST[ 'slider_status' ] ) ) {

        $wpdb->update( $wpdb->posts, array( 'post_status' => sanitize_text_field($_POST[ 'slider_status' ]) ), array( 'ID' => $post_id ) );

        clean_post_cache( $post_id );

        $args = array(
            'post_type' => 'slider',
            'post_status' => 'publish',
            'fields' => 'ids',
        );

        $posts = get_posts($args);

        $urls = array();

        foreach( (array) $posts as $key=>$val ):
            $image_url = get_post_meta($val, 'slider_image', true);
            if( $image_url ):
                $urls[$val] = esc_url_raw($image_url);
            endif;
        endforeach;

        update_option('waorder_sliders', $urls);
    }


}

add_action( 'delete_post', 'waorder_on_delete_slider', 99 );
add_action( 'trashed_post', 'waorder_on_delete_slider', 99 );

function waorder_on_delete_slider( $pid ) {

    $args = array(
        'post_type' => 'slider',
        'post_status' => 'publish',
        'fields' => 'ids',
    );

    $posts = get_posts($args);

    $urls = array();

    foreach( (array) $posts as $key=>$val ):
        $image_url = get_post_meta($val, 'slider_image', true);
        if( $image_url ):
            $urls[$val] = esc_url_raw($image_url);
        endif;
    endforeach;

    update_option('waorder_sliders', $urls);
}

add_filter( 'manage_slider_posts_columns', 'waorder_slider_column' );
add_action( 'manage_slider_posts_custom_column' , 'waorder_slider_content_column', 10, 2 );

function waorder_slider_column($columns) {

    $new_columns['cb'] = '<input type="checkbox"/>';
    $new_columns['slider_image'] = __('Image', 'waorder');
    $new_columns['slider_title'] = __('Title', 'waorder');
    $new_columns['slider_status'] = __('Status', 'waorder');
    $new_columns['slider_action'] = __('&nbsp;', 'waorder');

    return $new_columns;
}

function waorder_slider_content_column( $column, $post_id ) {

    switch ( $column ) :

        case 'slider_image' :
            echo '<img style="width: 200px; height: auto;" src="'.get_post_meta($post_id, 'slider_image',  true).'"/>';
            break;

        case 'slider_title' :
            echo '<span>'.get_the_title($post_id).'</span> ';
            break;

        case 'slider_status' :
            $statuse = get_post_status($post_id);

            echo '<span>'.$statuse.'</span>';
            break;

        case 'slider_action' :
        echo '<div style="text-align:right">';
            echo '<a href="'.get_edit_post_link( $post_id ).'" class="button">Edit</a>&nbsp';
            echo '<a href="'.get_delete_post_link( $post_id ).'" class="button">Delete</a>';
            echo '</div>';
            break;

    endswitch;
}



add_action( 'admin_footer', 'waorder_slider_admin_footer' );
function waorder_slider_admin_footer(){
    $current_screen = get_current_screen();
    if( $current_screen->parent_file == 'edit.php?post_type=slider' ):
        ?>
        <script>
        jQuery('.slider_image .row-actions').hide();
        </script>
        <?php
    endif;
}


add_action( 'admin_menu', function () {
    remove_meta_box( 'submitdiv', 'slider', 'side' );
} );
