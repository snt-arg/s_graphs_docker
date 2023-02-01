<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2019 ThemePunch
 */

if(!defined('ABSPATH')) exit();
?>


<!-- SLIDER SETTINGS -->
<div id="nav_settings" data-root="settings.">

	<div class="form_collector nav_collector" data-type="sliderconfig" data-pcontainer="#nav_settings" data-offset="#rev_builder_wrapper">
		<div class="main_mode_breadcrumb_wrap"><div class="main_mode_submode"><?php _e('Navigation Options', 'revslider');?></div></div>
		<div class="gso_wrap">
			<div id="gst_nav_1" class="nav_submodule_trigger opensettingstrigger selected" data-select="#gst_nav_1" data-unselect=".nav_submodule_trigger" data-collapse="true" data-forms='["#form_nav_pbara"]'><i class="material-icons">timelapse</i><span class="gso_title"><?php _e('Progress', 'revslider');?></span></div><!--
			--><div id="gst_nav_2" data-select="#gst_nav_2" data-unselect=".nav_submodule_trigger" class="nav_submodule_trigger opensettingstrigger" data-collapse="true" data-forms='["#form_nav_arrows"]'><i class="material-icons">swap_horiz</i><span class="gso_title"><?php _e('Arrows', 'revslider');?></span></div><!--
			--><div id="gst_nav_3" data-select="#gst_nav_3" data-unselect=".nav_submodule_trigger" class="nav_submodule_trigger opensettingstrigger" data-collapse="true" data-forms='["#form_nav_bullets"]'><i class="material-icons">more_horiz</i><span class="gso_title"><?php _e('Bullets', 'revslider');?></span></div><!--
			--><div id="gst_nav_4" data-select="#gst_nav_4" data-unselect=".nav_submodule_trigger" class="nav_submodule_trigger opensettingstrigger" data-collapse="true" data-forms='["#form_nav_tabs"]'><i class="material-icons">view_column</i><span class="gso_title"><?php _e('Tabs', 'revslider');?></span></div><!--
			--><div id="gst_nav_5" data-select="#gst_nav_5" data-unselect=".nav_submodule_trigger" class="nav_submodule_trigger opensettingstrigger" data-collapse="true" data-forms='["#form_nav_thumbs"]'><i class="material-icons">filter_frames</i><span class="gso_title"><?php _e('Thumbs', 'revslider');?></span></div><!--
			--><div id="gst_nav_6" data-select="#gst_nav_6" data-unselect=".nav_submodule_trigger" class="nav_submodule_trigger opensettingstrigger" data-collapse="true" data-forms='["#form_nav_pprevima"]'><i class="material-icons">image</i><span class="gso_title"><?php _e('Prev Size', 'revslider');?></span></div><!--
			--><div id="gst_nav_7" data-select="#gst_nav_7" data-unselect=".nav_submodule_trigger" class="nav_submodule_trigger opensettingstrigger" data-collapse="true" data-forms='["#form_nav_touch"]'><i class="material-icons">pan_tool</i><span class="gso_title"><?php _e('Touch', 'revslider');?></span></div><!--
			--><div id="gst_nav_8" data-select="#gst_nav_8" data-unselect=".nav_submodule_trigger" class="nav_submodule_trigger opensettingstrigger" data-collapse="true" data-forms='["#form_nav_misc"]'><i class="material-icons">keyboard</i><span class="gso_title"><?php _e('Keyboard', 'revslider');?></span></div><!--
			--><div id="gst_nav_9" data-select="#gst_nav_9" data-unselect=".nav_submodule_trigger" class="nav_submodule_trigger opensettingstrigger" data-collapse="true" data-forms='["#form_nav_mousescroll"]'><i class="material-icons">mouse</i><span class="gso_title"><?php _e('Mouse', 'revslider');?></span></div><!--
			--><div id="gst_nav_10" class="callEvent general_submodule_trigger openmodaltrigger" data-evt="openNavigationEditor"><i class="material-icons">games</i><span class="gso_title"><?php _e('Nav Editor', 'revslider');?></span></div>

		</div>
	</div>


	<!-- NAVIGATION SETTINGS -->
	<div class="form_collector sceneunavailable carouselavailable standardavailable slider_nav_layout_collector nav_collector" data-type="sliderconfig" data-pcontainer="#nav_settings" data-offset="#rev_builder_wrapper" id="nav_form_collector" >
		<!-- PROGRESS BAR SETTINGS -->
		<div id="form_nav_pbara" data-select="#gst_nav_1" data-unselect=".nav_submodule_trigger" class="formcontainer form_menu_inside">
			<div class="collectortabwrap"><div id="collectortab_form_pbara" class="collectortab form_menu_inside" data-forms='["#form_nav_pbara"]'><i class="material-icons">timelapse</i><?php _e('Progress Bar', 'revslider');?></div></div>
			<!--<div id="slider_pb_settings_arrow" class="form_intoaccordion"><i class="material-icons">arrow_drop_down</i></div>-->
			<div class="form_inner">
				<div class="form_inner_header"><i class="material-icons">timelapse</i><?php _e('Progress Bar', 'revslider');?></div>
				<div class="on_off_navig_wrap"><input type="checkbox"  id="sr_pb_set" class="sliderinput easyinit" data-evt="sliderProgressUpdate" data-r="general.progressbar.set" data-showhide="#slider_pb_settings, #slider_pb_settings_arrow" data-showhidedep="true"/></div>
				<div id="slider_pb_settings" class="collapsable" style="display:block">
					<label_a><?php _e('Based On', 'revslider');?></label_a><select data-evt="sliderProgressUpdate" id="sr_pb_basedon" data-show=".progressgaps_*val*" data-hide=".progressgaps" class="sliderinput tos2 nosearchbox easyinit"  data-r="general.progressbar.basedon"><option value="slide"><?php _e('Current Slide Progress', 'revslider');?></option><option value="module"><?php _e('Module Progress', 'revslider');?></option></select><span class="linebreak"></span>					
					<label_a><?php _e('Style', 'revslider');?></label_a><select data-evt="sliderProgressUpdate" id="sr_pb_style" class="sliderinput tos2 nosearchbox easyinit"  data-r="general.progressbar.style" data-show=".progressoffsets_*val*" data-hide=".progressoffsets"><option value="horizontal"><?php _e('Horizontal', 'revslider');?></option><option value="vertical"><?php _e('Vertical', 'revslider');?></option><option value="cw"><?php _e('Circle CW', 'revslider');?></option><option value="ccw"><?php _e('Circle CCW', 'revslider');?></option></select><span class="linebreak"></span>
					<div class="progressoffsets progressoffsets_horizontal progressoffsets_vertical">
						<div class="progressgaps progressgaps_module">
							<label_a><?php _e('Gap', 'revslider');?></label_a><input type="checkbox" class="easyinit sliderinput" data-evt="sliderProgressUpdate" id="sr_pb_separator" data-showhide=".separatorpb" data-showhidedep="true" data-r="general.progressbar.gap"><span class="linebreak"></span>						
							<div class="separatorpb">
								<label_a><?php _e('Gap Size', 'revslider');?></label_a><input class="sliderinput valueduekeyboard easyinit" data-numeric="true" data-allowed="" data-evt="sliderProgressUpdate" data-r="general.progressbar.gapsize" type="text" id="sr_pb_gaps" ><span class="linebreak"></span>						
								<label_a><?php _e('Gap Color', 'revslider');?></label_a><input type="text" data-editing="Gap Color" data-evt="sliderProgressUpdate" name="progressgapcolor" data-visible="true" id="progressgapcolor" class="my-color-field sliderinput easyinit" data-r="general.progressbar.gapcolor" value="transparent">							
							</div>
						</div>
					</div>
					<div class="div5"></div>										
					<label_a><?php _e('Progress Bar', 'revslider');?></label_a><input type="text" data-editing="Progressbar Color" data-evt="sliderProgressUpdate" name="sliderprogresscolor" data-visible="true" id="sliderprogresscolor" class="my-color-field sliderinput easyinit" data-r="general.progressbar.color" value="transparent">
					<label_a><?php _e('Background', 'revslider');?></label_a><input type="text" data-editing="Progressbar Color BG" data-evt="sliderProgressUpdate" name="sliderprogresscolorbg" data-visible="true" id="sliderprogresscolorbg" class="my-color-field sliderinput easyinit" data-r="general.progressbar.bgcolor" value="transparent">
					<div class="div5"></div>
					<label_a>Aligned by</label_a>
					<div class="radiooption">						
						<div><input class="sliderinput easyinit" data-evt="sliderProgressUpdate" type="radio" value="grid" id="sr_pr_alignscene_grid" name="sr_pr_alignscene" data-r="general.progressbar.alignby"><label_sub><?php _e('Layer Area', 'revslider');?></label_sub></div>
						<div><input class="sliderinput easyinit" data-evt="sliderProgressUpdate" type="radio" value="slider" id="sr_pr_alignscene_slider" name="sr_pr_alignscene" data-r="general.progressbar.alignby"><label_sub><?php _e('Scene', 'revslider');?></label_sub></div>
					</div>
					<div class="div20"></div>
					<div class="div5"></div>					
					<select style="display:none" id="sr_progbaralignrhor" data-evt="sliderProgressUpdate" data-evtparam="progressbar" data-unselect=".progressbar_selector" data-select="#progressbar_selector_*val*-*RVAL*" data-rval="settings.general.progressbar.vertical" class="sliderinput easyinit" data-r="general.progressbar.horizontal" data-triggerinp="#generalprogressbaroffsetx" data-triggerinpval="0"><option value="left"><?php _e('Left', 'revslider');?></option><option value="center"><?php _e('Center', 'revslider');?></option><option value="right"><?php _e('Right', 'revslider');?></option></select>
					<select style="display:none" id="sr_progbaralignrver" data-evt="sliderProgressUpdate" data-evtparam="progressbar" data-unselect=".progressbar_selector" data-select="#progressbar_selector_*RVAL*-*val*" data-rval="settings.general.progressbar.horizontal" class="sliderinput easyinit" data-r="general.progressbar.vertical" data-triggerinp="#generalprogressbaroffsety"  data-triggerinpval="0"><option value="top"><?php _e('Top', 'revslider');?></option><option value="center"><?php _e('Center', 'revslider');?></option><option value="bottom"><?php _e('Bottom', 'revslider');?></option></select>					
					<row class="direktrow">
						<onelong>
							<label_a><?php _e('Aligment', 'revslider');?></label_a>
							<div class="bg_alignselector_wrap">
								<div class="bg_align_row">
									<div data-type="progressbar" class=" progressbar_selector bg_alignselector" data-select="#sr_progbaralignrhor,#sr_progbaralignrver" data-val="left,top" id="progressbar_selector_left-top"></div>
									<div data-type="progressbar" class=" progressbar_selector bg_alignselector" data-select="#sr_progbaralignrhor,#sr_progbaralignrver" data-val="center,top" id="progressbar_selector_center-top"></div>
									<div data-type="progressbar" class=" progressbar_selector bg_alignselector" data-select="#sr_progbaralignrhor,#sr_progbaralignrver" data-val="right,top" id="progressbar_selector_right-top"></div>
								</div>
								<div class="bg_align_row">
									<div data-type="progressbar" class=" progressbar_selector bg_alignselector" data-select="#sr_progbaralignrhor,#sr_progbaralignrver" data-val="left,center" id="progressbar_selector_left-center"></div>
									<div data-type="progressbar" class=" progressbar_selector bg_alignselector" data-select="#sr_progbaralignrhor,#sr_progbaralignrver" data-val="center,center" id="progressbar_selector_center-center"></div>
									<div data-type="progressbar" class=" progressbar_selector bg_alignselector" data-select="#sr_progbaralignrhor,#sr_progbaralignrver" data-val="right,center" id="progressbar_selector_right-center"></div>
								</div>
								<div class="bg_align_row">
									<div data-type="progressbar" class=" progressbar_selector bg_alignselector" data-select="#sr_progbaralignrhor,#sr_progbaralignrver" data-val="left,bottom" id="progressbar_selector_left-bottom"></div>
									<div data-type="progressbar" class=" progressbar_selector bg_alignselector" data-select="#sr_progbaralignrhor,#sr_progbaralignrver" data-val="center,bottom" id="progressbar_selector_center-bottom"></div>
									<div data-type="progressbar" class=" progressbar_selector bg_alignselector" data-select="#sr_progbaralignrhor,#sr_progbaralignrver" data-val="right,bottom" id="progressbar_selector_right-bottom"></div>
								</div>
							</div>
						</onelong>
						<oneshort>
							<div class="progressoffsets progressoffsets_vertical progressoffsets_ccw progressoffsets_cw"><label_icon class="ui_x"></label_icon><input class="sliderinput valueduekeyboard  easyinit" data-r="general.progressbar.x" data-evt="sliderProgressUpdate" data-numeric="true"  data-min="-1200" data-max="1200" type="text" id="generalprogressbaroffsetx" ></div>
							<div class="progressoffsets progressoffsets_horizontal progressoffsets_ccw progressoffsets_cw"><label_icon class="ui_y"></label_icon><input class="sliderinput valueduekeyboard  easyinit" data-r="general.progressbar.y" data-evt="sliderProgressUpdate" data-numeric="true"  data-min="-1200" data-max="1200" type="text" id="generalprogressbaroffsety" ></div>
						</oneshort>
					</row>
					<div class="div5"></div>										
					<label_a><?php _e('Strength', 'revslider');?></label_a><input class="sliderinput valueduekeyboard easyinit" data-allowed="px,%" data-numeric="true" data-evt="sliderProgressUpdate" data-r="general.progressbar.size" type="text" id="sr_pb_size" ><span class="linebreak"></span>
					<div class="progressoffsets progressoffsets_ccw progressoffsets_cw"><label_a><?php _e('Radius', 'revslider');?></label_a><input class="sliderinput valueduekeyboard easyinit" data-evt="sliderProgressUpdate" data-r="general.progressbar.radius" type="text" id="sr_pb_radius" ></div>
					<label_a><?php _e('Reset', 'revslider');?></label_a><select class="sliderinput tos2 nosearchbox easyinit"  data-r="general.progressbar.reset"><option value="reset"><?php _e('No Animation', 'revslider');?></option><option value="animate"><?php _e('Animate', 'revslider');?></option></select><span class="linebreak"></span>
					<div class="div5"></div>
					<row class="directrow">
						<onelong><label_icon class="ui_desktop"></label_icon><input type="checkbox" class="easyinit sliderinput" data-r="general.progressbar.visibility.d"></onelong>
						<oneshort><label_icon class="ui_notebook"></label_icon><input type="checkbox" class="easyinit sliderinput" data-r="general.progressbar.visibility.n" ></oneshort>
					</row>
					<row class="directrow">
						<onelong><label_icon class="ui_tablet"></label_icon><input type="checkbox" class="easyinit sliderinput" data-r="general.progressbar.visibility.t" ></onelong>
						<oneshort><label_icon class="ui_mobile"></label_icon><input type="checkbox" class="easyinit sliderinput" data-r="general.progressbar.visibility.m" ></oneshort>
					</row>
				</div>
			</div>
		</div><!-- PROGRESS BAR SETTINGS ENDS-->

		<!-- ARROWS SETTING -->
		<div id="form_nav_arrows" data-select="#gst_nav_2" data-unselect=".nav_submodule_trigger" class="formcontainer carouselenable standardenable herodisable collapsed form_menu_inside">
			<div class="collectortabwrap"><div id="collectortab_form_nav_arr" class="collectortab form_menu_inside" data-forms='["#form_nav_arrows"]'><i class="material-icons">swap_horiz</i><?php _e('Arrows', 'revslider');?></div></div>
			<!--<div id="nav_arrows_settings_arrow" class="form_intoaccordion"><i class="material-icons">arrow_drop_down</i></div>-->
			<ul class="form_menu_level_1">
				<li data-target="#form_nav_arrows_mainstyle" class="form_menu_level_1_li" id="sr_na_arr_0"><?php _e('Style', 'revslider');?></li>
				<li data-target="#form_nav_arrows_visi" class="form_menu_level_1_li" id="sr_na_arr_1"><?php _e('Visibility', 'revslider');?></li>
				<li data-target="#form_nav_arrows_left" class="form_menu_level_1_li" id="sr_na_arr_12"><?php _e('Left Arrow', 'revslider');?></li>
				<li data-target="#form_nav_arrows_right" class="form_menu_level_1_li" id="sr_na_arr_13"><?php _e('Right Arrow', 'revslider');?></li>
				<li data-target="#form_nav_arrows_style" class="form_menu_level_1_li" id="sr_na_arr_2"><?php _e('Style', 'revslider');?></li>
				<li data-target="#form_slide_nav_arrows" class="form_menu_level_1_li" id="sr_na_arr_21"><?php _e('Style on Slide', 'revslider');?></li>
			</ul>
			<div id="form_nav_arrows_mainstyle" class="form_inner open" >
				<div class="form_inner_header"><i class="material-icons">opacity</i><?php _e('Arrow Type', 'revslider');?></div>
				<div class="on_off_navig_wrap"><input type="checkbox"  id="sr_usenavarrow" class="sliderinput easyinit nav-enable" data-evt="sliderNavUpdate" data-evtparam="arrows" data-showhide="#arrow_main_style_collaps, #form_nav_arrows_left, #form_nav_arrows_right, #form_nav_arrows_visi, #form_nav_arrows_style, #form_slide_nav_arrows" data-showhidedep="true" data-r="nav.arrows.set"/></div>
				<!--<div class="form_intoaccordion" data-trigger="#sr_na_arr_1"><i class="material-icons">arrow_drop_down</i></div>-->
				<div id="arrow_main_style_collaps" class="collapsable">
					<label_a><?php _e('Arrow Style', 'revslider');?></label_a><select id="sr_arrows_style"  data-evt="sliderNavUpdate" data-evtparam="arrows" data-r="nav.arrows.style" class="sliderinput tos2 nosearchbox easyinit sr_nav_style_tos" >
						<option value=""><?php _e('No Style', 'revslider');?></option>

					</select>
				</div>
			</div>

			<div id="form_nav_arrows_left" class="form_inner open" >
				<div class="form_inner_header"><i class="material-icons">arrow_back</i><?php _e('Left Arrow', 'revslider');?></div>
				<!--<div class="form_intoaccordion" data-trigger="#sr_na_arr_12"><i class="material-icons">arrow_drop_down</i></div>-->
				<div class="collapsable">

					
					

					<label_a><?php _e('Aligned by', 'revslider');?></label_a>
					<div class="radiooption">
						<div><input class="sliderinput easyinit" data-evt="sliderNavPositionUpdate" data-evtparam="arrows" type="radio" value="slider" name="sr_leftarralign" data-r="nav.arrows.left.align"><label_sub><?php _e('Module Dimension', 'revslider');?></label_sub></div>
						<div><input class="sliderinput easyinit" data-evt="sliderNavPositionUpdate" data-evtparam="arrows" type="radio" value="grid" name="sr_leftarralign" data-r="nav.arrows.left.align"><label_sub><?php _e('Content', 'revslider');?></label_sub></div>
					</div>
					<div class="div20"></div>

					<select style="display:none" data-evt="sliderNavPositionUpdate" data-evtparam="arrows" id="sr_leftarrhor" data-unselect=".left_arrow_position_selector" data-select="#left_arrow_position_selector_*val*-*RVAL*" data-rval="settings.nav.arrows.left.vertical" class="sliderinput easyinit" data-r="nav.arrows.left.horizontal" data-triggerinp="#nav_arrows_left_offsetx" data-triggerinpval="0"><option value="left"><?php _e('Left', 'revslider');?></option><option value="center"><?php _e('Center', 'revslider');?></option><option value="right"><?php _e('Right', 'revslider');?></option></select>
					<select style="display:none" data-evt="sliderNavPositionUpdate" data-evtparam="arrows" id="sr_leftarrver" data-unselect=".left_arrow_position_selector" data-select="#left_arrow_position_selector_*RVAL*-*val*" data-rval="settings.nav.arrows.left.horizontal" class="sliderinput easyinit" data-r="nav.arrows.left.vertical" data-triggerinp="#nav_arrows_left_offsety"  data-triggerinpval="0"><option value="top"><?php _e('Top', 'revslider');?></option><option value="center"><?php _e('Center', 'revslider');?></option><option value="bottom"><?php _e('Bottom', 'revslider');?></option></select>

					<row class="direktrow">
						<onelong>
							<label_a><?php _e('Aligment', 'revslider');?></label_a>
							<div class="bg_alignselector_wrap">
								<div class="bg_align_row">
									<div data-type="arrows" class="navaligntrigger left_arrow_position_selector bg_alignselector" data-select="#sr_leftarrhor,#sr_leftarrver" data-val="left,top" id="left_arrow_position_selector_left-top"></div>
									<div data-type="arrows" class="navaligntrigger left_arrow_position_selector bg_alignselector" data-select="#sr_leftarrhor,#sr_leftarrver" data-val="center,top" id="left_arrow_position_selector_center-top"></div>
									<div data-type="arrows" class="navaligntrigger left_arrow_position_selector bg_alignselector" data-select="#sr_leftarrhor,#sr_leftarrver" data-val="right,top" id="left_arrow_position_selector_right-top"></div>
								</div>
								<div class="bg_align_row">
									<div data-type="arrows" class="navaligntrigger left_arrow_position_selector bg_alignselector" data-select="#sr_leftarrhor,#sr_leftarrver" data-val="left,center" id="left_arrow_position_selector_left-center"></div>
									<div data-type="arrows" class="navaligntrigger left_arrow_position_selector bg_alignselector" data-select="#sr_leftarrhor,#sr_leftarrver" data-val="center,center" id="left_arrow_position_selector_center-center"></div>
									<div data-type="arrows" class="navaligntrigger left_arrow_position_selector bg_alignselector" data-select="#sr_leftarrhor,#sr_leftarrver" data-val="right,center" id="left_arrow_position_selector_right-center"></div>
								</div>
								<div class="bg_align_row">
									<div data-type="arrows" class="navaligntrigger left_arrow_position_selector bg_alignselector" data-select="#sr_leftarrhor,#sr_leftarrver" data-val="left,bottom" id="left_arrow_position_selector_left-bottom"></div>
									<div data-type="arrows" class="navaligntrigger left_arrow_position_selector bg_alignselector" data-select="#sr_leftarrhor,#sr_leftarrver" data-val="center,bottom" id="left_arrow_position_selector_center-bottom"></div>
									<div data-type="arrows" class="navaligntrigger left_arrow_position_selector bg_alignselector" data-select="#sr_leftarrhor,#sr_leftarrver" data-val="right,bottom" id="left_arrow_position_selector_right-bottom"></div>
								</div>
							</div>
						</onelong>
						<oneshort>
							<label_icon class="ui_x"></label_icon><input class="sliderinput valueduekeyboard  easyinit" data-r="nav.arrows.left.offsetX" data-evt="sliderNavPositionUpdate" data-evtparam="arrows" data-allowed="px" data-numeric="true"  data-min="-1200" data-max="1200" type="text" id="nav_arrows_left_offsetx" >
							<label_icon class="ui_y"></label_icon><input class="sliderinput valueduekeyboard  easyinit" data-r="nav.arrows.left.offsetY" data-evt="sliderNavPositionUpdate" data-evtparam="arrows" data-allowed="px" data-numeric="true"  data-min="-1200" data-max="1200" type="text" id="nav_arrows_left_offsety" >
						</oneshort>
					</row>

					<div class="div20"></div>

					<label_a><?php _e('Animation', 'revslider');?></label_a><select  id="sr_arrowleft_animation"  data-r="nav.arrows.left.anim" class="sliderinput tos2 nosearchbox easyinit">						
						<option value="fade"><?php _e('Fade', 'revslider');?></option>
						<option value="left"><?php _e('From Left', 'revslider');?></option>
						<option value="right"><?php _e('From Right', 'revslider');?></option>
						<option value="top"><?php _e('From Top', 'revslider');?></option>
						<option value="bottom"><?php _e('From Bottom', 'revslider');?></option>
						<option value="zoomin"><?php _e('Zoom In', 'revslider');?></option>
						<option value="zoomout"><?php _e('Zoom Out', 'revslider');?></option>
					</select>					
				</div>
			</div>

			<div id="form_nav_arrows_right" class="form_inner open" >
				<div class="form_inner_header"><i class="material-icons">arrow_forward</i><?php _e('Right Arrow', 'revslider');?></div>
				<!--<div class="form_intoaccordion" data-trigger="#sr_na_arr_13"><i class="material-icons">arrow_drop_down</i></div>-->
				<div class="collapsable">					
					<label_a><?php _e('Aligned by', 'revslider');?></label_a>
					<div class="radiooption">
						<div><input class="sliderinput easyinit" data-evt="sliderNavPositionUpdate" data-evtparam="arrows" type="radio" value="slider" name="sr_rightarralign" data-r="nav.arrows.right.align"><label_sub><?php _e('Module Dimension', 'revslider');?></label_sub></div>
						<div><input class="sliderinput easyinit" data-evt="sliderNavPositionUpdate" data-evtparam="arrows" type="radio" value="grid" name="sr_rightarralign" data-r="nav.arrows.right.align"><label_sub><?php _e('Content', 'revslider');?></label_sub></div>
					</div>
					<div class="div20"></div>

					<select style="display:none" data-evt="sliderNavPositionUpdate" data-evtparam="arrows" id="sr_rightarrhor" data-unselect=".right_arrow_position_selector" data-select="#right_arrow_position_selector_*val*-*RVAL*" data-rval="settings.nav.arrows.right.vertical" class="sliderinput easyinit" data-r="nav.arrows.right.horizontal" data-triggerinp="#nav_arrows_right_offsetx"  data-triggerinpval="0"><option value="left"><?php _e('Left', 'revslider');?></option><option value="center"><?php _e('Center', 'revslider');?></option><option value="right"><?php _e('Right', 'revslider');?></option></select>
					<select style="display:none" data-evt="sliderNavPositionUpdate" data-evtparam="arrows" id="sr_rightarrver" data-unselect=".right_arrow_position_selector" data-select="#right_arrow_position_selector_*RVAL*-*val*" data-rval="settings.nav.arrows.right.horizontal" class="sliderinput easyinit" data-r="nav.arrows.right.vertical" data-triggerinp="#nav_arrows_right_offsety"  data-triggerinpval="0"><option value="top"><?php _e('Top', 'revslider');?></option><option value="center"><?php _e('Center', 'revslider');?></option><option value="bottom"><?php _e('Bottom', 'revslider');?></option></select>
					<row class="direktrow">
						<onelong>
							<label_a><?php _e('Aligment', 'revslider');?></label_a>
							<div class="bg_alignselector_wrap">
								<div class="bg_align_row">
									<div data-type="arrows" class="navaligntrigger right_arrow_position_selector bg_alignselector" data-select="#sr_rightarrhor,#sr_rightarrver" data-val="left,top" id="right_arrow_position_selector_left-top"></div>
									<div data-type="arrows" class="navaligntrigger right_arrow_position_selector bg_alignselector" data-select="#sr_rightarrhor,#sr_rightarrver" data-val="center,top" id="right_arrow_position_selector_center-top"></div>
									<div data-type="arrows" class="navaligntrigger right_arrow_position_selector bg_alignselector" data-select="#sr_rightarrhor,#sr_rightarrver" data-val="right,top" id="right_arrow_position_selector_right-top"></div>
								</div>
								<div class="bg_align_row">
									<div data-type="arrows" class="navaligntrigger right_arrow_position_selector bg_alignselector" data-select="#sr_rightarrhor,#sr_rightarrver" data-val="left,center" id="right_arrow_position_selector_left-center"></div>
									<div data-type="arrows" class="navaligntrigger right_arrow_position_selector bg_alignselector" data-select="#sr_rightarrhor,#sr_rightarrver" data-val="center,center" id="right_arrow_position_selector_center-center"></div>
									<div data-type="arrows" class="navaligntrigger right_arrow_position_selector bg_alignselector" data-select="#sr_rightarrhor,#sr_rightarrver" data-val="right,center" id="right_arrow_position_selector_right-center"></div>
								</div>
								<div class="bg_align_row">
									<div data-type="arrows" class="navaligntrigger right_arrow_position_selector bg_alignselector" data-select="#sr_rightarrhor,#sr_rightarrver" data-val="left,bottom" id="right_arrow_position_selector_left-bottom"></div>
									<div data-type="arrows" class="navaligntrigger right_arrow_position_selector bg_alignselector" data-select="#sr_rightarrhor,#sr_rightarrver" data-val="center,bottom" id="right_arrow_position_selector_center-bottom"></div>
									<div data-type="arrows" class="navaligntrigger right_arrow_position_selector bg_alignselector" data-select="#sr_rightarrhor,#sr_rightarrver" data-val="right,bottom" id="right_arrow_position_selector_right-bottom"></div>
								</div>
							</div>
						</onelong>

						<oneshort>
							<label_icon class="ui_x"></label_icon><input class="sliderinput valueduekeyboard  easyinit" data-r="nav.arrows.right.offsetX" data-evt="sliderNavPositionUpdate" data-evtparam="arrows" data-allowed="px" data-numeric="true"  data-min="-1200" data-max="1200" type="text" id="nav_arrows_right_offsetx" >
							<label_icon class="ui_y"></label_icon><input class="sliderinput valueduekeyboard  easyinit" data-r="nav.arrows.right.offsetY" data-evt="sliderNavPositionUpdate" data-evtparam="arrows" data-allowed="px" data-numeric="true"  data-min="-1200" data-max="1200" type="text" id="nav_arrows_right_offsety" >
						</oneshort>
					</row>
					<div class="div20"></div>
					<label_a><?php _e('Animation', 'revslider');?></label_a><select  id="sr_arrowright_animation"  data-r="nav.arrows.right.anim" class="sliderinput tos2 nosearchbox easyinit">						
						<option value="fade"><?php _e('Fade', 'revslider');?></option>
						<option value="left"><?php _e('From Left', 'revslider');?></option>
						<option value="right"><?php _e('From Right', 'revslider');?></option>
						<option value="top"><?php _e('From Top', 'revslider');?></option>
						<option value="bottom"><?php _e('From Bottom', 'revslider');?></option>
						<option value="zoomin"><?php _e('Zoom In', 'revslider');?></option>
						<option value="zoomout"><?php _e('Zoom Out', 'revslider');?></option>
					</select>					
				</div>

			</div>

			<div id="form_nav_arrows_visi" class="form_inner open" >
				<div class="form_inner_header"><i class="material-icons">visibility</i><?php _e('Visibility', 'revslider');?></div>
				<!--<div class="form_intoaccordion" data-trigger="#sr_na_arr_1"><i class="material-icons">arrow_drop_down</i></div>-->
				<div class="collapsable">					
					<label_a><?php _e('RTL Direction', 'revslider');?></label_a><input type="checkbox"  id="sr_arrowrtl" class="sliderinput easyinit" data-r="nav.arrows.rtl"/><span class="linebreak"></span>
					<label_a><?php _e('Show Speed', 'revslider');?></label_a><input class="sliderinput valueduekeyboard  easyinit" data-numeric="true" data-allowed="ms" data-r="nav.arrows.animSpeed" data-min="1" data-max="10000" type="text" id="nav_arrow_animSpeed"><span class="linebreak"></span>
					<label_a><?php _e('Show Delay', 'revslider');?></label_a><input class="sliderinput valueduekeyboard easyinit" data-numeric="true" data-allowed="ms" data-r="nav.arrows.animDelay" data-min="1" data-max="10000" type="text" id="nav_arrow_animDelay"><span class="linebreak"></span>
					<row class="directrow">
						<onelong><label_a><?php _e('Show Always', 'revslider');?></label_a><input type="checkbox"  id="sr_arrowsalwshow" class="sliderinput easyinit" data-r="nav.arrows.alwaysOn" data-showhide="#nav_arrows_alwaysshow" data-showhidedep="false"/></onelong>
						<oneshort id="nav_arrows_alwaysshow">
							<label_icon class="ui_desktop"></label_icon><input data-numeric="true" data-allowed="ms" class="sliderinput valueduekeyboard  easyinit" data-r="nav.arrows.hideDelay" data-min="0" data-max="5000" type="text" id="nav_arrows_hideDelay"/><span class="linebreak"></span>
							<label_icon class="ui_notebook"></label_icon><input data-numeric="true" data-allowed="ms" class="sliderinput valueduekeyboard  easyinit" data-r="nav.arrows.hideDelayMobile" data-min="0" data-max="5000" type="text" id="nav_arrows_hideDelayMobile"/>
							<div class="div10"></div>
						</oneshort>
					</row>

					<row class="direktrow">
						<onelong><label_a><?php _e('Hide Under', 'revslider');?></label_a><input type="checkbox"  id="sr_arrowshideunder" class="sliderinput easyinit" data-r="nav.arrows.hideUnder" data-showhide="#nav_arrows_hideunderlimit_wr" data-showhidedep="true"/></onelong>
						<oneshort id="nav_arrows_hideunderlimit_wr"><label_icon class="ui_maxwidth"></label_icon><input data-numeric="true" data-allowed="px" class="sliderinput valueduekeyboard  easyinit" data-r="nav.arrows.hideUnderLimit" data-min="0" data-max="2400" type="text" id="nav_arrows_hideunderlimit" ></oneshort>
					</row>

					<row class="direktrow">
						<onelong><label_a><?php _e('Hide Over', 'revslider');?></label_a><input type="checkbox"  id="sr_arrowshideover" class="sliderinput easyinit" data-r="nav.arrows.hideOver" data-showhide="#nav_arrows_hideoverlimit_wr" data-showhidedep="true"/></onelong>
						<oneshort id="nav_arrows_hideoverlimit_wr"><label_icon class="ui_minwidth"></label_icon><input data-numeric="true" data-allowed="px" class="sliderinput valueduekeyboard  easyinit" data-r="nav.arrows.hideOverLimit" data-min="0" data-max="2400" type="text" id="nav_arrows_hideoverlimit" ></oneshort>
					</row>
				</div>
			</div>

			<div id="form_nav_arrows_style" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">palette</i><?php _e('Navigation Style', 'revslider');?></div>
				<div class="collapsable">
					<div id="sr_arrows_styles_fieldset"></div>
				</div>
			</div>

			<div id="form_nav_arrows_style" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">palette</i><?php _e('Global Style Presets', 'revslider');?></div>
				<!--<div class="form_intoaccordion" data-trigger="#sr_na_arr_2"><i class="material-icons">arrow_drop_down</i></div>-->
				<div class="collapsable">
					<label_a><?php _e('Preset', 'revslider');?></label_a><select id="sr_arrows_style_preset" data-tags="true" data-r="nav.arrows.preset" class="sliderinput tos2 searchbox easyinit" ></select><span class="linebreak"></span>
					<label_a></label_a><div data-evt="sliderNavPreset" data-evtparam="arrows" class="callEventButton basic_action_button autosize"><i class="material-icons">save</i><?php _e('Load', 'revslider');?></div>
					<div data-evt="saveNavPreset" data-evtparam="arrows" class="callEventButton basic_action_button autosize"><i class="material-icons">save</i><?php _e('Save', 'revslider');?></div><span class="linebreak"></span>
					<label_a></label_a><div data-evt="deleteNavPreset" data-evtparam="arrows" class="callEventButton basic_action_button autosize"><i class="material-icons">delete</i><?php _e('Delete', 'revslider');?></div>
				</div>
			</div>

			<!-- SLIDE LOCAL ARROWS SETTING -->
			<div id="form_slide_nav_arrows" class="form_inner open form_menu_inside">
				<div class="form_inner_header"><i class="material-icons">texture</i><?php _e('Override Style on Slide', 'revslider');?></div>
				<!--<div class="form_intoaccordion" data-trigger="#sr_na_arr_21"><i class="material-icons">arrow_drop_down</i></div>-->
				<div class="collapsable carouselenable standardenable herodisable">
					<div id="sl_arrows_styles_fieldset"></div>
				</div>
			</div><!-- END OF SLIDE ARROWS CHANGES -->
		</div>

		<!--  BULLETS SETTING -->
		<div id="form_nav_bullets" data-select="#gst_nav_3" data-unselect=".nav_submodule_trigger" class="formcontainer form_menu_inside carouselenable standardenable herodisable collapsed">
			<div class="collectortabwrap"><div id="collectortab_form_nav_bull" class="collectortab form_menu_inside" data-forms='["#form_nav_bullets"]'><i class="material-icons">more_horiz</i><?php _e('Bullets', 'revslider');?></div></div>
			<!--<div id="nav_bullets_settings_arrow" class="form_intoaccordion"><i class="material-icons">arrow_drop_down</i></div>-->
			<ul class="form_menu_level_1">
				<li data-target="#form_nav_bullets_mainstyle" class="form_menu_level_1_li" id="sr_na_bul_0"><?php _e('Style', 'revslider');?></li>
				<li data-target="#form_nav_bullets_visi" class="selected form_menu_level_1_li" id="sr_na_bul_1"><?php _e('Visibility', 'revslider');?></li>
				<li data-target="#form_nav_bullets_posi" class="selected form_menu_level_1_li" id="sr_na_bul_11"><?php _e('Position', 'revslider');?></li>
				<li data-target="#form_nav_bullets_style" class="form_menu_level_1_li" id="sr_na_bul_2"><?php _e('Style', 'revslider');?></li>
				<li data-target="#form_slide_nav_bullets" class="form_menu_level_1_li" id="sr_na_bul_21"><?php _e('Style', 'revslider');?></li>
			</ul>

			<div id="form_nav_bullets_mainstyle" class="form_inner form_menu_inside open">
				<div class="form_inner_header"><i class="material-icons">opacity</i><?php _e('Bullets Type', 'revslider');?></div>
				<div class="on_off_navig_wrap"><input type="checkbox"  id="sr_usenavbullets" class="sliderinput easyinit nav-enable" data-evt="sliderNavUpdate" data-evtparam="bullets" data-showhide="#bullets_style_collapsable, #form_nav_bullets_posi, #form_nav_bullets_visi,#form_nav_bullets_style, #form_slide_nav_bullets" data-showhidedep="true" data-r="nav.bullets.set"/></div>
				<!--<div class="form_intoaccordion" data-trigger="#sr_na_bul_0"><i class="material-icons">arrow_drop_down</i></div>-->
				<div id="bullets_style_collapsable" class="collapsable">
					<label_a><?php _e('Bullets Style', 'revslider');?></label_a><select  id="sr_bullets_style"  data-evt="sliderNavUpdate" data-evtparam="bullets" data-r="nav.bullets.style"  class="sliderinput tos2 nosearchbox easyinit sr_nav_style_tos">
						<option value=""><?php _e('No Style', 'revslider');?></option>
					</select>
				</div>
			</div>

			<div id="form_nav_bullets_posi" class="form_inner form_menu_inside open">
				<div class="form_inner_header"><i class="material-icons">open_with</i><?php _e('Position', 'revslider');?></div>
				<!--<div class="form_intoaccordion" data-trigger="#sr_na_bul_11"><i class="material-icons">arrow_drop_down</i></div>-->
				<div class="collapsable">
					<label_a><?php _e('Gap', 'revslider');?></label_a><input class="sliderinput valueduekeyboard  easyinit" data-evt="sliderNavPositionUpdate" data-evtparam="bullets" data-r="nav.bullets.space" data-min="-100" data-max="500" type="text" id="nav_bullets_space" ><span class="linebreak"></span>
					<label_a><?php _e('Orientation', 'revslider');?></label_a>
					<div class="radiooption">
						<input class="sliderinput easyinit" type="radio" name="sr_bulletdirection" data-evt="sliderNavPositionUpdate" data-evtparam="bullets" data-r="nav.bullets.direction" value="horizontal"><label_sub><?php _e('Horizontal', 'revslider');?></label_sub><span class="linebreak"></span>
						<input class="sliderinput easyinit" type="radio" name="sr_bulletdirection" data-evt="sliderNavPositionUpdate" data-evtparam="bullets" data-r="nav.bullets.direction" value="vertical"><label_sub><?php _e('Vertical', 'revslider');?></label_sub>
					</div>
					<div class="div10"></div>

					<!-- BULLETS POSITION -->
					<label_a><?php _e('Aligned by', 'revslider');?></label_a>
					<div class="radiooption">
						<input class="sliderinput easyinit" type="radio" name="sr_bulletsalign" data-evt="sliderNavPositionUpdate" data-evtparam="bullets" data-r="nav.bullets.align" value="slider"><label_sub><?php _e('Module Dimension', 'revslider');?></label_sub><span class="linebreak"></span>
						<input class="sliderinput easyinit" type="radio" name="sr_bulletsalign" data-evt="sliderNavPositionUpdate" data-evtparam="bullets" data-r="nav.bullets.align" value="grid"><label_sub><?php _e('Content', 'revslider');?></label_sub>
					</div>
					<div class="div20"></div>

					<select style="display:none" data-evt="sliderNavPositionUpdate" data-evtparam="bullets" id="sr_bulletshor" data-unselect=".bulletspos_selector" data-select="#bulletspos_selector_*val*-*RVAL*" data-rval="settings.nav.bullets.vertical" class="sliderinput easyinit" data-r="nav.bullets.horizontal" data-triggerinp="#nav_bullets_offsetx" data-triggerinpval="0"><option value="left"><?php _e('Left', 'revslider');?></option><option value="center"><?php _e('Center', 'revslider');?></option><option value="right"><?php _e('Right', 'revslider');?></option></select>
					<select style="display:none" data-evt="sliderNavPositionUpdate" data-evtparam="bullets" id="sr_bulletsver" data-unselect=".bulletspos_selector" data-select="#bulletspos_selector_*RVAL*-*val*" data-rval="settings.nav.bullets.horizontal" class="sliderinput easyinit" data-r="nav.bullets.vertical" data-triggerinp="#nav_bullets_offsety" data-triggerinpval="0"><option value="top"><?php _e('Top', 'revslider');?></option><option value="center"><?php _e('Center', 'revslider');?></option><option value="bottom"><?php _e('Bottom', 'revslider');?></option></select>
					<row class="direktrow">
						<onelong>
							<label_a><?php _e('Aligment', 'revslider');?></label_a>
							<div class="bg_alignselector_wrap">
								<div class="bg_align_row">
									<div data-type="bullets" class="navaligntrigger bulletspos_selector bg_alignselector" data-select="#sr_bulletshor,#sr_bulletsver" data-val="left,top" id="bulletspos_selector_left-top"></div>
									<div data-type="bullets" class="navaligntrigger bulletspos_selector bg_alignselector" data-select="#sr_bulletshor,#sr_bulletsver" data-val="center,top" id="bulletspos_selector_center-top"></div>
									<div data-type="bullets" class="navaligntrigger bulletspos_selector bg_alignselector" data-select="#sr_bulletshor,#sr_bulletsver" data-val="right,top" id="bulletspos_selector_right-top"></div>
								</div>
								<div class="bg_align_row">
									<div data-type="bullets" class="navaligntrigger bulletspos_selector bg_alignselector" data-select="#sr_bulletshor,#sr_bulletsver" data-val="left,center" id="bulletspos_selector_left-center"></div>
									<div data-type="bullets" class="navaligntrigger bulletspos_selector bg_alignselector" data-select="#sr_bulletshor,#sr_bulletsver" data-val="center,center" id="bulletspos_selector_center-center"></div>
									<div data-type="bullets" class="navaligntrigger bulletspos_selector bg_alignselector" data-select="#sr_bulletshor,#sr_bulletsver" data-val="right,center" id="bulletspos_selector_right-center"></div>
								</div>
								<div class="bg_align_row">
									<div data-type="bullets" class="navaligntrigger bulletspos_selector bg_alignselector" data-select="#sr_bulletshor,#sr_bulletsver" data-val="left,bottom" id="bulletspos_selector_left-bottom"></div>
									<div data-type="bullets" class="navaligntrigger bulletspos_selector bg_alignselector" data-select="#sr_bulletshor,#sr_bulletsver" data-val="center,bottom" id="bulletspos_selector_center-bottom"></div>
									<div data-type="bullets" class="navaligntrigger bulletspos_selector bg_alignselector" data-select="#sr_bulletshor,#sr_bulletsver" data-val="right,bottom" id="bulletspos_selector_right-bottom"></div>
								</div>
							</div>
						</onelong>
						<oneshort>
							<label_icon class="ui_x"></label_icon><input class="sliderinput valueduekeyboard  easyinit" data-r="nav.bullets.offsetX" data-evt="sliderNavPositionUpdate" data-numeric="true" data-allowed="px" data-evtparam="bullets" data-min="-1200" data-max="1200" type="text" id="nav_bullets_offsetx">
							<label_icon class="ui_y"></label_icon><input class="sliderinput valueduekeyboard  easyinit" data-r="nav.bullets.offsetY" data-evt="sliderNavPositionUpdate" data-numeric="true" data-allowed="px" data-evtparam="bullets" data-min="-1200" data-max="1200" type="text" id="nav_bullets_offsety">
						</oneshort>
					</row>
				</div>
			</div>

			<div id="form_nav_bullets_visi" class="form_inner form_menu_inside open">
				<div class="form_inner_header"><i class="material-icons">visibility</i><?php _e('Bullets Visibility', 'revslider');?></div>
				<!--<div class="form_intoaccordion" data-trigger="#sr_na_bul_1"><i class="material-icons">arrow_drop_down</i></div>-->
				<div class="collapsable">
					<label_a><?php _e('Animation', 'revslider');?></label_a><select  id="sr_bullets_animation"  data-r="nav.bullets.anim" class="sliderinput tos2 nosearchbox easyinit">						
						<option value="fade"><?php _e('Fade', 'revslider');?></option>
						<option value="left"><?php _e('From Left', 'revslider');?></option>
						<option value="right"><?php _e('From Right', 'revslider');?></option>
						<option value="top"><?php _e('From Top', 'revslider');?></option>
						<option value="bottom"><?php _e('From Bottom', 'revslider');?></option>
						<option value="zoomin"><?php _e('Zoom In', 'revslider');?></option>
						<option value="zoomout"><?php _e('Zoom Out', 'revslider');?></option>
					</select>
					<label_a><?php _e('Show Speed', 'revslider');?></label_a><input class="sliderinput valueduekeyboard  easyinit" data-numeric="true" data-allowed="ms" data-r="nav.bullets.animSpeed" data-min="1" data-max="10000" type="text" id="nav_bullet_animSpeed"><span class="linebreak"></span>
					<label_a><?php _e('Show Delay', 'revslider');?></label_a><input class="sliderinput valueduekeyboard easyinit" data-numeric="true" data-allowed="ms" data-r="nav.bullets.animDelay" data-min="1" data-max="10000" type="text" id="nav_bullet_animDelay"><span class="linebreak"></span>
					<div class="div10"></div>
					<label_a><?php _e('RTL Direction', 'revslider');?></label_a><input type="checkbox"  id="sr_bulletrtl" class="sliderinput easyinit" data-r="nav.bullets.rtl"/><span class="linebreak"></span>
					<row class="directrow">
						<onelong><label_a><?php _e('Show Always', 'revslider');?></label_a><input type="checkbox"  id="sr_bulletsalwshow" class="sliderinput easyinit" data-r="nav.bullets.alwaysOn" data-showhide="#nav_bullets_alwaysshow" data-showhidedep="false"/></onelong>
						<oneshort id="nav_bullets_alwaysshow">
							<label_icon class="ui_desktop"></label_icon><input data-numeric="true" data-allowed="ms" class="sliderinput valueduekeyboard  easyinit" data-r="nav.bullets.hideDelay" data-min="0" data-max="5000" type="text" id="nav_bullets_hideDelay"/><span class="linebreak"></span>
							<label_icon class="ui_notebook"></label_icon><input data-numeric="true" data-allowed="ms" class="sliderinput valueduekeyboard  easyinit" data-r="nav.bullets.hideDelayMobile" data-min="0" data-max="5000" type="text" id="nav_bullets_hideDelayMobile"/>
							<div class="div10"></div>
						</oneshort>
					</row>

					<row class="direktrow">
						<onelong><label_a><?php _e('Hide Under', 'revslider');?></label_a><input type="checkbox"  id="sr_bulletshideunder" class="sliderinput easyinit" data-r="nav.bullets.hideUnder" data-showhide="#nav_bullets_hideunderlimit_wr" data-showhidedep="true"/></onelong>
						<oneshort id="nav_bullets_hideunderlimit_wr"><label_icon class="ui_maxwidth"></label_icon><input data-numeric="true" data-allowed="px" class="sliderinput valueduekeyboard  easyinit" data-r="nav.bullets.hideUnderLimit" data-min="0" data-max="2400" type="text" id="nav_bullets_hideunderlimit" ></oneshort>
					</row>

					<row class="direktrow">
						<onelong><label_a><?php _e('Hide Over', 'revslider');?></label_a><input type="checkbox"  id="sr_bulletshideover" class="sliderinput easyinit" data-r="nav.bullets.hideOver" data-showhide="#nav_bullets_hideoverlimit_wr" data-showhidedep="true"/></onelong>
						<oneshort id="nav_bullets_hideoverlimit_wr"><label_icon class="ui_minwidth"></label_icon><input data-numeric="true" data-allowed="px" class="sliderinput valueduekeyboard  easyinit" data-r="nav.bullets.hideOverLimit" data-min="0" data-max="2400" type="text" id="nav_bullets_hideoverlimit" ></oneshort>
					</row>
				</div>
			</div>

			<div id="form_nav_bullets_style" class="form_inner form_menu_inside open">
				<div class="form_inner_header"><i class="material-icons">palette</i><?php _e('Navigation Style', 'revslider');?></div>
				<div class="collapsable">
					<div id="sr_bullets_styles_fieldset"></div>
				</div>
			</div>

			<div id="form_nav_bullets_style" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">palette</i><?php _e('Global Style Presets', 'revslider');?></div>
				<!--<div class="form_intoaccordion" data-trigger="#sr_na_arr_2"><i class="material-icons">arrow_drop_down</i></div>-->
				<div class="collapsable">
					<label_a><?php _e('Preset', 'revslider');?></label_a><select id="sr_bullets_style_preset" data-tags="true" data-r="nav.bullets.preset" class="sliderinput tos2 searchbox easyinit" ></select>
					<label_a></label_a><div data-evt="sliderNavPreset" data-evtparam="bullets" class="callEventButton basic_action_button autosize"><i class="material-icons">save</i><?php _e('Load', 'revslider');?></div>
					<div data-evt="saveNavPreset" data-evtparam="bullets" class="callEventButton basic_action_button autosize"><i class="material-icons">save</i><?php _e('Save', 'revslider');?></div><span class="linebreak"></span>
					<label_a></label_a><div data-evt="deleteNavPreset" data-evtparam="bullets" class="callEventButton basic_action_button autosize"><i class="material-icons">delete</i><?php _e('Delete', 'revslider');?></div>
				</div>
			</div>

			<!-- SLIDE LOCAL BULLETS STYLE-->
			<div id="form_slide_nav_bullets" class="form_inner form_menu_inside open">
				<!-- SLIDE BULLETS SETTING -->
				<div class="form_inner_header"><i class="material-icons">texture</i><?php _e('Override Style on Slide', 'revslider');?></div>
				<!--<div class="form_intoaccordion" data-trigger="#sr_na_bul_21"><i class="material-icons">arrow_drop_down</i></div>-->

				<div class="collapsable carouselenable standardenable herodisable">
					<div id="sl_bullets_styles_fieldset">
					</div>
				</div>

			</div><!-- END OF SLIDE LOCAL BULLERS STYLE-->
		</div><!-- END OF BULLETS SETTINGS -->


		<!--  TABS SETTING -->
		<div id="form_nav_tabs" data-select="#gst_nav_4" data-unselect=".nav_submodule_trigger" class="formcontainer form_menu_inside carouselenable standardenable herodisable collapsed">
			<div class="collectortabwrap"><div id="collectortab_form_nav_tab" class="collectortab form_menu_inside" data-forms='["#form_nav_tabs"]'><i class="material-icons">view_column</i><?php _e('Tabs', 'revslider');?></div></div>

			<!--<div id="nav_tabs_settings_arrow" class="form_intoaccordion"><i class="material-icons">arrow_drop_down</i></div>-->
			<ul class="form_menu_level_1">
				<li data-target="#form_nav_tabs_mainstyle" class="selected form_menu_level_1_li" id="sr_na_tab_0"><?php _e('Main Style', 'revslider');?></li>
				<li data-target="#form_nav_tabs_visi" class="selected form_menu_level_1_li" id="sr_na_tab_1"><?php _e('Visibility', 'revslider');?></li>
				<li data-target="#form_nav_tabs_posi" class="selected form_menu_level_1_li" id="sr_na_tab_11"><?php _e('Position', 'revslider');?></li>
				<li data-target="#form_nav_tabs_size" class="selected form_menu_level_1_li" id="sr_na_tab_12"><?php _e('Size', 'revslider');?></li>
				<li data-target="#form_nav_tabs_offsets" class="selected form_menu_level_1_li" id="sr_na_tab_19"><?php _e('Mask', 'revslider');?></li>
				<li data-target="#form_nav_tabs_wrap" class="selected form_menu_level_1_li" id="sr_na_tab_13"><?php _e('Wrapper', 'revslider');?></li>
				<li data-target="#form_nav_tabs_style" class="form_menu_level_1_li" id="sr_na_tab_2"><?php _e('Style', 'revslider');?></li>
				<li data-target="#form_slide_nav_tabs" class="form_menu_level_1_li" id="sr_na_tab_21"><?php _e('Style', 'revslider');?></li>
			</ul>

			<div id="form_nav_tabs_mainstyle" class="form_inner form_menu_inside open">
				<div class="form_inner_header"><i class="material-icons">opacity</i><?php _e('Tabs Type', 'revslider');?></div>
				<div class="on_off_navig_wrap"><input type="checkbox"  id="sr_usenavtabs" class="sliderinput easyinit nav-enable" data-evt="sliderNavUpdate" data-evtparam="tabs" data-showhide="#tabs_style_collapsable, #form_nav_tabs_posi,#form_nav_tabs_size,#form_nav_tabs_offsets,  #form_nav_tabs_wrap, #form_nav_tabs_visi, #form_nav_tabs_style, #form_slide_nav_tabs" data-showhidedep="true"  data-r="nav.tabs.set" /></div>
				<!--<div class="form_intoaccordion" data-trigger="#sr_na_tab_0"><i class="material-icons">arrow_drop_down</i></div>-->
				<div id="tabs_style_collapsable" class="collapsable">
					<label_a><?php _e('Tabs Style', 'revslider');?></label_a><select  id="sr_tabs_style"  data-evt="sliderNavUpdate" data-evtparam="tabs" data-r="nav.tabs.style" class="sliderinput tos2 nosearchbox easyinit sr_nav_style_tos">
						<option value=""><?php _e('No Style', 'revslider');?></option>
					</select>
				</div>
			</div>

			<div id="form_nav_tabs_posi" class="form_inner form_menu_inside open">
				<div class="form_inner_header"><i class="material-icons">open_with</i><?php _e('Position', 'revslider');?></div>
				<!--<div class="form_intoaccordion" data-trigger="#sr_na_tab_11"><i class="material-icons">arrow_drop_down</i></div>-->
				<div class="collapsable">
					<label_a><?php _e('Orientation', 'revslider');?></label_a>
					<div class="radiooption">
						<input class="sliderinput easyinit" type="radio" name="sr_tabsdirection" data-evt="sliderNavPositionUpdate" data-evtparam="tabs" data-r="nav.tabs.direction" value="horizontal"><label_sub><?php _e('Horizontal', 'revslider');?></label_sub><span class="linebreak"></span>
						<input class="sliderinput easyinit" type="radio" name="sr_tabsdirection" data-evt="sliderNavPositionUpdate" data-evtparam="tabs" data-r="nav.tabs.direction" value="vertical"><label_sub><?php _e('Vertical', 'revslider');?></label_sub>
					</div>
					<div class="div10"></div>

					<!-- TABS POSITION -->
					<label_a><?php _e('Aligned by', 'revslider');?></label_a>
					<div class="radiooption">
						<input class="sliderinput easyinit" type="radio" name="sr_tabsalign" data-evt="sliderNavPositionUpdate" data-evtparam="tabs" data-r="nav.tabs.align" value="slider"><label_sub><?php _e('Module Dimension', 'revslider');?></label_sub><span class="linebreak"></span>
						<input class="sliderinput easyinit" type="radio" name="sr_tabsalign" data-evt="sliderNavPositionUpdate" data-evtparam="tabs" data-r="nav.tabs.align" value="grid"><label_sub><?php _e('Content', 'revslider');?></label_sub>
					</div>
					<div class="div10"></div>


					<label_a><?php _e('Inner / Outer', 'revslider');?></label_a>
					<div class="radiooption">
						<input class="sliderinput easyinit" type="radio" name="sr_tabsinnerouter" data-evt="navinnerouter" data-evtparam="tabs" data-r="nav.tabs.innerOuter" value="inner"><label_sub><?php _e('Inner', 'revslider');?></label_sub><span class="linebreak"></span>
						<input class="sliderinput easyinit" type="radio" name="sr_tabsinnerouter" data-evt="navinnerouter" data-evtparam="tabs" data-r="nav.tabs.innerOuter" value="outer-vertical"><label_sub><?php _e('Outer Vertical', 'revslider');?></label_sub><span class="linebreak"></span>
						<input class="sliderinput easyinit" type="radio" name="sr_tabsinnerouter" data-evt="navinnerouter" data-evtparam="tabs" data-r="nav.tabs.innerOuter" value="outer-horizontal"><label_sub><?php _e('Outer Horizontal', 'revslider');?></label_sub>
					</div>

					<div class="div20"></div>
					<select style="display:none" data-evt="sliderNavPositionUpdate" data-evtparam="tabs" id="sr_tabshor" data-unselect=".tabspos_selector" data-select="#tabspos_selector_*val*-*RVAL*" data-rval="settings.nav.tabs.vertical" class="sliderinput easyinit" data-r="nav.tabs.horizontal" data-triggerinp="#nav_tabs_offsetx" data-triggerinpval="0"><option value="left"><?php _e('Left', 'revslider');?></option><option value="center"><?php _e('Center', 'revslider');?></option><option value="right"><?php _e('Right', 'revslider');?></option></select>
					<select style="display:none" data-evt="sliderNavPositionUpdate" data-evtparam="tabs" id="sr_tabsver" data-unselect=".tabspos_selector" data-select="#tabspos_selector_*RVAL*-*val*" data-rval="settings.nav.tabs.horizontal" class="sliderinput easyinit" data-r="nav.tabs.vertical" data-triggerinp="#nav_tabs_offsety" data-triggerinpval="0"><option value="top"><?php _e('Top', 'revslider');?></option><option value="center"><?php _e('Center', 'revslider');?></option><option value="bottom"><?php _e('Bottom', 'revslider');?></option></select>
					<row class="direktrow">
						<onelong>
							<label_a><?php _e('Aligment', 'revslider');?></label_a>
							<div class="bg_alignselector_wrap">
								<div class="bg_align_row">
									<div data-type="tabs" class="navaligntrigger tabspos_selector bg_alignselector" data-select="#sr_tabshor,#sr_tabsver" data-val="left,top" id="tabspos_selector_left-top"></div>
									<div data-type="tabs" class="navaligntrigger tabspos_selector bg_alignselector" data-select="#sr_tabshor,#sr_tabsver" data-val="center,top" id="tabspos_selector_center-top"></div>
									<div data-type="tabs" class="navaligntrigger tabspos_selector bg_alignselector" data-select="#sr_tabshor,#sr_tabsver" data-val="right,top" id="tabspos_selector_right-top"></div>
								</div>
								<div class="bg_align_row">
									<div data-type="tabs" class="navaligntrigger tabspos_selector bg_alignselector" data-select="#sr_tabshor,#sr_tabsver" data-val="left,center" id="tabspos_selector_left-center"></div>
									<div data-type="tabs" class="navaligntrigger tabspos_selector bg_alignselector" data-select="#sr_tabshor,#sr_tabsver" data-val="center,center" id="tabspos_selector_center-center"></div>
									<div data-type="tabs" class="navaligntrigger tabspos_selector bg_alignselector" data-select="#sr_tabshor,#sr_tabsver" data-val="right,center" id="tabspos_selector_right-center"></div>
								</div>
								<div class="bg_align_row">
									<div data-type="tabs" class="navaligntrigger tabspos_selector bg_alignselector" data-select="#sr_tabshor,#sr_tabsver" data-val="left,bottom" id="tabspos_selector_left-bottom"></div>
									<div data-type="tabs" class="navaligntrigger tabspos_selector bg_alignselector" data-select="#sr_tabshor,#sr_tabsver" data-val="center,bottom" id="tabspos_selector_center-bottom"></div>
									<div data-type="tabs" class="navaligntrigger tabspos_selector bg_alignselector" data-select="#sr_tabshor,#sr_tabsver" data-val="right,bottom" id="tabspos_selector_right-bottom"></div>
								</div>
							</div>
						</onelong>
						<oneshort>
							<label_icon class="ui_x"></label_icon><input class="sliderinput valueduekeyboard  easyinit" data-r="nav.tabs.offsetX" data-evt="sliderNavPositionUpdate" data-evtparam="tabs" data-min="-1200" data-max="1200" type="text" id="nav_tabs_offsetx">
							<label_icon class="ui_y"></label_icon><input class="sliderinput valueduekeyboard  easyinit" data-r="nav.tabs.offsetY" data-evt="sliderNavPositionUpdate" data-evtparam="tabs" data-min="-1200" data-max="1200" type="text" id="nav_tabs_offsety" >
						</oneshort>
					</row>
					<label_a><?php _e('Visible amount', 'revslider');?></label_a><input class="sliderinput valueduekeyboard  easyinit" data-evt="sliderNavPositionUpdate" data-evtparam="tabs" data-r="nav.tabs.amount" data-min="1" data-max="100" type="text" id="nav_tabs_amount" >
				</div>
			</div>



			<div id="form_nav_tabs_size" class="form_inner form_menu_inside open">
				<div class="form_inner_header"><i class="material-icons">photo_size_select_large</i><?php _e('Size', 'revslider');?></div>
				<!--<div class="form_intoaccordion" data-trigger="#sr_na_tab_12"><i class="material-icons">arrow_drop_down</i></div>-->
				<div class="collapsable">
					<row class="directrow">
						<onelong><label_icon class="ui_gap"></label_icon><input class="sliderinput valueduekeyboard  easyinit" data-evt="sliderNavPositionUpdate" data-evtparam="tabs" data-r="nav.tabs.space" data-min="-500" data-max="500" type="text" id="nav_tabs_space" ></onelong>
						<oneshort><label_icon class="ui_minwidth"></label_icon><input class="sliderinput valueduekeyboard  easyinit" data-r="nav.tabs.widthMin" data-min="0" data-max="5000" type="text" id="nav_tabs_widthMin" ></oneshort>
					</row>
					<!-- TABS SIZING -->
					<row class="directrow">
						<onelong><label_icon class="ui_width"></label_icon><input class="sliderinput valueduekeyboard  easyinit" data-evt="sliderNavPositionUpdate" data-evtparam="tabs" data-r="nav.tabs.width" data-min="0" data-max="5000" type="text" id="nav_tabs_width" ></onelong>
						<oneshort><label_icon class="ui_height"></label_icon><input class="sliderinput valueduekeyboard  easyinit" data-evt="sliderNavPositionUpdate" data-evtparam="tabs" data-r="nav.tabs.height" data-min="0" data-max="5000" type="text" id="nav_tabs_height" ></oneshort>
					</row>
				</div>
			</div>

			<div id="form_nav_tabs_offsets" class="form_inner form_menu_inside open">
				<div class="form_inner_header"><i class="material-icons">photo_size_select_large</i><?php _e('Mask Offset', 'revslider');?></div>
				<!--<div class="form_intoaccordion" data-trigger="#sr_na_tab_19"><i class="material-icons">arrow_drop_down</i></div>-->
				<div class="collapsable">
					<!-- TABS MASK OFFSET -->
					<row class="directrow">
					<onelong><label_icon class="ui_margin_left"></label_icon><input class="sliderinput valueduekeyboard  easyinit" data-evt="sliderNavPositionUpdate" data-evtparam="tabs" data-r="nav.tabs.mhoffset" data-min="0" data-max="500" type="text" id="nav_tabs_mhoffset" ></onelong>
					<oneshort><label_icon class="ui_margin_top"></label_icon><input class="sliderinput valueduekeyboard  easyinit" data-evt="sliderNavPositionUpdate" data-evtparam="tabs" data-r="nav.tabs.mvoffset" data-min="0" data-max="500" type="text" id="nav_tabs_mvoffset" ></oneshort>
					</row>
				</div>
			</div>

			<div id="form_nav_tabs_wrap" class="form_inner form_menu_inside open">
				<div class="form_inner_header"><i class="material-icons">more</i><?php _e('Wrapper', 'revslider');?></div>
				<!--<div class="form_intoaccordion" data-trigger="#sr_na_tab_13"><i class="material-icons">arrow_drop_down</i></div>-->
				<div class="collapsable">
					<!-- WRAPPER -->
					<label_a style="padding:0px"><label_icon class="ui_bg"></label_icon></label_a><input type="text" data-editing="Tab Wrapper BG Color" data-evt="sliderTabBgColor" name="sliderTabBgColor" id="sliderTabBgColor" data-visible="true" class="my-color-field sliderinput easyinit" data-r="nav.tabs.wrapperColor" value="transparent">
					<div class="div10"></div>
					<label_a style="padding:0px"><label_icon class="ui_padding"></label_icon></label_a><input class="sliderinput valueduekeyboard  easyinit" data-evt="sliderNavPositionUpdate" data-evtparam="tabs" data-r="nav.tabs.padding" data-min="0" data-max="5000" type="text" id="nav_tabs_padding" >
					<span class="linebreak"></span>
					<label_a><?php _e('Span', 'revslider');?></label_a><input type="checkbox" id="sr_tabspan" class="sliderinput easyinit" data-r="nav.tabs.spanWrapper" data-evt="sliderNavPositionUpdate" data-evtparam="tabs"/>
				</div>
			</div>

			<div id="form_nav_tabs_visi" class="form_inner form_menu_inside open">
				<div class="form_inner_header"><i class="material-icons">visibility</i><?php _e('Tabs Visibility', 'revslider');?></div>
				<!--<div class="form_intoaccordion" data-trigger="#sr_na_tab_1"><i class="material-icons">arrow_drop_down</i></div>-->
				<div class="collapsable">
					<label_a><?php _e('Animation', 'revslider');?></label_a><select  id="sr_tabs_animation"  data-r="nav.tabs.anim" class="sliderinput tos2 nosearchbox easyinit">						
						<option value="fade"><?php _e('Fade', 'revslider');?></option>
						<option value="left"><?php _e('From Left', 'revslider');?></option>
						<option value="right"><?php _e('From Right', 'revslider');?></option>
						<option value="top"><?php _e('From Top', 'revslider');?></option>
						<option value="bottom"><?php _e('From Bottom', 'revslider');?></option>
						<option value="zoomin"><?php _e('Zoom In', 'revslider');?></option>
						<option value="zoomout"><?php _e('Zoom Out', 'revslider');?></option>
					</select>
					<label_a><?php _e('Show Speed', 'revslider');?></label_a><input class="sliderinput valueduekeyboard  easyinit" data-numeric="true" data-allowed="ms" data-r="nav.tabs.animSpeed" data-min="1" data-max="10000" type="text" id="nav_tab_animSpeed"><span class="linebreak"></span>
					<label_a><?php _e('Show Delay', 'revslider');?></label_a><input class="sliderinput valueduekeyboard easyinit" data-numeric="true" data-allowed="ms" data-r="nav.tabs.animDelay" data-min="1" data-max="10000" type="text" id="nav_tab_animDelay"><span class="linebreak"></span>					
					<label_a><?php _e('RTL Direction', 'revslider');?></label_a><input type="checkbox"  id="sr_tabsrtl" class="sliderinput easyinit" data-r="nav.tabs.rtl"/><span class="linebreak"></span>
					<row class="directrow">
						<onelong><label_a><?php _e('Show Always', 'revslider');?></label_a><input type="checkbox"  id="sr_tabsalwshow" class="sliderinput easyinit" data-r="nav.tabs.alwaysOn" data-showhide="#nav_tabs_alwaysshow" data-showhidedep="false"/></onelong>
						<oneshort id="nav_tabs_alwaysshow">
							<label_icon class="ui_desktop"></label_icon><input data-numeric="true" data-allowed="ms" class="sliderinput valueduekeyboard  easyinit" data-r="nav.tabs.hideDelay" data-min="0" data-max="5000" type="text" id="nav_tabs_hideDelay"/><span class="linebreak"></span>
							<label_icon class="ui_notebook"></label_icon><input data-numeric="true" data-allowed="ms" class="sliderinput valueduekeyboard  easyinit" data-r="nav.tabs.hideDelayMobile" data-min="0" data-max="5000" type="text" id="nav_tabs_hideDelayMobile"/>
							<div class="div10"></div>
						</oneshort>
					</row>

					<row class="direktrow">
						<onelong><label_a><?php _e('Hide Under', 'revslider');?></label_a><input type="checkbox"  id="sr_tabshideunder" class="sliderinput easyinit" data-r="nav.tabs.hideUnder" data-showhide="#nav_tabs_hideunderlimit_wr" data-showhidedep="true"/></onelong>
						<oneshort id="nav_tabs_hideunderlimit_wr"><label_icon class="ui_maxwidth"></label_icon><input data-numeric="true" data-allowed="px" class="sliderinput valueduekeyboard  easyinit" data-r="nav.tabs.hideUnderLimit" data-min="0" data-max="2400" type="text" id="nav_tabs_hideunderlimit" ></oneshort>
					</row>

					<row class="direktrow">
						<onelong><label_a><?php _e('Hide Over', 'revslider');?></label_a><input type="checkbox"  id="sr_tabshideover" class="sliderinput easyinit" data-r="nav.tabs.hideOver" data-showhide="#nav_tabs_hideoverlimit_wr" data-showhidedep="true"/></onelong>
						<oneshort id="nav_tabs_hideoverlimit_wr"><label_icon class="ui_minwidth"></label_icon><input data-numeric="true" data-allowed="px" class="sliderinput valueduekeyboard  easyinit" data-r="nav.tabs.hideOverLimit" data-min="0" data-max="2400" type="text" id="nav_tabs_hideoverlimit" ></oneshort>
					</row>
				</div>
			</div>

			<div id="form_nav_tabs_style" class="form_inner form_menu_inside open">
				<div class="form_inner_header"><i class="material-icons">palette</i><?php _e('Style Global', 'revslider');?></div>
				<div class="collapsable">
					<div id="sr_tabs_styles_fieldset"></div>
				</div>
			</div>

			<div id="form_nav_tabs_style" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">palette</i><?php _e('Global Style Presets', 'revslider');?></div>
				<div class="collapsable">
					<label_a><?php _e('Preset', 'revslider');?></label_a><select id="sr_tabs_style_preset" data-tags="true" data-r="nav.tabs.preset" class="sliderinput tos2 searchbox easyinit" ></select>
					<label_a></label_a><div data-evt="sliderNavPreset" data-evtparam="tabs" class="callEventButton basic_action_button autosize"><i class="material-icons">save</i><?php _e('Load', 'revslider');?></div>
					<div data-evt="saveNavPreset" data-evtparam="tabs" class="callEventButton basic_action_button autosize"><i class="material-icons">save</i><?php _e('Save', 'revslider');?></div><span class="linebreak"></span>
					<label_a></label_a><div data-evt="deleteNavPreset" data-evtparam="tabs" class="callEventButton basic_action_button autosize"><i class="material-icons">delete</i><?php _e('Delete', 'revslider');?></div>
				</div>
			</div>

			<!-- SLIDE TABS STYLE -->
			<div id="form_slide_nav_tabs" class="form_inner form_menu_inside open">
				<div class="form_inner_header"><i class="material-icons">texture</i><?php _e('Override Style on Slide', 'revslider');?></div>
				<!--<div class="form_intoaccordion" data-trigger="#sr_na_tab_21"><i class="material-icons">arrow_drop_down</i></div>-->

				<div class="collapsable carouselenable standardenable herodisable">
					<div id="sl_tabs_styles_fieldset">
					</div>
				</div>
			</div><!-- END OF SLIDE TABS STYLE -->
		</div><!-- END OF TABS SETTINGS -->

		<!--  THUMB SETTING -->
		<div id="form_nav_thumbs" data-select="#gst_nav_5" data-unselect=".nav_submodule_trigger" class="formcontainer form_menu_inside carouselenable standardenable herodisable collapsed">
			<div class="collectortabwrap"><div id="collectortab_form_nav_thumb" class="collectortab form_menu_inside" data-forms='["#form_nav_thumbs"]'><i class="material-icons">filter_frames</i><?php _e('Thumbs', 'revslider');?></div></div>
			<!--<div id="nav_thumbs_settings_arrow" class="form_intoaccordion"><i class="material-icons">arrow_drop_down</i></div>-->
			<ul class="form_menu_level_1">
				<li data-target="#form_nav_thumbs_mainstyle" class="selected form_menu_level_1_li" id="sr_na_thumb_0"><?php _e('Main Style', 'revslider');?></li>
				<li data-target="#form_nav_thumbs_visi" class="selected form_menu_level_1_li" id="sr_na_thumb_1"><?php _e('Visibility', 'revslider');?></li>
				<li data-target="#form_nav_thumbs_posi" class="selected form_menu_level_1_li" id="sr_na_thumb_11"><?php _e('Position', 'revslider');?></li>
				<li data-target="#form_nav_thumbs_size" class="selected form_menu_level_1_li" id="sr_na_thumb_12"><?php _e('Size', 'revslider');?></li>
				<li data-target="#form_nav_thumbs_offsets" class="selected form_menu_level_1_li" id="sr_na_thumb_19"><?php _e('Mask', 'revslider');?></li>
				<li data-target="#form_nav_thumbs_wrap" class="selected form_menu_level_1_li" id="sr_na_thumb_13"><?php _e('Wrapper', 'revslider');?></li>
				<li data-target="#form_nav_thumbs_style" class="form_menu_level_1_li" id="sr_na_thumb_2"><?php _e('Style', 'revslider');?></li>
				<li data-target="#form_slide_nav_thumbs" class="form_menu_level_1_li" id="sr_na_thumb_21"><?php _e('Style', 'revslider');?></li>
			</ul>

			<div id="form_nav_thumbs_mainstyle" class="form_inner form_menu_inside open">
				<div class="form_inner_header"><i class="material-icons">opacity</i><?php _e('Thumb Type', 'revslider');?></div>
				<div class="on_off_navig_wrap"><input type="checkbox"  id="sr_usenavthumbs" class="sliderinput easyinit nav-enable" data-evt="sliderNavUpdate" data-evtparam="thumbs" data-showhide="#thumbs_style_collapsable, #form_nav_thumbs_posi,#form_nav_thumbs_size,#form_nav_thumbs_offsets,#form_nav_thumbs_wrap,#form_nav_thumbs_visi,#form_nav_thumbs_style,#form_slide_nav_thumbs" data-showhidedep="true"  data-r="nav.thumbs.set" /></div>
				<!--<div class="form_intoaccordion" data-trigger="#sr_na_thumb_0"><i class="material-icons">arrow_drop_down</i></div>-->
				<div id="thumbs_style_collapsable" class="collapsable">
					<label_a><?php _e('Thumbs Style', 'revslider');?></label_a><select  id="sr_thumbs_style"  data-evt="sliderNavUpdate" data-evtparam="thumbs" data-r="nav.thumbs.style" class="sliderinput tos2 nosearchbox easyinit sr_nav_style_tos">
						<option value=""><?php _e('No Style', 'revslider');?></option>
					</select>
				</div>
			</div>

			<div id="form_nav_thumbs_posi" class="form_inner form_menu_inside open">
				<div class="form_inner_header"><i class="material-icons">open_with</i><?php _e('Position', 'revslider');?></div>
				<!--<div class="form_intoaccordion" data-trigger="#sr_na_thumb_11"><i class="material-icons">arrow_drop_down</i></div>-->
				<div class="collapsable">
					<label_a><?php _e('Orientation', 'revslider');?></label_a>
					<div class="radiooption">
						<input class="sliderinput easyinit" type="radio" name="sr_thumbsdirection" data-evt="sliderNavPositionUpdate" data-evtparam="thumbs" data-r="nav.thumbs.direction" value="horizontal"><label_sub><?php _e('Horizontal', 'revslider');?></label_sub><span class="linebreak"></span>
						<input class="sliderinput easyinit" type="radio" name="sr_thumbsdirection" data-evt="sliderNavPositionUpdate" data-evtparam="thumbs" data-r="nav.thumbs.direction" value="vertical"><label_sub><?php _e('Vertical', 'revslider');?></label_sub>
					</div>
					<div class="div10"></div>

					<!-- thumbs POSITION -->
					<label_a><?php _e('Aligned by', 'revslider');?></label_a>
					<div class="radiooption">
						<input class="sliderinput easyinit" type="radio" name="sr_thumbsalign" data-evt="sliderNavPositionUpdate" data-evtparam="thumbs" data-r="nav.thumbs.align" value="slider"><label_sub><?php _e('Slider', 'revslider');?></label_sub><span class="linebreak"></span>
						<input class="sliderinput easyinit" type="radio" name="sr_thumbsalign" data-evt="sliderNavPositionUpdate" data-evtparam="thumbs" data-r="nav.thumbs.align" value="grid"><label_sub><?php _e('Content', 'revslider');?></label_sub>
					</div>
					<div class="div10"></div>


					<label_a><?php _e('Inner / Outer', 'revslider');?></label_a>
					<div class="radiooption">
						<input class="sliderinput easyinit" type="radio" name="sr_thumbsinnerouter" data-evt="navinnerouter" data-evtparam="thumbs" data-r="nav.thumbs.innerOuter" value="inner"><label_sub><?php _e('Inner', 'revslider');?></label_sub><span class="linebreak"></span>
						<input class="sliderinput easyinit" type="radio" name="sr_thumbsinnerouter" data-evt="navinnerouter" data-evtparam="thumbs" data-r="nav.thumbs.innerOuter" value="outer-vertical"><label_sub><?php _e('Outer Vertical', 'revslider');?></label_sub><span class="linebreak"></span>
						<input class="sliderinput easyinit" type="radio" name="sr_thumbsinnerouter" data-evt="navinnerouter" data-evtparam="thumbs" data-r="nav.thumbs.innerOuter" value="outer-horizontal"><label_sub><?php _e('Outer Horizontal', 'revslider');?></label_sub>
					</div>

					<div class="div20"></div>
					<select style="display:none" data-evt="sliderNavPositionUpdate" data-evtparam="thumbs" id="sr_thumbshor" data-unselect=".thumbspos_selector" data-select="#thumbspos_selector_*val*-*RVAL*" data-rval="settings.nav.thumbs.vertical" class="sliderinput easyinit" data-r="nav.thumbs.horizontal" data-triggerinp="#nav_thumbs_offsetx" data-triggerinpval="0"><option value="left"><?php _e('Left', 'revslider');?></option><option value="center"><?php _e('Center', 'revslider');?></option><option value="right"><?php _e('Right', 'revslider');?></option></select>
					<select style="display:none" data-evt="sliderNavPositionUpdate" data-evtparam="thumbs" id="sr_thumbsver" data-unselect=".thumbspos_selector" data-select="#thumbspos_selector_*RVAL*-*val*" data-rval="settings.nav.thumbs.horizontal" class="sliderinput easyinit" data-r="nav.thumbs.vertical" data-triggerinp="#nav_thumbs_offsety" data-triggerinpval="0"><option value="top"><?php _e('Top', 'revslider');?></option><option value="center"><?php _e('Center', 'revslider');?></option><option value="bottom"><?php _e('Bottom', 'revslider');?></option></select>
					<row class="direktrow">
						<onelong>
							<label_a><?php _e('Aligment', 'revslider');?></label_a>
							<div class="bg_alignselector_wrap">
								<div class="bg_align_row">
									<div data-type="thumbs" class="navaligntrigger thumbspos_selector bg_alignselector" data-select="#sr_thumbshor,#sr_thumbsver" data-val="left,top" id="thumbspos_selector_left-top"></div>
									<div data-type="thumbs" class="navaligntrigger thumbspos_selector bg_alignselector" data-select="#sr_thumbshor,#sr_thumbsver" data-val="center,top" id="thumbspos_selector_center-top"></div>
									<div data-type="thumbs" class="navaligntrigger thumbspos_selector bg_alignselector" data-select="#sr_thumbshor,#sr_thumbsver" data-val="right,top" id="thumbspos_selector_right-top"></div>
								</div>
								<div class="bg_align_row">
									<div data-type="thumbs" class="navaligntrigger thumbspos_selector bg_alignselector" data-select="#sr_thumbshor,#sr_thumbsver" data-val="left,center" id="thumbspos_selector_left-center"></div>
									<div data-type="thumbs" class="navaligntrigger thumbspos_selector bg_alignselector" data-select="#sr_thumbshor,#sr_thumbsver" data-val="center,center" id="thumbspos_selector_center-center"></div>
									<div data-type="thumbs" class="navaligntrigger thumbspos_selector bg_alignselector" data-select="#sr_thumbshor,#sr_thumbsver" data-val="right,center" id="thumbspos_selector_right-center"></div>
								</div>
								<div class="bg_align_row">
									<div data-type="thumbs" class="navaligntrigger thumbspos_selector bg_alignselector" data-select="#sr_thumbshor,#sr_thumbsver" data-val="left,bottom" id="thumbspos_selector_left-bottom"></div>
									<div data-type="thumbs" class="navaligntrigger thumbspos_selector bg_alignselector" data-select="#sr_thumbshor,#sr_thumbsver" data-val="center,bottom" id="thumbspos_selector_center-bottom"></div>
									<div data-type="thumbs" class="navaligntrigger thumbspos_selector bg_alignselector" data-select="#sr_thumbshor,#sr_thumbsver" data-val="right,bottom" id="thumbspos_selector_right-bottom"></div>
								</div>
							</div>
						</onelong>
						<oneshort>
							<label_icon class="ui_x"></label_icon><input class="sliderinput valueduekeyboard  easyinit" data-r="nav.thumbs.offsetX" data-evt="sliderNavPositionUpdate" data-evtparam="thumbs" data-min="-1200" data-max="1200" type="text" id="nav_thumbs_offsetx">
							<label_icon class="ui_y"></label_icon><input class="sliderinput valueduekeyboard  easyinit" data-r="nav.thumbs.offsetY" data-evt="sliderNavPositionUpdate" data-evtparam="thumbs" data-min="-1200" data-max="1200" type="text" id="nav_thumbs_offsety" >
						</oneshort>
					</row>
					<label_a><?php _e('Visible amount', 'revslider');?></label_a><input class="sliderinput valueduekeyboard  easyinit" data-evt="sliderNavPositionUpdate" data-evtparam="thmbs" data-r="nav.thumbs.amount" data-min="1" data-max="100" type="text" id="nav_thumbs_amount" >
				</div>
			</div>

			<div id="form_nav_thumbs_size" class="form_inner form_menu_inside open">
				<div class="form_inner_header"><i class="material-icons">photo_size_select_large</i><?php _e('Size', 'revslider');?></div>
				<!--<div class="form_intoaccordion" data-trigger="#sr_na_thumb_12"><i class="material-icons">arrow_drop_down</i></div>-->
				<div class="collapsable">
					<row class="directrow">
						<onelong><label_icon class="ui_gap"></label_icon><input class="sliderinput valueduekeyboard  easyinit" data-evt="sliderNavPositionUpdate" data-evtparam="thumbs" data-r="nav.thumbs.space" data-min="-500" data-max="500" type="text" id="nav_thumbs_space" ></onelong>
						<oneshort><label_icon class="ui_minwidth"></label_icon><input class="sliderinput valueduekeyboard  easyinit" data-r="nav.thumbs.widthMin" data-min="0" data-max="5000" type="text" id="nav_thumbs_widthMin" ></oneshort>
					</row>
					<!-- thumbs SIZING -->
					<row class="directrow">
						<onelong><label_icon class="ui_width"></label_icon><input class="sliderinput valueduekeyboard  easyinit" data-evt="sliderNavPositionUpdate" data-evtparam="thumbs" data-r="nav.thumbs.width" data-min="0" data-max="5000" type="text" id="nav_thumbs_width" ></onelong>
						<oneshort><label_icon class="ui_height"></label_icon><input class="sliderinput valueduekeyboard  easyinit" data-evt="sliderNavPositionUpdate" data-evtparam="thumbs" data-r="nav.thumbs.height" data-min="0" data-max="5000" type="text" id="nav_thumbs_height" ></oneshort>
					</row>

				</div>
			</div>

			<div id="form_nav_thumbs_offsets" class="form_inner form_menu_inside open">
				<div class="form_inner_header"><i class="material-icons">photo_size_select_large</i><?php _e('Mask Offset', 'revslider');?></div>
				<!--<div class="form_intoaccordion" data-trigger="#sr_na_tab_19"><i class="material-icons">arrow_drop_down</i></div>-->
				<div class="collapsable">
					<!-- TABS MASK OFFSET -->
					<row class="directrow">
					<onelong><label_icon class="ui_margin_left"></label_icon><input class="sliderinput valueduekeyboard  easyinit" data-evt="sliderNavPositionUpdate" data-evtparam="thumbs" data-r="nav.thumbs.mhoffset" data-min="0" data-max="500" type="text" id="nav_thumbs_mhoffset" ></onelong>
					<oneshort><label_icon class="ui_margin_top"></label_icon><input class="sliderinput valueduekeyboard  easyinit" data-evt="sliderNavPositionUpdate" data-evtparam="thumbs" data-r="nav.thumbs.mvoffset" data-min="0" data-max="500" type="text" id="nav_thumbs_mvoffset" ></oneshort>
					</row>
				</div>
			</div>

			<div id="form_nav_thumbs_wrap" class="form_inner form_menu_inside open">
				<div class="form_inner_header"><i class="material-icons">more</i><?php _e('Wrapper', 'revslider');?></div>
				<!--<div class="form_intoaccordion" data-trigger="#sr_na_thumb_13"><i class="material-icons">arrow_drop_down</i></div>-->
				<div class="collapsable">
					<!-- WRAPPER -->
					<label_a style="padding:0px"><label_icon class="ui_bg"></label_icon></label_a><input type="text" data-editing="Thumb Wrapper BG Color" data-evt="sliderThumbBgColor" data-visible="true"  name="sliderThumbBgColor" id="sliderThumbBgColor" class="my-color-field sliderinput easyinit" data-r="nav.thumbs.wrapperColor" value="transparent">
					<div class="div10"></div>
					<label_a style="padding:0px"><label_icon class="ui_padding"></label_icon></label_a><input class="sliderinput valueduekeyboard  easyinit" data-evt="sliderNavPositionUpdate" data-evtparam="thumbs" data-r="nav.thumbs.padding" data-min="0" data-max="5000" type="text" id="nav_thumbs_padding">
					<span class="linebreak"></span>
					<label_a><?php _e('Span', 'revslider');?></label_a><input type="checkbox" id="sr_thumbspan" class="sliderinput easyinit" data-r="nav.thumbs.spanWrapper" data-evt="sliderNavPositionUpdate" data-evtparam="thumbs"/>
				</div>
			</div>

			<div id="form_nav_thumbs_visi" class="form_inner form_menu_inside open">
				<div class="form_inner_header"><i class="material-icons">visibility</i><?php _e('Thumbs Visibility', 'revslider');?></div>
				<!--<div class="form_intoaccordion" data-trigger="#sr_na_thumb_1"><i class="material-icons">arrow_drop_down</i></div>-->
				<div class="collapsable">
					<label_a><?php _e('Animation', 'revslider');?></label_a><select  id="sr_thumbs_animation"  data-r="nav.thumbs.anim" class="sliderinput tos2 nosearchbox easyinit">						
						<option value="fade"><?php _e('Fade', 'revslider');?></option>
						<option value="left"><?php _e('From Left', 'revslider');?></option>
						<option value="right"><?php _e('From Right', 'revslider');?></option>
						<option value="top"><?php _e('From Top', 'revslider');?></option>
						<option value="bottom"><?php _e('From Bottom', 'revslider');?></option>
						<option value="zoomin"><?php _e('Zoom In', 'revslider');?></option>
						<option value="zoomout"><?php _e('Zoom Out', 'revslider');?></option>
					</select>
					<label_a><?php _e('Show Speed', 'revslider');?></label_a><input class="sliderinput valueduekeyboard  easyinit" data-numeric="true" data-allowed="ms" data-r="nav.thumbs.animSpeed" data-min="1" data-max="10000" type="text" id="nav_thumb_animSpeed"><span class="linebreak"></span>
					<label_a><?php _e('Show Delay', 'revslider');?></label_a><input class="sliderinput valueduekeyboard easyinit" data-numeric="true" data-allowed="ms" data-r="nav.thumbs.animDelay" data-min="1" data-max="10000" type="text" id="nav_thumb_animDelay"><span class="linebreak"></span>
					<label_a><?php _e('RTL Direction', 'revslider');?></label_a><input type="checkbox"  id="sr_thumbsrtl" class="sliderinput easyinit" data-r="nav.thumbs.rtl"/><span class="linebreak"></span>
					<row class="directrow">
						<onelong><label_a><?php _e('Show Always', 'revslider');?></label_a><input type="checkbox"  id="sr_thumbsalwshow" class="sliderinput easyinit" data-r="nav.thumbs.alwaysOn" data-showhide="#nav_thumbs_alwaysshow" data-showhidedep="false"/></onelong>
						<oneshort id="nav_thumbs_alwaysshow">
							<label_icon class="ui_desktop"></label_icon><input data-numeric="true" data-allowed="ms" class="sliderinput valueduekeyboard  easyinit" data-r="nav.thumbs.hideDelay" data-min="0" data-max="5000" type="text" id="nav_thumbs_hideDelay"/><span class="linebreak"></span>
							<label_icon class="ui_notebook"></label_icon><input data-numeric="true" data-allowed="ms" class="sliderinput valueduekeyboard  easyinit" data-r="nav.thumbs.hideDelayMobile" data-min="0" data-max="5000" type="text" id="nav_thumbs_hideDelayMobile"/>
							<div class="div10"></div>
						</oneshort>
					</row>



					<row class="direktrow">
						<onelong><label_a><?php _e('Hide Under', 'revslider');?></label_a><input type="checkbox"  id="sr_thumbshideunder" class="sliderinput easyinit" data-r="nav.thumbs.hideUnder" data-showhide="#nav_thumbs_hideunderlimit_wr" data-showhidedep="true"/></onelong>
						<oneshort id="nav_thumbs_hideunderlimit_wr"><label_icon class="ui_maxwidth"></label_icon><input data-numeric="true" data-allowed="px" class="sliderinput valueduekeyboard  easyinit" data-r="nav.thumbs.hideUnderLimit" data-min="0" data-max="2400" type="text" id="nav_thumbs_hideunderlimit" ></oneshort>
					</row>

					<row class="direktrow">
						<onelong><label_a><?php _e('Hide Over', 'revslider');?></label_a><input type="checkbox"  id="sr_thumbshideover" class="sliderinput easyinit" data-r="nav.thumbs.hideOver" data-showhide="#nav_thumbs_hideoverlimit_wr" data-showhidedep="true"/></onelong>
						<oneshort id="nav_thumbs_hideoverlimit_wr"><label_icon class="ui_minwidth"></label_icon><input data-numeric="true" data-allowed="px" class="sliderinput valueduekeyboard  easyinit" data-r="nav.thumbs.hideOverLimit" data-min="0" data-max="2400" type="text" id="nav_thumbs_hideoverlimit" ></oneshort>
					</row>
				</div>
			</div>

			<div id="form_nav_thumbs_style" class="form_inner form_menu_inside open">
				<div class="form_inner_header"><i class="material-icons">palette</i><?php _e('Style Global', 'revslider');?></div>
				<div class="collapsable">
					<div id="sr_thumbs_styles_fieldset"></div>
				</div>
			</div>

			<div id="form_nav_thumbs_style" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">palette</i><?php _e('Global Style Presets', 'revslider');?></div>
				<div class="collapsable">
					<label_a><?php _e('Preset', 'revslider');?></label_a><select id="sr_thumbs_style_preset" data-tags="true" data-r="nav.thumbs.preset" class="searchbox sliderinput tos2 easyinit" ></select>
					<label_a></label_a><div data-evt="sliderNavPreset" data-evtparam="thumbs" class="callEventButton basic_action_button autosize"><i class="material-icons">save</i><?php _e('Load', 'revslider');?></div>
					<div data-evt="saveNavPreset" data-evtparam="thumbs" class="callEventButton basic_action_button autosize"><i class="material-icons">save</i><?php _e('Save', 'revslider');?></div><span class="linebreak"></span>
					<label_a></label_a><div data-evt="deleteNavPreset" data-evtparam="thumbs" class="callEventButton basic_action_button autosize"><i class="material-icons">delete</i><?php _e('Delete', 'revslider');?></div>
				</div>
			</div>

			<!-- SLIDE THUMBS STYLE -->
			<div id="form_slide_nav_thumbs" class="form_inner form_menu_inside open">
				<div class="form_inner_header"><i class="material-icons">texture</i><?php _e('Override Style on Slide', 'revslider');?></div>
				<!--<div class="form_intoaccordion" data-trigger="#sr_na_thumb_21"><i class="material-icons">arrow_drop_down</i></div>-->

				<div class="collapsable carouselenable standardenable herodisable">
					<div id="sl_thumbs_styles_fieldset">
					</div>
				</div>
			</div><!-- SLIDE THUMBS STYLE -->

		</div><!-- END OF THUMB SETTINGS -->

		<!-- PREVIEW IMAGE SETTINGS -->
		<div id="form_nav_pprevima" data-select="#gst_nav_6" data-unselect=".nav_submodule_trigger" class="formcontainer form_menu_inside collapsed">
			<div class="collectortabwrap"><div id="collectortab_form_pprevima" class="collectortab form_menu_inside" data-forms='["#form_nav_pprevima"]'><i class="material-icons">image</i><?php _e('Nav Image Dimensions', 'revslider');?></div></div>
			<!--<div class="form_intoaccordion"><i class="material-icons">arrow_drop_down</i></div>-->
			<div class="form_inner">
				<div class="form_inner_header"><i class="material-icons">image</i><?php _e('Preview Image', 'revslider');?></div>
				<!--<div class="form_intoaccordion" data-trigger="#sr_na_thumb_11"><i class="material-icons">arrow_drop_down</i></div>				-->
				<div class="collapsable" style="display:block;padding-bottom:0px">
					
					<!--<longoption><i class="material-icons">language</i><label_a ><?php _e('Image from Stream if exists', 'revslider');?></label_a><input type="checkbox" class="easyinit slideinput" data-r="thumb.fromStream"></longoption>-->
					<row>
						<onelong><label_icon class="ui_width"></label_icon><input class="sliderinput valueduekeyboard  easyinit"  data-allowed="px" data-numeric="true" data-r="nav.preview.width" data-min="0" data-max="1024" type="text" id="nav_prev_width" ></onelong>
						<oneshort><label_icon class="ui_height"></label_icon><input class="sliderinput valueduekeyboard  easyinit"  data-allowed="px" data-numeric="true"  data-r="nav.preview.height" data-min="0" data-max="1024" type="text" id="nav_prev_height" ></oneshort>
					</row>					
					
				</div>
			</div>
		</div><!-- PREVIEW IMAGE SETTINGS END -->

		<!-- TOUCH  SETTINGS -->
		<div id="form_nav_touch" data-select="#gst_nav_7" data-unselect=".nav_submodule_trigger" class="formcontainer form_menu_inside collapsed carouselenable standardenable herodisable">
			<div class="collectortabwrap"><div id="collectortab_form_touch" class="collectortab form_menu_inside" data-forms='["#form_nav_touch"]'><i class="material-icons">pan_tool</i><?php _e('Swipe Settings', 'revslider');?></div></div>
			<!--<div class="form_intoaccordion"><i class="material-icons">arrow_drop_down</i></div>-->
			<div class="form_inner">
				<div class="form_inner_header"><i class="material-icons">pan_tool</i><?php _e('Touch', 'revslider');?></div>
				<!--<div class="form_intoaccordion" data-trigger="#sr_na_thumb_11"><i class="material-icons">arrow_drop_down</i></div>				-->
				<div class="collapsable" style="display:block;padding-bottom:0px">
					<div class="carouselunavailable standardavailable sceneavailable">
						<longoption><i class="material-icons"></i><label_a><?php _e('Mobile Swipe Enabled', 'revslider');?></label_a><input type="checkbox"  id="sr_usetouch" class="sliderinput easyinit" data-r="nav.swipe.set"/></longoption>
						<longoption><i class="material-icons"></i><label_a><?php _e('Desktop Swipe Enabled', 'revslider');?></label_a><input type="checkbox"  id="sr_usetouchdesktop" class="sliderinput easyinit" data-r="nav.swipe.setOnDesktop"/></longoption>
					</div>
					<div class="carouselavailable standardunavailable sceneunavailable">
						<longoption><i class="material-icons"></i><label_a><?php _e('Mobile Carousel Swipe', 'revslider');?></label_a><input type="checkbox"  id="sr_usetouch" class="sliderinput easyinit" data-r="nav.swipe.setMobileCarousel"/></longoption>
						<longoption><i class="material-icons"></i><label_a><?php _e('Desktop Carousel Swipe', 'revslider');?></label_a><input type="checkbox"  id="sr_usetouch" class="sliderinput easyinit" data-r="nav.swipe.setDesktopCarousel"/></longoption>
					</div>
					<longoption><i class="material-icons"></i><label_a><?php _e('Block Scroll', 'revslider');?></label_a><input type="checkbox"  id="sr_blockDragVertical" class="sliderinput easyinit" data-r="nav.swipe.blockDragVertical"/></longoption>
					<div class="div15"></div>					
					<label_a><?php _e('Velocity', 'revslider');?></label_a><input class="sliderinput valueduekeyboard smallinput easyinit"  data-r="nav.swipe.velocity" data-min="0" data-max="75" type="text" id="nav_swipe_velocity" ><span class="linebreak"></span>
					<label_a><?php _e('Min. Finger', 'revslider');?></label_a><input class="sliderinput valueduekeyboard smallinput easyinit"  data-r="nav.swipe.minTouch" data-min="0" data-max="10" type="text" id="nav_swipe_minTouch" ><span class="linebreak"></span>
					<div class="div15"></div>
					<label_a><?php _e('Swipe Dir', 'revslider');?></label_a>
					<div class="radiooption">
						<input type="radio" name="sr_swipedirection" class="sliderinput easyinit" data-r="nav.swipe.direction" value="horizontal"><label_sub><?php _e('Horizontal', 'revslider');?></label_sub><span class="linebreak"></span>
						<input type="radio" name="sr_swipedirection" class="sliderinput easyinit" data-r="nav.swipe.direction" value="vertical"><label_sub><?php _e('Vertical', 'revslider');?></label_sub><span class="linebreak"></span>
					</div>
					<div class="div20"></div>
				</div>
			</div>
		</div><!-- TOUCH SETTINGS END -->

		<!-- KEYBOARD  SETTINGS -->
		<div id="form_nav_misc" data-select="#gst_nav_8" data-unselect=".nav_submodule_trigger" class="formcontainer form_menu_inside collapsed carouselenable standardenable herodisable">
			<div class="collectortabwrap"><div id="collectortab_form_misc" class="collectortab form_menu_inside" data-forms='["#form_nav_misc"]'><i class="material-icons">keyboard</i><?php _e('Keyboard Settings', 'revslider');?></div></div>
			<!--<div class="form_intoaccordion"><i class="material-icons">arrow_drop_down</i></div>-->
			<div class="form_inner">
				<div class="form_inner_header"><i class="material-icons">keyboard</i><?php _e('Keyboard Arrow Navigation', 'revslider');?></div>
				<!--<div class="form_intoaccordion" data-trigger="#sr_na_thumb_11"><i class="material-icons">arrow_drop_down</i></div>				-->
				<div class="collapsable" style="display:block">
					<label_a><?php _e('Enabled', 'revslider');?></label_a><input type="checkbox"  id="sr_usekeyboard" class="sliderinput easyinit" data-r="nav.keyboard.set"/><span class="linebreak"></span>
					<label_a><?php _e('Direction', 'revslider');?></label_a>
					<div class="radiooption">
						<input type="radio" name="sr_keyboarddirection" class="sliderinput easyinit" data-r="nav.keyboard.direction" value="horizontal"><label_sub><?php _e('Left/Right Arrow Keys', 'revslider');?></label_sub><span class="linebreak"></span>
						<input type="radio" name="sr_keyboarddirection" class="sliderinput easyinit" data-r="nav.keyboard.direction" value="vertical"><label_sub><?php _e('Up/Down Arrow Keys', 'revslider');?></label_sub><span class="linebreak"></span>
					</div>
				</div>
			</div>
		</div><!-- KEYBOARD SETTINGS END -->

		<!-- MOUSE  SETTINGS -->
		<div id="form_nav_mousescroll" data-select="#gst_nav_9" data-unselect=".nav_submodule_trigger" class="formcontainer form_menu_inside collapsed carouselenable standardenable herodisable">
			<div class="collectortabwrap"><div id="collectortab_form_misc" class="collectortab form_menu_inside" data-forms='["#form_nav_mousescroll"]'><i class="material-icons">mouse</i><?php _e('Mouse Wheel Navigation', 'revslider');?></div></div>
			<!--<div class="form_intoaccordion"><i class="material-icons">arrow_drop_down</i></div>-->
			<div class="form_inner">
				<div class="form_inner_header"><i class="material-icons">mouse</i><?php _e('Mouse Wheel Navigation', 'revslider');?></div>
				<!--<div class="form_intoaccordion" data-trigger="#sr_na_thumb_11"><i class="material-icons">arrow_drop_down</i></div>				-->
				<div class="collapsable" style="display:block">
					<label_a><?php _e('Wheel Listener', 'revslider');?></label_a><select class="sliderinput tos2 nosearchbox easyinit"  name="sr_mousenavigation" class="sliderinput easyinit" data-r="nav.mouse.set" data-show=".sr_mousenavigation_*val*" data-hide=".sr_mousenavigationsettings"><option value="on"><?php _e('On', 'revslider');?></option><option value="carousel"><?php _e('Infinity', 'revslider');?></option><option value="off"><?php _e('Off', 'revslider');?></option></select><span class="linebreak"></span>
					<div class="sr_mousenavigation_on sr_mousenavigation_carousel sr_mousenavigationsettings">																				
						<label_a><?php _e('Reverse Scroll', 'revslider');?></label_a><select class="sliderinput tos2 nosearchbox easyinit"  name="sr_reversemousenavigation" class="sliderinput easyinit" data-r="nav.mouse.reverse"><option value="reverse"><?php _e('Reverse', 'revslider');?></option><option value="default"><?php _e('Default', 'revslider');?></option></select><span class="linebreak"></span>
						<label_a><?php _e('Scroll Target', 'revslider');?></label_a><select class="sliderinput tos2 nosearchbox easyinit"  name="sr_targetmousenavigation" class="sliderinput easyinit" data-r="nav.mouse.target"><option value="window"><?php _e('Window', 'revslider');?></option><option value="html"><?php _e('HTML', 'revslider');?></option><option value="body"><?php _e('Body', 'revslider');?></option></select><span class="linebreak"></span>
						<div class="div10"></div>				
						<longoption><i class="material-icons">view_day</i><label_a><?php _e('Snap Threshold', 'revslider');?></label_a><input class="sliderinput valueduekeyboard easyinit"  data-r="nav.mouse.threshold" data-min="0" data-max="100" type="text" id="wheelsnapthreshold" ></longoption>
						<longoption><i class="material-icons">visibility</i><label_a><?php _e('In ViewPort (%)', 'revslider');?></label_a><input class="sliderinput valueduekeyboard easyinit"  data-r="nav.mouse.viewport" data-min="0" data-max="100" type="text" id="wheelifvisible" ></longoption>
						<longoption><i class="material-icons">schedule</i><label_a><?php _e('Call Delay', 'revslider');?></label_a><input class="sliderinput valueduekeyboard easyinit"  data-r="nav.mouse.calldelay" data-min="100" data-max="3000" data-allowed="ms" type="text" id="wheelcalldelay" ></longoption>
						
					</div>
				</div>		
				<!--<div class="sr_mousenavigation_on sr_mousenavigationsettings">			
					<div class="form_inner">					
						<div class="collectortabwrap " style="display:block"><div class="collectortab form_inner_header" style="display:block"><i class="material-icons">mouse</i><?php _e('Stop Page Scrolling', 'revslider');?></div></div>
						<div class="collapsable" style="display:block">																													
							<label_a><?php _e('Way Up at', 'revslider');?></label_a><select id="wheelwayup" class="sliderinput tos2 nosearchbox easyinit"  data-show=".msWayUpOffset" data-hide=".msWayUp_*val*" data-showprio="hide" data-r="nav.mouse.msWayUp"><option value="top"><?php _e('Top', 'revslider');?></option><option value="center"><?php _e('Center', 'revslider');?></option><option value="bottom"><?php _e('Bottom', 'revslider');?></option><option value="ignore"><?php _e('Ignore', 'revslider');?></option></select><span class="linebreak"></span>
							<div class="msWayUp_ignore msWayUpOffset"><label_a><?php _e('Offset', 'revslider');?></label_a><input class="sliderinput valueduekeyboard easyinit"  data-r="nav.mouse.msWayUpOffset" data-min="0" data-max="1500" type="text" id="msWayUpOffset" ></div>
							<label_a><?php _e('Way Down at', 'revslider');?></label_a><select id="wheelwaydown" class="sliderinput tos2 nosearchbox easyinit" data-show=".msWayDownOffset" data-hide=".msWayDown_*val*" data-showprio="hide" data-r="nav.mouse.msWayDown"><option value="top"><?php _e('Top', 'revslider');?></option><option value="center"><?php _e('Center', 'revslider');?></option><option value="bottom"><?php _e('Bottom', 'revslider');?></option><option value="ignore"><?php _e('Ignore', 'revslider');?></option></select><span class="linebreak"></span>
							<div class="msWayDown_ignore msWayDownOffset"><label_a><?php _e('Offset', 'revslider');?></label_a><input class="sliderinput valueduekeyboard easyinit"  data-r="nav.mouse.msWayDownOffset" data-min="0" data-max="1500" type="text" id="msWayDownOffset" ></div>
						</div>
					</div>
				</div>-->
			</div>				
									
		</div><!-- MOUSE SETTINGS END -->		
	</div>
</div><!-- END OF SLIDER SETTINGS-->