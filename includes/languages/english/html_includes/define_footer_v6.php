<footer class="layout-0 <?php echo $footer_class; ?>">
    <!-- footer-data -->
    <div class="container inset-bottom-60">
        <div class="row" >
            <div class="col-sm-12 col-md-5 col-lg-6 border-sep-right">
				<div class="footer-logo hidden-xs">
					<!--  Logo  --> 
					<a class="logo" href="<?php echo zen_href_link(FILENAME_DEFAULT, '', 'SSL'); ?>">
						<img alt="<?php if($logo_image!=NULL){ echo "logo"; } ?>" src="<?php echo $template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'images').'/uploads/'.$logo_image;?>" />
					</a> 
					<!-- /Logo --> 
				</div>
				<div class="box-about">
					<div class="mobile-collapse">
						<h4 class="mobile-collapse__title visible-xs">ABOUT US</h4>
						<div class="mobile-collapse__content">
							<p> No more need to look for other ecommerce themes. We provide huge number of different layouts. Yourstore comes packed with free and useful features developed to make your website creation easier... </p>
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
									include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_FOOTER_SOCIAL_LINKS, 'false'); ?>
							</div>
							<!-- /social-icon -->
						</div>
					</div>
				</div> 
            </div>
            <div class="col-sm-12 col-md-7 col-lg-6 border-sep-left">
				<?php if($display_newsletter==1){ ?>
				<!-- subscribe-box -->
				<div class="subscribe-box offset-top-20">
					<div class="mobile-collapse">
						<h4 class="mobile-collapse__title">NEWSLETTER SIGNUP</h4>
						<div class="mobile-collapse__content">
							<!-- Begin MailChimp Signup Form -->
							<?php echo $newsletter_details; ?>
							<!--End mc_embed_signup-->
						</div>
					</div>
				</div>
				<!-- /subscribe-box -->
				<?php } ?>
				<div class="row">
                    <div class="col-sm-4">
                        <div class="mobile-collapse">
                        	<!-- Information column -->
							<?php
                            include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_FOOTER_INFORMATION_LINKS, 'false'); ?>
                            <!-- Information column Ends -->
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="mobile-collapse">
                        	<!-- My Account column -->
							<?php
                            include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_FOOTER_ACCOUNT_LINKS, 'false'); ?>
                            <!-- My Account column Ends-->
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="mobile-collapse">
                        	 <!-- Customer Care column -->
							<?php
                            include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_FOOTER_CUSTOMER_CARE_LINKS, 'false'); ?>
                            <!-- Customer Care column Ends -->
                        </div>
                    </div>
                    
               	</div>
        	</div>
        </div>
    </div>
    <!-- /footer-data --> 
    <div class="divider divider-md visible-xs visible-sm visible-md"></div>
    <!-- footer-copyright -->
    <div class="container footer-copyright">
        <div class="row">
            <div class="col-xs-12 col-sm-5"><?php echo $store_copyright; ?></div>
            <div class="payment-image col-xs-12 col-sm-7">
                <img alt="<?php if($payment_image!=NULL){ echo "payment-image"; } ?>" src="<?php echo $template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'images').'/uploads/'.$payment_image;?>" />
            </div>
        </div>
    </div>
    <!-- /footer-copyright -->
    <a href="#" class="btn btn--ys btn--full visible-xs" id="w2b-StoTop">Back to top <span class="icon icon-expand_less"></span></a>
</footer>