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
?>

<div class="centerColumn" id="testimonialDefault">
  <div class="title-box">
		<h2 class="title-under text-uppercase text-center">
      <?php echo HEADING_ADD_TITLE; ?>
    </h2>
  </div>
  <?php echo zen_draw_form('new_testimonial', zen_href_link(FILENAME_TESTIMONIALS_ADD, 'action=send', 'SSL')); ?>

  <?php
    if (isset($_GET['action']) && ($_GET['action'] == 'success')) {
  ?>

  <div class="mainContent alert alert-success success">
    <?php echo TESTIMONIAL_SUCCESS; ?>
  </div>
  <div class="buttonRow back btn btn--ys">
    <?php echo zen_back_link() . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) .'</a>'; ?>
  </div>
<?php
  } else {
?>
  <div class="card card--padding">
    <?php if (TESTIMONIAL_STORE_NAME_ADDRESS == 'true') { ?>
      <address><?php echo nl2br(STORE_NAME_ADDRESS); ?></address>
    <?php } ?>
    <?php if (DEFINE_TESTIMONIAL_STATUS >= '1' and DEFINE_TESTIMONIAL_STATUS <= '2') { ?>
      <div id="pageThreeMainContent">
      <?php
      require($define_page);
      ?>
      </div>
    <?php } ?>
  </div>

  <div class="card card--padding">
    <fieldset id="personal">
      <h4><?php echo TESTIMONIAL_CONTACT; ?></h4>
      <?php if ($messageStack->size('new_testimonial') > 0) echo $messageStack->output('new_testimonial'); ?>
      <div class="alert forward"><?php echo zen_image($template->get_template_dir(RETURN_REQUIRED_IMAGE, DIR_WS_TEMPLATE, $current_page_base,'images'). '/' . RETURN_REQUIRED_IMAGE, RETURN_REQUIRED_IMAGE_ALT, RETURN_REQUIRED_IMAGE_WIDTH, RETURN_REQUIRED_IMAGE_HEIGHT) . RETURN_REQUIRED_INFORMATION . zen_image($template->get_template_dir(RETURN_OPTIONAL_IMAGE, DIR_WS_TEMPLATE, $current_page_base,'images'). '/' . RETURN_OPTIONAL_IMAGE, RETURN_OPTIONAL_IMAGE_ALT, RETURN_OPTIONAL_IMAGE_WIDTH, RETURN_OPTIONAL_IMAGE_HEIGHT) . RETURN_OPTIONAL_INFORMATION; ?></div>
      
      <label class="inputLabel" for="testimonials_name"><?php echo (($error == true && $entry_name_error == true) ? TEXT_TESTIMONIALS_NAME . zen_image($template->get_template_dir(RETURN_WARNING_IMAGE, DIR_WS_TEMPLATE, $current_page_base,'images'). '/' . RETURN_WARNING_IMAGE, RETURN_WARNING_IMAGE_ALT, RETURN_WARNING_IMAGE_WIDTH, RETURN_WARNING_IMAGE_HEIGHT) : TEXT_TESTIMONIALS_NAME . zen_image($template->get_template_dir(RETURN_REQUIRED_IMAGE, DIR_WS_TEMPLATE, $current_page_base,'images'). '/' . RETURN_REQUIRED_IMAGE, RETURN_REQUIRED_IMAGE_ALT, RETURN_REQUIRED_IMAGE_WIDTH, RETURN_REQUIRED_IMAGE_HEIGHT)); ?></label>
      <br /><?php if($error == true && $entry_name_error == true) { echo ERROR_TESTIMONIALS_NAME_REQUIRED;} ?>
      <?php echo zen_draw_input_field('testimonials_name', $testimonials_name, 'size="25" id="testimonials_name"');?>
      <?php //echo (($error == true && $entry_name_error == true) ? zen_draw_input_field('testimonials_name', $testimonials_name, 'size="25" id="testimonials_name"') . ERROR_TESTIMONIALS_NAME_REQUIRED : zen_draw_input_field('testimonials_name', $testimonials_name, 'size="25" id="testimonials_name"')); ?>
      
      <label class="inputLabel" for="testimonials_mail"><?php echo (($error == true && $entry_email_error == true) ? TEXT_TESTIMONIALS_MAIL . zen_image($template->get_template_dir(RETURN_WARNING_IMAGE, DIR_WS_TEMPLATE, $current_page_base,'images'). '/' . RETURN_WARNING_IMAGE, RETURN_WARNING_IMAGE_ALT, RETURN_WARNING_IMAGE_WIDTH, RETURN_WARNING_IMAGE_HEIGHT) : TEXT_TESTIMONIALS_MAIL . zen_image($template->get_template_dir(RETURN_REQUIRED_IMAGE, DIR_WS_TEMPLATE, $current_page_base,'images'). '/' . RETURN_REQUIRED_IMAGE, RETURN_REQUIRED_IMAGE_ALT, RETURN_REQUIRED_IMAGE_WIDTH, RETURN_REQUIRED_IMAGE_HEIGHT)); ?></label>
      <br/><?php if ($error == true && $entry_email_error == true) { echo ERROR_TESTIMONIALS_EMAIL_REQUIRED; }?>
			<?php echo zen_draw_input_field('testimonials_mail', $testimonials_mail, 'size="25" id="testimonials_mail"'); ?>
			<?php //echo (($error == true && $entry_email_error == true) ? zen_draw_input_field('testimonials_mail', $testimonials_mail, 'size="25" id="testimonials_mail"') . ERROR_TESTIMONIALS_EMAIL_REQUIRED : zen_draw_input_field('testimonials_mail', $testimonials_mail, 'size="25" id="testimonials_mail"')); ?>
      
			<?php
        if (TESTIMONIALS_COMPANY == 'true') {
      ?>
      <label class="inputLabel" for="testimonials_company"><?php echo TEXT_TESTIMONIALS_COMPANY . zen_image($template->get_template_dir(RETURN_OPTIONAL_IMAGE, DIR_WS_TEMPLATE, $current_page_base,'images'). '/' . RETURN_OPTIONAL_IMAGE, RETURN_OPTIONAL_IMAGE_ALT, RETURN_OPTIONAL_IMAGE_WIDTH, RETURN_OPTIONAL_IMAGE_HEIGHT); ?></label>
      <?php echo zen_draw_input_field('testimonials_company', $testimonials_company, 'size="25" id="testimonials_company"'); ?>
      <?php
        }
      ?>
			
      <?php
        if (TESTIMONIALS_CITY == 'true') {
      ?>
      <label class="inputLabel" for="testimonials_city"><?php echo TEXT_TESTIMONIALS_CITY . zen_image($template->get_template_dir(RETURN_OPTIONAL_IMAGE, DIR_WS_TEMPLATE, $current_page_base,'images'). '/' . RETURN_OPTIONAL_IMAGE, RETURN_OPTIONAL_IMAGE_ALT, RETURN_OPTIONAL_IMAGE_WIDTH, RETURN_OPTIONAL_IMAGE_HEIGHT); ?></label>
      <?php echo zen_draw_input_field('testimonials_city', $testimonials_city, 'size="25" id="testimonials_city"'); ?>
      <?php
        }
      ?>
      
			<?php
        if (TESTIMONIALS_COUNTRY == 'true') {
      ?>
      <label class="inputLabel" for="testimonials_country"><?php echo TEXT_TESTIMONIALS_COUNTRY . zen_image($template->get_template_dir(RETURN_OPTIONAL_IMAGE, DIR_WS_TEMPLATE, $current_page_base,'images'). '/' . RETURN_OPTIONAL_IMAGE, RETURN_OPTIONAL_IMAGE_ALT, RETURN_OPTIONAL_IMAGE_WIDTH, RETURN_OPTIONAL_IMAGE_HEIGHT); ?></label>
      <?php echo zen_draw_input_field('testimonials_country', $testimonials_country, 'size="25" id="testimonials_country"'); ?>
      <br class="clearBoth" />
      <?php
        }
      ?>
    </fieldset>
    
    <fieldset id="write">
      <h4><?php echo TEXT_TESTIMONIALS_HTML_TEXT ; ?></h4>
      
      <label class="inputLabel" for="testimonials_title"><?php echo (($error == true && $entry_title_error == true) ? TEXT_TESTIMONIALS_TITLE . zen_image($template->get_template_dir(RETURN_WARNING_IMAGE, DIR_WS_TEMPLATE, $current_page_base,'images'). '/' . RETURN_WARNING_IMAGE, RETURN_WARNING_IMAGE_ALT, RETURN_WARNING_IMAGE_WIDTH, RETURN_WARNING_IMAGE_HEIGHT) : TEXT_TESTIMONIALS_TITLE . zen_image($template->get_template_dir(RETURN_REQUIRED_IMAGE, DIR_WS_TEMPLATE, $current_page_base,'images'). '/' . RETURN_REQUIRED_IMAGE, RETURN_REQUIRED_IMAGE_ALT, RETURN_REQUIRED_IMAGE_WIDTH, RETURN_REQUIRED_IMAGE_HEIGHT)); ?></label>
			<br/><?php if($error == true && $entry_title_error == true) { echo ERROR_TESTIMONIALS_TITLE_REQUIRED; }?>
      <?php echo zen_draw_input_field('testimonials_title', $testimonials_title, 'size="25" id="testimonials_title"'); ?>
			<?php //echo (($error == true && $entry_title_error == true) ? zen_draw_input_field('testimonials_title', $testimonials_title, 'size="25" id="testimonials_title"') . ERROR_TESTIMONIALS_TITLE_REQUIRED : zen_draw_input_field('testimonials_title', $testimonials_title, 'size="25" id="testimonials_title"')); ?>
      
      <?php if ($error == true && $entry_description_error == true) { ?>
      
			<label class="inputLabel" for="testimonials_html_text"><?php echo TEXT_TESTIMONIALS_DESCRIPTION . zen_image($template->get_template_dir(RETURN_WARNING_IMAGE, DIR_WS_TEMPLATE, $current_page_base,'images'). '/' . RETURN_WARNING_IMAGE, RETURN_WARNING_IMAGE_ALT, RETURN_WARNING_IMAGE_WIDTH, RETURN_WARNING_IMAGE_HEIGHT); ?></label>
			<br/><?php echo ERROR_TESTIMONIALS_DESCRIPTION_REQUIRED; ?>
      <?php echo zen_draw_textarea_field('testimonials_html_text', '30', '7', $testimonials_html_text, 'id="testimonials_html_text"'); ?>
			<div class="testimonialsSmallText"><?php echo TEXT_TESTIMONIALS_DESCRIPTION_INFO ; ?></div>
      
			<?php } else {  ?>
			
      <?php if ($error == true && $entry_description_big_error == true) { ?>

      <label class="inputLabel" for="testimonials_html_text"><?php echo TEXT_TESTIMONIALS_DESCRIPTION . zen_image($template->get_template_dir(RETURN_WARNING_IMAGE, DIR_WS_TEMPLATE, $current_page_base,'images'). '/' . RETURN_WARNING_IMAGE, RETURN_WARNING_IMAGE_ALT, RETURN_WARNING_IMAGE_WIDTH, RETURN_WARNING_IMAGE_HEIGHT); ?></label>
			<br/><?php echo ERROR_TESTIMONIALS_TEXT_MAX_LENGTH; ?>
      <?php echo zen_draw_textarea_field('testimonials_html_text', '30', '7', $testimonials_html_text, 'id="testimonials_html_text"'); ?>
			<div class="testimonialsSmallText"><?php echo TEXT_TESTIMONIALS_DESCRIPTION_INFO ; ?></div>
      
			<?php } else {  ?>
      
      <label class="inputLabel" for="testimonials_html_text"><?php echo TEXT_TESTIMONIALS_DESCRIPTION . zen_image($template->get_template_dir(RETURN_REQUIRED_IMAGE, DIR_WS_TEMPLATE, $current_page_base,'images'). '/' . RETURN_REQUIRED_IMAGE, RETURN_REQUIRED_IMAGE_ALT, RETURN_REQUIRED_IMAGE_WIDTH, RETURN_REQUIRED_IMAGE_HEIGHT); ?></label>
      <?php echo zen_draw_textarea_field('testimonials_html_text', '30', '7', $testimonials_html_text, 'id="testimonials_html_text"'); ?>
			<div class="testimonialsSmallText"><?php echo TEXT_TESTIMONIALS_DESCRIPTION_INFO ; ?></div>
      <?php } 
      }
      ?>
    </fieldset>
  </div>
	<div class="testimonial-links">
		<div class="buttonRow forward">
			<?php echo zen_image_submit(BUTTON_IMAGE_SUBMIT_TESTIMONIALS, BUTTON_TESTIMONIALS_SUBMIT_ALT); ?>
		</div>
		<div class="buttonRow back btn btn--ys">
			<?php echo zen_back_link() . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) .'</a>'; ?>
		</div>
	</div>
<?php
  }
?>
</form>
<br class="clearBoth" />
</div>