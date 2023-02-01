<?php
/**
 * Represents the view for slider panel.
 *
 * @package   MasterSlider
 * @author    averta [averta.net]
 * @license   LICENSE.txt
 * @link      http://masterslider.com
 * @copyright Copyright © 2015 averta
 */

?>

<!-- markup for slider panel page here. -->
<div id="msp-header">
    <div class="msp-logo"><a href="?page=masterslider"><img src="<?php echo MSWP_AVERTA_ADMIN_URL . '/views/slider-panel'; ?>/images/masterslider.gif" ></a></div>
</div>
<div id="panelLoading" class="msp-loading">
    <img src="<?php echo MSWP_AVERTA_ADMIN_URL . '/views/slider-panel'; ?>/images/loading.gif">
    <?php _e('Loading data...', MSWP_TEXT_DOMAIN); ?>
</div>
<div id="msp-root" class="msp-container"> </div>
<div id="mspHiddenEditor" style="display:none">
    <?php wp_editor( '', 'msp-hidden' , array( 'textarea_rows' => 8 ) );  ?>
</div>

<!-- Application Template -->
<script type="text/x-handlebars">

    {{#if hasError}}
        <div class="msp-error-cont">
            {{partial errorTemplate}}
        </div>
    {{else}}
        <nav class="msp-main-nav">
            <ul>
                <li>{{#link-to 'settings'}} <?php _e('Slider Settings', MSWP_TEXT_DOMAIN); ?> <span class="msp-ico msp-ico-settings"></span>{{/link-to}}</li>
                {{#if isFlickr }}<li>{{#link-to 'flickr'}} <?php _e('Flickr Settings', MSWP_TEXT_DOMAIN); ?> <span class="msp-ico msp-ico-flickr"></span>{{/link-to}}</li>{{/if}}
                {{#if isFacebook }}<li>{{#link-to 'facebook'}} <?php _e('Facebook Settings', MSWP_TEXT_DOMAIN); ?> <span class="msp-ico msp-ico-facebook"></span>{{/link-to}}</li>{{/if}}
                {{#if isPost }}<li>{{#link-to 'post'}} <?php _e('Posts Settings', MSWP_TEXT_DOMAIN); ?> <span class="msp-ico msp-ico-posts"></span>{{/link-to}}</li>{{/if}}
                {{#if isWcproduct }}<li>{{#link-to 'wcproduct'}} <?php _e('Product Slider Settings', MSWP_TEXT_DOMAIN); ?> <span class="msp-ico msp-ico-wooc"></span>{{/link-to}}</li>{{/if}}
                <li>{{#link-to 'slides'}} <?php _e('Slides', MSWP_TEXT_DOMAIN); ?> <span class="msp-ico msp-ico-slides"></span>{{/link-to}}</li>
                <li>{{#link-to 'controls'}} <?php _e('Slider Controls', MSWP_TEXT_DOMAIN); ?> <span class="msp-ico msp-ico-controls"></span>{{/link-to}}</li>
                <li>{{#link-to 'callbacks'}} <?php _e('Slider Callbacks', MSWP_TEXT_DOMAIN); ?> <span class="msp-ico msp-ico-api"></span>{{/link-to}}</li>
            </ul>
        </nav>
        <div class="clear"></div>
        <div class="msp-main-container">
        {{outlet}}
        </div>
        <div class="msp-shortcode-cont">
            <span><?php _e('Shortcode :', MSWP_TEXT_DOMAIN); ?> </span>
            {{view MSPanel.SimpleCodeBlock value=shortCode width=120}}
            {{view MSPanel.SimpleCodeBlock value=shortCodeSlug width=120}}
            <span><?php _e('PHP function :', MSWP_TEXT_DOMAIN); ?> </span>
            {{view MSPanel.SimpleCodeBlock value=phpFunction width=160}}
            {{view MSPanel.SimpleCodeBlock value=phpFunctionSlug width=160}}
        </div>
        <div class="msp-save-bar-placeholder" id="saveBarPlaceHolder"></div>
        <div class="msp-save-bar" id="saveBar">
            <button id="msp-preview-btn" {{action showPreview}} class="msp-blue-btn msp-save-changes"> <?php _e('Preview', MSWP_TEXT_DOMAIN); ?></button>
            {{#if isSending}}
                <button class="msp-blue-btn msp-save-changes disabled"> <?php _e('Saving...', MSWP_TEXT_DOMAIN); ?></button>
            {{else}}
                <button class="msp-blue-btn msp-save-changes" {{action "saveAll"}}> <?php _e('Save Changes', MSWP_TEXT_DOMAIN); ?></button>
            {{/if}}
            <div class="msp-saving-msg-cont">
                <span {{bind-attr class=":msp-save-status savingStatus"}}>{{statusMsg}}</span>
                <div {{bind-attr class=":msp-time-ago savingStatus"}}><?php _e('Saved', MSWP_TEXT_DOMAIN); ?> <span  id="timeAgo"></span>.</div>
            </div>
        </div>
    {{/if}}
</script>

<!-- woocommers no installed error -->
<script type="text/x-handlebars" id="wooc-error">
    <h3><?php _e('Ooops! It seems Woocommers plugin is not installed.', MSWP_TEXT_DOMAIN); ?> </h3>
    <p>
        <?php _e('This type of slider requires the Woocommers plugin. ', MSWP_TEXT_DOMAIN); ?>
        <a {{bind-attr href=wooLink}} > <?php _e('Please install and activate it first.', MSWP_TEXT_DOMAIN); ?> </a>
    </p>
</script>
<!-- Slider Settings Page -->
<script type="text/x-handlebars" id="settings">

    {{#meta-box title="<?php _e('General Settings', MSWP_TEXT_DOMAIN); ?>"}}

        <div class="msp-metabox-row">

            <h4><?php _e('Slider name and dimensions', MSWP_TEXT_DOMAIN); ?></h4>

            <div class="msp-metabox-indented">
                <label><?php _e('Slider name :', MSWP_TEXT_DOMAIN); ?> </label> {{input value=name size="40"}}
            </div>
            <div class="msp-metabox-indented">
                <label><?php _e('Slider alias :', MSWP_TEXT_DOMAIN); ?> </label> {{input value=slug action="checkSliderSlug" on="focus-out" size="40"}}
                <span {{bind-attr class=":msp-save-status slugStatus"}}></span>
            </div>
            <div class="msp-metabox-indented">
                 <label><?php _e('Slider width :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=width}} px
                <span class="msp-form-space"></span>
                <label><?php _e('Slider height :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=height}} px
            </div>

            <div class="msp-metabox-indented">
                {{switch-box value=responsiveSize}}<label><?php _e('Custom responsive size', MSWP_TEXT_DOMAIN); ?></label>
            </div>

            {{#if responsiveSize}}
            <div class="msp-metabox-indented">
                 <label><?php _e('Tablet width :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=tabletWidth}} px
                <span class="msp-form-space"></span>
                <label><?php _e('Tablet height :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=tabletHeight}} px
            </div>
            <div class="msp-metabox-indented">
                 <label><?php _e('Phone width :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=phoneWidth}} px
                <span class="msp-form-space"></span>
                <label><?php _e('Phone height :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=phoneHeight}} px
            </div>
            {{/if}}
            <div class="msp-metabox-indented">
               {{switch-box value=autoCrop}}<label><?php _e('Automatically crop and resize slider images based on the size above.', MSWP_TEXT_DOMAIN); ?></label>
            </div>

            <h4><?php _e('Slider sizing method', MSWP_TEXT_DOMAIN); ?></h4>

            <div class="msp-metabox-indented">
                {{#view MSPanel.Select value=layout width="400" }}
                    <option value="boxed"><?php _e('Boxed layout', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="fullwidth"><?php _e('Full-width', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="fullscreen"><?php _e('Full-screen', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="fillwidth"><?php _e('Auto size width to fill slider parent element', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="autofill"><?php _e('Auto size width and height to fill slider parent element', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="partialview"><?php _e('Boxed and visible nearby slides', MSWP_TEXT_DOMAIN); ?></option>
                {{/view}}
                {{#if showAutoHeight}}
                    <span class="msp-form-space"></span>
                    {{switch-box value=autoHeight}}<label><?php _e('Auto-height slider', MSWP_TEXT_DOMAIN); ?></label>
                {{/if}}
                {{#if showFSMargin}}
                    <span class="msp-form-space"></span>
                    <label><?php _e('Fullscreen margin :', MSWP_TEXT_DOMAIN); ?> </label>{{number-input value=fullscreenMargin}} px
                {{/if}}
            </div>
            {{#if showAutoFillTarget}}
                <div class="msp-metabox-indented">
                    <label><?php _e('Auto fill to element :', MSWP_TEXT_DOMAIN); ?> </label>{{input value=autofillTarget}} <em> Default is parent element of slider.</em>
                </div>
            {{/if}}
            {{#if showMinHeight}}
                <div class="msp-metabox-indented">
                    <label><?php _e('Minimum height amount :', MSWP_TEXT_DOMAIN); ?> </label>{{number-input value=minHeight}} px
                </div>
            {{/if}}
            {{#if showWrapperWidth}}
               <div class="msp-metabox-indented">
                    <label><?php _e('Slider wrapper width :', MSWP_TEXT_DOMAIN); ?> </label>{{number-input value=wrapperWidth}}
                    {{#view MSPanel.Select value=wrapperWidthUnit width="40" }}
                        <option value="px">px</option>
                        <option value="%">%</option>
                    {{/view}}
                </div>
            {{/if}}

        </div>

    {{/meta-box}}

    {{#meta-box title="<?php _e('Slider Template', MSWP_TEXT_DOMAIN); ?>"}}
        <div class="msp-metabox-row">
            <h4><?php _e('Select slider template here, click on "Choose template" for the list of all templates.', MSWP_TEXT_DOMAIN); ?></h4>
            <div class="msp-metabox-indented">
                <label><?php _e('Template:', MSWP_TEXT_DOMAIN); ?> </label>
                <div class="msp-choose-template">
                    <div class="msp-img-box"><img {{action "openTemplates"}} {{bind-attr src=msTemplateImg}}></div>
                        <div class="float-left">
                            <span class="msp-template-name">{{msTemplateName}}</span>
                            <button {{action "openTemplates"}} class="msp-blue-btn msp-blue-medium-btn"><?php _e('Choose template', MSWP_TEXT_DOMAIN); ?></button>
                        </div>
                </div>
            </div>
            <h4><?php _e('Change slider transition, transition speed and spacing between slides', MSWP_TEXT_DOMAIN); ?></h4>

            <div class="msp-metabox-indented">
                <label><?php _e('Transition :', MSWP_TEXT_DOMAIN); ?> </label>
                {{#view MSPanel.Select value=trView width=150}}
                    <option value="basic">Normal</option>
                    <option value="fadeBasic">Normal and Fade</option>
                    <option value="wave">Wave</option>
                    <option value="fadeWave">Wave and Fade</option>
                    <option value="flow">Flow</option>
                    <option value="stack">Stack</option>
                    <option value="fadeFlow">Flow and Fade</option>
                    <option value="mask">Mask</option>
                    <option value="parallaxMask">Parallax Mask</option>
                    <option value="box">Box</option>
                    <option value="fade">Fade</option>
                    <option value="scale">Scale</option>
                    <option value="focus">Focus</option>
                    <option value="partialWave">Partial View Wave</option>
                {{/view}}
                <span class="msp-form-space"></span>
                <label><?php _e('Transition speed :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=speed}}
            </div>
            <div class="msp-metabox-indented">
                <label><?php _e('Direction :', MSWP_TEXT_DOMAIN); ?> </label>
                {{#view MSPanel.Select value=dir width="120"}}
                    <option value="h"><?php _e('Horizontal', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="v"><?php _e('Vertical', MSWP_TEXT_DOMAIN); ?></option>
                {{/view}}
                <span class="msp-form-space"></span>
                <label><?php _e('Slide spacing :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=space}} px
            </div>
        </div>
    {{/meta-box}}


    {{#meta-box title="<?php _e('Navigation', MSWP_TEXT_DOMAIN); ?>"}}

        <div class="msp-metabox-row">
            <h4><?php _e('Slideshow behavior and sorting slides', MSWP_TEXT_DOMAIN); ?></h4>
            <div class="msp-metabox-indented">
                {{switch-box value=autoplay}}<label><?php _e('Autoplay (Slideshow)', MSWP_TEXT_DOMAIN); ?></label>
                <span class="msp-form-space"></span>
                {{switch-box value=loop}}<label><?php _e('Loop navigation', MSWP_TEXT_DOMAIN); ?> </label>
                <span class="msp-form-space"></span>
                {{switch-box value=endPause}}<label><?php _e('Pause at the final slide', MSWP_TEXT_DOMAIN); ?></label>
            </div>
            <div class="msp-metabox-indented">
                {{switch-box value=overPause}}<label><?php _e('Pause on hover', MSWP_TEXT_DOMAIN); ?></label>
                <span class="msp-form-space"></span>
                {{switch-box value=shuffle}}<label><?php _e('Random order', MSWP_TEXT_DOMAIN); ?></label>
                <span class="msp-form-space"></span>
                {{switch-box value=hideLayers}}<label><?php _e('Hide layers before changing slide', MSWP_TEXT_DOMAIN); ?></label>
            </div>
            <div class="msp-metabox-indented">
               {{switch-box value=instantShowLayers}}<label><?php _e('Show layers before the slide transition is complete', MSWP_TEXT_DOMAIN); ?></label>
            </div>
            <div class="msp-metabox-indented">
               {{switch-box value=mobileBGVideo}}<label><?php _e('Show background video in mobile devices (Not recommended)', MSWP_TEXT_DOMAIN); ?></label>
            </div>
            <div class="msp-metabox-indented">
                <label><?php _e('Start with slide :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=start min=1}}
            </div>
            <h4><?php _e('Slider deep linking options' , MSWP_TEXT_DOMAIN); ?></h4>
            <div class="msp-metabox-indented">
                {{switch-box value=useDeepLink}}<label><?php _e('Enable slider deep linking.', MSWP_TEXT_DOMAIN); ?></label>
            </div>
            {{#if useDeepLink}}
                 <div class="msp-metabox-indented">
                    <label><?php _e('Deeplink name :', MSWP_TEXT_DOMAIN); ?> </label> {{input value=deepLink}}
                    <div class="msp-form-space-med"></div>
                    <label><?php _e('Type of permalink: ', MSWP_TEXT_DOMAIN); ?> </label>
                    {{#dropdwon-List value=deepLinkType width=250}}
                        <option value="path"><?php _e('URL path style (/name/index/)', MSWP_TEXT_DOMAIN); ?></option>
                        <option value="query"><?php _e('Query string style (&name=index)', MSWP_TEXT_DOMAIN); ?></option>
                    {{/dropdwon-List}}
                </div>
            {{/if}}
            <h4><?php _e('Layers parallax mode', MSWP_TEXT_DOMAIN); ?></h4>
            <div class="msp-metabox-indented">
                <label><?php _e('Parallax mode : ', MSWP_TEXT_DOMAIN); ?> </label>
                {{#dropdwon-List value=parallaxMode width=200}}
                    <option value="swipe"><?php _e('Move while sliding/swiping', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="mouse"><?php _e('Follow mouse', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="mouse:x-only"><?php _e('Follow mouse over X-axis', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="mouse:y-only"><?php _e('Follow mouse over Y-axis', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="off"><?php _e('Disable', MSWP_TEXT_DOMAIN); ?></option>
                {{/dropdwon-List}}
            </div>
            <h4><?php _e('Parallax move and fade layers when slider leaves page by scrolling', MSWP_TEXT_DOMAIN); ?></h4>
            <div class="msp-metabox-indented">
                {{switch-box value=scrollParallax}}<label><?php _e('Scrolling parallax effect', MSWP_TEXT_DOMAIN); ?> </label>
            </div>
            {{#if scrollParallax}}
                <div class="msp-metabox-indented">
                    <label><?php _e('Layers parallax depth percentage :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=scrollParallaxMove min=0}} %
                    <span class="msp-form-space"></span>
                    <label><?php _e('Background parallax depth percentage :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=scrollParallaxBGMove min=0}} %
                </div>
                <div class="msp-metabox-indented">
                    {{switch-box value=scrollParallaxFade}}<label><?php _e('Fade layers while scrolling.', MSWP_TEXT_DOMAIN); ?> </label>
                </div>
            {{/if}}
            <h4><?php _e('Slider navigation methods', MSWP_TEXT_DOMAIN); ?></h4>
            <div class="msp-metabox-indented">
                {{switch-box value=swipe}}<label><?php _e('Touch swipe navigation', MSWP_TEXT_DOMAIN); ?></label>
                <span class="msp-form-space"></span>
                {{switch-box value=mouse}}<label><?php _e('Mouse swipe navigation', MSWP_TEXT_DOMAIN); ?></label>
                <span class="msp-form-space"></span>
                {{switch-box value=grabCursor}}<label><?php _e('Use grab mouse cursor', MSWP_TEXT_DOMAIN); ?></label>
            </div>
            <div class="msp-metabox-indented">
                {{switch-box value=wheel}}<label><?php _e('Mouse wheel navigation', MSWP_TEXT_DOMAIN); ?></label>
                <span class="msp-form-space"></span>
                {{switch-box value=keyboard}}<label><?php _e('Keyboard navigation', MSWP_TEXT_DOMAIN); ?></label>
            </div>
            <div class="msp-metabox-indented">
                {{switch-box value=startOnAppear}}<label><?php _e('Start slider when appears in browser window.', MSWP_TEXT_DOMAIN); ?></label>
            </div>
            <h4><?php _e('Slide preloading', MSWP_TEXT_DOMAIN); ?></h4>
            <div class="msp-metabox-indented">
                {{#view MSPanel.Select value=preloadMethod width="200" }}
                    <option value="nearby"><?php _e('Load nearby slides', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="-1"><?php _e('Load slides in sequence', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="all"><?php _e('Load all slides before init', MSWP_TEXT_DOMAIN); ?></option>
                {{/view}}
                {{#if showNearbyNum}}
                    <span class="msp-form-space"></span>
                   <?php _e('Number of slides :', MSWP_TEXT_DOMAIN); ?> {{number-input value=preload }}
                {{/if}}
            </div>
        </div>

    {{/meta-box}}

    {{#meta-box title="<?php _e('Appearance', MSWP_TEXT_DOMAIN); ?>"}}

        <div class="msp-metabox-row">
            <h4><?php _e('Slider Skin', MSWP_TEXT_DOMAIN); ?></h4>
            <div class="msp-metabox-indented">
                <label><?php _e('Skin :', MSWP_TEXT_DOMAIN); ?> </label>
                {{#dropdwon-List value=skin width=180}}
                    {{#each skin in sliderSkins}}
                        <option {{bind-attr value=skin.class}}>{{skin.label}}</option>
                    {{/each}}

                    {{!--
                    <option value="ms-skin-default"><?php _e('Default', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="ms-skin-minimal"><?php _e('Minimal', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="ms-skin-light-2"><?php _e('Light 2', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="ms-skin-light-3"><?php _e('Light 3', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="ms-skin-light-4"><?php _e('Light 4', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="ms-skin-light-5"><?php _e('Light 5', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="ms-skin-light-6"><?php _e('Light 6', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="ms-skin-light-6 round-skin"><?php _e('Light 6 Round', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="ms-skin-contrast"><?php _e('Contrast', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="ms-skin-black-1"><?php _e('Black 1', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="ms-skin-black-2"><?php _e('Black 2', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="ms-skin-black-2 round-skin"><?php _e('Black 2 Round', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="ms-skin-metro"><?php _e('Metro', MSWP_TEXT_DOMAIN); ?></option>
                    --}}
                {{/dropdwon-List}}
            </div>
            <div class="msp-metabox-indented">
                <label><?php _e('Align center slider controls :', MSWP_TEXT_DOMAIN); ?> </label> {{switch-box value=centerControls}}
            </div>
            <h4><?php _e('Slider background settings', MSWP_TEXT_DOMAIN); ?></h4>
            <div class="msp-metabox-indented">
                <label><?php _e('Background image :', MSWP_TEXT_DOMAIN); ?> </label> {{view MSPanel.ImgSelect value=bgImage thumb=bgImageThumb}}
                <span class="msp-form-space"></span>
                <label><?php _e('Background color :', MSWP_TEXT_DOMAIN); ?> </label> {{color-picker value=bgColor}}
            </div>
            <h4><?php _e('Slider custom class name and style', MSWP_TEXT_DOMAIN); ?></h4>
            <div class="msp-metabox-indented">
                <label><?php _e('Class name :', MSWP_TEXT_DOMAIN); ?> </label> {{input value=className}}
            </div>
            {{!--<div class="msp-metabox-indented">
                <label><?php _e('Inline style :', MSWP_TEXT_DOMAIN); ?> </label> {{input value=inlineStyle size="50"}}
            </div>--}}
           <div class="msp-metabox-indented">
                <label><?php _e('Slider custom styles :', MSWP_TEXT_DOMAIN); ?> </label>
            </div>
            <div class="msp-metabox-indented">
                {{#code-mirror width="880" height="250" mode="css" value=customStyle}}{{/code-mirror}}
            </div>

        </div>

    {{/meta-box}}
</script>
<!-- Flickr Plugin Settings -->
<script type="text/x-handlebars" id="flickr">
 {{#meta-box title="<?php _e('Flickr Settings', MSWP_TEXT_DOMAIN); ?>"}}
        <div class="msp-metabox-row">
            <h4><?php _e('Enter your Flickr API key here', MSWP_TEXT_DOMAIN); ?></h4>
            <div class="msp-metabox-indented">
                <label><?php _e('API key :', MSWP_TEXT_DOMAIN); ?> </label> {{input value=apiKey size="60"}}
            </div>
            <div class="msp-metabox-indented">
                <span class="msp-tip"><?php _e('Don\'t have API key?', MSWP_TEXT_DOMAIN); ?>
                    <a href="https://www.flickr.com/services/api/misc.api_keys.html" target="_blank"><?php _e('See here for more details.', MSWP_TEXT_DOMAIN); ?></a>
                 </span>
            </div>
            <h4><?php _e('Create slides from user images or photoset images', MSWP_TEXT_DOMAIN); ?></h4>
            <div class="msp-metabox-indented">
                <label><?php _e('Create slides from :', MSWP_TEXT_DOMAIN); ?> </label>
                {{#dropdwon-List value=setType width=180}}
                    <option value="photos"><?php _e('User public photos', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="photoset"><?php _e('Photos in a set', MSWP_TEXT_DOMAIN); ?></option>
                {{/dropdwon-List}}
                    <div class="msp-form-space-med"></div>

                {{#if isPhotoset}}
                    <label><?php _e('Photoset Id :', MSWP_TEXT_DOMAIN); ?> </label> {{input value=setId }}
                {{else}}
                    <label><?php _e('User Id :', MSWP_TEXT_DOMAIN); ?> </label> {{input value=setId }}
                {{/if}}
            </div>

            <div class="msp-metabox-indented">
                {{#if isPhotoset}}
                    <span class="msp-tip"><?php _e('Don\'t have you photoset id?', MSWP_TEXT_DOMAIN); ?>
                        <a href="http://support.averta.net/envato/knowledgebase/find-id-photoset-flickr/" target="_blank"><?php _e('See here for more details.', MSWP_TEXT_DOMAIN); ?></a>
                    </span>
                {{else}}
                    <span class="msp-tip"><?php _e('Don\'t have the user id?', MSWP_TEXT_DOMAIN); ?>
                        <a href="http://idgettr.com/" target="_blank"><?php _e('See here for more details.', MSWP_TEXT_DOMAIN); ?></a>
                    </span>
                {{/if}}
            </div>

            <h4><?php _e('Number of photos and size of images and thumbnails', MSWP_TEXT_DOMAIN); ?></h4>
            <div class="msp-metabox-indented">
                <label><?php _e('Number of photos :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=imgCount min="1" }}
            </div>
            <div class="msp-metabox-indented">
                <label><?php _e('Images size :', MSWP_TEXT_DOMAIN); ?> </label>
                {{#dropdwon-List value=imgSize width=200}}
                    <option value="c"> <?php _e('800px on longest side', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="-"> <?php _e('500px on longest side', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="z"> <?php _e('640px on longest side', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="b"> <?php _e('1024px on longest side', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="o"> <?php _e('Original image', MSWP_TEXT_DOMAIN);?> </option>
                {{/dropdwon-List}}
                <div class="msp-form-space-med"></div>
                <label><?php _e('Thumbnails size :', MSWP_TEXT_DOMAIN); ?> </label>
                {{#dropdwon-List value=thumbSize width=200}}
                   <option value="q"> <?php _e('Large square 150x150', MSWP_TEXT_DOMAIN);?> </option>
                   <option value="s"> <?php _e('Small square 75x75', MSWP_TEXT_DOMAIN);?> </option>
                   <option value="t"> <?php _e('100px on longest side', MSWP_TEXT_DOMAIN);?> </option>
                {{/dropdwon-List}}
            </div>

        </div>

    {{/meta-box}}
</script>

<!-- Facebook Slider Settings -->
<script type="text/x-handlebars" id="facebook">
 {{#meta-box title="<?php _e('Facebook Settings', MSWP_TEXT_DOMAIN); ?>"}}
        <div class="msp-metabox-row">
            <h4><?php _e('Enter the Facebook Access Token', MSWP_TEXT_DOMAIN); ?></h4>
            <div class="msp-metabox-indented">
                <label><?php _e('Access token :', MSWP_TEXT_DOMAIN); ?> </label> {{input value=fbtoken size=60 }}
            </div>
            <div class="msp-metabox-indented">
                <span class="msp-tip"><?php _e('Don\'t have an access token?', MSWP_TEXT_DOMAIN); ?>
                    <a href="http://support.averta.net/envato/get-the-facebook-access-token/" target="_blank"><?php _e('Check this page.', MSWP_TEXT_DOMAIN); ?></a>
                </span>
            </div>

            <h4><?php _e('Create slides from user images or album images', MSWP_TEXT_DOMAIN); ?></h4>
            <div class="msp-metabox-indented">
                <label><?php _e('Create slides from :', MSWP_TEXT_DOMAIN); ?> </label>
                {{#dropdwon-List value=setType width=180}}
                    <option value="photostream"><?php _e('User public photos', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="album"><?php _e('Photos in a album', MSWP_TEXT_DOMAIN); ?></option>
                {{/dropdwon-List}}
                    <div class="msp-form-space-med"></div>

                {{#if isPhotostream}}
                    <label><?php _e('Username :', MSWP_TEXT_DOMAIN); ?> </label> {{input value=setId }}
                {{else}}
                    <label><?php _e('Album id :', MSWP_TEXT_DOMAIN); ?> </label> {{input value=setId }}
                {{/if}}
            </div>

            <div class="msp-metabox-indented">
                {{#if isPhotostream}}
                {{else}}
                    <span class="msp-tip"><?php _e('Don\'t have your album id?', MSWP_TEXT_DOMAIN); ?>
                        <a href="http://support.averta.net/envato/knowledgebase/find-facebook-album-id/" target="_blank"><?php _e('See here for more details.', MSWP_TEXT_DOMAIN); ?></a>
                    </span>
                {{/if}}
            </div>

            <h4><?php _e('Number of photos and size of images and thumbnails', MSWP_TEXT_DOMAIN); ?></h4>
            <div class="msp-metabox-indented">
                <label><?php _e('Number of photos :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=imgCount min="1" }}
            </div>
            <div class="msp-metabox-indented">
                <label><?php _e('Images size :', MSWP_TEXT_DOMAIN); ?> </label>
                {{#dropdwon-List value=imgSize width=200}}
                    <option value="orginal"> <?php _e('Original image', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="960"> <?php _e('960px on longest side', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="720"> <?php _e('720px on longest side', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="600"> <?php _e('600px on longest side', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="480"> <?php _e('480px on longest side', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="320"> <?php _e('320px on longest side', MSWP_TEXT_DOMAIN);?> </option>
                {{/dropdwon-List}}
                <div class="msp-form-space-med"></div>
                <label><?php _e('Thumbnails size :', MSWP_TEXT_DOMAIN); ?> </label>
                {{#dropdwon-List value=thumbSize width=200}}
                    <option value="orginal"> <?php _e('Original image', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="960"> <?php _e('960px on longest side', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="720"> <?php _e('720px on longest side', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="600"> <?php _e('600px on longest side', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="480"> <?php _e('480px on longest side', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="320"> <?php _e('320px on longest side', MSWP_TEXT_DOMAIN);?> </option>
                {{/dropdwon-List}}
            </div>

        </div>

    {{/meta-box}}
</script>

<!-- Posts Settings -->
<script type="text/x-handlebars" id="post">
    {{#meta-box title="<?php _e('Posts Settings', MSWP_TEXT_DOMAIN); ?>"}}
        <div class="msp-metabox-row">
            <h4><?php _e('Create slides from below filter', MSWP_TEXT_DOMAIN); ?></h4>
            <div class="msp-metabox-indented">
                <label><?php _e('Post type :', MSWP_TEXT_DOMAIN); ?> </label>
                {{#dropdwon-List value=postType width=200}}
                    {{#each ptype in wpData.types}}
                      <option {{bind-attr value=ptype.name}}>{{ptype.label}}</option>
                    {{/each}}
                {{/dropdwon-List}}
            </div>

            <div class="msp-metabox-indented">
                {{#if postCatsList}}
                    <label><?php _e('Categories :', MSWP_TEXT_DOMAIN); ?> </label>
                    {{#multi-dropdwon-List value=postCats width=200}}
                        <option value="" selected><?php _e('All Categories', MSWP_TEXT_DOMAIN); ?></option>
                        {{#each pcat in postCatsList}}
                          <option {{bind-attr value=pcat.value}}>{{pcat.label}}</option>
                        {{/each}}
                    {{/multi-dropdwon-List}}
                    <div class="msp-form-space-med"></div>
                {{/if}}
                {{#if postTagsList}}
                    <label><?php _e('Tags :', MSWP_TEXT_DOMAIN); ?> </label>
                    {{#multi-dropdwon-List value=postTags width=200}}
                        <option value="" selected><?php _e('All Tags', MSWP_TEXT_DOMAIN); ?></option>
                        {{#each ptag in postTagsList}}
                          <option {{bind-attr value=ptag.value}}>{{ptag.label}}</option>
                        {{/each}}
                    {{/multi-dropdwon-List}}
                {{/if}}
            </div>
             <h4><?php _e('Enter the post IDs which you want to exclude or include', MSWP_TEXT_DOMAIN); ?></h4>
             <div class="msp-metabox-indented">
                <label><?php _e('Exclude posts :', MSWP_TEXT_DOMAIN); ?> </label>
                {{input value=postExcludeIds }}&nbsp;&nbsp;<?php _e('post IDs separated by comma (eg. 53,34,87,25)', MSWP_TEXT_DOMAIN); ?>
            </div>
             <div class="msp-metabox-indented">
                <label><?php _e('Include posts :', MSWP_TEXT_DOMAIN); ?> </label>
                {{input value=postIncludeIds }}&nbsp;&nbsp;<?php _e('post IDs separated by comma (eg. 53,34,87,25)', MSWP_TEXT_DOMAIN); ?>
            </div>
            <div class="msp-metabox-indented">
                <?php _e('Exclude posts wihtout image : ', MSWP_TEXT_DOMAIN); ?> </label> {{switch-box value=postExcludeNoImg}} <label>
            </div>
            <h4><?php _e('Maximum number of posts to include in slider and length of excerpt', MSWP_TEXT_DOMAIN); ?></h4>
            <div class="msp-metabox-indented">
               <label><?php _e('Posts number :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=postCount min="1" }}
               <div class="msp-form-space-med"></div>
               <label><?php _e('Excerpt length :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=postExcerptLen min="1" }}&nbsp;&nbsp;<?php _e('character(s)', MSWP_TEXT_DOMAIN); ?>
            </div>
            <div class="msp-metabox-indented">
               <label><?php _e('Number of first results to skip (offset) :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=postOffset min=null }}
            </div>
            <h4><?php _e('Link slides to post\'s page', MSWP_TEXT_DOMAIN); ?></h4>
            <div class="msp-metabox-indented">
               <?php _e('Link slides to post\'s page : ', MSWP_TEXT_DOMAIN); ?> </label> {{switch-box value=postLinkSlide}} <label>
            </div>
            {{#if postLinkSlide}}
                <div class="msp-metabox-indented">
                   <label><?php _e('Slide link target : ', MSWP_TEXT_DOMAIN); ?> </label> {{view MSPanel.URLTarget  value=postLinkTarget }}
                </div>
            {{/if}}
            <h4><?php _e('Order of slides', MSWP_TEXT_DOMAIN); ?></h4>
            <div class="msp-metabox-indented">
                <label><?php _e('Order by :', MSWP_TEXT_DOMAIN); ?> </label>
                {{#dropdwon-List value=postOrder width=150}}
                    <option value="date"> <?php _e('Date', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="menu_order date"> <?php _e('Menu Order', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="title"> <?php _e('Title', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="ID"> <?php _e('ID', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="rand"> <?php _e('Random', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="comment_count"> <?php _e('Comments', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="modified"> <?php _e('Date Modified', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="author"> <?php _e('Author', MSWP_TEXT_DOMAIN);?> </option>
                {{/dropdwon-List}}
                <div class="msp-form-space-med"></div>
                <label><?php _e('Order direction :', MSWP_TEXT_DOMAIN); ?> </label>
                {{#dropdwon-List value=postOrderDir width=150}}
                    <option value="DESC"> <?php _e('Descending', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="ASC"> <?php _e('Ascending', MSWP_TEXT_DOMAIN);?> </option>
                {{/dropdwon-List}}
            </div>
            <h4><?php _e('Use as background image of slide', MSWP_TEXT_DOMAIN); ?></h4>
            <div class="msp-metabox-indented">
                <label><?php _e('Grab the image from :', MSWP_TEXT_DOMAIN); ?> </label>
                {{#dropdwon-List value=postImageType width=150}}
                    <option value="auto"> <?php _e('Auto Select', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="featured"> <?php _e('Featured Image', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="first"> <?php _e('First Image in Post', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="custom"> <?php _e('Custom Image', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="none"> <?php _e('None', MSWP_TEXT_DOMAIN);?> </option>
                {{/dropdwon-List}}
            </div>
            {{#if useCustomBg}}
                <div class="msp-metabox-indented">
                    <label><?php _e('Background image :', MSWP_TEXT_DOMAIN); ?> </label>
                    {{view MSPanel.ImgSelect value=postSlideBg thumb=postSlideBgthumb}}
                </div>
            {{/if}}
        </div>
    {{/meta-box}}

    {{#meta-box title="<?php _e('Posts Preview', MSWP_TEXT_DOMAIN); ?>"}}
        <div class="msp-posts-preview">
            {{{previewResults}}}
        </div>
    {{/meta-box}}
</script>

<!-- Woocommerce Settings -->
<script type="text/x-handlebars" id="wcproduct">
    {{#meta-box title="<?php _e('Product Slider Settings', MSWP_TEXT_DOMAIN); ?>"}}
        <div class="msp-metabox-row">

            <h4><?php _e('Create slides from below filter', MSWP_TEXT_DOMAIN); ?></h4>
            <div class="msp-metabox-indented">
                <label><?php _e('Categories :', MSWP_TEXT_DOMAIN); ?> </label>
                {{#multi-dropdwon-List value=postCats width=200}}
                    <option value="" selected><?php _e('All Categories', MSWP_TEXT_DOMAIN); ?></option>
                    {{#each pcat in postCatsList}}
                      <option {{bind-attr value=pcat.value}}>{{pcat.label}}</option>
                    {{/each}}
                {{/multi-dropdwon-List}}
                <div class="msp-form-space-med"></div>
                <label><?php _e('Tags :', MSWP_TEXT_DOMAIN); ?> </label>
                {{#multi-dropdwon-List value=postTags width=200}}
                    <option value="" selected><?php _e('All Tags', MSWP_TEXT_DOMAIN); ?></option>
                    {{#each ptag in postTagsList}}
                      <option {{bind-attr value=ptag.value}}>{{ptag.label}}</option>
                    {{/each}}
                {{/multi-dropdwon-List}}
            </div>
            <div class="msp-metabox-indented">
                {{switch-box value=wcOnlyInstock}} <label> <?php _e('Only display in-stock products.', MSWP_TEXT_DOMAIN);?></label>
            </div>
            <div class="msp-metabox-indented">
                {{switch-box value=wcOnlyFeatured}} <label> <?php _e('Only display featured products.', MSWP_TEXT_DOMAIN);?></label>
            </div>
            <div class="msp-metabox-indented">
                {{switch-box value=wcOnlyOnsale}} <label> <?php _e('Only display on sale products.', MSWP_TEXT_DOMAIN);?></label>
            </div>

             <h4><?php _e('Enter the product IDs which you want to exclude', MSWP_TEXT_DOMAIN); ?></h4>
             <div class="msp-metabox-indented">
                <label><?php _e('Exclude products :', MSWP_TEXT_DOMAIN); ?> </label>
                {{input value=postExcludeIds }}&nbsp;&nbsp;<?php _e('product IDs separated by comma (eg. 53,34,87,25)', MSWP_TEXT_DOMAIN); ?>
            </div>
            <h4><?php _e('Maximum number of products to include in slider and length of excerpt', MSWP_TEXT_DOMAIN); ?></h4>
            <div class="msp-metabox-indented">
               <label><?php _e('Products number :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=postCount min="1" }}
               <div class="msp-form-space-med"></div>
               <label><?php _e('Excerpt length :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=postExcerptLen min="1" }}&nbsp;&nbsp;<?php _e('character(s)', MSWP_TEXT_DOMAIN); ?>
            </div>
            <div class="msp-metabox-indented">
               <label><?php _e('Number of first results to skip (offset) :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=postOffset min=null }}
            </div>
            <h4><?php _e('Link slides to product\'s page', MSWP_TEXT_DOMAIN); ?></h4>
            <div class="msp-metabox-indented">
               <?php _e('Link slides to product\'s page : ', MSWP_TEXT_DOMAIN); ?> </label> {{switch-box value=postLinkSlide}}
            </div>
            {{#if postLinkSlide}}
                <div class="msp-metabox-indented">
                   <label><?php _e('Slide link target : ', MSWP_TEXT_DOMAIN); ?> </label> {{view MSPanel.URLTarget  value=postLinkTarget }}
                </div>
            {{/if}}
            <h4><?php _e('Order of slides', MSWP_TEXT_DOMAIN); ?></h4>
            <div class="msp-metabox-indented">
                <label><?php _e('Order by :', MSWP_TEXT_DOMAIN); ?> </label>
                {{#dropdwon-List value=postOrder width=150}}
                    <option value="date"> <?php _e('Date', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="menu_order date"> <?php _e('Menu Order', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="title"> <?php _e('Title', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="ID"> <?php _e('ID', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="rand"> <?php _e('Random', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="comment_count"> <?php _e('Comments', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="modified"> <?php _e('Date Modified', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="author"> <?php _e('Author', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="popularity"> <?php _e('Popularity', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="rating"> <?php _e('Average rating', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="price"> <?php _e('Price: low to high', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="price-desc"> <?php _e('Price: high to low', MSWP_TEXT_DOMAIN);?> </option>
                {{/dropdwon-List}}
                <div class="msp-form-space-med"></div>
                <label><?php _e('Order direction :', MSWP_TEXT_DOMAIN); ?> </label>
                {{#dropdwon-List value=postOrderDir width=150}}
                    <option value="DESC"> <?php _e('Descending', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="ASC"> <?php _e('Ascending', MSWP_TEXT_DOMAIN);?> </option>
                {{/dropdwon-List}}
            </div>
            <h4><?php _e('Use as background image of slide', MSWP_TEXT_DOMAIN); ?></h4>
            <div class="msp-metabox-indented">
                <label><?php _e('Grab the image from :', MSWP_TEXT_DOMAIN); ?> </label>
                {{#dropdwon-List value=postImageType width=150}}
                    <option value="auto"> <?php _e('Auto Select', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="featured"> <?php _e('Featured Image', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="first"> <?php _e('First Image in Post', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="custom"> <?php _e('Custom Image', MSWP_TEXT_DOMAIN);?> </option>
                    <option value="none"> <?php _e('None', MSWP_TEXT_DOMAIN);?> </option>
                {{/dropdwon-List}}
            </div>
            {{#if useCustomBg}}
                <div class="msp-metabox-indented">
                    <label><?php _e('Background image :', MSWP_TEXT_DOMAIN); ?> </label>
                    {{view MSPanel.ImgSelect value=postSlideBg thumb=postSlideBgthumb}}
                </div>
            {{/if}}
        </div>
    {{/meta-box}}

    {{#meta-box title="<?php _e('Products Preview', MSWP_TEXT_DOMAIN); ?>"}}
        <div class="msp-posts-preview">
            {{{previewResults}}}
        </div>
    {{/meta-box}}
</script>
<!-- Slides Page -->
<script type="text/x-handlebars" id="slides">
    {{#if customSlider}}
        <div class="msp-slides-list-panel">
            <!-- Slides List -->
            {{#meta-box title="<?php _e('Slides', MSWP_TEXT_DOMAIN); ?>"}}
            <div class="msp-metabox-row">
                {{view MSPanel.SlideList}}
            </div>
            {{/meta-box}}
        </div>
        {{#if currentSlide}}
            {{partial "slide-settings"}}
        {{/if}}
    {{/if}}
    {{#if templateSlider}}
        <div class="msp-slides-list-panel">
        {{#meta-box title="<?php _e('Slides Template', MSWP_TEXT_DOMAIN); ?>"}}
            <div class="msp-metabox-row">
                <div class="msp-metabox-indented">
                <?php _e('In this section you can create slide template for your slider.', MSWP_TEXT_DOMAIN); ?><br>
                <?php _e('Slide template will be used by the slider to create dynamically slides from posts, Facebook or Flickr photos.', MSWP_TEXT_DOMAIN); ?><br>
                </div>
            </div>
        {{/meta-box}}
        </div>
        {{partial "slide-template-settings"}}

    {{/if}}
</script>
<!-- tempalte slide settings -->
<script type="text/x-handlebars" id="slide-template-settings">
    <div class="msp-slide-settings-panel">
        {{#tabs-panel id="slide-settings"}}
        <div class="msp-metabox-handle">

            <ul class="tabs">
                <li class="active"><a href="#sl-bg"><?php _e('Fill Mode', MSWP_TEXT_DOMAIN); ?></a></li>
                <li><a href="#sl-inf"><?php _e('Slide Info', MSWP_TEXT_DOMAIN); ?></a></li>
                <li><a href="#sl-misc"><?php _e('Misc', MSWP_TEXT_DOMAIN); ?></a></li>
            </ul>

            <div class="msp-metabox-toggle"></div>
        </div>

        <ul class="tabs-content">
            <li id="sl-bg">
                <div class="msp-metabox-row">
                    <h4><?php _e('Choose slide background fill mode', MSWP_TEXT_DOMAIN); ?></h4>
                    <div class="msp-metabox-indented">
                        <label><?php _e('Fillmode :', MSWP_TEXT_DOMAIN); ?> </label> {{view MSPanel.Fillmode value=currentSlide.fillMode}}
                    </div>
                </div>
            </li>
            <li id="sl-inf">{{partial 'slide-info'}}</li>
            <li id="sl-misc">
                <div class="msp-metabox-row">
                    <h4><?php _e('Slide background color', MSWP_TEXT_DOMAIN); ?></h4>
                    <div class="msp-metabox-indented">
                        <label><?php _e('Background color :', MSWP_TEXT_DOMAIN); ?> </label> {{color-picker value=currentSlide.bgColor}}
                    </div>
                    <h4><?php _e('Custom class name for slide element', MSWP_TEXT_DOMAIN); ?> </h4>
                    <div class="msp-metabox-indented">
                        <label><?php _e('Class name :', MSWP_TEXT_DOMAIN); ?> </label> {{input size=30 value=currentSlide.cssClass}}
                    </div>
                </div>
            </li>
        </ul>

        {{/tabs-panel}}
    </div>
    <div class="msp-slide-editor-panel">
    {{render "layers" currentSlide.layers}}
    </div>
</script>
<!-- Slide Settings Partial -->
<script type="text/x-handlebars" id="slide-settings">
    <div class="msp-slide-settings-panel">
        {{#if currentSlide.isOverlayLayers}}
            {{#meta-box title="<?php _e('Overlay layers', MSWP_TEXT_DOMAIN); ?>"}}
                <div class="msp-metabox-indented">
                    <p><?php _e('In this section you can add layers over the slider. They remain fixed while changing slides.', MSWP_TEXT_DOMAIN);?></p>
                </div>
                <div class="msp-metabox-indented">
                    {{switch-box value=sliderSettings.enableOverlayLayers}} <label> <?php _e('Enable overlay layers', MSWP_TEXT_DOMAIN);?></label>
                </div>
            {{/meta-box}}
        {{else}}
        {{#tabs-panel id="slide-settings"}}
        <div class="msp-metabox-handle">

            <ul class="tabs">
                <li class="active"><a href="#sl-bg"><?php _e('Background', MSWP_TEXT_DOMAIN); ?></a></li>
                <li><a href="#sl-vbg"><?php _e('Video Background', MSWP_TEXT_DOMAIN); ?></a></li>
                <li><a href="#sl-val"><?php _e('Video and Link', MSWP_TEXT_DOMAIN); ?></a></li>
                <li><a href="#sl-inf"><?php _e('Slide Info', MSWP_TEXT_DOMAIN); ?></a></li>
                <li><a href="#sl-misc"><?php _e('Misc', MSWP_TEXT_DOMAIN); ?></a></li>
            </ul>

            <div class="msp-metabox-toggle"></div>
        </div>

        <ul class="tabs-content">
            <li id="sl-bg">{{partial 'slide-background'}}</li>
            <li id="sl-vbg">{{partial 'slide-videobg'}}</li>
            <li id="sl-val">{{partial 'slide-video-and-link'}}</li>
            <li id="sl-inf">{{partial 'slide-info'}}</li>
            <li id="sl-misc">{{partial 'slide-misc'}}</li>
        </ul>

        {{/tabs-panel}}

        <!-- end of check for overlay if -->
        {{/if}}
    </div>

    {{render "layers" currentSlide.layers}}
</script>

<!-- Slide Background Settings Partial -->
<script type="text/x-handlebars" id="slide-background">
    <div class="msp-metabox-row">
        <h4><?php _e('Choose slide background and thumbnail', MSWP_TEXT_DOMAIN); ?></h4>
        <div class="msp-metabox-indented">
            <label><?php _e('Background :', MSWP_TEXT_DOMAIN); ?> </label> {{view MSPanel.ImgSelect value=currentSlide.bg thumb=currentSlide.bgThumb }}
            <span class="msp-form-space"></span>
            <label><?php _e('Fillmode :', MSWP_TEXT_DOMAIN); ?> </label> {{view MSPanel.Fillmode value=currentSlide.fillMode}}
            <span class="msp-form-space"></span>
            <label><?php _e('Thumbnail :', MSWP_TEXT_DOMAIN); ?> </label> {{view MSPanel.ImgSelect value=currentSlide.thumbOrginal thumb=currentSlide.thumb}}
        </div>
    </div>
</script>
<!-- Slide Video Background Partial -->
<script type="text/x-handlebars" id="slide-videobg">
    <div class="msp-metabox-row">
        <h4><?php _e('Video background paths', MSWP_TEXT_DOMAIN); ?></h4>
        <div class="msp-metabox-indented">
            <label class="msp-col-medium"><?php _e('MP4 :', MSWP_TEXT_DOMAIN); ?> </label> {{input class="msp-path-input" value=currentSlide.bgv_mp4}}
            <label class="msp-col-medium"><?php _e('Webm :', MSWP_TEXT_DOMAIN); ?> </label> {{input class="msp-path-input" value=currentSlide.bgv_webm}}
        </div>
        <div class="msp-metabox-indented">
            <label class="msp-col-medium"><?php _e('Ogg :', MSWP_TEXT_DOMAIN); ?> </label> {{input class="msp-path-input" value=currentSlide.bgv_ogg}}
        </div>
        <h4><?php _e('Video background fill mode', MSWP_TEXT_DOMAIN); ?></h4>
        <div class="msp-metabox-indented">
            <label><?php _e('Fillmode :', MSWP_TEXT_DOMAIN); ?> </label> {{view MSPanel.Fillmode type="video" value=currentSlide.bgv_fillmode}}
        </div>
        <h4><?php _e('Video background settings', MSWP_TEXT_DOMAIN); ?></h4>
        <div class="msp-metabox-indented">
            <label><?php _e('Loop :', MSWP_TEXT_DOMAIN); ?> </label>  {{switch-box value=currentSlide.bgv_loop}}
            <span class="msp-form-space"></span>
            <label><?php _e('Mute :', MSWP_TEXT_DOMAIN); ?> </label>  {{switch-box value=currentSlide.bgv_mute}}
            <span class="msp-form-space"></span>
            <label><?php _e('Pause video on slide changed :', MSWP_TEXT_DOMAIN); ?> </label>  {{switch-box value=currentSlide.bgv_autopause}}
        </div>
    </div>
</script>
<!-- Slide Embeded Video and Link -->
<script type="text/x-handlebars" id="slide-video-and-link">
    <div class="msp-metabox-row">
        <h4><?php _e('Link this slide', MSWP_TEXT_DOMAIN); ?> </h4>
        <div class="msp-metabox-indented">
            <label><?php _e('URL :', MSWP_TEXT_DOMAIN); ?> </label> {{input class="msp-path-input" value=currentSlide.link}}
            {{view MSPanel.URLTarget  value=currentSlide.linkTarget }}
        </div>
        <div class="msp-metabox-indented">
            <label><?php _e('Link id :', MSWP_TEXT_DOMAIN); ?> </label> {{input size=20 value=currentSlide.linkId}}
             <span class="msp-form-space"></span>
            <label><?php _e('Link class :', MSWP_TEXT_DOMAIN); ?> </label> {{input size=20 value=currentSlide.linkClass}}
        </div>
        <div class="msp-metabox-indented">
            <label><?php _e('Link rel :', MSWP_TEXT_DOMAIN); ?> </label> {{input size=20 value=currentSlide.linkRel}}
             <span class="msp-form-space"></span>
            <label><?php _e('Link title :', MSWP_TEXT_DOMAIN); ?> </label> {{input size=20 value=currentSlide.linkTitle}}
        </div>
        <h4><?php _e('Youtube or Vimeo video as slide', MSWP_TEXT_DOMAIN); ?></h4>
        <div class="msp-metabox-indented">
            <label><?php _e('Video embed src :', MSWP_TEXT_DOMAIN); ?> </label> {{input size=60 value=currentSlide.video}}
            <span class="msp-form-space"></span>
            <label><?php _e('Autoplay video :', MSWP_TEXT_DOMAIN); ?> </label>  {{switch-box value=currentSlide.autoplayVideo}}
        </div>
        <div class="msp-metabox-indented">
            <a href="http://masterslider.com/doc/wp/#embed-url" target="_blank"><?php _e('Where to find the Youtube/Vimeo embed URL.', MSWP_TEXT_DOMAIN); ?></a>
        </div>
    </div>
</script>

<!-- Slide Info -->
<script type="text/x-handlebars" id="slide-info">
    <div class="msp-metabox-row">
        <div class="msp-metabox-indented">
            <label><?php _e('Unique slide id :', MSWP_TEXT_DOMAIN); ?> </label> {{input size=60 value=currentSlide.msId}}
        </div>
        <div class="msp-metabox-indented">
            <label><?php _e('The info. will appear next to the slider when it reaches that specific slide, or it can represent as a tab in tabs control. Please note that it is relative to the selected slider\'s template.', MSWP_TEXT_DOMAIN); ?></label>
        </div>

        {{#if MSPanel.dynamicTags}}
            <div class="msp-metabox-indented">
                <label><?php _e('Insert dynamic content : ', MSWP_TEXT_DOMAIN); ?></label>
                {{view MSPanel.AddDynamicTag editorId=infoEditor}}
            </div>
        {{/if}}
        <div class="msp-metabox-indented">
            {{view MSPanel.WPEditor tabs="slide-settings" tab="sl-inf" _id=infoEditor value=currentSlide.info}}
            {{!-- {{view MSPanel.HTMLTextArea value=currentSlide.info}} --}}
        </div>
    </div>
</script>

<!-- Slide Misc -->
<script type="text/x-handlebars" id="slide-misc">
    <div class="msp-metabox-row">
        <h4><?php _e('Custom class name and ID for slide element', MSWP_TEXT_DOMAIN); ?> </h4>
        <div class="msp-metabox-indented">
            <label><?php _e('Class name :', MSWP_TEXT_DOMAIN); ?> </label> {{input size=30 value=currentSlide.cssClass}}
             <span class="msp-form-space"></span>
            <label><?php _e('CSS ID :', MSWP_TEXT_DOMAIN); ?> </label> {{input size=30 value=currentSlide.cssId}}
        </div>
        <h4><?php _e('Background color and slide background alt text ', MSWP_TEXT_DOMAIN); ?></h4>
        <div class="msp-metabox-indented">
            <label><?php _e('Background color :', MSWP_TEXT_DOMAIN); ?> </label> {{color-picker value=currentSlide.bgColor}}
             <span class="msp-form-space"></span>
            <label><?php _e('Alt text :', MSWP_TEXT_DOMAIN); ?> </label> {{input size=30 value=currentSlide.bgAlt}}
        </div>
        <div class="msp-metabox-indented">
            <label><?php _e('Background image title :', MSWP_TEXT_DOMAIN); ?> </label> {{input size=30 value=currentSlide.bgTitle}}
        </div>
        <h4><?php _e('Slide color and pattern overlay ', MSWP_TEXT_DOMAIN); ?></h4>
        <div class="msp-metabox-indented">
           <label><?php _e('Color overlay :', MSWP_TEXT_DOMAIN); ?> </label> {{color-picker value=currentSlide.colorOverlay}}
           <div class="msp-form-space-med"></div>
           <label><?php _e('Pattern overlay :', MSWP_TEXT_DOMAIN); ?> </label> {{pattern-picker value=currentSlide.pattern}}
        </div>
    </div>
</script>
<!-- Slide Scene Partial -->
<script type="text/x-handlebars" id='layers'>
    <div class="msp-slide-editor-panel">
    {{#meta-box title="Slide"}}
    {{view MSPanel.StageArea}}
    <hr class="msp-metabox-hr">
    <div class="msp-metabox-row">
        <label><?php _e('New layer :', MSWP_TEXT_DOMAIN); ?> </label> {{view MSPanel.AddLayer}}
        <span class="msp-form-space"></span>
        <label><?php _e('Slide duration :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input class="msp-number-input" min=0 max=300 step="0.1" value=slide.duration}} s
        <span class="msp-form-space"></span>
        {{view MSPanel.PreviewSlideBtn}}
    </div>

    {{view MSPanel.Timeline}}

    {{/meta-box}}
    </div>

    {{partial layerSettings}}
</script>

<!-- layer content common settings -->
<script type="text/x-handlebars" id="layer-content-common">
    <div class="msp-metabox-indented">
        <label><?php _e('Layer type:', MSWP_TEXT_DOMAIN); ?> </label>
        {{#dropdwon-List value=currentLayer.position}}
            <option value="normal"><?php _e('Normal', MSWP_TEXT_DOMAIN); ?></option>
            <option value="static"><?php _e('Static', MSWP_TEXT_DOMAIN); ?></option>
            <option value="fixed"><?php _e('Fixed', MSWP_TEXT_DOMAIN); ?></option>
        {{/dropdwon-List}}
        <div class="msp-form-space"></div>
        <label><?php _e('Unique layer id :', MSWP_TEXT_DOMAIN); ?> </label> {{input value=currentLayer.msId}}
    </div>
    <div class="msp-metabox-indented">
        <label><?php _e('Hide element on :', MSWP_TEXT_DOMAIN); ?> </label> {{view MSPanel.BreakpointSelect layer=currentLayer}}
    </div>

    {{#if currentLayer.slide.isOverlayLayers}}
        <div class="msp-metabox-indented">
            <p><?php _e('Enter slide(s) id separated by comma to show or hide the overlay layer over specific slide.', MSWP_TEXT_DOMAIN); ?></p>
            {{#dropdwon-List value=currentLayer.overlayTargetSlidesAction width="200"}}
                <option value="show"><?php _e('Show layer only in slide(s):', MSWP_TEXT_DOMAIN); ?></option>
                <option value="hide"><?php _e('Hide layer in slide(s):', MSWP_TEXT_DOMAIN); ?></option>
            {{/dropdwon-List}}
            {{input value=currentLayer.overlayTargetSlides size="50"}}
        </div>
    {{/if}}
</script>


<!-- text layer settings -->
<script type="text/x-handlebars" id="text-layer-settings">
    <div class="msp-layer-settings-panel">
    {{#tabs-panel}}
    <div class="msp-metabox-handle">

        <ul class="tabs">
            <li class="active"><a href="#layer-content"><?php _e('Layer Content', MSWP_TEXT_DOMAIN); ?></a></li>
            <li><a href="#layer-anim"><?php _e('Transition', MSWP_TEXT_DOMAIN); ?></a></li>
            <li><a href="#layer-style"><?php _e('Style', MSWP_TEXT_DOMAIN); ?></a></li>
            <li><a href="#layer-misc"><?php _e('Misc', MSWP_TEXT_DOMAIN); ?></a></li>
        </ul>

        <div class="msp-metabox-toggle"></div>
    </div>

    <ul class="tabs-content">
        <li id="layer-content">
            <div class="msp-metabox-row">
                {{partial 'layer-content-common'}}
                 <div class="msp-metabox-indented">
                    <label><?php _e('Width :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=currentLayer.width}} px
                    {{!--<span class="msp-form-space"></span>
                    <label><?php _e('Height :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=currentLayer.height}} px--}}
                </div>
                <div class="msp-metabox-indented">
                    <label><?php _e('Insert your text content here, for a better SEO result you can use heading tags for important contents.', MSWP_TEXT_DOMAIN); ?> </label>
                </div>
                {{#if MSPanel.dynamicTags}}
                    <div class="msp-metabox-indented">
                        <label><?php _e('Insert dynamic content : ', MSWP_TEXT_DOMAIN); ?></label>
                        {{view MSPanel.AddDynamicTag editorId=textLayerEditor}}
                    </div>
                {{/if}}
                <div class="msp-metabox-indented">
                {{view MSPanel.WPEditor _id=textLayerEditor value=currentLayer.content}}
                {{!-- {{view MSPanel.HTMLTextArea value=currentLayer.content}} --}}
                </div>
                <h4><?php _e('Bind action to layer', MSWP_TEXT_DOMAIN); ?></h4>
                <div class="msp-metabox-indented">
                    {{switch-box value=currentLayer.useAction}} <label><?php _e('Enable actions. Action runs by clicking user on the layer.', MSWP_TEXT_DOMAIN); ?>
                </div>
                <div class="msp-metabox-indented">
                    {{#if currentLayer.useAction}}
                        <label><?php _e('Select action :', MSWP_TEXT_DOMAIN); ?> </label> {{view MSPanel.ActionList layer=currentLayer}}
                    {{/if}}
                </div>
            </div>
        </li>
        <li id="layer-anim">{{partial 'layer-transition-settings'}}</li>
        <li id="layer-style">{{partial 'layer-style-settings'}}</li>
        <li id="layer-misc">{{partial 'layer-misc-settings'}}</li>
    </ul>

    {{/tabs-panel}}
    </div>
</script>

<!-- image layer settings -->
<script type="text/x-handlebars" id="image-layer-settings">
    <div class="msp-layer-settings-panel">
    {{#tabs-panel}}
    <div class="msp-metabox-handle">

        <ul class="tabs">
            <li class="active"><a href="#layer-content"><?php _e('Layer Content', MSWP_TEXT_DOMAIN); ?></a></li>
            <li><a href="#layer-anim"><?php _e('Transition', MSWP_TEXT_DOMAIN); ?></a></li>
            <li><a href="#layer-style"><?php _e('Style', MSWP_TEXT_DOMAIN); ?></a></li>
            <li><a href="#layer-misc"><?php _e('Misc', MSWP_TEXT_DOMAIN); ?></a></li>
        </ul>

        <div class="msp-metabox-toggle"></div>
    </div>

    <ul class="tabs-content">
        <li id="layer-content">
            <div class="msp-metabox-row">
                {{partial 'layer-content-common'}}
                <h4><?php _e('Layer image and alt attribute', MSWP_TEXT_DOMAIN); ?></h4>
                <div class="msp-metabox-indented">
                    <label><?php _e('Select image :', MSWP_TEXT_DOMAIN); ?> </label> {{view MSPanel.ImgSelect value=currentLayer.img thumb=currentLayer.imgThumb}}
                    <span class="msp-form-space"></span>
                    <label><?php _e('Alt text :', MSWP_TEXT_DOMAIN); ?> </label> {{input value=currentLayer.imgAlt}}
                </div>
                <h4><?php _e('Link layer or bind action to layer', MSWP_TEXT_DOMAIN); ?></h4>
                <div class="msp-metabox-indented">
                    {{switch-box value=currentLayer.useAction}} <label><?php _e('Bind action to layer. Action runs by clicking user on the layer.', MSWP_TEXT_DOMAIN); ?>
                </div>
                <div class="msp-metabox-indented">
                    {{#if currentLayer.useAction}}
                        <label><?php _e('Select action :', MSWP_TEXT_DOMAIN); ?> </label> {{view MSPanel.ActionList layer=currentLayer}}
                    {{else}}
                        <label><?php _e('URL :', MSWP_TEXT_DOMAIN); ?> </label> {{input class="msp-path-input" value=currentLayer.link}}
                        {{view MSPanel.URLTarget value=currentLayer.linkTarget }}
                    {{/if}}
                </div>
            </div>
        </li>
        <li id="layer-anim">{{partial 'layer-transition-settings'}}</li>
        <li id="layer-style">{{partial 'layer-style-settings'}}</li>
        <li id="layer-misc">{{partial 'layer-misc-settings'}}</li>
    </ul>

    {{/tabs-panel}}
    </div>
</script>

<!-- video layer settings -->
<script type="text/x-handlebars" id="video-layer-settings">
    <div class="msp-layer-settings-panel">
    {{#tabs-panel}}
    <div class="msp-metabox-handle">

        <ul class="tabs">
            <li class="active"><a href="#layer-content"><?php _e('Layer Content', MSWP_TEXT_DOMAIN); ?></a></li>
            <li><a href="#layer-anim"><?php _e('Transition', MSWP_TEXT_DOMAIN); ?></a></li>
            <li><a href="#layer-style"><?php _e('Style', MSWP_TEXT_DOMAIN); ?></a></li>
            <li><a href="#layer-misc"><?php _e('Misc', MSWP_TEXT_DOMAIN); ?></a></li>
        </ul>

        <div class="msp-metabox-toggle"></div>
    </div>

    <ul class="tabs-content">
        <li id="layer-content">
            <div class="msp-metabox-row">
                {{partial 'layer-content-common'}}
                <h4><?php _e('Youtube or Vimeo video embed source', MSWP_TEXT_DOMAIN); ?></h4>
                <div class="msp-metabox-indented">
                    <label><?php _e('URL :', MSWP_TEXT_DOMAIN); ?> </label> {{input class="msp-path-input" value=currentLayer.video}}
                    <span class="msp-form-space"></span>
                    <label><?php _e('Width :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=currentLayer.width}} px
                    <span class="msp-form-space"></span>
                    <label><?php _e('Height :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=currentLayer.height}} px
                </div>
                <div class="msp-metabox-indented">
                    <a href="http://masterslider.com/doc/wp/#embed-url" target="_blank"><?php _e('Where to find the Youtube/Vimeo embed URL.', MSWP_TEXT_DOMAIN); ?></a>
                </div>
                <div class="msp-metabox-indented">
                     <label><?php _e('Autoplay video :', MSWP_TEXT_DOMAIN); ?> </label>  {{switch-box value=currentLayer.autoplayVideo}}
                </div>
                <h4><?php _e('Video custom cover image', MSWP_TEXT_DOMAIN); ?></h4>
                <div class="msp-metabox-indented">
                    <label><?php _e('Select image :', MSWP_TEXT_DOMAIN); ?> </label> {{view MSPanel.ImgSelect value=currentLayer.img thumb=currentLayer.imgThumb}}
                    <span class="msp-form-space"></span>
                    <label><?php _e('Alt text :', MSWP_TEXT_DOMAIN); ?> </label> {{input value=currentLayer.imgAlt}}
                </div>
            </div>
        </li>
        <li id="layer-anim">{{partial 'layer-transition-settings'}}</li>
        <li id="layer-style">{{partial 'layer-style-settings'}}</li>
        <li id="layer-misc">{{partial 'layer-misc-settings'}}</li>
    </ul>
    {{/tabs-panel}}
    </div>
</script>

<!-- hotspot layer settings -->
<script type="text/x-handlebars" id="hotspot-layer-settings">
    <div class="msp-layer-settings-panel">
    {{#tabs-panel}}
    <div class="msp-metabox-handle">

        <ul class="tabs">
            <li class="active"><a href="#layer-content"><?php _e('Layer Content', MSWP_TEXT_DOMAIN); ?></a></li>
            <li><a href="#layer-anim"><?php _e('Transition', MSWP_TEXT_DOMAIN); ?></a></li>
            <li><a href="#layer-style"><?php _e('Style', MSWP_TEXT_DOMAIN); ?></a></li>
            <li><a href="#layer-misc"><?php _e('Misc', MSWP_TEXT_DOMAIN); ?></a></li>
        </ul>

        <div class="msp-metabox-toggle"></div>
    </div>

    <ul class="tabs-content">
        <li id="layer-content">
            <div class="msp-metabox-row">
                {{partial 'layer-content-common'}}
                <h4><?php _e('Hotspot tooltip alignment and max width', MSWP_TEXT_DOMAIN); ?></h4>
                <div class="msp-metabox-indented">
                    <label><?php _e('Tooltip align : ', MSWP_TEXT_DOMAIN); ?> </label>
                    {{#view MSPanel.Select value=currentLayer.align }}
                        <option value="top"><?php _e('Top', MSWP_TEXT_DOMAIN); ?></option>
                        <option value="right"><?php _e('Right', MSWP_TEXT_DOMAIN); ?></option>
                        <option value="bottom"><?php _e('Bottom', MSWP_TEXT_DOMAIN); ?></option>
                        <option value="left"><?php _e('Left', MSWP_TEXT_DOMAIN); ?></option>
                    {{/view}}
                    <div class="msp-form-space"></div>
                    <label><?php _e('Tooltip max width : ', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=currentLayer.width min="0"}} px
                </div>
                <div class="msp-metabox-indented">
                    <label><?php _e('Stay tooltip on mouse over it : ', MSWP_TEXT_DOMAIN); ?> </label> {{switch-box value=currentLayer.stayHover}}
                </div>
                <h4><?php _e('Insert your hotspot content here, for a better SEO result you can use heading tags for important contents.', MSWP_TEXT_DOMAIN); ?> </h4>
                 {{#if MSPanel.dynamicTags}}
                    <div class="msp-metabox-indented">
                        <label><?php _e('Insert dynamic content : ', MSWP_TEXT_DOMAIN); ?></label>
                        {{view MSPanel.AddDynamicTag editorId=hsLayerEditor}}
                    </div>
                {{/if}}
                <div class="msp-metabox-indented">
                     {{view MSPanel.WPEditor _id=hsLayerEditor value=currentLayer.content}}
                {{!-- {{view MSPanel.HTMLTextArea value=currentLayer.content}} --}}
                </div>
                 <h4><?php _e('Link hotspot or bind action to layer', MSWP_TEXT_DOMAIN); ?></h4>
                <div class="msp-metabox-indented">
                    {{switch-box value=currentLayer.useAction}} <label><?php _e('Bind action to layer. Action runs by clicking user on the layer.', MSWP_TEXT_DOMAIN); ?>
                </div>
                <div class="msp-metabox-indented">
                    {{#if currentLayer.useAction}}
                        <label><?php _e('Select action :', MSWP_TEXT_DOMAIN); ?> </label> {{view MSPanel.ActionList layer=currentLayer}}
                    {{else}}
                        <label><?php _e('URL :', MSWP_TEXT_DOMAIN); ?> </label> {{input class="msp-path-input" value=currentLayer.link}}
                        {{view MSPanel.URLTarget value=currentLayer.linkTarget }}
                    {{/if}}
                </div>
            </div>
        </li>
        <li id="layer-anim">{{partial 'layer-transition-settings'}}</li>
        <li id="layer-style">{{partial 'layer-style-settings'}}</li>
        <li id="layer-misc">{{partial 'layer-misc-settings'}}</li>
    </ul>
    {{/tabs-panel}}
    </div>
</script>

<!--
    button layer settings
    @since 1.9.0
-->
<script type="text/x-handlebars" id="button-layer-settings">
    <div class="msp-layer-settings-panel">
    {{#tabs-panel}}
    <div class="msp-metabox-handle">

        <ul class="tabs">
            <li class="active"><a href="#layer-content"><?php _e('Layer Content', MSWP_TEXT_DOMAIN); ?></a></li>
            <li><a href="#layer-anim"><?php _e('Transition', MSWP_TEXT_DOMAIN); ?></a></li>
            <li><a href="#layer-style"><?php _e('Style', MSWP_TEXT_DOMAIN); ?></a></li>
            <li><a href="#layer-misc"><?php _e('Misc', MSWP_TEXT_DOMAIN); ?></a></li>
        </ul>

        <div class="msp-metabox-toggle"></div>
    </div>

    <ul class="tabs-content">
        <li id="layer-content">
            <div class="msp-metabox-row">
                {{partial 'layer-content-common'}}
                <h4><?php _e('Button label and link', MSWP_TEXT_DOMAIN); ?></h4>
                <div class="msp-metabox-indented">
                    <label><?php _e('Label :', MSWP_TEXT_DOMAIN); ?> </label> {{input value=currentLayer.content}}
                </div>
                 <h4><?php _e('Link button or bind action', MSWP_TEXT_DOMAIN); ?></h4>
                <div class="msp-metabox-indented">
                    {{switch-box value=currentLayer.useAction}} <label><?php _e('Bind action to layer. Action runs by clicking user on the layer.', MSWP_TEXT_DOMAIN); ?>
                </div>
                <div class="msp-metabox-indented">
                    {{#if currentLayer.useAction}}
                        <label><?php _e('Select action :', MSWP_TEXT_DOMAIN); ?> </label> {{view MSPanel.ActionList layer=currentLayer}}
                    {{else}}
                        <label><?php _e('URL :', MSWP_TEXT_DOMAIN); ?> </label> {{input class="msp-path-input" value=currentLayer.link}}
                        {{view MSPanel.URLTarget value=currentLayer.linkTarget }}
                    {{/if}}
                </div>
                <h4><?php _e('Choose button style from below or create/edit a new button.', MSWP_TEXT_DOMAIN); ?></h4>
                <div class="msp-metabox-indented">
                    {{view MSPanel.ButtonsList layer=currentLayer}}
                </div>
                <div class="msp-metabox-indented">
                    <button class="msp-regular" {{action "openButtonEditor"}}>
                        <?php _e('New/Edit Button...', MSWP_TEXT_DOMAIN); ?>
                    </button>
                </div>
            </div>
        </li>
        <li id="layer-anim">{{partial 'layer-transition-settings'}}</li>
        <li id="layer-style">{{partial 'layer-style-settings'}}</li>
        <li id="layer-misc">{{partial 'layer-misc-settings'}}</li>
    </ul>

    {{/tabs-panel}}
    </div>
</script>

<!-- layer transition tab -->
<script type="text/x-handlebars" id="layer-transition-settings">
    <div class="msp-metabox-row">
        <h4><?php _e('Layer parallax effect', MSWP_TEXT_DOMAIN); ?></h4>
        <div class="msp-metabox-indented">
            <label><?php _e('Parallax effect level :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=currentLayer.parallax}} %
        </div>

        {{#if staticLayer}}
            <h4><?php _e('Layer transition in', MSWP_TEXT_DOMAIN); ?></h4>
            <div class="msp-metabox-indented">
                <p><strong><?php _e('Static layer doesn\'t support transitions.', MSWP_TEXT_DOMAIN); ?></strong></p>
            </div>
        {{else}}
            <h4><?php _e('Wait for action trigger', MSWP_TEXT_DOMAIN); ?></h4>
            <div class="msp-metabox-indented">
                {{switch-box value=currentLayer.wait}} <label><label><?php _e('Do not start automatically and wait for an action trigger.', MSWP_TEXT_DOMAIN); ?> </label>
            </div>
            <h4><?php _e('Layer transition in', MSWP_TEXT_DOMAIN); ?></h4>
            <div class="msp-metabox-indented">
                <label><?php _e('Transition effect :', MSWP_TEXT_DOMAIN); ?> </label><button class="msp-regular" {{action "openEffectEditor" "show"}}>Select...</button>
                <span class="msp-form-space"></span>
                <label><?php _e('Duration :', MSWP_TEXT_DOMAIN); ?> </lable> {{number-input value=currentLayer.showDuration step="0.2"}} s
                <span class="msp-form-space"></span>
                <label><?php _e('Delay :', MSWP_TEXT_DOMAIN); ?> </lable> {{number-input value=currentLayer.showDelay step="0.2"}} s
            </div>
            <h4><?php _e('Layer transition out', MSWP_TEXT_DOMAIN); ?></h4>
            <div class="msp-metabox-indented">
                {{switch-box value=currentLayer.useHide}} <label><label><?php _e('Enable transition out', MSWP_TEXT_DOMAIN); ?> </label>
            </div>
            {{#if currentLayer.useHide}}
                <div class="msp-metabox-indented">
                    <label><?php _e('Transition effect :', MSWP_TEXT_DOMAIN); ?> </label><button class="msp-regular" {{action "openEffectEditor" "hide"}}>Select...</button>
                    <span class="msp-form-space"></span>
                    <label><?php _e('Duration :', MSWP_TEXT_DOMAIN); ?> </lable> {{number-input value=currentLayer.hideDuration step="0.2"}} s
                    <span class="msp-form-space"></span>
                    <label><?php _e('Waiting :', MSWP_TEXT_DOMAIN); ?> </lable> {{number-input value=currentLayer.hideDelay step="0.2"}} s
                </div>
            {{/if}}
        {{/if}}

    </div>
</script>

<!-- layer style tab -->
<script type="text/x-handlebars" id="layer-style-settings">
    <div class="msp-metabox-row">
        <h4><?php _e('Layer position and size', MSWP_TEXT_DOMAIN); ?></h4>
        <div class="msp-metabox-indented">
            <label><?php _e('Layer position origin :', MSWP_TEXT_DOMAIN); ?> </label> {{view MSPanel.PositionOrigin layer=currentLayer}}
            <span class="msp-form-space"></span>
            <label><?php _e('OffsetX :', MSWP_TEXT_DOMAIN); ?> </label> {{view MSPanel.ResponsivePositionInput layer=currentLayer axis='x'}} px
            <span class="msp-form-space"></span>
            <label><?php _e('OffsetY :', MSWP_TEXT_DOMAIN); ?> </label> {{view MSPanel.ResponsivePositionInput layer=currentLayer axis='y'}} px
            <span class="msp-form-space"></span>
        </div>
        <div class="msp-metabox-indented">
            <label><?php _e('Width :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=currentLayer.width}} px
            <span class="msp-form-space"></span>
            <label><?php _e('Height :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=currentLayer.height}} px
        </div>

        {{#if maskOptions}}
        <h4><?php _e('Layer mask settings', MSWP_TEXT_DOMAIN); ?></h4>
        <div class="msp-metabox-indented">
            <label><?php _e('Mask layer :', MSWP_TEXT_DOMAIN); ?> </label> {{switch-box value=currentLayer.masked}}
            <span class="msp-form-space"></span>
            {{#if currentLayer.masked}}
            <label><?php _e('Custom mask size :', MSWP_TEXT_DOMAIN); ?> </label> {{switch-box value=currentLayer.maskCustomSize}}
            {{/if}}
        </div>
        {{#if currentLayer.masked}}
        {{#if currentLayer.maskCustomSize}}
        <div class="msp-metabox-indented">
            <label><?php _e('Mask width :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=currentLayer.maskWidth}} px
            <span class="msp-form-space"></span>
            <label><?php _e('Mask height :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=currentLayer.maskHeight}} px
        </div>
        {{/if}}
        {{/if}}
        {{/if}}

        <h4><?php _e('Layer style settings', MSWP_TEXT_DOMAIN); ?></h4>
        <div class="msp-metabox-indented">
            <label><?php _e('Select style for your layer :', MSWP_TEXT_DOMAIN); ?> </label><button {{action "openStyleEditor"}} class="msp-regular"><?php _e('Select...', MSWP_TEXT_DOMAIN); ?></button>
            <span class="msp-form-space"></span>
        </div>
        <div class="msp-metabox-indented">
            <label><?php _e('Resizable layer :', MSWP_TEXT_DOMAIN); ?> </label> {{switch-box value=currentLayer.resize}}
            <span class="msp-form-space"></span>
            <label><?php _e('Hide layer under width :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=currentLayer.widthlimit}} px
        </div>
        <div class="msp-metabox-indented">
            <label><?php _e('Don\'t change layer position when resizing browser :', MSWP_TEXT_DOMAIN); ?> </label> {{switch-box value=currentLayer.fixed}}
        </div>
        <div class="msp-metabox-indented">
            <label><?php _e('Disable swipe navigation when mouse moves over this layer :', MSWP_TEXT_DOMAIN); ?> </label> {{switch-box value=currentLayer.noSwipe}}
        </div>
    </div>
</script>

<!-- layer misc tab -->
<script type="text/x-handlebars" id="layer-misc-settings">
    <div class="msp-metabox-row">
        <div class="msp-metabox-indented">
            <label><?php _e('CSS class name :', MSWP_TEXT_DOMAIN); ?> </label> {{input value=currentLayer.cssClass}}
            <span class="msp-form-space"></span>
            <label><?php _e('CSS id :', MSWP_TEXT_DOMAIN); ?> </label> {{input value=currentLayer.cssId}}
        </div>
        <div class="msp-metabox-indented">
            <label><?php _e('Title attribute :', MSWP_TEXT_DOMAIN); ?> </label> {{input value=currentLayer.title}}
            <span class="msp-form-space"></span>
            <label><?php _e('Rel attribute :', MSWP_TEXT_DOMAIN); ?> </label> {{input value=currentLayer.rel}}
        </div>
    </div>
</script>

<!-- style parameters -->
<script type="text/x-handlebars" id="style-properties">

    {{#tabs-panel id="style-tabs"}}
        <div class="msp-metabox-handle">
            <ul class="tabs">
                <li class="active"><a href="#style-font"><?php _e('Font and typography', MSWP_TEXT_DOMAIN); ?></a></li>
                <li><a href="#style-border"><?php _e('Border', MSWP_TEXT_DOMAIN); ?></a></li>
                <li><a href="#style-padding"><?php _e('Padding', MSWP_TEXT_DOMAIN); ?></a></li>
                <li><a href="#style-custom"><?php _e('Custom style', MSWP_TEXT_DOMAIN); ?></a></li>
            </ul>

            <div class="msp-metabox-toggle"></div>
        </div>

        <ul class="tabs-content">
            <li id="style-font">
                <div class="msp-metabox-indented">
                    <label><?php _e('Background color :', MSWP_TEXT_DOMAIN); ?> </label> {{color-picker value=draftStyle.backgroundColor}}
                    <span class="msp-form-space-med"></span>
                    <label><?php _e('Text color :', MSWP_TEXT_DOMAIN); ?> </label> {{color-picker value=draftStyle.color}}
                    <span class="msp-form-space-med"></span>
                    <label><?php _e('Font size :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=draftStyle.fontSize}} px
                </div>
                <div class="msp-metabox-indented">
                    <label><?php _e('Font :', MSWP_TEXT_DOMAIN); ?> </label> {{google-fonts value=draftStyle.fontFamily variants=fontVariants}}
                    <span class="msp-form-space-med"></span>
                    <label><?php _e('Font weight :', MSWP_TEXT_DOMAIN); ?> </label> {{google-font-weights value=draftStyle.fontWeight variants=fontVariants}}
                    <span class="msp-form-space-med"></span>
                    <label><?php _e('Wordwrap :', MSWP_TEXT_DOMAIN); ?> </label> {{switch-box value=wordwrap}}
                </div>
                <div class="msp-metabox-indented">
                    <label><?php _e('Letter spacing :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=draftStyle.letterSpacing min=null}} px
                    <span class="msp-form-space-med"></span>
                    <label><?php _e('Line height :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=lineHeight}} px
                    <span class="msp-form-space-med"></span>
                    <label><?php _e('Text align :', MSWP_TEXT_DOMAIN); ?> </label>
                    {{#dropdwon-List value=draftStyle.textAlign}}
                        <option value="left"><?php _e('Left', MSWP_TEXT_DOMAIN); ?></option>
                        <option value="center"><?php _e('Center', MSWP_TEXT_DOMAIN); ?></option>
                        <option value="right"><?php _e('Right', MSWP_TEXT_DOMAIN); ?></option>
                        <option value="justify"><?php _e('Justify', MSWP_TEXT_DOMAIN); ?></option>
                    {{/dropdwon-List}}
                </div>
            </li>
            <li id="style-border">
                <div class="msp-metabox-indented">
                    <label><?php _e('Top :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=draftStyle.borderTop}} px
                    <span class="msp-form-space-med"></span>
                    <label><?php _e('Right :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=draftStyle.borderRight}} px
                    <span class="msp-form-space-med"></span>
                    <label><?php _e('Bottom :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=draftStyle.borderBottom}} px
                    <span class="msp-form-space-med"></span>
                    <label><?php _e('Left :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=draftStyle.borderLeft}} px
                </div>
                <div class="msp-metabox-indented">
                    <label><?php _e('Border color :', MSWP_TEXT_DOMAIN); ?> </label> {{color-picker value=draftStyle.borderColor}}
                    <span class="msp-form-space-med"></span>
                    <label><?php _e('Border style :', MSWP_TEXT_DOMAIN); ?> </label>
                    {{#dropdwon-List value=draftStyle.borderStyle}}
                        <option value="solid"><?php _e('Solid', MSWP_TEXT_DOMAIN); ?></option>
                        <option value="none"><?php _e('None', MSWP_TEXT_DOMAIN); ?></option>
                        <option value="hidden"><?php _e('Hidden', MSWP_TEXT_DOMAIN); ?></option>
                        <option value="dotted"><?php _e('Dotted', MSWP_TEXT_DOMAIN); ?></option>
                        <option value="dashed"><?php _e('Dashed', MSWP_TEXT_DOMAIN); ?></option>
                        <option value="double"><?php _e('Double', MSWP_TEXT_DOMAIN); ?></option>
                        <option value="groove"><?php _e('Groove', MSWP_TEXT_DOMAIN); ?></option>
                        <option value="ridge"><?php _e('Ridge', MSWP_TEXT_DOMAIN); ?></option>
                        <option value="inset"><?php _e('Inset', MSWP_TEXT_DOMAIN); ?></option>
                        <option value="outset"><?php _e('Outset', MSWP_TEXT_DOMAIN); ?></option>
                    {{/dropdwon-List}}
                    <span class="msp-form-space-med"></span>
                    <label><?php _e('Rounded corners :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=draftStyle.borderRadius}} px
                </div>
            </li>
            <li id="style-padding">
                <div class="msp-metabox-indented">
                    <label><?php _e('Top :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=draftStyle.paddingTop}} px
                    <span class="msp-form-space-med"></span>
                    <label><?php _e('Right :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=draftStyle.paddingRight}} px
                    <span class="msp-form-space-med"></span>
                    <label><?php _e('Bottom :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=draftStyle.paddingBottom}} px
                    <span class="msp-form-space-med"></span>
                    <label><?php _e('Left :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=draftStyle.paddingLeft}} px
                </div>
            </li>
            <li id="style-custom">
                <div class="msp-metabox-indented">
                    <span><?php _e('You can add more style settings in below box, please make sure to enter a valid CSS. Example: <em>text-transform:uppercase;', MSWP_TEXT_DOMAIN); ?></em> </span>
                </div>
                <div class="msp-metabox-indented">
                    {{#code-mirror tabs="style-tabs" tab="style-custom" width=720 height=120 value=draftStyle.custom}}{{/code-mirror}}
                </div>
            </li>
        </ul>
    {{/tabs-panel}}
</script>

<!-- effect properties in transition editor -->
<script type="text/x-handlebars" id="effect-properties">
    {{#tabs-panel id="style-tabs"}}
        <div class="msp-metabox-handle">
            <ul class="tabs">
                <li class="active"><a href="#trans-general"><?php _e('General and Offset', MSWP_TEXT_DOMAIN); ?></a></li>
                <li><a href="#trans-rotate"><?php _e('Rotate', MSWP_TEXT_DOMAIN); ?></a></li>
                <li><a href="#trans-scale"><?php _e('Scale and Skew', MSWP_TEXT_DOMAIN); ?></a></li>
                <li><a href="#trans-origin"><?php _e('Move Origin', MSWP_TEXT_DOMAIN); ?></a></li>
            </ul>
        </div>
        <ul class="tabs-content">
            <li id="trans-general">
                <div class="msp-metabox-indented">
                    <label><?php _e('Fade :', MSWP_TEXT_DOMAIN); ?> </label> {{switch-box value=draftEffect.fade}}
                    <span class="msp-form-space-med"></span>
                    <label><?php _e('Duration :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=duration step="0.1"}} sec
                    <span class="msp-form-space-med"></span>
                    <label><?php _e('Ease function :', MSWP_TEXT_DOMAIN); ?> </label>
                    {{#dropdwon-List value=ease width=150}}
                        <option value="linear"> linear</option>
                        <option value="easeInCubic"> easeInCubic</option>
                        <option value="easeOutCubic"> easeOutCubic</option>
                        <option value="easeInOutCubic"> easeInOutCubic</option>
                        <option value="easeInCirc"> easeInCirc</option>
                        <option value="easeOutCirc"> easeOutCirc</option>
                        <option value="easeInOutCirc"> easeInOutCirc</option>
                        <option value="easeInExpo"> easeInExpo</option>
                        <option value="easeOutExpo"> easeOutExpo</option>
                        <option value="easeInOutExpo"> easeInOutExpo</option>
                        <option value="easeInQuad"> easeInQuad</option>
                        <option value="easeOutQuad"> easeOutQuad</option>
                        <option value="easeInOutQuad"> easeInOutQuad</option>
                        <option value="easeInQuart"> easeInQuart</option>
                        <option value="easeOutQuart"> easeOutQuart</option>
                        <option value="easeInOutQuart"> easeInOutQuart</option>
                        <option value="easeInQuint"> easeInQuint</option>
                        <option value="easeOutQuint"> easeOutQuint</option>
                        <option value="easeInOutQuint"> easeInOutQuint</option>
                        <option value="easeInSine"> easeInSine</option>
                        <option value="easeOutSine"> easeOutSine</option>
                        <option value="easeInOutSine"> easeInOutSine</option>
                        <option value="easeInBack"> easeInBack</option>
                        <option value="easeOutBack"> easeOutBack</option>
                        <option value="easeInOutBack"> easeInOutBack</option>
                    {{/dropdwon-List}}
                </div>
                <div class="msp-metabox-indented">
                    <label><?php _e('Offset X :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=draftEffect.translateX min=null}} px
                    <span class="msp-form-space-med"></span>
                    <label><?php _e('Offset Y :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=draftEffect.translateY min=null }} px
                    <span class="msp-form-space-med"></span>
                    <label><?php _e('Offset Z :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=draftEffect.translateZ min=null}} px
                </div>
            </li>
            <li id="trans-rotate">
                <div class="msp-metabox-indented">
                    <label><?php _e('2D Rotate :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=draftEffect.rotate min=null}} °
                </div>
                <div class="msp-metabox-indented">
                    <label><?php _e('Rotate X :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=draftEffect.rotateX min=null}} °
                    <span class="msp-form-space-med"></span>
                    <label><?php _e('Rotate Y :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=draftEffect.rotateY min=null}} °
                    <span class="msp-form-space-med"></span>
                    <label><?php _e('Rotate Z :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=draftEffect.rotateZ min=null}} °
                </div>
            </li>
            <li id="trans-scale">
                <div class="msp-metabox-indented">
                    <label><?php _e('Scale X :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=draftEffect.scaleX step="0.05"}}
                    <span class="msp-form-space-med"></span>
                    <label><?php _e('Scale Y :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=draftEffect.scaleY step="0.05"}}
                </div>
                <div class="msp-metabox-indented">
                    <label><?php _e('Skew X :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=draftEffect.skewX min=null}} °
                    <span class="msp-form-space-med"></span>
                    <label><?php _e('Skew Y :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=draftEffect.skewY min=null}} °
                </div>
            </li>
            <li id="trans-origin">
                <div class="msp-metabox-indented">
                    <label><?php _e('Origin X :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=draftEffect.originX  min=null}} %
                    <span class="msp-form-space-med"></span>
                    <label><?php _e('Origin Y :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=draftEffect.originY  min=null}} %
                    <span class="msp-form-space-med"></span>
                    <label><?php _e('Origin Z :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=draftEffect.originZ  min=null}} px
                </div>
            </li>
        </ul>
    {{/tabs-panel}}
</script>

<!-- button parameters -->
<script type="text/x-handlebars" id="button-properties">
    {{#tabs-panel id="button-tabs"}}
        <div class="msp-metabox-handle">
            <ul class="tabs">
                <li class="active"><a href="#button-normal"><?php _e('Normal', MSWP_TEXT_DOMAIN); ?></a></li>
                <li><a href="#button-over"><?php _e('Over', MSWP_TEXT_DOMAIN); ?></a></li>
                <li><a href="#button-active"><?php _e('Pressed', MSWP_TEXT_DOMAIN); ?></a></li>
            </ul>
        </div>

        <ul class="tabs-content">
            <li id="button-normal">
                <div class="msp-metabox-indented">
                    <label><?php _e('Button style :', MSWP_TEXT_DOMAIN); ?>
                     {{#dropdwon-List value=draftBtnStyle width=100}}
                        <option value="ms-btn-box"><?php _e('Box', MSWP_TEXT_DOMAIN); ?></option>
                        <option value="ms-btn-round"><?php _e('Round', MSWP_TEXT_DOMAIN); ?></option>
                        <option value="ms-btn-circle"><?php _e('Circle', MSWP_TEXT_DOMAIN); ?></option>
                    {{/dropdwon-List}}
                    <div class="msp-form-space-med"></div>
                    <label><?php _e('Button style :', MSWP_TEXT_DOMAIN); ?>
                     {{#dropdwon-List value=draftBtnSize width=100}}
                        <option value="ms-btn-n"><?php _e('Normal', MSWP_TEXT_DOMAIN); ?></option>
                        <option value="ms-btn-s"><?php _e('Small', MSWP_TEXT_DOMAIN); ?></option>
                        <option value="ms-btn-m"><?php _e('Medium', MSWP_TEXT_DOMAIN); ?></option>
                        <option value="ms-btn-l"><?php _e('Large', MSWP_TEXT_DOMAIN); ?></option>
                    {{/dropdwon-List}}
                </div>
                <div class="msp-metabox-indented">
                    <span><?php _e('You can add custom style in below box, please make sure to enter a valid CSS. Example: <em>text-transform:uppercase;', MSWP_TEXT_DOMAIN); ?></em> </span>
                </div>
                <div class="msp-metabox-indented">
                    {{#code-mirror tabs="button-tabs" tab="button-normal" width=720 height=220 value=draftNormal}}{{/code-mirror}}
                </div>
            </li>
            <li id="button-over">
              <div class="msp-metabox-indented">
                    <span><?php _e('You can add custom style in below box, please make sure to enter a valid CSS. Example: <em>text-transform:uppercase;', MSWP_TEXT_DOMAIN); ?></em> </span>
                </div>
                <div class="msp-metabox-indented">
                    {{#code-mirror tabs="button-tabs" tab="button-over" width=720 height=270 value=draftHover}}{{/code-mirror}}
                </div>
            </li>
            <li id="button-active">
                <div class="msp-metabox-indented">
                    <span><?php _e('You can add custom style in below box, please make sure to enter a valid CSS. Example: <em>text-transform:uppercase;', MSWP_TEXT_DOMAIN); ?></em> </span>
                </div>
                <div class="msp-metabox-indented">
                    {{#code-mirror tabs="button-tabs" tab="button-active" width=720 height=270 value=draftActive}}{{/code-mirror}}
                </div>
            </li>
        </ul>
    {{/tabs-panel}}
</script>
<!-- Slider Controls -->
<script type="text/x-handlebars" id="controls">
{{#if controllers.application.disableControls}}
     {{#meta-box title="Slider Controls"}}
        <div class="msp-metabox-row">
            <div class="msp-metabox-indented">
                <?php _e('The selected tempalte for slider does not support custom controls.', MSWP_TEXT_DOMAIN); ?>
            </div>
        </div>
    {{/meta-box}}
{{else}}
    {{#meta-box title="Slider Controls"}}
        <div class="msp-metabox-row">

            <h4><?php _e('Here you can add or remove controls to slider', MSWP_TEXT_DOMAIN); ?></h4>

            <div class="msp-metabox-indented">
                <label><?php _e('Add new control', MSWP_TEXT_DOMAIN); ?></label>
                {{#if noMore}}
                    <button class="msp-add-btn disabled"><span class="msp-ico msp-ico-whiteadd"></span></button>
                {{else}}
                    <button {{action addControl}} class="msp-add-btn"><span class="msp-ico msp-ico-whiteadd"></span></button>
                {{/if}}

                {{#dropdwon-List value=selectedControl width=200}}
                    {{#each control in availableControls}}
                        <option {{bind-attr value=control.value}}>{{control.label}}</option>
                    {{else}}
                        <option><?php _e('-- All controls are used --', MSWP_TEXT_DOMAIN); ?></option>
                    {{/each}}
                {{/dropdwon-List}}
            </div>
        </div>
        <hr class="msp-metabox-hr">
        <div class="msp-metabox-row">
            <h4><?php _e('Used controls:', MSWP_TEXT_DOMAIN); ?></h4>
            <div class="msp-metabox-indented">
                {{#each control in controller}}
                    {{view MSPanel.ControlBtn control=control}}
                {{/each}}
            </div>
        </div>
    {{/meta-box}}

    {{partial controlOptions}}
{{/if}}
</script>

<script type="text/x-handlebars" id="arrows-options">
    {{#meta-box title="Arrows Control Options"}}
        <div class="msp-metabox-row">
            <div class="msp-metabox-indented">
                {{switch-box value=currentControl.autoHide}} <label><?php _e('Hide arrows when mouse leaves slider', MSWP_TEXT_DOMAIN); ?></label>
                <div class="msp-form-space-med"></div>
                {{switch-box value=currentControl.overVideo}} <label><?php _e('Show arrows over Youtube/Vimeo video player', MSWP_TEXT_DOMAIN); ?></label>
            </div>
            <div class="msp-metabox-indented">
                <label><?php _e('Hide arrows for window width less than :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=currentControl.hideUnder}} px
            </div>

            {{!--<div class="msp-metabox-indented">
                {{switch-box value=currentControl.inset}} <label><?php _e('Insert arrows inside slider', MSWP_TEXT_DOMAIN); ?></label>
            </div>
            <div class="msp-metabox-indented">
                <label><?php _e('Arrows margin :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=currentControl.margin min=null}} px
            </div>--}}
        </div>
    {{/meta-box}}
</script>

<script type="text/x-handlebars" id="timebar-options">
    {{#meta-box title="Line Timer Control Options"}}
        <div class="msp-metabox-row">
            <div class="msp-metabox-indented">
                {{switch-box value=currentControl.autoHide}} <label><?php _e('Hide line timer when mouse leaves slider', MSWP_TEXT_DOMAIN); ?></label>
                <div class="msp-form-space-med"></div>
                {{switch-box value=currentControl.overVideo}} <label><?php _e('Show line timer over Youtube/Vimeo video player', MSWP_TEXT_DOMAIN); ?></label>
            </div>
            <div class="msp-metabox-indented">
                <?php _e('Align control :', MSWP_TEXT_DOMAIN); ?>
                {{#dropdwon-List value=currentControl.align width=100}}
                    <option value="top"><?php _e('Top', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="bottom"><?php _e('Bottom', MSWP_TEXT_DOMAIN); ?></option>
                {{/dropdwon-List}}
                <div class="msp-form-space-med"></div>
                <label><?php _e('Hide line timer for window width less than :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=currentControl.hideUnder}} px
            </div>
            <div class="msp-metabox-indented">
                <label><?php _e('Line timer color :', MSWP_TEXT_DOMAIN); ?> </label> {{color-picker value=currentControl.color}}
                <div class="msp-form-space-med"></div>
                <label><?php _e('Line timer width :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=currentControl.width}} px
            </div>
        </div>
    {{/meta-box}}
</script>

<script type="text/x-handlebars" id="bullets-options">
    {{#meta-box title="Bullets Control Options"}}
        <div class="msp-metabox-row">
            <div class="msp-metabox-indented">
                {{switch-box value=currentControl.autoHide}} <label><?php _e('Hide bullets when mouse leaves slider', MSWP_TEXT_DOMAIN); ?></label>
                <div class="msp-form-space-med"></div>
                {{switch-box value=currentControl.overVideo}} <label><?php _e('Show bullets over Youtube/Vimeo video player', MSWP_TEXT_DOMAIN); ?></label>
            </div>
           {{!-- <div class="msp-metabox-indented">
                {{switch-box value=currentControl.inset}} <label><?php _e('Insert bullets inside slider', MSWP_TEXT_DOMAIN); ?></label>
            </div> --}}
            <div class="msp-metabox-indented">
                <?php _e('Align control :', MSWP_TEXT_DOMAIN); ?>
                {{#dropdwon-List value=currentControl.align width=100}}
                    <option value="top"><?php _e('Top', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="right"><?php _e('Right', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="left"><?php _e('Left', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="bottom"><?php _e('Bottom', MSWP_TEXT_DOMAIN); ?></option>
                {{/dropdwon-List}}
                <div class="msp-form-space-med"></div>
                <label><?php _e('Bullets margin :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=currentControl.margin min=null}} px
                <div class="msp-form-space-med"></div>
                <label><?php _e('Space between bullets :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=currentControl.space min=null}} px
            </div>
            <div class="msp-metabox-indented">
                <label><?php _e('Hide bullets for window width less than :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=currentControl.hideUnder}} px
            </div>
        </div>
    {{/meta-box}}
</script>

<script type="text/x-handlebars" id="scrollbar-options">
    {{#meta-box title="Scrollbar Control Options"}}
        <div class="msp-metabox-row">
            <div class="msp-metabox-indented">
                {{switch-box value=currentControl.autoHide}} <label><?php _e('Hide scrollbar when mouse leaves slider', MSWP_TEXT_DOMAIN); ?></label>
                 <div class="msp-form-space-med"></div>
                {{switch-box value=currentControl.overVideo}} <label><?php _e('Show scrollbar over Youtube/Vimeo video player', MSWP_TEXT_DOMAIN); ?></label>
            </div>
            <div class="msp-metabox-indented">
                {{switch-box value=currentControl.inset}} <label><?php _e('Insert scrollbar inside slider', MSWP_TEXT_DOMAIN); ?></label>
            </div>

            {{!--<div class="msp-metabox-indented">
                <label><?php _e('Scrollbar direction :', MSWP_TEXT_DOMAIN); ?> </label>
                {{#dropdwon-List value=currentControl.dir width=100}}
                    <option value="h"><?php _e('Horizontal', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="v"><?php _e('Vertical', MSWP_TEXT_DOMAIN); ?></option>
                {{/dropdwon-List}}
                <div class="msp-form-space-med"></div>
            </div>--}}

            <div class="msp-metabox-indented">
               <label><?php _e('Scrollbar handle color :', MSWP_TEXT_DOMAIN); ?> </label> {{color-picker value=currentControl.color}}
               <div class="msp-form-space-med"></div>
               <label><?php _e('Hide scrollbar for window width less than :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=currentControl.hideUnder}} px
            </div>
            <div class="msp-metabox-indented">
                <?php _e('Align control :', MSWP_TEXT_DOMAIN); ?>
                {{#dropdwon-List value=currentControl.align width=100}}
                    <option value="top"><?php _e('Top', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="right"><?php _e('Right', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="left"><?php _e('Left', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="bottom"><?php _e('Bottom', MSWP_TEXT_DOMAIN); ?></option>
                {{/dropdwon-List}}
                <div class="msp-form-space-med"></div>
                <label><?php _e('Scrollbar width :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=currentControl.width}} px
                <div class="msp-form-space-med"></div>
                <label><?php _e('Scrollbar margin :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=currentControl.margin min=null}} px
            </div>
        </div>
    {{/meta-box}}
</script>

<script type="text/x-handlebars" id="circletimer-options">
    {{#meta-box title="Circle Timer Control Options"}}
        <div class="msp-metabox-row">
            <div class="msp-metabox-indented">
                {{switch-box value=currentControl.autoHide}} <label><?php _e('Hide cricle timer when mouse leaves slider', MSWP_TEXT_DOMAIN); ?></label>
                <div class="msp-form-space-med"></div>
                {{switch-box value=currentControl.overVideo}} <label><?php _e('Show circle timer over Youtube/Vimeo video player', MSWP_TEXT_DOMAIN); ?></label>
            </div>
             {{!--<div class="msp-metabox-indented">
                <?php _e('Align control :', MSWP_TEXT_DOMAIN); ?>
                {{#dropdwon-List value=currentControl.align width=100}}
                    <option value="tl"><?php _e('Top Left', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="tr"><?php _e('Top Right', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="bl"><?php _e('Bottom Left', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="br"><?php _e('Bottom Right', MSWP_TEXT_DOMAIN); ?></option>
                {{/dropdwon-List}}
            </div>--}}
            <div class="msp-metabox-indented">
                <label><?php _e('Hide circle timer for window width less than :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=currentControl.hideUnder}} px
            </div>
            <div class="msp-metabox-indented">
                {{!--<label><?php _e('Circle timer margin :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=currentControl.margin min=null}} px
                <div class="msp-form-space-med"></div>--}}
                <label><?php _e('Circle stroke :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=currentControl.stroke}} px
                <div class="msp-form-space-med"></div>
                <label><?php _e('Circle radius :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=currentControl.radius}} px
                <div class="msp-form-space-med"></div>
                <label><?php _e('Circle color :', MSWP_TEXT_DOMAIN); ?> </label> {{color-picker value=currentControl.color}}
            </div>
        </div>
    {{/meta-box}}
</script>

<script type="text/x-handlebars" id="slideinfo-options">
    {{#meta-box title="Slide Info Control Options"}}
        <div class="msp-metabox-row">
            <div class="msp-metabox-indented">
                {{switch-box value=currentControl.autoHide}} <label><?php _e('Hide slide info when mouse leaves slider', MSWP_TEXT_DOMAIN); ?></label>
                <div class="msp-form-space-med"></div>
                {{switch-box value=currentControl.overVideo}} <label><?php _e('Show slide info over Youtube/Vimeo video player', MSWP_TEXT_DOMAIN); ?></label>
            </div>
            <div class="msp-metabox-indented">
                {{switch-box value=currentControl.inset}} <label><?php _e('Insert slide info inside slider', MSWP_TEXT_DOMAIN); ?></label>
            </div>
            <div class="msp-metabox-indented">
                <?php _e('Align control :', MSWP_TEXT_DOMAIN); ?>
                {{#dropdwon-List value=currentControl.align width=100}}
                    <option value="top"><?php _e('Top', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="right"><?php _e('Right', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="left"><?php _e('Left', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="bottom"><?php _e('Bottom', MSWP_TEXT_DOMAIN); ?></option>
                {{/dropdwon-List}}
                <div class="msp-form-space-med"></div>
                <label><?php _e('Slide info margin :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=currentControl.margin min=null}} px
            </div>
            <div class="msp-metabox-indented">
                <label><?php _e('Slide info width :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=currentControl.width}} px
                <div class="msp-form-space-med"></div>
                <label><?php _e('Slide info height :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=currentControl.height}} px
            </div>
        </div>
            <div class="msp-metabox-indented">
                <label><?php _e('Hide slide info for window width less than :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=currentControl.hideUnder}} px
            </div>
        </div>
    {{/meta-box}}
</script>

<script type="text/x-handlebars" id="thumblist-options">
    {{#meta-box title="Thumblist/Tabs Control Options"}}
        <div class="msp-metabox-row">
            <div class="msp-metabox-indented">
                {{switch-box value=currentControl.autoHide}} <label><?php _e('Hide thumblist/tabs when mouse leaves slider', MSWP_TEXT_DOMAIN); ?></label>
                <div class="msp-form-space-med"></div>
                {{switch-box value=currentControl.overVideo}} <label><?php _e('Show thumblist/tabs over Youtube/Vimeo video player', MSWP_TEXT_DOMAIN); ?></label>
            </div>
            <div class="msp-metabox-indented">
                {{switch-box value=currentControl.inset}} <label><?php _e('Insert thumblist/tabs inside slider', MSWP_TEXT_DOMAIN); ?></label>
                <div class="msp-form-space-med"></div>
                {{switch-box value=currentControl.arrows}} <label><?php _e('Insert navigation arrows', MSWP_TEXT_DOMAIN); ?></label>
            </div>
            <div class="msp-metabox-indented">
                {{switch-box value=currentControl.hoverChange}} <label><?php _e('Change slides on hovering over thumbs/tabs.', MSWP_TEXT_DOMAIN); ?></label>
            </div>
            <div class="msp-metabox-indented">
                <?php _e('Align control :', MSWP_TEXT_DOMAIN); ?>
                {{#dropdwon-List value=currentControl.align width=100}}
                    <option value="top"><?php _e('Top', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="right"><?php _e('Right', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="left"><?php _e('Left', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="bottom"><?php _e('Bottom', MSWP_TEXT_DOMAIN); ?></option>
                {{/dropdwon-List}}
                <div class="msp-form-space-med"></div>
                <label><?php _e('Thumblist/Tabs margin :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=currentControl.margin min=null}} px
            </div>
            <div class="msp-metabox-indented">
                <?php _e('Appearance :', MSWP_TEXT_DOMAIN); ?>
                {{#dropdwon-List value=currentControl.type width=100}}
                    <option value="thumbs"><?php _e('Thumblist', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="tabs"><?php _e('Tabs', MSWP_TEXT_DOMAIN); ?></option>
                {{/dropdwon-List}}
                <div class="msp-form-space-med"></div>
                <label><?php _e('Hide thumblist/tabs for window width less than :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=currentControl.hideUnder}} px
            </div>

            {{!--<div class="msp-metabox-indented">
                <label><?php _e('Thumblist/Tabs direction :', MSWP_TEXT_DOMAIN); ?> </label>
                {{#dropdwon-List value=currentControl.dir width=100}}
                    <option value="h"><?php _e('Horizontal', MSWP_TEXT_DOMAIN); ?></option>
                    <option value="v"><?php _e('Vertical', MSWP_TEXT_DOMAIN); ?></option>
                {{/dropdwon-List}}
            </div>--}}

            {{#if isTab}}
                <div class="msp-metabox-indented">
                    {{switch-box value=currentControl.insertThumb}} <?php _e('Insert thumbnail inside tabs', MSWP_TEXT_DOMAIN); ?>
                </div>
            {{else}}
                <div class="msp-metabox-indented">
                    <?php _e('Thumb background fill mode :', MSWP_TEXT_DOMAIN); ?>
                    {{view MSPanel.Fillmode value=currentControl.fillMode}}
                 </div>
            {{/if}}

            <div class="msp-metabox-indented">
                <label><?php _e('Thumb/Tab width :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=currentControl.width}} px
                <div class="msp-form-space-med"></div>
                <label><?php _e('Thumb/Tab height :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=currentControl.height}} px
                <div class="msp-form-space-med"></div>
                <label><?php _e('Space between thumbs/tabs :', MSWP_TEXT_DOMAIN); ?> </label> {{number-input value=currentControl.space}} px
            </div>

        </div>
    {{/meta-box}}
</script>

<!-- Slider Apis -->
<script type="text/x-handlebars" id="callbacks">
    {{#meta-box title="Slider Callbacks"}}
        <div class="msp-metabox-row">

            <h4><?php _e('Here you can add or remove callbacks to slider', MSWP_TEXT_DOMAIN); ?></h4>

            <div class="msp-metabox-indented">
                <label><?php _e('Add new callback', MSWP_TEXT_DOMAIN); ?></label>
                {{#if noMore}}
                    <button class="msp-add-btn disabled"><span class="msp-ico msp-ico-whiteadd"></span></button>
                {{else}}
                    <button {{action addCallback}} class="msp-add-btn"><span class="msp-ico msp-ico-whiteadd"></span></button>
                {{/if}}

                {{#dropdwon-List value=selectedCallback width=250}}
                    {{#each callback in availableCallbacks}}
                        <option {{bind-attr value=callback.value}}>{{callback.label}}</option>
                    {{else}}
                        <option><?php _e('-- All callbacks are added --', MSWP_TEXT_DOMAIN); ?></option>
                    {{/each}}
                {{/dropdwon-List}}
            </div>
        </div>
        {{#each callback in controller}}
            <hr class="msp-metabox-hr">
            <div class="msp-metabox-row">
                <h4>{{callback.label}} : </h4>
                <div class="msp-metabox-indented">
                    {{#code-mirror width="100%" height="auto" mode="javascript" value=callback.content}}{{/code-mirror}}
                </div>
                <div class="msp-metabox-indented">
                    <button {{action "removeCallback" callback}} class="msp-blue-btn msp-remove-btn-med"><?php _e('Remove', MSWP_TEXT_DOMAIN); ?></button>
                </div>
            </div>
        {{/each}}
    {{/meta-box}}
</script>

<!-- Slider Templates -->
<script type="text/x-handlebars" id="TemplatesModal">
    <div class="msp-metabox-row">
        <h4><?php _e('Here you can choose template for the slider. Please note that selecting template may overwrite some slider options. If you want to have full control on options, select "Custom Template".', MSWP_TEXT_DOMAIN); ?></h4>
    </div>
    <hr class="msp-metabox-hr">
    <div class="msp-templates-list">
        {{#each template in templates}}
            {{view MSPanel.TemplateFigure msTemplate=template}}
        {{/each}}
    </div>
    <div class="msp-templates-bottom">
        <button {{action "saveTemplate"}} class="msp-blue-btn msp-applyeffect msp-tempalte-save"><?php _e('Save', MSWP_TEXT_DOMAIN); ?></button>
    </div>
</script>
<!-- empty template -->
<script type="text/x-handlebars" id="empty-template"></script>
