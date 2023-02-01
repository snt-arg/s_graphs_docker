<?php

/**
 * Class BEThemeImporter
 *
 * This class provides the capability to import demo content as well as import widgets and WordPress menus
 *
 * @since 2.2.0
 *
 * @category RadiumFramework
 * @package  NewsCore WP
 * @author   Franklin M Gitonga
 * @link     http://radiumthemes.com/
 *
 */
class BEThemeImporter {

	/**
	 * Holds a copy of the object for easy reference.
	 *
	 * @since 2.2.0
	 *
	 * @var object
	 */
	public $theme_options_file;

	/**
	 * Holds a copy of the object for easy reference.
	 *
	 * @since 2.2.0
	 *
	 * @var object
	 */
	public $widgets;

	/**
	 * Holds a copy of the object for easy reference.
	 *
	 * @since 2.2.0
	 *
	 * @var object
	 */
	public $content_demo;

	/**
	 * Flag imported to prevent duplicates
	 *
	 * @since 2.2.0
	 *
	 * @var object
	 */
	public $flag_as_imported = array();

  public $customizer_data;

  public $demo_settings;

  private static $demo_names;

    /**
     * Holds a copy of the object for easy reference.
     *
     * @since 2.2.0
     *
     * @var object
     */
    private static $instance;

