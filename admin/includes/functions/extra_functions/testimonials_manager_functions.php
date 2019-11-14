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
 
function zen_set_testimonials_status($testimonials_id, $status) {
global $db;
    if ($status == '1') {
      return $db->Execute("update " . TABLE_TESTIMONIALS_MANAGER . " set status = '1' where testimonials_id = '" . $testimonials_id . "'");
    } elseif ($status == '0') {
      return $db->Execute("update " . TABLE_TESTIMONIALS_MANAGER . " set status = '0' where testimonials_id = '" . $testimonials_id . "'");
    } else {
      return -1;
    }
  }
?>
