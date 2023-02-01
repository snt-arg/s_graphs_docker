<?php
/*****************************************************
		Portfolio Navigation
*****************************************************/
if (!function_exists('portfolio_navigation_module')) {
	function portfolio_navigation_module( $atts, $content, $tag ) {
		$atts = shortcode_atts( array (
			'url_type' => 'default',
			'link_url' => '',
			'style' => 'style1',
			'title_align' => 'center',
		    'nav_links_color' => '',
		    'animate' => 0,
			'animation_type'=>'fadeIn',
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
		$portfolio_home_page = get_post_meta( get_the_ID(), 'be_themes_portfolio_home_page', true); //Get link from Meta Options
		$portfolio_home_page = ($portfolio_home_page == '' ? $be_themes_data['portfolio_home_page'] : $portfolio_home_page) ; //Get link from Options panel link is not present in Meta Options
		$portfolio_catg_traversal = (1 == get_post_meta( get_the_ID(), 'be_themes_traverse_catg', true) ? true : false);
	    $output = "";
	    $style = ((!isset($style)) || empty($style)) ? 'style1' : $style;
	    $grid_icon_background = '';
	    //$nav_links_color = '';
        if ( is_singular( 'portfolio' ) ) {
            
            if(!empty($portfolio_home_page)) {
                $url = $portfolio_home_page;
            } else {
                $url = site_url();
            }
        } else {
            $url = be_get_posts_page_url();
        }

		$url = ( $url_type == 'custom' && ! empty( $link_url ) ) ? $link_url : $url;
		if((!is_page_template( 'gallery.php' )) || (!is_page_template( 'portfolio.php' ))) {
			if($style == 'style1') {
				$output .= '<div '.$css_id.' class="portfolio-nav-wrap style1-navigation oshine-module '.$animate.' align-'.$title_align.' '.$unique_class_name.' '.$visibility_classes.' '.$css_classes.'" '.$data_animations.'>';
				// ob_start();  
				// get_template_part( 'single', 'navigation' ); 
				// $output .= ob_get_contents();  
				// ob_end_clean();
				    $output .= '<div id="nav-below" class="single-page-nav">';
				    $output .=  get_next_post_link( '%link', '<i class="font-icon icon-arrow_left" title="%title"></i>' , $portfolio_catg_traversal , '' , 'portfolio_categories');				    
				    $output .= '<a href="'.$url.'">
				    				<div class="home-grid-icon"><span'.$grid_icon_background.'></span><span'.$grid_icon_background.'></span><span'.$grid_icon_background.'></span><span'.$grid_icon_background.'></span><span'.$grid_icon_background.'></span><span'.$grid_icon_background.'></span></div>
				    			</a>';
				    $output .= get_previous_post_link( '%link', '<i class="font-icon icon-arrow_right" title="%title"></i>' , $portfolio_catg_traversal , '' , 'portfolio_categories' );
				    $output .= '</div>';
					$output .= $custom_style_tag;
				$output .= '</div>';
			} else {
				$output .= '<div '.$css_id.' class="portfolio-nav-wrap oshine-module '.$animate.' '.$unique_class_name.' '.$visibility_classes.' '.$css_classes.'" '.$data_animations.'>';
	    		$output .= '<div id="nav-below" class="single-page-nav style2-navigation">';
	    		$next_post = get_previous_post($portfolio_catg_traversal, ' ', 'portfolio_categories');
				$prev_post = get_next_post($portfolio_catg_traversal, ' ', 'portfolio_categories');
				if($prev_post) {
					$output .= '<a href="'.get_permalink($prev_post->ID).'" title="'.str_replace('"', '\'', $prev_post->post_title).'" class="previous-post-link" >
									<i class="font-icon icon-arrow-left7"></i>
									<h6>'.str_replace('"', '\'', $prev_post->post_title).'</h6>
								</a>';
				}
	        	$output .= '<a href="'.$url.'" class="portfolio-url">
	        					<div class="home-grid-icon">
	        						<span'.$grid_icon_background.'></span><span'.$grid_icon_background.'></span><span'.$grid_icon_background.'></span><span'.$grid_icon_background.'></span><span'.$grid_icon_background.'></span><span'.$grid_icon_background.'></span>
	        					</div>
	        				</a>';
	        	if($next_post) {
	        		$output .= '<a href="'.get_permalink($next_post->ID).'" title="'.str_replace('"', '\'', $next_post->post_title).'" class="next-post-link" >
	        						<h6>'.str_replace('"', '\'', $next_post->post_title).'</h6>
	        						<i class="font-icon icon-arrow-left7"></i>
	        					</a>';
	        	}
				$output .= '</div>';
				$output .= $custom_style_tag;
	    		$output .= '</div>';
			}
		}
	    return $output;
	}
	add_shortcode( 'portfolio_navigation_module', 'portfolio_navigation_module' );
}

add_action( 'tatsu_register_modules', 'oshine_register_portfolio_navigation_module' );
function oshine_register_portfolio_navigation_module() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#portfolio_navigation',
	        'title' => __( 'Portfolio Navigation', 'oshine-modules' ),
	        'is_js_dependant' => false,
	        'type' => 'single',
	        'is_built_in' => false,
			'group_atts' => array (
				array (
					'type'	=>	'tabs',
					'style'	=>	'style1',
					'group'	=>	array (
						array(
							'type'	=>	'tab',
							'title'	=>	esc_html__('Content', 'tatsu'),
							'group'	=>	array(
								'url_type',
								'link_url',
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
											'title' => __( 'Shape and size', 'tatsu' ),
											'group' => array (
												'style',
												'title_align',
											)
										),
										array (
											'type' => 'panel',
											'title' => __( 'Colors', 'tatsu' ),
											'group' => array (
												'nav_links_color',
											)
										)
									)
								),
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
	        		'att_name' => 'url_type',
					'type' => 'button_group',
					'is_inline' => true,
	        		'label' => __( 'Type', 'oshine-modules' ),
					'options'=> array(
						'default' => __( 'Default URL', 'oshine-modules' ), 
						'custom' => __( 'Custom URL', 'oshine-modules' )
					),
					'default'=> 'default',
	        		'tooltip' => ''
	        	),
				array(
					'att_name' => 'link_url',
					'type' => 'text',
					'is_inline' => false,
					'options' => array(
						'placeholder' => 'https://example.com',
					),
					'label' => esc_html__('Custom Home URL', 'oshine-modules'),
					'default' => '',
					'tooltip' => '',
					'visible' => array('url_type', '=', 'custom'),
				),
	        	array (
	        		'att_name' => 'style',
					'type' => 'button_group',
					'is_inline' => true,
	        		'label' => __( 'Style', 'oshine-modules' ),
					'options'=> array(
						'style1' => 'Style 1', 
						'style2' => 'Style 2'
					),
					'default'=> 'style1',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'title_align',
					'type' => 'button_group',
					'is_inline' => true,
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
					'att_name' => 'nav_links_color',
					'type' => 'color',
					'label' => __( 'Color', 'oshine-modules' ),
					'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .home-grid-icon span' => array(
							'property' => 'background',
						),
						'.tatsu-{UUID} h6' => array(
							'property' => 'color',
							'when' => array('style', '!=', 'style1'),
						),
						'.tatsu-{UUID}.portfolio-nav-wrap' => array(
							'property' => 'color',
						),
					),
	            ),
	        ),
	    );
	tatsu_register_module( 'portfolio_navigation_module', $controls );
}