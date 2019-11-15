<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=contact_us.<br />
 * Displays contact us page form.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: rbarbour zcadditions.com Fri Feb 26 00:03:33 2016 -0500 Modified in v1.5.5 $
 */
?>

<span class="breadcrumb-title"><?php echo $var_pageDetails->fields['pages_title']; ?></span>

<div class="centerColumn" id="contactUsDefault">
	<?php echo zen_draw_form('contact_us', zen_href_link(FILENAME_CONTACT_US, 'action=send')); ?>
    <!-- <div class="title-box">
		<h2 id="contactus-heading" class="title-under text-uppercase text-center"><?php //echo HEADING_TITLE; ?></h2>
	</div> -->
    <?php
  		if (isset($_GET['action']) && ($_GET['action'] == 'success')) {
	?>
		<div class="alert alert-success alert-dismissable"><?php echo TEXT_SUCCESS; ?></div>
	<?php
  		} 
	?>
    <?php if ($messageStack->size('contact') > 0) echo $messageStack->output('contact'); ?>
    <!-- <div class="contact-details">
        <div class="contact-info">
    		<div class="row">
                <div class="static-content col-lg-12 col-md-12 col-sm-12 col-xs-12">
                	<div class="card card--padding">
                        <div class="contact-sample-text">
                        <?php if (DEFINE_CONTACT_US_STATUS >= '1' and DEFINE_CONTACT_US_STATUS <= '2') { ?>
                            <?php
                            /**
                             * require html_define for the contact_us page
                             */
                              //require($define_page); 
                            ?>
                        <?php
                          }
                        ?>
                        </div>
                	</div>
                </div>
            </div>
        </div>
   	</div> -->
	<div class="row">
		<div class="col-md-3 col-sm-12 col-xs-12">
			<h2 class="text-uppercase title-bottom"><?php echo HEADING_CONTACTS_TEXT; ?></h2>
			<ul class="list-icon">
				<?php if($store_address != NULL) { ?>
				<li>
					<!-- <span class="icon icon-home"></span> -->
					<strong><?php echo LABEL_CONTACTS_ADDRESS; ?>&nbsp;&nbsp;</strong><?php echo $store_address; ?>
				</li>
				<?php } ?>
				<?php if($store_contact != NULL) { ?>
				<li>
					<!-- <span class="icon icon-call"></span> -->
					<strong><?php echo LABEL_CONTACTS_PHONE; ?>&nbsp;&nbsp;</strong><?php echo $store_contact; ?>
				</li>
				<?php } ?>
				<?php if($store_fax != NULL) { ?>
				<li>
					<!-- <span class="fa fa-fax"></span> -->
					<strong><?php echo LABEL_CONTACTS_FAX; ?>&nbsp;&nbsp;</strong><?php echo $store_fax; ?>
				</li>
				<?php } ?>
				<?php if($store_timings != NULL) { ?>
				<li>
					<!-- <span class="icon icon-schedule"></span> -->
					<strong><?php echo LABEL_CONTACTS_HOURS; ?>&nbsp;&nbsp;</strong><?php echo $store_timings; ?>
				</li>
				<?php } ?>
				<?php if($store_email != NULL) { ?>
				<li>
					
					<strong><?php echo LABEL_CONTACTS_EMAIL; ?>&nbsp;&nbsp;</strong>
					<br/>
					<?php echo $store_email; ?>
					<!-- <span class="icon icon-mail"></span> -->
				</li>
				<?php } ?>
			</ul>
			<div class="divider divider--sm"></div>
			<div class="social-links social-links--large">
			<?php
				include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_FOOTER_SOCIAL_LINKS, 'false');
			?>
			</div>
		</div>
		<div class="store-contact-form col-md-9 col-sm-12 col-xs-12">
			<div class="divider divider--lg visible-xs"></div>
			<h2 class="text-uppercase title-bottom"><?php echo HEADING_GET_IN_TOUCH_WIDTH_US; ?></h2>
            <div class="row sender-name-email">
				<?php
				// show dropdown if set
					if (CONTACT_US_LIST !=''){
				?>
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 sender-dropdown">
					<label class="inputLabel" for="send-to"><?php echo SEND_TO_TEXT  . '<span class="alert-text">' . ENTRY_REQUIRED_SYMBOL . '</span>'; ?></label>
					<div class="select-wrapper">
						<?php echo zen_draw_pull_down_menu('send_to',  $send_to_array, 0, 'id="send-to"'); ?>
					</div>
				</div>
				<?php
					}
				?>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 sender-name">
                    <label><?php echo ENTRY_NAME . '<span class="alertrequired">' . ENTRY_REQUIRED_SYMBOL . '</span>'; ?></label>
                    <?php echo zen_draw_input_field('contactname', $name, ' size="40" id="contactname" placeholder="' . ENTRY_REQUIRED_SYMBOL . '" required'); ?>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 sender-email" for="email-address">
                    <label><?php echo ENTRY_EMAIL . '<span class="alertrequired">' . ENTRY_REQUIRED_SYMBOL . '</span>'; ?></label>
                    <?php echo zen_draw_input_field('email', ($email_address), ' size="40" id="email-address" autocomplete="off" placeholder="' . ENTRY_REQUIRED_SYMBOL . '" required', 'email'); ?>
                </div>
            </div>
            <div class="row message-detail">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 contactus-message" for="enquiry">
                    <label><?php echo ENTRY_ENQUIRY . '<span class="alertrequired">' . ENTRY_REQUIRED_SYMBOL . '</span>'; ?></label>
                    <?php echo zen_draw_textarea_field('enquiry', '30', '7', $enquiry, 'id="enquiry" placeholder="' . ENTRY_REQUIRED_SYMBOL . '" required'); ?>
                </div>
				<?php echo zen_draw_input_field('should_be_empty', '', ' size="40" id="CUAS" style="visibility:hidden; display:none;" autocomplete="off"'); ?>
                <?php if ($siteKey != NULL || $secret != NULL) { ?>
                <!-- bo Google reCAPTCHA  -->
				<script src='https://www.google.com/recaptcha/api.js'></script>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 recaptcha-details">
                    <label><?php echo GOOGLE_RECAPTCHA . '<span class="alertrequired">' . ENTRY_REQUIRED_SYMBOL . '</span>'; ?></label>
	                <div class="g-recaptcha" data-sitekey="<?php echo $siteKey;?>"></div>
                </div>
                <!-- eo Google reCAPTCHA  -->
                <?php } ?>
            </div>
            <div class="row contactus-sendbutton">
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <?php echo zen_image_submit(BUTTON_IMAGE_SEND, BUTTON_SEND_ALT); ?>
                </div>
				<div class="col-lg-6 col-sm-6 col-xs-12">
					<div class="pull-right note alert-text">
						<?php echo FORM_REQUIRED_INFORMATION; ?>
					</div>
				</div>
            </div>
		</div>
	</div>
</form>
</div>