<?php
/*
 *  Author: Taufik Hidayat
 *  URL: https://www.fiqhidayat.com
 */

 if(!function_exists('__debug')) :
    function __debug()
    {
 	   $bt     = debug_backtrace();
 	   $caller = array_shift($bt);
 	   ?><pre><?php
 	   print_r([
 		   "file"  => $caller["file"],
 		   "line"  => $caller["line"],
 		   "args"  => func_get_args()
 	   ]);
 	   ?></pre><?php
    }
 endif;

 define( 'WAORDER_SERVER', 'https://saungdigital.com/' );
 define( 'WAORDER_PATH', get_template_directory() );
 define( 'WAORDER_URL', get_template_directory_uri() );

/**
 * onclick update
 * @var [type]
 */
require 'update-checker/plugin-update-checker.php';
$waorderUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://bitbucket.org/fiqhid24/waorder',
	__FILE__,
	'waorder'
);

//Optional: If you're using a private repository, create an OAuth consumer
//and set the authentication credentials like this:
//Note: For now you need to check "This is a private consumer" when
//creating the consumer to work around #134:
// https://github.com/YahnisElsts/plugin-update-checker/issues/134
$waorderUpdateChecker->setAuthentication(array(
	'consumer_key' => 'Nm7DKVDLMdnQETuPV5',
	'consumer_secret' => 'WdawPVBZm2pWCCvPEZcJMRGCNpFhRu3H',
));

/*------------------------------------*\
	External Modules/Files
\*------------------------------------*/

require  get_template_directory() . '/inc/widget.php';
require  get_template_directory() . '/inc/product.php';
require  get_template_directory() . '/inc/product-import.php';
require  get_template_directory() . '/inc/order.php';
require  get_template_directory() . '/inc/slider.php';
require  get_template_directory() . '/inc/option.php';
require  get_template_directory() . '/inc/feature.php';
require  get_template_directory() . '/inc/ongkir.php';
require  get_template_directory() . '/inc/payment.php';
require  get_template_directory() . '/inc/form.php';

/*------------------------------------*\
	Theme Support
\*------------------------------------*/

add_action( 'after_setup_theme', 'waorder_setup' );
function waorder_setup(){
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    add_image_size('galery-icon', 200, 200, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');

    // Enables post and comment RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Localisation Support
    load_theme_textdomain('waorder', get_template_directory() . '/languages');

    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'waorder'), // Main Navigation
    ));
}

/*------------------------------------*\
	Functions
\*------------------------------------*/

/**
 * script for frontend
 * @var [type]
 */
add_action('wp_enqueue_scripts', 'waorder_scripts');
function waorder_scripts(){

    //wp_enqueue_style('waorder', get_template_directory_uri() . '/css/style.css', array(), strtotime('now'), 'all');
    //wp_enqueue_style('waorder-responsive', get_template_directory_uri() . '/css/responsive.css', array(), strtotime('now'), 'all');
    //wp_enqueue_style('slim-select', get_template_directory_uri() . '/css/slim-select.css', array(), strtotime('now'), 'all');


    if( !get_post_meta( get_the_ID(), '_elementor_edit_mode', true ) ):
        wp_deregister_script('jquery');
        wp_deregister_script( 'wp-embed' );
    endif;

    //wp_enqueue_script('waorder', get_template_directory_uri() . '/js/scripts.js', array(), strtotime('now'), true);
}

/**
 * script for backend
 * @var [type]
 */
add_action( 'admin_enqueue_scripts','waorder_admin_scripts' );
function waorder_admin_scripts() {

    wp_enqueue_style( 'waorder-admin', get_template_directory_uri() . '/css/admin.css', array(), strtotime('now'), 'all' );
    wp_enqueue_script( 'slim-select', 'https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.23.0/slimselect.min.js', [], strtotime('now'), false );
    wp_enqueue_script( 'waorder-admin', get_template_directory_uri() . '/js/admin.js', array('jquery','jquery-ui-core'), strtotime('now'), true );


}

/**
 * minify css code
 * @return [type] [description]
 */
function waorder_minify_script(){

	if( file_exists( get_template_directory() . '/css/style.min.css' ) ) return;

    ob_start();
    include_once(get_template_directory() . '/css/style.css');
    include_once(get_template_directory() . '/css/responsive.css');
    include_once(get_template_directory() . '/css/slim-select.css');
    //include_once( WPINC . '/css/dist/block-library/style.min.css' );
    $script = ob_get_contents();
    ob_end_clean();

    $buffer = $script;
    // Remove comments
    $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
    // Remove space after colons
    $buffer = str_replace(': ', ':', $buffer);
    // Remove whitespace
    $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
    // Write everything out

    $css = fopen(get_template_directory() . '/css/style.min.css', 'w');
    fwrite($css, $buffer);
    fclose($css);

    return;
}

