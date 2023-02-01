<?php
/**************************************
			Animated Box Style1
**************************************/
if ( ! function_exists( 'be_animate_icons_style1' ) ) {
	function be_animate_icons_style1( $atts, $content ) {
		$atts = shortcode_atts( array (
			'height' => '300',
			'gutter' => '',
			'key' => be_uniqid_base36(true),
		),$atts );
		extract( $atts );
		$height = ( isset( $height ) && !empty( $height ) ) ? $height : 300 ;
		$custom_style_tag = be_generate_css_from_atts( $atts, 'animate_icons_style1', $atts['key'] );
		$custom_class_name = ' tatsu-'.$atts['key'];

	//    $GLOBALS['be_animate_icon_style1_gutter']  = $gutter = ( isset( $gutter ) && !empty( $gutter ) && $gutter != '0' ) ? $gutter : '0' ;
		$output = '';
		$output .= '<div class="oshine-module oshine-am-fh display-block '.$custom_class_name.'">'.$custom_style_tag.'<div class="animate-icon-module-style1-wrap-container"><div class="animate-icon-module-style1-wrap clearfix" data-gutter-width="'.$gutter.'">'.do_shortcode($content).'</div></div></div>';
		return $output;
	}
	add_shortcode( 'animate_icons_style1', 'be_animate_icons_style1' );
}

if ( ! function_exists( 'be_animate_icon_style1' ) ) {
	function be_animate_icon_style1( $atts, $content, $tag ) {
		$atts =  shortcode_atts( array (
			'icon' => 'none',
			'title' => '',
			'title_font' => 'h6',
			'size' => 30,
			'icon_color' => '',
			'link_to_url' => '',
			'height' => '',
			'bg_image' => '',
			'bg_color' => '',
			'hover_bg_color' => '',
			'bg_overlay' => 0,
			'overlay_color' => '',
			//'overlay_opacity' => '',
			'hover_overlay_color' => '',
			'hover_overlay_opacity' => '',
			'animate_direction' => 'top',
			'key' => be_uniqid_base36(true),
		),$atts, $tag );

		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, $tag, $atts['key'] );
		$custom_class_name = 'tatsu-'.$atts['key'];
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );
		$animate = ( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) ? ' tatsu-animate' : '';  		
		$data_animations = be_get_animation_data_atts( $atts );

		$link_to_url = ( isset( $link_to_url ) && !empty( $link_to_url ) ) ? $link_to_url : '#' ;
	    $animate_direction = ( isset( $animate_direction ) && !empty( $animate_direction ) ) ? $animate_direction : 'top';
	    $bg_overlay_class = ( isset( $bg_overlay ) && 1 == $bg_overlay ) ? 'ai-has-overlay' : '' ;
	    $title_font = ( isset( $title_font ) && !empty($title_font) ) ? $title_font : 'h6' ;
	//    $margin_bottom = $GLOBALS['be_animate_icon_style1_gutter'];
	    if( !empty( $bg_image ) ) {
	    	//$attachment_info = wp_get_attachment_image_src( $bg_image, 'full' );
			//$attachment_url = $attachment_info[0];
	    	$bg_image = 'background: url('.$bg_image.');';
	    } 
	    $output = '';
		$output .= '<a '.$css_id.' href="'.$link_to_url.'" class="animate-icon-module-style1 be-bg-cover animate-icon-module '.$bg_overlay_class.' '.$animate_direction.'-animate '.$custom_class_name.' '.$animate.' '.$visibility_classes.' '.$css_classes.'" '.$data_animations.'>';
		$output .= $custom_style_tag;
		$output .= '<div class="animate-icon-module-normal-content"><div class="display-table"><div class="display-table-cell vertical-align-middle"><i class="font-icon '.$icon.'" ></i>';
		$output .= !empty($title) ? '<'.$title_font.'  class="title_content" >'.$title.'</'.$title_font.'>' : '';
		$output .= '</div></div></div>'; //closing tags for Normal Content
		$output .= '<div class="animate-icon-module-hover-content"><div class="display-table"><div class="display-table-cell vertical-align-middle">'.$content.'</div></div></div>';
		if( isset( $bg_overlay ) && 1 == $bg_overlay && !empty( $bg_image ) ) {
			$output .= '<div class="ai-overlay" ></div>';
		}
		$output .= '</a>';
		return $output;
	}
	add_shortcode( 'animate_icon_style1', 'be_animate_icon_style1' );
}

