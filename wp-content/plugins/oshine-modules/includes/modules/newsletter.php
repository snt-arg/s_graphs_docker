<?php 
if (!function_exists('oshine_newsletter')) {
	function oshine_newsletter( $atts, $content, $tag ) {
			$atts = shortcode_atts( array (
				'api_key' => '',
				'id' => '',
				'width' => '50',
				'alignment' => 'left',			
				'button_text'=>'Submit',
				'bg_color'=> '',
				'hover_bg_color'=> '',
				'color'=> '',
				'hover_color'=> '',
				'border_width' => 0,			
				'border_color'=> '',
				'hover_border_color'=> '',
		        'animate' => 0,
				'animation_type'=>'fadeIn',
				'key' => be_uniqid_base36(true),
			), $atts, $tag );
			
			extract($atts);
			$custom_style_tag = be_generate_css_from_atts( $atts, $tag, $atts['key'] );
			$custom_class_name = ' tatsu-'.$atts['key'];
			$css_id = be_get_id_from_atts( $atts );
			$visibility_classes = be_get_visibility_classes_from_atts( $atts );
			$animate = ( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) ? ' tatsu-animate' : '';  		
			$data_animations = be_get_animation_data_atts( $atts );

			global $be_themes_data;
	    	$api_key = ( isset( $api_key ) && !empty( $api_key ) ) ? $api_key : '' ;
	    	$width  = (isset($width ) && !empty( $width ) ) ? $width : '100';
	    	$alignment  = (isset($alignment ) && !empty( $alignment ) ) ? $alignment : 'left';	
			
			$border_width = (!isset($border_width) || empty($border_width) || $border_width == '0') ? 0 : $border_width;
			$border_style = $border_width != 0 ? 'border-style: solid;' : '' ;

	    	$id = ( isset( $id ) && !empty( $id ) ) ? $id : '' ;
			$privacy_policy_link = ( function_exists( 'get_privacy_policy_url' ) ) ? get_privacy_policy_url() : '#';
			$output = '';
	    	$output .= '<div '.$css_id.' class="oshine-mc-wrap '.$custom_class_name.' oshine-module align-'.$alignment.' '.$animate.' '.$visibility_classes.' '.$css_classes.' clearfix" '.$data_animations.' data-consent-error = "'.__('Please check the consent box, in order for us to process this form', 'oshine-modules').'">';
	    	$output .= '<form method="POST" class="oshine-mc-form">';
	    	$output .= '<div class="clearfix">';
	    	$output .= '<input type="hidden" name="api_key" value="'.$api_key.'" /><input type="hidden" name="list_id" value="'.$id.'" />';
			$output .= '<fieldset class="contact_fieldset oshine-mc-field" style="width: '.$width.'%;"><input type="text" name="email" placeholder="'.__('Email','oshine-module').'" /><div class="clear"></div></fieldset>';
			if( !empty( $be_themes_data['consent_checkboxes'] ) ) {
				$output .= '<fieldset class="field_consent contact_consent">	<input type="checkbox" name="contact_consent" class="consent-checkbox" placeholder="'.__('Subject','oshine-modules').'" '.$border_width.' /><span class="consent-message">'.sprintf( __('By checking this box, you consent and confirm your subscription to our newsletter. For more info check our <a href="%s" target="_blank">privacy policy</a> where you will get more info on where, how and why we store your data.', 'oshine-modules'), esc_url( $privacy_policy_link) ).'</span></fieldset>';
			}
			$output .= '<fieldset class="contact_fieldset oshine-mc-submit-wrap"><input type="submit" name="submit" value="'.$button_text.'" class="oshine-mc-submit oshine-module tatsu-button" style= "'.$border_style.'" /><div class="subscribe_loader"><div class="tatsu-icon loader-style4-wrap loader-icon"></div></div></fieldset>';
			$output .= '</div>';
			$output .= '<div class="subscribe_status tatsu-notification"></div>';
			$output .= '</form>';
			$output .= $custom_style_tag;
	        $output .= '</div>';
	        return $output;
	}
	add_shortcode( 'newsletter', 'oshine_newsletter' );
}


