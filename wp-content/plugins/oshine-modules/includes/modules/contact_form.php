<?php
/**************************************
		Contact Form
**************************************/
if ( ! function_exists( 'be_contact_form' ) ) {
	function be_contact_form( $atts, $content, $tag ) {
		$atts = shortcode_atts( array (
			'form_style' => 'style1',
			'input_bg_color' => '',
			'input_color' => '',
		    'input_border_color' => '',
		    'border_width' => '',
		    'input_height' => '',
		    'input_style' => 'style1',
		    'input_button_style' => 'medium',
		    'bg_color' => '',
		    'color' => '',
			'key' => be_uniqid_base36(true),
		),$atts, $tag );		

		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key );
		$unique_class_name = 'tatsu-'.$key;
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );
		$animate = ( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) ? ' tatsu-animate' : '';  		
		$data_animations = be_get_animation_data_atts( $atts );
		global $be_themes_data;

		$output = '';
	//	$styles_height = ( isset( $input_height ) && !empty( $input_height) ) ? 'height: '.$input_height.'px;' : '';
		$border_width = 'style="border-width:'.$border_width.'px"';
		$form_style =  ( isset( $form_style ) && !empty( $form_style) ) ? $form_style : 'style1';
		$input_style = ( isset( $input_style ) && !empty( $input_style) ) ? $input_style : 'style1';
		$input_button_style = ( isset( $input_button_style ) && !empty( $input_button_style) ) ? $input_button_style : 'medium';
		$privacy_policy_link = ( function_exists( 'get_privacy_policy_url' ) ) ? get_privacy_policy_url() : '#';
		$output .= '<div '.$css_id.' class="contact_form contact_form_module oshine-module '.$form_style.' '.$input_style.'-input '.$unique_class_name.' '.$animate.' '.$visibility_classes.' '.$css_classes.'" '.$data_animations.' data-consent-error = "'.__('Please check the consent box, in order for us to process this form', 'oshine-modules').'">
						<form method="post" class="contact">
							<fieldset class="field_name contact_fieldset">
								<input type="text" name="contact_name" class="txt autoclear" placeholder="'.__('Name','oshine-modules').'" '.$border_width.' />
							</fieldset>
							<fieldset class="field_email contact_fieldset">
								<input type="text" name="contact_email" class="txt autoclear" placeholder="'.__('Email','oshine-modules').'" '.$border_width.' />
							</fieldset>';
		if($form_style != 'style2'){
			$output .= '<fieldset class="field_subject contact_fieldset">
								<input type="text" name="contact_subject" class="txt autoclear" placeholder="'.__('Subject','oshine-modules').'" '.$border_width.' />
						</fieldset>';
		}							
		$output .= '<fieldset class="field_comment contact_fieldset">
								<textarea name="contact_comment" class="txt_area autoclear" placeholder="'.__('Message','oshine-modules').'" '.$border_width.' ></textarea>
							</fieldset>';
		if( !empty( $be_themes_data['consent_checkboxes'] ) ) {
			$output .= '<fieldset class="field_consent contact_fieldset">
							<input type="checkbox" name="contact_consent" class="consent-checkbox" placeholder="'.__('Subject','oshine-modules').'" '.$border_width.' />
							<span class="consent-message">'.sprintf( __('By checking this box, you consent to sending your details to us over email. For more info check our <a href="%s" target="_blank">privacy policy</a> where you will get more info on where, how and why we store your data.', 'oshine-modules'), esc_url( $privacy_policy_link) ).'</span>
							</fieldset>';
		}

		$output .= '<fieldset class="contact_fieldset submit-fieldset">
								<input type = "hidden" name = "contact_style" value = "'. $form_style .'"/> 
								<input type="submit" name="contact_submit" value="'.__('Submit','oshine-modules').'" class="contact_submit tatsu-button rounded '.$input_button_style.'btn" />
								<div class="contact_loader"><div class="font-icon loader-style4-wrap loader-icon"></div></div>
							</fieldset>';
				
		$output	.=		'<div class="contact_status tatsu-notification"></div>
						</form>'.$custom_style_tag.'
					</div>';


		return $output; 
	}
	add_shortcode('contact_form','be_contact_form');
}

add_filter( 'contact_form_before_css_generation', 'contact_form_css' );
function contact_form_css( $atts ) {
	$atts['input_bg_color'] = ( !empty($atts['input_bg_color']) ? $atts['input_bg_color'] : 'transparent' );
	$atts['input_color'] = ( !empty($atts['input_color']) ? $atts['input_color'] : 'input_color' );
	return $atts;
}



