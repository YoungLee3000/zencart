<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_reviews_random.php 16044 2010-04-23 01:15:45Z drbyte $
 */
  $content = "";
  $review_box_counter = 0;
  $content .= '<div class="sideBoxInnerContent">';
   $content .= '<div class="vertical-carousel vertical-carousel-1 offset-top-10">';
  while (!$random_review_sidebox_product->EOF) {
    $review_box_counter++;
    $content .= '<div class="vertical-carousel__item '.str_replace('_', '-', $box_id . 'Content').'">
                  <div class="vertical-carousel__item__image pull-left">
                    <a href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . $random_review_sidebox_product->fields['products_id'] . '&reviews_id=' . $random_review_sidebox_product->fields['reviews_id'], 'SSL') . '">'
                      . zen_image(DIR_WS_IMAGES . $random_review_sidebox_product->fields['products_image'], $random_review_sidebox_product->fields['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) .
                    '</a>
                  </div>
                  <div class="vertical-carousel__item__title">
                    <h2>
                      <a href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . $random_review_sidebox_product->fields['products_id'] . '&reviews_id=' . $random_review_sidebox_product->fields['reviews_id'], 'SSL') . '">'
                        . zen_trunc_string(nl2br(zen_output_string_protected(stripslashes($random_review_sidebox_product->fields['reviews_text']))), 60) .
                      '</a>
                    </h2>
                  </div>
                  <div class="rating">'
                    . zen_image(DIR_WS_TEMPLATE_IMAGES . 'stars_' . $random_review_sidebox_product->fields['reviews_rating'] . '_small.png' , sprintf(BOX_REVIEWS_TEXT_OF_5_STARS, $random_review_sidebox_product->fields['reviews_rating'])).
                  '</div>
                 </div>';
    $random_review_sidebox_product->MoveNextRandom();
  }
  $content .= '</div></div>';
