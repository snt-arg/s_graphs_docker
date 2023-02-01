<?php
if( !function_exists( 'tatsu_wp_forms' ) ) {
    function tatsu_wp_forms( $atts, $content, $tag ) {
        $atts = shortcode_atts( array (
            'form_id'           => '',
            'bg_color'          => '',
            'color'             => '',
            'label_color'       => '',
            'form_type'         => '',
            'accent_color'      => '',
            'button_type'       => '',
            'button_color'      => '',
            'button_bg_color'   => '',
            'border_color'      => '',
            'border'    => '',
            'outer_border_color'  => '',
            'border_style'  => '',
            'border_radius'         => '',
            'key' => be_uniqid_base36(true),
        ), $atts, $tag );

        extract($atts);
        $form_id = tatsu_validate_wpforms($form_id);
        
        $custom_style_tag = be_generate_css_from_atts( $atts, $tag, $atts['key'] );
        $unique_class_name = ' tatsu-'.$atts['key'];

        $classes = array ( 'tatsu-wp-forms', 'tatsu-module', $unique_class_name );
        if( !empty( $atts['css_classes'] ) ) {
            $classes[] = $atts['css_classes'];
        }
        $classes[] = be_get_visibility_classes_from_atts( $atts );

        $css_id = be_get_id_from_atts( $atts );

        if( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) {
            $classes[] = 'tatsu-animate';
        }
        $data_attrs = be_get_animation_data_atts( $atts );

        $form_types = array( 'rounded', 'border-with-underline', 'rounded-with-underline', 'pill' );
        $button_types = array ('rounded', 'pill', 'rounded-block', 'pill-block' );
        $html_class = array();
        $form_type = !empty( $form_type ) && in_array( $form_type, $form_types ) ? $form_type : '';
        $button_type = !empty($button_type) && in_array( $button_type, $button_types ) ? $button_type : '';
        if( !empty( $form_type ) ) {
            $html_class[] = 'tatsu-wp-form-' . $form_type;
        }
        if( !empty( $button_type ) ) {
            $html_class[] = 'tatsu-wp-form-submit-' . $button_type;
        }

        $form_shortcode = '';
        if( !empty( $form_id ) ) {
            $form_shortcode =  sprintf( '[wpforms html_class = "%s" id="%s"]', implode( ' ', $html_class ), $form_id );
        }
        
        ob_start();
?>
        <div <?php echo $css_id; ?> class = "<?php echo implode( ' ', $classes ); ?>" <?php echo $data_attrs; ?>>
            <?php echo $custom_style_tag; ?>
            <div class = "tatsu-wp-forms-inner <?php echo implode( ' ', $html_class ); ?>">
                <?php echo do_shortcode( $form_shortcode ); ?>
            </div>
        </div>
<?php
        return ob_get_clean();
    };
    add_shortcode( 'tatsu_wp_forms', 'tatsu_wp_forms' );
}

if( !function_exists( 'tatsu_validate_wpforms' ) ) {
    function tatsu_validate_wpforms( $form_id ){
        
        $valid_form = get_post($form_id);
        if( NULL == $valid_form || 'wpforms' != $valid_form->post_type ){
            $wp_forms = get_posts(
                array(
                    'numberposts'      => 1,
                    'post_type'        => 'wpforms'
                )
            );
            foreach( $wp_forms as $index => $wp_form ) {
                if( $index == 0 ){
                    $valid_form = get_post($wp_form->ID);
                }
            }
        } 
        return $valid_form->ID;

    }
}
if( !function_exists( 'tatsu_wp_forms_prevent_autop' ) ) {
    function tatsu_wp_forms_prevent_autop( $content_filter, $tag ) {
        if( 'tatsu_wp_forms' === $tag ) {
            $content_filter = false;
        }
        return $content_filter;
    }
    add_filter( 'tatsu_shortcode_output_content_filter', 'tatsu_wp_forms_prevent_autop', 10, 2 );
}

