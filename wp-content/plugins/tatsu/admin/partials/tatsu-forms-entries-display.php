<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.brandexponents.com
 * @since      3.3.2
 *
 * @package    Tatsu
 * @subpackage Tatsu/admin/partials
 */

 
if( !function_exists( 'tatsu_forms_entries_display_table' ) ){
    function tatsu_forms_entries_display_table(){
        add_thickbox();
        $tatsu_table = new Tatsu_forms_table();
        $tatsu_table->do_the_action();
        $select_forms_html = $tatsu_table->select_forms_html();
        $tatsu_table->prepare_items();
        echo '<h3>Tatsu Form Entries</h3>';
        echo "<form method='post' id='tatsu-form-entries-table-form' name='frm_search_post' action='" . $_SERVER['PHP_SELF'] . "?page=".$_GET['page']."'>";
        echo '<input type="hidden" name="page" value="'.$_GET['page'].'" />';
        echo $select_forms_html;
        $tatsu_table->search_box("Search Forms", "search_tatsu_forms");
        $tatsu_table->display();
        echo "</form>";
    }
}


?>