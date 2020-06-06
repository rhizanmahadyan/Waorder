<?php
add_action('admin_init', 'waorder_feature_save_action');
function waorder_feature_save_action(){

    if( !isset($_POST['__waorderfeaturenonce']) ) return;

    if( ! wp_verify_nonce( $_POST['__waorderfeaturenonce'], 'noncenonce' ) ) return;

    $data = $_POST;

    unset($data['__waorderfeaturenonce']);

    foreach( (array)$data as $key => $value) {
        if( is_array($value) ):
            update_option( $key, $value );
        else:
            update_option( $key, wp_kses_post( stripcslashes( $value ) ) );
        endif;
    }
}

add_action( 'admin_menu','waorder_feature_admin_menu' );
function waorder_feature_admin_menu(){
    add_menu_page( 'Waorder', 'Waorder', 'manage_options', 'waorder', 'waorder_feature_options_page', 'dashicons-portfolio', 30);
}

function waorder_feature_options_page(){

    $tabs = array(
        'ongkir' => __('Ongkir', 'waorder'),
        'payment' => __('Pembayaran', 'waorder'),
    );

    $tabs = apply_filters('waorder_feature_tabs', $tabs);

    $current_tab = (isset($_GET['tab']) && array_key_exists($_GET['tab'], $tabs)) ? trim($_GET['tab']) : 'ongkir';

    $sections = array(
        'general' => 'General',
    );

    $sections = apply_filters('waorder_feature_tab_section', $sections, $current_tab);

    $current_section = (isset($_GET['section']) && array_key_exists($_GET['section'], $sections)) ? trim($_GET['section']) : 'general';

    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline"><?php echo esc_html( __( 'Waorder Feature', 'waorder' ) ); ?></h1>

        <h2 class="nav-tab-wrapper wp-clearfix">
            <?php foreach ($tabs as $url => $title) : ?>
                <a href="<?php echo add_query_arg('tab', $url); ?>" class="nav-tab <?php echo ($current_tab === $url) ? 'nav-tab-active' : '' ?>">
                    <?php echo $title ?>
                </a>
            <?php endforeach; ?>
        </h2>

        <div class="waorder-clearfix" style="position:relative;width: 100%;margin-bottom: 10px;">
            <ul class="subsubsub">
                <?php foreach( $sections as $key=>$value ): ?>
                    <li>
                        <a href="<?php echo add_query_arg('section', $key); ?>" <?php echo ($current_section === $key) ? 'class="current"' : ''; ?>><?php echo $value; ?></a> |
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <hr class="wp-header-end">
        <div class="waorder-feature">
            <form action="" method="post" enctype="multipart/form-data">
                <?php wp_nonce_field('noncenonce', '__waorderfeaturenonce', false); ?>
                <?php do_action('waorder_feature_option_page_'.$current_tab.'_'.$current_section);?>
            </form>
        </div>
    </div>
    <?php
}
