<?php

add_action( 'widgets_init', 'waorder_widget_init' );
function waorder_widget_init(){

    // /if( waorder_lislis() !== 'active' ) return;

    // Define Sidebar Widget Area 1
    register_sidebar(array(
        'name'          => __('Post Sidebar', 'waorder'),
        'description'   => __('Blogpost sidebar', 'waorder'),
        'id'            => 'widget-post-1',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>'
    ));

    register_sidebar(array(
        'name'          => __('Footer Widget 1', 'waorder'),
        'description'   => __('Footer widget on lef position', 'waorder'),
        'id'            => 'footer-widget-1',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>'
    ));

    register_sidebar(array(
        'name'          => __('Footer Widget 2', 'waorder'),
        'description'   => __('Footer widget on center position', 'waorder'),
        'id'            => 'footer-widget-2',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>'
    ));

    register_sidebar(array(
        'name'          => __('Footer Widget 3', 'waorder'),
        'description'   => __('Footer widget on right position', 'waorder'),
        'id'            => 'footer-widget-3',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>'
    ));

    register_widget( 'Waorder_About_Widget' );
    register_widget( 'Waorder_Payment_widget' );
    register_widget( 'Waorder_Shipping_widget' );
    register_widget( 'Waorder_Contact_widget' );

}

class Waorder_About_Widget extends WP_Widget {

    /**
     * construction
     */
    public function __construct() {

        parent::__construct(
            'waorder_about',
            __('Waorder About','waorder'),
            array(
                'description' => __( 'About or address your store', 'waorder' )
            )
        );

    }

    // Creating widget front-end
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if ( ! empty( $title ) )
        echo $args['before_title'] . $title . $args['after_title'];

        ?>
        <div class="widget-content">
            <?php echo $instance['content']; ?>
        </div>
        <?php
        echo $args['after_widget'];
    }

    // Widget Backend
    public function form( $instance ) {
        $title = isset( $instance[ 'title' ]) ? $instance[ 'title' ] : 'Toko WA Order';
        $content = isset($instance['content']) ? $instance['content'] : 'Jl. Tentara Pelajar</br>Jakarta Selatan 22222';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />

            <label for="<?php echo $this->get_field_id( 'content' ); ?>"><?php _e( 'Content:' ); ?></label>
            <textarea id="<?php echo $this->get_field_id( 'content' ); ?>" name="<?php echo $this->get_field_name( 'content' ); ?>" class="widefat"><?php echo esc_textarea( $content ); ?></textarea>
        </p>
        <?php
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['content'] = wp_kses_post($new_instance['content']);
        return $instance;
    }

}

class Waorder_Contact_Widget extends WP_Widget {

    private $default = array(
        'title'        => 'Jam Operasional',
        'working_hour' => '<strong>Senin - Sabtu</strong> ( 07.00 s/d 15.00 )',
    );

    /**
     * construction
     */
    public function __construct() {

        parent::__construct(
            'waorder_contact',
            __('Waorder Contact','waorder'),
            array(
                'description' => __( 'Contact Detail', 'waorder' )
            )
        );

    }

    // Creating widget front-end
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );

        echo $args['before_widget'];
        if ( ! empty( $title ) )
        echo $args['before_title'] . $title . $args['after_title'];

        // $whatsapp = $instance['whatsapp'];
        //
        // $whatsapp = preg_replace('/[^0-9]/', '', $whatsapp);
		// $whatsapp = preg_replace('/^620/','62', $whatsapp);
		// $whatsapp = preg_replace('/^0/','62', $whatsapp);

        ?>
        <div class="widget-content">
            <!---<div class="btn">
                <a class="color-scheme-background-hover" onclick="openHelpWA('</?php echo $whatsapp; ?>');">
                    <i class="icon ion-logo-whatsapp"></i>
                    <small>WhatsApp</small>
                </a>
                </a>
            </div>--->
            <div class="working_hour">
                <?php echo $instance['working_hour']; ?>
            </div>
        </div>
        <?php
        echo $args['after_widget'];
    }

    // Widget Backend
    public function form( $instance ) {
        $instance = wp_parse_args($instance, $this->default);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />

            <!---<label for="</?php echo $this->get_field_id( 'whatsapp' ); ?>"></?php _e( 'Whatsapp:' ); ?></label>
            <input class="widefat" id="</?php echo $this->get_field_id( 'whatsapp' ); ?>" name="</?php echo $this->get_field_name( 'whatsapp' ); ?>" type="text" value="</?php echo esc_attr( $instance['whatsapp'] ); ?>" />--->

            <label for="<?php echo $this->get_field_id( 'working_hour' ); ?>"><?php _e( 'Jam Kerja:' ); ?></label>
            <textarea id="<?php echo $this->get_field_id( 'working_hour' ); ?>" name="<?php echo $this->get_field_name( 'working_hour' ); ?>" class="widefat"><?php echo esc_textarea( $instance['working_hour'] ); ?></textarea>
        </p>
        <?php
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['working_hour'] = wp_kses_post($new_instance['working_hour']);
        return $instance;
    }

}

