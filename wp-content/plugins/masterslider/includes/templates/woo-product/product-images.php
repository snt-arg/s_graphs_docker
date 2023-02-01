<?php
/**
 * Master Slider.
 *
 * @package   MasterSlider
 * @author    averta [averta.net]
 * @license   LICENSE.txt
 * @link      http://masterslider.com
 * @copyright Copyright © 2014 averta
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $woocommerce, $product;

?>
<div class="images ms-product-slider">

	<?php
	$attachment_ids = $product->get_gallery_image_ids();

	$image_count  = has_post_thumbnail() ? 1 : 0;
	$image_count += count( $attachment_ids );


	if( $image_count > 1 ) {

		$enable_thumbnail = apply_filters( 'msp_woocommerce_display_thumbnail_for_single_product_slider', true );

		$small_thumbnail_size  	= apply_filters( 'single_product_small_single_size', 'shop_thumbnail' );
		$thumbnail_dimensions   = wc_get_image_size( $small_thumbnail_size );

		$large_single_size  	= apply_filters( 'single_product_large_single_size', 'shop_single' );
		$slide_image_dimensions = wc_get_image_size( $large_single_size );

		$slider_params = array(

			'id'            => $post->ID,     // slider id
			'uid'           => '',      // an unique and temporary id
			'class'         => '',      // a class that adds to slider wrapper
			'margin'        => 0,

			'inline_style'  => '',
			'bg_color'      => '',
			'bg_image'      => '',

			'slider_type'   => 'custom',   // values: custom, flickr, facebook, post

			'width'         => $slide_image_dimensions['width'],     // base width of slides. It helps the slider to resize in correct ratio.
			'height'        => $slide_image_dimensions['height'],     // base height of slides, It helps the slider to resize in correct ratio.

			'start'         => 1,
			'space'         => 0,

			'grab_cursor'   => 'true',  // Whether the slider uses grab mouse cursor
			'swipe'         => 'true',  // Whether the drag/swipe navigation is enabled

			'wheel'         => 'false', // Enables mouse scroll wheel navigation
			'mouse'         => 'true',  // Whether the user can use mouse drag navigation

			'crop' 			 => 'false', // Automatically crop slide images?

			'autoplay'      => 'false', // Enables the autoplay slideshow
			'loop'          => 'false', //
			'shuffle'       => 'false', // Enables the shuffle slide order
			'preload'       =>  2,

			'wrapper_width' => '',
    		'wrapper_width_unit' => 'px',

			'layout'        => 'fillwidth',

			'fullscreen_margin' => 0,

			'height_limit'  => 'false', // It force the slide to use max height value as its base specified height value.
			'auto_height'   => 'false',
			'smooth_height' => 'true',

			'end_pause'     => 'false',
			'over_pause'    => 'false',

			'fill_mode'     => 'fill',
			'center_controls'=> 'true',

			'layers_mode'   => 'center',// It accepts two values "center" and "full"
			'hide_layers'   => 'false',

			'instant_show_layers' => 'false',

			'speed'         => 17,

			'skin'          => 'ms-skin-default', // slider skin. should be seperated by space - should be started by ms-skin
			'template'      => '',
			'template_class'=> '',
			'direction'     => 'h',
			'view'          => 'basic',

			'gfonts' 		=> '',

    		'parallax_mode' => 'swipe',

			'arrows'           => 'true',   // display arrows?
			'arrows_autohide'  => 'true',   // auto hide arrows?
			'arrows_overvideo' => 'true',   // visible over slide video while playing?
			'arrows_hideunder' => '',

			'bullets'          => 'false',  // display bullets?
			'bullets_autohide' => 'true',   // auto hide bullets?
			'bullets_overvideo'=> 'true',   // visible over slide video while playing?
			'bullets_direction'=> 'h',
			'bullets_align'    => 'bottom',
			'bullets_margin'   => '',
			'bullets_hideunder'=> '',

			'thumbs'           => 'false',  // display thumbnails?
			'thumbs_autohide'  => 'false',   // auto hide thumbs?
			'thumbs_overvideo' => 'true',   // visible over slide video while playing?
			'thumbs_direction' => 'h',      // direction of control
			'thumbs_type'      => 'thumbs',
			'thumbs_speed'     => 17,       // scrolling speed. It accepts float values between 0 and 100
			'thumbs_inset'     => 'false',   // insert thumbs inside slider
			'thumbs_align'     => 'bottom',
			'thumbs_margin'    => 0,
			'thumbs_width'     => $thumbnail_dimensions['width'],
			'thumbs_height'    => $thumbnail_dimensions['height'],
			'thumbs_space'     => 0,
			'thumbs_hideunder' => '',
			'thumbs_fillmode'  => 'fill',

			'scroll'           => 'false',  // display scrollbar?
			'scroll_autohide'  => 'true',   // auto hide scroll?
			'scroll_overvideo' => 'true',   // visible over slide video while playing?
			'scroll_direction' => 'h',      // direction of control
			'scroll_align'     => 'top',
			'scroll_inset'     => 'true',
			'scroll_margin'    => '',
			'scroll_color'     => '#3D3D3D',
			'scroll_hideunder' => '',
			'scroll_width' 	 => '',

			'circletimer'          => 'false',  // display circletimer?
			'circletimer_autohide' => 'true',   // auto hide circletimer?
			'circletimer_overvideo'=> 'true',   // visible over slide video while playing?
			'circletimer_color'    => '#A2A2A2',// color of circle timer
			'circletimer_radius'   => 4,        // radius of circle timer in pixels
			'circletimer_stroke'   => 10,       // the stroke of circle timer in pixels
			'circletimer_margin'   => '',
			'circletimer_hideunder'=> '',

			'timebar'          => 'false',   // display timebar?
			'timebar_autohide' => 'true',   // auto hide timebar?
			'timebar_overvideo'=> 'true',   // visible over slide video while playing?
			'timebar_align'    => 'bottom',
			'timebar_color'    => '#FFFFFF',
			'timebar_hideunder'=> '',
			'timebar_width' 	 => '',


			'slideinfo'          => 'false',   // display timebar?
			'slideinfo_autohide' => 'true',   // auto hide timebar?
			'slideinfo_overvideo'=> 'true',   // visible over slide video while playing?
			'slideinfo_direction'=> 'h',
			'slideinfo_align'    => 'bottom',
			'slideinfo_inset'    => 'false',
			'slideinfo_margin'   => '',
			'slideinfo_hideunder'=> '',
			'slideinfo_width'	 => '',
			'slideinfo_height'   => ''
		);

		if( $enable_thumbnail )
			$slider_params['thumbs'] = 'true';

		$slider_params = apply_filters( 'msp_woocommerce_single_product_slider_params', $slider_params, $post );

		// create ms_slider shortcode
		$slider_attrs = '';
		foreach ( $slider_params as $attr => $attr_value ) {
			$slider_attrs .= sprintf( '%s="%s" ', $attr, esc_attr( $attr_value ) );
		}



		$slides = '';

		if ( has_post_thumbnail() ) {

			$image_title = esc_attr( get_the_title( get_post_thumbnail_id() ) );
			$image_link  = wp_get_attachment_url( get_post_thumbnail_id() );
			$image_src   = msp_get_the_resized_image_src( $image_link, $slide_image_dimensions['width'], $slide_image_dimensions['height'], $slide_image_dimensions['crop'] );

			$attachment_count = count( $product->get_gallery_image_ids() );

			if ( $attachment_count > 0 ) {
				$gallery = "&#91;product-gallery&#93;";
			} else {
				$gallery = '';
			}

			$slide_options = array(
				'src'       => $image_src,
				'css_class' => 'woocommerce-main-image zoom ms-zoom',

				'title'     => $image_title, // image and link title
				'alt'       => $image_title, // image alternative text
				//'link'      => $image_link,
				'rel' 		=> "prettyPhoto" . $gallery,
				'target'    => '_blank',
				'video'     => '', // youtube or vimeo video link

				'mp4'			=> '', // self host video bg
				'webm'		=> '', // self host video bg
				'ogg'			=> '', // self host video bg

				'autopause' => 'false',
				'mute'		=> 'true',
				'loop' 		=> 'true',

				'crop_width'  => '', // empty means auto
				'crop_height' => '', // empty means auto

				'thumb' 	=> '',
				'delay'     => '', // data-delay
				'bgalign'	=> ''  // data-fill-mode
			);

			if( $enable_thumbnail )
				$slide_options['thumb'] = msp_get_the_resized_image_src( $image_link, $thumbnail_dimensions['width'], $thumbnail_dimensions['height'], $thumbnail_dimensions['crop'] );


			$slide_options = apply_filters( 'msp_woocommerce_single_product_slider_slide_params', $slide_options, $post );


			$slide_attrs = '';
			foreach ( $slide_options as $attr => $attr_value ) {
				$slide_attrs .= sprintf( '%s="%s" ', $attr, esc_attr( $attr_value ) );
			}

			$slides .= sprintf( '[ms_slide %s ][/ms_slide]', $slide_attrs );
		}


		if ( $attachment_ids ) {

			$loop = 0;

			foreach ( $attachment_ids as $attachment_id ) {

				$image_link = wp_get_attachment_url( $attachment_id );

				if ( ! $image_link )
					continue;

				$image_title = esc_attr( get_the_title( $attachment_id ) );
				$image_src   = msp_get_the_resized_image_src( $image_link, $slide_image_dimensions['width'], $slide_image_dimensions['height'], $slide_image_dimensions['crop'] );

				$attachment_count = count( $product->get_gallery_image_ids() );

				if ( $attachment_count > 0 ) {
					$gallery = "&#91;product-gallery&#93;";
				} else {
					$gallery = '';
				}


				$slide_options = array(
					'src'       => $image_src,
					'css_class' => 'zoom ms-zoom',

					'title'     => $image_title, // image and link title
					'alt'       => $image_title, // image alternative text
					//'link'      => $image_link,
					'rel' 		=> 'prettyPhoto' . $gallery,
					'target'    => '_blank',
					'video'     => '', // youtube or vimeo video link

					'mp4'			=> '', // self host video bg
					'webm'		=> '', // self host video bg
					'ogg'			=> '', // self host video bg

					'autopause' => 'false',
					'mute'		=> 'true',
					'loop' 		=> 'true',

					'crop_width'  => '', // empty means auto
					'crop_height' => '', // empty means auto

					'thumb' 	=> '',
					'delay'     => '', // data-delay
					'bgalign'	=> ''  // data-fill-mode
				);

				if( $enable_thumbnail )
					$slide_options['thumb'] = msp_get_the_resized_image_src( $image_link, $thumbnail_dimensions['width'], $thumbnail_dimensions['height'], $thumbnail_dimensions['crop'] );


				$slide_options = apply_filters( 'msp_woocommerce_single_product_slider_slide_params', $slide_options, $post );


				$slide_attrs = '';
				foreach ( $slide_options as $attr => $attr_value ) {
					$slide_attrs .= sprintf( '%s="%s" ', $attr, esc_attr( $attr_value ) );
				}

				$slides .= sprintf( '[ms_slide %s ][/ms_slide]', $slide_attrs );

				$loop++;
			}

		}



		$slider_shortcode = ! empty( $slides ) ? sprintf( '[ms_slider %s ]%s[/ms_slider]', $slider_attrs, $slides ) : '';
		echo do_shortcode( $slider_shortcode );

	} elseif( $image_count === 1 ) {

		if ( has_post_thumbnail() ) {

			$image_title = esc_attr( get_the_title( get_post_thumbnail_id() ) );
			$image_link  = wp_get_attachment_url( get_post_thumbnail_id() );
			$image       = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
				'title' => $image_title
			) );

			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-rel="prettyPhoto">%s</a>', $image_link, $image_title, $image ), $post->ID );

		} else {

			$image       = wp_get_attachment_image( $attachment_ids[0], apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
			$image_title = esc_attr( get_the_title( $attachment_ids[0] ) );
			$image_link  = wp_get_attachment_url( $attachment_ids[0] );

			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-rel="prettyPhoto">%s</a>', $image_link, $image_title, $image ), $post->ID );
		}

	} else {
		echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="Placeholder" />', wc_placeholder_img_src() ), $post->ID );
	}

	do_action( 'woocommerce_product_thumbnails' );
	?>

</div>
