<!-- FOOTER section -->
<footer  class="layout-2 <?php echo $footer_other_class; ?>">			
	<!-- social-icon -->
	<div class="container">
		
		<div class=" text-center">
			<div class="social-links social-links-border social-links--large ">
				<?php
				include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_FOOTER_SOCIAL_LINKS, 'false'); 
				?>
			</div>
		</div>
		
	</div>
	<!-- /social-icon --> 
	<!-- footer-copyright -->
	<div class="container footer-copyright">
		<div class="row">
			<div class="col-lg-12  text-center"> 
				<?php echo $store_copyright; ?>
			</div>
		</div>
	</div>
	<!-- /footer-copyright -->			
</footer>
<!-- END FOOTER section -->