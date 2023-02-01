(function($){
    var addToggleButton = function() {
            var buttonHtml = $($('#tatsu-gutenberg-switch-button').html()),
                gutenberg = $('#editor');
            if( '1' ===  TatsuGutenbergSettings.editedWithTatsu ) {
                buttonHtml.on('click', function(e) {
                    e.preventDefault();
                    showWarningModal();
                });
            }
            if( 0 < gutenberg.length && ! gutenberg.find( '#tatsu-switch-builder-button' ).length ) {
                // alert(2);
                gutenberg.find('.edit-post-header-toolbar').append(buttonHtml);
            }
        },
        showWarningModal = function() {
            var modal = $($('#tatsu-switch-to-gutenberg').html());
            $('body').append(modal);
        }
        addTatsuPanel = function() {
            var tatsuEditorPanel = $($('#tatsu-gutenberg-editor-panel').html()), gutenberg = $('#editor'), 
                gutenbergBlockList = $('#editor').find('.block-editor-block-list__layout, .editor-post-text-editor');
            if( 0 < gutenbergBlockList.length  && ! gutenberg.find( '#tatsu_edit_post_wrap' ).length ) {
                gutenbergBlockList.after(tatsuEditorPanel);
            }
        };
    
    if(wp.data != undefined) {
        wp.data.subscribe( function() {
                setTimeout( function() {
                    addToggleButton();
                    addTatsuPanel();
                }, 1 );
            } );
    } else {
        $(function() {
        setTimeout(function() {
            // alert(1);
            addToggleButton();
            addTatsuPanel();
            }, 1)
        })
    }
})(jQuery)