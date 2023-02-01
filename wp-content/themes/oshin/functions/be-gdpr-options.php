<?php
if ( ! function_exists( 'be_gdpr_options' ) ) {
    function be_gdpr_options(){
        $options = array(
            'youtube' => array(
                'label' => "Youtube",
                'description' => __( "Consent to display content from YouTube.", 'oshin' ),
                'required' => false
            ),
            'vimeo' => array(
                'label' => "Vimeo",
                'description' => __( "Consent to display content from Vimeo.", 'oshin' ),
                'required' => false
            ), 
            'gmaps' => array(
                'label' => "Google Maps",
                'description' => __( "Consent to display content from Google Maps.", 'oshin' ),
                'required' => false
            ),
        );
        foreach( $options as $option => $value ){
            be_gdpr_register_option($option,$value);
        }
    }
}
add_action('be_gdpr_register_options','be_gdpr_options');

?>