    /**
     * Constructor. Hooks all interactions to initialize the class.
     *
     * @since 2.2.0
     */
    public function __construct() {
        if(isset($_POST['demo']) && !empty($_POST['demo'])) {
          $demo = $_POST['demo'].'/';
        } else {
          $demo = '';
        }
        self::$instance = $this;
        $this->demo_files_path = $this->demo_files_path . $demo;
        $this->theme_options_file = $this->demo_files_path . $this->theme_options_file_name;
        $this->colorhub_options_file = $this->demo_files_path . $this->colorhub_options_file_name;
        $this->typehub_options_file = $this->demo_files_path . $this->typehub_options_file_name;
        $this->tatsu_global_sections_file = $this->demo_files_path . $this->tatsu_global_sections_file_name;
        $this->widgets = $this->demo_files_path . $this->widgets_file_name;
        $this->content_demo = $this->demo_files_path . $this->content_demo_file_name;
        $this->customizer_data = $this->demo_files_path . $this->customizer_data_name;
        $this->demo_settings = $this->get_demo_settings($demo);
        self::$demo_names = array(
          'v1' => 'v1 Main demo',
          'v2' => 'v2 Photography',
          'v3' => 'v3 Modern Portfolio',
          'v4' => 'v4 Shop',
          'v5' => 'v5 Boxed Minimal',
          'v6' => 'v6 Agency/Portfolio',
          'v7' => 'v7 Dark Photography',
          'v8' => 'v8 Digital Agency',
          'v9' => 'v9 Architecture',
          'v10' => 'v10 Dual Carousel',
          'v11' => 'v11 Business',
          'v12' => 'v12 Freelancer',
          'v13' => 'v13 Full Screen Sections',
          'v14' => 'v14 One Page',
          'v15' => 'v15 Scroll Parallax Portfolio',
          'v16' => 'v16 Mobile App',
          'v17' => 'v17 Modern Photography',
          'v18' => 'v18 Restaurant',
          'v19' => 'v19 One Page Agency',
          'v20' => 'v20 Video Agency',
          'v21' => 'v21 Designer Portfolio',
          'v22' => 'v22 Fullscreen Photography',
          'v23' => 'v23 Modern Business',
          'v24' => 'v24 Justified Grid Photography',
          'v25' => 'v25 Creative Agency',
          'v26' => 'v26 Wedding',
          'v27' => 'v27 Apartment / Villa',
          'v28' => 'v28 Dark Portfolio & Agency',
          'v29' => 'v29 Minimal Portfolio & Agency',
          'v30' => 'v30 Architects',
          'v31' => 'v31 Freelancer',
          'v32' => 'v32 Coworking Space',
          'v33' => 'v33 Web Design Agency',
          'v34' => 'v34 Gym Fitness',
          'v35' => 'v35 Interior Design',
          'v36' => 'v36 Product Design',
          'v37' => 'v37 Winery',
          'v38' => 'v38 Vibrant Portfolio',
          'v39' => 'v39 Wedding Photography',  
          'v40' => 'V40 Cafe and Bistros', 
          'v41' => 'v41 Model Agency',  
          'v42' => 'V42 Salon / Barber Shop',
          'v43' => 'V43 Modern Landing Page', 
          'v44' => 'V44 Modern Creative Agency',
          'v45' => 'V45 Film Studio / Videographer ', 
          'v46' => 'V46 Luxury Spa', 
          'v47' => 'V47 Creative Agency Illustration style', 
          'v48' => 'V48 Modern Photography',   
          'v49' => 'V49 Split Screen Portfolio',   
          'v50' => 'V50 Title Carousel Portfolio',  
          'v51' => 'V51 Modern Coworking Space',                                 
          'v52' => 'V52 Writer / Author',                                 
          'shop_samples' => 'Shop Samples',
        );   
    }

    
    /**
     * [demo_installer description]
     *
     * @since 2.2.0
     *
     * @return [type] [description]
     */
    public function demo_installer() {
      
        ?>     

        <form id="be_import_form" method="post">
            <input type="hidden" name="demononce" value="<?php echo wp_create_nonce('radium-demo-code'); ?>" />
            <div class="clearfix">
            <div class="c-4 content">
            <h3 style="">Choose the contents </h3>
            <ul class="radio-list be_demo_content">
            <li class="demo_content" data-value="set_demo_content" class="click">
            <div class="loader"><span class="circle"></span></div>
                <div class="radio-option"><span class="checkmark">
    <div class="checkmark_stem"></div>
    <div class="checkmark_kick"></div>
</span></div><?php esc_html_e( 'Content ( Posts, Pages and other post types )', 'be-functions' ); ?>

              </li>
              <li class="theme_options" data-value="import_theme_options" class="click">
              <div class="loader"><span class="circle"></span></div>
                <div class="radio-option"><span class="checkmark">
    <div class="checkmark_stem"></div>
    <div class="checkmark_kick"></div>
</span></div><?php esc_html_e( 'Options Panel Settings', 'be-functions' ); ?>
              </li>

              <li class="typehub_options" data-value="import_typehub_options" class="click">
              <div class="loader"><span class="circle"></span></div>
                <div class="radio-option"><span class="checkmark">
    <div class="checkmark_stem"></div>
    <div class="checkmark_kick"></div>
</span></div><?php esc_html_e( 'Typography', 'be-functions' ); ?>
              </li>
              <li class="tatsu_global_sections" data-value="import_tatsu_global_sections" class="click">
              <div class="loader"><span class="circle"></span></div>
                <div class="radio-option"><span class="checkmark">
    <div class="checkmark_stem"></div>
    <div class="checkmark_kick"></div>
</span></div><?php esc_html_e( 'Tatsu Global Sections', 'be-functions' ); ?>
              </li>
              <li class="widgets" data-value="import_theme_widgets" class="click">
              <div class="loader"><span class="circle"></span></div>
                <div class="radio-option"><span class="checkmark">
    <div class="checkmark_stem"></div>
    <div class="checkmark_kick"></div>
</span></div><?php esc_html_e( 'Widgets', 'be-functions' ); ?>
              </li>
              <li class="slider" data-value="import_slider" class="click">
              <div class="loader"><span class="circle"></span></div>
                <div class="radio-option"><span class="checkmark">
    <div class="checkmark_stem"></div>
    <div class="checkmark_kick"></div>
</span></div><?php esc_html_e( 'Slider Data', 'be-functions' ); ?>
              </li>
              
                <li class="home_page" data-value="set_home_page" class="click">
                <div class="loader"><span class="circle"></span></div>
                <div class="radio-option"><span class="checkmark">
    <div class="checkmark_stem"></div>
    <div class="checkmark_kick"></div>
</span></div><?php esc_html_e( 'Set Home Page', 'be-functions' ); ?>
              </li>
            </ul>
            <input name="reset" class="panel-save button-primary" type="submit" value="<?php esc_html_e( 'Import data', 'be-functions' ); ?>" />
            <?php $page = get_page_by_title( "Home - v1" );
            
             ?>
            </div>
            <div class="c-8">
            <select class="image-picker" name="be_demo_file" style="width: 100px;">
              <?php
              $dir = $this->demos_folder();
              
            //  foreach ($dir as $dirinfo) {
               
               // if($dirinfo->isDir() && !$dirinfo->isDot()) {
                //  $demo_val = $dirinfo->getFilename();
                foreach(self::$demo_names as $folder_name => $label ) {
                  $src = BE_URL . '/inc/importer/demo-files/'.$folder_name.'/src.jpg';
                  
                  echo '<option data-img-label="'.esc_attr($label).'" data-img-src="'.$src.'"';
                  echo BEThemeDemoImporter::check_settings($folder_name);
                  echo 'value="'.$folder_name.'">'.$folder_name.'</option>';
                }
             //   }                
             // }

               ?>
            </select>
            </div>
            </div>
            
            <input type="hidden" name="action" value="demo-data" />
        </form>
        <?php
		
		
    }
    
