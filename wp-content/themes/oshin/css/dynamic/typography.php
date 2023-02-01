<?php
/* ======================
    Typography
   ====================== */
$parsed_to_typehub = get_option( 'oshine_redux_to_typehub' );
// Run only when Redux is not parsed to Typehub. Parser is run during typehub activation 
if( empty( $parsed_to_typehub ) ) :
?>
body,
.special-heading-wrap .caption-wrap .body-font,
.woocommerce .woocommerce-ordering select.orderby, 
.woocommerce-page .woocommerce-ordering select.orderby {
  <?php be_themes_print_typography('body_text'); ?>
  -webkit-font-smoothing: antialiased; 
  -moz-osx-font-smoothing: grayscale;
}

h1 {
  <?php be_themes_print_typography('h1'); ?>
}

h2 {
  <?php be_themes_print_typography('h2'); ?>
}

h3 {
  <?php be_themes_print_typography('h3'); ?>
}

h4,
.woocommerce-order-received .woocommerce h2, 
.woocommerce-order-received .woocommerce h3,
.woocommerce-view-order .woocommerce h2, 
.woocommerce-view-order .woocommerce h3{
  <?php be_themes_print_typography('h4'); ?>
}

h5, #reply-title {
  <?php be_themes_print_typography('h5'); ?>
  }

h6,
.testimonial-author-role.h6-font,
.menu-card-title,
.menu-card-item-price,
.slider-counts,
.woocommerce-MyAccount-navigation ul li {
  <?php be_themes_print_typography('h6'); ?>
}

<?php if( isset($be_themes_data['enable_portfolio_details_typo']) && $be_themes_data['enable_portfolio_details_typo'] == true ) {?>
h6.gallery-side-heading {
  <?php be_themes_print_typography('portfolio_details_title'); ?>
}
.portfolio-details .gallery-side-heading-wrap p{
  <?php be_themes_print_typography('portfolio_details_content'); ?>
}
<?php } else { ?>
h6.gallery-side-heading {
  font-size: <?php echo $be_themes_data['body_text']['font-size']; ?>;
}
<?php } ?>

.special-subtitle , 
.style1.thumb-title-wrap .portfolio-item-cats {
  font-style: <?php echo $be_themes_data['sub_title']['font-style']; ?>;
  font-size: <?php echo $be_themes_data['sub_title']['font-size']; ?>;
  font-weight: <?php echo $be_themes_data['sub_title']['font-weight']; ?>;
  font-family: <?php echo $be_themes_data['sub_title']['font-family']; ?>;
  text-transform: <?php echo $be_themes_data['sub_title']['text-transform']; ?>;
  letter-spacing: 0px;
}

.gallery-side-heading {
  font-size: <?php echo $be_themes_data['body_text']['font-size']; ?>;
}

.attachment-details-custom-slider {
  <?php be_themes_background_colors($be_themes_data['portfolio_caption_bg']['color'], $be_themes_data['portfolio_caption_bg']['alpha']); ?>
  <?php be_themes_print_typography('portfolio_caption_typo'); ?>
}

.single-portfolio-slider .carousel_bar_wrap {
  <?php be_themes_background_colors($be_themes_data['thumbnail_bar_color']['color'], $be_themes_data['thumbnail_bar_color']['alpha']); ?>
}

.top-right-sliding-menu .sb-right ul#slidebar-menu li,
.overlay-menu-close,
.be-overlay-menu-close {
  <?php be_themes_print_typography('sidebar_menu_text'); ?>
}

.top-right-sliding-menu .sb-right ul#slidebar-menu li a {
  color: <?php echo $be_themes_data['sidebar_menu_text']['color'] ; ?> !important;
}

.top-right-sliding-menu .sb-right #slidebar-menu ul.sub-menu li {
  <?php be_themes_print_typography('sidebar_submenu_text'); ?>
}

.top-right-sliding-menu .sb-right ul#slidebar-menu li a {
  color: <?php echo $be_themes_data['sidebar_submenu_text']['color'] ; ?> !important;
}

.sb-right #slidebar-menu .mega .sub-menu .highlight .sf-with-ul {
<?php be_themes_print_typography('sidebar_menu_text'); ?>
  color: <?php echo $be_themes_data['sidebar_submenu_text']['color'] ; ?> !important;
}

