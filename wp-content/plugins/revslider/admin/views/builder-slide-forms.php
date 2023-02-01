<?php
/**
 * Provide a admin area view for the plugin Slide Settings
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2019 ThemePunch
 */
 
if(!defined('ABSPATH')) exit();
?>
<!-- SLIDE SETTINGS -->
<div id="slide_settings">

	<div class="form_collector slide_settings_collector" data-type="sliderconfig" data-pcontainer="#slide_settings" data-offset="#rev_builder_wrapper">
		<div class="main_mode_breadcrumb_wrap"><div class="main_mode_submode"><?php _e('Slide Options', 'revslider');?></div></div>
		<div class="gso_wrap" id="slide_menu_gso_wrap">
			<div id="gst_slide_1" class="slide_submodule_trigger selected opensettingstrigger" data-select="#gst_slide_1" data-unselect=".slide_submodule_trigger" data-collapse="true" data-forms='["#form_slidebg"]'><i class="material-icons">image</i><span class="gso_title"><?php _e('Background', 'revslider');?></span></div><!--
			--><div id="gst_slide_6" data-select="#gst_slide_6" data-unselect=".slide_submodule_trigger" class="slide_submodule_trigger opensettingstrigger" data-collapse="true" data-forms='["#form_slide_thumbnail"]'><i class="material-icons">photo_album</i><span class="gso_title"><?php _e('Thumbnail', 'revslider');?></span></div><!--
			--><div id="gst_slide_2" data-select="#gst_slide_2" data-unselect=".slide_submodule_trigger" class="slide_submodule_trigger opensettingstrigger" data-collapse="true" data-forms='["#form_slide_transition"]'><i class="material-icons">movie</i><span class="gso_title"><?php _e('Animation', 'revslider');?></span></div><!--
			--><div id="gst_slide_5" class="slide_submodule_trigger opensettingstrigger" data-select="#gst_slide_5" data-unselect=".slide_submodule_trigger" data-collapse="true" data-forms='["#form_slidebg_filters"]'><i class="material-icons">blur_on</i><span class="gso_title"><?php _e('Filters', 'revslider');?></span></div><!--
			--><div id="gst_slide_8" data-select="#gst_slide_8" data-unselect=".slide_submodule_trigger" class="slide_submodule_trigger opensettingstrigger" data-collapse="true" data-forms='["#form_slide_progress"]'><i class="material-icons">timer</i><span class="gso_title"><?php _e('Progress', 'revslider');?></span></div><!--
			--><div id="gst_slide_9" data-select="#gst_slide_9" data-unselect=".slide_submodule_trigger" class="slide_submodule_trigger opensettingstrigger" data-collapse="true" data-forms='["#form_slide_publish"]'><i class="material-icons">access_time</i><span class="gso_title"><?php _e('Pub. Rules', 'revslider');?></span></div><!--
			--><div id="gst_slide_4" data-select="#gst_slide_4" data-unselect=".slide_submodule_trigger" class="slide_submodule_trigger opensettingstrigger" data-collapse="true" data-forms='["#form_slidegeneral"]'><i class="material-icons">code</i><span class="gso_title"><?php _e('Tags & Link', 'revslider');?></span></div><!--
			--><div id="gst_slide_10" data-select="#gst_slide_10" data-unselect=".slide_submodule_trigger" class="slide_submodule_trigger opensettingstrigger" data-collapse="true" data-forms='["#form_slidestatic"]'><i class="material-icons">album</i><span class="gso_title"><?php _e('Static Layer', 'revslider');?></span></div><!--
			--><div id="gst_slide_3" data-select="#gst_slide_3" data-unselect=".slide_submodule_trigger" class="slide_submodule_trigger opensettingstrigger slidebg_image_settings slidebg_external_settings slide_bg_settings" data-collapse="true" data-forms='["#form_slide_kenburn_outter"]'><i id="gst_kenburns_title_icon" class="material-icons">leak_add</i><span id="gst_kenburns_title" class="gso_title"><?php _e('Ken Burns', 'revslider');?></span></div><!--
			--><div id="gst_slide_7" data-select="#gst_slide_7" data-unselect=".slide_submodule_trigger" class="slide_submodule_trigger opensettingstrigger" data-collapse="true" data-forms='["#form_slide_parameters"]'><i class="material-icons">info</i><span class="gso_title"><?php _e('Params', 'revslider');?></span></div><!--
			--><div id="gst_slide_11" data-select="#gst_slide_11" data-unselect=".slide_submodule_trigger" class="slide_submodule_trigger opensettingstrigger callEvent" data-evt="updateSlideLoopRange" data-collapse="true" data-forms='["#form_slide_loops"]'><i class="material-icons">repeat_one</i><span class="gso_title"><?php _e('Loop Layers', 'revslider');?></span></div><!--
			--><div id="gst_slide_12" data-select="#gst_slide_12" data-unselect=".slide_submodule_trigger" class="slide_submodule_trigger opensettingstrigger" data-collapse="true" data-forms='["#form_slide_onscroll"]'><i class="material-icons">system_update_alt</i><span class="gso_title"><?php _e('On Scroll', 'revslider');?></span></div>
			<?php
if ($wpml->wpml_exists()) {
	?>
<div id="gst_slide_13" data-select="#gst_slide_13" data-unselect=".slide_submodule_trigger" class="slide_submodule_trigger opensettingstrigger" data-collapse="true" data-forms='["#form_slide_wpml"]'><i class="material-icons">language</i><span class="gso_title"><?php _e('WPML', 'revslider');?></span></div>
			<?php 
} 
?>
		</div>
	</div>


	<!-- SLIDE BACKGROUND -->
	<div class="form_collector slide_settings_collector" data-type="slideconfig" data-pcontainer="#slide_settings" data-offset="#rev_builder_wrapper">
		<div id="form_slidebg"  class="formcontainer form_menu_inside" data-select="#gst_slide_1"  >
			<!--<div class="collectortabwrap"><div id="collectortab_form_slidebg" class="collectortab form_menu_inside" data-forms='["#form_slidebg"]'><i class="material-icons">filter_hdr</i><?php _e('Background', 'revslider');?></div></div>-->
			<!-- SOURCE -->
			<div id="form_slidebg_source" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">link</i><?php _e('Source', 'revslider');?></div>
				<!--<div class="form_intoaccordion" data-trigger="#sl_fbg_l1_1"><i class="material-icons">arrow_drop_down</i></div>-->
				<div class="collapsable">
					<label_a><?php _e('Type', 'revslider');?></label_a><div class="input_with_buttonextenstion"><select id="slide_bg_type" data-available=".sss_for_*val*" data-unavailable=".sss_notfor_*val*" data-updatetext="selected_slide_source" data-triggerinp="#slide_bg_*val*_alt,#slide_bg_*val*_title" data-evt="updateslidebasic" data-evtparam="kenburnupdate" data-show=".slidebg_*val*_settings" data-hide=".slide_bg_settings" class="slideinput tos2 nosearchbox easyinit "  data-r="bg.type"><option value="image"><?php _e('Image', 'revslider');?></option><option value="external"><?php _e('External Image', 'revslider');?></option><option value="trans"><?php _e('Transparent', 'revslider');?></option><option value="solid"><?php _e('Colored', 'revslider');?></option><option value="youtube"><?php _e('YouTube Video', 'revslider');?></option><option value="vimeo"><?php _e('Vimeo Video', 'revslider');?></option><option value="html5"><?php _e('HTML5 Video', 'revslider');?></option></select>
						<div class="buttonextenstion slidebg_image_settings slidebg_external_settings slide_bg_settings slidebg_youtube_settings slidebg_html5_settings slidebg_vimeo_settings">
							<input class="dontseeme" id="slide_bg_image_path" />
							<div class="basic_action_button copyclipboard onlyicon dark_action_button" data-clipboard-action="copy" data-clipboard-target="#slide_bg_image_path"><i class="material-icons">link</i></div>
						</div>
					</div><!--
					--><div class="slidebg_image_settings slide_bg_settings">
						<label_a></label_a><div id="slide_bg_image_btn" data-evt="updateslidebasic" data-evtparam="kenburnupdate" data-r="#slide#.slide.bg.image" data-rid="#slide#.slide.bg.imageId" data-lib="#slide#.slide.bg.imageLib" data-sty="#slide#.slide.bg.imageSourceType" class="getImageFromMediaLibrary basic_action_button longbutton callEventButton"><i class="material-icons">style</i><?php _e('Media Library', 'revslider');?></div>
						<label_a></label_a><div id="slide_object_library_btn" data-evt="updateslidebasic" data-evtparam="double" data-r="#slide#.slide.bg.image" data-rid="#slide#.slide.bg.imageId" data-lib="#slide#.slide.bg.imageLib" data-sty="#slide#.slide.bg.imageSourceType" class="getImageFromObjectLibrary basic_action_button longbutton callEventButton"><i class="material-icons">camera_enhance</i><?php _e('Object Library', 'revslider');?></div>
					</div><!--
					--><div class="slidebg_external_settings slide_bg_settings">
						<label_a><?php _e('Source', 'revslider');?></label_a><input id="s_ext_src" data-evt="updateslidebasic" data-evtparam="kenburnupdate" class="slideinput easyinit" type="text" data-r="bg.externalSrc" placeholder="<?php _e('Enter Image URL', 'revslider');?>">
						<label_a><?php _e('', 'revslider');?></label_a><div data-evt="updateslidebasic" data-evtparam="kenburnupdate" class="basic_action_button  longbutton callEventButton"><i class="material-icons">refresh</i><?php _e('Refresh Source', 'revslider');?></div>
					</div><!--
					--><div class="slidebg_solid_settings slide_bg_settings">
						<label_a><?php _e('BG Color', 'revslider');?></label_a><input type="text" data-evt="updateslidebasic" data-editing="<?php _e('Background Color', 'revslider');?>" name="slide_bg_color" id="s_bg_color" data-visible="true" class="my-color-field slideinput easyinit" data-r="bg.color" value="#fff">
					</div><!--
					--><div class="slidebg_trans_settings slide_bg_settings">						
					</div><!--
					--><div class="slidebg_youtube_settings slide_bg_settings">
						<label_a><?php _e('YouTube ID', 'revslider');?></label_a><input id="s_bg_youtube_src" data-evt="updateslidebasic" class="slideinput easyinit" type="text" data-r="bg.youtube" placeholder="<?php _e('Enter YouTube ID', 'revslider');?>">
						<div class="div25"></div>
						<label_a><?php _e('Poster Image', 'revslider');?></label_a><div data-r="#slide#.slide.bg.image" data-f="#slide#.slide.bg.youtube" data-evtparam="double" data-evt="updateslidebasic" data-lib="#slide#.slide.bg.imageLib" data-sty="#slide#.slide.bg.imageSourceType"  class="getImageFromYouTube basic_action_button longbutton "><i class="material-icons">style</i><?php _e('YouTube Poster', 'revslider');?></div>
						<label_a></label_a><div data-evt="updateslidebasic" data-r="#slide#.slide.bg.image" data-rid="#slide#.slide.bg.imageId" class="getImageFromMediaLibrary basic_action_button longbutton"><i class="material-icons">style</i><?php _e('Media Library', 'revslider');?></div>
						<label_a></label_a><div data-evt="updateslidebasic" data-evtparam="double" data-r="#slide#.slide.bg.image" data-rid="#slide#.slide.bg.imageId" data-lib="#slide#.slide.bg.imageLib" data-sty="#slide#.slide.bg.imageSourceType" class="getImageFromObjectLibrary basic_action_button longbutton callEventButton"><i class="material-icons">camera_enhance</i><?php _e('Object Library', 'revslider');?></div>
						<label_a></label_a><div data-evt="updateslidebasic" data-r="#slide#.slide.bg.image" data-rid="#slide#.slide.bg.imageId" class="removePosterImage basic_action_button longbutton"><i class="material-icons">delete</i><?php _e('Remove', 'revslider');?></div><span class="linebreak"></span>
					</div><!--
					--><div class="slidebg_vimeo_settings slide_bg_settings">
						<label_a><?php _e('Vimeo ID', 'revslider');?></label_a><input id="s_bg_vimeo_src" data-evt="updateslidebasic" class="slideinput easyinit" type="text" data-r="bg.vimeo" placeholder="<?php _e('Enter Vimeo ID', 'revslider');?>">
						<div class="div25"></div>
						<label_a><?php _e('Poster Image', 'revslider');?></label_a><div data-r="#slide#.slide.bg.image" data-f="#slide#.slide.bg.vimeo" data-evtparam="double" data-evt="updateslidebasic" data-lib="#slide#.slide.bg.imageLib" data-sty="#slide#.slide.bg.imageSourceType"  class="getImageFromVimeo basic_action_button longbutton "><i class="material-icons">style</i><?php _e('Vimeo Poster', 'revslider');?></div>
						<label_a></label_a><div data-evt="updateslidebasic" data-evtparam="double" data-r="#slide#.slide.bg.image" data-rid="#slide#.slide.bg.imageId" data-lib="#slide#.slide.bg.imageLib" data-sty="#slide#.slide.bg.imageSourceType"  class="getImageFromMediaLibrary basic_action_button  longbutton"><i class="material-icons">style</i><?php _e('Media Library', 'revslider');?></div>
						<label_a></label_a><div data-evt="updateslidebasic" data-evtparam="double" data-r="#slide#.slide.bg.image" data-rid="#slide#.slide.bg.imageId" data-lib="#slide#.slide.bg.imageLib" data-sty="#slide#.slide.bg.imageSourceType" class="getImageFromObjectLibrary basic_action_button longbutton callEventButton"><i class="material-icons">camera_enhance</i><?php _e('Object Library', 'revslider');?></div>						
						<label_a></label_a><div data-evt="updateslidebasic" data-r="#slide#.slide.bg.image" data-rid="#slide#.slide.bg.imageId" class="removePosterImage basic_action_button longbutton"><i class="material-icons">delete</i><?php _e('Remove', 'revslider');?></div><span class="linebreak"></span>
					</div><!--
					--><div class="slidebg_html5_settings slide_bg_settings">
						<label_a><?php _e('MPEG', 'revslider');?></label_a><input id="s_bg_mpeg_src" data-evt="updateslidebasic" class="slideinput easyinit nmarg" type="text" data-r="bg.mpeg" placeholder="<?php _e('Enter MPEG Source', 'revslider');?>">
						<label_a></label_a><div data-evt="updateslidebasicmpeg" data-target="#s_bg_mpeg_src" data-rid="#slide#.slide.bg.videoId" class="getVideoFromMediaLibrary basic_action_button longbutton "><i class="material-icons">style</i><?php _e('Media Library', 'revslider');?></div>
						<label_a></label_a><div data-evt="updateslidebasic" data-target="#s_bg_mpeg_src" data-r="bg.mpeg" class="getVideoFromObjectLibrary basic_action_button longbutton "><i class="material-icons">camera_enhance</i><?php _e('Object Library', 'revslider');?></div>
						<!--<label_a><?php _e('WEBM', 'revslider');?></label_a><div class="input_with_buttonextenstion"><input id="s_bg_webm_src" data-evt="updateslidebasic" class="slideinput easyinit nmarg" type="text" data-r="bg.mpeg" placeholder="<?php _e('Optional WEBM Source', 'revslider');?>"><div data-evt="updateslidebasic" data-target="#s_bg_webm_src" class="getVideoFromMediaLibrary basic_action_button onlyicon dark_action_button callEventButton"><i class="material-icons">style</i></div></div>-->
						<!--<label_a><?php _e('OGV', 'revslider');?></label_a><div class="input_with_buttonextenstion"><input id="s_bg_ogv_src" data-evt="updateslidebasic" class="slideinput easyinit nmarg" type="text" data-r="bg.ogv" placeholder="<?php _e('Optional OGV Source', 'revslider');?>"><div data-evt="updateslidebasic" data-target="#s_bg_ogv_src" class="getVideoFromMediaLibrary basic_action_button  onlyicon dark_action_button callEventButton"><i class="material-icons">style</i></div></div>-->
						<div class="div25"></div>
						<label_a><?php _e('Poster Image', 'revslider');?></label_a><div data-evt="gethtml5posterimage" data-evtparam="slide" class="basic_action_button longbutton callEventButton"><i class="material-icons">linked_camera</i><?php _e('Get Start Frame', 'revslider');?></div>
						<label_a></label_a><div data-evt="updateslidebasic" data-evtparam="double" data-r="#slide#.slide.bg.image" data-rid="#slide#.slide.bg.imageId" data-lib="#slide#.slide.bg.imageLib" data-sty="#slide#.slide.bg.imageSourceType" class="getImageFromMediaLibrary basic_action_button longbutton "><i class="material-icons">style</i><?php _e('Media Library', 'revslider');?></div>
						<label_a></label_a><div  data-evt="updateslidebasic" data-evtparam="double" data-r="#slide#.slide.bg.image" data-rid="#slide#.slide.bg.imageId" data-lib="#slide#.slide.bg.imageLib" data-sty="#slide#.slide.bg.imageSourceType" class="getImageFromObjectLibrary basic_action_button longbutton callEventButton"><i class="material-icons">camera_enhance</i><?php _e('Object Library', 'revslider');?></div>						
						<!--<label_a></label_a><div data-evt="updateslidebasic" class="basic_action_button longbutton "><i class="material-icons">camera_enhance</i><?php _e('Object Library', 'revslider');?></div>-->
						<label_a></label_a><div data-evt="updateslidebasic" data-r="#slide#.slide.bg.image" data-rid="#slide#.slide.bg.imageId" data-lib="#slide#.slide.bg.imageLib" data-sty="#slide#.slide.bg.imageSourceType" class="removePosterImage basic_action_button longbutton"><i class="material-icons">delete</i><?php _e('Remove', 'revslider');?></div><span class="linebreak"></span>
					</div><!--					
					--><div class="slidebg_image_settings slidebg_vimeo_settings slidebg_html5_settings slidebg_youtube_settings slide_bg_settings">
						<div style="display:none"><label_a class="singlerow"><?php _e('Used Library', 'revslider');?></label_a><select class="slideinput easyinit" data-r="bg.imageLib" data-show="#slidebg_srctype_*val*" data-hide=".slidebg_srctype_all" data-showprio="show"><option value="">Nothing</option><option value="objectlibrary">Objectlibrary</option><option value="medialibrary">MediaLibrary</option></select></div>
						<div id="slidebg_srctype_objectlibrary" class="slidebg_srctype_all"><label_a class="singlerow"><?php _e('Source Type', 'revslider');?></label_a><select data-theme="dark" id="slide_bg_img_ssize_a" class="slideinput tos2 nosearchbox easyinit" data-evt="getNewImageSize" data-evtparam="slidebg.object" data-r="bg.imageSourceType"><option value="100" selected="selected"><?php _e("Original", 'revslider');?></option><option value="75" selected="selected"><?php _e("Large", 'revslider');?></option><option value="50" selected="selected"><?php _e("Medium", 'revslider');?></option><option value="25" selected="selected"><?php _e("Small", 'revslider');?></option><option value="10" selected="selected"><?php _e("Extra Small", 'revslider');?></option></select></div>
						<div id="slidebg_srctype_medialibrary" class="slidebg_srctype_all"><label_a class="singlerow"><?php _e('Source Type', 'revslider');?></label_a><select data-theme="dark" id="slide_bg_img_ssize_b" class="slideinput tos2 nosearchbox easyinit" data-evt="getNewImageSize" data-evtparam="slidebg.media"  data-r="bg.imageSourceType"><option value="auto" selected="selected"><?php _e("Default Setting", 'revslider');?></option><?php foreach ($img_sizes as $imghandle => $imgSize) { echo '<option value="' . $imghandle . '">' . $imgSize . '</option>';}?></select></div>
					</div><!--
					--><div class="slidebg_html5_settings slide_bg_settings slidebg_vimeo_settings slidebg_youtube_settings slidebg_image_settings slidebg_external_settings"><!--
						--><div class="div25"></div><!--
						--><longoption><i class="material-icons">language</i><label_a ><?php _e('Image from Stream if exists', 'revslider');?></label_a><input type="checkbox" class="easyinit slideinput" data-r="bg.imageFromStream"></longoption><!--
					--></div><!--
					--><div class="slidebg_html5_settings slide_bg_settings slidebg_vimeo_settings slidebg_youtube_settings"><!--
						--><longoption><i class="material-icons">language</i><label_a ><?php _e('Video from Stream if exists', 'revslider');?></label_a><input type="checkbox" class="easyinit slideinput" data-r="bg.videoFromStream"></longoption><!--
					--></div><!--
				--></div>
			</div><!-- SOURCE END -->

			<!-- SOURCE SETTINGS -->
			<div id="form_slidebg_ssettings" class="form_inner open sss_notfor_solid sss_notfor_trans sss_for_image sss_for_external sss_for_youtube sss_for_vimeo sss_for_html5">
				<div class="form_inner_header"><i class="material-icons">chrome_reader_mode</i><span id="selected_slide_source"></span><?php _e('Settings', 'revslider');?></div>
				<!--<div class="form_intoaccordion" data-trigger="#sl_fbg_l1_2"><i class="material-icons">arrow_drop_down</i></div>-->
				<div class="collapsable">

					<!-- BACKGROUND / COVER IMAGE SETTINGS -->
