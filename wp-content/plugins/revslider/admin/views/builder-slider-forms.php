<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2019 ThemePunch
 */

if(!defined('ABSPATH')) exit();

$rs_f = RevSliderGlobals::instance()->get('RevSliderFunctions');
//$rs_info	= new RevSliderSliderInfo($slider_id);

// GET POST TYPED AND CATEGORIES
$post_types_with_categories = $rs_f->get_post_types_with_categories_for_client();
$json_tax_with_cats = $rs_f->json_encode_client_side($post_types_with_categories);
$post_type = $rs_f->get_post_type_assoc();

// GET LATEST RECENT POSTS AND POPULAR POSTS
$uslider = new RevSliderSlider();
$pop_posts = $uslider->get_popular_posts(15);
$rec_posts = $uslider->get_latest_posts(15);
$recent = array();
$popular = array();
if (!empty($pop_posts)) {
	foreach ($pop_posts as $p_post) {
		$popular[] = $p_post['ID'];
	}
}
if (!empty($rec_posts)) {
	foreach ($rec_posts as $r_post) {
		$recent[] = $r_post['ID'];
	}
}
$wc_sortby = RevSliderWooCommerce::getArrSortBy();

$api = 'revapi'; // . $slider_id;

?>

<!-- THE LIST OF TAXONOMIES AND CATEGORIES -->
<script>
	RVS.LIB.POST_TYPES_CAT = JSON.parse(<?php echo $json_tax_with_cats; ?>);
</script>

<!-- UNDERLAYS FOR MODALS -->
<div id="__inmodal_formcontainerunderlay"></div>

