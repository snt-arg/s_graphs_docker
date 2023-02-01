<?php
/********************* META BOX DEFINITIONS ***********************/

/**
 * Prefix of meta keys (optional)
 * Use underscore (_) at the beginning to make keys hidden
 * Alt.: You also can make prefix empty to disable it
 */
// Better has an underscore as last sign

add_filter( 'rwmb_meta_boxes', 'be_themes_register_meta_boxes' );

function be_themes_register_meta_boxes( $meta_boxes )
{
	$prefix = 'be_themes_';

	/****************************
	PORTFOLIO POST TYPE METABOXES
	****************************/
	// Oshine Portfolio Post Type
	$meta_boxes[] = array (
		'id' => 'portfolio',
		'title' => 'OSHINE - Portfolio Options',
		'pages' => array( 'portfolio' ),
		'context' => 'normal',
		'priority' => 'high',

		'tabs' =>  array(
				'general' => array(
					'label' => __( 'Single Portfolio Settings', 'rwmb' ),
					'icon'  => '', // Dashicon
				),
				'slider_settings'  => array(
					'label' => __( 'Slider Settings', 'rwmb' ),
					'icon'  => '', // Dashicon
				),
				'portfolio_details'  => array(
					'label' => __( 'Portfolio Details', 'rwmb' ),
					'icon'  => '', // Dashicon
				),
				'thumbnail'  => array(
					'label' => __( 'Portfolio Grid - Thumbnail Settings', 'rwmb' ),
					'icon'  => '', // Dashicon
				),
			),

		// Tab style: 'default', 'box' or 'left'. Optional
		'tab_style' => 'left',
		
		// Show meta box wrapper around tabs? true (default) or false. Optional
		'tab_wrapper' => true,

		'fields' => array(

			// SINGLE PORTFOLIO STYLE TAB
			array (
				'name'	=>	__('Portfolio Style','oshin'),
				'id'	=>	"{$prefix}single_portfolio_slider_note6",
				'desc'	=>	'',
				'type'	=>	'heading',
				'std'  	=>	0,
				'tab'	=> 'general'
			),
			array (
				'name'	=> __('Portfolio Single Page Style','oshin'),
				'id'	=> "{$prefix}portfolio_single_page_style",
				'desc'	=> 'Advanced Settings for SLIDER type portfolio is given under Slider Settings tab',
				'type' 	=> 'select',
				'options'	=> array (
					'normal' => 'Single Page - Page Builder',
					'style1' => 'Horizontal Carousel Slider',
					'style2' => 'Centered Slider',
					'style3' => 'Full Screen Slider',
					'style4' => 'Vertical Screen Slider',
					'be-ribbon-carousel' => 'Ribbon Carousel Slider',
					'be-center-carousel' => 'Center Slide Carousel Slider',
					'lightbox' => 'LightBox',
					'lightbox-gallery' => 'LightBox Gallery',
					'floting-right' => 'Single Page - Floating Right Sidebar',
					'floting-left' => 'Single Page - Floating Left Sidebar',
					'fixed-left' => 'Single Page - Fixed Left Sidebar',
					'fixed-right' => 'Single Page - Fixed Right Sidebar',
					'fixed-overflow-left' => 'Single Page - Fixed Right Sidebar with Overflow Images',
					'fixed-overflow-right'	=> 'Single Page - Fixed Left Sidebar with Overflow Images',
					'none' => 'None',
				),
				'std'  => 'normal',
				'tab'		=> 'general'
			),
			array (
				'name'		=> __('Portfolio Images','oshin'),
				'id'	=> "{$prefix}single_portfolio_slider_images",
				'desc'		=> '',
				'type'		=> 'image_advanced',
				// 'max_file_uploads' => '',
				'tab'		=> 'general',
				// 'visible'	=> array('be_themes_portfolio_single_page_style','!=','normal')
			),
			array (
				'name'	=> __('Animation Style','oshin'),
				'id'	=> "{$prefix}single_portfolio_floting_images_style",
				'desc'	=> '',
				'type' 	=> 'select',
				'options'	=> array (
					'none' => 'None',
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
					'infiniteJump' => 'infiniteJump'
				),
				'std'  => 'none',
				'tab'		=> 'general',
				'visible'	=> array('be_themes_portfolio_single_page_style','in',array('floting-right','floting-left','fixed-left','fixed-right','fixed-overflow-left', 'fixed-overflow-right'))
			),
			array (
				'name'	=>	__('Image Area Width','oshin'),
				'id'	=>	"{$prefix}fixed_sidebar_image_width",
				'desc'	=>	'',
				'type'	=>	'slider',
				'suffix' => '%',
				'js_options' => array(
								'min'   => 30,
								'max'   => 90,
								'step'  => 1,
							),
				'std' => 70,
				'tab'	=> 'general',
				'visible'	=> array('be_themes_portfolio_single_page_style','in',array('fixed-left','fixed-right'))
			),
			array (
				'name' => __('Image Padding','oshin'),
				'id'   => "{$prefix}fixed_sidebar_image_padding",
				'desc'	=> '',
				'type' => 'slider',
				'std'  => '30',
				'suffix' => 'px',
				'tab'		=> 'general',
				'visible'	=> array('be_themes_portfolio_single_page_style','in',array('fixed-left','fixed-right'))
			),
			array (
				'name'	=>	__('Portfolio Title Bar','oshin'),
				'id'	=>	"{$prefix}single_portfolio_slider_note5",
				'desc'	=>	'',
				'type'	=>	'heading',
				'std'  	=>	0,
				'tab'	=> 'general'
			),
			array (
				'name' => __('Show Porfolio Title and Navigation Bar','oshin'),
				'id'   => "{$prefix}portfolio_title_nav",
				'type' => 'checkbox',
				'std'  => '',
				'tab'		=> 'general'
			),
			array (
				'name' => __('Navigate within Category','oshin'),
				'id'   => "{$prefix}traverse_catg",
				'type' => 'checkbox',
				'std'  => '',
				'tab'		=> 'general',
				'visible'	=> array('be_themes_portfolio_title_nav', true),
			),
			array (
				'name' => __('Grid Icon URL <br/><span style="color: #878787; font-size: 10px;">Useful if Navigate within Category is enabled</span>','oshin'),
				'id'   => "{$prefix}portfolio_home_page",
				'desc'	=> 'Default : URL provided in Options Panel under Portfolio Settings',
				'type' => 'text',
				'std'  => '',
				'tab'		=> 'general',
				'visible'	=> array('be_themes_portfolio_title_nav', true),
			),
			// PORTFOLIO DETAILS TAB
			array (
				'name'	=>	__('Portfolio Details','oshin'),
				'id'	=>	"{$prefix}single_portfolio_slider_note4",
				'desc'	=>	'To publish these details in the Front End, use the Portfolio Details module in the Page Builder',
				'type'	=>	'heading',
				'std'  	=>	0,
				'tab'	=> 'portfolio_details'
			),
			array (
				'name'		=> __('Client Name','oshin'),
				'id'	=> "{$prefix}portfolio_client_name",
				'desc'		=> '',
				'type'		=> 'text',
				'std'		=> '',
				'tab'		=> 'portfolio_details'
			),		
			array (
				'name'		=> __('Project Date','oshin'),
				'id'	=> "{$prefix}portfolio_project_date",
				'desc'		=> '',
				'type'		=> 'text',
				'std'		=> '',
				'tab'		=> 'portfolio_details'
			),
			array (
				'name'		=> __('Project URL','oshin'),
				'id'	=> "{$prefix}portfolio_visitsite_url",
				'desc'		=> 'VIEW PROJECT button will appear if a Project URL is provided',
				'type'		=> 'text',
				'tab'		=> 'portfolio_details'
			),

			// MAIN SETTINGS
			array (
				'name'	=>	__('SLIDER - Main Settings','oshin'),
				'id'	=>	"{$prefix}single_portfolio_slider_note1",
				'desc'	=>	'',
				'type'	=>	'heading',
				'std'  	=>	0,
				'tab'	=> 'slider_settings',
				'hidden'	=> array('be_themes_portfolio_single_page_style','=','style4')
			),
			array (
				'name'	=>	__('Gutter Width','oshin'),
				'id'	=>	"{$prefix}horizontal_carousel_slider_gutter_width",
				'desc'	=>	'In Pixels (Default : 0px)',
				'type'	=>	'text',
				'std'  	=>	0,
				'tab'	=> 'slider_settings'
			),
			array (
				'name'	=>	__('Slider Height','oshin'),
				'id'	=>	"{$prefix}horizontal_carousel_slider_height",
				'desc' => 'In Percentage (0-100)',
				'type'	=>	'text',
				'std'  	=>	'',
				'tab'	=> 'slider_settings'
			),
			array (
				'name' => __('Enable Loop','oshin'),
				'id'   => "{$prefix}swiper_slider_loop_control",
				'type' => 'checkbox',
				'std'  => 1,
				'tab'	=> 'slider_settings'
			),
			array (
				'name' => __('Enable Auto Play <br><span style="color:#878787; font-size:10px;">Auto-playing will stop when the gallery is clicked or an Image is selected</span></br>','oshin'),
				'id'   => "{$prefix}swiper_slider_autoslide_control",
				'type' => 'checkbox',
				'std'  => 1,
				'tab'	=> 'slider_settings'
			),
			array (
				'name' => __('Auto Play Duration','oshin'),
				'id'   => "{$prefix}swiper_slider_autoslide_duration",
				'desc' => 'In milliseconds (Default : 5000ms)',
				'type' => 'text',
				'std'  => 5000,
				'tab'	=> 'slider_settings'
			),
			array (
				'name' => __('Enable Keyboard Control','oshin'),
				'id'   => "{$prefix}swiper_slider_keyboard_control",
				'type' => 'checkbox',
				'std'  => 1,
				'tab'	=> 'slider_settings'
			),
			array (
				'name' => __('Show Slide Counts','oshin'),
				'id'   => "{$prefix}swiper_slide_counts",
				'type' => 'checkbox',
				'std'  => 1,
				'tab'	=> 'slider_settings'
			),
			array (
				'name' => __('Disable Vertical Stacked Display in Mobile','oshin'),
				'id'   => "{$prefix}swiper_slide_one_by_one_mobile",
				'type' => 'checkbox',
				'std'  => 0,
				'tab'	=> 'slider_settings'
			),
			//CAROUSEL THUMBNAIL SETTINGS
			array (
				'name'	=>	__('Slider - Thumbnail Bar Settings','oshin'),
				'id'	=>	"{$prefix}single_portfolio_slider_note2",
				'desc'	=>	'',
				'type'	=>	'heading',
				'std'  	=>	0,
				'tab'	=> 'slider_settings'
			),
			array (
				'name' => __('Enable Slider Thumbnails bar','oshin'),
				'id'   => "{$prefix}single_show_carousel_bar",
				'type' => 'checkbox',
				'std'  => 1,
				'tab'	=> 'slider_settings'
			),	
			array (
				'name' => __('Show Thumbnails bar','oshin'),
				'id'   => "{$prefix}swiper_carousel_bar_device_opt",
				'type' => 'select',
				'options'=>array (
					'show-all-devices' => 'In All devices', 
					'show-desktop-only' => 'In Desktop Only'
				),
				'std'  => 'show-all-devices',
				'desc' => '',
				'tab'	=> 'slider_settings'
			),
			array (
				'name' => __('Thumbnail Layout','oshin'),
				'id'   => "{$prefix}swiper_carousel_bar_style",
				'type' => 'select',
				'options'=>array (
					'be-full-width' => 'Full Width', 
					'be-wrap' => 'Wrapped',
				),
				'std'  => 'be-full-width',
				'desc' => '',
				'tab'	=> 'slider_settings'
			),
			// OTHER SETTINGS
			array (
				'name'	=>	__('SLIDER - Other Settings','oshin'),
				'id'	=>	"{$prefix}single_portfolio_slider_note3",
				'desc'	=>	'',
				'type'	=>	'heading',
				'std'  	=>	0,
				'tab'	=> 'slider_settings'
			),
			array (
				'name' => __('Show Information box','oshin'),
				'id'   => "{$prefix}single_show_info_box",
				'type' => 'checkbox',
				'std'  => 1,
				'tab'	=> 'slider_settings'
			),
			array (
				'name' => __('Information box Style <br><span style="color:#878787; font-size:10px;">The option is applicable only on Ribbon Carousel and Center Slide Carousel</span></br>','oshin'),
				'id'   => "{$prefix}info_box_style",
				'type' => 'radio',
				'options'	=> array (
					'floating_panel' => 'Floating Panel',
					'starting_slide' => 'As First Slide',
				),
				'std'  => 'floating_panel',
				'tab'  => 'slider_settings',
				// 'visible' => array(
				//     array('be_themes_single_show_info_box',true),
				//     array('be_themes_single_page_style', '=', 'be-ribbon-carousel')
				// )
			),	
			array (
				'name' => __('Enable Normal/Free Scroll','oshin'),
				'id'   => "{$prefix}single_horizontal_vertical_slider_normal_scroll",
				'type' => 'checkbox',
				'std'  => 1,
				'tab'	=> 'slider_settings'
			),
			array (
				'name' => __('Enable Slider Navigation Arrows','oshin'),
				'id'   => "{$prefix}swiper_slider_nav_arrows",
				'type' => 'checkbox',
				'std'  => 1,
				'tab'	=> 'slider_settings'
			),
			// OVERLAY SETTINGS
			array (
				'name' => __('Enable Overlay','oshin'),
				'id'   => "{$prefix}single_horizontal_slider_enable_overlay",
				'type' => 'checkbox',
				'std'  => 1,
				'tab'	=> 'slider_settings'
			),
			array (
				'name' => __('Overlay Background Color','oshin'),
				'id' => "{$prefix}single_horizontal_slider_overlay_color",
				'desc' => '',
				'type' => 'color',
				'std' => '',
				'tab'	=> 'slider_settings'
			),
			array (
				'name' => __('Overlay Background Opacity','oshin'),
				'id' => "{$prefix}single_horizontal_slider_overlay_color_opacity",
				'desc' => 'In Percentage (0-100)',
				'type' => 'text',
				'std' => 85,
				'tab'	=> 'slider_settings'
			),
			//GRID THUMBNAIL SETTINGS TAB
			
			array (
				'name'	=>	__('Portfolio Grid - Thumbnail Settings','oshin'),
				'id'	=>	"{$prefix}single_portfolio_slider_note3",
				'desc'	=>	'',
				'type'	=>	'heading',
				'std'  	=>	0,
				'tab'	=> 'thumbnail'
			),
			array (
				'name' => __('Open Thumbnail in New tab','oshin'),
				'id'   => "{$prefix}portfolio_open_new_tab",
				'type' => 'checkbox',
				'std'  => '',
				'tab'		=> 'thumbnail'
			),		
			array (
				'name'		=> __('Link Thumbnail To','oshin'),
				'id'	=> "{$prefix}portfolio_link_to",
				'desc'		=> '',
				'type' => 'radio',
				'options'	=> array (
					'single_portfolio' => 'Single Portfolio Page',
					'external_url' => 'External Url',
				),
				'std'  => 'single_portfolio',
				'tab'		=> 'thumbnail'
			),
			array (
				'name'		=> __('External URL','oshin'),
				'id'	=> "{$prefix}portfolio_external_url",
				'desc'		=> 'If thumbnail should be linked to external site.',
				'type'		=> 'text',
				'tab'		=> 'thumbnail'
			),
			array (
				'name' => __('Double Width','oshin'),
				'id'   => "{$prefix}width_wide",
				'type' => 'checkbox',
				'std'  => '',
				'tab'		=> 'thumbnail'
			),
			array (
				'name' => __('Double Height','oshin'),
				'id'   => "{$prefix}height_wide",
				'type' => 'checkbox',
				'std'  => '',
				'tab'		=> 'thumbnail'
			),
			array (
				'name'		=> __('Overlay Color','oshin'),
				'id'	=> "{$prefix}single_overlay_color",
				'desc'		=> '',
				'type'		=> 'color',
				'std'		=> '',
				'tab'		=> 'thumbnail'
			),
			array (
				'name' => __('Overlay Opacity','oshin'),
				'id' => "{$prefix}single_overlay_color_opacity",
				'desc' => 'In Percentage (0-100)',
				'type' => 'text',
				'std' => 85,
				'tab'		=> 'thumbnail'
			),
			array (
				'name'		=> __('Portfolio Title Color','oshin'),
				'id'	=> "{$prefix}single_overlay_title_color",
				'desc'		=> '',
				'type'		=> 'color',
				'std'		=> '',
				'tab'		=> 'thumbnail'
			),
			array (
				'name'		=> __('Portfolio Categories Color','oshin'),
				'id'	=> "{$prefix}single_overlay_cat_color",
				'desc'		=> '',
				'type'		=> 'color',
				'std'		=> '',
				'tab'		=> 'thumbnail'
			),
		)
	);
	/****************************
	BLOG POST METABOXES
	****************************/
	// Oshine Post Format 
	$meta_boxes[] = array (
		'id' => 'post_format_options',
		'title' => 'Post Format Options',
		'pages' => array( 'post' ),
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array (
			array (
				'name'		=> __('Youtube / Vimeo Video Url','oshin'),
				'id'	=> "{$prefix}video_url",
				'desc'		=> '',
				'type'		=> 'text',
				'std'		=> ''
			),
			array (
				'name'		=> __('Audio Embed Code Or Link to an Audio File','oshin'),
				'id'	=> "{$prefix}audio_url",
				'desc'		=> '',
				'type'		=> 'text',
				'std'		=> ''
			),
			array (
				'name'		=> __('Link Post Format URL','oshin'),
				'id'	=> "{$prefix}link_format",
				'desc'		=> '',
				'type'		=> 'text',
				'std'		=> ''
			),
			array (
				'name'		=> __('Quote Post Format Author','oshin'),
				'id'	=> "{$prefix}quote_author",
				'desc'		=> '',
				'type'		=> 'text',
				'std'		=> ''
			),						
			array (
				'name'		=> __('Gallery Post Format Images','oshin'),
				'id'	=> "{$prefix}gal_post_format",
				'desc'		=> '',
				'type'		=> 'image_advanced',
				// 'max_file_uploads' => 10,
			)
		)
	);
	/****************************
	BLOG MASONRY STYLE (2) THUMBNAIL OPTIONS
	****************************/
	// Oshine Post Format 
	$meta_boxes[] = array (
		'id' => 'post_masonry_2_options',
		'title' => 'Masonry Style 2 Thumbnail Options',
		'pages' => array( 'post' ),
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array (
			array (
				'name'		=> __('Quote/Link style Post Background','oshin'),
				'id'   => "{$prefix}thumbnail_bg_color",
				'type' => 'color',
				'std'  => ''
			),
			array (
				'name'		=> __('Quote/Link Post Color ','oshin'),
				'id'   => "{$prefix}post_text_color",
				'type' => 'color',
				'std'  => ''
			)
		)
	);
	/****************************
	BLOG METRO STYLE THUMBNAIL OPTIONS
	****************************/
	// Oshine Post Format 
	$meta_boxes[] = array (
		'id' => 'post_metro_thumbnail_options',
		'title' => 'Metro Style Post Thumbnail Options',
		'pages' => array( 'post' ),
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array (
			array (
				'name'		=> __('Enable Double Width','oshin'),
				'id'   => "{$prefix}blog_double_width",
				'type' => 'checkbox',
				'std'  => ''
			),
			array (
				'name'		=> __('Enable Double Height','oshin'),
				'id'   => "{$prefix}blog_double_height",
				'type' => 'checkbox',
				'std'  => ''
			)
		)
	);

	/****************************
	PAGE METABOXES
	****************************/
	// Oshine Header Hero Section
	$meta_boxes[] = array (
		'id' => 'header_hero_section',
		'title' => 'OSHINE - Header Hero Section Options',
		'pages' => array( 'post', 'page','portfolio', 'product' ),
		'context' => 'normal',
		'priority' => 'high',

		'tabs' =>  array(
				'general' => array(
					'label' => __( 'General Settings', 'rwmb' ),
					'icon'  => '', // Dashicon
				),
				'image_settings'  => array(
					'label' => __( 'Background Image/Color', 'rwmb' ),
					'icon'  => '', // Dashicon
				),
				'video_settings'  => array(
					'label' => __( 'Background Video', 'rwmb' ),
					'icon'  => '', // Dashicon
				),
				'overlay_settings'  => array(
					'label' => __( 'Overlay Settings', 'rwmb' ),
					'icon'  => '', // Dashicon
				),
				'scroll_indicator'  => array(
					'label' => __( 'Scroll Indicator Settings', 'rwmb' ),
					'icon'  => '', // Dashicon
				),
				'canvas_settings'  => array(
					'label' => __( 'Canvas Settings', 'rwmb' ),
					'icon'  => '', // Dashicon
				),
			),
		'tab_style' => 'left',
		'tab_wrapper' => true,
		'fields' => array (
			array (
				'name'	=>	__('Header Settings','oshin'),
				'id'	=>	"{$prefix}hero_section_note1",
				'desc'	=>	'',
				'type'	=>	'heading',
				'std'  	=>	0,
				'tab'	=> 'general'
			),
			array (
				'name' => __('Header Background Style','oshin'),
				'id'   => "{$prefix}header_transparent",
				'type' => 'select',
				'options'=> array('none' => 'Default', 'transparent'=>'Transparent', 'semitransparent'=>'Semi-Transparent'),
				'std'  => '',
				'tab'  => 'general',
			),
			array (
				'name' => __('Logo and Navigation Color Scheme<br><span style="color:#878787; font-size:10px;">Applicable only for Transparent/Semi Transparent header</span></br>','oshin'),
				'id'   => "{$prefix}header_transparent_color_scheme",
				'type' => 'select',
				'options'=> array('none' => 'Default', 'dark' => 'Dark', 'light' => 'Light'),
				'std'  => 'dark',
				'tab'  => 'general',
				'visible' => array(
					'when' => array(
						array( 'be_themes_header_transparent', '!=', 'none' ),
						array( 'be_themes_hero_section', '!=', 'none' ),
					),
					'relation' => 'and',
				),
			),
			array (
				'name' => __('Sticky Header','oshin'),
				'id'   => "{$prefix}sticky_header",
				'type' => 'select',
				'options'=> array('inherit' => 'Inherit From Option panel', 'yes' => 'Yes', 'no' => 'No'),
				'std'  => 'inherit',
				'desc' => '',
				'tab'  => 'general'
			),
			array (
				'name'	=>	__('Hero Section Settings','oshin'),
				'id'	=>	"{$prefix}hero_section_note2",
				'desc'	=>	'',
				'type'	=>	'heading',
				'std'  	=>	0,
				'tab'	=> 'general'
			),
			array (
				'name' => __('Hero Section Type','oshin'),
				'id'   => "{$prefix}hero_section",
				'type' => 'select',
				'options'=> array('slider'=>'Slider', 'custom'=>'Image/Video', 'none' => 'None'),
				'std'  => 'none',
				'desc' => '',
				'tab'  => 'general'
			),
			array (
				'name'		=> __('Slider Shortcode','oshin'),
				'id'	=> "{$prefix}hero_section_slider_shortcode",
				'desc'		=> '',
				'type'		=> 'textarea',
				'std'		=> '',
				'hidden' => array( 'be_themes_hero_section', '!=', 'slider' ),
				'tab'  => 'general',
			),
			array (
				'name' => __('Custom Height<br><span style="color:#878787; font-size:10px;">Leave this Blank for a Full Screen Hero Section</span></br>','oshin'),
				'id'   => "{$prefix}hero_section_custom_height",
				'type' => 'text',
				'std'  => '',
				'tab'  => 'general'
			),
			array (
				'name' => __('Hero Section Position <br><span style="color:#878787; font-size:10px;">Applicable only for non-transparent header</span></br>','oshin'),
				'id'   => "{$prefix}hero_section_position",
				'type' => 'select',
				'options'=> array('after' => 'After Header' , 'before' => 'Before Header'),
				'std'  => 'after',
				'desc' => '',
				'tab'  => 'general',
				'hidden' => array( 'be_themes_header_transparent', '!=', 'none' ),
			),
			array (
				'name' => __('Show With Header<br><span style="color:#878787; font-size:10px;">Applicable only if header is non-transparent, Hero Section position is Before Header and no Custom Height is defined</span></br>','oshin'),
				'id'   => "{$prefix}hero_section_with_header",
				'type' => 'radio',
				'options'=> array('yes' => 'Yes', 'no' => 'No'),
				'std'  => 'no',
				'desc' => '',
				'tab'  => 'general',
				'visible' => array(
				    array('be_themes_header_transparent', '=' , 'none'),
				    array('be_themes_hero_section_custom_height', '=', ''),
				    array('be_themes_hero_section_position', '=' , 'before')
				)
			),
			
			//BACKGROUND IMAGE SETTINGS
			array (
				'name'	=>	__('Background Settings','oshin'),
				'id'	=>	"{$prefix}hero_section_note4",
				'desc'	=>	'',
				'type'	=>	'heading',
				'std'  	=>	0,
				'tab'	=> 'image_settings'
			),
			array (
				'name'		=> __('Background Color','oshin'),
				'id'	=> "{$prefix}hero_section_bg_color",
				'desc'		=> '',
				'type'		=> 'color',
				'std'		=> '',
				'tab'  => 'image_settings'
			),
			array (
				'name'		=> __('Background Image','oshin'),
				'id'	=> "{$prefix}hero_section_bg_image",
				'desc'		=> '',
				'type'		=> 'image_advanced',
				'max_file_uploads' => 1,
				'tab'  => 'image_settings'
			),
			array (
				'name' => __('Background Repeat','oshin'),
				'id'   => "{$prefix}hero_section_bg_repeat",
				'type' => 'select',
				'options'=> array('repeat' => 'Repeat', 'repeat-x' => 'Repeat-x', 'four' => 'Four', 'repeat-y' => 'Repeat-y', 'no-repeat' => 'No Repeat'),
				'std'  => 'repeat',
				'desc' => '',
				'tab'  => 'image_settings'
			),
			array (
				'name' => __('Background Attachment','oshin'),
				'id'   => "{$prefix}hero_section_bg_attachment",
				'type' => 'select',
				'options'=> array('scroll' => 'Scroll', 'fixed' => 'Fixed'),
				'std'  => 'scroll',
				'desc' => '',
				'tab'  => 'image_settings'
			),
			array (
				'name' => __('Background Position','oshin'),
				'id'   => "{$prefix}hero_section_bg_position",
				'type' => 'select',
				'options'=> array('top left' => 'Top Left', 'top right' => 'Top Right', 'top center' => 'Top Center', 'center left' => 'Center Left', 'center right' => 'Center Right', 'center center' => 'Center Center', 'bottom left' => 'Bottom Left', 'bottom right' => 'Bottom Right', 'bottom center' => 'Bottom Center'),
				'std'  => 'top left',
				'desc' => '',
				'tab'  => 'image_settings'
			),
			array (
				'name' => __('Scale Image to Fill Container','oshin'),
				'id'   => "{$prefix}hero_section_bg_scale",
				'type' => 'checkbox',
				'std'  => '',
				'tab'  => 'image_settings'
			),
			array (
				'name' => __('Background Animation','oshin'),
				'id'   => "{$prefix}hero_section_bg_animation",
				'type' => 'select',
				'options'=> array(
					'none' => 'None', 
					'be-bg-parallax' => 'Parallax',
					//'be-bg-mousemove-parallax' => 'Mouse Move',
					'background-horizontal-animation' => 'Horizontal Loop Animation',
					'background-vertical-animation' => 'Vertical Loop Animation'
				),
				'std'  => 'scroll',
				'desc' => '',
				'tab'  => 'image_settings'
			),

			//CANVAS SETTINGS
			array (
				'name'	=>	__('Canvas Settings','oshin'),
				'id'	=>	"{$prefix}hero_section_note5",
				'desc'	=>	'',
				'type'	=>	'heading',
				'std'  	=>	0,
				'tab'	=> 'canvas_settings'
			),
			array (
				'name' => __('Animation Canvas on Background','oshin'),
				'id'   => "{$prefix}hero_section_bg_animation_canvas",
				'type' => 'select',
				'options'=> array(
					'none' => 'None', 
					'galaxy-canvas' => 'Galaxy',
					'waterdrops-canvas' => 'Waterdrops',
					'pattern-canvas' => 'Colored Pattern',
				),
				'std'  => 'none',
				'desc' => '',
				'tab'  => 'canvas_settings'
			),
			array (
				'name'		=> __('Canvas Color 1','oshin'),
				'id'	=> "{$prefix}hero_section_canvas_color1",
				'desc'		=> '',
				'type'		=> 'color',
				'std'		=> '',
				'tab'  => 'canvas_settings',
				'visible' => array( 'be_themes_hero_section_bg_animation_canvas', '!=', 'none' ),
			),
			array (
				'name'		=> __('Canvas Color 2','oshin'),
				'id'	=> "{$prefix}hero_section_canvas_color2",
				'desc'		=> '',
				'type'		=> 'color',
				'std'		=> '',
				'tab'  => 'canvas_settings',
				'visible' => array( 'be_themes_hero_section_bg_animation_canvas', 'not in', array('none','waterdrops-canvas') ),
			),
			array (
				'name'		=> __('Canvas Color 3','oshin'),
				'id'	=> "{$prefix}hero_section_canvas_color3",
				'desc'		=> '',
				'type'		=> 'color',
				'std'		=> '',
				'tab'  => 'canvas_settings',
				'visible' => array( 'be_themes_hero_section_bg_animation_canvas', '=', 'pattern-canvas' ),
			),
			array (
				'name'		=> __('Canvas Color 4','oshin'),
				'id'	=> "{$prefix}hero_section_canvas_color4",
				'desc'		=> '',
				'type'		=> 'color',
				'std'		=> '',
				'tab'  => 'canvas_settings',
				'visible' => array( 'be_themes_hero_section_bg_animation_canvas', '=', 'pattern-canvas' ),
			),
			array (
				'name'		=> __('Canvas Color 5','oshin'),
				'id'	=> "{$prefix}hero_section_canvas_color5",
				'desc'		=> '',
				'type'		=> 'color',
				'std'		=> '',
				'tab'  => 'canvas_settings',
				'visible' => array( 'be_themes_hero_section_bg_animation_canvas', '=', 'pattern-canvas' ),
			),

			//VIDEO SETTINGS
			array (
				'name'	=>	__('Video Settings','oshin'),
				'id'	=>	"{$prefix}hero_section_note6",
				'desc'	=>	'',
				'type'	=>	'heading',
				'std'  	=>	0,
				'tab'	=> 'video_settings'
			),
			array (
				'name' => __('Enable Background Video','oshin'),
				'id'   => "{$prefix}hero_section_bg_video",
				'type' => 'checkbox',
				'std'  => '',
				'tab'  => 'video_settings'
			),
			array (
				'name' => __('.MP4 Video File','oshin'),
				'id'   => "{$prefix}hero_section_bg_video_mp4",
				'type' => 'text',
				'std'  => '',
				'tab'  => 'video_settings',
				'visible' => array( 'be_themes_hero_section_bg_video', true ),
			),
			array (
				'name' => __('.OGG Video File','oshin'),
				'id'   => "{$prefix}hero_section_bg_video_ogg",
				'type' => 'text',
				'std'  => '',
				'tab'  => 'video_settings',
				'visible' => array( 'be_themes_hero_section_bg_video', true),
			),
			array (
				'name' => __('.Webm Video File','oshin'),
				'id'   => "{$prefix}hero_section_bg_video_webm",
				'type' => 'text',
				'std'  => '',
				'tab'  => 'video_settings',
				'visible' => array( 'be_themes_hero_section_bg_video', true ),
			),

			//OVERLAY SETTINGS
			array (
				'name'	=>	__('Overlay Settings','oshin'),
				'id'	=>	"{$prefix}hero_section_note7",
				'desc'	=>	'',
				'type'	=>	'heading',
				'std'  	=>	0,
				'tab'	=> 'overlay_settings'
			),
			array (
				'name' => __('Enable Overlay','oshin'),
				'id'   => "{$prefix}hero_section_overlay",
				'type' => 'checkbox',
				'std'  => '',
				'tab'  => 'overlay_settings',
			),
			array (
				'name'		=> __('Overlay Color','oshin'),
				'id'	=> "{$prefix}hero_section_bg_overlay_color",
				'desc'		=> '',
				'type'		=> 'color',
				'std'		=> '',
				'tab'  => 'overlay_settings',
				'visible' => array( 'be_themes_hero_section_overlay', true ),
			),
			array (
				'name' => __('Overlay Opacity','oshin'),
				'id'   => "{$prefix}hero_section_bg_overlay_opacity",
				'desc'	=>	'In Percentage (0-100)',
				'type' => 'text',
				'std'  => '',
				'tab'  => 'overlay_settings',
				'visible' => array( 'be_themes_hero_section_overlay', true ),
			),
			// CONTENT SETTINGS - GENERAL TAB
			array (
				'name'	=>	__('Hero Section Content Settings','oshin'),
				'id'	=>	"{$prefix}hero_section_note3",
				'desc'	=>	'',
				'type'	=>	'heading',
				'std'  	=>	0,
				'tab'	=> 'general'
			),
			array (
				'name'		=> __('Content','oshin'),
				'id'	=> "{$prefix}hero_section_content",
				'desc'		=> '',
				'type'		=> 'wysiwyg',
				'std'		=> '',
				'tab'  => 'general'
			),
			array (
				'name' => __('Content Container Wrap','oshin'),
				'id'   => "{$prefix}hero_section_container_wrap",
				'type' => 'radio',
				'options'=> array('yes' => 'Yes', 'no' => 'No'),
				'std'  => 'yes',
				'tab'  => 'general'
			),
			//SCROLL INDICATOR
			array (
				'name'	=>	__('Scroll Indicator Settings','oshin'),
				'id'	=>	"{$prefix}hero_section_note8",
				'desc'	=>	'',
				'type'	=>	'heading',
				'std'  	=>	0,
				'tab'	=> 'scroll_indicator'
			),
			array (
				'name' => __('Scroll Indicator Icon','oshin'),
				'id'   => "{$prefix}section_nav_icon",
				'type' => 'select',
				'options'=> array(
					'icon-arrow_carrot-down' => 'Icon Down',
					'icon-arrow-down4' => 'Triangle Down',
					'icon-mouse-wheel' => 'Mouse Wheel',

				),
				'std'  => 'icon-arrow_carrot-down',
				'desc' => '',
				'tab'  => 'scroll_indicator'
			),
			array (
				'name'	=> __('Scroll Indicator Icon Color','oshin'),
				'id'	=> "{$prefix}section_nav_icon_color",
				'desc'	=> '',
				'type'	=> 'color',
				'std'	=> '',
				'tab'  => 'scroll_indicator'
			),
			array (
				'name' => __('Link Scroll Indicator to (Enter SECTION ID)','oshin'),
				'id'   => "{$prefix}section_nav_id",
				'type' => 'text',
				'std'  => '',
				'tab'  => 'scroll_indicator'
			),
		)
	);
	// Oshine Gallery Page Template
	$meta_boxes[] = array (
		'id' => 'gallery_template_options',
		'title' => 'OSHINE - Gallery Page Template Options',
		'pages' => array( 'page' ),
		'show'   => array(
            'template'    => array( 'gallery.php' ),
		),
		'context' => 'normal',
		'priority' => 'high',
		'tabs' =>  array(
				'general' => array(
					'label' => __( 'Main Settings', 'rwmb' ),
					'icon'  => '', // Dashicon
				),
				'thumbnail_settings'  => array(
					'label' => __( 'Thumbnail Bar Settings', 'rwmb' ),
					'icon'  => '', // Dashicon
				),
				'other_settings'  => array(
					'label' => __( 'Other Settings', 'rwmb' ),
					'icon'  => '', // Dashicon
				),
			),
		'tab_style' => 'left',
		'tab_wrapper' => true,
		'fields' => array(
			array (
				'name'		=> __('Gallery Images','oshin'),
				'id'	=> "{$prefix}single_portfolio_slider_images",
				'desc'		=> '',
				'type'		=> 'image_advanced',
				// 'max_file_uploads' => '',
				'tab'  => 'general'
			),	
			array (
				'name'	=> __('Gallery Style','oshin'),
				'id'	=> "{$prefix}portfolio_single_page_style",
				'desc'	=> '',
				'type' 	=> 'select',
				'options'	=> array (
					'style1' => 'Horizontal Carousel Slider',
					'be-ribbon-carousel' => 'Ribbon Carousel Slider',
					'be-center-carousel' => 'Center Slide Carousel Slider',
					'style2' => 'Centered Slider',
					'style3' => 'Full Screen Slider',
					'style4' => 'Vertical Screen Slider',
				),
				'std'  => 'style1',
				'tab'  => 'general',
			),
			array (
				'name'	=>	__('Gutter Width','oshin'),
				'id'	=>	"{$prefix}horizontal_carousel_slider_gutter_width",
				'desc'	=>	'In Pixels (Default : 0px)',
				'type'	=>	'text',
				'std'  	=>	0,
				'tab'  => 'general',
				'visible' => array('be_themes_portfolio_single_page_style', 'not in', array('style3','style2','style4')),
			),
			array (
				'name'	=>	__('Gallery Height','oshin'),
				'id'	=>	"{$prefix}horizontal_carousel_slider_height",
				'desc'	=>	'In Percentage (0-100)',
				'type'	=>	'text',
				'std'  	=>	'',
				'tab'  => 'general',
				'visible' => array('be_themes_portfolio_single_page_style', 'not in', array('style3','style4')),
			),
			array (
				'name' => __('Enable Loop','oshin'),
				'id'   => "{$prefix}swiper_slider_loop_control",
				'type' => 'checkbox',
				'std'  => 1,
				'tab'  => 'general',
				'visible' => array('be_themes_portfolio_single_page_style','not in',array('style1','style4'))
			),
			array (
				'name' => __('Enable Auto Play <br><span style="color:#878787; font-size:10px;">Auto-playing will stop when the gallery is clicked or an Image is selected</span></br>','oshin'),
				'id'   => "{$prefix}swiper_slider_autoslide_control",
				'type' => 'checkbox',
				'std'  => 1,
				'tab'  => 'general',
				'visible' => array('be_themes_portfolio_single_page_style','not in',array('style1','style4'))
			),
			array (
				'name' => __('Auto Play Duration','oshin'),
				'id'   => "{$prefix}swiper_slider_autoslide_duration",
				'type' => 'text',
				'desc'	=>	'In millisecond (default : 5000ms)',
				'std'  => 5000,
				'tab'  => 'general',
				'visible' => array('be_themes_portfolio_single_page_style','not in',array('style1','style4'))
			),
			array (
				'name' => __('Enable Keyboard Control','oshin'),
				'id'   => "{$prefix}swiper_slider_keyboard_control",
				'type' => 'checkbox',
				'std'  => 1,
				'tab'  => 'general',
				'visible' => array('be_themes_portfolio_single_page_style','not in',array('style1','style4'))
			),
			array (
				'name' => __('Show Slide Counts','oshin'),
				'id'   => "{$prefix}swiper_slide_counts",
				'type' => 'checkbox',
				'std'  => 1,
				'tab'  => 'general',
				'visible' => array('be_themes_portfolio_single_page_style','not in',array('style1','style4'))
			),				
			array (
				'name' => __('Show Information box','oshin'),
				'id'   => "{$prefix}single_show_info_box",
				'type' => 'checkbox',
				'std'  => 1,
				'tab'  => 'other_settings'
			),
			array (
				'name' => __('Information box Style <br><span style="color:#878787; font-size:10px;">The option is applicable only on Ribbon Carousel and Center Slide Carousel</span></br>','oshin'),
				'id'   => "{$prefix}info_box_style",
				'type' => 'radio',
				'options'	=> array (
					'floating_panel' => 'Floating Panel',
					'starting_slide' => 'As First Slide',
				),
				'std'  => 'floating_panel',
				'tab'  => 'other_settings',
				// 'visible' => array(
				//     array('be_themes_portfolio_single_show_info_box',true),
				//     array('be_themes_portfolio_single_page_style', '=', 'be-ribbon-carousel')
				// )
			),		
			array (
				'name' => __('Enable Normal/Free Scroll','oshin'),
				'id'   => "{$prefix}single_horizontal_vertical_slider_normal_scroll",
				'type' => 'checkbox',
				'std'  => 0,
				'tab'  => 'other_settings',
				'visible' => array('be_themes_portfolio_single_page_style', 'not in', array('style3','style2','style4')),
			),	
			array (
				'name' => __('Enable Slider Navigation Arrows','oshin'),
				'id'   => "{$prefix}swiper_slider_nav_arrows",
				'type' => 'checkbox',
				'std'  => 1,
				'tab'  => 'other_settings',
				'hidden' => array('be_themes_single_horizontal_vertical_slider_normal_scroll', true),
			),
			array (
				'name' => __('Disable Vertical Stacked Display in Mobile','oshin'),
				'id'   => "{$prefix}swiper_slide_one_by_one_mobile",
				'type' => 'checkbox',
				'std'  => 0,
				'tab'  => 'general',
				'visible' => array('be_themes_portfolio_single_page_style','not in',array('style1','style4'))
			),
			array (
				'name' => __('Enable Thumbnails bar','oshin'),
				'id'   => "{$prefix}single_show_carousel_bar",
				'type' => 'checkbox',
				'std'  => 1,
				'tab'  => 'thumbnail_settings'
			),
			array (
				'name' => __('Show Thumbnails bar','oshin'),
				'id'   => "{$prefix}swiper_carousel_bar_device_opt",
				'type' => 'select',
				'options'=>array (
					'show-all-devices' => 'In All devices', 
					'show-desktop-only' => 'In Desktop Only'
				),
				'std'  => 'show-all-devices',
				'desc' => '',
				'visible' => array('be_themes_single_show_carousel_bar', true),
				'tab'  => 'thumbnail_settings'
			),
			array (
				'name' => __('Thumbnail Bar Layout','oshin'),
				'id'   => "{$prefix}swiper_carousel_bar_style",
				'type' => 'select',
				'options'=>array (
					'be-full-width' => 'Full Width', 
					'be-wrap' => 'Wrapped',
				),
				'std'  => 'be-full-width',
				'desc' => '',
				'visible' => array('be_themes_single_show_carousel_bar', true),
				'tab'  => 'thumbnail_settings'
			),	
			array (
				'name' => __('Enable Overlay','oshin'),
				'id'   => "{$prefix}single_horizontal_slider_enable_overlay",
				'type' => 'checkbox',
				'std'  => 0,
				'hidden' => array(
								'when' => array( array('be_themes_portfolio_single_page_style', 'in', array('style3','style2','style4')),
												 array('be_themes_single_horizontal_vertical_slider_normal_scroll', true)
										),
								'relation' => 'or'
							),
				'tab'  => 'other_settings'
			),
			array (
				'name' => __('Overlay Background Color','oshin'),
				'id' => "{$prefix}single_horizontal_slider_overlay_color",
				'desc' => '',
				'type' => 'color',
				'std' => '',
				'visible' => array('be_themes_single_horizontal_slider_enable_overlay', true),
				'tab'  => 'other_settings'
			),
			array (
				'name' => __('Overlay Background Color Opacity','oshin'),
				'id' => "{$prefix}single_horizontal_slider_overlay_color_opacity",
				'desc' => '',
				'type' => 'text',
				'desc'	=>	'In Percentage (0-100)',
				'std' => 85,
				'visible' => array('be_themes_single_horizontal_slider_enable_overlay', true),
				'tab'  => 'other_settings'
			),	

		)
	);
	// Oshine Portfolio Page Template
	$meta_boxes[] = array (
		'id' => 'portfolio_template_options',
		'title' => 'OSHINE - Portfolio Page Template Options',
		'pages' => array( 'page' ),
		'show'   => array(
            'template'    => array( 'portfolio.php' ),
		),
		'context' => 'normal',
		'priority' => 'high',
		'tabs' =>  array(
				'general' => array(
					'label' => __( 'Main Settings', 'rwmb' ),
					'icon'  => '', // Dashicon
				),
				'portfolio_categories'  => array(
					'label' => __( 'Portfolio Categories', 'rwmb' ),
					'icon'  => '', // Dashicon
				),
				'other_settings'  => array(
					'label' => __( 'Other Settings', 'rwmb' ),
					'icon'  => '', // Dashicon
				),
			),
		'tab_style' => 'left',
		'tab_wrapper' => true,
		'fields' => array (
			array (
				'name' => 'Portfolio Category',
				'id'   => "{$prefix}portfolio_taxonomy",
				'type' => 'taxonomy',
				'options' => array(
	        		'taxonomy' => 'portfolio_categories',
	        		'type' => 'checkbox_list',
	        		'args' => array( ),
	    		),
				'desc' => 'Choose the categories of Portfolio to be pulled.',
				'tab' => 'portfolio_categories'
			),
			array (
				'name'	=> __('Portfolio Style','oshin'),
				'id'	=> "{$prefix}portfolio_template_style",
				'desc'	=> '',
				'type' 	=> 'select',
				'options'	=> array (
					'style1' => 'Horizontal Carousel Slider',
					// 'be-ribbon-carousel' => 'Ribbon Carousel Slider',
					// 'be-center-carousel' => 'Center Slide Carousel Slider',
					'style2' => 'Vertical Screen Slider',
                    'style3' => 'Dual Carousel Slider',
                    'style4' => 'Split Screen',
                    'style5' => 'Title Carousel',   
				),
				'std'  => 'style1',
				'tab' => 'general'
            ),
            array (
                'name'  => __( 'Start from center', 'oshin' ),
                'id' => "{$prefix}title_carousel_start_from_center",
                'desc'  => __( 'Title Carousel will start from the middle slide', 'oshin' ),
                'type' => 'checkbox',
                'tab' => 'general',
                'std' => '1',
                'visible' => array('be_themes_portfolio_template_style', '=' , 'style5'),
            ),
            array (
                'name'  => __( 'Enable Mouse wheel Navigation', 'oshin' ),
                'id' => "{$prefix}title_carousel_mousewheel_nav",
                'type' => 'checkbox',
                'tab' => 'general',
                'std' => '0',
                'visible' => array('be_themes_portfolio_template_style', '=' , 'style5'),
            ),
			array (
				'name'	=>	__('Gutter Width','oshin'),
				'id'	=>	"{$prefix}portfolio_carousel_slider_gutter_width",
				'desc'	=>	'In Pixels (Default : 0px)',
				'type'	=>	'text',
				'std'  	=>	0,
				'visible' => array('be_themes_portfolio_template_style', 'in' , array('style1', 'be-ribbon-carousel', 'be-center-carousel')),
				'tab' => 'general'
			),
			// array (
			// 	'name'	=>	__('Image Container Width','oshin'),
			// 	'id'	=>	"{$prefix}hover_fade_image_width",
			// 	'desc'	=>	'In Percentage (0-100)',
            //     'type' => 'number',
            //     'min'  => 0,
            //     'max'  => 100,
            //     'step' => 1,
			// 	'std'  	=>	60,
			// 	'visible' => array('be_themes_portfolio_template_style', '=' , 'style4'),
			// 	'tab' => 'general'
            // ),
            array (
				'name'	=>	__('Portfolio Title Horizontal Alignment','oshin'),
				'id'	=>	"{$prefix}hover_fade_title_alignment",
				'type' 	=> 'select',
				'options'	=> array (
					'left' => 'Left',
                    'center' => 'Center',
                    'right' => 'Right',
				),
				'std'  => 'left',
				'visible' => array('be_themes_portfolio_template_style', '=' , 'style4'),
				'tab' => 'general'
            ),
            // array (
			// 	'name'	=>	__('Portfolio Title Top/Bottom Padding','oshin'),
			// 	'id'	=>	"{$prefix}hover_fade_title_top_pad",
            //     'type' => 'number',
            //     'min'  => 0,
            //     'step' => 1,
			// 	'visible' => array('be_themes_portfolio_template_style', '=' , 'style4'),
			// 	'tab' => 'general'
            // ),
            // array (
			// 	'name'	=>	__('Portfolio Title Left/Right Padding','oshin'),
			// 	'id'	=>	"{$prefix}hover_fade_title_left_pad",
            //     'type' => 'number',
            //     'min'  => 0,
            //     'step' => 1,
			// 	'visible' => array('be_themes_portfolio_template_style', '=' , 'style4'),
			// 	'tab' => 'general'
            // ),
            array (
				'name'	=>	__('Slider Height','oshin'),
				'id'	=>	"{$prefix}portfolio_carousel_slider_height",
				'desc'	=>	'In Percentage (0-100)',
				'type'	=>	'text',
				'std'  	=>	'',
				'visible' => array('be_themes_portfolio_template_style', 'in' , array('style1', 'be-ribbon-carousel', 'be-center-carousel')),
				'tab' => 'general'
			),
			array (
				'name'	=> __('Order','oshin'),
				'id'	=> "{$prefix}portfolio_template_item_order",
				'desc'	=> 'Items are ordered by Date of Creation',
				'type' 	=> 'select',
				'options'	=> array (
					'ASC' => 'Ascending',
					'DESC' => 'Descending',
				),
				'std'  => 'ASC',
				'tab' => 'general'
			),
			array (
				'name'	=> __('Slider Animation Style','oshin'),
				'id'	=> "{$prefix}dual_carousel_posrtfolio_animation_style",
				'desc'	=> 'Applied in Dual Carousel Slider',
				'type' 	=> 'select',
				'options'=> array (
					'fxSoftScale' => 'FxSoftScale', 
					'fxPressAway' => 'FxPressAway',
					'fxSideSwing' => 'FxSideSwing',
					'fxFortuneWheel' => 'FxFortuneWheel', 
					'fxSwipe' => 'FxSwipe', 
					'fxPushReveal' => 'FxPushReveal', 
					'fxSnapIn' => 'FxSnapIn', 
					'fxLetMeIn' => 'FxLetMeIn', 
					'fxStickIt' => 'FxStickIt', 
					'fxArchiveMe' => 'FxArchiveMe', 
					'fxVGrowth' => 'FxVGrowth', 
					'fxVGrowth' => 'FxSlideBehind', 
					'fxSoftPulse' => 'FxSoftPulse', 
					'fxEarthquake' => 'FxEarthquake', 
					'fxCliffDiving' => 'FxCliffDiving'
				),
				'std'=> 'fxSoftScale',
				'visible' => array('be_themes_portfolio_template_style', '=' , 'style3'),
				'tab' => 'general'
			),
			array (
				'name' => __('Show Information box','oshin'),
				'id'   => "{$prefix}portfolio_show_info_box",
				'type' => 'checkbox',
				'std'  => 1,
				'tab' => 'other_settings'
			),
			array (
				'name' => __('Enable Normal Scroll/Free Scroll','oshin'),
				'id'   => "{$prefix}portfolio_horizontal_vertical_slider_normal_scroll",
				'type' => 'checkbox',
				'std'  => 0,
				'tab' => 'other_settings',
				'visible' => array('be_themes_portfolio_template_style', '=','style1')
			),
			array (
				'name' => __('Show Thumbnails bar','oshin'),
				'id'   => "{$prefix}portfolio_show_carousel_bar",
				'type' => 'checkbox',
				'std'  => 1,
				'tab' => 'other_settings'
			),
			array (
				'name' => __('Enable Overlay','oshin'),
				'id'   => "{$prefix}portfolio_horizontal_slider_enable_overlay",
				'type' => 'checkbox',
				'std'  => 1,
				'tab' => 'other_settings',
				'visible' => array('be_themes_portfolio_horizontal_vertical_slider_normal_scroll' , false)
			),
			array (
				'name' => __('Overlay Background Color','oshin'),
				'id' => "{$prefix}portfolio_horizontal_slider_overlay_color",
				'desc' => '',
				'type' => 'color',
				'std' => '',
				'tab' => 'other_settings',
				'visible' => array('be_themes_portfolio_horizontal_slider_enable_overlay' , true)
			),
			array (
				'name' => __('Overlay Background Color Opacity','oshin'),
				'id' => "{$prefix}portfolio_horizontal_slider_overlay_color_opacity",
				'desc' => 'In Percentage (0-100)',
				'type' => 'text',
				'std' => 85,
				'tab' => 'other_settings',
				'visible' => array('be_themes_portfolio_horizontal_slider_enable_overlay' , true)
			),
		)
    );
    //Hide portfolio template other settings tab
    if( !function_exists( 'be_themes_hide_portfolio_template_other_settings' ) ) {
        function be_themes_hide_portfolio_template_other_settings( $conditions ) {
            $conditions['.rwmb-tab-other_settings'] = array(
                'hidden' => array (
                    'when' => array (
                        array( 'be_themes_portfolio_template_style', '=', 'style4' ),
                        array( 'be_themes_portfolio_template_style', '=', 'style5' ),
                    ),
                    'relation' => 'or'
                )
            );
            return $conditions;
        }
        add_filter( 'rwmb_outside_conditions', 'be_themes_hide_portfolio_template_other_settings' );
    }


	// Oshine Page Sidebar Options
	$meta_boxes[] = array (
		'id' => 'page_portfolio',
		'title' => 'OSHINE - Page Sidebar Options',
		'pages' => array( 'page' ),
		'hide'   => array(
            'template'    => array( 'portfolio.php' , 'gallery.php' ),
		),
		'context' => 'advanced',
		'priority' => 'high',
		'fields' => array (
			array (
				'name' => __('Layout','oshin'),
				'id'   => "{$prefix}page_layout",
				'type' => 'select',
				'options'=>array (
					'right'=>'Right Sidebar', 
					'left'=>'Left Sidebar', 
					'no' => 'No Sidebar'
				),
				'std'  => 'right',
				'desc' => '',
			),									
			array (
				'name' => __('Sidebar','oshin'),
				'id'   => "{$prefix}sidebar",
				'type' => 'sidebar_select',
				'size' => '',
				'std'  => '',
				'desc' => '',
			),
		)
	);
	// Oshine Other Layout Options
	$meta_boxes[] = array (
		'id' => 'page_portfolio_common',
		'title' => 'OSHINE - Other Layout Options',
		'pages' => array( 'page','portfolio' ),
		'context' => 'advanced',
		'priority' => 'high',
		'fields' => array (
			array (
				'name' => __('Single Page Site','oshin'),
				'id'   => "{$prefix}single_page_version",
				'type' => 'checkbox',
				'std'  => '',
			),
			array (
				'name' => __('Scroll To Sections','oshin'),
				'id'   => "{$prefix}section_scroll",
				'type' => 'checkbox',
				'std'  => '',
			),
			array (
				'name'	=> __( 'Sticky Sections', 'oshin' ),
				'id'	=> "{$prefix}sticky_sections",
				'type'	=> 'checkbox',
				'std'	=> ''
			),
			array (
				'name' => __( 'Scroll Type', 'oshin' ),
				'id'   => "{$prefix}sticky_scroll_type",
				'type' => 'select',
				'options' => array (
					'auto_scroll' => 'Auto Scroll',
					'normal_scroll' => 'Normal Scroll',
				),
				'std' => 'normal_scroll',
				'desc' => '',
				'visible' => array(
					'be_themes_sticky_sections', true
				),
			),
			array (
				'name'	=> __( 'Enable Overlay', 'oshin' ),
				'id' => "{$prefix}sticky_overlay",
				'type' => 'checkbox',
				'std' => true,
				'desc' => '',
				'visible' => array(
					'be_themes_sticky_sections', true
				),
			),
			array (
				'name' => __('Show Bottom Widgets','oshin'),
				'id'   => "{$prefix}bottom_widgets",
				'type' => 'select',
				'options'=> array('yes'=>'Yes', 'no'=>'No'),
				'std'  => 'yes',
				'desc' => '',
				'visible' => array('be_themes_section_scroll',false)
			),
			array (
				'name' => __('Show Footer','oshin'),
				'id'   => "{$prefix}footer_area",
				'type' => 'select',
				'options'=> array('yes'=>'Yes', 'no'=>'No'),
				'std'  => 'yes',
				'desc' => '',
				'visible' => array('be_themes_section_scroll',false)
			)
		)
	);



	return $meta_boxes;
}

?>