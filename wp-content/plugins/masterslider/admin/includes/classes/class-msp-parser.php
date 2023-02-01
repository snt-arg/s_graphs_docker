<?php

/**
 * Master Slider Data Parser Class.
 *
 * @package   MasterSlider
 * @author    averta [averta.net]
 * @license   LICENSE.txt
 * @link      http://masterslider.com
 * @copyright Copyright © 2014 averta
*/

// no direct access allowed
if ( ! defined('ABSPATH') ) {
    die();
}


class MSP_Parser {


	public $maybe_encoded_data;

	// ready to parse data
	public $parsable_data ;

	// recent parsed slider setting
	public $recent_setting;

	// recent parsed slides
	public $recent_slides ;

	// recent parsed layers
	public $recent_layers ;

	// recent parsed styles
	public $recent_styles ;


	public $current_slider_id;

	public $join_char = "\n";
	public $tab_char  = "\t";



	public function __construct() {


		if ( apply_filters( 'masterslider_compress_custom_css' , 1 ) ) {
			$this->join_char = "";
			$this->tab_char  = "";
		}
	}

	public function get_setting() {

	}

	public function is_key_true( $array, $key, $default = 'true' ) {
		if( isset( $array[ $key ] ) ) {
			return $array[ $key ] ? 'true' : 'false';
		} else {
			return $default;
		}
	}

