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

<!-- UNDERLAY FOR MODALS -->
<div id="rb_modal_underlay"></div>

<!-- DECISION MODAL -->
<div class="_TPRB_ rb-modal-wrapper" data-modal="rbm_decisionModal">
	<div class="rb-modal-inner">
		<div class="rb-modal-content">
			<div id="rbm_decisionModal" class="rb_modal form_inner">
				<div class="rbm_header"><i id="decmod_icon" class="rbm_symbol material-icons">info</i><span id="decmod_title" class="rbm_title"><?php _e('Decision Modal Title', 'revslider');?></span></div>
				<div class="rbm_content">
					<div id="decmod_maintxt"></div>
					<div id="decmod_subtxt"></div>
					<div class="div75"></div>
					<div id="decmod_do_btn" class="rbm_darkhalfbutton mr10"><i id="decmod_do_icon" class="material-icons">add_circle_outline</i><span id="decmod_do_txt"><?php _e('Do It', 'revslider');?></span></div><!--
					--><div id="decmod_dont_btn" class="rbm_darkhalfbutton"><i id="decmod_dont_icon" class="material-icons">add_circle_outline</i><span id="decmod_dont_txt"><?php _e('Dont Do It', 'revslider');?></span></div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- PREVIEW MODAL -->
<div class="_TPRB_ rb-modal-wrapper" data-modal="rbm_preview">
	<div class="rb-modal-inner">
		<div class="rb-modal-content">
			<div id="rbm_preview" class="rb_modal form_inner">
				<div class="rbm_header"><i class="rbm_symbol material-icons">search</i><span class="rbm_title"><?php _e('Preview', 'revslider');?></span><span class="rbm_subtitle"><i class="material-icons">photo</i><span id="rbm_preview_moduletitle">Some Module Title</span></span><span class="rbm_preview_sizes"><i data-ref="d" class="rbm_prev_size_sel material-icons selected">desktop_windows</i><i data-ref="n" class="rbm_prev_size_sel material-icons">laptop</i><i data-ref="t" class="rbm_prev_size_sel material-icons">tablet_mac</i><i data-ref="m" class="rbm_prev_size_sel material-icons">phone_android</i></span><div data-clipboard-action="copy" data-clipboard-target="#copy_shortcode_from_preview" class="copypreviewshortcode basic_action_button autosize rightbutton" style="margin-top:10px;margin-right:30px"><i class="material-icons">content_paste</i><?php _e('Copy Embed Code', 'revslider');?></div><i class="rbm_close material-icons">close</i></div>	
				<div class="rbm_content">
					<input style="position:absolute; top:0px; left:0px;height:0px;width:100%; opacity:0; overflow:hidden; outline:none;border:none" class="inputtocopy" id="copy_shortcode_from_preview" readonly="" value="[rev_slider alias=&quot;slider1&quot;][/rev_slider]">
					<div id="rbm_preview_live"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--ADDONS INSTALLATION MODAL-->
<div class="_TPRB_ rb-modal-wrapper" data-modal="rbm_addons">
	<div class="rb-modal-inner">
		<div class="rb-modal-content">
			<div id="rbm_addons" class="rb_modal form_inner">
				<div class="rbm_header"><i class="rbm_symbol material-icons">extension</i><span class="rbm_title"><?php _e('Addons', 'revslider');?></span><i class="rbm_close material-icons">close</i><div id="check_addon_updates_wrap"><div id="check_addon_updates" class="basic_action_button autosize"><i class="material-icons">refresh</i><?php _e('Check for Updates', 'revslider');?></div><div id="process_all_addon_updates" class="ale_i_allupdateaddon  basic_action_coloredbutton autosize basic_action_button autosize"><i class="material-icons">get_app</i><?php _e('Update All', 'revslider');?></div></div></div>
				<div id="addon_overviewheader_wrap">
						<div id="addon_overviewheader" class="addon_overview_header">
							<div class="rs_fh_left"><input class="flat_input" id="searchaddons" type="text" placeholder="<?php _e('Search Addons...', 'revslider');?>"/></div>
							<div class="rs_fh_right" style="margin-right:-5px">
								<select id="sel_addon_sorting" data-evt="updateAddonsOverview" data-evtparam="#addon_sorting" class="addon_sortby tos2 nosearchbox callEvent" data-theme="autowidthinmodal"><option value="datedesc"><?php _e('Sort by Date', 'revslider');?></option><option value="pop"><?php _e('Sort by Popularity', 'revslider');?></option><option value="title"><?php _e('Sort by Title', 'revslider');?></option></select>
								<select id="sel_addon_filtering" data-evt="updateAddonsOverview" data-evtparam="#addon_filtering" class="addon_filterby tos2 nosearchbox callEvent" data-theme="autowidthinmodal"><option value="all"><?php _e('Show all Addons', 'revslider');?></option><option value="action"><?php _e('Action Needed', 'revslider');?></option><option value="installed"><?php _e('Installed Addons', 'revslider');?></option><option value="notinstalled"><?php _e('Not Installed Addons', 'revslider');?></option><option value="activated"><?php _e('Activated Addons', 'revslider');?></option></select>							
							</div>
							<div class="tp-clearfix"></div>
						</div>
					</div>
				<div id="rbm_addonlist" class="rbm_content"></div>
				<div id="rbm_addon_details">
					<div class="rbm_addon_details_inner"><div class="div20"></div><div class="ale_i_title"><?php _e('Slider Revolution Addons', 'revslider');?></div><div class="ale_i_content"><?php _e('Please select an Addon to start with.', 'revslider');?></div><div class="div20"></div></div>
				</div>
				<div id="rbm_configpanel_savebtn"><i class="material-icons mr10">save</i><span class="rbm_cp_save_text"><?php _e('Save Configuration', 'revslider');?></span></div>
			</div>
		</div>
	</div>
