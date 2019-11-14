<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=create_account.<br />
 * Displays Create Account form.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */
?>

<?php if ($messageStack->size('create_account') > 0) echo $messageStack->output('create_account'); ?>
<div class="alert-text forward"><?php echo FORM_REQUIRED_INFORMATION; ?></div><br/>

<div class="row create-account-page">
	
	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 address-details">
		<div class="card card--padding">
        	<h4><?php echo TABLE_HEADING_ADDRESS_DETAILS; ?></h4>
			<?php
              if (ACCOUNT_GENDER == 'true') {
            ?>
			<?php echo zen_draw_radio_field('gender', 'm', '', 'id="gender-male"') . '<label class="radioButtonLabel" for="gender-male">' . MALE . '</label>' . zen_draw_radio_field('gender', 'f', '', 'id="gender-female"') . '<label class="radioButtonLabel" for="gender-female">' . FEMALE . '</label>' . (zen_not_null(ENTRY_GENDER_TEXT) ? '<span class="alert-text">' . ENTRY_GENDER_TEXT . '</span>': ''); ?>
			<br class="clearBoth" />
			<?php
              }
            ?>
            <div class="row">
            	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 first-name">
                    <label class="inputLabel" for="firstname">
                        <?php echo ENTRY_FIRST_NAME; ?>
                        <?php echo zen_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="alert-text">' . ENTRY_FIRST_NAME_TEXT . '</span>': ''; ?>
                    </label>
					<?php echo zen_draw_input_field('firstname', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_firstname', '40') . ' id="firstname" placeholder="' . ENTRY_FIRST_NAME_TEXT . '"' . ((int)ENTRY_FIRST_NAME_MIN_LENGTH > 0 ? ' required' : '')); ?>
				</div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 last-name">    
                    <label class="inputLabel" for="lastname">
                        <?php echo ENTRY_LAST_NAME; ?>
                        <?php echo zen_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="alert-text">' . ENTRY_LAST_NAME_TEXT . '</span>': ''; ?>
                    </label>
                    <?php echo zen_draw_input_field('lastname', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_lastname', '40') . ' id="lastname" placeholder="' . ENTRY_LAST_NAME_TEXT . '"'. ((int)ENTRY_LAST_NAME_MIN_LENGTH > 0 ? ' required' : '')); ?>
				</div>
            	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 emailaddress">
                	<label class="inputLabel" for="email-address">
						<?php echo ENTRY_EMAIL_ADDRESS; ?>
						<?php echo zen_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="alert-text">' . ENTRY_EMAIL_ADDRESS_TEXT . '</span>': ''; ?>
                    </label>
					<?php echo zen_draw_input_field('email_address', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_email_address', '40') . ' id="email-address" placeholder="' . ENTRY_EMAIL_ADDRESS_TEXT . '"' . ((int)ENTRY_EMAIL_ADDRESS_MIN_LENGTH > 0 ? ' required' : ''), 'email'); ?>
                </div>
				<?php echo zen_draw_input_field('should_be_empty', '', ' size="40" id="CAAS" style="visibility:hidden; display:none;" autocomplete="off"'); ?>
				
                <?php if (ACCOUNT_DOB == 'true') { ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 dob">
                	<label class="inputLabel" for="dob">
						<?php echo ENTRY_DATE_OF_BIRTH; ?> 
						<?php echo zen_not_null(ENTRY_DATE_OF_BIRTH_TEXT) ? '<span class="alert-text">' . ENTRY_DATE_OF_BIRTH_TEXT . '</span>': ''; ?>
                	</label>
					<?php echo zen_draw_input_field('dob','', 'id="dob" placeholder="' . ENTRY_DATE_OF_BIRTH_TEXT . '"' . (ACCOUNT_DOB == 'true' && (int)ENTRY_DOB_MIN_LENGTH != 0 ? ' required' : '')); ?>
                </div>
                <?php } ?>
            	<div class="street-add1 col-lg-12 col-md-12 col-sm-12 col-xs-12">
            		<label class="inputLabel" for="street-address">
						<?php echo ENTRY_STREET_ADDRESS; ?>
						<?php echo zen_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="alert-text">' . ENTRY_STREET_ADDRESS_TEXT . '</span>': ''; ?>
                    </label>
  					<?php echo zen_draw_input_field('street_address', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_street_address', '40') . ' id="street-address" placeholder="' . ENTRY_STREET_ADDRESS_TEXT . '"'. ((int)ENTRY_STREET_ADDRESS_MIN_LENGTH > 0 ? ' required' : '')); ?>
				</div>
				<?php  if (ACCOUNT_SUBURB == 'true') {	?>
				 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 suburb">
					<label class="inputLabel" for="suburb"><?php echo ENTRY_SUBURB; ?></label>
					<?php echo zen_draw_input_field('suburb', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_suburb', '40') . ' id="suburb" placeholder="' . ENTRY_SUBURB_TEXT . '"'); ?>
				</div>
				<?php  }?>
				
            	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 city">
                    <label class="inputLabel" for="city">
                        <?php echo ENTRY_CITY; ?>
                        <?php echo zen_not_null(ENTRY_CITY_TEXT) ? '<span class="alert-text">' . ENTRY_CITY_TEXT . '</span>': ''; ?>
                    </label>
                    <?php echo zen_draw_input_field('city', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_city', '40') . ' id="city" placeholder="' . ENTRY_CITY_TEXT . '"'. ((int)ENTRY_CITY_MIN_LENGTH > 0 ? ' required' : '')); ?>
				</div>
                
				<?php
	            if (ACCOUNT_STATE == 'true') {
				    if ($flag_show_pulldown_states == true) {
                ?>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 statezone">			
					<label class="inputLabel" for="stateZone" id="zoneLabel">
						<?php echo ENTRY_STATE; ?>
                    	<?php echo zen_not_null(ENTRY_STATE_TEXT) ? '<span class="alert-text">' . ENTRY_STATE_TEXT . '</span>': ''; ?>
                    </label>
					<div class="select-wrapper">
					<?php  echo zen_draw_pull_down_menu('zone_id', zen_prepare_country_zones_pull_down($selected_country), $zone_id, 'id="stateZone"'); ?>
					</div>
				</div>
				<?php }	?>
            	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 statezone">
					<label class="inputLabel" for="state" id="stateLabel">
						<?php echo ENTRY_STATE; ?>
						<?php echo zen_not_null(ENTRY_STATE_TEXT) ? '<span class="alert-text">' . ENTRY_STATE_TEXT . '</span>': ''; ?>
                    </label>
					<?php
                        echo zen_draw_input_field('state', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_state', '40') . ' id="state" placeholder="' . ENTRY_STATE_TEXT . '"');
						if ($flag_show_pulldown_states == false) {
						  echo zen_draw_hidden_field('zone_id', $zone_name, ' ');
						}
                    ?>
                </div>
                <?php } ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 zip-code">
					<label class="inputLabel" for="postcode">
						<?php echo ENTRY_POST_CODE; ?>
						<?php echo zen_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="alert-text">' . ENTRY_POST_CODE_TEXT . '</span>': ''; ?>
                    </label>
					<?php echo zen_draw_input_field('postcode', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_postcode', '40') . ' id="postcode" placeholder="' . ENTRY_POST_CODE_TEXT . '"' . ((int)ENTRY_POSTCODE_MIN_LENGTH > 0 ? ' required' : '')); ?>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 country">
					<label class="inputLabel" for="country">
						<?php echo ENTRY_COUNTRY; ?>
						<?php echo zen_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="alert-text">' . ENTRY_COUNTRY_TEXT . '</span>': ''; ?>
                    </label>
					<div class="select-wrapper">
					<?php echo zen_get_country_list('zone_country_id', $selected_country, 'id="country" ' . ($flag_show_pulldown_states == true ? 'onchange="update_zone(this.form);"' : '')) . (zen_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="alert">' . ENTRY_COUNTRY_TEXT . '</span>': ''); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php if (ACCOUNT_COMPANY == 'true') {  ?>
	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 company-details">
		<div class="card card--padding">
            <h4><?php echo CATEGORY_COMPANY; ?></h4>
            <div class="company-details">
            	<label class="inputLabel" for="company"><?php echo ENTRY_COMPANY; ?></label>
            	<?php echo zen_draw_input_field('company', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_company', '40') . ' id="company" placeholder="' . ENTRY_COMPANY_TEXT . '"'. (ACCOUNT_COMPANY == 'true' && (int)ENTRY_COMPANY_MIN_LENGTH != 0 ? ' required' : '')); ?>
            </div>
		</div>
	</div>
    <?php } ?>
	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 phone-details">
		<div class="card card--padding">
			<h4><?php echo TABLE_HEADING_PHONE_FAX_DETAILS; ?></h4>
            <div class="row telephone-fax">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 telephone">
                    <label class="inputLabel" for="telephone">
                    <?php echo ENTRY_TELEPHONE_NUMBER; ?> 
                    <?php echo zen_not_null(ENTRY_TELEPHONE_NUMBER_TEXT) ? '<span class="alert-text">' . ENTRY_TELEPHONE_NUMBER_TEXT . '</span>': ''; ?></label>
                   <?php echo zen_draw_input_field('telephone', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_telephone', '40') . ' id="telephone" placeholder="' . ENTRY_TELEPHONE_NUMBER_TEXT . '"' . ((int)ENTRY_TELEPHONE_MIN_LENGTH > 0 ? ' required' : ''), 'tel'); ?>
                </div>
                <?php
                	if (ACCOUNT_FAX_NUMBER == 'true') {
                ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 fax-number">
                    <label class="inputLabel" for="fax">
                    <?php echo ENTRY_FAX_NUMBER; ?>
                    <?php echo zen_not_null(ENTRY_FAX_NUMBER_TEXT) ? '<span class="alert-text">' . ENTRY_FAX_NUMBER_TEXT . '</span>': ''; ?></label>
                    <?php echo zen_draw_input_field('fax', '', 'id="fax" placeholder="' . ENTRY_FAX_NUMBER_TEXT . '"', 'tel'); ?>
                </div>
				<?php
                	}
                ?>
        	</div>
		</div>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 login-details">
    	<div class="card card--padding">
			<h4><?php echo TABLE_HEADING_LOGIN_DETAILS; ?></h4>
			<div class="row password-details">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 password-entry">
                	<label class="inputLabel" for="password-new">
						<?php echo ENTRY_PASSWORD; ?>
						<?php echo zen_not_null(ENTRY_PASSWORD_TEXT) ? '<span class="alert-text">' . ENTRY_PASSWORD_TEXT . '</span>': ''; ?>
                    </label>
					<?php echo zen_draw_password_field('password', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_password', '20') . ' id="password-new" autocomplete="off" placeholder="' . ENTRY_PASSWORD_TEXT . '"'. ((int)ENTRY_PASSWORD_MIN_LENGTH > 0 ? ' required' : '')); ?>
               </div>
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 confirm-password">
               		<label class="inputLabel" for="password-confirm">
						<?php echo ENTRY_PASSWORD_CONFIRMATION; ?>
						<?php echo zen_not_null(ENTRY_PASSOWRD_CONFIRMATION_TEXT) ? '<span class="alert-text">' . ENTRY_PASSWORD_CONFIRMATION_TEXT . '</span>': ''; ?>
                    </label>
					<?php echo zen_draw_password_field('confirmation', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_password', '20') . ' id="password-confirm" autocomplete="off" placeholder="' . ENTRY_PASSWORD_CONFIRMATION_TEXT . '"'. ((int)ENTRY_PASSWORD_MIN_LENGTH > 0 ? ' required' : '')); ?>
               </div>
			</div>
    	</div>
    </div>
    <?php
      if (DISPLAY_PRIVACY_CONDITIONS == 'true') {
    ?>
	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 privacy-condition-info">
    	<div class="card card--padding">
            <h4><?php echo TABLE_HEADING_PRIVACY_CONDITIONS; ?></h4>
            <div class="information"><?php echo TEXT_PRIVACY_CONDITIONS_DESCRIPTION;?></div>
            <?php echo zen_draw_checkbox_field('privacy_conditions', '1', false, 'id="privacy" required');?>
            <label class="checkboxLabel" for="privacy"><?php echo TEXT_PRIVACY_CONDITIONS_CONFIRM;?></label>
		</div>
    </div>
	<?php
  		}
	?>
    <?php if ($siteKey != NULL || $secret != NULL) { ?>
    <!-- bo Google reCAPTCHA  -->
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 recaptcha-details">
    	<div class="card card--padding">
    		<label><?php echo GOOGLE_RECAPTCHA . '<span class="alertrequired">' . ENTRY_REQUIRED_SYMBOL . '</span>'; ?></label>
    		<div class="g-recaptcha" data-sitekey="<?php echo $siteKey;?>"></div>
    	</div>
    </div>
	<!-- eo Google reCAPTCHA  -->
    <?php } ?>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
		<div>
        	<!--<h4><?php //echo ENTRY_EMAIL_PREFERENCE; ?></h4>-->
			<div class="customers_referral row">
            	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 customers_referral">
					<?php
						  if (CUSTOMERS_REFERRAL_STATUS == 2) {
						?>
						<fieldset>

						<legend><?php echo TABLE_HEADING_REFERRAL_DETAILS; ?></legend>
						<label class="inputLabel" for="customers_referral"><?php echo ENTRY_CUSTOMERS_REFERRAL; ?></label>
						<?php echo zen_draw_input_field('customers_referral', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_referral', '15') . ' id="customers_referral"'); ?>
						<br class="clearBoth" />
						</fieldset>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 newsletter-details-signup">
		<div>
        	<!--<h4><?php //echo ENTRY_EMAIL_PREFERENCE; ?></h4>-->
			<div class="newsletter row">
            	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 newsletter">
					<?php
                      if (ACCOUNT_NEWSLETTER_STATUS != 0) {
                    ?>
                    <?php echo zen_draw_checkbox_field('newsletter', '1', $newsletter, 'id="newsletter-checkbox"') . '<label class="checkboxLabel" for="newsletter-checkbox">' . ENTRY_NEWSLETTER . '</label>' . (zen_not_null(ENTRY_NEWSLETTER_TEXT) ? '<span class="alert-text">' . ENTRY_NEWSLETTER_TEXT . '</span>': ''); ?>
			    	<br class="clearBoth" />
                    <?php } ?>
					<?php echo zen_draw_radio_field('email_format', 'HTML', ($email_format == 'HTML' ? true : false),'id="email-format-html"') . '<label class="radioButtonLabel" for="email-format-html">' . ENTRY_EMAIL_HTML_DISPLAY . '</label>' .  zen_draw_radio_field('email_format', 'TEXT', ($email_format == 'TEXT' ? true : false), 'id="email-format-text"') . '<label class="radioButtonLabel" for="email-format-text">' . ENTRY_EMAIL_TEXT_DISPLAY . '</label>'; ?>
				</div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 submit-info">
                	<div class="buttonRow forward"><?php echo zen_image_submit(BUTTON_IMAGE_SUBMIT, BUTTON_SUBMIT_ALT); ?></div>
                </div>  
			</div>
		</div>
	</div>
</div>