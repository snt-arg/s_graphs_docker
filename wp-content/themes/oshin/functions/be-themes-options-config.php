<?php

/**
  ReduxFramework Sample Config File
  For full documentation, please visit: https://docs.reduxframework.com
 * */

if (!class_exists('Redux_Framework_sample_config')) {

    class Redux_Framework_sample_config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if (  true == Redux_Helpers::isTheme(__FILE__) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

        }

        public function initSettings() {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            //add_action( 'redux/loaded', array( $this, 'remove_demo' ) );
            
            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 3);
            
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            
            // Dynamically add a section. Can be also used to modify sections/fields
            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**

          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field	set with compiler=>true is changed.

         * */
        function compiler_action($options, $css, $changed_values) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r($changed_values); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

            /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }

              if( $wp_filesystem ) {
                $wp_filesystem->put_contents(
                    $filename,
                    $css,
                    FS_CHMOD_FILE // predefined mode settings for WP files
                );
              }
             */
        }

        /**

          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.

          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons

         * */
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', 'oshin'),
                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'oshin'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        /**

          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

         * */
        function change_arguments($args) {
            $args['dev_mode'] = false;

            return $args;
        }

        /**

          Filter hook for filtering the default value of any given field. Very useful in development mode.

         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }

        public function setSections() {

            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
               
            $top_header_styles_path   = get_template_directory().'/img/headers/'; 
            $top_header_styles_url    = get_template_directory_uri().'/img/headers/';
           $top_header_styles = array(
                array(
                    'alt' => 'Style 1',
                    'img' => $top_header_styles_url.'style1.png',
                ),
                array(
                    'alt' => 'Style 2',
                    'img' => $top_header_styles_url.'style2.png',
                ),
                array(
                    'alt' => 'Style 3',
                    'img' => $top_header_styles_url.'style3.png',
                ),
                array(
                    'alt' => 'Style 4',
                    'img' => $top_header_styles_url.'style4.png',
                ),
                array(
                    'alt' => 'Style 5',
                    'img' => $top_header_styles_url.'style5.png',
                ), 
                array(
                    'alt' => 'Style 6',
                    'img' => $top_header_styles_url.'style6.png',
                ),
                array(
                    'alt' => 'Style 7',
                    'img' => $top_header_styles_url.'style7.png',
                ),
                array(
                    'alt' => 'Style 8',
                    'img' => $top_header_styles_url.'style8.png',
                ),
                array(
                    'alt' => 'Style 9',
                    'img' => $top_header_styles_url.'style9.png',
                ),
                array(
                    'alt' => 'Style 10',
                    'img' => $top_header_styles_url.'style10.png',
                ),
                array(
                    'alt' => 'Style 11',
                    'img' => $top_header_styles_url.'style11.png',
                ), 
                array(
                    'alt' => 'Style 12',
                    'img' => $top_header_styles_url.'style12.png',
                ),                                                                                
            ); 


            //Menu Styles
            $menu_styles_path    = get_template_directory().'/img/menu_styles/';
            $menu_styles_url     = get_template_directory_uri().'/img/menu_styles/';
            $menu_styles = array(
                array(
                    'alt' => 'Page Stack Top',
                    'img' => $menu_styles_url.'page-stack-top.jpg',
                ),
                array(
                    'alt' => 'Animated Falling Menu',
                    'img' => $menu_styles_url.'menu-animate-fall.jpg',
                ),
                array(
                    'alt' => 'Overlay Horizontal Menu',
                    'img' => $menu_styles_url.'overlay-horizontal-menu.jpg',
                ),
                array(
                    'alt' => 'Overlay Center Align Menu',
                    'img' => $menu_styles_url.'overlay-center-align-menu.jpg',
                ),
                array(
                    'alt' => 'Left Stacked Sliding Menu',
                    'img' => $menu_styles_url.'page-stack-left.jpg',
                ),
                array(
                    'alt' => 'Right Stacked Sliding Menu',
                    'img' => $menu_styles_url.'page-stack-right.jpg',
                ), 
                array(
                    'alt' => 'Left Sliding Menu',
                    'img' => $menu_styles_url.'special-left-menu.jpg',
                ),
                array(
                    'alt' => 'Right Sliding Menu',
                    'img' => $menu_styles_url.'special-right-menu.jpg',
                ),
                array(
                    'alt' => 'Right 3D Menu',
                    'img' => $menu_styles_url.'perspective-left.jpg',
                ),
                array(
                    'alt' => 'Left 3D Menu',
                    'img' => $menu_styles_url.'perspective-right.jpg',
                ),                                                                  
            );

            //Left Header images
            $left_header_styles_path    = get_template_directory().'/img/headers/left/';
            $left_header_styles_url     = get_template_directory_uri().'/img/headers/left/';
            $left_header_styles = array(
                array(
                    'alt' => 'Static',
                    'img' => $left_header_styles_url . 'left-static-menu.jpg', // Fix Loading Style
                ),
                array(
                    'alt' => 'Strip',
                    'img' => $left_header_styles_url.'left-strip-menu.jpg',
                ),
                array(
                    'alt' => 'Overlay Left Aligned Menu',
                    'img' => $left_header_styles_url.'overlay-left-align-menu.jpg',
                ),
                array(
                    'alt' => 'Overlay Center Align Menu',
                    'img' => $left_header_styles_url.'overlay-center-align-menu.jpg',
                ),
                array(
                    'alt' => '3D Menu',
                    'img' => $left_header_styles_url.'perspective-right.jpg',
                ),
                array(
                    'alt' => 'Overlay with widget area ( Old )',
                    'img' => $left_header_styles_url.'overlay.jpg',
                ), 
                array(
                    'alt' => 'Static with Widget Area (Old )',
                    'img' => $left_header_styles_url.'static.jpg',
                ),
                array(
                    'alt' => 'Strip with Widget Area ( Old )',
                    'img' => $left_header_styles_url.'strip.jpg',
                ),                                                                 
            );           

            //Hamburger menu styles
            $hamburger_styles_path    = get_template_directory().'/img/hamburger-styles/';
            $hamburger_styles_url     = get_template_directory_uri().'/img/hamburger-styles/';
           $hamburger_styles = array(
                array(
                    'alt' => 'Style 1',
                    'img' => $hamburger_styles_url.'style1.jpg',
                ),
                array(
                    'alt' => 'Style 2',
                    'img' => $hamburger_styles_url.'style2.jpg',
                ),
                array(
                    'alt' => 'Style 3',
                    'img' => $hamburger_styles_url.'style3.jpg',
                ),
                array(
                    'alt' => 'Style 4',
                    'img' => $hamburger_styles_url.'style4.jpg',
                ),
                array(
                    'alt' => 'Style 5',
                    'img' => $hamburger_styles_url.'style5.jpg',
                ), 
                array(
                    'alt' => 'Style 6',
                    'img' => $hamburger_styles_url.'style6.jpg',
                ),                                                                
            );            

            //Portfolio navigation grid styles
            $portfolio_grid_styles_path    = get_template_directory().'/img/portfolio-navigation-grid/';
            $portfolio_grid_styles_url     = get_template_directory_uri().'/img/portfolio-navigation-grid/';
           $portfolio_grid_styles = array(
                array(
                    'alt' => 'Four Dots Solid',
                    'img' => $portfolio_grid_styles_url.'four-filled.png',
                ),
                array(
                    'alt' => 'Four Dots Bordered',
                    'img' => $portfolio_grid_styles_url.'four-hollow.png',
                ),
                array(
                    'alt' => 'Six Dots Solid',
                    'img' => $portfolio_grid_styles_url.'six-filled.png',
                ),
                array(
                    'alt' => 'Six Dots Bordered',
                    'img' => $portfolio_grid_styles_url.'six-hollow.png',
                ),
                array(
                    'alt' => 'Nine Dots Solid',
                    'img' => $portfolio_grid_styles_url.'nine-filled.png',
                ), 
                array(
                    'alt' => 'Nine Dots Bordered',
                    'img' => $portfolio_grid_styles_url.'nine-hollow.png',
                ),                                                                
            );             

            ob_start();

            $ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'oshin'), $this->theme->display('Name'));
            
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview', 'oshin'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview','oshin'); ?>" />
                <?php endif; ?>

                <h4><?php echo $this->theme->display('Name'); ?></h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'oshin'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'oshin'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'oshin') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
            <?php
            if ($this->theme->parent()) {
                
                _e('<p class="howto">This <a href="http://codex.wordpress.org/Child_Themes">child theme</a> requires its parent theme</p>', 'oshin' );
            }
            ?>

                </div>
            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $sampleHTML = '';
            if (file_exists(dirname(__FILE__) . '/info-html.html')) {
                Redux_Functions::initWpFilesystem();
                
                global $wp_filesystem;

                $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
            }

            $title_font = "Lato";
            $body_font = "Open Sans:regular";

            $be_std_font_arr = array(               
                "Arial, Helvetica, sans-serif"                     => "Arial, Helvetica, sans-serif",
                "Arial Black, Gadget, sans-serif"                  => "Arial Black, Gadget, sans-serif",
                "Bookman Old Style, serif"                         => "Bookman Old Style, serif",
                "Comic Sans MS, cursive"                           => "Comic Sans MS, cursive",
                "Courier, monospace"                               => "Courier, monospace",
                "Garamond, serif"                                  => "Garamond, serif",
                "Georgia, serif"                                   => "Georgia, serif",
                "Impact, Charcoal, sans-serif"                     => "Impact, Charcoal, sans-serif",
                "Lucida Console, Monaco, monospace"                => "Lucida Console, Monaco, monospace",
                "Lucida Sans Unicode, Lucida Grande, sans-serif"   => "Lucida Sans Unicode, Lucida Grande, sans-serif",
                "MS Sans Serif, Geneva, sans-serif"                => "MS Sans Serif, Geneva, sans-serif",
                "MS Serif, New York, sans-serif"                   => "MS Serif, New York, sans-serif",
                "Palatino Linotype, Book Antiqua, Palatino, serif" => "Palatino Linotype, Book Antiqua, Palatino, serif",
                "Tahoma,Geneva, sans-serif"                        => "Tahoma, Geneva, sans-serif",
                "Times New Roman, Times,serif"                     => "Times New Roman, Times, serif",
                "Trebuchet MS, Helvetica, sans-serif"              => "Trebuchet MS, Helvetica, sans-serif",
                "Verdana, Geneva, sans-serif"                      => "Verdana, Geneva, sans-serif",
            );

            $parsed_to_typehub = get_option( 'oshine_redux_to_typehub' );
            $colorhub_data = get_option( 'colorhub_data' );

            $be_custom_font_arr = array(
                "Hans Kendrick Light"                                  => "Hans Kendrick Light",
                "Hans Kendrick Regular"                                => "Hans Kendrick Regular",
                "Hans Kendrick Medium"                                 => "Hans Kendrick Medium",
                "Hans Kendrick Heavy"                                  => "Hans Kendrick Heavy",
            );

            $be_fonts_arr = array_merge($be_std_font_arr, apply_filters('be_themes_custom_font_filter', $be_custom_font_arr) );

            // General Settings
            $this->sections[] = array(
                'title'     => __('General Settings', 'oshin'),
                'desc'      => sprintf( __('General Settings of the site including the favicon and google analytics. <a href="%s" target="_blank">General Settings Documentation</a>', 'oshin'), 'https://www.brandexponents.com/oshine-knowledgebase/knowledge-base/general-settings/'),
                'icon'      => 'el-icon-adjust-alt',
                'fields'    => array(

                    array (
                        'id' => 'site_status',
                        'type' => 'switch',
                        'title' => __('Cache Options Panel Settings ?', 'oshin'), 
                        //'subtitle' => __('Option\'s panel cache ', 'oshin'),
                        'desc' => __('Turn on Cache once you have completed setting up all the Options here. Turning on cache, will save the options panel settings and that will help us optimize performance of the website. However, any changes to the Options while cache is ON will NOT be saved. So make sure you turn OFF cache before making changes in the Options Panel', 'oshin'),
                        'default' => false
                    ),
                    // array (
                    //     'id' => 'enable_pb',
                    //     'type' => 'checkbox',
                    //     'title' => __('Enable Pagebuilder ?', 'oshin'),
                    //     'subtitle' => __('Check this box if you would like to use the page builder for constructing your pages and portfolio posts. You can still disable the page builder per page if you would like to use the default wordpress content editor', 'oshin'),
                        
                    //     'default' => 1,
                    // ),
                    // array (
                    //     'id' => 'favicon',
                    //     'type' => 'media',
                    //     'title' => __('Your Favicon', 'oshin'), 
                    //     
                    //     'desc' => __('Please upload a favicon here.', 'oshin')
                    // ),
                    array (
                        'id' => 'google_analytics_code',
                        'type' => 'text',
                        'title' => __('Google Analytics Code', 'oshin'), 
                        'desc' => __('Please enter your Google analytics tracking ID here.', 'oshin'),
                        'default' => ''
                    ),
                    array (
                        'id' => 'custom_css',
                        'type' => 'ace_editor',
                        'title' => __('Custom CSS', 'oshin'), 
                        'desc' => __('Please add your custom CSS here.', 'oshin'),
                        'validate' => 'html', 
                        'default' => ''
                    ),
                    array (
                        'id' => 'custom_js',
                        'type' => 'ace_editor',
                        'title' => __('Custom Javascript', 'oshin'), 
                        'desc' => __('Please add your custom js code here.', 'oshin'),
                        'validate' => 'html', 
                        'default' => ''
                    )
                    
                ),
            );
            //Logo
            $this->sections[] = array(
                'title' => __('Logo', 'oshin'),
                'desc' => sprintf( __('<a href="%s" target="_blank">Logo Documentation</a>', 'oshin'), 'https://www.brandexponents.com/oshine-knowledgebase/knowledge-base/logo/' ),
                
                'icon' => 'el-icon-star',
                'fields' => array ( 
                        array (
                            'id' => 'disable_logo',
                            'type' => 'checkbox',
                            'title' => __('Disable Logo', 'oshin'),
                            'subtitle' => __('Check this is you do not wish to have a logo in your site', 'oshin'),
                            
                            'default' => 0,
                        ),
                        array (
                            'id' => 'logo',
                            'type' => 'media',
                            'title' => __('Logo', 'oshin'), 
                            'subtitle' => __('Upload your logo here.', 'oshin'),
                            'required' => array('disable_logo','equals','0')
                        ),
                        array (
                            'id' => 'logo_sticky',
                            'type' => 'media',
                            'title' => __('Logo on Sticky Header', 'oshin'), 
                            'subtitle' => __('Upload the logo that needs to be displayed in sticky header', 'oshin'),
                            'required' => array('disable_logo','equals','0')
                        ),
                        array (
                            'id' => 'logo_transparent',
                            'type' => 'media',
                            'title' => __('Dark Logo', 'oshin'), 
                            'subtitle' => __('Upload the logo that needs to be displayed in transparent header sections.', 'oshin'),
                            'required' => array('disable_logo','equals','0')
                        ),
                        array (
                            'id' => 'logo_transparent_light',
                            'type' => 'media',
                            'title' => __('Light Logo', 'oshin'), 
                            'subtitle' => __('Upload the logo that needs to be displayed in transparent header sections with dark backgrounds.', 'oshin'),
                            'required' => array('disable_logo','equals','0')
                        ),
                        array (
                            'id' => 'logo_sidebar',
                            'type' => 'media',
                            'title' => __('Logo on Sidebar', 'oshin'), 
                            'subtitle' => __('Upload the logo that needs to be displayed in the slidebar', 'oshin'),
                            'required' => array('disable_logo','equals','0')
                        ),  
                        array(
                            'id' => 'left-strip-logo',
                            'type' => 'media',
                            'title' => __('Strip Logo', 'oshin'), 
                            'required'  => array('left-header-style','equals', array(
                                                get_template_directory_uri().'/img/headers/left/left-strip-menu.jpg',
                                                get_template_directory_uri().'/img/headers/left/strip.jpg',
                                                get_template_directory_uri().'/img/headers/left/overlay.jpg',
                                                get_template_directory_uri().'/img/headers/left/overlay-center-align-menu.jpg',
                                                get_template_directory_uri().'/img/headers/left/overlay-left-align-menu.jpg',
                                                get_template_directory_uri().'/img/headers/left/perspective-right.jpg',
                                                'overlay' ) ),
                            'subtitle' => __('Logo shown in Strip Left Header', 'oshin'),
                        ),
                        array(
                            'id'        => 'opt-logo-padding',
                            'type'      => 'text',
                            'title'     => __('Top Header Logo Padding', 'oshin'),
                            'subtitle'  => __('Enter only Numbers (in pixels)', 'oshin'),
                            'default' => '25',
                         ), 
                         array(
                            'id'        => 'opt-logo-max-width',
                            'type'      => 'text',
                            'title'     => __('Logo max width', 'oshin'),
                            'subtitle'  => __('Enter only Numbers (in pixels)', 'oshin'),
                            'default' => '',
                         ), 
                         array(
                            'id'        => 'opt-logo-max-width-mobile',
                            'type'      => 'text',
                            'title'     => __('Logo max width (Mobile)', 'oshin'),
                            'subtitle'  => __('Enter only Numbers (in pixels)', 'oshin'),
                            'default' => '',
                         ),  
                    )
                );
            //Background
            $this->sections[] = array(
                'title' => __('Background', 'oshin'),
                'desc' => sprintf( __('Background settings for all the individual elements of the site. <a href="%s" target="_blank">Background Documentation</a>', 'oshin'), 'https://www.brandexponents.com/oshine-knowledgebase/knowledge-base/background-settings/'),
                'icon' => 'el-icon-picture',
                'fields' => array (    

                    array(
                        'id'        => 'opt-header-color',
                        'type'      => 'background',
                        'title'     => __('Header', 'oshin'),
                        'default'   => array(
                            'background-color' => '#f2f3f8'
                            )
                    ),   
                    array (
                        'id' => 'header_title_module',
                        'type' => 'background',
                        'title' => __('Page Title Module', 'oshin'), 
                        
                        'default' => array(
                            'background-color' => '#f2f3f8',
                        )
                    ),             
                    array (
                        'id' => 'body',
                        'type' => 'background',
                        'title' => __('Body', 'oshin'), 
                        'default' => array(
                            'background-color' => '#FFFFFF',
                        )
                    ),
                    array (
                        'id' => 'content',
                        'type' => 'background',
                        'title' => __('Content Area', 'oshin'), 
                        
                        
                        'default' => array(
                            'background-color' => '#FFFFFF',
                        )
                    ),
                    array (
                        'id' => 'bottom_widgets',
                        'type' => 'background',
                        'title' => __('Footer Widget Area', 'oshin'), 
                        
                        
                        'default' => array(
                            'background-color' => '#f2f3f8',
                        )
                    ),  
                    array(
                        'id' => 'footer_background',
                        'type' => 'background',
                        'title' => __('Footer', 'oshin'), 
                        
                        
                        'default' => (
                            array ('background-color' => '#ffffff')
                            )
                    ),           
                )
            );
            // Typography
        if( empty( $parsed_to_typehub ) ) {
            $this->sections[] = array(
                'title' => __('Typography', 'oshin'),
                
                'icon' => 'el-icon-fontsize',
            );
            // Headings
            $this->sections[] = array(
                'title' => __('Headings', 'oshin'),
                
                'icon' => '',
                'subsection' => 'true',
                'fields' => array (
                    array (
                        'id' => 'h1',
                        'type' => 'typography',
                        'title' => __('H1', 'oshin'), 
                        'subtitle' => __('Heading Tag 1', 'oshin'),
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'text-transform' => true,
                        'letter-spacing' => true,
                        'default'   => array(
                            'color'         => '#222222',
                            'font-size'     => '55px',
                            'line-height'   => '70px',
                            'font-family'   => 'Montserrat',
                            'font-style'    => '',
                            'font-weight'   => '700',
                            'text-transform' => 'none',
                            'letter-spacing' => '0px'
                        ),
                    ),
                    array (
                        'id' => 'h2',
                        'type' => 'typography',
                        'title' => __('H2', 'oshin'), 
                        'subtitle' => __('Heading Tag 2', 'oshin'),
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'text-transform' => true,
                        'letter-spacing' => true,                        
                        'default'   => array(
                            'color'         => '#222222',
                            'font-size'     => '42px',
                            'line-height'   => '63px',
                            'font-family'   => 'Montserrat',
                            'font-style'    => '',
                            'font-weight'   => '700',
                            'text-transform' => 'none',
                            'letter-spacing' => '0px'
                        ),
                    ),
                    array (
                        'id' => 'h3',
                        'type' => 'typography',
                        'title' => __('H3', 'oshin'), 
                        'subtitle' => __('Heading Tag 3', 'oshin'),
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'text-transform' => true,
                        'letter-spacing' => true,                        
                        'default'   => array(
                            'color'         => '#222222',
                            'font-size'     => '35px',
                            'line-height'   => '52px',
                            'font-family'   => 'Montserrat',
                            'font-style'    => '',
                            'font-weight'   => '700',
                            'text-transform' => 'none',
                            'letter-spacing' => '1px'
                        ),
                    ),
                    array (
                        'id' => 'h4',
                        'type' => 'typography',
                        'title' => __('H4', 'oshin'), 
                        'subtitle' => __('Heading Tag 4', 'oshin'),
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'text-transform' => true,
                        'letter-spacing' => true,                        
                        'default'   => array(
                            'color'         => '#222222',
                            'font-size'     => '26px',
                            'line-height'   => '42px',
                            'font-family'   => 'Montserrat',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'none',
                            'letter-spacing' => '0px'
                        ),
                    ),
                    array (
                        'id' => 'h5',
                        'type' => 'typography',
                        'title' => __('H5', 'oshin'), 
                        'subtitle' => __('Heading Tag 5', 'oshin'),
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'text-transform' => true,
                        'letter-spacing' => true,                        
                        'default'   => array(
                            'color'         => '#222222',
                            'font-size'     => '20px',
                            'line-height'   => '36px',
                            'font-family'   => 'Montserrat',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'none',
                            'letter-spacing' => '0px'
                        ),
                    ),
                    array (
                        'id' => 'h6',
                        'type' => 'typography',
                        'title' => __('H6', 'oshin'), 
                        'subtitle' => __('Heading Tag 6', 'oshin'), 
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'text-transform' => true,
                        'letter-spacing' => true,                        
                        'default'   => array(
                            'color'         => '#222222',
                            'font-size'     => '15px',
                            'line-height'   => '32px',
                            'font-family'   => 'Montserrat',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'none',
                            'letter-spacing' => '0px'
                        ),
                    ),           
                )
            );
            // Content Area
            $this->sections[] = array(
                'title' => __('Content Area', 'oshin'),
                
                'icon' => '',
                'subsection' => 'true',
                'fields' => array (
                    array (
                        'id' => 'body_text',
                        'type' => 'typography',
                        'title' => __('Body Text', 'oshin'), 
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'text-transform' => true,
                        'letter-spacing' => true,
                        'default'   => array(
                            'color'         => '#5f6263',
                            'font-size'     => '13px',
                            'line-height'   => '26px',
                            'font-family'   => 'Raleway',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'none',
                            'letter-spacing' => '0px'
                        ),
                    ),                    
                    array (
                        'id' => 'page_title_module_typo',
                        'type' => 'typography',
                        'title' => __('Page Title Module', 'oshin'), 
                        
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'text-transform' => true,
                        'letter-spacing' => true,
                        'default'   => array(
                            'color'         => '#000000',
                            'font-size'     => '18px',
                            'line-height'   => '36px',
                            'font-family'   => 'Montserrat',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'uppercase',
                            'letter-spacing' => '3px'
                        ),
                    ),
                    array (
                        'id' => 'sub_title',
                        'type' => 'typography',
                        'title' => __('Sub Title', 'oshin'), 
                        'subtitle' => __('Font that will be used by the Sub Title Module in Page Builder', 'oshin'), 
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'text-transform' => true,
                        'letter-spacing' => true,
                        'default'   => array(
                            'font-family'   => 'Crimson Text',
                            'font-style'    => 'Italic',
                            'font-weight'   => '400',
                            'text-transform' => 'none',
                            'font-size' => '15px',
                            'letter-spacing' => '0px'
                        ),
                        'color' => false,
                        'line-height' => false,                        
                    ),
                    array (
                        'id' => 'sidebar_widget_title',
                        'type' => 'typography',
                        'title' => __('Sidebar Widget Title', 'oshin'), 
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'text-transform' => true,
                        'letter-spacing' => true,
                        'default'   => array(
                            'color'         => '#333333',
                            'font-size'     => '12px',
                            'line-height'   => '22px',
                            'font-family'   => 'Montserrat',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'uppercase',
                            'letter-spacing' => '1px'
                        ),
                    ),
                    array (
                        'id' => 'sidebar_widget_text',
                        'type' => 'typography',
                        'title' => __('Sidebar Widget Text', 'oshin'), 
                         
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'text-transform' => true,
                        'letter-spacing' => true,
                        'default'   => array(
                            'color'         => '#606060',
                            'font-size'     => '13px',
                            'line-height'   => '24px',
                            'font-family'   => 'Raleway',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'none',
                            'letter-spacing' => '0px'
                        ),
                    ),  
                )
            );
            // Main Navigation
            $this->sections[] = array(
                'title' => __('Main Navigation Menu', 'oshin'),
                
                'icon' => '',
                'subsection' => 'true',
                'fields' => array (                   
                    array (
                        'id' => 'navigation_text',
                        'type' => 'typography',
                        'title' => __('Navigation Menu', 'oshin'), 
                         
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'text-transform' => true,
                        'letter-spacing' => true,
                        'default'   => array(
                            'color'         => '#232323',
                            'font-size'     => '12px',
                            'line-height'   => '51px',
                            'font-family'   => 'Montserrat',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'uppercase',
                            'letter-spacing' => '1px'
                        ),
                    ),
                    array (
                        'id' => 'submenu_text',
                        'type' => 'typography',
                        'title' => __('Navigation Submenu', 'oshin'), 
                        
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'text-transform' => true,
                        'letter-spacing' => true,
                        'default'   => array(
                            'color'         => '#bbbbbb',
                            'font-size'     => '13px',
                            'line-height'   => '28px',
                            'font-family'   => 'Raleway',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'none',
                            'letter-spacing' => '0px'
                        ),
                    ),
                )
            );
            // Mobile Menu
            $this->sections[] = array(
                'title' => __('Mobile Menu', 'oshin'),
                
                'icon' => '',
                'subsection' => 'true',
                'fields' => array (  
                    array (
                        'id' => 'mobile_menu_text',
                        'type' => 'typography',
                        'title' => __('Mobile Menu', 'oshin'), 
                         
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'text-transform' => true,
                        'letter-spacing' => true,
                        'default'   => array(
                            'color'         => '#232323',
                            'font-size'     => '12px',
                            'line-height'   => '40px',
                            'font-family'   => 'Montserrat',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'uppercase',
                            'letter-spacing' => '1px'
                        ),
                    ),
                    array (
                        'id' => 'mobile_submenu_text',
                        'type' => 'typography',
                        'title' => __('Mobile Submenu', 'oshin'), 
                        
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'text-transform' => true,
                        'letter-spacing' => true,
                        'default'   => array(
                            'color'         => '#bbbbbb',
                            'font-size'     => '13px',
                            'line-height'   => '27px',
                            'font-family'   => 'Raleway',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'none',
                            'letter-spacing' => '0px'
                        ),
                    ),
                )
            );
            //Slidebar
            $this->sections[] = array(
                'title' => __('Slidebar', 'oshin'),
                'desc' => __('Typography Options for Elements in the Slidebar', 'oshin'),
                'icon' => '',
                'subsection' => 'true',
                'fields' => array (
                    array (
                        'id' => 'sidebar_menu_text',
                        'type' => 'typography',
                        'title' => __('Sidebar Menu Text', 'oshin'), 
                        'subtitle' => __('This typography setting will apply on the Optional Right Sidebar Menu', 'oshin'),
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'text-transform' => true,
                        'letter-spacing' => true,
                        'default'   => array(
                            'color'         => '#ffffff',
                            'font-size'     => '12px',
                            'line-height'   => '50px',
                            'font-family'   => 'Raleway',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'uppercase',
                            'letter-spacing' => '1px'
                        ),
                    ),
                    array (
                        'id' => 'sidebar_submenu_text',
                        'type' => 'typography',
                        'title' => __('Sidebar Sub Menu Text', 'oshin'), 
                        'subtitle' => __('This typography setting will apply on the Optional Right Sidebar Sub-Menu', 'oshin'),
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'text-transform' => true,
                        'letter-spacing' => true,
                        'default'   => array(
                            'color'         => '#ffffff',
                            'font-size'     => '13px',
                            'line-height'   => '25px',
                            'font-family'   => 'Raleway',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'none',
                            'letter-spacing' => ''
                        ),
                    ),
                    array (
                        'id' => 'slidebar_widget_title',
                        'type' => 'typography',
                        'title' => __('Slidebar Widget Title', 'oshin'), 
                         
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'text-transform' => true,
                        'letter-spacing' => true,
                        'default'   => array(
                            'color'         => '#ffffff',
                            'font-size'     => '12px',
                            'line-height'   => '22px',
                            'font-family'   => 'Montserrat',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'none',
                            'letter-spacing' => '1px'
                        ),
                    ),
                    array (
                        'id' => 'slidebar_widget_text',
                        'type' => 'typography',
                        'title' => __('Slidebar Widget Text', 'oshin'), 
                         
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'text-transform' => true,
                        'letter-spacing' => true,
                        'default'   => array(
                            'color'         => '#a2a2a2',
                            'font-size'     => '13px',
                            'line-height'   => '25px',
                            'font-family'   => 'Raleway',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'none',
                            'letter-spacing' => '0px'
                        ),
                    ),

                )
            );  
            // Blog 
            $this->sections[] = array(
                'title' => __('Blog Posts', 'oshin'),
                
                'icon' => '',
                'subsection' => 'true',
                'fields' => array (  
                    array (
                        'id' => 'post_title',
                        'type' => 'typography',
                        'title' => __('Blog Post Title', 'oshin'), 
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'text-transform' => true,
                        'letter-spacing' => true,
                        'default'   => array(
                            'color'         => '#000000',
                            'font-size'     => '20px',
                            'line-height'   => '40px',
                            'font-family'   => 'Montserrat',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'none',
                            'letter-spacing' => '0px'
                        ),
                    ),
                    array (
                        'id' => 'masonry_post_title',
                        'type' => 'typography',
                        'title' => __('Masonry Style Blog Post Title', 'oshin'), 
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'text-transform' => true,
                        'letter-spacing' => true,
                        'default'   => array(
                            'color'         => '#363c3b',
                            'font-size'     => '16px',
                            'line-height'   => '28px',
                            'font-family'   => 'Source Sans Pro',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'none',
                            'letter-spacing' => '0px'
                        ),
                    ),
                    array (
                        'id' => 'post_top_meta_options',
                        'type' => 'typography',
                        'title' => __('Blog Post Top Meta Options', 'oshin'), 
                        'subtitle' => __('This typography is used for Meta (Category) in Blog Style with Meta on Top', 'oshin'),
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'text-transform' => true,
                        'letter-spacing' => true,
                        'default'   => array(
                            'color'         => '#757575',
                            'font-size'     => '12px',
                            'line-height'   => '24px',
                            'font-family'   => 'Raleway',
                            'font-style'    =>  '',
                            'font-weight'   => '',
                            'text-transform' => 'uppercase',
                            'letter-spacing' => '0px'
                        ),
                    ),                    
                    array (
                        'id' => 'post_meta_options',
                        'type' => 'typography',
                        'title' => __('Blog Post Bottom Meta Options', 'oshin'), 
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'text-transform' => true,
                        'letter-spacing' => true,
                        'default'   => array(
                            'color'         => '#757575',
                            'font-size'     => '12px',
                            'line-height'   => '24px',
                            'font-family'   => 'Raleway',
                            'font-style'    =>  '',
                            'font-weight'   => '',
                            'text-transform' => 'uppercase',
                            'letter-spacing' => '0px'
                        ),
                    ),
                    array (
                        'id'           => 'single_post_typo',
                        'type'         => 'switch',
                        'title'        => __( 'Custom Typography for Individual Post ?', 'oshin' ),
                        'default'      => false
                    ),
                    array (
                        'id'           => 'single_post_title',
                        'type'         => 'typography',
                        'title'        => __( 'Individual Blog Post Title', 'oshin' ),
                        'subtitle'     => '',
                        'fonts'        => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'text-transform' => true,
                        'letter-spacing' => true,
                        'default'      => array (
                            'color'         => '#ffffff',
                            'font-size'     => '25px',
                            'line-height'   => '45px',
                            'font-family'   => 'Montserrat',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'none',
                            'letter-spacing' => '0px'
                        ),
                        'required' => array('single_post_typo','equals','1'),
                    )                    
                )
            );

            //Portfolio

            $this->sections[] = array (
                'icon' => '',
                'subsection' => 'true',
                'title' => __('Portfolio', 'oshin'),
                
                'fields' => array (
                        array (
                            'id' => 'portfolio_title',
                            'type' => 'typography',
                            'title' => __('Title on Portfolio Grid', 'oshin'), 
                                
                            'fonts' => $be_fonts_arr,
                            'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                            
                            'default'   => array(
                                'font-size'     => '14px',
                                'line-height'   => '30px',
                                'font-family'   => 'Montserrat',
                                'font-style'    => '',
                                'font-weight'   => '400',
                                'text-transform' => 'uppercase',
                                'letter-spacing' => '0px'
                            ),
                            'color'         => false,
                        ),
                        array (
                            'id' => 'portfolio_meta_typo',
                            'type' => 'typography',
                            'title' => __('Meta on Portfolio Grid', 'oshin'), 
                            'subtitle' => __('Body font will be used for this.', 'oshin'), 
                            'fonts' => $be_fonts_arr,
                            'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                            
                            'default'   => array(
                                'font-size'     => '12px',
                                'line-height'   => '17px',
                                'text-transform' => 'none',
                                'letter-spacing'   => 0,
                            ),
                            'color'         => false,
                            'font-family'   => false,
                            'font-weight'   => false,
                            'font-style'    => false,
                            'text-align'    => false,
                        ),
                        array(
                            'id' => 'enable_portfolio_details_typo',
                            'type' => 'switch',
                            'title'     => __('Enable Portfolio Details Typography', 'oshin'),
                            'subtitle'  => __('', 'oshin'),
                            'default'   => false,
                        ),
                        array (
                            'id' => 'portfolio_details_title',
                            'type' => 'typography',
                            'title' => __('Title', 'oshin'), 
                            'subtitle'  => __('','oshin'),
                            'fonts' => $be_fonts_arr,
                            'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                            'default'   => array(
                                'color'         => '#222222',
                                'font-size'     => '15px',
                                'line-height'   => '32px',
                                'font-family'   => 'Montserrat',
                                'font-style'    => '',
                                'font-weight'   => '400',
                                'text-transform' => 'none',
                                'letter-spacing' => '0px'
                            ),
                            'color'         => false,
                            'required' => array('enable_portfolio_details_typo','equals',true)
                        ),
                        array (
                            'id' => 'portfolio_details_content',
                            'type' => 'typography',
                            'title' => __('Content', 'oshin'), 
                            'subtitle'  => __('','oshin'),
                            'fonts' => $be_fonts_arr,
                            'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                            'default'   => array(
                                'color'         => '#5f6263',
                                'font-size'     => '13px',
                                'line-height'   => '26px',
                                'font-family'   => 'Raleway',
                                'font-style'    => '',
                                'font-weight'   => '400',
                                'text-transform' => 'none',
                                'letter-spacing' => '0px'
                            ),
                            'color'         => false,
                            'required' => array('enable_portfolio_details_typo','equals',true)
                        ),

                        array (
                            'id' => 'portfolio_nav_bottom_typography',
                            'type' => 'typography',
                            'title' => __('Global Portfolio Navigation', 'oshin'), 
                            'fonts' => $be_fonts_arr,
                            'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                            
                            'default'   => array(
                                'color'         => '#222222',
                                'font-size'     => '13px',
                                'line-height'   => '20px',
                                'font-family'   => 'Montserrat',
                                'font-style'    => '',
                                'font-weight'   => '700',
                                'text-transform' => 'none',
                                'letter-spacing' => '0px'
                            ),
                            'color' => false,
                            //'required' => array('portfolio_nav_bottom','equals',true)
                        ),
                        array (
                            'id' => 'portfolio_title_count_typo',
                            'type' => 'typography',
                            'title' => __('Title in Portfolio Navigation Module', 'oshin'), 
                            'subtitle' => __('Applied on Slider Type Portfolios', 'oshin'), 
                            'fonts' => $be_fonts_arr,
                            'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                            
                            'text-align'    => false,
                            'color' => false,
                            'line-height' => false,
                            'default'   => array(
                                'font-size'     => '15px',
                                'font-family'   => 'Montserrat',
                                'font-style'    => '',
                                'font-weight'   => '400',
                                'text-transform' => 'none',
                                'letter-spacing' => '0px',
                                'line-height' => '40px'
                            )
                        ),
                        array (
                            'id' => 'portfolio_caption_typo',
                            'type' => 'typography',
                            'title' => __('Caption in Sliders', 'oshin'), 
                            'subtitle' => __('Applied on Slider Type Portfolios', 'oshin'), 
                            'fonts' => $be_fonts_arr,
                            'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                            
                            'default'   => array(
                                'font-family'   => 'Crimson Text',
                                'font-style'    => 'Italic',
                                'font-weight'   => '400',
                                'text-transform' => 'none',
                                'font-size' => '15px',
                                'letter-spacing' => '0px'
                            ),
                            'text-align'    => false,
                        ),
                        array (
                            'id' => 'portfolio_filter_typo',
                            'type' => 'typography',
                            'title' => __('Portfolio Filters', 'oshin'), 
                                
                            'fonts' => $be_fonts_arr,
                            'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                            
                            'default'   => array(
                                'color'         => '#222222',
                                'font-size'     => '12px',
                                'line-height'   => '32px',
                                'font-family'   => 'Montserrat',
                                'font-style'    => '',
                                'font-weight'   => '400',
                                'text-transform' => 'uppercase',
                                'letter-spacing' => '1px'
                            ),
                        ),
                    )
                );

            // Shop 
            $this->sections[] = array (
                'icon' => '',
                'subsection' => 'true',
                'title' => __('Shop', 'oshin'),
                
                'fields' => array (
                        array (
                            'id' => 'shop_page_title',
                            'type' => 'typography',
                            'title' => __('Product Thumbnail Title', 'oshin'), 
                             
                            'fonts' => $be_fonts_arr,
                            'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                            'text-transform' => true,
                            'letter-spacing' => true,
                            'default'   => array(
                                'color'         => '#222222',
                                'font-size'     => '13px',
                                'line-height'   => '27px',
                                'font-family'   => 'Montserrat',
                                'font-style'    => '',
                                'font-weight'   => '400',
                                'text-transform' => 'uppercase',
                                'letter-spacing' => '1px'
                            ),
                        ),
                        array (
                            'id' => 'shop_single_page_title',
                            'type' => 'typography',
                            'title' => __('Individual Product Page Title', 'oshin'), 
                             
                            'fonts' => $be_fonts_arr,
                            'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                            'text-transform' => true,
                            'letter-spacing' => true,
                            'default'   => array(
                                'color'         => '#222222',
                                'font-size'     => '25px',
                                'line-height'   => '27px',
                                'font-family'   => 'Montserrat',
                                'font-style'    => '',
                                'font-weight'   => '400',
                                'text-transform' => 'none',
                                'letter-spacing' => '0px'
                            ),
                        ),
                    )
                );
            // Contact Form
            $this->sections[] = array (
                'icon' => '',
                'subsection' => 'true',
                'title' => __('Contact Form', 'oshin'),
                
                'fields' => array (
                        array (
                            'id' => 'contact_form_typo',
                            'type' => 'typography',
                            'title' => __('Contact Form Typography', 'oshin'), 
                            
                            'fonts' => $be_fonts_arr,
                            'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                            'text-transform' => true,
                            'letter-spacing' => true, 
                            'default'   => array (
                                'color'         => '#222222',
                                'font-size'     => '13px',
                                'line-height'   => '26px',
                                'font-family'   => 'Montserrat',
                                'font-style'    => '',
                                'font-weight'   => '400',
                                'text-transform' => 'none',
                                'letter-spacing' => '0px'
                            ),
                        ),
                    )
                );
            // Footer
            $this->sections[] = array(
                'title' => __('Footer and Footer Widgets', 'oshin'),
                'icon' => '',
                'subsection' => 'true',
                'fields' => array (
                    array (
                        'id' => 'bottom_widget_title',
                        'type' => 'typography',
                        'title' => __('Footer Widget Title', 'oshin'), 
                         
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'text-transform' => true,
                        'letter-spacing' => true,
                        'default'   => array(
                            'color'         => '#474747',
                            'font-size'     => '12px',
                            'line-height'   => '22px',
                            'font-family'   => 'Montserrat',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'uppercase',
                            'letter-spacing' => '1px'
                        ),
                    ),
                    array (
                        'id' => 'bottom_widget_text',
                        'type' => 'typography',
                        'title' => __('Footer Widget Text', 'oshin'), 
                         
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'text-transform' => true,
                        'letter-spacing' => true,
                        'default'   => array(
                            'color'         => '#757575',
                            'font-size'     => '13px',
                            'line-height'   => '24px',
                            'font-family'   => 'Raleway',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'none',
                            'letter-spacing' => '0px'
                        ),
                    ),
                    array (
                        'id' => 'footer_text', 
                        'type' => 'typography',
                        'title' => __('Footer Text', 'oshin'), 
                        
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'text-transform' => true,
                        'letter-spacing' => true, 
                        'default'   => array(
                            'color'         => '#888888',
                            'font-size'     => '13px',
                            'line-height'   => '14px',
                            'font-family'   => 'Raleway',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'none',
                            'letter-spacing' => '0px'
                        ),
                    ),                    
                )
            );
            // Page Builder Typography Settings
            $this->sections[] = array (
                'icon' => '',
                'subsection' => 'true',
                'title' => __('Page Builder Modules', 'oshin'),
                'desc' => __('Typography settings for specific modules in BE Page Builder', 'oshin'),
                'fields' => array (
                    array (
                        'id' => 'pb_module_title',
                        'type' => 'typography',
                        'title' => __('Title Font Family', 'oshin'), 
                        'subtitle' => __('The title font will be applied to the Title section of selected modules that includes - Tabs, Accordion, Animated Charts and Skills', 'oshin'), 
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'letter-spacing' => true,
                        'default'   => array(
                            'font-family'   => 'Raleway',
                            'letter-spacing' => '0px',
                            'font-weight'   => '600',
                            'font-style'    => '',
                        ),
                        'color'         => false,
                        'font-size'     => false,
                        'line-height'   => false,
                        'text-align'    => false,
                        'text-transform' => false,
                    ),
                    array (
                        'id' => 'pb_tab_font_size',
                        'type' => 'typography',
                        'title' => __('Tab Module Title Size', 'oshin'), 
                        'subtitle' => __('The font size for Tab module title', 'oshin'), 
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'text-transform' => true,
                        'default'   => array(
                            'font-size'     => '13px',
                            'line-height'   => '17px',
                            'text-transform' => 'uppercase',
                        ),
                        'color'         => false,
                        'font-family'   => false,
                        'font-weight'   => false,
                        'font-style'    => false,
                        'letter-spacing'   => false,
                        'text-align'    => false,
                    ),
                    array (
                        'id' => 'pb_acc_font_size',
                        'type' => 'typography',
                        'title' => __('Accordion Module Title Size', 'oshin'), 
                        'subtitle' => __('The font size for Accordion module title', 'oshin'), 
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'text-transform' => true,
                        'default'   => array(
                            'font-size'     => '13px',
                            'line-height'   => '17px',
                            'text-transform' => 'uppercase',
                        ),
                        'color'         => false,
                        'font-family'   => false,
                        'font-weight'   => false,
                        'font-style'    => false,
                        'letter-spacing'   => false,
                        'text-align'    => false,
                    ),
                    array (
                        'id' => 'pb_skill_font_size',
                        'type' => 'typography',
                        'title' => __('Skills Module Title Size', 'oshin'), 
                        'subtitle' => __('The font size for Skills module title', 'oshin'), 
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'text-transform' => true,
                        'default'   => array(
                            'font-size'     => '12px',
                            'line-height'   => '17px',
                            'text-transform' => 'uppercase',
                        ),
                        'color'         => false,
                        'font-family'   => false,
                        'font-weight'   => false,
                        'font-style'    => false,
                        'letter-spacing'   => false,
                        'text-align'    => false,
                    ),
                    array (
                        'id' => 'pb_countdown_number_font_size',
                        'type' => 'typography',
                        'title' => __('Countdown Number Font Size', 'oshin'), 
                        'subtitle' => __('The font size for Countdown module number', 'oshin'), 
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'text-transform' => true,
                        'default'   => array(
                            'font-size'     => '55px',
                            'line-height'   => '95px',
                            'text-transform' => 'uppercase',
                        ),
                        'color'         => false,
                        'font-family'   => false,
                        'font-weight'   => false,
                        'font-style'    => false,
                        'letter-spacing'   => false,
                        'text-align'    => false,
                    ),  
                    array (
                        'id' => 'pb_countdown_caption_font_size',
                        'type' => 'typography',
                        'title' => __('Countdown Caption Font Size', 'oshin'), 
                        'subtitle' => __('The font size for Countdown module caption', 'oshin'), 
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'text-transform' => true,
                        'default'   => array(
                            'font-size'     => '15px',
                            'line-height'   => '30px',
                            'text-transform' => 'uppercase',
                        ),
                        'color'         => false,
                        'font-family'   => false,
                        'font-weight'   => false,
                        'font-style'    => false,
                        'letter-spacing'   => false,
                        'text-align'    => false,
                    ),                                        
                    array (
                        'id' => 'pb_module_spl_body',
                        'type' => 'typography',
                        'title' => __('Content Font Family', 'oshin'), 
                        'subtitle' => __('This font will be applied to the Content section of selected modules that includes - Blockquote, Testimonials etc', 'oshin'), 
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'text-transform' => true,
                        'letter-spacing' => true,
                        'default'   => array(
                            'font-family'   => 'Crimson Text',
                            'letter-spacing' => '0px',
                            'font-weight'   => '400',
                            'font-style'    => 'Italic',
                            'text-transform' => 'none',
                        ),
                        'color'         => false,
                        'font-size'     => false,
                        'line-height'   => false,
                        'text-align'    => false,
                    ),
                    array (
                        'id' => 'pb_blockquote_font_size',
                        'type' => 'typography',
                        'title' => __('Blockquote Font Size', 'oshin'), 
                        'subtitle' => __('The font size for Blockquote module', 'oshin'), 
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'default'   => array(
                            'font-size'     => '26px',                      
                            ),
                        'color'         => false,
                        'font-family'   => false,
                        'font-weight'   => false,
                        'font-style'    => false,
                        'letter-spacing'    => false,
                        'line-height'       => false,
                        'text-transform'    => false,
                        'text-align'        => false,
                    ),
                    array (
                        'id' => 'pb_module_tweet',
                        'type' => 'typography',
                        'title' => __('Tweet Module Font Family', 'oshin'), 
                        'subtitle' => __('This font will be applied to the Content section of the Tweet Module', 'oshin'), 
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'text-transform' => true,
                        'letter-spacing' => true,
                        'default'   => array(
                            'font-family'   => 'Raleway',
                            'letter-spacing' => '0px',
                            'font-weight'   => '',
                            'font-style'    => '',
                            'text-transform' => 'none',
                        ),
                        'color'         => false,
                        'font-size'     => false,
                        'line-height'   => false,
                        'text-align'    => false,
                    ),
                    array (
                        'id' => 'button_font',
                        'type' => 'typography',
                        'title' => __('Buttons Font Family', 'oshin'), 
                        
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'desc' => __('' , 'oshin'),
                        'default'   => array(
                            'font-family'   => 'Montserrat',
                            'font-style'    => '',
                            'font-weight'   => '',
                        ),
                        'font-size'     => false,
                        'line-height'   => false,
                        'text-transform' => false,
                        'letter-spacing' => false,
                        'color' => false,
                        'text-align'   => false,
                    ),
                    array (
                        'id' => 'animated_link_font',
                        'type' => 'typography',
                        'title' => __('Animated Link Font Family', 'oshin'), 
                        
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'desc' => __('' , 'oshin'),
                        'text-transform' => true,
                        'letter-spacing' => true,                        
                        'default'   => array(
                            'font-family'   => 'Montserrat',
                            'font-style'    => '',
                            'font-weight'   => '',
                            'letter-spacing' => '',
                            'text-transform' => 'none',
                        ),
                        'font-size'     => false,
                        'line-height'   => false,
                        'color' => false,
                        'text-align'   => false,
                    ),
                )
            );

            // Responsive Settings
            $this->sections[] = array(
                'title' => __('Responsive Typography', 'oshin'),
                
                'icon' => 'el-var-phone',
            ); 

            // Mobile Device Typography
            $this->sections[] = array(
                'title' => __('Heading Tags on Mobile', 'oshin'),
                
                'icon' => '',
                'subsection' => 'true',
                'fields' => array (
                    array (
                        'id'        => 'mobile_typo_controller',
                        'type'      => 'checkbox',
                        'title'     => __('Set Font Sizes for Mobile Devices', 'oshin'), 
                        'subtitle'  => __('', 'oshin'),
                        'desc'      => __('By default the Sizes set under OSHINE OPTIONS > TYPOGRAPHY will be applied in all devices', 'oshin'),
                        'default'   => 0,
                    ),        
                    array (
                        'id' => 'h1_mobile',
                        'type' => 'typography',
                        'title' => __('H1', 'oshin'), 
                        'subtitle' => __('Heading Tag 1', 'oshin'),
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'font-size'     => '30px',
                            'line-height'   => '40px',
                        ),
                        'required' => array('mobile_typo_controller','equals','1'),
                        'color' => false,
                        'font-family'   => false,
                        'font-style'    => false,
                        'font-weight'   => false,
                        'text-transform' => false,
                        'letter-spacing' => false,
                        'text-align' => false,
                    ),
                    array (
                        'id' => 'h2_mobile',
                        'type' => 'typography',
                        'title' => __('H2', 'oshin'), 
                        'subtitle' => __('Heading Tag 2', 'oshin'),
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'font-size'     => '25px',
                            'line-height'   => '35px',
                        ),
                        'required' => array('mobile_typo_controller','equals','1'),
                        'color' => false,
                        'font-family'   => false,
                        'font-style'    => false,
                        'font-weight'   => false,
                        'text-transform' => false,
                        'letter-spacing' => false,
                        'text-align' => false,
                    ),
                    array (
                        'id' => 'h3_mobile',
                        'type' => 'typography',
                        'title' => __('H3', 'oshin'), 
                        'subtitle' => __('Heading Tag 3', 'oshin'),
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'font-size'     => '20px',
                            'line-height'   => '30px',
                        ),
                        'required' => array('mobile_typo_controller','equals','1'),
                        'color' => false,
                        'font-family'   => false,
                        'font-style'    => false,
                        'font-weight'   => false,
                        'text-transform' => false,
                        'letter-spacing' => false,
                        'text-align' => false,
                    ),
                    array (
                        'id' => 'h4_mobile',
                        'type' => 'typography',
                        'title' => __('H4', 'oshin'), 
                        'subtitle' => __('Heading Tag 4', 'oshin'),
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'font-size'     => '16px',
                            'line-height'   => '30px',
                        ),
                        'required' => array('mobile_typo_controller','equals','1'),
                        'color' => false,
                        'font-family'   => false,
                        'font-style'    => false,
                        'font-weight'   => false,
                        'text-transform' => false,
                        'letter-spacing' => false,
                        'text-align' => false,
                    ),
                    array (
                        'id' => 'h5_mobile',
                        'type' => 'typography',
                        'title' => __('H5', 'oshin'), 
                        'subtitle' => __('Heading Tag 5', 'oshin'),
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'font-size'     => '16px',
                            'line-height'   => '30px',
                        ),
                        'required' => array('mobile_typo_controller','equals','1'),
                        'color' => false,
                        'font-family'   => false,
                        'font-style'    => false,
                        'font-weight'   => false,
                        'text-transform' => false,
                        'letter-spacing' => false,
                        'text-align' => false,
                    ),
                    array (
                        'id' => 'h6_mobile',
                        'type' => 'typography',
                        'title' => __('H6', 'oshin'), 
                        'subtitle' => __('Heading Tag 6', 'oshin'), 
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'font-size'     => '15px',
                            'line-height'   => '32px',
                        ),
                        'required' => array('mobile_typo_controller','equals','1'),
                        'color' => false,
                        'font-family'   => false,
                        'font-style'    => false,
                        'font-weight'   => false,
                        'text-transform' => false,
                        'letter-spacing' => false,
                        'text-align' => false,
                    ),           
                )
            );
        }

            //Site Layout
            $this->sections[] = array(
                'icon' => 'el-icon-website',
                'title' => __('Global Site Layout and Settings', 'oshin'),
                'desc'      => sprintf( __('This Panel has all the settings related to the Global Settings and Layout of your Website <a href="%s" target="_blank">Global Site Layout and Settings Documentation</a>', 'oshin'), 'https://www.brandexponents.com/oshine-knowledgebase/knowledge-base/site-layout-settings/'),
                'fields' => array (
                    array(
                        'id'        => 'opt-header-type',
                        'type'      => 'select',
                        'title'     => __('Header Layout', 'oshin'),
                        'options'   => array('top' => 'Top Header' , 'left' => 'Left Header', 'builder' => 'Tatsu Header Builder'), 
                        'default'   => 'top',
                    ),
                    array (
                        'id' => 'layout',
                        'type'  => 'select',
                        'title' => __('Site Layout', 'oshin'), 
                        
                        
                        'options'=> array (
                            'layout-box'=>'Boxed Layout', 
                            'layout-wide'=>'Wide Layout',
                            'layout-border'=>'Border Layout',
                            'layout-border-header-top'=>'Header Top Border Layout',
                        ),
                        'default' => 'layout-wide'
                    ), 
                    array (
                        'id' => 'enable_footer_builder',
                        'type' => 'checkbox',
                        'title' => __('Enable Footer Builder', 'oshin'),
                        'default' => 0,
                    ),  
                    array(
                        'id'        => 'border-settings-start',
                        'type'      => 'section',
                        'title'     => 'Border Layout Settings',
                        'subtitle'  => __('These settings will be applicable if you choose Border Layout in the above option. This is not required for other layouts','oshin'),
                        'indent'    => true, // Indent all options below until the next 'section' option is set.
                    ),                    
                    array(
                        'id'        => 'border-bg-setting',
                        'type'      => 'background',
                        'title'     => __('Border BG', 'oshin'), 
                        'subtitle'  => __('', 'oshin'),
                        'desc'      => __('', 'oshin'),
                        'default'   => array(
                            'background-color' => '#d3d3d3',
                        )
                    ),                     
                    array(
                        'id'        => 'border-width',
                        'type'      => 'text',
                        'title'     => __('Border Width(in px)', 'oshin'), 
                        'subtitle'  => __('Enter Value Only', 'oshin'),
                        'desc'      => __('', 'oshin'),
                        'default'   => '30'
                    ),  
                    array(
                        'id'        => 'border-settings-end',
                        'type'      => 'section',
                        'indent'    => false, // End of Indentation.
                    ),
                    
                    // array (
                    //     'id' => 'all_ajax',
                    //     'type' => 'checkbox',
                    //     'title' => __('Enable Ajax Transitions', 'oshin'),
                        
                    //     'desc' => __('NOTE - Ajax Transitions is not compatible with Slider Revolution and Masterslider plugin currently. Hence, Ajax loading will be Hard-Disabled if any of these Plugins are activated. This option will not take effect for now and will be added once the plugin authors provide compatibility.', 'oshin'),
                    //     'default' => 0
                    // ),
                    // array (
                    //     'id' => 'all_ajax_exclude_links',
                    //     'type' => 'textarea',
                    //     'title' => __('Exclude Ajax Loading on pages', 'oshin'),
                    //     'subtitle' => __('Seperate by ,', 'oshin'),
                    //     'desc' => __('', 'oshin')
                    // ),  
                    // array (
                    //     'id' => 'page_loader_style',
                    //     'type' => 'select',
                    //     'title' => __('Loader Style', 'oshin'),
                        
                        
                    //     'options'=> array (
                    //         'style1-loader'=>'Style1 Loader', 
                    //         'style2-loader'=>'Style2 Loader',
                    //         'style3-loader'=>'Style3 Loader',
                    //         'style4-loader'=>'Style4 Loader',
                    //         'style5-loader'=>'Style5 Loader',
                    //         'style6-loader'=>'Style6 Loader',
                    //     ),
                    //     'default' => 'style1-loader'
                    // ), 
                    array (
                        'id' => 'comments_on_page',
                        'type' => 'checkbox',
                        'title' => __('Display Comments on Pages', 'oshin'),
                        'default' => 1,
                    ), 
                    array (
                        'id' => 'rev_slider_bg_check',
                        'type' => 'checkbox',
                        'title' => __('Disable Dynamic Menu Color Change on Slider Revolution', 'oshin'),
                        
                        
                        'default' => 0
                    ),
                    array (
                        'id' => 'disable_css_animation_mobile',
                        'type' => 'checkbox',
                        'title' => __('Disable CSS Animtion in mobile devices', 'oshin'),
                        
                        
                        'default' => 0
                    ),
                    array (
                        'id' => 'disable_back_top_btn',
                        'type' => 'checkbox',
                        'title' => __('Disable Back to top Button', 'oshin'),
                        
                        
                        'default' => 0
                    ), 
                    array (
                        'id' => 'textbox_style',
                        'type' => 'select',
                        'title' => __('Form Field Style', 'oshin'),  
                        'options'=> array (
                            'style1'=>'Transparent', 
                            'style2'=>'With Background',
                        ),
                        'default' => 'style1'
                    ),
                    array (
                        'id' => 'button_shape',
                        'type' => 'select',
                        'title' => __('Button Shape', 'oshin'), 
                        'subtitle' => __('Not Applicable for Blog & Portfolio Button Styles - TEXT UNDERLINE & TAIL', 'oshin'),
                        'desc' => __('The Button Shape will be applied on Blog Read More, Portfolio View Project, Commnets Submit, Shop Pages and Contact Form Buttons' , 'oshin'),
                        'options'=> array('rounded' => 'Rounded', 'circular'=>'Circular', 'none'=>'Default'),
                        'default' => 'none'
                    ),                        
                    array (
                        'id' => 'custom_sidebars',
                        'type' => 'multi_text',
                        'title' => __('Custom Sidebars', 'oshin'),
                        
                        
                        'default' => ''
                    ),
                    array (
                        'id' => 'maintenance_mode_on',
                        'type' => 'checkbox',
                        'title' => __('Turn On Maintenance Mode', 'oshin'),
                        'desc' => __('For users, not logged into site' , 'oshin'),
                        'default' => 0
                    ),
                    array (
                        'id' => 'maintenance_mode_page',
                        'type' => 'select',
                        'title' => __('Maintenance Mode Page', 'oshin'),
                        'desc' => __('Select a page that you want to use as splash page in maintenance mode.' , 'oshin'),
                        'options'=> oshine_get_all_pages(),
                        'default' => 'right_side'
                    ),
                    array (
                        'id' => 'instagram_access_token',
                        'type' => 'text',
                        'title' => __('Instagram Access Token', 'oshin'), 
                        'subtitle' => __("<a href='https://developers.facebook.com/docs/instagram-basic-display-api/getting-started/' target='_blank'>Generate Access Token</a>", 'oshin'),
                        'desc' => __('' , 'oshin'),
                        'default' => ''
                    ), 
                    array (
                        'id' => 'google_map_api_key',
                        'type' => 'text',
                        'title' => __('Google Map API Key', 'oshin'), 
                        'subtitle' => __("<a href='https://developers.google.com/maps/documentation/javascript/get-api-key/' target='_blank'>Generate your API Key</a>", 'oshin'),
                        'desc' => __('' , 'oshin'),
                        'default' => ''
                    ), 
                    array (
                        'id'       => 'cdn_address',
                        'type'     => 'text',
                        'title'    => __( 'CDN Address', 'oshin' ),
                        'subtitle' => __( "Add your cdn address here, if you are using one", 'oshin' ),
                        'desc'     => __( '', 'oshin' ),
                        'default'  => ''
                    )
                )
            );
            //Top Header Settings
            $this->sections[] = array(
                'title'     => __('Top Header Settings', 'oshin'),
                'desc'      => __('This Panel has all the settings related to the Top Header Style', 'oshin'),
                'icon'      => 'el-icon-hand-up',
                'class'     => 'top-header-settings',
                'subsection' => false
            );
            //Top Header Style
            $this->sections[] = array(
                'title'     => __('Header Style', 'oshin'),
                'desc'      => __('<a href="https://www.brandexponents.com/oshine-knowledgebase/knowledge-base/top-header-settings/" target="_blank">Top Header Documentation</a>', 'oshin'),
                'icon'      => '',
                'subsection' => true,
                'fields'    => array(
                    array(
                        'id'        => 'opt-header-wrap',
                        'type'      => 'switch',
                        'title'     => __('Header Wrap', 'oshin'),
                        'subtitle'  => __('Turn this off if you want a Full Screen Width Header', 'oshin'),
                        'default'   => false,
                    ),
                    array(
                        'id'        => 'opt-header-style',
                        'type'      => 'select_image',
                        'tiles'     => true,
                        'title'     => __('Top Header Style', 'oshin'),
                        'subtitle'  => __('', 'oshin'),
                        'options'   => $top_header_styles,
                        'default' => $top_header_styles_url.'style3.png',
                    ),
                    array(
                        'id'        => 'opt-header-top-menu-settings',
                        'type'      => 'section',
                        'title'     => 'Menu Settings',
                        'indent'    => true, // Indent all options below until the next 'section' option is set.
                    ),
                    //Menu level
                    array(
                            'id'        => 'opt-menu-level',
                            'type'      => 'text',
                            'title'     => __('Menu Level', 'oshin'),
                            'subtitle'  => __('Maximum menu level to show (numeric)', 'oshin'),
                            'default' => '3',
                         ),
                        // Old Menu Style Settings
                        array (
                            'id'        => 'top-menu-style',
                            'type'      => 'select',
                            'title'     => __('Special Menu Type', 'oshin'),
                            'subtitle'  => __('Choose the type of Special Menu for navigation. This is possible in any of the Header Styles choosen above. ','oshin'),
                            'options'   => array (
                                            'top-overlay-menu' => 'Overlay Menu', 
                                            'menu-animate-fall' => 'Animate Falling',
                                            'none' => 'None'
                                        ) ,
                            'required'  => array( 'opt-header-style', 'equals', array( 
                                                    get_template_directory_uri().'/img/headers/style1.png',
                                                    get_template_directory_uri().'/img/headers/style2.png',
                                                    get_template_directory_uri().'/img/headers/style3.png',
                                                    get_template_directory_uri().'/img/headers/style4.png',
                                                    get_template_directory_uri().'/img/headers/style5.png',
                                                    get_template_directory_uri().'/img/headers/style6.png' ) ),            
                            'default'   => 'none',
                        ),
                        array (
                            'id' => 'nav_link_style',
                            'type' => 'select',
                            'title' => __('Navigation Link Hover Style', 'oshin'), 
                            'subtitle' => __('Does not apply for Overlay Menu Style', 'oshin'),
                            
                            'options'   => array('none' => 'None', 'be-nav-link-effect-1' => 'Bottom Line Fades In' , 'be-nav-link-effect-2' => 'Bottom Line Diverges out upto the Edge' , 'be-nav-link-effect-3' => 'Bottom Line Diverges out'), 
                            'required'  => array( 'opt-header-style', 'equals', array( 
                                                    get_template_directory_uri().'/img/headers/style1.png',
                                                    get_template_directory_uri().'/img/headers/style2.png',
                                                    get_template_directory_uri().'/img/headers/style3.png',
                                                    get_template_directory_uri().'/img/headers/style4.png',
                                                    get_template_directory_uri().'/img/headers/style5.png',
                                                    get_template_directory_uri().'/img/headers/style6.png' ) ),            
                            'default' => 'none'
                        ), 
                        // New Menu Style Settings
                        array (
                            'id'        => 'top_header_hamburger_style',
                            'type'      => 'select_image',
                            // 'type'      => 'select',
                            'tiles'     => true,
                            'title'     => __('Hamburger Style', 'oshin'),
                            'subtitle'  => __('', 'oshin'),
                            'options'   => $hamburger_styles,
                            'default' => get_template_directory_uri().'/img/hamburger-styles/style1.jpg',
                        ),
                        array (
                            'id'        => 'opt-menu-style',
                            'type'      => 'select_image',
                            'tiles'     => true,
                            'title'     => __('Menu Style', 'oshin'),
                            'subtitle'  => __('', 'oshin'),
                            'options'   => $menu_styles  ,
                            'required'  => array( 'opt-header-style', 'equals', array( 
                                                    get_template_directory_uri().'/img/headers/style7.png',
                                                    get_template_directory_uri().'/img/headers/style8.png',
                                                    get_template_directory_uri().'/img/headers/style9.png',
                                                    get_template_directory_uri().'/img/headers/style10.png',
                                                    get_template_directory_uri().'/img/headers/style11.png',
                                                    get_template_directory_uri().'/img/headers/style12.png' ) ), 
                            'default' => get_template_directory_uri().'/img/menu_styles/page-stack-left.jpg',
                        ),
                        array (
                            'id'        => 'be_sidemenu_width',
                            'type'      => 'text',
                            'title'     => __('Menu Bar Width', 'oshin'),
                            'required'  => array('opt-menu-style','equals', array(
                                                    get_template_directory_uri().'/img/menu_styles/page-stack-left.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/page-stack-right.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/special-left-menu.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/special-right-menu.jpg',
                                                ) ),
                            'validate'  => 'numeric',
                            'default'   => '280',
                        ),
                        array (
                            'id'        => 'top_special_header_menu_animation',
                            'type'      => 'select',
                            'title'     => __( 'Menu Link Animation Direction', 'oshin'),
                            'required'  =>  array( 'opt-menu-style', 'equals', array(                                               
                                                    get_template_directory_uri().'/img/menu_styles/page-stack-top.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/page-stack-left.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/page-stack-right.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/perspective-left.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/perspective-right.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/special-left-menu.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/special-right-menu.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/overlay-center-align-menu.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/overlay-horizontal-menu.jpg' ) ),
                            'options'   => array( 
                                                    'r2l'=>'Right to Left',
                                                    'l2r'=>'Left to Right', 
                                                    't2b'=>'Top to Bottom',
                                                    'b2t'=>'Bottom to Top' 
                                                ),
                            'default'   => 'r2l',
                        ),
                        array (
                            'id'        => 'top_menu_hover_style',
                            'type'      => 'select',
                            'title'     => __( 'Menu Link Hover Style', 'oshin'),
                            'options'   => array( 
                                                    'none'=>'None',
                                                    'underline' => 'Underline', 
                                                    'color-fill'=>'Color fill', 
                                                    'color-fill-with-underline'=>'Color fill with underline',
                                                    'tail-left'=>'Tail to the left' 
                                                ),
                            'required'  =>  array( 'opt-menu-style', 'equals', array(                                               
                                                    get_template_directory_uri().'/img/menu_styles/page-stack-top.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/page-stack-left.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/page-stack-right.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/perspective-left.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/perspective-right.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/special-left-menu.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/special-right-menu.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/overlay-center-align-menu.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/overlay-horizontal-menu.jpg' ) ),                    
                            'default'   => 'none',
                        ),
                        array (
                            'id'        => 'side_menu_style',
                            'type'      => 'select',
                            'title'     => __( 'Menu Sliding Style', 'oshin'),
                            'required'  => array( 'opt-menu-style', 'equals', array(
                                                    get_template_directory_uri().'/img/menu_styles/special-left-menu.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/special-right-menu.jpg'                                                
                                                ) ),
                            'options'   => array( 'slide-special-menu'=>'Push Page', 'push-special-menu'=>'Over Page' ),
                            'default'   => 'slide-special-menu',
                        ),
                        array (
                            'id'        => 'top_special_menu_alignment',
                            'type'      => 'select',
                            'title'     => __('Menu Vertical Alignment', 'oshin'),
                            'required'  => array( 'opt-menu-style', 'equals', array( 
                                                    get_template_directory_uri().'/img/menu_styles/page-stack-left.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/page-stack-right.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/perspective-left.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/perspective-right.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/special-left-menu.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/special-right-menu.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/overlay-center-align-menu.jpg'                                                                                               
                                                ) ),
                            'options'   => array( 'flex-start'=>'Top', 'center'=>'Middle', 'flex-end'=>'Bottom' ),
                            'default'   => 'flex-start',
                        ),
                        array (
                            'id'        => 'top_special_menu_alignment_horizontal',
                            'type'      => 'select',
                            'title'     => __('Menu Horizontal Alignment', 'oshin'),
                            'required'  => array( 'opt-menu-style', 'equals', array( 
                                                    get_template_directory_uri().'/img/menu_styles/page-stack-left.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/page-stack-right.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/page-stack-top.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/perspective-left.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/perspective-right.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/special-left-menu.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/special-right-menu.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/overlay-center-align-menu.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/overlay-horizontal-menu.jpg'                                                                                                                                             
                                                ) ),
                            'options'   => array( 'left'=>'Left', 'center'=>'Center', 'right'=>'Right' ),
                            'default'   => 'center',
                        ),
                        array (
                            'id'        => 'stack_menu_bg_color',
                            'type'      => 'color_rgba',
                            'title'     => __('Stack Background Color', 'oshin'),
                            'required'  => array( 'opt-menu-style', 'equals', array( 
                                                    get_template_directory_uri().'/img/menu_styles/page-stack-left.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/page-stack-right.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/page-stack-top.jpg'
                                                ) ),
                            'default'   =>  array('color' => '#1a1a1a', 'alpha' => '1'),
                        ),
                        // Common Color Settings
                        array (
                            'id'        => 'sidebar_menu_bg_color',
                            'type'      => 'color_rgba',
                            'title'     => __('Right Slidebar/Overlay Menu Background Color', 'oshin'), 
                            'subtitle'  => __('', 'oshin'),
                            'desc'      => __('', 'oshin'),
                            'default'   =>  array('color' => '#1a1a1a', 'alpha' => '1'),
                        ),  
                        array(
                            'id'        => 'right_side_menu_border',
                            'type'      => 'color',
                            'title'     => __('Right Slidebar/Overlay Menu Border Color', 'oshin'), 
                            'subtitle'  => __('', 'oshin'),
                            'desc'      => __('', 'oshin'),
                            'default'   => '#2d2d2d'
                        ),
                        array (
                            'id'        => 'main_overlay_color_top_menu_open',
                            'type'      => 'color_rgba',
                            'title'     => __('Overlay color on page when Sliding / Sidebar Stack menu is opened', 'oshin'),
                            'required'  => array( 'opt-menu-style', 'equals', array( 
                                                    get_template_directory_uri().'/img/menu_styles/page-stack-left.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/page-stack-right.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/special-left-menu.jpg',
                                                    get_template_directory_uri().'/img/menu_styles/special-right-menu.jpg'
                                                ) ),
                            'default'   =>  array('color' => '#000000', 'alpha' => '0.8'),
                         ),                         
                    array(
                        'id'        => 'opt-header-widgets-left-end',
                        'type'      => 'section',
                        'indent'    => false, // End of Indentation.
                    ),
                    array(
                        'id'        => 'opt-header-submenu-start',
                        'type'      => 'section',
                        'title'     => 'Submenu Settings',
                        'indent'    => true, // Indent all options below until the next 'section' option is set.
                    ),
                        array(
                            'id'        => 'submenu_bg_color',
                            'type'      => 'color_rgba',
                            'title'     => __('Submenu Background Color', 'oshin'), 
                            'subtitle'  => __('', 'oshin'),
                            'desc'      => __('', 'oshin'),
                            'default'   =>  array('color' => '#1f1f1f', 'alpha' => '1'),
                        ),  
                        array(
                            'id'        => 'sub_menu_border',
                            'type'      => 'color',
                            'title'     => __('Submenu Border Color', 'oshin'), 
                            'subtitle'  => __('', 'oshin'),
                            'desc'      => __('', 'oshin'),
                            'default'   => '#3d3d3d'
                        ),
                    array(
                        'id'        => 'opt-header-submenu-end',
                        'type'      => 'section',
                        'indent'    => false, // End of Indentation.
                    ), 
                    array (
                        'id'        => 'menu_and_widget_color_top_menu_open',
                        'type'      => 'select',
                        'title'     => __('Menu and widgets color scheme', 'oshin'),
                        'subtitle'  => __( 'Color scheme that will appear when the menu is opened', 'oshin' ),
                        'options'   => array( 'dark' => 'Dark', 'light' => 'Light'),
                        'required'  => array( 'opt-menu-style', 'equals', array( 
                                                get_template_directory_uri().'/img/menu_styles/overlay-center-align-menu.jpg',
                                                get_template_directory_uri().'/img/menu_styles/overlay-horizontal-menu.jpg',
                                                get_template_directory_uri().'/img/menu_styles/page-stack-top.jpg'
                                            ) ),
                        'default'   =>  'dark',
                    ),
                    array(
                        'id'        => 'top_special_header_bottom_text',
                        'type'      => 'ace_editor',
                        'multi'     => true,
                        // 'title'     => __('Special Header Bottom Text/HTML/Shortcode', 'oshin'),
                        'title'     => __('Widget Area', 'oshin'),
                        'subtitle'  => __('For Example Social Media Icons', 'oshin'),
                        'required'  => array( 'opt-menu-style', 'equals', array( 
                                                get_template_directory_uri().'/img/menu_styles/page-stack-top.jpg',                                                
                                                get_template_directory_uri().'/img/menu_styles/page-stack-left.jpg',
                                                get_template_directory_uri().'/img/menu_styles/page-stack-right.jpg',
                                                get_template_directory_uri().'/img/menu_styles/perspective-left.jpg',
                                                get_template_directory_uri().'/img/menu_styles/perspective-right.jpg',
                                                get_template_directory_uri().'/img/menu_styles/special-left-menu.jpg',
                                                get_template_directory_uri().'/img/menu_styles/special-right-menu.jpg',
                                                get_template_directory_uri().'/img/menu_styles/overlay-center-align-menu.jpg',
                                                get_template_directory_uri().'/img/menu_styles/overlay-horizontal-menu.jpg'                                                                                                
                                            ) ),
                    ),
                    array (
                        'id'        => 'nav_link_hover_color_controller',
                        'type'      => 'checkbox',
                        'title'     => __('Set Navigation Link Hover Color', 'oshin'), 
                        'subtitle'  => __('', 'oshin'),
                        'desc'      => __('By default the Color Scheme set under OSHINE OPTIONS > COLORS will be applied for Menu Links on Hover State', 'oshin'),
                        'default'   => 0,
                    ),              
                    array (
                        'id'        => 'nav_link_hover_color',
                        'type'      => 'color',
                        'title'     => __('Navigation Link Hover Color', 'oshin'), 
                        'subtitle'  => __('', 'oshin'),
                        'desc'      => __('', 'oshin'),
                        'default'   => '',
                        'required' => array('nav_link_hover_color_controller','equals','1')
                    ),
                    array (
                        'id' => 'sticky_header',
                        'type' => 'checkbox',
                        'title' => __('Enable Sticky Header', 'oshin'),
                        
                        
                        'default' => 0
                    ),  
                    array(
                        'id'        => 'semi-transparent-header-color',
                        'type'      => 'color_rgba',
                        'title'     => __('Semi Transparent Background Color', 'oshin'), 
                        'subtitle'  => __('This color will apply as BG for the Top Header in pages where you choose Semi Transparent Header' , 'oshin'),
                        'desc'      => __('', 'oshin'),
                        'default'   =>  array('color' => '#000000', 'alpha' => '0.4'),
                    ),
                    array(
                        'id'        => 'opt-header-border-color',
                        'type'      => 'border',
                        'title'     => __('Header Border Color', 'oshin'),
                        'subtitle'  => __('Border Bottom','oshin'),
                        'default'   => array(
                            'border-color'  => '', 
                            'border-style'  => 'none', 
                            'bottom' => '0px'
                        ),
                        'all'    => false,
                        'top'    => false,
                        'left'   => false,
                        'right'  => false
                    ),              
                    array(
                        'id'        => 'opt-header-border-wrap',
                        'type'      => 'switch',
                        'title'     => __('Header Border Wrap', 'oshin'),
                        'subtitle'  => __('Turn this on if you want a wrapped border', 'oshin'),
                        'default'   => false,
                    ),
                )
            );

            //Header Widget Settings
            $this->sections[] = array(
                'title'     => __('Header Widgets', 'oshin'),
                'desc'      => __('This Panel has all the settings related to the Header', 'oshin'),
                'icon'      => '',
                'subsection' => true,
                'fields'    => array(
                    array(
                        'id'        => 'opt-header-pos',
                        'type'      => 'sorter',
                        'title'     => __('Position of widgets in Header','oshin'),
                        'compiler'  => 'true',
                        'options'   => array(
                            'unused'  => array(
                                'phone' => 'Text 1',
                                'email' => 'Text 2',
                                'smenu' => 'Sliding Menu',
                                'socialmedia' => 'Code Content',
                                'search' => 'Search Widget',
                                'cart'   => 'Cart',
                            ),
                            'left'   => array(
                            ),
                            'right'    => array(
                            ),
                        ),
                        'default'  => false
                    ),
                    array(
                        'id'        => 'opt-header-widgets-left',
                        'type'      => 'section',
                        'title'     => 'Text and Code Widget Settings',
                        'indent'    => true, // Indent all options below until the next 'section' option is set.
                    ),
                        array(
                            'id'        => 'opt-phone-header',
                            'type'      => 'text',
                            'title'     => __('Text Area 1', 'oshin'),
                            'default'   => '',
                        ),
                        array(
                            'id'        => 'opt-email-header',
                            'type'      => 'text',
                            'title'     => __('Text Area 2', 'oshin'),
                            'default'   => '',
                        ),
                        array(
                            'id'        => 'opt-header-social-media',
                            'type'      => 'ace_editor',
                            'multi'     => true,
                            'title'     => __('Content using Code/Shortcode', 'oshin'),
                            'subtitle'  => __('For Example Social Media Icons', 'oshin'),
                        ),
                    array(
                        'id'        => 'opt-header-widgets-left-end',
                        'type'      => 'section',
                        'indent'    => false, // End of Indentation.
                    ), 
                    array (
                        'id'        => 'search-settings-start',
                        'type'      => 'section',
                        'title'     => 'Search Widget Settings',
                        'indent'    => true, // Indent all options below until the next 'section' option is set.
                    ), 
                        array (
                            'id' => 'seach_widget_style',
                            'type' => 'select',
                            'title' => __('Header Search Widget Style', 'oshin'),
                            
                            
                            'options'=> array (
                                'style1-header-search-widget' => 'Search Bar', 
                                'style2-header-search-widget' => 'Overlay Search'
                            ),
                            'default' => 'style2-header-search-widget'
                        ),                   
                        array(
                            'id'        => 'search_bg',
                            'type'      => 'color_rgba',
                            'title'     => __('Search Screen BG', 'oshin'), 
                            'subtitle'  => __('', 'oshin'),
                            'desc'      => __('', 'oshin'),
                            'default'   => array('color' => '#ffffff', 'alpha' => '0.85'),
                        ),                
                        array(
                            'id'        => 'search_font_color',
                            'type'      => 'color',
                            'title'     => __('Search Text Color', 'oshin'), 
                            'subtitle'  => __('', 'oshin'),
                            'desc'      => __('', 'oshin'),
                            'default'   => '#000000'
                        ),
                    array(
                        'id'        => 'search-settings-end',
                        'type'      => 'section',
                        'indent'    => false, // Indent all options below until the next 'section' option is set.
                    ), 
                    array (
                        'id'        => 'cart-settings-start',
                        'type'      => 'section',
                        'title'     => 'Cart Widget Settings',
                        'indent'    => true, // Indent all options below until the next 'section' option is set.
                    ),
                        array(
                            'id'        => 'header_cart_count_background',
                            'type'      => 'color',
                            'title'     => __('Header Cart Number Background Color', 'oshin'), 
                            'subtitle'  => __('', 'oshin'),
                            'desc'      => __('', 'oshin'),
                            'default'   => '#646464'
                        ),
                        array(
                            'id'        => 'header_cart_count_color',
                            'type'      => 'color',
                            'title'     => __('Header Cart Number Text Color', 'oshin'), 
                            'subtitle'  => __('', 'oshin'),
                            'desc'      => __('', 'oshin'),
                            'default'   => '#f5f5f5'
                        ), 
                    array(
                        'id'        => 'cart-settings-end',
                        'type'      => 'section',
                        'indent'    => false, // Indent all options below until the next 'section' option is set.
                    ), 
                )
            );
            //Header Top Bar
            $this->sections[] = array(
                'title'     => __('Header Top Bar', 'oshin'),
                'desc'      => __('Top Bar will apply only on TOP header style and not on Left Header', 'oshin'),
                'icon'      => '',
                'subsection' => true,
                'fields'    => array(
                    array(
                        'id'        => 'opt-noshow-topbar',
                        'type'      => 'checkbox',
                        'title'     => __('Enable Header Top Bar', 'oshin'),
                        'desc'      => __('', 'oshin'),
                        'default'   => 0// 1 = on | 0 = off
                    ),
                    array(
                        'id'        => 'opt-topbar-color',
                        'type'      => 'color_rgba',
                        'title'     => __('Top Bar Background Color', 'oshin'),
                        'default'   => array('color' => '#323232', 'alpha' => '0.85'),
                        'required' => array('opt-noshow-topbar','equals','1'),
                    ),
                    array(
                        'id'        => 'opt-topbar-text-color',
                        'type'      => 'color',
                        'title'     => __('TopBar Text Color', 'oshin'),
                        'default'   => '#ffffff',
                        'required' => array('opt-noshow-topbar','equals','1'),
                    ),
                    array(
                        'id'        => 'opt-topbar-border-color',
                        'type'      => 'border',
                        'title'     => __('Top Bar Border (bottom) Color', 'oshin'),
                        'default'   => array(
                            'border-color'  => '#323232', 
                            'border-style'  => 'none', 
                            'bottom'        => '0px', 
                        ),
                        'all'   => false,
                        'left'  =>  false,
                        'right' =>  false,
                        'top'   =>  false,
                        'required' => array('opt-noshow-topbar','equals','1'),
                    ),
                    array(
                        'id'        => 'opt-topbar-widgets-pos',
                        'type'      => 'sorter',
                        'title'     => 'Position of widgets in the Top Bar',
                        'compiler'  => 'true',
                        'options'   => array(
                            'unused'  => array(
                                'phone' => 'Text 1',
                                'email' => 'Text 2',
                                'menu'  => 'Menu Links',
                                'socialmedia' => 'Code Content',
                                'search' => 'Search Widget',
                                'cart'   => 'Cart',
                            ),
                            'left'   => array(
                            ),
                            'right'    => array(
                            ),
                        ),
                        'default'  => false,
                        'required' => array('opt-noshow-topbar','equals','1'),
                    ),
                    array(
                        'id'        => 'opt-phone-topbar',
                        'type'      => 'text',
                        'title'     => __('Text Area 1', 'oshin'),
                        'default'   => '',
                        'required' => array('opt-noshow-topbar','equals','1'),
                    ),
                    array(
                        'id'        => 'opt-email-topbar',
                        'type'      => 'text',
                        'title'     => __('Text Area 2', 'oshin'),
                        'default'   => '',
                        'required' => array('opt-noshow-topbar','equals','1'),
                    ),
                    array(
                        'id'        => 'opt-smedia-topbar',
                        'type'      => 'ace_editor',
                        'multi'     => true,
                        'title'     => __('Content using Code/Shortcode', 'oshin'),
                        'required' => array('opt-noshow-topbar','equals','1'),
                    ),
                )
            );
            //Header Bottom Bar Settings
            $this->sections[] = array(
                'title'     => __('Header Bottom Bar', 'oshin'),
                'desc'      => __('This is appicable only if you choose a Header Style with Menu at the Bottom (i.e. style2)', 'oshin'),
                'icon'      => '',
                'subsection' => true,
                'fields'    => array(
                    array(
                        'id'        => 'opt-bottombar-color',
                        'type'      => 'color_rgba',
                        'title'     => __('Bottom Bar Background Color', 'oshin'),
                        'subtitle'  => __('','oshin'),
                        'default'   => array('color' => '#ffffff', 'alpha' => '1'),
                    ),
                    array(
                        'id'        => 'opt-bottombar-border-color',
                        'type'      => 'border',
                        'title'     => __('Bottom Bar Border Color', 'oshin'),
                        'subtitle'  => __('','oshin'),
                        'default'   => array(
                            'border-color'  => '#323232', 
                            'border-style'  => 'none', 
                            'top'    => '0px', 
                            'bottom' => '0px'
                        ),
                        'all' => false,
                        'left' => false,
                        'right' => false
                    ),
                )
            );
            //Left Header Settings
            $this->sections[] = array(
                'title'     => __('Left Header Settings', 'oshin'),
                'desc'      => __('This Panel has all the settings related to the Left Header Style', 'oshin'),
                'icon'      => 'el-icon-hand-left',
                'class'     => 'left-header-settings',
                'subsection' => false,
                'fields'    => array(

                    array(
                        'id'        => 'left-header-style',
                        'type'      => 'select_image',
                        'width'     => '500px',
                        'tiles'     => true,
                        'title'     => __('Left Header Style', 'oshin'),
                        'subtitle'  => __('', 'oshin'),
                        // 'options'   => array('static' => 'Static Left Menu', 'strip' => 'Strip with Left Menu', 'overlay' => 'Strip with Overlay Menu') ,
                        'options'   => $left_header_styles,
                        'default'   => get_template_directory_uri().'/img/headers/left/left-static-menu.jpg',
                    ),

                    array(
                        'id'        => 'left_header_hamburger_style',
                        'type'      => 'select_image',
                        // 'type'      => 'select',
                        'tiles'     => true,
                        'title'     => __('Hamburger Style', 'oshin'),
                        'subtitle'  => __('', 'oshin'),
                        'options'   => $hamburger_styles  ,
                        'required'  => array('left-header-style','equals', array(
                                            get_template_directory_uri().'/img/headers/left/left-strip-menu.jpg',
                                            get_template_directory_uri().'/img/headers/left/overlay-center-align-menu.jpg',
                                            get_template_directory_uri().'/img/headers/left/overlay-left-align-menu.jpg',
                                            get_template_directory_uri().'/img/headers/left/perspective-right.jpg' ) ),
                        'default' => get_template_directory_uri().'/img/hamburger-styles/style1.jpg',
                    ),
                    array (
                        'id'        => 'left_special_header_width',
                        'type'      => 'text',
                        'title'     => __('Left header Width', 'oshin'),
                        'required'  => array('left-header-style','equals', array(
                                            get_template_directory_uri().'/img/headers/left/left-strip-menu.jpg',
                                            get_template_directory_uri().'/img/headers/left/left-static-menu.jpg' ) ),
                        'validate'  => 'numeric',
                        'default'   => '280',
                    ),

                    array (
                        'id'        => 'left_special_strip_width',
                        'type'      => 'text',
                        'title'     => __('Left Strip Width', 'oshin'),
                        'required'  => array('left-header-style','equals', array(
                                            get_template_directory_uri().'/img/headers/left/left-strip-menu.jpg',
                                            get_template_directory_uri().'/img/headers/left/overlay-center-align-menu.jpg',
                                            get_template_directory_uri().'/img/headers/left/overlay-left-align-menu.jpg',
                                            get_template_directory_uri().'/img/headers/left/perspective-right.jpg' ) ),
                        'validate'  => 'numeric',
                        'default'   => '70',
                    ),

                    array(
                        'id'        => 'left_strip_bg_color',
                        'type'      => 'color_rgba',
                        'title'     => __('Left Strip Background Color', 'oshin'),
                        'required'  => array('left-header-style','equals', array(
                                            get_template_directory_uri().'/img/headers/left/left-strip-menu.jpg',
                                            get_template_directory_uri().'/img/headers/left/overlay-center-align-menu.jpg',
                                            get_template_directory_uri().'/img/headers/left/overlay-left-align-menu.jpg',
                                            get_template_directory_uri().'/img/headers/left/perspective-right.jpg' ) ),
                        'default'   =>  array('color' => '#000000', 'alpha' => '0.85'),
                    ),

                    array (
                        'id'        => 'main_overlay_color_left_menu_open',
                        'type'      => 'color_rgba',
                        'title'     => __('Main overlay color when menu is opened', 'oshin'),
                        'required'  => array('left-header-style','equals', array(
                                            get_template_directory_uri().'/img/headers/left/left-strip-menu.jpg',
                                            ) ),
                        'default'   =>  array('color' => '#000000', 'alpha' => '0.8'),
                    ),

                    array (
                        'id'        => 'left_special_header_menu_animation',
                        'type'      => 'select',
                        'title'     => __( 'Menu Link Animation Direction', 'oshin'),
                        'required'  =>  array('left-header-style','equals', array(
                                                get_template_directory_uri().'/img/headers/left/left-strip-menu.jpg',
                                                get_template_directory_uri().'/img/headers/left/overlay-center-align-menu.jpg',
                                                get_template_directory_uri().'/img/headers/left/overlay-left-align-menu.jpg',
                                                get_template_directory_uri().'/img/headers/left/perspective-right.jpg' ) ),
                        'options'   => array( 
                                                'r2l'=>'Right to Left',
                                                'l2r'=>'Left to Right', 
                                                't2b'=>'Top to Bottom',
                                                'b2t'=>'Bottom to Top' 
                                            ),
                        'default'   => 'r2l',
                    ),
                    array (
                        'id'        => 'left_menu_hover_style',
                        'type'      => 'select',
                        'title'     => __( 'Menu Hover Style', 'oshin'),
                        'options'   => array( 
                                                'none'=>'None',
                                                'underline' => 'Underline',
                                                'color-fill'=>'Color fill', 
                                                'color-fill-with-underline'=>'Color fill with underline',
                                                'tail-left'=>'Tail to the left' 
                                            ),
                        'default'   => 'none',
                    ),
                     array (
                        'id'        => 'left_special_menu_alignment',
                        'type'      => 'select',
                        'title'     => __('Menu Vertical Alignment', 'oshin'),
                        'required'  =>  array('left-header-style','equals', array(
                                            get_template_directory_uri().'/img/headers/left/left-strip-menu.jpg',
                                            get_template_directory_uri().'/img/headers/left/overlay-center-align-menu.jpg',
                                            get_template_directory_uri().'/img/headers/left/overlay-left-align-menu.jpg',
                                            get_template_directory_uri().'/img/headers/left/perspective-right.jpg' )
                                        ),
                        'options'   => array( 'flex-start'=>'Top', 'center'=>'Center', 'flex-end'=>'Bottom' ),
                        'default'   => 'flex-start',
                    ),
                    array (
                        'id'        => 'left_special_menu_alignment_horizontal',
                        'type'      => 'select',
                        'title'     => __('Menu Horizontal Alignment', 'oshin'),
                        'required'  =>  array('left-header-style','equals', array(
                                            get_template_directory_uri().'/img/headers/left/left-strip-menu.jpg',                                            // get_template_directory_uri().'/img/headers/left/overlay-center-align-menu.jpg',
                                            get_template_directory_uri().'/img/headers/left/perspective-right.jpg' )
                                        ),
                        'options'   => array( 'left'=>'Left', 'center'=>'Center', 'right'=>'Right' ),
                        'default'   => 'center',
                    ),
                    array (
                        'id'        => 'left_header_alignment_horizontal',
                        'type'      => 'select',
                        'title'     => __('Left Header Horizontal Alignment', 'oshin'),
                        'required'  =>  array('left-header-style', 'equals', get_template_directory_uri().'/img/headers/left/left-static-menu.jpg' ),
                        'options'   => array( 'left'=>'Left', 'center'=>'Center', 'right'=>'Right' ),
                        'default'   => 'center',
                    ),
                    array(
                        'id'        => 'left-strip-animation',
                        'type'      => 'select',
                        'title'     => __('Left Strip Animation', 'oshin'),
                        'subtitle'  => __('', 'oshin'),
                        'options'   => array('menu_push_main' => 'Push Main', 'menu_over_main' => 'Over Main') ,
                        'required' => array('left-header-style','equals', array(
                                            get_template_directory_uri().'/img/headers/left/strip.jpg',
                                            get_template_directory_uri().'/img/headers/left/left-strip-menu.jpg',
                                            'strip')
                                        ),
                        'default'  => 'menu_push_main'
                    ), 
                    array(
                        'id'        => 'left_special_header_bottom_text',
                        'type'      => 'ace_editor',
                        'multi'     => true,
                        'title'     => __('Special Header Bottom Text/HTML/Shortcode', 'oshin'),
                        'subtitle'  => __('For Example Social Media Icons', 'oshin'),
                        'required'  => array('left-header-style','equals', array(
                                            get_template_directory_uri().'/img/headers/left/left-strip-menu.jpg',
                                            get_template_directory_uri().'/img/headers/left/left-static-menu.jpg',
                                            get_template_directory_uri().'/img/headers/left/overlay-center-align-menu.jpg',
                                            get_template_directory_uri().'/img/headers/left/overlay-left-align-menu.jpg',
                                            get_template_directory_uri().'/img/headers/left/perspective-right.jpg' ) ),
                    ),     
                    array(
                        'id'        => 'left-static-overlay',
                        'type'      => 'color_rgba',
                        'title'     => __('Overlay Color on Left Menu', 'oshin'), 
                        'subtitle'  => __('Will apply on the menu that has a BG image. This will not be applied on "3D Menu" style', 'oshin'),
                        'desc'      => __('', 'oshin'),
                        'default'   =>  array('color' => '#ffffff', 'alpha' => '0.85'),
                    ),
                    array(
                        'id'        => 'left_overlay_menu_bg_color',
                        'type'      => 'color_rgba',
                        'title'     => __('Left Overlay Menu Background Color', 'oshin'), 
                        'subtitle'  => __('', 'oshin'),
                        'desc'      => __('', 'oshin'),
                        'required'  => array('left-header-style','equals', array(
                                            get_template_directory_uri().'/img/headers/left/left-strip-menu.jpg',
                                            //get_template_directory_uri().'/img/headers/left/left-static-menu.jpg',
                                            get_template_directory_uri().'/img/headers/left/overlay.jpg',
                                            get_template_directory_uri().'/img/headers/left/overlay-center-align-menu.jpg',
                                            get_template_directory_uri().'/img/headers/left/overlay-left-align-menu.jpg',
                                            get_template_directory_uri().'/img/headers/left/perspective-right.jpg',
                                            'overlay' ) ),
                        'default'   =>  array('color' => '#080808', 'alpha' => '0.90'),
                    ),   
                    array(
                        'id'        => 'left_side_menu_border',
                        'type'      => 'color',
                        'title'     => __('Left Menu Border Color', 'oshin'), 
                        'subtitle'  => __('', 'oshin'),
                        'desc'      => __('', 'oshin'),
                        'required'  => array('left-header-style','equals', array(
                                            get_template_directory_uri().'/img/headers/left/left-strip-menu.jpg',
                                            get_template_directory_uri().'/img/headers/left/static.jpg',
                                            get_template_directory_uri().'/img/headers/left/strip.jpg',
                                            get_template_directory_uri().'/img/headers/left/overlay.jpg',
                                            // For old users
                                            'static',
                                            'strip',
                                            'overlay' ) ),
                        'default'   => '#3d3d3d'
                    ), 
                )
            );
            //Footer Settings
            $this->sections[] = array(
                'title'     => __('Footer Settings', 'oshin'),
                'desc'      => sprintf( __('This Panel has all the settings required for the footer <a href="%s" target="_blank">Footer Documentation</a>', 'oshin'), 'https://www.brandexponents.com/oshine-knowledgebase/knowledge-base/footer-settings/'),
                'icon'      => 'el-icon-hand-down',
                'subsection' => false,
                'fields'    => array(

                    array(
                        'id'        => 'opt-footer-wrap',
                        'type'      => 'switch',
                        'title'     => __('Footer Wrap', 'oshin'),
                        'subtitle'  => __('Turn this off if you want a Full Screen Width Footer', 'oshin'),
                        'default'   => true,
                    ),
                    array(
                        'id'        => 'footer-style',
                        'type'      => 'select',
                        'title'     => __('Footer Style', 'oshin'),
                        'subtitle'  => __('', 'oshin'),
                        'options'   => array('style1' => 'Horizontal', 'style2' => 'Vertical') ,
                        'default' => 'style1',
                    ),      
                    array (
                        'id'        => 'fixed-footer',
                        'type'      => 'switch',
                        'title'     => __( 'Footer - Fixed to Bottom ?', 'oshin' ),
                        'subtitle'  => __( 'Turn on this option will dock the footer at the bottom, behind the wrapper', 'oshin' ),
                        'default'   => false, 
                    ), 
                    array(
                        'id'        => 'footer-border-color',
                        'type'      => 'border',
                        'title'     => __('Footer border(Top) color', 'oshin'),
                        'subtitle'  => __('','oshin'),
                        'default'   => array(
                            'border-color'  => '', 
                            'border-style'  => 'none', 
                            'top' => '0px'
                        ),
                        'all'    => false,
                        'bottom'    => false,
                        'left'   => false,
                        'right'  => false
                    ),              
                    array(
                        'id'        => 'footer-border-wrap',
                        'type'      => 'switch',
                        'title'     => __('Footer Border Wrap', 'oshin'),
                        'subtitle'  => __('Turn this on if you want a wrapped border', 'oshin'),
                        'default'   => false,
                    ),
                    array(
                        'id'        => 'footer_padding',
                        'type'      => 'text',
                        'title'     => __('Footer Padding Value (in pixels)', 'oshin'),
                        'default'   => '25',
                    ),
                    array(
                        'id'        => 'footer_text1',
                        'type'      => 'ace_editor',
                        'title'     => __('Primary Text on Footer', 'oshin'),
                        'default'   => 'Copyright Brand Exponents 2018. All Rights Reserved',
                    ),     
                    array(
                        'id'        => 'footer_text2',
                        'type'      => 'ace_editor',
                        'title'     => __('Secondary Text on Footer', 'oshin'),
                        'default'   => '',
                    ),  
                    array(
                        'id'        => 'footer_text3',
                        'type'      => 'ace_editor',
                        'title'     => __('Tertiary Text on Footer', 'oshin'),
                        'default'   => '',
                    ),                     
                    array(
                        'id'        => 'footer-content-pos-left',
                        'type'      => 'radio',
                        'title'     => __('Footer - Widget 1','oshin'),
                        'compiler'  => 'true',
                        'options'   => array('none' => 'None', 'text1' => 'Primary content', 'text2' => 'Secondary content', 'text3' => 'Tertiary content', 'menu'  => 'Menu Links'),
                        'default'   => 'none'
                    ),                     
                    array(
                        'id'        => 'footer-content-pos-center',
                        'type'      => 'radio',
                        'title'     => __('Footer - Widget 2','oshin'),
                        'compiler'  => 'true',
                        'options'   => array('none' => 'None', 'text1' => 'Primary content', 'text2' => 'Secondary content', 'text3' => 'Tertiary content', 'menu'  => 'Menu Links'),
                        'default'   =>  'text1'
                    ),                     
                    array(
                        'id'        => 'footer-content-pos-right',
                        'type'      => 'radio',
                        'title'     => __('Footer - Widget 3','oshin'),
                        'compiler'  => 'true',
                        'options'   => array('none' => 'None', 'text1' => 'Primary content', 'text2' => 'Secondary content', 'text3' => 'Tertiary content', 'menu'  => 'Menu Links'),
                        'default'   => 'none'
                    ),
                    array (
                        'id' => 'bottom_widgets_layout',
                        'type' => 'select',
                        'title' => __('Number of Columns in Footer Widget Area', 'oshin'), 
                        
                        
                        'options'   => array('three-col' => 'Three Column' , 'four-col' => 'Four Column'), 
                        'default' => 'four-col'
                    ),  
                    array (
                        'id' => 'show_bottom_widgets',
                        'type' => 'select',
                        'title' => __('Show Footer Widget Area in Archive and Search Pages', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'options'=> array('yes'=>'Yes', 'no'=>'No'),
                        'default' => 'yes'
                    ),                    
                )
            );
            //Mobile Menu Settings
            $this->sections[] = array(
                'title'     => __('Mobile Menu Settings', 'oshin'),
                'desc'      => sprintf( __('This Panel has all the settings related to the Mobile Menu <a href="%s" target="_blank">Mobile Menu Documentation</a>', 'oshin') , 'https://www.brandexponents.com/oshine-knowledgebase/knowledge-base/mobile-menu-settings/'  ),
                'icon'      => 'el-icon-lines',
                'subsection' => false,
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields'    => array(

                    array(
                        'id'        => 'mobile_menu_bg',
                        'type'      => 'color_rgba',
                        'title'     => __('Mobile Menu Background Color', 'oshin'), 
                        'subtitle'  => __('', 'oshin'),
                        'desc'      => __('', 'oshin'),
                        'default'   => array('color' => '#ffffff', 'alpha' => '1'),
                    ),  
                    array(
                        'id'        => 'mobile_menu_border',
                        'type'      => 'color',
                        'title'     => __('Mobile Menu Border Color', 'oshin'), 
                        'subtitle'  => __('', 'oshin'),
                        'desc'      => __('', 'oshin'),
                        'default'   => '#efefef'
                    ),  
                )
            );
            $this->sections[] = array(
                'title'     => __('Hamburger Icon Settings', 'oshin'),
                'desc'      => sprintf( __('This Panel has all the settings related to the styling of the hamburger icon <a href="%s" target="_blank">Hamburger Icon Settings Documentation</a>', 'oshin') , 'https://www.brandexponents.com/oshine-knowledgebase/knowledge-base/hamburger-icon-settings/'  ),
                'icon'      => 'el-icon-lines',
                'fields'    => array(
                        array(
                            'id'        => 'mobile_menu_icon_bg',
                            'type'      => 'color_rgba',
                            'title'     => __('Hamburger Menu Background', 'oshin'), 
                            'subtitle'  => __('', 'oshin'),
                            'desc'      => __('', 'oshin'),
                            'default'   => array('color' => '#ffffff', 'alpha' => '0'),
                            'required' => array( 'opt-header-type', 'equals', 'top' ),
                        ),
                        array(
                            'id'        => 'mobile_menu_icon_color',
                            'type'      => 'color',
                            'title'     => __('Hamburger Menu Color', 'oshin'), 
                            'subtitle'  => __('', 'oshin'),
                            'desc'      => __('', 'oshin'),
                            'default'   => '#323232',
                        ),
                    array(
                        'id'        => 'mobile_menu_width',
                        'type'      => 'text',
                        'title'     => __('Hamburger Menu Width', 'oshin'), 
                        'subtitle'  => __('', 'oshin'),
                        'desc'      => __('', 'oshin'),
                        'default'   => '18',
                    ),  
                    array(
                        'id'        => 'mobile_menu_thickness',
                        'type'      => 'text',
                        'title'     => __('Hamburger Thickness', 'oshin'), 
                        'subtitle'  => __('', 'oshin'),
                        'desc'      => __('', 'oshin'),
                        'default'   => '2',
                    ),  
                    array(
                        'id'        => 'mobile_menu_gap',
                        'type'      => 'text',
                        'title'     => __('Hamburger Gap', 'oshin'), 
                        'subtitle'  => __('', 'oshin'),
                        'desc'      => __('', 'oshin'),
                        'default'   => '5',
                    ),
                )
            );            
            //Color Settings
            $colors_field = array (
                array (
                    'id' => 'sec_bg',
                    'type' => 'color',
                    'title' => __('Secondary Background Color', 'oshin'), 
                    
                    
                    'default' => '#fafbfd'
                ),
                array (
                    'id' => 'sec_color',
                    'type' => 'color',
                    'title' => __('Secondary Text Color', 'oshin'), 
                    
                    
                    'default' => '#7a7a7a'
                ),
                array (
                    'id' => 'sec_border',
                    'type' => 'color',
                    'title' => __('Secondary Border Color', 'oshin'), 
                    
                    
                    'default' => '#eeeeee'
                ),
                array (
                    'id' => 'tert_bg',
                    'type' => 'color',
                    'title' => __('Tertiary Background Color', 'oshin'), 
                    'subtitle' => __('This color will be applied to the content area in Fixed Sidebar Portfolio Pages', 'oshin'),
                    
                    'default' => '#ffffff'
                ), 
            );
            if( !$colorhub_data ) {
                array_unshift( $colors_field, array (
                        'id' => 'color_scheme',
                        'type' => 'color',
                        'title' => __('Color Scheme', 'oshin'), 
                        'default' => '#e0a240'
                    ),   
                    array (
                        'id' => 'alt_bg_text_color',
                        'type' => 'color',
                        'title' => __('Text Color on BG with Color Scheme', 'oshin'), 
                        'default' => '#ffffff'
                    )
                );
            }
            $this->sections[] = array(
                'icon' => 'el-icon-brush',
                'title' => __('Colors', 'oshin'),
                'desc'      => sprintf( __('<a href="%s" target="_blank">Colors Documentation</a>', 'oshin'), 'https://www.brandexponents.com/oshine-knowledgebase/knowledge-base/colour-settings/'),
                
                'fields' => $colors_field
            );
            // Blog Settings
            $get_posts = get_posts( array(
                'posts_per_page' => -1,
                'post_status'    => 'publish',
            ) );
            $post_options = array();
            $latest_post_id = '';
            if($get_posts){
                foreach ( $get_posts as $post ) {
                        $post_options[$post->ID] = html_entity_decode(get_the_title($post->ID));
                        $latest_post_id = $post->ID;
                }
            }
            $this->sections[] = array (
                'icon' => 'el-icon-blogger',
                'title' => __('Blog Settings', 'oshin'),
                'desc'      => sprintf( __('<a href="%s" target="_blank">Blog Settings Documentation</a>', 'oshin'), 'https://www.brandexponents.com/oshine-knowledgebase/knowledge-base/blog-settings/'),
                
                'fields' => array (
                    array (
                        'id' => 'open_to_lightbox',
                        'type' => 'checkbox',
                        'title' => __('Open Thumbnail image in Lighbox', 'oshin'),
                        'subtitle' => __('By default the thumbnail will be linked to the Blog Post page', 'oshin'),
                        
                        'default' => 1
                    ),
                    array (
                        'id' => 'blog_style',
                        'type' => 'select',
                        'title' => __('Blog Style', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'options'=> array (
                                    'style5'=>'Large Thumbnail',
                                    'style1'=>'Large Thumbnail - Date in box', 
                                    'style6'=>'Large Thumbnail - Date above Title',
                                    'style4'=>'Large Thumbnail - Content in Box',
                                    'style7'=>'Large Thumbnail - Category above Title',
                                    'style2'=>'Small Thumbnail', 
                                    'style3'=>'Masonry - Style 1 (Old)', 
                                    'style8'=>'Masonry - Style 2', 
                                    'style10'=>'Single - Masonry',
                                    //'style9'=>'Metro Grid', 
                                ),
                        'default' => 'style6'
                    ),
                    array (
                        'id'        => 'blog-single-post-settings-start',
                        'type'      => 'section',
                        'title'     => 'Blog Single Post Settings',
                        'subtitle'  => '',
                        'indent'    => true, // Indent all options below until the next 'section' option is set.
                        'required' => array('blog_style','equals','style10')
                    ),
                        array (
                            'id' => 'blog_single_post_selected',
                            'type' => 'select',
                            'title'     => __('Select post', 'oshin'),
                            'subtitle'  => __('', 'oshin'),
                            'options'   => $post_options,
                            'default'   => $latest_post_id
                        ),
                        array (
                            'id' => 'blog_single_post_read_more_text',
                            'type' => 'text',
                            'title'     => __('Read more Text', 'oshin'),
                            'subtitle'  => __('', 'oshin'),
                            'default'   => 'Read More',
                        ),
                    array (
                        'id'        => 'blog-single-post-settings-end',
                        'type'      => 'section',
                        'indent'    => false, // Indent all options below until the next 'section' option is set.
                    ),
                    array (
                        'id'        => 'blog-meta-setting-start',
                        'type'      => 'section',
                        'title'     => 'Blog Meta Settings',
                        'subtitle'  => '',
                        'indent'    => true, // Indent all options below until the next 'section' option is set.
                        'required' => array('blog_style','equals','style8')
                    ),
                        array (
                            'id' => 'blog_meta_category',
                            'type' => 'switch',
                            'title'     => __('Show Post Category', 'oshin'),
                            'subtitle'  => __('', 'oshin'),
                            'default'   => true,
                        ),
                        array (
                            'id' => 'blog_meta_date',
                            'type' => 'switch',
                            'title'     => __('Show Post Date', 'oshin'),
                            'subtitle'  => __('', 'oshin'),
                            'default'   => true,
                        ),
                        array (
                            'id' => 'blog_meta_comments_count',
                            'type' => 'switch',
                            'title'     => __('Show Count of Post Comments', 'oshin'),
                            'subtitle'  => __('', 'oshin'),
                            'default'   => true,
                        ),
                        array (
                            'id' => 'blog_meta_author',
                            'type' => 'switch',
                            'title'     => __('Show Post Author', 'oshin'),
                            'subtitle'  => __('', 'oshin'),
                            'default'   => true,
                        ),
                        array (
                            'id' => 'blog_meta_share',
                            'type' => 'switch',
                            'title'     => __('Show Share Icon', 'oshin'),
                            'subtitle'  => __('', 'oshin'),
                            'default'   => true,
                        ),
                    array (
                        'id'        => 'blog-meta-setting-end',
                        'type'      => 'section',
                        'indent'    => false, // Indent all options below until the next 'section' option is set.
                    ),                    
                    array (
                        'id'        => 'blog-masonry-setting-start',
                        'type'      => 'section',
                        'title'     => 'Blog Masonry Style Settings',
                        'subtitle'  => 'Affects only Masonry (Style 1 and 2) Layout',
                        'indent'    => true, // Indent all options below until the next 'section' option is set.
                        'required' => array( 
                            array('blog_style','!=','style1'), 
                            array('blog_style','!=','style2'),
                            array('blog_style','!=','style4'),
                            array('blog_style','!=','style5'),
                            array('blog_style','!=','style6'),
                            array('blog_style','!=','style7'),
                        ),
                    ),
                        array (
                            'id' => 'blog_show_filters',
                            'type' => 'switch',
                            'title' => __('Filterable Post', 'oshin'), 
                            'desc' => __('' , 'oshin'),
                            'default' => true,
                            'required' => array('blog_style','equals','style10')
                        ),
                        array (
                            'id' => 'blog_filters_align',
                            'type' => 'select',
                            'title' => __('Filters Alignment', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'options'=> array('left'=>'Left', 'center'=>'Center', 'right'=>'Right'),
                            'default' => 'align-center',
                            'required' => array('blog_show_filters','equals',true)
                        ),
                        array (
                            'id' => 'blog_filter_bottom_color',
                            'type' => 'color',
                            'title' => __('Bottom border color', 'oshin'), 
                            'desc' => __('' , 'oshin'),
                            'default' => '#33e9b9',
                            'required' => array('blog_show_filters','equals',true)
                        ),
                        array (
                            'id' => 'blog_items_per_page',
                            'type' => 'text',
                            'title' => __('Number of Items Per Load', 'oshin'), 
                            'desc' => __('' , 'oshin'),
                            'default' => '9',
                            'required' => array('blog_style','equals','style10')
                        ),
                        array (
                            'id' => 'blog_image_aspect_ratio',
                            'type' => 'text',
                            'title' => __('Blog Images Aspect Ratio', 'oshin'), 
                            'desc' => __('' , 'oshin'),
                            'default' => '1.60',
                            'required' => array('blog_style','equals','style10')
                        ),
                        array (
                            'id' => 'blog_masonry_enable',
                            'type' => 'switch',
                            'title' => __('Masonry Layout', 'oshin'), 
                            'desc' => __('' , 'oshin'),
                            'default' => false,
                            'required' => array('blog_style','equals','style10')
                        ),
                        array (
                            'id' => 'blog_cat_hide',
                            'type' => 'switch',
                            'title' => __('Hide Categories', 'oshin'), 
                            'desc' => __('' , 'oshin'),
                            'default' => false,
                            'required' => array('blog_style','equals','style10')
                        ),
                        array (
                            'id' => 'blog_column',
                            'type' => 'select',
                            'title' => __('Blog Column', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'options'=> array('two-col'=>'Two Column', 'three-col'=>'Three Column', 'four-col'=>'Four Column'),
                            'default' => 'three-col'
                        ),  
                        array (
                            'id' => 'blog_grid_style',
                            'type' => 'select',
                            'title' => __('Blog Grid Style', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'options'=> array('wrapped'=>'Wrapped', 'full'=>'Full Width'),
                            'default' => 'wrapped'
                        ),
                        array (
                            'id' => 'blog_gutter_style',
                            'type' => 'select',
                            'title' => __('Blog Gutter Style', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'options'=> array('style1'=>'With Margin on Edges', 'style2'=>'No Margin on edges'),
                            'default' => 'style1'
                        ),
                        array (
                            'id' => 'blog_pagination_style',
                            'type' => 'select',
                            'title' => __('Blog Pagination Style', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'options'=> array('normal'=>'Normal', 'loadmore'=>'Load More', 'infinite' => 'Infinite Scroll'),
                            'default' => 'normal'
                        ),
                        array (
                            'id' => 'blog_gutter_width',
                            'type' => 'text',
                            'title' => __('Blog Gutter Width', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => 40
                        ),
                        // array (
                        //     'id' => 'blog_aspect_ratio',
                        //     'type' => 'text',
                        //     'title' => __('Blog Aspect Ratio', 'oshin'), 
                            
                        //     'desc' => __('' , 'oshin'),
                        //     'default' => 1
                        // ),
                        array (
                            'id'        => 'masonry_bg',
                            'type'      => 'color',
                            'title'     => __('Background Color', 'oshin'), 
                            'subtitle'  => __('', 'oshin'),
                            'desc'      => __('', 'oshin'),
                            'default'   =>  '#ffffff',
                            'required' => array('blog_style', 'equals', 'style8' ),
                        ), 
                    array (
                        'id'        => 'blog-masonry-setting-end',
                        'type'      => 'section',
                        'indent'    => false, // Indent all options below until the next 'section' option is set.
                    ),
                    array (
                        'id' => 'blog_page_show_page_title_module',
                        'type' => 'checkbox',
                        'title' => __('Show Page Title Bar in Blog Page', 'oshin'),
                        'default' => 1,
                    ),
                    array (
                        'id' => 'blog_sidebar',
                        'type' => 'select',
                        'title' => __('Blog Sidebar Position', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'options'=> array('left'=>'Left Sidebar', 'right'=>'Right Sidebar', 'no'=>'No Sidebar'),
                        'default' => 'right'
                    ),
                    array (
                        'id' => 'blog_read_more_style',
                        'type' => 'select',
                        'title' => __('Blog Read More Button Style', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'options'=> array('style1' => 'Text Underline', 'style2'=>'Border', 'style3'=>'Block'),
                        'default' => 'style1',
                        'required' => array( 
                            array('blog_style','!=','style2'),
                            array('blog_style','!=','style8') 
                        )
                    ),                    
                    array (
                        'id'        => 'single-post-setting-start',
                        'type'      => 'section',
                        'title'     => 'Blog Single Post Settings',
                        'subtitle'  => '',
                        'indent'    => true, // Indent all options below until the next 'section' option is set.
                    ),
                        // array (
                        //     'id' => 'enable_pb_blog_posts',
                        //     'type' => 'checkbox',
                        //     'title' => __('Enable BE Page Builder in Single Posts', 'oshin'),
                            
                            
                        //     'default' => 0,
                        // ),
                        array (
                            'id' => 'blog_single_sidebar',
                            'type' => 'checkbox',
                            'title' => __('Enable Sidebar in Single Posts', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => '1'
                        ),
                        array (
                            'id' => 'enable_breadcrumb',
                            'type' => 'checkbox',
                            'title' => __('Enable Breadcrumb in Single Posts', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => 0
                        ),
                        array (
                            'id'            => 'single_blog_style',
                            'type'          => 'switch',
                            'title'         =>  __( 'Enable Hero Featured Image in Single Posts', 'oshin' ),
                            'desc'          => __( '', 'oshin' ),
                            'default'       => false
                        ),
                        array (
                            'id'    => 'blog_masonry_hero_height',
                            'type'  => 'text',
                            'title' => __( 'Single Post Featured Image Height', 'oshin' ),
                            'subtitle'  => __( 'Leave this blank for a full screen featured image', 'oshin' ),
                            'default'   => '',
                            'required'  => array ( 'single_blog_style', 'equals', true )
                        ),
                        array (
                            'id'        => 'single_wide_header_transparent',
                            'type'      => 'select',
                            'title'     => __( 'Header Background Style', 'oshin' ),
                            'desc'      => __( '', 'oshin' ),
                            'options'   => array (
                                    'none' => 'Default',
                                    'transparent' => 'Transparent',
                                    'semitransparent' => 'Semi Transparent' 
                            ),
                            'default'   => 'none',
                            'required'  => array ( 'single_blog_style', 'equals', true )
                        ),
                        array (
                            'id'        => 'single_wide_navigation_color_scheme',
                            'type'      => 'select',
                            'title'     => __( 'Header Navigation Color Scheme', 'oshin' ),
                            'desc'      => __( '', 'oshin' ),
                            'options'      => array (
                                    'light'    => 'Light',
                                    'dark'    => 'Dark'
                            ),
                            'default'   => 'light',
                            'required'  => array ( 'single_blog_style', 'equals', true )
                        ),  
                        array (
                            'id' => 'show_related_posts',
                            'type' => 'switch',
                            'title' => __('More Posts Section', 'oshin'), 
                            'desc' => __('' , 'oshin'),
                            'default' => false,
                            'required' => array('blog_style','equals','style10')
                        ),
                        array (
                            'id' => 'related_posts_section_title',
                            'type' => 'text',
                            'title' => __('More Posts Section title', 'oshin'), 
                            'desc' => __('' , 'oshin'),
                            'default' => 'Industry Insights',
                            'required' => array('show_related_posts','equals',true)
                        ),
                    array (
                        'id'        => 'single-post-setting-end',
                        'type'      => 'section',
                        'indent'    => false, // Indent all options below until the next 'section' option is set.
                    ),
                    array (
                        'id'        => 'blog-share-setting-start',
                        'type'      => 'section',
                        'title'     => 'Blog Post Share Settings',
                        'subtitle'  => '',
                        'indent'    => true, // Indent all options below until the next 'section' option is set.
                        'required' => array('blog_style','equals','style10')
                    ),
                        array (
                            'id' => 'blog_show_share_icons',
                            'type' => 'switch',
                            'title'     => __('Show Share Icons', 'oshin'),
                            'subtitle'  => __('', 'oshin'),
                            'default'   => true,
                            'required' => array('blog_style','equals','style10')
                        ),
                        array (
                            'id' => 'blog_show_share_icon_facebook',
                            'type' => 'switch',
                            'title'     => __('Facebook', 'oshin'),
                            'subtitle'  => __('', 'oshin'),
                            'default'   => true,
                            'required' => array('blog_show_share_icons','equals',true)
                        ),
                        array (
                            'id' => 'blog_show_share_icon_twitter',
                            'type' => 'switch',
                            'title'     => __('Twitter', 'oshin'),
                            'subtitle'  => __('', 'oshin'),
                            'default'   => true,
                            'required' => array('blog_show_share_icons','equals',true)
                        ),
                        /*array (
                            'id' => 'blog_show_share_icon_google_plus',
                            'type' => 'switch',
                            'title'     => __('Google+', 'oshin'),
                            'subtitle'  => __('', 'oshin'),
                            'default'   => true,
                            'required' => array('blog_show_share_icons','equals',true)
                        ),*/
                        array (
                            'id' => 'blog_show_share_icon_linkedin',
                            'type' => 'switch',
                            'title'     => __('Linkedin', 'oshin'),
                            'subtitle'  => __('', 'oshin'),
                            'default'   => true,
                            'required' => array('blog_show_share_icons','equals',true)
                        ),
                        array (
                            'id' => 'blog_show_share_icon_pinterest',
                            'type' => 'switch',
                            'title'     => __('Pinterest', 'oshin'),
                            'subtitle'  => __('', 'oshin'),
                            'default'   => true,
                            'required' => array('blog_show_share_icons','equals',true)
                        ),
                    array (
                        'id'        => 'blog-share-setting-end',
                        'type'      => 'section',
                        'indent'    => false, // Indent all options below until the next 'section' option is set.
                    ),
                )                   
            );
            // Portfolio Settings    
            $this->sections[] = array (
                'icon' => 'el-icon-film',
                'title' => __('Portfolio Settings', 'oshin'),
                'desc'      => sprintf( __('<a href="%s" target="_blank">Portfolio Settings Documentation</a>', 'oshin'), 'https://www.brandexponents.com/oshine-knowledgebase/knowledge-base/portfolio-settings/'),
                
                'fields' => array (  
                    array (
                        'id' => 'portfolio_aspect_ratio',
                        'type' => 'text',
                        'title' => __('Portfolio Images Aspect Ratio', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'default' => '1.6',
                    ),
                    array (
                        'id' => 'portfolio_slug',
                        'type' => 'text',
                        'title' => __('Portfolio Post Slug', 'oshin'), 
                        'subtitle' => __('This option is to modify the slug of the portfolio post items. Default will be /portfolio/', 'oshin'),
                        'desc' => __('' , 'oshin'),
                        'default' => '',
                    ),

                    array (
                        'id' => 'portfolio_home_page',
                        'type' => 'text',
                        'title' => __('Portfolio Home Page', 'oshin'), 
                        'subtitle' => __('The grid icons in the single portfolio page will be linked to this URL.', 'oshin'),
                        'desc' => __('' , 'oshin'),
                        'default' => get_home_url(),
                    ),
                    array (
                        'id' => 'portfolio_visit_site_style',
                        'type' => 'select',
                        'title' => __('Portfolio View Project Button Style', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'options'=> array('style1' => 'Text Underline', 'style2'=>'Border', 'style3'=>'Block', 'style4' => 'Tail'),
                        'default' => 'style1'
                    ),
                )                   
            );
            // Single Portfolio Settings
            $this->sections[] = array(
                'title' => __('Single Portfolio Settings', 'oshin'),
                'desc'      => __('Settings applicable on Portfolio Style including - Single Page Builder, Folating Sidebar and Fixed Sidebar types', 'oshin'),
                'subsection' => true,
                'fields' => array(
                    array(
                        'id'        => 'portfolio-nav-top-start',
                        'type'      => 'section',
                        'title'     => 'Portfolio Title Bar',
                        // 'subtitle'  => 'The settings will be applied on the Portfolio Styles with Portfolio Title and Navigation in Top bar',
                        'indent'    => true, // Indent all options below until the next 'section' option is set.
                    ),
                        array (
                            'id' => 'portfolio_title_nav_color',
                            'type' => 'color',
                            'title' => __('Background Color', 'oshin'), 
                            'desc' => __('' , 'oshin'),
                            'default' => '#ededed'
                        ), 
                        array (
                            'id' => 'portfolio_nav_color',
                            'type' => 'color',
                            'title' => __('Navigation Icons color', 'oshin'), 
                            'default' => '#d2d2d2'
                        ),  
                        array (
                            'id' => 'portfolio_nav_hover_color',
                            'type' => 'color',
                            'title' => __('Navigation Icons Hover color', 'oshin'), 
                            
                            
                            'default' => '#000000'
                        ), 
                        array (
                            'id'        => 'portfolio_title_bar_padding',
                            'type'      => 'text',
                            'title'     => __('Padding', 'oshin'),
                            'subtitle'  => __('Enter only Numbers (in pixels)', 'oshin'),
                            'default'   =>  '15'
                        ),
                        array(
                            'id'        => 'portfolio_title_bar_border',
                            'type'      => 'border',
                            'title'     => __('Bottom Border Color', 'oshin'),
                            'subtitle'  => __('','oshin'),
                            'default'   => array(
                                'border-color'  => '#e8e8e8', 
                                'border-style'  => 'solid', 
                                'bottom'    => '1px', 
                            ),
                            'top'       => false,
                            'left'      => false,
                            'right'     => false,
                            'all'       => false
                        ),
                        array (
                            'id' => 'portfolio_title_nav_style',
                            'type' => 'select',
                            'title' => __('Bar Style', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'options'=> array('style1' => 'Center Title - Right (Wrap) Navigation', 'style2'=>'Center Title - Right (Edge) Navigation', 'style3'=>'Left Title - Right (Wrap) Navigation'),
                            'default' => 'style1'
                        ),
                    array(
                        'id'        => 'portfolio-nav-top-end',
                        'type'      => 'section',
                        'indent'    => false, // Indent all options below until the next 'section' option is set.
                    ),
                    // Portfolio Navigation
                    array(
                        'id'        => 'portfolio-nav-bar-start',
                        'type'      => 'section',
                        'title'     => 'Portfolio Navigation Bar',
                        // 'subtitle'  => 'The settings will be applied on the Portfolio Styles with Portfolio Title and Navigation in Top bar',
                        'indent'    => true, // Indent all options below until the next 'section' option is set.
                    ),
                        array(
                            'id' => 'portfolio_nav_bottom',
                            'type' => 'switch',
                            'title'     => __('Enable Portfolio Naviagtion in all items ?', 'oshin'),
                            'subtitle'  => __('Turn this on if you want portfolio navigation for all single portfolio pages, excluding Slider Type Portfolios', 'oshin'),
                            'default'   => false,
                        ),
                        array(
                            'id' => 'portfolio_nav_bottom_wrap',
                            'type' => 'switch',
                            'title'     => __('Wrap', 'oshin'),
                            'subtitle'  => __('Turn this off if you want a Full Screen Width Navigation', 'oshin'),
                            'default'   => false,
                            'required' => array('portfolio_nav_bottom','equals',true)
                        ),
                        array(
                            'id' => 'portfolio_nav_bottom_height',
                            'type' => 'text',
                            'title'     => __('Height', 'oshin'),
                            'default'   => 100,
                            'validate' => 'numeric',
                            'required' => array('portfolio_nav_bottom','equals',true)
                        ),
                        array(
                            'id' => 'portfolio_nav_bottom_grid',
                            'type' => 'switch',
                            'title'     => __('Show Grid Icon', 'oshin'),
                            'subtitle'  => __('Turn this on if you want a navigation grid', 'oshin'),
                            'default'   => true,
                            'required' => array('portfolio_nav_bottom','equals',true)
                        ),
                        array(
                            'id' => 'portfolio_nav_bottom_grid_icon',
                            'type' => 'select_image',
                            'title' => __('Grid Icon Style', 'oshin'),
                            'tiles' => true,
                            'options' => $portfolio_grid_styles,
                            'default' => get_template_directory_uri().'/img/portfolio-navigation-grid/six-filled.png',
                            'required' => array('portfolio_nav_bottom_grid','equals',true)
                        ),
                        array (
                            'id'        => 'portfolio_nav_bottom_icon_color',
                            'type'      => 'color',
                            'title'     => __('Icon Color', 'oshin'),
                            'default'   => '#1a1a1a',
                            'required' => array('portfolio_nav_bottom_grid','equals',true)
                        ),
                        array (
                            'id' => 'portfolio_nav_bottom_icon_hover_color',
                            'type' => 'color',
                            'title' => __('Icon Hover color', 'oshin'),    
                            'default' => '#000000',
                            'required' => array('portfolio_nav_bottom_grid','equals',true)
                        ), 
                        array (
                            'id'        => 'portfolio_nav_bottom_bg_color',
                            'type'      => 'color',
                            'title'     => __('Background Color', 'oshin'),
                            'default'   => '#1a1a1a',
                            'required' => array('portfolio_nav_bottom','equals',true)
                        ),
                        array (
                            'id' => 'portfolio_nav_bottom_bg_hover_color',
                            'type' => 'color',
                            'title' => __('Background Hover color', 'oshin'),    
                            'default' => '#000000',
                            'required' => array('portfolio_nav_bottom','equals',true)
                        ), 
                        array (
                            'id'        => 'portfolio_nav_bottom_text_color',
                            'type'      => 'color',
                            'title'     => __('Navigation Text Color', 'oshin'),
                            'default'   => '#1a1a1a',
                            'required' => array('portfolio_nav_bottom','equals',true)
                        ),
                        array (
                            'id' => 'portfolio_nav_bottom_text_hover_color',
                            'type' => 'color',
                            'title' => __('Navigation Text Hover color', 'oshin'),    
                            'default' => '#000000',
                            'required' => array('portfolio_nav_bottom','equals',true)
                        ), 
                        array(
                            'id' => 'portfolio_nav_bottom_thumbnail',
                            'type' => 'switch',
                            'title'     => __('Show Featured Image', 'oshin'),
                            'subtitle'  => __('Turn this on if you want Featured Images to be visible', 'oshin'),
                            'default'   => false,
                            'required' => array('portfolio_nav_bottom','equals',true)
                        ),
                        array (
                            'id' => 'portfolio_nav_bottom_featured_image_overlay_color',
                            'type' => 'color_rgba',
                            'title' => __('Featured image overlay color', 'oshin'),    
                            'default' => array('color' => '#000000', 'alpha' => '0.4'),
                            'required' => array('portfolio_nav_bottom_thumbnail','equals',true)
                        ),
                        array(
                            'id'    => 'portfolio_nav_bottom_featured_image_overlay_hover_color',
                            'type' => 'color_rgba',
                            'title' => __('Featured image overlay hover color', 'oshin'),    
                            'default' => array('color' => '#000000', 'alpha' => '0.4'),
                            'required' => array('portfolio_nav_bottom_thumbnail','equals',true)
                        ),
                        array(
                            'id'        => 'portfolio_nav_bottom_border',
                            'type'      => 'border',
                            'title'     => __('Border', 'oshin'),
                            'subtitle'  => __('','oshin'),
                            'default'   => array(
                                'border-color'  => '', 
                                'border-style'  => 'none', 
                                'border-width'    => '0px', 
                            ),
                            'all'       => true,
                            'required' => array('portfolio_nav_bottom','equals',true)
                        ),
                    array(
                        'id'        => 'portfolio-nav-bar-end',
                        'type'      => 'section',
                        'indent'    => false, // Indent all options below until the next 'section' option is set.
                    ),
                )
            );
            // Single Slider Portfolio Settings
            $this->sections[] = array(
                'title' => __('Slider Type Single Portfolio Settings', 'oshin'),
                'desc'  => __('Settings applicable on Portfolio Style including - Sliders and Carousels', 'oshin'),
                'subsection' => true,
                'fields' => array(
                    array(
                        'id'        => 'portfolio-nav-bottom-start',
                        'type'      => 'section',
                        'title'     => 'Portfolio Title Bar',
                        'subtitle'  => 'The settings will be applied on the Portfolio Styles with Portfolio Title and Navigation in the bottom. This includes all the Slider styles',
                        'indent'    => true, // Indent all options below until the next 'section' option is set.
                    ),
                        array (
                            'id' => 'portfolio_title_nav_bg',
                            'type' => 'color_rgba',
                            'title' => __('Background Color', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default'   =>  array('color' => '#ffffff', 'alpha' => '0'),
                        ),
                        array (
                            'id' => 'portfolio_title_nav_text_color',
                            'type' => 'color',
                            'title' => __('Text Color', 'oshin'), 
                            'desc' => __('' , 'oshin'),
                            'default' => '#2b2b2b'
                        ),
                        array (
                            'id' => 'portfolio_title_nav_hover_bg_color',
                            'type' => 'color_rgba',
                            'title' => __('Hover Background Color', 'oshin'), 
                            'desc' => __('' , 'oshin'),
                            'default'   =>  array('color' => '#eb4949', 'alpha' => '0.85'),
                        ),
                        array (
                            'id' => 'portfolio_title_nav_text_hover_color',
                            'type' => 'color',
                            'title' => __('Text Hover Color', 'oshin'), 
                            'desc' => __('' , 'oshin'),
                            'default' => '#ffffff'
                        ),
                        
                        array (
                            'id' => 'portfolio_caption_bg',
                            'type' => 'color_rgba',
                            'title' => __('Caption Background Color', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default'   =>  array('color' => '#000000', 'alpha' => '1'),
                        ),
                        array (
                            'id' => 'thumbnail_bar_color',
                            'type' => 'color_rgba',
                            'title' => __('Thumbnail Background Color', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default'   =>  array('color' => '#ffffff', 'alpha' => '0.5'),
                        ),
                    array(
                        'id'        => 'portfolio-nav-bottom-end',
                        'type'      => 'section',
                        'indent'    => false, // Indent all options below until the next 'section' option is set.
                    ),
                    array (
                        'id'        => 'navigation-settings-start',
                        'type'      => 'section',
                        'title'     => 'Slider Arrow Settings',
                        'indent'    => true, // Indent all options below until the next 'section' option is set.
                    ),   
                        array (
                            'id' => 'slider_navigation_style',
                            'type' => 'select',
                            'title' => __('Navigation Arrow Style', 'oshin'),
                            
                            
                            'options'=> array(
                                    'style1-arrow'=>'Large Sqaure Block', 
                                    'style2-arrow'=>'Large Sqaure Border',
                                    'style3-arrow'=>'Small Sqaure Block',
                                    'style4-arrow'=>'Small Sqaure Border',
                                    'style5-arrow'=>'Circle Block',
                                    'style6-arrow'=>'Circle Border',
                            ),
                            'default' => 'style1-arrow'
                        ),
                        array(
                            'id'        => 'slider_nav_bg',
                            'type'      => 'color_rgba',
                            'title'     => __('Background/Border Color', 'oshin'), 
                            'subtitle'  => __('The color will be applied as the BG or border of the slider arrow , depending on the style choosen', 'oshin'),
                            'desc'      => __('', 'oshin'),
                            'default'   =>  array('color' => '#000000', 'alpha' => '1'),
                        ), 
                        array(
                            'id'        => 'slider_nav_hover_bg',
                            'type'      => 'color_rgba',
                            'title'     => __('Background/Border Hover Color', 'oshin'), 
                            'subtitle'  => __('', 'oshin'),
                            'desc'      => __('', 'oshin'),
                            'default'   =>  array('color' => '#000000', 'alpha' => '1'),
                        ),  
                        array(
                            'id'        => 'slider_nav_color',
                            'type'      => 'color',
                            'title'     => __('Arrow Color', 'oshin'), 
                            'subtitle'  => __('', 'oshin'),
                            'desc'      => __('', 'oshin'),
                            'default'   =>  '#ffffff'
                        ),
                        array(
                            'id'        => 'slider_nav_hover_color',
                            'type'      => 'color',
                            'title'     => __('Arrow Hover Color', 'oshin'), 
                            'subtitle'  => __('', 'oshin'),
                            'desc'      => __('', 'oshin'),
                            'default'   =>  '#ffffff'
                        ),
                    array(
                        'id'        => 'navigation-settings-end',
                        'type'      => 'section',
                        'indent'    => false, // Indent all options below until the next 'section' option is set.
                    ),
                )
            );
            // Portfolio Filter Settings
            $this->sections[] = array(
                'title' => __('Portfolio Filter Settings', 'oshin'),
                'desc'  => __('', 'oshin'),
                'subsection' => true,
                'fields' => array(
                    array(
                        'id'        => 'portfolio-filter-settings-start',
                        'type'      => 'section',
                        'title'     => 'Portfolio Filter Settings',
                        'subtitle'  => '',
                        'indent'    => true, // Indent all options below until the next 'section' option is set.
                    ),
                        array (
                            'id' => 'portfolio_filter_style',
                            'type' => 'image_select',
                            'title' => __('Portfolio Filter Style', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'options'  => array(
                                'border'      => array(
                                    'alt'   => 'Border', 
                                    'img'   => get_template_directory_uri().'/img/filters/border.png'
                                ),
                                'rounded'      => array(
                                    'alt'   => 'Rounded', 
                                    'img'   => get_template_directory_uri().'/img/filters/rounded.png'
                                ),
                                'single_border'      => array(
                                    'alt'   => 'One Side Border', 
                                    'img'  => get_template_directory_uri().'/img/filters/single_border.png'
                                )
                            ),
                            'default' => 'border'
                        ),
                        array (
                            'id' => 'portfolio_filter_alignment',
                            'type' => 'select',
                            'title' => __('Portfolio Filter Alignment', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'options'=> array('left' => 'Left', 'center'=>'Center'),
                            'default' => 'center'
                         ),
                    array(
                        'id'        => 'portfolio-filter-settings-end',
                        'type'      => 'section',
                        'indent'    => false, // Indent all options below until the next 'section' option is set.
                    ),
                )
            );
            // Portfolio Taxonomy Settings
            $this->sections[] = array(
                'title' => __('Portfolio Taxonomy Settings', 'oshin'),
                'desc'  => __('', 'oshin'),
                'subsection' => true,
                'fields' => array(
                                        array(
                        'id'        => 'portfolio-taxonomy-settings-start',
                        'type'      => 'section',
                        'title'     => 'Portfolio Taxonomy Page Settings',
                        'subtitle'  => 'The settings will be applied on the Portfolio Category and Tag Archive Pages',
                        'indent'    => true, // Indent all options below until the next 'section' option is set.
                    ),
                        // array (
                        //     'id' => 'portfolio_style',
                        //     'type' => 'select',
                        //     'title' => __('Page Style', 'oshin'), 
                        //     
                        //     'desc' => __('' , 'oshin'),
                        //     'options'=> array('portfolio_full_screen'=>'Full Screen Portfolio', 'portfolio_full_screen_with_gutter'=>'Full Screen With Gutter', 'portfolio'=>'Normal Portfolio'),
                        //     'default' => 'portfolio'
                        // ),
                        array (
                            'id' => 'hide_breadcrumbs',
                            'type' => 'checkbox',
                            'title' => __('Disable Title and Breadcrumbs Bar in Taxonomy Page', 'oshin'),
                            
                            
                            'default' => 0
                        ),
                        array (
                            'id' => 'portfolio_grid_style',
                            'type' => 'select',
                            'title' => __('Portfolio Grid Style', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'options'=> array('wrapped'=>'Wrapped', 'full'=>'Full Width'),
                            'default' => 'wrapped'
                        ),
                        array (
                            'id' => 'portfolio_col',
                            'type' => 'select',
                            'title' => __('Number of Columns', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'options'=> array('two'=>'Two Column', 'three'=>'Three Column', 'four'=>'Four Column', 'five'=>'Five Column'),
                            'default' => 'three'
                        ),  
                        array (
                            'id' => 'portfolio_grid_gutter',
                            'type' => 'text',
                            'title' => __('Portfolio Gutter Width', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => '30'
                        ),                  
                        array (
                            'id' => 'portfolio_hover',
                            'type' => 'color_rgba',
                            'title' => __('Grid hover Color', 'oshin'), 
                            
                            
                            'default' => array('color' => '#e0a240', 'alpha' => '0.85') ,    
                        ),
                    array(
                        'id'        => 'portfolio-taxonomy-settings-end',
                        'type'      => 'section',
                        'indent'    => false, // Indent all options below until the next 'section' option is set.
                    ),
                )
            );
            // Shop Settings
            $this ->sections[] = array (
                'icon' => 'el-icon-shopping-cart',
                'title' => __('Shop', 'oshin'),
                'desc'      => sprintf( __('<a href="%s" target="_blank">Shop Settings Documentation</a>', 'oshin'), 'https://www.brandexponents.com/oshine-knowledgebase/knowledge-base/shop-settings/'),
                
                'fields' => array (
                    array (
                        'id' => 'shop_products_column',
                        'type' => 'select',
                        'title' => __('Shop Page Column', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'options'=> array('four'=>'Four', 'three'=>'Three'),
                        'default' => 'three'
                    ),
                    array (
                        'id' => 'show_sidebar_on_shop_page',
                        'type' => 'checkbox',
                        'title' => __('Enable Sidebar in Shop Page', 'oshin'),
                        
                        
                        'default' => 0
                    ),
                    array (
                        'id' => 'number_of_products_per_page',
                        'type' => 'text',
                        'title' => __('Number of products per page', 'oshin'),
                        
                        
                        'default' => 9
                    ),
                    array (
                        'id' => 'sigle_page_woo_tabs_position',
                        'type' => 'select',
                        'title' => __('Single Page Tabs Position', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'options'=> array('right_side'=>'Beside Product Image', 'full_width'=>'Below Product Image'),
                        'default' => 'right_side'
                    ),
                    array(
                        'id'        => 'shop_page_button_section_start',
                        'type'      => 'section',
                        'title'     => __('Shop Page Primary Button Styling', 'oshin'), 
                        'indent'    => true
                    ),
                        array (
                            'id' => 'shop_page_button_bg_color',
                            'type' => 'color',
                            'title' => __('Background', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => 'transparent',
                        ),
                        array (
                            'id' => 'shop_page_button_color',
                            'type' => 'color',
                            'title' => __('Text', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => '#000000'
                        ),
                        array (
                            'id' => 'shop_page_button_border_color',
                            'type' => 'color',
                            'title' => __('Border', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => '#000000'
                        ),
                        array (
                            'id' => 'shop_page_button_hover_bg_color',
                            'type' => 'color',
                            'title' => __('Hover Background', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => '#e0a240'
                        ),
                        array (
                            'id' => 'shop_page_button_hover_color',
                            'type' => 'color',
                            'title' => __('Hover Text', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => '#ffffff'
                        ),
                        array (
                            'id' => 'shop_page_button_border_hover_color',
                            'type' => 'color',
                            'title' => __('Hover Border', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => '#e0a240'
                        ),
                        array (
                            'id' => 'shop_page_button_border_width',
                            'type' => 'text',
                            'title' => __('Border Width', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => '2'
                        ),
                    array(
                        'id'        => 'shop_page_button_section_end',
                        'type'      => 'section',
                        'indent'    => false
                    ),
                    array(
                        'id'        => 'shop_page_alt_button_section_start',
                        'type'      => 'section',
                        'title'     => __('Shop Page Secondary Button Styling', 'oshin'), 
                        'indent'    => true
                    ),
                        array (
                            'id' => 'shop_page_alt_button_bg_color',
                            'type' => 'color',
                            'title' => __('Background', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => '#e0a240',
                        ),
                        array (
                            'id' => 'shop_page_alt_button_color',
                            'type' => 'color',
                            'title' => __('Text', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => '#fff'
                        ),
                        array (
                            'id' => 'shop_page_alt_button_border_color',
                            'type' => 'color',
                            'title' => __('Border', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => '#e0a240'
                        ),
                        array (
                            'id' => 'shop_page_alt_button_hover_bg_color',
                            'type' => 'color',
                            'title' => __('Hover Background', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => 'transparent'
                        ),
                        array (
                            'id' => 'shop_page_alt_button_hover_color',
                            'type' => 'color',
                            'title' => __('Hover Text', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => '#000'
                        ),
                        array (
                            'id' => 'shop_page_alt_button_border_hover_color',
                            'type' => 'color',
                            'title' => __('Hover Border', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => '#000'
                        ),
                        array (
                            'id' => 'shop_page_alt_button_border_width',
                            'type' => 'text',
                            'title' => __('Border Width', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => '2'
                        ),
                    array(
                        'id'        => 'shop_page_alt_button_section_end',
                        'type'      => 'section',
                        'indent'    => false
                    )
                )
            );
            //Contact Settings
            $this->sections[] = array(
                'icon' => 'el-icon-envelope',
                'title' => __('Contact Settings', 'oshin'),
                'desc'      => sprintf( __('Contact information that will be used in the Contact form <a href="%s" target="_blank">Contact Settings Documentation</a>', 'oshin'), 'https://www.brandexponents.com/oshine-knowledgebase/knowledge-base/contact-settings/'),
                'fields' => array (
                    array (
                        'id' => 'mail_id',
                        'type' => 'text',
                        'title' => __('Email Address', 'oshin'),
                        
                        'subtitle' => __('Enter your email address.', 'oshin'),
                        // 'validate' => 'email',
                        'default' => ''
                    ),
                )
            );

            // $this->sections[] = array(
            //     'title' => __('Advanced Settings', 'oshin'),
                
            //     'icon' => 'el el-cogs',
            // ); 
            // Be Wrap Width
            // $this->sections[] = array(
            //     'icon' => '',
            //     'title' => __('Width Setting', 'oshin'),
            //     'desc' => __('Wrapper Width', 'oshin'),
            //     'subsection' => true,
            //     'fields' => array (
            //         array (
            //             'id' => 'main_wrap_width',
            //             'type' => 'text',
            //             'title' => __('Large Desktop', 'oshin'),
            //             'subtitle' => __('', 'oshin'),
            //             'default' => '1160'
            //         ),
            //         array (
            //             'id' => 'main_wrap_width_laptop',
            //             'type' => 'text',
            //             'title' => __('Laptop', 'oshin'),
            //             'subtitle' => __('1280-1440px', 'oshin'),
            //             'default' => '980'
            //         ),
            //         array (
            //             'id' => 'main_wrap_width_laptop_small',
            //             'type' => 'text',
            //             'title' => __('Small Laptop', 'oshin'),
            //             'subtitle' => __('960-1279px', 'oshin'),
            //             'default' => '940'
            //         ),
            //         array (
            //             'id' => 'main_wrap_width_tablet',
            //             'type' => 'text',
            //             'title' => __('Tablet', 'oshin'),
            //             'subtitle' => __('768-959px', 'oshin'),
            //             'default' => '740'
            //         ),
            //         array (
            //             'id' => 'main_wrap_width_landscape',
            //             'type' => 'text',
            //             'title' => __('Mobile Landscape', 'oshin'),
            //             'subtitle' => __('', 'oshin'),
            //             'default' => '440'
            //         ),
            //         array (
            //             'id' => 'main_wrap_width_portrait',
            //             'type' => 'text',
            //             'title' => __('Mobile Portrait', 'oshin'),
            //             'subtitle' => __('', 'oshin'),
            //             'default' => '300'
            //         ),
            //     )
            // );
            // Margin
            // $this->sections[] = array(
            //     'icon' => '',
            //     'title' => __('Margin Setting', 'oshin'),
            //     'desc' => __('', 'oshin'),
            //     'subsection' => true,
            //     'fields' => array (
            //         array (
            //             'id' => 'h1_bottom_margin',
            //             'type' => 'text',
            //             'title' => __('H1 Bottom Margin', 'oshin'),
            //             'subtitle' => __('In Pixels', 'oshin'),
            //             'default' => '20'
            //         ),
            //         array (
            //             'id' => 'h2_bottom_margin',
            //             'type' => 'text',
            //             'title' => __('H2 Bottom Margin', 'oshin'),
            //             'subtitle' => __('In Pixels', 'oshin'),
            //             'default' => '20'
            //         ),
            //         array (
            //             'id' => 'h3_bottom_margin',
            //             'type' => 'text',
            //             'title' => __('H3 Tag Bottom Margin', 'oshin'),
            //             'subtitle' => __('In Pixels', 'oshin'),
            //             'default' => '15'
            //         ),
            //         array (
            //             'id' => 'h4_bottom_margin',
            //             'type' => 'text',
            //             'title' => __('H4 Tag Bottom Margin', 'oshin'),
            //             'subtitle' => __('In Pixels', 'oshin'),
            //             'default' => '15'
            //         ),
            //         array (
            //             'id' => 'h5_bottom_margin',
            //             'type' => 'text',
            //             'title' => __('H5 Tag Bottom Margin', 'oshin'),
            //             'subtitle' => __('In Pixels', 'oshin'),
            //             'default' => '15'
            //         ),
            //         array (
            //             'id' => 'h6_bottom_margin',
            //             'type' => 'text',
            //             'title' => __('H6 Tag Bottom Margin', 'oshin'),
            //             'subtitle' => __('In Pixels', 'oshin'),
            //             'default' => '10'
            //         ),
            //         array (
            //             'id' => 'p_bottom_margin',
            //             'type' => 'text',
            //             'title' => __('Paragraph Tag Bottom Margin', 'oshin'),
            //             'subtitle' => __('In Pixels', 'oshin'),
            //             'default' => '30'
            //         ),
            //     )
            // );
            // Padding
            // $this->sections[] = array(
            //     'icon' => '',
            //     'title' => __('Padding Setting', 'oshin'),
            //     'desc' => __('', 'oshin'),
            //     'subsection' => true,
            //     'fields' => array (
            //         array(
            //             'id' => 'enable_custom_button_sizes',
            //             'type' => 'switch',
            //             'title'     => __('Enable Custom Button Sizes', 'oshin'),
            //             'subtitle'  => __('Turn this on if you want to configure button sizes', 'oshin'),
            //             'default'   => false,
            //         ),
            //         array(
            //             'id'        => 'button_size_start',
            //             'type'      => 'section',
            //             'title'     => 'Button Padding Values',
            //             'indent'    => true, // Indent all options below until the next 'section' option is set.
            //             'required' => array('enable_custom_button_sizes','equals',true)
            //         ),
            //             array(
            //                 'id'             => 'small_button_padding',
            //                 'type'           => 'spacing',
            //                 'mode'           => 'padding',
            //                 'units'          => 'px',
            //                 'units_extended' => 'false',
            //                 'title'          => __('Small Button Padding', 'oshin'),
            //                 'subtitle'       => __('', 'oshin'),
            //                 'desc'           => __('', 'oshin'),
            //                 'default'            => array(
            //                     'padding-top'     => '12px', 
            //                     'padding-right'   => '15px', 
            //                     'padding-bottom'  => '12px', 
            //                     'padding-left'    => '15px',
            //                 ),
            //                 'required' => array('enable_custom_button_sizes','equals',true)
            //             ),
            //             array(
            //                 'id'             => 'medium_button_padding',
            //                 'type'           => 'spacing',
            //                 'mode'           => 'padding',
            //                 'units'          => 'px',
            //                 'units_extended' => 'false',
            //                 'title'          => __('Medium Button Padding', 'oshin'),
            //                 'subtitle'       => __('', 'oshin'),
            //                 'desc'           => __('', 'oshin'),
            //                 'default'            => array(
            //                     'padding-top'     => '15px', 
            //                     'padding-right'   => '20px', 
            //                     'padding-bottom'  => '15px', 
            //                     'padding-left'    => '20px',
            //                 ),
            //                 'required' => array('enable_custom_button_sizes','equals',true)
            //             ),
            //             array(
            //                 'id'             => 'large_button_padding',
            //                 'type'           => 'spacing',
            //                 'mode'           => 'padding',
            //                 'units'          => 'px',
            //                 'units_extended' => 'false',
            //                 'title'          => __('Large Button Padding', 'oshin'),
            //                 'subtitle'       => __('', 'oshin'),
            //                 'desc'           => __('', 'oshin'),
            //                 'default'            => array(
            //                     'padding-top'     => '18px', 
            //                     'padding-right'   => '25px', 
            //                     'padding-bottom'  => '18px', 
            //                     'padding-left'    => '25px',
            //                 ),
            //                 'required' => array('enable_custom_button_sizes','equals',true)
            //             ),
            //         array(
            //             'id'        => 'button_size_end',
            //             'type'      => 'section',
            //             'indent'    => false, // End of Indentation.
            //         ), 
            //     )
            // );
            // Single Blog - Hero Section
            $this->sections[] = array (
                'icon' => 'el-icon-magic',
                'title' => __('Single Blog Hero Section', 'oshin'),
                'desc'      => sprintf( __('Single Blog Hero Section Setting <a href="%s" target="_blank">Single Blog Hero Section Settings Documentation</a>', 'oshin'), 'https://www.brandexponents.com/oshine-knowledgebase/knowledge-base/single-blog-hero-section/'),
                'fields' => array (
                    array (
                        'id' => 'single_blog_hero_section_from',
                        'type' => 'radio',
                        'title' => __('Source of Hero Section in Single posts page', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'options'=> array('inherit_option_panel'=>'Options Panel (Here)', 'single_page'=>'Single Posts Page', 'none' => 'None'),
                        'default' => 'inherit_option_panel'
                    ),
                    array (
                        'id' => 'single_blog_hero_section',
                        'type' => 'radio',
                        'title' => __('Hero Section Type', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'options'=> array('slider'=>'Slider', 'custom'=>'Image/Video', 'none' => 'None'),
                        'default' => 'none'
                    ),
                    array (
                        'id' => 'single_blog_hero_section_slider_shortcode',
                        'type' => 'textarea',
                        'title' => __('Add Slider Shortcode', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'validate' => 'html',
                        'default' => ''
                    ),
                    array (
                        'id' => 'single_blog_header_transparent',
                        'type' => 'radio',
                        'title' => __('Enable Transparent Header', 'oshin'),
                        
                        
                        'options' => array('none' => 'Default', 'transparent'=>'Transparent', 'semitransparent'=>'Semi-Transparent'),
                        'default' => 'none'
                    ),
                    array (
                        'id' => 'single_blog_header_sticky',
                        'type' => 'select',
                        'title' => __('Sticky Header', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'options'=> array('inherit' => 'Inherit From Options panel (Under Layout)', 'yes' => 'Yes', 'no' => 'No'),
                        'default' => 'inherit'
                    ),
                    array (
                        'id' => 'single_blog_header_transparent_color_scheme',
                        'type' => 'radio',
                        'title' => __('Transparent Header Navigation Color Scheme', 'oshin'), 
                        'subtitle' => __('Applicable only for Transparent header', 'oshin'),
                        'desc' => __('' , 'oshin'),
                        'options'=>  array('none' => 'Default', 'dark' => 'Dark', 'light' => 'Light'),
                        'default' => 'dark'
                    ),
                    array (
                        'id' => 'single_blog_hero_section_position',
                        'type' => 'radio',
                        'title' => __('Hero Section Position', 'oshin'), 
                        'subtitle' => __('Applicable only for non-transparent header', 'oshin'),
                        'desc' => __('' , 'oshin'),
                        'options'=> array('before' => 'Before Header', 'after' => 'After Header'),
                        'default' => 'after'
                    ),
                    array (
                        'id' => 'single_blog_hero_section_custom_height',
                        'type' => 'text',
                        'title' => __('Hero Section Custom Height', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'default' => ''
                    ),
                    array (
                        'id' => 'single_blog_hero_section_with_header',
                        'type' => 'radio',
                        'title' => __('Hero Section With Header', 'oshin'), 
                        'subtitle' => __('Applicable only if header is non-transparent, Hero Section position is Before Header and no Custom Height is defined', 'oshin'),
                        'desc' => __('' , 'oshin'),
                        'options'=> array('yes' => 'Yes', 'no' => 'No'),
                        'default' => 'no'
                    ),
                    array (
                        'id' => 'single_blog_hero_section_bg_color',
                        'type' => 'color',
                        'title' => __('Hero Section Background Color', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'default' => ''
                    ),
                    array (
                        'id' => 'single_blog_hero_section_bg_image',
                        'type' => 'background',
                        'title' => __('Hero Section Background Image', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'background-color' => false
                    ),
                    array (
                        'id' => 'single_blog_hero_video_options',
                        'type' => 'section',
                        'title' => __('Video Settings','oshin'),
                        'indent' => true,
                    ),
                        array (
                            'id' => 'single_blog_hero_section_bg_video',
                            'type' => 'checkbox',
                            'title' => __('Enable Background Video', 'oshin'),
                            
                            
                            'default' => 0
                        ),
                        array (
                            'id' => 'single_blog_hero_section_bg_video_format',
                            'type' => 'radio',
                            'title' => __('Background Video format', 'oshin'),
                            
                            
                            'options' => array('mp4'=>'MP4', 'ogg'=>'OGG' , 'webm'=>'WebM'),
                            'default' => 'mp4'
                        ),
                        array (
                            'id' => 'single_blog_hero_section_bg_video_url',
                            'type' => 'text',
                            'title' => __('Video .MP4 Video File', 'oshin'),
                            'subtitle' => __('Self host the video and enter the URL of the media file', 'oshin'),
                            
                            'validate' => 'url',
                            'default' => ''
                        ),
                        array (
                            'id' => 'single_blog_hero_section_video_mute',
                            'type' => 'checkbox',
                            'title' => __('Unmute Video', 'oshin'),
                            'subtitle' => __('By default, the video in the BG will be muted', 'oshin'),
                            
                            'default' => 0
                        ),
                    array (
                        'id' => 'single_blog_hero_video_options_end',
                        'type' => 'section',
                        'indent' => false,
                    ),
                    array (
                        'id' => 'single_blog_hero_section_bg_animation',
                        'type' => 'select',
                        'title' => __('Background Animation', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'options'=> array(
                            'none' => 'None', 
                            'be-bg-parallax' => 'Parallax',
                            //'be-bg-mousemove-parallax' => 'Mouse Move', 
                            'background-horizontal-animation' => 
                            'Horizontal Loop Animation', 
                            'background-vertical-animation' => 
                            'Vertical Loop Animation'
                        ),
                        'default' => 'none'
                    ),
                    array (
                        'id' => 'single_blog_hero_section_overlay',
                        'type' => 'checkbox',
                        'title' => __('Hero Section Enable Background Overlay', 'oshin'),
                        
                        
                        'default' => 0
                    ),
                    array (
                        'id' => 'single_blog_hero_section_bg_overlay',
                        'type' => 'color_rgba',
                        'title' => __('Background Overlay Color', 'oshin'),
                        
                        
                        'default' => array('color' => '#e0a240', 'alpha' => '0.85')
                    ),
                    array (
                        'id' => 'single_blog_hero_section_container_wrap',
                        'type' => 'radio',
                        'title' => __('Wrap Content', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'options'=> array('yes' => 'Yes', 'no' => 'No'),
                        'default' => 'yes'
                    ),
                    array (
                        'id' => 'single_blog_hero_section_content',
                        'type' => 'editor',
                        'title' => __('Hero Section content', 'oshin'),
                        
                        
                        'default' => ''
                    ),
                )                   
            );
            // Single Shop - Hero Section
            $this->sections[] = array (
                'icon' => 'el-icon-magic',
                'title' => __('Single Shop Hero Section', 'oshin'),
                'desc'      => sprintf( __('Single Shop Hero Section Setting <a href="%s" target="_blank">Single Shop Hero Section Settings Documentation</a>', 'oshin'), 'https://www.brandexponents.com/oshine-knowledgebase/knowledge-base/single-shop-hero-section/'),
                'fields' => array (
                    array (
                        'id' => 'single_shop_hero_section_from',
                        'type' => 'radio',
                        'title' => __('Source of Hero Section in Single Products page', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'options'=> array('inherit_option_panel'=>'Options Panel (Here)', 'single_page'=>'Single Posts Page', 'none' => 'None'),
                        'default' => 'inherit_option_panel'
                    ),
                    array (
                        'id' => 'single_shop_hero_section',
                        'type' => 'radio',
                        'title' => __('Hero Section Type', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'options'=> array('slider'=>'Slider', 'custom'=>'Image/Video', 'none' => 'None'),
                        'default' => 'none'
                    ),
                    array (
                        'id' => 'single_shop_hero_section_slider_shortcode',
                        'type' => 'textarea',
                        'title' => __('Add Slider Shortcode', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'validate' => 'html',
                        'default' => ''
                    ),
                    array (
                        'id' => 'single_shop_header_transparent',
                        'type' => 'radio',
                        'title' => __('Header Style', 'oshin'),
                        
                        
                        'options' => array('none' => 'Default', 'transparent'=>'Transparent', 'semitransparent'=>'Semi-Transparent'),
                        'default' => 'none'
                    ),
                    array (
                        'id' => 'single_shop_header_sticky',
                        'type' => 'select',
                        'title' => __('Sticky Header', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'options'=> array('inherit' => 'Inherit From Options panel (Under Layout)', 'yes' => 'Yes', 'no' => 'No'),
                        'default' => 'inherit'
                    ),
                    array (
                        'id' => 'single_shop_header_transparent_color_scheme',
                        'type' => 'radio',
                        'title' => __('Transparent Header Navigation Color Scheme', 'oshin'), 
                        'subtitle' => __('Applicable only for Transparent header', 'oshin'),
                        'desc' => __('' , 'oshin'),
                        'options'=>  array('none' => 'Default', 'dark' => 'Dark', 'light' => 'Light'),
                        'default' => 'dark'
                    ),
                    array (
                        'id' => 'single_shop_hero_section_position',
                        'type' => 'radio',
                        'title' => __('Hero Section Position', 'oshin'), 
                        'subtitle' => __('Applicable only for non-transparent header', 'oshin'),
                        'desc' => __('' , 'oshin'),
                        'options'=> array('before' => 'Before Header', 'after' => 'After Header'),
                        'default' => 'after'
                    ),
                    array (
                        'id' => 'single_shop_hero_section_custom_height',
                        'type' => 'text',
                        'title' => __('Hero Section Custom Height', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'default' => ''
                    ),
                    array (
                        'id' => 'single_shop_hero_section_with_header',
                        'type' => 'radio',
                        'title' => __('Hero Section With Header', 'oshin'), 
                        'subtitle' => __('Applicable only if header is non-transparent, Hero Section position is Before Header and no Custom Height is defined', 'oshin'),
                        'desc' => __('' , 'oshin'),
                        'options'=> array('yes' => 'Yes', 'no' => 'No'),
                        'default' => 'no'
                    ),
                    array (
                        'id' => 'single_shop_hero_section_bg_color',
                        'type' => 'color',
                        'title' => __('Hero Section Background Color', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'default' => ''
                    ),
                    array (
                        'id' => 'single_shop_hero_section_bg_image',
                        'type' => 'background',
                        'title' => __('Hero Section Background Image', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'background-color' => false,
                    ),
                    array (
                        'id' => 'single_shop_hero_video_options',
                        'type' => 'section',
                        'title' => __('Video Settings','oshin'),
                        'indent' => true,
                    ),
                        array (
                            'id' => 'single_shop_hero_section_bg_video',
                            'type' => 'checkbox',
                            'title' => __('Enable Background Video', 'oshin'),
                            
                            
                            'default' => 0
                        ),
                        array (
                            'id' => 'single_shop_hero_section_bg_video_format',
                            'type' => 'radio',
                            'title' => __('Background Video format', 'oshin'),
                            
                            
                            'options' => array('mp4'=>'MP4', 'ogg'=>'OGG' , 'webm'=>'WebM'),
                            'default' => 'mp4'
                        ),
                        array (
                            'id' => 'single_shop_hero_section_bg_video_url',
                            'type' => 'text',
                            'title' => __('Video .MP4 Video File', 'oshin'),
                            'subtitle' => __('Self host the video and enter the URL of the media file', 'oshin'),
                            
                            'validate' => 'url',
                            'default' => ''
                        ),
                        array (
                            'id' => 'single_shop_hero_section_video_mute',
                            'type' => 'checkbox',
                            'title' => __('Unmute Video', 'oshin'),
                            'subtitle' => __('By default, the video in the BG will be muted', 'oshin'),
                            
                            'default' => 0
                        ),
                    array (
                        'id' => 'single_shop_hero_video_options_end',
                        'type' => 'section',
                        'indent' => false,
                    ),
                    array (
                        'id' => 'single_shop_hero_section_bg_parallax',
                        'type' => 'checkbox',
                        'title' => __('Enable Parallax', 'oshin'),
                        
                        
                        'default' => 0
                    ),
                    array (
                        'id' => 'single_shop_hero_section_bg_mouse_move_parallax',
                        'type' => 'checkbox',
                        'title' => __('Enable Mouse Move Parallax', 'oshin'),
                        
                        
                        'default' => 0
                    ),
                    array (
                        'id' => 'single_shop_hero_section_overlay',
                        'type' => 'checkbox',
                        'title' => __('Hero Section Enable Background Overlay', 'oshin'),
                        
                        
                        'default' => 0
                    ),
                    array (
                        'id' => 'single_shop_hero_section_bg_overlay',
                        'type' => 'color_rgba',
                        'title' => __('Background Overlay Color', 'oshin'),
                        
                        
                        'default' => array('color' => '#e0a240', 'alpha' => '0.85')
                    ),
                    array (
                        'id' => 'single_shop_hero_section_container_wrap',
                        'type' => 'radio',
                        'title' => __('Wrap Content', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'options'=> array('yes' => 'Yes', 'no' => 'No'),
                        'default' => 'yes'
                    ),
                    array (
                        'id' => 'single_shop_hero_section_content',
                        'type' => 'editor',
                        'title' => __('Hero Section content', 'oshin'),
                        
                        
                        'default' => ''
                    ),
                )                   
            );     
            $this->sections[] = array(
                'type' => 'divide',
            );       
            // Import Export
            $this->sections[] = array(
                'title'     => __('Import / Export', 'oshin'),
                'desc'      => sprintf( __('Import and Export your Redux Framework settings from file, text or URL. <a href="%s" target="_blank">Import/Export Documentation</a>', 'oshin') , 'https://www.brandexponents.com/oshine-knowledgebase/knowledge-base/importexport/' ),
                'icon'      => 'el-icon-refresh',
                'fields'    => array(
                    array(
                        'id'            => 'opt-import-export',
                        'type'          => 'import_export',
                        'title'         => 'Import Export',
                        'subtitle'      => 'Save and restore your Redux options',
                        'full_width'    => false,
                    ),
                ),
            );
            //Performace
            $this->sections[] = array(
                'title'   => __( 'Performance', 'oshin' ),
                'desc'      => sprintf( __('<a href="%s" target="_blank">Performance Documentation</a>', 'oshin') , 'https://www.brandexponents.com/oshine-knowledgebase/knowledge-base/performance/' ),
                'icon'    => 'el el-wrench',
                'fields'  => array (
                    array (
                        'id'            => 'external_dynamic_css',
                        'type'          => 'checkbox',
                        'title'         => __( 'Use external file to load dynamic css', 'oshin' ),
                        'subtitle'      => 'This option will not work if you are using a multi site network.',
                        'default'       => 0,
                    ), 
                    array (
                        'id'            => 'minified_css',
                        'type'          => 'checkbox',
                        'title'         => __( 'Use Minified CSS assets', 'oshin' ),
                        'subtitle'      => '',
                        'default'       => 0,
                    ),
                    array (
                        'id'            => 'minified_js',
                        'type'          => 'checkbox',
                        'title'         => __( 'Use minified JS assets', 'oshin' ),
                        'subtitle'      => '',
                        'default'       => 0,
                    ),              
                )
            );

            //GDPR
            $this->sections[] = array(
                'title'   => __( 'GDPR Compliance', 'oshin' ),
                'desc'      => sprintf( __('<a href="%s" target="_blank">GDPR Compliance Documentation</a>', 'oshin') , 'https://www.brandexponents.com/oshine-knowledgebase/knowledge-base/gdpr-compliance/' ),
                'icon'    => 'el el-wrench',
                'fields'  => array (
                    array (
                        'id'            => 'consent_checkboxes',
                        'type'          => 'checkbox',
                        'title'         => __( 'Add Consent Checkboxes to Contact Form and Newsletter Modules', 'oshin' ),
                        'subtitle'      => 'This option works only for the modules integrated with Tatsu. Not applicable if you have used a 3rd party plugin such as Contact Form 7, for publishing forms',
                        'default'       => 0,
                    ), 
                    array (
                        'id'            => 'anonymize_analytics_ip',
                        'type'          => 'checkbox',
                        'title'         => __( 'Anonymize IP when using Google Analytics', 'oshin' ),
                        'subtitle'      => 'This option works only if you have integrated Google Analytics using the option we have provided in the General Settings tab',
                        'default'       => 0,
                    ),            
                )
            );


            $this->sections[] = array(
                'icon'      => 'el-icon-info-sign',
                'title'     => __('Theme Information', 'oshin'),
                'desc'      => __('<p class="description">This is the Description. Again HTML is allowed</p>', 'oshin'),
                'fields'    => array(
                    array(
                        'id'        => 'opt-raw-info',
                        'type'      => 'raw',
                        'content'   => $item_info,
                    )
                ),
            );
        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => __('Theme Information 1', 'oshin'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'oshin')
            );

            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => __('Theme Information 2', 'oshin'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'oshin')
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'oshin');
        }

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'          => 'be_themes_data',            // This is where your data is stored in the database and also becomes your global variable name.
                'disable_tracking'  => true,
                'display_name'      => $theme->get('Name'),     // Name that appears at the top of your panel
                'display_version'   => $theme->get('Version'),  // Version that appears at the top of your panel
                'menu_type'         => 'menu',                  //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'    => true,                    // Show the sections below the admin menu item or not
                'menu_title'        => __('Oshine Options', 'oshin'),
                'page_title'        => __('Oshine Options', 'oshin'),
                
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => 'AIzaSyCzccjpnf0TJHkjR3K5IMsF3rALDKMDzuk', // Must be defined to add google fonts to the typography module
                'google_update_weekly' => false,
                'async_typography'  => false,                    // Use a asynchronous font on the front end or font string
                'admin_bar'         => true,                    // Show the panel pages on the admin bar
                'global_variable'   => '',                      // Set a different name for your global variable other than the opt_name
                'dev_mode'          => false,                    // Show the time the page took to load, etc
                'customizer'        => true,                    // Enable basic customizer support
                //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                // OPTIONAL -> Give you extra features
                'page_priority'     => null,                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'       => 'themes.php',            // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions'  => 'manage_options',        // Permissions needed to access the options panel.
                'menu_icon'         => '',                      // Specify a custom URL to an icon
                'last_tab'          => '',                      // Force your panel to always open to a specific tab (by id)
                'page_icon'         => 'icon-themes',           // Icon displayed in the admin panel next to your menu_title
                'page_slug'         => '_options',              // Page slug used to denote the panel
                'save_defaults'     => true,                    // On load save the defaults to DB before user clicks save or not
                'default_show'      => false,                   // If true, shows the default value next to each field that is not the default value.
                'default_mark'      => '',                      // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,                   // Shows the Import/Export panel when not used as a field.
                
                // CAREFUL -> These options are for advanced use only
                'transient_time'    => 60 * MINUTE_IN_SECONDS,
                'output'            => true,                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'        => true,                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.
                
                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'              => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info'           => false, // REMOVE

                // HINTS
                'hints' => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'         => 'light',
                        'shadow'        => true,
                        'rounded'       => false,
                        'style'         => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'mouseover',
                        ),
                        'hide'      => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'click mouseleave',
                        ),
                    ),
                )
            );


            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            // $this->args['share_icons'][] = array(
            //     'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
            //     'title' => 'Visit us on GitHub',
            //     'icon'  => 'el-icon-github'
            //     //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
            // );
            // $this->args['share_icons'][] = array(
            //     'url'   => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
            //     'title' => 'Like us on Facebook',
            //     'icon'  => 'el-icon-facebook'
            // );
            // $this->args['share_icons'][] = array(
            //     'url'   => 'http://twitter.com/reduxframework',
            //     'title' => 'Follow us on Twitter',
            //     'icon'  => 'el-icon-twitter'
            // );
            // $this->args['share_icons'][] = array(
            //     'url'   => 'http://www.linkedin.com/company/redux-framework',
            //     'title' => 'Find us on LinkedIn',
            //     'icon'  => 'el-icon-linkedin'
            // );

            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace('-', '_', $this->args['opt_name']);
                }
             //   $this->args['intro_text'] = sprintf(__('<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'oshin'), $v);
            } else {
              //  $this->args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'oshin');
            }

            // Add content after the form.
           // $this->args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'oshin');
        }

    }
    
    global $reduxConfig;
    $reduxConfig = new Redux_Framework_sample_config();
}

/**
  Custom function for the callback referenced above
 */
if (!function_exists('redux_my_custom_field')):
    function redux_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;

/**
  Custom function for the callback validation referenced above
 * */
if (!function_exists('redux_validate_callback_function')):
    function redux_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';

        /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            $field['msg'] = 'your custom error message';
          }
         */

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;