	public function parse_setting( $setting = array() ) {

		// make sure $setting is not serialized
		$setting = maybe_unserialize( $setting );

		$setid = isset( $setting['setId'] ) ? (string) $setting['setId'] : '';

		$post_cats = isset( $setting['postCats'] ) ? (array) $setting['postCats'] : array();
		$post_tags = isset( $setting['postTags'] ) ? (array) $setting['postTags'] : array();
		$tax_term_ids = implode( ',', array_merge( $post_cats, $post_tags ) );

		// slider options
		return array(

            'id'                      => is_numeric( $this->current_slider_id ) ? $this->current_slider_id : ( isset( $setting['sliderId'] ) ? (string) $setting['sliderId'] : '' ),
            'uid'                     => '',         // an unique and temporary id
            'class'                   => isset( $setting['className'] ) ? (string) $setting['className'] : '',      // a class that adds to slider wrapper
            'margin'                  => 0,

            'custom_style'            => isset( $setting['customStyle'] ) ? $setting['customStyle'] : '',

            'inline_style'            => isset( $setting['inlineStyle'] ) ? esc_attr( $setting['inlineStyle'] ) : '',
            'bg_color'                => isset( $setting['bgColor'] ) ? (string) $setting['bgColor'] : '',
            'bg_image'                => isset( $setting['bgImage'] ) ? msp_get_the_relative_media_url( $setting['bgImage'] ) : '',

            'title'                   => isset( $setting['name'] )  ? (string) $setting['name']  : __( 'Untitled Slider', MSWP_TEXT_DOMAIN ),       // slider name
            'alias'                   => isset( $setting['slug'] ) ? (string) $setting['slug'] : '',

            'slider_type'             => isset( $setting['type'] ) ? (string) $setting['type'] : 'custom',   // values: custom, express, flickr, post_view


            'width'                   => isset( $setting['width'] )  ? (int) rtrim($setting['width'] , 'px' ) : 300,     // base width of slides. It helps the slider to resize in correct ratio.
            'height'                  => isset( $setting['height'] ) ? (int) rtrim($setting['height'], 'px' ) : 150,     // base height of slides, It helps the slider to resize in correct ratio.
            'min_height'              => isset( $setting['minHeight'] ) ? (int) rtrim($setting['minHeight'], 'px' ) : 0,

            'start'                   => isset( $setting['start'] ) ? (int) $setting['start'] : 1,
            'space'                   => isset( $setting['space'] ) ? (int) $setting['space'] : 0,

            'grab_cursor'             => $this->is_key_true( $setting, 'grabCursor', 'true' ),  // Whether the slider uses grab mouse cursor
            'swipe'                   => $this->is_key_true( $setting, 'swipe', 'true' ),  // Whether the drag/swipe navigation is enabled

            'wheel'                   => $this->is_key_true( $setting, 'wheel', 'false' ), // Enables mouse scroll wheel navigation
            'mouse'                   => $this->is_key_true( $setting, 'mouse', 'true' ),  // Whether the user can use mouse drag navigation

            'keyboard'                => $this->is_key_true( $setting, 'keyboard', 'false' ),  // Whether the user can use keyboard navigation

            'crop'                    => $this->is_key_true( $setting, 'autoCrop', 'false' ),  // Automatically crop slide images?

            'autoplay'                => $this->is_key_true( $setting, 'autoplay', 'false' ), // Enables the autoplay slideshow
            'loop'                    => $this->is_key_true( $setting, 'loop', 'false' ), //
            'shuffle'                 => $this->is_key_true( $setting, 'shuffle', 'false' ), // Enables the shuffle slide order
            'preload'                 => isset( $setting['preload'] ) ? $setting['preload'] : 0,

            'wrapper_width'           => isset( $setting['wrapperWidth'] ) ? (int) $setting['wrapperWidth'] : '',
            'wrapper_width_unit'      => isset( $setting['wrapperWidthUnit'] ) ? $setting['wrapperWidthUnit'] : 'px',

            'layout'                  => isset( $setting['layout'] ) ? (string) $setting['layout'] : 'boxed',

            'fullscreen_margin'       => isset( $setting['fullscreenMargin'] ) ? (int) $setting['fullscreenMargin'] : 0,


            'height_limit'            => 'true', // It force the slide to use max height value as its base specified height value.
            'auto_height'             => $this->is_key_true( $setting, 'autoHeight', 'false' ),
            'smooth_height'           => 'true',

            'end_pause'               => $this->is_key_true( $setting, 'endPause' , 'false' ),
            'over_pause'              => $this->is_key_true( $setting, 'overPause', 'false' ),

            'fill_mode'               => apply_filters( 'masterslider_params_default_fill_mode', 'fill' ),
            'autofill_target'         => isset( $setting['autofillTarget'] ) ? (string) $setting['autofillTarget'] : '',

            'center_controls'         => $this->is_key_true( $setting, 'centerControls', 'true' ),

            'layers_mode'             => apply_filters( 'masterslider_params_default_layers_mode', 'center' ), // It accepts two values "center" and "full"
            'hide_layers'             => $this->is_key_true( $setting, 'hideLayers', 'false' ),

            'instant_show_layers'     => $this->is_key_true( $setting, 'instantShowLayers'  , 'false' ),
            'mobile_bg_video'         => $this->is_key_true( $setting, 'mobileBGVideo'      , 'false' ),
            'enable_overlay_layers'   => $this->is_key_true( $setting, 'enableOverlayLayers', 'false' ),

            'speed'                   => isset( $setting['speed'] ) ? (int) $setting['speed'] : 20,

            'skin'                    => isset( $setting['skin'] ) ? $setting['skin'] : 'ms-skin-default', // slider skin. should be seperated by space
            'template'                => isset( $setting['msTemplate'] ) ? (string) $setting['msTemplate'] : 'custom',
            'template_class'          => isset( $setting['msTemplateClass'] ) ? (string) $setting['msTemplateClass'] : '',
            'direction'               => isset( $setting['dir'] ) ? (string) $setting['dir'] : 'h',
            'view'                    => isset( $setting['trView'] ) ? (string) $setting['trView'] : 'basic',

            'gfonts'                  => isset( $setting['usedFonts'] ) ? (string) $setting['usedFonts'] : '',

            'parallax_mode'           => isset( $setting['parallaxMode'] ) ? (string) $setting['parallaxMode'] : 'swipe',
            'scroll_parallax'         => $this->is_key_true( $setting, 'scrollParallax', 'false' ),

            'start_on_appear'         => $this->is_key_true( $setting, 'startOnAppear', 'false' ),

            'scroll_parallax_move'    => isset( $setting['scrollParallaxMove'] ) ? (int) $setting['scrollParallaxMove'] : 30,
            'scroll_parallax_fade'    => $this->is_key_true( $setting, 'scrollParallaxFade', 'true' ),
            'scroll_parallax_bg_move' => isset( $setting['scrollParallaxBGMove'] ) ? (int) $setting['scrollParallaxBGMove'] : 50,

            'use_deep_link'           => $this->is_key_true( $setting, 'useDeepLink', 'false' ),
            'deep_link'               => isset( $setting['deepLink'] ) ? (string) $setting['deepLink'] : '',
            'deep_link_type'          => isset( $setting['deepLinkType'] ) ? (string) $setting['deepLinkType'] : 'path',

            'flickr_key'              => isset( $setting['apiKey'] ) ? (string) $setting['apiKey'] : '',
            'flickr_id'               => $setid,
            'flickr_count'            => isset( $setting['imgCount'] ) ? (int) $setting['imgCount'] : 10,
            'flickr_type'             => isset( $setting['setType'] ) ? (string) $setting['setType'] : 'photos',
            'flickr_size'             => isset( $setting['imgSize'] ) ? (string) $setting['imgSize'] : 'c',
            'flickr_thumb_size'       => isset( $setting['thumbSize'] ) ? (string) $setting['thumbSize'] : 'q',


            'ps_post_type'            => isset( $setting['postType'] ) ? (string) $setting['postType'] : '',
            'ps_tax_term_ids'         => $tax_term_ids,
            'ps_post_count'           => isset( $setting['postCount'] ) ? (int) $setting['postCount'] : 10,
            'ps_image_from'           => isset( $setting['postImageType'] ) ? (string) $setting['postImageType'] : 'auto',
            'ps_order'                => isset( $setting['postOrderDir'] ) ? (string) $setting['postOrderDir'] : 'DESC',
            'ps_orderby'              => isset( $setting['postOrder'] ) ? (string) $setting['postOrder'] : 'menu_order date',
            'ps_posts_not_in'         => isset( $setting['postExcludeIds'] ) ? (string) $setting['postExcludeIds'] : '',
            'ps_posts_in'             => isset( $setting['postIncludeIds'] ) ? (string) $setting['postIncludeIds'] : '',
            'ps_exclude_no_img'       => $this->is_key_true( $setting, 'postExcludeNoImg', 'false' ),

            'ps_excerpt_len'          => isset( $setting['postExcerptLen'] ) ? (int) $setting['postExcerptLen'] : 100,
            'ps_offset'               => isset( $setting['postOffset'] ) ? (int) $setting['postOffset'] : 0,
            'ps_link_slide'           => isset( $setting['postLinkSlide'] ) ? (boolean) $setting['postLinkSlide'] : false,
            'ps_link_target'          => isset( $setting['postLinkTarget'] ) ? (string) $setting['postLinkTarget'] : '_self',
            'ps_slide_bg'             => isset( $setting['postSlideBg'] ) ? msp_get_the_relative_media_url( $setting['postSlideBg'] ) : '',

            'wc_only_featured'        => $this->is_key_true( $setting, 'wcOnlyFeatured', 'false' ),
            'wc_only_instock'         => $this->is_key_true( $setting, 'wcOnlyInstock' , 'false' ),
            'wc_only_onsale'          => $this->is_key_true( $setting, 'wcOnlyOnsale'  , 'false' ),


            'facebook_username'       => isset( $setting['setType'] ) && ( 'photostream' == $setting['setType'] ) ? $setid : '',
            'facebook_albumid'        => isset( $setting['setType'] ) && ( 'album' == $setting['setType'] ) ? $setid : '',
            'facebook_count'          => isset( $setting['imgCount'] ) ? (int) $setting['imgCount'] : 10,
            'facebook_type'           => isset( $setting['setType'] ) ? (string) $setting['setType'] : 'album',
            'facebook_size'           => isset( $setting['imgSize'] ) ? (string) $setting['imgSize'] : 'orginal',
            'facebook_thumb_size'     => isset( $setting['thumbSize'] ) ? (string) $setting['thumbSize'] : '320',
            'facebook_token'          => isset( $setting['fbtoken'] ) ? (string) $setting['fbtoken'] : '',

            'arrows'                  => 'false',   // display arrows?
            'arrows_autohide'         => 'true',   // auto hide arrows?
            'arrows_overvideo'        => 'true',   // visible over slide video while playing?
            'arrows_hideunder'        => '',

            'bullets'                 => 'false',  // display bullets?
            'bullets_autohide'        => 'true',   // auto hide bullets?
            'bullets_overvideo'       => 'true',   // visible over slide video while playing?
            'bullets_align'           => 'bottom',
            'bullets_margin'          => '',
            'bullets_hideunder'       => '',

            'thumbs'                  => 'false',  // display thumbnails?
            'thumbs_autohide'         => 'true',   // auto hide thumbs?
            'thumbs_overvideo'        => 'true',   // visible over slide video while playing?
            'thumbs_type'             => 'thumbs', // thumb or tabs
            'thumbs_speed'            => 17,       // scrolling speed. It accepts float values between 0 and 100
            'thumbs_inset'            => 'true',	// insert thumbs inside slider
            'thumbs_align'            => 'bottom',
            'thumbs_margin'           => 0,
            'thumbs_width'            => 100,
            'thumbs_height'           => 80,
            'thumbs_space'            => 5,
            'thumbs_hideunder'        => '',
            'thumbs_arrows'           => 'false',
            'thumbs_in_tab'           => 'fasle',
            'thumbs_hoverchange'      => 'false',

            'scroll'                  => 'false',  // display scrollbar?
            'scroll_autohide'         => 'true',   // auto hide scroll?
            'scroll_overvideo'        => 'true',   // visible over slide video while playing?
            'scroll_align'            => 'top',
            'scroll_inset'            => 'true',
            'scroll_margin'           => '',
            'scroll_hideunder'        => '',
            'scroll_color'            => '#3D3D3D',
            'scroll_width'            => '',


            'circletimer'             => 'false',  // display circletimer?
            'circletimer_autohide'    => 'true',   // auto hide circletimer?
            'circletimer_overvideo'   => 'true',   // visible over slide video while playing?
            'circletimer_color'       => '#A2A2A2',// color of circle timer
            'circletimer_radius'      => 4,        // radius of circle timer in pixels
            'circletimer_stroke'      => 10,       // the stroke of circle timer in pixels
            'circletimer_margin'      => '',
            'circletimer_hideunder'   => '',

            'timebar'                 => 'false',   // display timebar?
            'timebar_autohide'        => 'true',   // auto hide timebar?
            'timebar_overvideo'       => 'true',   // visible over slide video while playing?
            'timebar_align'           => 'bottom',
            'timebar_hideunder'       => '',
            'timebar_color'           => '#FFFFFF',
            'timebar_width'           => '',


            'slideinfo'               => 'false',   // display timebar?
            'slideinfo_autohide'      => 'true',   // auto hide timebar?
            'slideinfo_overvideo'     => 'true',   // visible over slide video while playing?
            'slideinfo_align'         => 'bottom',
            'slideinfo_inset'         => 'false',
            'slideinfo_margin'        => '',
            'slideinfo_hideunder'     => '',
            'slideinfo_width'         => '',
            'slideinfo_height'        => '',

            'on_init'                 => '',
            'on_change_start'         => '',
            'on_change_end'           => '',
            'on_waiting'              => '',
            'on_resize'               => '',
            'on_video_play'           => '',
            'on_video_close'          => '',
            'on_swipe_start'          => '',
            'on_swipe_move'           => '',
			'on_swipe_end'            => '',

			'responsive'              => $this->is_key_true( $setting, 'responsive', 'true' ),
			'responsive_size'         => $this->is_key_true( $setting, 'responsiveSize', 'false' ),

			'tablet_width'            => isset( $setting['tabletWidth']  ) ? (int) $setting['tabletWidth']  : 768,
			'tablet_height'           => isset( $setting['tabletHeight'] ) ? (int) $setting['tabletHeight'] : null,
			'phone_width'             => isset( $setting['phoneWidth']  ) ? (int) $setting['phoneWidth']  : 480,
			'phone_height'            => isset( $setting['phoneHeight'] ) ? (int) $setting['phoneHeight'] : null
	    );


	}