/**
 * make css inline
 * @var [type]
 */
add_action( 'wp_head', 'waorder_head', 10);
function waorder_head(){
    waorder_minify_script();
    ?>
    <style type="text/css">
    <?php include(get_template_directory().'/css/style.min.css'); ?>
    <?php
    // include_once(get_template_directory() . '/css/style.css');
    // include_once(get_template_directory() . '/css/responsive.css');
    // include_once(get_template_directory() . '/css/slim-select.css');
    ?>
    </style>
    <script type='text/javascript'>
    /* <![CDATA[ */
    const main = {
        "site_url":"<?php echo site_url(); ?>",
        "ajax_url":"<?php echo admin_url('admin-ajax.php'); ?>",
        "currency": new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }),
        "nonce": "<?php echo wp_create_nonce('noncenonce'); ?>"
    };
    /* ]]> */
    </script>
    <?php
}

add_action( 'wp_footer', 'waorder_footer');
function waorder_footer(){
    ?>
    <?php $help = get_theme_mod('waorder_help_onoff'); ?>
    <?php if( $help !== 'hide' ): ?>
        <div class="contactwa" onclick="openHelpWA();">
            <div class="inner color-scheme-background">
                Butuh Bantuan ?
                <div class="iconwa color-scheme-background">
                    <i class="icon ion-logo-whatsapp"></i>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="formWaBox" id="cartWa">
        <div class="formWa" id="formWA">
            <div class="formWaBody" id="formWABody">
                <div class="heading clear">
                    <i class="icon ion-md-cart color-scheme-text"></i>
                    <h3><b>Keranjang</b> Belanja</h3>
                    <div class="close" onclick="closeOrderWA();">×</div>
                </div>
                <div class="items" id="cartItems">
                </div>
                <?php
                if( get_post_type(get_the_ID()) == 'product' ):
                    $ajax_url = get_the_permalink();
                else:
                    $ajax_url = admin_url('admin-ajax.php?action=order_form');
                endif;
                ?>
                <form class="form" method="post" enctype="multipart/form-data" onsubmit="orderWA(this); return false;" action="<?php echo $ajax_url; ?>" style="display:none">
                    <table>
                        <tr>
                            <td>
                                <div class="input">
                                    <i class="icon ion-md-person"></i>
                                    <input type="text" name="full_name" placeholder="Nama Lengkap" required oninvalid="this.setCustomValidity('Input Nama Lengkap Anda')" oninput="this.setCustomValidity('')">
                                </div>
                            </td>
                            <td>
                                <div class="input">
                                    <i class="icon ion-md-phone-portrait"></i>
                                    <input type="tel" name="phone" placeholder="Nomor Hp" pattern="[0-9]{9,13}" required oninvalid="this.setCustomValidity('Nomor Hp tidak valid!')" oninput="this.setCustomValidity('')">
                                </div>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td>
                                <div class="input">
                                    <textarea name="address" placeholder="Alamat Lengkap" required></textarea>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <?php do_action('waorder_wa_form_after_address'); ?>
                    <?php if (get_option('waorder_feature_payment_enable') == 'yes' ) : ?>
                        <table>
                            <tr>
                                <td>
                                    <div class="input dropdown">
                                        <i class="icon ion-md-cash"></i>
                                        <select required name="payment_type" oninvalid="this.setCustomValidity('Pilih Metode pmbayaran!')" oninput="this.setCustomValidity('')">
                                            <option hidden="hidden" selected="selected" value="">Metode Pembayaran</option>
                                            <optgroup label="Metode Pembayaran">
                                                <option value="Bank Transfer">Bank Transfer</option>
                                                <option value="COD (Cash On Delivery)">COD (Cash on Delivery)</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    <?php endif; ?>
                    <?php if( get_option('waorder_feature_ongkir_enable') !== 'yes' ): ?>
                        <div class="subtotal">
                            <table>
                                <tr>
                                    <td>
                                        <span style="font-weight: 400;font-style:italic;font-size:10px;">*Belum termasuk Ongkos kirim</span>
                                    </td>
                                <tr>
                            </table>
                        </div>
                    <?php endif; ?>
                    <?php do_action('waorder_wa_form_before_total'); ?>
                    <div class="subtotal">
                        <table>
                            <tr>
                                <td class="labelo">
                                    Total
                                </td>
                                <td class="valueo">
                                    <span id="orderTotal" style="font-size:18px;color: #FF5050;font-weight: bold;line-height: 25px;"></span>
                                </td>
                            <tr>
                        </table>
                    </div>
                    <table>
                        <tr>
                            <td>
                                <button id="sendWA" class="color-scheme-background" type="submit">
                                    <i class="icon ion-md-send"></i>
                                    Kirim
                                </button>
                            </td>
                        </tr>
                    </table>

                    <input type="hidden" name="order_item_weight" value="1000">
                    <input type="hidden" name="order_sub_total" value="">
                    <input type="hidden" name="order_total" value="">
                    <input type="hidden" name="admin_phone" value="<?php echo waorder_admin_phone(); ?>">
                    <input type="hidden" name="gretings" value="<?php echo get_theme_mod('waorder_greeting_message','Haloo Admin'); ?>">
                    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('waordernonce'); ?>"/>
                    <input type="hidden" name="order_key" value="<?php echo waorder_order_key_generator(); ?>"/>
                    <input type="hidden" name="multi_item_order" value="1"/>
                </form>
                <div id="cartEmpty" class="cart-empty">
                    <div class="cart-empty-inner">
                        <p>Ups, Belum ada barang di keranjang belanja Anda.</p>
                        <p>
                            <a href="<?php echo site_url(); ?>/product/" class="color-scheme-background">Belanja Sekarang !</a>
                        </p>
                    </div>
                </div>
                <div id="cartAdd" class="cart-add">
                    <div class="cart-add-inner">
                        <p>
                            <a class="color-scheme-background" onclick="openCartWA();">Lanjut Checkout</a>
                            <a href="<?php echo site_url(); ?>/product/" class="order-again-background">Belanja Lagi</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="formWaBox" id="helpViaWa">
        <div class="formWa" id="formHelpWA">
            <div class="formWaBody" id="formHelpWABody">
                <div class="heading clear">
                    <i class="icon ion-logo-whatsapp" style="color: #61ddbb"></i>
                    <h3><b>Form</b> Bantuan Whatsapp!</h3>
                    <div class="close" onclick="closeHelpWA();">×</div>
                </div>
                <form class="form" method="post" enctype="multipart/form-data" onsubmit="helpWA(this); return false;">
                    <table>
                        <tr>
                            <td>
                                <div class="input">
                                    <i class="icon ion-md-person"></i>
                                    <input type="text" name="full_name" placeholder="Nama Lengkap" required oninvalid="this.setCustomValidity('Input Nama Lengkap Anda')" oninput="this.setCustomValidity('')">
                                </div>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td>
                                <div class="input">
                                    <textarea name="message" placeholder="Pesan Anda"></textarea>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td>
                                <button class="color-scheme-background" type="submit">
                                    <i class="icon ion-md-send"></i>
                                    Kirim
                                </button>
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" name="destination" value="<?php echo waorder_admin_phone(); ?>">
                    <input type="hidden" name="gretings" value="<?php echo get_theme_mod('waorder_greeting_help_message', 'Haloo Admin'); ?>">
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    <?php include(get_template_directory().'/js/scripts.js'); ?>
    </script>
    <?php $pixel_id = get_theme_mod('waorder_fbpixel_id'); ?>
    <?php if( $pixel_id ): ?>
        <!-- Facebook Pixel Code -->
        <script>
          !function(f,b,e,v,n,t,s)
          {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
          n.callMethod.apply(n,arguments):n.queue.push(arguments)};
          if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
          n.queue=[];t=b.createElement(e);t.async=!0;
          t.src=v;s=b.getElementsByTagName(e)[0];
          s.parentNode.insertBefore(t,s)}(window, document,'script',
          'https://connect.facebook.net/en_US/fbevents.js');
          fbq('init', '<?php echo $pixel_id; ?>');
          fbq('track', 'PageView');
          var button = document.getElementById('sendWA');
          if( typeof(button) != 'undefined' && button != null ){
              button.addEventListener(
                'click',
                function() {
                    let form = document.getElementById('productData'),
                    product_name = form.querySelector('[name="order_item_name"]').value,
                    product_id = form.querySelector('[name="order_item_id"]').value,
                    product_price = form.querySelector('[name="order_item_price"]').value;
                    fbq('track', '<?php echo get_theme_mod('waorder_fbpixel_order_event', 'AddToCart'); ?>',{
                        content_name: product_name,
                        content_ids: [product_id],
                        content_type: 'product',
                        value: parseInt(product_price),
                        currency: 'IDR'
                    });
                },
                false
              );
          }
          <?php if( 'product' == get_post_type(get_the_ID()) ): ?>
                <?php
                $categories = get_the_terms(get_the_ID(), 'product-category');
                $cat = isset($categories[0]->name) ? $categories[0]->name : '';
                ?>
                fbq('track', 'ViewContent', {
                    content_ids: ['<?php echo get_the_ID(); ?>'],
                    content_type: 'product',
                    content_name: '<?php echo get_the_title(); ?>'
                });
          <?php endif; ?>
        </script>
        <noscript><img height="1" width="1" style="display:none"
          src="https://www.facebook.com/tr?id=<?php echo $pixel_id; ?>&ev=PageView&noscript=1"
        /></noscript>
        <!-- End Facebook Pixel Code -->
    <?php endif; ?>
    <?php
}

