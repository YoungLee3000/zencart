<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
// |                                                                      |
// | http://www.zen-cart.com/index.php                                    |
// |                                                                      |
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
// $Id: tpl_drop_menu.php  2005/06/15 15:39:05 DrByte Exp $
//

?>
<?php
  if(isset($_REQUEST['pg']))
  {
    $pg=$_REQUEST['pg'];
  }
  $menutype=get_pzen_options("menu_type");
  if($menutype==1){
	  /**================================================================
	  ** Simple Menu
	  **================================================================*/
	  ?>
	  <!-- menu area -->
		<nav class="<?php echo $navbar_class; ?>">
			<div class="responsive-menu" id="mainMenu">									
				<!-- Mobile menu Button-->
				<div class="col-xs-2 visible-mobile-menu-on">
					<div class="expand-nav compact-hidden">
						<a href="#off-canvas-menu" id="off-canvas-menu-toggle">
							<button type="button" class="navbar-toggle"> 
								<span class="icon-bar"></span> 
								<span class="icon-bar"></span> 
								<span class="icon-bar"></span> 
								<span class="menu-text"><?php echo TEXT_DROP_MENU; ?></span> 
							</button>
						</a>
					</div>
				</div>
				<!-- //end Mobile menu Button -->
				<ul class="nav navbar-nav mn1">
					<li class="dl-close"><a href="#"><span class="icon icon-close"></span><?php echo TEXT_DROP_MENU_CLOSE; ?></a></li>
					<li id='home'>
						<a href="<?php echo zen_href_link(FILENAME_DEFAULT, '', 'SSL'); ?>">
							<span class="act-underline"><?php echo HEADER_TITLE_CATALOG; ?></span>
						</a>
					</li>
					<!--Categories Link in Menu-->
					<?php 
						//$cat_query = "select * from ".DB_PREFIX."categories where categories_status='1' ORDER BY RAND() LIMIT 1";
						//$category = $db->Execute($cat_query);
						//$categories_id=$category->fields['categories_id'];
					?>
					<li id='categories' class="dropdown" >
						<span class="dropdown-toggle extra-arrow"></span>
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<span class="act-underline"><?php echo HEADER_TITLE_CATEGORIES; ?></span>
						</a>
					<?php
						//Display Categories
						echo $pzen_menu['simple'];
					?>
					</li>
					<!--Categories Link in Menu Ends-->
					<!--Manufacturers Link in Menu-->
					<?php
						global $languages_id, $db;
						$mn_manfact_query = "SELECT m.manufacturers_id, m.manufacturers_name, m.manufacturers_image FROM ".DB_PREFIX."manufacturers m GROUP BY m.manufacturers_id ORDER BY m.manufacturers_name" ;
						$mn_manfact = $db->Execute($mn_manfact_query);
					?>
					<?php if (count($mn_manfact) > 0 ) { ?>
					<li id='brands' class="submenu" >
						<span class="extra-arrow"></span>
						<a href="<?php echo zen_href_link(FILENAME_MANUFACTURERS_ALL,'&pg=brands', 'SSL'); ?>">
							<span class="act-underline"><?php echo HEADER_TITLE_MANUFACTURER; ?></span>
						</a>
						<ul class="level2" role="menu">
							<li class="dl-back"><a href="#"><span class="icon icon-chevron_left"></span><?php echo TEXT_BACK ?></a></li>	
							<?php
								while (!$mn_manfact->EOF) {
									$mn_manfact_id=$mn_manfact->fields['manufacturers_id'];
									$mn_manfact_name=$mn_manfact->fields['manufacturers_name'];
										if($mn_manfact_name !='' ) { ?>
											<li><a href="<?php echo zen_href_link("index&manufacturers_id=".$mn_manfact_id."&pg=brands",'', 'SSL'); ?>">
												<?php echo $mn_manfact_name; ?></a>			
											</li>
									<?php }
									$mn_manfact->MoveNext();
								}
							?>
						</ul>
					</li>
					<?php } ?>
					<!--Manufacturers Link in Menu Ends-->
					<!--Display the EZ Pages link in Menu. Uncomment if needed. -->
					 <?php if (EZPAGES_STATUS_HEADER == '1' or (EZPAGES_STATUS_HEADER == '2' and (strstr(
							EXCLUDE_ADMIN_IP_FOR_MAINTENANCE, $_SERVER['REMOTE_ADDR'])))) { ?>
							 <!-- <li id='ezpages' class="submenu">
									<span class="dropdown-toggle extra-arrow"></span>
									<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void();">
										<span class="act-underline"><?php echo HEADER_TITLE_EZPAGES; ?></span>
									</a>
									<ul class="level2" role="menu">
										<li class="dl-back"><a href="#"><span class="icon icon-chevron_left"></span><?php echo TEXT_BACK ?></a></li>	
										<?php require($template->get_template_dir('tpl_ezpages_bar_header.php',DIR_WS_TEMPLATE,$current_page_base,'templates'). '/tpl_ezpages_bar_header.php'); ?>
									</ul>    
								</li>   -->
					<?php } ?> 
					<!--EZ Pages Menu Ends Here-->
				</ul>
			</div>
		</nav>
	<?php }else if($menutype==2){ ?>
	<?php 
	/**================================================================
	** Mega Menu
	**================================================================*/
	?>
	<!-- navigation start -->
	<nav class="<?php echo $navbar_class; ?>">
		<div class="responsive-menu" id="mainMenu">									
			<!-- Mobile menu Button-->
			<div class="col-xs-2 visible-mobile-menu-on">
				<div class="expand-nav compact-hidden">
					<a href="#off-canvas-menu" id="off-canvas-menu-toggle">
						<button type="button" class="navbar-toggle"> 
							<span class="icon-bar"></span> 
							<span class="icon-bar"></span> 
							<span class="icon-bar"></span> 
							<span class="menu-text"><?php echo TEXT_DROP_MENU; ?></span> 
						</button>
					</a>
				</div>
			</div>
			<!-- //end Mobile menu Button -->
			<ul class="nav navbar-nav">
				<li class="dl-close"><a href="#"><span class="icon icon-close"></span><?php echo TEXT_DROP_MENU_CLOSE; ?></a></li>										
				<li id="home">
					<a href="<?php echo zen_href_link(FILENAME_DEFAULT, '', 'SSL'); ?>">
						<span class="act-underline"><?php echo HEADER_TITLE_CATALOG; ?></span>
					</a>
				</li>
				<?php if(file_exists($template->get_template_dir('define_drop_menu_static_content.php',DIR_WS_TEMPLATE, $current_page_base,'define_templates'). '/define_drop_menu_static_content.php')){
						require($template->get_template_dir('define_drop_menu_static_content.php',DIR_WS_TEMPLATE, $current_page_base,'define_templates'). '/define_drop_menu_static_content.php');
					} ?>
				<?php
					/**================================================================================================
					**Megamenu Category
					**===============================================================================================*/
					pzen_megamenu();
				?>
				<!--Display the EZ Pages link in Menu. Uncomment if needed. -->
				<?php if (EZPAGES_STATUS_HEADER == '1' or (EZPAGES_STATUS_HEADER == '2' and (strstr(
						EXCLUDE_ADMIN_IP_FOR_MAINTENANCE, $_SERVER['REMOTE_ADDR'])))) { ?>
						 <!-- <li id='ezpages' class="dropdown dropdown-mega-menu dropdown-two-col">
								<span class="dropdown-toggle extra-arrow"></span>
								<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void();">
									<span class="act-underline"><?php echo HEADER_TITLE_EZPAGES; ?></span>
								</a>
								<ul class="dropdown-menu multicolumn two-col" role="menu">
									<li class="dl-back"><a href="#"><span class="icon icon-chevron_left"></span><?php echo TEXT_BACK ?></a></li>	
									<?php require($template->get_template_dir('tpl_ezpages_bar_header.php',DIR_WS_TEMPLATE,$current_page_base,'templates'). '/tpl_ezpages_bar_header.php'); ?>
								</ul>    
							</li>   -->
				<?php } ?>
				<!--EZ Pages Menu Ends Here-->
			</ul>
		</div>
	</nav>
	<?php } ?>
	<!-- end dropMenuWrapper-->
	<div class="clearBoth"></div>