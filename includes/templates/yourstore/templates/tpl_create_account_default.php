<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=create_account.<br />
 * Displays Create Account form.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_create_account_default.php 5523 2007-01-03 09:37:48Z drbyte $
 */
?>
<div class="centerColumn" id="createAcctDefault">
	<div class="title-box">
		<h2 id="createAcctDefaultHeading" class="title-under text-uppercase text-center"><?php echo HEADING_TITLE; ?></h2>
	</div>
<?php echo zen_draw_form('create_account', zen_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL'), 'post', 'onsubmit="return check_form(create_account);"') . zen_draw_hidden_field('action', 'process') . zen_draw_hidden_field('email_pref_html', 'email_format'); ?>
	<div class="alert alert-info alert-dismissable">
		
		<?php echo sprintf(TEXT_ORIGIN_LOGIN, zen_href_link(FILENAME_LOGIN, zen_get_all_get_params(array('action')), 'SSL')); ?>
    </div>

<!--<legend><?php //echo CATEGORY_PERSONAL; ?></legend>-->

<?php require($template->get_template_dir('tpl_modules_create_account.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_create_account.php'); ?>


<!--<div class="buttonRow forward"><?php //echo zen_image_submit(BUTTON_IMAGE_SUBMIT, BUTTON_SUBMIT_ALT); ?></div>-->
</form>
</div>