<?php
if( !function_exists( 'tatsu_icon_card' ) ) {
    function tatsu_icon_card( $atts, $content, $tag ) {

        $atts = shortcode_atts( array (
            'style'             => 'style1',
            'icon_type'         => 'icon',
            'horizontal_alignment' => 'center',
            'vertical_alignment'   => 'center',
            'icon'              => '',
            'svg_icon'          => '',
            'image'             => '',
            'bg_size'           => 'cover',
            'icon_style'        => '',
            'icon_bg'           => '',
            'icon_color'        => '',
			'icon_hover_color'  => '',
            'size'              => 'medium',
            'line_animate'      => '0',
            'svg_icon_color'    => '',
			'svg_icon_hover_color' => '',
			'box_shadow'        => '', // Icon's Shadow
			'outer_box_shadow' => '',
            'title'             => '',
            'url'               => '',
			'new_tab'           => 0,
            'title_font'        => '',
            'title_color'       => '',
			'title_hover_color' => '',
            'caption_font'      => '',
            'caption_color'     => '',
            'margin'            => '0 0 60px 0',
            'animate'           => '',
            'animation_type'    => '',
            'animation_delay'   => 0,
            'builder_mode'      => '',
            'hide_in'           => '',
            'key'               => be_uniqid_base36(true),
        ), $atts, $tag );

        extract($atts);

		$url = tatsu_parse_custom_fields( $url );
		$content = do_shortcode( $content );

        $custom_style_tag = be_generate_css_from_atts( $atts, $tag, $atts['key'], $builder_mode );
		$unique_class_name = ' tatsu-'.$atts['key'];
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );
		$classes = array( 'tatsu-module', 'tatsu-icon_card', $unique_class_name, $visibility_classes, $css_classes );
		$animate = ( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) ? ' tatsu-animate' : '' ;
		$data_animations = be_get_animation_data_atts( $atts );
        $icon_type = !empty($icon_type) ? $icon_type : 'icon';

        if(!empty($icon_type)) {
            $classes[] = 'tatsu-icon_card-type-' . $icon_type;
        }
        if( !empty($style) ) {
            $classes[] = 'tatsu-icon_card-' . $style;
        }else {
            $classes[] = 'tatsu-icon_card-style1';
        }
        if( !empty($horizontal_alignment) ) {
            $classes[] ='tatsu-icon_card-align-' . $horizontal_alignment;
        }
        if( 'style1' === $style && !empty($vertical_alignment) ) {
            $classes[] = 'tatsu-icon_card-vertical-align-' . $vertical_alignment;
        }
        if( 'image' !== $icon_type && 'circled' === $icon_style ) {
            $classes[] = 'tatsu-icon_circled';
        }
        if( !empty($size) ) {
            $classes[] = 'tatsu-icon_' . $size;
        }else {
            $classes[] = 'tatsu-icon_medium';
        }
    
        $svg_icon_html = '';
        if( 'svg' === $icon_type ) {
            if( !empty($line_animate) ) {
                $classes[] = 'tatsu-line-animate';
            }
            $svg_icon_html = function_exists( 'tatsu_get_svg_icon' ) ? tatsu_get_svg_icon( $svg_icon ) : '';
        }

        $icon = !empty($icon) ? $icon : '';
        
		$icon_label = ucfirst(str_replace(array('tatsu','icon'),' ',str_replace('-','',$icon)));
        $new_tab = $new_tab ? 'target="_blank"' : '';

        $classes = implode( ' ', $classes );
        ob_start();
    ?>
            <div <?php echo $css_id; ?> class = "<?php echo $classes; ?>" <?php echo $data_animations; ?>>
                <?php echo $custom_style_tag; ?>
                <?php if( ( 'icon' === $icon_type && !empty( $icon ) ) || ( 'svg' === $icon_type && !empty( $svg_icon_html ) ) || ( 'image' === $icon_type && !empty( $image ) ) ) : ?>
                    <div class = "tatsu-icon_card-icon <?php echo 'circled' === $icon_style && 'image' !== $icon_type ? 'tatsu-icon_bg' : ( ( 'plain' === $icon_style && 'image' === $icon_type ) ? 'tatsu-img-plain' : '' ); ?>">
                        <?php if( 'icon' === $icon_type ) : ?>
                            <i aria-label = "<?php echo $icon_label; ?>" class = "tatsu-icon <?php echo $icon; ?>">
                            </i>
                        <?php elseif( 'svg' === $icon_type ) : ?>
                            <?php echo $svg_icon_html; ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php if( !empty( $title ) || !empty( $content ) ) : ?>
                    <div class = "tatsu-icon_card-title-caption">
                        <?php if( !empty( $title ) ) : ?>
                            <div class = "tatsu-icon_card-title <?php echo !empty($title_font) ? $title_font : ''; ?>">
							<?php 
								if(empty($url)){
									echo tatsu_parse_custom_fields( $title );
								}else{
							?>
                                <a href = "<?php echo $url; ?>" <?php echo $new_tab; ?> >
                                    <?php echo tatsu_parse_custom_fields( $title ); ?>
                                </a>
							<?php } ?>
                            </div>
                        <?php endif; ?>
                        <?php if( !empty( $content ) ) : ?>
                            <div class = "tatsu-icon_card-caption <?php echo !empty($caption_font) ? $caption_font : ''; ?>">
                                <?php echo $content; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
    <?php
        return ob_get_clean();
    }
    add_shortcode( 'tatsu_icon_card', 'tatsu_icon_card' );
}