</div>

<!--DEACTIVATED WARNING MODAL-->
<div class="_TPRB_ rb-modal-wrapper" data-modal="rbm_notactive_warning">
	<div class="rb-modal-inner">
		<div class="rb-modal-content">
			<div id="rbm_notactive_warning" class="rb_modal form_inner">
				<div class="rbm_header"><i class="rbm_close material-icons">close</i></div>	
				<div class="rbm_content">
					<div class="mcg_page mcg_selected">
						<div class="dcenter">							
							<div class="bigredwarning"><i class="material-icons">error_outline</i></div>
							<div class="mcg_page_title warningtext"><?php _e('URGENT', 'revslider');?></div>
							<div class="mcg_page_title"><?php _e('Your Slider Revolution License Has Been Deactivated!', 'revslider');?></div>
							<div><a class="simpletext smalllink" target="_blank" rel="noopener" href="https://www.sliderrevolution.com/faq/why-was-my-slider-revolution-license-deactivated/?utm_source=admin&utm_medium=button&utm_campaign=srusers&utm_content=deactivatedfaq"><?php _e('Wondering why this happened? Click here!', 'revslider');?></a></div>
							<div class="div35"></div>
							<div class="dr_warningbox">
								<div class="mcg_page_subtitle"><i class="material-icons warningicon">block</i></div>
								<div class="div15"></div>
								<div class="mcg_page_subtitle"><?php _e('All of the premium features including templates, media assets,<br>and add-ons have been removed from your website.', 'revslider');?></div>
								<div class="div15"></div>
								<div class="mcg_page_content"><?php _e('We can help you restore everything right now, all you have to do is choose one of<br>the options below:', 'revslider');?></div>
								<div class="div25"></div>
								<purplebutton id="pb_closeandregister" style="display:inline-block; margin-right:10px" class="mcg_next_page"><?php _e('Register Licence Key', 'revslider');?></purplebutton>							
								<a target="_blank" rel="noopener"  href="https://account.sliderrevolution.com/portal/?utm_source=admin&utm_medium=button&utm_campaign=srusers&utm_content=members" style="display:inline-block;" class="bluebutton normal mcg_quit_page"><?php _e('Buy License Key', 'revslider');?></a>
								<div class="div10"></div>
							</div>
							<div class="div10"></div>
							<div class="dr_warningbox">
								<div class="mcg_page_subtitle"><i class="material-icons warningicon">do_not_touch</i></div>
								<div class="div15"></div>
								<div class="mcg_page_subtitle"><?php _e('Please note you don’t have access to Premium 1-on-1 support<br>right now ...', 'revslider');?></div>
								<div class="div15"></div>
								<div class="mcg_page_content"><?php _e('.. however, as soon as you reactivate your license, our top-rated support team will<br>ensure that your website is fully functional.', 'revslider');?></div>
								<div class="div25"></div>
								<purplebutton id="pb_closeandregister" style="display:inline-block; margin-right:10px" class="mcg_next_page"><?php _e('Register Licence Key', 'revslider');?></purplebutton>							
								<a target="_blank" rel="noopener"  href="https://account.sliderrevolution.com/portal/?utm_source=admin&utm_medium=button&utm_campaign=srusers&utm_content=members" style="display:inline-block;" class="bluebutton normal mcg_quit_page"><?php _e('Buy License Key', 'revslider');?></a>
								<div class="div10"></div>
							</div>													
						</div>						
					</div>										
				</div>
			</div>
		</div>
	</div>
</div>

<!--DEACTIVATED ADDONS WARNING MODAL-->
<div class="_TPRB_ rb-modal-wrapper" data-modal="rbm_notactiveaddon_warning">
	<div class="rb-modal-inner">
		<div class="rb-modal-content">
			<div id="rbm_notactiveaddon_warning" class="rb_modal form_inner">
				<div class="rbm_header"><i class="rbm_close material-icons">close</i></div>	
				<div class="rbm_content">
					<div class="mcg_page mcg_selected">
						<div class="dcenter">							
							<div class="bigyellowwarning"><i class="material-icons">error_outline</i></div>
							<div class="mcg_page_title"><?php _e('There is a problem with some of your<br>Slider Revolution modules', 'revslider');?></div>
							<div class="simpletext"><?php _e('These modules are using <a class="smalllink" target="_blank" rel="noopener" href="https://www.sliderrevolution.com/expand-possibilities-with-addons/?utm_source=admin&utm_medium=button&utm_campaign=srusers&utm_content=addons">addons</a> which are deactivated or not installed:', 'revslider');?></a></div>
							<div class="div45"></div>
							<div id="list_of_deactivated_addons"></div>
							<div class="div55"></div>
							<div class="simpletext"><?php _e('Press the button below to install & activate<br>all addons required by your modules.','revslider'); ?></div>
							<div class="div40"></div>
							<purplebutton id="naa_install_all" class="mcg_next_page"><?php _e('Fix All Addons', 'revslider');?></purplebutton>							
							<div class="div40"></div>
						</div>						
					</div>										
				</div>
			</div>
		</div>
	</div>
</div>


