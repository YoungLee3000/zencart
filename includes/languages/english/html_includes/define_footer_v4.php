<!-- FOOTER section -->
		<footer class="layout-3 <?php echo $footer_other_class; ?>">
			<!-- footer-data -->
			<div class="container inset-bottom-60">
				<div class="row">
					<div class="col-sm-12 text-center">
						<!--  Logo  --> 
						<a class="logo hidden-sm hidden-xs" href="<?php echo zen_href_link(FILENAME_DEFAULT, '', 'SSL'); ?>"><img alt="<?php if($logo_image!=NULL){ echo "logo"; } ?>" src="<?php echo $template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'images').'/uploads/'.$logo_image;?>" /> </a> 
						<!-- /Logo -->
						<div class="divider divider-md hidden-xs hidden-sm"></div>
						<?php if($display_newsletter==1){ ?>
						<!-- subscribe-box -->
						<div class="subscribe-box subscribe-box-row offset-top-20">
							<div class="mobile-collapse">
								<h4 class="mobile-collapse__title text-left">NEWSLETTER SIGNUP<span class="hidden-sm hidden-xs">:</span></h4>
								<div class="mobile-collapse__content">
									<!-- Begin MailChimp Signup Form -->
									<?php echo $newsletter_details; ?>
									<!--End mc_embed_signup-->
								</div>
							</div>
						</div>
						<!-- /subscribe-box -->	
						<?php } ?>
					</div>
				</div>
				<div class="divider divider-md hidden-xs"></div>								
				<div class="row">					
					<div class="col-sm-4 col-md-3">
						<div class="mobile-collapse">
							<!-- Information column -->
							<?php
							include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_FOOTER_INFORMATION_LINKS, 'false'); ?>
							<!-- Information column Ends -->
						</div>
					</div>
					<div class="col-sm-4 col-md-3">
						<div class="mobile-collapse">
							<!-- My Account column -->
							<?php
							include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_FOOTER_ACCOUNT_LINKS, 'false'); ?>
							<!-- My Account column Ends-->
						</div>
					</div>
					<div class="col-sm-4 col-md-3">
						<div class="mobile-collapse">
							<!-- Customer Care column -->
							<?php
							include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_FOOTER_CUSTOMER_CARE_LINKS, 'false'); ?>
							<!-- Customer Care column Ends -->
						</div>
					</div>
					<div class="clearfix visible-sm divider divider-lg "></div>
					<div class="col-sm-9 col-md-3">
						<div class="mobile-collapse">
							<h4 class="text-left  title-under  mobile-collapse__title text-uppercase visible-xs visible-sm">Contact</h4>
							<div class=" mobile-collapse__content">							
								<!-- address -->
								<address class="box-address">
									<span class="icon icon-home"></span> <?php echo $store_address; ?> <br>
									<span class="icon icon-call"></span> <b class="color-dark"><?php echo $store_contact; ?></b><br>
									<span class="icon icon-access_time"></span> <?php echo $store_timings; ?><br>
									<span class="icon icon-markunread"></span> <a class="color link-underline" href="mailto:<?php echo $store_email; ?>"><?php echo $store_email; ?></a>
								</address>
								<!-- /address -->
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
				</div>
			</div>
			<!-- /footer-data --> 
			<div class="divider divider-md visible-sm"></div>
			
			<!-- footer-copyright -->
			<div class="container footer-copyright">
				<div class="row">
					<div class="col-lg-12 text-center"> <?php echo $store_copyright; ?> </div>
				</div>
			</div>
			<!-- /footer-copyright --> 
			<a href="#" class="btn btn--ys btn--full visible-xs" id="w2b-StoTop">Back to top <span class="icon icon-expand_less"></span></a> 
		</footer>

<!-- END FOOTER section -->