/**
 * get template directory url with wp cdn for static resource
 * @param  boolean $wp_cdn [description]
 * @return [string]          [description]
 */
function waorder_theme_url($wp_cdn = true){

    $url = get_template_directory_uri();
    if( $wp_cdn ){
        $url = str_replace('https://', 'https://i0.wp.com/', $url);
        $url = str_replace('http://', 'https://i0.wp.com/', $url);
    }

    return $url;
}

/**
 * random key generator
 * @return [type] [description]
 */
function waorder_order_key_generator() {
    $secret_key = 'waorder';
    $secret_iv = 'waorder';

    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $secret_key );
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );

    return base64_encode( openssl_encrypt( strtotime('now'), $encrypt_method, $key, 0, $iv ) );
}

/**
 * check if string is url or not
 * @param  [type]  $string [description]
 * @return boolean         [description]
 */
function waorder_is_url($string){

    $regex = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,6}(\/\S*)?/';

    if (preg_match($regex, $string, $url) ) return true;

    return false;
}

/**
 * get radnom admin phone
 * @return [type] [description]
 */
function waorder_admin_phone(){
    $phones = get_theme_mod('waorder_admin_phone');

    if( !$phones )return;

    $phones = explode(',',$phones);

    $key = array_rand($phones, 1);

    $whatsapp = isset($phones[$key]) ? $phones[$key] : '';

    $whatsapp = preg_replace('/[^0-9]/', '', $whatsapp);
    $whatsapp = preg_replace('/^620/','62', $whatsapp);
    $whatsapp = preg_replace('/^0/','62', $whatsapp);

    return $whatsapp;
}

