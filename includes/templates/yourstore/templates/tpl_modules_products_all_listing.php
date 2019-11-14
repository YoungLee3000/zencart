<?php
/**
 * Module Template
 *
 * Loaded automatically by index.php?main_page=products_all.<br />
 * Displays listing of All Products
 *
 * @package templateSystem
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_products_all_listing.php 6096 2007-04-01 00:43:21Z ajeh $
 */
$grid_list_class='';
if(!$flag_is_grid) { $grid_list_class = "row-view"; }
?>
<div id="productListing" class="product-listing carousel-products-mobile row <?php echo $grid_list_class; ?>">
	<div id="product-area" <?php echo $allprodpage_container_data; ?>>
<?php if($products_grid_layouts!='grid' && $flag_is_grid==false){ ?>
	<div class="row">
<?php } ?>
<?php

  //$group_id = zen_get_configuration_key_value('PRODUCT_ALL_LIST_GROUP_ID');

if($products_all_split->number_of_rows > 0) {
  
	$products_all = $db->Execute($products_all_split->sql_query);
	while (!$products_all->EOF) {

		$products_name = $products_all->fields['products_name'];
		
		//set cPath
		$cPath = zen_get_generated_category_path_rev($products_all->fields['master_categories_id']);
		$products_all->fields['cPath'] = $cPath;
		
		//set Infopagelink
		$zen_get_info_page = zen_get_info_page($products_all->fields['products_id']);
		$products_all->fields['zen_get_info_page'] = $zen_get_info_page;
	
	
		$moreinfo = '<a class="more_info_text" href="' . zen_href_link($zen_get_info_page, 'cPath=' . $cPath . '&products_id=' . $products_all->fields['products_id'], 'SSL') . '">'.MORE_INFO_TEXT.'</a>';

		$display_products_image = '';
		if (PRODUCT_ALL_LIST_IMAGE != '0') {
				if ($products_all->fields['products_image'] == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == 0) {
					$display_products_image = str_repeat('', substr(PRODUCT_ALL_LIST_IMAGE, 3, 1));
				} else {
					$display_products_image = zen_image(DIR_WS_IMAGES . $products_all->fields['products_image'], $products_name, IMAGE_PRODUCT_ALL_LISTING_WIDTH, IMAGE_PRODUCT_ALL_LISTING_HEIGHT) . str_repeat('', substr(PRODUCT_ALL_LIST_IMAGE, 3, 1));
				}
		}
		
		$display_products_name = '';
		if (PRODUCT_ALL_LIST_NAME != '0') {
			$display_products_name = '<a href="' . zen_href_link($zen_get_info_page, 'cPath=' . $cPath . '&products_id=' . $products_all->fields['products_id'], 'SSL') . '">' . $products_name . '</a>' . str_repeat('', substr(PRODUCT_ALL_LIST_NAME, 3, 1));
		}
		
		$display_products_weight = '';
		if (PRODUCT_ALL_LIST_WEIGHT != '0' and zen_get_show_product_switch($products_all->fields['products_id'], 'weight')) {
			$display_products_weight = TEXT_PRODUCTS_WEIGHT . $products_all->fields['products_weight'] . TEXT_SHIPPING_WEIGHT . str_repeat('', substr(PRODUCT_ALL_LIST_WEIGHT, 3, 1));
		}

		$display_products_quantity = '';
		if (PRODUCT_ALL_LIST_QUANTITY != '0' and zen_get_show_product_switch($products_all->fields['products_id'], 'quantity')) {
			if ($products_all->fields['products_quantity'] <= 0) {
				$display_products_quantity = TEXT_OUT_OF_STOCK . str_repeat('', substr(PRODUCT_ALL_LIST_QUANTITY, 3, 1));
			} else {
				$display_products_quantity = TEXT_PRODUCTS_QUANTITY . $products_all->fields['products_quantity'] . str_repeat('', substr(PRODUCT_ALL_LIST_QUANTITY, 3, 1));
			}
		}

		$display_products_date_added = '';
		if (PRODUCT_ALL_LIST_DATE_ADDED != '0' and zen_get_show_product_switch($products_all->fields['products_id'], 'date_added')) {
			$display_products_date_added = sprintf(TEXT_DATE_ADDED, zen_date_long($products_all->fields['products_date_added'])) . str_repeat('', substr(PRODUCT_ALL_LIST_DATE_ADDED, 3, 1));
		}
		
		$display_products_manufacturers_name = '';
		if (PRODUCT_ALL_LIST_MANUFACTURER != '0' and zen_get_show_product_switch($products_all->fields['products_id'], 'manufacturer')) {
			$display_products_manufacturers_name = ($products_all->fields['manufacturers_name'] != '' ? TEXT_MANUFACTURER . ' ' . $products_all->fields['manufacturers_name'] . str_repeat('', substr(PRODUCT_ALL_LIST_MANUFACTURER, 3, 1)) : '');
		}

		$display_products_price = '';
		if ((PRODUCT_ALL_LIST_PRICE != '0' and zen_get_products_allow_add_to_cart($products_all->fields['products_id']) == 'Y') and zen_check_show_prices() == true) {
			$products_price = zen_get_products_display_price($products_all->fields['products_id']);
			$display_products_price = $products_price . str_repeat('', substr(PRODUCT_ALL_LIST_PRICE, 3, 1)) . (zen_get_show_product_switch($products_all->fields['products_id'], 'ALWAYS_FREE_SHIPPING_IMAGE_SWITCH') ? (zen_get_product_is_always_free_shipping($products_all->fields['products_id']) ? TEXT_PRODUCT_FREE_SHIPPING_ICON : '') : '');
		}
		$display_products_button='';
		// more info in place of buy now
		if (PRODUCT_ALL_BUY_NOW != '0' and zen_get_products_allow_add_to_cart($products_all->fields['products_id']) == 'Y') {
			if (zen_has_product_attributes($products_all->fields['products_id'])) {
				$link = '<a class="list-more btn btn--ys btn--xl" href="' . zen_href_link($zen_get_info_page, 'cPath=' . $cPath . '&products_id=' . $products_all->fields['products_id']) . '" '.pzenExtraBtnLink($products_all).'><span class="icon icon-shopping_basket"></span>' . TITLE_SELECT_OPTIONS . '</a>';
			} else {
				if (PRODUCT_ALL_LISTING_MULTIPLE_ADD_TO_CART > 0 && $products_all->fields['products_qty_box_status'] != 0) {
				//            $how_many++;
					$link = '<div class="prod-qty-bx"><div class="inner-qty-box"><span class="qty-lbl">'.TEXT_PRODUCT_ALL_LISTING_MULTIPLE_ADD_TO_CART . "</span><span class='qty_txt'><input type=\"text\" name=\"products_id[" . $products_all->fields['products_id'] . "]\" value=\"0\" size=\"4\" /></span>".'</div></div>';
				} else {
					$link = '<a class="btn btn--ys btn--xl" href="' . zen_href_link(FILENAME_PRODUCTS_ALL, zen_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $products_all->fields['products_id']) . '" '.pzenExtraBtnLink($products_all).' '.pzenExtraBtnLink($products_all).'><span class="icon icon-shopping_basket"></span>' . zen_image_button(BUTTON_IMAGE_BUY_NOW, BUTTON_BUY_NOW_ALT) . '</a>&nbsp;';
				}
			}
			$the_button = $link;
			if($products_all->fields['product_is_call'] != '1'){
				$products_link = '<a href="' . zen_href_link($zen_get_info_page, 'cPath=' . $cPath . '&products_id=' . $products_all->fields['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
			}
			//if not out of stock
			if($products_all->fields['products_quantity'] > 0 || SHOW_PRODUCTS_SOLD_OUT_IMAGE == 0){
				if((zen_get_products_allow_add_to_cart($products_all->fields['products_id']) != 'N') && $products_all->fields['product_is_call'] == '1'){
					$display_products_button ='<a class="btn btn--ys btn--xl btn-callforprice" href="' . zen_href_link(FILENAME_CONTACT_US, '', 'SSL') . '"><span class="icon icon-call"></span>' . TEXT_CALL_FOR_PRICE . '</a>';
				}else{
					$minmaxqty=zen_get_products_quantity_min_units_display($products_all->fields['products_id']);
					$display_products_button =  zen_get_buy_now_button($products_all->fields['products_id'], $the_button, $products_link) .(($minmaxqty)? '<span class="min-max-qty">'.$minmaxqty.'</span>' : ''). str_repeat('<br />', substr(PRODUCT_ALL_BUY_NOW, 3, 1));;
				}
			}
		
		  } else {
				$link = '<a class="list-more btn btn--ys btn--xl" href="' . zen_href_link($zen_get_info_page, 'cPath=' . $cPath . '&products_id=' . $products_all->fields['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
				$the_button = $link;
				$products_link = '<a class="list-more btn btn--ys btn--xl" href="' . zen_href_link($zen_get_info_page, 'cPath=' . $cPath . '&products_id=' . $products_all->fields['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
			
				if($products_all->fields['products_quantity'] > 0 || SHOW_PRODUCTS_SOLD_OUT_IMAGE == 0){
					if((zen_get_products_allow_add_to_cart($products_all->fields['products_id']) != 'N') && $products_all->fields['product_is_call'] == '1'){
						$display_products_button ='<a class="btn btn--ys btn--xl btn-callforprice" href="' . zen_href_link(FILENAME_CONTACT_US, '', 'SSL') . '"><span class="icon icon-call"></span>' . TEXT_CALL_FOR_PRICE . '</a>';
					}else{
						$minmaxqty=zen_get_products_quantity_min_units_display($products_all->fields['products_id']);
						$display_products_button =  zen_get_buy_now_button($products_all->fields['products_id'], $the_button, $products_link) .(($minmaxqty)? '<span class="min-max-qty">'.$minmaxqty.'</span>' : ''). str_repeat('<br />', substr(PRODUCT_ALL_BUY_NOW, 3, 1));;
					}
				}
			}
			
			$display_products_description = '';
			if (PRODUCT_ALL_LIST_DESCRIPTION > '0') {

				$disp_text = zen_get_products_description($products_all->fields['products_id']);
				$disp_text = zen_clean_html($disp_text);

				$display_products_description = stripslashes(zen_trunc_string($disp_text, PRODUCT_ALL_LIST_DESCRIPTION, '<a href="' . zen_href_link($zen_get_info_page, 'cPath=' . $cPath . '&products_id=' . $products_all->fields['products_id']) . '"> ' . MORE_INFO_TEXT . '</a>'));
			}
 
		$product_content = pzen_get_product_content($products_all, array("image_width"=>IMAGE_PRODUCT_ALL_LISTING_WIDTH, "image_height"=>IMAGE_PRODUCT_ALL_LISTING_HEIGHT));	
		
		?>
		<div class="<?php echo $allprodpage_item_class; ?>">
			<div data-filter="all products" data-name="<?php echo $products_name; ?>" class="product <?php echo ($prodlist_image_effects==2)? 'product--zoom' : ''; ?> <?php echo ($prodlistview_image_layout==2)? 'small-size' : ''; ?> <?php echo $product_content['products_class']; ?>">
				<!-- Product Grid View -->
				<div class="product__inside">
					<div class="product__inside__image">
						<?php echo $product_content['products_image'].$product_content['hover_label_prod'].(($_GET['view']!='rows') ? $product_content['hover_label'] : ''); ?>
					</div>
					<?php echo (($product_content['products_new']==1)? '<div class="product__label product__label--right product__label--new"> <span>'.PZEN_BADGE_NEW.'</span></div>' : ''); ?>
					<div class="product__inside__content">
						<div class="product__inside__name">
							<h2>
								<?php echo $display_products_name; ?>
							</h2>
						</div>
						<div class="product__inside__description row-mode-visible">
							<?php echo $display_products_description.$moreinfo; ?>
						</div>
						<div class="product__inside__price price-box">
							<?php echo $display_products_price; ?>
						</div>
						<div class="product__inside__review row-mode-visible">
							<?php echo $product_content['products_review'];?>
						</div>
						<div class="product-info__description product__inside__info hidden-xs row-mode-visible">
							<div class="product-info__sku">
								<?php echo $display_products_weight; ?>
							</div>
							<div class="product-info__sku">
								<?php echo $display_products_quantity; ?>
							</div>
							<div class="product-info__sku">
								<?php echo $display_products_date_added; ?>
							</div>
							<div class="product-info__sku">
								<?php echo $display_products_manufacturers_name; ?>
							</div>
						</div>
						<div class="product__inside__hover">
							<div class="product__inside__info">
								<div class="product__inside__info__btns">
									<?php echo $display_products_button .$product_content['wishlist_link_alt'].$product_content['compare_link_alt']; ?>
									<?php echo (((isset($_GET['view'])) && ($_GET['view']=='rows')) ? $hover_label : ''); ?>
								</div>
								<ul class="product__inside__info__link hidden-sm">
									<li class="text-right"><?php echo $product_content['wishlist_link']; ?></li>
									<li class="text-left"><?php echo $product_content['compare_link']; ?></li>
								</ul>
							</div>
							<div class="rating row-mode-hide">
								<?php echo $product_content['products_review'];?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
		$products_all->MoveNext();
    }
} else { ?>
	<div class="col-xs-12"><div class="alert alert-info"><?php echo TEXT_NO_ALL_PRODUCTS; ?></div></div>
<?php  } ?>
</div>
</div>
</div>