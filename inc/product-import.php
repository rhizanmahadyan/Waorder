<?php
/**
 * Contains methods for customizing the theme customization screen.
 *
 * @link http://codex.wordpress.org/Theme_Customization_API
 * @since waorder 2.1.5
 */

function waorder_product_import_admin_menu(){

    //if( waorder_lislis() == 'active' ) return;
    add_submenu_page(
        'edit.php?post_type=product',
        __('Import Massal', 'waorder'),
        __('Import Massal', 'waorder'),
        'manage_options',
        'product-import',
        'waorder_product_import_page'
    );
}

add_action( 'admin_menu',  'waorder_product_import_admin_menu' );

function waorder_product_import_page(){

    ob_start();
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline"><?php echo esc_html( __( 'Waorder Feature', 'waorder' ) ); ?></h1>
        <div style="">
            <p>* Untuk menghindari terjadinya error dan kesalahan yang di sebabkan oleh resource server, kami merekomendasikan data import tidak lebih dari 50 row dalam 1 atau sekali file import.</p>
            <p>
                <?php
                $demo_csv_url = get_template_directory_uri() . '/data/demo-import-data.csv';
                ?>
                * Download contoh file csv <a href="<?php echo $demo_csv_url; ?>" target="_blank">di sini</a><br/>
            </p>
            <p>
                Cara Edit Data Import CSV:<br/>
                1. Download file csv kemudian buka file csv menggunakan microsoft excel<br/>
                2. Blok seluruh data dalam file csv copy dengan menekan tombol ctrl + C<br/>
                3. Buka google spreadsheet <a href="https://docs.google.com/spreadsheets/u/0/" target="_blank">Di Sini</a>, buat spreadsheet baru kemduian paste data yang telah tercopy ke dalam google spreadhseet dengan menekan tombol ctrl + V<br/>
                4. Blok kolom label A hingga Q, klik kanan pilih menu "Ubah Ukuran Kolom" pilih paskan sesuai data Klik Tombol Oke.<br/>
                5. Lakukan editing, ubah atau tambah data produk sesuai ketentuan atau data contoh.<br/>
                6. Setelah selesai, pilih menu File pada barisan menu bagian kiri atas, Pilih sub menu Download, Klik format csv atau Nilai yang di pisahkan Koma<br/>
                7. Upload file di bawah ini.
            </p>
            <p style="color: red">
                * kesalahan dalam melakukan editing dapat menyebabkan kegagalan proses import<br/>
                * Hindari menggunakan tanda baca koma saat melakukan input data, karena dapat menyebabkan data tidak beraturan.
            </p>
        </div>
        <form name="post" method="post" id="quick-press" class="initial-form hide-if-no-js ng-dirty" enctype="multipart/form-data">
            <div class="input-text-wrap" id="title-wrap">
    			<input type="file" name="csv" required>
    		</div>
    		<p class="submit">
    			<input type="hidden" name="_wpnonce" value="<?php echo wp_create_nonce('waorder_nonce'); ?>">
                <button type="submit" class="button button-primary">Import Sekarang</button>
                <br class="clear">
    		</p>
        </form>
        <?php
        waorder_product_import_action();
        ?>
    </div>
    <?php
    $html = ob_get_contents();
    ob_end_clean();
    echo $html;
}

function waorder_product_import_action(){

    $post = isset($_POST) ? $_POST : array();

    if( isset($post['_wpnonce']) && wp_verify_nonce($post['_wpnonce'], 'waorder_nonce') ){
        set_time_limit(0);

        $csv = $_FILES['csv'];
        //__debug($csv);
        if( $csv && isset($csv['tmp_name']) ){
            $file = fopen($csv['tmp_name'], 'r');
            $data = array();
            while (($row = fgetcsv($file, 0, ",")) !== FALSE) :
                $data[] = $row;
            endwhile;
            fclose($file);

            foreach( (array) $data as $key=>$val ):
                if( $key == 0 ) continue;

                $c = count($val);

                if( $c < 15 ) continue;

                $result = waorder_create_product($val);
                if( $result == 'error' ){
                    echo '<br/>Error Import<br/>';
                }else{
                    $l = get_edit_post_link($result);
                    echo '<a href="'.$l.'" taget="_blankk">Success product ID '.$result.'</a><br/>';
                }
            endforeach;
        }
    }
}

