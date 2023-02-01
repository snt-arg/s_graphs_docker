<?php
/**
 * 
 * This is the template that displays Tatsu header.
 *
 */
?>
<!doctype html>
<html <?php language_attributes(); ?> >
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php 
wp_body_open();
do_action( 'be_themes_before_body' );
//Tatsu Header 
do_action( 'tatsu_print_header' );

do_action( 'be_themes_before_single_page_content' );
?>