if( !function_exists( 'oshine_modules_remove_common_atts_from_animated_module1' ) ) {
	add_filter( 'tatsu_default_common_atts_global_excludes', 'oshine_modules_remove_common_atts_from_animated_module1' );
	function oshine_modules_remove_common_atts_from_animated_module1( $excludes_array ) {
		$excludes_array[] = 'animate_icons_style1';
		return $excludes_array;
	}
}

add_action( 'tatsu_register_modules', 'oshine_register_animate_icons_style1');
function oshine_register_animate_icons_style1() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#animated_module',
	        'title' => __( 'Fixed Height Animated Module', 'oshine-modules' ),
	        'is_js_dependant' => true,
	        'child_module' => 'animate_icon_style1',
	        'type' => 'multi',
	        'initial_children' => 3,
	        'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'height',
					'type' => 'number',
					'is_inline' => true,
	        		'label' => __( 'Height', 'oshine-modules' ),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '300',
					'tooltip' => '',
					'responsive' => true,
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .animate-icon-module-style1-wrap' => array(
							'property' => 'height',
							'append' => 'px',
						),
					),
				),
				array (
					'att_name' => 'gutter',
					'type' => 'number',
					'is_inline' => true,
					'label' => __( 'Gutter Width', 'oshine-modules' ),
					'options' => array(
						'unit' => 'px',
					),	        		
					'default' => '40',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .animate-icon-module-style1' => array(
							'property' => 'margin-bottom',
							'append' => 'px',
						),
					),
	        	),
	        ),
	    );
	tatsu_register_module( 'animate_icons_style1', $controls );
}