add_action( 'tatsu_register_modules', 'oshine_register_contact_form');
function oshine_register_contact_form() {
	$controls = array (
        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#contact_form',
        'title' => __( 'Contact Form', 'oshine-modules' ),
        'is_js_dependant' => false,
        'child_module' => '',
        'type' => 'single',
        'is_built_in' => false,
		'group_atts' => array (
			array (
				'type'	=>	'tabs',
				'style'	=>	'style1',
				'group'	=>	array (
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
										'title' => __( 'Shape and Size', 'tatsu' ),
										'group' => array (
											'form_style',
											'input_style',
											'input_button_style',
											'input_height',
											'border_width',
											)
										),
									array (
										'type' => 'panel',
										'title' => __( 'Colors', 'tatsu' ),
										'group' => array (
											'input_color',
											'input_bg_color',
											'input_border_color',
											'bg_color',
											'color',
										)
									),
								)
							)
						),
					),
					array (
						'type'	=>	'tab',
						'title'	=>	__( 'Advanced' , 'tatsu'),
						'group'	=>	array (
								array(
								'type' => 'accordion' ,
								'active' => array(0, 1),
								'group' => array (
									array (
										'type' => 'panel',
										'title' => __( 'Animation', 'tatsu' ),
										'group' => array (
										)
									),
								)
							),
						)
					),
				)
			),
		),
        'atts' => array (
        	array (
        		'att_name' => 'form_style',
				'type' => 'button_group',
				'is_inline' => true,
        		'label' => __( 'Columns', 'oshine-modules' ),
        		'options' => array(
        			'style1' => 'One',
        			'style2' => 'Two'
        		),
        		'default' => 'style1',
        		'tooltip' => ''
        	), 
			array (
	            'att_name' => 'input_bg_color',
	            'type' => 'color',
	            'label' => __( 'Input Background Color', 'oshine-modules' ),
	            'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} input[type="text"], .tatsu-{UUID} textarea' => array(
						'property' => 'background-color',
					),
				),
            ),
			array (
	            'att_name' => 'input_color',
	            'type' => 'color',
	            'label' => __( 'Input Text Color', 'oshine-modules' ),
	            'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} input[type="text"], .tatsu-{UUID} textarea' => array(
						'property' => 'color',
					),
				),
            ),
        	array (
        		'att_name' => 'border_width',
				'type' => 'number',
				'is_inline' => true,
        		'options' => array(
        			'unit' => 'px',
        		),
        		'label' => __( 'Input Border Width', 'oshine-modules' ),
        		'default' => '',
				'tooltip' => '',
				// 'css' => true,
				// 'selectors' => array(
				// 	'.tatsu-{UUID} input[type="text"], .tatsu-{UUID} textarea' => array(
				// 		'property' => 'border-width',
				// 		'append' => 'px',
				// 	),
				// ),
        	),            
			array (
	            'att_name' => 'input_border_color',
	            'type' => 'color',
	            'label' => __( 'Input Border Color', 'oshine-modules' ),
	            'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} input[type="text"], .tatsu-{UUID} textarea' => array(
						'property' => 'border-color',
					),
				),
            ),
        	array (
        		'att_name' => 'input_height',
				'type' => 'number',
				'is_inline' => true,
        		'options' => array(
        			'unit' => 'px',
        		),        		
        		'label' => __( 'Input Box Height', 'oshine-modules' ),
        		'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} input[type="text"]' => array(
						'property' => 'height',
						'append' => 'px',
					),
				),
        	),
        	array (
        		'att_name' => 'input_style',
				'type' => 'button_group',
				'is_inline' => true,
        		'label' => __( 'Input Box Style', 'oshine-modules' ),
        		'options' => array(
        			'style1' => 'Boxed', 
        			'style2' => 'Underline'
        		),
        		'default' => 'style1',
        		'tooltip' => ''
        	),
        	array (
        		'att_name' => 'input_button_style',
				'type' => 'button_group',
				'is_inline' => true,
        		'label' => __( 'Button Style', 'oshine-modules' ),
        		'options' => array(
        			'small' => 'S', 
        			'medium' => 'M', 
        			'large' => 'L', 
        			'block' => 'Block'
        		),
        		'default' => 'medium',
        		'tooltip' => ''
        	),
			array (
	            'att_name' => 'bg_color',
	            'type' => 'color',
	            'label' => __( 'Button Background Color', 'oshine-modules' ),
	            'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .contact_submit' => array(
						'property' => 'background-color',
					),
				),
            ),
			array (
	            'att_name' => 'color',
	            'type' => 'color',
	            'label' => __( 'Button Text Color', 'oshine-modules' ),
	            'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .contact_submit' => array(
						'property' => 'color',
					),
				),
            ),                   		        		        	       	                   	
        ),
        'presets' => array(
        	'default' => array(
        		'title' => '',
        		'image' => '',
        		'preset' => array(
        			'border_width' => '2',
					'input_border_color' => 'rgba(0,0,0,0.2)',
					'input_style' => 'boxed',
					'bg_color' => array('id' => 'palette:0', 'color' => tatsu_get_color('tatsu_accent_color')),
					'color' => array('id' => 'palette:1', 'color' => tatsu_get_color('tatsu_accent_twin_color')),
        		),
        	)
        ), 
    );
	tatsu_register_module( 'contact_form', $controls );	
}