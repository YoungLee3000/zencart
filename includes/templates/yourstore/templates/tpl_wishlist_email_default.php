<div id="wishlist"> <!-- begin wishlist id for styling -->
	
	<div class="title-box">
		<h2 class="title-under text-uppercase text-center"><?php echo HEADING_TITLE . UN_LABEL_DELIMITER . $wishlist->fields['name']; ?></h2>
	</div>
	<div class="alert alert-info alert-dismissable">
		<button class="close" type="button" data-dismiss="alert" aria-hidden="true">&times;</button>
		<?php echo TEXT_DESCRIPTION; ?>
	</div>

	<?php if ($messageStack->size('wishlist_email') > 0) { 
        echo $messageStack->output('wishlist_email'); 
    } ?>

	<div class="alert-text forward"><?php echo FORM_REQUIRED_INFORMATION; ?></div>

	<?php echo zen_draw_form('wishlist_email', zen_href_link(UN_FILENAME_WISHLIST_EMAIL, 'action=process', 'SSL')); ?>
	<?php echo zen_draw_hidden_field('wid', $id); ?>
	<div class="send-mail card card--padding">
		<h4><?php echo FORM_TITLE; ?></h4>
		<div class="group">
			<div class="formrow">
				<label class="block" for="to_email_address">
					<?php echo FORM_LABEL_EMAIL . ' <span class="alertrequired">' . UN_TEXT_FORM_FIELD_REQUIRED . '</span>'; ?>
              	</label>
				<?php echo zen_draw_input_field('to_email_address', '', 'class="l"'); ?>
			</div>
			<div class="formrow">
				<label class="block" for="message"><?php echo FORM_LABEL_MESSAGE; ?></label>
				<?php echo zen_draw_textarea_field('message', 40, 8, sprintf(FORM_DEFAULT_BODY, STORE_NAME, $from_name)); ?> 
			</div>
		</div> <!-- end group -->
        <div class="buttons">
			<?php echo '<a href="' . zen_href_link(UN_FILENAME_WISHLIST, zen_get_all_get_params(), 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) . '</a>'; ?>
            <?php echo zen_image_submit(BUTTON_IMAGE_TELLAFRIEND, BUTTON_TELL_A_FRIEND_ALT, 'class="button-l"'); ?>
        </div>
	</div>
	
	</form>
	<dl class="footnote">
		<dd><?php echo TEXT_PRIVACY_EMAIL; ?></dd>
		<dd><?php echo TEXT_MESSAGE_FROM; ?></dd>
	</dl>
</div> <!-- end (un) id for styling -->