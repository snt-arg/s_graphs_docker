/*!
 * sticky sections 
 * v0.1
 * https://bitbucket.org/ram_brandexponents/snapped-sections
 * @license MIT licensed
 * 
 * Copyright (C) 20l18 - A project by Ram Subramanian
 */
(function( root, window, document, factory, undefined ) {
    if ( 'function' == typeof define  && define.amd) {
        define( function($) {
          return factory( window, document, undefined );
        } );
    } else if ( 'object' == typeof exports) {
        module.exports = factory( window, document, undefined );
    } else {
        window.stickySections = factory( window, document, undefined );
    }
})( this, window, document, function( window, document, undefined ) {

    //keeping centeral set of classnames and its corresponding selectors
    var stickyWrapper = 'sticky-sections-wrap',
        enabled = 'sticky-enabled',
        active = 'sticky-current-active',
        dotsNavigation = 'sticky-dots-navigation',
        dotsNavigationSelector = '#' + dotsNavigation,
        activeDot = 'sticky-dot-active',
        singleDot = 'sticky-nav-dot',
        singleDotSelector = '.' + singleDot,
        noTransition = 'sticky-disable-animation',
        overflowSection = 'sticky-overflow',
        overlay = 'sticky-overlay',
        section = 'sticky-section',
        sectionSelector = '.' + section;

    //globals
    var options,
        windowHeight = getWindowHeight(),
        debouncedResize = null,
        canScroll = true,
        scrollings = [],
        breakpointConfig = {
            d : 1377,
            l : 1025,
            t : 968,
            m : 0
        },
        stickyObj = {
            active : null,
            breakpoint : 'd',
            scrollRange : null,
            sections : null,
        },
        overlayEle = null,
        scrollingRange,
        prevTime = Date.now(),
        footerParent = null,
        footerHeight = 0,        
        scrollTimeout = null,
        didScroll = false,
        container,
        footerVisible = false,
        fullScreenHeight = windowHeight,
        body = __get( 'body' );
    function initialize( element, customOptions, callback ) {
        var defaultOptions = {
            autoScroll : true,
            navigationPosition : 'right',
            fixedParent : null,
            navigationColor : '',
            overlay : false,
            scrollCallback : null,
            fullScreenOffset : null,
            footer : '',
            scrollingSpeed : 3000,
            easingcss3 : 'ease',
            activeIndex : -1,
            afterLoad : null,
            dots : false
        };
        options = extend( defaultOptions, customOptions );
        container = __get( element );
        if( isElement( container ) ) {
            setUp( callback );
        }else {
            triggerError( 'You need a valid HTML element to initialize sticky sections', 'error' );
        }
    }

    function setUp( callback ) {
        setBreakpoint();
        setStickySections();
        setFullScreenHeight();
        prepareDOM();
        addMouseWheelHandler();
        addResizeHandler();
        addScrollHandler();
        setActive();
        newSectionLoaded( stickyObj.active );
        addClass( body, enabled );
        if( isFunction( callback ) ) { 
            callback.call( container, stickyObj.active, getActiveIndex() );
        }
    }

    function setBreakpoint() {
        var curBreakpoint = getBreakpoint();
        stickyObj.breakpoint = curBreakpoint;
    }

    function getBreakpoint() {
        var curBreakpoint = null;
        for( var breakpoint in breakpointConfig ) {
            if( breakpointConfig[ breakpoint ] <= getWindowWidth() ) {
                if( null == curBreakpoint ) {
                    curBreakpoint = breakpoint;
                }else if( breakpointConfig[ breakpoint ] > breakpointConfig[ curBreakpoint ] ) {
                    curBreakpoint = breakpoint;
                }
            }
        }
        return null != curBreakpoint ? curBreakpoint : 'd';
    }

    function getBannedClassBasedOnBreakpoint() {
        var curBreakpoint = stickyObj.breakpoint,
            bannedClass = '';
        switch( curBreakpoint ) {
            case 'l' :
                bannedClass = 'tatsu-hide-laptop';
                break;
            case 't' :
                bannedClass = 'tatsu-hide-tablet';
                break;
            case 'm' :
                bannedClass = 'tatsu-hide-mobile';
                break;
            default :
                bannedClass = 'tatsu-hide-desktop';
                break;    
        }
        return bannedClass;
    }

    function setStickySections() {
        var possibleStickySections = container.children,
            stickySections = null,
            bannedClass = '';
        bannedClass = getBannedClassBasedOnBreakpoint();
        stickySections = [].filter.call( possibleStickySections, function( section ) {
            return hasClass( section, 'tatsu-section' ) && !hasClass( section, bannedClass );  
        } );
        stickyObj.sections = stickySections;
        addClass( stickySections, section );
    }

    function updateStickySections() {
        var possibleStickySections = container.children,
            curStickySections = stickyObj.sections,
            newStickySections = null,
            nonStickySections = null,
            bannedClass = '';
        bannedClass = getBannedClassBasedOnBreakpoint();
        newStickySections = [].filter.call( possibleStickySections, function( section ) {
            return hasClass( section, 'tatsu-section' ) && !hasClass( section, bannedClass );  
        } );
        nonStickySections = [].filter.call( possibleStickySections, function( section ) {
            return -1 == newStickySections.indexOf( section );
        } );
        if( 0 < nonStickySections.length ) {
            removeClass( nonStickySections, [section, active, noTransition] );
            resetCss( nonStickySections, [ 'height', 'transform', 'transition' ] );
        }
        stickyObj.sections = newStickySections;
        if( null != curStickySections && null != newStickySections ) {
            if( !equalArray( curStickySections, newStickySections ) ) {
                updateActive( newStickySections[ newStickySections.length - 1 ] );
                updateDots();
            }
        }
        addClass( newStickySections, section );
    }

    function addFooter() {
        if( '' != options.footer ) {
            var selectorArray = options.footer,
                wrapper = document.createElement( 'div' );
            wrapper.setAttribute( 'class', 'sticky-footer-wrap' );
            selectorArray.forEach( function( selector ) {
                var elements = __getAll( selector );
                if( null != elements ) {
                    [].forEach.call( elements, function(element){
                        footerParent = element.parentElement;
                        footerParent.removeChild( element );
                        wrapper.appendChild( element );
                    });
                }

            } );
            if( 0 < wrapper.children.length ) {
                if( null != overlayEle ) {
                    addAdjacentSibling( overlayEle, wrapper, 'beforebegin' );
                }else {
                    container.appendChild( wrapper );
                }
                setFooterHeight();
            }
        }
    }

    function removeFooter() {
        if( '' != options.footer ) {
            var fixedFooter = __get( '.sticky-footer-wrap' );
            if( null != fixedFooter ) {
                fixedFooter.parentElement.removeChild( fixedFooter );
                if( 0 < fixedFooter.children.length ) {
                    footerParent.appendChild( fixedFooter.children[0] );
                    if( 0 < fixedFooter.children.length ) {
                        footerParent.appendChild( fixedFooter.children[0] );                            
                    }
                }
                footerHeight = 0;
            }
        }
    }

    function setFooterHeight() {
        var footerEle = __get( '.sticky-footer-wrap' );
        if( null != footerEle ) {
            footerHeight = footerEle.offsetHeight;
        }
    }

    function setActive() {
        var stickySections = stickyObj.sections,
            activeSection = null;
        if( null != stickySections && 0 < stickySections.length ) {
            activeSection = stickySections[0];
        updateActive( activeSection, 'down' );
        if( hasClass( stickyObj.active, overflowSection ) ) {
            enableScrollCallback( true );
        }
    }
    }

    function silentMoveTo( targetIndex ) {
        if( targetIndex != getActiveIndex() ) {
            moveTo( targetIndex, true );
        }
    }

    //https://gist.github.com/andjosh/6764939
    function animateScrollTo( element, to, duration ) {
        var start = element.scrollTop,
            change = to - start,
            currentTime = 0,
            increment = 20,
            easeInOutQuad = function(t, b, c, d) {
                t /= d/2;
                if (t < 1) {
                    return c/2*t*t + b;
                }
                t--;
                return -c/2 * (t*(t-2) - 1) + b;                
            },
            animateScroll = function(){        
                currentTime += increment;
                var val = easeInOutQuad(currentTime, start, change, duration);
                element.scrollTop = val;
                if(currentTime < duration) {
                    setTimeout(animateScroll, increment);
                }
            };
        animateScroll();
    }

    function moveTo( targetIndex, disableAnimation ) {
        var sourceIndex = getActiveIndex(),
            normalizedScrollingSpeed = null != disableAnimation ? 0 : options.scrollingSpeed/( Math.abs( targetIndex - sourceIndex ) ),
            node = stickyObj.active,
            loopCount = 0;
        if( 0 <= targetIndex && targetIndex < ( stickyObj.sections.length ) && sourceIndex != targetIndex ) {
            if( options.autoScroll && canScroll ) {
                canScroll = false;
                while( sourceIndex != targetIndex ) {
                    setTimeout( function( sIndex ) {
                        if( targetIndex < sIndex ) {
                            if( hasClass( stickyObj.active, overflowSection ) || footerVisible ) {
                                transformSection( node, 0, null == disableAnimation ? true : false );
                                if( footerVisible ) {
                                    footerVisible = false;
                                }
                            }
                            node = stickyObj.sections[ getNodeIndex(node) - 1];
                            if( targetIndex == sIndex - 1 ) {
                                updateActive( node, 'up' );
                                setTimeout( function() {
                                    transformSection( node, 0, null == disableAnimation ? true : false );
                                    setTimeout( function() {
                                        newSectionLoaded( stickyObj.active );
                                        if( hasClass( stickyObj.active, overflowSection ) ) {
                                            enableScrollCallback( true );
                                        }else if( null != scrollTimeout ) {
                                            enableScrollCallback( false );
                                        }
                                    }, null == disableAnimation ? options.scrollingSpeed : 0 );
                                }, 50 );
                            }else{                                
                                transformSection( node, 0, null == disableAnimation ? true : false );
                            }
                        }else {
                            transformSection( node, -1 * getOffsetOrScreenHeight( node ), null == disableAnimation ? true : false );
                            node = stickyObj.sections[ getNodeIndex(node) + 1];
                            if( targetIndex == sIndex + 1 ) {
                                setTimeout( function() {
                                    updateActive( node, 'down' );
                                    newSectionLoaded( stickyObj.active );
                                    if( hasClass( stickyObj.active, overflowSection ) ) {
                                        enableScrollCallback( true );
                                    }else if( null != scrollTimeout ) {
                                        enableScrollCallback( false );
                                    }
                                }, null == disableAnimation ? options.scrollingSpeed : 0 );
                            }
                        }
                    }.bind( null, sourceIndex ), loopCount * normalizedScrollingSpeed );
                    sourceIndex = targetIndex < sourceIndex ? sourceIndex - 1 : sourceIndex + 1;
                    loopCount += 1;
                }
            }else {
                disableAnimation ? scrollTo( 0, getDistanceFromContainer( targetIndex ) ) : animateScrollTo( getScrollElement(), getDistanceFromContainer( targetIndex ), options.scrollingSpeed );
            }
        }else {
            triggerError( "You are already in the target section", "warn" );   
        }
    }

    function getDistanceFromContainer( targetIndex ) {
        var distance = 0;
        if( targetIndex < stickyObj.sections.length ) {
            for( var index = 0; index < targetIndex; index++ ) {
                distance += getOffsetOrScreenHeight( stickyObj.sections[ index ] )
            }
        }
        return distance;
    }

    function updateLayout() {
            updateStickySections();
            setFullScreenHeight();
            setContainerHeight();
            reLayout();
            addBodyHeight();
            silentMoveTo( 0 );
        // setTimeout( function() {
        //     setActive();
        //     newSectionLoaded( stickyObj.active );
        // }, 0 );
    }

    function resizeHandler( event ) {   
        var newBreakpoint = getBreakpoint();
        if( newBreakpoint != stickyObj.breakpoint ) {
            if( 'm' != newBreakpoint ) {
                stickyObj.breakpoint = newBreakpoint;
                updateLayout();
            }
        }   
    } 

    function destroy() {
        if( hasClass( body, enabled ) ) {
            removeClass( stickyObj.sections, [active, section, noTransition] );
            if( null != scrollTimeout ) {
                didScroll = false;
                clearInterval( scrollTimeout );
            }
            if( null != options.fixedParent ) {
                var parentElement = __get( options.fixedParent );
                removeClass( parentElement, 'sticky-normal-scroll' );
            }

            //reset Footer, Overlay and dots
            removeFooter();
            removeOverlay();
            removeDots();

            //reset styles
            resetCss( container, 'height' );
            resetCss( stickyObj.sections, [ 'height', 'transform', 'transition' ] );
            if( !options.autoScroll ) {
                resetCss( body, [ 'height', 'overflow' ] );
            }
            resetStickyObj();

            //removeHandlers
            removeEventHandler( window, debouncedResize, 'resize' );
            removeEventHandler( document, scrollHandler, 'scroll' );
            removeEventHandler( document, mouseWheelHandler, [ 'mousewheel', 'wheel', 'DOMMouseScroll', 'onmousewheel' ] );

            //finally remove class
            removeClass( body, enabled );          
        }
    }

    function resetStickyObj() {
        stickyObj = {
            active : null,
            sections : null,
            breakpoint : '',
            scrollRange : null
        };
        scrollingRange = {
            min : 0,
            max : 0
        };
    }

    function addResizeHandler() {
        debouncedResize = debounce( resizeHandler, 300 );
        addEventHandler( window, debouncedResize, 'resize' );
    }

    function setScrollingRange() {
        scrollingRange = {
            min : 0,
            max : 0
        };
        var currentActive = stickyObj.active,
            scrollAreaLeft;
        scrollingRange.min = getDistanceFromContainer( getActiveIndex() );
        scrollingRange.max = scrollingRange.min + ( hasClass( currentActive, overflowSection ) ? currentActive.offsetHeight : fullScreenHeight );
        if( getActiveIndex() === ( stickyObj.sections.length- 1 ) ) {
            scrollAreaLeft = offsetHeight('html') - ( __get('html').scrollTop + window.innerHeight );
            scrollingRange.max += scrollAreaLeft;
        }
    }

    function getElementWithActiveClass() {
        var stickySections = stickyObj.sections;
        if( 0 < stickySections.length ) {
            var activeSection = __get( sectionSelector + ' active' );
            if( null == activeSection ) {
                return null;
            }
            return activeSection;
        }
    }

    function prepareDOM() {
        var stickySections = stickyObj.sections,
            sectionCount = stickySections.length,
            fixedParent = null;
        if( 0 == sectionCount ) {
            triggerError( 'Element on which you initialized sticky doesn\'t have any children. Kindly add some children to make them sticky', 'warning' );
            return;
        }
        setContainerHeight();
        if( !options.autoScroll ) {
            if( options.fixedParent ) {
                fixedParent = __get(  options.fixedParent );
            }else {
                fixedParent = container;
            }
            addClass( fixedParent, 'sticky-normal-scroll' );
        }else {
            addClass( container, 'sticky-auto-scroll' );
        }
        createLayout();
        addOverlay();
        addFooter();
        addDots();
        addBodyHeight();
        addClass( container, stickyWrapper );
    }

    function setContainerHeight() {
        css( container, {
            height : fullScreenHeight + 'px'
        } );
    }

    function removeDots() {
        var nav = __get(dotsNavigationSelector);
        if( null != nav ) {
            nav.parentElement.removeChild( nav );
        }
    }

    function updateDots() {
        var nav = __get(dotsNavigationSelector);
        if( null != nav ) {
            nav.parentElement.removeChild( nav );
            addDots();
        }
    }

    function addDots() {
        if( options.dots ) {
            var stickySections = stickyObj.sections,
                div = document.createElement('div');
            div.setAttribute('id', dotsNavigation);
            var divUl = document.createElement('ul');
            div.appendChild(divUl);
            document.body.appendChild(div);
            nav = __get(dotsNavigationSelector);
            addClass(nav, options.navigationPosition);    

            var li = '';    
            for( var index = 0; index < stickySections.length; index++ ) {
                li = li + '<li class = "sticky-nav-dot"><span></span></li>';
            }        
            divUl.innerHTML = divUl.innerHTML + li;
            if( options.navigationColor ) {
                setCss( __getAll( singleDotSelector + ' span' ) , 'background', options.navigationColor);
            }
            [].forEach.call( divUl.children, function( curDot, index ) {
                addEventHandler( curDot, function() {
                    removeClass( divUl.children, activeDot );
                    addClass( this, activeDot );
                    moveTo( index );
                }, 'click' );
            } );
        }
    }

    function updateNavDots() {
        if( options.dots && null != stickyObj.active ) {
            var elementIndex = getActiveIndex(),
                navDots = __getAll( singleDotSelector );
            removeClass( navDots, activeDot );
            addClass( navDots[ elementIndex ], activeDot );
        }
    }

    function addOverlay() {
        if( options.overlay ) {
            var stickySections = stickyObj.sections,
                overlayElement = document.createElement( 'div' );
            addClass( overlayElement, overlay );
            setCss( overlayElement, 'z-index', stickySections.length - 1 );
            overlayEle = overlayElement;
            addAdjacentSibling( container, overlayElement, 'beforeend' );
        }
    }

    function removeOverlay() {
        if( options.overlay && null != overlayEle ) {
            overlayEle.parentElement.removeChild( overlayEle );
            overlayEle = null;
        }
    }

    function setFullScreenHeight() {
        fullScreenHeight = getWindowHeight() - getHeightFromSelectors( options.fullScreenOffset );
    }

    function getHeightFromSelectors( selectorArray ) {
        var totalHeight = 0;
        if( null != selectorArray ) {
            if( '[object Array]' == getObjectType( selectorArray ) && 0 < selectorArray.length ) {
                selectorArray.forEach( function( selector ) {
                    var curElement = __get( selector );
                    if( null != curElement ) {
                        totalHeight = totalHeight + curElement.offsetHeight;
                    }
                } );
            }
        }
        return totalHeight;
    }

    function createLayout() {
        var stickySections = stickyObj.sections,
            childrenCount = stickySections.length;
        [].forEach.call( stickySections, function( stickySection, index ) {
            if( !hasClass( stickySection, 'tatsu-fullscreen' ) ) {
                if( fullScreenHeight < stickySection.offsetHeight ) {
                    addClass( stickySection, overflowSection );
                }else {
                    setCss( stickySection, 'height', '100%' );
                }
            }
            setCss( stickySection, 'z-index', childrenCount - index );
        } );
    }

    function reLayout() {
        var stickySections = stickyObj.sections,
            childrenCount = stickySections.length;
            node = null;
        [].forEach.call( stickySections, function( stickySection, index ) {
            if( !hasClass( stickySection, 'tatsu-fullscreen' ) ) {
                resetCss( stickySection, 'height', '' );
                if( fullScreenHeight < stickySection.offsetHeight ) {
                    addClass( stickySection, overflowSection );
                }else {
                    setCss( stickySection, 'height', '100%' );
                }                    
            }
            setCss( stickySection, 'z-index', childrenCount - index );
        } );
        if( options.overlay ) {
            setCss( overlayEle, 'z-index', stickyObj.sections.length - 1 );
        }

    }
    
    function addBodyHeight() {
        if( !options.autoScroll ) {
            var totalHeight = 0,
                stickySections = stickyObj.sections;
            [].forEach.call( stickySections, function( curSection ) {
                if( !hasClass( curSection, overlay ) ) {
                    totalHeight = totalHeight + curSection.offsetHeight;
                }
            } );
            options.fullScreenOffset.forEach( function( selector ) {
                var ele = __get( selector );
                if( null != ele && 'wpadminbar' != ele.id ) {
                    totalHeight = totalHeight + ele.offsetHeight;
                }
            } );
            if( '' != options.footer && 0 < footerHeight ) {
                totalHeight = totalHeight + footerHeight;
            }
            css( body, {
                overflow : 'auto',
                height : totalHeight + 'px'
            } );
        }
    }

    function triggerError( message, type ) {
        if( 'string' == typeof message && 'string' == typeof type && '' != message && -1 < [ 'error', 'warn' ].indexOf( type ) ) {
            console[ type ]( message );
        }
    }

    function mouseWheelHandler( event ) {
        var curTime = Date.now(),
            timeDiff = curTime - prevTime,
            event = window.event || event,
            averageEnd,
            averageMedium,
            isAccelerating = false,
            value = event.wheelDelta || ( -1 * event.detail ),
            delta = Math.max( -1, Math.min( 1, value ) );
        prevTime = curTime;
        if( 149 < scrollings.length ) {
            scrollings.shift();
        }
        scrollings.push( Math.abs( value ) );
        if( 200 < timeDiff ) {
            scrollings = [];
        }
        if( canScroll ) {
            averageEnd = getAverage( scrollings, 5 );
            averageMedium = getAverage( scrollings, 70 );
            isAccelerating = averageEnd >= averageMedium;
            if( isAccelerating || hasClass( stickyObj.active, overflowSection ) ) {
                if( 1 == delta ) {
                    moveSectionUp();
                }else if( -1 == delta ) {
                    moveSectionDown();
                }
            }
        }
    }

    function getTranslateY( node ) {
        var transform = getComputedStyle( node ).transform,
            transformArray = transform.split( "," );
        if( null != transformArray[5] ) {
            return Math.abs( parseInt( transformArray[5] ) );
        }
        return 0;
    }

    function moveSectionDown() {
        var currentActive = stickyObj.active;
        if( hasClass( currentActive, overflowSection ) ) {
            var currentTransformedValue = getTranslateY( currentActive );
            if( fullScreenHeight < ( currentActive.offsetHeight - ( currentTransformedValue + 50 ) ) ) {
                if( null != scrollTimeout && !didScroll ) {
                    didScroll = true;
                }
                transformSection( currentActive, -1 * ( currentTransformedValue + 50 ), false );
            }else {
                nextSection();
            }
        }else {
            nextSection();
        }
    }

    function moveSectionUp() {
        var currentActive = stickyObj.active;
        if( hasClass( currentActive, overflowSection ) && !footerVisible ) {
            //can do this with scrollingRange
            var currentTransformedValue = getTranslateY( currentActive );
            if( 0 <= ( currentTransformedValue - 50 ) ) {
                if( null != scrollTimeout && !didScroll ) {
                    didScroll = true;
                }
                transformSection( currentActive, 50 > ( currentTransformedValue - 50 ) ? 0 : -1 * ( currentTransformedValue - 50 ), false );
            }else {
                previousSection();
            }
        }else {
            previousSection();
        }
    }

    function enableScrollCallback( enable ) {
        if( enable ) {
            if( null == scrollTimeout ) {
                scrollTimeout = setInterval( function() {
                    if( didScroll ) {
                        didScroll = false;
                        options.scrollCallback.call( stickyObj.active, getActiveIndex() );
                    }
                }, 150 );
            }
        }else if( null != scrollTimeout ) {
            clearInterval( scrollTimeout );
            scrollTimeout = null;
            if( didScroll ) {
                 didScroll = false;
            }
        }
    }

    function moveSectionBasedOnScrollTop( scrollTop ) {
        if( 0 <= scrollTop ) {
            if( scrollTop >= scrollingRange.max ) {
                while( scrollTop >= scrollingRange.max ) {
                    transformSection( stickyObj.active, getYMovement( scrollTop ), false );
                    updateActive( getActiveNextSibling(), 'down' );
                    newSectionLoaded( stickyObj.active );
                    if( hasClass( stickyObj.active, overflowSection ) ) {
                        enableScrollCallback( true );
                    }else if( null != scrollTimeout ) {
                        enableScrollCallback( false );
                    }
                }
                transformSection( stickyObj.active, getYMovement( scrollTop ), false );
            }else if( scrollTop < scrollingRange.min ) {
                while( scrollingRange.min > scrollTop ) {
                    transformSection( stickyObj.active, getYMovement( scrollTop ), false );
                    if( footerVisible ) {
                        footerVisible = false;
                    }
                    updateActive( getActivePrevSibling(), 'up' );     
                    newSectionLoaded( stickyObj.active );   
                    if( hasClass( stickyObj.active, overflowSection ) ) {
                        enableScrollCallback( true );
                    }else if( null != scrollTimeout ) {
                        enableScrollCallback( false );
                    }            
                }
                transformSection( stickyObj.active, getYMovement( scrollTop ), false );
            }else {
                if( null != scrollTimeout && !didScroll ) {
                    didScroll = true;
                }
                if( hasClass( getActiveNextSibling(), 'sticky-footer-wrap' ) && !footerVisible ) {
                    footerVisible = true;
                }
                transformSection( stickyObj.active, getYMovement( scrollTop ), false );
            }
        }
    }

    function scrollHandler( event ) {
        moveSectionBasedOnScrollTop( getScrollTop() );
    }

    function getYMovement( scrollTop ) {
        if( scrollTop >= scrollingRange.max ) {
            return -1 * ( hasClass( stickyObj.active, overflowSection ) ? stickyObj.active.offsetHeight : fullScreenHeight ) ;
        }else if( scrollTop <= scrollingRange.min ) {
            return 0;
        }else {
            return -1 * ( scrollTop - scrollingRange.min );
        }
    }

    function updateOverlay( opacity ) {
        if( options.overlay ) {
            var curzIndex = Number( getCss( stickyObj.active, 'z-index' ) );
            if( !isNaN( curzIndex ) ) {
                css( overlayEle, {
                    'z-index' : curzIndex - 1,
                    'opacity' : opacity,
                    'transition' : 'none'
                } );
            }
        }
    }

    function updateActive( element, direction ) {
        if( null != element && element != stickyObj.active ) {
            removeClass( stickyObj.active, active );
            addClass( element, active );
            stickyObj.active = element;
            updateNavDots();
            updateOverlay( 'down' == direction ? 1 : 0 );
            setScrollingRange();
        }
    }

    function newSectionLoaded( loadedSection ) {
        isFunction( options.afterLoad ) && options.afterLoad.call( loadedSection, getNodeIndex( loadedSection ) );
        canScroll = true;
    }

    function transformSection( element, yMovement, animated, varyingSpeed ) {
        if( animated ) {
            addAnimation( element, varyingSpeed );
        }else {
            removeAnimation( element );
        }
        setTransforms( element, yMovement );
        setOpacity( element, Math.abs( yMovement ) );
    }

    function setOpacity( element, yMovement ) {
        if( options.overlay ) {
            if( options.autoScroll ) {
                if( hasClass( element, overflowSection ) ) {
                    if( yMovement > ( element.offsetHeight - fullScreenHeight ) || yMovement == ( element.offsetHeight - fullScreenHeight ) ) {
                        css( overlayEle, {
                            transition : 'opacity ' + options.scrollingSpeed + 'ms ease',
                            opacity : yMovement > ( element.offsetHeight - fullScreenHeight ) ? 0 : 1   
                        } );    
                    }
                }else {
                    css( overlayEle, {
                        'transition' : 'opacity ' + options.scrollingSpeed + 'ms ease',
                        opacity : 0 == yMovement ? 1 : 0
                    });
                }
            }else {
                if( hasClass( element, overflowSection ) ) { 
                    if( yMovement > ( element.offsetHeight - fullScreenHeight ) ) {
                        setCss( overlayEle, 'opacity', 1 - ( ( yMovement - ( element.offsetHeight - fullScreenHeight ) )/( footerVisible ? footerHeight : fullScreenHeight ) ) );
                    }
                }else {
                    setCss( overlayEle, 'opacity', 1 - ( yMovement/( footerVisible ? footerHeight : fullScreenHeight ) ) );
                }
            }
        }
    }

    function nextSection() {
        var currentActive = stickyObj.active,
            nextSection = getActiveNextSibling(); 
        if( null != nextSection ) {
            if( options.autoScroll ) {
                if( canScroll ) {
                    if( hasClass( nextSection, 'sticky-footer-wrap' ) ) {
                        if( !footerVisible ) {
                            canScroll = false;
                            transformSection( currentActive, -1 * ( hasClass( currentActive, overflowSection ) ? ( ( currentActive.offsetHeight%fullScreenHeight )  + footerHeight ) : footerHeight ), true );
                            setTimeout( function() {
                                canScroll = true;
                                footerVisible = true;
                            }, options.scrollingSpeed );
                        }
                    }else {
                        canScroll = false;
                        transformSection( currentActive, -1 * getOffsetOrScreenHeight( currentActive ), true );
                        setTimeout( function() {
                            updateActive( nextSection, 'down' );
                            newSectionLoaded( stickyObj.active );
                            if( hasClass( stickyObj.active, overflowSection ) ) {
                                enableScrollCallback( true );
                            }else if( null != scrollTimeout ) {
                                enableScrollCallback( false );
                            }
                        }, options.scrollingSpeed );
                    }
                }else {
                    triggerError( 'nextSection : Transition to a section is in progress, please call again once its complete', 'warn' );
                }
            }else {
                scrollTo( 0, scrollingRange.max );
            }
        }
    }

    function previousSection() {
        var currentActive = stickyObj.active,
            prevSibling = getActivePrevSibling();
        if( null != prevSibling ) {
            if( options.autoScroll ) {
                if( canScroll ) {
                    if( footerVisible ) {
                        canScroll = false;
                        transformSection( currentActive, -1 * (hasClass( currentActive, overflowSection ) ? ( currentActive.offsetHeight - fullScreenHeight ) : 0 ), true );
                        setTimeout( function() {
                            footerVisible = false;
                            canScroll = true;
                        }, options.scrollingSpeed )
                    }else {
                        canScroll = false;
                        updateActive( prevSibling, 'up' );
                        setTimeout( function() {
                            transformSection( stickyObj.active, hasClass( stickyObj.active, overflowSection ) ? ( -1 * (stickyObj.active.offsetHeight - fullScreenHeight ) ) : 0, true );
                            setTimeout( function() {
                                newSectionLoaded( stickyObj.active );
                                if( hasClass( stickyObj.active, overflowSection ) ) {
                                    enableScrollCallback( true )
                                }else if( null != scrollTimeout ) {
                                    enableScrollCallback( false );
                                }
                            }, options.scrollingSpeed );        
                        }, 50 );
                    }
                }else {
                    triggerError( 'previousSection : Transition to a section is in progress, please call again once its complete', 'warn' );                    
                }
            }else {
                scrollTo( 0, scrollingRange.min - getOffsetOrScreenHeight( prevSibling ) );
            }
        }
    }

    function addMouseWheelHandler() {
       if( options.autoScroll ) {
            addEventHandler( document, mouseWheelHandler, [ 'mousewheel', 'wheel', 'DOMMouseScroll', 'onmousewheel' ] );
       }
    }

    function addScrollHandler() {
        if( !options.autoScroll ) {
            addEventHandler( document, scrollHandler, "scroll" )
        }
    }

    function getActiveNextSibling() {
        var activeIndex = getActiveIndex();
        if( activeIndex < ( stickyObj.sections.length - 1 ) ) {
            return stickyObj.sections[ activeIndex + 1 ];
        }else if( options.footer && !footerVisible ) {
            return __get( '.sticky-footer-wrap' );
        }
        return null;
    }

    function getActivePrevSibling() {
        var activeIndex = getActiveIndex();
        if( activeIndex > 0 ) {
            return stickyObj.sections[ activeIndex - 1 ];
        }
        return null;
    }

    /**
    * Gets the average of the last `number` elements of the given array.
    */
    function getAverage(elements, number){
        var sum = 0,
            lastElements = elements.slice(Math.max(elements.length - number, 1));
        for(var i = 0; i < lastElements.length; i++){
            sum = sum + lastElements[i];
        }
        return Math.ceil(sum/number);
    }

    function addAnimation( element, varyingSpeed ) {
        var transition = 'all ' + ( null != varyingSpeed ? varyingSpeed : options.scrollingSpeed ) + 'ms ' + options.easingcss3;
        if( null == element ) { 
            return;
        }
        removeClass( element, noTransition );
        css(element, {
            '-webkit-transition': transition,
            'transition': transition
        });
    }

    function removeAnimation( element ) {
        addClass( element, noTransition );
    }


    /* --------------- Javascript helpers  ---------------*/

    /**
    * Replacement of jQuery extend method.
    */
    function extend(defaultOptions, options){
        //creating the object if it doesnt exist
        if(typeof(options) !== 'object'){
            options = {};
        }
        for(var key in options){
            if(defaultOptions.hasOwnProperty(key)){
                defaultOptions[key] = options[key];
            }
        }
        return defaultOptions;
    }

    function isElement(o){
        if( null != o ) {
            return (
                null != HTMLElement ? o instanceof HTMLElement : //DOM2
                o && typeof o === "object" && o !== null && o.nodeType === 1 && typeof o.nodeName==="string"
            );
        }
        return false;
    }

    function getById(element){
        return document.getElementById(element);
    }

    function getByTag(element){
        return document.getElementsByTagName(element)[0];
    }

    function css( el, props ) {
        if( null != el ) {
        var key,
            objType = getObjectType( el );
        if( "[object NodeList]" == objType || "[object HTMLCollection]" == objType ) {
            [].forEach.call( el, function( ele ) {
                for ( key in props ) {
                    if ( props.hasOwnProperty(key) ) {
                        if ( key !== null ) {
                            el.style[key] = props[key];
                        }
                    }
                }                
            } );
        }else {
            for ( key in props ) {
                if ( props.hasOwnProperty(key) ) {
                    if ( key !== null ) {
                        el.style[key] = props[key];
                    }
                }
            }
        }
    }
    }

    function debounce(func, wait, immediate) {
        var timeout;
        return function() {
            var context = this, args = arguments;
            var later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    };

    function getOffsetOrScreenHeight( node ) {
        return null == node ? 0 : ( hasClass( node, overflowSection ) ? node.offsetHeight : fullScreenHeight );
    }

    function setCss(element, style, value){
        var objType = getObjectType( element );
        if( "[object NodeList]" == objType || "[object HTMLCollection]" == objType ) {
            [].forEach.call( element, function( ele ) {
                ele.style[ style ] = value;
            } );
        }else {
            element.style[style] = value;
        }
    }

    function resetCss( element, style ) {
        var objType = getObjectType( element ),
            styleType = getObjectType( style );
        if( null != element ) {
        if( "[object NodeList]" == objType || "[object HTMLCollection]" == objType || "[object Array]" == objType ) {
            [].forEach.call( element, function( ele ) {
                if( '[object Array]' == styleType ) {
                    style.forEach( function( curStyle ) {
                        ele.style[ curStyle ] = "";
                    } );
                }else {
                    ele.style[ style ] = "";
                }
            } );
        }else {
            if( '[object Array]' == styleType ) {
                style.forEach( function( curStyle ) {
                    element.style[ curStyle ] = "";
                } );
            }else {
                
                element.style[ style ] = "";
            }
        }        
    }
    }

    function getCss( element, att ) {
        if( null != element ) {
            return getComputedStyle( element ).getPropertyValue( att );
        }
    }

    function setTransforms(element, yMovement, varyingSpeed){
        var translate3d = 'translate3d(0px, ' + yMovement + 'px, 0px)';
        css(element, {
            '-webkit-transform': translate3d,
            '-moz-transform': translate3d,
            '-ms-transform': translate3d,
            'transform': translate3d 
        });
    }

    function __get(selector, context){
        context = context || document;
        return context.querySelector(selector);
    }

    function __getAll(selector, context){
        context = context || document;
        return context.querySelectorAll(selector);
    }

    function getNodeIndex(node) {
        var index = -1;
        if( 0 < stickyObj.sections.length && null != node ) {
            return [].indexOf.call( stickyObj.sections, node );
        }
        return index;
    }

    function getActiveIndex() {
        if( null != stickyObj.active && null != stickyObj.sections ) {
            var index = [].indexOf.call( stickyObj.sections, stickyObj.active );
            if( -1 == index ) {
                return stickyObj.sections.length;
            }else {
                return index;
            }
        }
        return -1;
    }


    //http://jaketrent.com/post/addremove-classes-raw-javascript/
    function hasClass(ele,cls,every) {
        if( null != ele ) {
            var objType = getObjectType( ele ); 
            if( "[object NodeList]" == objType || "[object HTMLCollection]" == objType || "[object Array]" == objType ) {
                if( every ) {
                    return [].every.call( ele, function( curEle ) {
                        return curEle.classList.contains( cls );
                    } );      
                }else {
                    return [].some.call( ele, function( curEle ) {
                        return curEle.classList.contains( cls );
                    } )
                }
            }else{
                return ele.classList.contains( cls );
            }
        }
        return false;
    }

    function removeClass(element, className) {
        if( null != element ) {
            var objType = getObjectType( element ),
                classType = getObjectType( className );
            if( "[object NodeList]" == objType || "[object HTMLCollection]" == objType || "[object Array]" == objType ) {
                [].forEach.call( element, function( ele ) {
                    if( null != ele ) {
                        if( "[object Array]" == classType ) {
                            className.forEach(function( curClass ) {
                                if( hasClass( ele, curClass ) ) {
                                    ele.classList.remove( curClass );
                                }
                            });
                        }else if( hasClass( ele, className ) ) {
                            ele.classList.remove( className );
                        }
                    }
                } );
            }else {
                if( "[object Array]" == classType ) {
                    className.forEach(function( curClass ) {
                        if( hasClass( element, curClass ) ) {
                            element.classList.remove( curClass );
                        }
                    });
                }else if( hasClass( element, className ) ) {
                    element.classList.remove( className );
                }
            }
        }
    }

    function addClass(element, className) {
        if( null != element ) {
            var objType = getObjectType( element );
            if( "[object HTMLCollection]" == objType || "[object NodeList]" == objType || "[object Array]" == objType ) {
                [].forEach.call( element, function( ele ) {
                    if (ele && !hasClass(ele,className)) {
                        ele.classList.add( className );
                    }
                } );
            }else if (element && !hasClass(element,className)) {
                element.classList.add( className );
            }
        }
    }

    function offsetHeight( element ) {
        var element = (typeof element === 'string') ? document.querySelector(element) : element,
            styles = window.getComputedStyle(element),
            margin = parseFloat(styles['marginTop']) +
                    parseFloat(styles['marginBottom']);
        element = (typeof element === 'string') ? document.querySelector(element) : element; 
        return Math.ceil(element.offsetHeight + margin);
    }

    function equalArray( arr1, arr2 ) {
        if( null != arr1 && null != arr2 ) {
            if( arr1.length == arr2.length ) {
                return arr1.every( function( arrEle, index ) {
                    return arrEle === arr2[ index ];
                } );
            }
        }
        return false;
    }

    //http://stackoverflow.com/questions/22100853/dom-pure-javascript-solution-to-jquery-closest-implementation
    function closest(el, fn) {
        return el && (
            fn(el) ? el : closest(el.parentNode, fn)
        );
    }

    function getWindowWidth(){
        return  'innerWidth' in window ? window.innerWidth : document.documentElement.offsetWidth;
    }

    function getWindowHeight(){
        return  'innerHeight' in window ? window.innerHeight : document.documentElement.offsetHeight;
    }   

    //http://stackoverflow.com/questions/842336/is-there-a-way-to-select-sibling-nodes
    //Gets siblings
    function getAllSiblings( element ) {
        return getChildren( element.parentNode.firstChild, element );
    }
    
    function getChildren( element, skipMe ){
        var siblings = [];
        for ( ; element ; element = element.nextSiblingElement ) {
            if( element != skipMe ) {
                siblings.push( element ); 
            }
        }
        return siblings;
    };
    
    function addAdjacentSibling( targetElement, newElement, position ) {
        if( -1 == [ 'afterbegin', 'beforebegin', 'afterend', 'beforeend' ].indexOf( position ) || null == targetElement || null == newElement ) {
            return false;
        }
        return targetElement.insertAdjacentElement( position, newElement );
    }

    function addEventHandler( element, handler, eventsArray ) {
        if( "[object Array]" == getObjectType( eventsArray ) ) {
            eventsArray.forEach( function( event ) {
                element.addEventListener( event, handler );
            } );
        }else {
            element.addEventListener( eventsArray, handler );
        }
    }

    function removeEventHandler( element, handler, eventsArray ) {
        if( "[object Array]" == getObjectType( eventsArray ) ) {
            eventsArray.forEach( function( event ) {
                element.removeEventListener( event, handler );
            } );
        }else {
            element.removeEventListener( eventsArray, handler );
        }        
    }

    function isFunction( func ) {
        return func && "[object Function]" == getObjectType( func );
    }

    function getObjectType( obj ) {
        var dummyObj = {};
        return dummyObj.toString.call( obj );
    }

    function getScrollElement() {
        if( 0 < document.body.scrollTop ) {
            return document.body;
        }else {
            return document.documentElement;
        }
    }

    function getScrollTop() {
        return document.body.scrollTop || document.documentElement.scrollTop;
    }

    function getCurrentActive() {
        return stickyObj.active;
    }

    function getScrollingRange() {
        return scrollingRange;
    }

    function getCurBreakpoint() {
        return stickyObj.breakpoint;
    }

    /* --------------- END Javascript helpers  ---------------*/

    return {
        initialize : initialize,
        previousSection : previousSection,
        nextSection : nextSection,
        moveTo : moveTo,
        getCurrentActive : getCurrentActive,
        updateLayout : updateLayout,
        getScrollingRange : getScrollingRange,
        getBreakpoint : getCurBreakpoint,
        destroy : destroy,
        getStickyIndex : getNodeIndex,
    }
    
});