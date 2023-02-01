<?php
global $BECore;
?>
<?php 
$available_updates = '';
if(isset($_GET) && !empty($_GET['be_check_theme_update'])){
	$available_updates = be_themecheck_for_updates();
}

?>
<header class="be-start-header">
   <div class="header-wrapper clearfix">
    <div class="c-3">
    	<?php $themeinfo = wp_get_theme(); ?>
    	<div class="theme_preview">
    	<img height="180" src="<?php echo esc_url( $themeinfo->get_screenshot() ); ?>">
    	<span class="ves"><?php echo esc_html( $themeinfo->get('Version') ); ?></span>
    	</div>
    </div>
    <div class="c-9"><h1><?php esc_html_e( 'Welcome to ', 'oshin' ); ?><?php echo esc_html( ucfirst( $BECore['themeName'] ) ); ?></h1>
<p>Thanks for purchasing and using <?php echo esc_html( ucfirst( $BECore['themeName'] ) ); ?>. Get started by installing all the required and recommended plugins and import a demo of your choice. <?php if( !defined('ENVATO_HOSTED_SITE')  ) : ?> Register your license and enjoy automatic theme updates. To learn more about the theme and its features, checkout our <a href="<?php echo esc_html($BECore['documentation']); ?>" target="_blank">online knowledgebase.</a><?php endif; ?><br /><a href="<?php echo admin_url('themes.php?page=be_register&be_check_theme_update=1#be-welcome'); ?>">Check for updates</a> <span><?php echo empty($available_updates)?'':'Available version '.$available_updates; ?></span></p>
	<span id="oshine-home-url" style="display:none;">
	<?php 
		echo esc_url( home_url() );		 
	?>
	</span>
    </div>
   </div>
	
</header>

<section class="be-start-content">

	<h2 class="nav-tab-wrapper">
	<a href="#" data-tab="be-news" class="nav-tab nav-tab-active"><?php esc_html_e( 'Getting Started', 'oshin' ); ?></a>
		<?php if( !defined('ENVATO_HOSTED_SITE')  ) : ?>
		<a href="#" data-tab="be-welcome" class="nav-tab"><?php esc_html_e( 'License', 'oshin' ); ?></a>
		<?php endif; ?>
		<a href="#" data-tab="be-plugins" class="nav-tab"><?php esc_html_e( 'Install Plugins', 'oshin' ); ?></a>
		<a href="#" data-tab="be-import" class="nav-tab"><?php esc_html_e( 'Import', 'oshin' ); ?></a>
		<?php if( !defined('ENVATO_HOSTED_SITE')  ) : ?>
		<a href="#" class="nav-tab" data-tab="be-system-stat"><?php esc_html_e( 'System Status', 'oshin' ); ?></a>
		<?php endif; ?>
		<?php do_action( 'be_start_tabs' ); ?>
	</h2>
	<div class="notifyjs"></div>
	<div class="nav-content current" id="be-news">
	<h2>Thank you for choosing <strong><?php echo esc_html( $BECore['themeName'] ); ?>!</strong></h2>
	<p><?php esc_html_e( 'Getting started with Oshine is pretty simple, just follow the steps below:', 'oshin' ); ?>
	<ol>
		<?php if( !defined('ENVATO_HOSTED_SITE')  ) : ?>
		<li><?php esc_html_e( 'Register your purchase by going to ', 'oshin' ); ?><a data-tab="be-welcome" href="#"><?php esc_html_e('License Tab', 'oshin' ) ?></a></li>
		<?php endif; ?>
		<li><?php esc_html_e( 'Install & Activate Recommended and Required Plugins ', 'oshin' ); ?><a href="#" data-tab="be-plugins">Install Plugins</a></li>
		<li><?php esc_html_e( 'Import a demo of your choice from the ', 'oshin' ) ?><a data-tab="be-import" href="#">Import</a> tab</li>
		<li><?php esc_html_e( 'That\'s it! Start Building your Website', 'oshin' ); ?></li>
	</ol>
	</p>
	<?php do_action( 'be_welcome_content' ); ?>
	</div>

