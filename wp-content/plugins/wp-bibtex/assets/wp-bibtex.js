(function($) {
    $('.wpbibtex-trigger').click(function() {
        var bibtexInfoContainer = $('.bibtex', $(this).parent());
        if ( $(bibtexInfoContainer).is(':visible') ) {
            $(bibtexInfoContainer).slideUp(250);
        } else {
            $(bibtexInfoContainer).slideDown(250);
        }
    });
})(jQuery);