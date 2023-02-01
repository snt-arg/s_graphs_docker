<?php
/**************************************
			TWEET
**************************************/
if (!function_exists('be_tweet')) {
	function be_tweet( $atts, $content ) {
		$atts = shortcode_atts( array (
			'account_name' => '',
			'count' => 5,
			'color' => '',
			'content_size' => '12',
			'tweet_bird_color' => '',
			'alignment' => 'center',
			'slide_show' => '0',
			'slide_show_speed' => 4000,
			'pagination' => 0,
			'animate' => 0,
			'animation_type' =>'slide-up',
			'key' => be_uniqid_base36(true),
		),$atts );		


		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tweets', $key );
		$unique_class_name = 'tatsu-'.$key;


		$animate = ( isset( $animate ) && 1 == $animate ) ? 'be-animate' : '';
		$alignment = (isset( $alignment ) && !empty( $alignment )) ? $alignment : 'center';
		$pagination = (empty($pagination) || (!empty($pagination) && $pagination == 0)) ? '0' : '1' ; 
	    $slide_show = ( !empty( $slide_show ) ) ? 1 : 0 ;
		$slide_show_speed = ( !empty( $slide_show_speed ) ) ? $slide_show_speed : 4000 ;

		$output = '';
		if($account_name) {
			$query = 'count='.$count.'&include_entities=true&include_rts=true&screen_name='.$account_name;
			$tweets = be_get_tweets( $query );
			if( $tweets ) {
				$output .= '<div class="tweet-slides oshine-module ' .$animate.' '.$unique_class_name.'" data-animation="'.$animation_type.'" ><ul class="twitter_module slides '.$alignment.'-content" data-slide-show="'.$slide_show.'" data-slide-show-speed="'.$slide_show_speed.'" data-pagination="'.$pagination.'">';
				foreach($tweets as $tweet) {
					$output .= '<li class="tweet_list"><div class="testimonial_slide_inner"><i class="font-icon icon-twitter" ></i><span class="tweet-content status" >';
					$output .= be_tweet_format($tweet);
					$output .= '</div></li>';
				}
				$output .= '</ul>'.$custom_style_tag.'</div>';
			}
		}
		return $output;
	}
	add_shortcode( 'tweets', 'be_tweet' );
}

add_action( 'tatsu_register_modules', 'oshine_register_tweets');
function oshine_register_tweets() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#tweets',
	        'title' => __( 'Tweets', 'oshine-modules' ),
	        'is_js_dependant' => true,
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
								'account_name',
								'count',
								'pagination',
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
												'content_size',
												'alignment',
												)
											),
										array (
											'type' => 'panel',
											'title' => __( 'Colors', 'tatsu' ),
											'group' => array (
												'color',
												'tweet_bird_color',
											)
										),
										'slide_show',
										'slide_show_speed',
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
												'animate',
												'animation_type',
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
	        		'att_name' => 'account_name',
	        		'type' => 'text',
	        		'label' => __( 'Twitter Account Name', 'oshine-modules' ),
	        		'default' => '',
					'tooltip' => '',
					'is_inline' => false,
	        	),
	        	array (
	        		'att_name' => 'count',
	        		'type' => 'slider',
	        		'label' => __( 'Number of tweets', 'oshine-modules' ),
	        		'options' => array(
	        			'max' => '10',
	        			'min' => '1',
	        			'step' => '1',
	        		),
	        		'default' => '3',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'content_size',
	        		'type' => 'number',
	        		'label' => __( 'Tweet Font Size', 'oshine-modules' ),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '12',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tweet-content' => array(
							'property' => 'font-size',
							'append' => 'px',
						),
					),
	        	),
				array (
		            'att_name' => 'tweet_bird_color',
					'type' => 'color',
					'options' => array(
						'gradient' => true,
					),
		            'label' => __( 'Tweet Bird Icon Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .icon-twitter' => array(
							'property' => 'color',
						),
					),
	            ),
				array (
		            'att_name' => 'color',
					'type' => 'color',
					'options' => array(
						'gradient' => true,
					),
		            'label' => __( 'Text Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tweet-content' => array(
							'property' => 'color',
						),
					),
	            ),
	        	array (
	        		'att_name' => 'alignment',
	        		'type' => 'button_group',
	        		'label' => __( 'Alignment', 'oshine-modules' ),
	        		'options' => array(
	        			'left' => 'Left',
	        			'center' => 'Center',
	        			'right' => 'Right'
	        		),
	        		'default' => 'center',
	        		'tooltip' => ''
	        	),
	            array (
	        		'att_name' => 'slide_show',
	        		'type' => 'switch',
	        		'label' => __( 'Enable Slide Show', 'oshine-modules' ),
	        		'default' => '0',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'slide_show_speed',
	        		'type' => 'slider',
	        		'label' => __( 'Slide Show Speed', 'oshine-modules' ),
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '10000',
	        			'step' => '1000',
	        			'unit' => 'ms',
	        		),		        		
	        		'default' => '4000',
					'tooltip' => '',
					'visible' => array('slide_show', '=', '1'),
	        	),	        	
	            array (
	              	'att_name' => 'pagination',
	              	'type' => 'switch',
	              	'label' => __( 'Enable Pagination', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
				array (
	              	'att_name' => 'animate',
	              	'type' => 'switch',
	              	'label' => __( 'Enable CSS Animation', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'animation_type',
	              	'type' => 'select',
	              	'label' => __( 'Animation Type', 'oshine-modules' ),
	              	'options' => tatsu_css_animations(),
					'visible' => array('animate' ,'=' , '1'),
	              	'default' => 'fadeIn',
	            ),        		        		        		            	            	        		        		        	
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'account_name' => 'envato',
	        			'content_size' => '20',
	        			'tweet_bird_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'tweets', $controls );
}