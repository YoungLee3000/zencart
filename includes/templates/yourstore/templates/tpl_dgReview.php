<?php 
// dgReviews v 1.01
//Modified to work with version v1.3.6  of the dgcart
// This is a quick down and dirty mod to add product reviews onto the product info page
// by MichaelDuvall.com
?>
	<!-- bof: dgReviews-->
<?php
//change this constant to change the title for the customer reviews
  $review_title = 'Customer Reviews';
  $review_display_limit = '3';
  
 $review_status = " and r.status = '1'";
  /* This is where you change the parameter value to output 1000 charaters or equivelent */
  $reviews_query_raw = "select r.reviews_id, left(rd.reviews_text, 1000) as reviews_text,
                               r.reviews_rating, r.date_added, r.customers_name
                        from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd
                        where r.products_id = '" . (int)$_GET['products_id'] . "'
                        and r.reviews_id = rd.reviews_id
                        and rd.languages_id = '" . (int)$_SESSION['languages_id'] . "'" .
                        $review_status . "
                        order by r.date_added";
	$reviews_split = new splitPageResults($reviews_query_raw, $review_display_limit);

    $reviews = $db->Execute($reviews_split->sql_query);

    while (!$reviews->EOF) {
?>
  <?php // change the class name here to reflect your CSS page ?>
	<div class="product_info_ratings">
        <h3>
            <?php echo sprintf(TEXT_REVIEW_BY, zen_output_string_protected($reviews->fields['customers_name'])); ?>
        </h3>
        <p class="text">
        	<span class="product-rating">
        	<?php 
            	echo sprintf(zen_image(DIR_WS_TEMPLATE_IMAGES . 'stars_' . $reviews->fields['reviews_rating'] . '_small.png'));
           	?>
       		</span>
       		<?php echo zen_break_string(zen_output_string_protected(stripslashes($reviews->fields['reviews_text'])), 35, '-<br />')?>
        </p>
	</div>
<?php
      $reviews->MoveNext();
    }
?>
<?php //this is the end of dgReview?>