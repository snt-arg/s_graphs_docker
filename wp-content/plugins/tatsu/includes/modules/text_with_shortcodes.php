<?php
if ( !function_exists( 'tatsu_text_with_shortcodes' ) ) {
	function tatsu_text_with_shortcodes( $atts, $content, $tag ) {
		extract( shortcode_atts( array(
			'builder_mode' => '',
	    	'animate' => 0,
			'animation_type' => 'fadeIn',
			'hide_in' => '',
			'key' => be_uniqid_base36(true),
	    ),$atts, $tag ) );
		$output = '';
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts ); 		
		$animate = ( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) ? ' tatsu-animate' : '';
		$data_animations = be_get_animation_data_atts( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key, $builder_mode );
		$unique_class_name = 'tatsu-'.$key;

		$output .= '<div '. $css_id.' class="tatsu-shortcode-module tatsu-module '.$unique_class_name.' '.$css_classes.' '.$visibility_classes.' '.$animate.'"  '.$data_animations.'>';
		$output .= do_shortcode( shortcode_unautop( $content ) );
		$output .= $custom_style_tag;
		$output .= '</div>';
		return $output;
	}
	add_shortcode( 'tatsu_text_with_shortcodes', 'tatsu_text_with_shortcodes' );
}

if( !function_exists( 'tatsu_text_with_shortcodes_header_atts' ) ) {
	function tatsu_text_with_shortcodes_header_atts( $atts, $tag ) {
		if( 'tatsu_text_with_shortcodes' === $tag ) {
			// New Atts
			$atts['builder_mode'] = array (
				'type' => '',
				'default' => 'Header',
			);
			$atts['margin'] = 	array (
				'type' => 'input_group',
				'label' => esc_html__( 'Margin', 'tatsu' ),
				'default' => '0px 30px 0px 0px',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-shortcode-module' => array(
						'property' => 'margin',
					),
				),
			);
			// Modify Atts
			// Remove Atts
		}
		return $atts;
	}
	add_filter( 'tatsu_header_modify_atts', 'tatsu_text_with_shortcodes_header_atts', 10, 2 );
}

add_action('tatsu_register_header_modules', 'tatsu_register_text_with_shortcodes', 9);
add_action('tatsu_register_modules', 'tatsu_register_text_with_shortcodes', 9);
function tatsu_register_text_with_shortcodes()
{
	$controls = array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#text',
		'title' => esc_html__('Shortcode Editor', 'tatsu'),
		'is_js_dependant' => false,
		'child_module' => '',
		'type' => 'single',
		'is_built_in' => false,
		'is_dynamic' => true,
		//Tab1
		'group_atts'			=> array(
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
											'title' => esc_html__('Spacing', 'tatsu'),
											'group' => array(
												'margin',
											)
										),
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
				'type' => 'tinymce',
				'label' => esc_html__('Shortcode', 'tatsu'),
				'default' => '',
				'tooltip' => ''
			),
		),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'content' => 'Add your Shortcode here',
				),
			)
		),
	);
	tatsu_register_module('tatsu_text_with_shortcodes', $controls);
	tatsu_register_header_module('tatsu_text_with_shortcodes', $controls, 'tatsu_text_with_shortcodes');
}


?>