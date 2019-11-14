<div id="wishlist"> <!-- begin wishlist id for styling -->

	<div title="title-box">
		<h2 class="title-under text-uppercase text-center"><?php echo HEADING_TITLE; ?></h2>
	</div>
	<div class="alert alert-info alert-dismissable">
		<button class="close" type="button" data-dismiss="alert" aria-hidden="true">&times;</button>
		<?php echo TEXT_DESCRIPTION; ?>
	</div>

	<?php 
    if ( $messageStack->size('wishlists') > 0 ) { 
        echo $messageStack->output('wishlists'); 
    }
    ?>
	<div class="card card--padding">
        <ul class="simple-list">
            <li>
                <a href="<?php echo zen_href_link(UN_FILENAME_WISHLIST_FIND, '', 'SSL'); ?>">
                    <?php echo UN_TEXT_FIND_WISHLIST; ?>
                </a>
            </li>
            <?php if ( UN_ALLOW_MULTIPLE_WISHLISTS===true ) { ?>
            <li>
                <a href="<?php echo zen_href_link(UN_FILENAME_WISHLIST_EDIT, 'op=add', 'SSL'); ?>">
                    <?php echo UN_TEXT_NEW_WISHLIST; ?>
                </a>
            </li>
            <?php } ?>
        </ul>
	</div> 
	<?php if ( $records->RecordCount() > 0 ) { ?>

    <!-- record listing -->
    <div class="wishlist-lists">
    	<h4><?php echo TEXT_LISTING_TYPE; ?></h4>
		<?php
            $rows = 0;
            while (!$records->EOF) {
                if ( $rows & 1 ) {
                    $tdclass = 'even';
                } else {
                    $tdclass = 'odd';
                }
        ?>
		
		<div class="wishlist<?php echo (!un_is_empty($tdclass)? '-'.$tdclass: ''); ?>">
			<div class="card--padding card">
				<!-- data -->
				<h4>
                	<a href="<?php echo zen_href_link(UN_FILENAME_WISHLIST, 'wid='.$records->fields['id'], 'SSL'); ?>">
						<?php echo $records->fields['name']; ?>
                    </a>
              	</h4>
                <ul class="simple-list">
                    <li>
                        <?php echo TABLE_HEADING_ITEMS . UN_LABEL_DELIMITER . $records->fields['items_count']; ?> 
                        <?php if ( $records->fields['items_count']>0 ) { ?>
                            <?php echo TEXT_ACTION_DELIMITER; ?>
                            <a href="<?php echo zen_href_link(UN_FILENAME_WISHLIST_MOVE, 'wid='.$records->fields['id'], 'SSL'); ?>">
                                <?php echo TEXT_MOVE; ?>
                                
                            </a>
                        <?php } ?>
                    </li>
                    <li>
                        <?php echo TABLE_HEADING_COMMENT . UN_LABEL_DELIMITER . $records->fields['comment']; ?>
                    </li>
                    <li>
                        <?php echo TABLE_HEADING_DEFAULT . UN_LABEL_DELIMITER; ?>
                        <?php if ( $records->fields['default_status']==1 ) { ?>
                            <?php echo TEXT_YES; ?>
                        <?php } else { ?>
                            <?php echo TEXT_NO; ?> 
                            <?php echo TEXT_ACTION_DELIMITER; ?>
                            <a href="<?php echo zen_href_link(UN_FILENAME_WISHLISTS, 'wid='.$records->fields['id'].'&op=default', 'SSL'); ?>" title="<?php echo TEXT_MAKE_DEFAULT; ?>"><?php echo TEXT_MAKE_DEFAULT; ?></a>
                        <?php } ?>
                    </li>
                    <li>
                        <?php echo TABLE_HEADING_PUBLIC . UN_LABEL_DELIMITER; ?>
                        <?php if ( $records->fields['public_status']==1 ) { ?>
                            <a href="<?php echo zen_href_link(UN_FILENAME_WISHLISTS, 'wid='.$records->fields['id'].'&op=deact', 'SSL'); ?>" title="<?php echo TEXT_MAKE_PRIVATE; ?>"><?php echo TEXT_YES; ?></a> 
                            <?php echo TEXT_ACTION_DELIMITER; ?>
                            <a href="<?php echo zen_href_link(UN_FILENAME_WISHLIST_EMAIL, 'wid='.$records->fields['id'], 'SSL'); ?>" title="<?php echo UN_TEXT_EMAIL_WISHLIST; ?>"><?php echo UN_TEXT_EMAIL_WISHLIST; ?></a>
                        <?php } else { ?>
                            <a href="<?php echo zen_href_link(UN_FILENAME_WISHLISTS, 'wid='.$records->fields['id'].'&op=act', 'SSL'); ?>" title="<?php echo TEXT_MAKE_PUBLIC; ?>"><?php echo TEXT_NO; ?></a>
                        <?php } ?>
                    </li>
                </ul>
                <!-- buttons -->
                <div class="buttons" style="float:none;margin-top:10px;text-align:left">
                    <a class="btn btn--ys" href="<?php echo zen_href_link(UN_FILENAME_WISHLIST_EDIT, 'wid='.$records->fields['id'].'&op=edit', 'SSL'); ?>" title="<?php echo BUTTON_EDIT_SMALL_ALT; ?>"><?php echo zen_image_button(BUTTON_IMAGE_EDIT_SMALL, BUTTON_EDIT_SMALL_ALT, ''); ?></a>
                    <a class="btn btn--ys" href="<?php echo zen_href_link(UN_FILENAME_WISHLISTS, 'wid='.$records->fields['id'].'&op=del', 'SSL'); ?>" title="<?php echo  BUTTON_DELETE_SMALL_ALT; ?>"><?php echo zen_image_button(BUTTON_IMAGE_DELETE_SMALL, BUTTON_DELETE_SMALL_ALT, ''); ?></a>
                </div>
			</div>
		</div> <!-- end div.wishlist -->
		<?php $rows ++; ?>
		<?php $records->MoveNext(); ?>
	<?php } // end while records ?>
   	</div>
<!-- end records listing -->

<?php } else { ?>

	<div class="alert alert-danger alert-dismissable">
		<?php echo TEXT_NO_RECORDS; ?>
   	</div>

<?php } // end RecordCount > 0 ?>

<div class="buttons">
<?php echo zen_back_link() . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) . '</a>'; ?>
</div>

</div> <!-- end (un) id for styling -->