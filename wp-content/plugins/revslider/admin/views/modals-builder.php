<?php
/**
 * Provide an admin area view for the Slider Modal Options
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2019 ThemePunch
 */
 
if(!defined('ABSPATH')) exit();
?>

<!--QUICK GUIDE MODAL-->
<div class="_TPRB_ rb-modal-wrapper" data-modal="rbm_colorskins">
	<div class="rb-modal-inner">
		<div class="rb-modal-content">
			<div id="rbm_colorskins" class="rb_modal form_inner">
				<div class="rbm_header"><i class="rbm_symbol material-icons">format_paint</i><span class="rbm_title"><?php _e('Global Color Skin', 'revslider');?></span><i class="rbm_close material-icons">close</i></div>	
				<div class="rbm_content">
					<div class="modal_fields_title" style="width:170px;margin-right:10px;"><?php _e('SKIN TITLE', 'revslider');?></div><div class="modal_fields_title"><?php _e('SKIN COLOR', 'revslider');?></div>
					<div id="module_color_skins"></div>
					<div class="div20"></div>
					<div id="add_skin_color" class="basic_action_button layerinput autosize rightbutton"><i class="material-icons">color_lens</i><?php _e('Add Skin', 'revslider');?></div><div class="tp-clearfix"></div>
					<div class="div40"></div>
					<div class="global_sas_wrap">
						<label_a style="max-width:none; width:auto;"><?php _e('Show this Modal on Editor launch', 'revslider');?></label_a><input type="checkbox" id="sr_show_glob_skins" class="sliderinput easyinit" data-r="skins.colorsAtStart">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<!--QUICK GUIDE MODAL-->
<div class="_TPRB_ rb-modal-wrapper" data-modal="rbm_quickguide">
	<div class="rb-modal-inner">
		<div class="rb-modal-content">
			<div id="rbm_quickguide" class="rb_modal form_inner">
				<div class="rbm_header"><i class="rbm_symbol material-icons">new_releases</i><span class="rbm_title"><?php _e('Module Creation Guide', 'revslider');?></span><i class="rbm_close material-icons">close</i></div>	
				<div class="rbm_content">
					<!-- PAGE 0 -->
					<div id="mcg_page_0"  class="mcg_page mcg_selected">
						<div class="dcenter">
							<div class="div30"></div>
							<div class="mcg_page_title"><?php _e('Welcome to Slider Revolution 6', 'revslider');?></div>
							<div class="mcg_page_subtitle"><?php _e('This Guide will help you with the basic configuration *<br>of your Slider Revolution 6 Module.', 'revslider');?></div>
							<div class="div100"></div>
							<bluebutton class="normal mcg_next_page"><?php _e('Start Guide', 'revslider');?></bluebutton>
							<div class="div10"></div>
							<graybutton class="normal mcg_quit_page"><?php _e('Quit Guide', 'revslider');?></graybutton>
						</div>
						<div class="mcg_page_footer">
							<div id="mcg_page_0_blurredbox"></div>
							<div class="mcg_footer_content">
								<grayiconbox><i class="material-icons">help_outline</i></grayiconbox>
								<blueiconbox class="blueiconongray"><i class="material-icons">help_outline</i></blueiconbox>
								<div class="mcg_fotter_text"><?php _e('* All settings adjusted by the guide can be changed later.<br>Click the <strong>Help Icon</strong> to find options & documentation', 'revslider');?></div>
							</div>
						</div>
					</div>

					<!-- PAGE 1 -->
					<div id="mcg_page_1"  class="mcg_page">
						<div class="dcenter">
							<div class="div30"></div>
							<div class="mcg_page_title"><?php _e('What type of module would you like to create?');?></div>				
							<div class="div35"></div>
						</div>			
						<div class="mcg_option_third_wraps">
							<div class="st_slider mcg_guide_optionwrap mcg_option_third">
								<input data-unavailable=".standardunavailable" data-available=".standardavailable" data-disable=".standarddisable" data-enable=".standardenable" data-select=".st_slider" data-unselect=".st_scene, .st_carousel" data-r="type" data-evt="updatesliderlayout"  data-evtparam="slidertype" type="radio" value="standard" id="slidertype_guide_standard" name="slidertype_guide" class="sliderinput easyinit" data-show="" data-hide="">
								<mcg_guide_image class="guide_slider"></mcg_guide_image>
								<div class="mcg_o_title"><?php _e('Slider');?></div>
								<div class="mcg_o_descp"><?php _e('A Slider consists of multiple Slides.<br>Each Slide has its own content and can be<br>navigated to with various optional<br>navigation elements.');?></div>
							</div>
							<div class="st_scene mcg_guide_optionwrap mcg_option_third">
								<input data-unavailable=".sceneunavailable" data-available=".sceneavailable" data-disable=".herodisable" data-enable=".heroenable" data-select=".st_scene" data-unselect=".st_slider, .st_carousel" data-r="type" data-evt="updatesliderlayout" data-evtparam="slidertype" type="radio" value="hero" id="slidertype_guide_hero"  name="slidertype_guide" class="sliderinput easyinit" data-show="" data-hide="">
								<mcg_guide_image class="guide_scene"></mcg_guide_image>
								<div class="mcg_o_title"><?php _e('Scene');?></div>
								<div class="mcg_o_descp"><?php _e('A Scene is essentially a Slider with a single<br>Slide and no navigation elements.<br>Best used for content modules that require<br>no additional depth.');?></div>
							</div>
							<div class="st_carousel mcg_guide_optionwrap mcg_option_third last">
								<input data-unavailable=".carouselunavailable" data-available=".carouselavailable" data-disable=".carouseldisable" data-enable=".carouselenable" data-select=".st_carousel" data-unselect=".st_slider, .st_scene" data-r="type" data-evt="updatesliderlayout"  data-evtparam="slidertype" type="radio" value="carousel" id="slidertype_guide_carousel"  name="slidertype_guide" class="sliderinput easyinit" data-show="" data-hide="">
								<mcg_guide_image class="guide_carousel"></mcg_guide_image>
								<div class="mcg_o_title"><?php _e('Carousel');?></div>
								<div class="mcg_o_descp"><?php _e('A Carousel is a Slider with multiple Slides<br>visible at the same time.<br>There are lots of options to customize the Carousel.');?></div>
							</div>
						</div>
						<div class="mcg_footer_btns_right"><graybutton class="minimal mcg_prev_page"><?php _e('Previous Step', 'revslider');?></graybutton></div>
						<div class="mcg_footer_btns">
							<div class="mcg_page_minititle"><?php _e('Module Type', 'revslider');?></div>
							<div class="mcg_page_pagination">1/3</div>
							<bluebutton class="minimal mcg_next_page"><?php _e('Next Step', 'revslider');?></bluebutton>				
						</div>			
					</div>

					<!-- PAGE 2 -->
					<div id="mcg_page_2"  class="mcg_page">
						<div class="dcenter">
							<div class="div30"></div>
							<div class="mcg_page_title"><?php _e('What size should the module have?');?></div>				
							<div class="div35"></div>
						</div>
						<div class="mcg_option_third_wraps">				
							<div class="sl_auto mcg_guide_optionwrap mcg_option_third">
								<input data-select=".sl_auto" data-unselect=".sl_fullwidth, .sl_fullscreen" data-r="layouttype" data-evt="updatesliderlayout" type="radio" value="auto" id="sliderlayouttype_guide_auto" name="sliderlayouttype_guide" class="sliderinput easyinit" data-show="#sr_size_minheight" data-hide=".sliderminheights,.decreaseheights">
								<mcg_guide_image class="guide_auto"></mcg_guide_image>
								<div class="mcg_o_title"><?php _e('Auto');?></div>
								<div class="mcg_o_descp"><?php _e('The module dimensions will automatically<br>adjust to the surrounding container width,<br>keeping its aspect ratio.');?></div>
							</div>
							<div class="sl_fullwidth mcg_guide_optionwrap mcg_option_third">
								<input data-select=".sl_fullwidth" data-unselect=".sl_auto, .sl_fullscreen" data-r="layouttype" data-evt="updatesliderlayout" type="radio" value="fullwidth" id="sliderlayouttype_guide_fullwidth" name="sliderlayouttype_guide" class="sliderinput easyinit" data-show="#sr_size_minheight" data-hide=".sliderminheights,.decreaseheights">
								<mcg_guide_image class="guide_fullwidth"></mcg_guide_image>
								<div class="mcg_o_title"><?php _e('Full-Width');?></div>
								<div class="mcg_o_descp"><?php _e('The module will always span across the<br>full-width of the web-page. The height can<br>be flexible depending on other settings.');?></div>
							</div>
							<div class="sl_fullscreen mcg_guide_optionwrap mcg_option_third last">
								<input data-select=".sl_fullscreen" data-unselect=".sl_auto, .sl_fullwidth" data-r="layouttype" data-evt="updatesliderlayout" type="radio" value="fullscreen" id="sliderlayouttype_guide_fullscreen" name="sliderlayouttype_guide" class="sliderinput easyinit" data-show="#sr_size_minheight_fs, .decreaseheights" data-hide=".sliderminheights">
								<mcg_guide_image class="guide_fullscreen"></mcg_guide_image>
								<div class="mcg_o_title"><?php _e('Full-Screen');?></div>
								<div class="mcg_o_descp"><?php _e('The module will always fit the full area<br>within the web-page.');?></div>
							</div>
						</div>
						<div class="mcg_footer_btns_right"><graybutton class="minimal mcg_prev_page"><?php _e('Previous Step', 'revslider');?></graybutton></div>
						<div class="mcg_footer_btns">
							<div class="mcg_page_minititle"><?php _e('Module Dimensions', 'revslider');?></div>
							<div class="mcg_page_pagination">2/3</div>
							<bluebutton class="minimal mcg_next_page"><?php _e('Next Step', 'revslider');?></bluebutton>				
						</div>			
					</div>

					<!-- PAGE 3 -->
					<div id="mcg_page_3"  class="mcg_page">
						<div class="dcenter">
							<div class="div30"></div>
							<div class="mcg_page_title"><?php _e('How would you like your content to resize?');?></div>				
							<div class="div35"></div>
						</div>
						<div class="mcg_option_third_wraps">
							<div id="guide_classic" class="guide_combi_resize  mcg_guide_optionwrap mcg_option_third">
								<mcg_guide_image class="guide_autoresponsive"></mcg_guide_image>
								<div class="mcg_o_title"><?php _e('Classic, Linear Resizing');?></div>
								<div class="mcg_o_descp"><?php _e('Layers will resize in a linear fashion, as the module size changes. You only need to configure one screen size.');?></div>
							</div>
							<div id="guide_intelligent" class="guide_combi_resize mcg_guide_optionwrap mcg_option_third">
								<mcg_guide_image class="guide_intelligent"></mcg_guide_image>
								<div class="mcg_o_title"><?php _e('Intelligent Inheriting');?></div>
								<div class="mcg_o_descp"><?php _e('Four custom device sizes are activated and a layers size / position is automatically calculated from its desktop device size. You can make individual adjustments to layers in all device sizes.');?></div>
							</div>
							<div id="guide_manual" class="guide_combi_resize mcg_guide_optionwrap mcg_option_third last">
								<mcg_guide_image class="guide_manual"></mcg_guide_image>
								<div class="mcg_o_title"><?php _e('Manual Custom Sizes');?></div>
								<div class="mcg_o_descp"><?php _e('Four custom device sizes are activated and layers need to be manually adjusted to their respective device sizes.');?></div>
							</div>
						</div>
						<div class="mcg_footer_btns_right"><graybutton class="minimal mcg_prev_page"><?php _e('Previous Step', 'revslider');?></graybutton></div>
						<div class="mcg_footer_btns">
							<div class="mcg_page_minititle"><?php _e('Responisvity', 'revslider');?></div>
							<div class="mcg_page_pagination">3/3</div>
							<!--<bluebutton class="minimal mcg_next_page"><?php _e('Next Step', 'revslider');?></bluebutton>-->
							<bluebutton class="minimal mcg_quit_page"><?php _e('Go to Editor', 'revslider');?></bluebutton>
						</div>			
					</div>

					<!-- PAGE 4 -->
					<!--<div id="mcg_page_4"  class="mcg_page">
						<div class="dcenter">
							<div class="mcg_page_title"><?php _e('Further module customization');?></div>				
							<div class="div10"></div>
						</div>
						<div class="mcg_option_third_wraps">
							<div class="mcg_option_third">
								<div class="mcg_o_title_gray"><?php _e('Add Navigation');?></div>
								<div class="mcg_video_preview"></div>
							</div>
							<div class="mcg_option_third">
								<div class="mcg_o_title_gray"><?php _e('Slide Animation');?></div>
								<div class="mcg_video_preview"></div>
							</div>
							<div class="mcg_option_third last">
								<div class="mcg_o_title_gray"><?php _e('Slide Background Media');?></div>
								<div class="mcg_video_preview"></div>
							</div>
						</div>
						<div class="div45"></div>
						<div class="mcg_option_third_wraps">
							<div class="mcg_option_third">
								<div class="mcg_o_title_gray"><?php _e('Add Navigation');?></div>
								<div class="mcg_video_preview"></div>
							</div>
							<div class="mcg_option_third">
								<div class="mcg_o_title_gray"><?php _e('Slide Animation');?></div>
								<div class="mcg_video_preview"></div>
							</div>
							<div class="mcg_option_third last">
								<div class="mcg_o_title_gray"><?php _e('Slide Background Media');?></div>
								<div class="mcg_video_preview"></div>
							</div>
						</div>
						<div class="mcg_footer_btns_right"><graybutton class="minimal mcg_prev_page"><?php _e('Previous Step', 'revslider');?></graybutton></div>
						<div class="mcg_footer_btns">
							<div class="mcg_page_minititle"><?php _e('Customization', 'revslider');?></div>
							<div class="mcg_page_pagination">4/4</div>
							<bluebutton class="minimal mcg_quit_page"><?php _e('Go to Editor', 'revslider');?></bluebutton>
						</div>			
					</div>-->

				</div>
			</div>
		</div>
	</div>
