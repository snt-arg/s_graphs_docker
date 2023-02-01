<?php
if( !function_exists( 'tatsu_interactive_box' ) ) {
    function tatsu_interactive_box($atts,$content, $tag) {
        
        $atts =  shortcode_atts( array (
            'style'                 => 'style1',
            'flip_type'             => 'horizontal',
            'alignment'             => 'center',
            'overlay'               => 'null',
            'overlay_color'         => '',
			'overlay_blend_mode'    => '',
            'title'                 => '',
            'title_font'            => '',
            'title_color'           => '',
            'title_hover_color'     => '',
            'icon'                  => 'none',
            'svg_icon'              => '',
            'icon_size'             => '',
            'new_tab'               => '',
            'icon_color'            => '',
            'icon_hover_color'      => '',
            'border' => '',
            'border_color' => '',
            'border_style' => '',
            'border_radius'         => '',
            'content_color'         => '',
            'content_hover_color'   => '',
			'url'                   => '',
            'bg_image'              => '',
            'custom_height'         => 'null',
            'height'                => '',
            'vertical_alignment'    => 'center',
			'bg_color'              => '',
            'hover_bg_color'        => '',
            'strip_bg_color'        => '',
            'arrow_color'           => '',
            'box_shadow'            => '',
			'key'                   => be_uniqid_base36(true),
		),$atts, $tag );

        extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, $tag, $atts['key'] );
        $custom_class_name = ' tatsu-'.$atts['key'];

        $style = !empty( $style ) ? $style : 'stacked';
        $bg_image = !empty( $bg_image ) ? $bg_image : '';
        $icon = !empty( $icon ) ? $icon : '';

        $css_id = be_get_id_from_atts( $atts );
        $visibility_classes = be_get_visibility_classes_from_atts( $atts );
        
        $classes = array( 'tatsu-interactive-box', 'tatsu-module', $custom_class_name );
        $new_tab = !empty( $new_tab ) ? true : false;

        //classes
        $classes[] = 'tatsu-interactive-box-' . $style;
        if( !empty( $visibility_classes ) ) {
            $classes[] = $visibility_classes;
        }
        if( 'flip' == $style && !empty( $flip_type ) ) {
            $classes[] = 'tatsu-interactive-box-flip-' . $flip_type;
        }
        if( !empty($alignment) ) {
            $classes[] = 'tatsu-interactive-box-align-' . $alignment;
        }
        if( !empty( $bg_image ) ) {
            $classes[] = 'tatsu-interactive-box-with-bg-image';
        }
        if( 'flip' !== $style ) {
            if( !empty( $overlay ) || ( isset( $overlay_blend_mode ) && $overlay_blend_mode !== 'none' ) ) {
            $classes[] = 'tatsu-interactive-box-overlay';
            }
            if( !empty( $height ) ) {
                $classes[] = 'tatsu-interactive-box-custom-height';
            }
        }
        if( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) {
            $classes[] = 'tatsu-animate';
        }
        $data_attrs = be_get_animation_data_atts( $atts );
        $overlay_class = 'flip' === $style && (!empty( $overlay ) || ( isset( $overlay_blend_mode ) && $overlay_blend_mode !== 'none' ) ) ? 'tatsu-interactive-box-overlay' : '';

        $url = !empty( $url ) ? $url : '';

        if( 'transform' === $style ) {
            $svg_icon_html = tatsu_get_svg_icon( $svg_icon );
            if( empty( $svg_icon_html ) ) {
                $classes[] = 'tatsu-interactive-box-allow-overflow';
            }
        }

        $classes = implode( ' ', $classes );
        ob_start();
        ?>
            <div <?php echo $css_id; ?> class = "<?php echo $classes; ?>" <?php echo $data_attrs; ?>>
                <?php echo $custom_style_tag; ?>
                <?php if( !empty( $url ) ) : ?>
                    <a class = "tatsu-interactive-box-link" <?php echo $new_tab ? 'target="_blank"' : '' ?> href = "<?php echo $url; ?>">
                    </a>
                <?php endif; ?>
                <?php if( 'flip' === $style ) : ?>
                    <div class = "tatsu-interactive-box-flip-wrap">
                        <div class = "tatsu-interactive-box-front <?php echo $overlay_class; ?>">
                            <div class = "tatsu-interactive-box-header">
                                <div class = "tatsu-interactive-box-icon">
                                    <i class = "tatsu-icon <?php echo $icon; ?>">
                                    </i>
                                </div>
                                <div class = "tatsu-interactive-box-title <?php echo $title_font; ?>">
                                    <?php echo $title; ?>
                                </div>
                            </div>
                        </div>
                        <div class = "tatsu-interactive-box-back <?php echo $overlay_class; ?>">
                            <div class = "tatsu-interactive-box-content">
                                <?php echo $content; ?>
                            </div>
                        </div>
                    </div>
                <?php endif;?>
                <?php if( 'stacked' === $style ) : ?>
                    <div class = "tatsu-interactive-box-stacks">
                        <?php if( !empty( $bg_image ) ) : ?>
                            <div class = "tatsu-interactive-box-image-holder">
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class = "tatsu-interactive-box-inner">
                        <div class = "tatsu-interactive-box-header">
                            <div class = "tatsu-interactive-box-icon">
                                <i class = "tatsu-icon <?php echo $icon; ?>">
                                </i>
                            </div>
                            <div class = "tatsu-interactive-box-title <?php echo $title_font; ?>">
                                <?php echo $title; ?>
                            </div>
                        </div>
                        <div class = "tatsu-interactive-box-content">
                            <?php echo $content; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if( 'transform' === $style ) : ?>
                    <?php  ?>
                    <div class = "tatsu-interactive-box-inner">
                        <div class = "tatsu-interactive-box-icon-content">
                            <?php if( !empty( $svg_icon_html ) ) : ?>
                                <div class = "tatsu-interactive-box-icon tatsu-line-animate">
                                    <?php echo $svg_icon_html; ?>
                                </div>
                            <?php endif; ?>
                            <div class = "tatsu-interactive-box-title <?php echo $title_font; ?>">
                                <?php echo $title; ?>
                            </div>
                            <div class = "tatsu-interactive-box-content">
                                <?php echo $content; ?>
                            </div>
                        </div>
                        <div class = "tatsu-interactive-box-arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 43 29">
                                <g fill="none" stroke-linecap="round" stroke-width="3" transform="translate(2 2)">
                                    <path d="M0.106550075,12.6101838 L38.2937419,12.6101838"/>
                                    <polyline stroke-linejoin="round" points="27.042 0 39.31 12.581 27.042 25.161"/>
                                </g>
                            </svg>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php 
            return ob_get_clean();        
    }
}

