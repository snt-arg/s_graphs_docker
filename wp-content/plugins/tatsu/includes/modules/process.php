<?php
if( !function_exists( 'tatsu_process' ) ) {
    function tatsu_process( $atts, $content, $tag ) {
        $atts = shortcode_atts( array (
            'title_font'             => 'h5',
            'content_font'            => 'body',
            'icon_size'              => '32',
            'divider_color'          => '#D8D8D8',
            'title_color'            => '',
            'title_hover_color'      => '',
            'icon_hover_color'       => '',   
            'icon_color'             => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
            'content_color'          => '',
            'content_hover_color'    => '',
            'key'                    => be_uniqid_base36(true),
        ), $atts, $tag );
        extract( $atts );
        
        $custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_process', $atts['key'] );
        $custom_class_name = ' tatsu-'.$atts['key'];

		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );
		
        $classes = 'tatsu-process tatsu-module ' . $custom_class_name;
		$data_animations = be_get_animation_data_atts( $atts );
		if( !empty( $animation_type ) && 'none' !== $animation_type ) {
            $css_classes .= ' tatsu-animate ';
        }

        global $tatsu_process_title_font, $tatsu_process_content_font;
        if( !empty( $title_font ) ) {
            $tatsu_process_title_font = $title_font;
        }else {
            $tatsu_process_title_font = '';
        }

        if( !empty( $content_font ) ) {
            $tatsu_process_content_font = $content_font;
        }else {
            $tatsu_process_content_font = '';
        }
		$classes .= $visibility_classes . ' ' . $css_classes;
        ob_start();
        ?>
            <div <?php echo $css_id; ?> class = "<?php echo $classes; ?>" <?php echo $data_animations; ?> >
                <?php echo $custom_style_tag; ?>
                <?php echo do_shortcode( $content ); ?>
            </div>
        <?php
        return ob_get_clean();
    }
}

if( !function_exists( 'tatsu_process_col' ) ) {
    function tatsu_process_col( $atts, $content, $tag ) {
        $atts = shortcode_atts( array (
            'icon_type'              => 'icon',
            'icon'                   => 'tatsu-icon-user',
            'svg_icon'               => '',
            'line_animate'           => '',
			'title'                  => '',
			'css_classes'			 => '',
			'animate'				 => '1',
            'icon'                   => '',
            'key'                    => be_uniqid_base36(true),
        ), $atts, $tag );

        extract( $atts );

        $custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_process_col', $atts['key'] );
        $custom_class_name = ' tatsu-'.$atts['key'];

		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );

        $classes = array ( 'tatsu-process-col', $custom_class_name, $visibility_classes );

        $icon_type = !empty( $icon_type ) ? $icon_type : 'icon';

        global $tatsu_process_title_font, $tatsu_process_content_font;
        $title_font = !empty( $tatsu_process_title_font ) ? $tatsu_process_title_font : '';
        $content_font = !empty( $tatsu_process_content_font ) ? $tatsu_process_content_font : '';
		$icon_label = str_replace(array('tatsu','icon','-','_'),'',$icon);
        $svg_icon_html = '';
        if( 'svg' == $icon_type ) {
            $classes[] = 'tatsu-process-icon-type-svg';
            if( !empty( $line_animate ) ) {
                $classes[] = 'tatsu-line-animate';
            }
            if( !empty( $svg_icon ) ) {
                $svg_icon_html = function_exists( 'tatsu_get_svg_icon' ) ? tatsu_get_svg_icon( $svg_icon ) : '';
            }
		}
		
		$data_animations = be_get_animation_data_atts( $atts );
		if( !empty( $animate ) && !empty( $animation_type ) && 'none' !== $animation_type ) {
            $css_classes .= ' tatsu-animate ';
        }

		$classes[] = $css_classes;
        $classes = implode( ' ', $classes );
		ob_start();
        ?>
            <div <?php echo $css_id; ?> class = "<?php echo $classes; ?>" <?php echo $data_animations; ?> >
                <?php echo $custom_style_tag; ?>
                <div class = "tatsu-process-header">
                    <div class = "tatsu-process-icon">
                        <?php if( 'icon' == $icon_type ) : ?>
                            <i class = "tatsu-icon <?php echo $icon;?>" aria-label = "<?php echo $icon_label;?>" >
                            </i>
                        <?php else: ?>
                            <?php echo $svg_icon_html; ?>
                        <?php endif; ?>
                    </div>
                    <div class = "tatsu-process-title <?php echo $title_font; ?>">
                        <?php echo $title; ?>
                    </div>
                </div>
                <div class = "tatsu-process-content <?php echo $content_font; ?>">
                    <?php echo do_shortcode( $content ); ?>
                </div>
                <div class = "tatsu-process-sep">
                </div>
            </div>
        <?php
        return ob_get_clean();
    }
}


