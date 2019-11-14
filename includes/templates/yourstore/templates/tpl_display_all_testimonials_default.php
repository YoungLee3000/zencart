<?php
/**
 * Testimonials Manager
 *
 * @package Template System
 * @copyright 2007 Clyde Jones
  * @copyright Portions Copyright 2003-2007 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Testimonials_Manager.php v1.5.4
 */
 
?>
<div class="centerColumn" id="testimonialDefault">
	<div class="title-box">
		<h2 class="title-under text-uppercase text-center"><?php echo HEADING_TITLE; ?></h2>
	</div>

	<?php
	//  $testimonials_query_raw = "select * from " . TABLE_TESTIMONIALS_MANAGER . " where status = 1 and language_id = '" . (int)$_SESSION['languages_id'] . "' order by date_added DESC, testimonials_title";
	//  $testimonials_split = new splitPageResults($testimonials_query_raw, MAX_DISPLAY_TESTIMONIALS_MANAGER_ALL_TESTIMONIALS);
	if (($testimonials_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3'))) {
	?>
	<div class="pageresult_top filters-row">
		<div id="productsListingTopNumber" class="navSplitPagesResult back">
			<?php echo $testimonials_split->display_count(TEXT_DISPLAY_NUMBER_OF_TESTIMONIALS_MANAGER_ITEMS); ?>
		</div>
		<div id="productsListingListingTopLinks" class="navSplitPagesLinks forward filters-row__pagination">
			<ul class="pagination"><?php echo TEXT_RESULT_PAGE . ' ' . $testimonials_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page')), $paginateAsUL); ?></ul>
		</div>
	</div>
	<?php
		} // split page
	?>
	<?php
			//echo $testimonials_split->sql_query;
			$testimonials = $db->Execute($testimonials_split->sql_query);
			while (!$testimonials->EOF) {
				$date_published = $testimonials->fields['date_added'];
				$testimonial_info = '';
				if ( (!empty($testimonials->fields['testimonials_city'])) and (!empty($testimonials->fields['testimonials_country'])) ) {
				$testimonial_info .= NAME_SEPARATOR . $testimonials->fields['testimonials_city'] . CITY_STATE_SEPARATOR . $testimonials->fields['testimonials_country'];
				}
				if ( (!empty($testimonials->fields['testimonials_city'])) and (empty($testimonials->fields['testimonials_country'])) ) {
				$testimonial_info .= NAME_SEPARATOR . $testimonials->fields['testimonials_city'];
				}
				if ( (empty($testimonials->fields['testimonials_city'])) and (!empty($testimonials->fields['testimonials_country'])) ) {
				$testimonial_info .= NAME_SEPARATOR . $testimonials->fields['testimonials_country'];
				}
				if (!empty($testimonials->fields['testimonials_company'])) {
				$testimonial_info .= NAME_SEPARATOR . $testimonials->fields['testimonials_company'];
				}
	?>
	<div class="card card--padding">
		<div class="row">
			<?php
				if (($testimonials->fields['testimonials_image']) != ('')) {
					$testimonials_image = zen_image(DIR_WS_IMAGES . $testimonials->fields['testimonials_image'], $testimonials->fields['testimonials_title'], TESTIMONIAL_IMAGE_WIDTH, TESTIMONIAL_IMAGE_HEIGHT);
				}
				else {
					$testimonials_image = zen_image(DIR_WS_IMAGES . 'no_picture.gif', $testimonials->fields['testimonials_title'], TESTIMONIAL_IMAGE_WIDTH, TESTIMONIAL_IMAGE_HEIGHT);
				}
			?>
						<div class="testimonialImage col-lg-3 col-md-3 col-sm-4 col-xs-12">
							<?php if (($testimonials->fields['testimonials_url']) == ('http://') or ($testimonials->fields['testimonials_url']) == ('')) {
								echo $testimonials_image;
							} else {
								echo '<a href="' . $testimonials->fields['testimonials_url'] . '" target="_blank">' . $testimonials_image . '</a>';
							}
							?>
						</div>
						<div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 product-review-default">
							<h4><a href="<?php echo zen_href_link(FILENAME_TESTIMONIALS_MANAGER, 'testimonials_id=' . $testimonials->fields['testimonials_id'], 'SSL');?>"><?php echo $testimonials->fields['testimonials_title'];?></a></h4>
							<p>
								<?php echo '<i class="fa fa-quote-left"></i>' . nl2br($testimonials->fields['testimonials_html_text']); ?>
							</p>
							<footer>
								<?php echo TESTIMONIALS_BY; ?><strong><?php echo $testimonials->fields['testimonials_name']; ?></strong> 
								<?php echo $testimonial_info; ?> 
								<?php if (DISPLAY_TESTIMONIALS_DATE_PUBLISHED == 'true') { echo '<br/>'.zen_date_long($date_published); } ?>
							</footer>
						</div>
		</div>
	</div>
	<?php
			$testimonials->MoveNext();
		}
	?>
	<?php
		if (($testimonials_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) {
	?>
	<div class="pageresult_bottom filters-row">
		<div id="productsListingBottomNumber" class="navSplitPagesResult back">
			<?php echo $testimonials_split->display_count(TEXT_DISPLAY_NUMBER_OF_TESTIMONIALS_MANAGER_ITEMS); ?>
		</div>
		<div id="productsListingListingBottomLinks" class="navSplitPagesLinks forward filters-row__pagination">
			<ul class="pagination"><?php echo TEXT_RESULT_PAGE . ' ' . $testimonials_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page')), $paginateAsUL); ?></ul>
		</div>
	</div>
	<?php
		} // split page
	?>
	<div class="testimonial-links">
		<div class="buttonRow back btn btn--ys">
			<?php echo zen_back_link() . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) . '</a>'; ?>
		</div>
		<div class="buttonRow forward">
			<a class="btn btn--ys" href="<?php echo zen_href_link(FILENAME_TESTIMONIALS_ADD, '', 'SSL'); ?>"><?php echo zen_image_button(BUTTON_IMAGE_TESTIMONIALS, BUTTON_TESTIMONIALS_ADD_ALT); ?></a>
		</div>
	</div>
</div>
