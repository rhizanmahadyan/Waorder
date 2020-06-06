<?php
/**
 * Contains methods for customizing the theme customization screen.
 *
 * @link http://codex.wordpress.org/Theme_Customization_API
 * @since waorder 1.0.0
 */
class WaOrder_Customize {

    /**
     * register
     * @param  [type] $wp_customize [description]
     * @return [type]               [description]
     */
    public static function register ( $wp_customize ) {

        if( waorder_lislis() !== 'active' ) return;
        $wp_customize->add_section(
            'waorder_general_section',
            array(
                'title'       => __( 'General', 'waorder' ), //Visible title of section
                'priority'    => 35, //Determines what order this appears in
                'capability'  => 'edit_theme_options', //Capability needed to tweak
                'description' => __('General Section', 'waorder'), //Descriptive tooltip
            )
        );

        $wp_customize->add_section(
            'waorder_color_section',
            array(
                'title'       => __( 'Color', 'waorder' ), //Visible title of section
                'priority'    => 35, //Determines what order this appears in
                'capability'  => 'edit_theme_options', //Capability needed to tweak
                'description' => __('Color Section', 'waorder'), //Descriptive tooltip
            )
        );

        $wp_customize->add_section(
            'waorder_featured_section',
            array(
                'title'       => __( 'Featured', 'waorder' ), //Visible title of section
                'priority'    => 35, //Determines what order this appears in
                'capability'  => 'edit_theme_options', //Capability needed to tweak
                'description' => __('Featured Section', 'waorder'), //Descriptive tooltip
            )
        );

        $wp_customize->add_section(
            'waorder_social_section',
            array(
                'title'       => __( 'Socials Link', 'waorder' ), //Visible title of section
                'priority'    => 35, //Determines what order this appears in
                'capability'  => 'edit_theme_options', //Capability needed to tweak
                'description' => __('Socials Section', 'waorder'), //Descriptive tooltip
            )
        );

        $wp_customize->add_section(
            'waorder_copyright_section',
            array(
                'title'       => __( 'Copyright', 'waorder' ), //Visible title of section
                'priority'    => 35, //Determines what order this appears in
                'capability'  => 'edit_theme_options', //Capability needed to tweak
                'description' => __('Copyright Section', 'waorder'), //Descriptive tooltip
            )
        );

        $wp_customize->add_setting(
            'waorder_logo',
            array(
                'default'    => get_template_directory_uri() .'/img/logos.png', //Default setting/value to save
                'type'       => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
                'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
                'transport'  => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                'waorder_logo_upload',
                array(
                    'label'      => __( 'Logo', 'waorder' ), //Admin-visible name of the control
                    'settings'   => 'waorder_logo', //Which setting to load and manipulate (serialized is okay)
                    'priority'   => 10, //Determines the order this control appears in for the specified section
                    'section'    => 'waorder_general_section', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
                )
            )
        );

        $wp_customize->add_setting(
            'waorder_admin_phone',
            array(
                'default'    => '', //Default setting/value to save
                'type'       => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
                'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
                'transport'  => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'waorder_admin_phone_input',
                array(
                    'label'      => __( 'Nomor Whatsapp Admin', 'waorder' ), //Admin-visible name of the control
                    'settings'   => 'waorder_admin_phone', //Which setting to load and manipulate (serialized is okay)
                    'priority'   => 10, //Determines the order this control appears in for the specified section
                    'section'    => 'waorder_general_section',
                    'type' => 'textarea',
                    'description' => 'Jika Nomor whatsapp lebih dari satu, pisahkan dengan koma, contoh: 6298123456789,6281123456789 dan seterusnya',
                )
            )
        );

        $wp_customize->add_setting(
            'waorder_greeting_message',
            array(
                'default'    => 'Haloo Admin', //Default setting/value to save
                'type'       => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
                'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
                'transport'  => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'waorder_greeting_message_input',
                array(
                    'label'      => __( 'Salam Pembuka pesan order wahstapp', 'waorder' ), //Admin-visible name of the control
                    'settings'   => 'waorder_greeting_message', //Which setting to load and manipulate (serialized is okay)
                    'priority'   => 10, //Determines the order this control appears in for the specified section
                    'section'    => 'waorder_general_section',
                    'description' => 'Pesan salam pembuka yang akan muncul otomatis di pesan order whatsapp dari customer'
                )
            )
        );

        $wp_customize->add_setting(
            'waorder_help_onoff',
            array(
                'default'    => 'show', //Default setting/value to save
                'type'       => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
                'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
                'transport'  => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'waorder_help_onoff_input',
                array(
                    'label'      => __( 'Show or Hide Help Floating Button', 'waorder' ), //Admin-visible name of the control
                    'settings'   => 'waorder_help_onoff', //Which setting to load and manipulate (serialized is okay)
                    'priority'   => 10, //Determines the order this control appears in for the specified section
                    'section'    => 'waorder_general_section',
                    'type' => 'radio',
                    'choices' => array(
                        'show' => 'Show',
                        'hide' => 'Hide',
                    )
                )
            )
        );

        $wp_customize->add_setting(
            'waorder_greeting_help_message',
            array(
                'default'    => 'Haloo Admin', //Default setting/value to save
                'type'       => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
                'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
                'transport'  => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'waorder_greeting_help_message_input',
                array(
                    'label'      => __( 'Salam Pembuka pesan bantuan wahstapp', 'waorder' ), //Admin-visible name of the control
                    'settings'   => 'waorder_greeting_help_message', //Which setting to load and manipulate (serialized is okay)
                    'priority'   => 10, //Determines the order this control appears in for the specified section
                    'section'    => 'waorder_general_section',
                    'description' => 'Pesan salam pembuka yang akan muncul otomatis di pesan bantuan whatsapp dari user'
                )
            )
        );

        $wp_customize->add_setting(
            'waorder_product_per_page',
            array(
                'default'    => '15', //Default setting/value to save
                'type'       => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
                'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
                'transport'  => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            )
        );

        $wp_customize->add_setting(
            'waorder_fbpixel_id',
            array(
                'default'    => '', //Default setting/value to save
                'type'       => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
                'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
                'transport'  => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'waorder_fbpixel_id_input',
                array(
                    'label'      => __( 'ID Facebook Pixel', 'waorder' ), //Admin-visible name of the control
                    'settings'   => 'waorder_fbpixel_id', //Which setting to load and manipulate (serialized is okay)
                    'priority'   => 10, //Determines the order this control appears in for the specified section
                    'section'    => 'waorder_general_section',
                )
            )
        );

        $wp_customize->add_setting(
            'waorder_fbpixel_id',
            array(
                'default'    => '', //Default setting/value to save
                'type'       => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
                'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
                'transport'  => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'waorder_fbpixel_id_input',
                array(
                    'label'      => __( 'ID Facebook Pixel', 'waorder' ), //Admin-visible name of the control
                    'settings'   => 'waorder_fbpixel_id', //Which setting to load and manipulate (serialized is okay)
                    'priority'   => 10, //Determines the order this control appears in for the specified section
                    'section'    => 'waorder_general_section',
                )
            )
        );

        $wp_customize->add_setting(
            'waorder_fbpixel_order_event',
            array(
                'default'    => 'AddToCart', //Default setting/value to save
                'type'       => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
                'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
                'transport'  => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'waorder_fbpixel_order_event_input',
                array(
                    'label'      => __( 'On Send WA Facebook Pixel Event', 'waorder' ), //Admin-visible name of the control
                    'settings'   => 'waorder_fbpixel_order_event', //Which setting to load and manipulate (serialized is okay)
                    'priority'   => 10, //Determines the order this control appears in for the specified section
                    'section'    => 'waorder_general_section',
                    'type' => 'select',
                    'choices' => array(
                        'AddToCart'=> 'Add To Cart',
                        'Purchase' => 'Purchase',
                    )
                )
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'waorder_product_per_page_input',
                array(
                    'label'      => __( 'Produk Per Page Query', 'waorder' ), //Admin-visible name of the control
                    'settings'   => 'waorder_product_per_page', //Which setting to load and manipulate (serialized is okay)
                    'priority'   => 10, //Determines the order this control appears in for the specified section
                    'section'    => 'waorder_general_section',
                    'type' => 'number',
                )
            )
        );

        $wp_customize->add_setting(
            'waorder_color_scheme',
            array(
                'default'    => '#61DDBB', //Default setting/value to save
                'type'       => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
                'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
                'transport'  => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'waorder_color_scheme_input',
                array(
                    'label'      => __( 'Theme Color', 'waorder' ), //Admin-visible name of the control
                    'settings'   => 'waorder_color_scheme', //Which setting to load and manipulate (serialized is okay)
                    'priority'   => 10, //Determines the order this control appears in for the specified section
                    'section'    => 'waorder_color_section', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
                )
            )
        );

        $wp_customize->add_setting(
            'waorder_featured_onoff',
            array(
                'default'    => 'show', //Default setting/value to save
                'type'       => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
                'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
                'transport'  => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'waorder_featured_onoff_input',
                array(
                    'label'      => __( 'Show or Hide featured', 'waorder' ), //Admin-visible name of the control
                    'settings'   => 'waorder_featured_onoff', //Which setting to load and manipulate (serialized is okay)
                    'priority'   => 10, //Determines the order this control appears in for the specified section
                    'section'    => 'waorder_featured_section',
                    'type' => 'radio',
                    'choices' => array(
                        'show' => 'Show',
                        'hide' => 'Hide',
                    )
                )
            )
        );

        $wp_customize->add_setting(
            'waorder_featured_left_title',
            array(
                'default'    => 'Simple Order', //Default setting/value to save
                'type'       => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
                'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
                'transport'  => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'waorder_featured_left_title_input',
                array(
                    'label'      => __( 'Judul Fitur Kiri', 'waorder' ), //Admin-visible name of the control
                    'settings'   => 'waorder_featured_left_title', //Which setting to load and manipulate (serialized is okay)
                    'priority'   => 10, //Determines the order this control appears in for the specified section
                    'section'    => 'waorder_featured_section', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
                )
            )
        );

        $wp_customize->add_setting(
            'waorder_featured_left_desc',
            array(
                'default'    => 'Order cepat tanpa ribet langsung melalui form whatsapp.', //Default setting/value to save
                'type'       => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
                'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
                'transport'  => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'waorder_featured_left_desc_input',
                array(
                    'label'      => __( 'Deskripsi Fitur Kiri', 'waorder' ), //Admin-visible name of the control
                    'settings'   => 'waorder_featured_left_desc', //Which setting to load and manipulate (serialized is okay)
                    'priority'   => 10, //Determines the order this control appears in for the specified section
                    'section'    => 'waorder_featured_section',
                    'type' => 'textarea'
                )
            )
        );

        $wp_customize->add_setting(
            'waorder_featured_center_title',
            array(
                'default'    => 'Fast Respons', //Default setting/value to save
                'type'       => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
                'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
                'transport'  => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'waorder_featured_center_title_input',
                array(
                    'label'      => __( 'Judul Fitur Tengah', 'waorder' ), //Admin-visible name of the control
                    'settings'   => 'waorder_featured_center_title', //Which setting to load and manipulate (serialized is okay)
                    'priority'   => 10, //Determines the order this control appears in for the specified section
                    'section'    => 'waorder_featured_section', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
                )
            )
        );

        $wp_customize->add_setting(
            'waorder_featured_center_desc',
            array(
                'default'    => 'Kami siap melayani dan merespons order Anda dengan cepat.', //Default setting/value to save
                'type'       => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
                'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
                'transport'  => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'waorder_featured_center_desc_input',
                array(
                    'label'      => __( 'Deskripsi Fitur Tengah', 'waorder' ), //Admin-visible name of the control
                    'settings'   => 'waorder_featured_center_desc', //Which setting to load and manipulate (serialized is okay)
                    'priority'   => 10, //Determines the order this control appears in for the specified section
                    'section'    => 'waorder_featured_section',
                    'type' => 'textarea'
                )
            )
        );

        $wp_customize->add_setting(
            'waorder_featured_right_title',
            array(
                'default'    => 'Quality Product', //Default setting/value to save
                'type'       => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
                'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
                'transport'  => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'waorder_featured_right_title_input',
                array(
                    'label'      => __( 'Judul Fitur Kanan', 'waorder' ), //Admin-visible name of the control
                    'settings'   => 'waorder_featured_right_title', //Which setting to load and manipulate (serialized is okay)
                    'priority'   => 10, //Determines the order this control appears in for the specified section
                    'section'    => 'waorder_featured_section', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
                )
            )
        );

        $wp_customize->add_setting(
            'waorder_featured_right_desc',
            array(
                'default'    => 'Kami hanya menjual produk yang benar benar bermutu dan berkualitas.', //Default setting/value to save
                'type'       => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
                'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
                'transport'  => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'waorder_featured_right_desc_input',
                array(
                    'label'      => __( 'Deskripsi Fitur Kanan', 'waorder' ), //Admin-visible name of the control
                    'settings'   => 'waorder_featured_right_desc', //Which setting to load and manipulate (serialized is okay)
                    'priority'   => 10, //Determines the order this control appears in for the specified section
                    'section'    => 'waorder_featured_section',
                    'type' => 'textarea'
                )
            )
        );

        $wp_customize->add_setting(
            'waorder_social_onoff',
            array(
                'default'    => 'show', //Default setting/value to save
                'type'       => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
                'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
                'transport'  => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'waorder_social_onoff_input',
                array(
                    'label'      => __( 'Show or Hide Social section', 'waorder' ), //Admin-visible name of the control
                    'settings'   => 'waorder_social_onoff', //Which setting to load and manipulate (serialized is okay)
                    'priority'   => 10, //Determines the order this control appears in for the specified section
                    'section'    => 'waorder_social_section',
                    'type' => 'radio',
                    'choices' => array(
                        'show' => 'Show',
                        'hide' => 'Hide',
                    )
                )
            )
        );

        $wp_customize->add_setting(
            'waorder_social_facebook',
            array(
                'default'    => '#', //Default setting/value to save
                'type'       => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
                'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
                'transport'  => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'waorder_social_facebook_input',
                array(
                    'label'      => __( 'Facebook Link', 'waorder' ), //Admin-visible name of the control
                    'settings'   => 'waorder_social_facebook', //Which setting to load and manipulate (serialized is okay)
                    'priority'   => 10, //Determines the order this control appears in for the specified section
                    'section'    => 'waorder_social_section', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
                )
            )
        );

        $wp_customize->add_setting(
            'waorder_social_instagram',
            array(
                'default'    => '#', //Default setting/value to save
                'type'       => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
                'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
                'transport'  => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'waorder_social_instagram_input',
                array(
                    'label'      => __( 'Instagram Link', 'waorder' ), //Admin-visible name of the control
                    'settings'   => 'waorder_social_instagram', //Which setting to load and manipulate (serialized is okay)
                    'priority'   => 10, //Determines the order this control appears in for the specified section
                    'section'    => 'waorder_social_section', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
                )
            )
        );

        $wp_customize->add_setting(
            'waorder_social_youtube',
            array(
                'default'    => '#', //Default setting/value to save
                'type'       => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
                'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
                'transport'  => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'waorder_social_youtube_input',
                array(
                    'label'      => __( 'Youtube Link', 'waorder' ), //Admin-visible name of the control
                    'settings'   => 'waorder_social_youtube', //Which setting to load and manipulate (serialized is okay)
                    'priority'   => 10, //Determines the order this control appears in for the specified section
                    'section'    => 'waorder_social_section', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
                )
            )
        );

        $wp_customize->add_setting(
            'waorder_copyright_text',
            array(
                'default'    => '&copy; '.date('Y').' Copyright WA ORDER', //Default setting/value to save
                'type'       => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
                'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
                'transport'  => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'waorder_copyright_text_input',
                array(
                    'label'      => __( 'Footer Copyright', 'waorder' ), //Admin-visible name of the control
                    'settings'   => 'waorder_copyright_text', //Which setting to load and manipulate (serialized is okay)
                    'priority'   => 10, //Determines the order this control appears in for the specified section
                    'section'    => 'waorder_copyright_section',
                    'type' => 'textarea'
                )
            )
        );

        $wp_customize->add_setting(
            'waorder_nextproduct_text',
            array(
                'default'    => 'Lihat Semua Produk', //Default setting/value to save
                'type'       => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
                'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
                'transport'  => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'waorder_nextproduct_text_input',
                array(
                    'label'      => __( 'Homepage Next Button Text', 'waorder' ), //Admin-visible name of the control
                    'settings'   => 'waorder_nextproduct_text', //Which setting to load and manipulate (serialized is okay)
                    'priority'   => 10, //Determines the order this control appears in for the specified section
                    'section'    => 'waorder_general_section',
                )
            )
        );
    }