add_action('tatsu_register_modules', 'tatsu_register_process');
function tatsu_register_process()
{
	$controls = array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#process',
		'title' => esc_html__('Process', 'tatsu'),
		'is_js_dependant' => false,
		'child_module' => 'tatsu_process_col',
		'type' => 'multi',
		'initial_children' => 3,
		'is_built_in' => true,
		'group_atts'	=> array(
			array(
				'type'		=> 'tabs',
				'style'		=> 'style1',
				'group'		=> array(
					array(
						'type' => 'tab',
						'title' => esc_html__('Style', 'tatsu'),
						'group'	=> array(
							array(
								'type'		=> 'accordion',
								'active'	=> 'all',
								'group'		=> array(
									'icon_size',
									array(
										'type'		=> 'panel',
										'title'		=> esc_html__('Colors', 'tatsu'),
										'group'		=> array(
											
											array(
												'type'  	=> 'tabs',
												'style'		=> 'style1',
												'group'		=> array(
													array(
														'type'		=> 'tab',
														'title'		=> esc_html__('Normal', 'tatsu'),
														'group'		=> array(
															'icon_color',
															'title_color',
															'content_color',
															'divider_color',
														),
													),
													array(
														'type'		=> 'tab',
														'title'		=> esc_html__('Hover', 'tatsu'),
														'group'		=> array(
															'icon_hover_color',
															'title_hover_color',
														),
													),
												),
											),
											
										)
									),
									array(
										'type'		=> 'panel',
										'title'		=> esc_html__('Typography', 'tatsu'),
										'group'		=> array(
											'title_font',
											'content_font',
										)
									),
								)
							),
						)
					),
					array(
						'type' => 'tab',
						'title' => esc_html__('Advanced', 'tatsu'),
						'group'	=> array(
						)
					)

				)
			),
		),
		'atts' => array_values(array_filter(array(
			function_exists('typehub_get_exposed_selectors') ? array(
				'att_name'		=> 'title_font',
				'type'			=> 'select',
				'label'			=> esc_html__('Title Font', 'tatsu'),
				'default'		=> 'h5',
				'options'		=> typehub_get_exposed_selectors()
			) : false,
			function_exists('typehub_get_exposed_selectors') ? array(
				'att_name'		=> 'content_font',
				'type'			=> 'select',
				'label'			=> esc_html__('Content Font', 'tatsu'),
				'default'		=> 'body',
				'options'		=> typehub_get_exposed_selectors()
			) : false,
			array(
				'att_name'		=> 'divider_color',
				'label'			=> esc_html__('Divider Color', 'tatsu'),
				'default'		=> '#D8D8D8',
				'type'			=> 'color',
				'css'			=> true,
				'selectors'		=> array(
					'.tatsu-{UUID} .tatsu-process-sep'  => array(
						'property'		=> 'background'
					)
				)
			),
			array(
				'att_name'		=> 'icon_size',
				'type'			=> 'slider',
				'label'			=> esc_html__('Icon Size', 'tatsu'),
				'default'		=> '30',
				'options'		=> array(
					'min'		=> '10',
					'max'		=> '100',
					'step'		=> '1'
				),
				'css'			=> true,
				'responsive'	=> true,
				'selectors'		=> array(
					'.tatsu-{UUID} .tatsu-process-icon' => array(
						'property'	=> 'font-size',
						'append'	=> 'px',
					),
					'.tatsu-{UUID} .tatsu-process-icon svg' => array(
						'property'	=> array('width', 'height'),
						'append'	=> 'px',
					),
					'.tatsu-{UUID} .tatsu-process-sep' => array(
						'property'	=> 'top',
						'append'	=> 'px',
						'operation'	=> array('/', 2),
					)
				)
			),
			array(
				'att_name' => 'icon_color',
				'type' 	   => 'color',
				'label'    => esc_html__('Icon Color', 'tatsu'),
				'default'   => '',
				'tooltip'   => '',
				'css'		=> true,
				'selectors'	=> array(
					'.tatsu-{UUID} .tatsu-process-icon i, .tatsu-{UUID} .tatsu-process-icon svg'	=> array(
						'property'		=> 'color',
					)
				)
			),
			array(
				'att_name' => 'icon_hover_color',
				'type' 	   => 'color',
				'label'    => esc_html__('Icon Hover Color', 'tatsu'),
				'default'   => '',
				'tooltip'   => '',
				'css'		=> true,
				'selectors'	=> array(
					'.tatsu-{UUID} .tatsu-process-icon i:hover, .tatsu-{UUID} .tatsu-process-icon svg:hover'	=> array(
						'property'		=> 'color',
					)
				)
			),
			array(
				'att_name'		=> 'title_color',
				'type'			=> 'color',
				'label'			=> esc_html__('Title Color', 'tatsu'),
				'default'		=> '',
				'css'			=> true,
				'selectors'		=> array(
					'.tatsu-{UUID} .tatsu-process-title'	=> array(
						'property'		=> 'color'
					)
				)
			),
			array(
				'att_name'		=> 'title_hover_color',
				'type'			=> 'color',
				'label'			=> esc_html__('Title Hover Color', 'tatsu'),
				'default'		=> '',
				'css'			=> true,
				'selectors'		=> array(
					'.tatsu-{UUID} .tatsu-process-title:hover'	=> array(
						'property'		=> 'color'
					)
				)
			),
			array(
				'att_name'		=> 'content_color',
				'type'			=> 'color',
				'label'			=> esc_html__('Content Color', 'tatsu'),
				'default'		=> '',
				'css'			=> true,
				'selectors'		=> array(
					'.tatsu-{UUID} .tatsu-process-content'	=> array(
						'property'		=> 'color'
					)
				)
			),
			array(
				'att_name' => 'animate',
				'type' => 'switch',
				'label' => esc_html__('Enable CSS Animation', 'tatsu'),
				'default' => 0,
				'tooltip' => '',
			),
		))),
		'presets'		=> array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'icon_color'			=> array('id' => 'palette:0', 'color' => tatsu_get_color('tatsu_accent_color')),
					'icon_size'				=> '32',
				)
			)
		)
	);
	tatsu_remap_modules(array('tatsu_process', 'process_style1'), $controls, 'tatsu_process');
}

