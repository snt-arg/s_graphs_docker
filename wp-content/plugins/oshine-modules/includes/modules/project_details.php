<?php
/**************************************
			PORTFOLIO DETAILS
**************************************/
if ( ! function_exists( 'be_project_details' ) ) {
	function be_project_details( $atts, $content, $tag ) {
		$atts = shortcode_atts( array (
			'style' => 'style1',
	        'alignment'=> 'left',
			'key' => be_uniqid_base36(true),
		),$atts, $tag );
		
		extract($atts);
	    global $be_themes_data;
	    $style = (!isset($style) || empty($style)) ? 'style1' : $style;
	    $alignment = (!isset($alignment) || empty($alignment) || 'style3' == $style ) ? 'left' : $alignment;	   
	    if($style == 'style2') {
	    	$alignment = 'initial';
		}
		
		$custom_style_tag = be_generate_css_from_atts( $atts, 'be_countdown', $atts['key'] );
		$custom_class_name = ' tatsu-'.$atts['key'];

		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );

		$data_animations = be_get_animation_data_atts( $atts );
		if( !empty( $animation_type ) && 'none' !== $animation_type ) {
            $css_classes .= ' tatsu-animate ';
        }


		global $post;
		$output = '';
		$post_type = get_post_type();
		if( $post_type != 'portfolio' ) {
			return '';
		} else {
			$output .= '<div '.$css_id.' class="portfolio-details '.$style.' oshine-module '.$custom_class_name.' '.$visibility_classes.' '.$css_classes.'" style="text-align: '.$alignment.'" '.$data_animations.'>';
			if((!is_page_template( 'gallery.php' )) || (!is_page_template( 'portfolio.php' ))) {
				if(get_post_meta($post->ID,'be_themes_portfolio_client_name',true)) {
					$output .= '<div class="gallery-side-heading-wrap portfolio-client-name clearfix"><h6 class="gallery-side-heading">'.__('Client', 'oshine-modules').'</h6>';
					$output .= '<p><span class="project_client">'.get_post_meta($post->ID, 'be_themes_portfolio_client_name', true).'</span></p></div>';
				}
				if(get_post_meta($post->ID,'be_themes_portfolio_project_date',true)) {
					$output .= '<div class="gallery-side-heading-wrap portfolio-project-date clearfix"><h6 class="gallery-side-heading">'.__('Project Date', 'oshine-modules').'</h6>';
					$output .= '<p><span class="project_client">'.get_post_meta($post->ID, 'be_themes_portfolio_project_date', true).'</span></p></div>';
				}
				if(get_be_themes_portfolio_category_list($post->ID, true)) {
					$output .= '<div class="gallery-side-heading-wrap portfolio-category clearfix"><div class="gallery-cat-list-wrap">';
					$output .= '<h6 class="gallery-side-heading">'.__('Category', 'oshine-modules').'</h6>';
					$output .= '<p>'.get_be_themes_portfolio_category_list($post->ID, true).'</p>';
					$output .= '</div></div>';
				}
			}
			$output .= '<div class="gallery-side-heading-wrap portfolio-share clearfix"><h6 class="gallery-side-heading">'.__('Share This', 'oshine-modules').'</h6>';
			$output .= '<p>';
			$output .= be_get_share_button(get_permalink($post->ID), get_the_title($post->ID) , $post->ID);
			$output .= '</p></div>';
			if(get_post_meta($post->ID,'be_themes_portfolio_visitsite_url',true)) {
				if(!isset($be_themes_data['portfolio_visit_site_style']) || empty($be_themes_data['portfolio_visit_site_style'])) {
					$be_themes_data['portfolio_visit_site_style'] = 'style1';
				}				

				$output .= '<a href="'.get_post_meta($post->ID,'be_themes_portfolio_visitsite_url',true).'" class="mediumbtn be-button view-project-link '.$be_themes_data['portfolio_visit_site_style'].'-button" target="_blank">'.__('View Project', 'oshine-modules').'</a>';
			}
			$output .= $custom_style_tag.'</div>';
			return $output;
		}

	}
	add_shortcode( 'project_details', 'be_project_details' );
}

add_filter( 'tatsu_project_details_shortcode_output_filter', 'oshine_project_details_tatsu_output' );
function oshine_project_details_tatsu_output( $tag ) {
	$output = '<div class="tatsu-module tatsu-notification tatsu-error">Portfolio Details Module - Preview Not Available, Please check the output in the front end</div>';
	return $output;
}




add_action( 'tatsu_register_modules', 'oshine_register_project_details');
function oshine_register_project_details() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#portfolio_details',
	        'title' => __( 'Portfolio Details', 'oshine-modules' ),
	        'is_js_dependant' => false,
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
											'title' => __( 'Shape and size', 'tatsu' ),
											'group' => array (
												'style',
												'title_align',
											)
										),
									)
								),
							)
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
	        		'att_name' => 'style',
	        		'type' => 'button_group',
	        		'label' => __( 'Style', 'oshine-modules' ),
					'options'=> array(
						'style1' => 'Style 1', 
						'style2' => 'Style 2',
						'style3' => 'Style 3'	 
					),
					'default'=> 'style1',
					'is_inline' => true,
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'title_align',
	        		'type' => 'button_group',
	        		'label' => __( 'Alignment', 'oshine-modules' ),
	        		'options' => array(
	        			'left' => 'Left',
	        			'center' => 'Center',
	        			'right' => 'Right'
	        		),
	        		'default' => 'left',
					'is_inline' => true,
	        		'tooltip' => '',
					'hidden'  => array ( 'style', '==', 'style3' )
	        	)
	        ),
	    );
	tatsu_register_module( 'project_details', $controls );
}