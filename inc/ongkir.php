<?php

add_filter('waorder_feature_tab_section','waorder_ongkir_tab_section', 10 , 2 );
function waorder_ongkir_tab_section($sections, $current_tab){
    if( $current_tab == 'ongkir' ):
        $sections['rajaongkir'] = 'Raja Ongkir API';
        $sections = apply_filters('waorder_feature_tab_section_ongkir', $sections);
    endif;

    return $sections;
}

add_action('waorder_feature_option_page_ongkir_general', 'waorder_ongkir_options_page_general' );
function waorder_ongkir_options_page_general(){

    $ongkir_provider = array(
        'rajaongkir' => 'Raja Ongkir API',
    );

    $ongkir_provider = apply_filters('waorder_feature_ongkir_provider', $ongkir_provider);
    ob_start();
    ?>
    <table>
        <tr>
            <th scope="row">
                <label><?php _e('Aktifkan Fitur Ongkir ?', 'waorder'); ?></label>
            </th>
            <td>
                <input name="waorder_feature_ongkir_enable" type="hidden" value="no"/>
                <input name="waorder_feature_ongkir_enable" type="checkbox" value="yes" <?php echo ( 'yes' == get_option('waorder_feature_ongkir_enable')) ? 'checked="chekced"': ''; ?> />
                <?php echo __('Aktifkan Fitur Ongkir') ?>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label><?php _e('Provider Ongkir', 'waorder'); ?></label>
            </th>
            <td>
                <select name="waorder_ongkir_provider" class="regular-text">

                    <?php foreach( (array) $ongkir_provider as $key =>$val ): ?>
                        <option value="<?php echo $key; ?>" <?php if(get_option('waorder_ongkir_provider') == $key ){echo 'selected';}?>><?php echo $val; ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row">
            </th>
            <td>
                <button class="button button-primary" type="submit" name="submit"><?php echo __('Simpan Pengaturan', 'waorder'); ?></button>
            </td>
        </tr>
    </table>
    <?php
    $content = ob_get_contents();
    ob_end_clean();

    echo $content;
}