.post-meta.post-top-meta-typo,
.style8-blog .post-meta.post-category a,
.hero-section-blog-categories-wrap a {
  <?php be_themes_print_typography('post_top_meta_options'); ?>;
}

#portfolio-title-nav-bottom-wrap h6,
#portfolio-title-nav-bottom-wrap .slider-counts {
  <?php be_themes_print_typography('portfolio_title_count_typo'); ?>;  
line-height: 40px;
}

.filters .filter_item {
  <?php be_themes_print_typography('portfolio_filter_typo'); ?>;  
}

ul#mobile-menu a {
  <?php be_themes_print_typography('mobile_menu_text'); ?>
}

ul#mobile-menu ul.sub-menu a {
  <?php be_themes_print_typography('mobile_submenu_text'); ?> 
}

ul#mobile-menu li.mega ul.sub-menu li.highlight > :first-child {
  <?php be_themes_print_typography('mobile_menu_text'); ?>
}

#navigation,
.style2 #navigation,
.style13 #navigation,
#navigation-left-side,
#navigation-right-side,
.sb-left  #slidebar-menu,
.header-widgets,
.header-code-widgets,
body #header-inner-wrap.top-animate.style2 #navigation,
.top-overlay-menu .sb-right  #slidebar-menu,
#navigation .mega .sub-menu .highlight .sf-with-ul,
.special-header-menu .menu-container {
  <?php be_themes_print_typography('navigation_text'); ?>
}

#navigation .sub-menu,
#navigation .children,
#navigation-left-side .sub-menu,
#navigation-left-side .children,
#navigation-right-side .sub-menu,
#navigation-right-side .children,
.sb-left  #slidebar-menu .sub-menu,
.top-overlay-menu .sb-right  #slidebar-menu .sub-menu,
.special-header-menu .menu-container .sub-menu,
.special-header-menu .sub-menu {
  <?php be_themes_print_typography('submenu_text'); ?>
}

.thumb-title-wrap .thumb-title {
  <?php be_themes_print_typography('portfolio_title'); ?>
}

.thumb-title-wrap .portfolio-item-cats {
  font-size: <?php echo $be_themes_data['portfolio_meta_typo']['font-size']; ?>;
  line-height: <?php echo $be_themes_data['portfolio_meta_typo']['line-height']; ?>;
  text-transform: <?php echo $be_themes_data['portfolio_meta_typo']['text-transform']; ?>;
  letter-spacing: <?php echo $be_themes_data['portfolio_meta_typo']['letter-spacing']; ?>;
}

.full-screen-portfolio-overlay-title {
  <?php be_themes_print_typography('portfolio_title'); ?>
}

#footer {
  <?php be_themes_print_typography('footer_text'); ?>
}

#bottom-widgets h6 {
  <?php be_themes_print_typography('bottom_widget_title'); ?>
  margin-bottom:20px;
}

#bottom-widgets {
  <?php be_themes_print_typography('bottom_widget_text'); ?>
}

.sidebar-widgets h6 {
  <?php be_themes_print_typography('sidebar_widget_title'); ?>
  margin-bottom:20px;
}

.sidebar-widgets {
  ?php be_themes_print_typography('sidebar_widget_text'); ?>
}

.sb-slidebar .widget {
  <?php be_themes_print_typography('slidebar_widget_text'); ?>
}
.sb-slidebar .widget h6 {
  <?php be_themes_print_typography('slidebar_widget_title'); ?>
}

.woocommerce ul.products li.product .product-meta-data h3, 
.woocommerce-page ul.products li.product .product-meta-data h3,
.woocommerce ul.products li.product h3, 
.woocommerce-page ul.products li.product h3 {
  <?php be_themes_print_typography('shop_page_title'); ?>
}

.woocommerce ul.products li.product .product-meta-data .woocommerce-loop-product__title, 
.woocommerce-page ul.products li.product .product-meta-data .woocommerce-loop-product__title,
.woocommerce ul.products li.product .woocommerce-loop-product__title, 
.woocommerce-page ul.products li.product .woocommerce-loop-product__title,
.woocommerce ul.products li.product-category .woocommerce-loop-category__title, 
.woocommerce-page ul.products li.product-category .woocommerce-loop-category__title {
  <?php be_themes_print_typography('shop_page_title'); ?>
  margin-bottom:5px;
  text-align: center;
}

