<div id="wishlist"> <!-- begin wishlist id for styling -->
	<div class="title-box">
		<h2 class="title-under text-uppercase text-center"><?php echo TEXT_WISHLIST_FOR . '<b>'.$customers_name.'</b>'; ?></h2>
	</div>
    <!-- control -->
    <?php echo zen_draw_form('control', zen_href_link(UN_FILENAME_WISHLIST_FIND, '', 'SSL'), 'get', 'class="control"'); ?>
    <?php echo zen_hide_session_id(); ?>
    <?php echo zen_draw_hidden_field('main_page', UN_FILENAME_WISHLIST_FIND); ?>
    <?php echo zen_draw_hidden_field('wid', $wid); ?>

	<div class="sorter filters-row">
		<div class="multiple">
			<label for="sort"><?php echo UN_TEXT_SORT . UN_LABEL_DELIMITER; ?></label>
			<div class="select-wrapper">
				<?php 
					echo zen_draw_pull_down_menu('sort', $aSortOptions, (isset($_GET['sort']) ? $_GET['sort'] : ''), 'class="m" onchange="this.form.submit()"');
				?>
			</div>
		</div>
	
		<?php if ( UN_DISPLAY_CATEGORY_FILTER===true ) { ?>
		<div class="multiple">
			<label for="cPath"><?php echo UN_TEXT_SHOW . UN_LABEL_DELIMITER; ?></label>
			<div class="select-wrapper">
				<?php
					echo un_draw_categories_pull_down_menu('cPath', UN_TEXT_ALL_CATEGORIES, (isset($_GET['cPath']) ? $_GET['cPath'] : ''), 'class="m" onchange="this.form.submit()"');
				?>
			</div>
		</div>
		<?php } ?>
		<div class="multiple">
			<label for="layout"><?php echo UN_TEXT_VIEW . UN_LABEL_DELIMITER; ?></label>
			<div class="select-wrapper">
				<?php 
					echo un_draw_view_pull_down_menu('layout', '', (isset($_GET['layout']) ? $_GET['layout'] : ''), 'class="m" onchange="this.form.submit()"');
				?>
			</div>
		</div>
	</div>
    </form>
        <!-- control -->		

		<?php echo zen_draw_form('wishlist', zen_href_link(UN_FILENAME_WISHLIST_FIND, zen_get_all_get_params(array('action')) . 'action=multiple_products_add_product', 'SSL')); ?>
        <?php echo zen_hide_session_id(); ?>
        <?php echo zen_draw_hidden_field('layout', isset($_REQUEST['layout'])? $_REQUEST['layout']: ''); ?>
        <?php echo zen_draw_hidden_field('wid', $wid); ?>

		<!-- product listing -->
		<!--<div class="tableheading"><?php //echo TEXT_LISTING_TYPE; ?></div>-->
		<?php
        if ($listing_split->number_of_rows > 0) {
            $rows = 0;
            $products = $db->Execute($listing_split->sql_query);
            while (!$products->EOF) {
                if ( $rows & 1 ) {
                    $tdclass = 'even';
                } else {
                    $tdclass = 'odd';
                }
                $products_price = zen_get_products_display_price($products->fields['products_id']);
        ?>

		<div class="wishlist<?php echo (!un_is_empty($tdclass)? '-'.$tdclass: ''); ?>">
		
			<!-- buttons -->
			<?php //echo '<a href="' . zen_href_link($_GET['main_page'], zen_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $products->fields['products_id']) . '" title="'.BUTTON_IN_CART_ALT.'">' . zen_image_button(BUTTON_IMAGE_IN_CART, BUTTON_IN_CART_ALT, 'style="float: right; margin-left: 5px; padding: 0;"') . '</a>'; ?>
			<?php
            	$the_button = '<a class="btn btn--ys" href="' . zen_href_link($_GET['main_page'], zen_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $products->fields['products_id'], 'SSL') . '" title="'.BUTTON_IN_CART_ALT.'">' . zen_image_button(BUTTON_IMAGE_IN_CART, BUTTON_IN_CART_ALT) . '</a>';
  				
				$display_button = zen_get_buy_now_button($products->fields['products_id'], $the_button);
				
				$products_description = zen_trunc_string(zen_clean_html(stripslashes(zen_get_products_description($products->fields['products_id'], $_SESSION['languages_id']))), PRODUCT_LIST_DESCRIPTION);
				$products_description = ltrim(substr($products_description, 0, 250) . '');
				$moreinfo = '<a class="more_info_text" href="' . zen_href_link(zen_get_info_page($products->fields['products_id']), 'cPath=' . zen_get_generated_category_path_rev($products->fields['master_categories_id']) . '&products_id=' . $products->fields['products_id'], 'SSL') . '">'.MORE_INFO_TEXT.'</a>';
  			?>
			
            
            <!-- product data -->
        	<div id="productListing" class="product-listing row row-view">
				<div class="products-container product-list">
					<div class="product ">
						<div class="product__inside">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 no-padding">
								<div class="product__inside__image">
									<?php echo '<a href="' . zen_href_link(zen_get_info_page($products->fields['products_id']), 'products_id=' . $products->fields['products_id'], 'SSL') . '">'.zen_image(DIR_WS_IMAGES . $products->fields['products_image'], $products->fields['products_name'], IMAGE_PRODUCT_LISTING_WIDTH, IMAGE_PRODUCT_LISTING_HEIGHT, '').'</a>'; ?>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 no-padding">
								<div class="product__inside__name">
									<h2>
										<a href="<?php echo zen_href_link(zen_get_info_page($products->fields['products_id']), 'products_id=' . $products->fields['products_id'], 'SSL');?>"> <?php echo $products->fields['products_name']; ?> </a>
									</h2>
								</div>
								<div class="product__inside__description row-mode-visible">
									<?php if ( SHOW_PRODUCT_INFO_DATE_AVAILABLE && ( $products->fields['products_date_available'] > date('Y-m-d H:i:s') ) ) { ?>
									<div class="notabene"><?php echo sprintf(UN_TEXT_DATE_AVAILABLE, zen_date_short($products->fields['products_date_available'])); ?></div>
									<?php } ?>
									<!-- wishlist data -->
									<div class="wishlistfields">
										<ul class="simple-list">
											<?php if ( $products->fields['date_added'] ) { ?>
											<li>
												<?php echo UN_TEXT_DATE_ADDED . UN_LABEL_DELIMITER; ?>
												<?php echo zen_date_short($products->fields['date_added']); ?>
											</li>
											<?php } ?>
											<li>
												<?php echo UN_TEXT_QUANTITY . UN_LABEL_DELIMITER; ?> 
												<?php echo $products->fields['quantity']; ?>
											</li>
											<li>
												<?php echo UN_TEXT_COMMENT . UN_LABEL_DELIMITER; ?>
												<?php echo $products->fields['comment']; ?>
											</li>
											<li>
												<?php echo UN_TEXT_PRIORITY . UN_LABEL_DELIMITER; ?>
												<?php echo $products->fields['priority']; ?>
											</li>
										</ul>
									</div> <!-- end div.wishlistfields -->
								</div>
								<div class="product__inside__price price-box">
									<?php echo ((zen_has_product_attributes_values((int)$products->fields['products_id']) and $flag_show_product_info_starting_at == 1) ? TEXT_BASE_PRICE : '') . $products_price; ?>
								</div>
								<div class="product__inside__hover">
									<div class="product__inside__info">
										<div class="product__inside__info__btns">
											<?php if ( $display_button != '') { ?>
											<?php
												echo $display_button;
											?>	
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
								
                        </div>
                   	</div>
				</div>
			</div>
		</div> <!-- end div.wishlist -->
		<?php $rows ++; ?>
		<?php $products->MoveNext(); ?>
	<?php } // end while products ?>
	
<?php } else { ?>
	<div class="alert alert-danger alert-dismissable">
		<?php echo UN_TEXT_NO_PRODUCTS; ?>
   	</div>
<?php } // end if products ?>
<!-- end product listing -->
</form>

<?php if (($listing_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) { ?>

	<div class="sorter filters-row">
		<div class="navSplitPagesResult back"><?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></div>	
		<div class="navSplitPagesLinks forward filters-row__pagination">
			<ul class="pagination">
				<?php echo TEXT_RESULT_PAGE . ' ' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'wid')) . '&wid=' . $wid, $paginateAsUL); ?>
			</ul>
		</div>
	</div>

<?php } // end paging bottom ?>

<div class="buttons">
<?php echo zen_back_link() . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) . '</a>'; ?>
</div>

</div> <!-- end (un) id for styling -->