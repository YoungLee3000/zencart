<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_specials.php 18698 2011-05-04 14:50:06Z wilt $
 */
  $content = "";
  $content .= '<div class="sideBoxInnerContent centeredContent">';
  $content .= '<div class="vertical-carousel specialsSidebox offset-top-10">';
  $specials_box_counter = 0;
  while (!$random_specials_sidebox_product->EOF) {
    $specials_box_counter++;
    $specials_box_price = zen_get_products_display_price($random_specials_sidebox_product->fields['products_id']);
    $content .= '<div class="vertical-carousel__item">
                  <div class="vertical-carousel__item__image pull-left">
                    <a href="' . zen_href_link(zen_get_info_page($random_specials_sidebox_product->fields["products_id"]), 'cPath=' . zen_get_generated_category_path_rev($random_specials_sidebox_product->fields["master_categories_id"]) . '&products_id=' . $random_specials_sidebox_product->fields["products_id"], 'SSL') . '">'
                      . zen_image(DIR_WS_IMAGES . $random_specials_sidebox_product->fields['products_image'], $random_specials_sidebox_product->fields['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) .
                    '</a>
                  </div>
                  <div class="vertical-carousel__item__title">
                    <h2>
                      <a href="' . zen_href_link(zen_get_info_page($random_specials_sidebox_product->fields["products_id"]), 'cPath=' . zen_get_generated_category_path_rev($random_specials_sidebox_product->fields["master_categories_id"]) . '&products_id=' . $random_specials_sidebox_product->fields["products_id"], 'SSL') . '">'
                        . $random_specials_sidebox_product->fields['products_name'] .
                      '</a>
                    </h2>
                  </div>
                  <div class="price-box">'
                    . $specials_box_price .
                  '</div>
                </div>';
    $random_specials_sidebox_product->MoveNextRandom();
  }
  $content .= '</div></div>';
