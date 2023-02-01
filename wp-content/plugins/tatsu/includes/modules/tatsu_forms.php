<?php
if( !function_exists( 'tatsu_forms' ) ) {
    function tatsu_forms( $atts, $content, $tag ) {
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
        $form_id = tatsu_validate_tatsuforms($form_id);
        
        $custom_style_tag = be_generate_css_from_atts( $atts, $tag, $atts['key'] );
        $unique_class_name = ' tatsu-'.$atts['key'];

        $classes = array ( 'tatsu-forms', 'tatsu-module', $unique_class_name );
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
            $html_class[] = 'tatsu-form-' . $form_type;
        }
        if( !empty( $button_type ) ) {
            $html_class[] = 'tatsu-form-submit-' . $button_type;
        }

        $form_shortcode = '';
        if( !empty( $form_id ) ) {
            $form_shortcode =  extract_spyro_form_module_shortcode($form_id);
        }
        
        ob_start();
?>
        <div <?php echo $css_id; ?> class = "<?php echo implode( ' ', $classes ); ?>" <?php echo $data_attrs; ?>>
            <?php echo $custom_style_tag; ?>
            <div class = "tatsu-forms-inner tatsu-forms-save <?php echo implode( ' ', $html_class ); ?>" id="form-<?php echo $form_id; ?>">
                <?php echo do_shortcode( $form_shortcode ); ?>
                <div class="tatsu-form-status">
                    <div class="exp-subscribe-loader">
                        <div class="exp-subscribe-loader-inner">
                        </div>
                    </div>
                    <div class="subscribe_status tatsu-notification">
                    </div>
                </div>
            </div>
        </div>
<?php
        return ob_get_clean();
    };
    add_shortcode( 'tatsu_forms', 'tatsu_forms' );
}

if( !function_exists( 'tatsu_validate_tatsuforms' ) ) {
    function tatsu_validate_tatsuforms( $form_id ){
        
        $valid_form = get_post($form_id);
        if( NULL == $valid_form || 'tatsuforms' != $valid_form->post_type ){
            $tatsu_forms = get_posts(
                array(
                    'numberposts'      => 1,
                    'post_type'        => 'tatsuforms'
                )
            );
            foreach( $tatsu_forms as $index => $tatsu_form ) {
                if( $index == 0 ){
                    $valid_form = get_post($tatsu_form->ID);
                }
            }
        } 
        return !empty($valid_form)?$valid_form->ID:'';
        //return $valid_form->ID;

    }
}
if( !function_exists( 'tatsu_forms_prevent_autop' ) ) {
    function tatsu_forms_prevent_autop( $content_filter, $tag ) {
        if( 'tatsu_forms' === $tag ) {
            $content_filter = false;
        }
        return $content_filter;
    }
    add_filter( 'tatsu_shortcode_output_content_filter', 'tatsu_forms_prevent_autop', 10, 2 );
}

if( !function_exists( 'tatsu_forms_css_load' ) ) {
    function tatsu_forms_css_load() {
        // wp_enqueue_style(
        //     'tatsu-forms-full',
        //     plugins_url() . '/forms-full.css',
        //     array()
        // );
    }
}

