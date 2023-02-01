/* Master Slider plugin for tinymce */

( function () {

    // skip if sliders list is not available
    if( ! __MS_EDITOR || ! __MS_EDITOR.sliders )
        return;


    tinymce.PluginManager.add( 'msp_shortcodes_button', function( editor, url ) {

        var menu_items = [],
            item_label;

        for ( slider_alias in __MS_EDITOR.sliders ) {
            item_label = __MS_EDITOR.sliders[ slider_alias ] + " [#" + slider_alias + "]";
            menu_items.push( { text: item_label, value: slider_alias } );
        };


        var ed = tinymce.activeEditor;
        editor.addButton( 'msp_shortcodes_button', {
            text: false,
            icon: false,
            title:__MS_GLOBAL.plugin_name,
            type: 'menubutton',
            menu: menu_items,
            onselect: function(e) {
                console.log( e );
                var slider_alias = e.control.settings.value;
                ed.selection.setContent( '[masterslider alias="' + slider_alias + '"]' );
            }
        });
    });

})();


( function ( $ ) {

    'use strict';
    if( ! wp.mce.views ) return;

    var gallery = wp.mce.views.get( 'gallery' );

    if ( 'function' === typeof gallery ) {
        gallery = gallery.prototype;
    } else {
        gallery = gallery.View.prototype;
    }

    // override initialize
    var superInitialize = gallery.initialize;
    gallery.initialize = function( options ) {

        // options is empty in new api
        options = options || this;

        if( options.shortcode.attrs.named.masterslider &&
            ( 'on'   === options.shortcode.attrs.named.masterslider ||
              'true' === options.shortcode.attrs.named.masterslider
            )
          ){
            options.template = wp.media.template( 'editor-master-gallery' );
        } else {
            options.template = wp.media.template( 'editor-gallery' );
        }

        superInitialize.apply( this, arguments );
    };

    /* ------------------------------------------------------------------------------ */
    // old version
    return;

    wp.mce.views.unregister( 'gallery' );

    var views = {},
        instances = {},
        media = wp.media,
        viewOptions = ['encodedText'],
        newAPI = 'getContent' in wp.mce.View.prototype;


    // New gallery view object
    var view = {

        // The fallback post ID to use as a parent for galleries that don't
        // specify the `ids` or `include` parameters.
        //
        // Uses the hidden input on the edit posts page by default.
        postID: $('#post_ID').val(),

        initialize: function( options ) {

            // options is empty in new api
            options = options || this;

            if( options.shortcode.attrs.named.masterslider &&
                ( 'on'   === options.shortcode.attrs.named.masterslider ||
                  'true' === options.shortcode.attrs.named.masterslider
                )
              ){
                this.template = media.template( 'editor-master-gallery' );
            } else {
                this.template = media.template( 'editor-gallery' );
            }

            this.shortcode = options.shortcode;
            this.fetch();
        },

        fetch: function() {
            var self = this;

            this.attachments = wp.media.gallery.attachments( this.shortcode, this.postID );
            this.dfd = this.attachments.more().done( function() {
                self.render( true );
            } );
        }

    };

    view[(newAPI ? 'getContent' : 'getHtml')] = function() {

        var attrs = this.shortcode.attrs.named,
            attachments = false,
            options;

        // Don't render errors while still fetching attachments
        if ( this.dfd && 'pending' === this.dfd.state() && ! this.attachments.length ) {
            return '';
        }

        if ( this.attachments.length ) {
            attachments = this.attachments.toJSON();

            _.each( attachments, function( attachment ) {
                if ( attachment.sizes ) {
                    if ( attachment.sizes.thumbnail ) {
                        attachment.thumbnail = attachment.sizes.thumbnail;
                    } else if ( attachment.sizes.full ) {
                        attachment.thumbnail = attachment.sizes.full;
                    }
                }
            } );
        }

        options = {
            attachments: attachments,
            columns: attrs.columns ? parseInt( attrs.columns, 10 ) : wp.media.galleryDefaults.columns
        };

        this.content = this.template( options );

        return this.content;
    };

    if ( newAPI ) {
        view.edit = function( text, update ) {
            var gallery = wp.media.gallery,
                frame = gallery.edit( text );

            frame.state( 'gallery-edit' ).on( 'update', function( selection ) {
                update( gallery.shortcode( selection ).string() );
            } );

            frame.on( 'close', function() {
                frame.detach();
            });
        };

        wp.mce.views.register( 'gallery', view);

    } else {
        wp.mce.views.register( 'gallery', {
            View: view,
            edit: function( node ) {
                var gallery = wp.media.gallery,
                    self = this,
                    frame, data;

                data = window.decodeURIComponent( $( node ).attr('data-wpview-text') );
                frame = gallery.edit( data );

                frame.state('gallery-edit').on( 'update', function( selection ) {
                    var shortcode = gallery.shortcode( selection ).string();
                    $( node ).attr( 'data-wpview-text', window.encodeURIComponent( shortcode ) );
                    wp.mce.views.refreshView( self, shortcode );
                });

                frame.on( 'close', function() {
                    frame.detach();
                });
            }
        });
    }

})( jQuery );



/**
 * Master Slider Gallery Settings
 */
(function($) {

    var media = wp.media,

        masterDefaults = {
            'masterslider':false, 'loop':false, 'autoplay':false,
            'thumbs':true, 'thumbs_align':'bottom', 'skin':'ms-skin-default',
            'class':'', 'caption':true, 'auto_height':false
        };

    var superRender = media.view.Settings.Gallery.prototype.render;
    media.view.Settings.Gallery = media.view.Settings.Gallery.extend({

        render: function() {
            var $el = this.$el,
                setting_val;

            if ( superRender ) {
                superRender.apply(this, arguments );
            } else {
                media.view.Settings.prototype.render.apply( this, arguments );
            }

            // Append masterslider template (gallery-master-settings) and update the settings.
            $el.append( media.template( 'gallery-master-settings' ) );

            for( var msOpt in masterDefaults ){

                $setting = $el.find( '.msas-gallery-' + msOpt +' [data-setting]' );
                setting_val = ( typeof this.model.attributes[msOpt] != 'undefined' ) ? this.model.attributes[msOpt] : masterDefaults[msOpt];

                if ( $setting.is('input[type="checkbox"]') ) {
                    $setting.prop('checked', setting_val );
                } else {
                    $setting.val( setting_val );
                }
            }

            this.toggleMasterOptions();

            return this;
        },


        toggleMasterOptions: function(){
            var $el = this.$el,
                $ms_options = $el.find( '.msas-toggle' ),
                is_master_enabled = ( typeof this.model.attributes.masterslider != 'undefined' ) ? this.model.attributes.masterslider : media.gallery.defaults.masterslider;

            if( ! is_master_enabled ) {
                setTimeout( function(){ $ms_options.hide(1); }, 10 );
            }

            $el.find( '.msas-gallery-masterslider' ).on( 'click', '[data-setting]', function () {
                this.checked ? $ms_options.show(1) : $ms_options.hide(1);
            });
        },


        updateHandler: function() {
            media.view.Settings.prototype.updateHandler.apply( this, arguments );
        },


        initialize: function() {
            media.view.Settings.prototype.initialize.apply( this, arguments );
            var masterOptions = [];

            for( var msOpt in masterDefaults ){
                media.gallery.defaults[msOpt] = masterOptions[msOpt];
                masterOptions.push( msOpt );
            }

            this.update.apply( this, masterOptions );
        }

    });

})(jQuery);
