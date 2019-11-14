<?php
/**
 * Header Currencies Links Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_header_currencies.php  2006-05-31 bunyip $
 */?>
  <?php $content = "";
  for ($i=0; $i<sizeof($currencies_array); $i++)
 {
    $content .= '<li class="currency__item '.(($_SESSION['currency']==$currencies_array[$i]['id'])? 'active' : '').'"><a href="' . zen_href_link($_GET['main_page'], zen_get_all_get_params(array('language')) . 'currency=' . $currencies_array[$i]['id'], $request_type) . '">' . $currencies_array[$i]['text'] .'&nbsp;'. $currencies_array[$i]['id'] . '&nbsp;-&nbsp;'. $currencies_array[$i]['title'] . '</a></li>';
  }
  echo $content;
?>
