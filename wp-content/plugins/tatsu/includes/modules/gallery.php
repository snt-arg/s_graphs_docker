<?php
/*****************************************************
		GALLERY
*****************************************************/
if (!function_exists('tatsu_gallery')) {
	function tatsu_gallery( $atts, $content, $tag ) {
		global $be_themes_data;
		$atts = shortcode_atts( array (
			'gutter_style' => 'style1',
			'items_per_load' => '',
			'gutter_width' => 40,
			'masonry'=> '0',
			'initial_load_style' => 'none',
			'hover_show_title' => 'icon',
			'disable_hover_icon' => '0',
			'hover_content_color' => '',
			'image_effect' => 'none',
			'overlay_color' => '',
			'overlay_opacity' => '85',
			'placeholder_color' => '',
            'image_source' => 'selected',
            'two_col_mobile' => '0',
			'images' => '',
			'account_name' => 'themeforest',
			'count' => 10,
			'lazy_load' => 0,
			'delay_load' => 0,
			'ids'	=> '',
			'columns' => '3',
			'margin' => '',
			'link' => 'none',
			'key' => be_uniqid_base36(true),
		),$atts, $tag );		

		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key );
		$unique_class_name = 'tatsu-'.$key;
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );
		$animate = ( 'none' !== $animation_type ) ? 'tatsu-animate' : '' ; 		
		$data_animations = be_get_animation_data_atts( $atts );
		$lazy_load = (isset($lazy_load) && !empty($lazy_load) && intval($lazy_load) != 0) ? $lazy_load : 0;
		$delay_load = (isset($delay_load) && !empty($delay_load) && intval($delay_load) != 0) ? $delay_load : 0;
		$enable_data_src = ( !( wp_doing_ajax() || ( defined('REST_REQUEST') && REST_REQUEST ) || isset($_GET['tatsu']) ) && $lazy_load ) ? 1 : 0;
		$lazy_load_class = ( !empty( $lazy_load ) && $enable_data_src ) ? 'be-lazy-load' : '';
		$aspect_ratio = get_theme_mod('gallery_aspect_ratio', '1.6');
		$gutter_width = ( isset( $gutter_width ) ) ? intval( $gutter_width ) : intval(40);
		$masonry_enable = ((!isset($masonry)) || empty($masonry)) ? 'masonry_disable' : 'masonry_enable';
		$columns = ((!isset($columns)) || empty($columns)) ? 0 : $columns;
		$link = ((!isset($link)) || empty($link)) ? '' : $link;
		$items_per_load = ((!isset($items_per_load)) || empty($items_per_load)) ? 0 : $items_per_load;

		$images = ((!isset($images)) || empty($images)) ? '' : $images;

        $columns_as_number = $columns;
		//Conditions if default WP gallery is used
		if($columns != 0 || (!empty($ids) && $images == '') ) {
			if($columns > 5){
				$columns = 'three';
			}elseif($columns == 1){
				$columns = 'one';
			}elseif($columns == 2){
				$columns = 'two';
			}elseif($columns == 3){
				$columns = 'three';
			}elseif($columns == 4){
				$columns = 'four';
			}elseif($columns == 5){
				$columns = 'five';
			}
		}

		//Condition if default WP gallery is used
		$images = (isset($ids) && $images == '') ? $ids : $images;
		$masonry = ((!isset($masonry)) || empty($masonry)) ? 0 : $masonry;
		$initial_load_style = ((!isset($initial_load_style)) || empty($initial_load_style)) ? 'none' : $initial_load_style;
        
        if( '0' != $delay_load && 'none' == $initial_load_style ) {
			$initial_load_style = 'fadeIn';
		}
		$hover_style = 'style1-hover';
	
		$image_effect = ((!isset($image_effect)) || empty($image_effect)) ? 'none' : $image_effect;
		$image_source = ((!isset($image_source)) || empty($image_source)) ? 'selected' : $image_source;
		$account_name = ((!isset($account_name)) || empty($account_name)) ? 'themeforest' : $account_name;
		$count = ((!isset($count)) || empty($count)) ? 10 : $count;

		$source = array (
			'source' => $image_source,
			'account_name' => $account_name, 
			'count' => $count,
			'col' => $columns,
			'masonry' => $masonry
		);

		$paged  = '0';
		$images_offset = '0';

		$images_arr = $images;	
		$data_total_items = count(explode(',',$images_arr)) - $items_per_load;
        $output = '';
        if( $items_per_load ){
            $images_subset = array_slice(explode(',', $images), $images_offset, $items_per_load);
        }else{
            $images_subset = explode(',', $images);
        }
        $images = tatsu_get_gallery_image_from_source($source, implode(",",$images_subset));
		
		if($images && is_array($images) && !isset($images['error']) && empty($images['error'])) {
			$output .= '<div '.$css_id.' class="tatsu-gallery-wrap tatsu-gallery-module tatsu-module '.$disable_hover_icon.' '.$unique_class_name.' '.$visibility_classes.' '.$css_classes.' '.$animate.'" '.$data_animations.'>';
            $output .= '<div class="gallery   '. $hover_style .' ' . ( 0 != $masonry ? 'masonry_enable ' : '' ) . '"  >';
            
			$output .= '<div class="gallery-container be-grid be-row be-cols-'.$columns_as_number.' clickable clearfix  " data-aspect-ratio="1.6" data-animation-target = ".gallery-thumb-img-wrap" data-cols="'.$columns_as_number.'" data-scroll-reveal = "'.$delay_load .'" data-animation = "'.$initial_load_style.'" data-gutter="'.$gutter_width.'" ' . ( empty( $masonry ) ? 'data-layout="metro"' : 'data-layout = "masonry"' ) . ' ' . ( !empty( $two_col_mobile ) ? 'data-mobile-cols="2"' : '' ) . '>';

			$masonry_enable = ((!isset($masonry)) || empty($masonry)) ? 'masonry_disable' : 'masonry_enable';
			if( 'instagram' == $image_source ) {
				$aspect_ratio = 1;
			}
			if(!empty($images)){
				foreach($images as $image) {
					$image_atts = array();
					$attachment_info = array();
					if( $image['id'] ){
						$image_atts = be_get_gallery_image($image['id'], $columns, $masonry);
						$attachment_info = be_wp_get_attachment( $image['id'] );
						if( !$attachment_info || empty( $attachment_info ) ) {
							continue;
						}
					}
					$image_thumbnail_details = wp_get_attachment_image_src( $image['id'], 'thumbnail' );
					$output_hover_content = '';
					if($hover_show_title == '1'){
						$output_hover_content = '<div class="thumb-title" >'.$image['caption'].'</div>';
					}
					$masonry_aspect_ratio = 1;
					if( $masonry && 'flickr' !== $image_source ){
						if( 'instagram' == $image_source ) {
							$placeholder_padding = 100;
						}else{
							$masonry_aspect_ratio = round( $attachment_info[ 'width' ]/$attachment_info[ 'height' ], 2 );
							$placeholder_padding = ( $attachment_info[ 'height' ]/$attachment_info[ 'width' ] ) * 100;
						}
					}else{
						$placeholder_padding = (1/$aspect_ratio)*100;
					}
					
					if( 'flickr' == $image_source ) {
						$masonry_aspect_ratio = round( $image[ 'width' ]/$image[ 'height' ], 2 );
						$placeholder_padding = ( $image[ 'height' ]/$image[ 'width' ] ) * 100;
					}

					$is_double_height = empty($masonry) && ("1" == get_post_meta($image['id'], 'be_themes_height_wide', true ));
					$is_double_width = empty($masonry) && ("1" == get_post_meta($image['id'], 'be_themes_width_wide', true ));
			
					$double_prop_class = (   $is_double_width &&  $is_double_height ? 'be-double-width-height-cell' :  ($is_double_width ? 'be-double-width-cell' : ($is_double_height ? "be-double-height-cell" : '') ) );
		
					$output .= '<div class="gallery-cell be-col be-hoverlay '. $double_prop_class .' '. ( !empty( $image_atts ) ? $image_atts['class'].' '.$image_atts['alt_class'] : '' ).' '.$hover_style.' " >';
					$output .= '<div class="gallery-cell-inner"">';
						
					$gdpr_lightbox_content = '';

					$lightbox_image_class = 'mfp-image';
					$lightbox_video_class = 'mfp-iframe';
					$lightbox_html_class = 'mfp-popup';

					$lightbox_atts = apply_filters('tatsu_gallery_lightbox_atts', $image, $key );
					$data_atts = array();
					$html_att = array();
					if( !empty( $lightbox_atts['class'] ) ){
						
						$lightbox_image_class = $lightbox_atts['class']['image'];
						$lightbox_video_class = !empty( $lightbox_atts['class']['video'] ) ? $lightbox_atts['class']['video'] : $lightbox_atts['class']['image'];
						$lightbox_html_class  = (!empty( $lightbox_atts['class']['html'] ) ? $lightbox_atts['class']['html'] : $lightbox_atts['class']['image']); 

						$data_atts = $lightbox_atts['data'];
						$html_att = !empty( $lightbox_atts['html_att'] ) ? $lightbox_atts['html_att'] : array();
					}
					if( $image['has_video'] ){
						$gdpr_atts = '{}';
						$gdpr_concern_selector = '';
						$href = $image['full_image_url'];
						$gdpr_data_atts = '';
						$gdpr_key = be_uniqid_base36(true);
						if( function_exists( 'be_gdpr_privacy_ok' ) ){
							$video_details = be_get_video_details($image['full_image_url'],'large');
							if( !empty($_COOKIE) ){
								if( !be_gdpr_privacy_ok($video_details['source'])  ){

									$href = '#gdpr-alt-lightbox-'.$gdpr_key;
									$lightbox_video_class = $lightbox_html_class;

									foreach( $html_att as $att_name => $value ){
										$gdpr_data_atts .= $att_name .'="'. $value .'" '; 
									}

								}
							}else{

								$gdpr_atts = array(
									'concern' => $video_details[ 'source' ],
									'add' => array( 
										'class' => array( $lightbox_html_class ),
										'atts'	=> array_merge (
											array( 'href' => '#gdpr-alt-lightbox-'.$gdpr_key ),
											$html_att
										),
									),
									'remove' => array( 
										'class' => array( $lightbox_video_class  )
									)
								);
								$gdpr_concern_selector = 'be-gdpr-consent-required';
								$gdpr_atts = json_encode( $gdpr_atts );
							}
						}

						$output .= '<a href="'.$href.'" '. join( ' ', $data_atts ) .' class="thumb-anchor  '. $lightbox_video_class . ' ' .$gdpr_concern_selector.' " '. $gdpr_data_atts .' data-gdpr-atts='.$gdpr_atts.' title="'.$image['description'].'">';

						$gdpr_lightbox_content .= be_gdpr_lightbox_for_video($gdpr_key,$video_details["thumb_url"],$video_details['source']);

					} else {
						$output .= '<a data-thumb = "' . (empty($image_thumbnail_details)?'':$image_thumbnail_details[0]) . '" href="'.$image['full_image_url'].'"  class="thumb-anchor '. $lightbox_image_class .'  " '. join( ' ',$data_atts ) .' title="'.$image['description'].'">';
					}
					
					//End
					$output .= '<div class="thumb-wrap"><div style = "padding-bottom : '. $placeholder_padding .'%;'.'" class="gallery-thumb-img-wrap be-grid-placeholder '.$image_effect.'-effect" ' . ( ( "masonry_enable" == $masonry_enable || 'flickr' == $image_source ) ? ( 'data-aspect-ratio="'.$masonry_aspect_ratio.'"' )  : '' ) . ' ><img class="'.$lazy_load_class.'"  '. ( $enable_data_src ? 'data-src="'.$image['thumbnail'] : 'src="'.$image['thumbnail'] ) .'" alt="'.( !empty( $attachment_info['alt'] ) ? $attachment_info['alt'] : ''  ).'" /></div></div>';
					$output .= '<div class="thumb-overlay"><div class="thumb-bg">';
					$output .= '<div class="thumb-title-wrap display-table-cell vertical-align-middle align-center fadeIn animated">';
					$output .= $output_hover_content;
					$output .= '</div>';
					$output .= '</div></div>'; //End Thumb Bg & Thumb Overlay
					$output .= '</a>'; //End Thumb Wrap
					$output .= $gdpr_lightbox_content;
					$output .= '</div>'; //End Element Inner
					$output .= '</div>'; //End Element
				}
				$output .= '</div>'; //end gallery-container
				$output .= '</div>'; //end galery
				$output .= $custom_style_tag . '</div>'; //end gallery-wrap
			}
		} else {
			if(is_array($images) && !empty($images['error'])) {
				$output .= '<p class="element-empty-message">'.$images['error'].'</p>';
			} else {
				$output .= '<p class="element-empty-message"><b>'.esc_html__('Gallery Notice : ', 'tatsu').'</b>'.esc_html__('Images have either not been selected or couldn\'t be found', 'tatsu').'</p>';
			}
		}
		return $output;
	}

	function tatsu_gallery_prevent_autop( $content_filter, $tag ) {
        if( 'tatsu_gallery' === $tag || 'gallery' === $tag ) {
            $content_filter = false;
        }
        return $content_filter;
    }
    add_filter( 'tatsu_shortcode_output_content_filter', 'tatsu_gallery_prevent_autop', 10, 2 );

}

