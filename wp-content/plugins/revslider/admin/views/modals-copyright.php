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

if (method_exists('RevSliderGlobals','instance')) {
	$rs_f = RevSliderGlobals::instance()->get('RevSliderFunctions');
} else {
	$rs_f = new RevSliderFunctions();
}


$registered_p_c = ($rs_f->get_addition('selling') === true) ? __('registered license key', 'revslider') : __('registered purchase code', 'revslider');
$registered_p_c_url = ($rs_f->get_addition('selling') === true) ? 'https://account.sliderrevolution.com/portal/pricing/?utm_source=admin&utm_medium=button&utm_campaign=srusers&utm_content=buykey' : 'https://themepunch.com/faq/where-to-find-purchase-code/';
?>

<!--OPTIMIZER DETAILS-->
<div style="display:none" class="_TPRB_ rb-modal-wrapper" data-modal="rbm_optimizer_infos" id="rbm_optimizer_infos_wrap" >
	<div class="rb-modal-inner">
		<div class="rb-modal-content">
			<div id="rbm_optimizer_infos" class="rb_modal form_inner">
				<div class="rbm_header">
					<span class="rbm_title">
						<i class="rbm_symbol material-icons">flash_on</i>
						<?php _e('File Size Optimizer Dimensions');?>
					</span>
					<i class="rbm_close material-icons">close</i>
				</div>
				<div class="rbm_content">
					<div style="padding:50px">											
						<div class="decmod_maintxt"><?php _e('Where do the available Dimensions come from?', 'revslider');?></div>
						<div class="decmod_subtxt"><?php _e('Those are all sizes that are already generated for the used image in the WordPress Media Library AND have the same aspect ratio.', 'revslider');?></div>
						<div class="div40"></div>
						<div class="decmod_maintxt"><?php _e('Why are my choices not exactly 1X or 2X?', 'revslider');?></div>
						<div class="decmod_subtxt"><?php _e('The File Size Optimizer looks at the required media size throughout all device layouts and in that way evaluates the available Dimensions.<br>If available, there is always a choice shown that is the closest to 1X or 2X.<br>If no fitting size is available, you can hover the standard (1X) or retina (2X) lines to get an info on the currently optimal size for your media.', 'revslider');?></div>
					</div>					
				</div>
			</div>
		</div>
	</div>
</div>


