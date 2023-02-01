<?php
    global $be_themes_data;
    $strip_flag = (('strip' == basename($be_themes_data['left-header-style'],'.jpg') ) || ('overlay' == basename($be_themes_data['left-header-style'],'.jpg') )) ? 'on' : 'off' ;
	$strip_menu_class = isset($be_themes_data['left-header-style']) && !empty($be_themes_data['left-header-style']) ? basename($be_themes_data['left-header-style'],'.jpg') : '' ;
	$left_strip_animation = isset($be_themes_data['left-strip-animation']) && !empty($be_themes_data['left-strip-animation']) ? $be_themes_data['left-strip-animation'] : 'menu_push_main' ;
    
    if ('on' == $strip_flag) {?>
	<div class="left-strip-wrapper">
		<div id="sb-left-strip" class="leftside-menu-controller ajaxable <?php echo $strip_menu_class.' '; echo $left_strip_animation; ?>">
		<?php 
			if ( ! empty( $be_themes_data['left-strip-logo']['url'])){
				$logo_strip = $be_themes_data['left-strip-logo']['url'];
				echo '<div id="logo-strip-bar"><img class="" src="'.$logo_strip.'" alt="" /></div>';
			}
			be_themes_get_left_header_woocommerce_cart_widget();?>
			<i class="font-icon icon-icon_menu leftside-menu-controller"></i>

		</div>
	</div><?php
	}?>
	<?php 
		// left strip menu for the new header styles
		if( isset($be_themes_data['left-header-style']) && !empty($be_themes_data['left-header-style']) && ( be_is_special_left_menu( 'left-strip-menu' ) || be_is_special_left_menu( 'overlay-center-align-menu' ) || be_is_special_left_menu( 'overlay-left-align-menu' ) || be_is_special_left_menu( 'perspective-right' ) ) ){ ?>
			<div class = "be-left-strip-wrapper">
				<div id = "be-left-strip">
				<?php
					 if ( ! empty( $be_themes_data['left-strip-logo']['url'])){
						 $logo_strip = $be_themes_data['left-strip-logo']['url'];
						 echo '<div id="logo-strip-bar"><img class="" src="'.$logo_strip.'" alt="" /></div>';
					 }
					 be_themes_get_left_header_woocommerce_cart_widget();
					 get_template_part( 'headers/header','hamburger' );?>
				</div>
			</div>
	<?php } ?>
    <div id="main-wrapper">
		<?php 
			if($be_themes_data['layout'] == 'layout-border-header-top') {
				$layout = 'layout-border layout-border-header-top';
			} else {
				$layout = $be_themes_data['layout'];
			}
		?>
		<div id="main" class="ajaxable <?php echo $layout; ?>" >
			<?php
				extract( be_themes_top_section_details() );
				if($top_section_position == 'before' && !(!empty($header_transparent) && isset($header_transparent) && $header_transparent && $header_transparent != 'none')) {
					get_template_part( 'headers/top', 'section' );
				}
				get_template_part( 'headers/left/header', 'style' );
				if($top_section_position != 'before' || (!empty($header_transparent) && isset($header_transparent) && $header_transparent && $header_transparent != 'none')) {
					get_template_part( 'headers/top', 'section' );
				}
			?>