function waorder_create_product($data){

    $d = array(
        'title'                 => isset($data[0]) ? sanitize_text_field($data[0]) : '',
        'content'               => isset($data[1]) ? sanitize_text_field($data[1]) : '',
        'price'                 => isset($data[2]) ? intval($data[2]) : '',
        'price_slik'            => isset($data[3]) ? intval($data[3]) : '',
        'color'                 => isset($data[4]) ? sanitize_text_field($data[4]) : '',
        'custom_variable_name'  => isset($data[5]) ? sanitize_text_field($data[5]) : '',
        'custom_variable_value' => isset($data[6]) ? sanitize_text_field($data[6]) : '',
        'is_out_stock'          => isset($data[7]) ? sanitize_text_field($data[7]) : '',
        'label'                 => isset($data[8]) ? sanitize_text_field($data[8]) : '',
        'weight'                => isset($data[9]) ? intval($data[9]) : 1000,
        'category'              => isset($data[10]) ? sanitize_text_field($data[10]) : '',
        'thumbnail'             => isset($data[15]) ? esc_url_raw($data[15]) : '',
        'galeries'              => isset($data[16]) ? sanitize_text_field($data[16]) : '',
        'product_link_mp'       => array(
            'bukalapak'         => isset($data[11]) ? esc_url_raw($data[11]) : '',
            'tokopedia'         => isset($data[12]) ? esc_url_raw($data[12]) : '',
            'shoppe'            => isset($data[13]) ? esc_url_raw($data[13]) : '',
            'lazada'            => isset($data[14]) ? esc_url_raw($data[14]) : '',
        )
    );

    $categories = explode('*', $d['category']);
    $color = str_replace('*', ',', $d['color']);

    $custom_variable = explode('*', $d['custom_variable_value']);
    $custom_variable_values = array();

    foreach( (array) $custom_variable as $key=>$val ):
        $dd = explode(':', $val);
        if( !isset($dd[0]) ) continue;
        $custom_variable_values['chooser'][] = $dd[0];
        $custom_variable_values['price'][] = isset($dd[1]) ? intval($dd[1]) : '';
    endforeach;

    $post_data = array(
        'post_title'   => $d['title'],
        'post_name'    => sanitize_title($d['title']),
        'post_content' => str_replace('*', ',', $d['content']),
        'post_status'  => 'draft',
        //'post_author'  => 1,
        'post_type'    => 'product',
        // 'tax-input' => array(
        //     'product-category' => $categories,
        // ),
    );
    $post_id = wp_insert_post($post_data);

    if( is_wp_error($post_id) ){
        return 'error';
    }else{
        if($d['is_out_stock'] == 'YA' ){
            update_post_meta($post_id, 'product_out_stock', 'yes');
        }
        update_post_meta($post_id, 'product_price', intval($d['price']));
        update_post_meta($post_id, 'product_price_slik', intval($d['price_slik']));
        update_post_meta($post_id, 'product_color', $color);

        update_post_meta($post_id, 'product_custom_variable_label', $d['custom_variable_name']);
        update_post_meta($post_id, 'product_custom_variable_value', $custom_variable_values);

        update_post_meta($post_id, 'product_ribbon', $d['label']);
        update_post_meta($post_id, 'product_weight', $d['weight']);
        update_post_meta($post_id, 'product_link_mp', $d['product_link_mp']);

        waorder_upload_product_thumbnail($d['thumbnail'], $post_id);
        waorder_upload_product_galery($d['galeries'], $post_id);

        $term_ids = array();

        foreach( (array)$categories as $key=>$val ){
            $term = term_exists($val, 'product-category');
            if( !$term ){
                $term = wp_insert_term($val, 'product-category');
            }
            $term_ids[] = $term['term_id'];
        }


        if( $term_ids ){
            wp_set_post_terms($post_id, $term_ids, 'product-category');
        }

        return $post_id;
    }

}