<div class="slidebg_image_settings slidebg_external_settings slide_bg_settings">

						<div id="ken_burn_bg_setting_off">
							<div id="slide_bg_settings_wrapper">
								<div id="slide_bg_and_repeat_fit_wrap">
									<label_a><?php _e('BG Fit', 'revslider');?></label_a>
									<div class="radiooption">
										<div><input type="radio" class="slideinput easyinit" value="cover" name="slide_bg_fit"  data-evt="updateslidebasic" data-show=".slide_bg_fit_*val*" data-hide=".slide_bg_fit" data-r="bg.fit"><label_sub>Cover</label_sub></div>
										<div><input type="radio" class="slideinput easyinit" value="contain" name="slide_bg_fit"  data-evt="updateslidebasic" data-show=".slide_bg_fit_*val*" data-hide=".slide_bg_fit" data-r="bg.fit"><label_sub>Contain</label_sub></div>
										<div><input type="radio" class="slideinput easyinit" value="percentage" name="slide_bg_fit"  data-evt="updateslidebasic" data-show=".slide_bg_fit_*val*" data-hide=".slide_bg_fit" data-r="bg.fit"><label_sub>Percentage</label_sub></div>
										<!--<div><input type="radio" class="slideinput easyinit" value="percentagebywrap" name="slide_bg_fit"  data-evt="updateslidebasic" data-show=".slide_bg_fit_*val*" data-hide=".slide_bg_fit" data-r="bg.fit"><label_sub>Percentage by Wrap</label_sub></div>-->
										<div><input type="radio" class="slideinput easyinit" value="auto" name="slide_bg_fit"  data-evt="updateslidebasic" data-show=".slide_bg_fit_*val*" data-hide=".slide_bg_fit" data-r="bg.fit"><label_sub>Auto</label_sub></div>
									</div>
									<div class="div15"></div>

									<div class="slide_bg_fit slide_bg_fit_percentage slide_bg_fit_percentagebywrap">
										<label_a><?php _e('Scale Width', 'revslider');?></label_a><input data-allowed="%" data-numeric="true" id="slide_bg_fitX" data-evt="updateslidebasic" class="slideinput easyinit withsuffix" type="text" data-r="bg.fitX">
									</div>
                  <!-- 
                    @desc wrapper added to toggle this option's visibility for the Distortion AddOn
                    @since 6.4.7
                  -->
                  <div class="slide_bg_repeat">
                    <label_a><?php _e('Repeat', 'revslider');?></label_a><select data-theme="dark" id="slide_bg_repeat"  data-evt="updateslidebasic" class="slideinput tos2 nosearchbox easyinit"  data-r="bg.repeat">
                      <option value="no-repeat" selected="selected">no-repeat</option>
                      <option value="repeat">repeat</option>
                      <option value="repeat-x">repeat-x</option>
                      <option value="repeat-y">repeat-y</option>
                    </select><span class="linebreak"></span>
                  </div>
									<div class="div10"></div>
								</div>
								<label_a><?php _e('Position', 'revslider');?></label_a><select style="display:none !important" data-theme="dark" id="slide_bg_position" data-unselect=".slide_bg_position_selector" data-select="#slide_bg_position_*val*" data-evt="updateslidebasic" data-evtparam="kenburnupdate" data-show=".slide_bg_pos_*val*" data-hide=".slide_bg_pos" class="slideinput easyinit"  data-r="bg.position"><option value="left center"><?php _e('left center', 'revslider');?></option><option value="left bottom"><?php _e('left bottom', 'revslider');?></option><option value="left top"><?php _e('left top', 'revslider');?></option><option value="center top"><?php _e('center top', 'revslider');?></option><option value="center center"><?php _e('center center', 'revslider');?></option><option value="center bottom"><?php _e('center bottom', 'revslider');?></option>																				<option value="right top"><?php _e('right top', 'revslider');?></option><option value="right center"><?php _e('right center', 'revslider');?></option><option value="right bottom"><?php _e('right bottom', 'revslider');?></option><option value="percentage"><?php _e('(x%, y%)', 'revslider');?></option>
								</select><div class="bg_alignselector_wrap"><!--
									--><div class="bg_align_row">
										<div class="triggerselect slide_bg_position_selector bg_alignselector" data-select="#slide_bg_position" data-val="left top" id="slide_bg_position_left-top"></div>
										<div class="triggerselect slide_bg_position_selector bg_alignselector" data-select="#slide_bg_position" data-val="center top" id="slide_bg_position_center-top"></div>
										<div class="triggerselect slide_bg_position_selector bg_alignselector" data-select="#slide_bg_position" data-val="right top" id="slide_bg_position_right-top"></div>
									</div>
									<div class="bg_align_row">
										<div class="triggerselect slide_bg_position_selector bg_alignselector" data-select="#slide_bg_position" data-val="left center" id="slide_bg_position_left-center"></div>
										<div class="triggerselect slide_bg_position_selector bg_alignselector" data-select="#slide_bg_position" data-val="center center" id="slide_bg_position_center-center"></div>
										<div class="triggerselect slide_bg_position_selector bg_alignselector" data-select="#slide_bg_position" data-val="right center" id="slide_bg_position_right-center"></div>
									</div>
									<div class="bg_align_row">
										<div class="triggerselect slide_bg_position_selector bg_alignselector" data-select="#slide_bg_position" data-val="left bottom" id="slide_bg_position_left-bottom"></div>
										<div class="triggerselect slide_bg_position_selector bg_alignselector" data-select="#slide_bg_position" data-val="center bottom" id="slide_bg_position_center-bottom"></div>
										<div class="triggerselect slide_bg_position_selector bg_alignselector" data-select="#slide_bg_position" data-val="right bottom" id="slide_bg_position_right-bottom"></div>
									</div>
									<div class="bg_align_xy">
										<div class="triggerselect slide_bg_position_selector bg_alignselector" data-select="#slide_bg_position" data-val="percentage" id="slide_bg_position_percentage"></div>
										<xy_label><?php _e('X% Y%', 'revslider');?></xy_label>
									</div>
								</div>
								<row class="directrow slide_bg_pos slide_bg_pos_percentage">
									<onelong><label_icon class="ui_x"></label_icon><input id="slide_bg_positionX" data-evt="updateslidebasic" class="slideinput easyinit shortinput" data-numeric="true" data-allowed="%" type="text" data-r="bg.positionX"></onelong>
									<oneshort><label_icon class="ui_y"></label_icon><input id="slide_bg_positionY" data-evt="updateslidebasic" class="slideinput easyinit" data-numeric="true" data-allowed="%" type="text" data-r="bg.positionY"></oneshort>
								</row>

							</div>
						</div>
					</div>


					<!-- HTML ATTRIBUTE ALT FOR BG IMAGE -->
					<div class="slidebg_image_settings slide_bg_settings">
						<label_a><?php _e('"Alt" Attr.', 'revslider');?></label_a><select data-theme="dark" id="slide_bg_image_alt"  data-show=".slide_bg_*val*alt" data-hide=".slide_bg_customalt" class="slideinput tos2 nosearchbox easyinit"  data-r="attributes.altOption">
							<option value="media_library"><?php _e('Media Library', 'revslider');?></option>
							<option value="file_name"><?php _e('Filename', 'revslider');?></option>
							<option value="custom"><?php _e('Custom', 'revslider');?></option>
						</select><span class="linebreak"></span>
					</div>
					<div class="slidebg_image_settings slidebg_external_settings slide_bg_settings slide_bg_customalt">
						<label_a><?php _e('Custom "Alt"', 'revslider');?></label_a><input placeholder='Enter "Alt" Value' id="slide_bg_img_calt" class="slideinput easyinit" type="text" data-r="attributes.alt"><span class="linebreak"></span>
					</div>

					<!-- HTML ATTRIBUTE TITLE FOR BG IMAGE -->
					<div class="slidebg_image_settings slide_bg_settings">
						<label_a><?php _e('"Title" Attr.', 'revslider');?></label_a><select data-theme="dark" id="slide_bg_image_title"  data-show=".slide_bg_*val*title" data-hide=".slide_bg_customtitle" class="slideinput tos2 nosearchbox easyinit"  data-r="attributes.titleOption">
							<option value="media_library"><?php _e('Media Library', 'revslider');?></option>
							<option value="file_name"><?php _e('Filename', 'revslider');?></option>
							<option value="custom"><?php _e('Custom', 'revslider');?></option>
						</select><span class="linebreak"></span>
					</div>

					<div class="slidebg_image_settings slidebg_external_settings slide_bg_settings slide_bg_customtitle">
						<label_a><?php _e('Custom "Title"', 'revslider');?></label_a><input placeholder='Enter "Title" Value' id="slide_bg_img_ctit" class="slideinput easyinit" type="text" data-r="attributes.title"><span class="linebreak"></span>
					</div>
					<!-- HTML ATTRIBUTE WIDTH AND HEIGHT FOR BG IMAGE -->
					<div class="slidebg_external_settings slide_bg_settings">
						<label_a><?php _e('Width Attrib.', 'revslider');?></label_a><input id="slide_bg_width" data-evt="updateslidebasic" class="slideinput easyinit" type="text" data-r="bg.width" data-numeric="true" data-allowed="px">
						<label_a><?php _e('Height Attrib.', 'revslider');?></label_a><input data-numeric="true" data-allowed="px" id="slide_bg_height" data-evt="updateslidebasic" class="slideinput easyinit" type="text" data-r="bg.height">
					</div>
					
					<!-- YOUTUBE / VIMEO HTML5 SETTINGS-->
					<div class="slidebg_html5_settings slide_bg_settings">
						<longoption><i class="material-icons">aspect_ratio</i><label_a><?php _e('Video Fit Cover', 'revslider');?></label_a><input type="checkbox"  id="sl_vid_fit_cover" class="slideinput easyinit" data-r="bg.video.fitCover"/></longoption>						
					</div>
					<div class="slidebg_youtube_settings slidebg_vimeo_settings slidebg_html5_settings slide_bg_settings">
						<div class="div10"></div>
						<label_a><?php _e('Aspect Ratio', 'revslider');?></label_a><select data-theme="dark" id="slide_vid_aratio" class="slideinput tos2 nosearchbox easyinit"  data-r="bg.video.ratio"><option value="16:9">16:9</option><option value="4:3">4:3</option></select><span class="linebreak"></span>									
						<longoption><i class="material-icons">pause</i><label_a ><?php _e('Pause Timer during Play', 'revslider');?></label_a><input type="checkbox" class="easyinit slideinput" data-r="bg.video.pausetimer"></longoption>
						<longoption><i class="material-icons">loop</i><label_a ><?php _e('Loop Media', 'revslider');?></label_a><input type="checkbox" class="easyinit slideinput" id="sl_vid_loop_me" data-change="sl_vid_nextslide" data-changeto="false" data-changewhennot="false" data-r="bg.video.loop"></longoption>										
						<longoption><i class="material-icons">query_builder</i><label_a><?php _e('Start after Slide Transition', 'revslider');?></label_a><input type="checkbox"  id="sl_vid_after_slide_trans" class="slideinput easyinit" data-r="bg.video.startAfterTransition"/></longoption>
						<longoption><i class="material-icons">skip_next</i><label_a><?php _e('Next Slide at End', 'revslider');?></label_a><input type="checkbox"  id="sl_vid_nextslide" data-change="sl_vid_loop_me" data-changeto="false" data-changewhennot="false" class="slideinput easyinit" data-r="bg.video.nextSlideAtEnd" /></longoption>
						<longoption><i class="material-icons">fast_rewind</i><label_a><?php _e('Rewind at Start', 'revslider');?></label_a><input type="checkbox"  id="sl_vid_forceRewind" class="slideinput easyinit" data-r="bg.video.forceRewind" /></longoption>
						<div style="display:none !important"><longoption><i class="material-icons">volume_mute</i><label_a><?php _e('Mute at Start', 'revslider');?></label_a><input type="checkbox"  id="sl_vid_mute" class="slideinput easyinit" data-r="bg.video.mute" /></longoption></div>
						<div class="div15"></div>
						<row class="slidebg_youtube_settings slidebg_vimeo_settings slide_bg_settings directrow">
							<onelong><label_icon class="ui_volume"></label_icon><input id="slide_vid_vol" class="slideinput easyinit" type="text" data-r="bg.video.volume"></onelong>
							<oneshort><label_icon class="ui_speed"></label_icon><select data-theme="dark" id="slide_vid_speed" class="slideinput tos2 nosearchbox easyinit"  data-r="bg.video.speed"><option value="0.25">1/4</option><option value="0.50">1/2</option><option selected="selected" value="1">Normal</option><option value="1.5">x1.5</option><option value="2">x2</option></select></oneshort>
						</row>
						<row class="directrow">
							<onelong><label_icon class="ui_startat"></label_icon><input id="slide_vid_startat" class="slideinput easyinit" placeholder="00:00" type="text" data-r="bg.video.startAt"></onelong>
							<oneshort><label_icon class="ui_endat"></label_icon><input id="slide_vid_endat" class="slideinput easyinit" placeholder="00:00" type="text" data-r="bg.video.endAt"></oneshort>
						</row>
					</div>
					<div class="div15"></div>
					<div class="slidebg_youtube_settings slide_bg_settings"><label_a><?php _e('Arguments', 'revslider');?></label_a><input id="slide_vid_argsyt" class="slideinput easyinit" type="text" data-r="bg.video.args"><span class="linebreak"></span></div>
					<div class="slidebg_vimeo_settings slide_bg_settings"><label_a><?php _e('Arguments', 'revslider');?></label_a><input id="slide_vid_argvim" class="slideinput easyinit" type="text" data-r="bg.video.argsVimeo"><span class="linebreak"></span></div>
					<div class="div15"></div>
					<div class="slidebg_youtube_settings slidebg_vimeo_settings slidebg_html5_settings slide_bg_settings">
						<div class="form_inner_header" style="margin: 0px -20px 25px;"><i class="material-icons">chrome_reader_mode</i><span id="selected_slide_source"></span><?php _e('Overlay', 'revslider');?></div>
						<!-- SLIDE VIDEO OVERLAY -->
						<label_a><?php _e('Overlay', 'revslider');?></label_a><select data-evt="updateslidebasic" id="sl_vid_overlay" class="dottedoverlay slideinput tos2 nosearchbox easyinit callEvent" data-r="bg.video.dottedOverlay"></select>
						<label_a><?php _e('Overlay Size', 'revslider');?></label_a><input data-numeric="true" data-allowed="none" data-min="0"  data-r="bg.video.dottedOverlaySize" data-evt="drawBGOverlay"  type="text"  class="slideinput valueduekeyboard  easyinit callEvent" placeholder="none" >
						<label_a><?php _e('O. Color 1', 'revslider');?></label_a><input type="text" data-editing="Video Overlay Color 1" data-evt="updateslidebasic" name="slidebgoverlaycolor_a" id="slideoverlaybgcolor_a" class="my-color-field slideinput easyinit" data-visible="true" data-mode="single" data-r="bg.video.dottedColorA" value="transparent">
						<label_a><?php _e('O. Color 2', 'revslider');?></label_a><input type="text" data-editing="Video Overlay Color 2" data-evt="updateslidebasic" name="slidebgoverlaycolor_b" id="slideoverlaybgcolor_b" class="my-color-field slideinput easyinit" data-visible="true" data-mode="single" data-r="bg.video.dottedColorB" value="transparent">
					</div>
				</div>
			</div><!-- END OF SOURCE SETTINGS -->			
		</div>
	</div>

	<!-- SLIDE FILTERS -->
	<div class="form_collector slide_settings_collector" data-type="slideconfig" data-pcontainer="#slide_settings" data-offset="#rev_builder_wrapper">
		<div id="form_slide_onscroll"  class="formcontainer form_menu_inside collapsed" data-select="#gst_slide_12">
			<div class="collapsable">				
				<!-- GENERAL INFO IF NOTHING SET -->
				<div style="display:none">
					<div id="no_onscroll_on_slider">
						<div class="form_inner open">
							<div class="form_inner_header"><i class="material-icons">filter_9_plus</i><?php _e('On Scroll Details', 'revslider');?></div>
							<div class="collapsable">
								<row class="direktrow">
									<labelhalf><i class="material-icons vmi">sms_failed</i></labelhalf>
									<contenthalf><div id="onscroll_info" class="function_info"><?php _e('On Scroll can be Added per Slider in the General Options', 'revslider');?></div></contenthalf>
								</row>
							</div>
						</div>
					</div>
				</div>
				<!-- PARALLAX & 3D SETTINGS -->
				<div id="form_slidebg_pddd" class="form_inner open">
					<div class="form_inner_header"><i class="material-icons">filter_9_plus</i><?php _e('Parallax & 3D Settings', 'revslider');?></div>
					<!--<div class="form_intoaccordion" data-trigger="#sl_fbg_l1_4"><i class="material-icons">arrow_drop_down</i></div>-->
					<div class="collapsable">
						<div class="slider_ddd_subsettings">
							<label_a><?php _e('BG 3D Depth', 'revslider');?></label_a><input type="text" id="sr_paralaxlevel_16_slidebased" class="sliderinput easyinit smallinput callEvent" data-evt="updateParallaxdddBG" data-r="parallax.levels.15">
							<row class="direktrow">
								<labelhalf><i class="material-icons vmi">sms_failed</i></labelhalf>
								<contenthalf><div class="function_info"><?php _e('Global Value ! Option to find under Slider Settings - Parallax Tab', 'revslider');?></div></contenthalf>
							</row>
						</div>
						<div class="slide_parallax_wrap">
							<label_a><?php _e('Parallax Level', 'revslider');?></label_a><select data-theme="dark" id="slide_parallax_level" data-evt="enablePXModule" data-evtparam="slideparallax" class="slideinput tos2 nosearchbox easyinit prallaxlevelselect"  data-r="effects.parallax">
								<option value="-">No Parallax</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
								<option value="13">13</option>
								<option value="14">14</option>
								<option value="15">15</option>
							</select>
						</div>
					</div>
				</div><!--END OF PARALLAX & 3D SETTINGS-->

				
				<!--<div class="all_sbe_dependencies">-->
					<div id="form_slidefilter_scrollbased" class="form_inner open">
						<div class="form_inner_header"><i class="material-icons">system_update_alt</i><?php _e('Scroll Effects', 'revslider');?></div>
						<div class="collapsable">					
							<label_a><?php _e('Fade', 'revslider');?></label_a><select data-theme="dark" data-evt="enableScrollEffectModule" data-evtparam="fade" id="slide_effectscroll_fade" class="slideinput tos2 nosearchbox easyinit callEvent"  data-r="effects.fade">
								<option value="default"><?php _e('Default', 'revslider');?></option>
								<option value="true"><?php _e('Enabled - Scroll Based', 'revslider');?></option>
								<option value="false"><?php _e('Disabled - Time Based', 'revslider');?></option>
							</select>
							<label_a><?php _e('Blur', 'revslider');?></label_a><select data-theme="dark" data-evt="enableScrollEffectModule" data-evtparam="blur" id="slide_effectscroll_blur" class="slideinput tos2 nosearchbox easyinit callEvent"  data-r="effects.blur">
								<option value="default"><?php _e('Default', 'revslider');?></option>
								<option value="true"><?php _e('Enabled - Scroll Based', 'revslider');?></option>
								<option value="false"><?php _e('Disabled - Time Based', 'revslider');?></option>
							</select>
							<label_a><?php _e('Grayscale', 'revslider');?></label_a><select data-theme="dark" data-evt="enableScrollEffectModule" data-evtparam="grayscale" id="slide_effectscroll_grayscale" class="slideinput tos2 nosearchbox easyinit callEvent"  data-r="effects.grayscale">
								<option value="default"><?php _e('Default', 'revslider');?></option>
								<option value="true"><?php _e('Enabled - Scroll Based', 'revslider');?></option>
								<option value="false"><?php _e('Disabled - Time Based', 'revslider');?></option>
							</select>
						</div>
					</div>
				<!--</div>-->
			</div>
		</div>
	</div>


	<!-- SLIDE FILTERS -->
	<div class="form_collector slide_settings_collector" data-type="slideconfig" data-pcontainer="#slide_settings" data-offset="#rev_builder_wrapper">
		<div id="form_slidebg_filters"  class="formcontainer form_menu_inside collapsed" data-select="#gst_slide_5"  >
			<!--<div class="collectortabwrap"><div id="collectortab_form_slidebg_filters" class="collectortab form_menu_inside" data-forms='["#form_slidebg_filters"]'><i class="material-icons">blur_on</i><?php _e('Filters', 'revslider');?></div></div>-->
			<!-- FILTER SETTINGS -->
			<div id="form_slidebg_filters_int" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">blur_on</i><?php _e('Filters', 'revslider');?></div>
				<!--<div class="form_intoaccordion" data-trigger="#sl_fbg_l1_3"><i class="material-icons">arrow_drop_down</i></div>-->
				<div class="collapsable">
					<label_a><?php _e('BG Filter', 'revslider');?></label_a><select data-theme="dark" id="slide_bg_filter" class="slideinput tos2 nosearchbox easyinit" data-evtparam="double" data-show=".*val*_warning" data-hide=".filter_warning" data-evt="updateslidebasic" data-unselect=".filter_selector" data-select="#filter_*val*"  data-r="bg.mediaFilter">
								<option value="none">No Filter</option>
									<option value="_1977">1977</option>
									<option value="aden">Aden</option>
									<option value="brooklyn">Brooklyn</option>
									<option value="clarendon">Clarendon</option>
									<option value="earlybird">Earlybird</option>
									<option value="gingham">Gingham</option>
									<option value="hudson">Hudson</option>
									<option value="inkwell">Inkwell</option>
									<option value="lark">Lark</option>
									<option value="lofi">Lo-Fi</option>
									<option value="mayfair">Mayfair</option>
									<option value="moon">Moon</option>
									<option value="nashville">Nashville</option>
									<option value="perpetua">Perpetua</option>
									<option value="reyes">Reyes</option>
									<option value="rise">Rise</option>
									<option value="slumber">Slumber</option>
									<option value="toaster">Toaster</option>
									<option value="walden">Walden</option>
									<option value="willow">Willow</option>
									<option value="xpro2">X-pro II</option>
							</select><span class="linebreak"></span>
					<div id="inst-filter-grid">
						<div id="filter_none" data-val="none" data-hoverevtparam="none" data-leaveevtparam="double" data-leaveevt="updateslidebasic" data-select="#slide_bg_filter" data-hoverevt="showSlideFilter" class="filter_selector callhoverevt triggerselect filter_none inst-filter-griditem" data-name="No Filter"><div class="inst-filter-griditem-img none"></div></div><!--
						--><div id="filter__1977" data-val="_1977" data-hoverevtparam="_1977" data-leaveevtparam="double" data-leaveevt="updateslidebasic" data-select="#slide_bg_filter" data-hoverevt="showSlideFilter" class="filter_selector callhoverevt triggerselect filter__1977 inst-filter-griditem " data-name="1977"><div class="inst-filter-griditem-img _1977"></div></div><!--
						--><div id="filter_aden" data-val="aden" data-hoverevtparam="aden" data-leaveevtparam="double" data-leaveevt="updateslidebasic" data-select="#slide_bg_filter" data-hoverevt="showSlideFilter" class="filter_selector callhoverevt triggerselect filter_aden inst-filter-griditem " data-name="Aden"><div class="inst-filter-griditem-img aden"></div></div><!--
						--><div id="filter_brooklyn" data-val="brooklyn" data-hoverevtparam="brooklyn" data-leaveevtparam="double" data-leaveevt="updateslidebasic" data-select="#slide_bg_filter" data-hoverevt="showSlideFilter" class="filter_selector callhoverevt triggerselect filter_brooklyn inst-filter-griditem " data-name="Brooklyn"><div class="inst-filter-griditem-img brooklyn"></div></div><!--
						--><div id="filter_clarendon" data-val="clarendon" data-hoverevtparam="clarendon" data-leaveevtparam="double" data-leaveevt="updateslidebasic" data-select="#slide_bg_filter" data-hoverevt="showSlideFilter" class="filter_selector callhoverevt triggerselect filter_clarendon inst-filter-griditem " data-name="Clarendon"><div class="inst-filter-griditem-img clarendon"></div></div><!--
						--><div id="filter_earlybird" data-val="earlybird" data-hoverevtparam="earlybird" data-leaveevtparam="double" data-leaveevt="updateslidebasic" data-select="#slide_bg_filter" data-hoverevt="showSlideFilter" class="filter_selector callhoverevt triggerselect filter_earlybird inst-filter-griditem " data-name="Earlybird"><div class="inst-filter-griditem-img earlybird"></div></div><!--
						--><div id="filter_gingham" data-val="gingham" data-hoverevtparam="gingham" data-leaveevtparam="double" data-leaveevt="updateslidebasic" data-select="#slide_bg_filter" data-hoverevt="showSlideFilter" class="filter_selector callhoverevt triggerselect filter_gingham inst-filter-griditem " data-name="Gingham"><div class="inst-filter-griditem-img gingham"></div></div><!--
						--><div id="filter_hudson" data-val="hudson" data-hoverevtparam="hudson" data-leaveevtparam="double" data-leaveevt="updateslidebasic" data-select="#slide_bg_filter" data-hoverevt="showSlideFilter" class="filter_selector callhoverevt triggerselect filter_hudson inst-filter-griditem " data-name="Hudson"><div class="inst-filter-griditem-img hudson"></div></div><!--
						--><div id="filter_inkwell" data-val="inkwell" data-hoverevtparam="inkwell" data-leaveevtparam="double" data-leaveevt="updateslidebasic" data-select="#slide_bg_filter" data-hoverevt="showSlideFilter" class="filter_selector callhoverevt triggerselect filter_inkwell inst-filter-griditem " data-name="Inkwell"><div class="inst-filter-griditem-img inkwell"></div></div><!--
						--><div id="filter_lark" data-val="lark" data-hoverevtparam="lark" data-leaveevtparam="double" data-leaveevt="updateslidebasic" data-select="#slide_bg_filter" data-hoverevt="showSlideFilter" class="filter_selector callhoverevt triggerselect filter_lark inst-filter-griditem " data-name="Lark"><div class="inst-filter-griditem-img lark"></div></div><!--
						--><div id="filter_lofi" data-val="lofi" data-hoverevtparam="lofi" data-leaveevtparam="double" data-leaveevt="updateslidebasic" data-select="#slide_bg_filter" data-hoverevt="showSlideFilter" class="filter_selector callhoverevt triggerselect filter_lofi inst-filter-griditem " data-name="Lo-Fi"><div class="inst-filter-griditem-img lofi"></div></div><!--
						--><div id="filter_mayfair" data-val="mayfair" data-hoverevtparam="mayfair" data-leaveevtparam="double" data-leaveevt="updateslidebasic" data-select="#slide_bg_filter" data-hoverevt="showSlideFilter" class="filter_selector callhoverevt triggerselect filter_mayfair inst-filter-griditem " data-name="Mayfair"><div class="inst-filter-griditem-img mayfair"></div></div><!--
						--><div id="filter_moon" data-val="moon" data-hoverevtparam="moon" data-leaveevtparam="double" data-leaveevt="updateslidebasic" data-select="#slide_bg_filter" data-hoverevt="showSlideFilter" class="filter_selector callhoverevt triggerselect filter_moon inst-filter-griditem " data-name="Moon"><div class="inst-filter-griditem-img moon"></div></div><!--
						--><div id="filter_nashville" data-val="nashville" data-hoverevtparam="nashville" data-leaveevtparam="double" data-leaveevt="updateslidebasic" data-select="#slide_bg_filter" data-hoverevt="showSlideFilter" class="filter_selector callhoverevt triggerselect filter_nashville inst-filter-griditem " data-name="Nashville"><div class="inst-filter-griditem-img nashville"></div></div><!--
						--><div id="filter_perpetua" data-val="perpetua" data-hoverevtparam="perpetua" data-leaveevtparam="double" data-leaveevt="updateslidebasic" data-select="#slide_bg_filter" data-hoverevt="showSlideFilter" class="filter_selector callhoverevt triggerselect filter_perpetua inst-filter-griditem " data-name="Perpetua"><div class="inst-filter-griditem-img perpetua"></div></div><!--
						--><div id="filter_reyes" data-val="reyes" data-hoverevtparam="reyes" data-leaveevtparam="double" data-leaveevt="updateslidebasic" data-select="#slide_bg_filter" data-hoverevt="showSlideFilter" class="filter_selector callhoverevt triggerselect filter_reyes inst-filter-griditem " data-name="Reyes"><div class="inst-filter-griditem-img reyes"></div></div><!--
						--><div id="filter_rise" data-val="rise" data-hoverevtparam="rise" data-leaveevtparam="double" data-leaveevt="updateslidebasic" data-select="#slide_bg_filter" data-hoverevt="showSlideFilter" class="filter_selector callhoverevt triggerselect filter_rise inst-filter-griditem " data-name="Rise"><div class="inst-filter-griditem-img rise"></div></div><!--
						--><div id="filter_slumber" data-val="slumber" data-hoverevtparam="slumber" data-leaveevtparam="double" data-leaveevt="updateslidebasic" data-select="#slide_bg_filter" data-hoverevt="showSlideFilter" class="filter_selector callhoverevt triggerselect filter_slumber inst-filter-griditem " data-name="Slumber"><div class="inst-filter-griditem-img slumber"></div></div><!--
						--><div id="filter_toaster" data-val="toaster" data-hoverevtparam="toaster" data-leaveevtparam="double" data-leaveevt="updateslidebasic" data-select="#slide_bg_filter" data-hoverevt="showSlideFilter" class="filter_selector callhoverevt triggerselect filter_toaster inst-filter-griditem " data-name="Toaster"><div class="inst-filter-griditem-img toaster"></div></div><!--
						--><div id="filter_walden" data-val="walden" data-hoverevtparam="walden" data-leaveevtparam="double" data-leaveevt="updateslidebasic" data-select="#slide_bg_filter" data-hoverevt="showSlideFilter" class="filter_selector callhoverevt triggerselect filter_walden inst-filter-griditem " data-name="Walden"><div class="inst-filter-griditem-img walden"></div></div><!--
						--><div id="filter_willow" data-val="willow" data-hoverevtparam="willow" data-leaveevtparam="double" data-leaveevt="updateslidebasic" data-select="#slide_bg_filter" data-hoverevt="showSlideFilter" class="filter_selector callhoverevt triggerselect filter_willow inst-filter-griditem " data-name="Willow"><div class="inst-filter-griditem-img willow"></div></div><!--
						--><div id="filter_xpro2" data-val="xpro2" data-hoverevtparam="xpro2" data-leaveevtparam="double" data-leaveevt="updateslidebasic" data-select="#slide_bg_filter" data-hoverevt="showSlideFilter" class="filter_selector callhoverevt triggerselect filter_xpro2 inst-filter-griditem " data-name="X-pro"><div class="inst-filter-griditem-img xpro2"></div></div>
					</div>
					<div class="div25"></div>					
					<row class="direktrow filter_warning earlybird_warning, lark_warning moon_warning toaster_warning willow_warning xpro2_warning">
						<labelhalf><i class="material-icons vmi">sms_failed</i></labelhalf>
						<contenthalf><div class="function_info"><?php _e('The Filter may not work with HTML5 Videos in Internet Explorer and Edge Browsers', 'revslider');?></div></contenthalf>
					</row>
					
				</div><!-- END OF COLLAPSABLE -->
			</div><!-- END OF FILTER SETTINGS -->
		</div>
	</div>

	<!-- SLIDE ANIMATION SETTINGS-->
	<div class="form_collector slide_settings_collector" data-type="slideconfig" data-pcontainer="#slide_settings" data-offset="#rev_builder_wrapper">
		<div id="form_slide_transition"  class="formcontainer form_menu_inside collapsed" data-select="#gst_slide_2" >
			<!--<div class="collectortabwrap"><div id="collectortab_form_slide_transition" class="collectortab form_menu_inside" data-forms='["#form_slidebg_transition"]'><?php _e('Animation', 'revslider');?></div></div>			-->
			<!--<div class="form_intoaccordion"><i class="material-icons">arrow_drop_down</i></div>-->

			<!--  SLIDE ANIMATION & PRESETS -->
			<div id="form_slidebg_transition" class="form_inner">
				<div class="form_inner_header"><i class="material-icons">photo_filter</i><?php _e('Transition Presets', 'revslider');?></div>
				<div class="collapsable" style="display:block">	
					<div id="active_transitions" class="saw_cells">						
						<div id="active_transitions_innerwrap"></div>	
						<longoption class="centered_longoption" id="sl_trans_favorit"><i class="material-icons">star</i><label_a><?php _e('Show Only Favorites', 'revslider');?></label_a><input type="checkbox" id="sl_trans_favorit_inp" class="easyinit slideinput callEvent" data-evt="updateSlideAnimationFavoits" data-r="slideChange.favorit"></longoption>
						<div class="div20"></div>					
						<div class="presets_liste" id="active_transitions_innerwrap_results"></div>						
						<div class="tp-clearfix"></div>
						<div id="transition_selector" style="display:none"></div>
					</div>														
				</div>
			</div>
			<!-- ADVANCED SETTINGS FOR ANIMATION -->
			<div id="form_sanimation_sframes_advanced" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">tune</i><?php _e('Advanced', 'revslider');?></div>
				<div id="form_sanimation_sframes_innerwrap" class="collapsable">
					
				
					<!-- LAYER FRAME TRANSFORM  -->
					<div id="slide_maintranssettings_wrap" class="slide_transsettings_wrap">
						<div id="slidebasic_ts_wrapbrtn" class="ts_wrapbrtn"><div data-showtrans="#slide_transsettings" data-frametarget="slide" class="transtarget_selector selected" ><?php _e('Timing', 'revslider');?></div></div><!--
						--><div style="display:inline-block"><div id="slidein_ts_wrapbrtn" class="ts_wrapbrtn"><div data-showtrans="#slidein_transsettings" class="transtarget_selector" ><?php _e('In', 'revslider');?></div></div></div><!--
						--><div style="display:inline-block"><div id="slideout_ts_wrapbrtn" class="ts_wrapbrtn"><div data-showtrans="#slideout_transsettings" class="transtarget_selector"><?php _e('Out', 'revslider');?></div></div></div><!--
						--><div style="display:inline-block"><div id="slidefilter_ts_wrapbrtn" class="ts_wrapbrtn"><div data-showtrans="#slidefilter_transsettings" class="transtarget_selector"><?php _e('Filters', 'revslider');?></div></div></div><!--
						--><div style="display:inline-block"><div id="slide3d_ts_wrapbrtn" class="ts_wrapbrtn"><div data-showtrans="#slide3d_transsettings" class="transtarget_selector"><?php _e('3D', 'revslider');?></div></div></div><!--						
					--></div>
					<div class="div20"></div>
					<!-- SLIDE IN TRANSFORMATIONS -->
					<div id="slide_transsettings" class="group_transsettings">
						<div style="display:none"><label_a><?php _e('Effect', 'revslider');?></label_a><select id="sltrans_effect" data-showprio="hide" data-show="._ST_*val*_SHOW, ._ST_ALL" data-hide="._ST_*val*_HIDE" class="slideinput tos2 nosearchbox easyinit callEvent" data-evt="updateSlideAnimationView" data-r="slideChange.e" data-theme="dark">
							<option value="none"><?php _e('None', 'revslider');?></option>
							<option value="basic"><?php _e('Basic Transforms', 'revslider');?></option>								
							<option value="slidingoverlay"><?php _e('Sliding Overlays', 'revslider');?></option>								
							</select>
						</div>
						<div id="sltrans_all_globals">
							<div id="slideframespeed_wrap"><label_a><?php _e('Duration', 'revslider');?></label_a><input id="sltrans_duration" class="callEvent withsuffix slideinput valueduekeyboard smallinput easyinit input_with_presets" data-suffix="ms" data-numeric="true" data-allowed="default,ms" data-presets_text="$C$1000ms!$I$Default" data-presets_val="1000!default" data-evt="updateSlideTransitionTimeLine" data-r="slideChange.speed" data-steps="300" type="text"><div id="slideframespeed_sub"></div></div>
							<div id="sltrans_pause">
								<label_a><?php _e('Pause Between', 'revslider');?></label_a><select id="sltrans_breaking" class="slideinput tos2 nosearchbox easyinit callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom" data-r="slideChange.p" data-theme="dark">
									<option value="none"><?php _e('No Pause', 'revslider');?></option>
									<option value="dark"><?php _e('Pause with Dark Background', 'revslider');?></option>
									<option value="light"><?php _e('Pause with Light Background', 'revslider');?></option>
									<option value="transparent"><?php _e('Pause with Transparent BG', 'revslider');?></option>									
								</select><span class="linebreak"></span>
							</div>
							<div id="sltrans_flow">
								<label_a><?php _e('Flow', 'revslider');?></label_a><select id="sltrans_from" class="slideinput tos2 nosearchbox easyinit callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom"  data-showprio="hide" data-show="._STFD_ALL" data-hide="._STFD_*val*_HIDE" data-r="slideChange.f" data-theme="dark">
									<option value="default"><?php _e('Default', 'revslider');?></option>
									<option value="start"><?php _e('Forwards', 'revslider');?></option>
									<option value="end"><?php _e('Backwards', 'revslider');?></option>
									<option value="center"><?php _e('From Center', 'revslider');?></option>
									<option value="edges"><?php _e('From Edges', 'revslider');?></option>
									<option value="slidebased"><?php _e('Slide Direction Based', 'revslider');?></option>
									<option value="oppslidebased"><?php _e('Mirror Slide Direction', 'revslider');?></option>
									<option value="nodelay"><?php _e('No Delays', 'revslider');?></option>
									<option value="random"><?php _e('Random', 'revslider');?></option>
								</select><span class="linebreak"></span>
								<div class="_STFD_nodelay_HIDE _STFD_ALL"><label_a><?php _e('Flow Speed', 'revslider');?></label_a><input id="sltrans_fromdelay" class="slideinput valueduekeyboard smallinput easyinit callEvent" data-allowed="" data-evt="updateSlideTransitionTimeLine" data-numeric="true" data-r="slideChange.d" data-min="5" data-max="100"  type="text"></div>
								<label_a><?php _e('Index Order', 'revslider');?></label_a><select id="sltrans_order" class="slideinput tos2 nosearchbox easyinit callEvent" data-evt="updateSlideAnimation"  data-evtparam="tocustom"  data-r="slideChange.o" data-theme="dark">
									<option value="inout"><?php _e('Auto / Default', 'revslider');?></option>
									<option value="forceinout"><?php _e('In Over Out', 'revslider');?></option>
									<option value="outin"><?php _e('Out over In', 'revslider');?></option>
								</select><span class="linebreak"></span>
							</div>
						</div>
					</div>
					<!-- SLIDE IN TRANSFORMATIONS -->
					<div id="slidein_transsettings" class="group_transsettings" style="display:none">
						<!-- TRANSFORM IN BASIC SETTINGS-->
						<div id="sltrans_in_full_wrap">							
							<row class="direktrow" id="sltrans_in_rowcol_wrap">
								<onelong><label_a><?php _e('Cols', 'revslider');?></label_a><input id="sltrans_in_col" class="slideinput valueduekeyboard smallinput easyinit input_with_presets callEvent" data-evt="colrowslideanimchange" data-numeric="true" data-allowed="random,default" data-presets_text="$C$1!$C$2!$C$5!$C$10!$R$Random!$I$Default" data-presets_val="1!2!5!10!random!default!"  data-r="slideChange.in.col" data-evtparam="in.col" data-steps="0" data-min="1" data-max="500"  type="text"></onelong>
								<oneshort><label_a style="overflow:visible"><?php _e('Rows', 'revslider');?></label_a><input id="sltrans_in_row" class="slideinput valueduekeyboard smallinput easyinit input_with_presets callEvent" data-evt="colrowslideanimchange" data-numeric="true" data-allowed="random,default" data-presets_text="$C$1!$C$2!$C$5!$C$10!$R$Random!$I$Default" data-presets_val="1!2!5!10!random!default!"  data-evtparam="in.row" data-r="slideChange.in.row" data-steps="1" data-min="0" data-max="500"  type="text"></oneshort>						
							</row>
							<div id="sltrans_in_ease_wrap"><label_a><?php _e('Ease', 'revslider');?></label_a><select id="sltrans_in_ease" class="slideinput tos2 nosearchbox easyinit easingSelect callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom"  data-r="slideChange.in.e" data-theme="dark"></select></div>
							<row class="direktrow" id="sltrans_in_mamo_wrap">
								<onelong id="sltrans_in_mask_wrap"><label_a><?php _e('Mask', 'revslider');?></label_a><input type="checkbox" class="easyinit slideinput callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom"  data-r="slideChange.in.m"></onelong>
								<oneshort id="sltrans_in_motionswitch_wrap"><label_a style="overflow: visible;margin-left: -12px;margin-right: 22px;"><?php _e('Motion', 'revslider');?></label_a><input type="checkbox" data-change="sltrans_in_fade" data-changeto='0' data-changewhen="true" data-disable="#sltrans_in_opa_wrap" data-enable="#sltrans_in_motion_wrap" data-showhide="#sltrans_in_motion_overlay_wrap" data-showhidedep="true" data-disableenable="switch" class="easyinit slideinput callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom"  data-r="slideChange.in.mou"></oneshort>
							</row>
							<row class="direktrow" id="sltrans_in_xy_wrap">				
								<onelong class="dyn_inp_wrap" id="sltrans_in_x_wrap"><label_icon class="ui_x"></label_icon><input id="sltrans_in_x" class="rsdyn_inp slideinput valueduekeyboard smallinput easyinit input_with_presets callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom"  data-numeric="true" data-allowed="%,random,cycle,dir" data-presets_text="val - Standard!{min,max} - Random![val|val|val] - Cycles!(val) - Direction Based" data-presets_val="100%!{-20,20}![-50|50]!(100%)" data-r="slideChange.in.x" data-steps="1" data-min="-300" data-max="300" type="text"></onelong>
								<oneshort class="dyn_inp_wrap" id="sltrans_in_y_wrap"><label_icon class="ui_y"></label_icon><input id="sltrans_in_y" class="rsdyn_inp slideinput valueduekeyboard smallinput easyinit input_with_presets callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom"  data-numeric="true" data-allowed="%,random,cycle,dir" data-presets_text="val - Standard!{min,max} - Random![val|val|val] - Cycles!(val) - Direction Based" data-presets_val="100%!{-20,20}![-50|50]!(100%)" data-r="slideChange.in.y" data-steps="1" data-min="-300" data-max="300" type="text"></oneshort>						
							</row>
							<row class="direktrow"  id="sltrans_in_rzo_wrap">				
								<onelong class="dyn_inp_wrap" id="sltrans_in_rota_wrap"><label_icon class="ui_rotatez"></label_icon><input id="sltrans_in_rotation" class="rsdyn_inp slideinput valueduekeyboard smallinput easyinit input_with_presets callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom" data-numeric="true" data-allowed="deg,random,cycle,dir" data-presets_text="deg - Standard!{min,max} - Random![val|val|val] - Cycles!(val) - Direction Based" data-presets_val="45deg!{-20,20}![-50|50]!(45deg)" data-r="slideChange.in.r" data-steps="45" type="text"></onelong>
								<oneshort id="sltrans_in_opa_wrap"><label_icon class="ui_opacity"></label_icon><input id="sltrans_in_fade" class="slideinput valueduekeyboard smallinput easyinit callEvent" data-evt="updateSlideAnimation"   data-numeric="true" data-allowed="." data-r="slideChange.in.o" data-steps="0.1" data-min="-3" data-max="1" type="text"></oneshort>
							</row>
							<row class="direktrow" id="sltrans_in_sxsy_wrap">
								<onelong class="dyn_inp_wrap" id="sltrans_in_sx_wrap"><label_icon class="ui_scalex"></label_icon><input id="sltrans_in_scalex" class="rsdyn_inp slideinput valueduekeyboard smallinput easyinit input_with_presets callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom"  data-numeric="true" data-allowed=".,random,cycle" data-presets_text="val - Standard!{min,max} - Random![val|val|val] - Cycles" data-presets_val="1.5!{0,3}![0.3|1.5]" data-r="slideChange.in.sx" data-steps="0.1" data-min="0" data-max="500" type="text"></onelong>
								<oneshort class="dyn_inp_wrap" id="sltrans_in_sy_wrap"><label_icon class="ui_scaley"></label_icon><input id="sltrans_in_scaley" class="rsdyn_inp slideinput valueduekeyboard smallinput easyinit input_with_presets callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom"  data-numeric="true" data-allowed=".,random,cycle" data-presets_text="val - Standard!{min,max} - Random![val|val|val] - Cycles" data-presets_val="1.5!{0,3}![0.3|1.5]" data-r="slideChange.in.sy" data-steps="0.1" data-min="0" data-max="500" type="text"></oneshort>						
							</row>
							<row class="direktrow"  id="sltrans_in_motionand_wrap">				
								<onelong class="dyn_inp_wrap" id="sltrans_in_motion_wrap"><i class="label_icon material-icons">blur_linear</i><input id="sltrans_filter_motion" class="slideinput valueduekeyboard smallinput easyinit callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom"  data-numeric="true" data-allowed="px" data-min="0" data-max="100" data-r="slideChange.in.mo" type="text"></onelong>
								<oneshort></oneshort>
							</row>				
							<row id="sltrans_in_motion_overlay_wrap"><label_a><?php _e('Overlay', 'revslider');?></label_a><select
								id="sltrans_in_motion_overlay" class="slideinput tos2 nosearchbox easyinit callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom"  data-r="slideChange.in.moo" data-theme="dark">
									<option value="none"><?php _e('None', 'revslider');?></option>
									<option value="partial"><?php _e('Partial', 'revslider');?></option>
									<option value="full"><?php _e('Full', 'revslider');?></option>
								</select>
							</row>
							<div id="sltrans_in_extensions_wrap"></div>
						</div>
					</div>
					<!-- SLIDE OUT TRANSFORMATIONS -->
					<div id="slideout_transsettings" class="group_transsettings" style="display:none">
						<div id="sltrans_out_full_wrap">							
							<!-- TRANSFORM OUT BASIC SETTINGS -->																		
							<longoption id="sltrans_in_auto_input_wrap"><label_a><?php _e('Use Auto Animation', 'revslider');?></label_a><input id="slidechangeouta" type="checkbox" class="easyinit slideinput callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom"  data-showhide="#sltrans_out_auto" data-showhidedep="false" data-r="slideChange.out.a"></longoption>
							<div id="sltrans_out_auto">
								<div class="div25"></div>
								<row class="direktrow" id="sltrans_out_rowcol_wrap">
									<onelong><label_a><?php _e('Cols', 'revslider');?></label_a><input id="sltrans_out_col" class="slideinput valueduekeyboard smallinput easyinit input_with_presets callEvent" data-evt="colrowslideanimchange" data-numeric="true" data-allowed="random,default" data-presets_text="$C$1!$C$2!$C$5!$C$10!$R$Random!$I$Default" data-presets_val="1!2!5!10!random!default!"  data-r="slideChange.out.col" data-evtparam="out.col" data-steps="0" data-min="1" data-max="500"  type="text"></onelong>
									<oneshort><label_a style="overflow:visible"><?php _e('Rows', 'revslider');?></label_a><input id="sltrans_out_row" class="slideinput valueduekeyboard smallinput easyinit input_with_presets callEvent" data-evt="colrowslideanimchange" data-numeric="true" data-allowed="random,default" data-presets_text="$C$1!$C$2!$C$5!$C$10!$R$Random!$I$Default" data-presets_val="1!2!5!10!random!default!"  data-evtparam="out.row" data-r="slideChange.out.row" data-steps="1" data-min="0" data-max="500"  type="text"></oneshort>
								</row>
								<div id="sltrans_out_ease_wrap"><label_a><?php _e('Ease', 'revslider');?></label_a><select id="sltrans_out_ease" class="slideinput tos2 nosearchbox easyinit easingSelect callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom"  data-r="slideChange.out.e" data-theme="dark"></select></div>
								<row class="direktrow">
									<onelong id="sltrans_out_mask_wrap"><label_a><?php _e('Mask', 'revslider');?></label_a><input type="checkbox" class="rsdyn_inp easyinit slideinput callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom"  data-r="slideChange.out.m"></onelong>
									<oneshort></oneshort>
								</row>							
								<row class="direktrow"  id="sltrans_out_xy_wrap">				
									<onelong class="dyn_inp_wrap" id="sltrans_out_x_wrap"><label_icon class="ui_x"></label_icon><input id="sltrans_out_x" class="rsdyn_inp slideinput valueduekeyboard smallinput easyinit input_with_presets callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom"  data-numeric="true" data-allowed="%,random,cycle,dir" data-presets_text="val - Standard!{min,max} - Random![val|val|val] - Cycles!(val) - Direction Based" data-presets_val="100%!{-20,20}![-50|50]!(100%)" data-r="slideChange.out.x" data-steps="1" data-min="-300" data-max="300" type="text"></onelong>
									<oneshort class="dyn_inp_wrap" id="sltrans_out_y_wrap"><label_icon class="ui_y"></label_icon><input id="sltrans_out_y" class="rsdyn_inp slideinput valueduekeyboard smallinput easyinit input_with_presets callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom"  data-numeric="true" data-allowed="%,random,cycle,dir" data-presets_text="val - Standard!{min,max} - Random![val|val|val] - Cycles!(val) - Direction Based" data-presets_val="100%!{-20,20}![-50|50]!(100%)" data-r="slideChange.out.y" data-steps="1" data-min="-300" data-max="300" type="text"></oneshort>						
								</row>
								<row class="direktrow"  id="sltrans_out_rzo_wrap">				
									<onelong class="dyn_inp_wrap" id="sltrans_out_rota_wrap"><label_icon class="ui_rotatez"></label_icon><input id="sltrans_out_rotation" class="rsdyn_inp slideinput valueduekeyboard smallinput easyinit input_with_presets callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom"  data-numeric="true" data-allowed="deg,random,cycle,dir" data-presets_text="deg - Standard!{min,max} - Random![val|val|val] - Cycles!(val) - Direction Based" data-presets_val="45deg!{-20,20}![-50|50]!(45deg)" data-r="slideChange.out.r" data-steps="45" type="text"></onelong>
									<oneshort id="sltrans_out_opa_wrap"><label_icon class="ui_opacity"></label_icon><input id="sltrans_out_fade" class="slideinput valueduekeyboard smallinput easyinit callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom"  data-numeric="true" data-allowed="." data-r="slideChange.out.o" data-steps="0.1" data-min="-3" data-max="1" type="text"></oneshort>
								</row>
								<row class="direktrow" id="sltrans_out_sxsy_wrap">
									<onelong class="dyn_inp_wrap" id="sltrans_out_sx_wrap"><label_icon class="ui_scalex"></label_icon><input id="sltrans_out_scalex" class="rsdyn_inp slideinput valueduekeyboard smallinput easyinit input_with_presets callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom"  data-numeric="true" data-allowed=".,random,cycle" data-presets_text="val - Standard!{min,max} - Random![val|val|val] - Cycles" data-presets_val="1.5!{0,3}![0.3|1.5]"  data-r="slideChange.out.sx" data-steps="0.1" data-min="0" data-max="500" type="text"></onelong>
									<oneshort class="dyn_inp_wrap" id="sltrans_out_sy_wrap"><label_icon class="ui_scaley"></label_icon><input id="sltrans_out_scaley" class="rsdyn_inp slideinput valueduekeyboard smallinput easyinit input_with_presets callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom"  data-numeric="true" data-allowed=".,random,cycle" data-presets_text="val - Standard!{min,max} - Random![val|val|val] - Cycles" data-presets_val="1.5!{0,3}![0.3|1.5]"  data-r="slideChange.out.sy" data-steps="0.1" data-min="0" data-max="500" type="text"></oneshort>						
								</row>
								<div id="sltrans_in_extensions_wrap">
								</div>							
							</div>								
						</div>
					</div>
					<!-- SLIDE FILTER TRANSFORMATIONS -->
					<div id="slidefilter_transsettings" class="group_transsettings" style="display:none">
						<div id="sltrans_filters_wrap">
							<div id="sltrans_in_filters_wrap">								
								<longoption id="sltrans_filter_input_wrap"><label_a><?php _e('Use Filter Effects', 'revslider');?></label_a><input id="slidechangefilteru" type="checkbox" class="easyinit slideinput callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom"  data-showhide="#sltrans_filter_sets" data-showhidedep="true" data-r="slideChange.filter.u"></longoption>						
								<div id="sltrans_filter_sets">
									<div class="div25"></div>
									<label_a><?php _e('Ease', 'revslider');?></label_a><select id="sltrans_filter_ease" class="slideinput tos2 nosearchbox easyinit callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom"  data-r="slideChange.filter.e" data-theme="dark">
										<option value="default"><?php _e('Default', 'revslider');?></option>
										<option value="late"><?php _e('Small Delay', 'revslider');?></option>
										<option value="late2"><?php _e('Middle Delay', 'revslider');?></option>
										<option value="late3"><?php _e('Large Delay', 'revslider');?></option>								
									</select><span class="linebreak"></span>												
									<row class="direktrow">
										<onelong><label_icon class="ui_blur"></label_icon><input id="slidechangefilterb" class="slideinput valueduekeyboard smallinput easyinit callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom"  data-numeric="true" data-allowed="px" data-min="0" data-max="100" data-r="slideChange.filter.b" type="text"></onelong>
										<oneshort><i class="label_icon material-icons inshort">filter_vintage</i><input id="slidechangefilters" class="slideinput valueduekeyboard smallinput easyinit callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom"  data-numeric="true" data-allowed="%,px" data-min="0" data-max="100" data-r="slideChange.filter.s" type="text"></oneshort>
									</row>
									<row class="direktrow">
										<onelong><label_icon class="ui_grayscale"></label_icon><input id="slidechangefilterg" class="slideinput valueduekeyboard smallinput easyinit callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom"  data-numeric="true" data-allowed="%" data-min="0" data-max="100" data-r="slideChange.filter.g" type="text"></onelong>
										<oneshort><label_icon class="ui_brightness"></label_icon><input id="slidechangefilterh" class="slideinput valueduekeyboard smallinput easyinit callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom" data-numeric="true" data-allowed="%" data-min="0" data-max="10000" data-r="slideChange.filter.h" type="text"></oneshort>
									</row>
									<row class="direktrow">
										<onelong><i class="label_icon material-icons">photo_filter</i><input id="slidechangefilterc" class="slideinput valueduekeyboard smallinput easyinit callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom" data-numeric="true" data-allowed="%,px" data-min="0" data-max="100" data-r="slideChange.filter.c" type="text"></onelong>
										<oneshort><i class="label_icon material-icons inshort">invert_colors</i><input id="slidechangefilteri" class="slideinput valueduekeyboard smallinput easyinit callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom" data-numeric="true" data-allowed="%,px" data-min="0" data-max="100" data-r="slideChange.filter.i" type="text"></oneshort>
									</row>								
								</div>									
							</div>				
						</div>
					</div>
					<!-- SLIDE 3D TRANSFORMATIONS -->
					<div id="slide3d_transsettings" class="group_transsettings" style="display:none">
						<div id="sltrans_3d_wrap">
							<div id="sltrans_in_3d_wrap">																
								<div id="sltrans_3d_sets">									
									<label_a><?php _e('3D Effect', 'revslider');?></label_a><select id="sltrans_3d_effect" class="slideinput tos2 nosearchbox easyinit callEvent" data-showprio="show" data-show="._3DST_*val*_SHOW" data-hide="._3DST_ALL"  data-evt="updateSlideAnimation" data-evtparam="tocustom"  data-r="slideChange.d3.f" data-theme="dark">
										<option value="none"><?php _e('None', 'revslider');?></option>
										<option value="cube"><?php _e('Cube', 'revslider');?></option>
										<option value="incube"><?php _e('In Cube', 'revslider');?></option>
										<option value="fly"><?php _e('Fly Out Throw In', 'revslider');?></option>								
										<option value="turn"><?php _e('Clap Out Clap In', 'revslider');?></option>								
									</select><span class="linebreak"></span>
									<label_a><?php _e('Direction', 'revslider');?></label_a><select id="sltrans_3d_dir" class="slideinput tos2 nosearchbox easyinit callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom"  data-r="slideChange.d3.d" data-theme="dark">
										<option value="horizontal"><?php _e('Horizontal', 'revslider');?></option>
										<option value="vertical"><?php _e('Vertical', 'revslider');?></option>										
									</select><span class="linebreak"></span>
									<label_a><?php _e('Ease', 'revslider');?></label_a><select id="sltrans_3d_ease" class="slideinput tos2 nosearchbox easyinit easingSelect callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom"  data-r="slideChange.d3.e" data-theme="dark"></select>
									<div class="_3DST_cube_SHOW _3DST_incube_SHOW _3DST_ALL">
										<div class="div25"></div>
										<label_a><?php _e('Side Color', 'revslider');?></label_a><input type="text" data-evt="updateSlideAnimation" data-evtparam="tocustom" data-editing="<?php _e('Background Wall Color', 'revslider');?>" name="slide_wall_bg_color" id="s_wall_bg_color" data-visible="true" class="my-color-field slideinput easyinit" data-r="slideChange.d3.c" data-mode="single">
									</div>
									<div class="_3DST_cube_SHOW _3DST_incube_SHOW _3DST_ALL _3DST_fly_SHOW">
										<div class="div25"></div>
										<label_a><?php _e('Z Distance', 'revslider');?></label_a><input id="slidechangedddz" class="slideinput valueduekeyboard smallinput easyinit callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom" data-numeric="true" data-allowed="" data-min="0" data-max="1000" data-r="slideChange.d3.z" type="text">
										<label_a><?php _e('Room Rotation', 'revslider');?></label_a><input id="slidechangedddroom" class="slideinput valueduekeyboard smallinput easyinit callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom" data-numeric="true" data-allowed="" data-min="-180" data-max="180" data-r="slideChange.d3.t" type="text">										
									</div>									
									<div class="_3DST_ALL _3DST_fly_SHOW">
										<div class="div25"></div>
										<label_a><?php _e('Z Rotation', 'revslider');?></label_a><input id="sltrans_3d_fdz" class="slideinput valueduekeyboard smallinput easyinit callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom" data-numeric="true" data-allowed="" data-min="-180" data-max="180" data-r="slideChange.d3.fz" type="text">
										<label_a><?php _e('Distance In', 'revslider');?></label_a><select id="sltrans_3d_fdi" class="slideinput tos2 nosearchbox easyinit callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom"  data-r="slideChange.d3.fdi" data-theme="dark">
											<option value="0.5"><?php _e('0.5', 'revslider');?></option>
											<option value="0.75"><?php _e('0.75', 'revslider');?></option>
											<option value="1"><?php _e('1', 'revslider');?></option>
											<option value="1.25"><?php _e('1.25', 'revslider');?></option>
											<option value="1.5"><?php _e('1.5', 'revslider');?></option>
											<option value="2"><?php _e('2', 'revslider');?></option>
										</select><span class="linebreak"></span>
										<label_a><?php _e('Distance Out', 'revslider');?></label_a><select id="sltrans_3d_fdo" class="slideinput tos2 nosearchbox easyinit callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom"  data-r="slideChange.d3.fdo" data-theme="dark">
											<option value="0.5"><?php _e('0.5', 'revslider');?></option>
											<option value="0.75"><?php _e('0.75', 'revslider');?></option>
											<option value="1"><?php _e('1', 'revslider');?></option>
											<option value="1.25"><?php _e('1.25', 'revslider');?></option>
											<option value="1.5"><?php _e('1.5', 'revslider');?></option>
											<option value="2"><?php _e('2', 'revslider');?></option>
										</select><span class="linebreak"></span>
									</div>
									<div class="div25"></div>
									<label_a><?php _e('Shadow Effect', 'revslider');?></label_a><input id="sl_ddd_shadow_u" type="checkbox" class="easyinit slideinput callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom"  data-showhide="#three3dcubeshadow" data-showhidedep="true" data-r="slideChange.d3.su">
									<div id="three3dcubeshadow">
										<label_a><?php _e('Min. Strength', 'revslider');?></label_a><input id="sl_ddd_shadow_min" class="slideinput valueduekeyboard smallinput easyinit callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom" data-numeric="true" data-allowed="" data-min="0" data-max="0.5" data-r="slideChange.d3.smi" type="text">
										<label_a><?php _e('Max. Strength', 'revslider');?></label_a><input id="sl_ddd_shadow_max" class="slideinput valueduekeyboard smallinput easyinit callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom" data-numeric="true" data-allowed="" data-min="0.5" data-max="1" data-r="slideChange.d3.sma" type="text">
										<label_a><?php _e('Limit at', 'revslider');?></label_a><input id="sl_ddd_shadow_limit" class="slideinput valueduekeyboard smallinput easyinit callEvent" data-evt="updateSlideAnimation" data-evtparam="tocustom" data-numeric="true" data-allowed="" data-min="0.2" data-max="1" data-r="slideChange.d3.sl" type="text">
										<label_a><?php _e('Shadow Color', 'revslider');?></label_a><input id="slide_shadow_color" type="text" data-evt="updateSlideAnimation" data-evtparam="tocustom" data-editing="<?php _e('Shadow Color', 'revslider');?>" name="slide_shadow_color"  data-visible="true" class="my-color-field slideinput easyinit" data-r="slideChange.d3.sc" data-mode="single">
									</div>
								</div>									
							</div>				
						</div>
					</div>
				</div>
			</div>

			<div id="form_sanimation_sframes_perf" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">speed</i><?php _e('Performance', 'revslider');?></div>
				<div id="form_sanimation_sperform_innerwrap" class="collapsable">
					<row id="sltrans_dpr_wrap">
						<longoption id="sltrans_dpr"><label_a style="min-width:160px"><?php _e('Prioritize Performance', 'revslider');?></label_a><input id="slidechangedpr" type="checkbox" class="easyinit slideinput callEvent" data-evt="updateSlideAnimation" data-r="slideChange.adpr"></longoption>
					</row>
					<div class="div10"></div>
					<row class="direktrow">
						<labelhalf><i class="material-icons vmi">sms_failed</i></labelhalf>
						<contenthalf><div class="function_info"><?php _e('Win performance in complex transitions by reducing the image quality during animations', 'revslider');?></div></contenthalf>
					</row>
				</div>
			</div>
			<!-- ADVANCED SETTINGS FOR ANIMATION -->
			<div id="form_sanimation_sframes_alternates" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">slow_motion_video</i><?php _e('Alternated Transitions', 'revslider');?></div>
				<div id="form_sanimation_sfalternates_innerwrap" class="collapsable">
					<div id="sanimation_sfalternates">
					</div>
					<div class="autosize rightbutton basic_action_button callEventButton" data-evt="addslidetransition"><i class="material-icons">add</i>Add Transition</div>
					<div class="div25"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- END OF SLIDE ANIMATION SETTINGS-->


	<!-- SLIDE PAN ZOOM SETTINGS-->
	<div class="form_collector slide_settings_collector" data-type="slideconfig" data-pcontainer="#slide_settings" data-offset="#rev_builder_wrapper">
		<div id="form_slide_kenburn_outter"  class="formcontainer form_menu_inside collapsed" data-select="#gst_slide_3" >
			<!--<div class="collectortabwrap"><div id="collectortab_form_slide_transition" class="collectortab form_menu_inside" data-forms='["#form_slide_kenburn_outter"]'><?php _e('Ken Burns / Pan Zoom', 'revslider');?></div></div>			-->
			<!--<div class="form_intoaccordion"><i class="material-icons">arrow_drop_down</i></div>-->
			<!-- KEN BURN SETTINGS-->
			<div id="form_slidebg_kenburn" class="form_inner">
				<div id="sl_pz_innerheader" class="form_inner_header"><i class="material-icons">photo_filter</i><?php _e('Pan Zoom Settings', 'revslider');?></div>
				<div id="sl_pz_onoff" class="on_off_navig_wrap"><input type="checkbox"  data-evt="updateKenBurnBasics" id="sl_pz_set" data-showhide="#internal_kenburn_settings" data-showhidedep="true" class="slideinput easyinit" data-r="panzoom.set" /></div>
				<div id="kenburnissue" class="collapsable">
					<row class="direktrow">
						<labelhalf><i class="material-icons vmi">sms_failed</i></labelhalf>
						<contenthalf><div id="kenburnissue_info" class="function_info"><?php _e('Place the shortcode on the page or post where you want to show this module.', 'revslider');?></div></contenthalf>
					</row>
				</div>
				<div id="internal_kenburn_settings" class="collapsable" style="display:block !important">
					<div class="slidebg_image_settings slidebg_external_settings slide_bg_settings">
						<div id="ken_burn_bg_setting_on">
						</div>

						<row id="sl_pz_fs_fe" class="direktrow">
							<onelong id="sl_pz_fs_wrap"><label_a><?php _e('Zoom From', 'revslider');?></label_a><input data-allowed="%" data-numeric="true" data-evt="updateKenBurnSettings" data-evtparam="begin" id="sl_pz_fs" class="slideinput easyinit verysmallinput valueduekeyboard" data-min="0" data-max="1000" type="text" data-r="panzoom.fitStart"></onelong>
							<oneshort><label_a><?php _e('To', 'revslider');?></label_a><input data-allowed="%" data-numeric="true" data-evt="updateKenBurnSettings" data-evtparam="end" id="sl_pz_fe" class="slideinput easyinit verysmallinput valueduekeyboard" data-min="0" data-max="1000" type="text" data-r="panzoom.fitEnd"></oneshort>
						</row>

						<row id="sl_pz_xs_xe" class="direktrow">
							<onelong><label_a><?php _e('X From', 'revslider');?></label_a><input data-allowed="px" data-numeric="true" data-evt="updateKenBurnSettings" data-evtparam="begin" id="sl_pz_xs" class="slideinput easyinit verysmallinput valueduekeyboard" data-min="-1000" data-max="1000" type="text" data-r="panzoom.xStart"></onelong>
							<oneshort><label_a><?php _e('To', 'revslider');?></label_a><input data-allowed="px" data-numeric="true" data-evt="updateKenBurnSettings" data-evtparam="end" id="sl_pz_xe" class="slideinput easyinit verysmallinput valueduekeyboard" data-min="-1000" data-max="1000" type="text" data-r="panzoom.xEnd"></oneshort>
						</row>

						<row id="sl_pz_ys_ye" class="direktrow">
							<onelong><label_a><?php _e('Y From', 'revslider');?></label_a><input data-allowed="px" data-numeric="true" data-evt="updateKenBurnSettings" data-evtparam="begin" id="sl_pz_ys" class="slideinput easyinit verysmallinput valueduekeyboard" data-min="-1000" data-max="1000" type="text" data-r="panzoom.yStart"></onelong>
							<oneshort><label_a><?php _e('To', 'revslider');?></label_a><input data-allowed="px" data-numeric="true" data-evt="updateKenBurnSettings" data-evtparam="end" id="sl_pz_ye" class="slideinput easyinit verysmallinput valueduekeyboard" data-min="-1000" data-max="1000" type="text" data-r="panzoom.yEnd"></oneshort>
						</row>

						<row id="sl_pz_rs_re" class="direktrow">
							<onelong><label_a><?php _e('Rotate From', 'revslider');?></label_a><input data-allowed="deg" data-numeric="true" data-evt="updateKenBurnSettings" data-evtparam="begin" id="sl_pz_ro" class="slideinput easyinit verysmallinput valueduekeyboard" data-min="-2000" data-max="2000" type="text" data-r="panzoom.rotateStart"></onelong>
							<oneshort><label_a><?php _e('To', 'revslider');?></label_a><input data-allowed="deg" data-numeric="true" data-evt="updateKenBurnSettings" data-evtparam="end" id="sl_pz_re" class="slideinput easyinit verysmallinput valueduekeyboard" data-min="-2000" data-max="2000" type="text" data-r="panzoom.rotateEnd"></oneshort>
						</row>

						<row id="sl_pz_bs_be" class="direktrow">
							<onelong><label_a><?php _e('Blur From', 'revslider');?></label_a><input data-allowed="px" data-numeric="true" data-evt="updateKenBurnSettings" data-evtparam="begin" id="sl_pz_blurs" class="slideinput easyinit verysmallinput valueduekeyboard" data-min="0" data-max="100" type="text" data-r="panzoom.blurStart"></onelong>
							<oneshort><label_a><?php _e('To', 'revslider');?></label_a><input data-allowed="px" data-numeric="true" data-evt="updateKenBurnSettings" data-evtparam="end" id="sl_pz_blure" class="slideinput easyinit verysmallinput valueduekeyboard" data-min="0" data-max="100" type="text" data-r="panzoom.blurEnd"></oneshort>
						</row>

						<label_a><?php _e('Easing', 'revslider')?></label_a><select data-evt="updateKenBurnSettings" id="sl_pz_ease" class="slideinput tos2 nosearchbox easyinit" data-theme="dark" data-r="panzoom.ease"><option value="none">none</option><option value="power0.in">power0.in</option><option value="power0.inOut">power0.inOut</option><option value="power0.out">power0.out</option><option value="power1.in">power1.in</option><option value="power1.inOut">power1.inOut</option><option value="power1.out">power1.out</option><option value="power2.in">power2.in</option><option value="power2.inOut">power2.inOut</option><option value="power2.out">power2.out</option><option value="power3.in">power3.in</option><option value="power3.inOut">power3.inOut</option><option value="power3.out">power3.out</option><option value="power4.in">power4.in</option><option value="power4.inOut">power4.inOut</option><option value="power4.out">power4.out</option><option value="back.in">back.in</option><option value="back.inOut">back.inOut</option><option value="back.out">back.out</option><option value="bounce.in">bounce.in</option><option value="bounce.inOut">bounce.inOut</option><option value="bounce.out">bounce.out</option><option value="circ.in">circ.in</option><option value="circ.inOut">circ.inOut</option><option value="circ.out">circ.out</option><option value="elastic.in">elastic.in</option><option value="elastic.inOut">elastic.inOut</option><option value="elastic.out">elastic.out</option><option value="expo.in">expo.in</option><option value="expo.inOut">expo.inOut</option><option value="expo.out">expo.out</option><option value="sine.in">sine.in</option><option value="sine.inOut">sine.inOut</option><option value="sine.out">sine.out</option><option value="slow">slow</option></select><span class="linebreak"></span>
						<label_a><?php _e('Duration', 'revslider');?></label_a><input data-allowed="ms" data-numeric="true" data-evt="updateKenBurnSettings" id="sl_pz_dur" class="slideinput easyinit valueduekeyboard withsuffix" data-suffix="ms" data-min="0" data-max="1000000" type="text" data-r="panzoom.duration">
						<div id="kenburn_timeline"><div class="pz_timedone"></div><div class="pz_pin"></div></div>
						<div id="kenburn_simulator" data-states="play,stop" data-start_state="play" data-stop="previewKenBurn" data-stop_state="" data-stop_icon="stop" data-play="previewStopKenBurn"  data-play_state="" data-play_icon="play_arrow" class="basic_action_button onlyicon switch_button"><i class="switch_button_icon material-icons"></i><span class="switch_button_state"></span></div>
						<div data-evt="rewindKenBurn" class="basic_action_button callEventButton onlyicon"><i class="material-icons">rotate_left</i></div>


					</div>
				</div><!-- END OF COLLAPSABLE-->
			</div>
			<!--END OF KEN BURN SETTINGS -->
		</div>
	</div>

	<!-- SLIDE GLOBAL LAYERS SETTINGS -->
	<div id="gst_slide_10_outter" class="form_collector slide_settings_collector" data-type="slideconfig" data-pcontainer="#slide_settings" data-offset="#rev_builder_wrapper" data-collapsvisibles="true">
		<div id="form_slidestatic"  class="formcontainer form_menu_inside collapsed" data-select="#gst_slide_10" >
			<!-- HTML TAGS -->
			<div id="form_slidegeneral_timing" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">album</i><?php _e('Global Layers', 'revslider');?></div>

				<div class="collapsable">
					<label_a><?php _e('Overflow', 'revslider');?></label_a><select id="sl_static_layers_overflow" class="slideinput tos2 easyinit" data-r="static.overflow" data-theme="dark">
						<option value="visible"><?php _e('Visible', 'revslider');?></option>
						<option value="hidden"><?php _e('Hidden', 'revslider');?></option>
					</select><span class="linebreak"></span>

					<label_a><?php _e('Z Position', 'revslider');?></label_a><select id="sl_static_layers_z_position" class="slideinput tos2 easyinit" data-r="static.position" data-theme="dark">
						<option value="front"><?php _e('Front', 'revslider');?></option>
						<option value="back"><?php _e('Back', 'revslider');?></option>
					</select><span class="linebreak"></span>

					<longoption><i class="material-icons">visibility</i><label_a><?php _e('Show Last Edited Slide', 'revslider');?></label_a><input type="checkbox"  id="sr_showhidelastedited" data-evt="showLastEditedSlideStatic" class="callEvent slideinput easyinit" data-r="static.lastEdited"/></longoption>
				</div>
			</div><!-- END OF HTML TAGS -->
		</div>
	</div><!-- END OF SLIDE GENERALS -->



	<!-- SLIDE GENERALS -->
	<div class="form_collector slide_settings_collector" data-type="slideconfig" data-pcontainer="#slide_settings" data-offset="#rev_builder_wrapper" data-collapsvisibles="true">
		<div id="form_slidegeneral"  class="formcontainer form_menu_inside collapsed" data-select="#gst_slide_4" >
			<!-- HTML TAGS -->
			<div id="form_slidegeneral_timing" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">code</i><?php _e('Slide HTML Tags', 'revslider');?></div>
				<!--<div class="form_intoaccordion" data-trigger="#sl_fge_l1_1"><i class="material-icons">arrow_drop_down</i></div>-->

				<div class="collapsable">
					<label_a><?php _e('Class', 'revslider');?></label_a><input id="slide_ls_class" placeholder="Custom Slide Classes" class="slideinput easyinit" type="text" data-r="attributes.class"><span class="linebreak"></span>
					<label_a><?php _e('ID', 'revslider');?></label_a><input id="slide_ls_id" placeholder="Custom Slide ID" class="slideinput easyinit" type="text" data-r="attributes.id"><span class="linebreak"></span>
					<label_a><?php _e('HTML Data', 'revslider');?></label_a><textarea style="height:75px; line-height:20px;padding-top:5px" placeholder="i.e. data-min='12' data-custom='somevalue'" id="slide_ls_data" class="slideinput easyinit" type="text" data-r="attributes.data"></textarea>
					<label_a><?php _e('Deeplink Tag', 'revslider');?></label_a><input id="slide_ls_deeplink" class="slideinput easyinit" type="text" data-r="attributes.deeplink"><span class="linebreak"></span>
				</div>
			</div><!-- END OF HTML TAGS -->

			<!-- Link & Seo -->
			<div id="form_slidegeneral_linkseo" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">link</i><?php _e('Link & Seo', 'revslider');?></div>
				<!--<div class="form_intoaccordion" data-trigger="#sl_fge_l1_3"><i class="material-icons">arrow_drop_down</i></div>-->

				<div class="collapsable">

					<label_a><?php _e('Slide Link', 'revslider');?></label_a><input type="checkbox"  id="sl_seo_set" class="slideinput easyinit" data-showhide="#slide_link_wrap" data-showhidedep="true" data-r="seo.set" /><span class="linebreak"></span>
					<div id="slide_link_wrap">
						<label_a><?php _e('Type', 'revslider');?></label_a><select data-theme="dark" id="slide_seo_type" class="slideinput tos2 nosearchbox easyinit"  data-r="seo.type" data-show="#slidelink_*val*_seo" data-hide=".slidelink_seo_subs">
							<option value="regular"><?php _e('Regular', 'revslider');?></option>
							<option value="slide"><?php _e('To Slide', 'revslider');?></option>
						</select><span class="linebreak"></span>
						<div class="slidelink_seo_subs" id="slidelink_regular_seo">
							<label_a><?php _e('URL', 'revslider');?></label_a><input placeholder="Enter URL to link to" id="slide_ls_link" class="slideinput easyinit" type="text" data-r="seo.link"><span class="linebreak"></span>
							<label_a><?php _e('Protocol', 'revslider');?></label_a><select data-theme="dark" id="slide_ls_url_help" class="slideinput tos2 nosearchbox easyinit"  data-r="seo.linkHelp">
								<option value="http"><?php _e('http://', 'revslider');?></option>
								<option value="https"><?php _e('https://', 'revslider');?></option>
								<option value="auto"><?php _e('Auto http / https', 'revslider');?></option>
								<option value="keep"><?php _e('Keep as it is', 'revslider');?></option>	
							</select>
							<label_a><?php _e('Target', 'revslider');?></label_a><select data-theme="dark" id="slide_ls_link_target" class="slideinput tos2 nosearchbox easyinit"  data-r="seo.target">
								<option value="_self"><?php _e('_self', 'revslider');?></option>
								<option value="_blank"><?php _e('_blank', 'revslider');?></option>
								<option value="_top"><?php _e('_top', 'revslider');?></option>
								<option value="_parent"><?php _e('_parent', 'revslider');?></option>														
							</select>							
						</div>
						<div class="slidelink_seo_subs" id="slidelink_slide_seo">
							<label_a><?php _e('Link to Slide', 'revslider');?></label_a><select data-theme="dark" id="slide_seo_linktoslide" class="slideinput tos2 nosearchbox easyinit"  data-r="seo.slideLink"></select><span class="linebreak"></span>
						</div>
						<label_a><?php _e('Sensibility', 'revslider');?></label_a><select data-theme="dark" id="slide_seo_z" class="slideinput tos2 nosearchbox easyinit"  data-r="seo.z">
							<option value="front"><?php _e('Over Layers (Front)', 'revslider');?></option>
							<option value="back"><?php _e('Behind Layers (Back)', 'revslider');?></option>
						</select>
						<label_a><?php _e('Tag', 'revslider');?></label_a><select data-theme="dark" id="slide_tag_type" class="slideinput tos2 nosearchbox easyinit"  data-r="seo.tag">
							<option value="l"><?php _e('&lt;RS-LAYER&gt;', 'revslider');?></option>
							<option value="a"><?php _e('&lt;A&gt;', 'revslider');?></option>
						</select>
					</div>
				</div>
			</div><!-- END OF Link & Seo -->


		</div>
	</div><!-- END OF SLIDE GENERALS -->

	<!-- SLIDE PROGRESS -->
	<div class="form_collector slide_settings_collector" data-type="slideconfig" data-pcontainer="#slide_settings" data-offset="#rev_builder_wrapper">
		<div id="form_slide_progress"  class="formcontainer form_menu_inside collapsed" data-select="#gst_slide_8" >
			<!-- PROGRESS -->
			<div id="form_slidegeneral_timing" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">timer</i><?php _e('Progress', 'revslider');?></div>
				<!--<div class="form_intoaccordion" data-trigger="#sl_fge_l1_1"><i class="material-icons">arrow_drop_down</i></div>-->

				<div class="collapsable">
					<label_a><?php _e('Slide Length', 'revslider');?></label_a><input id="slide_length" class="slideinput easyinit" data-allowed="ms,Default" data-numeric="true" type="text" data-valcheck="slideMinLength"  placeholder="Default" data-evt="updateMaxTime" data-r="timeline.delay"><span class="linebreak"></span>
					<label_a><?php _e('Pause Slider', 'revslider');?></label_a><select data-theme="dark" id="slide_time_stopOnPurpose" class="slideinput tos2 nosearchbox easyinit"  data-r="timeline.stopOnPurpose">
						<option value="false"><?php _e('Default', 'revslider');?></option>
						<option value="true"><?php _e('Stop Slider Progress', 'revslider');?></option>
					</select>
				</div>
			</div><!-- END OF PROGRESS AND STATE -->

			<!-- Visibilty -->
			<div id="form_slidegeneral_visibility" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">check_circle</i><?php _e('Visibility', 'revslider');?></div>
				<!--<div class="form_intoaccordion" data-trigger="#sl_fge_l1_1"><i class="material-icons">arrow_drop_down</i></div>-->
				<div class="collapsable">
					<label_icon class="ui_hide_in_nav singlerow"></label_icon><select data-theme="dark" id="slide_visibil_hideFromNavigation" class="slideinput tos2 nosearchbox easyinit"  data-r="visibility.hideFromNavigation">
						<option value="false"><?php _e('Visible in Navigation', 'revslider');?></option>
						<option value="true"><?php _e('Hidden in Navigation', 'revslider');?></option>
					</select><span class="linebreak"></span>
					<label_icon class="ui_hide_after_loop singlerow"></label_icon><input id="slide_vis_loop" data-numeric="true" data-allowed="" class="slideinput easyinit" type="text" data-r="visibility.hideAfterLoop"><span class="linebreak"></span>
					<label_icon class="ui_hide_on_mobile singlerow"></label_icon><input type="checkbox"  id="sl_vis_hidemobile" class="slideinput easyinit" data-r="visibility.hideOnMobile" /><span class="linebreak"></span>
				</div>
			</div><!-- END OF PROGRESS AND STATE -->
		</div>
	</div>



	<!-- SLIDE PUBLISH -->
	<div class="form_collector slide_settings_collector" data-type="slideconfig" data-pcontainer="#slide_settings" data-offset="#rev_builder_wrapper">
		<div id="form_slide_publish"  class="formcontainer form_menu_inside collapsed" data-select="#gst_slide_9" >

			<!-- PUBLISH AND STATE -->
			<div id="form_slidegeneral_progstate" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">event</i><?php _e('Publish', 'revslider');?></div>
				<!--<div class="form_intoaccordion" data-trigger="#sl_fge_l1_1"><i class="material-icons">arrow_drop_down</i></div>-->
				<div class="collapsable">
					<label_icon class="ui_published singlerow"></label_icon><select data-theme="dark" id="slide_publish_State" class="slideinput tos2 nosearchbox easyinit callEvent" data-evt="updatepublishicons" data-r="publish.state">
						<option value="published"><?php _e('Published', 'revslider');?></option>
						<option value="unpublished"><?php _e('Unpublished', 'revslider');?></option>
					</select>
					<row class="direktrow">
						<onelong><label_icon class="ui_published_from"></label_icon><input id="slide_pub_from" class="inputDatePicker slideinput easyinit" type="text" data-r="publish.from"></onelong>
						<oneshort><label_icon class="ui_published_until"></label_icon><input id="slide_pub_until" class="inputDatePicker slideinput easyinit" type="text" data-r="publish.to"></oneshort>
					</row>					
				</div>
			</div><!-- END OF PROGRESS AND STATE -->
		</div>
	</div>

	<!-- WPML RULES -->
	<div class="form_collector slide_settings_collector" data-type="slideconfig" data-pcontainer="#slide_settings" data-offset="#rev_builder_wrapper">
		<div id="form_slide_wpml"  class="formcontainer form_menu_inside collapsed" data-select="#gst_slide_13" >

			<!-- PUBLISH AND STATE -->
			<div id="form_slidegeneral_progstate" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">event</i><?php _e('Wordpress Multi Language', 'revslider');?></div>				
				<div class="collapsable">					
					<?php
