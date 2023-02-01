(function(){

    // basename function like php basename
    function basename( path, suffix ){
        path = path || '';
        var b = path,
            lastChar = b.charAt(b.length - 1);
        if (lastChar === '/' || lastChar === '\\') {
        b = b.slice(0, -1);
        }
        b = b.replace(/^.*[/\\]/g, '')
        if (typeof suffix === 'string' && b.substr(b.length - suffix.length) === suffix) {
        b = b.substr(0, b.length - suffix.length)
        }
        return b
    }

    var previousHeaderStyle = basename( jQuery('#be_themes_data-opt-header-style select.redux-select-images').val(), '.png' ),
        optHeaderStyle = basename( jQuery( 'select[data-id="opt-header-style"]' )[0].value , '.png' ),
        topMenuHoverStyleTailLeft = jQuery( '#be_themes_data-top_menu_hover_style' ).find( 'option[value="tail-left"]' ),
        optHeaderType = jQuery( '#opt-header-type-select' ).val(),
        topMenuHoverStyle = jQuery( '#top_menu_hover_style-select' ),
        topMenuHoverStyleOptions = jQuery( '#top_menu_hover_style-select' ).children(),
        layout = jQuery( '#be_themes_data-layout' ).closest('tr'),
        borderSettingsStartSection = jQuery( '#section-border-settings-start' ),
        borderSettingsStartTable = jQuery( '#section-table-border-settings-start' );

    if( optHeaderType == 'left' ){
        // Hide the top header panel settings
        jQuery( '.top-header-settings' ).eq(0).animate({opacity: 'toggle', height: 'toggle', padding: 'toggle', margin: 'toggle'},1);
    } else if( optHeaderType == 'top' ){
        // Hide the left header panel settings
        jQuery( '.left-header-settings' ).eq(0).animate({opacity: 'toggle', height: 'toggle', padding: 'toggle', margin: 'toggle'},1);
         // Show or hide the layout options based on header type and whether its new header style
        if( optHeaderStyle == 'style1' || optHeaderStyle == 'style2' || optHeaderStyle == 'style3' || optHeaderStyle == 'style4' || optHeaderStyle == 'style5' || optHeaderStyle == 'style6' || optHeaderStyle == 'style13' ){
            layout.css( 'display', 'table-row' );
            borderSettingsStartSection.css( 'display', 'block' );
            borderSettingsStartTable.css( 'display', 'block' );
        } else {
            layout.css( 'display', 'none' );
            borderSettingsStartSection.css( 'display', 'none' );
            borderSettingsStartTable.css( 'display', 'none' );
        }
    } else if( optHeaderType == 'builder' ){
         // Hide the top header panel settings
         jQuery( '.top-header-settings' ).eq(0).animate({opacity: 'toggle', height: 'toggle', padding: 'toggle', margin: 'toggle'},1);
         // Hide the left header panel settings
        jQuery( '.left-header-settings' ).eq(0).animate({opacity: 'toggle', height: 'toggle', padding: 'toggle', margin: 'toggle'},1);
    }
    
    if( 'style7' != optHeaderStyle ){
        // Allow animated falling menu only for style 7
        jQuery( '#be_themes_data-opt-menu-style' ).find( "input[value$='menu-animate-fall.jpg']" ).closest('li').css('display', 'none');        
    }
    
    // Dont allow tail-left menu animation style for old header styles    
    if( 'style1' == optHeaderStyle || 'style2' == optHeaderStyle || 'style3' == optHeaderStyle || 'style4' == optHeaderStyle || 'style5' == optHeaderStyle || 'style6' == optHeaderStyle || 'style13' == optHeaderStyle ){
        var default_params = {
                            width: 'resolve',
                            triggerChange: true,
                            allowClear: true
                        };
        topMenuHoverStyle.children().remove('[value="tail-left"]');
        topMenuHoverStyle.select2('destroy').select2( default_params );
    }

    //On selection change of opt-header-type show the layout options if its left header and top header with old header styles else hide in case its top header with new header style 
    jQuery( '#opt-header-type-select' ).on('change', function(e){
        var layout = jQuery( '#be_themes_data-layout' ).closest('tr'),
            borderSettingsStartSection = jQuery( '#section-border-settings-start' ),
            borderSettingsStartTable = jQuery( '#section-table-border-settings-start' );
        if(e.val == 'left'){
            // Toggle the header pannel visibility
            jQuery( '.top-header-settings' ).eq(0).animate({opacity: 0, height: 0, padding: 'toggle', margin: 'toggle'}).css('display','none');
            jQuery( '.left-header-settings' ).eq(0).animate({opacity: 1, height: '39px', padding: 'toggle', margin: 'toggle'}).css('display','block');

            layout.css('display', 'table-row');
            borderSettingsStartSection.css( 'display', 'block' );
            borderSettingsStartTable.css( 'display', 'block' );
        } else if( e.val == 'top' ){
            // Toggle the header pannel visibility
            jQuery( '.left-header-settings' ).eq(0).animate({opacity: 0, height: 0, padding: 'toggle', margin: 'toggle'}).css('display','none');
            jQuery( '.top-header-settings' ).eq(0).animate({opacity: 1, height: '57px', padding: 'toggle', margin: 'toggle'}).css('display','block');
            
            var optHeaderStyle = basename( jQuery( 'select[data-id="opt-header-style"]' )[0].value , '.png' );
            if( optHeaderStyle == 'style1' || optHeaderStyle == 'style2' || optHeaderStyle == 'style3' || optHeaderStyle == 'style4' || optHeaderStyle == 'style5' || optHeaderStyle == 'style6' || optHeaderStyle == 'style13' ){
                layout.css( 'display', 'table-row' );
                borderSettingsStartSection.css( 'display', 'block' );
                borderSettingsStartTable.css( 'display', 'block' );
            } else {
                layout.css( 'display', 'none' );
                borderSettingsStartSection.css( 'display', 'none' );
                borderSettingsStartTable.css( 'display', 'none' );
            }
        } else if( e.val == 'builder' ){
            // Hide the top header panel settings
            jQuery( '.top-header-settings' ).eq(0).animate({opacity: 0, height: 0, padding: 'toggle', margin: 'toggle'}).css('display','none');
            // Hide the left header panel settings
           jQuery( '.left-header-settings' ).eq(0).animate({opacity: 0, height: 0, padding: 'toggle', margin: 'toggle'}).css('display','none');
       }
    });

    jQuery( 'select[data-id="opt-header-style"]' ).on('change', function(e){
        var optHeaderStyle = basename( e.val, '.png' ),
            optHeaderType = jQuery( '#opt-header-type-select' ).val(),
            optMenuStyle = jQuery( '#be_themes_data-opt-menu-style' ).find( "input[checked='checked']" ),
            optMenuStyleName = basename( optMenuStyle.val(), '.jpg' ),
            topMenuHoverStyleSelection = jQuery( '#top_menu_hover_style-select' ).val(),
            layout = jQuery( '#be_themes_data-layout' ).closest('tr'),
            borderSettingsStartSection = jQuery( '#section-border-settings-start' ),
            borderSettingsStartTable = jQuery( '#section-table-border-settings-start' );

        //On selection change of opt-header-type show the layout options if its left header and top header with old header styles else hide in case its top header with new header style 
        if( optHeaderType == 'left' ){
            layout.css('display', 'table-row');
            borderSettingsStartSection.css( 'display', 'block' );
            borderSettingsStartTable.css( 'display', 'block' );
        } else if( optHeaderType == 'top' ){
            if( optHeaderStyle == 'style1' || optHeaderStyle == 'style2' || optHeaderStyle == 'style3' || optHeaderStyle == 'style4' || optHeaderStyle == 'style5' || optHeaderStyle == 'style6' || optHeaderStyle == 'style13' ){
                layout.css( 'display', 'table-row' );
                borderSettingsStartSection.css( 'display', 'block' );
                borderSettingsStartTable.css( 'display', 'block' );
            } else {
                layout.css( 'display', 'none' );
                borderSettingsStartSection.css( 'display', 'none' );
                borderSettingsStartTable.css( 'display', 'none' );
            }
        }

        // Don't allow menu-animate-fall for new styles except style7
        if( 'style7' == previousHeaderStyle && 'menu-animate-fall' == optMenuStyleName ){
            optMenuStyle.attr( 'checked', null );
            optMenuStyle.closest('label').removeClass( 'redux-image-select-selected' );
            optMenuStyle.closest( 'li' ).css( 'display', 'none' );

            var newMenuStyle = jQuery('#be_themes_data-opt-menu-style #opt-menu-style_2');
            newMenuStyle = ( newMenuStyle == optMenuStyle ) ? jQuery( '#be_themes_data-opt-menu-style #opt-menu-style_3' ) : newMenuStyle;
            newMenuStyle.attr( 'checked', 'checked' );
            newMenuStyle.closest('label').addClass( 'redux-image-select-selected' );
        }

        if( 'style7' == optHeaderStyle ){
            jQuery( '#be_themes_data-opt-menu-style' ).find( "input[value$='menu-animate-fall.jpg']" ).closest('li').css('display', 'inline-block');
        } else {
            jQuery( '#be_themes_data-opt-menu-style' ).find( "input[value$='menu-animate-fall.jpg']" ).closest('li').css('display', 'none');
        }

        var default_params = {
                            width: 'resolve',
                            triggerChange: true,
                            allowClear: true
                        };

        // Dont allow tail-left menu animation style for old header styles
        if( 'style1' == optHeaderStyle || 'style2' == optHeaderStyle || 'style3' == optHeaderStyle || 'style4' == optHeaderStyle || 'style5' == optHeaderStyle || 'style6' == optHeaderStyle || 'style13' == optHeaderStyle ){
            if( 'tail-left' == topMenuHoverStyle.val() ){  
                topMenuHoverStyle.children().eq(1).attr( 'selected', 'selected' );
                topMenuHoverStyle.children().remove('[value="tail-left"]');
                topMenuHoverStyle.select2('destroy').select2( default_params );
            } else if( topMenuHoverStyle.find( 'option[value="tail-left"]' ).length > 0 ) {
                topMenuHoverStyle.children().remove('[value="tail-left"]');
            }
        } else {
            // Go back to all the options by appending it.
            topMenuHoverStyle.append( topMenuHoverStyleOptions );
            // Reset the selection to already selected value before the change event got fired, so that select2 maintains it properly
            topMenuHoverStyle.val( topMenuHoverStyleSelection );          
        }
        // keep in closure the selected header style as previousHeaderStyle
        previousHeaderStyle = optHeaderStyle;

    })
    
})();

jQuery(document).ready( function() {
    var counter = 0;
    var removeReduxAds = setInterval( function(){
        counter++;
        if( jQuery('.rAds').length > 0 || counter >= 100 ) {
            jQuery('.rAds').remove();
            clearInterval( removeReduxAds );
        }
        console.log(counter);
    }, 200 );
    var previousHeaderType,
        previousFooterType;
    window.previousHeaderType = jQuery('#be_themes_data-opt-header-type select.redux-select-item').val();    
    window.previousFooterStatus = jQuery('#be_themes_data-enable_footer_builder input[name="be_themes_data[enable_footer_builder]"]').val();
});