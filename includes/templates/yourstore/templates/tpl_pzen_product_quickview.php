<div id="productGeneral" class="container-fluid">
	<div class="row product-info-outer">
		<!--bof Form start-->
		<?php echo zen_draw_form('cart_quantity', zen_href_link(zen_get_info_page($_GET['products_id']), zen_get_all_get_params(array('action')) . 'action=add_product', $request_type), 'post', 'enctype="multipart/form-data"') . "\n"; ?>
			<?php if (zen_not_null($products_image)) { ?>
				<?php require(DIR_WS_MODULES . zen_get_module_directory(FILENAME_MAIN_PRODUCT_IMAGE)); ?> 
				<div class="col-sm-6 col-md-6 col-lg-6">
					<div class="product-main-image">
						<div class="product-main-image__item">
							<?php  echo zen_image($products_image_large, $products_name, LARGE_IMAGE_MAX_WIDTH, LARGE_IMAGE_MAX_HEIGHT); ?>
						</div>
					</div>
				</div>
			<?php } ?>
				<div class="product-info col-sm-6 col-md-6 col-lg-6">
					<!-- <div class="wrapper">
						<div class="product-info__sku pull-left"><?php //echo (($flag_show_product_info_model == 1 and $products_model !='') ? TEXT_PRODUCT_MODEL . '<strong>'.$products_model.'</strong>' : ''); ?></div>
						<div class="product-info__availability pull-right">
							<?php //echo TEXT_PRODUCT_AVAILABILITY.(($products_quantity>0 ) ? '<strong class="color">&nbsp;'.	TEXT_PRODUCT_QUANTITY.'</strong>'  : '<strong class="alert-text">&nbsp;'.TITLE_OUT_OF_STOCK.'</strong>'); ?>
						</div>
					</div> -->
					<div class="product-info__title">
						<h2><?php echo $products_name; ?></h2>
					</div>
					<?php if(SHOW_PRODUCT_INFO_REVIEWS_COUNT==1){ ?>
					<div class="product-info__review">
						<?php 
							if ($reviews->fields['count'] > 0 ) { 
								if ($flag_show_product_info_reviews_count == 1) {
									echo pzen_product_reviews($_GET['products_id']);
								} 
							  } ?>
						<a href="<?php echo  zen_href_link(FILENAME_PRODUCT_REVIEWS, zen_get_all_get_params(), 'SSL'); ?>" title="<?php echo BUTTON_REVIEWS_ALT; ?>">
							<?php  echo TEXT_CURRENT_REVIEWS ." ". $reviews->fields['count']; ?>
						</a>
						<a href="<?php echo zen_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, zen_get_all_get_params(array('reviews_id')), 'SSL'); ?>"><?php echo TEXT_ADD_YOUR_REVIEW; ?></a>
					</div>
					<?php } ?>
					<?php if(zen_get_product_is_always_free_shipping($products_id_current) && $flag_show_product_info_free_shipping) { ?>
						<div id="freeShippingIcon"><?php echo TEXT_PRODUCT_FREE_SHIPPING_ICON; ?></div>
					<?php } ?>
					<div id="productPrices" class="productGeneral price-box product-info__price">
						<?php
							// base price
							if ($show_onetime_charges_description == 'true') {
								$one_time = '<span >' . TEXT_ONETIME_CHARGE_SYMBOL . TEXT_ONETIME_CHARGE_DESCRIPTION . '</span><br />';
							} else {
								$one_time = '';
							}
							echo $one_time . ((zen_has_product_attributes_values((int)$_GET['products_id']) and $flag_show_product_info_starting_at == 1) ? '' : '') . zen_get_products_display_price((int)$_GET['products_id']);
							?>
					</div>
					<div class="divider divider--xs product-info__divider"></div>
					<div class="product-info__description">
						<div class="product-info__description__text"><?php echo $products_description; ?></div>
					</div>
					<div class="product-info__description hidden-xs">
						<!-- <div class="product-info__sku">
							<?php echo (($flag_show_product_info_weight == 1 and $products_weight !=0) ? TEXT_PRODUCT_WEIGHT .  '<strong>'.$products_weight . TEXT_PRODUCT_WEIGHT_UNIT . 
								'</strong>'  : '') . "\n"; ?>
						</div> -->
						<div class="product-info__sku">
							<?php echo (($flag_show_product_info_manufacturer == 1 and !empty($manufacturers_name)) ? TEXT_PRODUCT_MANUFACTURER . 
								'<strong>'.$manufacturers_name . '</strong>' : '') . "\n"; ?>
						</div>
						<div class="product-info__sku">
							<?php echo (($flag_show_product_info_quantity == 1) ? TEXT_PRODUCT_UNITS_IN_STOCK . '<span id="productDetailsList_product_info_quantity"><strong>' . $products_quantity . '</strong></span>'  : '') . "\n"; ?>
						</div>
						<!--bof Product date added/available-->
						<?php
						  if ($products_date_available > date('Y-m-d H:i:s')) {
							if ($flag_show_product_info_date_available == 1) {
						?>
						  <div id="productDateAvailable" class="productGeneral product-info__sku"><?php echo sprintf(TEXT_DATE_AVAILABLE, '<strong>' . zen_date_long($products_date_available) . '</strong>'); ?></div>
						<?php
							}
						  } else {
							if ($flag_show_product_info_date_added == 1) {
						?>
							<div id="productDateAdded" class="productGeneral product-info__sku"><?php echo sprintf(TEXT_DATE_ADDED,  '<strong>' . zen_date_long($products_date_added)  . '</strong>' ); ?></div>
						<?php
							} // $flag_show_product_info_date_added
						  }
						?>
						<!--eof Product date added/available -->
					</div>
					<div class="divider divider--xs product-info__divider hidden-xs"></div>
					<div class="wrapper">
						<!--bof Attributes Module -->
						<?php
						  if ($pr_attr->fields['total'] > 0) {
						?>
						<?php
						/**
						 * display the product atributes
						 */
						  require($template->get_template_dir('/tpl_modules_attributes.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_attributes.php'); ?>
						<?php
						  }
						?>
						<!--eof Attributes Module -->
					</div>
					<!--bof Add to Cart Box -->
						<?php
						if (CUSTOMERS_APPROVAL == 3 and TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE_SHOWROOM == '') {
						  // do nothing
						} else {
						?>
						<?php
							$display_qty = (($flag_show_product_info_in_cart_qty == 1 and $_SESSION['cart']->in_cart($_GET['products_id'])) ? '<p>' . PRODUCTS_ORDER_QTY_TEXT_IN_CART . $_SESSION['cart']->get_quantity($_GET['products_id']) . '</p>' : '');
							if ($products_qty_box_status == 0 or $products_quantity_order_max== 1) {
								// hide the quantity box and default to 1
								$the_button = '<input type="hidden" name="cart_quantity" value="1" />' . zen_draw_hidden_field('products_id', (int)$_GET['products_id']) . '<div class="pull-left"><span class="icon icon-shopping_basket"></span>'.zen_image_submit(BUTTON_IMAGE_IN_CART, BUTTON_IN_CART_ALT).'</div>';
							} else {
							// show the quantity box
							$the_button = '
								<div class="pull-left">
									<span class="qty-label">' . TEXT_QTY . '</span>
								</div>
								<div class="pull-left">
									<input type="text" class="quantity-input input--ys qty-input pull-left" name="cart_quantity" value="' . (zen_get_buy_now_qty($_GET['products_id'])) . '" maxlength="6" size="4" />
								</div>
								<div class="pull-left">
									
									<div class="btn btn--ys btn--xxl">
										<span class="icon icon-shopping_basket"></span>
									'.zen_image_submit(BUTTON_IMAGE_IN_CART, BUTTON_IN_CART_ALT) . zen_draw_hidden_field('products_id', (int)$_GET['products_id']).
									'</div>
								</div>';
								
							}
							$display_button = zen_get_buy_now_button($_GET['products_id'], $the_button);
							
							if (UN_MODULE_WISHLISTS_ENABLED) { $wishlist_link= '<a title="'.UN_TEXT_ADD_WISHLIST.'" href="' . zen_href_link(UN_FILENAME_WISHLIST, 'products_id=' . $_GET['products_id'] . '&action=wishlist_add_product', 'SSL') . '"><span class="icon icon-favorite_border  tooltip-link"></span><span class="text">'.UN_TEXT_ADD_WISHLIST.'</span></a>';}else{ $wishlist_link='';}
							
							$compare_link='';
							if(COMPARE_VALUE_COUNT > 0){
								$compare_link='<a title="'.TITLE_ADD_TO_COMPARE.'" href="javascript: compareNew('.$_GET['products_id'].', \'add\')"><span class="icon icon-sort  tooltip-link"></span><span class="text">'.TITLE_ADD_TO_COMPARE.'</span></a>';
							}
							echo (zen_get_products_quantity_min_units_display((int)$_GET['products_id']))? '<div class="divider divider--sm"></div>'."<div class='col-lg-12'>".zen_get_products_quantity_min_units_display((int)$_GET['products_id'])."</div>" : '';
						  ?>
						  <div class="divider divider--sm"></div>
						  <?php if ($display_qty != '' or $display_button != '') { ?>
						  <div class="wrapper">
								<?php
								echo $display_qty;
								echo $display_button;
								//echo $products_qty_box_status;
							  ?>
						  </div>
						  <ul class="product-link">
							<li class="">
								<?php echo $wishlist_link; ?>
							</li>
							<li class="text-left">
								<?php echo $compare_link; ?>
							</li>
						  </ul>
						  <?php } // display qty and button ?>
						<?php } // CUSTOMERS_APPROVAL == 3 ?>
						<!--eof Add to Cart Box-->
					  <div class="divider divider--sm"></div>
					  <a href="<?php echo  zen_href_link(zen_get_info_page((int)$_GET['products_id']), 'cPath=' . $productsInCategory[(int)$_GET['products_id']] . '&products_id=' . (int)$_GET['products_id'], 'SSL'); ?>" class="viewfullinfo">View Full Info</a>
				</div>
			</div>
		</div>
		</form>
		<!--eof Form start-->
	</div>
</div>