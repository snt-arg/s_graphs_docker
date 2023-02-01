<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 */

get_header(); 
?>
	<section id="content" class="no-sidebar-page">
		<div id="content-wrap" class="">
			<section id="page-content">
				<div class="clearfix">	
					<div class="be-row be-wrap not-found">
						<header class="entry-header">
							<h1 class="entry-title"><?php _e( '404 PAGE NOT FOUND', 'oshin' ); ?></h1>
						</header>
						<div class="not-found-search">
							<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'oshin' ); ?></p>
							<?php get_search_form(); ?>
						</div>
					</div>
				</div> <!--  End Page Content -->
			</section>
		</div>
	</section>	
<?php get_footer(); ?>