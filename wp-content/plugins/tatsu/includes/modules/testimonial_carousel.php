<?php
if (!function_exists('tatsu_testimonials_carousel')) {	
	function tatsu_testimonials_carousel( $atts, $content, $tag ){
		$atts = shortcode_atts( array (
			'style'				=> 'style1',
			'font_size'			=> '20',
			'content_width'		=> '70',
			'alignment'	 		=> 'center',
			'author_font'		=> function_exists( 'typehub_get_exposed_selectors' ) ? 'h6' : false,
			'author_role_font'	=> function_exists( 'typehub_get_exposed_selectors' ) ? 'h9' : false,
			'author_color'		=> '',
			'author_role_color'	=> '',
			'dots_color'		=> array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
			'author_image_shadow' => '',	
			'pagination'		=> '1',
			'slide_show' 		=> '0',
			'slide_show_speed' 	=> '2000',
			'animate'			=> '1',
			'arrows'			=> '',
			'key' => be_uniqid_base36(true),
		), $atts, $tag );
		extract( $atts );

		global $tatsu_testimonial_author_font, $tatsu_testimonial_author_role_font, $tatsu_testimonial_style;

		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_testimonials_carousel', $atts['key'] );
		$unique_class_name = 'tatsu-'.$atts['key'];
		$classes = array( 'tatsu-testimonials', 'be-slider' );

		$data_animations = be_get_animation_data_atts( $atts );
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts ); 

		if( !empty( $style ) ) {
			$classes[] = 'tatsu-testimonial-' . $style;
		}
		if( !empty( $alignment ) ) {
			$classes[] = 'tatsu-testimonial-align-' . $alignment; 
		}else {
			$classes[] = 'tatsu-testimonial-align-center';
		}

		$tatsu_testimonial_style = $style;
		$tatsu_testimonial_author_font = !empty( $author_font ) ? $author_font : '';
		$tatsu_testimonial_author_role_font = !empty( $author_role_font ) ? $author_role_font : '';

		$adaptive_height = 'data-adaptive-height = "1"';
		$infinite = 'data-infinite = "1"';
		$pagination = !empty( $pagination ) ? 'data-dots = "1"' : '';
		$slide_show = !empty( $slide_show ) && !empty( $slide_show_speed ) ? 'data-auto-play = "'. $slide_show_speed .'"' : '';
		$arrows = !empty( $arrows ) ? 'data-arrows = "1" data-outer-arrows = "1"' : '';
		$animate_class = !empty( $animation_type ) && 'none' != $animation_type ? ' tatsu-animate' : '';
		
		$classes = implode( ' ', $classes );

		ob_start();
		?>
			<div <?php echo $css_id; ?> class = "<?php echo 'tatsu-testimonials-wrap tatsu-module clearfix '.$visibility_classes. ' '. $css_classes .' ' . $unique_class_name . $animate_class;  ?>" <?php echo $data_animations; ?>> <!-- Clearfix to prevent collapsing margins -->
				<?php echo $custom_style_tag; ?>
				<div class = "<?php echo $classes; ?>" <?php echo $infinite . $adaptive_height . ' ' . $pagination . ' ' . $slide_show . ' ' . $arrows; ?> >
					<?php echo do_shortcode( $content ); ?>
				</div>
			</div>
		<?php
		return ob_get_clean();
	}	
}

if (!function_exists('tatsu_testimonial_carousel')) {	
	function tatsu_testimonial_carousel( $atts, $content, $tag ) {
		$atts = shortcode_atts( array (
			'author' 				=> '',
			'author_image'			=> '', 
			'author_role'			=> '',
			'css_classes'			=> '',
			'key' => be_uniqid_base36(true),
		),$atts, $tag );

		extract( $atts );

		global $tatsu_testimonial_author_font, $tatsu_testimonial_author_role_font, $tatsu_testimonial_style;

		$custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key );
		$unique_class_name = 'tatsu-'.$key;


		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts ); 

		$classes = "tatsu-testimonial be-slide " . $unique_class_name . ' ' . $css_classes .' '. $visibility_classes ;

		ob_start();
		?>
			<div <?php $css_id ?> class = "<?php echo $classes; ?>">
				<?php echo $custom_style_tag; ?>
				<?php if( 'style2' === $tatsu_testimonial_style ) : ?>
					<div class = "tatsu-testimonial-content">
						<?php echo do_shortcode( $content ); ?>
					</div>
					<div class = "tatsu-testimonial-author-details-wrap">
						<?php if( !empty( $author_image ) ) : ?>
							<div class = "tatsu-testimonial-author-image">
								<img src = <?php echo $author_image; ?> />
							</div>
						<?php endif; ?>
						<div class = "tatsu-testimonial-author-wrap">
							<?php if( !empty( $author ) ) : ?>
								<h6 class = "tatsu-testimonial-author <?php echo !empty( $tatsu_testimonial_author_font ) ? $tatsu_testimonial_author_font : ''; ?>">
									<?php echo $author; ?>
								</h6>
							<?php endif; ?>
							<?php if( !empty( $author_role ) ) : ?>
								<div class = "tatsu-testimonial-author-role <?php echo !empty( $tatsu_testimonial_author_role_font ) ? $tatsu_testimonial_author_role_font : ''; ?>">
									<?php echo $author_role; ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				<?php else: ?>
					<div class = "tatsu-testimonial-content-image-wrap">
						<?php if( !empty( $author_image ) ) : ?>
							<div class = "tatsu-testimonial-author-image">
								<img src = <?php echo $author_image; ?> />
							</div>
						<?php endif; ?>
						<div class = "tatsu-testimonial-content">
							<?php echo do_shortcode( $content ); ?>
						</div>
					</div>
					<div class = "tatsu-testimonial-author-details-wrap">
						<?php if( !empty( $author ) ) : ?>
							<div class = "tatsu-testimonial-author <?php echo !empty( $tatsu_testimonial_author_font ) ? $tatsu_testimonial_author_font : ''; ?>">
								<?php echo $author; ?>
							</div>
						<?php endif; ?>
						<?php if( !empty( $author_role ) ) : ?>
							<div class = "tatsu-testimonial-author-role <?php echo !empty( $tatsu_testimonial_author_role_font ) ? $tatsu_testimonial_author_role_font : ''; ?>">
								<?php echo $author_role; ?>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		<?php
			return ob_get_clean();
	}	
}

