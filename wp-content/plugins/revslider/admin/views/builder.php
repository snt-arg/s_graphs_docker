<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2019 ThemePunch
 */

if(!defined('ABSPATH')) exit();

$rs_data = new RevSliderData();
$rs_f = RevSliderGlobals::instance()->get('RevSliderFunctions');
$slider = new RevSliderSlider();
$slide = new RevSliderSlide();
$rs_nav = new RevSliderNavigation();
$wpml = new RevSliderWpml();
$rs_favorite = RevSliderGlobals::instance()->get('RevSliderFavorite');

$slide_id = RevSliderFunctions::esc_attr_deep($rs_f->get_get_var('id'));
$slide_alias = RevSliderFunctions::esc_attr_deep($rs_f->get_get_var('alias'));

//GoogleFontFamilies
$font_familys = $rs_f->get_font_familys();

$json_font_familys = $rs_f->json_encode_client_side($font_familys);

//get Navigation Styles 
$arr_navigations = $rs_nav->get_all_navigations_builder();

//get Layer Animations
$animationsRaw = $this->get_layer_animations(true);

//get Image Sizes
$img_sizes = $rs_f->get_all_image_sizes();

//get transitions
$rs_base_transitions = $rs_f->get_base_transitions();
$rs_custom_transitions = $rs_f->get_custom_slidetransitions();														  
$rs_favorite_transitions = $rs_favorite->get_favorite('slide_transitions');

require_once(RS_PLUGIN_PATH . 'admin/views/modals-copyright.php');

?>

