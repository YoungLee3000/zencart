<?php
/**
 * manufacturers_all  header_php.php
 *
 * @package page
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 6912 2007-09-02 02:23:45Z drbyte $
 */
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

// include template specific file name defines
$define_page = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_MANUFACTURERS_ALL, 'false');

$breadcrumb->add(NAVBAR_TITLE);

// Get manufacturers info
    global $db;

if (!MANUFACTURERS_ALL_EMPTY_SHOW) {
    $manufacturers_query = "select distinct m.manufacturers_id, m.manufacturers_name, m.manufacturers_image, mi.manufacturers_url
                            from (" . TABLE_MANUFACTURERS . " m
                            left join " . TABLE_MANUFACTURERS_INFO . " mi on m.manufacturers_id = mi.manufacturers_id)
                            left join " . TABLE_PRODUCTS . " p on m.manufacturers_id = p.manufacturers_id
                            where p.manufacturers_id = m.manufacturers_id
                            and (p.products_status = 1
                            and p.products_quantity > 0)
                            order by m.manufacturers_name";
	} else {
      $manufacturers_query = "select m.manufacturers_id, m.manufacturers_name, m.manufacturers_image, mi.manufacturers_url
                              from " . TABLE_MANUFACTURERS . " m
                              left join " . TABLE_MANUFACTURERS_INFO . " mi on m.manufacturers_id = mi.manufacturers_id
							  order by manufacturers_name";
	}

    $manufacturers = $db->Execute($manufacturers_query);

	$manu_content = '';
	$manu_row=0;

    while (!$manufacturers->EOF) {
		if ($manu_row==MANUFACTURERS_ALL_COLUMNS) {
			$manu_content .= '<br class="clearBoth" />';
			$manu_row=0;
		}
  		$manu_content .= '<div id="ManuWrapper"><a href="' . DIR_WS_CATALOG . 'index.php?main_page=index&amp;manufacturers_id=' . $manufacturers->fields['manufacturers_id'] . '">';
		if (MANUFACTURERS_ALL_IMAGE_SHOW) {
			$manu_content .= '<span class="manufacturer_all_image">'.zen_image(DIR_WS_IMAGES . $manufacturers->fields['manufacturers_image'], '', MANUFACTURERS_ALL_WIDTH, MANUFACTURERS_ALL_HEIGHT) . '</span><br />';
			}
		$manu_content .= '<span class="manufacturer_all_name">'.$manufacturers->fields['manufacturers_name'] . "</span></a>";
		if (MANUFACTURERS_ALL_URL_SHOW) {
			$manu_content .= '<br /><a href="http://' . $manufacturers->fields['manufacturers_url'] . '" target="_blank">' . $manufacturers->fields['manufacturers_url'] . '</a>';
			}
		$manu_content .= '</div>';
		$manu_row++;
      $manufacturers->MoveNext();
    }
?>