add_action( 'tatsu_register_modules', 'oshine_register_newsletter');
function oshine_register_newsletter() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#newsletter',
	        'title' => __( 'Newsletter', 'oshine-modules' ),
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
							'title'	=>	__( 'Content' , 'tatsu'),
							'group'	=>	array (
								'api_key',
								'id',
								'button_text',
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
											'title' => __( 'Shape and Size', 'tatsu' ),
											'group' => array (
												'width',
												'alignment',
												'border_width',
												)
											),
										array (
											'type' => 'panel',
											'title' => __( 'Button Colors', 'tatsu' ),
											'group' => array (
													array (
													'type'	=>	'tabs',
													'style'	=>	'style1',
													'group'	=>	array (
														array (
															'type'	=>	'tab',
															'title'	=>	__( 'Normal' , 'tatsu'),
															'group'	=>	array(
																'bg_color',
																'color',
																'border_color'
															)
														),
														array (
															'type'	=>	'tab',
															'title'	=>	__( 'Hover' , 'tatsu'),
															'group'	=>	array(
																'hover_bg_color',
																'hover_color',
																'hover_border_color',
															)
														),
													)
												),
											)
										)
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
	        		'att_name' => 'api_key',
	        		'type' => 'text',
	        		'label' => __( 'Mailchimp.com Api key', 'oshine-modules' ),
	        		'default' => '',
					'tooltip' => '',
					'is_inline' => false,
	        	),
	        	array (
	        		'att_name' => 'id',
	        		'type' => 'text',
	        		'label' => __( 'Mailchimp.com List ID', 'oshine-modules' ),
	        		'default' => '',
					'tooltip' => '',
					'is_inline' => false,
	        	),
	        	array (
	        		'att_name' => 'width',
	        		'type' => 'slider',
	        		'label' => __( 'Width', 'oshine-modules' ),
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '100',
	        			'step' => '1',
	        			'unit' => '%',
	        		),	
	        		'default' => '100',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'alignment',
					'type' => 'button_group',
					'is_inline' => true,
	        		'label' => __( 'Alignment', 'oshine-modules' ),
	        		'options' => array(
	        			'left' => 'Left',
	        			'center' => 'Center',
	        			'right' => 'Right'
	        		),
	        		'default' => 'left',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'button_text',
	        		'type' => 'text',
	        		'label' => __( 'Button Text', 'oshine-modules' ),
	        		'default' => __( 'Submit', 'oshine-modules' ),
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'bg_color',
		            'type' => 'color',
		            'label' => __( 'Background', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .oshine-mc-submit' =>  array(
							'property' => 'background'
						),
					),
	            ),
	        	array (
		            'att_name' => 'hover_bg_color',
		            'type' => 'color',
		            'label' => __( 'Hover Background', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .oshine-mc-submit:hover' =>  array(
							'property' => 'background'
						),
					),
	            ),
	        	array (
		            'att_name' => 'color',
		            'type' => 'color',
		            'label' => __( 'Text', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .oshine-mc-submit' =>  array(
							'property' => 'color'
						),
					),
	            ),
	        	array (
		            'att_name' => 'hover_color',
		            'type' => 'color',
		            'label' => __( 'Hover Text', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .oshine-mc-submit:hover' =>  array(
							'property' => 'color'
						),
					),
	            ),
	            array (
	        		'att_name' => 'border_width',
					'type' => 'number',
					'is_inline' => true,
	        		'label' => __( 'Button Border Width', 'oshine-modules' ),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .oshine-mc-submit' =>  array(
							'property' => 'border-width',
							'append' => 'px',
						),
					),
	        	),
	        	array (
		            'att_name' => 'border_color',
		            'type' => 'color',
		            'label' => __( 'Border', 'oshine-modules' ),
		            'default' => '',
		            'tooltip' => '',
					'visible' => array( 'border_width', '!=', '' ),
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .oshine-mc-submit' =>  array(
							'property' => 'border-color'
						),
					),
	            ),
	        	array (
		            'att_name' => 'hover_border_color',
		            'type' => 'color',
		            'label' => __( 'Hover Border', 'oshine-modules' ),
		            'default' => '',
		            'tooltip' => '',
					'visible' => array( 'border_width', '!=', '' ),
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .oshine-mc-submit:hover' =>  array(
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
	        			'bg_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
	        			'color' => array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'newsletter', $controls );
}