<div style="display:none" class="_TPRB_ rb-modal-wrapper rb-basicforms" data-modal="rbm_blocksettings">
	<div class="rb-modal-inner">
		<div class="rb-modal-content">
			<div id="rbm_blocksettings" class="rb_modal form_inner">
				<div class="rbm_header"><i class="rbm_symbol material-icons">tune</i><span class="rbm_title"><?php _e('Slider Revolution Block Settings','revslider');?></span><i class="rbm_close material-icons">close</i></div>
				<div class="rbm_content">
					<div class="rbm_general_half" style="padding-right:20px;">
						<div class="rb_not_on_notactive">						
							<div class="ale_i_title thumbnail_title"><?php _e('Module Layout','revslider');?></div><hr class="general_hr"><span class="linebreak"></span>
							<label_a><?php _e('Sizing','revslider');?></label_a>
							<div class="radiooption">
								<div class="sl_auto"><input name="modulelayout" data-r="layout" type="radio" value="auto" class="scblockinput easyinit callEvent" data-evt="checkOffsets"><label_sub><?php _e('Auto Width','revslider');?></label_sub><span class="origlayout_auto origlayout">*</span></div>
								<div class="sl_fullwidth"><input name="modulelayout" data-r="layout" type="radio" value="fullwidth" class="scblockinput callEvent easyinit" data-evt="checkOffsets"><label_sub><?php _e('Full Width','revslider');?></label_sub><span class="origlayout_fullwidth origlayout">*</span></div>
								<div class="sl_fullscreen"><input name="modulelayout" data-r="layout" type="radio" value="fullscreen" class="scblockinput callEvent easyinit" data-evt="checkOffsets"><label_sub><?php _e('Full Screen','revslider');?></label_sub><span class="origlayout_fullscreen origlayout">*</span></div>
							</div>			
							<div class="div40"></div>	
						</div>
						<div class="ale_i_title thumbnail_title"><?php _e('Insert Module as Pop Up Module','revslider');?></div><hr class="general_hr"><span class="linebreak"></span>
						<label_a>Use Pop Up</label_a><input id="rs_popup_decide" type="checkbox" class="easyinit scblockinput" data-r="modal" data-showhide=".rs_modaldependencies_false" data-hideshow=".rs_modaldependencies_true" data-showhidedep="false">
						<div class="rs_modaldependencies_true">	
							<div class="div25"></div>							
							<div class="ale_i_title thumbnail_title"><?php _e('1 Time Per Session','revslider');?><input type="checkbox" data-rocker="foals"  class="easyinit scblockinput" data-r="popup.cookie.use"></div><hr class="general_hr"><span class="linebreak"></span>							
							<row class="direktrow"><onefull><label_a><?php _e('Session (hours)','revslider');?></label_a><input data-r="popup.cookie.v" class="valueduekeyboard longinput scblockinput easyinit callEvent" data-allowed="" data-numeric="true" data-min="0" data-max="1000" type="text"></onefull></row>							
							<div class="function_info_small"><?php _e('Relating on Pop Up after Time and Scroll Position ','revslider');?></div>
						</div>
						<div class="div25"></div>
						<div class="ale_i_title thumbnail_title"><?php _e('Pop Up by Actions','revslider');?></div><hr class="general_hr"><span class="linebreak"></span>																						
						<div class="function_info"><?php _e('Pop Up\'s can also be triggered by Layer Actions.<br>See more details in ','revslider');?><a href="https://www.themepunch.com/slider-revolution/lightbox-modal/" target:"_new"><?php _e('Pop Up / Modal Documentation','revslider');?></a></div>
						
					</div>
					<div class="rbm_general_half" style="padding-left:20px;">
						<div class="rb_not_on_notactive">	
							<div class="rs_modaldependencies_false">								
								<div class="ale_i_title thumbnail_title"><?php _e('Block Offsets (Module Wrapping Offset)','revslider');?></div><hr class="general_hr"><span class="linebreak"></span>				
								<div class="offset_list"><label_icon class="ui_margin_top"></label_icon><label_icon class="ui_padding_right"></label_icon><label_icon class="ui_margin_bottom"></label_icon><label_icon class="ui_padding_left"></label_icon></div>
								<div><label_icon class="ui_desktop"></label_icon>   <input data-r="offset.d.top" class="valueduekeyboard miniinput scblockinput easyinit " data-allowed="px"  data-numeric="true" data-min="-500" data-max="2000" type="text"><input data-r="offset.d.right" class=" valueduekeyboard miniinput scblockinput easyinit" data-allowed="px"  data-numeric="true" data-min="-500" data-max="2000" type="text"><input data-r="offset.d.bottom" class=" valueduekeyboard miniinput scblockinput easyinit" data-allowed="px"  data-numeric="true" data-min="-500" data-max="2000" type="text"><input data-r="offset.d.left" class=" valueduekeyboard miniinput scblockinput easyinit" data-allowed="px"  data-numeric="true" data-min="-500" data-max="2000" type="text"><input type="checkbox" class="easyinit scblockinput" data-r="offset.d.use"></div>
								<div><label_icon class="ui_notebook"></label_icon>  <input data-r="offset.n.top" class="valueduekeyboard miniinput scblockinput easyinit " data-allowed="px"  data-numeric="true" data-min="-500" data-max="2000" type="text"><input data-r="offset.n.right" class=" valueduekeyboard miniinput scblockinput easyinit" data-allowed="px"  data-numeric="true" data-min="-500" data-max="2000" type="text"><input data-r="offset.n.bottom" class=" valueduekeyboard miniinput scblockinput easyinit" data-allowed="px"  data-numeric="true" data-min="-500" data-max="2000" type="text"><input data-r="offset.n.left" class=" valueduekeyboard miniinput scblockinput easyinit" data-allowed="px"  data-numeric="true" data-min="-500" data-max="2000" type="text"><input type="checkbox" class="easyinit scblockinput" data-r="offset.n.use"></div>
								<div><label_icon class="ui_tablet"></label_icon>    <input data-r="offset.t.top" class="valueduekeyboard miniinput scblockinput easyinit " data-allowed="px"  data-numeric="true" data-min="-500" data-max="2000" type="text"><input data-r="offset.t.right" class=" valueduekeyboard miniinput scblockinput easyinit" data-allowed="px"  data-numeric="true" data-min="-500" data-max="2000" type="text"><input data-r="offset.t.bottom" class=" valueduekeyboard miniinput scblockinput easyinit" data-allowed="px"  data-numeric="true" data-min="-500" data-max="2000" type="text"><input data-r="offset.t.left" class=" valueduekeyboard miniinput scblockinput easyinit" data-allowed="px"  data-numeric="true" data-min="-500" data-max="2000" type="text"><input type="checkbox" class="easyinit scblockinput" data-r="offset.t.use"></div>
								<div><label_icon class="ui_mobile"></label_icon>    <input data-r="offset.m.top" class="valueduekeyboard miniinput scblockinput easyinit " data-allowed="px"  data-numeric="true" data-min="-500" data-max="2000" type="text"><input data-r="offset.m.right" class=" valueduekeyboard miniinput scblockinput easyinit" data-allowed="px"  data-numeric="true" data-min="-500" data-max="2000" type="text"><input data-r="offset.m.bottom" class=" valueduekeyboard miniinput scblockinput easyinit" data-allowed="px"  data-numeric="true" data-min="-500" data-max="2000" type="text"><input data-r="offset.m.left" class=" valueduekeyboard miniinput scblockinput easyinit" data-allowed="px"  data-numeric="true" data-min="-500" data-max="2000" type="text"><input type="checkbox" class="easyinit scblockinput" data-r="offset.m.use"></div>
								<div class="div25"></div>
								<div class="ale_i_title thumbnail_title"><?php _e('Block Depth','revslider');?></div>
								<hr class="general_hr">
								<span class="linebreak"></span>	
								<label_a><?php _e('Z-Index','revslider');?></label_a>
								<input data-r="zindex" class="valueduekeyboard miniinput scblockinput easyinit" data-allowed=""  data-numeric="true" data-min="0" data-max="10000000" type="text">
							</div>
						</div>
						<div class="rb_not_on_notactive">	
							<div class="rs_modaldependencies_true">				
								<div class="ale_i_title thumbnail_title"><?php _e('Pop Up after Time','revslider');?><input type="checkbox" data-rocker="foals" class="easyinit scblockinput" data-r="popup.time.use"></div><hr class="general_hr"><span class="linebreak"></span>
								<label_a><?php _e('After (ms)','revslider');?></label_a><input data-r="popup.time.v" class="valueduekeyboard smallinput scblockinput easyinit " data-allowed="ms"  data-numeric="true" data-min="0" data-max="200000" type="text">
								<div class="div25"></div>
								<div class="ale_i_title thumbnail_title"><?php _e('Pop Up at Scroll Position','revslider');?><input type="checkbox" data-rocker="foals" class="easyinit scblockinput" data-r="popup.scroll.use"></div><hr class="general_hr"><span class="linebreak"></span>
								<div class="radiooption">
									<label_a><?php _e('Based On','revslider');?></label_a><div style="display:inline-block; margin-right:20px;"><input name="popupscrolltype" data-show="#pop_scroll_o_based" data-hide="#pop_scroll_c_based" data-r="popup.scroll.type" type="radio" value="offset" class="scblockinput easyinit"><label_sub><?php _e('Offset','revslider');?></label_sub></div><!--
									--><div style="display:inline-block"><input name="popupscrolltype" data-r="popup.scroll.type" data-hide="#pop_scroll_o_based" data-show="#pop_scroll_c_based" type="radio" value="container" class="scblockinput easyinit"><label_sub><?php _e('Container','revslider');?></label_sub></div>								
								</div>	
								<div class="div15"></div>
								<row id="pop_scroll_c_based" class="directrow">
									<onefull><label_a><?php _e('Container','revslider');?></label_a><input data-r="popup.scroll.container" data-rocker="foals" class="valueduekeyboard longinput scblockinput easyinit " type="text"></onefull>
								</row>
								<div id="pop_scroll_o_based"><label_a><?php _e('Offset','revslider');?></label_a><input data-r="popup.scroll.v" data-rocker="foals" class="valueduekeyboard smallinput scblockinput easyinit " data-allowed="px"  data-numeric="true" data-min="-1000" data-max="200000" type="text"></div>
								<div class="div25"></div>							
								<div class="ale_i_title thumbnail_title"><?php _e('Pop Up by Events','revslider');?><input type="checkbox" data-rocker="foals"  class="easyinit scblockinput" data-r="popup.event.use"></div><hr class="general_hr"><span class="linebreak"></span>							
								<row class="direktrow"><onefull><label_a><?php _e('Listen to','revslider');?></label_a><input data-r="popup.event.v" class="valueduekeyboard longinput scblockinput easyinit callEvent" data-evt="updateSRBSSVREVT" type="text"></onefull></row>							
								<div class="function_info_small">i.e.: jQuery(document).trigger("<span id="srbs_scr_evt"></span>")</div>
								<div class="div25"></div>
								<div class="ale_i_title thumbnail_title"><?php _e('Pop Up on URL Hash ','revslider');?><input type="checkbox" data-rocker="foals"  class="easyinit scblockinput" data-r="popup.hash.use"></div><hr class="general_hr"><span class="linebreak"></span>															
								<div class="function_info"><?php _e('https://yourwebsite.com/yourpage/#<span id="srbs_scr_hash"></span>','revslider') ?></div>
							</div>
						</div>
					</div>
				</div>								
			</div>
		</div>
	</div>
