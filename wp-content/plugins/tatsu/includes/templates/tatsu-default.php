<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" >
		<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<?php
		wp_head();
		?>
	</head>
	<body <?php body_class(); ?>>
		<?php
		do_action('tatsu_print_header');
		do_action('tatsu_head');
		while (have_posts()):
			the_post();
			?>
			<div id="tatsu-content">
				<?php the_content() ?>
			</div>
			<?php
		endwhile;
		do_action('tatsu_footer');
		do_action('tatsu_print_footer');
		wp_footer();
		?>
	</body>
</html>