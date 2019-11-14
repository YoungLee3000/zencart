<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=product_info.<br />
 * Displays details of a typical product
 *
 * @package templateSystem
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_product_info_display.php 19690 2011-10-04 16:41:45Z drbyte $
 */
 //require(DIR_WS_MODULES . '/debug_blocks/product_info_prices.php');
?>
<div class="centerColumn product-container" id="productGeneral">

    <!--bof Form start-->
    <?php echo zen_draw_form('cart_quantity', zen_href_link(zen_get_info_page($_GET['products_id']), zen_get_all_get_params(array('action')) . 'action=add_product', SSL), 'post', 'enctype="multipart/form-data"') . "\n"; ?>
    <!--eof Form start-->

	<?php if ($messageStack->size('product_info') > 0) echo $messageStack->output('product_info'); ?>
	<section class="content offset-top-0">
    	<div class="row product-info-outer">
			<?php if (PRODUCT_INFO_PREVIOUS_NEXT == 1 or PRODUCT_INFO_PREVIOUS_NEXT == 3) { ?>
                <?php if ($products_found_count > 1) { ?>
                    <div id="productPrevNext" class="hidden-xs hidden-sm">
                        <a class="product-prev" data-toggle="tooltip" data-original-title="<?php echo TITLE_PREVIOUS_PRODUCT; ?>" href="<?php echo zen_href_link(zen_get_info_page($previous), "cPath=$cPath&products_id=$previous", 'SSL'); ?>"><?php echo $previous_image . $previous_button; ?></a>
                        <a class="product-next" data-toggle="tooltip" data-original-title="<?php echo TITLE_NEXT_PRODUCT; ?>" href="<?php echo zen_href_link(zen_get_info_page($next_item), "cPath=$cPath&products_id=$next_item", 'SSL'); ?>"><?php echo  $next_item_button . $next_item_image; ?></a>
					</div> 
                <?php } ?>
            <?php }	?>
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
				<div class="row <?php echo ($prodinfo_image_layout==1)? 'big-size' : 'small-size'; ?> product-view">
				  <?php	if (zen_not_null($products_image)) { ?>
					<div class="<?php echo ($prodinfo_image_layout==1)? 'col-sm-6 col-md-6 col-lg-6 col-xl-6' : 'col-sm-4 col-md-4 col-lg-4 col-xl-4'; ?> hidden-xs">
						<div class="product-main-image">
							
							<!--bof Main Product Image -->
							<?php
							/**
							* display the main product image
							*/ ?>
							<?php
								require($template->get_template_dir('/tpl_modules_main_product_image.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_main_product_image.php');
							?>
							<!--eof product image -->
						</div>
						<div id="productAdditionalImages">
							<div class="product-images-carousel">
								<ul id="smallGallery">
									<!--bof product additional images--><?php
									/**
									 * display the products additional images
									 */
									require($template->get_template_dir('/tpl_modules_additional_images.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_additional_images.php'); ?>
									<!--eof product additional images-->
								</ul>
							</div>
						</div>
					</div>
					<?php } ?>
					<div class="product-info <?php echo ($prodinfo_image_layout==1)? 'col-sm-6 col-md-6 col-lg-6 col-xl-6' : 'col-sm-8 col-md-8 col-lg-8 col-xl-8'; ?>">
						<?php if($flag_show_product_info_model == 1 || $flag_show_product_info_quantity == 1) { ?>
						<!-- <div class="wrapper hidden-xs">
							<?php if($flag_show_product_info_model == 1 and $products_model !='') { ?>
							<div class="product-info__sku pull-left">
								<?php //echo TEXT_PRODUCT_MODEL . '<strong>'.$products_model.'</strong>'; ?>
							</div>
							<?php } ?>
							<?php if ($flag_show_product_info_quantity == 1) { ?>
							<div class="product-info__availability pull-right">
								<?php //echo TEXT_PRODUCT_AVAILABILITY.(($products_quantity>0 ) ? '<strong class="color">&nbsp;'.TEXT_PRODUCT_QUANTITY.'</strong>'  : '<strong class="alert-text">&nbsp;'.TITLE_OUT_OF_STOCK.'</strong>'); ?>
							</div>
							<?php } ?>
						</div> -->
						<?php } ?>
						<div class="product-info__title">
							<h2><?php echo $products_name; ?></h2>
						</div>
						<!-- <div class="wrapper visible-xs">
							<div class="product-info__sku pull-left">
								<?php //echo (($flag_show_product_info_model == 1 and $products_model !='') ? TEXT_PRODUCT_MODEL . '<strong>'.$products_model.'</strong>' : ''); ?>
							</div>
							<div class="product-info__availability pull-right">
								<?php //echo TEXT_PRODUCT_AVAILABILITY.(($products_quantity>0 ) ? '<strong class="color">&nbsp;'.TEXT_PRODUCT_QUANTITY.'</strong>'  : '<strong class="alert-text">&nbsp;'.TITLE_OUT_OF_STOCK.'</strong>'); ?>
							</div>
						</div> -->
						<div class="visible-xs">
							<div class="clearfix"></div>
							<ul id="mobileGallery">
								<!--bof product additional images--><?php
								/**
								 * display the products additional images
								 */
								require($template->get_template_dir('/tpl_modules_additional_images_device.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_additional_images_device.php'); ?>
								<!--eof product additional images-->
							</ul>
						</div>
						<?php if(zen_get_product_is_always_free_shipping($products_id_current) && $flag_show_product_info_free_shipping) { ?>
						<div id="freeShippingIcon"><?php echo TEXT_PRODUCT_FREE_SHIPPING_ICON; ?></div>
						<?php } ?>
						<!--eof free ship icon  -->
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
						<div class="divider divider--xs product-info__divider hidden-xs"></div>
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
								<?php echo (($flag_show_product_info_quantity == 1) ? TEXT_PRODUCT_UNITS_IN_STOCK . '<span id="productDetailsList_product_info_quantity"><strong>&nbsp;' . $products_quantity . '</strong></span>'  : '') . "\n"; ?>
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
						<?php
							if ($pr_attr->fields['total'] > 0) {
						?>
						<div class="wrapper">
							<!--bof Attributes Module -->
							<?php
							/**
							 * display the product atributes
							 */
							  require($template->get_template_dir('/tpl_modules_attributes.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_attributes.php'); ?>
							<!--eof Attributes Module -->
						</div>
						<?php
							}
						?>
						<!--分享按钮 -->

							<!-- AddThis Button BEGIN -->

							<div class="addthis_toolbox addthis_default_style addthis_32x32_style">

								<a class="addthis_button_preferred_1"></a>

								<a class="addthis_button_preferred_2"></a>

								<a rel="nofollow" class="addthis_button_google"></a>

								<a rel="nofollow" class="addthis_button_myspace"></a>

								<a class="addthis_button_preferred_3"></a>

								<a class="addthis_button_preferred_4"></a>

								<a class="addthis_button_compact"></a>

								<a class="addthis_counter addthis_bubble_style"></a>

							</div>

							<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>

							<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4f99347b4d58a004"></script>

							<!-- AddThis Button END -->
						<!--bof Add to Cart Box -->
						<?php
						if (CUSTOMERS_APPROVAL == 3 and TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE_SHOWROOM == '') {
						  // do nothing
						} else {
						?>
						<?php
							$display_qty = (($flag_show_product_info_in_cart_qty == 1 and $_SESSION['cart']->in_cart($_GET['products_id'])) ? '<p class="qty-in-cart">' . PRODUCTS_ORDER_QTY_TEXT_IN_CART . $_SESSION['cart']->get_quantity($_GET['products_id']) . '</p>' : '');
							if ($products_qty_box_status == 0 or $products_quantity_order_max== 1) {
								// hide the quantity box and default to 1
								$the_button = '<input type="hidden" name="cart_quantity" value="1" />' . zen_draw_hidden_field('products_id', (int)$_GET['products_id']) . '<div class="pull-left"><div class="btn btn--ys btn--xxl"><span class="icon icon-shopping_basket"></span>'.zen_image_submit(BUTTON_IMAGE_IN_CART, BUTTON_IN_CART_ALT).'</div></div>';
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
						  <div class="wrapper cartAdd">
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
						  

					</div>
				</div>
				<div class="content">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs nav-tabs--ys1" role="tablist">
						<li class="active">
							<a data-toggle="tab" href="#description" class="text-uppercase">
								<?php echo TEXT_PRODUCT_DESCRIPTION; ?>
							</a>
						</li>
						<?php if ($flag_show_product_info_reviews == 1) { ?>
						<li>
							<a data-toggle="tab" href="#product-info-reviews" class="text-uppercase">
								<?php echo TEXT_PRODUCT_REVIEWS; ?>
							</a>
						</li>
						<?php } ?>
						<?php if(DISQUS_STATUS != 'false') { ?>
						<li>
							<a data-toggle="tab" href="#product-info-comments" class="text-uppercase">
								<?php echo TEXT_PRODUCT_COMMENTS; ?>
							</a>
						</li>
						<?php } ?>
					</ul>
					<!-- Tab panes -->
					<div class="tab-content tab-content--ys nav-stacked">
						<div id="description" class="tab-pane active" role="tabpanel">
							<div class="product-tab">
								<p class="text"><?php echo stripslashes($products_description); ?></p>
								<!--bof Product URL -->
								<?php
								  if (zen_not_null($products_url)) {
									if ($flag_show_product_info_url == 1) {
								?>
									<p id="productInfoLink" class="productGeneral centeredContent"><?php echo sprintf(TEXT_MORE_INFORMATION, zen_href_link(FILENAME_REDIRECT, 'action=product&products_id=' . zen_output_string_protected($_GET['products_id']), 'NONSSL', true, false)); ?></p>
								<?php
									} // $flag_show_product_info_url
								  }
								?>
								<!--eof Product URL -->
								<!--bof Quantity Discounts table -->
									<?php
									  if ($products_discount_type != 0) { ?>
									<?php
									/**
									 * display the products quantity discount
									 */
									 require($template->get_template_dir('/tpl_modules_products_quantity_discounts.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_products_quantity_discounts.php'); ?>
									<?php
									  }
									?>
								<!--eof Quantity Discounts table -->
							</div>
						</div>
						<?php if ($flag_show_product_info_reviews == 1) { ?>
						<div id="product-info-reviews" class="tab-pane">
							<div class="product-tab">
								<?php 
								// if more than 0 reviews, then show reviews button; otherwise, show the "write review" button ?>
										<?php if ($reviews->fields['count'] > 0 ) { ?>
											<?php require($template->get_template_dir('tpl_dgReview.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_dgReview.php');?>
										<?php } else { ?>
											<div id="productReviewLink" class="buttonRow back"><?php echo TEXT_NO_REVIEWS; ?> <br/><?php echo '<a href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, zen_get_all_get_params(array()), 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_WRITE_REVIEW, BUTTON_WRITE_REVIEW_ALT) . '</a>'; ?>
											</div>
										<?php
										  } ?>
							</div>
						</div>
						<?php }	?>
						<div id="product-info-comments" class="tab-pane">
							<div class="product-tab">
								<!--Begin Disqus http://www.samuelsena.com/zen-cart-disqus-comment-system/-->
								<?php if(DISQUS_STATUS != 'false') { ?>
								<div id="<?php echo DISQUS_ELEMENT_ID; ?>"></div>
								<script type="text/javascript">
									var disqus_url = '<?php echo str_replace("&amp;", "&", zen_href_link(FILENAME_PRODUCT_INFO, zen_get_all_get_params(), 'SSL'));?>';
									var disqus_identifier = '<?php echo (int)$_GET['products_id'] .'-'. str_replace("&amp;", "&", zen_href_link(FILENAME_PRODUCT_INFO, zen_get_all_get_params(), 'SSL')); ?>';
									var disqus_container_id = '<?php echo DISQUS_ELEMENT_ID; ?>';
									var disqus_domain = 'disqus.com';
									var disqus_shortname = '<?php echo DISQUS_SHORTNAME; ?>';
									var disqus_title = "<?php echo $products_name; ?>";
									var disqus_config = function () {
									var config = this; // Access to the config object
								
										/*
										   All currently supported events:
											* preData ?fires just before we request for initial data
											* preInit - fires after we get initial data but before we load any dependencies
											* onInit  - fires when all dependencies are resolved but before dtpl template is rendered
											* afterRender - fires when template is rendered but before we show it
											* onReady - everything is done
										 */
								
										config.callbacks.preData.push(function() {
											// clear out the container (its filled for SEO/legacy purposes)
											document.getElementById(disqus_container_id).innerHTML = '';
										});
								
									};
								</script>
								<script type="text/javascript">
								(function() {
									var dsq = document.createElement('script'); dsq.type = 'text/javascript';
									dsq.async = true;
									dsq.src = 'https://' + disqus_shortname + '.' + disqus_domain + '/embed.js';
									(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
								})();
								</script>
								<?php } ?>
								<!--End Disqus http://www.samuelsena.com/zen-cart-disqus-comment-system/-->
							</div>
						</div>
					</div>
				</div> <!--eof Product_info left wrapper -->
			</div>
		</div>
	</section>
   	
    <section class="content">
		<!--bof also purchased products module-->
		<?php require($template->get_template_dir('tpl_modules_also_purchased_products.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_also_purchased_products.php');?>
		<!--eof also purchased products module-->
	</section>
	<section class="content">
		<!--bof also related products module-->
		<?php require($template->get_template_dir('tpl_modules_related_products.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_related_products.php');?>
		<!--eof also related products module-->
	</section>

	<section class="content">
		<!--bof also new products module-->
		<?php require($template->get_template_dir('tpl_modules_whats_new.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_whats_new.php');?>
		<!--eof also new products module-->
	</section>

	<section class="content">
		<!--bof also special products module-->
		<?php require($template->get_template_dir('tpl_modules_specials_default.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_specials_default.php');?>
		<!--eof also special products module-->
	</section>

    <!--bof Prev/Next bottom position -->
    <?php if (PRODUCT_INFO_PREVIOUS_NEXT == 2 or PRODUCT_INFO_PREVIOUS_NEXT == 3) { ?>
    <?php
    /**
     * display the product previous/next helper
     */
     require($template->get_template_dir('/tpl_products_next_previous.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_products_next_previous.php'); ?>
    <?php } ?>
    <!--eof Prev/Next bottom position -->
    
    <!--bof Form close-->
    </form>
    <!--bof Form close-->
</div>