<?php
    $headings = array(
        'h1' => array(
            'label' => __( 'Heading 1', 'oshin' ),
            'selector' => 'h1',
            'responsive' => true,
            'img' => get_template_directory_uri().'/img/typehub/h1_h6.jpg',
            'expose' => true,
            'options' => array(
                'font-family' => 'google:Montserrat',
                'font-variant' => '700',
                'font-size' => '55px',
                'text-transform' => 'none',
                'letter-spacing' => '0px',
                'line-height' => '70px',
                'color' => '#222222',
            )
        ),
        'h2' => array(
            'label' => __( 'Heading 2', 'oshin' ),
            'selector' => 'h2',
            'responsive' => true,
            'img' => get_template_directory_uri().'/img/typehub/h1_h6.jpg',
            'expose' => true,
            'options' => array(
                'font-family' => 'google:Montserrat',
                'font-variant' => '700',
                'font-size' => '42px',
                'text-transform' => 'none',
                'letter-spacing' => '0px',
                'line-height' => '63px',
                'color' => '#222222',
            )
        ),
        'h3' => array(
            'label' => __( 'Heading 3', 'oshin' ),
            'selector' => 'h3',
            'responsive' => true,
            'img' => get_template_directory_uri().'/img/typehub/h1_h6.jpg',
            'expose' => true,
            'options' => array(
                'font-family' => 'google:Montserrat',
                'font-variant' => '700',
                'font-size' => '35px',
                'text-transform' => 'none',
                'letter-spacing' => '1px',
                'line-height' => '52px',
                'color' => '#222222',
            )
        ),
        'h4' => array(
            'label' => __( 'Heading 4', 'oshin' ),
            'selector' => 'h4,
                .woocommerce-order-received .woocommerce h2, 
                .woocommerce-order-received .woocommerce h3,
                .woocommerce-view-order .woocommerce h2, 
                .woocommerce-view-order .woocommerce h3',
            'responsive' => true,
            'img' => get_template_directory_uri().'/img/typehub/h1_h6.jpg',
            'expose' => true,
            'options' => array(
                'font-family' => 'google:Montserrat',
                'font-variant' => '400',
                'font-size' => '26px',
                'text-transform' => 'none',
                'letter-spacing' => '0px',
                'line-height' => '42px',
                'color' => '#222222',
            )
        ),
        'h5' => array(
            'label' => __( 'Heading 5', 'oshin' ),
            'selector' => 'h5, #reply-title',
            'responsive' => true,
            'img' => get_template_directory_uri().'/img/typehub/h1_h6.jpg',
            'expose' => true,
            'options' => array(
                'font-family' => 'google:Montserrat',
                'font-variant' => '400',
                'font-size' => '20px',
                'text-transform' => 'none',
                'letter-spacing' => '0px',
                'line-height' => '36px',
                'color' => '#222222',
            )
        ),
        'h6' => array(
            'label' => __( 'Heading 6', 'oshin' ),
            'selector' => 'h6,
                .testimonial-author-role.h6-font,
                .menu-card-title,
                .menu-card-item-price,
                .slider-counts,
                .woocommerce-MyAccount-navigation ul li,
                a.bbp-forum-title,
                #bbpress-forums fieldset.bbp-form label,
                .bbp-topic-title a.bbp-topic-permalink,
                #bbpress-forums ul.forum-titles li,
                #bbpress-forums ul.bbp-replies li.bbp-header',  
            'responsive' => true, 
            'img' => get_template_directory_uri().'/img/typehub/h1_h6.jpg',
            'expose' => true,
            'options' => array(  
                'font-family' => 'google:Montserrat', 
                'font-variant' => '400',  
                'font-size' => '15px', 
                'text-transform' => 'none', 
                'letter-spacing' => '0px', 
                'line-height' => '32px',
                'color' => '#222222',
            )
        ),
    );
    $content = array(
        'body' => array(
            'label' => __( 'Body - Main Text', 'oshin' ),
            'selector' => 'body,
                .special-heading-wrap .caption-wrap .body-font,
                .woocommerce .woocommerce-ordering select.orderby, 
                .woocommerce-page .woocommerce-ordering select.orderby',
            'responsive' => true,
            'img' => get_template_directory_uri().'/img/typehub/body.jpg',  
            'expose' => true,
            'options' => array( 
                'font-family' => 'google:Raleway', 
                'font-variant' => '400', 
                'font-size' => '13px', 
                'text-transform' => 'none',
                'letter-spacing' => '0px',
                'line-height' => '26px',
                'color' => '#5f6263',
            )
        ),
        'page_title_module_typo' => array(
            'label' => __( 'Page Title Bar', 'oshin' ),
            'selector' => '.page-title-module-custom .page-title-custom,
                h6.portfolio-title-nav',
            'responsive' => true,
            'img' => get_template_directory_uri().'/img/typehub/page_title_module_typo.jpg',                   
            'options' => array( 
                'font-family'   => 'google:Montserrat',
                'font-size'     => '18px',
                'line-height'   => '36px',
                'font-variant'   => '400',
                'text-transform' => 'uppercase',
                'letter-spacing' => '3px',
                'color'         => '#000000',
            )
        ),
        'sub_title' => array( 
            'label' => __( 'Sub Title', 'oshin' ),
            'selector' => '.sub-title, .special-subtitle',
            'img' => get_template_directory_uri().'/img/typehub/sub_title.jpg',
            'expose' => true,
            'options' => array(
                'font-family'   => 'google:Crimson Text',
                'font-variant'   => '400italic',
                'text-transform' => 'none',
                'font-size' => '15px',
                // 'letter-spacing' => '0px'
            )
        ),
        'footer_text' => array(
            'label' => __( 'Footer Text', 'oshin' ),
            'selector' => '#footer',
            'responsive' => true,
            'img' => get_template_directory_uri().'/img/typehub/footer_text.jpg',
            'options' => array(
                'color'         => '#888888',
                'font-size'     => '13px',
                'line-height'   => '14px',
                'font-family'   => 'google:Raleway',
                'font-variant'   => '400',
                'text-transform' => 'none',
                'letter-spacing' => '0px'
            )
        ),
    );
    $navigation = array(
        'navigation_text' => array(
            'label' => __( 'Navigation Menu', 'oshin' ),
            'selector' => '.special-header-menu .menu-container, #navigation .mega .sub-menu .highlight .sf-with-ul ,#navigation,
                .style2 #navigation,
                .style13 #navigation,
                #navigation-left-side,
                #navigation-right-side,
                .sb-left  #slidebar-menu,
                .header-widgets,
                .header-code-widgets,
                body #header-inner-wrap.top-animate.style2 #navigation,
                .top-overlay-menu .sb-right  #slidebar-menu ',
            'responsive' => true,
            'img' => get_template_directory_uri().'/img/typehub/navigation_text.jpg',
            'options' => array( 
                'color'         => '#232323', 
                'font-size'     => '12px', 
                'line-height'   => '51px',
                'font-family'   => 'google:Montserrat',
                'font-variant'   => '400',
                'text-transform' => 'uppercase',
                'letter-spacing' => '1px'
            )
        ),
        'submenu_text' => array(
            'label' => __( 'Navigation Submenu', 'oshin' ),
            'selector' => '.special-header-menu .menu-container .sub-menu,
                .special-header-menu .sub-menu, #navigation .sub-menu,
                #navigation .children,
                #navigation-left-side .sub-menu,
                #navigation-left-side .children,
                #navigation-right-side .sub-menu,
                #navigation-right-side .children,
                .sb-left  #slidebar-menu .sub-menu,
                .top-overlay-menu .sb-right  #slidebar-menu .sub-menu',
            'img' => get_template_directory_uri().'/img/typehub/submenu_text.jpg',
            'options' => array( 
                'color'         => '#bbbbbb',
                'font-size'     => '13px',
                'line-height'   => '28px',
                'font-family'   => 'google:Raleway',
                'font-variant'   => '400',
                'text-transform' => 'none',
                'letter-spacing' => '0px'
            )
        ),
        'mobile_menu_text' => array(
            'label' => __( 'Mobile Menu', 'oshin' ),
            'selector' => 'ul#mobile-menu a, ul#mobile-menu li.mega ul.sub-menu li.highlight > :first-child',
            'img' => get_template_directory_uri().'/img/typehub/mobile_menu_text.jpg',
            'options' => array( 
                'color'         => '#232323',
                'font-size'     => '12px',
                'line-height'   => '40px',
                'font-family'   => 'google:Montserrat',
                'font-variant'   => '400',
                'text-transform' => 'uppercase',
                'letter-spacing' => '1px'
            )
        ),
        'mobile_submenu_text' => array(
            'label' => __( 'Mobile Submenu', 'oshin' ),
            'selector' => 'ul#mobile-menu ul.sub-menu a',
            'img' => get_template_directory_uri().'/img/typehub/mobile_submenu_text.jpg',
            'options' => array( 
                'color'         => '#bbbbbb',
                'font-size'     => '13px',
                'line-height'   => '27px',
                'font-family'   => 'google:Raleway',
                'font-variant'   => '400',
                'text-transform' => 'none',
                'letter-spacing' => '0px'
            )
        ),
        'sidebar_menu_text' => array(
            'label' => __( 'Sidebar Menu Text', 'oshin' ),
            'selector' => '.top-right-sliding-menu .sb-right ul#slidebar-menu li,
            .sb-right #slidebar-menu .mega .sub-menu .highlight .sf-with-ul ',
            'img' => get_template_directory_uri().'/img/typehub/sidebar_menu_text.jpg',
            'options' => array( 
                'color'         => '#ffffff', 
                'font-size'     => '12px', 
                'line-height'   => '50px',
                'font-family'   => 'google:Raleway',
                'font-variant'   => '400',
                'text-transform' => 'uppercase',
                'letter-spacing' => '1px'
            )
        ),
        'sidebar_submenu_text' => array(
            'label' => __( 'Sidebar Submenu Text', 'oshin' ),
            'selector' => '.top-right-sliding-menu .sb-right #slidebar-menu ul.sub-menu li',
            'img' => get_template_directory_uri().'/img/typehub/sidebar_submenu_text.jpg',
            'options' => array( 
                'color'         => '#ffffff',
                'font-size'     => '13px', 
                'line-height'   => '25px',
                'font-family'   => 'google:Raleway',
                'font-variant'   => '400',
                'text-transform' => 'none',
                'letter-spacing' => ''
            )
        ),  
    );
    $pagebuilder_options = array(
        'pb_module_title' => array(
            'label' => __( 'Title font of page builder modules', 'oshin' ),
            'selector' => '.ui-tabs-anchor, .accordion .accordion-head, .skill-wrap .skill_name, .chart-wrap span, .animate-number-wrap h6 span, .woocommerce-tabs .tabs li a, .be-countdown',
            //'img' => get_template_directory_uri().'/img/typehub/pb_module_title.jpg',
            'options' => array(
                'font-family'   => 'google:Raleway',
                'letter-spacing' => '0px',
                'font-variant'   => '600',
            )
        ),
        'pb_tab_font_size' => array(
            'label' => __( 'Tab Module Title Size', 'oshin' ),
            'selector' => '.ui-tabs-anchor',
            'responsive' => true,
            'img' => get_template_directory_uri().'/img/typehub/pb_tab_font_size.jpg',
            'options' => array(
                'font-size'     => '13px',
                'line-height'   => '17px',
                'text-transform' => 'uppercase',
            )
        ),
        'pb_acc_font_size' => array(
            'label' => __( 'Accordion Module Title Size', 'oshin' ),
            'selector' => '.accordion .accordion-head',
            'responsive' => true,
            'img' => get_template_directory_uri().'/img/typehub/pb_acc_font_size.jpg',
            'options' => array(
                'font-size'     => '13px',
                'line-height'   => '17px',
                'text-transform' => 'uppercase',
            )
        ),
        'pb_skill_font_size' => array(
            'label' => __( 'Skills Module Title Size', 'oshin' ),
            'selector' => '.skill-wrap .skill_name',
            'responsive' => true,
            'img' => get_template_directory_uri().'/img/typehub/pb_skill_font_size.jpg',
            'options' => array(
                'font-size'     => '12px',
                'line-height'   => '17px',
                'text-transform' => 'uppercase',
            )
        ),
        'pb_countdown_number_font_size' => array(
            'label' => __( 'Countdown Number Font Size', 'oshin' ),
            'selector' => '.countdown-amount',
            'responsive' => true,
            'img' => get_template_directory_uri().'/img/typehub/pb_countdown_number_font_size.jpg',
            'responsive' => true,
            'options' => array(
                'font-size'     => '55px',
                'line-height'   => '95px',
                'text-transform' => 'uppercase',
            )
        ),
        'pb_countdown_caption_font_size' => array(
            'label' => __( 'Countdown Caption Font Size', 'oshin' ),
            'selector' => '.countdown-section',
            'responsive' => true,
            'img' => get_template_directory_uri().'/img/typehub/pb_countdown_caption_font_size.jpg',
            'options' => array(
                'font-size'     => '15px',
                'line-height'   => '30px',
                'text-transform' => 'uppercase',
            )
        ),
        'pb_module_spl_body' => array(
            'label' => __( 'Testimonials Font Family', 'oshin' ),
            'selector' => '.testimonial_slide .testimonial-content',
            'img' => get_template_directory_uri().'/img/typehub/pb_module_spl_body.jpg',
            'options' => array(
                'font-family'   => 'google:Crimson Text',
                'letter-spacing' => '0px',
                'font-variant'   => '400italic',
                'text-transform' => 'none',
            )
        ),
        // 'pb_blockquote_font_size' => array( // this id is not found in be-themes-styles.php
        //     'label' => __( 'Blockquote Font Size', 'oshin' ),
        //     'selector' => '',
        //     'img' => get_template_directory_uri().'/img/typehub/pb_blockquote_font_size.jpg',
        //     'options' => array(
        //         'font-size'     => '26px', 
        //     )
        // ),
        'pb_module_tweet' => array(
            'label' => __( 'Tweet Module Font Family', 'oshin' ),
            'selector' => '.tweet-slides .tweet-content',
            'responsive' => true,
            'img' => get_template_directory_uri().'/img/typehub/pb_module_tweet.jpg',
            'options' => array(
                'font-family'   => 'google:Raleway',
                'letter-spacing' => '0px',
                'font-variant'   => '',
                'text-transform' => 'none', 
            )
        ),
        'button_font' => array(
            'label' => __( 'Buttons Font Family', 'oshin' ),
            'selector' => '.tatsu-button,
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
                input[type="file"]::-webkit-file-upload-button',
            'img' => get_template_directory_uri().'/img/typehub/button_font.jpg',
            'options' => array( 
                'font-family'   => 'google:Montserrat',
                'font-variant'   => '', 
            )
        ),
        'animated_link_font' => array(
            'label' => __( 'Animated Link Font Family', 'oshin' ),
            'selector' => '.oshine-animated-link, .view-project-link.style4-button',
            'img' => get_template_directory_uri().'/img/typehub/animated_link_font.jpg',
            'options' => array( 
                'font-family'   => 'google:Montserrat',
                'font-variant'   => '',
                'letter-spacing' => '',
                'text-transform' => 'none',
            ),
        ),        
    );
    $portfolio = array(
        'portfolio_title' => array(
            'label' => __( 'Title on Portfolio Grid', 'oshin' ),
            'selector' => '.thumb-title-wrap .thumb-title, .full-screen-portfolio-overlay-title',
            'responsive' => true,
            'img' => get_template_directory_uri().'/img/typehub/portfolio_title.jpg',
            'options' => array(
                'font-size'     => '14px',
                'line-height'   => '30px',
                'font-family'   => 'google:Montserrat',
                'font-variant'   => '400',
                'text-transform' => 'uppercase',
                'letter-spacing' => '0px'
            )
        ),
        'portfolio_meta_typo' => array(
            'label' => __( 'Meta on Portfolio Grid', 'oshin' ),
            'selector' => '.thumb-title-wrap .portfolio-item-cats',
            'responsive' => true,
            'img' => get_template_directory_uri().'/img/typehub/portfolio_meta_typo.jpg',
            'options' => array(
                'font-size'     => '12px',
                'line-height'   => '17px',
                'text-transform' => 'none',
                'letter-spacing'   => 0,
            )
        ),
        'portfolio_details_title' => array(
            'label' => __( 'Portfolio Details Module - Title', 'oshin' ),
            'selector' => 'h6.gallery-side-heading',
            'responsive' => true,
            'img' => get_template_directory_uri().'/img/typehub/portfolio_details_title.jpg',
            'options' => array(
                'font-size'     => '15px',
                'line-height'   => '32px',
                'font-family'   => 'google:Montserrat',
                'font-variant'   => '400',
                'text-transform' => 'none',
                'letter-spacing' => '0px'
            )
        ),
        'portfolio_details_content' => array(
            'label' => __( 'Portfolio Details Module - Content', 'oshin' ),
            'selector' => '.portfolio-details .gallery-side-heading-wrap p',
            'responsive' => true,
            'img' => get_template_directory_uri().'/img/typehub/portfolio_details_content.jpg',
            'options' => array(
                'font-size'     => '13px',
                'line-height'   => '26px',
                'font-family'   => 'google:Raleway',
                'font-variant'   => '400',
                'text-transform' => 'none',
                'letter-spacing' => '0px'
            )
        ),
        'style4_portfolio_typography' => array (
            'label' => __( 'Split Screen Portfolio Title', 'oshin' ),
            'selector' => '.ps-fade-nav-item .ps-fade-nav-item-inner',
            'responsive' => true,
            //'img' => get_template_directory_uri().'/img/typehub/portfolio_details_content.jpg',
            'options' => array(
                'font-size'     => '60px',
                'line-height'   => '1.3em',
                'font-family'   => 'google:Raleway',
                'font-variant'   => '600',
                'text-transform' => 'none',
                'letter-spacing' => '0px',
                'color' => '#000',
            )
        ),
        'style5_portfolio_typography' => array (
            'label' => __( 'Title Carousel Portfolio Title', 'oshin' ),
            'selector' => '.ps-fade-horizontal-nav-item-inner',
            'responsive' => true,
            //'img' => get_template_directory_uri().'/img/typehub/portfolio_details_content.jpg',
            'options' => array(
                'font-size'     => '80px',
                'line-height'   => '1.3em',
                'font-family'   => 'google:Raleway',
                'font-variant'   => '600',
                'text-transform' => 'none',
                'letter-spacing' => '0px'
            )
        ),
        'portfolio_nav_bottom_typography' => array(
            'label' => __( 'Global Portfolio Navigation', 'oshin' ),
            'selector' => 'a.navigation-previous-post-link, a.navigation-next-post-link',
            'img' => get_template_directory_uri().'/img/typehub/portfolio_nav_bottom_typography.jpg',
            'responsive' => true,
            'options' => array(
                'font-size'     => '13px',
                'line-height'   => '20px',
                'font-family'   => 'google:Montserrat',
                'font-variant'   => '700',
                'text-transform' => 'none',
                'letter-spacing' => '0px'
            )
        ),
        'portfolio_title_count_typo' => array(
            'label' => __( 'Title in Portfolio Navigation Module', 'oshin' ),
            'selector' => '#portfolio-title-nav-bottom-wrap h6, #portfolio-title-nav-bottom-wrap .slider-counts',
            'img' => get_template_directory_uri().'/img/typehub/portfolio_title_count_typo.jpg',
            'options' => array(
                'font-size'     => '15px',
                'font-family'   => 'google:Montserrat',
                'font-variant'   => '400',
                'text-transform' => 'none',
                'letter-spacing' => '0px',
                'line-height' => '40px'
            )
        ),
        'portfolio_caption_typo' => array(
            'label' => __( 'Caption in Portfolio Sliders', 'oshin' ),
            'selector' => '.attachment-details-custom-slider',
            'responsive' => true,
            'img' => get_template_directory_uri().'/img/typehub/portfolio_caption_typo.jpg',
            'options' => array(
                'font-family'   => 'google:Crimson Text',
                'font-variant'   => '400italic',
                'text-transform' => 'none',
                'font-size' => '15px',
                'letter-spacing' => '0px'
            )
        ),
        'portfolio_filter_typo' => array(
            'label' => __( 'Portfolio Filters', 'oshin' ),
            'selector' => '.filters .filter_item',
            'responsive' => true,
            'img' => get_template_directory_uri().'/img/typehub/portfolio_filter_typo.jpg',
            'options' => array(
                'color'         => '#222222',
                'font-size'     => '12px',
                'line-height'   => '32px',
                'font-family'   => 'google:Montserrat',
                'font-variant'   => '400',
                'text-transform' => 'uppercase',
                'letter-spacing' => '1px'
            )
        ),
    );
    $shop = array(
        'shop_page_title' => array(
            'label' => __( 'Product Thumbnail Title', 'oshin' ),
            'selector' => '.woocommerce ul.products li.product .product-meta-data h3, 
                .woocommerce-page ul.products li.product .product-meta-data h3,
                .woocommerce ul.products li.product h3, 
                .woocommerce-page ul.products li.product h3,
                .woocommerce ul.products li.product .product-meta-data .woocommerce-loop-product__title, 
                .woocommerce-page ul.products li.product .product-meta-data .woocommerce-loop-product__title,
                .woocommerce ul.products li.product .woocommerce-loop-product__title, 
                .woocommerce-page ul.products li.product .woocommerce-loop-product__title,
                .woocommerce ul.products li.product-category .woocommerce-loop-category__title, 
                .woocommerce-page ul.products li.product-category .woocommerce-loop-category__title',
            'responsive' => true,
            'img' => get_template_directory_uri().'/img/typehub/shop_page_title.jpg',
            'options' => array(
                'color'         => '#222222',
                'font-size'     => '13px', 
                'line-height'   => '27px',
                'font-family'   => 'google:Montserrat',
                'font-variant'   => '400',
                'text-transform' => 'uppercase',
                'letter-spacing' => '1px'
            )
        ),
        'shop_single_page_title' => array(
            'label' => __( 'Individual Product Page Title', 'oshin' ),
            'selector' => '.woocommerce-page.single.single-product #content div.product h1.product_title.entry-title',
            'responsive' => true,
            'img' => get_template_directory_uri().'/img/typehub/shop_single_page_title.jpg',
            'options' => array(
                'color'         => '#222222',
                'font-size'     => '25px',
                'line-height'   => '27px',
                'font-family'   => 'google:Montserrat',
                'font-variant'   => '400',
                'text-transform' => 'none',
                'letter-spacing' => '0px'
            )
        ),
    );
    $blog = array(
        'post_title' => array( 
            'label' => __( 'Blog Post Title', 'oshin' ),
            'selector' => '.post-title , .post-date-wrap',
            'responsive' => true,
            'img' => get_template_directory_uri().'/img/typehub/post_title.jpg',
            'options' => array( 
                'color'         => '#000000',
                'font-size'     => '20px', 
                'line-height'   => '40px', 
                'font-family'   => 'google:Montserrat',
                'font-variant'   => '400',
                'text-transform' => 'none',
                'letter-spacing' => '0px'
            )
        ),
        'masonry_post_title' => array(
            'label' => __( 'Masonry Style Blog Post Title', 'oshin' ),
            'selector' => '.style3-blog .post-title, .style8-blog .post-title ',
            'responsive' => true,
            'img' => get_template_directory_uri().'/img/typehub/masonry_post_title.jpg',
            'options' => array(
                'color'         => '#363c3b',
                'font-size'     => '16px',
                'line-height'   => '28px',
                'font-family'   => 'Source Sans Pro',
                'font-variant'   => '400',
                'text-transform' => 'none',
                'letter-spacing' => '0px'
            )
        ),
        'post_top_meta_options' => array(
            'label' => __( 'Blog Post Top Meta Options', 'oshin' ),
            'selector' => '.post-meta.post-top-meta-typo, .style8-blog .post-meta.post-category a, .hero-section-blog-categories-wrap a ',
            'img' => get_template_directory_uri().'/img/typehub/post_top_meta_options.jpg',
            'options' => array(
                'color'         => '#757575',
                'font-size'     => '12px',
                'line-height'   => '24px',
                'font-family'   => 'google:Raleway',
                'font-variant'   => '',
                'text-transform' => 'uppercase',
                'letter-spacing' => '0px'
            )
        ),
        'post_meta_options' => array(
            'label' => __( 'Blog Post Bottom Meta Options', 'oshin' ),
            'selector' => '.post-nav li,
                           .style8-blog .post-meta.post-date,
                           .style8-blog .post-bottom-meta-wrap,
                           .hero-section-blog-bottom-meta-wrap',
            'img' => get_template_directory_uri().'/img/typehub/post_meta_options.jpg',
            'options' => array( 
                'color'         => '#757575', 
                'font-size'     => '12px',
                'line-height'   => '24px',
                'font-family'   => 'google:Raleway',
                'font-variant'   => '',
                'text-transform' => 'uppercase',
                'letter-spacing' => '0px'
            )
        ),
        'single_post_title' => array(
            'label' => __( 'Individual Blog Post Title', 'oshin' ),
            'selector' => '  .single-post .post-title,
                .single-post .style3-blog .post-title,
                .single-post .style8-blog .post-title ',
            'responsive' => true,
            'img' => get_template_directory_uri().'/img/typehub/single_post_title.jpg',
            'options' => array( 
                'color'         => '#ffffff', 
                'font-size'     => '25px',
                'line-height'   => '45px', 
                'font-family'   => 'google:Montserrat',
                'font-variant'   => '400',
                'text-transform' => 'none',
                'letter-spacing' => '0px'
            )
        ),
    );
    $widgets = array(
        'sidebar_widget_title' => array(
            'label' => __( 'Sidebar Widget Title', 'oshin' ),
            'selector' => '.sidebar-widgets h6',
            'img' => get_template_directory_uri().'/img/typehub/sidebar_widget_title.jpg',
            'options' => array(
                'color'         => '#333333',
                'font-size'     => '12px',
                'line-height'   => '22px',
                'font-family'   => 'google:Montserrat',
                'font-variant'   => '400',
                'text-transform' => 'uppercase',
                'letter-spacing' => '1px'
            )
        ),
        'sidebar_widget_text' => array(
            'label' => __( 'Sidebar Widget Text', 'oshin' ),
            'selector' => '.sidebar-widgets',
            'img' => get_template_directory_uri().'/img/typehub/sidebar_widget_text.jpg',
            'options' => array(
                'color'         => '#606060',
                'font-size'     => '13px',
                'line-height'   => '24px',
                'font-family'   => 'google:Raleway',
                'font-variant'   => '400',
                'text-transform' => 'none',
                'letter-spacing' => '0px'
            )
        ),

        'slidebar_widget_title' => array(
            'label' => __( 'Slidebar Widget Title', 'oshin' ),
            'selector' => '.sb-slidebar .widget h6',
            'img' => get_template_directory_uri().'/img/typehub/slidebar_widget_title.jpg',
            'options' => array(
                'color'         => '#ffffff',
                'font-size'     => '12px',
                'line-height'   => '22px',
                'font-family'   => 'google:Montserrat',
                'font-variant'   => '400',
                'text-transform' => 'none',
                'letter-spacing' => '1px'
            )
        ),
        'slidebar_widget_text' => array(
            'label' => __( 'Slidebar Widget Text', 'oshin' ),
            'selector' => '.sb-slidebar .widget',
            'img' => get_template_directory_uri().'/img/typehub/slidebar_widget_text.jpg',
            'options' => array(
                'color'         => '#a2a2a2',
                'font-size'     => '13px',
                'line-height'   => '25px',
                'font-family'   => 'google:Raleway',
                'font-variant'   => '400',
                'text-transform' => 'none',
                'letter-spacing' => '0px'
            )
        ),
       'bottom_widget_title' => array(
            'label' => __( 'Footer Widget Title', 'oshin' ),
            'selector' => '#bottom-widgets h6',
            'img' => get_template_directory_uri().'/img/typehub/bottom_widget_title.jpg',
            'options' => array(
                'color'         => '#474747',
                'font-size'     => '12px',
                'line-height'   => '22px',
                'font-family'   => 'google:Montserrat',
                'font-variant'   => '400',
                'text-transform' => 'uppercase',
                'letter-spacing' => '1px'
            )
        ),
        'bottom_widget_text' => array(
            'label' => __( 'Footer Widget Text', 'oshin' ),
            'selector' => '#bottom-widgets',
            'img' => get_template_directory_uri().'/img/typehub/bottom_widget_text.jpg',
            'options' => array(
                'color'         => '#757575',
                'font-size'     => '13px',
                'line-height'   => '24px',
                'font-family'   => 'google:Raleway',
                'font-variant'   => '400',
                'text-transform' => 'none',
                'letter-spacing' => '0px'
            )
        ),
    );
    $form = array(
        'contact_form_typo' => array(
            'label' => __( 'Contact Form Typography', 'oshin' ),
            'selector' => '.contact_form_module input[type="text"], .contact_form_module textarea',
            'img' => get_template_directory_uri().'/img/typehub/contact_form_typo.jpg',
            'options' => array(
                'color'         => '#222222',
                'font-size'     => '13px',
                'line-height'   => '26px',
                'font-family'   => 'google:Montserrat',
                'font-variant'   => '400',
                'text-transform' => 'none',
                'letter-spacing' => '0px'
            )
        ),
    );

    return array(
        'Headings' => $headings,
        'Content' => $content,
        'Navigation' => $navigation,
        'Page Builder Modules' => $pagebuilder_options,
        'Portfolio' => $portfolio,
        'Shop' => $shop,
        'Blog' => $blog,
        'Widgets' => $widgets,
        'Form' => $form,
    );
?>