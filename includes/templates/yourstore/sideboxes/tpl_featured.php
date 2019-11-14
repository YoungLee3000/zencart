<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_featured.php 18698 2011-05-04 14:50:06Z wilt $
 */
  $content = "";
  $content .= '<div class="sideBoxInnerContent">';
  $content .= '<div class="vertical-carousel featuredSidebox offset-top-10">';
  $featured_box_counter = 0;

  while (!$random_featured_product->EOF) {
	  $featured_name=$random_featured_product->fields['products_name'];
		//$featured_name=ltrim(substr($featured_name, 0, 20));
    $featured_box_counter++;
    $featured_box_price = zen_get_products_display_price($random_featured_product->fields['products_id']);
    $content .= '<div class="vertical-carousel__item">
									<div class="vertical-carousel__item__image pull-left">
										<a href="' . zen_href_link(zen_get_info_page($random_featured_product->fields["products_id"]), 'cPath=' . zen_get_generated_category_path_rev($random_featured_product->fields["master_categories_id"]) . '&products_id=' . $random_featured_product->fields["products_id"], 'SSL') . '">'
											. zen_image(DIR_WS_IMAGES . $random_featured_product->fields['products_image'], $featured_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) .
										'</a>
									</div>
									<div class="vertical-carousel__item__title">
										<h2>
											<a href="' . zen_href_link(zen_get_info_page($random_featured_product->fields["products_id"]), 'cPath=' . zen_get_generated_category_path_rev($random_featured_product->fields["master_categories_id"]) . '&products_id=' . $random_featured_product->fields["products_id"], 'SSL') . '">'
												. $featured_name .
											'</a>
										</h2>
									</div>
									<div class="price-box">'
										. $featured_box_price .
									'</div>
								</div>';
    $random_featured_product->MoveNextRandom();
  }
  $content .= '</div></div>';
