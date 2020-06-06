<?php

add_action('init', 'waorder_form'); // Add our Product Type
function waorder_form(){
    if( waorder_lislis() !== 'active' ) return;
    register_post_type('form', // Register Custom Post Type
        array(
        'labels' => array(
            'name'               => __('WA Form LP', 'waorder'), // Rename these to suit
            'singular_name'      => __('Form', 'waorder'),
            'add_new'            => __('Add New', 'waorder'),
            'add_new_item'       => __('Add New Form', 'waorder'),
            'edit'               => __('Edit', 'waorder'),
            'edit_item'          => __('Edit Form', 'waorder'),
            'new_item'           => __('New Form', 'waorder'),
            'view'               => __('View Form', 'waorder'),
            'view_item'          => __('View Form', 'waorder'),
            'search_items'       => __('Search Form', 'waorder'),
            'not_found'          => __('No Forms found', 'waorder'),
            'not_found_in_trash' => __('No Forms found in Trash', 'waorder')
        ),
        'public' => false,
        'show_ui' => true,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'hierarchical' => false,
        'has_archive' => false,
        'supports' => array(
            'title',
            'thumbnail',
        ),
        'can_export' => false,
        'menu_icon' => 'dashicons-list-view',
    ));
}

add_filter( 'manage_form_posts_columns', 'waorder_form_column' );
add_action( 'manage_form_posts_custom_column' , 'waorder_form_content_column', 10, 2 );

function waorder_form_column($columns) {

    $new_columns['cb'] = '<input type="checkbox"/>';
    $new_columns['form_name'] = __('Title', 'waorder');
    $new_columns['form_shortcode'] = __('Shortcode', 'waorder');
    $new_columns['form_action'] = __('&nbsp;', 'waorder');

    return $new_columns;
}

function waorder_form_content_column( $column, $post_id ) {

    switch ( $column ) :

        case 'form_name' :
            echo '<span style="font-weight: bold">'.get_the_title($post_id).'</span>';
            break;

        case 'form_shortcode' :
            echo '[waorder_form form_id="'.get_the_ID().'" show_price="true" show_quantity="true"]';
            break;

        case 'form_action' :
        echo '<div style="text-align:right">';
            echo '<a href="'.get_edit_post_link( $post_id ).'" class="button">Edit Form</a>&nbsp';
            echo '<a href="'.get_delete_post_link( $post_id ).'" class="button">Delete</a>';
            echo '</div>';
            break;

    endswitch;
}

add_action( 'admin_footer', 'waorder_form_admin_footer' );
function waorder_form_admin_footer(){
    $current_screen = get_current_screen();
    if( $current_screen->parent_file == 'edit.php?post_type=form' ):
        ?>
        <script>
        jQuery('.form_name .row-actions').hide();
        </script>
        <?php
    endif;
}


/*
 * Add a meta box
 */
add_action( 'add_meta_boxes', 'waorder_form_metabox', 0, 2 );
function waorder_form_metabox( $post_type, $post ) {

    add_meta_box(
        'waorder_form_details',
        'Product Detail',
        'waorder_form_detail_metabox_view',
        'form',
        'normal',
        'high'
    );
}

