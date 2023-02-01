(function($){
	"use strict";
	function go_to() {
		$( document ).on('wp-theme-update-success', function(){
			window.location.href = be_redirect.url;
		})
	}
	function be_can_update_plugin(){
        if(typeof be_redirect !=='undefined' && typeof be_redirect.be_is_theme_valid !== 'undefined' && be_redirect.be_is_theme_valid=="0"){
			//Modify Plugin update links
            var theme_url = be_redirect.theme_url;
			var check_plugin = ['#be-gdpr-update','#be-grid-update','#tatsu-update','#typehub-update','#colorhub-update','#exponent-demos-update','#exponent-modules-update','#be-portfolio-post-update'];
			check_plugin.forEach(function(beplugin){
				if($(beplugin).length){
					var text = $(beplugin).text();
					$(beplugin).find('.update-message').html('<p><a href="'+theme_url+'">'+text+'</a></p>');
				};
			});

			//Remove install plugin links from admin notice
			if($('#setting-error-tgmpa').length){
				$('#setting-error-tgmpa p span').last().remove();
			}
        }
    }
    $(document).on( 'ready', function() {
    	go_to();
		be_can_update_plugin();
    });
})(jQuery);
