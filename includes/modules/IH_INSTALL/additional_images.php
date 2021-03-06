<?php
/**mod Image Handler 4.3.2
 * additional_images module
 *
 * Prepares list of additional product images to be displayed in template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: additional_images.php 18697 2011-05-04 14:35:20Z wilt $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
if (!defined('IMAGE_ADDITIONAL_DISPLAY_LINK_EVEN_WHEN_NO_LARGE')) define('IMAGE_ADDITIONAL_DISPLAY_LINK_EVEN_WHEN_NO_LARGE','Yes');
$images_array = array();

// do not check for additional images when turned off
if ($products_image != '' && $flag_show_product_info_additional_images != 0) {
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

// Build output based on images found
$temp_num_images=sizeof($images_array);
$num_images = sizeof($images_array);
$list_box_contents = array();
$title = '';

if ($num_images) {
  $row = 0;
  $col = 0;
  if ($num_images < IMAGES_AUTO_ADDED || IMAGES_AUTO_ADDED == 0 ) {
    $col_width = floor(100/$num_images);
  } else {
    $col_width = floor(100/IMAGES_AUTO_ADDED);
  }
  //if lightbox then not display main image
  //if($prodinfo_image_effects!=2){ 
	$main_imgarray=array($products_image);
	$images_array=array_merge($main_imgarray,$images_array);
  //}
  $products_image_directory_real=$products_image_directory;
  $num_images = sizeof($images_array);
  for ($i=0, $n=$num_images; $i<$n; $i++) {
    $file = $images_array[$i];
	//if lightbox then not display main image
	//if($prodinfo_image_effects!=2){ 
		if($i==0){
			$products_image_directory=DIR_WS_IMAGES;
		}else{
			$products_image_directory=$products_image_directory_real;
		}
	//}
    $products_image_large = str_replace(DIR_WS_IMAGES, DIR_WS_IMAGES . 'large/', $products_image_directory) . str_replace($products_image_extension, '', $file) . IMAGE_SUFFIX_LARGE . $products_image_extension;
//  Begin Image Handler changes 1 of 2
	if (function_exists('handle_image')) {
		$newimg = handle_image($products_image_large, addslashes($products_name), MEDIUM_IMAGE_WIDTH, MEDIUM_IMAGE_HEIGHT, '');
		list($src, $alt, $width, $height, $parameters) = $newimg;
		$products_image_large = zen_output_string($src);
	} 
	$flag_has_large = file_exists($products_image_large);
//  End Image Handler changes 1 of 2
    $products_image_large = ($flag_has_large ? $products_image_large : $products_image_directory . $file);
    $flag_display_large = (IMAGE_ADDITIONAL_DISPLAY_LINK_EVEN_WHEN_NO_LARGE == 'Yes' || $flag_has_large);
    $base_image = $products_image_directory . $file;
    $thumb_slashes = zen_image(addslashes($base_image), addslashes($products_name), SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);
//  Begin Image Handler changes 2 of 2
//  remove additional single quotes from image attributes (important!)
    $thumb_slashes = preg_replace("/([^\\\\])'/", '$1\\\'', $thumb_slashes);
//  End Image Handler changes 2 of 2
    $thumb_regular = zen_image($base_image, $products_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);
	$large_img = zen_image($products_image_large, $products_name, MEDIUM_IMAGE_WIDTH, MEDIUM_IMAGE_HEIGHT);
    $large_link = zen_href_link(FILENAME_POPUP_IMAGE_ADDITIONAL, 'pID=' . $_GET['products_id'] . '&pic=' . $i . '&products_image_large_additional=' . $products_image_large, 'SSL');
	$script_link=array();
    // Link Preparation:
	$script_link['large'] = '<a href="javascript:void(0)">' . $large_img .'</a>';
	if($prodinfo_image_effects==1){ 
	/*========================= PZEN ZOOMEFFECT ===========================*/
	$script_link['thumb'] = '<a href="javascript:void(0)" data-image="'.$products_image_large.'" data-zoom-image="'.$products_image_large.'" title="' . $products_name . '">' . $thumb_regular .'</a>';
	$noscript_link='';
	/*=========================EOF PZEN ZOOMEFFECT ===========================*/
	}else{
	/*========================= PZEN LIGHT BOX ===========================*/
		// bof Zen Lightbox 2008-12-11 aclarke
		if (ZEN_LIGHTBOX_STATUS == 'true') {
		  if (ZEN_LIGHTBOX_GALLERY_MODE == 'true') {
			$rel = 'lightbox-g';
		  } else {
			$rel = 'lightbox';
		  }
		$script_link['thumb'] = '<script language="javascript" type="text/javascript"><!--' . "\n" . 'document.write(\'' . ($flag_display_large ? '<a href="' . zen_lightbox($products_image_large, addslashes($products_name), MEDIUM_IMAGE_WIDTH, MEDIUM_IMAGE_HEIGHT) . '" rel="' . $rel . '" title="' . addslashes($products_name) . '">' . $thumb_slashes . '</a>' : $thumb_slashes) . '\');' . "\n" . '//--></script>';
		} else {

		$script_link['thumb'] = '<noscript>' . ($flag_display_large ? '<a href="' . zen_href_link(FILENAME_POPUP_IMAGE_ADDITIONAL, 'pID=' . $_GET['products_id'] . '&pic=' . $i . '&products_image_large_additional=' . $products_image_large, 'SSL') . '" target="_blank">' . $thumb_regular . '</a>' : $thumb_regular ) . '</noscript>';
		}
		//      $alternate_link = '<a href="' . $products_image_large . '" onclick="javascript:popupWindow(\''. $large_link . '\') return false;" title="' . $products_name . '" target="_blank">' . $thumb_regular . '<br />' . TEXT_CLICK_TO_ENLARGE . '</a>';
	/*=========================EOF PZEN LIGHT BOX ===========================*/
	}

    $link = $script_link;
    //      $link = $alternate_link;

    // List Box array generation:
    $list_box_contents[$row][$col] = array('params' => 'class="additionalImages centeredContent back"', 'text' => $link);
    $col ++;
    if ($col > (IMAGES_AUTO_ADDED -1)) {
      $col = 0;
      $row ++;
    }
  } // end for loop
} // endif
$num_images=$temp_num_images;