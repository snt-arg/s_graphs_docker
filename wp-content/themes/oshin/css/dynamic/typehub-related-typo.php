<?php
/*
Parsed to Typehub is true and Typehub is deactivated
- Use Default Typography Values from Config

Parsed to Typehub is false
- Typehub was never activated. Be Styles php will handle this using values from redux

Parsed to Typehub is true and Typehub is active use values from Typehub
*/
global $be_themes_data;
$parsed_to_typehub = get_option( 'oshine_redux_to_typehub' );
$typehub_data = array();
if( !empty( $parsed_to_typehub ) ) {
  if( class_exists( 'Typehub' ) ) {
    $store = typehub_get_store();
    $typehub_data = !empty( $store['savedValues'] ) ? $store['savedValues'] : array();
  } else {
    $typehub_data = oshine_typehub_default_values();
  }
} 
// Typehub data will be empty when redux is not parsed to typehub
if( !empty( $typehub_data ) ) : 
?>
/* RELATED TO TYPOGRAPHY */

#header-controls-right,
#header-controls-left {
  color: <?php echo $typehub_data['navigation_text']['color'] ; ?>
}
#be-left-strip .be-mobile-menu-icon span {
    background-color: <?php echo ( empty( $be_themes_data[ 'mobile_menu_icon_color' ] ) ) ?  $typehub_data['navigation_text']['color'] : $be_themes_data[ 'mobile_menu_icon_color' ] ; ?>
}

ul#mobile-menu .mobile-sub-menu-controller {
  line-height : <?php echo $typehub_data['mobile_menu_text']['line-height']['desktop']['value'].$typehub_data['mobile_menu_text']['line-height']['desktop']['unit'] ; ?> ;
}

ul#mobile-menu ul.sub-menu .mobile-sub-menu-controller{
  line-height : <?php echo $typehub_data['mobile_submenu_text']['line-height']['desktop']['value'].$typehub_data['mobile_submenu_text']['line-height']['desktop']['unit']; ?> ;
}

.breadcrumbs {
  color: <?php echo $typehub_data['page_title_module_typo']['color']; ?>;
}

.search-box-wrapper.style2-header-search-widget input[type="text"]{
  font-style: <?php echo be_extract_font_style( $typehub_data['sub_title']['font-variant'] ); ?>;
  font-weight: <?php echo be_extract_font_weight( $typehub_data['sub_title']['font-variant'] ); ?>;
  font-family: <?php echo oshin_get_font_family( $typehub_data['sub_title']['font-family'] ); ?>;
}

.portfolio-share a.custom-share-button, 
.portfolio-share a.custom-share-button:active, 
.portfolio-share a.custom-share-button:hover, 
.portfolio-share a.custom-share-button:visited {
  color: <?php echo ! is_array( $typehub_data['h6']['color'] ) ? $typehub_data['h6']['color'] : ''; ?>; 
}

.more-link.style2-button {
  color: <?php echo $typehub_data['post_title']['color'];  ?> !important;
  border-color: <?php echo $typehub_data['post_title']['color'];  ?> !important;
}

.style8-blog .post-bottom-meta-wrap .be-share-stack a.custom-share-button, 
.style8-blog .post-bottom-meta-wrap .be-share-stack a.custom-share-button:active, 
.style8-blog .post-bottom-meta-wrap .be-share-stack a.custom-share-button:hover, 
.style8-blog .post-bottom-meta-wrap .be-share-stack a.custom-share-button:visited {
  color: <?php echo $typehub_data['post_meta_options']['color']; ?>; 
}

.hero-section-blog-categories-wrap a,
.hero-section-blog-categories-wrap a:visited,
.hero-section-blog-categories-wrap a:hover,
.hero-section-blog-bottom-meta-wrap
.hero-section-blog-bottom-meta-wrap a,
.hero-section-blog-bottom-meta-wrap a:visited,
.hero-section-blog-bottom-meta-wrap a:hover,
.hero-section-blog-bottom-meta-wrap { 
   color : <?php echo $typehub_data[ 'single_post_title' ][ 'color' ]; ?>;
}

#navigation .mega .sub-menu .highlight .sf-with-ul {
 color: <?php echo $typehub_data['submenu_text']['color'] ; ?> !important;
 line-height:1.5;
}

.view-project-link.style4-button {
    color : <?php echo ! is_array( $typehub_data['h6']['color'] ) ? $typehub_data['h6']['color'] : ''; ?>;
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
  font-family: <?php echo oshin_get_font_family( $typehub_data['shop_page_title']['font-family'] ); ?>;
  font-weight: <?php echo be_extract_font_weight( $typehub_data['shop_page_title']['font-variant'] ); ?>;
}

.woocommerce form .form-row label, .woocommerce-page form .form-row label {
  color: <?php echo ! is_array( $typehub_data['h6']['color'] ) ? $typehub_data['h6']['color'] : ''; ?>;
}

.woocommerce-tabs .tabs li a {
  color: <?php echo ! is_array( $typehub_data['h6']['color'] ) ? $typehub_data['h6']['color'] : ''; ?> !important;
}


/* BB Press Plugin */

#bbpress-forums ul.forum-titles li,
#bbpress-forums ul.bbp-replies li.bbp-header {
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
  color: <?php echo ! is_array( $typehub_data['h6']['color'] ) ? $typehub_data['h6']['color'] : ''; ?>;
}


/*Event On Plugin*/

.ajde_evcal_calendar .calendar_header p, .eventon_events_list .eventon_list_event .evcal_cblock {
    font-family: <?php echo oshin_get_font_family( $typehub_data['h1']['font-family'] ); ?> !important;
}

.eventon_events_list .eventon_list_event .evcal_desc span.evcal_desc2, .evo_pop_body .evcal_desc span.evcal_desc2 {
  font-family: <?php echo oshin_get_font_family( $typehub_data['h6']['font-family'] ); ?> !important;
  font-size: 14px !important;
  text-transform: none;
}

.eventon_events_list .eventon_list_event .evcal_desc span.evcal_event_subtitle, .evo_pop_body .evcal_desc span.evcal_event_subtitle,
.evcal_evdata_row .evcal_evdata_cell p, #evcal_list .eventon_list_event p.no_events {
  text-transform: none !important;
  font-family: <?php echo oshin_get_font_family( $typehub_data['body']['font-family'] ); ?> !important;
  font-size: inherit !important;
}

/* END RELATED TO TYPOGRAPHY */

<?php endif; ?>