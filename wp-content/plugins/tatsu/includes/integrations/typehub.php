<?php
if( !function_exists( 'tatsu_modules_typehub_add_options' ) ) {
    function tatsu_modules_typehub_add_options() {
        $modules = array (
            'tatsu_wpforms_label'   =>   array (
                'label'        => esc_html__( 'WP Forms Label', 'tatsu' ),
                'selector'     => '.tatsu-wp-forms div.wpforms-container-full .wpforms-form label.wpforms-field-label',
                'img'          => '',
                'responsive' => true,
                'options'      => array (
                    'font-family'       => 'schemes:primary',
                    'font-size'         => '15px',
                    'line-height'       => '1.7em',
                    'color'             => 'rgba(0,0,0,0.45)',
                    'letter-spacing'    => '0px',
                    'font-variant'      => '400',
                    'text-transform'    => 'none',   
                )
            ),
            'tatsu_wpforms_entry'  =>   array (
                'label'        => esc_html__( 'WP Forms Entry', 'tatsu' ),
                'selector'     =>  '.tatsu-wp-forms div.wpforms-container-full .wpforms-form select, .tatsu-wp-forms div.wpforms-container-full .wpforms-form input:not([type = "submit"]), .tatsu-wp-forms div.wpforms-container-full .wpforms-form label.wpforms-field-label-inline',
                'img'          => '',
                'responsive' => true,
                'options'      => array (
                    'font-family'       => 'schemes:primary',
                    'font-size'         => '15px',
                    'line-height'       => '1.7em',
                    'color'             => '#343638',
                    'letter-spacing'    => '0px',
                    'font-variant'      => '600',
                    'text-transform'    => 'none',  
                )
            ),
            'tatsu_wpforms_sublabel'   =>   array (
                'label'        => esc_html__( 'WP Forms Sublabel', 'tatsu' ),
                'selector'     => '.tatsu-wp-forms div.wpforms-container-full .wpforms-form label.wpforms-field-sublabel',
                'img'          => '',
                'responsive' => true,
                'options'      => array (
                    'font-family'       => 'schemes:primary',
                    'font-size'         => '12px',
                    'line-height'       => '1em',
                    'color'             => 'rgba(0,0,0,0.45)',
                    'letter-spacing'    => '0px',
                    'font-variant'      => '200',
                    'text-transform'    => 'none',   
                )
            ),
        );
        typehub_register_options( $modules, 'Forms' );
    }
    if ( in_array( 'wpforms-lite/wpforms.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        add_action( 'typehub_register_options', 'tatsu_modules_typehub_add_options', 11 );
    }
}
?>