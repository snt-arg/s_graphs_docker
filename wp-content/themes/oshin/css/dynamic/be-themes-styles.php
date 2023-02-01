<?php 

/**
 * Replace color scheme and alt text bg color with color pallete colors
 */
extract( be_get_accent_color() );

extract(be_themes_calculate_logo_height());
extract(be_themes_calculate_logo_width());
$new_header_styles = array (
    'style7', 
    'style8',
    'style9',
    'style10',
    'style11',
    'style12'
);
$header_style = ( isset( $be_themes_data[ 'opt-header-style' ] ) && !empty( $be_themes_data[ 'opt-header-style' ] ) ) ? pathinfo( $be_themes_data[ 'opt-header-style' ], PATHINFO_FILENAME ) : '';
?>

body {
    <?php be_themes_set_backgrounds('body'); ?>
}
.layout-box #header-inner-wrap, 
#header-inner-wrap, #header-inner-wrap.style3 #header-bottom-bar,
body.header-transparent #header #header-inner-wrap.no-transparent,
.left-header .sb-slidebar.sb-left,
.left-header .sb-slidebar.sb-left #slidebar-menu a::before 
{
    <?php be_themes_set_backgrounds('opt-header-color'); ?>
}
#mobile-menu, 
#mobile-menu ul {
    <?php be_themes_background_colors($be_themes_data['mobile_menu_bg']['color'], $be_themes_data['mobile_menu_bg']['alpha']); ?>
}

<?php if(isset($be_themes_data['mobile_menu_border']) && !empty($be_themes_data['mobile_menu_border']) ) { ?>
  #mobile-menu li{
    border-bottom-color: <?php echo $be_themes_data['mobile_menu_border']; ?> ;
  }
<?php } ?>


body.header-transparent #header-inner-wrap{
  background: transparent;
}
.be-gdpr-modal-item input:checked + .slider{
  background-color: <?php echo $color_scheme; ?>;
}
.be-gdpr-modal-iteminput:focus + .slider {
  box-shadow: 0 0 1px  <?php echo $color_scheme; ?>;
}
.be-gdpr-modal-item .slider:before {
  background-color:<?php echo $alt_bg_text_color ?>;
}
.be-gdpr-cookie-notice-bar .be-gdpr-cookie-notice-button{
  background: <?php echo $color_scheme; ?>;
  color: <?php echo $alt_bg_text_color; ?>;
}

<?php if(('left' == $be_themes_data['opt-header-type'] )  && (!empty( $be_themes_data['opt-header-color']['background-image'] ))) {?>
  .left-header .sb-slidebar.sb-left .display-table{
    <?php be_themes_background_colors($be_themes_data['left-static-overlay']['color'], $be_themes_data['left-static-overlay']['alpha']); ?>
  }<?php
}?>
#header .header-border{
 border-bottom: <?php echo be_themes_borders('opt-header-border-color','bottom') ; ?>;
}
#header-top-bar{
    <?php be_themes_background_colors($be_themes_data['opt-topbar-color']['color'], $be_themes_data['opt-topbar-color']['alpha']); ?>
    border-bottom: <?php echo be_themes_borders('opt-topbar-border-color','bottom') ; ?>;
    color: <?php echo $be_themes_data['opt-topbar-text-color']; ?>;
}
#header-top-bar #topbar-menu li a{
    color: <?php echo $be_themes_data['opt-topbar-text-color']; ?>;
}
#header-bottom-bar{
    <?php be_themes_background_colors($be_themes_data['opt-bottombar-color']['color'], $be_themes_data['opt-bottombar-color']['alpha']); ?>
    border-top: <?php echo be_themes_borders('opt-bottombar-border-color','top') ; ?>;
    border-bottom: <?php echo be_themes_borders('opt-bottombar-border-color','bottom') ; ?>;
}

/*Adjusted the timings for the new effects*/
body.header-transparent #header #header-inner-wrap {
	-webkit-transition: background .25s ease, box-shadow .25s ease, opacity 700ms cubic-bezier(0.645, 0.045, 0.355, 1), transform 700ms cubic-bezier(0.645, 0.045, 0.355, 1);
	-moz-transition: background .25s ease, box-shadow .25s ease, opacity 700ms cubic-bezier(0.645, 0.045, 0.355, 1), transform 700ms cubic-bezier(0.645, 0.045, 0.355, 1);
	-o-transition: background .25s ease, box-shadow .25s ease, opacity 700ms cubic-bezier(0.645, 0.045, 0.355, 1), transform 700ms cubic-bezier(0.645, 0.045, 0.355, 1);
	transition: background .25s ease, box-shadow .25s ease, opacity 700ms cubic-bezier(0.645, 0.045, 0.355, 1), transform 700ms cubic-bezier(0.645, 0.045, 0.355, 1);
}

body.header-transparent.semi #header .semi-transparent{
  <?php be_themes_background_colors($be_themes_data['semi-transparent-header-color']['color'], $be_themes_data['semi-transparent-header-color']['alpha']); ?>  !important ;
}
body.header-transparent.semi #content {
    padding-top: 100px;
}

#content,
#blog-content {
    <?php be_themes_set_backgrounds('content'); ?>
}
#bottom-widgets {
    <?php be_themes_set_backgrounds('bottom_widgets'); ?>
}
#footer {
  <?php be_themes_set_backgrounds('footer_background'); ?>
}
#footer .footer-border{
  border-bottom: <?php echo be_themes_borders('footer-border-color','top') ; ?>;
}
.page-title-module-custom {
	<?php be_themes_set_backgrounds('header_title_module'); ?>
}
#portfolio-title-nav-wrap{
  background-color : <?php echo $be_themes_data['portfolio_title_nav_color']; ?>;
}
#navigation .sub-menu,
#navigation .children,
#navigation-left-side .sub-menu,
#navigation-left-side .children,
#navigation-right-side .sub-menu,
#navigation-right-side .children {
  <?php be_themes_background_colors($be_themes_data['submenu_bg_color']['color'], $be_themes_data['submenu_bg_color']['alpha']); ?>
}
.sb-slidebar.sb-right {
  <?php be_themes_background_colors($be_themes_data['sidebar_menu_bg_color']['color'], $be_themes_data['sidebar_menu_bg_color']['alpha']); ?>
}
.left-header .left-strip-wrapper,
.left-header #left-header-mobile {
  background-color : <?php echo $be_themes_data['opt-header-color']['background-color']; ?> ;
}
.layout-box-top,
.layout-box-bottom,
.layout-box-right,
.layout-box-left,
.layout-border-header-top #header-inner-wrap,
.layout-border-header-top.layout-box #header-inner-wrap, 
body.header-transparent .layout-border-header-top #header #header-inner-wrap.no-transparent {
  <?php be_themes_set_backgrounds('border-bg-setting');?>
}

.left-header.left-sliding.left-overlay-menu .sb-slidebar{
  <?php be_themes_background_colors($be_themes_data['left_overlay_menu_bg_color']['color'], $be_themes_data['left_overlay_menu_bg_color']['alpha']); ?>
  
}
.top-header.top-overlay-menu .sb-slidebar{
  <?php be_themes_background_colors($be_themes_data['sidebar_menu_bg_color']['color'], $be_themes_data['sidebar_menu_bg_color']['alpha']); ?>
}
.search-box-wrapper{
  <?php be_themes_background_colors($be_themes_data['search_bg']['color'], $be_themes_data['search_bg']['alpha']); ?>
}
.search-box-wrapper.style1-header-search-widget input[type="text"]{
  background-color: transparent !important;
  color: <?php echo $be_themes_data['search_font_color'] ;?>;
  border: 1px solid  <?php echo $be_themes_data['search_font_color'] ;?>;
}
.search-box-wrapper.style2-header-search-widget input[type="text"]{
  background-color: transparent !important;
  color: <?php echo $be_themes_data['search_font_color'] ;?>;
  border: none !important;
  box-shadow: none !important;
}
.search-box-wrapper .searchform .search-icon{
  color: <?php echo $be_themes_data['search_font_color'] ;?>;
}
#header-top-bar-right .search-box-wrapper.style1-header-search-widget input[type="text"]{
  border: none; 
}

<?php $padding = ('' != $be_themes_data['opt-logo-padding']) ? str_replace('px', '', $be_themes_data['opt-logo-padding']) : 20; ?>

.post-title ,
.post-date-wrap {
  margin-bottom: 12px;
}

/* ======================
    Dynamic Border Styling
   ====================== */

<?php
if(isset($be_themes_data['border-width']) && !empty($be_themes_data['border-width'])){
  $border_layout_width = $be_themes_data['border-width']; 
}else{
  $border_layout_width = 30; 
}
?>

.layout-box-top,
.layout-box-bottom {
  height: <?php echo $border_layout_width ; ?>px;
}

.layout-box-right,
.layout-box-left {
  width: <?php echo $border_layout_width ; ?>px;
}

#main.layout-border,
#main.layout-border.layout-border-header-top{
  padding: <?php echo $border_layout_width ; ?>px;
}
.left-header #main.layout-border {
    padding-left: 0px;
}
#main.layout-border.layout-border-header-top {
  padding-top: 0px;
}
.be-themes-layout-layout-border #logo-sidebar,
.be-themes-layout-layout-border-header-top #logo-sidebar{
  margin-top: <?php echo 40 + $border_layout_width ; ?>px;
}

/*Left Static Menu*/
.left-header.left-static.be-themes-layout-layout-border #main-wrapper{
  margin-left: <?php echo 280 + $border_layout_width ; ?>px;
}
.left-header.left-static.be-themes-layout-layout-border .sb-slidebar.sb-left {
  left: <?php echo $border_layout_width ; ?>px;
}

/*Right Slidebar*/

body.be-themes-layout-layout-border-header-top .sb-slidebar.sb-right,
body.be-themes-layout-layout-border .sb-slidebar.sb-right {
  right: -<?php echo 280 - $border_layout_width ; ?>px; 
}
.be-themes-layout-layout-border-header-top .sb-slidebar.sb-right.opened,
.be-themes-layout-layout-border .sb-slidebar.sb-right.opened {
  right: <?php echo $border_layout_width ; ?>px;
}

/* Top-overlay menu on opening, header moves sideways bug. Fixed on the next line code */
/*body.be-themes-layout-layout-border-header-top.top-header.slider-bar-opened #main #header #header-inner-wrap.no-transparent.top-animate,
body.be-themes-layout-layout-border.top-header.slider-bar-opened #main #header #header-inner-wrap.no-transparent.top-animate {
  right: <?php echo 280 + $border_layout_width ; ?>px;
}*/

body.be-themes-layout-layout-border-header-top.top-header:not(.top-overlay-menu).slider-bar-opened #main #header #header-inner-wrap.no-transparent.top-animate,
body.be-themes-layout-layout-border.top-header:not(.top-overlay-menu).slider-bar-opened #main #header #header-inner-wrap.no-transparent.top-animate {
  right: <?php echo 280 + $border_layout_width ; ?>px;
}

/* Now not needed mostly, as the hero section image is coming properly */


