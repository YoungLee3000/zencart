<?php
/**
 * Page Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_product_reviews_default.php 4852 2006-10-28 06:47:45Z drbyte $
 */

?>
<div class="centerColumn" id="reviewsDefault">
	<div class="title-box">
		<h2 class="title-under text-uppercase text-center"><?php echo TEXT_PRODUCT_REVIEW;?><?php //echo $products_name; //. $products_model; ?></h2>
	</div>
	<?php
      if ($reviews_split->number_of_rows > 0) {
        if ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3')) {
            $reviewsplit = $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_REVIEWS);
            if($reviewsplit == '')
            {
            
            }
            else
            {
    ?>
	<div class="pageresult_top filters-row">
		<div id="productReviewsDefaultListingTopNumber" class="navSplitPagesResult">
			<?php echo $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_REVIEWS); ?>
        </div>
		<?php if($reviews_split->number_of_pages > 1) { //to hide the pagination div if no. of pages < 1 ?>
		<div id="productReviewsDefaultListingTopLinks" class="navSplitPagesLinks filters-row__pagination">
			<ul class="pagination"><?php echo TEXT_RESULT_PAGE . ' ' . $reviews_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'main_page')), $paginateAsUL); ?></ul>
        </div>
	</div>
		<?php
                }
            }
        }
        ?>
		<div class="reviews-list">
		<?php 
            foreach ($reviewsArray as $reviews) {
				//print_r($reviews);
        ?> 
        	<div class="card card--padding">
            	<div class="row product-details-review">
            		<div class="smallProductImage back col-lg-3 col-md-3 col-sm-3 col-xs-12">
                		<?php echo '<a href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . (int)$_GET['products_id'] . '&reviews_id='. $reviews['id'], 'SSL') . '">' . zen_image(DIR_WS_IMAGES . $products_image, $product_name, MEDIUM_IMAGE_WIDTH, MEDIUM_IMAGE_HEIGHT) . '</a>'; ?>
            		</div>
                	<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 product-review-default">
                    	<h4>
                    		<?php echo '<a data-toggle="tooltip" data-original-title="'.TITLE_PRODUCT_DETAILS.'" href="' . zen_href_link(zen_get_info_page($_GET['products_id']), zen_get_all_get_params(array('reviews_id')), 'SSL') . '">' . $products_name . '</a>'; ?>
                    	</h4>
						<?php $product_review = $reviews['reviewsText'];
                            $product_review = ltrim(substr($product_review, 0, 250) . '...'); //Trims and Limits the Review
                        ?>
                    	<p>
                    		<?php echo '<i class="fa fa-quote-left"></i>' . $product_review . '<a class="more_info_text" data-toggle="tooltip" data-original-title="'.TEXT_READ_REVIEW.'" href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . (int)$_GET['products_id'] . '&reviews_id='. $reviews['id'], 'SSL') . '">'.TEXT_READ_MORE.'</a>'; ?>
                    	</p>
                    	<footer>
                        	<strong><?php echo sprintf(zen_output_string_protected($reviews['customersName'])); ?></strong>, 
                        	<?php echo sprintf(zen_date_short($reviews['dateAdded'])); ?>
                        	<br/>
							<span class="reviews_default">
                        	<?php echo zen_image(DIR_WS_TEMPLATE_IMAGES . 'stars_' . $reviews['reviewsRating'] . '.png', sprintf(TEXT_OF_5_STARS, $reviews['reviewsRating'])) .'<span class="reviews_text">'. sprintf(TEXT_OF_5_STARS, $reviews['reviewsRating']).'</span>'; ?>
							</span>
                    	</footer>
                	</div>
        		</div> <!--productreviews-wrapper ends -->
			</div>       
			<?php
                }
            ?>
		</div>
	<?php   } else {
	?>
	<div id="productReviewsDefaultNoReviews" class="card card--padding">
		<?php echo TEXT_NO_REVIEWS . (REVIEWS_APPROVAL == '1' ? '<br />' . TEXT_APPROVAL_REQUIRED: ''); ?>
    </div>
	<br class="clearBoth" />
	<?php
      } 
    ?>
	<?php  if (($reviews_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) {
		$reviewsplit = $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_REVIEWS);
		if($reviewsplit == '')
			{
			}
		else
			{
	?>
	<div class="pageresult_bottom filters-row">
		<div id="productReviewsDefaultListingBottomNumber" class="navSplitPagesResult">
			<?php echo $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_REVIEWS); ?>
		</div>
		<?php if($reviews_split->number_of_pages > 1) { //to hide the pagination div if no. of pages < 1 ?>
		<div id="productReviewsDefaultListingBottomLinks" class="navSplitPagesLinks filters-row__pagination">
			<ul class="pagination"><?php echo TEXT_RESULT_PAGE . ' ' . $reviews_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'main_page')), $paginateAsUL); ?></ul>
		</div>
	</div>
	<?php
    }
      }
    }
    ?>
</div>
