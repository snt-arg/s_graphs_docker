<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Tatsu_Page_Templates {

	private $templates;
	private static $instance;

	public static function getInstance() {
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
 
        return self::$instance;		
	}

	private function __construct() {
		$this->templates = array(
			'sections' => array(),
			'templates'	=> array(),
		);
	}

	public function get_template( WP_REST_Request $request ) {
		$name = $request->get_param('name');
		$type = $request->get_param('type');
		$templates = get_option('tatsu_templates', '');
		$templates = json_decode( $templates, true );

		if( !empty( $templates[$type][$name] ) ) {
			$parser = new Tatsu_Parser( $templates[$type][$name]['content'] );
			$template_content = json_decode( $parser->get_tatsu_page_content(), true )  ;
			return $template_content;
		} else {
			if( array_key_exists( $name, $this->templates ) ) {
				$template_content = file_get_contents( $this->templates[$name]['content'] );
				if( $template_content ) {
					$parser = new Tatsu_Parser( $template_content );
					$template_content = json_decode( $parser->get_tatsu_page_content(), true )  ;
					return $template_content;
				}
			} else {
				return false;
			}
		}
		return false;
	}

	public function ajax_get_template() {
		if( !array_key_exists( 'nonce', $_POST ) || !wp_verify_nonce( $_POST['nonce'], 'wp_rest' ) ) {
			echo 'false';
			wp_die();
		}
		$name = be_sanitize_text_field($_POST['name']);
		$template_type = be_sanitize_text_field($_POST['template_type']);
        $collection_type = be_sanitize_text_field($_POST['collection_type']);
        $template_content = '';
        $possible_template_types = array( 'prebuilt', 'custom' );
		if( in_array( $template_type, $possible_template_types ) ) {
			if( 'prebuilt' === $template_type ) {
                if( array_key_exists( $name, $this->templates[$collection_type] ) ) {
                    $template_content = file_get_contents( $this->templates[$collection_type][$name]['src'] );
                }
            }else {
                $saved_templates = get_option('tatsu_templates', '');
                $saved_templates = json_decode( $saved_templates, true );        
                if( array_key_exists( $name, $saved_templates[$collection_type] ) ) {
                    $template_content = $saved_templates[$collection_type][$name]['content'];
                }
            }
		}
		if( !empty( $template_content ) ) {
            $parser = new Tatsu_Parser( $template_content );
            $template_content = json_decode( $parser->get_tatsu_page_content(), true )  ;
            echo json_encode( $template_content );
            wp_die();
		} else {
			echo 'false';
			wp_die();
		}
	}	

	public function save_template( WP_REST_Request $request ) {
		$name = $request->get_param('name');
		$type = $request->get_param('type');
		$title = $request->get_param('title');
		$inner = json_decode( $request->get_param('template_content') , true );
		$inner = $inner['inner'];

		$templates = get_option('tatsu_templates', '');
		$templates = json_decode( $templates, true );
		$templates[$type][$name]['content'] = tatsu_shortcodes_from_content( $inner ); 
		$templates[$type][$name]['title'] = $title;
		$templates = json_encode( $templates );

		return update_option( 'tatsu_templates',  $templates );
		
	}

	public function ajax_save_template() {
		if( !array_key_exists( 'nonce', $_POST ) || !wp_verify_nonce( $_POST['nonce'], 'wp_rest' ) ) {
			echo 'false';
			wp_die();
		}
		$name = be_sanitize_text_field($_POST['name']);
		$type = be_sanitize_text_field($_POST['type']);
		$title = be_sanitize_text_field($_POST['title']);
		$created_by = $_POST['created_by'];
		$created_at = $_POST['created_at'];
		$inner = json_decode(stripslashes( $_POST['template_content'] ) , true );
		$inner = $inner['inner'];

		$templates = get_option('tatsu_templates', '');
		$templates = json_decode( $templates, true );
		if(empty($templates)) {
			$templates = array ( 
				'sections'	=> array(),
				'templates'	=> array(),
			);
		}
		$templates[$type][$name]['content'] = tatsu_shortcodes_from_content( $inner ); 
		$templates[$type][$name]['title'] = $title;
		$templates[$type][$name]['created_at'] = $created_at;
		$templates[$type][$name]['created_by'] = $created_by;
		$templates = json_encode( $templates );

		if( update_option( 'tatsu_templates',  $templates ) ) {
			echo 'true';
			wp_die();
		} else {
			echo 'false';
			wp_die();
		}	
	}	

	public function delete_template( WP_REST_Request $request ) {
		$name = $request->get_param('name');
		$type = $request->get_param('type');
		$templates = get_option('tatsu_templates', '');
		$templates = json_decode( $templates, true );
		unset( $templates[$type][$name] );
		$templates = json_encode( $templates );
		return update_option( 'tatsu_templates',  $templates );
	}

	public function ajax_delete_template() {
		if( !array_key_exists( 'nonce', $_POST ) || !wp_verify_nonce( $_POST['nonce'], 'wp_rest' ) ) {
			echo 'false';
			wp_die();
		}

		$name = be_sanitize_text_field($_POST['name']);
		$type = be_sanitize_text_field($_POST['type']);
		$templates = get_option('tatsu_templates', '');
		$templates = json_decode( $templates, true );
		unset( $templates[$type][$name] );
		$templates = json_encode( $templates );
		if( update_option( 'tatsu_templates',  $templates ) ) {
			echo 'true';
			wp_die();
		} else {
			echo 'false';
			wp_die();			
		}
	}	

	public function register_template( $args ) {
		if( is_array( $args ) && !empty( $args['name'] ) && !empty( $args['src'] ) && !empty( $args['type'] ) && in_array( $args['type'], array( 'templates', 'sections' ) ) ) {
			$new_template = array(  
				$args['name'] => array ( 
					'title' => !empty( $args['title'] )? $args['title'] : $args['name'],
					'src' => $args['src'],
					'img' => !empty( $args['img'] )? $args['img'] : '',
					'category' => $args['category'],
				)
			);
			$this->templates[$args['type']] = array_merge( $this->templates[$args['type']], $new_template );
		}

	}

	public function get_templates_list() {
		
		$saved_templates = json_decode( get_option( 'tatsu_templates', '' ), true );
		$templates_list = array(
            'prebuilt' => array( 
                'sections'	=> array(),
                'templates'	=> array(),
            ),
            'custom' => array( 
                'sections'	=> array(),
                'templates'	=> array(),
            )
        );

        if( is_array( $saved_templates ) && !empty( $saved_templates ) ) {
            foreach ( $saved_templates as $type => $templates ) {
                foreach( $templates as $name => $template ) {
                    $templates_list['custom'][$type][] = array(
                        'name' => $name,
                        'title' => $template['title'],
                        'created_at' => $template['created_at'],
                        'created_by' => $template['created_by'],	
                    ); 
                }	
            }		
        }	

		foreach ( $this->templates as $type => $templates ) {
			foreach( $templates as $name => $template ) {
				
				$image_details_from_url = getimagesize( $template['img'] );
				if( is_null( $image_details_from_url[0] ) || is_null( $image_details_from_url[0] ) ){
					$image_details_from_path = getimagesize(ABSPATH . parse_url($template['img'])['path']);
					$image_details = $image_details_from_path;
				}else{
					$image_details = $image_details_from_url;
				}

				$templates_list['prebuilt'][$type][] = array(
					'name' => $name,
					'title' => $template['title'],
					'img' => $template['img'],
					'category' => $template['category'],
					'width' => $image_details[0],
					'height' => $image_details[1],
				); 
			}
		}

		echo json_encode( $templates_list );
		wp_die();		
		 
	}

	public function get_prebuilt_templates() {
		$type = be_sanitize_text_field($_POST['type']);
		$offset = be_sanitize_text_field($_POST['offset']);
		$possible_collection_type = array( 'sections', 'templates' );
		if( in_array( $type, $possible_collection_type ) ) {	
			$target_collection = $this->templates[$type];
			$target_collection_length = count($target_collection);
			if( $offset >= $target_collection_length ) {
				echo true;
				wp_die();
			}
			$length = 9 > ( $target_collection_length - $offset ) ? ( $target_collection_length - $offset ) : 9;
			$sliced_collection = array_slice( $target_collection, $offset, $length );
			$formatted_collection = array();
			foreach( $sliced_collection as $name => $template ) {
				list($width, $height, $type, $attr) = getimagesize($template['img']);
				$formatted_collection[] = array (
					'name' => $name,
					'title' => $template['title'],
					'img' => $template['img'],
					'category' => $template['category'],
					'width' => $width,
					'height' => $height,
				);
			}
			echo json_encode( $formatted_collection );
			wp_die();	
		}
		echo false;
		wp_die();
	}

	public function setup_hooks() {
		do_action( 'tatsu_register_templates' );	
	}	
}
?>