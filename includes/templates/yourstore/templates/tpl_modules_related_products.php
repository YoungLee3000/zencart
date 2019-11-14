<?php
/**
* Finds related products based on on field
*					TABLE_PRODUCTS.products_family
* @date 2009-12-12
* @author: Joe McFrederick
* @license: GPL v2.0
* @package: Zencart
* @require: Field `products_family` VARCHAR(50) must be added to TABLE_PRODUCTS
*
*/

	$relatedProducts = $db->Execute("SELECT products_family FROM " . TABLE_PRODUCTS . " WHERE  products_id = '" . (int)$_GET['products_id'] ."'", 1);
	
	$products_family = '';
	if ($relatedProducts->RecordCount() > 0 AND !empty($relatedProducts->fields['products_family'])){
		$related_string = explode('|', $relatedProducts->fields['products_family']);

		foreach ($related_string as $family)
		{
			$products_family .= "OR p.products_family REGEXP '" . $family . "' ";
		}

		$products_family = " AND (" . substr($products_family, 2) . ") ";
		


		//Build query string to find related products
		$sql = "select p.products_id, pd.products_name, pd.products_description, p.products_model, p.products_quantity, p.products_image, pd.products_url, p.products_price, p.products_tax_class_id, p.products_date_added, p.products_date_available, p.manufacturers_id, p.products_quantity, p.products_weight, p.products_priced_by_attribute, p.product_is_free, p.products_qty_box_status, p.products_quantity_order_max, p.products_discount_type, p.products_discount_type_from, p.products_sort_order, p.products_price_sorter, p.products_quantity, p.product_is_call
			from   " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
			where  p.products_status = '1' " . $products_family . " and p.products_id != '" . (int)$_GET['products_id'] . "' and    pd.products_id = p.products_id and    pd.language_id = '" . (int)$_SESSION['languages_id'] . "' LIMIT 9";

		//Run Query and check for related products
		$relatedResult = $db->Execute($sql);
		$row = 0;
		$col = 0;
		$list_box_contents = array();
		$title = '';
		if($relatedResult->RecordCount() > 0){?>
			<div class="centerBoxWrapper" id="relatedProducts">
			<?php
				//Build infoBox
				$list_box_contents[0] = array('params' => 'class="productListing-heading"',
											  'align' => 'center',
											  'text' => 'Related Products');
				
					// show only when 1 or more and equal to or greater than minimum set in admin
					
					$col_width =  ($relatedResult->RecordCount() < SHOW_PRODUCT_INFO_COLUMNS_RELATED_PRODUCTS) ? floor(100/$relatedResult->RecordCount()) : floor(100/SHOW_PRODUCT_INFO_COLUMNS_RELATED_PRODUCTS);
					while (!$relatedResult->EOF){
						
						if (!isset($productsInCategory[$relatedResult->fields['products_id']])) $productsInCategory[$relatedResult->fields['products_id']] = zen_get_generated_category_path_rev($relatedResult->fields['master_categories_id']);
						
						$cPath = $productsInCategory[$relatedResult->fields['products_id']];
						$relatedResult->fields['cPath'] = $cPath;
								
						//set Infopagelink
						$zen_get_info_page = zen_get_info_page($relatedResult->fields['products_id']);
						$relatedResult->fields['zen_get_info_page'] = $zen_get_info_page;
						
					
						$products_price = zen_get_products_display_price($relatedResult->fields['products_id']);
	
						$products_name = $relatedResult->fields['products_name'];
				
						$product_content = pzen_get_product_content($relatedResult);

						$buy_now = zen_get_buy_now_button($relatedResult->fields['products_id'],'<a class="btn btn--ys btn--xl" href="' . zen_href_link(zen_get_info_page($relatedResult->fields['products_id']), 'cPath=' . $productsInCategory[$relatedResult->fields['products_id']] . '&products_id=' . $relatedResult->fields['products_id'], 'SSL') . '"><span class="icon icon-shopping_basket"></span>'.TITLE_VIEW_PRODUCT.'</a>');
						
						$list_box_contents[$row][$col] = array('params' => 'class="col-xl-one-six centerBoxContentsRelatedProduct col-xs-6 col-sm-4 col-md-3 col-lg-3"' . ' ', 'text' => (($relatedResult->fields['products_image'] == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == 0) ? '' : 
						'<div class="product '.$product_content['products_class'].'">
							<div class="product__inside">
								<div class="product__inside__image">
									'.$product_content['products_image'].'
									'.$product_content['hover_label_prod'].'
									'.$product_content['hover_label'].'
								</div>
								'.(($product_content['products_new']==1)? '<div class="product__label product__label--right product__label--new"> <span>'.PZEN_BADGE_NEW.'</span></div>' : '').'
								<div class="product__inside__name">
									<h2 class="product_title"><a href="' . zen_href_link($zen_get_info_page, 'cPath=' . $cPath . '&products_id=' . $relatedResult->fields['products_id'], 'SSL') . '">' . $products_name . '</a>
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

						if ($col > (SHOW_PRODUCT_INFO_COLUMNS_RELATED_PRODUCTS - 1)){
							$col = 0;
							$row ++;
						}

						$relatedResult->MoveNext();
					}
				
					//$title = '<h2 class="text-left text-uppercase title-under pull-left">'.BOX_HEADING_RELATED_PRODUCTS.'</h2>';	
					$title = '<div class="title-with-button">
								<div class="carousel-products__center pull-right"> <span class="btn-prev"></span> <span class="btn-next"></span> </div>
									<h2 class="text-left text-uppercase title-under pull-left">'
										. BOX_HEADING_RELATED_PRODUCTS .
									'</h2>
							</div>';				

				require($template->get_template_dir('tpl_columnar_display.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_columnar_display.php');
			?>
			</div>
		<?php
		}
	}
/* End of File */