	public function parse_layer( $layer ) {

		// make sure $layer is not serialized
		$layer = maybe_unserialize( $layer );

		if( empty( $layer ) )
			return $layer;

		return array(

            'id'                           => isset( $layer['id'] ) ? (int) $layer['id'] : 0,
            'src'                          => isset( $layer['img'] ) ? esc_attr( msp_get_the_relative_media_url( $layer['img'] ) ) : '', // image layer src or video cover image

            'widthlimit'                   => isset( $layer['widthlimit'] ) ? (int) $layer['widthlimit'] : 0,

            'ms_id'                        => isset( $layer['msId'] ) ? (string) $layer['msId'] : '', // slide id
            'action_target_layer'          => isset( $layer['actionTargetLayer'] ) ? (string) $layer['actionTargetLayer'] : '', // the target layer id
            'wait'                         => $this->is_key_true( $layer, 'wait', 'false' ),
            'masked'                       => $this->is_key_true( $layer, 'masked', 'false' ),
            'mask_custom_size'             => $this->is_key_true( $layer, 'maskCustomSize', 'false' ),
            'mask_width'                   => isset( $layer['maskWidth'] ) ? (int) $layer['maskWidth'] : '',
            'mask_height'                  => isset( $layer['maskHeight'] ) ? (int) $layer['maskHeight'] : '',

            // only for overlay layers, show or hide the layer over the specified slides
            'overlay_target_slides'        => isset( $layer['overlayTargetSlides'] ) ? (string) $layer['overlayTargetSlides'] : '',
            'overlay_target_slides_action' => isset( $layer['overlayTargetSlidesAction'] ) ? (string) $layer['overlayTargetSlidesAction'] : 'show',
            //---------------------------------------------------------------------------

            'type'                         => isset( $layer['type'] ) ? (string) $layer['type'] : 'text', // layer type : text, image, video, hotspot
            'resize'                       => $this->is_key_true( $layer, 'resize', 'true' ),

            'css_class'                    => isset( $layer['cssClass'] ) ? (string) $layer['cssClass'] : '',
            'btn_class'                    => isset( $layer['btnClass'] ) ? (string) $layer['btnClass'] : 'ms-default-btn',
            'css_id'                       => isset( $layer['cssId'] ) ? (string) $layer['cssId'] : '',
            'style_id'                     => isset( $layer['className'] ) ? (string) $layer['className'] : '',

            'action'                       => isset( $layer['action'] ) ? (string) $layer['action'] : 'next',
            'use_action'                   => $this->is_key_true( $layer, 'useAction', 'false' ),
            'to_slide'                     => isset( $layer['toSlide'] ) ? (int) $layer['toSlide'] : 1,
            'action_scroll_duration'       => isset( $layer['scrollDuration'] ) ? (float) $layer['scrollDuration'] : 2,
            'scroll_target'                => isset( $layer['scrollTarget'] ) ? (string) $layer['scrollTarget'] : '',

            'position_type'                => isset( $layer['position'] ) ? (string) $layer['position'] : 'normal',

            'offsetx'                      => isset( $layer['offsetX'] ) ? (int) $layer['offsetX'] : 0,
            'offsety'                      => isset( $layer['offsetY'] ) ? (int) $layer['offsetY'] : 0,
            'origin'                       => isset( $layer['origin'] ) ? (string) $layer['origin'] : 'tl',
            'fixed'                        => $this->is_key_true( $layer, 'fixed', 'false' ),


            'use_hide'                     => $this->is_key_true( $layer, 'useHide', 'true' ),
            'hide_effect'                  => isset( $layer['hideEffFunc'] ) ? esc_attr( $layer['hideEffFunc'] ) : 'fade',
            'hide_duration'                => isset( $layer['hideDuration'] ) ? (float) $layer['hideDuration'] * 1000 : 1000,
            'hide_delay'                   => isset( $layer['hideDelay'] ) ? (float) $layer['hideDelay'] * 1000 : 1000,
            'hide_ease'                    => isset( $layer['hideEase'] ) ? (string) $layer['hideEase'] : 'easeOutQuint',

            'show_effect'                  => isset( $layer['showEffFunc'] ) ? esc_attr( $layer['showEffFunc'] ) : 'fade',
            'show_duration'                => isset( $layer['showDuration'] ) ? (float) $layer['showDuration'] * 1000 : 1000,
            'show_delay'                   => isset( $layer['showDelay'] ) ? (float) $layer['showDelay'] * 1000 : 0,
            'show_ease'                    => isset( $layer['showEase'] ) ? (string) $layer['showEase'] : 'easeOutQuint',

            'rel'                          => isset( $layer['rel'] ) ? (string) $layer['rel'] : '',
            'alt'                          => isset( $layer['imgAlt'] ) ? (string) $layer['imgAlt'] : '', // image alternative text
            'link'                         => isset( $layer['link'] ) ? (string) $layer['link'] : '', // image external url
            'target'                       => isset( $layer['linkTarget'] ) ? esc_attr( $layer['linkTarget'] ) : '_self',
            'title'                        => isset( $layer['title'] ) ? esc_attr( $layer['title'] ) : '',

            'tooltip_align'                => isset( $layer['align'] ) ? esc_attr( $layer['align'] ) : 'top',
            'tooltip_stay_hover'           => $this->is_key_true( $layer, 'stayHover', 'true' ),
            'tooltip_width'                => isset( $layer['width'] ) ? (int) $layer['width'] : '',

            'parallax'                     => isset( $layer['parallax'] ) ? (int)$layer['parallax'] : 0,

            'content'                      => isset( $layer['content'] ) ? wp_slash( $layer['content'] ) : '',
            'order'                        => isset( $layer['order'] ) ? $layer['order'] : '',

            'video'                        => isset( $layer['video'] ) ? (string) $layer['video'] : '', // video iframe path
            'auto_play_video'              => $this->is_key_true( $layer, 'autoplayVideo', 'false' ), // autoplay for youtube or vimeo videos
            'width'                        => isset( $layer['width'] ) ? (int) $layer['width'] : '',
			'height'                       => isset( $layer['height'] ) ? (int) $layer['height'] : '',

			'fixed'                        => $this->is_key_true( $layer, 'fixed', 'false' ),

			// responsive options
			'tablet_offset_x'              => isset( $layer['tabletOffsetX'] ) ? (int) $layer['tabletOffsetX']   : 0,
            'tablet_offset_y'              => isset( $layer['tabletOffsetY'] ) ? (int) $layer['tabletOffsetY']   : 0,
			'tablet_origin'                => isset( $layer['tabletOrigin']  ) ? (string) $layer['tabletOrigin'] : '',

			'phone_offset_x'               => isset( $layer['phoneOffsetX'] ) ? (int) $layer['phoneOffsetX']   : 0,
            'phone_offset_y'               => isset( $layer['phoneOffsetY'] ) ? (int) $layer['phoneOffsetY']   : 0,
			'phone_origin'                 => isset( $layer['phoneOrigin']  ) ? (string) $layer['phoneOrigin'] : '',
			'hide_on'                      => isset( $layer['hideOn'] ) ? (string) $layer['hideOn'] : ''
        );

	}