</div><!-- END OF QUICK GUIDE MODAL -->


<!--LAYER IMPORT/EXPORT MODAL-->
<div class="_TPRB_ rb-modal-wrapper" data-modal="rbm_layerimport">
	<div class="rb-modal-inner">
		<div class="rb-modal-content">
			<div id="rbm_layerimport" class="rb_modal form_inner">
				<div class="rbm_header"><i class="rbm_symbol material-icons">import_export</i><span class="rbm_title"><?php _e('Layer Import', 'revslider');?></span><i class="rbm_close material-icons">close</i></div>
				<div class="rbm_content">
					<!-- THE LEFT SIDE OF THE AWESOME MODAL WINDOW -->
					<div id="rbm_layerimport_list">
					</div>
					<div id="rbm_layerimport_buttonwrap">
						<div id="layers_import_feedback"></div>
						<div id="layers_import_from_slides_button" class="basic_action_button autosize rightbutton layerinput"><i class="material-icons">import_export</i><?php _e('Import Selected Layers', 'revslider');?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><!-- END OF LAYER IMPORT/EXPORT MODAL -->


<!-- NAVIGATION EDITOR -->
<div class="_TPRB_ rb-modal-wrapper" data-modal="rbm_navigation_editor">
	<div class="rb-modal-inner">
		<div class="rb-modal-content">
			<div id="rbm_navigation_editor" class="rb_modal form_inner">
				<div class="rbm_header"><i class="rbm_symbol material-icons">games</i><span class="rbm_title"><?php _e('Navigation Editor', 'revslider');?></span><i class="rbm_close material-icons">close</i></div>
				<div class="rbm_content">
					<div id="save_naveditor"><i class="material-icons">save</i><?php _e('Save Navigation', 'revslider');?></div>
					<div id="rs_ne_left_wrap">
						<div id="rs_ne_selector_arrows" class="rs_ne_selector selected" data-type="arrows"><i class="material-icons">swap_horiz</i><?php _e('Arrows', 'revslider');?></div><!--
						--><div id="rs_ne_selector_bullets" class="rs_ne_selector" data-type="bullets"><i class="material-icons">more_horiz</i><?php _e('Bullets', 'revslider');?></div><!--
						--><div id="rs_ne_selector_tabs" class="rs_ne_selector" data-type="tabs"><i class="material-icons">view_column</i><?php _e('Tabs', 'revslider');?></div><!--
						--><div id="rs_ne_selector_thumbs" class="rs_ne_selector" data-type="thumbs"><i class="material-icons">filter_frames</i><?php _e('Thumbs', 'revslider');?></div>
						<div id="rs_ne_navlist_wrap">
							<div id="rs_ne_navlist">
								<div class="rs_ne_navlist_header"><?php _e('Factory Skins', 'revslider');?></div>
								<div class="rs_ne_list_wrapper"><div id="rs_ne_factory_list"></div></div>
								<div class="rs_ne_navlist_header"><?php _e('Custom', 'revslider');?></div>
								<div class="rs_ne_list_wrapper"><div id="rs_ne_custom_list"></div></div>
							</div>
							<div class="rs_ne_add_new_wrap"><div id="rs_ne_new_custom_nav" class="basic_action_button fullbutton"><i class="material-icons">add</i><?php _e('Add New Navigation ', 'revslider');?></div></div>
						</div>
					</div>

					<div id="rs_ne_right_wrap">
						<div id="rs_ne_preview_wrap">
								<!-- ARROWS -->
								<div id="rs_ne_arrows">
									<div id="rs_ne_tp-rightarrow" class="tp-rightarrow tparrows"></div>
									<div id="rs_ne_tp-leftarrow" class="tp-leftarrow tparrows"></div>
								</div>

								<!-- BULLETS -->
								<div id="rs_ne_bullets" class="tp-bullets">
								</div>

								<!-- TABS -->
								<div id="rs_ne_tabs" class="tp-tabs">
									<div id="rs_ne_tabs-mask" class="tp-tabs-mask">
										<div id="rs_ne_tabs-inner-wrapper" class="tp-tabs-inner-wrapper"></div>
									</div>
								</div>

								<!-- NAVIGATION THUMBS -->
								<div id="rs_ne_thumbs" class="tp-thumbs">
									<div id="rs_ne_thumbs-mask" class="tp-thumbs-mask">
										<div id="rs_ne_thumbs-inner-wrapper" class="tp-thumbs-inner-wrapper"></div>
									</div>
								</div>
						</div>
						<div id="rs_ne_ce_wrap">
							<div id="rs_ne_settings">
								<label_a style="width:auto"><?php _e('Class', 'revslider');?></label_a><input type="text" id="rs_ne_nav_classname"/>
								<label_icon class="ui_width" style="margin-left:15px;"></label_icon><input type="text" class="basicinput callEvent" data-evt="rsdimgapchange" data-evtparam="width" id="rs_ne_nav_width"/>
								<label_icon class="ui_height" style="margin-left:5px;"></label_icon><input type="text" class="basicinput callEvent" data-evt="rsdimgapchange" data-evtparam="height" id="rs_ne_nav_height"/>
								<label_icon class="ui_gap" style="margin-left:33px;"></label_icon><input type="text" value="5" class="basicinput callEvent" data-evt="rsdimgapchange" data-evtparam="space" id="rs_ne_nav_space"/>
								<div style="margin-left:11px" id="rs_ne_horizontaltest" data-evt="setrsnavtohorizontal" class="eventcaller basic_action_button onlyicon selected"><i class="material-icons">more_horiz</i></div><div id="rs_ne_verticaltest" data-evt="setrsnavtovertical" class="eventcaller basic_action_button onlyicon"><i class="material-icons">more_vert</i></div>
								<select style="display:none !important" id="rs_nav_test_position" data-unselect=".rs_nav_test_position_selector" data-select="#rs_nav_test_position_*val*" data-evt="setrsnavposition" data-show=".rs_nav_test_pos_*val*" data-hide=".rs_nav_test_pos" class="basicinput callEvent"><option value="left center"><?php _e('left center', 'revslider');?></option><option value="left bottom"><?php _e('left bottom', 'revslider');?></option><option value="left top"><?php _e('left top', 'revslider');?></option><option value="center top"><?php _e('center top', 'revslider');?></option><option value="center center"><?php _e('center center', 'revslider');?></option><option selected value="center bottom"><?php _e('center bottom', 'revslider');?></option><option value="right top"><?php _e('right top', 'revslider');?></option><option value="right center"><?php _e('right center', 'revslider');?></option><option value="right bottom"><?php _e('right bottom', 'revslider');?></option></select>
								<div class="bg_alignselector_wrap">
									<div class="bg_align_row">
										<div class="triggerselect rs_nav_test_position_selector bg_alignselector" data-select="#rs_nav_test_position" data-val="left top" id="rs_nav_test_position_left-top"></div>
										<div class="triggerselect rs_nav_test_position_selector bg_alignselector" data-select="#rs_nav_test_position" data-val="center top" id="rs_nav_test_position_center-top"></div>
										<div class="triggerselect rs_nav_test_position_selector bg_alignselector" data-select="#rs_nav_test_position" data-val="right top" id="rs_nav_test_position_right-top"></div>
									</div>
									<div class="bg_align_row">
										<div class="triggerselect rs_nav_test_position_selector bg_alignselector" data-select="#rs_nav_test_position" data-val="left center" id="rs_nav_test_position_left-center"></div>
										<div class="triggerselect rs_nav_test_position_selector bg_alignselector" data-select="#rs_nav_test_position" data-val="center center" id="rs_nav_test_position_center-center"></div>
										<div class="triggerselect rs_nav_test_position_selector bg_alignselector" data-select="#rs_nav_test_position" data-val="right center" id="rs_nav_test_position_right-center"></div>
									</div>
									<div class="bg_align_row">
										<div class="triggerselect rs_nav_test_position_selector bg_alignselector" data-select="#rs_nav_test_position" data-val="left bottom" id="rs_nav_test_position_left-bottom"></div>
										<div class="triggerselect rs_nav_test_position_selector bg_alignselector selected" data-select="#rs_nav_test_position" data-val="center bottom" id="rs_nav_test_position_center-bottom"></div>
										<div class="triggerselect rs_nav_test_position_selector bg_alignselector" data-select="#rs_nav_test_position" data-val="right bottom" id="rs_nav_test_position_right-bottom"></div>
									</div>
								</div>

							</div>
							<div id="rs_ne_markup_css_button_wrap"><div id="rs_ne_mcss_thecsseditor" data-mode="css" data-show="#rs_ne_css_meta" data-hide="#rs_ne_markup_meta" class="rs_ne_markup_css_button rsnmcb_right"><?php _e('CSS', 'revslider');?></div><div data-mode="markup" data-show="#rs_ne_markup_meta" data-hide="#rs_ne_css_meta" class="rs_ne_markup_css_button rsnmcb_left selected"><?php _e('Markup', 'revslider');?></div></div>
							<div id="rs_nav_css_js_area">
							</div>
						</div>
						<div id="rs_ne_helper_wrap">
							<div id="rs_ne_markup_meta">
								<div class="rs_ne_header"><?php _e('Markup Meta', 'revslider');?></div>
								<div class="rs_ne_markup_meta_btn" data-insert="{{title}}"><?php _e('Slide Title', 'revslider');?></div>
								<div class="rs_ne_markup_meta_btn" data-insert="{{description}}"><?php _e('Slide Description', 'revslider');?></div>
								<div class="rs_ne_markup_meta_btn" data-insert="{{param1}}"><?php _e('Parameter 1', 'revslider');?></div>
								<div class="rs_ne_markup_meta_btn" data-insert="{{param2}}"><?php _e('Parameter 2', 'revslider');?></div>
								<div class="rs_ne_markup_meta_btn" data-insert="{{param3}}"><?php _e('Parameter 3', 'revslider');?></div>
								<div class="rs_ne_markup_meta_btn" data-insert="{{param4}}"><?php _e('Parameter 4', 'revslider');?></div>
								<div class="rs_ne_markup_meta_btn" data-insert="{{param5}}"><?php _e('Parameter 5', 'revslider');?></div>
								<div class="rs_ne_markup_meta_btn" data-insert="{{param6}}"><?php _e('Parameter 6', 'revslider');?></div>
								<div class="rs_ne_markup_meta_btn" data-insert="{{param7}}"><?php _e('Parameter 7', 'revslider');?></div>
								<div class="rs_ne_markup_meta_btn" data-insert="{{param8}}"><?php _e('Parameter 8', 'revslider');?></div>
								<div class="rs_ne_markup_meta_btn" data-insert="{{param9}}"><?php _e('Parameter 9', 'revslider');?></div>
								<div class="rs_ne_markup_meta_btn" data-insert="{{param10}}"><?php _e('Parameter 10', 'revslider');?></div>
							</div>
							<div id="rs_ne_css_meta">
								<div id="rs_ne_cssmeta_values">
									<div class="rs_ne_header"><?php _e('Meta Values', 'revslider');?></div>
									<div id="rs_ne_meta_values_inner"></div>
									<div class="rs_ne_add_new_wrap" style="padding-left:0px; padding-right:30px"><div id="add_new_placeholder" class="basic_action_button fullbutton"><i class="material-icons">add</i><?php _e('Add New Meta', 'revslider');?></div></div>
								</div>
								<div id="rs_ne_cssmeta_config">
									<div class="rs_ne_header"><?php _e('Meta Config', 'revslider');?></div>
									<label_a><?php _e('Type', 'revslider');?></label_a><select id="rs_ne_meta_type" data-show="#rs_ne_def_meta_*val*_val_wrap" data-hide=".rs_ne_def_meta_wrap" class="tos2 nosearchbox basicinput"><option value="color"><?php _e('Color', 'revslider');?></option></option><option selected value="custom"><?php _e('Custom', 'revslider');?></option><option value="font-family"><?php _e('Font Family', 'revslider');?></option><option value="icon"><?php _e('Icon', 'revslider');?></option></select><linebreak></linebreak>
									<div class="rs_ne_def_meta_wrap" id="rs_ne_def_meta_font-family_val_wrap"><label_a><?php _e('Default', 'revslider');?></label_a><select id="nav_fontfamily" class="basicinput searchbox tos2" data-evt="updateFontFamily"></select></div>
									<div class="rs_ne_def_meta_wrap" id="rs_ne_def_meta_custom_val_wrap"><label_a><?php _e('Default', 'revslider');?></label_a><input id="rs_ne_def_meta_custom_val" type="text" /></div>
									<div class="rs_ne_def_meta_wrap" id="rs_ne_def_meta_color_val_wrap"><label_a><?php _e('Default', 'revslider');?></label_a><input id="rs_ne_def_meta_color_val" type="text" class="my-color-field" data-visible="true" value="#ffffff" data-editing="Meta Color" data-mode="single" name="nav_meta_color" /></div>
									<div class="rs_ne_def_meta_wrap" id="rs_ne_def_meta_icon_val_wrap"><label_a><?php _e('Default', 'revslider');?></label_a><input id="rs_ne_def_meta_icon_val" type="text"/>
										<div id="rs_ne_icons">
											<div class="font_icon_subcontainer">
												<i class="rs_ne_pick rs_ne_icon_e817 revicon-left-dir" data-content="\e817"></i><!--
												--><i class="rs_ne_pick rs_ne_icon_e818 revicon-right-dir" data-content="\e818"></i><!--
												--><i class="rs_ne_pick rs_ne_icon_e819 revicon-left-open" data-content="\e819"></i><!--
												--><i class="rs_ne_pick rs_ne_icon_e81a revicon-right-open" data-content="\e81a"></i><!--
												--><i class="rs_ne_pick rs_ne_icon_e820 revicon-angle-left" data-content="\e820"></i><!--
												--><i class="rs_ne_pick rs_ne_icon_e81d revicon-angle-right" data-content="\e81d"></i><!--
												--><i class="rs_ne_pick rs_ne_icon_e81f revicon-left-big" data-content="\e81f"></i><!--
												--><i class="rs_ne_pick rs_ne_icon_e81e revicon-right-big" data-content="\e81e"></i><!--
												--><i class="rs_ne_pick rs_ne_icon_e82a revicon-left-open-1" data-content="\e82a"></i><!--
												--><i class="rs_ne_pick rs_ne_icon_e82b revicon-right-open-1" data-content="\e82b"></i><!--
												--><i class="rs_ne_pick rs_ne_icon_e822 revicon-left-open-mini" data-content="\e822"></i><!--
												--><i class="rs_ne_pick rs_ne_icon_e823 revicon-right-open-mini" data-content="\e823"></i><!--
												--><i class="rs_ne_pick rs_ne_icon_e824 revicon-left-open-big" data-content="\e824"></i><!--
												--><i class="rs_ne_pick rs_ne_icon_e825 revicon-right-open-big" data-content="\e825"></i><!--
												--><i class="rs_ne_pick rs_ne_icon_e836 revicon-left" data-content="\e836"></i><!--
												--><i class="rs_ne_pick rs_ne_icon_e826 revicon-right" data-content="\e826"></i><!--
												--><i class="rs_ne_pick rs_ne_icon_e82e revicon-left-open-outline" data-content="\e82e"></i><!--
												--><i class="rs_ne_pick rs_ne_icon_e82f revicon-right-open-outline" data-content="\e82f"></i><!--
												--><i class="rs_ne_pick rs_ne_icon_e82c revicon-left-open-2" data-content="\e82c"></i><!--
												--><i class="rs_ne_pick rs_ne_icon_e82d revicon-right-open-2" data-content="\e82d"></i>
											</div>
										</div>
									</div>
									<label_a><?php _e('Title', 'revslider');?></label_a><input placeholder="<?php _e('Can not be Empty', 'revslider');?>" id="rs_ne_def_meta_title" type="text" /><linebreak></linebreak>
									<label_a><?php _e('Handle', 'revslider');?></label_a><input placeholder="<?php _e('Can not be Empty', 'revslider');?>" id="rs_ne_def_meta_handle" type="text" /><linebreak></linebreak>
									<div class="rs_ne_add_new_wrap"><div data-evt="closenavmetavalue" class="eventcaller basic_action_button onlyicon autosize"><i class="material-icons">close</i></div><div id="update_nav_meta_value" data-evt="updatenavmetavalue" class="eventcaller basic_action_button onlyicon autosize"><i class="material-icons">done</i></div></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<!-- SLIDER API MODAL -->
