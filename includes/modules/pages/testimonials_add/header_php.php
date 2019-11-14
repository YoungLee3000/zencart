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
require(DIR_WS_FUNCTIONS . 'testimonials.php');


  //require('includes/application_top.php');
if (REGISTERED_TESTIMONIAL == 'true'){
  if (!$_SESSION['customer_id']) {
    $_SESSION['navigation']->set_snapshot();
    $messageStack->add_session('login', TEXT_TESTIMONIAL_LOGIN_PROMPT, 'warning');
    zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
  }
}


  $process = false;
  if (isset($_GET['action']) && ($_GET['action'] == 'send')) {
    
        $testimonials_id = zen_db_prepare_input($_POST['testimonials_id']);
        $testimonials_title = zen_db_prepare_input($_POST['testimonials_title']);
        $testimonials_name = zen_db_prepare_input($_POST['testimonials_name']);
        $testimonials_mail = zen_db_prepare_input($_POST['testimonials_mail']);
        $testimonials_company = zen_db_prepare_input($_POST['testimonials_company']);
        $testimonials_city = zen_db_prepare_input($_POST['testimonials_city']);
        $testimonials_country = zen_db_prepare_input($_POST['testimonials_country']);
        $testimonials_html_text = zen_db_prepare_input($_POST['testimonials_html_text']);

  $zc_validate_email = zen_validate_email($testimonials_mail);

		
  $process = true;
  $error = false;
	  if (empty($testimonials_name) or strlen($testimonials_name) < ENTRY_TESTIMONIALS_CONTACT_NAME_MIN_LENGTH) {
        $error = true;
		$entry_name_error = true;
//        $messageStack->add('new_testimonial', ERROR_TESTIMONIALS);
      }
	  if ($zc_validate_email == false) {
        $error = true;
		$entry_email_error = true;
//        $messageStack->add('new_testimonial', ERROR_TESTIMONIALS);
      }
      if (empty($testimonials_title) or strlen($testimonials_title) < ENTRY_TESTIMONIALS_TITLE_MIN_LENGTH) {
        $error = true;
		$entry_title_error = true;
//        $messageStack->add('new_testimonial', ERROR_TESTIMONIALS);
      }
      if (empty($testimonials_html_text) or strlen($testimonials_html_text) < ENTRY_TESTIMONIALS_TEXT_MIN_LENGTH) {
          $error = true;
		  $entry_description_error = true;
		  $testimonials_html_text = zen_trunc_string($testimonials_html_text,ENTRY_TESTIMONIALS_TEXT_MIN_LENGTH);
//          $messageStack->add('new_testimonial', ERROR_TESTIMONIALS);
      }
	  if (strlen($testimonials_html_text) > ENTRY_TESTIMONIALS_TEXT_MAX_LENGTH) {
          $error = true;
		  $entry_description_big_error = true;
		  $testimonials_html_text = zen_trunc_string($testimonials_html_text,ENTRY_TESTIMONIALS_TEXT_MAX_LENGTH);
//          $messageStack->add('new_testimonial', ERROR_TESTIMONIALS);
      }
	  if ($error == true)  {
         $messageStack->add('new_testimonial', ERROR_TESTIMONIALS);
      }

			if ($error == false) {

      $language_id = (int)$_SESSION['languages_id'];

	$sql_data_array = array('testimonials_title' => $testimonials_title,
                                  'testimonials_name' => $testimonials_name,
                                  'language_id' => $language_id, 
                                  'testimonials_mail' => $testimonials_mail,
                                  'testimonials_company' => $testimonials_company,
                                  'testimonials_city' => $testimonials_city,
                                  'testimonials_country' => $testimonials_country,
								  'testimonials_show_email' => $testimonials_show_email,
                                  'testimonials_html_text' => $testimonials_html_text);

          
            $insert_sql_data = array('date_added' => 'now()',
                                     'status' => '0');
            $sql_data_array = array_merge($sql_data_array, $insert_sql_data);
            zen_db_perform(TABLE_TESTIMONIALS_MANAGER, $sql_data_array);
            $testimonials_id = zen_db_insert_id();
//            $messageStack->add_session(SUCCESS_TESTIMONIALS_INSERTED, 'success');
 
 
 // build the message content
     
	  $name = $testimonials_name;
      $email_text = sprintf(EMAIL_GREET_NONE, $name);
      $html_msg['EMAIL_GREETING'] = str_replace('\n','',$email_text);


      // initial welcome
      $email_text .=  EMAIL_WELCOME;
	  $html_msg['EMAIL_WELCOME'] = str_replace('\n','',EMAIL_WELCOME);
      // add in regular email welcome text
      $email_text .= "\n\n" . EMAIL_TEXT . EMAIL_CONTACT . EMAIL_GV_CLOSURE;
	  $html_msg['EMAIL_MESSAGE_HTML']  = str_replace('\n','',EMAIL_TEXT);
	  $html_msg['EMAIL_CONTACT_OWNER'] = str_replace('\n','',EMAIL_CONTACT);
	  $html_msg['EMAIL_CLOSURE']       = nl2br(EMAIL_GV_CLOSURE);

// include create-account-specific disclaimer
      $email_text .= "\n\n" . sprintf(EMAIL_DISCLAIMER_NEW_CUSTOMER, STORE_OWNER_EMAIL_ADDRESS). "\n\n";
	  $html_msg['EMAIL_DISCLAIMER'] = sprintf(EMAIL_DISCLAIMER_NEW_CUSTOMER, '<a href="mailto:' . STORE_OWNER_EMAIL_ADDRESS . '">'. STORE_OWNER_EMAIL_ADDRESS .' </a>');
// send welcome email
   zen_mail($name, $testimonials_mail, EMAIL_SUBJECT, $email_text, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, $html_msg, 'testimonial_add');
   
   ////SEND ADMIN EMAIL
   
   zen_mail($name, STORE_OWNER_EMAIL_ADDRESS, EMAIL_OWNER_SUBJECT, EMAIL_OWNER_TEXT, STORE_NAME, EMAIL_FROM, $html_msg, 'testimonial_add');
	 
// send additional emails
      if (SEND_EXTRA_CREATE_ACCOUNT_EMAILS_TO_STATUS == '1' and SEND_EXTRA_CREATE_ACCOUNT_EMAILS_TO !='') {
        if ($_SESSION['customer_id']) {
          $account_query = "select customers_firstname, customers_lastname, customers_email_address
                            from " . TABLE_CUSTOMERS . "
                            where customers_id = '" . (int)$_SESSION['customer_id'] . "'";

          $account = $db->Execute($account_query);
        }
	   $extra_info=email_collect_extra_info($name,$email_address, $account->fields['customers_firstname'] . ' ' . $account->fields['customers_lastname'] , $account->fields['customers_email_address'] );
       $html_msg['EXTRA_INFO'] = $extra_info['HTML'];
       zen_mail('', SEND_EXTRA_CREATE_ACCOUNT_EMAILS_TO, SEND_EXTRA_TESTIMONIALS_ADD_SUBJECT . ' ' . EMAIL_SUBJECT,
             $email_text . $extra_info['TEXT'], STORE_NAME, EMAIL_FROM, $html_msg, 'welcome_extra');
      }
 
 
 
	  
//////////////

      zen_redirect(zen_href_link(FILENAME_TESTIMONIALS_ADD, 'action=success', 'SSL'));

}
  }
  ///////////////////