	public function parse_slide( $slide = array() ) {

		// make sure $slide is not serialized
		$slide = maybe_unserialize( $slide );

		if( empty( $slide ) )
			return $slide;

		// get slider setting and controls
		$slider_setting = $this->get_slider_setting();

		// get slide onfo if is set (usage: for tab content if is set)
		$info = isset( $slide['info'] ) ? $slide['info'] : '';

		if( isset( $slide['bg'] ) ) {
			$slide_src = msp_get_the_absolute_media_url( $slide['bg'] );

			// generate thumb for master slider panel
			msp_get_the_resized_image_src( $slide_src, 150, 150, true );
		}


		// stores a URL for thumbnail in thumbnail list
		$thumb = '';

		// add thumb just if thumblist is added to controls list
		// also always add thumbnail if slider template is gallery
		if( ( 'true' == $slider_setting['thumbs'] && 'thumbs' == $slider_setting['thumbs_type'] ) ||
		      'image-gallery' == $slider_setting['template']
		  ){

			if( isset( $slide['thumbOrginal'] ) && ! empty( $slide['thumbOrginal'] ) ) {
				$thumb = $slide['thumbOrginal'];
				$thumb = msp_get_the_relative_media_url( $thumb );

			} elseif( isset( $slide['bg'] ) ) {

				// set custom thumb size if slider template is gallery
				if( 'image-gallery' == $slider_setting['template']  )
					$thumb = msp_get_the_resized_image_src( $slide_src, 175, 140, true );
				else
					$thumb = msp_get_the_resized_image_src( $slide_src, $slider_setting['thumbs_width'], $slider_setting['thumbs_height'], true );

				$thumb = msp_get_the_relative_media_url( $thumb );

			}

		}

		// stores a URL for thumbnail in tab
		$tab_thumb = '';

		// get thumb for tab if thumblist is added to controls list
		if( ( 'true' == $slider_setting['thumbs'] &&
		   	  'tabs' == $slider_setting['thumbs_type'] ) &&
			  'true' == $slider_setting['thumbs_in_tab'] ){

			if( isset( $slide['thumbOrginal'] ) && ! empty( $slide['thumbOrginal'] ) ) {
				$tab_thumb = $slide['thumbOrginal'];
				$tab_thumb = msp_get_the_relative_media_url( $tab_thumb );

			} elseif( isset( $slide['bg'] ) ) {
				// generate a square thumb for tab
				$tab_thumb = msp_get_the_resized_image_src( $slide_src, $slider_setting['thumbs_height'], $slider_setting['thumbs_height'], true );
				$tab_thumb = msp_get_the_relative_media_url( $tab_thumb );
			}
		}


		$slides = array(

            'slide_order'       => isset( $slide['order'] ) ? (int) $slide['order'] : 0,

            'css_class'         => isset( $slide['cssClass'] ) ? (string) $slide['cssClass'] : '',
            'css_id'            => isset( $slide['cssId'] ) ? (string) $slide['cssId'] : '',

            'ishide'            => $this->is_key_true( $slide, 'ishide', 'false' ),

            'ms_id'             => isset( $slide['msId'] ) ? (string) $slide['msId'] : '', // slide id
            'is_overlay_layers' => $this->is_key_true( $slide, 'isOverlayLayers', 'false' ),

            'src'               => isset( $slide['bg'] ) ? esc_attr( msp_get_the_relative_media_url( $slide['bg'] ) ) : '',
            'src_full'          => isset( $slide['bg'] ) ? esc_attr( msp_get_the_relative_media_url( $slide['bg'] ) ) : '',

            'title'             => isset( $slide['bgTitle'] ) ? esc_attr($slide['bgTitle']) : '', // title for slide image
            'alt'               => isset( $slide['bgAlt'] ) ? esc_attr($slide['bgAlt']) : '', // alternative text for slide image

            'link'              => isset( $slide['link']      ) ? esc_attr( $slide['link'] ) : '',
            'target'            => isset( $slide['linkTarget']) ? (string) $slide['linkTarget'] : '',
            'link_title'        => isset( $slide['linkTitle'] ) ? (string) $slide['linkTitle'] : '',
            'link_class'        => isset( $slide['linkClass'] ) ? (string) $slide['linkClass'] : '',
            'link_id'           => isset( $slide['linkId']    ) ? (string) $slide['linkId'] : '',
            'link_rel'          => isset( $slide['linkRel']   ) ? (string) $slide['linkRel'] : '',

            'video'             => isset( $slide['video'] ) ? esc_attr( $slide['video'] ) : '', // youtube or vimeo video link
            'auto_play_video'   => $this->is_key_true( $slide, 'autoplayVideo', 'false' ), // autoplay for youtube or vimeo videos

            'info'              => wp_slash( $info ), // image alternative text

            'mp4'               => isset( $slide['bgv_mp4'] ) ? esc_attr( $slide['bgv_mp4'] ) : '', // self host video bg
            'webm'              => isset( $slide['bgv_webm'] ) ? esc_attr( $slide['bgv_webm'] ) : '', // self host video bg
            'ogg'               => isset( $slide['bgv_ogg'] ) ? esc_attr( $slide['bgv_ogg'] ) : '', // self host video bg
            'autopause'         => $this->is_key_true( $slide, 'bgv_autopause', 'false' ),
            'mute'              => $this->is_key_true( $slide, 'bgv_mute', 'true' ),
            'loop'              => $this->is_key_true( $slide, 'bgv_loop', 'true' ),
            'vbgalign'          => isset( $slide['bgv_fillmode'] ) ? (string) $slide['bgv_fillmode'] : 'fill',


            'thumb'             => $thumb,
            'tab'               => 'true' == $slider_setting['thumbs'] && 'tabs' == $slider_setting['thumbs_type'] ? str_replace( '"', '&quote;', $info ) : '',
            'tab_thumb'         => $tab_thumb,
            'delay'             => isset( $slide['duration'] ) ? (string) $slide['duration'] : '', // data-delay
            'bgalign'           => isset( $slide['fillMode'] ) ? (string) $slide['fillMode'] : 'fill', // data-fill-mode
            'bgcolor'           => isset( $slide['bgColor']  ) ? (string) $slide['bgColor'] : '',
            'pattern'           => isset( $slide['pattern']  ) ? (string) $slide['pattern'] : '',
            'tintcolor'         => isset( $slide['colorOverlay']  ) ? (string) $slide['colorOverlay'] : '',

            'layer_ids'         => isset( $slide['layer_ids'] ) && ! empty( $slide['layer_ids'] ) ? (array) $slide['layer_ids'] : array(),
            'layers'            => array()
        );

		// get all layers in slider
		$all_layers = $this->get_layers();
		// store slide's layers
		$current_layers = array();

		// select the layers that belongs to this slide
		foreach ( $slides['layer_ids'] as $layer_id ) {
			if( isset( $all_layers[ $layer_id ] ) )
				$current_layers[] = $all_layers[ $layer_id ];
		}
		// stores layers by layer order
		$layers_by_order = array();

		// collect layers by layer order
		foreach ( $current_layers as $layer ) {
			$layers_by_order[ $layer['order'] ] = $layer;
		}
		// sort layers by layer order
		ksort( $layers_by_order );

		// replace real layers data with layers id
		$slides['layers'] = $layers_by_order;

		return $slides;
	}


