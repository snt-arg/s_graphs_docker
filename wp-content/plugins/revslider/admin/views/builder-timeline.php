<?php
/**
 * Provide a admin area view for the plugin TIMELINE SETTINGS
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2019 ThemePunch
 */

if(!defined('ABSPATH')) exit();
?>

<!-- TIMELINE -->
<div id="timeline_settings">
	<!-- LAYERS LIST -->
	<div id="timeline">
		<div id="timeline_collapser"><i class="material-icons">close</i></div>
		<div id="timeline_top_toolbar"><!--			
			--><div class="timeline_left_container">
				<div class="layer_group_filter_wrap">
					<div class="layer_g_filter"><label_icon class="selected ui_free_layers" data-realref="hide_all_nonezone" data-ref="hide_free_layers"></label_icon></div><!--
					--><div class="layer_g_filter"><label_icon class="selected ui_top_row_layers" data-realref="hide_all_zone" data-ref="hide_top_row_layers hide_middle_row_layers hide_bottom_row_layers"></label_icon></div><!--
					--><div class="layer_allcollaps"><i class="material-icons lacoll_open">folder_open</i></div>
				</div><!--				
				--><div id="tl_gridmanagement_wrap" class="tl_gridmanagement_wrap">
						<div id="general_gridmanagement_wrap" class="sliderconfig_forms">															
							<label_a><?php _e('Adjust by', 'revslider');?></label_a><select id="snap_to_what" class="sliderinput tos2 nosearchbox easyinit callEvent" data-r="snap.adjust" data-show="" data-hide="" data-theme="dark" data-evt="updateSnapVisual">
									<option value="none"><?php _e('None', 'revslider');?></option>
									<option value="grid"><?php _e('Grid', 'revslider');?></option>
									<option value="layers"><?php _e('Same Aligned Layers','revslider');?></option>									
							</select><div class="linebreak"></div>
							<label_a><?php _e('Gap', 'revslider');?></label_a><input data-numeric="true" data-min="0" data-max="2500" data-evt="updateSnapVisual" id="snap_cell_size" data-r="snap.gap" type="text" class="callEvent sliderinput easyinit valueduekeyboard "><div class="linebreak"></div>
							<div class="closeme_tl_miniwrapper"><i class="material-icons">close</i></div>
						</div>				
						<div class="basic_action_button mini_action_button onlyicon" id="tl_gridmanagement"><i class="material-icons">border_vertical</i></div>

					</div><!--
				--><div class="tl_magnifying_wrap">
						<div id="general_frame_magnif_wrap">
							<div class="radiooption">
								<div class="magnet_fr_none selected"><input id="magnet_fr_none"  data-select=".st_slider" data-unselect=".magnet_fr_sticky, .magnet_fr_sticky_inh" name="frame_maginfiy_radio" data-evt="magnetframes" data-evtparam="0" type="radio" value="0" class="basicinput callEvent" checked="checked"><label_sub><?php _e('No Sticky Keyframes', 'revslider');?></label_sub><span class="shortcuttext osx"><span class="shortcut_cmdctrl">⌘</span>U</span></div>
								<div  class="magnet_fr_sticky"><input id="magnet_fr_sticky" data-select=".magnet_fr_sticky" data-unselect=".magnet_fr_none, .magnet_fr_sticky_inh" name="frame_maginfiy_radio" data-evt="magnetframes" data-evtparam="1" type="radio" value="1" class="basicinput callEvent"><label_sub><?php _e('Single Layer Sticky', 'revslider');?></label_sub><span class="shortcuttext osx"><span class="shortcut_cmdctrl">⌘</span>I</span></div>
								<div  class="magnet_fr_sticky_inh"><input id="magnet_fr_sticky_inh" data-select=".magnet_fr_sticky_inh" data-unselect=".magnet_fr_none, .magnet_fr_sticky" name="frame_maginfiy_radio" data-evt="magnetframes" data-evtparam="2" type="radio" value="2" class="basicinput callEvent"><label_sub><?php _e('Hierarchy Sticky', 'revslider');?></label_sub><span class="shortcuttext osx"><span class="shortcut_cmdctrl">⌘</span>O</span></div>
							</div>
							<div class="closeme_tl_miniwrapper"><i class="material-icons">close</i></div>
						</div>
						<div class="basic_action_button mini_action_button onlyicon" id="tl_framemagnet"><label_icon class="ui_magnet"></label_icon></div>						
					</div><!--
				--><div class="tl_multip_wrap">					
					<div id="general_speed_factor_wrap">
						<label_a><?php _e('Set all Timings', 'revslider');?></label_a>
						<input id="general_speed_factor" class="basicinput" type="text" data-min="1" data-max="500" placeholder="100%" data-numeric="true" data-allowed="%" value="100%"/>
						<div id="gsf_ok" class="basic_action_button onlyicon"><i class="material-icons">update</i></div>
						<div class="closeme_tl_miniwrapper"><i class="material-icons">close</i></div>
					</div>
					<div class="basic_action_button mini_action_button onlyicon" id="tl_multiplicator"><i class="material-icons">shutter_speed</i></div>
				</div><!--
				--><div class="tl_playstop_wrap"><div id="timline_process" data-states="play,stop" data-start_state="play" data-stop="playTimeLine" data-stop_state="Stop" data-stop_icon="stop" data-play="stopTimeLine" data-play_state="Play" data-play_icon="play_arrow" class="basic_action_button mini_action_button switch_button activeswitch autosize" data-state="play"><i class="material-icons switch_button_icon">play_arrow</i></div></div>
				<!--<div class="tl_toolbar_wrap">
					<div class="all_layer_delete all_layer_tool"><i class="material-icons">delete</i></div>
					<div class="all_layer_hide_show all_layer_tool"><i class="material-icons">visibility_off</i></div>
					<div class="all_layer_selector all_layer_tool"><i class="material-icons">check_box_outline_blank</i></div>
					<div class="all_layer_untilend all_layer_tool"><i class="material-icons">keyboard_tab</i></div>
				</div>-->
			</div>
			<div class="timeline_right_container">
				<div id="time_linear"><canvas id="time_linear_canvas"></canvas><div class="slidelooptimemarker"></div></div>
				<div id="fixedscroll_linear"><div class="fixedscrolltimemarker"></div></div>
				<div id="hovertime"><div class="timebox"><span class="ctm">00</span>:<span class="cts">00</span>:<span class="ctms">00</span></div><div class="timebox_marker"></div></div>
				<div id="frametime"><div class="timebox"><span class="ctm">00</span>:<span class="cts">00</span>:<span class="ctms">00</span></div><div class="timebox_marker"></div></div>
				<div id="currenttime"><div class="timebox_idle">EDITOR</div><div class="timebox"><span class="ctm">00</span>:<span class="cts">00</span>:<span class="ctms">00</span></div><div class="timebox_marker"></div></div>
				<div id="maxtime"><div class="timebox"><span class="ctm">00</span>:<span class="cts">00</span>:<span class="ctms">00</span></div><div class="timebox_marker"></div></div>
				<div id="slidelooptimestart"><div class="timebox"><span class="ctm">00</span>:<span class="cts">00</span>:<span class="ctms">00</span></div><div class="timebox_marker"></div></div>
				<div id="slidelooptimeend"><div class="timebox"><span class="ctm">00</span>:<span class="cts">00</span>:<span class="ctms">00</span></div><div class="timebox_marker"></div></div>

				<div id="fixedscrolltimestart"><div class="timebox"><span class="ctm">00</span>:<span class="cts">00</span>:<span class="ctms">00</span></div><div class="timebox_marker"></div></div>
				<div id="fixedscrolltimeend"><div class="timebox"><span class="ctm">00</span>:<span class="cts">00</span>:<span class="ctms">00</span></div><div class="timebox_marker"></div></div>
			</div>
		</div>

		<div id="tlLayerListWrap">			
			<div id="the_slide_timeline" class="slide_timeline">
				<div class="slide_timeline_element">
					<div class="layerlist_element_innerwrap">
						<div id="the_st_cl" class="context_left"><div id="slide_bg_anim_trigger"><div class="layerlist_element_type" ><i class="material-icons">panorama</i></div><div class="layerlist_element_alias"><?php _e('Slide BG Animation', 'revslider');?></div></div><i id="tl_trigger_slide_options" data-select="#gst_slide_1" data-unselect=".slide_submodule_trigger" data-collapse="true" data-forms='["*slidelayout**mode__slidestyle*#form_slidebg"]' class="material-icons opensettingstrigger">perm_media</i></div>
						<div id="slide_frame_container" class="stimeline">
							<div class="slidelooptimemarker"></div>
							<div class="frameswrap"></div>
						</div>
					</div>
				</div>
			</div>
			<div id="the_global_layers_timeline" class="slide_timeline">
				<div class="slide_timeline_element">
					<div class="layerlist_element_innerwrap">
						<div id="the_fake_cl" class="context_left"><div><div class="layerlist_element_type" ><i class="material-icons">panorama</i></div><div class="layerlist_element_alias"><?php _e('Global Layers Timeline', 'revslider');?></div></div></div>
						<div id="fake_frame_container" class="stimeline"></div>
					</div>
				</div>
			</div>
			<!--<div class="fake_slide_timeline">
				<div class="fake_tllayerlist_element tllayerlist_element_zone">
					<div class="layerlist_element_innerwrap" data-ignore="true">
						<div class="context_left"><div class="layerlist_element_type"></div><div class="layerlist_element_alias"><?php _e('FREE POSITIONED LAYERS', 'revslider');?></div></div>
						<div class="stimeline">							
							<div class="frameswrap"></div>
						</div>
					</div>
				</div>
			</div>-->
		</div>
	</div>
</div><!-- END OF TIMELINE  -->