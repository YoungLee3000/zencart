<?php
/**
 * Common Template - tpl_box_default_left.php
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_box_default_left.php 2975 2006-02-05 19:33:51Z birdbrain $
 */

?>

<!--// bof: <?php echo $box_id; ?> //-->
<div class="leftBoxContainer facet-box collapse-block open" id="<?php echo str_replace('_', '-', $box_id ); ?>">
<h2 class="leftBoxHeading collapse-block__title" id="<?php echo str_replace('_', '-', $box_id) . 'Heading'; ?>"><?php echo $title; ?></h2>
	<div class="sideBoxContent collapse-block__content">
		<?php echo $content; ?>
		<?php if ($title_link) { echo '<a class="btn btn--ys btn--xs" href="' . zen_href_link($title_link, '', 'SSL') . '">' . BOX_HEADING_LINKS . '</a>'; } ?>
	</div>
</div>
<!--// eof: <?php echo $box_id; ?> //-->