	public function parse_each_style( $style_obj, $allowed_style_type = array( 'custom' ) ) {

		// make sure $style_obj is not serialized
		$style_obj = maybe_unserialize( $style_obj );

		if( empty( $style_obj ) )
			return $style_obj;

		$allowed_style_type = (array) $allowed_style_type;

		if( ! isset( $style_obj['type'] ) || ( ! in_array( $style_obj['type'], $allowed_style_type ) ) )
			return '';

		// the css block selector
		$class_name = isset( $style_obj['className'] ) ? ".". $style_obj['className'] : '';
		// store css styles
		$css = '';

        $supported_css_props = array(

            'backgroundColor' 	=> array('background-color'	, ''  ),

            'paddingTop'		=> array('padding-top'		, 'px'),
            'paddingRight'		=> array('padding-right'	, 'px'),
            'paddingBottom' 	=> array('padding-bottom'	, 'px'),
            'paddingLeft' 		=> array('padding-left'		, 'px'),

            'borderTop' 		=> array('border-top'		, 'px'),
            'borderRight' 		=> array('border-right'		, 'px'),
            'borderBottom' 		=> array('border-bottom'	, 'px'),
            'borderLeft' 		=> array('border-left'		, 'px'),

            'borderColor' 		=> array('border-color'		, ''  ),
            'borderRadius' 		=> array('border-radius'	, 'px'),
            'borderStyle' 		=> array('border-style'		, ''  ),

            'fontFamily' 		=> array('font-family'		, ''  ),
            'fontWeight' 		=> array('font-weight'		, ''  ),
            'fontSize' 			=> array('font-size'		, 'px'),

            'textAlign' 		=> array('text-align'		, ''  ),
            'letterSpacing'     => array('letter-spacing'	, 'px'),
            'lineHeight' 		=> array('line-height'		, 'px'),
            'whiteSpace' 		=> array('white-space'		, ''  ),
            'color' 			=> array('color'			, ''  )
        );

        foreach ( $supported_css_props as $js_prop => $parse_option ) {

        	if( isset( $style_obj[$js_prop] ) && ! empty( $style_obj[$js_prop] ) ) {
        		// if prop is font-family add quote around font name
        		if ( 'fontFamily' == $js_prop )
        			$css .= sprintf( "%s%s:\"%s\";", $this->tab_char, $parse_option['0'], rtrim( $style_obj[$js_prop] ) ) . $this->join_char;

        		elseif ( 'lineHeight' == $js_prop &&  'normal' == $style_obj[$js_prop] )
        			$css .= sprintf( "%s%s:%s;", $this->tab_char, $parse_option['0'], rtrim( $style_obj[$js_prop] ) ) . $this->join_char;

        		else
        			$css .= sprintf( "%s%s:%s%s;"  , $this->tab_char, $parse_option['0'], rtrim( $style_obj[$js_prop], $parse_option['1'] ), $parse_option['1'] ) . $this->join_char;

        	}
        }

        // add custom styles at the end
        $css .= isset( $style_obj['custom'] ) ? $this->tab_char . $style_obj['custom'] .$this->join_char : '';
        // create css block
        $css_block = $this->join_char.$class_name." { ".$this->join_char.$css." } \n";
        //$css_block = sprintf( "\n%s {\n%s\n} \n", $class_name, $css );

        return apply_filters( 'msp_parse_each_style', $css_block, $class_name, $css, $supported_css_props );
	}






	// set/store panel raw and parsed data for further use
	public function set_data( $data, $slider_id = null ) {
		$this->reset();

		$this->maybe_encoded_data = $data;
		$this->current_slider_id  = $slider_id;

		$decoded = msp_maybe_base64_decode( $data );
		$this->parsable_data = json_decode($decoded);
	}


	// reset cache data
	public function reset() {
		$this->recent_setting 		= null;
		$this->recent_slides  		= null;
		$this->recent_layers  		= null;
		$this->recent_styles  		= null;
		$this->maybe_encoded_data 	= null;
	}



