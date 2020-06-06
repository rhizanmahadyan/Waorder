<?php

function waorder_create_cart_table(){
    global $wpdb;

    $table = $wpdb->prefix . 'waorder_cart';
    $sql = "CREATE TABLE IF NOT EXISTS {$table} (
      ID int(11) NOT NULL AUTO_INCREMENT,
      user_key varchar(255) NOT NULL,
      created datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
      updated datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
      PRIMARY KEY (ID)
    )";
    $wpdb->query($sql);
}

function waorder_create_cart_user_table(){
    global $wpdb;

    $table = $wpdb->prefix . 'waorder_cart_item';
    $sql = "CREATE TABLE IF NOT EXISTS {$table} (
      ID int(11) NOT NULL AUTO_INCREMENT,
      cart_id int(11) NOT NULL,
      product_id int(11) NOT NULL,
      quantity int(5) DEFAULT 1 NOT NULL,
      color varchar(255) NULL,
      custom_name varchar(255) NULL,
      custom_value varchar(255) NULL,
      PRIMARY KEY (ID)
    )";
    $wpdb->query($sql);
}

add_action('after_switch_theme', 'waorder_theme_activation');
function waorder_theme_activation() {

}
