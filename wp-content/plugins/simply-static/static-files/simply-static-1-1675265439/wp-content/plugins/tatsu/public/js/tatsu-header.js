
// Custom Side with Fade Animation
function tatsuToggle(speed, easing, callback) {
    return this.animate({opacity: 'toggle', height: 'toggle', padding: 'toggle', margin: 'toggle'}, speed, easing, callback);
}

(function( $ ) {
    'use strict';

    var vendorScriptsUrl = tatsuFrontendConfig.vendorScriptsUrl,
        dependencies = tatsuFrontendConfig.dependencies || {};

    if( 'undefined' != typeof dependencies ) {
		for( var dependency in dependencies ) {
			if( dependencies.hasOwnProperty( dependency ) ) {
				asyncloader.register( dependencies[ dependency ], dependency );
			}
		}
    }    

    var adjustTopSectionPadding = function() {
        if( jQuery('#tatsu-header-wrap').hasClass('header-auto-pad') && !jQuery('body').hasClass('tatsu-frame') ){
            var firstSection = jQuery('#be-content .tatsu-section:first-child .tatsu-section-pad'),
                adjustedPadding = 0,
                responsivePadding,
                desktopPadding,
                laptopPadding,
                tabletPadding,
                mobilePadding,
                headerHeight = parseInt( jQuery('#tatsu-header-wrap').height() ),
                lastHeaderBottomPadding = parseInt( jQuery( '.tatsu-header.default .tatsu-header-row' ).last().css( 'padding-bottom' ) );
            if( firstSection.length > 0 ) {
                try {
                    responsivePadding = JSON.parse( firstSection.attr('data-padding') );
                    } catch(e) {
                    responsivePadding = { 
                        d: firstSection.attr('data-padding') || 0
                    }
                }
                
                desktopPadding = parseInt( responsivePadding.d.split(' ')[0] );
                laptopPadding = responsivePadding.hasOwnProperty('l') ? parseInt( responsivePadding.l.split(' ')[0] ) : desktopPadding;
                tabletPadding = responsivePadding.hasOwnProperty('t') ? parseInt(responsivePadding.t.split(' ')[0] ) : desktopPadding;
                mobilePadding = responsivePadding.hasOwnProperty('m') ? parseInt( responsivePadding.m.split(' ')[0] ) : desktopPadding;
                if( jQuery(window).width() > 1377 ) {
                    adjustedPadding = desktopPadding + headerHeight - lastHeaderBottomPadding;
                } else if( jQuery(window).width() > 1024 && jQuery(window).width() <= 1377 ) {
                    adjustedPadding = laptopPadding + headerHeight - lastHeaderBottomPadding;
                } else if( jQuery(window).width() >= 768 && jQuery(window).width() <= 1024 ) {
                    adjustedPadding = tabletPadding + headerHeight - lastHeaderBottomPadding;
                } else {
                    adjustedPadding = mobilePadding + headerHeight - lastHeaderBottomPadding;
                }
                firstSection.css('padding-top', adjustedPadding);
            }
            $(document.body).addClass( 'tatsu-transparent-header-pad' );
            $(document).trigger( 'tatsu_transparent_header_padding_calc' );            

        }
    },

    addHoverClass = function() {

        if( jQuery('#tatsu-header-wrap').hasClass('transparent') ){
            jQuery(document).on('mouseenter', '.tatsu-menu li', function() {
                jQuery(this).addClass('tatsu-hovered');
                jQuery(this).closest('li.current-menu-parent').addClass('tatsu-hovered');
            });
            jQuery(document).on('mouseleave', '.tatsu-menu li' , function() {
                jQuery(this).removeClass('tatsu-hovered');
                jQuery(this).closest('li.current-menu-parent').removeClass('tatsu-hovered');
            });  
        } 
    };

    var tatsuHeader = (function() {
        var body = $('body'),
            html = $('html'),
            $htmlBody = $( 'html,body' ),
            $win = $(window),
            headerContainer = $('#tatsu-header-container'),
            headerWrap = $('#tatsu-header-wrap'),
            header = $('.tatsu-header'),
            triggerStickyPostion = headerWrap.height(),
            placeholder = $( '#tatsu-header-placeholder' ),
            placeholderHeight = headerWrap.height(),
            isTransparent = headerWrap.hasClass('transparent'),
            pluginUrl = tatsuFrontendConfig.pluginUrl,
            smartSticky = headerWrap.hasClass('smart'),
            sticky = headerWrap.hasClass('sticky'),
            scrollPos = 0,
            headerWrapHeight = headerWrap.height(),
            smartOffset = headerWrap.height() + 200,
            hamburger = $('.tatsu-hamburger'),
            slideMenu = $('.tatsu-slide-menu'),
            overlay = $( '#tatsu-fixed-overlay' ),
            raf,
            tatsuCallbacks = {},  

        stickyHeader = function() {
            
            if( $win.scrollTop() > headerWrap.height() && $win.scrollTop() < smartOffset ) {
                headerWrap.addClass('pre-stuck');
                
            } else if( $win.scrollTop() >= smartOffset ){
                if( smartSticky ) {
                    if( !headerWrap.hasClass('pre-stuck') ) {
                        headerWrap.addClass( 'pre-stuck' );
                    }
                    if( body[0].getBoundingClientRect().top <= scrollPos ) {
                        headerWrap.addClass('hide');//
                    } else {
                        headerWrap.removeClass('hide').addClass('stuck');
                    }
                }else{
                        headerWrap.addClass('stuck');
                    if( !isTransparent ) {
                        placeholder.css( 'height', placeholderHeight );
                    }
                }
            } else if($win.scrollTop() <= headerWrap.height() ){
                if( body[0].getBoundingClientRect().top > scrollPos ){
                    if( !isTransparent ) {
                        placeholder.css( 'height', '0' );
                    }
                    headerWrap.removeClass('stuck').removeClass('pre-stuck');
                }
            }
            scrollPos = body[0].getBoundingClientRect().top;
        },

        getHeaderHeight = function() {
            var height = 0;
            header.each( function() {
                if( $(this).hasClass('default') && $(this).is(':visible') ) {
                    height = height + parseInt( $(this).height() );
                }
            });
            
            return height;
        },

        getSmartOffset = function(){
            return smartOffset;
        },

        getStickyHeaderHeight = function() {
            var height = 0;
            if( $htmlBody.scrollTop() < smartOffset ) {
                var clonedHeader = headerWrap.clone();
                clonedHeader.addClass( 'pre-stuck stuck' ).css({
                    position : 'absolute',
                    left : '-999999px',
                    display : 'block',
                    visibility : 'hidden',
                });
                body.append( clonedHeader );
                height = clonedHeader.height();
                clonedHeader.remove();
                clonedHeader = null;
            }else {
                header.each( function() {
                    var curEle = $(this);
                    if( curEle.hasClass( 'sticky' ) && curEle.is( ':visible' ) ) {
                            height+= curEle.height();
                    }
                } );
            }
            return height;
        },

        setPlaceholderHeight = function() {
            if( headerWrap.hasClass( 'solid' ) && sticky && placeholder.length > 0 ) {
                placeholder.css( 'height', headerWrapHeight );
            }
        },

        slide = function() {
            hamburger.on( 'click', function(){
                var id = $(this).attr('data-slide-menu');
                var menuToSlide = slideMenu.filter( function(){
                    return $(this).attr('id') == id;
                });
                $(this).find('.line-wrapper').addClass('open');
                menuToSlide.toggleClass('open');
                overlay.toggleClass('open');
            });
        },

        closeSlideCallback = function() {
            var menuToClose = slideMenu.filter( function(){
                return $(this).hasClass('open');
            });
            hamburger.find('.line-wrapper').removeClass('open');
            overlay.removeClass('open');
            menuToClose.removeClass('open');
        },

        closeSlide = function() {
            overlay.on( 'click', closeSlideCallback );
        },

        removeMegaMenuClass = function() {
            jQuery('.tatsu-slide-menu li.mega-menu').removeClass('mega-menu');
        },

        setSidebarMenuWidth = function() {

            var sideBarMenu = jQuery('.tatsu-sidebar-menu');

            sideBarMenu.each(function (){
                sideBarMenu.css('width', jQuery(this).closest('.tatsu-slide-menu-col').width());
            });
            
        },

        superfish = function() {
            asyncloader.require( [ 'superfish', 'hoverintent' ], function(){
                
                var $menu = jQuery('.tatsu-header-col .tatsu-header-navigation .tatsu-menu').children('ul');
                $menu.superfish('destroy');
                
                // Remove Instances on Menu within Slide Bar 
                // $menu = $menu.map( function( index, menuInstance ){
                //     if( jQuery(menuInstance).closest('.tatsu-slide-menu').length <= 0 ){
                //         return menuInstance;
                //     }else{
                //         return null;
                //     }
                // });

                $menu.superfish({
                    animation: {top: "50px", opacity: "show"},
                    animationOut: {top: "45px", opacity: "hide"},
                    pathLevels:3,  
                    speed : "fast",
                    delay: 100,
                    disableHI: true,
                    onBeforeShow : function() {
                        
                        if( this.parent('li').hasClass('mega-menu') ){
                            this.css('display', 'flex');
                            this.css('visibility','hidden');
                            this.fadeIn();
                            this.css( 'left', '' ); 
                            
                            var subMenu = this,
                                windowWidth = jQuery(window).width(),
                                subMenuWidth = subMenu.outerWidth() ,
                                parentMenu = subMenu.parent('li'),
                                parentMenuWidth = parentMenu.width(),
                                subMenuPosition = subMenu.offset().left,
                                subMenuArrow = subMenu.find('.tatsu-header-pointer'),
                                centeredSubmenuPosition = subMenuPosition + (parentMenuWidth/2) - (subMenuWidth/2),
                                parentPosition = this.parent('li').offset().left;
                            if( 0 > centeredSubmenuPosition || ( centeredSubmenuPosition + subMenuWidth ) > windowWidth ) {
                                var correctedPosition = subMenuWidth - ( windowWidth - 30 - subMenuPosition )
                                subMenu.css( 'left', - correctedPosition );
                                subMenuArrow.css( 'left', correctedPosition + 20 );
                            }else {
                                subMenuArrow.css( 'left', (subMenuWidth/2) - (subMenuArrow.width()/2) );
                                subMenu.css( 'left', (parentMenuWidth/2) - (subMenuWidth/2));
                            }
                            this.css('visibility','visible');
                            this.fadeOut();
                        }
                        else{
                            var subMenuDepth = this.parents('ul').length ,
                            currentMenuItem = this.closest('li.menu-item-has-children'),
                            subMenuWidth = this.innerWidth(),
                            subMenuPositionCheck = subMenuDepth * subMenuWidth,
                            positionOffset = ( jQuery(this).innerWidth() - jQuery(this).width() ) / 2 , 
                            subMenuPosition = subMenuWidth -  positionOffset + 5;

                            if ( subMenuDepth > 1 ){                                
                                if( ( jQuery(window).width() - this.closest('li.menu-item-has-children').offset().left ) < subMenuPositionCheck ){
                                    currentMenuItem.find('ul.tatsu-sub-menu').css( 'right', subMenuPosition ).css( 'left', 'auto' ).css('top', 0);
                                }else{
                                    currentMenuItem.find('ul.tatsu-sub-menu').css( 'left', subMenuPosition ).css( 'right', 'auto' ).css('top', 0);
                                }
                            }
                        }
                        this.siblings('.sub-menu-indicator').addClass('menu-open');
                    },
                    onBeforeHide : function() {
                        this.siblings('.sub-menu-indicator').removeClass('menu-open');
                    }
                });
            });		    	
        },

        tatsuSideBarMenu = function() {
            removeMegaMenuClass();
            setSidebarMenuWidth();
        },

        closeMobileMenu = function() {
            jQuery('.tatsu-mobile-menu-icon').find('.line-wrapper').removeClass('open');
            jQuery('.tatsu-mobile-menu').animate({opacity: 'hide', height: 'hide', padding: 'hide', margin: 'hide'}, 200, 'linear', '');
        },

        tatsu_mobile_menu = function() {
            jQuery(document).on('click', '.tatsu-mobile-navigation .tatsu-mobile-menu-icon', function () {
                jQuery(this).find('.line-wrapper').toggleClass('open');
                jQuery(this).siblings('.tatsu-mobile-menu').animate({opacity: 'toggle', height: 'toggle', padding: 'toggle', margin: 'toggle'}, 200, 'linear', '');
            });
            jQuery(document).on('click', '.tatsu-mobile-menu .sub-menu-indicator, .tatsu-slide-menu-col .sub-menu-indicator' , function() {
                jQuery(this).toggleClass('menu-open');
                jQuery(this).siblings('.tatsu-sub-menu').animate({opacity: 'toggle', height: 'toggle', padding: 'toggle', margin: 'toggle'}, 200, 'linear', '');
            });
            jQuery(document).on('click', '.tatsu-mobile-menu li.menu-item-has-children a, .tatsu-slide-menu-col li.menu-item-has-children a' , function() {
                var attr = jQuery(this).attr('href');
                if(typeof attr === 'undefined' || attr === false || attr == '#') {
                    jQuery(this).toggleClass('menu-open');     
                    jQuery(this).siblings('.tatsu-sub-menu').animate({opacity: 'toggle', height: 'toggle', padding: 'toggle', margin: 'toggle'}, 200, 'linear', '');
                }
            });
            //Close mobile menu in single page site e.g. v31
            jQuery(document).on('click','.tatsu-mobile-menu li.menu-item-type-custom a' , function() {
                if( jQuery(this).attr('href') != '#' && !jQuery(this).closest('li').hasClass('menu-item-has-children') ){ 
                    closeMobileMenu();  
                }
            });
        },

        megaMenu = function () {
            if( jQuery( '.tatsu-header-navigation-mega-menu' ).length ) {
                jQuery( '.tatsu-header-navigation-mega-menu > .tatsu-menu > ul > .menu-item-has-children' ).addClass( 'mega-menu' );
            }
        },

        mobile_menu_maxheight = function() {
            var $mobile_menu = jQuery('.tatsu-mobile-menu'),
                $max_height = window.innerHeight - jQuery('#wpadminbar').height() - jQuery('#tatsu-header-wrap').height() ;
            jQuery('.tatsu-mobile-menu').css( 'max-height', $max_height );
        },

        tatsu_search = function() {
            jQuery(document).on( 'click', '.tatsu-search svg', function() {
                var iconPostion = jQuery(this).offset().left,
                    windowMedian = jQuery(window).width() / 2,
                    searchBar = jQuery(this).siblings( '.search-bar' ),
                    searchBox =  jQuery(this).closest( '.tatsu-search' );
                if( iconPostion <  windowMedian ){
                    searchBar.css( 'left' , -20 );
                    searchBar.find( '.tatsu-header-pointer' ).css( 'left' , 20 );
                }else{
                    searchBar.css( 'right' , -20 );
                    searchBar.find( '.tatsu-header-pointer' ).css( 'right' , 20 );
                }
                searchBox.toggleClass('search-open');
                if( searchBox.hasClass( 'search-open' ) ) {
                    setTimeout(function(){
                        searchBar.find( 'input' ).focus();
                    }, 100 );
                }
                
            });
        },

        tatsu_close_popups = function() {
            var searchBar = jQuery('.tatsu-search'),
                languageSelector = jQuery( '.tatsu-wpml-lang-switcher' );
            jQuery(document).on('click', function (e) {
                var target = jQuery(e.target);
                if( !target.closest( '.tatsu-search' ).length && searchBar.hasClass('search-open') ){
                    searchBar.removeClass('search-open');
                }else if( !target.closest( '.tatsu-wpml-lang-switcher' ).length && languageSelector.hasClass( 'language-switcher-open' ) ) {
                    languageSelector.removeClass( 'language-switcher-open' );
                }
            })
        },

        tatsu_language_switcher = function() {
            jQuery(document).on( 'click', '.tatsu-wpml-lang-switcher', function(e) {
                e.stopPropagation();
                jQuery(this).toggleClass('language-switcher-open');
            });
        },    

        tatsuHorizontalMenuCb = function() {
            superfish();
            megaMenu();
        },

        registerCallbacks = function() {
            tatsuCallbacks[ 'tatsu_sidebar_navigation_menu' ] = tatsuSideBarMenu;
            tatsuCallbacks[ 'tatsu_navigation_menu' ] = tatsuHorizontalMenuCb;
            tatsuCallbacks[ 'tatsu_wpml_language_switcher' ] = tatsu_language_switcher;
        },

        singlePageSiteMenuUpdate = (function() {
            var mainMenuItems = jQuery('li.menu-item'),
                $header = $('#tatsu-header-wrap'),
                tatsuSection = $('.tatsu-section'),
                normalHeaderHeight = getHeaderHeight(), 
                stickyHeaderHeight = getStickyHeaderHeight(),  
                headerSmartOffset = getSmartOffset(),  
                sectionCount = tatsuSection.length,
                prevScrollTop = 0;
            return function() {
                    var scrollOffset = 0,
                        curScrollTop =  Math.max(window.pageYOffset, document.documentElement.scrollTop, document.body.scrollTop), //jQuery('body,html').scrollTop(),
                        curScrollTopWithOffset,
                        curSection,
                        curSectionStart,
                        curSectionEnd,
                        curSectionId;
                    mainMenuItems.removeClass( 'current-menu-item' );
                    if( body.hasClass( 'admin-bar' ) ) {
                        scrollOffset += 32;
                    }
                    if( $header.length > 0 ) {
                        if( $header.hasClass( 'solid' ) && curScrollTop < headerSmartOffset ) {
                            scrollOffset += normalHeaderHeight;
                        }
                        if( $header.hasClass( 'sticky' ) && curScrollTop > headerSmartOffset ) {
                            if( ( !$header.hasClass( 'smart' ) || curScrollTop < prevScrollTop ) ) {
                                scrollOffset += stickyHeaderHeight;
                            }
                        }
                    }
                    curScrollTopWithOffset = curScrollTop + scrollOffset;
                    for( var index = 0; index < sectionCount; index++ ) {
                        curSection = tatsuSection.eq(index);
                        curSectionStart = curSection.offset().top;
                        curSectionEnd = curSectionStart + curSection.outerHeight();
                        curSectionId = curSection.attr('id');
                        if( curSection.is(':visible' ) && ( curScrollTopWithOffset >= curSectionStart && curScrollTopWithOffset < curSectionEnd ) && null != curSectionId ) {
                            console.log( 'inside section' );
                            mainMenuItems.find('a[href$="#'+ curSectionId +'"]').closest('li.menu-item').addClass('current-menu-item');
                        }
                    }
                    prevScrollTop = curScrollTop;
            }
        })(),

        ready = function(){

            adjustTopSectionPadding();
            addHoverClass();
            if( body.hasClass( 'tatsu-header-single-page-site' ) ) {
                singlePageSiteMenuUpdate();
            }
            megaMenu();
            slide();
            closeSlide();    
            superfish();   
            tatsuSideBarMenu();
            tatsu_mobile_menu();
            mobile_menu_maxheight();
            tatsu_search();
            tatsu_language_switcher();
            tatsu_close_popups();
            registerCallbacks();

            jQuery(window).on( 'tatsu_update.tatsu', function( e, data )  {
                if( data.moduleName in tatsuCallbacks ) {
                    tatsuCallbacks[data.moduleName]( data.shouldUpdate, data.moduleId );                                         
                } 
            });

            jQuery(window).resize(function(){
                adjustTopSectionPadding();
                mobile_menu_maxheight();
            });

            if( sticky ) {
                $(window).on( 'scroll.tatsuStickyHeader', function() {
                    stickyHeader();
                });
            }
            if( body.hasClass( 'tatsu-header-single-page-site' ) ) {
                $(window).on( 'scroll', function(){
                    singlePageSiteMenuUpdate();
                });
            }
        }        
        
        return {
            ready: ready,
            getStickyHeaderHeight : getStickyHeaderHeight,
            getHeaderHeight : getHeaderHeight,
            getSmartOffset : getSmartOffset,
            closeSlide : closeSlideCallback,
            closeMobileMenu : closeMobileMenu
        }

    })(); 

    window.tatsuHeader = tatsuHeader;
    $( tatsuHeader.ready );

})( jQuery );