function waorder_form_detail_metabox_view($post){
    wp_nonce_field('noncenonce','waordernonce');

    ?>
    <div class="waorder">
        <div class="product-detail waorder-clearfix">
            <div class="tab">
                <button type="button" class="tablinks active" onclick="waorderOpenTab(event, 'pricing')" id="defaultOpen">Harga</button>
                <button type="button" class="tablinks" onclick="waorderOpenTab(event, 'delivery')">Pengiriman</button>
            </div>

            <div id="pricing" class="tabcontent" style="display: block">
                <div class="fieldbox">
                    <label style="font-weight:bold">Harga Jual</label><br/>
                    <input type="number" class="regular-text" value="<?php echo get_post_meta($post->ID, 'product_price', true); ?>" name="product_price" required><br/>
                    <span style="font-style: italic;font-size: 13px;">*Input dalam bilangan bulat, contoh 120000 untuk harga (seratus dua puluh ribu)</span>
                </div>
                <div class="fieldbox">
                    <label style="font-weight:bold">Harga Coret</label><br/>
                    <input type="number" class="regular-text" value="<?php echo get_post_meta($post->ID, 'product_price_slik', true); ?>" name="product_price_slik"><br/>
                    <span style="font-style: italic;font-size: 13px;">*Input dalam bilangan bulat, contoh 120000 untuk harga (seratus dua puluh ribu), kosongkan jika tidak ada harga coret</span>
                </div>
            </div>

            <div id="variable" class="tabcontent">
                <div class="fieldbox">
                    <label style="font-weight:bold">Warna</label>
                    <textarea style="width: 100%" name="product_color"><?php echo get_post_meta($post->ID, 'product_color', true); ?></textarea>
                    <span style="font-style: italic;font-size: 13px;">*Input warna dan pisahkan dengan koma, Contoh : Grey,Ungu,Merah dan seterusnya. Kosongkan jika tidak ada pilihan warna</span>
                </div>
                <div class="fieldbox">
                    <label style="font-weight:bold">Ukuran</label>
                    <textarea style="width: 100%" name="product_size"><?php echo get_post_meta($post->ID, 'product_size', true); ?></textarea>
                    <span style="font-style: italic;font-size: 13px;">*Input ukuran dan pisahkan dengan koma, Contoh : 39,40,42,45 atau S,M,XL dan seterusnya. Kosongkan jika tidak ada pilihan ukuran</span>
                </div>
                <div class="fieldbox">
                    <?php $custom_variable_fields =  get_post_meta($post->ID, 'product_custom_variable_value', true); ?>
                    <label style="font-weight:bold">Custom Variable</label>
                    <input type="text" style="width: 100%;margin-bottom: 20px;" name="product_custom_variable_label" value="<?php echo get_post_meta($post->ID, 'product_custom_variable_label', true); ?>" placeholder="Label Name"/>
                    <div id="customvariablebox" class="customvariable">
                        <?php if( isset($custom_variable_fields['chooser']) ): ?>
                            <?php foreach( (array) $custom_variable_fields['chooser'] as $key=>$val ): ?>
                                <?php $prices = $custom_variable_fields['price']; ?>
                                <div class="customvariablefieldbox">
                                    <div class="customvariableinput inpute">
                                        <label>Pilihan</label><br/>
                                        <input type="text" name="product_custom_variable_value[chooser][]" value="<?php echo $val; ?>"/>
                                    </div>
                                    <div class="customvariableinput inpute">
                                        <label>Harga Custom</label><br/>
                                        <input type="number" name="product_custom_variable_value[price][]" value="<?php echo $prices[$key]; ?>"/>
                                    </div>
                                    <div class="customvariableinput trash" onclick="waorderDynamicInputDelete(this);">
                                        <span class="dashicons dashicons-trash"></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <br/>
                    <button type="button" class="button" onclick="waorderDynamicInputAdd(this, 'customvariablebox');" data-fields="<div class='customvariableinput inpute'>
                            <label>Pilihan</label><br/>
                            <input type='text' name='product_custom_variable_value[chooser][]' value=''/>
                        </div>
                        <div class='customvariableinput inpute'>
                            <label>Tambahan Harga</label><br/>
                            <input type='number' name='product_custom_variable_value[price][]' value=''/>
                        </div>
                        <div class='customvariableinput trash' onclick='waorderDynamicInputDelete(this);''>
                            <span class='dashicons dashicons-trash'></span>
                        </div>">Tambah Pilihan</button>
                    <br/>
                    <br/>
                    <span style="font-style: italic;font-size: 13px;">*Pada kolom pilihan, input variable pilihan seperti misal untuk ukuran isi dengan S atau M dan seterusnya</span><br/>
                    <span style="font-style: italic;font-size: 13px;">*Pada kolom Tambahan Harga, input tambahan harga dalam bilangan bulat, seperti misal untuk pilihan ukuran M tambahan harganya 10000, maka saat customer memilih ukuran M harga otomatis akan bertambah 10.000; Kosongkan kolom tambahan Harga jika tidak ada penambahan Harga</span>
                </div>
            </div>

            <div id="stock" class="tabcontent">
                <div class="fieldbox">
                    <label style="font-weight:bold">Stock Habis ?</label><br/>
                    <input type="hidden" name="product_out_stock" value="no">
                    <input type="checkbox" name="product_out_stock" value="yes" <?php if(get_post_meta($post->ID, 'product_out_stock', true) == 'yes'){echo 'checked="checked"';}?>)>Ya<br/>
                    <span style="font-style: italic;font-size: 13px;">*Centang jika produk ini habis stok</span>
                </div>
            </div>

            <div id="delivery" class="tabcontent">
                <div class="fieldbox">
                    <label style="font-weight:bold">Berat Produk (satuan gram)</label><br/>
                    <?php
                    $weight = get_post_meta($post->ID, 'product_weight', true);
                    $weight = empty($weight) ? 1000 : intval($weight);
                    ?>
                    <input type="number" class="regular-text" value="<?php echo $weight; ?>" name="product_weight" required><br/>
                </div>
            </div>
        </div>
    </div>
    <?php
}

/*
 * Save Meta Box data
 */
