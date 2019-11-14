<?php
/**
 * product_listing module
 *
 * @package modules
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: product_listing.php 6787 2007-08-24 14:06:33Z drbyte $
 * UPDATED TO WORK WITH COLUMNAR PRODUCT LISTING For Zen Cart v1.3.6 - 10/25/2006
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
// BOF Number of Items Per Page
if(isset($_POST['max_display']) || isset($_GET['max_display'])) {
	$_SESSION['product_listing_max_display'] = (int)$_REQUEST['max_display'];
} elseif (!isset($_SESSION['product_listing_max_display'])) {
	$_SESSION['product_listing_max_display'] = (int)MAX_DISPLAY_PRODUCTS_LISTING;
}
// EOF Number of Items Per Page

// Column Layout Support originally added for Zen Cart v 1.1.4 by Eric Stamper - 02/14/2004
// Upgraded to be compatible with Zen-cart v 1.2.0d by Rajeev Tandon - Aug 3, 2004
// Column Layout Support (Grid Layout) upgraded for v1.3.0 compatibility DrByte 04/04/2006
// Column Layout Support (Grid Layout) upgraded for v1.5.0 compatibility and changed to customer control asarfraz July 26 2012
// Modified for admin control of customer option by Glenn Herbert (gjh42) 2012-09-20   test 20120929 grid sorter
//
if (!defined('PRODUCT_LISTING_LAYOUT_STYLE')) define('PRODUCT_LISTING_LAYOUT_STYLE',(isset($_GET['view']) ? $_GET['view'] : 'rows'));
if (!defined('PRODUCT_LISTING_COLUMNS_PER_ROW')) define('PRODUCT_LISTING_COLUMNS_PER_ROW',3);
if (!defined('PRODUCT_LISTING_GRID_SORT')) define('PRODUCT_LISTING_GRID_SORT',0);
$product_listing_layout_style = isset($_GET['view'])? $_GET['view']: PRODUCT_LISTING_LAYOUT_STYLE;
$row = 0;
$col = 0;
$list_box_contents = array();
$title = '';

// $max_results = ($product_listing_layout_style=='columns' && PRODUCT_LISTING_COLUMNS_PER_ROW>0) ? (PRODUCT_LISTING_COLUMNS_PER_ROW * (int)(MAX_DISPLAY_PRODUCTS_LISTING/PRODUCT_LISTING_COLUMNS_PER_ROW)) : MAX_DISPLAY_PRODUCTS_LISTING;

//$max_results = (PRODUCT_LISTING_LAYOUT_STYLE=='columns' && PRODUCT_LISTING_COLUMNS_PER_ROW>0) ? (PRODUCT_LISTING_COLUMNS_PER_ROW * (int)($_SESSION['product_listing_max_display']/PRODUCT_LISTING_COLUMNS_PER_ROW)) : $_SESSION['product_listing_max_display'];

$show_submit = zen_run_normal();
$listing_split = new splitPageResults($listing_sql, MAX_DISPLAY_PRODUCTS_LISTING, 'p.products_id', 'page');
$zco_notifier->notify('NOTIFY_MODULE_PRODUCT_LISTING_RESULTCOUNT', $listing_split->number_of_rows);
$how_many = 0;

// Begin Row Layout Header
if ($product_listing_layout_style == 'rows' or PRODUCT_LISTING_GRID_SORT) {		// For Column Layout (Grid Layout) add on module

//$list_box_contents[0] = array('params' => 'class="productListing-rowheading"');

$zc_col_count_description = 0;
$lc_align = '';
$lst_lc_text='';
for ($col=0, $n=sizeof($column_list); $col<$n; $col++) {
	  switch ($column_list[$col]) {
		case 'PRODUCT_LIST_MODEL':
			$lc_text = TABLE_HEADING_MODEL;
			//$lst_lc_text = TABLE_HEADING_MODEL;
			$lc_align = '';
			$zc_col_count_description++;
		break;
		case 'PRODUCT_LIST_NAME':
			$lc_text = TABLE_HEADING_PRODUCTS;
			//$lst_lc_text =TABLE_HEADING_PRODUCTS;
			$lc_align = '';
			$zc_col_count_description++;
		break;
		case 'PRODUCT_LIST_MANUFACTURER':
			$lc_text = TABLE_HEADING_MANUFACTURER;
			//$lst_lc_text = TABLE_HEADING_MANUFACTURER;
			$lc_align = '';
			$zc_col_count_description++;
		break;
			case 'PRODUCT_LIST_PRICE':
			$lc_text = TABLE_HEADING_PRICE;
			$lc_align = 'right' . (PRODUCTS_LIST_PRICE_WIDTH > 0 ? '" width="' . PRODUCTS_LIST_PRICE_WIDTH : '');
			//$lst_lc_text = TABLE_HEADING_PRICE;
			$zc_col_count_description++;
		break;
		case 'PRODUCT_LIST_QUANTITY':
			$lc_text = TABLE_HEADING_QUANTITY;
			//$lst_lc_text = TABLE_HEADING_QUANTITY;
			$lc_align = 'right';
			$zc_col_count_description++;
		break;
		case 'PRODUCT_LIST_WEIGHT':
			$lc_text = TABLE_HEADING_WEIGHT;
		//	$lst_lc_text = TABLE_HEADING_WEIGHT;
			$lc_align = 'right';
			$zc_col_count_description++;
		break;
		case 'PRODUCT_LIST_IMAGE':
			if ($product_listing_layout_style == 'rows') { //skip if grid
			 // $lc_text = TABLE_HEADING_IMAGE;
			 // $lst_lc_text = TABLE_HEADING_IMAGE;
			 // $lc_align = 'center';
			//  $zc_col_count_description++;
			}
		break;
	}
  
	if ( ($column_list[$col] != 'PRODUCT_LIST_IMAGE')) {
		$lc_text= pzen_create_sort_heading($_GET['sort'], $col+1, $lc_text);
		//$lst_lc_text = zen_create_sort_heading($_GET['sort'], $col+1, $lc_text);
		$list_box_contents[0][$col] = array('text' => $lc_text);
	}
}


    $grid_sort = $list_box_contents[0];
	if ($product_listing_layout_style == 'rows') {
		$list_box_contents = array();
		$list_box_contents[0] = array('text' => '');
	}
	if ($product_listing_layout_style == 'columns') {
       $list_box_contents = array();
	}
	$listing_asc_des=pzen_create_sort_heading_asc_des($_GET['sort'],'','');
	$gridlist_tab='';
	if (defined('PRODUCT_LISTING_LAYOUT_STYLE_CUSTOMER') and PRODUCT_LISTING_LAYOUT_STYLE_CUSTOMER == '1') {
		//echo '<div class="view-mode">' .  array(array('id'=>'rows','text'=>PRODUCT_LISTING_LAYOUT_ROWS),array('id'=>'columns','text'=>PRODUCT_LISTING_LAYOUT_COLUMNS))) . '</div>';
		$gridlist_tab=pzen_gridlist_tab(FILENAME_DEFAULT);
	}

} // End Row Layout Header used in Column Layout (Grid Layout) add on module

/////////////  HEADER ROW ABOVE /////////////////////////////////////////////////

$num_products_count = $listing_split->number_of_rows;
if ($listing_split->number_of_rows > 0) {
	$rows = 0;
	// Used for Column Layout (Grid Layout) add on module
	$column = 0;	
	if ($product_listing_layout_style == 'columns') {
		if ($num_products_count < PRODUCT_LISTING_COLUMNS_PER_ROW || PRODUCT_LISTING_COLUMNS_PER_ROW == 0 ) {
			$col_width = floor(100/$num_products_count) - 4.0;
		} else {
			$col_width = floor(100/PRODUCT_LISTING_COLUMNS_PER_ROW) - 4.0;
		}
	}
	
	// Used for Column Layout (Grid Layout) add on module
  
	$listing = $db->Execute($listing_split->sql_query);
	$extra_row = 0;
	while (!$listing->EOF) {
		$product_etc_info='';
		if ($product_listing_layout_style == 'rows') { // Used in Column Layout (Grid Layout) Add on module
			$rows++;
			if ((($rows-$extra_row)/2) == floor(($rows-$extra_row)/2)) {
				$list_box_contents[$rows] = array('params' => 'class="item even"');
			} else {
				$list_box_contents[$rows] = array('params' => 'class="item odd"');
			}
			$cur_row = sizeof($list_box_contents) - 1;
		}
		// End of Conditional execution - only for row (regular style layout)

		$product_contents = array(); // Used For Column Layout (Grid Layout) Add on module
		$products_name = $listing->fields['products_name'];
		$products_description_full = zen_trunc_string(zen_clean_html(stripslashes(zen_get_products_description($listing->fields['products_id'], $_SESSION['languages_id']))), PRODUCT_LIST_DESCRIPTION); //To Display Product Desc 
		$products_description_list = ltrim(substr($products_description_full, 0, 250) . ''); //Trims and Limits the desc
		
		//set cPath
		$cPath = (($_GET['manufacturers_id'] > 0 and $_GET['filter_id']) > 0 ?  zen_get_generated_category_path_rev($_GET['filter_id']) : ($_GET['cPath'] > 0 ? zen_get_generated_category_path_rev($_GET['cPath']) : zen_get_generated_category_path_rev($listing->fields['master_categories_id'])));
		$listing->fields['cPath'] = $cPath;
		
		//set Infopagelink
		$zen_get_info_page = zen_get_info_page($listing->fields['products_id']);
		$listing->fields['zen_get_info_page'] = $zen_get_info_page;
		
		$moreinfo = '<a class="more_info_text" href="' . zen_href_link($zen_get_info_page, 'cPath=' . $cPath . '&products_id=' . $listing->fields['products_id'], 'SSL') . '">'.MORE_INFO_TEXT.'</a>';
		for($col=0, $n=sizeof($column_list); $col<$n; $col++) {
			$lc_align = '';
			switch ($column_list[$col]) {
				case 'PRODUCT_LIST_MODEL':
					$lc_align = '';
					if($listing->fields['manufacturers_name']!=''){
						$product_etc_info.= '<div class="product-model">'.TABLE_HEADING_MODEL.' : '.$listing->fields['products_model']."</div>";
					}
		
					break;
				case 'PRODUCT_LIST_NAME':
					$lc_align = '';
					if (isset($_GET['manufacturers_id'])) {
						$product_name = '<h2 class="product-name"><a href="' . zen_href_link($zen_get_info_page, 'cPath=' . $cPath . '&products_id=' . $listing->fields['products_id'], 'SSL') . '">' . $products_name . '</a></h2>';
						//$product_desc='<div class="text"><p>' . zen_trunc_string(zen_clean_html(stripslashes(zen_get_products_description($listing->fields['products_id'], $_SESSION['languages_id']))), PRODUCT_LIST_DESCRIPTION) . '</p></div>' ;
					}else {
						$product_name = '<h2 class="product-name"><a href="' . zen_href_link($zen_get_info_page, 'cPath=' . $cPath . '&products_id=' . $listing->fields['products_id'], 'SSL') . '">' . $products_name . '</a></h2>';
						//$product_desc='<div class="text"><p>' . zen_trunc_string(zen_clean_html(stripslashes(zen_get_products_description($listing->fields['products_id'], $_SESSION['languages_id']))), PRODUCT_LIST_DESCRIPTION) . '</p></div>';
					}
					break;
				case 'PRODUCT_LIST_MANUFACTURER':
					$lc_align = '';
					if($listing->fields['manufacturers_name']!=''){
						$product_etc_info .= '<div class="product-menufacture">'.TABLE_HEADING_MANUFACTURER.' : '.'<span><a href="' . zen_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $listing->fields['manufacturers_id'], 'SSL') . '">' . $listing->fields['manufacturers_name'] . '</a></span></div>';}
						//$lst_lc_text = '<div class="product-menufacture"><a href="' . zen_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $listing->fields['manufacturers_id']) . '">' . $listing->fields['manufacturers_name'] . '</a></div>';
					break;
				case 'PRODUCT_LIST_PRICE':
					$lc_price = zen_get_products_display_price($listing->fields['products_id']);
					$lc_buy_now='';
					$lc_align = 'right';
					//$lc_buy_now =  $lc_price;
					$lst_lc_text =  $lc_price;
					// more info in place of buy now
					$lc_button = '';
		
					if (zen_has_product_attributes($listing->fields['products_id']) or PRODUCT_LIST_PRICE_BUY_NOW == '0') {
						$lc_button = '<a class="btn btn--ys btn--xl btn-sopt" href="' . zen_href_link($zen_get_info_page, 'cPath=' . $cPath . '&products_id=' . $listing->fields['products_id']) . '" '.pzenExtraBtnLink($listing).'><span class="icon icon-shopping_basket"></span>' . TITLE_SELECT_OPTIONS . '</a>';
					}else {
						if (PRODUCT_LISTING_MULTIPLE_ADD_TO_CART != 0) {
							if (
							// not a hide qty box product
							$listing->fields['products_qty_box_status'] != 0 &&
							// product type can be added to cart
							zen_get_products_allow_add_to_cart($listing->fields['products_id']) != 'N'
							&&
							// product is not call for price
							$listing->fields['product_is_call'] == 0
							&&
							// product is in stock or customers may add it to cart anyway
							($listing->fields['products_quantity'] > 0 || SHOW_PRODUCTS_SOLD_OUT_IMAGE == 0) ) {
								$how_many++;
							}
							// hide quantity box
							if ($listing->fields['products_qty_box_status'] == 0) {
								$lc_button = '<a class="btn btn--ys btn--xl btn-buynow" href="' . zen_href_link($_GET['main_page'], zen_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $listing->fields['products_id']) . '" '.pzenExtraBtnLink($listing).'>' . zen_image_button(BUTTON_IMAGE_BUY_NOW, BUTTON_BUY_NOW_ALT, 'class="listingBuyNowButton"') . '</a>';
							} else {
								$lc_button = '<div class="prod-qty-bx"><div class="inner-qty-box"><span class="qty-lbl">'.TEXT_PRODUCT_LISTING_MULTIPLE_ADD_TO_CART . "</span><span class='qty_txt'><input type=\"text\" name=\"products_id[" . $listing->fields['products_id'] . "]\" value=\"0\" size=\"4\" /></span>".'</div></div>';
							}
						}else{
							// qty box with add to cart button

							if (PRODUCT_LIST_PRICE_BUY_NOW == '2' && $listing->fields['products_qty_box_status'] != 0) {
								$lc_button= zen_draw_form('cart_quantity', zen_href_link($_GET['main_page'], zen_get_all_get_params(array('action')) . 'action=add_product&products_id=' . $listing->fields['products_id']), 'post', 'enctype="multipart/form-data"') . '<div class="prod-qty-bx"><div class="inner-qty-box"><span class="qty-lbl">'.TEXT_PRODUCT_LISTING_MULTIPLE_ADD_TO_CART .'</span><span class="qty_txt"><input type="text" name="cart_quantity" value="' . (zen_get_buy_now_qty($listing->fields['products_id'])) . '" maxlength="6" size="4" /></span></div></div>' . zen_draw_hidden_field('products_id', $listing->fields['products_id']) .'<button class="btn btn--ys btn--xl btn-buynow"><span class="icon icon-shopping_basket"></span>'. zen_image_submit(BUTTON_IMAGE_IN_CART, BUTTON_IN_CART_ALT) . '</button></form>';
							} else {
								$lc_button = '<a class="btn btn--ys btn--xl btn-buynow" href="' . zen_href_link($_GET['main_page'], zen_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $listing->fields['products_id']) . '" '.pzenExtraBtnLink($listing).'><span class="icon icon-shopping_basket"></span>' . zen_image_button(BUTTON_IMAGE_BUY_NOW, BUTTON_BUY_NOW_ALT, 'class="listingBuyNowButton"') . '</a>';
							}
						}
					}
					$the_button = $lc_button;
					$lst_the_button = $lst_lc_button;
					if($listing->fields['product_is_call'] != '1'){
						$products_link = '<a href="' . zen_href_link($zen_get_info_page, 'cPath=' . $cPath . '&products_id=' . $listing->fields['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
					}
					//if not out of stock
					if($listing->fields['products_quantity'] > 0 || SHOW_PRODUCTS_SOLD_OUT_IMAGE == 0){
						if((zen_get_products_allow_add_to_cart($listing->fields['products_id']) != 'N') && $listing->fields['product_is_call'] == '1'){ 
							$lc_buy_now.='<a class="btn btn--ys btn--xl btn-callforprice" href="' . zen_href_link(FILENAME_CONTACT_US, '', 'SSL') . '"><span class="icon icon-call"></span>' . TEXT_CALL_FOR_PRICE . '</a>';
						}else{
							$minmaxqty=zen_get_products_quantity_min_units_display($listing->fields['products_id']);
							$lc_buy_now .=  zen_get_buy_now_button($listing->fields['products_id'], $the_button, $products_link) .(($minmaxqty)? '<span class="min-max-qty">'.$minmaxqty.'</span>' : '');
						}
					}
					$lc_buy_now .= (zen_get_show_product_switch($listing->fields['products_id'], 'ALWAYS_FREE_SHIPPING_IMAGE_SWITCH') ? (zen_get_product_is_always_free_shipping($listing->fields['products_id']) ? TEXT_PRODUCT_FREE_SHIPPING_ICON  : '') : '');
					break;
				case 'PRODUCT_LIST_QUANTITY':
					$lc_align = 'right';
					if($listing->fields['products_quantity']!=''){
					$product_etc_info .= '<div class="product-qty">'.TABLE_HEADING_QUANTITY.' : '.$listing->fields['products_quantity']."</div>";}
					//$lst_lc_text = '<div class="product-qty">'.$listing->fields['products_quantity']."</div>";
					break;
				case 'PRODUCT_LIST_WEIGHT':
					$lc_align = 'right';
					if($listing->fields['products_weight']!=''){
					$product_etc_info .= '<div class="product-weight">'.TABLE_HEADING_WEIGHT.' : '.$listing->fields['products_weight'].'</div>';}
					//$lst_lc_text = '<div class="product-weight">'.$listing->fields['products_weight'].'</div>';
					break;
				case 'PRODUCT_LIST_IMAGE':
					$lc_align = 'center';
					if ($listing->fields['products_image'] == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == 0) {
						$lc_text = '';
						$lst_lc_text = '';
					}else {
						if (isset($_GET['manufacturers_id'])) {
							$product_img_link=   zen_href_link($zen_get_info_page, 'cPath=' . $cPath . '&products_id=' . $listing->fields['products_id'], 'SSL');
							$product_img = zen_image(DIR_WS_IMAGES . $listing->fields['products_image'], $products_name, IMAGE_PRODUCT_LISTING_WIDTH, IMAGE_PRODUCT_LISTING_HEIGHT);
						}else {
							$product_img = zen_image(DIR_WS_IMAGES . $listing->fields['products_image'], $products_name, IMAGE_PRODUCT_LISTING_WIDTH, IMAGE_PRODUCT_LISTING_HEIGHT);
					  }
					}
					break;
			}
			$product_contents[] = $lc_text; // Used For Column Layout (Grid Layout) Option
			$listview_product_contents[] = $lst_lc_text;
		}
	
		$display_products_model = TEXT_PRODUCTS_MODEL . $listing->fields['products_model'] . str_repeat('', substr(PRODUCT_ALL_LIST_MODEL, 3, 1));
	
		$product_content = pzen_get_product_content($listing);
		
		$lc_text =
				'<div class="product '.(($prodlist_image_effects==2)? 'product--zoom' : '' ).' '.$product_content['products_class'].' '.(($prodlistview_image_layout==2)? 'small-size' : '').'" data-filter="listing" data-name="'.$product_name_only.'">
						<div class="product__inside">
							<div class="product__inside__image">
								'.$product_content['products_image'].'
								'.$product_content['hover_label_prod'].'
								'.(($product_listing_layout_style == 'columns') ? $product_content['hover_label'] : '').'
							</div>
							'.(($product_content['products_new']==1)? '<div class="product__label product__label--right product__label--new"> <span>'.PZEN_BADGE_NEW.'</span></div>' : '').'
							<div class="product__inside__content">
								<div class="product__inside__name">
									'.$product_content['products_name'].'
								</div>
								<div class="product__inside__description row-mode-visible">
									'.$products_description_list.$moreinfo.'
								</div>
								<div class="product__inside__price price-box">
									'.$lc_price.'
								</div>
								<div class="product__inside__review row-mode-visible">
									'.$product_content['products_review'].'
								</div>
								'.(($product_etc_info)? '
								<div class="product-info__description product__inside__info hidden-xs row-mode-visible">
									'.$product_etc_info.'
								</div>' : '').'
								<div class="product__inside__hover">
									<div class="product__inside__info '.((PRODUCT_LIST_PRICE_BUY_NOW == '2' && $listing->fields['products_qty_box_status'] != 0)? 'sqa_prod': '').' ">
										<div class="product__inside__info__btns">
											'.$lc_buy_now.$product_content['wishlist_link_alt'].$product_content['compare_link_alt'].'
											'.(($product_listing_layout_style == 'rows') ? $hover_label : '').'
										</div>
										<ul class="product__inside__info__link hidden-sm">
											<li class="text-right">'.$product_content['wishlist_link'].'</li>
											<li class="text-left">'.$product_content['compare_link'].'</li>
										</ul>
									</div>
									<div class="rating row-mode-hide">
										'.$product_content['products_review'].'
									</div>
								</div>
							</div>
						</div>
					</div>
				';
	  
	 		//$lc_text.='</div>';
		$lc_text.='</div>';
		if($product_listing_layout_style == 'rows') {
			$list_box_contents[$rows][$column] = array('params' => $pzenitem_param . ' ' . '', 'text'  => $lc_text);
			$lst_lc_text='';
			$lc_text='';
		}
		
		if ($product_listing_layout_style == 'columns') {
			$list_box_contents[$rows][$column] = array('params' => $pzenitem_param . ' ' . '', 'text'  => $lc_text);
			$column ++;
			
			if ($column >= PRODUCT_LISTING_COLUMNS_PER_ROW) {
				$column = 0;
				$rows ++;
			}
			$lc_text='';
			$product_etc_info='';
			$product_price_box='';
		}
		// End of Code fragment for Column Layout (Grid Layout) option in add on module
		$listing->MoveNext();
	}
	$error_categories = false;
}else{

	$list_box_contents = array();

	$list_box_contents[0] = array('params' => 'class="productListing-odd"');
	$list_box_contents[0][] = array('params' => 'class="productListing-data alert alert-danger alert-dismissable"',
                                              'text' => TEXT_NO_PRODUCTS);

	$error_categories = true;
}

if (($how_many > 0 and $show_submit == true and $listing_split->number_of_rows > 0) and (PRODUCT_LISTING_MULTIPLE_ADD_TO_CART == 1 or  PRODUCT_LISTING_MULTIPLE_ADD_TO_CART == 3) ) {
	$show_top_submit_button = true;
}else {
	$show_top_submit_button = false;
}

if (($how_many > 0 and $show_submit == true and $listing_split->number_of_rows > 0) and (PRODUCT_LISTING_MULTIPLE_ADD_TO_CART >= 2) ) {
	$show_bottom_submit_button = true;
} else {
	$show_bottom_submit_button = false;
}
if ($how_many > 0 && PRODUCT_LISTING_MULTIPLE_ADD_TO_CART != 0 and $show_submit == true and $listing_split->number_of_rows > 0) {
	// bof: multiple products
    echo zen_draw_form('multiple_products_cart_quantity', zen_href_link(FILENAME_DEFAULT, zen_get_all_get_params(array('action')) . 'action=multiple_products_add_product', 'SSL'), 'post', 'enctype="multipart/form-data"');
}
?>