.woocommerce-page.single.single-product #content div.product h1.product_title.entry-title {
  <?php be_themes_print_typography('shop_single_page_title'); ?>
}

.contact_form_module input[type="text"], 
.contact_form_module textarea {
  <?php be_themes_print_typography('contact_form_typo'); ?>
}

.page-title-module-custom .page-title-custom,
h6.portfolio-title-nav{
  <?php be_themes_print_typography('page_title_module_typo'); ?>
}

.tatsu-button,
.be-button,
.woocommerce a.button, .woocommerce-page a.button, 
.woocommerce button.button, .woocommerce-page button.button, 
.woocommerce input.button, .woocommerce-page input.button, 
.woocommerce #respond input#submit, .woocommerce-page #respond input#submit,
.woocommerce #content input.button, .woocommerce-page #content input.button,
input[type="submit"],
.more-link.style1-button,
.more-link.style2-button,
.more-link.style3-button,
input[type="button"], 
input[type="submit"], 
input[type="reset"], 
button,
input[type="file"]::-webkit-file-upload-button {
  font-family: <?php echo $be_themes_data['button_font']['font-family'];  ?>;
  font-weight: <?php echo $be_themes_data['button_font']['font-weight'];  ?>;
}

.post-title ,
.post-date-wrap {
  <?php be_themes_print_typography('post_title'); ?>
  margin-bottom: 12px;
}

.style3-blog .post-title,
.style8-blog .post-title {
  <?php be_themes_print_typography('masonry_post_title'); ?>
}

.post-nav li,
.style8-blog .post-meta.post-date,
.style8-blog .post-bottom-meta-wrap,
.hero-section-blog-bottom-meta-wrap {
  <?php be_themes_print_typography('post_meta_options'); ?>
}

<?php if( isset( $be_themes_data[ 'single_post_typo' ] ) && !empty( $be_themes_data[ 'single_post_typo' ] ) ) {?>
.single-post .post-title,
.single-post .style3-blog .post-title,
.single-post .style8-blog .post-title {
  <?php be_themes_print_typography( 'single_post_title' ); ?>
}
<?php } ?>

.ui-tabs-anchor, 
.accordion .accordion-head,
.skill-wrap .skill_name,
.chart-wrap span,
.animate-number-wrap h6 span,
.woocommerce-tabs .tabs li a,
.be-countdown {
  font-family: <?php echo $be_themes_data['pb_module_title']['font-family']; ?>;
  letter-spacing: <?php echo $be_themes_data['pb_module_title']['letter-spacing']; ?>;
  font-style: <?php echo $be_themes_data['pb_module_title']['font-style']; ?>;
  font-weight: <?php echo $be_themes_data['pb_module_title']['font-weight']; ?>;
}

.ui-tabs-anchor {
  font-size: <?php echo $be_themes_data['pb_tab_font_size']['font-size']; ?>;
  line-height: <?php echo $be_themes_data['pb_tab_font_size']['line-height']; ?>;
  text-transform: <?php echo $be_themes_data['pb_tab_font_size']['text-transform']; ?>;
}

.accordion .accordion-head {
  font-size: <?php echo $be_themes_data['pb_acc_font_size']['font-size']; ?>;
  line-height: <?php echo $be_themes_data['pb_acc_font_size']['line-height']; ?>;
  text-transform: <?php echo $be_themes_data['pb_acc_font_size']['text-transform']; ?>;
}

.skill-wrap .skill_name {
  font-size: <?php echo $be_themes_data['pb_skill_font_size']['font-size']; ?>;
  line-height: <?php echo $be_themes_data['pb_skill_font_size']['line-height']; ?>;
  text-transform: <?php echo $be_themes_data['pb_skill_font_size']['text-transform']; ?>;
}

