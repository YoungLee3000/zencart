<h4 class="text-left  title-under  mobile-collapse__title"><?php echo FOOTER_TITLE_MY_ACCOUNT; ?></h4>
	<div class="v-links-list mobile-collapse__content">
		<ul>
			<li>
				<a href="<?php echo zen_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL'); ?>">
					<?php echo FOOTER_TITLE_ORDER_HISTORY; ?>
				</a>
			</li>
			<?php if (UN_MODULE_WISHLISTS_ENABLED) { ?>
			<li>
				<a href="<?php echo zen_href_link(wishlist, '', 'SSL'); ?>">
					<?php echo HEADER_TITLE_WISHLIST; ?>
				</a>
			</li>
			<?php } ?>
			<?php if(COMPARE_VALUE_COUNT > 0) { ?>
			<li>
				<a href="<?php echo zen_href_link(compare, '', 'SSL'); ?>">
					<?php echo HEADER_TITLE_COMPARE; ?>
				</a>
			</li>
			<?php } ?>
			<li>
				<a href="<?php echo zen_href_link(FILENAME_ACCOUNT_PASSWORD, '', 'SSL'); ?>">
					<?php echo FOOTER_TITLE_CHANGE_PASSWORD; ?>
				</a>
			</li>
			<li>
				<a href="<?php echo zen_href_link(FILENAME_LOGIN, '', 'SSL'); ?>">                                    			
					<?php echo FOOTER_TITLE_CREATE_ACCOUNT; ?>
				</a>
			</li>
		</ul>
	</div>
