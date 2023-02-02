// teachPress javascript for the admin menu

/**
 * Delele node
 * @param {type} id
 * @since 5.0.0
 */
function teachpress_del_node(id){
    jQuery(document).ready(function($) {
        $(id).remove();
    });
}

/**
 * for selecting all checkboxes on an admin page
 * @param {string} element_names
 * @param {string} checkbox_id
 * @since 3.0.0
 */
function teachpress_checkboxes(element_names, checkbox_id) {
    var switch_box = document.getElementById(checkbox_id);
    var checkbox = document.getElementsByName(element_names);
    var i;
    if (switch_box.checked === true) {
        for ( i = 0; i < checkbox.length; i++ ) {
            checkbox[i].checked = true;
        }
    }
    else {
        for ( i = 0; i < checkbox.length; i++ ) {
            checkbox[i].checked = false;
        }
    }
}

/**
 * for adding new tags
 * @param {string} tag
 * @since 4.2.0
 * @version 2
 */
function teachpress_inserttag(tag) {
    var old = document.getElementsByName("tags")[0].value;
    if ( old === "") {
        document.getElementsByName("tags")[0].value = tag;
    }
    else {
        old = old + ', ' + tag;
        document.getElementsByName("tags")[0].value = old;
    }	
}

/**
 * trim a string
 * @param {string} input
 * @returns {string}
 * @since 4.2.0
 */
function teachpress_trim (input) {
    input = input.replace(/^\s*(.*)/, "$1");
    input = input.replace(/(.*?)\s*$/, "$1");
    return input;
}

/**
 * For changing the color of a checkbox label between red and dark grey
 * @param {string} checkbox
 * @param {string] label
 * @since 1.0.0
 * @version 2
 */
function teachpress_change_label_color(checkbox, label) {
    if (document.getElementById(checkbox).checked === true) {
        document.getElementById(label).style.color = "#FF0000";
    }
    else {
        document.getElementById(label).style.color = "#333";
    }
}

/**
 * for show/hide buttons
 * @param {string} where
 * @since 1.0.0
 */
function teachpress_showhide(where) {
    var mode = "block";
    if (where === "show_all_fields" || where === "show_recommend_fields") {
        mode = "inline";
    }
    if (where === "tp-inline-edit-row") {
        mode = "table-row";
    }
    if (document.getElementById(where).style.display !== mode) {
    	document.getElementById(where).style.display = mode;
    }
    else {
     	document.getElementById(where).style.display = "none";
    }
}

/**
 * for switching rel_page options at add_course page
 * @returns {undefined}
 * @since 5.0.0
 */
function teachpress_switch_rel_page_container(){
    if (document.getElementById('rel_page_original').style.display !== "none") {
    	document.getElementById('rel_page_alternative').style.display = "block";
        document.getElementById('rel_page_original').style.display = "none";
    }
    else {
        document.getElementById('rel_page_alternative').style.display = "none";
        document.getElementById('rel_page_original').style.display = "block";
    }
}

/**
 * for show/hide sub course panel at add_course page
 * @returns {undefined}
 * @since 5.0.0
 */
function teachpress_courseFields () {
    var test = document.getElementById('parent2').value;
    if ( test === "0") {
        document.getElementById('sub_course_panel').style.display = "block";
    }
    else {
        document.getElementById('sub_course_panel').style.display = "none";
    }
}

/**
 * for edit tags
 * @param {int} tag_id
 * @since 1.0.0
 */
function teachpress_editTags(tag_id) {
    var parent = "tp_tag_row_" + tag_id;
    var message_text_field = "tp_tag_row_name_" + tag_id;
    var input_field = "tp_edit_tag_name";
    var text;

    if (isNaN(document.getElementById(input_field))) {
    }
    else {
        var reg = /<(.*?)>/g;
        text = document.getElementById(message_text_field).value;
        text = text.replace( reg, "" );
        // create div
        var editor = document.createElement('div');
        editor.id = "div_edit";
        // create hidden fields
        var field_neu = document.createElement('input');
        field_neu.name = "tp_edit_tag_id";
        field_neu.type = "hidden";
        field_neu.value = tag_id;
        // create textarea
        var tagname_new = document.createElement('input');
        tagname_new.id = input_field;
        tagname_new.name = input_field;
        tagname_new.value = text;
        tagname_new.style.width = "98%";
        // create save button
        var save_button = document.createElement('input');
        save_button.name = "tp_edit_tag_submit";
        save_button.value = "Save";
        save_button.type = "submit";
        save_button.className = "button-primary";
        // create cancel button
        var cancel_button = document.createElement('input');
        cancel_button.value = "Cancel";
        cancel_button.type = "button";
        cancel_button.className = "button";
        cancel_button.onclick = function () { document.getElementById(parent).removeChild(editor);};
        document.getElementById(parent).appendChild(editor);
        document.getElementById("div_edit").appendChild(field_neu);
        document.getElementById("div_edit").appendChild(tagname_new);
        document.getElementById("div_edit").appendChild(save_button);
        document.getElementById("div_edit").appendChild(cancel_button);
    }
}

/**
 * validate forms
 * @since 1.0.0
 */
function teachpress_validateForm() {
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=teachpress_validateForm.arguments;
    for (i = 0; i < (args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.name; if ((val=val.value)!=="") {
        if (test.indexOf('isEmail') !== -1) { p=val.indexOf('@');
          if (p < 1 || p === (val.length-1)) errors+='* '+nm+' must contain an e-mail address.\n';
        } else if ( test!== 'R') { num = parseFloat(val);
          if (isNaN(val)) errors+='* '+nm+' must contain a number.\n';
          if (test.indexOf('inRange') !== -1) { p=test.indexOf(':');
            min=test.substring(8,p); max=test.substring(p+1);
            if (num<min || max<num) errors+='* '+nm+' must contain a number between '+min+' and '+max+'.\n';
      } } } else if (test.charAt(0) === 'R') errors += '* '+nm+' is required.\n'; }
    } if (errors) alert('Sorry, but you must relieve the following error(s):\n'+errors);
    document.teachpress_returnValue = (errors === '');
} }

/**
 * for show/hide bibtex fields
 * @param {string} mode     std (= the action is called from the type select form) or 
 *                          std2 (= the action is called from the show fields buttons)
 * @since 2.0.0
 */
function teachpress_publicationFields(mode) {
    var all_fields = ["journal", "volume", "number", "pages", "address", "chapter", 
                        "institution", "school", "series", "howpublished", "edition",
                        "organization", "techtype", "booktitle", "issuetitle", "publisher",
                        "urldate"];
    // Show publication type specific fields
    if ( mode === "std" || mode === "std2" ) {
        if ( mode === "std2" ) {
            teachpress_showhide("show_all_fields");
            teachpress_showhide("show_recommend_fields");
        }
        
        // Load pub type and the suitable default fields for this type
        var pub_type = document.getElementsByName("type")[0].value;
        var default_fields = window['tp_type_' + pub_type];
        
        // Show/Hide the fields
        for (i = 0; i < all_fields.length; i++) {
            document.getElementById("div_" + all_fields[i]).style.display = "none";
            if ( default_fields.includes( all_fields[i] ) ) {
                document.getElementById("div_" + all_fields[i]).style.display = "block";
            }
        }
        
        // key field
        document.getElementById("div_key").style.display = "none";
        // crossref field
        document.getElementById("div_crossref").style.display = "none";
    }
    
    // Show all fields
    else {
        teachpress_showhide("show_all_fields");
        teachpress_showhide("show_recommend_fields");
        for (i = 0; i < all_fields.length; i++) {
            document.getElementById("div_" + all_fields[i]).style.display = "block";
        }
        document.getElementById("div_crossref").style.display = "block";
        document.getElementById("div_key").style.display = "block";
    }
}

/**
 * Make it possible to use the wordpress media uploader
 * @since 2.0.0
 */
jQuery(document).ready(function() {
    var uploadID = '';
    var old = '';
    jQuery('.upload_button').click(function() {
        uploadID = jQuery(this).next('textarea');
        document.getElementById("upload_mode").value = "multiple";
        formfield = jQuery('.upload').attr('nam;');
        tb_show('', 'media-upload.php?TB_iframe=true');
        return false;
    });

    jQuery('.upload_button_image').click(function() {
        uploadID = jQuery(this).prev('input');
        formfield = jQuery('.upload').attr('name');
        document.getElementById("upload_mode").value = "single";
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        return false;
    });

    window.send_to_editor = function(html) {
        // html_fixed should fix the jQuery error: HTML strings must start with '<' character
        var html_fixed = '<html>' + html + '</html>';
        var imgurl = jQuery('img',html_fixed).attr('src');
        var sel = document.getElementById("upload_mode").value;
        if (typeof(imgurl) === "undefined") {
            imgurl = jQuery(html).attr('href');
        }
        if (sel === "multiple") {
            var old = document.getElementById("url");
            // IE
            if (document.selection){
                imgurl = old.value + imgurl;
            }
            // Firefox, Chrome, Safari, Opera
            else if (old.selectionStart || old.selectionStart === '0') {
                var startPos = old.selectionStart;
                var endPos = old.selectionEnd;
                var urlLength = imgurl.length;
                imgurl = old.value.substring(0, startPos) + imgurl + old.value.substring(endPos, old.value.length);
                old.selectionStart = startPos + urlLength;
                old.selectionEnd = startPos + urlLength;
            }
            // IE and others
            else {
                imgurl = old.value + imgurl;
            }
            old.focus();
            old.value = imgurl;
            tb_remove();
            return;
        }
        uploadID.val(imgurl);
        tb_remove();
    };
});