add_action('waorder_feature_option_page_ongkir_rajaongkir', 'waorder_ongkir_options_page_rajaongkir' );
function waorder_ongkir_options_page_rajaongkir(){

    $ongkir_provider = array(
        'rajaongkir' => 'Raja Ongkir API',
    );

    $ongkir_provider = apply_filters('waorder_feature_ongkir_provider', $ongkir_provider);
    ob_start();
    ?>
    <table>
        <tr>
            <th scope="row">
                <label><?php _e('Api Key', 'waorder'); ?></label>
            </th>
            <td>
                <input name="waorder_rajaongkir_api_key" type="text" value="<?php echo get_option('waorder_rajaongkir_api_key'); ?>" class="regular-text"/>
                <div class="waorder-options-desc">Dapatkan api key rajaongkir Anda <a href="https://rajaongkir.com/akun/panel" target="_blank">di sini</a></div>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label><?php _e('Asal Pengiriman', 'waorder'); ?></label>
            </th>
            <td>
                <?php
                $origin_id = get_option('waorder_rajaongkir_origin_id');
                $origin_name = get_option('waorder_rajaongkir_origin_name');
                ?>
                <input type="hidden" name="waorder_rajaongkir_origin_id" value="<?php echo $origin_id; ?>"/>
                <input type="hidden" name="waorder_rajaongkir_origin_name" value="<?php echo $origin_name; ?>"/>
                <select class="regular-text get_sub_district" style="height:30px;">
                    <?php if( $origin_id & $origin_name ): ?>
                        <option selected="selected" value="<?php echo $origin_id; ?>"><?php echo $origin_name; ?></option>
                    <?php else: ?>
                        <option hidden="hidden" selected="selected" value="">Pilih Kota Asal Pengiriman</option>
                    <?php endif; ?>

                </select>
                <script>
                new SlimSelect({
                    select: '.get_sub_district',
                    placeholder: 'Kecamatan',
                    searchingText: 'Searching . . .',
                    ajax: function(search, callback){

                        if( search.length < 1 ){
                            callback('Ktik minimal 3 huruf');
                            return;
                        }

                        fetch('<?php echo admin_url('admin-ajax.php'); ?>?action=get_sub_district&nonce=<?php echo wp_create_nonce('noncenonce'); ?>&s='+search)
                        .then((respons) => respons.json())
                        .then(function(json){

                            let data = [];
                            for (let i = 0; i < json.length; i++) {
                                let city = json[i].type+' '+json[i].city;
                                if( json[i].type == 'Kabupaten' ){
                                    city = 'Kab. '+json[i].city;
                                }
                                let label = json[i].subdistrict_name+', '+city+', '+json[i].province;
                                let value = json[i].subdistrict_id+'-'+json[i].city_id;
                                data.push({text: label, value: value});
                            }

                            setTimeout(() => {
                                callback(data);
                            }, 100);
                        })
                        .catch(function(error){
                            callback(error);
                        })
                    },
                    onChange: (info) => {
                        document.querySelector('[name="waorder_rajaongkir_origin_id"]').value = info.value;
                        document.querySelector('[name="waorder_rajaongkir_origin_name"]').value = info.text;
                    }
                });
                </script>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label><?php _e('Type Akun', 'waorder'); ?></label>
            </th>
            <td>
                <select name="waorder_rajaongkir_account_type" class="regular-text rajaongkirtype">
                    <option value="starter" <?php if(get_option('waorder_rajaongkir_account_type') == 'starter' ){echo 'selected';}?>>Starter</option>
                    <option value="basic" <?php if(get_option('waorder_rajaongkir_account_type') == 'basic' ){echo 'selected';}?>>Basic</option>
                    <option value="pro" <?php if(get_option('waorder_rajaongkir_account_type') == 'pro' ){echo 'selected';}?>>Pro</option>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label><?php _e('Kurir', 'waorder'); ?></label>
            </th>
            <td style="position: relative;" class="waorder-cleafix">
                <?php
                $rajaongkir_account_type = get_option('waorder_rajaongkir_account_type');
                $rajaongkir_account_type = empty($rajaongkir_account_type) ? 'starter' : $rajaongkir_account_type;

                $kurir = get_option('waorder_rajaongkir_kurir') ? get_option('waorder_rajaongkir_kurir') : array();

                //__debug(get_option('waorder_rajaongkir_kurir'));
                ?>
                <label class="kurir starter">
                    <input name="waorder_rajaongkir_kurir[]" type="checkbox" value="pos" <?php echo ( in_array('pos', $kurir) ) ? 'checked="chekced"': ''; ?> />
                    <?php echo __('Pos') ?>
                </label>
                <label class="kurir starter">
                    <input name="waorder_rajaongkir_kurir[]" type="checkbox" value="jne" <?php echo ( in_array('jne', $kurir) ) ? 'checked="chekced"': ''; ?> />
                    <?php echo __('JNE') ?>
                </label>
                <label class="kurir starter">
                    <input name="waorder_rajaongkir_kurir[]" type="checkbox" value="tiki" <?php echo ( in_array('tiki', $kurir) ) ? 'checked="chekced"': ''; ?> />
                    <?php echo __('Tiki') ?>
                </label>

                <br/>
                <br/>
                <?php
                $basic = array(
                    array(
                        'id' => 'pcp',
                        'name' => 'Priority Cargo and Package',
                    ),
                    array(
                        'id' => 'esl',
                        'name' => 'Eka Sari Lorena',
                    ),
                    array(
                        'id' => 'rpx',
                        'name' => 'RPX Holding',
                    )
                )
                ?>

                <?php foreach( (array)$basic as $courier ): ?>
                    <label class="kurir">
                        <input class="basic" name="waorder_rajaongkir_kurir[]" type="checkbox" value="<?php echo $courier['id']; ?>" <?php echo ( in_array($courier['id'], $kurir) ) ? 'checked="chekced"': ''; ?> <?php if($rajaongkir_account_type == 'starter' ) { echo 'disabled="disabled"';} ?>/>
                        <?php echo $courier['name']; ?>
                    </label>
                <?php endforeach; ?>


                <br/>
                <br/>
                <?php
                $pro = array(
                    array(
                        'id' => 'pandu',
                        'name' => 'Pandu Logistics',
                    ),
                    array(
                        'id' => 'wahana',
                        'name' => 'Wahana Prestasi Logistik'
                    ),
                    array(
                        'id' => 'sicepat',
                        'name' => 'SiCepat Express',
                    ),
                    array(
                        'id' => 'jnt',
                        'name' => 'JnT Express',
                    ),
                    array(
                        'id' => 'pahala',
                        'name' => 'PAHALA KENCANA',
                    ),
                    array(
                        'id' => 'sap',
                        'name' => 'SAP Express',
                    ),
                    array(
                        'id' => 'jet',
                        'name' => 'JET Express',
                    ),
                    array(
                        'id'=> 'slis',
                        'name' => 'Solusi Express',
                    ),
                    array(
                        'id' => 'dse',
                        'name' => '21 Express'
                    ),
                    array(
                        'id' => 'first',
                        'name' => 'First Express',
                    ),
                    array(
                        'id' => 'ncs',
                        'name' => 'Nusantara Card Semesta',
                    ),
                    array(
                        'id' => 'star',
                        'name' => 'Star Cargo',
                    ),
                    array(
                        'id' => 'lion',
                        'name' => 'Lion Parcel',
                    ),
                    array(
                        'id' => 'ninja',
                        'name' => 'Ninja Express',
                    ),
                    array(
                        'id' => 'idl',
                        'name' => 'IDL Cargo',
                    ),
                    array(
                        'id' => 'rex',
                        'name' => 'Royal Express Indonesia'
                    )
                );
                ?>
                <?php foreach( (array)$pro as $courier ): ?>
                    <label class="kurir">
                        <input class="pro" name="waorder_rajaongkir_kurir[]" type="checkbox" value="<?php echo $courier['id']; ?>" <?php echo ( in_array($courier['id'], $kurir) ) ? 'checked="chekced"': ''; ?> <?php if($rajaongkir_account_type !== 'pro' ) { echo 'disabled="disabled"';} ?>/>
                        <?php echo $courier['name']; ?>
                    </label>
                <?php endforeach; ?>
            </td>
        </tr>
        <tr>
            <th scope="row">
            </th>
            <td>
                <button class="button button-primary" type="submit" name="submit"><?php echo __('Simpan Pengaturan', 'waorder'); ?></button>
            </td>
        </tr>
    </table>
    <?php
    $content = ob_get_contents();
    ob_end_clean();

    echo $content;
}