    public static function header_output() {
        $color = get_theme_mod('waorder_color_scheme');
        $color = $color ? $color : '#61DDBB';
        ?>
        <style type="text/css">
            a{color: <?php echo $color; ?>}
            a:hover{color:<?php echo $color; ?>}
            .color-scheme-text{color: <?php echo $color; ?>;}
            .color-scheme-background{background: <?php echo $color; ?>;}
            .color-scheme-border{border-color: <?php echo $color; ?>;}
            .color-scheme-background-hover{background: #ffffff;color: rgba(0,0,0,.6);}
            .color-scheme-background-hover:hover{background: <?php echo $color; ?>;color: #ffffff;}
        </style>
        <?php
    }

    public static function live_preview() {

        wp_enqueue_script(
             'mytheme-themecustomizer', // Give the script a unique ID
             get_template_directory_uri() . '/assets/js/theme-customizer.js', // Define the path to the JS file
             array(  'jquery', 'customize-preview' ), // Define dependencies
             '', // Define a version (optional)
             true // Specify whether to put in footer (leave this true)
        );
    }

    public static function admin_menu(){
        if( waorder_lislis() == 'active' ) return;
        add_menu_page(
            __('WA ORDER', 'waorder'),
            __('WA ORDER', 'waorder'),
            'manage_options',
			'waorder',
            ['WaOrder_Customize', 'settings']
        );
    }

    public static function check_curl(){

		if( !function_exists("curl_init") ) return true;

		return false;
	}

    public static function settings(){

        $check = waorder_lislis();
        $curl_check = self::check_curl();
        if( $check == 'active' ):
            $check = 'Active, <a href="'.admin_url().'?waorderflush=true">klik di sini untuk melanjutkan</a>';
        endif;
        ?>
        <div class="wrap">
            <h2><?php _e('WA ORDER License', 'waorder'); ?></h2>
            <?php if( $check ): ?>
                <div class="notice notice-warning is-dismissible">
                    <p><?php echo $check; ?></p>
                </div>
            <?php endif; ?>
            <?php if( $curl_check ): ?>
                <div class="notice notice-warning">
                    <p><?php _e('Modul curl tidak active, silahkan kontak provider hosting Anda untuk mengaktifkan Curl !', 'wwaorder'); ?></p>
                </div>
                <?php return; ?>
            <?php endif; ?>

            <form action="" method="post" enctype="multipart/form-data">

                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row">
                                <label>Email</label>
                            </th>
                            <td>
                                <input type="email" name="email" value=""  class="regular-text" required/>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label>License Code</label>
                            </th>
                            <td>
                                <input type="text" name="code" value=""  class="regular-text" required/>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label>&nbsp;</label>
                            </th>
                            <td>
                                <input type="hidden" name="waorder_key" value="activate"/>
                                <input type="submit" name="submit" class="button button-primary" value="Aktifkan Lisensi">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <?php wp_nonce_field('waordernonce', 'noncenonce'); ?>
            </form>
        </div>
        <?php
    }

}

// Setup the Theme Customizer settings and controls...
add_action( 'customize_register' , array( 'WaOrder_Customize' , 'register' ) );

// Output custom CSS to live site
add_action( 'wp_head' , array( 'WaOrder_Customize' , 'header_output'), 11 );

// Enqueue live preview javascript in Theme Customizer admin screen
add_action( 'customize_preview_init' , array( 'WaOrder_Customize' , 'live_preview' ) );

add_action( 'admin_menu',  array('WaOrder_Customize', 'admin_menu') );
