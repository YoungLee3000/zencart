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

  require('includes/application_top.php');
  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  if (zen_not_null($action)) {
    switch ($action) {
      case 'setflag':
        if ( ($_GET['flag'] == '0') || ($_GET['flag'] == '1') ) {
          zen_set_testimonials_status($_GET['bID'], $_GET['flag']);
          $messageStack->add_session(SUCCESS_PAGE_STATUS_UPDATED, 'success');
        } else {
          $messageStack->add_session(ERROR_UNKNOWN_STATUS_FLAG, 'error');
        }
        zen_redirect(zen_href_link(FILENAME_TESTIMONIALS_MANAGER, 'page=' . $_GET['page'] . '&bID=' . $_GET['bID']));
        break;
      case 'insert':
      case 'update':
        if (isset($_POST['testimonials_id'])) $testimonials_id = zen_db_prepare_input($_POST['testimonials_id']);
        $testimonials_title = zen_db_prepare_input($_POST['testimonials_title']);
        $testimonials_url = zen_db_prepare_input($_POST['testimonials_url']);
		$testimonials_name = zen_db_prepare_input($_POST['testimonials_name']);
		$testimonials_mail = zen_db_prepare_input($_POST['testimonials_mail']);
		$testimonials_date = (empty($_POST['date_added']) ? zen_db_prepare_input('0001-01-01 00:00:00') : zen_db_prepare_input($_POST['date_added']));

		$testimonials_company = zen_db_prepare_input($_POST['testimonials_company']);
		$testimonials_city = zen_db_prepare_input($_POST['testimonials_city']);
		$testimonials_country = zen_db_prepare_input($_POST['testimonials_country']);
        $testimonials_html_text = zen_db_prepare_input($_POST['testimonials_html_text']);
        $page_error = false;
        if (empty($testimonials_name)) {
          $messageStack->add(ERROR_PAGE_AUTHOR_REQUIRED, 'error');
          $page_error = true;
        }
        if (empty($testimonials_mail)) {
          $messageStack->add(ERROR_PAGE_EMAIL_REQUIRED, 'error');
          $page_error = true;
        }
        if (empty($testimonials_title)) {
          $messageStack->add(ERROR_PAGE_TITLE_REQUIRED, 'error');
          $page_error = true;
        }
        if (empty($testimonials_html_text)) {
		$messageStack->add(ERROR_PAGE_TEXT_REQUIRED, 'error');
          $page_error = true;
        }
        if ($page_error == false) {
		$language_id = (int)$_SESSION['languages_id'];
          $sql_data_array = array('testimonials_title' => $testimonials_title,
		                          'language_id' => $language_id,
								  'testimonials_url' => $testimonials_url,
		  						  'testimonials_name' => $testimonials_name,
		  						   'testimonials_mail' => $testimonials_mail,
		  						   'testimonials_company' => $testimonials_company,
		  						   'testimonials_city' => $testimonials_city,
		  						   'testimonials_country' => $testimonials_country,
                                   'testimonials_html_text' => $testimonials_html_text);
          if ($action == 'insert') {
		if (empty($_POST['date_added'])) {
		$testimonials_date = 'now()';
		}else {
		$testimonials_date = zen_date_raw($_POST['date_added']);
		}
            $insert_sql_data = array('status' => '1', 'date_added' => $testimonials_date);
            $sql_data_array = array_merge($sql_data_array, $insert_sql_data);
            zen_db_perform(TABLE_TESTIMONIALS_MANAGER, $sql_data_array);	
            $testimonials_id = zen_db_insert_id();
            $messageStack->add_session(SUCCESS_PAGE_INSERTED, 'success');
          } elseif ($action == 'update') {
            $insert_sql_data = array('status' => '1', 'last_update' => 'now()');
            $sql_data_array = array_merge($sql_data_array, $insert_sql_data);
            zen_db_perform(TABLE_TESTIMONIALS_MANAGER, $sql_data_array, 'update', "testimonials_id = '" . (int)$testimonials_id . "'");
            $messageStack->add_session(SUCCESS_PAGE_UPDATED, 'success');
          }
 
 
 
 if ($testimonials_image = new upload('testimonials_image')) {
          $testimonials_image->set_destination(DIR_FS_CATALOG_IMAGES . TESTIMONIAL_IMAGE_DIRECTORY);
          if ($testimonials_image->parse() && $testimonials_image->save()) {
            $testimonials_image_name = TESTIMONIAL_IMAGE_DIRECTORY . $testimonials_image->filename;
          }
          if ($testimonials_image->filename != 'none' && $testimonials_image->filename != '') {
            $db->Execute("update " . TABLE_TESTIMONIALS_MANAGER . "
                          set testimonials_image = '" . $testimonials_image_name . "'
                          where testimonials_id = '" . (int)$testimonials_id . "'");
          } else {

            if ($testimonials_image->filename == 'none' || $_POST['image_delete'] == 1) {
//		  if ($testimonials_image->filename == 'none') {
              $db->Execute("update " . TABLE_TESTIMONIALS_MANAGER . "
                            set testimonials_image = ''
                            where testimonials_id = '" . (int)$testimonials_id . "'");
            }
          }
        }
 
 
 
 
          zen_redirect(zen_href_link(FILENAME_TESTIMONIALS_MANAGER, (isset($_GET['page']) ? 'page=' . $_GET['page'] . '&' : '') . 'bID=' . $testimonials_id));
        } else {
          $action = 'new';
        }
        break;
      case 'deleteconfirm':
        $testimonials_id = zen_db_prepare_input($_GET['bID']);
        $db->Execute("delete from " . TABLE_TESTIMONIALS_MANAGER . " where testimonials_id = '" . (int)$testimonials_id . "'");
        $messageStack->add_session(SUCCESS_PAGE_REMOVED, 'success');
        zen_redirect(zen_href_link(FILENAME_TESTIMONIALS_MANAGER, 'page=' . $_GET['page']));
        break;
    }
  }
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script type="text/javascript" src="includes/menu.js"></script>
<script type="text/javascript" src="includes/general.js"></script>
<script type="text/javascript">
  <!--
  function init()
  {
    cssjsmenu('navbar');
    if (document.getElementById)
    {
      var kill = document.getElementById('hoverJS');
      kill.disabled = true;
    }
  if (typeof _editor_url == "string") HTMLArea.replaceAll();
  }
  // -->
</script>
</head>
<body onLoad="init()">
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->
<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo zen_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
<?php
  if ($action == 'new') {
    $form_action = 'insert';

    $parameters = array('testimonials_title' => '',
	                    'language_id' => '',
						'testimonials_url' => '',    
						'testimonials_name' => '',
	                    'testimonials_mail' => '',
		  				'testimonials_company' => '',
		  				'testimonials_city' => '',
		  				'testimonials_country' => '',
						'testimonials_image' => '',
                        'testimonials_html_text' => '',
						'date_added' => '',
                        'status' =>'');

    $bInfo = new objectInfo($parameters);

    if (isset($_GET['bID'])) {
      $form_action = 'update';

      $bID = zen_db_prepare_input($_GET['bID']);

      $page_query = "select * from " . TABLE_TESTIMONIALS_MANAGER . " where testimonials_id = '" . $_GET['bID'] . "'";
      $page = $db->Execute($page_query);
      $bInfo->objectInfo($page->fields);
    } elseif (zen_not_null($_POST)) {
      $bInfo->objectInfo($_POST);
    }
?>
      <tr>
        <td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr><?php echo zen_draw_form('new_page', FILENAME_TESTIMONIALS_MANAGER, (isset($_GET['page']) ? 'page=' . $_GET['page'] . '&' : '') . 'action=' . $form_action, 'post', 'enctype="multipart/form-data"'); if ($form_action == 'update') echo zen_draw_hidden_field('testimonials_id', $bID); ?>
        <td><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><?php echo TEXT_TESTIMONIALS_NAME; ?></td>
            <td class="main"><?php echo zen_draw_input_field('testimonials_name', $bInfo->testimonials_name, '', true) . TEXT_FIELD_REQUIRED; ?></td>
          </tr>
		  <tr>
            <td class="main"><?php echo TEXT_TESTIMONIALS_MAIL; ?></td>
            <td class="main"><?php echo zen_draw_input_field('testimonials_mail', $bInfo->testimonials_mail, '', true) . TEXT_FIELD_REQUIRED; ?></td>
          </tr>
		  <?php if ($form_action == 'insert') { ?>
		  <tr>
            <td colspan=2><?php echo TEXT_TESTIMONIALS_DATE_INFO; ?></td>
			</tr>
			<tr>
			<td class="main"><?php echo TEXT_TESTIMONIALS_DATE; ?></td>
            <td class="main"><?php echo zen_draw_input_field('date_added', zen_date_short($bInfo->date_added), '', false) . TEXT_TESTIMONIALS_OPTIONAL . ENTRY_DATE_ADDED_TEXT; ?></td>
          </tr>
		  <?php
		  }
		  ?>
		  <tr>
            <td class="main"><?php echo TEXT_TESTIMONIALS_COMPANY; ?></td>
            <td class="main"><?php echo zen_draw_input_field('testimonials_company', $bInfo->testimonials_company, '', false) . TEXT_TESTIMONIALS_OPTIONAL; ?></td>
          </tr>

		  <tr>
            <td class="main"><?php echo TEXT_TESTIMONIALS_CITY; ?></td>
            <td class="main"><?php echo zen_draw_input_field('testimonials_city', $bInfo->testimonials_city, '', false) . TEXT_TESTIMONIALS_OPTIONAL; ?></td>
          </tr>
		  <tr>
            <td class="main"><?php echo TEXT_TESTIMONIALS_COUNTRY; ?></td>
            <td class="main"><?php echo zen_draw_input_field('testimonials_country', $bInfo->testimonials_country, '', false) . TEXT_TESTIMONIALS_OPTIONAL; ?></td>
          </tr>
		  <tr>
            <td class="main"><?php echo TEXT_TESTIMONIALS_URL; ?></td>			
            <td class="main"><?php echo zen_draw_input_field('testimonials_url', zen_not_null($bInfo->testimonials_url) ? $bInfo->testimonials_url : 'http://', 'maxlength="255"', false) . TEXT_TESTIMONIALS_OPTIONAL; ?></td>		
          </tr>
		   <tr>
            <td class="main"><?php echo TEXT_TESTIMONIALS_TITLE; ?></td>
            <td class="main"><?php echo zen_draw_input_field('testimonials_title', $bInfo->testimonials_title, '', true) . TEXT_FIELD_REQUIRED; ?></td>
          </tr>

          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_TESTIMONIALS_HTML_TEXT; ?></td>
            <td class="main"><?php echo zen_draw_textarea_field('testimonials_html_text', 'soft', '60', '10', $bInfo->testimonials_html_text, '', true) . TEXT_FIELD_REQUIRED; ?></td>
          </tr>
		  
		  
    <?php
     if (($bInfo->testimonials_image) != ('')) {
   ?>
           <tr>
            <td valign="top" class="main"><?php echo TEXT_INFO_CURRENT_IMAGE; ?></td>
			<td class="main"><?php echo $bInfo->testimonials_image; ?></td>
          </tr>
<?php
}
?> 

           <tr>
            <td valign="top" class="main"><?php echo TEXT_INFO_PAGE_IMAGE; ?></td>
			<td class="main"><?php echo zen_draw_file_field('testimonials_image') . TEXT_TESTIMONIALS_OPTIONAL; ?></td>
          </tr>

		  <tr>
			<td class="main"><?php echo TEXT_IMAGES_TESTIMONIALS_DELETE; ?></td>
            <td class="main"><?php echo zen_draw_radio_field('image_delete', '0', 'checked="checked"', $off_image_delete) . '&nbsp;' . TABLE_HEADING_NO . ' ' . zen_draw_radio_field('image_delete', '1', $on_image_delete) . '&nbsp;' . TABLE_HEADING_YES; ?></td>
			</tr>

		  
          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td colspan="2" class="main" align="left" valign="top" nowrap><?php echo (($form_action == 'insert') ? zen_image_submit('button_insert.gif', IMAGE_INSERT) : zen_image_submit('button_update.gif', IMAGE_UPDATE)). '&nbsp;&nbsp;<a href="' . zen_href_link(FILENAME_TESTIMONIALS_MANAGER, (isset($_GET['page']) ? 'page=' . $_GET['page'] . '&' : '') . (isset($_GET['bID']) ? 'bID=' . $_GET['bID'] : '')) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>'; ?></td>
          </tr>
        </table></td>
      </form></tr>
<?php
  } else {
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow" width="100%">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_TESTIMONIALS; ?></td>
				<td class="dataTableHeadingContent"><?php echo TABLE_HEADING_NAME; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_MAIL; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_DATE_ADDED; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent"></td>
                <td class="dataTableHeadingContent"></td>
              </tr>

<?php
    $testimonials_query_raw = "select testimonials_id, language_id, testimonials_image, testimonials_title, testimonials_name, testimonials_mail, testimonials_html_text, status, date_added, last_update from " . TABLE_TESTIMONIALS_MANAGER . " order by date_added DESC, testimonials_title";
    $testimonials_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $testimonials_query_raw, $testimonials_query_numrows);
    $testimonials = $db->Execute($testimonials_query_raw);

while (!$testimonials->EOF) {
     if ((!isset($_GET['bID']) || (isset($_GET['bID']) && ($_GET['bID'] == $testimonials->fields['testimonials_id']))) && !isset($bInfo) && (substr($action, 0, 3) != 'new')) {
        $bInfo_array = array_merge($testimonials->fields);
        $bInfo = new objectInfo($bInfo_array);
      }
      if (isset($bInfo) && is_object($bInfo) && ($testimonials->fields['testimonials_id'] == $bInfo->testimonials_id)) {
        echo '              <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link(FILENAME_TESTIMONIALS_MANAGER, 'page=' . $_GET['page'] . '&bID=' . $testimonials->fields['testimonials_id']) . '\'">' . "\n";
      } else {
        echo '              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link(FILENAME_TESTIMONIALS_MANAGER, 'testimonials=' . $_GET['page'] . '&bID=' . $testimonials->fields['testimonials_id']) . '\'">' . "\n";
      }
?>
                <td class="dataTableContent"><?php echo $testimonials->fields['testimonials_title']; ?></td>
                 <td class="dataTableContent" align="left"><?php echo $testimonials->fields['testimonials_name']; ?></td>
				<td class="dataTableContent" align="left"><?php echo $testimonials->fields['testimonials_mail']; ?></td>
                <td class="dataTableContent"><?php echo $testimonials->fields['date_added']; ?></td>
                <td class="dataTableContent" align="center">
<?php
      if ($testimonials->fields['status'] == '1') {
        echo zen_image(DIR_WS_IMAGES . 'icon_status_green.gif', 'Approved', 10, 10) . '&nbsp;&nbsp;<a href="' . zen_href_link(FILENAME_TESTIMONIALS_MANAGER, 'page=' . $_GET['page'] . '&bID=' . $testimonials->fields['testimonials_id'] . '&action=setflag&flag=0') . '">' . zen_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', 'Set Pending', 10, 10) . '</a>';
      } else {
        echo '<a href="' . zen_href_link(FILENAME_TESTIMONIALS_MANAGER, 'page=' . $_GET['page'] . '&bID=' . $testimonials->fields['testimonials_id'] . '&action=setflag&flag=1') . '">' . zen_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', 'Set Approved', 10, 10) . '</a>&nbsp;&nbsp;' . zen_image(DIR_WS_IMAGES . 'icon_status_red.gif', 'Pending', 10, 10);
      }
?></td>
                <td class="dataTableContent" align="right"><?php if (isset($bInfo) && is_object($bInfo) && ($testimonials->fields['testimonials_id'] == $bInfo->testimonials_id)) { echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . zen_href_link(FILENAME_TESTIMONIALS_MANAGER, zen_get_all_get_params(array('bID')) . 'bID=' . $testimonials->fields['testimonials_id']) . '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
                <td class="dataTableContent" align="right"></td>
              </tr>
<?php

 $testimonials->MoveNext();
    }
?>
                  <tr>
                    <td class="smallText" valign="top"><?php echo $testimonials_split->display_count($testimonials_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_TESTIMONIALS); ?></td>
                    <td class="smallText" align="right"><?php echo $testimonials_split->display_links($testimonials_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], zen_get_all_get_params(array('page', 'info', 'x', 'y', 'lID'))); ?></td>
                  </tr>


              <tr>
                <td colspan="5"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td align="right" colspan="2"><?php echo '<a href="' . zen_href_link(FILENAME_TESTIMONIALS_MANAGER, 'action=new') . '">' . zen_image_button('button_new_testimonial.gif', IMAGE_NEW_PAGE) . '</a>'; ?></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
<?php
if ($bInfo->status == 0) {
$teststatus = 'Pending';
} else {
$teststatus = 'Approved';
}
  $heading = array();
  $contents = array();
  switch ($action) {
    case 'delete':
      $heading[] = array('text' => '<b>' . $bInfo->testimonials_title . '</b>');

      $contents = array('form' => zen_draw_form('testimonials', FILENAME_TESTIMONIALS_MANAGER, 'page=' . $_GET['page'] . '&bID=' . $bInfo->testimonials_id . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
      $contents[] = array('text' => '<br /><b>' . $bInfo->testimonials_title . '</b>');
      if ($bInfo->testimonials_image) $contents[] = array('text' => '<br />' . zen_draw_checkbox_field('delete_image', 'on', true) . ' ' . TEXT_INFO_DELETE_IMAGE);
      $contents[] = array('align' => 'center', 'text' => '<br />' . zen_image_submit('button_delete.gif', IMAGE_DELETE) . '&nbsp;<a href="' . zen_href_link(FILENAME_TESTIMONIALS_MANAGER, 'page=' . $_GET['page'] . '&bID=' . $_GET['bID']) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
    default:
      if (is_object($bInfo)) {
	  
        $heading[] = array('text' => '<b>' . $bInfo->testimonials_title . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a href="' . zen_href_link(FILENAME_TESTIMONIALS_MANAGER, 'page=' . $_GET['page'] . '&bID=' . $bInfo->testimonials_id . '&action=new') . '">' . zen_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . zen_href_link(FILENAME_TESTIMONIALS_MANAGER, 'page=' . $_GET['page'] . '&bID=' . $bInfo->testimonials_id . '&action=delete') . '">' . zen_image_button('button_delete.gif', IMAGE_DELETE) . '</a><br /><br /><br />');

        $contents[] = array('text' => '<br />' . TEXT_INFO_TESTIMONIALS_STATUS . ' '  . $teststatus);

		if (zen_not_null($bInfo->testimonials_image)) {
        $contents[] = array('text' => '<br />' . zen_image(DIR_WS_CATALOG_IMAGES . $bInfo->testimonials_image, $bInfo->testimonials_title, TESTIMONIAL_IMAGE_WIDTH, TESTIMONIAL_IMAGE_HEIGHT) . '<br />' . $bInfo->testimonials_title);
		} else {
		$contents[] = array('text' => '<br />' . TEXT_IMAGE_NONEXISTENT);
		}
        $contents[] = array('text' => '<br />' . TEXT_INFO_TESTIMONIALS_CONTACT_NAME . ' '  . $bInfo->testimonials_name);
        $contents[] = array('text' => '<br />' . TEXT_INFO_TESTIMONIALS_CONTACT_EMAIL . ' ' . $bInfo->testimonials_mail);

        $contents[] = array('text' => '<br />' . TEXT_INFO_TESTIMONIALS_DESCRIPTION . '<br /> ' . $bInfo->testimonials_html_text);

        $contents[] = array('text' => '<br />' . TEXT_DATE_TESTIMONIALS_CREATED . ' ' . zen_date_short($bInfo->date_added));

        if (zen_not_null($bInfo->last_update)) {
          $contents[] = array('text' => TEXT_DATE_TESTIMONIALS_LAST_MODIFIED . ' ' . zen_date_short($bInfo->last_update));
        } else {		
          $contents[] = array('text' => TEXT_DATE_TESTIMONIALS_LAST_MODIFIED);
		}
		
        if ($bInfo->date_scheduled) $contents[] = array('text' => '<br />' . sprintf(TEXT_TESTIMONIALS_SCHEDULED_AT_DATE, zen_date_short($bInfo->date_scheduled)));

        if ($bInfo->expires_date) {
          $contents[] = array('text' => '<br />' . sprintf(TEXT_TESTIMONIALS_EXPIRES_AT_DATE, zen_date_short($bInfo->expires_date)));
        } elseif ($bInfo->expires_impressions) {
          $contents[] = array('text' => '<br />' . sprintf(TEXT_TESTIMONIALS_EXPIRES_AT_IMPRESSIONS, $bInfo->expires_impressions));
        }

        if ($bInfo->date_status_change) $contents[] = array('text' => '<br />' . sprintf(TEXT_TESTIMONIALS_STATUS_CHANGE, zen_date_short($bInfo->date_status_change)));
      }
      break;
  }

  if ( (zen_not_null($heading)) && (zen_not_null($contents)) ) {
    echo '            <td width="25%" valign="top">' . "\n";

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '            </td>' . "\n";
  }
?>
          </tr>
        </table></td>
      </tr>
<?php
  }
?>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>