add_action('tatsu_register_modules', 'tatsu_register_gallery', 8);
function tatsu_register_gallery()
{
	$controls = array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#gallery',
		'title' => esc_html__('Gallery', 'tatsu'),
		'is_js_dependant' => true,
		'type' => 'single',
		'should_autop' => false,
		'is_built_in' => false,
		'group_atts' => array(
			array(
				'type'		=> 'tabs',
				'style'		=> 'style1',
				'group'		=> array(
					//Tab1
					array(
						'type' => 'tab',
						'title' => esc_html__('Content', 'tatsu'),
						'group'	=> array(
							'image_source',
							'ids',
							'items_per_load',
							'account_name',
							'count',
							'hover_show_title',
						),
					),
					//Tab2
					array(
						'type' => 'tab',
						'title' => esc_html__('Style', 'tatsu'),
						'group'	=> array(
							array( //Styling Details
								'type' => 'accordion',
								'active' => 'all',
								'group' => array(
									array(
										'type' => 'panel',
										'title' => esc_html__('Layout', 'tatsu'),
										'group' => array(
                                            'columns',
                                            'two_col_mobile',
											'gutter_style',
											'gutter_width',
											'masonry',
										)
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Loading', 'tatsu'),
										'group' => array(
											'lazy_load',
											'delay_load',
											'placeholder_color',
											'initial_load_style'
										)
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Colors', 'tatsu'),
										'group' => array(
											'overlay_color',
											'hover_content_color',
										)
									),
								),
							),
						),
					),
					//Tab3
					array(
						'type' => 'tab',
						'title' => esc_html__('Advanced', 'tatsu'),
						'group'	=> array(

						),
					),
				),
			),
		),
		'atts' => array(
			array(
				'att_name' => 'image_source',
				'type' => 'select',
				'label' => esc_html__('Image Source', 'tatsu'),

				'options' => array(
					'selected' => 'Selected Images',
					'instagram' => 'Instagram',
					'flickr' => 'Flickr',
				),
				'default' => 'selected',
				'tooltip' => ''
			),
			array(
				'att_name' => 'ids',
				'type' => 'multi_image_picker',
				'label' => esc_html__('Upload / Select Gallery Images', 'tatsu'),
				'tooltip' => '',
				'visible' => array('image_source', '=', 'selected'),
			),
			array(
				'att_name' => 'account_name',
				'type' => 'text',
				'label' => esc_html__('Account Name', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'hidden' => array('image_source', '=', 'selected'),
			),
			array(
				'att_name' => 'count',
				'type' => 'slider',
				'label' => esc_html__('Images Count', 'tatsu'),
				'options' => array(
					'min' => '1',
					'max' => '20',
					'step' => '1',
				),
				'default' => '10',
				'tooltip' => '',
				'hidden' => array('image_source', '=', 'selected'),
			),
			array(
				'att_name' => 'columns',
				'type' => 'select',
				'label' => esc_html__('Columns', 'tatsu'),
				'options' => array(
					'1' => 'One',
					'2' => 'Two',
					'3' => 'Three',
					'4' => 'Four',
					'5' => 'Five',
				),
				'default' => '3',
				'tooltip' => ''
            ),
            array (
                'att_name'  => 'two_col_mobile',
                'label' => esc_html__( '2 Column Grid in Mobile', 'tatsu' ),
                'type'  => 'switch',
                'default' => '0',
                'tooltip' => '',  
            ),
			array(
				'att_name' => 'lazy_load',
				'type' => 'switch',
				'label' => esc_html__('Lazy Load Images', 'tatsu'),
				'default' => 0,
				'tooltip' => 'Lazy Load'
			),
			array(
				'att_name' => 'delay_load',
				'type' => 'switch',
				'label' => esc_html__('Reveal images only on scroll', 'tatsu'),
				'default' => 1,
				'tooltip' => 'Delay Load Grid'
			),
			array(
				'att_name' => 'placeholder_color',
				'type' => 'color',
				'label' => esc_html__('Placeholder Background', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-gallery-module .gallery-thumb-img-wrap' => array(
						'property' => 'background-color',
					),
				),
			),
			array(
				'att_name' => 'items_per_load',
				'type' => 'text',
				'label' => esc_html__('Items To Load', 'tatsu'),
				'default' => '9',
				'tooltip' => '',
				'visible' => array('image_source', '=', 'selected'),
			),
			array(
				'att_name' => 'gutter_style',
				'type' => 'select',
				'label' => esc_html__('Gutter Style', 'tatsu'),
				'options' => array(
					'style1' => 'With Margin',
					'style2' => 'Without Margin',
				),
				'default' => 'style2',
				'tooltip' => ''
			),
			array(
				'att_name' => 'gutter_width',
				'type' => 'number',
				'is_inline' => true,
				'label' => esc_html__('Gutter Width', 'tatsu'),
				'options' => array(
					'unit' => 'px',
				),
				'default' => '40',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .gallery-container' => array(
						'property' => 'margin',
						'prepend' => '0 -',
						'append' => 'px',
						'operation' => array('/', 2),
						'when' => array('gutter_style', '=', 'style2'),
					),
					'.tatsu-{UUID}.tatsu-gallery-wrap .gallery-container ' => array(
						'property' => 'padding',
						'prepend' => '0 ',
						'append' => 'px',
						'operation' => array('/', 2),
						'when' => array('gutter_style', '=', 'style1'),
					),
					'.tatsu-{UUID} .gallery-container .gallery-cell.be-col' => array(
						'property' => 'margin-bottom',
						'append' => 'px'
					),
					'.tatsu-{UUID} .gallery-container .gallery-cell.be-col ' => array(
						'property' => 'padding',
						'prepend' => '0 ',
						'append' => 'px',
						'operation' => array('/', 2),
					),
					'.tatsu-{UUID}.tatsu-gallery-module .gallery-container ' => array(
						'property' => 'margin-bottom',
						'prepend' => '-',
						'append' => 'px !important'
					),
				),
			),
			array(
				'att_name' => 'masonry',
				'type' => 'switch',
				'label' => esc_html__('Preserve Image Aspect Ratio', 'tatsu'),
				'default' => 0,
				'tooltip' => '',
			),
			array(
				'att_name' => 'initial_load_style',
				'type' => 'select',
				'label' => esc_html__('Image Load Animation', 'tatsu'),
				'options' => array(
					'init-slide-left' => 'Slide Left',
					'init-slide-right' => 'Slide Right',
					'init-slide-top' => 'Slide Top',
					'init-slide-bottom' => 'Slide Bottom',
					'init-scale' => 'Scale',
					'fadeIn' => 'Fade In',
					'none' => 'None',
				),
				'default' => 'fadeIn',
				'tooltip' => ''
			),
			array(
				'att_name' => 'hover_show_title',
				'type' => 'switch',
				'label' => esc_html__('Show Title On Hover', 'tatsu'),
				'default' => '0',
				'tooltip' => ''
			),
			array(
				'att_name' => 'hover_content_color',
				'type' => 'color',
				'label' => esc_html__('Title Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'visible' => array('hover_show_title', '=', '1'),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-gallery-module .thumb-title' => array(
						'property' => 'color',
					),
				),
			),
			array(
				'att_name' => 'overlay_color',
				'type' => 'color',
				'label' => esc_html__('Image Overlay Color', 'tatsu'),
				'options'		=> array(
					'gradient'	=> true
				),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-gallery-module .thumb-bg' => array(
						'property' => 'background-color',
					),
				),
			),
		),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'initial_load_style' => 'fadeIn',
					'overlay_color' => array('id' => 'palette:0', 'color' => tatsu_get_color('tatsu_accent_color')),
					'hover_content_color' => '#fff',
				),
			)
		),
	);
	if ( ! in_array( 'wplr-sync/wplr-sync.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		tatsu_register_module('gallery', $controls, 'tatsu_gallery');
		tatsu_remap_modules(array('tatsu_gallery', 'oshine_gallery' ,'gallery'), $controls, 'tatsu_gallery');
	}else{
		tatsu_remap_modules(array('tatsu_gallery', 'oshine_gallery' ), $controls, 'tatsu_gallery');
	}
	
}

?>