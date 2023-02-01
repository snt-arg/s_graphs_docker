<?php

if( !function_exists( 'oshine_section_templates' ) ) {
    add_action( 'tatsu_register_templates', 'oshine_section_templates' );
    function oshine_section_templates() {
        $templates_order = array( 'hero', 'content', 'team', 'testimonials', 'clients', 'pricing', 'cta', 'contact' );
        foreach( $templates_order as $category_name ) {
            $category = OSHINE_MODULES_PLUGIN_DIR . 'includes/templates/'.$category_name;
            foreach( glob( $category . '/*.txt' ) as $template ) {
                $template_name = basename( $template, '.txt' );
                $img = OSHINE_MODULES_PLUGIN_URL . '/includes/templates/' . $category_name . '/' . $template_name . '.jpg';
                tatsu_register_template( array(
                    'title' => $template_name,
                    'name'  => $template_name, 
                    'category' => array( $category_name ),
                    'type' => 'sections',
                    'img' => $img,
                    'src' => $template
                ) );
            }
        }
    }
}