/*Single Page Version*/
body.be-themes-layout-layout-border-header-top.single-page-version .single-page-nav-wrap,
body.be-themes-layout-layout-border.single-page-version .single-page-nav-wrap {
  right: <?php echo 20 + $border_layout_width ; ?>px;
}

/*Split Screen Page Template*/
.top-header .layout-border #content.page-split-screen-left {
  margin-left: calc(50% + <?php echo $border_layout_width/2 ; ?>px);
} 
.top-header.page-template-page-splitscreen-left .layout-border .header-hero-section {
  width: calc(50% - <?php echo $border_layout_width/2 ; ?>px);
} 

.top-header .layout-border #content.page-split-screen-right {
  width: calc(50% - <?php echo $border_layout_width/2 ; ?>px);
} 
.top-header.page-template-page-splitscreen-right .layout-border .header-hero-section {
  left: calc(50% - <?php echo $border_layout_width/2 ; ?>px);
} 
  
 
@media only screen and (max-width: 960px) {
  body.be-themes-layout-layout-border-header-top.single-page-version .single-page-nav-wrap,
  body.be-themes-layout-layout-border.single-page-version .single-page-nav-wrap {
    right: <?php echo 5 + $border_layout_width ; ?>px;
  }
  body.be-themes-layout-layout-border-header-top .sb-slidebar.sb-right, 
  body.be-themes-layout-layout-border .sb-slidebar.sb-right {
    right: -280px;
  }
  #main.layout-border,
  #main.layout-border.layout-border-header-top {
    padding: 0px !important;
  }
  .top-header .layout-border #content.page-split-screen-left,
  .top-header .layout-border #content.page-split-screen-right {
      margin-left: 0px;
      width:100%;
  }
  .top-header.page-template-page-splitscreen-right .layout-border .header-hero-section,
  .top-header.page-template-page-splitscreen-left .layout-border .header-hero-section {
      width:100%;
  }
}

<?php
/* Include Dynamic Typography  */
include get_template_directory().'/css/dynamic/typography.php';
?>



.filters.single_border .filter_item{
    border-color: <?php echo $color_scheme; ?>;
}
.filters.rounded .current_choice{
    border-radius: 50px;
    background-color: <?php echo $color_scheme; ?>;
    color: <?php echo $alt_bg_text_color; ?>;
}
.filters.single_border .current_choice,
.filters.border .current_choice{
    color: <?php echo $color_scheme; ?>;
}

.exclusive-mobile-bg .menu-controls{
  background-color: <?php be_themes_background_colors($be_themes_data['mobile_menu_icon_bg']['color'], $be_themes_data['mobile_menu_icon_bg']['alpha']); ?>;
}
<?php
  if( isset( $be_themes_data[ 'mobile_menu_icon_color' ] ) && !empty( $be_themes_data[ 'mobile_menu_icon_color' ] ) ) { ?>
    #header .be-mobile-menu-icon span {
        background-color : <?php echo $be_themes_data[ 'mobile_menu_icon_color' ]; ?>;
    } 
    #header-controls-right,
    #header-controls-left,
    .overlay-menu-close,
    .be-overlay-menu-close {
      color : <?php echo $be_themes_data[ 'mobile_menu_icon_color' ]; ?>;
    }
<?php }  ?>

#header .exclusive-mobile-bg .be-mobile-menu-icon,
#header .exclusive-mobile-bg .be-mobile-menu-icon span,
#header-inner-wrap.background--light.transparent.exclusive-mobile-bg .be-mobile-menu-icon,
#header-inner-wrap.background--light.transparent.exclusive-mobile-bg .be-mobile-menu-icon span,
#header-inner-wrap.background--dark.transparent.exclusive-mobile-bg .be-mobile-menu-icon,
#header-inner-wrap.background--dark.transparent.exclusive-mobile-bg .be-mobile-menu-icon span {
  background-color: <?php echo $be_themes_data['mobile_menu_icon_color'] ; ?>
}
.be-mobile-menu-icon{
  width: <?php echo $be_themes_data['mobile_menu_width'] ; ?>px;
  height: <?php echo $be_themes_data['mobile_menu_thickness'] ; ?>px;
}
.be-mobile-menu-icon .hamburger-line-1{
  top: -<?php echo $be_themes_data['mobile_menu_gap'] ; ?>px;
}
.be-mobile-menu-icon .hamburger-line-3{
  top: <?php echo $be_themes_data['mobile_menu_gap'] ; ?>px;
}

.thumb-title-wrap {
  color: <?php echo $alt_bg_text_color; ?>;
}


#bottom-widgets .widget ul li a, #bottom-widgets a {
	color: inherit;
}

#bottom-widgets .tagcloud a:hover {
  color: <?php echo $alt_bg_text_color; ?>;
}

<?php 
if ( isset($be_themes_data['nav_link_hover_color_controller']) && 1== ($be_themes_data['nav_link_hover_color_controller']) && !empty($be_themes_data['nav_link_hover_color']) ) {
  $nav_hover_color = $be_themes_data['nav_link_hover_color'];
}else{
  $nav_hover_color = $color_scheme;
}
?>

a, a:visited, a:hover,
#bottom-widgets .widget ul li a:hover, 
#bottom-widgets a:hover{
  color: <?php echo $color_scheme; ?>;
}

#header-top-menu a:hover,
#navigation .current_page_item a,
#navigation .current_page_item a:hover,
#navigation a:hover,
#navigation-left-side .current_page_item a,
#navigation-left-side .current_page_item a:hover,
#navigation-left-side a:hover,
#navigation-right-side .current_page_item a,
#navigation-right-side .current_page_item a:hover,
#navigation-right-side a:hover,
#menu li.current-menu-ancestor > a,
#navigation-left-side .current-menu-item > a,
#navigation-right-side .current-menu-item > a,
#navigation .current-menu-item > a,
#navigation .sub-menu .current-menu-item > a,
#navigation .sub-menu a:hover,
#navigation .children .current-menu-item > a,
#navigation .children a:hover,
#slidebar-menu .current-menu-item > a,
.special-header-menu a:hover + .mobile-sub-menu-controller i,
.special-header-menu #slidebar-menu a:hover,
.special-header-menu .sub-menu a:hover,
.single-page-version #navigation a:hover,
.single-page-version #navigation-left-side a:hover,
.single-page-version #navigation-right-side a:hover,
.single-page-version #navigation .current-section.current_page_item a,
.single-page-version #navigation-left-side .current-section.current_page_item a,
.single-page-version #navigation-right-side .current-section.current_page_item a,
.single-page-version #slidebar-menu .current-section.current_page_item a,
.single-page-version #navigation .current_page_item a:hover,
.single-page-version #navigation-left-side .current_page_item a:hover,
.single-page-version #navigation-right-side .current_page_item a:hover,
.single-page-version #slidebar-menu .current_page_item a:hover,
.be-sticky-sections #navigation a:hover,
.be-sticky-sections #navigation-left-side a:hover,
.be-sticky-sections #navigation-right-side a:hover,
.be-sticky-sections #navigation .current-section.current_page_item a,
.be-sticky-sections #navigation-left-side .current-section.current_page_item a,
.be-sticky-sections #navigation-right-side .current-section.current_page_item a,
.be-sticky-sections #navigation .current_page_item a:hover,
.be-sticky-sections #navigation-left-side .current_page_item a:hover,
.be-sticky-sections #navigation-right-side .current_page_item a:hover,
#navigation .current-menu-ancestor > a,
#navigation-left-side .current-menu-ancestor > a,
#navigation-right-side .current-menu-ancestor > a,
#slidebar-menu .current-menu-ancestor > a,
.special-header-menu .current-menu-item > a,
.sb-left #slidebar-menu a:hover {
	color: <?php echo $nav_hover_color; ?>;
}

#navigation .current_page_item ul li a,
#navigation-left-side .current_page_item ul li a,
#navigation-right-side .current_page_item ul li a,
.single-page-version #navigation .current_page_item a,
.single-page-version #navigation-left-side .current_page_item a,
.single-page-version #navigation-right-side .current_page_item a,
.single-page-version #slidebar-menu .current_page_item a,
.single-page-version #navigation .sub-menu .current-menu-item > a,
.single-page-version #navigation .children .current-menu-item > a 
.be-sticky-sections #navigation .current_page_item a,
.be-sticky-sections #navigation-left-side .current_page_item a,
.be-sticky-sections #navigation-right-side .current_page_item a,
.be-sticky-sections #navigation .sub-menu .current-menu-item > a,
.be-sticky-sections #navigation .children .current-menu-item > a {
  color: inherit;
}

.be-nav-link-effect-1 a::after,
.be-nav-link-effect-2 a::after,
.be-nav-link-effect-3 a::after{
  <?php be_themes_background_colors($nav_hover_color, '1'); ?>
}

<?php 
if( 'left' == $be_themes_data['opt-header-type'] ){
  if( 'none' == $be_themes_data['left_menu_hover_style'] || 'underline' == $be_themes_data['left_menu_hover_style'] || 'tail-left' == $be_themes_data['left_menu_hover_style'] || null == $be_themes_data['left_menu_hover_style']){ ?>
    .sb-left #slidebar-menu a:hover,
    .special-header-menu #slidebar-menu a:hover,
    .special-header-menu .sub-menu a:hover{
      color: <?php echo $nav_hover_color; ?>;
    }
<?php  
    if( 'underline' == $be_themes_data['left_menu_hover_style'] ){?>
      .sb-left #slidebar-menu a::before,
      .special-header-menu #slidebar-menu a::before,
      .special-header-menu .sub-menu a::before{
        content : '';
        border-bottom: 2px solid <?php echo $nav_hover_color;?>;
        width: 100%;
        bottom: 0;
      }
<?php 
    }
  }else if( 'color-fill' == $be_themes_data['left_menu_hover_style'] || 'color-fill-with-underline' == $be_themes_data['left_menu_hover_style'] ){ ?>
    .sb-left #slidebar-menu a::before,
    .special-header-menu #slidebar-menu a::before,
    .special-header-menu .sub-menu a::before{
      content : attr(title);
      color: <?php echo $nav_hover_color; ?>;
      <?php if( 'color-fill-with-underline' == $be_themes_data['left_menu_hover_style'] ){?>
              border-bottom: 2px solid <?php echo $nav_hover_color;
            }?>
    }
    .sb-left #slidebar-menu a:hover {
      color: inherit;
    }
  <?php } ?>

  <?php if( 'tail-left' == $be_themes_data['left_menu_hover_style'] ){ ?>
    .sb-left #slidebar-menu a::before,
    .special-header-menu #slidebar-menu a::before,
    .special-header-menu .sub-menu a::before{
      content : '';
      background-color: <?php echo $nav_hover_color; ?> !important;
      width: 0;
      left: 0;
      max-width: 100%;
      top: 50%;
      height: 1px;
      transition: width .5s cubic-bezier(0.2,.7,.3,1), left .5s cubic-bezier(0.2,.7,.3,1);
      transition-delay: 80ms;
    }

    .sb-left #slidebar-menu a,
    .special-header-menu #slidebar-menu a,
    .special-header-menu .sub-menu a{
      left: 0;
      transition: color 0.3s ease, padding-left .5s cubic-bezier(0.2,.7,.3,1);
      transition-delay: 80ms;
    }

    .sb-left #slidebar-menu a:hover,
    .special-header-menu #slidebar-menu a:hover,
    .special-header-menu .sub-menu a:hover{
      padding-left: <?php echo 'left' == $be_themes_data['left_special_menu_alignment_horizontal'] ? '1.2em' : '2.4em' ?>
    }

    .sb-left #slidebar-menu a:hover::before,
    .special-header-menu #slidebar-menu a:hover::before,
    .special-header-menu .sub-menu a:hover::before{
      width: 1em;
      left: <?php echo 'left' == $be_themes_data['left_special_menu_alignment_horizontal'] ? '0em' : '1.2em' ?>
    }
<?php 
  }
} ?>

