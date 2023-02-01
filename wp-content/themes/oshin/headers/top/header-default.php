<div id="main-wrapper"
    <?php
        //Make the below as function for checking of style is 7 to 12 and page stack top is enabled 
        global $be_themes_data;
        $top_menu_style = $be_themes_data['top-menu-style'];
        if ( be_is_special_top_menu('page-stack-top') ) {
		    echo 'class = "be-page-stack-wrapper"';
	    } 
    ?>>
    <?php if ( be_is_special_top_menu('page-stack-top') ){
		echo '<div class = "be-page-stack-container">';
	}?>
    <?php 
        global $be_themes_data;
        if($be_themes_data['layout'] == 'layout-border-header-top') {
            $layout = 'layout-border layout-border-header-top';
        } else {
            $layout = $be_themes_data['layout'];
        }

        if ( be_is_special_top_menu('page-stack-top') ) {
            $page_stack_class = 'be-page-stack ';
        } else {
            $page_stack_class = '';
        }
    ?>
    <div id="main" class="ajaxable <?php echo $page_stack_class; ?><?php echo $layout; ?>" >
        <?php
            extract( be_themes_top_section_details() );
            if($top_section_position == 'before' && !(!empty($header_transparent) && isset($header_transparent) && $header_transparent && $header_transparent != 'none')) {
                get_template_part( 'headers/top', 'section' );
            }
            $header_style = basename($be_themes_data['opt-header-style'], '.png');
            if( ( 'style1' == $header_style ) || ( 'style3' == $header_style ) || ( 'style4' == $header_style ) || ( 'style5' == $header_style ) ){
                get_template_part( 'headers/top/header','style' );
            } else if ( ( 'style2' == $header_style ) || ( 'style6' == $header_style ) || ( 'style13' == $header_style ) ){
                get_template_part( 'headers/top/header', $header_style );
            } else {
                get_template_part( 'headers/top/header', 'new-style' );
            }
            if($top_section_position != 'before' || (!empty($header_transparent) && isset($header_transparent) && $header_transparent && $header_transparent != 'none')) {
                get_template_part( 'headers/top', 'section' );
            }
        ?>