/**
 * pagination for product
 * @param  string  $pages [description]
 * @param  integer $range [description]
 * @return [type]         [description]
 */
function waorder_product_pagination($pages = '', $range = 1){
    global $wp_query,$paged;

    $showitems = ($range * 2)+1;     // This is the items range, that we can pass it as parameter depending on your necessary.

    if(empty($paged)) $paged = 1;

    if($pages == '') {   // paged is not defined than its first page. just assign it first page.
        $pages = $wp_query->max_num_pages;
        if(!$pages)
           $pages = 1;
    }

    if(1 != $pages) { //For other pages, make the pagination work on other page queries
        echo '<div class="navigation">';
		//posts_nav_link(' ', __('Previous Page', 'pngtree'), __('Next Page', 'pngtree'));
        //if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
        if($paged > 1 && $showitems < $pages) echo '<a href="'.get_pagenum_link($paged - 1).'" class="prevnextlink">Sebelumnya</a>';

        for ($i=1; $i <= $pages; $i++)    {
            if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
                echo ($paged == $i)? "<span class='current color-scheme-background'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
        }

        if ($paged < $pages && $showitems < $pages) echo '<a href="'.get_pagenum_link($paged + 1).'" class="prevnextlink">Selanjutnya</a>';
        //if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
        echo '</div>';
    }
}

/**
 * pagination for post
 * @param  [type]  $query [description]
 * @param  string  $pages [description]
 * @param  integer $range [description]
 * @return [type]         [description]
 */