if( !function_exists( 'tatsu_register_tatsu_forms_module' ) ) {
    add_action( 'tatsu_register_modules', 'tatsu_register_tatsu_forms_module' );
    function tatsu_register_tatsu_forms_module() {
        if ( current_theme_supports('tatsu-forms')  ) {
            //add_action( 'tatsu_frame_enqueue', 'tatsu_forms_css_load' );
            $args = array(
                'post_type' => 'tatsu_forms', 
                'posts_per_page' => -1
            );
            extract( be_get_color_hub() );
            $tatsu_forms = get_posts( $args );
            $forms = array();
            $default_form_id = '';
            if( !empty( $tatsu_forms ) ) {
                foreach( $tatsu_forms as $index => $tatsu_form ) {
                    $id = $tatsu_form->ID;
                    $title = $tatsu_form->post_title;
                    $forms[ $id ] = $title;
                    if( 0 === $index ) {
                        $default_form_id = $id;
                    }
                }
            }
            $controls = array (
                'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#tabs',
                'title' => esc_html__( 'Tatsu Forms', 'tatsu' ),
                'is_js_dependant' => true,
                'type' => 'single',
                'is_built_in' => false,
                'group_atts'  => array (
                    array (
                        'type' => 'tabs',
                        'group' => array (
                            array (
                                'type'  => 'tab',
                                'title' => esc_html__( 'Content', 'tatsu' ),
                                'group' => array (
                                    'form_id'
                                )
                            ),
                            // array (
                            //     'type'  => 'tab',
                            //     'title' => esc_html__( 'Style', 'tatsu' ),
                            //     'group' => array (
                            //         'form_type',
                            //         'button_type',
                            //         array (
                            //             'type'  => 'accordion',
                            //             'active' => 'all',
                            //             'group' => array (
                            //                 array (
                            //                     'type'  => 'panel',
                            //                     'title' => esc_html__( 'Colors', 'tatsu' ),
                            //                     'group' => array (
                            //                         'bg_color',
                            //                         'color',
                            //                         'label_color',
                            //                         'button_color',
                            //                         'button_bg_color',
                            //                         'border_color',
                            //                     )
                            //                 )
                            //             )
                            //         )
                            //     )
                            // ),
                            array (
                                'type'  => 'tab',
                                'title' => esc_html__( 'Advanced', 'tatsu' ),
                                'group' => array (
                                    array (
                                        'type'  => 'accordion',
                                        'active' => 'none',
                                        'group' => array (
                                            array (
												'type' => 'panel',
												'title' => esc_html__( 'Border', 'tatsu' ),
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
                        'label'			=> esc_html__( 'Forms', 'tatsu' ),
                        'options'		=> $forms,
                        'default'		=> $default_form_id,
                        'tooltip'		=> '',	
                    ),
                    array (
                        'att_name'		=> 'bg_color',
                        'type'			=> 'color',
                        'gradient'      => false,
                        'label'			=> esc_html__( 'Background', 'tatsu' ),
                        'default'		=> '',
                        'tooltip'		=> '',
                        'visible'		=> array ( 'form_type', '!=', 'border-with-underline' ),
                        'css'			=> true,
                        'selectors'		=> array (
                            '.tatsu-{UUID}.tatsu-forms .tatsuforms-container-full .tatsuforms-form input:not([type="submit"]), 
                            .tatsu-{UUID}.tatsu-forms .tatsuforms-container-full .tatsuforms-form textarea, 
                            .tatsu-{UUID}.tatsu-forms .tatsuforms-container-full .tatsuforms-form select' => array (
                                'property'		=> 'background-color',
                                'when'			=> array ( 'form_type', '!=', 'border-with-underline' ),
                            )
                        )
                    ),
                    array (
                        'att_name'		=> 'color',
                        'type'			=> 'color',
                        'label'			=> esc_html__( 'Text', 'tatsu' ),
                        'default'		=> '',
                        'tooltip'		=> '',
                        'css'			=> true,
                        'selectors'		=> array (
                            '.tatsu-{UUID}.tatsu-forms .tatsuforms-container-full .tatsuforms-form input:not([type="submit"]), 
                            .tatsu-{UUID}.tatsu-forms .tatsuforms-container-full .tatsuforms-form textarea, 
                            .tatsu-{UUID}.tatsu-forms div.tatsuforms-container-full .tatsuforms-form select' => array (
                                'property'		=> 'color'
                            )
                        )
                    ),
                    array (
                        'att_name'		=> 'label_color',
                        'type'			=> 'color',
                        'label'			=> esc_html__( 'Label', 'tatsu' ),
                        'default'		=> '',
                        'tooltip'		=> '',
                        'css'			=> true,
                        'selectors'		=> array (
                            '.tatsu-{UUID}.tatsu-forms .tatsuforms-container-full .tatsuforms-form .tatsuforms-field-label, 
                            .tatsu-{UUID} ::-webkit-input-placeholder,
                            .tatsu-{UUID}.tatsu-forms .tatsuforms-container-full .tatsuforms-form .tatsuforms-field-label-inline' => array (
                                'property'		=> 'color',
                            )
                        )
                    ),
                    array (
                        'att_name'		=> 'form_type',
                        'type'			=> 'select',
                        'label'			=> esc_html__( 'Form Style', 'tatsu' ),
                        'default'		=> 'rounded',
                        'tooltip'		=> '',
                        'options'		=> array (
                            'rounded'					=> esc_html__( 'Solid', 'tatsu' ),
                            'border-with-underline'	=> esc_html__( 'Line', 'tatsu' ),
                            'rounded-with-underline'	=> esc_html__( 'Rounded - Inner Shadow ', 'tatsu' ),
                            'pill'					=> esc_html__( 'Pill', 'tatsu' ),
                        )
                    ),
                    array (
                        'att_name'		=> 'button_type',
                        'type'			=> 'select',
                        'label'			=> esc_html__( 'Button Style', 'tatsu' ),
                        'default'		=> 'rounded',
                        'tooltip'		=> '',
                        'options'		=> array (
                            'rounded'			=> esc_html__( 'Rounded', 'tatsu' ),
                            'pill'		=>  esc_html__( 'Pill', 'tatsu' ),
                            'rounded-block' => esc_html__( 'Rounded Block', 'tatsu' ),
                            'pill-block'	=> esc_html__( 'Pill - Block', 'tatsu' ),
                        )
                    ),
                    array (
                        'att_name'		=> 'button_color',
                        'type'			=> 'color',
                        'label'			=> esc_html__( 'Button', 'tatsu' ),
                        'default'		=> '',
                        'tooltip'		=> '',
                        'css'			=> true,
                        'selectors'		=> array (
                            '.tatsu-{UUID}.tatsu-forms div.tatsuforms-container-full .tatsuforms-form button[type=submit]' => array (
                                'property'		=> 'color'
                            )
                        )
                    ),
                    array (
                        'att_name'		=> 'button_bg_color',
                        'type'			=> 'color',
                        'label'			=> esc_html__( 'Button Background', 'tatsu' ),
                        'default'		=> '',
                        'tooltip'		=> '',
                        'css'			=> true,
                        'selectors'		=> array (
                            '.tatsu-{UUID}.tatsu-forms div.tatsuforms-container-full .tatsuforms-form button[type=submit]' => array (
                                'property'		=> 'background-color',
                            ),
                        ),
                    ),
                    array (
                        'att_name'		=> 'border_color',
                        'type'			=> 'color',
                        'label'			=> esc_html__( 'Border', 'tatsu' ),
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
                        'label' => esc_html__( 'Border Style', 'tatsu' ),
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
                        'label' => esc_html__( 'Border Width', 'tatsu' ),
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
                        'label' => esc_html__( 'Border Color', 'tatsu' ),
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
                        'label'		=> esc_html__( 'Border Radius', 'tatsu' ),
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
            tatsu_register_module( 'tatsu_forms', $controls );
        }
    }
}