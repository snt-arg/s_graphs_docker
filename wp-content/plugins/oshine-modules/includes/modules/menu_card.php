<?php
/**************************************
			MENU CARD 
**************************************/
if (!function_exists('be_menu_cards')) {
	function be_menu_cards( $atts, $content, $tag ) {
			$atts = shortcode_atts( array (
				'title' => '',
				'ingredients' => '',
				'price' => '',
				'title_color' => '',
				'ingredients_color' => '',
				'price_color' => '',
				'highlight' => '',
				'highlight_color' => '',
				'star' => '',
				'star_color' => '',
				'border_color' => '',
				'key' => be_uniqid_base36(true),
			), $atts, $tag );
			
			extract( $atts );
			$custom_style_tag = be_generate_css_from_atts( $atts, 'menu_card', $atts['key'] );
			$custom_class_name = ' tatsu-'.$atts['key'];

			$css_id = be_get_id_from_atts( $atts );
			$visibility_classes = be_get_visibility_classes_from_atts( $atts );
	
	
			$data_animations = be_get_animation_data_atts( $atts );
			if( !empty( $animation_type ) && 'none' !== $animation_type ) {
				$css_classes .= ' tatsu-animate ';
			}

	    	$highlight = ( isset( $highlight ) && 1 == $highlight ) ? 'highlight-menu-item' : '' ;

			$output = '';
	    	$output .= '<div '.$css_id.' class="menu-card-item '. $custom_class_name .' oshine-module  clearfix '.$highlight.' '.$visibility_classes.' '.$css_classes.'" '.$data_animations.' >';
			$output .= '<div class="menu-card-item-info">';
			$output .= '<span class="h6-font menu-card-title" >'.$title.'</span>';
			$output .= '<span class="menu-card-ingredients special-subtitle" >'.$ingredients.'</span>';
			$output .= '<span class="menu-card-item-price" >'.$price.'</span>';
			if( isset( $star ) && 1 == $star ) {
				$output .= '<i class="icon-icon_star menu-card-item-stared alt-color" ></i>';
			}
			$output .= '</div>';
			$output .= $custom_style_tag;
	        $output .= '</div>';
	        return $output;
	}
	add_shortcode( 'menu_card', 'be_menu_cards' );
}

add_action( 'tatsu_register_modules', 'oshine_register_menu_card');
function oshine_register_menu_card() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#menu_card',
	        'title' => __( 'Card', 'oshine-modules' ),
	        'is_js_dependant' => false,
	        'child_module' => '',
	        'type' => 'single',
			'hint' => 'title',
	        'is_built_in' => true,
			'group_atts' => array (
				array (
					'type'	=>	'tabs',
					'style'	=>	'style1',
					'group'	=>	array (
						array (
							'type'	=>	'tab',
							'title'	=>	__( 'Content' , 'tatsu'),
							'group'	=>	array (
								'title',
								'ingredients',
								'price',
								'star',
							)
						),
						array (
							'type'	=>	'tab',
							'title'	=>	__( 'Style' , 'tatsu'),
							'group'	=>	array (
								array (
									'type' => 'accordion' ,
									'active' => array(0, 1),
									'group' => array (
										array (
											'type' => 'panel',
											'title' => __( 'Colors', 'tatsu' ),
											'group' => array (
												'title_color',
												'ingredients_color',
												'price_color',
												'star_color',
												'highlight_color',
												'border_color',
											)
										),
										'highlight',
									)
								)
							),
						),
						array (
							'type'	=>	'tab',
							'title'	=>	__( 'Advanced' , 'tatsu'),
							'group'	=>	array (
							)
						),
					)
				),
			),
	        'atts' => array (
	        	array (
	        		'att_name' => 'title',
	        		'type' => 'text',
	        		'label' => __( 'Title', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'ingredients',
	        		'type' => 'text',
	        		'label' => __( 'Caption', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'price',
	        		'type' => 'text',
	        		'label' => __( 'Price', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
				array (
		            'att_name' => 'title_color',
		            'type' => 'color',
		            'label' => __( 'Title Text Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .menu-card-title' => array(
							'property' => 'color'
						),
					),
	            ),
				array (
		            'att_name' => 'ingredients_color',
		            'type' => 'color',
		            'label' => __( 'Caption Text Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .menu-card-ingredients' => array(
							'property' => 'color'
						),
					),
	            ),
				array (
		            'att_name' => 'price_color',
		            'type' => 'color',
		            'label' => __( 'Price Text Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .menu-card-item-price' => array(
							'property' => 'color'
						),
					),
	            ),
	            array (
	              	'att_name' => 'highlight',
	              	'type' => 'switch',
	              	'label' => __( 'Highlight this item', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),	            
				array (
		            'att_name' => 'highlight_color',
		            'type' => 'color',
		            'label' => __( 'Highlight Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'visible' => array ('highlight' , '=' , '1'),
					'selectors' => array(
						'.tatsu-{UUID}.menu-card-item' => array(
							'property' => 'background',
							'when' => array('highlight','=','1')
						),
					),
	            ),	
	            array (
	              	'att_name' => 'star',
	              	'type' => 'switch',
	              	'label' => __( 'Mark item with a Star', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
				array (
		            'att_name' => 'star_color',
		            'type' => 'color',
		            'label' => __( 'Star Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .menu-card-item-stared' => array(
							'property' => 'color'
						),
					),
	            ),
				array (
		            'att_name' => 'border_color',
		            'type' => 'color',
		            'label' => __( 'Border Color', 'oshine-modules' ),
		            'default' => '',
		            'tooltip' => '',
					'visible' => array( 'highlight', '==', '0' ),
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.menu-card-item' => array(
							'property' => 'border-color'
						),
					),
				),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'title' => 'Pasta Primavera',
	        			'ingredients' => 'Penne, Tomatoes, Onions, Capsicum, Cream, Garlic',
	        			'price' => '$12',
	        			'border_color' => '#efefef',
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'menu_card', $controls );
}