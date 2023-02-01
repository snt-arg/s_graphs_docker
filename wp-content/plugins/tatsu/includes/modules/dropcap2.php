<?php
/**************************************
			DROP CAPS - STYLE 2
**************************************/
if ( ! function_exists( 'tatsu_dropcap2' ) ) {
	function tatsu_dropcap2( $atts, $content, $tag ) {
		$atts = shortcode_atts( array(
	        'letter'=>'',
	        'icon'=>'',
	        'size' =>'60',
	        'color'=>'',
	        'dropcap_title'=>'',
	        'title_color' => '',
	        'title_font' => '',
			'animate'=>0,
			'animation_type'=>'fadeIn',
			'animation_delay'        => '',   
			'animation_duration'	 => '',
			'margin' => '',
			'key' => be_uniqid_base36(true),
		), $atts , $tag );
		
		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key );
		$unique_class_name = 'tatsu-'.$key;
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts ); 
		$animate = ( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) ? ' tatsu-animate' : '' ; 
		$data_animations = be_get_animation_data_atts( $atts );

		$output="";
		if( !empty( $icon ) ) {
			$letter = '<span class="tatsu-dropcap" ><i class="tatsu-icon '.$icon.'" ></i></span>';
		}else{
			$letter = '<h6 class="tatsu-dropcap" >'.$letter.'</h6>';
		}

		$title_tag = 'div';
		if ('body' == $title_font){
			$title_font_style = 'body-font';
		} elseif ('special' == $title_font){
			$title_font_style = 'special-subtitle';
		} else {
			$title_font_style = '';
			$title_tag = $title_font;
		}

		$output .= ' <div '.$css_id.' class="tatsu-dropcap-wrap tatsu-module style2 '.$animate.' '.$unique_class_name.' '.$css_classes.' '. $visibility_classes .'"  '.$data_animations.'>';
		$output .= $letter;
		$output .= !empty($dropcap_title) ? '<'.$title_tag.' class= "tatsu-dropcap-title '.$title_font_style.'" ><span class="tatsu-dropcap-title-color">'.$dropcap_title.'</span></'.$title_tag.'>' : '' ;
		$output .= $custom_style_tag;
		$output .= '</div>';
		return $output;	
	}
	add_shortcode( 'tatsu_dropcap2', 'tatsu_dropcap2' );
}

add_action('tatsu_register_modules', 'tatsu_register_dropcap2');
function tatsu_register_dropcap2()
{
	$controls = array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#dropcap',
		'title' => esc_html__('Dropcap - 2', 'tatsu'),
		'is_js_dependant' => false,
		'child_module' => '',
		'type' => 'single',
		'is_built_in' => true,
		'hint' => 'dropcap_title',
		'group_atts' => array(

			array(
				'type'		=> 'tabs',
				'style'		=> 'style1',
				'group'		=> array(
					//Tab1
					array(
						'type' => 'tab',
						'title' => esc_html__('Content', 'tatsu'),
						'group'	=> array(
							'letter',
							'icon',
							'dropcap_title',
						),
					),
					//Tab2
					array(
						'type' => 'tab',
						'title' => esc_html__('Style', 'tatsu'),
						'group'	=> array(
							array( //Spacing and styling accordion
								'type' => 'accordion',
								'active' => 'all',
								'group' => array(
									array(
										'type' => 'panel',
										'title' => esc_html__(' Styling', 'tatsu'),
										'group' => array(
											'size',
											'title_font',
										)
									),
									array(
										'type' => 'panel',
										'title' => esc_html__(' Color', 'tatsu'),
										'group' => array(
											'color',
											'title_color',
										)
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

								),
							),
						),
					),
				),
			),
		),

		'atts' => array(
			array(
				'att_name' => 'letter',
				'type' => 'text',
				'label' => esc_html__('Letter', 'tatsu'),
				'is_inline' => false,
				'default' => '',
				'visible' => array( 'icon', '=', '' ),
				'tooltip' => '',
			),
			array(
				'att_name' => 'icon',
				'type' => 'icon_picker',
				'label' => 'Icon',
				'default' => '',
				'tooltip' => ''
			),
			array(
				'att_name' => 'size',
				'type' => 'slider',
				'label' => 'Dropcap Size',
				'options' => array(
					'unit' => 'px',
					'min' => '10',
					'max' => '200',
					'step' => '1'
				),
				'default' => '60',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-icon' => array(
						'property' => 'font-size',
						'when' => array('icon', 'notempty'),
						'append' => 'px',
					),
					'.tatsu-{UUID} .tatsu-dropcap' => array(
						'property' => 'font-size',
						'when' => array('icon', 'empty'),
						'append' => 'px',
					),
				),
			),
			array(
				'att_name' => 'color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => 'Dropcap Color',
				'default' => '',	//color_scheme
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-icon' => array(
						'property' => 'color',
						'when' => array('icon', 'notempty'),
					),
					'.tatsu-{UUID} .tatsu-dropcap' => array(
						'property' => 'color',
						'when' => array('icon', 'empty'),
					),
				),
			),
			array(
				'att_name' => 'dropcap_title',
				'type' => 'text',
				'label' => esc_html__('Dropcap Title', 'tatsu'),
				'default' => '',
				'tooltip' => ''
			),
			array(
				'att_name' => 'title_font',
				'type' => 'select',
				'label' => esc_html__('Title Font', 'tatsu'),
				'options' => array(
					'body' => 'Body',
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6'
				),
				'default' => 'h6',
				'tooltip' => ''
			),
			array(
				'att_name' => 'title_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__('Title Color', 'tatsu'),
				'default' => '', //color_scheme
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-dropcap-title-color' => array(
						'property' => 'color',
						'when' => array('dropcap_title', 'notempty'),
					),
				),
			),
		),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'letter' => 'T',
					'color' => 'rgba(0,0,0,0.1)',
					'dropcap_title' => 'TATSU IS AWESOME',
					'title_color' => '#000',
					'size' => '100',
				)
			),
		),
	);
	tatsu_register_module('tatsu_dropcap2', $controls);
}
?>