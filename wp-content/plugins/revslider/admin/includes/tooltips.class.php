<?php
/**
* @author    ThemePunch <info@themepunch.com>
* @link      https://www.themepunch.com/
* @copyright 2019 ThemePunch
*/

if(!defined('ABSPATH')) exit();

class RevSliderTooltips {

	public static function getTooltips() {

		$translations = array(
			
			'docs' => __('Docs', 'revslider'),
			'next_tip' => __('Next Tip'),
			'got_it' => __('Got It'),
			'hide_tips' => __("Don't show tooltips again")

		);
			
		$tooltips = array(
		
			'help_mode' => array(
			
				'title' => 'Help Mode',
				'target' => '.help_wrap',
				'alignment' => 'bottom',
				'margin' => '20px 0 0 0',
				'text' => 'Get information about the different options available for your Slider',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/help-center/?utm_source=admin&utm_medium=button&utm_campaign=srusers&utm_content=faq'
				
			),
			'slides' => array(
			
				'title' => 'Add Slide',
				'target' => '#add_slide_toolbar_wrap',
				'alignment' => 'bottom',
				'margin' => '20px 0 0 0',
				'text' => "Add new Slides, reorder your current Slides and manage the Module's global content",
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/slide-management/'
				
			),
			'add_layer' => array(
			
				'title' => 'Add Layer',
				'target' => '#add_layer_toolbar_wrap',
				'alignment' => 'bottom',
				'margin' => '20px 0 0 0',
				'text' => 'Add new content to the currently active Slide'
				
			),
			'tooltip_button' => array(
			
				'title' => 'Tooltip Button',
				'target' => '.tooltip_wrap',
				'alignment' => 'bottom',
				'margin' => '20px 0 0 0',
				'text' => 'Enable the tooltip wizard for a quick overview of the editor'
				
			),
			'undo_redo' => array(
			
				'title' => 'Undo Redo',
				'target' => '.undo_redo_wrap',
				'alignment' => 'bottom',
				'margin' => '20px 0 0 0',
				'text' => "Undo or redo changes you've made while using the editor"
				
			),
			'quick_style' => array(
			
				'title' => 'Quick Style Layer',
				'target' => '#quick_style_trigger',
				'alignment' => 'bottom',
				'margin' => '20px 0 0 0',
				'text' => 'Add pre-styled headlines, paragraph text and buttons to the current Slide'
				
			),
			'device_switcher' => array(
			
				'title' => 'Device View Switcher',
				'target' => '#main_screenselector',
				'alignment' => 'bottom',
				'margin' => '20px 0 0 0',
				'trigger' => '#main_screenselector:visible',
				'text' => "Adjust your content's size and position for different screen sizes"
				
			),
			'layer_selections' => array(
			
				'title' => 'Layer Selections',
				'target' => '#toolkit_selector_wrap',
				'alignment' => 'bottom',
				'margin' => '20px 0 0 0',
				'text' => 'Choose the way you would like to select multiple Layers on the stage'
			
			),
			'slider_settings' => array(
			
				'title' => 'Slider Settings',
				'target' => '#module_settings_trigger',
				'alignment' => 'bottom',
				'margin' => '20px 0 0 0',
				'elementcss' => 'width: 80px',
				'focus' => 'none',
				'trigger' => array('#module_settings_trigger'),
				'text' => "Adjust the module's Layout and set its Slideshow behavior"
			
			),
			'slider_navigation' => array(
			
				'title' => 'Slider Navigation',
				'target' => '#module_navigation_trigger',
				'alignment' => 'bottom',
				'margin' => '20px 0 0 0',
				'elementcss' => 'width: 80px',
				'focus' => 'none',
				'trigger' => array('#module_navigation_trigger'),
				'text' => 'Add a variety of navigation elements to your Slider'
			
			),
			'slide_settings' => array(
			
				'title' => 'Slide Settings',
				'target' => '#module_slide_trigger',
				'alignment' => 'bottom-left',
				'margin' => '20px 0 0 78px',
				'elementcss' => 'width: 80px',
				'focus' => 'none',
				'trigger' => array('#module_slide_trigger'),
				'text' => "Set the Slide's main background and slide-change animation"
			
			),
			'layer_settings' => array(
			
				'title' => 'Layer Settings',
				'target' => '#module_layers_trigger',
				'alignment' => 'bottom-left',
				'margin' => '20px 0 0 78px',
				'elementcss' => 'width: 80px',
				'focus' => 'none',
				'trigger' => array('#module_layers_trigger'),
				'text' => "Adjust the size and position for your Slide's content"
			
			),
			'shortcode' => array(
			
				'title' => 'Title/Shortcode',
				'target' => '#sr_shortcode',
				'placer' => '#rs_shortcode_label',
				'alignment' => 'left',
				'margin' => '-4px 0 0 -17px',
				'trigger' => array('#module_settings_trigger', '#gst_sl_1'),
				'section' => 'Module General Options -> Title',
				'text' => 'The shortcode for the module is located here.'
			
			),
			'back' => array(
			
				'title' => 'Back to Plugin Admin Page',
				'target' => '#back_to_overview',
				'alignment' => 'bottom-right',
				'margin' => '20px 0 0 -90px',
				'text' => "Click here to go back to the plugin's main admin page"
			
			),
			'add_slide' => array(
			
				'title' => 'Add Slide',
				'target' => '#add_slide_toolbar_wrap',
				'focus' => '.toolbar_dd_subdrop_wrap',
				'alignment' => 'top-right',
				'margin' => '-5px 0 0 20px',
				'cssClass' => 'tip-hover',
				'text' => 'Add a new Slide to the Slider',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/slide-management/'
			
			),
			'global_layers' => array(
			
				'title' => 'Global Layers',
				'target' => '#add_slide_toolbar_wrap',
				'focus' => '.static-slide-btn',
				'alignment' => 'top-right',
				'margin' => '-5px 0 0 20px',
				'cssClass' => 'tip-hover tip-hover-staticlayers',
				'text' => 'Content that should always be visible throughout the life-cycle of your Slider exists here',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/global-layers/'
			
			),
			'slide_order' => array(
			
				'title' => 'Change Slide Order',
				'target' => '#add_slide_toolbar_wrap',
				'focus' => '.slide_list_element.selected',
				'alignment' => 'top-right',
				'margin' => '-5px 0 0 20px',
				'cssClass' => 'tip-hover tip-hover-slideorder',
				'text' => 'Drag these menu items on top of one another to change the order of your Slides',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/slide-management/#switch-reorder-slides'
			
			),
			'add_layer_text' => array(
			
				'title' => 'Add Text Layer',
				'target' => '#add_layer_toolbar_wrap',
				'focus' => '#toolbar_add_layer_text',
				'alignment' => 'top-right',
				'margin' => '-5px 0 0 20px',
				'cssClass' => 'tip-hover tip-hover-text',
				'text' => 'Add a text element to the current Slide',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/layer-content/'
			
			),
			'add_layer_image' => array(
			
				'title' => 'Add Image Layer',
				'target' => '#add_layer_toolbar_wrap',
				'focus' => '#toolbar_add_layer_image',
				'alignment' => 'top-right',
				'margin' => '-5px 0 0 20px',
				'cssClass' => 'tip-hover tip-hover-image',
				'text' => 'Add an image to the current Slide',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/layer-content/'
			
			),
			'add_layer_button' => array(
			
				'title' => 'Add Button Layer',
				'target' => '#add_layer_toolbar_wrap',
				'focus' => '#toolbar_add_layer_button',
				'alignment' => 'top-right',
				'margin' => '-5px 0 0 20px',
				'cssClass' => 'tip-hover tip-hover-button',
				'text' => 'Add a pre-styled button to the current Slide',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/layer-content/'
			
			),
			'add_layer_shape' => array(
			
				'title' => 'Add Shape Layer',
				'target' => '#add_layer_toolbar_wrap',
				'focus' => '#toolbar_add_layer_shape',
				'alignment' => 'top-right',
				'margin' => '-5px 0 0 20px',
				'cssClass' => 'tip-hover tip-hover-shape',
				'text' => 'Shapes are elements with a background colors but not content',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/layer-content/'
			
			),
			'add_layer_video' => array(
			
				'title' => 'Add Video Layer',
				'target' => '#add_layer_toolbar_wrap',
				'focus' => '#toolbar_add_layer_video',
				'alignment' => 'top-right',
				'margin' => '-5px 0 0 20px',
				'cssClass' => 'tip-hover tip-hover-video',
				'text' => 'Add a YouTube, Vimeo or HTML5 video to the current Slide',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/layer-content/'
			
			),
			'add_layer_audio' => array(
			
				'title' => 'Add Audio Layer',
				'target' => '#add_layer_toolbar_wrap',
				'focus' => '#toolbar_add_layer_audio',
				'alignment' => 'top-right',
				'margin' => '-5px 0 0 20px',
				'cssClass' => 'tip-hover tip-hover-audio',
				'text' => 'Add sound to the current Slide',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/layer-content/'
			
			),
			'add_layer_object' => array(
			
				'title' => 'Add Object Layer',
				'target' => '#add_layer_toolbar_wrap',
				'focus' => '#toolbar_add_layer_object',
				'alignment' => 'top-right',
				'margin' => '-5px 0 0 20px',
				'cssClass' => 'tip-hover tip-hover-object',
				'text' => 'Add a simple icon or SVG element to the current Slide',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/layer-content/'
			
			),
			'add_layer_row' => array(
			
				'title' => 'Add Row',
				'target' => '#add_layer_toolbar_wrap',
				'focus' => '#toolbar_add_layer_row',
				'alignment' => 'top-right',
				'margin' => '-5px 0 0 20px',
				'cssClass' => 'tip-hover tip-hover-row',
				'text' => 'Add a new Row to the current Slide to allow for Rows/Column-based content',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/rows-columns/'
			
			),
			'add_layer_group' => array(
			
				'title' => 'Add Group',
				'target' => '#add_layer_toolbar_wrap',
				'focus' => '#toolbar_add_layer_group',
				'alignment' => 'top-right',
				'margin' => '-5px 0 0 20px',
				'cssClass' => 'tip-hover tip-hover-group',
				'text' => 'Add a special container to the Slide that can then include multiple Layers grouped together',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/layer-groups/'
			
			),
			'add_layer_layerlibrary' => array(
			
				'title' => 'Layer Library',
				'target' => '#add_layer_toolbar_wrap',
				'focus' => '#add_from_layerlibrary',
				'alignment' => 'top-right',
				'margin' => '-5px 0 0 20px',
				'cssClass' => 'tip-hover tip-hover-layerlibrary',
				'text' => 'Add a text-based template that includes a predefined style and animation',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/layer-content/'
			
			),
			'add_layer_importlayer' => array(
			
				'title' => 'Import Layer',
				'target' => '#add_layer_toolbar_wrap',
				'focus' => '#import_layers',
				'alignment' => 'top-right',
				'margin' => '-5px 0 0 20px',
				'cssClass' => 'tip-hover tip-hover-importlayer',
				'text' => 'Import a Layer from another Slider or Slide',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/layer-content/'
			
			),
			'delete_layer' => array(
			
				'title' => 'Delete Layer',
				'target' => '#do_delete_layer',
				'alignment' => 'bottom',
				'margin' => '20px 0 0 0',
				'trigger' => array('#module_layers_trigger'),
				'text' => 'Delete the currently selected Layer',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/editor-overview/'
				
			),
			'duplicate_layer' => array(
			
				'title' => 'Duplicate Layer',
				'target' => '#duplicate_btn_icon',
				'focus' => '#do_duplicate_layer',
				'alignment' => 'top-left',
				'margin' => '-5px 0 0 -20px',
				'trigger' => array('#module_layers_trigger'),
				'cssClass' => 'tip-hover tip-hover-duplicate',
				'text' => 'Duplicate the currently selected Layer',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/editor-overview/'
				
			),
			'copy_layer' => array(
			
				'title' => 'Copy Layer',
				'target' => '#duplicate_btn_icon',
				'focus' => '#do_copy_layer',
				'alignment' => 'top-left',
				'margin' => '-5px 0 0 -20px',
				'trigger' => array('#module_layers_trigger'),
				'cssClass' => 'tip-hover tip-hover-copy',
				'text' => 'Copy the current Layer and paste it into another Slide',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/editor-overview/'
				
			),
			'paste_layer' => array(
			
				'title' => 'Paste Layer',
				'target' => '#duplicate_btn_icon',
				'focus' => '#do_paste_layer',
				'alignment' => 'top-left',
				'margin' => '-5px 0 0 -20px',
				'trigger' => array('#module_layers_trigger'),
				'cssClass' => 'tip-hover tip-hover-paste',
				'text' => 'Paste a copied Layer into the current Slide',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/editor-overview/'
				
			),
			'lock_layers' => array(
			
				'title' => 'Lock Layers',
				'target' => '#do_lock_layer',
				'focus' => '#toggle_lock_layer',
				'alignment' => 'top-left',
				'margin' => '-5px 0 0 -20px',
				'trigger' => array('#module_layers_trigger'),
				'cssClass' => 'tip-hover tip-hover-lock',
				'text' => 'Lock the currently selected Layer(s) from being edited',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/editor-overview/'
				
			),
			'unlock_layers' => array(
			
				'title' => 'Unlock Layers',
				'target' => '#do_lock_layer',
				'focus' => '#unlock_all_layer',
				'alignment' => 'top-left',
				'margin' => '-5px 0 0 -20px',
				'trigger' => array('#module_layers_trigger'),
				'cssClass' => 'tip-hover tip-hover-unlock',
				'text' => 'Unlock the currently selected Layers so they can be edited',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/editor-overview/'
				
			),
			'hide_highlight_boxes' => array(
			
				'title' => 'Hide Highlight Boxes',
				'target' => '#do_show_layer',
				'focus' => '#hide_highlight_boxes',
				'alignment' => 'top-left',
				'margin' => '-5px 0 0 -20px',
				'trigger' => array('#module_layers_trigger'),
				'cssClass' => 'tip-hover tip-hover-highlightboxes',
				'text' => "Hide the editor's outline guide markers",
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/editor-overview/'
				
			),
			'show_hide_selected' => array(
			
				'title' => 'Show/Hide Selected',
				'target' => '#do_show_layer',
				'focus' => '#toggle_visible_layer',
				'alignment' => 'top-left',
				'margin' => '-5px 0 0 -20px',
				'trigger' => array('#module_layers_trigger'),
				'cssClass' => 'tip-hover tip-hover-showhide',
				'text' => "Show the editor's outline guide markers for the selected Layers",
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/editor-overview/'
				
			),
			'set_all_visible' => array(
			
				'title' => 'Set All Visible',
				'target' => '#do_show_layer',
				'focus' => '#visible_all_layer',
				'alignment' => 'top-left',
				'margin' => '-5px 0 0 -20px',
				'trigger' => array('#module_layers_trigger'),
				'cssClass' => 'tip-hover tip-hover-setallvisible',
				'text' => "Show all outline guide markers for the editor",
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/editor-overview/'
				
			),
			'change_layer_order' => array(
			
				'title' => 'Change Layer Order',
				'target' => '#do_background_layer',
				'alignment' => 'bottom',
				'margin' => '20px 0 0 0',
				'trigger' => array('#module_layers_trigger'),
				'text' => 'Use these arrows to adjust the z-index/stacking order of the currently selected Layer',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/editor-overview/'
				
			),
			'layout_type' => array(
			
				'title' => 'Layout Type',
				'target' => '#rs-layout-type',
				'placer' => '#rs-layout-type label_a',
				'focus' => 'none',
				'alignment' => 'top-left',
				'margin' => '-4px 0 0 -20px',
				'trigger' => array('#module_settings_trigger', '#gst_sl_2'),
				'section' => 'Module General Options -> Layout',
				'scrollTo' => '#form_slider_layout_layout',
				'text' => "Optionally set your Slider to display as a carousel or a Hero Scene",
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/module-layout/'
			
			),
			'layout_sizing' => array(
			
				'title' => 'Layout Sizing',
				'target' => '#rs-layout-sizing',
				'placer' => '#rs-layout-sizing label_a',
				'focus' => 'none',
				'alignment' => 'top-left',
				'margin' => '-4px 0 0 -20px',
				'trigger' => array('#module_settings_trigger', '#gst_sl_2'),
				'section' => 'Module General Options -> Layout',
				'scrollTo' => '#form_slider_layout_layout',
				'text' => 'Choose how the Slider should be displayed on your web page',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/module-layout/'
			
			),
			'breakpoints' => array(
			
				'title' => 'Enable Breakpoints',
				'target' => '#rs-laptop-breakpoint',
				'placer' => '#rs-laptop-breakpoint',
				'focus' => '.tponoffwrap',
				'alignment' => 'top-left',
				'margin' => '-5px 0 0 -20px',
				'trigger' => array('#module_settings_trigger', '#gst_sl_2'),
				'section' => 'Module General Options -> Layout',
				'scrollTo' => '#form_slider_layout_bpoints',
				'text' => "Enable device breakpoints and edit your content's size and position for each viewport",
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/module-layout/'
			
			),
			'module_content' => array(
			
				'title' => 'Module Content Source',
				'target' => '#rs-module-source-wrap',
				'focus' => 'none',
				'alignment' => 'top-left',
				'margin' => '-4px 0 0 -20px',
				'trigger' => array('#module_settings_trigger', '#gst_sl_4'),
				'section' => 'Module General Options -> Content',
				'text' => 'Choose if your Slider should be auto-populated with content from your blog or a social channel',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/module-content/'
			
			),
			'auto_rotate' => array(
			
				'title' => 'Module Content Source',
				'target' => '#rs-autorotate-wrap',
				'placer' => '#rs-autorotate-wrap',
				'focus' => '.tponoffwrap',
				'alignment' => 'top-left',
				'margin' => '-4px 0 0 -20px',
				'trigger' => array('#module_settings_trigger', '#gst_sl_6'),
				'section' => 'Module General Options -> General',
				'scrollTo' => '#form_slidergeneral_general',
				'text' => 'Enable/disable autoplay for the Slider',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/module-general-settings/'
			
			),
			'lazy_loading' => array(
			
				'title' => 'Lazy Loading',
				'target' => '#form_slidergeneral_advanced_loading .collapsable',
				'placer' => '#form_slidergeneral_advanced_loading label_a',
				'focus' => '.ddTP_S',
				'alignment' => 'top-left',
				'margin' => '-4px 0 0 -15px',
				'trigger' => array('#module_settings_trigger', '#gst_sl_10'),
				'section' => 'Module General Options -> Advanced',
				'scrollTo' => '#form_module_advanced',
				'text' => "Enable LazyLoading for your Slider's images for faster page loading",
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/advanced-module-settings/'
			
			),
			'progress_bar' => array(
			
				'title' => 'Progress Bar',
				'target' => '#form_nav_pbara',
				'placer' => '#form_nav_pbara .form_inner_header',
				'focus' => '.tponoffwrap',
				'alignment' => 'left',
				'margin' => '-4px 0 0 -15px',
				'cssClass' => 'form_collector nav_collector',
				'trigger' => array('#module_navigation_trigger', '#gst_nav_1'),
				'section' => 'Navigation Options -> Progress',
				'text' => "Display the Slider's progress with an animated horizontal bar",
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/progress-bar/'
			
			),
			'navigation_arrows' => array(
			
				'title' => 'Navigation Arrows',
				'target' => '#form_nav_arrows',
				'placer' => '#form_nav_arrows .form_inner_header',
				'focus' => '.tponoffwrap',
				'alignment' => 'left',
				'margin' => '-4px 0 0 -15px',
				'cssClass' => 'form_collector nav_collector form_menu_inside',
				'trigger' => array('#module_navigation_trigger', '#gst_nav_2'),
				'section' => 'Navigation Options -> Arrows',
				'text' => "Switch between Slides with navigation Arrows",
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/navigation-arrows/'
			
			),
			'navigation_bullets' => array(
			
				'title' => 'Navigation Bullets',
				'target' => '#form_nav_bullets',
				'placer' => '#form_nav_bullets .form_inner_header',
				'focus' => '.tponoffwrap',
				'alignment' => 'left',
				'margin' => '-4px 0 0 -15px',
				'cssClass' => 'form_collector nav_collector',
				'trigger' => array('#module_navigation_trigger', '#gst_nav_3'),
				'section' => 'Navigation Options -> Bullets',
				'text' => 'Switch between Slides with navigation Bullets',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/navigation-bullets/'
			
			),
			'navigation_tabs' => array(
			
				'title' => 'Navigation Tabs',
				'target' => '#form_nav_tabs',
				'placer' => '#form_nav_tabs .form_inner_header',
				'focus' => '.tponoffwrap',
				'alignment' => 'left',
				'margin' => '-4px 0 0 -15px',
				'cssClass' => 'form_collector nav_collector',
				'trigger' => array('#module_navigation_trigger', '#gst_nav_4'),
				'section' => 'Navigation Options -> Tabs',
				'text' => 'Switch between Slides with navigation Tabs',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/navigation-tabs/'
			
			),
			'navigation_thumbs' => array(
			
				'title' => 'Navigation Thumbs',
				'target' => '#form_nav_thumbs',
				'placer' => '#form_nav_thumbs .form_inner_header',
				'focus' => '.tponoffwrap',
				'alignment' => 'left',
				'margin' => '-4px 0 0 -15px',
				'cssClass' => 'form_collector nav_collector',
				'trigger' => array('#module_navigation_trigger', '#gst_nav_5'),
				'section' => 'Navigation Options -> Thumbs',
				'text' => 'Switch between Slides with navigation Thumbnails',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/navigation-thumbnails/'
			
			),
			'slide_background' => array(
			
				'title' => 'Slide Background',
				'target' => '#form_slidebg',
				'placer' => '#form_slidebg label_a',
				'focus' => '.ddTP_S',
				'alignment' => 'left',
				'margin' => '0 0 0 -20px',
				'cssClass' => 'form_collector slide_settings_collector',
				'trigger' => array('#module_slide_trigger', '#gst_slide_1'),
				'section' => 'Slide Options -> Background',
				'text' => "Set/change the current Slide's main background to an image, video or color",
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/slide-background/'
			
			),
			'slide_animation' => array(
			
				'title' => 'Slide Animation',
				'target' => '#form_slide_transition',
				'placer' => '#active_transitions_innerwrap',
				'focus' => '.rightbutton',
				'alignment' => 'left',
				'margin' => '-3px 0 0 -20px',
				'cssClass' => 'form_collector slide_settings_collector',
				'trigger' => array('#module_slide_trigger', '#gst_slide_2'),
				'section' => 'Slide Options -> Title',
				'text' => "Set the animation for the Slide's main background image when the Slides change",
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/slide-animation/'
			
			),
			'background_filter' => array(
			
				'title' => 'Background Filter',
				'target' => '#form_slidebg_filters',
				'placer' => '#form_slidebg_filters label_a',
				'focus' => '.ddTP_S',
				'alignment' => 'left',
				'margin' => '-4px 0 0 -20px',
				'elementcss' => 'margin-top: -40px',
				'cssClass' => 'form_collector slide_settings_collector',
				'trigger' => array('#module_slide_trigger', '#gst_slide_5'),
				'section' => 'Slide Options -> Title',
				'text' => "Add a CSS image filter to the Slide's main background",
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/slide-filters/'
			
			),
			'slide_duration' => array(
			
				'title' => 'Slide Duration',
				'target' => '#form_slide_progress',
				'placer' => '#form_slide_progress label_a',
				'focus' => '#slide_length',
				'alignment' => 'left',
				'margin' => '-3px 0 0 -20px',
				'elementcss' => 'margin-top: -40px',
				'cssClass' => 'form_collector slide_settings_collector',
				'trigger' => array('#module_slide_trigger', '#gst_slide_8'),
				'section' => 'Slide Options -> Title',
				'text' => 'Adjust the total duration for the current Slide',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/slide-progress/'
			
			),
			'slide_link' => array(
			
				'title' => 'Slide Link',
				'target' => '#form_slidegeneral_linkseo',
				'placer' => '#form_slidegeneral_linkseo label_a',
				'focus' => '.tponoffwrap',
				'alignment' => 'top-left',
				'margin' => '-3px 0 0 -20px',
				'cssClass' => 'form_collector slide_settings_collector',
				'trigger' => array('#module_slide_trigger', '#gst_slide_4'),
				'section' => 'Slide Options -> Title',
				'scrollTo' => '#form_slidegeneral_linkseo',
				'text' => 'Add a link to the entire Slide',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/tags-link/'
			
			),
			'edit_text' => array(
			
				'title' => 'Edit Text',
				'target' => '#form_layercontent_content_text',
				'focus' => '#ta_layertext',
				'alignment' => 'left',
				'margin' => '-3px 0 0 -20px',
				'cssClass' => 'form_collector layer_settings_collector',
				'trigger' => array('._lc_type_text, ._lc_type_button', '#module_layers_trigger', '#gst_layer_1'),
				'section' => 'Layer Options -> Title',
				'text' => 'Edit the content of your text Layers here',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/layer-content/#edit-set-content'
			
			),
			'font_size' => array(
			
				'title' => 'Font Size',
				'target' => '#form_layerstyle_font',
				'focus' => '#layer_font_size_idle',
				'alignment' => 'top-left',
				'margin' => '-3px 0 0 -115px',
				'cssClass' => 'form_collector layer_settings_collector',
				'trigger' => array('._lc_type_text, ._lc_type_button', '#module_layers_trigger', '#gst_layer_3'),
				'section' => 'Layer Options -> Title',
				'scrollTo' => '#form_layer_style',
				'text' => 'Set the font-size for your text Layers here',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/font-colors-styling/'
			
			),
			'font_family' => array(
			
				'title' => 'Font Family',
				'target' => '#form_layerstyle_font',
				'focus' => '.ddTP_C--fontfamily .ddTP_S',
				'alignment' => 'top-left',
				'margin' => '-3px 0 0 -115px',
				'cssClass' => 'form_collector layer_settings_collector',
				'trigger' => array('._lc_type_text, ._lc_type_button', '#module_layers_trigger', '#gst_layer_3'),
				'section' => 'Layer Options -> Title',
				'scrollTo' => '#form_layer_style',
				'text' => 'Set the font-family for your text Layers here',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/font-colors-styling/'
			
			),
			'font_color' => array(
			
				'title' => 'Font Color',
				'target' => '#form_layerstyle_font',
				'focus' => '.rev-colorpicker',
				'alignment' => 'top-left',
				'margin' => '-3px 0 0 -115px',
				'cssClass' => 'form_collector layer_settings_collector',
				'trigger' => array('._lc_type_text, ._lc_type_button', '#module_layers_trigger', '#gst_layer_3'),
				'section' => 'Layer Options -> Title',
				'scrollTo' => '#form_layer_style',
				'text' => 'Set the text color for your Layers here',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/font-colors-styling/'
			
			),
			'layer_position' => array(
			
				'title' => 'Layer Position',
				'target' => '#rs-align-buttons',
				'alignment' => 'left',
				'focus' => 'none',
				'margin' => '-3px 0 0 -20px',
				'cssClass' => 'form_collector layer_settings_collector',
				'trigger' => array('._lc_type_text, ._lc_type_button, ._lc_type_video, ._lc_type_shape, ._lc_type_image, ._lc_type_audio, ._lc_type_object', '#module_layers_trigger', '#gst_layer_2'),
				'section' => 'Layer Options -> Title',
				'text' => "Adjust the Layer's position inside the current Slide",
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/size-position/'
			
			),
			'layer_animations' => array(
			
				'title' => 'Layer Animations',
				'target' => '#form_animation_sframes_keyframes',
				'alignment' => 'left',
				'focus' => 'none',
				'placer' => '#form_animation_sframes_keyframes',
				'margin' => '-26px 0 0 0',
				'cssClass' => 'form_collector layer_settings_collector',
				'trigger' => array('._lc_', '#module_layers_trigger', '#gst_layer_4'),
				'section' => 'Layer Options -> Title',
				'text' => 'Set the in/out animations for your Layer content here',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/layer-animations/'
			
			),
			'layer_hover' => array(
			
				'title' => 'Layer Hover',
				'target' => '#form_layer_hover',
				'alignment' => 'left',
				'focus' => '.tponoffwrap',
				'placer' => '#form_layer_hover label_a',
				'margin' => '57px 0 0 0',
				'cssClass' => 'form_collector layer_settings_collector',
				'trigger' => array('._lc_', '#module_layers_trigger', '#gst_layer_9'),
				'section' => 'Layer Options -> Title',
				'text' => 'Apply hover styles to your Layers',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/mouse-hover-settings/'
			
			),
			'edit_layer_name' => array(
			
				'title' => 'Edit Layer Name',
				'target' => '#do_title_layer',
				'alignment' => 'bottom',
				'margin' => '20px 0 0 0',
				'trigger' => array('._lc_'),
				'section' => 'Layer Options -> Title',
				'text' => 'Change the name of your Layers here to help organize your content'
				
			),
			'responsive_behavior' => array(
			
				'title' => 'Responsive Behavior',
				'target' => '#form_layerposition_basic',
				'alignment' => 'left',
				'focus' => '.tponoffwrap',
				'placer' => '#form_layerposition_basic label_a',
				'margin' => '57px 0 0 0',
				'cssClass' => 'form_collector layer_settings_collector',
				'trigger' => array('._lc_', '#module_layers_trigger', '#gst_layer_13'),
				'section' => 'Layer Options -> Title',
				'text' => 'Adjust the responsive behavior of your content here',
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/responsive-settings/'
			
			),
			'timeline_preview' => array(
			
				'title' => 'Timeline Preview',
				'target' => '.tl_playstop_wrap',
				'focus' => '#timline_process',
				'alignment' => 'top',
				'margin' => '15px 0 0 -3px',
				'cssClass' => 'rb-tooltip-timeline',
				'text' => "Preview the current Slide's animations",
				'linkText' => 'Learn More',
				'link' => 'https://www.sliderrevolution.com/documentation/slide-timeline/'
			
			),
			'save_module' => array(
			
				'title' => 'Save Module',
				'target' => '#save_slider',
				'focus' => 'none',
				'alignment' => 'right-top',
				'margin' => '25px 0px 0px 55px',
				'hidePrevSave' => true,
				'text' => 'Click this button to save your changes'
			
			),
			'preview_module' => array(
			
				'title' => 'Preview Module',
				'target' => '#preview_slider',
				'focus' => 'none',
				'alignment' => 'right-top',
				'margin' => '25px 0px 0px 70px',
				'hidePrevSave' => true,
				'text' => 'Click this button to preview the current Slide'
			
			)
			
		);
		
		return array('translations' => $translations, 'tooltips' => $tooltips);
		
	}
	
}