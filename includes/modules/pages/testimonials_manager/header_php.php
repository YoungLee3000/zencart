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
 
   require(DIR_WS_MODULES . 'require_languages.php');
 $id = (int)$_GET['testimonials_id'];
 $which_languages = (TESTIMONIALS_DISPLAY_ALL_LANGUAGES == 'true') ? '' : (" and language_id = '" . (int)$_SESSION['languages_id'] . "'");
  $page_check = $db->Execute("select * from " . TABLE_TESTIMONIALS_MANAGER . " where testimonials_id = $id and status = 1" . $which_languages . " order by date_added DESC, testimonials_title");
  define('NAVBAR_TITLE', 'Testimonial');
  $date_published = $page_check->fields['date_added'];
$breadcrumb->add(NAVBAR_TITLE);
//EOF