add_action( 'tatsu_register_modules', 'oshine_register_animate_icon_style1');
function oshine_register_animate_icon_style1() {
		$controls = array (
			'icon' => '',
			'title' => __( 'Element', 'oshine-modules' ),
			'is_js_dependant' => false,
			'child_module' => '',
			'type' => 'sub_module',
			'is_built_in' => true,
			'hint' => 'title',
			'group_atts' => array (
				array (
					'type'	=>	'tabs',
					'style'	=>	'style1',
					'group'	=>	array (
						array (
							'type'	=>	'tab',
							'title'	=>	__( 'Content' , 'tatsu'),
							'group'	=>	array (
								'icon',
								'title',
								'content',
								'link_to_url',
							)
						),
						array (
							'type'	=>	'tab',
							'title'	=>	__( 'Style' , 'tatsu'),
							'group'	=>	array (
								array (
									'type' => 'accordion' ,
									'active' => 'all',
									'group' => array (
										'title_font',
										'size',
										'icon_color',
										array (
											'type' => 'panel',
											'title' => __( 'Background', 'tatsu' ),
											'group' => array (
												'bg_image',
												'bg_color',
												'hover_bg_color',
												'bg_overlay',
												'overlay_color',
												'hover_overlay_color',
											)
										),
										'animate_direction',
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
					'att_name' => 'link_to_url',
					'type' => 'text',
					'is_inline' => false,
					'label' => __( 'Link URL', 'oshine-modules' ),
					'default' => '',
					'tooltip' => '',
					'options' => array(
						'placeholder' => 'https://example.com'
					)
				),
				array (
					'att_name' => 'bg_image',
					'type' => 'single_image_picker',
					'label' => __( 'Background Image', 'oshine-modules' ),
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}' => array(
							'property'=> 'background-image',
						),
					),
				),
				array (
					'att_name' => 'bg_color',
					'type' => 'color',
					'label' => __( 'Background Color', 'oshine-modules' ),
					'default' => '',
					'tooltip' => '',
					'visible' => array( 'bg_image', '=', '' ),
					'css' => true,
					'selectors' => array(
					  '.tatsu-{UUID}' => array(
						  'property' => 'background-color',
						),
					),
				),
				array (
					'att_name' => 'hover_bg_color',
					'type' => 'color',
					'label' => __( 'Background Color - Hover State', 'oshine-modules' ),
					'default' => '',
					'tooltip' => '',
					'visible' => array( 'bg_image', '=', '' ),
					'css' => true,
					'selectors' => array(
					  '.tatsu-{UUID}:hover' => array(
						  'property' => 'background-color',
					  ),
				  ),
				),
				array (
					'att_name' => 'bg_overlay',
					'type' => 'switch',
					'label' => __( 'Enable Overlay', 'oshine-modules' ),
					'default' => 0,
					'tooltip' => '',
					'visible' => array( 'bg_image', '!=', '' ),
				),
				array (
					'att_name' => 'overlay_color',
					'type' => 'color',
					'label' => __( 'Overlay Background Color', 'oshine-modules' ),
					'default' => '',
					'tooltip' => '',
					'visible' => array(
						'condition' => array(
							array( 'bg_overlay', '=', '1' ),
							array( 'bg_image', '!=', '' ),
						),
						'relation' => 'and', 
					),
					'css' => true,
					'selectors' => array(
					  '.tatsu-{UUID} .ai-overlay' => array(
						  'property' => 'background-color',
						),
					),
				),
				array (
					'att_name' => 'hover_overlay_color',
					'type' => 'color',
					'label' => __( 'Hover Overlay Background Color', 'oshine-modules' ),
					'default' => '',
					'tooltip' => '',
					'visible' => array(
						'condition' => array(
							array( 'bg_overlay', '=', '1' ),
							array( 'bg_image', '!=', '' ),
						),
						'relation' => 'and', 
					),
					'css' => true,
					'selectors' => array(
					  '.tatsu-{UUID}:hover .ai-overlay' => array(
						  'property' => 'background-color',
						),
					),
				),
				array (
					'att_name' => 'icon',
					'type' => 'icon_picker',
					'label' => __( 'Icon', 'oshine-modules' ),
					'default' => '',
					'tooltip' => ''
				),
				array (
					'att_name' => 'size',
					'type' => 'number',
					'is_inline' => true,
					'label' => __( 'Icon Size', 'oshine-modules' ),
					'options' => array(
						'unit' => 'px',
					),
					'default' => '30',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .font-icon' => array(
							'property' => 'font-size',
							'append' => 'px'
						),
					),
				),
				array (
				'att_name' => 'title',
					'type' => 'text',
					'is_inline' => false,
					'label' => __( 'Title', 'oshine-modules' ),
					'default' => '',
					'tooltip' => ''
				),
				array (
					'att_name' => 'title_font',
					'type' => 'select',
					'label' => __( 'Title Tag', 'oshine-modules' ),
					'options' => array (
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
				array (
					'att_name' => 'icon_color',
					'type' => 'color',
					'label' => __( 'Icon and Title Color', 'oshine-modules' ),
					'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .font-icon' => array(
							'property' => 'color',
						),
						'.tatsu-{UUID} .title_content' =>  array(
							'property' => 'color',
						)
					),
				),
				array (
					'att_name' => 'content',
					'type' => 'tinymce',
					'label' => __( 'Content on Hover', 'oshine-modules' ),
					'default' => '',
					'tooltip' => ''
 				),
 				array (
					'att_name' => 'animate_direction',
					'type' => 'select',
					'label' => __( 'Animation', 'oshine-modules' ),
					'options' => array (
						'top' => 'Slide Top', 
						'left' => 'Slide Left', 
						'right' => 'Slide Right', 
						'bottom' => 'Slide Bottom', 
						'fade' => 'Fade'
					),
					'default' => 'top',
					'tooltip' => ''
				),
			),
			'presets' => array(
			'default' => array(
					'title' => '',
					'image' => '',
					'preset' => array(
						'bg_color' => '#000',
						'hover_bg_color' => '#232323',
						'icon' => 'icon-icon_desktop',
						'title' => 'Title Goes Here',
						'content' => '<span style="color:#fff;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.</span>',
						'icon_color' => '#ffffff',
					),
				)
			),
		);
	tatsu_register_module( 'animate_icon_style1', $controls );
}