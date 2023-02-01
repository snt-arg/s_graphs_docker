/*!

	// ****************************
	// **********  USAGE **********
	// ****************************
	RsTooltips(
	
		true, // initialize the tooltip mode?
		['add_layer', 'change_slides'] // array of tooltips to show and in what order
	
	);

*/

(function() {
	
	
	
	var data,
		shell,
		bodies,
		tipList,
		toolTip,
		tipText,
		section,
		linkButton,
		totalSteps,
		currentTip,
		currentStep,
		currentData,
		currentTarget,
		toolTipWidth,
		rightToolbar;
		
		
	var defaults = [
		
		'back',
		'slides',
		'add_slide',
		'global_layers',
		'slide_order',
		'add_layer',
		'add_layer_text',
		'add_layer_image',
		'add_layer_button',
		'add_layer_shape',
		'add_layer_video',
		'add_layer_audio',
		'add_layer_object',
		'add_layer_row',
		'add_layer_group',
		'add_layer_layerlibrary',
		'add_layer_importlayer',
		'edit_layer_name',
		'duplicate_layer',
		'copy_layer',
		'paste_layer',
		'delete_layer',
		'lock_layers',
		'unlock_layers',
		'hide_highlight_boxes',
		'show_hide_selected',
		'set_all_visible',
		'change_layer_order',
		'layer_selections',
		'undo_redo',
		'device_switcher',
		'help_mode',
		'tooltip_button',
		'quick_style',
		'slider_settings',
		'slider_navigation',
		'slide_settings',
		'layer_settings',
		'shortcode',
		'layout_type',
		'layout_sizing',
		'breakpoints',
		'module_content',
		'auto_rotate',
		'lazy_loading',
		'progress_bar',
		'navigation_arrows',
		'navigation_bullets',
		'navigation_tabs',
		'navigation_thumbs',
		'slide_background',
		'slide_animation',
		'background_filter',
		'slide_duration',
		'slide_link',
		'edit_text',
		'font_size',
		'font_family',
		'font_color',
		'layer_position',
		'layer_animations',
		'layer_hover',
		'responsive_behavior',
		'timeline_preview',
		'save_module',
		'preview_module'

	];
	
	function getData() {
		
		jQuery('<link rel="stylesheet" type="text/css" href="' + RVS.ENV.plugin_url + 'admin/assets/css/tooltip.css" />').appendTo(jQuery('head'));
		RVS.F.ajaxRequest('get_tooltips', {}, function(response) {
			
			if(response.success) {	
				
				try {
					data = JSON.stringify(response.data);
					data = JSON.parse(data);
				}
				catch(e) {
					data = false;
				}
				
				if(data) init();
				else console.log('tooltip ajax error');
					
			}
			else {
				console.log('tooltip ajax error');
			}
			
		});
		
	}
	
	function clonePreviewSave() {
		
		jQuery(this).clone().addClass('tooltip-save-preview').insertAfter(toolTip);
		
	}
		
	function openToolTips() {
		
		jQuery(shell).appendTo(jQuery('#rb_tlw'));
		jQuery('.rs-tooltip-btn').not('.tooltip-link').on('click.tooltips', btnClick);
		jQuery('.rs-tooltip-check').on('click.tooltips', cancelTips);
		jQuery('#rs-tooltip-close').on('click.tooltips', exitTips);
		
		toolTip = jQuery('#rs-tooltip');
		tipText = jQuery('.tooltip-text');
		section = jQuery('.tooltip-section');
		
		toolTipWidth = toolTip.outerWidth();
		linkButton = jQuery('.tooltip-link').on('click.tooltips', openLink);
		
		rightToolbar = jQuery('#the_right_toolbar_inner');
		tipList = window.RsTooltipList || defaults;
		totalSteps = tipList.length;
		currentStep = 0;
		
		bodies = jQuery('body');
		RVS.WIN.on('keydown.tooltips', keyShortcut).on('resize.tooltips', runStep);
		jQuery('.rs-save-preview').each(clonePreviewSave);
		
		runStep();
		
	}
	
	function openLink() {
		
		window.open(this.dataset.href);
		
	}
	
	function closeToolTips() {
		
		jQuery('.tooltip-hide-target').removeClass('tooltip-hide-target');
		jQuery('.tip-clone').remove();
		
		jQuery('.rs-tooltip-btn').off('.tooltips');
		jQuery('.rs-tooltip-check').off('.tooltips');
		jQuery('#rs-tooltip-close').off('.tooltips');
		
		jQuery('#rs-tooltip').remove();
		jQuery('.tooltip-save-preview').remove();
		
		jQuery('body').removeClass('rb-tooltips-active');
		RVS.WIN.off('.tooltips');
		
		linkButton.off('.tooltips');
		
		bodies = null;
		toolTip = null;
		tipText = null;
		section = null;
		currentTip = null;
		linkButton = null;
		rightToolbar = null;
		currentTarget = null;
		
	}
	
	function cleanup() {
		
		cancelAnimationFrame(displayStep);
		
	}
	
	function exitTips() {
		
		cleanup();
		closeToolTips();
		
	}
	
	function cancelTips() {
		
		RVS.F.ajaxRequest('set_tooltip_preference', false, false, true, true);	
		exitTips();
		
	}
	
	function btnClick() {
		
		if(this.id === 'rs-tooltip-next') {
			currentStep++;
			runStep();
		}
		else {
			exitTips();
		}
		
	}
	
	function nextButton() {
		
		var btn = jQuery('#rs-tooltip-next');
		if(!btn.is(':visible')) btn = jQuery('#rs-tooltip-gotit');
		btn.trigger('click');
		
	}
	
	function runStep() {
		
		cleanup();
		currentTip = currentData.tooltips[tipList[currentStep]];
		tipText.html(currentTip.text);
		
		/*
		if(currentTip.section) section.html(currentTip.section).show();
		else section.hide();
		*/
		
		/*
		if(currentTip.link) linkButton.attr('data-href', currentTip.link).text(currentTip.linkText).show();
		else linkButton.hide();
		*/
		
		if(currentStep < totalSteps - 1) toolTip.removeClass('tooltip-gotit');
		else toolTip.addClass('tooltip-gotit');
		
		if(currentTip.trigger) {
			
			let triggers = currentTip.trigger,
				len = triggers.length;
				
			for(let i = 0; i < len; i++) {
		
				let trigger = jQuery(triggers[i]);
				if(trigger.length) {
					
					jQuery(trigger).first().trigger('click');
					
				}
				else {
					
					console.log('tooltip trigger does not exist');
					nextButton();
					return;
					
				}
				
			}
			
		}
		
		currentTarget = jQuery(currentTip.target).first();
		if(!currentTarget.length) {
			
			console.log('tooltip target does not exist');
			nextButton();
			return;
			
		}
		
		rightToolbar.scrollTop(0);
		if(currentTip.scrollTo) {
			
			let scrollTo = jQuery(currentTip.scrollTo).filter(':visible');
			rightToolbar.scrollTop(scrollTo.offset().top - 50);
			requestAnimationFrame(displayStep);
			
		}
		
		requestAnimationFrame(displayStep);
		
	}
	
	function displayStep() {
		
		jQuery('.tooltip-hide-target').removeClass('tooltip-hide-target');
		jQuery('.tip-clone').remove();
		
		var offset = currentTarget.offset(),
			position,
			placer;
		
		toolTip.removeClass(function(i, clas) {return (clas.match (/(^|\s)tip-\S+/g) || []).join(' ');});
		toolTip.addClass('tip-' + currentTip.alignment);
		
		if(currentTip.margin) toolTip.css('margin', currentTip.margin);
		else toolTip.css('margin', 0);
		
		var padding = currentTarget.css('padding'),
			paddingLeft = Math.round(parseInt(currentTarget.css('padding-left'), 10) * 0.25);
			cloned = currentTarget.clone();
					
		cloned.find('input[type="radio"]').each(function() {this.name = this.name + '-tooltip';});
		cloned.addClass('tip-clone').css({top: offset.top, left: offset.left, padding: padding}).insertBefore(toolTip);
		
		if(currentTip.cssClass) cloned.addClass(currentTip.cssClass);		
		if(currentTip.elementcss) {
			
			let css = currentTip.elementcss.split(';'),
				len = css.length;
				
			for(let i = 0; i < len; i++) {
				
				let style = css[i].split(':');
				cloned.css(RVS.F.trim(style[0]), RVS.F.trim(style[1]));
				
			}
			
		}
		
		if(currentTip.placer) {
			
			placer = jQuery(currentTip.placer).first();
			if(placer.length) {
				
				offset = placer.offset();
				
			}
			else {
				
				console.log('tooltip placer does not exist');
				nextButton();
				return;
				
			}
			
		}
		
		var noFocus = currentTip.focus === 'none';
		if(!currentTip.focus || noFocus) {
			
			if(!noFocus) cloned.addClass('tip-focussed');
			if(!placer) placer = currentTarget;
			
		}
		else {
			
			let clas = currentTip.focusClass || 'tip-focussed';
				focussed = cloned.find(currentTip.focus).first().addClass(clas);
				
			if(!focussed.length) {
				
				console.log('tooltip focus does not exist');
				nextButton();
				return;
				
			}	

			if(!placer) {
				placer = focussed;
				offset = placer.offset();
			}
			
		}
		
		position = getPosition(placer, currentTip.alignment);
		toolTip.css({left: offset.left + position.x - paddingLeft, top: offset.top + position.y});
		
		currentTarget.addClass('tooltip-hide-target');
		bodies.addClass('rb-tooltips-active');
		
		if(!currentTip.hidePrevSave) bodies.removeClass('tooltip-hide-preview-save');
		else bodies.addClass('tooltip-hide-preview-save');
		
	}
	
	function getPosition(target, align) {
		
		var xx,
			yy;
		
		switch(align) {
			
			case 'top':
			case 'bottom':
				xx = (Math.round(target.outerWidth() * 0.5) - Math.round(toolTipWidth * 0.5));
			break;
			
			case 'left':
			case 'right':
				yy = -(Math.round(toolTip.outerHeight() * 0.5) - Math.round(target.outerHeight() * 0.5));
			break;
			
			case 'bottom-left':
			case 'top-left':
			case 'right-top':
				xx = -toolTip.width();
			break;
			
			case 'bottom-right':
			case 'top-right':
				xx = target.outerWidth();
			break;
			
		}
		
		switch(align) {
			
			case 'top':
			case 'right-top':
				yy = -(target.outerHeight() + toolTip.height());
			break;
			
			case 'top-left':
			case 'top-right':
				yy = 0;
			break;
			
			case 'bottom':
			case 'bottom-left':
			case 'bottom-right':
				yy = target.outerHeight();
			break;
			
			case 'left':
				xx = -toolTipWidth;
			break;
			
			case 'right':
				xx = target.outerWidth();
			break;
			
		}
		
		return {x: xx, y: yy};
		
	}
	
	function keyShortcut(e) {
		
		if(e.keyCode === 13) nextButton();
		
	}
	
	function init() {
		
		currentData = jQuery.extend(true, {}, data);
		shell = 
	
		'<div id="rs-tooltip">' + 
			'<div id="rs-tooltip-top">' + 
				'<span class="rs-tooltip-text"><span class="tooltip-section"></span><span class="tooltip-text"></span></span>' + 
				'<span class="rs-tooltip-btn tooltip-link" data-href="tooltip-link"></span><span id="rs-tooltip-next" class="rs-tooltip-btn"><i class="material-icons">redo</i>' + currentData.translations.next_tip + '<span class="rs-tooltip-return-icon"></span></span><span id="rs-tooltip-gotit" class="rs-tooltip-btn"><i class="material-icons">thumb_up</i>' + currentData.translations.got_it +'</span>' + 
			'</div>' + 
			'<div id="rs-tooltip-bottom"><div><span class="rs-tooltip-check"></span>' + currentData.translations.hide_tips + '</div></div>' +
			'<span id="rs-tooltip-close"><i class="material-icons">close</i></span>' + 
		'</div>';
		
		var btn = jQuery('.tooltip_wrap'),
			defs = btn.data('tooltip-definitions');
			
		if(defs) {
		
			jQuery.extend(true, currentData.tooltips, defs);
			btn.removeData('tooltip-definitions');
			
		}
		
		jQuery(document).on('start-tooltips', openToolTips);
		btn.data('scriptready', true);
		openToolTips();
		
	}
	
	getData();
	
})();