<div class="_TPRB_ rb-modal-wrapper" data-modal="rbm_slider_api" data-centerineditor="true">
	<div class="rb-modal-inner">
		<div class="rb-modal-content">
			<div id="rbm_slider_api" class="rb_modal form_inner">
				<div class="rbm_header"><i class="rbm_symbol material-icons">code</i><span class="rbm_title"><?php _e('CSS/JS Editor', 'revslider');?></span><div class="modal_header_functions"><div data-mode="css" class="selected js_css_editor_tabs"><?php _e('CUSTOM CSS', 'revslider');?></div><div data-mode="javascript" class="js_css_editor_tabs"><?php _e('CUSTOM JS', 'revslider');?></div></div></div>
				<div class="emc_toggle_wrap"><div class="emc_toggle_info">A<br>P<br>I</div><i id="emc_toggle" class="material-icons">keyboard_arrow_right</i><i class="rbm_close material-icons">close</i>
					<div class="emc_toggle_inner">
						<!-- MODULE API -->

							<div id="form_module_advanced_api"  data-select="#gst_sl_11" data-unselect=".general_submodule_trigger" class="formcontainer form_menu_inside collapsed">
								<!-- MODULE API INNER-->
								<div id="form_slidergeneral_advanced_api" class="form_inner">
									<div class="form_inner_header"><i class="material-icons">code</i><?php _e('Methods', 'revslider');?></div>
									<div class="collapsable" style="display:block !important">
										<label_a origtitle="<?php _e("Call this function to start the slider.", 'revslider');?>"><?php _e("Start Slider", 'revslider')?></label_a><!--
										--><div class="input_with_buttonextenstion">
											<input type="text" readonly  class="api-input withlabel" id="apiapi0" value="revapi.revstart();">
											<div class="basic_action_button insertineditor mini_action_button onlyicon buttonextension" data-insertfrom="#apiapi0"><i class="material-icons">add</i></div>
										</div>

										<label_a origtitle="<?php _e("Call this function to pause the slider.", 'revslider');?>"><?php _e("Pause Slider", 'revslider')?></label_a><!--
										--><div class="input_with_buttonextenstion">
											<input type="text" readonly  class="api-input withlabel" id="apiapi1" value="revapi.revpause();">
											<div class="buttonextension basic_action_button insertineditor mini_action_button onlyicon" data-insertfrom="#apiapi1"><i class="material-icons">add</i></div>
										</div>

										<label_a origtitle="<?php _e("Call this function to play the slider if it is paused.", 'revslider');?>"><?php _e("Resume Slider", 'revslider')?></label_a><!--
										--><div class="input_with_buttonextenstion">
											<input type="text" readonly class="api-input withlabel" id="apiapi2" value="revapi.revresume();">
											<div class="buttonextension basic_action_button insertineditor mini_action_button onlyicon" data-insertfrom="#apiapi2"><i class="material-icons">add</i></div>
										</div>

										<label_a origtitle="<?php _e("Switch slider to previous slide.", 'revslider');?>"><?php _e("Previous Slide", 'revslider')?></label_a><!--
										--><div class="input_with_buttonextenstion">
											<input type="text" readonly class="api-input withlabel" id="apiapi3" value="revapi.revprev();">
											<div class="buttonextension basic_action_button insertineditor mini_action_button onlyicon" data-insertfrom="#apiapi3"><i class="material-icons">add</i></div>
										</div>

										<label_a origtitle="<?php _e("Switch slider to next slide.", 'revslider');?>"><?php _e("Next Slide", 'revslider')?></label_a><!--
										--><div class="input_with_buttonextenstion">
											<input type="text" readonly class="api-input withlabel" id="apiapi4" value="revapi.revnext();">
											<div class="buttonextension basic_action_button insertineditor mini_action_button onlyicon" data-insertfrom="#apiapi4"><i class="material-icons">add</i></div>
										</div>

										<label_a origtitle="<?php _e("Scroll page under the slider.", 'revslider');?>"><?php _e("External Scroll", 'revslider')?></label_a><!--
										--><div class="input_with_buttonextenstion">
											<input type="text" readonly class="api-input withlabel" id="apiapi9" value="revapi.revscroll(offset);">
											<div class="buttonextension basic_action_button insertineditor mini_action_button onlyicon" data-insertfrom="#apiapi9"><i class="material-icons">add</i></div>
										</div>

										<label_a origtitle="<?php _e("Remove One Slide with Slide Index from the Slider. Index starts with 0 which will remove the first slide.", 'revslider');?>"><?php _e("Remove Slide", 'revslider')?></label_a><!--
										--><div class="input_with_buttonextenstion">
											<input type="text" readonly  class="api-input withlabel" id="apiapi12" value="revapi.revremoveslide(slideindex);">
											<div class="buttonextension basic_action_button insertineditor mini_action_button onlyicon" data-insertfrom="#apiapi12"><i class="material-icons">add</i></div>
										</div>

										<label_a origtitle="<?php _e("Switch to the slide which is defined as parameter.", 'revslider');?>"><?php _e("Go To Slide", 'revslider')?></label_a><!--
										--><div class="input_with_buttonextenstion">
											<input type="text" readonly class="api-input withlabel" id="apiapi5" value="revapi.revshowslide(2);">
											<div class="buttonextension basic_action_button insertineditor mini_action_button onlyicon" data-insertfrom="#apiapi5"><i class="material-icons">add</i></div>
										</div>

										<label_a origtitle="<?php _e("Switch to the slide which is defined as parameter.", 'revslider');?>"><?php _e("Go To Slide with ID", 'revslider')?></label_a><!--
										--><div class="input_with_buttonextenstion">
											<input type="text" readonly class="api-input withlabel" id="apiapi15" value="revapi.revcallslidewithid('rs-1007');">
											<div class="buttonextension basic_action_button insertineditor mini_action_button onlyicon" data-insertfrom="#apiapi15"><i class="material-icons">add</i></div>
										</div>

										<label_a origtitle="<?php _e("Get the amount of existing slides in the slider.", 'revslider');?>"><?php _e("Max Slides", 'revslider')?></label_a><!--
										--><div class="input_with_buttonextenstion">
											<input type="text" readonly class="api-input withlabel" id="apiapi6" value="revapi.revmaxslide();">
											<div class="buttonextension basic_action_button insertineditor mini_action_button onlyicon" data-insertfrom="#apiapi6"><i class="material-icons">add</i></div>
										</div>

										<label_a origtitle="<?php _e("Get the current focused slide index.", 'revslider');?>"><?php _e("Current Slide", 'revslider')?></label_a><!--
										--><div class="input_with_buttonextenstion">
											<input type="text" readonly class="api-input withlabel" id="apiapi7" value="revapi.revcurrentslide();">
											<div class="buttonextension basic_action_button insertineditor mini_action_button onlyicon" data-insertfrom="#apiapi7"><i class="material-icons">add</i></div>
										</div>

										<label_a origtitle="<?php _e("Get the previously played slide.", 'revslider');?>"><?php _e("Last Slide", 'revslider')?></label_a><!--
										--><div class="input_with_buttonextenstion">
											<input type="text" readonly class="api-input withlabel" id="apiapi8" value="revapi.revlastslide();">
											<div class="buttonextension basic_action_button insertineditor mini_action_button onlyicon" data-insertfrom="#apiapi8"><i class="material-icons">add</i></div>
										</div>

										<label_a origtitle="<?php _e("Recalculate all positions, sizing etc in the slider.  This should be called i.e. if Slider was invisible and becomes visible without any window resize event.", 'revslider');?>"><?php _e("Redraw Slider", 'revslider')?></label_a><!--
										--><div class="input_with_buttonextenstion">
											<input type="text" readonly  class="api-input withlabel" id="apiapi10" value="revapi.revredraw();">
											<div class="buttonextension basic_action_button insertineditor mini_action_button onlyicon" data-insertfrom="#apiapi10"><i class="material-icons">add</i></div>
										</div>

										<label_a origtitle="<?php _e("Unbind all listeners, remove current animations and delete containers. Ready for Garbage collection.", 'revslider');?>"><?php _e("Kill Slider", 'revslider')?></label_a><!--
										--><div class="input_with_buttonextenstion">
											<input type="text" readonly  class="api-input withlabel" id="apiapi11" value="revapi.revkill();">
											<div class="buttonextension basic_action_button insertineditor mini_action_button onlyicon" data-insertfrom="#apiapi11"><i class="material-icons">add</i></div>
										</div>
									</div>

								<!-- API EVENTS-->

									<div class="form_inner_header"><i class="material-icons">av_timer</i><?php _e('Events', 'revslider');?></div>
									<div class="collapsable" style="display:block !important">
										<label_full><?php _e("Slider Loaded", 'revslider')?></label_full><div class="basic_action_button insertineditor mini_action_button onlyicon" data-insertfrom="#apievent1"><i class="material-icons">add</i></div><span class="linebreak"></span>
										<textarea id="apievent1" class="api_area" readonly style="height:50px">revapi.bind("revolution.slide.onloaded",function (e) {});</textarea>

										<label_full><?php _e("Slider swapped to an other slide", 'revslider')?></label_full><div class="basic_action_button insertineditor mini_action_button onlyicon" data-insertfrom="#apievent2"><i class="material-icons">add</i></div><span class="linebreak"></span>
										<textarea id="apievent2"  class="api_area" readonly style="height:135px">revapi.bind("revolution.slide.onchange",function (e,data){&#013;   //data.slideIndex => <?php _e('Index of Current Slide', 'revslider');?>&#013;   //data.slideLIIndex => <?php _e('Current <li> Index', 'revslider');?>&#013;   //data.currentslide => <?php _e('Current Slide as jQuery Object', 'revslider');?>&#013;   //data.prevslide => <?php _e('Prev. Slide as jQuery Object', 'revslider');?>&#013;});</textarea>

										<label_full><?php _e("Slider paused", 'revslider')?></label_full><div class="basic_action_button insertineditor mini_action_button onlyicon" data-insertfrom="#apievent3"><i class="material-icons">add</i></div><span class="linebreak"></span>
										<textarea id="apievent3"  class="api_area"  readonly style="height:85px">revapi.bind("revolution.slide.onpause",function (e,data) {&#013;   //<?php _e('Timer Paused', 'revslider');?>&#013;});</textarea>

										<label_full><?php _e("Slider is Playing after pause", 'revslider')?></label_full><div class="basic_action_button insertineditor mini_action_button onlyicon" data-insertfrom="#apievent4"><i class="material-icons">add</i></div><span class="linebreak"></span>
										<textarea id="apievent4" class="api_area" readonly style="height:85px">revapi.bind("revolution.slide.onresume",function (e,data) {&#013;   //<?php _e('Timer Resumed', 'revslider');?>&#013;});</textarea>

										<label_full><?php _e("Video is playing in slider", 'revslider')?></label_full><div class="basic_action_button insertineditor mini_action_button onlyicon" data-insertfrom="#apievent5"><i class="material-icons">add</i></div><span class="linebreak"></span>
										<textarea id="apievent5" class="api_area" readonly style="height:135px">revapi.bind("revolution.slide.onvideoplay",function (e,data) {&#013;  //<?php _e('Video is playing', 'revslider');?>&#013;  //data.video => <?php _e('Video API', 'revslider');?>&#013;   //data.videotype => <?php _e('youtube, vimeo, html5', 'revslider');?>&#013;   //data.settings => <?php _e('Video Settings', 'revslider');?>&#013;});</textarea>

										<label_full><?php _e("Video stopped in slider", 'revslider')?></label_full><div class="basic_action_button insertineditor mini_action_button onlyicon" data-insertfrom="#apievent6"><i class="material-icons">add</i></div><span class="linebreak"></span>
										<textarea id="apievent6" class="api_area" readonly style="height:135px">revapi.bind("revolution.slide.onvideostop",function (e,data) {&#013;  //<?php _e('Video is stopped', 'revslider');?>&#013;  //data.video => <?php _e('Video API', 'revslider');?>&#013;   //data.videotype => <?php _e('youtube, vimeo, html5', 'revslider');?>&#013;   //data.settings => <?php _e('Video Settings', 'revslider');?>&#013;});</textarea>

										<label_full><?php _e("Slider reached the 'stop at' slide", 'revslider')?></label_full><div class="basic_action_button insertineditor mini_action_button onlyicon" data-insertfrom="#apievent7"><i class="material-icons">add</i></div><span class="linebreak"></span>
										<textarea id="apievent7" class="api_area" readonly style="height:85px">revapi.bind("revolution.slide.onstop",function (e,data) {&#013;   //<?php _e('Slider Stopped', 'revslider');?>&#013;});</textarea>

										<label_full><?php _e("Prepared for slide change", 'revslider')?></label_full><div class="basic_action_button insertineditor mini_action_button onlyicon" data-insertfrom="#apievent8"><i class="material-icons">add</i></div><span class="linebreak"></span>
										<textarea id="apievent8" class="api_area" readonly style="height:120px">revapi.bind("revolution.slide.onbeforeswap",function (e,data) {&#013;   //<?php _e('Slider Before Swap', 'revslider');?>&#013;   //data.currentslide => <?php _e('Current Slide as jQuery Object', 'revslider');?>&#013;   //data.nextslide => <?php _e('Coming Slide as jQuery Object', 'revslider');?>&#013;});</textarea>

										<label_full><?php _e("Finnished with slide change", 'revslider')?></label_full><div class="basic_action_button insertineditor mini_action_button onlyicon" data-insertfrom="#apievent9"><i class="material-icons">add</i></div><span class="linebreak"></span>
										<textarea id="apievent9" class="api_area" readonly style="height:120px">revapi.bind("revolution.slide.onafterswap",function (e,data) {&#013;   //<?php _e('Slider After Swap', 'revslider');?>&#013;   //data.currentslide => <?php _e('Current Slide as jQuery Object', 'revslider');?>&#013;   //data.prevslide => <?php _e('Previous Slide as jQuery Object', 'revslider');?>&#013;});</textarea>

										<label_full><?php _e("Last slide starts", 'revslider')?></label_full><div class="basic_action_button insertineditor mini_action_button onlyicon" data-insertfrom="#apievent10"><i class="material-icons">add</i></div><span class="linebreak"></span>
										<textarea id="apievent10" class="api_area" readonly style="height:65px">revapi.bind("revolution.slide.slideatend",function (e) {&#013;   //<?php _e('Last Slide Started, Slider is at the end', 'revslider');?>&#013;});</textarea>

										<label_full><?php _e("Layer Events", 'revslider')?></label_full><div class="basic_action_button insertineditor mini_action_button onlyicon" data-insertfrom="#apievent11"><i class="material-icons">add</i></div><span class="linebreak"></span>
										<textarea id="apievent11" class="api_area"  readonly style="height:150px">revapi.bind("revolution.slide.layeraction",function (e,data) {&#013;   //data.eventtype - <?php _e('Layer Action (enterstage, enteredstage, leavestage,leftstage)', 'revslider');?>&#013;   //data.layertype - <?php _e('Layer Type (image,video,html)', 'revslider');?>&#013;   //data.layersettings - <?php _e('Default Settings for Layer', 'revslider');?>&#013;   //data.layer - <?php _e('Layer as jQuery Object', 'revslider');?>&#013;});</textarea>
									</div><!-- COLLAPSED -->

							</div>
						</div><!-- END OF MODULE API -->
					</div>
				</div>
				<div class="rbm_content" id="rs_css_js_area"></div>
			</div>
		</div>
	</div>
</div>

<!--LAYER META MODAL-->
<div class="_TPRB_ rb-modal-wrapper" data-modal="rbm_layer_metas">
	<div class="rb-modal-inner">
		<div class="rb-modal-content">
			<div id="rbm_layer_metas" class="rb_modal form_inner">
				<div class="rbm_header"><i class="rbm_symbol material-icons">local_offer</i><span class="rbm_title"><?php _e('Meta Datas', 'revslider');?></span>
					<div id="mdl_group_wrap_menu"><!--
						--><div data-show="mdl_group_basic" class="mdl_group_wrap_menuitem selected"><?php _e('Basic', 'revslider');?></div><!--
						--><div data-show="mdl_group_post" class="mdl_group_wrap_menuitem"><?php _e('Post', 'revslider');?></div><!--
						--><div data-show="mdl_group_wc" class="mdl_group_wrap_menuitem"><?php _e('WooCommerce', 'revslider');?></div><!--
						--><div data-show="mdl_group_events" class="mdl_group_wrap_menuitem"><?php _e('Events', 'revslider');?></div><!--
						--><div data-show="mdl_group_social" class="mdl_group_wrap_menuitem"><?php _e('Social', 'revslider');?></div>
					</div>
					<i class="rbm_close material-icons">close</i>
				</div>
				<div class="rbm_content" id="meta_rbm_content">
					<div id="meta_datas_list">
						<div id="mdl_group_basic" class="mdl_group_wrap selected">
							<!-- Basics -->
							<div class="mdl_group">
								<div class="mdl_group_header"><i class="material-icons">copyright</i><?php _e('Basic Metas', 'revslider');?><i class="material-icons accordiondrop">arrow_drop_down</i></div>
								<div data-val="{{current_slide_index}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">bookmark</i><?php _e("Current Slide Index", 'revslider');?></div><div class="mdl_right_content">{{current_slide_index}}</div><div class="mdl_placeholder_content"><?php _e('03', 'revslider');?></div></div>
								<div data-val="{{total_slide_count}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">bookmark</i><?php _e("Number of Slides in Module", 'revslider');?></div><div class="mdl_right_content">{{total_slide_count}}</div><div class="mdl_placeholder_content"><?php _e('21', 'revslider');?></div></div>
								<div data-val="{{current_page_link}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">bookmark</i><?php _e("Link to current page", 'revslider');?></div><div class="mdl_right_content">{{current_page_link}}</div><div class="mdl_placeholder_content"><?php _e('http://yoursite.com/page', 'revslider');?></div></div>
								<div data-val="{{home_url}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">bookmark</i><?php _e("Link to WP Home Page", 'revslider');?></div><div class="mdl_right_content">{{home_url}}</div><div class="mdl_placeholder_content"><?php _e('http://yoursite.com/home', 'revslider');?></div></div>
							</div>
						</div>

						<div id="mdl_group_post" class="mdl_group_wrap" data-title="<?php _e('Post', 'revslider');?>">
							<!-- POST BASICS META DATAS -->
							<div class="mdl_group">
								<div class="mdl_group_header"><i class="material-icons">description</i><?php _e('Post Basics', 'revslider');?><i class="material-icons accordiondrop">arrow_drop_down</i></div>
								<div data-val="{{id}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">description</i><?php _e("Post ID", 'revslider');?></div><div class="mdl_right_content">{{id}}</div><div class="mdl_placeholder_content"><?php _e('Post ID', 'revslider');?></div></div>
								<div data-val="{{meta:somemegatag}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">description</i><?php _e("Any custom meta tag", 'revslider');?></div><div class="mdl_right_content">{{meta:somemegatag}}</div><div class="mdl_placeholder_content"><?php _e('Custom Meta', 'revslider');?></div></div>
								<div data-val="{{title}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">description</i><?php _e("Post Title", 'revslider');?></div><div class="mdl_right_content">{{title}}</div><div class="mdl_placeholder_content"><?php _e('Title', 'revslider');?></div></div>
								<div data-val="{{excerpt}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">description</i><?php _e("Post Excerpt", 'revslider');?></div><div class="mdl_right_content">{{excerpt}}</div><div class="mdl_placeholder_content"><?php _e('Excerpt ipsum dolor sit amet, consetetur sadipscing elitr sed diam nonumy.', 'revslider');?></div></div>
								<div data-val="{{alias}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">description</i><?php _e("Post Alias", 'revslider');?></div><div class="mdl_right_content">{{alias}}</div><div class="mdl_placeholder_content"><?php _e('Post Alias', 'revslider');?></div></div>
								<div data-val="{{content}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">description</i><?php _e("Post Content", 'revslider');?></div><div class="mdl_right_content">{{content}}</div><div class="mdl_placeholder_content"><?php _e('Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.', 'revslider');?></div></div>
								<div data-val="{{content:words:10}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">description</i><?php _e("Post content limit by words", 'revslider');?></div><div class="mdl_right_content">{{content:words:10}}</div><div class="mdl_placeholder_content"><?php _e('Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.', 'revslider');?></div></div>
								<div data-val="{{content:chars:10}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">description</i><?php _e("Post content limit by chars", 'revslider');?></div><div class="mdl_right_content">{{content:chars:10}}</div><div class="mdl_placeholder_content"><?php _e('Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.', 'revslider');?></div></div>
							</div>

							<!-- POST DETAILS META DATAS -->
							<div class="mdl_group">
								<div class="mdl_group_header"><i class="material-icons">info</i><?php _e('Post Details', 'revslider');?><i class="material-icons accordiondrop">arrow_drop_down</i></div>
								<div data-val="{{link}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">info</i><?php _e("The link to the post", 'revslider');?></div><div class="mdl_right_content">{{link}}</div><div class="mdl_placeholder_content"><?php _e('http://yoursite.com/post', 'revslider');?></div></div>
								<div data-val="{{date}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">info</i><?php _e("Date created", 'revslider');?></div><div class="mdl_right_content">{{date}}</div><div class="mdl_placeholder_content"><?php _e('05.03.2018', 'revslider');?></div></div>
								<div data-val="{{date_modified}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">info</i><?php _e("Date modified", 'revslider');?></div><div class="mdl_right_content">{{date_modified}}</div><div class="mdl_placeholder_content"><?php _e('04.03.2018', 'revslider');?></div></div>
								<div data-val="{{author_name}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">info</i><?php _e("Author name", 'revslider');?></div><div class="mdl_right_content">{{author_name}}</div><div class="mdl_placeholder_content"><?php _e('John Doe', 'revslider');?></div></div>
								<div data-val="{{author_avatar:80px}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">info</i><?php _e("Author Avatar URL(size in px)", 'revslider');?></div><div class="mdl_right_content">{{author_avatar:80px}}</div><div class="mdl_placeholder_content"><?php _e('http://yoursite/media/avatar.jpg', 'revslider');?></div></div>
								<div data-val="{{author_website}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">info</i><?php _e("Author Website", 'revslider');?></div><div class="mdl_right_content">{{author_website}}</div><div class="mdl_placeholder_content"><?php _e('http://yoursite/user/page', 'revslider');?></div></div>
								<div data-val="{{author_posts}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">info</i><?php _e("Author Posts Page", 'revslider');?></div><div class="mdl_right_content">{{author_posts}}</div><div class="mdl_placeholder_content"><?php _e('http://yoursite/user/post', 'revslider');?></div></div>
							</div>

							<!-- POST DETAILS II META DATAS -->
							<div class="mdl_group">
								<div class="mdl_group_header"><i class="material-icons">category</i><?php _e('Post Categories, Tags and Comments', 'revslider');?><i class="material-icons accordiondrop">arrow_drop_down</i></div>
								<div data-val="{{num_comments}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">category</i><?php _e("Number of comments", 'revslider');?></div><div class="mdl_right_content">{{num_comments}}</div><div class="mdl_placeholder_content"><?php _e('20', 'revslider');?></div></div>
								<div data-val="{{catlist}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">category</i><?php _e("List of categories with links", 'revslider');?></div><div class="mdl_right_content">{{catlist}}</div><div class="mdl_placeholder_content"><?php _e('Category1, Category2, Category3', 'revslider');?></div></div>
								<div data-val="{{catlist_raw}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">category</i><?php _e("List of categories without links", 'revslider');?></div><div class="mdl_right_content">{{catlist_raw}}</div><div class="mdl_placeholder_content"><?php _e('Category1, Category2, Category3', 'revslider');?></div></div>
								<div data-val="{{taglist}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">category</i><?php _e("List of tags with links", 'revslider');?></div><div class="mdl_right_content">{{taglist}}</div><div class="mdl_placeholder_content"><?php _e('Tag1, Tag2, Tag3', 'revslider');?></div></div>
							</div>
						</div>

						<div id="mdl_group_wc" class="mdl_group_wrap" data-title="<?php _e('WooCommerce', 'revslider');?>">
							<!-- WOOCOMMERCE -->
							<div class="mdl_group">
								<div class="mdl_group_header"><i class="material-icons">shopping_cart</i><?php _e('WooCommerce Basics', 'revslider');?><i class="material-icons accordiondrop">arrow_drop_down</i></div>
								<div data-val="{{wc_categories}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">category</i><?php _e("Categories", 'revslider');?></div><div class="mdl_right_content">{{wc_categories}}</div><div class="mdl_placeholder_content"><?php _e('WC Category1, WC Category2', 'revslider');?></div></div>
								<div data-val="{{wc_tags}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">category</i><?php _e("Tags", 'revslider');?></div><div class="mdl_right_content">{{wc_tags}}</div><div class="mdl_placeholder_content"><?php _e('WC Tag 1, WC Tag 2, WC Tag 3', 'revslider');?></div></div>
								<div data-val="{{wc_add_to_cart}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">category</i><?php _e("Add to Cart URL", 'revslider');?></div><div class="mdl_right_content">{{wc_add_to_cart}}</div><div class="mdl_placeholder_content"><?php _e('http://yoursite.com/addtocart.php', 'revslider');?></div></div>
								<div data-val="{{wc_add_to_cart_button}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">category</i><?php _e("Add to Cart Button", 'revslider');?></div><div class="mdl_right_content">{{wc_add_to_cart_button}}</div><div class="mdl_placeholder_content"><?php _e('Add To Cart', 'revslider');?></div></div>
							</div>
							<div class="mdl_group">
								<div class="mdl_group_header"><i class="material-icons">shopping_cart</i><?php _e('WooCommerce Prices', 'revslider');?><i class="material-icons accordiondrop">arrow_drop_down</i></div>
								<div data-val="{{wc_full_price}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">attach_money</i><?php _e("Full Price", 'revslider');?></div><div class="mdl_right_content">{{wc_full_price}}</div><div class="mdl_placeholder_content"><?php _e('$9.99', 'revslider');?></div></div>
								<div data-val="{{wc_price}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">attach_money</i><?php _e("Single Price", 'revslider');?></div><div class="mdl_right_content">{{wc_price}}</div><div class="mdl_placeholder_content"><?php _e('$9.99', 'revslider');?></div></div>
								<div data-val="{{wc_price_no_cur}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">attach_money</i><?php _e("Single Price without currency", 'revslider');?></div><div class="mdl_right_content">{{wc_price_no_cur}}</div><div class="mdl_placeholder_content"><?php _e('9.99', 'revslider');?></div></div>
							</div>
							<div class="mdl_group">
								<div class="mdl_group_header"><i class="material-icons">shopping_cart</i><?php _e('WooCommerce Stock', 'revslider');?><i class="material-icons accordiondrop">arrow_drop_down</i></div>
								<div data-val="{{wc_sku}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">dashboard</i><?php _e("SKU", 'revslider');?></div><div class="mdl_right_content">{{wc_sku}}</div><div class="mdl_placeholder_content"><?php _e('457819', 'revslider');?></div></div>
								<div data-val="{{wc_stock}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">dashboard</i><?php _e("In Stock", 'revslider');?></div><div class="mdl_right_content">{{wc_stock}}</div><div class="mdl_placeholder_content"><?php _e('5', 'revslider');?></div></div>
								<div data-val="{{wc_stock_quantity}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">dashboard</i><?php _e("Stock Quantity", 'revslider');?></div><div class="mdl_right_content">{{wc_stock_quantity}}</div><div class="mdl_placeholder_content"><?php _e('5', 'revslider');?></div></div>
							</div>
							<div class="mdl_group">
								<div class="mdl_group_header"><i class="material-icons">shopping_cart</i><?php _e('WooCommerce Ratings', 'revslider');?><i class="material-icons accordiondrop">arrow_drop_down</i></div>
								<div data-val="{{wc_rating_count}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">star_half</i><?php _e("Number of Ratings", 'revslider');?></div><div class="mdl_right_content">{{wc_rating_count}}</div><div class="mdl_placeholder_content"><?php _e('47', 'revslider');?></div></div>
								<div data-val="{{wc_review_count}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">star_half</i><?php _e("Number of Reviews", 'revslider');?></div><div class="mdl_right_content">{{wc_review_count}}</div><div class="mdl_placeholder_content"><?php _e('13', 'revslider');?></div></div>
								<div data-val="{{wc_rating}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">star_half</i><?php _e("Text Rating", 'revslider');?></div><div class="mdl_right_content">{{wc_rating}}</div><div class="mdl_placeholder_content"><?php _e('9', 'revslider');?></div></div>
								<div data-val="{{wc_star_rating}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">star_half</i><?php _e("Star Rating", 'revslider');?></div><div class="mdl_right_content">{{wc_star_rating}}</div><div class="mdl_placeholder_content"><?php _e('38', 'revslider');?></div></div>
							</div>
						</div>

						<div id="mdl_group_events" class="mdl_group_wrap" data-title="<?php _e('Events', 'revslider');?>">
							<!-- EVENTS -->
							<div class="mdl_group">
								<div class="mdl_group_header"><i class="material-icons">event</i><?php _e('Event Basics', 'revslider');?><i class="material-icons accordiondrop">arrow_drop_down</i></div>
								<div data-val="{{event_start_date}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">event</i><?php _e("Event start date", 'revslider');?></div><div class="mdl_right_content">{{event_start_date}}</div><div class="mdl_placeholder_content"><?php _e('14.09.2019', 'revslider');?></div></div>
								<div data-val="{{event_end_date}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">event</i><?php _e("Event end date", 'revslider');?></div><div class="mdl_right_content">{{event_end_date}}</div><div class="mdl_placeholder_content"><?php _e('17.09.2019', 'revslider');?></div></div>
								<div data-val="{{event_start_time}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">event</i><?php _e("Event start time", 'revslider');?></div><div class="mdl_right_content">{{event_start_time}}</div><div class="mdl_placeholder_content"><?php _e('21:00', 'revslider');?></div></div>
								<div data-val="{{event_end_time}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">event</i><?php _e("Event end time", 'revslider');?></div><div class="mdl_right_content">{{event_end_time}}</div><div class="mdl_placeholder_content"><?php _e('14:00', 'revslider');?></div></div>
								<div data-val="{{event_id}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">event</i><?php _e("Event ID", 'revslider');?></div><div class="mdl_right_content">{{event_id}}</div><div class="mdl_placeholder_content"><?php _e('EQH-1879', 'revslider');?></div></div>
							</div>
							<div class="mdl_group">
								<div class="mdl_group_header"><i class="material-icons">my_location</i><?php _e('Event Location', 'revslider');?><i class="material-icons accordiondrop">arrow_drop_down</i></div>
								<div data-val="{{event_location_name}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">location_on</i><?php _e("Event location name", 'revslider');?></div><div class="mdl_right_content">{{event_location_name}}</div><div class="mdl_placeholder_content"><?php _e('Music Hall', 'revslider');?></div></div>
								<div data-val="{{event_location_slug}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">location_on</i><?php _e("Event location slug", 'revslider');?></div><div class="mdl_right_content">{{event_location_slug}}</div><div class="mdl_placeholder_content"><?php _e('Concert', 'revslider');?></div></div>
								<div data-val="{{event_location_address}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">location_on</i><?php _e("Event location address", 'revslider');?></div><div class="mdl_right_content">{{event_location_address}}</div><div class="mdl_placeholder_content"><?php _e('East 32th Street between Park & Lexington Avn ', 'revslider');?></div></div>
								<div data-val="{{event_location_town}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">location_on</i><?php _e("Event location town", 'revslider');?></div><div class="mdl_right_content">{{event_location_town}}</div><div class="mdl_placeholder_content"><?php _e('Los Angeles', 'revslider');?></div></div>
								<div data-val="{{event_location_state}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">location_on</i><?php _e("Event location state", 'revslider');?></div><div class="mdl_right_content">{{event_location_state}}</div><div class="mdl_placeholder_content"><?php _e('US', 'revslider');?></div></div>
								<div data-val="{{event_location_postcode}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">location_on</i><?php _e("Event location postcode", 'revslider');?></div><div class="mdl_right_content">{{event_location_postcode}}</div><div class="mdl_placeholder_content"><?php _e('EX 87 TNT', 'revslider');?></div></div>
								<div data-val="{{event_location_region}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">location_on</i><?php _e("Event location region", 'revslider');?></div><div class="mdl_right_content">{{event_location_region}}</div><div class="mdl_placeholder_content"><?php _e('Orange Country', 'revslider');?></div></div>
								<div data-val="{{event_location_country}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">location_on</i><?php _e("Event location country", 'revslider');?></div><div class="mdl_right_content">{{event_location_country}}</div><div class="mdl_placeholder_content"><?php _e('USA', 'revslider');?></div></div>
							</div>
						</div>

						<div id="mdl_group_social" class="mdl_group_wrap" data-title="<?php _e('Social', 'revslider');?>">
							<!-- FLICKR -->
							<div class="mdl_group">
								<div class="mdl_group_header"><i class="material-icons">public</i><?php _e('Social Basics (Flickr, Instagram, Twitter, Facebook, YouTube)', 'revslider');?><i class="material-icons accordiondrop">arrow_drop_down</i></div>
								<div data-val="{{title}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">public</i><?php _e("Post Title", 'revslider');?></div><div class="mdl_right_content">{{title}}</div><div class="mdl_placeholder_content"><?php _e('Title', 'revslider');?></div></div>
								<div data-val="{{content}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">public</i><?php _e("Post content", 'revslider');?></div><div class="mdl_right_content">{{content}}</div><div class="mdl_placeholder_content"><?php _e('Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.', 'revslider');?></div></div>
								<div data-val="{{content:words:10}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">public</i><?php _e("Post content limit by words", 'revslider');?>	</div><div class="mdl_right_content">{{content:words:10}}</div><div class="mdl_placeholder_content"><?php _e('Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.', 'revslider');?></div></div>
								<div data-val="{{content:chars:10}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">public</i><?php _e("Post content limit by chars", 'revslider');?>	</div><div class="mdl_right_content">{{content:chars:10}}</div><div class="mdl_placeholder_content"><?php _e('Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.', 'revslider');?></div></div>
								<div data-val="{{link}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">public</i><?php _e("The link to the post", 'revslider');?></div><div class="mdl_right_content">{{link}}</div><div class="mdl_placeholder_content"><?php _e('http://yoursite.com/post', 'revslider');?></div></div>
								<div data-val="{{date}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">public</i><?php _e("Date created", 'revslider');?></div><div class="mdl_right_content">{{date}}</div><div class="mdl_placeholder_content"><?php _e('08.03.2018', 'revslider');?></div></div>
								<div data-val="{{author_name}}" class="mdl_group_member"><div class="mdl_left_content"><i class="material-icons">public</i><?php _e("Username", 'revslider');?></div><div class="mdl_right_content">{{author_name}}</div><div class="mdl_placeholder_content"><?php _e('John Doe', 'revslider');?></div></div>
							</div>

							<!-- FLICKR -->
							<div class="mdl_group">
								<div class="mdl_group_header"><i class="fa__icons fa-flickr"></i><?php _e('Flickr Extras', 'revslider');?><i class="material-icons accordiondrop">arrow_drop_down</i></div>
								<div data-val="{{date}}" class="mdl_group_member"><div class="mdl_left_content"><i class="fa__icons fa-flickr"></i><?php _e("Date created", 'revslider');?></div><div class="mdl_right_content">{{date}}</div><div class="mdl_placeholder_content"><?php _e('08.03.2018', 'revslider');?></div></div>
								<div data-val="{{views}}" class="mdl_group_member"><div class="mdl_left_content"><i class="fa__icons fa-flickr"></i><?php _e("Views", 'revslider');?></div><div class="mdl_right_content">{{views}}</div><div class="mdl_placeholder_content"><?php _e('24', 'revslider');?></div></div>
							</div>

							<!-- INSTAGRAM -->
							<!--
							<div class="mdl_group">
								<div class="mdl_group_header"><i class="fa__icons fa-instagram"></i><?php _e('Instagram Extras', 'revslider');?><i class="material-icons accordiondrop">arrow_drop_down</i></div>
								<div data-val="{{date}}" class="mdl_group_member"><div class="mdl_left_content"><i class="fa__icons fa-instagram"></i><?php _e("Date created", 'revslider');?></div><div class="mdl_right_content">{{date}}</div><div class="mdl_placeholder_content"><?php _e('08.03.2018', 'revslider');?></div></div>
								<div data-val="{{likes}}" class="mdl_group_member"><div class="mdl_left_content"><i class="fa__icons fa-instagram"></i><?php _e("Number of Likes", 'revslider');?></div><div class="mdl_right_content">{{likes}}</div><div class="mdl_placeholder_content"><?php _e('12', 'revslider');?></div></div>
								<div data-val="{{num_comments}}" class="mdl_group_member"><div class="mdl_left_content"><i class="fa__icons fa-instagram"></i><?php _e("Number of Comments", 'revslider');?></div><div class="mdl_right_content">{{num_comments}}</div><div class="mdl_placeholder_content"><?php _e('19', 'revslider');?></div></div>
							</div>
							-->

							<!-- TWITTER -->
							<div class="mdl_group">
								<div class="mdl_group_header"><i class="fa__icons fa-twitter"></i><?php _e('Twitter Extras', 'revslider');?><i class="material-icons accordiondrop">arrow_drop_down</i></div>
								<div data-val="{{date_published}}" class="mdl_group_member"><div class="mdl_left_content"><i class="fa__icons fa-twitter"></i><?php _e("Date Published", 'revslider');?></div><div class="mdl_right_content">{{date_published}}</div><div class="mdl_placeholder_content"><?php _e('08.03.2018', 'revslider');?></div></div>
								<div data-val="{{retweet_count}}" class="mdl_group_member"><div class="mdl_left_content"><i class="fa__icons fa-twitter"></i><?php _e("Retweet Count", 'revslider');?></div><div class="mdl_right_content">{{retweet_count}}</div><div class="mdl_placeholder_content"><?php _e('19824', 'revslider');?></div></div>
								<div data-val="{{favorite_count}}" class="mdl_group_member"><div class="mdl_left_content"><i class="fa__icons fa-twitter"></i><?php _e("Favorite Count", 'revslider');?></div><div class="mdl_right_content">{{favorite_count}}</div><div class="mdl_placeholder_content"><?php _e('1249', 'revslider');?></div></div>
							</div>

							<!-- FACEBOOK -->
							<div class="mdl_group">
								<div class="mdl_group_header"><i class="fa__icons fa-facebook"></i><?php _e('Facebook Extras', 'revslider');?><i class="material-icons accordiondrop">arrow_drop_down</i></div>
								<div data-val="{{date_published}}" class="mdl_group_member"><div class="mdl_left_content"><i class="fa__icons fa-facebook"></i><?php _e("Date Published", 'revslider');?></div><div class="mdl_right_content">{{date_published}}</div><div class="mdl_placeholder_content"><?php _e('08.03.2018', 'revslider');?></div></div>
								<div data-val="{{date_modified}}" class="mdl_group_member"><div class="mdl_left_content"><i class="fa__icons fa-facebook"></i><?php _e("Date Modified", 'revslider');?></div><div class="mdl_right_content">{{date_modified}}</div><div class="mdl_placeholder_content"><?php _e('18.08.2018', 'revslider');?></div></div>
								<div data-val="{{likes}}" class="mdl_group_member"><div class="mdl_left_content"><i class="fa__icons fa-facebook"></i><?php _e("Number of Likes", 'revslider');?></div><div class="mdl_right_content">{{likes}}</div><div class="mdl_placeholder_content"><?php _e('212', 'revslider');?></div></div>
							</div>

							<!-- YOUTUBE -->
							<div class="mdl_group">
								<div class="mdl_group_header"><i class="fa__icons fa-youtube-square"></i><?php _e('YouTube Extras', 'revslider');?><i class="material-icons accordiondrop">arrow_drop_down</i></div>
								<div data-val="{{excerpt}}" class="mdl_group_member"><div class="mdl_left_content"><i class="fa__icons fa-youtube-square"></i><?php _e("Excerpt", 'revslider');?></div><div class="mdl_right_content">{{excerpt}}</div><div class="mdl_placeholder_content"><?php _e('Excerpt ipsum dolor sit amet, consetetur sadipscing elitr sed diam nonumy.', 'revslider');?></div></div>
								<div data-val="{{date_published}}" class="mdl_group_member"><div class="mdl_left_content"><i class="fa__icons fa-youtube-square"></i><?php _e("Date Published", 'revslider');?></div><div class="mdl_right_content">{{date_published}}</div><div class="mdl_placeholder_content"><?php _e('08.03.2018', 'revslider');?></div></div>
							</div>

							<!-- VIMEO -->
							<div class="mdl_group">
								<div class="mdl_group_header"><i class="fa__icons fa-vimeo-square"></i><?php _e('Vimeo Extras', 'revslider');?><i class="material-icons accordiondrop">arrow_drop_down</i></div>
								<div data-val="{{date_published}}" class="mdl_group_member"><div class="mdl_left_content"><i class="fa__icons fa-vimeo-square"></i><?php _e("Date Published", 'revslider');?></div><div class="mdl_right_content">{{date_published}}</div><div class="mdl_placeholder_content"><?php _e('08.03.2018', 'revslider');?></div></div>
								<div data-val="{{likes}}" class="mdl_group_member"><div class="mdl_left_content"><i class="fa__icons fa-vimeo-square"></i><?php _e("Number of Likes", 'revslider');?></div><div class="mdl_right_content">{{likes}}</div><div class="mdl_placeholder_content"><?php _e('321', 'revslider');?></div></div>
								<div data-val="{{views}}" class="mdl_group_member"><div class="mdl_left_content"><i class="fa__icons fa-vimeo-square"></i><?php _e("Number of Views", 'revslider');?></div><div class="mdl_right_content">{{views}}</div><div class="mdl_placeholder_content"><?php _e('1786', 'revslider');?></div></div>
								<div data-val="{{num_comments}}" class="mdl_group_member"><div class="mdl_left_content"><i class="fa__icons fa-vimeo-square"></i><?php _e("Number of Comments", 'revslider');?></div><div class="mdl_right_content">{{num_comments}}</div><div class="mdl_placeholder_content"><?php _e('124', 'revslider');?></div></div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--LAYER ACTION MODAL-->
<div class="_TPRB_ rb-modal-wrapper" data-modal="rbm_layer_action">
	<div class="rb-modal-inner">
		<div class="rb-modal-content">
			<div id="rbm_layer_action" class="rb_modal form_inner">
				<div class="rbm_header"><i class="rbm_symbol material-icons">touch_app</i><span class="rbm_title"><?php _e('Actions', 'revslider');?></span><i class="rbm_close material-icons">close</i></div>
				<div class="rbm_content">
					<!-- THE LEFT SIDE OF THE AWESOME MODAL WINDOW -->
					<div class="rbm_content_left">

						<div id="layeractions_overview">
							<div id="layeractions_overview_innerwrap">
								<!-- LAYER AND ITS DEPENDENCIES -->
								<div id="layer_with_action_wrap">
									<div id="layer_with_action"></div>
									<div id="layer_width_action_inner_wrap">
										<ul id="layer_depending_wrap" class="layer_depending_wrap"></ul>
										<div id="layer_depending_frames"></div>													
										<label_a style="width:175px"><?php _e('Trigger Memory', 'revslider');?></label_a><select data-r="actions.triggerMemory" class="easyinit layerinput nosearchbox tos2"><option value="reset"><?php _e('Reset before each Loop', 'revslider');?></option><option value="keep"><?php _e('Keep Last State', 'revslider');?></option></select>
									</div>
								</div>
								<!-- ACTIONS TRIGGERED BY THE LAYER -->
								<ul id="selected_layer_actions"></ul>
							</div>
							<div id="addactiontolayer" class="rbm_darkbutton"><i class="material-icons">add_circle_outline</i><?php _e('Add Action to ', 'revslider');?> &quot;<span id="add_action_to_layername"></span>&quot;</span></div>
						</div>

					</div>
					<!-- THE RIGHT SIDE OF THE AWESOME MODAL WINDOW -->
					<div class="rbm_content_right">
						<div id="no_action_selected"><i class="material-icons">info</i><?php _e('No Action Selected', 'revslider');?></div>

						<!-- THE LIST OF THE ACTIONS -->
						<div id="layeraction_list"></div>

						<!-- INPUT FIELD LIST OF THE SELECTED ACTION -->
						<div id="action_inputs">
							<div id="action_interaction_wrap">
								<select style="display:none !important" id="action_interaction" data-unselect=".layer_action_interaction_selector" data-select="#action_interaction*val*" class="easyinit" data-r="actions.action.#actionindex#.tooltip_event"><option value="click"><?php _e('Click', 'revslider');?></option><option value="mouseenter"><?php _e('Mouse Enter', 'revslider');?></option><option value="mouseleave"><?php _e('Mouse Leave', 'revslider');?></option></select>
								<label_a><?php _e('Interaction', 'revslider');?></label_a><select id="action_interaction" class="easyinit actioninput tos2 nosearchbox" data-r="actions.action.#actionindex#.tooltip_event"><option value="click"><?php _e('Click', 'revslider');?></option><option value="mouseenter"><?php _e('Mouse Enter', 'revslider');?></option><option value="mouseleave"><?php _e('Mouse Leave', 'revslider');?></option></select>				
							</div>
							<!--<label_icon class="triggerselect layer_action_interaction_selector twostatetrigger material-icons selected mirrorhorizontal" data-select="#action_interaction" data-val="click" id="action_interaction_click">near_me</label_icon>
							<label_icon class="triggerselect layer_action_interaction_selector twostatetrigger material-icons" data-select="#action_interaction" data-val="mouseenter" id="action_interaction_mouseenter">file_download</label_icon>
							<label_icon class="triggerselect layer_action_interaction_selector twostatetrigger material-icons" data-select="#action_interaction" data-val="mouseleave" id="action_interaction_mouseleave">file_upload</label_icon>-->
							<!-- TYPE OF ACTION -->
							<label_a><?php _e('Action Type', 'revslider');?></label_a><div class="input_presets_wrap" id="layer_action_type"><div id="layer_action_fake"></div><input type="text" readonly  class="easyinit actioninput" data-r="actions.action.#actionindex#.action" value=""><i class="material-icons input_presets_dropdown">more_vert</i></div>
							
							<div class="div20"></div>

							<!-- SIMPLE LINK SETTINGS -->
							<div id="la_settings_link_menu" class="la_settings" style="margin-bottom:20px !important">
								<label_a><?php _e('Link to URL', 'revslider');?></label_a><input type="text" class="easyinit actioninput" id="la_menu_link" data-r="actions.action.#actionindex#.menu_link" placeholder="<?php _e('Enter Link', 'revslider');?>" ><span class="linebreak"></span>
								<label_a><?php _e('Anchor #id at URL', 'revslider');?></label_a><input type="text" class="easyinit actioninput" id="la_menu_link" data-r="actions.action.#actionindex#.menu_anchor" placeholder="<?php _e('Enter Anchor ID', 'revslider');?>" ><span class="linebreak"></span>
							</div>
							
							<!-- SIMPLE LINK SETTINGS -->
							<div id="la_settings_link_url" class="la_settings">
								<label_a><?php _e('Link URL', 'revslider');?></label_a><input type="text" class="easyinit actioninput" id="la_image_link" data-r="actions.action.#actionindex#.image_link" placeholder="<?php _e('Enter Link', 'revslider');?>" ><span class="linebreak"></span>
							</div>
							<div id="la_settings_link" class="la_settings">
								<label_a><?php _e('Protocol', 'revslider');?></label_a><select id="la_link_help_in" data-r="actions.action.#actionindex#.link_help_in" class="easyinit actioninput nosearchbox tos2"><option value="http"><?php _e('http://', 'revslider');?></option><option value="https"><?php _e('https://', 'revslider');?></option><option value="auto"><?php _e('Auto http / https', 'revslider');?></option><option value="keep"><?php _e('Keep as it is', 'revslider');?></option></select>
								<label_a><?php _e('Target', 'revslider');?></label_a><select id="la_link_open_in" data-r="actions.action.#actionindex#.link_open_in" class="easyinit actioninput nosearchbox tos2"><option value="_self"><?php _e('Same Window', 'revslider');?></option><option value="_blank"><?php _e('New Window', 'revslider');?></option></select>
								<label_a><?php _e('Follow', 'revslider');?></label_a><select id="la_link_follow" data-r="actions.action.#actionindex#.link_follow" class="easyinit actioninput nosearchbox tos2"><option value="follow"><?php _e('Follow Link', 'revslider');?></option><option value="nofollow"><?php _e('No Follow', 'revslider');?></option></select>
								<span class="linebreak"></span>
							</div>
							<div id="la_settings_link_type" class="la_settings">
								<label_a><?php _e('Type', 'revslider');?></label_a><select id="la_link_type" data-r="actions.action.#actionindex#.link_type" class="easyinit actioninput nosearchbox tos2"></select>								
								<span class="linebreak"></span>
							</div>

							<div id="la_settings_modal" class="la_settings">
								<label_a><?php _e('Open Modal', 'revslider');?></label_a><select id="la_open_modal" data-r="actions.action.#actionindex#.openmodal" data-evt="refreshSlideLists" class="selectsliderlist easyinit actioninput searchbox tos2"></select>
								<label_a><?php _e('Open Slide', 'revslider');?></label_a><select id="la_open_modalslide" data-r="actions.action.#actionindex#.modalslide" class="selectsliderlist easyinit actioninput searchbox tos2"></select>					
							</div>

							<!-- CALL BACK SETTINGS -->
							<div id="la_settings_callback" class="la_settings">
								<label_a><?php _e('Function', 'revslider');?></label_a><input class="easyinit actioninput" type="text" id="la_actioncallback" data-r="actions.action.#actionindex#.actioncallback" placeholder="<?php _e('javaScript Function', 'revslider');?>" ><span class="linebreak"></span>
								<span class="linebreak"></span>
							</div>

							<!-- SCROLL TO ID -->
							<div id="la_settings_scroll_to" class="la_settings">
								<label_a><?php _e('Scroll to ID', 'revslider');?></label_a><input class="easyinit actioninput" type="text" id="la_scrolltoid" data-r="actions.action.#actionindex#.scrollto_id" placeholder="<?php _e('ID of Element', 'revslider');?>" ><span class="linebreak"></span>					
								<span class="linebreak"></span>
							</div>							

							<!-- SCROLL BELOW SETTINGS -->
							<div id="la_settings_scroll_under" class="la_settings">
								<label_a><?php _e('Scroll Offset', 'revslider');?></label_a><input class="easyinit actioninput" type="text" id="la_scrollunder_offset" data-numeric="true" data-allowed="px,%" data-r="actions.action.#actionindex#.scrollunder_offset" placeholder="<?php _e('Offset to Scroll Position', 'revslider');?>" ><span class="linebreak"></span>
								<label_a><?php _e('Animation Ease', 'revslider');?></label_a><select id="la_action_easing" class="easyinit actioninput tos2 nosearchbox easingSelect" data-r="actions.action.#actionindex#.action_easing"></select>
								<label_a><?php _e('Animation Duration', 'revslider');?></label_a><input class="easyinit actioninput" type="text" id="la_saction_speed" data-numeric="true" data-allowed="ms" data-r="actions.action.#actionindex#.action_speed" placeholder="<?php _e('Animation Duration in ms', 'revslider');?>" ><span class="linebreak"></span>
								<span class="linebreak"></span>
							</div>

							<!-- JUMP TO SLIDE -->
							<div id="la_settings_jumpto" class="la_settings">
								<label_a><?php _e('Jump to Slide', 'revslider');?></label_a><select id="la_jump_to_slide" data-r="actions.action.#actionindex#.jump_to_slide" class="easyinit actioninput nosearchbox tos2"></select>
								<span class="linebreak"></span>
							</div>

							<!-- SCROLL BELOW SETTINGS -->
							<div id="la_settings_getAccelerationPermissionk" class="la_settings">								
								<span class="linebreak"></span>
							</div>

							<!-- LAYER TARGET -->
							<div id="la_settings_layertarget" class="la_settings">
								<label_a><?php _e('Target Layer', 'revslider');?></label_a><select id="la_layer_target" data-evt="refreshActionView" data-theme="layer_selector_drop_down" data-r="actions.action.#actionindex#.layer_target" class="easyinit actioninput nosearchbox tos2"></select>					
							</div>
							

							<!-- LAYER TOGGLE -->
							<div id="la_settings_layer_toggle_actions" class="la_settings">
								<label_a><?php _e('Toggle Start State', 'revslider');?></label_a><select id="toggle_layer_type" data-evt="refreshLayerToggleState" data-theme="layer_selector_drop_down" data-r="actions.action.#actionindex#.toggle_layer_type" class="easyinit actioninput nosearchbox tos2"><option value="visible"><?php _e('Toggled (Visible)', 'revslider');?></option><option value="hidden"><?php _e('Untoggled (Hidden)', 'revslider');?></option></select>
							</div>

							<!-- LAYER ANIMATION IN/OUT -->
							<div id="la_settings_layer_actions_in" class="la_settings">
								<label_a><?php _e('Frame wait\'s on Action', 'revslider');?></label_a><input id="overtake_frame_1_control" type="checkbox" class="targetlayeractioninput" data-r="timeline.frames.frame_1.timeline.actionTriggered"><span class="linebreak"></span>					
							</div>
							
							<!-- LAYER ANIMATION IN/OUT -->
							<div id="la_settings_layer_actions_out" class="la_settings">
								<label_a><?php _e('Frame wait\'s on Action', 'revslider');?></label_a><input type="checkbox" id="overtake_frame_999_control" class="targetlayeractioninput" data-r="timeline.frames.frame_999.timeline.actionTriggered"><span class="linebreak"></span>	
							</div>

							<!-- LAYER ANIMATION FRAME -->
							<div id="la_settings_layer_actions_frame" class="la_settings">
								<label_a><?php _e('GoTo Frame', 'revslider');?></label_a><select id="la_gotoframeX"  data-evt="updatePlayFrameXOnlyOnAction" data-evtparam="X" data-r="actions.action.#actionindex#.gotoframe" class="callEvent easyinit actioninput nosearchbox tos2"></select>
								<span class="linebreak"></span>
								<label_a><?php _e('Frame wait\'s on Action', 'revslider');?></label_a><input type="checkbox" id="overtake_frameX_control" class="targetlayeractioninput " data-r="timeline.frames.frame_2.timeline.actionTriggered"><span class="linebreak"></span>					
							</div>

							<!-- LAYER ANIMATION FRAME -->
							<div id="la_settings_layer_actions_frameXY" class="la_settings">
								<div class="div20"></div>
								<label_a><?php _e('Frame N', 'revslider');?></label_a><select id="la_gotoframeN"  data-evt="updatePlayFrameXOnlyOnAction" data-evtparam="N" data-r="actions.action.#actionindex#.gotoframeN" class="callEvent easyinit actioninput nosearchbox tos2"></select>
								<label_a><?php _e('Frame M', 'revslider');?></label_a><select id="la_gotoframeM"  data-evt="updatePlayFrameXOnlyOnAction" data-evtparam="M" data-r="actions.action.#actionindex#.gotoframeM" class="callEvent easyinit actioninput nosearchbox tos2"></select>
								<span class="linebreak"></span>
								<label_a><?php _e('"N" wait\'s on Action', 'revslider');?></label_a><input type="checkbox" id="overtake_frameN_control" class="targetlayeractioninput " data-r="timeline.frames.frame_88.timeline.actionTriggered"><span class="linebreak"></span>					
								<label_a><?php _e('"M" wait\'s on Action', 'revslider');?></label_a><input type="checkbox" id="overtake_frameM_control" class="targetlayeractioninput " data-r="timeline.frames.frame_77.timeline.actionTriggered"><span class="linebreak"></span>					
								<div class="div20"></div>
							</div>

							<!-- LAYER CHILDREN TIMELINE RESET IF NEEDED -->
							<div id="la_settings_childrentimelines" class="la_settings">
								<label_a><?php _e('Reset Children Timelines', 'revslider');?></label_a><input id="update_children_timelines" type="checkbox" class="easyinit actioninput" data-r="actions.action.#actionindex#.updateChildren">
							</div>

							<!-- LAYER ANIMATION IN/OUT -->
							<div id="la_settings_layer_actions" class="la_settings">
								<label_a><?php _e('After Action', 'revslider');?></label_a><select id="la_triggerMemory" data-r="actions.triggerMemory" class="targetlayeractioninput nosearchbox tos2"><option value="reset"><?php _e('Reset before each Loop', 'revslider');?></option><option value="keep"><?php _e('Keep Last State', 'revslider');?></option></select>
								<span class="linebreak"></span>
							</div>

							<!-- LAYER TARGET CLASS-->
							<div id="la_settings_class" class="la_settings">
								<label_a><?php _e('Class to Toggle', 'revslider');?></label_a><input class="easyinit actioninput" type="text" id="la_toggle_class" data-r="actions.action.#actionindex#.toggle_class" placeholder="<?php _e('class Name to Toggle', 'revslider');?>" ><span class="linebreak"></span>
							</div>

							<!-- ACTION EXTENSIONS -->
							<div id="layer_action_extension_wrap"></div>

							<!-- DELAY -->
							<div id="laction_delay"><label_a><?php _e('Action Delay', 'revslider');?></label_a><input class="easyinit actioninput" data-numeric="true" data-allowed="ms" type="text" id="layer_action_delay" data-r="actions.action.#actionindex#.action_delay" placeholder="0"></div>

							<!-- REPEAT DELAY -->
							<div id="lraction_delay"><label_a><?php _e('Trigger Repeat Delay', 'revslider');?></label_a><input class="easyinit actioninput" data-numeric="true" data-allowed="ms" type="text" id="layer_action_repeat" data-r="actions.action.#actionindex#.action_repeats" placeholder="0"></div>
						</div><!-- END OF INPUT FIELD LIST OF THE SELECTED ACTION -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>