add_action('tatsu_register_modules', 'tatsu_register_process_col');
function tatsu_register_process_col()
{
	$controls = array(
		'icon' => '',
		'title' => esc_html__('Process Col', 'tatsu'),
		'is_js_dependant' => false,
		'child_module' => '',
		'type' => 'sub_module',
		'is_built_in' => true,
		'hint' => 'title',
		'group_atts'	=> array(
			array(
				'type'		=> 'tabs',
				'style'		=> 'style1',
				'group'		=> array(
					array(
						'type' => 'tab',
						'title' => esc_html__('Style', 'tatsu'),
						'group'	=> array(
							'icon_type',
							'icon',
							'svg_icon',
							'line_animate',
							'title',
							'content',
						)
					),
					array(
						'type' => 'tab',
						'title' => esc_html__('Advanced', 'tatsu'),
						'group'	=> array(
						)
					)
				)
			)
		),
		'atts' => array(
			array(
				'att_name'	    => 'icon_type',
				'type'			=> 'button_group',
				'is_inline'     => true,
				'label'			=> esc_html__('Icon Type', 'tatsu'),
				'default'		=> 'icon',
				'options'		=> array(
					'svg'		=> 'Svg',
					'icon'		=> 'Icon'
				)
			),
			array(
				'att_name'		=> 'icon',
				'type'			=> 'icon_picker',
				'label'			=> esc_html__('Icon', 'tatsu'),
				'default'		=> '',
				'tooltip'		=> '',
				'visible'		=> array('icon_type', '=', 'icon')
			),
			array(
				'att_name'		=> 'svg_icon',
				'type'			=> 'svg_icon_picker',
				'label'			=> esc_html__('Svg Icon', 'tatsu'),
				'default'		=> 'linea:basic_paperplane',
				'visible'		=> array('icon_type', '=', 'svg'),
				'tooltip'		=> ''
			),
			array(
				'att_name'		=> 'line_animate',
				'type'			=> 'switch',
				'label'			=> esc_html__('Enable Line Animate', 'tatsu'),
				'default'		=> '',
				'visible'		=> array('icon_type', '=', 'svg'),
				'tooltip'		=> ''
			),
			array(
				'att_name'		=> 'title',
				'type'			=> 'text',
				'label'			=> esc_html__('Title', 'tatsu'),
				'default'		=> ''
			),

			array(
				'att_name'		=> 'content',
				'type'			=> 'tinymce',
				'label'			=> esc_html__('Content', 'tatsu'),
				'default'		=> ''
			),
		),
		'presets'		=> array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'icon' => 'tatsu-icon-user',
					'title' => 'Title Goes Here',
					'content' => '<p >Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.</p>',
				),
			)
		)
	);
	tatsu_remap_modules(array('tatsu_process_col', 'process_col'), $controls, 'tatsu_process_col');
}