#portfolio-title-nav-wrap .portfolio-nav a {
 color:   <?php echo $be_themes_data['portfolio_nav_color']; ?>; 
}
#portfolio-title-nav-wrap .portfolio-nav a .home-grid-icon span{
  background-color: <?php echo $be_themes_data['portfolio_nav_color']; ?>; 
}
#portfolio-title-nav-wrap .portfolio-nav a:hover {
 color:   <?php echo $be_themes_data['portfolio_nav_hover_color']; ?>; 
}
#portfolio-title-nav-wrap .portfolio-nav a:hover .home-grid-icon span{
  background-color: <?php echo $be_themes_data['portfolio_nav_hover_color']; ?>; 
}

.page-title-module-custom .header-breadcrumb {
  line-height: 36px;
}
#portfolio-title-nav-bottom-wrap h6, 
#portfolio-title-nav-bottom-wrap ul li a, 
.single_portfolio_info_close,
#portfolio-title-nav-bottom-wrap .slider-counts{
  <?php be_themes_background_colors($be_themes_data['portfolio_title_nav_bg']['color'], $be_themes_data['portfolio_title_nav_bg']['alpha']); ?>
}

.more-link.style2-button:hover {
  border-color: <?php echo $color_scheme;  ?> !important;
  background: <?php echo $color_scheme; ?> !important;
  color: <?php echo $alt_bg_text_color; ?> !important;
}
.woocommerce a.button, .woocommerce-page a.button, 
.woocommerce button.button, .woocommerce-page button.button, 
.woocommerce input.button, .woocommerce-page input.button, 
.woocommerce #respond input#submit, .woocommerce-page #respond input#submit,
.woocommerce #content input.button, .woocommerce-page #content input.button {
  background: transparent !important;
  color: #000 !important;
  border-color: #000 !important;
  border-style: solid !important;
  border-width: 2px !important;
  background: <?php echo $be_themes_data['shop_page_button_bg_color']; ?> !important;
  color: <?php echo $be_themes_data['shop_page_button_color']; ?> !important;
  border-width: <?php echo $be_themes_data['shop_page_button_border_width']; ?>px !important;
  border-color: <?php echo $be_themes_data['shop_page_button_border_color']; ?> !important;
  line-height: 41px;
  text-transform: uppercase;
}
.woocommerce a.button:hover, .woocommerce-page a.button:hover, 
.woocommerce button.button:hover, .woocommerce-page button.button:hover, 
.woocommerce input.button:hover, .woocommerce-page input.button:hover, 
.woocommerce #respond input#submit:hover, .woocommerce-page #respond input#submit:hover,
.woocommerce #content input.button:hover, .woocommerce-page #content input.button:hover {
  background: #e0a240 !important;
  color: #fff !important;
  border-color: #e0a240 !important;
  border-width: 2px !important;
  background: <?php echo $be_themes_data['shop_page_button_hover_bg_color']; ?> !important;
  color: <?php echo $be_themes_data['shop_page_button_hover_color']; ?> !important;
  border-color: <?php echo $be_themes_data['shop_page_button_border_hover_color']; ?> !important;

}
.woocommerce a.button.alt, .woocommerce-page a.button.alt, 
.woocommerce .button.alt, .woocommerce-page .button.alt, 
.woocommerce input.button.alt, .woocommerce-page input.button.alt,
.woocommerce input[type="submit"].alt, .woocommerce-page input[type="submit"].alt, 
.woocommerce #respond input#submit.alt, .woocommerce-page #respond input#submit.alt,
.woocommerce #content input.button.alt, .woocommerce-page #content input.button.alt {
  background: #e0a240 !important;
  color: #fff !important;
  border-color: #e0a240 !important;
  border-style: solid !important;
  border-width: 2px !important;
  background: <?php echo $be_themes_data['shop_page_alt_button_bg_color']; ?> !important;
  color: <?php echo $be_themes_data['shop_page_alt_button_color']; ?> !important;
  border-width: <?php echo $be_themes_data['shop_page_alt_button_border_width']; ?>px !important;
  border-color: <?php echo $be_themes_data['shop_page_alt_button_border_color']; ?> !important;
  line-height: 41px;
  text-transform: uppercase;
}
.woocommerce a.button.alt:hover, .woocommerce-page a.button.alt:hover, 
.woocommerce .button.alt:hover, .woocommerce-page .button.alt:hover, 
.woocommerce input[type="submit"].alt:hover, .woocommerce-page input[type="submit"].alt:hover, 
.woocommerce input.button.alt:hover, .woocommerce-page input.button.alt:hover, 
.woocommerce #respond input#submit.alt:hover, .woocommerce-page #respond input#submit.alt:hover,
.woocommerce #content input.button.alt:hover, .woocommerce-page #content input.button.alt:hover {
  background: transparent !important;
  color: #000 !important;
  border-color: #000 !important;
  border-style: solid !important;
  border-width: 2px !important;
  background: <?php echo $be_themes_data['shop_page_alt_button_hover_bg_color']; ?> !important;
  color: <?php echo $be_themes_data['shop_page_alt_button_hover_color']; ?> !important;
  border-color: <?php echo $be_themes_data['shop_page_alt_button_border_hover_color']; ?> !important;
}

.woocommerce .woocommerce-message a.button, 
.woocommerce-page .woocommerce-message a.button,
.woocommerce .woocommerce-message a.button:hover,
.woocommerce-page .woocommerce-message a.button:hover {
  border: none !important;
  color: #fff !important;
  background: none !important;
}

.woocommerce .woocommerce-ordering select.orderby, 
.woocommerce-page .woocommerce-ordering select.orderby {
      border-color: <?php echo $be_themes_data['sec_border']; ?>;
}

.style7-blog .post-title{
  margin-bottom: 9px;
}

.style8-blog .post-comment-wrap a:hover{
    color : <?php echo $color_scheme; ?>;
}

<?php if (null !== $be_themes_data['masonry_bg']){?>
  .style8-blog .element:not(.be-image-post) .post-details-wrap{
    background-color: <?php echo $be_themes_data['masonry_bg']; ?> ;
  }
<?php }else{?>
  .style8-blog .element:not(.be-image-post) .post-details-wrap{
    background-color: <?php echo $be_themes_data['sec_bg']; ?> ;
  }
<?php } ?>

.accordion .accordion-head.with-bg.ui-accordion-header-active{
  background-color: <?php echo $color_scheme; ?> !important;
  color: <?php echo $alt_bg_text_color; ?> !important;
}

#portfolio-title-nav-wrap{
  padding-top: <?php echo $be_themes_data['portfolio_title_bar_padding'];?>px;
  padding-bottom: <?php echo $be_themes_data['portfolio_title_bar_padding'];?>px;
  border-bottom: <?php echo be_themes_borders('portfolio_title_bar_border','bottom') ; ?>;
}

#portfolio-title-nav-bottom-wrap h6, 
#portfolio-title-nav-bottom-wrap ul, 
.single_portfolio_info_close .font-icon,
.slider-counts{
  color:  <?php echo $be_themes_data['portfolio_title_nav_text_color']; ?> ;
}
#portfolio-title-nav-bottom-wrap .home-grid-icon span{
  background-color: <?php echo $be_themes_data['portfolio_title_nav_text_color']; ?> ;
}
#portfolio-title-nav-bottom-wrap h6:hover,
#portfolio-title-nav-bottom-wrap ul a:hover,
#portfolio-title-nav-bottom-wrap .slider-counts:hover,
.single_portfolio_info_close:hover {
  <?php be_themes_background_colors($be_themes_data['portfolio_title_nav_hover_bg_color']['color'], $be_themes_data['portfolio_title_nav_hover_bg_color']['alpha']); ?>
}

#portfolio-title-nav-bottom-wrap h6:hover,
#portfolio-title-nav-bottom-wrap ul a:hover,
#portfolio-title-nav-bottom-wrap .slider-counts:hover,
.single_portfolio_info_close:hover .font-icon{
  color:  <?php echo $be_themes_data['portfolio_title_nav_text_hover_color']; ?> ;
}
#portfolio-title-nav-bottom-wrap ul a:hover .home-grid-icon span{
  background-color: <?php echo $be_themes_data['portfolio_title_nav_text_hover_color']; ?> ;
}
/* ======================
    Layout 
   ====================== */


body #header-inner-wrap.top-animate #navigation, 
body #header-inner-wrap.top-animate .header-controls, 
body #header-inner-wrap.stuck #navigation, 
body #header-inner-wrap.stuck .header-controls {
	-webkit-transition: line-height 0.5s ease;
	-moz-transition: line-height 0.5s ease;
	-ms-transition: line-height 0.5s ease;
	-o-transition: line-height 0.5s ease;
	transition: line-height 0.5s ease;
}
	
.header-cart-controls .cart-contents span{
	background: <?php echo $be_themes_data['header_cart_count_background']; ?>;
}
.header-cart-controls .cart-contents span{
	color: <?php echo $be_themes_data['header_cart_count_color']; ?>;
}

.left-sidebar-page,
.right-sidebar-page, 
.no-sidebar-page .be-section-pad:first-child, 
.page-template-page-940-php #content , 
.no-sidebar-page #content-wrap, 
.portfolio-archives.no-sidebar-page #content-wrap {
    padding-top: 80px;
    padding-bottom: 80px;
}  
.no-sidebar-page #content-wrap.page-builder{
    padding-top: 0px;
    padding-bottom: 0px;
}
.left-sidebar-page .be-section:first-child, 
.right-sidebar-page .be-section:first-child, 
.dual-sidebar-page .be-section:first-child {
    padding-top: 0 !important;
}

.style1 .logo,
.style4 .logo,
#left-header-mobile .logo,
.style3 .logo,
.style7 .logo,
.style10 .logo{
  padding-top: <?php echo $padding.'px' ; ?>;
  padding-bottom: <?php echo $padding.'px' ; ?>;
}

.style5 .logo,
.style6 .logo{
  margin-top: <?php echo $padding.'px' ; ?>;
  margin-bottom: <?php echo $padding.'px' ; ?>;
}
#footer-wrap {
  padding-top: <?php echo $be_themes_data['footer_padding']; ?>px;  
  padding-bottom: <?php echo $be_themes_data['footer_padding']; ?>px;  
}