add_action('tatsu_register_modules', 'tatsu_register_testimonials_carousel', 8);
function tatsu_register_testimonials_carousel()
{
	$controls = array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#testimonial',
		'title' => esc_html__('Testimonials Slider', 'tatsu'),
		'is_js_dependant' => false, //custom js implementation
		'child_module' => 'tatsu_testimonial_carousel',
		'type' => 'multi',
		'initial_children' => 2,
		'is_built_in' => true,
		'group_atts' => array(
			array(
				'type'		=> 'tabs',
				'style'		=> 'style1',
				'group'		=> array(
					array(
						'type' => 'tab',
						'title' => esc_html__('Style', 'tatsu'),
						'group'	=> array(
							array(
								'type' => 'accordion',
								'active' => array(0),
								'group' => array(
									array(
										'type'		=> 'panel',
										'title'		=> esc_html__('Style and Alignment', 'tatsu'),
										'group'		=> array(
											'style',
											'content_width',
											'alignment',
										)
									),
									array(
										'type'		=> 'panel',
										'title'		=> esc_html__('Typography', 'tatsu'),
										'group'		=> array(
											'font_size',
											'author_font',
											'author_role_font',
										)
									),
									array(
										'type'		=> 'panel',
										'title'		=> esc_html__('Colors', 'tatsu'),
										'group'		=> array(
											'author_color',
											'author_role_color',
											'dots_color',
										)
									),
									array(
										'type'		=> 'panel',
										'title'		=> esc_html__('Others', 'tatsu'),
										'group'		=> array(
											'pagination',
											'arrows',
											'slide_show',
											'slide_show_speed',
											'author_image_shadow',
										)
									),
								)
							),
						),
					),
					array(
						'type' => 'tab',
						'title' => esc_html__('Advanced', 'tatsu'),
						'group'	=> array(
						)
					)
				),
			)
		),
		'atts' => array_values(array_filter(array(
			array(
				'att_name' => 'style',
				'type' => 'button_group',
				'is_inline' => true,
				'label' => esc_html__('Style', 'tatsu'),
				'options' => array(
					'style1' => 'Style 1',
					'style2' => 'Style 2',
					'style3' => 'Style 3'
				),
				'default' => 'style1',
				'tooltip' => ''
			),
			array(
				'att_name' => 'font_size',
				'type' => 'number',
				'is_inline' => true,
				'label' => esc_html__('Content Font Size', 'tatsu'),
				'options' => array(
					'unit' => 'px',
				),
				'default' => 20,
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-testimonial-content' => array(
						'property' => 'font-size',
						'append' => 'px',
					),
				),
			),
			array(
				'att_name' => 'content_width',
				'type' => 'slider',
				'label' => esc_html__('Content Width', 'tatsu'),
				'options' => array(
					'unit' => '%',
					'min'  => '0',
					'max'  => '100'
				),
				'default' => '70',
				'tooltip' => '',
				'responsive'	=> true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-testimonial-content' => array(
						'property' => 'max-width',
						'append' => '%',
					),
				),
			),
			array(
				'att_name' => 'author_color',
				'type' => 'color',
				'label' => esc_html__('Author Text Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-testimonial-author' => array(
						'property' => 'color',
					),
				),
			),
			array(
				'att_name' => 'author_role_color',
				'type' => 'color',
				'label' => esc_html__('Designation Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-testimonial-author-role' => array(
						'property' => 'color',
					),
				),
			),
			array(
				'att_name' => 'dots_color',
				'type' => 'color',
				'label' => esc_html__('Slider Dots Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'visible'	  => array('pagination', '=', '1'),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .flickity-page-dots .is-selected' => array(
						'property' => 'background',
						'when'	   => array('pagination', '=', '1'),
					),
				),
			),
			array(
				'att_name' => 'author_image_shadow',
				'type' => 'input_box_shadow',
				'label' => esc_html__('Author Image Box Shadow', 'tatsu'),
				'tooltip' => '',
				'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-testimonial-author-image img' => array(
						'property' => 'box-shadow',
						'when' => array('author_image_shadow', '!=', '0px 0px 0px 0px rgba(0,0,0,0)'),
					),
				),
			),
			array(
				'att_name' => 'alignment',
				'type' => 'button_group',
				'is_inline' => true,
				'label' => esc_html__('Alignment', 'tatsu'),
				'options' => array(
					'left' => 'Left',
					'center' => 'Center',
					'right' => 'Right'
				),
				'default' => 'center',
				'tooltip' => '',
			),
			function_exists('typehub_get_exposed_selectors') ? array(
				'att_name'	=> 'author_font',
				'type'		=> 'select',
				'label'		=> esc_html__('Author Font', 'tatsu'),
				'options'	=> typehub_get_exposed_selectors(),
				'default'	=> 'h6',
				'tooltip'	=> ''
			) : false,
			function_exists('typehub_get_exposed_selectors') ? array(
				'att_name'	=> 'author_role_font',
				'type'		=> 'select',
				'label'		=> esc_html__('Designation Font', 'tatsu'),
				'options'	=> typehub_get_exposed_selectors(),
				'default'	=> 'h9',
				'tooltip'	=> ''
			) : false,
			array(
				'att_name' => 'pagination',
				'type' => 'switch',
				'label' => esc_html__(' Enable Dots', 'tatsu'),
				'default' => 1,
				'tooltip' => '',
			),
			array(
				'att_name'		=> 'arrows',
				'type'			=> 'switch',
				'label'			=> esc_html__('Enable Arrows', 'tatsu'),
				'default'		=> '1',
				'tooltip'		=> '',
			),
			array(
				'att_name' => 'slide_show',
				'type' => 'switch',
				'label' => esc_html__('Enable Slide Show', 'tatsu'),
				'default' => 0,
				'tooltip' => ''
			),
			array(
				'att_name' => 'slide_show_speed',
				'type' => 'slider',
				'visible' => array('slide_show', '=', '1'),
				'label' => esc_html__('Slide Show Speed', 'tatsu'),
				'options' => array(
					'min' => '0',
					'max' => '5000',
					'step' => '1000',
					'unit' => 'ms',
				),
				'visible'	=> array(
					'slide_show', '=', '1'
				),
				'default' => '2000',
				'tooltip' => ''
			),
		))),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'content_width'		=> array('d' => '70', 'm'	=> '100'),
					'dots_color'		=> array('id' => 'palette:0', 'color' => tatsu_get_color('tatsu_accent_color')),
				),
			)
		),
	);
	tatsu_remap_modules(array('tatsu_testimonials_carousel', 'testimonials'), $controls, 'tatsu_testimonials_carousel');
}