if($_SESSION['customer_id']) {
  $sql = "SELECT c.customers_id, c.customers_firstname, c.customers_lastname, c.customers_email_address, c.customers_default_address_id, c.customers_telephone, ab.customers_id, ab.entry_street_address, ab.entry_company, ab.entry_city, ab.entry_postcode, ab.entry_zone_id, ab.entry_country_id, z.zone_id, z.zone_code, cn.countries_id, cn.countries_name FROM " . TABLE_CUSTOMERS . " c, " . TABLE_ADDRESS_BOOK . " ab, "  . TABLE_ZONES  . " z, " . TABLE_COUNTRIES . " cn WHERE c.customers_id = :customersID AND ab.customers_id = :customersID AND ab.entry_country_id = cn.countries_id";
  
  $sql = $db->bindVars($sql, ':customersID', $_SESSION['customer_id'], 'integer');
  $check_customer = $db->Execute($sql);
      $testimonials_mail = $check_customer->fields['customers_email_address'];
      $testimonials_name = $check_customer->fields['customers_firstname'] . ' ' . $check_customer->fields['customers_lastname'];
	  $testimonials_company = $check_customer->fields['entry_company'];
	  $testimonials_city = $check_customer->fields['entry_city'];

  if (isset($check_customer->fields['zone_id']) && zen_not_null($check_customer->fields['zone_id'])) {
        $testimonials_country = zen_get_zone_code($check_customer->fields['entry_country_id'], $check_customer->fields['entry_zone_id'], $check_customer->fields['entry_state']);
      }	  
	    $testimonials_country  .= ', ' . $check_customer->fields['countries_name'];
}

  // include template specific file name defines
$define_page = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_TESTIMONIALS_ADD, 'false');

    $breadcrumb->add(NAVBAR_TITLE);
//EOF