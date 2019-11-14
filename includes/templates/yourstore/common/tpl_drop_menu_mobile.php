<nav id="off-canvas-menu">
	<ul class="expander-list">
			<li>
				<span class="name">
					<a href="<?php echo zen_href_link(FILENAME_DEFAULT, '', 'SSL'); ?>"><span class="act-underline"><?php echo HEADER_TITLE_CATALOG; ?></span></a>
				</span>
			</li>
			<?php if(file_exists($template->get_template_dir('define_mobile_menu_static_content.php',DIR_WS_TEMPLATE, $current_page_base,'define_templates'). '/define_mobile_menu_static_content.php')){
				require($template->get_template_dir('define_mobile_menu_static_content.php',DIR_WS_TEMPLATE, $current_page_base,'define_templates'). '/define_mobile_menu_static_content.php');
			} ?>
			<li>
				<span class="name">
					<span class="expander">-</span>
					<a href="#"><span class="act-underline"><?php echo HEADER_TITLE_CATEGORIES; ?></span></a>
				</span>
				<?php
						//Display Categories
						echo $pzen_menu['simple'];
					?>
			</li>
			<!--Display the EZ Pages link in Menu. Uncomment if needed. -->
			<?php if (EZPAGES_STATUS_HEADER == '1' or (EZPAGES_STATUS_HEADER == '2' and (strstr(EXCLUDE_ADMIN_IP_FOR_MAINTENANCE, $_SERVER['REMOTE_ADDR'])))) { ?>
				<!-- <li>
					<span class="name">
						<span class="expander">-</span>
						<a href="javascript:void();">
							<span class="act-underline"><?php echo HEADER_TITLE_EZPAGES; ?></span>
						</a>
					</span>
					<ul class="dropdown-menu megamenu image-links-layout" role="menu">
						<?php require($template->get_template_dir('tpl_ezpages_bar_header.php',DIR_WS_TEMPLATE,$current_page_base,'templates'). '/tpl_ezpages_bar_header.php'); ?>
					</ul>    
				</li>   -->
			<?php } ?>
			<!--EZ Pages Menu Ends Here-->
		</ul>
</nav>