function waorder_upload_product_thumbnail($url, $post_id) {
    $image = '';
    if($url != '') {

        $file = array();
        $file['name'] = $url;
        $file['tmp_name'] = download_url($url);

        if (is_wp_error($file['tmp_name'])) {
            @unlink($file['tmp_name']);
            //var_dump( $file['tmp_name']->get_error_messages( ) );
        } else {
            $attachmentId = media_handle_sideload($file, $post_id);

            if ( is_wp_error($attachmentId) ) {
                @unlink($file['tmp_name']);
                //var_dump( $attachmentId->get_error_messages( ) );
            } else {
                $image = wp_get_attachment_url( $attachmentId );
                set_post_thumbnail( $post_id, $attachmentId );
                @unlink($file['tmp_name']);
            }
        }
    }
    return $image;
}

function waorder_upload_product_galery($galeries_url, $post_id) {

    $galeries = array();

    $urls = explode('*', $galeries_url);
    foreach( (array)$urls as $key=>$url) {

        $file = array();
        $file['name'] = $url;
        $file['tmp_name'] = download_url($url);

        if (is_wp_error($file['tmp_name'])) {
            @unlink($file['tmp_name']);
            //var_dump( $file['tmp_name']->get_error_messages( ) );
        } else {
            $attachmentId = media_handle_sideload($file, $post_id);

            if ( is_wp_error($attachmentId) ) {
                @unlink($file['tmp_name']);
                //var_dump( $attachmentId->get_error_messages( ) );
            } else {
                $galeries[] = $attachmentId;
            }
        }
    }


    update_post_meta($post_id, 'waorder_gallery_ids', $galeries);
}


function waorder_product_export_action(){
    if( isset($_GET['export']) && $_GET['export'] == 'true'){
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            'fields' => 'ids',
        );

        $posts = new WP_Query($args);

        $list = array();

        $list[] = array(
            'Nama Produk',
            'Deskripsi',
            'Harga',
            'Harga Coret',
            'Warna',
            'Nama Custom Variable',
            'Value Custom Variable',
            'Stok Habis?',
            'Label Produk',
            'Berat',
            'Category Produk',
            'Link Bukalapak',
            'Link Tokopedia',
            'Link Shoppe',
            'Link Lazada',
            'Gambar Utama Produk',
            'Gambar Galery Produk'
        );

        foreach ((array)$posts->posts as $id):

            $post = get_post($id);

            if( !$post ) continue;

            $custom_variable_values = get_post_meta($post->ID, 'product_custom_variable_value', true);

            $custom_variable_value = array();

            if( isset( $custom_variable_values['chooser']) ):
                foreach( (array) $custom_variable_values['chooser'] as $key=>$val ):
                    $pricess = $custom_variable_values['price'];
                    $prices = $pricess[$key] ? $pricess[$key] : '';
                    $custom_variable_value[] = $val .':'. $prices;
                endforeach;
            endif;

            $is_out_stock = get_post_meta($post->ID, 'product_out_stock', true) == 'yes' ? 'YA' : '';

            $weight = get_post_meta($post->ID, 'product_weight', true);
            $weight = empty($weight) ? 1000 : intval($weight);

            $photos = array();
            $thumbnail_id = get_post_thumbnail_id( $post->ID );
            $photo_ids = get_post_meta($id, 'waorder_gallery_ids', true);

            foreach( (array) $photo_ids as $key=> $id ):
                $photos[] = wp_get_attachment_url($id, 'full');
            endforeach;

            $list[] = array(
                strip_tags($post->post_title),
                '', //strip_tags($post->post_content),
                get_post_meta($post->ID, 'product_price', true),
                get_post_meta($post->ID, 'product_price_slik', true),
                str_replace(',', '*', get_post_meta($post->ID, 'product_color', true)),
                get_post_meta($post->ID, 'product_custom_variable_label', true),
                implode('*',$custom_variable_value),
                $is_out_stock,
                get_post_meta($post->ID, 'product_ribbon', true),
                $weight,
                '',
                '',
                '',
                '',
                '',
                wp_get_attachment_url($thumbnail_id, 'full'),
                implode('*', $photos),
            );
        endforeach;

        __debug($list);

        $filename = 'product-export-'.date('y-m-d-H-i-s').'.csv';

        $file = fopen( WP_CONTENT_DIR.'/uploads/'.$filename,'w');

        foreach ($list as $line) {
          fputcsv($file, $line);
        }

        fclose($file);

        echo WP_CONTENT_URL . '/uploads/'.$filename;
    }
}
