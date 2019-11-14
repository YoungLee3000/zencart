<?php
/**
 * Page Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_shippinginfo_default.php 3464 2006-04-19 00:07:26Z ajeh $
 */
?>
<div class="centerColumn" id="shippingInfo">

<div class="title-box">
	<h2 id="shippingInfoHeading" class="text-center text-uppercase title-under"><?php echo HEADING_TITLE; ?></h2>
</div>
<?php if (DEFINE_SHIPPINGINFO_STATUS >= 1 and DEFINE_SHIPPINGINFO_STATUS <= 2) { ?>
<div id="shippingInfoMainContent" class="">
<?php
/**
 * require the html_define for the shippinginfo page
 */
  require($define_page);
?>
</div>
<?php } ?>

<!--<div class="buttonRow back"><?php //echo zen_back_link() . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) . '</a>'; ?></div>-->
</div>
