<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=shopping_cart.<br />
 * Displays shopping-cart contents
 *
 * @package templateSystem
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_shopping_cart_default.php 15881 2010-04-11 16:32:39Z wilt $
 */
?>
<div class="centerColumn" id="shoppingCartDefault">
<?php
  if ($flagHasCartContents) {
?>

<?php
  if ($_SESSION['cart']->count_contents() > 0) {
?>
<!--<div class="forward"><?php //echo TEXT_VISITORS_CART; ?></div>-->
<?php
  }
?>
<div class="title-box">
		<h2 class="text-center text-uppercase title-under"><?php echo TEXT_SHOPPING_CART; ?></h2>
</div>

<?php if ($messageStack->size('shopping_cart') > 0) echo $messageStack->output('shopping_cart'); ?>

<?php echo zen_draw_form('cart_quantity', zen_href_link(FILENAME_SHOPPING_CART, 'action=update_product', $request_type)); ?>
<!--<div id="cartInstructionsDisplay" class="content"><?php //echo TEXT_INFORMATION; ?></div>-->
<?php if (!empty($totalsDisplay)) { ?>
  <!--<div class="cartTotalsDisplay important"><?php //echo $totalsDisplay; ?></div>-->

<?php } ?>

<?php  if ($flagAnyOutOfStock) { ?>

<?php    if (STOCK_ALLOW_CHECKOUT == 'true') {  ?>

<div class="alert alert-danger alert-dismissable"><?php echo OUT_OF_STOCK_CAN_CHECKOUT; ?></div>
<?php    } else { ?>
<div class="alert alert-danger alert-dismissable"><?php echo OUT_OF_STOCK_CANT_CHECKOUT; ?></div>

<?php    } //endif STOCK_ALLOW_CHECKOUT ?>
<?php  } //endif flagAnyOutOfStock ?>
<div class="cart-container">
    <div class="table-responsive table-container">
        <table class="table table-bordered">
             <tr class="tableHeading">
                <th scope="col" id="scProductsHeading"><?php echo TABLE_HEADING_PRODUCTS_IMAGE; ?></th>
                <th scope="col" id="scProductsHeading"><?php echo TABLE_HEADING_PRODUCTS_NAME; ?></th>
                <th scope="col" id="scUnitHeading"><?php echo TABLE_HEADING_PRICE; ?></th>
                <th scope="col" id="scQuantityHeading"><?php echo TABLE_HEADING_QUANTITY; ?></th>
                <th scope="col" id="scUpdateQuantity"><?php echo TABLE_HEADING_UPDATE; ?></th>
                <th scope="col" id="scRemoveHeading"><?php echo TABLE_HEADING_DELETE; ?></th>
                <th scope="col" id="scTotalHeading"><?php echo TABLE_HEADING_TOTAL; ?></th>
             </tr>
                 <!-- Loop through all products /-->
            <?php
                foreach ($productArray as $product) {
            ?>
             <tr class="<?php echo $product['rowClass']; ?>">
                <td class="cartProductDisplay img" valign="middle" width="20%" padding="0">
                    <span id="cartImage" class="back">
                        <?php echo $product['productsImage']; ?>
                    </span>
               </td>
               <td class="details">
               		<div class="product-desc">
                        <h5 class="shopping-cart-table__product-name text-left text-uppercase">
                            <a href="<?php echo $product['linkProductsName']; ?>"><?php echo $product['productsName']; ?></a>
                        </h5>
                        <span class="alert-text bold"> <?php echo $product['flagStockCheck']; ?> </span>
                        <?php
                          echo $product['attributeHiddenField'];
                          if (isset($product['attributes']) && is_array($product['attributes'])) {
                          echo '<div class="cartAttribsList">';
                          echo '<ul class="shopping-cart-table__list-parameters">';
                            reset($product['attributes']);
                            foreach ($product['attributes'] as $option => $value) {
                        ?>
                        <li><?php echo $value['products_options_name'] . TEXT_OPTION_DIVIDER . nl2br($value['products_options_values_name']); ?></li>
                        <?php
                            }
                          echo '</ul>';
                          echo '</div>';
                          }
                        ?>
                  	</div>
               </td>
               <td class="cartUnitDisplay">
									<div class="shopping-cart-table__product-price unit-price">
										<?php echo $product['productsPriceEach']; ?>
									</div>
							 </td>
               <td class="cartQuantity">
									<div class="shopping-cart-table__input">
										<?php
											if ($product['flagShowFixedQuantity']) {
												echo $product['showFixedQuantityAmount'] . '<span class="alert-text bold">' . $product['flagStockCheck'] . '</span>' . $product['showMinUnits'];
											} else {
												echo $product['quantityField'] . '<span class="alert-text bold">' . $product['flagStockCheck'] . '</span>' . $product['showMinUnits'];
											}
										?>
									</div>
              </td>
              <td class="cartQuantityUpdate">
                <?php
                  if ($product['buttonUpdate'] == '') {
                   echo '' ;
                  } else {
                    echo $product['buttonUpdate'];
                  }
                    //echo zen_image_submit(ICON_IMAGE_UPDATE, ICON_UPDATE_ALT);
                ?>
               </td>
               <td class="cartRemoveItemDisplay">
                <?php
                  if ($product['buttonDelete']) {
                ?>
                	<a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART, 'action=remove_product&product_id=' . $product['id'], 'SSL'); ?>">
                    	<?php echo zen_image($template->get_template_dir(ICON_IMAGE_TRASH, DIR_WS_TEMPLATE, $current_page_base,'images/icons'). '/' . ICON_IMAGE_TRASH, ICON_TRASH_ALT); ?>
                  	</a>
                <?php
                  }
                  /*if ($product['checkBoxDelete'] ) {
                    echo zen_draw_checkbox_field('cart_delete[]', $product['id']);
                  }*/
                ?>
                </td>
               <td class="cartTotalDisplay">
									<div class="shopping-cart-table__product-price unit-price">
										<?php echo $product['productsPrice']; ?>
									</div>
							 </td>
             </tr>
                <?php
                  } // end foreach ($productArray as $product)
                ?>
             <!-- Finished loop through all products /-->
    	</table>
    </div>
    <div id="cartSubTotal">
			<div class="shopping-cart-table__product-price unit-price">
				<strong><?php echo SUB_TITLE_SUB_TOTAL; ?></strong>
				<?php echo $cartShowTotal; ?>
			</div>
		</div>
	<div class="divider divider--xs"></div>
	<!--bof shopping cart buttons-->
	<div class="clearfix shopping-cart-btns">
		<?php
			if (SHOW_SHIPPING_ESTIMATOR_BUTTON == '1') {
    ?>
		<div class="back btn btn--ys btn--light"><?php echo '<a href="javascript:popupWindow(\'' . zen_href_link(FILENAME_POPUP_SHIPPING_ESTIMATOR, '', 'SSL') . '\')">' .
			zen_image_button(BUTTON_IMAGE_SHIPPING_ESTIMATOR, BUTTON_SHIPPING_ESTIMATOR_ALT) . '</a>'; ?></div>
		<?php
      }
    ?>
				<?php
			// show update cart button
			if (SHOW_SHOPPING_CART_UPDATE == 2 or SHOW_SHOPPING_CART_UPDATE == 3) {
		?>
				<div class="back btn--light pull-left updateall_btn btn-right">
					<?php echo zen_image_submit(ICON_IMAGE_UPDATE, 'UPDATE TOTAL'); ?>
				</div>
		<?php
		 } else { // don't show update button below cart
		?>
		<?php
		} // show update button
		?>
		<div class="forward checkout_button btn btn--ys btn--light pull-right"><?php echo '<a href="' . zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_CHECKOUT, BUTTON_CHECKOUT_ALT) . '</a><span class="icon icon-keyboard_arrow_right"></span>'; ?></div>
		<div class="back btn btn--ys btn--light btn-right pull-right"><?php echo '<span class="icon icon-keyboard_arrow_left"></span>'.zen_back_link() . zen_image_button(BUTTON_IMAGE_CONTINUE_SHOPPING, BUTTON_CONTINUE_SHOPPING_ALT) . '</a>'; ?></div>
	<!--eof shopping cart buttons-->
	</div>
