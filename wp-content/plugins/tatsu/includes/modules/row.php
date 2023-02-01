<?php

if (!function_exists('tatsu_row')) {
	function tatsu_row( $atts, $content, $tag ) {
		$atts = shortcode_atts( array(
	        'full_width'=>0,
	        'no_margin_bottom'=>0,
	        'equal_height_columns'=>0,
	        'gutter'=> 'medium',
	        'column_spacing'=> '25px',
	        'row_id' => '',
	        'row_class' => '',
			'fullscreen_cols' => 0,
			'swap_cols'	=> 0,		
	        'hide_in' => '',
			'layout' => '1/1',
			'box_shadow' => '',
			'border_radius' => '',
			'padding' => '',
			'custom_margin' => '',
			'margin' => '',
			'bg_color' => '',
			'border' => '',
			'border_color' => '',
			'key' => be_uniqid_base36(true),
		),$atts, $tag );
		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_row', $key );
		$unique_class_name = 'tatsu-'.$key;
		$animate = ( isset( $animate ) && !empty( $animate ) && 'none' !== $animation_type ) ? 'tatsu-animate' : '';
		$data_animations = be_get_animation_data_atts( $atts );
	    $row_wrap_flag = 0;
	    $class = '';
	    $row_style = '';

		$row_layout = !empty( $layout ) ? preg_replace( '/\s+/', '', $layout ) : '';
		if( 'tatsu_row' == $tag ) {
			if( empty( $full_width ) ){
				$class .= ' tatsu-wrap';
			} else {
				$class .= ' tatsu-row-full-width';
			}
		}


		$columns = explode( '+', $layout );

		if( is_array( $columns ) && in_array( '1/1', $columns ) ) {
			$class .= ' tatsu-row-one-col';
		} elseif ( is_array( $columns ) && in_array( '1/2', $columns ) ) {
			$class .= ' tatsu-row-has-one-half';
		} 

		$no_of_cols = count( $columns );
		$cols_in_words = array( '0' => 'zero', '1' => 'one', '2' => 'two', '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six', '7' => 'seven', '8' => 'eight', '9' => 'nine' ) ;
		$no_of_cols = $cols_in_words[$no_of_cols];
		
		$class .= ' tatsu-row-has-'.$no_of_cols.'-cols';

		if( 'custom' === $gutter ) {
			$column_spacing =  !empty( $column_spacing ) ? intval( $column_spacing ) : 0;
			$column_spacing = intval( $column_spacing / 2 );
			if( !empty( $full_width ) ) {
				$row_style = 'style="margin-left:'.$column_spacing.'px;margin-right:'.$column_spacing.'px;"';
			} else {
				$row_style = 'style="margin-left:-'.$column_spacing.'px;margin-right:-'.$column_spacing.'px;"';
			}
		}

	    $class .= ( isset( $no_margin_bottom ) &&  1 == $no_margin_bottom ) ? ' tatsu-zero-margin' : '' ;
	    $class .= ( isset( $gutter ) ) ? ' tatsu-'.$gutter.'-gutter' : ' tatsu-medium-gutter' ;
	    $class .= ( isset( $equal_height_columns ) &&  1 == $equal_height_columns ) ? ' tatsu-eq-cols' : ' tatsu-reg-cols' ;
		$class .= ( isset( $fullscreen_cols ) && 1 == $fullscreen_cols && 'tatsu_row' == $tag ) ? ' tatsu-fullscreen-cols' : '';
		$class .= ( 'tatsu_inner_row' == $tag ) ? ' tatsu-inner-row-wrap' : ''; 
		if( !empty( $swap_cols ) ) {
			$exploded_layout = explode( '+', $row_layout );
			$layout_size = count( $exploded_layout );
			if( 2 == $layout_size ) {
				$class .= ' tatsu-swap-cols';
			}
		}
		
		//Handle Resposive Visibility controls
		if( !empty( $hide_in ) ) {
			$hide_in = explode(',', $hide_in);
			foreach ( $hide_in as $device ) {
				$class .= ' tatsu-hide-'.$device;
			}
		}	   
		
		
		$row_id = !empty($row_id) ? 'id = "'.$row_id.'"' : '';
		$row_class = !empty($row_class) ? str_replace(',', ' ', $row_class) : '' ;
		
		$output = '<div class="tatsu-row-wrap '.$class.' '.$animate.' tatsu-clearfix '.$unique_class_name.'" '.$data_animations.'>';
		$output .= $custom_style_tag;
		$output .= '<div '.$row_id.' class="tatsu-row '.$row_class.'" '.$row_style.'>';
		$output .= do_shortcode( $content );
		$output .= '</div>';
		$output .= '</div>';
		

		return $output;
	}
	add_shortcode( 'row','tatsu_row' );
	add_shortcode( 'tatsu_row','tatsu_row' );
	add_shortcode( 'tatsu_row1','tatsu_row' );
	add_shortcode( 'tatsu_inner_row', 'tatsu_row' );
}

