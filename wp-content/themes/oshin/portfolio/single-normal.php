<?php
	//global $post;
	global $be_themes_data;
	$be_pb_class = 'page-builder';
	$be_pb_disabled = get_post_meta( get_the_ID(), '_be_pb_disable', true );
	if( !function_exists( 'is_edited_with_tatsu' ) || !is_edited_with_tatsu( get_the_ID() ) ) {
		$be_pb_class = 'be-wrap no-page-builder';
		get_template_part( 'page-breadcrumb' );
	}
?>
<section id="content" class="no-sidebar-page">
	<div id="content-wrap" class="<?php echo $be_pb_class; ?>">
		<section id="page-content">
			<div class="clearfix">
				<?php 
					if ( post_password_required() ) {
       	 				$content  = get_the_password_form();

       	 			    echo '<div class="be-wrap clearfix be-password-protect-wrap">'.$content.'</div>';
       	 			} else {
						the_content();
					}
				?>
			</div> <!--  End Page Content -->
		</section>
	</div>
</section>
<?php
if( $be_themes_data['portfolio_nav_bottom'] == true ){
	get_template_part( 'portfolio/portfolio', 'navigation' );
}
?>