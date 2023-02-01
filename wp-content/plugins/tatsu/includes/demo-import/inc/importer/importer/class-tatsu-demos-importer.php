<?php

/**
 * Class TatsuImporter
 *
 * This class provides the capability to import demo content as well as import widgets and WordPress menus
 *
 * @since 1.0
 *
 *
 */
class TatsuImporter {

	/**
	 * Holds a copy of the object for easy reference.
	 *
	 * @since 1.0
	 *
	 * @var object
	 */
	public $theme_options_file;

	/**
	 * Holds a copy of the object for easy reference.
	 *
	 * @since 1.0
	 *
	 * @var object
	 */
	public $widgets;

	/**
	 * Holds a copy of the object for easy reference.
	 *
	 * @since 1.0
	 *
	 * @var object
	 */
	public $content_demo;

	/**
	 * Flag imported to prevent duplicates
	 *
	 * @since 1.0
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
     * @since 1.0
     *
     * @var object
     */
    private static $instance;

    /**
     * Constructor. Hooks all interactions to initialize the class.
     *
     * @since 1.0
     */
    public function __construct() {
        if(isset($_POST['exp-demo']) && !empty($_POST['exp-demo'])) {
          $demo = $_POST['exp-demo'].'/';
        } else {
          $demo = '';
        }
        self::$instance = $this;
        $this->demo_files_path = $this->demo_files_path . $demo;
        $this->colorhub_options_file = $this->demo_files_path . $this->colorhub_options_file_name;
        $this->typehub_options_file = $this->demo_files_path . $this->typehub_options_file_name;
        $this->tatsu_header_file = $this->demo_files_path . $this->tatsu_header_file_name;
        $this->tatsu_global_sections_file = $this->demo_files_path . $this->tatsu_global_sections_file_name;
        $this->widgets = $this->demo_files_path . $this->widgets_file_name;
        $this->content_demo = $this->demo_files_path . $this->content_demo_file_name;
        $this->customizer_data = $this->demo_files_path . $this->customizer_data_name;
        $this->demo_settings = $this->get_demo_settings($demo);
        $pro = ' PRO';
        if(is_tatsu_authorized()){
          $pro = '';
        }
        self::$demo_names = array(
          'skin_care'=>'Skin Care',
          'mobile_app'=>'Mobile App',
          'book'=>'Book'.$pro,
          'hair_treatment'=>'Hair Treatment'.$pro,
          'blog'=>'Blog'.$pro,
          'online_fitness'=>'Online Fitness'.$pro,
          'pet_care'=>'Pet Care'.$pro,
          'saas_click_through'=>'SAAS Click Through'.$pro,
          'saas_lead_generation'=>'SAAS Lead Generation'.$pro,
          'webinar'=>'Webinar'.$pro,
          'wedding_planner'=>'Wedding Planner'.$pro,
          'portfolio'=>'Portfolio'.$pro,
          'seo-agency'=>'Seo Agency'.$pro,
          'finance-advisor'=>'Finance Advisor'.$pro,
          'shop'=>'Shop'.$pro,
          'hosting'=>'Hosting'.$pro
                  );   
    }

    
    /**
     * [demo_installer description]
     *
     * @since 1.0
     *
     * @return [type] [description]
     */
    public function demo_installer() {
      
        ?>     

        <form id="tatsu_import_form" method="post">
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
            <div class="c-12">
            <select class="image-picker" name="be_demo_file" style="width: 100px;">
              <?php
              $dir = $this->demos_folder();
              
            //  foreach ($dir as $dirinfo) {
               
               // if($dirinfo->isDir() && !$dirinfo->isDot()) {
                //  $demo_val = $dirinfo->getFilename();
                foreach(self::$demo_names as $folder_name => $label ) {
                  $src = TATSU_STANDALONE_DEMOS_URL . '/inc/importer/demo-files/'.$folder_name.'/src.jpg';
                  
                  echo '<option data-img-label="'.esc_attr($label).'" data-img-src="'.$src.'"';
                  echo TatsuDemoImporter::check_settings($folder_name);
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
      $demos_main_fo = TATSU_STANDALONE_DEMOS_PATH . '/inc/importer/demo-files';

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
     * @since 1.0
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

    /**
     * Import Customizer Settings
    */

    public function _import_customizer($customizer_data = '') {
        if(empty($customizer_data)) {
          $customizer_data = $this->customizer_data;
        }
        
        if(!class_exists('WP_Customize_Manager')) {
          require_once( ABSPATH . 'wp-includes/class-wp-customize-manager.php' );
        }
        require_once( TATSU_STANDALONE_DEMOS_PATH . '/inc/importer/importer/class-be-customizer-import.php' );
        
        $wordpress_customize = new WP_Customize_Manager;
        $import_core = new BECustomizerImport;
        $import_core->init($wordpress_customize, $customizer_data);
    }


    /**
     * Import Tatsu Header
    */    

    public function import_tatsu_header() {
      $tatsu_header_data = file_exists( $this->tatsu_header_file ) ? file_get_contents( $this->tatsu_header_file ) : false;
      if( $tatsu_header_data ) {
          return update_option( 'tatsu_header_store' , $tatsu_header_data );
      } 
      return false;
    }

    /**
     * Import Tatsu Global Section settings
    */    

    public function import_tatsu_global_sections() {
      $tatsu_global_sections_data = file_exists( $this->tatsu_global_sections_file ) ? file_get_contents( $this->tatsu_global_sections_file ) : false;
      if( $tatsu_global_sections_data ) {
          return update_option( 'tatsu_global_section_data' , $tatsu_global_sections_data );
      } 
      return false;
    }


    /**
     * Import Demo Content from XML file
    */

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


    /**
     * Import Customizer Data, Colorhub Settings, Global Sections & Header Builder data
    */

    public function set_demo_theme_options( $file = '' ) {

      $this->_import_customizer();

      $colorhub_file = $this->colorhub_options_file;
      $colorhub_data = file_exists( $colorhub_file ) ? json_decode( file_get_contents( $colorhub_file ), true ) : false;

      if( function_exists( 'colorhub_import' ) && is_array( $colorhub_data ) ) {
        if( colorhub_import( $colorhub_data ) ) {
          echo 'Colorhub Options Imported Successfully';
        } else {
          echo 'Unable to Import Colorhub options';
        }
      }

      if( $this->import_tatsu_header ) {
        echo 'Tatsu Headers Imported Successfully';
      } else {
        echo 'Unable to import Tatsu Headers';
      }

      if( $this->import_tatsu_global_sections ) {
        echo 'Tatsu Global Sections Imported Successfully';
      } else {
        echo 'Unable to import Tatsu Global Sections';
      }

    }

    /**
     * Import TypeHub Settings
    */

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
     * @since 1.0
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
     * @since 1.0
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
     * @since 1.0
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