function waorder_rajaongkir_api_url(){

    $type = get_option('waorder_rajaongkir_account_type');

    $url = 'https://api.rajaongkir.com/starter/cost';

    if( $type == 'pro' ):
        $url = 'https://pro.rajaongkir.com/api/cost';
    elseif( $type == 'basic' ):
        $url = 'https://api.rajaongkir.com/basic/cost';
    endif;

    return $url;

}

function waorder_get_rajaongkir_ongkir($api_key, $account_type, $origin, $destination, $weight, $courier){

    if( empty($api_key) ) return false;

    if( empty($origin) || empty($destination) || empty($weight) || empty($courier) ) return false;

    $url = waorder_rajaongkir_api_url();

    $args = array(
        'headers' => array(
            'Content-Type' => 'application/x-www-form-urlencoded',
            'key' => $api_key,
        ),
        'body' => array(
            'origin'      => $origin,
            'destination' => $destination,
            'weight'      => $weight,
            'courier'     => $courier,
        )
    );

    if( $account_type == 'pro' ):
        $args['body']['originType'] = 'subdistrict';
        $args['body']['destinationType'] = 'subdistrict';
    endif;

    $res = wp_remote_post( $url, $args );

    if(is_wp_error($res) ) return false;

    $result = json_decode($res['body'], true);

    if( isset($result['rajaongkir']['status']['code']) && $result['rajaongkir']['status']['code'] == 200 ) :

        if( isset($result['rajaongkir']['results'][0]['costs']) ):

            $ongkirs = array();

            foreach( (array) $result['rajaongkir']['results'][0]['costs'] as $ongkir ):
                $courier = strtoupper($result['rajaongkir']['results'][0]['code']);
                $courier = str_replace('&', 'n', $courier);
                $ongkirs[] = array(
                    'courier' => $courier,
                    'service' => $ongkir['service'],
                    'value'   => $ongkir['cost'][0]['value'],
                    'etd'     => $ongkir['cost'][0]['etd'],
                );
            endforeach;

            return $ongkirs;

        endif;

    endif;

    return false;
}

