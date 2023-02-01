<?php
if ( ! function_exists( 'tatsu_dropcap' ) ) {
	function tatsu_dropcap( $atts, $content, $tag  ) {
		$atts = shortcode_atts( array(
	        'type'=>'circle',
	        'bg_color' => '',
	        'color'=>'',
	        'size' =>'small',
	        'letter'=>'',
	        'icon'=>'none',
			'animate'=>'0',
	        'animation_type'=>'fadeIn',
			'margin' => '',
			'key' => be_uniqid_base36(true),
		), $atts, $tag );
		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key );
		$unique_class_name = 'tatsu-'.$key;
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );
		$animate = ( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) ? ' tatsu-animate' : '' ; 
		$data_animations = be_get_animation_data_atts( $atts );

		$output = "";
		$output .= '<div '.$css_id.' class="tatsu-module tatsu-clearfix tatsu-dropcap-wrap '.$unique_class_name.' '.$css_classes.' '. $visibility_classes.' '.$animate.'" '.$data_animations.'>';
		$letter = ( $icon != '' ) ? '<i class="tatsu-icon '.$icon.'"></i>' : '<span>'.$letter.'</span>';
		
	 	if( 'rounded' == $type || 'circle' == $type ) {
	 		$output .= '<span class="tatsu-dropcap tatsu-dropcap-'.$type.' '.$size.'">'.$letter.'</span>'.do_shortcode( $content );
	 	}
	 	if( 'letter' == $type) {
	 		$output .= '<span class="tatsu-dropcap tatsu-dropcap-'.$type.' '.$size.'">'.$letter.'</span>'.do_shortcode( $content );
		}
		$output .= $custom_style_tag;
		$output .= '</div>';
		return $output;
	}
	add_shortcode( 'tatsu_dropcap', 'tatsu_dropcap' );
	add_shortcode( 'dropcap', 'tatsu_dropcap' );
}

add_action('tatsu_register_modules', 'tatsu_register_dropcap');
function tatsu_register_dropcap()
{
	$controls = array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#dropcap',
		'title' => esc_html__('Dropcap', 'tatsu'),
		'is_js_dependant' => false,
		'type' => 'single',
		'is_built_in' => true,
		'hint' => 'content',
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
							'letter',
							'icon',
							'content',
						),
					),

					//Tab2
					array(
						'type' => 'tab',
						'title' => esc_html__('Style', 'tatsu'),
						'group'	=> array(
							'type',
							'size',
							'color',
							'bg_color',
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
				'label' => esc_html__('Letter to be Dropcapped', 'tatsu'),
				'is_inline' => false,
				'default' => '',
				'tooltip' => '',
			),
			array(
				'att_name' => 'icon',
				'type' => 'icon_picker',
				'label' => esc_html__('Icon to be Dropcapped', 'tatsu'),
				'default' => '',
				'tooltip' => '',
			),
			array(
				'att_name' => 'type',
				'type' => 'button_group',
				'is_inline' => true,
				'label' => esc_html__('Style', 'tatsu'),
				'options' => array(
					'letter' => 'Plain',
					'circle' => 'Circle',
					'rounded' => 'Square',
				),
				'default' => 'circle',
				'tooltip' => ''
			),
			array(
				'att_name' => 'size',
				'type' => 'button_group',
				'is_inline' => true,
				'label' => esc_html__('Size', ''),
				'options' => array(
					'small' => 'Small',
					'big' => 'Big',
				),
				'default' => 'small',
				'tooltip' => ''
			),
			array(
				'att_name' => 'color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => 'Color',
				'default' => '',	//color_scheme
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-icon' => array(
						'property' => 'color',
						'when' => array('icon', 'notempty'),
					),
					'.tatsu-{UUID} .tatsu-dropcap span' => array(
						'property' => 'color',
						'when' => array('icon', 'empty'),
					),
				),
			),
			array(
				'att_name' => 'bg_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => 'Background Color',
				'default' => '',	//color_scheme
				'tooltip' => '',
				'hidden' => array('type', '=', 'letter'),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-dropcap' => array(
						'property' => 'background-color',
						'when' => array('type', '!=', 'letter'),
					),
				),
			),
			array(
				'att_name' => 'content',
				'type' => 'tinymce',
				'label' => 'Dropcap Content',
				'default' => '',
				'tooltip' => 'Add/Edit content'
			),
		),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s',
					'letter' => 'T',
					'color' => array('id' => 'palette:0', 'color' => tatsu_get_color('tatsu_accent_color')),
					'type' => 'letter',
				)
			),
		),
	);
	tatsu_register_module('tatsu_dropcap', $controls);
}

?>