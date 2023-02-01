<?php
/**
 * Master Slider Database Class.
 *
 * @package   MasterSlider
 * @author    averta [averta.net]
 * @license   LICENSE.txt
 * @link      http://masterslider.com
 * @copyright Copyright © 2014 averta
 */

// no direct access allowed
if ( ! defined('ABSPATH') ) {
    die();
}

/**
 * Plugin class. This class should ideally be used to work with the
 * public-facing side of the WordPress site.
 */
class MSP_DB {

	/**
	 * Current database version
	 */
	const DB_VERSION = "1.4";


	/**
	* Count of rows returned by previous query
	*
	* @since 1.0
	* @access private
	* @var int
	*/
	var $num_rows = 0;


	/**
	* Last query made
	*
	* @since 1.0
	* @access private
	* @var array
	*/
	var $last_query;


	/**
	* Results of the last query made
	*
	* @since 1.0
	* @access private
	* @var array|null
	*/
	var $last_result;


	/**
	* Master table prefix
	*
	* @since 1.0
	* @access private
	* @var string
	*/
	var $prefix = '';


	/**
	* Master table tabes
	*
	* @since 1.0
	* @access private
	* @var string
	*/
	var $tabel_names = array( 'sliders', 'options' );


	/**
	 * The database character collate.
	 *
	 * @since 1.0
	 * @access private
	 * @var string
	 */
	var $charset_collate = '';



	/**
	 * Constructor
	 */
	public function __construct() {

		if( is_admin() ) {

			$this->maybe_update_tables();
			add_filter( 'wpmu_drop_tables', array( $this, 'wpmu_drop_tables' ), 11, 2 );
		}

	}

	/**
	 * Get known properties
	 *
	 * @param  string   property name
	 * @return string   property value
	 */
	public function __get( $name ){

		if( in_array( $name, $this->tabel_names ) ){
			global $wpdb;
			return $wpdb->prefix . 'masterslider_' . $name;

		// Get list of Masterslider table names
		} elseif( 'tables' == $name ){
			global $wpdb;
			$tables = array();

			foreach ( $this->tabel_names as $table_name )
				$tables[ $table_name ] = $wpdb->prefix . 'masterslider_' . $table_name;

			return $tables;

		} else {
			return NULL;
		}
	}

