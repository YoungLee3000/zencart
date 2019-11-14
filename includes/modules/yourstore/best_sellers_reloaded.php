<?php
/**
 * Best Sellers Reloaded v1.1
 *
 * best_sellers_reloaded module - prepares content for display
 *
 * @package modules
 * @author Alex Clarke (aclarke@ansellandclarke.co.uk)
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: best_sellers_reloaded.php 2007-07-22 aclarke $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

$zc_show_best_sellers = (((int)SHOW_PRODUCT_INFO_MAIN_BEST_SELLERS) > 0);
if ($zc_show_best_sellers) {
	$max_display_best_sellers = (((int)MAX_DISPLAY_SEARCH_RESULTS_BEST_SELLERS) <= 0) ? 9 : (int)MAX_DISPLAY_SEARCH_RESULTS_BEST_SELLERS;
  
	$from_clause = " FROM "  . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd";
	$where_clause = " WHERE p.products_status = '1' AND p.products_ordered > 0 AND p.products_id = pd.products_id AND pd.language_id = " . (int)$_SESSION['languages_id'];
	$limit_clause = ($max_display_best_sellers <= 0) ? '' : " LIMIT $max_display_best_sellers";
  
	if (BEST_SELLERS_RELOADED_SHOW_OUT_OF_STOCK == 'false') {
		$where_clause .= ' AND p.products_quantity > 0';
	}
	
	if (isset ($current_category_id) && $current_category_id > 0) {
		$from_clause .= ", " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c";
		$where_clause .= " AND p.products_id = p2c.products_id AND p2c.categories_id = c.categories_id AND " . (int)$current_category_id . " IN (c.categories_id, c.parent_id)";
	}
	
	$best_sellers_reloaded_query = "SELECT DISTINCT p.products_id, pd.products_name, p.products_image, p.products_quantity, p.product_is_call, p.products_date_available, p.products_date_added, p.products_ordered$from_clause$where_clause ORDER BY p.products_ordered desc, pd.products_name$limit_clause";
	$best_sellers_reloaded = $db->Execute ($best_sellers_reloaded_query);
	
	$row = 0;
    $col = 0;
    $list_box_contents = array();
    $title = '';
	
	$num_products_count = $best_sellers_reloaded->RecordCount();
	if ($num_products_count > 0) {
		$best_sellers_columns = (int)SHOW_PRODUCT_INFO_COLUMNS_BEST_SELLERS;
		if ($num_products_count < $best_sellers_columns || $best_sellers_columns == 0) {
			$col_width = floor (100 / $num_products_count);
		} else {
			$col_width = floor (100 / $best_sellers_columns);
		}

		while (!$best_sellers_reloaded->EOF) {
			
			//set cPath
			$cPath = (($_GET['manufacturers_id'] > 0 and $_GET['filter_id']) > 0 ?  zen_get_generated_category_path_rev($_GET['filter_id']) : ($_GET['cPath'] > 0 ? zen_get_generated_category_path_rev($_GET['cPath']) : zen_get_generated_category_path_rev($best_sellers_reloaded->fields['master_categories_id'])));
			$best_sellers_reloaded->fields['cPath'] = $cPath;
					
			//set Infopagelink
			$zen_get_info_page = zen_get_info_page($best_sellers_reloaded->fields['products_id']);
			$best_sellers_reloaded->fields['zen_get_info_page'] = $zen_get_info_page;
			
			$products_price = zen_get_products_display_price ($best_sellers_reloaded->fields['products_id']);
			  
			$products_name = $best_sellers_reloaded->fields['products_name'];
				
			$product_content = pzen_get_product_content($best_sellers_reloaded, array("image_width"=>IMAGE_BEST_SELLERS_LISTING_WIDTH, "image_height"=>IMAGE_BEST_SELLERS_LISTING_HEIGHT));		
			
			$list_box_contents[$row][$col] = array ('params' =>'class="back centerBoxContentsBestSellers '.$pzen_bestsellerprod_index_class.'"' . ' ', 'text' => (($best_sellers_reloaded->fields['products_image'] == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == 0) ? '' : '
				<div class="product '.$product_content['products_class'].'">
					<div class="product__inside">
						<div class="product__inside__image">
							'.$product_content['products_image'].'
							'.$product_content['hover_label_prod'].'
							'.$product_content['hover_label'].'
						</div>
						<div class="product__inside__name">
							<h2 class="product_title"><a href="' . zen_href_link($zen_get_info_page, 'cPath=' . $cPath . '&products_id=' . $best_sellers_reloaded->fields['products_id'], 'SSL') . '">' . $products_name . '</a>
							</h2>
						</div>
						'.(($product_content['products_new']==1)? '<div class="product__label product__label--right product__label--new"> <span>'.PZEN_BADGE_NEW.'</span></div>' : '').'
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

				$col++;
			if ($col > ($best_sellers_columns - 1)) {
				$col = 0;
				$row++;
			}
			$best_sellers_reloaded->MoveNext ();
		}
		if($bproducts_display_style=='slider') {
			$btitle_with_button = "<div class='carousel-products__button pull-right'> <span class='btn-prev'></span> <span class='btn-next'></span> </div>";
		}
		if ($num_products_count) {
			if (isset ($new_products_category_id) && $new_products_category_id != 0) {
				$category_title = zen_get_categories_name ((int)$new_products_category_id);
				$title = '<div class="'.$parent_btitle_class.'">'.$btitle_with_button.'
						<h2 class="'.$parent_btitle_h2_class.'">' . TABLE_HEADING_BEST_SELLERS . ($category_title != '' ? ' - ' . $category_title : '') . '</h2></div>';
        
			} else {
				$title = '<div class="'.$parent_btitle_class.'">'.$btitle_with_button.'
						<h2 class="'.$parent_btitle_h2_class.'">' . TABLE_HEADING_BEST_SELLERS . '</h2></div>';
			}
			$zc_show_best_sellers = true;
		}
	}
}