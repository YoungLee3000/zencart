<?php
/**
 * featured_products module - prepares content for display
 *
 * @package modules
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: featured_products.php 6424 2007-05-31 05:59:21Z ajeh $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

// initialize vars
$categories_products_id_list = array();
$list_of_products = '';
$featured_products_query = '';
$display_limit = '';

if ( (($manufacturers_id > 0 && $_GET['filter_id'] == 0) || $_GET['music_genre_id'] > 0 || $_GET['record_company_id'] > 0) || (!isset($new_products_category_id) || $new_products_category_id == '0') ) {
  $featured_products_query = "select distinct p.products_id, p.products_image, pd.products_name, p.master_categories_id, p.products_quantity, p.product_is_call, p.products_date_available, p.products_date_added
                           from (" . TABLE_PRODUCTS . " p
                           left join " . TABLE_FEATURED . " f on p.products_id = f.products_id
                           left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id )
                           where p.products_id = f.products_id
                           and p.products_id = pd.products_id
                           and p.products_status = 1 and f.status = 1
                           and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'";
						   
		 $last_featured_products_query = "select max(p.products_date_added),p.products_id, p.products_image, pd.products_name, p.master_categories_id, p.products_quantity, p.product_is_call, p.products_date_available, p.products_date_added
                           from (" . TABLE_PRODUCTS . " p
                           left join " . TABLE_FEATURED . " f on p.products_id = f.products_id
                           left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id )
                           where p.products_id = f.products_id
                           and p.products_id = pd.products_id
                           and p.products_status = 1 and f.status = 1
                           and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'";
						   
						   
} else {
  // get all products and cPaths in this subcat tree
  $productsInCategory = zen_get_categories_products_list( (($manufacturers_id > 0 && $_GET['filter_id'] > 0) ? zen_get_generated_category_path_rev($_GET['filter_id']) : $cPath), false, true, 0, $display_limit);
  
   
  if (is_array($productsInCategory) && sizeof($productsInCategory) > 0) {
    // build products-list string to insert into SQL query
    foreach($productsInCategory as $key => $value) {
      $list_of_products .= $key . ', ';
    }
    $list_of_products = substr($list_of_products, 0, -2); // remove trailing comma

    $featured_products_query = "select distinct p.products_id, p.products_image, pd.products_name, p.master_categories_id, p.products_quantity, p.product_is_call, p.products_date_available, p.products_date_added
                                from (" . TABLE_PRODUCTS . " p
                                left join " . TABLE_FEATURED . " f on p.products_id = f.products_id
                                left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id)
                                where p.products_id = f.products_id
                                and p.products_id = pd.products_id
                                and p.products_status = 1 and f.status = 1
                                and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                                and p.products_id in (" . $list_of_products . ")";
			
	
	
	 $last_featured_products_query = "select max(p.products_date_added),p.products_id, p.products_image, pd.products_name, p.master_categories_id, p.products_quantity, p.product_is_call, p.products_date_available, p.products_date_added
                                from (" . TABLE_PRODUCTS . " p
                                left join " . TABLE_FEATURED . " f on p.products_id = f.products_id
                                left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id)
                                where p.products_id = f.products_id
                                and p.products_id = pd.products_id
                                and p.products_status = 1 and f.status = 1
                                and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                                and p.products_id in (" . $list_of_products . ")";
							
								
								
  }
}
		

if ($featured_products_query != '') $featured_products = $db->ExecuteRandomMulti($featured_products_query, MAX_DISPLAY_SEARCH_RESULTS_FEATURED);
if ($last_featured_products_query != '') $last_featured_products = $db->ExecuteRandomMulti($last_featured_products_query, MAX_DISPLAY_SEARCH_RESULTS_FEATURED);
  
$row = 0;
$col = 0;
$list_box_contents = array();
$title = '';

 
$num_products_count = ($featured_products_query == '') ? 0 : $featured_products->RecordCount();
// show only when 1 or more
if ($num_products_count > 0) {
  if ($num_products_count < SHOW_PRODUCT_INFO_COLUMNS_FEATURED_PRODUCTS || SHOW_PRODUCT_INFO_COLUMNS_FEATURED_PRODUCTS == 0) {
    $col_width = floor(100/$num_products_count);
  } else {
    $col_width = floor(100/SHOW_PRODUCT_INFO_COLUMNS_FEATURED_PRODUCTS);
  }
 
 
  while (!$featured_products->EOF) {
	//set cPath
	
	if (!isset($productsInCategory[$featured_products->fields['products_id']])) $productsInCategory[$featured_products->fields['products_id']] = zen_get_generated_category_path_rev($featured_products->fields['master_categories_id']);
	
	$cPath = $productsInCategory[$featured_products->fields['products_id']];
	$featured_products->fields['cPath'] = $cPath;
			
	//set Infopagelink
	$zen_get_info_page = zen_get_info_page($featured_products->fields['products_id']);
	$featured_products->fields['zen_get_info_page'] = $zen_get_info_page;
	  
    $products_price = zen_get_products_display_price($featured_products->fields['products_id']);
	
	$products_name = $featured_products->fields['products_name'];
	
	$product_content = pzen_get_product_content($featured_products, array("image_width"=>IMAGE_FEATURED_PRODUCTS_LISTING_WIDTH, "image_height"=>IMAGE_FEATURED_PRODUCTS_LISTING_HEIGHT));	

    $list_box_contents[$row][$col] = array('params' =>'class="back centerBoxContentsFeatured '.$pzen_featuredprod_index_class.' "', 'text' => (($featured_products->fields['products_image'] == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == 0) ? '' : '
	<div class="product '.$product_content['products_class'].'">
		<div class="product__inside">
			<div class="product__inside__image">
				'.$product_content['products_image'].'
				'.$product_content['hover_label_prod'].'
				'.$product_content['hover_label'].'
			</div>
			'.(($product_content['products_new']==1)? '<div class="product__label product__label--right product__label--new"> <span>'.PZEN_BADGE_NEW.'</span></div>' : '').'
			<div class="product__inside__name">
				<h2 class="product_title"><a href="' . zen_href_link($zen_get_info_page, 'cPath=' . $cPath . '&products_id=' . $featured_products->fields['products_id'], 'SSL') . '">' . $products_name . '</a>
				</h2>
			</div>
			<div class="product__inside__price price-box">'
				. $products_price .
			'</div>
			<div class="product__inside__review row-mode-visible">
				<div class="rating row-mode-visible">
					'.$product_content['products_review'].'
				</div>
			</div>
			<div class="product__inside__hover">
				<div class="product__inside__info">
					<div class="product__inside__info__btns">
						'.$product_content['buy_now'].$product_content['wishlist_link_alt'].$product_content['compare_link_alt'].'
					</div>
					<ul class="product__inside__info__link hidden-xs">
						<li class="text-right">'.$product_content['wishlist_link'].'</li>
						<li class="text-left">'.$product_content['compare_link'].'</li>
					</ul>
				</div>
				<div class="rating row-mode-hide">
					'.$product_content['products_review'].'
				</div>
			</div>') .  
		'</div>
	 </div>' );

    $col ++;
    if ($col > (SHOW_PRODUCT_INFO_COLUMNS_FEATURED_PRODUCTS - 1)) {
      $col = 0;
      $row ++;
    }
    $featured_products->MoveNextRandom();
  }
	if($fproducts_display_style=='slider') {
		$ftitle_with_button = "<div class='carousel-products__button pull-right'> <span class='btn-prev'></span> <span class='btn-next'></span> </div>";
	}
	//else {
	//	$title_with_button = "";
	//}

  if ($featured_products->RecordCount() > 0) {
    if (isset($new_products_category_id) && $new_products_category_id !=0) {
      $category_title = zen_get_categories_name((int)$new_products_category_id);
      $title = '<div class="'.$parent_ftitle_class.'">'.$ftitle_with_button.'
					<h2 class="'.$parent_ftitle_h2_class.'">'. TABLE_HEADING_FEATURED_PRODUCTS . /*($category_title != '' ? ' - ' . $category_title : '') .'<a title="View All" href="' . zen_href_link(FILENAME_FEATURED_PRODUCTS) . '">View All<i class="fa fa-angle-double-right"></i></a>*/'</h2></div>';
    } else {
      $title = '<div class="'.$parent_ftitle_class.'">'.$ftitle_with_button.'
					<h2 class="'.$parent_ftitle_h2_class.'">' . TABLE_HEADING_FEATURED_PRODUCTS . /*'<a title="View All" href="' . zen_href_link(FILENAME_FEATURED_PRODUCTS) . '">View All<i class="fa fa-angle-double-right"></i></a>*/'</h2></div>';
    }
    $zc_show_featured = true;
  }
}
?>