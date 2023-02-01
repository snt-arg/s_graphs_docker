(function ($) {
    "use strict";

    var import_log = '',
        data = [],
        curPurchaseCode = '',
        windHref = window.location.href;

    function admin_tabs() {
        var target;
        $('.nav-tab-wrapper').find('a').each(function () {
            $(this).on('click', function (e) {
                e.preventDefault();
                target = $(this).data('tab');
                $('.nav-tab-wrapper').find('a.nav-tab-active').removeClass('nav-tab-active');
                $(this).addClass('nav-tab-active');
                $('.nav-content.current').removeClass('current');
                $('#' + target + '').addClass('current');
                return false;
            })
        })
    }

    function add_or_remove_loading_class(long, target) {
        if (typeof target === 'undefined') {
            target = $('.loader');
        }

        if (target.hasClass('loading')) {
            target.removeClass('loading');
        } else {
            target.addClass('loading');

        }
    }

    function copy_system_status() {
        var stat_text = $('.be-system-status').text();
        var clipboard = new ClipboardJS(document.querySelectorAll('#be-copy-status'), {
            text: function () {
                return stat_text;
            }
        });
        $('#be-copy-status').on('click', function (e) {
            e.preventDefault();
            $.confirm({
                title: 'Copied !',
                theme: 'modern',
                content: 'You can paste them in new text file or send them directly to the support team',
                buttons: {
                    log: {
                        text: 'Ok',
                        btnClass: 'btn-green',
                        keys: ['enter', 'shift'],
                    },
                }
            });
        })

    }

    function tabs_url_navigation() {
        var tab;
        if (window.location.hash) {
            tab = window.location.hash;
            tab = tab.replace('#', '');
            go_to_tab(tab);
        }
    }

    function form_token_check() {
        $('#tatsu_pro_start_updater').on( 'submit', function (e) {
            e.preventDefault();
            var token_field = $('#be_purchase_code').val(),
            security = $('#purchase_nonce').val();
            var newsletterEmail = $('#be-newsletter-email').val();
            if( token_field === curPurchaseCode ) {
                // $('.token_check').html($('<div class="notic notic-warning ">No Changes have been made</div>'));
                // return;
            }
                $('.token_check').html($('<div class="notic notic-warning ">Please wait ...</div>'));
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'tatsu_save_license_key',
                    tatsu_license_key: token_field,
                    security: security,
                    email: newsletterEmail
                },
                success: function (response) {
                    if(response) {console.log("respo",response);
                        cachePurchaseCode(token_field);
                        $('.token_check').html(response.msg);  
                        if(response.res){
                            setTimeout(function() {
                                window.location.reload();
                            },1500);
                        }  
                    }else {
                        $('.token_check').html($('<div class="notic notic-warning ">Unable to save license key</div>'));
                    }
                },
                error : function(response) {
                    $('.token_check').html($('<div class="notic notic-warning ">Unable to save license key</div>'));
                }
            })
        });

        $('#be-newsletter-form').on( 'submit', function (e) {
            e.preventDefault();
            var newsletterEmail = $('#be-newsletter-email').val(),
                security = $('#be-newsletter-email-nonce').val();
            $('.be-newsletter-submit-wrap').addClass('loading');
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'be_newsletter_subscribe',
                    email: newsletterEmail,
                    security: security,
                    list_name: 'Tatsu Subscribers',
                },
                success: function (response) {
                    $('.be-newsletter-submit-wrap').removeClass('loading');
                    $('.token_check').html(response);
                }
            })
        });

    }

    function tatsu_ajax_handle(demo, action, loader, next) {
        $.ajax({
            url: ajaxurl,

            type: 'POST',
            data: {
                action: action,
                'exp-demo': demo,
            },
            beforeSend: function () {
                $(loader).removeClass('click');
                $(loader).addClass('loading');
            },
            success: function (resp) {
                $(loader).removeClass('loading');
                $(loader).addClass('done');
                $(loader).addClass('click');
                if ('function' === typeof next(resp)) {
                    next(resp);
                }
            },
        }).done(function () {
            if ($('.be_demo_content').find('li.loading').length === 0) {
                $('#tatsu_import_form').removeClass('disabled');
                $('#tatsu_import_form').find('input[type="submit"]').prop('disabled', false);
                $('.be_demo_content li').removeClass('done');
                $('.be_demo_content li').removeClass('click');
                check_selected_data();
                $.confirm({
                    title: '<span style="color:green;font-size:180px;width:180px;height:180px;" class="dashicons dashicons-smiley"></span><div style="margin-top:15px;">Import completed successfully</div>',
                    theme: 'modern',
                    content: '',
                    onOpen: function () {
                        new ClipboardJS(document.querySelectorAll('.copy-log'), {
                            text: function () {
                                return import_log;
                            }
                        });
                    },
                    buttons: {
                        view_site: {
                            text: 'View Site',
                            btnClass: 'btn-green',
                            keys: ['enter'],
                            action: function () {
                                window.open($('#tatsu-home-url').html(), '_blank');
                                return false;
                            }
                        },
                        log: {
                            text: 'Copy Import Log',
                            btnClass: 'btn-orange copy-log',
                            action: function () {
                                $('.jconfirm-content-pane div').html("Import Log copied to clipboard");
                                return false;
                            }
                        },
                        cancel: {
                            text: 'Close',
                            keys: ['space'],
                        }


                    }
                });
            }
        })
    }

    function form_installer() {
        $('#tatsu_import_form').on( 'submit', function (e) {
            data = [];
            var demo = $('select[name="be_demo_file"]').val(),
                ajaxSlug = 'tatsu',
                dataSize, selc, el,
                current = 0;
            add_or_remove_loading_class(true, $(''));

            $('.be_demo_content').find('li').each(function () {
                if ($(this).hasClass('click')) {
                    data.push($(this).data('value'));
                }
            })
            $('#tatsu_import_form').addClass('disabled');
            $('#tatsu_import_form').find('input[type="submit"]').prop('disabled', true);
            dataSize = data.length;
            import_log = '';
            if (dataSize > 0) {
                selc = data[dataSize - dataSize];
                el = $('.be_demo_content').find('[data-value="' + selc + '"]');
                tatsu_ajax_handle(demo, ajaxSlug + '_' + selc, el, function (resp2) {
                    current = current + 1;
                    import_log += resp2 + "\n";
                    if (dataSize >= 2) {
                        selc = data[current];
                        el = $('.be_demo_content').find('[data-value="' + selc + '"]');;
                        tatsu_ajax_handle(demo, ajaxSlug + '_' + selc, el, function (resp3) {
                            current = current + 1;
                            import_log += resp3 + "\n";
                            if (dataSize >= 3) {
                                selc = data[current];
                                el = $('.be_demo_content').find('[data-value="' + selc + '"]');
                                tatsu_ajax_handle(demo, ajaxSlug + '_' + selc, el, function (resp4) {
                                    current = current + 1;
                                    import_log += resp4 + "\n";
                                    if (dataSize >= 4) {
                                        selc = data[current];
                                        el = $('.be_demo_content').find('[data-value="' + selc + '"]');
                                        tatsu_ajax_handle(demo, ajaxSlug + '_' + selc, el, function (resp5) {
                                            current = current + 1;
                                            import_log += resp5 + "\n";
                                            if (dataSize >= 5) {
                                                selc = data[current];
                                                el = $('.be_demo_content').find('[data-value="' + selc + '"]');
                                                tatsu_ajax_handle(demo, ajaxSlug + '_' + selc, el, function (resp6) {
                                                    current = current + 1;
                                                    import_log += resp6 + "\n";
                                                    if (dataSize >= 6) {
                                                        selc = data[current];
                                                        el = $('.be_demo_content').find('[data-value="' + selc + '"]');
                                                        tatsu_ajax_handle(demo, ajaxSlug + '_' + selc, el, function (resp7) {
                                                            current = current + 1;
                                                            import_log += resp7 + "\n";
                                                            if (dataSize >= 7) {
                                                                selc = data[current];
                                                                el = $('.be_demo_content').find('[data-value="' + selc + '"]');
                                                                tatsu_ajax_handle(demo, ajaxSlug + '_' + selc, el, function (resp8) {
                                                                    import_log += resp8 + "\n";
                                                                    
                                                                });
                                                            }
                                                        });
                                                    }

                                                });
                                            }
                                        })
                                    }
                                })
                            }
                        })
                    }
                })

            } else {
                alret_message('Please select at least one content !', 'Ok', false);
            }
            e.preventDefault();
        });
    }

    function cachePurchaseCode(code) {
        code = code || $('#be_purchase_code').val();
        curPurchaseCode = code;
    }

    function alret_message(message, confirmtext, submitform) {
        return $.confirm({
            title: '<span style="color:ORANGE;font-size:34px;" class="dashicons dashicons-info"></span>',
            theme: 'modern',
            content: message,
            buttons: {
                confirm: {
                    text: confirmtext,
                    btnClass: 'btn-green',
                    keys: ['enter', 'space'],
                    action: function () {
                        if (submitform) {
                            $('#tatsu_import_form').submit();
                        }
                    }
                },
                cancel: function () {

                },

            }
        });
    }

    function check_import_requires_plugins() {
        var message;

        $('#tatsu_import_form').find('.panel-save').on('click', function (e) {
            e.preventDefault();
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'tatsu_require_plugins',
                    'exp-demo': $('select[name="be_demo_file"]').val(),
                },
                success: function (respo) {
                    var ret = $.parseJSON(respo);
                    if (ret.stat === "0") {
                        message = "The selected demo requires the following plugins <strong>" + ret.plugins.toString() + "</strong> without them, some of the content may not get imported.";

                        alret_message(message, 'I understand, keep importing', true);
                    } else {
                        message = "If you choose to import Options Panel data, please note that your existing Customizer, ColorHub & Global Section settings will be overwritten. If this is the first time you are importing a demo, you don't have to worry. But if you have already customized the settings, then it may be wise to take a backup of your options before proceeding."
                        alret_message(message, 'Yes', true);
                    }

                }
            })


        })

    }

    function get_selected_data() {
        var data = [];
        $('.be_demo_content').find('li').each(function () {
            if ($(this).hasClass('click')) {
                data.push($(this).data('value'));
            }
        });
        return data;
    }

    function tab_hash(hash) {
        var foundhash = windHref.match('#'),
            newhash;
        if (null !== foundhash && foundhash[0] != '') {
            newhash = windHref.replace(/#(.*)/, '#' + hash);
            window.location.href = newhash;
        } else {
            window.location.href = windHref + '#' + hash;
        }
    }

    function go_to_tab(goTO) {
        if($('.be-start-header').length) {
            return false;
        }
        if (typeof goTO !== 'undefined') {
            $('.nav-tab-wrapper').find('.nav-tab-active').removeClass('nav-tab-active');
            $('.nav-tab-wrapper').find('a[data-tab="' + goTO + '"]').addClass('nav-tab-active');
            $('.nav-content.current').removeClass('current');
            $('#' + goTO + '').addClass('current');
            tab_hash(goTO);
        } else {
            var goTO;
        }

        $('a[data-tab]').each(function () {
            if ($(this).data('tab') !== 'undefined') {
                $(this).on('click', function (e) {
                    e.preventDefault();
                    window.scrollTo(0, 0);
                    goTO = $(this).data('tab');
                    $('.nav-tab-wrapper').find('.nav-tab-active').removeClass('nav-tab-active');
                    $('.nav-tab-wrapper').find('a[data-tab="' + goTO + '"]').addClass('nav-tab-active');
                    $('.nav-content.current').removeClass('current');
                    $('#' + goTO + '').addClass('current');
                    tab_hash(goTO);
                })
            }
        })
    }

    function fix_button() {
        $('.fix-button').on('click', function (e) {
            e.preventDefault();
            add_or_remove_loading_class();
            var action = $(this).data('action');
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'BS_set_memory'
                },
                success: function (res) {

                    add_or_remove_loading_class();
                },
                fail: function (jqXHR, textStatus) {
                    add_or_remove_loading_class();
                    alert("Request failed: " + textStatus);
                }
            })
        })
    }

    function check_selected_data() {
        if ($('.be_demo_content').find('li.click').length === 0) {
            $('#tatsu_import_form').find('input[type="submit"]').prop('disabled', true);
        } else {
            $('#tatsu_import_form').find('input[type="submit"]').prop('disabled', false);
        }

    }

    function radio_list() {
        $('#tatsu_import_form .radio-list').find('li').each(function () {

            $(this).on('click', function () {
                var that = $(this);
                if (!$('#tatsu_import_form').hasClass('disabled')) {
                    if (that.hasClass('disable')) {
                        that.removeClass('click');
                    } else {
                        that.toggleClass('click');
                    }
                }
                check_selected_data();
            })
        })
    }

    function available_settings() {
        var $selected = $('select[name="be_demo_file"]').val(),
            options = $('select[name="be_demo_file"]').find('option[value="' + $selected + '"]');
        if ( 0 === options.length) {
            $('#tatsu_import_form').addClass('disabled');
            return;
        } else {
            $('#tatsu_import_form').removeClass('disabled');
        }
        var settings = options.data('settings');
        if($('.demo_content').hasClass('click')){
            add_demo_import_button_to_image_picker();
        }
        if (settings.home_page) {
            $('.home_page').removeClass('disable');
            $('#tatsu_import_form .home_page').addClass('click');
        } else {
            $('.home_page').addClass('disable');
            $('.home_page').removeClass('click');
        }
        
        if (settings.typehub_option) {
            $('.typehub_options').removeClass('disable');
            $('#tatsu_import_form .typehub_options').addClass('click');
        } else {
            $('.typehub_options').addClass('disable');
            $('.typehub_options').removeClass('click');
        }

        if (settings.tatsu_global_section_option) {
            $('.tatsu_global_sections').removeClass('disable');
            $('#tatsu_import_form .tatsu_global_sections').addClass('click');
        } else {
            $('.tatsu_global_sections').addClass('disable');
            $('.tatsu_global_sections').removeClass('click');
        }

        if (settings.slider_data) {
            $('.slider').removeClass('disable');
            $('#tatsu_import_form .slider').addClass('click');
        } else {
            $('.slider').addClass('disable');
            $('.slider').removeClass('click');
        }

        if (settings.theme_option) {
            $('.theme_options').removeClass('disable');
            $('#tatsu_import_form .theme_options').addClass('click');
        } else {
            $('.theme_options').addClass('disable');
            $('.theme_options').removeClass('click');
        }
        if (settings.widgets) {
            $('.widgets').removeClass('disable');
            $('#tatsu_import_form .widgets').addClass('click');
        } else {
            $('.widgets').addClass('disable');
            $('.widgets').removeClass('click');
        }

        if (settings.content) {
            $('.demo_content').removeClass('disable');
            $('#tatsu_import_form .demo_content').addClass('click');
        } else {
            $('.demo_content').addClass('disable');
            $('.demo_content').removeClass('click');
        }

    }

    function tatsu_import_form_submit(){
        $(document).on('click','.import-data-button',function(){
            if(!$(this).hasClass('tatsu-pro-link')){
            var demo_submit_button = $('#tatsu_import_form').find('input[type="submit"]');
            demo_submit_button.prop('disabled', false);
            demo_submit_button.click();
            }
        });
    }

    function add_demo_import_button_to_image_picker(){
        if(!$('#tatsu_import_form .image_picker_selector').hasClass('submit-button-added')){
            var image_picker_thumbnail = $('#tatsu_import_form .image_picker_selector .thumbnail');
            if(0<image_picker_thumbnail.length){
                image_picker_thumbnail.each(function(){
                    var demo_name = $(this).find('p').text();
                    console.log(demo_name);
                    var button_html = '<div class="middle"><div class="import-data-button">Import Data</div></div>';
                    if(typeof demo_name !== 'undefined' && demo_name != null && demo_name.indexOf('PRO')>=0){
                        button_html = '<div class="middle"><a href="'+tatsuAdminConfigStartPage.tatsu_pro_url+'" target="_blank"><div class="import-data-button tatsu-pro-link">Go Pro</div></a></div>';
                    }
                    $(this).append(button_html);
                });
                $('#tatsu_import_form .image_picker_selector').addClass('submit-button-added');
            }else{
                console.log('no length');
            }
        }
    }

    $.fn.fixedSidebar = function (target, areaRight, areaLeft) {
        var $scrollValue,
            $mainArea = $(this).find(areaLeft),
            $fixedArea = $(this).find(areaRight);
        if (!$(this).length || $(window).width() <= 1024) {
            $fixedArea.attr('style', '');
            return false;
        }
        $(window).on( 'scroll', function () {
            $scrollValue = $(window).scrollTop();
            if ($scrollValue >= $mainArea.offset().top) {
                $fixedArea.css({
                    'position': 'relative',
                    'top': $scrollValue - $mainArea.offset().top + 30
                });
            } else {
                $fixedArea.attr('style', '');
            }
        });
    }

    function be_admin_accordion(){
        var acc = document.getElementsByClassName("be-admin-accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            /* Toggle between hiding and showing the active panel */
            var panel = this.nextElementSibling;
            if(panel.style.maxHeight){
                panel.style.maxHeight = null;
            }else{
                panel.style.maxHeight = panel.scrollHeight + "px";
            }
        });
        }
    }

    $(document).on( 'ready', function () {
        cachePurchaseCode();
        check_import_requires_plugins();
        form_token_check();
        admin_tabs();
        form_installer();
        radio_list();
        fix_button();
        go_to_tab();
        tabs_url_navigation();
        copy_system_status();
        check_selected_data();
        available_settings();
        tatsu_import_form_submit();
        be_admin_accordion();
        $('#tatsu_import_form').fixedSidebar('.content', '.content', '.c-12');
        $("select.image-picker").imagepicker({
            show_label: true,
            selected: function (select, picker, event) {
                available_settings();
            }
        })
    })

})(jQuery);
