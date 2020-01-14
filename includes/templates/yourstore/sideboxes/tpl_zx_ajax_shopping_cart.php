<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @copyright Copyright 2014 ZenExpert - http://www.zenexpert.com
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_zx_ajax_shopping_cart.php 1 2014-06-05 19:07:36Z ZenExpert $
 */
	if($header_style=='header_style_2' || $header_style=='header_style_6' || $header_style=='header_style_9' ) {
		$name_text = "<span class='name-text'>".TEXT_AJAX_CART_TITLE."</span>";
	}
	$content ="";
	$content .= '<a href="'. zen_href_link(FILENAME_SHOPPING_CART, '', 'SSL') .'" class="dropdown-toggle " id="topcartlink"><span class="badge badge--cart">'. $_SESSION['cart']->count_contents() .'</span><span class="icon icon-shopping_basket"></span>'.$name_text.'</a>';
	$content .= '<div role="menu" class="dropdown-menu dropdown-menu--xs-full slide-from-top">
	<div class="container">
		<div class="cart__top">'.TITLE_RECENTLY_ADDED_ITEMS.'</div>
		<a class="icon icon-close cart__close" href="#"><span>'.TEXT_DROP_MENU_CLOSE.'</span></a>';
	if ($_SESSION['cart']->count_contents() > 0) {
		$content.='<ul>';
		$products = $_SESSION['cart']->get_products();
		for ($i=0, $n=sizeof($products); $i<$n; $i++) {
			$attributeHiddenField = "";
			$attrArray2 = false;
			$productsName = $products[$i]['name'];
			// Push all attributes information in an array
			if (isset($products[$i]['attributes']) && is_array($products[$i]['attributes'])) {
				if (PRODUCTS_OPTIONS_SORT_ORDER=='0') {
					$options_order_by= ' ORDER BY LPAD(popt.products_options_sort_order,11,"0")';
				}else {
					$options_order_by= ' ORDER BY popt.products_options_name';
				}
				foreach ($products[$i]['attributes'] as $option => $value) {
					$attributes = "SELECT popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix
								 FROM " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
								 WHERE pa.products_id = :productsID
								 AND pa.options_id = :optionsID
								 AND pa.options_id = popt.products_options_id
								 AND pa.options_values_id = :optionsValuesID
								 AND pa.options_values_id = poval.products_options_values_id
								 AND popt.language_id = :languageID
								 AND poval.language_id = :languageID " . $options_order_by;

					$attributes = $db->bindVars($attributes, ':productsID', $products[$i]['id'], 'integer');
					$attributes = $db->bindVars($attributes, ':optionsID', $option, 'integer');
					$attributes = $db->bindVars($attributes, ':optionsValuesID', $value, 'integer');
					$attributes = $db->bindVars($attributes, ':languageID', $_SESSION['languages_id'], 'integer');
					$attributes_values = $db->Execute($attributes);
					//clr 030714 determine if attribute is a text attribute and assign to $attr_value temporarily
					if ($value == PRODUCTS_OPTIONS_VALUES_TEXT_ID) {
						$attributeHiddenField .= zen_draw_hidden_field('id[' . $products[$i]['id'] . '][' . TEXT_PREFIX . $option . ']',  $products[$i]['attributes_values'][$option]);
						$attr_value = $products[$i]['attributes_values'][$option];
					}else {
						$attributeHiddenField .= zen_draw_hidden_field('id[' . $products[$i]['id'] . '][' . $option . ']', $value);	
						$attr_value = $attributes_values->fields['products_options_values_name'];
					}

					$attrArray2[$option]['products_options_name'] = $attributes_values->fields['products_options_name'];
					$attrArray2[$option]['options_values_id'] = $value;
					$attrArray2[$option]['products_options_values_name'] = zen_output_string_protected($attr_value) ;
					$attrArray2[$option]['options_values_price'] = $attributes_values->fields['options_values_price'];
					$attrArray2[$option]['price_prefix'] = $attributes_values->fields['price_prefix'];
				}
			} //end foreach [attributes]

		$content.='<li class="cart__item">
					<div class="cart__item__image pull-left"><a href="'.zen_href_link(zen_get_info_page($products[$i]['id']), 'products_id=' . $products[$i]['id'], 'SSL').'">'.zen_get_products_image($products[$i]['id'], SMALL_IMAGE_WIDTH,SMALL_IMAGE_HEIGHT).'</a></div>
					<div class="cart__item__control">
						<div class="cart__item__delete"><a class="icon icon-delete" onClick="zenajxcart(\''. $products[$i]['id'] .'\');" href="javascript:void(0);"><span>'.TEXT_DELETE.'</span></a></div>
					</div>
					<div class="cart__item__info">
						<div class="cart__item__info__title">
							<h2><a href="'.zen_href_link(zen_get_info_page($products[$i]['id']), 'products_id=' . $products[$i]['id'], 'SSL').'">'.$products[$i]['name'].'</a></h2>
						</div>
						<div class="cart__item__info__price"><span class="info-label">'.TEXT_AJAX_CART_PRICE.'</span><span>'.$currencies->display_price($products[$i]['final_price'], zen_get_tax_rate($products[$i]['tax_class_id']), $products[$i]['quantity']) . ($products[$i]['onetime_charges'] != 0 ? $currencies->display_price($products[$i]['onetime_charges'], zen_get_tax_rate($products[$i]['tax_class_id']), 1) : '').'</span></div>
						<div class="cart__item__info__qty"><input type="text" value="'.$products[$i]['quantity'].'" class="input--ys" readonly></div>';
						if (isset($attrArray2) && is_array($attrArray2)) {
						reset($attrArray2);
						$content.='<div class="cart__item__info__details">
							<div class="multitooltip">
								<a href="javascript:void(0);">Details</a>
								<div class="tip on-bottom">';
										foreach ($attrArray2 as $option => $value2) {
											$content.='<span><strong>'.$value2['products_options_name'].':</strong> '.nl2br($value2['products_options_values_name']).'</span>';
										}
								$content.='	
								</div>
							</div>
						</div>
						</div>';
						}
						$content.='
					
				</li>';
			
			if (isset($_SESSION['new_products_id_in_cart']) && ($_SESSION['new_products_id_in_cart'] == $products[$i]['id'])) {
				$_SESSION['new_products_id_in_cart'] = '';
			}
		}
		$content.='</ul>';
		$content.='<div class="cart__bottom">
						<div class="cart__total">'.TEXT_AJAX_CART_SUBTOTAL.' <span> '.$currencies->format($_SESSION['cart']->show_total()).'</span></div>
						<button class="btn btn--ys btn-checkout" onclick="window.location=\''.zen_href_link(FILENAME_SHOPPING_CART, '', 'SSL').'\'" >'.TEXT_AJAX_CART_CHECKOUT.' <span class="icon icon--flippedX icon-reply"></span></button>
						<a class="btn btn--ys" href="'.zen_href_link(FILENAME_SHOPPING_CART, '', 'SSL').'"><span class="icon icon-shopping_basket"></span> '.TEXT_AJAX_CART_VIEW_CART.'</a>
					</div>';
	
	}else{
		$content.=TEXT_AJAX_CART_EMPTY;
	}
	$content.='</div>';
	$content.='</div>';
?>