add_action('tatsu_register_modules', 'tatsu_register_testimonial_carousel', 8);
function tatsu_register_testimonial_carousel()
{
	$controls = array(
		'icon' => '',
		'title' => esc_html__('Testimonial', 'tatsu'),
		'is_js_dependant' => false,
		'child_module' => '',
		'type' => 'sub_module',
		'is_built_in' => true,
		'hint' => 'author',
		'group_atts' => array(
			array(
				'type'		=> 'tabs',
				'style'		=> 'style1',
				'group'		=> array(
					array(
						'type' => 'tab',
						'title' => esc_html__('Content', 'tatsu'),
						'group'	=> array(
							'author',
							'author_role',
							'author_image',
							'content',
						)
					),
					array(
						'type' => 'tab',
						'title' => esc_html__('Advanced', 'tatsu'),
						'group'	=> array(
				
						)
					)
				),
			)
		),
		'atts' => array(
			array(
				'att_name' => 'content',
				'type' => 'tinymce',
				'label' => esc_html__('Content', 'tatsu'),
				'default' => '',
				'tooltip' => ''
			),
			array(
				'att_name' => 'author',
				'type' => 'text',
				'label' => esc_html__('Author', 'tatsu'),
				'default' => '',
				'tooltip' => ''
			),

			array(
				'att_name' => 'author_image',
				'type' => 'single_image_picker',
				'options' => array(
					'size' => 'thumbnail',
				),
				'label' => esc_html__('Author Image', 'tatsu'),
				'tooltip' => '',
			),
			array(
				'att_name' => 'author_role',
				'type' => 'text',
				'label' => esc_html__('Designation', 'tatsu'),
				'default' => '',
				'tooltip' => ''
			),
		),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
					'author_image' => 'http://via.placeholder.com/100x100',
					'author' => 'Swami',
					'author_role' => 'Designer',
				),
			)
		),
	);
	tatsu_remap_modules(array('tatsu_testimonial_carousel', 'testimonial'), $controls, 'tatsu_testimonial_carousel');
}

?>