	// get decoded and parsable panel data
	public function get_parsable_data() {
		return $this->parsable_data;
	}






	public function get_raw_callbacks(){
		if ( isset( $this->parsable_data->{'MSPanel.Callback'} ) )
			return $this->parsable_data->{'MSPanel.Callback'};
		return array();
	}


	public function get_callbacks_params(){
		$callbacks_list = $this->get_raw_callbacks();

		$callbacks_params = array();

		foreach ($callbacks_list as $id => $callback_json) {
			$raw_json_decoded_callback = json_decode( $callback_json, true );
			$callback_params = $this->get_callback_params( $raw_json_decoded_callback );
			$callbacks_params = wp_parse_args( $callback_params, $callbacks_params );
		}

		return $callbacks_params;
	}


	public function get_callback_params( $callback ) {

		$name = isset( $callback['name'] ) ? (string) $callback['name'] : '';

		switch ( $name ) {
			case 'INIT':
				return array( 'on_init' => isset( $callback['content'] ) ? base64_encode( $callback['content'] ) : '' );
			case 'CHANGE_START':
				return array( 'on_change_start' => isset( $callback['content'] ) ? base64_encode( $callback['content'] ) : '' );
			case 'CHANGE_END':
				return array( 'on_change_end'   => isset( $callback['content'] ) ? base64_encode( $callback['content'] ) : '' );
			case 'WAITING':
				return array( 'on_waiting'      => isset( $callback['content'] ) ? base64_encode( $callback['content'] ) : '' );
			case 'RESIZE':
				return array( 'on_resize' 		=> isset( $callback['content'] ) ? base64_encode( $callback['content'] ) : '' );
			case 'VIDEO_PLAY':
				return array( 'on_video_play'   => isset( $callback['content'] ) ? base64_encode( $callback['content'] ) : '' );
			case 'VIDEO_CLOSE':
				return array( 'on_video_close'  => isset( $callback['content'] ) ? base64_encode( $callback['content'] ) : '' );
			case 'SWIPE_START':
				return array( 'on_swipe_start'  => isset( $callback['content'] ) ? base64_encode( $callback['content'] ) : '' );
			case 'SWIPE_MOVE':
				return array( 'on_swipe_move'   => isset( $callback['content'] ) ? base64_encode( $callback['content'] ) : '' );
			case 'SWIPE_END':
				return array( 'on_swipe_end'    => isset( $callback['content'] ) ? base64_encode( $callback['content'] ) : '' );
			default:
				return array();
		}

	}








	public function get_raw_controls(){
		if ( isset( $this->parsable_data->{'MSPanel.Control'} ) )
			return $this->parsable_data->{'MSPanel.Control'};
		return array();
	}


	public function get_controls_params(){
		$controls_list = $this->get_raw_controls();

		$controls_params = array();

		foreach ($controls_list as $id => $control_json) {
			$raw_json_decoded_control = json_decode( $control_json, true );
			$control_params = $this->get_control_params( $raw_json_decoded_control );
			$controls_params = wp_parse_args( $control_params, $controls_params );
		}

		return $controls_params;
	}


	public function get_control_params( $control ) {

		$name = isset( $control['name'] ) ? (string) $control['name'] : '';

		switch ( $name ) {
			case 'thumblist':
				return array(
					'thumbs'           => 'true',
			        'thumbs_autohide'  => $this->is_key_true( $control, 'autoHide' , 'true' ),
			        'thumbs_overvideo' => $this->is_key_true( $control, 'overVideo', 'true' ),
			        'thumbs_speed'     => isset( $control['speed'] ) ? (int) $control['speed'] : 17,
			        'thumbs_type' 	   => isset( $control['type'] ) ? (string) $control['type'] : 'thumbs',
			        'thumbs_inset'     => $this->is_key_true( $control, 'inset', 'false' ),
			        'thumbs_align'     => isset( $control['align'] ) ? (string) $control['align'] : 'bottom',
			        'thumbs_margin'    => isset( $control['margin'] ) ? (int) $control['margin'] : '',
			        'thumbs_width'     => isset( $control['width'] ) ? (int) $control['width'] : 100,
			        'thumbs_height'    => isset( $control['height'] ) ? (int) $control['height'] : 80,
			        'thumbs_space'     => isset( $control['space'] ) ? (int) $control['space'] : 5,
			        'thumbs_hideunder' => isset( $control['hideUnder'] ) ? (int) $control['hideUnder'] : '',
			        'thumbs_fillmode'  => isset( $control['fillMode'] ) ? (string) $control['fillMode'] : 'fill',
			        'thumbs_custom_class' => isset( $control['customClass'] ) ? (string) $control['customClass'] : 'ms-tab-thumb',
			        'thumbs_arrows' 	  => $this->is_key_true( $control, 'arrows' , 'false' ),
			        'thumbs_in_tab'    	  => $this->is_key_true( $control, 'insertThumb' , 'false' ),
			        'thumbs_hoverchange'  => $this->is_key_true( $control, 'hoverChange' , 'false' )
				);
			case 'bullets':
				return array(
					'bullets'          => 'true',
			        'bullets_autohide' => $this->is_key_true( $control, 'autoHide' , 'true' ),
			        'bullets_overvideo'=> $this->is_key_true( $control, 'overVideo', 'true' ),
			        'bullets_align'    => isset( $control['align'] ) ? (string) $control['align'] : 'bottom',
			        'bullets_space'    => isset( $control['space'] ) ? (int) $control['space'] : 5,
			        'bullets_margin'   => isset( $control['margin'] ) ? (int) $control['margin'] : '',
			        'bullets_hideunder'=> isset( $control['hideUnder'] ) ? (int) $control['hideUnder'] : ''
				);
			case 'scrollbar':
				return array(
					'scroll'           => 'true',
			        'scroll_autohide'  => $this->is_key_true( $control, 'autoHide' , 'true' ),
			        'scroll_overvideo' => $this->is_key_true( $control, 'overVideo', 'true' ),
			        //'scroll_width'     => isset( $control['width'] ) ? (int) $control['width'] : '',
			        'scroll_align' 	   => isset( $control['align'] ) ? (string) $control['align'] : 'top',
			        'scroll_color' 	   => isset( $control['color'] ) ? (string) $control['color'] : '#3D3D3D',
			        'scroll_margin'    => isset( $control['margin'] ) ? (int) $control['margin'] : '',
			        'scroll_inset' 	   => $this->is_key_true( $control, 'inset', 'true' ),
			        'scroll_hideunder' => isset( $control['hideUnder'] ) ? (int) $control['hideUnder'] : '',
			        'scroll_width'	   => isset( $control['width'] ) ? (int) $control['width'] : ''
				);
			case 'arrows':
				return array(
					'arrows'           => 'true',
			        'arrows_autohide'  => $this->is_key_true( $control, 'autoHide' , 'true' ),
			        'arrows_overvideo' => $this->is_key_true( $control, 'overVideo', 'true' ),
			        'arrows_hideunder' => isset( $control['hideUnder'] ) ? (int) $control['hideUnder'] : ''
				);
			case 'timebar':
				return array(
					'timebar'          => 'true',
			        'timebar_autohide' => $this->is_key_true( $control, 'autoHide' , 'true' ),
			        'timebar_overvideo'=> $this->is_key_true( $control, 'overVideo', 'true' ),
			        'timebar_align'    => isset( $control['align'] ) ? (string) $control['align'] : 'bottom',
			        'timebar_color'    => isset( $control['color'] ) ? (string) $control['color'] : '#FFFFFF',
			        'timebar_hideunder'=> isset( $control['hideUnder'] ) ? (int) $control['hideUnder'] : '',
			        'timebar_width'	   => isset( $control['width'] ) ? (int) $control['width'] : ''
				);
			case 'circletimer':
				return array(
					'circletimer'          => 'true',
			        'circletimer_autohide' => $this->is_key_true( $control, 'autoHide' , 'true' ),
			        'circletimer_overvideo'=> $this->is_key_true( $control, 'overVideo', 'true' ),
			        'circletimer_color'    => isset( $control['color'] ) ? (string) $control['color'] : '#A2A2A2',
			        'circletimer_radius'   => isset( $control['radius'] ) ? (int) $control['radius'] : 4,
			        'circletimer_stroke'   => isset( $control['stroke'] ) ? (int) $control['stroke'] : 10,
			        'circletimer_margin'   => isset( $control['margin'] ) ? (int) $control['margin'] : '',
			        'circletimer_hideunder'=> isset( $control['hideUnder'] ) ? (int) $control['hideUnder'] : ''
				);
			case 'slideinfo':
				return array(
					'slideinfo'          => 'true',
			        'slideinfo_autohide' => $this->is_key_true( $control, 'autoHide' , 'true' ),
			        'slideinfo_overvideo'=> $this->is_key_true( $control, 'overVideo', 'true' ),
			        'slideinfo_align'    => isset( $control['align'] ) ? (string) $control['align'] : 'bottom',
			        'slideinfo_inset'    => $this->is_key_true( $control, 'inset', 'false' ),
			        'slideinfo_margin'   => isset( $control['margin'] ) ? (int) $control['margin'] : '',
			        'slideinfo_hideunder'=> isset( $control['hideUnder'] ) ? (int) $control['hideUnder'] : '',
			        'slideinfo_width'	 => isset( $control['width'] )  ? (int) $control['width'] : '',
					'slideinfo_height'	 => isset( $control['height'] ) ? (int) $control['height'] : ''
				);
			default:
				return array();
		}

	}





