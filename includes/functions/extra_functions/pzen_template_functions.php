<?php
// Save for later functions.  
// Derived from Zen Cart logic by that Software Guy.
// Some portions Copyright 2003-2007 Zen Cart Development Team

// called from shopping cart template to replicate get_contents().
 

////// Get ul li
 function pzen_get_categories($categories_array = '', $parent_id = '0', $indent = '') {
    global $db;

    if (!is_array($categories_array)) $categories_array = array();

    $categories_query = "select c.categories_id, cd.categories_name
                         from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
                         where parent_id = '" . (int)$parent_id . "'
                         and c.categories_id = cd.categories_id
                         and cd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                         order by sort_order, cd.categories_name";

    $categories = $db->Execute($categories_query);

    while (!$categories->EOF) {
      $categories_array[] = array('id' => $categories->fields['categories_id'],
                                  'text' => $indent . $categories->fields['categories_name']);

      if ($categories->fields['categories_id'] != $parent_id) {
        $categories_array = zen_get_categories($categories_array, $categories->fields['categories_id'], $indent . '&nbsp;&nbsp;');
      }
      $categories->MoveNext();
    }

    return $categories_array;
}

function pzen_special_product($prod_id){
	global $db;
	$listing_sql="select p.products_id, p.products_image, pd.products_name, p.master_categories_id
                           from (" . TABLE_PRODUCTS . " p
                           left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id
                           left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id )
                           where p.products_id = s.products_id
                           and p.products_id = pd.products_id
                           and p.products_status = '1' and s.status = 1
                           and pd.language_id = '" . (int)$_SESSION['languages_id'] . "' and p.products_id='".$prod_id."' ";
	$listing_res = $db->Execute($listing_sql);
	return $listing_res->RecordCount();
	
}

function pzen_featured_product($prod_id)
{
	global $db;
	$featured_sql="select p.products_id, p.products_image, pd.products_name, p.master_categories_id
                           from (" . TABLE_PRODUCTS . " p
                           left join " . TABLE_FEATURED . " s on p.products_id = s.products_id
                           left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id )
                           where p.products_id = s.products_id
                           and p.products_id = pd.products_id
                           and p.products_status = '1' and s.status = 1
                           and pd.language_id = '" . (int)$_SESSION['languages_id'] . "' and p.products_id='".$prod_id."' ";
	$featured_res = $db->Execute($featured_sql);
	return $featured_res->RecordCount();
	
}

function pzen_new_product($products_ar){
	global $db;
	$products_date_available = (isset($products_ar['products_date_available']))? $products_ar['products_date_available'] : '';
	$products_date_added = (isset($products_ar['products_date_added']))? $products_ar['products_date_added'] : '';
	$new_range = 0;
	if($products_date_added !='' || $products_date_available!=''){
		$time_limit=false;
		if ($time_limit == false) {
		  $time_limit = SHOW_NEW_PRODUCTS_LIMIT;
		}
		// 120 days; 24 hours; 60 mins; 60secs
		$date_range = time() - ($time_limit * 24 * 60 * 60);
		$upcoming_mask_range = time();
		$upcoming_mask = date('Ymd', $upcoming_mask_range);

		// echo 'Now:      '. date('Y-m-d') ."<br />";
		// echo $time_limit . ' Days: '. date('Ymd', $date_range) ."<br />";
		$zc_new_date = date('Ymd', $date_range);
		switch (true) {
		case (SHOW_NEW_PRODUCTS_LIMIT == 0):
			$new_range = 1;
			break;
		case (SHOW_NEW_PRODUCTS_LIMIT == 1):
			$zc_new_date = date('Ym', time()) . '01';
			if($products_date_added >= $zc_new_date){
				$new_range = 1;
			}
			//$new_range = ' and p.products_date_added >=' . $zc_new_date;
			break;
		default:
			if($products_date_added >= $zc_new_date){
				$new_range = 1;
			}
			//$new_range = ' and p.products_date_added >=' . $zc_new_date;
		}

		if (SHOW_NEW_PRODUCTS_UPCOMING_MASKED == 0) {
		  // do nothing upcoming shows in new
		}else {
		  // do not include upcoming in new
			if($products_date_available <= $upcoming_mask || $products_date_available==''){
				$new_range=1;
			}
		  //$new_range .= " and (p.products_date_available <=" . $upcoming_mask . " or p.products_date_available IS NULL)";
		}
		return $new_range;
	}
}
function pzen_specials_product($prod_id)
{
	global $db;
	 $specials_index_query = "select p.products_id, p.products_image, pd.products_name, p.master_categories_id
                           from (" . TABLE_PRODUCTS . " p
                           left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id
                           left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id )
                           where p.products_id = s.products_id
                           and p.products_id = pd.products_id
                           and p.products_status = '1' and s.status = 1
                           and pd.language_id = '" . (int)$_SESSION['languages_id'] . "' and p.products_id='".$prod_id."'";
		$listing_res = $db->Execute($specials_index_query);
	return $listing_res->RecordCount();
}
function pzen_display_banner($action, $identifier) {
    global $db, $request_type;

    switch ($request_type) {
      case ('SSL'):
        $my_banner_filter=" and banners_on_ssl= " . "1 ";
        break;
      case ('NONSSL'):
        $my_banner_filter='';
        break;
    }

    if ($action == 'dynamic') {
      $new_banner_search = zen_build_banners_group($identifier);

      $banners_query = "select count(*) as count
                        from " . TABLE_BANNERS . "
                           where status = '1' " .
                           $new_banner_search . $my_banner_filter;

      $banners = $db->Execute($banners_query);

      if ($banners->fields['count'] > 0) {
        $banner = $db->Execute("select  banners_id, banners_title, banners_image, banners_html_text, banners_open_new_windows, banners_url
                               from " . TABLE_BANNERS . "
                               where status = 1 " .
                               $new_banner_search . $my_banner_filter . " order by banners_id");

      } else {
        return '<p class="alert">ZEN ERROR! (zen_display_banner(' . $action . ', ' . $identifier . ') -> No banners with group \'' . $identifier . '\' found!</p>';
      }
    } elseif ($action == 'static') {
      if (is_object($identifier)) {
        $banner = $identifier;
      } else {
        $banner_query = "select banners_id, banners_title, banners_image, banners_html_text, banners_open_new_windows, banners_url
                         from " . TABLE_BANNERS . "
                         where status = 1
                         and banners_id = '" . (int)$identifier . "'" . $my_banner_filter;

        $banner = $db->Execute($banner_query);

        if ($banner->RecordCount() < 1) {
          //return '<strong>ZEN ERROR! (zen_display_banner(' . $action . ', ' . $identifier . ') -> Banner with ID \'' . $identifier . '\' not found, or status inactive</strong>';
        }
      }
    } else {
      return '<p class="alert">ZEN ERROR! (zen_display_banner(' . $action . ', ' . $identifier . ') -> Unknown $action parameter value - it must be either \'dynamic\' or \'static\'</p>';
    }
     if ($banner->RecordCount() > 0) {
		 $i=0;
  while (!$banner->EOF) {
	  $banner_string.='<span class="slidesjs-slide" slidesjs-index="'.$i.'">';
    if (zen_not_null($banner->fields['banners_html_text'])) {
      $banner_string.= $banner->fields['banners_html_text'];
    } else {
      if ($banner->fields['banners_url'] == '') {
        $banner_string.= zen_image(DIR_WS_IMAGES . $banner->fields['banners_image'], $banner->fields['banners_title']);
      } else {
        if ($banner->fields['banners_open_new_windows'] == '1') {
          $banner_string.= '<a href="' . zen_href_link(FILENAME_REDIRECT, 'action=banner&goto=' . $banner->fields['banners_id'], 'SSL') . '" target="_blank">' . zen_image(DIR_WS_IMAGES . $banner->fields['banners_image'], $banner->fields['banners_title']) . '</a>';
        } else {
          $banner_string.= '<a href="' . zen_href_link(FILENAME_REDIRECT, 'action=banner&goto=' . $banner->fields['banners_id'], 'SSL') . '">' . zen_image(DIR_WS_IMAGES . $banner->fields['banners_image'], $banner->fields['banners_title'],254,309) . '</a>';
        }
      }
    }
    zen_update_banner_display_count($banner->fields['banners_id']);
	$banner_string.='</span>';
	$mj_banners_list.=$banner_string;
	$i++;
    $banner->MoveNext();
	$banner_string='';
  }
} 
else {
  echo '<p>Sorry, banners found.</p>';
}
    return $mj_banners_list;
  }