<?php if( !defined('ENVATO_HOSTED_SITE')  ) : ?>
	<div class="nav-content" id="be-welcome">
		<div class="token_check">
		<?php 
		// if(BEUpdater::theme_found() === true) {
		// 	echo BEUpdater::matched_token();
		// }
		?>
		<?php //Check for valid license
			$invalid_theme_notice = '';
			if(!be_is_theme_valid()){
				$invalid_theme_notice = oshin_theme_update_notice(true);
				if(empty($invalid_theme_notice)){
					$invalid_theme_notice = '<h3 class="be-error-msg">Please provide a valid <a href="#" data-tab="be-welcome">purchase code</a> of the theme in order to install plugins and import demo</h3>';
				}else{
					echo $invalid_theme_notice;
				}

				if(!empty($_GET['beerrormsg']) && $_GET['beerrormsg'] == "no-pc-plugin-update"){
					echo '<h3 class="be-error-msg">Please provide a valid <a href="#be-welcome">purchase code</a> of the theme in order to activate 1-click updates</h3>';
				}
			}
		?>
		</div>
		<form id="be_start_updater" method="post" action="options.php">
			<?php 
			//settings_fields( BEUpdater::options_group_name() );
			$be_purchase_data = get_option( 'be_themes_purchase_data', '' );
			$be_purchase_code = '';
			if ( ! empty( $be_purchase_data ) && !empty( $be_purchase_data['theme_purchase_code'] ) ) {
				$be_purchase_code = trim( $be_purchase_data['theme_purchase_code'] );
			}		
			?>
			<!-- theme purchase code -->
			<div class="be-purchase-code">
				<h2>Theme Purchase Code</h2>
				<input type="text" id="be_purchase_code" size="30" name="be_purchase_code" <?php echo ( be_is_theme_valid() ) ? 'readonly' : ''; ?> value="<?php echo esc_attr( $be_purchase_code ); ?>" class="widefat" style="padding: 10px 15px;" />
				<?php wp_nonce_field( 'be_save_purchase_code', 'purchase_nonce' ); ?>
				<div>
					<p class=""><strong><?php esc_html_e( 'Please enter your theme purchase code to allow automatic updates', 'oshin' ); ?></strong></p>
					<p class="be-admin-accordion"><strong>Where can I find the purchase code ?</strong></p>
					<p class="be-admin-accordion-panel">To locate your purchase code you need to log into the ThemeForest account from which you purchase the theme and go to your "Downloads" page. Click on the Download button next to the theme and then on the "License Certificate & Purchase code" link. You can find the purchase code inside the downloaded license certificate.</p>
				</div>
			</div>
			<!--Subscribe newsletter -->
			<div class="be-admin-newsletter">
				<h2>Subscribe Newsletter</h2>
				<?php 
					$be_newsletter_email = get_option( 'oshine_newsletter_email', get_bloginfo( 'admin_email' ) );
					if ( empty( $be_newsletter_email ) ) {
						$be_newsletter_email = get_bloginfo( 'admin_email' );
					}
				?>
				<input type="email" id="be-newsletter-email" size="30" name="be-newsletter-email" value="<?php echo esc_attr( $be_newsletter_email ); ?>" class="widefat" style="padding: 10px 15px;" />
				<?php wp_nonce_field( 'subscribe_checker', 'be-newsletter-email-nonce' ); ?>
				<div>
					<p class="be-admin-accordion"><strong>More Info ?</strong></p>
					<p class="be-admin-accordion-panel">We constantly update our products with new features and bug fixes. We need a way to reach out to you regarding these updates. Get update notifications with details on what was changed or added. Know how to use the new features and learn about special instructions for certain updates. A smoother experience for you and less support for us. Occasionally we send mailers about our product promotions that helps you save money on new licenses or support renewals.  We hate spam as much as you do and your details are never shared with any 3rd party.
					</p>
				</div>	
			</div>
			<?php
				if ( ! be_is_theme_valid() ) {
					submit_button( esc_html__( 'Submit', 'oshin' ), 'primary', 'submit' );
				} else { ?>
					<p class="submit"><input type="button" id="deactivate-license" class="button button-primary" data-license-key="<?php echo esc_attr( $be_purchase_code ); ?>" value="Deactivate License"></p>
				<?php }
			?>
		</form>
		<?php do_action( 'be_license_tpl' ); ?>
	</div>
<?php endif; ?>	

	<div class="nav-content" id="be-import">
		<?php
		if(!empty($invalid_theme_notice)){
			echo $invalid_theme_notice;
		}else{
			do_action( 'be_import_tpl' );
		}
		?>
	</div>

<?php if( !defined('ENVATO_HOSTED_SITE')  ) : ?>
	<div class="nav-content" id="be-system-stat">
		<?php
		do_action( 'be_systatus_tpl' );
		?>
	</div>
<?php endif; ?>
	<div class="nav-content" id="be-plugins">
	<?php
	if(!empty($invalid_theme_notice)){
		echo $invalid_theme_notice;
	}else{
		BE_get_Plugins()->envato_setup_default_plugins(); 
	}
	?>
	</div>
	<?php do_action( 'be_tabs_content' ); ?>
</section>
<div class="loader"><span class="circle"></span></div>