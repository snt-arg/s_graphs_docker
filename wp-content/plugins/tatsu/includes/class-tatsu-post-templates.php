<?php
    /**
     * Handles Post templates added by tatsu
     * @source https://github.com/wpexplorer/page-templater/blob/master/pagetemplater.php
     */

    class Tatsu_Post_Templates {
        private static $instance;
        private $templates;

        public static function getInstance() {
            if ( null == self::$instance ) {
                self::$instance = new self;
            }
            return self::$instance;		
        }

        public function __construct() {
            $this->templates = array();
        }

        public function init() {
            $this->templates = apply_filters( 'tatsu_post_templates', array( 
                'page' => array (
                    'blank.php' => esc_html__('Tatsu Template', 'tatsu')
                ),
                'post'  => array (
                    'blank.php' => esc_html__('Tatsu Template', 'tatsu'),
                )
            ) );
            if ( !version_compare( floatval( get_bloginfo( 'version' ) ), '4.7', '<' ) ) {
                foreach( $this->templates as $post_type => $templates ) {
                    add_filter( "theme_{$post_type}_templates", array( $this, 'add_new_template' ), 10, 4 );
                }
                add_filter( 'wp_insert_post_data', array( $this, 'register_project_templates' ) );
                add_filter( 'template_include', array( $this, 'view_project_template') );    
            }
        }
    
        public function add_new_template( $posts_templates, $theme, $post, $post_type ) {
            if( array_key_exists( $post_type, $this->templates ) ) {
                $posts_templates = array_merge( $posts_templates, $this->templates[$post_type] );
            }
            return $posts_templates;
        }
    
        public function register_project_templates( $atts ) {
            $post_type = tatsu_admin_get_post_type();
            if( !is_array( $this->templates ) || !array_key_exists( $post_type, $this->templates ) ) {
                return $atts;
            }
            $cache_key = 'post_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );
            $current_cache = wp_cache_get( $cache_key, 'themes' );
            if( empty( $current_cache ) ) {
                $current_cache = array();
            }
            if( !array_key_exists( $post_type, $current_cache ) ) {
                $current_cache[$post_type] = array();
            }
            $new_cache = $current_cache;
            wp_cache_delete( $cache_key , 'themes');
            $new_cache[$post_type] = array_merge( $current_cache[$post_type], $this->templates[$post_type] );
            wp_cache_add( $cache_key, $new_cache, 'themes', 1800 );
            return $atts;
        } 
    
        public function view_project_template( $template ) {
            global $post;
            if ( is_search() ) {
                return $template;
            }
            if ( ! $post ) {
                return $template;
            }
            $post_type = get_post_type();
            $current_template = get_post_meta( $post->ID, '_wp_page_template', true );
            if ( ! isset( $this->templates[$post_type] ) || ! isset( $this->templates[$post_type][ $current_template ] ) ) {
                return $template;
            } 
            $folder_path = apply_filters( "tatsu_{$post_type}_folder_path", plugin_dir_path( __FILE__ ) . 'templates/' );
            $file = $folder_path . $current_template;
            if ( file_exists( $file ) ) {
                return $file;
            } else {
                echo $file;
            }
            return $template;
        }
    }