function zen_pzen_get_products_display_price($products_id,$sales='0') {
    global $db, $currencies;

    $free_tag = "";
    $call_tag = "";

// 0 = normal shopping
// 1 = Login to shop
// 2 = Can browse but no prices
    // verify display of prices
      switch (true) {
        case (CUSTOMERS_APPROVAL == '1' and $_SESSION['customer_id'] == ''):
        // customer must be logged in to browse
        return '';
        break;
        case (CUSTOMERS_APPROVAL == '2' and $_SESSION['customer_id'] == ''):
        // customer may browse but no prices
        return TEXT_LOGIN_FOR_PRICE_PRICE;
        break;
        case (CUSTOMERS_APPROVAL == '3' and TEXT_LOGIN_FOR_PRICE_PRICE_SHOWROOM != ''):
        // customer may browse but no prices
        return TEXT_LOGIN_FOR_PRICE_PRICE_SHOWROOM;
        break;
        case ((CUSTOMERS_APPROVAL_AUTHORIZATION != '0' and CUSTOMERS_APPROVAL_AUTHORIZATION != '3') and $_SESSION['customer_id'] == ''):
        // customer must be logged in to browse
        return TEXT_AUTHORIZATION_PENDING_PRICE;
        break;
        case ((CUSTOMERS_APPROVAL_AUTHORIZATION != '0' and CUSTOMERS_APPROVAL_AUTHORIZATION != '3') and $_SESSION['customers_authorization'] > '0'):
        // customer must be logged in to browse
        return TEXT_AUTHORIZATION_PENDING_PRICE;
        break;
        default:
        // proceed normally
        break;
      }

// show case only
    if (STORE_STATUS != '0') {
      if (STORE_STATUS == '1') {
        return '';
      }
    }

    // $new_fields = ', product_is_free, product_is_call, product_is_showroom_only';
    $product_check = $db->Execute("select products_tax_class_id, products_price, products_priced_by_attribute, product_is_free, product_is_call, products_type from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "'" . " limit 1");

    // no prices on Document General
    if ($product_check->fields['products_type'] == 3) {
      return '';
    }

    $show_display_price = '';
    $display_normal_price = zen_get_products_base_price($products_id);
	$display_sale_price = zen_get_products_special_price($products_id, false);
    $display_special_price = zen_get_products_special_price($products_id, true);

    $show_sale_discount = '';
    if (SHOW_SALE_DISCOUNT_STATUS == '1' and ($display_special_price != 0 or $display_sale_price != 0)) {
      if ($display_sale_price) {
        if (SHOW_SALE_DISCOUNT == 1) {
          if ($display_normal_price != 0) {
            $show_discount_amount = number_format(100 - (($display_sale_price / $display_normal_price) * 100),SHOW_SALE_DISCOUNT_DECIMALS);
          } else {
            $show_discount_amount = '';
          }
          $show_sale_discount = '<span class="productPriceDiscount">'.  $show_discount_amount . PRODUCT_PRICE_DISCOUNT_PERCENTAGE . '</span>';

        } else {
          $show_sale_discount = '<span class="productPriceDiscount">' .$currencies->display_price(($display_normal_price - $display_sale_price), zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . PRODUCT_PRICE_DISCOUNT_AMOUNT . '</span>';
        }
      } else {
        if (SHOW_SALE_DISCOUNT == 1) {
          $show_sale_discount = '<span class="productPriceDiscount">' . number_format(100 - (($display_special_price / $display_normal_price) * 100),SHOW_SALE_DISCOUNT_DECIMALS) . PRODUCT_PRICE_DISCOUNT_PERCENTAGE . '</span>';
        } else {
          $show_sale_discount = '<span class="productPriceDiscount">' . $currencies->display_price(($display_normal_price - $display_special_price), zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . PRODUCT_PRICE_DISCOUNT_AMOUNT . '</span>';
        }
      }
    }

    if ($display_special_price) {
      $show_normal_price = '<span class="normalprice">' . $currencies->display_price($display_normal_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . '</span>'; //id="old-price-'.$products_id.'"
	  
      if ($display_sale_price && $display_sale_price != $display_special_price) {
      
		 $show_special_price = '<span class="productSpecialPriceSale">' .$currencies->display_price($display_special_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . '</span>'; //id="product-price-'.$products_id.'"
		
        if ($product_check->fields['product_is_free'] == '1') {
		   $show_sale_price = '<span class="productSalePrice">' .$currencies->display_price($display_sale_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])). '</span>'; //id="product-price-'.$products_id.'"
		  
        } else {
          $show_sale_price = '<span class="productSalePrice">' . $currencies->display_price($display_sale_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . '</span>'; //id="product-price-'.$products_id.'"
        }
      } else {
        if ($product_check->fields['product_is_free'] == '1') {
			$show_special_price = '<span class="productSpecialPrice">' . '<s>' .$currencies->display_price($display_special_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])) .'</s>' . '</span>'; //id="product-price-'.$products_id.'"
        } else {
		    $show_special_price = '<span class="productSpecialPrice">' .$currencies->display_price($display_special_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . '</span>'; //id="product-price-'.$products_id.'"
		  
        }
        $show_sale_price = '';
      }
    } else {
      if ($display_sale_price) {

        $show_normal_price = ' <span class="normalprice">' . $currencies->display_price($display_normal_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . '</span>'; //id="old-price-'.$products_id.'"
        $show_special_price = '';
		  $show_sale_price = '<span class="special-price productSalePrice"><span  class="price product-price-'.$products_id.'">' .$currencies->display_price($display_sale_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . '</span></span>'; //id="product-price-'.$products_id.'"
    
      } else {
        if ($product_check->fields['product_is_free'] == '1') {
          $show_normal_price = '<span class="normalprice">' . $currencies->display_price($display_normal_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . '</span>'; //id="old-price-'.$products_id.'"
        } else {
          $show_normal_price = '<span class="single_price">'. $currencies->display_price($display_normal_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])).'</span>'; //id="product-price-'.$products_id.'"

        }
        $show_special_price = '';
        $show_sale_price = '';
      }
    }

    if ($display_normal_price == 0) {
      // don't show the $0.00
      $final_display_price = $show_special_price . $show_sale_price . $show_sale_discount ;
    } else {
      $final_display_price = $show_normal_price. $show_special_price . $show_sale_price . $show_sale_discount;
    }

    // If Free, Show it
    if ($product_check->fields['product_is_free'] == '1') {
      if (OTHER_IMAGE_PRICE_IS_FREE_ON=='0') {
        $free_tag = '<br />' . PRODUCTS_PRICE_IS_FREE_TEXT;
      } else {
        $free_tag = '<br />' . zen_image(DIR_WS_TEMPLATE_IMAGES . OTHER_IMAGE_PRICE_IS_FREE, PRODUCTS_PRICE_IS_FREE_TEXT);
      }
    }

    // If Call for Price, Show it
    if ($product_check->fields['product_is_call']) {
      if (PRODUCTS_PRICE_IS_CALL_IMAGE_ON=='0') {
        $call_tag = '<br />' . PRODUCTS_PRICE_IS_CALL_FOR_PRICE_TEXT;
      } else {
        $call_tag = '<br />' . zen_image(DIR_WS_TEMPLATE_IMAGES . OTHER_IMAGE_CALL_FOR_PRICE, PRODUCTS_PRICE_IS_CALL_FOR_PRICE_TEXT);
      }
    }

    return $final_display_price;
}
function pzen_product_reviews($product_id){
    global $db;
	$content='';
	$flag_show_product_info_reviews = zen_get_show_product_switch($product_id, 'reviews');
	$flag_show_product_info_reviews_count = zen_get_show_product_switch($product_id, 'reviews_count');

	// 2P added BOF - Average Product Rating
    $reviews_query = "select count(*) as count, avg(reviews_rating) as average_rating from " . TABLE_REVIEWS . " r, "
                                                       . TABLE_REVIEWS_DESCRIPTION . " rd
                       where r.products_id = '" . (int)$product_id . "'
                       and r.reviews_id = rd.reviews_id
                       and rd.languages_id = '" . (int)$_SESSION['languages_id'] . "'" .
                       $review_status;

    $reviews = $db->Execute($reviews_query);
    // 2P added EOF - Average Product Rating

    if ($flag_show_product_info_reviews == 1) {
    // if more than 0 reviews, then show reviews button; otherwise, show the "write review" button
    
		if ($reviews->fields['count'] > 0 ) { 
		// 2P modified BOF - Average Product Rating
		
			$content.= '<div class="index-ratings">
					<div class="rating-box">';
				if ($flag_show_product_info_reviews_count == 1) {
					$stars_image_suffix = str_replace('.', '_', zen_round($reviews->fields['average_rating'] * 2, 0) / 2); // for stars_0_5.gif, stars_1.gif, stars_1_5.gif etc.
					$average_rating = zen_round(($reviews->fields['average_rating']*100)/5, 2);
					// $content.= zen_image(DIR_WS_TEMPLATE_IMAGES . 'stars_' . $stars_image_suffix . '.gif', sprintf(BOX_REVIEWS_TEXT_OF_5_STARS, $average_rating));
					$content.='<div style="width:'.$average_rating.'%" class="rating"></div>';
				} else {
					echo '';
				}
				$link_content="var t = opener ? opener.window : window; t.location.href='".zen_href_link(FILENAME_PRODUCT_REVIEWS, zen_get_all_get_params(), 'SSL')."'";
			$content.='</div>
		</div>';
		// 2P modified EOF - Average Product Rating
		} else {
			$content.= '<div class="index-ratings"><a href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, '&products_id='.$product_id, 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_WRITE_REVIEW, BUTTON_WRITE_REVIEW_ALT) . '</a></div>';
			//$content.='<div style="width:'.$average_rating.'%" class="rating"></div>';
		}
	
	} 	
	return $content;
}	

////// Get slected subcategories array
function pzen_get_selected_subcategories($categories_ul_li = '', $parent_id = '0', $cpath = '') {
global $db;
 
$categories_query = "select c.categories_id, cd.categories_name, c.categories_status
                     from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
                     where " . $zc_status . "
                     parent_id = '" . (int)$parent_id . "'
                     and c.categories_status = TRUE
                     and c.categories_id = cd.categories_id
                     and cd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                     order by sort_order, cd.categories_name";
$categories = $db->Execute($categories_query);
				while (!$categories->EOF) {
				if ($categories->fields['categories_id'] != $parent_id) {
					if(zen_has_category_subcategories($categories->fields['categories_id'])){
						
					   $categories_ul_li = pzen_get_selected_subcategories($categories_ul_li, $categories->fields['categories_id'], $dpath.= "_");
					}
					else
					{
				        $categories_ul_li[]=$categories->fields['categories_id'];
					
					}
				$categories->MoveNext();
				}
				}
				return $categories_ul_li;
}

////// Get ul li
function pzen_get_categories_ul_li($categories_ul_li = '', $parent_id = '0', $cpath = '') {
	global $db;
	 
	$categories_query = "select c.categories_id, cd.categories_name, c.categories_status
						 from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
						 where " . $zc_status . "
						 parent_id = '" . (int)$parent_id . "'
						 and c.categories_status = TRUE
						 and c.categories_id = cd.categories_id
						 and cd.language_id = '" . (int)$_SESSION['languages_id'] . "'
						 order by sort_order, cd.categories_name";
	$categories = $db->Execute($categories_query);
	$categories_ul_li .= "<ul>";
				while (!$categories->EOF) {
					
					if ($categories->fields['categories_id'] != $parent_id) {
					
					}
					
				$dpath = $cpath.$categories->fields['categories_id'];
				$categories_ul_li .= "<li><a href=\"index.php?main_page=index&cPath=$dpath\">".$categories->fields['categories_name'].'</a>';
				if ($categories->fields['categories_id'] != $parent_id) {
					if(zen_has_category_subcategories($categories->fields['categories_id'])){
						
					   $categories_ul_li = pzen_get_categories_ul_li($categories_ul_li, $categories->fields['categories_id'], $dpath.= "_");
					}
					else
					{
				        print_r($categories->fields['categories_id']);
					}
				$categories_ul_li .= "</li>";
				$categories->MoveNext();
				}
				}
				$categories_ul_li .= "</ul>";
				return $categories_ul_li;
}

function pzen_get_additional_images($products_ar , $width='', $height=''){
	global $db;

	$cPath = (isset($products_ar['cPath'])) ? $products_ar['cPath'] : '';
	$zen_get_info_page = (isset($products_ar['zen_get_info_page'])) ? $products_ar['zen_get_info_page'] : '';
	
	$products_image = $products_ar['products_image'];
	$products_id = $products_ar['products_id'];
	$product_link=zen_href_link($zen_get_info_page, 'cPath=' . $cPath . '&products_id=' . $products_id, 'SSL');
	
	$dis_addimgs_type=get_pzen_options('prodlist_addtionalimg_type');
	$prodlist_nums_addimgs=(get_pzen_options('prodlist_nums_addimgs'))? get_pzen_options('prodlist_nums_addimgs') : '4';
	
	$width=($width=='') ? IMAGE_PRODUCT_LISTING_WIDTH : $width;
	$height=($height=='') ? IMAGE_PRODUCT_LISTING_HEIGHT : $height;
	
	$content='';
	if (!defined('IMAGE_ADDITIONAL_DISPLAY_LINK_EVEN_WHEN_NO_LARGE')) define('IMAGE_ADDITIONAL_DISPLAY_LINK_EVEN_WHEN_NO_LARGE','Yes');
	$images_array = array();

	// do not check for additional images when turned off
	if ($products_image != '') {
	  // prepare image name
	  $products_image_extension = substr($products_image, strrpos($products_image, '.'));
	  $products_image_base = str_replace($products_image_extension, '', $products_image);

	  // if in a subdirectory
	  if (strrpos($products_image, '/')) {
		$products_image_match = substr($products_image, strrpos($products_image, '/')+1);
		//echo 'TEST 1: I match ' . $products_image_match . ' - ' . $file . ' -  base ' . $products_image_base . '<br>';
		$products_image_match = str_replace($products_image_extension, '', $products_image_match) . '_';
		$products_image_base = $products_image_match;
	  }

	  $products_image_directory = str_replace($products_image, '', substr($products_image, strrpos($products_image, '/')));
	  if ($products_image_directory != '') {
		$products_image_directory = DIR_WS_IMAGES . str_replace($products_image_directory, '', $products_image) . "/";
	  } else {
		$products_image_directory = DIR_WS_IMAGES;
	  }

	  // Check for additional matching images
	  $file_extension = $products_image_extension;
	  $products_image_match_array = array();
	  if ($dir = @dir($products_image_directory)) {
		while ($file = $dir->read()) {
		  if (!is_dir($products_image_directory . $file)) {
			if (substr($file, strrpos($file, '.')) == $file_extension) {
			  if(preg_match('/\Q' . $products_image_base . '\E/i', $file) == 1) {
				if ($file != $products_image) {
				  if ($products_image_base . str_replace($products_image_base, '', $file) == $file) {
					//  echo 'I AM A MATCH ' . $file . '<br>';
					$images_array[] = $file;
				  } else {
					//  echo 'I AM NOT A MATCH ' . $file . '<br>';
				  }
				}
			  }
			}
		  }
		}
		if (sizeof($images_array)) {
		  sort($images_array);
		}
		$dir->close();
	  }
	}
	$num_images = sizeof($images_array);
	// Build output based on images found
	if($dis_addimgs_type==2){
		$num_images=($num_images > 1) ? 1 : $num_images;
	}else if($prodlist_nums_addimgs){
		$max_additionalimg = (int)($prodlist_nums_addimgs);
		$num_images = ($num_images > $max_additionalimg) ? $max_additionalimg : $num_images;
	}
	$list_box_contents = array();
	$title = '';
	if ($num_images && $dis_addimgs_type!=1) {
	  $row = 0;
	  $col = 0;
	  if ($num_images < IMAGES_AUTO_ADDED || IMAGES_AUTO_ADDED == 0 ) {
		$col_width = floor(100/$num_images);
	  } else {
		$col_width = floor(100/IMAGES_AUTO_ADDED);
	  }
	  for ($i=0, $n=$num_images; $i<$n; $i++) {
		$file = $images_array[$i];
		$products_image_medium = str_replace(DIR_WS_IMAGES, DIR_WS_IMAGES . 'medium/', $products_image_directory) . str_replace($products_image_extension, '', $file) . IMAGE_SUFFIX_MEDIUM . $products_image_extension;
		//  Begin Image Handler changes 1 of 2
			if (function_exists('handle_image')) {
				$newimg = handle_image($products_image_medium, addslashes($products_name), $width, $height, '');
				list($src, $alt, $width, $height, $parameters) = $newimg;
				$products_image_medium = zen_output_string($src);
			} 
			$flag_has_medium = file_exists($products_image_medium);
		//  End Image Handler changes 1 of 2
		$products_image_medium = ($flag_has_medium ? $products_image_medium : $products_image_directory . $file);
		$flag_display_medium = (IMAGE_ADDITIONAL_DISPLAY_LINK_EVEN_WHEN_NO_MEDIUM == 'Yes' || $flag_has_medium);
		$base_image = $products_image_directory . $file;
		$thumb_slashes = zen_image(addslashes($base_image), addslashes($products_ar['products_name']), SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);
	//  Begin Image Handler changes 2 of 2
	//  remove additional single quotes from image attributes (important!)
		$thumb_slashes = preg_replace("/([^\\\\])'/", '$1\\\'', $thumb_slashes);
	//  End Image Handler changes 2 of 2
		$image_regular = zen_image($products_image_medium, $products_ar['products_name'], $width, $height, 'class="adt-img"');
		$large_link = zen_href_link(FILENAME_POPUP_IMAGE_ADDITIONAL, 'pID=' . $products_id . '&pic=' . $i . '&products_image_large_additional=' . $products_image_medium, 'SSL');
		$script_link = '<a href="'.$product_link.'" title="' . $products_ar['products_name'] . '">' . $image_regular .'</a>';
		// List Box array generation:
		$list_box_contents[$row][$col] = array('params' => 'class="item "', 'text' => array('imglink' => $script_link, 'img' => $image_regular));
		$col ++;
		if ($col > (IMAGES_AUTO_ADDED -1)) {
		  $col = 0;
		  $row ++;
		}
	  } // end for loop
		if($dis_addimgs_type==2){
				$second_img='';
				for($row=0;$row<sizeof($list_box_contents);$row++)
				{
					for($col=0;$col<sizeof($list_box_contents[$row]);$col++) 
					{
						$r_params = "";
						if (isset($list_box_contents[$row][$col]['params'])) $r_params .= ' ' . (string)$list_box_contents[$row][$col]['params'];
							if (isset($list_box_contents[$row][$col]['text']['img'])) 
							{ 
								$second_img.=$list_box_contents[$row][$col]['text']['img'];
							}
						}
				}
				
				$content.='<a class="image-swap-effect" href="'.$product_link.'" title="' . $products_ar['products_name'] . '">' . zen_image(DIR_WS_IMAGES.$products_image, $products_ar['products_name'], $width, $height, 'class="base-img"') .$second_img.'</a>';
		  
		}else{
			$content.='
			<!-- product image carousel -->
			<div class="product__inside__carousel slide" data-ride="carousel">
				<div class="carousel-inner" role="listbox">';
				$content.='<div class="item active"><a href="'.$product_link.'" title="' . $products_ar['products_name'] . '">' . zen_image(DIR_WS_IMAGES.$products_image, $products_ar['products_name'], $width, $height) .'</a></div>';
				
				
			for($row=0;$row<sizeof($list_box_contents);$row++)
				{
					$params = "";
					//if (isset($list_box_contents[$row]['params'])) $params .= ' ' . $list_box_contents[$row]['params'];
					for($col=0;$col<sizeof($list_box_contents[$row]);$col++) 
					{
						$r_params = "";
						if (isset($list_box_contents[$row][$col]['params'])) $r_params .= ' ' . (string)$list_box_contents[$row][$col]['params'];
							if (isset($list_box_contents[$row][$col]['text']['imglink'])) 
							{ 
								$content.='<div' . $r_params . '>' . $list_box_contents[$row][$col]['text']['imglink'] .  '</div>';
							}
						}
				}
			$content.='
				</div>
				<!-- Controls --> 
				<a class="carousel-control next"></a> <a class="carousel-control prev"></a>
			</div>';
		}
	}else{ // endif
		$content.='<a href="'.$product_link.'" title="' . $products_ar['products_name'] . '">' .zen_image(DIR_WS_IMAGES.$products_image, $products_ar['products_name'], IMAGE_PRODUCT_LISTING_WIDTH, IMAGE_PRODUCT_LISTING_HEIGHT) .'</a>';
	}
	return $content;
}

function pzen_getbaseimg_effects($img){
	if ($src == DIR_WS_IMAGES and PRODUCTS_IMAGE_NO_IMAGE_STATUS == '1') {
		$src = DIR_WS_IMAGES . PRODUCTS_IMAGE_NO_IMAGE;
    }else{
		$img_src=DIR_WS_IMAGES.$img;
		if(file_exists($img_src) && $img!=''){
			$src=$img_src;  
		}else{
			$src = DIR_WS_IMAGES . PRODUCTS_IMAGE_NO_IMAGE;
		}
	}
	return $src;
}
function pzen_gethoverimg_effects($img){	
	if ($src == DIR_WS_IMAGES and PRODUCTS_IMAGE_NO_IMAGE_STATUS == '1') {
		$src = DIR_WS_IMAGES . PRODUCTS_IMAGE_NO_IMAGE;
    }else{
	    $img_fileInfo = pathinfo($img);
		$img_extension = '.'.$img_fileInfo['extension'];
		$second_product_img_src=DIR_WS_IMAGES.str_replace($img_extension,'',$img).'_01'.$img_extension;
		$src=(file_exists($second_product_img_src))? 'hover_img="'.$second_product_img_src.'"' : '' ;
	}
	return $src;
}
////
// Return table heading with sorting capabilities
function pzen_create_sort_heading($sortby, $colnum, $heading) {
	global $PHP_SELF;
	$sort_prefix = '';
	if ($sortby) {
		 $select=(isset($_GET['sort']) && (($_GET['sort']==$colnum.'a') || ($_GET['sort']==$colnum.'d')) )? "selected='selected'":"";
	  $sort_prefix = '<option '. $select .' value="'. $colnum.'a">'.$heading.'</option>' ;
	}
	return $sort_prefix ;
}

function pzen_create_sort_heading_asc_des($sortby, $colnum, $heading) {
    global $PHP_SELF;

    $sort_prefix = '';
    $sort_suffix = '';
       $orderitm=(substr($sortby, 1, 1));
	  $colnum= str_replace($orderitm,'',$sortby);
    if ($sortby) {
      $sort_prefix = '<a href="' . zen_href_link($_GET['main_page'], zen_get_all_get_params(array('page', 'info', 'sort')) . 'page=1&sort=' . $colnum . ($sortby == $colnum . 'a' ? 'd' : 'a'), 'SSL') . '" title="' . zen_output_string(TEXT_SORT_PRODUCTS . ($sortby == $colnum . 'd' || substr($sortby, 0, 1) != $colnum ? TEXT_ASCENDINGLY : TEXT_DESCENDINGLY) . TEXT_BY . $heading) . '">' ;
      $sort_suffix = (substr($sortby, 0, 1) == $colnum ? (substr($sortby, 1, 1) == 'a' ? '<span class="ascending_direction direction">'.PRODUCT_LIST_SORT_ORDER_ASCENDING.'</span>' : '<span class="descending_direction direction">'.PRODUCT_LIST_SORT_ORDER_DESCENDING.'</span>') : '') . '</a>';
    }

    return $sort_prefix . $sort_suffix;
}

function pzen_gridlist_tab($page){
	 $cont='';
	 $cont.= '<div class="display-mode filters-row__mode"><ul class="unstyled float-right">
			  ';
			     (defined('PRODUCT_LISTING_LAYOUT_STYLE')? PRODUCT_LISTING_LAYOUT_STYLE: 'rows');
				    
				   if(((isset($_GET['view'])) && ($_GET['view']=='rows')) || (PRODUCT_LISTING_LAYOUT_STYLE=='rows' && (!isset($_GET['view'])) ))
				   {   
						$cont.= '<a class="filters-row__view link-grid-view btn-img btn-img-view_module" title="'.HEADING_VIEW_AS_GRID.'" href="'.zen_href_link($page, zen_get_all_get_params(array('view')) . 'view=columns', 'SSL').'" >'.'<span></span></a>';
						$cont.= '<a class="filters-row__view active link-row-view btn-img btn-img-view_list" title="'.HEADING_VIEW_AS_LIST.'" href="'.zen_href_link($page, zen_get_all_get_params(array('view')) . 'view=rows', 'SSL').'">'.'<span></span></a>';
				   }
				   else
				   {
						$cont.= '<a class="filters-row__view active link-grid-view btn-img btn-img-view_module" title="'.HEADING_VIEW_AS_GRID.'" href="'.zen_href_link($page, zen_get_all_get_params(array('view')) . 'view=columns', 'SSL').'">'.'<span></span></a>';
						$cont.= '<a class="filters-row__view link-row-view btn-img btn-img-view_list" title="'.HEADING_VIEW_AS_LIST.'" href="'.zen_href_link($page, zen_get_all_get_params(array('view')) . 'view=rows', 'SSL').'" >'.'<span></span></a>&nbsp;';
				   }
		$cont.= '</ul></div>';  
		return $cont;
}

function pzen_testimonials(){
	global $db;
	$testimonial_style = get_pzen_options('testimonial_style');
	$test_background_image = get_pzen_options('test_background_image');
	$homepage_layout=(get_pzen_options('homepage_layout')) ? get_pzen_options('homepage_layout') : '1' ;
	if($testimonial_style == 1){
		$test_main_class = ($homepage_layout==1)? "content content-bg-1 fixed-bg" : "content-sm content-bg-1 fixed-bg";
		$test_slider_class= "slider-blog slick-arrow-bottom";
	}elseif($testimonial_style == 2){
		$test_main_class = ($homepage_layout==1)? "content" : 'content-sm' ;
		$test_slider_class= "slider-blog-layout1";
	}
	$content='';
	$testimonials_query_raw = "select * from " . TABLE_TESTIMONIALS_MANAGER . " where status = 1 and language_id = '" . (int)$_SESSION['languages_id'] . "' order by date_added DESC, testimonials_title LIMIT 6";
	$testimonials = $db->Execute($testimonials_query_raw);
	if($testimonial_style==3){
	
		$content.='<h2 class="text-left text-uppercase title-under">'.BOX_HEADING_TESTIMONIALS_MANAGER.'</h2>
				<div class="slider-blog-layout1">';
				$i=0;
				while (!$testimonials->EOF){
					$testname = $testimonials->fields['testimonials_name'];
					$test_title = $testimonials->fields['testimonials_title'];
					$testimonialid = $testimonials->fields['testimonials_id'];
					
					$test_text = $testimonials->fields['testimonials_html_text'];;
				
					$testimonials_image = zen_image(DIR_WS_IMAGES . $testimonials->fields[testimonials_image], 
					$testimonials->fields['testimonials_title'], TESTIMONIAL_IMAGE_WIDTH, TESTIMONIAL_IMAGE_HEIGHT);
				$content.='
					<!-- slide-->
					<a class="link-hover-block" href="'.zen_href_link(FILENAME_TESTIMONIALS_MANAGER, 'testimonials_id=' . $testimonialid, 'SSL').'">
						<div class="slider-blog__item">									
							<div class="box-foto">'.$testimonials_image.'</div>
							<div class="box-data">';
								if (DISPLAY_TESTIMONIALS_MANAGER_TRUNCATED_TEXT == 'true') {
										$test_text = zen_trunc_string($test_text,TESTIMONIALS_MANAGER_DESCRIPTION_LENGTH) . '<br/><strong>' .TESTIMONIALS_MANAGER_READ_MORE .'</strong></span>';
									}
					$content.='<p>'.$test_text.'</p>
								<h6>'.$test_title.'<em>&nbsp;-&nbsp; '.$testname.'</em></h6>
							</div>									
						</div>
					</a>
					<!-- /slide-->
					<div class="divider divider--sm"></div>';
					$testimonials->MoveNext();
					if($i >= 1) break;
					$i++;
				}
	$content.='</div>
				<a class="btn btn-top btn--ys btn--xl" href="'.zen_href_link(FILENAME_TESTIMONIALS_MANAGER_ALL, '', 'SSL').'">'.TEXT_SEE_ALL.'</a>';
	}else{
	$content.='
	<!--Testimonials-->
	<section class="'.$test_main_class.'">';
	$content.=($homepage_layout==1)? '<div class="container">' : '';
	$content.='<div class="row">
			<h2 class="text-center text-uppercase title-under">'.BOX_HEADING_TESTIMONIALS_MANAGER.'</h2>
			<div class="'.$test_slider_class.'">';
				while (!$testimonials->EOF) {
					$testname = $testimonials->fields['testimonials_name'];
					$test_title = $testimonials->fields['testimonials_title'];
					$testimonialid = $testimonials->fields['testimonials_id'];
					
					$test_text = $testimonials->fields['testimonials_html_text'];;
				
					$testimonials_image = zen_image(DIR_WS_IMAGES . $testimonials->fields[testimonials_image], 
					$testimonials->fields['testimonials_title'], TESTIMONIAL_IMAGE_WIDTH, TESTIMONIAL_IMAGE_HEIGHT);
				if($testimonial_style=="1"){
	 $content.='<!-- slide-->
				<a href="'.zen_href_link(FILENAME_TESTIMONIALS_MANAGER, 'testimonials_id=' . $testimonialid, 'SSL').'" class="link-hover-block">
					<div class="slider-blog__item">
						<div class="row">
							<div class="col-xs-12 col-sm-2 col-sm-offset-3 box-foto">';
									if (($testimonials->fields['testimonials_url']) == ('http://') or ($testimonials->fields['testimonials_url']) == ('')) {
											$content.=$testimonials_image;
										} 
										else 
										{
											$content.='<a href="' . zen_href_link(FILENAME_TESTIMONIALS_MANAGER, 'testimonials_id=' . $testimonialid, 'SSL') . '" target="_blank">'. $testimonials_image . '</a>';
									} 
				$content.='</div>
							<div class="col-xs-12 col-sm-5 col-xl-4 box-data">
								<h6>
									'.$test_title.'<em>&nbsp;-&nbsp; '.$testname.'</em>
								</h6>';
									if (DISPLAY_TESTIMONIALS_MANAGER_TRUNCATED_TEXT == 'true') {
										$test_text = zen_trunc_string($test_text,TESTIMONIALS_MANAGER_DESCRIPTION_LENGTH) . '<br/><strong>' .TESTIMONIALS_MANAGER_READ_MORE .'</strong>';
									}
					 $content.='<p>'.$test_text.'</p>
							</div>
						</div>
					</div>
				</a>
				<!-- /slide-->
				<!-- slide-->';
				} else {
				$content.='<a href="'.zen_href_link(FILENAME_TESTIMONIALS_MANAGER, 'testimonials_id=' . $testimonialid, 'SSL').'" class="link-hover-block">
					<div class="slider-blog__item">
						<div class="col-md-12">
							<div class="box-foto">';
									if (($testimonials->fields['testimonials_url']) == ('http://') or ($testimonials->fields['testimonials_url']) == ('')) {
										$content.=$testimonials_image;
										} 
										else 
										{
										$content.='<a href="' . zen_href_link(FILENAME_TESTIMONIALS_MANAGER, 'testimonials_id=' . $testimonialid, 'SSL') . '" target="_blank">' 
										. $testimonials_image . '</a>';
									} 
				 $content.='</div>
							<div class="box-data">';								
									if (DISPLAY_TESTIMONIALS_MANAGER_TRUNCATED_TEXT == 'true') {
										$test_text = zen_trunc_string($test_text,TESTIMONIALS_MANAGER_DESCRIPTION_LENGTH) . '<br/><strong>' .TESTIMONIALS_MANAGER_READ_MORE .'</strong></span>';
									}
						$content.='<p>'.$test_text.'</p>
								<h6>'.$test_title.'<em>&nbsp;-&nbsp; '.$testname.'</em></h6>
							</div>
						</div>
					</div>
				</a>
				<!-- /slide-->';
				}
				$testimonials->MoveNext();
			}
		$content.='</div>
		</div>';
	$content.=($homepage_layout==1)? '</div>' : '';
	$content.='</section>
	<!--Testimonials Ends-->';
	}
	return $content;
}

function pzen_quickview($id){
	$pzen_quickview_status = (get_pzen_options('pzen_quickview_status')!=NULL) ? get_pzen_options('pzen_quickview_status') : 1 ;
	if($pzen_quickview_status){
		$product_listing_layout_style = isset($_GET['view'])? $_GET['view']: PRODUCT_LISTING_LAYOUT_STYLE;
		$quickview= '<a href="javascript:void(0);" data-toggle="modal" data-target="#quickViewModal" data-target-href="'.(zen_href_link(FILENAME_DEFINE_PZEN_QUICKVIEW,'products_id=' . $id, 'SSL')).'"  class="'.(($product_listing_layout_style == 'rows')? 'btn btn--ys btn--xl  row-mode-visible hidden-xs quickview-action' : 'quick-view quickview-action').'"><b><span class="icon icon-visibility"></span>'.PZEN_QUICK_VIEW_TEXT.'</b></a>';
		return $quickview;
	}
	return '';
}

function pzen_get_product_content($products_lst, $etc_ar=array(), $type=''){
	$products_ar=array();
	$products_ar['products_class']='';
	$products_ar['products_name']='';
	$products_ar['hover_label_prod']='';
	$products_ar['buy_now']='';
	$products_ar['wishlist_link']='';
	$products_ar['wishlist_link']='';
	$products_ar['wishlist_link_alt']='';
	$products_ar['compare_link']='';
	$products_ar['compare_link_alt']='';
	$products_ar['products_image']='';
	$products_ar['hover_label']='';
	$products_ar['products_review']='';
	$products_ar['products_new']='';
	
	
	
	if($type=='ar'){
		$products_lst_ar=$products_lst;
	}else{
		$products_lst_ar=$products_lst->fields;
	}
	
	//products name
	$products_ar['products_name'] = '<h2 class="product-name"><a href="' . zen_href_link($products_lst_ar['zen_get_info_page'], 'cPath=' . $products_lst_ar['cPath'] . '&products_id=' . $products_lst_ar['products_id'], 'SSL') . '">' . $products_lst_ar['products_name'] . '</a></h2>';
	
	//Additional Image
	$image_width = (isset($etc_ar['image_width'])) ? $etc_ar['image_width'] : '';
	$image_height = (isset($etc_ar['image_height'])) ? $etc_ar['image_height'] : '';
	$products_ar['products_image'] =  pzen_get_additional_images($products_lst_ar, $image_width, $image_height);
	
	//pzen quickview
	$products_ar['hover_label'] = pzen_quickview($products_lst_ar['products_id']);
	
	//pzen product review
	$products_ar['products_review'] = pzen_product_reviews($products_lst_ar['products_id']);
	
	//is products new
	$products_ar['products_new'] = pzen_new_product($products_lst_ar);
		
	//wishlist 
	if (UN_MODULE_WISHLISTS_ENABLED) {
		$products_ar['wishlist_link']= '<span class="icon icon-favorite_border  tooltip-link"></span><a href="' . zen_href_link(UN_FILENAME_WISHLIST, 'products_id=' . $products_lst_ar['products_id'] . '&action=wishlist_add_product', 'SSL') . '"><span class="text">'.TITLE_ADD_TO_WISHLIST.'</span></a>';
		
		$products_ar['wishlist_link_alt'] = '<a class="btn btn-wishlist btn--ys btn--xl visible-xs" href="' . zen_href_link(UN_FILENAME_WISHLIST, 'products_id=' . $products_lst_ar['products_id'] . '&action=wishlist_add_product', 'SSL') . '"><span class="icon icon-favorite_border"></span></a>';
	}
	
	//compare
	if(COMPARE_VALUE_COUNT > 0){
		$products_ar['compare_link'] ='<span class="icon icon-sort  tooltip-link"></span><a class="compare-link" href="javascript: compareNew('.$products_lst_ar['products_id'].', \'add\')"><span class="text">'.TITLE_ADD_TO_COMPARE.'</span></a>';
		$products_ar['compare_link_alt'] ='<a class="compare-link btn-compare btn btn--ys btn--xl visible-xs" href="javascript: compareNew('.$products_lst_ar['products_id'].', \'add\')"><span class="icon icon-sort"></span></a>';
	}
	
	//other content
	$minmaxqty=zen_get_products_quantity_min_units_display($products_lst_ar['products_id']);
	if($products_lst_ar['products_quantity'] <= 0 && $products_lst_ar['products_type']!=3 && SHOW_PRODUCTS_SOLD_OUT_IMAGE == '1'){
			$products_ar['products_class'] = 'sold-out';
			$products_ar['hover_label_prod'] = '<div class="product__label--sold-out">
				<span>'.TITLE_OUT_OF_STOCK.'</span>
			</div>';
	}else if((zen_get_products_allow_add_to_cart($products_lst_ar['products_id']) != 'N') && $products_lst_ar['product_is_call'] == '1'){
		$products_ar['buy_now'] ='<a class="btn btn--ys btn--xl btn-callforprice" href="' . zen_href_link(FILENAME_CONTACT_US, '', 'SSL') . '"><span class="icon icon-call"></span>' . TEXT_CALL_FOR_PRICE . '</a>';
	}else if(zen_has_product_attributes($products_lst_ar['products_id'])==1){
		$products_ar['buy_now']= zen_get_buy_now_button($products_lst_ar['products_id'],'<a class="btn btn-buynow btn--ys btn--xl" href="' . zen_href_link($_GET['main_page'], zen_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $products_lst_ar['products_id'], 'SSL') . '" '.pzenExtraBtnLink($products_lst).'><span class="icon icon-shopping_basket"></span>'.TITLE_SELECT_OPTIONS.'</a>').(($minmaxqty) ?'<span class="min-max-qty">'.$minmaxqty.'</span>' : '');
	}else{
		$products_ar['buy_now']= zen_get_buy_now_button($products_lst_ar['products_id'],'<a class="btn btn-buynow btn--ys btn--xl" href="' . zen_href_link($_GET['main_page'], zen_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $products_lst_ar['products_id'], 'SSL') . '" '.pzenExtraBtnLink($products_lst).'><span class="icon icon-shopping_basket"></span>'.TITLE_ADD_TO_CART.'</a>').(($minmaxqty) ?'<span class="min-max-qty">'.$minmaxqty.'</span>' : '');
	}
	return $products_ar;
}