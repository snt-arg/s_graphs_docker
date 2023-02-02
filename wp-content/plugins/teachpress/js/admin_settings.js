/**
 * This file contains js functions for admin/settings UI
 * 
 * @package teachpress
 * @subpackage js
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPLv2 or later
 */

jQuery(document).ready(function($){
    // Open about dialog settings
    $( "#dialog" ).dialog({
      autoOpen: false,
      width: 500,
      show: {
        effect: "blind",
        duration: 1000
      },
      hide: {
        effect: "explode",
        duration: 1000
      }
    });
    
    // Open about dialog
    $( "#tp_open_readme" ).click(function() {
      $( "#dialog" ).dialog( "open" );
    });
    
    
  });