<!-- SLIDER SETTINGS -->
<div id="slider_settings" data-root="settings.">

	<div class="form_collector slider_general_collector" data-type="sliderconfig" data-pcontainer="#slider_settings" data-offset="#rev_builder_wrapper">
		<div class="main_mode_breadcrumb_wrap"><div class="main_mode_submode"><?php _e('Module General Options', 'revslider');?></div></div>
		<div id="gst_sl_collector" class="gso_wrap">
			<div id="gst_sl_1" class="general_submodule_trigger opensettingstrigger selected" data-select="#gst_sl_1" data-unselect=".general_submodule_trigger" data-collapse="true" data-forms='["#form_module_title"]'><i class="material-icons">title</i><span class="gso_title"><?php _e('Title', 'revslider');?></span></div><!--
			--><div id="gst_sl_2" data-select="#gst_sl_2" data-unselect=".general_submodule_trigger" class="general_submodule_trigger opensettingstrigger" data-collapse="true" data-forms='["#form_sliderlayout"]'><i class="material-icons">devices</i><span class="gso_title"><?php _e('Layout', 'revslider');?></span></div><!--
			--><div id="gst_sl_3" data-select="#gst_sl_3" data-unselect=".general_submodule_trigger" class="general_submodule_trigger opensettingstrigger carouselavailable standardunavailable sceneunavailable" data-collapse="true" data-forms='["#form_module_carousel"]'><i class="material-icons">view_carousel</i><span class="gso_title"><?php _e('Carousel', 'revslider');?></span></div><!--
			--><div id="gst_sl_4" data-select="#gst_sl_4" data-unselect=".general_submodule_trigger" class="general_submodule_trigger opensettingstrigger" data-collapse="true" data-forms='["#form_slidercontent"]'><i class="material-icons">message</i><span class="gso_title"><?php _e('Content', 'revslider');?></span></div><!--
			--><div id="gst_sl_5" data-select="#gst_sl_5" data-unselect=".general_submodule_trigger" class="general_submodule_trigger opensettingstrigger" data-collapse="true" data-forms='["#form_module_default"]'><i class="material-icons">dns</i><span class="gso_title"><?php _e('Defaults', 'revslider');?></span></div><!--
			--><div id="gst_sl_6" data-select="#gst_sl_6" data-unselect=".general_submodule_trigger" class="general_submodule_trigger opensettingstrigger" data-collapse="true" data-forms='["#form_module_general_settings"]'><i class="material-icons">build</i><span class="gso_title"><?php _e('General', 'revslider');?></span></div><!--
			--><div id="gst_sl_8" data-select="#gst_sl_8" data-unselect=".general_submodule_trigger" class="general_submodule_trigger opensettingstrigger" data-collapse="true" data-forms='["#form_module_scroll"]'><i class="material-icons">system_update_alt</i><span class="gso_title"><?php _e('On Scroll', 'revslider');?></span></div><!--
			--><div id="gst_sl_12" data-select="#gst_sl_12" data-unselect=".general_submodule_trigger" class="general_submodule_trigger opensettingstrigger" data-collapse="true" data-forms='["#form_sliderspinner"]'><i class="material-icons">loop</i><span class="gso_title"><?php _e('Spinner', 'revslider');?></span></div><!--
			--><div id="gst_sl_9" class="callEvent general_submodule_trigger opensettingstrigger" data-evt="openAddonModal"><i class="material-icons">extension</i><span class="gso_title"><?php _e('Addons', 'revslider');?></span></div><!--
			--><div id="gst_sl_10" data-select="#gst_sl_10" data-unselect=".general_submodule_trigger" class="general_submodule_trigger opensettingstrigger" data-collapse="true" data-forms='["#form_module_advanced"]'><i class="material-icons">timeline</i><span class="gso_title"><?php _e('Advanced', 'revslider');?></span></div><!--
			--><div id="gst_sl_11" class="callEvent general_submodule_trigger openmodaltrigger" data-evt="openSliderApi"><i class="material-icons">code</i><span class="gso_title">CSS/jQuery</span></div><!--
			--><div id="gst_sl_13" data-select="#gst_sl_13" data-unselect=".general_submodule_trigger" class="general_submodule_trigger opensettingstrigger" data-collapse="true" data-forms='["#form_slider_as_modal"]'><i class="material-icons">picture_in_picture</i><span class="gso_title"><?php _e('As Modal', 'revslider');?></span></div><!--
			--><div id="gst_sl_14" class="callEvent general_submodule_trigger openmodaltrigger" data-evt="openColorSkinApi"><i class="material-icons">format_paint</i><span class="gso_title"><?php _e('Skin', 'revslider');?></span></div>
		</div>
	</div>

	<!-- MODULE TITLE -->
	<div class="form_collector slider_general_collector" data-type="sliderconfig" data-pcontainer="#slider_settings" data-offset="#rev_builder_wrapper">
		<div id="form_module_title"  data-select="#gst_sl_1"  class="formcontainer form_menu_inside">
			<!-- MODULE TITLE AND ALIAS AND SHORTCODE SETTINGS-->
			<div class="form_inner">
				<div class="form_inner_header"><i class="material-icons">title</i><?php _e('Module Naming', 'revslider');?></div>
				<div id="" class="collapsable" style="display:block !important">
					<label_a><?php _e('Title', 'revslider');?></label_a><input type="text" id="sr_title" class="sliderinput easyinit" data-r="title" placeholder="<?php _e('Enter a Module name', 'revslider')?>"/><span class="linebreak"></span>
					<label_a><?php _e('Alias', 'revslider');?></label_a><input type="text" id="sr_alias" data-evt="updateShortCode" class="sliderinput easyinit" data-r="alias" placeholder="<?php _e('enter-a-module-name', 'revslider')?>"/><span class="linebreak"></span>
					<label_a id="rs_shortcode_label"><?php _e('Shortcode', 'revslider');?></label_a><input readonly type="text" id="sr_shortcode" class="sliderinput easyinit" data-r="shortcode"/><span class="linebreak"></span>
					<label_a></label_a><div class="basic_action_button longbutton copyclipboard" data-clipboard-action="copy" data-clipboard-target="#sr_shortcode"><i class="material-icons">content_copy</i><?php _e('Copy Shortcode', 'revslider');?></div>
					<div class="div10"></div>
					<row class="direktrow">
						<labelhalf><i class="material-icons vmi">sms_failed</i></labelhalf>
						<contenthalf><div class="function_info"><?php _e('Place the shortcode on the page or post where you want to show this module.', 'revslider');?></div></contenthalf>
					</row>
					<div id="rs_premium"></div>
				</div><!-- END OF COLLAPSABLE-->
			</div><!--END OF MODULE TITLE AND ALIAS AND SHORTCODE SETTINGS -->
		</div>
	</div><!-- END OF MODULE TITLE-->

	<!-- SPINNER SETTINGS -->
	<!-- SLIDER LAYOUT SETTINGS -->
	<div class="form_collector slider_general_collector" data-type="sliderconfig" data-pcontainer="#slider_settings" data-offset="#rev_builder_wrapper">
		<div id="form_sliderspinner"  data-select="#gst_sl_12"  class="formcontainer form_menu_inside collapsed">
			<div class="form_inner">
				<div class="form_inner_header"><i class="material-icons">refresh</i><?php _e('Spinner Settings', 'revslider');?></div>
				<div class="collapsable" style="display:block !important">
					<label_a style="width: 75px"><?php _e('Spinner', 'revslider');?></label_a>
				    <select id="revealer_spinners" class="sliderinput tos2 nosearchbox easyinit callEvent" data-r="layout.spinner.type" data-showprio="hide" data-show="#module_spinner_wrap" data-hide=".module_spinner_*val*" data-theme="dark" data-evt="moduleSpinnerChange">
							<option value="off"><?php _e('None', 'revslider');?></option>
							<option value="0">0</option>
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
				 	<div class="div5"></div>
				 	<div id="module_spinner_wrap" class="module_spinner_off">
							<label_a style="width: 75px"><?php _e('Spinner Color', 'revslider');?></label_a>
				     	<input id="module_spinner_color" name="module_spinner_color" type="text" data-editing="Spinner Color" data-mode="single" class="my-color-field sliderinput easyinit" data-visible="true" data-r="layout.spinner.color" value="#FFFFFF">
				 		<div class="div5"></div>
				 		<div id="module_spinner_preview" style="width: 100%; height: 100px; position: relative">
				 			<rs-loader >
					  			<div class="dot1"></div>
					  	    	<div class="dot2"></div>
					  	   		<div class="bounce1"></div>
								<div class="bounce2"></div>
								<div class="bounce3"></div>
						 	</rs-loader>
				 		</div>
				 	</div>
				</div>
			</div>
		</div>
	</div>

	<!-- SLIDER MODAL SETTINGS -->
	<div class="form_collector slider_general_collector" data-type="sliderconfig" data-pcontainer="#slider_settings" data-offset="#rev_builder_wrapper">
		<div id="form_slider_as_modal"  data-select="#gst_sl_99"  class="formcontainer form_menu_inside collapsed">
			<!-- SLIDER MODAL -->
			<div id="form_slidergeneral_general_as_modal" class="form_inner">
				<div class="form_inner_header"><i class="material-icons">picture_in_picture</i><?php _e('Slider as Modal', 'revslider');?></div>
				<div class="collapsable" style="display:block !important">
					<longoption>
						<label_a><?php _e('Page Scroll', 'revslider');?></label_a>
						<input type="checkbox"  id="sr_allowpagescroll" class="sliderinput easyinit"  data-r="modal.allowPageScroll" />						
					</longoption>
					<longoption>
							<label_a><?php _e('Use Cover', 'revslider');?></label_a><input type="checkbox"  id="sr_usemodalcover" class="sliderinput easyinit"  data-r="modal.cover" data-showhide=".slider_modal_coversettings" data-showhidedep="true"/>
							
						</longoption>					

					<div class="slider_modal_coversettings">
						<div class="div5"></div>
						<label_a><?php _e('Cover Color', 'revslider');?></label_a><input type="text" data-editing="Modal Background Color" name="slidermodalcolor" id="slidermodalcolor" class="my-color-field sliderinput easyinit" data-visible="true" data-mode="single" data-r="modal.coverColor" value="rgba(0,0,0,0.5)">						
					</div>
					<div class="div10"></div>
					<div class="modalaligns">
						
						<div class="div10"></div>
						<!-- LAYER ALIGN ICON BASED SETTINGS-->
						<select style="display:none !important" id="modal_pos_halign" data-unselect=".modal_hor_selector" data-select="#modal_hor_*val*" class="sliderinput easyinit" data-responsive="true" data-r="modal.horizontal" data-triggerinp="#modal_pos_x" data-triggerinpval="0"><option value="left"><?php _e('Left', 'revslider');?></option><option value="center"><?php _e('Center', 'revslider');?></option><option value="right"><?php _e('Right', 'revslider');?></option></select>
						<select style="display:none !important" id="modal_pos_valign" data-unselect=".modal_ver_selector" data-select="#modal_ver_*val*" class="sliderinput easyinit" data-responsive="true" data-r="modal.vertical" data-triggerinp="#modal_pos_y" data-triggerinpval="0"><option value="top"><?php _e('Top', 'revslider');?></option><option value="middle"><?php _e('Center', 'revslider');?></option><option value="bottom"><?php _e('Bottom', 'revslider');?></option></select>
						<row>
							<onelabel><label_a><?php _e('Position', 'revslider');?></label_a></onelabel>
							<oneshort><label_icon class="triggerselect ui_leftalign modal_hor_selector" data-select="#modal_pos_halign" data-val="left" id="modal_hor_left"></label_icon><label_icon class="triggerselect ui_centeralign modal_hor_selector" data-select="#modal_pos_halign" data-val="center" id="modal_hor_center"></label_icon><label_icon class="triggerselect ui_rightalign modal_hor_selector" data-select="#modal_pos_halign" data-val="right" id="modal_hor_right"></label_icon></oneshort>
							<oneshort class="lp10"><label_icon class="triggerselect ui_topalign modal_ver_selector" data-select="#modal_pos_valign" data-val="top" id="modal_ver_top"></label_icon><label_icon class="triggerselect ui_middlealign modal_ver_selector" data-select="#modal_pos_valign" data-val="middle" id="modal_ver_middle"></label_icon><label_icon class="triggerselect ui_bottomalign modal_ver_selector" data-select="#modal_pos_valign" data-val="bottom" id="modal_ver_bottom"></label_icon></oneshort>
						</row>
					</div>
					<div class="div10"></div>
					
					<label_a><?php _e('General Speed', 'revslider');?></label_a><input type="text" id="sr_modal_fadespeed" class="sliderinput easyinit" data-numeric="true" data-allowed="ms" data-min="300" data-max="3000" data-r="modal.coverSpeed"/><span class="linebreak"></span>
					<div class="div10"></div>
					<label_a><?php _e('Body Class', 'revslider');?></label_a><input type="text" id="sr_modalbodyclass" class="sliderinput easyinit" data-r="modal.bodyclass"/><span class="linebreak"></span>
					<row class="direktrow">
						<labelhalf><i class="material-icons vmi">sms_failed</i></labelhalf>
						<contenthalf><div class="function_info"><?php _e('Toggle Document Body Class on Open and Close of the Modal.', 'revslider');?></div></contenthalf>
					</row>

					<div class="div25"></div>
					<label_a><?php _e('Shortcode', 'revslider');?></label_a><input readonly type="text" id="sr_modalshortcode" class="sliderinput easyinit" data-r="modalshortcode"/><span class="linebreak"></span>
					<label_a></label_a><div class="basic_action_button longbutton copyclipboard" data-clipboard-action="copy" data-clipboard-target="#sr_modalshortcode"><i class="material-icons">content_copy</i><?php _e('Copy Shortcode', 'revslider');?></div>
					<div class="div10"></div>
					<row class="direktrow">
						<labelhalf><i class="material-icons vmi">sms_failed</i></labelhalf>
						<contenthalf><div class="function_info"><?php _e('Place the shortcode on the page or post where you want to show this modal.', 'revslider');?></div></contenthalf>
					</row>

				</div>
			</div>
		</div>
	</div>


	<!-- SLIDER LAYOUT SETTINGS -->
	<div class="form_collector slider_general_collector" data-type="sliderconfig" data-pcontainer="#slider_settings" data-offset="#rev_builder_wrapper">
		<div id="form_sliderlayout"  data-select="#gst_sl_2"  class="formcontainer form_menu_inside collapsed">
			<!--<div class="collectortabwrap"><div id="collectortab_form_sliderlayout" class="collectortab form_menu_inside" data-forms='["#form_sliderlayout"]'><i class="material-icons">filter_hdr</i><?php _e('Slider Layout', 'revslider');?></div></div>-->


			<!-- SLIDER LAYOUT -->
			<div id="form_slider_layout_layout" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">fullscreen</i><?php _e('Layout', 'revslider');?></div>
				<div class="collapsable">
					<!-- SLIDER TYPE -->
					<div id="rs-layout-type">
						<label_a><?php _e('Type', 'revslider');?></label_a>
						<div class="radiooption">
							<div class="st_slider"><input data-unavailable=".standardunavailable" data-available=".standardavailable" data-disable=".standarddisable" data-enable=".standardenable" data-select=".st_slider" data-unselect=".st_scene, .st_carousel" data-r="type" data-evt="updatesliderlayout"  data-evtparam="slidertype" type="radio" value="standard" id="slidertype_standard" name="slidertype" class="sliderinput easyinit" data-show="" data-hide=""><label_sub><?php _e('Slider', 'revslider');?></label_sub></div>
							<div class="st_scene"><input data-unavailable=".sceneunavailable" data-available=".sceneavailable" data-disable=".herodisable" data-enable=".heroenable" data-select=".st_scene" data-unselect=".st_slider, .st_carousel" data-r="type" data-evt="updatesliderlayout" data-evtparam="slidertype" type="radio" value="hero" id="slidertype_hero" name="slidertype" class="sliderinput easyinit" data-show="" data-hide=""><label_sub><?php _e('Scene', 'revslider');?></label_sub></div>
							<div class="st_carousel"><input data-unavailable=".carouselunavailable" data-available=".carouselavailable" data-disable=".carouseldisable" data-enable=".carouselenable" data-select=".st_carousel" data-unselect=".st_slider, .st_scene" data-r="type" data-evt="updatesliderlayout"  data-evtparam="slidertype" type="radio" value="carousel" id="slidertype_carousel" name="slidertype" class="sliderinput easyinit" data-show="" data-hide=""><label_sub><?php _e('Carousel', 'revslider');?></label_sub></div>
						</div>
					</div>
					<div class="div15"></div>
					<!-- SLIDER LAYOUT -->
					<div id="rs-layout-sizing">
						<label_a><?php _e('Sizing', 'revslider');?></label_a>
						<div class="radiooption">
							<div class="sl_auto"><input data-select=".sl_auto" data-unselect=".sl_fullwidth, .sl_fullscreen" data-r="layouttype" data-enable="" data-disable=".fixedscrollonoff" data-evt="updatesliderlayout_main" type="radio" value="auto" id="sliderlayouttype_auto" name="sliderlayouttype" class="sliderinput easyinit" data-show=".topbottommargins, .fixedscrollsettingsinfo, .sliderminheight,.slidermaxwidth, #sr_size_minheight, .modalaligns" data-hide=".sliderfsminheight, .fixedscrollsettings,.decreaseheights,.usefullheight,#layersupscaling"><label_sub><?php _e('Auto', 'revslider');?></label_sub></div>
							<div class="sl_fullwidth"><input data-select=".sl_fullwidth" data-unselect=".sl_auto, .sl_fullscreen" data-r="layouttype" data-enable=".fixedscrollonoff" data-evt="updatesliderlayout_main" type="radio" value="fullwidth" id="sliderlayouttype_fullwidth" name="sliderlayouttype" class="sliderinput easyinit" data-show=".topbottommargins, .fixedscrollsettings,#sr_size_minheight .modalaligns,#layersupscaling" data-hide=".fixedscrollsettingsinfo,.sliderfsminheight, .slidermaxwidth, .sliderminheight,.decreaseheights,.usefullheight"><label_sub><?php _e('Full-Width', 'revslider');?></label_sub></div>
							<div class="sl_fullscreen"><input data-select=".sl_fullscreen" data-unselect=".sl_auto, .sl_fullwidth" data-r="layouttype" data-enable=".fixedscrollonoff" data-evt="updatesliderlayout_main" type="radio" value="fullscreen" id="sliderlayouttype_fullscreen" name="sliderlayouttype" class="sliderinput easyinit" data-show="#sr_size_minheight_fs,.fixedscrollsettings, .decreaseheights, .sliderfsminheight,.usefullheight" data-hide=".topbottommargins, .fixedscrollsettingsinfo,.slidermaxwidth,  .sliderminheight, .modalaligns,#layersupscaling"><label_sub><?php _e('Full-Screen', 'revslider');?></label_sub></div>
						</div>
					</div>
					<div class="div10"></div>
				</div>
			</div>

			<!-- SLIDER BREAKPOINTS -->
			<div id="form_slider_layout_bpoints" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">devices</i><?php _e('Layer Area Size', 'revslider');?></div>
				<div id="slbpoints_overall" class="collapsable">

					<row style="margin-bottom:5px"><label_a><i class="material-icons bpdevices">desktop_mac</i><?php _e('Browser Width', 'revslider');?> <div class="global_size_miniinfo" id="global_size_desktop">1240</div></label_a></row>
					<row class="direktrow">
						<onelong><label_icon class="ui_width"></label_icon><input data-numeric="true" id="sr_size_width_d" data-r="size.width.d" data-screen="d" data-evt="device_area_dimension_update" type="text"  class="sliderinput valueduekeyboard easyinit"></onelong>
						<oneshort><label_icon class="ui_height"></label_icon><input data-numeric="true"  id="sr_size_height_d" data-r="size.height.d" data-screen="d" data-evt="device_area_dimension_update" type="text"  class="sliderinput valueduekeyboard easyinit"><div class="fake_on_button"><div class="fake_on_button_inner"><div class="fake_onff_on">On</div></div></div></oneshort>
					</row>
					<div class="div10"></div>

					<div id="rs-laptop-breakpoint">
						<row style="margin-bottom:5px"><label_a id="rs-laptop-label"><i class="material-icons bpdevices" style="transform: scale(0.9);">laptop</i><?php _e('Browser Width', 'revslider');?> <div class="global_size_miniinfo" id="global_size_notebook">1240</div></label_a></row>
						<row class="direktrow">
							<onelong><label_icon class="ui_width"></label_icon><input data-numeric="true" id="sr_size_width_n" data-r="size.width.n" data-screen="n" data-evt="device_area_dimension_update" type="text"  class="sliderinput valueduekeyboard easyinit"></onelong>
							<oneshort><label_icon class="ui_height"></label_icon><input data-numeric="true"  id="sr_size_height_n" data-r="size.height.n" data-screen="n" data-evt="device_area_dimension_update" type="text"  class="sliderinput valueduekeyboard easyinit"><input type="checkbox" id="sr_custom_n" class="sliderinput easyinit" data-evt="device_area_availibity" data-r="size.custom.n"></oneshort>
						</row>
					</div>

					<div class="div10"></div>
					<row style="margin-bottom:5px"><label_a><i class="material-icons bpdevices" style="transform: scale(0.8);">tablet_android</i><?php _e('Browser Width', 'revslider');?> <div class="global_size_miniinfo" id="global_size_tablet">1240</div></label_a></row>
					<row class="direktrow">
						<onelong><label_icon class="ui_width"></label_icon><input data-numeric="true" id="sr_size_width_t" data-r="size.width.t" data-screen="t" data-evt="device_area_dimension_update" type="text"  class="sliderinput valueduekeyboard easyinit"></onelong>
						<oneshort><label_icon class="ui_height"></label_icon><input data-numeric="true"  id="sr_size_height_t" data-r="size.height.t" data-screen="t" data-evt="device_area_dimension_update" type="text"  class="sliderinput valueduekeyboard easyinit"><input type="checkbox" id="sr_custom_t" class="sliderinput easyinit" data-evt="device_area_availibity" data-r="size.custom.t"></oneshort>
					</row>


					<div class="div10"></div>
					<row style="margin-bottom:5px"><label_a><i class="material-icons bpdevices" style="transform: scale(0.7);">phone_iphone</i><?php _e('Browser Width', 'revslider');?> <div class="global_size_miniinfo" id="global_size_mobile">1240</div></label_a></row>
					<row class="direktrow">
						<onelong><label_icon class="ui_width"></label_icon><input data-numeric="true" id="sr_size_width_m" data-r="size.width.m" data-screen="t" data-evt="device_area_dimension_update" type="text"  class="sliderinput valueduekeyboard easyinit"></onelong>
						<oneshort><label_icon class="ui_height"></label_icon><input data-numeric="true"  id="sr_size_height_m" data-r="size.height.m" data-screen="t" data-evt="device_area_dimension_update" type="text"  class="sliderinput valueduekeyboard easyinit"><input type="checkbox" id="sr_custom_m" class="sliderinput easyinit" data-evt="device_area_availibity" data-r="size.custom.m"></oneshort>
					</row>

				</div>
			</div>

			<!-- SLIDER LAYOUT DECREASE MODULE HEIGHT-->
			<div id="form_slider_layout_decmohei" class="form_inner open">
				<div class="decreaseheights">
					<div class="form_inner_header"><i class="material-icons">tab_unselected</i><?php _e('Decrease Module Height', 'revslider');?></div>
					<div class="collapsable">
						<label_a><?php _e('by Container', 'revslider');?></label_a><input class="sliderinput easyinit" data-r="size.fullScreenOffsetContainer" type="text" id="sr_fs_height__decrease_cont" placeholder="<?php _e('Enter Container .class or #id', 'revslider')?>">
						<span class="linebreak"></span>
						<label_a><?php _e('by PX or %', 'revslider');?></label_a><input data-numeric="true" data-allowed="px,%" data-r="size.fullScreenOffset" type="text" id="sr_fs_height_decrease" class="sliderinput easyinit">
						<span class="linebreak"></span>
						<longoption><i class="material-icons">select_all</i><label_a><?php _e('Dont Force Fullwidth', 'revslider');?></label_a><input type="checkbox"  id="sr_keepautowidth" class="easyinit sliderinput" data-evt="" data-r="size.disableForceFullWidth"/></longoption>
						<longoption><i class="material-icons">settings_cell</i><label_a style="overflow:visible"><?php _e('Ignore Mobile Height Changes', 'revslider');?></label_a><input type="checkbox"  id="sr_ignHeCha" class="sliderinput easyinit" data-r="size.ignoreHeightChanges"/></longoption>
					</div>
				</div>
			</div>


			<!-- SLIDER LAYOUT ADVANCED-->
			<div id="form_slider_layout_adv" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">settings_input_component</i><?php _e('Advanced Settings', 'revslider');?></div>
				<div class="collapsable">


					<div class="_nvojcm_ carouselunavailable standardavailable sceneavailable">
						<!-- SLIDER MIN HEIGHT AND MAX WIDTH -->
						<longoption class="slidermaxwidth"><i class="material-icons rcw">unfold_more</i><label_a><?php _e('Max Width', 'revslider');?></label_a><input data-allowed="px,%,none" data-min="0" data-numeric="true"  id="sr_size_maxwidth" data-r="size.maxWidth" data-evt="updatesliderlayout"  type="text"  class="sliderinput valueduekeyboard easyinit" placeholder="none"></longoption>
						<longoption class="sliderminheight"><i class="material-icons">unfold_less</i><label_a><?php _e('Min Height', 'revslider');?></label_a><input data-min="0" data-numeric="true"  data-allowed="px,%,none" id="sr_size_minheight" data-r="size.minHeight" data-evt="updatesliderlayout"  type="text" class="sliderinput valueduekeyboard smallinput easyinit" placeholder="none"></longoption>
						<longoption class="sliderfsminheight"><i class="material-icons">unfold_less</i><label_a><?php _e('Min Height', 'revslider');?></label_a><input data-min="0" data-numeric="true" data-allowed="none,px,%" id="sr_size_minheight_fs" data-r="size.minHeightFullScreen" placeholder="none" data-evt="updatesliderlayout"  type="text"  class="sliderinput valueduekeyboard easyinit"></longoption>
						<longoption><i class="material-icons">unfold_more</i><label_a><?php _e('Wrapper Max Height', 'revslider');?></label_a><input data-allowed="px,%,none" data-min="0" data-numeric="true"  id="sr_size_maxheight" data-r="size.maxHeight"  type="text"  class="sliderinput valueduekeyboard easyinit" placeholder="none"></longoption>

						<div class="div20"></div>
						<longoption><i class="material-icons">devices</i><label_a><?php _e('Keep Breakpoint Heights', 'revslider');?></label_a><input type="checkbox"  id="sr_breakpoint_heights" class="easyinit sliderinput" data-r="size.keepBPHeight"/></longoption>
						<longoption><i class="material-icons">aspect_ratio</i><label_a><?php _e('Respect Ratio', 'revslider');?></label_a><input type="checkbox"  id="sr_respectAR" class="easyinit sliderinput" data-evt="updatesliderlayout" data-r="size.respectAspectRatio"/></longoption>
						<longoption><i class="material-icons">open_with</i><label_a><?php _e('Grid = Module', 'revslider');?></label_a><input type="checkbox"  id="sr_layersAlignOnModule" class="easyinit sliderinput" data-evt="" data-r="size.layersAlignOnModule"/></longoption>
						<div id="layersupscaling"><longoption><i class="material-icons">open_in_full</i><label_a><?php _e('Enable Layer Upscaling', 'revslider');?></label_a><input type="checkbox"  id="sr_layerscanupscale" class="easyinit sliderinput" data-evt="" data-r="size.enableUpscaling"/></longoption></div>
						<div class="div20"></div>
						<longoption><i class="material-icons">tab_unselected</i><label_a><?php _e('Force Overflow Visible', 'revslider');?></label_a><input type="checkbox"  id="sr_forceOvVi" class="easyinit sliderinput" data-r="size.forceOverflow"/></longoption>
						<longoption><i class="material-icons">vertical_align_top</i><label_a><?php _e('Fixed on Top', 'revslider');?></label_a><input type="checkbox" class="easyinit sliderinput"  data-r="layout.position.fixedOnTop"/></longoption>
					</div>

					<!-- CAROUSEL ADVANCED SETTINGS -->
					<div class="carouselavailable standardunavailable sceneunavailable">
						<longoption><i class="material-icons">tab_unselected</i><label_a><?php _e('Force Overflow Hidden', 'revslider');?></label_a><input type="checkbox"  id="sr_forceOvHid" class="easyinit sliderinput" data-r="size.overflowHidden"/></longoption>
						<longoption class="usefullheight"><i class="material-icons">unfold_more</i><label_a><?php _e('Use Full Height for Content', 'revslider');?></label_a><input type="checkbox"  id="sr_forceOvHid" class="easyinit sliderinput" data-r="size.useFullScreenHeight"/></longoption>
					</div>
					<div class="div20"></div>
					<div class="carouselavailable standardavailable sceneavailable">						
						<label_a><?php _e('Perspective', 'revslider');?></label_a><select data-evt="updatePerspective" id="global_pers_type" class="sliderinput tos2 nosearchbox easyinit" data-r="general.perspectiveType" data-show=".global_perspecitve_*val*_settings" data-hide=".global_perspective_settings"> <option value="isometric"><?php _e('Isometric (Global)', 'revslider');?></option><option value="global"><?php _e('3D Uniform (Global)', 'revslider');?></option><option value="local"><?php _e('3D Individual (Local)', 'revslider');?></option></select>
						<div class="global_perspecitve_global_settings global_perspective_settings">
							<longoption><label_icon class="ui_perspective"></label_icon><label_a><?php _e('Layer Perspective Globally', 'revslider');?></label_a><input data-allowed="px" data-min="0" data-numeric="true"  id="global_layers_perspectives" data-r="general.perspective"  type="text"  class="sliderinput valueduekeyboard callEvent easyinit"  data-evt="updatePerspective" placeholder="none"></longoption>
						</div>
					</div>
				</div>
				<div class="div5"></div>
			</div>

			<!-- SLIDER  OVERLAY  -->
			<div id="form_slider_layout_decboovsh" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">drag_indicator</i><?php _e('Overlay', 'revslider');?></div>
				<div class="collapsable">
						<!-- SLIDER OVERLAY -->
						<label_a><?php _e('Overlay', 'revslider');?></label_a><select data-evt="drawBGOverlay" id="sr_overlay" class="dottedoverlay sliderinput tos2 nosearchbox easyinit callEvent" data-r="layout.bg.dottedOverlay"></select>
						<label_a><?php _e('Size', 'revslider');?></label_a><input data-numeric="true" data-allowed="none" data-min="0"  data-r="layout.bg.dottedOverlaySize" data-evt="drawBGOverlay"  type="text"  class="sliderinput valueduekeyboard  easyinit callEvent" placeholder="none" >
						<label_a><?php _e('Color 1', 'revslider');?></label_a><input type="text" data-editing="Background Overlay Color 1" data-evt="drawBGOverlay" name="sliderbgoverlaycolor_a" id="slideroverlaybgcolor_a" class="my-color-field sliderinput easyinit" data-visible="true" data-mode="single" data-r="layout.bg.dottedColorA" value="transparent">
						<label_a><?php _e('Color 2', 'revslider');?></label_a><input type="text" data-editing="Background Overlay Color 2" data-evt="drawBGOverlay" name="sliderbgoverlaycolor_b" id="slideroverlaybgcolor_b" class="my-color-field sliderinput easyinit" data-visible="true" data-mode="single" data-r="layout.bg.dottedColorB" value="transparent">
				</div>
			</div>

			<!-- SLIDER POSITION -->
			<div id="form_slidergeneral_general_sr_position" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">settings_overscan</i><?php _e('Module Position within Wrapper', 'revslider');?></div>
				<div class="collapsable" style="display:block !important">
					<!-- SLIDER POSITION SETTINGS -->
					<!--<label_a><?php _e('Align', 'revslider');?></label_a>
					<div class="radiooption">
						<div><input value="left" class="sliderinput easyinit" name="slider_pos_in_wrapper" data-r="layout.position.align" type="radio"><label_sub><?php _e('Left', 'revslider');?></label_sub></div>
						<div><input value="center" class="sliderinput easyinit" name="slider_pos_in_wrapper" data-r="layout.position.align" type="radio"><label_sub><?php _e('Center', 'revslider');?></label_sub></div>
						<div><input value="right" class="sliderinput easyinit" name="slider_pos_in_wrapper" data-r="layout.position.align" type="radio"><label_sub><?php _e('Right', 'revslider');?></label_sub></div>
					</div>
					<div class="div15"></div>-->
					<row class="direktrow">
						<onelong><label_a><?php _e('Clear After', 'revslider');?></label_a><input type="checkbox"  id="add_clear" class="sliderinput easyinit" data-r="layout.position.addClear"/></onelong>
						<oneshort></oneshort>
					</row>

					<row class="direktrow topbottommargins">
						<onelong><label_icon class="ui_margin_top"></label_icon><input type="text" data-numeric="true" data-allowed="px,%" id="sr_pos_marg_top" class="sliderinput easyinit withsuffix smallinput" data-r="layout.position.marginTop"/></onelong>
						<oneshort><label_icon class="ui_margin_bottom"></label_icon><input data-numeric="true" data-allowed="px,%" type="text"  id="sr_pos_marg_bottom" class="sliderinput easyinit withsuffix smallinput" data-r="layout.position.marginBottom"/></oneshort>
					</row>

				</div>
			</div>




			<!-- SLIDER LAYOUT MODULE BACKGROUND -->
			<div id="form_slider_layout_decmobg" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">format_color_fill</i><?php _e('Module Background', 'revslider');?></div>
				<div class="collapsable">
					<row class="direktrow">
						<onelong><label_a><?php _e('Use Image', 'revslider');?></label_a><input type="checkbox"  id="sr_usebgimage" class="sliderinput easyinit" data-evt="sliderBGUpdate" data-r="layout.bg.useImage" data-showhide=".slider_bg_moresettings_wr" data-showhidedep="true"/></onelong>
						<oneshort></oneshort>
					</row>
					<label_a><?php _e('BG Color', 'revslider');?></label_a><input type="text" data-editing="Slider Background Color" data-evt="sliderBGUpdate" name="sliderbgcolor" id="sliderbgcolor" class="my-color-field sliderinput easyinit" data-visible="true" data-r="layout.bg.color" value="transparent">
					<div class="div5"></div>
					<div class="sublabels_wrapper slider_bg_moresettings_wr">
						<row class="direktrow">
							<onelong style="min-width:90px;padding-right:0px;"><label_a><?php _e('BG Image', 'revslider');?></label_a><div style="margin-left:11px; margin-top:9px" class="miniprevimage_wrap"><i class="material-icons">filter_hdr</i><div id="slider_bg_image"></div><div data-evt="sliderBGUpdate" data-r="settings.layout.bg.image" data-rid="settings.layout.bg.imageId" data-sty="settings.layout.bg.imageSourceType" data-lib="settings.layout.bg.imageLib" data-default="" class="resettodefault basic_action_button callEventButton sliderinput onlyicon"><i class="material-icons">close</i></div></div></onelong>
							<oneshort>
								<div id="slider_bg_inputfields"><input style="min-width:185px !important;" class="sliderinput easyinit" data-r="layout.bg.image" type="text" id="sr_bgimage" placeholder="<?php _e('Enter External URL', 'revslider')?>"></div>
								<div data-evt="sliderBGUpdate" data-target="#sr_bgimage" id="sliderbg_image" data-r="settings.layout.bg.image" data-rid="settings.layout.bg.imageId" data-sty="settings.layout.bg.imageSourceType" data-lib="settings.layout.bg.imageLib" class="getImageFromMediaLibrary basic_action_button longbutton callEventButton"><i class="material-icons">style</i><?php _e('Media Library', 'revslider');?></div>
								<div data-evt="sliderBGUpdate" data-target="#sr_bgimage" id="sliderbg_image_ol" data-r="settings.layout.bg.image" data-rid="settings.layout.bg.imageId" data-sty="settings.layout.bg.imageSourceType" data-lib="settings.layout.bg.imageLib" class="getImageFromObjectLibrary basic_action_button longbutton callEventButton"><i class="material-icons">camera_enhance</i><?php _e('Object Library', 'revslider');?></div>
							</oneshort>
						</row>
						<!-- USED LIBRARY TYPE-->
						<div style="display:none" id="slider_used_library"><label_a class="singlerow"><?php _e('Used Library', 'revslider');?></label_a><select class="sliderinput easyinit" data-r="layout.bg.imageLib" data-show="#sliderbg_srctype_*val*" data-hide=".sliderbg_srctype_all" data-showprio="show"><option value="">Nothing</option><option value="objectlibrary">Objectlibrary</option><option value="medialibrary">MediaLibrary</option></select></div>
						<!-- SIZE / SRC PICKER FOR CURRENT USED LIBRARY TYPE-->
						<div id="slider_used_library_lists">
							<div id="sliderbg_srctype_objectlibrary" class="sliderbg_srctype_all"><label_a class="singlerow"><?php _e('Image Size', 'revslider');?></label_a><select class="sliderinput tos2 nosearchbox easyinit" data-evt="getNewImageSize" data-evtparam="slider.object" data-r="layout.bg.imageSourceType"><option value="100" selected="selected"><?php _e("Original", 'revslider');?></option><option value="75" selected="selected"><?php _e("Large", 'revslider');?></option><option value="50" selected="selected"><?php _e("Medium", 'revslider');?></option><option value="25" selected="selected"><?php _e("Small", 'revslider');?></option><option value="10" selected="selected"><?php _e("Extra Small", 'revslider');?></option></select></div>
							<div id="sliderbg_srctype_medialibrary" class="sliderbg_srctype_all"><label_a class="singlerow"><?php _e('Source Type', 'revslider');?></label_a><select class="sliderinput tos2 nosearchbox easyinit" data-evt="getNewImageSize" data-evtparam="slider.media" data-r="layout.bg.imageSourceType"><option value="auto" selected="selected"><?php _e("Default Setting", 'revslider');?></option><?php foreach ($img_sizes as $imghandle => $imgSize) { echo '<option value="' . $imghandle . '">' . $imgSize . '</option>';}?></select></div>
						</div>

						<div class="div20"></div>
						<select style="display:none !important" id="sr_bgimage_pos" data-unselect=".sliderm_bg_position_selector" data-select="#sliderm_bg_position_*val*" data-evt="sliderBGUpdate" class="sliderinput easyinit"  data-r="layout.bg.position"><option value="left center"><?php _e('left center', 'revslider');?></option><option value="left bottom"><?php _e('left bottom', 'revslider');?></option><option value="left top"><?php _e('left top', 'revslider');?></option><option value="center top"><?php _e('center top', 'revslider');?></option><option value="center center"><?php _e('center center', 'revslider');?></option><option value="center bottom"><?php _e('center bottom', 'revslider');?></option>																				<option value="right top"><?php _e('right top', 'revslider');?></option><option value="right center"><?php _e('right center', 'revslider');?></option><option value="right bottom"><?php _e('right bottom', 'revslider');?></option></select>
						<row class="direktrow">
							<onelong>
								<label_a><?php _e('Position', 'revslider');?></label_a><!--
									--><div class="bg_alignselector_wrap">
										<div class="bg_align_row">
											<div class="triggerselect sliderm_bg_position_selector bg_alignselector" data-select="#sr_bgimage_pos" data-val="left top" id="sliderm_bg_position_left-top"></div>
											<div class="triggerselect sliderm_bg_position_selector bg_alignselector" data-select="#sr_bgimage_pos" data-val="center top" id="sliderm_bg_position_center-top"></div>
											<div class="triggerselect sliderm_bg_position_selector bg_alignselector" data-select="#sr_bgimage_pos" data-val="right top" id="sliderm_bg_position_right-top"></div>
										</div>
										<div class="bg_align_row">
											<div class="triggerselect sliderm_bg_position_selector bg_alignselector" data-select="#sr_bgimage_pos" data-val="left center" id="sliderm_bg_position_left-center"></div>
											<div class="triggerselect sliderm_bg_position_selector bg_alignselector" data-select="#sr_bgimage_pos" data-val="center center" id="sliderm_bg_position_center-center"></div>
											<div class="triggerselect sliderm_bg_position_selector bg_alignselector" data-select="#sr_bgimage_pos" data-val="right center" id="sliderm_bg_position_right-center"></div>
										</div>
										<div class="bg_align_row">
											<div class="triggerselect sliderm_bg_position_selector bg_alignselector" data-select="#sr_bgimage_pos" data-val="left bottom" id="sliderm_bg_position_left-bottom"></div>
											<div class="triggerselect sliderm_bg_position_selector bg_alignselector" data-select="#sr_bgimage_pos" data-val="center bottom" id="sliderm_bg_position_center-bottom"></div>
											<div class="triggerselect sliderm_bg_position_selector bg_alignselector" data-select="#sr_bgimage_pos" data-val="right bottom" id="sliderm_bg_position_right-bottom"></div>
										</div>
									</div>
							</onelong>
							<oneshort>
								<label_icon class="ui_fit"></label_icon><select data-evt="sliderBGUpdate" id="sr_bgimage_fit" class="sliderinput tos2 nosearchbox easyinit" data-theme="minl120" data-r="layout.bg.fit" ><option value="cover">cover</option><option value="contain">contain</option><option value="normal">normal</option></select>
								<label_icon class="ui_repeat"></label_icon><select data-evt="sliderBGUpdate" id="sr_bgimage_repeat" class="sliderinput tos2 nosearchbox easyinit" data-theme="minl120" data-r="layout.bg.repeat" ><option value="no-repeat">no</option><option value="repeat">repeat</option><option value="repeat-x">x</option><option value="repeat-y">y</option></select>
							</oneshort>
						</row>
					</div>
				</div>
			</div>
			<!-- SLIDER LAYOUT MODULE PADDING , OVERLAY and SHADOW -->
			<div id="form_slider_layout_decboovsh" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">flip_to_back</i><?php _e('Border & Shadow', 'revslider');?></div>
				<div class="collapsable">						
						<!-- SLIDER SHADOW -->
						<label_a><?php _e('Shadow Type', 'revslider');?></label_a><select data-evt="sliderBGUpdate" id="sr_shadow" class="sliderinput tos2 nosearchbox easyinit" data-r="layout.bg.shadow" ><option value="0"><?php _e('No Shadow', 'revslider');?></option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option></select>
						<!-- PADDING -->
						<label_a><?php _e('Gap (Border)', 'revslider');?></label_a><input data-numeric="true" data-allowed="px,none" data-min="0"  id="sr_layout_padding" data-r="layout.bg.padding" data-evt="updatesliderlayout"  type="text"  class="sliderinput valueduekeyboard  easyinit" placeholder="none" >

				</div>
			</div>
		</div>
	</div><!-- END OF SLIDER LAYOUT SETTINGS -->

	<!-- MODULE CAROUSEL SETTINGS -->
	<div class="form_collector slider_general_collector" data-type="sliderconfig" data-pcontainer="#slider_settings" data-offset="#rev_builder_wrapper">
		<div id="form_module_carousel"  data-select="#gst_sl_3"  class="formcontainer form_menu_inside collapsed">
			<!--<div class="collectortabwrap"><div id="" class="collectortab form_menu_inside" data-forms='["#form_module_carousel"]'><?php _e('Caraousel', 'revslider');?></div></div>			-->
			<!--<div class="form_intoaccordion"><i class="material-icons">arrow_drop_down</i></div>			-->
			<div id="form_slidergeneral_caroussel" class="form_inner">
				<div class="form_inner_header"><i class="material-icons">view_carousel</i><?php _e('Carousel Layout', 'revslider');?></div>

				<div class="collapsable" style="display:block !important">
					<longoption><label_a><?php _e('Keep Aspect Ratio (Justify)', 'revslider');?></label_a><input type="checkbox"  id="sr_ca_justi" class="sliderinput easyinit callEvent" data-evt="device_area_dimension_update" data-showhide=".nojustifywall" data-hideshow=".justifywall" data-showhidedep="false"  data-r="carousel.justify"/></longoption>
					<div class="justifywall"><longoption><label_a><?php _e('Max Width 100%', 'revslider');?></label_a><input type="checkbox"  id="sr_ca_justi_maxwidth" class="sliderinput easyinit"  data-r="carousel.justifyMaxWidth"/></longoption></div>
					<longoption><label_a><?php _e('Snap to X Alignment', 'revslider');?></label_a><input type="checkbox"  id="sr_ca_snap" class="sliderinput easyinit"  data-r="carousel.snap"/></longoption>
					<longoption><label_a><?php _e('Infinity Scroll', 'revslider');?></label_a><input type="checkbox"  id="sr_ca_inf" class="sliderinput easyinit" data-evt="" data-r="carousel.infinity"/></longoption>
					<longoption><label_a><?php _e('Stop on click', 'revslider');?></label_a><input type="checkbox"  id="sr_ca_socl" class="sliderinput easyinit" data-evt="" data-r="carousel.stopOnClick"/></longoption>
					<div class="div20"></div>
					<label_a><?php _e('Visible Layers', 'revslider');?></label_a><select id="sr_ca_showAllLayers" class="sliderinput tos2 nosearchbox easyinit" data-r="carousel.showAllLayers" data-show="._lavoc_*val*" data-hide="._lavoc_" data-showprio="show"><option value="false"><?php _e('If Slide in Focus', 'revslider');?></option><option value="all"><?php _e('Always on all Slide', 'revslider');?></option><option value="individual"><?php _e('Set by Layer Visibility', 'revslider');?></option></select>
					<div class="div20"></div>					
					<row class="directrow">
						<onelong><label_a><?php _e('Max. Visible', 'revslider');?></label_a><select data-change="sr_ca_stretch" data-changeto='false' data-changewhennot="1" data-evt="updatesliderlayout" id="sr_ca_mitems" class="sliderinput tos2 nosearchbox easyinit" data-r="carousel.maxItems" ><option value="1">1</option><option value="3">3</option><option value="5">5</option><option value="7">7</option><option value="9">9</option><option value="11">11</option><option value="13">13</option><option value="15">15</option><option value="17">17</option></select></onelong>
					</row>
					<div class="nojustifywall">
						<label_a><?php _e('Stretch Slides', 'revslider');?></label_a><input type="checkbox"  data-evt="updatesliderlayout" id="sr_ca_stretch" data-change="sr_ca_mitems" data-changeto="1" data-changewhen='true' class="sliderinput easyinit" data-evt="" data-r="carousel.stretch"/><span class="linebreak"></span>
					</div>
					<row class="directrow">
						<onelong><label_icon class="ui_bradius"></label_icon><input data-allowed="px,%" data-evt="updatesliderlayout" data-r="carousel.borderRadius" type="text" id="sr_ca_br" data-numeric="true" class="sliderinput  easyinit valueduekeyboard"></onelong>
						<oneshort><label_icon class="ui_gap"></label_icon><input data-evt="updatesliderlayout" data-min="-700"  id="sr_ca_gap" data-r="carousel.space" data-numeric="true" data-allowed="px" data-evt=""  type="text"  class="sliderinput valueduekeyboard  easyinit" placeholder="none" ></oneshort>
					</row>
					<div class="nojustifywall">
						<row class="directrow">
							<onelong><label_icon class="ui_padding_top"></label_icon><input data-evt="updatesliderlayout" data-min="0"  id="sr_ca_pdt" data-r="carousel.paddingTop" data-numeric="true" data-allowed="px" data-evt=""  type="text"  class="sliderinput valueduekeyboard  easyinit" placeholder="none" ></onelong>
							<oneshort><label_icon class="ui_padding_bottom"></label_icon><input data-evt="updatesliderlayout" data-min="0"  id="sr_ca_pdb" data-r="carousel.paddingBottom" data-numeric="true" data-allowed="px" data-evt=""  type="text"  class="sliderinput valueduekeyboard  easyinit" placeholder="none" ></oneshort>
						</row>
					</div>
					<row class="directrow">
						<onelong><label_icon class="ui_x"></label_icon><select id="sr_ca_halign" class="sliderinput tos2 nosearchbox easyinit" data-r="carousel.horizontal" ><option value="left"><?php _e('Left', 'revslider');?></option><option value="center"><?php _e('Center', 'revslider');?></option><option value="right"><?php _e('Right', 'revslider');?></option></select></onelong>
						<oneshort><label_icon class="ui_y"></label_icon><select id="sr_ca_valign" class="sliderinput tos2 nosearchbox easyinit" data-r="carousel.vertical" ><option value="top"><?php _e('Top', 'revslider');?></option><option value="center"><?php _e('Center', 'revslider');?></option><option value="bottom"><?php _e('Bottom', 'revslider');?></option></select></oneshort>
					</row>
				</div>
			</div>

			<div id="form_slidergeneral_caroussel_animation" class="form_inner">
				<div class="form_inner_header"><i class="material-icons">local_play</i><?php _e('Animation', 'revslider');?></div>
				<div class="collapsable" style="display:block !important">
					<label_a><?php _e('Easing', 'revslider');?></label_a><select id="sr_ca_ease" class="sliderinput tos2 searchbox easyinit easingSelect" data-r="carousel.ease"></select>
					<label_a><?php _e('Ease Speed', 'revslider');?></label_a><input data-allowed="ms" data-min="0"  id="sr_ca_speed" data-r="carousel.speed" data-numeric="true" data-evt=""  type="text"  class="sliderinput valueduekeyboard  easyinit">
				</div>
			</div>

			<div id="form_slidergeneral_caroussel_effects" class="form_inner nojustifywall">
				<div class="form_inner_header"><i class="material-icons">linear_scale</i><?php _e('Effects', 'revslider');?></div>
				<div class="collapsable" style="display:block !important">
					<row class="directrow">
						<onelong><label_a><?php _e('Fade', 'revslider');?></label_a><input type="checkbox" data-evt="updatesliderlayout" data-showhide="#carosel_fade_vary_wrap" data-showhidedep="true" id="sr_ca_fadeall" class="sliderinput easyinit" data-evt="" data-r="carousel.fadeOut"/></onelong>
						<oneshort id="carosel_fade_vary_wrap">
							<label_icon class="ui_max_fadedown"></label_icon><input data-evt="updatesliderlayout" data-min="0"  id="sr_ca_maxopa" data-r="carousel.maxOpacity" data-numeric="true" data-allowed="%" data-evt=""  data-min="0" data-max="100" type="text"  class="sliderinput valueduekeyboard  easyinit"><span class="linebreak"></span>
							<label_icon class="ui_v_fade"></label_icon><input type="checkbox"  data-evt="updatesliderlayout" id="sr_ca_vfadeall" class="sliderinput easyinit" data-evt="" data-r="carousel.varyFade"/></oneshort>
					</row>
					<row class="directrow">
						<onelong><label_a><?php _e('Rotation', 'revslider');?></label_a><input data-evt="updatesliderlayout" type="checkbox" data-showhide=".carosel_rotate_vary_wrap" data-showhidedep="true"  id="sr_ca_rotate" class="sliderinput easyinit" data-evt="" data-r="carousel.rotation"/></onelong>
						<oneshort class="carosel_rotate_vary_wrap">
							<label_icon class="ui_max_rotation"></label_icon><input data-evt="updatesliderlayout" data-min="0"  id="sr_ca_maxrot" data-r="carousel.maxRotation" data-numeric="true" data-allowed="deg" data-evt=""  type="text"  class="sliderinput valueduekeyboard  easyinit"><span class="linebreak"></span>
							<label_icon class="ui_v_rotation"></label_icon><input data-evt="updatesliderlayout" type="checkbox"  id="sr_ca_vrotate" class="sliderinput easyinit" data-evt="" data-r="carousel.varyRotate"/><span class="linebreak"></span>
						</oneshort>
					</row>
					<row class="directrow">
						<onelong><label_a><?php _e('Scale', 'revslider');?></label_a><input type="checkbox" data-evt="updatesliderlayout" data-showhide=".carosel_scale_vary_wrap" data-showhidedep="true"  id="sr_ca_scale" class="sliderinput easyinit" data-evt="" data-r="carousel.scale"/></onelong>
						<oneshort class="carosel_scale_vary_wrap">
							<label_icon class="ui_max_scaledown"></label_icon><input data-evt="updatesliderlayout" data-min="0"  id="sr_ca_scaleDown" data-r="carousel.scaleDown" data-numeric="true" data-allowed="%" data-evt=""  type="text"  class="sliderinput valueduekeyboard  easyinit"><span class="linebreak"></span>
						</oneshort>
					</row>
					<row class="directrow carosel_scale_vary_wrap">
						<onelong><label_a><?php _e('Scale Offset', 'revslider');?></label_a><input type="checkbox" data-evt="updatesliderlayout" id="sr_ca_offsetscale" class="sliderinput easyinit" data-evt="" data-r="carousel.offsetScale"/></onelong>
						<oneshort><label_icon class="ui_v_scale"></label_icon><input data-evt="updatesliderlayout" type="checkbox"  id="sr_ca_vscale" class="sliderinput easyinit" data-evt="" data-r="carousel.varyScale"/></oneshort>
					</row>
				</div><!-- END OF COLLAPSABLE-->
			</div>
			<!--END OF MODULE CAROUSSEL -->
		</div>
	</div><!-- END OF CAROUSSEL SETTINGS -->

	<!-- SLIDER CONTENT SETTINGS -->
	<div class="form_collector slider_general_collector" data-type="sliderconfig" data-pcontainer="#slider_settings" data-offset="#rev_builder_wrapper">
		<div id="form_slidercontent"  data-select="#gst_sl_4"  class="formcontainer form_menu_inside collapsed">
			<!--<div class="collectortabwrap"><div id="collectortab_form_sliderlayout" class="collectortab form_menu_inside" data-forms='["#form_slidercontent"]'><i class="material-icons">filter_hdr</i><?php _e('Content', 'revslider');?></div></div>-->
			<div style="display:none"  class="form_intoaccordion"><i class="material-icons">arrow_drop_down</i></div>


			<!-- SLIDER SOURCE CONTENT -->
			<div id="form_slider_content_content" data-evt="loadStreamDependencies" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">insert_comment</i><?php _e('Content', 'revslider');?></div>
				<div style="display:none" class="form_intoaccordion" data-trigger="#slr_fsc_l1"><i class="material-icons">arrow_drop_down</i></div>
				<div class="collapsable">
					<div id="rs-module-source-wrap">
						<label_a id="rs-module-source-label"><?php _e('Source', 'revslider');?></label_a>
						<div class="radiooption">
							<div><input value="gallery" type="radio" name="slider_sourcetype" class="sliderinput easyinit" data-evt="loadStreamDependencies" data-evtparam="force" data-show="#source_*val*_settings" data-hide=".source_subsetting_wrapper" data-r="sourcetype"><label_sub><?php _e('Custom', 'revslider');?></label_sub></div>
							<div><input value="post" type="radio" name="slider_sourcetype" class="sliderinput easyinit" data-evt="loadStreamDependencies" data-evtparam="force" data-show="#source_*val*_settings, #post_typesubselector" data-hide=".source_subsetting_wrapper" data-r="sourcetype"><label_sub><?php _e('Post-Based', 'revslider');?></label_sub></div>
							<div><input value="woo" type="radio" name="slider_sourcetype" class="sliderinput easyinit" data-evt="loadStreamDependencies" data-evtparam="force" data-show="#source_*val*_settings" data-hide=".source_subsetting_wrapper" data-r="sourcetype"><label_sub><?php _e('WooCommerce', 'revslider');?></label_sub></div>
							<div><input value="flickr" type="radio" name="slider_sourcetype" class="sliderinput easyinit" data-evt="loadStreamDependencies" data-evtparam="force" data-show="#source_*val*_settings" data-hide=".source_subsetting_wrapper" data-r="sourcetype"><label_sub><?php _e('Flickr', 'revslider');?></label_sub></div>
							<div><input value="instagram" type="radio" name="slider_sourcetype" class="sliderinput easyinit" data-evt="loadStreamDependencies" data-evtparam="force" data-show="#source_*val*_settings" data-hide=".source_subsetting_wrapper" data-r="sourcetype"><label_sub><?php _e('Instagram', 'revslider');?></label_sub></div>
							<div><input value="twitter" type="radio" name="slider_sourcetype" class="sliderinput easyinit" data-evt="loadStreamDependencies" data-evtparam="force" data-show="#source_*val*_settings" data-hide=".source_subsetting_wrapper" data-r="sourcetype"><label_sub><?php _e('Twitter', 'revslider');?></label_sub></div>
							<div><input value="facebook" type="radio" name="slider_sourcetype" class="sliderinput easyinit" data-evt="loadStreamDependencies" data-evtparam="force" data-show="#source_*val*_settings" data-hide=".source_subsetting_wrapper" data-r="sourcetype"><label_sub><?php _e('Facebook', 'revslider');?></label_sub></div>
							<div><input value="youtube" type="radio" name="slider_sourcetype" class="sliderinput easyinit" data-evt="loadStreamDependencies" data-evtparam="force" data-show="#source_*val*_settings" data-hide=".source_subsetting_wrapper" data-r="sourcetype"><label_sub><?php _e('YouTube', 'revslider');?></label_sub></div>
							<div><input value="vimeo" type="radio" name="slider_sourcetype" class="sliderinput easyinit" data-evt="loadStreamDependencies" data-evtparam="force" data-show="#source_*val*_settings" data-hide=".source_subsetting_wrapper" data-r="sourcetype"><label_sub><?php _e('Vimeo', 'revslider');?></label_sub></div>
						</div>
					</div>
					<div id="post_typesubselector" class="source_subsetting_wrapper" style="display:none">
						<div class="div15"></div>
						<label_a><?php _e('Type', 'revslider');?></label_a>
						<div class="radiooption">
							<div id="sps_post"><input data-r="source.post.subType" type="radio" value="post" name="slidersourcesubtype" class="easyinit sliderinput" data-show="#post_all_subtypesettings, #post_subtype_settings_wrapper" data-hide="#specificpost_subtype_settings_wrapper" ><label_sub><?php _e('Post', 'revslider');?></label_sub></div>
							<div id="sps_specific_post"><input data-r="source.post.subType" type="radio" value="specific_post" name="slidersourcesubtype" class="easyinit sliderinput" data-show="#post_all_subtypesettings, #specificpost_subtype_settings_wrapper, .fetch_ .sorts_" data-hide="#post_subtype_settings_wrapper"><label_sub><?php _e('Specific Post', 'revslider');?></label_sub></div>
							<div id="sps_current_post"><input data-r="source.post.subType" type="radio" value="current_post" name="slidersourcesubtype" class="easyinit sliderinput" data-show="" data-hide="#post_all_subtypesettings"><label_sub><?php _e('Current Post', 'revslider');?></label_sub></div>
						</div>
					</div>
				</div>
			</div>

			<!-- POST VISIBILITY -->
			<div id="source_post_settings" class="source_subsetting_wrapper" style="display:none">
				<div id="post_all_subtypesettings">
					<!-- POST SSELECTION -->
					<div id="form_slider_content_post_selection" data-evt="loadStreamDependencies" class="form_inner open">
						<div class="form_inner_header"><i class="material-icons">description</i><?php _e('Post Selection', 'revslider');?></div>
						<div style="display:none"  class="form_intoaccordion" data-trigger="#slr_fsc_l2"><i class="material-icons">arrow_drop_down</i></div>
						<div class="collapsable">
							<div id="post_subtype_settings_wrapper">
								<label_a><?php _e('Fetch By', 'revslider');?></label_a><select id="post_fetch_type" name="post_fetch_type" class="sliderinput tos2 nosearchbox easyinit" data-r="source.post.fetchType" data-show=".fetch_ .*val*_, ._show_*val*" data-hide=".fetch_ .dep_, ._*val*_hide">
									<option value="cat_tag"><?php _e('Categories & Tags', 'revslider');?></option>
									<option value="related"><?php _e('Related', 'revslider');?></option>
									<option value="popular"><?php _e('Popular', 'revslider');?></option>
									<option value="recent"><?php _e('Recent', 'revslider');?></option>
									<option value="next_prev"><?php _e('Next / Previous', 'revslider');?></option>
								</select><span class="linebreak"></span>
								<div class="fetch_dependencies fetch_cat_tag_settings">
									<label_a><?php _e('Post Types:', 'revslider');?></label_a><select id="post_types" name="post_types" multiple  data-evt="updateSourcePostCategories" class="sliderinput tos2 searchbox easyinit" data-r="source.post.types">
										<?php
