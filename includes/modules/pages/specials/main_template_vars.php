<?php
/**
 * Specials
 *
 * @package page
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: main_template_vars.php 18802 2011-05-25 20:23:34Z drbyte $
 */

if (MAX_DISPLAY_SPECIAL_PRODUCTS > 0 ) {
  $specials_query_raw = "SELECT p.products_id, p.products_image, pd.products_name,
                          p.master_categories_id, p.products_quantity, p.product_is_call, p.products_date_available, p.products_date_added
                         FROM (" . TABLE_PRODUCTS . " p
                         LEFT JOIN " . TABLE_SPECIALS . " s on p.products_id = s.products_id
                         LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id )
                         WHERE p.products_id = s.products_id and p.products_id = pd.products_id and p.products_status = '1'
                         AND s.status = 1
                         AND pd.language_id = :languagesID
                         ORDER BY s.specials_date_added DESC";

  $specials_query_raw = $db->bindVars($specials_query_raw, ':languagesID', $_SESSION['languages_id'], 'integer');
  $specials_split = new splitPageResults($specials_query_raw, MAX_DISPLAY_SPECIAL_PRODUCTS);
  
  $specials = $db->Execute($specials_split->sql_query);
  $row = 0;
  $col = 0;
  $list_box_contents = array();
  $title = '';

  $num_products_count = $specials->RecordCount();
  if ($num_products_count) {
    if ($num_products_count < SHOW_PRODUCT_INFO_COLUMNS_SPECIALS_PRODUCTS || SHOW_PRODUCT_INFO_COLUMNS_SPECIALS_PRODUCTS==0 ) {
      $col_width = floor(100/$num_products_count);
    } else {
      $col_width = floor(100/SHOW_PRODUCT_INFO_COLUMNS_SPECIALS_PRODUCTS);
    }

    $list_box_contents = array();
    while (!$specials->EOF) {
		
		//set cPath
		$cPath = (($_GET['manufacturers_id'] > 0 and $_GET['filter_id']) > 0 ?  zen_get_generated_category_path_rev($_GET['filter_id']) : ($_GET['cPath'] > 0 ? zen_get_generated_category_path_rev($_GET['cPath']) : zen_get_generated_category_path_rev($specials->fields['master_categories_id'])));
		$specials->fields['cPath'] = $cPath;
				
		//set Infopagelink
		$zen_get_info_page = zen_get_info_page($specials->fields['products_id']);
		$specials->fields['zen_get_info_page'] = $zen_get_info_page;
		
		$products_price = zen_get_products_display_price($specials->fields['products_id']);
	  
		$products_name = $specials->fields['products_name'];
		
		//$products_description = zen_trunc_string(zen_clean_html(stripslashes(zen_get_products_description($specials->fields['products_id'], $_SESSION['languages_id']))), PRODUCT_LIST_DESCRIPTION); //To Display Product Desc 
		
		$product_content = pzen_get_product_content($specials, array("image_width"=>IMAGE_PRODUCT_LISTING_WIDTH, "image_height"=>IMAGE_PRODUCT_LISTING_HEIGHT));
	
		$list_box_contents[$row][$col] = array('params' => 'class="specialsListBoxContents '.$specials_page_class.'"',
                                             'text' => '
			<div class="product '.$product_content['products_class'].'">
				<div class="product__inside">
					<div class="product__inside__image">
						'.$product_content['products_image'].'
						'.$product_content['hover_label_prod'].'
						'.$product_content['hover_label'].'
					</div>
					'.(($product_content['products_new']==1)? '<div class="product__label product__label--right product__label--new"> <span>'.PZEN_BADGE_NEW.'</span></div>' : '').'
					<div class="product__inside__name">
						<h2 class="product_title">
							<a href="' . zen_href_link($zen_get_info_page, 'cPath=' . $cPath . '&products_id=' . $specials->fields['products_id'], 'SSL') . '">' . $products_name . '</a>
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
					</div>
				</div>
			 </div>');
		$col ++;
		if ($col > (SHOW_PRODUCT_INFO_COLUMNS_SPECIALS_PRODUCTS - 1)) {
			$col = 0;
			$row ++;
		}
		$specials->MoveNext();
    }
    require($template->get_template_dir('tpl_specials_default.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_specials_default.php');
  }
}
