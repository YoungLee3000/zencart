<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_best_sellers.php 2982 2006-02-07 07:56:41Z birdbrain $
 */
  $content = '';
  
    
  $content .= '<div id="' . str_replace('_', '-', $box_id . 'Content') . '" class="coll-gallery"></div>' . "\n";
  $content .= '<div class="coll-gallery-clone" style="display:none">
								<div class="vertical-carousel vertical-carousel-2 offset-top-10">';
  for ($i=1; $i<=sizeof($bestsellers_list); $i++) {
    
	$bestsellers_name=$bestsellers_list[$i]['name'];
    //$bestsellers_name=ltrim(substr($bestsellers_name, 0, 20));
	$bestsellers_list_price = zen_get_products_display_price($bestsellers_list[$i]['id']);
    $content .=  '<div class="vertical-carousel__item">
										<div class="vertical-carousel__item__image pull-left">
											<a href="' . zen_href_link(zen_get_info_page($bestsellers_list[$i]['id']), 'products_id=' . $bestsellers_list[$i]['id'], 'SSL') . '">'
												. zen_image(DIR_WS_IMAGES . $bestsellers_list[$i]['products_image'], $bestsellers_list[$i]['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) .
											'</a>
										</div>
										<div class="vertical-carousel__item__title">
											<h2>
												<a href="' . zen_href_link(zen_get_info_page($bestsellers_list[$i]['id']), 'products_id=' . $bestsellers_list[$i]['id'], 'SSL') . '">' . zen_trunc_string($bestsellers_name, BEST_SELLERS_TRUNCATE, BEST_SELLERS_TRUNCATE_MORE) .
												'</a>
											</h2>
										</div>
										<div class="price-box">'
											. $bestsellers_list_price .
										'</div>
									</div>'; }
  $content .= '</div>';
  $content .= '</div>';
?>