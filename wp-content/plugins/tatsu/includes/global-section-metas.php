<?php

add_action('tatsu_register_global_section_metas','global_section_metas');
function global_section_metas(){
    $options = array(
        'page' => array(
            "date" => "Date",
            "category" => "Category",
            "author" => "Author",
        ),
        'post' => array(
            "date" => "Date",
            "category" => "Category",
            "author" => "Author",
        ),
        'portfolio' => array(
            "date" => "Date",
            "category" => "Category",
            "author" => "Author",
        )
    );
	foreach( $options as $option => $value ){
		tatsu_register_global_section_meta($option,$value);
	}
}