	/**
	 * Create master slider sliders table
	 *
	 * @since 1.0
	 * @return null
	 */
	private function create_table_sliders() {

		$sql_create_table = "CREATE TABLE {$this->sliders}  (
            ID mediumint unsigned NOT NULL AUTO_INCREMENT,
            title  varchar(100) NOT NULL,
            alias  varchar(100) NOT NULL,
            type  varchar(64) NOT NULL,
            slides_num smallint unsigned NOT NULL,
            date_created  datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
            date_modified datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
            params mediumtext NOT NULL,
            custom_styles text NOT NULL DEFAULT '',
            custom_fonts  text NOT NULL DEFAULT '',
            status varchar(10) NOT NULL DEFAULT 'draft',
            PRIMARY KEY  (ID),
            KEY date_created (date_created),
            KEY alias (alias)
        ) {$this->charset_collate};\n";

	 	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql_create_table );
	}


	/**
	 * Create master slider options table
	 *
	 * @since 1.0
	 * @return null
	 */
	private function create_table_options() {

		$sql_create_table = "CREATE TABLE {$this->options}  (
            ID smallint unsigned NOT NULL AUTO_INCREMENT,
            option_name varchar(120) NOT NULL,
            option_value text NOT NULL DEFAULT '',
            PRIMARY KEY  (ID),
            UNIQUE KEY option_name (option_name)
        ) $this->charset_collate;\n";

	 	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql_create_table );
	}


	/**
	 * Create master slider tables
	 *
	 * Should be invoked on plugin activation
	 *
	 * @since 1.0
	 * @return null
	 */
	public function create_tables() {
		global $wpdb, $charset_collate;

		// set database character collate
		if ( ! empty( $wpdb->charset ) )
	        $this->charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
	    if ( ! empty( $wpdb->collate ) )
	        $this->charset_collate .= " COLLATE {$wpdb->collate}";

	    // if ( $wpdb->get_var( "SHOW TABLES LIKE '{$this->sliders}'" )  != $this->sliders  )
		$this->create_table_sliders();

	    // if ( $wpdb->get_var( "SHOW TABLES LIKE '{$this->options}'" ) != $this->options )
        $this->create_table_options();

		// update tables version to current version
		update_option( "masterslider_db_version", self::DB_VERSION );

		do_action( 'masterslider_tables_created', $this->tables  );
	}


    /**
     * Update master slider tables
     *
     * Should be invoked on plugin updates
     *
     * @since 1.1
     * @return null
     */
    public function update_tables() {

        if( version_compare( self::DB_VERSION, '1.3', '>=') ){

            // pull mulitple row results from sliders table
            if( $results = $this->get_sliders_list( 0, 0, 'ID', 'DESC', "1") ){
                foreach ( $results as $row_index => $row ) {
                    if( isset( $row['alias'] ) && empty( $row['alias'] ) ){
                        $row['alias'] = $this->generate_slider_alias( $row['ID'] );
                        $this->update_slider( $row['ID'], array( 'alias' => $row['alias'] ) );
                    }
                }
            }
        }

    }


	/**
	 * Updates masterslider tables if update is required
	 *
	 * @since 1.0
	 * @return bool  is any update required for tabels?
	 */
	public function maybe_update_tables(){
		// check if the tables need update
		if( get_option( 'masterslider_db_version', '0' ) == self::DB_VERSION )
			return false;

        $this->create_tables();
		$this->update_tables();

		do_action( 'masterslider_tables_updated', $this->tables );

		return true;
	}


	/**
	 * Drop all master slider tables
	 *
	 * @since 1.0
	 * @return null
	 */
	public function delete_tables(){
		global $wpdb;

		foreach ( $this->tables as $table_id => $table_name) {
			$wpdb->query("DROP TABLE IF EXISTS $table_name");
		}
	}


	/**
	 * Filter Masterslider tables to drop when the blog is deleted
	 *
	 * @since 1.8
	 * @return null
	 */
	public function wpmu_drop_tables( $tables, $blog_id ){
		global $wpdb;
		$tables[] = $wpdb->base_prefix . $blog_id . '_masterslider_sliders';
		$tables[] = $wpdb->base_prefix . $blog_id . '_masterslider_options';
		return $tables;
	}





	/**
	 * Adds new slider in sliders table
	 *
	 * @param array $fields   array of fields for sliders table
	 * @example array(  'title' => '', 'type' => '', 'skin' => '', 'template' => '',
	 *          		'common_params'	=> array(), 'special_params' => array(),
	 *          		'panel_data' => '', 'is_active' => 1 );
	 *
	 * @return int|false ID number for new inserted row or false if the row could not be inserted.
	 */
	public function add_slider($fields = array() ) {
		global $wpdb;

		// default fields in sliders table
		$defaults = array(
			'title' 		=> 'Untitled Slider',
            'alias'         => $this->generate_slider_alias(),
			'type'			=> '',  // custom, flickr, instagram, facebook, post
			'slides_num'	=> 0,
			'date_created'	=> '',
			'date_modified'	=> '',
			'params'		=> array(),
			'custom_styles' => '',
			'custom_fonts'  => '',
			'status'		=> 'published'
		);

		// merge input $fields with defaults
		$data = wp_parse_args($fields, $defaults);

		// set current time as date if date is not specified
		if ( empty($data['date_created']) || '0000-00-00 00:00:00' == $data['date_created'] )
			$data['date_created'] = current_time('mysql');


		if ( empty($data['date_modified']) || '0000-00-00 00:00:00' == $data['date_modified'] )
			$data['date_modified'] = current_time('mysql');

		if( isset($data['ID']) )
			unset($data['ID']);

		// map through some fields and serialize values if data type is array
		$data = $this->maybe_serialize_fields($data);

		// An array of formats to be mapped to each of the value in $data
		$format = array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');

		// Insert a row into the table. returns false if the row could not be inserted.
		$status = $wpdb->insert( $this->sliders, $data, $format );

		return false === $status ? $status: $wpdb->insert_id;
	}


	/**
	 * Updates a slider data in sliders table
	 *
	 * @param int $slider_id the slider id that is going to be updated
	 * @param array $fields   array of fields in sliders table that needs to be updated
	 * @param array|string (optional) An array of formats to be mapped to each of the values in $fields
	 * @example array(  'title' => '', 'type' => '', 'custom_styles'	=> array(), 'custom_fonts' => array(),
	 *          		'params' => '', 'status' => 'published' );
	 *
	 * @return int|false The number of rows updated, or false on error.
	 */
	public function update_slider($slider_id, $fields, $format = null ) {
		global $wpdb;

		if ( ! isset($slider_id) || ! is_numeric($slider_id) ) {
			return false;
		}

		if( ! isset($fields) || empty($fields) ){
			return;
		}

		// default required field while updating
		$defaults = array(
			'date_modified'	=> ''
		);

		// merge input $fields with defaults
		$data = wp_parse_args($fields, $defaults);

		// set modified date to current time
		if( empty( $data['date_modified'] ) )
			$data['date_modified'] = current_time('mysql');


		$data = $this->maybe_serialize_fields($data);

		//  slider id as WHERE clause
		$where = array( 'ID' => $slider_id );

		// An array of formats to be mapped to each of the values in $where
		$where_format = array( '%d' );

		// Insert a row into the table
		return $wpdb->update( $this->sliders, $data, $where, $format, $where_format);
	}


	/**
	 * Remove a specific slider data from sliders table by both slider ID and alias
	 *
     * @param  int $slider_id  The ID of the slider you'd like to be removed
     * @param  int $by         The field name where we search for slider. possible values 'ID' and 'alias'
	 *
	 * @return bool  returns true on success or false on error
	 */
	public function delete_slider( $slider_id, $by = 'ID' ) {
		global $wpdb;

		if ( ! empty( $slider_id ) ) {
            $by = strtolower( $by );

            // Remove slider by ID
            if( 'id' == $by && is_numeric( $slider_id ) ){

                return $wpdb->delete(
                    $this->sliders,
                    array( 'ID' => (int)$slider_id ),
                    array( '%d' )
                );

            // Remove slider by alias
            } elseif ( 'alias' == $by ) {

                return $wpdb->delete(
                    $this->sliders,
                    array( 'alias' => $slider_id ),
                    array( '%s' )
                );

            }
        }

		return  false;
	}


	/**
	 * Get slider data by slider id/alias from slider table (for single )
	 *
	 * @param  int $slider_id  The ID of the slider you'd like to get the content
     * @param  int $by         The field name where we search for slider. possible values 'ID' and 'alias'
     *
	 * @return array|null 	   Slider data in array or null if no result found
	 */
	public function get_slider( $slider_id, $by = 'ID' ) {
		global $wpdb;

        $sql = '';

		if ( ! empty( $slider_id ) ) {
            $by = strtolower( $by );

            // Remove slider by ID
            if( 'id' == $by && is_numeric( $slider_id ) ){

                $sql = $wpdb->prepare( "SELECT * FROM {$this->sliders} WHERE ID = %d", (int)$slider_id );

            // Remove slider by alias
            } elseif ( 'alias' == $by ) {

                $sql = $wpdb->prepare( "SELECT * FROM {$this->sliders} WHERE alias = %s", $slider_id );

            }
		}

		if( empty( $sql ) ){
            return null;
        }

        $result = $wpdb->get_row( $sql, ARRAY_A );

		return $this->maybe_unserialize_fields($result);
	}


	/**
	 * Duplicate a slider in new row
	 *
	 * @param  int $slider_id  The ID of the slider you'd like to duplicate
	 * @return bool   true on success and false on failure
	 */
	public function duplicate_slider( $slider_id ) {

		if( ! $fields = $this->get_slider($slider_id) )
			return false;

		$fields['title'] = $this->duplicate_title( $fields['title'] );

		return (bool) $this->add_slider($fields);
	}


	/**
	 * Add new slider with preset data
	 *
	 * @param  string $slider_params  The slider panel data
	 * @param  string $slider_title   The slider title
	 * @return int|false ID number for new inserted row or false if the row could not be inserted.
	 */
	public function import_slider( $fields = array() ) {

		if( ! isset( $fields['title'] ) || empty( $fields['title'] ) )
			$fields['title'] = 'Untitled Slider';

        $fields['title'] = $this->duplicate_title( $fields['title'] );

        // generate an alias if it is not set
        if( ! isset( $fields['alias'] ) || empty( $fields['alias'] ) ){
            $fields['alias'] = $this->generate_slider_alias();
        }

        $fields['alias'] = $this->validate_slider_alias( $fields['alias'] );

		return $this->add_slider( $fields );
	}


    /**
     * If the alias was registered before, it will change the alias to a unnique name
     *
     * @param  string $alias The slider alias name
     * @return string        A unique slider alias
     */
    public function validate_slider_alias( $alias, $slider_id = null ){
        $sanitized_alias = sanitize_title( $alias );
        $valid_alias     = $sanitized_alias;
        $counter         = 0;

        while( $slider_data = $this->get_slider( $valid_alias, 'alias' ) ){
            if( $slider_id && isset( $slider_data['ID'] ) && $slider_id == $slider_data['ID'] ){
                return $valid_alias;
            }
            ++$counter;
            $valid_alias = $sanitized_alias .'-'. $counter;
        }

        return $valid_alias;
    }


    /**
     * Checks whether the slider alias exists in slider table or not
     *
     * @param  string $alias The slider alias name
     * @return boolean       True if the slider alias exists in slider table, false otherwise
     */
    public function slider_alias_exists( $alias ){
        return $this->get_slider( $alias, 'alias' ) ? true : false;
    }


    /**
     * Generates a unique slider ID base on slider ID
     *
     * @param  string $new_slider_id    The slider ID
     * @return string                   A unique slider alias
     */
    public function generate_slider_alias( $new_slider_id = '' ){

        if( empty( $new_slider_id ) ){
            $sliders = $this->get_sliders( 0, 0, 'ID', 'DESC' );

            if( ! empty( $sliders ) && is_array( $sliders ) ){
                $new_slider_id = $sliders[0]['ID'];
            }

            $new_slider_id = (int) $new_slider_id + 1;

        }

        $alias = 'ms-' . $new_slider_id;
        return $this->validate_slider_alias( $alias );
    }

	/**
	 * Get the value of a single field for a spesific slider
	 *
	 * @param  int    $slider_id   The ID of the slider you'd like to get value of its field
	 * @param  string $field_name  The field name in slider table to get value from
	 * @return string|null 	field value or null if no result found
	 */
	public function get_slider_field_val( $slider_id, $field_name ) {
		global $wpdb;

		if ( ! isset( $slider_id ) || ! is_numeric( $slider_id ) ) {
			return '';
		}

		$result = $this->get_slider($slider_id);

		return ( $result && isset( $result[$field_name] ) ) ? maybe_unserialize( $result[$field_name] ) : NULL;
	}


	/**
	 * Get an array containing row results (serialized) from sliders table
	 *
	 * @param  int $args        The query args
	 * @return array|null 	    Sliders data in an array or null if no result found
	 */
	public function ms_query( $args = array() ) {
		global $wpdb;

		$default_args = array(
			'perpage' => 0,
			'offset'  => 0,
			'orderby' => 'ID',
			'order'   => 'DESC',
			'where'   => "status='published'",
			'like' 	  => ''
		);

		$args = wp_parse_args( $args, $default_args );


		// convert perpage type to number
		$limit_num = (int) $args['perpage'];

		// convert offset type to number
		$offset_num = (int) $args['offset'];

		// remove limit if limit number is set to 0
		$limit  = ( 1 > $limit_num ) ? '' : 'LIMIT '. $limit_num;

		// remove offect if offset number is set to 0
		$offset = ( 0 == $offset_num )? '' : 'OFFSET '. $offset_num;

		// add LIKE if defined
		$like  = empty( $args['like'] ) ? '' : 'LIKE '. $args['like'];

		$where = empty( $args['where'] ) ? '' : 'WHERE '. $args['where'];

        // sanitize sort type
        $order   = strtolower( $args['order'] ) === 'desc' ? 'DESC' : 'ASC';
        $orderby_clause = $args['orderby'] .' '. $order;

        $orderby_clause = sanitize_sql_orderby( $orderby_clause );

        $sql = "
            SELECT *
            FROM {$this->sliders}
            $where
            ORDER BY $orderby_clause
            $limit
            $offset
            ";

		return $wpdb->get_results( $sql, ARRAY_A );
	}


	/**
	 * Get an array containing row results (serialized) from sliders table
	 *
	 * @param  int $perpage     Maximum number of rows to return - 0 means no limit
     * @param  int $offset      The offset of the first row to return
     * @param  string $orderby  The field name to order results by
     * @param  string $order    The sort type. 'DESC' or 'ASC'
     * @param  string $where    The sql filter to get results by
	 * @return array|null 	    Sliders data in an array or null if no result found
	 */
	public function get_sliders_list( $perpage = 0, $offset  = 0, $orderby = 'ID', $order = 'DESC', $where = "status='published'" ) {
		global $wpdb;

		$args = array(
			'perpage' => $perpage,
			'offset'  => $offset,
			'orderby' => $orderby,
			'order'   => $order,
			'where'   => $where
		);

		return $this->ms_query( $args );
	}



	/**
	 * Get an array containing row results (unserialized) from sliders table (with all slider table fields)
	 *
	 * @param  int $perpage     Maximum number of rows to return
     * @param  int $offset      The offset of the first row to return
     * @param  string $orderby  The field name to order results by
     * @param  string $sort     The sort type. 'DESC' or 'ASC'
     * @param  string $where    The sql filter to get results by
	 * @return array|null 	    Slider data in array or null if no result found
	 */
	public function get_sliders( $perpage = 0, $offset  = 0, $orderby = 'ID', $sort = 'DESC', $where = "status='published'" ) {

		// pull mulitple row results from sliders table
		if( ! $results = $this->get_sliders_list( $perpage, $offset, $orderby, $sort, $where ) ){
			return;
		}

		// map through some fields and unserialize values if some data fields are serialized
		foreach ( $results as $row_index => $row ) {
			$results[ $row_index ] = $this->maybe_unserialize_fields($row);
		}

		return $results;
	}


	/**
	 * Get total number of sliders from sliders table
	 *
	 * @return int|null 	 total number of sliders or null on failure
	 */
	public function get_total_sliders_count( $where = "status='published'" ) {
		global $wpdb;

		$result = $wpdb->get_results( "SELECT count(ID) AS total FROM {$this->sliders} WHERE {$where} ", ARRAY_A );
		return $result ? (int)$result[0]['total'] : null;
	}







	/**
	 * Insert option data in new record in options table
	 *
	 * @param   string $option_name a unique name for option
	 * @param   string $option_value the option value
	 *
	 * @return bool False if option was not added and true if option was added.
	 */
	public function add_option( $option_name, $option_value = '' ) {
		global $wpdb;

		$option_name = trim( $option_name );
		if( empty( $option_name ) ) {
			return false;
		}

		if ( is_object($option_value) )
			$option_value = clone $option_value;


		// serialize the option value
		$option_value = maybe_serialize( $option_value );

		$fields = array(
			'option_name' 	=> $option_name,
			'option_value' 	=> $option_value
		);

		// check if key already exist in master slider options table
		$sql = $wpdb->prepare( "SELECT * FROM {$this->options} WHERE option_name = %s", $option_name );
		// skip adding option if option added to options table before
		if( $result = $wpdb->get_row( $sql, ARRAY_A ) )
			return false;

		// An array of formats to be mapped to each of the value in $data
		$format = array('%s', '%s');

		// Insert a row into the table. returns false if the row could not be inserted.
		$result = $wpdb->insert( $this->options, $fields, $format );

		if(false === $result)
			return false;

		wp_cache_set( $option_name, $option_value, 'masterslider' );

		do_action( 'masterslider_added_option', $option_name, $option_value );
		return true;
	}


	/**
	 * Get option value
	 *
	 * @param   string  $option_name a unique name for option
	 * @param   string  $default_value  a value to return by function if option_value not found
	 * @return  string  option_value or default_value
	 */
	public function get_option( $option_name, $default_value = '' ) {
		global $wpdb;

		$option_name = trim( $option_name );
		if( empty( $option_name ) ) {
			return $default_value;
		}

		$value = wp_cache_get( $option_name, 'masterslider' );

		// query the value if value is not available in cache
		if( false === $value ) {

			$sql = $wpdb->prepare( "SELECT * FROM {$this->options} WHERE option_name = %s", $option_name );
			$result = $wpdb->get_row( $sql, ARRAY_A );

			$value = $result && isset( $result['option_value'] ) ? $result['option_value'] : $default_value;

			// serialize and cache this option for next request
			$serialized_value = maybe_serialize( $value );
			wp_cache_set( $option_name, $serialized_value, 'masterslider' );
		}

		return maybe_unserialize( $value );
	}



	/**
	 * Update option value in options table, if option_name does not exist then insert new option
	 *
	 * @param   string $option_name a unique name for option
	 * @param   string $option_value the option value
	 *
	 * @return int|false ID number for new inserted row or false if the option can not be updated.
	 */
	public function update_option( $option_name, $option_value = '' ) {
		global $wpdb;

		$option_name = trim( $option_name );
		if( empty( $option_name ) ) {
			return false;
		}

		if ( is_object($option_value) )
			$option_value = clone $option_value;

		// get current option value
		$old_value = $this->get_option( $option_name );

		$option_value = apply_filters( 'msp_pre_update_option_' . $option_name, $option_value, $old_value );

		// If the new and old values are the same, no need to update.
		if ( $option_value === $old_value )
			return false; // 'has same value';

		$option_value = maybe_serialize( $option_value );


		$result = $wpdb->update( $this->options, array( 'option_value' => $option_value ), array( 'option_name' => $option_name ) );
		if ( ! $result ) {
			return $this->add_option( $option_name, $option_value);
		} else {
			wp_cache_set( $option_name, $option_value, 'masterslider' );
		}

		return true;
	}


	/**
	 * Remove a specific option name from options table
	 *
	 * @param   string $option_name a unique name for option
	 * @return bool True, if option is successfully deleted. False on failure.
	 */
	public function delete_option( $option_name ) {
		global $wpdb;

		$option_name = trim( $option_name );
		if( empty( $option_name ) ) {
			return false;
		}

		$result = $wpdb->delete(
			$this->options,
			array( 'option_name' => $option_name ),
			array( '%s' )
		);

		wp_cache_delete( $option_name, 'masterslider' );

		return (bool) $result;
	}







	// map through some fields and unserialize values if data field is serialized
	protected function maybe_unserialize_fields($row_fields){
		if ( empty($row_fields) ) {
			return $row_fields;
		}

		foreach ( $row_fields as $key => $value) {
			$row_fields[$key] = maybe_unserialize( $value );
		}
		return $row_fields;
	}



	// map through some fields and serialize values if data type is array
	protected function maybe_serialize_fields($row_fields){
		if ( empty($row_fields) ) {
			return $row_fields;
		}

		foreach ( $row_fields as $key => $value) {
			$row_fields[$key] = maybe_serialize( $value );
		}
		return $row_fields;
	}


	/**
	 * Insert a row into a table.
	 * @param array $fields    array of fields and values to insert
	 * @param array $defaults  array of default fields value to insert if field value is not set
	 *
	 * @return int|false ID number for new inserted row or false if the row could not be inserted.
	 */
	public function insert( $table_name, $fields = array(), $defaults = array(), $format = NULL ) {
		global $wpdb;

		if( empty( $fields ) ) {
			return false;
		}

		// merge input $fields with defaults
		$data = wp_parse_args($fields, $defaults);

		// map through some fields and serialize values if data type is array or object
		$data = $this->maybe_serialize_fields( $data );

		// Insert a row into the table. returns false if the row could not be inserted.
		$result = $wpdb->insert( $table_name, $data, $format );

		return (false === $result)? $result : $wpdb->insert_id;
	}


	public function duplicate_title($title, $suffix = '' ){
		$title = trim($title);
		if( empty($suffix) ){
			$suffix = __('copy', MSWP_TEXT_DOMAIN);
		}

		$suffix_num = substr($title, -2);

		if (strpos($title, ' '.$suffix) !== false) {
		    $suffix_num = substr($title, -2);
		    if( is_numeric($suffix_num) ){
		    	$suffix_num = (int)$suffix_num + 1;
		    	$title = trim(substr($title, 0, -2)) . ' ' . $suffix_num;
		    } else {
		    	$title = trim($title) . ' 1';
		    }
		} else {
			$title .= ' '.$suffix;
		}
		return $title;
	}

}

global $mspdb;
if( is_null( $mspdb ) ) $mspdb = new MSP_DB();
