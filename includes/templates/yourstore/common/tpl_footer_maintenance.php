<?php
/**
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_footer.php 3183 2006-03-14 07:58:59Z birdbrain $
 */
require(DIR_WS_MODULES . zen_get_module_directory('footer.php'));
?>
<footer class="layout-7">			
	<!-- footer-copyright -->
	<div class="container footer-copyright text-center">
		<div class="row">
			<div class="col-lg-12"><?php echo $store_copyright; ?></div>
		</div>
	</div>
	<!-- /footer-copyright --> 
	<a href="#" class="btn btn--ys btn--full visible-xs" id="backToTop"><?php echo TEXT_BACK_TO_TOP ?><span class="icon icon-expand_less"></span></a> 
</footer>
<!-- JS Files -->

<!-- Google Jquery -->
<script src="<?php  echo $template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'external/jquery').'/jquery-2.1.4.min.js'?>" type="text/javascript"></script>
<!-- Google Jquery Ends -->
<?php if ($this_is_home_page) { ?>
<script src="<?php  echo $template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'jscript').'/jquery.easing.1.3.js'?>" type="text/javascript"></script>
<?php }	?> 
<script src="<?php  echo $template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'external/slick').'/slick.min.js'?>" type="text/javascript"></script>
<!--Magnific Popup-->
<script src="<?php echo $template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'external/magnific-popup').'/jquery.magnific-popup.min.js'?>"></script>
<script src="<?php echo $template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'external/colorbox').'/jquery.colorbox-min.js'?>"></script>
<!-- SLIDER REVOLUTION 4.x SCRIPTS  -->

<!-- Masonary JS -->
<script src="<?php  echo $template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'jscript').'/masonry.pkgd.min.js'?>" type="text/javascript"></script>
<!-- Masonary JS Ends -->
<script src="<?php echo $template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'external/imagesloaded').'/imagesloaded.pkgd.min.js'?>"></script>
<!-- Accordian for Categories Sidebox JS -->
<script src="<?php echo $template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'jscript').'/jquery.dcjqaccordion.2.7.js'?>" type="text/javascript"></script>
<!-- Accordian for Categories Sidebox JS Ends -->
<!-- Bootstrap JS -->
<script src="<?php  echo $template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'external/bootstrap').'/bootstrap.min.js'?>" type="text/javascript"></script>
<!-- Bootstrap JS Ends -->
<!-- Template Custom JS -->
<script src="<?php  echo $template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'jscript').'/template_custom.js'?>" type="text/javascript"></script>
<!-- Template Custom JS Ends -->
<script src="<?php  echo $template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'jscript').'/modernizr.js'?>" type="text/javascript"></script>
<!-- JQuery Lightbox JS and Cloud Zoom JS-->  