.countdown-section {
  font-size: <?php echo $be_themes_data['pb_countdown_caption_font_size']['font-size']; ?>;
  line-height: <?php echo $be_themes_data['pb_countdown_caption_font_size']['line-height']; ?>;
  text-transform: <?php echo $be_themes_data['pb_countdown_caption_font_size']['text-transform']; ?>;
}

.countdown-amount {
  font-size: <?php echo $be_themes_data['pb_countdown_number_font_size']['font-size']; ?>;
  line-height: <?php echo $be_themes_data['pb_countdown_number_font_size']['line-height']; ?>;
  text-transform: <?php echo $be_themes_data['pb_countdown_number_font_size']['text-transform']; ?>;
}

.tweet-slides .tweet-content {
  font-family: <?php echo $be_themes_data['pb_module_tweet']['font-family']; ?>;
  letter-spacing: <?php echo $be_themes_data['pb_module_tweet']['letter-spacing']; ?>;
  font-style: <?php echo $be_themes_data['pb_module_tweet']['font-style']; ?>;
  font-weight: <?php echo $be_themes_data['pb_module_tweet']['font-weight']; ?>;
  text-transform: <?php echo $be_themes_data['pb_module_tweet']['text-transform']; ?>;
}

.testimonial_slide .testimonial-content {
  font-family: <?php echo $be_themes_data['pb_module_spl_body']['font-family']; ?>;
  letter-spacing: <?php echo $be_themes_data['pb_module_spl_body']['letter-spacing']; ?>;
  font-style: <?php echo $be_themes_data['pb_module_spl_body']['font-style']; ?>;
  font-weight: <?php echo $be_themes_data['pb_module_spl_body']['font-weight']; ?>;
  text-transform: <?php echo $be_themes_data['pb_module_spl_body']['text-transform']; ?>;
}

.oshine-animated-link,
.view-project-link.style4-button {
  font-family: <?php echo $be_themes_data['animated_link_font']['font-family'];  ?>;
  font-weight: <?php echo $be_themes_data['animated_link_font']['font-weight'];  ?>;
  letter-spacing: <?php echo $be_themes_data['animated_link_font']['letter-spacing']; ?>;
  font-style: <?php echo $be_themes_data['animated_link_font']['font-style']; ?>;
  text-transform: <?php echo $be_themes_data['animated_link_font']['text-transform']; ?>;
}

a.navigation-previous-post-link,
a.navigation-next-post-link {
  <?php be_themes_print_typography('portfolio_nav_bottom_typography'); ?>;
}

