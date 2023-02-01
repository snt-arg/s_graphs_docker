<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is use for Tatsu form settings.
 *
 * @link       http://www.brandexponents.com
 * @since      3.3.2
 *
 * @package    Tatsu
 * @subpackage Tatsu/admin/partials
 */

if( !function_exists( 'tatsu_form_settings' ) ){
    function tatsu_form_settings(){
    
    $tatsu_recaptcha_settings = get_option( 
        'tatsu_form_recaptcha_settings',
        array(
            'recaptcha_type'=>'v3',
            'site_key'=>'',
            'secret_key'=>''
        ));
?>
<div class="tatsu-admin-card">
    <h1><?php esc_html_e('Tatsu form settings', 'tatsu'); ?></h1>
</div>
<div class="tatsu-admin-card tatsu-col-6">
    <h3><?php esc_html_e('reCAPTCHA Integration', 'tatsu'); ?></h3>
    <p>reCAPTCHA v3 and v2 help you protect your sites from fraudulent activities, spam, and abuse. By using this integration in your tatsu forms, you can block spam form submissions. For more details, see <a href="https://developers.google.com/recaptcha/intro" target="_blank">reCAPTCHA</a></p>
    <form method="post" id="recaptcha-integration-form" class="be-forms" action="<?php echo esc_html( admin_url( 'admin.php?page=tatsu-forms-settings' ) ); ?>" >
        <div class="">
            <fieldset class="form-fields">
                <legend>reCAPTCHA Type<span class="required-field">*</span></legend>
                <div class="radio-inline">
                    <input type="radio" name="recaptcha_type" class="form-input radio recaptcha-type-v3" value="v3" <?php echo ($tatsu_recaptcha_settings['recaptcha_type']=='v3')?"checked":''; ?> />
                    <label for="recaptcha-type-v3">v3</label>
                    
                    <input type="radio" name="recaptcha_type" class="form-input radio recaptcha-type-v2" value="v2" <?php echo ($tatsu_recaptcha_settings['recaptcha_type']=='v2')?"checked":'';  ?> />
                    <label for="recaptcha-type-v2" >v2</label>
                </div>
            </fieldset>
            <fieldset class="form-fields">
                <legend>Site Key<span class="required-field">*</span></legend>
                <input type="text" name="site_key" class="form-input" value="<?php echo $tatsu_recaptcha_settings['site_key']; ?>" required />
            </fieldset>
            <fieldset class="form-fields">
                <legend>Secret key<span class="required-field">*</span></legend>
                <input type="text" name="secret_key" class="form-input" value="<?php echo $tatsu_recaptcha_settings['secret_key']; ?>" required />
            </fieldset>
            <fieldset class="form-fields">
                <div class="tatsu-form-response"></div>
                <p class="submit">
                    <input type="submit" name="submit"  class="button button-primary" value="Save Changes">
                </p>
            </fieldset>
        </div>
    </form>
</div>
<?php
    }
}


?>