if ($wpml->wpml_exists()) {
	?>
					<div id="wpml_exists">
						<label_a><?php _e('Slide Lang.', 'revslider');?></label_a><select data-theme="dark" id="slide_wpml_language" data-evt="changeflags" class="callEvent wpml_lang_selector slideinput tos2 easyinit"  data-r="child.language">
						</select><span class="linebreak"></span>
					</div>
					<?php
}
?>
				</div>
			</div><!-- END OF PROGRESS AND STATE -->
		</div>
	</div>

	<!-- SLIDE PARAMETERS SETTINGS-->
	<div class="form_collector slide_settings_collector" data-type="slideconfig" data-pcontainer="#slide_settings" data-offset="#rev_builder_wrapper">
		<div id="form_slide_parameters"  class="formcontainer form_menu_inside collapsed" data-select="#gst_slide_7" >
			<!-- PARAMETERS -->
			<div id="form_slidegeneral_params" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">info</i><?php _e('Parameters', 'revslider');?></div>
				<!--<div class="form_intoaccordion" data-trigger="#sl_fge_l1_4"><i class="material-icons">arrow_drop_down</i></div>-->

				<div id="slide_parameters" class="collapsable">
					<label_a><?php _e('Parameter 1', 'revslider');?></label_a><input placeholder="Enter Any Text" id="slide_info_p1" class="tqinput slideinput easyinit " type="text" data-r="info.params.0.v"><input id="slide_info_p1ch" class="oqinput slideinput easyinit valueduekeyboard" data-min="0" data-max="255" type="text" data-r="info.params.0.l"><span class="linebreak"></span>
					<label_a><?php _e('Parameter 2', 'revslider');?></label_a><input id="slide_info_p2" placeholder="Enter Any Text" class="tqinput slideinput easyinit " type="text" data-r="info.params.1.v"><input id="slide_info_p2ch" class="oqinput slideinput easyinit valueduekeyboard" data-min="0" data-max="255" type="text" data-r="info.params.1.l"><span class="linebreak"></span>
					<label_a><?php _e('Parameter 3', 'revslider');?></label_a><input id="slide_info_p3" placeholder="Enter Any Text" class="tqinput slideinput easyinit " type="text" data-r="info.params.2.v"><input id="slide_info_p3ch" class="oqinput slideinput easyinit valueduekeyboard" data-min="0" data-max="255" type="text" data-r="info.params.2.l"><span class="linebreak"></span>
					<label_a><?php _e('Parameter 4', 'revslider');?></label_a><input id="slide_info_p4" placeholder="Enter Any Text" class="tqinput slideinput easyinit " type="text" data-r="info.params.3.v"><input id="slide_info_p4ch" class="oqinput slideinput easyinit valueduekeyboard" data-min="0" data-max="255" type="text" data-r="info.params.3.l"><span class="linebreak"></span>
					<label_a><?php _e('Parameter 5', 'revslider');?></label_a><input id="slide_info_p5" placeholder="Enter Any Text" class="tqinput slideinput easyinit " type="text" data-r="info.params.4.v"><input id="slide_info_p5ch" class="oqinput slideinput easyinit valueduekeyboard" data-min="0" data-max="255" type="text" data-r="info.params.4.l"><span class="linebreak"></span>
					<label_a><?php _e('Parameter 6', 'revslider');?></label_a><input id="slide_info_p6" placeholder="Enter Any Text" class="tqinput slideinput easyinit " type="text" data-r="info.params.5.v"><input id="slide_info_p6ch" class="oqinput slideinput easyinit valueduekeyboard" data-min="0" data-max="255" type="text" data-r="info.params.5.l"><span class="linebreak"></span>
					<label_a><?php _e('Parameter 7', 'revslider');?></label_a><input id="slide_info_p7" placeholder="Enter Any Text" class="tqinput slideinput easyinit " type="text" data-r="info.params.6.v"><input id="slide_info_p7ch" class="oqinput slideinput easyinit valueduekeyboard" data-min="0" data-max="255" type="text" data-r="info.params.6.l"><span class="linebreak"></span>
					<label_a><?php _e('Parameter 8', 'revslider');?></label_a><input id="slide_info_p8" placeholder="Enter Any Text" class="tqinput slideinput easyinit " type="text" data-r="info.params.7.v"><input id="slide_info_p8ch" class="oqinput slideinput easyinit valueduekeyboard" data-min="0" data-max="255" type="text" data-r="info.params.7.l"><span class="linebreak"></span>
					<label_a><?php _e('Parameter 9', 'revslider');?></label_a><input id="slide_info_p9" placeholder="Enter Any Text" class="tqinput slideinput easyinit " type="text" data-r="info.params.8.v"><input id="slide_info_p9ch" class="oqinput slideinput easyinit valueduekeyboard" data-min="0" data-max="255" type="text" data-r="info.params.8.l"><span class="linebreak"></span>
					<label_a><?php _e('Parameter 10', 'revslider');?></label_a><input id="slide_info_p10" placeholder="Enter Any Text" class="tqinput slideinput easyinit " type="text" data-r="info.params.9.v"><input id="slide_info_p10ch" class="oqinput slideinput easyinit valueduekeyboard" data-min="0" data-max="255" type="text" data-r="info.params.9.l"><span class="linebreak"></span>
					<label_a><?php _e('Description', 'revslider');?></label_a><textarea placeholder="Enter any Description which can be referenced from Navigation Elements." style="height:100px; line-height:20px;padding-top:5px;width:100%" id="slide_info_desc" class="slideinput easyinit" type="text" data-r="info.description"></textarea><span class="linebreak"></span>
				</div>
			</div><!-- END OF PARAMETERS -->
		</div>
	</div>


	<!-- SLIDE LOOP SETTINGS-->
	<div class="form_collector slide_settings_collector" data-type="slideconfig" data-pcontainer="#slide_settings" data-offset="#rev_builder_wrapper">
		<div id="form_slide_loops"  class="formcontainer form_menu_inside collapsed" data-select="#gst_slide_11" >
			<!-- PARAMETERS -->
			<div id="form_slide_loops_iner" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">info</i><?php _e('Loop All Layer Timeline', 'revslider');?></div>					
				<div class="collapsable">
					<label_a><?php _e('Use Slide Loop', 'revslider');?></label_a><input type="checkbox"  data-setclasson="timeline" data-class="slideloopon" id="sl_layers_loop" class="slideinput easyinit callEvent" data-evt="updateSlideLoopRange" data-showhide="#slide_loop_wrap" data-showhidedep="true" data-r="timeline.loop.set" /><span class="linebreak"></span>
					<div id="slide_loop_wrap">
						<label_a><?php _e('Repeat', 'revslider');?></label_a><input id="slide_loop_repeat" class="slideinput easyinit input_with_presets" type="text" data-r="timeline.loop.repeat" data-numeric="true" data-allowed="unlimited" data-presets_text="$C$1!$C$2!$R$Unlimited!" data-presets_val="1!2!unlimited!"><span class="linebreak"></span>
						<label_a><?php _e('Start', 'revslider');?></label_a><input id="slide_loop_start" class="slideinput easyinit callEvent" data-evt="updateSlideLoopRange" type="text" data-r="timeline.loop.start"><span class="linebreak"></span>
						<label_a><?php _e('End', 'revslider');?></label_a><input id="slide_loop_end" class="slideinput easyinit callEvent" data-evt="updateSlideLoopRange"  type="text" data-r="timeline.loop.end"><span class="linebreak"></span>
					</div>
				</div>
			</div><!-- END OF PARAMETERS -->
		</div>
	</div>



	<!-- SLIDE THUMBNAIL ETTINGS-->
	<div class="form_collector slide_settings_collector" data-type="slideconfig" data-pcontainer="#slide_settings" data-offset="#rev_builder_wrapper">
		<div id="form_slide_thumbnail"  class="formcontainer form_menu_inside collapsed" data-select="#gst_slide_6" >

			<!--<div class="form_intoaccordion"><i class="material-icons">arrow_drop_down</i></div>-->
			<!-- THUMBNAILS -->
			<div id="form_slidegeneral_thumbnails" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">photo_album</i><?php _e('Module Admin Thumbnail', 'revslider');?></div>
				<!--<div class="form_intoaccordion" data-trigger="#sl_fge_l1_2"><i class="material-icons">arrow_drop_down</i></div>-->

				<div class="collapsable">
					<row class="direktrow">
						<onelong><label_a><?php _e('Admin Thumb', 'revslider');?></label_a><div class="miniprevimage_wrap"><i class="material-icons">filter_hdr</i><div id="admin_purpose_thumbnail"></div></div></onelong>
						<oneshort>
							<div data-evt="updateslidethumbs" data-r="#slide#.slide.thumb.customAdminThumbSrc" data-rid="#slide#.slide.thumb.customAdminThumbSrcId" class="getImageFromMediaLibrary basic_action_button  callEventButton"><i class="material-icons">folder</i><?php _e('Select', 'revslider');?></div>
							<div data-evt="resetslideadminthumb" data-evtparam="slide.thumb.customAdminThumbSrc" class="resettodefault basic_action_button  callEventButton"><i class="material-icons">update</i><?php _e('Reset', 'revslider');?></div>
						</oneshort>
					</row>

					<div class="div15"></div>
					<row>
						<onelong><label_a><?php _e('Navig. Thumb', 'revslider');?></label_a><div class="miniprevimage_wrap"><i class="material-icons">filter_hdr</i><div id="navigation_purpose_thumbnail"></div></div></onelong>
						<oneshort>
							<div data-evt="updateslidethumbs" data-r="#slide#.slide.thumb.customThumbSrc" data-rid="#slide#.slide.thumb.customThumbSrcId" class="getImageFromMediaLibrary basic_action_button  callEventButton"><i class="material-icons">folder</i><?php _e('Select', 'revslider');?></div>
							<div data-evt="resetslideadminthumb" data-evtparam="slide.thumb.customThumbSrc" class="resettodefault basic_action_button  callEventButton"><i class="material-icons">update</i><?php _e('Reset', 'revslider');?></div>
						</oneshort>
					</row>
					<label_a><?php _e('Dimension', 'revslider');?></label_a><select data-theme="dark" id="slide_thumb_dimension" class="slideinput tos2 nosearchbox easyinit"  data-r="thumb.dimension">
						<option value="slider"><?php _e('From Slider Settings', 'revslider');?></option>
						<option value="orig"><?php _e('Original Size', 'revslider');?></option>
					</select>
					
				</div>

			</div>			
		</div>
	</div>

</div><!-- END OF SLIDE SETTINGS -->