<?php

if ( !function_exists( 'be_gdpr_privacy_ok' ) ){
    function be_gdpr_privacy_ok($name){
        $privacyPref = array_key_exists( 'be_gdpr_privacy',$_COOKIE ) ?  json_decode(stripslashes($_COOKIE['be_gdpr_privacy'])) : array() ;

        $options = Be_Gdpr_Options::getInstance()->get_options();
        
        if( array_key_exists( $name, $options ) ){
            return in_array($name, $privacyPref);
        } else {
            return true;
        }

		
    }
}

if( !function_exists( 'be_gdpr_register_option' ) ){
    function be_gdpr_register_option( $id, $args ){
        if( empty( $id ) || empty( $args ) || !is_array( $args ) ) {
            trigger_error( __( 'Incorrect Arguments to register a consent condition', 'be-gdpr' ), E_USER_NOTICE );
        }
        Be_Gdpr_Options::getInstance()->register_option($id,$args);
    }
}

if( !function_exists( 'be_gdpr_deregister_option' ) ){
    function be_gdpr_deregister_option( $id ){
        if( empty( $id ) ) {
            trigger_error( __( 'Incorrect Arguments to de-register a consent condition', 'be-gdpr' ), E_USER_NOTICE );
        }
        Be_Gdpr_Options::getInstance()->deregister_option($id);
    }
}

/******* GDPR Audio *******/
if( !function_exists( 'be_gdpr_embed_audio' ) ){
	function be_gdpr_embed_audio( $url ){
		if( strpos( $url, 'spotify' ) !== false ){
            if( !be_gdpr_privacy_ok( 'spotify' ) ){
                return '<div class="gdpr-alt-image"><img style="opacity:1;width:100%;" src="'. plugin_dir_url(__FILE__) .'/assets/spotify.jpg"/><div class="gdpr-video-alternate-image-content" >'. do_shortcode( str_replace('[be_gdpr_api_name]','[be_gdpr_api_name api="spotify" ]', get_option( 'be_gdpr_text_on_overlay', 'Your consent is required to display this content from [be_gdpr_api_name] - [be_gdpr_privacy_popup]' ))  ) .'</div></div>';
            } else {
                return wp_oembed_get( $url );
            }
        } else if ( strpos( $url, 'soundcloud' ) !== false ){
            if( !be_gdpr_privacy_ok( 'soundcloud' ) ){
                return '<div class="gdpr-alt-image"><img style="opacity:1;width:100%;" src="'. plugin_dir_url(__FILE__) .'/assets/soundcloud.jpg"/><div class="gdpr-video-alternate-image-content" >'. do_shortcode( str_replace('[be_gdpr_api_name]','[be_gdpr_api_name api="soundcloud" ]', get_option( 'be_gdpr_text_on_overlay', 'Your consent is required to display this content from [be_gdpr_api_name] - [be_gdpr_privacy_popup]' ))  ) .'</div></div>';
            } else {
                return wp_oembed_get( $url );
            }
        }
	}
}