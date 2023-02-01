<?php
/**************************************
			SPECIAL TITLE 1
**************************************/
if (!function_exists('be_special_heading')) {
	function be_special_heading( $atts, $content, $tag ) {
		global $be_themes_data;
		$atts = shortcode_atts( array (
			'title_align' => 'center',
			'title_content' => '',
			'h_tag' => 'h3',
			'title_color' => '',
			'subtitle_spl_font' => '',
			'disable_separator' => 0,
			'separator_style' => '1',
			'icon_name' => '',
			'default_icon' => 0,
			'icon_color' => '' ,
			'separator_thickness' => '2' ,
			'separator_width' => '40' ,
			'separator_pos' => '0' ,
	        'separator_color' => '#323232',
			'scroll_to_animate'=> 0,
			'animate'=> 0,
	        'animation_type'=> 'fadeIn',
			'key' => be_uniqid_base36(true),
		),$atts, $tag );
		
		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key );
		$unique_class_name = 'tatsu-'.$key;
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );
		$animate = ( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) ? ' tatsu-animate' : '';  		
		$data_animations = be_get_animation_data_atts( $atts );
	    $output ='';
	    $subtitle_spl_font = ( isset( $subtitle_spl_font ) && 1 == $subtitle_spl_font ) ? ' special-subtitle' : '';
	    $title_align = ( isset( $title_align ) && !empty($title_align) ) ? $title_align : 'center';
		$seperator_color = '';
		if( !( $disable_separator ) ){
			if( !empty( $separator_style ) ){
				$sep_output = '<div class="sep-with-icon-wrap margin-bottom"><span class="sep-with-icon" ></span><i class="sep-icon font-icon '.$icon_name.'"></i><span class="sep-with-icon" ></span></div>';
			} else {
				$sep_output = '<hr class="separator margin-bottom" />';
			}
		}
		else{
			$sep_output = '';
		}
		
		$output .='<div '.$css_id.' class="special-heading-wrap style1 oshine-module '.$animate.' '.$unique_class_name.' '.$visibility_classes.' '.$css_classes.'" '.$data_animations.'><div class="special-heading align-'.$title_align.'">';
		$output .= ($title_content) ? '<'.$h_tag.' class="special-h-tag" >'.$title_content.'</'.$h_tag.'>' : '' ;
		if (isset($separator_pos) && 1 == $separator_pos) { //Place Divider Above Header
			$output .= $sep_output;
			$output .= ($content) ? '<div class="sub-title margin-bottom '.$subtitle_spl_font.'">'.$content.'</div>' : '' ;
		}
		else {
			$output .= ($content) ? '<div class="sub-title margin-bottom '.$subtitle_spl_font.'">'.$content.'</div>' : '' ;
			$output .= $sep_output;
		}
		$output .='</div>'.$custom_style_tag.'</div>';
		return $output;
	}
	add_shortcode( 'special_heading', 'be_special_heading' );
}

add_filter( 'special_heading_before_css_generation', 'special_heading_css' );
function special_heading_css( $atts ) {
	$atts['separator_width'] = $atts['separator_style'] == '1' ? $atts['separator_width'] / 2 : $atts['separator_width'] ;
	return $atts;
}


