<?php
add_action( 'tatsu_register_svgs', 'tatsu_register_linea' );
function tatsu_register_linea() {
    $kit_id = 'linea';
    $linea_icons = array();
    if( $handle = opendir(TATSU_PLUGIN_DIR.'includes/icons/svgs') ) {
        while ( false !== ( $file = readdir( $handle ) ) ) {
            $filename = explode( '.', $file );
            if( !empty( $filename[1] ) && 'svg' === $filename[1] && $filename[0] !== $kit_id ) {
                $linea_icons[] = $filename[0];
            }  
        }
        closedir($handle);
    }
	tatsu_register_svg( $kit_id, esc_html__( 'Linea SVG Icons', 'tatsu' ) , $linea_icons, TATSU_PLUGIN_URL.'/includes/icons/svgs/' );
} 

?>