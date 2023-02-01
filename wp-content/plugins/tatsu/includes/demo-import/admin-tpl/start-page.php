<header class="be-start-header be-dashboard">
   	<div class="header-wrapper clearfix">
		<div class="c-3">
			<div class="theme_preview">
				<img height="180" src="<?php echo TATSU_PLUGIN_URL.'/img/tatsu.png'; ?>">
				<span class="ves"><?php echo TATSU_VERSION; ?></span>
			</div>
		</div>
		<div class="c-9">
			<h1><?php esc_html_e( 'Welcome to Tatsu', 'tatsu' ); ?></h1>
			<p><?php esc_html_e( 'You are using Tatsu for WordPress, a super fast page builder built for convenience & high conversion websites.', 'tatsu' );
			//_e('Thank you for using Tatsu Website Builder. From header to footer, build your website using a fully visual interface. Its super easy for beginners to get started and super powerful for pros. If you can imagine it, you can build it','tatsu'); 
			?>.</p>
			<span id="tatsu-home-url" style="display:none;"><?php echo esc_url( home_url() ); ?></span>
		</div>
	</div>
</header>

<section class="be-start-content be-dashboard">
	<div class="ts-row">
		<div class="ts-column ts-left">
			<h2 class="nav-tab-wrapper">
				<a href="#" data-tab="be-news" class="nav-tab nav-tab-active"><?php esc_html_e( 'Getting Started', 'tatsu' ); ?></a>
				<?php if(is_tatsu_pro_active()){ ?>
					<a href="#" data-tab="be-welcome" class="nav-tab"><?php esc_html_e( 'License', 'tatsu' ); ?></a>
				<?php } ?>
				<a href="#" class="nav-tab" data-tab="be-system-stat"><?php esc_html_e( 'System Status', 'tatsu' ); ?></a>
				<?php //do_action( 'be_start_tabs' ); ?>
			</h2>
			<div class="notifyjs"></div>
			<div class="nav-content current" id="be-news">
				<h2><?php esc_html_e('Thank you for choosing Tatsu','tatsu');?>!</h2>
				<p><?php esc_html_e( 'Tatsu comes loaded with 50 free modules and 2 demo sites which you import for free.', 'tatsu' ); ?></p>
				<h3><?php esc_html_e('Quick Actions','tatsu');?></h3>
				<p>
					<ul>
						<li><?php esc_html_e( 'Create Tatsu Page', 'tatsu' ) ?> <a href="<?php echo tatsu_create_new_post_url(); ?>">View</a></li>
						<li><?php esc_html_e( 'Header Builder', 'tatsu' ) ?> <a href="<?php echo tatsu_header_builder_url(); ?>">View</a></li>
						<li><?php esc_html_e( 'Footer Builder', 'tatsu' ) ?> <a href="<?php echo tatsu_footer_builder_url(); ?>">View</a></li>
						<li><?php esc_html_e( 'Tatsu Settings', 'tatsu' ) ?> <a href="<?php echo admin_url('admin.php?page=tatsu_global_settings'); ?>">View</a></li>
						<li><?php esc_html_e( 'Import Demo', 'tatsu' ) ?> 
						<?php if(is_tatsu_standalone()){ ?>
							<a href="<?php echo admin_url('admin.php?page=tatsu_demo_import'); ?>">View</a>
						<?php }else{ ?>
						<a href="<?php echo admin_url('themes.php?page=be_register#be-import'); ?>">View</a>
						<?php }?>
					</ul>
				</p>
				<?php //do_action( 'be_welcome_content' ); ?>
			</div>

			<!-- /**** TATSU LICENSE : START **********/ -->
			<?php if(is_tatsu_pro_active()) { ?>
				<div class="nav-content" id="be-welcome">
					<div class="token_check"></div>
					<form id="tatsu_pro_start_updater" method="post" action="options.php">
						<?php $be_purchase_code = get_option('tatsu_license_key', ''); ?>
						<!-- tatsu license key -->
						<div class="be-purchase-code">
							<h2>Tatsu License Key</h2>
							<input type="text" id="be_purchase_code" size="30" name="be_purchase_code" value="<?php echo esc_attr($be_purchase_code); ?>" class="widefat" style="padding: 9px 15px;" />
							<div>
								<p class=""><strong><?php esc_html_e( 'Please enter your tatsu license key to allow automatic updates.', 'tatsu' ); ?></strong></p>
								<?php wp_nonce_field( 'be_save_purchase_code', 'purchase_nonce', true ); ?>
								<!-- <p class="be-admin-accordion"><strong>Where can I find the license key?</strong></p>
								<p class="be-admin-accordion-panel">To locate your license key you need to log into the ThemeForest account from which you purchase the theme and go to your "Downloads" page.

								Click on the Download button next to the theme and then on the "License Certificate & license key" link. You can find the license key inside the downloaded license certificate.</p> -->
							</div>
						</div>
						<!--Subscribe newsletter -->
						<div class="be-admin-newsletter">
							<h2>Subscribe newsletter</h2>
							<?php 
								$be_newsletter_email = get_option('tatsu_newsletter_email', '');
								if(empty($be_newsletter_email)){
									$be_newsletter_email =	get_bloginfo('admin_email');
								}
							?>
							<input type="text" id="be-newsletter-email" size="30" name="be-newsletter-email" value="<?php echo esc_attr($be_newsletter_email); ?>" class="widefat" style="padding: 9px 15px;" />
							<?php wp_nonce_field( 'subscribe_checker', 'be-newsletter-email-nonce', true ); ?>
							<div>
								<p class="be-admin-accordion"><strong><?php esc_html_e( 'More Info ?', 'tatsu' ); ?></strong></p>
								<p class="be-admin-accordion-panel"><?php esc_html_e( 'We constantly update our products with new features and bug fixes. We need a way to reach out to you regarding these updates. Get update notifications with details on what was changed or added. Know how to use the new features and learn about special instructions for certain updates. A smoother experience for you and less support for us. Occasionally we send mailers about our product promotions that helps you save money on new licenses or support renewals.  We hate spam as much as you do and your details are never shared with any 3rd party.', 'tatsu' ); ?></p>
							</div>	
						</div>
						<?php submit_button( esc_html__( 'Submit', 'tatsu' ), 'primary', 'submit', true, null ); ?>
					</form>
					<?php do_action( 'tatsu_license_tpl' ); ?>
				</div>
			<?php } ?>
			<!-- /**** TATSU LICENSE : END **********/ -->

			<div class="nav-content" id="be-system-stat">
				<?php do_action( 'tatsu_systatus_tpl' ); ?>
			</div>
			<?php //do_action( 'exp_tabs_content' ); ?>
		</div>
  		<div class="ts-column ts-right">
		  	<?php if(!is_tatsu_pro_active()) { ?>
				<div class="ts-upgrade-content">
					<h2><?php esc_html_e( 'Upgrade to Tatsu Pro', 'tatsu' ); ?></h2>
					<p><?php esc_html_e( 'You are using the free version of Tatsu which comes pre-installed with our official themes - Oshine, Exponent and Spyro, each of these themes installs some "pro" modules along with it for advance design & functionality.', 'tatsu' ); ?></p>
					<p><?php esc_html_e( 'Optionally, you can upgrade Tatsu to "Tatsu Pro" which will unlock all the "pro" modules without needing of any of our themes. Also, Tatsu Pro comes with growing list of pre-built demos and can work with any theme of your choice.', 'tatsu' ); ?></p>
					<h4><?php esc_html_e( 'Upgrade today to get 10% discount on the yearly price', 'tatsu' ); ?>:</h4>
					<ul>
						<li><?php esc_html_e( 'Pre-built Demo', 'tatsu' ); ?>s</li>
						<li><?php esc_html_e( '50+ Pro Modules', 'tatsu' ); ?></li>
						<li><?php esc_html_e( 'Typehub & Colorhub Pro options', 'tatsu' ); ?></li>
						<li><?php esc_html_e( 'BE GDPR & BE GRID plugins', 'tatsu' ); ?></li>
					</ul>
					<a class="ts-upgrade-btn" href="https://tatsubuilder.com?utm_source=tatsu_sidebar" target="_blank"><?php esc_html_e( 'Upgrade to Tatsu Pro', 'tatsu' ); ?></a>
				</div>
			<?php } ?>
		</div>
	</div>
</section>
<div class="loader"><span class="circle"></span></div>