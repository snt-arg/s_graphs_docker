// Administration-specific JavaScript
(function ( $ ) {
	"use strict";

	// Slider type selector dialog
	$(function () {

		var $add_new_slider = $('#msp-add-slider');
		if( ! $add_new_slider.length ) return;	


		// get markup for slider types
		var $slider_types_markup = $('#msp-slider-type-select');

		$slider_types_markup.dialog({
			resizable: false,
			autoOpen: false,
			modal: true,
			width: 1000,
			height: 550,
			title: __MSP_GEN_LAN.genl_005,
			draggable: false,
			show: 'fade',
			dialogClass: 'msp-container msp-dialog msp-starter-selector',
			open: function(){
				$('.ui-widget-overlay').bind('click',function(){
					$slider_types_markup.dialog('close');
				});
			},
			position: { 
				my: "center", 
				at: "center" 
			}
		});

		window.onSelectorDialogResize = function(event){
			var frame = event.data.the_frame;
			frame.dialog("option", "width"   , "80%" );
			frame.dialog("option", "height"  , $(window).height()-90 );
		};

		$(window).bind('resize', { the_frame:$slider_types_markup } , onSelectorDialogResize );
		$(window).trigger('resize');


		// open select type window on add slider btn clicked
		$add_new_slider.on('click', function(event){
			event.preventDefault();
			$slider_types_markup.dialog( 'open' );
		});


		// highlight selected template - ignore coming soon items
		var $slider_types = $('#msp-slider-type-select .msp-template-figure:not(.is-unavailable)');

		$slider_types.on('click', function(event){
			$slider_types.removeClass('selected');
			$(this).addClass('selected');
		});

		// if the template is disabled and disabled_msg is set, display the text on click
		var $slider_types_disabled = $('#msp-slider-type-select .msp-template-figure.is-unavailable');
		
		$slider_types_disabled.on('click', function(event){
			var disabled_alert_text = $(this).data('disabled-msg');
			if( disabled_alert_text )
				alert( disabled_alert_text );
		});

		// get "create" slider
		var $create_slider_btn = $('#msp-slider-type-create');

		$create_slider_btn.on('click', function(event){
			event.preventDefault();
			var $create_btn = $(this);
			

			var $selected_item = $('#msp-slider-type-select .msp-template-figure.selected').eq(0);

			var starter_section = $selected_item.data('starter-section');
			var slider_type     = $selected_item.data('slider-type');
			var starter_id      = $selected_item.data('starter-uid');

			if( 'main_types' == starter_section ) {

				$create_btn.text( __MSP_GEN_LAN.genl_004 );
				$create_btn.prop("disabled",true);

				jQuery.post(
					ajaxurl,
					{
						action			: 'msp_create_new_handler', // the handler
						nonce			: jQuery('#msp-main-wrapper').data('nonce'), // the generated nonce value
						slider_type		: slider_type
					},
					function(res){
						
						if( res.success === true ){
							$create_btn.text( __MSP_GEN_LAN.genl_003 );
							window.location.href = res.redirect;
						}else{
							$create_btn.prop( "disabled", false );
							$create_btn.text( res.message );
						}
					}
				);

			} else {
				$create_btn.text( 'Preparing to import content ..' );
				window.location.href = __MS.importer + "&starter_id=" + starter_id + "&step=2";
			}

		});

	});
	


	// Live preview
	$(function (){

		window.lunchMastersliderPreview = function( event ){
			if( event ) event.preventDefault();

			var $preview_wrapper = $('#msp-slider-preview');

			if( ! $preview_wrapper.length ) {
				$preview_wrapper = $('<iframe id="msp-slider-preview" width="100%" height="90%" ></iframe>');
				$preview_wrapper = $preview_wrapper.appendTo( $('body') );
				$preview_wrapper = $('#msp-slider-preview');
			}

			$preview_wrapper.dialog({
				resizable: false,
				autoOpen: false,
				modal: true,
				width: $(window).width(),
				height: $(window).height()-45,
				title: __MSP_GEN_LAN.genl_002,
				draggable: false,
				show: 'fade',
				dialogClass: 'msp-container msp-dialog msp-preview-dialog',
				close: function( event, ui ) {
					$preview_wrapper.prop( 'src', 'about:blank');
				},
				open: function(){
					$('.ui-widget-overlay').bind('click',function(){
						$preview_wrapper.dialog('close');
					});
				},
				position: { 
					my: "center", 
					at: "center" 
				},
			});
			
			$preview_wrapper.prop( 'src', __MS.msp_plugin_url + '/admin/views/slider-dashboard/get-preview.html?cn=' + Math.random() ).dialog('open');

			$preview_wrapper.load(function(){
				$preview_wrapper.addClass('axi-preview-loaded');
			});

			window.onbeforeunload = function(){
				if( $preview_wrapper.dialog( 'isOpen' ) )
					return __MSP_GEN_LAN.genl_001;
			};

			// Fluid preview dialog
			window.onPreviewDialogResize = function(event){
				var frame = event.data.the_frame;
				frame.dialog("option", "height"  , $(window).height()-45 );
			};

			$(window).bind('resize', { the_frame:$preview_wrapper } , onPreviewDialogResize );
		};



		window.lunchMastersliderPreviewBySliderID = function( slider_id ){

			var $preview_wrapper = $('#msp-slider-preview');

			if( ! $preview_wrapper.length ) {
				$preview_wrapper = $('<iframe id="msp-slider-preview" width="100%" height="90%" ></iframe>');
				$preview_wrapper = $preview_wrapper.appendTo( $('body') );
				$preview_wrapper = $('#msp-slider-preview');
			}

			$preview_wrapper.dialog({
				resizable: false,
				autoOpen: false,
				modal: true,
				width: $(window).width(),
				height: $(window).height()-45,
				title: __MSP_GEN_LAN.genl_002,
				draggable: false,
				show: 'fade',
				dialogClass: 'msp-container msp-dialog msp-preview-dialog',
				close: function( event, ui ) {
					$preview_wrapper.prop( 'src', 'about:blank');
				},
				open: function(){
					$('.ui-widget-overlay').bind('click',function(){
						$preview_wrapper.dialog('close');
					});
				},
				position: { 
					my: "center", 
					at: "center" 
				}
			});

			$preview_wrapper.load(function(){
				$preview_wrapper.addClass('axi-preview-loaded');
			});
			
			$preview_wrapper.prop( 'src', __MS.msp_menu_page + '&action=preview&strip_wp&slider_id=' + slider_id ).dialog('open');

			window.onbeforeunload = function(){
				if( $preview_wrapper.dialog( 'isOpen' ) )
					return __MSP_GEN_LAN.genl_001;
			};

			window.onPreviewDialogResize = function(event){
				var frame = event.data.the_frame;
				frame.dialog("option", "height"  , $(window).height()-45 );
			};

			$(window).bind('resize', { the_frame:$preview_wrapper } , onPreviewDialogResize );
			$(window).trigger('resize');
		};


		window.lunchMastersliderImportExport = function(){

			var $import_export_wrapper = $('.msp-import-export-wrapper');

			if( ! $import_export_wrapper.length )
				return;

			$import_export_wrapper.dialog({
				resizable: false,
				autoOpen: true,
				modal: true,
				width: 800,
				height: $(window).height()-85,
				title: __MSP_GEN_LAN.genl_007,
				draggable: false,
				show: 'fade',
				dialogClass: 'msp-container msp-dialog msp-import-export-dialog',
				close: function( event, ui ) {
					
				},
				open: function(){
					$('.ui-widget-overlay').bind('click',function(){
						$import_export_wrapper.dialog('close');
					});
				},
				position: { 
					my: "center", 
					at: "center" 
				}
			});

			window.onPreviewDialogResize = function(event){
				var frame = event.data.the_frame;
				var dialogHeight = $(window).height()-85;
				frame.dialog("option", "height"  , dialogHeight );
				$('.msp-export-table-container').css('min-height', dialogHeight - 350 );
			};

			$(window).bind('resize', { the_frame:$import_export_wrapper } , onPreviewDialogResize );
			$(window).trigger('resize');
		};

		// check all btn in export dialog
		$('.export-check-all').bind( 'click', function(){
			
			var $this = $(this);
			var isChecked = $this.prop('checked');
			$('.msp-export-sliders-table .export-slider-cb').prop( 'checked', isChecked );
		});

		// export button clicked
		$('#msp-export-btn').bind( 'click', function(){
			if( ! $('.msp-export-sliders-table .export-slider-cb:checked').length ) {
				alert( __MSP_GEN_LAN.genl_006 );
				return false;
			}
		});

		// help button position 
		if( $('#msp-header').length ){
			var help_btn_top_offset = $('#msp-header')[0].getBoundingClientRect().top - 6;
			$('#contextual-help-link-wrap').css( 'top', help_btn_top_offset );
		}
		
	});
	


}(jQuery));
