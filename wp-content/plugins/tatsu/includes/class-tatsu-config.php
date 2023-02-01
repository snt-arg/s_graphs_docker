<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Tatsu_Config {

	private static $instance;
	private $google_maps_api_key = '';
	private $common_atts = '';
 	private static $css_animations = array(
        'flipInX' => 'flipInX', 
        'flipInY' => 'flipInY', 
        'fadeIn' => 'fadeIn', 
        'fadeInDown' => 'fadeInDown', 
        'fadeInLeft' => 'fadeInLeft', 
        'fadeInRight' => 'fadeInRight', 
        'fadeInUp' => 'fadeInUp', 
        'slideInDown' => 'slideInDown', 
        'slideInLeft' => 'slideInLeft', 
        'slideInRight' => 'slideInRight', 
        'rollIn' => 'rollIn', 
        'rollOut' => 'rollOut',
        'bounce' => 'bounce',
        'bounceIn' => 'bounceIn',
        'bounceInUp' => 'bounceInUp',
        'bounceInDown' => 'bounceInDown',
        'bounceInLeft' => 'bounceInLeft',
        'bounceInRight' => 'bounceInRight',
        'fadeInUpBig' => 'fadeInUpBig',
        'fadeInDownBig' => 'fadeInDownBig',
        'fadeInLeftBig' => 'fadeInLeftBig',
        'fadeInRightBig' => 'fadeInRightBig',
        'flash' => 'flash',
        'flip' => 'flip',
        'lightSpeedIn' => 'lightSpeedIn',
        'pulse' => 'pulse',
        'rotateIn' => 'rotateIn',
        'rotateInUpLeft' => 'rotateInUpLeft',
        'rotateInDownLeft' => 'rotateInDownLeft',
        'rotateInUpRight' => 'rotateInUpRight',
        'rotateInDownRight' => 'rotateInDownRight',
        'shake' => 'shake',
        'swing' => 'swing',
        'tada' => 'tada',
        'wiggle' => 'wiggle',
        'wobble' => 'wobble',
        'infiniteJump' => 'infiniteJump',
        'zoomIn' => 'zoomIn',
        'none' => 'none'
    );

	public static function getInstance() {
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
 
        return self::$instance;		
	}

	private function __construct() {
        $this->google_maps_api_key = get_option( 'tatsu_google_map_id' );
		$this->common_atts = array (
            array (
                'atts'  => array(
                    array (
                        'att_name' => 'hide_in',
                        'is_inline' => true,
                        'exclude' => array('tatsu_testimonial_carousel'),
                        'type' => 'screen_visibility',
                        'label' => esc_html__( 'Hide in', 'tatsu' ),
                        'default' => '',
                        'tooltip' => '',
                    ),
                    array (
                        'att_name' => 'css_id',
                        'type' => 'text',
                        'exclude' => array( 'tatsu_section', 'tatsu_row', 'tatsu_column', 'tatsu_inner_column', 'tatsu_inner_row', 'tatsu_code', 'tatsu_empty_space', 'tatsu_header_logo', 'tatsu_header_column', 'tatsu_header_row' ),
                        'label' => esc_html__( 'CSS ID', 'tatsu' ),
                        'default' => '',
                        'tooltip' => '',
                    ),
                    array (
                        'att_name' => 'css_classes',
                        'exclude' => array( 'tatsu_section', 'tatsu_row', 'tatsu_column', 'tatsu_inner_column', 'tatsu_inner_row' , 'tatsu_code', 'tatsu_empty_space', 'tatsu_header_logo', 'tatsu_header_column', 'tatsu_header_row' ),
                        'type' => 'text',
                        'label' => esc_html__( 'CSS Classes', 'tatsu' ),
                        'default' => '',
                        'tooltip' => '',
                    ),
                    array(
                        'att_name' => 'animate',
                        'type' => 'switch',
                        'exclude' => array('tatsu_empty_space'),
                        'default' => 1,
                        'label' => esc_html__('Enable Css Animations', 'tatsu'),
                        'tooltip' => ''
                    ),
                    array (
                        'att_name' => 'animation_type',
                        'type' => 'select',
                        'exclude' => array( 'tatsu_testimonial_carousel', 'tatsu_empty_space', 'tatsu_svg_icon' ),
                        'options' => self::$css_animations,
                        'label' => esc_html__( 'Animation Type', 'tatsu' ),
                        'default' => 'none',
                        'tooltip' => '',
                    ),
                    array(
                       'att_name' => 'animation_delay',
                       'type' => 'slider',
                       'exclude' => array( 'tatsu_testimonial_carousel', 'tatsu_empty_space', 'tatsu_svg_icon' ),
                       'options' => array(
                           'min' => '0',
                           'max' => '5000',
                           'step' => '1',
                           'unit' => 'ms',
                       ),
                       'default' => '0',	        		
                       'label' => esc_html__( 'Animation Delay', 'tatsu' ),
                       'tooltip' => '',
                       'visible' => array( 'animation_type', '!=', 'none' ),
                    ),
                    array (
                        'att_name' => 'animation_duration',
                        'type' => 'slider',
                        'exclude' => array('tatsu_testimonial_carousel', 'tatsu_svg_icon', 'tatsu_empty_space'),
                        'default' => '300',
                        'options' => array(
                            'min' => '100',
                            'max' => '3000',
                            'step' => '1',
                            'unit' => 'ms',
                        ),
                        'label' => esc_html__( 'Animation Duration', 'tatsu' ),
                        'visible' => array( 'animation_type', '!=', 'none' ),
                        'tooltip' => ''
                    ),
                    array (
                        'att_name' => 'padding',
                        'type' => 'input_group',
                        'exclude' => array('tatsu_empty_space', 'special_heading2'),
                        'label' => esc_html__( 'Padding', 'tatsu' ),
                        'default' => '',
                        'tooltip' => '',
                        'css' => true,
                        'responsive' => true,
                        'selectors' => array(
                            '.tatsu-{UUID}' => array(
                                'property' => 'padding',
                                'when' => array( 'padding', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
                            ),
                        ),
                    ),
                    array (
                        'att_name' => 'margin',
                        'type' => 'input_group',
                        'exclude' => array('tatsu_empty_space', 'special_heading2', 'special_sub_title'),
                        'label' => esc_html__( 'Margin', 'tatsu' ),
                        'default' => '',
                        'tooltip' => '',
                        'css' => true,
                        'responsive' => true,
                        'selectors' => array(
                            '.tatsu-{UUID}' => array(
                                'property' => 'margin',
                                'when' => array( 'margin', '!=', array( 'd' => '0px 0px 60px 0px' ) ),
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
                        'exclude' => array( 'tatsu_image', 'tatsu_empty_space', 'special_heading2','menu_card' ),
                        'tooltip' => '',
                        'css' => true,
                        'responsive' => true,
                        'selectors' => array(
                            '.tatsu-{UUID}' => array(
                                'property' => 'border-style',
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
                    array (
                        'att_name' => 'border',
                        'type' => 'input_group',
                        'label' => esc_html__( 'Border Width', 'tatsu' ),
                        'default' => '',
                        'exclude' => array( 'tatsu_image', 'tatsu_lists', 'tatsu_empty_space', 'special_heading2','menu_card' ),
                        'tooltip' => '',
                        'responsive' => true,
                        'css' => true,
                        'selectors' => array(
                            '.tatsu-{UUID}' => array(
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
                    array (
                        'att_name' => 'border_color',
                        'type' => 'color',
                        'label' => esc_html__( 'Border Color', 'tatsu' ),
                        'default' => '',
                        'exclude' => array( 'tatsu_image', 'tatsu_lists', 'tatsu_call_to_action', 'tatsu_icon', 'tatsu_tabs', 'tatsu_accordion', 'tatsu_empty_space', 'special_heading2','menu_card' ),
                        'tooltip' => '',
                        'css' => true,
                        'selectors' => array(
                            '.tatsu-{UUID}' => array(
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
                    array (
                        'att_name'	=> 'border_radius',
                        'type'		=> 'number',
                        'is_inline' => true,
                        'exclude' => array('tatsu_empty_space','menu_card', 'special_heading2'),
                        'is_inline' => true,
                        'label'		=> esc_html__( 'Border Radius', 'tatsu' ),
                        'options' 	=> array (
                            'unit'	=> array( 'px', '%' ),
                        ),
                        'default'	=> '',
                        'css'		=> true,
                        'selectors'	=> array (
                            '.tatsu-{UUID}'	=>  array (
                                'property' => 'border-radius',
                                'append' => 'px'
                            )
                        )
                    ),
                    array (
                        'att_name' => 'box_shadow',
                        'type' => 'input_box_shadow',
                        'label' => esc_html__( 'Box Shadow', 'tatsu' ),
                        'exclude' => array( 'tatsu_column', 'tatsu_inner_column', 'tatsu_image', 'tatsu_icon_card', 'tatsu_title_icon', 'tatsu_button', 'tatsu_gradient_button', 'tatsu_empty_space', 'tatsu_multi_layer_image' ),
                        'tooltip' => '',
                        'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
                        'css' => true,
                        'selectors' => array(
                            '.tatsu-{UUID}' => array(
                                'property' => 'box-shadow',
                                'when' => array('box_shadow', '!=', '0px 0px 0px 0px rgba(0,0,0,0)' ),
                            ),
                        ),
                    ),
                ),
                'group_atts'  => array (    
                    array ( 
						'type'		=> 'tabs',
						'style'		=> 'style1',
						'group'		=> array(
							array (
								'type' => 'tab',
								'title' => esc_html__( 'Content', 'tatsu' ),
								'group'	=> array (
                                )
                            ),
                            array (
								'type' => 'tab',
								'title' => esc_html__( 'Style', 'tatsu' ),
								'group'	=> array (
                                )
                            ),
                            array (
								'type' => 'tab',
								'title' => esc_html__( 'Advanced', 'tatsu' ),
								'group'	=> array (
                                    array (
										'type' => 'accordion' ,
										'active' => array(0),
										'group' => array (
                                            array (
												'type' => 'panel',
												'title' => esc_html__( 'Spacing', 'tatsu' ),
												'group' => array (
                                                    'margin',
                                                    'padding',
                                                ),
                                            ),
                                            array (
												'type' => 'panel',
												'title' => esc_html__( 'Border', 'tatsu' ),
												'group' => array (
                                                    'border_style',
                                                    'border',
                                                    'border_color',
                                                    'border_radius',
                                                ),
                                            ),
                                            array (
												'type' => 'panel',
												'title' => esc_html__( 'Shadow', 'tatsu' ),
												'group' => array (
                                                    'box_shadow',
                                                ),
                                            ),
                                            array (
												'type' => 'panel',
                                                'title' => esc_html__( 'Animation', 'tatsu' ),
												'group' => array (
                                                    'animation_type',
                                                    'animation_delay',
                                                    'animation_duration',
                                                ),
                                            ),
											array (
												'type' => 'panel',
												'title' => esc_html__( 'Identifiers', 'tatsu' ),
												'group' => array (
                                                    'css_id',
                                                    'css_classes',
                                                ),
                                            ),
											array (
												'type' => 'panel',
												'title' => esc_html__( 'Visibility', 'tatsu' ),
												'group' => array (
                                                    'hide_in'
                                                ),
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
                'exclude' => apply_filters( 'tatsu_default_common_atts_global_excludes', array( 'tatsu_tab', 'tatsu_toggle' ) )
            ),
        );
	}

	public function get_css_animations() {
		return self::$css_animations;
	}

	public function get_google_maps_api_key() {
		return apply_filters( 'tatsu_gmaps_api_key', $this->google_maps_api_key );
    }
    
    public function get_common_atts() {
        return apply_filters( 'tatsu_common_atts', $this->common_atts );
    }

	public function get_core_modules() {
		return apply_filters( 'tatsu_core_modules', array( 'tatsu_section', 'tatsu_row', 'tatsu_column', 'tatsu_inner_row', 'tatsu_inner_column', 'tatsu_header_row', 'tatsu_header_column' , 'tatsu_slide_menu_column' ) );
	}

}