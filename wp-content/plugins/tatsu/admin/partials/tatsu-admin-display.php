<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.brandexponents.com
 * @since      1.0.0
 *
 * @package    Tatsu
 * @subpackage Tatsu/admin/partials
 */


if( !function_exists( 'tatsu_settings_page' ) ){
    function tatsu_settings_page(){
		$headers = get_posts(array('post_type' => TATSU_HEADER_CPT_NAME, 'post_status' => 'publish', 'numberposts' => -1));
		$footers = get_posts(array('post_type' => TATSU_FOOTER_CPT_NAME, 'post_status' => 'publish', 'numberposts' => -1));
		$headers_list[ 'none' ] = esc_html__( 'None', 'tatsu' );
        foreach($headers as $header) {
            $headers_list[$header->post_name] = $header->post_title;
        }
		$footers_list[ 'none' ] = esc_html__( 'None', 'tatsu' );
		foreach($footers as $footer) {
			$footers_list[$footer->post_name] = $footer->post_title;
		}
		$active_header = get_option('tatsu_active_header', 'none');
		$active_footer = get_option('tatsu_active_footer', 'none');
		$tatsu_license_key = get_option( 'tatsu_license_key' );
		if(empty( $tatsu_license_key ) ) {
			$tatsu_license_key = '';
		}
		?>
		<div class="tatsu-settings_wrapper">
			<h1><?php esc_html_e('Tatsu Settings', 'tatsu'); ?></h1>
			<?php 
				if(is_tatsu_standalone()){
			?>
			<div class="tatsu_global-section-settings">
				<table  class="form-table" role="presentation">
					<tbody>
						<tr>
							<th scope="row">
								<?php
								esc_html_e( 'Instagram Access Token', 'tatsu');
								$instagram_access_token = get_theme_mod('instagram_token', '');  
								?>
								<a href="https://developers.facebook.com/docs/instagram-basic-display-api/getting-started/" target="_blank">Generate Access Token</a>
							</th>
							<td>
								<fieldset>
									<p>
										<input type="text" autocomplete="off" name="instagram_token" id="tatsu-instagram-token" class="medium-text" value="<?php echo $instagram_access_token;?>"  />
										<button id="tatsu-instagram-token-save" class="button button-primary button-large"><?php esc_html_e( 'Save Token', 'tatsu'); ?></button>
									</p>
									
									<p class="description" id="tatsu_instagram_message">
										
									</p>
								</fieldset>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<?php } ?>
			<form method="post" id="tatsu_global_section_settings_form" action="options.php">
				<?php if (current_theme_supports('tatsu-header-builder') || current_theme_supports('tatsu-footer-builder')): ?>
					<div class="tatsu_active_headers_footers_settings">
					<h3><?php esc_html_e('Headers & Footers Settings', 'tatsu'); ?></h3>
					<div id="tatsu_active_headers_footers_settings_wrap" class="tatsu_settings_wrap">
						<div class="tatsu_settings_panel">
							<div class="be-settings-page-option">
								<label class="be-settings-page-option-label"><?php esc_html_e('Active Header', 'tatsu'); ?></label>
								<select name="tatsu_active_header">
									<?php foreach ($headers_list as $key => $label) : ?>
										<option value="<?php echo $key; ?>" <?php selected($key, $active_header) ?>><?php echo $label; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="be-settings-page-option">
								<label class="be-settings-page-option-label"><?php esc_html_e('Active Footer', 'tatsu'); ?></label>
								<select name="tatsu_active_footer">
									<?php foreach ($footers_list as $key => $label) : ?>
										<option value="<?php echo $key; ?>" <?php selected($key, $active_footer) ?>><?php echo $label; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>
					</div>
				<?php endif;?>
				<textarea id="tatsu_global_Section_hidden_field" style="display:none;"  name="tatsu_global_section_data" ></textarea>
				<?php
				settings_fields('tatsu_settings');
				do_settings_sections('tatsu_settings');
				?>
			</form>
			<div class="clear"></div>
			<div class="tatsu_global-section-settings">
				<h3><?php esc_html_e('Global Section Settings', 'tatsu'); ?></h3>
				<div id="tatsu_global_section_settings_wrap" class="tatsu_settings_wrap"></div>
				<div id="tatsu_add-new-ruleset" > <?php esc_html_e('Add New Ruleset', 'tatsu'); ?> </div>
				<div class="global-section-btn-wrap" >
					<button id="tatsu_global_section_settings_submit" class="button button-primary" type="button"  > <?php esc_html_e('Save', 'tatsu'); ?> </button>
					<a id="tatsu_global_section_settings_export" class="tatsu-global-section-export" > <?php esc_html_e('Export', 'tatsu'); ?> </a>
				</div>
			</div>
		</div>
		<?php
	}
}
if( !function_exists( 'tatsu_global_section_settings_options' ) ){
    function tatsu_global_section_settings_options(){


        $title_content = '<h1> Tatsu Global Section Settings </h1>';

        echo  '<div class="tatsu_global-section-settings" > 
                '.$title_content.'
                <div id="tatsu_global_section_settings_wrap"></div>
                <div id="tatsu_add-new-ruleset" > Add New Ruleset  </div>
                <div class="global-section-btn-wrap" >
                <button id="tatsu_global_section_settings_submit" class="button button-primary" type="button"  > Save </button>
                <a id="tatsu_global_section_settings_export" class="tatsu-global-section-export" > Export </a>
                </div>
              </div>';
        ?>

        <form style="margin:20px;" method="post" id="tatsu_global_section_settings_form" action="options.php">
            <textarea id="tatsu_global_Section_hidden_field" style="display:none;"  name="tatsu_global_section_data" ></textarea>
        <?php
        settings_fields( 'tatsu_global_section_settings' );
        do_settings_sections( 'tatsu_global_section_settings' );
        

        echo '</form>';
    }
}

