/**
 * This file contains js functions for admin/add_course UI
 * 
 * @package teachpress
 * @subpackage js
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPLv2 or later
 */
jQuery(document).ready(function($) {
    $('#comment').resizable({handles: "se", minHeight: 55, minWidth: 400});
    $('#start').datepicker({showWeek: true, changeMonth: true, changeYear: true, showOtherMonths: true, firstDay: 1, renderer: $.extend({}, $.datepicker.weekOfYearRenderer), onShow: $.datepicker.showStatus, dateFormat: 'yy-mm-dd', yearRange: '2008:c+5'}); 
    $('#end').datepicker({showWeek: true, changeMonth: true, changeYear: true, showOtherMonths: true, firstDay: 1, renderer: $.extend({}, $.datepicker.weekOfYearRenderer), onShow: $.datepicker.showStatus, dateFormat: 'yy-mm-dd', yearRange: '2008:c+5'});
});