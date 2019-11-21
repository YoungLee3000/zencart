<?php
/**
 * Module Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_main_product_image.php 3208 2006-03-19 16:48:57Z birdbrain $
 */
?>

<?php require(DIR_WS_MODULES . zen_get_module_directory(FILENAME_MAIN_PRODUCT_IMAGE)); ?>


<div class="video_inner" >
        
<?php

    if (!defined('IS_ADMIN_FLAG')) {
        die('Illegal Access');
    }
    if (!defined('IMAGE_ADDITIONAL_DISPLAY_LINK_EVEN_WHEN_NO_LARGE')) define('IMAGE_ADDITIONAL_DISPLAY_LINK_EVEN_WHEN_NO_LARGE','Yes');

    $images_array = array();

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
                        if(preg_match("/" . $products_image_base . "/i", $file) == 1) {
                            if ($file != $products_image) {
                                if ($products_image_base . str_replace($products_image_base, '', $file) == $file) {
                                    $images_array[] = $products_image_directory . $file;
                                } 
                            }
                        }
                    }
                }
            }


            $images_array[] = DIR_WS_IMAGES. $products_image;

            if (sizeof($images_array)) {
                sort($images_array);
            }

            $dir->close();
        }
    }

    // Build output based on images found
    $num_images = sizeof($images_array);


    if ($num_images) {
        for ($i=0, $n=$num_images; $i<$n; $i++) {
?>
            <img src="<?php echo $images_array[$i]; ?>" width="400" height="400"  />
<?php
        }

    } 
?>
</div>