/* ======================
    Colors 
   ====================== */


.sec-bg,
.gallery_content,
.fixed-sidebar-page .fixed-sidebar,
.style3-blog .blog-post.element .element-inner,
.style4-blog .blog-post,
.blog-post.format-link .element-inner,
.blog-post.format-quote .element-inner,
.woocommerce ul.products li.product, 
.woocommerce-page ul.products li.product,
.chosen-container.chosen-container-single .chosen-drop,
.chosen-container.chosen-container-single .chosen-single,
.chosen-container.chosen-container-active.chosen-with-drop .chosen-single {
  background: <?php echo $be_themes_data['sec_bg']; ?>;
}
.sec-color,
.post-meta a,
.pagination a, .pagination a:visited, .pagination span, .pages_list a,
input[type="text"], input[type="email"], input[type="password"],
textarea,
.gallery_content,
.fixed-sidebar-page .fixed-sidebar,
.style3-blog .blog-post.element .element-inner,
.style4-blog .blog-post,
.blog-post.format-link .element-inner,
.blog-post.format-quote .element-inner,
.woocommerce ul.products li.product, 
.woocommerce-page ul.products li.product,
.chosen-container.chosen-container-single .chosen-drop,
.chosen-container.chosen-container-single .chosen-single,
.chosen-container.chosen-container-active.chosen-with-drop .chosen-single {
  color: <?php echo $be_themes_data['sec_color']; ?>;
}

.woocommerce .quantity .plus, .woocommerce .quantity .minus, .woocommerce #content .quantity .plus, .woocommerce #content .quantity .minus, .woocommerce-page .quantity .plus, .woocommerce-page .quantity .minus, .woocommerce-page #content .quantity .plus, .woocommerce-page #content .quantity .minus,
.woocommerce .quantity input.qty, .woocommerce #content .quantity input.qty, .woocommerce-page .quantity input.qty, .woocommerce-page #content .quantity input.qty {
  background: <?php echo $be_themes_data['sec_bg']; ?>; 
  color: <?php echo $be_themes_data['sec_color']; ?>;
  border-color: <?php echo $be_themes_data['sec_border']; ?>;
}

.woocommerce div.product .woocommerce-tabs ul.tabs li, .woocommerce #content div.product .woocommerce-tabs ul.tabs li, .woocommerce-page div.product .woocommerce-tabs ul.tabs li, .woocommerce-page #content div.product .woocommerce-tabs ul.tabs li {
  color: <?php echo $be_themes_data['sec_color']; ?>!important;
}

.chosen-container .chosen-drop,
nav.woocommerce-pagination,
.summary.entry-summary .price,
.portfolio-details.style2 .gallery-side-heading-wrap,
#single-author-info,
.single-page-atts,
article.comment {
  border-color: <?php echo $be_themes_data['sec_border']; ?> !important;
}

.fixed-sidebar-page #page-content{
  background: <?php echo $be_themes_data['tert_bg']; ?>; 
}


.sec-border,
input[type="text"], input[type="email"], input[type="tel"], input[type="password"],
textarea {
  border: 2px solid <?php echo $be_themes_data['sec_border']; ?>;
}
.chosen-container.chosen-container-single .chosen-single,
.chosen-container.chosen-container-active.chosen-with-drop .chosen-single {
  border: 2px solid <?php echo $be_themes_data['sec_border']; ?>;
}

.woocommerce table.shop_attributes th, .woocommerce-page table.shop_attributes th,
.woocommerce table.shop_attributes td, .woocommerce-page table.shop_attributes td {
    border: none;
    border-bottom: 1px solid <?php echo $be_themes_data['sec_border']; ?>;
    padding-bottom: 5px;
}

.woocommerce .widget_price_filter .price_slider_wrapper .ui-widget-content, .woocommerce-page .widget_price_filter .price_slider_wrapper .ui-widget-content{
    border: 1px solid <?php echo $be_themes_data['sec_border']; ?>;
}
.pricing-table .pricing-title,
.chosen-container .chosen-results li {
  border-bottom: 1px solid <?php echo $be_themes_data['sec_border']; ?>;
}


.separator {
  border:0;
  height:1px;
  color: <?php echo $be_themes_data['sec_border']; ?>;
  background-color: <?php echo $be_themes_data['sec_border']; ?>;
}

.alt-color,
li.ui-tabs-active h6 a,
a,
a:visited,
.social_media_icons a:hover,
.post-title a:hover,
.fn a:hover,
a.team_icons:hover,
.recent-post-title a:hover,
.widget_nav_menu ul li.current-menu-item a,
.widget_nav_menu ul li.current-menu-item:before,
.woocommerce ul.cart_list li a:hover,
.woocommerce ul.product_list_widget li a:hover,
.woocommerce-page ul.cart_list li a:hover,
.woocommerce-page ul.product_list_widget li a:hover,
.woocommerce-page .product-categories li a:hover,
.woocommerce ul.products li.product .product-meta-data h3:hover,
.woocommerce table.cart a.remove:hover, .woocommerce #content table.cart a.remove:hover, .woocommerce-page table.cart a.remove:hover, .woocommerce-page #content table.cart a.remove:hover,
td.product-name a:hover,
.woocommerce-page #content .quantity .plus:hover,
.woocommerce-page #content .quantity .minus:hover,
.post-category a:hover,
.menu-card-item-stared {
    color: <?php echo $color_scheme; ?>;
}

a.custom-like-button.no-liked{
  color: rgba(255,255,255,0.5);
}

a.custom-like-button.liked{
  color: rgba(255,255,255,1);
}

<?php //Dont Apply Menu Item hover styles for old menu style 1 to 6
if( 'top' == $be_themes_data['opt-header-type'] &&  in_array( $header_style, $new_header_styles) ) {
  if( 'underline' == $be_themes_data['top_menu_hover_style'] ) { ?>
    #navigation a::before,
    #header-top-menu a::before,
    #navigation .sub-menu a::before,
    #navigation .children a::before,
    .special-header-menu #slidebar-menu a::before,
    .special-header-menu .sub-menu a::before{
      content : '';
      border-bottom: 2px solid <?php echo $nav_hover_color;?>;
      width: 100%;
      <?php if( be_is_special_top_menu( 'page-stack-top' ) || be_is_special_top_menu( 'overlay-horizontal-menu' ) ) {?>
        bottom: 1em;
      <?php } else {?>
        bottom : 0;
      <?php } ?>  
    }
  <?php  } else if( 'color-fill' == $be_themes_data['top_menu_hover_style'] || 'color-fill-with-underline' == $be_themes_data['top_menu_hover_style'] ) { ?>
    #navigation a::before,
    #header-top-menu a::before,
    #navigation .sub-menu a::before,
    #navigation .children a::before,
    .special-header-menu #slidebar-menu a::before,
    .special-header-menu .sub-menu a::before {
      content : attr(title);
      color: <?php echo $nav_hover_color; ?>;
      <?php if( 'color-fill-with-underline' == $be_themes_data['top_menu_hover_style'] ){ ?>
              border-bottom: 2px solid <?php echo $nav_hover_color;
            } ?>
    }
    .special-header-menu #slidebar-menu a:hover {
      color: inherit;
    }
  <?php } else if( 'tail-left' == $be_themes_data['top_menu_hover_style'] ) {  ?>
    
    .special-header-menu #slidebar-menu a::before,
    .special-header-menu .sub-menu a::before {
      content : '';
      background-color: <?php echo $nav_hover_color; ?>;
      width: 0;
      left: 0;
      max-width: 100%;
      top: 50%;
      height: 1px;
      transition: width .5s cubic-bezier(0.2,.7,.3,1), left .5s cubic-bezier(0.2,.7,.3,1);
      transition-delay: 80ms;
    }

    .special-header-menu #slidebar-menu a,
    .special-header-menu .sub-menu a{
      left: 0;
      transition: color 0.3s ease, padding-left .5s cubic-bezier(0.2,.7,.3,1);
      transition-delay: 80ms;
    }

    .special-header-menu #slidebar-menu a:hover,
    .special-header-menu .sub-menu a:hover{
      padding-left: <?php echo 'left' == $be_themes_data['top_special_menu_alignment_horizontal'] ? '1.2em' : '2.4em' ?>
    }

    .special-header-menu #slidebar-menu a:hover::before,
    .special-header-menu .sub-menu a:hover::before{
      width: 1em;
      left: <?php echo 'left' == $be_themes_data['top_special_menu_alignment_horizontal'] ? '0em' : '1.2em' ?>
    }
<?php 
  }
} ?>

.content-slide-wrap .flex-control-paging li a.flex-active,
.content-slide-wrap .flex-control-paging li.flex-active a:before {
  background: <?php echo $color_scheme; ?> !important;
  border-color: <?php echo $color_scheme; ?> !important;
}


#navigation .menu > ul > li.mega > ul > li {
  border-color: <?php echo $be_themes_data['sub_menu_border']; ?>;
}
<?php if (($be_themes_data['left_side_menu_border'] != '') && ($be_themes_data['left_side_menu_border'] != 'transparent') && ($be_themes_data['opt-header-type'] == 'left')){ ?>
  .sb-slidebar.sb-left .menu {
    border-top: 1px solid <?php echo $be_themes_data['left_side_menu_border']; ?>;
    border-bottom: 1px solid <?php echo $be_themes_data['left_side_menu_border']; ?>;
  }<?php }
?>

<?php if (($be_themes_data['right_side_menu_border'] != '') && ($be_themes_data['right_side_menu_border'] != 'transparent') && ($be_themes_data['opt-header-type'] == 'top')){ ?>
  .sb-slidebar.sb-right .menu{
    border-top: 1px solid <?php echo $be_themes_data['right_side_menu_border']; ?>;
    border-bottom: 1px solid <?php echo $be_themes_data['right_side_menu_border']; ?>;
}<?php }
?>

.post-title a:hover {
    color: <?php echo $color_scheme; ?> !important;
}

.alt-bg,
input[type="submit"],
.tagcloud a:hover,
.pagination a:hover,
.widget_tag_cloud a:hover,
.pagination .current,
.trigger_load_more .be-button,
.trigger_load_more .be-button:hover {
    background-color: <?php echo $color_scheme; ?>;
    transition: 0.2s linear all;
}
.mejs-controls .mejs-time-rail .mejs-time-current ,
.mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current,
.woocommerce span.onsale, 
.woocommerce-page span.onsale, 
.woocommerce a.add_to_cart_button.button.product_type_simple.added,
.woocommerce-page .widget_shopping_cart_content .buttons a.button:hover,
.woocommerce nav.woocommerce-pagination ul li span.current, 
.woocommerce nav.woocommerce-pagination ul li a:hover, 
.woocommerce nav.woocommerce-pagination ul li a:focus,
.testimonial-flex-slider .flex-control-paging li a.flex-active,
#back-to-top,
.be-carousel-nav,
.portfolio-carousel .owl-controls .owl-prev:hover,
.portfolio-carousel .owl-controls .owl-next:hover,
.owl-theme .owl-controls .owl-dot.active span,
.owl-theme .owl-controls .owl-dot:hover span,
.more-link.style3-button,
.view-project-link.style3-button{
  background: <?php echo $color_scheme; ?> !important;
}
.single-page-nav-link.current-section-nav-link {
  background: <?php echo $nav_hover_color; ?> !important;
}


