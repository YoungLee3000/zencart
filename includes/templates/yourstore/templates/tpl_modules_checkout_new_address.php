<?php
/**
 * Module Template
 *
 * Allows entry of new addresses during checkout stages
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_checkout_new_address.php 4683 2006-10-07 06:11:53Z drbyte $
 */
?>
<div class="centerColumnModule" id="checkoutNewAddress">
	<div class="card card--padding">
		<fieldset>
			<h4><?php echo TITLE_PLEASE_SELECT; ?></h4>
				<div class="alert-text forward"><?php echo FORM_REQUIRED_INFORMATION; ?></div>
				<?php
                  if (ACCOUNT_GENDER == 'true') {
                ?>
				<?php echo zen_draw_radio_field('gender', 'm', '', 'id="gender-male"') . '<label class="radioButtonLabel" for="gender-male">' . MALE . '</label>' . zen_draw_radio_field('gender', 'f', '', 'id="gender-female" ') . '<label class="radioButtonLabel" for="gender-female">' . FEMALE . (zen_not_null(ENTRY_GENDER_TEXT) ? '<span class="alert-text">' . ENTRY_GENDER_TEXT . '</span>': '').'</label>'; ?>
				<br class="clearBoth" />
				<?php
                  }
                ?>
                <label class="inputLabel" for="firstname">
					<?php echo ENTRY_FIRST_NAME; ?>
					<?php echo (zen_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="alert-text">' . ENTRY_FIRST_NAME_TEXT . '</span>': '');?>
                </label>
                <?php echo zen_draw_input_field('firstname', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_firstname', '40') . ' id="firstname" placeholder="' . ENTRY_FIRST_NAME_TEXT . '"' . ((int)ENTRY_FIRST_NAME_MIN_LENGTH > 0 ? ' required' : '')); ?>
				<label class="inputLabel" for="lastname">
					<?php echo ENTRY_LAST_NAME; ?>
					<?php echo (zen_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="alert-text">' . ENTRY_LAST_NAME_TEXT . '</span>': '');?>
               	</label>
				<?php echo zen_draw_input_field('lastname', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_lastname', '40') . ' id="lastname" placeholder="' . ENTRY_LAST_NAME_TEXT . '"' . ((int)ENTRY_LAST_NAME_MIN_LENGTH > 0 ? ' required' : '')); ?>
				<?php
                  if (ACCOUNT_COMPANY == 'true') {
                ?>
                <label class="inputLabel" for="company">
					<?php echo ENTRY_COMPANY; ?>
					<?php echo (zen_not_null(ENTRY_COMPANY_TEXT) ? '<span class="alert-text">' . ENTRY_COMPANY_TEXT . '</span>': '');?>
                </label>
                <?php echo zen_draw_input_field('company', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_company', '40') . ' id="company" placeholder="' . ENTRY_COMPANY_TEXT . '"' . (ACCOUNT_COMPANY == 'true' && (int)ENTRY_COMPANY_MIN_LENGTH != 0 ? ' required' : '')); ?>
                <?php
                  }
                ?>
                <label class="inputLabel" for="street-address">
					<?php echo ENTRY_STREET_ADDRESS; ?>
					<?php echo (zen_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="alert-text">' . ENTRY_STREET_ADDRESS_TEXT . '</span>': '');?>
               	</label>
                <?php echo zen_draw_input_field('street_address', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_street_address', '40') . ' id="street-address" placeholder="' . ENTRY_STREET_ADDRESS_TEXT . '"' . ((int)ENTRY_STREET_ADDRESS_MIN_LENGTH > 0 ? ' required' : '')); ?>
                <?php
                	if (ACCOUNT_SUBURB == 'true') {
                ?>
                <label class="inputLabel" for="suburb">
					<?php echo ENTRY_SUBURB; ?>
					<?php echo (zen_not_null(ENTRY_SUBURB_TEXT) ? '<span class="alert-text">' . ENTRY_SUBURB_TEXT . '</span>': '');?>
                </label>
                <?php echo zen_draw_input_field('suburb', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_suburb', '40') . ' id="suburb" placeholder="' . ENTRY_SUBURB_TEXT . '"'); ?>
                <?php
                  }
                ?>
                <label class="inputLabel" for="city">
					<?php echo ENTRY_CITY; ?>
					<?php echo (zen_not_null(ENTRY_CITY_TEXT) ? '<span class="alert-text">' . ENTRY_CITY_TEXT . '</span>': '');?>
                </label>
                <?php echo zen_draw_input_field('city', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_city', '40') . ' id="city" placeholder="' . ENTRY_CITY_TEXT . '"'. ((int)ENTRY_CITY_MIN_LENGTH > 0 ? ' required' : '')); ?>
                <?php
                  if (ACCOUNT_STATE == 'true') {
                    if ($flag_show_pulldown_states == true) {
                ?>
                <label class="inputLabel" for="stateZone" id="zoneLabel">
					<?php echo ENTRY_STATE; ?>
                    <?php echo zen_not_null(ENTRY_STATE_TEXT) ? '<span class="alert-text">' . ENTRY_STATE_TEXT . '</span>': ''; ?>
                </label>
				
                <?php
                      echo '<div class="select-wrapper">'.zen_draw_pull_down_menu('zone_id', zen_prepare_country_zones_pull_down($selected_country), $zone_id, 'id="stateZone"').'</div>';
                    }
                ?>
                <?php if ($flag_show_pulldown_states == true) { ?>
                <?php } ?>
                <label class="inputLabel" for="state" id="stateLabel">
					<?php echo ENTRY_STATE; ?>
					<?php echo (zen_not_null(ENTRY_STATE_TEXT) ? '<span class="alert-text">' . ENTRY_STATE_TEXT . '</span>': '');?>
                </label>
                <?php
                   echo zen_draw_input_field('state', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_state', '40') . ' id="state" placeholder="' . ENTRY_STATE_TEXT . '"');
					if ($flag_show_pulldown_states == false) {
					  echo zen_draw_hidden_field('zone_id', $zone_name, ' ');
					}
                ?>
                <?php
                  }
                ?>
                <label class="inputLabel" for="postcode">
					<?php echo ENTRY_POST_CODE; ?>
					<?php echo (zen_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="alert-text">' . ENTRY_POST_CODE_TEXT . '</span>': '');?>
                </label>
                <?php echo zen_draw_input_field('postcode', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_postcode', '40') . ' id="postcode" placeholder="' . ENTRY_POST_CODE_TEXT . '"' . ((int)ENTRY_POSTCODE_MIN_LENGTH > 0 ? ' required' : '')); ?>
                <label class="inputLabel" for="country">
					<?php echo ENTRY_COUNTRY; ?>
					<?php echo (zen_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="alert-text">' . ENTRY_COUNTRY_TEXT . '</span>': '');?>
                </label>
				<div class="select-wrapper">
                <?php echo zen_get_country_list('zone_country_id', $selected_country, 'id="country" placeholder="' . ENTRY_COUNTRY_TEXT . '"' . ($flag_show_pulldown_states == true ? 'onchange="update_zone(this.form);"' : '')); ?>
				</div>
				<div class="buttonRow forward">
					<?php echo zen_draw_hidden_field('action', 'submit') . zen_image_submit(BUTTON_IMAGE_CONTINUE, BUTTON_CONTINUE_ALT); ?>
				</div>
    	</fieldset>
	</div> <!-- content_box ends -->
</div>