	public function has_raw_setting(){
		if ( isset( $this->parsable_data->{'MSPanel.Settings'} ) && isset( $this->parsable_data->{'MSPanel.Settings'}->{'1'} ) )
			return true;
		return false;
	}


	public function get_raw_setting(){
		if ( $this->has_raw_setting() )
			return $this->parsable_data->{'MSPanel.Settings'}->{'1'};
		return null;
	}


	public function get_slider_setting( $force_new_parse = false ){
		$raw_setting = $this->get_raw_setting();

		if( is_null( $raw_setting ) ){
			return $this->parse_setting();
		}

		if( is_null( $this->recent_setting ) || $force_new_parse ) {
			$raw_json_decoded_setting = json_decode( $raw_setting, true );
			$this->recent_setting = $this->parse_setting( $raw_json_decoded_setting );
			$this->recent_setting = wp_parse_args( $this->get_controls_params() , $this->recent_setting );
			$this->recent_setting = wp_parse_args( $this->get_callbacks_params(), $this->recent_setting );
		}
		return $this->recent_setting;
	}


	/*--------------------------------------------------------------*/


	// is slides data passed in raw panel data?
	public function has_raw_slide() {
		if ( isset( $this->parsable_data->{'MSPanel.Slide'} ) )
			return true;
		return false;
	}


	public function get_raw_slides() {
		if ( $this->has_raw_slide() ) {
			return $this->parsable_data->{'MSPanel.Slide'};
		}
		return null;
	}


	public function get_parsable_slides() {

		if( ! $raw_slides = $this->get_raw_slides() ){
			return array();
		}

		$valid_slides  = array();
        $overlay_slide = array();

		foreach ( $raw_slides as $id => $raw_slide ) {
			$raw_json_decoded_slide = json_decode( $raw_slide, true );

            if( isset( $raw_json_decoded_slide['order'] ) && $raw_json_decoded_slide['order'] > -1 ){
                $valid_slides[ $raw_json_decoded_slide['order'] ] = $raw_json_decoded_slide;
            } else {
                $overlay_slide = $raw_json_decoded_slide;
            }
		}

		ksort( $valid_slides );
        array_unshift( $valid_slides, $overlay_slide );

        return $valid_slides;
	}


	public function get_slides( $force_new_parse = false ) {

		if( is_null( $this->recent_slides ) || $force_new_parse ) {

			$parsable_slides = $this->get_parsable_slides();

			if ( empty( $parsable_slides ) )
				return  $parsable_slides;

			$slides = array();

			foreach ( $parsable_slides as $slide ) {
				$slides[] = $this->parse_slide( $slide );
			}

			$this->recent_slides = $slides;
		}
		return $this->recent_slides;
	}


	public function get_parent_of_layer( $layer_id ){

		$slides = $this->get_slides();

		foreach ( $slides as $key => $slide ) {
			if( is_array( $slide['layer_ids'] ) && in_array( $layer_id, $slide['layer_ids'] ) ){
				return $slide;
            }
		}

		return null;
	}


	/*--------------------------------------------------------------*/


	public function has_raw_layer() {
		if ( isset( $this->parsable_data->{'MSPanel.Layer'} ) )
			return true;
		return false;
	}


	public function get_raw_layers() {
		if ( $this->has_raw_layer() ) {
			return $this->parsable_data->{'MSPanel.Layer'};
		}
		return null;
	}


	public function get_parsable_layers() {

		if( ! $raw_layers = $this->get_raw_layers() ){
			return array();
		}

		// stores layers by layer order
		$layers_by_order = array();

		// collect layers by layer order
		foreach ( $raw_layers as $id => $raw_layer ) {
			$raw_json_decoded_layer = json_decode( $raw_layer, true );
			$layers_by_order[ $raw_json_decoded_layer['id'] ] = $raw_json_decoded_layer;
		}

		return $layers_by_order;
	}


	public function get_layers( $force_new_parse = false ) {

		if( is_null( $this->recent_layers ) || $force_new_parse ) {

			$parsable_layers = $this->get_parsable_layers();

			if ( empty( $parsable_layers ) )
				return  $parsable_layers;

			$layers = array();

			foreach ( $parsable_layers as $id => $layer ) {
				$layers[$id] = $this->parse_layer( $layer );
			}

			$this->recent_layers = $layers;
		}

		return $this->recent_layers;
	}


