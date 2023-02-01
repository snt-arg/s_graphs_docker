/******************************************************************************/

/** Full Screen Sections Height Calculation - Revised in V4.3 **/
;(function( $ ) {

var window_height = $(window),
    page_template = 0,
    init;
	$.fn.FullScreen = function(){
		var body_content = $('body'),
			reduction_index,
			all_objects  = $(this);
		init = function init() {
			be_site_layout = body_content.attr('data-be-site-layout'),
			be_page_template = body_content.attr('data-be-page-template');
			header_style_analyser(be_site_layout, be_page_template);
		}
	    function header_style_analyser(arg_layout_name, arg_template_name) { 
		   	var full_screen_section_count = all_objects.length,
	   		header_style,
	   		index = 0;

   			if (body_content.hasClass('section-scroll'))
	   			header_style = 'section-scroll';
		   	else if (body_content.hasClass('transparent-sticky')) 
		   		header_style = 'transparent-sticky';
		   	else if(body_content.hasClass('sticky-header'))
		   		header_style = 'sticky';
		   	else if(body_content.hasClass('header-transparent'))
		   		header_style = 'header-transparent';
		   	else
		   		header_style = 'non-sticky';

		   	if(window_height.width() > 960) {
				for( index; index<full_screen_section_count; index++ ) {     
					var current_object = all_objects.eq(index); 
					if( current_object.hasClass('full-screen-section') ) {
						reduction_index = sticky_helper(index, arg_layout_name,'',header_style);
						full_screen_section_height_calculation(current_object);
					}else if (current_object.hasClass('full-screen-height')){
						reduction_index = sticky_helper(index, arg_layout_name,arg_template_name,header_style);
						hero_section_height_calculation(current_object,header_style);
					}
					current_object.animate({opacity: 1}, 1000); 
					current_object.css('padding', '0px 0px');
				}
			}else {
				for( index; index<full_screen_section_count; index++ ) {     
					var current_object = all_objects.eq(index);   
						if( current_object.hasClass('full-screen-section')){
							var $padding_top = 0;
							if( index === 0 && ( current_object.find('.master-slider').length <= 0 ) && header_style === 'header-transparent' ) {
								$padding_top = parseInt( $('#header-inner-wrap').height() ) + parseInt( current_object.find('.be-section-pad').attr('data-padding-top') - ( parseInt( $('.logo').css('padding-bottom') ) * 2 ) );
								current_object.find('.be-section-pad').css('padding-top', $padding_top + 'px');	
							}				
							current_object.height('auto');
						}else if (current_object.hasClass('full-screen-height')){
							if ((arg_template_name != 'page-splitscreen-left')	&& (arg_template_name != 'page-splitscreen-right')){
								var $padding_total = 0,
								$padding_split = 0,
								$padding = '';
								if($('.header-hero-section').find('.master-slider').length > 0) {
									$padding = '0px';
								}else{
									if(header_style === 'header-transparent') {
										$padding_total = parseInt($('#header-inner-wrap').height())+200; 
										$padding_split = $padding_total/2;	
										$padding = $padding_split+'px 0px';
									} 
									else{
										$padding = '100px 0px';
									}
								}
								current_object.css('padding',$padding);
								current_object.height('auto');
							}else{
								reduction_index = sticky_helper(index, arg_layout_name,arg_template_name,header_style);
								hero_section_height_calculation(current_object,header_style);
							}
						} 
					current_object.animate({opacity: 1}, 1000); 
				}
			}
		}
		function full_screen_section_height_calculation(current_object) {
			current_object.height(window_height.height()-reduction_index);
			current_object.animate({opacity: 1}, 1000);
		}
		function hero_section_height_calculation(current_object,header_style) {
       		if(current_object.hasClass('full-no')) {
	       	  	current_object.height(window_height.height() - $('#wpadminbar').height());
	       	}else{
       			current_object.height(window_height.height() - reduction_index);
       		}
		}
		function sticky_helper(argIndex,layout_name,page_template,header_type) {
			var border_padding,
				reduction = 0,
				border_padding = Number($('.layout-box-bottom').height()),
				header_height = Number($('#header-inner-wrap').height()),
				admin_bar_height = Number($('#wpadminbar').height());
			if ((page_template != 'page-splitscreen-left')	&& (page_template != 'page-splitscreen-right')){
				switch(layout_name) {
					case 'layout-wide': border_padding *= 0;
					break;
					case 'layout-boxed': border_padding *= 0;
					break;
					case 'layout-border': border_padding *= 2;
					break;
					case 'layout-border-header-top': border_padding *= 1;
					break;
				}
		    	switch(header_type) { // Just computing different reduction_index for different header styles!
		    		case 'sticky': reduction = header_height + admin_bar_height + border_padding;
		    		break;
		    		case 'non-sticky': if(argIndex === 0)
		    		                   		reduction = header_height + admin_bar_height + border_padding;
		    		                   else
		    		                   		reduction = admin_bar_height + border_padding;
		    		break;
		    		case 'transparent-sticky':  if(argIndex === 0)
		    		                            	reduction = admin_bar_height + border_padding;
		    		                            else
		    		                            	reduction = header_height + admin_bar_height + border_padding; 
		    		break;
		    		case 'header-transparent' : reduction = admin_bar_height + border_padding;
		    		break;
		    		case 'section-scroll': 	if((body_content).hasClass('header-transparent'))
		    									reduction = admin_bar_height + border_padding;
											else
												reduction = header_height + admin_bar_height + border_padding;
					break;
		    	}
			}else{
				reduction = 0;
			}
	 	 	return reduction;
		}
		window_height.on('scroll.fullscreen', init);
		window_height.on('resize', init);
		window_height.on('load', init);
		init();
}
$(document).on("update_content", function() {
	if(!(jQuery(this).hasClass('full-screen-section')) && (!(jQuery(this).hasClass('full-screen-height') ) ) ) {
		window_height.off('scroll.fullscreen', init);
	}
});

} )( jQuery );