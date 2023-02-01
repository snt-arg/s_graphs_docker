<?php
/**
 * Class for the Typehub importer in Merlin WP.
 *
 */

class Merlin_Typehub_Importer {
	/**
	 * Import Typehub data from a JSON file, included within the theme zip file.
	 *
	 * @param array $file_path contains the path of the file the data to be included'.
	 *
	 * @return boolean
	 */
	public static function import( $file_path ) {
		
        if ( empty( $file_path ) || !function_exists('typehub_import') ) {
            return false;
        }

        $typehub_raw_data = file_get_contents( $file_path );
        $typehub_raw_data = trim( $typehub_raw_data, '###' );
        $typehub_raw_data = json_decode( $typehub_raw_data,true );

        if( typehub_import( $typehub_raw_data ) ){
            return true;
        } else {
            return false;
        }

        if( class_exists( 'Merlin_Logger' ) ){
            Merlin_Logger::get_instance()->debug( __( 'The Typehub data was imported' , 'merlin-wp') );
        }
		return true;
	}
}
