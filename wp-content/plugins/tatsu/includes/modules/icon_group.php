<?php
if ( !function_exists( 'tatsu_icon_group' ) ) {	
	function tatsu_icon_group( $atts, $content, $tag ){
		$atts = shortcode_atts( array (
			'alignment' => 'center',
			'margin' => '',
			'builder_mode' => '',
			'hide_in' => '',
			'css_classes' => '',
			'key' => be_uniqid_base36(true),
		),$atts, $tag );

		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_icon_group', $key, $builder_mode );
		$custom_class_name = 'tatsu-'.$key;

		$css_id = be_get_id_from_atts( $atts );

		$visibility_classes = '';
		//Handle Resposive Visibility controls
		if( !empty( $hide_in ) ) {
			$hide_in = explode(',', $hide_in);
			foreach ( $hide_in as $device ) {
				$visibility_classes .= ' tatsu-hide-'.$device;
			}
		} else {
			$visibility_classes = be_get_visibility_classes_from_atts( $atts ); 
		}

		$data_animations = be_get_animation_data_atts( $atts );
		if( !empty( $animation_type ) && 'none' !== $animation_type ) {
            $css_classes .= ' tatsu-animate ';
        }

		$output = '<div '.$css_id.' class="tatsu-module tatsu-icon-group '.$custom_class_name.' '.$visibility_classes.' '.$css_classes.'" '.$data_animations.' >' . $custom_style_tag .do_shortcode( $content ).'</div>';		
		return $output;	
	}	
	add_shortcode( 'tatsu_icon_group', 'tatsu_icon_group' );
	add_shortcode( 'icon_group', 'tatsu_icon_group' );
}

if( !function_exists( 'tatsu_icon_group_header_atts' ) ) {
	function tatsu_icon_group_header_atts( $atts, $tag ) {
		if( 'tatsu_icon_group' === $tag ) {
			// New Atts
			$atts['hide_in'] = array (
				'type' => 'screen_visibility',
				'label' => esc_html__( 'Hide in', 'tatsu' ),
				'default' => '',
				'tooltip' => '',
			);
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
					'.tatsu-{UUID}.tatsu-icon-group' => array(
						'property' => 'margin',
					),
				),
			);
			// Remove Atts
		}
		return $atts;
	}
	add_filter( 'tatsu_header_modify_atts', 'tatsu_icon_group_header_atts', 10, 2 );
}

add_action('tatsu_register_header_modules', 'tatsu_register_icon_group', 9);
add_action('tatsu_register_modules', 'tatsu_register_icon_group', 5);

function tatsu_register_icon_group()
{
	$controls = array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#icon_group',
		'title' => esc_html__('Icon Group', 'tatsu'),
		'is_js_dependant' => false,
		'child_module' => 'tatsu_icon',
		'type' => 'multi',
		'allowed_sub_modules' => array('tatsu_icon'),
		'is_built_in' => false,
		'is_dynamic' => true,
		'group_atts' => array(
			array(
				'type'		=> 'tabs',
				'style'		=> 'style1',
				'group'		=> array(
					array(
						'type' => 'tab',
						'title' => esc_html__('Style', 'tatsu'),
						'group'	=> array(
							'alignment'
						)
					),
					array(
						'type'	=> 'tab',
						'title'	=> esc_html__('Advanced', 'tatsu'),
						'group'	=> array(
							array(
								'type' => 'accordion',
								'active'=> 'none',
								'group' => array(
									array(
										'type' => 'panel',
										'title'=> esc_html__('Spacing', 'tatsu'),
										'group'=> array(
											'margin'
										)
									)
								)
							)
						)
					)
				)
			)
		),
		'atts' => array(
			array(
				'att_name' => 'alignment',
				'type' => 'button_group',
				'is_inline' => true,
				'label' => esc_html__('Align', 'tatsu'),
				'options' => array(
					'left' => 'Left',
					'center' => 'Center',
					'right' => 'Right'
				),
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-icon-group' => array(
						'property' => 'text-align',
					),
				),
				'default' => 'left',
				'tooltip' => ''
			),
			array(
				'att_name' => 'margin',
				'type' => 'input_group',
				'label' => esc_html__('Margin', 'tatsu'),
				'default' => '0px 0px 20px 0px',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-icon-group' => array(
						'property' => 'margin',
					),
				),
			),
		),
	);
	tatsu_remap_modules(array('tatsu_icon_group', 'icon_group'), $controls, 'tatsu_icon_group');
	tatsu_register_header_module('tatsu_icon_group', $controls, 'tatsu_icon_group');
}

?>