.view-project-link.style2-button,
.single-page-nav-link.current-section-nav-link {
  border-color: <?php echo $color_scheme; ?> !important;
}

.view-project-link.style2-button:hover {
  background: <?php echo $color_scheme; ?> !important;
  color: <?php echo $alt_bg_text_color; ?> !important;
}
.tagcloud a:hover,
.testimonial-flex-slider .flex-control-paging li a.flex-active,
.testimonial-flex-slider .flex-control-paging li a {
  border-color: <?php echo $color_scheme; ?>;
}
a.be-button.view-project-link,
.more-link {
  border-color: <?php echo $color_scheme;  ?>; 
}

<?php
  $overlay_color = be_themes_hexa_to_rgb( $color_scheme );
  if ( is_array( $overlay_color ) && count( $overlay_color ) >= 3 ) { ?>
    .portfolio-container .thumb-bg {
      background-color: <?php echo 'rgba('.$overlay_color[0].','.$overlay_color[1].','.$overlay_color[2].',0.85)'; ?>;
    }
  <?php }
?>

.photostream_overlay,
.be-button,
.more-link.style3-button,
.view-project-link.style3-button,
button,
input[type="button"], 
input[type="submit"], 
input[type="reset"] {
	background-color: <?php echo $color_scheme; ?>;
}
input[type="file"]::-webkit-file-upload-button{
	background-color: <?php echo $color_scheme; ?>;
}
.alt-bg-text-color,
input[type="submit"],
.tagcloud a:hover,
.pagination a:hover,
.widget_tag_cloud a:hover,
.pagination .current,
.woocommerce nav.woocommerce-pagination ul li span.current, 
.woocommerce nav.woocommerce-pagination ul li a:hover, 
.woocommerce nav.woocommerce-pagination ul li a:focus,
#back-to-top,
.be-carousel-nav,
.single_portfolio_close .font-icon, 
.single_portfolio_back .font-icon,
.more-link.style3-button,
.view-project-link.style3-button,
.trigger_load_more a.be-button,
.trigger_load_more a.be-button:hover,
.portfolio-carousel .owl-controls .owl-prev:hover .font-icon,
.portfolio-carousel .owl-controls .owl-next:hover .font-icon{
    color: <?php echo $alt_bg_text_color;  ?>;
    transition: 0.2s linear all;
}
.woocommerce .button.alt.disabled {
    background: #efefef !important;
    color: #a2a2a2 !important;
    border: none !important;
    cursor: not-allowed;
}
.be-button,
input[type="button"], 
input[type="submit"], 
input[type="reset"], 
button {
	color: <?php echo $alt_bg_text_color;  ?>;
	transition: 0.2s linear all;
}
input[type="file"]::-webkit-file-upload-button {
	color: <?php echo $alt_bg_text_color;  ?>;
	transition: 0.2s linear all;
}
.button-shape-rounded #submit,
.button-shape-rounded .style2-button.view-project-link,
.button-shape-rounded .style3-button.view-project-link,
.button-shape-rounded .style2-button.more-link,
.button-shape-rounded .style3-button.more-link,
.button-shape-rounded .contact_submit {
  border-radius: 3px;
}
.button-shape-circular .style2-button.view-project-link,
.button-shape-circular .style3-button.view-project-link{
  border-radius: 50px;
  padding: 17px 30px !important;
}
.button-shape-circular .style2-button.more-link,
.button-shape-circular .style3-button.more-link{
  border-radius: 50px;
  padding: 7px 30px !important;
}
.button-shape-circular .contact_submit,
.button-shape-circular #submit{
  border-radius: 50px;   
  padding-left: 30px;
  padding-right: 30px;
}

.view-project-link.style4-button:hover::after{
    border-color : <?php echo $color_scheme; ?>;
}
.mfp-arrow{
  color: <?php echo $alt_bg_text_color;  ?>;
  transition: 0.2s linear all;
  -moz-transition: 0.2s linear all;
  -o-transition: 0.2s linear all;
  transition: 0.2s linear all;
}

.portfolio-title a {
    color: inherit;
}

.arrow-block .arrow_prev,
.arrow-block .arrow_next,
.arrow-block .flickity-prev-next-button {
    <?php be_themes_background_colors($be_themes_data['slider_nav_bg']['color'], $be_themes_data['slider_nav_bg']['alpha']); ?>
} 

.arrow-border .arrow_prev,
.arrow-border .arrow_next,
.arrow-border .flickity-prev-next-button {
    border: 1px solid <?php echo $be_themes_data['slider_nav_bg']['color']; ?>;
} 

.gallery-info-box-wrap .arrow_prev .font-icon,
.gallery-info-box-wrap .arrow_next .font-icon{
  color: <?php echo $be_themes_data['slider_nav_color']; ?>;
}

.flickity-prev-next-button .arrow{
  fill: <?php echo $be_themes_data['slider_nav_color']; ?>;
}

.arrow-block .arrow_prev:hover,
.arrow-block .arrow_next:hover,
.arrow-block .flickity-prev-next-button:hover {
  <?php be_themes_background_colors($be_themes_data['slider_nav_hover_bg']['color'], $be_themes_data['slider_nav_hover_bg']['alpha']); ?>
}

.arrow-border .arrow_prev:hover,
.arrow-border .arrow_next:hover,
.arrow-border .flickity-prev-next-button:hover {
    border: 1px solid <?php echo $be_themes_data['slider_nav_hover_bg']['color']; ?>;
} 

.gallery-info-box-wrap .arrow_prev:hover .font-icon,
.gallery-info-box-wrap .arrow_next:hover .font-icon{
  color: <?php echo $be_themes_data['slider_nav_hover_color']; ?>;
}

.flickity-prev-next-button:hover .arrow{
  fill: <?php echo $be_themes_data['slider_nav_hover_color']; ?>;
}

#back-to-top.layout-border,
#back-to-top.layout-border-header-top {
  right: <?php echo ($border_layout_width+20); ?>px;
  bottom: <?php echo ($border_layout_width+20); ?>px;
}
.layout-border .fixed-sidebar-page #right-sidebar.active-fixed {
    right: <?php echo $border_layout_width; ?>px;
}
body.header-transparent.admin-bar .layout-border #header #header-inner-wrap.no-transparent.top-animate, 
body.sticky-header.admin-bar .layout-border #header #header-inner-wrap.no-transparent.top-animate {
  top: <?php echo ($border_layout_width+32); ?>px;
}
body.header-transparent .layout-border #header #header-inner-wrap.no-transparent.top-animate, 
body.sticky-header .layout-border #header #header-inner-wrap.no-transparent.top-animate {
  top: <?php echo ($border_layout_width); ?>px;
}
body.header-transparent.admin-bar .layout-border.layout-border-header-top #header #header-inner-wrap.no-transparent.top-animate, 
body.sticky-header.admin-bar .layout-border.layout-border-header-top #header #header-inner-wrap.no-transparent.top-animate {
  top: 32px;
  z-index: 15;
}
body.header-transparent .layout-border.layout-border-header-top #header #header-inner-wrap.no-transparent.top-animate, 
body.sticky-header .layout-border.layout-border-header-top #header #header-inner-wrap.no-transparent.top-animate {
  top: 0px;
  z-index: 15;
}
body.header-transparent .layout-border #header #header-inner-wrap.no-transparent #header-wrap, 
body.sticky-header .layout-border #header #header-inner-wrap.no-transparent #header-wrap {
  margin: 0px <?php echo ($border_layout_width); ?>px;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  position: relative;
}
.mfp-content.layout-border img {
  padding: <?php echo ($border_layout_width+40); ?>px 0px <?php echo ($border_layout_width+40); ?>px 0px;
}
body.admin-bar .mfp-content.layout-border img {
  padding: <?php echo ($border_layout_width+72); ?>px 0px <?php echo ($border_layout_width+40); ?>px 0px;
}
.mfp-content.layout-border .mfp-bottom-bar {
  margin-top: -<?php echo ($border_layout_width+30); ?>px;
}
body .mfp-content.layout-border .mfp-close {
  top: <?php echo ($border_layout_width); ?>px;
}
body.admin-bar .mfp-content.layout-border .mfp-close {
  top: <?php echo ($border_layout_width+32); ?>px;
}
pre {
    background-image: -webkit-repeating-linear-gradient(top, <?php echo $be_themes_data['content']['background-color']; ?> 0px, <?php echo $be_themes_data['content']['background-color']; ?> 30px, <?php echo $be_themes_data['sec_bg']; ?> 24px, <?php echo $be_themes_data['sec_bg']; ?> 56px);
    background-image: -moz-repeating-linear-gradient(top, <?php echo $be_themes_data['content']['background-color']; ?> 0px, <?php echo $be_themes_data['content']['background-color']; ?> 30px, <?php echo $be_themes_data['sec_bg']; ?> 24px, <?php echo $be_themes_data['sec_bg']; ?> 56px);
    background-image: -ms-repeating-linear-gradient(top, <?php echo $be_themes_data['content']['background-color']; ?> 0px, <?php echo $be_themes_data['content']['background-color']; ?> 30px, <?php echo $be_themes_data['sec_bg']; ?> 24px, <?php echo $be_themes_data['sec_bg']; ?> 56px);
    background-image: -o-repeating-linear-gradient(top, <?php echo $be_themes_data['content']['background-color']; ?> 0px, <?php echo $be_themes_data['content']['background-color']; ?> 30px, <?php echo $be_themes_data['sec_bg']; ?> 24px, <?php echo $be_themes_data['sec_bg']; ?> 56px);
    background-image: repeating-linear-gradient(top, <?php echo $be_themes_data['content']['background-color']; ?> 0px, <?php echo $be_themes_data['content']['background-color']; ?> 30px, <?php echo $be_themes_data['sec_bg']; ?> 24px, <?php echo $be_themes_data['sec_bg']; ?> 56px);
    display: block;
    line-height: 28px;
    margin-bottom: 50px;
    overflow: auto;
    padding: 0px 10px;
    border:1px solid <?php echo $be_themes_data['sec_border']; ?>;
}
<?php if($be_themes_data['textbox_style'] == 'style2') { ?>
    input[type="text"], input[type="email"], input[type="password"], textarea, select {
      border: 1px solid <?php echo $be_themes_data['sec_border']; ?>;
      background: <?php echo $be_themes_data['sec_bg']; ?>;
    }
<?php } ?>
.post-title a{
  color: inherit;
}

/*Animated link Typography*/


.be-sidemenu,
.special-header-menu a::before{ 
  <?php be_themes_background_colors($be_themes_data['sidebar_menu_bg_color']['color'], $be_themes_data['sidebar_menu_bg_color']['alpha']); ?>
}