if (!empty($post_type)) {
	foreach ($post_type as $post_handle => $post_name) {
		echo '<option value="' . $post_handle . '">' . $post_name . '</option>';
	}
}
?>
									</select><span class="linebreak"></span>
									<div class="_show_cat_tag _show_related _show_popular _show_recent _next_prev_hide "><label_a><?php _e('Categories:', 'revslider');?></label_a><select id="post_category" name="post_category" multiple class="sliderinput tos2 nosearchbox easyinit" data-r="source.post.category"></select><span class="linebreak"></span></div>
								</div>
							</div>
							<div id="specificpost_subtype_settings_wrapper">
								<label_a><?php _e('Specific Posts', 'revslider');?></label_a><input class="sliderinput  fullinput easyinit" data-r="source.post.list" type="text" placeholder="<?php _e('coma separated list | ex: 23,24,25', 'revslider');?>" id="sr_source_post_list"><span class="linebreak"></span>
								<label_a></label_a><div class="basic_action_button extendval" data-extendval="<?php echo implode(',', $popular); ?>" data-inp="#sr_source_post_list"><i class="material-icons">add_circle</i><?php _e('Popular Posts', 'revslider');?></div>
								<label_a></label_a><div class="basic_action_button extendval" data-extendval="<?php echo implode(',', $recent); ?>" data-inp="#sr_source_post_list"><i class="material-icons">add_circle</i><?php _e('Recent Posts', 'revslider');?></div>
							</div>
						</div>
					</div><!-- END OF POST SELECTION -->

					<div class="fetch_">
						<!-- POST SORTIN AND SETTINGS -->
						<div id="form_slider_content_post_sort" data-evt="loadStreamDependencies" class="form_inner open">
							<div class="form_inner_header"><i class="material-icons">sort_by_alpha</i><?php _e('Sorting & Settings', 'revslider');?></div>
							<div style="display:none" class="form_intoaccordion" data-trigger="#slr_fsc_l3"><i class="material-icons">arrow_drop_down</i></div>
							<div class="collapsable">
								<div class="sorts_ dep_ cat_tag_ related_">
									<label_a><?php _e('Sort Posts By:', 'revslider');?></label_a><select id="post_sortby" name="post_sortby" data-theme="wideopentos2" class="sliderinput tos2 nosearchbox easyinit" data-r="source.post.sortBy">
										<option value="ID"><?php _e('Post ID', 'revslider');?></option>
										<option value="date"><?php _e('Date', 'revslider');?></option>
										<option value="title"><?php _e('Title', 'revslider');?></option>
										<option value="name"><?php _e('Slug', 'revslider');?></option>
										<option value="author" ><?php _e('Author', 'revslider');?></option>
										<option value="modified"><?php _e('Last Modified', 'revslider');?></option>
										<option value="comment_count"><?php _e('Number Of Comments', 'revslider');?></option>
										<option value="rand"><?php _e('Random', 'revslider');?></option>
										<option value="none"><?php _e('Unsorted', 'revslider');?></option>
										<option value="menu_order"><?php _e('Custom Order', 'revslider');?></option>
										<?php