@media only screen and (max-width : 767px ) {
<?php if ( isset($be_themes_data['mobile_typo_controller']) && 1== ($be_themes_data['mobile_typo_controller']) ) { ?>
h1{
  font-size: <?php echo ((isset($be_themes_data['h1_mobile']['font-size']) && !empty($be_themes_data['h1_mobile']['font-size']) ) ? $be_themes_data['h1_mobile']['font-size'] : '30px' ) ; ?>;
  line-height: <?php echo ((isset($be_themes_data['h1_mobile']['line-height']) && !empty($be_themes_data['h1_mobile']['line-height']) ) ? $be_themes_data['h1_mobile']['line-height'] : '40px' ) ; ?>;
}    
h2{
  font-size: <?php echo ((isset($be_themes_data['h2_mobile']['font-size']) && !empty($be_themes_data['h2_mobile']['font-size']) ) ? $be_themes_data['h2_mobile']['font-size'] : '25px' ) ; ?>;
  line-height: <?php echo ((isset($be_themes_data['h2_mobile']['line-height']) && !empty($be_themes_data['h2_mobile']['line-height']) ) ? $be_themes_data['h2_mobile']['line-height'] : '35px' ) ; ?>;
}    
h3{
  font-size: <?php echo ((isset($be_themes_data['h3_mobile']['font-size']) && !empty($be_themes_data['h3_mobile']['font-size']) ) ? $be_themes_data['h3_mobile']['font-size'] : '20px' ) ; ?>;
  line-height: <?php echo ((isset($be_themes_data['h3_mobile']['line-height']) && !empty($be_themes_data['h3_mobile']['line-height']) ) ? $be_themes_data['h3_mobile']['line-height'] : '30px' ) ; ?>;
}    
h4{
  font-size: <?php echo ((isset($be_themes_data['h4_mobile']['font-size']) && !empty($be_themes_data['h4_mobile']['font-size']) ) ? $be_themes_data['h4_mobile']['font-size'] : '16px' ) ; ?>;
  line-height: <?php echo ((isset($be_themes_data['h4_mobile']['line-height']) && !empty($be_themes_data['h4_mobile']['line-height']) ) ? $be_themes_data['h4_mobile']['line-height'] : '30px' ) ; ?>;
}    
h5{
  font-size: <?php echo ((isset($be_themes_data['h5_mobile']['font-size']) && !empty($be_themes_data['h5_mobile']['font-size']) ) ? $be_themes_data['h5_mobile']['font-size'] : '16px' ) ; ?>;
  line-height: <?php echo ((isset($be_themes_data['h5_mobile']['line-height']) && !empty($be_themes_data['h5_mobile']['line-height']) ) ? $be_themes_data['h5_mobile']['line-height'] : '30px' ) ; ?>;
}    
h6{
  font-size: <?php echo ((isset($be_themes_data['h6_mobile']['font-size']) && !empty($be_themes_data['h6_mobile']['font-size']) ) ? $be_themes_data['h6_mobile']['font-size'] : '15px' ) ; ?>;
  line-height: <?php echo ((isset($be_themes_data['h6_mobile']['line-height']) && !empty($be_themes_data['h6_mobile']['line-height']) ) ? $be_themes_data['h6_mobile']['line-height'] : '32px' ) ; ?>;
}

<?php } else { ?>

#hero-section h1 , 
.full-screen-section-wrap h1,
.tatsu-fullscreen-wrap h1 {
  font-size: 30px;
  line-height: 40px;
}
#hero-section h2,
.full-screen-section-wrap h2,
.tatsu-fullscreen-wrap h2 { 
  font-size: 25px;
  line-height: 35px;
}
#hero-section h4,
.full-screen-section-wrap h4,
.tatsu-fullscreen-wrap h3 {
  font-size: 16px;
  line-height: 30px;
}
#hero-section h5,
.full-screen-section-wrap h5,
.tatsu-fullscreen-wrap h5 {
  font-size: 16px;
  line-height: 30px;
}

<?php } 
?>
}

/* RELATED TO TYPOGRAPHY */

#header-controls-right,
#header-controls-left {
  color: <?php echo $be_themes_data['navigation_text']['color'] ; ?>
}

#be-left-strip .be-mobile-menu-icon span {
    background-color: <?php echo ( !isset( $be_themes_data[ 'mobile_menu_icon_color' ] ) || empty( $be_themes_data[ 'mobile_menu_icon_color' ] ) ) ?  $be_themes_data['navigation_text']['color'] : $be_themes_data[ 'mobile_menu_icon_color' ] ; ?>
}

ul#mobile-menu .mobile-sub-menu-controller {
  line-height : <?php echo $be_themes_data['mobile_menu_text']['line-height'] ; ?> ;
}

ul#mobile-menu ul.sub-menu .mobile-sub-menu-controller{
  line-height : <?php echo $be_themes_data['mobile_submenu_text']['line-height'] ; ?> ;
}

.breadcrumbs {
  color: <?php echo $be_themes_data['page_title_module_typo']['color']; ?>;
}

.search-box-wrapper.style2-header-search-widget input[type="text"]{
  font-style: <?php echo $be_themes_data['sub_title']['font-style']; ?>;
  font-weight: <?php echo $be_themes_data['sub_title']['font-weight']; ?>;
  font-family: <?php echo $be_themes_data['sub_title']['font-family']; ?>;
}

.portfolio-share a.custom-share-button, 
.portfolio-share a.custom-share-button:active, 
.portfolio-share a.custom-share-button:hover, 
.portfolio-share a.custom-share-button:visited {
  color: <?php echo $be_themes_data['h6']['color']; ?>; 
}

.more-link.style2-button {
  color: <?php echo $be_themes_data['post_title']['color'];  ?> !important;
  border-color: <?php echo $be_themes_data['post_title']['color'];  ?> !important;
}

