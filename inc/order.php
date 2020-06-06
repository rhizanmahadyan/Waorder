<?php

add_action('init', 'waorder_order'); // Add our Order Type
function waorder_order()
{
    if( waorder_lislis() !== 'active' ) return;
    register_post_type('order', // Register Custom Post Type
        array(
        'labels' => array(
            'name'               => __('Order', 'waorder'), // Rename these to suit
            'singular_name'      => __('Order', 'waorder'),
            'add_new'            => __('Add New', 'waorder'),
            'add_new_item'       => __('Add New Order', 'waorder'),
            'edit'               => __('Edit', 'waorder'),
            'edit_item'          => __('Edit Order', 'waorder'),
            'new_item'           => __('New Order', 'waorder'),
            'view'               => __('View Order', 'waorder'),
            'view_item'          => __('View Order', 'waorder'),
            'search_items'       => __('Search Order', 'waorder'),
            'not_found'          => __('No Orders found', 'waorder'),
            'not_found_in_trash' => __('No Orders found in Trash', 'waorder')
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
        'can_export' => false,
        'capability_type' => 'post',
        'capabilities' => array(
            //'create_posts' => false,
        ),
        'menu_icon' => 'dashicons-cart',
    ));

    register_post_status( 'new_order', array(
		'label'                     => _x( 'New Order', 'post status label', 'waorder' ),
		'public'                    => true,
		'label_count'               => _n_noop( 'New Order <span class="count">(%s)</span>', 'New Order <span class="count">(%s)</span>', 'plugin-domain' ),
		'post_type'                 => array( 'order' ), // Define one or more post types the status can be applied to.
		'show_in_admin_all_list'    => true,
		'show_in_admin_status_list' => true,
		'show_in_metabox_dropdown'  => true,
		'show_in_inline_dropdown'   => true,
		'dashicon'                  => 'dashicons-yes',
	) );

	register_post_status( 'on_hold', array(
		'label'                     => _x( 'On Hold', 'post status label', 'waorder' ),
		'public'                    => true,
		'label_count'               => _n_noop( 'On Hold <span class="count">(%s)</span>', 'On Hold <span class="count">(%s)</span>', 'plugin-domain' ),
		'post_type'                 => array( 'order' ), // Define one or more post types the status can be applied to.
		'show_in_admin_all_list'    => true,
		'show_in_admin_status_list' => true,
		'show_in_metabox_dropdown'  => true,
		'show_in_inline_dropdown'   => true,
		'dashicon'                  => 'dashicons-dismiss',
	) );

    register_post_status( 'on_shipping', array(
		'label'                     => _x( 'On Shipping', 'post status label', 'waorder' ),
		'public'                    => true,
		'label_count'               => _n_noop( 'On Shipping <span class="count">(%s)</span>', 'On Shipping <span class="count">(%s)</span>', 'plugin-domain' ),
		'post_type'                 => array( 'order' ), // Define one or more post types the status can be applied to.
		'show_in_admin_all_list'    => true,
		'show_in_admin_status_list' => true,
		'show_in_metabox_dropdown'  => true,
		'show_in_inline_dropdown'   => true,
		'dashicon'                  => 'dashicons-dismiss',
	) );

	register_post_status( 'completed', array(
		'label'                     => _x( 'Completed', 'post status label', 'waorder' ),
		'public'                    => true,
		'label_count'               => _n_noop( 'Completed <span class="count">(%s)</span>', 'Completed <span class="count">(%s)</span>', 'plugin-domain' ),
		'post_type'                 => array( 'order' ), // Define one or more post types the status can be applied to.
		'show_in_admin_all_list'    => true,
		'show_in_admin_status_list' => true,
		'show_in_metabox_dropdown'  => true,
		'show_in_inline_dropdown'   => true,
		'dashicon'                  => 'dashicons-businessman',
	) );

    register_post_status( 'canceled', array(
		'label'                     => _x( 'Canceled', 'post status label', 'waorder' ),
		'public'                    => true,
		'label_count'               => _n_noop( 'Canceled <span class="count">(%s)</span>', 'Canceled <span class="count">(%s)</span>', 'plugin-domain' ),
		'post_type'                 => array( 'order' ), // Define one or more post types the status can be applied to.
		'show_in_admin_all_list'    => true,
		'show_in_admin_status_list' => true,
		'show_in_metabox_dropdown'  => true,
		'show_in_inline_dropdown'   => true,
		'dashicon'                  => 'dashicons-businessman',
	) );

    register_post_status( 'refunded', array(
		'label'                     => _x( 'Refunded', 'post status label', 'waorder' ),
		'public'                    => true,
		'label_count'               => _n_noop( 'Refunded <span class="count">(%s)</span>', 'Refunded <span class="count">(%s)</span>', 'plugin-domain' ),
		'post_type'                 => array( 'order' ), // Define one or more post types the status can be applied to.
		'show_in_admin_all_list'    => true,
		'show_in_admin_status_list' => true,
		'show_in_metabox_dropdown'  => true,
		'show_in_inline_dropdown'   => true,
		'dashicon'                  => 'dashicons-businessman',
	) );
}

add_action( 'add_meta_boxes', 'waorder_order_metabox', 10, 2 );
function waorder_order_metabox( $post_type, $post ) {
    add_meta_box(
        'waorder_order_detail',
        'Order Detail',
        'waorder_order_detail_metabox_view',
        'order',
        'normal',
        'high' );

    add_meta_box(
        'waorder_order_customer',
        'Customer Detail',
        'waorder_order_customer_metabox_view',
        'order',
        'side',
        'high' );

    add_meta_box(
        'waorder_order_save',
        'Simpan Order',
        'waorder_order_save_metabox_view',
        'order',
        'side',
        'high' );
}

function waorder_order_detail_metabox_view($post){
    wp_nonce_field('noncenonce','waordernonce');

    $detail = get_post_meta($post->ID, 'order_detail', true);
    $product_id = get_post_meta($post->ID, 'order_product_id', true);

    $order_v2 = get_post_meta($post->ID, 'order_v2', true);
    $order_items = get_post_meta($post->ID, 'order_items', true);
    $items = json_decode($order_items, true);
    $weight = 0;
    ?>
    <?php if( $order_v2 == 'yap' ): ?>
        <div class="waorder">
            <div class="order-detail waorder-clearfix">
                <table>
                    <tr>
                        <td><label>Items</label></td>
                        <td>
                            <?php foreach( (array)$items as $item ): ?>
                                <?php
                                $w = intval($item['order_item_weight']) * intval($item['order_item_qty']);
                                $weight = $weight + $w;
                                ?>
                                <div class="order-item-box">
                                    <h3><a target="_blank" href="<?php echo get_the_permalink($item['order_item_id']); ?>"><?php echo $item['order_item_name']; ?></a></h3>
                                    <div class="order-item-price">
                                        @ Rp <?php echo number_format($item['order_item_price'],0,'.','.'); ?>
                                    </div>
                                    <div class="order-item-detail">
                                        <?php if( isset($item['order_item_color']) ): ?>
                                            <p>Warna: <?php echo $item['order_item_color']; ?></p>
                                        <?php endif; ?>
                                        <?php if( isset($item['order_item_custom_name']) && isset($item['order_item_custom_value']) ): ?>
                                            <p><?php echo $item['order_item_custom_name']; ?>: <?php echo $item['order_item_custom_value']; ?> L</p>
                                        <?php endif; ?>
                                        <p>Quantity: <?php echo $item['order_item_qty']; ?></p>
                                        <?php
                                        $total_harga = intval($item['order_item_price']) * intval($item['order_item_qty']);
                                        ?>
                                        <p>Total Harga: Rp <?php echo number_format($total_harga,0,'.',','); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Total Berat</label></td>
                        <td><?php echo $weight; ?> Gram</td>
                    </tr>

                    <tr>
                        <td><label>Tipe Pembayaran</label></td>
                        <td><?php echo get_post_meta($post->ID, 'order_payment_type', true); ?></td>
                    </tr>
                    <tr>
                        <td><label>Harga Subtotal</label></td>
                        <td>Rp <?php echo number_format(get_post_meta($post->ID, 'order_subtotal', true),0,'.',','); ?></td>
                    </tr>
                    <tr>
                        <td><label>Ongkir</label></td>
                        <td><?php echo get_post_meta($post->ID, 'order_ongkir', true); ?></td>
                    </tr>
                    <tr>
                        <td><label>Total</label></td>
                        <td>Rp <?php echo number_format(get_post_meta($post->ID, 'order_total', true),0,'.',','); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="waorder">
            <div class="order-detail waorder-clearfix">
                <table>
                    <tr>
                        <td><label>Produk</label></td>
                        <td>
                            <a href="<?php echo get_the_permalink($product_id); ?>" target="_blank">
                                <h3><?php echo get_post_meta($post->ID, 'order_product_name', true); ?></h3>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Harga (@)</label></td>
                        <td><input type="text" name="order_product_price" value="<?php echo number_format(get_post_meta($post->ID, 'order_product_price', true),0,'.','.'); ?>" readonly/></td>
                    </tr>
                    <tr>
                        <td><label>Quantity</label></td>
                        <td><input type="number" name="order_detail[quantity]" value="<?php echo $detail['quantity']?>" min="1"/></td>
                    </tr>
                    <tr>
                        <td><label>Berat</label></td>
                        <td><input type="number" name="order_detail[weight]" value="<?php echo $detail['weight']?>"/></td>
                    </tr>
                    <!--<tr>
                        <td><label>Ukuran</label></td>
                        <td><input type="text" name="order_detail[size]" value="<?php echo $detail['size']; ?>"/></td>
                    </tr>--->
                    <tr>
                        <td><label>Warna</label></td>
                        <td><input type="text" name="order_detail[color]" value="<?php echo $detail['color']; ?>"/></td>
                    </tr>
                    <?php if( isset($detail['custom_label']) && $detail['custom_label'] ): ?>
                        <tr>
                            <td><label><?php echo $detail['custom_label']; ?> (custom variable)</label></td>
                            <td>
                                <input type="text" name="order_detail[custom_value]" value="<?php echo $detail['custom_value']; ?>"/>
                                <input type="hidden" name="order_detail[custom_label]" value="<?php echo $detail['custom_label']; ?>"/>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td><label>Tipe Pembayaran</label></td>
                        <td><input type="text" name="order_payment_type" value="<?php echo get_post_meta($post->ID, 'order_payment_type', true); ?>"/></td>
                    </tr>
                    <tr>
                        <td><label>Harga Subtotal</label></td>
                        <td><input type="text" name="order_subtotal" value="<?php echo get_post_meta($post->ID, 'order_subtotal', true); ?>"/></td>
                    </tr>
                    <tr>
                        <td><label>Ongkir</label></td>
                        <td><input type="text" name="order_ongkir" value="<?php echo get_post_meta($post->ID, 'order_ongkir', true); ?>"/></td>
                    </tr>
                    <tr>
                        <td><label>Total</label></td>
                        <td><input type="text" name="order_total" value="<?php echo get_post_meta($post->ID, 'order_total', true); ?>"/></td>
                    </tr>
                    <tr>
                        <td><label>Catatan</label></td>
                        <td><textarea name="order_note" style="width: 100%;height: 150px;"><?php echo get_post_meta($post->ID, 'order_note', true); ?></textarea></td>
                    </tr>
                </table>
            </div>
        </div>
    <?php endif; ?>
    <?php
}

function waorder_order_customer_metabox_view($post){
    wp_nonce_field('noncenonce','waordernonce');

    $phone = get_post_meta($post->ID, 'customer_phone', true);

    $phone = preg_replace('/[^0-9]/', '', $phone);
    $phone = preg_replace('/^620/','62', $phone);
    $phone = preg_replace('/^0/','62', $phone);

    ?>
    <div class="waorder">
        <div class="order-customer waorder-clearfix">
            <p>
                <label style="font-weight:bold">Nama Lengkap</label><br/>
                <input type="text" style="width:100%" value="<?php echo get_post_meta($post->ID, 'customer_full_name', true); ?>" name="customer_full_name" required><br/>
            </p>
            <p>
                <label style="font-weight:bold">Nomor Hp</label><br/>
                <input type="text" style="width:100%" value="<?php echo get_post_meta($post->ID, 'customer_phone', true); ?>" name="customer_phone"><br/>
            </p>
            <p>
                <label style="font-weight:bold">Alamat</label><br/>
                <textarea style="width:100%;height:50px;line-height: 25px;" name="customer_address"><?php echo get_post_meta($post->ID, 'customer_address', true); ?></textarea><br/>
                <textarea style="width:100%;height: 50px;line-height: 25px" name="customer_subdictrict"><?php echo get_post_meta($post->ID, 'customer_subdistrict', true); ?></textarea>
            </p>
            <p>
                <button type="button" style="width: 100%;" class="button button-primary" onclick="customerFollowUp('<?php echo $phone; ?>');"> Follow Up</button>
            </p>
        </div>
    </div>
    <?php
}


function waorder_order_save_metabox_view($post){
    wp_nonce_field('noncenonce','waordernonce');
    ?>
    <div class="waorder">
        <div class="order-customer waorder-clearfix">
            <p>
                <label style="font-weight:bold">Setatus Order</label><br/>
                <select name="order_status" style="width: 100%">
                    <option value="new_order" <?php if($post->post_status == 'new_order'){echo 'selected="selected"';} ?>>New Order</option>
                    <option value="on_hold" <?php if($post->post_status == 'on_hold'){echo 'selected="selected"';} ?>>On Hold</option>
                    <option value="on_shipping" <?php if($post->post_status == 'on_shipping'){echo 'selected="selected"';} ?>>On Shipping</option>
                    <option value="completed" <?php if($post->post_status == 'completed'){echo 'selected="selected"';} ?>>Completed</option>
                    <option value="canceled" <?php if($post->post_status == 'canceled'){echo 'selected="selected"';} ?>>Canceled</option>
                    <option value="refunded" <?php if($post->post_status == 'refunded'){echo 'selected="selected"';} ?>>Refunded</option>
                </select>
            </p>
            <p>
                <button type="submit" style="width: 100%;" class="button button-primary button-hero">Simpan Perubahan</button>
            </p>
        </div>
    </div>
    <?php
}

add_action('save_post', 'waorder_order_metabox_save');
function waorder_order_metabox_save( $post_id ) {

    global $wpdb;

    if ( !isset( $_POST['waordernonce'] ) ) {
        return $post_id;
    }

    if ( !wp_verify_nonce( $_POST['waordernonce'], 'noncenonce') ) {
        return $post_id;
    }

    if ( isset( $_POST[ 'order_detail' ] ) ) {
        update_post_meta( $post_id, 'order_detail', $_POST['order_detail'] );
    }

    if ( isset( $_POST[ 'order_payment_type' ] ) ) {
        update_post_meta( $post_id, 'order_payment_type', sanitize_text_field($_POST['order_payment_type']) );
    }

    if ( isset( $_POST[ 'order_subtotal' ] ) ) {
        update_post_meta( $post_id, 'order_subtotal', sanitize_text_field($_POST['order_subtotal']) );
    }

    if ( isset( $_POST[ 'order_ongkir' ] ) ) {
        update_post_meta( $post_id, 'order_ongkir', sanitize_text_field($_POST['order_ongkir']) );
    }

    if ( isset( $_POST[ 'order_total' ] ) ) {
        update_post_meta( $post_id, 'order_total', sanitize_text_field($_POST['order_total']) );
    }

    if ( isset( $_POST[ 'order_note' ] ) ) {
        update_post_meta( $post_id, 'order_note', sanitize_text_field($_POST['order_note']) );
    }

    if ( isset( $_POST[ 'customer_full_name' ] ) ) {
        update_post_meta( $post_id, 'customer_full_name', sanitize_text_field($_POST['customer_full_name']) );
    }

    if ( isset( $_POST[ 'customer_phone' ] ) ) {
        update_post_meta( $post_id, 'customer_phone', sanitize_text_field($_POST['customer_phone']) );
    }

    if ( isset( $_POST[ 'customer_address' ] ) ) {
        update_post_meta( $post_id, 'customer_address', sanitize_text_field($_POST['customer_address']) );
    }

    if ( isset( $_POST[ 'customer_subdistrict' ] ) ) {
        update_post_meta( $post_id, 'customer_subdistrict', sanitize_text_field($_POST['customer_subdistrict']) );
    }

    if ( isset( $_POST[ 'order_status' ] ) ) {

        $wpdb->update( $wpdb->posts, array( 'post_status' => sanitize_text_field($_POST[ 'order_status' ]) ), array( 'ID' => $post_id ) );

        clean_post_cache( $post_id );
    }

}

add_filter( 'manage_order_posts_columns', 'waorder_order_column' );
add_action( 'manage_order_posts_custom_column' , 'waorder_order_content_column', 10, 2 );

function waorder_order_column($columns) {

    $new_columns['cb'] = '<input type="checkbox"/>';
    $new_columns['order_name'] = __('Title', 'waorder');
    $new_columns['order_date'] = __('Date', 'waorder');
    $new_columns['order_customer'] = __('Customer', 'waorder');
    //$new_columns['order_product'] = __('Product', 'waorder');
    $new_columns['order_status'] = __( 'Status', 'waorder' );
    $new_columns['order_followup'] = __('Follow Up', 'waorder');
    $new_columns['order_action'] = __('&nbsp;', 'waorder');

    return $new_columns;
}

function waorder_order_content_column( $column, $post_id ) {

    $phone = get_post_meta($post_id, 'customer_phone', true);

    $phone = preg_replace('/[^0-9]/', '', $phone);
    $phone = preg_replace('/^620/','62', $phone);
    $phone = preg_replace('/^0/','62', $phone);

    $product_id = get_post_meta($post_id, 'order_product_id', true);

    switch ( $column ) :

        case 'order_name' :
            echo '<span style="font-weight: bold">'.get_the_title($post_id).'</span>';
            break;

        case 'order_date' :
            echo get_the_date( 'Y-m-d H:i:s', $post_id);
            break;

        case 'order_customer' :
            echo '<span>'.get_post_meta($post_id, 'customer_full_name', true).'</span> ';
            echo '<span>( '.$phone.' )</span><br/>';
            break;

        // case 'order_product' :
        //     echo '<a href="'.get_the_permalink($product_id).'" target="_blank">'.get_post_meta($post_id, 'order_product_name', true).'</a>';
        //     break;

        case 'order_status' :
            $statuse = get_post_status($post_id);
            $statuses = array(
                'new_order'   => 'New Order',
                'on_hold'     => 'On Hold',
                'on_shipping' => 'On Shipping',
                'completed'   => 'Completed',
                'refunded'    => 'Refunded',
                'canceled'   => 'Canceled',
            );

            $statuse = isset($statuses[$statuse]) ? $statuse : 'new_order';
            $status = isset($statuses[$statuse]) ? $statuses[$statuse] : 'New Order';
            echo '<div class="order-status-'.$statuse.'">'.$status.'</div>';
            break;

        case 'order_followup' :
            echo '<button type="button" class="button button-primary" onclick="customerFollowUp(\''.$phone.'\');">Follow Up</button>';
            break;

        case 'order_action' :
        echo '<div style="text-align:right">';
            echo '<a href="'.get_edit_post_link( $post_id ).'" class="button">View Order</a>&nbsp';
            //echo '<a href="'.get_delete_post_link( $post_id ).'" class="button">Delete</a>';
            echo '</div>';
            break;

    endswitch;
}



add_action( 'admin_footer', 'waorder_order_admin_footer' );
function waorder_order_admin_footer(){
    $current_screen = get_current_screen();
    if( $current_screen->parent_file == 'edit.php?post_type=order' ):
        ?>
        <script>
        jQuery('.order_name .row-actions').hide();
        jQuery(jQuery(".wrap h1")[0]).append("<a  id='export-csv' class='add-new-h2'>Export To CSV</a>");
        jQuery('#export-csv').on('click', function(){
            jQuery(this).html('Proses..');

            jQuery.ajax({
                type: "POST",
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                // dataType: "json",
                data: {
                    action: 'export_orders',
                    nonce: '<?php echo wp_create_nonce( 'waordernonce' ); ?>',
                    status: '<?php echo isset($_GET['post_status']) ? $_GET['post_status'] : 'all'; ?>',
                },
                success: function(data){
                    jQuery('#export-excel').html('Export To CSV');
                    console.log(data);
                    window.open(data, '_blank');
                }
            });
        })
        </script>
        <?php
    endif;
}

add_action( 'admin_menu', function () {
    remove_meta_box( 'submitdiv', 'order', 'side' );
} );


//add_action('wp', 'test');
function test(){
    $args = array(
        'post_type' => 'order',
        'posts_per_page' => -1,
        'fields' => 'ids',
    );

    // if( $_POST['status'] !== 'all' ):
    //     $args['post_status'] = 'new_order'; //sanitize_text_field($_POST['status']);
    // endif;

    $posts = new WP_Query($args);

    $list = array();

    $list[] = array(
        'Title',
        'Date',
        'Customer',
        'Phone',
        'Address',
        'District',
        'Product',
    );

    foreach ((array)$posts->posts as $id):
        $phone = get_post_meta($id, 'customer_phone', true);

        $phone = preg_replace('/[^0-9]/', '', $phone);
        $phone = preg_replace('/^620/','62', $phone);
        $phone = preg_replace('/^0/','62', $phone);

        $detail = get_post_meta($id, 'order_detail', true);
        $address = get_post_meta($id, 'customer_address', true);

        $order_v2 = get_post_meta($id, 'order_v2', true);
        $order_items = get_post_meta($id, 'order_items', true);
        $items = json_decode($order_items, true);

        if( $order_v2 == 'yap' ){
            $product = '';
            foreach((array)$items as $item ){
                $itm = $item['order_item_name'].'; Qty:'.$item['order_item_qty'].';';
                if( isset($item['order_item_color']) ){
                    $itm .= ' Warna:'.$item['order_item_color'].';';
                }
                if( isset($item['order_item_custom_name']) ){
                    $itm .= ' '.$item['order_item_custom_name'].':'.$item['order_item_custom_value'].';';
                }
                $product .= $itm.'** ';
            }

        }else{
            $product = get_post_meta($id, 'order_product_name', true).'; Qty:'.$detail['quantity'].'; Ukuran:'.$detail['size'].'; Warna:'.$detail['color'];
        }

        $list[] = array(
            get_the_title($id),
            get_the_date( 'Y-m-d H:i:s', $id),
            get_post_meta($id, 'customer_full_name', true),
            $phone,
            $address,
            get_post_meta($id, 'customer_subdictrict', true),
            $product,
        );
    endforeach;
    __debug($list);
    exit;
}

add_action( 'wp_ajax_export_orders', 'ajax_export_orders');
function ajax_export_orders(){
    $nonce = isset($_REQUEST['nonce']) ? $_REQUEST['nonce'] : '';
    if( !wp_verify_nonce($nonce, 'waordernonce') ) exit;

    $upload_dir   = wp_upload_dir();

    $args = array(
        'post_type' => 'order',
        'posts_per_page' => -1,
        'fields' => 'ids',
    );

    if( $_POST['status'] !== 'all' ):
        $args['post_status'] = 'new_order'; //sanitize_text_field($_POST['status']);
    endif;

    $posts = new WP_Query($args);

    $list = array();

    $list[] = array(
        'Title',
        'Date',
        'Customer',
        'Phone',
        'Address',
        'District',
        'Product',
    );

    foreach ((array)$posts->posts as $id):
        $phone = get_post_meta($id, 'customer_phone', true);

        $phone = preg_replace('/[^0-9]/', '', $phone);
        $phone = preg_replace('/^620/','62', $phone);
        $phone = preg_replace('/^0/','62', $phone);

        $detail = get_post_meta($id, 'order_detail', true);
        $address = get_post_meta($id, 'customer_address', true);

        $order_v2 = get_post_meta($id, 'order_v2', true);
        $order_items = get_post_meta($id, 'order_items', true);
        $items = json_decode($order_items, true);

        if( $order_v2 == 'yap' ){
            $product = '';
            foreach((array)$items as $item ){
                $itm = $item['order_item_name'].' Qty:'.$item['order_item_qty'];
                if( isset($item['order_item_color']) ){
                    $itm .= ' Warna:'.$item['order_item_color'];
                }
                if( isset($item['order_item_custom_name']) ){
                    $itm .= ' '.$item['order_item_custom_name'].':'.$item['order_item_custom_value'];
                }
                $product .= $itm.'**';
            }

        }else{
            $product = get_post_meta($id, 'order_product_name', true).' Qty:'.$detail['quantity'].' Ukuran:'.$detail['size'].' Warna:'.$detail['color'];
        }

        $list[] = array(
            get_the_title($id),
            get_the_date( 'Y-m-d H:i:s', $id),
            get_post_meta($id, 'customer_full_name', true),
            $phone,
            $address,
            get_post_meta($id, 'customer_subdictrict', true),
            $product,
        );
    endforeach;

    $filename = 'orders-export-status-'.$_POST['status'].'-'.date('y-m-d-H-i-s').'.csv';

    $file = fopen( WP_CONTENT_DIR.'/uploads/'.$filename,'w');

    foreach ($list as $line) {
      fputcsv($file, $line);
    }

    fclose($file);

    echo WP_CONTENT_URL . '/uploads/'.$filename;
    exit;
}

add_action('wp_ajax_order_create', 'waorder_order_create');
add_action('wp_ajax_nopriv_order_create', 'waorder_order_create');
function waorder_order_create(){

    $input = file_get_contents("php://input");

    /*
    no input ? return.
     */
    if( empty($input) ) exit;

    $data = json_decode($input, true);

    /*
    Check nonce.
     */
    if( isset($data['nonce'])  && wp_verify_nonce($data['nonce'], 'waordernonce') ):

        $default = array(
            'full_name'               => '',
            'phone'                   => '',
            'address'                 => '',
            'subdistrict'             => '',
            'subdistrict_id'          => '',
            'order_payment_type'      => '',
            'order_item_id'           => '',
            'order_item_name'         => '',
            'order_item_price'        => '',
            'order_item_qty'          => 1,
            'order_item_color'        => '',
            'order_item_size'         => '',
            'order-item_custom'       => '',
            'order_item_custom_label' => '',
            'order_item_weight'       => '',
            'order_ongkir'            => '',
            'order_sub_total'         => '',
            'order_total'             => '',
            'order_courier'           => '',
            'order_key'               => '',
        );

        $data = wp_parse_args($data, $default);

        $order_key = sanitize_text_field($data['order_key']);

        if( empty($order_key) ) exit;

        $cookie = isset($_COOKIE[$order_key]) ? $_COOKIE[$order_key] : '';

        if( $cookie ):
            $post_id = $cookie;
        else:
            $invoice_last_number = get_option('invoice_number');
            $invoice_number = intval($invoice_last_number) + 1;

            $post_data = array(
                'post_title'   => 'Order '.$invoice_number,
                'post_name'    => 'order-'.$invoice_number,
                'post_content' => '',
                'post_status'  => 'new_order',
                'post_author'  => 1,
                'post_type'    => 'order',
            );
            $post_id = wp_insert_post($post_data);
            update_option('invoice_number', $invoice_number);
            //wp_update_post(['ID' => $post_id, 'post_title' => 'Order '.$post_id]);

            setcookie($order_key, $post_id, strtotime('+1 day'));
        endif;

        update_post_meta($post_id, 'customer_full_name', sanitize_text_field($data['full_name']));
        update_post_meta($post_id, 'customer_phone', sanitize_text_field($data['phone']));
        update_post_meta($post_id, 'customer_address', sanitize_text_field($data['address']));
        update_post_meta($post_id, 'customer_subdistrict', sanitize_text_field($data['subdistrict']));
        update_post_meta($post_id, 'customer_subdistrict_id', sanitize_text_field($data['subdistrict_id']));
        update_post_meta($post_id, 'order_v2', 'yap');
        update_post_meta($post_id, 'order_subtotal', sanitize_text_field($data['order_sub_total']));
        update_post_meta($post_id, 'order_total', sanitize_text_field($data['order_total']));
        update_post_meta($post_id, 'order_ongkir', sanitize_text_field($data['order_courier']));
        update_post_meta($post_id, 'order_items', sanitize_text_field($data['order_items']));
        update_post_meta($post_id, 'order_payment_type', sanitize_text_field($data['payment_type']));
        echo $post_id;
        exit;
    endif;

    exit;
}