//add_action('init', 'tests');
function tests(){

    if( is_admin() ) return;

    $api_key      = get_option('waorder_rajaongkir_api_key');
    $account_type = get_option('waorder_rajaongkir_account_type');
    $couriers     = get_option('waorder_rajaongkir_kurir');
    $origin_id    = explode('-', get_option('waorder_rajaongkir_origin_id'));

    if( $account_type == 'pro' ):
        $origin = isset($origin_id[0]) ? $origin_id[0] : '';
    else:
        $origin = isset($origin_id[1]) ? $origin_id[1] : '';
    endif;

    $destination_id = isset($_GET['destination']) ? sanitize_text_field($_GET['destination']) : '2495-177';
    $weight = isset($_GET['weight']) ? intval($_GET['weight']) : 1000;

    if( !$destination_id ) exit;

    $destination_id = explode('-', $destination_id);

    if( $account_type == 'pro' ):
        $destination = isset($destination_id[0]) ? $destination_id[0] : '';
    else:
        $destination = isset($destination_id[1]) ? $destination_id[1] : '';
    endif;


    $datas = array();

    foreach( $couriers as $key=>$val ):

        $data = waorder_get_rajaongkir_ongkir($api_key, $account_type, $origin, $destination, $weight, $val);

        if( is_array($data) ):
            $datas = array_merge((array)$data, $datas);
        endif;

    endforeach;

    __debug($datas);

    exit;
}

add_action( 'wp_ajax_get_ongkir', 'waorder_ajax_get_ongkir');
add_action( 'wp_ajax_nopriv_get_ongkir', 'waorder_ajax_get_ongkir');
function waorder_ajax_get_ongkir(){

    $nonce = isset($_REQUEST['nonce']) ? $_REQUEST['nonce'] : '';
    if( !wp_verify_nonce($nonce, 'noncenonce') ) exit;

    $api_key      = get_option('waorder_rajaongkir_api_key');
    $account_type = get_option('waorder_rajaongkir_account_type');
    $couriers     = get_option('waorder_rajaongkir_kurir');
    $origin_id    = explode('-', get_option('waorder_rajaongkir_origin_id'));

    if( $account_type == 'pro' ):
        $origin = isset($origin_id[0]) ? $origin_id[0] : '';
    else:
        $origin = isset($origin_id[1]) ? $origin_id[1] : '';
    endif;

    $destination_id = isset($_GET['destination']) ? sanitize_text_field($_GET['destination']) : '';
    $weight = isset($_GET['weight']) ? intval($_GET['weight']) : 1000;

    if( !$destination_id ) exit;

    $destination_id = explode('-', $destination_id);

    if( $account_type == 'pro' ):
        $destination = isset($destination_id[0]) ? $destination_id[0] : '';
    else:
        $destination = isset($destination_id[1]) ? $destination_id[1] : '';
    endif;


    $datas = array();

    foreach( $couriers as $key=>$val ):

        $data = waorder_get_rajaongkir_ongkir($api_key, $account_type, $origin, $destination, $weight, $val);

        if( is_array($data) ):
            $datas = array_merge((array)$data, $datas);
        endif;

    endforeach;

    if( !$datas ):
        echo 404;
        exit;
    endif;

    echo json_encode($datas);
    exit;

}



add_action( 'wp_ajax_get_sub_district', 'waorder_ajax_get_sub_district');
add_action( 'wp_ajax_nopriv_get_sub_district', 'waorder_ajax_get_sub_district');
function waorder_ajax_get_sub_district(){
    global $wp_filesystem;

    $nonce = isset($_REQUEST['nonce']) ? $_REQUEST['nonce'] : '';
    if( !wp_verify_nonce($nonce, 'noncenonce') ) exit;

    $search = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';

    $file_url  = WAORDER_URL . '/inc/subdistrict.json';
    $file_path = WAORDER_PATH . '/inc/subdistrict.json';

    try {
        require_once ABSPATH . 'wp-admin/includes/file.php';

        if ( is_null( $wp_filesystem ) ) {
            WP_Filesystem();
        }

        if ( ! $wp_filesystem instanceof WP_Filesystem_Base || ( is_wp_error( $wp_filesystem->errors ) && $wp_filesystem->errors->get_error_code() ) ) {
            throw new Exception( 'WordPress Filesystem Abstraction classes is not available', 1 );
        }

        if ( ! $wp_filesystem->exists( $file_path ) ) {
            throw new Exception( 'JSON file is not exists or unreadable', 1 );
        }

        $json = $wp_filesystem->get_contents( $file_path );
    } catch ( Exception $e ) {
        // Get JSON data by HTTP if the WP_Filesystem API procedure failed.
        $json = wp_remote_retrieve_body( wp_remote_get( esc_url_raw( $file_url ) ) );
    }

    if ( ! $json ) {
        return false;
    }

    $data = json_decode( $json, true );

    if ( 'No error' !== json_last_error_msg() || ! $data ) {
        return false;
    }

    if ( $search ) :
        $subdistricts = array();
        foreach ( $data as $row ) :
            if (stripos($row['subdistrict_name'], $search) !== false || stripos($row['city'], $search) !== false ):
                $subdistricts[] = $row;
            endif;
        endforeach;

        echo json_encode($subdistricts);
        exit;

    endif;

    echo json_encode($data);
    exit;

}


