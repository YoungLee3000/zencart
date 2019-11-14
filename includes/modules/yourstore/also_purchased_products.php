<?php
/**
 * also_purchased_products.php
 *
 * @package modules
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: also_purchased_products.php 5369 2006-12-23 10:55:52Z drbyte $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
if (isset($_GET['products_id']) && SHOW_PRODUCT_INFO_COLUMNS_ALSO_PURCHASED_PRODUCTS > 0 && MIN_DISPLAY_ALSO_PURCHASED > 0) {
	
	$sql_also_purchase_products="SELECT p.products_id, p.products_image, p.products_quantity, p.product_is_call, p.products_date_available, p.products_date_added, max(o.date_purchased) as date_purchased
                     FROM " . TABLE_ORDERS_PRODUCTS . " opa, " . TABLE_ORDERS_PRODUCTS . " opb, "
                            . TABLE_ORDERS . " o, " . TABLE_PRODUCTS . " p
                     WHERE opa.products_id = '%s'
                     AND opa.orders_id = opb.orders_id
                     AND opb.products_id != '%s'
                     AND opb.products_id = p.products_id
                     AND opb.orders_id = o.orders_id
                     AND p.products_status = 1
                     GROUP BY p.products_id, p.products_image
                     ORDER BY date_purchased desc, p.products_id
                     LIMIT 50";

  $also_purchased_products = $db->Execute(sprintf($sql_also_purchase_products, (int)$_GET['products_id'], (int)$_GET['products_id']));

  $num_products_ordered = $also_purchased_products->RecordCount();

  $row = 0;
  $col = 0;
  $list_box_contents = array();
  $title = '';

	// show only when 1 or more and equal to or greater than minimum set in admin
	if ($num_products_ordered >= MIN_DISPLAY_ALSO_PURCHASED && $num_products_ordered > 0) {
		if ($num_products_ordered < SHOW_PRODUCT_INFO_COLUMNS_ALSO_PURCHASED_PRODUCTS) {
			$col_width = floor(100/$num_products_ordered);
		}else {
			$col_width = floor(100/SHOW_PRODUCT_INFO_COLUMNS_ALSO_PURCHASED_PRODUCTS);
		}

		while (!$also_purchased_products->EOF) {
			
			//set cPath
			$cPath = (($_GET['manufacturers_id'] > 0 and $_GET['filter_id']) > 0 ?  zen_get_generated_category_path_rev($_GET['filter_id']) : ($_GET['cPath'] > 0 ? zen_get_generated_category_path_rev($_GET['cPath']) : zen_get_generated_category_path_rev($also_purchased_products->fields['master_categories_id'])));
			$also_purchased_products->fields['cPath'] = $cPath;
					
			//set Infopagelink
			$zen_get_info_page = zen_get_info_page($also_purchased_products->fields['products_id']);
			$also_purchased_products->fields['zen_get_info_page'] = $zen_get_info_page;
			
			$products_price = zen_get_products_display_price($also_purchased_products->fields['products_id']);
			
			$products_name = zen_get_products_name($also_purchased_products->fields['products_id']);
			
			$product_content = pzen_get_product_content($also_purchased_products);

			$buy_now = zen_get_buy_now_button($also_purchased_products->fields['products_id'],'<a class="btn btn--ys btn--xl" href="' . zen_href_link(zen_get_info_page($also_purchased_products->fields['products_id']), 'cPath=' . $productsInCategory[$also_purchased_products->fields['products_id']] . '&products_id=' . $also_purchased_products->fields['products_id'], 'SSL') . '"><span class="icon icon-shopping_basket"></span>'.TITLE_VIEW_PRODUCT.'</a>');
					
		  $list_box_contents[$row][$col] = array('params' => 'class="centerBoxContentsAlsoPurch col-xs-6 col-sm-4 col-md-3 col-lg-3 col-xl-one-six"', 'text' => (($also_purchased_products->fields['products_image'] == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == 0) ? '' : '
		<div class="product '.$product_content['products_class'].'">
			<div class="product__inside">
				<div class="product__inside__image">
					'.$product_content['products_image'].'
					'.$product_content['hover_label_prod'].'
					'.$product_content['hover_label'].'
				</div>
				'.(($product_content['products_new']==1)? '<div class="product__label product__label--right product__label--new"> <span>'.PZEN_BADGE_NEW.'</span></div>' : '').'
				<div class="product__inside__name">
					<h2 class="product_title"><a href="' . zen_href_link($zen_get_info_page, 'cPath=' . $cPath . '&products_id=' . $also_purchased_products->fields['products_id'], 'SSL') . '">' . $products_name . '</a>
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
							'.$buy_now.$product_content['wishlist_link_alt'].$product_content['compare_link_alt'].'
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
		 </div>');

			$col ++;
			if ($col > (SHOW_PRODUCT_INFO_COLUMNS_ALSO_PURCHASED_PRODUCTS - 1)) {
				$col = 0;
				$row ++;
			}
			$also_purchased_products->MoveNext();
		}
	}
	if ($also_purchased_products->RecordCount() > 0 && $also_purchased_products->RecordCount() >= MIN_DISPLAY_ALSO_PURCHASED) {
		$title = '<div class="title-with-button">
							<div class="carousel-products__center pull-right"> <span class="btn-prev"></span> <span class="btn-next"></span> </div>
								<h2 class="text-left text-uppercase title-under pull-left">'
									. TEXT_ALSO_PURCHASED_PRODUCTS .
								'</h2>
						</div>';
		$zc_show_also_purchased = true;
	}
}
?>