if( !function_exists( 'tatsu_wpforms_css_load' ) ) {
    function tatsu_wpforms_css_load() {
        wp_enqueue_style(
            'wpforms-full',
            plugins_url() . '/wpforms-lite/assets/css/wpforms-full.css',
            array()
        );
    }
}

if( !function_exists( 'tatsu_register_wp_forms' ) ) {
    add_action( 'tatsu_register_modules', 'tatsu_register_wp_forms' );
    function tatsu_register_wp_forms() {
        if ( function_exists( 'wpforms' )  ) {
            add_action( 'tatsu_frame_enqueue', 'tatsu_wpforms_css_load' );
            $args = array(
                'post_type' => 'wpforms', 
                'posts_per_page' => -1
            );
            extract( be_get_color_hub() );
            $wp_forms = get_posts( $args );
            $forms = array();
            $default_form_id = '';
            if( !empty( $wp_forms ) ) {
                foreach( $wp_forms as $index => $wp_form ) {
                    $id = $wp_form->ID;
                    $title = $wp_form->post_title;
                    $forms[ $id ] = $title;
                    if( 0 === $index ) {
                        $default_form_id = $id;
                    }
                }
            }
            $controls = array (
                'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#wpforms',
                'title' => __( 'WP Forms', 'tatsu' ),
                'is_js_dependant' => true,
                'type' => 'single',
                'is_built_in' => false,
                'group_atts'  => array (
                    array (
                        'type' => 'tabs',
                        'group' => array (
                            array (
                                'type'  => 'tab',
                                'title' => __( 'Content', 'tatsu' ),
                                'group' => array (
                                    'form_id'
                                )
                            ),
                            array (
                                'type'  => 'tab',
                                'title' => __( 'Style', 'tatsu' ),
                                'group' => array (
                                    'form_type',
                                    'button_type',
                                    array (
                                        'type'  => 'accordion',
                                        'active' => 'all',
                                        'group' => array (
                                            array (
                                                'type'  => 'panel',
                                                'title' => __( 'Colors', 'tatsu' ),
                                                'group' => array (
                                                    'bg_color',
                                                    'color',
                                                    'label_color',
                                                    // 'accent_color',
                                                    'button_color',
                                                    'button_bg_color',
                                                    'border_color',
                                                )
                                            )
                                        )
                                    )
                                )
                            ),
                            array (
                                'type'  => 'tab',
                                'title' => __( 'Advanced', 'tatsu' ),
                                'group' => array (
                                    array (
                                        'type'  => 'accordion',
                                        'active' => 'none',
                                        'group' => array (
                                            array (
												'type' => 'panel',
												'title' => __( 'Border', 'tatsu' ),
												'group' => array (
                                                    'border_style',
                                                    'border',
                                                    'outer_border_color',
                                                    'border_radius',
                                                ),
                                            ),
                                        )
                                    )
                                )
                            ),
                        )
                    )
                ),
                'atts' => array (
                    array (
                        'att_name'		=> 'form_id',
                        'type'			=> 'select',
                        'label'			=> __( 'Forms', 'tatsu' ),
                        'options'		=> $forms,
                        'default'		=> $default_form_id,
                        'tooltip'		=> '',	
                    ),
                    array (
                        'att_name'		=> 'bg_color',
                        'type'			=> 'color',
                        'gradient'      => false,
                        'label'			=> __( 'Background', 'tatsu' ),
                        'default'		=> '',
                        'tooltip'		=> '',
                        'visible'		=> array ( 'form_type', '!=', 'border-with-underline' ),
                        'css'			=> true,
                        'selectors'		=> array (
                            '.tatsu-{UUID}.tatsu-wp-forms .wpforms-container-full .wpforms-form input:not([type="submit"]), 
                            .tatsu-{UUID}.tatsu-wp-forms .wpforms-container-full .wpforms-form textarea, 
                            .tatsu-{UUID}.tatsu-wp-forms .wpforms-container-full .wpforms-form select' => array (
                                'property'		=> 'background-color',
                                'when'			=> array ( 'form_type', '!=', 'border-with-underline' ),
                            )
                        )
                    ),
                    array (
                        'att_name'		=> 'color',
                        'type'			=> 'color',
                        'label'			=> __( 'Text', 'tatsu' ),
                        'default'		=> '',
                        'tooltip'		=> '',
                        'css'			=> true,
                        'selectors'		=> array (
                            '.tatsu-{UUID}.tatsu-wp-forms .wpforms-container-full .wpforms-form input:not([type="submit"]), 
                            .tatsu-{UUID}.tatsu-wp-forms .wpforms-container-full .wpforms-form textarea, 
                            .tatsu-{UUID}.tatsu-wp-forms div.wpforms-container-full .wpforms-form select' => array (
                                'property'		=> 'color'
                            )
                        )
                    ),
                    array (
                        'att_name'		=> 'label_color',
                        'type'			=> 'color',
                        'label'			=> __( 'Label', 'tatsu' ),
                        'default'		=> '',
                        'tooltip'		=> '',
                        'css'			=> true,
                        'selectors'		=> array (
                            '.tatsu-{UUID}.tatsu-wp-forms .wpforms-container-full .wpforms-form .wpforms-field-label, 
                            .tatsu-{UUID} ::-webkit-input-placeholder,
                            .tatsu-{UUID}.tatsu-wp-forms .wpforms-container-full .wpforms-form .wpforms-field-label-inline' => array (
                                'property'		=> 'color',
                            )
                        )
                    ),
                    array (
                        'att_name'		=> 'form_type',
                        'type'			=> 'select',
                        'label'			=> __( 'Form Style', 'tatsu' ),
                        'default'		=> 'rounded',
                        'tooltip'		=> '',
                        'options'		=> array (
                            'rounded'					=> __( 'Solid', 'tatsu' ),
                            'border-with-underline'	=> __( 'Line', 'tatsu' ),
                            'rounded-with-underline'	=> __( 'Rounded - Inner Shadow ', 'tatsu' ),
                            'pill'					=> __( 'Pill', 'tatsu' ),
                        )
                    ),
                    // array (
                    //     'att_name'		=> 'accent_color',
                    //     'type'			=> 'color',
                    //     'label'			=> __( 'Accent', 'tatsu' ),
                    //     'default'		=> '',
                    //     'tooltip'		=> '',
                    //     'css'			=> true,
                    //     'selectors'		=> array (
                    //         '.tatsu-{UUID} input:not([type = "submit"]):focus, .tatsu-{UUID} textarea:focus, .tatsu-{UUID} select:focus' => array (
                    //             'property'		=> 'border-color',
                    //             'when'			=> array (
                    //                 array ('form_type', '=', 'pill' ),
                    //                 array( 'form_type', '=', 'rounded' ),
                    //             ),
                    //             'relation'		=> 'or',
                    //         ),
                    //         '.tatsu-{UUID} .exp-form-border' => array (
                    //             'property'		=> 'background-color',
                    //             'when'			=> array (
                    //                 array ( 'form_type', '=', 'border-with-underline' ),
                    //                 array ( 'form_type', '=', 'rounded-with-underline' ),
                    //             ),
                    //             'relation'		=> 'or',
                    //         ),
                    //         '.tatsu-{UUID} .exp-form-border-with-underline .exp-form-field-active .exp-form-field-label'	=> array (
                    //             'property'		=> 'color',
                    //             'when'			=> array ( 'form_type', '=', 'border-with-underline' ),
                    //         )
                    //     )
                    // ),
                    array (
                        'att_name'		=> 'button_type',
                        'type'			=> 'select',
                        'label'			=> __( 'Button Style', 'tatsu' ),
                        'default'		=> 'rounded',
                        'tooltip'		=> '',
                        'options'		=> array (
                            'rounded'			=> __( 'Rounded', 'tatsu' ),
                            'pill'		=>  __( 'Pill', 'tatsu' ),
                            'rounded-block' => __( 'Rounded Block', 'tatsu' ),
                            'pill-block'	=> __( 'Pill - Block', 'tatsu' ),
                        )
                    ),
                    array (
                        'att_name'		=> 'button_color',
                        'type'			=> 'color',
                        'label'			=> __( 'Button', 'tatsu' ),
                        'default'		=> '',
                        'tooltip'		=> '',
                        'css'			=> true,
                        'selectors'		=> array (
                            '.tatsu-{UUID}.tatsu-wp-forms div.wpforms-container-full .wpforms-form button[type=submit]' => array (
                                'property'		=> 'color'
                            )
                        )
                    ),
                    array (
                        'att_name'		=> 'button_bg_color',
                        'type'			=> 'color',
                        'label'			=> __( 'Button Background', 'tatsu' ),
                        'default'		=> '',
                        'tooltip'		=> '',
                        'css'			=> true,
                        'selectors'		=> array (
                            '.tatsu-{UUID}.tatsu-wp-forms div.wpforms-container-full .wpforms-form button[type=submit]' => array (
                                'property'		=> 'background-color',
                            ),
                        ),
                    ),
                    array (
                        'att_name'		=> 'border_color',
                        'type'			=> 'color',
                        'label'			=> __( 'Border', 'tatsu' ),
                        'default'		=> '',
                        'tooltip'		=> '',
                        'css'			=> true,
                        'visible'		=> array ( 'form_type', '=', 'border-with-underline' ),
                        'selectors'		=> array (
                            '.tatsu-{UUID} textarea, .tatsu-{UUID} input:not([type = "submit"]), .tatsu-{UUID} select' => array (
                                'property'		=> 'border-color',
                                'when'				=> array ( 'form_type', '=', 'border-with-underline' )
                            ),
                        )
                    ),
                    array (
                        'att_name' => 'border_style',
                        'type' => 'select',
                        'label' => __( 'Border Style', 'tatsu' ),
                        'options' => array(
                            'none' => 'None',
                            'solid' => 'Solid',
                            'dashed' => 'Dashed',
                            'double' => 'Double',
                            'dotted' => 'Dotted',
                        ),
                        'default' => 'solid',
                        'tooltip' => '',
                        'css' => true,
                        'selectors' => array(
                            '.tatsu-{UUID}' => array(
                                'property' => 'border-style',
                                'when' => array(
                                    array( 'border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
                                    array( 'border_style', '!=', 'none' ),
                                ),
                                'relation' => 'and',            
                            ),
                        ),
                    ),
                    array (
                        'att_name' => 'border',
                        'type' => 'input_group',
                        'label' => __( 'Border Width', 'tatsu' ),
                        'default' => '0px 0px 0px 0px',
                        'tooltip' => '',
                        'responsive' => true,
                        'css' => true,
                        'selectors' => array(
                            '.tatsu-{UUID}' => array(
                                'property' => 'border-width',
                            ),
                        ),
                    ),
                    array (
                        'att_name' => 'outer_border_color',
                        'type' => 'color',
                        'label' => __( 'Border Color', 'tatsu' ),
                        'default' => '',
                        'tooltip' => '',
                        'css' => true,
                        'selectors' => array(
                            '.tatsu-{UUID}' => array(
                                'property' => 'border-color',
                                'when' => array('border', '!=', '0px 0px 0px 0px'),
                            ),
                        ),
                    ),
                    array (
                        'att_name'	=> 'border_radius',
                        'type'		=> 'number',
                        'is_inline' => true,
                        'exclude' => array('tatsu_empty_space'),
                        'is_inline' => true,
                        'label'		=> __( 'Border Radius', 'tatsu' ),
                        'options' 	=> array (
                            'unit'	=> array( 'px', '%' ),
                        ),
                        'default'	=> '',
                        'css'		=> true,
                        'selectors'	=> array (
                            '.tatsu-{UUID}'	=>  array (
                                'property' => 'border-radius',
                                'append' => 'px'
                            )
                        )
                    ),
                )
            );
            tatsu_register_module( 'tatsu_wp_forms', $controls );
        }
    }
}