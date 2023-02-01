<?php
    if( !function_exists( 'tatsu_star_rating' ) ) {
        function tatsu_star_rating( $atts, $content, $tag) {
            $atts = shortcode_atts( array (
                'rating'            => '',
                'alignment'         => 'left',
                'range_color'       => '',
                'fill_color'        => '',
                'margin'            => '',
                'animate' => 0,
                'animation_type' => 'fadeIn',
                'animation_delay' => 0,
                'key' => be_uniqid_base36(true),
            ), $atts , $tag);
            extract( $atts );
            $css_id = be_get_id_from_atts( $atts );
		    $visibility_classes = be_get_visibility_classes_from_atts( $atts ); 
            $animate = ( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) ? ' tatsu-animate' : '';
            $classes = array( 'tatsu-module', 'tatsu-star-rating', 'tatsu-'. $key, $visibility_classes, $css_classes, $animate );
            $custom_style_tag  = be_generate_css_from_atts( $atts, $tag, $atts['key'] );

            $data_animations = be_get_animation_data_atts( $atts );

            if( !empty( $alignment ) ) {
                $classes[] = 'tatsu-star-rating-align-' . $alignment;
            }else {
                $classes[] = 'tatsu-star-rating-align-left';
            }

            $rating = !empty( $rating ) && is_numeric( $rating ) ? (float)$rating : 5;
            $filled_width = ( $rating/5 ) * 100;
            $filled_style = sprintf( 'style = "width : %s%% ;"', $filled_width );

            ob_start();
            ?>
                <div <?php echo $css_id; ?> class = "<?php echo implode( ' ', $classes ); ?>" <?php echo $data_animations;?>>
                    <?php echo $custom_style_tag; ?>
                    <div class = "tatsu-star-rating-inner">
                        <div class = "tatsu-star-rating-range">
                            <span class = "tatsu-star-rating-star">   
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15"><polygon points="1189 6866 1190.9 6871.348 1196 6871.348 1191.838 6874.488 1193.327 6880 1189 6876.695 1184.675 6880 1186.162 6874.488 1182 6871.348 1187.1 6871.348" transform="translate(-1182 -6866)"/></svg> 
                            </span>                                  
                            <span class = "tatsu-star-rating-star">    
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15"><polygon points="1189 6866 1190.9 6871.348 1196 6871.348 1191.838 6874.488 1193.327 6880 1189 6876.695 1184.675 6880 1186.162 6874.488 1182 6871.348 1187.1 6871.348" transform="translate(-1182 -6866)"/></svg>         
                            </span>                                 
                            <span class = "tatsu-star-rating-star">     
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15"><polygon points="1189 6866 1190.9 6871.348 1196 6871.348 1191.838 6874.488 1193.327 6880 1189 6876.695 1184.675 6880 1186.162 6874.488 1182 6871.348 1187.1 6871.348" transform="translate(-1182 -6866)"/></svg>      
                            </span>                                 
                            <span class = "tatsu-star-rating-star">    
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15"><polygon points="1189 6866 1190.9 6871.348 1196 6871.348 1191.838 6874.488 1193.327 6880 1189 6876.695 1184.675 6880 1186.162 6874.488 1182 6871.348 1187.1 6871.348" transform="translate(-1182 -6866)"/></svg>    
                            </span>                                 
                            <span class = "tatsu-star-rating-star">           
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15"><polygon points="1189 6866 1190.9 6871.348 1196 6871.348 1191.838 6874.488 1193.327 6880 1189 6876.695 1184.675 6880 1186.162 6874.488 1182 6871.348 1187.1 6871.348" transform="translate(-1182 -6866)"/></svg>     
                            </span>    
                        </div>
                        <div <?php echo $filled_style; ?> class = "tatsu-star-rating-filled">
                            <span class = "tatsu-star-rating-star">    
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15"><polygon points="1170 6866 1171.9 6871.348 1177 6871.348 1172.838 6874.488 1174.327 6880 1170 6876.695 1165.675 6880 1167.162 6874.488 1163 6871.348 1168.1 6871.348" transform="translate(-1163 -6866)"/></svg>
                            </span>                                  
                            <span class = "tatsu-star-rating-star">    
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15"><polygon points="1170 6866 1171.9 6871.348 1177 6871.348 1172.838 6874.488 1174.327 6880 1170 6876.695 1165.675 6880 1167.162 6874.488 1163 6871.348 1168.1 6871.348" transform="translate(-1163 -6866)"/></svg>
                            </span>                                 
                            <span class = "tatsu-star-rating-star">     
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15"><polygon points="1170 6866 1171.9 6871.348 1177 6871.348 1172.838 6874.488 1174.327 6880 1170 6876.695 1165.675 6880 1167.162 6874.488 1163 6871.348 1168.1 6871.348" transform="translate(-1163 -6866)"/></svg>
                            </span>                                 
                            <span class = "tatsu-star-rating-star">    
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15"><polygon points="1170 6866 1171.9 6871.348 1177 6871.348 1172.838 6874.488 1174.327 6880 1170 6876.695 1165.675 6880 1167.162 6874.488 1163 6871.348 1168.1 6871.348" transform="translate(-1163 -6866)"/></svg>    
                            </span>                                 
                            <span class = "tatsu-star-rating-star">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15"><polygon points="1170 6866 1171.9 6871.348 1177 6871.348 1172.838 6874.488 1174.327 6880 1170 6876.695 1165.675 6880 1167.162 6874.488 1163 6871.348 1168.1 6871.348" transform="translate(-1163 -6866)"/></svg>
                            </span>    
                        </div>
                    </div>
                </div>
            <?php
            return ob_get_clean();
        }
        add_shortcode( 'tatsu_star_rating', 'tatsu_star_rating' );
    }

    if (!function_exists('tatsu_register_star_rating')) {
        add_action('tatsu_register_modules', 'tatsu_register_star_rating');
        function tatsu_register_star_rating()
        {
            $controls = array(
                'icon' 				=> TATSU_PLUGIN_URL . '/builder/svg/modules.svg#star_rating',
                'title' 			=> esc_html__('Star Rating', 'tatsu'),
                'is_js_dependant' 	=> false,
                'type' 				=> 'single',
                'is_built_in' 		=> true,
                'group_atts'			=> array(
    
                    array(
                        'type'		=> 'tabs',
                        'style'		=> 'style1',
                        'group'		=> array(
    
                            //Tab1
                            array(
                                'type' => 'tab',
                                'title' => esc_html__('Content', 'tatsu'),
                                'group'	=> array(
    
                                    'rating',
                                ),
                            ),
    
                            //Tab2
                            array(
                                'type' => 'tab',
                                'title' => esc_html__('Style', 'tatsu'),
                                'group'	=> array(
                                    array(
                                        'type' => 'accordion',
                                        'active' => 'all',
                                        'group' => array(
                                            array( //Colors Accordion
                                                'type' => 'panel',
                                                'title' => esc_html__('Colors', 'tatsu'),
                                                'group'		=> array(
                                                    'range_color',
                                                    'fill_color',
                                                ),
                                            ),
    
                                            array( //Shape and Size Accordion
                                                'type' => 'panel',
                                                'title' => esc_html__('Alignments', 'tatsu'),
                                                'group'		=> array(
                                                    'alignment',
                                                ),
                                            ),
                                        ),
                                    ),
                                ),
                            ),
    
    
                            //Tab3
                            array(
                                'type' => 'tab',
                                'title' => esc_html__('Advanced', 'tatsu'),
                                'group'	=> array(
                                    array( //spacing and styling accordion
                                        'type' => 'accordion',
                                        'active' => 'none',
                                        'group' => array(
                                            array(
                                                'type' => 'panel',
                                                'title' => esc_html__('Spacing', 'tatsu'),
                                                'group' => array(
                                                    'margin',
                                                )
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
    
                'atts' 				=> array(
                    array(
                        'att_name'		=> 'rating',
                        'type'			=> 'slider',
                        'label'			=> esc_html__('Rating', 'tatsu'),
                        'options'		=> array(
                            'min'		=> '0.5',
                            'max'		=> '5',
                            'step'		=> '0.5'
                        ),
                        'default'		=> '5',
                        'tooltip'		=> '',
                    ),
                    array(
                        'att_name'		=> 'alignment',
                        'type'			=> 'button_group',
                        'is_inline'     => true,
                        'label'			=> esc_html__('Align', 'tatsu'),
                        'options'		=> array(
                            'none'		=> 'None',
                            'left'		=> 'Left',
                            'center'	=> 'Center',
                            'right'		=> 'Right',
                        ),
                        'default'		=> 'none',
                        'tooltip'		=> '',
                    ),
                    array(
                        'att_name'		=> 'range_color',
                        'type'			=> 'color',
                        'label'			=> esc_html__('Range Color', 'tatsu'),
                        'default'		=> '',
                        'tooltip'		=> '',
                        'css'			=> true,
                        'selectors'		=> array(
                            '.tatsu-{UUID} .tatsu-star-rating-range'	 => array(
                                'property'		=> 'color'
                            )
                        )
                    ),
                    array(
                        'att_name'		=> 'fill_color',
                        'type'			=> 'color',
                        'label'			=> esc_html__('Fill Color', 'tatsu'),
                        'default'		=> '#F5C74D',
                        'tooltip'		=> '',
                        'options'		=> array(
                            'gradient'	=> true,
                        ),
                        'css'			=> true,
                        'selectors'		=> array(
                            '.tatsu-{UUID} .tatsu-star-rating-filled'	 => array(
                                'property'		=> 'color'
                            )
                        )
                    ),
                    array(
                        'att_name' => 'margin',
                        'type' => 'input_group',
                        'label' => esc_html__('Margin', 'tatsu'),
                        'default' => '0 0 10px 0',
                        'tooltip' => '',
                        'css'	  => true,
                        'responsive'	=> true,
                        'selectors'	=> array(
                            '.tatsu-{UUID}.tatsu-module'	=> array(
                                'property'		=> 'margin',
                            )
                        )
                    ),
                ),
            );
            tatsu_register_module('tatsu_star_rating', $controls);
        }
    }