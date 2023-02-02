/**
 * This file contains js functions for admin/mail UI
 * 
 * @package teachpress
 * @subpackage js
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPLv2 or later
 */
jQuery(document).ready(function($) {
    $('#mail_text').resizable({handles: "se", minHeight: 55, minWidth: 400});
    $('#mail_recipients').resizable({handles: "se", minHeight: 55, minWidth: 400});
});