</form>

<!-- ** BEGIN PAYPAL EXPRESS CHECKOUT ** -->
<?php  // the tpl_ec_button template only displays EC option if cart contents >0 and value >0
if (defined('MODULE_PAYMENT_PAYPALWPP_STATUS') && MODULE_PAYMENT_PAYPALWPP_STATUS == 'True') {
  include(DIR_FS_CATALOG . DIR_WS_MODULES . 'payment/paypal/tpl_ec_button.php');
}
?>
<!-- ** END PAYPAL EXPRESS CHECKOUT ** -->

<?php
      if (SHOW_SHIPPING_ESTIMATOR_BUTTON == '2') {
/**
 * load the shipping estimator code if needed
 */
?>
	<div class="shippingEstimatorCont">
      <?php require(DIR_WS_MODULES . zen_get_module_directory('shipping_estimator.php')); ?>
	</div>

<?php
      }
?>
<?php
  } else {
?>

<h2 id="cartEmptyText"><?php echo TEXT_CART_EMPTY; ?></h2>
<?php
	$show_display_shopping_cart_empty = $db->Execute(SQL_SHOW_SHOPPING_CART_EMPTY);
	while (!$show_display_shopping_cart_empty->EOF) {
	?>
	<?php
	  if ($show_display_shopping_cart_empty->fields['configuration_key'] == 'SHOW_SHOPPING_CART_EMPTY_FEATURED_PRODUCTS') { ?>
	<?php
	/**
	 * display the Featured Products Center Box
	 */
	?>
		<?php require($template->get_template_dir('tpl_modules_featured_products.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_featured_products.php'); ?>
	<?php } ?>
	<?php
	  if ($show_display_shopping_cart_empty->fields['configuration_key'] == 'SHOW_SHOPPING_CART_EMPTY_SPECIALS_PRODUCTS') { ?>
	<?php
	/**
	 * display the Special Products Center Box
	 */
	?>
	<?php require($template->get_template_dir('tpl_modules_specials_default.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_specials_default.php'); ?>
	<?php } ?>

	<?php
	  if ($show_display_shopping_cart_empty->fields['configuration_key'] == 'SHOW_SHOPPING_CART_EMPTY_NEW_PRODUCTS') { ?>
	<?php
	/**
	 * display the New Products Center Box
	 */
	?>
	<?php require($template->get_template_dir('tpl_modules_whats_new.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_whats_new.php'); ?>
	<?php } ?>

	<?php
	  if ($show_display_shopping_cart_empty->fields['configuration_key'] == 'SHOW_SHOPPING_CART_EMPTY_UPCOMING') {
		include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_UPCOMING_PRODUCTS));
	  }
	?>
	<?php
	  $show_display_shopping_cart_empty->MoveNext();
	} // !EOF
	?>
<?php
  }
?>
</div>
</div>