.style8-blog .post-bottom-meta-wrap .be-share-stack a.custom-share-button, 
.style8-blog .post-bottom-meta-wrap .be-share-stack a.custom-share-button:active, 
.style8-blog .post-bottom-meta-wrap .be-share-stack a.custom-share-button:hover, 
.style8-blog .post-bottom-meta-wrap .be-share-stack a.custom-share-button:visited {
  color: <?php echo $be_themes_data['post_meta_options']['color']; ?>; 
}

.hero-section-blog-categories-wrap a,
.hero-section-blog-categories-wrap a:visited,
.hero-section-blog-categories-wrap a:hover,
.hero-section-blog-bottom-meta-wrap
.hero-section-blog-bottom-meta-wrap a,
.hero-section-blog-bottom-meta-wrap a:visited,
.hero-section-blog-bottom-meta-wrap a:hover { 
   color : <?php echo ( !empty( $be_themes_data[ 'single_post_typo' ] ) ) ?  $be_themes_data[ 'single_post_title' ][ 'color' ] : $be_themes_data[ 'post_title' ][ 'color' ]; ?>;
}

#navigation .mega .sub-menu .highlight .sf-with-ul {
 color: <?php echo $be_themes_data['submenu_text']['color'] ; ?> !important;
 line-height:1.5;
}

.view-project-link.style4-button {
    color : <?php echo $be_themes_data[ 'h6' ]['color']; ?>;
}

.pricing-table .pricing-feature{
  font-size: <?php echo  intval($be_themes_data['body_text']['font-size']) - 1;?>px;
}

/* Woocommerce */

.related.products h2,
.upsells.products h2,
.cart-collaterals .cross-sells h2,
.cart_totals h2, 
.shipping_calculator h2,
.woocommerce-billing-fields h3,
.woocommerce-shipping-fields h3,
.shipping_calculator h2,
#order_review_heading,
.woocommerce .page-title {
  font-family: <?php echo $be_themes_data['shop_page_title']['font-family']; ?>;
  font-weight: <?php echo $be_themes_data['shop_page_title']['font-weight']; ?>;
}

.woocommerce form .form-row label, .woocommerce-page form .form-row label {
  color: <?php echo $be_themes_data['h6']['color']; ?>;
}

.woocommerce-tabs .tabs li a {
  color: <?php echo $be_themes_data['h6']['color']; ?> !important;
}


/* BB Press Plugin */

a.bbp-forum-title,
#bbpress-forums fieldset.bbp-form label,
.bbp-topic-title a.bbp-topic-permalink {
  <?php be_themes_print_typography('h6'); ?>
}

#bbpress-forums ul.forum-titles li,
#bbpress-forums ul.bbp-replies li.bbp-header {
  <?php be_themes_print_typography('h6'); ?>
  line-height: inherit;
  letter-spacing: inherit;
  text-transform: uppercase;
  font-size: inherit;
}

#bbpress-forums .topic .bbp-topic-meta a, 
.bbp-forum-freshness a,
.bbp-topic-freshness a,
.bbp-header .bbp-reply-content a,
.bbp-topic-tags a,
.bbp-breadcrumb a,
.bbp-forums-list a {
  color: <?php echo $be_themes_data['h6']['color']; ?>;
}


/*Event On Plugin*/

.ajde_evcal_calendar .calendar_header p, .eventon_events_list .eventon_list_event .evcal_cblock {
    font-family: <?php echo $be_themes_data['h1']['font-family']; ?> !important;
}

.eventon_events_list .eventon_list_event .evcal_desc span.evcal_desc2, .evo_pop_body .evcal_desc span.evcal_desc2 {
  font-family: <?php echo $be_themes_data['h6']['font-family']; ?> !important;
  font-size: 14px !important;
  text-transform: none;
}

.eventon_events_list .eventon_list_event .evcal_desc span.evcal_event_subtitle, .evo_pop_body .evcal_desc span.evcal_event_subtitle,
.evcal_evdata_row .evcal_evdata_cell p, #evcal_list .eventon_list_event p.no_events {
  text-transform: none !important;
  font-family: <?php echo $be_themes_data['body_text']['font-family']; ?> !important;
  font-size: inherit !important;
}

/* END RELATED TO TYPOGRAPHY */

<?php endif; ?>