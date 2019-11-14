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
  $breadcrumb->add(NAVBAR_TITLE);
  
  $which_languages = (TESTIMONIALS_DISPLAY_ALL_LANGUAGES == 'true') ? '' : (" and language_id = '" . (int)$_SESSION['languages_id'] . "'");
  
  $testimonials_query_raw = "select * from " . TABLE_TESTIMONIALS_MANAGER . " where status = 1" . $which_languages . " order by date_added DESC, testimonials_title";

  $testimonials_split = new splitPageResults($testimonials_query_raw, MAX_DISPLAY_TESTIMONIALS_MANAGER_ALL_TESTIMONIALS);
//EOF