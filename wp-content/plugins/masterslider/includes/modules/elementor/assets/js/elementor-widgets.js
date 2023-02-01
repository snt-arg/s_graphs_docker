/**
 * Init Elements in Elementor Frontend
 *
 */
;(function($, window, document, undefined){
    "use strict";

    $(window).on('elementor/frontend/init', function (){

        elementorFrontend.hooks.addAction( 'frontend/element_ready/aux_masterslider.default',
            function( $scope ){

                if( $scope.find('.ms-container').length ) {
                    return;
                }
                if ( window.MSReady && typeof MSReady !== 'undefined' ) {
                    for ( var i = 0, l = MSReady.length; i !== l; i++ ) {
                        MSReady[i].call( null, $ );
                    }
                }
             }
        );

    });

})(jQuery, window, document);