class Waorder_Shipping_Widget extends WP_Widget {

    private $default = array(
        'title'   => 'Pengiriman',
        'gosend'  => 'on',
        'pos'     => 'on',
        'grab'    => 'on',
        'jne'     => 'on',
        'jnt'     => 'on',
        'tiki'    => 'on',
        'wahana'  => 'on',
        'sicepat' => 'on',
    );

    /**
     * construction
     */
    public function __construct() {

        parent::__construct(
            'waorder_shipping',
            __('Waorder Shipping','waorder'),
            array(
                'description' => __( 'Shipping Service Logo Widget', 'waorder' )
            )
        );

    }

    // Creating widget front-end
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if ( ! empty( $title ) )
        echo $args['before_title'] . $title . $args['after_title'];

        ?>
        <div class="widget-content">
            <ul>
                <?php  if( 'on' == $instance[ 'pos' ] ) : ?>
                    <li class="lazy" data-bg="url(<?php echo waorder_theme_url(); ?>/img/posindonesia.png)"></li>
                <?php endif; ?>
                <?php  if( 'on' == $instance[ 'gosend' ] ) : ?>
                    <li class="lazy" data-bg="url(<?php echo waorder_theme_url(); ?>/img/gosend.png)"></li>
                <?php endif; ?>
                <?php  if( 'on' == $instance[ 'grab' ] ) : ?>
                    <li class="lazy" data-bg="url(<?php echo waorder_theme_url(); ?>/img/grabexpress.png)"></li>
                <?php endif; ?>
                <?php  if( 'on' == $instance[ 'jne' ] ) : ?>
                    <li class="lazy" data-bg="url(<?php echo waorder_theme_url(); ?>/img/jne.png)"></li>
                <?php endif; ?>
                <?php  if( 'on' == $instance[ 'jnt' ] ) : ?>
                    <li class="lazy" data-bg="url(<?php echo waorder_theme_url(); ?>/img/jnt.png)"></li>
                <?php endif; ?>
                <?php  if( 'on' == $instance[ 'tiki' ] ) : ?>
                    <li class="lazy" data-bg="url(<?php echo waorder_theme_url(); ?>/img/tiki.png)"></li>
                <?php endif; ?>
                <?php  if( 'on' == $instance[ 'wahana' ] ) : ?>
                    <li class="lazy" data-bg="url(<?php echo waorder_theme_url(); ?>/img/wahana.png)"></li>
                <?php endif; ?>
                <?php  if( 'on' == $instance[ 'sicepat' ] ) : ?>
                    <li class="lazy" data-bg="url(<?php echo waorder_theme_url(); ?>/img/sicepat.png)"></li>
                <?php endif; ?>

            </ul>
        </div>
        <?php
        echo $args['after_widget'];
    }

    // Widget Backend
    public function form( $instance ) {
        $instance = wp_parse_args($instance, $this->default);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
            <br/>
            <br/>
            <input type="checkbox" id="<?php echo $this->get_field_id( 'gosend' ); ?>" name="<?php echo $this->get_field_name( 'gosend' ); ?>" class="widefat" <?php checked( $instance[ 'gosend' ], 'on' ); ?>><?php echo __('Enable Gosend'); ?><br/>

            <input type="checkbox" id="<?php echo $this->get_field_id( 'pos' ); ?>" name="<?php echo $this->get_field_name( 'pos' ); ?>" class="widefat" <?php checked( $instance[ 'pos' ], 'on' ); ?>><?php echo __('Enable Pos'); ?><br/>

            <input type="checkbox" id="<?php echo $this->get_field_id( 'grab' ); ?>" name="<?php echo $this->get_field_name( 'grab' ); ?>" class="widefat" <?php checked( $instance[ 'grab' ], 'on' ); ?>><?php echo __('Enable Grab'); ?><br/>

            <input type="checkbox" id="<?php echo $this->get_field_id( 'jne' ); ?>" name="<?php echo $this->get_field_name( 'jne' ); ?>" class="widefat" <?php checked( $instance[ 'jne' ], 'on' ); ?>><?php echo __('Enable JNE'); ?><br/>

            <input type="checkbox" id="<?php echo $this->get_field_id( 'jnt' ); ?>" name="<?php echo $this->get_field_name( 'jnt' ); ?>" class="widefat" <?php checked( $instance[ 'jnt' ], 'on' ); ?>><?php echo __('Enable J&T'); ?><br/>

            <input type="checkbox" id="<?php echo $this->get_field_id( 'tiki' ); ?>" name="<?php echo $this->get_field_name( 'tiki' ); ?>" class="widefat" <?php checked( $instance[ 'tiki' ], 'on' ); ?>><?php echo __('Enable Tiki'); ?><br/>

            <input type="checkbox" id="<?php echo $this->get_field_id( 'wahana' ); ?>" name="<?php echo $this->get_field_name( 'wahana' ); ?>" class="widefat" <?php checked( $instance[ 'wahana' ], 'on' ); ?>><?php echo __('Enable Wahana'); ?><br/>

            <input type="checkbox" id="<?php echo $this->get_field_id( 'sicepat' ); ?>" name="<?php echo $this->get_field_name( 'sicepat' ); ?>" class="widefat" <?php checked( $instance[ 'sicepat' ], 'on' ); ?>><?php echo __('Enable Sicepat'); ?><br/>
        </p>
        <?php
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title']   = strip_tags( $new_instance['title'] );
        $instance['pos']  = sanitize_text_field($new_instance['pos']);
        $instance['gosend']  = sanitize_text_field($new_instance['gosend']);
        $instance['grab']    = sanitize_text_field($new_instance['grab']);
        $instance['jne']     = sanitize_text_field($new_instance['jne']);
        $instance['jnt']     = sanitize_text_field($new_instance['jnt']);
        $instance['tiki']    = sanitize_text_field($new_instance['tiki']);
        $instance['wahana']  = sanitize_text_field($new_instance['wahana']);
        $instance['sicepat'] = sanitize_text_field($new_instance['sicepat']);
        return $instance;
    }

}