if( !function_exists( 'tatsu_row_margin_top_callback' ) ) {
	function tatsu_row_margin_top_callback( $margin ){
		
		$value_array = explode( ' ', $margin );
		return $value_array[0];
	}
}
if( !function_exists( 'tatsu_row_margin_bottom_callback' ) ) {
	function tatsu_row_margin_bottom_callback( $margin ){
		
		$value_array = explode( ' ', $margin );
		if( isset( $value_array[1] ) ) {
			return $value_array[1];
		} else {
			return $value_array[0];
		}
	}
}


add_action('tatsu_register_modules', 'tatsu_register_row');
function tatsu_register_row()
{
	$controls = array(
		'icon' => '',
		'title' => esc_html__('Row', 'tatsu'),
		'is_js_dependant' => true,
		'child_module' => 'tatsu_column',
		'label' => 'Row',
		'initial_children' => 1,
		'type' => 'core',
		'builder_layout' => 'column',
		'is_built_in' => true,
		'group_atts' => array(
			array(
				'type'		=> 'tabs',
				'style'		=> 'style1',
				'group'	=> array(
					array(
						'type' => 'tab',
						'title' => esc_html__('Style', 'tatsu'),
						'group'	=> array(
							'full_width',
							'bg_color',
							array(
								'type' => 'accordion',
								'active' => 'all',
								'group' => array(
									array(
										'type' => 'panel',
										'title' => esc_html__('Column Structure', 'tatsu'),
										'group' => array(
											'no_margin_bottom',
											'equal_height_columns',
											'gutter',
											'column_spacing',
											'fullscreen_cols',
											'swap_cols'
										)
									)
								)
							)
						)
					),
					array(
						'type' => 'tab',
						'title' => esc_html__('Advanced', 'tatsu'),
						'group'	=> array(
							array(
								'type' => 'accordion',
								'active' => 'none',
								'group' => array(
									array(
										'type' => 'panel',
										'title' => esc_html__('Spacing', 'tatsu'),
										'group' => array(
											'margin',
											'padding',
										)
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Border', 'tatsu'),
										'group'		=> array(
											'border_style',
											'border',
											'border_color',
											'border_radius',
										),
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Shadow', 'tatsu'),
										'group' => array(
											'box_shadow',
										)
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Identifiers', 'tatsu'),
										'group' => array(
											'row_id',
											'row_class'
										)
									),
								)
							)
						)
					)
				)
			)
		),
		'atts' => array(
			array(
				'att_name' => 'full_width',
				'type' => 'switch',
				'label' => esc_html__('Full Width Row', 'tatsu'),
				'default' => 0,
				'tooltip' => '',
			),
			array(
				'att_name' => 'bg_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__('Background Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-row-wrap > .tatsu-row' => array(
						'property' => 'background-color',
					),
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
				'tooltip' => '',
				'css' => true,
				'responsive' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-row-wrap > .tatsu-row' => array(
						'property' => 'border-style',
						'when' => array(
							array( 'border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
							array( 'border', '!=', '0px 0px 0px 0px' ),
							array( 'border', 'notempty' ),
                            array( 'border_style', '!=', array( 'd' => 'none', 'l' => 'none', 't' => 'none', 'm' => 'none' ) ),
						),
						'relation' => 'and',            
					),
				),
			),
			array(
				'att_name' => 'border',
				'type' => 'input_group',
				'label' => esc_html__('Border Width', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-row-wrap > .tatsu-row' => array(
						'property' => 'border-width',
                        'when' => array(
                            array('border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
							array( 'border', '!=', '0px 0px 0px 0px' ),
							array( 'border', 'notempty' ),
                            array( 'border_style', '!=', array( 'd' => 'none', 'l' => 'none', 't' => 'none', 'm' => 'none' ) ),
                        ),
                        'relation' => 'and',
					),
				),
			),
			array(
				'att_name' => 'border_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__('Border Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-row-wrap > .tatsu-row' => array(
						'property' => 'border-color',
                        'when' => array(
                            array('border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
							array( 'border', '!=', '0px 0px 0px 0px' ),
							array( 'border', 'notempty' ),
                            array( 'border_style', '!=', array( 'd' => 'none', 'l' => 'none', 't' => 'none', 'm' => 'none' ) ),
                        ),
                        'relation' => 'and',
					),
				),
			),
			array(
				'att_name' => 'no_margin_bottom',
				'type' => 'switch',
				'label' => esc_html__('Nullify default bottom margin of columns', 'tatsu'),
				'default' => 0,
				'tooltip' => '',
			),
			array(
				'att_name' => 'equal_height_columns',
				'type' => 'switch',
				'label' => esc_html__('Equal height columns ?', 'tatsu'),
				'default' => 0,
				'tooltip' => '',
			),
			array(
				'att_name' => 'gutter',
				'type' => 'select',
				'label' => esc_html__('Column Spacing', 'tatsu'),
				'options' => array(
					'tiny' => 'Tiny',
					'small' => 'Small',
					'medium' => 'Medium',
					'large' => 'Large',
					'no' => 'Zero',
					'custom' => 'Custom',
				),
				'default' => 'medium',
				'tooltip' => '',
			),
			array(
				'att_name' => 'column_spacing',
				'type' => 'number',
				'is_inline' => true,
				'label' => esc_html__('Custom Spacing', 'tatsu'),
				'options' => array(
					'unit' => 'px',
					'add_unit_to_value' => true,
				),
				'default' => '',
				'tooltip' => '',
				'visible' => array('gutter', '=', 'custom'),
			),
			array(
				'att_name'	=> 'fullscreen_cols',
				'type'		=> 'switch',
				'label'		=> esc_html__('Fullscreen Columns', 'tatsu'),
				'default'	=> 0,
				'tooltip'	=> ''
			),
			array(
				'att_name'		=> 'swap_cols',
				'type'			=> 'switch',
				'label'			=> esc_html__('Swap Columns in Mobile', 'tatsu'),
				'default'		=> 0,
				'tooltip'		=> ''
			),
			array(
				'att_name' => 'padding',
				'type' => 'input_group',
				'label' => esc_html__('Padding', 'tatsu'),
				'default' => '0px 0px 0px 0px',
				'tooltip' => '',
				'css' => true,
				'responsive' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-row-wrap > .tatsu-row' => array(
						'property' => 'padding',
						'when' => array('padding', '!=', array('d' => '0px 0px 0px 0px')),
					),
				),
			), 
			array(
				'att_name' => 'margin',
				'type' => 'negative_number',
				'label' => esc_html__('Margin', 'tatsu'),
				'default' => '0px 0px',
				'options' => array(
					'labels' => array('Top', 'Bottom'),
					'unit' => array('px')
				),
				'tooltip' => '',
				'css' => true,
				'responsive' => true,
				'selectors' => array(
					'.tatsu-{UUID} > .tatsu-row' => array(
						'property' => 'margin-top',
						'when' => array('margin', '!=', array('d' => '0px 0px')),
						'callback' => 'tatsu_row_margin_top_callback',
					),
					'.tatsu-{UUID}.tatsu-row-wrap > .tatsu-row' => array(
						'property' => 'margin-bottom',
						'when' => array('margin', '!=', array('d' => '0px 0px')),
						'callback' => 'tatsu_row_margin_bottom_callback',
					),
				),
			),
			array(
				'att_name' => 'row_id',
				'type' => 'text',
				'label' => esc_html__('CSS ID', 'tatsu'),
				'default' => '',
				'tooltip' => '',
			),
			array(
				'att_name' => 'row_class',
				'type' => 'text',
				'label' => esc_html__('CSS Classes', 'tatsu'),
				'default' => '',
				'tooltip' => 'Use this to add a css class identifier to this Row. Separate multiple classes using Comma',
			),
			array(
				'att_name' => 'box_shadow',
				'type' => 'input_box_shadow',
				'label' => esc_html__('Box Shadow', 'tatsu'),
				'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-row-wrap > .tatsu-row' => array(
						'property' => 'box-shadow',
						'when' => array('box_shadow', '!=', '0px 0px 0px 0px rgba(0,0,0,0)'),
					),
				),
			),
			array(
				'att_name' => 'border_radius',
				'type' => 'number',
				'is_inline' => true,
				'label' => esc_html__('Border Radius', 'tatsu'),
				'options' => array(
					'unit' => array( 'px', '%' ),
					'add_unit_to_value' => true,
				),
				'default' => '0',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-row-wrap > .tatsu-row' => array(
						'property' => 'border-radius',
						'when' => array('border_radius', '!=', '0px'),
					),
				),
				'tooltip' => 'Use this to give border radius',
			),
		),
	);
	tatsu_register_module('tatsu_row', $controls);
}

