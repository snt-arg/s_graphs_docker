<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2019 ThemePunch
 */
 
if(!defined('ABSPATH')) exit();

class RevSliderWooCommerce extends RevSliderFunctions {
	
	const META_SKU	 = '_sku'; //can be 'instock' or 'outofstock'
	const META_STOCK = '_stock'; //can be 'instock' or 'outofstock'
	
	/**
	 * return true / false if the woo commerce exists
	 * @before RevSliderWooCommerce::isWooCommerceExists();
	 */
	public static function woo_exists(){
		return (class_exists('Woocommerce')) ? true : false;
	}
	
	
	/**
	 * compare wc current version to given version
	 */
	public static function version_check($version = '1.0') {
		if(self::woo_exists()){
			global $woocommerce;
			if(version_compare($woocommerce->version, $version, '>=')){
				return true;
			}
		}
		return false;
	}
	
	
	/**
	 * get wc post types
	 */
	public static function getCustomPostTypes(){
		$arr = array(
			'product'			=> __('Product', 'revslider'),
			'product_variation'	=> __('Product Variation', 'revslider')
		);
		
		return $arr;
	}
	
	
	/**
	 * get price query
	 * @before: RevSliderWooCommerce::getPriceQuery()
	 */
	private static function get_price_query($from, $to, $meta_tag){
		$from	= (empty($from)) ? 0 : $from;
		$to		= (empty($to)) ? 9999999999 : $to;
		$query	= array(
			'key'		=> $meta_tag,
			'value'		=> array($from, $to),
			'type'		=> 'numeric',
			'compare'	=> 'BETWEEN'
		);
		
		return $query;
	}
	
	
	/**
	 * check if in pricerange
	 */
	private static function check_price_range($from, $to, $check){
		$from	= (empty($from)) ? 0 : $from;
		$to		= (empty($to)) ? 9999999999 : $to;
		
		return ($check > $from && $check < $to) ? true : false;
	}
	
	
	/**
	 * get meta query for filtering woocommerce posts.
	 * before: RevSliderWooCommerce::getMetaQuery();
	 * @6.5.23: removed _regular_price and _sale_price here, will be later checked under filter_products_by_price() to add the children
	 */
	public static function get_meta_query($args){
		$f			= RevSliderGlobals::instance()->get('RevSliderFunctions');
		$query		= array();
		$meta_query	= array();
		$tax_query	= array();
		
		if($f->get_val($args, array('source', 'woo', 'inStockOnly')) == true){
			$meta_query[] = array(
				'key' => '_stock_status',
				'value' => 'instock',
				'compare' => '='
			);
		}
		
		if($f->get_val($args, array('source', 'woo', 'featuredOnly')) == true){
			$tax_query[] = array(
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => 'featured',
			);
		}

		$tax_query['relation'] = 'AND';
		$tax_query[] = array(
			'taxonomy' => 'product_visibility',
			'field'    => 'name',
			'terms'    => 'exclude-from-catalog',
			'operator' => 'NOT IN',
		);
		
		if(!empty($meta_query))	$query['meta_query'] = $meta_query;
		if(!empty($tax_query))	$query['tax_query'] = $tax_query;
		
		return $query;
	}


	/**
	 * filter posts by sales prices, also check for child products
	 * @since: 6.5.23
	 */
	public static function filter_products_by_price($posts, $args){
		if(empty($posts)) return $posts;

		$f					= RevSliderGlobals::instance()->get('RevSliderFunctions');
		$is_30				= RevSliderWooCommerce::version_check('3.0');
		$reg_price_from		= $f->get_val($args, array('source', 'woo', 'regPriceFrom'));
		$reg_price_to		= $f->get_val($args, array('source', 'woo', 'regPriceTo'));
		$sale_price_from	= $f->get_val($args, array('source', 'woo', 'salePriceFrom'));
		$sale_price_to		= $f->get_val($args, array('source', 'woo', 'salePriceTo'));
		$post_types			= $f->get_val($args, array('source', 'woo', 'types'), 'any');

		$meta_query = array();
		//get regular price array
		if(!empty($reg_price_from) || !empty($reg_price_to)){
			$meta_query[] = self::get_price_query($reg_price_from, $reg_price_to, '_regular_price');
		}
		
		//get sale price array
		if(!empty($sale_price_from) || !empty($sale_price_to)){
			$meta_query[] = self::get_price_query($sale_price_from, $sale_price_to, '_sale_price');
		}

		$_good_posts = array();
		foreach($posts as $key => $post){
			$product_id = $f->get_val($post, 'ID'); // ID of parent product
			$product    = ($is_30) ? wc_get_product($product_id) : get_product($product_id);

			if($product === false){
				$_good_posts[] = $post;
				unset($posts[$key]);
				continue;
			}
			
			//check if current post is okay with _regular_price and _sale_price
			if(!empty($reg_price_from) || !empty($reg_price_to) || !empty($sale_price_from) || !empty($sale_price_to)){
				$meta			= get_post_meta($product_id);
				$in_reg_range	= false;
				$in_sale_range	= false;
				if(!empty($reg_price_from) || !empty($reg_price_to)){
					$in_reg_range	= self::check_price_range($reg_price_from, $reg_price_to, $f->get_val($meta, '_regular_price'));
				}
				if(!empty($sale_price_from) || !empty($sale_price_to)){
					$in_sale_range	= self::check_price_range($sale_price_from, $sale_price_to, $f->get_val($meta, '_sale_price'));
				}

				if($in_reg_range || $in_sale_range){
					$_good_posts[] = $post;
					continue;
				}else{
					unset($posts[$key]);
				}
			}
			
			if(!empty($meta_query)){
				$my_posts	= new WP_Query(
					array(
						'post_parent'	=> $product_id, // ID of a page, post, or custom type
						'post_type'		=> $post_types,
						'meta_query'	=> $meta_query
					)
				);
				$_posts		= $my_posts->posts;
				if(!empty($_posts)){
					foreach($_posts as $child_post){
						$_good_posts[] = $child_post;
					}
				}
			}else{
				$_good_posts[] = $post;
			}
		}

		return $_good_posts;
	}
	
	
	/**
	 * get sortby function including standart wp sortby array
	 */
	public static function getArrSortBy(){
		
		$sort_by = array(
			'meta_num__regular_price'	=> __('Regular Price', 'revslider'),
			'meta_num__sale_price'		=> __('Sale Price', 'revslider'),
			'meta_num_total_sales'		=> __('Number Of Sales', 'revslider'),
			//'meta__featured'			=> __('Featured Products', 'revslider'),
			'meta__sku'					=> __('SKU', 'revslider'),
			'meta_num_stock'			=> __('Stock Quantity', 'revslider')
		);
		
		return $sort_by;
	}
	
}	//end of the class