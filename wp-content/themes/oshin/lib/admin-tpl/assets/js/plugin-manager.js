var EnvatoWizard = (function($){

    var t;

    // callbacks from form button clicks.
    var callbacks = {
        install_plugins: function(btn){
            var plugins = new PluginManager();
            plugins.init(btn);
        },
    };

    function window_loaded(){
        $('#handle-plugins').click(function(e){
        	e.preventDefault();
        	if($(this).data('callback') && typeof callbacks[$(this).data('callback')] != 'undefined'){
                // we have to process a callback before continue with form submission
                callbacks[$(this).data('callback')](this);
                $(this).prop('disabled', true);
                return false;
            }
        })
    }

	function PluginManager(){

        var complete;
        var items_completed = 0;
        var current_item = '';
        var $current_node;
        var current_item_hash = '';

        function ajax_callback(response){
        	
            if(typeof response == 'object' && typeof response.message != 'undefined'){
                if(response.message === 'Success') {
                    $current_node.find('span').first().addClass('green');
                    $current_node.find('.checkmark').first().addClass('green');
                }
                $current_node.find('span').first().text(response.message);
                $current_node.find('.loader').addClass('loading');
                if(typeof response.url != 'undefined'){
                    // we have an ajax url action to perform.

                    if(response.hash == current_item_hash){
                        $current_node.find('span').text("failed");
                        find_next();
                    }else {
                        current_item_hash = response.hash;
                        jQuery.post(response.url, response, function(response2) {
                            process_current();
                            
                            $current_node.find('span').first().text(response.message + envato_setup_params.verify_text);
                        }).fail(ajax_callback);
                    }

                }else if(typeof response.done != 'undefined'){
                    // finished processing this plugin, move onto next
                    find_next();
                }else{
                    // error processing this plugin
                    find_next();
                }
            }else{
                // error - try again with next plugin
                $current_node.find('span').text("ajax error");
                find_next();
            }
        }
        function process_current(){
            if(current_item){
                // query our ajax handler to get the ajax to send to TGM
                // if we don't get a reply we can assume everything worked and continue onto the next one.
                jQuery.post(envato_setup_params.ajaxurl, {
                    action: 'be_handle_plugins',
                    wpnonce: envato_setup_params.wpnonce,
                    slug: current_item
                }, function(e){
                	ajax_callback(e);
                	
                }).fail(ajax_callback);
            }
        }
        function find_next(){
            var do_next = false;
            if($current_node){
                if(!$current_node.data('done_item')){
                    items_completed++;
                    $current_node.data('done_item',1);
                }
                $current_node.find('.loader').removeClass('loading');
            }
            var $li = $('.envato-wizard-plugins li');
            $li.each(function(){
                if(current_item == '' || do_next){
                    current_item = $(this).data('slug');
                    $current_node = $(this);
                    process_current();
                    do_next = false;
                }else if($(this).data('slug') == current_item){
                    do_next = true;
                }
            });
            if(items_completed >= $li.length){
                // finished all plugins!
                complete();
            }
        }
        
        return {
            init: function(btn){
                $('.envato-wizard-plugins').addClass('installing');
                complete = function(){
                    var href = window.location.href;
                    href = href.split( '#' )[0];
                    window.location.href = href+'#be-plugins';
                    location.reload();
                };
                find_next();
            }
        }
    }
    return {
        init: function(){
            t = this;
            $(window_loaded);
        }
    }
})(jQuery);

EnvatoWizard.init();