</div>



<!--COPYRIGHT MODAL-->
<div style="display:none" class="_TPRB_ rb-modal-wrapper" data-modal="rbm_copyright">
	<div class="rb-modal-inner">
		<div class="rb-modal-content">
			<div id="rbm_copyright" class="rb_modal form_inner">
				<div class="rbm_header"><span class="rbm_title"><?php _e('Copyright & Licensing - Slider Revolution Library', 'revslider');?></span><i class="rbm_close material-icons">close</i></div>
				<div class="rbm_content">
					<div class="rbm_content_left">
						<div class="copyright_sel selected" data-crm="templates"><i class="material-icons">aspect_ratio</i><?php _e('Templates');?></div>
						<div class="copyright_sel" data-crm="images"><i class="material-icons">photo_camera</i><?php _e('Images');?></div>
						<div class="copyright_sel" data-crm="objects"><i class="material-icons">filter_drama</i><?php _e('Objects');?></div>
						<div class="copyright_sel" data-crm="videos"><i class="material-icons">videocam</i><?php _e('Videos');?></div>
						<div class="copyright_sel" data-crm="svg"><i class="material-icons">copyright</i><?php _e('SVG');?></div>
						<div class="copyright_sel" data-crm="icon"><i class="material-icons">font_download</i><?php _e('Icon');?></div>
						<div class="copyright_sel" data-crm="layers"><i class="material-icons">layers</i><?php _e('Layers');?></div>
					</div>
					<div class="rbm_content_right">
						<div class="crm_content_wrap" id="crm_templates">
							<div class="crm_title"><?php _e('Terms of using Layer Group Objects from the Library');?></div>
							<div class="crm_content"><div class="crm_arrow material-icons">arrow_forward</div><div class="crm_text"><?php _e('Templates from the Slider Revolution Library <b>must only</b> be used with a');?><br><a target="_blank" rel="noopener" href="<?php echo $registered_p_c_url; ?>"><?php echo $registered_p_c;?></a> <?php _e('on that particular website.');?></div></div>							
							<div class="crm_content"><div class="crm_arrow material-icons">arrow_forward</div><div class="crm_text"><?php _e('Media assets used in the respective templates, are licensed according to the here mentioned license terms (see list on the left).');?></div></div>
							<div class="crm_content"><div class="crm_arrow material-icons">arrow_forward</div><div class="crm_text"><?php _e('Slider Revolution Add-Ons <b>must only</b> be used with a');?> <a target="_blank" rel="noopener" href="<?php echo $registered_p_c_url; ?>"><?php echo $registered_p_c;?></a> <?php _e('on that particular website.');?></div></div>
							<div class="div30"></div>
							<a target="_blank" rel="noopener" href="https://getsliderrevolution.com" class="crm_basic_button basic_action_button autosize basic_action_coloredbutton" style="padding:0px 30px"><?php _e('Buy another License');?> <span style="line-height:28px" class="crm_infostar">*</span></a>
							<div class="crm_info_text"><span class="crm_infostar">*</span><?php _e('One License Key / Purchase Code is required for each Website');?></div>
						</div>
						<div class="crm_content_wrap" id="crm_images">
							<div class="crm_title"><?php _e('Terms of using JPG Images from the Library');?></div>
							<div class="crm_content"><div class="crm_arrow material-icons">arrow_forward</div><div class="crm_text"><?php _e('The pictures are free for personal and even for commercial use.');?></div></div>
							<div class="crm_content"><div class="crm_arrow material-icons">arrow_forward</div><div class="crm_text"><?php _e('You can modify, copy and distribute the photos. All without asking for permission or setting a link to the source. So, attribution is not required.');?></div></div>
							<div class="crm_content"><div class="crm_arrow material-icons">arrow_forward</div><div class="crm_text"><?php _e('The only restriction is that identifiable people may not appear in a bad light or in a way that they may find offensive, unless they give their consent.');?></div></div>
							<div class="crm_content"><div class="crm_arrow material-icons">arrow_forward</div><div class="crm_text"><?php _e('The CC0 license was released by the non-profit organization Creative Commons (CC). Get more information about Creative Commons images and the license on the official license page.');?></div></div>
							<div class="crm_content"><div class="crm_arrow material-icons">arrow_forward</div><div class="crm_text"><?php _e('Images from');?> <a target="_blank" rel="noopener" href="https://www.pexels.com/"><?php _e('Pexels');?></a> <?php _e('under the license');?> <a target="_blank" rel="noopener" href="https://creativecommons.org/share-your-work/public-domain/cc0/"><?php _e('CC0 Creative Commons');?></a></div></div>							
						</div>
						<div class="crm_content_wrap" id="crm_objects">
							<div class="crm_title"><?php _e('Terms of using PNG Objects from the Library');?></div>
							<div class="crm_content"><div class="crm_arrow material-icons">arrow_forward</div><div class="crm_text"><?php _e('PNG Objects from the Slider Revolution Library <b>must only</b> be used with a');?><br><a target="_blank" rel="noopener" href="<?php echo $registered_p_c_url; ?>"><?php echo $registered_p_c;?></a> <?php _e('on that particular website.');?></div></div>							
							<div class="crm_content"><div class="crm_arrow material-icons">arrow_forward</div><div class="crm_text"><?php _e('Licenses via extended license and cooperation with author ');?> <a target="_blank" rel="noopener" href="https://creativemarket.com/ceacle"><?php _e('Ceacle');?></a></div></div>
							<div class="crm_content"><div class="crm_arrow material-icons">arrow_forward</div><div class="crm_text"><?php _e('If you need .psd files for objects, you can purchase it from the original author');?> <a target="_blank" rel="noopener" href="https://creativemarket.com/ceacle"><?php _e('here');?></a></div></div>
							<div class="div30"></div>
							<a target="_blank" rel="noopener" href="https://getsliderrevolution.com" class="crm_basic_button basic_action_button autosize basic_action_coloredbutton" style="padding:0px 30px"><?php _e('Buy another License');?> <span style="line-height:28px" class="crm_infostar">*</span></a>
							<div class="crm_info_text"><span class="crm_infostar">*</span><?php _e('One License Key / Purchase Code is required for each Website');?></div>
						</div>
						<div class="crm_content_wrap " id="crm_videos">
							<div class="crm_title"><?php _e('Terms of using HTML5 Videos from the Library');?></div>
							<div class="crm_content"><div class="crm_arrow material-icons">arrow_forward</div><div class="crm_text"><?php _e('The videos are free for personal and even for commercial use.');?></div></div>
							<div class="crm_content"><div class="crm_arrow material-icons">arrow_forward</div><div class="crm_text"><?php _e('You can modify, copy and distribute the videos. All without asking for permission or setting a link to the source. So, attribution is not required.');?></div></div>
							<div class="crm_content"><div class="crm_arrow material-icons">arrow_forward</div><div class="crm_text"><?php _e('The only restriction is that identifiable people may not appear in a bad light or in a way that they may find offensive, unless they give their consent.');?></div></div>
							<div class="crm_content"><div class="crm_arrow material-icons">arrow_forward</div><div class="crm_text"><?php _e('The CC0 license was released by the non-profit organization Creative Commons (CC). Get more information about Creative Commons images and the license on the official license page.');?></div></div>
							<div class="crm_content"><div class="crm_arrow material-icons">arrow_forward</div><div class="crm_text"><?php _e('Videos from');?> <a target="_blank" rel="noopener" href="https://www.pexels.com/"><?php _e('Pexels');?></a> <?php _e('under the license');?> <a target="_blank" rel="noopener" href="https://creativecommons.org/share-your-work/public-domain/cc0/"><?php _e('CC0 Creative Commons');?></a></div></div>
						</div>
						<div class="crm_content_wrap " id="crm_svg">
							<div class="crm_title"><?php _e('Terms of using SVG Objects from the Library');?></div>
							<div class="crm_content"><div class="crm_arrow material-icons">arrow_forward</div><div class="crm_text"><?php _e('Usage only allowed within Slider Revolution Plugin');?></div></div>
							<div class="crm_content"><div class="crm_arrow material-icons">arrow_forward</div><div class="crm_text"><?php _e('A variety of sizes and densities can be also downloaded from the ');?> <a target="_blank" rel="noopener" href="https://github.com/google/material-design-icons"><?php _e('git repository');?></a> <?php _e(', making it even easier for developers to customize, share, and re-use outside of Slider Revolution.');?></div></div>							
							<div class="crm_content"><div class="crm_arrow material-icons">arrow_forward</div><div class="crm_text"><?php _e('Licenses via Apache License. Read More at');?> <a target="_blank" rel="noopener" href="https://github.com/google/material-design-icons/blob/master/LICENSE"><?php _e('Google Material Design Icons');?></a></div></div>
						</div>
						<div class="crm_content_wrap" id="crm_icon">
							<div class="crm_title"><?php _e('Terms of using ICON Objects from the Library');?></div>
							<div class="crm_content"><div class="crm_arrow material-icons">arrow_forward</div><div class="crm_text"><?php _e('Please check the listed license files for details about how you can use the "FontAwesome" and "Stroke 7 Icon" font sets for commercial projects, open source projects, or really just about whatever you want.');?></div></div>
							<div class="crm_content"><div class="crm_arrow material-icons">arrow_forward</div><div class="crm_text"><?php _e('Please respect all other icon fonts licenses for fonts not included directly into Slider Revolution.');?></div></div>
							<div class="div25"></div>
							<div class="crm_title"><?php _e('Further License Information');?></div>
							<div class="crm_content"><div class="crm_arrow material-icons">arrow_forward</div><div class="crm_text"><?php _e('<b>Font Awesome 4.6.3</b> by @davegandy - http://fontawesome.io - @fontawesome <br>License -');?> <a target="_blank" rel="noopener" href="http://fontawesome.io/license"><?php _e('http://fontawesome.io/license');?></a><?php _e('(Font: SIL OFL 1.1, CSS: MIT License)');?></div></div>
							<div class="crm_content"><div class="crm_arrow material-icons">arrow_forward</div><div class="crm_text"><?php _e('<b>Stroke 7 Icon Font Set</b> by www.pixeden.com <br>Get your Freebie Iconset at');?> <a target="_blank" rel="noopener" href="http://www.pixeden.com/icon-fonts/stroke-7-icon-font-set"><?php _e('http://www.pixeden.com/icon-fonts/stroke-7-icon-font-set');?></a></div></div>
						</div>
						<div class="crm_content_wrap selected" id="crm_layers">
							<div class="crm_title"><?php _e('Terms of using Layer Group Objects from the Library');?></div>
							<div class="crm_content"><div class="crm_arrow material-icons">arrow_forward</div><div class="crm_text"><?php _e('Layer Group Objects from the Slider Revolution Library <b>must only</b> be used with a');?><br><a target="_blank" rel="noopener" href="<?php echo $registered_p_c_url; ?>"><?php echo $registered_p_c;?></a> <?php _e('on that particular website.');?></div></div>							
							<div class="crm_content"><div class="crm_arrow material-icons">arrow_forward</div><div class="crm_text"><?php _e('Media assets used in the respective Layer Group Objects, are licensed according to the here mentioned license terms (see list on the left).');?></div></div>							
							<div class="div30"></div>
							<a target="_blank" rel="noopener" href="https://getsliderrevolution.com" class="crm_basic_button basic_action_button autosize basic_action_coloredbutton" style="padding:0px 30px"><?php _e('Buy another License');?> <span style="line-height:28px" class="crm_infostar">*</span></a>
							<div class="crm_info_text"><span class="crm_infostar">*</span><?php _e('One License Key / Purchase Code is required for each Website');?></div>
						</div>
					</div>
				</div>					
			</div>
		</div>
	</div>
</div>