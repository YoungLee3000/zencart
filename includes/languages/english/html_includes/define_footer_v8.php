<footer class="layout-5 footer-layout-08 <?php echo $footer_other_class; ?>">
	<!-- footer-data -->
	<div class="container">									
		<div class="row">
			<div class="col-sm-12 text-center">
				<!-- telephone -->
				<div class="telephone-box offset-top-20">
					<div class="mobile-collapse">
						<h4 class="mobile-collapse__title text-left text-uppercase visible-xs">telephone</h4>
						<div class="mobile-collapse__content">
							<address class="font-medium">
								<span class="icon icon-call"></span><?php echo $store_contact; ?>							
							</address>
							<time class="color-gray"><?php echo $store_timings; ?></time>
						</div>
					</div>
				</div>						
				<!-- /telephone -->
				<?php if($display_newsletter==1){ ?>
				<!-- subscribe-box -->
				<div class="subscribe-box subscribe-box-row offset-top-20">
					<div class="mobile-collapse">
						<h4 class="mobile-collapse__title text-left">NEWSLETTER SIGNUP<span class="hidden-xs">:</span></h4>
						<div class="mobile-collapse__content">
							<!-- Begin MailChimp Signup Form -->
							<?php echo $newsletter_details; ?>
							<!--End mc_embed_signup-->
						</div>
					</div>
				</div>
				<!-- /subscribe-box -->
				<?php } ?>
				<div class="divider divider--md"></div>
				<!-- social-icon -->
				<div class="social-links social-links--large social-links-layout-02">
					<?php
						include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_FOOTER_SOCIAL_LINKS, 'false'); 
					?>
				</div>
				<!-- /social-icon -->			
			</div>				
		</div>
	</div>
	<!-- /footer-data --> 
	
	<!-- footer-copyright -->
	<div class="container footer-copyright">
		<div class="row">
			<div class="col-sm-12 text-center">
				<?php echo $store_copyright; ?>
			</div>					
		</div>
	</div>
	<!-- /footer-copyright --> 
	<a id="backToTop" class="btn btn--ys btn--full visible-xs" href="#">Back to top <span class="icon icon-expand_less"></span></a> 
</footer>