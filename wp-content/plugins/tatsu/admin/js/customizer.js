jQuery(function($){
    "use strict";

    //multi select drop down control
    $('.customize-control-semantic').each(function(){
		$(this).chosen({width : '96%'});
	});
	$(".customize-control-semantic").on('change', function(e) {
        var updatedValue = '';
        if( $(this).val() ) {
            updatedValue = $(this).val().join(',');
        }
		$(this).parent().find('.customize-control-dropdown-semantic').val( updatedValue ).trigger('change');
	});
});