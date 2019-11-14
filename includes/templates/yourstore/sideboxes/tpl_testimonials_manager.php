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
$content = '';
  $content .= '<div id="' . str_replace('_', '-', $box_id . 'Content') . '" class="sideBoxInnerContent fill-bg-custom aside-inner color-white">';
  $content .='<div class="testimonialsAsid nav-dot nav-dot-invert">';
  for ($i=1; $i<=sizeof($page_query_list); $i++) {
    $content .= '<a href="' . zen_href_link(FILENAME_TESTIMONIALS_MANAGER, 'testimonials_id=' . $page_query_list[$i]['id'], 'SSL') . '" class="link-hover-block">
                  <div class="text-center">';
                    if ($page_query_list[$i]['image'] != '') { 
					 $content .= zen_image(DIR_WS_IMAGES . $page_query_list[$i]['image'], $page_query_list[$i]['name'], TESTIMONIAL_IMAGE_WIDTH, TESTIMONIAL_IMAGE_HEIGHT, 'class="img-responsive-inline"') ;  
					}
					else {
						$content .= zen_image(DIR_WS_IMAGES . 'no_picture.gif', $page_query_list[$i]['name'], TESTIMONIAL_IMAGE_WIDTH, TESTIMONIAL_IMAGE_HEIGHT, 'class="img-responsive-inline"') ;  
					}
                    if (DISPLAY_TESTIMONIALS_MANAGER_TRUNCATED_TEXT == 'true') {
                      $content .= '<p><span class="icon"></span>' 
                                    . zen_trunc_string($page_query_list[$i]['story'],TESTIMONIALS_MANAGER_DESCRIPTION_LENGTH) . 
                                    '</p>
                                    <p> 
                                      <b>'. $page_query_list[$i]['name'] . '</b>
                                      <em>'. $page_query_list[$i]['by'] . '</em>
                                    </p>';
                    }
              $content .= '</div></a>';
    }
    $content .= '</div>';
  $content .= '</div>';
  if (DISPLAY_ALL_TESTIMONIALS_TESTIMONIALS_MANAGER_LINK == 'true') {
    $content .= '<div class="bettertestimonial text-center"><a class="btn btn--ys btn--xs" href="' . zen_href_link(FILENAME_TESTIMONIALS_MANAGER_ALL, '', 'SSL') . '">' . TESTIMONIALS_MANAGER_DISPLAY_ALL_TESTIMONIALS . '</a></div>';
   }
    if (DISPLAY_ADD_TESTIMONIAL_LINK == 'true') {
    $content .= '<div class="bettertestimonial text-center"><a class="btn btn--ys btn--xs" href="' . zen_href_link(FILENAME_TESTIMONIALS_ADD, '', 'SSL') . '">' . TESTIMONIALS_MANAGER_ADD_TESTIMONIALS . '</a></div>';
   }
//EOF