add_action('waorder_wa_form_after_address', 'waorder_wa_form_sub_district_field' );
function waorder_wa_form_sub_district_field(){

    if( get_option('waorder_feature_ongkir_enable') !== 'yes' ) return;

    if( get_option('waorder_ongkir_provider') !== 'rajaongkir' ) return;

    ob_start();
    ?>
    <table>
        <tr>
            <td>
                <div class="input">
                    <svg enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" width="20px" height="20px">
                        <path fill="rgba(0,0,0,.2)" d="m256 0c-102.24 0-185.43 83.182-185.43 185.43 0 126.89 165.94 313.17 173 321.04 6.636 7.391 18.222 7.378 24.846 0 7.065-7.868 173-194.15 173-321.04-2e-3 -102.24-83.183-185.43-185.43-185.43zm0 469.73c-55.847-66.338-152.04-197.22-152.04-284.3 0-83.834 68.202-152.04 152.04-152.04s152.04 68.202 152.04 152.04c-1e-3 87.088-96.174 217.94-152.04 284.3z"/>
                        <path fill="rgba(0,0,0,.2)" d="m256 92.134c-51.442 0-93.292 41.851-93.292 93.293s41.851 93.293 93.292 93.293 93.291-41.851 93.291-93.293-41.85-93.293-93.291-93.293zm0 153.19c-33.03 0-59.9-26.871-59.9-59.901s26.871-59.901 59.9-59.901 59.9 26.871 59.9 59.901-26.871 59.901-59.9 59.901z"/>
                    </svg>
                    <input type="hidden" name="subdistrict" value="">
                    <input type="hidden" name="subdistrict_id" value="">
                    <select id="getSubDistrict" required oninvalid="this.setCustomValidity('Tentukan kecamatan alamat Anda untuk penghitungan Ongkir')" oninput="this.setCustomValidity('')">
                        <option hidden="hidden" selected="selected" value="">Kecamatan</option>
                    </select>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.23.0/slimselect.min.js"></script>
                    <script>

                    new SlimSelect({
                        select: '#getSubDistrict',
                        placeholder: 'Kecamatan',
                        searchingText: 'Searching . . .',
                        ajax: function(search, callback){

                            if( search.length < 1 ){
                                callback('Ktik minimal 3 huruf');
                                return;
                            }

                            fetch('<?php echo admin_url('admin-ajax.php'); ?>?action=get_sub_district&nonce=<?php echo wp_create_nonce('noncenonce'); ?>&s='+search)
                            .then((respons) => respons.json())
                            .then(function(json){

                                let data = [];
                                for (let i = 0; i < json.length; i++) {
                                    let city = json[i].type+' '+json[i].city;
                                    if( json[i].type == 'Kabupaten' ){
                                        city = 'Kab. '+json[i].city;
                                    }
                                    let label = json[i].subdistrict_name+', '+city+', '+json[i].province;
                                    let value = json[i].subdistrict_id+'-'+json[i].city_id;
                                    data.push({text: label, value: value})
                                }

                                setTimeout(() => {
                                    callback(data);
                                }, 100);
                            })
                            .catch(function(error){
                                callback(error);
                            })
                        },
                        onChange: (info) => {
                            let form = document.getElementById('cartWa'),
                            weight = form.querySelector('[name="order_item_weight"]').value,
                            ongkirField = form.querySelector('#orderOngkir'),
                            orderSubTotal = form.querySelector('[name="order_sub_total"]').value,
                            orderTotal = form.querySelector('[name="order_total"]'),
                            orderCourier = form.querySelector('[name="order_courier"]'),
                            orderTotalView = form.querySelector('#orderTotal'),
                            loader = form.querySelector('.loader');

                            loader.innerHTML = 'Loading ....';

                            form.querySelector('[name="subdistrict"]').value = info.text;
                            form.querySelector('[name="subdistrict_id"]').value = info.value;

                            let url = '<?php echo admin_url('admin-ajax.php'); ?>?action=get_ongkir&nonce=<?php echo wp_create_nonce('noncenonce'); ?>&destination='+info.value+'&weight='+weight;

                            fetch(url)
                            .then((respons) => respons.json())
                            .then(function(json){
                                if( json == '404' ){
                                    alert('Gagal mendapatkan data ongkir, silahkan hubungi admin');
                                }else{
                                    ongkirField.options.length = 0;
                                    for (let i = 0; i < json.length; i++) {
                                        let name = main.currency.format(json[i].value)+' ( '+json[i].courier+' '+json[i].service+' )';
                                        ongkirField.options.add(new Option(name, json[i].value));
                                    }

                                    let total = parseInt(orderSubTotal) + parseInt(json[0].value);
                                    orderTotal.value = total;
                                    orderTotalView.innerHTML = main.currency.format(total);
                                    orderCourier.value = main.currency.format(json[0].value)+' ( '+json[0].courier+' '+json[0].service+' )';
                                    loader.style.display = 'none';
                                }

                            })
                            .catch(function(error){
                                console.log(error);
                            })
                        }
                    });
                    </script>
                </div>
            </td>
        </tr>
    </table>
    <?php
    $html = ob_get_contents();
    ob_end_clean();

    echo $html;
}