add_action('tatsu_register_modules', 'tatsu_register_inner_row', 2);
function tatsu_register_inner_row()
{
	$controls = array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#inner_row',
		'title' => esc_html__('Inner Row', 'tatsu'),
		'is_js_dependant' => false,
		'child_module' => 'tatsu_inner_column',
		'allowed_sub_modules' => array('tatsu_inner_column'),
		'type' => 'multi',
		'initial_children' => 1,
		'is_built_in' => true,
		'builder_layout' => 'column',
		'group_atts' => array(
			array(
				'type'		=> 'tabs',
				'style'		=> 'style1',
				'group'	=> array(
					array(
						'type' => 'tab',
						'title' => esc_html__('Style', 'tatsu'),
						'group'	=> array(
							'bg_color',
							array(
								'type' => 'accordion',
								'active' => 'none',
								'group' => array(
									array(
										'type' => 'panel',
										'title' => esc_html__('Column Structure', 'tatsu'),
										'group' => array(
											'no_margin_bottom',
											'equal_height_columns',
											'gutter',
											'column_spacing',
											'swap_cols'
										)
									)
								)
							)
						)
					),
					array(
						'type' => 'tab',
						'title' => esc_html__('Advanced', 'tatsu'),
						'group'	=> array(
							array(
								'type' => 'accordion',
								'active' => 'none',
								'group' => array(
									array(
										'type' => 'panel',
										'title' => esc_html__('Spacing', 'tatsu'),
										'group' => array(
											'margin',
											'padding',
										)
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Border', 'tatsu'),
										'group'		=> array(
											'border_style',
											'border',
											'border_color',
											'border_radius',
										),
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Shadow', 'tatsu'),
										'group' => array(
											'box_shadow',
										)
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Identifiers', 'tatsu'),
										'group' => array(
											'row_id',
											'row_class'
										)
									),
								)
							)
						)
					)
				)
			)
		),
		'atts' => array(
			array(
				'att_name' => 'no_margin_bottom',
				'type' => 'switch',
				'label' => esc_html__('Nullify Default Bottom Margin Of Columns', 'tatsu'),
				'default' => 0,
				'tooltip' => '',
			),
			array(
				'att_name' => 'equal_height_columns',
				'type' => 'switch',
				'label' => esc_html__('Equal Height Columns ?', 'tatsu'),
				'default' => 0,
				'tooltip' => '',
			),
			array(
				'att_name' => 'gutter',
				'type' => 'select',
				'label' => esc_html__('Column Spacing', 'tatsu'),
				'options' => array(
					'tiny' => 'Tiny',
					'small' => 'Small',
					'medium' => 'Medium',
					'large' => 'Large',
					'no' => 'Zero',
					'custom' => 'Custom',
				),
				'default' => 'medium',
				'tooltip' => ''
			),
			array(
				'att_name' => 'column_spacing',
				'type' => 'number',
				'label' => esc_html__('Custom Spacing', 'tatsu'),
				'options' => array(
					'unit' => 'px',
					'add_unit_to_value' => true,
				),
				'default' => '',
				'tooltip' => '',
				'visible' => array('gutter', '=', 'custom'),
			),
			array(
				'att_name'		=> 'swap_cols',
				'type'			=> 'switch',
				'label'			=> esc_html__('Swap Columns in Mobile', 'tatsu'),
				'default'		=> 0,
				'tooltip'		=> ''
			),
			array(
				'att_name' => 'bg_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__('Background Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-row-wrap > .tatsu-row' => array(
						'property' => 'background-color',
					),
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
				'tooltip' => '',
				'css' => true,
				'responsive' => true,
				'selectors' => array(
					'.tatsu-{UUID}' => array(
						'property' => 'border-style',
						'when' => array(
							array( 'border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
							array( 'border', '!=', '0px 0px 0px 0px' ),
							array( 'border', 'notempty' ),
                            array( 'border_style', '!=', array( 'd' => 'none', 'l' => 'none', 't' => 'none', 'm' => 'none' ) ),
						),
						'relation' => 'and',            
					),
				),
			),
			array(
				'att_name' => 'border',
				'type' => 'input_group',
				'label' => esc_html__('Border Width', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-row-wrap' => array(
						'property' => 'border-width',
                        'when' => array(
                            array('border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
							array( 'border', '!=', '0px 0px 0px 0px' ),
							array( 'border', 'notempty' ),
                            array( 'border_style', '!=', array( 'd' => 'none', 'l' => 'none', 't' => 'none', 'm' => 'none' ) ),
                        ),
                        'relation' => 'and',
					),
				),
			),
			array(
				'att_name' => 'border_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__('Border Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-row-wrap' => array(
						'property' => 'border-color',
                        'when' => array(
                            array('border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
							array( 'border', '!=', '0px 0px 0px 0px' ),
							array( 'border', 'notempty' ),
                            array( 'border_style', '!=', array( 'd' => 'none', 'l' => 'none', 't' => 'none', 'm' => 'none' ) ),
                        ),
                        'relation' => 'and',
					),
				),
			),
			array(
				'att_name' => 'border_radius',
				'type' => 'number',
				'is_inline' => true,
				'label' => esc_html__('Border Radius', 'tatsu'),
				'options' => array(
					'unit' => 'px',
					'add_unit_to_value' => true,
				),
				'default' => '0',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-row-wrap > .tatsu-row' => array(
						'property' => 'border-radius',
						'when' => array('border_radius', '!=', '0px'),
					),
				),
				'tooltip' => 'Use this to give border radius',
			),
			array(
				'att_name' => 'box_shadow',
				'type' => 'input_box_shadow',
				'label' => esc_html__('Box Shadow', 'tatsu'),
				'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-row-wrap > .tatsu-row' => array(
						'property' => 'box-shadow',
						'when' => array('box_shadow', '!=', '0px 0px 0px 0px rgba(0,0,0,0)'),
					),
				),
			),
			array(
				'att_name' => 'margin',
				'type' => 'negative_number',
				'label' => esc_html__('Margin', 'tatsu'),
				'default' => '0px 0px',
				'options' => array(
					'labels' => array('Top', 'Bottom'),
					'unit' => array('px')
				),
				'tooltip' => '',
				'css' => true,
				'responsive' => true,
				'selectors' => array(
					'.tatsu-{UUID} > .tatsu-row' => array(
						'property' => 'margin-top',
						'when' => array('margin', '!=', array('d' => '0px 0px')),
						'callback' => 'tatsu_row_margin_top_callback',
					),
					'.tatsu-{UUID}.tatsu-row-wrap > .tatsu-row' => array(
						'property' => 'margin-bottom',
						'when' => array('margin', '!=', array('d' => '0px 0px')),
						'callback' => 'tatsu_row_margin_bottom_callback',
					),
				),
			),
			array(
				'att_name' => 'padding',
				'type' => 'input_group',
				'label' => esc_html__('Padding', 'tatsu'),
				'default' => '0px 0px 0px 0px',
				'tooltip' => '',
				'css' => true,
				'responsive' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-row-wrap > .tatsu-row' => array(
						'property' => 'padding',
						'when' => array('padding', '!=', array('d' => '0px 0px 0px 0px')),
					),
				),
			),
			array(
				'att_name' => 'row_id',
				'type' => 'text',
				'label' => esc_html__('CSS ID', 'tatsu'),
				'default' => '',
				'tooltip' => '',
			),
			array(
				'att_name' => 'row_class',
				'type' => 'text',
				'label' => esc_html__('CSS Classes', 'tatsu'),
				'default' => '',
				'tooltip' => 'Use this to add a css class identifier to this Row. Separate multiple classes using Comma',
			),
		),
	);
	tatsu_register_module('tatsu_inner_row', $controls);
}

?>