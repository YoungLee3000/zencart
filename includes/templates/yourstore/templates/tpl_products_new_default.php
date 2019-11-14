<?php
/**
 * Page Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_products_new_default.php 2677 2005-12-24 22:30:12Z birdbrain $
 */
?>
<div class="centerColumn" id="newProductsDefault">

	<div class="title-box">
		<h2 class="text-center text-uppercase title-under"><?php echo HEADING_TITLE; ?></h2>
	</div>
<!-- Top Product Sorter -->
<?php
/********************************** GRID LIST VIEW ***************************************/
   $gridlist_tab='';
   if (defined('PRODUCT_LISTING_LAYOUT_STYLE_CUSTOMER') and PRODUCT_LISTING_LAYOUT_STYLE_CUSTOMER == '1') {
    //echo '<div class="view-mode">' .  array(array('id'=>'rows','text'=>PRODUCT_LISTING_LAYOUT_ROWS),array('id'=>'columns','text'=>PRODUCT_LISTING_LAYOUT_COLUMNS))) . '</div>';
	$gridlist_tab=pzen_gridlist_tab(FILENAME_PRODUCTS_NEW);
  }
   /**********************************EOF GRID LIST VIEW ***************************************/
/**
 * display the product order dropdown
 */
require($template->get_template_dir('/tpl_modules_listing_display_order.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_listing_display_order.php'); ?>
<!-- Top Product Sorter Ends-->
<?php  if (PRODUCT_NEW_LISTING_MULTIPLE_ADD_TO_CART > 0 and $show_submit == true and $products_new_split->number_of_rows > 0) { ?>
<?php
    if ($show_top_submit_button == true or $show_bottom_submit_button == true) {
      echo zen_draw_form('multiple_products_cart_quantity', zen_href_link(FILENAME_PRODUCTS_NEW, zen_get_all_get_params(array('action')) . 'action=multiple_products_add_product'), 'post', 'enctype="multipart/form-data"');
    }
  }
?>
<?php
  $openGroupWrapperDiv = false;
  if (($products_new_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3'))) {
    $openGroupWrapperDiv = true;
?>
<div class="prod-list-wrap group top-wrap-group">
	<div class="product-page-count">
		<div id="newProductsDefaultListingTopLinks" class="back navSplitPagesLinks"><?php echo TEXT_RESULT_PAGE . $products_new_split->display_links($max_display_page_links, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page')), $paginateAsUL); ?></div>
		<div id="newProductsDefaultListingTopNumber" class="navSplitPagesResult back"><?php echo $products_new_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW); ?></div>
	</div>
<?php
  }
?>


<?php  if ($show_top_submit_button == true) {?>
<?php
if (PREV_NEXT_BAR_LOCATION == '2') {
  echo '<div class="prod-list-wrap group">';
}
?>
<div class="button-top forward"><?php echo zen_image_submit(BUTTON_IMAGE_ADD_PRODUCTS_TO_CART, BUTTON_ADD_PRODUCTS_TO_CART_ALT, 'id="submit1" name="submit1"'); ?></div>
<?php	if(PREV_NEXT_BAR_LOCATION == '2') { echo '</div>'; } ?>
<?php } ?>
<?php if ($openGroupWrapperDiv) { echo '</div>'; } ?>

<!-- Product List -->
<?php
/**
 * display the new products
 */
require($template->get_template_dir('/tpl_modules_products_new_listing.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_products_new_listing.php'); ?>
<!-- Product List Ends -->


<?php
if ($show_bottom_submit_button == false && PREV_NEXT_BAR_LOCATION == '1') {
  // nothing
} else {
  echo '<div class="prod-list-wrap group">';
}
?>
<?php  if ($show_bottom_submit_button == true) { ?>
<?php
if (PREV_NEXT_BAR_LOCATION == '1') {
  echo '<div class="prod-list-wrap group button-bottom">';
}
?>
<div class="forward button-top"><?php echo zen_image_submit(BUTTON_IMAGE_ADD_PRODUCTS_TO_CART, BUTTON_ADD_PRODUCTS_TO_CART_ALT, 'id="submit2" name="submit1"'); ?></div>
<?php if (PREV_NEXT_BAR_LOCATION == '1') {   echo '</div>'; } ?>
<?php  }  ?>
<?php  if (($products_new_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) { ?>
<div class="product-page-count">
	<div id="newProductsDefaultListingBottomLinks" class="navSplitPagesLinks back"><?php echo TEXT_RESULT_PAGE . $products_new_split->display_links($max_display_page_links, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page')), $paginateAsUL); ?></div>
  <div id="newProductsDefaultListingBottomNumber" class="navSplitPagesResult back"><?php echo $products_new_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW); ?></div>
 </div>
<?php } ?>
<?php
if ($show_bottom_submit_button == false && PREV_NEXT_BAR_LOCATION == '1') {
  // nothing
} else {
  echo '</div>';
}
?>

<?php
// only end form if form is created
    if ($show_top_submit_button == true or $show_bottom_submit_button == true) {
?>
</form>
<?php } // end if form is made ?>
</div>
