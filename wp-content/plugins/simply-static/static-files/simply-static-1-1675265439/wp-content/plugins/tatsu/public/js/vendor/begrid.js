(function (global, factory, $) {
    if (typeof define == 'function' && define.amd) {
        // AMD - RequireJS
        define('begrid', factory);
    } else if (typeof module == 'object' && module.exports) {
        // CommonJS - Browserify, Webpack
        module.exports = factory($);
    } else {
        // Browser globals
        global.BeGrid = factory($);
    }
}(window, function ($) {
    "use strict";
    var $window = $(window),
        BeGrid = function (grid) {
            if (null != grid && !$(grid).hasClass('be-grid-initialized')) {
                this.init(grid);
                $window.load(function () {
                    this.ele.isotope('layout');
                }.bind(this));
            }
        };
    BeGrid.prototype.init = function (ele) {
        if (null != ele) {
            this.ele = $(ele);
            this.setDefaultProps();
            this.setLayout();
            this.setGutter();
            this.initGridAnimation();
            this.grid();
            this.initEvents();    
            this.filterItems();
        }
    };
    BeGrid.prototype.initEvents = function () {
        $window.on('load', function () {
            this.ele.isotope('layout');
        }.bind(this));
        $window.on( 'debouncedresize', function() {
            var mediaElements = this.ele.find( 'audio, video' ),
                sliders = this.ele.find( '.be-slider' );
            this.grid();
            if( 0 < mediaElements.length ) {
                mediaElements.each( function() {
                    var mediaElementObj = $(this).data().mediaelementplayer;
                    if( 'object' == typeof mediaElementObj ) {
                        mediaElementObj.setPlayerSize();
                        mediaElementObj.setControlsSize();
                    }
                } );
            }
            if( 0 < sliders.length ) {
                sliders.each(function(){
                    var curSlider = $(this);
                    if( curSlider.hasClass( 'flickity-enabled' ) ) {
                       curSlider.flickity( 'reposition' );
                    } 
                });
                this.ele.isotope( 'layout' );
            }
        }.bind(this));
    };
    BeGrid.prototype.setDefaultProps = function () {
        //defaults
        this.cols = 3;
        this.gutter = 0;
        this.elementsToReveal = null;
        this.animationType = 'revealAllAtOnce';
        this.layout = 'masonry';
    };
    BeGrid.prototype.setGutter = function () {
        this.gutter = parseInt(this.ele.attr('data-gutter')) || 0;
    };
    BeGrid.prototype.setLayout = function () {
        if ('metro' === this.ele.attr('data-layout')) {
            this.layout = 'metro';
        }
    };
    BeGrid.prototype.setCols = function () {
        var cols = parseInt(this.ele.attr('data-cols')) || 3,
            windowWidth = $window.width();
        if (1024 < windowWidth) {
            //laptops and desktops
            this.cols = cols;
        } else {
            //small screens
            if (959 < windowWidth) {
                //table landscape mode
                switch (cols) {
                    case 1:
                        this.cols = 1;
                        break;
                    case 2:
                        this.cols = 2;
                        break;
                    case 3:
                    default:
                        this.cols = 3;
                        break;
                }
            } else if( 767 < windowWidth ) {
                //tablet portrait mode 
                if (1 == cols) {
                    this.cols = 1;
                } else {
                    this.cols = 2;
                }
            }else {
                if( null != this.ele.attr('data-mobile-cols') ) {
                    this.cols = parseInt(this.ele.attr('data-mobile-cols'));
                }else {
                    this.cols = 1;
                }
            }
        }
    };
    BeGrid.prototype.initGridAnimation = function () {
        this.animationType = '1' === this.ele.attr('data-scroll-reveal') ? 'scrollReveal' : 'revealAllAtOnce';
        this.elementsToReveal = this.ele.find('.be-col');
        this.addAnimationClass();
        if ( 'scrollReveal' === this.animationType ) {
            $window.on('scroll', function () {
                this.triggerScrollReveal();
            }.bind(this));
        }
    };
    BeGrid.prototype.addAnimationClass = function () {
        var animationTarget = this.ele.attr( 'data-animation-target' ) || '.be-col',
            animationClass = this.ele.attr('data-animation') || 'be-col-hide';
        this.ele.find( animationTarget ).addClass( animationClass );
    };
    BeGrid.prototype.triggerScrollReveal = function () {
        if ( 'scrollReveal' === this.animationType && 0 < this.elementsToReveal.length) {
            var visibleEles = this.elementsToReveal.filter(function () {
                return $(this).isVisible(-100);
            });
            if (0 < visibleEles.length) {
                visibleEles.each(function (i, el) {
                    var curEl = $(el),
                        animationClass = null == this.ele.attr('data-animation') ? 'be-col-visible' : 'be-start-animation',
                        animationTarget = this.ele.attr( 'data-animation-target' );
                    if ( null != animationTarget ) {
                        curEl = curEl.find( animationTarget );
                    }
                    curEl.css('transition-delay', (i * 150) + 'ms');
                    curEl.addClass(animationClass);
                }.bind(this));
                this.elementsToReveal = this.elementsToReveal.not(visibleEles);
            }
        }
    };
    BeGrid.prototype.filterItems = function () {
        if (this.ele.attr('data-filter-items') === "1") {
            this.ele.parent().on('click', '.sort-items', function (e) {
                var filterKey = $(e.currentTarget).data('id');
                var filterredItems = $([]);
                if (!$(e.currentTarget).hasClass('current_choice')) {
                    this.ele.parent().find('.sort-items').removeClass('current_choice');
                    $(e.currentTarget).addClass('current_choice');
                    var cols = this.ele.find('.be-col');
                    cols.css({
                        transform: 'scale(0)',
                        transition: 'all 0.3s ease'
                    });
                    setTimeout(function () {
                        cols.find('.be-start-animation').css('transition-delay', '');
                        cols.css({ transform: '', transition: '' });
                        this.ele.isotope({
                            filter: function () {
                                var itemCategories = $(this).data('category-names');
                                if (filterKey === 'all' || itemCategories.indexOf(filterKey) > -1) {
                                    filterredItems = filterredItems.add($(this));
                                    return true;
                                }
                            },
                            transitionDuration: 0
                        });
                        filterredItems.find('.be-start-animation').removeClass('be-start-animation');
                        this.elementsToReveal = filterredItems;
                        setTimeout( function() {
                            if (this.animationType === 'scrollReveal') {
                                this.triggerScrollReveal();
                            }else {
                                this.revealAllAtOnce();
                            }
                        }.bind(this), 0 );
                    }.bind(this), 300);
                }
            }.bind(this));
        }
    };
    BeGrid.prototype.revealAllAtOnce = function () {
        if ( 'revealAllAtOnce' === this.animationType && 0 < this.elementsToReveal.length) {
            this.elementsToReveal.each(function (i, el) {
                var jEl = $(el),
                    animationClass = null == this.ele.attr('data-animation') ? 'be-col-visible' : 'be-start-animation',
                    animationTarget = this.ele.attr( 'data-animation-target' );
                if ( null != animationTarget ) {
                    jEl = jEl.find( animationTarget );
                }
                jEl.css('transition-delay', (i * 150) + 'ms');
                jEl.addClass( animationClass );
            }.bind(this));
            this.elementsToReveal = $([]);
        }
    };
    BeGrid.prototype.grid = function () {
        this.setCols();
        this.setWidth();
        this.setGiantCells();
        this.renderLayout();
    };
    BeGrid.prototype.setWidth = function () {
        this.ele.width(''); //reset ele width bfore recalculating
        var curWidth = this.ele.width(),
            windowWidth = $window.width(),
            cells = this.ele.find('.be-col'),
            giants,
            normalWidth;

        // while ((curWidth % this.cols) != 0) {
        //     curWidth = curWidth + 1;
        // }

        console.log(curWidth);
        var remainder = Math.floor(curWidth / this.cols);
        curWidth = remainder * this.cols + this.cols;
        console.log(curWidth);

        this.ele.width(curWidth);

        normalWidth = curWidth / this.cols;
        if ('masonry' == this.layout) {
            cells.outerWidth(normalWidth);
        } else {
            if (767 < windowWidth) {
                giants = cells.filter(function () {
                    return $(this).hasClass('be-double-width-cell') || $(this).hasClass('be-double-width-height-cell');
                });
                if (0 < giants.length) {
                    cells = cells.not(giants);
                    giants.outerWidth(normalWidth * 2);
                }
            }
            cells.outerWidth(normalWidth);
        }
    };
    BeGrid.prototype.setGiantCells = function () {
        //computes the dimensions of double width, double height cells
        if ('metro' == this.layout) {

            var aspectRatio = !isNaN(parseFloat(this.ele.attr('data-aspect-ratio'))) ? parseFloat(this.ele.attr('data-aspect-ratio')) : 1,
                normalCellWidth = (this.ele.width() / this.cols) - this.gutter,
                windowWidth = $window.width(),
                normalCellHeight = (normalCellWidth) / aspectRatio,
                normalCellHeight = Math.round(normalCellHeight * 100) / 100,
                doubleWidthCells = this.ele.find('.be-double-width-cell'),
                doubleHeightCells = this.ele.find('.be-double-height-cell'),
                doubleWidthHeightCells = this.ele.find('.be-double-width-height-cell');
            //double width
            if (0 < doubleWidthCells.length) {
                doubleWidthCells.each(function (i, cell) {
                    var curCell = $(cell),
                        padding;
                    if (767 < windowWidth) {
                        padding = normalCellHeight / ((normalCellWidth * 2) + this.gutter);
                    } else {
                        padding = normalCellHeight / normalCellWidth;
                    }
                    if (!isNaN(padding)) {
                        padding = padding * 100;
                        curCell.find('.be-grid-placeholder').css('padding-bottom', padding + '%');
                    }
                }.bind(this));
            }

            ///double height
            if (0 < doubleHeightCells.length) {
                doubleHeightCells.each(function (i, cell) {
                    var curCell = $(cell),
                        padding = ((2 * normalCellHeight) + this.gutter) / normalCellWidth;
                    if (!isNaN(padding)) {
                        padding = padding * 100;
                        curCell.find('.be-grid-placeholder').css('padding-bottom', padding + '%');
                    }
                }.bind(this));
            }

            //double width height
            if (0 < doubleWidthHeightCells.length) {
                doubleWidthHeightCells.each(function (i, cell) {
                    var curCell = $(cell),
                        padding;
                    if (767 < windowWidth) {
                        padding = ((2 * normalCellHeight) + this.gutter) / ((normalCellWidth * 2) + this.gutter)
                    } else {
                        padding = ((2 * normalCellHeight) + this.gutter) / normalCellWidth;
                    }
                    if (!isNaN(padding)) {
                        padding = padding * 100;
                        curCell.find('.be-grid-placeholder').css('padding-bottom', padding + '%');
                    }
                }.bind(this));
            }
        }
    };
    BeGrid.prototype.renderLayout = function () {
        var columnWidth = this.ele.width() / this.cols;
        this.ele.isotope({
            isInitLayout: false,
            itemSelector: '.be-col',
            resize: false,
            masonry: {
                columnWidth: columnWidth,
            }
        });
        this.ele.on('layoutComplete', function () {
            if (!this.ele.hasClass('be-grid-initialized')) {
                this.ele.addClass('be-grid-initialized');
                setTimeout(function () {
                    if (this.animationType === 'scrollReveal') {
                        this.triggerScrollReveal();
                    }else {
                        this.revealAllAtOnce();
                    }
                    BeLazyLoad.lazyLoad();
                }.bind(this), 0);
            }
        }.bind(this));
        this.ele.isotope();
    };
    return BeGrid;
}, jQuery));