add_action( 'tatsu_register_modules', 'oshine_register_special_heading' );
function oshine_register_special_heading() {
	$controls = array (
        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#special_heading',
        'title' => __( 'Special Title - Style 1',  'oshine_modules'  ),
        'is_js_dependant' => false,
        'type' => 'single',
		'is_built_in' => true,
		'hint' => 'title_content',
		'group_atts' => array (
			array ( 
				'type'	=> 'tabs',
				'style'	=> 'style1',
				'group'	=> array (
					array (
						'type' => 'tab',
						'title' => __( 'Content', 'tatsu' ),
						'group'	=> array (
							array (
								'type' => 'accordion' ,
								'active' => 'all',
								'group' => array (
									array (
										'type' => 'panel',
										'title' => __( 'Title and description', 'tatsu' ),
										'group'	=> array(
											'title_content',
											'content',
										),
									),
								)
							),
						)
					),
					array ( 
						'type' => 'tab',
						'title' => __( 'Style', 'tatsu' ),
						'group'	=> array (
							array (
								'type' => 'accordion' ,
								'active' => 'all',
								'group' => array (
									array (
										'type' => 'panel',
										'title' => __( 'Shape and style', 'tatsu' ),
										'group'	=> array(
											'h_tag',
											'title_align',
											'subtitle_spl_font',
										),
									),
									array (
										'type' => 'panel',
										'title' => __( 'Divider styling', 'tatsu' ),
										'group'	=> array(
											'disable_separator',
											'separator_width',
											'separator_thickness',
											'separator_style',
											'icon_name',
											'separator_pos'
										),
									),
									array (
										'type' => 'panel',
										'title' => __( 'Colors', 'tatsu' ),
										'group'	=> array(
											'title_color',
											'icon_color',
										),
									),
								)
							),
						)
					),
					array (
						'type' => 'tab',
						'title' => __( 'Advanced', 'tatsu' ),
						'group'	=> array (
							array (
								'type' => 'accordion' ,
								'active' => 'none',
								'group' => array (
								)
							)
						)
					)
				)
			)
		),
        'atts' => array (
        	array (
        		'att_name' => 'title_content',
        		'type' => 'text_area',
        		'label' => __( 'Title', 'oshine_modules' ),
        		'default' => '',
        		'tooltip' => '',
        		
        	),
        	array (
	            'att_name' => 'title_color',
	            'type' => 'color',
	            'label' => __( 'Title Color', 'oshine_modules' ),
	            'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .special-h-tag' => array(
						'property' => 'color',
					),
				),
        		
            ), 
        	array (
        		'att_name' => 'h_tag',
				'type' => 'select',
				'is_inline' => true,
        		'label' => __( 'Title Tag',  'oshine_modules'  ),
        		'options' => array (
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6'
				),
        		'default' => 'h5',
				'tooltip' => '',
				
        	),
            array (
        		'att_name' => 'content',
        		'type' => 'tinymce',
        		'label' => __( 'Description', 'oshine_modules' ),
        		'default' => '',
        		'tooltip' => '',
        		
	        	),	
	        array (
              	'att_name' => 'subtitle_spl_font',
              	'type' => 'switch',
              	'label' => __( 'Apply Special-Subtitle font to Description', 'oshine_modules' ),
              	'default' => 0, 
              	'tooltip' => '',
            ),
            array (
              	'att_name' => 'disable_separator',
              	'type' => 'switch',
				'label' => __( 'Disable Divider', 'oshine_modules' ),
				'default' => '0',
              	'tooltip' => '',
            ),
            array (
        		'att_name' => 'separator_style',
        		'type' => 'switch',
        		'label' => __( 'Enable icon in divider ?', 'oshine_modules' ),
        		'default' => '1',
				'tooltip' => '',
				'hidden' => array('disable_separator', '=', '1'),  
        	),
        	array (
        		'att_name' => 'icon_name',
        		'type' => 'icon_picker',
        		'label' => __( 'Icon', 'oshine_modules' ),
        		'default' => '',
				  'tooltip' => '',
				  'hidden' => array('disable_separator', '=', '1'),
        	),
            array (
	            'att_name' => 'icon_color',
	            'type' => 'color',
	            'label' => __( 'Icon Color', 'oshine_modules' ),
	            'default' => '', 
				'tooltip' => '',
				'hidden' => array('disable_separator', '=', '1'),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .sep-icon.oshine_diamond' => array(
						'property' => 'background',
						'when' => array(
							array('icon_name', '=', 'oshine_diamond'),
							array('disable_separator', 'empty'),
							array('separator_style', '=', '1'),
						),
						'relation' => 'or',
					),
					'.tatsu-{UUID} .sep-icon' => array(
						'property' => 'color',
						'when' => array(
							array('icon_name', '!=', 'oshine_diamond'),
							array('disable_separator', '!=', '1'),
							array('separator_style', '=', '1'),
						),
						'relation' => 'and',
					),
				),

            ),
            array (
	            'att_name' => 'separator_color',
	            'type' => 'color',
	            'label' => __( 'Divider Color', 'oshine_modules' ),
	            'default' => '', 
				'tooltip' => '',
				'hidden' => array('disable_separator', '=', '1'),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .sep-with-icon' => array(
						'property' => 'background',
						'when' => array(
							array('disable_separator', '!=', '1'),
							array('separator_style', '=', '1'),
						),
						'relation' => 'and',
					),
					'.tatsu-{UUID} .separator' => array(
						'property' => 'background',
						'when' => array(
							array('disable_separator', '!=', '1'),
							array('separator_style', '!=', '1'),
						),
						'relation' => 'and',
					),
				),
        		
            ),
            array (
        		'att_name' => 'separator_thickness',
        		'type' => 'slider',
        		'label' => __( 'Separator Thickness', 'oshine_modules' ),
        		'options' => array(
        			'min' => '1',
        			'max' => '20',
        			'step' => '1',
        			'unit' => 'px',
        		),
        		'default' => '2',
				'tooltip' => '',
				'hidden' => array('disable_separator', '=', '1'),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .sep-with-icon' => array(
						'property' => 'height',
						'when' => array(
							array('disable_separator', '!=', '1'),
							array('separator_style', '=', '1'),
						),
						'relation' => 'and',
						'append' => 'px',
					),
					'.tatsu-{UUID} .separator' => array(
						'property' => 'height',
						'when' => array(
							array('disable_separator', '!=', '1'),
							array('separator_style', '!=', '1'),
						),
						'relation' => 'and',
						'append' => 'px',
					),
				),
        		
        	),
        	array (
        		'att_name' => 'separator_width',
				'type' => 'number',
				'is_inline' => true,
        		'label' => __( 'Separator Width', 'oshine_modules' ),
        		'options' => array(
        			'unit' => 'px',
        		),
        		'default' => '40',
				'tooltip' => '',
				'hidden' => array('disable_separator', '=', '1'),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .sep-with-icon' => array(
						'property' => 'width',
						'when' => array(
							array('disable_separator', '!=', '1'),
							array('separator_style', '=', '1'),
						),
						'relation' => 'and',
						'append' => 'px',
						//'operation' => array('/', 2),
					),
					'.tatsu-{UUID} .separator' => array(
						'property' => 'width',
						'when' => array(
							array('disable_separator', '!=', '1'),
							array('separator_style', '!=', '1'),
						),
						'relation' => 'and',
						'append' => 'px',
					),
				),
        		
        	),
        	array (
              	'att_name' => 'separator_pos',
              	'type' => 'switch',
              	'label' => __( 'Place Divider above Description', 'oshine_modules' ),
              	'default' => 0,
				  'tooltip' => '',
				  'hidden' => array('disable_separator', '=', '1'),
        		
            ),
            array (
        		'att_name' => 'title_align',
				'type' => 'button_group',
				'is_inline' => true,
        		'label' => __( 'Alignment', 'oshine_modules' ),
        		'options' => array(
        			'left' => 'Left',
        			'center' => 'Center',
        			'right' => 'Right'
        		),
        		'default' => 'center',
        		'tooltip' => '',
        		
        	),            
        ),
        'presets' => array(
        	'default' => array(
        		'title' => '',
        		'image' => '',
        		'preset' => array(
        			'title_content' => 'TATSU IS AWESOME',
        			'h_tag' => 'h3',
        			'content' => 'A Powerful and Elegant Front End Page Builder for Wordpress',
        			'subtitle_spl_font' => '1',
        			'icon_name' => 'oshine_diamond',
        			'icon_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
        			'separator_thickness' => '1',
        			'separator_color' => '#efefef'
        		),
        	)
        ),
    );
	tatsu_register_module( 'special_heading', $controls );
}