if( !function_exists( 'tatsu_global_section_settings_on_posts_callback' ) ) {
    function tatsu_global_section_settings_on_posts_callback( $post ){

        // Add a nonce field so we can check for it later.
        wp_nonce_field( 'tatsu_global_settings_on_post_nonce', 'tatsu_global_settings_on_post_nonce' );

        $position_values = get_post_meta(get_the_ID() , '_tatsu_global_section_on_post', true );

        $global_section_array = tatsu_get_global_sections();

        if( empty( $position_values ) ){
            $position_values = array();
        }
        $section_value_top = array_key_exists( 'top', $position_values ) ? $position_values[ 'top' ] : '';								
        $global_section_list_for_top = tatsu_get_select_box_content_post( $global_section_array, $section_value_top );

        $section_value_penultimate = array_key_exists( 'penultimate', $position_values ) ? $position_values[ 'penultimate' ] : '';			

        $global_section_list_for_penultimate = tatsu_get_select_box_content_post( $global_section_array, $section_value_penultimate );


        $section_value_bottom = array_key_exists( 'bottom', $position_values ) ? $position_values[ 'bottom' ] : '';	
        $global_section_list_for_bottom = tatsu_get_select_box_content_post( $global_section_array, $section_value_bottom );



        $title_content = '<h1> Tatsu Global Section Settings </h1>';
        
        $top_content = '<div class="be-settings-page-option" ><label class="be-settings-page-option-label" >Top</label><select name="position_top"  >'.$global_section_list_for_top.'</select></div>';
        $penultimate_content = '<div class="be-settings-page-option" ><label class="be-settings-page-option-label" title="' . esc_attr__( 'Penultimate Section appears after page content and just before Bottom Global Section.', 'tatsu' ) . '">Penultimate</label><select  name="position_penultimate"  >'.$global_section_list_for_penultimate.'</select></div>';
        $bottom_content = '<div class="be-settings-page-option" ><label class="be-settings-page-option-label" >Bottom</label><select name="position_bottom"  >'.$global_section_list_for_bottom.'</select></div>';

        echo $top_content . $penultimate_content . $bottom_content;
    }
}

if( !function_exists( 'tatsu_get_select_box_content_post' ) ) {
    function tatsu_get_select_box_content_post( $global_section_array, $position_val ){

        $temp_content = '<option value="inherit" '.( $position_val === 'inherit' ? "selected" : " "  ) .'   >Inherit</option>';
        $temp_content .= '<option value="none" '.( $position_val === 'none' ? "selected" : " "  ) .'  >None</option>';
        foreach ($global_section_array as $key => $value) {
            $temp_content .= '<option value="'.$key.'" '. ( $position_val === (string) $key ? "selected" : " "  ) .' >'.$value.'</option>';
        }
        return $temp_content;
    }
}

?>