if (RevSliderEventsManager::isEventsExists()) {
	$arrEMSortBy = RevSliderEventsManager::getArrSortBy();
	if (!empty($arrEMSortBy)) {
		foreach ($arrEMSortBy as $event_handle => $event_name) {
			echo '<option value="' . $event_handle . '">' . $event_name . '</option>';
		}
	}
}
?>
									</select>
									<span class="linebreak"></span>
								</div>
								<div class="sorts_ dep_ cat_tag_ related_"><label_a><?php _e('Sort Direction', 'revslider');?></label_a>
									<div class="radiooption">
										<div id="srcpostsortdirections_DESC"><input data-r="source.post.sortDirection" type="radio" value="DESC" name="slidersourcesortDirection" class="easyinit sliderinput" ><label_sub><?php _e('Descending', 'revslider');?></label_sub></div>
										<div id="srcpostsortdirections_ASC"><input data-r="source.post.sortDirection" type="radio" value="ASC" name="slidersourcesortDirection" class="easyinit sliderinput"><label_sub><?php _e('Ascending', 'revslider');?></label_sub></div>
									</div>
									<div class="div15"></div>
								</div>
								<div class="sorts_ dep_ cat_tag_ related_ popular_ recent_"><label_a><?php _e('Max Posts', 'revslider');?></label_a><input class="sliderinput valueduekeyboard smallinput easyinit" data-r="source.post.maxPosts" data-min="0" data-max="500" type="text" id="sr_source_post_maxposts"><span class="linebreak"></span></div>
								<div class="sorts_ dep_ cat_tag_ related_ popular_ recent_"><label_a><?php _e('Limit Excerpt', 'revslider');?></label_a><input data-allowed="chars,words" data-numeric="true" class="sliderinput valueduekeyboard smallinput easyinit" data-r="source.post.excerptLimit" data-min="0" data-max="500" type="text" id="sr_source_post_limitexc"><span class="linebreak"></span></div>
							</div>
						</div>		<!-- END OF POST SORTING AND SETTINGS -->
					</div><!-- END OF FETCH CONTAINER -->
				</div>
			</div><!-- END OF VISIBILITY POST SELECTION -->


			<!-- CUSTOM SETTINGS-->
			<div id="source_gallery_settings" class="source_subsetting_wrapper" style="display:none">
				<div class="form_inner open">
					<div class="collapsable">
						<row class="direktrow">
							<labelhalf><i class="material-icons vmi">sms_failed</i></labelhalf>
							<contenthalf><div class="function_info"><?php _e('No further source settings needed. Content is created manually.', 'revslider');?></div></contenthalf>
						</row>
					</div>
				</div>
			</div><!-- END OF CUSTOM SETTINGS -->

			<!-- WOO VISIBILITY -->
			<div id="source_woo_settings" class="source_subsetting_wrapper" style="display:none">
				<!-- WOOCOMMERCE TYPE AND CATEGORIES-->
				<div id="form_slider_content_woo_tandc" data-evt="loadStreamDependencies" class="form_inner open">
					<div class="form_inner_header"><i class="material-icons">label</i><?php _e('Types & Categories', 'revslider');?></div>
					<div style="display:none"  class="form_intoaccordion" data-trigger="#slr_fsc_l4"><i class="material-icons">arrow_drop_down</i></div>
					<div class="collapsable">

						<label_a><?php _e('Types', 'revslider');?></label_a><select id="woo_types" name="woo_types" multiple  data-evt="updateSourceWooCategories" data-theme="wideopentos2" class="sliderinput tos2 nosearchbox easyinit" data-r="source.woo.types">
							<?php
$woo_type = RevSliderWooCommerce::getCustomPostTypes();
if (!empty($woo_type)) {
	foreach ($woo_type as $post_handle => $post_name) {
		echo '<option value="' . $post_handle . '">' . $post_name . '</option>';
	}
}
?>
						</select>


						<label_a><?php _e('Product Categories', 'revslider');?></label_a><select id="woo_category" name="woo_category" multiple data-theme="wideopentos2" class="sliderinput tos2 nosearchbox easyinit" data-r="source.woo.category"></select>
					</div>
				</div><!-- END OF WOOCOMMERCE TYPE AND CATEGORIES-->

				<!-- WOO FILTERS -->
				<div id="form_slider_content_woo_filters" data-evt="loadStreamDependencies" class="form_inner open">
					<div class="form_inner_header"><i class="material-icons">filter_list</i><?php _e('Filters', 'revslider');?></div>
					<div style="display:none"  class="form_intoaccordion" data-trigger="#slr_fsc_l5"><i class="material-icons">arrow_drop_down</i></div>
					<div class="collapsable">
						<row class="direktrow">
							<onelong><label_a><?php _e('Regular Price', 'revslider');?></label_a><input class=" sliderinput valueduekeyboard smallinput easyinit" data-r="source.woo.regPriceFrom" data-min="0" data-max="9999999" placeholder="<?php _e('From', 'revslider');?>" type="text" id="sr_source_woo_regPriceFrom"></onelong>
							<oneshort><input class=" sliderinput valueduekeyboard smallinput easyinit" placeholder="<?php _e('To', 'revslider');?>"  data-r="source.woo.regPriceTo" data-min="0" data-max="9999999" type="text" id="sr_source_woo_regPriceTo"><span class="linebreak"></span></oneshort>
						</row>
						<row class="direktrow">
							<onelong><label_a><?php _e('Sale Price', 'revslider');?></label_a><input class=" sliderinput valueduekeyboard smallinput easyinit" data-r="source.woo.salePriceFrom" data-min="0" data-max="9999999" placeholder="<?php _e('From', 'revslider');?>"  type="text" id="sr_source_woo_salePriceFrom"></onelong>
							<oneshort><input class=" sliderinput valueduekeyboard smallinput easyinit" placeholder="<?php _e('To', 'revslider');?>"  data-r="source.woo.salePriceTo" data-min="0" data-max="9999999" type="text" id="sr_source_woo_salePriceTo"></oneshort>
						</row>
						<label_a><?php _e('In Stock Only', 'revslider');?></label_a><input type="checkbox"  id="sr_woo_stock" class="sliderinput easyinit" data-r="source.woo.inStockOnly"/><span class="linebreak"></span>
						<label_a><?php _e('Featured Only', 'revslider');?></label_a><input type="checkbox"  id="sr_woo_feat" class="sliderinput easyinit" data-r="source.woo.featuredOnly" /><span class="linebreak"></span>
					</div>
				</div><!-- END OF WOO FILTERS -->
				<!-- WOO SORT -->
				<div id="form_slider_content_woo_sort" data-evt="loadStreamDependencies" class="form_inner open">
					<div class="form_inner_header"><i class="material-icons">sort_by_alpha</i><?php _e('Sorting & Limitations', 'revslider');?></div>
					<div style="display:none"  class="form_intoaccordion" data-trigger="#slr_fsc_l6"><i class="material-icons">arrow_drop_down</i></div>
					<div class="collapsable">
						<label_a><?php _e('Sort Prod. By', 'revslider');?></label_a><select id="woo_sortby" name="woo_sortby" data-theme="wideopentos2" class="sliderinput tos2 nosearchbox easyinit" data-r="source.woo.sortBy">
							<?php