    public function demos_folder($lookinside = '') {
      $demos_main_fo = BE_PATH . '/inc/importer/demo-files';

      if($lookinside != '') {
       $demos_dir = $demos_main_fo.'/'.$lookinside;
      } else {
        $demos_dir = $demos_main_fo;
      }
      $dir = new DirectoryIterator($demos_dir);
      if(!isset($dir) || empty($dir)) { return; }
      return $dir;
    }

    public function get_demo_settings($demo) {
      $folder_path = $this->demos_folder($demo);
      return $folder_path;
    }
    /**
     * add_widget_to_sidebar Import sidebars
     * @param  string $sidebar_slug    Sidebar slug to add widget
     * @param  string $widget_slug     Widget slug
     * @param  string $count_mod       position in sidebar
     * @param  array  $widget_settings widget settings
     *
     * @since 2.2.0
     *
     * @return null
     */
    public function add_widget_to_sidebar($sidebar_slug, $widget_slug, $count_mod, $widget_settings = array()) {

        $sidebars_widgets = get_option('sidebars_widgets');

        if(!isset($sidebars_widgets[$sidebar_slug]))
           $sidebars_widgets[$sidebar_slug] = array('_multiwidget' => 1);

        $newWidget = get_option('widget_'.$widget_slug);

        if(!is_array($newWidget))
            $newWidget = array();

        $count = count($newWidget)+1+$count_mod;
        $sidebars_widgets[$sidebar_slug][] = $widget_slug.'-'.$count;

        $newWidget[$count] = $widget_settings;

        update_option('sidebars_widgets', $sidebars_widgets);
        update_option('widget_'.$widget_slug, $newWidget);

    }

    public function _import_customizer($customize_data = '') {
      if(empty($customizer_data)) {
        $customizer_data = $this->customizer_data;
      }
      if(!class_exists('WP_Customize_Manager')) {
          require_once( ABSPATH . 'wp-includes/class-wp-customize-manager.php' );
      }
      global $wp_customize;
      $import_core = new BeSquaresCustomizeImport;
      $import_core->init($wp_customize, $customize_data);
    }
    public function set_demo_data( $file = '' ) {
      if(empty($file)) {
        $file = $this->content_demo;
      }
	    if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);

        require_once ABSPATH . 'wp-admin/includes/import.php';

        $importer_error = false;

        if ( !class_exists( 'WP_Importer' ) ) {

            $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
	
            if ( file_exists( $class_wp_importer ) ){

                require_once($class_wp_importer);

            } else {

                $importer_error = true;
            }
        }

        if ( !class_exists( 'WP_Import' ) ) {

            $class_wp_import = dirname( __FILE__ ) .'/wordpress-importer.php';

            if ( file_exists( $class_wp_import ) ) 
                require_once($class_wp_import);
            else
                $importer_error = true;
        }

