/**
 * This file contains js functions for the teachpress tinyMCE plugin.
 * 
 * @package teachpress
 * @subpackage js
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPLv2 or later
 */

(function() {
    /**
     * A JavaScript equivalent of PHP’s stripslashes
     * Source: http://phpjs.org/functions/stripslashes/
     * @param {string} str
     * @returns {string} 
     * @since 5.0.0
     */
    function tp_stripslashes(str) {
        return (str + '')
          .replace(/\\(.?)/g, function(s, n1) {
            switch (n1) {
              case '\\':
                return '\\';
              case '0':
                return '\u0000';
              case '':
                return '';
              default:
                return n1;
            }
          });
    }
    
    /**
     * Gets a cookie
     * @param {string} cname    The name of the cookie
     * @returns {string}        The value of the cookie
     * @since 5.0.0
     */
    function tp_getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i=0; i<ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0)===' ') c = c.substring(1);
            if (c.indexOf(name) !== -1) return c.substring(name.length, c.length);
        }
        return "";
    }
    
    /**
     * Sets a cookie
     * @param {string} cname            The name of the cookie
     * @param {string} cvalue           The value of the cookie
     * @param {int} exdays              The number of days, where the cookie will be expire
     * @since 5.0.0
     */
    function tp_setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + "; " + expires + "; path=" + teachpress_cookie_path;
    }
    
    /**
     * teachPress tinyMCE Plugin
     * @since 5.0.0
     */
    tinymce.PluginManager.add('teachpress_tinymce', function( editor, url ) {
        editor.addButton( 'teachpress_tinymce', {
            text: 'teachPress',
            icon: false,
            type: 'menubutton',
            menu: [
                {
                    text: 'Add document',
                    onclick: function() {
                        
                        editor.windowManager.open( {
                            url: teachpress_editor_url,
                            title: 'teachPress Document Manager',
                            id: 'tp_document_manager',
                            inline: 1,
                            width: 950,
                            height: 560,
                            buttons: [
                            
                            {
                                text: 'Insert',
                                onclick: function(){
                                    
                                    // read cookie
                                    var data_store = tp_getCookie("teachpress_data_store");
                                    
                                    // build insert string
                                    // alert(data_store);
                                    var insert = '';
                                    var data = data_store.split(":::");
                                    var length = data.length;
                                    for ( var i = 0; i < length; i++ ) {
                                        if ( data[i] === "") {
                                            continue;
                                        }
                                        data[i] = data[i].replace('[','');
                                        data[i] = data[i].replace(']','');
                                        // console.log(data[i]);
                                        var data_single = data[i].split(",");
                                        var file_name = '', file_url = '';
                                        for ( var j = 0; j < 2; j++ ) {
                                            var data_inline = data_single[j].split(" = ");
                                            data_inline[1] = data_inline[1].replace('{"','');
                                            data_inline[1] = data_inline[1].replace('"}','');
                                            if ( j === 0 ) {
                                                file_name = data_inline[1];
                                            }
                                            if ( j === 1 ) {
                                                file_url = data_inline[1];
                                            }
                                            // console.log(data_inline[1]);
                                            
                                        }
                                        insert = insert + '<a class="' + teachpress_file_link_css_class + '" href="' + file_url + '">' + tp_stripslashes(file_name) + '</a> ';
                                        // console.log(insert);
                                    }
                                    
                                    // insert into editor
                                    editor.insertContent(insert);
                                    editor.windowManager.close();
                                    
                                    // reset cookie
                                    tp_setCookie("teachpress_data_store", "", 1);
                                }
                            },
                            {
                                text: 'Close',
                                onclick: function () {
                                    editor.windowManager.close();
                                    tp_setCookie("teachpress_data_store", "", 1);
                                }
                            }
                                
                        ]
                        });
                    }
                },
                {
                    text: 'Insert shortcode (courses)',
                    menu: [
                        
                        // [tpcourselist]
                        
                        {
                            text: 'List of courses [tpcourselist]',
                            onclick: function() {
                                editor.windowManager.open( {
                                    title: 'Insert a list of courses [tpcourselist]',
                                    body: [
                                        {
                                            type: 'listbox',
                                            name: 'tp_image',
                                            label: 'Show images',
                                            'values': [
                                                {text: 'none', value: 'none'},
                                                {text: 'left', value: 'left'},
                                                {text: 'right', value: 'right'},
                                                {text: 'bottom', value: 'bottom'}
                                            ]
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'tp_size',
                                            label: 'Image size in px',
                                            value: '0'
                                        },
                                        {
                                            type: 'listbox',
                                            name: 'tp_headline',
                                            label: 'Show headline',
                                            'values': [
                                                {text: 'show', value: '1'},
                                                {text: 'hide', value: '0'}
                                            ]
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'tp_text',
                                            label: 'Custom text under the headline',
                                            value: '',
                                            multiline: true,
                                            minWidth: 300,
                                            minHeight: 100
                                        },
                                        {
                                            type: 'listbox',
                                            name: 'tp_term',
                                            label: 'Term',
                                            'values': teachpress_semester // is written with tp_write_data_for_tinymce()
                                        }
                                    ],
                                    onsubmit: function( e ) {
                                        var image = e.data.tp_image;
                                        var image_size = e.data.tp_size;
                                        var headline = e.data.tp_headline;
                                        var text = e.data.tp_text;
                                        var term = e.data.tp_term;
                                        
                                        image = (image === 'none') ? '' : 'image="' + image + '"';
                                        image_size = (image_size === '0') ? '' : 'image_size="' + image_size + '"';
                                        headline = (headline === '1') ? '' : 'headline="' + headline + '"';
                                        text = (text === '') ? '' : 'text="' + text + '"';
                                        term = (term === '') ? '' : 'term="' + term + '"';
                                        
                                        editor.insertContent( '[tpcourselist ' + image + ' ' + image_size + ' ' + headline + ' ' + text + ' ' + term + ']');
                                    }
                                });
                            }
                        },
                        
                        // [tpcoursedocs]
                        
                        {
                            text: 'Course documents [tpcoursedocs]',
                            onclick: function() {
                                editor.windowManager.open( {
                                    title: 'Insert a list of course documents [tpcoursedocs]',
                                    body: [
                                        {
                                            type: 'listbox',
                                            name: 'tp_coure_id',
                                            label: 'Select course',
                                            minWidth: 570,
                                            'values': teachpress_courses //  is written by tp_write_data_for_tinymce()
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'tp_link_class',
                                            label: 'CSS class for links',
                                            value: teachpress_file_link_css_class // is written by tp_write_data_for_tinymce()
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'tp_date_format',
                                            label: 'Date format',
                                            value: 'd.m.Y'
                                        },
                                        {
                                            type: 'listbox',
                                            name: 'tp_show_date',
                                            label: 'Show upload date for documents',
                                            'values': [
                                                {text: 'Yes', value: '1'},
                                                {text: 'No', value: '0'}
                                            ]
                                        },
                                        {
                                            type: 'listbox',
                                            name: 'tp_numbered',
                                            label: 'Use a numbered list',
                                            'values': [
                                                {text: 'Yes', value: '1'},
                                                {text: 'No', value: '0'}
                                            ]
                                        },
                                        {
                                            type: 'listbox',
                                            name: 'tp_headline',
                                            label: 'Show headline',
                                            'values': [
                                                {text: 'Yes', value: '1'},
                                                {text: 'No', value: '0'}
                                            ]
                                        }
                                    ],
                                    onsubmit: function( e ) {
                                        var id = e.data.tp_coure_id;
                                        var link_class = e.data.tp_link_class;
                                        var date_format = e.data.tp_date_format;
                                        var show_date = e.data.tp_show_date;
                                        var numbered = e.data.tp_numbered;
                                        var headline = e.data.tp_headline;
                                        
                                        id = (id === '0') ? '' : 'id="' + id + '"';
                                        link_class = (link_class === teachpress_file_link_css_class) ? '' : 'link_class="' + link_class + '"';
                                        date_format = (date_format === 'd.m.Y') ? '' : 'date_format="' + date_format + '"';
                                        show_date = (show_date === '1') ? '' : 'show_date="' + show_date + '"';
                                        numbered = (numbered === '1') ? '' : 'numbered="' + numbered + '"';
                                        headline = (headline === '1') ? '' : 'headline="' + headline + '"';
                                        
                                        editor.insertContent( '[tpcoursedocs ' + id + ' ' + link_class + ' ' + date_format + ' ' + show_date + ' ' + numbered + ' ' + headline + ']');
                                    }
                                });
                            }
                        },
                        
                        // [tpcourseinfo]
                        
                        {
                            text: 'Course information [tpcourseinfo]',
                            onclick: function() {                     
                                editor.windowManager.open( {
                                    title: 'Insert course information [tpcourseinfo]',
                                    body: [
                                        {
                                            type: 'listbox',
                                            name: 'tp_coure_id',
                                            label: 'Select course',
                                            minWidth: 570,
                                            'values': teachpress_courses // is written by tp_write_data_for_tinymce()
                                        },
                                        {
                                            type: 'listbox',
                                            name: 'tp_show_meta',
                                            label: 'Show meta data',
                                            'values': [
                                                {text: 'Yes', value: '1'},
                                                {text: 'No', value: '0'}
                                            ]
                                        }
                                    ],
                                    onsubmit: function( e ) {
                                        var id = e.data.tp_coure_id;
                                        var show_meta = e.data.tp_show_meta;
                                        
                                        id = (id === '0') ? '' : 'id="' + id + '"';
                                        show_meta = (show_meta === '1') ? '' : 'show_meta="' + show_meta + '"';
                                        
                                        editor.insertContent( '[tpcourseinfo ' + id + ' ' + show_meta + ']');
                                    }
                                });
                            }
                        },
                        
                        // [tpenrollments]
                        
                        {
                            text: 'Enrollment system [tpenrollments]',
                            onclick: function() {
                                editor.windowManager.open( {
                                    title: 'Insert enrollment system [tpenrollments]',
                                    body: [
                                        {
                                            type: 'listbox',
                                            name: 'tp_term',
                                            label: 'Term',
                                            'values': teachpress_semester // is written by tp_write_data_for_tinymce()
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'tp_date_format',
                                            label: 'Date format',
                                            value: 'd.m.Y H:i'
                                        }
                                    ],
                                    onsubmit: function( e ) {
                                        var term = e.data.tp_term;
                                        var date_format = e.data.tp_date_format;
                                        
                                        term = (term === '') ? '' : 'term="' + term + '"';
                                        date_format = (date_format === 'd.m.Y H:i') ? '' : 'date_format="' + date_format + '"';
                                        
                                        editor.insertContent( '[tpenrollments ' + term + ' ' + date_format + ']');
                                    }
                                });
                            }
                        }
                    ]
                },
                {
                    text: 'Insert shortcode (publications)',
                    menu: [
                        
                        // [tplist]
                        
                        {
                            text: 'Publication list [tplist]',
                            onclick: function() {
                                var data = {};
                                editor.windowManager.open( {
                                    title: 'Insert publication list [tplist]',
                                    bodyType: 'tabpanel',
                                    body: [
                                        {
                                            title: 'Filter',
                                            type: 'form',
                                            name: 'tp_filterform',
                                            items: [
                                                {
                                                    type: 'listbox',
                                                    name: 'tp_user',
                                                    label: 'Select user',
                                                    'values': teachpress_pub_user //  is written by tp_write_data_for_tinymce()
                                                },
                                                {
                                                    type: 'listbox',
                                                    name: 'tp_filter_type',
                                                    label: 'Only entries with type',
                                                    value: null,
                                                    values: teachpress_pub_types
                                                },
                                                {
                                                    type: 'listbox',
                                                    name: 'tp_filter_tag',
                                                    label: 'Only entries with tag',
                                                    value: null,
                                                    values: teachpress_pub_tags
                                                },
                                                {
                                                    type: 'textbox',
                                                    name: 'tp_entries_per_page',
                                                    label: 'Entries per page',
                                                    value: '50'
                                                }
                                                
                                            ]
                                        },
                                        // Design box
                                        {
                                            title: 'Design',
                                            type: 'form',
                                            name: 'tp_designform',
                                            items: [
                                                {
                                                    type: 'listbox',
                                                    name: 'tp_headline',
                                                    label: 'Headline',
                                                    'values': [
                                                        {text: 'years', value: '1'},
                                                        {text: 'publication types', value: '2'},
                                                        {text: 'headlines grouped by year then by type', value: '3'},
                                                        {text: 'headlines grouped by type then by year', value: '4'},
                                                        {text: 'none', value: '0'}
                                                    ]
                                                },
                                                {
                                                    type: 'listbox',
                                                    name: 'tp_author_name',
                                                    label: 'Style of the author names',
                                                    'values': [
                                                        {text: 'last (example: van der Vaart, Ludwig)', value: 'last'},
                                                        {text: 'initials (example: van der Vaart, Ludwig C)', value: 'initials'},
                                                        {text: 'simple (example: Ludwig C. van der Vaart)', value: 'simple'},
                                                        {text: 'old (example: Vaart, Ludwig C. van der)', value: 'old'}
                                                    ]
                                                },
                                                {
                                                    type: 'listbox',
                                                    name: 'tp_editor_name',
                                                    label: 'Style of the editor names',
                                                    'values': [
                                                        {text: 'last (example: van der Vaart, Ludwig)', value: 'last'},
                                                        {text: 'initials (example: van der Vaart, Ludwig C)', value: 'initials'},
                                                        {text: 'simple (example: Ludwig C. van der Vaart)', value: 'simple'},
                                                        {text: 'old (example: Vaart, Ludwig C. van der)', value: 'old'}
                                                    ]
                                                },
                                                {
                                                    type: 'listbox',
                                                    name: 'tp_style',
                                                    label: 'Numeration of publication lists',
                                                    'values': [
                                                        {text: 'none', value: 'none'},
                                                        {text: 'numbered', value: 'numbered'},
                                                        {text: 'numbered descending', value: 'numbered_desc'}
                                                    ]
                                                },
                                                {
                                                    type: 'listbox',
                                                    name: 'tp_template',
                                                    label: 'Template',
                                                    'values': teachpress_pub_templates  //  is written by tp_write_data_for_tinymce()
                                                },
                                                {
                                                    type: 'listbox',
                                                    name: 'tp_link_style',
                                                    label: 'Style of publication links',
                                                    'values': [
                                                        {text: 'inline', value: 'inline'},
                                                        {text: 'images', value: 'images'},
                                                        {text: 'direct', value: 'direct'}
                                                    ]
                                                }
                                            ]
                                        },
                                        // Image box
                                        {
                                            title: 'Images',
                                            type: 'form',
                                            name: 'tp_imagesform',
                                            items: [
                                                {
                                                    type: 'listbox',
                                                    name: 'tp_image',
                                                    label: 'Show images',
                                                    'values': [
                                                        {text: 'none', value: 'none'},
                                                        {text: 'left', value: 'left'},
                                                        {text: 'right', value: 'right'},
                                                        {text: 'bottom', value: 'bottom'}
                                                    ]
                                                },
                                                {
                                                    type: 'textbox',
                                                    name: 'tp_image_size',
                                                    label: 'Image size in px',
                                                    value: '0'
                                                },
                                                {
                                                    type: 'listbox',
                                                    name: 'tp_image_link',
                                                    label: 'Image refers to',
                                                    'values': [
                                                        {text: 'none', value: 'none'},
                                                        {text: 'self', value: 'self'},
                                                        {text: 'post or page', value: 'post'}
                                                    ]
                                                }
                                            ]
                                        }
                                        // End Panels
                                        
                                    ],
                                    onsubmit: function( e ) {
                                        var filterData = this.find('[name=tp_filterform]')[0].toJSON();
                                        var designData = this.find('[name=tp_designform]')[0].toJSON();
                                        var imageData = this.find('[name=tp_imagesform]')[0].toJSON();
                                        
                                        var user = filterData.tp_user;
                                        var entries_per_page = filterData.tp_entries_per_page;
                                        var tag = filterData.tp_filter_tag;  
                                        var type = filterData.tp_filter_type;
                                        var headline = designData.tp_headline;
                                        var image = imageData.tp_image;
                                        var image_size = imageData.tp_image_size;
                                        var image_link = imageData.tp_image_link;
                                        var template = designData.tp_template;
                                        var author_name = designData.tp_author_name;
                                        var editor_name = designData.tp_editor_name;
                                        var style = designData.tp_style;
                                        var link_style = designData.tp_link_style;
                                        
                                        user = (user === '') ? '' : 'user="' + user + '"';
                                        entries_per_page = (entries_per_page === '50') ? '' : 'entries_per_page="' + entries_per_page + '"';
                                        tag = (tag === null) ? '' : 'tag="' + tag + '"';
                                        type = (type === '0') ? '' : 'type="' + type + '"';
                                        headline = (headline === '1') ? '' : 'headline="' + headline + '"';
                                        image = (image === 'none') ? '' : 'image="' + image + '"';
                                        image_size = (image_size === '0') ? '' : 'image_size="' + image_size + '"';
                                        image_link = (image_link === 'none') ? '' : 'image_link="' + image_link + '"';
                                        template = 'template="' + template + '"';
                                        author_name = (author_name === 'last') ? '' : 'author_name="' + author_name + '"';
                                        editor_name = (editor_name === 'last') ? '' : 'editor_name="' + editor_name + '"';
                                        style = (style === 'none') ? '' : 'style="' + style + '"';
                                        link_style = (link_style === 'inline') ? '' : 'link_style="' + link_style + '"';
                                        
                                        editor.insertContent( '[tplist ' + user + ' ' + entries_per_page + ' ' + tag + ' ' + type + ' ' + headline + ' ' + image + ' ' + image_size + ' ' + image_link + ' ' + author_name + ' ' + editor_name + ' ' + style + ' ' + template + ' ' + link_style + ']');
                                    }
                                });
                            }
                        },
                        
                        // [tpcloud]
                        
                        {
                            text: 'Publication list with tag cloud [tpcloud]',
                            onclick: function() {
                                editor.windowManager.open( {
                                    title: 'Insert publication list with tag cloud [tpcloud]',
                                    bodyType: 'tabpanel',
                                    body: [
                                        {
                                            title: 'Filter',
                                            type: 'form',
                                            name: 'tp_filterform',
                                            items: [
                                                {
                                                    type: 'listbox',
                                                    name: 'tp_user',
                                                    label: 'Select user',
                                                    'values': teachpress_pub_user // is written by tp_write_data_for_tinymce()
                                                },
                                                {
                                                    type: 'listbox',
                                                    name: 'tp_filter_type',
                                                    label: 'Only entries with type',
                                                    value: null,
                                                    values: teachpress_pub_types
                                                },
                                                {
                                                    type: 'textbox',
                                                    name: 'tp_entries_per_page',
                                                    label: 'Entries per page',
                                                    value: '50'
                                                }
                                            ]
                                            
                                        },
                                        {
                                            title: 'Design',
                                            type: 'form',
                                            name: 'tp_designform',
                                            items: [
                                                 {
                                                    type: 'listbox',
                                                    name: 'tp_headline',
                                                    label: 'Headline',
                                                    'values': [
                                                        {text: 'years', value: '1'},
                                                        {text: 'publication types', value: '2'},
                                                        {text: 'headlines grouped by year then by type', value: '3'},
                                                        {text: 'headlines grouped by type then by year', value: '4'},
                                                        {text: 'none', value: '0'}
                                                    ]
                                                },
                                                {
                                                    type: 'listbox',
                                                    name: 'tp_author_name',
                                                    label: 'Style of the author names',
                                                    'values': [
                                                        {text: 'last (example: van der Vaart, Ludwig)', value: 'last'},
                                                        {text: 'initials (example: van der Vaart, Ludwig C)', value: 'initials'},
                                                        {text: 'simple (example: Ludwig C. van der Vaart)', value: 'simple'},
                                                        {text: 'old (example: Vaart, Ludwig C. van der)', value: 'old'}
                                                    ]
                                                },
                                                {
                                                    type: 'listbox',
                                                    name: 'tp_editor_name',
                                                    label: 'Style of the editor names',
                                                    'values': [
                                                        {text: 'last (example: van der Vaart, Ludwig)', value: 'last'},
                                                        {text: 'initials (example: van der Vaart, Ludwig C)', value: 'initials'},
                                                        {text: 'simple (example: Ludwig C. van der Vaart)', value: 'simple'},
                                                        {text: 'old (example: Vaart, Ludwig C. van der)', value: 'old'}
                                                    ]
                                                },
                                                {
                                                    type: 'listbox',
                                                    name: 'tp_style',
                                                    label: 'Numeration of publication lists',
                                                    'values': [
                                                        {text: 'none', value: 'none'},
                                                        {text: 'numbered', value: 'numbered'},
                                                        {text: 'numbered descending', value: 'numbered_desc'}
                                                    ]
                                                },
                                                {
                                                    type: 'listbox',
                                                    name: 'tp_template',
                                                    label: 'Template',
                                                    'values': teachpress_pub_templates  //  is written by tp_write_data_for_tinymce()
                                                },
                                                {
                                                    type: 'listbox',
                                                    name: 'tp_link_style',
                                                    label: 'Style of publication links',
                                                    'values': [
                                                        {text: 'inline', value: 'inline'},
                                                        {text: 'images', value: 'images'},
                                                        {text: 'direct', value: 'direct'}
                                                    ]
                                                }
                                            ]
                                        },
                                        {
                                            title: 'Tag Cloud',
                                            type: 'form',
                                            name: 'tp_tagcloudform',
                                            items: [
                                                {
                                                    type: 'textbox',
                                                    name: 'tp_tag_limit',
                                                    label: 'Number of tags',
                                                    value: '30'
                                                },
                                                {
                                                    type: 'textbox',
                                                    name: 'tp_tag_minsize',
                                                    label: 'Min font size',
                                                    value: '11'
                                                },
                                                 {
                                                    type: 'textbox',
                                                    name: 'tp_tag_maxsize',
                                                    label: 'Max font size',
                                                    value: '35'
                                                },
                                                {
                                                    type: 'listbox',
                                                    name: 'tp_show_tags_as',
                                                    label: 'Show tag filter as',
                                                    'values': [
                                                        {text: 'cloud', value: 'cloud'},
                                                        {text: 'pulldown', value: 'pulldown'}
                                                    ]
                                                }
                                            ]
                                        },
                                        {
                                            title: 'Images',
                                            type: 'form',
                                            name: 'tp_imagesform',
                                            items: [
                                                {
                                                    type: 'listbox',
                                                    name: 'tp_image',
                                                    label: 'Show images',
                                                    'values': [
                                                        {text: 'none', value: 'none'},
                                                        {text: 'left', value: 'left'},
                                                        {text: 'right', value: 'right'},
                                                        {text: 'bottom', value: 'bottom'}
                                                    ]
                                                },
                                                {
                                                    type: 'textbox',
                                                    name: 'tp_image_size',
                                                    label: 'Image size in px',
                                                    value: '0'
                                                },
                                                {
                                                    type: 'listbox',
                                                    name: 'tp_image_link',
                                                    label: 'Image refers to',
                                                    'values': [
                                                        {text: 'none', value: 'none'},
                                                        {text: 'self', value: 'self'},
                                                        {text: 'post or page', value: 'post'}
                                                    ]
                                                }
                                            ]
                                        }
                                    ],
                                    onsubmit: function( e ) {
                                        var filterData = this.find('[name=tp_filterform]')[0].toJSON();
                                        var designData = this.find('[name=tp_designform]')[0].toJSON();
                                        var tagcloudData = this.find('[name=tp_tagcloudform]')[0].toJSON();
                                        var imageData = this.find('[name=tp_imagesform]')[0].toJSON();
                                        var user = filterData.tp_user;
                                        var type = filterData.tp_filter_type;
                                        var headline = designData.tp_headline;
                                        var tag_minsize = tagcloudData.tp_tag_minsize;
                                        var tag_maxsize = tagcloudData.tp_tag_maxsize;
                                        var tag_limit = tagcloudData.tp_tag_limit;
                                        var show_tags_as = tagcloudData.tp_show_tags_as;
                                        var image = imageData.tp_image;
                                        var image_size = imageData.tp_image_size;
                                        var image_link = imageData.tp_image_link;
                                        var author_name = designData.tp_author_name;
                                        var editor_name = designData.tp_editor_name;
                                        var style = designData.tp_style;
                                        var template = designData.tp_template;
                                        var link_style = designData.tp_link_style;
                                        var entries_per_page = e.data.tp_entries_per_page;
                                        
                                        user = (user === '') ? '' : 'user="' + user + '"';
                                        type = (type === '0') ? '' : 'type="' + type + '"';
                                        headline = (headline === '1') ? '' : 'headline="' + headline + '"';
                                        tag_minsize = (tag_minsize === '11') ? '' : 'minsize="' + tag_minsize + '"';
                                        tag_maxsize = (tag_maxsize === '35') ? '' : 'maxsize="' + tag_maxsize + '"';
                                        tag_limit = (tag_limit === '30') ? '' : 'tag_limit="' + tag_limit + '"';
                                        show_tags_as = (show_tags_as === 'cloud') ? '' : 'show_tags_as="' + show_tags_as + '"';
                                        image = (image === 'none') ? '' : 'image="' + image + '"';
                                        image_size = (image_size === '0') ? '' : 'image_size="' + image_size + '"';
                                        image_link = (image_link=== 'none') ? '' : 'image_link="' + image_link + '"';
                                        author_name = (author_name === 'last') ? '' : 'author_name="' + author_name + '"';
                                        editor_name = (editor_name === 'last') ? '' : 'editor_name="' + editor_name + '"';
                                        style = (style === 'none') ? '' : 'style="' + style + '"';
                                        template = 'template="' + template + '"';
                                        link_style = (link_style === 'inline') ? '' : 'link_style="' + link_style + '"';
                                        entries_per_page = (entries_per_page === '50') ? '' : 'entries_per_page="' + entries_per_page + '"';
                                        
                                        editor.insertContent( '[tpcloud ' + user + ' ' + type + ' ' + headline + ' ' + tag_limit + ' ' + tag_minsize + ' ' + tag_maxsize + ' ' + show_tags_as + ' ' + image + ' ' + image_size + ' ' + image_link + ' ' + author_name + ' ' + editor_name + ' ' + style + ' ' + template + ' ' + link_style + ' ' + entries_per_page + ']');
                                    }
                                });
                            }
                        },
                        
                        // [tpsearch]
                        
                        {
                            text: 'Publication search [tpsearch]',
                            onclick: function() {
                                 editor.windowManager.open( {
                                    title: 'Insert publication search [tpsearch]',
                                    bodyType: 'tabpanel',
                                    body: [
                                        // Filter box
                                        {
                                            title: 'Filter',
                                            type: 'form',
                                            name: 'tp_filterform',
                                            items: [
                                                 {
                                                    type: 'listbox',
                                                    name: 'tp_as_filter',
                                                    label: 'Show all publications by default',
                                                    'values': [
                                                        {text: 'No', value: 'false'},
                                                        {text: 'Yes', value: 'true'}
                                                    ]
                                                },
                                                {
                                                    type: 'textbox',
                                                    name: 'tp_entries_per_page',
                                                    label: 'Entries per page',
                                                    value: '20'
                                                }
                                            ]
                                        },
                                        // Design box
                                        {
                                            title: 'Design',
                                            type: 'form',
                                            name: 'tp_designform',
                                            items: [
                                                {
                                                    type: 'listbox',
                                                    name: 'tp_headline',
                                                    label: 'Headline',
                                                    'values': [
                                                        {text: 'years', value: '1'},
                                                        {text: 'publication types', value: '2'},
                                                        {text: 'headlines grouped by year then by type', value: '3'},
                                                        {text: 'headlines grouped by type then by year', value: '4'},
                                                        {text: 'none', value: '0'}
                                                    ]
                                                },
                                                {
                                                    type: 'listbox',
                                                    name: 'tp_author_name',
                                                    label: 'Style of the author names',
                                                    'values': [
                                                        {text: 'last (example: van der Vaart, Ludwig)', value: 'last'},
                                                        {text: 'initials (example: van der Vaart, Ludwig C)', value: 'initials'},
                                                        {text: 'simple (example: Ludwig C. van der Vaart)', value: 'simple'},
                                                        {text: 'old (example: Vaart, Ludwig C. van der)', value: 'old'}
                                                    ]
                                                },
                                                {
                                                    type: 'listbox',
                                                    name: 'tp_editor_name',
                                                    label: 'Style of the editor names',
                                                    'values': [
                                                        {text: 'last (example: van der Vaart, Ludwig)', value: 'last'},
                                                        {text: 'initials (example: van der Vaart, Ludwig C)', value: 'initials'},
                                                        {text: 'simple (example: Ludwig C. van der Vaart)', value: 'simple'},
                                                        {text: 'old (example: Vaart, Ludwig C. van der)', value: 'old'}
                                                    ]
                                                },
                                                {
                                                    type: 'listbox',
                                                    name: 'tp_style',
                                                    label: 'Numeration of publication lists',
                                                    'values': [
                                                        {text: 'none', value: 'none'},
                                                        {text: 'numbered', value: 'numbered'},
                                                        {text: 'numbered descending', value: 'numbered_desc'}
                                                    ]
                                                },
                                                {
                                                    type: 'listbox',
                                                    name: 'tp_template',
                                                    label: 'Template',
                                                    'values': teachpress_pub_templates  //  is written by tp_write_data_for_tinymce()
                                                },
                                                {
                                                    type: 'listbox',
                                                    name: 'tp_link_style',
                                                    label: 'Style of publication links',
                                                    'values': [
                                                        {text: 'inline', value: 'inline'},
                                                        {text: 'images', value: 'images'},
                                                        {text: 'direct', value: 'direct'}
                                                    ]
                                                },
                                                {
                                                    type: 'textbox',
                                                    name: 'tp_date_format',
                                                    label: 'Date format',
                                                    value: 'd.m.Y'
                                                }
                                            ]
                                        },
                                        // Image box
                                        {
                                            title: 'Images',
                                            type: 'form',
                                            name: 'tp_imagesform',
                                            items: [
                                                {
                                                    type: 'listbox',
                                                    name: 'tp_image',
                                                    label: 'Show images',
                                                    'values': [
                                                        {text: 'none', value: 'none'},
                                                        {text: 'left', value: 'left'},
                                                        {text: 'right', value: 'right'},
                                                        {text: 'bottom', value: 'bottom'}
                                                    ]
                                                },
                                                {
                                                    type: 'textbox',
                                                    name: 'tp_image_size',
                                                    label: 'Image size in px',
                                                    value: '0'
                                                },
                                                {
                                                    type: 'listbox',
                                                    name: 'tp_image_link',
                                                    label: 'Image refers to',
                                                    'values': [
                                                        {text: 'none', value: 'none'},
                                                        {text: 'self', value: 'self'},
                                                        {text: 'post or page', value: 'post'}
                                                    ]
                                                }
                                            ]
                                        }
                                        // End Panels
                                    ],
                                    onsubmit: function( e ) {
                                        var filterData = this.find('[name=tp_filterform]')[0].toJSON();
                                        var designData = this.find('[name=tp_designform]')[0].toJSON();
                                        var imageData = this.find('[name=tp_imagesform]')[0].toJSON();
                                        var image = imageData.tp_image;
                                        var image_size = imageData.tp_image_size;
                                        var image_link = imageData.tp_image_link;
                                        var author_name = designData.tp_author_name;
                                        var editor_name = designData.tp_editor_name;
                                        var style = designData.tp_style;
                                        var template = designData.tp_template;
                                        var link_style = designData.tp_link_style;
                                        var entries_per_page = filterData.tp_entries_per_page;
                                        var as_filter = filterData.tp_as_filter;
                                        var date_format = designData.tp_date_format;
                                        
                                        image = (image === 'none') ? '' : 'image="' + image + '"';
                                        image_size = (image_size === '0') ? '' : 'image_size="' + image_size + '"';
                                        image_link = (image_link === 'none') ? '' : 'image_link="' + image_link + '"';
                                        author_name = (author_name === 'last') ? '' : 'author_name="' + author_name + '"';
                                        editor_name = (editor_name === 'last') ? '' : 'editor_name="' + editor_name + '"';
                                        style = (style === 'numbered') ? '' : 'style="' + style + '"';
                                        template = 'template="' + template + '"';
                                        link_style = (link_style === 'inline') ? '' : 'link_style="' + link_style + '"';
                                        entries_per_page = (entries_per_page === '20') ? '' : 'entries_per_page="' + entries_per_page + '"';
                                        as_filter = (as_filter === 'false') ? '' : 'as_filter="' + as_filter + '"';
                                        date_format = (date_format === 'd.m.Y') ? '' : 'date_format="' + date_format + '"';
                                        
                                        editor.insertContent( '[tpsearch ' + entries_per_page + ' ' + image + ' ' + image_size + ' ' + image_link + ' ' + author_name + ' ' + editor_name + ' ' + style + ' ' + template + ' ' + link_style + ' ' + as_filter + ' ' + date_format + ']');
                                    }
                                });
                            }
                        }
                    ]
                }
            ]
        });
    });
})();