foreach ($wc_sortby as $wc_val => $wc_name) {
	?>
									<option value="<?php echo $wc_val; ?>"><?php echo $wc_name; ?></option>
									<?php
}
?>
							<option value="ID" selected="selected"><?php _e('Post ID', 'revslider');?></option>
							<option value="date"><?php _e('Date', 'revslider');?></option>
							<option value="title"><?php _e('Title', 'revslider');?></option>
							<option value="name"><?php _e('Slug', 'revslider');?></option>
							<option value="author"><?php _e('Author', 'revslider');?></option>
							<option value="modified"><?php _e('Last Modified', 'revslider');?></option>
							<option value="comment_count"><?php _e('Number Of Comments', 'revslider');?></option>
							<option value="rand"><?php _e('Random', 'revslider');?></option>
							<option value="none"><?php _e('Unsorted', 'revslider');?></option>
							<option value="menu_order"><?php _e('Custom Order', 'revslider');?></option>
						</select><span class="linebreak"></span>
						<label_a><?php _e('Sort Direction', 'revslider');?></label_a>
						<div class="radiooption">
							<div><input data-r="source.woo.sortDirection" type="radio" value="DESC" name="slidersourcesortwooDirection" class="easyinit sliderinput" ><label_sub><?php _e('Descending', 'revslider');?></label_sub></div>
							<div><input data-r="source.woo.sortDirection" type="radio" value="ASC" name="slidersourcesortwooDirection" class="easyinit sliderinput"><label_sub><?php _e('Ascending', 'revslider');?></label_sub></div>
						</div>
						<div class="div15"></div>
						<label_a><?php _e('Max Posts', 'revslider');?></label_a><input class="sliderinput valueduekeyboard smallinput easyinit" data-r="source.woo.maxProducts" data-min="0" data-max="500" type="text" id="sr_source_woo_maxposts"><span class="linebreak"></span>
						<label_a><?php _e('Limit Excerpt', 'revslider');?></label_a><input class="sliderinput valueduekeyboard smallinput easyinit" data-r="source.woo.excerptLimit" data-min="0" data-max="500" type="text" id="sr_source_woo_limitexc"><span class="linebreak"></span>
					</div>
				</div><!-- END OF WOO SORT -->
			</div><!-- END OF WOOCOMMERCE VISIBILITY -->

			<!-- FLICKR SETTINGS -->
			<div id="source_flickr_settings" class="source_subsetting_wrapper" style="display:none">
				<!-- FLICKR SETTINGS-->
				<div id="form_slider_content_flickr" data-evt="loadStreamDependencies" class="form_inner open">
					<div class="form_inner_header"><i class="material-icons">vpn_key</i><?php _e('Flickr Settings', 'revslider');?></div>
					<div style="display:none"  class="form_intoaccordion" data-trigger="#slr_fsc_l7"><i class="material-icons">arrow_drop_down</i></div>
					<div class="collapsable">
						<label_a><?php _e('Slides', 'revslider');?></label_a><input placeholder="<?php _e('Amount of Slides', 'revslider');?>" class="sliderinput valueduekeyboard  easyinit" data-r="source.flickr.count" data-min="0" data-max="500" type="text" id="sr_source_flickr_count"><span class="linebreak"></span>
						<label_a><?php _e('Cache (sec)', 'revslider');?></label_a><input placeholder="<?php _e('i.e. 1200', 'revslider');?>" class="sliderinput valueduekeyboard  easyinit" data-r="source.flickr.transient" data-min="0" data-max="500" type="text" id="sr_source_flickr_transient"><span class="linebreak"></span>
						<label_a><?php _e('API Key', 'revslider');?></label_a><input placeholder="<?php _e('Enter your Api Key', 'revslider');?>" data-evt="flickrsourcechange" class="sliderinput easyinit" data-r="source.flickr.apiKey"  type="text" id="sr_source_flickr_apikey"><span class="linebreak"></span>
						<label_a><?php _e('Source', 'revslider');?></label_a><select id="flickr-type" data-evt="flickrsourcechange" data-theme="wideopentos2" class="sliderinput tos2 nosearchbox easyinit" data-r="source.flickr.type" data-show=".flickr_*val*" data-hide=".flickr_source_settings">
							<option value="publicphotos" title="<?php _e('Display a user\'s public photos', 'revslider');?>"><?php _e('User Public Photos', 'revslider');?></option>
							<option value="photosets" title="<?php _e('Display a certain photoset from a user', 'revslider');?>" selected="selected"><?php _e('User Photoset', 'revslider');?></option>
							<option value="gallery" title="<?php _e('Display a gallery', 'revslider');?>"><?php _e('Gallery', 'revslider');?></option>
							<option value="group" title="<?php _e('Display a group\'s photos', 'revslider');?>"><?php _e('Groups\' Photos', 'revslider');?></option>
						</select>
						<div class="flickr_source_settings flickr_publicphotos flickr_photosets">
							<label_a><?php _e('User URL:', 'revslider');?></label_a><input placeholder="<?php _e('Enter User URL', 'revslider');?>" data-r="source.flickr.userURL" data-evt="flickrsourcechange" type="text"  name="sr_src_flick_userurl" class="easyinit sliderinput"><span class="linebreak"></span>
							<div class="flickr_source_settings flickr_photosets">
								<label_a><?php _e('Photoset', 'revslider');?></label_a><select placeholder="<?php _e('Pick an Item', 'revslider');?>" id="sr_src_flickr_photoset" name="sr_src_flickr_photoset" data-theme="wideopentos2" class="sliderinput tos2 searchbox easyinit" data-r="source.flickr.photoSet"></select>
							</div>
						</div>
						<div class="flickr_source_settings flickr_gallery">
							<label_a><?php _e('Gallery URL', 'revslider');?></label_a><input placeholder="<?php _e('Enter Gallery URL', 'revslider');?>" data-r="source.flickr.galleryURL" type="text"  name="sr_src_flick_galleryurl" class="easyinit sliderinput"><span class="linebreak"></span>
						</div>
						<div class="flickr_source_settings flickr_group">
							<label_a><?php _e('Group URL', 'revslider');?></label_a><input placeholder="<?php _e('Enter Group URL', 'revslider');?>" data-r="source.flickr.groupURL" type="text"  name="sr_src_flick_groupyurl" class="easyinit sliderinput"><span class="linebreak"></span>
						</div>
						<div class="div10"></div>
						<row class="direktrow">
							<labelhalf><i class="material-icons vmi">sms_failed</i></labelhalf>
							<contenthalf><div class="function_info"><?php _e('Read <a target="_blank" rel="noopener" href="http://weblizar.com/get-flickr-api-key/">here</a> how to receive your Flickr API key', 'revslider');?></div></contenthalf>
						</row>

					</div> <!-- END OF COLLAPSE -->
				</div> <!-- END OF FLICKR SETTINGS -->
			</div><!-- END OF FLICKR VISIBILITY -->

			<!-- INSTAGRAM VISIVBILTY -->
			<div id="source_instagram_settings" class="source_subsetting_wrapper" style="display:none">
				<!-- INSTAGRAM SETTINGS -->
				<div id="form_slider_content_insta" data-evt="loadStreamDependencies" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">vpn_key</i><?php _e('Instagram Settings', 'revslider');?></div>
				<div style="display:none"  class="form_intoaccordion" data-trigger="#slr_fsc_l8"><i class="material-icons">arrow_drop_down</i></div>
					<div class="collapsable">
						<label_a><?php _e('Slides(<=33):', 'revslider');?></label_a><input placeholder="<?php _e('Amount of Slides', 'revslider');?>" class="sliderinput valueduekeyboard  easyinit" data-r="source.instagram.count" data-min="0" data-max="500" type="text" id="sr_source_instagram_count"><span class="linebreak"></span>
						<label_a><?php _e('Cache (sec):', 'revslider');?></label_a><input placeholder="<?php _e('i.e. 1200', 'revslider');?>" class="sliderinput valueduekeyboard  easyinit" data-r="source.instagram.transient" data-min="0" data-max="500" type="text" id="sr_source_instagram_transient"><span class="linebreak"></span>
						<input type="text" id="instagram-type" class="sliderinput valueduekeyboard easyinit" data-r="source.instagram.type" style="display: none;" />
						<label_a><?php _e('Token Source', 'revslider')?></label_a><select id="sr_source_instagram_token_source"  class="sliderinput easyinit tos2 nosearchbox" data-show=".token_source_*val*" data-hide=".token_source_container" data-r="source.instagram.token_source">
							<option value="account" selected="selected"><?php _e('From Account', 'revslider');?></option>
							<option value="manual"><?php _e('Manual', 'revslider');?></option>
						</select><span class="linebreak"></span>
						<div class="token_source_container token_source_account">
							<label_a><?php _e('Connected To', 'revslider');?></label_a><input type="text" placeholder="<?php _e('Not yet Connected', 'revslider');?>" id="intagram_connect_with" class="sliderinput valueduekeyboard easyinit" data-r="source.instagram.connect_with" disabled />
							<row>
								<div id="get_insta_token" class="basic_action_button fullbutton save_and_goto_button" data-goto="<?php echo RevSliderInstagram::get_login_url(); ?>"><i class="material-icons">person_add</i><?php _e('Connect an Instagram Account', 'revslider' ); ?></div>
							</row>
							<row>
								<labelhalf><i class="material-icons vmi">sms_failed</i></labelhalf>
								<contenthalf><div class="function_info"><?php _e('You will be redirected to Instagram and then back to the editor. Your current settings will be auto saved.', 'revslider');?></div></contenthalf>							
							</row>
						</div>
						<div class="token_source_container token_source_manual">
							<label_a><?php _e('Access Token', 'revslider');?></label_a><input placeholder="<?php _e('Enter the Access Token', 'revslider');?>" data-r="source.instagram.token" type="text" name="sr_src_instagram_token" class="easyinit sliderinput"><span class="linebreak"></span>
							<div class="div10"></div>
							<row>
								<labelhalf><i class="material-icons vmi">sms_failed</i></labelhalf>
																																	  
								<contenthalf><div class="function_info"><?php _e('Please check this FAQ on how to <a target="_blank" rel="noopener" href="https://www.sliderrevolution.com/faq/instagram-stream-setup-instructions-with-access-token/">generate</a> your Instagram Access Token in Facebook manually.', 'revslider');?></div></contenthalf>
							</row>
						</div>
					</div><!-- END OF COLLAPSABLE -->
				</div> <!-- END OF INSTAGRAM SETTINGS -->
			</div><!-- END OF INSTAGRAM VISIVBILTY -->


			<!-- TWITTER VISIBILITY  -->
			<div id="source_twitter_settings" class="source_subsetting_wrapper" style="display:none">
				<!-- INSTAGRAM SETTINGS -->
				<div id="form_slider_content_twitter" data-evt="loadStreamDependencies" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">vpn_key</i><?php _e('Twitter Settings', 'revslider');?></div>
				<div style="display:none"  class="form_intoaccordion" data-trigger="#slr_fsc_l9"><i class="material-icons">arrow_drop_down</i></div>
					<div class="collapsable">
						<label_a><?php _e('Slides (<500)', 'revslider');?></label_a><input placeholder="<?php _e('Amount of Slides', 'revslider');?>" class="sliderinput valueduekeyboard  easyinit" data-r="source.twitter.count" data-min="0" data-max="500" type="text" id="sr_source_twitter_count"><span class="linebreak"></span>
						<label_a><?php _e('Cache (sec)', 'revslider');?></label_a><input placeholder="<?php _e('i.e. 1200', 'revslider');?>" class="sliderinput valueduekeyboard  easyinit" data-r="source.twitter.transient" data-min="0" data-max="500" type="text" id="sr_source_twitter_transient"><span class="linebreak"></span>
						<label_a><?php _e('Twitter @', 'revslider');?></label_a><input placeholder="<?php _e('Enter Twitter Name', 'revslider');?>" data-r="source.twitter.userId" type="text"  name="sr_src_twitter_userid" class="easyinit sliderinput"><span class="linebreak"></span>
						<label_a><?php _e('Text Tweets', 'revslider');?></label_a><input type="checkbox"  id="sr_src_twitter_imageonly" class="sliderinput easyinit" data-r="source.twitter.imageOnly"/><span class="linebreak"></span>
						<label_a><?php _e('ReTweets', 'revslider');?></label_a><input type="checkbox"  id="sr_src_twitter_includeretweets" class="sliderinput easyinit" data-r="source.twitter.includeRetweets"/><span class="linebreak"></span>
						<label_a><?php _e('Replies', 'revslider');?></label_a><input type="checkbox"  id="sr_src_twitter_excludereplies" class="sliderinput easyinit" data-r="source.twitter.excludeReplies"/><span class="linebreak"></span>
						<label_a><?php _e('Consumer Key', 'revslider');?></label_a><input placeholder="<?php _e('Enter Consumer Key', 'revslider');?>" data-r="source.twitter.consumerKey" type="text"  name="sr_src_twitter_consumerKey" class="easyinit sliderinput"><span class="linebreak"></span>
						<label_a><?php _e('Cons. Secret', 'revslider');?></label_a><input placeholder="<?php _e('Enter Secret', 'revslider');?>" data-r="source.twitter.consumerSecret" type="text"  name="sr_src_twitter_consumerSecret" class="easyinit sliderinput"><span class="linebreak"></span>
						<label_a><?php _e('Access Token', 'revslider');?></label_a><input placeholder="<?php _e('Enter Access Token', 'revslider');?>" data-r="source.twitter.accessToken" type="text"  name="sr_src_twitter_accessToken" class="easyinit sliderinput"><span class="linebreak"></span>
						<label_a><?php _e('Access Secret', 'revslider');?></label_a><input placeholder="<?php _e('Enter Access Secret', 'revslider');?>" data-r="source.twitter.accessSecret" type="text"  name="sr_src_twitter_accessSecret" class="easyinit sliderinput"><span class="linebreak"></span>
						<div class="div10"></div>
						<row class="direktrow">
							<labelhalf><i class="material-icons vmi">sms_failed</i></labelhalf>
							<contenthalf><div class="function_info"><?php _e('Please <a target="_blank" rel="noopener" href="https://dev.twitter.com/apps">register</a> your application with Twitter<br>to get the right values', 'revslider');?></div></contenthalf>
						</row>
					</div><!-- END OF COLLAPSABLE -->
				</div><!-- END OF TWITTER SETTINGS -->
			</div><!-- END OF TWITTER VISIBILITY  -->

			<!-- FACEBOOK VISIBILTY -->
			<div id="source_facebook_settings" class="source_subsetting_wrapper" style="display:none">
				<!-- FACEBOOK SETTINGS -->
				<div id="form_slider_content_facebook" data-evt="loadStreamDependencies" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">vpn_key</i><?php _e('FaceBook Settings', 'revslider');?></div>
				<div style="display:none"  class="form_intoaccordion" data-trigger="#slr_fsc_l10"><i class="material-icons">arrow_drop_down</i></div>
					<div class="collapsable">
						<label_a><?php _e('Slides (<25)', 'revslider');?></label_a><input placeholder="<?php _e('Amount of Slides', 'revslider');?>" class=" sliderinput valueduekeyboard  easyinit" data-r="source.facebook.count" data-min="0" data-max="500" type="text" id="sr_source_facebook_count"><span class="linebreak"></span>
						<label_a><?php _e('Cache (sec)', 'revslider');?></label_a><input placeholder="<?php _e('i.e. 1200', 'revslider');?>" class=" sliderinput valueduekeyboard  easyinit" data-r="source.facebook.transient" data-min="0" data-max="500" type="text" id="sr_source_facebook_transient"><span class="linebreak"></span>
						<label_a><?php _e('Source', 'revslider');?></label_a><select id="facebook-typesource" data-evt="facebooksourcechange" data-theme="wideopentos2" class="sliderinput tos2 nosearchbox easyinit" data-r="source.facebook.typeSource" data-show=".facebook_*val*_settings" data-hide=".facebook_source_settings">
							<option value="album"><?php _e('Album', 'revslider');?></option>
							<option value="timeline"><?php _e('TimeLine', 'revslider');?></option>
						</select>
						<div class="facebook_album_settings facebook_source_settings">
							<label_a><?php _e('Select Album', 'revslider');?></label_a><select id="sr_src_facebok_album" name="sr_src_facebok_album" data-theme="wideopentos2" class="sliderinput tos2 searchbox easyinit" data-r="source.facebook.album"></select>
						</div>
						<label_a><?php _e('Token Source', 'revslider')?></label_a><select id="sr_source_facebook_token_source"  class="sliderinput easyinit tos2 nosearchbox" data-show=".facebook_token_source_*val*" data-hide=".facebook_token_source_container" data-r="source.facebook.token_source">
							<option value="account" selected="selected"><?php _e('From Account', 'revslider');?></option>
							<option value="manual"><?php _e('Manual', 'revslider');?></option>
						</select><span class="linebreak"></span>
						<div class="facebook_token_source_container facebook_token_source_account">
							<label_a><?php _e('Connected To', 'revslider');?></label_a><input type="text" placeholder="<?php _e('Not yet Connected', 'revslider');?>" id="facebook_connect_with" class="sliderinput valueduekeyboard easyinit" data-r="source.facebook.connect_with" disabled />
							<row>
								<div id="get_facebook_token" class="basic_action_button fullbutton save_and_goto_button" data-goto="<?php echo RevSliderFacebook::get_login_url(); ?>"><i class="material-icons">person_add</i><?php _e('Connect Facebook Account', 'revslider' ); ?></div>
							</row>
							<row>
								<labelhalf><i class="material-icons vmi">sms_failed</i></labelhalf>
								<contenthalf><div class="function_info"><?php _e('You will be redirected to Facebook and then back to the editor. Current settings will be auto saved.', 'revslider');?></div></contenthalf>
							</row>
						</div>
						<div class="facebook_token_source_container facebook_token_source_manual">
							<label_a><?php _e('Access Token', 'revslider');?></label_a><input type="text" placeholder="<?php _e('Enter the Access Token', 'revslider');?>" data-r="source.facebook.appId"  name="sr_src_facebook_appid" class="easyinit sliderinput"><span class="linebreak"></span>
							<label_a><?php _e('Page ID', 'revslider');?></label_a><input type="text" placeholder="<?php _e('Enter Facebook Page ID', 'revslider');?>" data-r="source.facebook.page_id" name="sr_src_facebook_page_id" class="easyinit sliderinput"><span class="linebreak"></span>
							<div class="div10"></div>
							<row>
								<labelhalf><i class="material-icons vmi">sms_failed</i></labelhalf>
								<contenthalf><div class="function_info"><?php _e('Check the FAQ on <a target="_blank" rel="noopener" href="https://www.sliderrevolution.com/faq/facebook-stream-setup-instructions-access-token/">how to generate</a> Access Token and get Page ID.', 'revslider');?></div></contenthalf>
							</row>
						</div>

					</div><!-- END OF COLLAPSABLE -->
				</div><!-- END OF FACEBOOK SETTINGS -->
			</div><!-- END OF FACEBOOK VISIBILITY  -->

			<!-- YOUTUBE VISIBILITY -->
			<div id="source_youtube_settings" class="source_subsetting_wrapper" style="display:none">
				<!-- YOUTUBE SETTINGS -->
				<div id="form_slider_content_youtube" data-evt="loadStreamDependencies" class="form_inner open">
					<div class="form_inner_header"><i class="material-icons">vpn_key</i><?php _e('YouTube Settings', 'revslider');?></div>
					<div style="display:none"  class="form_intoaccordion" data-trigger="#slr_fsc_l11"><i class="material-icons">arrow_drop_down</i></div>
					<div class="collapsable">
						<label_a><?php _e('Slides (<25)', 'revslider');?></label_a><input placeholder="<?php _e('Amount of Slides', 'revslider');?>" class=" sliderinput valueduekeyboard  easyinit" data-r="source.youtube.count" data-min="0" data-max="500" type="text" id="sr_source_youtube_count"><span class="linebreak"></span>
						<label_a><?php _e('Cache (sec)', 'revslider');?></label_a><input placeholder="<?php _e('i.e. 1200', 'revslider');?>" class=" sliderinput valueduekeyboard  easyinit" data-r="source.youtube.transient" data-min="0" data-max="500" type="text" id="sr_source_youtube_transient"><span class="linebreak"></span>
						<label_a><?php _e('API Key', 'revslider');?></label_a><input placeholder="<?php _e('Enter Api Key', 'revslider');?>" data-r="source.youtube.api" type="text"  data-evt="youtubesourcechange" name="sr_src_youtube_api" class="easyinit sliderinput"><span class="linebreak"></span>
						<div class="div10"></div>
						<row >
							<labelhalf><i class="material-icons vmi">sms_failed</i></labelhalf>
							<contenthalf><div class="function_info"><?php _e('Find information about the YouTube API key <a target="_blank" rel="noopener" href="https://developers.google.com/youtube/v3/getting-started#before-you-start">here</a>', 'revslider');?></div></contenthalf>
						</row>
						<div class="div10"></div>
						<label_a><?php _e('Channel ID', 'revslider');?></label_a><input placeholder="<?php _e('Enter YouTube Channel ID', 'revslider');?>" data-r="source.youtube.channelId" type="text" data-evt="youtubesourcechange" name="sr_src_youtube_channelId" class="easyinit sliderinput"><span class="linebreak"></span>
						<label_a><?php _e('Source', 'revslider');?></label_a><select id="youtube-typesource" data-evt="youtubesourcechange" data-theme="wideopentos2" class="sliderinput tos2 nosearchbox easyinit" data-r="source.youtube.typeSource" data-show=".youtube_*val*_settings" data-hide=".youtube_source_settings">
							<option value="playlist"><?php _e('Playlist', 'revslider');?></option>
							<option value="channel"><?php _e('Channel', 'revslider');?></option>
						</select>
						<div class="youtube_playlist_settings youtube_source_settings">
							<label_a><?php _e('Select Playlist', 'revslider');?></label_a><select id="sr_src_youtube_playlist" name="sr_src_youtube_playlist" data-theme="wideopentos2" class="sliderinput tos2 searchbox easyinit" data-r="source.youtube.playList"></select>
						</div>
						<div class="div10"></div>
						<row >
							<labelhalf><i class="material-icons vmi">sms_failed</i></labelhalf>
							<contenthalf><div class="function_info"><?php _e('See how to find the Youtube channel ID <a target="_blank" rel="noopener" href="https://support.google.com/youtube/answer/3250431?hl=en">here</a>', 'revslider');?></div></contenthalf>
						</row>
						<div class="div10"></div>
						<row class="direktrow">
							<labelhalf><i class="material-icons vmi">sms_failed</i></labelhalf>
							<contenthalf><div class="function_info"><?php _e('The “YouTube Stream” content source is used to display a full stream of videos from a channel/playlist.<br> If you want to display a single youtube video, please select the content source “Default Slider” and add a video layer in the slide editor.', 'revslider');?></div></contenthalf>
						</row>
					</div><!-- END OF COLLAPSABLE -->
				</div><!-- END OF YOUTUBE SETTINGS -->
			</div><!-- END OF YOUTUBE VISIBILITY  -->

			<!-- VIMEO VISIBILITY -->
			<div id="source_vimeo_settings" class="source_subsetting_wrapper" style="display:none">
				<!-- VIMEO SETTINGS -->
				<div id="form_slider_content_vimeo" data-evt="loadStreamDependencies" class="form_inner open">
					<div class="form_inner_header"><i class="material-icons">vpn_key</i><?php _e('Vimeo Settings', 'revslider');?></div>
					<div style="display:none"  class="form_intoaccordion" data-trigger="#slr_fsc_l12"><i class="material-icons">arrow_drop_down</i></div>
					<div class="collapsable">
						<label_a><?php _e('Slides (<60)', 'revslider');?></label_a><input placeholder="<?php _e('Amount of Slides', 'revslider');?>" class=" sliderinput valueduekeyboard  easyinit" data-r="source.vimeo.count" data-min="0" data-max="60" type="text" id="sr_source_vimeo_count"><span class="linebreak"></span>
						<label_a><?php _e('Cache (sec)', 'revslider');?></label_a><input placeholder="<?php _e('i.e. 1200', 'revslider');?>" class=" sliderinput valueduekeyboard  easyinit" data-r="source.vimeo.transient" data-min="0" data-max="2500" type="text" id="sr_source_vimeo_transient"><span class="linebreak"></span>
						<label_a><?php _e('Source', 'revslider');?></label_a><select id="vimeo-typesource" data-theme="wideopentos2" class="sliderinput tos2 nosearchbox easyinit" data-r="source.vimeo.typeSource" data-show=".vimeo_*val*_settings" data-hide=".vimeo_source_settings">
							<option value="user"><?php _e('User', 'revslider');?></option>
							<option value="album"><?php _e('Showcase', 'revslider');?></option>
							<option value="group"><?php _e('Group', 'revslider');?></option>
							<option value="channel"><?php _e('Channel', 'revslider');?></option>
						</select>
						<div class="vimeo_user_settings vimeo_source_settings">
							<label_a><?php _e('User', 'revslider');?></label_a><input placeholder="<?php _e('Enter User Name', 'revslider');?>" type="text" id="sr_src_vimeo_userName" name="sr_src_vimeo_userName" class="sliderinput easyinit" data-r="source.vimeo.userName">
						</div>
						<div class="vimeo_album_settings vimeo_source_settings">
							<label_a><?php _e('Showcase', 'revslider');?></label_a><input placeholder="<?php _e('Enter Showcase Id', 'revslider');?>" type="text" id="sr_src_vimeo_albumId" name="sr_src_vimeo_albumId" class="sliderinput easyinit" data-r="source.vimeo.albumId">
						</div>
						<div class="vimeo_group_settings vimeo_source_settings">
							<label_a><?php _e('Group', 'revslider');?></label_a><input placeholder="<?php _e('Enter Group Name', 'revslider');?>" type="text" id="sr_src_vimeo_groupName" name="sr_src_vimeo_groupName" class="sliderinput easyinit" data-r="source.vimeo.groupName">
						</div>
						<div class="vimeo_channel_settings vimeo_source_settings">
							<label_a><?php _e('Channel', 'revslider');?></label_a><input placeholder="<?php _e('Enter Channel Name', 'revslider');?>" type="text" id="sr_src_vimeo_channelName" name="sr_src_vimeo_channelName" class="sliderinput easyinit" data-r="source.vimeo.channelName">
						</div>
						<row class="direktrow">
							<labelhalf><i class="material-icons vmi">sms_failed</i></labelhalf>
							<contenthalf><div class="function_info"><?php _e('The “Vimeo Stream” content source is used to display a full stream of videos from a user/album/group/channel.<br> If you want to display a single vimeo video, please select the content source “Default Slider” and add a video layer in the slide editor.', 'revslider');?></div></contenthalf>
						</row>
					</div><!-- END OF COLLAPSABLE -->
				</div><!-- END OF VIMEO SETTINGS -->
			</div><!-- END OF VIMEO VISIBILITY  -->
		</div>
	</div><!-- END OF SLIDER CONTENT SETTINGS -->

	<!-- GENERAL SETTINGS-->
	<div class="form_collector slider_general_collector" data-type="sliderconfig" data-pcontainer="#slider_settings" data-offset="#rev_builder_wrapper">
		<div id="form_module_general_settings"  data-select="#gst_sl_6"  class="formcontainer form_menu_inside collapsed">
			<!--<div class="collectortabwrap"><div id="" class="collectortab form_menu_inside" data-forms='["#form_module_general_settings"]'><?php _e('General Settings', 'revslider');?></div></div>						-->
			<!-- GENERAL INNER SETTINGS-->

			<div id="form_slidergeneral_general_viewport" class="form_inner">
				<div class="form_inner_header"><i class="material-icons">play_circle_outline</i><?php _e('Dynamic Viewport Loading', 'revslider');?></div>
				<div class="div5"></div>
				<div class="collapsable" style="display:block !important">
					<longoption><label_a><?php _e('ViewPort Stop', 'revslider');?></label_a><input type="checkbox"  id="sr_viewport" class="sliderinput easyinit" data-r="general.slideshow.viewPort" data-showhide=".slider_stopslider_viewport" data-showhidedep="true"/></longoption>
					<div class="slider_stopslider_viewport">
						<div class="div10"></div>
						<row class="direktrow">
							<onelong><label_icon class="ui_outofviewport"></label_icon><select id="sr_sshow_outviewport" class="sliderinput tos2 nosearchbox easyinit" data-r="general.slideshow.viewPortStart"><option value="wait"><?php _e('Wait', 'revslider');?></option><option value="pause"><?php _e('Pause', 'revslider');?></option></select></onelong>
							<oneshort><label_icon class="ui_viewportpercent"></label_icon><input data-numeric="true" data-allowed="%,px" class="sliderinput valueduekeyboard input_with_presets easyinit" data-presets_text="$C$px!$C$%!" data-presets_val="100px!20%!" data-responsive="true" data-r="general.slideshow.viewPortArea.#size#.v" data-min="-1500" data-max="1500" type="text" id="sr_viewport_area"></oneshort>
						</row>
						<row class="direktrow">
							<onelong><label_icon class="ui_presetheight"></label_icon><input type="checkbox"  id="sr_viewportpresetheight" class="sliderinput easyinit" data-r="general.slideshow.presetSliderHeight"/></onelong>
							<oneshort></oneshort>
						</row>
					</div>
				</div>
			</div>

			<div id="form_slidergeneral_general" class="form_inner">
				<div class="form_inner_header"><i class="material-icons">play_circle_outline</i><?php _e('Slideshow', 'revslider');?></div>
				<div class="collapsable" style="display:block !important">
					<!-- SLIDER SLIDESHOW SETTINGS -->
					<div id="form_slidergeneral_slideshow" class="form_level_2_inner">
						<div id="rs-autorotate-wrap"><longoption><label_a><?php _e('Auto Rotate Slideshow', 'revslider');?></label_a><input type="checkbox"  id="sr_slideshowonoff" class="sliderinput easyinit callEvent" data-updateviaevt="true" data-evt="updateAutoRotate" data-showhide="#generalslideshow" data-showhidedep="true" data-r="general.slideshow.slideShow"/></longoption></div>
						<div id="generalslideshow" class="herodisable carouselenable standardenable">
							<longoption><label_a><?php _e('Stop on Hover', 'revslider');?></label_a><input type="checkbox"  id="sr_ssonhover" class="sliderinput easyinit" data-r="general.slideshow.stopOnHover"/></longoption>
							<longoption><label_a><?php _e('Loop One Slide', 'revslider');?></label_a><input type="checkbox"  id="sr_loopsingle" class="sliderinput easyinit" data-r="general.slideshow.loopSingle"/></longoption>
							<longoption><label_a><?php _e('Stop after N Loops', 'revslider');?></label_a><input type="checkbox"  id="sr_disendloop" class="sliderinput easyinit" data-r="general.slideshow.stopSlider" data-showhide=".slider_stopslider_settings" data-showhidedep="true"/></longoption>
							<div class="direktrow slider_stopslider_settings"></div>
							<div class="div5"></div>
							<row>
								<onelong><label_icon class="ui_stopafterloop"></label_icon><input class="sliderinput valueduekeyboard smallinput easyinit" data-r="general.slideshow.stopAfterLoops" data-min="0" data-max="100" type="text" id="sr_sshw_amountloops"></onelong>
								<oneshort><label_icon class="ui_stopatslide"></label_icon><input class="sliderinput valueduekeyboard smallinput easyinit" data-r="general.slideshow.stopAtSlide" data-min="0" data-max="999" type="text" id="sr_sshw_atSlide"></oneshort>
							</row>
							<longoption><label_a><?php _e('Random Order', 'revslider');?></label_a><input type="checkbox"  id="sr_randomslideshow" class="sliderinput easyinit" data-r="general.slideshow.shuffle"/></longoption>
						</div>

						<longoption><label_a><?php _e('Wait for API', 'revslider');?></label_a><input type="checkbox"  id="sr_waitrevapi" class="sliderinput easyinit" data-r="general.slideshow.waitForInit"/></longoption>
					</div>
					<div class="div5"></div>
				</div>
			</div>

			<!-- SLIDER 1ST SLIDE -->
			<div id="form_slidergeneral_general_first_slide" class="form_inner">
				<div class="form_inner_header"><i class="material-icons">filter_1</i><?php _e('First Slide', 'revslider');?></div>
				<div class="collapsable" style="display:block !important">
					<row class="direktrow">
						<onelong><label_a><?php _e('Other 1. Slide', 'revslider');?></label_a><input data-showhide=".slider_othertslide" data-showhidedep="true" type="checkbox"  id="sr_gen_alternativeFirstSlideSet" class="sliderinput easyinit" data-r="general.firstSlide.alternativeFirstSlideSet" /></onelong>
						<oneshort class="slider_othertslide"><label_a class="short"><?php _e('#', 'revslider');?></label_a><input class="sliderinput valueduekeyboard smallinput easyinit" data-r="general.firstSlide.alternativeFirstSlide" type="text" id="sr_gen_firstSlide_alternativeFirstSlide" ></oneshort>
					</row>
					<label_a><?php _e('Diff. Anim', 'revslider');?></label_a><input type="checkbox"  id="sr_gen_fs" class="sliderinput easyinit" data-r="general.firstSlide.set" data-showhide=".slider_firstslide" data-showhidedep="true"/>
					<div class="slider_firstslide">
						<label_a><?php _e('Transitions', 'revslider')?></label_a><select id="sr_gen_fs_transition" class="sliderinput tos2 searchbox easyinit slideAnimSelect" data-theme="wideopentos2" data-r="general.firstSlide.type">
							</select>
						<label_a><?php _e('Duration', 'revslider');?></label_a><input data-numeric="true" data-allowed="ms" class="sliderinput valueduekeyboard  easyinit" data-r="general.firstSlide.duration" data-min="0" data-max="1000000" type="text" id="sr_gen_fsduration" />
						<!--<label_a><?php _e('Slot Amount', 'revslider');?></label_a><input data-numeric="true" data-allowed="none" class="sliderinput valueduekeyboard smallinput easyinit" data-r="general.firstSlide.slotAmount" data-min="0" data-max="1000000" type="text" id="sr_gen_fsslotamount">-->
					</div>
				</div>
			</div>

			<!-- Disable On Mobile-->
			<div id="form_slidergeneral_general_disable_mobile" class="form_inner">
				<div class="form_inner_header"><i class="material-icons">phonelink_lock</i><?php _e('Disable on Mobile', 'revslider');?></div>
				<div class="collapsable" style="display:block !important">
					<longoption><label_a><?php _e('Disable Slider', 'revslider');?></label_a><input type="checkbox"  id="sr_gen_disonmob" class="sliderinput easyinit" data-r="general.disableOnMobile"/></longoption>
					<longoption><label_a><?php _e('Disable Ken B.', 'revslider');?></label_a><input type="checkbox"  id="sr_gen_disablePanZoomMobile" class="sliderinput easyinit" data-r="general.disablePanZoomMobile"/></longoption>
				</div>
				<div class="div5"></div>
			</div>
			<!-- Under Borwser width-->
			<div id="form_slidergeneral_general_under_browser_width" class="form_inner">
				<div class="form_inner_header"><i class="material-icons">phonelink_off</i><?php _e('Hide Under Browser width...', 'revslider');?></div>
				<div class="collapsable" style="display:block !important">
					<label_a><?php _e('Slider', 'revslider');?></label_a><input data-numeric="true" data-allowed="px" type="text"  id="sr_vis_hideSliderUnderLimit" class="sliderinput easyinit  " data-r="visibility.hideSliderUnderLimit"/>
					<label_a><?php _e('Marked Layers', 'revslider');?></label_a><input data-numeric="true" data-allowed="px" type="text"  id="sr_vis_hideSelectedLayersUnderLimit" class="sliderinput easyinit  " data-r="visibility.hideSelectedLayersUnderLimit"/>
					<label_a><?php _e('All Layers', 'revslider');?></label_a><input type="text" data-numeric="true" data-allowed="px" id="sr_vis_hideAllLayersUnderLimit" class="sliderinput easyinit " data-r="visibility.hideAllLayersUnderLimit"/>
				</div>
			</div>
			<!-- MOBILE SETTINGS -->
			<div id="form_slidergeneral_general_mobile_settings" class="form_inner">
				<div class="form_inner_header"><i class="material-icons">phonelink_setup</i><?php _e('Mobile Settings', 'revslider');?></div>
				<div class="collapsable" style="display:block !important">
					<longoption><label_a><?php _e('HTML5 Autoplay', 'revslider');?></label_a><input type="checkbox"  id="sr_autoPlayVideoOnMobile" class="sliderinput easyinit" data-r="general.autoPlayVideoOnMobile"/></longoption>
					<div class="div10"></div>
					<row class="direktrow">
						<labelhalf><i class="material-icons vmi">sms_failed</i></labelhalf>
						<contenthalf><div class="function_info"><?php _e('Option is depricated and will be removed in upcoming updates !', 'revslider');?></div></contenthalf>
					</row>
				</div>
			</div>



			<!-- SLIDER MISC SETTINGS -->
			<div id="form_slidergeneral_misc" class="form_inner">
				<div class="form_inner_header"><i class="material-icons">web</i><?php _e('Browser behavior', 'revslider');?></div>
				<div class="collapsable" style="display:block !important">
					<!-- SLIDER MISC. SETTINGS -->
					<longoption><label_a ><?php _e('Observe Wrapper Container', 'revslider');?></label_a><input type="checkbox"  id="sr_gen_observeWrapper" class="sliderinput easyinit" data-r="general.observeWrap" /></longoption>
					<longoption><label_a ><?php _e('Next on Browser Focus', 'revslider');?></label_a><input type="checkbox"  id="sr_gen_nextSlideOnFocus" class="sliderinput easyinit" data-r="general.nextSlideOnFocus" /></longoption>
					<longoption><label_a ><?php _e('Disable Blur/Focus behav.', 'revslider');?></label_a><input type="checkbox"  id="sr_gen_disableFocusListener" class="sliderinput easyinit" data-r="general.disableFocusListener" /></longoption>
					<longoption><label_a ><?php _e('Set Deeplink Hash in URL', 'revslider');?></label_a><input type="checkbox"  id="sr_gen_enableurlhash" class="sliderinput easyinit" data-r="general.enableurlhash" /></longoption>
				</div><!-- END OF COLLAPSABLE-->
				<div class="div5"></div>
			</div>
			<!-- WPML SETTINGS -->
			<?php
