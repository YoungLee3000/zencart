<?php
/**
 * @package templateSystem
 * @copyright Copyright 2014 ZenExpert - http://www.zenexpert.com
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: add_to cart.php 1 2014-06-05 18:53:26Z ZenExpert $
 */

  require('includes/application_top.php');

$_SESSION['cart']->actionAddProductAjaxAttributes($goto, $parameters);

$content .= '<a href="'. zen_href_link(FILENAME_SHOPPING_CART, '', 'SSL') .'" class="dropdown-toggle lnk-cart btn btn-blue btn-small" id="topcartlink" onClick="ajax_cart(); return false"><i class="glyphicon glyphicon-shopping-cart"></i><span class="item-count">Cart '. $_SESSION['cart']->count_contents() .'</span></a>';
  echo $content;

?>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