/*For normal styles add the padding in top and bottom*/
.be-themes-layout-layout-border .be-sidemenu,
.be-themes-layout-layout-border .be-sidemenu,
.be-themes-layout-layout-border-header-top .be-sidemenu,
.be-themes-layout-layout-border-header-top .be-sidemenu{
  padding: <?php echo $border_layout_width ; ?>px 0px;
  box-sizing: border-box;
}

/*For center-align and left-align overlay, add padding to all sides*/
.be-themes-layout-layout-border.overlay-left-align-menu .be-sidemenu,
.be-themes-layout-layout-border.overlay-center-align-menu .be-sidemenu,
.be-themes-layout-layout-border-header-top.overlay-left-align-menu .be-sidemenu,
.be-themes-layout-layout-border-header-top.overlay-center-align-menu .be-sidemenu{
  padding: <?php echo $border_layout_width ; ?>px;
  box-sizing: border-box;
}

.be-themes-layout-layout-border-header-top .be-sidemenu{
  padding-top: 0px;
}

body.perspective-left.perspectiveview,
body.perspective-right.perspectiveview{
  <?php be_themes_background_colors($be_themes_data['sidebar_menu_bg_color']['color'], $be_themes_data['sidebar_menu_bg_color']['alpha']); ?>
}

body.left-header.perspective-right.perspectiveview{
  <?php be_themes_background_colors($be_themes_data['left_overlay_menu_bg_color']['color'], $be_themes_data['left_overlay_menu_bg_color']['alpha']); ?>
}
body.perspective-left .be-sidemenu,
body.perspective-right .be-sidemenu{
  background-color : transparent;
}

<?php if( be_is_special_top_menu() ){
  if( ( be_is_special_top_menu( 'page-stack-left' ) || be_is_special_top_menu( 'page-stack-right' ) || be_is_special_top_menu( 'special-left-menu' ) || be_is_special_top_menu( 'special-right-menu' ) ) && isset( $be_themes_data['be_sidemenu_width'] ) && !empty( $be_themes_data['be_sidemenu_width'] ) ){
    $sidemenu_width = $be_themes_data['be_sidemenu_width']; 
  } else{
    $sidemenu_width = 280;
  }
?>
  .overlay-center-align-menu.header-solid.side-menu-opened,
  .overlay-horizontal-menu.header-solid.side-menu-opened{
    <?php be_themes_set_backgrounds('opt-header-color'); ?>
  }
  body.overlay-center-align-menu .be-sidemenu, 
  body.overlay-horizontal-menu .be-sidemenu,
  body.overlay-center-align-menu .special-header-menu a::before,
  body.overlay-horizontal-menu .special-header-menu a::before{
    <?php be_themes_background_colors($be_themes_data['sidebar_menu_bg_color']['color'], $be_themes_data['sidebar_menu_bg_color']['alpha']); ?>
  }

  body.page-stack-top .be-sidemenu{
    background-color : transparent;
  }

  body.page-stack-top.side-menu-opened{
    <?php be_themes_background_colors($be_themes_data['sidebar_menu_bg_color']['color'], $be_themes_data['sidebar_menu_bg_color']['alpha']); ?>
  }

  .be-page-stack-left:after,
  .be-page-stack-left:before,
  .be-page-stack-right:after,
  .be-page-stack-right:before{
    <?php be_themes_background_colors($be_themes_data['stack_menu_bg_color']['color'], $be_themes_data['stack_menu_bg_color']['alpha']); ?>
  }

  .be-page-stack.be-page-stack-empty{
    <?php be_themes_background_colors($be_themes_data['stack_menu_bg_color']['color'], $be_themes_data['stack_menu_bg_color']['alpha']); ?>
  }

  .style7 .logo, 
  .style9 .logo, 
  .style10 .logo{
    padding-top: <?php echo $padding.'px' ; ?>;
    padding-bottom: <?php echo $padding.'px' ; ?>;
  }
  .be-sidemenu{
    width : <?php echo $sidemenu_width .'px'; ?>;
  }

   body:not(.overlay-horizontal-menu):not(.overlay-center-align-menu):not(.page-stack-top) #be-sidemenu-content{
    padding-top: <?php echo $padding.'px'; ?>;
  } 

  .overlay-center-align-menu #be-sidemenu-content,
  .overlay-horizontal-menu #be-sidemenu-content{
    padding-top: <?php echo ($logo_height - intval($padding) ).'px'; ?>;
  }
  <?php if( isset( $be_themes_data[ 'menu_and_widget_color_top_menu_open' ] ) && !empty( $be_themes_data[ 'menu_and_widget_color_top_menu_open' ] ) && 'dark' == $be_themes_data[ 'menu_and_widget_color_top_menu_open' ] ) {?>
  .page-stack-top #be-sidemenu-content{
    padding-top: <?php echo ( $logo_dark_height - intval( $padding ) ) . 'px' ; ?>;
  }
  
  <?php }else if( isset( $be_themes_data[ 'menu_and_widget_color_top_menu_open' ] ) && !empty( $be_themes_data[ 'menu_and_widget_color_top_menu_open' ] ) && 'light' == $be_themes_data[ 'menu_and_widget_color_top_menu_open' ] ) {?>
  .page-stack-top #be-sidemenu-content{
    padding-top: <?php echo ( $logo_light_height - intval( $padding ) ) . 'px' ; ?>;
  }
  
  <?php } ?>

  .header-solid.page-stack-top-opened #main-wrapper{
    margin-top : <?php echo $logo_height . 'px'; ?>;
  }
  .be-sidemenu.be-sidemenu-right {
    transform: translateX( <?php echo $sidemenu_width.'px'; ?> );
  }

  body.top-header.page-stack-right.side-menu-opened #main > *:not(#header),
  body.top-header.page-stack-right.side-menu-opened #header-inner-wrap,
  body.top-header.page-stack-right.side-menu-opened #main:after,
  body.top-header.special-right-menu:not(.push-special-menu).side-menu-opened #main > *:not(#header), 
  body.top-header.special-right-menu:not(.push-special-menu).side-menu-opened #header-inner-wrap,
  body.top-header.special-right-menu.side-menu-opened #main:after {
    transform: translateX( <?php echo -$sidemenu_width.'px'; ?> );
  }

  body.top-header.page-stack-left.side-menu-opened #main > *:not(#header), 
  body.top-header.page-stack-left.side-menu-opened #header-inner-wrap,
  body.top-header.page-stack-left.side-menu-opened #main:after,
  body.top-header.special-left-menu:not(.push-special-menu).side-menu-opened #main > *:not(#header), 
  body.top-header.special-left-menu:not(.push-special-menu).side-menu-opened #header-inner-wrap,
  body.top-header.special-left-menu.side-menu-opened #main:after {
      transform: translateX( <?php echo $sidemenu_width.'px'; ?> );
  }

  .page-stack-left #main::after, 
  .page-stack-right #main::after,
  .special-left-menu #main::after, 
  .special-right-menu #main::after{
    <?php be_themes_background_colors($be_themes_data['main_overlay_color_top_menu_open']['color'], $be_themes_data['main_overlay_color_top_menu_open']['alpha']); ?> 
  }

  .be-sidemenu.be-sidemenu-left {
    transform: translateX( <?php echo -$sidemenu_width.'px'; ?> );
  }

  .header-solid.perspective-left.perspectiveview #main, 
  .header-solid.perspective-right.perspectiveview #main{
    margin-top: <?php echo ($logo_height).'px'; ?>;
  }

  body.overlay-center-align-menu.side-menu-opened #header-inner-wrap #header-wrap, 
  body.overlay-center-align-menu.side-menu-opened #header-inner-wrap #header-controls-right, 
  body.overlay-center-align-menu.side-menu-opened #header-inner-wrap #header-controls-left,
  body.overlay-horizontal-menu.side-menu-opened #header-inner-wrap #header-wrap, 
  body.overlay-horizontal-menu.side-menu-opened #header-inner-wrap #header-controls-right, 
  body.overlay-horizontal-menu.side-menu-opened #header-inner-wrap #header-controls-left,
  body.page-stack-top.side-menu-opened #header-inner-wrap #header-wrap, 
  body.page-stack-top.side-menu-opened #header-inner-wrap #header-controls-right, 
  body.page-stack-top.side-menu-opened #header-inner-wrap #header-controls-left{
    line-height : <?php echo ( ( isset( $be_themes_data[ 'menu_and_widget_color_top_menu_open' ] ) && !empty( $be_themes_data[ 'menu_and_widget_color_top_menu_open' ] ) ) ? ( ( 'dark' == $be_themes_data[ 'menu_and_widget_color_top_menu_open' ] ) ? $logo_dark_height : $logo_light_height ) : $logo_transparent_height ).'px'; ?>;
  }

  .special-header-menu .menu-item,
  .special-header-logo,
  .special-header-bottom-text{
    text-align: <?php echo $be_themes_data['top_special_menu_alignment_horizontal'] ?>
  }
<?php } ?>

