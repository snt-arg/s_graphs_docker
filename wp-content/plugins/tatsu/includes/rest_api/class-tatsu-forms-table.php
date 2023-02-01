<?php 
/**
 * Tatsu Forms table
 * Using Wordpress default Table class
 */

require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );

class Tatsu_forms_table extends WP_List_Table {

    protected $form_id;

    public function __construct()
    {
        parent::__construct();

        $this->form_id = isset($_POST['form_id']) ? (int) $_POST['form_id'] : 0;
    }

    //GET TATSU FORMS LIST
    public function tatsu_forms_list(){
        $query  = new WP_Query(  
            array (  
                'post_type'      => 'tatsu_forms',  
                'post_status' => 'publish',
                'posts_per_page' => -1  
            )  
        );  
        $return = array();  
        $fields = array('post_title', 'ID');  
        $posts = $query->get_posts();
        foreach($posts as $post) {
            $newPost = array();
            foreach($fields as $field) {
                $newPost[$field] = $post->$field;
            }
            $return[] = $newPost;
        }

        return $return;
    }

    public function select_forms_html(){
        $tatsu_forms = $this->tatsu_forms_list();
        $select_form_html = '';
        if(!empty($tatsu_forms)){
            $total_forms  = count($tatsu_forms);
            $this->form_id = isset($_POST['form_id']) ? (int) $_POST['form_id'] : $tatsu_forms[$total_forms-1]['ID'];
            $select_form_html = '<select name="form_id" onchange="this.form.submit();"><option value="">Choose form</option>';
            foreach ($tatsu_forms as $key => $tatsu_form) {
                $selected = "";
                if($this->form_id == $tatsu_form['ID']){
                    $selected = "selected";
                }
                $select_form_html .='<option value="'.$tatsu_form['ID'].'" '.$selected.'>'.$tatsu_form['post_title'].'</option>';
            }
            $select_form_html .= '</select>';
        }
        return $select_form_html;
    } 
    //PREPARE TABLE HEADER, DATA AND PAGINATION
    public function prepare_items() {

        $orderby = isset($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : "";
        $order = isset($_GET['order']) ? sanitize_text_field($_GET['order']) : "DESC";

        $search_term = isset($_POST['s']) ? trim($_POST['s']) : "";
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->process_bulk_action();
        $per_page = 20;
        $current_page = $this->get_pagenum();

        $response = $this->form_list_table_data($orderby, $order, $search_term,$per_page, $current_page);
        //echo "<pre>";print_r($response);exit;
        $total_items = $response['total_items'];
        
        $this->set_pagination_args([
        'total_items' => $total_items, 
        'per_page' => $per_page, 
        ]);

        $this->items = $response['data'];

        
    }

    //FETCH DATA FOR TABLE
    public function form_list_table_data($orderby = '', $order = 'DESC', $search_term = '',$per_page = 20, $page_number = 1) {
        $data_array = array();
        $total_forms = 0;
        if(!empty($this->form_id))
        {    global $wpdb;
            $submit_table = $wpdb->prefix.'tatsu_forms_submit';
            $data_table = $wpdb->prefix.'tatsu_forms_data';
            $search_query = '';
            /*
             SELECT s.*,GROUP_CONCAT(d.field_name ORDER BY d.id) AS field_name ,GROUP_CONCAT(d.field_value ORDER BY d.id ) AS field_value
            FROM wp_tatsu_forms_submit AS s
            LEFT JOIN wp_tatsu_forms_data AS d ON s.submit_id = d.submit_id  WHERE s.tatsu_form_id = '5184' 
            AND s.submit_id IN (SELECT DISTINCT submit_id FROM  wp_tatsu_forms_data WHERE field_value LIKE '%abc%') GROUP BY s.submit_id ORDER BY s.submit_id DESC LIMIT %d OFFSET %d
            */
            $main_data_query = "SELECT s.*,GROUP_CONCAT(d.field_name ORDER BY d.id SEPARATOR ' ; ') AS field_name,GROUP_CONCAT(d.field_value ORDER BY d.id SEPARATOR ' ; ') AS field_value
            FROM " . $submit_table . " AS s
            LEFT JOIN " . $data_table . " AS d ON s.submit_id = d.submit_id  WHERE s.tatsu_form_id = '%d' AND s.deleted = '0' ";
            $way_of_show = "GROUP BY s.submit_id ORDER BY s.submit_id $order LIMIT %d OFFSET %d";

            $query_for_total_forms = "SELECT COUNT(DISTINCT d.submit_id) AS total_forms
            FROM " . $submit_table . " AS s
            LEFT JOIN " . $data_table . " AS d ON s.submit_id = d.submit_id  WHERE s.tatsu_form_id = '%d' AND s.deleted = '0' ";

            if (!empty($search_term)) {
                $search_term =  sanitize_textarea_field($search_term);

                $search_query = "AND s.submit_id IN (SELECT DISTINCT submit_id FROM  wp_tatsu_forms_data WHERE field_value LIKE '%%%s%%')";
                $query_for_data = sprintf($main_data_query." ".$search_query." ".$way_of_show, $this->form_id,$search_term,$per_page, ($page_number - 1) * $per_page);

                $query_for_total_forms .= $search_query." ";
                $query_for_total_forms = sprintf($query_for_total_forms, $this->form_id,$search_term);
            }else{
                
                $query_for_data = sprintf($main_data_query." ".$way_of_show, $this->form_id,$per_page, ($page_number - 1) * $per_page);

                $query_for_total_forms = sprintf($query_for_total_forms." ", $this->form_id,$search_term);
            }
            $forms_data = $wpdb->get_results($query_for_data);
            $total_forms = $wpdb->get_results($query_for_total_forms);
            $total_forms = $total_forms[0]->total_forms;

            if (count($forms_data) > 0) {

                foreach ($forms_data as $index => $forms) {
                    
                    $field_name = explode(' ; ',$forms->field_name);
                    $field_value = explode(' ; ',$forms->field_value);
                    $array_combine = array_combine($field_name,$field_value);
                    $array1 = array(
                        "submit_id" => $forms->submit_id,
                        "added" => wp_date('d-m-y',strtotime($forms->added)),
                        "view" => $forms->viewed,
                        "ip"=>$forms->ip,
                        "json_data"=>json_encode($array_combine)
                    );
                    $array2 = array_map(function($v){
                        return substr($v,0,50);
                    },$array_combine);
                    $data_array[] = array_merge($array1,$array2);
                }
            }
        }
        //echo "<pre>";print_r($data_array);exit;
        return array('total_items'=>$total_forms,'data'=>$data_array);
    }

    //HIDE COLUMN
    public function get_hidden_columns() {
        return array();
        //return array("id", "name");
    }

    //MAKE COLUMN SORTABLE
    public function get_sortable_columns() {
         return array("submit_id" => array("ID",true));
    }

    //GET COLUMN NAMES
    public function get_columns() {
        $columns = array("submit_id" => "ID","added" => "Submit Time");
        if(!empty($this->form_id))
        {   $form_fields_name = extract_tatsu_forms_field_name_list($this->form_id);
			if($form_fields_name !== false){

                $array1 = array(
                    "cb"=>"<input type='checkbox' />",
                    "submit_id" => "ID");
                $array2 = array("added" => "Submit Time","ip"=>"IP");
                $array3 = array_combine($form_fields_name,$form_fields_name);
                $columns = array_merge($array1,$array3,$array2);
            }
        }
        return $columns;
    }

    //PUT CHECKBOX FOR EACH ROW
    public function column_cb($item){
        return sprintf('<input type="checkbox" name="tatsu_forms_multiple_delete[]" value=%s"" />',$item['submit_id']);
    }

    //FILTER VALUE FOR EACH COLUMN BEFORE PRINT ON SCREEN
    public function column_default($item, $column_name) {
        switch ($column_name) {
            case 'submit_id':
            case 'added':
            case 'ip':
                return esc_html($item[$column_name]);
            default: $result = isset($item[$column_name])?$item[$column_name]:' ';
                return $result;
        }
    }

    //VIEW OR DELETE 
    public function column_submit_id($item){
        $submit_id = $item['submit_id'];
        $popup_html = $this->make_tatsu_form_details_popup_html($item['json_data']);
        $action = array(
            'view'=>sprintf('<span id="form-details-%s" style="display:none;">'.$popup_html.'</span><a href="#TB_inline?&width=700&height=700&inlineId=form-details-%s" class="thickbox">view</a>',$item['submit_id'],$item['submit_id']),
            'delete'=>sprintf('<a href="?page=%s&action=delete&submit_id=%s" class="delete-form" submitid="%s">delete</a>',$_GET['page'],$item['submit_id'],$item['submit_id'])
                    );
        return sprintf('%1$s %2$s',$submit_id,$this->row_actions($action));
    }

    public function make_tatsu_form_details_popup_html($json_data){
        $json_data = json_decode($json_data);
        $html = '<table class="tatsu-form-details-table wp-list-table widefat fixed striped table-view-list"><colgroup>
        <col span="1" style="width: 30%%;">
        <col span="1" style="width: 70%%;">
     </colgroup>
        <thead><tr><th scope="col" colspan="2"><span class="form-details-heading"><strong>Form Details</strong></span></th></tr></thead><tbody>
        ';
        foreach ($json_data as $field_name => $field_value) {
            $html .= "<tr><td class='field-name'><span class='form-details-field-name'>$field_name :</span></td> <td class='field-value'><span class='form-details-field-value' >$field_value</span></td></tr>";
        }
        $html .="</tbody></table>";
        return $html;
    }

    //BULK ACTION 
    public function get_bulk_actions()
    {
        $actions = array("tatsu-form-delete"=> __('Delete'));
        return $actions;
    }

    public function process_bulk_action(){
        if(!empty($_POST['tatsu_forms_multiple_delete'])){
            global $wpdb;
            $submit_table = $wpdb->prefix.'tatsu_forms_submit';
            foreach($_POST['tatsu_forms_multiple_delete'] as $submit_id){
                $submit_id = sanitize_text_field($submit_id);
                $delete_query = sprintf("UPDATE $submit_table
                SET deleted = '1' WHERE submit_id = '%s'",$submit_id);
                $wpdb->query($delete_query);
            }
        }
    }

    public function do_the_action(){
        if(!empty($_GET['action']) && $_GET['action'] == 'delete' && !empty($_GET['submit_id'])){
            global $wpdb;
            $submit_table = $wpdb->prefix.'tatsu_forms_submit';
            $submit_id = sanitize_text_field($_GET['submit_id']);
            $delete_query = sprintf("UPDATE $submit_table
            SET deleted = '1' WHERE submit_id = '%s'",$submit_id);
            $wpdb->query($delete_query);
        }
    }

}
?>