if ($wpml->wpml_exists()) {
	?>
			<!-- USE WPML-->
			<div id="form_slidergeneral_general_usewpml" class="form_inner">
				<div class="form_inner_header"><i class="material-icons">language</i><?php _e('WPML', 'revslider');?></div>
				<div class="collapsable" style="display:block !important">
					<longoption><i class="material-icons">language</i><label_a><?php _e('Use WPML Settings', 'revslider');?></label_a><input type="checkbox"  data-setclasson="body" data-class="rs-multilanguage_on" data-inversclass="rs-multilanguage_off" data-id="sr_gen_wpml" class="sliderinput easyinit" data-r="general.useWPML"/></longoption>
				</div>
				<div class="div5"></div>
			</div>
			<?php }
?>

			<!--END OF MODULE TITLE AND ALIAS AND SHORTCODE SETTINGS -->
		</div>
	</div><!-- END OF GENERAL SETTINGS-->

	<!-- DEFAULT SETTINGS -->
	<div class="form_collector slider_general_collector" data-type="sliderconfig" data-pcontainer="#slider_settings" data-offset="#rev_builder_wrapper">
		<div id="form_module_default" data-select="#gst_sl_5"  class="formcontainer form_menu_inside collapsed">
			<!--<div class="collectortabwrap"><div id="" class="collectortab form_menu_inside" data-forms='["#form_module_default"]'><?php _e('Module Defaults', 'revslider');?></div></div>						-->
			<!-- MODULE DEFAULTS-->
			<!-- SLIDER SOURCE CONTENT -->
			<div id="form_slidergeneral_defaults" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">dns</i><?php _e('Default Basics', 'revslider');?></div>
				<div class="collapsable" style="display:block !important">
					<longoption><i class="material-icons">perm_identity</i><label_a><?php _e('Module ID', 'revslider');?></label_a><input placeholder="ID" class="sliderinput easyinit" data-r="id" type="text" id="sr_sliderid"></longoption>
					<longoption><i class="material-icons">class</i><label_a><?php _e('Module Classes', 'revslider');?></label_a><input placeholder="Class" class="sliderinput easyinit" data-r="class" type="text" id="sr_sliderclass"></longoption>
					<longoption><i class="material-icons">class</i><label_a><?php _e('Wrapper Classes', 'revslider');?></label_a><input placeholder="Class" class="sliderinput easyinit" data-r="wrapperclass" type="text" id="sr_wrapperclass"></longoption>
					<longoption><i class="material-icons">timer</i><label_a><?php _e('Slide Duration', 'revslider');?></label_a><input data-numeric="true" data-allowed="ms" class="sliderinput valueduekeyboard  easyinit" data-r="def.delay" data-min="0" data-max="1000000" data-evt="updateMaxTime" type="text" id="sr_def_delay"/></longoption>
					<longoption><i class="material-icons">timelapse</i><label_a><?php _e('Initialization Delay', 'revslider');?></label_a><input data-numeric="true" data-allowed="ms" class="sliderinput valueduekeyboard  easyinit" data-r="general.slideshow.initDelay" data-min="0" data-max="1000000" type="text" id="sr_sshow_initdelay" /></longoption>
					<longoption><i class="material-icons">select_all</i><label_a><?php _e('Layers are Selectable', 'revslider');?></label_a><input type="checkbox"  id="sr_layersselectable" class="sliderinput easyinit" data-r="general.layerSelection"/></longoption>
				</div>
				<div class="div5"></div>
			</div>
			<!-- DEFAULT SETTINGS -->
			<div id="form_slidergeneral_layersettings" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">dns</i><?php _e('Default New Layer Settings', 'revslider');?></div>
				<div class="collapsable" style="display:block !important">
					<longoption><i class="material-icons">important_devices</i><label_a><?php _e('Intelligent Inheriting', 'revslider');?></label_a><input type="checkbox"  id="sr_layer_intelligentinherit" class="sliderinput easyinit" data-r="def.intelligentInherit"/></longoption>
					<longoption><i class="material-icons">important_devices</i><label_a><?php _e('Responsive Between Devices', 'revslider');?></label_a><input type="checkbox"  id="sr_layer_autoResponsive" class="sliderinput easyinit" data-r="def.autoResponsive"/></longoption>
					<longoption><i class="material-icons">important_devices</i><label_a><?php _e('Responsive Offsets', 'revslider');?></label_a><input type="checkbox"  id="sr_layer_responsiveOffset" class="sliderinput easyinit" data-r="def.responsiveOffset"/></longoption>
					<longoption><i class="material-icons">important_devices</i><label_a><?php _e('Responsive Children', 'revslider');?></label_a><input type="checkbox"  id="sr_layer_responsiveChilds" class="sliderinput easyinit" data-r="def.responsiveChilds"/></longoption>
				</div>
				<div class="div5"></div>
			</div>

			<!--END OF MODULE DEFAULTS-->
		</div>
	</div> <!-- END OF DEFAULT SETTINGS -->

	<!-- MODULE SCROLL SETTINGS -->
	<div class="form_collector slider_general_collector" data-type="sliderconfig" data-pcontainer="#slider_settings" data-offset="#rev_builder_wrapper">
		<div id="form_module_scroll"  data-select="#gst_sl_8"  class="formcontainer form_menu_inside collapsed">
			<!-- SCROLL EFFECT SUBMENUI -->
			<div id="form_slidergeneral_effects_scroll" class="form_inner">
				<div id="slider_scroll_based_wrap">
					<div class="form_inner_header"><i class="material-icons">folder_special</i><?php _e('Scroll Based Features', 'revslider');?></div>
					<div class="collapsable" style="display:block !important">
						<div class="div15"></div><!--
						--><div id="sr_sbased-tab-3" class="settingsmenu_wrapbtn"><div data-inside="#slider_scroll_based_wrap" data-evt="showhidescrollonssm" data-evtparam="parallax" data-showssm="#sr_scrollbased_parallax" class="ssmbtn selected"><?php _e('Parallax', 'revslider');?></div></div><!--
						--><div id="sr_sbased-tab-1" class="settingsmenu_wrapbtn carouselunavailable standardavailable sceneavailable"><div id="timeline_slider_tab" data-inside="#slider_scroll_based_wrap" data-evt="showhidescrollonssm" data-evtparam="timeline" data-showssm="#sr_scrollbased_timeline" class="ssmbtn"><?php _e('Timeline', 'revslider');?></div></div><!--
						--><div id="sr_sbased-tab-2" class="settingsmenu_wrapbtn carouselunavailable standardavailable sceneavailable"><div data-inside="#slider_scroll_based_wrap" data-evt="showhidescrollonssm" data-evtparam="effects" data-showssm="#sr_scrollbased_filters" class="ssmbtn"><?php _e('Effects', 'revslider');?></div></div><!--
						--><div class="div25"></div>
						<!-- PARALLAX -->
						<div id="sr_scrollbased_parallax" class="ssm_content selected">
							<longoption><i class="material-icons">calendar_view_day</i><label_a><?php _e('Parallax Enabled', 'revslider');?></label_a><input type="checkbox"  id="sr_effectspddd" class="sliderinput easyinit callEvent"  data-evt="checkOnScrollSettings" data-showhide=".slider_parallax_subsettings, .layer_parallax_settings" data-showhidedep="true" data-r="parallax.set"/></longoption>
							<div class="slider_parallax_subsettings">
								<longoption><i class="material-icons">3d_rotation</i><label_a><?php _e('3D Effects Enabled', 'revslider');?></label_a><input type="checkbox"  id="sr_effectddd" class="sliderinput easyinit" data-showhide=".slider_ddd_subsettings" data-hideshow=".slide_parallax_wrap" data-showhidedep="true" data-triggerinp="#sr_paralaxlevel_16" data-r="parallax.setDDD"/></longoption>
								<longoption><i class="material-icons">mobile_off</i><label_a><?php _e('Disable on Mobile', 'revslider');?></label_a><input type="checkbox"  id="sr_effectdisableonmobile" class="sliderinput easyinit" data-r="parallax.disableOnMobile"/></longoption>
							</div>
						</div>
						<!-- TIMELINE -->
						<div id="sr_scrollbased_timeline" class="ssm_content">
							<longoption><label_a><?php _e('Timelines Scroll based', 'revslider');?></label_a><input type="checkbox"  id="sr_sbt_ge_enabled" class="sliderinput easyinit callEvent"  data-evt="checkOnScrollSettings" data-showhide=".all_sbt_dependencies" data-showhidedep="true"  data-r="scrolltimeline.set"/></longoption>
							<div class="all_sbt_dependencies">
								<div class="div20"></div>
								<label_a><?php _e('Easing', 'revslider');?></label_a><select id="scroll_timeline_ease" class="sliderinput tos2 searchbox easyinit easingSelect" data-r="scrolltimeline.ease"></select>
								<label_a><?php _e('Speed', 'revslider');?></label_a><input data-allowed="ms" data-min="0"  id="scrolltimeline_speed" data-r="scrolltimeline.speed" data-numeric="true" data-evt=""  type="text"  class="sliderinput valueduekeyboard  easyinit">
								<div class="div20"></div>
								<div class="fixedscrollonoff">
									<longoption><label_a><?php _e('Fix during Scroll', 'revslider');?></label_a><input type="checkbox"  id="sr_sbt_ge_fix_enabled" class="sliderinput easyinit"  data-setclasson="timeline" data-class="fixedscrollon" data-evt="updateFixedScrollRange" data-showhide=".all_sbt_fix_dependencies" data-showhidedep="true"  data-r="scrolltimeline.fixed"/></longoption>
									<longoption><label_a style="overflow:visible"><?php _e('Pull Content, dyn. Bottom Margin', 'revslider');?></label_a><input type="checkbox"  id="sr_sbt_ge_pull_content" class="sliderinput easyinit" data-r="scrolltimeline.pullcontent"/></longoption>
								</div>
								<div class="fixedscrollsettings">
									<div class="all_sbt_fix_dependencies">
										<div class="div20"></div>
										<longoption><label_a><?php _e('Module Fixed From', 'revslider');?></label_a><input data-allowed="ms" id="fixed_scroll_start" data-r="scrolltimeline.fixedStart" data-numeric="true" data-min="1" data-max="999999999" data-evt="updateFixedScrollRange"  type="text"  class="sliderinput valueduekeyboard  easyinit" style="width:95px"></longoption>
										<longoption><label_a><?php _e('Module Fixed Until', 'revslider');?></label_a><input data-allowed="ms"  id="fixed_scroll_end" data-r="scrolltimeline.fixedEnd" data-numeric="true" data-min="1" data-max="999999999"  data-evt="updateFixedScrollRange"  type="text"  class="sliderinput valueduekeyboard  easyinit" style="width:95px"></longoption>
									</div>
								</div>
								<div class="fixedscrollsettingsinfo">
									<row class="direktrow">
										<labelhalf><i class="material-icons vmi">sms_failed</i></labelhalf>
										<contenthalf><div class="function_info"><?php _e('Use Full Screen or Full Width Layout to Use Fixed Scroll.', 'revslider');?></div></contenthalf>
									</row>
								</div>
							</div>
						</div>
						<!-- SCROLL FILTERS -->
						<div id="sr_scrollbased_filters" class="ssm_content">
							<longoption><label_a><?php _e('Scroll based Effects', 'revslider');?></label_a><input type="checkbox"  id="sr_sbe_ge_enabled" class="sliderinput easyinit callEvent"  data-evt="checkOnScrollSettings" data-showhide=".all_sbe_dependencies" data-showhidedep="true" data-r="scrolleffects.set"/></longoption>
						</div>
					</div>
				</div>
			</div><!-- END OF SCROLL EFFECT SUBMENUI -->

			<!-- PARALLAX SETTINGS -->
			<div id="sr_sbased_parallax" class="sr_sbased_tab" >
				<div id="form_slidergeneral_effects_parallax_mous" class="form_inner open">
				<div class="form_inner_header"><i class="material-icons">mouse</i><?php _e('Mouse Interaction', 'revslider');?></div>
				<div class="collapsable" style="display:block !important">
						<label_a><?php _e('Triggered by', 'revslider');?></label_a><select id="slider_parallax_mouse_sens_event"  data-show=".parevent_*val*_settings" data-hide=".parallax_mosue_events" class="sliderinput easyinit tos2 nosearchbox" data-r="parallax.mouse.type">
							<option value="mouse"><?php _e('Mouse Move', 'revslider');?></option>
							<option value="scroll"><?php _e('Scroll Position', 'revslider');?></option>
							<option value="mousescroll"><?php _e('Mouse Move & Scroll', 'revslider');?></option>
						</select>
						<label_a><?php _e('Parallax Orig.', 'revslider');?></label_a><select id="slider_parallax_mouse_origo"  class="sliderinput easyinit tos2 nosearchbox"  data-r="parallax.mouse.origo">
								<option value="enterpoint"><?php _e('Mouse Enter Point', 'revslider');?></option>
								<option value="slidercenter"><?php _e('Slider Center', 'revslider');?></option>
						</select>
						<div class="parevent_mouse_settings parevent_mousescroll_settings parallax_mosue_events"><label_a><?php _e('Mouse Speed', 'revslider');?></label_a><input data-numeric="true" data-allowed="ms" class="sliderinput valueduekeyboard  easyinit" data-r="parallax.mouse.speed" data-min="0" data-max="1000000" type="text" id="sr_parallax_mbspeed"/></div>
						<div class="parevent_scroll_settings parevent_mousescroll_settings parallax_mosue_events"><label_a><?php _e('BG Speed', 'revslider');?></label_a><input data-numeric="true" data-allowed="ms" class="sliderinput valueduekeyboard  easyinit" data-r="parallax.mouse.bgSpeed" data-min="0" data-max="1000000" type="text" id="sr_parallax_mbgspeed"/></div>
						<div class="parevent_scroll_settings parevent_mousescroll_settings parallax_mosue_events"><label_a><?php _e('Layers Speed', 'revslider');?></label_a><input data-numeric="true" data-allowed="ms" class="sliderinput valueduekeyboard  easyinit" data-r="parallax.mouse.layersSpeed" data-min="0" data-max="1000000" type="text" id="sr_parallax_mlayspeed"/></div>
					</div>
				</div>
				<div class="slider_parallax_subsettings">
					<div class="slider_ddd_subsettings">
						<div id="form_slidergeneral_effects_parallax_dddd" class="form_inner open">
						<div class="form_inner_header"><i class="material-icons">3d_rotation</i><?php _e('3D Settings', 'revslider');?></div>
							<div class="collapsable" style="display:block !important">
								<longoption><i class="material-icons">collections</i><label_a><?php _e('Shadow', 'revslider');?></label_a><input type="checkbox"  id="sr_ddd_shadow" class="sliderinput easyinit" data-r="parallax.ddd.shadow"/></longoption>
								<longoption><i class="material-icons">image</i><label_a><?php _e('Slide Background Disabled', 'revslider');?></label_a><input type="checkbox"  id="sr_ddd_BGFreeze" class="sliderinput easyinit" data-r="parallax.ddd.BGFreeze"/></longoption>
								<longoption><i class="material-icons">star_half</i><label_a><?php _e('Slider Overflow Hidden', 'revslider');?></label_a><input type="checkbox"  id="sr_ddd_overflow" class="sliderinput easyinit" data-r="parallax.ddd.overflow"/></longoption>
								<longoption><i class="material-icons">star_half</i><label_a><?php _e('Layers Overflow Hidden', 'revslider');?></label_a><input type="checkbox"  id="sr_ddd_layerOverflow" class="sliderinput easyinit" data-r="parallax.ddd.layerOverflow"/></longoption>
								<div class="div15"></div>
								<label_a><?php _e('3D Crop Fix (z)', 'revslider');?></label_a><input type="text"  id="sr_ddd_zCorrection" class="sliderinput easyinit withsuffix smallinput" data-r="parallax.ddd.zCorrection"/><span class="linebreak"></span>
								<label_a><?php _e('BG 3D Depth', 'revslider');?></label_a><input type="text"  id="sr_paralaxlevel_16" class="sliderinput easyinit smallinput callEvent" data-evt="updateParallaxdddBG" data-r="parallax.levels.15" data-helpkey="bgparallaxlevel" /><span class="linebreak"></span>
							</div>
						</div>
					</div>
					<div id="form_slidergeneral_effects_parallax_depths" class="form_inner open">
						<div class="form_inner_header"><i class="material-icons" style="transform:rotate(90deg)">tune</i><?php _e('Depths', 'revslider');?></div>
						<div class="collapsable" style="display:block !important">
							<row class="direktrow">
								<onethird><label_a class="short"><?php _e('1.', 'revslider');?></label_a><input type="text"  id="sr_paralaxlevel_1" class="sliderinput easyinit smallinput" data-evt="updateParallaxLevelTexts" data-r="parallax.levels.0"/><span class="linebreak"></span></onethird>
								<onethird><label_a class="short"><?php _e('6.', 'revslider');?></label_a><input type="text"  id="sr_paralaxlevel_6" class="sliderinput easyinit smallinput" data-evt="updateParallaxLevelTexts" data-r="parallax.levels.5"/><span class="linebreak"></span></onethird>
								<onethird><label_a class="short"><?php _e('11.', 'revslider');?></label_a><input type="text"  id="sr_paralaxlevel_11" class="sliderinput easyinit smallinput" data-evt="updateParallaxLevelTexts" data-r="parallax.levels.10"/><span class="linebreak"></span></onethird>
							</row>
							<row class="direktrow">
								<onethird><label_a class="short"><?php _e('2.', 'revslider');?></label_a><input type="text"  id="sr_paralaxlevel_2" class="sliderinput easyinit smallinput" data-evt="updateParallaxLevelTexts" data-r="parallax.levels.1"/><span class="linebreak"></span></onethird>
								<onethird><label_a class="short"><?php _e('7.', 'revslider');?></label_a><input type="text"  id="sr_paralaxlevel_7" class="sliderinput easyinit smallinput" data-evt="updateParallaxLevelTexts" data-r="parallax.levels.6"/><span class="linebreak"></span></onethird>
								<onethird><label_a class="short"><?php _e('12.', 'revslider');?></label_a><input type="text"  id="sr_paralaxlevel_12" class="sliderinput easyinit smallinput" data-evt="updateParallaxLevelTexts" data-r="parallax.levels.11"/><span class="linebreak"></span></onethird>
							</row>
							<row class="direktrow">
								<onethird><label_a class="short"><?php _e('3.', 'revslider');?></label_a><input type="text"  id="sr_paralaxlevel_3" class="sliderinput easyinit smallinput" data-evt="updateParallaxLevelTexts" data-r="parallax.levels.2"/><span class="linebreak"></span></onethird>
								<onethird><label_a class="short"><?php _e('8.', 'revslider');?></label_a><input type="text"  id="sr_paralaxlevel_8" class="sliderinput easyinit smallinput" data-evt="updateParallaxLevelTexts" data-r="parallax.levels.7"/><span class="linebreak"></span></onethird>
								<onethird><label_a class="short"><?php _e('13.', 'revslider');?></label_a><input type="text"  id="sr_paralaxlevel_13" class="sliderinput easyinit smallinput" data-evt="updateParallaxLevelTexts" data-r="parallax.levels.12"/><span class="linebreak"></span></onethird>
							</row>
							<row class="direktrow">
								<onethird><label_a class="short"><?php _e('4.', 'revslider');?></label_a><input type="text"  id="sr_paralaxlevel_4" class="sliderinput easyinit smallinput" data-evt="updateParallaxLevelTexts" data-r="parallax.levels.3"/><span class="linebreak"></span></onethird>
								<onethird><label_a class="short"><?php _e('9.', 'revslider');?></label_a><input type="text"  id="sr_paralaxlevel_9" class="sliderinput easyinit smallinput" data-evt="updateParallaxLevelTexts" data-r="parallax.levels.8"/><span class="linebreak"></span></onethird>
								<onethird><label_a class="short"><?php _e('14.', 'revslider');?></label_a><input type="text"  id="sr_paralaxlevel_14" class="sliderinput easyinit smallinput" data-evt="updateParallaxLevelTexts" data-r="parallax.levels.13"/><span class="linebreak"></span></onethird>
							</row>
							<row class="direktrow">
								<onethird><label_a class="short"><?php _e('5.', 'revslider');?></label_a><input type="text"  id="sr_paralaxlevel_5" class="sliderinput easyinit smallinput" data-evt="updateParallaxLevelTexts" data-r="parallax.levels.4"/><span class="linebreak"></span></onethird>
								<onethird><label_a class="short"><?php _e('10.', 'revslider');?></label_a><input type="text"  id="sr_paralaxlevel_10" class="sliderinput easyinit smallinput" data-evt="updateParallaxLevelTexts" data-r="parallax.levels.9"/><span class="linebreak"></span></onethird>
								<onethird><label_a class="short"><?php _e('15.', 'revslider');?></label_a><input type="text"  id="sr_paralaxlevel_15" class="sliderinput easyinit smallinput" data-evt="updateParallaxLevelTexts" data-r="parallax.levels.14"/><span class="linebreak"></span></onethird>
							</row>
						</div>
					</div><!-- END OF COLLAPSABLE  data-updatetext="slide_ddd_depth_info"  -->
				</div>
			</div><!-- END OF PARALLAX SETTINGS -->
			<!-- TIMELINE SCROLL BASED SETTINGS -->
			<div class="all_sbt_dependencies">
				<div id="sr_sbased_timeline" class="sr_sbased_tab" style="display:none">
					<div id="form_slidergeneral_effects_scroll_on" class="form_inner">
						<div class="form_inner_header"><i class="material-icons">list</i><?php _e('Use Default on...', 'revslider');?></div>
						<div class="collapsable" style="display:block !important">
							<longoption><label_a><?php _e('Layers', 'revslider');?></label_a><input type="checkbox"  id="sr_scrtime_layers" data-evt="checkLayerLoopswithOnScroll" class="sliderinput easyinit callEvent"  data-r="scrolltimeline.layers"/></longoption>
						</div>
					</div>
				</div>
			</div><!-- END OF TIMELINE SCROLL BASED SETTINGS -->

			<!-- EFFECT SETTINGS -->
			<div class="all_sbe_dependencies">
				<div id="sr_sbased_effects" class="sr_sbased_tab" style="display:none">
					<div id="form_slidergeneral_effects_scroll_on" class="form_inner">
						<div class="form_inner_header"><i class="material-icons">list</i><?php _e('Scroll Effects Default', 'revslider');?></div>
						<div class="collapsable" style="display:block !important">
							<longoption><label_a><?php _e('Fade', 'revslider');?></label_a><input type="checkbox"  id="sr_se_fadeset" class="sliderinput easyinit" data-r="scrolleffects.setFade"/></longoption>
							<longoption><label_a><?php _e('Grayscale', 'revslider');?></label_a><input type="checkbox"  id="sr_se_grayset" class="sliderinput easyinit" data-r="scrolleffects.setGrayScale"/></longoption>
							<longoption><label_a><?php _e('Blur', 'revslider');?></label_a><input type="checkbox"  data-showhide="#max_scroll_blur" data-showhidedep="true" id="sr_se_blurset" class="sliderinput easyinit" data-r="scrolleffects.setBlur"/></longoption>
							<longoption  id="max_scroll_blur"><i class="material-icons">photo_filter</i><label_a><?php _e('Max Blur Strength', 'revslider');?></label_a><input type="text"  id="sr_se_blurMax" class="sliderinput easyinit withsuffix smallinput" data-r="scrolleffects.maxBlur"/></longoption>
							<longoption><label_a><?php _e('Layers default Enabled', 'revslider');?></label_a><input type="checkbox"  id="sr_screff_layers" class="sliderinput easyinit" data-r="scrolleffects.layers"/></longoption>
							<longoption><label_a><?php _e('Slides default Enabled', 'revslider');?></label_a><input type="checkbox"  id="sr_screff_bg" class="sliderinput easyinit" data-r="scrolleffects.bg"/></longoption>
						</div>
					</div>
					<div id="form_slidergeneral_effects_scroll_dependencies" class="form_inner">
						<div class="form_inner_header"><i class="material-icons">done_all</i><?php _e('Scroll Effects Settings', 'revslider');?></div>
						<div class="collapsable" style="display:block !important">

							<label_a><?php _e('Direction', 'revslider');?></label_a><select id="slider_screff_direction"  class="sliderinput easyinit tos2 nosearchbox" data-r="scrolleffects.direction">
									<option value="top"><?php _e('Top', 'revslider');?></option>
									<option value="bottom"><?php _e('Bottom', 'revslider');?></option>
									<option value="both"><?php _e('Both', 'revslider');?></option>
								</select>

							<label_a><?php _e('Disable Mobile', 'revslider');?></label_a><input type="checkbox"  id="sr_screff_disableOnMobile" class="sliderinput easyinit" data-r="scrolleffects.disableOnMobile"/><span class="linebreak"></span>
							<label_a><?php _e('Offset (Tilt) Effect', 'revslider');?></label_a><input data-numeric="true" data-allowed="%" type="text"  id="sr_screff_tilt" class="sliderinput easyinit withsuffix smallinput" data-r="scrolleffects.tilt"/><span class="linebreak"></span>
							<label_a><?php _e('Factor on BG\'s', 'revslider');?></label_a><input type="text" data-numeric="true" data-allowed="" id="sr_screff_multiplicator" class="sliderinput easyinit " data-r="scrolleffects.multiplicator"/><span class="linebreak"></span>
							<label_a><?php _e('Factor on Layers', 'revslider');?></label_a><input type="text" data-numeric="true" data-allowed="" id="sr_screff_multiplicatorLayers" class="sliderinput easyinit " data-r="scrolleffects.multiplicatorLayers"/>
						</div><!-- END OF COLLAPSABLE-->
					</div>
				</div>
			</div><!--END OF SCROLL EFFECTS SETTINGS -->
		</div>
	</div><!-- END OF SCROLL SETTINGS -->

	<!-- MODULE ADVANCED -->
	<div class="form_collector slider_general_collector" data-type="sliderconfig" data-pcontainer="#slider_settings" data-offset="#rev_builder_wrapper">
		<div id="form_module_advanced"  data-select="#gst_sl_10"  class="formcontainer form_menu_inside collapsed">
			<!--<div class="collectortabwrap"><div id="" class="collectortab form_menu_inside" data-forms='["#form_module_advanced"]'><?php _e('Advanced Settings', 'revslider');?></div></div>-->
			<!-- MODULE ADVANCED INNER-->
			<div id="form_slidergeneral_advanced_loading" class="form_inner">
				<div class="form_inner_header"><i class="material-icons">ev_station</i><?php _e('Loading Type', 'revslider');?></div>
				<div class="collapsable" style="display:block !important">
					<!-- SLIDER ADVANCED SETTINGS -->
					<label_a><?php _e('Lazy Loading', 'revslider')?></label_a><select id="sr_adv_performance_load" class="sliderinput tos2 nosearchbox easyinit" data-r="general.lazyLoad" data-show=".tp-monitor-*val*-speed" data-hide=".tp-monitor-speeds"><option value="all"><?php _e("All", 'revslider');?></option><option value="smart"><?php _e("Smart", 'revslider');?></option><option value="single"><?php _e("Single", 'revslider');?></option><option value="none"><?php _e("Default Global Setting", 'revslider');?></option></select>
				</div>
			</div>

			<!-- MODULE ADVANCED INNER-->
			<div id="form_slidergeneral_advanced_internalcache" class="form_inner">
				<div class="form_inner_header"><i class="material-icons">cached</i><?php _e('Internal Cache', 'revslider');?></div>
				<div class="collapsable" style="display:block !important">					
					<label_a><?php _e('Use Cache', 'revslider');?></label_a><select id="sliderintcache" class="sliderinput tos2 nosearchbox easyinit" data-r="general.icache"> <option value="default"><?php _e('Global Default', 'revslider');?></option><option value="on"><?php _e('Enable', 'revslider');?></option><option value="off"><?php _e('Disabled', 'revslider');?></option></select>					
					<row class="direktrow">
						<labelhalf><i class="material-icons vmi">sms_failed</i></labelhalf>
						<contenthalf><div class="function_info"><?php _e('Keep disabled if slider has dynamic content, e.g. shortcodes', 'revslider');?></div></contenthalf>
					</row>
				</div>
			</div>

			<!-- MODULE ADVANCED INNER-->
			<div id="form_slidergeneral_advanced_DPR" class="form_inner">
				<div class="form_inner_header"><i class="material-icons">4k</i><?php _e('Device Pixel Ratio', 'revslider');?></div>
				<div class="collapsable" style="display:block !important">					
					<label_a><?php _e('Max. BG DPR', 'revslider');?></label_a><select id="sliderbgdpr" class="sliderinput tos2 nosearchbox easyinit" data-r="general.DPR"> <option value="ax1"><?php _e('Auto but Max x1', 'revslider');?></option><option value="ax2"><?php _e('Auto but Max x2', 'revslider');?></option><option value="ax3"><?php _e('Auto but Max x3', 'revslider');?></option><option value="ax4"><?php _e('Auto but Max x4', 'revslider');?></option><option value="dpr"><?php _e('Auto', 'revslider');?></option><option value="x1"><?php _e('x1', 'revslider');?></option><option value="x2"><?php _e('x2', 'revslider');?></option><option value="x3"><?php _e('x3', 'revslider');?></option><option value="x4"><?php _e('x4', 'revslider');?></option></select>					
					<row class="direktrow">
						<labelhalf><i class="material-icons vmi">sms_failed</i></labelhalf>
						<contenthalf><div class="function_info"><?php _e('Higher maximum values can have a negative influence on complex canvas animations. Lower values can have a negative influence on image quality on 4k+ devices.', 'revslider');?></div></contenthalf>
					</row>
				</div>
			</div>

			

			<!-- SLIDER FALLBACK SETTINGS -->
			<div id="form_slidergeneral_advanced_fallback" class="form_inner">
				<div class="form_inner_header"><i class="material-icons">error</i><?php _e('Fallback Settings', 'revslider');?></div>
				<div class="collapsable" style="display:block !important">
					<longoption><i class="material-icons"></i><label_a><?php _e('Simplify on IOS4 / IE8', 'revslider');?></label_a><input type="checkbox"  id="sr_simplify_ie8_ios4" class="sliderinput easyinit" data-r="troubleshooting.simplify_ie8_ios4"/></longoption>
					<div class="div15"></div>
					<label_a><?php _e('Alt. Image', 'revslider')?></label_a><select id="slider_fallback_alt_image"  class="sliderinput easyinit tos2 nosearchbox" data-show=".fallback_alt_image_*val*" data-hide=".fallback_alt_image" data-r="troubleshooting.alternateImageType">
						<option value="off" selected="selected"><?php _e('Off', 'revslider');?></option>
						<option value="mobile"><?php _e('On Mobile', 'revslider');?></option>
						<option value="ie8"><?php _e('On IE8', 'revslider');?></option>
						<option value="mobile-ie8"><?php _e('On Mobile and IE8', 'revslider');?></option>
					</select><span class="linebreak"></span>

					<div class="fallback_alt_image_mobile fallback_alt_image_ie8 fallback_alt_image_mobile-ie8 fallback_alt_image">
						<label_a><?php _e('Image URL', 'revslider');?></label_a><input placeholder="<?php _e('Enter Image URL', 'revslider');?>" type="text"  id="troubleshooting_alternateURL" class="sliderinput easyinit" data-r="troubleshooting.alternateURL"/>
						<label_a></label_a><div class="basic_action_button getImageFromMediaLibrary longbutton" data-target="#troubleshooting_alternateURL" id="fallbackimage"><i class="material-icons">style</i><?php _e('Media Library', 'revslider');?></div>
					</div>
				</div>
			</div>

			<!-- SLIDER TROUBLESHOOTING SETTINGS -->
			<div id="form_slidergeneral_advanced_fallback" class="form_inner">
				<div class="form_inner_header"><i class="material-icons">code</i><?php _e('jQuery & OutPut Filters', 'revslider');?></div>
				<div class="collapsable" style="display:block !important">
					<longoption><i class="material-icons">code</i><label_a><?php _e('jQuery No Conflict Mode', 'revslider');?></label_a><input type="checkbox"  id="sr_trbl_conflictmode" class="sliderinput easyinit" data-r="troubleshooting.jsNoConflict"/></longoption>
					<longoption><i class="material-icons">add_to_queue</i><label_a><?php _e('Put JS to Body', 'revslider');?></label_a><input type="checkbox"  id="sr_trbl_jsInBody" class="sliderinput easyinit" data-r="troubleshooting.jsInBody"/></longoption>
					<div class="div15"></div>


					<label_a><?php _e('Output Filter', 'revslider');?></label_a><select id="sr_trbl_filters"  class="sliderinput easyinit tos2 nosearchbox"  data-r="troubleshooting.outPutFilter">
						<option value="none" selected="selected"><?php _e('None', 'revslider');?></option>
						<option value="compress"><?php _e('By Compressing Output', 'revslider');?></option>
						<option value="echo"><?php _e('By Echo Output', 'revslider');?></option>
					</select><span class="linebreak"></span>

				</div><!-- END OF COLLAPSABLE-->
			</div><!--END OF MODULE ADVANCED INNER -->



		</div>
	</div><!-- END OF ADVANCED -->

</div><!-- END OF SLIDER SETTINGS-->