<?php if( be_is_special_left_menu() ){
  if( isset( $be_themes_data['left_special_strip_width'] ) && !empty( $be_themes_data['left_special_strip_width'] ) ){ 
    $left_strip_width = $be_themes_data['left_special_strip_width']; 
  } else{
    $left_strip_width = 70;
  }
  if( ( be_is_special_left_menu( 'left-strip-menu' ) || be_is_special_left_menu( 'left-static-menu' ) ) && isset( $be_themes_data['left_special_header_width'] ) && !empty( $be_themes_data['left_special_header_width'] ) ){
    $left_header_width = $be_themes_data['left_special_header_width']; 
  } else{
    $left_header_width = 280;
  }
?>
  .be-sidemenu{
    width :  <?php echo $left_header_width.'px'; ?>;
  }

  .be-sidemenu.be-sidemenu-left {
    transform : translateX( <?php echo '-'.$left_header_width.'px'; ?> );
  }

  .left-header.perspective-right.perspectiveview #main-wrapper{
    width: calc( 100% - <?php echo $left_strip_width.'px'; ?> )
  }

  .special-header-menu .menu-item,
  .special-header-logo,
  .special-header-bottom-text{
    text-align: <?php echo $be_themes_data['left_special_menu_alignment_horizontal'] ?>
  }

  /*Dont apply the image and colour over image in case of perspective right in left header*/
  .left-header:not(.perspective-right) .be-sidemenu{
    <?php be_themes_set_backgrounds('opt-header-color'); ?>
    <?php be_themes_background_colors($be_themes_data['left_overlay_menu_bg_color']['color'], $be_themes_data['left_overlay_menu_bg_color']['alpha']); ?>
  }
  
  .left-header:not(.perspective-right) .special-header-menu a::before{
    <?php be_themes_background_colors($be_themes_data['left_overlay_menu_bg_color']['color'], $be_themes_data['left_overlay_menu_bg_color']['alpha']); ?>
  }
  <?php if( !empty( $be_themes_data['opt-header-color']['background-image'] )) {?>
    .left-header:not(.perspective-right) .be-sidemenu:before{
      content: '';
      position: absolute;
      pointer-events: none;
      top: 0;
      width: 100%;
      height : 100%;
      z-index: -1;
      <?php be_themes_background_colors($be_themes_data['left-static-overlay']['color'], $be_themes_data['left-static-overlay']['alpha']); ?>
    }<?php
  }?>

  .left-header.left-static-menu .be-sidemenu {
    <?php be_themes_set_backgrounds('opt-header-color'); ?>
  }

  .be-left-strip-wrapper{
    width: <?php echo $left_strip_width.'px'; ?>;
    <?php be_themes_background_colors($be_themes_data['left_strip_bg_color']['color'], $be_themes_data['left_strip_bg_color']['alpha']); ?>
  }

  .left-static-menu #main-wrapper{
    margin-left: <?php echo $left_header_width.'px'; ?>;
  }

  .left-strip-menu .be-sidemenu.be-sidemenu-left.opened{
    transform: translateX( <?php echo $left_strip_width.'px'; ?> );
  }

  .left-strip-menu #main::after{
    <?php be_themes_background_colors($be_themes_data['main_overlay_color_left_menu_open']['color'], $be_themes_data['main_overlay_color_left_menu_open']['alpha']); ?> 
    //left: -<?php echo $left_strip_width.'px'; ?>;
    width: 100%;
  }

  .left-strip-menu .be-sidemenu.be-sidemenu-left{
    transform : translateX( <?php echo -($left_header_width - $left_strip_width).'px'; ?> );
  }
  .left-strip-menu:not(.menu_over_main).side-menu-opened #main{
    transform : translateX( <?php echo $left_header_width.'px'; ?> );
  }

  .left-header:not(.left-static-menu):not(.left-static) #main-wrapper{
    margin-left: <?php echo $left_strip_width.'px'; ?>;
  }

  .left-header.side-menu-opened.overlay-center-align-menu #main-wrapper, .left-header.side-menu-opened.overlay-left-align-menu #main-wrapper {
    margin-left: 0px;
  }

  .left-strip-menu #be-left-strip:after{
    border-right: 1px solid <?php echo $be_themes_data['left_side_menu_border']; ?>;
  }


  <?php 
    // Logo has a top of 40px. Hence add that to the height of logo and apply as padding
    $be_sidemenu_padding = 0;
    if((!isset($be_themes_data['disable_logo']) || empty($be_themes_data['disable_logo'])) || (isset($be_themes_data['disable_logo']) && (0 == $be_themes_data['disable_logo'])) ){		
      if( ! empty( $be_themes_data['logo_sidebar']['url'] )) {
        $be_sidemenu_padding = $be_themes_data['logo_sidebar']['height'];
      }
    }
    if( $be_sidemenu_padding > 80 ){
      $be_sidemenu_padding = 80;
    }
    $be_sidemenu_padding += 40;      
  ?>
  .overlay-left-align-menu #be-sidemenu-content{
    padding-top : <?php echo ( $be_sidemenu_padding ).'px' ?>; 
  }
  .overlay-left-align-menu .be-sidemenu .special-header-menu, 
  .overlay-left-align-menu .be-sidemenu .special-header-bottom-text{
    margin-bottom: <?php echo ( $be_sidemenu_padding ).'px' ?>;
   }
<?php } ?>
/*Portfolio navigation*/
<?php if( true == $be_themes_data['portfolio_nav_bottom'] ){ ?>
  #portfolio-navigation-bottom-wrap{
    height: <?php echo $be_themes_data['portfolio_nav_bottom_height'].'px'; ?>;
    border-top: <?php echo be_themes_borders('portfolio_nav_bottom_border','top') ; ?>;
    border-bottom: <?php echo be_themes_borders('portfolio_nav_bottom_border','bottom') ; ?>;
  }

a.navigation-previous-post-link,
a.navigation-next-post-link{
  color: <?php echo $be_themes_data['portfolio_nav_bottom_text_color']; ?>;
}

  a.navigation-previous-post-link:hover,
  a.navigation-next-post-link:hover{
    color: <?php echo $be_themes_data['portfolio_nav_bottom_text_hover_color']; ?>
  }

  .arrow-line-one,
  .arrow-line-two,
  .arrow-line-three{
    background-color: <?php echo $be_themes_data['portfolio_nav_bottom_text_color']; ?>
  }

  .navigation-previous-post-link:hover .arrow-line-one,
  .navigation-previous-post-link:hover .arrow-line-two,
  .navigation-previous-post-link:hover .arrow-line-three,
  .navigation-next-post-link:hover .arrow-line-one,
  .navigation-next-post-link:hover .arrow-line-two,
  .navigation-next-post-link:hover .arrow-line-three{
    background-color: <?php echo $be_themes_data['portfolio_nav_bottom_text_hover_color']; ?>
  }

  .navigation-grid{
    border-right: <?php echo be_themes_borders('portfolio_nav_bottom_border','top') ; ?>;
    border-left: <?php echo be_themes_borders('portfolio_nav_bottom_border','bottom') ; ?>;
  }

  #portfolio-navigation-bottom-wrap{
    background : <?php echo $be_themes_data['portfolio_nav_bottom_bg_color']; ?>;
  }
  .navigation-grid:hover,
  .navigation-previous::after,
  .navigation-next::after{
    background-color : <?php echo $be_themes_data['portfolio_nav_bottom_bg_hover_color']; ?>;
  }
  <?php 
    if( true == $be_themes_data['portfolio_nav_bottom_thumbnail'] ) { ?>
      .navigation-previous::before,
      .navigation-next::before{
        content: '';
      }
      .navigation-previous::before,
      .navigation-next::before{
        <?php be_themes_background_colors($be_themes_data['portfolio_nav_bottom_featured_image_overlay_color']['color'], $be_themes_data['portfolio_nav_bottom_featured_image_overlay_color']['alpha']);?>;
      }
      .navigation-previous:hover::before,
      .navigation-next:hover::before{
        <?php be_themes_background_colors($be_themes_data['portfolio_nav_bottom_featured_image_overlay_hover_color']['color'], $be_themes_data['portfolio_nav_bottom_featured_image_overlay_hover_color']['alpha']);?>;
      }
    <?php }
    if( ( true == $be_themes_data['portfolio_nav_bottom_thumbnail'] ) || ( ( $be_themes_data['portfolio_nav_bottom_bg_hover_color'] != $be_themes_data['portfolio_nav_bottom_bg_color'] ) && ( $be_themes_data['portfolio_nav_bottom_bg_hover_color'] != 'transparent' ) ) ){ ?>
      .navigation-previous a, .navigation-grid a, .navigation-next a{
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        width: 100%;
      }
    <?php
    }
    $portfolio_nav_grid_icon = basename( $be_themes_data['portfolio_nav_bottom_grid_icon'], '.jpg');
    if( empty( $portfolio_nav_grid_icon ) ) {
        $portfolio_nav_grid_icon = 'six-filled';
    }    
    if( strpos( $portfolio_nav_grid_icon, 'filled' ) !== false ){ 
    ?>
      #portfolio-navigation-bottom-wrap .home-grid-icon span{
        background: <?php echo $be_themes_data['portfolio_nav_bottom_icon_color']; ?>;
      }
    <?php 
    } else if( strpos( $portfolio_nav_grid_icon, 'hollow' ) !== false ){ ?>
      #portfolio-navigation-bottom-wrap .home-grid-icon span{
        background: transparent;
        border: 1px solid <?php echo $be_themes_data['portfolio_nav_bottom_icon_color']; ?>;
      }
      #portfolio-navigation-bottom-wrap .portfolio-url:hover span{
        border: 1px solid <?php echo $be_themes_data['portfolio_nav_bottom_icon_hover_color']; ?>;
      }
    <?php }
    if( 'four-filled' == $portfolio_nav_grid_icon || 'four-hollow' == $portfolio_nav_grid_icon ){ ?>
      #portfolio-navigation-bottom .home-grid-icon{
        width: 14px;
      }
    <?php } else if ( 'nine-hollow' == $portfolio_nav_grid_icon ){ ?>
      #portfolio-navigation-bottom .home-grid-icon{
        width: 21px;
      }
    <?php }
  ?>
  #portfolio-navigation-bottom-wrap .portfolio-url:hover span{
    background: <?php echo $be_themes_data['portfolio_nav_bottom_icon_hover_color']; ?>;
  }
<?php } ?>

.loader-style1-double-bounce1, .loader-style1-double-bounce2,
.loader-style2-wrap,
.loader-style3-wrap > div,
.loader-style5-wrap .dot1, .loader-style5-wrap .dot2,
#nprogress .bar {
  background: <?php echo $color_scheme; ?> !important; 
}
.loader-style4-wrap {
  <?php $loader_color = be_themes_hexa_to_rgb( $color_scheme );
  if ( is_array( $loader_color ) && count( $loader_color ) >= 3 ) { ?>
    border-top: 7px solid rgba(<?php echo $loader_color[0].', '.$loader_color[1].', '.$loader_color[2]; ?> , 0.3);
    border-right: 7px solid rgba(<?php echo $loader_color[0].', '.$loader_color[1].', '.$loader_color[2]; ?> , 0.3);
    border-bottom: 7px solid rgba(<?php echo $loader_color[0].', '.$loader_color[1].', '.$loader_color[2]; ?> , 0.3);
  <?php } ?>
  border-left-color: <?php echo $color_scheme; ?>; 
}

#nprogress .spinner-icon {
  border-top-color: <?php echo $color_scheme; ?> !important; 
  border-left-color: <?php echo $color_scheme; ?> !important; 
}
#nprogress .peg {
  box-shadow: 0 0 10px <?php echo $color_scheme; ?>, 0 0 5px <?php echo $color_scheme; ?> !important;
}