if( !function_exists( 'tatsu_icon_card_header_atts' ) ) {
	function tatsu_icon_card_header_atts( $atts, $tag ) {
		if( 'tatsu_icon_card' === $tag ) {
			// New Atts
			$atts['builder_mode'] = array (
				'type' => '',
				'default' => 'Header',
			);
			// Modify Atts
			$atts['margin'] = 	array (
				'type' => 'input_group',
				'label' => esc_html__( 'Margin', 'tatsu' ),
				'default' => '0px 30px 0px 0px',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-module' => array(
						'property' => 'margin',
					),
				),
            );
            $atts['vertical_alignment']['default'] = 'center';
		}
		return $atts;
	}
	add_filter( 'tatsu_header_modify_atts', 'tatsu_icon_card_header_atts', 10, 2 );
}

add_action('tatsu_register_header_modules', 'tatsu_register_icon_card', 9);
add_action('tatsu_register_modules', 'tatsu_register_icon_card', 7);
function tatsu_register_icon_card()
{
	$controls = array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#icon_card',
		'title' => esc_html__('Multi Purpose Card', 'tatsu'),
		'is_js_dependant' => false,
		'child_module' => '',
		'type' => 'single',
		'is_built_in' => true,
		'hint' => 'title',
		'is_dynamic' => true,
		'group_atts' => array(
			array(
				'type'	=>	'tabs',
				'style'	=>	'style1',
				'group'	=>	array(
					array(
						'type'	=>	'tab',
						'title'	=>	esc_html__('Content', 'tatsu'),
						'group'	=>	array(
							'icon_type',
							'icon',
							'svg_icon',
							'image',
							'bg_size',
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
							array(
								'type' => 'accordion',
								'active' => 'all',
								'group' => array(
									array(
										'type' => 'panel',
										'title' => esc_html__('Shape and Size', 'tatsu'),
										'group' => array(
											'style',
											'icon_style',
											'size',
											'line_animate',
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
															'icon_color',
															'svg_icon_color',
															'title_color',
															'caption_color',
															'icon_bg',
															'box_shadow',
														)
													),
													array(
														'type'	=>	'tab',
														'title'	=>	esc_html__('Hover', 'tatsu'),
														'group'	=>	array(
															'icon_hover_color',
															'svg_icon_hover_color',
															'title_hover_color',
														)
													),
												)
											),
										)
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Alignment', 'tatsu'),
										'group' => array(
											'horizontal_alignment',
											'vertical_alignment',
										)
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Typography', 'tatsu'),
										'group' => array(
											'title_font',
											'caption_font',
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
								'active' => array(0, 1),
								'group' => array(
									array(
										'type'	=>	'panel',
										'title'	=>	esc_html__('Spacing', 'tatsu'),
										'group'	=>	array(
											'margin',
										)
									),
									array(
										'type'	=>	'panel',
										'title'	=>	esc_html__('Shadow', 'tatsu'),
										'group'	=>	array(
											'outer_box_shadow',
										)
									),
								)
							),
						)
					),
				)
			),
		),
		'atts' => array_values(array_filter(array(
			array(
				'att_name' => 'style',
				'type' => 'button_group',
				'is_inline' => true,
				'label' => esc_html__('Style', 'tatsu'),
				'options' => array(
					'style1'	=> 'Adjacent',
					'style2'	=> 'Vertical'
				),
				'default' => 'style1',
				'tooltip' => ''
			),
			array(
				'att_name' => 'horizontal_alignment',
				'type' => 'select',
				'is_inline' => true,
				'label' => esc_html__('Horizontal', 'tatsu'),
				'options' => array(
					'left'		=> 'Left',
					'center'	=> 'Center',
					'right'		=> 'Right'
				),
				'default' => 'center',
				'tooltip' => ''
			),
			array(
				'att_name' 		=> 'vertical_alignment',
				'type' 			=> 'select',
				'is_inline' => true,
				'label' 		=> esc_html__('Vertical', 'tatsu'),
				'options' 		=> array(
					'top'		=> 'Top',
					'center'	=> 'Center',
					'bottom'	=> 'Bottom',
					'baseline'	=> 'Baseline',
				),
				'default' => 'top',
				'visible'	=> array('style', '==', 'style1'),
				'tooltip' => ''
			),
			array(
				'att_name' => 'icon_type',
				'type' => 'button_group',
				'is_inline' => true,
				'label' => esc_html__('Type', 'tatsu'),
				'options' => array(
					'icon' => 'Icon',
					'svg' => 'SVG',
					'image' => 'Image',
				),
				'default' => 'icon',
				'tooltip' => ''
			),
			array(
				'att_name' => 'icon',
				'type' => 'icon_picker',
				'label' => esc_html__('Icon', 'tatsu'),
				'default' => 'icon-monitor',
				'visible' => array('icon_type', '=', 'icon'),
				'tooltip' => ''
			),
			array(
				'att_name' => 'svg_icon',
				'type' => 'svg_icon_picker',
				'label' => esc_html__('Icon', 'tatsu'),
				'default' => 'linea:basic_mail',
				'visible' => array('icon_type', '=', 'svg'),
				'tooltip' => ''
			),
			array(
				'att_name' => 'image',
				'type' => 'single_image_picker',
				'label' => esc_html__('Image', 'tatsu'),
				'visible' => array('icon_type', '=', 'image'),
				'tooltip' => '',
				'default'	=> 'http://via.placeholder.com/150x150',
				'options' => array(
					'size' => 'thumbnail',
				),
				'css'		=> true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-icon_card-icon'	=> array(
						'property'	=> 'background',
						'prepend'	=> 'url(',
						'append'	=> ') center scroll no-repeat',
						'when'	=> array('icon_type', '=', 'image')
					)
				)
			),
			array(
				'att_name' => 'bg_size',
				'type' => 'select',
				'label' => esc_html__('Background Size', 'tatsu'),
				'visible' => array(
					'condition' => array(
						array('icon_type', '=', 'image'),
						array('image', '!=', ''),
					),
					'relation'	=> 'and',
				),
				'options' => array(
					'cover' => 'Cover',
					'contain' => 'Contain',
					'initial' => 'Initial',
				),
				'default' => 'cover',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-icon_card-icon' => array(
						'property' => 'background-size',
						'when' => array(
							array('icon_type', '=', 'image'),
							array('image', '!=', ''),
						),
						'relation' => 'and',
					),
				)
			),
			array(
				'att_name' => 'size',
				'type' => 'button_group',
				'is_inline' => true,
				'label' => esc_html__('Icon Size', 'tatsu'),
				'options' => array(
					'tiny'		=> 'XS',
					'small'		=> 'S',
					'medium'	=> 'M',
					'large'		=> 'L',
					'x-large'	=> 'XL'
				),
				'default' => 'medium',
				'tooltip' => ''
			),
			array(
				'att_name' => 'icon_style',
				'type' => 'button_group',
				'is_inline' => true,
				'label' => esc_html__('Icon Style', 'tatsu'),
				'options' => array(
					'plain' => 'Plain',
					'circled' => 'Circled'
				),
				'default' => 'plain',
				'tooltip' => ''
			),
			array(
				'att_name' => 'icon_bg',
				'type' => 'color',
				'visible'	=> array(
					'relation'	=> 'and',
					'condition'	=> array(
						array('icon_type', '!=', 'image'),
						array('icon_style', '=', 'circled'),
					)
				),
				'options' => array(
					'gradient' => true,
				),
				'label' => esc_html__('Icon Background Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css'	  => true,
				'selectors'	=> array(
					'.tatsu-{UUID} .tatsu-icon_bg'	=> array(
						'property'		=> 'background',
						'when'			=> array(
							array('icon_style', '=', 'circled'),
							array('icon_type', '!=', 'image')
						),
						'relation'		=> 'and'
					)
				)
			),
			array(
				'att_name' => 'icon_color',
				'type' => 'color',
				'visible'	=> array('icon_type', '=', 'icon'),
				'options' => array(
					'gradient' => true,
				),
				'label' => esc_html__('Icon Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css'	  => true,
				'selectors'	=> array(
					'.tatsu-{UUID} .tatsu-icon'	=> array(
						'property'		=> 'color',
						'when'			=> array('icon_type', '=', 'icon')
					)
				)
			),
			array(
				'att_name' => 'icon_hover_color',
				'type' => 'color',
				'visible'	=> array('icon_type', '=', 'icon'),
				'options' => array(
					'gradient' => true,
				),
				'label' => esc_html__('Icon Hover Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css'	  => true,
				'selectors'	=> array(
					'.tatsu-{UUID} .tatsu-icon:hover'	=> array(
						'property'		=> 'color',
						'when'			=> array('icon_type', '=', 'icon')
					)
				)
			),
			array(
				'att_name'	=> 'svg_icon_color',
				'type' => 'color',
				'visible'	=> array('icon_type', '=', 'svg'),
				'label' => esc_html__('Icon Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css'	  => true,
				'selectors'	=> array(
					'.tatsu-{UUID} .tatsu-icon_card-icon svg' => array(
						'property'		=> 'color',
						'when'			=> array('icon_type', '=', 'svg')
					)
				)
			),
			array(
				'att_name'	=> 'svg_icon_hover_color',
				'type' => 'color',
				'visible'	=> array('icon_type', '=', 'svg'),
				'label' => esc_html__('Icon Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css'	  => true,
				'selectors'	=> array(
					'.tatsu-{UUID} .tatsu-icon_card-icon svg:hover' => array(
						'property'		=> 'color',
						'when'			=> array('icon_type', '=', 'svg')
					)
				)
			),
			array(
				'att_name'	=> 'line_animate',
				'type' => 'switch',
				'visible'	=> array('icon_type', '=', 'svg'),
				'label' => esc_html__('Enable Line Animation', 'tatsu'),
				'default' => '0',
				'tooltip' => '',
			),
			array(
				'att_name'			=> 'box_shadow',
				'label'				=> esc_html__('Icon Shadow', 'tatsu'),
				'type'				=> 'input_box_shadow',
				'visible'			=> array(
					'relation'		=> 'or',
					'condition'		=> array(
						array('icon_type', '=', 'image'),
						array('icon_style', '=', 'circled')
					)
				),
				'default'			=> '0px 0px 0px 0px rgba(0,0,0,0)',
				'css'				=> true,
				'selectors'			=> array(
					'.tatsu-{UUID} .tatsu-icon_card-icon' => array(
						'property'	=> 'box-shadow',
						'when'		=> array(
							array('icon_type', '=', 'image'),
							array('icon_style', '=', 'circled')
						),
						'relation'	=> 'or'
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
			array(
				'att_name'	 => 'url',
				'type' => 'text',
				'label' => esc_html__('Title Link URL', 'tatsu'),
				'default' => '',
				'tooltip' => ''
			),
			array(
				'att_name'	 => 'new_tab',
				'type' => 'switch',
				'label' => esc_html__('Open Link in New Tab', 'tatsu'),
				'default' => 0,
				'tooltip' => ''
			),
			function_exists('typehub_get_exposed_selectors') ? array(
				'att_name'	=> 'title_font',
				'type'		=> 'select',
				'label'		=> esc_html__('Title Font', 'tatsu'),
				'default'	=> 'h6',
				'options'	=> typehub_get_exposed_selectors()
			) : false,
			array(
				'att_name' => 'title_color',
				'type' => 'color',
				'label' => esc_html__('Title Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'options'	=> array(
					'gradient'	=> true
				),
				'css'	=> true,
				'selectors'	=> array(
					'.tatsu-{UUID} .tatsu-icon_card-title, .tatsu-{UUID} .tatsu-icon_card-title a' => array(
						'property'		=> 'color',
					)
				)
			),
			array(
				'att_name' => 'title_hover_color',
				'type' => 'color',
				'label' => esc_html__('Title Hover Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'options'	=> array(
					'gradient'	=> true
				),
				'css'	=> true,
				'selectors'	=> array(
					'.tatsu-{UUID} .tatsu-icon_card-title:hover, .tatsu-{UUID} .tatsu-icon_card-title a:hover' => array(
						'property'		=> 'color',
					)
				)
			),
			array(
				'att_name' => 'content',
				'type' => 'tinymce',
				'label' => esc_html__('Caption', 'tatsu'),
				'default' => '',
				'tooltip' => '',
			),
			function_exists('typehub_get_exposed_selectors') ? array(
				'att_name'	=> 'caption_font',
				'type'		=> 'select',
				'label'		=> esc_html__('Caption Font', 'tatsu'),
				'default'	=> 'body',
				'options'	=> typehub_get_exposed_selectors()
			) : false,
			array(
				'att_name' => 'margin',
				'type' => 'input_group',
				'label' => esc_html__('Margin', 'tatsu'),
				'default' => '0 0 30px 0',
				'tooltip' => '',
				'css'	  => true,
				'responsive'	=> true,
				'selectors'	=> array(
					'.tatsu-{UUID}.tatsu-module'	=> array(
						'property'		=> 'margin',
					)
				)
			),
			array(
				'att_name' => 'caption_color',
				'type' => 'color',
				'options'	=> array(
					'gradient'	=> true
				),
				'label' => esc_html__('Caption Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css'	 => true,
				'selectors'	=> array(
					'.tatsu-{UUID} .tatsu-icon_card-caption' => array(
						'property'		=> 'color',
					)
				)
			),
			array(
				'att_name'			=> 'outer_box_shadow',
				'label'				=> esc_html__('Box Shadow', 'tatsu'),
				'type'				=> 'input_box_shadow',
				'default'			=> '0px 0px 0px 0px rgba(0,0,0,0)',
				'css'				=> true,
				'selectors'			=> array(
					'.tatsu-{UUID}.tatsu-module' => array(
						'property'	=> 'box-shadow',
						'when'		=> array( 'outer_box_shadow', '!=', '0px 0px 0px 0px rgba(0,0,0,0)' ),
					)
				)
			),
		))),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'icon' => 'tatsu-icon-user', //need to replace this with a font loaded from tatsu
					'size' => 'medium',
					'url' => '#',
					'icon_color' 		=> array('id' => 'palette:0', 'color' => tatsu_get_color('tatsu_accent_color')),
					'svg_icon_color'	=> array('id' => 'palette:0', 'color' => tatsu_get_color('tatsu_accent_color')),
					'title' => 'John Doe',
					'title_font' => 'h6',
					'content' => 'Developer',
					'caption_font'	=> 'body',
					'horizontal_alignment'	=> 'left',
				)
			),
		),
	);
	tatsu_register_module('tatsu_icon_card', $controls);
	if (function_exists('tatsu_register_header_module')) {
		tatsu_register_header_module('tatsu_icon_card', $controls, 'tatsu_icon_card');
	}
}

?>