function waorder_post_pagination($query, $pages = '', $range = 1){
    global $wp_query, $paged;

    $showitems = ($range * 2)+1;     // This is the items range, that we can pass it as parameter depending on your necessary.

    if(empty($paged)) $paged = 1;

    if($pages == '') {   // paged is not defined than its first page. just assign it first page.
        $pages = $query === false ? $wp_query->max_num_pages : $query->max_num_pages;
        if(!$pages)
           $pages = 1;
    }

    if(1 != $pages) { //For other pages, make the pagination work on other page queries
        echo '<div class="navigation">';
		//posts_nav_link(' ', __('Previous Page', 'pngtree'), __('Next Page', 'pngtree'));
        //if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
        if($paged > 1 && $showitems < $pages) echo '<a href="'.get_pagenum_link($paged - 1).'" class="prevnextlink">Sebelumnya</a>';

        for ($i=1; $i <= $pages; $i++)    {
            if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
                echo ($paged == $i)? "<span class='current color-scheme-background'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
        }

        if ($paged < $pages && $showitems < $pages) echo '<a href="'.get_pagenum_link($paged + 1).'" class="prevnextlink">Selanjutnya</a>';
        //if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
        echo '</div>';
    }
}

/**
 * make low priority for yoast and aio seo meabox
 * @var [type]
 */
add_filter( 'wpseo_metabox_prio', 'waorder_seo_metabox_priority' );
add_filter( 'aioseop_post_metabox_priority', 'waorder_seo_metabox_priority' );
function waorder_seo_metabox_priority($prio) {
	//* Accepts 'high', 'default', 'low'. Default is 'high'.
	return 'low';
}

/**
 * modify query for homepage and product post
 * @var [type]
 */
add_action( 'pre_get_posts','waorder_query_filter', 10 );
function waorder_query_filter($query){

    if( is_admin() ) return;

    if( is_home() ) return;

    if( is_singular() ) return;

    if( 'product' == $query->get('post_type') || is_tax('product-category') && 'nav_menu_item' !== $query->get('post_type') ):

        if( isset($_GET['filter']) ):

            $filter = sanitize_text_field($_GET['filter']);
            $meta_query = $query->get('meta_query');

            if( in_array($filter, ['termurah', 'termahal']) ):

                $meta_query = array(
                    'key' => 'product_price',
                    'compare' => 'EXISTS',
                    'type' => 'NUMERIC',
                );
                $query->set('meta_query',array($meta_query));
                $query->set('orderby', 'meta_value_num');

                if( $filter == 'termurah' ):
                    $query->set('order', 'ASC');
                else:
                    $query->set('order', 'DESC');
                endif;

            endif;

        endif;

        $query->set('posts_per_page', get_theme_mod('waorder_product_per_page', '15'));

    endif;
}

/**
 * get current url variable
 * @param  string $var_key [description]
 * @param  string $var_val [description]
 * @return [type]          [description]
 */
function waorder_get_current_variables($var_key = '', $var_val = ''){

    $vars = array();

    foreach( (array) $_GET as $key=>$val ):
        $vars[sanitize_text_field($key)] = sanitize_text_field($val);
    endforeach;

    if( $var_key && $var_val ):
        $vars[$var_key] = $var_val;
    elseif( $var_key && empty($var_val) ):
        unset($vars[$var_key]);
    endif;

    return http_build_query($vars);
}

/**
 * product filter dropdown
 * @return [type] [description]
 */
function waorder_product_filter_dropdown(){
    global $wp;

    $site_url = home_url( $wp->request );
    ob_start();
    ?>
    <select class="color-scheme-border" onchange="productsFilter(this);">
        <?php
        $filter = isset($_GET['filter']) ? $_GET['filter'] : '';
        ?>
        <optgroup label="Urutkan :">
            <option value="<?php echo $site_url; ?>/?<?php echo waorder_get_current_variables('filter','terbaru'); ?>" <?php if($filter == 'terbaru' ){echo 'selected="selected"'; }?>>Terbaru</option>
            <option value="<?php echo $site_url; ?>/?<?php echo waorder_get_current_variables('filter','termurah'); ?>" <?php if($filter == 'termurah' ){echo 'selected="selected"'; }?>>Termurah</option>
            <option value="<?php echo $site_url; ?>/?<?php echo waorder_get_current_variables('filter','termahal'); ?>" <?php if($filter == 'termahal' ){echo 'selected="selected"'; }?>>Termahal</option>
        </optgroup>
    </select>
    <?php
    $html= ob_get_contents();
    ob_end_clean();

    return $html;
}

/**
 * license checking
 * @param  [type] $license [description]
 * @param  [type] $email   [description]
 * @return [type]          [description]
 */