add_action('save_post', 'waorder_form_metabox_save');
function waorder_form_metabox_save( $post_id ) {

    if ( !isset( $_POST['waordernonce'] ) ) {
        return $post_id;
    }

    if ( !wp_verify_nonce( $_POST['waordernonce'], 'noncenonce') ) {
        return $post_id;
    }

    if ( isset( $_POST[ 'product_price' ] ) ) {
        update_post_meta( $post_id, 'product_price', sanitize_text_field($_POST['product_price']) );
    }

    if ( isset( $_POST[ 'product_price_slik' ] ) ) {
        update_post_meta( $post_id, 'product_price_slik', sanitize_text_field($_POST['product_price_slik']) );
    }

    if ( isset( $_POST[ 'product_discount' ] ) ) {
        update_post_meta( $post_id, 'product_discount', sanitize_text_field($_POST['product_discount']) );
    }

    if ( isset( $_POST[ 'product_size' ] ) ) {
        update_post_meta( $post_id, 'product_size', sanitize_text_field($_POST['product_size']) );
    }

    if ( isset( $_POST[ 'product_color' ] ) ) {
        update_post_meta( $post_id, 'product_color', sanitize_text_field($_POST['product_color']) );
    }

    if ( isset( $_POST[ 'product_custom_variable_label' ] ) ) {
        update_post_meta( $post_id, 'product_custom_variable_label', sanitize_text_field($_POST['product_custom_variable_label']) );
    }

    if ( isset( $_POST[ 'product_custom_variable_value' ] ) ) {
        update_post_meta( $post_id, 'product_custom_variable_value', $_POST['product_custom_variable_value'] );
    }

    if ( isset( $_POST[ 'product_out_stock' ] ) ) {
        update_post_meta( $post_id, 'product_out_stock', sanitize_text_field($_POST['product_out_stock']) );
    }

    if ( isset( $_POST[ 'product_link_mp' ] ) ) {
        update_post_meta( $post_id, 'product_link_mp', $_POST['product_link_mp'] );
    }

    if ( isset( $_POST[ 'product_weight' ] ) ) {
        update_post_meta( $post_id, 'product_weight', intval($_POST['product_weight']) );
    }

}

add_shortcode('waorder_form', 'waorder_form_display');
function waorder_form_display($atts){
    $a = shortcode_atts( array(
		'form_id' => false,
        'show_price' => 'false',
        'show_quantity' => 'false',
	), $atts );

    if( $a['form_id'] ===  false ) return;

    ob_start();
    ?>
    <form class="orderBox center" method="post" enctype="multipart/form-data" id="productData">
        <?php
        $post_id = intval($a['form_id']);
        $thumb                  = wp_get_attachment_image_src(get_post_thumbnail_id($post_id));
        $is_out_stock           = get_post_meta($post_id, 'product_out_stock', true);
        $price                  = get_post_meta($post_id, 'product_price', true);
        $price_slik             = get_post_meta($post_id, 'product_price_slik', true);
        $size_data              = get_post_meta($post_id, 'product_size', true);
        $color_data             = get_post_meta($post_id, 'product_color', true);

        $custom_variable_label  = get_post_meta($post_id, 'product_custom_variable_label', true);
        $custom_variable_fields = get_post_meta($post_id, 'product_custom_variable_value', true);

        $product_link_mp        = get_post_meta($post_id, 'product_link_mp', true);
        $weight = get_post_meta($post_id, 'product_weight', true);
        $weight = empty($weight) ? 1000 : intval($weight);
        ?>
        <input type="hidden" name="order_key" value="<?php echo waorder_order_key_generator(); ?>"/>
        <input type="hidden" name="order_item_price" value="<?php echo $price; ?>"/>
        <input type="hidden" name="order_item_price_slik" value="<?php echo $price_slik; ?>"/>
        <input type="hidden" name="order_item_name" value="<?php echo get_the_title($post_id); ?>"/>
        <input type="hidden" name="order_item_id" value="<?php echo $post_id ?>">
        <input type="hidden" name="order_item_photo" value="<?php if( isset($thumb[0]) ){ echo $thumb[0];} ?>"/>
        <input type="hidden" name="order_item_weight" value="<?php echo $weight; ?>"/>
        <input type="hidden" name="order_form_lp" value="1"/>
        <input type="hidden" value="1" name="order_item_qty">

        <?php if( $a['show_price'] == 'truees' ): ?>
            <div class="pricing">
                <span class="price" id="price-view">Rp <?php echo number_format($price,0,',','.'); ?></span>
                <?php if($price_slik): ?>
                    <span class="price_slik"><del>Rp <?php echo number_format($price_slik,0,',','.'); ?></del></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if( $a['show_quantity'] == 'trueess' ): ?>
            <div class="variable">
                <p>Quantity</p>
                <div class="variable-qty clear">
                    <button type="button" class="minus" onclick="productOptionQty(this,'minus');">-</button>
                    <input min="1" type="number" value="1" name="order_item_qty">
                    <button type="button" class="plus" onclick="productOptionQty(this,'plus');">+</button>
                </div>
            </div>
        <?php endif;?>

        <div class="variable">
            <button type="button" class="order-button<?php if( $is_out_stock == 'yes' ){ echo ' outstock';}else{echo ' color-scheme-background';} ?>" style="float:none;width: 100%;" onclick="singleCartWA(this);">
                <i class="icon ion-logo-whatsapp"></i>
                Beli Sekarang
            </button>
        </div>
    </form>
    <?php
    $html = ob_get_contents();
    ob_end_clean();

    return $html;
}
