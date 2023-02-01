<?php
/**
 * Provide a admin area view for the plugin LAYER SETTINGS
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2019 ThemePunch
 */
if(!defined('ABSPATH')) exit();
?>

<!--<div id="gst_layer_5" data-select="#gst_layer_5" data-unselect=".layer_submodule_trigger" class="layer_submodule_trigger opensettingstrigger" data-collapse="true" data-forms='["#form_layer_actions"]'><i class="material-icons">link</i><span class="gso_title">Actions</span></div>-->

<!-- GOOGLE FONT LIST CONTAINER -->
<div id="tp-thelistoffonts"></div>

<!-- LAYER SETTINGS -->
<div id="layer_settings">

	<div class="form_collector layer_settings_collector" data-type="layersconfig" data-pcontainer="#layer_settings" data-offset="#rev_builder_wrapper">
		<div id="mmbw_loptions">
			<div id="stylemode_layeroption"><div class="main_mode_submode left blue"><?php _e('Editor View', 'revslider');?></div><div class="main_mode_submode right"><?php _e('Layer options', 'revslider');?></div><div class="tp-clearfix"></div></div>
			<div id="hovermode_layeroption"><div class="main_mode_submode left blue"><?php _e('Hover View', 'revslider');?></div><div class="main_mode_submode right"><?php _e('Layer options', 'revslider');?></div><div class="tp-clearfix"></div></div>
			<div id="animationmode_layeroption"><div class="main_mode_submode left lila"><?php _e('Animation View', 'revslider');?></div><div class="main_mode_submode right"><?php _e('Layer options', 'revslider');?></div><div class="tp-clearfix"></div></div>
		</div>
		<div id="gst_layer_collector" class="gso_wrap">
			<div id="gst_layer_1" data-select="#gst_layer_1" data-unselect=".layer_submodule_trigger" class="layer_submodule_trigger opensettingstrigger selected" data-collapse="true" data-forms='["#form_layer_content"]'><i class="material-icons">create</i><span data-stickycolor="blue" class="gso_title"><?php _e('Content', 'revslider');?></span></div><!--
			--><div id="gst_layer_3" data-select="#gst_layer_3" data-unselect=".layer_submodule_trigger" data-evt="updateInputFields" class="callEvent layer_submodule_trigger opensettingstrigger" data-collapse="true" data-forms='["#form_layer_style"]'><i class="material-icons">palette</i><span data-stickycolor="blue"  class="gso_title"><?php _e('Style', 'revslider');?></span></div><!--
			--><div id="gst_layer_2" data-select="#gst_layer_2" data-unselect=".layer_submodule_trigger" class="layer_submodule_trigger opensettingstrigger" data-collapse="true" data-forms='["#form_layer_position"]'><i class="material-icons">open_with</i><span data-stickycolor="blue"  class="gso_title"><?php _e('Size & Pos', 'revslider');?></span></div><!--
			--><div id="gst_layer_6" data-select="#gst_layer_6" data-unselect=".layer_submodule_trigger" class="layer_submodule_trigger opensettingstrigger" data-collapse="true" data-forms='["#form_layer_advstyle"]'><i class="material-icons">invert_colors</i><span data-stickycolor="blue"  class="gso_title"><?php _e('Adv. Style', 'revslider');?></span></div><!--
			--><div id="gst_layer_4" data-select="#gst_layer_4" data-unselect=".layer_submodule_trigger" class="layer_submodule_trigger opensettingstrigger" data-collapse="true" data-forms='["#form_layer_animation"]'><i class="material-icons">play_arrow</i><span data-stickycolor="purple"  class="gso_title"><?php _e('Animation', 'revslider');?></span></div><!--
			--><div id="gst_layer_15" data-select="#gst_layer_15" data-unselect=".layer_submodule_trigger" class="layer_submodule_trigger opensettingstrigger" data-collapse="true" data-forms='["#form_layer_loop"]'><i class="material-icons">repeat_one</i><span data-stickycolor="purple"  class="gso_title"><?php _e('Loop Layer', 'revslider');?></span></div><!--
			--><div id="gst_layer_9" data-select="#gst_layer_9" data-unselect=".layer_submodule_trigger" class="layer_submodule_trigger opensettingstrigger" data-collapse="true" data-forms='["#form_layer_hover"]'><i class="material-icons">mouse</i><span data-stickycolor="blue"  class="gso_title"><?php _e('Hover', 'revslider');?></span></div><!--
			--><div id="gst_layer_8" data-select="#gst_layer_8" data-unselect=".layer_submodule_trigger" class="layer_submodule_trigger opensettingstrigger" data-collapse="true" data-forms='["#form_layer_parallax"]'><i class="material-icons">system_update_alt</i><span data-stickycolor="blue"  class="gso_title"><?php _e('On Scroll', 'revslider');?></span></div><!--
			--><div id="gst_layer_5" class="callEvent layer_submodule_trigger openmodaltrigger" data-evt="openLayerActions"><i class="material-icons">touch_app</i><span class="gso_title">Actions</span></div><!--
			--><div id="gst_layer_13" data-select="#gst_layer_13" data-unselect=".layer_submodule_trigger" class="layer_submodule_trigger opensettingstrigger" data-collapse="true" data-forms='["#form_layer_visibility"]'><i class="material-icons">photo_size_select_large</i><span data-stickycolor="blue"  class="gso_title"><?php _e('Visibility', 'revslider');?></span></div><!--
			--><div id="gst_layer_11" data-select="#gst_layer_11" data-unselect=".layer_submodule_trigger" class="layer_submodule_trigger opensettingstrigger callEvent" data-collapse="true" data-forms='["#form_layer_attributes"]'><i class="material-icons">description</i><span data-stickycolor="blue"  class="gso_title"><?php _e('Attributes', 'revslider');?></span></div><!--
			--><div id="gst_layer_7" data-select="#gst_layer_7" data-unselect=".layer_submodule_trigger" class="layer_submodule_trigger opensettingstrigger callEvent" data-evt="updateCustomCSSLayerInput" data-collapse="true" data-forms='["#form_layer_customcss"]'><i class="material-icons">code</i><span data-stickycolor="blue"  class="gso_title"><?php _e('Custom CSS', 'revslider');?></span></div><!--
			--><div id="gst_layer_14" data-select="#gst_layer_14" data-unselect=".layer_submodule_trigger" class="layer_submodule_trigger opensettingstrigger" data-collapse="true" data-forms='["#form_layer_static"]'><i class="material-icons">album</i><span data-stickycolor="blue"  class="gso_title"><?php _e('Static', 'revslider');?></span></div>
		</div>
	</div>

	<!-- LAYER CONTENT CONTAINER -->
	<div id="no_layer_selected" class="form_collector layer_settings_collector" data-type="layersconfig" data-pcontainer="#layer_settings" data-offset="#rev_builder_wrapper"><i class="material-icons">info</i>Add or Select Layer(s)</div>



	<!-- LAYER CONTENT CONTAINER -->
	<div class="form_collector layer_settings_collector" data-type="layersconfig" data-pcontainer="#layer_settings" data-offset="#rev_builder_wrapper">
		<div id="form_layer_content"  class="formcontainer form_menu_inside" data-select="#gst_layer_1" data-unselect=".layer_submodule_trigger" >
			<!--<div class="collectortabwrap"><div id="collectortab_form_layer_content" class="collectortab form_menu_inside" data-forms='["#form_layer_content"]'><i class="material-icons">create</i><?php _e('Content', 'revslider');?></div></div>-->

			<!-- LAYER ROW CONTENT  -->
			<!-- LAYER COLUMN CONTENT  -->
			<div id="form_layercontent_content_row" class="form_inner open _shfr_ _shfc_">
				<div class="form_inner_header"><i class="material-icons">reorder</i><?php _e('Row Settings', 'revslider');?></div>
				<div class="collapsable">
					<div id="colselector_wrap">
						<row class="directrow">
							<onefifth><div class="colselector" data-col="1"><label_bigicon class="ui_onecol"></label_bigicon></div></onefifth>
							<onefifth><div class="colselector" data-col="1/2 + 1/2"><label_bigicon class="ui_twocol"></label_bigicon></div></onefifth>
							<onefifth><div class="colselector" data-col="1/3 + 1/3 + 1/3"><label_bigicon class="ui_threecol"></label_bigicon></div></onefifth>
							<onefifth><div class="colselector" data-col="1/4 + 1/4 + 1/4 + 1/4"><label_bigicon class="ui_fourcol"></label_bigicon></div></onefifth>
							<onefifth><div class="colselector" data-col="1/6 + 1/6 + 1/6 + 1/6 + 1/6 + 1/6"><label_bigicon class="ui_sixcol"></label_bigicon></div></onefifth>
						</row>
						<row>
							<onefifth><div class="colselector" data-col="1/4 + 1/2 + 1/4"><label_bigicon class="ui_onefourth_half_onefourth_col"></label_bigicon></div></onefifth>
							<onefifth><div class="colselector" data-col="1/6 + 4/6 + 1/6"><label_bigicon class="ui_onesixth_foursixth_onesixts_col"></label_bigicon></div></onefifth>
							<onefifth><div class="colselector" data-col="2/3 + 1/3"><label_bigicon class="ui_twothird_onethird_col"></label_bigicon></div></onefifth>
							<onefifth><div class="colselector" data-col="3/4 + 1/4"><label_bigicon class="ui_threefourth_onefourth_col"></label_bigicon></div></onefifth>
							<onefifth><div class="colselector" data-col="5/6 + 1/6"><label_bigicon class="ui_fivesixth_onesixth_col"></label_bigicon></div></onefifth>
						</row>
						<label_a><?php _e('Columns', 'revslider');?></label_a><input type="text" id="row_column_structure" data-updateviaevt="true">
						<label_a></label_a><div data-evt="updateColumnStructure" class="basic_action_button longbutton callEventButton layerinput"><i class="material-icons">refresh</i><?php _e('Update Row', 'revslider');?></div>
						<div class="div10"></div>
						<select  style="display:none !important" id="layer_row_break" data-evt="updateColumnBreak" data-updateviaevt="true" data-unselect=".layer_rowbreak_icons" data-select="#layer_row_break_*val*" class="layerinput easyinit callEvent" data-r="group.columnbreakat"><option value="notebook">notebook</option><option value="tablet">tablet</option><option value="mobile">mobile</option><option value="nobreak">nobreak</option></select>
						<row class="directrow">
							<onelabel><label_a><?php _e('Break At', 'revslider');?></label_a></onelabel>
							<onefull><label_icon class="triggerselect material-icons twostatetrigger layer_rowbreak_icons" data-select="#layer_row_break" data-val="notebook" id="layer_row_break_notebook">laptop</label_icon><label_icon class="triggerselect material-icons twostatetrigger layer_rowbreak_icons" data-select="#layer_row_break" data-val="tablet" id="layer_row_break_tablet">tablet_android</label_icon><label_icon class="triggerselect material-icons twostatetrigger layer_rowbreak_icons" data-select="#layer_row_break" data-val="mobile" id="layer_row_break_mobile">phone_iphone</label_icon><label_icon class="triggerselect material-icons twostatetrigger layer_rowbreak_icons" data-select="#layer_row_break" data-val="nobreak" id="layer_row_break_nobreak">block</label_icon></onefull>
						</row>

						<div class="div10"></div>
						<select  style="display:none !important" id="layer_row_position" data-evt="updateRowPosition" data-updateviaevt="true" data-unselect=".layer_rowposition_icons" data-prval="#slide#.layers.#parentlayer#.group.puid" data-prvalif="column" data-select="#layer_row_position_*val*" class="layerinput easyinit callEvent" data-r="group.puid"><option value="top">Top</option><option value="middle">Middle</option><option value="bottom">Bottom</option></select>
						<row class="directrow">
							<onelabel><label_a><?php _e('Row Position', 'revslider');?></label_a></onelabel>
							<onefull>
								<div class="triggerselect twostatetrigger material-icons layer_rowposition_icons" data-select="#layer_row_position" data-val="top" id="layer_row_position_top" data-helpkey="row_position"><label_icon class="rowtop"></label_icon></div><!--
								--><div class="triggerselect twostatetrigger material-icons layer_rowposition_icons" data-select="#layer_row_position" data-val="middle" id="layer_row_position_middle" data-helpkey="row_position"><label_icon class="rowmiddle"></label_icon></div><!--
								--><div class="triggerselect twostatetrigger material-icons layer_rowposition_icons" data-select="#layer_row_position" data-val="bottom" id="layer_row_position_bottom" data-helpkey="row_position"><label_icon class="rowbottom"></label_icon></div>
							</onefull>
						</row>
					</div>
				</div>
			</div>

			<div id="form_layercontent_content_column" class="form_inner open  _shfc_">
				<div class="form_inner_header"><i class="material-icons">reorder</i><?php _e('Column Settings', 'revslider');?></div>
				<div class="collapsable" style="padding-bottom:0px;" >
					<row>
						<onelabel><label_a><?php _e('Vertical Align', 'revslider');?></label_a></onelabel>
						<onefull>
							<label_icon class="triggerselect layer_content_ver_selector twostatetrigger material-icons" data-select="#layer_content_valign" data-val="top" id="layer_content_valign_top">vertical_align_top</label_icon><!--
							--><label_icon class="triggerselect layer_content_ver_selector twostatetrigger material-icons" data-select="#layer_content_valign" data-val="middle" id="layer_content_valign_middle">vertical_align_center</label_icon><!--
							--><label_icon class="triggerselect layer_content_ver_selector twostatetrigger material-icons" data-select="#layer_content_valign" data-val="bottom" id="layer_content_valign_bottom">vertical_align_bottom</label_icon>
						</onefull>
					</row>
				</div>
			</div>




			<!-- LAYER TEXT CONTENT -->
			<div id="form_layercontent_content_text" class="form_inner open _shft_ _shfb_ _homs_">
				<div class="form_inner_header"><i class="material-icons">title</i><?php _e('Text/Button Layer Content', 'revslider');?></div>
				<div class="collapsable" style="padding-bottom:0px;" id="text_button_layer_content_wrapper">

					<div class="left_right_row">
						<div class="view-switch">
							<div data-show="#ta_layertext" data-hide=".idletoggletext, #ta_toggle_settings" class="vs-item selected"><?php _e('Idle', 'revslider');?></div>
							<div data-show="#ta_toggletext, #ta_toggle_settings" data-hide=".idletoggletext" class="vs-item"><?php _e('Toggle', 'revslider');?></div>
						</div>
						<div class="icon_trigger_wrap">

							<div class="triggerEvent icon_trigger" data-evt="addBRtoTextLayer"><i style="margin:0px" class="material-icons">subdirectory_arrow_right</i></div>
							<div class="triggerEvent icon_trigger" data-evt="addIcontoTextLayer" data-iconparent="#text_button_layer_content_wrapper" data-insertinto="#ta_layertext"><i class="material-icons">apps</i><?php _e('Icon', 'revslider');?></div>
							<div id="add_meta_to_layer" class="triggerEvent icon_trigger" data-evt="addMetaToLayer" data-evtparam="layer"><i class="material-icons">local_offer</i><?php _e('Meta', 'revslider');?></div>
						</div>
						<div class="tp-clearfix"></div>
					</div>
					<textarea id="ta_layertext" class="idletoggletext rsmaxtextarea its-idle layerinput easyinit callEvent livechange"  data-br="convert" data-evt="layerTextContentUpdate" data-r="text" data-cursortoclick="true"></textarea>
					<textarea id="ta_toggletext" style="display:none" class="idletoggletext rsmaxtextarea its-toggle layerinput easyinit" data-br="convert" data-r="toggle.text" data-cursortoclick="true"></textarea>
					<div id="ta_layertext_extension"></div>
					<div id="ta_toggle_settings" style="display:none">
						<longoption><i class="material-icons">g_translate</i><label_a><?php _e('Use Toggle', 'revslider');?></label_a><input type="checkbox" class="easyinit layerinput" data-r="toggle.set"></longoption>
						<longoption style="display:none"><i class="material-icons">mouse</i><label_a><?php _e('Toggled in Hover Style', 'revslider');?></label_a><input type="checkbox" class="easyinit layerinput" data-r="toggle.useHover"></longoption>
						<longoption><i class="material-icons">compare_arrows</i><label_a><?php _e('Inverse Toggled Content', 'revslider');?></label_a><input type="checkbox" class="easyinit layerinput" data-r="toggle.inverse"></longoption>
					</div>

					<div class="div10"></div>
					<label_a><?php _e('Placeholder', 'revslider');?></label_a><input id="ta_placeholder" type="text" data-r="placeholder" class="easyinit layerinput livechange" data-evt="layerTextContentUpdate" data-evtparam="placeholder" data-br="convert" data-cursortoclick="true">
					<div class="__idle__"><label_a><?php _e('Line Break', 'revslider');?></label_a><select id="layer_linebreak" class="layerinput easyinit nosearchbox tos2"  data-responsive="true" data-evt="redrawInnerHTML" data-r="idle.whiteSpace.#size#.v"><option value="nowrap"><?php _e('Only Manual &lt;br/&gt;', 'revslider');?></option><option value="normal"><?php _e('Width Based', 'revslider');?></option><option value="content"><?php _e('Content Based', 'revslider');?></option><option value="full"><?php _e('Content and Width Based', 'revslider');?></option></select></div>
				</div>
			</div>

			<!-- HORIZONTAL ALIGN SPECIALITY -->
			<div id="form_layercontent_content_horalign" style="margin-top:0px; padding-top:0px;" class="form_inner open _shft_ _shfb_ _shfc_">
				<div class="collapsable" class="" style="padding-top:0px;">
					<row class="directrow">
						<onelabel><label_a><?php _e('Text Align', 'revslider');?></label_a></onelabel>
						<onefull>
							<label_icon class="triggerselect layer_content_hor_selector twostatetrigger material-icons" data-select="#layer_content_halign" data-val="left" id="layer_content_halign_left">format_align_left</label_icon><!--
							--><label_icon class="triggerselect layer_content_hor_selector twostatetrigger material-icons" data-select="#layer_content_halign" data-val="center" id="layer_content_halign_center">format_align_center</label_icon><!--
							--><label_icon class="triggerselect layer_content_hor_selector twostatetrigger material-icons" data-select="#layer_content_halign" data-val="right" id="layer_content_halign_right">format_align_right</label_icon><!--
							--><label_icon class="triggerselect layer_content_hor_selector twostatetrigger material-icons" data-select="#layer_content_halign" data-val="inherit" id="layer_content_halign_inherit">subdirectory_arrow_right</label_icon>
						</onefull>
					</row>
				</div>
			</div>

			

			<!-- LAYER IMAGE CONTENT  -->
			<div id="form_layercontent_content_image" class="form_inner open _shfi_">
				<div class="form_inner_header"><i class="material-icons">filter_hdr</i><?php _e('Image Layer Content', 'revslider');?></div>
				<div class="collapsable">
					<longoption><i class="material-icons">language</i><label_a ><?php _e('Image from Stream if exist', 'revslider');?></label_a><input type="checkbox" class="easyinit layerinput" data-r="media.imageFromStream"></longoption>
					<div class="div10"></div>
					<row class="direktrow">
						<oneshort><div id="minilayerprevimage_wrap" class="miniprevimage_wrap"><i class="material-icons">filter_hdr</i><div id="layer_image_src"></div></div></oneshort>
						<oneshort>
							<div id="image_layer_media_library_button" data-evt="updatelayerimagesrc" data-r="media.imageUrl" data-rid="media.imageId" data-sty="behavior.imageSourceType" data-lib="media.imageLib" class="getImageFromMediaLibrary basic_action_button longbutton layerinput"><i class="material-icons">style</i><?php _e('Media Library', 'revslider');?></div>
							<div id="image_layer_object_library_button" data-evt="updatelayerimagesrc" data-r="media.imageUrl" data-rid="media.imageId" data-sty="behavior.imageSourceType" data-lib="media.imageLib" class="getImageFromObjectLibrary basic_action_button longbutton layerinput"><i class="material-icons">camera_enhance</i><?php _e('Object Library', 'revslider');?></div>
						</oneshort>
					</row>
					<div class="div15"></div>
					<label_a class="singlerow"><?php _e('Lazy Loading', 'revslider');?></label_a><select class="layerinput tos2 nosearchbox easyinit" data-r="behavior.lazyLoad"><option value="auto" selected="selected"><?php _e("Default Setting", 'revslider');?></option><option value="force"><?php _e("Force Lazy Loading", 'revslider');?></option><option value="ignore"><?php _e("Ignore Lazy Loading", 'revslider');?></option></select>
					
					<!-- USED LIBRARY TYPE-->
					<div style="display:none"><label_a class="singlerow"><?php _e('Used Library', 'revslider');?></label_a><select class="layerinput easyinit" data-r="media.imageLib" data-show="#imagelayer_srctype_*val*" data-hide=".imagelayer_srctype_all" data-showprio="show"><option value="">Nothing</option><option value="objectlibrary">Objectlibrary</option><option value="medialibrary">MediaLibrary</option></select></div>					
					<!-- SIZE / SRC PICKER FOR CURRENT USED LIBRARY TYPE-->
					<div style="display:none" id="imagelayer_srctype_objectlibrary" class="imagelayer_srctype_all"><label_a class="singlerow"><?php _e('Image Size', 'revslider');?></label_a><select class="layerinput tos2 nosearchbox easyinit" data-evt="getNewImageSize" data-evtparam="image.object" data-r="behavior.imageSourceType"><option value="100" selected="selected"><?php _e("Original", 'revslider');?></option><option value="75" selected="selected"><?php _e("Large", 'revslider');?></option><option value="50" selected="selected"><?php _e("Medium", 'revslider');?></option><option value="25" selected="selected"><?php _e("Small", 'revslider');?></option><option value="10" selected="selected"><?php _e("Extra Small", 'revslider');?></option></select></div>
					<div style="display:none" id="imagelayer_srctype_medialibrary" class="imagelayer_srctype_all"><label_a class="singlerow"><?php _e('Source Type', 'revslider');?></label_a><select class="layerinput tos2 nosearchbox easyinit" data-evt="getNewImageSize" data-evtparam="image.media" data-r="behavior.imageSourceType"><option value="auto" selected="selected"><?php _e("Default Setting", 'revslider');?></option><?php foreach ($img_sizes as $imghandle => $imgSize) { echo '<option value="' . $imghandle . '">' . $imgSize . '</option>';}?></select></div>
				</div>
			</div>

			<!-- LAYER VIDEO CONTENT  -->
			<div id="form_layercontent_content_video" class="form_inner open _shfv_ _shfa_">
				<div class="form_inner_header"><i class="material-icons">create</i><?php _e('Media Content', 'revslider');?></div>
				<div class="collapsable">
					<input class="dontseeme layerinput easyinit callEvent" data-evt="resetVideoPlaceholder" data-triggerinp="#layerpostersrctype" data-triggerinpval="nothing" id="layer_video_poster" data-r="media.posterUrl"/>
					<div class="_nsfa_">
						<longoption><i class="material-icons">language</i><label_a ><?php _e('Video from Stream if exist', 'revslider');?></label_a><input type="checkbox" class="easyinit layerinput" data-r="media.videoFromStream"></longoption>
						<div class="div10"></div>
						<label_a><?php _e('Type', 'revslider');?></label_a>
						<div class="radiooption ">
							<div id="video_layer_youtube" class="video_layer_type_selector"><input value="youtube" type="radio" name="layer_video_type" data-select="#video_layer_youtube" data-unselect=".video_layer_type_selector" data-evt="checkVideoID" data-updateviaevt="true" data-show=".layerbg_*val*_settings" data-hide=".layer_bg_settings" class="layervideocontentradio layerinput easyinit callEvent"  data-r="media.mediaType"><label_sub><?php _e('YouTube Video', 'revslider');?></label_sub></div>
							<div id="video_layer_vimeo" class="video_layer_type_selector"><input value="vimeo" type="radio" name="layer_video_type" data-select="#video_layer_vimeo" data-unselect=".video_layer_type_selector" data-evt="checkVideoID" data-updateviaevt="true" data-show=".layerbg_*val*_settings" data-hide=".layer_bg_settings" class="layervideocontentradio layerinput easyinit callEvent"  data-r="media.mediaType"><label_sub><?php _e('Vimeo Video', 'revslider');?></label_sub></div>
							<div id="video_layer_html5" class="video_layer_type_selector"><input value="html5" type="radio" name="layer_video_type" data-select="#video_layer_html5" data-unselect=".video_layer_type_selector" data-evt="checkVideoID" data-updateviaevt="true" data-show=".layerbg_*val*_settings" data-hide=".layer_bg_settings" class="layervideocontentradio layerinput easyinit callEvent"  data-r="media.mediaType"><label_sub><?php _e('HTML5 Video', 'revslider');?></label_sub></div>
							<div id="video_layer_audio" class="video_layer_type_selector" style="display:none"><input value="audio" type="radio" name="layer_video_type" data-select="#video_layer_audio" data-unselect=".video_layer_type_selector" data-evt="checkVideoID" data-updateviaevt="true" data-show=".layerbg_*val*_settings" data-hide=".layer_bg_settings" class="layerinput easyinit callEvent"  data-r="media.mediaType"><label_sub><?php _e('Audio', 'revslider');?></label_sub></div>
						</div>
						<div class="div25"></div>
					</div>
					<div id="video_id_wrap" class="layerbg_youtube_settings layerbg_vimeo_settings layer_bg_settings">
						<label_a><?php _e('Video ID', 'revslider');?></label_a><div class="input_with_buttonextenstion">
							<input id="layer_youtubevimeo_id" data-evt="checkVideoID" class="layerinput easyinit" type="text" data-r="media.id" placeholder="<?php _e('Enter Video ID', 'revslider');?>">
							<div class="buttonextenstion"><div class="basic_action_button  callEventButton onlyicon dark_action_button" data-evt="checkVideoID"><i class="material-icons">sync_problem</i></div></div>
						</div>
					</div>
					<div id="" class="layerbg_audio_settings layer_bg_settings">
						<label_a><?php _e('MPEG', 'revslider');?></label_a><input id="layer_mpegaudio_src" data-evt="" class="layerinput easyinit nmarg" type="text" data-r="media.audioUrl" placeholder="<?php _e('Enter MPEG Source', 'revslider');?>">
						<label_a></label_a><div id="audio_layer_media_library_button" data-evt="checkforaudiolayer" data-mediatype="audio" data-rid="media.id" data-target="#layer_mpegaudio_src" class="getVideoFromMediaLibrary basic_action_button layerinput longbutton callEventButton"><i class="material-icons">style</i><?php _e('Media Library', 'revslider');?></div>
					</div>
					<div id="" class="layerbg_html5_settings layer_bg_settings">
						<label_a><?php _e('MPEG', 'revslider');?></label_a><input id="layer_mpeg_src" data-evt="updatelayerpostermpeg" class="layerinput easyinit nmarg callEvent" type="text" data-r="media.mp4Url" placeholder="<?php _e('Enter MPEG Source', 'revslider');?>">
						<label_a></label_a><div id="video_layer_media_library_button" data-evt="" data-rid="media.id" data-target="#layer_mpeg_src" class="getVideoFromMediaLibrary basic_action_button layerinput longbutton  callEventButton"><i class="material-icons">style</i><?php _e('Media Library', 'revslider');?></div>
						<label_a></label_a><div  id="video_layer_object_library_button" data-evt="updatelayerimagesrc" data-target="#layer_mpeg_src" data-r="media.mp4Url" class="getVideoFromObjectLibrary basic_action_button layerinput longbutton callEventButton"><i class="material-icons">camera_enhance</i><?php _e('Object Library', 'revslider');?></div>
						<longoption><i class="material-icons">aspect_ratio</i><label_a><?php _e('Video Fit Cover', 'revslider');?></label_a><input type="checkbox"  id="video_layer_fit_cover" class="layerinput easyinit" data-r="media.fitCover"/></longoption>
					</div>
					<div class="div15"></div>
					<div id="" class="layerbg_html5_settings layerbg_audio_settings layer_bg_settings">
						<!--<div class="_nsfa_">-->
							<!--<label_a><?php _e('WEBM', 'revslider');?></label_a><div class="input_with_buttonextenstion"><input id="layer_webm_src" data-evt="" class="layerinput easyinit nmarg" type="text" data-r="media.webmUrl" placeholder="<?php _e('Optional WEBM Source', 'revslider');?>"><div data-evt="" data-target="#layer_webm_src" class="getVideoFromMediaLibrary dark_action_button basic_action_button onlyicon layerinput  callEventButton"><i class="material-icons">style</i></div></div>-->
							<!--<label_a><?php _e('OGV', 'revslider');?></label_a><div class="input_with_buttonextenstion"><input id="layer_ogv_src" data-evt="" class="layerinput easyinit nmarg" type="text" data-r="media.ogvUrl" placeholder="<?php _e('Optional OGV Source', 'revslider');?>"><div data-evt="" data-target="#layer_ogv_src" class="getVideoFromMediaLibrary dark_action_button basic_action_button  layerinput onlyicon  callEventButton"><i class="material-icons">style</i></div></div>-->
						<!--</div>-->
						<label_a><?php _e('Preload', 'revslider');?></label_a><select id="layer_media_preload" class="layerinput tos2 nosearchbox easyinit" data-r="media.preload" ><option value="auto" selected="selected"><?php _e('auto', 'revslider');?></option><option value="none"><?php _e('Disabled', 'revslider');?></option><option  value="metadata"><?php _e('Meta Data', 'revslider');?></option></select>
						<div class="_shfa_">
							<label_a><?php _e('Skip Preload', 'revslider');?></label_a><select id="layer_media_preload_wait" class="layerinput tos2 nosearchbox easyinit" data-r="media.preloadWait" ><option value="0">0 sec</option><option value="1">1 sec</option><option  value="2">2 sec</option><option  value="3">3 sec</option><option  value="4">4 sec</option><option selected="selected" value="5">5 sec</option><option  value="6">6 sec</option><option  value="7">7 sec</option><option  value="8">8 sec</option><option  value="9">9 sec</option><option  value="10">10 sec</option></select>
						</div>
					</div>
					<div class="_nsfa_">
						<label_a><?php _e('Aspect Ratio', 'revslider');?></label_a><div class="input_with_buttonextenstion"><select id="layer_video_layeraspectratio" class="layerinput tos2 nosearchbox easyinit"  data-r="media.ratio"><option value="16:9"><?php _e('16:9', 'revslider');?></option><option value="4:3"><?php _e('4:3', 'revslider');?></option><option value="1.85:1"><?php _e('1.85:1', 'revslider');?></option><option value="2.39:1"><?php _e('2.39:1', 'revslider');?></option></select>
							<div class="buttonextenstion">
								<div class="basic_action_button onlyicon callEventButton dark_action_button" data-evt="syncVideoRatio"><i class="material-icons">sync_problem</i></div>
							</div>
						</div>
					</div>
					
					<label_a><?php _e('Auto Play', 'revslider');?></label_a><select id="layer_video_autoplay" class="layerinput tos2 nosearchbox easyinit" data-r="media.autoPlay" ><option value="false" selected="selected"><?php _e('Off', 'revslider');?></option><option value="true"><?php _e('On', 'revslider');?></option><option value="1sttime"><?php _e('Only 1st Time Slide shown', 'revslider');?></option><option value="no1sttime"><?php _e('On - Skip 1st Time Slide', 'revslider');?></option></select><span class="linebreak"></span>		
				</div>
			</div>

			<!-- LAYER VIDEO POSTER CONTENT  -->
			<div id="form_layercontent_content_videoposter" class="form_inner open _shfv_">
				<div class="form_inner_header"><i class="material-icons">filter_hdr</i><?php _e('Media Poster', 'revslider');?></div>
				<div class="collapsable">
					<longoption><i class="material-icons">language</i><label_a ><?php _e('Poster from Stream if exist', 'revslider');?></label_a><input type="checkbox" class="easyinit layerinput" data-r="media.posterFromStream"></longoption>
					<div class="div10"></div>
					<div id="" class="layerbg_youtube_settings layer_bg_settings">
						<label_a><?php _e('Poster Image', 'revslider');?></label_a><div data-r="media.posterUrl" class="getLayerImageFromYouTube basic_action_button longbutton"><i class="material-icons">ondemand_video</i><?php _e('YouTube Thumb', 'revslider');?></div>
					</div>

					<div id="" class="layerbg_vimeo_settings layer_bg_settings">
						<label_a><?php _e('Poster Image', 'revslider');?></label_a><div data-r="media.posterUrl" class="getLayerImageFromVimeo basic_action_button longbutton"><i class="material-icons">ondemand_video</i><?php _e('Vimeo Thumb', 'revslider');?></div>
					</div>
					<div id="" class="layerbg_html5_settings layer_bg_settings">
						<label_a><?php _e('Poster Image', 'revslider');?></label_a><div data-evt="gethtml5posterimage" data-evtparam="layer" class="basic_action_button longbutton callEventButton"><i class="material-icons">linked_camera</i><?php _e('Get Start Frame', 'revslider');?></div>
					</div>
					<label_a></label_a><div data-evt="updatelayerimagesrc" data-r="media.posterUrl" data-rid="media.posterId" data-sty="behavior.imageSourceType" data-lib="media.imageLib" class="getImageFromMediaLibrary layerinput basic_action_button longbutton"><i class="material-icons">style</i><?php _e('Media Library', 'revslider');?></div>
					<label_a></label_a><div id="image_videoposter_object_library_button" data-evt="updatelayerimagesrc" data-r="media.posterUrl" data-rid="media.posterId" data-sty="behavior.imageSourceType" data-lib="media.imageLib" class="getImageFromObjectLibrary basic_action_button longbutton layerinput"><i class="material-icons">camera_enhance</i><?php _e('Object Library', 'revslider');?></div>
					<!--<label_a></label_a><div id="image_videoposter_stream_button" data-evt="updatelayerimagesrc" data-r="media.posterUrl" data-rid="media.posterId" class="getImageFromStream basic_action_button longbutton layerinput"><i class="material-icons">language</i><?php _e("From Stream", 'revslider');?></div>-->
					<label_a></label_a><div data-r="media.posterUrl" data-rid="media.posterId" data-sty="behavior.imageSourceType" data-lib="media.imageLib"  class="removeLayerPoster basic_action_button layerinput longbutton callEventButton"><i class="material-icons">delete</i><?php _e('Remove Poster', 'revslider');?></div>
					<div class="div10"></div>
					
					<!-- USED LIBRARY TYPE-->
					<div style="display:none"><label_a class="singlerow"><?php _e('Used Library', 'revslider');?></label_a><select class="layerinput easyinit" id="layerpostersrctype" data-r="media.imageLib" data-show="#posterlayer_srctype_*val*" data-hide=".posterlayer_srctype_all" data-showprio="show"><option value="nothing">Nothing</option><option value="">Nothing</option><option value="objectlibrary">Objectlibrary</option><option value="medialibrary">MediaLibrary</option></select></div>					
					<!-- SIZE / SRC PICKER FOR CURRENT USED LIBRARY TYPE-->
					<div id="posterlayer_srctype_objectlibrary" class="posterlayer_srctype_all"><label_a class="singlerow"><?php _e('Image Size', 'revslider');?></label_a><select class="layerinput tos2 nosearchbox easyinit" data-evt="getNewImageSize" data-evtparam="poster.object" data-r="behavior.imageSourceType"><option value="100" selected="selected"><?php _e("Original", 'revslider');?></option><option value="75" selected="selected"><?php _e("Large", 'revslider');?></option><option value="50" selected="selected"><?php _e("Medium", 'revslider');?></option><option value="25" selected="selected"><?php _e("Small", 'revslider');?></option><option value="10" selected="selected"><?php _e("Extra Small", 'revslider');?></option></select></div>
					<div id="posterlayer_srctype_medialibrary" class="posterlayer_srctype_all"><label_a class="singlerow"><?php _e('Source Type', 'revslider');?></label_a><select class="layerinput tos2 nosearchbox easyinit" data-evt="getNewImageSize" data-evtparam="poster.media" data-r="behavior.imageSourceType"><option value="auto" selected="selected"><?php _e("Default Setting", 'revslider');?></option><?php foreach ($img_sizes as $imghandle => $imgSize) { echo '<option value="' . $imghandle . '">' . $imgSize . '</option>';}?></select></div>
					
					<div class="div10"></div>
					<longoption><i class="material-icons">pause</i><label_a><?php _e('Poster in Pause', 'revslider');?></label_a><input type="checkbox" class="easyinit layerinput" data-r="media.posterOnPause"></longoption>
					<longoption><i class="material-icons">phonelink_erase</i><label_a><?php _e('No Poster on Mobile', 'revslider');?></label_a><input type="checkbox" class="easyinit layerinput" data-r="media.disableOnMobile"></longoption>
					<longoption><i class="material-icons">smartphone</i><label_a><?php _e('Only Poster on Mobile', 'revslider');?></label_a><input type="checkbox" class="easyinit layerinput" data-r="media.posterOnMobile"></longoption>
				</div>
			</div>
			<!-- LAYER VIDEO POSTER CONTENT  -->
			<div id="form_layercontent_content_videooverlay" class="form_inner open _shfv_ _shfa_">
				<div class="form_inner_header"><i class="material-icons">filter_hdr</i><?php _e('Overlay', 'revslider');?></div>
				<div class="collapsable">
					<div class="_nsfa_">
						<!-- SLIDE VIDEO OVERLAY -->
							<label_a><?php _e('Overlay', 'revslider');?></label_a><select data-evt="updateslidebasic" id="layer_dotted_overlay" class="dottedoverlay layerinput tos2 nosearchbox easyinit callEvent" data-r="media.dotted"></select>
							<label_a><?php _e('Size', 'revslider');?></label_a><input data-numeric="true" data-allowed="none" data-min="0"  data-r="media.dottedSize" data-evt="drawBGOverlay"  type="text"  class="layerinput valueduekeyboard  easyinit callEvent" placeholder="none" >
							<label_a><?php _e('Color 1', 'revslider');?></label_a><input type="text" data-editing="Video Overlay Color 1" data-evt="updateslidebasic" name="layervideooverlaycolor_a" id="layervideooverlaycolor_a" class="my-color-field layerinput easyinit" data-visible="true" data-mode="single" data-r="media.dottedColorA" value="transparent">
							<label_a><?php _e('Color 2', 'revslider');?></label_a><input type="text" data-editing="Video Overlay Color 2" data-evt="updateslidebasic" name="layervideooverlaycolor_b" id="layervideooverlaycolor_b" class="my-color-field layerinput easyinit" data-visible="true" data-mode="single" data-r="media.dottedColorB" value="transparent">						
					</div>
				</div>
			</div>
			<!-- LAYER VIDEO SETTINGS -->
			<div id="form_layercontent_content_video_adv" class="form_inner open _shfv_ _shfa_ layerbg_youtube_settings layerbg_vimeo_settings layer_bg_settings">
				<div class="form_inner_header"><i class="material-icons">video_library</i><?php _e('Advanced Media Settings', 'revslider');?></div>
				<div class="collapsable">
					<longoption><i class="material-icons">stop</i><label_a ><?php _e('Stop Other Media', 'revslider');?></label_a><input type="checkbox" class="easyinit layerinput" data-r="media.stopAllVideo"></longoption>
					<longoption class="_nsfa_"><i class="material-icons">fullscreen</i><label_a ><?php _e('Allow Fullscreen', 'revslider');?></label_a><input type="checkbox" class="easyinit layerinput" data-r="media.allowFullscreen"></longoption>
					<longoption><i class="material-icons">pause</i><label_a ><?php _e('Pause Timer during Play', 'revslider');?></label_a><input type="checkbox" class="easyinit layerinput" data-r="media.pausetimer"></longoption>
					<longoption><i class="material-icons">loop</i><label_a ><?php _e('Loop Media', 'revslider');?></label_a><input type="checkbox" class="easyinit layerinput" data-r="media.loop" id="layer_media_loop" data-change="layer_media_nextslideaten" data-changeto="false" data-changewhennot="false"></longoption>					
					<longoption><i class="material-icons">skip_next</i><label_a ><?php _e('Next Slide at End', 'revslider');?></label_a><input type="checkbox" class="easyinit layerinput" data-r="media.nextSlideAtEnd" id="layer_media_nextslideaten" data-change="layer_media_loop" data-changeto="false" data-changewhennot="false"></longoption>
					<longoption><i class="material-icons">fast_rewind</i><label_a ><?php _e('Rewind at Start', 'revslider');?></label_a><input type="checkbox" class="easyinit layerinput" data-r="media.forceRewind"></longoption>
					<longoption class="_nsfa_"><i class="material-icons">play_for_work</i><label_a><?php _e('No Interaction', 'revslider');?></label_a><input type="checkbox" class="easyinit layerinput callEvent" data-updateviaevt="true" data-evt="disableAllMediaControls" data-r="media.nointeraction" data-showhide="#mediacontroloptions" data-showhidedep="false"></longoption>
					<div id="mediacontroloptions">
						<longoption><i class="material-icons">videogame_asset</i><label_a ><?php _e('Controls', 'revslider');?></label_a><input type="checkbox" class="easyinit layerinput callEvent mediacontroloption" data-updateviaevt="true" data-evt="audioControlOnOff" id="mediacontrols" data-r="media.controls"></longoption>
						<longoption class="layerbg_html5_settings layer_bg_settings"><i class="material-icons">keyboard</i><label_a><?php _e('Large Controls', 'revslider');?></label_a><input type="checkbox" class="easyinit layerinput mediacontroloption" data-id="medialargecontrol" data-r="media.largeControls"></longoption>
					</div>
					<longoption class="_nsfa_"><i class="material-icons">featured_video</i><label_a ><?php _e('Inline Mode', 'revslider');?></label_a><input type="checkbox" class="easyinit layerinput" data-r="media.playInline"></longoption>
					<longoption class="_nsfa_"><i class="material-icons">volume_mute</i><label_a><?php _e('Mute at Start', 'revslider');?></label_a><input type="checkbox" class="easyinit layerinput" data-r="media.mute"></longoption>
					<div class="div15"></div>
					<row class="directrow">
						<onelong><label_icon class="ui_volume"></label_icon><input id="layer_video_volume" data-allowed="" data-numeric="true" data-min="0" data-max="100" class="layerinput easyinit" type="text" data-r="media.volume" placeholder="<?php _e('Media Volume (0-100)', 'revslider');?>"></onelong>
						<oneshort class="layerbg_youtube_settings layer_bg_settings"><label_icon class="ui_speed"></label_icon><select id="layer_media_speed" class="layerinput tos2 nosearchbox easyinit" data-r="media.speed" ><option value="0.25"><?php _e('1/4', 'revslider');?></option><option value="0.50"><?php _e('1/2', 'revslider');?></option><option selected="selected" value="1"><?php _e('Normal', 'revslider');?></option><option value="1.5"><?php _e('x1.5', 'revslider');?></option><option value="2.0"><?php _e('x2', 'revslider');?></option></select></oneshort>
					</row>
					<row class="directrow">
						<onelong><label_icon class="ui_startat"></label_icon><input id="layer_video_start" class="layerinput easyinit callEvent" data-evt="updateaudiorange" type="text" data-r="media.startAt" placeholder="<?php _e('i.e. 0:15', 'revslider');?>"></onelong>
						<oneshort><label_icon class="ui_endat"></label_icon><input id="layer_video_end" class="layerinput easyinit callEvent" data-evt="updateaudiorange" type="text" data-r="media.endAt" placeholder="<?php _e('i.e. 2:41', 'revslider');?>"></oneshort>
					</row>

					<div id="media_audio_wave_wrap">
						<div id="audio_simulator" data-states="play,stop" data-start_state="play" data-stop="listenAudioMaster" data-stop_state="" data-stop_icon="stop" data-play="muteAudioMaster" data-play_state="" data-play_icon="play_arrow" class="disabled basic_action_button onlyicon switch_button" data-state="play"><i class="switch_button_icon material-icons">play_arrow</i><span class="switch_button_state"></span></div>
						<div id="media_audio_master"></div>
					</div>
				</div>
			</div>

			<!-- LAYER VIDEO ARGUMENTS-->
			<div id="form_layercontent_content_video_attr" class="layerbg_youtube_settings layerbg_vimeo_settings layer_bg_settings form_inner open _shfv_ _nsfa_">
				<div class="form_inner_header"><i class="material-icons">video_library</i><?php _e('Arguments', 'revslider');?></div>
				<div class="collapsable">
					<label_a><?php _e('Arguments', 'revslider');?></label_a><input id="layer_video_arg" class="layerinput easyinit" type="text" data-r="media.args" placeholder="Leave Empty for Default"><span class="linebreak"></span>
					<label_a></label_a><div data-evt="" class="resetVideoArguments basic_action_button layerinput longbutton callEventButton"><i class="material-icons">settings_backup_restore</i><?php _e('Reset', 'revslider');?></div>
				</div>
			</div>

			<!-- LAYER SHAPE CONTENT
			<div id="form_layercontent_content" class="form_inner open _shfs_">
				<div class="form_inner_header"><i class="material-icons">crop_landscape</i><?php _e('Shape Layer Content', 'revslider');?></div>
				<div class="collapsable">
				</div>
			</div>-->

			<!-- DISPLAY MODE IN COLUMN -->
			<div id="form_layercontent_content_column_display" class="form_inner open  _shflic_ _homs_">
				<div class="form_inner_header"><i class="material-icons">reorder</i><?php _e('Display Mode in Column', 'revslider');?></div>
				<div class="collapsable">
					<label_a><?php _e('Display', 'revslider');?></label_a><select id="layer_displaymode" class="layerinput tos2 nosearchbox easyinit"  data-r="idle.display"><option value="block" selected="selected"><?php _e('Block', 'revslider');?></option><option value="inline-block"><?php _e('Inline-Block', 'revslider');?></option></select>
					<label_a><?php _e('Float', 'revslider');?></label_a><select id="layer_floatmode" class="layerinput tos2 nosearchbox easyinit"   data-r="idle.float.#size#.v"><option value="none" selected="selected"><?php _e('None', 'revslider');?></option><option value="left"><?php _e('Left', 'revslider');?></option><option value="right"><?php _e('Right', 'revslider');?></option></select>
					<label_a><?php _e('Clear', 'revslider');?></label_a><select id="layer_clearmode" class="layerinput tos2 nosearchbox easyinit"  data-r="idle.clear.#size#.v"><option value="none" selected="selected"><?php _e('None', 'revslider');?></option><option value="left"><?php _e('Left', 'revslider');?></option><option value="right"><?php _e('Right', 'revslider');?></option><option value="both"><?php _e('Both', 'revslider');?></option></select>
					<div class="div10"></div>					
					<div data-pos="before" data-helpkey="linebreak_before" style="text-align:left" class="add_linebreak basic_action_button longbutton layerinput rightbutton"><i class="material-icons">vertical_align_top</i><?php _e('Add LineBreak Before', 'revslider');?></div><linebreak></linebreak>
					<div data-pos="after" data-helpkey="lineabreak_after" style="text-align:left" class="add_linebreak basic_action_button longbutton layerinput rightbutton"><i class="material-icons">vertical_align_bottom</i><?php _e('Add LineBreak After', 'revslider');?></div><linebreak></linebreak>					
				</div>
			</div>

			<!-- LAYER CONTENT TAG -->
			<div id="form_layercontent_tag" class="form_inner open _nsfr_ _nsfc_">
				<div class="form_inner_header"><i class="material-icons">code</i><?php _e('HTML Tag', 'revslider');?></div>
				<div class="collapsable">
					<label_a><?php _e('Wrapping Tag', 'revslider');?></label_a><select id="layer_htmltag" class="layerinput tos2 nosearchbox easyinit" data-r="htmltag"><option value="div" selected="selected"><?php _e('&lt;rs-layer&gt;', 'revslider');?></option><option value="p"><?php _e('&lt;p&gt;', 'revslider');?></option><option value="h1"><?php _e('&lt;h1&gt;', 'revslider');?></option><option value="h2"><?php _e('&lt;h2&gt;', 'revslider');?></option><option value="h3"><?php _e('&lt;h3&gt;', 'revslider');?></option><option value="h4"><?php _e('&lt;h4&gt;', 'revslider');?></option><option value="h5"><?php _e('&lt;h5&gt;', 'revslider');?></option><option value="h6"><?php _e('&lt;h6&gt;', 'revslider');?></option><option value="span"><?php _e('&lt;span&gt;', 'revslider');?></option></select>
				</div>
			</div>

			<!-- LAYER CONTENT CONVERT -->
			<div id="form_layercontent_convert" class="form_inner open _nsfr_ _nsfc_ _nsfs_ _nsfa_">
				<div class="form_inner_header"><i class="material-icons">swap_horizontal_circle</i><?php _e('Convert Layer Type', 'revslider');?></div>
				<div class="collapsable">					
					<div data-into="button" class="_shoft_ convert_layer_into basic_action_button layerinput longbutton rightbutton"><i class="material-icons">swap_horizontal_circle</i>Convert to Button</div>
					<div data-into="text" class="_shofb_ convert_layer_into basic_action_button layerinput longbutton rightbutton"><i class="material-icons">swap_horizontal_circle</i>Convert to Text</div>
					<div data-into="video" class="_shfi_ convert_layer_into basic_action_button layerinput longbutton rightbutton"><i class="material-icons">swap_horizontal_circle</i>Convert to Video</div>
					<div data-into="image" class="_shfv_ convert_layer_into basic_action_button layerinput longbutton rightbutton"><i class="material-icons">swap_horizontal_circle</i>Convert to Image</div>
				</div>
				<div class="div50"></div>
			</div>

		</div>
	</div><!-- END OF LAYER CONTENT CONTAINER -->

	<!-- LAYER STATIC SETTINGS -->
	<div class="form_collector layer_settings_collector" data-type="layersconfig" data-pcontainer="#layer_settings" data-offset="#rev_builder_wrapper">
		<div id="form_layer_static"  class="formcontainer form_menu_inside collapsed" data-select="#gst_layer_14" data-unselect=".layer_submodule_trigger">
			<!--<div class="collectortabwrap"><div id="collectortab_form_layer_static" class="collectortab form_menu_inside" data-forms='["#form_layer_static"]'><i class="material-icons">album</i><?php _e('Global Layer Settings', 'revslider');?></div></div>-->


			<!-- LAYER STATIC basic SETTINGS-->
			<div id="form_layer_static_basic" class="form_inner open _nsfr_ _nsfc_">
				<div class="form_inner_header"><i class="material-icons">album</i><?php _e('Global Layer Settings', 'revslider');?></div>
				<div class="collapsable">
					<!--<longoption><i class="material-icons">important_devices</i><label_a><?php _e('Layer is Global', 'revslider');?></label_a><input type="checkbox"  data-showhide="#global_layer_settings_wrap" data-updateviaevt="true" data-evt="globalLayerSettingUpdate" id="layer_globalLayer" class="layerinput easyinit callEvent" data-r="static.isStatic" /></longoption>-->
					<div id="global_layer_settings_wrap">
						<label_icon class="ui_easing_in singlerow"></label_icon><select id="staticlayer_Startindex" class="layerinput tos2 nosearchbox easyinit"  data-r="timeline.static.start"><option value="1" selected="selected">1</option><option value="2">2</option><option value="3">3</option></select>
						<label_icon class="ui_easing_out singlerow"></label_icon><select id="staticlayer_Endindex" class="layerinput tos2 nosearchbox easyinit"  data-r="timeline.static.end"><option value="2" selected="selected">2</option><option value="3">3</option><option value="4">4</option><option value="last"><?php _e('Last Slide', 'revslider');?></option></select>
					</div>
				</div>
			</div>


		</div>
	</div>

	<!-- LAYER RESPONSIVENESS -->
	<div class="form_collector layer_settings_collector" data-type="layersconfig" data-pcontainer="#layer_settings" data-offset="#rev_builder_wrapper">
		<div id="form_layer_visibility"  class="formcontainer form_menu_inside collapsed" data-select="#gst_layer_13" data-unselect=".layer_submodule_trigger">
			<!-- LAYER CONTENT VISIBILITY -->
			<div id="form_layercontent_visibility" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">visibility</i><?php _e('Visibility', 'revslider');?></div>
				<div class="collapsable">
					<row class="directrow">
						<onelong><label_icon class="ui_desktop"></label_icon><input type="checkbox" class="easyinit layerinput" data-r="visibility.d"></onelong>
						<oneshort><label_icon class="ui_notebook"></label_icon><input type="checkbox" class="easyinit layerinput" data-r="visibility.n" ></oneshort>
					</row>
					<row class="directrow">
						<onelong><label_icon class="ui_tablet"></label_icon><input type="checkbox" class="easyinit layerinput" data-r="visibility.t" ></onelong>
						<oneshort><label_icon class="ui_mobile"></label_icon><input type="checkbox" class="easyinit layerinput" data-r="visibility.m" ></oneshort>
					</row>

					<longoption><i class="material-icons">settings_ethernet</i><label_a><?php _e('Hide "Under" Width', 'revslider');?></label_a><input type="checkbox"  id="layer_visibility_hideunder" class="layerinput easyinit" data-r="visibility.hideunder" /></longoption>
					<longoption><i class="material-icons">center_focus_strong</i><label_a><?php _e('Show if mouse over Slider', 'revslider');?></label_a><input type="checkbox"  id="layer_visibility_showonover" class="layerinput easyinit" data-r="visibility.onlyOnSlideHover" /></longoption>
					<div class="_lavoc_ _lavoc_individual"><longoption class="carouselavailable standardunavailable sceneunavailable"><i class="material-icons">view_carousel</i><label_a><?php _e('Always Visible on Carousel', 'revslider');?></label_a><input type="checkbox"  id="layer_visibility_oncarousel" class="layerinput easyinit" data-r="visibility.alwaysOnCarousel" /></longoption></div>
				</div>
			</div>
		</div>
	</div>

	<!-- LAYER POSITION CONTAINER -->
	<div class="form_collector layer_settings_collector" data-type="layersconfig" data-pcontainer="#layer_settings" data-offset="#rev_builder_wrapper">
		<div id="form_layer_position"  class="formcontainer form_menu_inside collapsed" data-select="#gst_layer_2" data-unselect=".layer_submodule_trigger">			
			
			<!-- LAYER POSITION basic -->
			<div id="form_staticlayerposition_basic" class="form_inner open _nsfc_ _nsfr_ _nflic_">
				<div class="form_inner_header"><i class="material-icons">zoom_out_map</i><?php _e('Static Layer Depth', 'revslider');?></div>
				<div class="collapsable ">
					<label_a><?php _e('Force Z Depth', 'revslider');?></label_a><select id="staticlayer_zposition" class="layerinput tos2 nosearchbox easyinit"  data-r="position.staticZ"><option value="default" selected="selected"><?php _e('Static Slide based', 'revslider');?></option><option value="front"><?php _e('Force Front', 'revslider');?></option><option value="back"><?php _e('Force Back', 'revslider');?></option></select>
				</div>
			</div>

			<!-- LAYER POSITION basic -->
			<div id="form_layerposition_basic" class="form_inner open _nsfc_">
				<div class="form_inner_header"><i class="material-icons">zoom_out_map</i><?php _e('Position & Size', 'revslider');?></div>
				<div class="collapsable ">
					<div id="rs-align-buttons" class="_nfr_ _nflic_">
						<!-- LAYER ALIGN ICON BASED SETTINGS-->
						<select style="display:none !important" id="layer_pos_halign" data-unselect=".layer_hor_selector" data-select="#layer_hor_*val*" class="layerinput easyinit" data-responsive="true" data-r="position.horizontal.#size#.v" data-triggerinp="#layer_pos_x" data-triggerinpval="0"><option value="left"><?php _e('Left', 'revslider');?></option><option value="center"><?php _e('Center', 'revslider');?></option><option value="right"><?php _e('Right', 'revslider');?></option></select>
						<select style="display:none !important" id="layer_pos_valign" data-unselect=".layer_ver_selector" data-select="#layer_ver_*val*" class="layerinput easyinit" data-responsive="true" data-r="position.vertical.#size#.v" data-triggerinp="#layer_pos_y" data-triggerinpval="0"><option value="top"><?php _e('Top', 'revslider');?></option><option value="middle"><?php _e('Center', 'revslider');?></option><option value="bottom"><?php _e('Bottom', 'revslider');?></option></select>
						<row>
							<onelabel><label_a><?php _e('Alignment', 'revslider');?></label_a></onelabel>
							<oneshort><label_icon class="triggerselect ui_leftalign layer_hor_selector" data-select="#layer_pos_halign" data-val="left" id="layer_hor_left"></label_icon><label_icon class="triggerselect ui_centeralign layer_hor_selector" data-select="#layer_pos_halign" data-val="center" id="layer_hor_center"></label_icon><label_icon class="triggerselect ui_rightalign layer_hor_selector" data-select="#layer_pos_halign" data-val="right" id="layer_hor_right"></label_icon></oneshort>
							<oneshort class="lp10"><label_icon class="triggerselect ui_topalign layer_ver_selector" data-select="#layer_pos_valign" data-val="top" id="layer_ver_top"></label_icon><label_icon class="triggerselect ui_middlealign layer_ver_selector" data-select="#layer_pos_valign" data-val="middle" id="layer_ver_middle"></label_icon><label_icon class="triggerselect ui_bottomalign layer_ver_selector" data-select="#layer_pos_valign" data-val="bottom" id="layer_ver_bottom"></label_icon></oneshort>
						</row>
					</div>
					<row class="directrow _nfr_ _nfc_ _nflic_">
						<onelong><label_icon class="ui_x"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-allowed="px" data-responsive="true" data-numeric="true" data-r="position.x.#size#.v" data-min="-3000" data-max="3000" type="text" id="layer_pos_x"></onelong>
						<oneshort class="_nfr_"><label_icon class="ui_y"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-responsive="true" data-numeric="true" data-allowed="px" data-r="position.y.#size#.v" data-min="-3000" data-max="5000" type="text" id="layer_pos_y"></oneshort>
					</row>
					<row class="_nfr_ _nfc_">
						<onelong class="layersize_wrap layersize_wrap_width layersize_fullwidth layersize_cover layersize_cover-proportional"><label_icon class="ui_width"></label_icon><input data-numeric="true" data-allowed="%,px,auto,#/#" data-min="0" data-max="10000" data-updateviaevt="true" data-evt="layerSizeChange" data-evtparam="width" data-presets_text="Auto!100%!200px!#1/3#!#2/3#" data-responsive="true" data-presets_val="auto!100%!200px!#1/3#!#2/3#" data-r="size.width.#size#.v" type="text" id="layer_width"  class="layerinput smallinput easyinit input_with_presets callEvent"></onelong>
						<oneshort class="layersize_wrap layersize_wrap_height layersize_fullheight layersize_cover layersize_cover-proportional"><label_icon class="ui_height"></label_icon><input data-numeric="true" data-allowed="%,px,auto,#/#" data-min="0" data-max="10000" data-updateviaevt="true" data-evt="layerSizeChange" data-evtparam="height" data-presets_text="Auto!100%!200px!#1/3#!#2/3#" data-responsive="true" data-presets_val="auto!100%!200px!#1/3#!#2/3#" data-r="size.height.#size#.v" type="text" id="layer_height"  class="layerinput smallinput easyinit input_with_presets callEvent"></oneshort>
						<div id="reset_lock_media_size_layer" class="_nsft_ _nsfa_ _nsfb_">
							<div class="icon_trigger_wrap">
								<div id="layer_scaleprop_iconswitch" class="icon_switcher _nfr_ _nfc_ _nft_ _nfa_ _nsfsvg_" data-ref="#size_scaleProportional"><i class="material-icons icon_state_off">lock_open</i><i class="material-icons icon_state_on">lock_outline</i><input class="easyinit layerinput callEvent" id="size_scaleProportional" data-updateviaevt="true" data-evt="lockLayerRatio" data-setclasson="layer_scaleprop_iconswitch" data-class="icsw_on" type="checkbox" data-r="size.scaleProportional"></div>
								<div class="triggerEvent icon_trigger" data-evt="restoreLayersSize"><i class="material-icons mirrorhorizontal">refresh</i></div>
							</div>
						</div>
					</row>

					<div class="_nsfc_ _nsfr_ _nsft_ _nsfa_ _nsfb_ _nsfsvg_ _nsftbsic_">
						<label_a><?php _e('Size Presets', 'revslider');?></label_a><select id="layer_covermode" data-enable=".layersize_wrap " data-disable=".layersize_*val*" class="layerinput tos2 nosearchbox easyinit callEvent" data-updateviaevt="true" data-evt="layerSizePreset" data-r="size.covermode"><option value="custom" selected="selected"><?php _e('Custom Size', 'revslider');?></option><option value="fullwidth"><?php _e('Full Width', 'revslider');?></option><option value="fullheight"><?php _e('Full Height', 'revslider');?></option><option value="cover"><?php _e('Stretch', 'revslider');?></option><option value="cover-proportional"><?php _e('Cover', 'revslider');?></option></select>
					</div>
					<div class="_nflic_ _nvojcm_">
						<label_a><?php _e('Layer Align', 'revslider');?></label_a>
						<div class="radiooption">
							<div><input name="layer_within_align" class="layerinput easyinit" data-r="behavior.baseAlign" data-evt="layerAlignChanged" type="radio" value="grid"><label_sub><?php _e('Layer Area', 'revslider');?></label_sub></div>
							<div><input name="layer_within_align" class="layerinput easyinit" data-r="behavior.baseAlign" data-evt="layerAlignChanged" type="radio" value="slide"><label_sub><?php _e('Scene', 'revslider');?></label_sub></div>
						</div>
					</div>
				</div>
			</div>

			<!-- LAYER POSITION ADDITIONAL -->
			<div id="form_layerposition_additional" class="form_inner open _nsfc_">
				<div class="form_inner_header"><i class="material-icons">select_all</i><?php _e('Additional', 'revslider');?></div>
				<div class="collapsable">

					<row class="directrow _nsfr_ _nsfc_">
						<onelong><label_icon class="ui_minwidth"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-allowed="px,none" data-presets_text="None" data-presets_val="none" data-numeric="true" data-responsive="true" data-r="size.minWidth.#size#.v" data-min="-3000" data-max="3000" type="text" id="layer_min_width"></onelong>
						<oneshort><label_icon class="ui_maxwidth"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-allowed="px,none" data-presets_text="None" data-presets_val="none" data-numeric="true" data-responsive="true" data-r="size.maxWidth.#size#.v" data-min="-3000" data-max="3000" type="text" id="layer_max_width"></oneshort>
					</row>

					<row class="directrow">
						<onelong class="_nsfc_"><label_icon class="ui_minheight"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-allowed="px,none" data-presets_text="None" data-presets_val="none" data-responsive="true" data-numeric="true" data-r="size.minHeight.#size#.v" data-min="-3000" data-max="3000" type="text" id="layer_min_height"></onelong>
						<oneshort class="_nsfc_ _nsfr_"><label_icon class="ui_maxheight"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-allowed="px,none" data-presets_text="None" data-presets_val="none" data-responsive="true" data-numeric="true" data-r="size.maxHeight.#size#.v" data-min="-3000" data-max="3000" type="text" id="layer_max_height"></oneshort>
					</row>

				</div>
			</div>

			<div id="form_layerposition_advanced" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">photo_size_select_large</i><?php _e('Responsive Behavior', 'revslider');?></div>
				<div class="collapsable">

					<longoption><i class="material-icons">important_devices</i><label_a><?php _e('Intelligent Inheriting', 'revslider');?></label_a><input type="checkbox"  data-show="#intelligent_buttons_*val*" data-hide=".intelligent_buttons" data-updateviaevt="true" data-evt="intelligentInheritUpdate" id="layer_behavior_intelSize" class="layerinput easyinit callEvent" data-r="behavior.intelligentInherit" /></longoption>
					<div class="div10"></div>
					<div id="intelligent_buttons_true" class="intelligent_buttons fullbutton basic_action_button callEventButton" data-evt="resetIntelligentInherits"><i class="material-icons">refresh</i>Inherit All Values from Desktop</div>
					<div id="intelligent_buttons_false" class="intelligent_buttons fullbutton basic_action_button callEventButton" data-evt="inheritValuesFromDesktop"><i class="material-icons">refresh</i>Reset All Values from Desktop</div>
					<div class="div5"></div>
					<longoption><i class="material-icons">launch</i><label_a><?php _e('Resize Between Devices', 'revslider');?></label_a><input type="checkbox"  id="layer_behavior_autoResponsive" class="layerinput easyinit" data-r="behavior.autoResponsive" /></longoption>
					<div class="_nsfr_ _nsfc_">
						<longoption><i class="material-icons">picture_in_picture</i><label_a><?php _e('Responsive Offsets', 'revslider');?></label_a><input type="checkbox"  id="layer_behavior_responsiveOffset" class="layerinput easyinit" data-r="behavior.responsiveOffset" /></longoption>
						<longoption><i class="material-icons">folder_shared</i><label_a><?php _e('Responsive Children', 'revslider');?></label_a><input type="checkbox"  id="layer_behavior_responsiveChilds" class="layerinput easyinit" data-r="behavior.responsiveChilds" /></longoption>
					</div>
					<div class="div5"></div>
				</div>
			</div>

		</div>
	</div><!-- END OF LAYER POSITION CONTAINER -->


	<!-- LAYER STYLE CONTAINER -->
	<div class="form_collector layer_settings_collector" data-type="layersconfig" data-pcontainer="#layer_settings" data-offset="#rev_builder_wrapper">
		<div id="form_layer_style"  class="formcontainer form_menu_inside collapsed" data-select="#gst_layer_3" data-unselect=".layer_submodule_trigger">
			<!--<div class="collectortabwrap"><div id="collectortab_form_layer_style" class="collectortab form_menu_inside" data-forms='["#form_layer_style"]'><i class="material-icons">color_lens</i><?php _e('Style', 'revslider');?></div></div>					-->
			<ul class="form_menu_level_1">
				<li data-target="#form_layerstyle_font" class="form_menu_level_1_li selected" id="lstyle_l1_1"><?php _e('Font', 'revslider');?></li>
				<li data-target="#form_layerstyle_bg" class="form_menu_level_1_li" id="lstyle_l1_2"><?php _e('Background', 'revslider');?></li>
			</ul>

			<div id="form_layerstyle_lineheight" class="form_inner open _shfc_">
				<div class="form_inner_header"><i class="material-icons">title</i><?php _e('Line Height', 'revslider');?></div>
				<div class="collapsable">
					<row class="directrow __idle__">
						<onelong><label_icon class="ui_lineheight"></label_icon><input data-evt="updateLayerPosition" class="layerinput valueduekeyboard smallinput easyinit callEvent" data-allowed="px"  data-numeric="true" data-responsive="true" data-r="idle.lineHeight.#size#.v" data-max="500" type="text" id="layer_line_height_idle_all"></onelong>
						<oneshort></oneshort>
					</row>
				</div>
			</div>
			<!-- LAYER STYLE FONT -->
			<div id="form_layerstyle_font" class="form_inner open _shft_">
				<div id="flf_font_icon" class="form_inner_header"><i class="material-icons">title</i><?php _e('Font & Icon', 'revslider');?></div>
				<div class="collapsable">

					<row class="directrow __idle__">
						<onelong><label_icon class="ui_fontsize"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-allowed="px"  data-numeric="true" data-responsive="true" data-r="idle.fontSize.#size#.v"  data-max="500" type="text" id="layer_font_size_idle"></onelong>
						<oneshort><label_icon class="ui_lineheight"></label_icon><input data-evt="updateLayerPosition" class="layerinput valueduekeyboard smallinput easyinit callEvent" data-allowed="px"  data-numeric="true" data-responsive="true" data-r="idle.lineHeight.#size#.v" data-max="500" type="text" id="layer_line_height_idle"></oneshort>
					</row>
					<row class="directrow __idle__">
						<onelong><label_icon class="ui_fontweight"></label_icon><select id="layer_fontweight_idle" data-theme="min120" data-evt="updateFontFamily" data-evtparam="fontweight" class="layerinput tos2 nosearchbox easyinit" data-responsive="true" data-r="idle.fontWeight.#size#.v"><option value="100">100 Thin</option><option value="200">200 Extra-Light</option><option value="300">300 Light</option><option selected="selected" value="400">400 Regular</option><option value="500">500 Medium</option><option value="600">600 Semi-Bold </option><option value="700">700 Bold</option><option value="800">800 Extra-Bold</option><option value="900">900 Black</option></select></onelong>
						<oneshort><label_icon class="ui_letterspacing"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-responsive="true" data-r="idle.letterSpacing.#size#.v" data-min="-100" data-max="100" type="text" id="layer_letter_spacing_idle"></oneshort>
					</row>
					<div class="div10"></div>
					<label_a></label_a><div id="quick_style_trigger" data-evt="quickstyletrigger" class="longbutton basic_action_button callEventButton"><i class="toptoolbaricon material-icons">invert_colors</i><?php _e('Quick Style', 'revslider');?></div>
					<div class="div10"></div>
					<div class="show_more_toggle" data-toggle="#more_font_style"><div class="shmt_bar"></div><div class="shmt_textmore"><?php _e('More', 'revslider');?><i class="material-icons">add</i></div><div class="shmt_textless"><?php _e('Less', 'revslider');?><i class="material-icons">remove</i></div></div>
					<div id="more_font_style" style="display:none">
						<div class="div15"></div>
						<row class="directrow __idle__">
							<onelong><label_icon class="ui_fontstyle"></label_icon><input type="checkbox" data-evt="updateFontFamily"  id="layer_fontStyle" class="layerinput easyinit" data-r="idle.fontStyle"/></onelong>
							<oneshort><label_icon class="ui_textdecoration"></label_icon><select id="layer_textdecoration_idle" class="layerinput tos2 nosearchbox easyinit" data-theme="minl120" data-r="idle.textDecoration"><option selected="selected" value="none">None</option><option value="underline"><?php _e('Underline', 'revslider');?></option><option value="overline"><?php _e('Overline', 'revslider');?></option><option value="line-through"><?php _e('Line-through', 'revslider');?></option></select></oneshort>
						</row>
						<row class="directrow __idle__">
							<onelong><label_icon class="ui_uppercase"></label_icon><select id="layer_texttransform" class="layerinput tos2 nosearchbox easyinit" data-theme="min150"  data-r="idle.textTransform"><option selected="selected" value="none">None</option><option value="uppercase"><?php _e('Uppercase', 'revslider');?></option><option value="lowercase"><?php _e('Lowercase', 'revslider');?></option><option value="capitalize"><?php _e('Capitalize', 'revslider');?></option></select></onelong>
							<oneshort><label_icon class="ui_selectable"></label_icon><select id="layer_selectable" class="layerinput tos2 nosearchbox easyinit" data-theme="minl120"  data-r="idle.selectable"><option selected="selected" value="default">Default</option><option value="on"><?php _e('Selectable', 'revslider');?></option><option value="off"><?php _e('Unselectable', 'revslider');?></option></select></oneshort>
						</row>
					</div>
					<div class="div15"></div>
					<div class="__idle__"><label_a><?php _e('Font Family', 'revslider');?></label_a><select id="layer_fontfamily" class="layerinput easyinit searchbox tos2" data-evt="updateFontFamily" data-theme="fontfamily" data-r="idle.fontFamily"></select></div>
					<div class="__idle__"><label_a><?php _e('Text Color', 'revslider');?></label_a><input type="text" data-editing="Layer Text Color" data-mode="single" name="layerTextColor" id="layerTextColor" class="my-color-field layerinput easyinit" data-visible="true" data-responsive="true" data-r="idle.color.#size#.v" value="transparent"></div>
					<div class="_ltsel_color"><label_a><?php _e('Color in Frame', 'revslider');?></label_a><input type="text" data-editing="Layer Text Color in Frame" data-mode="single" name="layerTextColorInFrame" id="layerTextColorInFrame" class="my-color-field layerinput easyinit" data-visible="true" data-r="#frame#.color.color" value="transparent"></div>

				</div>
			</div>

			<!-- LAYER STYLE SVG -->
			<div id="form_layerstyle_svg" class="form_inner open _shfsvg_">
				<div class="form_inner_header"><i class="material-icons">gesture</i><?php _e('SVG', 'revslider');?></div>

				<div class="collapsable">
					<!-- SVG IDLE STYLE-->
					<div class="__idle__">
						<longoption><i class="material-icons">trip_origin</i><label_a><?php _e('Keep Original Colors', 'revslider');?></label_a><input type="checkbox" class="easyinit layerinput" data-showhide=".svglayer_simplecoloring" data-showhidedep="false" data-r="idle.svg.originalColor"></longoption>
						<div class="svglayer_simplecoloring">
							<div class="div15"></div>
							<div><label_a><?php _e('SVG Color', 'revslider');?></label_a><input type="text" data-editing="SVG Color" data-mode="single" name="layerSVGColor" id="layerSVGColor" class="my-color-field layerinput easyinit" data-visible="true" data-r="idle.svg.color.#size#.v" value="transparent"></div>
							<div class="div5"></div>
							<div><label_a><?php _e('Stroke Color', 'revslider');?></label_a><input type="text" data-editing="Stroke Color" data-mode="single" name="layerStrokeColor" id="layerStrokeColor" class="my-color-field layerinput easyinit" data-visible="true" data-r="idle.svg.strokeColor" value="transparent"></div>
							<div class="div15"></div>
							<row class="directrow">
								<onelong><label_icon class="ui_strokewidth"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-allowed="px"  data-numeric="true" data-r="idle.svg.strokeWidth" data-min="-1" data-max="500" type="text"></onelong>
								<oneshort><label_icon class="ui_strokedasharray"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-r="idle.svg.strokeDashArray" type="text"></oneshort>
							</row>
							<row class="directrow">
								<onelong><label_icon class="ui_strokedashoffset"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-allowed="px"  data-numeric="true" data-r="idle.svg.strokeDashOffset" data-min="0" data-max="500" type="text"></onelong>
								<oneshort></oneshort>
							</row>
							<div class="div25"></div>
							<longoption><label_a><?php _e('Style All Elements', 'revslider');?></label_a><input type="checkbox" class="easyinit layerinput" data-evt="SvgSelectAllChanged" data-r="idle.svg.styleAll"></longoption>
						</div>
					</div>
				</div>
			</div>

			<!-- LAYER STYLE BACKGROUND -->
			<div id="form_layerstyle_bg" class="form_inner open _nsfv_">
				<div class="form_inner_header"><i class="material-icons">color_lens</i><?php _e('Background', 'revslider');?></div>
				<div class="collapsable">					
					<div class="__idle__"><label_a><?php _e('BG Color', 'revslider');?></label_a><input type="text" data-editing="Layer BG Color" name="layerBGColor" id="layerBGColor" class="my-color-field layerinput easyinit" data-visible="true" data-r="idle.backgroundColor" value="transparent"></div>
					<div class="_ltsel_bgcolor"><label_a><?php _e('BG in Frame', 'revslider');?></label_a><input type="text" data-editing="Frame BG Color Animation" name="frameBGColorAnimationDouble" id="frameBGColorAnimationDouble" class="my-color-field layerinput easyinit" data-visible="true" data-r="#frame#.bgcolor.backgroundColor" value="transparent"></div>
					<div class="div15"></div>
					<row class="direktrow __idle__ _nsfi_ _nsfv_">						
						<onelong><label_a><?php _e('BG Image', 'revslider');?></label_a><div class="miniprevimage_wrap"><i class="material-icons">filter_hdr</i><div id="layer_bg_image" data-showadvbg="#layer_bg_adv_settings"></div><div data-evt="updatelayerbgimage" data-r="idle.backgroundImage" data-rid="idle.backgroundImageId" data-lib="idle.bgimagelib" data-default="" class="resettodefault basic_action_button callEventButton layerinput onlyicon"><i class="material-icons">close</i></div></div></onelong>
						<oneshort>
							<div data-evt="updatelayerbgimage" data-r="idle.backgroundImage" data-rid="idle.backgroundImageId" data-lib="idle.bgimagelib" data-sty="behavior.imageSourceType" class="getImageFromMediaLibrary basic_action_button callEventButton layerinput"><i class="material-icons">style</i><?php _e('Media', 'revslider');?></div>
							<div data-evt="updatelayerbgimage" data-r="idle.backgroundImage" data-rid="idle.backgroundImageId" data-lib="idle.bgimagelib" data-sty="behavior.imageSourceType" class="getImageFromObjectLibrary basic_action_button callEventButton layerinput"><i class="material-icons">camera_enhance</i><?php _e('Object', 'revslider');?></div>							
						</oneshort>
					</row>


					<!-- USED LIBRARY TYPE-->
					<div style="display:none"><label_a class="singlerow"><?php _e('Used Library', 'revslider');?></label_a><select class="layerinput easyinit" data-r="idle.bgimagelib" data-show="#layerbg_srctype_*val*" data-hide=".layerbg_srctype_all" data-showprio="show"><option value="">Nothing</option><option value="objectlibrary">Objectlibrary</option><option value="medialibrary">MediaLibrary</option></select></div>

					<!-- SIZE / SRC PICKER FOR CURRENT USED LIBRARY TYPE-->
					<div id="layerbg_srctype_objectlibrary" class="layerbg_srctype_all"><label_a class="singlerow"><?php _e('Image Size', 'revslider');?></label_a><select class="layerinput tos2 nosearchbox easyinit" data-evt="getNewImageSize" data-evtparam="bg.object" data-r="behavior.imageSourceType"><option value="100" selected="selected"><?php _e("Original", 'revslider');?></option><option value="75" selected="selected"><?php _e("Large", 'revslider');?></option><option value="50" selected="selected"><?php _e("Medium", 'revslider');?></option><option value="25" selected="selected"><?php _e("Small", 'revslider');?></option><option value="10" selected="selected"><?php _e("Extra Small", 'revslider');?></option></select></div>
					<div id="layerbg_srctype_medialibrary" class="layerbg_srctype_all"><label_a class="singlerow"><?php _e('Source Type', 'revslider');?></label_a><select class="layerinput tos2 nosearchbox easyinit" data-evt="getNewImageSize" data-evtparam="bg.media" data-r="behavior.imageSourceType"><option value="auto" selected="selected"><?php _e("Default Setting", 'revslider');?></option><?php foreach ($img_sizes as $imghandle => $imgSize) { echo '<option value="' . $imghandle . '">' . $imgSize . '</option>';}?></select></div>

					
									




					<div id="layer_bg_adv_settings">
						<div class="div15"></div>
						<select style="display:none !important" id="layer_bgimage_pos" data-unselect=".layer_bg_position_selector" data-select="#layer_bg_position_*val*"  class="layerinput easyinit"  data-r="idle.backgroundPosition"><option value="left center"><?php _e('left center', 'revslider');?></option><option value="left bottom"><?php _e('left bottom', 'revslider');?></option><option value="left top"><?php _e('left top', 'revslider');?></option><option value="center top"><?php _e('center top', 'revslider');?></option><option value="center center"><?php _e('center center', 'revslider');?></option><option value="center bottom"><?php _e('center bottom', 'revslider');?></option>																				<option value="right top"><?php _e('right top', 'revslider');?></option><option value="right center"><?php _e('right center', 'revslider');?></option><option value="right bottom"><?php _e('right bottom', 'revslider');?></option></select>
						<row class="direktrow __idle__">
							<onelong>
								<label_a><?php _e('Position', 'revslider');?></label_a><!--
									--><div class="bg_alignselector_wrap">
										<div class="bg_align_row">
											<div class="triggerselect layer_bg_position_selector bg_alignselector" data-select="#layer_bgimage_pos" data-val="left top" id="layer_bg_position_left-top"></div>
											<div class="triggerselect layer_bg_position_selector bg_alignselector" data-select="#layer_bgimage_pos" data-val="center top" id="layer_bg_position_center-top"></div>
											<div class="triggerselect layer_bg_position_selector bg_alignselector" data-select="#layer_bgimage_pos" data-val="right top" id="layer_bg_position_right-top"></div>
										</div>
										<div class="bg_align_row">
											<div class="triggerselect layer_bg_position_selector bg_alignselector" data-select="#layer_bgimage_pos" data-val="left center" id="layer_bg_position_left-center"></div>
											<div class="triggerselect layer_bg_position_selector bg_alignselector" data-select="#layer_bgimage_pos" data-val="center center" id="layer_bg_position_center-center"></div>
											<div class="triggerselect layer_bg_position_selector bg_alignselector" data-select="#layer_bgimage_pos" data-val="right center" id="layer_bg_position_right-center"></div>
										</div>
										<div class="bg_align_row">
											<div class="triggerselect layer_bg_position_selector bg_alignselector" data-select="#layer_bgimage_pos" data-val="left bottom" id="layer_bg_position_left-bottom"></div>
											<div class="triggerselect layer_bg_position_selector bg_alignselector" data-select="#layer_bgimage_pos" data-val="center bottom" id="layer_bg_position_center-bottom"></div>
											<div class="triggerselect layer_bg_position_selector bg_alignselector" data-select="#layer_bgimage_pos" data-val="right bottom" id="layer_bg_position_right-bottom"></div>
										</div>
									</div>
							</onelong>
							<oneshort>
								<label_icon class="ui_fit"></label_icon><select id="layer_bgimage_fit" data-theme="minl120" class="layerinput tos2 nosearchbox easyinit" data-r="idle.backgroundSize" data-show=".bgIdleSize_*val*" data-hide=".bgIdleSize_perpix"><option value="cover">cover</option><option value="contain">contain</option><option value="auto">auto</option><option value="percentage">%</option><option value="pixel">px</option></select>
								<label_icon class="ui_repeat"></label_icon><select id="layer_bgimage_repeat" data-theme="minl120" class="layerinput tos2 nosearchbox easyinit" data-r="idle.backgroundRepeat" ><option value="no-repeat">no-repeat</option><option value="repeat">repeat</option><option value="repeat-x">repeat-x</option><option value="repeat-y">repeat-y</option></select>
								<div class="bgIdleSize_percentage bgIdleSize_perpix"><label_a>%</label_a><input class="layerinput valueduekeyboard smallinput easyinit" data-allowed=""  data-responsive="false" data-numeric="true" data-r="idle.backgroundSizePerc" data-min="0" data-max="2000" type="text"></div>
								<div class="bgIdleSize_pixel bgIdleSize_perpix"><label_a>PX</label_a><input class="layerinput valueduekeyboard smallinput easyinit" data-allowed=""  data-responsive="false" data-numeric="true" data-r="idle.backgroundSizePix" data-min="0" data-max="2000" type="text"></div>
							</oneshort>
						</row>
					</div>
					<!-- STREAM BASED IMAGE BG -->
					<div class="__idle__ _nsfi_ _nsfv_">						
						<div class="div25"></div>
						<longoption><i class="material-icons">language</i><label_a ><?php _e('Image from Stream if exist', 'revslider');?></label_a><input type="checkbox" class="easyinit layerinput callEvent" data-showhide="#layerbg_srctype_streamlibrary" data-showhidedep="true" data-evt="updatelayerbgimage" data-r="idle.bgFromStream"></longoption>
						<div class="div5"></div>
						<div id="layerbg_srctype_streamlibrary"><label_a class="singlerow"><?php _e('Stream Size', 'revslider');?></label_a><select class="layerinput tos2 nosearchbox easyinit"  data-r="behavior.streamSourceType"><option value="auto" selected="selected"><?php _e("Default Setting", 'revslider');?></option><?php foreach ($img_sizes as $imghandle => $imgSize) { echo '<option value="' . $imghandle . '">' . $imgSize . '</option>';}?></select></div>						
					</div>	
				</div>
			</div>

			<!-- LAYER SPACINGS -->
			<div id="form_layerstyle_space" class="form_inner open _nsfg_">
				<div class="form_inner_header"><i class="material-icons">more_horiz</i><?php _e('Spacings', 'revslider');?></div>
				<div class="collapsable">
					<row class="directrow">
						<oneabsolute><div id="layer_marginlock_iconswitch" class="icon_switcher" data-ref="#layer_margin_lock"><i class="material-icons icon_state_off">lock_open</i><i class="material-icons icon_state_on">lock_outline</i><input class="easyinit layerinput callEvent" id="layer_margin_lock" data-updateviaevt="true" data-evt="lockMargin" data-setclasson="layer_marginlock_iconswitch" data-class="icsw_on" type="checkbox" data-r="idle.marginLock"></div></oneabsolute>
						<onelong><label_icon class="ui_margin_top"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit callEvent" data-updateviaevt="true" data-evt="updateMarginInput" data-evtparam="0" data-allowed="px"  data-responsive="true" data-numeric="true" data-r="idle.margin.#size#.v.0" data-min="-500" data-max="2000" type="text"></onelong>
						<oneshort><label_icon class="ui_margin_right"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit callEvent" data-updateviaevt="true" data-evt="updateMarginInput" data-evtparam="1" data-allowed="px"  data-responsive="true" data-numeric="true" data-r="idle.margin.#size#.v.1" data-min="-500" data-max="2000" type="text"></oneshort>
					</row>
					<row>
						<onelong><label_icon class="ui_margin_bottom"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit callEvent" data-updateviaevt="true" data-evt="updateMarginInput" data-evtparam="2" data-allowed="px"  data-responsive="true" data-numeric="true" data-r="idle.margin.#size#.v.2" data-min="-500" data-max="2000" type="text"></onelong>
						<oneshort><label_icon class="ui_margin_left"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit callEvent" data-updateviaevt="true" data-evt="updateMarginInput" data-evtparam="3" data-allowed="px"  data-responsive="true" data-numeric="true" data-r="idle.margin.#size#.v.3" data-min="-500" data-max="2000" type="text"></oneshort>
					</row>

					<row class="directrow">
						<oneabsolute><div id="layer_paddinglock_iconswitch" class="icon_switcher" data-ref="#layer_padding_lock"><i class="material-icons icon_state_off">lock_open</i><i class="material-icons icon_state_on">lock_outline</i><input class="easyinit layerinput callEvent" id="layer_padding_lock" data-updateviaevt="true" data-evt="lockPadding" data-setclasson="layer_paddinglock_iconswitch" data-class="icsw_on" type="checkbox" data-r="idle.paddingLock"></div></oneabsolute>
						<onelong><label_icon class="ui_padding_top"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit callEvent" id="idle_layer_padding_top" data-updateviaevt="true" data-evt="updatePaddingInput" data-evtparam="0" data-allowed="px"  data-responsive="true" data-numeric="true" data-r="idle.padding.#size#.v.0" data-min="0" data-max="1000" type="text"></onelong>
						<oneshort><label_icon class="ui_padding_right"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit callEvent" data-updateviaevt="true" data-evt="updatePaddingInput" data-evtparam="1" data-allowed="px"  data-numeric="true" data-responsive="true" data-r="idle.padding.#size#.v.1" data-min="0" data-max="1000" type="text"></oneshort>
					</row>
					<row>
						<onelong><label_icon class="ui_padding_bottom"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit callEvent" data-updateviaevt="true" data-evt="updatePaddingInput" data-evtparam="2" data-allowed="px"  data-numeric="true" data-responsive="true" data-r="idle.padding.#size#.v.2" data-min="0" data-max="1000" type="text"></onelong>
						<oneshort><label_icon class="ui_padding_left"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit callEvent" data-updateviaevt="true" data-evt="updatePaddingInput" data-evtparam="3" data-allowed="px"  data-numeric="true" data-responsive="true" data-r="idle.padding.#size#.v.3" data-min="0" data-max="1000" type="text"></oneshort>
					</row>

					<select style="display:none !important" id="layer_content_halign" data-unselect=".layer_content_hor_selector" data-select="#layer_content_halign_*val*" class="layerinput easyinit" data-responsive="true" data-r="idle.textAlign.#size#.v"><option value="left"><?php _e('Left', 'revslider');?></option><option value="center"><?php _e('Center', 'revslider');?></option><option value="right"><?php _e('Right', 'revslider');?></option><option value="inherit"><?php _e('Inherit', 'revslider');?></option></select>
					<select style="display:none !important" id="layer_content_valign" data-unselect=".layer_content_ver_selector" data-select="#layer_content_valign_*val*" class="layerinput easyinit" data-responsive="true" data-r="idle.verticalAlign"><option value="top"><?php _e('Top', 'revslider');?></option><option value="middle"><?php _e('Middle', 'revslider');?></option><option value="bottom"><?php _e('Bottom', 'revslider');?></option></select>



				</div>
			</div>


			<!-- LAYER BORDER -->
			<div id="form_layerstyle_border" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">rounded_corner</i><?php _e('Border', 'revslider');?></div>
				<div class="collapsable">
					<div class="__idle__">
						<label_a><?php _e('Border Color', 'revslider');?></label_a><input type="text" data-mode="single" data-editing="Layer Border Color" name="layerBorderColor" id="layerBorderColor" class="my-color-field layerinput easyinit" data-visible="true" data-r="idle.borderColor" value="transparent"><div class="linebreak"></div>
						<div class="div5"></div>
						<label_a><?php _e('Border Style', 'revslider');?></label_a><select id="layer_border_style" class="layerinput tos2 nosearchbox easyinit" data-responsive="true" data-r="idle.borderStyle.#size#.v" data-show=".border_style_advanced" data-hide="#border_style_*val*" data-showprio="hide"><option value="none"><?php _e('None', 'revslider');?></option><option value="solid"><?php _e('Solid', 'revslider');?></option><option value="dashed"><?php _e('Dashed', 'revslider');?></option><option value="dotted"><?php _e('Dotted', 'revslider');?></option><option value="double"><?php _e('Double', 'revslider');?></option></select>
						<div class="div10"></div>
						<div id="border_style_none" class="border_style_advanced">
							<row class="directrow">
								<oneabsolute><div id="layer_borderlock_iconswitch" class="icon_switcher" data-ref="#layer_border_lock"><i class="material-icons icon_state_off">lock_open</i><i class="material-icons icon_state_on">lock_outline</i><input class="easyinit layerinput callEvent" id="layer_border_lock" data-updateviaevt="true" data-evt="lockBorder" data-setclasson="layer_borderlock_iconswitch" data-class="icsw_on" type="checkbox" data-r="idle.borderWidthLock"></div></oneabsolute>
								<onelong><label_icon class="ui_border_top"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit callEvent" data-updateviaevt="true" data-evt="updateBorderInput" data-evtparam="0" data-allowed="px"  data-numeric="true" data-r="idle.borderWidth.0" data-min="-500" data-max="500" type="text"></onelong>
								<oneshort><label_icon class="ui_border_right"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit callEvent" data-updateviaevt="true" data-evt="updateBorderInput" data-evtparam="1" data-allowed="px"  data-numeric="true" data-r="idle.borderWidth.1" data-min="-500" data-max="500" type="text"></oneshort>
							</row>
							<row>
								<onelong><label_icon class="ui_border_bottom"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit callEvent" data-updateviaevt="true" data-evt="updateBorderInput" data-evtparam="2" data-allowed="px"  data-numeric="true" data-r="idle.borderWidth.2" data-min="-500" data-max="500" type="text"></onelong>
								<oneshort><label_icon class="ui_border_left"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit callEvent" data-updateviaevt="true" data-evt="updateBorderInput" data-evtparam="3" data-allowed="px"  data-numeric="true" data-r="idle.borderWidth.3" data-min="-500" data-max="500" type="text"></oneshort>
							</row>
						</div>

						<row class="directrow">
							<oneabsolute><div id="layer_borderRadiuslock_iconswitch" class="icon_switcher" data-ref="#layer_borderRadius_lock"><i class="material-icons icon_state_off">lock_open</i><i class="material-icons icon_state_on">lock_outline</i><input class="easyinit layerinput callEvent" id="layer_borderRadius_lock" data-updateviaevt="true" data-evt="lockBorderRadius" data-setclasson="layer_borderRadiuslock_iconswitch" data-class="icsw_on" type="checkbox" data-r="idle.borderRadiusLock"></div></oneabsolute>
							<onelong><label_icon class="ui_bradius_topleft"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit callEvent" data-updateviaevt="true" data-evt="updateBorderRadiusInput" data-evtparam="0" data-allowed="px,%"  data-numeric="true" data-r="idle.borderRadius.v.0" data-min="-500" data-max="500" type="text"></onelong>
							<oneshort><label_icon class="ui_bradius_topright"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit callEvent" data-updateviaevt="true" data-evt="updateBorderRadiusInput" data-evtparam="1" data-allowed="px,%"  data-numeric="true" data-r="idle.borderRadius.v.1" data-min="-500" data-max="500" type="text"></oneshort>
						</row>
						<row>
							<onelong><label_icon class="ui_bradius_bottomleft"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit callEvent" data-updateviaevt="true" data-evt="updateBorderRadiusInput" data-evtparam="3" data-allowed="px,%"  data-numeric="true" data-r="idle.borderRadius.v.3" data-min="-500" data-max="500" type="text"></onelong>
							<oneshort><label_icon class="ui_bradius_bottomright"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit callEvent" data-updateviaevt="true" data-evt="updateBorderRadiusInput" data-evtparam="2" data-allowed="px,%"  data-numeric="true" data-r="idle.borderRadius.v.2" data-min="-500" data-max="500" type="text"></oneshort>
						</row>
					</div>
				</div>
			</div>



		</div>
	</div><!-- END OF STYLE CONTAINER -->

	<!-- LAYER SPACING CONTAINER -->
	<div class="form_collector layer_settings_collector" data-type="layersconfig" data-pcontainer="#layer_settings" data-offset="#rev_builder_wrapper">
		<div id="form_layer_advstyle"  class="formcontainer form_menu_inside collapsed" data-select="#gst_layer_6" data-unselect=".layer_submodule_trigger">			
			<!-- BASIC TRANSFORMS -->
			<div id="form_basic_transforms" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">rotate_90_degrees_ccw</i><?php _e('Basic Transforms', 'revslider');?></div>
				<div class="collapsable">
					<row class="direktrow">
						<onelong><label_icon class="ui_rotatex"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="deg" data-r="idle.rotationX" data-min="-3600" data-max="3600" type="text"></onelong>
						<oneshort><label_icon class="ui_rotatey"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="deg" data-r="idle.rotationY" data-min="-3600" data-max="3600" type="text"></oneshort>
					</row>
					<row class="direktrow">
						<onelong><label_icon class="ui_rotatez"></label_icon><input  class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="deg" data-r="idle.rotationZ" data-min="-3600" data-max="3600" type="text"></onelong>
						<oneshort><label_icon class="ui_opacity"></label_icon><input  class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="" data-r="idle.opacity" data-min="0" data-max="1" data-steps="0.05" type="text"></oneshort>
					</row>
					<label_a><?php _e('iOS Fix by', 'revslider');?></label_a><select  class="layerinput tos2 nosearchbox easyinit" data-r="idle.filtersIOSFix">
						<option value="d"><?php _e('Default', 'revslider');?></option>									
						<option value="z"><?php _e('z', 'revslider');?></option>
						<option value="x"><?php _e('x', 'revslider');?></option>
						<option value="r"><?php _e('Rotation', 'revslider');?></option>							
					</select>
					
				</div>
			</div><!-- END OF BOX SHADOW SETTING -->

			<!-- BOX SHADOW SETTINGS-->
			<div id="form_box_shadow" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">filter_none</i><?php _e('Box Shadow', 'revslider');?></div>
				<div class="collapsable">
					<row class="direktrow">
						<onelong><label_a><?php _e('Effect', 'revslider');?></label_a><input class="layerinput smallinput easyinit" type="checkbox" data-r="idle.boxShadow.inuse"/></onelong>
						<oneshort></oneshort>
					</row>
					<div style="display:none">
						<label_a><?php _e('Shadow on', 'revslider');?></label_a>
						<div class="radiooption">
							<div><input name="boxshadowon" class="layerinput easyinit" data-r="idle.boxShadow.container" type="radio" value="wrapper"><label_sub><?php _e('Wrapper Container', 'revslider');?></label_sub></div>
							<div><input name="boxshadowon" class="layerinput easyinit" data-r="idle.boxShadow.container" type="radio" value="content"><label_sub><?php _e('Layer Container', 'revslider');?></label_sub></div>
						</div>
					</div>
					<div class="div10"></div>

					<row class="direktrow">
						<onelong><label_icon class="ui_x"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px" data-min="-500" data-max="500" data-responsive="true" data-r="idle.boxShadow.hoffset.#size#.v" type="text"></onelong>
						<oneshort><label_icon class="ui_y"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px" data-min="-500" data-max="500" data-responsive="true" data-r="idle.boxShadow.voffset.#size#.v" type="text"></oneshort>
					</row>
					<row class="direktrow">
						<onelong><label_icon class="ui_blur"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px" data-min="0" data-max="500" data-responsive="true" data-r="idle.boxShadow.blur.#size#.v" type="text"></onelong>
						<oneshort><label_icon class="ui_gap"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px" data-min="0" data-max="500" data-responsive="true" data-r="idle.boxShadow.spread.#size#.v" type="text"></oneshort>
					</row>
					<label_a><?php _e('Shadow Color', 'revslider');?></label_a><input type="text" data-mode="single" data-editing="Box Shadow Color" name="boxShadowColor" id="boxShadowColor" class="my-color-field layerinput easyinit" data-visible="true" data-r="idle.boxShadow.color" value="transparent"><div class="linebreak"></div>
				</div>
			</div><!-- END OF BOX SHADOW SETTING -->

			<!-- TEXT SHADOW SETTINGS-->
			<div id="form_text_shadow" class="form_inner open _shft_ _shfb_">
				<div class="form_inner_header"><i class="material-icons">format_size</i><?php _e('Text Shadow', 'revslider');?></div>
				<div class="collapsable">
					<row class="direktrow">
						<onelong><label_a><?php _e('Effect', 'revslider');?></label_a><input class="layerinput smallinput easyinit" type="checkbox" data-r="idle.textShadow.inuse"/></onelong>
						<oneshort></oneshort>
					</row>
					<row class="direktrow">
						<onelong><label_icon class="ui_x"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px" data-min="0" data-max="500" data-responsive="true" data-r="idle.textShadow.hoffset.#size#.v" type="text"></onelong>
						<oneshort><label_icon class="ui_y"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px" data-min="0" data-max="500" data-responsive="true" data-r="idle.textShadow.voffset.#size#.v" type="text"></oneshort>
					</row>
					<row class="direktrow">
						<onelong><label_icon class="ui_blur"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px" data-min="0" data-max="500" data-responsive="true" data-r="idle.textShadow.blur.#size#.v" type="text"></onelong>
						<oneshort></oneshort>
					</row>
					<label_a><?php _e('Shadow Color', 'revslider');?></label_a><input type="text" data-mode="single" data-editing="Text Shadow Color" name="textShadowColor" id="textShadowColor" class="my-color-field layerinput easyinit" data-visible="true" data-r="idle.textShadow.color" value="transparent"><div class="linebreak"></div>
				</div>
			</div><!-- END OF TEXT SHADOW SETTING -->

			<!-- TEXT STROKE SETTINGS-->
			<div id="form_text_stoke" class="form_inner open _shft_ _shfb_">
				<div class="form_inner_header"><i class="material-icons">format_size</i><?php _e('Text Stroke', 'revslider');?></div>
				<div class="collapsable">
					<row class="direktrow">
						<onelong><label_a><?php _e('Effect', 'revslider');?></label_a><input class="layerinput smallinput easyinit" type="checkbox" data-r="idle.textStroke.inuse"/></onelong>
						<oneshort></oneshort>
					</row>
					<row class="direktrow">
						<onelong><label_icon class="ui_border_right"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px" data-min="0" data-max="500" data-responsive="true" data-r="idle.textStroke.width.#size#.v" type="text"></onelong>
						<oneshort></oneshort>
					</row>					
					<label_a><?php _e('Stroke Color', 'revslider');?></label_a><input type="text" data-mode="single" data-editing="Text Shadow Color" name="textStrokeColor" id="textStrokeColor" class="my-color-field layerinput easyinit" data-visible="true" data-r="idle.textStroke.color" value="transparent"><div class="linebreak"></div>
				</div>
			</div><!-- END OF TEXT SHADOW SETTING -->

			<!-- LAYER FILTERS-->
			<div id="form_layerstyle_css" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">blur_linear</i><?php _e('Blend Mode', 'revslider');?></div>
				<div class="collapsable">
					<label_icon class="ui_blendmode singlerow"></label_icon><select class="layerinput tos2 nosearchbox easyinit"  data-r="idle.filter.blendMode"><option value="normal" selected="selected">normal</option><option value="multiply">multiply</option><option value="screen">screen</option><option value="overlay">overlay</option><option value="darken">darken</option><option value="lighten">lighten</option><option value="color-dodge">color-dodge</option><option value="color-burn">color-burn</option><option value="hard-light">hard-light</option><option value="soft-light">soft-light</option><option value="difference">difference</option><option value="exclusion">exclusion</option><option value="hue">hue</option><option value="saturation">saturation</option><option value="color">color</option><option value="luminosity">luminosity</option></select>
					<row class="direktrow">
						<labelhalf><i class="material-icons vmi">sms_failed</i></labelhalf>
						<contenthalf><div class="function_info"><?php _e('Can not be rendered in Editor. Please preview in Frontend.', 'revslider');?></div></contenthalf>
					</row>
					<!--<row class="direktrow">-->
						<!--<onelong><label_a><?php _e('Show in Editor', 'revslider');?></label_a><input class="layerinput smallinput easyinit" type="checkbox" data-r="idle.filter.showInEditor"/></onelong>-->
						<!--<oneshort></oneshort>-->
					<!--</row>-->
				</div>
			</div><!-- END OF LAYER FILTERS -->

			<!-- LAYER SPIKES -->
			<div id="form_layer_spiketyle" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">rounded_corner</i><?php _e('Spike Masks', 'revslider');?></div>
				<div class="collapsable">
					<div class="__idle__">	
						<label_a><?php _e('Enable Spikes', 'revslider');?></label_a><input class="easyinit layerinput" id="layer_userSpikes" data-showhide="#layerspikeoptions" data-showhidedep="true" type="checkbox" data-r="idle.spikeUse">	
						<div id="layerspikeoptions">				
							<label_a><?php _e('Left Spike', 'revslider');?></label_a><select id="layer_leftspiketype" class="layerinput tos2 nosearchbox easyinit"  data-r="idle.spikeLeft"><option value="none"><?php _e('No Spikes', 'revslider');?></option><option value="top"><?php _e('1 Spike Top', 'revslider');?></option><option value="middle"><?php _e('1 Spike Middle', 'revslider');?></option><option value="bottom"><?php _e('1 Spike Bottom', 'revslider');?></option><option value="two"><?php _e('Two Spikes', 'revslider');?></option><option value="three"><?php _e('Three Spikes', 'revslider');?></option><option value="four"><?php _e('Four Spikes', 'revslider');?></option><option value="five"><?php _e('Five Spikes', 'revslider');?></option></select>
							<label_a><?php _e('Spike Width', 'revslider');?></label_a><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="%" data-r="idle.spikeLeftWidth" type="text">
							<label_a><?php _e('Right Spike', 'revslider');?></label_a><select id="layer_rightspiketype" class="layerinput tos2 nosearchbox easyinit"  data-r="idle.spikeRight"><option value="none"><?php _e('No Spikes', 'revslider');?></option><option value="top"><?php _e('1 Spike Top', 'revslider');?></option><option value="middle"><?php _e('1 Spike Middle', 'revslider');?></option><option value="bottom"><?php _e('1 Spike Bottom', 'revslider');?></option><option value="two"><?php _e('Two Spikes', 'revslider');?></option><option value="three"><?php _e('Three Spikes', 'revslider');?></option><option value="four"><?php _e('Four Spikes', 'revslider');?></option><option value="five"><?php _e('Five Spikes', 'revslider');?></option></select>
							<label_a><?php _e('Spike Width', 'revslider');?></label_a><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="%" data-r="idle.spikeRightWidth" type="text">
						</div>
					</div>
				</div>
			</div>
			<!-- LAYER SPIKES -->
			<div id="form_layer_cornertyle" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">rounded_corner</i><?php _e('Sharp Corner Extensions', 'revslider');?></div>
				<div class="collapsable">
					<div class="__idle__">							
						<label_a><?php _e('Left Corner', 'revslider');?></label_a><select id="layer_leftcornertype" class="layerinput tos2 nosearchbox easyinit"  data-r="idle.cornerLeft"><option value="none"><?php _e('No Corner', 'revslider');?></option><option value="rs-fcr"><?php _e('Normal', 'revslider');?></option><option value="rs-fcrt"><?php _e('Reverse', 'revslider');?></option></select>
						<label_a><?php _e('Right Corner', 'revslider');?></label_a><select id="layer_rightcornertype" class="layerinput tos2 nosearchbox easyinit"  data-r="idle.cornerRight"><option value="none"><?php _e('No Corner', 'revslider');?></option><option value="rs-bcr"><?php _e('Normal', 'revslider');?></option><option value="rs-bcrt"><?php _e('Reverse', 'revslider');?></option></select>						
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- LAYER PARALLAX CONTAINER -->
	<div class="form_collector layer_settings_collector" data-type="layersconfig" data-pcontainer="#layer_settings" data-offset="#rev_builder_wrapper">
		<div id="form_layer_parallax"  class="formcontainer form_menu_inside collapsed" data-select="#gst_layer_8" data-unselect=".layer_submodule_trigger">
			<!--<div class="collectortabwrap"><div id="collectortab_form_layer_parallax" class="collectortab form_menu_inside" data-forms='["#form_layer_parallax"]'><i class="material-icons">system_update_alt</i><?php _e('On Scroll', 'revslider');?></div></div>						-->
			<!-- LAYER CONTENT PARALLAX -->
			<!-- GENERAL INFO IF NOTHING SET -->
			<div style="display:none">
				<div id="no_onscroll_on_layers">
					<div class="form_inner open">
						<div class="form_inner_header"><i class="material-icons">filter_9_plus</i><?php _e('On Scroll Details', 'revslider');?></div>
						<div class="collapsable">
							<row class="direktrow">
								<labelhalf><i class="material-icons vmi">sms_failed</i></labelhalf>
								<contenthalf><div id="kenburnissue_info" class="function_info"><?php _e('On Scroll can be Added per Slider in the General Options', 'revslider');?></div></contenthalf>
							</row>
						</div>
					</div>
				</div>
			</div>
			<!--<div class="layer_parallax_settings">-->
				<div id="form_layercontent_pddd" class="form_inner open">
					<div class="form_inner_header"><i class="material-icons">system_update_alt</i><?php _e('Parallax & 3D', 'revslider');?></div>
					<div class="collapsable">						
						<label_a><?php _e('Level', 'revslider');?></label_a><select data-theme="dark" data-change="parallax_3d_on_bg" data-changeto='false' data-evt="enablePXModule" data-changewhennot="-" id="layer_parallax_level" class="layerinput tos2 nosearchbox easyinit prallaxlevelselect"  data-r="effects.parallax">
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
						<label_a><?php _e('Under Mask', 'revslider');?></label_a><input  class="easyinit layerinput"  id="parallax_undermask" type="checkbox" data-r="effects.pxmask">
						
						<div class="slider_ddd_subsettings">
							<label_a><?php _e('Attach to BG', 'revslider');?></label_a><input data-change="layer_parallax_level" data-changeto='-' data-changewhen="true" class="easyinit layerinput"  id="parallax_3d_on_bg" type="checkbox" data-r="effects.attachToBg">
						</div>
						
					</div>
				</div>
			<!--</div>-->
			<!--<div class="all_sbt_dependencies">-->
				<div id="form_layertimeline_scrollbased" class="form_inner open">
					<div class="form_inner_header"><i class="material-icons">system_update_alt</i><?php _e('Timeline Scroll Based', 'revslider');?></div>
					<div class="collapsable">					
						<label_a><?php _e('Handling', 'revslider');?></label_a><select data-theme="dark" id="layer_timlinescroll_level" data-evt="enableScrollModule" class="layerinput tos2 nosearchbox easyinit"  data-r="timeline.scrollBased">
								<option value="default"><?php _e('Default (Global Settings)', 'revslider');?></option>
								<option value="true"><?php _e('Enabled - Scroll Based', 'revslider');?></option>
								<option value="false"><?php _e('Disabled - Time Based', 'revslider');?></option>
							</select>
						<label_a><?php _e('Start Earlier', 'revslider');?></label_a><input class="layerinput easyinit"  data-r="timeline.scrollBasedOffset" data-numeric="true" data-allowed="ms" data-min="0" data-max="2000" type="text">
					</div>
				</div>
			<!--</div>-->
			<!--<div class="all_sbe_dependencies">-->
				<div id="form_layerfilter_scrollbased" class="form_inner open">
					<div class="form_inner_header"><i class="material-icons">system_update_alt</i><?php _e('Filter Effect Scroll Based', 'revslider');?></div>
					<div class="collapsable">					
						<label_a><?php _e('Handling', 'revslider');?></label_a><select data-theme="dark" id="layer_effectscroll_level" data-evt="enableScrollEffectModule" class="layerinput tos2 nosearchbox easyinit"  data-r="effects.effect">
								<option value="default"><?php _e('Default (Global Settings)', 'revslider');?></option>
								<option value="true"><?php _e('Enabled - Scroll Based', 'revslider');?></option>
								<option value="false"><?php _e('Disabled', 'revslider');?></option>
							</select>
					</div>
				</div>
			<!--</div>-->
		</div>
	</div>

	<!-- LAYER ATTRIBUTES CONTAINER -->
	<div class="form_collector layer_settings_collector" data-type="layersconfig" data-pcontainer="#layer_settings" data-offset="#rev_builder_wrapper">
		<div id="form_layer_attributes"  class="formcontainer form_menu_inside collapsed" data-select="#gst_layer_11" data-unselect=".layer_submodule_trigger">
			<!--<div class="collectortabwrap"><div id="collectortab_form_layer_attributes" class="collectortab form_menu_inside" data-forms='["#form_layer_attributes"]'><i class="material-icons">description</i><?php _e('Attributes', 'revslider');?></div></div>		-->
			<!-- LAYER CONTENT ATTRIBUTES -->
			<div class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">description</i><?php _e('Attributes', 'revslider');?></div>
				<div class="collapsable">
					 <label_a><?php _e('Layer ID', 'revslider');?></label_a><input class="layerinput easyinit " id="layer_id"  data-r="attributes.id" type="text">
					 <label_a><?php _e('Classes', 'revslider');?></label_a><input class="layerinput easyinit " id="layer_classes"  data-r="attributes.classes" type="text">
					 <label_a><?php _e('Title', 'revslider');?></label_a><input class="layerinput easyinit " id="layer_title"  data-r="attributes.title" type="text">
					 <label_a><?php _e('Rel', 'revslider');?></label_a><input class="layerinput easyinit " id="layer_rel"  data-r="attributes.rel" type="text">
					 <label_a><?php _e('TabIndex', 'revslider');?></label_a><input data-numeric="true" data-allowed="" class="layerinput valueduekeyboard easyinit " id="layer_tbindex"  data-r="attributes.tabIndex" type="text">
					 <div class="div15"></div>
					 <label_a><?php _e('Wrapper ID', 'revslider');?></label_a><input class="layerinput easyinit " id="layer_wrapper_id"  data-r="attributes.wrapperId" type="text">
					 <label_a><?php _e('Classes', 'revslider');?></label_a><input class="layerinput easyinit " id="layer_wrapper_classes"  data-r="attributes.wrapperClasses" type="text">
				</div>				
			</div>
		</div>			
	</div>

	<!-- LAYER ATTRIBUTES CONTAINER -->
	<div class="form_collector layer_settings_collector" data-type="layersconfig" data-pcontainer="#layer_settings" data-offset="#rev_builder_wrapper">
		<div id="form_layer_customcss"  class="formcontainer form_menu_inside collapsed" data-select="#gst_layer_7" data-unselect=".layer_submodule_trigger">
			<!-- LAYER CUSTOM SETTINGS -->
			<div class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">code</i><?php _e('Custom Inline & Hover CSS', 'revslider');?></div>
				<div class="collapsable">

					<div class="css_opening_closing_bracket"><?php _e('CustomCSS', 'revslider');?> {</div>
					<div id="custom_css_layer_area"></div>
					<div class="css_opening_closing_bracket">}</div>
					<div class="div25"></div>
					<div class="css_opening_closing_bracket"><?php _e('CustomCSS', 'revslider');?><span style="color:#006dd2">:hover</span> {</div>
					<div id="custom_css_hover_layer_area"></div>
					<div class="css_opening_closing_bracket">}</div>
					<div class="div10"></div>
					<row class="direktrow">
						<labelhalf><i class="material-icons vmi">sms_failed</i></labelhalf>
						<contenthalf><div class="function_info"><?php _e('Depricated Function !<br>Only visible by Rendering. Limited influence on Styled Layers. Custom CSS Inline will be removed in Version 6.2', 'revslider');?></div></contenthalf>
					</row>
				</div>
			</div>

		</div>
	</div>

	<!-- LAYER HOVER CONTAINER -->
	<div class="form_collector layer_settings_collector" data-type="layersconfig" data-pcontainer="#layer_settings" data-offset="#rev_builder_wrapper">
		<div id="form_layer_hover"  class="formcontainer form_menu_inside collapsed" data-select="#gst_layer_9" data-unselect=".layer_submodule_trigger">
			<!--<div class="collectortabwrap"><div id="collectortab_form_layer_hover" class="collectortab form_menu_inside" data-forms='["#form_layer_hover"]'><i class="material-icons">mouse</i><?php _e('Hover', 'revslider');?></div></div>		-->

			<!-- LAYER HOVER DEFAULTS -->
			<div class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">mouse</i><?php _e('Hover', 'revslider');?></div>
				<div class="collapsable">
					<label_a><?php _e('Cursor', 'revslider');?></label_a><select class="layerinput tos2 nosearchbox easyinit" id="layer_css_cursor" data-r="idle.cursor"><option value="auto" selected="selected">Auto</option><option value="default">Default</option><option value="crosshair">Crosshair</option><option value="pointer">Pointer</option><option value="move">Move</option><option value="text">Text</option><option value="wait">Wait</option><option value="help">Help</option><option value="zoom-in">Zoom-in</option><option value="zoom-out">Zoom-out</option><option value="none">None</option></select><span class="linebreak"></span>
					<label_a><?php _e('Pointer Event', 'revslider');?></label_a><select class="layerinput tos2 nosearchbox easyinit" id="layer_css_pointerevent" data-r="hover.pointerEvents"><option value="auto" selected="selected">Auto</option><option value="none">None</option></select>
					<label_a><?php _e('Animation', 'revslider');?></label_a><select class="layerinput tos2 nosearchbox easyinit" id="layer_use_hover" data-r="hover.usehover" data-show=".copyhoversettings*val*" data-hide=".copyhoversettings" data-showprio="show" id="layer_usehover" class="layerinput easyinit" data-evt="copyhoversettings" data-evtparam="checkiffirst" data-r="hover.usehover"><option value="true"><?php _e('Enabled', 'revslider');?></option><option value="desktop"><?php _e('Only on Desktop', 'revslider');?></option><option value="false"><?php _e('Disabled', 'revslider');?></option></select></onelong>					
				</div>
			</div>
			<div class="copyhoversettings copyhoversettingstrue copyhoversettingsdesktop">
				<!-- LAYER HOVER TRANSFORM -->
				<div class="form_inner open">
					<div class="form_inner_header"><i class="material-icons">mouse</i><?php _e('Animation', 'revslider');?></div>
					<div class="collapsable">
						<row class="directrow">
							<onelong><label_icon class="ui_duration"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="ms" data-r="hover.speed" type="text"></onelong>
							<oneshort></oneshort>
						</row>
						<label_icon class="ui_easing_in singlerow"></label_icon><select id="layer_hover_appear_ease" class="layerinput tos2 nosearchbox easyinit easingSelect" data-r="hover.ease"></select>
						<label_a><?php _e('zIndex', 'revslider');?></label_a><input class="layerinput valueduekeyboard smallinput easyinit input_with_presets" id="layer_hover_zindex" data-numeric="true" data-allowed="auto" data-presets_text="Auto!1!100!500!1000" data-presets_val="auto!1!100!500!1000" data-r="hover.zIndex" data-history="auto" type="text">
						<label_icon class="ui_opacity singlerow"></label_icon><input  class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="" data-r="hover.opacity" data-min="0" data-max="1" data-steps="0.05" type="text">
						<row class="direktrow">
							<onelong><label_icon class="ui_scalex"></label_icon><input  class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="" data-r="hover.scaleX" data-min="0" data-max="500" type="text"></onelong>
							<oneshort><label_icon class="ui_scaley"></label_icon><input  class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="" data-r="hover.scaleY" data-min="0" data-max="500" type="text"></oneshort>
						</row>
						<row class="direktrow">
							<onelong><label_icon class="ui_skewx"></label_icon><input  class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="" data-r="hover.skewX" data-min="-500" data-max="500" type="text"></onelong>
							<oneshort><label_icon class="ui_skewy"></label_icon><input  class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="" data-r="hover.skewY" data-min="-500" data-max="500" type="text"></oneshort>
						</row>

						<row class="direktrow">
							<onelong><label_icon class="ui_rotatex"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="deg" data-r="hover.rotationX" data-min="-3600" data-max="3600" type="text"></onelong>
							<oneshort><label_icon class="ui_rotatey"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="deg" data-r="hover.rotationY" data-min="-3600" data-max="3600" type="text"></oneshort>
						</row>
						<row class="direktrow">
							<onelong><label_icon class="ui_rotatez"></label_icon><input  class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="deg" data-r="hover.rotationZ" data-min="-3600" data-max="3600" type="text"></onelong>
							<oneshort></oneshort>
						</row>

						<row class="direktrow">
							<onelong><label_icon class="ui_origox"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px,%" data-r="hover.originX" data-min="-3600" data-max="3600" type="text"></onelong>
							<oneshort><label_icon class="ui_origoy"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px,%" data-r="hover.originY" data-min="-3600" data-max="3600" type="text"></oneshort>
						</row>
						<row class="direktrow">
							<onelong><label_icon class="ui_origoz"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px,%" data-r="hover.originZ" data-min="-3600" data-max="3600" type="text"></onelong>
							<oneshort><div class="global_perspective_settings global_perspecitve_local_settings"><label_icon class="ui_perspective"></label_icon><input id="le_frame_hover_perspective" class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px" data-r="hover.transformPerspective" type="text"></div></oneshort>
						</row>
						<label_a><?php _e('Mask', 'revslider');?></label_a><input type="checkbox" id="layer_usehovermask" class="layerinput easyinit" data-r="hover.usehovermask"/>
					</div>
				</div>

				<!-- LAYER HOVER STYLE TEXT -->
				<div class="form_inner open">
					<div class="form_inner_header"><i class="material-icons">title</i><?php _e('Style', 'revslider');?></div>
					<div class="collapsable">
						<div class="_shft_ _shfb_ _shoft_ _shofb_">
							<!-- TEXT HOVER STYLE -->
							<label_a><?php _e('Text Color', 'revslider');?></label_a><input type="text" data-editing="Layer Hover Text Color" data-mode="single" name="layerTextColorHover" id="layerTextColorHover" class="my-color-field layerinput easyinit" data-visible="true" data-r="hover.color" value="transparent">
							<div class="div5"></div>
							<row class="directrow">
								<onelong><label_icon class="ui_textdecoration"></label_icon><select id="layer_textdecoration_hover" class="layerinput tos2 nosearchbox easyinit" data-r="hover.textDecoration"><option selected="selected" value="none">None</option><option value="underline"><?php _e('Underline', 'revslider');?></option><option value="overline"><?php _e('Overline', 'revslider');?></option><option value="line-through"><?php _e('Line-through', 'revslider');?></option></select></onelong>
								<oneshort></oneshort>
							</row>
						</div>
										
						<label_a><?php _e('BG Color', 'revslider');?></label_a><input type="text" data-editing="Layer BG Color on Hover" name="layerBGColor" id="layerBGColorHover" class="my-color-field layerinput easyinit" data-visible="true" data-r="hover.backgroundColor" value="transparent">
						<div class="div5"></div>
						<label_a><?php _e('Gradient Anim', 'revslider');?></label_a><select id="hover_layer_gradient_style" class="layerinput tos2 nosearchbox easyinit" data-r="hover.gradientStyle"><option value="fading"><?php _e('Fade', 'revslider');?></option><option value="sliding"><?php _e('Slide', 'revslider');?></option></select>
						<div class="div10"></div>
						<label_a><?php _e('Border Color', 'revslider');?></label_a><input type="text" data-mode="single" data-editing="Layer Border Color" name="layerBorderColor" id="layerBorderColorHover" class="my-color-field layerinput easyinit" data-visible="true" data-r="hover.borderColor" value="transparent"><div class="linebreak"></div>
						<div class="div5"></div>
						<label_a><?php _e('Border Style', 'revslider');?></label_a><select id="hover_layer_border_style" class="layerinput tos2 nosearchbox easyinit" data-r="hover.borderStyle" data-show=".border_style_advanced_hover" data-hide="#border_style_*val*_hover" data-showprio="hide" ><option value="none"><?php _e('None', 'revslider');?></option><option value="solid"><?php _e('Solid', 'revslider');?></option><option value="dashed"><?php _e('Dashed', 'revslider');?></option><option value="dotted"><?php _e('Dotted', 'revslider');?></option><option value="double"><?php _e('Double', 'revslider');?></option></select>
						<div class="div10"></div>
						<div id="border_style_none_hover" class="border_style_advanced_hover" >
							<row class="directrow">
								<oneabsolute><div id="hover_layer_borderlock_iconswitch" class="icon_switcher" data-ref="#hover_layer_border_lock"><i class="material-icons icon_state_off">lock_open</i><i class="material-icons icon_state_on">lock_outline</i><input class="easyinit layerinput callEvent" id="hover_layer_border_lock" data-updateviaevt="true" data-evt="lockBorderHover" data-setclasson="hover_layer_borderlock_iconswitch" data-class="icsw_on" type="checkbox" data-r="hover.borderWidthLock"></div></oneabsolute>
								<onelong><label_icon class="ui_border_top"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit callEvent" data-updateviaevt="true" data-evt="updateBorderInputHover" data-evtparam="0" data-allowed="px"  data-numeric="true" data-r="hover.borderWidth.0" data-min="-500" data-max="500" type="text"></onelong>
								<oneshort><label_icon class="ui_border_right"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit callEvent" data-updateviaevt="true" data-evt="updateBorderInputHover" data-evtparam="1" data-allowed="px"  data-numeric="true" data-r="hover.borderWidth.1" data-min="-500" data-max="500" type="text"></oneshort>
							</row>
							<row>
								<onelong><label_icon class="ui_border_bottom"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit callEvent" data-updateviaevt="true" data-evt="updateBorderInputHover" data-evtparam="2" data-allowed="px"  data-numeric="true" data-r="hover.borderWidth.2" data-min="-500" data-max="500" type="text"></onelong>
								<oneshort><label_icon class="ui_border_left"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit callEvent" data-updateviaevt="true" data-evt="updateBorderInputHover" data-evtparam="3" data-allowed="px"  data-numeric="true" data-r="hover.borderWidth.3" data-min="-500" data-max="500" type="text"></oneshort>
							</row>
						</div>
						<row class="directrow">
							<oneabsolute><div id="hover_layer_borderRadiuslock_iconswitch" class="icon_switcher" data-ref="#hover_layer_borderRadius_lock"><i class="material-icons icon_state_off">lock_open</i><i class="material-icons icon_state_on">lock_outline</i><input class="easyinit layerinput callEvent" id="hover_layer_borderRadius_lock" data-updateviaevt="true" data-evt="lockBorderRadiusHover" data-setclasson="hover_layer_borderRadiuslock_iconswitch" data-class="icsw_on" type="checkbox" data-r="hover.borderRadiusLock"></div></oneabsolute>
							<onelong><label_icon class="ui_bradius_topleft"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit callEvent" data-updateviaevt="true" data-evt="updateBorderRadiusInputHover" data-evtparam="0" data-allowed="px,%"  data-numeric="true" data-r="hover.borderRadius.v.0" data-min="-500" data-max="500" type="text"></onelong>
							<oneshort><label_icon class="ui_bradius_topright"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit callEvent" data-updateviaevt="true" data-evt="updateBorderRadiusInputHover" data-evtparam="1" data-allowed="px,%"  data-numeric="true" data-r="hover.borderRadius.v.1" data-min="-500" data-max="500" type="text"></oneshort>
						</row>
						<row class="directrow">
							<onelong><label_icon class="ui_bradius_bottomleft"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit callEvent" data-updateviaevt="true" data-evt="updateBorderRadiusInputHover" data-evtparam="3" data-allowed="px,%"  data-numeric="true" data-r="hover.borderRadius.v.3" data-min="-500" data-max="500" type="text"></onelong>
							<oneshort><label_icon class="ui_bradius_bottomright"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit callEvent" data-updateviaevt="true" data-evt="updateBorderRadiusInputHover" data-evtparam="2" data-allowed="px,%"  data-numeric="true" data-r="hover.borderRadius.v.2" data-min="-500" data-max="500" type="text"></oneshort>
						</row>
						<div class="div15"></div>
						<div data-evt="copyhoversettings" data-helpkey="resethover" class="basic_action_button rightbutton longbutton callEventButton"><?php _e('Reset Style', 'revslider');?></div>
						<div class="tp-clearfix"></div>
					</div>
				</div>

				<div class="form_inner open _shfsvg_">
					<div class="svglayer_simplecoloring">
						<div class="form_inner_header"><i class="material-icons">title</i><?php _e('SVG Style', 'revslider');?></div>
						<div class="collapsable">						
							<!-- SVG HOVER STYLE -->
							
							<label_a><?php _e('SVG Color', 'revslider');?></label_a><input type="text" data-editing="SVG Hover Color" data-mode="single" name="layerSVGColorHover" id="layerSVGColorHover" class="my-color-field layerinput easyinit" data-visible="true" data-r="hover.svg.color" value="transparent">
							<div class="div5"></div>
							<label_a><?php _e('Stroke Color', 'revslider');?></label_a><input type="text" data-editing="Stroke Hover Color" data-mode="single" name="layerStrokeColorHover" id="layerStrokeColorHover" class="my-color-field layerinput easyinit" data-visible="true" data-r="hover.svg.strokeColor" value="transparent">
							<div class="div5"></div>
							<row class="directrow">
								<onelong><label_icon class="ui_strokewidth"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-allowed="px"  data-numeric="true" data-r="hover.svg.strokeWidth" data-min="-1" data-max="500" type="text"></onelong>
								<oneshort><label_icon class="ui_strokedasharray"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-r="hover.svg.strokeDashArray" type="text"></oneshort>
							</row>
							<row class="directrow">
								<onelong><label_icon class="ui_strokedashoffset"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-allowed="px"  data-numeric="true" data-r="hover.svg.strokeDashOffset" data-min="0" data-max="500" type="text"></onelong>
								<oneshort></oneshort>
							</row>						
						</div>
					</div>
				</div>

				<!-- LAYER FILTER HOVERS-->
				<div id="form_layerstyle_css_hover" class="form_inner open">
					<div class="form_inner_header"><i class="material-icons">blur_linear</i><?php _e('Filter', 'revslider');?></div>
						<div class="collapsable">

							<row class="direktrow">
								<onelong><label_icon class="ui_blur"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px" data-min="0" data-max="500" data-r="hover.filter.blur" type="text"></onelong>
								<oneshort></oneshort>
							</row>
							<row class="direktrow">
								<onelong><label_icon class="ui_brightness"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="%" data-min="0" data-max="10000" data-r="hover.filter.brightness" type="text"></onelong>
								<oneshort><label_icon class="ui_grayscale"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="%" data-min="0" data-max="100" data-r="hover.filter.grayscale" type="text"></oneshort>
							</row>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- LAYER ACTIONS CONTAINER -->
	<div class="form_collector layer_settings_collector" data-type="layersconfig" data-pcontainer="#layer_settings" data-offset="#rev_builder_wrapper">
		<div id="form_layer_actions"  class="formcontainer form_menu_inside collapsed" data-select="#gst_layer_9" data-unselect=".layer_submodule_trigger">
			<!--<div class="collectortabwrap"><div id="collectortab_form_layer_actions" class="collectortab form_menu_inside" data-forms='["#form_layer_actions"]'><i class="material-icons">link</i><?php _e('Actions', 'revslider');?></div></div>		-->

			<!-- LAYER ACTION SETTINGS -->
			<div class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">link</i><?php _e('Actions', 'revslider');?></div>
				<div class="collapsable">
				</div>
			</div>

		</div>
	</div>

	<!-- LAYER CUSTOM CONTAINER -->
	<div class="form_collector layer_settings_collector" data-type="layersconfig" data-pcontainer="#layer_settings" data-offset="#rev_builder_wrapper">
		<div id="form_layer_custom"  class="formcontainer form_menu_inside collapsed" data-select="#gst_layer_10" data-unselect=".layer_submodule_trigger">
			<!--<div class="collectortabwrap"><div id="collectortab_form_layer_custom" class="collectortab form_menu_inside" data-forms='["#form_layer_custom"]'><i class="material-icons">code</i><?php _e('Custom', 'revslider');?></div></div>		-->



		</div>
	</div>


	<!-- LAYER ANIMATION CONTAINER -->
	<div class="form_collector layer_settings_collector" data-type="layersconfig" data-pcontainer="#layer_settings" data-offset="#rev_builder_wrapper">
		<div id="form_layer_animation"  class="formcontainer form_menu_inside collapsed" data-select="#gst_layer_4" data-unselect=".layer_submodule_trigger">
			<div id="form_layer_animation_innerwrap">
				<!--<div class="collectortabwrap"><div id="collectortab_form_layer_animation" class="collectortab form_menu_inside" data-forms='["#form_layer_animation"]'><i class="material-icons">play_arrow</i><?php _e('Animation', 'revslider');?></div></div>		-->

				<!-- LAYER CONTENT SINGLE ANIMATION  <label_icon class="ui_textsplit singlerow"></label_icon> -->
				<div id="form_animation_sframes_keyframes" class="form_inner open">
					<div class="form_inner_header"><i class="material-icons">flash_on</i><?php _e('Keyframes', 'revslider');?><div id="layer_simulator" data-states="play,stop" data-start_state="play" data-stop="previewLayerAnimation" data-stop_state="" data-stop_icon="stop" data-play="previewStopLayerAnimation"  data-play_state="" data-play_icon="play_arrow" class="rightbutton basic_action_button onlyicon switch_button"><i class="switch_button_icon material-icons"></i><span class="switch_button_state"></span></div></div>

					<div class="collapsable">
						<!-- KEYFRAMES -->
						<div id="le_keyframes_list">
							<ul id="le_keyframes_list_innerwrap"></ul>
							<!-- PROGRESS BAR -->
							<!--<div id="layer_animation_progressbar"><div id="layer_animation_progressarrow"></div></div>-->
						</div>
						<div class="div15"></div>
						<div id="set_editor_view" data-helpkey="editorview" class="basic_action_button leftbutton autosize"><i class="material-icons">visibility</i><?php _e('Set as Editor View', 'revslider');?></div>
						<div id="remove_keyframe" class="basic_action_button rightbutton onlyicon"><i class="material-icons">delete</i></div>
						<div class="tp-clearfix"></div>


						<!-- PLAY/PAUSE LAYER SIMULATION-->
					</div>
				</div>

				<!-- BASICS SETTINGS FOR ANIMATION -->
				<div id="form_animation_sframes_basics" class="form_inner open">
					<div class="form_inner_header"><i class="material-icons">timer</i><?php _e('Basics', 'revslider');?></div>
					<div class="collapsable">

						<!-- KEYFRAME OPTIONS -->
						<!--<i class="material-icons label_icon">edit</i>-->
						<label_a><?php _e('Frame Alias', 'revslider');?></label_a><input  id="layerframename" class="layerinput smallinput easyinit callEvent" data-evt="updateKeyFramesList"  data-r="#frame#.alias" type="text">
						<div class="hide_on_frame_0">							
							<div id="layerframespeed_wrap"><!--<label_icon class="ui_duration singlerow"></label_icon>-->
								<label_a><?php _e('Duration', 'revslider');?></label_a><input  id="layerframespeed" class="layerinput valueduekeyboard smallinput easyinit callEvent" data-evt="updateLayerFrame" data-numeric="true" data-allowed="" data-r="#frame#.timeline.speed" data-min="0" data-max="99999" data-steps="10" type="text"><div id="layerframespeed_sub"></div>
							</div>
							<label_a><?php _e('Start', 'revslider');?></label_a><input  id="layerframestart" class="layerinput valueduekeyboard smallinput easyinit callEvent" data-evt="updateLayerFrameStart" data-updateviaevt="true" data-numeric="true" data-allowed="" data-r="#frame#.timeline.start" data-min="0" data-max="99999999" data-steps="10" type="text">
							<!--<label_icon class="ui_easing singlerow"></label_icon>-->
							<label_a><?php _e('Easing', 'revslider');?></label_a><select class="layerinput tos2 nosearchbox easyinit easingSelect" data-r="#frame#.timeline.ease"></select>
							<row class="direktrow">
								<onelong><label_a><?php _e('Wait for Action', 'revslider');?></label_a><div class="onoff_showonlystatus"><input class="layerinput smallinput easyinit callEvent" data-evt="updateAllLayerFrames" type="checkbox" data-r="#frame#.timeline.actionTriggered"/></div></onelong>
								<oneshort></oneshort>
							</row>
						</div>

						<!--<div class="show_on_frame_0">
							<row class="direktrow">
								<onelong><label_a><?php _e('Force Prepare', 'revslider');?></label_a><input class="layerinput smallinput easyinit" type="checkbox" data-r="timeline.forcePrepare"/></onelong>
								<oneshort></oneshort>
							</row>								
						</div>-->

						<div class="show_on_frame_999">
							<row class="direktrow">
								<onelong><label_a><?php _e('Reverse "IN"', 'revslider');?></label_a><input data-showhide="" data-evt="reverse-in-animation" data-hideshow="#form_animation_sframes_advanced" data-showhidedep="true" class="layerinput smallinput easyinit" type="checkbox" data-r="#frame#.timeline.auto"/></onelong>
								<oneshort></oneshort>
							</row>
						</div>
					</div>
				</div>

				<!-- ADVANCED SETTINGS FOR ANIMATION -->
				<div id="form_animation_sframes_advanced" class="form_inner open">
					<div class="form_inner_header"><i class="material-icons">tune</i><?php _e('Advanced', 'revslider');?></div>
					<div id="form_animation_sframes_innerwrap" class="collapsable">
						<!-- LAYER FRAME TRANSFORM  -->
						<div id="layer_maintranssettings_wrap" class="layer_transsettings_wrap">
							<div id="layerbasic_ts_wrapbrtn" class="ts_wrapbrtn"><div data-showtrans="#layer_transsettings" data-frametarget="layer" class="transtarget_selector selected" ><?php _e('Layer', 'revslider');?></div></div><!--
							--><div style="display:inline-block" class="_nsfr_ _nsfc_"><div id="chars_ts_wrapbrtn" class="ts_wrapbrtn"><div data-showtrans="#chars_transsettings" data-frametarget="chars"  class="transtarget_selector" ><?php _e('Char', 'revslider');?></div></div></div><!--
							--><div style="display:inline-block" class="_nsfr_ _nsfc_"><div id="words_ts_wrapbrtn" class="ts_wrapbrtn"><div data-showtrans="#words_transsettings" data-frametarget="words" class="transtarget_selector"><?php _e('Word', 'revslider');?></div></div></div><!--
							--><div style="display:inline-block" class="_nsfr_ _nsfc_"><div id="lines_ts_wrapbrtn" class="ts_wrapbrtn"><div data-showtrans="#lines_transsettings" data-frametarget="lines" class="transtarget_selector"><?php _e('Line', 'revslider');?></div></div></div><!--
							--><div id="mask_ts_wrapbrtn" class="ts_wrapbrtn"><div data-showtrans="#mask_transsettings" data-frametarget="mask" class="transtarget_selector"><?php _e('Mask', 'revslider');?></div></div><!--							
							--><div id="color_ts_wrapbrtn" class="ts_wrapbrtn"><div data-showtrans="#color_transsettings" data-frametarget="color" class="transtarget_selector" ><?php _e('Color', 'revslider');?></div></div><!--
							--><div style="display:inline-block" class="hide_on_frame_0 "><div id="sfx_ts_wrapbrtn" class="ts_wrapbrtn"><div data-showtrans="#sfx_transsettings" data-frametarget="sfx" class="transtarget_selector"><?php _e('SFX', 'revslider');?></div></div></div><!--
							
							
						--></div>
						<div class="div20"></div>
						<!-- LAYER TRANSFORMATIONS -->
						<div id="layer_transsettings" class="group_transsettings">
							<label_icon class="ui_opacity singlerow"></label_icon><input id="le_frame_opacity" class="layerinput valueduekeyboard smallinput easyinit input_with_presets" data-numeric="true" data-allowed="inherit,random" data-presets_text="$I$Inherit!$R$Random {min,max}!$C$Custom" data-presets_val="inherit!{0,1}!0.5" data-r="#frame#.transform.opacity" data-min="0" data-max="1" data-steps="0.05" type="text">
							<div class="div10"></div>
							<row class="direktrow">
								<onelong class="dyn_inp_wrap"><label_icon class="ui_x"></label_icon><input data-numeric="true" id="le_frame_x" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets"  data-allowed="px,%,random,cycle,left,right,center,inherit" data-responsive="true" data-r="#frame#.transform.x.#size#.v"  data-presets_text="$C$px!$C$%!$I$Inherit!$R$Random {min,max}!$SL$Wrapper Left!$SR$Wrapper Right!$BV$Wrapper Center!$CY$Cycles [val|val|val]" data-presets_val="50px!100%!inherit!{-20,20}!left!right!center![-50|50]" type="text"></onelong>
								<oneshort class="dyn_inp_wrap"><label_icon class="ui_y"></label_icon><input data-numeric="true"  id="le_frame_y" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets"  data-allowed="px,%,random,cycle,top,bottom,middle,inherit,center" data-responsive="true" data-r="#frame#.transform.y.#size#.v" data-presets_text="$C$px!$C$%!$I$Inherit!$R$Random {min,max}!$ST$Wrapper Top!$SB$Wrapper Bottom!$BH$Wrapper Middle!$CY$Cycles [val|val|val]" data-presets_val="50px!100%!inherit!{-20,20}!top!bottom!center![-50|50]" type="text"></oneshort>
							</row>
							<row class="direktrow">
								<onelong class="dyn_inp_wrap"><label_icon class="ui_z"></label_icon><input id="le_frame_z" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets" data-numeric="true" data-allowed="px,random,cycle,inherit" data-r="#frame#.transform.z"  data-presets_text="$C$px!$I$Inherit!$R$Random {min,max}!$CY$Cycles [val|val|val]" data-presets_val="50px!inherit!{-100,100}![-50|50]" type="text"></onelong>
								<oneshort><div class="global_perspective_settings global_perspecitve_local_settings"><label_icon class="ui_perspective"></label_icon><input id="le_frame_perspective" class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px" data-r="#frame#.transform.transformPerspective" type="text"></div></oneshort>
							</row>
							<div class="div10"></div>
							<row class="direktrow">
								<onelong class="dyn_inp_wrap"><label_icon class="ui_scalex"></label_icon><input id="le_frame_scale_x" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets" data-numeric="true" data-allowed="random,cycle,inherit" data-presets_text="$C$1!$I$Inherit!$R$Random {min,max}!$CY$Cycles [val|val|val]" data-presets_val="1!inherit!{0,2}![0.5|1]" data-r="#frame#.transform.scaleX"  data-steps="0.05" type="text"></onelong>
								<oneshort class="dyn_inp_wrap"><label_icon class="ui_scaley"></label_icon><input id="le_frame_scale_y" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets" data-numeric="true" data-allowed="random,cycle,inherit" data-presets_text="$C$1!$I$Inherit!$R$Random {min,max}!$CY$Cycles [val|val|val]" data-presets_val="1!inherit!{0,2}![0.5|1]" data-r="#frame#.transform.scaleY"  data-steps="0.05" type="text"></oneshort>
							</row>
							<row class="direktrow">
								<onelong class="dyn_inp_wrap"><label_icon class="ui_skewx"></label_icon><input id="le_frame_skew_x" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets" data-numeric="true" data-allowed="px,random,cycle,inherit" data-presets_text="$C$px!$I$Inherit!$R$Random {min,max}!$CY$Cycles [val|val|val]" data-presets_val="50px!inherit!{0,2}![-50|50]" data-r="#frame#.transform.skewX"  data-steps="0.05" type="text"></onelong>
								<oneshort class="dyn_inp_wrap"><label_icon class="ui_skewy"></label_icon><input id="le_frame_skew_y" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets" data-numeric="true" data-allowed="px,random,cycle,inherit" data-presets_text="$C$px!$I$Inherit!$R$Random {min,max}!$CY$Cycles [val|val|val]" data-presets_val="50px!inherit!{0,2}![-50|50]" data-r="#frame#.transform.skewY"  data-steps="0.05" type="text"></oneshort>
							</row>
							<div class="div10"></div>
							<row class="direktrow">
								<onelong class="dyn_inp_wrap"><label_icon class="ui_rotatex"></label_icon><input id="le_frame_rotate_x" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets" data-numeric="true" data-allowed="deg,random,cycle,inherit" data-presets_text="$C$px!$I$Inherit!$R$Random {min,max}!$CY$Cycles [val|val|val]" data-presets_val="50deg!inherit!{-15,15}![-50|50]" data-r="#frame#.transform.rotationX" type="text"></onelong>
								<oneshort class="dyn_inp_wrap"><label_icon class="ui_rotatey"></label_icon><input id="le_frame_rotate_y" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets " data-numeric="true" data-allowed="deg,random,cycle,inherit" data-presets_text="$C$px!$I$Inherit!$R$Random {min,max}!$CY$Cycles [val|val|val]" data-presets_val="50deg!inherit!{-15,15}![-50|50]" data-r="#frame#.transform.rotationY" type="text"></oneshort>
							</row>
							<row class="direktrow">
								<onelong class="dyn_inp_wrap"><label_icon class="ui_rotatez"></label_icon><input id="le_frame_rotate_z" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets" data-numeric="true" data-allowed="deg,random,cycle,inherit" data-presets_text="$C$px!$I$Inherit!$R$Random {min,max}!$CY$Cycles [val|val|val]" data-presets_val="50deg!inherit!{-15,15}![-50|50]" data-r="#frame#.transform.rotationZ" type="text"></onelong>
								<oneshort></oneshort>
							</row>
							<row class="direktrow">
								<onelong><label_icon class="ui_origox"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px,%,inherit" data-r="#frame#.transform.originX" data-min="-3600" data-max="3600" type="text"></onelong>
								<oneshort><label_icon class="ui_origoy"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px,%,inherit" data-r="#frame#.transform.originY" data-min="-3600" data-max="3600" type="text"></oneshort>
							</row>
							<row class="direktrow">
								<onelong><label_icon class="ui_origoz"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px,%,inherit" data-r="#frame#.transform.originZ" data-min="-3600" data-max="3600" type="text"></onelong>
								<oneshort></oneshort>
							</row>
							<div class="div15"></div>
							<div class="form_inner_header innerwrap_breakout"><i class="material-icons">auto_awesome</i><?php _e('Layer Filter', 'revslider');?></div>
							<div class="div15"></div>
							<row>
								<onelong><label_a><?php _e('Use Filter', 'revslider');?></label_a><input type="checkbox" data-showhide="._ltsel_main_filter" data-showhidedep="true" class="layerinput easyinit" data-r="#frame#.filter.use"/></onelong>
								<oneshort class="_ltsel_main_filter"><label_icon class="ui_blur"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px" data-min="0" data-max="500" data-r="#frame#.filter.blur" type="text"></oneshort>									
							</row>
							<row>
								<onelong class="_ltsel_main_filter"><label_icon class="ui_grayscale"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="%" data-min="0" data-max="100" data-r="#frame#.filter.grayscale" type="text"></onelong>
								<oneshort class="_ltsel_main_filter"><label_icon class="ui_brightness"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="%" data-min="0" data-max="10000" data-r="#frame#.filter.brightness" type="text"></oneshort>
							</row>															
							
							<longoption class="_ltsel_main_filter"><label_a><?php _e('Set Filters on Mask', 'revslider');?></label_a><input type="checkbox" class="layerinput easyinit" data-r="timeline.filtersOnMask"/></longoption>
							
							
							<div class="div15"></div>
							<div class="form_inner_header innerwrap_breakout"><i class="material-icons">settings_brightness</i><?php _e('Layer Back-Drop Filter', 'revslider');?></div>
							<div class="div15"></div>
							<row>
								<onelong><label_a><?php _e('Use Filter', 'revslider');?></label_a><input type="checkbox" data-showhide="._ltsel_main_bfilter" data-showhidedep="true" class="layerinput easyinit" data-r="#frame#.bfilter.use"/></onelong>
								<oneshort class="_ltsel_main_bfilter"><label_icon class="ui_blur"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px" data-min="0" data-max="100" data-r="#frame#.bfilter.blur" type="text"></oneshort>									
							</row>
							<row class="direktrow">
								<onelong class="_ltsel_main_bfilter"><label_icon class="ui_grayscale"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="%" data-min="0" data-max="100" data-r="#frame#.bfilter.grayscale" type="text"></onelong>
								<oneshort class="_ltsel_main_bfilter"><label_icon class="ui_brightness"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="%" data-min="0" data-max="500" data-r="#frame#.bfilter.brightness" type="text"></oneshort>
							</row>
							<row class="direktrow">
								<onelong class="_ltsel_main_bfilter"><i class="label_icon material-icons">filter_vintage</i><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="%" data-min="0" data-max="100" data-r="#frame#.bfilter.sepia" type="text"></onelong>
								<oneshort class="_ltsel_main_bfilter"><i class="label_icon material-icons inshort">invert_colors</i><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="%" data-min="0" data-max="500" data-r="#frame#.bfilter.invert" type="text"></oneshort>
							</row>

							<div class="div15"></div>
							<!-- REVERSE ANIMATIONS -->
							<div class="show_on_frame_0 show_on_frame_999">
								<div class="form_inner_header innerwrap_breakout"><i class="material-icons">settings_ethernet</i><?php _e('Slide Direction based Mirroring', 'revslider');?></div>

								<div class="div15"></div>
								<row> <!-- NO DIREKT ROW NEEDED -->
									<onelong><label_icon class="ui_x"></label_icon><input type="checkbox" class="easyinit layerinput" data-r="#frame#.reverseDirection.x"></onelong>
									<oneshort><label_icon class="ui_y"></label_icon><input type="checkbox" class="easyinit layerinput" data-r="#frame#.reverseDirection.y"></oneshort>
								</row>
								<row class="direktrow">
									<onelong><label_icon class="ui_rotatex"></label_icon><input type="checkbox" class="easyinit layerinput" data-r="#frame#.reverseDirection.rotationX"></onelong>
									<oneshort><label_icon class="ui_rotatey"></label_icon><input type="checkbox" class="easyinit layerinput" data-r="#frame#.reverseDirection.rotationY"></oneshort>
								</row>
								<row> <!-- NO DIREKT ROW NEEDED -->
									<onelong><label_icon class="ui_rotatez"></label_icon><input type="checkbox" class="easyinit layerinput" data-r="#frame#.reverseDirection.rotationZ"></onelong>
									<oneshort></oneshort>
								</row>
								<row>
									<onelong><label_icon class="ui_skewx"></label_icon><input type="checkbox" class="easyinit layerinput" data-r="#frame#.reverseDirection.skewX"></onelong>
									<oneshort><label_icon class="ui_skewy"></label_icon><input type="checkbox" class="easyinit layerinput" data-r="#frame#.reverseDirection.skewY"></oneshort>
								</row>
							</div>

						</div>
						<!-- MASK TRANSFORMATIONS -->
						<div id="mask_transsettings" class="group_transsettings" style="display:none">
							<label_a><?php _e('Use Masking', 'revslider');?></label_a><input type="checkbox" data-showhide="#_ltsel_mask" data-showhidedep="true" class="layerinput easyinit callEvent" data-evt="checkEnterFrameLevels" data-r="#frame#.mask.use" /><div class="linebreak"></div>														
							<div id="_ltsel_mask">
									<row> <!-- NO DIREKT ROW NEEDED -->
 										<onelong class="dyn_inp_wrap"><label_icon class="ui_x"></label_icon><input data-numeric="true" id="le_frame_mask_x" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets"  data-allowed="px,%,random,left,right,center,inherit" data-responsive="true" data-r="#frame#.mask.x.#size#.v"  data-presets_text="$C$px!$C$%!$I$Inherit!$R$Random {min,max}!$SL$Wrapper Left!$SR$Wrapper Right!$SC$Wrapper Center" data-presets_val="50px!100%!0!{-20,20}!left!right!center" type="text"></onelong>
										<oneshort class="dyn_inp_wrap"><label_icon class="ui_y"></label_icon><input data-numeric="true"  id="le_frame_mask_y" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets"  data-allowed="px,%,random,top,bottom,center,inherit" data-responsive="true" data-r="#frame#.mask.y.#size#.v" data-presets_text="$C$px!$C$%!$I$Inherit!$R$Random {min,max}!$ST$Wrapper Top!$SB$Wrapper Bottom!$SC$Wrapper Center" data-presets_val="50px!100%!0!{-20,20}!bottom!center" type="text"></oneshort>
									</row>
									<div class="div10"></div>							
									<!-- REVERSE ANIMATIONS -->
									<div class="show_on_frame_0 show_on_frame_999">
										<div class="form_inner_header innerwrap_breakout"><i class="material-icons">settings_ethernet</i><?php _e('Slide Direction based Mirroring', 'revslider');?></div>
										<div class="div15"></div>
										<row class="direktrow">
											<onelong ><label_icon class="ui_x"></label_icon><input type="checkbox" class="easyinit layerinput" data-r="#frame#.reverseDirection.maskX"></onelong>
											<oneshort ><label_icon class="ui_y"></label_icon><input type="checkbox" class="easyinit layerinput" data-r="#frame#.reverseDirection.maskY"></oneshort>
										</row>
									</div>									
							</div>
							<label_a><?php _e('Use Clip Path', 'revslider');?></label_a><input type="checkbox" data-showhide="#__clip_not_mask" data-showhidedep="true" class="layerinput easyinit callEvent" data-evt="checkEnterFrameLevels" data-r="timeline.clipPath.use" />					
							<div id="__clip_not_mask">
								<label_a><?php _e('Type', 'revslider');?></label_a><select data-show=".clippath_o_*val*" data-hide=".clippath_hide" class="layerinput tos2 nosearchbox easyinit" data-r="timeline.clipPath.type">
									<option value="rectangle"><?php _e('Rectangle', 'revslider');?></option>									
									<option value="circle"><?php _e('Circle', 'revslider');?></option>
									<option value="inverts"><?php _e('Custom Mask', 'revslider');?></option>							
								</select>
								<label_a><?php _e('Origin', 'revslider');?></label_a><div class="clippath_o_rectangle clippath_hide" style="display:inline-block"><select class="layerinput tos2 nosearchbox easyinit"  data-r="timeline.clipPath.origin">
											<optgroup label="<?php _e('Vertical', 'revslider');?>">
												<option value="l"><?php _e('Left', 'revslider');?></option>
												<option value="cv"><?php _e('Center', 'revslider');?></option>
												<option value="r"><?php _e('Right', 'revslider');?></option>												
											</optgroup>
											<optgroup label="<?php _e('Horizontal', 'revslider');?>">
												<option value="t"><?php _e('Top', 'revslider');?></option>
												<option value="ch"><?php _e('Center', 'revslider');?></option>
												<option value="b"><?php _e('Bottom', 'revslider');?></option>												
											</optgroup>
											<optgroup label="<?php _e('Diagonal From', 'revslider');?>">
												<option value="lt"><?php _e('Left Top', 'revslider');?></option>										
												<option value="rt"><?php _e('Right Top', 'revslider');?></option>										
												<option value="rb"><?php _e('Right Bottom', 'revslider');?></option>										
												<option value="lb"><?php _e('Left Bottom', 'revslider');?></option>
											</optgroup>
											<optgroup label="<?php _e('Center Diagonal', 'revslider');?>">
												<option value="clr"><?php _e('Center - Left Right', 'revslider');?></option>
												<option value="crl"><?php _e('Center - Right Left', 'revslider');?></option>
												<option disabled="disabled" value="invh"><?php _e('Horizontal Mask', 'revslider');?></option>
												<option disabled="disabled" value="invv"><?php _e('Vertical Mask', 'revslider');?></option>
											</optgroup>										
										</select>
									</div><div class="clippath_o_circle clippath_hide"  style="display:inline-block"><select class="layerinput tos2 nosearchbox easyinit clippath_hide" data-r="timeline.clipPath.origin">
											<optgroup label="<?php _e('Basics', 'revslider');?>">
												<option value="l"><?php _e('Left', 'revslider');?></option>
												<option disabled="disabled" value="cv"><?php _e('Center', 'revslider');?></option>
												<option disabled="disabled" value="invh"><?php _e('Invert Horizontal', 'revslider');?></option>
												<option disabled="disabled" value="invv"><?php _e('Invert Vertical', 'revslider');?></option>
												<option value="r"><?php _e('Right', 'revslider');?></option>										
												<option value="t"><?php _e('Top', 'revslider');?></option>
												<option disabled="disabled" value="ch"><?php _e('Center', 'revslider');?></option>
												<option value="b"><?php _e('Bottom', 'revslider');?></option>
												<option value="clr"><?php _e('Center', 'revslider');?></option>
											</optgroup>
											<optgroup label="<?php _e('Corners', 'revslider');?>">
												<option value="lt"><?php _e('Left Top', 'revslider');?></option>										
												<option value="rt"><?php _e('Right Top', 'revslider');?></option>										
												<option value="rb"><?php _e('Right Bottom', 'revslider');?></option>										
												<option value="lb"><?php _e('Left Bottom', 'revslider');?></option>
												<option disabled="disabled" value="crl"><?php _e('Center - Right Left', 'revslider');?></option>
											</optgroup>																															
										</select>
									</div><div class="clippath_o_inverts clippath_hide"  style="display:inline-block"><select class="layerinput tos2 nosearchbox easyinit clippath_hide" data-r="timeline.clipPath.origin">											
											<option value="invv"><?php _e('Vertical Mask', 'revslider');?></option>
											<option value="invh"><?php _e('Horizontal Mask', 'revslider');?></option>
											<option disabled="disabled" value="l"><?php _e('Left', 'revslider');?></option>
											<option disabled="disabled" value="cv"><?php _e('Center', 'revslider');?></option>											
											<option disabled="disabled" value="r"><?php _e('Right', 'revslider');?></option>										
											<option disabled="disabled" value="t"><?php _e('Top', 'revslider');?></option>
											<option disabled="disabled" value="ch"><?php _e('Center', 'revslider');?></option>
											<option disabled="disabled" value="b"><?php _e('Bottom', 'revslider');?></option>
											<option disabled="disabled" value="clr"><?php _e('Center', 'revslider');?></option>										
											<option disabled="disabled" value="lt"><?php _e('Left Top', 'revslider');?></option>										
											<option disabled="disabled" value="rt"><?php _e('Right Top', 'revslider');?></option>										
											<option disabled="disabled" value="rb"><?php _e('Right Bottom', 'revslider');?></option>										
											<option disabled="disabled" value="lb"><?php _e('Left Bottom', 'revslider');?></option>
											<option disabled="disabled" value="crl"><?php _e('Center - Right Left', 'revslider');?></option>											
										</select>
									</div>
								<onelong><label_icon class="ui_brightness clippath_hide clippath_o_circle clippath_o_rectangle"></label_icon><label_a class="clippath_o_inverts clippath_hide"><?php _e('Start Range', 'revslider');?></label_a><input data-numeric="true" class="layerinput valueduekeyboard smallinput easyinit input_with_presets"  data-allowed="%,inherit" data-responsive="true" data-r="#frame#.transform.clip"  data-presets_text="$C$100%!$C$75%!$C$50%!$C$25%!" data-presets_val="100%!75%!50%!25%!" type="text"></onelong>
								<div class="clippath_o_inverts clippath_hide"><onelong><label_a><?php _e('End Range', 'revslider');?></label_a><input data-numeric="true" class="layerinput valueduekeyboard smallinput easyinit input_with_presets"  data-allowed="%,inherit" data-responsive="true" data-r="#frame#.transform.clipB"  data-presets_text="$C$100%!$C$75%!$C$50%!$C$25%!" data-presets_val="100%!75%!50%!25%!" type="text"></onelong></div>
							</div>
						</div>
						<!-- CHARS TRANSFORMATIONS -->
						<div id="chars_transsettings" class="group_transsettings" style="display:none">
							<label_a><?php _e('Split Chars', 'revslider');?></label_a><input type="checkbox" data-showhide="#_ltsel_char" data-showhidedep="true" class="layerinput easyinit callEvent" data-evt="checkEnterFrameLevels" data-r="#frame#.chars.use" />
							<div id="_ltsel_char">
								<row class="direktrow nosfxanim hide_on_frame_0">
									<onelong><label_icon class="ui_splitdirection"></label_icon><select data-theme="min120" id="le_frame_chars_txtsplitdirection" class="layerinput tos2 nosearchbox easyinit" data-r="#frame#.chars.direction"><option value="forward"><?php _e('Forward', 'revslider');?></option><option value="backward"><?php _e('Backward', 'revslider');?></option><option value="middletoedge"><?php _e('Middle To Edge', 'revslider');?></option><option value="edgetomiddle"><?php _e('Edge to Middle', 'revslider');?></option><option value="random"><?php _e('Random', 'revslider');?></option></select></onelong>
									<oneshort><label_icon class="ui_splitdelay"></label_icon><input data-numeric="true"  id="le_frame_chars_splitdelay" class="layerinput valueduekeyboard smallinput easyinit callEvent"  data-evt="updateLayerFrame" data-allowed="" data-r="#frame#.chars.delay" data-min="0" data-max="99999" type="text"></oneshort>
									<label_icon class="ui_easing_in singlerow"></label_icon><select id="chars_appear_ease" class="layerinput tos2 nosearchbox easyinit easingSelect" data-inherit="true" data-r="#frame#.chars.ease"></select>
								</row>
								<label_icon class="ui_opacity singlerow"></label_icon><input id="le_frame_chars_opacity" class="layerinput valueduekeyboard smallinput easyinit input_with_presets" data-numeric="true" data-allowed="inherit,random" data-presets_text="$I$Inherit!$R$Random {min,max}!$C$Custom" data-presets_val="inherit!{0,1}!0.5" data-r="#frame#.chars.opacity" data-min="0" data-max="1" data-steps="0.05" type="text">
								<div class="div10"></div>
								<row class="direktrow">
									<onelong class="dyn_inp_wrap"><label_icon class="ui_x"></label_icon><input data-numeric="true" id="le_frame_chars_x" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets"  data-allowed="px,%,random,cycle,left,right,center,inherit" data-responsive="true" data-r="#frame#.chars.x.#size#.v"  data-presets_text="$C$px!$C$%!$I$Inherit!$R$Random {min,max}!$SL$Wrapper Left!$SR$Wrapper Right!$BV$Wrapper Center!$CY$Cycles [val|val|val]" data-presets_val="50px!100%!inherit!{-20,20}!left!right!center![-50|50]" type="text"></onelong>
									<oneshort class="dyn_inp_wrap"><label_icon class="ui_y"></label_icon><input data-numeric="true"  id="le_frame_chars_y" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets"  data-allowed="px,%,random,cycle,top,bottom,middle,inherit" data-responsive="true" data-r="#frame#.chars.y.#size#.v" data-presets_text="$C$px!$C$%!$I$Inherit!$R$Random {min,max}!$ST$Wrapper Top!$SB$Wrapper Bottom!$BH$Wrapper Middle!$CY$Cycles [val|val|val]" data-presets_val="50px!100%!inherit!{-20,20}!top!bottom!center![-50|50]" type="text"></oneshort>
								</row>
								<row class="direktrow">
									<onelong class="dyn_inp_wrap"><label_icon class="ui_z"></label_icon><input id="le_frame_chars_z" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets" data-numeric="true" data-allowed="px,random,cycle,inherit" data-r="#frame#.chars.z"  data-presets_text="$C$px!$I$Inherit!$R$Random {min,max}!$CY$Cycles [val|val|val]" data-presets_val="50px!inherit!{0,2}![-50|50]" type="text"></onelong>
									<oneshort></oneshort>
								</row>
								<div class="div10"></div>
								<row class="direktrow">
									<onelong class="dyn_inp_wrap"><label_icon class="ui_scalex"></label_icon><input id="le_frame_chars_scale_x" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets" data-numeric="true" data-allowed="random,cycle,inherit" data-presets_text="$C$1!$I$Inherit!$R$Random {min,max}!$CY$Cycles [val|val|val]" data-presets_val="1!inherit!{0,2}![0.5|1]" data-r="#frame#.chars.scaleX"  data-steps="0.05" type="text"></onelong>
									<oneshort class="dyn_inp_wrap"><label_icon class="ui_scaley"></label_icon><input id="le_frame_chars_scale_y" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets" data-numeric="true" data-allowed="random,cycle,inherit" data-presets_text="$C$1!$I$Inherit!$R$Random {min,max}!$CY$Cycles [val|val|val]" data-presets_val="1!inherit!{0,2}![0.5|1]" data-r="#frame#.chars.scaleY"  data-steps="0.05" type="text"></oneshort>
								</row>
								<row class="direktrow">
									<onelong class="dyn_inp_wrap"><label_icon class="ui_skewx"></label_icon><input id="le_frame_chars_skew_x" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets" data-numeric="true" data-allowed="px,random,cycle,inherit" data-presets_text="$C$px!$I$Inherit!$R$Random {min,max}!$CY$Cycles [val|val|val]" data-presets_val="50px!inherit!{0,2}![-50|50]" data-r="#frame#.chars.skewX"  data-steps="0.05" type="text"></onelong>
									<oneshort class="dyn_inp_wrap"><label_icon class="ui_skewy"></label_icon><input id="le_frame_chars_skew_y" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets" data-numeric="true" data-allowed="px,random,cycle,inherit" data-presets_text="$C$px!$I$Inherit!$R$Random {min,max}!$CY$Cycles [val|val|val]" data-presets_val="50px!inherit!{0,2}![-50|50]" data-r="#frame#.chars.skewY" data-steps="0.05"  type="text"></oneshort>
								</row>
								<div class="div10"></div>
								<row class="direktrow">
									<onelong class="dyn_inp_wrap"><label_icon class="ui_rotatex"></label_icon><input id="le_frame_chars_rotate_x" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets" data-numeric="true" data-allowed="deg,random,cycle,inherit" data-presets_text="$C$px!$I$Inherit!$R$Random {min,max}!$CY$Cycles [val|val|val]" data-presets_val="50deg!inherit!{-15,15}![-50|50]" data-r="#frame#.chars.rotationX" type="text"></onelong>
									<oneshort class="dyn_inp_wrap"><label_icon class="ui_rotatey"></label_icon><input id="le_frame_chars_rotate_y" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets " data-numeric="true" data-allowed="deg,random,cycle,inherit" data-presets_text="$C$px!$I$Inherit!$R$Random {min,max}!$CY$Cycles [val|val|val]" data-presets_val="50deg!inherit!{-15,15}![-50|50]" data-r="#frame#.chars.rotationY" type="text"></oneshort>
								</row>
								<row class="direktrow">
									<onelong class="dyn_inp_wrap"><label_icon class="ui_rotatez"></label_icon><input id="le_frame_chars_rotate_z" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets" data-numeric="true" data-allowed="deg,random,cycle,inherit" data-presets_text="$C$px!$I$Inherit!$R$Random {min,max}!$CY$Cycles [val|val|val]" data-presets_val="50deg!inherit!{-15,15}![-50|50]" data-r="#frame#.chars.rotationZ" type="text"></onelong>
									<oneshort></oneshort>
								</row>
								<row class="direktrow">
									<onelong><label_icon class="ui_origox"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px,%,inherit" data-r="#frame#.chars.originX" data-min="-3600" data-max="3600" type="text"></onelong>
									<oneshort><label_icon class="ui_origoy"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px,%,inherit" data-r="#frame#.chars.originY" data-min="-3600" data-max="3600" type="text"></oneshort>
								</row>
								<row class="direktrow">
									<onelong><label_icon class="ui_origoz"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px,%,inherit" data-r="#frame#.chars.originZ" data-min="-3600" data-max="3600" type="text"></onelong>
									<oneshort></oneshort>
								</row>
								<div class="div15"></div>
								<div class="form_inner_header innerwrap_breakout"><i class="material-icons">auto_awesome</i><?php _e('Char Filter', 'revslider');?></div>
								<div class="div15"></div>
								<row class="direktrow">
									<onelong><label_a><?php _e('Use Filter', 'revslider');?></label_a><input type="checkbox" data-showhide="._ltsel_chars_filter" data-showhidedep="true" class="layerinput easyinit" data-r="#frame#.chars.fuse"/></onelong>
									<oneshort class="_ltsel_chars_filter"><label_icon class="ui_blur"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px" data-min="0" data-max="500" data-r="#frame#.chars.blur" type="text"></oneshort>									
								</row>
								<row class="direktrow">
									<onelong class="_ltsel_chars_filter"><label_icon class="ui_grayscale"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="%" data-min="0" data-max="100" data-r="#frame#.chars.grayscale" type="text"></onelong>
									<oneshort class="_ltsel_chars_filter"><label_icon class="ui_brightness"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="%" data-min="0" data-max="10000" data-r="#frame#.chars.brightness" type="text"></oneshort>
								</row>
								<div class="div15"></div>
								<!-- REVERSE ANIMATIONS -->
								<div class="show_on_frame_0 show_on_frame_999">
									<div class="form_inner_header innerwrap_breakout"><i class="material-icons">settings_ethernet</i><?php _e('Slide Direction based Mirroring', 'revslider');?></div>

									<div class="div15"></div>
									<row class="direktrow">
										<onelong><label_icon class="ui_x"></label_icon><input type="checkbox" class="easyinit layerinput" data-r="#frame#.reverseDirection.charsX"></onelong>
										<oneshort><label_icon class="ui_y"></label_icon><input type="checkbox" class="easyinit layerinput" data-r="#frame#.reverseDirection.charsY"></oneshort>
									</row>
									<row>
										<onelong><label_icon class="ui_splitdirection"></label_icon><input type="checkbox" class="easyinit layerinput" data-r="#frame#.reverseDirection.charsDirection"></onelong>
										<oneshort></oneshort>
									</row>
								</div>
							</div>
						</div>
						<!-- WORDS TRANSFORMATIONS -->
						<div id="words_transsettings" class="group_transsettings" style="display:none">
							<label_a><?php _e('Split Words', 'revslider');?></label_a><input type="checkbox" data-showhide="#_ltsel_word" data-showhidedep="true" class="layerinput easyinit callEvent" data-evt="checkEnterFrameLevels" data-r="#frame#.words.use" />
							<div id="_ltsel_word">
								<row class="direktrow nosfxanim hide_on_frame_0">
									<onelong><label_icon class="ui_splitdirection"></label_icon><select data-theme="min120" id="le_frame_words_txtsplitdirection" class="layerinput tos2 nosearchbox easyinit" data-r="#frame#.words.direction"><option value="forward"><?php _e('Forward', 'revslider');?></option><option value="backward"><?php _e('Backward', 'revslider');?></option><option value="middletoedge"><?php _e('Middle To Edge', 'revslider');?></option><option value="edgetomiddle"><?php _e('Edge to Middle', 'revslider');?></option><option value="random"><?php _e('Random', 'revslider');?></option></select></onelong>
									<oneshort><label_icon class="ui_splitdelay"></label_icon><input data-numeric="true"  id="le_frame_words_splitdelay" class="layerinput valueduekeyboard smallinput easyinit callEvent"  data-evt="updateLayerFrame" data-allowed="" data-r="#frame#.words.delay" data-min="0" data-max="99999" type="text"></oneshort>
									<label_icon class="ui_easing_in singlerow"></label_icon><select id="words_appear_ease" class="layerinput tos2 nosearchbox easyinit easingSelect" data-inherit="true" data-r="#frame#.words.ease"></select>
								</row>
								<label_icon class="ui_opacity singlerow"></label_icon><input id="le_frame_words_opacity" class="layerinput valueduekeyboard smallinput easyinit input_with_presets" data-numeric="true" data-allowed="inherit,random" data-presets_text="$I$Inherit!$R$Random {min,max}!$C$Custom" data-presets_val="inherit!{0,1}!0.5" data-r="#frame#.words.opacity" data-min="0" data-max="1" data-steps="0.05" type="text">
								<div class="div10"></div>
								<row class="direktrow">
									<onelong class="dyn_inp_wrap"><label_icon class="ui_x"></label_icon><input data-numeric="true" id="le_frame_words_x" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets"  data-allowed="px,%,random,cycle,left,right,center,inherit" data-responsive="true" data-r="#frame#.words.x.#size#.v"  data-presets_text="$C$px!$C$%!$I$Inherit!$R$Random {min,max}!$SL$Wrapper Left!$SR$Wrapper Right!$BV$Wrapper Center!$CY$Cycles [val|val|val]" data-presets_val="50px!100%!inherit!{-15,15}!left!right!center![-50|50]" type="text"></onelong>
									<oneshort class="dyn_inp_wrap"><label_icon class="ui_y"></label_icon><input data-numeric="true"  id="le_frame_words_y" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets"  data-allowed="px,%,random,cycle,top,bottom,middle,inherit,center" data-responsive="true" data-r="#frame#.words.y.#size#.v" data-presets_text="$C$px!$C$%!$I$Inherit!$R$Random {min,max}!$ST$Wrapper Top!$SB$Wrapper Bottom!$BH$Wrapper Middle!$CY$Cycles [val|val|val]" data-presets_val="50px!100%!inherit!{-15,15}!top!bottom!center![-50|50]" type="text"></oneshort>
								</row>
								<row class="direktrow">
									<onelong class="dyn_inp_wrap"><label_icon class="ui_z"></label_icon><input id="le_frame_words_z" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets" data-numeric="true" data-allowed="px,random,cycle,inherit" data-r="#frame#.words.z"  data-presets_text="$C$px!$I$Inherit!$R$Random {min,max}!$CY$Cycles [val|val|val]" data-presets_val="50px!inherit!{-50,50}![-50|50]" type="text"></onelong>
									<oneshort></oneshort>
								</row>
								<div class="div10"></div>
								<row class="direktrow">
									<onelong class="dyn_inp_wrap"><label_icon class="ui_scalex"></label_icon><input id="le_frame_words_scale_x" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets" data-numeric="true" data-allowed="random,cycle,inherit" data-presets_text="$C$1!$I$Inherit!$R$Random {min,max}!$CY$Cycles [val|val|val]" data-presets_val="1!inherit!{0,2}![0.5|1]" data-r="#frame#.words.scaleX"  data-steps="0.05" type="text"></onelong>
									<oneshort class="dyn_inp_wrap"><label_icon class="ui_scaley"></label_icon><input id="le_frame_words_scale_y" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets" data-numeric="true" data-allowed="random,cycle,inherit" data-presets_text="$C$1!$I$Inherit!$R$Random {min,max}!$CY$Cycles [val|val|val]" data-presets_val="1!inherit!{0,2}![0.5|1]" data-r="#frame#.words.scaleY"  data-steps="0.05" type="text"></oneshort>
								</row>
								<row class="direktrow">
									<onelong class="dyn_inp_wrap"><label_icon class="ui_skewx"></label_icon><input id="le_frame_words_skew_x" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets" data-numeric="true" data-allowed="px,random,cycle,inherit" data-presets_text="$C$px!$I$Inherit!$R$Random {min,max}!$CY$Cycles [val|val|val]" data-presets_val="50px!inherit!{0,2}![-50|50]" data-r="#frame#.words.skewX" data-steps="0.05"  type="text"></onelong>
									<oneshort class="dyn_inp_wrap"><label_icon class="ui_skewy"></label_icon><input id="le_frame_words_skew_y" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets" data-numeric="true" data-allowed="px,random,cycle,inherit" data-presets_text="$C$px!$I$Inherit!$R$Random {min,max}!$CY$Cycles [val|val|val]" data-presets_val="50px!inherit!{0,2}![-50|50]" data-r="#frame#.words.skewY" data-steps="0.05" type="text"></oneshort>
								</row>
								<div class="div10"></div>
								<row class="direktrow">
									<onelong class="dyn_inp_wrap"><label_icon class="ui_rotatex"></label_icon><input id="le_frame_words_rotate_x" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets" data-numeric="true" data-allowed="deg,random,cycle,inherit" data-presets_text="$C$px!$I$Inherit!$R$Random {min,max}!$CY$Cycles [val|val|val]" data-presets_val="50deg!inherit!{-15,15}![-50|50]" data-r="#frame#.words.rotationX" type="text"></onelong>
									<oneshort class="dyn_inp_wrap"><label_icon class="ui_rotatey"></label_icon><input id="le_frame_words_rotate_y" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets " data-numeric="true" data-allowed="deg,random,cycle,inherit" data-presets_text="$C$px!$I$Inherit!$R$Random {min,max}!$CY$Cycles [val|val|val]" data-presets_val="50deg!inherit!{-15,15}![-50|50]" data-r="#frame#.words.rotationY" type="text"></oneshort>
								</row>
								<row class="direktrow">
									<onelong class="dyn_inp_wrap"><label_icon class="ui_rotatez"></label_icon><input id="le_frame_words_rotate_z" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets" data-numeric="true" data-allowed="deg,random,cycle,inherit" data-presets_text="$C$px!$I$Inherit!$R$Random {min,max}!$CY$Cycles [val|val|val]" data-presets_val="50deg!inherit!{-15,15}![-50|50]" data-r="#frame#.words.rotationZ" type="text"></onelong>
									<oneshort></oneshort>
								</row>
								<row class="direktrow">
									<onelong><label_icon class="ui_origox"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px,%,inherit" data-r="#frame#.words.originX" data-min="-3600" data-max="3600" type="text"></onelong>
									<oneshort><label_icon class="ui_origoy"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px,%,inherit" data-r="#frame#.words.originY" data-min="-3600" data-max="3600" type="text"></oneshort>
								</row>
								<row class="direktrow">
									<onelong><label_icon class="ui_origoz"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px,%,inherit" data-r="#frame#.words.originZ" data-min="-3600" data-max="3600" type="text"></onelong>
									<oneshort></oneshort>
								</row>
								<div class="div15"></div>
								<div class="form_inner_header innerwrap_breakout"><i class="material-icons">auto_awesome</i><?php _e('Word Filter', 'revslider');?></div>
								<div class="div15"></div>
								<row class="direktrow">
									<onelong><label_a><?php _e('Use Filter', 'revslider');?></label_a><input type="checkbox" data-showhide="._ltsel_words_filter" data-showhidedep="true" class="layerinput easyinit" data-r="#frame#.words.fuse"/></onelong>
									<oneshort class="_ltsel_words_filter"><label_icon class="ui_blur"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px" data-min="0" data-max="500" data-r="#frame#.words.blur" type="text"></oneshort>									
								</row>
								<row class="direktrow">
									<onelong class="_ltsel_words_filter"><label_icon class="ui_grayscale"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="%" data-min="0" data-max="100" data-r="#frame#.words.grayscale" type="text"></onelong>
									<oneshort class="_ltsel_words_filter"><label_icon class="ui_brightness"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="%" data-min="0" data-max="10000" data-r="#frame#.words.brightness" type="text"></oneshort>
								</row>
								<div class="div15"></div>
								<!-- REVERSE ANIMATIONS -->
								<div class="show_on_frame_0 show_on_frame_999">
									<div class="form_inner_header innerwrap_breakout"><i class="material-icons">settings_ethernet</i><?php _e('Slide Direction based Mirroring', 'revslider');?></div>

									<div class="div15"></div>
									<row class="direktrow">
										<onelong><label_icon class="ui_x"></label_icon><input type="checkbox" class="easyinit layerinput" data-r="#frame#.reverseDirection.wordsX"></onelong>
										<oneshort><label_icon class="ui_y"></label_icon><input type="checkbox" class="easyinit layerinput" data-r="#frame#.reverseDirection.wordsY"></oneshort>
									</row>
									<row>
										<onelong><label_icon class="ui_splitdirection"></label_icon><input type="checkbox" class="easyinit layerinput" data-r="#frame#.reverseDirection.wordsDirection"></onelong>
										<oneshort></oneshort>
									</row>
								</div>
							</div>
						</div>
						<!-- LINES TRANSFORMATIONS -->
						<div id="lines_transsettings" class="group_transsettings" style="display:none">
							<label_a><?php _e('Split Lines', 'revslider');?></label_a><input type="checkbox" data-showhide="#_ltsel_line" data-showhidedep="true" class="layerinput easyinit callEvent" data-evt="checkEnterFrameLevels" data-r="#frame#.lines.use" />
							<div id="_ltsel_line">
								<row class="direktrow nosfxanim hide_on_frame_0">
									<onelong><label_icon class="ui_splitdirection"></label_icon><select data-theme="min120" id="le_frame_lines_txtsplitdirection" class="layerinput tos2 nosearchbox easyinit" data-r="#frame#.lines.direction"><option value="forward"><?php _e('Forward', 'revslider');?></option><option value="backward"><?php _e('Backward', 'revslider');?></option><option value="middletoedge"><?php _e('Middle To Edge', 'revslider');?></option><option value="edgetomiddle"><?php _e('Edge to Middle', 'revslider');?></option><option value="random"><?php _e('Random', 'revslider');?></option></select></onelong>
									<oneshort><label_icon class="ui_splitdelay"></label_icon><input data-numeric="true"  id="le_frame_lines_splitdelay" class="layerinput valueduekeyboard smallinput easyinit callEvent"  data-evt="updateLayerFrame" data-allowed="" data-r="#frame#.lines.delay" data-min="0" data-max="99999" type="text"></oneshort>
									<label_icon class="ui_easing_in singlerow"></label_icon><select id="lines_appear_ease" class="layerinput tos2 nosearchbox easyinit easingSelect" data-inherit="true" data-r="#frame#.lines.ease"></select>
								</row>
								<label_icon class="ui_opacity singlerow"></label_icon><input id="le_frame_lines_opacity" class="layerinput valueduekeyboard smallinput easyinit input_with_presets" data-numeric="true" data-allowed="inherit,random" data-presets_text="$I$Inherit!$R$Random {min,max}!$C$Custom" data-presets_val="inherit!{0,1}!0.5" data-r="#frame#.lines.opacity" data-min="0" data-max="1" data-steps="0.05" type="text">
								<div class="div10"></div>
								<row class="direktrow">
									<onelong class="dyn_inp_wrap"><label_icon class="ui_x"></label_icon><input data-numeric="true" id="le_frame_lines_x" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets"  data-allowed="px,%,random,cycle,left,right,center,inherit" data-responsive="true" data-r="#frame#.lines.x.#size#.v"  data-presets_text="$C$px!$C$%!$I$Inherit!$R$Random {min,max}!$SL$Wrapper Left!$SR$Wrapper Right!$BV$Wrapper Center!$CY$Cycles [val|val|val]" data-presets_val="50px!100%!inherit!{-20,20}!left!right!center![-50|50]" type="text"></onelong>
									<oneshort class="dyn_inp_wrap"><label_icon class="ui_y"></label_icon><input data-numeric="true"  id="le_frame_lines_y" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets"  data-allowed="px,%,random,cycle,top,bottom,middle,inherit,center" data-responsive="true" data-r="#frame#.lines.y.#size#.v" data-presets_text="$C$px!$C$%!$I$Inherit!$R$Random {min,max}!$ST$Wrapper Top!$SB$Wrapper Bottom!$BH$Wrapper Middle!$CY$Cycles [val|val|val]" data-presets_val="50px!100%!inherit!{-20,20}!top!bottom!center![-50|50]" type="text"></oneshort>
								</row>
								<row class="direktrow">
									<onelong class="dyn_inp_wrap"><label_icon class="ui_z"></label_icon><input id="le_frame_lines_z" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets" data-numeric="true" data-allowed="px,random,cycle,inherit" data-r="#frame#.lines.z"  data-presets_text="$C$px!$I$Inherit!$R$Random {min,max}!$CY$Cycles [val|val|val]" data-presets_val="50px!inherit!{-20,20}![-50|50]" type="text"></onelong>
									<oneshort></oneshort>
								</row>
								<div class="div10"></div>
								<row class="direktrow">
									<onelong class="dyn_inp_wrap"><label_icon class="ui_scalex"></label_icon><input id="le_frame_lines_scale_x" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets" data-numeric="true" data-allowed="random,cycle,inherit" data-presets_text="$C$1!$I$Inherit!$R$Random {min,max}!$CY$Cycles [val|val|val]" data-presets_val="1!inherit!{0,2}![0.5|1]" data-r="#frame#.lines.scaleX" data-steps="0.05" type="text"></onelong>
									<oneshort class="dyn_inp_wrap"><label_icon class="ui_scaley"></label_icon><input id="le_frame_lines_scale_y" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets" data-numeric="true" data-allowed="random,cycle,inherit" data-presets_text="$C$1!$I$Inherit!$R$Random {min,max}!$CY$Cycles [val|val|val]" data-presets_val="1!inherit!{0,2}![0.5|1]" data-r="#frame#.lines.scaleY" data-steps="0.05" type="text"></oneshort>
								</row>
								<row class="direktrow">
									<onelong class="dyn_inp_wrap"><label_icon class="ui_skewx"></label_icon><input id="le_frame_lines_skew_x" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets" data-numeric="true" data-allowed="px,random,cycle,inherit" data-presets_text="$C$px!$I$Inherit!$R$Random {min,max}!$CY$Cycles [val|val|val]" data-presets_val="50px!inherit!{0,2}![-50|50]" data-r="#frame#.lines.skewX" data-steps="0.05" type="text"></onelong>
									<oneshort class="dyn_inp_wrap"><label_icon class="ui_skewy"></label_icon><input id="le_frame_lines_skew_y" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets" data-numeric="true" data-allowed="px,random,cycle,inherit" data-presets_text="$C$px!$I$Inherit!$R$Random {min,max}!$CY$Cycles [val|val|val]" data-presets_val="50px!inherit!{0,2}![-50|50]" data-r="#frame#.lines.skewY" data-steps="0.05" type="text"></oneshort>
								</row>
								<div class="div10"></div>
								<row class="direktrow">
									<onelong class="dyn_inp_wrap"><label_icon class="ui_rotatex"></label_icon><input id="le_frame_lines_rotate_x" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets" data-numeric="true" data-allowed="deg,random,cycle,inherit" data-presets_text="$C$px!$I$Inherit!$R$Random {min,max}!$CY$Cycles [val|val|val]" data-presets_val="50deg!inherit!{-15,15}![-50|50]" data-r="#frame#.lines.rotationX" type="text"></onelong>
									<oneshort class="dyn_inp_wrap"><label_icon class="ui_rotatey"></label_icon><input id="le_frame_lines_rotate_y" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets " data-numeric="true" data-allowed="deg,random,cycle,inherit" data-presets_text="$C$px!$I$Inherit!$R$Random {min,max}!$CY$Cycles [val|val|val]" data-presets_val="50deg!inherit!{-15,15}![-50|50]" data-r="#frame#.lines.rotationY" type="text"></oneshort>
								</row>
								<row class="direktrow">
									<onelong class="dyn_inp_wrap"><label_icon class="ui_rotatez"></label_icon><input id="le_frame_lines_rotate_z" class="rsdyn_inp layerinput valueduekeyboard smallinput easyinit input_with_presets" data-numeric="true" data-allowed="deg,random,cycle,inherit" data-presets_text="$C$px!$I$Inherit!$R$Random {min,max}!$CY$Cycles [val|val|val]" data-presets_val="50deg!inherit!{-15,15}![-50|50]" data-r="#frame#.lines.rotationZ" type="text"></onelong>
									<oneshort></oneshort>
								</row>
								<row class="direktrow">
									<onelong><label_icon class="ui_origox"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px,%,inherit" data-r="#frame#.lines.originX" data-min="-3600" data-max="3600" type="text"></onelong>
									<oneshort><label_icon class="ui_origoy"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px,%,inherit" data-r="#frame#.lines.originY" data-min="-3600" data-max="3600" type="text"></oneshort>
								</row>
								<row class="direktrow">
									<onelong><label_icon class="ui_origoz"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px,%,inherit" data-r="#frame#.lines.originZ" data-min="-3600" data-max="3600" type="text"></onelong>
									<oneshort></oneshort>
								</row>
								<div class="div15"></div>
								<div class="form_inner_header innerwrap_breakout"><i class="material-icons">auto_awesome</i><?php _e('Line Filter', 'revslider');?></div>
								<div class="div15"></div>
								<row class="direktrow">
									<onelong><label_a><?php _e('Use Filter', 'revslider');?></label_a><input type="checkbox" data-showhide="._ltsel_lines_filter" data-showhidedep="true" class="layerinput easyinit" data-r="#frame#.lines.fuse"/></onelong>
									<oneshort class="_ltsel_lines_filter"><label_icon class="ui_blur"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px" data-min="0" data-max="500" data-r="#frame#.lines.blur" type="text"></oneshort>									
								</row>
								<row class="direktrow">
									<onelong class="_ltsel_lines_filter"><label_icon class="ui_grayscale"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="%" data-min="0" data-max="100" data-r="#frame#.lines.grayscale" type="text"></onelong>
									<oneshort class="_ltsel_lines_filter"><label_icon class="ui_brightness"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="%" data-min="0" data-max="10000" data-r="#frame#.lines.brightness" type="text"></oneshort>
								</row>
								<div class="div15"></div>
								<!-- REVERSE ANIMATIONS -->
								<div class="show_on_frame_0 show_on_frame_999">
									<div class="form_inner_header innerwrap_breakout"><i class="material-icons">settings_ethernet</i><?php _e('Slide Direction based Mirroring', 'revslider');?></div>

									<div class="div15"></div>
									<row class="direktrow">
										<onelong><label_icon class="ui_x"></label_icon><input type="checkbox" class="easyinit layerinput" data-r="#frame#.reverseDirection.linesX"></onelong>
										<oneshort><label_icon class="ui_y"></label_icon><input type="checkbox" class="easyinit layerinput" data-r="#frame#.reverseDirection.linesY"></oneshort>
									</row>
									<row>
										<onelong><label_icon class="ui_splitdirection"></label_icon><input type="checkbox" class="easyinit layerinput" data-r="#frame#.reverseDirection.linesDirection"></onelong>
										<oneshort></oneshort>
									</row>
								</div>
							</div>
						</div>
						

						<!-- COLOR TRANSFORMATIONS-->
						<div id="color_transsettings" class="group_transsettings" style="display:none">

							<label_a><?php _e('Text', 'revslider');?></label_a><input type="checkbox" data-showhide="._ltsel_color" data-showhidedep="true" class="layerinput callEvent easyinit" data-evt="checkEnterFrameLevels" data-r="#frame#.color.use"/>
							<div class="_ltsel_color">
								<label_a><?php _e('Color', 'revslider');?></label_a><input type="text" data-editing="Frame Color Animation" data-mode="single" name="frameColorAnimation" id="frameColorAnimation" class="my-color-field layerinput easyinit" data-visible="true" data-r="#frame#.color.color" value="transparent">
								<div class="div20"></div>
							</div>
							<div class="linebreak"></div>
							<label_a><?php _e('Background', 'revslider');?></label_a><input type="checkbox" data-showhide="._ltsel_bgcolor" data-showhidedep="true" class="layerinput callEvent easyinit" data-evt="checkEnterFrameLevels" data-r="#frame#.bgcolor.use"/>
							<div class="_ltsel_bgcolor">
								<label_a><?php _e('Color', 'revslider');?></label_a><input type="text" data-editing="Frame BG Color Animation" name="frameBGColorAnimation" id="frameBGColorAnimation" class="my-color-field layerinput easyinit" data-visible="true" data-r="#frame#.bgcolor.backgroundColor" value="transparent">
							</div>
						</div>

						<!-- LAYER FRAME TRANSFORM -->
						<div id="sfx_transsettings" class="group_transsettings" style="display:none">
							<label_a><?php _e('Effect', 'revslider');?></label_a><select id="layer_frame_sfx" class="layerinput easyinit nosearchbox tos2"  data-show=".sfx_*val*" data-hide=".sfx_allparameters" data-r="#frame#.sfx.effect"><option value="none"><?php _e('No Special Effect', 'revslider');?></option><option value="blocktoleft"><?php _e('Block to Left', 'revslider');?></option><option value="blocktoright"><?php _e('Block to Right', 'revslider');?></option><option value="blocktotop"><?php _e('Block to Top', 'revslider');?></option><option value="blocktobottom"><?php _e('Block to Bottom', 'revslider');?></option></select>
							<div class="sfx_blocktoleft sfx_blocktoright sfx_blocktotop sfx_blocktobottom sfx_allparameters">
								<label_a><?php _e('Block Color', 'revslider');?></label_a><input type="text" data-editing="SFX Color Animation" data-mode="single" name="sfxColorAnimation" id="sfxColorAnimation" class="my-color-field layerinput easyinit" data-visible="true" data-r="#frame#.sfx.color" value="transparent">
							</div>
						</div>
					</div>
				</div>


			</div>
		</div>

	</div><!-- END OF LAYER ANIMAION CONTAINER -->

	<!-- LAYER ANIMATION CONTAINER -->
	<div class="form_collector layer_settings_collector" data-type="layersconfig" data-pcontainer="#layer_settings" data-offset="#rev_builder_wrapper">
		<div id="form_layer_loop"  class="formcontainer form_menu_inside collapsed" data-select="#gst_layer_15" data-unselect=".layer_submodule_trigger">
			<div id="form_layer_loop_innerwrap">
				<!--<div class="collectortabwrap"><div id="collectortab_form_layer_loop" class="collectortab form_menu_inside" data-forms='["#form_layer_loop"]'><i class="material-icons">loop</i><?php _e('Animation', 'revslider');?></div></div>		-->


				<!-- LAYER CONTENT LOOP ANIMATION -->
				<div id="form_animation_sloop" class="form_inner open">
					<div id="layer_looping_wrap">
						<div class="form_inner_header"><i class="material-icons">loop</i><?php _e('Layer Loop Animations', 'revslider');?></div>
						<div class="collapsable" style="display:block !important">
							<div class="div15"></div><!--					
							--><div id="la_looping-tab-1" class="settingsmenu_wrapbtn"><div data-inside="#layer_looping_wrap" data-evt="showhidelayerlooping" data-evtparam="timeline" data-showssm="#la_looping_timeline" class="ssmbtn selected"><?php _e('Timeline', 'revslider');?></div></div><!--
							--><div id="la_looping-tab-2" class="settingsmenu_wrapbtn"><div data-inside="#layer_looping_wrap" data-evt="showhidelayerlooping" data-evtparam="effects" data-showssm="#la_looping_effects" class="ssmbtn"><?php _e('Effects', 'revslider');?></div></div><!--						
							--><div class="div25"></div>
							<div id="la_looping_timeline" class="ssm_content selected">
								<longoption><label_a><?php _e('Enable Timeline Loops', 'revslider');?></label_a><input type="checkbox"  class="layerinput easyinit callEvent" data-evt="updateLayerLoopTimelineframes" data-evtparam="updateAllLayerFrames" data-showhide="#layer_timelineloop_animation" data-showhidedep="true"  data-r="timeline.tloop.use"/></longoption>
							</div>
							<div id="la_looping_effects" class="ssm_content">
								<longoption><label_a><?php _e('Enable Loop Effects', 'revslider');?></label_a><input type="checkbox"  class="layerinput easyinit" data-showhide="#all_layer_loop_animation,#layer_simulator_loop" data-showhidedep="true"  data-r="timeline.loop.use"/></longoption>
							</div>
						</div>
					</div>
				</div>

				<!-- LAYER LOOPING TIMELINE  -->
				<div id="layer_timelineloop_animation"> 
					<div id="la_loopings_tab_timeline" class="la_loopings_tab selected">
						<div id="form_layer_loop_timeline" class="form_inner open">
							<div class="form_inner_header"><i class="material-icons">repeat_one</i><?php _e('Layer Timeline Loop', 'revslider');?></div>															
							<div class="collapsable">
								<label_a><?php _e('Start Frame', 'revslider');?></label_a><select id="la_timeline_loop_from" class="layerinput easyinit nosearchbox tos2 callEvent" data-evt="updateAllLayerFrames" data-r="timeline.tloop.from"></select><span class="linebreak"></span>
								<label_a><?php _e('End Frame', 'revslider');?></label_a><select id="la_timeline_loop_to" class="layerinput easyinit nosearchbox tos2 callEvent" data-evt="updateAllLayerFrames"  data-r="timeline.tloop.to"></select><span class="linebreak"></span>
								<label_a><?php _e('Loop Amount', 'revslider');?></label_a><input id="la_timeline_loop_amnt" class="layerinput valueduekeyboard smallinput easyinit input_with_presets" data-numeric="true" data-allowed="" data-presets_text="$C$Infinity!$C$1!$C$2!$C$5" data-presets_val="-1!1!2!5" data-r="timeline.tloop.repeat" type="text"><span class="linebreak"></span>
								<longoption><label_a><?php _e('Animate to "Start" in Loop', 'revslider');?></label_a><input type="checkbox"  class="layerinput easyinit"  data-r="timeline.tloop.keep"/></longoption>
								<longoption class="_shfg_ _shfc_ _shfr_"><label_a><?php _e('Reset Children Timeline', 'revslider');?></label_a><input type="checkbox"  class="layerinput easyinit"  data-r="timeline.tloop.children"/></longoption>
								<div class="_shfg_ _shfc_ _shfr_">
									<div class="div25"></div>
									<row class="direktrow">
										<labelhalf style="width:40px"><i class="material-icons vmi">sms_failed</i></labelhalf>
										<contenthalf style="width:250px"><div class="function_info"><?php _e('Restriction !<br>Children Layers of Group, Column and Row will simply restart, without animation from the last loop Frame to first loop frame, independent of the Animate to "start" in Loop enabled option.', 'revslider');?></div></contenthalf>
									</row>
								</div>
							</div>
						</div>
					</div>
				</div>


				<!-- LAYER LOOPING EFFECTS  -->
				<div id="all_layer_loop_animation"> 
					<div id="la_loopings_tab_effects" class="la_loopings_tab" style="display:none">
						<div id="form_layer_loop_effect" class="form_inner open">
							<div class="form_inner_header"><i class="material-icons">mouse</i><?php _e('Layer Looping Effects', 'revslider');?></div>								
							<div class="load_anim_value_wrap">
								<div class="div15"></div>
								<!-- QUICK ANIMATION PICKER-->
								<div class="layer_transliste"><div class="layer_transliste_head"><span class="frame_list_id">LOOP</span><span class="frame_list_title" id="layer_trans_curr_name_loop"><?php _e('Load Loop Template', 'revslider');?></span><i class="right-divided-icon material-icons">arrow_drop_down</i></div><div id="layer_transliste_loop" class="layer_transliste_inner"></div></div>
							</div>
							<div class="collapsable">
								<row class="direktrow">
									<div id="layer_simulator_loop" data-states="play,stop" data-start_state="play" data-stop="previewLayerAnimation" data-stop_state="" data-stop_icon="stop" data-play="previewStopLayerAnimation"  data-play_state="" data-play_icon="play_arrow" class="rightbutton basic_action_button onlyicon switch_button"><i class="switch_button_icon material-icons"></i><span class="switch_button_state"></span></div>
									<onelong><label_icon class="ui_easing_in"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit callEvent" data-evt="updateLayerFrame" data-numeric="true" data-allowed="" data-r="timeline.loop.start" data-min="0" data-max="99999" data-steps="10" type="text"></onelong>
									<oneshort><label_icon class="ui_duration"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit callEvent" data-evt="updateLayerFrame" data-numeric="true" data-allowed="" data-r="timeline.loop.speed" data-min="0" data-max="99999" data-steps="10" type="text"></oneshort>
								</row>

								<label_icon class="ui_easing singlerow"></label_icon><select id="le_frame_ease_loop" class="layerinput tos2 nosearchbox easyinit easingSelect" data-r="timeline.loop.ease"></select>
								<div class="div10"></div>
								<row class="direktrow">
									<onelong><label_icon class="ui_origox"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px,%" data-r="timeline.loop.originX" data-min="-3600" data-max="3600" type="text"></onelong>
									<oneshort><label_icon class="ui_origoy"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px,%" data-r="timeline.loop.originY" data-min="-3600" data-max="3600" type="text"></oneshort>
								</row>
								<row>
									<onelong><label_icon class="ui_origoz"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px,%" data-r="timeline.loop.originZ" data-min="-3600" data-max="3600" type="text"></onelong>
									<oneshort></oneshort>
								</row>

								<div class="div10"></div>

								<div id="layer_loop_settings" class="loop_wrapbrtn"><div data-showloop="#loop_move_settings" data-frametarget="mask" class="looptarget_selector selected"><?php _e('Move', 'revslider');?></div></div><!--
								--><div class="loop_wrapbrtn"><div data-showloop="#loop_scale_settings" data-frametarget="filter" class="looptarget_selector" ><?php _e('Scale', 'revslider');?></div></div><!--
								--><div class="loop_wrapbrtn"><div data-showloop="#loop_rotate_settings" data-frametarget="color" class="looptarget_selector" ><?php _e('Rotate', 'revslider');?></div></div><!--
								--><div class="loop_wrapbrtn"><div data-showloop="#loop_filter_settings" data-frametarget="color" class="looptarget_selector" ><?php _e('Filter', 'revslider');?></div></div>
								<div class="div25"></div>

								<!-- LAYER LOOP ANIMATIONTRANSFORMATIONS -->

								<div id="loop_move_settings" class="group_loopsettings" style="display:block">
									<row><onelong><label_a><?php _e('Yoyo', 'revslider');?></label_a><input class="easyinit layerinput"  type="checkbox" data-r="timeline.loop.yoyo_move"></onelong><oneshort></oneshort></row>
									<row class="direktrow">
										<onelong><label_icon class="ui_x"></label_icon><input data-numeric="true" class="layerinput valueduekeyboard smallinput easyinit"  data-allowed="px,%" data-r="timeline.loop.frame_0.x"  d type="text"></onelong>
										<oneshort><input data-numeric="true" class="layerinput valueduekeyboard smallinput easyinit"  data-allowed="px,%" data-r="timeline.loop.frame_999.x"  d type="text"></oneshort>
									</row>
									<row class="direktrow">
										<onelong><label_icon class="ui_y"></label_icon><input data-numeric="true"  class="layerinput valueduekeyboard smallinput easyinit"  data-allowed="px,%" data-r="timeline.loop.frame_0.y"  type="text"></onelong>
										<oneshort><input data-numeric="true"  class="layerinput valueduekeyboard smallinput easyinit"  data-allowed="px,%" data-r="timeline.loop.frame_999.y"  type="text"></oneshort>
									</row>
									<row class="direktrow">
										<onelong><label_icon class="ui_z"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px" data-r="timeline.loop.frame_0.z"  type="text"></onelong>
										<oneshort><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px" data-r="timeline.loop.frame_999.z"  type="text"></oneshort>
									</row>
									<div class="div15"></div>
									<label_a><?php _e('Curved', 'revslider');?></label_a><input type="checkbox" data-showhide="#curved_loop_settings" data-showhidedep="true" class="layerinput easyinit" data-r="timeline.loop.curved" /><div class="linebreak"></div>
									<div id="curved_loop_settings">
										<label_a><?php _e('Auto Rotate', 'revslider');?></label_a><input type="checkbox" class="layerinput easyinit" data-r="timeline.loop.autoRotate" /><div class="linebreak"></div>
										<row >
											<onelong><label_icon class="ui_startangle"></label_icon><select id="le_loop_startangle" class="layerinput tos2 nosearchbox easyinit" data-r="timeline.loop.radiusAngle"><option value="0">0 Degree</option><option value="1">90 Degree</option><option value="2">180 Degree</option><option value="3">270 Degree</option></select></onelong>
											<oneshort><label_icon class="ui_curviness"></label_icon><input data-numeric="true" class="layerinput valueduekeyboard smallinput easyinit"  data-allowed="" data-r="timeline.loop.curviness"  d type="text"></oneshort>
										</row>
										<row class="direktrow">
											<onelong><label_icon class="ui_xradius"></label_icon><input data-numeric="true" class="layerinput valueduekeyboard smallinput easyinit"  data-allowed="px,%" data-r="timeline.loop.frame_0.xr"  d type="text"></onelong>
											<oneshort><input data-numeric="true" class="layerinput valueduekeyboard smallinput easyinit"  data-allowed="px" data-r="timeline.loop.frame_999.xr"  d type="text"></oneshort>
										</row>
										<row class="direktrow">
											<onelong><label_icon class="ui_yradius"></label_icon><input data-numeric="true"  class="layerinput valueduekeyboard smallinput easyinit"  data-allowed="px,%" data-r="timeline.loop.frame_0.yr"  type="text"></onelong>
											<oneshort><input data-numeric="true"  class="layerinput valueduekeyboard smallinput easyinit"  data-allowed="px" data-r="timeline.loop.frame_999.yr"  type="text"></oneshort>
										</row>
										<row class="direktrow">
											<onelong><label_icon class="ui_zradius"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px" data-r="timeline.loop.frame_0.zr"  type="text"></onelong>
											<oneshort><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px" data-r="timeline.loop.frame_999.zr"  type="text"></oneshort>
										</row>
									</div>
								</div>
								<div id="loop_scale_settings" class="group_loopsettings">
									<row><onelong><label_icon class="ui_yoyo"></label_icon><input class="easyinit layerinput"  type="checkbox" data-r="timeline.loop.yoyo_scale"></onelong><oneshort></oneshort></row>
									<row class="direktrow">
										<onelong><label_icon class="ui_scalex"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="" data-r="timeline.loop.frame_0.scaleX"  type="text"></onelong>
										<oneshort><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="" data-r="timeline.loop.frame_999.scaleX"  type="text"></oneshort>
									</row>
									<row>
										<onelong><label_icon class="ui_scaley"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="" data-r="timeline.loop.frame_0.scaleY"  type="text"></onelong>
										<oneshort><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="" data-r="timeline.loop.frame_999.scaleY"  type="text"></oneshort>
									</row>
									<row class="direktrow">
										<onelong><label_icon class="ui_skewx"></label_icon><input  class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="" data-r="timeline.loop.frame_0.skewX"  type="text"></onelong>
										<oneshort><input  class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="" data-r="timeline.loop.frame_999.skewX"  type="text"></oneshort>
									</row>
									<row class="direktrow">
										<onelong><label_icon class="ui_skewy"></label_icon><input  class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="" data-r="timeline.loop.frame_0.skewY"  type="text"></onelong>
										<oneshort><input  class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="" data-r="timeline.loop.frame_999.skewY"  type="text"></oneshort>
									</row>
								</div>
								<div id="loop_rotate_settings" class="group_loopsettings">
									<row><onelong><label_icon class="ui_yoyo"></label_icon><input class="easyinit layerinput"  type="checkbox" data-r="timeline.loop.yoyo_rotate"></onelong><oneshort></oneshort></row>
									<row class="direktrow">
										<onelong><label_icon class="ui_rotatex"></label_icon><input  class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="deg" data-r="timeline.loop.frame_0.rotationX" type="text"></onelong>
										<oneshort><input  class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="deg" data-r="timeline.loop.frame_999.rotationX" type="text"></oneshort>
									</row>
									<row class="direktrow">
										<onelong><label_icon class="ui_rotatey"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit " data-numeric="true" data-allowed="deg" data-r="timeline.loop.frame_0.rotationY" type="text"></onelong>
										<oneshort><input class="layerinput valueduekeyboard smallinput easyinit " data-numeric="true" data-allowed="deg" data-r="timeline.loop.frame_999.rotationY" type="text"></oneshort>
									</row>
									<row class="direktrow">
										<onelong><label_icon class="ui_rotatez"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="deg" data-r="timeline.loop.frame_0.rotationZ" type="text"></onelong>
										<oneshort><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="deg" data-r="timeline.loop.frame_999.rotationZ" type="text"></oneshort>
									</row>
								</div>
								<div id="loop_filter_settings" class="group_loopsettings">
									<row><onelong><label_icon class="ui_yoyo"></label_icon><input class="easyinit layerinput"  type="checkbox" data-r="timeline.loop.yoyo_filter"></onelong><oneshort></oneshort></row>
									<row class="direktrow">
										<onelong><label_icon class="ui_opacity singlerow"></label_icon><input  class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="" data-r="timeline.loop.frame_0.opacity" data-min="0" data-max="1" data-steps="0.05" type="text"></onelong>
										<oneshort><input  class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="" data-r="timeline.loop.frame_999.opacity" data-min="0" data-max="1" data-steps="0.05" type="text"></oneshort>
									</row>
									<row class="direktrow">
										<onelong><label_icon class="ui_blur"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px" data-min="0" data-max="500" data-r="timeline.loop.frame_0.blur" type="text"></onelong>
										<oneshort><label_icon class="ui_blur"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="px" data-min="0" data-max="500" data-r="timeline.loop.frame_999.blur" type="text"></oneshort>
									</row>
									<row class="direktrow">
										<onelong><label_icon class="ui_grayscale"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="%" data-min="0" data-max="100" data-r="timeline.loop.frame_0.grayscale" type="text"></onelong>
										<oneshort><label_icon class="ui_grayscale"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="%" data-min="0" data-max="100" data-r="timeline.loop.frame_999.grayscale" type="text"></oneshort>
									</row>

									<row class="direktrow">
										<onelong><label_icon class="ui_brightness"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="%" data-min="0" data-max="10000" data-r="timeline.loop.frame_0.brightness" type="text"></onelong>
										<oneshort><label_icon class="ui_brightness"></label_icon><input class="layerinput valueduekeyboard smallinput easyinit" data-numeric="true" data-allowed="%" data-min="0" data-max="10000" data-r="timeline.loop.frame_999.brightness" type="text"></oneshort>
									</row>
								</div>							
							</div>
						</div>
					</div>
				</div><!-- END OF LOOP ANIMATION -->
			</div>
		</div>
	</div><!-- END OF LOOP CONTAINER -->


	<!-- LAYER PRESETS CONTAINER -->
	<div class="form_collector layer_settings_collector" data-type="layersconfig" data-pcontainer="#layer_settings" data-offset="#rev_builder_wrapper">
		<div id="form_layer_presets"  class="formcontainer form_menu_inside collapsed" data-select="#gst_layer_12" data-unselect=".layer_submodule_trigger">
			<!--<div class="collectortabwrap"><div id="collectortab_form_layer_presets" class="collectortab form_menu_inside" data-forms='["#form_layer_presets"]'><i class="material-icons">save</i><?php _e('Presets', 'revslider');?></div></div>		-->

			<!-- LAYER PRESET HANDLINGS -->
			<div class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">save</i><?php _e('Presets', 'revslider');?></div>
				<div class="collapsable">
				</div>
			</div>

		</div>
	</div>
</div><!-- END OF LAYER SETTINGS -->