add_action('waorder_wa_form_before_total', 'waorder_wa_form_ongkir_field' );
function waorder_wa_form_ongkir_field(){

    if( get_option('waorder_feature_ongkir_enable') !== 'yes' ) return;

    if( get_option('waorder_ongkir_provider') !== 'rajaongkir' ) return;

    ob_start();
    ?>
    <div class="subtotal" style="margin-top: 10px;">
        <table>
            <tr>
                <td class="labelo">
                    Sub Total
                </td>
                <td class="valueo">
                    <span id="orderSubTotal" style="font-size:14px;color: #FF5050;font-weight: bold"></span>
                </td>
            <tr>
        </table>
    </div>
    <div class="subtotal">
        <table>
            <tr>
                <td class="labelo">
                    Ongkir
                </td>
                <td class="valueo">
                    <div class="input">
                        <svg enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" width="20px" height="20px">
                            <path fill="rgba(0,0,0,.2)" d="m471.04 378.18v-349.86h-380.86l-0.21 241.09h-89.978v214.27h121.19v-23.044h349.58c22.736 0 41.233-18.497 41.233-41.232-1e-3 -22.645-18.349-41.077-40.958-41.228zm-381.17-53.199v127.38h-58.556v-151.64h58.556v24.256zm171.8-265.35h28.701v41.56h-28.701v-41.56zm-140.2 0h108.88v72.876h91.332v-72.876h118.04v318.54h-161.04c-3.635 0-6.592-2.957-6.592-6.591s2.957-6.591 6.592-6.591h56.056c23.756 0 43.083-19.327 43.083-43.082 0-21.213-15.827-39.537-36.815-42.625l-48.765-7.17c-45.77-6.729-74.776-0.178-112.29 14.265l-58.701 25.154 0.22-251.9zm349.29 369.69h-349.58v-43.441h6e-3l0.036-40.269 70.253-30.115c38.287-14.714 60.804-17.611 96.211-12.402l48.765 7.169c5.732 0.844 10.055 5.849 10.055 11.642 0 6.489-5.279 11.766-11.767 11.766h-56.057c-20.902 0-37.908 17.005-37.908 37.907s17.006 37.907 37.908 37.907h192.08c5.469 0 9.918 4.449 9.918 9.918-1e-3 5.47-4.449 9.918-9.918 9.918z"/>
                        </svg>

                        <input type="hidden" name="order_courier" value="">
                        <select id="orderOngkir" name="order_ongkir" required oninvalid="this.setCustomValidity('Tentukan Ongkir')" oninput="this.setCustomValidity('')" onchange="chooseOngkir(this);">
                            <option hidden="hidden" selected="selected" value="">Pilih Kurir</option>
                            <option value="" disabled>Silahkan tentukan</option>
                            <option value="" disabled>kecamatan tujuan</option>
                            <option value="" disabled>terlebih dahulu</option>
                        </select>
                    </div>
                </td>
            <tr>
        </table>
    </div>
    <div class="loader">Tentukan kecamatan Anda</div>
    <?php
    $html = ob_get_contents();
    ob_end_clean();

    echo $html;
}