<div id="wp_overlay"></div>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div id="builderView" class="_TPRB_">

	<!-- REVOLUTION BUILDER TOP LEVEL WRAPPER -->
	<div id="rb_tlw">

		<!-- DISPLAY SIZE SELECTOR (UNVISIBLE SELECTOR; NEED TO EXIST IN DOM-->
		<select id="screenselector" style="display:none;">
			<option value="d"><?php _e('Desktop', 'revslider');?></option>
			<option value="n"><?php _e('Notebook', 'revslider');?></option>
			<option value="t"><?php _e('Tablet', 'revslider');?></option>
			<option value="m"><?php _e('Mobile', 'revslider');?></option>
		</select>

		<?php
		require_once(RS_PLUGIN_PATH . 'admin/views/modals-general.php');
		require_once(RS_PLUGIN_PATH . 'admin/views/builder-slider-forms.php');
		require_once(RS_PLUGIN_PATH . 'admin/views/builder-nav-forms.php');
		require_once(RS_PLUGIN_PATH . 'admin/views/builder-slide-forms.php');
		require_once(RS_PLUGIN_PATH . 'admin/views/builder-layer-forms.php');
		
		require_once(RS_PLUGIN_PATH . 'admin/views/modals-builder.php');
		require_once(RS_PLUGIN_PATH . 'admin/views/modals-copyright.php');
		?>

		<div id="glob_slide_selector_header" style="display:none">
			<div class="gb_st_header">
				<div class="gb_st_header_title"><?php _e('Slides', 'revslider');?></div>
			</div>
		</div>

		<div id="the_container">
			<!--THIS IS THE MAIN LEFT TOOLBAR-->			
			<div id="the_editor">
				<!--- MAIN HORIZONTAL TOOLBAR CONTAINER -->
				<div id="main_hor_toolbar">
					<div id="rb_editor_logo"><span class="ab-icon"></span><div id="rb_the_logo"></div></div><!--
					--><div id="_layer_settings" class="mht_inner">
						<div id="back_to_overview" class="toolbar_btn"><i class="material-icons">view_module</i><span class="toolbar_btn_txt"><?php _e('Back', 'revslider');?></span></div><!--
						--><div id="add_slide_toolbar_wrap" class="toolbar_btn tool_drop"><i class="material-icons">burst_mode</i><span class="toolbar_btn_txt"><?php _e('Slides', 'revslider');?></span>
							<div class="tool_dd_wrap" id="slide_picker_wrap">
								<div class="toolbar_dd_subdrop_wrap">
									<div id="newslide" class="slide_list_element"><div class="sle_description"><i class="material-icons">add</i><?php _e('Add Slide(s)', 'revslider');?></div></div>
									<div class="toolbar_dd_subdrop">
										<div id="add_blank_slide" class="add_slide" data-type="text"><i class="material-icons">crop_square</i><?php _e('Blank slide', 'revslider');?></div>
										<div id="add_bulk_slide" class="add_slide getImageFromMediaLibrary" data-multiple="true" data-evt="addBulkSlides" data-type="text"><i class="material-icons">apps</i><?php _e('Bulk Slide', 'revslider');?></div>
										<div id="add_module_slide" class="add_slide" data-type="text"><i class="material-icons">redo</i><?php _e('Import from Modules', 'revslider');?></div>
										<div id="add_template_slide" class="add_slide" data-type="text"><i class="material-icons">folder</i><?php _e('Import from Template', 'revslider');?></div>
									</div>
								</div>
								<div id="slide_thumb_repeater"></div>
								<ul id="slidelist">
									<div class="tp-clearfix"></div>
								</ul>
							</div>
						</div><!--
						--><div id="add_layer_toolbar_wrap" class="toolbar_btn tool_drop"><i class="material-icons">library_add</i><span class="toolbar_btn_txt"><?php _e('Add Layer', 'revslider');?></span>
							<div class="tool_dd_wrap" id="add_layer_main_wrap">
								<div id="toolbar_add_layer_text" class="toolbar_dd_subdrop_wrap">
									<div class="add_layer" data-type="text"><i class="material-icons">title</i><?php _e('Text', 'revslider');?></div>
									<div class="toolbar_dd_subdrop">
										<div class="add_layer" data-type="text" data-subtype="headline"><i class="material-icons">font_download</i><?php _e('Quick Style Headline', 'revslider');?></div>
										<div class="add_layer" data-type="text" data-subtype="simple_content"><i class="material-icons">title</i><?php _e('Quick Style Content', 'revslider');?></div>
									</div>
								</div>
								<div id="toolbar_add_layer_image" class="toolbar_dd_subdrop_wrap">
									<div class="add_layer" data-type="image"><i class="material-icons">filter_hdr</i><?php _e('Image', 'revslider');?></div>
									<div class="toolbar_dd_subdrop">
										<div class="add_layer" data-type="image" data-subtype="wordpress_library"><i class="material-icons">system_update_alt</i><?php _e('WordPress Library', 'revslider');?></div>
										<div class="add_layer" data-type="image" data-subtype="object_library"><i class="material-icons">style</i><?php _e('Object Library', 'revslider');?></div>
										<div class="add_layer" data-type="image"><i class="material-icons">flip_to_back</i><?php _e('Empty Placeholder', 'revslider');?></div>
									</div>
								</div>
								<div id="toolbar_add_layer_button" class="add_layer" data-type="button" data-subtype="button"><i class="material-icons">radio_button_checked</i><?php _e('Button', 'revslider');?></div>
								<div id="toolbar_add_layer_shape" class="add_layer" data-type="shape"><i class="material-icons">crop_landscape</i><?php _e('Shape', 'revslider');?></div>
								<div id="toolbar_add_layer_video" class="toolbar_dd_subdrop_wrap">
									<div class="add_layer" data-type="video"><i class="material-icons">live_tv</i><?php _e('Video', 'revslider');?></div>
									<div class="toolbar_dd_subdrop">
										<div class="add_layer" data-type="video" data-subtype="wordpress_library"><i class="material-icons">system_update_alt</i><?php _e('WordPress Library', 'revslider');?></div>
										<div class="add_layer" data-type="video" data-subtype="object_library"><i class="material-icons">style</i><?php _e('Object Library', 'revslider');?></div>
										<div class="add_layer" data-type="video"><i class="material-icons">flip_to_back</i><?php _e('Empty Placeholder', 'revslider');?></div>
									</div>
								</div>
								<div id="toolbar_add_layer_audio" class="add_layer" data-type="audio"><i class="material-icons">audiotrack</i><?php _e('Audio', 'revslider');?></div>
								<div id="toolbar_add_layer_object" class="add_layer" data-type="object" data-subtype="object_library"><i class="material-icons">filter_drama</i><?php _e('Icon / SVG', 'revslider');?></div>
								<div id="toolbar_add_layer_row" class="add_layer" data-type="row"><i class="material-icons">reorder</i><?php _e('Row', 'revslider');?></div>
								<div id="toolbar_add_layer_group" class="add_layer" data-type="group"><i class="material-icons">format_shapes</i><?php _e('Group', 'revslider');?></div>
								<div id="add_from_layerlibrary" class="add_layer"><i class="material-icons">library_books</i><?php _e('Layer Library', 'revslider');?></div>
								<div id="import_layers" class="add_layer"><i class="material-icons">redo</i><?php _e('Import Layer', 'revslider');?></div>
							</div>
						</div>
					</div><!--
					--><div class="layertoolbar_wrap mht_inner layer_settings_collector">
						<div id="layer_rescaler"><div id="lresc_path"><div id="lresc_pin"></div></div></div>
						<div id="do_title_layer"><i id="selected_layers_icon_toolbar" class="material-icons do_title_layer_icon">do_not_disturb_alt</i><input data-multiplaceholder="<?php _e('Multiple Selection', 'revslider');?>" data-r="alias" class="easyinit layerinput" id="updateLayerSingleAliasInput" data-evt="updateLayerAliasFromSingleInput" type="text" /></div><!--
						--><div id="do_title_layer_not_selected"><i class="material-icons do_title_layer_icon">do_not_disturb_alt</i><?php _e('No Layers Selected', 'revslider');?></div><!--
						--><div id="duplicate_btn_icon" class="toolbar_btn justicon tool_drop">
							<div class="selected_placeholder"><i class="norightmargin material-icons">content_copy</i></div>
							<div id="duplicate_layer_list" class="tool_dd_wrap outicon_dd_rwap">
								<div id="do_duplicate_layer" class="toolbar_listelement"><i class="material-icons">content_copy</i><?php _e('Duplicate', 'revslider');?><span class="shortcuttext"><span class="shortcut_cmdctrl">ctrl</span>J</span></div>
								<div id="do_copy_layer" class="toolbar_listelement"><i class="material-icons">content_paste</i><?php _e('Copy', 'revslider');?><span class="shortcuttext"><span class="shortcut_cmdctrl">ctrl</span>C</span></div>
								<div id="do_paste_layer" class="toolbar_listelement disabled"><i class="material-icons">file_download</i><?php _e('Paste', 'revslider');?><span class="shortcuttext"><span class="shortcut_cmdctrl">ctrl</span>V</span></div>
							</div>
						</div><!--
						--><div id="do_delete_layer" class="toolbar_btn justicon"><i class="norightmargin material-icons">delete</i></div><!--
						--><div id="do_lock_layer" class="toolbar_btn justicon tool_drop">
							<div id="layer_lock_iconswitch" class="icon_switcher" data-ref="#layer_Lock"><i class="material-icons icon_state_off">lock_open</i><i class="material-icons icon_state_on">lock_outline</i><input class="easyinit layerinput callEvent" id="layer_Lock" data-updateviaevt="true" data-evt="lockLayer" data-setclasson="layer_lock_iconswitch" data-class="icsw_on" type="checkbox" data-r="visibility.lock"></div>
							<div id="locked_layers_list" class="tool_dd_wrap outicon_dd_rwap">
								<div id="toggle_lock_layer" class="lockstep_main"><i class="material-icons">radio_button_checked</i><?php _e('Lock/Unlock Selected', 'revslider');?></div>
								<div id="unlock_all_layer" class="lockstep_main"><i class="material-icons">lock_open</i><?php _e('Unlock All', 'revslider');?></div>
							</div>
						</div><!--
						--><div id="do_show_layer" class="toolbar_btn justicon">
							<div id="layer_visibility_iconswitch" class="norightmargin icon_switcher icsw_on" data-ref="#layer_Visibility"><i class="material-icons icon_state_off">visibility_off</i><i class="material-icons icon_state_on">visibility</i><input class="easyinit layerinput callEvent" id="layer_Visibility" data-updateviaevt="true" data-evt="showHideLayer" data-setclasson="layer_visibility_iconswitch" data-class="icsw_on" type="checkbox" checked="checked" data-default="true" data-r="visibility.visible" ></div>
							<div id="unvisible_layers_list" class="tool_dd_wrap outicon_dd_rwap">
								<div id="hide_highlight_boxes" class="visiblestep_main"><i class="hhb_a material-icons">border_all</i><i class="hhb_b material-icons">border_clear</i><span class="hhb_a"><?php _e('Hide Highlight Boxes', 'revslider');?></span><span class="hhb_b"><?php _e('Show Highlight Boxes', 'revslider');?></span></div>
								<div id="toggle_visible_layer" class="visiblestep_main"><i class="material-icons">radio_button_checked</i><?php _e('Show/Hide Selected', 'revslider');?></div>
								<div id="visible_all_layer" class="visiblestep_main"><i class="material-icons">visibility</i><?php _e('Set All Visible', 'revslider');?></div>
							</div>
						</div><!--
						--><div id="do_background_layer" class="norightmargin toolbar_btn justicon"><i class="material-icons">arrow_drop_down</i></div><!--
						--><div id="do_foreground_layer" class="norightmargin toolbar_btn justicon"><i class="material-icons">arrow_drop_up</i></div>
					</div><!--
					--><div class="layertoolbar_wrap mht_inner slide_settings_collector">
						<div id="do_title_slide"><i class="material-icons do_title_slide_icon">burst_mode</i><input id="slide_title_field" data-r="title" class="easyinit slideinput callEvent" data-evt="updateSlideNameInList" type="text" /></div><!--
						--><div id="do_edit_slidename" class="toolbar_btn justicon"><i class="norightmargin material-icons">edit</i></div><!--
						--><div id="do_duplicate_slide" class="toolbar_btn justicon"><i class="norightmargin material-icons">content_copy</i></div><!--
						--><div id="do_delete_slide" class="toolbar_btn justicon"><i class="norightmargin material-icons">delete</i></div><!--
					--></div><!--
					--><div style="padding-left:0px" class="layertoolbar_wrap mht_inner slider_general_collector"><!--
						--><div id="current_sel_display" class="selected_placeholder"><i id="screen_selector_ph_icon_sr" class="toptoolbaricon material-icons">desktop_windows</i></div><!--
						--><div id="current_width_height"><i class="material-icons rotateleft">unfold_more</i><span id="show_c_width">1920px</span><i class="material-icons">unfold_more</i><span id="show_c_height">1920px</span></div><!--
					--></div>
					<div id="right_top_toolbar_wrap" class="toolbar_rightoriented"><!--
						--><div id="zoomer_wrap_toolbar" class="zoomer_wrap toolbar_selector_icons">
							<div class="selected_placeholder"><i id="zoomer_icon" style="font-size: 17px;margin-top: -2px;"class="toptoolbaricon material-icons">search</i><div id="zoomer_factor">100%</div></div>
							<div class="tool_dd_wrap"><!--
								--><div id="ezoomer_wrap">
									
									<div id="ezoomer">
										<div id="ezoomer_pin"></div>
										<div class="ezzomer_marks" style="left:0px"></div>
										<div class="ezzomer_marks" style="left:50px"></div>
										<div class="ezzomer_marks" style="left:100px"></div>
										<div class="ezzomer_marks" style="left:150px"></div>
										<div class="ezzomer_marks" style="left:200px"></div>									
									</div>
									
								</div><!--
							--></div>
						</div><!--
						--><div class="drawselector_wrap toolbar_selector_icons" id="toolkit_selector_wrap">
							<div class="selected_placeholder"><i id="toolkit_selector_ph_icon" class="toptoolbaricon material-icons mirrorhorizontal">near_me</i><i id="toolkit_selector_ph_icon_sub" class="material-icons near_me_addon"></i></div>
							<div class="tool_dd_wrap">
								<div class="toolkit_selector callEvent selected" id="select_by_cursor" data-toolkiticon="near_me" data-toolkiticonsub=" " data-evt="cursorselection"><i class="material-icons mirrorhorizontal">near_me</i><?php _e('Single Select', 'revslider');?></div>
								<div class="toolkit_selector callEvent" id="select_by_cursor_add" data-toolkiticon="near_me" data-toolkiticonsub="add" data-evt="cursorselectionadd"><i class="material-icons mirrorhorizontal">near_me</i><i class="material-icons near_me_addon">add</i><?php _e('Add to Selection', 'revslider');?><span class="shortcuttext"><span class="shortcut_cmdctrl">ctrl</span></span></div>
								<div class="toolkit_selector callEvent" id="select_by_draw" data-toolkiticon="flip_to_back" data-toolkiticonsub=" " data-evt="squareselection"><i class="material-icons">flip_to_back</i><?php _e('Drag to Select', 'revslider');?><span class="shortcuttext">shift</span></div>
							</div>
						</div><!--
						--><div class="undo_redo_wrap toolbar_selector_icons">
							<div class="selected_placeholder"><i id="undo_redo_wrap" class="toptoolbaricon material-icons">replay</i>
								<div class="tool_dd_wrap">
									<div id="undo" class="toolbar_listelement"><i class="material-icons">undo</i>Undo<span class="shortcuttext"><span class="shortcut_cmdctrl">ctrl</span>Z</span></div>
									<div id="redo" class="toolbar_listelement"><i class="material-icons">redo</i>Redo<span class="shortcuttext"><span class="shortcut_cmdctrl">ctrl</span>Y</span></div>
									<div id="undoredowrap">
										<div id="noactiondone_undo" class="toolbar_listelement"><i class="material-icons">exit_to_app</i><?php _e('Open Document', 'revslider');?></div>
										<ul id="undolist">
										</ul>
										<ul id="redolist"></ul>
									</div>
								</div>
							</div>
						</div><!--
						--><div class="toolbar_selector_icons" id="main_screenselector">
							<div class="selected_placeholder"><i id="screen_selector_ph_icon" class="toptoolbaricon material-icons">desktop_windows</i><span class="highlight_arrow"></span></div>
							<div id="screen_selector_top_list" class="tool_dd_wrap">
								<div id="screen_selecotr_ss_d" class="screen_selector ss_d selected callEvent" data-evt="screenSelectorChanged"  data-screenicon="desktop_windows" data-triggerinp="#screenselector" data-triggerinpval="d"><i class="material-icons">desktop_windows</i><?php _e('Desktop', 'revslider');?></div>
								<div id="screen_selecotr_ss_n" class="screen_selector ss_n callEvent" data-evt="screenSelectorChanged"  data-screenicon="laptop" data-triggerinp="#screenselector" data-triggerinpval="n"><i class="material-icons">laptop</i><?php _e('Notebook', 'revslider');?><input type="checkbox" id="sr_custom_n_opt" class="sliderinput easyinit" data-evt="device_area_availibity" data-r="size.custom.n"></div>
								<div id="screen_selecotr_ss_t" class="screen_selector ss_t callEvent" data-evt="screenSelectorChanged"  data-screenicon="tablet_mac" data-triggerinp="#screenselector" data-triggerinpval="t"><i class="material-icons">tablet_mac</i><?php _e('Tablet', 'revslider');?><input type="checkbox" id="sr_custom_t_opt" class="sliderinput easyinit" data-evt="device_area_availibity" data-r="size.custom.t"></div>
								<div id="screen_selecotr_ss_m" class="screen_selector ss_m no_rm callEvent" data-evt="screenSelectorChanged"  data-screenicon="phone_android" data-triggerinp="#screenselector" data-triggerinpval="m"><i class="material-icons">phone_android</i><?php _e('Mobile', 'revslider');?><input type="checkbox" id="sr_custom_m_opt" class="sliderinput easyinit" data-evt="device_area_availibity" data-r="size.custom.m"></div>
							</div>
						</div><!--
						--><div class="toolbar_btn help_wrap"><i class="toptoolbaricon material-icons">help_outline</i></div><!--<div class="toolbar_btn tooltip_wrap"><i class="toptoolbaricon material-icons">comment</i></div>--><!--
					--></div>
				</div><!-- END OF MAIN HORIZONTAL TOOLBAR -->
				<div id="rev_builder_wrapper">
					<!-- HORIZONTAL AND VERTICAL RULERS -->
					<div id="ruler_hor_marker"></div>
					<div id="ruler_ver_marker"></div>
					<div id="ruler_top"><canvas id="ruler_top_offset"></canvas></div>
					<div id="ruler_left"><canvas id="ruler_left_offset"></canvas></div>
					<div id="ruler_left_top_cover"></div>
					<!-- REV BUILDER CONTAINER -->
					<div id="rev_builder">
						<div id="rev_builder_inner">
							<div id="rev_slider_inbuild">

								<!-- SLIDER "UL" -->
								<div id="rev_slider_ul" data-multiplemark="false" data-forms='["#form_sliderlayout"]'>
									<canvas id="gridcanvas"></canvas>
									<div id="rev_slider_ul_inner">

										<!-- SLIDER OVERLAY -->
										<rs-dotted id="slider_overlay" class="twoxtwowhite"></rs-dotted>

										<!-- LAYOUT SLIDE ELEMENT -->
										<div class="slideelement" id="layout_slide">
											<div id="layer_grid" class="" data-multiplemark="false" data-forms='["#form_sliderlayout:#sr_fsl_l1_1"]' data-updateruler="layergrid">
											</div>
										</div><!-- END OF LAYOUT SLIDE ELEMENT -->

										<!-- TEMPLATE FOR SLIDE LI's -->
										<div class="slide_li aable markable" data-multiplemark="false" data-updateruler="layergrid" id="slide_li_template">											
											<div class="layer_grid" data-updateruler="layergrid"><div class="lg_topborder"></div><div class="lg_bottomborder"></div><div class="lg_leftborder"></div><div class="lg_rightborder"></div><div class="row_wrapper_top"></div><div class="row_wrapper_middle"></div><div class="row_wrapper_bottom"></div></div>
										</div><!-- END OF TEMPLATE FOR SLIDE LI's -->

										<!-- CAROUSEL FAKES FOR SHOWING BETTER THE RESULT OF CAROUSEL LAYOUTS-->
											<div id="fake_carousel_elements"></div>
										<!-- END OF CAROUSEL FAKES -->

										<!-- PROGRESS BAR -->
										<div id="rev_progress_bar_wrap" class="aable markable" data-multiplemark="false" data-collapse="true" data-forms='["*navlayout*#orm_nav_pbara"]'></div><!-- END OF PROGRESS BAR-->

										<!-- NAVIGATION ARROWS -->
										<div id="tp-rightarrow" class="aable markable tp-rightarrow tparrows" data-collapse="true" data-forms='["*navlayout*#form_nav_arrows"]'></div>
										<div id="tp-leftarrow" class="aable markable tp-leftarrow tparrows" data-collapse="true" data-forms='["*navlayout*#form_nav_arrows"]'></div>
										<!-- END OF NAVGATION ARROWS-->

										<!-- NAVIGATION BULLETS -->
										<div id="tp-bullets" class="aable markable tp-bullets" data-collapse="true" data-forms='["*navlayout*#form_nav_bullets"]'></div>
										<!-- END OF NAVIGATION BULLETS-->

										<!-- NAVIGATION TABS -->
										<div id="tp-tabs" class="aable markable tp-tabs" data-collapse="true" data-forms='["*navlayout*#form_nav_tabs"]'>
											<div id="tp-tabs-mask" class="tp-tabs-mask">
												<div id="tp-tabs-inner-wrapper" class="tp-tabs-inner-wrapper"></div>
											</div>
										</div>
										<!-- END OF NAVIGATION TABS-->

										<!-- NAVIGATION THUMBS -->
										<div id="tp-thumbs" class="aable markable tp-thumbs" data-collapse="true" data-forms='["*navlayout*#form_nav_thumbs"]'>
											<div id="tp-thumbs-mask" class="tp-thumbs-mask">
												<div id="tp-thumbs-inner-wrapper" class="tp-thumbs-inner-wrapper"></div>
											</div>
										</div>
										<!-- END OF NAVIGATION THUMBS-->

										<!-- DROP SENSOR -->
										<div id="dropSensor"></div>

									</div><!-- END OF INNER UL WRAPPER -->

								</div><!-- END OF SLIDER "UL" -->
							</div><!-- END OF REV_SLIDER -->
						</div><!-- END OF REV_BUILDER_INNER-->
					</div><!-- END OF REV_BUILDER -->
				</div><!-- END OF REV BUILDER WRAPPER-->
			</div><!-- END OF THE EDITOR-->

			<!-- THIS IS THE MAIN RIGHT TOOLBAR IF WITH RIGHT TOOLBAR SET -->
			<div id="the_right_toolbar">
				<div id="the_right_toolbar_inner">
					<div class="main_mode_selector opensettingstrigger" data-forms='["*sliderlayout*"]' data-collapse="false" id="module_settings_trigger"><i class=" material-icons">settings</i></div>
					<div class="main_mode_selector opensettingstrigger herodisable carouselenable standardenable" data-forms='["*navlayout*"]' data-collapse="true" id="module_navigation_trigger"><i class=" material-icons">gamepad</i></div>
					<div class="main_mode_selector opensettingstrigger" data-forms='["*slidelayout**mode__slidestyle*"]' data-collapse="false" id="module_slide_trigger"><i class=" material-icons">burst_mode</i></div>
					<div class="main_mode_selector opensettingstrigger" data-forms='["*slidelayout**mode__slidecontent*"]' data-collapse="false" id="module_layers_trigger"><i class=" material-icons">layers</i></div>
					<div class="tp-clearfix"></div>
				</div>
				<div id="settings_sticky_info">
					<div id="settings_sticky_left" class="main_mode_submode left blue">Editor View</div>
					<div id="settings_sticky_right" class="main_mode_submode right">Layer options</div>
				</div>
				<div id="optimizeslider" class="rs-save-preview"><i class="material-icons">flash_on</i><?php _e('Optimize File Sizes', 'revslider');?></div>
				<div id="save_slider" class="rs-save-preview"><i class="material-icons">save</i><?php _e('Save', 'revslider');?></div>
				<div id="preview_slider" data-mode="editor" class="rs-save-preview" ><i class="material-icons">search</i><?php _e('Preview', 'revslider');?></div>
			</div>
			<!-- END OF RIGHT TOOLBAR -->
		</div><!-- END OF THE CONTAINER-->

		<?php
		require_once(RS_PLUGIN_PATH . 'admin/views/builder-timeline.php');
		?>
	</div><!-- END OF REVOLUTION BUILDER TOP LEVEL WRAPPER -->

	

	<div id="crumblist"></div>


	<!-- 				-->
	<!--	DIALOGS 	-->
	<!-- 				-->

	<div id="nocustomsize" class="tp-dialog" title="Custom Size is Disabled">
		<span><?php _e('The Current Size is set to "Auto Size". Do you want to continue with Custom Size?', 'revslider');?></span>
	</div>

	<!-- 					-->
	<!--	MOUSEINFOBOX 	-->
	<!-- 					-->

	<div id="mouseInfoBox"></div>

</div>


<script>
	function rs_builder_inits() {
		RVS.LIB.LAYERANIMS = {customLTIn:{},customLTOut:{}};

<?php
if(isset($animationsRaw['in'])){ ?>
		RVS.LIB.LAYERANIMS.in = <?php echo $animationsRaw['in']; ?>;
<?php
}

if(isset($animationsRaw['out'])){ ?>
		RVS.LIB.LAYERANIMS.out = <?php echo $animationsRaw['out']; ?>;
<?php
}
if(isset($animationsRaw['out'])){ ?>
		RVS.LIB.LAYERANIMS.loop = <?php echo $animationsRaw['loop']; ?>;
<?php
}
?>		
		
		//Init Transition Presets
		RVS.LIB.SLTR = JSON.parse(<?php echo (empty($rs_base_transitions)) ? "'{}'" : str_replace('[]', '{}', $rs_f->json_encode_client_side($rs_base_transitions)); ?>);
		RVS.LIB.SLTR_CUSTOM = JSON.parse(<?php echo (empty($rs_custom_transitions)) ? "'{}'" : str_replace('[]', '{}', $rs_f->json_encode_client_side($rs_custom_transitions)); ?>);
		RVS.LIB.SLTR_FAVORIT = JSON.parse(<?php echo (empty($rs_favorite_transitions)) ? "'{}'" : str_replace('[]', '{}', $rs_f->json_encode_client_side($rs_favorite_transitions)); ?>);
		

		//Init Navigation Presets
		RVS.F.migrateNavigation(JSON.parse(<?php echo $rs_f->json_encode_client_side($arr_navigations); ?>));



		//Init Font Types
		<?php if (!empty($json_font_familys)) {?>
		RVS.F.initFontTypes(<?php echo $json_font_familys; ?>);
		<?php }?>

		if (!RVS.V.ignoreAutoStart) RVS.F.loadSlider({id:"<?php echo $slide_id; ?>", alias: "<?php echo $slide_alias; ?>"});
	}


	// INITIALISE PROCESSES
	var RSBUILDERINITS_once = false
	if (document.readyState === "loading") 
		document.addEventListener('readystatechange',function(){
			if ((document.readyState === "interactive" || document.readyState === "complete") && !RSBUILDERINITS_once) {
				RSBUILDERINITS_once = true;
				rs_builder_inits();	
			}
		});
	else {
		RSBUILDERINITS_once = true;
		rs_builder_inits();	
	}

	
	
	<?php
	
	/* temp */
	// delete_option('revslider_hide_tooltips', true);
	
	$showToolTips = get_option('revslider_hide_tooltips');
	$showToolTips = empty($hideToolTips) ? 'true' : 'false';
	?>
	var revSliderToolTips = <?php echo $showToolTips; ?>;

</script>