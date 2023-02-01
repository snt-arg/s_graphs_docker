<?php
/**************************************
	        CODE
**************************************/
if (!function_exists('tatsu_code')) {
    function tatsu_code( $atts, $content ,$tag) {
        extract( shortcode_atts( array (
			'id' => '',
			'class' => '',
			'animate' => 0,
			'animation_type' => 'fadeIn',
			'animation_delay' => 0,
			'key' => be_uniqid_base36( true ),
		), $atts, $tag ) );

		$visibility_classes = be_get_visibility_classes_from_atts( $atts ); 		
		$animate = ( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) ? ' tatsu-animate' : '';
		$unique_class_name = 'tatsu-'.$key;
		$custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key, '' );	
		$data_animations = be_get_animation_data_atts( $atts );
							
		$output = '';
		$output .= '<div id = "'. $id .'" class="tatsu-code tatsu-module '.$unique_class_name.' '. $visibility_classes . ' ' .  $class .' '. $animate.'" '.$data_animations.' >'; 
		$output .= shortcode_unautop( $content );
		$output .= $custom_style_tag;
		$output .= '</div>';
		return $output;
  }
	add_shortcode( 'tatsu_code', 'tatsu_code' );
}

add_action( 'tatsu_register_modules', 'tatsu_register_code', 9 );
add_action( 'tatsu_register_header_modules', 'tatsu_register_code' );

function tatsu_register_code()
{
	$controls = array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#code',
		'title' => esc_html__('Code', 'tatsu'),
		'is_js_dependant' => false,
		'child_module' => '',
		'type' => 'single',
		'is_built_in' => true,
		'hint' => 'content',
		'should_autop' => false,
		//Tab1
		'group_atts' => array(
			array(
				'type'		=> 'tabs',
				'style'		=> 'style1',
				'group'		=> array(
					array( //Tab1
						'type' => 'tab',
						'title' => esc_html__('Content', 'tatsu'),
						'group'	=> array(
							'content',
							
						),
					),
					array( //Tab2
						'type' => 'tab',
						'title' => esc_html__('Advanced', 'tatsu'),
						'group'	=> array(
							array(
								"type" => "accordion",
								"active" => "none",
							  	"group" => array(
									array( 
										'type' => 'panel',
										'title' => esc_html__('Identifiers', 'tatsu'),
										'group'	=> array(
											'id',
											'class',
										)
									)
								)
					    	)
				 	 	)  
				  	),
			   	)
	        )
		),
		'atts' => array(
			array(
				'att_name' => 'content',
				'type' => 'text_area',
				'label' => esc_html__('Code Content', 'tatsu'),
				'default' => '',
				'tooltip' => ''
			),
			array(
				'att_name' => 'id',
				'type' => 'text',
				'label' => esc_html__('CSS ID', 'tatsu'),
				'default' => '',
				'tooltip' => '',
			),
			array(
				'att_name' => 'class',
				'type' => 'text',
				'label' => esc_html__('CSS Classes', 'tatsu'),
				'default' => '',
				'tooltip' => '',
			),
		),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'content' => '<p>Insert your code here!</p>',
				),
			)
		),
	);
	tatsu_register_module('tatsu_code', $controls);
	tatsu_register_header_module( 'tatsu_code', $controls, 'tatsu_code' );
}

?>