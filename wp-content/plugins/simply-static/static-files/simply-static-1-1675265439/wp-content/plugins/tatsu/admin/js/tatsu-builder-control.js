jQuery(document).ready(function(){
    if(tatsuBuilderConfig.be_theme_name=='spyro'||tatsuBuilderConfig.is_tatsu_authorized){
        //REMOVE SPYRO FORM MODULE IN PAGE 
        if(jQuery('body').hasClass("tatsu-page-builder")){
            jQuery(document).on('input','.be-pb-module-search-input',function(){
                if(jQuery('body').hasClass("single-tatsu_forms")){
                    jQuery(document).find('.be-pb-module-list-area').find('.be-pb-Tatsu.Forms-card').parent('.be-pb-modulelist-card').remove();
                }else{
                    jQuery(document).find('.be-pb-module-list-area').find('.be-pb-Spyro.Form-card').parent('.be-pb-modulelist-card').remove();
                }
            });
        }

        //SPYRO FORM IN TATSU FORMS BUILDER
        if(jQuery('body').hasClass("tatsu-page-builder") && jQuery('body').hasClass("single-tatsu_forms")){
            jQuery('#tatsu-preview').load(function(){
                var iframe = jQuery('#tatsu-preview').contents();
                setTimeout(function(){
                    //remove header, footer, add section, drag section icons 
                    var style_tag = '<style>#tatsu-selection-tooltip, .be-pb-section-adder, .exp-post-single-header-wrap, .tatsu-add-tools-helper, .tatsu-add-tools-icon-wrapper,.tatsu-add-tools-helper,.exp-post-single-footer, .exp-post-single .exp-posts-nav{display: none;}</style>';
                    iframe.find('head').append(style_tag);
                    // iframe.find('.exp-post-single-header-wrap').first().remove();
                    // iframe.find('.tatsu-add-tools-helper').remove();
                    // iframe.find('.exp-post-single-footer').first().remove();
                    //Disable Add New section
                    jQuery(document).find('.be-pb-section-adder').css('pointer-events','none');
                    
                    
                    //select spyro form module
                    var forms = iframe.find(".spyro-form").length;
                    var tatsu_empty_col = iframe.find(".tatsu-empty-col");
                    if (typeof forms !=='undefined' && forms){
                        //alert("already have form");
                    } else if(typeof tatsu_empty_col !=='undefined'){
                        //Auto select spyro form
                        tatsu_empty_col.click();
                        setTimeout(function(){ 
                            var spyro_module = jQuery(document).find('.be-pb-module-list-area').find('.be-pb-Spyro.Form-card').parent('.be-pb-modulelist-card');
                            spyro_module.trigger('click');
                        },500);
                    }
                },350);

                iframe.on('click',".tatsu-empty-col",function(){
                    var forms = iframe.find(".spyro-form").length;
                    if (typeof forms !=='undefined' && forms){
                        alert("You have already added a form.");
                    } else {
                        setTimeout(function(){ 
                            var spyro_module = jQuery(document).find('.be-pb-module-list-area').find('.be-pb-Spyro.Form-card').parent('.be-pb-modulelist-card');
                            spyro_module.trigger('click');
                        },500);
                    }
                });

                jQuery(document).on('click','.be-pb-leftPanel-tab-link',function(){
                    setTimeout(function(){ 
                        //Disable Add New section
                        jQuery(document).find('.be-pb-section-adder').css('pointer-events','none');
                    },100);
                })
                
                
            });
        }
    }

    // if(jQuery('body').hasClass("tatsu-page-builder")){
    //     jQuery(document).find('#root').append(`<div id="tatsu_builder_preview_modal" class="display_none">
    //     <img class="preview_image" alt="Module Preview">
    //     <div class="modal-container">
    //       <div class="left-icon"><svg class="tatsu-svg-icon" ></svg></div>
    //       <div class="right-content">
    //         <div class="title-wrap"> 
    //         <h3 class="title"></h3>
    //         <span class="pro_icon"></span>
    //         </div>
    //         <p class="description"></p> 
    //       </div>
    //     </div>
    //   </div>`);
    //   var preview_modal = jQuery(document).find('#root #tatsu_builder_preview_modal');
    //     jQuery(document).on('mouseenter','.be-pb-modulelist-card',function(){
    //       var card_title = jQuery(this).find('.be-pb-modulelist-card-title').text();
    //       if(typeof card_title !== 'undefined' && card_title!= null){
    //         card_title = card_title.trim();
    //         console.log('card_title',card_title);
    //         console.log('card_title tatsuBuilderConfig',tatsuBuilderConfig.module_preview[card_title]);
    //         if(preview_modal.length){
    //             preview_modal.find('.preview_image').attr('src',tatsuBuilderConfig.module_preview[card_title]['preview_image']);
    //             preview_modal.find('.left-icon .tatsu-svg-icon').html('<use xlink:href="'+tatsuBuilderConfig.module_preview[card_title]['icon']+'" ></use>');
                
    //             preview_modal.find('.description').text(tatsuBuilderConfig.module_preview[card_title]['description']);
    //             if(tatsuBuilderConfig.module_preview[card_title]['is_tatsu_pro']=='1'){
    //                 preview_modal.find('.right-content .pro_icon').html('<img alt="PRO" src="'+tatsuBuilderConfig.pro_icon+'" class="tatsu-pro-icon" />');
    //             }else{
    //                 preview_modal.find('.right-content .pro_icon').html('');
    //             }
    //             preview_modal.find('.right-content .title').text(card_title.replace("PRO",""));
    //             preview_modal.removeClass('display_none');
    //         }
    //       }
    //     });
    //     jQuery(document).on('mouseleave click','.be-pb-modulelist-card',function(){
    //         if(preview_modal.length && !preview_modal.hasClass('display_none')){
    //             preview_modal.addClass('display_none');
    //         }
    //     });
    // }

});