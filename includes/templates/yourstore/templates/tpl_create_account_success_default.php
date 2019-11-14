<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=create-account_success.<br />
 * Displays confirmation that a new account has been created.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_create_account_success_default.php 4886 2006-11-05 09:01:18Z drbyte $
 */
?>
<div class="centerColumn" id="createAcctSuccess">
    <div title="title-box">
        <h2 id="createAcctSuccessHeading" class="title-under text-uppercase text-center"><?php echo HEADING_TITLE; ?></h2>
    </div>
	<div id="createAcctSuccessMainContent" class="alert alert-info alert-dismissable"><?php echo TEXT_ACCOUNT_CREATED; ?></div>
	<div class="card card--padding">
        <h4><?php echo PRIMARY_ADDRESS_TITLE; ?></h4>
        <?php
        /**
         * Used to loop thru and display address book entries
         */
          foreach ($addressArray as $addresses) {
        ?>
		<h5 class="addressBookDefaultName">
			<?php echo zen_output_string_protected($addresses['firstname'] . ' ' . $addresses['lastname']); ?>
       	</h5>
		<address><?php echo zen_address_format($addresses['format_id'], $addresses['address'], true, ' ', '<br />'); ?></address>
		<div class="buttonRow forward change_address">
			<?php echo '<a class="btn btn--ys" href="' . zen_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'edit=' . $addresses['address_book_id'], 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_EDIT_SMALL, BUTTON_EDIT_SMALL_ALT) . '</a>'; ?></div> &nbsp; &nbsp;
		<div class="buttonRow forward change_address"><?php echo '<a class="btn btn--ys" href="' . zen_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'delete=' . $addresses['address_book_id'], 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_DELETE, BUTTON_DELETE_ALT) . '</a>';?></div> &nbsp; &nbsp;
		<div class="buttonRow forward change_address"><?php echo '<a class="btn btn--ys" href="' . $origin_href . '">' . zen_image_button(BUTTON_IMAGE_CONTINUE, BUTTON_CONTINUE_ALT) . '</a>'; ?></div> &nbsp; &nbsp;
		<br class="clearBoth">
		<?php
          }
        ?>
	</div>
</div>