	/*--------------------------------------------------------------*/

    /**
     * Whether the raw custom CSS codes is set or not
     *
     * @return boolean [description]
     */
	public function has_raw_style() {
		if ( isset( $this->parsable_data->{'MSPanel.Style'} ) )
			return true;
		return false;
	}

    /**
     * Retrieves the raw custom CSS codes from Panel data
     *
     * @return string|null  Raw custom CSS code
     */
	public function get_raw_styles() {
		if ( $this->has_raw_style() ) {
			return $this->parsable_data->{'MSPanel.Style'};
		}
		return null;
	}

	public function get_parsable_styles() {

		if( ! $raw_styles = $this->get_raw_styles() ){
			return array();
		}

		$valid_styles = array();

		foreach ( $raw_styles as $id => $raw_style ) {
            // raw json decoded style
			$valid_styles[] = json_decode( $raw_style, true );
		}

		return $valid_styles;
	}


	public function get_styles_list( $force_new_parse = false ) {

		if( is_null( $this->recent_styles ) || $force_new_parse ) {

			$parsable_styles = $this->get_parsable_styles();

			if ( empty( $parsable_styles ) )
				return  array();

			$styles = array();

			foreach ( $parsable_styles as $id => $style ) {
				$styles[$id] = $this->parse_each_style( $style );
			}

			$this->recent_styles = $styles;
		}

		return $this->recent_styles;
	}


	public function get_styles( $force_new_parse = false ) {
		$styles_list = (array) $this->get_styles_list();

		// custom css code for sliders added
		$setting     = $this->get_slider_setting();
		$styles_list[] = $setting['custom_style'];

		return implode( $this->join_char, $styles_list );
	}


	/* Parsing Preset Styles -------------------------------------------------*/

    /**
     * Converts parsed presets data to list of CSS styles
     *
     * @param  string $parsable_preset_styles  Parsed presets data
     * @return string                          List of CSS styles for presets
     */
	private function get_preset_styles_list( $parsable_preset_styles ) {

		if ( empty( $parsable_preset_styles ) )
			return  $parsable_preset_styles;

		$preset_styles = array();

		foreach ( $parsable_preset_styles as $id => $preset_style ) {
			$preset_styles[$id] = $this->parse_each_style( $preset_style, 'preset' );
		}

		return $preset_styles;
	}

    /**
     * Converts parsed presets data to CSS styles
     *
     * @param  string $raw_preset_styles  Parsed presets data
     * @return string                     CSS styles for presets
     */
	public function preset_data_to_styles( $raw_preset_styles ){
		$valid_preset_styles = array();

		foreach ( $raw_preset_styles as $id => $raw_preset_style ) {
			$raw_json_decoded_preset_style = json_decode( $raw_preset_style, true );
			$valid_preset_styles[] = $raw_json_decoded_preset_style;
		}

		$preset_styles_list = $this->get_preset_styles_list( $valid_preset_styles );
		return implode( $this->join_char, $preset_styles_list );
	}

    /**
     * Extracts the presets raw data from Main Panel data and generates the CSS styles accordingly
     *
     * @param  string $raw_preset   Encoded and raw presets data
     * @return string               The CSS styles for presets
     */
	public function get_preset_styles( $raw_preset ) {

		$b64_decoded = msp_maybe_base64_decode( $raw_preset );
		$preset_data = json_decode( $b64_decoded );

		if ( ! isset( $preset_data->{'MSPanel.PresetStyle'} ) )
			return '';

		$raw_preset_styles = $preset_data->{'MSPanel.PresetStyle'};

		return $this->preset_data_to_styles( $raw_preset_styles );
	}


	/* Parsing Button Styles -------------------------------------------------*/

    /**
     * Converts parsed buttons data to list of CSS styles
     *
     * @param  string $parsable_buttons_styles Parsed buttons data
     * @return string                          List of CSS styles for buttons
     */
	private function get_buttons_styles_list( $parsable_buttons_styles ) {

		if ( empty( $parsable_buttons_styles ) )
			return  $parsable_buttons_styles;

		$buttons_styles = array();

		foreach ( $parsable_buttons_styles as $id => $button_style ) {
			if( ! isset( $button_style['className'] ) ) continue;

			if( isset( $button_style['normal'] ) )
				$button_styles[] = sprintf( ".%s{ %s }", $button_style['className'], str_replace("\n", "", $button_style['normal'] ) );
			if( isset( $button_style['hover'] ) )
				$button_styles[] = sprintf( ".%s:hover{ %s }", $button_style['className'], str_replace("\n", "", $button_style['hover'] ) );
			if( isset( $button_style['active'] ) )
				$button_styles[] = sprintf( ".%s:active{ %s }", $button_style['className'], str_replace("\n", "", $button_style['active'] ) );
		}

		return $button_styles;
	}


    /**
     * Converts parsed buttons data to CSS styles
     *
     * @param  string $raw_buttons_styles Parsed buttons data
     * @return string                     CSS styles for buttons
     */
	public function buttons_data_to_styles( $raw_buttons_styles ){
		$valid_buttons_styles = array();

		foreach ( $raw_buttons_styles as $id => $raw_buttons_style ) {
			$raw_json_decoded_buttons_style = json_decode( $raw_buttons_style, true );
			$valid_buttons_styles[] = $raw_json_decoded_buttons_style;
		}

		$buttons_styles_list = $this->get_buttons_styles_list( $valid_buttons_styles );
		return implode( $this->join_char. " ", $buttons_styles_list );
	}


    /**
     * Extracts the buttons raw data from Main Panel data and generates the button styles accordingly
     *
     * @param  string $raw_buttons  Encoded and raw buttons data
     * @return string               The buttons CSS styles
     */
	public function get_buttons_styles( $raw_buttons ) {

		$b64_decoded = msp_maybe_base64_decode( $raw_buttons );
		$buttons_data = json_decode( $b64_decoded );

		if ( ! isset( $buttons_data->{'MSPanel.ButtonStyle'} ) )
			return '';

		$raw_buttons_styles = $buttons_data->{'MSPanel.ButtonStyle'};
		return $this->buttons_data_to_styles( $raw_buttons_styles );
	}


	/*--------------------------------------------------------------*/


	public function parser_slider( $force_new_parse = false ) {
		$this->get_slider_setting( $force_new_parse );
		$this->get_layers( $force_new_parse );
		$this->get_slides( $force_new_parse );
		$this->get_styles( $force_new_parse );
	}


	public function get_results( $force_new_parse = false ) {
		$result = array();

		$result['setting'] = $this->get_slider_setting( $force_new_parse );
		$result['layers']  = $this->get_layers( $force_new_parse );
		$result['slides']  = $this->get_slides( $force_new_parse );
		$result['styles']  = $this->get_styles( $force_new_parse );

		return $result;
	}


	/**
     * pretty human readable print for parsed data
     * @return void
     */
	public function pretty_print() {
		axpp( $this->parsable_data );
	}


}