        if($importer_error){

            die("Error on import");

        } else {
            if(!is_file( $file )) {
                echo "The XML file containing the dummy content is not available or could not be read .. You might want to try to set the file permission to chmod 755.<br/>If this doesn't work please use the Wordpress importer and import the XML file (should be located in your download .zip: Sample Content folder) manually ";
            } else {
               $wp_import = new WP_Import();
               $wp_import->fetch_attachments = true;
               $wp_import->import( $file );
               echo ('Contents Imported Successfully. ');
         	}
    	}

    }

    public function replace_content_url_to_hosting_url($url){
      if(stripos($url,"wp-content")!==false){
        $url =explode('wp-content',$url);
        $url = end($url);
        $url = content_url() .''.$url;
      }
      return $url;
    }

    public function set_demo_theme_options( $file = '' ) {
      if(empty($file)) {
        $file = $this->theme_options_file;
      }

      $colorhub_file = $this->colorhub_options_file;
      $colorhub_data = file_exists( $colorhub_file ) ? json_decode( file_get_contents( $colorhub_file ), true ) : false;

    	// File exists?
  		if ( ! file_exists( $file ) ) {
  			wp_die(
  				// __( 'Theme options Import file could not be found. ', 'radium' ),
  				'',
  				array( 'back_link' => true )
  			);
  		}

  		// Get file contents and decode
  		$data = file_get_contents( $file );
                $data = trim($data, '###');

  		$data = json_decode( $data, true );
                 
  		if ( empty( $data ) || ! is_array( $data ) ) {
  			wp_die(
  				__( 'Theme options import data could not be read. Please try a different file.', 'radium' ),
  				'',
  				array( 'back_link' => true )
  			);
  		} else{
        echo('');
        echo('Theme Options Imported successfully');
      }
      //Replace header options url to hostinhg url
      if(!empty($data['opt-header-style'])){
        $data['opt-header-style'] = $this->replace_content_url_to_hosting_url($data['opt-header-style']);
      }
      if(!empty($data['top_header_hamburger_style'])){
        $data['top_header_hamburger_style'] = $this->replace_content_url_to_hosting_url($data['top_header_hamburger_style']);
      }

      if(!empty($data['left-header-style'])){
        $data['left-header-style'] = $this->replace_content_url_to_hosting_url($data['left-header-style']);
      }
      if(!empty($data['left_header_hamburger_style'])){
        $data['left_header_hamburger_style'] = $this->replace_content_url_to_hosting_url($data['left_header_hamburger_style']);
      }
      
      
  		// Hook before import
  		$data = apply_filters( 'radium_theme_import_theme_options', $data );
      update_option($this->theme_option_name, $data);
      if( function_exists( 'colorhub_import' ) && is_array( $colorhub_data ) ) {
        colorhub_import( $colorhub_data );
      }
    }

    public function set_typehub_options( $file = '' ) {
      if(empty($file)) {
        $file = $this->typehub_options_file;
      }
    	// File exists?
  		if ( ! file_exists( $file ) ) {
  			wp_die(
  				'',
  				array( 'back_link' => true )
  			);
  		}

  		// Get file contents and decode
  		$data = file_get_contents( $file );
                $data = trim($data, '###');

  		$data = json_decode( $data, true );
                 
  		if ( empty( $data ) || ! is_array( $data ) || !function_exists('typehub_import') ) {
  			wp_die(
  				__( 'Typehub import data could not be read. Please try a different file.', 'radium' ),
  				'',
  				array( 'back_link' => true )
  			);
  		}

      if( typehub_import( $data ) ) {
        echo 'Typehub Data Imported Successfully';
      } else {
        echo 'Failed to import Typehub data';
      }
    }

    /**
     * Import Global Section settings
     */
    public function set_global_section_options( $file = '' ) {
      if(empty($file)) {
        $file = $this->tatsu_global_sections_file;
      }
    	// File exists?
  		if ( ! file_exists( $file ) ) {
  			wp_die(
  				'',
  				array( 'back_link' => true )
  			);
  		}

  		$data = file_get_contents( $file );

  		if ( empty( $data ) || !function_exists('tatsu_register_global_module') ) {
  			wp_die(
  				__( 'Tatsu Global Sections import data could not be read. Please try a different file.', 'radium' ),
  				'',
  				array( 'back_link' => true )
  			);
      }

      if( update_option( 'tatsu_global_section_data', $data ) ) {
        echo 'Tatsu Global Section Data Imported Successfully';
      } else {
        echo 'Failed to import Tatsu Global Section data';
      }
    }    
  

    /**
     * Available widgets
     *
     * Gather site's widgets into array with ID base, name, etc.
     * Used by export and import functions.
     *
     * @since 2.2.0
     *
     * @global array $wp_registered_widget_updates
     * @return array Widget information
     */
    function available_widgets() {
    	global $wp_registered_widget_controls;
    	$widget_controls = $wp_registered_widget_controls;
    	$available_widgets = array();
    	foreach ( $widget_controls as $widget ) {
    		if ( ! empty( $widget['id_base'] ) && ! isset( $available_widgets[$widget['id_base']] ) ) { // no dupes

    			$available_widgets[$widget['id_base']]['id_base'] = $widget['id_base'];
    			$available_widgets[$widget['id_base']]['name'] = $widget['name'];

    		}

    	}

    	return apply_filters( 'radium_theme_import_widget_available_widgets', $available_widgets );

    }


    /**
     * Process import file
     *
     * This parses a file and triggers importation of its widgets.
     *
     * @since 2.2.0
     *
     * @param string $file Path to .wie file uploaded
     * @global string $widget_import_results
     */
    function process_widget_import_file( $file = '') {
      if(empty($file)) { 
        $file = $this->widgets;
      }
    	// File exists?
    	if ( ! file_exists( $file ) ) {
    		wp_die(
    			// __( 'Widget Import file could not be found. ', 'radium' ),
    			'',
    			array( 'back_link' => true )
    		);
    	}

    	// Get file contents and decode
    	$data = file_get_contents( $file );
    	$data = json_decode( $data );

    	// Delete import file
    	//unlink( $file );

    	// Import the widget data
    	// Make results available for display on import/export page
    	$this->widget_import_results = $this->import_widgets( $data );

    }


    /**
     * Import widget JSON data
     *
     * @since 2.2.0
     * @global array $wp_registered_sidebars
     * @param object $data JSON widget data from .wie file
     * @return array Results array
     */
    public function import_widgets( $data ) {

    	global $wp_registered_sidebars;

    	// Have valid data?
    	// If no data or could not decode
    	if ( empty( $data ) || ! is_object( $data ) ) {
    		wp_die(
    			__( 'Widget import data could not be read. Please try a different file.', 'radium' ),
    			'',
    			array( 'back_link' => true )
    		);
    	}

    	// Hook before import
    	$data = apply_filters( 'radium_theme_import_widget_data', $data );

    	// Get all available widgets site supports
    	$available_widgets = $this->available_widgets();

    	// Get all existing widget instances
    	$widget_instances = array();
    	foreach ( $available_widgets as $widget_data ) {
    		$widget_instances[$widget_data['id_base']] = get_option( 'widget_' . $widget_data['id_base'] );
    	}

    	// Begin results
    	$results = array();

    	// Loop import data's sidebars
    	foreach ( $data as $sidebar_id => $widgets ) {

    		// Skip inactive widgets
    		// (should not be in export file)
    		if ( 'wp_inactive_widgets' == $sidebar_id ) {
    			continue;
    		}

    		// Check if sidebar is available on this site
    		// Otherwise add widgets to inactive, and say so
    		if ( isset( $wp_registered_sidebars[$sidebar_id] ) ) {
    			$sidebar_available = true;
    			$use_sidebar_id = $sidebar_id;
    			$sidebar_message_type = 'success';
    			$sidebar_message = '';
    		} else {
    			$sidebar_available = false;
    			$use_sidebar_id = 'wp_inactive_widgets'; // add to inactive if sidebar does not exist in theme
    			$sidebar_message_type = 'error';
    			$sidebar_message = __( 'Sidebar does not exist in theme (using Inactive)', 'radium' );
    		}

    		// Result for sidebar
    		$results[$sidebar_id]['name'] = ! empty( $wp_registered_sidebars[$sidebar_id]['name'] ) ? $wp_registered_sidebars[$sidebar_id]['name'] : $sidebar_id; // sidebar name if theme supports it; otherwise ID
    		$results[$sidebar_id]['message_type'] = $sidebar_message_type;
    		$results[$sidebar_id]['message'] = $sidebar_message;
    		$results[$sidebar_id]['widgets'] = array();

    		// Loop widgets
    		foreach ( $widgets as $widget_instance_id => $widget ) {

    			$fail = false;

    			// Get id_base (remove -# from end) and instance ID number
    			$id_base = preg_replace( '/-[0-9]+$/', '', $widget_instance_id );
    			$instance_id_number = str_replace( $id_base . '-', '', $widget_instance_id );

    			// Does site support this widget?
    			if ( ! $fail && ! isset( $available_widgets[$id_base] ) ) {
    				$fail = true;
    				$widget_message_type = 'error';
    				$widget_message = __( 'Site does not support widget', 'radium' ); // explain why widget not imported
    			}

    			// Filter to modify settings before import
    			// Do before identical check because changes may make it identical to end result (such as URL replacements)
    			$widget = apply_filters( 'radium_theme_import_widget_settings', $widget );

    			// Does widget with identical settings already exist in same sidebar?
    			if ( ! $fail && isset( $widget_instances[$id_base] ) ) {

    				// Get existing widgets in this sidebar
    				$sidebars_widgets = get_option( 'sidebars_widgets' );
    				$sidebar_widgets = isset( $sidebars_widgets[$use_sidebar_id] ) ? $sidebars_widgets[$use_sidebar_id] : array(); // check Inactive if that's where will go

    				// Loop widgets with ID base
    				$single_widget_instances = ! empty( $widget_instances[$id_base] ) ? $widget_instances[$id_base] : array();
    				foreach ( $single_widget_instances as $check_id => $check_widget ) {

    					// Is widget in same sidebar and has identical settings?
    					if ( in_array( "$id_base-$check_id", $sidebar_widgets ) && (array) $widget == $check_widget ) {

    						$fail = true;
    						$widget_message_type = 'warning';
    						$widget_message = __( 'Widget already exists', 'radium' ); // explain why widget not imported

    						break;

    					}

    				}

    			}

    			// No failure
    			if ( ! $fail ) {

    				// Add widget instance
    				$single_widget_instances = get_option( 'widget_' . $id_base ); // all instances for that widget ID base, get fresh every time
    				$single_widget_instances = ! empty( $single_widget_instances ) ? $single_widget_instances : array( '_multiwidget' => 1 ); // start fresh if have to
    				$single_widget_instances[] = (array) $widget; // add it

    					// Get the key it was given
    					end( $single_widget_instances );
    					$new_instance_id_number = key( $single_widget_instances );

    					// If key is 0, make it 1
    					// When 0, an issue can occur where adding a widget causes data from other widget to load, and the widget doesn't stick (reload wipes it)
    					if ( '0' === strval( $new_instance_id_number ) ) {
    						$new_instance_id_number = 1;
    						$single_widget_instances[$new_instance_id_number] = $single_widget_instances[0];
    						unset( $single_widget_instances[0] );
    					}

    					// Move _multiwidget to end of array for uniformity
    					if ( isset( $single_widget_instances['_multiwidget'] ) ) {
    						$multiwidget = $single_widget_instances['_multiwidget'];
    						unset( $single_widget_instances['_multiwidget'] );
    						$single_widget_instances['_multiwidget'] = $multiwidget;
    					}

    					// Update option with new widget
    					update_option( 'widget_' . $id_base, $single_widget_instances );

    				// Assign widget instance to sidebar
    				$sidebars_widgets = get_option( 'sidebars_widgets' ); // which sidebars have which widgets, get fresh every time
    				$new_instance_id = $id_base . '-' . $new_instance_id_number; // use ID number from new widget instance
    				$sidebars_widgets[$use_sidebar_id][] = $new_instance_id; // add new instance to sidebar
    				update_option( 'sidebars_widgets', $sidebars_widgets ); // save the amended data

    				// Success message
    				if ( $sidebar_available ) {
    					$widget_message_type = 'success';
    					$widget_message = __( 'Widgets Imported', 'radium' );
    				} else {
    					$widget_message_type = 'warning';
    					$widget_message = __( 'Imported to Inactive', 'radium' );
    				}

    			}

    			// Result for widget instance
    			$results[$sidebar_id]['widgets'][$widget_instance_id]['name'] = isset( $available_widgets[$id_base]['name'] ) ? $available_widgets[$id_base]['name'] : $id_base; // widget name or ID if name not available (not supported by site)
    			$results[$sidebar_id]['widgets'][$widget_instance_id]['title'] = $widget->title ? $widget->title : __( 'No Title', 'radium' ); // show "No Title" if widget instance is untitled
    			$results[$sidebar_id]['widgets'][$widget_instance_id]['message_type'] = $widget_message_type;
    			$results[$sidebar_id]['widgets'][$widget_instance_id]['message'] = $widget_message;

    		}

    	}
      echo $widget_message;
    	// Hook after import
    	do_action( 'radium_theme_import_widget_after_import' );

    	// Return results
    	return apply_filters( 'radium_theme_import_widget_results', $results );

    }

}

?>