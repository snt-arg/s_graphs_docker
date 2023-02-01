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

<!--WELCOME MODAL-->
<div class="_TPRB_ rb-modal-wrapper" data-modal="rbm_welcomeModal">
	<div class="rb-modal-inner">
		<div class="rb-modal-content">
			<div id="rbm_welcomeModal" class="rb_modal form_inner">
				<div class="rbm_header"><span class="rbm_title"><?php printf(__('Welcome to Slider Revolution %s', 'revslider'), RS_REVISION);?></span><i class="rbm_close material-icons">close</i></div>
				<div class="rbm_content">
					<div style="padding:80px 100px 0px">
						<div id="welcome_logo"></div>
						<div class="mcg_option_third_wraps">
							<div class="st_slider mcg_guide_optionwrap mcg_option_third">																
								<div class="mcg_o_title"><?php _e('What\'s new?');?></div>
								<div class="mcg_o_descp"><?php printf(__( 'Go over our Change Log to learn about new Features and Bug Fixes in Version %s.', 'revslider'), RS_REVISION); ?></div>
								<div class="div25"></div>
								<a  target="_blank" rel="noopener" href="https://www.sliderrevolution.com/documentation/changelog/" class="basic_action_button autosize basic_action_lilabutton"><?php _e('More Info');?></a>
							</div>
							<div class="st_scene mcg_guide_optionwrap mcg_option_third">																
								<div class="mcg_o_title"><?php _e('First Steps, Docs & FAQs');?></div>
								<div class="mcg_o_descp"><?php printf(__( 'Check out our Help Center with updated<br>%s Support Posts, Manual and Video Tuts.', 'revslider'), RS_REVISION); ?></div>
								<div class="div25"></div>
								<a  target="_blank" rel="noopener" href="https://www.sliderrevolution.com/help-center/?utm_source=admin&utm_medium=button&utm_campaign=srusers&utm_content=faq" class="basic_action_button autosize basic_action_lilabutton"><?php _e('Help Center');?></a>
							</div>
							<div class="st_carousel mcg_guide_optionwrap mcg_option_third last">																
								<div class="mcg_o_title"><?php _e('Clear your Browser Cache');?></div>
								<div class="mcg_o_descp"><?php _e('To make sure that all Slider Revolution files<br>are updated, please clear your cache.');?></div>
								<div class="div25"></div>
								<a  target="_blank" rel="noopener" href="https://www.sliderrevolution.com/faq/updating-make-sure-clear-caches/" class="basic_action_button autosize basic_action_lilabutton"><?php _e('How to?');?></a>
							</div>
						</div>
						<div class="div75"></div>
					</div>
					<?php
					if(get_option('revslider-valid', 'false') == 'true') { ?>
						<div id="open_welcome_register_form" class="big_purple_linkbutton"><?php _e('Lets get Started with ' );?> <b> <?php printf(__('Slider Revolution %s', 'revslider'), RS_REVISION); ?></b></div>
					<?php } else { ?>
						<div id="open_welcome_register_form" class="big_purple_linkbutton"><?php _e('Register Slider Revolution to');?> <b> <i class="material-icons">lock</i> <?php _e('Unlock all Features');?></b></div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>


<!--GLOBAL CUSTOM FONTS MODAL-->
<div class="_TPRB_ rb-modal-wrapper" data-modal="rbm_globalfontsettings" style="z-index:1000010 !important">
	<div class="rb-modal-inner">
		<div class="rb-modal-content">
			<div id="rbm_globalfontsettings" class="rb_modal form_inner">
				<div class="rbm_header"><i class="rbm_symbol material-icons">font_download</i><span class="rbm_title"><?php _e('Global Custom Fonts', 'revslider');?></span><i class="rbm_close material-icons">close</i></div>
				<div class="rbm_content">					
					<div class="modal_fields_title" style="width:200px;"><?php _e('Font Family Name', 'revslider');?></div><!--
					--><div class="modal_fields_title" style="width:200px;"><?php _e('Font CSS URL', 'revslider');?></div><!--
					--><div class="modal_fields_title" style="width:200px;"><?php _e('Available Font Weights', 'revslider');?></div><!--
					--><div class="modal_fields_title" style="width:75px;margin-left:10px;"><?php _e('Front End', 'revslider');?></div><!--
					--><div class="modal_fields_title" style="width:75px;"><?php _e('in Editor', 'revslider');?></div>					
					<div id="global_custom_fonts" style="margin-bottom:10px">
					</div>	
					<div id="add_new_custom_font" class="basic_action_button autosize rightbutton"><i class="material-icons">add</i><?php _e('Add Custom Font', 'revslider');?></div>				
				</div>
			</div>
		</div>
	</div>
</div>

<!--GLOBAL SETTINGS MODAL-->
<div class="_TPRB_ rb-modal-wrapper" data-modal="rbm_globalsettings">
	<div class="rb-modal-inner">
		<div class="rb-modal-content">
			<div id="rbm_globalsettings" class="rb_modal form_inner">
				<div class="rbm_header"><i class="rbm_symbol material-icons">settings</i><span class="rbm_title"><?php _e('Global Settings', 'revslider');?></span><i class="rbm_close material-icons">close</i></div>
				<div class="rbm_content"><!--
					--><div class="rbm_general_half" style="padding-right:20px;">
						<div class="ale_i_title"><?php _e('General', 'revslider');?></div>
						<hr class="general_hr">
						<label_a><?php _e('Permission', 'revslider');?></label_a><select id="role" name="role" data-theme="inmodal" class="globalinput easyinit nosearchbox tos2" data-r="globals.permission">
										<option selected="selected" value="admin"><?php _e('To Admin', 'revslider');?></option>
										<option value="editor"><?php _e('To Editor, Admin', 'revslider');?></option>
										<option value="author"><?php _e('Author, Editor, Admin', 'revslider');?></option>
									</select><span class="linebreak"></span>						
						<label_a><?php _e('Language', 'revslider');?></label_a><select id="plugin_lang" name="plugin_lang" data-theme="inmodal" class="globalinput easyinit nosearchbox tos2" data-r="globals.lang">
										<option selected="selected" value="default"><?php _e('Default', 'revslider');?></option>
										<?php
										if(isset($rs_languages) && !empty($rs_languages)){
											foreach($rs_languages as $rs_l => $rs_n){
												echo '<option value="'.$rs_l.'">'.$rs_n.'</option>';
											}
										}
										?>
									</select><span class="linebreak"></span>
						<label_a><?php _e('Include libraries globally', 'revslider');?></label_a><input type="checkbox" class="easyinit globalinput" data-r="globals.allinclude"><span class="linebreak"></span>
						<label_a><?php _e('List of pages to include RevSlider libraries ', 'revslider');?></label_a><input type="text" data-r="globals.includeids" class="easyinit globalinput" placeholder="<?php _e('(ie. Example 2,homepage,5)', 'revslider');?>"><span class="linebreak"></span>
						<label_a><?php _e('Cross-origin image defaults', 'revslider');?><a href="https://www.themepunch.com/faq/cors/" style="margin-left:10px;" target="_blank" rel="noopener"><i style="font-size:15px" class="material-icons">help</i></a></label_a><select id="crossorigin" name="crossorigin" data-theme="inmodal" class="globalinput easyinit nosearchbox tos2" data-r="globals.imgcrossOrigin">
										<option selected="selected" value="unset"><?php _e('Unset','revslider');?></option>
										<option value="anonymous"><?php _e('Anonymous', 'revslider');?></option>
										<option value="use-credentials"><?php _e('Use Credentials', 'revslider');?></option>
									</select><span class="linebreak"></span>
						<div class="div25"></div>
						<div class="ale_i_title"><?php _e('Page Loading Optimization', 'revslider');?></div>
						<hr class="general_hr">
						<label_a><?php _e('Insert scripts in footer', 'revslider');?></label_a><input type="checkbox" class="easyinit globalinput" data-r="globals.script.footer"><span class="linebreak"></span>
						<label_a><?php _e('Defer JavaScript loading', 'revslider');?></label_a><input type="checkbox" class="easyinit globalinput" data-r="globals.script.defer"><span class="linebreak"></span>
						<label_a><?php _e('Load Files asynchronously', 'revslider');?></label_a><input type="checkbox" class="easyinit globalinput" data-r="globals.script.async"><span class="linebreak"></span>
						<label_a><?php _e('Load YouTube API early', 'revslider');?></label_a><input type="checkbox" class="easyinit globalinput" data-r="globals.script.ytapi"><span class="linebreak"></span>
												
						
						<div class="div25"></div>
						<div class="ale_i_title"><?php _e('Fonts', 'revslider');?></div>
						<hr class="general_hr">
						<label_a><?php _e('Enable custom font selection in editor', 'revslider');?></label_a><div id="rs_gl_custom_fonts" class="basic_action_button autosize"><i class="material-icons">font_download</i><?php _e('Edit Custom Fonts', 'revslider');?></div>
						<label_a><?php _e('Disable SR Font Awesome library', 'revslider');?></label_a><input type="checkbox" class="easyinit globalinput" data-r="globals.fontawesomedisable"><span class="linebreak"></span>					
						<div class="div25"></div>						
						<label_a><?php _e('Enable Google Fonts download', 'revslider');?></label_a><select id="fontdownload" name="fontdownload" data-theme="inmodal" class="globalinput easyinit nosearchbox tos2" data-r="globals.fontdownload">
										<option selected="selected" value="off"><?php _e('Load from Google','revslider');?></option>
										<option value="preload"><?php _e('Cache Fonts Local', 'revslider');?></option>
										<option value="disable"><?php _e('Disable, Load on your own', 'revslider');?></option>
									</select><span class="linebreak"></span>
						<label_a><?php _e('Optional Google Fonts loading URL', 'revslider');?></label_a><input type="text" class="easyinit globalinput" data-r="globals.fonturl" placeholder="<?php _e('(ie. http://fonts.useso.com/css?family for chinese Environment)', 'revslider');?>"><span class="linebreak"></span>
						<label_a></label_a><div id="rs_trigger_font_deletion" class="basic_action_button autosize"><i class="material-icons">build</i><?php _e('Update Preload Fonts', 'revslider'); ?></div>
					</div><!--
					--><div class="rbm_general_half" style="padding-left:20px;">
						<div class="ale_i_title"><?php _e('Default Layout Grid Breakpoints', 'revslider');?></div>
						<hr class="general_hr">
						<label_a><?php _e('Default desktop content width', 'revslider');?></label_a><input type="text" class="easyinit globalinput" data-numeric="true" data-allowed="px" data-min="0" data-max="2400" data-r="globals.size.desktop"><span class="linebreak"></span>
						<label_a><?php _e('Default notebook content width', 'revslider');?></label_a><input type="text" class="easyinit globalinput" data-numeric="true" data-allowed="px" data-min="0" data-max="2400" data-r="globals.size.notebook"><span class="linebreak"></span>
						<label_a><?php _e('Default tablet content width', 'revslider');?></label_a><input type="text" class="easyinit globalinput" data-numeric="true" data-allowed="px" data-min="0" data-max="2400" data-r="globals.size.tablet"><span class="linebreak"></span>
						<label_a><?php _e('Default mobile content width', 'revslider');?></label_a><input type="text" class="easyinit globalinput" data-numeric="true" data-allowed="px" data-min="0" data-max="2400" data-r="globals.size.mobile"><span class="linebreak"></span>		
						<div class="div25"></div>
						<div class="ale_i_title"><?php _e('Modules Optimization', 'revslider');?></div>
						<hr class="general_hr">
						<label_a><?php _e('Force 1xDPR on mobile', 'revslider');?></label_a><input type="checkbox" class="easyinit globalinput" data-r="globals.onedpronmobile"><span class="linebreak"></span>
						<label_a><?php _e('Force viewport loading', 'revslider');?></label_a><select data-showprio="show" data-show=".show_forceViewport_*val*" data-hide=".hide_forceViewport" id="forceViewport" name="forceViewport" data-theme="inmodal" class="globalinput easyinit nosearchbox tos2" data-r="globals.forceViewport">
										<option value="true"><?php _e("On", 'revslider');?></option><option value="false"><?php _e("Off", 'revslider');?></option><option value="none"><?php _e("No Change", 'revslider');?></option>
									</select><span class="linebreak"></span>
						<div class="show_forceViewport_true hide_forceViewport"><label_a><?php _e('ViewPort Distance if Forced', 'revslider');?></label_a><input type="text" class="easyinit globalinput" data-numeric="true" data-allowed="px,%" data-min="-1500" data-max="1500" data-r="globals.forcedViewportDistance"></div>
						<label_a><?php _e('Default lazy loading in modules', 'revslider');?></label_a><select id="overwritelazyloading" name="overwritelazyloading" data-theme="inmodal" class="globalinput easyinit nosearchbox tos2" data-r="globals.forceLazyLoading">
										<option value="all"><?php _e("All", 'revslider');?></option><option value="smart"><?php _e("Smart", 'revslider');?></option><option value="single"><?php _e("Single", 'revslider');?></option><option value="none"><?php _e("No Change", 'revslider');?></option>
									</select><span class="linebreak"></span>
						<label_a><?php _e('Lazy Load on BG Images', 'revslider');?></label_a><input type="checkbox" class="easyinit globalinput" data-r="globals.lazyonbg"><span class="linebreak"></span>
						<label_a><?php _e('Third-party lazy loading data', 'revslider');?></label_a><input type="text" class="easyinit globalinput"  data-r="globals.lazyloaddata" placeholder="<?php _e('(i.e. lazy-src for WP Rocket)', 'revslider'); ?>"><span class="linebreak"></span>
						<label_a><?php _e('Use internal caching', 'revslider');?></label_a><input type="checkbox" class="easyinit globalinput" data-r="globals.internalcaching"><span class="linebreak"></span>
						<label_a></label_a><div id="rs_force_clear_cache" class="basic_action_button autosize"><i class="material-icons">build</i><?php _e('Clear Cache', 'revslider'); ?></div>
						<div class="div25"></div>
						<div class="ale_i_title"><?php _e('Miscellaneous', 'revslider');?></div>
						<hr class="general_hr">						
						<label_a><?php _e('Fix RevSlider table issues', 'revslider');?></label_a><div id="rs_db_force_create" class="basic_action_button autosize"><i class="material-icons">build</i><?php _e('Force RS DB Creation', 'revslider');?></div>						
						<label_a><?php _e('Editor high contrast mode', 'revslider');?></label_a><input type="checkbox" class="easyinit globalinput callEvent" data-evt="highContrast" data-r="globals.highContrast"><span class="linebreak"></span>

						
						
						
						<!--<input type="text" class="easyinit globalinput" data-r="globals.customfonts" placeholder="<?php _e('font-family, font-family, ...', 'revslider');?>"><span class="linebreak"></span>-->
						<!--<div id="general_custom_fonts_list"></div>
						<label_a></label_a><div class="basic_action_button onlyicon" id="add_custom_global_fonts"><i class="material-icons">add</i></div>		-->
					</div>
				</div>	
				
				<div id="rbm_globalsettings_savebtn"><i class="material-icons mr10">save</i><span class="rbm_cp_save_text"><?php _e('Save Global Settings', 'revslider');?></span></div>
			</div>
		</div>
	</div>
</div>