function waorder_license($license, $email){

    $server = WAORDER_SERVER . 'check/license';
    $domain = preg_replace('(^https?://)', '', site_url() );

    $fields = array(
        'key'     => 'nullmasterinbabaitoorg',
        'email'   => 'nullmaster@babiato.org',
        'string'  => $domain,
    );

    $response = 200;

   
    return json_decode($response['body'], true);
}

/**
 * lisense post
 * @var [type]
 */
add_action('admin_init', 'waorder_admin_init', 10 );
function waorder_admin_init(){
    
        $data = array(
            'email' => 'nullmaster@babiato.org',
            'code' => 'nullmasterinbabiatoorg',
        );
        update_option('waorderlislisdata', $data);
   

    if( isset($_GET['waorderflush']) && $_GET['waorderflush'] ==  'true' ):
        flush_rewrite_rules();
    endif;
}

/**
 * license manage
 * @return boolean [description]
 */
function waorder_lislis(){

    $transient = get_transient('waorderlislis');

    
        $data = get_option('waorderlislisdata');


        $result = waorder_license('nullmasterinbabiatoorg', 'nullmaster@babiato.org');

       

            
                set_transient('waorderlislis', 'active', 3000 * DAY_IN_SECONDS);
           
        $transient = get_transient('waorderlislis');
   

    return $transient;

}

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}

// Custom Excerpts
function waorder_index($length) // Create 20 Word Callback for Index page Excerpts, call using waorder_excerpt('waorder_index');
{
    return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using waorder_excerpt('waorder_custom_post');
function waorder_custom_post($length)
{
    return 40;
}

// Create the Custom Excerpts callback
function waorder_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}

// Remove Admin bar
function remove_admin_bar()
{
    return false;
}

/**
 * mofidy img tag in post content
 * @var [type]
 */
add_filter('the_content', 'waorder_the_content', 11);
function waorder_the_content($content){

    $img_pattern = '/<img.*?[^\>]+>/si';

    $iframe_pattern = '/<iframe.*?s*src="(.*?)".*?<\/iframe>/si';

    $content = preg_replace_callback($img_pattern, 'waorder_content_img', $content);

    //$content = preg_replace_callback($iframe_pattern, 'waorder_content_iframe', $content);

    return $content;
}
// function waorder_content_iframe($iframe){
//     __debug($iframe);
//
//     $src   = isset($iframe[1]) ? $iframe[1] : '';
//
//     $var = explode('/', $src);
//     $var = explode('?', $var[4]);
//
//     $tag = str_replace('src', 'data-src', $iframe[0]);
//     $tag = str_replace('iframe', 'iframe poster="https://img.youtube.com/vi/'.$var[0].'/0.jpg"', $tag);
//
//     // $tag = '<iframe class="lazy" width="100%" height="auto" data-src="'.$src.'" poster="https://img.youtube.com/vi/'.$var[0].'/0.jpg" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>';
//     // $tag .= '<noscript><iframe width="100%" height="auto" src="'.$src.'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe></noscript>';
//
//     return $tag;
// }


function waorder_content_img($img){

    $regex = '/.class=./si';

    if( preg_match($regex, $img[0], $m) ):
        $new_img = str_replace('class="', 'class="lazy"', $img[0]);
        $new_img = str_replace('src="', 'data-src="', $new_img);

    else:
        $new_img = str_replace('<img ', '<img class="lazy ', $img[0]);
        $new_img = str_replace('src="', 'data-src="', $new_img);
    endif;


    return $new_img;
}

function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// Custom Gravatar in Settings > Discussion
function waorder_gravatar ($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}

// Custom Comments Callback
function waorder_comments($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment-author vcard">
	<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment ); ?>
	</div>
<?php if ($comment->comment_approved == '0') : ?>
	<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
	<br />
<?php endif; ?>

	<div class="comment-meta"><span class="author-name"><?php echo get_comment_author_link(); ?></span> on <?php printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?>
	</div>
    <div class="comment-text"><?php comment_text() ?></div>
	<div class="reply">
	<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php }

/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

remove_action('wp_head', 'rest_output_link_wp_head', 10);

 // Disable oEmbed Discovery Links
remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);

 // Disable REST API link in HTTP headers
remove_action('template_redirect', 'rest_output_link_header', 11, 0);

remove_action('wp_head', 'wlwmanifest_link');

remove_action('wp_head', 'rsd_link');

// Add Filters
add_filter('avatar_defaults', 'waorder_gravatar'); // Custom Gravatar in Settings > Discussion
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)

add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether
