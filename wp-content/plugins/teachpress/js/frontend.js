// teachPress javascript for the frontend

/**
 * for jumpmenu
 * @param {string} targ
 * @param {string} selObj
 * @param {string} restore
 * @since 6.0.4
 * @version 2
 */
function teachpress_jumpMenu(targ, selObj, base){
    var url = encodeURI(base+selObj.options[selObj.selectedIndex].value);
    eval(targ+".location='"+ url +"'");
}

/**
 * for cleaning input field of tpsearch
 * @since 4.3.12
 */
function teachpress_tp_search_clean() {
    document.getElementById("tp_search_input_field").value = "";
}

/**
 * for show/hide buttons
 * @param {string} where
 * @since 0.85
 */
function teachpress_showhide(where) {
    var mode = "block";
    if (document.getElementById(where).style.display !== mode) {
        document.getElementById(where).style.display = mode;
    }
    else {
        document.getElementById(where).style.display = "none";
    }
}

/**
 * for show/hide div container in publication lists
 * @param {string} id
 * @param {string} button
 * @since 1.0
 */
function teachpress_pub_showhide(id, button) {
    var mode = "block";
    var curr = button + "_" + id;
    var currSh = button + "_sh_" + id;
    if ( document.getElementById(curr).style.display === mode ) {
        document.getElementById(curr).style.display = "none";
        document.getElementById(currSh).setAttribute("class", "tp_show");
    }
    else {
        container = new Array("tp_altmetric_", "tp_abstract_", "tp_bibtex_", "tp_links_");
        for ( let i = 0; i < (container.length); i++ ) {
            if ( document.getElementById(container[i] + id) ) {
                if ( (container[i] + id) === curr ) {
                    document.getElementById(container[i] + id).style.display = mode;
                    document.getElementById(container[i] + "sh_" + id).setAttribute("class", "tp_show_block");
                    continue;
                }
                if ( document.getElementById(container[i] + id).style.display === mode ) {
                    document.getElementById(container[i] + id).style.display = "none";
                    document.getElementById(container[i] + "sh_" + id).setAttribute("class", "tp_show");
                }
            }
        }
    }
}

/**
 * validate forms
 * @since 0.85
 */
function teachpress_validateForm() {
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=teachpress_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) { 
        test=args[i+2]; 
        val=document.getElementById(args[i]);
        if (val) {
            nm=val.name; 
            if ( (val = val.value)!== "" ) {
                if (test.indexOf('isEmail')!==-1) { 
                    p=val.indexOf('@');
                    if (p<1 || p===(val.length-1)) {
                        errors+='* '+nm+' must contain an e-mail address.\n';
                    }
                } 
                else if (test!=='R') {
                    num = parseFloat(val);
                    if (isNaN(val)) { 
                        errors+='* '+nm+' must contain a number.\n'; 
                    }
                    if (test.indexOf('inRange') !== -1) { 
                        p=test.indexOf(':');
                        min=test.substring(8,p); max=test.substring(p+1);
                        if (num<min || max<num) { 
                            errors+='* '+nm+' must contain a number between '+min+' and '+max+'.\n'; 
                        }
                    }
                } 
            } 
            else if (test.charAt(0) === 'R') errors += '* '+nm+' is required.\n'; 
        }
    } 
    if (errors) alert('Sorry, but you must relieve the following error(s):\n'+errors);
    document.teachpress_returnValue = (errors === '');
  } 
}
