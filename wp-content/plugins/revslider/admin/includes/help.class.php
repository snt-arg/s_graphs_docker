<?php
/**
* @author    ThemePunch <info@themepunch.com>
* @link      https://www.themepunch.com/
* @copyright 2019 ThemePunch
*/
if(!defined('ABSPATH')) exit();

class RevSliderHelp {

	/**
	 * @return array
	 */
	public static function getIndex() {
		$translations = array(
			'docs' => __('Docs', 'revsliderhelp'),
			'tutorial' => __('Tutorial', 'revsliderhelp'),
			'helpDirectory' => __('Help Directory', 'revsliderhelp'),
			'supportCenter' => __('Support Center', 'revsliderhelp'),
			'searchPlaceholder' => __('Search for an Option', 'revsliderhelp'),
			'tutorials' => __('Tutorials', 'revsliderhelp'),
			'slider' => __('Slider', 'revsliderhelp'),
			'navigation' => __('Navigation', 'revsliderhelp'),
			'slide' => __('Slide', 'revsliderhelp'),
			'layer' => __('Layer', 'revsliderhelp'),
			'settings' => __('Settings', 'revsliderhelp'),
			'helpMode' => __('Help Mode', 'revsliderhelp'),
			'hoverTip' => __('Hover your mouse over any option to learn more.', 'revsliderhelp'),
			'viewDocs' => __('Documentation', 'revsliderhelp'),
			'showOption' => __('Show Option', 'revsliderhelp'),
			'option' => __('Option', 'revsliderhelp'),
			'options' => __('Options', 'revsliderhelp'),
			'faqs' => __('FAQs', 'revsliderhelp'),
			'search' => __('Search Keywords, e.g. "Background"', 'revsliderhelp'),
			'instructions' => __('Hover over any option to learn more', 'revsliderhelp'),
			'selectresult' => __('Select a Search Result')
		);
		$u = 'https://www.themepunch.com/slider-revolution/';
		$fu = 'https://www.themepunch.com/faq/';
		$t = 'title';
		$h = 'helpPath';
		$k = 'keywords';
		$d = 'description';
		$a = 'article';
		$s = 'section';
		$hl = 'highlight';
		$m = 'menu';
		$st = 'scrollTo';
		$f = 'focus';
		$d = 'description';
		$di = 'dependency_id';
		$dp = 'dependencies';
		$p = 'path';
		$v = 'value';
		$o = 'option';
		$helpindex = array(
			'general_how_to' => array(
				'responsive_setup' => array(
					'activate_responsive_viewports' => array(
						$t => __("Activate Responsive Viewports", 'revsliderhelp'),
						$h => 'faq',
						$k => array("respon", "responsive", "viewport", "viewports", "responsive viewports", "breakpoints", "break points", "desktop", "notebook", "laptop", "mobile", "phone", "iphone", "smartphone", "smart phone"),
						$d => __("Enable multiple stage sizes for custom set responsive content", 'revsliderhelp'),
						$a => $fu . "responsive-content/",
						$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_slider_layout_bpoints', $f => "#sr_custom_n")
					),
					'responsive_grid_sizes' => array(
						$t => __("Responsive Grid Sizes", 'revsliderhelp'),
						$h => 'faq',
						$k => array("respon", "responsive", "viewport", "grid sizes", "desktop", "notebook", "laptop", "mobile", "phone", "iphone", "smartphone", "smart phone"),
						$d => __("Define custom grid widths and heights per device/viewport", 'revsliderhelp'),
						$a => $fu . "responsive-content/#breakpoints",
						$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_slider_layout_bpoints', $f => "#sr_size_width_d")
					),
					'content_size_position' => array(
						$t => __("Content Size/Position", 'revsliderhelp'),
						$h => 'faq',
						$k => array("respon", "responsive", "content", "size", "position", "desktop", "notebook", "laptop", "mobile", "phone", "iphone", "smartphone", "smart phone"),
						$d => __("Modify font size and layer position per device", 'revsliderhelp'),
						$a => $fu . "incorrect-size-or-position/",
						$hl => array($dp => array('layerselected'), $m => "#module_layers_trigger, #gst_layer_2", $st => '#form_layerposition_basic', $f => "#layer_pos_x")
					),
					'layers_responsive_behavior' => array(
						$t => __("Layers Responsive Behavior", 'revsliderhelp'),
						$h => 'doc',
						$k => array("respon", "responsive", "layer", "layers", "content", "behavior", "desktop", "notebook", "laptop", "mobile", "phone", "iphone", "smartphone", "smart phone"),
						$d => __("Responsive alignment and positioning", 'revsliderhelp'),
						$a => $u . "responsive-settings/",
						$hl => array($dp => array('layerselected'), $m => "#module_layers_trigger, #gst_layer_13", $st => '#form_layerposition_basic', $f => "#layer_behavior_intelSize")
					),
					'layers_mobile_visibility' => array(
						$t => __("Layers Mobile Visibility", 'revsliderhelp'),
						$h => 'doc',
						$k => array("respon", "responsive", "layer", "layers", "content", "visibility", "desktop", "notebook", "laptop", "mobile", "phone", "iphone", "smartphone", "smart phone"),
						$d => __("Disable slider on mobile, hide layer content below screen size", 'revsliderhelp'),
						$a => $u . "responsive-settings/#device-visibility",
						$hl => array($dp => array('layerselected'), $m => "#module_layers_trigger, #gst_layer_13", $st => '#form_layercontent_visibility', $f => "*[data-r='visibility.m']")
					),
					'responsive_text_images' => array(
						$t => __("Responsive Text/Images", 'revsliderhelp'),
						$h => 'doc',
						$k => array("respon", "responsive", "layer", "layers", "text", "image", "images", "desktop", "notebook", "laptop", "mobile", "phone", "iphone", "smartphone", "smart phone"),
						$d => __("Adjust the size of text and images for each reponsive viewport", 'revsliderhelp'),
						$a => $u . "size-position/#responsive",
						$hl => array($dp => array('layerselected::text||button||image'), $m => "#module_layers_trigger, #gst_layer_3", $st => '#form_layerstyle_font', $f => "#layer_font_size_idle")
					)
				),
				'slide_management' => array(
					'add_new_slide' => array(
						$t => __("Add New Slide", 'revsliderhelp'),
						$h => 'doc',
						$k => array("slide", "slides", "add slide", "new slide", "slide template", "template", "blank slide", "bulk slide", "blank", "bulk"),
						$d => __("add/duplicate/delete Slides", 'revsliderhelp'),
						$a => $u . "slide-management/#add-new-slide",
						$hl => array($dp => array('addslide'))
					),
					'slide_order' => array(
						$t => __("Change Slide Order", 'revsliderhelp'),
						$h => 'doc',
						$k => array("slide", "slide order", "order", "ordering"),
						$d => __("Change the order in which the Slides appear", 'revsliderhelp'),
						$a => $u . "slide-management/#switch-reorder-slides",
						$hl => array($dp => array('slideorder'))
					)
				),
				'add_edit_content' => array(
					'change_background' => array(
						$t => __("Set/Change Slide Background", 'revsliderhelp'),
						$h => 'doc', 
						$k => array("slide", "slide settings", "background", "bg", "image", "images", "color", "video", "image background"),
						$d => __("Set the Slide's Main background to a color, image or video", 'revsliderhelp'),
						$a => $u . "slide-background/",
						$hl => array($m => "#module_slide_trigger, #gst_slide_1", $st => '#form_slidebg_source', $f => "#slide_bg_type")
					),
					'change_slider_background' => array(
						$t => __("Set/Change Module Background", 'revsliderhelp'),
						$h => 'doc', 
						$k => array("slide", "slide settings", "background", "bg", "image", "images", "color", "video", "image background"),
						$d => __("Set the Module's Main background to a color, image or video", 'revsliderhelp'),
						$a => $u . "module-layout/#module-background",
						$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_slider_layout_decmobg', $f => "#sliderbgcolor")
					),
					'change_layer_background' => array(
						$t => __("Set/Change Layer Background", 'revsliderhelp'),
						$h => 'doc', 
						$k => array("slide", "slide settings", "background", "bg", "image", "images", "color", "video", "image background"),
						$d => __("Set a Layer's Main background to a color, image or video", 'revsliderhelp'),
						$a => $u . "font-colors-styling/#background",
						$hl => array($dp => array('layerselected'), $m => '#module_layers_trigger, #gst_layer_3', $st => '#form_layerstyle_bg', $f => "#layerBGColor")
					),
					'edit_content' => array(
						$t => __("Edit Content Layers", 'revsliderhelp'),
						$h => 'doc',
						$k => array("edit", "change", "style", "styles", "position", "size", "responsive"),
						$d => __("Edit text, images, videos, styles, position and size for your content", 'revsliderhelp'),
						$a => $u . "layer-content/#edit-set-content",
						$hl => array($dp => array('layerselected'), $m => '#module_layers_trigger, #gst_layer_1', $st => '#form_layer_content', $f => "#ta_layertext, #layer_htmltag, *[data-r='media.videoFromStream'], #layer_mpegaudio_src")
					),
					'add_new_layer' => array(
						$t => __("Add New Layer", 'revsliderhelp'),
						$h => 'doc',
						$k => array("layer", "layers", "add layer", "new layer", "import layer", "text", "image", "images", "video", "vimeo", "youtube", "you tube", "audio", "icon", "svg", "button", "shape", "row", "group"),
						$d => __("Add a variety of content to your Slides", 'revsliderhelp'),
						$a => $u . "layer-content/#add-new-layer",
						$hl => array($dp => array('addlayer'))
					),
					'global_layers' => array(
						$t => __("Global Layers", 'revsliderhelp'),
						$h => 'doc',
						$k => array("global", "static", "global layers", "static layers", "layers", "always visible", "always show"),
						$d => __("Add/Edit content that's meant to always be visible", 'revsliderhelp'),
						$a => $u . "global-layers/",
						$hl => array($dp => array('staticlayers'))
					)
				),
				'animations' => array(
					'slide_animations' => array(
						$t => __("Slide Animations", 'revsliderhelp'),
						$h => 'doc',
						$k => array("animation", "animations", "transition", "transitions", "slide animation", "slide animations", "slide transition", "slide transitions"),
						$d => __("60+ pre-built animations, animation duration, easing", 'revsliderhelp'),
						$a => $u . "slide-animation/",
						$hl => array($m => '#module_slide_trigger, #gst_slide_2', $st => '#form_slidebg_transition', $f => ".added_slide_transition.selected")
					),
					'layer_animations' => array(
						$t => __("Layer Animations", 'revsliderhelp'),
						$h => 'doc',
						$k => array("animation", "animations", "transition", "transitions", "layer animation", "layer animations", "layer transition", "layer transitions"),
						$d => __("Start/End animation timing and easing", 'revsliderhelp'),
						$a => $u . "layer-animations/",
						$hl => array($dp => array('layerselected'), $m => '#module_layers_trigger, #gst_layer_4', $st => '#form_animation_sframes', $f => ".frame_list_id")
					)
				),
				'navigation_links' => array(
					'enable_navigation' => array(
						$t => __("Enable/Disable Navigation", 'revsliderhelp'),
						$h => 'doc',
						$k => array("navigation", "add navigation", "enable navigation", "remove navigation", "disable navigation", "thumbs", "thumbnails", "tabs", "arrows", "bullets", "touch"),
						$d => __("Learn how to add/remove navigation elements to control the Slider", 'revsliderhelp'),
						$a => $u . "navigation-arrows/",
						$hl => array(
							$dp => array(array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard')), 
							$m => "#module_navigation_trigger, #gst_nav_2", 
							$st => '#form_nav_arrows_mainstyle', 
							$f => "#sr_usenavarrow"
						)
					),
					'links' => array(
						$t => __("Add/Remove Links", 'revsliderhelp'),
						$h => 'doc',
						$k => array("link", "links", "add link", "add links", "remove link", "remove links", "delete link", "delete links", "hyperlink", "external link"),
						$d => __("Add/Remove links to additional slides, other web pages/posts or external websites", 'revsliderhelp'),
						$a => $u . "simple-link/",
						$hl => array($m => '#module_slide_trigger, #gst_slide_4', $st => '#form_slidegeneral_linkseo', $f => "#sl_seo_set")
					)
				),
				'addon_extentions' => array(
					'activate_enable' => array(
						$t => __("Active/Enable Addons", 'revsliderhelp'),
						$h => 'doc',
						$k => array("addon", "addons", "extentions", "enable addon", "enable addons", "activate addon", "activate addons"),
						$d => __("Learn how to activate an AddOn for the Slider", 'revsliderhelp'),
						$a => $u . "enable-addons/",
						$hl => array($m => '#module_settings_trigger, #gst_sl_9', 'modal' => 'addons')
					),
					'how_to_use' => array(
						$t => __("How To Use", 'revsliderhelp'),
						$h => 'doc',
						$k => array("addon", "addons", "extentions", "addon settings"),
						$d => __("AddOn Settings will be located in the Slider, Slide or Layer settings depending on the AddOns functionality", 'revsliderhelp'),
						$a => $u . "addon-guides/",
					)
				)
			),
			'editor_settings' => array(
				'slider_settings' => array(
					'gst_sl_1' => array(
						$t => array(
							$t => __("Slider Title", 'revsliderhelp'),
							$h => "title",
							$k => array("slider", "title", "name", "naming"),
							$d => __("Set the title of the Slider for admin/editing purposes", 'revsliderhelp'),
							$a => $u . "module-title-shortcode/",
							$hl => array($m => '#module_settings_trigger, #gst_sl_1', $st => '#form_module_title', $f => "#sr_title")
						),
						'alias' => array(
							$t => __("Slider Alias",  'revsliderhelp'),
							$h => "alias", 
							$k => array("slider", "alias", "shortcode"),
							$d => __("The slider's alias is used to define a unique shortcode", 'revsliderhelp'),
							$a => $u . "module-title-shortcode/",
							$hl => array($m => '#module_settings_trigger, #gst_sl_1', $st => '#form_module_title', $f => "#sr_alias")
						),
						'shortcode' => array(
							$t => __("Slider Shortcode", 'revsliderhelp'),
							$h => "shortcode", 
							$k => array("slider", "shortcode", "slider shortcode"),
							$d => __("Place the shortcode on the page or post where you want to show this module", 'revsliderhelp'),
							$a => $u . "module-title-shortcode/",
							$hl => array($m => '#module_settings_trigger, #gst_sl_1', $st => '#form_module_title', $f => "#sr_shortcode")
						)
					),
					'gst_sl_2' => array(
						'type' => array(
							'standard' => array(
								$di => "slider_layout_type_standard",
								$t => __("Standard Slider", 'revsliderhelp'),
								$h => "type.standard",
								$k => array("slider", "slider layout", "layout", "type", "scene", "hero", "carousel"),
								$d => __("A Slider that can have multiple slides with navigation", 'revsliderhelp'),
								$a => $u . "module-layout/",
								$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_sliderlayout', $f => "input[name=slidertype][value=standard]")
							),
							'hero' => array(
								$t => __("Hero Scene", 'revsliderhelp'),
								$h => "type.hero",
								$k => array("slider", "slider layout", "layout", "type", "scene", "hero", "carousel"),
								$d => __("A single-slide Slider with no navigation", 'revsliderhelp'),
								$a => $u . "module-layout//",
								$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_sliderlayout', $f => "input[name=slidertype][value=hero]")
							),
							'carousel' => array(
								$di => "slider_layout_type_carousel",
								$t => __("Carousel", 'revsliderhelp'),
								$h => "type.carousel",
								$k => array("slider", "slider layout", "layout", "type", "scene", "hero", "carousel"),
								$d => __("Display the Slider as a traditional Carousel", 'revsliderhelp'),
								$a => $u . "module-layout/",
								$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_sliderlayout', $f => "input[name=slidertype][value=carousel]")
							),
						),
						'sizing' => array(
							'auto' => array(
								$t => __("Auto", 'revsliderhelp'),
								$h => "layouttype.auto",
								$k => array("slider", "slider sizing", "responsive", "respon", "sizing", "auto"),
								$d => __("Size will adapt to the same size as the web page's content", 'revsliderhelp'),
								$a => $u . "module-layout/",
								$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_sliderlayout', $f => "input[name=sliderlayouttype][value=auto]")
							),
							'fullwidth' => array(
								$t => __("Full Width", 'revsliderhelp'),
								$h => "layouttype.fullwidth",
								$k => array("slider", "slider sizing", "responsive", "respon", "sizing", "full width", "full-width", "fullwidth"),
								$d => __("Display the Slider 100% width across the page", 'revsliderhelp'),
								$a => $u . "module-layout/",
								$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_sliderlayout', $f => "input[name=sliderlayouttype][value=fullwidth]")
							),
							'fullscreen' => array(
								$di => "slider_layouttype_fullscreen",
								$t => __("Full Screen", 'revsliderhelp'),
								$h => "layouttype.fullscreen",
								$k => array("slider", "slider sizing", "responsive", "respon", "sizing", "full screen", "full-screen", "fullscreen"),
								$d => __("Display the Slider at 100% width and height", 'revsliderhelp'),
								$a => $u . "module-layout/",
								$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_sliderlayout', $f => "input[name=sliderlayouttype][value=fullscreen]")
							),
							'advanced' => array(
								'max_width' => array(
									$t => __("Max Width", 'revsliderhelp'),
									$h => "size.maxWidth",
									$k => array("max", "max width", "sizing", "layout"),
									$d => __("Optional maximum width for the Slider", 'revsliderhelp'),
									$a => $u . "module-layout/",
									$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_slider_layout_adv', $f => "#sr_size_maxwidth")
								),
								'min_height' => array(
									$t => __("Min Height", 'revsliderhelp'),
									$h => "size.minHeight",
									$k => array("min", "min height", "sizing", "layout"),
									$d => __("Optional minimum height for the Slider", 'revsliderhelp'),
									$a => $u . "module-layout/",
									$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_slider_layout_adv', $f => "#sr_size_minheight")
								),
								'max_height' => array(
									$t => __("Max Height", 'revsliderhelp'),
									$h => "size.maxHeight",
									$k => array("max", "max height", "sizing", "layout"),
									$d => __("Optional maximum height for the Slider", 'revsliderhelp'),
									$a => $u . "module-layout/",
									$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_slider_layout_adv', $f => "#sr_size_maxheight")
								),
								'breakpoint_heights' => array(
									$t => __("Keep Breakpoint Heights", 'revsliderhelp'),
									$h => "size.keepBPHeight",
									$k => array("breakpoints", "height", "heights", "breakpoint", "responsive"),
									$d => __("If enabled the Slider's height will always equal the viewport's breakpoint height", 'revsliderhelp'),
									$a => $u . "module-layout/",
									$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_slider_layout_adv', $f => "#sr_breakpoint_heights")
								),
								'aspect_ratio' => array(
									$t => __("Respect Aspect Ratio", 'revsliderhelp'),
									$h => "size.respectAspectRatio",
									$k => array("ratio", "aspect", "aspect ratio", "lock"),
									$d => __("Activates a responsive height for the Slider", 'revsliderhelp'),
									$a => $u . "module-layout/",
									$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_slider_layout_adv', $f => "#sr_respectAR")
								),
								'grid_equals_module' => array(
									$t => __("Grid = Module", 'revsliderhelp'),
									$h => "size.layersAlignOnModule",
									$k => array("ratio", "aspect", "aspect ratio", "grid", "module"),
									$d => __("The default align behavior for Layers.  If enabled, Layers will be aligned to the entire Module and if disabled Layers will align to the device breakpoint grid area.", 'revsliderhelp'),
									$a => $u . "module-layout/",
									$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_slider_layout_adv', $f => "#sr_layersAlignOnModule")
								),
								'force_overflow' => array(
									$t => __("Force Overflow", 'revsliderhelp'),
									$h => "size.forceOverflow",
									$k => array("ratio", "aspect", "aspect ratio", "overflow"),
									$d => __("Allow for content to be visible outside the Slider's bounding box", 'revsliderhelp'),
									$a => $u . "module-layout/",
									$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_slider_layout_adv', $f => "#sr_forceOvVi")
								),
								'fixed_top' => array(
									$t => __("Fixed on Top", 'revsliderhelp'),
									$h => "layout.position.fixedOnTop",
									$k => array("ratio", "aspect", "aspect ratio", "overflow"),
									$d => __("The module will be positioned at the top of the screen at all times.  Useful for creating sticky menus.", 'revsliderhelp'),
									$a => $u . "module-layout/",
									$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_slider_layout_adv', $f => '*[data-r="layout.position.fixedOnTop"]')
								),
								'theperspective' => array(
									$t => __("Global 3D Perspective", 'revsliderhelp'),
									$h => "general.perspectiveType",
									$k => array("perspective", "isometric", "3D", "3d"),
									$d => __("Defines the Perspective by the 3D rendering of layers. This can be set globally (3D Uniset) for better and easier handling or individuel (3D Individual) on each single layer frames. We recommend to do this globally.  The Special option Isometric will set the perspective to 0 automatically", 'revsliderhelp'),
									$a => $u . "module-layout/",
									$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_slider_layout_adv', $f => '*[data-r="layout.general.perspectiveType"]')
								),
								'theperspective_value' => array(
									$t => __("Global 3D Layer Perspective", 'revsliderhelp'),
									$h => "general.perspective",
									$k => array("perspective", "isometric", "3D", "3d","layer perspective"),
									$d => __("Defines the Perspective by the 3D rendering of layers globally.", 'revsliderhelp'),
									$a => $u . "module-layout/",
									$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_slider_layout_adv', $f => '*[data-r="layout.general.perspective"]')
								),

							),
							'slider_wrapper_position' => array(
								'align' => array(
									$t => __("Slider Alignment", 'revsliderhelp'),
									$h => "layout.position.align",
									$k => array("align", "slider align", "position", "slider position", "wrapper"),
									$d => __("Align the Slider to the left, center or right inside its parent container", 'revsliderhelp'),
									$a => $u . "module-general-settings/",
									$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_slidergeneral_general_sr_position', $f => "*[name='slider_pos_in_wrapper']{first}")
								),
								'margin_top' => array(
									$t => __("Margin Top", 'revsliderhelp'),
									$h => "layout.position.marginTop",
									$k => array("margin", "margin top", "top margin", "slider margin"),
									$d => __("Apply a top margin to the Slider (px)", 'revsliderhelp'),
									$a => $u . "module-general-settings/",
									$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_slidergeneral_general_sr_position', $f => "#sr_pos_marg_top")
								),
								'margin_bottom' => array(
									$t => __("Margin Bottom", 'revsliderhelp'),
									$h => "layout.position.marginBottom",
									$k => array("margin", "margin bottom", "bottom margin", "slider margin"),
									$d => __("Apply a bottom margin to the Slider (px)", 'revsliderhelp'),
									$a => $u . "module-general-settings/",
									$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_slidergeneral_general_sr_position', $f => "#sr_pos_marg_bottom")
								)
							),
							'full_screen_offset' => array(
								'offset_container' => array(
									$t => __("Offset Container", 'revsliderhelp'),
									$h => "size.fullScreenOffsetContainer",
									$k => array("fullscreen", "offset", "offset container", "decrease"),
									$d => __("Useful for allocating space for a page's menu or footer.  Accepts a jQuery selector such as '.menu' or 'footer'.", 'revsliderhelp'),
									$a => $u . "module-layout/",
									$hl => array(
										$dp => array(array($p => 'settings.layouttype', $v => 'fullscreen', $o => 'slider_layouttype_fullscreen')), 
										$m => "#module_settings_trigger, #gst_sl_2", 
										$st => '#form_slider_layout_decmohei', 
										$f => "#sr_fs_height__decrease_cont"
									)
								),
								'offset_value' => array(
									$t => __("Offset px/%", 'revsliderhelp'),
									$h => "size.fullScreenOffset",
									$k => array("fullscreen", "offset", "offset container", "decrease"),
									$d => __("Useful for allocating space for a page's menu or footer.  Enter a px or % value.", 'revsliderhelp'),
									$a => $u . "module-layout/",
									$hl => array(
										$dp => array(array($p => 'settings.layouttype', $v => 'fullscreen', $o => 'slider_layouttype_fullscreen')), 
										$m => "#module_settings_trigger, #gst_sl_2", 
										$st => '#form_slider_layout_decmohei', 
										$f => "#sr_fs_height_decrease"
									)
								),
								'no_force_fullwidth' => array(
									$t => __("Don't Force Fullwidth", 'revsliderhelp'),
									$h => "size.disableForceFullWidth",
									$k => array("full width", "fullwidth", "force"),
									$d => __("If enabled, the Module's width will remain the same as its immediate parent container", 'revsliderhelp'),
									$a => $u . "module-layout/",
									$hl => array(
										$dp => array(array($p => 'settings.layouttype', $v => 'fullscreen', $o => 'slider_layouttype_fullscreen')), 
										$m => "#module_settings_trigger, #gst_sl_2", 
										$st => '#form_slider_layout_decmohei', 
										$f => "#sr_keepautowidth"
									)
								)
							)
						),
						'responsive_breakpoints' => array(
							'desktop' => array(
								'enable' => array(
									$t => __("Desktop Viewport", 'revsliderhelp'),
									$h => "size.custom.d",
									$k => array(),
									$d => __("The default viewport.  This option will always be enabled", 'revsliderhelp'),
									$a => $u . "module-layout/#breakpoints",
									$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_slider_layout_bpoints', $f => "*[data-helpkey='size.custom.d']")
								),
								'width' => array(
									$t => __("Desktop Width", 'revsliderhelp'),
									$h => "size.width.d",
									$k => array("respon", "responsive", "slider size", "slider width", "desktop", "desktop width", "viewport", "view", "grid", "grid width", "grid size"),
									$d => __("The responsive grid width (in pixels) for the Desktop viewport", 'revsliderhelp'),
									$a => $u . "module-layout/#breakpoints",
									$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_slider_layout_bpoints', $f => "#sr_size_width_d")
								),
								'height' => array(
									$t => __("Desktop Height", 'revsliderhelp'),
									$h => "size.height.d",
									$k => array("respon", "responsive", "slider size", "slider height", "desktop", "desktop height", "viewport", "view", "grid", "grid height", "grid size"),
									$d => __("The responsive grid height (in pixels) for the Desktop viewport", 'revsliderhelp'),
									$a => $u . "module-layout/#breakpoints",
									$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_slider_layout_bpoints', $f => "#sr_size_height_d")
								),
							),
							'laptop' => array(
								'enable' => array(
									$t => __("Laptop Viewport", 'revsliderhelp'),
									$h => "size.custom.n",
									$k => array("respon", "responsive", "slider size", "notebook", "laptop", "viewport", "view", "grid", "grid size"),
									$d => __("Enable the Laptop responsive viewport", 'revsliderhelp'),
									$a => $u . "module-layout/#breakpoints",
									$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_slider_layout_bpoints', $f => "#sr_custom_n")
								),
								'width' => array(
									$t => __("Laptop Width", 'revsliderhelp'),
									$h => "size.width.n",
									$k => array("respon", "responsive", "slider size", "slider width", "notebook", "notebook width", "laptop", "laptop width", "viewport", "view", "grid", "grid width", "grid size"),
									$d => __("The responsive grid width (in pixels) for the Laptop viewport", 'revsliderhelp'),
									$a => $u . "module-layout/#breakpoints",
									$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_slider_layout_bpoints', $f => "#sr_size_width_n")
								),
								'height' => array(
									$t => __("Laptop Height", 'revsliderhelp'),
									$h => "size.height.n",
									$k => array("respon", "responsive", "slider size", "slider height", "notebook", "notebook height", "laptop", "laptop height", "viewport", "view", "grid", "grid height", "grid size"),
									$d => __("The responsive grid height (in pixels) for the Laptop viewport", 'revsliderhelp'),
									$a => $u . "module-layout/#breakpoints",
									$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_slider_layout_bpoints', $f => "#sr_size_height_n")
								),
							),
							'tablet' => array(
								'enable' => array(
									$t => __("Tablet Viewport", 'revsliderhelp'),
									$h => "size.custom.t",
									$k => array("respon", "responsive", "slider size", "tablet", "ipad", "viewport", "view", "grid", "grid size"),
									$d => __("Enable the Tablet responsive viewport", 'revsliderhelp'),
									$a => $u . "module-layout/#breakpoints",
									$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_slider_layout_bpoints', $f => "#sr_custom_t")
								),
								'width' => array(
									$t => __("Tablet Width", 'revsliderhelp'),
									$h => "size.width.t",
									$k => array("respon", "responsive", "slider size", "slider width", "ipad", "tablet", "tablet width", "viewport", "view", "grid", "grid width", "grid size"),
									$d => __("The responsive grid width (in pixels) for the Tablet viewport", 'revsliderhelp'),
									$a => $u . "module-layout/#breakpoints",
									$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_slider_layout_bpoints', $f => "#sr_size_width_t")
								),
								'height' => array(
									$t => __("Tablet Height", 'revsliderhelp'),
									$h => "size.height.t",
									$k => array("respon", "responsive", "slider size", "slider height", "ipad", "tablet", "tablet height", "viewport", "view", "grid", "grid height", "grid size"),
									$d => __("The responsive grid height (in pixels) for the Tablet viewport", 'revsliderhelp'),
									$a => $u . "module-layout/#breakpoints",
									$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_slider_layout_bpoints', $f => "#sr_size_height_t")
								),
							),
							'phone' => array(
								'enable' => array(
									$t => __("Phone Viewport", 'revsliderhelp'),
									$h => "size.custom.m",
									$k => array("respon", "responsive", "slider size", "phone", "iphone", "viewport", "view", "grid", "grid size"),
									$d => __("Enable the Phone responsive viewport", 'revsliderhelp'),
									$a => $u . "module-layout/#breakpoints",
									$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_slider_layout_bpoints', $f => "#sr_custom_m")
								),
								'width' => array(
									$t => __("Tablet Width", 'revsliderhelp'),
									$h => "size.width.m",
									$k => array("respon", "responsive", "slider size", "slider width", "iphone", "iphone width", "phone", "phone width", "smart", "smartphone", "smartphone width", "smart phone", "smart phone width", "viewport", "view", "grid", "grid width", "grid size"),
									$d => __("The responsive grid width (in pixels) for the Tablet viewport", 'revsliderhelp'),
									$a => $u . "module-layout/#breakpoints",
									$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_slider_layout_bpoints', $f => "#sr_size_width_m")
								),
								'height' => array(
									$t => __("Tablet Height", 'revsliderhelp'),
									$h => "size.height.m",
									$k => array("respon", "responsive", "slider size", "slider height", "iphone", "iphone height", "phone", "phone height", "smart", "smartphone", "smartphone height", "smart phone", "smart phone height", "viewport", "view", "grid", "grid height", "grid size"),
									$d => __("The responsive grid height (in pixels) for the Tablet viewport", 'revsliderhelp'),
									$a => $u . "module-layout/#breakpoints",
									$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_slider_layout_bpoints', $f => "#sr_size_height_m")
								)
							)
						),
						'module_background' => array(
							'image' => array(
								'enable' => array(
									$di => "slider_layout_bg_useimage",
									$t => __("Use Image", 'revsliderhelp'),
									$h => "layout.bg.useImage",
									$k => array("image", "images", "background", "bg", "bg image", "background image", "image background"),
									$d => __("Set a global background image for the Slider", 'revsliderhelp'),
									$a => $u . "module-layout/#module-background",
									$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_slider_layout_decmobg', $f => "#sr_usebgimage")
								),
								'url' => array(
									$t => __("Image URL", 'revsliderhelp'),
									$h => "layout.bg.image",
									$k => array("image", "images", "background", "bg", "bg image", "background image", "url", "image background"),
									$d => __("Enter an image url or select/upload an image from the Media or Object Library to be used as the Slider's global background image", 'revsliderhelp'),
									$a => $u . "module-layout/#module-background",
									$hl => array(
										$dp => array(array($p => 'settings.layout.bg.useImage', $v => true, $o => 'slider_layout_bg_useimage')), 
										$m => "#module_settings_trigger, #gst_sl_2", 
										$st => '#form_slider_layout_decmobg', 
										$f => "#sr_bgimage"
									)
								),
								'position' => array(
									$t => __("BG Position", 'revsliderhelp'),
									$h => "layout.bg.position",
									$k => array("image", "images", "background", "bg", "bg image", "background position"),
									$d => __("The CSS background-position for the Slider's global background image", 'revsliderhelp'),
									$a => $u . "module-layout/#module-background",
									$hl => array(
										$dp => array(array($p => 'settings.layout.bg.useImage', $v => true, $o => 'slider_layout_bg_useimage')), 
										$m => "#module_settings_trigger, #gst_sl_2", 
										$st => '#form_slider_layout_decmobg', 
										$f => "#sliderm_bg_position_center-center"
									)
								),
								'fit' => array(
									$t => __("Image Fit", 'revsliderhelp'),
									$h => "layout.bg.fit",
									$k => array("background size", "fit", "image fit", "cover", "contain"),
									$d => __("The css background-size value for the Slider's global background image", 'revsliderhelp'),
									$a => $u . "module-layout/#module-background",
									$hl => array(
										$dp => array(array($p => 'settings.layout.bg.useImage', $v => true, $o => 'slider_layout_bg_useimage')), 
										$m => "#module_settings_trigger, #gst_sl_2", 
										$st => '#form_slider_layout_decmobg', 
										$f => "#sr_bgimage_fit"
									)
								),
								'repeat' => array(
									$t => __("BG Repeat", 'revsliderhelp'),
									$h => "layout.bg.repeat",
									$k => array("background repeat", "repeat"),
									$d => __("The css background-repeat value for the Slider's global background image", 'revsliderhelp'),
									$a => $u . "module-layout/#module-background",
									$hl => array(
										$dp => array(array($p => 'settings.layout.bg.useImage', $v => true, $o => 'slider_layout_bg_useimage')), 
										$m => "#module_settings_trigger, #gst_sl_2", 
										$st => '#form_slider_layout_decmobg', 
										$f => "#sr_bgimage_repeat"
									)
								)
							),
							'bg_color' => array(
								$t => __("Module BG Color", 'revsliderhelp'),
								$h => "layout.bg.color",
								$k => array("bg", "background", "background color", "global background", "global background color", "slider background", "slider bg"),
								$d => __("Set a global background color for the Slider", 'revsliderhelp'),
								$a => $u . "module-layout/#module-background",
								$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_slider_layout_decmobg', $f => "#sliderbgcolor")
							)
						),
						'border_overlay_shadow' => array(
							'overlay' => array(
								$t => __("Overlay", 'revsliderhelp'),
								$h => "layout.bg.dottedOverlay",
								$k => array("overlay", "dotted", "dotted overlay"),
								$d => __("Add an mesh-style overlay to the Slider", 'revsliderhelp'),
								$a => $u . "module-layout/#border-overlay-shadow",
								$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_slider_layout_decboovsh', $f => "#sr_overlay")
							),
							'shadow' => array(
								$t => __("Shadow", 'revsliderhelp'),
								$h => "layout.bg.shadow",
								$k => array("shadow", "box-shadow", "slider shadow"),
								$d => __("Choose an optional shadow to add to the Slider", 'revsliderhelp'),
								$a => $u . "module-layout/#border-overlay-shadow",
								$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_slider_layout_decboovsh', $f => "#sr_shadow")
							),
							'border' => array(
								$t => __("Gap (Border)", 'revsliderhelp'),
								$h => "layout.bg.padding",
								$k => array("border", "padding"),
								$d => __("Add extra spacing around the Slider", 'revsliderhelp'),
								$a => $u . "module-layout/#border-overlay-shadow",
								$hl => array($m => "#module_settings_trigger, #gst_sl_2", $st => '#form_slider_layout_decboovsh', $f => "#sr_layout_padding")
							)
						)
					),
					'gst_sl_4' => array(
						 'source' => array(
							'custom' => array(
								$t => __("Custom Content", 'revsliderhelp'),
								$h => "sourcetype.gallery",
								$k => array("gallery", "source", "custom"),
								$d => __("Add your own custom text/images/video to the Slider", 'revsliderhelp'),
								$a => $u . "module-content/",
								$hl => array($m => "#module_settings_trigger, #gst_sl_4", $st => '#form_slider_content_content', $f => "*[name='slider_sourcetype'][value='gallery']")
							),
							'post' => array(
								$di => "slider_sourcetype_post",
								$t => __("Post Based", 'revsliderhelp'),
								$h => "sourcetype.post",
								$k => array("post", "post based", "source"),
								$d => __("Populate the Slider with your WordPress post content", 'revsliderhelp'),
								$a => $u . "post-based-sliders/",
								$hl => array($m => "#module_settings_trigger, #gst_sl_4", $st => '#form_slider_content_content', $f => "*[name='slider_sourcetype'][value='post']")
							),
							'woocommerce' => array(
								$di => "slider_sourcetype_woo",
								$t => __("WooCommerce", 'revsliderhelp'),
								$h => "sourcetype.woo",
								$k => array("post", "woo", "woocommerce", "woo commerce", "source", "product", "products", "woocommerce products"),
								$d => __("Populate the Slider with your WooCommerce Products", 'revsliderhelp'),
								$a => $u . "module-content/#woocommerce",
								$hl => array($m => "#module_settings_trigger, #gst_sl_4", $st => '#form_slider_content_content', $f => "*[name='slider_sourcetype'][value='woo']")
							),
							'flickr' => array(
								$di => "slider_sourcetype_flickr",
								$t => __("Flickr", 'revsliderhelp'),
								$h => "sourcetype.flickr",
								$k => array("source", "flickr", "gallery", "stream"),
								$d => __("Populate the Slider with your Flickr Content", 'revsliderhelp'),
								$a => $u . "module-content/#flickr",
								$hl => array($m => "#module_settings_trigger, #gst_sl_4", $st => '#form_slider_content_content', $f => "*[name='slider_sourcetype'][value='flickr']")
							),
							'instagram' => array(
								$di => "slider_sourcetype_instagram",
								$t => __("Instagram", 'revsliderhelp'),
								$h => "sourcetype.instagram",
								$k => array("source", "instagram", "gallery", "stream"),
								$d => __("Populate the Slider with Instagram Images", 'revsliderhelp'),
								$a => $u . "module-content/#instagram",
								$hl => array($m => "#module_settings_trigger, #gst_sl_4", $st => '#form_slider_content_content', $f => "*[name='slider_sourcetype'][value='instagram']")
							),
							'twitter' => array(
								$di => "slider_sourcetype_twitter",
								$t => __("Twitter", 'revsliderhelp'),
								$h => "sourcetype.twitter",
								$k => array("twitter", "source", "tweet", "stream"),
								$d => __("Populate the Slider from a Twitter account", 'revsliderhelp'),
								$a => $u . "module-content/#twitter",
								$hl => array($m => "#module_settings_trigger, #gst_sl_4", $st => '#form_slider_content_content', $f => "*[name='slider_sourcetype'][value='twitter']")
							),
							'facebook' => array(
								$di => "slider_sourcetype_facebook",
								$t => __("Facebook", 'revsliderhelp'),
								$h => "sourcetype.facebook",
								$k => array("source", "facebook", "face", "stream"),
								$d => __("Populate the Slider from a Facebook album or timeline", 'revsliderhelp'),
								$a => $u . "module-content/#facebook",
								$hl => array($m => "#module_settings_trigger, #gst_sl_4", $st => '#form_slider_content_content', $f => "*[name='slider_sourcetype'][value='facebook']")
							),
							'youtube' => array(
								$di => "slider_sourcetype_youtube",
								$t => __("YouTube", 'revsliderhelp'),
								$h => "sourcetype.youtube",
								$k => array("video", "youtube", "you tube", "source", "stream"),
								$d => __("Populate the Slider with a YouTube Channel or Playlist", 'revsliderhelp'),
								$a => $u . "module-content/#youtube",
								$hl => array($m => "#module_settings_trigger, #gst_sl_4", $st => '#form_slider_content_content', $f => "*[name='slider_sourcetype'][value='youtube']")
							),
							'vimeo' => array(
								$di => "slider_sourcetype_vimeo",
								$t => __("Vimeo", 'revsliderhelp'),
								$h => "sourcetype.vimeo",
								$k => array("video", "vimeo", "stream"),
								$d => __("Populate the Slider with a Vimeo account's content", 'revsliderhelp'),
								$a => $u . "module-content/#vimeo",
								$hl => array($m => "#module_settings_trigger, #gst_sl_4", $st => '#form_slider_content_content', $f => "*[name='slider_sourcetype'][value='vimeo']")
							)
						),
						'post_options' => array(
							'type' => array(
								$di => "settings_source_post_subtype",
								$t => __("Post Options Type", 'revsliderhelp'),
								$h => "source.post.subType",
								$k => array("post", "posts", "post-based", "post type", "specific post", "current post"),
								$d => __("Choose 'Post' to pull in a range of posts, 'Specific Post' to pull in posts by ID, or 'Current Post' to populate the Slider with the current post's content", 'revsliderhelp'),
								$a => $u . "post-based-sliders/",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'post', $o => 'slider_sourcetype_post')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_content', 
									$f => "*[name='slidersourcesubtype']*wildcard*"
								)
							),
							'fetch_by' => array(
								$t => __("Fetch By", 'revsliderhelp'),
								$h => "source.post.fetchType",
								$k => array("post", "posts", "categories", "tags", "related", "popular", "recent"),
								$d => __("Choose which type of posts should be pulled into the Slider", 'revsliderhelp'),
								$a => $u . "post-based-sliders/",
								$hl => array(
									$dp => array(
										array($p => 'settings.sourcetype', $v => 'post', $o => 'slider_sourcetype_post'), 
										array($p => 'settings.source.post.subType', $v => 'post', $o => 'settings_source_post_subtype', 'target' => 'post')
									), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_post_selection', 
									$f => "#post_fetch_type"
								)
							),
							'post_types' => array(
								$t => __("Post Types", 'revsliderhelp'),
								$h => "source.post.types",
								$k => array("woo", "post", "posts", "post types", "custom post type", "custom post types"),
								$d => __("Choose which Post Types to include in the Slider", 'revsliderhelp'),
								$a => $u . "post-based-sliders/",
								$hl => array(
									$dp => array(
										array($p => 'settings.sourcetype', $v => 'post::woo', $o => 'slider_sourcetype_post'), 
										array('dependency' => 'post', $p => 'settings.source.post.subType', $v => 'post', $o => 'settings_source_post_subtype', 'target' => 'post')
									), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_post_selection, #form_slider_content_woo_tandc', 
									$f => "#post_types, #woo_types"
								)
							),
							'categories' => array(
								$t => __("Post Categories", 'revsliderhelp'),
								$h => "source.post.category",
								$k => array("woo", "post", "posts", "categories", "post categories", "tags"),
								$d => __("Choose which Post Categories to include in the Slider", 'revsliderhelp'),
								$a => $u . "post-based-sliders/",
								$hl => array(
									$dp => array(
										array($p => 'settings.sourcetype', $v => 'post::woo', $o => 'slider_sourcetype_post'), 
										array('dependency' => 'post', $p => 'settings.source.post.subType', $v => 'post', $o => 'settings_source_post_subtype', 'target' => 'post')
									), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_post_selection, #form_slider_content_woo_tandc', 
									$f => "#post_category, #woo_category"
								)
							),
							'specific_posts' => array(
								$t => __("Specific Posts", 'revsliderhelp'),
								$h => "source.post.list",
								$k => array("post", "posts", "specific posts", "specific", "post id", "post ids"),
								$d => __("Enter a list of Post ID's to include in the Slider, or select 'Popular/Recent' to populate the list automatically", 'revsliderhelp'),
								$a => $u . "post-based-sliders/",
								$hl => array(
									$dp => array(
										array($p => 'settings.sourcetype', $v => 'post', $o => 'slider_sourcetype_post'), 
										array($p => 'settings.source.post.subType', $v => 'specific_post', $o => 'settings_source_post_subtype', 'target' => 'specific_post')
									), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_post_selection', 
									$f => "#sr_source_post_list"
								)
							),
							'post_sorting_and_settings' => array(
								'sort_by' => array(
									$t => __("Sort Posts By", 'revsliderhelp'),
									$h => "source.post.sortBy",
									$k => array("post", "posts", "sort", "sorting", "post sorting", ""),
									$d => __("Choose the order in which the posts should appear in the Slider", 'revsliderhelp'),
									$a => $u . "module-content/#post-based",
									$hl => array(
										$dp => array(
											array($p => 'settings.sourcetype', $v => 'post::woo', $o => 'slider_sourcetype_post'), 
											array('dependency' => 'post', $p => 'settings.source.post.subType', $v => 'post::specific_post', $o => 'settings_source_post_subtype', 'target' => 'post')
										), 
										$m => "#module_settings_trigger, #gst_sl_4", 
										$st => '#form_slider_content_post_sort, #form_slider_content_woo_sort', 
										$f => "#post_sortby, #woo_sortby"
									)
								),
								'sort_direction' => array(
									$t => __("Sort Direction", 'revsliderhelp'),
									$h => "source.post.sortDirection",
									$k => array("post", "posts", "sort", "sorting", "post sorting", "sort direction"),
									$d => __("Sort the posts in ascending or descending order", 'revsliderhelp'),
									$a => $u . "module-content/#post-based",
									$hl => array(
										$dp => array(
											array($p => 'settings.sourcetype', $v => 'post::woo', $o => 'slider_sourcetype_post'), 
											array('dependency' => 'post', $p => 'settings.source.post.subType', $v => 'post::specific_post', $o => 'settings_source_post_subtype', 'target' => 'post')
										), 
										$m => "#module_settings_trigger, #gst_sl_4", 
										$st => '#form_slider_content_post_sort, #form_slider_content_woo_sort', 
										$f => "*[name='slidersourcesortDirection'][value='DESC'], *[name='slidersourcesortwooDirection'][value='DESC']"
									)
								),
								'max_posts' => array(
									$t => __("Max Posts", 'revsliderhelp'),
									$h => "source.post.maxPosts",
									$k => array("post", "posts", "max posts", "max number", "max"),
									$d => __("Choose the maximum number of Posts that should be included in the Slider", 'revsliderhelp'),
									$a => $u . "module-content/#post-based",
									$hl => array(
										$dp => array(
											array($p => 'settings.sourcetype', $v => 'post::woo', $o => 'slider_sourcetype_post'), 
											array('dependency' => 'post', $p => 'settings.source.post.subType', $v => 'post::specific_post', $o => 'settings_source_post_subtype', 'target' => 'post')
										), 
										$m => "#module_settings_trigger, #gst_sl_4", 
										$st => '#form_slider_content_post_sort, #form_slider_content_woo_sort', 
										$f => "#sr_source_post_maxposts, #sr_source_woo_maxposts"
									)
								),
								'excerpt_limit' => array(
									$t => __("Limit Excerpt", 'revsliderhelp'),
									$h => "source.post.excerptLimit",
									$k => array("post", "posts", "excerpt", "post excerpt", "limit excerpt"),
									$d => __("Se a character limit  if the post's excerpt is included in the Slide", 'revsliderhelp'),
									$a => $u . "module-content/#post-based",
									$hl => array(
										$dp => array(
											array($p => 'settings.sourcetype', $v => 'post::woo', $o => 'slider_sourcetype_post'), 
											array('dependency' => 'post', $p => 'settings.source.post.subType', $v => 'post::specific_post', $o => 'settings_source_post_subtype', 'target' => 'post')
										), 
										$m => "#module_settings_trigger, #gst_sl_4", 
										$st => '#form_slider_content_post_sort, #form_slider_content_woo_sort', 
										$f => "#sr_source_post_limitexc, #sr_source_woo_limitexc"
									)
								)
							)
						),
						'woocommerce_filters' => array(
							'regular_price_from' => array(
								$t => __("Reg. Price From", 'revsliderhelp'),
								$h => "source.woo.regPriceFrom",
								$k => array("woo", "woocommerce", "woo commerce", "filters", "price", "regular price", "product", "products"),
								$d => __("Pull in products with this minimum price", 'revsliderhelp'),
								$a => $u . "module-content/#woocommerce",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'woo', $o => 'slider_sourcetype_woo')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_woo_filters', 
									$f => "#sr_source_woo_regPriceFrom"
								)
							),
							'regular_price_to' => array(
								$t => __("Reg. Price To", 'revsliderhelp'),
								$h => "source.woo.regPriceTo",
								$k => array("woo", "woocommerce", "woo commerce", "filters", "price", "regular price", "product", "products"),
								$d => __("Pull in products with a regular price equal to or below this number", 'revsliderhelp'),
								$a => $u . "module-content/#woocommerce",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'woo', $o => 'slider_sourcetype_woo')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_woo_filters', 
									$f => "#sr_source_woo_regPriceTo"
								)
							),
							'sale_price_from' => array(
								$t => __("Sale Price From", 'revsliderhelp'),
								$h => "source.woo.salePriceFrom",
								$k => array("woo", "woocommerce", "woo commerce", "filters", "sale", "price", "sale price", "product", "products"),
								$d => __("Pull in products with this minimum sale price", 'revsliderhelp'),
								$a => $u . "module-content/#woocommerce",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'woo', $o => 'slider_sourcetype_woo')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_woo_filters', 
									$f => "#sr_source_woo_salePriceFrom"
								)
							),
							'sale_price_to' => array(
								$t => __("Sale Price To", 'revsliderhelp'),
								$h => "source.woo.salePriceTo",
								$k => array("woo", "woocommerce", "woo commerce", "filters", "sale", "price", "sale price", "product", "products"),
								$d => __("Pull in products with a sale price equal to or below this number", 'revsliderhelp'),
								$a => $u . "module-content/#woocommerce",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'woo', $o => 'slider_sourcetype_woo')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_woo_filters', 
									$f => "#sr_source_woo_salePriceTo"
								)
							),
							'in_stock_only' => array(
								$t => __("In Stock Only", 'revsliderhelp'),
								$h => "source.woo.inStockOnly",
								$k => array("woo", "woocommerce", "woo commerce", "in stock", "in stock only"),
								$d => __("Only pull in products that are marked as 'In Stock'", 'revsliderhelp'),
								$a => $u . "module-content/#woocommerce",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'woo', $o => 'slider_sourcetype_woo')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_woo_filters', 
									$f => "#sr_woo_stock"
								)
							),
							'featured_only' => array(
								$t => __("Featured Only", 'revsliderhelp'),
								$h => "source.woo.featuredOnly",
								$k => array("woo", "woocommerce", "woo commerce", "featured", "featured products"),
								$d => __("Only pull in products that are marked as 'Featured'", 'revsliderhelp'),
								$a => $u . "module-content/#woocommerce",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'woo', $o => 'slider_sourcetype_woo')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_woo_filters', 
									$f => "#sr_woo_feat"
								)
							)
						),
						'flickr_settings' => array(
							'num_slides' => array(
								$t => __("Total Slides", 'revsliderhelp'),
								$h => "source.flickr.count",
								$k => array("flickr", "gallery"),
								$d => __("Choose how many Slides should be created from the Flickr source", 'revsliderhelp'),
								$a => $u . "module-content/#flickr",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'flickr', $o => 'slider_sourcetype_flickr')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_flickr', 
									$f => "#sr_source_flickr_count"
								)
							),
							'cache' => array(
								$t => __("API Cache", 'revsliderhelp'),
								$h => "source.flickr.transient",
								$k => array("flickr", "gallery", "cache"),
								$d => __("Cache the Flickr API results for faster loading", 'revsliderhelp'),
								$a => $u . "module-content/#flickr",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'flickr', $o => 'slider_sourcetype_flickr')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_flickr', 
									$f => "#sr_source_flickr_transient"
								)
							),
							'api_key' => array(
								$t => __("API Key", 'revsliderhelp'),
								$h => "source.flickr.apiKey",
								$k => array("flickr", "gallery", "api", "api key"),
								$d => __("Enter your Flickr API key.  <a href='http://weblizar.com/get-flickr-api-key/' target='_blank'>Learn more</a>", 'revsliderhelp'),
								$a => $u . "module-content/#flickr",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'flickr', $o => 'slider_sourcetype_flickr')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_flickr', 
									$f => "#sr_source_flickr_apikey"
								)
							),
							'source' => array(
								$di => 'slilder_source_flickr_type',
								$t => __("API Source", 'revsliderhelp'),
								$h => "source.flickr.type",
								$k => array("source", "flickr", "gallery", "api", "api source", "flickr source"),
								$d => __("Choose which type of Flickr content should be pulled into the Slider", 'revsliderhelp'),
								$a => $u . "module-content/#flickr",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'flickr', $o => 'slider_sourcetype_flickr')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_flickr', 
									$f => "#flickr-type"
								)
							),
							'user_url' => array(
								$t => __("User URL", 'revsliderhelp'),
								$h => "source.flickr.userURL",
								$k => array("flickr", "gallery", "api", "user url"),
								$d => __("Enter your Flickr user URL for the API query", 'revsliderhelp'),
								$a => $u . "module-content/#flickr",
								$hl => array(
									$dp => array(
										array($p => 'settings.sourcetype', $v => 'flickr', $o => 'slider_sourcetype_flickr'),
										array($p => 'settings.source.flickr.type', $v => 'publicphotos::photosets', $o => 'slilder_source_flickr_type'),
									), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_flickr', 
									$f => "*[name='sr_src_flick_userurl']"
								)
							),
							'photoset' => array(
								$t => __("Photoset", 'revsliderhelp'),
								$h => "source.flickr.photoSet",
								$k => array("flickr", "photoset", "flickr photoset", "flickr photos"),
								$d => __("Select the photo album you wish to include from the Flickr account", 'revsliderhelp'),
								$a => $u . "module-content/#flickr",
								$hl => array(
									$dp => array(
										array($p => 'settings.sourcetype', $v => 'flickr', $o => 'slider_sourcetype_flickr'),
										array($p => 'settings.source.flickr.type', $v => 'photosets', $o => 'slilder_source_flickr_type'),
									), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_flickr', 
									$f => "#sr_src_flickr_photoset"
								)
							),
							'gallery_url' => array(
								$t => __("Gallery URL", 'revsliderhelp'),
								$h => "source.flickr.galleryURL",
								$k => array("flickr", "gallery", "gallery url", "flickr gallery url"),
								$d => __("Enter the absolute URL of the flickr gallery you wish to include", 'revsliderhelp'),
								$a => $u . "module-content/#flickr",
								$hl => array(
									$dp => array(
										array($p => 'settings.sourcetype', $v => 'flickr', $o => 'slider_sourcetype_flickr'),
										array($p => 'settings.source.flickr.type', $v => 'gallery', $o => 'slilder_source_flickr_type'),
									), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_flickr', 
									$f => "*[name='sr_src_flick_galleryurl']"
								)
							),
							'group_url' => array(
								$t => __("Group URL", 'revsliderhelp'),
								$h => "source.flickr.groupURL",
								$k => array("flickr", "flickr group", "group", "group url", "flickr group url"),
								$d => __("Enter the absolute URL of the flickr group irl you wish to include", 'revsliderhelp'),
								$a => $u . "module-content/#flickr",
								$hl => array(
									$dp => array(
										array($p => 'settings.sourcetype', $v => 'flickr', $o => 'slider_sourcetype_flickr'),
										array($p => 'settings.source.flickr.type', $v => 'group', $o => 'slilder_source_flickr_type'),
									), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_flickr', 
									$f => "*[name='sr_src_flick_groupyurl']"
								)
							)
						),
						'instagram_settings' => array(
							'num_slides' => array(
								$t => __("Total Slides", 'revsliderhelp'),
								$h => "source.instagram.count",
								$k => array("instagram", "gallery"),
								$d => __("Choose how many Slides should be created from the Instagram source", 'revsliderhelp'),
								$a => $u . "module-content/#instagram",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'instagram', $o => 'slider_sourcetype_instagram')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_insta', 
									$f => "#sr_source_instagram_count"
								)
							),
							'cache' => array(
								$t => __("API Cache", 'revsliderhelp'),
								$h => "source.instagram.transient",
								$k => array("instagram", "gallery", "cache"),
								$d => __("Cache the Instagram API results for faster loading", 'revsliderhelp'),
								$a => $u . "module-content/#instagram",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'instagram', $o => 'slider_sourcetype_instagram')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_insta', 
									$f => "#sr_source_instagram_transient"
								)
							),
							'source' => array(
								$t => __("API Source", 'revsliderhelp'),
								$h => "source.instagram.type",
								$k => array("source", "instagram", "gallery", "api", "api source", "instagram source"),
								$d => __("Choose which type of Instagram content should be pulled into the Slider", 'revsliderhelp'),
								$a => $u . "module-content/#instagram",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'instagram', $o => 'slider_sourcetype_instagram')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_insta', 
									$f => "#instagram-type"
								)
							),
							'user_name' => array(
								$t => __("User Name", 'revsliderhelp'),
								$h => "source.instagram.userId",
								$k => array("instagram", "gallery", "api", "username", "user name"),
								$d => __("Enter your Instagram User Name for the API query", 'revsliderhelp'),
								$a => $u . "module-content/#instagram",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'instagram', $o => 'slider_sourcetype_instagram')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_insta', 
									$f => "*[name='sr_src_instagram_userid']"
								)
							)
						),
						'twitter_settings' => array(
							'num_slides' => array(
								$t => __("Total Slides", 'revsliderhelp'),
								$h => "source.twitter.count",
								$k => array("twitter"),
								$d => __("Choose how many Slides should be created from the Twitter source", 'revsliderhelp'),
								$a => $u . "module-content/#twitter",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'twitter', $o => 'slider_sourcetype_twitter')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_twitter', 
									$f => "#sr_source_twitter_count"
								)
							),
							'cache' => array(
								$t => __("API Cache", 'revsliderhelp'),
								$h => "source.twitter.transient",
								$k => array("twitter", "gallery", "cache"),
								$d => __("Cache the Twitter API results for faster loading", 'revsliderhelp'),
								$a => $u . "module-content/#twitter",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'twitter', $o => 'slider_sourcetype_twitter')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_twitter', 
									$f => "#sr_source_twitter_transient"
								)
							),
							'user_name' => array(
								$t => __("User Handle", 'revsliderhelp'),
								$h => "source.twitter.userId",
								$k => array("twitter", "api", "userid", "user id"),
								$d => __("Enter your Twitter User Name/Handle for the API query", 'revsliderhelp'),
								$a => $u . "module-content/#twitter",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'twitter', $o => 'slider_sourcetype_twitter')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_twitter', 
									$f => "*[name='sr_src_twitter_userid']"
								)
							),
							'text_tweets' => array(
								$t => __("Text Tweets", 'revsliderhelp'),
								$h => "source.twitter.imageOnly",
								$k => array("twitter", "tweets", "text tweets"),
								$d => __("Include text-only Tweets (tweets that do not contain an image)", 'revsliderhelp'),
								$a => $u . "module-content/#twitter",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'twitter', $o => 'slider_sourcetype_twitter')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_twitter', 
									$f => "#sr_src_twitter_imageonly"
								)
							),
							'retweets' => array(
								$t => __("Re-Tweets", 'revsliderhelp'),
								$h => "source.twitter.includeRetweets",
								$k => array("twitter", "tweets", "retweets", "re-tweets"),
								$d => __("Include both tweets and re-tweets in the Slider", 'revsliderhelp'),
								$a => $u . "module-content/#twitter",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'twitter', $o => 'slider_sourcetype_twitter')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_twitter', 
									$f => "#sr_src_twitter_includeretweets"
								)
							),
							'replies' => array(
								$t => __("Replies", 'revsliderhelp'),
								$h => "source.twitter.excludeReplies",
								$k => array("twitter", "tweets", "replies"),
								$d => __("Include both tweets and replies in the Slider", 'revsliderhelp'),
								$a => $u . "module-content/#twitter",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'twitter', $o => 'slider_sourcetype_twitter')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_twitter', 
									$f => "#sr_src_twitter_excludereplies"
								)
							),
							'consumer_key' => array(
								$t => __("Consumer Key", 'revsliderhelp'),
								$h => "source.twitter.consumerKey",
								$k => array("twitter", "api key", "consumer", "consumer key"),
								$d => __("Your <a href='https://dev.twitter.com/apps' target='_blank'>Twitter App's</a> Consumer Key", 'revsliderhelp'),
								$a => $u . "module-content/#twitter",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'twitter', $o => 'slider_sourcetype_twitter')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_twitter', 
									$f => "*[name='sr_src_twitter_consumerKey']"
								)
							),
							'consumer_secret' => array(
								$t => __("Consumer Secret", 'revsliderhelp'),
								$h => "source.twitter.consumerSecret",
								$k => array("twitter", "api key", "consumer", "consumer secret", "secret"),
								$d => __("Your <a href='https://dev.twitter.com/apps' target='_blank'>Twitter App's</a> Consumer Secret", 'revsliderhelp'),
								$a => $u . "module-content/#twitter",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'twitter', $o => 'slider_sourcetype_twitter')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_twitter', 
									$f => "*[name='sr_src_twitter_consumerSecret']"
								)
							),
							'access_token' => array(
								$t => __("Access Token", 'revsliderhelp'),
								$h => "source.twitter.accessToken",
								$k => array("twitter", "api key", "access token", "token"),
								$d => __("Your <a href='https://dev.twitter.com/apps' target='_blank'>Twitter App's</a> Access Token", 'revsliderhelp'),
								$a => $u . "module-content/#twitter",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'twitter', $o => 'slider_sourcetype_twitter')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_twitter', 
									$f => "*[name='sr_src_twitter_accessToken']"
								)
							),
							'access_secret' => array(
								$t => __("Access Secret", 'revsliderhelp'),
								$h => "source.twitter.accessSecret",
								$k => array("twitter", "api key", "access secret. secret"),
								$d => __("Your <a href='https://dev.twitter.com/apps' target='_blank'>Twitter App's</a> Access Secret", 'revsliderhelp'),
								$a => $u . "module-content/#twitter",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'twitter', $o => 'slider_sourcetype_twitter')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_twitter', 
									$f => "*[name='sr_src_twitter_accessSecret']"
								)
							)
						),
						'facebook_settings' => array(
							'num_slides' => array(
								$t => __("Total Slides", 'revsliderhelp'),
								$h => "source.facebook.count",
								$k => array("facebook"),
								$d => __("Choose how many Slides should be created from the Facebook source", 'revsliderhelp'),
								$a => $u . "module-content/#facebook",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'facebook', $o => 'slider_sourcetype_facebook')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_facebook', 
									$f => "#sr_source_facebook_count"
								)
							),
							'cache' => array(
								$t => __("API Cache", 'revsliderhelp'),
								$h => "source.facebook.transient",
								$k => array("facebook", "gallery", "cache"),
								$d => __("Cache the Facebook API results for faster loading", 'revsliderhelp'),
								$a => $u . "module-content/#facebook",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'facebook', $o => 'slider_sourcetype_facebook')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_facebook', 
									$f => "#sr_source_facebook_transient"
								)
							),
							'source' => array(
								$di => "slider_source_facebook_typesource",
								$t => __("Source", 'revsliderhelp'),
								$h => "source.facebook.typeSource",
								$k => array("source", "facebook", "facebook source"),
								$d => __("Choose which type of Facebook content should be pulled into the Slider", 'revsliderhelp'),
								$a => $u . "module-content/#facebook",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'facebook', $o => 'slider_sourcetype_facebook')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_facebook', 
									$f => "#facebook-typesource"
								)
							),
							'album' => array(
								$t => __("Album", 'revsliderhelp'),
								$h => "source.facebook.album",
								$k => array("source", "facebook", "facebook album"),
								$d => __("Choose the Facebook Album to be pulled into the Slider", 'revsliderhelp'),
								$a => $u . "module-content/#facebook",
								$hl => array(
									$dp => array(
										array($p => 'settings.sourcetype', $v => 'facebook', $o => 'slider_sourcetype_facebook'),
										array($p => 'settings.source.facebook.typeSource', $v => 'album', $o => 'slider_source_facebook_typesource')
									), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_facebook', 
									$f => "#sr_src_facebok_album"
								)
							),
							'app_id' => array(
								$t => __("Access Token", 'revsliderhelp'),
								$h => "source.facebook.appId",
								$k => array("facebook", "app id"),
								$d => __("<a href='https://www.themepunch.com/faq/facebook-stream-setup-instructions-access-token/' target='_blank'>Generate</a> a Facebook Access Token with the needed permissions", 'revsliderhelp'),
								$a => $u . "module-content/#facebook",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'facebook', $o => 'slider_sourcetype_facebook')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_facebook', 
									$f => "*[name='sr_src_facebook_appid']"
								)
							),
							'app_secret' => array(
								$t => __("App Secret", 'revsliderhelp'),
								$h => "source.facebook.appSecret",
								$k => array("facebook", "api secret", "app secret. secret"),
								$d => __("Your <a href='https://developers.facebook.com/docs/apps/register' target='_blank'>Facebook App's</a> App Secret", 'revsliderhelp'),
								$a => $u . "module-content/#facebook",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'facebook', $o => 'slider_sourcetype_facebook')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_facebook', 
									$f => "*[name='sr_src_facebook_appsecret']"
								)
							)
						),
						'youtube_settings' => array(
							'num_slides' => array(
								$t => __("Total Slides", 'revsliderhelp'),
								$h => "source.youtube.count",
								$k => array("youtube", "video stream", "youtube stream", "stream"),
								$d => __("Choose how many Slides should be created from the YouTube source", 'revsliderhelp'),
								$a => $u . "module-content/#youtube",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'youtube', $o => 'slider_sourcetype_youtube')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_youtube', 
									$f => "#sr_source_youtube_count"
								)
							),
							'cache' => array(
								$t => __("API Cache", 'revsliderhelp'),
								$h => "source.youtube.transient",
								$k => array("youtube", "video stream", "youtube stream", "stream"),
								$d => __("Cache the YouTube API results for faster loading", 'revsliderhelp'),
								$a => $u . "module-content/#youtube",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'youtube', $o => 'slider_sourcetype_youtube')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_youtube', 
									$f => "#sr_source_youtube_transient"
								)
							),
							'api_key' => array(
								$t => __("API Key", 'revsliderhelp'),
								$h => "source.youtube.api",
								$k => array("youtube", "video stream", "youtube stream", "stream", "api key"),
								$d => __("Enter your YouTube API key.  <a href='https://developers.google.com/youtube/v3/getting-started#before-you-start' target='_blank'>Learn more</a>", 'revsliderhelp'),
								$a => $u . "module-content/#youtube",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'youtube', $o => 'slider_sourcetype_youtube')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_youtube', 
									$f => "*[name='sr_src_youtube_api']"
								)
							),
							'channel_id' => array(
								$t => __("Channel ID", 'revsliderhelp'),
								$h => "source.youtube.channelId",
								$k => array("youtube", "stream", "youtube channel", "channel id"),
								$d => __("Enter the channel ID of the YouTube account", 'revsliderhelp'),
								$a => $u . "module-content/#youtube",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'youtube', $o => 'slider_sourcetype_youtube')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_youtube', 
									$f => "*[name='sr_src_youtube_channelId']"
								)
							),
							'source' => array(
								$di => "slider_source_youtube_source",
								$t => __("Source", 'revsliderhelp'),
								$h => "source.youtube.typeSource",
								$k => array("source", "youtube", "youtube source", "youtube playlist", "youtube channel", "video playlist"),
								$d => __("Choose to include videos from a YouTube Playlist or Channel", 'revsliderhelp'),
								$a => $u . "module-content/#youtube",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'youtube', $o => 'slider_sourcetype_youtube')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_youtube', 
									$f => "#youtube-typesource"
								)
							),
							'playlist' => array(
								$t => __("Playlist", 'revsliderhelp'),
								$h => "source.youtube.playList",
								$k => array("youtube", "stream", "youtube source", "playlist", "youtube playlist"),
								$d => __("Choose the playlist to pull in from the YouTube account", 'revsliderhelp'),
								$a => $u . "module-content/#youtube",
								$hl => array(
									$dp => array(
										array($p => 'settings.sourcetype', $v => 'youtube', $o => 'slider_sourcetype_youtube'),
										array($p => 'settings.source.youtube.typeSource', $v => 'playlist', $o => 'slider_source_youtube_source')
									), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_youtube', 
									$f => "#sr_src_youtube_playlist"
								)
							)
						),
						'vimeo_settings' => array(
							'num_slides' => array(
								$t => __("Total Slides", 'revsliderhelp'),
								$h => "source.vimeo.count",
								$k => array("vimeo"),
								$d => __("Choose how many Slides should be created from the Vimeo source", 'revsliderhelp'),
								$a => $u . "module-content/#vimeo",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'vimeo', $o => 'slider_sourcetype_vimeo')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_vimeo', 
									$f => "#sr_source_vimeo_count"
								)
							),
							'cache' => array(
								$t => __("API Cache", 'revsliderhelp'),
								$h => "source.vimeo.transient",
								$k => array("vimeo", "gallery", "cache"),
								$d => __("Cache the Vimeo API results for faster loading", 'revsliderhelp'),
								$a => $u . "module-content/#vimeo",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'vimeo', $o => 'slider_sourcetype_vimeo')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_vimeo', 
									$f => "#sr_source_vimeo_transient"
								)
							),
							'source' => array(
								$t => __("Page URL", 'revsliderhelp'),
								$h => "source.vimeo.typeSource",
								$k => array("source", "vimeo", "vimeo source"),
								$d => __("Choose which type of Vimeo content should be pulled into the Slider", 'revsliderhelp'),
								$a => $u . "module-content/#vimeo",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'vimeo', $o => 'slider_sourcetype_vimeo')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_vimeo', 
									$f => "#vimeo-typesource"
								)
							),
							'user_album_group_channel' => array(
								$t => __("User/Album/Group/Channel", 'revsliderhelp'),
								$h => "source.vimeo.userName, source.vimeo.albumId, source.vimeo.groupName, source.vimeo.channelName",
								$k => array("vimeo", "vimeo user", "vimeo username", "vimeo user name", "vimeo album", "vimeo group", "vimeo channel"),
								$d => __("Enter the username, album ID, group name or channel name of the Vimeo account to use as the stream", 'revsliderhelp'),
								$a => $u . "module-content/#vimeo",
								$hl => array(
									$dp => array(array($p => 'settings.sourcetype', $v => 'vimeo', $o => 'slider_sourcetype_vimeo')), 
									$m => "#module_settings_trigger, #gst_sl_4", 
									$st => '#form_slider_content_vimeo', 
									$f => "#sr_src_vimeo_userName, #sr_src_vimeo_albumId, #sr_src_vimeo_groupName, #sr_src_vimeo_channelName"
								)
							)
						)
					),
					'gst_sl_5' => array(
						'slider_id' => array(
							$t => __("Slider ID", 'revsliderhelp'),
							$h => "id",
							$k => array("slider id", "id", "default", "defaults"),
							$d => __("Add an optional ID for the Slider.  Will be applied to the Slider's outer HTML wrapper element", 'revsliderhelp'),
							$a => $u . "module-defaults/",
							$hl => array($m => "#module_settings_trigger, #gst_sl_5", $st => '#form_slidergeneral_defaults', $f => "#sr_sliderid")
						),
						'slider_classes' => array(
							$t => __("Slider Classes", 'revsliderhelp'),
							$h => "class",
							$k => array("slider class", "class", "classes", "slider classes"),
							$d => __("Add an optional ID for the Slider.  Will be applied to the Slider's outer HTML wrapper element", 'revsliderhelp'),
							$a => $u . "module-defaults/",
							$hl => array($m => "#module_settings_trigger, #gst_sl_5", $st => '#form_slidergeneral_defaults', $f => "#sr_sliderclass")
						),
						'wrapper_classes' => array(
							$t => __("Wrapper Classes", 'revsliderhelp'),
							$h => "wrapperclass",
							$k => array("wrapper class", "class", "classes", "wrapper classes"),
							$d => __("Add an optional ID for the Slider.  Will be applied to the Slider's outer HTML wrapper element", 'revsliderhelp'),
							$a => $u . "module-defaults/",
							$hl => array($m => "#module_settings_trigger, #gst_sl_5", $st => '#form_slidergeneral_defaults', $f => "#sr_wrapperclass")
						),
						'slide_duration' => array(
							$t => __("Slide Duration", 'revsliderhelp'),
							$h => "def.delay",
							$k => array("slide duration", "duration", "time", "timeline", "default", "defaults"),
							$d => __("The default duration to apply for each Slide before they change", 'revsliderhelp'),
							$a => $u . "module-defaults/",
							$hl => array($m => "#module_settings_trigger, #gst_sl_5", $st => '#form_slidergeneral_defaults', $f => "#sr_def_delay")
						),
						'init_delay' => array(
							$t => __("Initialization Delay", 'revsliderhelp'),
							$h => "general.slideshow.initDelay",
							$k => array("init", "initialization", "delay", "initialization delay", "default", "defaults"),
							$d => __("Add an optional delay before the Slider officially loads", 'revsliderhelp'),
							$a => $u . "module-defaults/",
							$hl => array($m => "#module_settings_trigger, #gst_sl_5", $st => '#form_slidergeneral_defaults', $f => "#sr_sshow_initdelay")
						),
						'layers_selectable' => array(
							$t => __("Layers Selectable", 'revsliderhelp'),
							$h => "general.layerSelection",
							$k => array("layers", "layers selectable", "selectable", "default", "defaults"),
							$d => __("Choose if Layers should be user-selectable by default", 'revsliderhelp'),
							$a => $u . "module-defaults/",
							$hl => array($m => "#module_settings_trigger, #gst_sl_5", $st => '#form_slidergeneral_defaults', $f => "#sr_layersselectable")
						),
						'transition' => array(
							$t => __("Transition", 'revsliderhelp'),
							$h => "def.transition",
							$k => array("default transition", "transition", "default", "defaults"),
							$d => __("The default transition to be applied to newly created Slides", 'revsliderhelp'),
							$a => $u . "module-defaults/",
							$hl => array($m => "#module_settings_trigger, #gst_sl_5", $st => '#form_slidergeneral_defaults_animation', $f => "#sr_def_slide_transition")
						),
						'duration' => array(
							$t => __("Transition Duration", 'revsliderhelp'),
							$h => "def.transitionDuration",
							$k => array("default duration", "duration", "default", "defaults"),
							$d => __("The default transition duration to be applied to newly created Slides", 'revsliderhelp'),
							$a => $u . "module-defaults/",
							$hl => array($m => "#module_settings_trigger, #gst_sl_5", $st => '#form_slidergeneral_defaults_animation', $f => "#sr_def_tduration")
						),
						'image_settings' => array(
							'image_size' => array(
								$t => __("Default Image Size", 'revsliderhelp'),
								$h => "def.background.imageSourceType",
								$k => array("image size", "image source", "default", "defaults"),
								$d => __("The default WordPress Image size to be used for the Slide's main  background images", 'revsliderhelp'),
								$a => $u . "module-defaults/",
								$hl => array($m => "#module_settings_trigger, #gst_sl_5", $st => '#form_slidergeneral_defaults_imagesettings', $f => "#sr_def_image_source_type")
							),
							'position' => array(
								$t => __("Default BG Position", 'revsliderhelp'),
								$h => "def.background.position",
								$k => array("image", "images", "background", "bg", "bg image", "background position", "default", "defaults"),
								$d => __("The default CSS background-position for the Slide's main background image", 'revsliderhelp'),
								$a => $u . "module-defaults/",
								$hl => array($m => "#module_settings_trigger, #gst_sl_5", $st => '#form_slidergeneral_defaults_imagesettings', $f => "#slider_def_img__bg_position_center-center")
							),
							'fit' => array(
								$t => __("Default Image Fit", 'revsliderhelp'),
								$h => "def.background.fit",
								$k => array("background size", "fit", "image fit", "cover", "contain", "default", "defaults"),
								$d => __("The default css background-size value for the Slide's main background image", 'revsliderhelp'),
								$a => $u . "module-defaults/",
								$hl => array($m => "#module_settings_trigger, #gst_sl_5", $st => '#form_slidergeneral_defaults_imagesettings', $f => "#sr_defbgimage_fit")
							),
							'repeat' => array(
								$t => __("Default BG Repeat", 'revsliderhelp'),
								$h => "def.background.repeat",
								$k => array("background repeat", "repeat", "default", "defaults"),
								$d => __("The default css background-repeat value for the Slide's main background image", 'revsliderhelp'),
								$a => $u . "module-defaults/",
								$hl => array($m => "#module_settings_trigger, #gst_sl_5", $st => '#form_slidergeneral_defaults_imagesettings', $f => "#sr_defbgimage_repeat")
							)
						),
						'layer_defaults' => array(
							'intelligent_inheriting' => array(
								$t => __("Intelligent Inheriting", 'revsliderhelp'),
								$h => "def.intelligentInherit",
								$k => array("responsive", "intelligent inheriting", "responsive behavior"),
								$d => __("Automatically resize/reposition new Layers for each device viewport inside the editor", 'revsliderhelp'),
								$a => $u . "module-defaults/",
								$hl => array($m => "#module_settings_trigger, #gst_sl_5", $st => '#form_slidergeneral_layersettings', $f => "#sr_layer_intelligentinherit")
							),
							'responsive_between_device' => array(
								$t => __("Responsive Between Devices", 'revsliderhelp'),
								$h => "def.autoResponsive",
								$k => array("responsive", "resize", "resize layers", "resize layer", "layer resizing", "layer sizing", "responsive sizes", "responsive sizing"),
								$d => __("Automatically resize Layers for each responsive device viewport", 'revsliderhelp'),
								$a => $u . "module-defaults/",
								$hl => array($m => "#module_settings_trigger, #gst_sl_5", $st => '#form_slidergeneral_layersettings', $f => "#sr_layer_autoResponsive")
							),
							'responsive_offset' => array(
								$t => __("Responsive Offsets", 'revsliderhelp'),
								$h => "def.responsiveOffset",
								$k => array("responsive", "responsive offset", "responsive offsets"),
								$d => __("Automatically adjust the positioning for Layers for each responsive device viewport", 'revsliderhelp'),
								$a => $u . "module-defaults/",
								$hl => array($m => "#module_settings_trigger, #gst_sl_5", $st => '#form_slidergeneral_layersettings', $f => "#sr_layer_responsiveOffset")
							),
							'responsive_children' => array(
								$t => __("Responsive Children", 'revsliderhelp'),
								$h => "def.responsiveChilds",
								$k => array("responsive", "responsive children"),
								$d => __("Choose to resize the Layer's inner HTML elements if the Layer includes custom HTML", 'revsliderhelp'),
								$a => $u . "module-defaults/",
								$hl => array($m => "#module_settings_trigger, #gst_sl_5", $st => '#form_slidergeneral_layersettings', $f => "#sr_layer_responsiveChilds")
							)
						),
						'pan_zoom' => array(
							'enable' => array(
								$di => "slider_defaults_panzoom",
								$t => __("Enable PanZoom", 'revsliderhelp'),
								$h => "def.panZoom.set",
								$k => array("panzoom", "pan zoom"),
								$d => __("Enable the PanZoom effect by default for newly created Slides", 'revsliderhelp'),
								$a => $u . "module-defaults/",
								$hl => array($m => "#module_settings_trigger, #gst_sl_5", $st => '#form_slidergeneral_defaults_kbsettings', $f => "#sr_def_panzoom")
							),
							'easing' => array(
								$t => __("Easing", 'revsliderhelp'),
								$h => "def.panZoom.ease",
								$k => array("panzoom", "pan zoom", "easing", "pan zoom easing", "panzoom easing"),
								$d => __("The default easing equation.  <a href='https://greensock.com/ease-visualizer' target=_'blank'>View visualization</a>", 'revsliderhelp'),
								$a => $u . "module-defaults/",
								$hl => array(
									$dp => array(array($p => 'settings.def.panZoom.set', $v => true, $o => 'slider_defaults_panzoom')), 
									$m => "#module_settings_trigger, #gst_sl_5", $st => '#form_slidergeneral_defaults_kbsettings', $f => "#def_pz_ease"
								)
							),
							'duration' => array(
								$t => __("Duration", 'revsliderhelp'),
								$h => "def.panZoom.duration",
								$k => array("panzoom", "pan zoom", "duration", "pan zoom duration", "panzoom duration"),
								$d => __("The default easing duration in milliseconds", 'revsliderhelp'),
								$a => $u . "module-defaults/",
								$hl => array(
									$dp => array(array($p => 'settings.def.panZoom.set', $v => true, $o => 'slider_defaults_panzoom')), 
									$m => "#module_settings_trigger, #gst_sl_5", $st => '#form_slidergeneral_defaults_kbsettings', $f => "#sr_def_pz_pzdur"
								)
							),
							'zoom' => array(
								'fit_start' => array(
									$t => __("Zoom Start Percentage", 'revsliderhelp'),
									$h => "def.panZoom.fitStart",
									$k => array("panzoom", "pan zoom", "zoom", "pan zoom zoom", "panzoom zoom"),
									$d => __("The default starting zoom percentage", 'revsliderhelp'),
									$a => $u . "module-defaults/",
									$hl => array(
										$dp => array(array($p => 'settings.def.panZoom.set', $v => true, $o => 'slider_defaults_panzoom')), 
										$m => "#module_settings_trigger, #gst_sl_5", $st => '#form_slidergeneral_defaults_kbsettings', $f => "#sr_def_pz_sfit"
									)
								),
								'fit_end' => array(
									$t => __("Zoom End Percentage", 'revsliderhelp'),
									$h => "def.panZoom.fitEnd",
									$k => array("panzoom", "pan zoom", "zoom", "pan zoom zoom", "panzoom zoom"),
									$d => __("The default ending zoom percentage", 'revsliderhelp'),
									$a => $u . "module-defaults/",
									$hl => array(
										$dp => array(array($p => 'settings.def.panZoom.set', $v => true, $o => 'slider_defaults_panzoom')), 
										$m => "#module_settings_trigger, #gst_sl_5", $st => '#form_slidergeneral_defaults_kbsettings', $f => "#sr_def_pz_efit"
									)
								)
							),
							'movement' => array(
								'x_start' => array(
									$t => __("Start Position X", 'revsliderhelp'),
									$h => "def.panZoom.xStart",
									$k => array("panzoom", "pan zoom", "position", "pan zoom position", "panzoom position"),
									$d => __("The default starting x position for the PanZoom movement", 'revsliderhelp'),
									$a => $u . "module-defaults/",
									$hl => array(
										$dp => array(array($p => 'settings.def.panZoom.set', $v => true, $o => 'slider_defaults_panzoom')), 
										$m => "#module_settings_trigger, #gst_sl_5", $st => '#form_slidergeneral_defaults_kbsettings', $f => "#sr_def_pz_sox"
									)
								),
								'x_end' => array(
									$t => __("End Position X", 'revsliderhelp'),
									$h => "def.panZoom.xEnd",
									$k => array("panzoom", "pan zoom", "position", "pan zoom position", "panzoom position"),
									$d => __("The default end x position for the PanZoom movement", 'revsliderhelp'),
									$a => $u . "module-defaults/",
									$hl => array(
										$dp => array(array($p => 'settings.def.panZoom.set', $v => true, $o => 'slider_defaults_panzoom')), 
										$m => "#module_settings_trigger, #gst_sl_5", $st => '#form_slidergeneral_defaults_kbsettings', $f => "#sr_def_pz_eox"
									)
								),
								'y_start' => array(
									$t => __("Start Position Y", 'revsliderhelp'),
									$h => "def.panZoom.yStart",
									$k => array("panzoom", "pan zoom", "position", "pan zoom position", "panzoom position"),
									$d => __("The default starting y position for the PanZoom movement", 'revsliderhelp'),
									$a => $u . "module-defaults/",
									$hl => array(
										$dp => array(array($p => 'settings.def.panZoom.set', $v => true, $o => 'slider_defaults_panzoom')), 
										$m => "#module_settings_trigger, #gst_sl_5", $st => '#form_slidergeneral_defaults_kbsettings', $f => "#sr_def_pz_soy"
									)
								),
								'y_end' => array(
									$t => __("End Position Y", 'revsliderhelp'),
									$h => "def.panZoom.yEnd",
									$k => array("panzoom", "pan zoom", "position", "pan zoom position", "panzoom position"),
									$d => __("The default ending y position for the PanZoom movement", 'revsliderhelp'),
									$a => $u . "module-defaults/",
									$hl => array(
										$dp => array(array($p => 'settings.def.panZoom.set', $v => true, $o => 'slider_defaults_panzoom')), 
										$m => "#module_settings_trigger, #gst_sl_5", $st => '#form_slidergeneral_defaults_kbsettings', $f => "#sr_def_pz_eoy"
									)
								)
							),
							'rotation_blur' => array(
								'rotate_start' => array(
									$t => __("Rotate Start", 'revsliderhelp'),
									$h => "def.panZoom.rotateStart",
									$k => array("panzoom", "pan zoom", "rotate", "pan zoom rotate", "panzoom rotate", "rotation", "pan zoom rotation"),
									$d => __("The default starting rotation for the PanZoom effect (deg)", 'revsliderhelp'),
									$a => $u . "module-defaults/",
									$hl => array(
										$dp => array(array($p => 'settings.def.panZoom.set', $v => true, $o => 'slider_defaults_panzoom')), 
										$m => "#module_settings_trigger, #gst_sl_5", $st => '#form_slidergeneral_defaults_kbsettings', $f => "#sr_def_pz_sro"
									)
								),
								'rotate_end' => array(
									$t => __("Rotate End", 'revsliderhelp'),
									$h => "def.panZoom.rotateEnd",
									$k => array("panzoom", "pan zoom", "rotate", "pan zoom rotate", "panzoom rotate", "rotation", "pan zoom rotation"),
									$d => __("The default ending rotation for the PanZoom effect (deg)", 'revsliderhelp'),
									$a => $u . "module-defaults/",
									$hl => array(
										$dp => array(array($p => 'settings.def.panZoom.set', $v => true, $o => 'slider_defaults_panzoom')), 
										$m => "#module_settings_trigger, #gst_sl_5", $st => '#form_slidergeneral_defaults_kbsettings', $f => "#sr_def_pz_ero"
									)
								),
								'blur_start' => array(
									$t => __("Blur Start", 'revsliderhelp'),
									$h => "def.panZoom.blurStart",
									$k => array("panzoom", "pan zoom", "rotate", "pan zoom blur", "panzoom blur", "blur", "image blur"),
									$d => __("The default starting image blur for the PanZoom effect (px)", 'revsliderhelp'),
									$a => $u . "module-defaults/",
									$hl => array(
										$dp => array(array($p => 'settings.def.panZoom.set', $v => true, $o => 'slider_defaults_panzoom')), 
										$m => "#module_settings_trigger, #gst_sl_5", $st => '#form_slidergeneral_defaults_kbsettings', $f => "#sr_def_pz_sblur"
									)
								),
								'blur_end' => array(
									$t => __("Blur End", 'revsliderhelp'),
									$h => "def.panZoom.blurEnd",
									$k => array("panzoom", "pan zoom", "rotate", "pan zoom blur", "panzoom blur", "blur", "image blur"),
									$d => __("The default ending image blur for the PanZoom effect (px)", 'revsliderhelp'),
									$a => $u . "module-defaults/",
									$hl => array(
										$dp => array(array($p => 'settings.def.panZoom.set', $v => true, $o => 'slider_defaults_panzoom')), 
										$m => "#module_settings_trigger, #gst_sl_5", $st => '#form_slidergeneral_defaults_kbsettings', $f => "#sr_def_pz_eblur"
									)
								)
							)
						)
					),
					'gst_sl_6' => array(
						'viewport_stop' => array(
							'enable' => array(
								$di => "slider_general_slideshow_viewport",
								$t => __("Enable Viewport Stop", 'revsliderhelp'),
								$h => "general.slideshow.viewPort",
								$k => array("viewport", "slider viewport", "stop", "viewport stop"),
								$d => __("Only initialize the Slider when the Slider is inside the page's view", 'revsliderhelp'),
								$a => $u . "module-general-settings/",
								$hl => array($m => "#module_settings_trigger, #gst_sl_6", $st => '#form_slidergeneral_general_viewport', $f => "#sr_viewport")
							),
							'wait_pause' => array(
								$t => __("Wait/Pause", 'revsliderhelp'),
								$h => "general.slideshow.viewPortStart",
								$k => array("viewport", "slider viewport", "wait", "pause", "viewport wait", "viewport pause"),
								$d => __("'wait' to initialize the Slider when its inside the viewport, or 'pause' the Slider's progress until its inside the viewport", 'revsliderhelp'),
								$a => $u . "module-general-settings/",
								$hl => array(
									$dp => array(array($p => 'settings.general.slideshow.viewPort', $v => true, $o => 'slider_general_slideshow_viewport')), 
									$m => "#module_settings_trigger, #gst_sl_6", 
									$st => '#form_slidergeneral_general_viewport', 
									$f => "#sr_sshow_outviewport"
								)
							),
							'viewport_area' => array(
								$t => __("Area %", 'revsliderhelp'),
								$h => "general.slideshow.viewPortArea.#size#.v",
								$k => array("viewport", "slider viewport", "wait", "pause", "viewport wait", "viewport pause", "area", "viewport area"),
								$d => __("Initialize/Pause the Slider when its inside this percentage of the page's viewport", 'revsliderhelp'),
								$a => $u . "module-general-settings/",
								$hl => array(
									$dp => array(array($p => 'settings.general.slideshow.viewPort', $v => true, $o => 'slider_general_slideshow_viewport')), 
									$m => "#module_settings_trigger, #gst_sl_6", 
									$st => '#form_slidergeneral_general_viewport', 
									$f => "#sr_viewport_area"
								)
							),
							'preset_slider_height' => array(
								$t => __("Preset Slider Height", 'revsliderhelp'),
								$h => "general.slideshow.presetSliderHeight",
								$k => array("slider space", "preset slider height", "viewport"),
								$d => __("Allocate space on the page for the Slider to prevent page content jumps when the Slider loads", 'revsliderhelp'),
								$a => $u . "module-general-settings/",
								$hl => array(
									$dp => array(array($p => 'settings.general.slideshow.viewPort', $v => true, $o => 'slider_general_slideshow_viewport')), 
									$m => "#module_settings_trigger, #gst_sl_6", 
									$st => '#form_slidergeneral_general_viewport', 
									$f => "#sr_viewportpresetheight"
								)
							)
						),
						'slideshow' => array(
							'auto_rotate' => array(
								$di => 'slideshow_auto_rotate',
								$t => __("Auto Rotate Slideshow", 'revsliderhelp'),
								$h => "general.slideshow.slideShow",
								$k => array("stop", "pause", "stop slider", "pause slider", "progress"),
								$d => __("Enable autoplay for the Slider to automatically change between slides", 'revsliderhelp'),
								$a => $u . "module-general-settings/",
								$hl => array($m => "#module_settings_trigger, #gst_sl_6", $st => '#form_slidergeneral_general', $f => "#sr_slideshowonoff")
							),
							'stop_on_hover' => array(
								$t => __("Stop on Hover", 'revsliderhelp'),
								$h => "general.slideshow.stopOnHover",
								$k => array("hover", "autoplay", "slider progress", "stop on", "stop on hover", "stop slider", "pause", "pause slider", "pause slideshow"),
								$d => __("Pause the Slider's progress when the user hover's their mouse over it", 'revsliderhelp'),
								$a => $u . "module-general-settings/",
								$hl => array(
									$dp => array(array($p => 'settings.general.slideshow.slideShow', $v => true, $o => 'slideshow_auto_rotate')), 
									$m => "#module_settings_trigger, #gst_sl_6", 
									$st => '#form_slidergeneral_general', 
									$f => "#sr_ssonhover"
								)
							),
							'loop_single' => array(
								$t => __("Loop Single Slide", 'revsliderhelp'),
								$h => "general.slideshow.loopSingle",
								$k => array("loop", "loop slide", "single", "single slide", "loop single slide"),
								$d => __("Continuously loop a Slide's animations when the Slider contains only one slide", 'revsliderhelp'),
								$a => $u . "module-general-settings/",
								$hl => array(
									$dp => array(array($p => 'settings.general.slideshow.slideShow', $v => true, $o => 'slideshow_auto_rotate')), 
									$m => "#module_settings_trigger, #gst_sl_6", 
									$st => '#form_slidergeneral_general', 
									$f => "#sr_loopsingle"
								)
							),
							'stop_slider' => array(
								$di => "slider_general_slideshow_stopslider",
								$t => __("Stop Slider Progress", 'revsliderhelp'),
								$h => "general.slideshow.stopSlider",
								$k => array("stop", "pause", "stop slider", "pause at", "pause at slide", "autoplay", "auto play"),
								$d => __("Chose when the Slider's progress should stop/pause", 'revsliderhelp'),
								$a => $u . "module-general-settings/",
								$hl => array(
									$dp => array(array($p => 'settings.general.slideshow.slideShow', $v => true, $o => 'slideshow_auto_rotate')), 
									$m => "#module_settings_trigger, #gst_sl_6", 
									$st => '#form_slidergeneral_general', 
									$f => "#sr_disendloop"
								)
							),
							'stop_after_loops' => array(
								$t => __("Stop After Loops", 'revsliderhelp'),
								$h => "general.slideshow.stopAfterLoops",
								$k => array("stop", "pause", "stop slider", "pause at", "pause at slide", "autoplay", "auto play", "loop", "looping", "slider loop"),
								$d => __("Stop the slider's progress after a set amount of loops", 'revsliderhelp'),
								$a => $u . "module-general-settings/",
								$hl => array(
									$dp => array(array($p => 'settings.general.slideshow.slideShow', $v => true, $o => 'slideshow_auto_rotate')), 
									$m => "#module_settings_trigger, #gst_sl_6", 
									$st => '#form_slidergeneral_general', 
									$f => "#sr_sshw_amountloops"
								)
							),
							'stop_at_slide' => array(
								$t => __("Stop at Slide", 'revsliderhelp'),
								$h => "general.slideshow.stopAtSlide",
								$k => array("stop", "pause", "stop slider", "pause at", "pause at slide", "autoplay", "auto play", "loop", "looping", "slider loop", "stop at", "stop after"),
								$d => __("Stop the slider's progress when a certain Slide is viewed", 'revsliderhelp'),
								$a => $u . "module-general-settings/",
								$hl => array(
									$dp => array(array($p => 'settings.general.slideshow.slideShow', $v => true, $o => 'slideshow_auto_rotate')), 
									$m => "#module_settings_trigger, #gst_sl_6", 
									$st => '#form_slidergeneral_general', 
									$f => "#sr_sshw_atSlide"
								)
							),
							'random_order' => array(
								$t => __("Random Order", 'revsliderhelp'),
								$h => "general.slideshow.shuffle",
								$k => array("slide order", "shuffle", "shuffle slides", "random", "randomize", "random slide order", "randomize slides", "randomize slide order"),
								$d => __("Randomize the Slide order each time the Slider is viewed", 'revsliderhelp'),
								$a => $u . "module-general-settings/",
								$hl => array(
									$dp => array(array($p => 'settings.general.slideshow.slideShow', $v => true, $o => 'slideshow_auto_rotate')),
									$m => "#module_settings_trigger, #gst_sl_6", 
									$st => '#form_slidergeneral_general', 
									$f => "#sr_randomslideshow"
								)
							),
							'wait_for_api' => array(
								$t => __("Wait for API", 'revsliderhelp'),
								$h => "general.slideshow.waitForInit",
								$k => array("api", "wait for", "wait for api", "initialization"),
								$d => __("Only start the Slider when the JavaScript API's 'revstart()' method is called", 'revsliderhelp'),
								$a => $u . "module-general-settings/",
								$hl => array($m => "#module_settings_trigger, #gst_sl_6", $st => '#form_slidergeneral_slideshow', $f => "#sr_waitrevapi")
							)
						),
						'mobile_options' => array(
							'disable_slider' => array(
								$t => __("Disable Slider on Mobile", 'revsliderhelp'),
								$h => "general.disableOnMobile",
								$k => array("disable slider", "hide on mobile", "mobile"),
								$d => __("When the Slider is disabled on mobile it will only be loaded on desktop-based devices", 'revsliderhelp'),
								$a => $u . "module-general-settings/",
								$hl => array($m => "#module_settings_trigger, #gst_sl_6", $st => '#form_slidergeneral_general_disable_mobile', $f => "#sr_gen_disonmob")
							),
							'disable_panzoom' => array(
								$t => __("Disable PanZoom on Mobile", 'revsliderhelp'),
								$h => "general.disablePanZoomMobile",
								$k => array("disable", "disable panzoom", "disable pan zoom", "panzoom", "pan zoom"),
								$d => __("Disable the PanZoom effect for mobile devices", 'revsliderhelp'),
								$a => $u . "module-general-settings/",
								$hl => array($m => "#module_settings_trigger, #gst_sl_6", $st => '#form_slidergeneral_general_disable_mobile', $f => "#sr_gen_disablePanZoomMobile")
							)
						),
						'hide_content_under_width' => array(
							'hide_slider_under' => array(
								$t => __("Hide Slider Under Width", 'revsliderhelp'),
								$h => "visibility.hideSliderUnderLimit",
								$k => array("hide slider", "hide under width", "hide slider under width"),
								$d => __("Hide the Slider under a certain window width", 'revsliderhelp'),
								$a => $u . "module-general-settings/",
								$hl => array($m => "#module_settings_trigger, #gst_sl_6", $st => '#form_slidergeneral_general_under_browser_width', $f => "#sr_vis_hideSliderUnderLimit")
							),
							'hide_marked_under' => array(
								$t => __("Hide Marked Layers", 'revsliderhelp'),
								$h => "visibility.hideSelectedLayersUnderLimit",
								$k => array("hide layer", "hide layers", "hide under width", "hide layer under width", "marked", "marked layers"),
								$d => __("Individual Layers that are selected to be hidden under a width will be hidden under this number", 'revsliderhelp'),
								$a => $u . "module-general-settings/",
								$hl => array($m => "#module_settings_trigger, #gst_sl_6", $st => '#form_slidergeneral_general_under_browser_width', $f => "#sr_vis_hideSelectedLayersUnderLimit")
							),
							'hide_all_layers' => array(
								$t => __("Hide All Layers Under", 'revsliderhelp'),
								$h => "visibility.hideAllLayersUnderLimit",
								$k => array("hide layer", "hide layers", "hide under width", "hide layer under width", "all layers"),
								$d => __("Hide all Layers under when the window is below this number", 'revsliderhelp'),
								$a => $u . "module-general-settings/",
								$hl => array($m => "#module_settings_trigger, #gst_sl_6", $st => '#form_slidergeneral_general_under_browser_width', $f => "#sr_vis_hideAllLayersUnderLimit")
							)
						),
						'first_slide_options' => array(
							'alternate_slide' => array(
								$di => "slider_firstslide_alternativefirstslide",
								$t => __("Alternate First Slide", 'revsliderhelp'),
								$h => "general.firstSlide.alternativeFirstSlideSet",
								$k => array("first slide", "alternate", "alternate slide"),
								$d => __("Show a specific Slide first when the Slider first loads", 'revsliderhelp'),
								$a => $u . "module-general-settings/",
								$hl => array($m => "#module_settings_trigger, #gst_sl_6", $st => '#form_slidergeneral_general_first_slide', $f => "#sr_gen_alternativeFirstSlideSet")
							),
							'alternate_slide_number' => array(
								$t => __("Slide to Show First", 'revsliderhelp'),
								$h => "general.firstSlide.alternativeFirstSlide",
								$k => array("first slide", "alternate", "alternate slide"),
								$d => __("Show slide number 'x' first when the Slider first loads", 'revsliderhelp'),
								$a => $u . "module-general-settings/",
								$hl => array(
									$dp => array(array($p => 'settings.general.firstSlide.alternativeFirstSlideSet', $v => true, $o => 'slider_firstslide_alternativefirstslide')), 
									$m => "#module_settings_trigger, #gst_sl_6", 
									$st => '#form_slidergeneral_general_first_slide', 
									$f => "#sr_gen_firstSlide_alternativeFirstSlide"
								)
							),
							'first_slide_transition' => array(
								$di => "slider_general_firstslidetransition",
								$t => __("First Slide Animation", 'revsliderhelp'),
								$h => "general.firstSlide.set",
								$k => array("first slide", "first slide animation", "alternate animation"),
								$d => __("Use an alternate transition when for the first slide when the Slider firsts loads", 'revsliderhelp'),
								$a => $u . "module-general-settings/",
								$hl => array($m => "#module_settings_trigger, #gst_sl_6", $st => '#form_slidergeneral_general_first_slide', $f => "#sr_gen_fs")
							),
							'first_slide_transition_type' => array(
								$t => __("First Slide Transition Type", 'revsliderhelp'),
								$h => "general.firstSlide.type",
								$k => array("first slide", "first slide animation", "alternate animation", "transition", "first slide transition"),
								$d => __("Choose an alternate transition for the first Slide", 'revsliderhelp'),
								$a => $u . "module-general-settings/",
								$hl => array(
									$dp => array(array($p => 'settings.general.firstSlide.set', $v => true, $o => 'slider_general_firstslidetransition')), 
									$m => "#module_settings_trigger, #gst_sl_6", 
									$st => '#form_slidergeneral_general_first_slide', 
									$f => "#sr_gen_fs_transition"
								)
							),
							'first_slide_duration' => array(
								$t => __("First Slide Transition Duration", 'revsliderhelp'),
								$h => "general.firstSlide.duration",
								$k => array("first slide", "first slide duration", "alternate animation", "transition duration", "first slide transition duration"),
								$d => __("The duration to be used for the alternate first Slide transition", 'revsliderhelp'),
								$a => $u . "module-general-settings/",
								$hl => array(
									$dp => array(array($p => 'settings.general.firstSlide.set', $v => true, $o => 'slider_general_firstslidetransition')), 
									$m => "#module_settings_trigger, #gst_sl_6", 
									$st => '#form_slidergeneral_general_first_slide', 
									$f => "#sr_gen_fsduration"
								)
							),
							'slot_amount' => array(
								$t => __("Slot Amount", 'revsliderhelp'),
								$h => "general.firstSlide.slotAmount",
								$k => array("slots", "slot amount", "transition slots"),
								$d => __("The amount of slots to be used for the alternate first Slide transition.  Applicable to slot-based transitions.", 'revsliderhelp'),
								$a => $u . "module-general-settings/",
								$hl => array(
									$dp => array(array($p => 'settings.general.firstSlide.set', $v => true, $o => 'slider_general_firstslidetransition')), 
									$m => "#module_settings_trigger, #gst_sl_6", 
									$st => '#form_slidergeneral_general_first_slide', 
									$f => "#sr_gen_fsslotamount"
								)
							)
						),
						'browser_behavior' => array(
							'next_slide_on_focus' => array(
								$t => __("Next Slide on Focus", 'revsliderhelp'),
								$h => "general.nextSlideOnFocus",
								$k => array("next on focus", "tab focus", "tab blur", "next slide on focus"),
								$d => __("Change slides when the user navigates to a new window or tab and then returns to the page", 'revsliderhelp'),
								$a => $u . "module-general-settings/",
								$hl => array($m => "#module_settings_trigger, #gst_sl_6", $st => '#form_slidergeneral_misc', $f => "#sr_gen_nextSlideOnFocus")
							),
							'disable_blur_focus' => array(
								$t => __("Disable Blur/Focus behavior", 'revsliderhelp'),
								$h => "general.disableFocusListener",
								$k => array("blur", "focus", "disable blur"),
								$d => __("Disable Slider resizing when the user navigates away from the tab/window and returns to the page", 'revsliderhelp'),
								$a => $u . "module-general-settings/",
								$hl => array($m => "#module_settings_trigger, #gst_sl_6", $st => '#form_slidergeneral_misc', $f => "#sr_gen_disableFocusListener")
							)
						)
					),
					'gst_sl_3' => array(
						'layout' => array(
							'infinity_scroll' => array(
								$t => __("Infinity Scroll", 'revsliderhelp'),
								$h => "carousel.infinity",
								$k => array("carousel", "infinity", "scroll", "infinity scroll"),
								$d => __("Slides will continuously appear from either side when the Slides change", 'revsliderhelp'),
								$a => $u . "carousel-settings/",
								$hl => array(
									$dp => array(array($p => 'settings.type', $v => 'carousel', $o => 'slider_layout_type_carousel')), 
									$m => "#module_settings_trigger, #gst_sl_3", 
									$st => '#form_slidergeneral_caroussel', 
									$f => "#sr_ca_inf"
								)
							),
							'stopOnClick' => array(
								$t => __("Stop Progress On Click", 'revsliderhelp'),
								$h => "carousel.stopOnClick",
								$k => array("carousel", "stop", "scroll", "stop on click"),
								$d => __("Autorotate progress will get stopped if user clicks on slider", 'revsliderhelp'),
								$a => $u . "carousel-settings/",
								$hl => array(
									$dp => array(array($p => 'settings.type', $v => 'carousel', $o => 'slider_layout_type_carousel')), 
									$m => "#module_settings_trigger, #gst_sl_3", 
									$st => '#form_slidergeneral_caroussel', 
									$f => "#sr_ca_socl"
								)
							),
							'layers_visible' => array(
								$t => __("Layers Visible", 'revsliderhelp'),
								$h => "carousel.showAllLayers",
								$k => array("carousel", "layers visible", "show layers"),
								$d => __("Layers from Slides that are visible in the carousel will always be visible by default (Layer animations will be disabled)", 'revsliderhelp'),
								$a => $u . "carousel-settings/",
								$hl => array(
									$dp => array(array($p => 'settings.type', $v => 'carousel', $o => 'slider_layout_type_carousel')), 
									$m => "#module_settings_trigger, #gst_sl_3", 
									$st => '#form_slidergeneral_caroussel', 
									$f => "#sr_ca_showAllLayers"
								)
							),
							'max_items' => array(
								$t => __("Max Visible Slides", 'revsliderhelp'),
								$h => "carousel.maxItems",
								$k => array("carousel", "max visible", "max visible slides"),
								$d => __("The maximum number of Slides that will be visible at any given time.  View the documentation below to learn how to set a minimum.", 'revsliderhelp'),
								$a => $u . "carousel-settings/",
								$hl => array(
									$dp => array(array($p => 'settings.type', $v => 'carousel', $o => 'slider_layout_type_carousel')), 
									$m => "#module_settings_trigger, #gst_sl_3", 
									$st => '#form_slidergeneral_caroussel', 
									$f => "#sr_ca_mitems"
								)
							),
							'stretch_slides' => array(
								$t => __("Stretch Slides", 'revsliderhelp'),
								$h => "carousel.stretch",
								$k => array("carousel", "stretch", "stretch slides", "full width", "full width slides"),
								$d => __("Slides will always appear as full width, resulting in one Slide being visible at a time", 'revsliderhelp'),
								$a => $u . "carousel-settings/",
								$hl => array(
									$dp => array(array($p => 'settings.type', $v => 'carousel', $o => 'slider_layout_type_carousel')), 
									$m => "#module_settings_trigger, #gst_sl_3", 
									$st => '#form_slidergeneral_caroussel', 
									$f => "#sr_ca_stretch"
								)
							),
							'border_radius' => array(
								$t => __("Border Radius", 'revsliderhelp'),
								$h => "carousel.borderRadius",
								$k => array("carousel", "border radius", "carouse border radius"),
								$d => __("Add a CSS border-radius to the carousel items (px)", 'revsliderhelp'),
								$a => $u . "carousel-settings/",
								$hl => array(
									$dp => array(array($p => 'settings.type', $v => 'carousel', $o => 'slider_layout_type_carousel')), 
									$m => "#module_settings_trigger, #gst_sl_3", 
									$st => '#form_slidergeneral_caroussel', 
									$f => "#sr_ca_br"
								)
							),
							'space' => array(
								$t => __("Item Spacing", 'revsliderhelp'),
								$h => "carousel.space",
								$k => array("carousel", "carousel spacing", "item spacing", "space", "spacing"),
								$d => __("Define the spacing between the carousel items (px)", 'revsliderhelp'),
								$a => $u . "carousel-settings/",
								$hl => array(
									$dp => array(array($p => 'settings.type', $v => 'carousel', $o => 'slider_layout_type_carousel')), 
									$m => "#module_settings_trigger, #gst_sl_3", 
									$st => '#form_slidergeneral_caroussel', 
									$f => "#sr_ca_gap"
								)
							),
							'padding_top' => array(
								$t => __("Padding Top", 'revsliderhelp'),
								$h => "carousel.paddingTop",
								$k => array("carousel", "carousel padding", "carousel padding top", "padding top", "padding"),
								$d => __("Define the CSS padding-top for the carousel items (px)", 'revsliderhelp'),
								$a => $u . "carousel-settings/",
								$hl => array(
									$dp => array(array($p => 'settings.type', $v => 'carousel', $o => 'slider_layout_type_carousel')), 
									$m => "#module_settings_trigger, #gst_sl_3", 
									$st => '#form_slidergeneral_caroussel', 
									$f => "#sr_ca_pdt"
								)
							),
							'padding_bottom' => array(
								$t => __("Padding Bottom", 'revsliderhelp'),
								$h => "carousel.paddingBottom",
								$k => array("carousel", "carousel padding", "carousel padding bottom", "padding bottom", "padding"),
								$d => __("Define the CSS padding-bottom for the carousel items (px)", 'revsliderhelp'),
								$a => $u . "carousel-settings/",
								$hl => array(
									$dp => array(array($p => 'settings.type', $v => 'carousel', $o => 'slider_layout_type_carousel')), 
									$m => "#module_settings_trigger, #gst_sl_3", 
									$st => '#form_slidergeneral_caroussel', 
									$f => "#sr_ca_pdb"
								)
							),
							'horizontal_align' => array(
								$t => __("Horizontal Align", 'revsliderhelp'),
								$h => "carousel.horizontal",
								$k => array("carousel", "carousel align", "carousel horizontal align", "horizontal align", "align"),
								$d => __("Decide how the items should be aligned horizontally inside the Slide container", 'revsliderhelp'),
								$a => $u . "carousel-settings/",
								$hl => array(
									$dp => array(array($p => 'settings.type', $v => 'carousel', $o => 'slider_layout_type_carousel')), 
									$m => "#module_settings_trigger, #gst_sl_3", 
									$st => '#form_slidergeneral_caroussel', 
									$f => "#sr_ca_halign"
								)
							),
							'vertical_align' => array(
								$t => __("Vertical Align", 'revsliderhelp'),
								$h => "carousel.vertical",
								$k => array("carousel", "carousel align", "carousel vertical align", "vertical align", "align"),
								$d => __("Decide how the items should be aligned vertically inside the Slide container", 'revsliderhelp'),
								$a => $u . "carousel-settings/",
								$hl => array(
									$dp => array(array($p => 'settings.type', $v => 'carousel', $o => 'slider_layout_type_carousel')), 
									$m => "#module_settings_trigger, #gst_sl_3", 
									$st => '#form_slidergeneral_caroussel', 
									$f => "#sr_ca_valign"
								)
							)
						),
						'animation' => array(
							'easing' => array(
								$t => __("Easing", 'revsliderhelp'),
								$h => "carousel.ease",
								$k => array("carousel", "carousel easing", "carousel transition", "carousel animation", "carousel transition easing", "easing"),
								$d => __("The easing equation for when the carousel changes from one Slide to the next", 'revsliderhelp'),
								$a => $u . "carousel-settings/",
								$hl => array(
									$dp => array(array($p => 'settings.type', $v => 'carousel', $o => 'slider_layout_type_carousel')), 
									$m => "#module_settings_trigger, #gst_sl_3", 
									$st => '#form_slidergeneral_caroussel_animation', 
									$f => "#sr_ca_ease"
								)
							),
							'speed' => array(
								$t => __("Speed", 'revsliderhelp'),
								$h => "carousel.speed",
								$k => array("carousel", "carousel speed", "carousel transition", "carousel animation", "carousel transition speed", "speed"),
								$d => __("The speed the items will change form one Slide to the next (in milliseconds)", 'revsliderhelp'),
								$a => $u . "carousel-settings/",
								$hl => array(
									$dp => array(array($p => 'settings.type', $v => 'carousel', $o => 'slider_layout_type_carousel')), 
									$m => "#module_settings_trigger, #gst_sl_3", 
									$st => '#form_slidergeneral_caroussel_animation', 
									$f => "#sr_ca_speed"
								)
							)
						),
						'effects' => array(
							'fade' => array(
								$di => "slider_carousel_fadeout",
								$t => __("Fade Items", 'revsliderhelp'),
								$h => "carousel.fadeOut",
								$k => array("carousel", "fade", "carousel fade", "carousel items", "carousel item opacity"),
								$d => __("Apply opacity to the non-activate Slides", 'revsliderhelp'),
								$a => $u . "carousel-settings/",
								$hl => array(
									$dp => array(array($p => 'settings.type', $v => 'carousel', $o => 'slider_layout_type_carousel')), 
									$m => "#module_settings_trigger, #gst_sl_3", 
									$st => '#form_slidergeneral_caroussel_effects', 
									$f => "#sr_ca_fadeall"
								)
							),
							'varying_fade' => array(
								$t => __("Varying Fade", 'revsliderhelp'),
								$h => "carousel.varyFade",
								$k => array("carousel", "fade", "carousel fade", "carousel items", "carousel item opacity", "varying fade"),
								$d => __("Apply varying opacity to the non-activate Slides in staggered order", 'revsliderhelp'),
								$a => $u . "carousel-settings/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'carousel', $o => 'slider_layout_type_carousel'),
										array($p => 'settings.carousel.fadeOut', $v => true, $o => 'slider_carousel_fadeout')
									), 
									$m => "#module_settings_trigger, #gst_sl_3", 
									$st => '#form_slidergeneral_caroussel_effects', 
									$f => "#sr_ca_vfadeall"
								)
							),
							'rotation_enable' => array(
								$di => "slider_carousel_rotation",
								$t => __("Enable 3D Rotation", 'revsliderhelp'),
								$h => "carousel.rotation",
								$k => array("carousel", "rotation", "carousel rotate items", "rotate items", "3d rotation"),
								$d => __("Apply a 3D rotation to the non-active items", 'revsliderhelp'),
								$a => $u . "carousel-settings/",
								$hl => array(
									$dp => array(array($p => 'settings.type', $v => 'carousel', $o => 'slider_layout_type_carousel')), 
									$m => "#module_settings_trigger, #gst_sl_3", 
									$st => '#form_slidergeneral_caroussel_effects', 
									$f => "#sr_ca_rotate"
								)
							),
							'degrees' => array(
								$t => __("Rotation Degrees", 'revsliderhelp'),
								$h => "carousel.maxRotation",
								$k => array("carousel", "carousel items", "carousel rotation", "item rotation", "3d rotation", "rotation degrees", "degrees"),
								$d => __("The degree value for the 3D rotation applied to the non-active items", 'revsliderhelp'),
								$a => $u . "carousel-settings/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'carousel', $o => 'slider_layout_type_carousel'),
										array($p => 'settings.carousel.rotation', $v => true, $o => 'slider_carousel_rotation')
									), 
									$m => "#module_settings_trigger, #gst_sl_3", 
									$st => '#form_slidergeneral_caroussel_effects', 
									$f => "#sr_ca_maxrot"
								)
							),
							'varying_rotation' => array(
								$t => __("Varying Rotation", 'revsliderhelp'),
								$h => "carousel.varyRotate",
								$k => array("carousel", "carousel items", "carousel rotation", "item rotation", "3d rotation", "varying rotation"),
								$d => __("Apply varying rotations to the non-activate Slides in staggered order", 'revsliderhelp'),
								$a => $u . "carousel-settings/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'carousel', $o => 'slider_layout_type_carousel'),
										array($p => 'settings.carousel.rotation', $v => true, $o => 'slider_carousel_rotation')
									), 
									$m => "#module_settings_trigger, #gst_sl_3", 
									$st => '#form_slidergeneral_caroussel_effects', 
									$f => "#sr_ca_vrotate"
								)
							),
							'scale' => array(
								$di => "slider_carousel_scale",
								$t => __("Enable Scaling", 'revsliderhelp'),
								$h => "carousel.scale",
								$k => array("carousel", "carousel items", "carousel scale", "item scale", "carousel scaling", "carousel zoom", "zoom"),
								$d => __("Zoom the non-active items by a certain percentage", 'revsliderhelp'),
								$a => $u . "carousel-settings/",
								$hl => array(
									$dp => array(array($p => 'settings.type', $v => 'carousel', $o => 'slider_layout_type_carousel')), 
									$m => "#module_settings_trigger, #gst_sl_3", 
									$st => '#form_slidergeneral_caroussel_effects', 
									$f => "#sr_ca_scale"
								)
							),
							'scale_percentage' => array(
								$t => __("Scale Percentage", 'revsliderhelp'),
								$h => "carousel.scaleDown",
								$k => array("carousel", "carousel items", "carousel scale", "item scale", "carousel scaling", "carousel zoom", "zoom"),
								$d => __("Zoom the non-active items by this percentage", 'revsliderhelp'),
								$a => $u . "carousel-settings/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'carousel', $o => 'slider_layout_type_carousel'),
										array($p => 'settings.carousel.scale', $v => true, $o => 'slider_carousel_scale')
									), 
									$m => "#module_settings_trigger, #gst_sl_3", 
									$st => '#form_slidergeneral_caroussel_effects', 
									$f => "#sr_ca_scaleDown"
								)
							),
							'varying_scale' => array(
								$t => __("Varing Scale", 'revsliderhelp'),
								$h => "carousel.varyScale",
								$k => array("carousel", "carousel items", "carousel scale", "item scale", "carousel scaling", "carousel zoom", "zoom", "varying scale", "varying zoom"),
								$d => __("Apply varying scale/zooms to the non-activate Slides in staggered order", 'revsliderhelp'),
								$a => $u . "carousel-settings/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'carousel', $o => 'slider_layout_type_carousel'),
										array($p => 'settings.carousel.scale', $v => true, $o => 'slider_carousel_scale')
									), 
									$m => "#module_settings_trigger, #gst_sl_3", 
									$st => '#form_slidergeneral_caroussel_effects', 
									$f => "#sr_ca_vscale"
								)
							)
						)
					),
					'gst_sl_12' => array(
						'enable_spinner' => array(
							$di => 'slider_spinner',
							$t => __("Spinner / Preloader", 'revsliderhelp'),
							$h => "layout.spinner.type",
							$k => array("spinner", "preloader", "loader"),
							$d => __("Display a spinner animation when the Module first loads", 'revsliderhelp'),
							$a => $u . "module-general-settings/",
							$hl => array($m => "#module_settings_trigger, #gst_sl_12", $st => '#form_sliderspinner', $f => "#revealer_spinners")
						),
						'spinner_color' => array(
							$t => __("Spinner Color", 'revsliderhelp'),
							$h => "layout.spinner.color",
							$k => array("spinner", "preloader", "loader", "spinner color", "preloader color"),
							$d => __("The color of the spinner/preloader that shows before the Module first loads", 'revsliderhelp'),
							$a => $u . "module-general-settings/",
							$hl => array(
								$dp => array(array($p => 'settings.layout.spinner.type', $v => '0::1::2::3::4::5', $o => 'slider_spinner')), 
								$m => "#module_settings_trigger, #gst_sl_12", 
								$st => '#form_sliderspinner', 
								$f => "#module_spinner_color"
							)
						)
					),
					'gst_sl_8' => array(
						'parallax' => array(
							'enable_effects' => array(
								$di => "slider_parallax",
								$t => __("Enable Parallax/3D Effects", 'revsliderhelp'),
								$h => "parallax.set",
								$k => array("parallax", "3D", "3d", "effects", "effect"),
								$d => __("Enable the special effects engine for the Slider", 'revsliderhelp'),
								$a => $u . "parallax-3d-effect/",
								$hl => array($m => "#module_settings_trigger, #gst_sl_8, #sr_sbased-tab-3 > div", $st => '#form_slidergeneral_effects_parallax', $f => "#sr_effectspddd")
							),
							'enable_3d' => array(
								$di => "slider_parallax_3d",
								$t => __("Enable 3D Effects", 'revsliderhelp'),
								$h => "parallax.setDDD",
								$k => array("3d", "effect", "effects", "3d effect"),
								$d => __("Enable the Parallax/3D effect engine for the Slider", 'revsliderhelp'),
								$a => $u . "parallax-3d-effect/",
								$hl => array(
									$dp => array(array($p => 'settings.parallax.set', $v => true, $o => 'slider_parallax')), 
									$m => "#module_settings_trigger, #gst_sl_8, #sr_sbased-tab-3 > div", 
									$st => '#form_slidergeneral_effects_parallax', 
									$f => "#sr_effectddd"
								)
							),
							'disable_mobile' => array(
								$t => __("Disable Parallax/3D on Mobile", 'revsliderhelp'),
								$h => "parallax.disableOnMobile",
								$k => array("3d", "effect", "effects", "3d effect", "disable", "disable mobile"),
								$d => __("Disable the Parallax/3D effects for mobile devices", 'revsliderhelp'),
								$a => $u . "parallax-3d-effect/",
								$hl => array(
									$dp => array(array($p => 'settings.parallax.set', $v => true, $o => 'slider_parallax')), 
									$m => "#module_settings_trigger, #gst_sl_8, #sr_sbased-tab-3 > div", 
									$st => '#form_slidergeneral_effects_parallax', 
									$f => "#sr_effectdisableonmobile"
								)
							),
							'mouse_sensibility' => array(
								'triggered_by' => array(
									$di => "slider_parallax_mouse_type",
									$t => __("Triggered By", 'revsliderhelp'),
									$h => "parallax.mouse.type",
									$k => array("parallax mouse", "parallax scroll", "scroll", "mouse", "mouse move", "triggered", "triggered by"),
									$d => __("Choose if the Parallax/3D effects should happen on mouse move, page scroll or both", 'revsliderhelp'),
									$a => $u . "parallax-3d-effect/",
									$hl => array($m => "#module_settings_trigger, #gst_sl_8, #sr_sbased-tab-3 > div", $st => '#form_slidergeneral_effects_parallax_mous', $f => "#slider_parallax_mouse_sens_event")
								),
								'parallax_origin' => array(
									$t => __("Parallax Origin", 'revsliderhelp'),
									$h => "parallax.mouse.origo",
									$k => array("parallax origo", "parallax origin, 3D origin"),
									$d => __("Choose if the origin point for the effect should be the Layer's center, or based on where the user first hovered their mouse over the element", 'revsliderhelp'),
									$a => $u . "parallax-3d-effect/",
									$hl => array($m => "#module_settings_trigger, #gst_sl_8, #sr_sbased-tab-3 > div", $st => '#form_slidergeneral_effects_parallax_mous', $f => "#slider_parallax_mouse_origo")
								),
								'mouse_speed' => array(
									$t => __("Mouse Speed", 'revsliderhelp'),
									$h => "parallax.mouse.speed",
									$k => array("mouse speed", "parallax mouse", "parallax mouse speed", "parallax speed"),
									$d => __("The sensitivity speed for the Parallax effect(s) on mouse-move", 'revsliderhelp'),
									$a => $u . "parallax-3d-effect/",
									$hl => array(
										$dp => array(array($p => 'settings.parallax.mouse.type', $v => 'mouse::mousescroll', $o => 'slider_parallax_mouse_type')), 
										$m => "#module_settings_trigger, #gst_sl_8, #sr_sbased-tab-3 > div", 
										$st => '#form_slidergeneral_effects_parallax_mous', 
										$f => "#sr_parallax_mbspeed"
									)
								),
								'bg_speed' => array(
									$t => __("Background Image Speed", 'revsliderhelp'),
									$h => "parallax.mouse.bgSpeed",
									$k => array("bg speed", "parallax background", "parallax background image", "parallax image"),
									$d => __("The movement speed for the Slide's main background when the effect(s) occur", 'revsliderhelp'),
									$a => $u . "parallax-3d-effect/",
									$hl => array(
										$dp => array(array($p => 'settings.parallax.mouse.type', $v => 'scroll::mousescroll', $o => 'slider_parallax_mouse_type')), 
										$m => "#module_settings_trigger, #gst_sl_8, #sr_sbased-tab-3 > div", 
										$st => '#form_slidergeneral_effects_parallax_mous', 
										$f => "#sr_parallax_mbgspeed"
									)
								),
								'layers_speed' => array(
									$t => __("Layers Speed", 'revsliderhelp'),
									$h => "parallax.mouse.layersSpeed",
									$k => array("bg speed", "parallax background", "parallax background layer", "parallax layers"),
									$d => __("The movement speed for the Slide's Layers when the effect(s) occur", 'revsliderhelp'),
									$a => $u . "parallax-3d-effect/",
									$hl => array(
										$dp => array(array($p => 'settings.parallax.mouse.type', $v => 'scroll::mousescroll', $o => 'slider_parallax_mouse_type')), 
										$m => "#module_settings_trigger, #gst_sl_8, #sr_sbased-tab-3 > div", 
										$st => '#form_slidergeneral_effects_parallax_mous', 
										$f => "#sr_parallax_mlayspeed"
									)
								)
							),
							'threed_settings' => array(
								'shadow' => array(
									$t => __("3D Shadow", 'revsliderhelp'),
									$h => "parallax.ddd.shadow",
									$k => array("3d", "3d effect", "3d shadow", "shadow"),
									$d => __("Apply a box-shadow to the 3D element to enhance the effect", 'revsliderhelp'),
									$a => $u . "parallax-3d-effect/",
									$hl => array(
										$dp => array(
											array($p => 'settings.parallax.set', $v => true, $o => 'slider_parallax'),
											array($p => 'settings.parallax.setDDD', $v => true, $o => 'slider_parallax_3d')
										), 
										$m => "#module_settings_trigger, #gst_sl_8, #sr_sbased-tab-3 > div", 
										$st => '#form_slidergeneral_effects_parallax_dddd', 
										$f => "#sr_ddd_shadow"
									)
								),
								'background' => array(
									$t => __("Background Enabled", 'revsliderhelp'),
									$h => "parallax.ddd.BGFreeze",
									$k => array("3d", "3d effect", "3d background", "3d bg"),
									$d => __("Choose if the Slide's main background image should be included for the 3D effect", 'revsliderhelp'),
									$a => $u . "parallax-3d-effect/",
									$hl => array(
										$dp => array(
											array($p => 'settings.parallax.set', $v => true, $o => 'slider_parallax'),
											array($p => 'settings.parallax.setDDD', $v => true, $o => 'slider_parallax_3d')
										), 
										$m => "#module_settings_trigger, #gst_sl_8, #sr_sbased-tab-3 > div", 
										$st => '#form_slidergeneral_effects_parallax_dddd', 
										$f => "#sr_ddd_BGFreeze"
									)
								),
								'slider_overflow' => array(
									$t => __("Slide BG Overflow Hidden", 'revsliderhelp'),
									$h => "parallax.ddd.overflow",
									$k => array("3d", "3d effect", "3d overflow", "3D overflow hidden", "3d background", "3d bg"),
									$d => __("Choose if the Slider's main background can bleed outside the Slider's bounding box when skewed in 3D space", 'revsliderhelp'),
									$a => $u . "parallax-3d-effect/",
									$hl => array(
										$dp => array(
											array($p => 'settings.parallax.set', $v => true, $o => 'slider_parallax'),
											array($p => 'settings.parallax.setDDD', $v => true, $o => 'slider_parallax_3d')
										), 
										$m => "#module_settings_trigger, #gst_sl_8, #sr_sbased-tab-3 > div", 
										$st => '#form_slidergeneral_effects_parallax_dddd', 
										$f => "#sr_ddd_overflow"
									)
								),
								'layers_overflow' => array(
									$t => __("Layers Overflow Hidden", 'revsliderhelp'),
									$h => "parallax.ddd.layerOverflow",
									$k => array("3d", "3d effect", "3d overflow", "3D overflow hidden", "3d layers"),
									$d => __("Choose if Slide Layers can bleed outside the Slider's bounding box when skewed in 3D space", 'revsliderhelp'),
									$a => $u . "parallax-3d-effect/",
									$hl => array(
										$dp => array(
											array($p => 'settings.parallax.set', $v => true, $o => 'slider_parallax'),
											array($p => 'settings.parallax.setDDD', $v => true, $o => 'slider_parallax_3d')
										), 
										$m => "#module_settings_trigger, #gst_sl_8, #sr_sbased-tab-3 > div", 
										$st => '#form_slidergeneral_effects_parallax_dddd', 
										$f => "#sr_ddd_layerOverflow"
									)
								),
								'threed_crop_fix' => array(
									$t => __("3D Crop Fix", 'revsliderhelp'),
									$h => "parallax.ddd.zCorrection",
									$k => array("3d", "3d effect", "3d crop", "3D crop fix"),
									$d => __("Applies a translateZ to the 3D elements to help avoid overlapping", 'revsliderhelp'),
									$a => $u . "parallax-3d-effect/",
									$hl => array(
										$dp => array(
											array($p => 'settings.parallax.set', $v => true, $o => 'slider_parallax'),
											array($p => 'settings.parallax.setDDD', $v => true, $o => 'slider_parallax_3d')
										), 
										$m => "#module_settings_trigger, #gst_sl_8, #sr_sbased-tab-3 > div", 
										$st => '#form_slidergeneral_effects_parallax_dddd', 
										$f => "#sr_ddd_zCorrection"
									)
								),
								'bg_3d_depth' => array(
									$t => __("BG 3D Depth", 'revsliderhelp'),
									$h => "bgparallaxlevel",
									$k => array("3d", "3d effect", "3d depth", "bg depth", "bg 3d depth"),
									$d => __("The 3D depth level for the Slide's main background", 'revsliderhelp'),
									$a => $u . "parallax-3d-effect/",
									$hl => array(
										$dp => array(
											array($p => 'settings.parallax.set', $v => true, $o => 'slider_parallax'),
											array($p => 'settings.parallax.setDDD', $v => true, $o => 'slider_parallax_3d')
										), 
										$m => "#module_settings_trigger, #gst_sl_8, #sr_sbased-tab-3 > div", 
										$st => '#form_slidergeneral_effects_parallax_dddd', 
										$f => "#sr_paralaxlevel_16"
									)
								)
							),
							'depths' => array(
								$t => __("Parallax Depths", 'revsliderhelp'),
								$h => "parallax.levels",
								$k => array("parallax", "depth", "parallax depth", "parallax depths"),
								$d => __("Define a depth for each of the 15 options, which can then be assigned to any given Layer", 'revsliderhelp'),
								$a => $u . "parallax-3d-effect/",
								$hl => array(
									$dp => array(array($p => 'settings.parallax.set', $v => true, $o => 'slider_parallax')),  
									$m => "#module_settings_trigger, #gst_sl_8, #sr_sbased-tab-3 > div", 
									$st => '#form_slidergeneral_effects_parallax_depths', 
									$f => "#sr_paralaxlevel_1"
								)
							)
						),
						'timeline' => array(
							'enabled' => array(
								$di => 'scroll_timeline_enabled',
								$t => __("Timeline Scroll Effects", 'revsliderhelp'),
								$h => "scrolltimeline.set",
								$k => array("timeline", "scroll", "scroll effects", "animation"),
								$d => __("The Slide's content will animate into and out of view as the user scrolls the page.", 'revsliderhelp'),
								$a => $u . "parallax-3d-effect/",
								$hl => array($m => "#module_settings_trigger, #gst_sl_8, #sr_sbased-tab-1 > div", $st => '#form_module_scroll', $f => "#sr_sbt_ge_enabled")
							),
							'easing' => array(
								$t => __("Animation Easing", 'revsliderhelp'),
								$h => "scrolltimeline.ease",
								$k => array("timeline", "scroll", "scroll effects", "animation", "easing"),
								$d => __("The easing equation to be applied to the animated content as the page scrolls", 'revsliderhelp'),
								$a => $u . "parallax-3d-effect/",
								$hl => array(
									$dp => array(array($p => 'settings.scrolltimeline.set', $v => true, $o => 'scroll_timeline_enabled')),  
									$m => "#module_settings_trigger, #gst_sl_8, #sr_sbased-tab-1 > div", 
									$st => '#form_module_scroll', 
									$f => "#scroll_timeline_ease"
								)
							),
							'duration' => array(
								$t => __("Animation Speed", 'revsliderhelp'),
								$h => "scrolltimeline.speed",
								$k => array("timeline", "scroll", "scroll effects", "animation", "duration", "speed"),
								$d => __("The speed at which the content will animate as the page scrolls (in milliseconds)", 'revsliderhelp'),
								$a => $u . "parallax-3d-effect/",
								$hl => array(
									$dp => array(array($p => 'settings.scrolltimeline.set', $v => true, $o => 'scroll_timeline_enabled')),  
									$m => "#module_settings_trigger, #gst_sl_8, #sr_sbased-tab-1 > div", 
									$st => '#form_module_scroll', 
									$f => "#scrolltimeline_speed"
								)
							),
							'use_on' => array(
								$t => __("Animate Layers on Scroll", 'revsliderhelp'),
								$h => "scrolltimeline.layers",
								$k => array("timeline", "scroll", "scroll effects", "animation", "layers"),
								$d => __("Animate the Layer's by default on Scroll (can then be turned off per Layer in the Layer settings)", 'revsliderhelp'),
								$a => $u . "parallax-3d-effect/",
								$hl => array(
									$dp => array(array($p => 'settings.scrolltimeline.set', $v => true, $o => 'scroll_timeline_enabled')),  
									$m => "#module_settings_trigger, #gst_sl_8, #sr_sbased-tab-1 > div", 
									$st => '#form_slidergeneral_effects_scroll_on', 
									$f => "#sr_scrtime_layers"
								)
							)
						),
						'effects' => array(
							'enabled' => array(
								$di => 'scroll_effects_enabled',
								$t => __("Scroll Effects", 'revsliderhelp'),
								$h => "scrolleffects.set",
								$k => array("scroll", "scroll effects", "fade on scroll", "special effects"),
								$d => __("Apply special effects to your content when the page is scrolled", 'revsliderhelp'),
								$a => $u . "parallax-3d-effect/",
								$hl => array($m => "#module_settings_trigger, #gst_sl_8, #sr_sbased-tab-2 > div", $st => '#form_slidergeneral_effects_scroll', $f => "#sr_sbe_ge_enabled")
							),
							'fade' => array(
								$t => __("Fade", 'revsliderhelp'),
								$h => "scrolleffects.setFade",
								$k => array("scroll", "scroll effects", "fade on scroll", "special effects"),
								$d => __("Fade the Slider out when  it scrolls into and out of view", 'revsliderhelp'),
								$a => $u . "parallax-3d-effect/",
								$hl => array(
									$dp => array(array($p => 'settings.scrolleffects.set', $v => true, $o => 'scroll_effects_enabled')),  
									$m => "#module_settings_trigger, #gst_sl_8, #sr_sbased-tab-2 > div", 
									$st => '#form_slidergeneral_effects_scroll', 
									$f => "#sr_se_fadeset"
								)
							),
							'grayscale' => array(
								$t => __("GrayScale", 'revsliderhelp'),
								$h => "scrolleffects.setGrayScale",
								$k => array("scroll", "scroll effects", "grayscale on scroll", "special effects", "grayscale"),
								$d => __("Apply a black and white filter to the Slider when it scrolls into and out of view", 'revsliderhelp'),
								$a => $u . "parallax-3d-effect/",
								$hl => array(
									$dp => array(array($p => 'settings.scrolleffects.set', $v => true, $o => 'scroll_effects_enabled')),  
									$m => "#module_settings_trigger, #gst_sl_8, #sr_sbased-tab-2 > div", 
									$st => '#form_slidergeneral_effects_scroll', 
									$f => "#sr_se_grayset"
								)
							),
							'blur' => array(
								$di => "slider_scrolleffects_blur",
								$t => __("Blur", 'revsliderhelp'),
								$h => "scrolleffects.setBlur",
								$k => array("scroll", "scroll effects", "blur on scroll", "special effects", "blur"),
								$d => __("Apply a blur filter to the Slider when it scrolls into and out of view", 'revsliderhelp'),
								$a => $u . "parallax-3d-effect/",
								$hl => array(
									$dp => array(array($p => 'settings.scrolleffects.set', $v => true, $o => 'scroll_effects_enabled')),  
									$m => "#module_settings_trigger, #gst_sl_8, #sr_sbased-tab-2 > div", 
									$st => '#form_slidergeneral_effects_scroll', 
									$f => "#sr_se_blurset"
								)
							),
							'blur_value' => array(
								$t => __("Blur Value", 'revsliderhelp'),
								$h => "scrolleffects.maxBlur",
								$k => array("scroll", "scroll effects", "blur on scroll", "special effects", "blur"),
								$d => __("The blur filter strength for the Blur scroll effect (px)", 'revsliderhelp'),
								$a => $u . "parallax-3d-effect/",
								$hl => array(
									$dp => array(
										array($p => 'settings.scrolleffects.set', $v => true, $o => 'scroll_effects_enabled'),
										array($p => 'settings.scrolleffects.setBlur', $v => true, $o => 'slider_scrolleffects_blur')
									),  
									$m => "#module_settings_trigger, #gst_sl_8, #sr_sbased-tab-2 > div", 
									$st => '#form_slidergeneral_effects_scroll', 
									$f => "#sr_se_blurMax"
								)
							),
							'use_on' => array(
								'layers' => array(
									$t => __("Layers", 'revsliderhelp'),
									$h => "scrolleffects.layers",
									$k => array("scroll", "scroll effects", "blur layers", "fade layers"),
									$d => __("Apply the effect(s) to all Layers", 'revsliderhelp'),
									$a => $u . "parallax-3d-effect/",
									$hl => array(
										$dp => array(array($p => 'settings.scrolleffects.set', $v => true, $o => 'scroll_effects_enabled')),  
										$m => "#module_settings_trigger, #gst_sl_8, #sr_sbased-tab-2 > div", 
										$st => '#form_slidergeneral_effects_scroll_on', 
										$f => "#sr_screff_layers"
									)
								),
								'parallax_layers' => array(
									$t => __("Parallax Layers", 'revsliderhelp'),
									$h => "scrolleffects.parallaxLayers",
									$k => array("scroll", "scroll effects", "blur layers", "fade layers", "parallax", "parallax layers"),
									$d => __("Apply the effect(s) to all Parallax Layers", 'revsliderhelp'),
									$a => $u . "parallax-3d-effect/",
									$hl => array(
										$dp => array(array($p => 'settings.scrolleffects.set', $v => true, $o => 'scroll_effects_enabled')),
										$m => "#module_settings_trigger, #gst_sl_8, #sr_sbased-tab-2 > div", 
										$st => '#form_slidergeneral_effects_scroll_on', 
										$f => "#sr_screff_parallaxLayers"
									)
								),
								'slide_bg' => array(
									$t => __("Slide Background", 'revsliderhelp'),
									$h => "scrolleffects.bg",
									$k => array("scroll", "scroll effects", "blur background", "fade background", "slide background", "slide bg", "image background"),
									$d => __("Apply the effect(s) to the Slide's main background", 'revsliderhelp'),
									$a => $u . "parallax-3d-effect/",
									$hl => array(
										$dp => array(array($p => 'settings.scrolleffects.set', $v => true, $o => 'scroll_effects_enabled')),
										$m => "#module_settings_trigger, #gst_sl_8, #sr_sbased-tab-2 > div", 
										$st => '#form_slidergeneral_effects_scroll_on', 
										$f => "#sr_screff_bg"
									)
								),
								'static_layers' => array(
									$t => __("Static/Global Layers", 'revsliderhelp'),
									$h => "scrolleffects.staticLayers",
									$k => array("scroll", "scroll effects", "blur global layers", "fade global layers", "static layers", "global", "global layers"),
									$d => __("Apply the effect(s) to the Slide's Static/Global Layers", 'revsliderhelp'),
									$a => $u . "parallax-3d-effect/",
									$hl => array(
										$dp => array(array($p => 'settings.scrolleffects.set', $v => true, $o => 'scroll_effects_enabled')),
										$m => "#module_settings_trigger, #gst_sl_8, #sr_sbased-tab-2 > div", 
										$st => '#form_slidergeneral_effects_scroll_on', 
										$f => "#sr_screff_staticLayers"
									)
								),
								'static_parallax_layers' => array(
									$t => __("Static/Global Parallax Layers", 'revsliderhelp'),
									$h => "scrolleffects.staticParallaxLayers",
									$k => array("scroll", "scroll effects", "blur global layers", "fade global layers", "static layers", "global", "global layers", "parallax"),
									$d => __("Apply the effect(s) to the Slide's Static/Global Parallax Layers", 'revsliderhelp'),
									$a => $u . "parallax-3d-effect/",
									$hl => array(
										$dp => array(array($p => 'settings.scrolleffects.set', $v => true, $o => 'scroll_effects_enabled')),
										$m => "#module_settings_trigger, #gst_sl_8, #sr_sbased-tab-2 > div", 
										$st => '#form_slidergeneral_effects_scroll_on', 
										$f => "#sr_screff_staticParallaxLayers"
									)
								)
							),
							$dp => array(
								'direction' => array(
									$t => __("Scroll Direction", 'revsliderhelp'),
									$h => "scrolleffects.direction",
									$k => array("scroll", "scroll effects", "scroll direction"),
									$d => __("Apply the effect(s) when the page is scrolled from the top, bottom, or both directions", 'revsliderhelp'),
									$a => $u . "parallax-3d-effect/",
									$hl => array(
										$dp => array(array($p => 'settings.scrolleffects.set', $v => true, $o => 'scroll_effects_enabled')),
										$m => "#module_settings_trigger, #gst_sl_8, #sr_sbased-tab-2 > div", 
										$st => '#form_slidergeneral_effects_scroll_dependencies', 
										$f => "#slider_screff_direction"
									)
								),
								'disable_mobile' => array(
									$t => __("Disable on Mobile", 'revsliderhelp'),
									$h => "scrolleffects.disableOnMobile",
									$k => array("scroll", "scroll effects", "disable", "disable mobile", "disable on mobile"),
									$d => __("Disable the effects on mobile devices", 'revsliderhelp'),
									$a => $u . "parallax-3d-effect/",
									$hl => array(
										$dp => array(array($p => 'settings.scrolleffects.set', $v => true, $o => 'scroll_effects_enabled')),
										$m => "#module_settings_trigger, #gst_sl_8, #sr_sbased-tab-2 > div", 
										$st => '#form_slidergeneral_effects_scroll_dependencies', 
										$f => "#sr_screff_disableOnMobile"
									)
								),
								'offset_tilt' => array(
									$t => __("Offset Tilt", 'revsliderhelp'),
									$h => "scrolleffects.tilt",
									$k => array("scroll", "scroll effects", "tilt", "offset tilt"),
									$d => __("The percentage the Slider is in the page's viewport before the effect(s) are applied", 'revsliderhelp'),
									$a => $u . "parallax-3d-effect/",
									$hl => array(
										$dp => array(array($p => 'settings.scrolleffects.set', $v => true, $o => 'scroll_effects_enabled')),
										$m => "#module_settings_trigger, #gst_sl_8, #sr_sbased-tab-2 > div", 
										$st => '#form_slidergeneral_effects_scroll_dependencies', 
										$f => "#sr_screff_tilt"
									)
								),
								'multiple_bg' => array(
									$t => __("BG Strength", 'revsliderhelp'),
									$h => "scrolleffects.multiplicator",
									$k => array("scroll", "scroll effects", "multiple factor"),
									$d => __("The strength of the opacity, blur or grayscale filter for the effect(s) for the Slide's main background", 'revsliderhelp'),
									$a => $u . "parallax-3d-effect/",
									$hl => array(
										$dp => array(array($p => 'settings.scrolleffects.set', $v => true, $o => 'scroll_effects_enabled')),
										$m => "#module_settings_trigger, #gst_sl_8, #sr_sbased-tab-2 > div", 
										$st => '#form_slidergeneral_effects_scroll_dependencies', 
										$f => "#sr_screff_multiplicator"
									)
								),
								'multiple_layers' => array(
									$t => __("Layers Strength", 'revsliderhelp'),
									$h => "scrolleffects.multiplicatorLayers",
									$k => array("scroll", "scroll effects", "multiple factor"),
									$d => __("The strength of the opacity, blur or grayscale filter for the effect(s) for the Slide's Layers", 'revsliderhelp'),
									$a => $u . "parallax-3d-effect/",
									$hl => array(
										$dp => array(array($p => 'settings.scrolleffects.set', $v => true, $o => 'scroll_effects_enabled')),
										$m => "#module_settings_trigger, #gst_sl_8, #sr_sbased-tab-2 > div", 
										$st => '#form_slidergeneral_effects_scroll_dependencies', 
										$f => "#sr_screff_multiplicatorLayers"
									)
								)
							)
						)
					),
					'addons' => array(),
					'gst_sl_10' => array(
						'lazy_loading' => array(
							$t => __("Lazy Loading", 'revsliderhelp'),
							$h => "general.lazyLoad",
							$k => array("lazy", "lazy load", "lazy loading"),
							$d => __("Choose 'All' to LazyLoad all images in the Slider when the Slider first loads, 'Smart' to only LazyLoad the prev/next Slide's images, and 'Single' to only LazyLoad the current Slide's images.", 'revsliderhelp'),
							$a => $u . "advanced-module-settings/",
							$hl => array($m => "#module_settings_trigger, #gst_sl_10", $st => '#form_slidergeneral_advanced_loading', $f => "#sr_adv_performance_load")
						),
						'bgdpr' => array(
							$t => __("Device Pixel Ratio", 'revsliderhelp'),
							$h => "general.DPR",
							$k => array("dpr", "device aspect ratio", "image quality", "background", "blurry"),
							$d => __("Allows to use higher DPR on 4k, 5k , Retina displays.  Higher Maximum value can have negativ influence on complex Canvas animations. Lower Value can have negative influence on Image Quality on 4K+ Devices. In cae animations or Pan Zoom are not smooth, try lower DPR, and incase BG Image blurry, try higher DPR.", 'revsliderhelp'),
							$a => $u . "advanced-module-settings/",
							$hl => array($m => "#module_settings_trigger, #gst_sl_10", $st => '#form_slidergeneral_advanced_loading', $f => "#sliderbgdpr")
						),
						'simplify' => array(
							$t => __("Simplify on IOS4/IE8", 'revsliderhelp'),
							$h => "troubleshooting.simplify_ie8_ios4",
							$k => array("fallback", "simplify", "simplify on", "simplify animations"),
							$d => __("Simplify Animations for better compatibility with IOS4/IE8", 'revsliderhelp'),
							$a => $u . "advanced-module-settings/",
							$hl => array($m => "#module_settings_trigger, #gst_sl_10", $st => '#form_slidergeneral_advanced_loading', $f => "#sr_simplify_ie8_ios4")
						),
						'alt_image' => array(
							$di => "slider_troubleshooting_alternativeimage",
							$t => __("Alternative Image", 'revsliderhelp'),
							$h => "troubleshooting.alternateImageType",
							$k => array("alternative image", "fallback image"),
							$d => __("Show a simple image instead of the Slider on mobile, IE8 or both", 'revsliderhelp'),
							$a => $u . "advanced-module-settings/",
							$hl => array($m => "#module_settings_trigger, #gst_sl_10", $st => '#form_slidergeneral_advanced_loading', $f => "#slider_fallback_alt_image")
						),
						'alt_image_url' => array(
							$t => __("Alternative Image URL", 'revsliderhelp'),
							$h => "troubleshooting.alternateURL",
							$k => array("alternative image", "fallback image", "fallback image url", "fallback url"),
							$d => __("The url for the fallback image if a fallback is used for IE8/Mobile", 'revsliderhelp'),
							$a => $u . "advanced-module-settings/",
							$hl => array(
								$dp => array(array($p => 'settings.troubleshooting.alternateImageType', $v => 'mobile::ie8::mobile-ie8', $o => 'slider_troubleshooting_alternativeimage')),
								$m => "#module_settings_trigger, #gst_sl_10", 
								$st => '#form_slidergeneral_advanced_loading', 
								$f => "#troubleshooting_alternateURL"
							)
						),
						'jquery_noconflict' => array(
							$t => __("jQuery No Conflict Mode", 'revsliderhelp'),
							$h => "troubleshooting.jsNoConflict",
							$k => array("jquery", "jquery noconflict", "no conflict", "jQuery no conflict"),
							$d => __("Call jQuery.noConflict() to help avoid conflicts with other themes/plugins", 'revsliderhelp'),
							$a => $u . "advanced-module-settings/",
							$hl => array($m => "#module_settings_trigger, #gst_sl_10", $st => '#form_slidergeneral_advanced_fallback', $f => "#sr_trbl_conflictmode")
						),
						'js_to_body' => array(
							$t => __("Put JS to Body", 'revsliderhelp'),
							$h => "troubleshooting.jsInBody",
							$k => array("js to body", "js to body", "troubleshooting"),
							$d => __("Load the Slider's JS files in the page's body to help resolve conflicts", 'revsliderhelp'),
							$a => $u . "advanced-module-settings/",
							$hl => array($m => "#module_settings_trigger, #gst_sl_10", $st => '#form_slidergeneral_advanced_fallback', $f => "#sr_trbl_jsInBody")
						),
						'output_filter' => array(
							$t => __("Output Filter Protection", 'revsliderhelp'),
							$h => "troubleshooting.outPutFilter",
							$k => array("output", "output filter"),
							$d => __("Useful for solving a conflict when the current theme runs filters over the page's main content", 'revsliderhelp'),
							$a => $u . "advanced-module-settings/",
							$hl => array($m => "#module_settings_trigger, #gst_sl_10", $st => '#form_slidergeneral_advanced_fallback', $f => "#sr_trbl_filters")
						),
						'debug_mode' => array(
							$t => __("Debug Mode", 'revsliderhelp'),
							$h => "troubleshooting.debugMode",
							$k => array("debug", "debug mode", "troubleshooting"),
							$d => __("Display debug information on the Slider to help show issues during development", 'revsliderhelp'),
							$a => $u . "advanced-module-settings/",
							$hl => array($m => "#module_settings_trigger, #gst_sl_10", $st => '#form_slidergeneral_advanced_fallback', $f => "#sr_trbl_debugMode")
						)
					),
					'gst_sl_11' => array(
						'custom_css' => array(
							$t => __("Custom CSS", 'revsliderhelp'),
							$h => "rs_css_area",
							$k => array("custom css", "css", "add css", "slider css"),
							$d => __("Add your own custom CSS to the Slider", 'revsliderhelp'),
							$a => $u . "advanced-module-settings/",
							$hl => array($m => "#module_settings_trigger, #gst_sl_11, .js_css_editor_tabsarray[data-mode='css']", 'modal' => "css_jquery")
						),
						'custom_js' => array(
							$t => __("Custom JavaScript", 'revsliderhelp'),
							$h => "rs_js_area",
							$k => array("custom js", "javascript", "custom javascript", "jquery", "custom jquery", "jquery"),
							$d => __("Add your own custom JavaScript to the Slider", 'revsliderhelp'),
							$a => $u . "advanced-module-settings/",
							$hl => array($m => "#module_settings_trigger, #gst_sl_11, .js_css_editor_tabsarray[data-mode='javascript']", 'modal' => "css_jquery")
						),
						'slider_api' => array(
							$t => __("Slider API", 'revsliderhelp'),
							$h => "rs_api_area",
							$k => array("custom js", "javascript", "custom javascript", "jquery", "custom jquery", "jquery", "api", "slider api"),
							$d => __("Slider Revolution API methods and events", 'revsliderhelp'),
							$a => $u . "advanced-module-settings/",
							$hl => array($m => "#module_settings_trigger, #gst_sl_11, .js_css_editor_tabsarray[data-mode='javascript'], #form_slidergeneral_advanced_api", 'modal' => "css_jquery")
						)
					),
					'gst_sl_13' => array(
						'modal_align_hor' => array(
							$t => __("Modal Horizontal Alignment", 'revsliderhelp'),
							$h => "modal.horizontal",
							$k => array("modal", "as modal", "alignment", "modal align", "align"),
							$d => __("Choose how the Module should be horizontally aligned to the page when loaded as a Modal", 'revsliderhelp'),
							$a => $u . "as-modal",
							$hl => array($m => "#module_settings_trigger, #gst_sl_13", $st => '#form_slidergeneral_general_as_modal', $f => ".modal_hor_selector.selected")
						),
						'modal_align_ver' => array(
							$t => __("Modal Vertical Alignment", 'revsliderhelp'),
							$h => "modal.vertical",
							$k => array("modal", "as modal", "alignment", "modal align", "align"),
							$d => __("Choose how the Module should be vertically aligned to the page when loaded as a Modal", 'revsliderhelp'),
							$a => $u . "as-modal",
							$hl => array($m => "#module_settings_trigger, #gst_sl_13", $st => '#form_slidergeneral_general_as_modal', $f => ".modal_ver_selector.selected")
						),
						'use_modal_cover' => array(
							$di => 'modal_cover',
							$t => __("Use Cover as Modal", 'revsliderhelp'),
							$h => "modal.cover",
							$k => array("modal", "as modal", "cover", "background"),
							$d => __("Include a background cover when the Module is loaded as a Modal", 'revsliderhelp'),
							$a => $u . "as-modal",
							$hl => array($m => "#module_settings_trigger, #gst_sl_13", $st => '#form_slidergeneral_general_as_modal', $f => "#sr_usemodalcover")
						),
						'modal_cover_color' => array(
							$t => __("Use Cover as Modal", 'revsliderhelp'),
							$h => "modal.coverColor",
							$k => array("modal", "as modal", "cover", "background", "color", "background color", "modal color"),
							$d => __("The background color to be applied when the Module loads as a Modal", 'revsliderhelp'),
							$a => $u . "as-modal",
							$hl => array(
								$dp => array(array($p => 'settings.modal.cover', $v => true, $o => 'modal_cover')),
								$m => "#module_settings_trigger, #gst_sl_13", 
								$st => '#form_slidergeneral_general_as_modal', 
								$f => "#slidermodalcolor"
							)
						),
						'body_class' => array(
							$t => __("Body Class", 'revsliderhelp'),
							$h => "modal.bodyclass",
							$k => array("modal", "as modal", "body class", "modal class", "class"),
							$d => __("Add an optional class name to the page's body element when the Module is loaded as a Modal", 'revsliderhelp'),
							$a => $u . "as-modal",
							$hl => array($m => "#module_settings_trigger, #gst_sl_13", $st => '#form_slidergeneral_general_as_modal', $f => "#sr_modalbodyclass")
						),
						'module_shortcode' => array(
							$t => __("Module Shortcode", 'revsliderhelp'),
							$h => "modalshortcode",
							$k => array("modal", "as modal", "body class", "modal shortcode", "shortcode"),
							$d => __("A special shortcode for the Module when loading it as a Modal in the page with <a href='#'>custom JavaScript</a>", 'revsliderhelp'),
							$a => $u . "as-modal",
							$hl => array($m => "#module_settings_trigger, #gst_sl_13", $st => '#form_slidergeneral_general_as_modal', $f => "#sr_modalshortcode")
						)
					)
				),
				'navigation_settings' => array(
					'gst_nav_1' => array(
						'enable' => array(
							$di => "nav_general_progressbar",
							$t => __("Enable Progress Bar", 'revsliderhelp'),
							$h => "general.progressbar.set",
							$k => array("progress", "progress bar", "enable progress bar", "activate progress"),
							$d => __("Add a progress bar to the Slider to display a visual representation of each Slide's timeline", 'revsliderhelp'),
							$a => $u . "progress-bar/",
							$hl => array(
								$dp => array(array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard')),
								$m => "#module_navigation_trigger, #gst_nav_1", 
								$st => '#form_nav_pbara', 
								$f => "#sr_pb_set"
							)
						),
						'color' => array(
							$t => __("Progress Bar Color", 'revsliderhelp'),
							$h => "general.progressbar.color",
							$k => array("progress", "progress bar", "progress bar color"),
							$d => __("Adjust the color for the progress bar", 'revsliderhelp'),
							$a => $u . "progress-bar/",
							$hl => array(
								$dp => array(
									array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
									array($p => 'settings.general.progressbar.set', $v => true, $o => 'nav_general_progressbar')
								),
								$m => "#module_navigation_trigger, #gst_nav_1", 
								$st => '#form_nav_pbara', 
								$f => "#sliderprogresscolor"
							)
						),
						'position' => array(
							$t => __("Progress Bar Position", 'revsliderhelp'),
							$h => "general.progressbar.position",
							$k => array("progress", "progress bar", "progress bar position"),
							$d => __("Choose if the progress bar should appear at the top or bottom of the Slider", 'revsliderhelp'),
							$a => $u . "progress-bar/",
							$hl => array(
								$dp => array(
									array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
									array($p => 'settings.general.progressbar.set', $v => true, $o => 'nav_general_progressbar')
								),
								$m => "#module_navigation_trigger, #gst_nav_1", 
								$st => '#form_nav_pbara', 
								$f => "#sr_pb_pos"
							)
						),
						'height' => array(
							$t => __("Progress Bar Height", 'revsliderhelp'),
							$h => "general.progressbar.height", 					
							$k => array("navigation, nav", "progressbar", "progress", "timer"),
							$d => __("The height of the progress bar in pixels", 'revsliderhelp'),
							$a => $u . "progress-bar/",
							$hl => array(
								$dp => array(
									array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
									array($p => 'settings.general.progressbar.set', $v => true, $o => 'nav_general_progressbar')
								),
								$m => "#module_navigation_trigger, #gst_nav_1", 
								$st => '#form_nav_pbara', 
								$f => "#sr_pb_height"
							)
						)
					),
					'gst_nav_2' => array(
						'enable' => array(
							$di => "nav_arrows",
							$t => __("Enable Arrows", 'revsliderhelp'),
							$h => "nav.arrows.set",
							$k => array("navigation", "arrow", "arrows", "add arrows", "add navigation"),
							$d => __("Enable left/right Arrows for the Slider's navigation", 'revsliderhelp'),
							$a => $u . "navigation-arrows/",
							$hl => array(
								$dp => array(array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard')),
								$m => "#module_navigation_trigger, #gst_nav_2", 
								$st => '#form_nav_arrows_mainstyle', 
								$f => "#sr_usenavarrow"
							)
						),
						'type' => array(
							$t => __("Arrows Type/Style", 'revsliderhelp'),
							$h => "nav.arrows.style",
							$k => array("navigation", "arrows", "arrow type", "arrow style", "arrows style", "arrows type"),
							$d => __("Choose a predefined style for the Arrows navigation", 'revsliderhelp'),
							$a => $u . "navigation-arrows/",
							$hl => array(
								$dp => array(
									array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
									array($p => 'settings.nav.arrows.set', $v => true, $o => 'nav_arrows')
								),
								$m => "#module_navigation_trigger, #gst_nav_2", 
								$st => '#form_nav_arrows_mainstyle', 
								$f => "#sr_arrows_style"
							)
						),
						'positioning' => array(
							'align_by' => array(
								$t => __("Align By Slider/Content", 'revsliderhelp'),
								$h => "nav.arrows.left.align, nav.arrows.right.align",
								$k => array("arrows", "arrow align", "arrow alignment", "position"),
								$d => __("Choose 'Slider' to align based on the Slider's full display, or 'Content' to align against the Slider's grid area", 'revsliderhelp'),
								$a => $u . "navigation-arrows/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.arrows.set', $v => true, $o => 'nav_arrows')
									),
									$m => "#module_navigation_trigger, #gst_nav_2", 
									$st => '#form_nav_arrows_left', 
									$f => "*[name='sr_leftarralign'][value='slider'], *[name='sr_rightarralign'][value='slider']"
								)
							),
							'alignment' => array(
								$t => __("Alignment", 'revsliderhelp'),
								$h => "nav.arrows.left.horizontal, nav.arrows.left.vertical, nav.arrows.right.horizontal, nav.arrows.right.vertical",
								$k => array("arrow align", "arrow alignment", "arrow position", "arrows position", "position"),
								$d => __("The Arrow's alignment position in the Slider before any offset(s) are applied", 'revsliderhelp'),
								$a => $u . "navigation-arrows/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.arrows.set', $v => true, $o => 'nav_arrows')
									),
									$m => "#module_navigation_trigger, #gst_nav_2", 
									$st => '#form_nav_arrows_left', 
									$f => "#left_arrow_position_selector_center-center, #right_arrow_position_selector_center-center"
								)
							),
							'offsetx' => array(
								$t => __("Offset X", 'revsliderhelp'),
								$h => "nav.arrows.left.offsetX, nav.arrows.right.offsetX",
								$k => array("arrow position", "arrow offset", "position"),
								$d => __("Offset the Arrow's horizontal position by this amount.  Accepts positive and negative values.", 'revsliderhelp'),
								$a => $u . "navigation-arrows/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.arrows.set', $v => true, $o => 'nav_arrows')
									),
									$m => "#module_navigation_trigger, #gst_nav_2", 
									$st => '#form_nav_arrows_left', 
									$f => "#nav_arrows_left_offsetx, #nav_arrows_right_offsetx"
								)
							),
							'offsety' => array(
								$t => __("Offset Y", 'revsliderhelp'),
								$h => "nav.arrows.left.offsetY, nav.arrows.right.offsetY",
								$k => array("arrow position", "arrow offset", "position"),
								$d => __("Offset the Arrow's vertical position by this amount.  Accepts positive and negative values.", 'revsliderhelp'),
								$a => $u . "navigation-arrows/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.arrows.set', $v => true, $o => 'nav_arrows')
									),
									$m => "#module_navigation_trigger, #gst_nav_2", 
									$st => '#form_nav_arrows_left', 
									$f => "#nav_arrows_left_offsety, #nav_arrows_right_offsety"
								)
							),
							'animation' => array(
								$t => __("Arrows Animation", 'revsliderhelp'),
								$h => "nav.arrows.left.anim, nav.arrows.right.anim",
								$k => array("arrow animation", "arrows animation", "show arrows", "hide arrows"),
								$d => __("Optionally animate the arrows into and out of view when the slider first loads and on mouse hover", 'revsliderhelp'),
								$a => $u . "navigation-arrows/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.arrows.set', $v => true, $o => 'nav_arrows')
									),
									$m => "#module_navigation_trigger, #gst_nav_2", 
									$st => '#form_nav_arrows_left', 
									$f => "#sr_arrowleft_animation, #sr_arrowright_animation"
								)
							)
						),
						'visibility' => array(
							'rtl' => array(
								$t => __("Right to Left", 'revsliderhelp'),
								$h => "nav.arrows.rtl",
								$k => array("rtl", "right to left", "right-to-left"),
								$d => __("Use RTL language alignment for the Arrow positioning", 'revsliderhelp'),
								$a => $u . "navigation-arrows/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.arrows.set', $v => true, $o => 'nav_arrows')
									),
									$m => "#module_navigation_trigger, #gst_nav_2", 
									$st => '#form_nav_arrows_visi', 
									$f => "#sr_arrowrtl"
								)
							),
							'show_speed' => array(
								$t => __("Arrows Animation Speed", 'revsliderhelp'),
								$h => "nav.arrows.animSpeed",
								$k => array("arrows visibility", "show speed", "navigation speed"),
								$d => __("The animation speed for when the Arrows animate into and out of view", 'revsliderhelp'),
								$a => $u . "navigation-arrows/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.arrows.set', $v => true, $o => 'nav_arrows')
									),
									$m => "#module_navigation_trigger, #gst_nav_2", 
									$st => '#form_nav_arrows_visi', 
									$f => "#nav_arrow_animSpeed"
								)
							),
							'show_delay' => array(
								$t => __("Arrows Show Delay", 'revsliderhelp'),
								$h => "nav.arrows.animDelay",
								$k => array("arrows visibility", "navigation delay"),
								$d => __("A delay in milliseconds before the Arrows animate into view", 'revsliderhelp'),
								$a => $u . "navigation-arrows/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.arrows.set', $v => true, $o => 'nav_arrows')
									),
									$m => "#module_navigation_trigger, #gst_nav_2", 
									$st => '#form_nav_arrows_visi', 
									$f => "#nav_arrow_animDelay"
								)
							),
							'hide_after' => array(
								$di => "nav_arrows_hide_after",
								$t => __("Hide After", 'revsliderhelp'),
								$h => "nav.arrows.alwaysOn",
								$k => array("arrows visibility", "hide after"),
								$d => __("Auto-hide the arrows after a set amount of time (will be shown again when the user hovers/taps the Slider)", 'revsliderhelp'),
								$a => $u . "navigation-arrows/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.arrows.set', $v => true, $o => 'nav_arrows')
									),
									$m => "#module_navigation_trigger, #gst_nav_2", 
									$st => '#form_nav_arrows_visi', 
									$f => "#sr_arrowsalwshow"
								)
							),
							'hide_after_desktop' => array(
								$t => __("Hide After: Desktop", 'revsliderhelp'),
								$h => "nav.arrows.hideDelay",
								$k => array("arrows visibility", "hide after", "hide after desktop"),
								$d => __("The amount of the time before the Arrows are hidden on Desktop computers (in milliseconds)", 'revsliderhelp'),
								$a => $u . "navigation-arrows/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.arrows.set', $v => true, $o => 'nav_arrows'),
										array($p => 'settings.nav.arrows.alwaysOn', $v => true, $o => 'nav_arrows_hide_after')
									),
									$m => "#module_navigation_trigger, #gst_nav_2", 
									$st => '#form_nav_arrows_visi', 
									$f => "#nav_arrows_hideDelay"
								)
							),
							'hide_after_mobile' => array(
								$t => __("Hide After: Mobile", 'revsliderhelp'),
								$h => "nav.arrows.hideDelayMobile",
								$k => array("arrows visibility", "hide after", "hide after desktop"),
								$d => __("The amount of the time before the Arrows are hidden on mobile devices (in milliseconds)", 'revsliderhelp'),
								$a => $u . "navigation-arrows/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.arrows.set', $v => true, $o => 'nav_arrows'),
										array($p => 'settings.nav.arrows.alwaysOn', $v => true, $o => 'nav_arrows_hide_after')
									),
									$m => "#module_navigation_trigger, #gst_nav_2", 
									$st => '#form_nav_arrows_visi', 
									$f => "#nav_arrows_hideDelayMobile"
								)
							),
							'hide_under' => array(
								$di => "nav_arrows_hideunder",
								$t => __("Hide Under", 'revsliderhelp'),
								$h => "nav.arrows.hideUnder",
								$k => array("arrows visibility", "hide under", "hide under width"),
								$d => __("Hide the Arrows when the browser window is equal to or below a certain number", 'revsliderhelp'),
								$a => $u . "navigation-arrows/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.arrows.set', $v => true, $o => 'nav_arrows')
									),
									$m => "#module_navigation_trigger, #gst_nav_2", 
									$st => '#form_nav_arrows_visi', 
									$f => "#sr_arrowshideunder"
								)
							),
							'hide_under_limit' => array(
								$t => __("Hide Under Limit", 'revsliderhelp'),
								$h => "nav.arrows.hideUnderLimit",
								$k => array("arrows visibility", "hide under", "hide under limit"),
								$d => __("Hide the Arrows when the browser window is equal to or below this number", 'revsliderhelp'),
								$a => $u . "navigation-arrows/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.arrows.set', $v => true, $o => 'nav_arrows'),
										array($p => 'settings.nav.arrows.hideUnder', $v => true, $o => 'nav_arrows_hideunder')
									),
									$m => "#module_navigation_trigger, #gst_nav_2", 
									$st => '#form_nav_arrows_visi', 
									$f => "#nav_arrows_hideunderlimit"
								)
							),
							'hide_over' => array(
								$di => "nav_arrows_hideover",
								$t => __("Hide Over", 'revsliderhelp'),
								$h => "nav.arrows.hideOver",
								$k => array("arrows visibility", "hide over", "hide over limit"),
								$d => __("Hide the Arrows when the browser window is equal to or above a certain number", 'revsliderhelp'),
								$a => $u . "navigation-arrows/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.arrows.set', $v => true, $o => 'nav_arrows')
									),
									$m => "#module_navigation_trigger, #gst_nav_2", 
									$st => '#form_nav_arrows_visi', 
									$f => "#sr_arrowshideover"
								)
							),
							'hide_over_limit' => array(
								$t => __("Hide Over Limit", 'revsliderhelp'),
								$h => "nav.arrows.hideOverLimit",
								$k => array("arrows visibility", "hide over", "hide over limit"),
								$d => __("Hide the Arrows when the browser window is equal to or above this number", 'revsliderhelp'),
								$a => $u . "navigation-arrows/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.arrows.set', $v => true, $o => 'nav_arrows'),
										array($p => 'settings.nav.arrows.hideUnder', $v => true, $o => 'nav_arrows_hideover')
									),
									$m => "#module_navigation_trigger, #gst_nav_2", 
									$st => '#form_nav_arrows_visi', 
									$f => "#nav_arrows_hideoverlimit"
								)
							)
						)
					),
					'gst_nav_3' => array(
						'enable' => array(
							$di => "nav_bullets",
							$t => __("Enable Bullets", 'revsliderhelp'),
							$h => "nav.bullets.set",
							$k => array("navigation", "bullet", "bullets", "add bullets", "add navigation"),
							$d => __("Enable Bullets for the Slider's navigation", 'revsliderhelp'),
							$a => $u . "navigation-bullets/",
							$hl => array(
								$dp => array(array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard')),
								$m => "#module_navigation_trigger, #gst_nav_3", 
								$st => '#form_nav_bullets_mainstyle', 
								$f => "#sr_usenavbullets"
							)
						),
						'type' => array(
							$t => __("Bullets Type/Style", 'revsliderhelp'),
							$h => "nav.bullets.style",
							$k => array("navigation", "bullets", "bullet type", "bullet style", "bullets style", "bullets type"),
							$d => __("Choose a predefined style for the Bullets navigation", 'revsliderhelp'),
							$a => $u . "navigation-bullets/",
							$hl => array(
								$dp => array(
									array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
									array($p => 'settings.nav.bullets.set', $v => true, $o => 'nav_bullets')
								),
								$m => "#module_navigation_trigger, #gst_nav_3", 
								$st => '#form_nav_bullets_mainstyle', 
								$f => "#sr_bullets_style"
							)
						),
						'positioning' => array(
							'gap' => array(
								$t => __("Gap/Spacing", 'revsliderhelp'),
								$h => "nav.bullets.space",
								$k => array("bullets spacing", "bullet spacing", "gap", "spacing", "bullet gap", "bullets spacing", "bullet space", "bullets space"),
								$d => __("The spacing between the bullets (in pixels)", 'revsliderhelp'),
								$a => $u . "navigation-bullets/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.bullets.set', $v => true, $o => 'nav_bullets')
									),
									$m => "#module_navigation_trigger, #gst_nav_3", 
									$st => '#form_nav_bullets_posi', 
									$f => "#nav_bullets_space"
								)
							),
							'orientation' => array(
								$t => __("Orientation", 'revsliderhelp'),
								$h => "nav.bullets.direction",
								$k => array("bullets orientation", "bullet orientation", "gap", "orientation", "bullet horizontal", "bullets horizontal", "bullet vertical", "bullets veritcal"),
								$d => __("Display the bullets next to one another (horizontal) or on top of one another (vertical)", 'revsliderhelp'),
								$a => $u . "navigation-bullets/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.bullets.set', $v => true, $o => 'nav_bullets')
									),
									$m => "#module_navigation_trigger, #gst_nav_3", 
									$st => '#form_nav_bullets_posi', 
									$f => "*[name='sr_bulletdirection'][value='horizontal']"
								)
							),
							'align_by' => array(
								$t => __("Align By Slider/Content", 'revsliderhelp'),
								$h => "nav.bullets.align",
								$k => array("bullets", "bullet align", "bullet alignment"),
								$d => __("Choose 'Slider' to align based on the Slider's full display, or 'Content' to align against the Slider's grid area", 'revsliderhelp'),
								$a => $u . "navigation-bullets/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.bullets.set', $v => true, $o => 'nav_bullets')
									),
									$m => "#module_navigation_trigger, #gst_nav_3", 
									$st => '#form_nav_bullets_posi', 
									$f => "*[name='sr_bulletsalign'][value='slider']"
								)
							),
							'alignment' => array(
								$t => __("Alignment", 'revsliderhelp'),
								$h => "nav.bullets.horizontal, nav.bullets.vertical",
								$k => array("bullet align", "bullet alignment", "bullet position", "bullets position"),
								$d => __("The Bullet's alignment position in the Slider before any offset(s) are applied", 'revsliderhelp'),
								$a => $u . "navigation-bullets/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.bullets.set', $v => true, $o => 'nav_bullets')
									),
									$m => "#module_navigation_trigger, #gst_nav_3", 
									$st => '#form_nav_bullets_posi', 
									$f => "#bulletspos_selector_center-center"
								)
							),
							'offsetx' => array(
								$t => __("Offset X", 'revsliderhelp'),
								$h => "nav.bullets.offsetX",
								$k => array("bullet position", "bullet offset"),
								$d => __("Offset the Bullet's horizontal position by this amount.  Accepts positive and negative values.", 'revsliderhelp'),
								$a => $u . "navigation-bullets/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.bullets.set', $v => true, $o => 'nav_bullets')
									),
									$m => "#module_navigation_trigger, #gst_nav_3", 
									$st => '#form_nav_bullets_posi', 
									$f => "#nav_bullets_offsetx"
								)
							),
							'offsety' => array(
								$t => __("Offset Y", 'revsliderhelp'),
								$h => "nav.bullets.offsetY",
								$k => array("bullet position", "bullet offset"),
								$d => __("Offset the Bullet's vertical position by this amount.  Accepts positive and negative values.", 'revsliderhelp'),
								$a => $u . "navigation-bullets/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.bullets.set', $v => true, $o => 'nav_bullets')
									),
									$m => "#module_navigation_trigger, #gst_nav_3", 
									$st => '#form_nav_bullets_posi', 
									$f => "#nav_bullets_offsety"
								)
							)
						),
						'visibility' => array(
							'rtl' => array(
								$t => __("Right to Left", 'revsliderhelp'),
								$h => "nav.bullets.rtl",
								$k => array("rtl", "right to left", "right-to-left"),
								$d => __("Use RTL language alignment for the Arrow positioning", 'revsliderhelp'),
								$a => $u . "navigation-bullets/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.bullets.set', $v => true, $o => 'nav_bullets')
									),
									$m => "#module_navigation_trigger, #gst_nav_3", 
									$st => '#form_nav_bullets_visi', 
									$f => "#sr_bulletrtl"
								)
							),
							'animation' => array(
								$t => __("Bullets Animation", 'revsliderhelp'),
								$h => "nav.bullets.anim",
								$k => array("bullets animation", "bullet animation", "show bullets", "hide bullets", "navigation animation"),
								$d => __("Optionally animate the bullets into and out of view when the slider first loads and on mouse hover", 'revsliderhelp'),
								$a => $u . "navigation-bullets/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.bullets.set', $v => true, $o => 'nav_bullets')
									),
									$m => "#module_navigation_trigger, #gst_nav_3", 
									$st => '#form_nav_bullets_visi', 
									$f => "#sr_bullets_animation"
								)
							),
							'show_speed' => array(
								$t => __("Bullets Animation Speed", 'revsliderhelp'),
								$h => "nav.bullets.animSpeed",
								$k => array("bullets visibility", "show speed", "navigation speed"),
								$d => __("The animation speed for when the Bullets animate into and out of view", 'revsliderhelp'),
								$a => $u . "navigation-bullets/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.bullets.set', $v => true, $o => 'nav_bullets')
									),
									$m => "#module_navigation_trigger, #gst_nav_3", 
									$st => '#form_nav_bullets_visi', 
									$f => "#nav_bullet_animSpeed"
								)
							),
							'show_delay' => array(
								$t => __("Bullets Show Delay", 'revsliderhelp'),
								$h => "nav.bullets.animDelay",
								$k => array("bullets visibility", "navigation delay"),
								$d => __("A delay in milliseconds before the Bullets animate into view", 'revsliderhelp'),
								$a => $u . "navigation-bullets/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.bullets.set', $v => true, $o => 'nav_bullets')
									),
									$m => "#module_navigation_trigger, #gst_nav_3", 
									$st => '#form_nav_bullets_visi', 
									$f => "#nav_bullet_animDelay"
								)
							),
							'hide_after' => array(
								$di => "nav_bullets_hideafter",
								$t => __("Hide After", 'revsliderhelp'),
								$h => "nav.bullets.alwaysOn",
								$k => array("bullets visibility", "hide after"),
								$d => __("Auto-hide the bullets after a set amount of time (will be shown again when the user hovers/taps the Slider)", 'revsliderhelp'),
								$a => $u . "navigation-bullets/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.bullets.set', $v => true, $o => 'nav_bullets')
									),
									$m => "#module_navigation_trigger, #gst_nav_3", 
									$st => '#form_nav_bullets_visi', 
									$f => "#sr_bulletsalwshow"
								)
							),
							'hide_after_desktop' => array(
								$t => __("Hide After: Desktop", 'revsliderhelp'),
								$h => "nav.bullets.hideDelay",
								$k => array("bullets visibility", "hide after", "hide after desktop"),
								$d => __("The amount of the time before the Bullets are hidden on Desktop computers (in milliseconds)", 'revsliderhelp'),
								$a => $u . "navigation-bullets/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.bullets.set', $v => true, $o => 'nav_bullets'),
										array($p => 'settings.nav.bullets.alwaysOn', $v => true, $o => 'nav_bullets_hideafter')
									),
									$m => "#module_navigation_trigger, #gst_nav_3", 
									$st => '#form_nav_bullets_visi', 
									$f => "#nav_bullets_hideDelay"
								)
							),
							'hide_after_mobile' => array(
								$t => __("Hide After: Mobile", 'revsliderhelp'),
								$h => "nav.bullets.hideDelayMobile",
								$k => array("bullets visibility", "hide after", "hide after desktop"),
								$d => __("The amount of the time before the Bullets are hidden on mobile devices (in milliseconds)", 'revsliderhelp'),
								$a => $u . "navigation-bullets/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.bullets.set', $v => true, $o => 'nav_bullets'),
										array($p => 'settings.nav.bullets.alwaysOn', $v => true, $o => 'nav_bullets_hideafter')
									),
									$m => "#module_navigation_trigger, #gst_nav_3", 
									$st => '#form_nav_bullets_visi', 
									$f => "#nav_bullets_hideDelayMobile"
								)
							),
							'hide_under' => array(
								$di => "nav_bullets_hideunder",
								$t => __("Hide Under", 'revsliderhelp'),
								$h => "nav.bullets.hideUnder",
								$k => array("bullets visibility", "hide under", "hide under width"),
								$d => __("Hide the Bullets when the browser window is equal to or below a certain number", 'revsliderhelp'),
								$a => $u . "navigation-bullets/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.bullets.set', $v => true, $o => 'nav_bullets')
									),
									$m => "#module_navigation_trigger, #gst_nav_3", 
									$st => '#form_nav_bullets_visi', 
									$f => "#sr_bulletshideunder"
								)
							),
							'hide_under_limit' => array(
								$t => __("Hide Under Limit", 'revsliderhelp'),
								$h => "nav.bullets.hideUnderLimit",
								$k => array("bullets visibility", "hide under", "hide under limit"),
								$d => __("Hide the Bullets when the browser window is equal to or below this number", 'revsliderhelp'),
								$a => $u . "navigation-bullets/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.bullets.set', $v => true, $o => 'nav_bullets'),
										array($p => 'settings.nav.bullets.hideUnder', $v => true, $o => 'nav_bullets_hideunder')
									),
									$m => "#module_navigation_trigger, #gst_nav_3", 
									$st => '#form_nav_bullets_visi', 
									$f => "#nav_bullets_hideunderlimit"
								)
							),
							'hide_over' => array(
								$di => "nav_bullets_hideover",
								$t => __("Hide Over", 'revsliderhelp'),
								$h => "nav.bullets.hideOver",
								$k => array("bullets visibility", "hide over", "hide over limit"),
								$d => __("Hide the Bullets when the browser window is equal to or above a certain number", 'revsliderhelp'),
								$a => $u . "navigation-bullets/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.bullets.set', $v => true, $o => 'nav_bullets')
									),
									$m => "#module_navigation_trigger, #gst_nav_3", 
									$st => '#form_nav_bullets_visi', 
									$f => "#sr_bulletshideover"
								)
							),
							'hide_over_limit' => array(
								$t => __("Hide Over Limit", 'revsliderhelp'),
								$h => "nav.bullets.hideOverLimit",
								$k => array("bullets visibility", "hide over", "hide over limit"),
								$d => __("Hide the Bullets when the browser window is equal to or above this number", 'revsliderhelp'),
								$a => $u . "navigation-bullets/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.bullets.set', $v => true, $o => 'nav_bullets'),
										array($p => 'settings.nav.bullets.hideOver', $v => true, $o => 'nav_bullets_hideover')
									),
									$m => "#module_navigation_trigger, #gst_nav_3", 
									$st => '#form_nav_bullets_visi', 
									$f => "#nav_bullets_hideoverlimit"
								)
							)
						),
						'styles' => array(
							'css_styling' => array(
								$t => __("CSS Styling", 'revsliderhelp'),
								$h => "navigation.styles",
								$k => array("navigation", "navigation styles", "bullets style", "bullets style", "bullet style"),
								$d => __("Adjust the size colors and other styles for the bullets", 'revsliderhelp'),
								$a => $u . "navigation-bullets/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.bullets.set', $v => true, $o => 'nav_bullets')
									),
									$m => "#module_navigation_trigger, #gst_nav_3", 
									$st => '#form_nav_bullets_style', 
									$f => "#form_nav_bullets_style .navstyleinput{first}"
								)
							),
							'override' => array(
								$t => __("Use Custom Style", 'revsliderhelp'),
								$h => "navigation.styles.default",
								$k => array("navigation", "navigation styles", "bullets style", "bullets style", "bullet style"),
								$d => __("Enable custom styling overrides for the bullets", 'revsliderhelp'),
								$a => $u . "navigation-bullets/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.bullets.set', $v => true, $o => 'nav_bullets')
									),
									$m => "#module_navigation_trigger, #gst_nav_3", 
									$st => '#form_slide_nav_bullets', 
									$f => "#form_slide_nav_bullets .navstyleinput{first}"
								)
							)
						)
					),
					'gst_nav_4' => array(
						'enable' => array(
							$di => "nav_tabs",
							$t => __("Enable Tabs", 'revsliderhelp'),
							$h => "nav.tabs.set",
							$k => array("navigation", "tab", "tabs", "add tabs", "add navigation"),
							$d => __("Enable Tabs for the Slider's navigation", 'revsliderhelp'),
							$a => $u . "navigation-tabs/",
							$hl => array(
								$dp => array(array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard')),
								$m => "#module_navigation_trigger, #gst_nav_4", 
								$st => '#form_nav_tabs_mainstyle', 
								$f => "#sr_usenavtabs"
							)
						),
						'type' => array(
							$t => __("Tabs Type/Style", 'revsliderhelp'),
							$h => "nav.tabs.style",
							$k => array("navigation", "tabs", "tab type", "tab style", "tabs style", "tabs type"),
							$d => __("Choose a predefined style for the Tabs navigation", 'revsliderhelp'),
							$a => $u . "navigation-tabs/",
							$hl => array(
								$dp => array(
									array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
									array($p => 'settings.nav.tabs.set', $v => true, $o => 'nav_tabs')
								),
								$m => "#module_navigation_trigger, #gst_nav_4", 
								$st => '#form_nav_tabs_mainstyle', 
								$f => "#sr_tabs_style"
							)
						),
						'positioning' => array(
							'orientation' => array(
								$t => __("Orientation", 'revsliderhelp'),
								$h => "nav.tabs.direction",
								$k => array("tabs orientation", "tab orientation", "gap", "orientation", "tab horizontal", "tabs horizontal", "tab vertical", "tabs veritcal"),
								$d => __("Display the tabs next to one another (horizontal) or on top of one another (vertical)", 'revsliderhelp'),
								$a => $u . "navigation-tabs/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.tabs.set', $v => true, $o => 'nav_tabs')
									),
									$m => "#module_navigation_trigger, #gst_nav_4", 
									$st => '#form_nav_tabs_posi', 
									$f => "*[name='sr_tabsdirection'][value='horizontal']"
								)
							),
							'align_by' => array(
								$t => __("Align By Slider/Content", 'revsliderhelp'),
								$h => "nav.tabs.align",
								$k => array("tabs", "tab align", "tab alignment"),
								$d => __("Choose 'Slider' to align based on the Slider's full display, or 'Content' to align against the Slider's grid area", 'revsliderhelp'),
								$a => $u . "navigation-tabs/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.tabs.set', $v => true, $o => 'nav_tabs')
									),
									$m => "#module_navigation_trigger, #gst_nav_4", 
									$st => '#form_nav_tabs_posi', 
									$f => "*[name='sr_tabsalign'][value='slider']"
								)
							),
							'inner_outer' => array(
								$t => __("Inner/Outer", 'revsliderhelp'),
								$h => "nav.tabs.innerOuter",
								$k => array("tabs. tabs position", "tabs inner", "tabs outer", "inner outer", "inner", "outer vertical", "outer horizontal"),
								$d => __("Choose if the tabs should appear inside or outside the Slider's main content area", 'revsliderhelp'),
								$a => $u . "navigation-tabs/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.tabs.set', $v => true, $o => 'nav_tabs')
									),
									$m => "#module_navigation_trigger, #gst_nav_4", 
									$st => '#form_nav_tabs_posi', 
									$f => "*[name='sr_tabsinnerouter'][value='inner']"
								)
							),
							'alignment' => array(
								$t => __("Alignment", 'revsliderhelp'),
								$h => "nav.tabs.horizontal, nav.tabs.vertical",
								$k => array("tab align", "tab alignment", "tab position", "tabs position"),
								$d => __("The Tab's alignment position in the Slider before any offset(s) are applied", 'revsliderhelp'),
								$a => $u . "navigation-tabs/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.tabs.set', $v => true, $o => 'nav_tabs')
									),
									$m => "#module_navigation_trigger, #gst_nav_4", 
									$st => '#form_nav_tabs_posi', 
									$f => "#tabspos_selector_center-center"
								)
							),
							'offsetx' => array(
								$t => __("Offset X", 'revsliderhelp'),
								$h => "nav.tabs.offsetX",
								$k => array("tab position", "tab offset"),
								$d => __("Offset the Tab's horizontal position by this amount.  Accepts positive and negative values.", 'revsliderhelp'),
								$a => $u . "navigation-tabs/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.tabs.set', $v => true, $o => 'nav_tabs')
									),
									$m => "#module_navigation_trigger, #gst_nav_4", 
									$st => '#form_nav_tabs_posi', 
									$f => "#nav_tabs_offsetx"
								)
							),
							'offsety' => array(
								$t => __("Offset Y", 'revsliderhelp'),
								$h => "nav.tabs.offsetY",
								$k => array("tab position", "tab offset"),
								$d => __("Offset the Tab's vertical position by this amount.  Accepts positive and negative values.", 'revsliderhelp'),
								$a => $u . "navigation-tabs/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.tabs.set', $v => true, $o => 'nav_tabs')
									),
									$m => "#module_navigation_trigger, #gst_nav_4", 
									$st => '#form_nav_tabs_posi', 
									$f => "#nav_tabs_offsety"
								)
							),
							'visible_amount' => array(
								$t => __("Num. Tabs", 'revsliderhelp'),
								$h => "nav.tabs.amount",
								$k => array("tabs amount", "num tabs", "number tabs"),
								$d => __("The maximum number of tabs that should be visible regardless of the screen size", 'revsliderhelp'),
								$a => $u . "navigation-tabs/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.tabs.set', $v => true, $o => 'nav_tabs')
									),
									$m => "#module_navigation_trigger, #gst_nav_4", 
									$st => '#form_nav_tabs_posi', 
									$f => "#nav_tabs_amount"
								)
							)
						),
						'size' => array(
							'space' => array(
								$t => __("Spacing", 'revsliderhelp'),
								$h => "nav.tabs.space",
								$k => array("tabs space", "tabs spacing", "tab space", "tabs spacing", "tab margin", "tab padding", "tabs margin", "tabs padding"),
								$d => __("The space between each individual tab (in pixels)", 'revsliderhelp'),
								$a => $u . "navigation-tabs/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.tabs.set', $v => true, $o => 'nav_tabs')
									),
									$m => "#module_navigation_trigger, #gst_nav_4", 
									$st => '#form_nav_tabs_size', 
									$f => "#nav_tabs_space"
								)
							),
							'width' => array(
								$t => __("Width", 'revsliderhelp'),
								$h => "nav.tabs.width",
								$k => array("tabs width", "tab width", "tabs size", "tab size"),
								$d => __("The default width for each individual tab", 'revsliderhelp'),
								$a => $u . "navigation-tabs/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.tabs.set', $v => true, $o => 'nav_tabs')
									),
									$m => "#module_navigation_trigger, #gst_nav_4", 
									$st => '#form_nav_tabs_size', 
									$f => "#nav_tabs_width"
								)
							),
							'min_width' => array(
								$t => __("Minimum Width", 'revsliderhelp'),
								$h => "nav.tabs.widthMin",
								$k => array("tabs min-width", "tabs min-width", "tabs size", "tab size", "tabs min width", "tabs minimum width"),
								$d => __("The minimum width for each individual tab", 'revsliderhelp'),
								$a => $u . "navigation-tabs/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.tabs.set', $v => true, $o => 'nav_tabs')
									),
									$m => "#module_navigation_trigger, #gst_nav_4", 
									$st => '#form_nav_tabs_size', 
									$f => "#nav_tabs_widthMin"
								)
							),
							'height' => array(
								$t => __("Height", 'revsliderhelp'),
								$h => "nav.tabs.height",
								$k => array("tabs height", "tabs height", "tabs size", "tab size"),
								$d => __("The default height for each individual tab", 'revsliderhelp'),
								$a => $u . "navigation-tabs/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.tabs.set', $v => true, $o => 'nav_tabs')
									),
									$m => "#module_navigation_trigger, #gst_nav_4", 
									$st => '#form_nav_tabs_size', 
									$f => "#nav_tabs_height"
								)
							)
						),
						'wrapper' => array(
							'color' => array(
								$t => __("Color", 'revsliderhelp'),
								$h => "nav.tabs.wrapperColor",
								$k => array("tabs color", "tabs color", "tabs size", "tab size"),
								$d => __("The background color for the tabs main wrapper", 'revsliderhelp'),
								$a => $u . "navigation-tabs/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.tabs.set', $v => true, $o => 'nav_tabs')
									),
									$m => "#module_navigation_trigger, #gst_nav_4", 
									$st => '#form_nav_tabs_wrap', 
									$f => "#sliderTabBgColor"
								)
							),
							'padding' => array(
								$t => __("Padding", 'revsliderhelp'),
								$h => "nav.tabs.padding",
								$k => array("tabs wrapper", "tabs wrapper padding", "wrapper padding"),
								$d => __("The CSS padding that will be applied to the tabs outer wrapper div", 'revsliderhelp'),
								$a => $u . "navigation-tabs/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.tabs.set', $v => true, $o => 'nav_tabs')
									),
									$m => "#module_navigation_trigger, #gst_nav_4", 
									$st => '#form_nav_tabs_wrap', 
									$f => "#nav_tabs_padding"
								)
							),
							'span' => array(
								$t => __("Span/Full-Width", 'revsliderhelp'),
								$h => "nav.tabs.spanWrapper",
								$k => array("tabs span", "tabs wrapper", "tabs wrapper span", "tabs full width", "tabs full-width"),
								$d => __("Choose if the wrapper should be displayed as a block or an inline-block", 'revsliderhelp'),
								$a => $u . "navigation-tabs/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.tabs.set', $v => true, $o => 'nav_tabs')
									),
									$m => "#module_navigation_trigger, #gst_nav_4", 
									$st => '#form_nav_tabs_wrap', 
									$f => "#sr_tabspan"
								)
							)
						),
						'visibility' => array(
							'rtl' => array(
								$t => __("Right to Left", 'revsliderhelp'),
								$h => "nav.tabs.rtl",
								$k => array("rtl", "right to left", "right-to-left"),
								$d => __("Use RTL language alignment for the Arrow positioning", 'revsliderhelp'),
								$a => $u . "navigation-tabs/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.tabs.set', $v => true, $o => 'nav_tabs')
									),
									$m => "#module_navigation_trigger, #gst_nav_4", 
									$st => '#form_nav_tabs_visi', 
									$f => "#sr_tabsrtl"
								)
							),
							'animation' => array(
								$t => __("Tabs Animation", 'revsliderhelp'),
								$h => "nav.tabs.anim",
								$k => array("tabs animation", "bullet animation", "show tabs", "hide tabs", "navigation animation"),
								$d => __("Optionally animate the tabs into and out of view when the slider first loads and on mouse hover", 'revsliderhelp'),
								$a => $u . "navigation-tabs/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.tabs.set', $v => true, $o => 'nav_tabs')
									),
									$m => "#module_navigation_trigger, #gst_nav_4", 
									$st => '#form_nav_tabs_visi', 
									$f => "#sr_tabs_animation"
								)
							),
							'show_speed' => array(
								$t => __("Tabs Animation Speed", 'revsliderhelp'),
								$h => "nav.tabs.animSpeed",
								$k => array("tabs visibility", "show speed", "navigation speed"),
								$d => __("The animation speed for when the Tabs animate into and out of view", 'revsliderhelp'),
								$a => $u . "navigation-tabs/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.tabs.set', $v => true, $o => 'nav_tabs')
									),
									$m => "#module_navigation_trigger, #gst_nav_4", 
									$st => '#form_nav_tabs_visi', 
									$f => "#nav_tab_animSpeed"
								)
							),
							'show_delay' => array(
								$t => __("Tabs Show Delay", 'revsliderhelp'),
								$h => "nav.tabs.animDelay",
								$k => array("tabs visibility", "navigation delay"),
								$d => __("A delay in milliseconds before the Tabs animate into view", 'revsliderhelp'),
								$a => $u . "navigation-tabs/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.tabs.set', $v => true, $o => 'nav_tabs')
									),
									$m => "#module_navigation_trigger, #gst_nav_4", 
									$st => '#form_nav_tabs_visi', 
									$f => "#nav_tab_animDelay"
								)
							),
							'hide_after' => array(
								$di => "nav_tabs_hideafter",
								$t => __("Hide After", 'revsliderhelp'),
								$h => "nav.tabs.alwaysOn",
								$k => array("tabs visibility", "hide after"),
								$d => __("Auto-hide the tabs after a set amount of time (will be shown again when the user hovers/taps the Slider)", 'revsliderhelp'),
								$a => $u . "navigation-tabs/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.tabs.set', $v => true, $o => 'nav_tabs')
									),
									$m => "#module_navigation_trigger, #gst_nav_4", 
									$st => '#form_nav_tabs_visi', 
									$f => "#sr_tabsalwshow"
								)
							),
							'hide_after_desktop' => array(
								$t => __("Hide After: Desktop", 'revsliderhelp'),
								$h => "nav.tabs.hideDelay",
								$k => array("tabs visibility", "hide after", "hide after desktop"),
								$d => __("The amount of the time before the Tabs are hidden on Desktop computers (in milliseconds)", 'revsliderhelp'),
								$a => $u . "navigation-tabs/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.tabs.set', $v => true, $o => 'nav_tabs'),
										array($p => 'settings.nav.tabs.alwaysOn', $v => true, $o => 'nav_tabs_hideafter')
									),
									$m => "#module_navigation_trigger, #gst_nav_4", 
									$st => '#form_nav_tabs_visi', 
									$f => "#nav_tabs_hideDelay"
								)
							),
							'hide_after_mobile' => array(
								$t => __("Hide After: Mobile", 'revsliderhelp'),
								$h => "nav.tabs.hideDelayMobile",
								$k => array("tabs visibility", "hide after", "hide after desktop"),
								$d => __("The amount of the time before the Tabs are hidden on mobile devices (in milliseconds)", 'revsliderhelp'),
								$a => $u . "navigation-tabs/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.tabs.set', $v => true, $o => 'nav_tabs'),
										array($p => 'settings.nav.tabs.alwaysOn', $v => true, $o => 'nav_tabs_hideafter')
									),
									$m => "#module_navigation_trigger, #gst_nav_4", 
									$st => '#form_nav_tabs_visi', 
									$f => "#nav_tabs_hideDelayMobile"
								)
							),
							'hide_under' => array(
								$di => "nav_tabs_hideunder",
								$t => __("Hide Under", 'revsliderhelp'),
								$h => "nav.tabs.hideUnder",
								$k => array("tabs visibility", "hide under", "hide under width"),
								$d => __("Hide the Tabs when the browser window is equal to or below a certain number", 'revsliderhelp'),
								$a => $u . "navigation-tabs/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.tabs.set', $v => true, $o => 'nav_tabs')
									),
									$m => "#module_navigation_trigger, #gst_nav_4", 
									$st => '#form_nav_tabs_visi', 
									$f => "#sr_tabshideunder"
								)
							),
							'hide_under_limit' => array(
								$t => __("Hide Under Limit", 'revsliderhelp'),
								$h => "nav.tabs.hideUnderLimit",
								$k => array("tabs visibility", "hide under", "hide under limit"),
								$d => __("Hide the Tabs when the browser window is equal to or below this number", 'revsliderhelp'),
								$a => $u . "navigation-tabs/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.tabs.set', $v => true, $o => 'nav_tabs'),
										array($p => 'settings.nav.tabs.hideUnder', $v => true, $o => 'nav_tabs_hideunder')
									),
									$m => "#module_navigation_trigger, #gst_nav_4", 
									$st => '#form_nav_tabs_visi', 
									$f => "#nav_tabs_hideunderlimit"
								)
							),
							'hide_over' => array(
								$di => "nav_tabs_hideover",
								$t => __("Hide Over", 'revsliderhelp'),
								$h => "nav.tabs.hideOver",
								$k => array("tabs visibility", "hide over", "hide over limit"),
								$d => __("Hide the Tabs when the browser window is equal to or above a certain number", 'revsliderhelp'),
								$a => $u . "navigation-tabs/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.tabs.set', $v => true, $o => 'nav_tabs')
									),
									$m => "#module_navigation_trigger, #gst_nav_4", 
									$st => '#form_nav_tabs_visi', 
									$f => "#sr_tabshideover"
								)
							),
							'hide_over_limit' => array(
								$t => __("Hide Over Limit", 'revsliderhelp'),
								$h => "nav.tabs.hideOverLimit",
								$k => array("tabs visibility", "hide over", "hide over limit"),
								$d => __("Hide the Tabs when the browser window is equal to or above this number", 'revsliderhelp'),
								$a => $u . "navigation-tabs/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.tabs.set', $v => true, $o => 'nav_tabs'),
										array($p => 'settings.nav.tabs.hideOver', $v => true, $o => 'nav_tabs_hideover')
									),
									$m => "#module_navigation_trigger, #gst_nav_4", 
									$st => '#form_nav_tabs_visi', 
									$f => "#nav_tabs_hideoverlimit"
								)
							)
						),
						'styles' => array(
							'css_styling' => array(
								$t => __("CSS Styling", 'revsliderhelp'),
								$h => "navigation.styles",
								$k => array("navigation", "navigation styles", "tabs style", "tabs style", "tab style", "tabs style", "tab style", "tab style"),
								$d => __("Adjust the size colors and other styles for the tabs", 'revsliderhelp'),
								$a => $u . "navigation-tabs/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.tabs.set', $v => true, $o => 'nav_tabs')
									),
									$m => "#module_navigation_trigger, #gst_nav_4", 
									$st => '#form_nav_tabs_style', 
									$f => "#form_nav_tabs_style .navstyleinput{first}"
								)
							),
							'override' => array(
								$t => __("Use Custom Style", 'revsliderhelp'),
								$h => "navigation.styles.default",
								$k => array("navigation", "navigation styles", "tabs style", "tabs style", "tab style", "tabs style", "tab style", "bullet style"),
								$d => __("Enable custom styling overrides for the tabs", 'revsliderhelp'),
								$a => $u . "navigation-tabs/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.tabs.set', $v => true, $o => 'nav_tabs')
									),
									$m => "#module_navigation_trigger, #gst_nav_4", 
									$st => '#form_slide_nav_tabs', 
									$f => "#form_slide_nav_tabs .navstyleinput{first}"
								)
							)
						)
					),
					'gst_nav_5' => array(
						'enable' => array(
							$di => "nav_thumbs",
							$t => __("Enable Thumbnails", 'revsliderhelp'),
							$h => "nav.thumbs.set",
							$k => array("navigation", "thumb", "thumbs", "add thumbs", "add navigation"),
							$d => __("Enable Thumbnails for the Slider's navigation", 'revsliderhelp'),
							$a => $u . "navigation-thumbnails/",
							$hl => array(
								$dp => array(array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard')),
								$m => "#module_navigation_trigger, #gst_nav_5", 
								$st => '#form_nav_thumbs_mainstyle', 
								$f => "#sr_usenavthumbs"
							)
						),
						'type' => array(
							$t => __("Thumbnails Type/Style", 'revsliderhelp'),
							$h => "nav.thumbs.style",
							$k => array("navigation", "thumbs", "thumb type", "thumb style", "thumbs style", "thumbs type"),
							$d => __("Choose a predefined style for the Thumbnails navigation", 'revsliderhelp'),
							$a => $u . "navigation-thumbnails/",
							$hl => array(
								$dp => array(
									array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
									array($p => 'settings.nav.thumbs.set', $v => true, $o => 'nav_thumbs')
								),
								$m => "#module_navigation_trigger, #gst_nav_5", 
								$st => '#form_nav_thumbs_mainstyle', 
								$f => "#sr_thumbs_style"
							)
						),
						'positioning' => array(
							'orientation' => array(
								$t => __("Orientation", 'revsliderhelp'),
								$h => "nav.thumbs.direction",
								$k => array("thumbs orientation", "thumb orientation", "gap", "orientation", "thumb horizontal", "thumbs horizontal", "thumb vertical", "thumbs veritcal"),
								$d => __("Display the thumbs next to one another (horizontal) or on top of one another (vertical)", 'revsliderhelp'),
								$a => $u . "navigation-thumbnails/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.thumbs.set', $v => true, $o => 'nav_thumbs')
									),
									$m => "#module_navigation_trigger, #gst_nav_5", 
									$st => '#form_nav_thumbs_posi', 
									$f => "*[name='sr_thumbsdirection'][value='horizontal']"
								)
							),
							'align_by' => array(
								$t => __("Align By Slider/Content", 'revsliderhelp'),
								$h => "nav.thumbs.align",
								$k => array("thumbs", "thumb align", "thumb alignment"),
								$d => __("Choose 'Slider' to align based on the Slider's full display, or 'Content' to align against the Slider's grid area", 'revsliderhelp'),
								$a => $u . "navigation-thumbnails/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.thumbs.set', $v => true, $o => 'nav_thumbs')
									),
									$m => "#module_navigation_trigger, #gst_nav_5", 
									$st => '#form_nav_thumbs_posi', 
									$f => "*[name='sr_thumbsalign'][value='slider']"
								)
							),
							'inner_outer' => array(
								$t => __("Inner/Outer", 'revsliderhelp'),
								$h => "nav.thumbs.innerOuter",
								$k => array("thumbs. thumbs position", "thumbs inner", "thumbs outer", "inner outer", "inner", "outer vertical", "outer horizontal"),
								$d => __("Choose if the thumbs should appear inside or outside the Slider's main content area", 'revsliderhelp'),
								$a => $u . "navigation-thumbnails/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.thumbs.set', $v => true, $o => 'nav_thumbs')
									),
									$m => "#module_navigation_trigger, #gst_nav_5", 
									$st => '#form_nav_thumbs_posi', 
									$f => "*[name='sr_thumbsinnerouter'][value='inner']"
								)
							),
							'alignment' => array(
								$t => __("Alignment", 'revsliderhelp'),
								$h => "nav.thumbs.horizontal, nav.thumbs.vertical",
								$k => array("thumb align", "thumb alignment", "thumb position", "thumbs position"),
								$d => __("The Thumb's alignment position in the Slider before any offset(s) are applied", 'revsliderhelp'),
								$a => $u . "navigation-thumbnails/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.thumbs.set', $v => true, $o => 'nav_thumbs')
									),
									$m => "#module_navigation_trigger, #gst_nav_5", 
									$st => '#form_nav_thumbs_posi', 
									$f => "#thumbspos_selector_center-center"
								)
							),
							'offsetx' => array(
								$t => __("Offset X", 'revsliderhelp'),
								$h => "nav.thumbs.offsetX",
								$k => array("thumb position", "thumb offset"),
								$d => __("Offset the Thumb's horizontal position by this amount.  Accepts positive and negative values.", 'revsliderhelp'),
								$a => $u . "navigation-thumbnails/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.thumbs.set', $v => true, $o => 'nav_thumbs')
									),
									$m => "#module_navigation_trigger, #gst_nav_5", 
									$st => '#form_nav_thumbs_posi', 
									$f => "#nav_thumbs_offsetx"
								)
							),
							'offsety' => array(
								$t => __("Offset Y", 'revsliderhelp'),
								$h => "nav.thumbs.offsetY",
								$k => array("thumb position", "thumb offset"),
								$d => __("Offset the Thumb's vertical position by this amount.  Accepts positive and negative values.", 'revsliderhelp'),
								$a => $u . "navigation-thumbnails/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.thumbs.set', $v => true, $o => 'nav_thumbs')
									),
									$m => "#module_navigation_trigger, #gst_nav_5", 
									$st => '#form_nav_thumbs_posi', 
									$f => "#nav_thumbs_offsety"
								)
							),
							'visible_amount' => array(
								$t => __("Num. Thumbs", 'revsliderhelp'),
								$h => "nav.thumbs.amount",
								$k => array("thumbs amount", "num thumbs", "number thumbs"),
								$d => __("The maximum number of thumbs that should be visible regardless of the screen size", 'revsliderhelp'),
								$a => $u . "navigation-thumbs/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.thumbs.set', $v => true, $o => 'nav_thumbs')
									),
									$m => "#module_navigation_trigger, #gst_nav_5", 
									$st => '#form_nav_thumbs_posi', 
									$f => "#nav_thumbs_amount"
								)
							)
						),
						'size' => array(
							'space' => array(
								$t => __("Spacing", 'revsliderhelp'),
								$h => "nav.thumbs.space",
								$k => array("thumbs space", "thumbs spacing", "thumb space", "thumbs spacing", "thumb margin", "thumb padding", "thumbs margin", "thumbs padding"),
								$d => __("The space between each individual thumb (in pixels)", 'revsliderhelp'),
								$a => $u . "navigation-thumbnails/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.thumbs.set', $v => true, $o => 'nav_thumbs')
									),
									$m => "#module_navigation_trigger, #gst_nav_5", 
									$st => '#form_nav_thumbs_size', 
									$f => "#nav_thumbs_space"
								)
							),
							'width' => array(
								$t => __("Width", 'revsliderhelp'),
								$h => "nav.thumbs.width",
								$k => array("thumbs width", "thumb width", "thumbs size", "thumb size"),
								$d => __("The default width for each individual thumb", 'revsliderhelp'),
								$a => $u . "navigation-thumbnails/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.thumbs.set', $v => true, $o => 'nav_thumbs')
									),
									$m => "#module_navigation_trigger, #gst_nav_5", 
									$st => '#form_nav_thumbs_size', 
									$f => "#nav_thumbs_width"
								)
							),
							'min_width' => array(
								$t => __("Minimum Width", 'revsliderhelp'),
								$h => "nav.thumbs.widthMin",
								$k => array("thumbs min-width", "thumbs min-width", "thumbs size", "thumb size", "thumbs min width", "thumbs minimum width"),
								$d => __("The minimum width for each individual thumb", 'revsliderhelp'),
								$a => $u . "navigation-thumbnails/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.thumbs.set', $v => true, $o => 'nav_thumbs')
									),
									$m => "#module_navigation_trigger, #gst_nav_5", 
									$st => '#form_nav_thumbs_size', 
									$f => "#nav_thumbs_widthMin"
								)
							),
							'height' => array(
								$t => __("Height", 'revsliderhelp'),
								$h => "nav.thumbs.height",
								$k => array("thumbs height", "thumbs height", "thumbs size", "thumb size"),
								$d => __("The default height for each individual thumb", 'revsliderhelp'),
								$a => $u . "navigation-thumbnails/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.thumbs.set', $v => true, $o => 'nav_thumbs')
									),
									$m => "#module_navigation_trigger, #gst_nav_5", 
									$st => '#form_nav_thumbs_size', 
									$f => "#nav_thumbs_height"
								)
							)
						),
						'wrapper' => array(
							'color' => array(
								$t => __("Wrapper Color", 'revsliderhelp'),
								$h => "nav.thumbs.wrapperColor",
								$k => array("thumbs color", "thumbs color", "thumbs size", "thumb size"),
								$d => __("The background color for the thumbs main wrapper", 'revsliderhelp'),
								$a => $u . "navigation-thumbnails/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.thumbs.set', $v => true, $o => 'nav_thumbs')
									),
									$m => "#module_navigation_trigger, #gst_nav_5", 
									$st => '#form_nav_thumbs_wrap', 
									$f => "#sliderThumbBgColor"
								)
							),
							'padding' => array(
								$t => __("Padding", 'revsliderhelp'),
								$h => "nav.thumbs.padding",
								$k => array("thumbs wrapper", "thumbs wrapper padding", "wrapper padding"),
								$d => __("The CSS padding that will be applied to the thumbs outer wrapper div", 'revsliderhelp'),
								$a => $u . "navigation-thumbnails/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.thumbs.set', $v => true, $o => 'nav_thumbs')
									),
									$m => "#module_navigation_trigger, #gst_nav_5", 
									$st => '#form_nav_thumbs_wrap', 
									$f => "#nav_thumbs_padding"
								)
							),
							'span' => array(
								$t => __("Span/Full-Width", 'revsliderhelp'),
								$h => "nav.thumbs.spanWrapper",
								$k => array("thumbs span", "thumbs wrapper", "thumbs wrapper span", "thumbs full width", "thumbs full-width"),
								$d => __("Choose if the wrapper should be displayed as a block or an inline-block", 'revsliderhelp'),
								$a => $u . "navigation-thumbnails/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.thumbs.set', $v => true, $o => 'nav_thumbs')
									),
									$m => "#module_navigation_trigger, #gst_nav_5", 
									$st => '#form_nav_thumbs_wrap', 
									$f => "#sr_thumbspan"
								)
							)
						),
						'visibility' => array(
							'rtl' => array(
								$t => __("Right to Left", 'revsliderhelp'),
								$h => "nav.thumbs.rtl",
								$k => array("rtl", "right to left", "right-to-left"),
								$d => __("Use RTL language alignment for the Arrow positioning", 'revsliderhelp'),
								$a => $u . "navigation-thumbnails/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.thumbs.set', $v => true, $o => 'nav_thumbs')
									),
									$m => "#module_navigation_trigger, #gst_nav_5", 
									$st => '#form_nav_thumbs_visi', 
									$f => "#sr_thumbsrtl"
								)
							),
							'animation' => array(
								$t => __("Thumbs Animation", 'revsliderhelp'),
								$h => "nav.thumbs.anim",
								$k => array("thumbs animation", "bullet animation", "show thumbs", "hide thumbs", "navigation animation"),
								$d => __("Optionally animate the thumbs into and out of view when the slider first loads and on mouse hover", 'revsliderhelp'),
								$a => $u . "navigation-thumbs/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.thumbs.set', $v => true, $o => 'nav_thumbs')
									),
									$m => "#module_navigation_trigger, #gst_nav_5", 
									$st => '#form_nav_thumbs_visi', 
									$f => "#sr_thumbs_animation"
								)
							),
							'show_speed' => array(
								$t => __("Thumbs Animation Speed", 'revsliderhelp'),
								$h => "nav.thumbs.animSpeed",
								$k => array("thumbs visibility", "show speed", "navigation speed"),
								$d => __("The animation speed for when the Thumbs animate into and out of view", 'revsliderhelp'),
								$a => $u . "navigation-thumbs/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.thumbs.set', $v => true, $o => 'nav_thumbs')
									),
									$m => "#module_navigation_trigger, #gst_nav_5", 
									$st => '#form_nav_thumbs_visi', 
									$f => "#nav_thumb_animSpeed"
								)
							),
							'show_delay' => array(
								$t => __("Thumbs Show Delay", 'revsliderhelp'),
								$h => "nav.thumbs.animDelay",
								$k => array("thumbs visibility", "navigation delay"),
								$d => __("A delay in milliseconds before the Thumbs animate into view", 'revsliderhelp'),
								$a => $u . "navigation-thumbs/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.thumbs.set', $v => true, $o => 'nav_thumbs')
									),
									$m => "#module_navigation_trigger, #gst_nav_5", 
									$st => '#form_nav_thumbs_visi', 
									$f => "#nav_thumb_animDelay"
								)
							),
							'hide_after' => array(
								$di => "nav_hideafter",
								$t => __("Hide After", 'revsliderhelp'),
								$h => "nav.thumbs.alwaysOn",
								$k => array("thumbs visibility", "hide after"),
								$d => __("Auto-hide the thumbs after a set amount of time (will be shown again when the user hovers/taps the Slider)", 'revsliderhelp'),
								$a => $u . "navigation-thumbnails/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.thumbs.set', $v => true, $o => 'nav_thumbs')
									),
									$m => "#module_navigation_trigger, #gst_nav_5", 
									$st => '#form_nav_thumbs_visi', 
									$f => "#sr_thumbsalwshow"
								)
							),
							'hide_after_desktop' => array(
								$t => __("Hide After: Desktop", 'revsliderhelp'),
								$h => "nav.thumbs.hideDelay",
								$k => array("thumbs visibility", "hide after", "hide after desktop"),
								$d => __("The amount of the time before the Thumbnails are hidden on Desktop computers (in milliseconds)", 'revsliderhelp'),
								$a => $u . "navigation-thumbnails/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.thumbs.set', $v => true, $o => 'nav_thumbs'),
										array($p => 'settings.nav.thumbs.alwaysOn', $v => true, $o => 'nav_hideafter')
									),
									$m => "#module_navigation_trigger, #gst_nav_5", 
									$st => '#form_nav_thumbs_visi', 
									$f => "#nav_thumbs_hideDelay"
								)
							),
							'hide_after_mobile' => array(
								$t => __("Hide After: Mobile", 'revsliderhelp'),
								$h => "nav.thumbs.hideDelayMobile",
								$k => array("thumbs visibility", "hide after", "hide after desktop"),
								$d => __("The amount of the time before the Thumbnails are hidden on mobile devices (in milliseconds)", 'revsliderhelp'),
								$a => $u . "navigation-thumbnails/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.thumbs.set', $v => true, $o => 'nav_thumbs'),
										array($p => 'settings.nav.thumbs.alwaysOn', $v => true, $o => 'nav_hideafter')
									),
									$m => "#module_navigation_trigger, #gst_nav_5", 
									$st => '#form_nav_thumbs_visi', 
									$f => "#nav_thumbs_hideDelayMobile"
								)
							),
							'hide_under' => array(
								$di => "nav_hideunder",
								$t => __("Hide Under", 'revsliderhelp'),
								$h => "nav.thumbs.hideUnder",
								$k => array("thumbs visibility", "hide under", "hide under width"),
								$d => __("Hide the Thumbnails when the browser window is equal to or below a certain number", 'revsliderhelp'),
								$a => $u . "navigation-thumbnails/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.thumbs.set', $v => true, $o => 'nav_thumbs')
									),
									$m => "#module_navigation_trigger, #gst_nav_5", 
									$st => '#form_nav_thumbs_visi', 
									$f => "#sr_thumbshideunder"
								)
							),
							'hide_under_limit' => array(
								$t => __("Hide Under Limit", 'revsliderhelp'),
								$h => "nav.thumbs.hideUnderLimit",
								$k => array("thumbs visibility", "hide under", "hide under limit"),
								$d => __("Hide the Thumbnails when the browser window is equal to or below this number", 'revsliderhelp'),
								$a => $u . "navigation-thumbnails/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.thumbs.set', $v => true, $o => 'nav_thumbs'),
										array($p => 'settings.nav.thumbs.hideUnder', $v => true, $o => 'nav_hideunder')
									),
									$m => "#module_navigation_trigger, #gst_nav_5", 
									$st => '#form_nav_thumbs_visi', 
									$f => "#nav_thumbs_hideunderlimit"
								)
							),
							'hide_over' => array(
								$di => "nav_hideover",
								$t => __("Hide Over", 'revsliderhelp'),
								$h => "nav.thumbs.hideOver",
								$k => array("thumbs visibility", "hide over", "hide over limit"),
								$d => __("Hide the Thumbnails when the browser window is equal to or above a certain number", 'revsliderhelp'),
								$a => $u . "navigation-thumbnails/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.thumbs.set', $v => true, $o => 'nav_thumbs')
									),
									$m => "#module_navigation_trigger, #gst_nav_5", 
									$st => '#form_nav_thumbs_visi', 
									$f => "#sr_thumbshideover"
								)
							),
							'hide_over_limit' => array(
								$t => __("Hide Over Limit", 'revsliderhelp'),
								$h => "nav.thumbs.hideOverLimit",
								$k => array("thumbs visibility", "hide over", "hide over limit"),
								$d => __("Hide the Thumbnails when the browser window is equal to or above this number", 'revsliderhelp'),
								$a => $u . "navigation-thumbnails/",
								$hl => array(
									$dp => array(
										array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard'),
										array($p => 'settings.nav.thumbs.set', $v => true, $o => 'nav_thumbs'),
										array($p => 'settings.nav.thumbs.hideOver', $v => true, $o => 'nav_hideover')
									),
									$m => "#module_navigation_trigger, #gst_nav_5", 
									$st => '#form_nav_thumbs_visi', 
									$f => "#nav_thumbs_hideoverlimit"
								)
							)
						)
					),
					'gst_nav_6' => array(
						'width' => array(
							$t => __("Preview Image Width", 'revsliderhelp'),
							$h => "nav.preview.width",
							$k => array("preview image", "prev image", "preview image width", "prev image width"),
							$d => __("The width of the navigation preview image", 'revsliderhelp'),
							$a => $u . "navigation-thumbnails/",
							$hl => array(
								$dp => array(array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard')),
								$m => "#module_navigation_trigger, #gst_nav_6", 
								$st => '#form_nav_pprevima', 
								$f => "#nav_prev_width"
							)
						),
						'height' => array(
							$t => __("Preview Image Height", 'revsliderhelp'),
							$h => "nav.preview.height",
							$k => array("preview image", "prev image", "preview image height", "prev image height"),
							$d => __("The height of the navigation preview image", 'revsliderhelp'),
							$a => $u . "navigation-thumbnails/",
							$hl => array(
								$dp => array(array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard')),
								$m => "#module_navigation_trigger, #gst_nav_6", 
								$st => '#form_nav_pprevima', 
								$f => "#nav_prev_height"
							)
						)
					),
					'gst_nav_7' => array(
						'enable' => array(
							$t => __("Enable Touch Swipe", 'revsliderhelp'),
							$h => "nav.swipe.set",
							$k => array("touch", "touch swipe", "swipe", "mobile"),
							$d => __("Enable touch swiping to navigate to the previous/next slides", 'revsliderhelp'),
							$a => $u . "touch-swipe/",
							$hl => array(
								$dp => array(array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard')),
								$m => "#module_navigation_trigger, #gst_nav_7", 
								$st => '#form_nav_touch', 
								$f => "#sr_usetouch"
							)
						),
						'enable_desktop' => array(
							$t => __("Enable Touch Swipe for Desktop", 'revsliderhelp'),
							$h => "nav.swipe.setOnDesktop",
							$k => array("touch", "touch swipe", "swipe", "desktop", "touch desktop", "touch swipe desktop"),
							$d => __("Enable touch swiping on Desktop computers to navigate to the previous/next slides", 'revsliderhelp'),
							$a => $u . "touch-swipe/",
							$hl => array(
								$dp => array(array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard')),
								$m => "#module_navigation_trigger, #gst_nav_7", 
								$st => '#form_nav_touch', 
								$f => "#sr_usetouchdesktop"
							)
						),
						'drag_block_vertical' => array(
							$t => __("Drag Block Vertical", 'revsliderhelp'),
							$h => "nav.swipe.blockDragVertical",
							$k => array("drag", "drag block", "drag block vertical"),
							$d => __("Choose if the page and its contents should be scrolled when swiping vertically", 'revsliderhelp'),
							$a => $u . "touch-swipe/",
							$hl => array(
								$dp => array(array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard')),
								$m => "#module_navigation_trigger, #gst_nav_7", 
								$st => '#form_nav_touch', 
								$f => "#sr_blockDragVertical"
							)
						),
						'velocity' => array(
							$t => __("Swipe Velocity", 'revsliderhelp'),
							$h => "nav.swipe.velocity",
							$k => array("velocity", "swipe", "touch swipe", "swipe velocity", "swipe sensitivity", "touch sensitivity"),
							$d => __("The amount of pixels that need to be swiped before a Slide change occurs", 'revsliderhelp'),
							$a => $u . "touch-swipe/",
							$hl => array(
								$dp => array(array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard')),
								$m => "#module_navigation_trigger, #gst_nav_7", 
								$st => '#form_nav_touch', 
								$f => "#nav_swipe_velocity"
							)
						),
						'min_touch' => array(
							$t => __("Min. Fingers", 'revsliderhelp'),
							$h => "nav.swipe.minTouch",
							$k => array("min finger", "min fingers", "swipe", "touch", "touch swipe", "minimum finger", "minimum fingers"),
							$d => __("The number of fingers needed in the swipe action for a Slide change to occur", 'revsliderhelp'),
							$a => $u . "touch-swipe/",
							$hl => array(
								$dp => array(array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard')),
								$m => "#module_navigation_trigger, #gst_nav_7", 
								$st => '#form_nav_touch', 
								$f => "#nav_swipe_minTouch"
							)
						),
						'orientation' => array(
							$t => __("Swipe Orientation", 'revsliderhelp'),
							$h => "nav.swipe.direction",
							$k => array("orientation", "swipe orientation", "swipe direction", "touch direction"),
							$d => __("The swipe direction that will trigger a Slide change", 'revsliderhelp'),
							$a => $u . "touch-swipe/",
							$hl => array(
								$dp => array(array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard')),
								$m => "#module_navigation_trigger, #gst_nav_7", 
								$st => '#form_nav_touch', 
								$f => "*[name='sr_swipedirection'][value='horizontal']"
							)
						)
					),
					'gst_nav_8' => array(
						'enable' => array(
							$t => __("Enable Keyboard Navigation", 'revsliderhelp'),
							$h => "nav.keyboard.set",
							$k => array("keyboard", "key", "left key", "right key", "up key", "down key"),
							$d => __("Enable left/right/up/down keys to control the Slider", 'revsliderhelp'),
							$a => $u . "keyboard-arrows-mouse-wheel/",
							$hl => array(
								$dp => array(array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard')),
								$m => "#module_navigation_trigger, #gst_nav_8", 
								$st => '#form_nav_misc', 
								$f => "#sr_usekeyboard"
							)
						),
						'direction' => array(
							$t => __("Key Arrow Direction", 'revsliderhelp'),
							$h => "nav.keyboard.direction",
							$k => array("keyboard", "key", "left key", "right key", "up key", "down key"),
							$d => __("Choose to use left/right keys or up/down keys to change Slides", 'revsliderhelp'),
							$a => $u . "keyboard-arrows-mouse-wheel/",
							$hl => array(
								$dp => array(array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard')),
								$m => "#module_navigation_trigger, #gst_nav_8", 
								$st => '#form_nav_misc', 
								$f => "*[name='sr_keyboarddirection'][value='horizontal']"
							)
						)
					),
					'gst_nav_9' => array(
						'enable' => array(
							$t => __("Enable Mouse Scroll", 'revsliderhelp'),
							$h => "nav.mouse.set",
							$k => array("mouse scroll", "scroll", "mouse", "mouse wheel", "wheel"),
							$d => __("Enable mouse scrolling to control Slide changes", 'revsliderhelp'),
							$a => $u . "keyboard-arrows-mouse-wheel/",
							$hl => array(
								$dp => array(array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard')),
								$m => "#module_navigation_trigger, #gst_nav_9", 
								$st => '#form_nav_mousescroll', 
								$f => "*[name='sr_mousenavigation'][value='on']"
							)
						),
						'reverse' => array(
							$t => __("Reverse Scroll", 'revsliderhelp'),
							$h => "nav.mouse.reverse",
							$k => array("mouse scroll", "scroll", "mouse", "direction", "reverse", "reverse scroll", "wheel", "mouse wheel"),
							$d => __("Choose which direction the mouse wheel should be scrolled to change Slides", 'revsliderhelp'),
							$a => $u . "keyboard-arrows-mouse-wheel/",
							$hl => array(
								$dp => array(array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard')),
								$m => "#module_navigation_trigger, #gst_nav_9", 
								$st => '#form_nav_mousescroll', 
								$f => "*[name='sr_reversemousenavigation'][value='reverse']"
							)
						),
						'target' => array(
							$t => __("Scroll Target", 'revsliderhelp'),
							$h => "nav.mouse.target",
							$k => array("mouse scroll", "scroll", "mouse", "scroll target", "target"),
							$d => __("Choose the page target object which scrolls in your theme so its scroll position can be animated while snapping", 'revsliderhelp'),
							$a => $u . "keyboard-arrows-mouse-wheel/",
							$hl => array(
								$dp => array(array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard')),
								$m => "#module_navigation_trigger, #gst_nav_9", 
								$st => '#form_nav_mousescroll', 
								$f => "*[name='sr_targetmousenavigation']"
							)
						),
						'threshold' => array(
							$t => __("Snap Threshold", 'revsliderhelp'),
							$h => "nav.mouse.threshold",
							$k => array("mouse scroll", "scroll", "mouse", "scroll snap", "snap threshold"),
							$d => __("Sets the threshold within which slider will snap into position while scrolling, threshold is calculated based on slider's distance from top and bottom", 'revsliderhelp'),
							$a => $u . "keyboard-arrows-mouse-wheel/",
							$hl => array(
								$dp => array(array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard')),
								$m => "#module_navigation_trigger, #gst_nav_9", 
								$st => '#form_nav_mousescroll', 
								$f => "#wheelsnapthreshold"
							)
						),
						'viewport' => array(
							$t => __("In ViewPort (%)", 'revsliderhelp'),
							$h => "nav.mouse.viewport",
							$k => array("mouse scroll", "scroll", "mouse", "scroll viewport"),
							$d => __("Determines how much % of slider should be visible when slider should change slide on scroll", 'revsliderhelp'),
							$a => $u . "keyboard-arrows-mouse-wheel/",
							$hl => array(
								$dp => array(array($p => 'settings.type', $v => 'standard::carousel', $o => 'slider_layout_type_standard')),
								$m => "#module_navigation_trigger, #gst_nav_9", 
								$st => '#form_nav_mousescroll', 
								$f => "#wheelifvisible"
							)
						)
					)
				),
				'slide_settings' => array(
					'gst_slide_1' => array(
						'type' => array(
							$di => "slide_bg_type",
							$t => __("Main Slide Background", 'revsliderhelp'),
							$h => "bg.type", 
							$k => array("slide", "slide settings", "background", "bg", "image", "image background"),
							$d => __("Set the Slide's Main background to a color, image or video", 'revsliderhelp'),
							$a => $u . "slide-background/",
							$hl => array($m => "#module_slide_trigger, #gst_slide_1", $st => '#form_slidebg_source', $f => "#slide_bg_type")
						),
						'color' => array(
							$t => __("Slide Background Color", 'revsliderhelp'),
							$h => "bg.color", 		
							$k => array("slide", "slide settings", "background", "bg", "image", "images", "bg color", "background color"),
							$d => __("Set the Slide's Main background to a color, image or video", 'revsliderhelp'),
							$a => $u . "slide-background/",
							$hl => array(
								$dp => array(array($p => '#slide#.slide.bg.type', $v => 'solid', $o => 'slide_bg_type')),
								$m => "#module_slide_trigger, #gst_slide_1", 
								$st => '#form_slidebg_source', 
								$f => "#s_bg_color"
							)
						),
						'external_url' => array(
							$t => __("External Image URL", 'revsliderhelp'),
							$h => "bg.externalSrc", 		
							$k => array("slide", "slide settings", "background", "bg", "image", "images", "slide background", "image background"),
							$d => __("An image url to be used as the Slide's main background image", 'revsliderhelp'),
							$a => $u . "slide-background/",
							$hl => array(
								$dp => array(array($p => '#slide#.slide.bg.type', $v => 'external', $o => 'slide_bg_type')),
								$m => "#module_slide_trigger, #gst_slide_1", 
								$st => '#form_slidebg_source', 
								$f => "#s_ext_src"
							)
						),
						'image_background' => array(
							'image_from_stream' => array(
								$t => __("Image from Stream", 'revsliderhelp'),
								$h => "bg.imageFromStream",
								$k => array("stream", "stream background", "poster", "youtube poster", "vimeo poster", "video poster"),
								$d => __("The Slide's main background will be populated automatically for Video/Social-Stream Sliders", 'revsliderhelp'),
								$a => $u . "slide-background/#image",
								$hl => array(
									$dp => array(array($p => '#slide#.slide.bg.type', $v => 'image::external::youtube::vimeo::html5', $o => 'slide_bg_type')),
									$m => "#module_slide_trigger, #gst_slide_1", 
									$st => '#form_slidebg_source', 
									$f => "*[data-r='bg.imageFromStream']"
								)
							),
							'source_size' => array(
								$t => __("Source Size", 'revsliderhelp'),
								$h => "bg.imageSourceType",
								$k => array("background image", "slide image", "bg image"),
								$d => __("The size of the image that will be loaded, defined by WP Main Menu -> Settings -> Media -> Image Sizes", 'revsliderhelp'),
								$a => $u . "slide-background/#image",
								$hl => array(
									$dp => array(array($p => '#slide#.slide.bg.type', $v => 'image', $o => 'slide_bg_type')),
									$m => "#module_slide_trigger, #gst_slide_1", 
									$st => '#form_slidebg_ssettings', 
									$f => "#slide_bg_img_ssize"
								)
							),
							'bg_fit' => array(
								$t => __("Background Fit", 'revsliderhelp'),
								$h => "bg.fit",
								$k => array("background image", "slide image", "bg image", "bg size", "background size", "bg fit", "background fit"),
								$d => __("The <a href='https://www.w3schools.com/cssref/css3_pr_background-size.asp' target='_blank'>CSS background-size</a> for the Slide's main background image", 'revsliderhelp'),
								$a => $u . "slide-background/#image",
								$hl => array(
									$dp => array(array($p => '#slide#.slide.bg.type', $v => 'image::external', $o => 'slide_bg_type')),
									$m => "#module_slide_trigger, #gst_slide_1", 
									$st => '#form_slidebg_ssettings', 
									$f => "*[name='slide_bg_fit'][value='cover']"
								)
							),
							'bg_repeat' => array(
								$t => __("Background Repeat", 'revsliderhelp'),
								$h => "bg.repeat",
								$k => array("background image", "slide image", "bg image", "bg repeat", "background repeat"),
								$d => __("The <a href='https://www.w3schools.com/cssref/pr_background-repeat.asp' target='_blank'>CSS background-fit</a> for the Slide's main background image", 'revsliderhelp'),
								$a => $u . "slide-background/#image",
								$hl => array(
									$dp => array(array($p => '#slide#.slide.bg.type', $v => 'image::external', $o => 'slide_bg_type')),
									$m => "#module_slide_trigger, #gst_slide_1", 
									$st => '#form_slidebg_ssettings', 
									$f => "#slide_bg_repeat"
								)
							),
							'bg_position' => array(
								$t => __("Background Position", 'revsliderhelp'),
								$h => "bg.position",
								$k => array("background image", "slide image", "bg image", "bg position", "background position"),
								$d => __("The <a href='https://www.w3schools.com/cssref/pr_background-position.asp' target='_blank'>CSS background-position</a> for the Slide's main background image", 'revsliderhelp'),
								$a => $u . "slide-background/#image",
								$hl => array(
									$dp => array(array($p => '#slide#.slide.bg.type', $v => 'image::external', $o => 'slide_bg_type')),
									$m => "#module_slide_trigger, #gst_slide_1", 
									$st => '#form_slidebg_ssettings', 
									$f => "#slide_bg_position_center-center"
								)
							),
							'parallax_3d' => array(
								$t => __("Parallax Level", 'revsliderhelp'),
								$h => "effects.parallax",
								$k => array("parallax", "parallax level", "background parallax bg image parallax", "bg parallax"),
								$d => __("The movement strength that will be applied to the Slide's main background image", 'revsliderhelp'),
								$a => $u . "slide-background/",
								$hl => array(
									$dp => array(array($p => 'settings.parallax.set', $v => true, $o => 'slider_parallax')),
									$m => "#module_slide_trigger, #gst_slide_1", 
									$st => '#form_slidebg_pddd', 
									$f => "#slide_parallax_level"
								)
							),
							'attributes' => array(
								'alt_attr' => array(
									$di => "slide_attributes_alt",
									$t => __("Alt Attribute", 'revsliderhelp'),
									$h => "attributes.altOption",
									$k => array("background image alt", "alt attribute", "bg alt", "image alt"),
									$d => __("Define the 'alt' attribute for the Slide's main background image.  Useful for SEO purposes.", 'revsliderhelp'),
									$a => $u . "slide-background/#image",
									$hl => array(
										$dp => array(array($p => '#slide#.slide.bg.type', $v => 'image::external', $o => 'slide_bg_type')),
										$m => "#module_slide_trigger, #gst_slide_1", 
										$st => '#form_slidebg_ssettings', 
										$f => "#slide_bg_image_alt"
									)
								),
								'alt_custom' => array(
									$t => __("Custom Alt Attribute", 'revsliderhelp'),
									$h => "attributes.alt",
									$k => array("background image alt", "alt attribute", "bg alt", "image alt"),
									$d => __("Enter custom alternative text for the Slide's main background image.  Useful for SEO purposes.", 'revsliderhelp'),
									$a => $u . "slide-background/#image",
									$hl => array(
										$dp => array(
											array($p => '#slide#.slide.bg.type', $v => 'image::external', $o => 'slide_bg_type'),
											array($p => '#slide#.slide.attributes.altOption', $v => 'custom', $o => 'slide_attributes_alt')
										),
										$m => "#module_slide_trigger, #gst_slide_1", 
										$st => '#form_slidebg_ssettings', 
										$f => "#slide_bg_img_calt"
									)
								),
								'title_attr' => array(
									$di => "slide_attributes_title",
									$t => __("Title Attribute", 'revsliderhelp'),
									$h => "attributes.titleOption",
									$k => array("background image title", "alt attribute", "bg title", "image title"),
									$d => __("Define the 'title' attribute for the Slide's main background image.  Useful for screen readers.", 'revsliderhelp'),
									$a => $u . "slide-background/#image",
									$hl => array(
										$dp => array(array($p => '#slide#.slide.bg.type', $v => 'image::external', $o => 'slide_bg_type')),
										$m => "#module_slide_trigger, #gst_slide_1", 
										$st => '#form_slidebg_ssettings', 
										$f => "#slide_bg_image_title"
									)
								),
								'title_custom' => array(
									$t => __("Custom Title Attribute", 'revsliderhelp'),
									$h => "attributes.title",
									$k => array("background image title", "title attribute", "bg title", "image title"),
									$d => __("Enter a custom title for the Slide's main background image.  Useful for screen readers.", 'revsliderhelp'),
									$a => $u . "slide-background/#image",
									$hl => array(
										$dp => array(
											array($p => '#slide#.slide.bg.type', $v => 'image::external', $o => 'slide_bg_type'),
											array($p => '#slide#.slide.attributes.titleOption', $v => 'custom', $o => 'slide_attributes_title')
										),
										$m => "#module_slide_trigger, #gst_slide_1", 
										$st => '#form_slidebg_ssettings', 
										$f => "#slide_bg_img_ctit"
									)
								)
							),
							'external_image' => array(
								'external_width' => array(
									$t => __("External Image Width", 'revsliderhelp'),
									$h => "bg.width",
									$k => array("background image width", "external image width", "external image"),
									$d => __("Define a custom width attribute for external image urls", 'revsliderhelp'),
									$a => $u . "slide-background/#image",
									$hl => array(
										$dp => array(array($p => '#slide#.slide.bg.type', $v => 'external', $o => 'slide_bg_type')),
										$m => "#module_slide_trigger, #gst_slide_1", 
										$st => '#form_slidebg_ssettings', 
										$f => "#slide_bg_width"
									)
								),
								'external_height' => array(
									$t => __("External Image Height", 'revsliderhelp'),
									$h => "bg.height",
									$k => array("background image height", "external image height", "external image"),
									$d => __("Define a custom height attribute for external image urls", 'revsliderhelp'),
									$a => $u . "slide-background/#image",
									$hl => array(
										$dp => array(array($p => '#slide#.slide.bg.type', $v => 'external', $o => 'slide_bg_type')),
										$m => "#module_slide_trigger, #gst_slide_1", 
										$st => '#form_slidebg_ssettings', 
										$f => "#slide_bg_height"
									)
								)
							)
						),
						'video_background' => array(
							'youtube_id' => array(
								$t => __("YouTube Video ID", 'revsliderhelp'),
								$h => "bg.youtube",
								$k => array("youtube video", "youtube video background", "video background", "video bg", "youtube", "youtube id"),
								$d => __("The <a href='https://www.quora.com/What-is-a-YouTube-video-ID' target=_'blank'>YouTube Video ID</a> for the background video", 'revsliderhelp'),
								$a => $u . "slide-background/#video",
								$hl => array(
									$dp => array(array($p => '#slide#.slide.bg.type', $v => 'youtube', $o => 'slide_bg_type')),
									$m => "#module_slide_trigger, #gst_slide_1", 
									$st => '#form_slidebg_source', 
									$f => "#s_bg_youtube_src"
								)
							),
							'vimeo_id' => array(
								$t => __("Vimeo Video ID", 'revsliderhelp'),
								$h => "bg.vimeo",
								$k => array("vimeo video", "vimeo video background", "video background", "video bg", "vimeo", "vimeo id"),
								$d => __("The <a href='https://docs.joeworkman.net/rapidweaver/stacks/vimeo/video-id' target=_'blank'>Vimeo Video ID</a> for the background video", 'revsliderhelp'),
								$a => $u . "slide-background/#video",
								$hl => array(
									$dp => array(array($p => '#slide#.slide.bg.type', $v => 'vimeo', $o => 'slide_bg_type')),
									$m => "#module_slide_trigger, #gst_slide_1", 
									$st => '#form_slidebg_source', 
									$f => "#s_bg_vimeo_src"
								)
							),
							'html5_url' => array(
								$t => __("HTML Video URL", 'revsliderhelp'),
								$h => "bg.mpeg",
								$k => array("html5 video", "video url", "html5 video url", "html5 source", "html5 video source"),
								$d => __("The video url to be used as the Slide's main background", 'revsliderhelp'),
								$a => $u . "slide-background/#video",
								$hl => array(
									$dp => array(array($p => '#slide#.slide.bg.type', $v => 'html5', $o => 'slide_bg_type')),
									$m => "#module_slide_trigger, #gst_slide_1", 
									$st => '#form_slidebg_source', 
									$f => "#s_bg_mpeg_src"
								)
							),
							'image_from_stream' => array(
								$t => __("Image/Poster from Stream", 'revsliderhelp'),
								$h => "bg.imageFromStream",
								$k => array("stream", "stream background", "poster", "youtube poster", "vimeo poster", "video poster"),
								$d => __("The Slide's main background will be populated automatically for Video/Social-Stream Sliders", 'revsliderhelp'),
								$a => $u . "slide-background/#video",
								$hl => array(
									$dp => array(array($p => '#slide#.slide.bg.type', $v => 'image::external::youtube::vimeo::html5', $o => 'slide_bg_type')),
									$m => "#module_slide_trigger, #gst_slide_1", 
									$st => '#form_slidebg_source', 
									$f => "*[data-r='bg.imageFromStream']"
								)
							),
							'video_from_stream' => array(
								$t => __("Video from Stream", 'revsliderhelp'),
								$h => "bg.videoFromStream",
								$k => array("stream", "stream background", "video stream"),
								$d => __("The Slide's main background will be populated automatically for Video-Stream Sliders", 'revsliderhelp'),
								$a => $u . "slide-background/#video",
								$hl => array(
									$dp => array(array($p => '#slide#.slide.bg.type', $v => 'youtube::vimeo::html5', $o => 'slide_bg_type')),
									$m => "#module_slide_trigger, #gst_slide_1", 
									$st => '#form_slidebg_source', 
									$f => "*[data-r='bg.videoFromStream']"
								)
							),
							'additional_settings' => array(
								'aspect_ratio' => array(
									$t => __("Aspect Ratio", 'revsliderhelp'),
									$h => "bg.video.ratio",
									$k => array("aspect ratio", "video size", "video aspect ratio"),
									$d => __("This value should match the video's original aspect ratio", 'revsliderhelp'),
									$a => $u . "slide-background/#video-settings",
									$hl => array(
										$dp => array(array($p => '#slide#.slide.bg.type', $v => 'youtube::vimeo::html5', $o => 'slide_bg_type')),
										$m => "#module_slide_trigger, #gst_slide_1", 
										$st => '#form_slidebg_ssettings', 
										$f => "#slide_vid_aratio"
									)
								),
								'dotted_overlay' => array(
									$t => __("Dotted Overlay", 'revsliderhelp'),
									$h => "bg.video.dottedOverlay",
									$k => array("overlay", "video overlay", "dotted overlay"),
									$d => __("Add a mesh-style overlay to the video for extra styling", 'revsliderhelp'),
									$a => $u . "slide-background/#video-settings",
									$hl => array(
										$dp => array(array($p => '#slide#.slide.bg.type', $v => 'youtube::vimeo::html5', $o => 'slide_bg_type')),
										$m => "#module_slide_trigger, #gst_slide_1", 
										$st => '#form_slidebg_ssettings', 
										$f => "#sl_vid_overlay"
									)
								),
								'loop' => array(
									$t => __("Loop Video", 'revsliderhelp'),
									$h => "bg.video.loop",
									$k => array("loop", "video loop", "restart", "restart video"),
									$d => __("Restart the video every time it ends", 'revsliderhelp'),
									$a => $u . "slide-background/#video-settings",
									$hl => array(
										$dp => array(array($p => '#slide#.slide.bg.type', $v => 'youtube::vimeo::html5', $o => 'slide_bg_type')),
										$m => "#module_slide_trigger, #gst_slide_1", 
										$st => '#form_slidebg_ssettings', 
										$f => "#slide_vid_loop"
									)
								),
								'fitCover' => array(
									$t => __("Video Fit Cover", 'revsliderhelp'),
									$h => "bg.video.fitCover",
									$k => array("cover", "force cover"),
									$d => __("Video will fit in container with CSS property object-fit cover. Disable this option in case video size jumps on slide change.", 'revsliderhelp'),
									$a => $u . "slide-background/#video-settings",
									$hl => array(
										$dp => array(array($p => '#slide#.slide.bg.type', $v => 'html5', $o => 'slide_bg_type')),
										$m => "#module_slide_trigger, #gst_slide_1", 
										$st => '#form_slidebg_ssettings', 
										$f => "#sl_vid_fit_cover"
									)
								),
								
								'next_slide_at_end' => array(
									$t => __("Next Slide at End", 'revsliderhelp'),
									$h => "bg.video.nextSlideAtEnd",
									$k => array("next slide at end", "next slide end"),
									$d => __("Change to the next Slide when the video ends", 'revsliderhelp'),
									$a => $u . "slide-background/#video-settings",
									$hl => array(
										$dp => array(array($p => '#slide#.slide.bg.type', $v => 'youtube::vimeo::html5', $o => 'slide_bg_type')),
										$m => "#module_slide_trigger, #gst_slide_1", 
										$st => '#form_slidebg_ssettings', 
										$f => "#sl_vid_nextslide"
									)
								),
								'rewind_at_start' => array(
									$t => __("Rewind at Start", 'revsliderhelp'),
									$h => "bg.video.forceRewind",
									$k => array("rewind", "rewind at start"),
									$d => __("Always play the video from the beginning each time the Slide is shown", 'revsliderhelp'),
									$a => $u . "slide-background/#video-settings",
									$hl => array(
										$dp => array(array($p => '#slide#.slide.bg.type', $v => 'youtube::vimeo::html5', $o => 'slide_bg_type')),
										$m => "#module_slide_trigger, #gst_slide_1", 
										$st => '#form_slidebg_ssettings', 
										$f => "#sl_vid_forceRewind"
									)
								),
								'mute_at_start' => array(
									$t => __("Mute at Start", 'revsliderhelp'),
									$h => "bg.video.mute",
									$k => array("mute video", "mute at start"),
									$d => __("Auto-mute the video each time the Slide is shown", 'revsliderhelp'),
									$a => $u . "slide-background/#video-settings",
									$hl => array(
										$dp => array(array($p => '#slide#.slide.bg.type', $v => 'youtube::vimeo::html5', $o => 'slide_bg_type')),
										$m => "#module_slide_trigger, #gst_slide_1", 
										$st => '#form_slidebg_ssettings', 
										$f => "#sl_vid_mute"
									)
								),
								'volume' => array(
									$t => __("Video Volume", 'revsliderhelp'),
									$h => "bg.video.volume",
									$k => array("video volume"),
									$d => __("Set the default volume for the video", 'revsliderhelp'),
									$a => $u . "slide-background/#video-settings",
									$hl => array(
										$dp => array(array($p => '#slide#.slide.bg.type', $v => 'youtube::vimeo', $o => 'slide_bg_type')),
										$m => "#module_slide_trigger, #gst_slide_1", 
										$st => '#form_slidebg_ssettings', 
										$f => "#slide_vid_vol"
									)
								),
								'speed' => array(
									$t => __("Video Speed", 'revsliderhelp'),
									$h => "bg.video.speed",
									$k => array("video speed"),
									$d => __("Optional playback speed for the video", 'revsliderhelp'),
									$a => $u . "slide-background/#video-settings",
									$hl => array(
										$dp => array(array($p => '#slide#.slide.bg.type', $v => 'youtube::vimeo', $o => 'slide_bg_type')),
										$m => "#module_slide_trigger, #gst_slide_1", 
										$st => '#form_slidebg_ssettings', 
										$f => "#slide_vid_speed"
									)
								),
								'start_at' => array(
									$t => __("Start Time", 'revsliderhelp'),
									$h => "bg.video.startAt",
									$k => array("video start", "video start time", "start at", "video start at"),
									$d => __("Start the video at this time (minutes:seconds, such as 01:30)", 'revsliderhelp'),
									$a => $u . "slide-background/#video-settings",
									$hl => array(
										$dp => array(array($p => '#slide#.slide.bg.type', $v => 'youtube::vimeo::html5', $o => 'slide_bg_type')),
										$m => "#module_slide_trigger, #gst_slide_1", 
										$st => '#form_slidebg_ssettings', 
										$f => "#slide_vid_startat"
									)
								),
								'end_at' => array(
									$t => __("End Time", 'revsliderhelp'),
									$h => "bg.video.endAt",
									$k => array("video end", "video end time", "end at", "video end at"),
									$d => __("End the video at this time (minutes:seconds, such as 01:30)", 'revsliderhelp'),
									$a => $u . "slide-background/#video-settings",
									$hl => array(
										$dp => array(array($p => '#slide#.slide.bg.type', $v => 'youtube::vimeo::html5', $o => 'slide_bg_type')),
										$m => "#module_slide_trigger, #gst_slide_1", 
										$st => '#form_slidebg_ssettings', 
										$f => "#slide_vid_endat"
									)
								),
								'arguments' => array(
									$t => __("YouTube/Vimeo Arguments", 'revsliderhelp'),
									$h => "bg.video.args, bg.video.argsVimeo",
									$k => array("youtube args", "youtube arguments", "vimeo args", "vimeo arguments"),
									$d => __("Optional iFrame arguments for <a href='https://developers.google.com/youtube/player_parameters' target='_blank'>YouTube</a> and <a href='https://help.vimeo.com/hc/en-us/articles/360001494447-Using-Player-Parameters' target='_blank'>Vimeo</a>", 'revsliderhelp'),
									$a => $u . "slide-background/#video-settings",
									$hl => array(
										$dp => array(array($p => '#slide#.slide.bg.type', $v => 'youtube::vimeo', $o => 'slide_bg_type')),
										$m => "#module_slide_trigger, #gst_slide_1", 
										$st => '#form_slidebg_ssettings', 
										$f => "#slide_vid_argsyt, #slide_vid_argvim"
									)
								)
							)
						)
					),
					'gst_slide_6' => array(
						'module_thumb' => array(
							$t => __("Module Admin Thumbnail", 'revsliderhelp'),
							$h => "#slide#.slide.thumb.customAdminThumbSrc",
							$k => array("thumbnail", "admin thumb", "admin thumbnail"),
							$d => __("Set a special thumbnail for editor admin purposes only", 'revsliderhelp'),
							$a => $u . "slide-thumbnails/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_6", 
								$st => '#form_slidegeneral_thumbnails', 
								$f => "*[data-r='#slide#.slide.thumb.customAdminThumbSrc']"
							)
						),
						'navigation_thumb' => array(
							$t => __("Navigation Thumbnail", 'revsliderhelp'),
							$h => "#slide#.slide.thumb.customThumbSrc",
							$k => array("thumbnail", "thumb", "navigation thumb", "navigation thumbnail", "nav thumb", "navigation thumb"),
							$d => __("The thumbnail image that will be used for the Slider's thumbnail navigation", 'revsliderhelp'),
							$a => $u . "slide-thumbnails/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_6", 
								$st => '#form_slidegeneral_thumbnails', 
								$f => "*[data-r='#slide#.slide.thumb.customThumbSrc']"
							)
						),
						'dimension' => array(
							$t => __("Dimension", 'revsliderhelp'),
							$h => "thumb.dimension",
							$k => array("thumbnail", "thumb", "navigation thumb", "navigation thumbnail", "nav thumb", "navigation thumb", "dimension", "thumb size", "thumbnail size"),
							$d => __("Load the images in their original size or in the size defined in the Slider Settings", 'revsliderhelp'),
							$a => $u . "slide-thumbnails/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_6", 
								$st => '#form_slidegeneral_thumbnails', 
								$f => "#slide_thumb_dimension"
							)
						)
					),
					'gst_slide_2' => array(
						'slide_transition' => array(
							$t => __("Slide Transition", 'revsliderhelp'),
							$h => "added_slide_transition",
							$k => array("slide", "slide settings", "slide animation", "slide transition", "animation", "transition"),
							$d => __("Represents the transition that will animate one slide's background out and the next slide's background in when switching sides.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2", 
								$st => '#form_slidebg_transition', 
								$f => ".added_slide_transition{first}"
							)
						),
						'favorit_transitions' => array(
							$t => __("Favorite Slide Transition", 'revsliderhelp'),
							$h => "slideChange.favorit",
							$k => array("slide", "slide settings", "slide animation", "slide transition", "animation", "transition", "favorit", "favorite", "favourite"),
							$d => __("ON: Show only favorited transitions. OFF: Show all available transitions", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2", 
								$st => '#sl_trans_favorit', 
								$f => "#sl_trans_favorit_inp"
							)
						),
						'slide_transition_timing' => array(
							$t => __("Slide Transition Timing", 'revsliderhelp'),
							$h => "#slide_transsettings",
							$k => array("slide transition", "slide animation", "animation timing", "transition timing"),
							$d => __("Configure the slide's transition animation timing settings such as 'Duration', 'Pause 'Between' behavior, 'Flow' and 'Index Order'", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slidebasic_ts_wrapbrtn > div", 
								$st => '#form_sanimation_sframes_innerwrap', 
								$f => "#slidebasic_ts_wrapbrtn"
							)
						),
						
						'duration' => array(
							$t => __("Transition Duration", 'revsliderhelp'),
							$h => "slideChange.speed",
							$k => array("slide transition", "slide animation", "animation duration", "transition duration", "animation time", "transition time"),
							$d => __("The total time, (in milliseconds), it takes to complete the slide's animation transition", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2,#slidebasic_ts_wrapbrtn > div", 
								$st => '#sltrans_all_globals', 
								$f => "#sltrans_duration"
							)
						),

						'adpr' => array(
							$t => __("Prioritize Performance", 'revsliderhelp'),
							$h => "slideChange.adpr",
							$k => array("slide transition", "slide animation", "animation performance", "animation blurry", "animation quality"),
							$d => __("Win performance in complex transitions by reducing the image quality during animations", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2", 
								$st => '#sltrans_all_globals', 
								$f => "#sltrans_dpr"
							)
						),

						'pause_between' => array(
							$t => __("Transition Break", 'revsliderhelp'),
							$h => "slideChange.p",
							$k => array("slide transition", "slide animation", "animation pause", "transition pause", "through dark", "through light"),
							$d => __("Add a pause between slides. When active, this option animates an exiting slide out to a dark/light/transparent background, pauses for a moment, then animates the next slide in. Note: Pausing has no effect on the very first animation of a slider.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2,#slidebasic_ts_wrapbrtn > div", 
								$st => '#sltrans_all_globals', 
								$f => "#sltrans_breaking"
							)
						),

						'transition_flow' => array(
							$t => __("Transition Flow", 'revsliderhelp'),
							$h => "slideChange.f",
							$k => array("slide transition", "slide animation", "animation flow", "transition flow"),
							$d => __("If using a 'Rows', 'Columns' or 'Boxes' transition, this option controls animation direction and timing for all the separate elements, generating a flow effect as each one moves. It defines the direction in which initial movement of elements should be staggered, and which element should be animated first & last, e.g. starting from the center or edges, changing based on slide direction, flowing randomly etc.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2,#slidebasic_ts_wrapbrtn > div", 
								$st => '#sltrans_all_globals', 
								$f => "#sltrans_from"
							)
						),

						'transition_flow_speed' => array(
							$t => __("Transition Flow Speed", 'revsliderhelp'),
							$h => "slideChange.d",
							$k => array("slide transition", "slide animation", "animation flow speed", "transition flow speed"),
							$d => __("If using a 'Rows', 'Columns' or 'Boxes' transition, this option controls the animation speed of each individual element. Increasing the number, up to a maximum of 100, makes elements move quicker and reduces the time until each begins moving. The minimum, and slowest, setting is 5. Changing this value also automatically recalculates the slide transition duration.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2,#slidebasic_ts_wrapbrtn > div", 
								$st => '#sltrans_all_globals', 
								$f => "#sltrans_fromdelay"
							)
						),

						'transition_index_order' => array(
							$t => __("Transition Order", 'revsliderhelp'),
							$h => "slideChange.o",
							$k => array("slide transition", "slide animation", "animation index order", "transition order"),
							$d => __("Define whether the slide transitioning in should appear over the slide going out, or if the slide going out should appear over the one coming in. If set to Auto, a selection will be inferred automatically based on other settings.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2,#slidebasic_ts_wrapbrtn > div", 
								$st => '#sltrans_all_globals', 
								$f => "#sltrans_order"
							)
						),
						'transition_in_mask' => array(
							$t => __("Transition Mask", 'revsliderhelp'),
							$h => "slideChange.in.m",
							$k => array("slide transition", "slide animation mask", "animation mask", "transition mask"),
							$d => __("On animated rows and columns, activating the transition mask does two things: 1) Makes the motion of elements start at the edge of their own row/column rather than the edge of their full container. 2) Ensures elements don't overlap one another.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slidein_ts_wrapbrtn > div", 
								$st => '#sltrans_all_globals', 
								$f => "#sltrans_in_mask_wrap"
							)
						),

						'transition_motion' => array(
							$t => __("Transition Motion Blur", 'revsliderhelp'),
							$h => "slideChange.in.mou",
							$k => array("slide transition", "slide animation blur", "animation motion blur", "transition blur", "motion blur"),
							$d => __("Add a light motion blur effect to slide transition animations. Enabling this setting will update other values as well.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slidein_ts_wrapbrtn > div", 
								$st => '#sltrans_all_globals', 
								$f => "#sltrans_in_motionswitch_wrap"
							)
						),

						'transition_motion_blur' => array(
							$t => __("Transition Motion Blur Val", 'revsliderhelp'),
							$h => "slideChange.in.mo",
							$k => array("slide transition", "slide animation blur", "animation motion blur", "transition blur", "motion blur"),
							$d => __("If 'Transition Motion Blur' is on, the 'Transition Motion Blur Val' determines the width of the blur effect in pixels", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slidein_ts_wrapbrtn > div", 
								$st => '#sltrans_all_globals', 
								$f => "#sltrans_filter_motion"
							)
						),

						'easing_in' => array(
							$t => __("Animation 'In' Easing", 'revsliderhelp'),
							$h => "slideChange.in.e",
							$k => array("slide transition", "slide animation", "animation easing", "transition easing"),
							$d => __("The easing equation for the 'In' animation, i.e. how the animation speeds up and slows down during playback.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slidein_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#sltrans_in_ease"
							)
						),
						
						'cols_in' => array(
							$t => __("Animation 'In'  Columns / Boxes", 'revsliderhelp'),
							$h => "slideChange.in.col",
							$k => array("slide transition", "slide animation", "animation columns", "transition colums", "slots", "boxes", "columns"),
							$d => __("If using a 'Columns' or 'Boxes' transition, this option specifies the number of vertical columns into which the animation should be split.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slidein_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#sltrans_in_col"
							)
						),

						'rows_in' => array(
							$t => __("Animation 'In'  Rows / Boxes", 'revsliderhelp'),
							$h => "slideChange.in.row",
							$k => array("slide transition", "slide animation", "animation columns", "transition colums", "slots", "boxes", "columns"),
							$d => __("If using a 'Rows' or 'Boxes' transition, this option specifies the number of horizontal rows into which the animation should be split.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slidein_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#sltrans_in_col"
							)
						),
						'xtrans_in' => array(
							$t => __("Animation 'In' - Horizontal Move", 'revsliderhelp'),
							$h => "slideChange.in.x",
							$k => array("slide transition", "slide animation", "animation transform", "transition horizontal"),
							$d => __("Optionally add horizontal motion to elements in Columns/Rows/Boxes transitions. Accepts three possible formats denoting either random, cycles or direction based movement. 1) Random: {min,max} Applies a random amount of movement within a specified range. E.g, {-45,45} to slide in by an amount between -45% and 45% of the element's width. 2) Cycles: [val,val,val] Cycles through applying specified movement amounts sequentially from one element to the next, in the order determined by the 'Flow' setting. E.g. [-10,10,25] will apply a -10% motion to the first element, 10% to the next, then 25%, then the sequence repeats. 3) Direction Based: (val) e.g. (45) to add 45% motion when going to the next slide, and -45% when going to the previous slide.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slidein_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#sltrans_in_x"
							)
						),
						'ytrans_in' => array(
							$t => __("Animation 'In' - Vertical Move", 'revsliderhelp'),
							$h => "slideChange.in.y",
							$k => array("slide transition", "slide animation", "animation transform", "transition horizontal"),
							$d => __("Optionally add vertical motion to elements in Columns/Rows/Boxes transitions. Accepts three possible formats denoting either random, cycles or direction based movement. 1) Random: {min,max} Applies a random amount of movement within a specified range. E.g, {-45,45} to slide in by an amount between -45% and 45% of the element's height. 2) Cycles: [val,val,val] Cycles through applying specified movement amounts sequentially from one element to the next, in the order determined by the 'Flow' setting. E.g. [-10,10,25] will apply a -10% motion to the first element, 10% to the next, then 25%, then the sequence repeats. 3) Direction Based: (val) e.g. (45) to add 45% motion when going to the next slide, and -45% when going to the previous slide.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slidein_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#sltrans_in_y"
							)
						),
						'xscale_in' => array(
							$t => __("Animation 'In' - Horizontal Scale", 'revsliderhelp'),
							$h => "slideChange.in.sx",
							$k => array("slide transition", "slide animation", "animation transform", "transition horizontal","slide scale", "transition scale", "scale"),
							$d => __("Optionally add horizontal scaling (growth or shrinking) to elements in Columns/Rows/Boxes transitions. Accepts three possible formats denoting either fixed, random or cycles based scaling. 1) Fixed: (val) A single value between 0 and 500. A value of 1 has no effect, < 1 scales down (shrinks), and > 1 scales up (grows). 2) Random: {min,max} Applies a random amount of horizontal scaling within a specified range. E.g, {0,2.5} will randomly generate scaling on each element of between 0% and 250%. 3) Cycles: [val,val,val] Cycles through applying specified horizontal scaling amounts sequentially from one element to the next, in the order determined by the 'Flow' setting. E.g. [0,1.5,0.2] will apply a 0% scaling to the first element, 150% to the next, then 20%, then the sequence repeats.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slidein_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#sltrans_in_scalex"
							)
						),
						'yscale_in' => array(
							$t => __("Animation 'In'  - Vertical Scale", 'revsliderhelp'),
							$h => "slideChange.in.sy",
							$k => array("slide transition", "slide animation", "animation transform", "transition horizontal", "slide scale", "transition scale", "scale"),
							$d => __("Optionally add vertical scaling (growth or shrinking) to elements in Columns/Rows/Boxes transitions. Accepts three possible formats denoting either fixed, random or cycles based scaling. 1) Fixed: (val) A single value between 0 and 500. A value of 1 has no effect, < 1 scales down (shrinks), and > 1 scales up (grows). 2) Random: {min,max} Applies a random amount of vertical scaling within a specified range. E.g, {0,2.5} will randomly generate scaling on each element of between 0% and 250%. 3) Cycles: [val,val,val] Cycles through applying specified vertical scaling amounts sequentially from one element to the next, in the order determined by the 'Flow' setting. E.g. [0,1.5,0.2] will apply a 0% scaling to the first element, 150% to the next, then 20%, then the sequence repeats.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slidein_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#sltrans_in_scaley"
							)
						),
						'opactiy_in' => array(
							$t => __("Animation 'In' - Transparency", 'revsliderhelp'),
							$h => "slideChange.in.o",
							$k => array("slide transition", "slide animation", "animation transparency"),
							$d => __("The standard input range is 0 to 1, where 0 is completely transparent and 1 is fully opaque. In most cases you should use a value between 0 and 1, however, if necessary you can reduce the value down as far as -3, which will allow you to time the opacity animation differently than the 'In’ animation. The lower the value, the longer the transparency animation will be delayed compared to the rest of the ’In’ animation. This can be helpful in harmonizing complex animations.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slidein_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#sltrans_in_fade"
							)							
						),
						'rotation_in' => array(
							$t => __("Animation 'In' - Rotation", 'revsliderhelp'),
							$h => "slideChange.in.r",
							$k => array("slide transition", "slide animation", "animation rotation", "transition rotation"),
							$d => __("Optionally add rotation to elements in Columns/Rows/Boxes transitions. Accepts three possible formats denoting either random, cycles or direction based rotation. 1) Random: {min,max} Applies a random amount of rotation within a specified range. E.g, {-45,45} to rotate by an amount between -45 and 45 degrees. 2) Cycles: [val,val,val] Cycles through applying specified movement amounts sequentially from one element to the next, in the order determined by the 'Flow' setting. E.g. [-10,10,25] will apply a -10 degree rotation to the first element, 10 degrees to the next, then 25 degrees, then the sequence repeats. 3) Direction Based: (val) e.g. (45) to add a 45 degree rotation when going to the next slide, and -45 degree rotation when going to the previous slide.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slidein_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#sltrans_in_rotation"
							)
						),
						'transition_out_mask' => array(
							$t => __("Transition Mask", 'revsliderhelp'),
							$h => "slideChange.out.m",
							$k => array("slide transition", "slide animation mask", "animation mask", "transition mask"),
							$d => __("On animated rows and columns, activating the transition mask does two things: 1) Makes the motion of elements start at the edge of their own row/column rather than the edge of their full container. 2) Ensures elements don't overlap one another.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slideout_ts_wrapbrtn > div", 
								$st => '#sltrans_all_globals', 
								$f => "#sltrans_out_mask_wrap"
							)
						),

						'auto_out' => array(
							$t => __("Animation 'Out' Automatically", 'revsliderhelp'),
							$h => "slideChange.out.a",
							$k => array("slide transition", "slide animation", "animation out", "transition auto", "auto animation", "auto transition"),
							$d => __("When toggled to ON this option will automatically generate the best possible 'Out' animation, based on the settings of the 'In' animation. ", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slideout_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#slidechangeouta"
							)
						),

						'easing_out' => array(
							$t => __("Animation 'Out' Easing", 'revsliderhelp'),
							$h => "slideChange.out.e",
							$k => array("slide transition", "slide animation", "animation easing", "transition easing"),
							$d => __("The easing equation for the 'Out' animation, i.e. how the animation speeds up and slows down during playback.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slideout_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#sltrans_out_ease"
							)
						),
						
						'cols_out' => array(
							$t => __("Animation 'Out'  Columns / Boxes", 'revsliderhelp'),
							$h => "slideChange.out.col",
							$k => array("slide transition", "slide animation", "animation columns", "transition colums", "slots", "boxes", "columns"),
							$d => __("If using a 'Columns' or 'Boxes' transition, this option specifies the number of vertical columns into which the animation should be split.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slideout_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#sltrans_in_col"
							)
						),

						'rows_out' => array(
							$t => __("Animation 'Out'  Rows / Boxes", 'revsliderhelp'),
							$h => "slideChange.out.row",
							$k => array("slide transition", "slide animation", "animation columns", "transition colums", "slots", "boxes", "columns"),
							$d => __("If using a 'Rows' or 'Boxes' transition, this option specifies the number of horizontal rows into which the animation should be split.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slideout_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#sltrans_out_col"
							)
						),
						'xtrans_out' => array(
							$t => __("Animation 'Out' - Horizontal Move", 'revsliderhelp'),
							$h => "slideChange.out.x",
							$k => array("slide transition", "slide animation", "animation transform", "transition horizontal"),
							$d => __("Optionally add horizontal motion to elements in Columns/Rows/Boxes transitions. Accepts three possible formats denoting either random, cycles or direction based movement. 1) Random: {min,max} Applies a random amount of movement within a specified range. E.g, {-45,45} to slide in by an amount between -45% and 45% of the element's width. 2) Cycles: [val,val,val] Cycles through applying specified movement amounts sequentially from one element to the next, in the order determined by the 'Flow' setting. E.g. [-10,10,25] will apply a -10% motion to the first element, 10% to the next, then 25%, then the sequence repeats. 3) Direction Based: (val) e.g. (45) to add 45% motion when going to the next slide, and -45% when going to the previous slide.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slideout_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#sltrans_out_x"
							)
						),
						'ytrans_out' => array(
							$t => __("Animation 'Out' - Vertical Move", 'revsliderhelp'),
							$h => "slideChange.out.y",
							$k => array("slide transition", "slide animation", "animation transform", "transition horizontal"),
							$d => __("Optionally add vertical motion to elements in Columns/Rows/Boxes transitions. Accepts three possible formats denoting either random, cycles or direction based movement. 1) Random: {min,max} Applies a random amount of movement within a specified range. E.g, {-45,45} to slide in by an amount between -45% and 45% of the element's height. 2) Cycles: [val,val,val] Cycles through applying specified movement amounts sequentially from one element to the next, in the order determined by the 'Flow' setting. E.g. [-10,10,25] will apply a -10% motion to the first element, 10% to the next, then 25%, then the sequence repeats. 3) Direction Based: (val) e.g. (45) to add 45% motion when going to the next slide, and -45% when going to the previous slide.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slideout_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#sltrans_out_y"
							)
						),
						'xscale_out' => array(
							$t => __("Animation 'Out' - Horizontal Scale", 'revsliderhelp'),
							$h => "slideChange.out.sx",
							$k => array("slide transition", "slide animation", "animation transform", "transition horizontal","slide scale", "transition scale", "scale"),
							$d => __("Optionally add horizontal scaling (growth or shrinking) to elements in Columns/Rows/Boxes transitions. Accepts three possible formats denoting either fixed, random or cycles based scaling. 1) Fixed: (val) A single value between 0 and 500. A value of 1 has no effect, < 1 scales down (shrinks), and > 1 scales up (grows). 2) Random: {min,max} Applies a random amount of horizontal scaling within a specified range. E.g, {0,2.5} will randomly generate scaling on each element of between 0% and 250%. 3) Cycles: [val,val,val] Cycles through applying specified horizontal scaling amounts sequentially from one element to the next, in the order determined by the 'Flow' setting. E.g. [0,1.5,0.2] will apply a 0% scaling to the first element, 150% to the next, then 20%, then the sequence repeats.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slideout_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#sltrans_out_scalex"
							)
						),
						'yscale_out' => array(
							$t => __("Animation 'Out' - Vertical Scale", 'revsliderhelp'),
							$h => "slideChange.out.sy",
							$k => array("slide transition", "slide animation", "animation transform", "transition horizontal", "slide scale", "transition scale", "scale"),
							$d => __("Optionally add vertical scaling (growth or shrinking) to elements in Columns/Rows/Boxes transitions. Accepts three possible formats denoting either fixed, random or cycles based scaling. 1) Fixed: (val) A single value between 0 and 500. A value of 1 has no effect, < 1 scales down (shrinks), and > 1 scales up (grows). 2) Random: {min,max} Applies a random amount of vertical scaling within a specified range. E.g, {0,2.5} will randomly generate scaling on each element of between 0% and 250%. 3) Cycles: [val,val,val] Cycles through applying specified vertical scaling amounts sequentially from one element to the next, in the order determined by the 'Flow' setting. E.g. [0,1.5,0.2] will apply a 0% scaling to the first element, 150% to the next, then 20%, then the sequence repeats.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slideout_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#sltrans_out_scaley"
							)
						),
						'opactiy_out' => array(
							$t => __("Animation 'Out' - Transparency", 'revsliderhelp'),
							$h => "slideChange.out.o",
							$k => array("slide transition", "slide animation", "animation transform", "transition horizontal"),
							$d => __("The standard input range is 0 to 1, where 0 is completely transparent and 1 is fully opaque. In most cases you should use a value between 0 and 1, however, if necessary you can reduce the value down as far as -3, which will allow you to time the opacity animation differently than the 'Out’ animation. The lower the value, the quicker the transparency animation will be compared to the rest of the ‘Out’ animation. This can be helpful in harmonizing complex animations.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slideout_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#sltrans_out_fade"
							)							
						),
						'rotation_out' => array(
							$t => __("Animation 'Out' - Rotation", 'revsliderhelp'),
							$h => "slideChange.out.r",
							$k => array("slide transition", "slide animation", "animation rotation", "transition rotation"),
							$d => __("Optionally add rotation to elements in Columns/Rows/Boxes transitions. Accepts three possible formats denoting either random, cycles or direction based rotation. 1) Random: {min,max} Applies a random amount of rotation within a specified range. E.g, {-45,45} to rotate by an amount between -45 and 45 degrees. 2) Cycles: [val,val,val] Cycles through applying specified movement amounts sequentially from one element to the next, in the order determined by the 'Flow' setting. E.g. [-10,10,25] will apply a -10 degree rotation to the first element, 10 degrees to the next, then 25 degrees, then the sequence repeats. 3) Direction Based: (val) e.g. (45) to add a 45 degree rotation when going to the next slide, and -45 degree rotation when going to the previous slide.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slideout_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#sltrans_out_rotation"
							)
						),

						'allfilters' => array(
							$t => __("Slide Animation Filters", 'revsliderhelp'),
							$h => "slideChange.filter.u",
							$k => array("slide transition", "slide animation", "animation filters", "filters"),
							$d => __("Enable or disable filter effects on slide transition animations ", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slidefilter_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#slidechangefilteru"
							)
						),
						'easing_filter' => array(
							$t => __("Filter Animation Easing", 'revsliderhelp'),
							$h => "slideChange.filter.e",
							$k => array("slide transition", "slide animation", "animation filter easing", "transition filter easing"),
							$d => __("Set the easing amount for any filter effect animations to help you correctly time them with the rest of the transition.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slidefilter_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#sltrans_filter_ease"
							)
						),

						'blur_filter' => array(
							$t => __("Slider Transition Blur Filter", 'revsliderhelp'),
							$h => "slideChange.filter.b",
							$k => array("slide transition", "slide animation", "animation filter blur", "transition filter blur", "blur"),
							$d => __("Apply a blur filter effect during the slide transition animation. This option sets the width of the blur in pixels, with a value of 0 representing no blur.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slidefilter_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#slidechangefilterb"
							)
						),
						'grayscale_filter' => array(
							$t => __("Slider Transition Grayscale Filter", 'revsliderhelp'),
							$h => "slideChange.filter.g",
							$k => array("slide transition", "slide animation", "animation filter grayscale", "transition filter grayscale", "grayscale"),
							$d => __("Apply a grayscale filter effect that reduces color during the slide transition animation. The minimum value is 0, which represents full color, and the maximum value is 100, which represents entirely black and white.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slidefilter_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#slidechangefilterg"
							)
						),
						'sephia_filter' => array(
							$t => __("Slider Transition Sepia Filter", 'revsliderhelp'),
							$h => "slideChange.filter.s",
							$k => array("slide transition", "slide animation", "animation filter sephia", "transition filter sephia", "sephia", "sepia", "animation filter sepia", "transition filter sepia"),
							$d => __("Apply a sepia color filter effect during the slide transition animation. The minimum value is 0, which represents full color, and the maximum value is 100, which represents full sepia.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slidefilter_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#slidechangefilters"
							)
						),
						'brightness_filter' => array(
							$t => __("Slider Transition Brightness Filter", 'revsliderhelp'),
							$h => "slideChange.filter.h",
							$k => array("slide transition", "slide animation", "animation filter brightness", "transition filter brightness", "brightness"),
							$d => __("Apply a brightness filter effect during the slide transition animation. A value of 100% represents normal brightness. Any value higher than 100% increases brightness, while values lower than 100% decrease brightness.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slidefilter_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#slidechangefilterh"
							)
						),
						'contrast_filter' => array(
							$t => __("Slider Transition Contrast Filter", 'revsliderhelp'),
							$h => "slideChange.filter.c",
							$k => array("slide transition", "slide animation", "animation filter contrast", "transition filter contrast", "contrast"),
							$d => __("Apply a contrast filter effect during the slide transition animation. The maximum value is 100, which represents normal contrast, and values 99 or lower reduce contrast, down to a minimum of 0.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slidefilter_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#slidechangefilterc"
							)
						),
						'invert_filter' => array(
							$t => __("Slider Transition Invert Filter", 'revsliderhelp'),
							$h => "slideChange.filter.i",
							$k => array("slide transition", "slide animation", "animation filter invert", "transition filter invert", "contrast"),
							$d => __("Apply a color inversion filter effect during the slide transition animation. The minimum value is 0, which represents normal color, and the maximum value is 100, which represents completely inverted color.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slidefilter_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#slidechangefilteri"
							)
						),
						
						
						
						'ddd_effect' => array(
							$t => __("Slider Transition 3D Effect", 'revsliderhelp'),
							$h => "slideChange.d3.f",
							$k => array("slide transition", "slide animation", "animation 3d effect", "3d effect", "3d"),
							$d => __("Apply a 3D effect to the entire slide during the transition animation. Available effects are: 'Cube', 'In Cube', 'Fly Out Throw In', and 'Clap Out Clap In'", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slide3d_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#sltrans_3d_effect"
							)
						),

						'ddd_direction' => array(
							$t => __("3D Effect Direction", 'revsliderhelp'),
							$h => "slideChange.d3.d",
							$k => array("slide transition", "slide animation", "animation 3d effect", "3d effect", "3d"),
							$d => __("Choose whether the 3D effect animation should move in a horizontal or vertical direction", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slide3d_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#sltrans_3d_dir"
							)
						),

						'ddd_ease' => array(
							$t => __("3D Effect Ease", 'revsliderhelp'),
							$h => "slideChange.d3.e",
							$k => array("slide transition", "slide animation", "animation 3d effect", "3d effect", "3d"),
							$d => __("The easing equation for the 3D effect animation, i.e. how the animation speeds up and slows down during playback", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slide3d_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#sltrans_3d_ease"
							)
						),

						'ddd_slidecolor' => array(
							$t => __("3D Effect Side Color", 'revsliderhelp'),
							$h => "slideChange.d3.c",
							$k => array("slide transition", "slide animation", "animation 3d effect", "3d effect", "3d"),
							$d => __("When using the 3D animated 'Cube' or 'In Cube' 3D effect, this option sets the color of any visible side of the animated cube that isn't already covered by slide content.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slide3d_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#s_wall_bg_color"
							)
						),

						'ddd_depth' => array(
							$t => __("3D Effect Depth", 'revsliderhelp'),
							$h => "slideChange.d3.z",
							$k => array("slide transition", "slide animation", "animation 3d effect", "3d effect", "3d"),
							$d => __("This option defines how much depth a 3D animated effect appears to have. Increasing the value make the far side of the effect look further away.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slide3d_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#slidechangedddz"
							)
						),

						'ddd_room' => array(
							$t => __("3D Effect Room Rotation", 'revsliderhelp'),
							$h => "slideChange.d3.t",
							$k => array("slide transition", "slide animation", "animation 3d effect", "3d effect", "3d"),
							$d => __("Adds rotation on an additional axis when using a 3D animation effect, i.e. if '3D Effect Direction' is set to horizontal this option will also add vertical rotation, and vice versa. Either positive or negative values can be used in order to create rotation in one direction or the other.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slide3d_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#slidechangedddroom"
							)
						),

						'ddd_flyrotation' => array(
							$t => __("Fly Out Throw In Z Rotation", 'revsliderhelp'),
							$h => "slideChange.d3.fz",
							$k => array("slide transition", "slide animation", "animation 3d effect", "3d effect", "3d"),
							$d => __("When using the 'Fly Out Throw In' 3D effect animation, this option controls rotation of the slide on the Z axis. In other words, setting either a positive or negative value can make the slide look like it's rolling or swinging in from the side.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slide3d_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#sltrans_3d_fdz"
							)
						),

						'ddd_flyout' => array(
							$t => __("Fly Out Distance", 'revsliderhelp'),
							$h => "slideChange.d3.fdo",
							$k => array("slide transition", "slide animation", "animation 3d effect", "3d effect", "3d"),
							$d => __("When using the 'Fly Out Throw In' 3D effect animation, this option controls the distance by which the slide will appear to 'fly out' of the container. At a value of 1 the slide will move a distance equal to 100% of its own width / height. At 2 it moves a distance twice its own size, at 0.5 the distance will be half its own size, and so on.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slide3d_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#sltrans_3d_fdo"
							)
						),

						'ddd_flyin' => array(
							$t => __("Throw In Distance", 'revsliderhelp'),
							$h => "slideChange.d3.fdi",
							$k => array("slide transition", "slide animation", "animation 3d effect", "3d effect", "3d"),
							$d => __("When using the 'Fly Out Throw In' 3D effect animation, this option controls the distance by which the slide will appear to 'throw in' from outside the container. At a value of 1 the slide will move a distance equal to 100% of its own width / height. At 2 it moves a distance twice its own size, at 0.5 the distance will be half its own size, and so on.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slide3d_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#sltrans_3d_fzi"
							)
						),

						'ddd_shadowuse' => array(
							$t => __("3D Shadow", 'revsliderhelp'),
							$h => "slideChange.d3.su",
							$k => array("slide transition", "slide animation", "animation 3d effect", "3d effect", "3d", "shadow"),
							$d => __("Toggle a shadow effect on 3D transition animations. The shadow appears as a gradient that runs across the face of the slider while its moving, and helps enhance the feeling of depth.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slide3d_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#sl_ddd_shadow_u"
							)
						),

						'ddd_shadowmin' => array(
							$t => __("3D Shadow Minimum Strength", 'revsliderhelp'),
							$h => "slideChange.d3.smi",
							$k => array("slide transition", "slide animation", "animation 3d effect", "3d effect", "3d", "shadow"),
							$d => __("The minimum strength of the 3D animation's shadow at its lightest point. Can be set between 0 and 0.5.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slide3d_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#sl_ddd_shadow_min"
							)
						),

						'ddd_shadowmax' => array(
							$t => __("3D Shadow Maximum Strength", 'revsliderhelp'),
							$h => "slideChange.d3.sma",
							$k => array("slide transition", "slide animation", "animation 3d effect", "3d effect", "3d", "shadow"),
							$d => __("The maximum strength of the 3D animation's shadow at its darkest point. Can be set between 0.5 and 1.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slide3d_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#sl_ddd_shadow_max"
							)
						),

						'ddd_shadowlimit' => array(
							$t => __("3D Shadow Limitation", 'revsliderhelp'),
							$h => "slideChange.d3.sl",
							$k => array("slide transition", "slide animation", "animation 3d effect", "3d effect", "3d", "shadow"),
							$d => __("The limit on the distance between minimum and maximum strength points in the shadow. A value of 1 creates a gradient across the full slide, 0.5 creates gradient across 50% of the slide, and so on.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slide3d_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#sl_ddd_shadow_limit"
							)
						),

						'ddd_shadowcolor' => array(
							$t => __("3D Shadow Color", 'revsliderhelp'),
							$h => "slideChange.d3.sc",
							$k => array("slide transition", "slide animation", "animation 3d effect", "3d effect", "3d", "shadow"),
							$d => __("The color of the 3D shadow effect.", 'revsliderhelp'),
							$a => $u . "slide-animation/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_2, #slide3d_ts_wrapbrtn > div", 
								$st => '#form_slidebg_transition', 
								$f => "#slide_shadow_color"
							)
						)
					),
					'gst_slide_5' => array(
						'bg_filter' => array(
							$t => __("Background Image Filter", 'revsliderhelp'),
							$h => "bg.mediaFilter",
							$k => array("filter", "filters", "image filter", "image filters", "bg filter", "bg filters", "background filter", "background filters", "instagram"),
							$d => __("An Instagram-type filter to apply to the Slide's main background image", 'revsliderhelp'),
							$a => $u . "slide-filters/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_5", 
								$st => '#form_slidebg_filters_int', 
								$f => "#slide_bg_filter"
							)
						)
					),
					'gst_slide_8' => array(
						'slide_length' => array(
							$t => __("Slide Time/Length", 'revsliderhelp'),
							$h => "timeline.delay",
							$k => array("slide", "slide settings", "slide time", "slide timeline", "slide length", "progress", "slide progress", "timeline"),
							$d => __("The Slide's total duration before the next Slide is shown", 'revsliderhelp'),
							$a => $u . "slide-progress/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_8", 
								$st => '#form_slidegeneral_timing', 
								$f => "#slide_length"
							)
						),
						'pause_slider' => array(
							$t => __("Pause Slider", 'revsliderhelp'),
							$h => "timeline.stopOnPurpose",
							$k => array("pause slider", "pause slide", "pause", "stop", "stop slider", "stop progress"),
							$d => __("Pause the Slider from changing Slides when this Slide is shown", 'revsliderhelp'),
							$a => $u . "slide-progress/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_8", 
								$st => '#form_slidegeneral_timing', 
								$f => "#slide_time_stopOnPurpose"
							)
						),
						'visibility' => array(
							'visible_in_navigation' => array(
								$t => __("Visible in Navigation", 'revsliderhelp'),
								$h => "visibility.hideFromNavigation",
								$k => array("visibility", "visible in navigation", "hidden in navigation", "slide visibility"),
								$d => __("Show the Slide in the Slider's main navigation, or make the Slide 'hidden' so it can only be shown from a Layer Action click", 'revsliderhelp'),
								$a => $u . "slide-progress/",
								$hl => array(
									$m => "#module_slide_trigger, #gst_slide_8", 
									$st => '#form_slidegeneral_visibility', 
									$f => "#slide_visibil_hideFromNavigation"
								)
							),
							'hide_after_loop' => array(
								$t => __("Hide After Loop", 'revsliderhelp'),
								$h => "visibility.hideAfterLoop",
								$k => array("visibility", "slide visibility", "hide after loop", "hide slide"),
								$d => __("Remove the Slide from the Slide stack after a set amount of loops", 'revsliderhelp'),
								$a => $u . "slide-progress/",
								$hl => array(
									$m => "#module_slide_trigger, #gst_slide_8", 
									$st => '#form_slidegeneral_visibility', 
									$f => "#slide_vis_loop"
								)
							),
							'hide_on_mobile' => array(
								$t => __("Hide on Mobile", 'revsliderhelp'),
								$h => "visibility.hideOnMobile",
								$k => array("visibility", "slide visibility", "hide on mobile", "hide slide", "hide slide on mobile"),
								$d => __("Hide the Slide on mobile devices"),
								$a => $u . "slide-progress/",
								$hl => array(
									$m => "#module_slide_trigger, #gst_slide_8", 
									$st => '#form_slidegeneral_visibility', 
									$f => "#sl_vis_hidemobile"
								)
							)
						)
					),
					'gst_slide_9' => array(
						'publish_status' => array(
							$t => __("Published Status", 'revsliderhelp'),
							$h => "publish.state",
							$k => array("slide", "slide settings", "publish", "publish slide", "unpublished"),
							$d => __("Choose the published state of the Slide.  Choose 'Unpublished' to work on the Slide in a draft status.", 'revsliderhelp'),
							$a => $u . "slide-publish-rules/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_9", 
								$st => '#form_slidegeneral_progstate', 
								$f => "#slide_publish_State"
							)
						),
						'publish_start' => array(
							$t => __("Publish Start Date", 'revsliderhelp'),
							$h => "publish.from",
							$k => array("publish", "publish slide", "unpublished", "publish from", "start date", "date", "starting date"),
							$d => __("Set a starting date for when the Slide should officially be included in the Slider", 'revsliderhelp'),
							$a => $u . "slide-publish-rules/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_9", 
								$st => '#form_slidegeneral_progstate', 
								$f => "#slide_pub_from"
							)
						),
						'publish_end' => array(
							$t => __("Publish End Date", 'revsliderhelp'),
							$h => "publish.to",
							$k => array("publish", "publish slide", "unpublished", "publish from", "end date", "date", "endingdate"),
							$d => __("Set an end date for when the Slide should officially be excluded from the Slider", 'revsliderhelp'),
							$a => $u . "slide-publish-rules/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_9", 
								$st => '#form_slidegeneral_progstate', 
								$f => "#slide_pub_until"
							)
						),
					),
					'gst_slide_4' => array(
						'html_tags' => array(
							'class' => array(
								$t => __("Slide Classes", 'revsliderhelp'),
								$h => "attributes.class",
								$k => array("slide class", "class", "class name"),
								$d => __("Add optional class names to the Slide to target the Slide with custom CSS or JavaScript", 'revsliderhelp'),
								$a => $u . "tags-link/",
								$hl => array(
									$m => "#module_slide_trigger, #gst_slide_4", 
									$st => '#form_slidegeneral_timing', 
									$f => "#slide_ls_class"
								)
							),
							'id' => array(
								$t => __("Slide ID", 'revsliderhelp'),
								$h => "attributes.id",
								$k => array("slide id", "slide id attribute", "id attribute"),
								$d => __("Add an optional ID to the Slide to target the Slide with custom CSS or JavaScript", 'revsliderhelp'),
								$a => $u . "tags-link/",
								$hl => array(
									$m => "#module_slide_trigger, #gst_slide_4", 
									$st => '#form_slidegeneral_timing', 
									$f => "#slide_ls_id"
								)
							),
							'data' => array(
								$t => __("Data Attributes", 'revsliderhelp'),
								$h => "attributes.data",
								$k => array("slide data", "slide data attribute", "slide data attributes", "data attribute", "data attributes"),
								$d => __("Optional data-attributes that can be added to the Slide to target it with custom CSS or JavaScript", 'revsliderhelp'),
								$a => $u . "tags-link/",
								$hl => array(
									$m => "#module_slide_trigger, #gst_slide_4", 
									$st => '#form_slidegeneral_timing', 
									$f => "#slide_ls_data"
								)
							)
						),
						'link_seo' => array(
							'enable' => array(
								$di => "slide_link_seo",
								$t => __("Enable Slide Link", 'revsliderhelp'),
								$h => "seo.set",
								$k => array("slide", "slide settings", "slide link", "link", "hyperlink", "slide hyperlink", "link slide"),
								$d => __("Add a link to the entire Slide area", 'revsliderhelp'),
								$a => $u . "tags-link/",
								$hl => array(
									$m => "#module_slide_trigger, #gst_slide_4", 
									$st => '#form_slidegeneral_linkseo', 
									$f => "#sl_seo_set"
								)
							),
							'type' => array(
								$di => "slide_link_seo_type",
								$t => __("Link Type", 'revsliderhelp'),
								$h => "seo.type",
								$k => array("slide link", "link", "hyperlink", "slide hyperlink", "link slide", "link to slide", "change slides"),
								$d => __("Choose a traditional link to the Slide to navigate to a new web page or another Slide", 'revsliderhelp'),
								$a => $u . "tags-link/",
								$hl => array(
									$dp => array(array($p => '#slide#.slide.seo.set', $v => true, $o => 'slide_link_seo')),
									$m => "#module_slide_trigger, #gst_slide_4", 
									$st => '#form_slidegeneral_linkseo', 
									$f => "#slide_seo_type"
								)
							),
							'url' => array(
								$t => __("Link URL", 'revsliderhelp'),
								$h => "seo.link",
								$k => array("slide link", "link", "hyperlink", "slide hyperlink", "link url", "url"),
								$d => __("The url to go to when the Slide is clicked", 'revsliderhelp'),
								$a => $u . "tags-link/",
								$hl => array(
									$dp => array(
										array($p => '#slide#.slide.seo.set', $v => true, $o => 'slide_link_seo'),
										array($p => '#slide#.slide.seo.type', $v => 'regular', $o => 'slide_link_seo_type'),
									),
									$m => "#module_slide_trigger, #gst_slide_4", 
									$st => '#form_slidegeneral_linkseo', 
									$f => "#slide_ls_link"
								)
							),
							'target' => array(
								$t => __("Link Target", 'revsliderhelp'),
								$h => "seo.target",
								$k => array("slide link", "link", "hyperlink", "slide hyperlink", "link url", "url", "link target"),
								$d => __("The <a href='https://www.w3schools.com/tags/att_link_target.asp' target='_blank'>target attribute</a> for the Slide link", 'revsliderhelp'),
								$a => $u . "tags-link/",
								$hl => array(
									$dp => array(
										array($p => '#slide#.slide.seo.set', $v => true, $o => 'slide_link_seo'),
										array($p => '#slide#.slide.seo.type', $v => 'regular', $o => 'slide_link_seo_type')
									),
									$m => "#module_slide_trigger, #gst_slide_4", 
									$st => '#form_slidegeneral_linkseo', 
									$f => "#slide_ls_link"
								)
							),
							'link_to_slide' => array(
								$t => __("Link to Slide", 'revsliderhelp'),
								$h => "seo.slideLink",
								$k => array("slide link", "link", "link to slide"),
								$d => __("Link to another Slide in the Slider", 'revsliderhelp'),
								$a => $u . "tags-link/",
								$hl => array(
									$dp => array(
										array($p => '#slide#.slide.seo.set', $v => true, $o => 'slide_link_seo'),
										array($p => '#slide#.slide.seo.type', $v => 'slide', $o => 'slide_link_seo_type')
									),
									$m => "#module_slide_trigger, #gst_slide_4", 
									$st => '#form_slidegeneral_linkseo', 
									$f => "#slide_seo_linktoslide"
								)
							),
							'link_zindex' => array(
								$t => __("Link Sensibility", 'revsliderhelp'),
								$h => "seo.z",
								$k => array("slide link", "link", "hyperlink", "slide hyperlink", "link to slide", "sensibility", "link z-index", "link zindex"),
								$d => __("Choose of the Slide link should be placed behind or above the Slide's Layer content", 'revsliderhelp'),
								$a => $u . "tags-link/",
								$hl => array(
									$dp => array(array($p => '#slide#.slide.seo.set', $v => true, $o => 'slide_link_seo')),
									$m => "#module_slide_trigger, #gst_slide_4", 
									$st => '#form_slidegeneral_linkseo', 
									$f => "#slide_seo_z"
								)
							)
						)
					),
					'gst_slide_3' => array(
						'enable' => array(
							$di => "slide_panzoom",
							$t => __("Enable PanZoom", 'revsliderhelp'),
							$h => "panzoom.set",
							$k => array("panzoom", "pan zoom"),
							$d => __("Enable the PanZoom effect by default for this Slide", 'revsliderhelp'),
							$a => $u . "pan-zoom/",
							$hl => array(
								$dp => array(array($p => '#slide#.slide.bg.type', $v => 'image::external', $o => 'slide_bg_type')),
								$m => "#module_slide_trigger, #gst_slide_3", 
								$st => '#form_slidebg_kenburn', 
								$f => "#sl_pz_set"
							)
						),
						'bg_position' => array(
							$t => __("Background Position", 'revsliderhelp'),
							$h => "bg.position",
							$k => array("pan zoom", "panzoom", "pan zoom position", "panzoom position"),
							$d => __("The <a href='https://www.w3schools.com/cssref/pr_background-position.asp' target='_blank'>CSS background-position</a> for the Slide's main background image", 'revsliderhelp'),
							$a => $u . "pan-zoom/",
							$hl => array(
								$dp => array(
									array($p => '#slide#.slide.bg.type', $v => 'image::external', $o => 'slide_bg_type'),
									array($p => '#slide#.slide.panzoom.set', $v => true, $o => 'slide_panzoom')
								),
								$m => "#module_slide_trigger, #gst_slide_3", 
								$st => '#form_slidebg_kenburn', 
								$f => "#slide_bg_position_center-center"
							)
						),
						'zoom' => array(
							'fit_start' => array(
								$t => __("Zoom Start Percentage", 'revsliderhelp'),
								$h => "panzoom.fitStart",
								$k => array("panzoom", "pan zoom", "zoom", "pan zoom zoom", "panzoom zoom"),
								$d => __("The starting zoom percentage", 'revsliderhelp'),
								$a => $u . "pan-zoom/",
								$hl => array(
									$dp => array(
										array($p => '#slide#.slide.bg.type', $v => 'image::external', $o => 'slide_bg_type'),
										array($p => '#slide#.slide.panzoom.set', $v => true, $o => 'slide_panzoom')
									),
									$m => "#module_slide_trigger, #gst_slide_3", 
									$st => '#form_slidebg_kenburn', 
									$f => "#sl_pz_fs"
								)
							),
							'fit_end' => array(
								$t => __("Zoom End Percentage", 'revsliderhelp'),
								$h => "panzoom.fitEnd",
								$k => array("panzoom", "pan zoom", "zoom", "pan zoom zoom", "panzoom zoom"),
								$d => __("The ending zoom percentage", 'revsliderhelp'),
								$a => $u . "pan-zoom/",
								$hl => array(
									$dp => array(
										array($p => '#slide#.slide.bg.type', $v => 'image::external', $o => 'slide_bg_type'),
										array($p => '#slide#.slide.panzoom.set', $v => true, $o => 'slide_panzoom')
									),
									$m => "#module_slide_trigger, #gst_slide_3", 
									$st => '#form_slidebg_kenburn', 
									$f => "#sl_pz_fe"
								)
							)
						),
						'movement' => array(
							'x_start' => array(
								$t => __("Start Position X", 'revsliderhelp'),
								$h => "panzoom.xStart",
								$k => array("panzoom", "pan zoom", "position", "pan zoom position", "panzoom position"),
								$d => __("The starting x position for the PanZoom movement", 'revsliderhelp'),
								$a => $u . "pan-zoom/",
								$hl => array(
									$dp => array(
										array($p => '#slide#.slide.bg.type', $v => 'image::external', $o => 'slide_bg_type'),
										array($p => '#slide#.slide.panzoom.set', $v => true, $o => 'slide_panzoom')
									),
									$m => "#module_slide_trigger, #gst_slide_3", 
									$st => '#form_slidebg_kenburn', 
									$f => "#sl_pz_xs"
								)
							),
							'x_end' => array(
								$t => __("End Position X", 'revsliderhelp'),
								$h => "panzoom.xEnd",
								$k => array("panzoom", "pan zoom", "position", "pan zoom position", "panzoom position"),
								$d => __("The end x position for the PanZoom movement", 'revsliderhelp'),
								$a => $u . "pan-zoom/",
								$hl => array(
									$dp => array(
										array($p => '#slide#.slide.bg.type', $v => 'image::external', $o => 'slide_bg_type'),
										array($p => '#slide#.slide.panzoom.set', $v => true, $o => 'slide_panzoom')
									),
									$m => "#module_slide_trigger, #gst_slide_3", 
									$st => '#form_slidebg_kenburn', 
									$f => "#sl_pz_xe"
								)
							),
							'y_start' => array(
								$t => __("Start Position Y", 'revsliderhelp'),
								$h => "panzoom.yStart",
								$k => array("panzoom", "pan zoom", "position", "pan zoom position", "panzoom position"),
								$d => __("The starting y position for the PanZoom movement", 'revsliderhelp'),
								$a => $u . "pan-zoom/",
								$hl => array(
									$dp => array(
										array($p => '#slide#.slide.bg.type', $v => 'image::external', $o => 'slide_bg_type'),
										array($p => '#slide#.slide.panzoom.set', $v => true, $o => 'slide_panzoom')
									),
									$m => "#module_slide_trigger, #gst_slide_3", 
									$st => '#form_slidebg_kenburn', 
									$f => "#sl_pz_ys"
								)
							),
							'y_end' => array(
								$t => __("End Position Y", 'revsliderhelp'),
								$h => "panzoom.yEnd",
								$k => array("panzoom", "pan zoom", "position", "pan zoom position", "panzoom position"),
								$d => __("The ending y position for the PanZoom movement", 'revsliderhelp'),
								$a => $u . "pan-zoom/",
								$hl => array(
									$dp => array(
										array($p => '#slide#.slide.bg.type', $v => 'image::external', $o => 'slide_bg_type'),
										array($p => '#slide#.slide.panzoom.set', $v => true, $o => 'slide_panzoom')
									),
									$m => "#module_slide_trigger, #gst_slide_3", 
									$st => '#form_slidebg_kenburn', 
									$f => "#sl_pz_ye"
								)
							)
						),
						'rotation_blur' => array(
							'rotate_start' => array(
								$t => __("Rotate Start", 'revsliderhelp'),
								$h => "panzoom.rotateStart",
								$k => array("panzoom", "pan zoom", "rotate", "pan zoom rotate", "panzoom rotate", "rotation", "pan zoom rotation"),
								$d => __("The starting rotation for the PanZoom effect (deg)", 'revsliderhelp'),
								$a => $u . "pan-zoom/",
								$hl => array(
									$dp => array(
										array($p => '#slide#.slide.bg.type', $v => 'image::external', $o => 'slide_bg_type'),
										array($p => '#slide#.slide.panzoom.set', $v => true, $o => 'slide_panzoom')
									),
									$m => "#module_slide_trigger, #gst_slide_3", 
									$st => '#form_slidebg_kenburn', 
									$f => "#sl_pz_ro"
								)
							),
							'rotate_end' => array(
								$t => __("Rotate End", 'revsliderhelp'),
								$h => "panzoom.rotateEnd",
								$k => array("panzoom", "pan zoom", "rotate", "pan zoom rotate", "panzoom rotate", "rotation", "pan zoom rotation"),
								$d => __("The ending rotation for the PanZoom effect (deg)", 'revsliderhelp'),
								$a => $u . "pan-zoom/",
								$hl => array(
									$dp => array(
										array($p => '#slide#.slide.bg.type', $v => 'image::external', $o => 'slide_bg_type'),
										array($p => '#slide#.slide.panzoom.set', $v => true, $o => 'slide_panzoom')
									),
									$m => "#module_slide_trigger, #gst_slide_3", 
									$st => '#form_slidebg_kenburn', 
									$f => "#sl_pz_re"
								)
							),
							'blur_start' => array(
								$t => __("Blur Start", 'revsliderhelp'),
								$h => "panzoom.blurStart",
								$k => array("panzoom", "pan zoom", "rotate", "pan zoom blur", "panzoom blur", "blur", "image blur"),
								$d => __("The starting image blur for the PanZoom effect (px)", 'revsliderhelp'),
								$a => $u . "pan-zoom/",
								$hl => array(
									$dp => array(
										array($p => '#slide#.slide.bg.type', $v => 'image::external', $o => 'slide_bg_type'),
										array($p => '#slide#.slide.panzoom.set', $v => true, $o => 'slide_panzoom')
									),
									$m => "#module_slide_trigger, #gst_slide_3", 
									$st => '#form_slidebg_kenburn', 
									$f => "#sl_pz_blurs"
								)
							),
							'blur_end' => array(
								$t => __("Blur End", 'revsliderhelp'),
								$h => "panzoom.blurEnd",
								$k => array("panzoom", "pan zoom", "rotate", "pan zoom blur", "panzoom blur", "blur", "image blur"),
								$d => __("The ending image blur for the PanZoom effect (px)", 'revsliderhelp'),
								$a => $u . "pan-zoom/",
								$hl => array(
									$dp => array(
										array($p => '#slide#.slide.bg.type', $v => 'image::external', $o => 'slide_bg_type'),
										array($p => '#slide#.slide.panzoom.set', $v => true, $o => 'slide_panzoom')
									),
									$m => "#module_slide_trigger, #gst_slide_3", 
									$st => '#form_slidebg_kenburn', 
									$f => "#sl_pz_blure"
								)
							)
						),
						'easing' => array(
							$t => __("Easing", 'revsliderhelp'),
							$h => "panzoom.ease",
							$k => array("panzoom", "pan zoom", "easing", "pan zoom easing", "panzoom easing"),
							$d => __("The easing equation.  <a href='https://greensock.com/ease-visualizer' target=_'blank'>View visualization</a>", 'revsliderhelp'),
							$a => $u . "pan-zoom/",
							$hl => array(
								$dp => array(
									array($p => '#slide#.slide.bg.type', $v => 'image::external', $o => 'slide_bg_type'),
									array($p => '#slide#.slide.panzoom.set', $v => true, $o => 'slide_panzoom')
								),
								$m => "#module_slide_trigger, #gst_slide_3", 
								$st => '#form_slidebg_kenburn', 
								$f => "#sl_pz_ease"
							)
						),
						'duration' => array(
							$t => __("Duration", 'revsliderhelp'),
							$h => "panzoom.duration",
							$k => array("panzoom", "pan zoom", "duration", "pan zoom duration", "panzoom duration"),
							$d => __("The easing duration in milliseconds", 'revsliderhelp'),
							$a => $u . "pan-zoom/",
							$hl => array(
								$dp => array(
									array($p => '#slide#.slide.bg.type', $v => 'image::external', $o => 'slide_bg_type'),
									array($p => '#slide#.slide.panzoom.set', $v => true, $o => 'slide_panzoom')
								),
								$m => "#module_slide_trigger, #gst_slide_3", 
								$st => '#form_slidebg_kenburn', 
								$f => "#sl_pz_dur"
							)
						)
					),
					'gst_slide_7' => array(
						'param_text' => array(
							$t => __("Parameter Value", 'revsliderhelp'),
							$h => "info.params.v",
							$k => array("slide params", "slide parameters", "params", "parameters"),
							$d => __("Slide data that can be used for navigation text/data", 'revsliderhelp'),
							$a => $u . "slide-parameters/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_7", 
								$st => '#form_slidegeneral_params', 
								$f => "#slide_info_p1"
							)
						),
						'max_chars' => array(
							$t => __("Max Characters", 'revsliderhelp'),
							$h => "info.params.l",
							$k => array("max chars", "max characters", "params", "parameters", "slide params", "slide parameters"),
							$d => __("The maximum characters/letters to display for the paramater", 'revsliderhelp'),
							$a => $u . "slide-parameters/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_7", 
								$st => '#form_slidegeneral_params', 
								$f => "#slide_info_p1ch"
							)
						),
						'description' => array(
							$t => __("Description", 'revsliderhelp'),
							$h => "info.description",
							$k => array("params", "parameters", "slide params", "slide parameters", "slide description", "params description", "description"),
							$d => __("A Slide description for certain navigation types", 'revsliderhelp'),
							$a => $u . "slide-parameters/",
							$hl => array(
								$m => "#module_slide_trigger, #gst_slide_7", 
								$st => '#form_slidegeneral_params', 
								$f => "#slide_info_desc"
							)
						)
					),
					'gst_slide_11' => array(
						'use_slide_loop' => array(
							$di => 'slide_loop',
							$t => __("Slide Looping", 'revsliderhelp'),
							$h => "timeline.loop.set",
							$k => array("slide loop", "slide looping", "loop", "loop slide", "animation", "loop animation"),
							$d => __("Loop all or part of the current Slide's timeline", 'revsliderhelp'),
							$a => $u . "slide-loop",
							$hl => array($m => "#module_slide_trigger, #gst_slide_11", $st => '#form_slide_loops', $f => "#sl_layers_loop")
						),
						'repeat' => array(
							$t => __("Slide Loop Repeat", 'revsliderhelp'),
							$h => "timeline.loop.repeat",
							$k => array("slide loop", "slide looping", "loop", "loop slide", "animation", "loop animation", "repeat", "slide loop repeat", "loop repeat"),
							$d => __("Enter a specific amount of times the Slide's timeeline should loop or use 'unlimited' to loop continusously until the Slide changes", 'revsliderhelp'),
							$a => $u . "slide-loop",
							$hl => array(
								$dp => array(array($p => '#slide#.slide.timeline.loop.set', $v => true, $o => 'slide_loop')),
								$m => "#module_slide_trigger, #gst_slide_11", 
								$st => '#form_slide_loops', 
								$f => "#slide_loop_repeat"
							)
						),
						'loop_start' => array(
							$t => __("Slide Loop Start", 'revsliderhelp'),
							$h => "timeline.loop.start",
							$k => array("slide loop", "slide looping", "loop", "loop slide", "animation", "loop animation", "start", "slide loop start", "loop start"),
							$d => __("The point in the timeline where the looping should begin", 'revsliderhelp'),
							$a => $u . "slide-loop",
							$hl => array(
								$dp => array(array($p => '#slide#.slide.timeline.loop.set', $v => true, $o => 'slide_loop')),
								$m => "#module_slide_trigger, #gst_slide_11", 
								$st => '#form_slide_loops', 
								$f => "#slide_loop_start"
							)
						),
						'loop_end' => array(
							$t => __("Slide Loop End", 'revsliderhelp'),
							$h => "timeline.loop.end",
							$k => array("slide loop", "slide looping", "loop", "loop slide", "animation", "loop animation", "end", "slide loop end", "loop end"),
							$d => __("The point in the timeline where the looping should begin", 'revsliderhelp'),
							$a => $u . "slide-loop",
							$hl => array(
								$dp => array(array($p => '#slide#.slide.timeline.loop.set', $v => true, $o => 'slide_loop')),
								$m => "#module_slide_trigger, #gst_slide_11", 
								$st => '#form_slide_loops', 
								$f => "#slide_loop_end"
							)
						)
					),
					'gst_slide_12' => array(
						'parallax_level' => array(
							$t => __("Parallax Level", 'revsliderhelp'),
							$h => "effects.parallax",
							$k => array("parallax", "3d", "scroll", "on scroll", "parallax level", "level", "effects"),
							$d => __("The <a href='http://docs.themepunch.com/slider-revolution/parallax-3d-effect/#depths' target='_blank'>parallax level</a> to apply to the Slide's main background", 'revsliderhelp'),
							$a => $u . "slide-background/",
							$hl => array($m => "#module_slide_trigger, #gst_slide_12", $st => '#form_slidebg_pddd', $f => "#slide_parallax_level")
						),
						'fade' => array(
							$t => __("Fade Effect", 'revsliderhelp'),
							$h => "effects.fade",
							$k => array("parallax", "3d", "scroll", "on scroll", "effects", "fade"),
							$d => __("Fade Layers in and out as the page scrolls into and out of view", 'revsliderhelp'),
							$a => $u . "slide-background/",
							$hl => array($m => "#module_slide_trigger, #gst_slide_12", $st => '#form_slidefilter_scrollbased', $f => "#slide_effectscroll_fade")
						),
						'blur' => array(
							$t => __("Blur Effect", 'revsliderhelp'),
							$h => "effects.blur",
							$k => array("parallax", "3d", "scroll", "on scroll", "effects", "blur"),
							$d => __("Blur Layers in and out as the page scrolls into and out of view", 'revsliderhelp'),
							$a => $u . "slide-background/",
							$hl => array($m => "#module_slide_trigger, #gst_slide_12", $st => '#form_slidefilter_scrollbased', $f => "#slide_effectscroll_blur")
						),
						'grayscale' => array(
							$t => __("Grayscale Effect", 'revsliderhelp'),
							$h => "effects.grayscale",
							$k => array("parallax", "3d", "scroll", "on scroll", "effects", "grayscale"),
							$d => __("Aply a grayscale filter to Layers as the page scrolls into and out of view", 'revsliderhelp'),
							$a => $u . "slide-background/",
							$hl => array($m => "#module_slide_trigger, #gst_slide_12", $st => '#form_slidefilter_scrollbased', $f => "#slide_effectscroll_grayscale")
						)
					),
					'addons' => array(),
				),
				'layer_settings' => array(
					'gst_layer_1' => array(
						'text_button_icon' => array(
							'text_content' => array(
								$t => __("Layer Text", 'revsliderhelp'),
								$h => "text",
								$k => array("layer", "layers", "slider text", "slide text", "layer text", "text", "change text"),
								$d => __("The html/text for the selected Layer's content.  'Idle' is the default text.  And 'Toggle' is alternative text to show when the Layer is clicked.", 'revsliderhelp'),
								$a => $u . "layer-content/#text-buttons",
								$hl => array(
									$dp => array('layerselected::text||button'), 
									$m => "#module_layers_trigger, #gst_layer_1", 
									$st => '#form_layercontent_content_text', 
									$f => "#ta_layertext"
								)
							),
							'placeholder' => array(
								$t => __("Placeholder", 'revsliderhelp'),
								$h => "placeholder",
								$k => array("slider text", "slide text", "layer text", "text", "change text"),
								$d => __("Optional placeholder attribute for the Layer's wrapper", 'revsliderhelp'),
								$a => $u . "layer-content/#text-buttons",
								$hl => array(
									$dp => array('layerselected::text||button'), 
									$m => "#module_layers_trigger, #gst_layer_1", 
									$st => '#form_layercontent_content_text', 
									$f => "#ta_placeholder"
								)
							),
							'linebreak' => array(
								$t => __("Line Break Behavior", 'revsliderhelp'),
								$h => "idle.whiteSpace.#size#.v",
								$k => array("slider text", "slide text", "layer text", "text", "change text", "line-break", "line break"),
								$d => __("Choose how text should wrap/break onto lines lines", 'revsliderhelp'),
								$a => $u . "layer-content/#text-buttons",
								$hl => array(
									$dp => array('layerselected::text||button'), 
									$m => "#module_layers_trigger, #gst_layer_1", 
									$st => '#form_layercontent_content_text', 
									$f => "#layer_linebreak"
								)
							)
						),
						'image' => array(
							'image_from_stream' => array(
								$t => __("Image from Stream", 'revsliderhelp'),
								$h => "media.imageFromStream",
								$k => array("stream", "image stream", "stream image"),
								$d => __("Choose if the Image source should be populated by the Slide's social stream content", 'revsliderhelp'),
								$a => $u . "layer-content/#images",
								$hl => array(
									$dp => array('layerselected::image'), 
									$m => "#module_layers_trigger, #gst_layer_1", 
									$st => '#form_layercontent_content_image', 
									$f => "*[data-r='media.imageFromStream']"
								)
							),
							'image_url' => array(
								$t => __("Image URL", 'revsliderhelp'),
								$h => "media.imageUrl",
								$k => array("layer", "layers", "layer image", "image url", "media library", "layer image url"),
								$d => __("Set/change the image for the Layer", 'revsliderhelp'),
								$a => $u . "layer-content/#images",
								$hl => array(
									$dp => array('layerselected::image'), 
									$m => "#module_layers_trigger, #gst_layer_1", 
									$st => '#form_layercontent_content_image', 
									$f => "#image_layer_media_library_button"
								)
							),
							'lazy_loading' => array(
								$t => __("Lazy Loading", 'revsliderhelp'),
								$h => "behavior.lazyLoad",
								$k => array("lazy", "lazy load", "lazy loading"),
								$d => __("'Default' will use the Slider's Lazy Load setting, 'Force' will LazyLoad the image regardless of the Slider's settings, and 'Ignore' will set LazyLoad to off regardless of the Slider's settings.", 'revsliderhelp'),
								$a => $u . "layer-content/",
								$hl => array(
									$dp => array('layerselected::image'), 
									$m => "#module_layers_trigger, #gst_layer_1", 
									$st => '#form_layercontent_content_image', 
									$f => "*[data-r='behavior.lazyLoad']"
								)
							),
							'image_size' => array(
								$t => __("Image Source Size", 'revsliderhelp'),
								$h => "behavior.imageSourceType",
								$k => array("image size", "image source", "image sour size", "layer image"),
								$d => __("The default WordPress Image size to be used when the image is loaded", 'revsliderhelp'),
								$a => $u . "layer-content/",
								$hl => array(
									$dp => array('layerselected::image'), 
									$m => "#module_layers_trigger, #gst_layer_1", 
									$st => '#form_layercontent_content_image', 
									$f => "*[data-r='behavior.imageSourceType']"
								)
							)
						),
						'video_audio' => array(
							'media_content' => array(
								'video_from_stream' => array(
									$t => __("Video from Stream", 'revsliderhelp'),
									$h => "media.videoFromStream",
									$k => array("layer", "layers", "stream", "stream video", "video stream"),
									$d => __("The Layer's image will be populated automatically from the Slider's Video-Stream source", 'revsliderhelp'),
									$a => $u . "layer-content/#video-audio",
									$hl => array(
										$dp => array('layerselected::video'), 
										$m => "#module_layers_trigger, #gst_layer_1", 
										$st => '#form_layercontent_content_video', 
										$f => "*[data-r='media.videoFromStream']"
									)
								),
								'type' => array(
									$di => "layer_video_type",
									$t => __("Video Type", 'revsliderhelp'),
									$h => "media.mediaType",
									$k => array("youtube", "vimeo", "html5 video", "video layer", "layer video", "youtube video", "you-tube", "you tube", "youtube video layer", "vimeo video"),
									$d => __("Choose if the video should be loaded from YouTube, Vimeo or locally (HTML5)", 'revsliderhelp'),
									$a => $u . "layer-content/#video-audio",
									$hl => array(
										$dp => array('layerselected::video'), 
										$m => "#module_layers_trigger, #gst_layer_1", 
										$st => '#form_layercontent_content_video', 
										$f => "*[name='layer_video_type']*wildcard*"
									)
								),
								'video_id_url' => array(
									'video_id' => array(
										$t => __("YouTube/Vimeo ID", 'revsliderhelp'),
										$h => "media.id",
										$k => array("youtube", "vimeo", "video layer", "layer video", "youtube video", "you-tube", "you tube", "youtube video layer", "vimeo video", "youtube id", "vimeo id"),
										$d => __("The <a href='https://www.quora.com/What-is-a-YouTube-video-ID' target=_'blank'>YouTube ID</a> or <a href='https://docs.joeworkman.net/rapidweaver/stacks/vimeo/video-id' target='_blank'>Vimeo ID</a> for the video's source", 'revsliderhelp'),
										$a => $u . "layer-content/#video-audio",
										$hl => array(
											$dp => array(
												'layerselected::video',
												array($p => '#slide#.layers.#layer#.media.mediaType', $v => 'youtube::vimeo', $o => 'layer_video_type', 'target' => 'youtube')
											), 
											$m => "#module_layers_trigger, #gst_layer_1", 
											$st => '#form_layercontent_content_video', 
											$f => "#layer_youtubevimeo_id"
										)
									),
									'html5_video_url' => array(
										$t => __("HTML5 Video URL", 'revsliderhelp'),
										$h => "media.mp4Url",
										$k => array("mpeg", "mpg", "mp4", "html5 video", "html5 video source", "video url", "html5 url", "htlm5 video url"),
										$d => __("The url for the locally loaded HTML5 Video", 'revsliderhelp'),
										$a => $u . "layer-content/#video-audio",
										$hl => array(
											$dp => array(
												'layerselected::video',
												array($p => '#slide#.layers.#layer#.media.mediaType', $v => 'html5', $o => 'layer_video_type', 'target' => 'html5')
											), 
											$m => "#module_layers_trigger, #gst_layer_1", 
											$st => '#form_layercontent_content_video', 
											$f => "#layer_mpeg_src"
										)
									),
									'html5_audio_url' => array(
										$t => __("HTML5 Audio URL", 'revsliderhelp'),
										$h => "media.audioUrl",
										$k => array("mpeg", "mpg", "mp3", "audio", "html5 audio", "audio url", "html5 audio url", "sound"),
										$d => __("The url for the locally loaded HTML5 Audio", 'revsliderhelp'),
										$a => $u . "layer-content/#video-audio",
										$hl => array(
											$dp => array('layerselected::audio'), 
											$m => "#module_layers_trigger, #gst_layer_1", 
											$st => '#form_layercontent_content_video', 
											$f => "#layer_mpegaudio_src"
										)
									)
								),

								'fitCover' => array(
									$t => __("Video Fit Cover", 'revsliderhelp'),
									$h => "media.fitCover",
									$k => array("fit cover", "video size", "video fit cover"),
									$d => __("Video will fit in container with CSS property object-fit cover. Disable this option in case video size jumps on slide change.", 'revsliderhelp'),
									$a => $u . "layer-video-audio-settings/",
									$hl => array(
										$dp => array('layerselected::video'), 
										$m => "#module_layers_trigger, #gst_layer_1", 
										$st => '#form_layercontent_content_video', 
										$f => "#video_layer_fit_cover"
									)
								),

								'preloading' => array(
									'preload' => array(
										$t => __("Preload", 'revsliderhelp'),
										$h => "media.speed",
										$k => array("preload video", "html5 video preload", "html5 audio preload"),
										$d => __("The HTML5 Video/Audio <a href='https://www.w3schools.com/tags/att_video_preload.asp' target=_'blank'>preload behavior</a> for the currently selected Video Layer", 'revsliderhelp'),
										$a => $u . "layer-content/#video-audio",
										$hl => array(
											$dp => array(
												'layerselected::video||audio',
												array('dependency' => 'video', $p => '#slide#.layers.#layer#.media.mediaType', $v => 'html5', $o => 'layer_video_type', 'target' => 'html5')
											), 
											$m => "#module_layers_trigger, #gst_layer_1", 
											$st => '#form_layercontent_content_video', 
											$f => "#layer_media_preload"
										)
									),
									'skip_preload' => array(
										$t => __("Preload Delay", 'revsliderhelp'),
										$h => "media.preloadWait",
										$k => array("audio", "media", "audio player", "sound", "preload", "skip preload", "preload delay"),
										$d => __("Skip the preloading of HTML5 Audio by a set amount of seconds", 'revsliderhelp'),
										$a => $u . "layer-content/#video-audio",
										$hl => array(
											$dp => array('layerselected::audio'), 
											$m => "#module_layers_trigger, #gst_layer_1", 
											$st => '#form_layercontent_content_video', 
											$f => "*[data-r='media.preloadWait']"
										)
									)
								),
								'aspect_ratio' => array(
									$t => __("Aspect Ratio", 'revsliderhelp'),
									$h => "media.ratio",
									$k => array("aspect ratio", "video size", "video aspect ratio"),
									$d => __("This value should match the video's original aspect ratio", 'revsliderhelp'),
									$a => $u . "layer-video-audio-settings/",
									$hl => array(
										$dp => array('layerselected::video'), 
										$m => "#module_layers_trigger, #gst_layer_1", 
										$st => '#form_layercontent_content_video', 
										$f => "#layer_video_layeraspectratio"
									)
								),
								'autoplay' => array(
									$t => __("Autoplay", 'revsliderhelp'),
									$h => "media.autoPlay",
									$k => array("autoplay video", "video autoplay", "autoplay", "video", "youtube", "vimeo", "html5"),
									$d => __("The autoplay behavior for the currently selected Video Layer", 'revsliderhelp'),
									$a => $u . "layer-video-audio-settings/",
									$hl => array(
										$dp => array('layerselected::video||audio'), 
										$m => "#module_layers_trigger, #gst_layer_1", 
										$st => '#form_layercontent_content_video', 
										$f => "#layer_video_autoplay"
									)
								),
								'loop' => array(
									$t => __("Loop Video/Audio", 'revsliderhelp'),
									$h => "media.loop",
									$k => array("loop", "video loop", "restart", "restart video"),
									$d => __("Restart the video/audio every time it ends", 'revsliderhelp'),
									$a => $u . "layer-video-audio-settings/",
									$hl => array(
										$dp => array('layerselected::video||audio'), 
										$m => "#module_layers_trigger, #gst_layer_1", 
										$st => '#form_layercontent_content_video', 
										$f => "#layer_video_loop"
									)
								),
								'dotted_overlay' => array(
									$t => __("Dotted Overlay", 'revsliderhelp'),
									$h => "media.dotted",
									$k => array("overlay", "video overlay", "dotted overlay"),
									$d => __("Add a mesh-style overlay to the video for extra styling", 'revsliderhelp'),
									$a => $u . "layer-video-audio-settings/",
									$hl => array(
										$dp => array('layerselected::video'), 
										$m => "#module_layers_trigger, #gst_layer_1", 
										$st => '#form_layercontent_content_video', 
										$f => "#layer_dotted_overlay"
									)
								)
							),
							'media_poster' => array(
								'poster_from_stream' => array(
									$t => __("Poster from Stream", 'revsliderhelp'),
									$h => "media.posterFromStream",
									$k => array("stream", "stream background", "poster", "youtube poster", "vimeo poster", "video poster"),
									$d => __("The video's poster image will be populated automatically from the Slider's Video-Stream source", 'revsliderhelp'),
									$a => $u . "layer-video-audio-settings/",
									$hl => array(
										$dp => array('layerselected::video'), 
										$m => "#module_layers_trigger, #gst_layer_1", 
										$st => '#form_layercontent_content_videoposter', 
										$f => "*[data-r='media.posterFromStream']"
									)
								),
								'poster_url' => array(
									$t => __("Poster URL", 'revsliderhelp'),
									$h => "media.posterUrl",
									$k => array("video poster", "poster", "youtube poster", "vimeo poster", "video image", "youtube image", "vimeo image", "poster url"),
									$d => __("Set/remove the video's preview image for the video", 'revsliderhelp'),
									$a => $u . "layer-video-audio-settings/",
									$hl => array(
										$dp => array('layerselected::video'), 
										$m => "#module_layers_trigger, #gst_layer_1", 
										$st => '#form_layercontent_content_videoposter', 
										$f => "#form_layercontent_content_videoposter *[data-r='media.posterUrl']{first}"
									)
								),
								'poster_in_pause' => array(
									$t => __("Show Poster on Video Pause", 'revsliderhelp'),
									$h => "media.posterOnPause",
									$k => array("video poster", "poster", "youtube poster", "vimeo poster", "video image", "youtube image", "vimeo image"),
									$d => __("Show the video's preview image whenever the video is paused by the user or on a Slide change", 'revsliderhelp'),
									$a => $u . "layer-video-audio-settings/",
									$hl => array(
										$dp => array('layerselected::video'), 
										$m => "#module_layers_trigger, #gst_layer_1", 
										$st => '#form_layercontent_content_videoposter', 
										$f => "*[data-r='media.posterOnPause']"
									)
								),
								'no_poster_mobile' => array(
									$t => __("No Poster on Mobile", 'revsliderhelp'),
									$h => "media.disableOnMobile",
									$k => array("video poster", "poster", "youtube poster", "vimeo poster", "video image", "youtube image", "vimeo image"),
									$d => __("Only show a video preview image on desktop computers", 'revsliderhelp'),
									$a => $u . "layer-video-audio-settings/",
									$hl => array(
										$dp => array('layerselected::video'), 
										$m => "#module_layers_trigger, #gst_layer_1", 
										$st => '#form_layercontent_content_videoposter', 
										$f => "*[data-r='media.disableOnMobile']"
									)
								),
								'only_poster_mobile' => array(
									$t => __("Only Poster on Mobile", 'revsliderhelp'),
									$h => "media.posterOnMobile",
									$k => array("video poster", "poster", "youtube poster", "vimeo poster", "video image", "youtube image", "vimeo image"),
									$d => __("Only show a video preview image on mobile devices", 'revsliderhelp'),
									$a => $u . "layer-video-audio-settings/",
									$hl => array(
										$dp => array('layerselected::video'), 
										$m => "#module_layers_trigger, #gst_layer_1", 
										$st => '#form_layercontent_content_videoposter', 
										$f => "*[data-r='media.posterOnMobile']"
									)
								)
							),
							'advanced_settings' => array(
								'stop_other_media' => array(
									$t => __("Stop Other Media", 'revsliderhelp'),
									$h => "media.stopAllVideo",
									$k => array("stop video", "pause video", "stop other media", "pause media", "stop media", "stop audio", "stop sound", "pause audio", "pause sound"),
									$d => __("Stop/pause other video/audio in the Slide when the currently selected Video Layer begins to play", 'revsliderhelp'),
									$a => $u . "layer-video-audio-settings/",
									$hl => array(
										$dp => array('layerselected::video||audio'), 
										$m => "#module_layers_trigger, #gst_layer_1", 
										$st => '#form_layercontent_content_video_adv', 
										$f => "*[data-r='media.stopAllVideo']"
									)
								),
								'allow_fullscreen' => array(
									$t => __("Allow Fullscreen", 'revsliderhelp'),
									$h => "media.allowFullscreen",
									$k => array("fullscreen video", "fullscreen", "fullscreen button", "allow fullscreen"),
									$d => __("Allow the video to be taken fullscreen by the user", 'revsliderhelp'),
									$a => $u . "layer-video-audio-settings/",
									$hl => array(
										$dp => array('layerselected::video'), 
										$m => "#module_layers_trigger, #gst_layer_1", 
										$st => '#form_layercontent_content_video_adv', 
										$f => "*[data-r='media.allowFullscreen']"
									)
								),
								'next_slide_at_end' => array(
									$t => __("Next Slide at End", 'revsliderhelp'),
									$h => "media.nextSlideAtEnd",
									$k => array("next slide at end", "next slide end"),
									$d => __("Change to the next Slide when the video/audio ends", 'revsliderhelp'),
									$a => $u . "layer-video-audio-settings/",
									$hl => array(
										$dp => array('layerselected::video||audio'), 
										$m => "#module_layers_trigger, #gst_layer_1", 
										$st => '#form_layercontent_content_video_adv', 
										$f => "*[data-r='media.nextSlideAtEnd']"
									)
								),
								'rewind_at_start' => array(
									$t => __("Rewind at Start", 'revsliderhelp'),
									$h => "media.forceRewind",
									$k => array("rewind", "rewind at start", "rewind video", "restart video", "rewind audio", "restart audio"),
									$d => __("Always play the video/audio from the beginning each time the Slide is shown", 'revsliderhelp'),
									$a => $u . "layer-video-audio-settings/",
									$hl => array(
										$dp => array('layerselected::video||audio'), 
										$m => "#module_layers_trigger, #gst_layer_1", 
										$st => '#form_layercontent_content_video_adv', 
										$f => "*[data-r='media.forceRewind']"
									)
								),
								'no_interaction' => array(
									$di => 'no_interaction',
									$t => __("No Interaction", 'revsliderhelp'),
									$h => "media.nointeraction",
									$k => array("video controls", "video control bar", "controls", "audio controls", "video player", "audio player", "interaction", "no interaction"),
									$d => __("Disable all possible user-interaction with the video", 'revsliderhelp'),
									$a => $u . "layer-video-audio-settings/",
									$hl => array(
										$dp => array('layerselected::video||audio'), 
										$m => "#module_layers_trigger, #gst_layer_1", 
										$st => '#form_layercontent_content_video_adv', 
										$f => "*[data-r='media.nointeraction']"
									)
								),
								'controls' => array(
									$t => __("Controls", 'revsliderhelp'),
									$h => "media.controls",
									$k => array("video controls", "video control bar", "controls", "audio controls", "video player", "audio player"),
									$d => __("Display controls in the video/audio player", 'revsliderhelp'),
									$a => $u . "layer-video-audio-settings/",
									$hl => array(
										$dp => array(
											'layerselected::video||audio',
											array($p => '#slide#.layers.#layer#.media.nointeraction', $v => false, $o => 'no_interaction')
										), 
										$m => "#module_layers_trigger, #gst_layer_1", 
										$st => '#form_layercontent_content_video_adv', 
										$f => "*[data-r='media.controls']"
									)
								),
								'large_controls' => array(
									$t => __("Large Controls", 'revsliderhelp'),
									$h => "media.largeControls",
									$k => array("large controls", "video controls", "html5 video controls"),
									$d => __("Include large controls for HTML5 Video Layers", 'revsliderhelp'),
									$a => $u . "layer-video-audio-settings/",
									$hl => array(
										$dp => array(
											'layerselected::video',
											array($p => '#slide#.layers.#layer#.media.mediaType', $v => 'html5', $o => 'layer_video_type', 'target' => 'html5'),
											array($p => '#slide#.layers.#layer#.media.nointeraction', $v => false, $o => 'no_interaction')
										), 
										$m => "#module_layers_trigger, #gst_layer_1", 
										$st => '#form_layercontent_content_video_adv', 
										$f => "*[data-r='media.largeControls']"
									)
								),
								'inline_mode' => array(
									$t => __("Inline Mode", 'revsliderhelp'),
									$h => "media.playInline",
									$k => array("playsinline, inline, inline mode, video inline, video playsinline"),
									$d => __("Include a 'playsline' attribute with the video element.  This will prevent the video from being taken fullscreen when it initially plays on mobile devices.", 'revsliderhelp'),
									$a => $u . "layer-video-audio-settings/",
									$hl => array(
										$dp => array('layerselected::video'), 
										$m => "#module_layers_trigger, #gst_layer_1", 
										$st => '#form_layercontent_content_video_adv', 
										$f => "*[data-r='media.playInline']"
									)
								),
								'mute_at_start' => array(
									$t => __("Mute at Start", 'revsliderhelp'),
									$h => "media.mute",
									$k => array("mute video", "mute at start"),
									$d => __("Auto-mute the video each time the Slide is shown", 'revsliderhelp'),
									$a => $u . "layer-video-audio-settings/",
									$hl => array(
										$dp => array('layerselected::video'), 
										$m => "#module_layers_trigger, #gst_layer_1", 
										$st => '#form_layercontent_content_video_adv', 
										$f => "*[data-r='media.mute']"
									)
								),
								'volume' => array(
									$t => __("Video/Audio Volume", 'revsliderhelp'),
									$h => "media.volume",
									$k => array("video volume", "volume", "youtube volume", "vimeo volume", "html5 video volume", "audio volume", "html5 audio volume"),
									$d => __("The initial volume for the video/audio.  Choose a number between 0-100", 'revsliderhelp'),
									$a => $u . "layer-video-audio-settings/",
									$hl => array(
										$dp => array('layerselected::video||audio'), 
										$m => "#module_layers_trigger, #gst_layer_1", 
										$st => '#form_layercontent_content_video_adv', 
										$f => "#layer_video_volume"
									)
								),
								'speed' => array(
									$t => __("Video Speed", 'revsliderhelp'),
									$h => "media.speed",
									$k => array("video speed"),
									$d => __("Optional playback speed for the video", 'revsliderhelp'),
									$a => $u . "layer-video-audio-settings/",
									$hl => array(
										$dp => array(
											'layerselected::video',
											array($p => '#slide#.layers.#layer#.media.mediaType', $v => 'youtube', $o => 'layer_video_type', 'target' => 'youtube')
										), 
										$m => "#module_layers_trigger, #gst_layer_1", 
										$st => '#form_layercontent_content_video_adv', 
										$f => "#layer_media_speed"
									)
								),
								'start_at' => array(
									$t => __("Start Time", 'revsliderhelp'),
									$h => "media.startAt",
									$k => array("video start", "video start time", "start at", "video start at", "audio start at", "audio start time"),
									$d => __("Start the video at this time (minutes:seconds, such as 01:30)", 'revsliderhelp'),
									$a => $u . "layer-video-audio-settings/",
									$hl => array(
										$dp => array('layerselected::video||audio'), 
										$m => "#module_layers_trigger, #gst_layer_1", 
										$st => '#form_layercontent_content_video_adv', 
										$f => "#layer_video_start"
									)
								),
								'end_at' => array(
									$t => __("End Time", 'revsliderhelp'),
									$h => "media.endAt",
									$k => array("video end", "video end time", "end at", "video end at", "audio end at", "audio end time"),
									$d => __("End the video at this time (minutes:seconds, such as 01:30)", 'revsliderhelp'),
									$a => $u . "layer-video-audio-settings/",
									$hl => array(
										$dp => array('layerselected::video||audio'), 
										$m => "#module_layers_trigger, #gst_layer_1", 
										$st => '#form_layercontent_content_video_adv', 
										$f => "#layer_video_end"
									)
								)
							),
							'arguments' => array(
								$t => __("YouTube/Vimeo Arguments", 'revsliderhelp'),
								$h => "media.args",
								$k => array("youtube args", "youtube arguments", "vimeo args", "vimeo arguments"),
								$d => __("Optional iFrame arguments for <a href='https://developers.google.com/youtube/player_parameters' target='_blank'>YouTube</a> and <a href='https://help.vimeo.com/hc/en-us/articles/360001494447-Using-Player-Parameters' target='_blank'>Vimeo</a>", 'revsliderhelp'),
								$a => $u . "layer-video-audio-settings/",
								$hl => array(
									$dp => array(
										'layerselected::video',
										array($p => '#slide#.layers.#layer#.media.mediaType', $v => 'youtube::vimeo', $o => 'layer_video_type', 'target' => 'youtube')
									), 
									$m => "#module_layers_trigger, #gst_layer_1", 
									$st => '#form_layercontent_content_video_attr', 
									$f => "#layer_video_arg"
								)
							)
						),
						'row_settings' => array(
							'columns' => array(
								$t => __("Column Structure", 'revsliderhelp'),
								$h => "row_column_structure",
								$k => array("rows", "columns", "row", "column", "colspan"),
								$d => __("Choose the number of columns and their <a href='https://www.w3schools.com/tags/att_td_colspan.asp' target='_blank'>colspan</a> for the selected row", 'revsliderhelp'),
								$a => $u . "rows-columns/",
								$hl => array(
									$dp => array('layerselected::row||column'), 
									$m => "#module_layers_trigger, #gst_layer_1", 
									$st => '#form_layercontent_content_row', 
									$f => "#row_column_structure"
								)
							),
							'break_at' => array(
								$t => __("Break At", 'revsliderhelp'),
								$h => "group.columnbreakat",
								$k => array("rows", "columns", "row", "column", "colspan", "break at", "break columns"),
								$d => __("Choose which viewport the rows should collapse into single columns", 'revsliderhelp'),
								$a => $u . "rows-columns/",
								$hl => array(
									$dp => array('layerselected::row||column'), 
									$m => "#module_layers_trigger, #gst_layer_1", 
									$st => '#form_layercontent_content_row', 
									$f => "#layer_row_break_tablet"
								)
							),
							'row_position' => array(
								$t => __("Row Position", 'revsliderhelp'),
								$h => "row_position",
								$k => array("rows", "columns", "row", "column", "row position", "row align", "position", "align"),
								$d => __("The vertical-align value for the row in relation to the Module's height (top, middle or bottom)", 'revsliderhelp'),
								$a => $u . "rows-columns/",
								$hl => array(
									$dp => array('layerselected::row||column'), 
									$m => "#module_layers_trigger, #gst_layer_1", 
									$st => '#form_layercontent_content_row', 
									$f => ".layer_rowposition_icons.selected"
								)
							)
						),
						'column_settings' => array(
							'horizontal_align' => array(
								$t => __("Horizontal Align", 'revsliderhelp'),
								$h => "idle.textAlign.#size#.v",
								$k => array("layer horizontal align", "horizontal align", "row align", "row alignment", "column align", "column alignment"),
								$d => __("The CSS text-align for the Layer's text.  Also useful for aligning content inside rows/colums", 'revsliderhelp'),
								$a => $u . "rows-columns/",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_1", 
									$st => '#form_layercontent_content_column', 
									$f => ".layer_content_hor_selector.selected"
								)
							),
							'vertical_align' => array(
								$t => __("Vertical Align", 'revsliderhelp'),
								$h => "idle.verticalAlign",
								$k => array("layer vertical align", "vertical align", "row align", "row alignment", "column align", "column alignment"),
								$d => __("The vertical alignment for content inside a row/column", 'revsliderhelp'),
								$a => $u . "rows-columns/",
								$hl => array(
									$dp => array('layerselected::column'), 
									$m => "#module_layers_trigger, #gst_layer_1", 
									$st => '#form_layercontent_content_column', 
									$f => ".layer_content_ver_selector.selected"
								)
							)
						),
						'column_display_mode' => array(
							'display' => array(
								$t => __("CSS Display", 'revsliderhelp'),
								$h => "idle.display",
								$k => array(),
								$d => __("The <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/display' target='_blank'>CSS display property</a> for the Layer as it fits inside the Column", 'revsliderhelp'),
								$a => $u . "layer-content/",
							),
							'float' => array(
								$t => __("CSS Float", 'revsliderhelp'),
								$h => "idle.clear.#size#.v",
								$k => array(),
								$d => __("The <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/float' target='_blank'>CSS float property</a> for the Layer as it fits inside the Column", 'revsliderhelp'),
								$a => $u . "layer-content/",
							),
							'clear' => array(
								$t => __("CSS Clear", 'revsliderhelp'),
								$h => "idle.float.#size#.v",
								$k => array(),
								$d => __("The <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/clear' target='_blank'>CSS clear property</a> for the Layer as it fits inside the Column", 'revsliderhelp'),
								$a => $u . "layer-content/",
							),
							'linebreak_before' => array(
								$t => __("Add Linebreak Before", 'revsliderhelp'),
								$h => "linebreak_before",
								$k => array(),
								$d => __("Add a linebreak before the currently selected Layer.  Useful when floats are used.", 'revsliderhelp'),
								$a => $u . "layer-content/",
							),
							'linebreak_before' => array(
								$t => __("Add Linebreak After", 'revsliderhelp'),
								$h => "linebreak_after",
								$k => array(),
								$d => __("Add a linebreak after the currently selected Layer.  Useful when floats are used.", 'revsliderhelp'),
								$a => $u . "layer-content/",
							)
						),
						'htmltag' => array(
							$t => __("Layer HTML Tag", 'revsliderhelp'),
							$h => "htmltag",
							$k => array("html tag", "layer tag", "layer wrapper tag", "wrapper tag", "wrapper"),
							$d => __("Choose which HTML tag should be used for the Layer.  Useful for SEO purposes", 'revsliderhelp'),
							$a => $u . "layer-content/",
							$hl => array(
								$dp => array('layerselected::text||image||button||shape||video||audio||object||group'), 
								$m => "#module_layers_trigger, #gst_layer_1", 
								$st => '#form_layercontent_tag', 
								$f => "#layer_htmltag"
							)
						)
					),
					'gst_layer_3' => array(
						'font' => array(
							'font_size' => array(
								$t => __("Font Size", 'revsliderhelp'),
								$h => "idle.fontSize.#size#.v",
								$k => array("font size", "font-size", "font", "text", "text-size", "layer text", "layer font", "layer font size", "layer font-size"),
								$d => __("The Layer's font-size for the currently selected viewport", 'revsliderhelp'),
								$a => $u . "font-colors-styling/",
								$hl => array(
									$dp => array('layerselected::text||button'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#form_layerstyle_font', 
									$f => "#layer_font_size_idle"
								)
							),
							'line_height' => array(
								$t => __("Line Height", 'revsliderhelp'),
								$h => "idle.lineHeight.#size#.v",
								$k => array("line-height", "line height", "text size"),
								$d => __("The Layer's <a href='https://www.w3schools.com/cssref/pr_dim_line-height.asp' target=_'blank'>CSS line-height</a> value for the currently selected viewport", 'revsliderhelp'),
								$a => $u . "font-colors-styling/",
								$hl => array(
									$dp => array('layerselected::text||button'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#form_layerstyle_font', 
									$f => "#layer_line_height_idle"
								)
							),
							'font_weight' => array(
								$t => __("Font Weight", 'revsliderhelp'),
								$h => "idle.fontWeight.#size#.v",
								$k => array("strong", "bold", "font-weight", "font-weight", "bold text", "strong text"),
								$d => __("The Layer's <a href=https://www.w3schools.com/cssref/pr_font_weight.asp' target=_'blank'>CSS font-weight</a> value for the currently selected viewport", 'revsliderhelp'),
								$a => $u . "font-colors-styling/",
								$hl => array(
									$dp => array('layerselected::text||button'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#form_layerstyle_font', 
									$f => "#layer_fontweight_idle"
								)
							),
							'letter_spacing' => array(
								$t => __("Letter Spacing", 'revsliderhelp'),
								$h => "idle.letterSpacing.#size#.v",
								$k => array("letter spacing", "text spacing", "letter-spacing"),
								$d => __("The Layer's <a href=https://www.w3schools.com/cssref/pr_text_letter-spacing.asp' target=_'blank'>CSS letter-spacing</a> value for the currently selected viewport", 'revsliderhelp'),
								$a => $u . "font-colors-styling/",
								$hl => array(
									$dp => array('layerselected::text||button'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#form_layerstyle_font', 
									$f => "*[data-r='idle.letterSpacing.#size#.v']"
								)
							),
							'font_family' => array(
								$t => __("Font Family", 'revsliderhelp'),
								$h => "idle.fontFamily",
								$k => array("font family", "font-family", "text", "text font", "text font family", "text font-family", "google font"),
								$d => __("The Google Font for the currently selected Layer's text", 'revsliderhelp'),
								$a => $u . "font-colors-styling/",
								$hl => array(
									$dp => array('layerselected::text||button'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#form_layerstyle_font', 
									$f => "#layer_fontfamily"
								)
							),
							'text_color' => array(
								$t => __("Text Color", 'revsliderhelp'),
								$h => "idle.color.#size#.v",
								$k => array("text color", "layer text color", "layer text"),
								$d => __("The text color for the currently selected Layer", 'revsliderhelp'),
								$a => $u . "font-colors-styling/",
								$hl => array(
									$dp => array('layerselected::text||button'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#form_layerstyle_font', 
									$f => "#layerTextColor"
								)
							),
							'italic' => array(
								$t => __("Font-Style: Italic", 'revsliderhelp'),
								$h => "idle.fontStyle",
								$k => array("font-style", "font style", "italic", "italics", "italic text"),
								$d => __("Add italics to the currently selected Layer's text", 'revsliderhelp'),
								$a => $u . "font-colors-styling/",
								$hl => array(
									$dp => array('layerselected::text||button'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#form_layerstyle_font', 
									$f => "#layer_fontStyle"
								)
							),
							'text_decoration' => array(
								$t => __("Text Decoration", 'revsliderhelp'),
								$h => "idle.textDecoration",
								$k => array("underline", "strike", "overline", "line-through", "strike-through"),
								$d => __("Add an text underline to the currently selected Layer's text", 'revsliderhelp'),
								$a => $u . "font-colors-styling/",
								$hl => array(
									$dp => array('layerselected::text||button'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#form_layerstyle_font', 
									$f => "#layer_textdecoration_idle"
								)
							),
							'text_transform' => array(
								$t => __("Text Transform", 'revsliderhelp'),
								$h => "idle.textTransform",
								$k => array("text-transform", "uppercase", "lowercase", "upper-case", "lower-case", "capitalize"),
								$d => __("The CSS <a href='https://www.w3schools.com/cssref/pr_text_text-transform.asp' target='_blank'>text-transform</a> value for the text", 'revsliderhelp'),
								$a => $u . "font-colors-styling/",
								$hl => array(
									$dp => array('layerselected::text||button'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#form_layerstyle_font', 
									$f => "#layer_texttransform"
								)
							),
							'selectable' => array(
								$t => __("Layer is Selectable", 'revsliderhelp'),
								$h => "idle.selectable",
								$k => array("selectable", "layer selectable", "user-select", "user select"),
								$d => __("The CSS <a href='https://www.w3schools.com/cssref/css3_pr_user-select.asp' target='_blank'>user-select</a> value for the text", 'revsliderhelp'),
								$a => $u . "font-colors-styling/",
								$hl => array(
									$dp => array('layerselected::text||button'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#form_layerstyle_font', 
									$f => "#layer_selectable"
								)
							)
						),
						'svg' => array(
							'originalColor' => array(
								$t => __("SVG Original Color", 'revsliderhelp'),
								$h => "idle.svg.originalColor",
								$k => array("svg", "svg color", "layer svg", "svg original color", "original color"),
								$d => __("Disable this option to change color of svg elements in layer", 'revsliderhelp'),
								$a => $u . "font-colors-styling/",
								$hl => array(
									$dp => array('layerselected::object'), 
									$m => "#module_layers_trigger, #gst_layer_3, #", 
									$st => '#form_layerstyle_svg', 
									$f => "*[data-r='idle.svg.originalColor']"
								)
							),
							'color' => array(
								$t => __("SVG Color", 'revsliderhelp'),
								$h => "idle.svg.color.#size#.v",
								$k => array("svg", "svg color", "layer svg", "svg icon", "icon"),
								$d => __("The color of the currently selected SVG Layer", 'revsliderhelp'),
								$a => $u . "font-colors-styling/",
								$hl => array(
									$dp => array('layerselected::object'), 
									$m => "#module_layers_trigger, #gst_layer_3, #", 
									$st => '#form_layerstyle_svg', 
									$f => "#layerSVGColor"
								)
							),
							'stroke_color' => array(
								$t => __("Stroke/Border Color", 'revsliderhelp'),
								$h => "idle.svg.strokeColor",
								$k => array("svg", "svg stroke", "svg border", "svg stroke color", "border color", "stroke color", "layer svg", "svg icon", "icon"),
								$d => __("The border/stroke color of the currently selected SVG Layer", 'revsliderhelp'),
								$a => $u . "font-colors-styling/",
								$hl => array(
									$dp => array('layerselected::object'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#layerStrokeColor', 
									$f => "#layerStrokeColor"
								)
							),
							'stroke_width' => array(
								$t => __("Stroke/Border Width/Size", 'revsliderhelp'),
								$h => "idle.svg.strokeWidth",
								$k => array("svg", "svg border", "layer svg", "svg icon", "icon", "svg stroke width", "stroke size", "svg border size", "svg border width"),
								$d => __("The border/stroke width/size of the currently selected SVG Layer", 'revsliderhelp'),
								$a => $u . "font-colors-styling/",
								$hl => array(
									$dp => array('layerselected::object'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#form_layerstyle_svg', 
									$f => "*[data-r='idle.svg.strokeWidth']"
								)
							),
							'dash' => array(
								$t => __("Dash-Array", 'revsliderhelp'),
								$h => "idle.svg.strokeDashArray",
								$k => array("svg", "svg dash", "svg dash array", "svg dash-array", "dash-array", "dash array"),
								$d => __("The <a href='https://developer.mozilla.org/en-US/docs/Web/SVG/Attribute/stroke-dasharray' target='_blank'>dash-array</a> for the currently selected SVG.  Displays the SVG stroke/border as dashes.", 'revsliderhelp'),
								$a => $u . "font-colors-styling/",
								$hl => array(
									$dp => array('layerselected::object'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#form_layerstyle_svg', 
									$f => "*[data-r='idle.svg.strokeDashArray']"
								)
							),
							'dash_offset' => array(
								$t => __("Dash-Array Offset", 'revsliderhelp'),
								$h => "idle.svg.strokeDashOffset",
								$k => array("svg", "svg dash", "svg dash offset", "svg dash-array", "dash-array", "dash array", "dash offset"),
								$d => __("The <a href='https://developer.mozilla.org/en-US/docs/Web/SVG/Attribute/stroke-dashoffset' target='_blank'>stroke-dash-offset</a> for the currently selected SVG", 'revsliderhelp'),
								$a => $u . "font-colors-styling/",
								$hl => array(
									$dp => array('layerselected::object'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#form_layerstyle_svg', 
									$f => "*[data-r='idle.svg.strokeDashOffset']"
								)
							),
							'styleAll' => array(
								$t => __("SVG Style All Elements", 'revsliderhelp'),
								$h => "idle.svg.styleAll",
								$k => array("svg", "svg color", "layer svg", "svg style all", "style all elements"),
								$d => __("By default only SVG path gets custom style, Enabling this option will style all svg elements like ellipse, polygon etc", 'revsliderhelp'),
								$a => $u . "font-colors-styling/",
								$hl => array(
									$dp => array('layerselected::object'), 
									$m => "#module_layers_trigger, #gst_layer_3, #", 
									$st => '#form_layerstyle_svg', 
									$f => "*[data-r='idle.svg.styleAll']"
								)
							)
						),
						'background' => array(
							'bg_color' => array(
								$t => __("Background Color", 'revsliderhelp'),
								$h => "idle.backgroundColor",
								$k => array("bg", "background", "background color", "layer background", "layer background color", "layer bg", "bg color"),
								$d => __("Set a background color for the Layer", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#background",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#form_layerstyle_bg', 
									$f => "#layerBGColor"
								)
							),
							'bg_image' => array(
								$t => __("Background Image", 'revsliderhelp'),
								$h => "idle.backgroundImage",
								$k => array("bg", "background", "background image", "layer background", "layer background image", "layer bg", "image background"),
								$d => __("Set a background image for the Layer", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#background",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#form_layerstyle_bg', 
									$f => "*[data-r='idle.backgroundImage']{first}"
								)
							),
							'position' => array(
								$t => __("BG Image Position", 'revsliderhelp'),
								$h => "idle.backgroundPosition",
								$k => array("image", "images", "background", "bg", "bg image", "background position"),
								$d => __("The CSS background-position for the Layer's background image", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#background",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#form_layerstyle_bg', 
									$f => "#layer_bg_position_center-center"
								)
							),
							'fit' => array(
								$t => __("BG Image Fit", 'revsliderhelp'),
								$h => "idle.backgroundSize",
								$k => array("background size", "fit", "image fit", "cover", "contain"),
								$d => __("The css background-size value for the Layer's background image", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#background",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#form_layerstyle_bg', 
									$f => "#layer_bgimage_fit"
								)
							),
							'repeat' => array(
								$t => __("BG Image Repeat", 'revsliderhelp'),
								$h => "idle.backgroundRepeat",
								$k => array("background repeat", "repeat"),
								$d => __("The css background-repeat value for the Layer's background image", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#background",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#form_layerstyle_bg', 
									$f => "#layer_bgimage_repeat"
								)
							)
						),
						'margins' => array(
							'margin_top' => array(
								$t => __("Margin Top", 'revsliderhelp'),
								$h => "idle.margin.#size#.v.0",
								$k => array("layer margin", "layers margin", "margin top", "margin-top"),
								$d => __("The top margin for the currently Selected Layer.  Useful for rows/columns.", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#spacings-border",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#form_layerstyle_space', 
									$f => "*[data-r='idle.margin.#size#.v.0']"
								)
							),
							'margin_right' => array(
								$t => __("Margin Right", 'revsliderhelp'),
								$h => "idle.margin.#size#.v.1",
								$k => array("layer margin", "layers margin", "margin right", "margin-right"),
								$d => __("The right margin for the currently Selected Layer.  Useful for rows/columns.", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#spacings-border",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#form_layerstyle_space', 
									$f => "*[data-r='idle.margin.#size#.v.1']"
								)
							),
							'margin_bottom' => array(
								$t => __("Margin Bottom", 'revsliderhelp'),
								$h => "idle.margin.#size#.v.2",
								$k => array("layer margin", "layers margin", "margin bottom", "margin-bottom"),
								$d => __("The bottom margin for the currently Selected Layer.  Useful for rows/columns.", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#spacings-border",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#form_layerstyle_space', 
									$f => "*[data-r='idle.margin.#size#.v.2']"
								)
							),
							'margin_left' => array(
								$t => __("Margin Left", 'revsliderhelp'),
								$h => "idle.margin.#size#.v.3",
								$k => array("layer margin", "layers margin", "margin left", "margin-left"),
								$d => __("The left margin for the currently Selected Layer.  Useful for rows/columns.", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#spacings-border",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#form_layerstyle_space', 
									$f => "*[data-r='idle.margin.#size#.v.3']"
								)
							)
						),
						'paddings' => array(
							'padding_top' => array(
								$t => __("Padding Top", 'revsliderhelp'),
								$h => "idle.padding.#size#.v.0",
								$k => array("layer padding", "layers padding", "padding top", "padding-top"),
								$d => __("The top padding for the currently Selected Layer", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#spacings-border",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#form_layerstyle_space', 
									$f => "#idle_layer_padding_top"
								)
							),
							'padding_right' => array(
								$t => __("Padding Right", 'revsliderhelp'),
								$h => "idle.padding.#size#.v.1",
								$k => array("layer padding", "layers padding", "padding right", "padding-right"),
								$d => __("The right padding for the currently Selected Layer", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#spacings-border",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#form_layerstyle_space', 
									$f => "*[data-r='idle.padding.#size#.v.1']"
								)
							),
							'padding_bottom' => array(
								$t => __("Padding Bottom", 'revsliderhelp'),
								$h => "idle.padding.#size#.v.2",
								$k => array("layer padding", "layers padding", "padding bottom", "padding-bottom"),
								$d => __("The bottom padding for the currently Selected Layer", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#spacings-border",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#form_layerstyle_space', 
									$f => "*[data-r='idle.padding.#size#.v.2']"
								)
							),
							'padding_left' => array(
								$t => __("Padding Left", 'revsliderhelp'),
								$h => "idle.padding.#size#.v.3",
								$k => array("layer padding", "layers padding", "padding left", "padding-left"),
								$d => __("The left padding for the currently Selected Layer", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#spacings-border",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#form_layerstyle_space', 
									$f => "*[data-r='idle.padding.#size#.v.3']"
								)
							)
						),
						'border' => array(
							'border_color' => array(
								$t => __("Border Color", 'revsliderhelp'),
								$h => "idle.borderColor",
								$k => array("border", "border color", "layer border", "layer border color", "layers border"),
								$d => __("Add a border to the Layer's HTML element", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#spacings-border",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#form_layerstyle_border', 
									$f => "#layerBorderColor"
								)
							),
							'border_style' => array(
								$t => __("Border Style", 'revsliderhelp'),
								$h => "idle.borderStyle.#size#.v",
								$k => array("border", "border style", "layer border", "layer border style", "layers border"),
								$d => __("The <a href='https://www.w3schools.com/cssref/pr_border-style.asp' target='_blank'>CSS border-style</a> to use for the Layer's border", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#spacings-border",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#form_layerstyle_border', 
									$f => "#layer_border_style"
								)
							),
							'border_width_top' => array(
								$t => __("Border Top Size", 'revsliderhelp'),
								$h => "idle.borderWidth.0",
								$k => array("border", "border size", "layer border", "layer border size", "layers border", "border-width"),
								$d => __("The border's top size (border-top-width)", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#spacings-border",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#form_layerstyle_border', 
									$f => "*[data-r='idle.borderWidth.0']"
								)
							),
							'border_width_right' => array(
								$t => __("Border Right Size", 'revsliderhelp'),
								$h => "idle.borderWidth.1",
								$k => array("border", "border size", "layer border", "layer border size", "layers border", "border-width"),
								$d => __("The border's right size (border-right-width)", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#spacings-border",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#form_layerstyle_border', 
									$f => "*[data-r='idle.borderWidth.1']"
								)
							),
							'border_width_bottom' => array(
								$t => __("Border Bottom Size", 'revsliderhelp'),
								$h => "idle.borderWidth.2",
								$k => array("border", "border size", "layer border", "layer border size", "layers border", "border-width"),
								$d => __("The border's bottom size (border-bottom-width)", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#spacings-border",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#form_layerstyle_border', 
									$f => "*[data-r='idle.borderWidth.2']"
								)
							),
							'border_width_left' => array(
								$t => __("Border Left Size", 'revsliderhelp'),
								$h => "idle.borderWidth.3",
								$k => array("border", "border size", "layer border", "layer border size", "layers border", "border-width"),
								$d => __("The border's left size (border-left-width)", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#spacings-border",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#form_layerstyle_border', 
									$f => "*[data-r='idle.borderWidth.3']"
								)
							)
						),
						'border_radius' => array(
							'border_radius_top_left' => array(
								$t => __("Border Radius Top Left", 'revsliderhelp'),
								$h => "idle.borderRadius.v.0",
								$k => array("border radius", "border-radius", "layer border radius", "layer border-radius"),
								$d => __("The top-left corner border-radius (px or %)", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#spacings-border",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#form_layerstyle_border', 
									$f => "*[data-r='idle.borderRadius.v.0']"
								)
							),
							'border_radius_top_right' => array(
								$t => __("Border Radius Top Right", 'revsliderhelp'),
								$h => "idle.borderRadius.v.1",
								$k => array("border radius", "border-radius", "layer border radius", "layer border-radius"),
								$d => __("The top-right corner border-radius (px or %)", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#spacings-border",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#form_layerstyle_border', 
									$f => "*[data-r='idle.borderRadius.v.1']"
								)
							),
							'border_radius_bottom_left' => array(
								$t => __("Border Radius Bottom Left", 'revsliderhelp'),
								$h => "idle.borderRadius.v.2",
								$k => array("border radius", "border-radius", "layer border radius", "layer border-radius"),
								$d => __("The bottom-left corner border-radius (px or %)", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#spacings-border",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#form_layerstyle_border', 
									$f => "*[data-r='idle.borderRadius.v.2']"
								)
							),
							'border_radius_bottom_right' => array(
								$t => __("Border Radius Bottom Right", 'revsliderhelp'),
								$h => "idle.borderRadius.v.3",
								$k => array("border radius", "border-radius", "layer border radius", "layer border-radius"),
								$d => __("The bottom-right corner border-radius (px or %)", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#spacings-border",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_3", 
									$st => '#form_layerstyle_border', 
									$f => "*[data-r='idle.borderRadius.v.3']"
								)
							)
						)
					),
					'gst_layer_2' => array(
						'horizontal_align' => array(
							$t => __("Horizontal Align", 'revsliderhelp'),
							$h => "position.horizontal.#size#.v",
							$k => array("align", "alignment", "layer align", "position", "layer position", "layer alignment", "horizontal align"),
							$d => __("Align the Layer horizontally to the Slider content or the entire Slider", 'revsliderhelp'),
							$a => $u . "size-position/",
							$hl => array(
								$dp => array('layerselected'), 
								$m => "#module_layers_trigger, #gst_layer_2", 
								$st => '#form_layerposition_basic', 
								$f => ".layer_hor_selector.selected"
							)
						),
						'vertical_align' => array(
							$t => __("Vertical Align", 'revsliderhelp'),
							$h => "position.vertical.#size#.v",
							$k => array("align", "alignment", "layer align", "position", "layer position", "layer alignment", "vertical align"),
							$d => __("Align the Layer vertically to the Slider content or the entire Slider", 'revsliderhelp'),
							$a => $u . "size-position/",
							$hl => array(
								$dp => array('layerselected'), 
								$m => "#module_layers_trigger, #gst_layer_2", 
								$st => '#form_layerposition_basic', 
								$f => ".layer_ver_selector.selected"
							)
						),
						'offsetx' => array(
							$t => __("Offset X", 'revsliderhelp'),
							$h => "position.x.#size#.v",
							$k => array("layer position", "layer offset"),
							$d => __("Offset the Layer's horizontal position by this amount.  Accepts positive and negative values.", 'revsliderhelp'),
							$a => $u . "size-position/",
							$hl => array(
								$dp => array('layerselected'), 
								$m => "#module_layers_trigger, #gst_layer_2", 
								$st => '#form_layerposition_basic', 
								$f => "#layer_pos_x"
							)
						),
						'offsety' => array(
							$t => __("Offset Y", 'revsliderhelp'),
							$h => "position.y.#size#.v",
							$k => array("layer position", "layer offset"),
							$d => __("Offset the Layer's vertical position by this amount.  Accepts positive and negative values.", 'revsliderhelp'),
							$a => $u . "size-position/",
							$hl => array(
								$dp => array('layerselected'), 
								$m => "#module_layers_trigger, #gst_layer_2", 
								$st => '#form_layerposition_basic', 
								$f => "#layer_pos_y"
							)
						),
						'width' => array(
							$t => __("Layer Width", 'revsliderhelp'),
							$h => "size.width.#size#.v",
							$k => array("layer width", "layers width", "layer size", "layers size"),
							$d => __("The Layer's width for the current device viewport", 'revsliderhelp'),
							$a => $u . "size-position/",
							$hl => array(
								$dp => array('layerselected'), 
								$m => "#module_layers_trigger, #gst_layer_2", 
								$st => '#form_layerposition_basic', 
								$f => "#layer_width"
							)
						),
						'height' => array(
							$t => __("Layer Height", 'revsliderhelp'),
							$h => "size.height.#size#.v",
							$k => array("layer height", "layers height", "layer size", "layers size"),
							$d => __("The Layer's height for the current device viewport", 'revsliderhelp'),
							$a => $u . "size-position/",
							$hl => array(
								$dp => array('layerselected'), 
								$m => "#module_layers_trigger, #gst_layer_2", 
								$st => '#form_layerposition_basic', 
								$f => "#layer_height"
							)
						),
						'size_presets' => array(
							$t => __("Size Presets", 'revsliderhelp'),
							$h => "size.covermode",
							$k => array("size presets", "full width", "full height", "stretch", "cover"),
							$d => __("Choose to set the Layer's width/height as full-width, full-height.  'Stretch' will be 100% width/height, 'Cover' will maintain aspect ratio.", 'revsliderhelp'),
							$a => $u . "size-position/",
							$hl => array(
								$dp => array('layerselected::image||video||shape'), 
								$m => "#module_layers_trigger, #gst_layer_2", 
								$st => '#form_layerposition_basic', 
								$f => "#layer_covermode"
							)
						),
						'align_by' => array(
							$t => __("Align By Slider/Content", 'revsliderhelp'),
							$h => "behavior.baseAlign",
							$k => array("layers", "layer align", "layer alignment"),
							$d => __("Choose 'Slider' to align based on the Slider's full display, or 'Content' to align against the Slider's grid area", 'revsliderhelp'),
							$a => $u . "size-position/",
							$hl => array(
								$dp => array('layerselected'), 
								$m => "#module_layers_trigger, #gst_layer_2", 
								$st => '#form_layerposition_basic', 
								$f => "*[name='layer_within_align']:checked"
							)
						),
						'additional_settings' => array(
							'min_width' => array(
								$t => __("Minimum Width", 'revsliderhelp'),
								$h => "size.minWidth.#size#.v",
								$k => array("layer min-width", "layers min-width", "layer size", "layers size"),
								$d => __("The Layer's <a href='https://www.w3schools.com/cssref/pr_dim_min-width.asp' target='_blank'>CSS min-width</a> for the current device viewport", 'revsliderhelp'),
								$a => $u . "size-position/",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_2", 
									$st => '#form_layerposition_additional', 
									$f => "#layer_min_width"
								)
							),
							'max_width' => array(
								$t => __("Maximum Width", 'revsliderhelp'),
								$h => "size.maxWidth.#size#.v",
								$k => array("layer max-width", "layers max-width", "layer size", "layers size"),
								$d => __("The Layer's <a href='https://www.w3schools.com/cssref/pr_dim_max-width.asp' target='_blank'>CSS max-width</a> for the current device viewport", 'revsliderhelp'),
								$a => $u . "size-position/",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_2", 
									$st => '#form_layerposition_additional', 
									$f => "#layer_max_width"
								)
							),
							'min_height' => array(
								$t => __("Minimum Height", 'revsliderhelp'),
								$h => "size.minHeight.#size#.v",
								$k => array("layer min-height", "layers min-height", "layer size", "layers size"),
								$d => __("The Layer's <a href='https://www.w3schools.com/cssref/pr_dim_min-height.asp' target='_blank'>CSS min-height</a> for the current device viewport", 'revsliderhelp'),
								$a => $u . "size-position/",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_2", 
									$st => '#form_layerposition_additional', 
									$f => "#layer_min_height"
								)
							),
							'max_height' => array(
								$t => __("Maximum Height", 'revsliderhelp'),
								$h => "size.maxHeight.#size#.v",
								$k => array("layer height", "layers height", "layer size", "layers size"),
								$d => __("The Layer's <a href='https://www.w3schools.com/cssref/pr_dim_max-height.asp' target='_blank'>CSS max-height</a> for the current device viewport", 'revsliderhelp'),
								$a => $u . "size-position/",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_2", 
									$st => '#form_layerposition_additional', 
									$f => "#layer_max_height"
								)
							)
						),
						'responsive_behavior' => array(
							'intelligent_inheriting' => array(
								$di => "layers_intelligent_inheriting",
								$t => __("Intelligent Inheriting", 'revsliderhelp'),
								$h => "behavior.intelligentInherit",
								$k => array("responsive", "intelligent inheriting", "responsive behavior"),
								$d => __("Automatically resize/reposition new Layers for each device viewport inside the editor", 'revsliderhelp'),
								$a => $u . "size-position/",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_2", 
									$st => '#form_layerposition_advanced', 
									$f => "#layer_behavior_intelSize"
								)								
							),
							'inherit_from_desktop' => array(
								$t => __("Inherit from Desktop", 'revsliderhelp'),
								$h => "resetIntelligentInherits",
								$k => array("responsive behavior", "inherit all values", "inherit all values from desktop", "intelligent inheriting"),
								$d => __("Automatically resize/reposition all Layers for each device viewport inside the editor", 'revsliderhelp'),
								$a => $u . "size-position/",
								$hl => array(
									$dp => array('layerselected', array($p => '#slide#.layers.#layer#.behavior.intelligentInherit', $v => true, $o => 'layers_intelligent_inheriting')), 
									$m => "#module_layers_trigger, #gst_layer_2", 
									$st => '#form_layerposition_advanced', 
									$f => "#intelligent_buttons_true"
								)
							),
							'reset_from_desktop' => array(
								$t => __("Reset from Desktop", 'revsliderhelp'),
								$h => "inheritValuesFromDesktop",
								$k => array("responsive behavior", "reset all values", "reset all values from desktop", "intelligent inheriting"),
								$d => __("Reset the size/position of all Layers to their desktop values for each viewport inside the editor", 'revsliderhelp'),
								$a => $u . "size-position/",
								$hl => array(
									$dp => array('layerselected', array($p => '#slide#.layers.#layer#.behavior.intelligentInherit', $v => false, $o => 'layers_intelligent_inheriting')),  
									$m => "#module_layers_trigger, #gst_layer_2", 
									$st => '#form_layerposition_advanced', 
									$f => "#intelligent_buttons_false"
								)
							),
							'resize_between_devices' => array(
								$t => __("Resize Between Devices", 'revsliderhelp'),
								$h => "behavior.autoResponsive",
								$k => array("responsive", "resize", "resize layers", "resize layer", "layer resizing", "layer sizing", "responsive sizes", "responsive sizing"),
								$d => __("Automatically resize Layers for each responsive device viewport", 'revsliderhelp'),
								$a => $u . "size-position/",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_2", 
									$st => '#form_layerposition_advanced', 
									$f => "#layer_behavior_autoResponsive"
								)
							),
							'responsive_offsets' => array(
								$t => __("Responsive Offsets", 'revsliderhelp'),
								$h => "behavior.responsiveOffset",
								$k => array("responsive", "responsive offset", "responsive offsets"),
								$d => __("Automatically adjust the positioning for Layers for each responsive device viewport", 'revsliderhelp'),
								$a => $u . "size-position/",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_2", 
									$st => '#form_layerposition_advanced', 
									$f => "#layer_behavior_responsiveOffset"
								)
							),
							'responsive_children' => array(
								$t => __("Responsive Children", 'revsliderhelp'),
								$h => "behavior.responsiveChilds",
								$k => array("responsive", "responsive children"),
								$d => __("Choose to resize the Layer's inner HTML elements if the Layer includes custom HTML", 'revsliderhelp'),
								$a => $u . "size-position/",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_2", 
									$st => '#form_layerposition_advanced', 
									$f => "#layer_behavior_responsiveChilds"
								)
							)
						),
					),
					'gst_layer_6' => array(
						'basic_transforms' => array(
							'rotationx' => array(
								$t => __("Rotation X", 'revsliderhelp'),
								$h => "idle.rotationX",
								$k => array("advanced style", "transform", "rotation", "rotationx"),
								$d => __("Add a <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/transform-function/rotateX' target='_blank'>rotateX</a> transform to the currently selected Layer", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#advanced-style",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_6", 
									$st => '#form_basic_transforms', 
									$f => "*[data-r='idle.rotationX']"
								)
							),
							'rotationy' => array(
								$t => __("Rotation Y", 'revsliderhelp'),
								$h => "idle.rotationY",
								$k => array("advanced style", "transform", "rotation", "rotationx"),
								$d => __("Add a <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/transform-function/rotateY' target='_blank'>rotateY</a> transform to the currently selected Layer", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#advanced-style",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_6", 
									$st => '#form_basic_transforms', 
									$f => "*[data-r='idle.rotationY']"
								)
							),
							'rotationz' => array(
								$t => __("Rotation Z", 'revsliderhelp'),
								$h => "idle.rotationZ",
								$k => array("advanced style", "transform", "rotation", "rotationx"),
								$d => __("Add a <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/transform-function/rotateZ' target='_blank'>rotateZ</a> transform to the currently selected Layer", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#advanced-style",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_6", 
									$st => '#form_basic_transforms', 
									$f => "*[data-r='idle.rotationZ']"
								)
							),
							'opacity' => array(
								$t => __("Opacity", 'revsliderhelp'),
								$h => "idle.opacity",
								$k => array("advanced style", "transform", "opacity"),
								$d => __("Adjust the opacity/transparency for the currently selected Layer", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#advanced-style",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_6", 
									$st => '#form_layerstyle_bg', 
									$f => "*[data-r='idle.opacity']"
								)
							)
						),
						'box_shadow' => array(
							'enable' => array(
								$t => __("Enable Box Shadow", 'revsliderhelp'),
								$h => "idle.boxShadow.inuse",
								$k => array("box shadow", "box-shadow", "layer box-shadow", "layer box shadow", "boxshadow"),
								$d => __("Add a <a href='https://www.w3schools.com/cssref/css3_pr_box-shadow.asp' target='_blank'>CSS box-shadow</a> to the currently selected Layer", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#advanced-style",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_6", 
									$st => '#form_layerstyle_bg', 
									$f => "*[data-r='idle.boxShadow.inuse']"
								)
							),
							'container' => array(
								$t => __("Apply Shadow to", 'revsliderhelp'),
								$h => "idle.boxShadow.container",
								$k => array("box shadow", "box shadow container", "shadow on"),
								$d => __("'Wrapper Container' is the Layer's outer-most HTML wrapper div, and 'Layer Container' is the content's main div", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#advanced-style",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_6", 
									$st => '#form_layerstyle_bg', 
									$f => "*[data-r='idle.boxShadow.container']:checked"
								)
							),
							'offsetx' => array(
								$t => __("Offset X", 'revsliderhelp'),
								$h => "idle.boxShadow.hoffset.#size#.v",
								$k => array("box shadow offset", "box shadow offset x", "shadow offset"),
								$d => __("The horizontal offset for the <a href='https://www.w3schools.com/cssref/css3_pr_box-shadow.asp' target='_blank'>box-shadow</a>", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#advanced-style",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_6", 
									$st => '#form_layerstyle_bg', 
									$f => "*[data-r='idle.boxShadow.hoffset.#size#.v']"
								)
							),
							'offsety' => array(
								$t => __("Offset Y", 'revsliderhelp'),
								$h => "idle.boxShadow.voffset.#size#.v",
								$k => array("box shadow offset", "box shadow offset y", "shadow offset"),
								$d => __("The vertical offset for the <a href='https://www.w3schools.com/cssref/css3_pr_box-shadow.asp' target='_blank'>box-shadow</a>", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#advanced-style",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_6", 
									$st => '#form_layerstyle_bg', 
									$f => "*[data-r='idle.boxShadow.voffset.#size#.v']"
								)
							),
							'blur' => array(
								$t => __("Blur Radius", 'revsliderhelp'),
								$h => "idle.boxShadow.blur.#size#.v",
								$k => array("box shadow blur", "box shadow blur radius", "blur radius"),
								$d => __("The blur-radius value for the Layer's <a href='https://www.w3schools.com/cssref/css3_pr_box-shadow.asp' target='_blank'>box-shadow</a>", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#advanced-style",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_6", 
									$st => '#form_layerstyle_bg', 
									$f => "*[data-r='idle.boxShadow.blur.#size#.v']"
								)
							),
							'spread' => array(
								$t => __("Spread", 'revsliderhelp'),
								$h => "idle.boxShadow.spread.#size#.v",
								$k => array("box shadow spread", "box shadow strength"),
								$d => __("The spread value for the Layer's <a href='https://www.w3schools.com/cssref/css3_pr_box-shadow.asp' target='_blank'>box-shadow</a>", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#advanced-style",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_6", 
									$st => '#form_layerstyle_bg', 
									$f => "*[data-r='idle.boxShadow.spread.#size#.v']"
								)
							),
							'color' => array(
								$t => __("Shadow Color", 'revsliderhelp'),
								$h => "idle.boxShadow.color",
								$k => array("box shadow color", "shadow color", "box-shadow color"),
								$d => __("The rgba color for the Layer's <a href='https://www.w3schools.com/cssref/css3_pr_box-shadow.asp' target='_blank'>box-shadow</a>", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#advanced-style",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_6", 
									$st => '#form_layerstyle_bg', 
									$f => "#boxShadowColor"
								)
							)
						),
						'text_shadow' => array(
							'enable' => array(
								$t => __("Enable Text Shadow", 'revsliderhelp'),
								$h => "idle.textShadow.inuse",
								$k => array("text shadow", "text-shadow", "layer text-shadow", "layer text shadow", "textshadow"),
								$d => __("Add a <a href='https://www.w3schools.com/CSSref/css3_pr_text-shadow.asp' target='_blank'>CSS text-shadow</a> to the currently selected Layer", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#advanced-style",
								$hl => array(
									$dp => array('layerselected::text'), 
									$m => "#module_layers_trigger, #gst_layer_6", 
									$st => '#form_layerstyle_bg._shft_', 
									$f => "*[data-r='idle.textShadow.inuse']"
								)
							),
							'offsetx' => array(
								$t => __("Offset X", 'revsliderhelp'),
								$h => "idle.textShadow.hoffset.#size#.v",
								$k => array("text shadow offset", "text shadow offset x", "shadow offset"),
								$d => __("The horizontal offset for the <a href='https://www.w3schools.com/CSSref/css3_pr_text-shadow.asp' target='_blank'>text-shadow</a>", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#advanced-style",
								$hl => array(
									$dp => array('layerselected::text'), 
									$m => "#module_layers_trigger, #gst_layer_6", 
									$st => '#form_layerstyle_bg._shft_', 
									$f => "*[data-r='idle.textShadow.hoffset.#size#.v']"
								)
							),
							'offsety' => array(
								$t => __("Offset Y", 'revsliderhelp'),
								$h => "idle.textShadow.voffset.#size#.v",
								$k => array("text shadow offset", "text shadow offset y", "shadow offset"),
								$d => __("The vertical offset for the <a href='https://www.w3schools.com/CSSref/css3_pr_text-shadow.asp' target='_blank'>text-shadow</a>", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#advanced-style",
								$hl => array(
									$dp => array('layerselected::text'), 
									$m => "#module_layers_trigger, #gst_layer_6", 
									$st => '#form_layerstyle_bg._shft_', 
									$f => "*[data-r='idle.textShadow.voffset.#size#.v']"
								)
							),
							'blur' => array(
								$t => __("Blur Radius", 'revsliderhelp'),
								$h => "idle.textShadow.blur.#size#.v",
								$k => array("text shadow blur", "text shadow blur radius", "blur radius"),
								$d => __("The blur-radius value for the Layer's <a href='https://www.w3schools.com/CSSref/css3_pr_text-shadow.asp' target='_blank'>text-shadow</a>", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#advanced-style",
								$hl => array(
									$dp => array('layerselected::text'), 
									$m => "#module_layers_trigger, #gst_layer_6", 
									$st => '#form_layerstyle_bg._shft_', 
									$f => "*[data-r='idle.textShadow.blur.#size#.v']"
								)
							),
							'color' => array(
								$t => __("Shadow Color", 'revsliderhelp'),
								$h => "idle.textShadow.color",
								$k => array("text shadow color", "shadow color", "text-shadow color"),
								$d => __("The rgba color for the Layer's <a href='https://www.w3schools.com/CSSref/css3_pr_text-shadow.asp' target='_blank'>text-shadow</a>", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#advanced-style",
								$hl => array(
									$dp => array('layerselected::text'), 
									$m => "#module_layers_trigger, #gst_layer_6", 
									$st => '#form_layerstyle_bg._shft_', 
									$f => "#textShadowColor"
								)
							)
						),
						'blend_mode' => array(
							'filter' => array(
								$t => __("Blend Mode Filter", 'revsliderhelp'),
								$h => "idle.filter.blendMode",
								$k => array("blend mode", "blend mode filter", "filter", "layer blend mode", "blend-mode"),
								$d => __("The CSS <a href='https://www.w3schools.com/cssref/pr_background-blend-mode.asp' target='_blank'>background-blend-mode</a> filter for the currently selected Layer", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#advanced-style",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_6", 
									$st => '#form_layerstyle_css', 
									$f => "*[data-r='idle.filter.blendMode']"
								)
							),
							'show_in_editor' => array(
								$t => __("Show in Editor Preview", 'revsliderhelp'),
								$h => "idle.filter.showInEditor",
								$k => array("blend mode", "blend mode filter", "filter", "layer blend mode", "blend-mode", "show in editor"),
								$d => __("Show the blend-mode both live in the Slider and also in the admin editing stage", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#advanced-style",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_6", 
									$st => '#form_layerstyle_css', 
									$f => "*[data-r='idle.filter.showInEditor']"
								)
							)
						),
						'spike_masks' => array(
							'enable' => array(
								$di => 'spike_masks',
								$t => __("Enable Spike Masks", 'revsliderhelp'),
								$h => "idle.spikeUse",
								$k => array("advanced style", "spikes", "corner", "spike", "corners"),
								$d => __("Add creative edges and corners to your content", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#advanced-style",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_6", 
									$st => '#form_layer_spiketyle', 
									$f => "#layer_userSpikes"
								)
							),
							'left_spike' => array(
								$t => __("Left Spike", 'revsliderhelp'),
								$h => "idle.spikeLeft",
								$k => array("advanced style", "spikes", "corner", "spike", "corners"),
								$d => __("Add creative edges and corners to the left side of your content", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#advanced-style",
								$hl => array(
									$dp => array(
										'layerselected',
										array($p => '#slide#.layers.#layer#.idle.spikeUse', $v => true, $o => 'spike_masks')
									), 
									$m => "#module_layers_trigger, #gst_layer_6", 
									$st => '#form_layer_spiketyle', 
									$f => "#layer_leftspiketype"
								)
							),
							'left_spike_width' => array(
								$t => __("Left Spike Width", 'revsliderhelp'),
								$h => "idle.spikeLeftWidth",
								$k => array("advanced style", "spikes", "corner", "spike", "corners"),
								$d => __("The percentage of your content's width to use when the spike(s) are drawn on the left side", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#advanced-style",
								$hl => array(
									$dp => array(
										'layerselected',
										array($p => '#slide#.layers.#layer#.idle.spikeUse', $v => true, $o => 'spike_masks')
									), 
									$m => "#module_layers_trigger, #gst_layer_6", 
									$st => '#form_layer_spiketyle', 
									$f => "*[data-r='idle.spikeLeftWidth']"
								)
							),
							'right_spike' => array(
								$t => __("Enable Spike Masks", 'revsliderhelp'),
								$h => "idle.spikeRight",
								$k => array("advanced style", "spikes", "corner", "spike", "corners"),
								$d => __("Add creative edges and corners to the right side of your content", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#advanced-style",
								$hl => array(
									$dp => array(
										'layerselected',
										array($p => '#slide#.layers.#layer#.idle.spikeUse', $v => true, $o => 'spike_masks')
									), 
									$m => "#module_layers_trigger, #gst_layer_6", 
									$st => '#form_layer_spiketyle', 
									$f => "#layer_rightspiketype"
								)
							),
							'right_spike_width' => array(
								$t => __("Right Spike Width", 'revsliderhelp'),
								$h => "idle.spikeRightWidth",
								$k => array("advanced style", "spikes", "corner", "spike", "corners"),
								$d => __("The percentage of your content's width to use when the spike(s) are drawn on the right side", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#advanced-style",
								$hl => array(
									$dp => array(
										'layerselected',
										array($p => '#slide#.layers.#layer#.idle.spikeUse', $v => true, $o => 'spike_masks')
									), 
									$m => "#module_layers_trigger, #gst_layer_6", 
									$st => '#form_layer_spiketyle', 
									$f => "*[data-r='idle.spikeRightWidth']"
								)
							)
						),
						'sharp_corners' => array(
							'left_corner' => array(
								$t => __("Left Corner", 'revsliderhelp'),
								$h => "idle.cornerLeft",
								$k => array("advanced style", "corner", "sharp", "sharp corners", "corners"),
								$d => __("Mask your content with diagonal slice from the left side", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#advanced-style",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_6", 
									$st => '#form_layer_cornertyle', 
									$f => "#layer_leftcornertype"
								)
							),
							'right_corner' => array(
								$t => __("Right Corner", 'revsliderhelp'),
								$h => "idle.cornerRight",
								$k => array("advanced style", "corner", "sharp", "sharp corners", "corners"),
								$d => __("Mask your content with diagonal slice from the right side", 'revsliderhelp'),
								$a => $u . "font-colors-styling/#advanced-style",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_6", 
									$st => '#form_layer_cornertyle', 
									$f => "#layer_rightcornertype"
								)
							)
						)
					),
					'gst_layer_4' => array(
						'start_animation_from' => array(
							$t => __("Start/In Animation: From", 'revsliderhelp'),
							$h => "animation.in.from",
							$k => array("animation in", "animation from", "layer animation", "layers animation", "animation"),
							$d => __("The Layer animation's starting point values before it first animates into view", 'revsliderhelp'),
							$a => $u . "layer-animations/",
							$hl => array(
								$dp => array('layerselected'), 
								$m => "#module_layers_trigger, #gst_layer_4", 
								$st => '#form_animation_sframes', 
								$f => "#keyframe_list_el_frame_0 .frame_list_title{frame}"
							)
						),
						'start_animation_to' => array(
							$t => __("Start/In Animation: To", 'revsliderhelp'),
							$h => "animation.in.to",
							$k => array("animation in", "animation to", "layer animation", "layers animation", "animation"),
							$d => __("The ending values for the Layer's very first animation", 'revsliderhelp'),
							$a => $u . "layer-animations/",
							$hl => array(
								$dp => array('layerselected'), 
								$m => "#module_layers_trigger, #gst_layer_4", 
								$st => '#form_animation_sframes', 
								$f => "#keyframe_list_el_frame_1 .frame_list_title{frame}"
							)
						),
						'animation_to' => array(
							$t => __("Animate Again To...", 'revsliderhelp'),
							$h => "animation.keyframe.to",
							$k => array("animation keyframe", "animation to", "layer animation", "layers animation", "animation", "keyframe"),
							$d => __("An additional animation to add to the Layer after its already animated into view", 'revsliderhelp'),
							$a => $u . "layer-animations/",
							$hl => array(
								$dp => array('layerselected'), 
								$m => "#module_layers_trigger, #gst_layer_4", 
								$st => '#form_animation_sframes', 
								$f => "#keyframe_list_el_frame_2 .frame_list_titlekey{frame}"
							)
						),
						'end_animation_out' => array(
							$t => __("End/Out Animation: To", 'revsliderhelp'),
							$h => "animation.out.to",
							$k => array("animation out", "animation to", "layer animation", "layers animation", "animation"),
							$d => __("The Layer's final animation when it's meant to be hidden or when the Slide changes", 'revsliderhelp'),
							$a => $u . "layer-animations/",
							$hl => array(
								$dp => array('layerselected'), 
								$m => "#module_layers_trigger, #gst_layer_4", 
								$st => '#form_animation_sframes', 
								$f => "#keyframe_list_el_frame_999 .frame_list_title{frame}"
							)
						),
						'editor_view' => array(
							$t => __("Set as Editor View", 'revsliderhelp'),
							$h => "editorview",
							$k => array("animation out", "animation to", "layer animation", "layers animation", "animation", "editor view", "set as editor view"),
							$d => __("Set the selected animation point as the default view when editing your content", 'revsliderhelp'),
							$a => $u . "layer-animations/",
							$hl => array(
								$dp => array('layerselected'), 
								$m => "#module_layers_trigger, #gst_layer_4", 
								$st => '#form_animation_sframes', 
								$f => "#set_editor_view"
							)
						),
						'basics' => array(
							'alias' => array(
								$t => __("Animation Name", 'revsliderhelp'),
								$h => "#frame#.alias",
								$k => array("animation alias", "animation name"),
								$d => __("Give the animation a name for editing purposes", 'revsliderhelp'),
								$a => $u . "layer-animations/#duration-easing",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_4", 
									$st => '#form_animation_sframes:nth-child(2)', 
									$f => "#layerframename"
								)
							),
							'speed' => array(
								$t => __("Animation Speed", 'revsliderhelp'),
								$h => "#frame#.timeline.speed",
								$k => array("animation speed", "animation duration", "animation time"),
								$d => __("The total duration for the selected animation", 'revsliderhelp'),
								$a => $u . "layer-animations/#duration-easing",
								$hl => array(
									$dp => array('layerselected', '#keyframe_list_el_frame_1'), 
									$m => "#module_layers_trigger, #gst_layer_4", 
									$st => '#form_animation_sframes:nth-child(2)', 
									$f => "#layerframespeed"
								)
							),
							'easing' => array(
								$t => __("Animation Easing", 'revsliderhelp'),
								$h => "#frame#.timeline.ease",
								$k => array("animation easing", "easing"),
								$d => __("The easing equation to use for the selected animation", 'revsliderhelp'),
								$a => $u . "layer-animations/#duration-easing",
								$hl => array(
									$dp => array('layerselected', '#keyframe_list_el_frame_1'), 
									$m => "#module_layers_trigger, #gst_layer_4", 
									$st => '#form_animation_sframes:nth-child(2)', 
									$f => "*[data-r='#frame#.timeline.ease']"
								)
							),
							'wait_for_action' => array(
								$t => __("Wait for Action", 'revsliderhelp'),
								$h => "#frame#.timeline.actionTriggered",
								$k => array("animation", "action", "actions", "animations", "keyframe", "keyframes"),
								$d => __("The selected animation will only start when it's called from a <a href='http://docs.themepunch.com/slider-revolution/layer-actions/' target=_'blank'>Layer Action</a>", 'revsliderhelp'),
								$a => $u . "layer-animations/#duration-easing",
								$hl => array(
									$dp => array('layerselected', '#keyframe_list_el_frame_1'), 
									$m => "#module_layers_trigger, #gst_layer_4", 
									$st => '#form_animation_sframes:nth-child(2)', 
									$f => "*[data-r='#frame#.timeline.actionTriggered']"
								)
							)
						),
						'advanced' => array(
							'layer' => array(
								'opacity' => array(
									$t => __("Opacity", 'revsliderhelp'),
									$h => "#frame#.transform.opacity",
									$k => array("opacity", "animation opacity", "transparency", "show layer", "hide layer", "animate opacity"),
									$d => __("The Layer's opacity to apply to the currently selected animation frame", 'revsliderhelp'),
									$a => $u . "layer-animations/#advanced-settings",
									$hl => array(
										$dp => array('layerselected', '#layerbasic_ts_wrapbrtn .transtarget_selector'), 
										$m => "#module_layers_trigger, #gst_layer_4", 
										$st => '#form_animation_sframes:nth-child(3)', 
										$f => "#le_frame_opacity"
									)
								),
								'translate' => array(
									'translate_x' => array(
										$t => __("TranslateX", 'revsliderhelp'),
										$h => "#frame#.transform.x.#size#.v",
										$k => array("animation position", "layer animation position", "animate left", "animate right", "translatex"),
										$d => __("The 'x' (left) position to apply to the currently selected animation frame.  Accepts positive and negative numbers.", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array('layerselected', '#layerbasic_ts_wrapbrtn .transtarget_selector'), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "#le_frame_x"
										)
									),
									'translate_y' => array(
										$t => __("TranslateY", 'revsliderhelp'),
										$h => "#frame#.transform.y.#size#.v",
										$k => array("animation position", "layer animation position", "animate top", "animate bottom", "translatey"),
										$d => __("The 'y' (top) position to apply to the currently selected animation frame.  Accepts positive and negative numbers.", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array('layerselected', '#layerbasic_ts_wrapbrtn .transtarget_selector'), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "#le_frame_y"
										)
									),
									'translate_z' => array(
										$t => __("TranslateZ", 'revsliderhelp'),
										$h => "#frame#.transform.z",
										$k => array("animation depth", "animation z", "translatez", "3d"),
										$d => __("The <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/transform-function/translateZ' target=_'blank'>CSS translateZ</a> to apply to the selected animation frame.  This adds/removes 3D depth to the Layer", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array('layerselected', '#layerbasic_ts_wrapbrtn .transtarget_selector'), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "#le_frame_z"
										)
									),
									'perspective' => array(
										$t => __("Transform Perspective", 'revsliderhelp'),
										$h => "#frame#.transform.transformPerspective",
										$k => array("animation perspective", "perspective", "transform perspective", "transform-perspective", "3d"),
										$d => __("The <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/perspective' target=_'blank'>CSS perspective</a> to apply to the selected animation frame", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array('layerselected', '#layerbasic_ts_wrapbrtn .transtarget_selector'), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "#le_frame_perspective"
										)
									)
								),
								'scale_skew_rotate' => array(
									'scalex' => array(
										$t => __("scaleX", 'revsliderhelp'),
										$h => "#frame#.transform.scaleX",
										$k => array("animation scale", "animation scalex", "scalex", "scale x", "scale"),
										$d => __("Scale the Layer's width by this amount for the selected animation frame", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array('layerselected', '#layerbasic_ts_wrapbrtn .transtarget_selector'), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "#le_frame_scale_x"
										)
									),
									'scaley' => array(
										$t => __("scaleY", 'revsliderhelp'),
										$h => "#frame#.transform.scaleY",
										$k => array("animation scale", "animation scaley", "scaley", "scale y", "scale"),
										$d => __("Scale the Layer's height by this amount for the selected animation frame", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array('layerselected', '#layerbasic_ts_wrapbrtn .transtarget_selector'), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "#le_frame_scale_y"
										)
									),
									'skewx' => array(
										$t => __("skewX", 'revsliderhelp'),
										$h => "#frame#.transform.skewX",
										$k => array("animation skew", "animation skewx", "skew x", "skewx", "skew"),
										$d => __("Skew/distort the Layer horizontally by this amount for the selected animation frame.  Accepts positive and negative values.", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array('layerselected', '#layerbasic_ts_wrapbrtn .transtarget_selector'), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "#le_frame_skew_x"
										)
									),
									'skewy' => array(
										$t => __("skewY", 'revsliderhelp'),
										$h => "#frame#.transform.skewY",
										$k => array("animation skew", "animation skewy", "skew y", "skewy", "skew"),
										$d => __("Skew/distort the Layer vertically by this amount for the selected animation frame.  Accepts positive and negative values.", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array('layerselected', '#layerbasic_ts_wrapbrtn .transtarget_selector'), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "#le_frame_skew_y"
										)
									),
									'rotationx' => array(
										$t => __("rotateX", 'revsliderhelp'),
										$h => "#frame#.transform.rotationX",
										$k => array("animation rotation", "animation rotatex", "rotatex", "rotationx", "rotation x", "3d", "3d rotation"),
										$d => __("Rotate the Layer on its 'x' axis by this amount for the selected animation frame.  Accepts positive and negative values.", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array('layerselected', '#layerbasic_ts_wrapbrtn .transtarget_selector'), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "#le_frame_rotate_x"
										)
									),
									'rotationy' => array(
										$t => __("rotateY", 'revsliderhelp'),
										$h => "#frame#.transform.rotationY",
										$k => array("animation rotation", "animation rotatey", "rotatey", "rotationy", "rotation y", "3d", "3d rotation"),
										$d => __("Rotate the Layer on its 'y' axis by this amount for the selected animation frame.  Accepts positive and negative values.", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array('layerselected', '#layerbasic_ts_wrapbrtn .transtarget_selector'), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "#le_frame_rotate_y"
										)
									),
									'rotation' => array(
										$t => __("2D Rotation", 'revsliderhelp'),
										$h => "#frame#.transform.rotationZ",
										$k => array("animation rotation", "animation rotate", "rotate", "rotation", "2d", "2d rotation"),
										$d => __("The Layer's <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/transform-function/rotate' target='_blank'>2D Rotation</a> for the selected animation frame.  Accepts positive and negative values.", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array('layerselected', '#layerbasic_ts_wrapbrtn .transtarget_selector'), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "#le_frame_rotate_z"
										)
									)
								),
								'transform_origin' => array(
									'originx' => array(
										$t => __("Transform Origin X", 'revsliderhelp'),
										$h => "#frame#.transform.originX",
										$k => array("animation origin", "animation originx", "transform origin", "transform-origin"),
										$d => __("The 'x' axis for the Layer's <a href='https://www.w3schools.com/cssref/css3_pr_transform-origin.asp' target='_blank'>transform-origin</a> applied to the selected animation frame.", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array('layerselected', '#layerbasic_ts_wrapbrtn .transtarget_selector'), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "*[data-r='#frame#.transform.originX']"
										)
									),
									'originy' => array(
										$t => __("Transform Origin Y", 'revsliderhelp'),
										$h => "#frame#.transform.originY",
										$k => array("animation origin", "animation originx", "transform origin", "transform-origin"),
										$d => __("The 'y' axis for the Layer's <a href='https://www.w3schools.com/cssref/css3_pr_transform-origin.asp' target='_blank'>transform-origin</a> applied to the selected animation frame.", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array('layerselected', '#layerbasic_ts_wrapbrtn .transtarget_selector'), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "*[data-r='#frame#.transform.originY']"
										)
									),
									'originz' => array(
										$t => __("Transform Origin Z", 'revsliderhelp'),
										$h => "#frame#.transform.originZ",
										$k => array("animation origin", "animation originx", "transform origin", "transform-origin"),
										$d => __("The 'z' axis for the Layer's <a href='https://www.w3schools.com/cssref/css3_pr_transform-origin.asp' target='_blank'>transform-origin</a> applied to the selected animation frame.", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array('layerselected', '#layerbasic_ts_wrapbrtn .transtarget_selector'), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "*[data-r='#frame#.transform.originZ']"
										)
									)
								)
							),
							'mask' => array(
								'enable' => array(
									$di => "layer_frame_mask",
									$t => __("Enable Layer Mask", 'revsliderhelp'),
									$h => "#frame#.mask.use",
									$k => array("animation mask", "animation masking", "layer mask", "layer masking", "mask", "masking"),
									$d => __("Add a mask to the Layer which is useful for wipe/reveal type animations", 'revsliderhelp'),
									$a => $u . "layer-animations/#advanced-settings",
									$hl => array(
										$dp => array('layerselected', '#mask_ts_wrapbrtn .transtarget_selector'), 
										$m => "#module_layers_trigger, #gst_layer_4", 
										$st => '#form_animation_sframes:nth-child(3)', 
										$f => "*[data-r='#frame#.mask.use']"
									)
								),
								'maskx' => array(
									$t => __("Mask X Position", 'revsliderhelp'),
									$h => "#frame#.mask.x.#size#.v",
									$k => array("animation mask", "animation masking", "layer mask", "layer masking", "mask", "masking"),
									$d => __("Position the mask horizontally.  Accepts positive and negative values.", 'revsliderhelp'),
									$a => $u . "layer-animations/#advanced-settings",
									$hl => array(
										$dp => array(
											'layerselected', 
											'#mask_ts_wrapbrtn .transtarget_selector',
											array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.mask.use', $v => true, $o => 'layer_frame_mask')
										), 
										$m => "#module_layers_trigger, #gst_layer_4", 
										$st => '#form_animation_sframes:nth-child(3)', 
										$f => "#le_frame_mask_x"
									)
								),
								'masky' => array(
									$t => __("Mask Y Position", 'revsliderhelp'),
									$h => "#frame#.mask.y.#size#.v",
									$k => array("animation mask", "animation masking", "layer mask", "layer masking", "mask", "masking"),
									$d => __("Position the mask vertically.  Accepts positive and negative values.", 'revsliderhelp'),
									$a => $u . "layer-animations/#advanced-settings",
									$hl => array(
										$dp => array(
											'layerselected', 
											'#mask_ts_wrapbrtn .transtarget_selector',
											array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.mask.use', $v => true, $o => 'layer_frame_mask')
										), 
										$m => "#module_layers_trigger, #gst_layer_4", 
										$st => '#form_animation_sframes:nth-child(3)', 
										$f => "#le_frame_mask_y"
									)
								),
								'clippath_enable' => array(
									$di => "clippath_enable",
									$t => __("Enable Clip Path", 'revsliderhelp'),
									$h => "timeline.clipPath.use",
									$k => array("clip path", "clippath", "mask", "masking"),
									$d => __("Apply and animate a CSS clip-path to the Layer.  Useful for creating 'wipe' animations", 'revsliderhelp'),
									$a => $u . "layer-animations/#advanced-settings",
									$hl => array(
										$dp => array('layerselected', '#mask_ts_wrapbrtn .transtarget_selector'), 
										$m => "#module_layers_trigger, #gst_layer_4", 
										$st => '#form_animation_sframes:nth-child(3)', 
										$f => "*[data-r='timeline.clipPath.use']"
									)
								),
								'clippath_type' => array(
									$t => __("Clip Path Type", 'revsliderhelp'),
									$h => "timeline.clipPath.type",
									$k => array("clip path", "clippath", "mask", "masking", "clip path type"),
									$d => __("Choose 'Rectangle' or 'Circle' for traditional wipes from the sides, center or corners, and 'Custom Mask' for curtain-type reveals", 'revsliderhelp'),
									$a => $u . "layer-animations/#advanced-settings",
									$hl => array(
										$dp => array(
											'layerselected', 
											'#mask_ts_wrapbrtn .transtarget_selector',
											array($p => '#slide#.layers.#layer#.timeline.clipPath.use', $v => true, $o => 'clippath_enable')
										), 
										$m => "#module_layers_trigger, #gst_layer_4", 
										$st => '#form_animation_sframes:nth-child(3)', 
										$f => "*[data-r='timeline.clipPath.type']"
									)
								),
								'clippath_origin' => array(
									$t => __("Clip Path Origin", 'revsliderhelp'),
									$h => "timeline.clipPath.origin",
									$k => array("clip path", "clippath", "mask", "masking", "clip path origin", "origin"),
									$d => __("Choose which direction the Clip Path should move to", 'revsliderhelp'),
									$a => $u . "layer-animations/#advanced-settings",
									$hl => array(
										$dp => array(
											'layerselected', 
											'#mask_ts_wrapbrtn .transtarget_selector',
											array($p => '#slide#.layers.#layer#.timeline.clipPath.use', $v => true, $o => 'clippath_enable')
										), 
										$m => "#module_layers_trigger, #gst_layer_4", 
										$st => '#form_animation_sframes:nth-child(3)', 
										$f => "*[data-r='timeline.clipPath.origin']"
									)
								),
								'clip_percentage' => array(
									$t => __("Clip Percentage", 'revsliderhelp'),
									$h => "#frame#.transform.clip, #frame#.transform.clipB",
									$k => array("clip path", "clippath", "mask", "masking", "clip path percentage"),
									$d => __("The percentage of the Layer to apply the clip-path mask to.  The number '0' would represent completely hidden and '100' represent completely visible.", 'revsliderhelp'),
									$a => $u . "layer-animations/#advanced-settings",
									$hl => array(
										$dp => array(
											'layerselected', 
											'#mask_ts_wrapbrtn .transtarget_selector',
											array($p => '#slide#.layers.#layer#.timeline.clipPath.use', $v => true, $o => 'clippath_enable')
										), 
										$m => "#module_layers_trigger, #gst_layer_4", 
										$st => '#form_animation_sframes:nth-child(3)', 
										$f => "*[data-r='#frame#.transform.clip']"
									)
								)
							),
							'filter' => array(
								'enable' => array(
									$di => "layer_frame_filter",
									$t => __("Enable Filter Animation", 'revsliderhelp'),
									$h => "#frame#.filter.use",
									$k => array("animate filter", "filter animation", "filter", "filters"),
									$d => __("Animate the Layer's blur, grayscale or brightness filter", 'revsliderhelp'),
									$a => $u . "layer-animations/#advanced-settings",
									$hl => array(
										$dp => array('layerselected', '#filter_ts_wrapbrtn .transtarget_selector'), 
										$m => "#module_layers_trigger, #gst_layer_4", 
										$st => '#form_animation_sframes:nth-child(3)', 
										$f => "*[data-r='#frame#.filter.use']"
									)
								),
								'blur' => array(
									$t => __("Blur Filter", 'revsliderhelp'),
									$h => "#frame#.filter.blur",
									$k => array("animate filter", "filter animation", "filter", "filters", "blur filter", "blur"),
									$d => __("The <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/filter-function/blur' target='_blank'>blur filter</a> value for the selected Animation frame", 'revsliderhelp'),
									$a => $u . "layer-animations/#advanced-settings",
									$hl => array(
										$dp => array(
											'layerselected', 
											'#filter_ts_wrapbrtn .transtarget_selector',
											array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.filter.use', $v => true, $o => 'layer_frame_filter')
										), 
										$m => "#module_layers_trigger, #gst_layer_4", 
										$st => '#form_animation_sframes:nth-child(3)', 
										$f => "*[data-r='#frame#.filter.blur']"
									)
								),
								'grayscale' => array(
									$t => __("Grayscale", 'revsliderhelp'),
									$h => "#frame#.filter.grayscale",
									$k => array("animate filter", "filter animation", "filter", "filters", "grayscale filter", "grayscale"),
									$d => __("The <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/filter-function/grayscale' target='_blank'>grayscale filter</a> value for the selected Animation frame", 'revsliderhelp'),
									$a => $u . "layer-animations/#advanced-settings",
									$hl => array(
										$dp => array(
											'layerselected', 
											'#filter_ts_wrapbrtn .transtarget_selector',
											array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.filter.use', $v => true, $o => 'layer_frame_filter')
										), 
										$m => "#module_layers_trigger, #gst_layer_4", 
										$st => '#form_animation_sframes:nth-child(3)', 
										$f => "*[data-r='#frame#.filter.grayscale']"
									)
								),
								'brightness' => array(
									$t => __("Brightness", 'revsliderhelp'),
									$h => "#frame#.filter.brightness",
									$k => array("animate filter", "filter animation", "filter", "filters", "brightness filter", "brightness"),
									$d => __("The <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/filter-function/brightness' target='_blank'>brightness filter</a> value for the selected Animation frame", 'revsliderhelp'),
									$a => $u . "layer-animations/#advanced-settings",
									$hl => array(
										$dp => array(
											'layerselected', 
											'#filter_ts_wrapbrtn .transtarget_selector',
											array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.filter.use', $v => true, $o => 'layer_frame_filter')
										), 
										$m => "#module_layers_trigger, #gst_layer_4", 
										$st => '#form_animation_sframes:nth-child(3)', 
										$f => "*[data-r='#frame#.filter.brightness']"
									)
								)
							),
							'color' => array(
								'enable_text_color' => array(
									$di => "layer_frame_color_text",
									$t => __("Animate Text Color", 'revsliderhelp'),
									$h => "#frame#.color.use",
									$k => array("animate color", "animate text color", "animate text-color", "color animation", "text color animation"),
									$d => __("Animate the Layer's text color", 'revsliderhelp'),
									$a => $u . "layer-animations/#advanced-settings",
									$hl => array(
										$dp => array('layerselected', '#color_ts_wrapbrtn .transtarget_selector'), 
										$m => "#module_layers_trigger, #gst_layer_4", 
										$st => '#form_animation_sframes:nth-child(3)', 
										$f => "*[data-r='#frame#.color.use']"
									)
								),
								'text_color' => array(
									$t => __("Text Color Value", 'revsliderhelp'),
									$h => "#frame#.color.color",
									$k => array("animate color", "animate text color", "animate text-color", "color animation", "text color animation"),
									$d => __("The Layer's text color for the selected Animation frame", 'revsliderhelp'),
									$a => $u . "layer-animations/#advanced-settings",
									$hl => array(
										$dp => array(
											'layerselected', 
											'#color_ts_wrapbrtn .transtarget_selector',
											array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.color.use', $v => true, $o => 'layer_frame_color_text')
										), 
										$m => "#module_layers_trigger, #gst_layer_4", 
										$st => '#form_animation_sframes:nth-child(3)', 
										$f => "#frameColorAnimation"
									)
								),
								'enable_background_color' => array(
									$di => "layer_frame_color_background",
									$t => __("Animate Background Color", 'revsliderhelp'),
									$h => "#frame#.bgcolor.use",
									$k => array("animate color", "animate background color", "animate background-color", "color animation", "background color animation"),
									$d => __("Animate the Layer's background color", 'revsliderhelp'),
									$a => $u . "layer-animations/#advanced-settings",
									$hl => array(
										$dp => array('layerselected', '#color_ts_wrapbrtn .transtarget_selector'), 
										$m => "#module_layers_trigger, #gst_layer_4", 
										$st => '#form_animation_sframes:nth-child(3)', 
										$f => "*[data-r='#frame#.bgcolor.use']"
									)
								),
								'background_color' => array(
									$t => __("Background Color Value", 'revsliderhelp'),
									$h => "#frame#.bgcolor.backgroundColor",
									$k => array("animate color", "animate background color", "animate background-color", "background color animation", "background-color animation"),
									$d => __("The Layer's background color for the selected Animation frame", 'revsliderhelp'),
									$a => $u . "layer-animations/#advanced-settings",
									$hl => array(
										$dp => array(
											'layerselected', 
											'#color_ts_wrapbrtn .transtarget_selector',
											array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.bgcolor.use', $v => true, $o => 'layer_frame_color_background')
										), 
										$m => "#module_layers_trigger, #gst_layer_4", 
										$st => '#form_animation_sframes:nth-child(3)', 
										$f => "#frameBGColorAnimation"
									)
								)
							),
							'char_word_line' => array(
								'enable' => array(
									$di => "layer_frame_char",
									$t => __("Enable Text-Split Animations", 'revsliderhelp'),
									$h => "#frame#.chars.use, #frame#.words.use, #frame#.lines.use",
									$k => array("text-split", "split", "text-split animation", "split animation", "char animation", "word animation", "line animation", "character animation"),
									$d => __("Animate characters, words or lines of text", 'revsliderhelp'),
									$a => $u . "layer-animations/#advanced-settings",
									$hl => array(
										$dp => array('layerselected', '#chars_ts_wrapbrtn .transtarget_selector'), 
										$m => "#module_layers_trigger, #gst_layer_4", 
										$st => '#form_animation_sframes:nth-child(3)', 
										$f => "*[data-r='#frame#.chars.use']"
									)
								),
								'direction' => array(
									$t => __("Split Direction", 'revsliderhelp'),
									$h => "#frame#.chars.direction, #frame#.words.direction, #frame#.lines.direction",
									$k => array("split direction", "split animation direction", "text-split direction", "text animation direction"),
									$d => __("Choose which direction the chars/words/lines should be animated in", 'revsliderhelp'),
									$a => $u . "layer-animations/#advanced-settings",
									$hl => array(
										$dp => array(
											'layerselected', 
											'#chars_ts_wrapbrtn .transtarget_selector',
											array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.chars.use', $v => true, $o => 'layer_frame_char')
										), 
										$m => "#module_layers_trigger, #gst_layer_4", 
										$st => '#form_animation_sframes:nth-child(3)', 
										$f => "#le_frame_chars_txtsplitdirection"
									)
								),
								'delay' => array(
									$t => __("Split Delay", 'revsliderhelp'),
									$h => "#frame#.lines.delay, #frame#.chars.delay, #frame#.words.delay",
									$k => array("split delay", "split animation delay", "text-split delay", "text animation delay"),
									$d => __("The delay time between each animation for the individual characters/words/lines", 'revsliderhelp'),
									$a => $u . "layer-animations/#advanced-settings",
									$hl => array(
										$dp => array(
											'layerselected', 
											'#chars_ts_wrapbrtn .transtarget_selector',
											array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.chars.use', $v => true, $o => 'layer_frame_char')
										), 
										$m => "#module_layers_trigger, #gst_layer_4", 
										$st => '#form_animation_sframes:nth-child(3)', 
										$f => "#le_frame_chars_splitdelay"
									)
								),
								'easing' => array(
									$t => __("Animation Easing", 'revsliderhelp'),
									$h => "#frame#.words.ease, #frame#.chars.ease, #frame#.lines.ease",
									$k => array("split easing", "split animation easing", "text-split easing", "text animation easing"),
									$d => __("The easing equation to be applied for each animation", 'revsliderhelp'),
									$a => $u . "layer-animations/#advanced-settings",
									$hl => array(
										$dp => array(
											'layerselected', 
											'#chars_ts_wrapbrtn .transtarget_selector',
											array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.chars.use', $v => true, $o => 'layer_frame_char')
										), 
										$m => "#module_layers_trigger, #gst_layer_4", 
										$st => '#form_animation_sframes:nth-child(3)', 
										$f => "#chars_appear_ease"
									)
								),
								'opacity' => array(
									$t => __("Opacity", 'revsliderhelp'),
									$h => "#frame#.chars.opacity, #frame#.words.opacity, #frame#.lines.opacity",
									$k => array("opacity", "animation opacity", "transparency", "animate opacity"),
									$d => __("The char/word/line opacity to apply to the currently selected animation frame", 'revsliderhelp'),
									$a => $u . "layer-animations/#advanced-settings",
									$hl => array(
										$dp => array(
											'layerselected', 
											'#chars_ts_wrapbrtn .transtarget_selector',
											array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.chars.use', $v => true, $o => 'layer_frame_char')
										), 
										$m => "#module_layers_trigger, #gst_layer_4", 
										$st => '#form_animation_sframes:nth-child(3)', 
										$f => "#le_frame_chars_opacity"
									)
								),
								'translate' => array(
									'translate_x' => array(
										$t => __("TranslateX", 'revsliderhelp'),
										$h => "#frame#.chars.x.#size#.v, #frame#.words.x.#size#.v, #frame#.lines.x.#size#.v",
										$k => array("animation position", "animate left", "animate right", "translatex"),
										$d => __("The 'x' (left) position to apply to the currently selected animation frame.  Accepts positive and negative numbers.", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array(
												'layerselected', 
												'#chars_ts_wrapbrtn .transtarget_selector',
												array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.chars.use', $v => true, $o => 'layer_frame_char')
											), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "#le_frame_chars_x"
										)
									),
									'translate_y' => array(
										$t => __("TranslateY", 'revsliderhelp'),
										$h => "#frame#.chars.y.#size#.v, #frame#.words.y.#size#.v, #frame#.lines.y.#size#.v",
										$k => array("animation position", "animate top", "animate bottom", "translatey"),
										$d => __("The 'y' (top) position to apply to the currently selected animation frame.  Accepts positive and negative numbers.", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array(
												'layerselected', 
												'#chars_ts_wrapbrtn .transtarget_selector',
												array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.chars.use', $v => true, $o => 'layer_frame_char')
											), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "#le_frame_chars_y"
										)
									),
									'translate_z' => array(
										$t => __("TranslateZ", 'revsliderhelp'),
										$h => "#frame#.lines.z, #frame#.words.z, #frame#.chars.z",
										$k => array("animation depth", "animation z", "translatez", "3d"),
										$d => __("The <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/transform-function/translateZ' target=_'blank'>CSS translateZ</a> to apply to the selected animation frame.  This adds/removes 3D depth to the Layer", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array(
												'layerselected', 
												'#chars_ts_wrapbrtn .transtarget_selector',
												array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.chars.use', $v => true, $o => 'layer_frame_char')
											), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "#le_frame_chars_z"
										)
									)
								),
								'scale_skew' => array(
									'scalex' => array(
										$t => __("scaleX", 'revsliderhelp'),
										$h => "#frame#.chars.scaleX, #frame#.words.scaleX, #frame#.lines.scaleX",
										$k => array("animation scale", "animation scalex", "scalex", "scale x", "scale"),
										$d => __("Scale the char/word/line width by this amount for the selected animation frame", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array(
												'layerselected', 
												'#chars_ts_wrapbrtn .transtarget_selector',
												array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.chars.use', $v => true, $o => 'layer_frame_char')
											), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "#le_frame_chars_scale_x"
										)
									),
									'scaley' => array(
										$t => __("scaleY", 'revsliderhelp'),
										$h => "#frame#.chars.scaleY, #frame#.words.scaleY, #frame#.lines.scaleY",
										$k => array("animation scale", "animation scaley", "scaley", "scale y", "scale"),
										$d => __("Scale the char/word/line height by this amount for the selected animation frame", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array(
												'layerselected', 
												'#chars_ts_wrapbrtn .transtarget_selector',
												array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.chars.use', $v => true, $o => 'layer_frame_char')
											), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "#le_frame_chars_scale_y"
										)
									),
									'skewx' => array(
										$t => __("skewX", 'revsliderhelp'),
										$h => "#frame#.chars.skewX, #frame#.words.skewX, #frame#.lines.skewX",
										$k => array("animation skew", "animation skewx", "skew x", "skewx", "skew"),
										$d => __("Skew/distort the Layer horizontally by this amount for the selected animation frame.  Accepts positive and negative values.", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array(
												'layerselected', 
												'#chars_ts_wrapbrtn .transtarget_selector',
												array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.chars.use', $v => true, $o => 'layer_frame_char')
											), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "#le_frame_chars_skew_x"
										)
									),
									'skewy' => array(
										$t => __("skewY", 'revsliderhelp'),
										$h => "#frame#.chars.skewY, #frame#.words.skewY, #frame#.lines.skewY",
										$k => array("animation skew", "animation skewy", "skew y", "skewy", "skew"),
										$d => __("Skew/distort the Layer vertically by this amount for the selected animation frame.  Accepts positive and negative values.", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array(
												'layerselected', 
												'#chars_ts_wrapbrtn .transtarget_selector',
												array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.chars.use', $v => true, $o => 'layer_frame_char')
											), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "#le_frame_chars_skew_y"
										)
									)
								),
								'rotation' => array(
									'rotationx' => array(
										$t => __("rotateX", 'revsliderhelp'),
										$h => "#frame#.chars.rotationX, #frame#.words.rotationX, #frame#.lines.rotationX",
										$k => array("animation rotation", "animation rotatex", "rotatex", "rotationx", "rotation x", "3d", "3d rotation"),
										$d => __("Rotate the Layer on its 'x' axis by this amount for the selected animation frame.  Accepts positive and negative values.", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array(
												'layerselected', 
												'#chars_ts_wrapbrtn .transtarget_selector',
												array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.chars.use', $v => true, $o => 'layer_frame_char')
											), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "#le_frame_chars_rotate_x"
										)
									),
									'rotationy' => array(
										$t => __("rotateY", 'revsliderhelp'),
										$h => "#frame#.chars.rotationY, #frame#.words.rotationY, #frame#.lines.rotationY",
										$k => array("animation rotation", "animation rotatey", "rotatey", "rotationy", "rotation y", "3d", "3d rotation"),
										$d => __("Rotate the Layer on its 'y' axis by this amount for the selected animation frame.  Accepts positive and negative values.", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array(
												'layerselected', 
												'#chars_ts_wrapbrtn .transtarget_selector',
												array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.chars.use', $v => true, $o => 'layer_frame_char')
											), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "#le_frame_chars_rotate_y"
										)
									),
									'rotation' => array(
										$t => __("2D Rotation", 'revsliderhelp'),
										$h => "#frame#.chars.rotationZ, #frame#.words.rotationZ, #frame#.lines.rotationZ",
										$k => array("animation rotation", "animation rotate", "rotate", "rotation", "2d", "2d rotation"),
										$d => __("The char/word/line <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/transform-function/rotate' target='_blank'>2D Rotation</a> for the selected animation frame.  Accepts positive and negative values.", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array(
												'layerselected', 
												'#chars_ts_wrapbrtn .transtarget_selector',
												array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.chars.use', $v => true, $o => 'layer_frame_char')
											), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "#le_frame_chars_rotate_z"
										)
									)
								),
								'transform_origin' => array(
									'originx' => array(
										$t => __("Transform Origin X", 'revsliderhelp'),
										$h => "#frame#.chars.originX, #frame#.words.originX, #frame#.lines.originX",
										$k => array("animation origin", "animation originx", "transform origin", "transform-origin"),
										$d => __("The 'x' axis for the char/word/line <a href='https://www.w3schools.com/cssref/css3_pr_transform-origin.asp' target='_blank'>transform-origin</a> applied to the selected animation frame.", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array(
												'layerselected', 
												'#chars_ts_wrapbrtn .transtarget_selector',
												array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.chars.use', $v => true, $o => 'layer_frame_char')
											), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "*[data-r='#frame#.chars.originX']"
										)
									),
									'originy' => array(
										$t => __("Transform Origin Y", 'revsliderhelp'),
										$h => "#frame#.chars.originY, #frame#.words.originY, #frame#.lines.originY",
										$k => array("animation origin", "animation originx", "transform origin", "transform-origin"),
										$d => __("The 'y' axis for the char/word/line <a href='https://www.w3schools.com/cssref/css3_pr_transform-origin.asp' target='_blank'>transform-origin</a> applied to the selected animation frame.", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array(
												'layerselected', 
												'#chars_ts_wrapbrtn .transtarget_selector',
												array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.chars.use', $v => true, $o => 'layer_frame_char')
											), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "*[data-r='#frame#.chars.originY']"
										)
									),
									'originz' => array(
										$t => __("Transform Origin Z", 'revsliderhelp'),
										$h => "#frame#.chars.originZ, #frame#.words.originZ, #frame#.lines.originZ",
										$k => array("animation origin", "animation originx", "transform origin", "transform-origin"),
										$d => __("The 'z' axis for the char/word/line <a href='https://www.w3schools.com/cssref/css3_pr_transform-origin.asp' target='_blank'>transform-origin</a> applied to the selected animation frame.", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array(
												'layerselected', 
												'#chars_ts_wrapbrtn .transtarget_selector',
												array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.chars.use', $v => true, $o => 'layer_frame_char')
											), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "*[data-r='#frame#.chars.originZ']"
										)
									)
								),
								'filter_chars' => array(
									'enable' => array(
										$di => "char_frame_filter",
										$t => __("Enable Filter Animation", 'revsliderhelp'),
										$h => "#frame#.chars.fuse",
										$k => array("animate filter", "filter animation", "filter", "filters"),
										$d => __("Animate the Char animation's blur, grayscale or brightness filter", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array(
												'layerselected', 
												'#chars_ts_wrapbrtn .transtarget_selector',
												array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.chars.use', $v => true, $o => 'layer_frame_char')
											), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "*[data-r='#frame#.chars.fuse']"
										)
									),
									'blur' => array(
										$t => __("Blur Filter", 'revsliderhelp'),
										$h => "#frame#.chars.blur",
										$k => array("animate filter", "filter animation", "filter", "filters", "blur filter", "blur"),
										$d => __("The <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/filter-function/blur' target='_blank'>blur filter</a> value for the Chars animation", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array(
												'layerselected', 
												'#chars_ts_wrapbrtn .transtarget_selector',
												array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.filter.use', $v => true, $o => 'layer_frame_char'),
												array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.chars.fuse', $v => true, $o => 'char_frame_filter')
											), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "*[data-r='#frame#.chars.blur']"
										)
									),
									'grayscale' => array(
										$t => __("Grayscale", 'revsliderhelp'),
										$h => "#frame#.chars.grayscale",
										$k => array("animate filter", "filter animation", "filter", "filters", "grayscale filter", "grayscale"),
										$d => __("The <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/filter-function/grayscale' target='_blank'>grayscale filter</a> value for the Chars animation", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array(
												'layerselected', 
												'#filter_ts_wrapbrtn .transtarget_selector',
												array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.filter.use', $v => true, $o => 'layer_frame_char'),
												array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.chars.fuse', $v => true, $o => 'char_frame_filter')
											), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "*[data-r='#frame#.chars.grayscale']"
										)
									),
									'brightness' => array(
										$t => __("Brightness", 'revsliderhelp'),
										$h => "#frame#.chars.brightness",
										$k => array("animate filter", "filter animation", "filter", "filters", "brightness filter", "brightness"),
										$d => __("The <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/filter-function/brightness' target='_blank'>brightness filter</a> value for the Chars animation", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array(
												'layerselected', 
												'#filter_ts_wrapbrtn .transtarget_selector',
												array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.filter.use', $v => true, $o => 'layer_frame_char'),
												array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.chars.fuse', $v => true, $o => 'char_frame_filter')
											), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "*[data-r='#frame#.chars.brightness']"
										)
									)
								),
								'filter_words' => array(
									'enable' => array(
										$di => "word_frame_filter",
										$t => __("Enable Filter Animation", 'revsliderhelp'),
										$h => "#frame#.words.fuse",
										$k => array("animate filter", "filter animation", "filter", "filters"),
										$d => __("Animate the word animation's blur, grayscale or brightness filter", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array(
												'layerselected', 
												'#words_ts_wrapbrtn .transtarget_selector',
												array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.words.use', $v => true, $o => 'layer_frame_word')
											), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "*[data-r='#frame#.words.fuse']"
										)
									),
									'blur' => array(
										$t => __("Blur Filter", 'revsliderhelp'),
										$h => "#frame#.words.blur",
										$k => array("animate filter", "filter animation", "filter", "filters", "blur filter", "blur"),
										$d => __("The <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/filter-function/blur' target='_blank'>blur filter</a> value for the words animation", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array(
												'layerselected', 
												'#words_ts_wrapbrtn .transtarget_selector',
												array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.filter.use', $v => true, $o => 'layer_frame_word'),
												array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.words.fuse', $v => true, $o => 'word_frame_filter')
											), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "*[data-r='#frame#.words.blur']"
										)
									),
									'grayscale' => array(
										$t => __("Grayscale", 'revsliderhelp'),
										$h => "#frame#.words.grayscale",
										$k => array("animate filter", "filter animation", "filter", "filters", "grayscale filter", "grayscale"),
										$d => __("The <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/filter-function/grayscale' target='_blank'>grayscale filter</a> value for the words animation", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array(
												'layerselected', 
												'#filter_ts_wrapbrtn .transtarget_selector',
												array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.filter.use', $v => true, $o => 'layer_frame_word'),
												array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.words.fuse', $v => true, $o => 'word_frame_filter')
											), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "*[data-r='#frame#.words.grayscale']"
										)
									),
									'brightness' => array(
										$t => __("Brightness", 'revsliderhelp'),
										$h => "#frame#.words.brightness",
										$k => array("animate filter", "filter animation", "filter", "filters", "brightness filter", "brightness"),
										$d => __("The <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/filter-function/brightness' target='_blank'>brightness filter</a> value for the words animation", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array(
												'layerselected', 
												'#filter_ts_wrapbrtn .transtarget_selector',
												array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.filter.use', $v => true, $o => 'layer_frame_word'),
												array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.words.fuse', $v => true, $o => 'word_frame_filter')
											), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "*[data-r='#frame#.words.brightness']"
										)
									)
								),
								'filter_lines' => array(
									'enable' => array(
										$di => "line_frame_filter",
										$t => __("Enable Filter Animation", 'revsliderhelp'),
										$h => "#frame#.lines.fuse",
										$k => array("animate filter", "filter animation", "filter", "filters"),
										$d => __("Animate the line animation's blur, grayscale or brightness filter", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array(
												'layerselected', 
												'#lines_ts_wrapbrtn .transtarget_selector',
												array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.lines.use', $v => true, $o => 'layer_frame_line')
											), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "*[data-r='#frame#.lines.fuse']"
										)
									),
									'blur' => array(
										$t => __("Blur Filter", 'revsliderhelp'),
										$h => "#frame#.lines.blur",
										$k => array("animate filter", "filter animation", "filter", "filters", "blur filter", "blur"),
										$d => __("The <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/filter-function/blur' target='_blank'>blur filter</a> value for the lines animation", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array(
												'layerselected', 
												'#lines_ts_wrapbrtn .transtarget_selector',
												array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.filter.use', $v => true, $o => 'layer_frame_line'),
												array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.lines.fuse', $v => true, $o => 'line_frame_filter')
											), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "*[data-r='#frame#.lines.blur']"
										)
									),
									'grayscale' => array(
										$t => __("Grayscale", 'revsliderhelp'),
										$h => "#frame#.lines.grayscale",
										$k => array("animate filter", "filter animation", "filter", "filters", "grayscale filter", "grayscale"),
										$d => __("The <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/filter-function/grayscale' target='_blank'>grayscale filter</a> value for the lines animation", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array(
												'layerselected', 
												'#filter_ts_wrapbrtn .transtarget_selector',
												array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.filter.use', $v => true, $o => 'layer_frame_line'),
												array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.lines.fuse', $v => true, $o => 'line_frame_filter')
											), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "*[data-r='#frame#.lines.grayscale']"
										)
									),
									'brightness' => array(
										$t => __("Brightness", 'revsliderhelp'),
										$h => "#frame#.lines.brightness",
										$k => array("animate filter", "filter animation", "filter", "filters", "brightness filter", "brightness"),
										$d => __("The <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/filter-function/brightness' target='_blank'>brightness filter</a> value for the lines animation", 'revsliderhelp'),
										$a => $u . "layer-animations/#advanced-settings",
										$hl => array(
											$dp => array(
												'layerselected', 
												'#filter_ts_wrapbrtn .transtarget_selector',
												array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.filter.use', $v => true, $o => 'layer_frame_line'),
												array($p => '#slide#.layers.#layer#.timeline.frames.#frame#.lines.fuse', $v => true, $o => 'line_frame_filter')
											), 
											$m => "#module_layers_trigger, #gst_layer_4", 
											$st => '#form_animation_sframes:nth-child(3)', 
											$f => "*[data-r='#frame#.lines.brightness']"
										)
									)
								)
							)
						),
						'sfx' => array(
							$t => __("Special Effects", 'revsliderhelp'),
							$h => "#frame#.sfx.effect",
							$k => array("sfx", "special effects", "block animations", "block transitions"),
							$d => __("Choose a predefined special effect to use as the Layer's animation", 'revsliderhelp'),
							$a => $u . "layer-animations/#advanced-settings",
							$hl => array(
								$dp => array('layerselected', '#sfx_ts_wrapbrtn .transtarget_selector'), 
								$m => "#module_layers_trigger, #gst_layer_4", 
								$st => '#form_animation_sframes:nth-child(3)', 
								$f => "#layer_frame_sfx"
							)
						)
					),
					'gst_layer_15' => array(
						'timeline' => array(
							'enable' => array(
								$di => "looping_timeline",
								$t => __("Loop Layer's Timeline", 'revsliderhelp'),
								$h => "timeline.tloop.use",
								$k => array("loop", "looping", "loop animation", "looping animation", "animation", "timeline", "loop timeline"),
								$d => __("Loop all or part of the Layer's timeline animation", 'revsliderhelp'),
								$a => $u . "looping-animations/",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-1 .ssmbtn", 
									$st => '#form_animation_sloop', 
									$f => "*[data-r='timeline.tloop.use']"
								)
							),
							'start_frame' => array(
								$t => __("Loop Start Frame", 'revsliderhelp'),
								$h => "timeline.tloop.from",
								$k => array("loop start", "start loop", "start loop animation", "start frame", "loop start frame", "loop", "timeline"),
								$d => __("Choose which point in the Layer's timeline it should begin from for the loop animation", 'revsliderhelp'),
								$a => $u . "looping-animations/",
								$hl => array(
									$dp => array(
										'layerselected',
										array($p => '#slide#.layers.#layer#.timeline.tloop.use', $v => true, $o => 'looping_timeline')
									), 
									$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-1 .ssmbtn", 
									$st => '#form_layer_loop_timeline', 
									$f => "*[data-r='timeline.tloop.from']"
								)
							),
							'end_frame' => array(
								$t => __("Loop End Frame", 'revsliderhelp'),
								$h => "timeline.tloop.to",
								$k => array("loop end", "end loop", "end loop animation", "end frame", "loop end frame", "loop", "timeline"),
								$d => __("Choose which point in the Layer's timeline it should play to before it animates again", 'revsliderhelp'),
								$a => $u . "looping-animations/",
								$hl => array(
									$dp => array(
										'layerselected',
										array($p => '#slide#.layers.#layer#.timeline.tloop.use', $v => true, $o => 'looping_timeline')
									), 
									$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-1 .ssmbtn", 
									$st => '#form_layer_loop_timeline', 
									$f => "*[data-r='timeline.tloop.to']"
								)
							),
							'loop_amount' => array(
								$t => __("Num Loops", 'revsliderhelp'),
								$h => "timeline.tloop.repeat",
								$k => array("loop timeline", "loop", "num loops", "loop amount", "timeline"),
								$d => __("The number of times the Layer's selected timeline should loop.  Enter '-1' to loop continously throughout the life-cycle of the current Slide", 'revsliderhelp'),
								$a => $u . "looping-animations/",
								$hl => array(
									$dp => array(
										'layerselected',
										array($p => '#slide#.layers.#layer#.timeline.tloop.use', $v => true, $o => 'looping_timeline')
									), 
									$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-1 .ssmbtn", 
									$st => '#form_layer_loop_timeline', 
									$f => "#la_timeline_loop_amnt"
								)
							),
							'animate_to_start' => array(
								$t => __("Animate to Start", 'revsliderhelp'),
								$h => "timeline.tloop.keep",
								$k => array("loop timeline", "loop", "timeline", "animate to start"),
								$d => __("Animate the Layer back to its starting values in the loop once the last frame is reached.  Useful for creating a more natural looping visual.", 'revsliderhelp'),
								$a => $u . "looping-animations/",
								$hl => array(
									$dp => array(
										'layerselected',
										array($p => '#slide#.layers.#layer#.timeline.tloop.use', $v => true, $o => 'looping_timeline')
									), 
									$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-1 .ssmbtn", 
									$st => '#form_layer_loop_timeline', 
									$f => "*[data-r='timeline.tloop.keep']"
								)
							)
						),
						'effects' => array(
							'enable' => array(
								$di => "layer_looping",
								$t => __("Add Loop Animation", 'revsliderhelp'),
								$h => "timeline.loop.use",
								$k => array("loop", "looping", "loop animation", "looping animation", "animation"),
								$d => __("Add a continuously looping animation to the Layer", 'revsliderhelp'),
								$a => $u . "looping-animations/",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
									$st => '#form_animation_sloop', 
									$f => "*[data-r='timeline.loop.use']"
								)
							),
							'start' => array(
								$t => __("Start Time", 'revsliderhelp'),
								$h => "timeline.loop.start",
								$k => array("loop start", "start loop", "start loop animation"),
								$d => __("Define when the loop animation should begin after the Slide is shown", 'revsliderhelp'),
								$a => $u . "looping-animations/",
								$hl => array(
									$dp => array(
										'layerselected',
										array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping')
									), 
									$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
									$st => '#form_layer_loop_effect', 
									$f => "*[data-r='timeline.loop.start']"
								)
							),
							'duration' => array(
								$t => __("Animation Duration", 'revsliderhelp'),
								$h => "timeline.loop.speed",
								$k => array("loop duration", "loop animation time"),
								$d => __("The amount of time each loop animation should occur before it begins again", 'revsliderhelp'),
								$a => $u . "looping-animations/",
								$hl => array(
									$dp => array(
										'layerselected',
										array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping')
									), 
									$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
									$st => '#form_layer_loop_effect', 
									$f => "*[data-r='timeline.loop.speed']"
								)
							),
							'easing' => array(
								$t => __("Animation Easing", 'revsliderhelp'),
								$h => "timeline.loop.ease",
								$k => array("loop easing", "loop animation easing"),
								$d => __("The easing equation to be used for the loop animation", 'revsliderhelp'),
								$a => $u . "looping-animations/",
								$hl => array(
									$dp => array(
										'layerselected',
										array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping')
									), 
									$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
									$st => '#form_layer_loop_effect', 
									$f => "#le_frame_ease_loop"
								)
							),
							'transform_origin' => array(
								'originx' => array(
									$t => __("Transform Origin X", 'revsliderhelp'),
									$h => "timeline.loop.originX",
									$k => array("animation origin", "animation originx", "transform origin", "transform-origin"),
									$d => __("The 'x' axis for the Layer's <a href='https://www.w3schools.com/cssref/css3_pr_transform-origin.asp' target='_blank'>transform-origin</a> applied to the loop animation.", 'revsliderhelp'),
									$a => $u . "looping-animations/",
									$hl => array(
										$dp => array(
											'layerselected',
											array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping')
										), 
										$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
										$st => '#form_layer_loop_effect', 
										$f => "*[data-r='timeline.loop.originX']"
									)
								),
								'originy' => array(
									$t => __("Transform Origin Y", 'revsliderhelp'),
									$h => "timeline.loop.originY",
									$k => array("animation origin", "animation originx", "transform origin", "transform-origin"),
									$d => __("The 'y' axis for the Layer's <a href='https://www.w3schools.com/cssref/css3_pr_transform-origin.asp' target='_blank'>transform-origin</a> applied to the loop animation.", 'revsliderhelp'),
									$a => $u . "looping-animations/",
									$hl => array(
										$dp => array(
											'layerselected',
											array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping')
										), 
										$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
										$st => '#form_layer_loop_effect', 
										$f => "*[data-r='timeline.loop.originY']"
									)
								),
								'originz' => array(
									$t => __("Transform Origin Z", 'revsliderhelp'),
									$h => "timeline.loop.originZ",
									$k => array("animation origin", "animation originx", "transform origin", "transform-origin"),
									$d => __("The 'z' axis for the Layer's <a href='https://www.w3schools.com/cssref/css3_pr_transform-origin.asp' target='_blank'>transform-origin</a> applied to the loop animation.", 'revsliderhelp'),
									$a => $u . "looping-animations/",
									$hl => array(
										$dp => array(
											'layerselected',
											array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping')
										), 
										$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
										$st => '#form_layer_loop_effect', 
										$f => "*[data-r='timeline.loop.originZ']"
									)
								)
							),
							'move' => array(
								'yoyo' => array(
									$t => __("Yoyo Movement", 'revsliderhelp'),
									$h => "timeline.loop.yoyo_move",
									$k => array("yoyo", "yoyo animation", "yoyo transition", "loop animation"),
									$d => __("Reverse the position as soon as the animation ends and vice versa", 'revsliderhelp'),
									$a => $u . "looping-animations/",
									$hl => array(
										$dp => array(
											'layerselected',
											array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
											'*[data-showloop="#loop_move_settings"]'
										), 
										$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
										$st => '#layer_loop_settings .loop_wrapbrtn', 
										$f => "*[data-r='timeline.loop.yoyo_move']"
									)
								),
								'startx' => array(
									$t => __("Start X Position", 'revsliderhelp'),
									$h => "timeline.loop.frame_0.x",
									$k => array("animation position", "layer animation position", "animate left", "animate right", "translatex"),
									$d => __("The 'x' (left) position to apply at the start of the loop animation.  Accepts positive and negative numbers.", 'revsliderhelp'),
									$a => $u . "looping-animations/",
									$hl => array(
										$dp => array(
											'layerselected',
											array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
											'*[data-showloop="#loop_move_settings"]'
										), 
										$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
										$st => '#layer_loop_settings .loop_wrapbrtn', 
										$f => "*[data-r='timeline.loop.frame_0.x']"
									)
								),
								'endx' => array(
									$t => __("End X Position", 'revsliderhelp'),
									$h => "timeline.loop.frame_999.x",
									$k => array("animation position", "layer animation position", "animate left", "animate right", "translatex"),
									$d => __("Animate the Layer to this 'x' (left) position.  Accepts positive and negative numbers.", 'revsliderhelp'),
									$a => $u . "looping-animations/",
									$hl => array(
										$dp => array(
											'layerselected',
											array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
											'*[data-showloop="#loop_move_settings"]'
										), 
										$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
										$st => '#layer_loop_settings .loop_wrapbrtn', 
										$f => "*[data-r='timeline.loop.frame_999.x']"
									)
								),
								'starty' => array(
									$t => __("Start Y Position", 'revsliderhelp'),
									$h => "timeline.loop.frame_0.y",
									$k => array("animation position", "layer animation position", "animate top", "animate bottom", "translatey"),
									$d => __("The 'y' (top) position to apply at the start of the loop animation.  Accepts positive and negative numbers.", 'revsliderhelp'),
									$a => $u . "looping-animations/",
									$hl => array(
										$dp => array(
											'layerselected',
											array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
											'*[data-showloop="#loop_move_settings"]'
										), 
										$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
										$st => '#layer_loop_settings .loop_wrapbrtn', 
										$f => "*[data-r='timeline.loop.frame_0.y']"
									)
								),
								'endy' => array(
									$t => __("End Y Position", 'revsliderhelp'),
									$h => "timeline.loop.frame_999.y",
									$k => array("animation position", "layer animation position", "animate top", "animate bottom", "translatey"),
									$d => __("Animate the Layer to this 'y' (top) position.  Accepts positive and negative numbers.", 'revsliderhelp'),
									$a => $u . "looping-animations/",
									$hl => array(
										$dp => array(
											'layerselected',
											array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
											'*[data-showloop="#loop_move_settings"]'
										), 
										$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
										$st => '#layer_loop_settings .loop_wrapbrtn', 
										$f => "*[data-r='timeline.loop.frame_999.y']"
									)
								),
								'startz' => array(
									$t => __("Start Z Position", 'revsliderhelp'),
									$h => "timeline.loop.frame_0.z",
									$k => array("animation depth", "animation z", "translatez", "3d"),
									$d => __("The <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/transform-function/translateZ' target=_'blank'>CSS translateZ</a> at the start of the loop animation.  This adds/removes 3D depth to the Layer", 'revsliderhelp'),
									$a => $u . "looping-animations/",
									$hl => array(
										$dp => array(
											'layerselected',
											array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
											'*[data-showloop="#loop_move_settings"]'
										), 
										$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
										$st => '#layer_loop_settings .loop_wrapbrtn', 
										$f => "*[data-r='timeline.loop.frame_0.z']"
									)
								),
								'endz' => array(
									$t => __("End Z Position", 'revsliderhelp'),
									$h => "timeline.loop.frame_999.z",
									$k => array("animation depth", "animation z", "translatez", "3d"),
									$d => __("Animate the Layer's <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/transform-function/translateZ' target=_'blank'>CSS translateZ</a> property to this value.  This adds/removes 3D depth to the Layer", 'revsliderhelp'),
									$a => $u . "looping-animations/",
									$hl => array(
										$dp => array(
											'layerselected',
											array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
											'*[data-showloop="#loop_move_settings"]'
										), 
										$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
										$st => '#layer_loop_settings .loop_wrapbrtn',
										$f => "*[data-r='timeline.loop.frame_999.z']"
									)
								),
								'curved' => array(
									'enable' => array(
										$di => "layer_loop_move_curved",
										$t => __("Add a Bezier Curve", 'revsliderhelp'),
										$h => "timeline.loop.curved",
										$k => array("curved", "curved animation", "bezier", "bezier curve"),
										$d => __("Adds a middle point to the movement between the starting and ending points", 'revsliderhelp'),
										$a => $u . "looping-animations/",
										$hl => array(
											$dp => array(
												'layerselected',
												array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
												'*[data-showloop="#loop_move_settings"]'
											), 
											$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
											$st => '#layer_loop_settings .loop_wrapbrtn',
											$f => "*[data-r='timeline.loop.curved']"
										)
									),
									'auto_rotate' => array(
										$t => __("Auto Rotate Bezier", 'revsliderhelp'),
										$h => "timeline.loop.autoRotate",
										$k => array("curved", "curved animation", "bezier", "bezier curve"),
										$d => __("Automatically rotate the Layer according to its position along the Bezier path", 'revsliderhelp'),
										$a => $u . "looping-animations/",
										$hl => array(
											$dp => array(
												'layerselected',
												array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
												'*[data-showloop="#loop_move_settings"]',
												array($p => '#slide#.layers.#layer#.timeline.loop.curved', $v => true, $o => 'layer_loop_move_curved')
											), 
											$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
											$st => '#layer_loop_settings .loop_wrapbrtn',
											$f => "*[data-r='timeline.loop.autoRotate']"
										)
									),
									'angle' => array(
										$t => __("Bezier Curve Angle", 'revsliderhelp'),
										$h => "timeline.loop.radiusAngle",
										$k => array("curved", "curved animation", "bezier", "bezier curve", "curve angle", "angle"),
										$d => __("Represents the curve's placement in the animation.  Lower degrees will place the curve toward the beginning, and higher degrees toward the end.", 'revsliderhelp'),
										$a => $u . "looping-animations/",
										$hl => array(
											$dp => array(
												'layerselected',
												array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
												'*[data-showloop="#loop_move_settings"]',
												array($p => '#slide#.layers.#layer#.timeline.loop.curved', $v => true, $o => 'layer_loop_move_curved')
											), 
											$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
											$st => '#layer_loop_settings .loop_wrapbrtn',
											$f => "#le_loop_startangle"
										)
									),
									'tension' => array(
										$t => __("Bezier Curve Tension", 'revsliderhelp'),
										$h => "timeline.loop.curviness",
										$k => array("curved", "curved animation", "bezier", "bezier curve", "curve angle", "tension"),
										$d => __("Magnify the curve by this value.  1 = no magnification.  2 = twice the curve, etc.", 'revsliderhelp'),
										$a => $u . "looping-animations/",
										$hl => array(
											$dp => array(
												'layerselected',
												array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
												'*[data-showloop="#loop_move_settings"]',
												array($p => '#slide#.layers.#layer#.timeline.loop.curved', $v => true, $o => 'layer_loop_move_curved')
											), 
											$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
											$st => '#layer_loop_settings .loop_wrapbrtn',
											$f => "*[data-r='timeline.loop.curviness']"
										)
									),
									'bezier_x_start' => array(
										$t => __("Bezier Start Point X", 'revsliderhelp'),
										$h => "timeline.loop.frame_0.xr",
										$k => array("curved", "curved animation", "bezier", "bezier curve"),
										$d => __("Represents the starting 'x' (left) position for the bezier curve", 'revsliderhelp'),
										$a => $u . "looping-animations/",
										$hl => array(
											$dp => array(
												'layerselected',
												array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
												'*[data-showloop="#loop_move_settings"]',
												array($p => '#slide#.layers.#layer#.timeline.loop.curved', $v => true, $o => 'layer_loop_move_curved')
											), 
											$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
											$st => '#layer_loop_settings .loop_wrapbrtn',
											$f => "*[data-r='timeline.loop.frame_0.xr']"
										)
									),
									'bezier_x_end' => array(
										$t => __("Bezier End Point X", 'revsliderhelp'),
										$h => "timeline.loop.frame_999.xr",
										$k => array("curved", "curved animation", "bezier", "bezier curve"),
										$d => __("Represents the ending 'x' (left) position for the bezier curve", 'revsliderhelp'),
										$a => $u . "looping-animations/",
										$hl => array(
											$dp => array(
												'layerselected',
												array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
												'*[data-showloop="#loop_move_settings"]',
												array($p => '#slide#.layers.#layer#.timeline.loop.curved', $v => true, $o => 'layer_loop_move_curved')
											), 
											$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
											$st => '#layer_loop_settings .loop_wrapbrtn',
											$f => "*[data-r='timeline.loop.frame_999.xr']"
										)
									),
									'bezier_y_start' => array(
										$t => __("Bezier Start Point Y", 'revsliderhelp'),
										$h => "timeline.loop.frame_0.yr",
										$k => array("curved", "curved animation", "bezier", "bezier curve"),
										$d => __("Represents the starting 'y' (top) position for the bezier curve", 'revsliderhelp'),
										$a => $u . "looping-animations/",
										$hl => array(
											$dp => array(
												'layerselected',
												array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
												'*[data-showloop="#loop_move_settings"]',
												array($p => '#slide#.layers.#layer#.timeline.loop.curved', $v => true, $o => 'layer_loop_move_curved')
											), 
											$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
											$st => '#layer_loop_settings .loop_wrapbrtn',
											$f => "*[data-r='timeline.loop.frame_0.yr']"
										)
									),
									'bezier_y_end' => array(
										$t => __("Bezier End Point Y", 'revsliderhelp'),
										$h => "timeline.loop.frame_999.yr",
										$k => array("curved", "curved animation", "bezier", "bezier curve"),
										$d => __("Represents the ending 'y' (top) position for the bezier curve", 'revsliderhelp'),
										$a => $u . "looping-animations/",
										$hl => array(
											$dp => array(
												'layerselected',
												array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
												'*[data-showloop="#loop_move_settings"]',
												array($p => '#slide#.layers.#layer#.timeline.loop.curved', $v => true, $o => 'layer_loop_move_curved')
											), 
											$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
											$st => '#layer_loop_settings .loop_wrapbrtn',
											$f => "*[data-r='timeline.loop.frame_999.yr']"
										)
									),
									'bezier_z_start' => array(
										$t => __("Bezier Start Point Z", 'revsliderhelp'),
										$h => "timeline.loop.frame_0.zr",
										$k => array("curved", "curved animation", "bezier", "bezier curve"),
										$d => __("Represents the starting 'z' (3D depth) position for the bezier curve", 'revsliderhelp'),
										$a => $u . "looping-animations/",
										$hl => array(
											$dp => array(
												'layerselected',
												array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
												'*[data-showloop="#loop_move_settings"]',
												array($p => '#slide#.layers.#layer#.timeline.loop.curved', $v => true, $o => 'layer_loop_move_curved')
											), 
											$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
											$st => '#layer_loop_settings .loop_wrapbrtn',
											$f => "*[data-r='timeline.loop.frame_0.zr']"
										)
									),
									'bezier_z_end' => array(
										$t => __("Bezier End Point Z", 'revsliderhelp'),
										$h => "timeline.loop.frame_999.zr",
										$k => array("curved", "curved animation", "bezier", "bezier curve"),
										$d => __("Represents the ending 'z' (3D depth) position for the bezier curve", 'revsliderhelp'),
										$a => $u . "looping-animations/",
										$hl => array(
											$dp => array(
												'layerselected',
												array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
												'*[data-showloop="#loop_move_settings"]',
												array($p => '#slide#.layers.#layer#.timeline.loop.curved', $v => true, $o => 'layer_loop_move_curved')
											), 
											$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
											$st => '#layer_loop_settings .loop_wrapbrtn',
											$f => "*[data-r='timeline.loop.frame_999.zr']"
										)
									)
								)
							),
							'scale' => array(
								'yoyo' => array(
									$t => __("Yoyo Scaling", 'revsliderhelp'),
									$h => "timeline.loop.yoyo_scale",
									$k => array("yoyo", "yoyo animation", "yoyo transition", "loop animation"),
									$d => __("Reverse the scaling as soon as the animation ends and vice versa", 'revsliderhelp'),
									$a => $u . "looping-animations/",
									$hl => array(
										$dp => array(
											'layerselected',
											array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
											'*[data-showloop="#loop_scale_settings"]'
										), 
										$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
										$st => '#layer_loop_settings .loop_wrapbrtn',
										$f => "*[data-r='timeline.loop.yoyo_scale']"
									)
								),
								'scale_start_x' => array(
									$t => __("Start scaleX", 'revsliderhelp'),
									$h => "timeline.loop.frame_0.scaleX",
									$k => array("animation scale", "animation scalex", "scalex", "scale x", "scale"),
									$d => __("The starting scaleX value (width) for the loop animation", 'revsliderhelp'),
									$a => $u . "looping-animations/",
									$hl => array(
										$dp => array(
											'layerselected',
											array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
											'*[data-showloop="#loop_scale_settings"]'
										), 
										$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
										$st => '#layer_loop_settings .loop_wrapbrtn',
										$f => "*[data-r='timeline.loop.frame_0.scaleX']"
									)
								),
								'scale_end_x' => array(
									$t => __("End scaleX", 'revsliderhelp'),
									$h => "timeline.loop.frame_999.scaleX",
									$k => array("animation scale", "animation scalex", "scalex", "scale x", "scale"),
									$d => __("The ending scaleX value (width) for the loop animation", 'revsliderhelp'),
									$a => $u . "looping-animations/",
									$hl => array(
										$dp => array(
											'layerselected',
											array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
											'*[data-showloop="#loop_scale_settings"]'
										), 
										$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
										$st => '#layer_loop_settings .loop_wrapbrtn',
										$f => "*[data-r='timeline.loop.frame_999.scaleX']"
									)
								),
								'scale_start_y' => array(
									$t => __("Start scaleY", 'revsliderhelp'),
									$h => "timeline.loop.frame_0.scaleY",
									$k => array("animation scale", "animation scaley", "scaley", "scale y", "scale"),
									$d => __("The starting scaleY value (height) for the loop animation", 'revsliderhelp'),
									$a => $u . "looping-animations/",
									$hl => array(
										$dp => array(
											'layerselected',
											array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
											'*[data-showloop="#loop_scale_settings"]'
										), 
										$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
										$st => '#layer_loop_settings .loop_wrapbrtn',
										$f => "*[data-r='timeline.loop.frame_0.scaleY']"
									)
								),
								'scale_end_y' => array(
									$t => __("End scaleY", 'revsliderhelp'),
									$h => "timeline.loop.frame_999.scaleY",
									$k => array("animation scale", "animation scaley", "scaley", "scale y", "scale"),
									$d => __("The ending scaleY value (height) for the loop animation", 'revsliderhelp'),
									$a => $u . "looping-animations/",
									$hl => array(
										$dp => array(
											'layerselected',
											array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
											'*[data-showloop="#loop_scale_settings"]'
										), 
										$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
										$st => '#layer_loop_settings .loop_wrapbrtn',
										$f => "*[data-r='timeline.loop.frame_999.scaleY']"
									)
								),
								'skew_start_x' => array(
									$t => __("Start skewX", 'revsliderhelp'),
									$h => "timeline.loop.frame_0.skewX",
									$k => array("animation skew", "animation skewx", "skewx", "skew x", "skew"),
									$d => __("The starting skewX value (horizontal plane) for the loop animation", 'revsliderhelp'),
									$a => $u . "looping-animations/",
									$hl => array(
										$dp => array(
											'layerselected',
											array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
											'*[data-showloop="#loop_scale_settings"]'
										), 
										$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
										$st => '#layer_loop_settings .loop_wrapbrtn',
										$f => "*[data-r='timeline.loop.frame_0.skewX']"
									)
								),
								'skew_end_x' => array(
									$t => __("End skewX", 'revsliderhelp'),
									$h => "timeline.loop.frame_999.skewX",
									$k => array("animation skew", "animation skewx", "skewx", "skew x", "skew"),
									$d => __("The ending skewX value (horizontal plane) for the loop animation", 'revsliderhelp'),
									$a => $u . "looping-animations/",
									$hl => array(
										$dp => array(
											'layerselected',
											array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
											'*[data-showloop="#loop_scale_settings"]'
										), 
										$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
										$st => '#layer_loop_settings .loop_wrapbrtn',
										$f => "*[data-r='timeline.loop.frame_999.skewX']"
									)
								),
								'skew_start_y' => array(
									$t => __("Start skewY", 'revsliderhelp'),
									$h => "timeline.loop.frame_0.skewY",
									$k => array("animation skew", "animation skewy", "skewy", "skew y", "skew"),
									$d => __("The starting skewY value (vertical plane) for the loop animation", 'revsliderhelp'),
									$a => $u . "looping-animations/",
									$hl => array(
										$dp => array(
											'layerselected',
											array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
											'*[data-showloop="#loop_scale_settings"]'
										), 
										$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
										$st => '#layer_loop_settings .loop_wrapbrtn',
										$f => "*[data-r='timeline.loop.frame_0.skewY']"
									)
								),
								'skew_end_y' => array(
									$t => __("End skewY", 'revsliderhelp'),
									$h => "timeline.loop.frame_999.skewY",
									$k => array("animation skew", "animation skewy", "skewy", "skew y", "skew"),
									$d => __("The ending skewY value (vertical plane) for the loop animation", 'revsliderhelp'),
									$a => $u . "looping-animations/",
									$hl => array(
										$dp => array(
											'layerselected',
											array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
											'*[data-showloop="#loop_scale_settings"]'
										), 
										$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
										$st => '#layer_loop_settings .loop_wrapbrtn',
										$f => "*[data-r='timeline.loop.frame_999.skewY']"
									)
								)
							),
							'rotate' => array(
								'yoyo' => array(
									$t => __("Yoyo Rotation", 'revsliderhelp'),
									$h => "timeline.loop.yoyo_rotate",
									$k => array("yoyo", "yoyo animation", "yoyo transition", "loop animation"),
									$d => __("Reverse the rotation as soon as the animation ends and vice versa", 'revsliderhelp'),
									$a => $u . "looping-animations/",
									$hl => array(
										$dp => array(
											'layerselected',
											array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
											'*[data-showloop="#loop_rotate_settings"]'
										), 
										$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
										$st => '#layer_loop_settings .loop_wrapbrtn',
										$f => "*[data-r='timeline.loop.yoyo_rotate']"
									)
								),
								'start_rotation_x' => array(
									$t => __("Start rotateX", 'revsliderhelp'),
									$h => "timeline.loop.frame_0.rotationX",
									$k => array("animation rotation", "animation rotatex", "rotatex", "rotationx", "rotation x", "3d", "3d rotation"),
									$d => __("The starting rotateX value (horizontal plane) for the loop animation.  Accepts positive and negative values.", 'revsliderhelp'),
									$a => $u . "looping-animations/",
									$hl => array(
										$dp => array(
											'layerselected',
											array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
											'*[data-showloop="#loop_rotate_settings"]'
										), 
										$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
										$st => '#layer_loop_settings .loop_wrapbrtn',
										$f => "*[data-r='timeline.loop.frame_0.rotationX']"
									)
								),
								'end_rotation_x' => array(
									$t => __("End rotateX", 'revsliderhelp'),
									$h => "timeline.loop.frame_999.rotationX",
									$k => array("animation rotation", "animation rotatex", "rotatex", "rotationx", "rotation x", "3d", "3d rotation"),
									$d => __("The ending rotateX value (horizontal plane) for the loop animation.  Accepts positive and negative values.", 'revsliderhelp'),
									$a => $u . "looping-animations/",
									$hl => array(
										$dp => array(
											'layerselected',
											array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
											'*[data-showloop="#loop_rotate_settings"]'
										), 
										$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
										$st => '#layer_loop_settings .loop_wrapbrtn',
										$f => "*[data-r='timeline.loop.frame_999.rotationX']"
									)
								),
								'start_rotation_y' => array(
									$t => __("Start rotateY", 'revsliderhelp'),
									$h => "timeline.loop.frame_0.rotationY",
									$k => array("animation rotation", "animation rotatey", "rotatey", "rotationy", "rotation y", "3d", "3d rotation"),
									$d => __("The starting rotateY value (horizontal plane) for the loop animation.  Accepts positive and negative values.", 'revsliderhelp'),
									$a => $u . "looping-animations/",
									$hl => array(
										$dp => array(
											'layerselected',
											array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
											'*[data-showloop="#loop_rotate_settings"]'
										), 
										$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
										$st => '#layer_loop_settings .loop_wrapbrtn',
										$f => "*[data-r='timeline.loop.frame_0.rotationY']"
									)
								),
								'end_rotation_y' => array(
									$t => __("End rotateY", 'revsliderhelp'),
									$h => "timeline.loop.frame_999.rotationY",
									$k => array("animation rotation", "animation rotatey", "rotatey", "rotationy", "rotation y", "3d", "3d rotation"),
									$d => __("The ending rotateY value (horizontal plane) for the loop animation.  Accepts positive and negative values.", 'revsliderhelp'),
									$a => $u . "looping-animations/",
									$hl => array(
										$dp => array(
											'layerselected',
											array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
											'*[data-showloop="#loop_rotate_settings"]'
										), 
										$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
										$st => '#layer_loop_settings .loop_wrapbrtn',
										$f => "*[data-r='timeline.loop.frame_999.rotationY']"
									)
								),
								'start_rotation_2d' => array(
									$t => __("Start rotate2D", 'revsliderhelp'),
									$h => "timeline.loop.frame_0.rotationZ",
									$k => array("animation rotation", "animation rotatey", "rotatey", "rotationy", "rotation y", "2d", "2d rotation"),
									$d => __("The starting rotation value (2D) for the loop animation.  Accepts positive and negative values.", 'revsliderhelp'),
									$a => $u . "looping-animations/",
									$hl => array(
										$dp => array(
											'layerselected',
											array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
											'*[data-showloop="#loop_rotate_settings"]'
										), 
										$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
										$st => '#layer_loop_settings .loop_wrapbrtn',
										$f => "*[data-r='timeline.loop.frame_0.rotationZ']"
									)
								),
								'end_rotation_2d' => array(
									$t => __("End rotate2D", 'revsliderhelp'),
									$h => "timeline.loop.frame_999.rotationZ",
									$k => array("animation rotation", "animation rotatey", "rotatey", "rotationy", "rotation y", "2d", "2d rotation"),
									$d => __("The ending rotation value (2D) for the loop animation.  Accepts positive and negative values.", 'revsliderhelp'),
									$a => $u . "looping-animations/",
									$hl => array(
										$dp => array(
											'layerselected',
											array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
											'*[data-showloop="#loop_rotate_settings"]'
										), 
										$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
										$st => '#layer_loop_settings .loop_wrapbrtn',
										$f => "*[data-r='timeline.loop.frame_999.rotationZ']"
									)
								)
							),
							'filter' => array(
								'yoyo' => array(
									$t => __("Yoyo Filters", 'revsliderhelp'),
									$h => "timeline.loop.yoyo_filter",
									$k => array("yoyo", "yoyo animation", "yoyo transition", "loop animation"),
									$d => __("Reverse the animated filters as soon as the animation ends and vice versa", 'revsliderhelp'),
									$a => $u . "looping-animations/",
									$hl => array(
										$dp => array(
											'layerselected',
											array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
											'*[data-showloop="#loop_filter_settings"]'
										), 
										$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
										$st => '#layer_loop_settings .loop_wrapbrtn',
										$f => "*[data-r='timeline.loop.yoyo_filter']"
									)
								),
								'opacity_start' => array(
									$t => __("Opacity Start", 'revsliderhelp'),
									$h => "timeline.loop.frame_0.opacity",
									$k => array("animate filter", "filter animation", "filter", "filters", "opacity filter", "opacity"),
									$d => __("The starting transparency for the loop animation", 'revsliderhelp'),
									$a => $u . "looping-animations/",
									$hl => array(
										$dp => array(
											'layerselected',
											array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
											'*[data-showloop="#loop_filter_settings"]'
										), 
										$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
										$st => '#layer_loop_settings .loop_wrapbrtn',
										$f => "*[data-r='timeline.loop.frame_0.opacity']"
									)
								),
								'opacity_end' => array(
									$t => __("Opacity End", 'revsliderhelp'),
									$h => "timeline.loop.frame_999.opacity",
									$k => array("animate filter", "filter animation", "filter", "filters", "opacity filter", "opacity"),
									$d => __("The ending transparency for the loop animation", 'revsliderhelp'),
									$a => $u . "looping-animations/",
									$hl => array(
										$dp => array(
											'layerselected',
											array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
											'*[data-showloop="#loop_filter_settings"]'
										), 
										$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
										$st => '#layer_loop_settings .loop_wrapbrtn',
										$f => "*[data-r='timeline.loop.frame_999.opacity']"
									)
								),
								'blur_start' => array(
									$t => __("Blur Start", 'revsliderhelp'),
									$h => "timeline.loop.frame_0.blur",
									$k => array("animate filter", "filter animation", "filter", "filters", "blur filter", "blur"),
									$d => __("The starting <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/filter-function/blur' target='_blank'>blur filter</a> value for the loop animation", 'revsliderhelp'),
									$a => $u . "looping-animations/",
									$hl => array(
										$dp => array(
											'layerselected',
											array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
											'*[data-showloop="#loop_filter_settings"]'
										), 
										$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
										$st => '#layer_loop_settings .loop_wrapbrtn',
										$f => "*[data-r='timeline.loop.frame_0.blur']"
									)
								),
								'blur_end' => array(
									$t => __("Blur End", 'revsliderhelp'),
									$h => "timeline.loop.frame_999.blur",
									$k => array("animate filter", "filter animation", "filter", "filters", "blur filter", "blur"),
									$d => __("The ending <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/filter-function/blur' target='_blank'>blur filter</a> value for the loop animation", 'revsliderhelp'),
									$a => $u . "looping-animations/",
									$hl => array(
										$dp => array(
											'layerselected',
											array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
											'*[data-showloop="#loop_filter_settings"]'
										), 
										$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
										$st => '#layer_loop_settings .loop_wrapbrtn',
										$f => "*[data-r='timeline.loop.frame_999.blur']"
									)
								),
								'grayscale_start' => array(
									$t => __("Grayscale Start", 'revsliderhelp'),
									$h => "timeline.loop.frame_0.grayscale",
									$k => array("animate filter", "filter animation", "filter", "filters", "grayscale filter", "grayscale"),
									$d => __("The starting <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/filter-function/grayscale' target='_blank'>grayscale filter</a> value for the loop animation", 'revsliderhelp'),
									$a => $u . "looping-animations/",
									$hl => array(
										$dp => array(
											'layerselected',
											array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
											'*[data-showloop="#loop_filter_settings"]'
										), 
										$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
										$st => '#layer_loop_settings .loop_wrapbrtn',
										$f => "*[data-r='timeline.loop.frame_0.grayscale']"
									)
								),
								'grayscale_end' => array(
									$t => __("Grayscale End", 'revsliderhelp'),
									$h => "timeline.loop.frame_999.grayscale",
									$k => array("animate filter", "filter animation", "filter", "filters", "grayscale filter", "grayscale"),
									$d => __("The ending <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/filter-function/grayscale' target='_blank'>grayscale filter</a> value for the loop animation", 'revsliderhelp'),
									$a => $u . "looping-animations/",
									$hl => array(
										$dp => array(
											'layerselected',
											array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
											'*[data-showloop="#loop_filter_settings"]'
										), 
										$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
										$st => '#layer_loop_settings .loop_wrapbrtn',
										$f => "*[data-r='timeline.loop.frame_999.grayscale']"
									)
								),
								'brightness_start' => array(
									$t => __("Brightness Start", 'revsliderhelp'),
									$h => "timeline.loop.frame_0.brightness",
									$k => array("animate filter", "filter animation", "filter", "filters", "brightness filter", "brightness"),
									$d => __("The starting <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/filter-function/grayscale' target='_blank'>brightness filter</a> value for the loop animation", 'revsliderhelp'),
									$a => $u . "looping-animations/",
									$hl => array(
										$dp => array(
											'layerselected',
											array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
											'*[data-showloop="#loop_filter_settings"]'
										), 
										$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
										$st => '#layer_loop_settings .loop_wrapbrtn',
										$f => "*[data-r='timeline.loop.frame_0.brightness']"
									)
								),
								'brightness_end' => array(
									$t => __("Brightness End", 'revsliderhelp'),
									$h => "timeline.loop.frame_999.brightness",
									$k => array("animate filter", "filter animation", "filter", "filters", "brightness filter", "brightness"),
									$d => __("The ending <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/filter-function/grayscale' target='_blank'>brightness filter</a> value for the loop animation", 'revsliderhelp'),
									$a => $u . "looping-animations/",
									$hl => array(
										$dp => array(
											'layerselected',
											array($p => '#slide#.layers.#layer#.timeline.loop.use', $v => true, $o => 'layer_looping'),
											'*[data-showloop="#loop_filter_settings"]'
										), 
										$m => "#module_layers_trigger, #gst_layer_15, #la_looping-tab-2 .ssmbtn", 
										$st => '#layer_loop_settings .loop_wrapbrtn',
										$f => "*[data-r='timeline.loop.frame_999.brightness']"
									)
								)
							)
						)
					),
					'gst_layer_9' => array(
						'enable' => array(
							$di => "enable_hover", 
							$t => __("Mouse Hover", 'revsliderhelp'),
							$h => "hover.usehover",
							$k => array("mouse hover", "mouseover", "mouse over", "mouse hover", "hover", "hover animation", "hover style", "hover styles"),
							$d => __("Activate mouse hover styles/transitions", 'revsliderhelp'),
							$a => $u . "mouse-hover-settings/",
							$hl => array(
								$dp => array('layerselected'), 
								$m => "#module_layers_trigger, #gst_layer_9", 
								$st => '#form_layer_hover', 
								$f => "#layer_usehover"
							)
						),
						'reset' => array(
							$t => __("Reset Styles", 'revsliderhelp'),
							$h => "resethover",
							$k => array("mouse hover", "mouseover", "mouse over", "mouse hover", "hover", "hover animation", "hover style", "hover styles", "reset", "reset styles"),
							$d => __("Reset all hover styles to the Layer's default idle/static styles", 'revsliderhelp'),
							$a => $u . "mouse-hover-settings/#general-settings",
							$hl => array(
								$dp => array(
									'layerselected',
									array($p => '#slide#.layers.#layer#.hover.usehover', $v => true, $o => 'enable_hover')
								), 
								$m => "#module_layers_trigger, #gst_layer_9", 
								$st => '#form_layer_hover', 
								$f => "#copyhoversettings"
							)
						),
						'cursor' => array(
							$t => __("Cursor Type", 'revsliderhelp'),
							$h => "idle.cursor",
							$k => array("mouse hover", "mouseover", "mouse over", "mouse hover", "hover", "hover animation", "hover style", "hover styles"),
							$d => __("The <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/cursor' target='_blank'>CSS cursor</a> property for the Layer.  Choose 'pointer' for a traditional hand cursor when hovering the Layer", 'revsliderhelp'),
							$a => $u . "mouse-hover-settings/#general-settings",
							$hl => array(
								$dp => array('layerselected'), 
								$m => "#module_layers_trigger, #gst_layer_9", 
								$st => '#form_layer_hover', 
								$f => "#layer_css_cursor"
							)
						),
						'pointer_events' => array(
							$t => __("Pointer Events", 'revsliderhelp'),
							$h => "hover.pointerEvents",
							$k => array("pointer-events", "pointer-event", "pointer event", "pointer-event"),
							$d => __("Choose 'none' to disable user-interaction.  Useful for enabling clicks on content placed beneath the Layer.", 'revsliderhelp'),
							$a => $u . "mouse-hover-settings/#general-settings",
							$hl => array(
								$dp => array('layerselected'), 
								$m => "#module_layers_trigger, #gst_layer_9", 
								$st => '#form_layer_hover', 
								$f => "*[data-r='hover.pointerEvents']"
							)
						),
						'mask' => array(
							$t => __("Masking", 'revsliderhelp'),
							$h => "hover.usehovermask",
							$k => array("hover", "masking", "mask", "mask hover", "hover mask", "hover masking"),
							$d => __("Mask the current Layer before applying hover styles/effects.  Useful for movements and scale/zooms.", 'revsliderhelp'),
							$a => $u . "mouse-hover-settings/#general-settings",
							$hl => array(
								$dp => array('layerselected'), 
								$m => "#module_layers_trigger, #gst_layer_9", 
								$st => '#form_layer_hover', 
								$f => "#layer_usehovermask"
							)
						),
						'background_hover' => array(
							$t => __("Hover Background Color", 'revsliderhelp'),
							$h => "hover.backgroundColor",
							$k => array("hover bg color", "hover background color", "bg hover", "background hover"),
							$d => __("Adjust the Layer's background color on mouse hover", 'revsliderhelp'),
							$a => $u . "mouse-hover-settings/#font-background",
							$hl => array(
								$dp => array('layerselected'), 
								$m => "#module_layers_trigger, #gst_layer_9", 
								$st => '#form_layer_hover .form_inner:nth-child(5)', 
								$f => "#layerBGColorHover"
							)
						),
						'hover_transform' => array(
							'speed' => array(
								$t => __("Transition Speed", 'revsliderhelp'),
								$h => "hover.speed",
								$k => array("transition speed", "hover transition speed", "hover duration"),
								$d => __("The transition duration for the currently selected Layer (in milliseconds)", 'revsliderhelp'),
								$a => $u . "mouse-hover-settings/#hover-transforms",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_9", 
									$st => '#form_layer_hover .form_inner:nth-child(2)', 
									$f => "*[data-r='hover.speed']"
								)
							),
							'easing' => array(
								$t => __("Transition Easing", 'revsliderhelp'),
								$h => "hover.ease",
								$k => array("easing", "transition easing", "hover easing", "animation easing"),
								$d => __("The easing equation to use for the hover transition", 'revsliderhelp'),
								$a => $u . "mouse-hover-settings/#hover-transforms",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_9", 
									$st => '#form_layer_hover .form_inner:nth-child(2)', 
									$f => "#layer_hover_appear_ease"
								)
							),
							'zindex' => array(
								$t => __("zIndex", 'revsliderhelp'),
								$h => "hover.zIndex",
								$k => array("zindex", "hover zindex", "hover z-index"),
								$d => __("The CSS z-index to apply to the Layer on mouse hover", 'revsliderhelp'),
								$a => $u . "mouse-hover-settings/#hover-transforms",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_9", 
									$st => '#form_layer_hover .form_inner:nth-child(2)', 
									$f => "#layer_hover_zindex"
								)
							),
							'opacity' => array(
								$t => __("Opacity", 'revsliderhelp'),
								$h => "hover.opacity",
								$k => array("opacity", "animation opacity", "transparency", "animate opacity"),
								$d => __("Change the Layer's transparency on mouse hover", 'revsliderhelp'),
								$a => $u . "mouse-hover-settings/#hover-transforms",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_9", 
									$st => '#form_layer_hover .form_inner:nth-child(2)', 
									$f => "*[data-r='hover.opacity']"
								)
							),
							'scale_skew_rotate' => array(
								'scalex' => array(
									$t => __("scaleX", 'revsliderhelp'),
									$h => "hover.scaleX",
									$k => array("animation scale", "animation scalex", "scalex", "scale x", "scale"),
									$d => __("Scale the Layer's width by this amount on mouse hover", 'revsliderhelp'),
									$a => $u . "mouse-hover-settings/#hover-transforms",
									$hl => array(
										$dp => array('layerselected'), 
										$m => "#module_layers_trigger, #gst_layer_9", 
										$st => '#form_layer_hover .form_inner:nth-child(2)', 
										$f => "*[data-r='hover.scaleX']"
									)
								),
								'scaley' => array(
									$t => __("scaleY", 'revsliderhelp'),
									$h => "hover.scaleY",
									$k => array("animation scale", "animation scaley", "scaley", "scale y", "scale"),
									$d => __("Scale the Layer's height by this amount on mouse hover", 'revsliderhelp'),
									$a => $u . "mouse-hover-settings/#hover-transforms",
									$hl => array(
										$dp => array('layerselected'), 
										$m => "#module_layers_trigger, #gst_layer_9", 
										$st => '#form_layer_hover .form_inner:nth-child(2)', 
										$f => "*[data-r='hover.scaleY']"
									)
								),
								'skewx' => array(
									$t => __("skewX", 'revsliderhelp'),
									$h => "hover.skewX",
									$k => array("animation skew", "animation skewx", "skew x", "skewx", "skew"),
									$d => __("Skew/distort the Layer horizontally by this amount on mouse hover.  Accepts positive and negative values.", 'revsliderhelp'),
									$a => $u . "mouse-hover-settings/#hover-transforms",
									$hl => array(
										$dp => array('layerselected'), 
										$m => "#module_layers_trigger, #gst_layer_9", 
										$st => '#form_layer_hover .form_inner:nth-child(2)', 
										$f => "*[data-r='hover.skewX']"
									)
								),
								'skewy' => array(
									$t => __("skewY", 'revsliderhelp'),
									$h => "hover.skewY",
									$k => array("animation skew", "animation skewy", "skew y", "skewy", "skew"),
									$d => __("Skew/distort the Layer vertically by this amount on mouse hover.  Accepts positive and negative values.", 'revsliderhelp'),
									$a => $u . "mouse-hover-settings/#hover-transforms",
									$hl => array(
										$dp => array('layerselected'), 
										$m => "#module_layers_trigger, #gst_layer_9", 
										$st => '#form_layer_hover .form_inner:nth-child(2)', 
										$f => "*[data-r='hover.skewY']"
									)
								),
								'rotationx' => array(
									$t => __("rotateX", 'revsliderhelp'),
									$h => "hover.rotationX",
									$k => array("animation rotation", "animation rotatex", "rotatex", "rotationx", "rotation x", "3d", "3d rotation"),
									$d => __("Rotate the Layer on its 'x' axis by this amount on mouse hover.  Accepts positive and negative values.", 'revsliderhelp'),
									$a => $u . "mouse-hover-settings/#hover-transforms",
									$hl => array(
										$dp => array('layerselected'), 
										$m => "#module_layers_trigger, #gst_layer_9", 
										$st => '#form_layer_hover .form_inner:nth-child(2)', 
										$f => "*[data-r='hover.rotationX']"
									)
								),
								'rotationy' => array(
									$t => __("rotateY", 'revsliderhelp'),
									$h => "hover.rotationY",
									$k => array("animation rotation", "animation rotatey", "rotatey", "rotationy", "rotation y", "3d", "3d rotation"),
									$d => __("Rotate the Layer on its 'y' axis by this amount on mouse hover.  Accepts positive and negative values.", 'revsliderhelp'),
									$a => $u . "mouse-hover-settings/#hover-transforms",
									$hl => array(
										$dp => array('layerselected'), 
										$m => "#module_layers_trigger, #gst_layer_9", 
										$st => '#form_layer_hover .form_inner:nth-child(2)', 
										$f => "*[data-r='hover.rotationY']"
									)
								),
								'rotation' => array(
									$t => __("2D Rotation", 'revsliderhelp'),
									$h => "hover.rotationZ",
									$k => array("animation rotation", "animation rotate", "rotate", "rotation", "2d", "2d rotation"),
									$d => __("The Layer's <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/transform-function/rotate' target='_blank'>2D Rotation</a> on mouse hover.  Accepts positive and negative values.", 'revsliderhelp'),
									$a => $u . "mouse-hover-settings/#hover-transforms",
									$hl => array(
										$dp => array('layerselected'), 
										$m => "#module_layers_trigger, #gst_layer_9", 
										$st => '#form_layer_hover .form_inner:nth-child(2)', 
										$f => "*[data-r='hover.rotationZ']"
									)
								)
							),
							'transform_origin' => array(
								'originx' => array(
									$t => __("Transform Origin X", 'revsliderhelp'),
									$h => "hover.originX",
									$k => array("animation origin", "animation originx", "transform origin", "transform-origin"),
									$d => __("The 'x' axis for the Layer's <a href='https://www.w3schools.com/cssref/css3_pr_transform-origin.asp' target='_blank'>transform-origin</a> on mouse hover.", 'revsliderhelp'),
									$a => $u . "mouse-hover-settings/#hover-transforms",
									$hl => array(
										$dp => array('layerselected'), 
										$m => "#module_layers_trigger, #gst_layer_9", 
										$st => '#form_layer_hover .form_inner:nth-child(2)', 
										$f => "*[data-r='hover.originX']"
									)
								),
								'originy' => array(
									$t => __("Transform Origin Y", 'revsliderhelp'),
									$h => "hover.originY",
									$k => array("animation origin", "animation originx", "transform origin", "transform-origin"),
									$d => __("The 'y' axis for the Layer's <a href='https://www.w3schools.com/cssref/css3_pr_transform-origin.asp' target='_blank'>transform-origin</a> on mouse hover.", 'revsliderhelp'),
									$a => $u . "mouse-hover-settings/#hover-transforms",
									$hl => array(
										$dp => array('layerselected'), 
										$m => "#module_layers_trigger, #gst_layer_9", 
										$st => '#form_layer_hover .form_inner:nth-child(2)', 
										$f => "*[data-r='hover.originY']"
									)
								),
								'originz' => array(
									$t => __("Transform Origin Z", 'revsliderhelp'),
									$h => "hover.originZ",
									$k => array("animation origin", "animation originx", "transform origin", "transform-origin"),
									$d => __("The 'z' axis for the Layer's <a href='https://www.w3schools.com/cssref/css3_pr_transform-origin.asp' target='_blank'>transform-origin</a> on mouse hover.", 'revsliderhelp'),
									$a => $u . "mouse-hover-settings/#hover-transforms",
									$hl => array(
										$dp => array('layerselected'), 
										$m => "#module_layers_trigger, #gst_layer_9", 
										$st => '#form_layer_hover .form_inner:nth-child(2)', 
										$f => "*[data-r='hover.originZ']"
									)
								),
								'perspective' => array(
									$t => __("Transform Perspective", 'revsliderhelp'),
									$h => "hover.transformPerspective",
									$k => array("animation perspective", "perspective", "transform perspective", "transform-perspective", "3d"),
									$d => __("The <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/perspective' target=_'blank'>CSS perspective</a> for the Layer on mouse hover", 'revsliderhelp'),
									$a => $u . "mouse-hover-settings/#hover-transforms",
									$hl => array(
										$dp => array('layerselected'), 
										$m => "#module_layers_trigger, #gst_layer_9", 
										$st => '#form_layer_hover .form_inner:nth-child(2)', 
										$f => "#le_frame_hover_perspective"
									)
								)
							)
						),
						'border_hover' => array(
							'border_color' => array(
								$t => __("Border Color", 'revsliderhelp'),
								$h => "hover.borderColor",
								$k => array("border", "border color", "layer border", "layer border color", "layers border"),
								$d => __("The border color for the Layer on mouse hover", 'revsliderhelp'),
								$a => $u . "mouse-hover-settings/#border-hover",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_9", 
									$st => '#form_layer_hover .form_inner:nth-child(6)', 
									$f => "#layerBorderColorHover"
								)
							),
							'border_style' => array(
								$t => __("Border Style", 'revsliderhelp'),
								$h => "hover.borderStyle",
								$k => array("border", "border style", "layer border", "layer border style", "layers border"),
								$d => __("The <a href='https://www.w3schools.com/cssref/pr_border-style.asp' target='_blank'>CSS border-style</a> for the Layer on mouse hover", 'revsliderhelp'),
								$a => $u . "mouse-hover-settings/#border-hover",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_9", 
									$st => '#form_layer_hover .form_inner:nth-child(6)', 
									$f => "#hover_layer_border_style"
								)
							),
							'border_size' => array(
								'border_width_top' => array(
									$t => __("Border Top Width", 'revsliderhelp'),
									$h => "hover.borderWidth.0",
									$k => array("border", "border size", "layer border", "layer border size", "layers border", "border-width"),
									$d => __("The border's top size (border-top-width) for the Layer on mouse hover", 'revsliderhelp'),
									$a => $u . "mouse-hover-settings/#border-hover",
									$hl => array(
										$dp => array('layerselected'), 
										$m => "#module_layers_trigger, #gst_layer_9", 
										$st => '#form_layer_hover .form_inner:nth-child(6)', 
										$f => "*[data-r='hover.borderWidth.0']"
									)
								),
								'border_width_right' => array(
									$t => __("Border Right Width", 'revsliderhelp'),
									$h => "hover.borderWidth.1",
									$k => array("border", "border size", "layer border", "layer border size", "layers border", "border-width"),
									$d => __("The border's right size (border-right-width) for the Layer on mouse hover", 'revsliderhelp'),
									$a => $u . "mouse-hover-settings/#border-hover",
									$hl => array(
										$dp => array('layerselected'), 
										$m => "#module_layers_trigger, #gst_layer_9", 
										$st => '#form_layer_hover .form_inner:nth-child(6)', 
										$f => "*[data-r='hover.borderWidth.1']"
									)
								),
								'border_width_bottom' => array(
									$t => __("Border Bottom Width", 'revsliderhelp'),
									$h => "hover.borderWidth.2",
									$k => array("border", "border size", "layer border", "layer border size", "layers border", "border-width"),
									$d => __("The border's bottom size (border-bottom-width) for the Layer on mouse hover", 'revsliderhelp'),
									$a => $u . "mouse-hover-settings/#border-hover",
									$hl => array(
										$dp => array('layerselected'), 
										$m => "#module_layers_trigger, #gst_layer_9", 
										$st => '#form_layer_hover .form_inner:nth-child(6)', 
										$f => "*[data-r='hover.borderWidth.2']"
									)
								),
								'border_width_left' => array(
									$t => __("Border Left Width", 'revsliderhelp'),
									$h => "hover.borderWidth.3",
									$k => array("border", "border size", "layer border", "layer border size", "layers border", "border-width"),
									$d => __("The border's left size (border-left-width) for the Layer on mouse hover", 'revsliderhelp'),
									$a => $u . "mouse-hover-settings/#border-hover",
									$hl => array(
										$dp => array('layerselected'), 
										$m => "#module_layers_trigger, #gst_layer_9", 
										$st => '#form_layer_hover .form_inner:nth-child(6)', 
										$f => "*[data-r='hover.borderWidth.3']"
									)
								)
							),
							'border_radius' => array(
								'border_radius_top_left' => array(
									$t => __("Border Radius Top Left", 'revsliderhelp'),
									$h => "hover.borderRadius.v.0",
									$k => array("border radius", "border-radius", "layer border radius", "layer border-radius"),
									$d => __("The top-left corner border-radius for the Layer on mouse hover (px or %)", 'revsliderhelp'),
									$a => $u . "mouse-hover-settings/#border-hover",
									$hl => array(
										$dp => array('layerselected'), 
										$m => "#module_layers_trigger, #gst_layer_9", 
										$st => '#form_layer_hover .form_inner:nth-child(6)', 
										$f => "*[data-r='hover.borderRadius.v.0']"
									)
								),
								'border_radius_top_right' => array(
									$t => __("Border Radius Top Right", 'revsliderhelp'),
									$h => "hover.borderRadius.v.1",
									$k => array("border radius", "border-radius", "layer border radius", "layer border-radius"),
									$d => __("The top-right corner border-radius for the Layer on mouse hover (px or %)", 'revsliderhelp'),
									$a => $u . "mouse-hover-settings/#border-hover",
									$hl => array(
										$dp => array('layerselected'), 
										$m => "#module_layers_trigger, #gst_layer_9", 
										$st => '#form_layer_hover .form_inner:nth-child(6)', 
										$f => "*[data-r='hover.borderRadius.v.1']"
									)
								),
								'border_radius_bottom_left' => array(
									$t => __("Border Radius Bottom Left", 'revsliderhelp'),
									$h => "hover.borderRadius.v.2",
									$k => array("border radius", "border-radius", "layer border radius", "layer border-radius"),
									$d => __("The bottom-left corner border-radius for the Layer on mouse hover (px or %)", 'revsliderhelp'),
									$a => $u . "mouse-hover-settings/#border-hover",
									$hl => array(
										$dp => array('layerselected'), 
										$m => "#module_layers_trigger, #gst_layer_9", 
										$st => '#form_layer_hover .form_inner:nth-child(6)', 
										$f => "*[data-r='hover.borderRadius.v.2']"
									)
								),
								'border_radius_bottom_right' => array(
									$t => __("Border Radius Bottom Right", 'revsliderhelp'),
									$h => "hover.borderRadius.v.3",
									$k => array("border radius", "border-radius", "layer border radius", "layer border-radius"),
									$d => __("The bottom-right corner border-radius for the Layer on mouse hover (px or %)", 'revsliderhelp'),
									$a => $u . "mouse-hover-settings/#border-hover",
									$hl => array(
										$dp => array('layerselected'), 
										$m => "#module_layers_trigger, #gst_layer_9", 
										$st => '#form_layer_hover .form_inner:nth-child(6)', 
										$f => "*[data-r='hover.borderRadius.v.3']"
									)
								)
							)
						),
						'filter_hover' => array(
							'blur' => array(
								$t => __("Blur Filter", 'revsliderhelp'),
								$h => "hover.filter.blur",
								$k => array("animate filter", "filter animation", "filter", "filters", "blur filter", "blur"),
								$d => __("The <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/filter-function/blur' target='_blank'>blur filter</a> value for the Layer on mouse hover", 'revsliderhelp'),
								$a => $u . "mouse-hover-settings/#filter-hover",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_9", 
									$st => '#form_layerstyle_css_hover', 
									$f => "*[data-r='hover.filter.blur']"
								)
							),
							'brightness' => array(
								$t => __("Brightness", 'revsliderhelp'),
								$h => "hover.filter.brightness",
								$k => array("animate filter", "filter animation", "filter", "filters", "brightness filter", "brightness"),
								$d => __("The <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/filter-function/brightness' target='_blank'>brightness filter</a> value for the Layer on mouse hover", 'revsliderhelp'),
								$a => $u . "mouse-hover-settings/#filter-hover",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_9", 
									$st => '#form_layerstyle_css_hover', 
									$f => "*[data-r='hover.filter.brightness']"
								)
							),
							'grayscale' => array(
								$t => __("Grayscale", 'revsliderhelp'),
								$h => "hover.filter.grayscale",
								$k => array("animate filter", "filter animation", "filter", "filters", "grayscale filter", "grayscale"),
								$d => __("The <a href='https://developer.mozilla.org/en-US/docs/Web/CSS/filter-function/grayscale' target='_blank'>grayscale filter</a> value for the Layer on mouse hover", 'revsliderhelp'),
								$a => $u . "mouse-hover-settings/#filter-hover",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_9", 
									$st => '#form_layerstyle_css_hover', 
									$f => "*[data-r='hover.filter.grayscale']"
								)
							)			
						)
					),
					'gst_layer_8' => array(
						'level' => array(
							$t => __("Parallax Level", 'revsliderhelp'),
							$h => "effects.parallax",
							$k => array("parallax", "layer parallax", "parallax 3d", "parallax level", "level", "3d level", "parallax layer", "depth", "parallax depth", "3d depth"),
							$d => __("The parallax depth level to use for the Layer.  Level values are defined in the Slider Settings.", 'revsliderhelp'),
							$a => $u . "layers-parallax-level/",
							$hl => array(
								$dp => array('layerselected'), 
								$m => "#module_layers_trigger, #gst_layer_8", 
								$st => '#form_layercontent_pddd', 
								$f => "#layer_parallax_level"
							)
						),
						'under_mask' => array(
							$t => __("Parallax Masking", 'revsliderhelp'),
							$h => "effects.pxmask",
							$k => array("parallax", "layer parallax", "parallax 3d", "parallax layer", "mask", "masking", "parallax mask"),
							$d => __("Apply a mask to the Layer as the Parallax Effect takes place.  When applied, the content will never bleed outside this mask.", 'revsliderhelp'),
							$a => $u . "layers-parallax-level/",
							$hl => array(
								$dp => array('layerselected'), 
								$m => "#module_layers_trigger, #gst_layer_8", 
								$st => '#form_layercontent_pddd', 
								$f => "#parallax_undermask"
							)
						),
						'timeline_scroll' => array(
							$t => __("Timeline Scroll Based", 'revsliderhelp'),
							$h => "timeline.scrollBased",
							$k => array("parallax", "layer parallax", "parallax layer", "timeline", "timeline scroll", "timeline scroll based", "scroll"),
							$d => __("Choose to animate the Layer's animation timeline as the Module scrolls into and out of view", 'revsliderhelp'),
							$a => $u . "layers-parallax-level/",
							$hl => array(
								$dp => array('layerselected'), 
								$m => "#module_layers_trigger, #gst_layer_8", 
								$st => '#form_layertimeline_scrollbased', 
								$f => "#layer_timlinescroll_level"
							)
						),
						'filter_effects' => array(
							$t => __("Filter Effect Scroll Based", 'revsliderhelp'),
							$h => "effects.effect",
							$k => array("parallax", "layer parallax", "parallax layer", "filter", "filters", "scroll", "filter effect"),
							$d => __("Enable/Disable filter effects for the Layer as the Module scrolls into and out of view.  Filter effects applied via the <a href='http://docs.themepunch.com/slider-revolution/scroll-effects/' target='_blank'>Module Settings</a>", 'revsliderhelp'),
							$a => $u . "layers-parallax-level/",
							$hl => array(
								$dp => array('layerselected'), 
								$m => "#module_layers_trigger, #gst_layer_8", 
								$st => '#form_layertimeline_scrollbased', 
								$f => "#layer_effectscroll_level"
							)
						)
					),
					'gst_layer_5' => array(
						'interaction' => array(
							$t => __("Interaction", 'revsliderhelp'),
							$h => "actions.action.#actionindex#.tooltip_event",
							$k => array("actions", "interation", "link", "hyperlink", "link layer", "layer link", "click", "hover", "mouseover", "mouse over", "mouse hover", "button", "button action"),
							$d => __("Choose if the Action should occur on user-click, mouse-over or mouse-out", 'revsliderhelp'),
							$a => $u . "actions-panel-overview/",
							$hl => array(
								$dp => array('.single_layer_action:first-child'), 
								$m => "#module_layers_trigger, #gst_layer_5", 
								$st => '{actions}#layeraction_group_link', 
								$f => "#layeraction_picker_link, #action_interaction",
								'modal' => 'actions'
							)
						),
						'action_type' => array(
							$di => "layer_action_type",
							$t => __("Action Type", 'revsliderhelp'),
							$h => "actions.action.#actionindex#.action",
							$k => array("actions", "action type", "link", "hyperlink", "link layer", "layer link", "click", "hover", "mouseover", "mouse over", "mouse hover"),
							$d => __("Choose which Action should occur when the user interacts with the Layer", 'revsliderhelp'),
							$a => $u . "actions-panel-overview/",
							$hl => array(
								$dp => array('.single_layer_action:first-child'), 
								$m => "#module_layers_trigger, #gst_layer_5", 
								$st => '{actions}#layeraction_group_link', 
								$f => "#layeraction_picker_link, #layer_action_type",
								'modal' => 'actions'
							)
						),
						'action_delay' => array(
							$t => __("Action Delay", 'revsliderhelp'),
							$h => "actions.action.#actionindex#.action_speed",
							$k => array("action delay", "delay", "delay action"),
							$d => __("Add an optional delay before the Action occurs (in milliseconds)", 'revsliderhelp'),
							$a => $u . "actions-panel-overview/",
							$hl => array(
								$dp => array('.single_layer_action:first-child'), 
								$m => "#module_layers_trigger, #gst_layer_5", 
								$st => '{actions}#layeraction_group_link', 
								$f => "#layeraction_picker_link, #layer_action_delay",
								'modal' => 'actions'
							)
						),
						'link_actions' => array(
							'simple_link' => array(
								'link_url' => array(
									$t => __("Link URL", 'revsliderhelp'),
									$h => "actions.action.#actionindex#.image_link",
									$k => array("action", "actions", "link", "simple link", "hyperlink", "link layer", "layer link", "link url", "url", "button link", "link button"),
									$d => __("The url to navigate to for the 'Simple Link' Action", 'revsliderhelp'),
									$a => $u . "simple-link/",
									$hl => array(
										$dp => array(
											'.single_layer_action:first-child', 
											array($p => '#slide#.layers.#layer#.actions.action.#action#.action', $v => 'link', $o => 'layer_action_type')
										), 
										$m => "#module_layers_trigger, #gst_layer_5", 
										$st => '{actions}#layeraction_group_link', 
										$f => "#layeraction_picker_link, #la_image_link",
										'modal' => 'actions'
									)
								),
								'link_target' => array(
									$t => __("Link Target", 'revsliderhelp'),
									$h => "actions.action.#actionindex#.link_open_in",
									$k => array("link", "simple link", "hyperlink", "link layer", "layer link", "link target"),
									$d => __("Choose if the link should be opened in the same window or in a new window", 'revsliderhelp'),
									$a => $u . "simple-link/",
									$hl => array(
										$dp => array(
											'.single_layer_action:first-child', 
											array($p => '#slide#.layers.#layer#.actions.action.#action#.action', $v => 'link', $o => 'layer_action_type')
										), 
										$m => "#module_layers_trigger, #gst_layer_5", 
										$st => '{actions}#layeraction_group_link', 
										$f => "#layeraction_picker_link, #la_link_open_in",
										'modal' => 'actions'
									)
								),
								'link_type' => array(
									$t => __("Link Type", 'revsliderhelp'),
									$h => "actions.action.#actionindex#.link_type",
									$k => array("simple link", "link type"),
									$d => __("Use a traditional HTML hyperlink tag or trigger the Action via a jQuery event", 'revsliderhelp'),
									$a => $u . "simple-link/",
									$hl => array(
										$dp => array(
											'.single_layer_action:first-child', 
											array($p => '#slide#.layers.#layer#.actions.action.#action#.action', $v => 'link', $o => 'layer_action_type')
										), 
										$m => "#module_layers_trigger, #gst_layer_5", 
										$st => '{actions}#layeraction_group_link', 
										$f => "#layeraction_picker_link, #la_link_type",
										'modal' => 'actions'
									)
								),
								'follow' => array(
									$t => __("Follow", 'revsliderhelp'),
									$h => "actions.action.#actionindex#.link_follow",
									$k => array("simple link", "follow", "nofollow", "no follow"),
									$d => __("Choose 'No Follow' to discourage search engines from indexing index the link", 'revsliderhelp'),
									$a => $u . "simple-link/",
									$hl => array(
										$dp => array(
											'.single_layer_action:first-child', 
											array($p => '#slide#.layers.#layer#.actions.action.#action#.action', $v => 'link', $o => 'layer_action_type')
										), 
										$m => "#module_layers_trigger, #gst_layer_5", 
										$st => '{actions}#layeraction_group_link', 
										$f => "#layeraction_picker_link, #la_link_follow",
										'modal' => 'actions'
									)
								)
							),
							'call_back' => array(
								$t => __("Call Back Function", 'revsliderhelp'),
								$h => "actions.action.#actionindex#.actioncallback",
								$k => array("action", "actions", "call back", "javascript", "javascript callback"),
								$d => __("Call an external JavaScript function on user-interaction", 'revsliderhelp'),
								$a => $u . "simple-link/",
								$hl => array(
									$dp => array(
										'.single_layer_action:first-child', 
										array($p => '#slide#.layers.#layer#.actions.action.#action#.action', $v => 'callback', $o => 'layer_action_type')
									), 
									$m => "#module_layers_trigger, #gst_layer_5", 
									$st => '{actions}#layeraction_group_link', 
									$f => "#layeraction_picker_callback, #la_actioncallback",
									'modal' => 'actions'
								)
							),
							'scroll_below_slider' => array(
								'scroll_offset' => array(
									$t => __("Scroll Offset", 'revsliderhelp'),
									$h => "actions.action.#actionindex#.scrollunder_offset",
									$k => array("action", "actions", "scroll", "scroll action", "scroll below slider", "scroll offset"),
									$d => __("The page will scroll to content below the Slider, and this offset will add or subtract pixels to the total amount scrolled.", 'revsliderhelp'),
									$a => $u . "simple-link/",
									$hl => array(
										$dp => array(
											'.single_layer_action:first-child', 
											array($p => '#slide#.layers.#layer#.actions.action.#action#.action', $v => 'scroll_under', $o => 'layer_action_type')
										), 
										$m => "#module_layers_trigger, #gst_layer_5", 
										$st => '{actions}#layeraction_group_link', 
										$f => "#layeraction_picker_scroll_under, #la_scrollunder_offset",
										'modal' => 'actions'
									)
								),
								'easing' => array(
									$t => __("Scroll Easing", 'revsliderhelp'),
									$h => "actions.action.#actionindex#.action_easing",
									$k => array("scroll", "scroll action", "scroll easing"),
									$d => __("The easing equation for the Scroll Action.  <a href='https://greensock.com/ease-visualizer' target=_'blank'>View visualization</a>", 'revsliderhelp'),
									$a => $u . "simple-link/",
									$hl => array(
										$dp => array(
											'.single_layer_action:first-child', 
											array($p => '#slide#.layers.#layer#.actions.action.#action#.action', $v => 'scroll_under', $o => 'layer_action_type')
										), 
										$m => "#module_layers_trigger, #gst_layer_5", 
										$st => '{actions}#layeraction_group_link', 
										$f => "#layeraction_picker_scroll_under, #la_action_easing",
										'modal' => 'actions'
									)
								),
								'duration' => array(
									$t => __("Scroll Duration", 'revsliderhelp'),
									$h => "actions.action.#actionindex#.action_speed",
									$k => array("scroll", "scroll action", "scroll duration"),
									$d => __("The easing duration for the Scroll Action in milliseconds", 'revsliderhelp'),
									$a => $u . "simple-link/",
									$hl => array(
										$dp => array(
											'.single_layer_action:first-child', 
											array($p => '#slide#.layers.#layer#.actions.action.#action#.action', $v => 'scroll_under', $o => 'layer_action_type')
										), 
										$m => "#module_layers_trigger, #gst_layer_5", 
										$st => '{actions}#layeraction_group_link', 
										$f => "#layeraction_picker_scroll_under, #la_saction_speed",
										'modal' => 'actions'
									)
								),
							)
						),
						'slide_actions' => array(
							'jump_to_slide' => array(
								$t => __("Jump to Slide", 'revsliderhelp'),
								$h => "actions.action.#actionindex#.jump_to_slide",
								$k => array("action", "actions", "jump", "jump to slide", "change slides"),
								$d => __("Link the Layer to a specific Slide", 'revsliderhelp'),
								$a => $u . "slide-actions/",
								$hl => array(
									$dp => array(
										'.single_layer_action:first-child', 
										array($p => '#slide#.layers.#layer#.actions.action.#action#.action', $v => 'jumpto', $o => 'layer_action_type')
									), 
									$m => "#module_layers_trigger, #gst_layer_5", 
									$st => '{actions}#layeraction_group_slide', 
									$f => "#layeraction_picker_jumpto, #la_jump_to_slide",
									'modal' => 'actions'
								)
							),
							'next_prev_slide' => array(
								$t => __("Next/Previous Slide", 'revsliderhelp'),
								$h => "layeraction_picker_next",
								$k => array("action", "actions", "next slide", "prev slide", "previous slide", "link to slide", "change slides"),
								$d => __("Change to the next or previous Slide on user-interaction", 'revsliderhelp'),
								$a => $u . "slide-actions/",
								$hl => array(
									$dp => array(
										'.single_layer_action:first-child', 
										array($p => '#slide#.layers.#layer#.actions.action.#action#.action', $v => 'next::prev', $o => 'layer_action_type')
									), 
									$m => "#module_layers_trigger, #gst_layer_5", 
									$st => '{actions}#layeraction_group_slide', 
									$f => "#layeraction_picker_prev, #layeraction_picker_next, #layer_action_type",
									'modal' => 'actions'
								)
							),
							'pause_play_slider' => array(
								$t => __("Pause/Play Slider", 'revsliderhelp'),
								$h => "layeraction_picker_pause",
								$k => array("action", "actions", "pause slide", "progress", "pause slider", "pause progress", "pause", "play slide", "play slider", "play", "resume", "resume progress", "play button", "pause button"),
								$d => __("Pause or Resume the Slider's progress on user-interaction", 'revsliderhelp'),
								$a => $u . "slide-actions/",
								$hl => array(
									$dp => array(
										'.single_layer_action:first-child', 
										array($p => '#slide#.layers.#layer#.actions.action.#action#.action', $v => 'pause::resume', $o => 'layer_action_type')
									), 
									$m => "#module_layers_trigger, #gst_layer_5", 
									$st => '{actions}#layeraction_group_slide', 
									$f => "#layeraction_picker_pause, #layeraction_picker_resume, #layer_action_type",
									'modal' => 'actions'
								)
							),
							'toggle_slider' => array(
								$t => __("Toggle Slider", 'revsliderhelp'),
								$h => "layeraction_picker_toggle_slider",
								$k => array("pause slide", "progress", "pause slider", "pause progress", "pause", "play slide", "progress", "play slider", "play", "resume", "resume progress", "toggle", "toggle slider", "toggle progress"),
								$d => __("Play/Pause the Slider on user-interaction", 'revsliderhelp'),
								$a => $u . "slide-actions/",
								$hl => array(
									$dp => array(
										'.single_layer_action:first-child', 
										array($p => '#slide#.layers.#layer#.actions.action.#action#.action', $v => 'toggle_slider', $o => 'layer_action_type')
									), 
									$m => "#module_layers_trigger, #gst_layer_5", 
									$st => '{actions}#layeraction_group_slide', 
									$f => "#layeraction_picker_toggle_slider, #layer_action_type",
									'modal' => 'actions'
								)
							)
						),
						'layer_actions' => array(
							'start_layer_in_out_animation' => array(
								$t => __("Start Layer In/Out Animation", 'revsliderhelp'),
								$h => "layeraction_picker_start_in",
								$k => array("animation", "action", "actions", "start animation", "play animation", "start layer in animation", "start layer out animation", "layer animation"),
								$d => __("Play a Layer's animation on-demand to show or hide the Layer", 'revsliderhelp'),
								$a => $u . "layer-actions/",
								$hl => array(
									$dp => array(
										'.single_layer_action:first-child', 
										array($p => '#slide#.layers.#layer#.actions.action.#action#.action', $v => 'start_in::start_out', $o => 'layer_action_type')
									), 
									$m => "#module_layers_trigger, #gst_layer_5", 
									$st => '{actions}#layeraction_group_layer', 
									$f => "#layeraction_picker_start_in, #layeraction_picker_start_out, #layer_action_type",
									'modal' => 'actions'
								)
							),
							'toggle_layer_animation' => array(
								$t => __("Toggle Layer Animation", 'revsliderhelp'),
								$h => "layeraction_picker_toggle_layer",
								$k => array("start animation", "play animation", "start layer out animation", "layer animation", "toggle animation", "toggle layer", "toggle layer animation", "toggle"),
								$d => __("Toggle any given Layer's animation in and out of view", 'revsliderhelp'),
								$a => $u . "layer-actions/",
								$hl => array(
									$dp => array(
										'.single_layer_action:first-child', 
										array($p => '#slide#.layers.#layer#.actions.action.#action#.action', $v => 'toggle_layer', $o => 'layer_action_type')
									), 
									$m => "#module_layers_trigger, #gst_layer_5", 
									$st => '{actions}#layeraction_group_layer', 
									$f => "#layeraction_picker_toggle_layer, #layer_action_type",
									'modal' => 'actions'
								)
							),
							'simulate_click' => array(
								$t => __("Simulate Click", 'revsliderhelp'),
								$h => "layeraction_picker_simulate_click",
								$k => array("simulate click", "click action", "jQuery click", "trigger", "trigger click"),
								$d => __("Trigger a jQuery click event on any given Layer", 'revsliderhelp'),
								$a => $u . "layer-actions/",
								$hl => array(
									$dp => array(
										'.single_layer_action:first-child', 
										array($p => '#slide#.layers.#layer#.actions.action.#action#.action', $v => 'simulate_click', $o => 'layer_action_type')
									), 
									$m => "#module_layers_trigger, #gst_layer_5", 
									$st => '{actions}#layeraction_group_layer', 
									$f => "#layeraction_picker_simulate_click, #layer_action_type",
									'modal' => 'actions'
								)
							),
							'toggle_class' => array(
								$t => __("Toggle Class", 'revsliderhelp'),
								$h => "actions.action.#actionindex#.toggle_class",
								$k => array("action", "actions", "class", "class name", "layer class", "add layer class", "remove layer class", "toggle class"),
								$d => __("Toggle (add/remove) a Layer's class name on user-interaction", 'revsliderhelp'),
								$a => $u . "layer-actions/",
								$hl => array(
									$dp => array(
										'.single_layer_action:first-child', 
										array($p => '#slide#.layers.#layer#.actions.action.#action#.action', $v => 'toggle_class', $o => 'layer_action_type')
									), 
									$m => "#module_layers_trigger, #gst_layer_5", 
									$st => '{actions}#layeraction_group_layer', 
									$f => "#layeraction_picker_toggle_class, #la_toggle_class",
									'modal' => 'actions'
								)
							),
							'layer_action_settings' => array(
								'target_layer' => array(
									$t => __("Target Layer", 'revsliderhelp'),
									$h => "actions.action.#actionindex#.layer_target",
									$k => array("start animation", "play animation", "start layer in animation", "layer animation", "toggle class"),
									$d => __("Choose which Layer to target for the Layer Action", 'revsliderhelp'),
									$a => $u . "layer-actions/",
									$hl => array(
										$dp => array(
											'.single_layer_action:first-child', 
											array($p => '#slide#.layers.#layer#.actions.action.#action#.action', $v => 'start_in::start_out::toggle_layer::simulate_click::toggle_class', $o => 'layer_action_type')
										), 
										$m => "#module_layers_trigger, #gst_layer_5", 
										$st => '{actions}#layeraction_group_layer', 
										$f => "#layeraction_picker_start_in, #la_layer_target",
										'modal' => 'actions'
									)
								),
								'animation_timing' => array(
									$t => __("Animation Timing", 'revsliderhelp'),
									$h => "actions.animationoverwrite",
									$k => array("animation timing", "animation action"),
									$d => __("Choose the Layer's default animation behavior in relation to the selected Action", 'revsliderhelp'),
									$a => $u . "layer-actions/",
									$hl => array(
										$dp => array(
											'.single_layer_action:first-child', 
											array($p => '#slide#.layers.#layer#.actions.action.#action#.action', $v => 'start_in::start_out::toggle_layer', $o => 'layer_action_type')
										), 
										$m => "#module_layers_trigger, #gst_layer_5", 
										$st => '{actions}#layeraction_group_layer', 
										$f => "#layeraction_picker_start_in, #la_animationoverwrite",
										'modal' => 'actions'
									)
								),
								'trigger_memory' => array(
									$t => __("Trigger Memory", 'revsliderhelp'),
									$h => "actions.triggerMemory",
									$k => array("trigger memory", "reset animation", "reset", "reset layer", "reset layer animation"),
									$d => __("Choose if the Layer's animation behavior should reset or not when the Slide replays again", 'revsliderhelp'),
									$a => $u . "layer-actions/",
									$hl => array(
										$dp => array(
											'.single_layer_action:first-child', 
											array($p => '#slide#.layers.#layer#.actions.action.#action#.action', $v => 'start_in::start_out::toggle_layer', $o => 'layer_action_type')
										), 
										$m => "#module_layers_trigger, #gst_layer_5", 
										$st => '{actions}#layeraction_group_layer', 
										$f => "#layeraction_picker_start_in, #la_triggerMemory",
										'modal' => 'actions'
									)
								)
							)
						),
						'media_actions' => array(
							'start_stop_media' => array(
								$t => __("Play/Pause Media", 'revsliderhelp'),
								$h => "layeraction_picker_start_video",
								$k => array("media", "video", "audio", "start media", "play media", "pause media", "end media", "resume media", "stop media", "play video", "stop video", "play audio", "stop audio", "resume", "resume media", "play button", "pause button"),
								$d => __("Play or pause Video or Audio on user-interaction", 'revsliderhelp'),
								$a => $u . "media-actions/",
								$hl => array(
									$dp => array(
										'.single_layer_action:first-child', 
										array($p => '#slide#.layers.#layer#.actions.action.#action#.action', $v => 'start_video::stop_video', $o => 'layer_action_type')
									), 
									$m => "#module_layers_trigger, #gst_layer_5", 
									$st => '{actions}#layeraction_group_media', 
									$f => "#layeraction_picker_start_video, #layeraction_picker_stop_video, #layer_action_type",
									'modal' => 'actions'
								)
							),
							'toggle_media' => array(
								$t => __("Toggle Media Play/Pause", 'revsliderhelp'),
								$h => "layeraction_picker_toggle_video",
								$k => array("media", "video", "audio", "start media", "play media", "pause media", "end media", "resume media", "stop media", "play video", "stop video", "play audio", "stop audio", "resume", "resume media", "play button", "pause button"),
								$d => __("Toggle a video or audio's play state on user-interaction", 'revsliderhelp'),
								$a => $u . "media-actions/",
								$hl => array(
									$dp => array(
										'.single_layer_action:first-child', 
										array($p => '#slide#.layers.#layer#.actions.action.#action#.action', $v => 'toggle_video', $o => 'layer_action_type')
									), 
									$m => "#module_layers_trigger, #gst_layer_5", 
									$st => '{actions}#layeraction_group_media', 
									$f => "#layeraction_picker_toggle_video, #layer_action_type",
									'modal' => 'actions'
								)
							),
							'mute_unmute_media' => array(
								$t => __("Mute/Unmute Media", 'revsliderhelp'),
								$h => "layeraction_picker_mute_video",
								$k => array("media", "video", "audio", "mute", "unmute", "mute media", "unmute media", "sound", "pause sound", "turn off", "turn off sound", "mute button"),
								$d => __("Mute or Unmute the sound from a video or audio Layer on user-interaction", 'revsliderhelp'),
								$a => $u . "media-actions/",
								$hl => array(
									$dp => array(
										'.single_layer_action:first-child', 
										array($p => '#slide#.layers.#layer#.actions.action.#action#.action', $v => 'mute_video::unmute_video', $o => 'layer_action_type')
									), 
									$m => "#module_layers_trigger, #gst_layer_5", 
									$st => '{actions}#layeraction_group_media', 
									$f => "#layeraction_picker_mute_video, #layeraction_picker_unmute_video, #layer_action_type",
									'modal' => 'actions'
								)
							),
							'toggle_mute_media' => array(
								$t => __("Toggle Mute (All) Media", 'revsliderhelp'),
								$h => "layeraction_picker_toggle_mute_video",
								$k => array("media", "video", "audio", "mute", "unmute", "mute media", "unmute media", "sound", "pause sound", "turn off", "turn off sound", "mute button"),
								$d => __("Toggle sound from a single video or audio Layer, or toggle all video/audio sound that exists in the Slide", 'revsliderhelp'),
								$a => $u . "media-actions/",
								$hl => array(
									$dp => array(
										'.single_layer_action:first-child', 
										array($p => '#slide#.layers.#layer#.actions.action.#action#.action', $v => 'toggle_mute_video::toggle_global_mute_video', $o => 'layer_action_type')
									), 
									$m => "#module_layers_trigger, #gst_layer_5", 
									$st => '{actions}#layeraction_group_media', 
									$f => "#layeraction_picker_toggle_mute_video, #layeraction_picker_toggle_global_mute_video, #layer_action_type",
									'modal' => 'actions'
								)
							)
						),
						'fullscreen_actions' => array(
							'enter_exit_fullscreen' => array(
								$t => __("Enter/Exit Fullscreen", 'revsliderhelp'),
								$h => "layeraction_picker_gofullscreen",
								$k => array("full", "fullscreen", "full screen", "full screen button", "fullscreen button", "exit fullscreen", "enter fullscreen", "enter full screen", "go fullscreen", "go full screen"),
								$d => __("Take the Slider fullscreen or exit fullscreen on user-interaction", 'revsliderhelp'),
								$a => $u . "fullscreen-actions/",
								$hl => array(
									$dp => array(
										'.single_layer_action:first-child', 
										array($p => '#slide#.layers.#layer#.actions.action.#action#.action', $v => 'gofullscreen::exitfullscreen', $o => 'layer_action_type')
									), 
									$m => "#module_layers_trigger, #gst_layer_5", 
									$st => '{actions}#layeraction_group_fullscreen', 
									$f => "#layeraction_picker_gofullscreen, #layeraction_picker_exitfullscreen, #layer_action_type",
									'modal' => 'actions'
								)
							),
							'toggle_fullscreen' => array(
								$t => __("Toggle Fullscreen", 'revsliderhelp'),
								$h => "layeraction_picker_togglefullscreen",
								$k => array("full", "fullscreen", "full screen", "full screen button", "fullscreen button", "exit fullscreen", "enter fullscreen", "enter full screen", "go fullscreen", "go full screen", "toggle fullscreen", "toggle full"),
								$d => __("Toggle the Slider fullscreen and non-fullscreen on user-interaction", 'revsliderhelp'),
								$a => $u . "fullscreen-actions/",
								$hl => array(
									$dp => array(
										'.single_layer_action:first-child', 
										array($p => '#slide#.layers.#layer#.actions.action.#action#.action', $v => 'togglefullscreen', $o => 'layer_action_type')
									),  
									$m => "#module_layers_trigger, #gst_layer_5", 
									$st => '{actions}#layeraction_group_fullscreen', 
									$f => "#layeraction_picker_togglefullscreen, #layer_action_type",
									'modal' => 'actions'
								)
							)
						)
					),
					
					'gst_layer_13' => array(
						
						'visibility' => array(
							'desktop' => array(
								$t => __("Show/Hide on Desktop", 'revsliderhelp'),
								$h => "visibility.d",
								$k => array("visibility", "layer visibility", "show layer", "hide layer"),
								$d => __("Show or hide the Layer for the desktop viewport", 'revsliderhelp'),
								$a => $u . "responsive-settings/",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_13", 
									$st => '#form_layercontent_visibility', 
									$f => "*[data-r='visibility.d']"
								)
							),
							'laptop' => array(
								$t => __("Show/Hide on Laptop", 'revsliderhelp'),
								$h => "visibility.n",
								$k => array("visibility", "layer visibility", "show layer", "hide layer"),
								$d => __("Show or hide the Layer for the laptop viewport", 'revsliderhelp'),
								$a => $u . "responsive-settings/",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_13", 
									$st => '#form_layercontent_visibility', 
									$f => "*[data-r='visibility.n']"
								)
							),
							'tablet' => array(
								$t => __("Show/Hide on Tablet", 'revsliderhelp'),
								$h => "visibility.t",
								$k => array("visibility", "layer visibility", "show layer", "hide layer"),
								$d => __("Show or hide the Layer for the tablet viewport", 'revsliderhelp'),
								$a => $u . "responsive-settings/",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_13", 
									$st => '#form_layercontent_visibility', 
									$f => "*[data-r='visibility.t']"
								)
							),
							'phone' => array(
								$t => __("Show/Hide on Phone", 'revsliderhelp'),
								$h => "visibility.m",
								$k => array("visibility", "layer visibility", "show layer", "hide layer"),
								$d => __("Show or hide the Layer for the phone viewport", 'revsliderhelp'),
								$a => $u . "responsive-settings/",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_13", 
									$st => '#form_layercontent_visibility', 
									$f => "*[data-r='visibility.m']"
								)
							),
							'hide_under' => array(
								$t => __("Hide Under Width", 'revsliderhelp'),
								$h => "visibility.hideunder",
								$k => array("layer visibility", "hide under", "hide under width", "show layer", "hide layer"),
								$d => __("Hide the Layer when the browser window is equal to or below the value set in the Slider Settings", 'revsliderhelp'),
								$a => $u . "responsive-settings/",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_13", 
									$st => '#form_layercontent_visibility', 
									$f => "#layer_visibility_hideunder"
								)
							),
							'show_on_mouseover' => array(
								$t => __("Show on Mouse Over", 'revsliderhelp'),
								$h => "visibility.onlyOnSlideHover",
								$k => array("visibility", "layer visibility", "show layer", "hide layer"),
								$d => __("Only show the Layer when the user hovers their mouse over the Slider", 'revsliderhelp'),
								$a => $u . "responsive-settings/",
								$hl => array(
									$dp => array('layerselected'), 
									$m => "#module_layers_trigger, #gst_layer_13", 
									$st => '#form_layercontent_visibility', 
									$f => "#layer_visibility_showonover"
								)
							)
						)
					),
					'gst_layer_11' => array(
						'layer_id' => array(
							$t => __("Layer ID", 'revsliderhelp'),
							$h => "attributes.id",
							$k => array("layer id", "layer id attribute"),
							$d => __("Define an optional ID for the Layer to target it with custom CSS/JavaScript", 'revsliderhelp'),
							$a => $u . "layer-attributes/",
							$hl => array(
								$dp => array('layerselected'), 
								$m => "#module_layers_trigger, #gst_layer_11", 
								$st => '#form_layer_attributes', 
								$f => "#layer_id"
							)
						),
						'layer_classes' => array(
							$t => __("Layer Classes", 'revsliderhelp'),
							$h => "attributes.classes",
							$k => array("layer class", "layer classes"),
							$d => __("Add class names to the Layer to target it with custom CSS/JavaScript (separate multiple class names with spaces)", 'revsliderhelp'),
							$a => $u . "layer-attributes/",
							$hl => array(
								$dp => array('layerselected'), 
								$m => "#module_layers_trigger, #gst_layer_11", 
								$st => '#form_layer_attributes', 
								$f => "#layer_classes"
							)
						),
						'layer_title' => array(
							$t => __("Layer Title", 'revsliderhelp'),
							$h => "attributes.title",
							$k => array("layer title", "layer title attribute"),
							$d => __("Define the Layer's title attribute", 'revsliderhelp'),
							$a => $u . "layer-attributes/",
							$hl => array(
								$dp => array('layerselected'), 
								$m => "#module_layers_trigger, #gst_layer_11", 
								$st => '#form_layer_attributes', 
								$f => "#layer_title"
							)
						),
						'layer_rel' => array(
							$t => __("Layer Rel", 'revsliderhelp'),
							$h => "attributes.rel",
							$k => array("layer rel", "layer relattribute"),
							$d => __("Define the Layer's 'rel' attribute", 'revsliderhelp'),
							$a => $u . "layer-attributes/",
							$hl => array(
								$dp => array('layerselected'), 
								$m => "#module_layers_trigger, #gst_layer_11", 
								$st => '#form_layer_attributes', 
								$f => "#layer_rel"
							)
						),
						'tab_index' => array(
							$t => __("Tab Index", 'revsliderhelp'),
							$h => "attributes.tabIndex",
							$k => array("layer tab index", "layer tab-index"),
							$d => __("Define the Layer's tab-index.  Useful for defining focus on elements.", 'revsliderhelp'),
							$a => $u . "layer-attributes/",
							$hl => array(
								$dp => array('layerselected'), 
								$m => "#module_layers_trigger, #gst_layer_11", 
								$st => '#form_layer_attributes', 
								$f => "#layer_tbindex"
							)
						),
						'wrapper_id' => array(
							$t => __("Wrapper ID", 'revsliderhelp'),
							$h => "attributes.wrapperId",
							$k => array("wrapper id", "layer wrapper", "layer wrapper id"),
							$d => __("Define an optional ID for the Layer's outer-most wrapper to target it with custom CSS/JavaScript.", 'revsliderhelp'),
							$a => $u . "layer-attributes/",
							$hl => array(
								$dp => array('layerselected'), 
								$m => "#module_layers_trigger, #gst_layer_11", 
								$st => '#form_layer_attributes', 
								$f => "#layer_wrapper_id"
							)
						),
						'wrapper_classes' => array(
							$t => __("Wrapper Classes", 'revsliderhelp'),
							$h => "attributes.wrapperClasses",
							$k => array("wrapper classes", "layer wrapper", "layer wrapper classes"),
							$d => __("Add class names to the Layer's outer-most wrapper to target it with custom CSS/JavaScript (separate multiple class names with spaces)", 'revsliderhelp'),
							$a => $u . "layer-attributes/",
							$hl => array(
								$dp => array('layerselected'), 
								$m => "#module_layers_trigger, #gst_layer_11", 
								$st => '#form_layer_attributes', 
								$f => "#layer_wrapper_classes"
							)
						)
					),
					'addons' => array()
				)
			)
		);
		return array('translations' => $translations, 'helpindex' => apply_filters('revslider_help_directory', $helpindex));
	}
}