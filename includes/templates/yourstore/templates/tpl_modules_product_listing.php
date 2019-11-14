<?php
/**
 * Module Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_product_listing.php 3241 2006-03-22 04:27:27Z ajeh $
 * UPDATED TO WORK WITH COLUMNAR PRODUCT LISTING 04/04/2006
 * Modified for admin control of customer option by Glenn Herbert (gjh42) 2012-09-21   2012-11-17 grid sorter
 */
 include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_PRODUCT_LISTING));
 if(((isset($_GET['view'])) && ($_GET['view']=='rows')) || (PRODUCT_LISTING_LAYOUT_STYLE=='rows' && (!isset($_GET['view'])) )) {
  $grid_list_class = "row-view";
 }
 else {
  $grid_list_class="";
 }

?>

<div id="productListing" class="product-listing carousel-products-mobile row <?php echo $grid_list_class; ?>">
<?php if ($listing_split->number_of_rows && (PREV_NEXT_BAR_LOCATION == '1' || PREV_NEXT_BAR_LOCATION == '3') ) { ?>
<div class="prod-list-wrap group top-wrap-group">
  <?php  } ?>
<?php if ($listing_split->number_of_rows && (PREV_NEXT_BAR_LOCATION == '1' || PREV_NEXT_BAR_LOCATION == '3') ) { ?>
<div class="product-page-count">
  <div id="productsListingListingTopLinks" class="navSplitPagesLinks back"><?php echo TEXT_RESULT_PAGE . $listing_split->display_links($max_display_page_links, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page')), $paginateAsUL); ?></div>
  <div id="productsListingTopNumber" class="navSplitPagesResult back<?php echo $listing_split->number_of_pages == 1 ? ' navSplitEmpty3rdColumn' : ''; ?>"><?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></div>
</div>
<?php } ?>
<?php
// only show when there is something to submit and enabled
    if ($show_top_submit_button == true) {
?>
<?php if (PREV_NEXT_BAR_LOCATION == '2' && $listing_split->number_of_rows) { ?>
  <div class="prod-list-wrap group">
<?php } ?>
    <div class="forward button-top"><?php echo zen_image_submit(BUTTON_IMAGE_ADD_PRODUCTS_TO_CART, BUTTON_ADD_PRODUCTS_TO_CART_ALT, 'id="submit1" name="submit1"'); ?></div>
<?php if (PREV_NEXT_BAR_LOCATION == '2' && $listing_split->number_of_rows) { ?>
  </div>
<?php } ?>

<?php   } // show top submit ?>
<?php if ($listing_split->number_of_rows && (PREV_NEXT_BAR_LOCATION == '1' || PREV_NEXT_BAR_LOCATION == '3') ) { ?>
</div>
<?php } ?>

<?php
/**
 * load the list_box_content template to display the products
 */
require($template->get_template_dir('tpl_template_productlisting.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_template_productlisting.php');

?>
<!-- Bottom Pagination and button -->
<?php if (($listing_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) { ?>
<div class="pageresult_bottom filters-row prod-list-wrap group">
<?php } ?>
<?php
// only show when there is something to submit and enabled
    if ($show_bottom_submit_button == true) {
?>
<?php if (PREV_NEXT_BAR_LOCATION == '1') { ?>
  <div class="prod-list-wrap group button-bottom">
<?php } ?>
    <div class="forward button-top"><?php echo zen_image_submit(BUTTON_IMAGE_ADD_PRODUCTS_TO_CART, BUTTON_ADD_PRODUCTS_TO_CART_ALT, 'id="submit2" name="submit1"'); ?></div>
<?php if (PREV_NEXT_BAR_LOCATION == '1') { ?>
  </div>
<?php } ?>

<?php
    } // show_bottom_submit_button
?>
<?php if (($listing_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) { ?>
	<div class="product-page-count">
		<div id="newProductsDefaultListingTopNumber" class="navSplitPagesResult back"><?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></div>
		<?php if($listing_split->number_of_pages > 1) { //to hide the pagination div if no. of pages < 1 ?>
			<div id="newProductsDefaultListingBottomLinks" class="navSplitPagesLinks forward filters-row__pagination"><ul class="pagination"><?php echo TEXT_RESULT_PAGE . ' ' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page')), $paginateAsUL); ?></ul></div>
		<?php } ?>
	</div>
</div>
<?php  } ?>

<?php
// if ($show_top_submit_button == true or $show_bottom_submit_button == true or (PRODUCT_LISTING_MULTIPLE_ADD_TO_CART != 0 and $show_submit == true and $listing_split->number_of_rows > 0)) {
  if ($show_top_submit_button == true or $show_bottom_submit_button == true) {
?>
</form>
<?php } ?>
</div>