.style1 #navigation,
.style3 #navigation,
.style4 #navigation,
.style5 #navigation, 
#header-controls-left,
#header-controls-right,
#header-wrap,
.mobile-nav-controller-wrap,
#left-header-mobile .header-cart-controls,
.style6 #navigation-left-side,
.style6 #navigation-right-side,
.style7 #navigation{
	line-height: <?php echo $logo_height; ?>px;
}
<?php 
//Only if admin set logo max width
if(!empty($be_themes_data['opt-logo-max-width']) && is_numeric($be_themes_data['opt-logo-max-width'])){ ?>
#header .logo img{
  max-width: <?php echo intval($be_themes_data['opt-logo-max-width']).'px'; ?>;
}
/*Light Logo */
body.header-transparent #header-inner-wrap.transparent:not(.no-transparent).background--dark  #navigation,
body.header-transparent #header-inner-wrap.transparent:not(.no-transparent).background--dark #header-wrap #navigation-left-side,
body.header-transparent #header-inner-wrap.transparent:not(.no-transparent).background--dark #header-wrap #navigation-right-side,
body.header-transparent #header-inner-wrap.transparent:not(.no-transparent).background--dark  .header-controls,
body.header-transparent #header-inner-wrap.transparent:not(.no-transparent).background--dark  #header-controls-left,
body.header-transparent #header-inner-wrap.transparent:not(.no-transparent).background--dark  #header-controls-right, 
body.header-transparent #header-inner-wrap.transparent:not(.no-transparent).background--dark  #header-wrap,
body.header-transparent #header-inner-wrap.transparent:not(.no-transparent).background--dark  .mobile-nav-controller-wrap{
  line-height: <?php echo $logo_light_height; ?>px;
}
/*Dark Logo */
body.header-transparent #header-inner-wrap.transparent:not(.no-transparent).background--light  #navigation,
body.header-transparent #header-inner-wrap.transparent:not(.no-transparent).background--light #header-wrap #navigation-left-side,
body.header-transparent #header-inner-wrap.transparent:not(.no-transparent).background--light #header-wrap #navigation-right-side,
body.header-transparent #header-inner-wrap.transparent:not(.no-transparent).background--light  .header-controls,
body.header-transparent #header-inner-wrap.transparent:not(.no-transparent).background--light  #header-controls-left,
body.header-transparent #header-inner-wrap.transparent:not(.no-transparent).background--light  #header-controls-right, 
body.header-transparent #header-inner-wrap.transparent:not(.no-transparent).background--light  #header-wrap,
body.header-transparent #header-inner-wrap.transparent:not(.no-transparent).background--light  .mobile-nav-controller-wrap{
  line-height: <?php echo $logo_dark_height; ?>px;
}
<?php } 
//For mobile logo max width
if(!empty($logo_max_width_mobile)){
?>
@media only screen and (max-width: 767px){
  #header .logo img{
  max-width: <?php echo $logo_max_width_mobile.'px'; ?>;
  }
  .style1 #navigation, .style3 #navigation, .style4 #navigation, .style5 #navigation, #header-controls-left, #header-controls-right, #header-wrap, .mobile-nav-controller-wrap, #left-header-mobile .header-cart-controls, .style6 #navigation-left-side, .style6 #navigation-right-side, .style7 #navigation{
    line-height: <?php echo $logo_height_mobile; ?>px !important;
  }
  #header-inner-wrap.transparent:not(.no-transparent).background--dark #header-wrap{
      line-height: <?php echo $logo_light_height_mobile; ?>px !important;
    }
    #header-inner-wrap.transparent:not(.no-transparent).background--light #header-wrap{
      line-height: <?php echo $logo_dark_height_mobile; ?>px !important;
    }
}
@media only screen and (max-width : 320px){
  #header-wrap #header-controls-right,
  #header-wrap  .mobile-nav-controller-wrap{
      line-height: <?php echo $logo_height_mobile; ?>px !important; 
    }
    #header-inner-wrap.transparent:not(.no-transparent).background--dark #header-wrap #header-controls-right,#header-inner-wrap.transparent:not(.no-transparent).background--dark #header-wrap .mobile-nav-controller-wrap{
      line-height: <?php echo $logo_light_height_mobile; ?>px !important;
    }
    #header-inner-wrap.transparent:not(.no-transparent).background--light #header-wrap #header-controls-right,#header-inner-wrap.transparent:not(.no-transparent).background--light #header-wrap .mobile-nav-controller-wrap{
      line-height: <?php echo $logo_dark_height_mobile; ?>px !important;
    }
}
@media only screen and (min-width: 321px) and (max-width: 480px){
  #header-wrap #header-controls-right,
  #header-wrap .mobile-nav-controller-wrap{
      line-height: <?php echo $logo_height_mobile; ?>px !important; 
    }
    #header-inner-wrap.transparent:not(.no-transparent).background--dark #header-wrap #header-controls-right,#header-inner-wrap.transparent:not(.no-transparent).background--dark #header-wrap .mobile-nav-controller-wrap{
      line-height: <?php echo $logo_light_height_mobile; ?>px !important;
    }
    #header-inner-wrap.transparent:not(.no-transparent).background--light #header-wrap #header-controls-right,#header-inner-wrap.transparent:not(.no-transparent).background--light #header-wrap .mobile-nav-controller-wrap{
      line-height: <?php echo $logo_dark_height_mobile; ?>px !important;
    }
  }
<?php } ?>
/*Transparent default*/
body.header-transparent #header-wrap #navigation,
body.header-transparent #header-wrap #navigation-left-side,
body.header-transparent #header-wrap #navigation-right-side,
body.header-transparent #header-inner-wrap .header-controls,
body.header-transparent #header-inner-wrap #header-controls-left,
body.header-transparent #header-inner-wrap #header-controls-right, 
body.header-transparent #header-inner-wrap #header-wrap,
body.header-transparent #header-inner-wrap .mobile-nav-controller-wrap {
	line-height: <?php echo $logo_transparent_height; ?>px;
}
body #header-inner-wrap.top-animate #navigation,
body #header-inner-wrap.top-animate #navigation-left-side,
body #header-inner-wrap.top-animate #navigation-right-side,
body #header-inner-wrap.top-animate .header-controls,
body #header-inner-wrap.top-animate #header-wrap,
body #header-inner-wrap.top-animate #header-controls-right,
body #header-inner-wrap.top-animate #header-controls-left {
	line-height: <?php echo $logo_sticky_height; ?>px;
}
.header-transparent #content.page-split-screen-left,
.header-transparent #content.page-split-screen-right{
  
}
<?php 
if(isset($be_themes_data['disable_logo']) && $be_themes_data['disable_logo'] == 1){
?>
  #header-inner-wrap,
  .style2 #header-bottom-bar,
  .style13 #header-bottom-bar {
    height: <?php echo $logo_height; ?>px;
  }
  .style2 #navigation,
  .style13 #navigation,
  body #header-inner-wrap.top-animate.style2 #navigation,
  body #header-inner-wrap.top-animate.style13 #navigation{
    line-height: <?php echo $logo_height; ?>px;
  }
<?php
}else{
  ?>
  #navigation-left-side {
    padding-right: <?php echo ($logo_width/2)+40 ; ?>px;
  }
  #navigation-right-side {
    padding-left: <?php echo ($logo_width/2)+40 ; ?>px;
  }
<?php
}
?>

<?php if(($logo_width > 130) && ($logo_attachment_flag == 1) && $logo_height_original ){?>
  @media only screen and (max-width : 320px){
    .logo{
     width: <?php echo $logo_width ; ?>px;
      max-width: 40%; 
      margin-left: 10px !important;
    }
    #header-controls-right,
    .mobile-nav-controller-wrap{
      line-height: <?php echo (130/($logo_width/$logo_height_original)) + (2*$padding) ?>px !important; 
      right: 10px !important;
    }
  }<?php
}?>
<?php if(($logo_width > 240) && ($logo_attachment_flag == 1) && $logo_height_original ){?>
  @media only screen and (min-width: 321px) and (max-width: 480px){
    .logo{
      max-width: 50%; 
      margin-left: 20px !important;
    }
    #header-controls-right,
    .mobile-nav-controller-wrap{
      line-height: <?php echo (240/($logo_width/$logo_height_original)) + (2*$padding) ?>px !important; 
      right: 20px !important;
    }
  }<?php
}?>
<?php if(($logo_width > 370) && ($logo_attachment_flag == 1) && $logo_height_original ){?>
  @media only screen and (min-width: 481px) and (max-width: 767px){
    .logo{
      max-width: 50%; 
      margin-left: 15px !important;
    }
    #header-controls-right,
    .mobile-nav-controller-wrap{
      line-height: <?php echo (370/($logo_width/$logo_height_original)) + (2*$padding) ?>px !important; 
      right: 20px !important;
    }
  }<?php
}?>

#bbpress-forums li.bbp-body ul.forum, 
#bbpress-forums li.bbp-body ul.topic {
  border-top: 1px solid <?php echo $be_themes_data['sec_border']; ?>;
}
#bbpress-forums ul.bbp-lead-topic, #bbpress-forums ul.bbp-topics, #bbpress-forums ul.bbp-forums, #bbpress-forums ul.bbp-replies, #bbpress-forums ul.bbp-search-results {
  border: 1px solid <?php echo $be_themes_data['sec_border']; ?>;
}
#bbpress-forums li.bbp-header, 
#bbpress-forums li.bbp-footer,
.menu-card-item.highlight-menu-item {
  background: <?php echo $be_themes_data['sec_bg']; ?>;
}

#bbpress-forums .topic .bbp-topic-meta a:hover,
.bbp-forum-freshness a:hover,
.bbp-topic-freshness a:hover,
.bbp-header .bbp-reply-content a:hover,
.bbp-topic-tags a:hover,
.bbp-breadcrumb a:hover,
.bbp-forums-list a:hover {
  color: <?php echo $color_scheme; ?>;
}
div.bbp-reply-header,
.bar-style-related-posts-list,
.menu-card-item {
  border-color: <?php echo $be_themes_data['sec_border']; ?>;
}


#evcal_list .eventon_list_event .evcal_desc span.evcal_event_title, .eventon_events_list .evcal_event_subtitle {
  padding-bottom: 10px !important;
}
.eventon_events_list .eventon_list_event .evcal_desc, .evo_pop_body .evcal_desc, #page-content p.evcal_desc {
  padding-left: 100px !important;
}
.evcal_evdata_row {
  background: <?php echo $be_themes_data['sec_bg']; ?> !important;
}
.eventon_events_list .eventon_list_event .event_description {
  background: <?php echo $be_themes_data['sec_bg']; ?> !important;
  border-color: <?php echo $be_themes_data['sec_border']; ?> !important;
}
.bordr,
#evcal_list .bordb {
  border-color: <?php echo $be_themes_data['sec_border']; ?> !important; 
}
.evcal_evdata_row .evcal_evdata_cell h3 {
  margin-bottom: 10px !important;
}

/**** Be single portfolio - overflow images ****/
<?php 
$portfolio_single_style = get_post_meta( get_the_ID(), 'be_themes_portfolio_single_page_style', true );
$header_bg_style = get_post_meta( get_the_ID(), 'be_themes_header_transparent', true );
$header_is_sticky = get_post_meta( get_the_ID(), 'be_themes_sticky_header' , true );
if( is_singular( 'portfolio' ) && isset( $portfolio_single_style ) && 
  ( 'fixed-overflow-left' == $portfolio_single_style || 'fixed-overflow-right' == $portfolio_single_style ) && 
  isset( $header_bg_style ) &&  
  ( 'transparent' == $header_bg_style || 'semitransparent' == $header_bg_style ) ) { ?>
        .header-transparent .be-content-overflow #right-sidebar{
            transition : padding-top 0.3s ease;
            padding-top : <?php echo ((int)$logo_transparent_height + 20) .'px'; ?>;
        }
<?php 
        if( $header_is_sticky ) { ?>
          .transparent-sticky.be-sticky-active .be-content-overflow #right-sidebar {
              padding-top : <?php echo ( (int)$logo_sticky_height + 20 ). 'px'; ?>;
          }
      <?php  }
  }
?>
/*  Optiopn Panel Css */
<?php echo stripslashes_deep(htmlspecialchars_decode($be_themes_data['custom_css'],ENT_QUOTES));  ?>