class Waorder_Payment_Widget extends WP_Widget {


    private $default = array(
        'title'   => 'Pembayaran',
        'bca'     => 'on',
        'bni'     => 'on',
        'bri'     => 'on',
        'mandiri' => 'on',
    );

    /**
     * construction
     */
    public function __construct() {

        parent::__construct(
            'waorder_payment',
            __('Waorder Payment','waorder'),
            array(
                'description' => __( 'Bank Logo Widget', 'waorder' )
            )
        );

    }

    // Creating widget front-end
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if ( ! empty( $title ) )
        echo $args['before_title'] . $title . $args['after_title'];

        ?>
        <div class="widget-content">
            <ul>
                <?php  if( 'on' == $instance[ 'bca' ] ) : ?>
                    <li class="lazy" data-bg="url(<?php echo waorder_theme_url(); ?>/img/bca.png)"></li>
                <?php endif; ?>
                <?php  if( 'on' == $instance[ 'bni' ] ) : ?>
                    <li class="lazy" data-bg="url(<?php echo waorder_theme_url(); ?>/img/bni.png)"></li>
                <?php endif; ?>
                <?php  if( 'on' == $instance[ 'bri' ] ) : ?>
                    <li class="lazy" data-bg="url(<?php echo waorder_theme_url(); ?>/img/bri.png)"></li>
                <?php endif; ?>
                <?php  if( 'on' == $instance[ 'mandiri' ] ) : ?>
                    <li class="lazy" data-bg="url(<?php echo waorder_theme_url(); ?>/img/mandiri.png)"></li>
                <?php endif; ?>

            </ul>
        </div>
        <?php
        echo $args['after_widget'];
    }

    // Widget Backend
    public function form( $instance ) {
        $instance = wp_parse_args( $instance, $this->default);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
            <br/>
            <br/>
            <input type="checkbox" id="<?php echo $this->get_field_id( 'bca' ); ?>" name="<?php echo $this->get_field_name( 'bca' ); ?>" class="widefat" <?php checked( $instance[ 'bca' ], 'on' ); ?>><?php echo __('Enable BCA'); ?><br/>
            <input type="checkbox" id="<?php echo $this->get_field_id( 'bni' ); ?>" name="<?php echo $this->get_field_name( 'bni' ); ?>" class="widefat" <?php checked( $instance[ 'bni' ], 'on' ); ?>><?php echo __('Enable BNI'); ?><br/>
            <input type="checkbox" id="<?php echo $this->get_field_id( 'bri' ); ?>" name="<?php echo $this->get_field_name( 'bri' ); ?>" class="widefat" <?php checked( $instance[ 'bri' ], 'on' ); ?>><?php echo __('Enable BRI'); ?><br/>
            <input type="checkbox" id="<?php echo $this->get_field_id( 'mandiri' ); ?>" name="<?php echo $this->get_field_name( 'mandiri' ); ?>" class="widefat" <?php checked( $instance[ 'mandiri' ], 'on' ); ?>><?php echo __('Enable Mandiri'); ?><br/>
        </p>
        <?php
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['bca'] = sanitize_text_field($new_instance['bca']);
        $instance['bni'] = sanitize_text_field($new_instance['bni']);
        $instance['bri'] = sanitize_text_field($new_instance['bri']);
        $instance['mandiri'] = sanitize_text_field($new_instance['mandiri']);
        return $instance;
    }

}