if( !function_exists( 'tatsu_interactive_box_remove_atts' ) ){
	function tatsu_interactive_box_remove_atts( $atts ){
		if( array_key_exists('overlay', $atts) && $atts['overlay'] == '0' ){
			$atts['overlay_color'] = '';
		}

        if( array_key_exists('custom_height', $atts) && $atts['custom_height'] == '0' ){
			$atts['height'] = '';
		}

		return $atts;
	}

	add_filter('tatsu_interactive_box_before_css_generation', 'tatsu_interactive_box_remove_atts');
}

add_action('tatsu_register_modules', 'tatsu_register_interactive_box', 8);
function tatsu_register_interactive_box() {
	$controls = array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#interactive_box',
		'title' => esc_html__('Interactive Box', 'tatsu'),
		'is_js_dependant' => false,
		'type' 				=> 'single',
		'child_module' => '',
		'is_built_in' => true,
		'hint' => 'title',
		'group_atts' => array(
			array(
				'type'	=>	'tabs',
				'style'	=>	'style1',
				'group'	=>	array(
					array(
						'type'	=>	'tab',
						'title'	=>	esc_html__('Content', 'tatsu'),
						'group'	=>	array(
							'icon',
							'svg_icon',
							'title',
                            'url',
                            'new_tab',
							'content',
						)
					),
					array(
						'type'	=>	'tab',
						'title'	=>	esc_html__('Style', 'tatsu'),
						'group'	=>	array(
                            'style',
                            'alignment',
                            'title_font',
                            'icon_size',
                            'height',
                            'vertical_alignment',
							array(
								'type' => 'accordion',
								'active' => 'none',
								'group' => array(
									array(
										'type' =>	'panel',
										'title' =>	esc_html__('Background', 'tatsu'),
										'group' =>	array(
											'bg_image',
											'overlay_blend_mode',
											'overlay_color',
											'bg_color',
											'hover_bg_color',
										)
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Colors', 'tatsu'),
										'group' => array(
											array(
												'type'	=>	'tabs',
												'style'	=>	'style1',
												'group'	=>	array(
													array(
														'type'	=>	'tab',
														'title'	=>	esc_html__('Normal', 'tatsu'),
														'group'	=>	array(
															'title_color',
															'icon_color',
															'content_color',
														)
													),
													array(
														'type'	=>	'tab',
														'title'	=>	esc_html__('Hover', 'tatsu'),
														'group'	=>	array(
															'title_hover_color',
															'icon_hover_color',
															'content_hover_color',
															'arrow_color',
														)
													),
												)
											),
										)
									),
								)
							)
						),
					),
					array(
						'type'	=>	'tab',
						'title'	=>	esc_html__('Advanced', 'tatsu'),
						'group'	=>	array(
							array(
								'type' => 'accordion',
								'active' => 'none',
								'group' => array(
									array(
										'type'	=>	'panel',
										'title'	=>	esc_html__('Border', 'tatsu'),
										'group'	=>	array(
											'border_style',
                                            'border',
                                            'border_color',
                                            'border_radius',
										)
                                    ),
                                    array(
										'type'	=>	'panel',
										'title'	=>	esc_html__('Shadow', 'tatsu'),
										'group'	=>	array(
											'box_shadow'
										)
                                    ),
								)
							),
						)
					),
				)
			),
		),	
		'atts' => array_values(
			array_filter(
				array(
					array(
						'att_name' => 'style',
                        'type' => 'select',
						'label' => esc_html__('Style', 'tatsu'),
						'options' => array(
							'flip' 		=> '3D Flip',
							'stacked' 	=> 'Stacked',
							'transform'	=> 'Offset'
						),
						'default' => 'stacked',
						'tooltip' => ''
					),
					array(
						'att_name' => 'alignment',
                        'type' => 'select',
						'label' => esc_html__('Alignment', 'tatsu'),
						'options' => array(
							'left' => 'Left',
							'center' => 'Center',
							'right' => 'Right',
						),
						'default' => 'center',
						'tooltip' => ''
					),
					array(
						'att_name' => 'url',
						'type' => 'text',
                        'label' => esc_html__('Link URL', 'tatsu'),
                        'options' => array(
                            'placeholder' => 'https://example.com',
                        ),
						'is_inline' => true,
						'default' => '',
						'tooltip' => ''
					),
					array(
						'att_name' => 'bg_image',
						'type' => 'single_image_picker',
						'label' => esc_html__('Image', 'tatsu'),
						'tooltip' => '',
						'css' => true,
						'selectors'		=> array(
							'.tatsu-{UUID} .tatsu-interactive-box-front' 		=> array(
								'property'	=> 'background-image',
								'when'		=> array('style', '=', 'flip')
							),
							'.tatsu-{UUID} .tatsu-interactive-box-back'  		=> array(
								'property'	=> 'background-image',
								'when'		=> array('style', '=', 'flip')
							),
							'.tatsu-{UUID} .tatsu-interactive-box-image-holder' => array(
								'property'	=> 'background',
								'when'		=> array('style', '=', 'stacked'),
								'prepend'	=> 'url(',
								'append' 	=> ') center/cover scroll'
							),
							'.tatsu-{UUID} .tatsu-interactive-box-stacks::before' => array(
								'property'	=> 'background',
								'when'		=> array('style', '=', 'stacked'),
								'prepend'	=> 'url(',
								'append' 	=> ') center/cover scroll'
							),
							'.tatsu-{UUID} .tatsu-interactive-box-stacks::after' => array(
								'property'	=> 'background',
								'when'		=> array('style', '=', 'stacked'),
								'prepend'	=> 'url(',
								'append' 	=> ') center/cover scroll'
							),
							'.tatsu-{UUID}.tatsu-interactive-box-transform'		=> array(
								'property'	=> 'background',
								'when'		=> array('style', '=', 'transform'),
								'prepend'	=> 'url(',
								'append' 	=> ') center/cover scroll'
							)
						)
					),
					array(
						'att_name'		=> 'new_tab',
						'type'			=> 'switch',
						'label'			=> esc_html__('Open in new tab', 'tatsu'),
						'default'		=> '0'
					),
					array(
						'att_name' => 'overlay_blend_mode',
						'type' => 'select',
						'label' => esc_html__('Blend Mode', 'tatsu'),
						'options' => tatsu_get_blend_modes(),
						'visible'		=> array('bg_image', '!=', ''),
						'default' => 'normal',
						'tooltip' => '',
						'css' => true,
						'selectors'		=> array(
							'.tatsu-{UUID} .tatsu-interactive-box-overlay::before' => array(
								'property'	=> 'mix-blend-mode',
								'when'		=> array('bg_image', 'notempty')
							),
							'.tatsu-{UUID}.tatsu-interactive-box-overlay::before'  => array(
								'property'	=> 'mix-blend-mode',
								'when'		=> array(
									array('bg_image', 'notempty'),
									array('style', '!=', 'flip')
								),
								'relation'	=> 'and'
							)
						),
						'default'		=> 'normal'
					),
					array(
						'att_name'		=> 'overlay_color',
						'type'			=> 'color',
						'options'		=> array(
							'gradient'	=> true
						),
						'label'			=> esc_html__('Overlay Color', 'tatsu'),
						'visible'		=> array(
							'condition' => array(
								array( 'bg_image', '!=', '' ),
								array( 'overlay_blend_mode', '!=', 'none' )
							),
							'relation'	=> 'and',
						),
						'css'			=> true,
						'selectors'		=> array(
							'.tatsu-{UUID} .tatsu-interactive-box-overlay::before' => array(
								'property'	=> 'background',
								'when'		=> array(
									array('bg_image', 'notempty'),
									array('overlay_blend_mode', '!=', 'none'),
								),
								'relation'	=> 'and'
							),
							'.tatsu-{UUID}.tatsu-interactive-box-overlay::before'  => array(
								'property'	=> 'background',
								'when'		=> array(
									array('bg_image', 'notempty'),
									array('style', '!=', 'flip'),
									array('overlay_blend_mode', '!=', 'none'),
								),
								'relation'	=> 'and'
							)
						),
						'default'		=> 'rgba(0, 0, 0, 0.5)'
					),
					array(
						'att_name' => 'bg_color',
						'type' => 'color',
						'label' => esc_html__('Color', 'tatsu'),
						'default' => '',
						'tooltip' => '',
						'visible' => array( 'bg_image', '=', '' ),
						'options' => array(
							'gradient'	=> true
						),
						'css' => true,
						'selectors' => array(
							'.tatsu-{UUID}.tatsu-interactive-box-stacked' => array(
								'property'		=> 'background',
								'when'			=> array(
									array('style', '=', 'stacked'),
									array('bg_image', 'empty')
								),
								'relation'		=> 'and',
							),
							'.tatsu-{UUID} .tatsu-interactive-box-front' 	=> array(
								'property'		=> 'background',
								'when'			=> array(
									array('style', '=', 'flip'),
									array('bg_image', 'empty')
								),
								'relation'		=> 'and'
							),
							'.tatsu-{UUID} .tatsu-interactive-box-back'	=> array(
								'property'		=> 'background',
								'when'			=> array(
									array('style', '=', 'flip'),
									array('bg_image', 'empty')
								),
								'relation'		=> 'and'
							),
							'.tatsu-{UUID}.tatsu-interactive-box-transform'	=> array(
								'property'		=> 'background',
								'when'			=> array(
									array('style', '=', 'transform'),
									array('bg_image', 'empty')
								),
								'relation'		=> 'and'
							),
						)
					),
					array(
						'att_name' => 'hover_bg_color',
						'type' => 'color',
						'label' => esc_html__('Hover Color', 'tatsu'),
						'default' => '',
						'tooltip' => '',
						'visible' => array('bg_image', '=', ''),
						'css' => true,
						'options'	=> array(
							'gradient'	=> true
						),
						'selectors' => array(
							'.tatsu-{UUID} .tatsu-interactive-box-stacks' => array(
								'property'		=> 'background',
								'when'			=> array(
									array('style', '=', 'stacked'),
									array('bg_image', 'empty')
								),
								'relation'		=> 'and',
							),
							'.tatsu-{UUID} .tatsu-interactive-box-back'	=> array(
								'property'		=> 'background',
								'when'			=> array(
									array('style', '=', 'flip'),
									array('bg_image', 'empty')
								),
								'relation'		=> 'and'
							),
							'.tatsu-{UUID}.tatsu-interactive-box-transform::after' => array(
								'property'		=> 'background',
								'when'			=> array(
									array('style', '=', 'transform'),
									array('bg_image', 'empty')
								),
								'relation'		=> 'and'
							)
						),
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
                        'default' => array( 'd' => 'solid', 'l' => 'solid', 't' => 'solid', 'm' => 'solid' ),
                        'exclude' => array( 'tatsu_image' ),
                        'tooltip' => '',
						'css' => true,
						'responsive' => true,
                        'selectors' => array(
                            '.tatsu-{UUID}.tatsu-interactive-box' => array(
								'property'	=> 'border-style',
								'when' => array(
									array( 'border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
									array( 'border', 'notempty' ),
                                    array( 'border_style', '!=',  array( 'd' => 'none' ) ),
                                    array('style', '!=', 'flip'),
                                ),
                                'relation' => 'and',
							),
							'.tatsu-{UUID} .tatsu-interactive-box-front' => array(
								'property'	=> 'border-style',
								'when' => array(
									array( 'border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
									array( 'border', 'notempty' ),
                                    array( 'border_style', '!=',  array( 'd' => 'none' ) ),
                                    array('style', '=', 'flip'),
                                ),
                                'relation' => 'and',
							),
							'.tatsu-{UUID} .tatsu-interactive-box-back' => array(
								'property'	=> 'border-style',
								'when' => array(
									array( 'border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
									array( 'border', 'notempty' ),
                                    array( 'border_style', '!=',  array( 'd' => 'none' ) ),
                                    array('style', '=', 'flip'),
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
                        'exclude' => array( 'tatsu_image', 'tatsu_lists' ),
                        'tooltip' => '',
                        'responsive' => true,
                        'css' => true,
                        'selectors' => array(
                            '.tatsu-{UUID}.tatsu-interactive-box' => array(
								'property'	=> 'border-width',
								'when' => array(
                                    array('border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
                                    array( 'border_style', '!=', 'none' ),
                                    array('style', '!=', 'flip')
                                ),
                                'relation' => 'and',
							),
							'.tatsu-{UUID} .tatsu-interactive-box-front' => array(
								'property'	=> 'border-width',
								'when' => array(
                                    array('border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
                                    array( 'border_style', '!=', 'none' ),
                                    array('style', '=', 'flip')
                                ),
                                'relation' => 'and',
							),
							'.tatsu-{UUID} .tatsu-interactive-box-back' => array(
								'property'	=> 'border-width',
								'when' => array(
                                    array('border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
                                    array( 'border_style', '!=', 'none' ),
                                    array('style', '=', 'flip')
                                ),
                                'relation' => 'and',
							),
                        ),
                    ),
                    array (
                        'att_name' => 'border_color',
                        'type' => 'color',
                        'label' => esc_html__( 'Border Color', 'tatsu' ),
                        'default' => '',
                        'exclude' => array( 'tatsu_image', 'tatsu_lists', 'tatsu_call_to_action', 'tatsu_icon', 'tatsu_tabs', 'tatsu_accordion' ),
                        'tooltip' => '',
                        'css' => true,
                        'selectors' => array(
                            '.tatsu-{UUID}.tatsu-interactive-box' => array(
								'property'	=> 'border-color',
								'when' => array(
                                    array('border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
                                    array( 'border_style', '!=', 'none' ),
                                    array('style', '!=', 'flip'),
                                ),
                                'relation' => 'and',
							),
							'.tatsu-{UUID} .tatsu-interactive-box-front' => array(
								'property'	=> 'border-color',
								'when' => array(
                                    array('border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
                                    array( 'border_style', '!=', 'none' ),
                                    array('style', '=', 'flip'),
                                ),
                                'relation' => 'and',
							),
							'.tatsu-{UUID} .tatsu-interactive-box-back' => array(
								'property'	=> 'border-color',
								'when' => array(
                                    array('border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
                                    array( 'border_style', '!=', 'none' ),
                                    array('style', '=', 'flip'),
                                ),
                                'relation' => 'and',
							),
                        ),
                    ),
					array(
						'att_name' => 'border_radius',
						'type' => 'number',
						'label' => esc_html__('Border Radius', 'tatsu'),
						'options' => array(
							'unit' => 'px',
						),
						'default' => '4',
						'tooltip' => '',
						'css' => true,
						'selectors' => array(
							'.tatsu-{UUID}.tatsu-interactive-box' => array(
								'property'	=> 'border-radius',
								'when'		=> array('style', '!=', 'flip'),
								'append'	=> 'px'
							),
							'.tatsu-{UUID} .tatsu-interactive-box-front' => array(
								'property'	=> 'border-radius',
								'when'		=> array('style', '=', 'flip'),
								'append'	=> 'px'
							),
							'.tatsu-{UUID} .tatsu-interactive-box-back' => array(
								'property'	=> 'border-radius',
								'when'		=> array('style', '=', 'flip'),
								'append'	=> 'px'
							),
						)
					),
					array(
						'att_name' => 'height',
                        'type' => 'number',
                        'is_inline' => true,
						'label' => esc_html__('Height', 'tatsu'),
						'options' => array(
							'unit' => 'px',
						),
						'default' => '',
						'tooltip' => '',
						'css' => true,
						'selectors' => array(
							'.tatsu-{UUID} .tatsu-interactive-box-back'   => array(
								'property'		=> 'min-height',
								'append'		=> 'px',
								'when'			=> array(
									array('height', 'notempty'),
									array('style', '=', 'flip')
								),
								'relation'	=> 'and'
							),
							'.tatsu-{UUID}.tatsu-interactive-box-custom-height' => array(
								'property'		=> 'min-height',
								'append'		=> 'px',
								'when'			=> array(
									array('height', 'notempty'),
									array('style', '!=', 'flip')
								),
								'relation'	=> 'and'
							),
						),
					),
					array(
						'att_name'		=> 'vertical_alignment',
                        'type'			=> 'select',
						'label'			=> esc_html__('Vertical Alignment', 'tatsu'),
						'default'		=> 'center',
						'visible'		=> array('height', '!=', ''),
						'options'		=> array(
							'flex-start' => 'Top',
							'center'	=> 'Center',
							'flex-end'	=> 'Bottom'
						),
						'tooltip'		=> '',
						'css'			=> true,
						'responsive'	=> true,
						'selectors'		=> array(
							'.tatsu-{UUID} .tatsu-interactive-box-front'	=> array(
								'property'		=> 'align-items',
								'when'			=> array(
									array('height', 'notempty'),
									array('style', '=', 'flip')
								),
								'relation'	=> 'and'
							),
							'.tatsu-{UUID} .tatsu-interactive-box-back'	=> array(
								'property'		=> 'align-items',
								'when'			=> array(
									array('height', 'notempty'),
									array('style', '=', 'flip')
								),
								'relation'	=> 'and'
							),
							'.tatsu-{UUID}.tatsu-interactive-box-custom-height'	=> array(
								'property'		=> 'align-items',
								'when'			=> array(
									array('height', 'notempty'),
									array('style', '!=', 'flip')
								),
								'relation'	=> 'and'
							),
						)
					),
					array(
						'att_name' => 'icon',
						'type' => 'icon_picker',
						'label' => esc_html__('Icon', 'tatsu'),
						'default' => '',
						'visible'	=> array('style', '!=', 'transform'),
						'tooltip' => ''
					),
					array(
						'att_name'		=> 'svg_icon',
						'type'			=> 'svg_icon_picker',
						'label'			=> esc_html__('Icon', 'tatsu'),
						'default'		=> 'linea:basic_paperplane',
						'visible'		=> array('style', '=', 'transform'),
						'tooltip'		=> '',
					),
					array(
						'att_name' => 'icon_size',
						'type' => 'slider',
						'label' => esc_html__('Icon Size', 'tatsu'),
						'options'	=> array(
							'min'	=> '0',
							'max'	=> '100',
							'step'	=> '1'
						),
						'default'	=> '42',
						'tooltip' => '',
						'css'	  => true,
						'selectors'	=> array(
							'.tatsu-{UUID} .tatsu-interactive-box-icon' => array(
								'property'		=> 'font-size',
								'append'		=> 'px',
								'when'			=> array('style', '!=', 'transform')
							),
							'.tatsu-{UUID} .tatsu-interactive-box-icon svg' => array(
								'property'		=> array('width', 'height'),
								'append'		=> 'px',
								'when'			=> array('style', '=', 'transform')
							),
							'.tatsu-{UUID}:hover .tatsu-interactive-box-icon-content' => array(
								'property'		=> 'transformY',
								'operation'		=> array('+', 20),
								'prepend'		=> '-',
								'append'		=> 'px',
								'when'			=> array('style', '=', 'transform')
							),
							'.tatsu-{UUID} .tatsu-interactive-box-arrow' => array(
								'property'		=> 'height',
								'append'		=> 'px',
								'when'			=> array('style', '=', 'transform')
							)
						)
					),
					array(
						'att_name' => 'icon_color',
						'type' => 'color',
						'label' => esc_html__('Icon', 'tatsu'),
						'default' => '',
						'tooltip' => '',
						'css' => true,
						'selectors' => array(
							'.tatsu-{UUID} .tatsu-interactive-box-icon' 		=> array(
								'property'		=> 'color',
								'when'			=> array('style', '!=', 'transform')
							),
							'.tatsu-{UUID} .tatsu-interactive-box-icon svg' 	=> array(
								'property'		=> 'color',
								'when'			=> array('style', '=', 'transform')
							)
						),
					),
					array(
						'att_name'	=> 'icon_hover_color',
						'type'		=> 'color',
						'label'		=> esc_html__('Icon', 'tatsu'),
						'default'	=> '',
						'tooltip'	=> '',
						'visible'	=> array('style', '=', 'stacked'),
						'css'		=> true,
						'selectors' => array(
							'.tatsu-{UUID}:hover .tatsu-interactive-box-icon'	=> array(
								'property'		=> 'color',
								'when'			=> array('style', '=', 'stacked'),
							)
						)
					),
					array(
						'att_name' => 'title',
						'type' => 'text',
						'label' => esc_html__('Title', 'tatsu'),
						'default' => '',
						'tooltip' => ''
					),
					function_exists('typehub_get_exposed_selectors') ? array(
						'att_name'	=> 'title_font',
						'type'		=> 'select',
						'label'		=> esc_html__('Title Font', 'tatsu'),
						'default'	=> 'h5',
						'options'	=> typehub_get_exposed_selectors()
					) : false,
					array(
						'att_name' => 'title_color',
						'type' => 'color',
						'label' => esc_html__('Title', 'tatsu'),
						'default' => '',
						'tooltip' => '',
						'css' => true,
						'selectors' => array(
							'.tatsu-{UUID} .tatsu-interactive-box-title'	=> array(
								'property'		=> 'color'
							)
						),
					),
					array(
						'att_name'	=> 'title_hover_color',
						'type'		=> 'color',
						'label'		=> esc_html__('Title', 'tatsu'),
						'default'	=> '',
						'tooltip'	=> '',
						'visible'	=> array('style', '!=', 'flip'),
						'css'		=> true,
						'selectors' => array(
							'.tatsu-{UUID}:hover .tatsu-interactive-box-title'	=> array(
								'property'		=> 'color',
								'when'			=> array('style', '!=', 'flip'),
							),
						)
					),
					array(
						'att_name' => 'content',
						'type' => 'tinymce',
						'label' => esc_html__('Content', 'tatsu'),
						'default' => '',
						'tooltip' => ''
					),
					array(
						'att_name' => 'content_color',
						'type' => 'color',
						'label' => esc_html__('Content', 'tatsu'),
						'default' => '',
						'tooltip' => '',
						'visible'	=> array('style', '!=', 'flip'),
						'css' => true,
						'selectors' => array(
							'.tatsu-{UUID} .tatsu-interactive-box-content' => array(
								'property' => 'color',
								'when'	   => array('style', '!=', 'flip'),
							),
						),
					),
					array(
						'att_name' => 'content_hover_color',
						'type' => 'color',
						'label' => esc_html__('Content', 'tatsu'),
						'default' => '',
						'tooltip' => '',
						//'visible'	=> array('style', '!=', 'flip'),
						'css' => true,
						'selectors' => array(
							'.tatsu-{UUID}:hover .tatsu-interactive-box-content' => array(
								'property' => 'color',
								'when'	   => array('style', '!=', 'flip'),
							),
							'.tatsu-{UUID} .tatsu-interactive-box-content' => array(
								'property' => 'color',
								'when'	   => array('style', '=', 'flip'),
							),
						),
					),
					array(
						'att_name' => 'arrow_color',
						'type' => 'color',
						'label' => esc_html__('Arrow', 'tatsu'),
						'default' => '#fff',
						'tooltip' => '',
						'visible' => array('style', '=', 'transform'),
						'css' => true,
						'selectors' => array(
							'.tatsu-{UUID} .tatsu-interactive-box-arrow svg' => array(
								'property' => 'stroke',
								'when'	   => array('style', '=', 'transform'),
							),
						),
					),
					array(
						'att_name'		=> 'box_shadow',
						'type' 			=> 'input_box_shadow',
						'label' 		=> esc_html__('Box Shadow', 'tatsu'),
						'tooltip' 		=> '',
						'default' 		=> '0 1px 6px 0 rgba(0,0,0,0.1)',
						'css' => true,
						'selectors' => array(
							'.tatsu-{UUID}.tatsu-interactive-box' => array(
								'property' => 'box-shadow',
								'when'	   => array('style', '!=', 'flip')
							),
							'.tatsu-{UUID} .tatsu-interactive-box-front' => array(
								'property' => 'box-shadow',
								'when'	   => array('style', '=', 'flip')
							),
						),
					),
				)
			)
		),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'style'	 => 'stacked',
					'hover_bg_color' => array('id' => 'palette:0', 'color' => tatsu_get_color('tatsu_accent_color')),
					'title' => 'Title Goes Here',
					'content' => '<p >Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.</p>',
					'icon_color'  => array('id' => 'palette:0', 'color' => tatsu_get_color('tatsu_accent_color')),
					'icon_hover_color'	=> array('id' => 'palette:1', 'color' => tatsu_get_color('tatsu_accent_twin_color')),
					'icon'		  => 'tatsu-icon-user',
					'icon_size'	  => '30',
					'title_hover_color'	=> array('id' => 'palette:1', 'color' => tatsu_get_color('tatsu_accent_twin_color')),
					'content_hover_color'	=> array('id' => 'palette:1', 'color' => tatsu_get_color('tatsu_accent_twin_color')),
					'svg_icon_color'	=> array('id' => 'palette:0', 'color' => tatsu_get_color('tatsu_accent_color')),
				),
			)
		),
	);
	tatsu_register_module('tatsu_interactive_box', $controls, 'tatsu_interactive_box');
}