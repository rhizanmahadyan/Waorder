<?php

add_filter('waorder_feature_tab_section','waorder_payment_tab_section', 10 , 2 );
function waorder_payment_tab_section($sections, $current_tab){
    if( $current_tab == 'payment' ):
        $sections = apply_filters('waorder_feature_tab_section_ongkir', $sections);
    endif;

    return $sections;
}

add_action('waorder_feature_option_page_payment_general', 'waorder_payment_options_page_general' );
function waorder_payment_options_page_general(){
    ob_start();
    ?>
    <table>
        <tr>
            <th scope="row">
                <label><?php _e('Aktifkan Fitur Pilihan Pembayaran ?', 'waorder'); ?></label>
            </th>
            <td>
                <input name="waorder_feature_payment_enable" type="hidden" value="no"/>
                <input name="waorder_feature_payment_enable" type="checkbox" value="yes" <?php echo ( 'yes' == get_option('waorder_feature_payment_enable')) ? 'checked="chekced"': ''; ?> />
                <?php echo __('Aktifkan Fitur Pilihan Pembayaran') ?>
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
