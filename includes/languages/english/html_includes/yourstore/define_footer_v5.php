<footer class="layout-4 <?php echo $footer_other_class; ?>">
    <!-- footer-data -->
    <div class="container inset-bottom-60">
		<div class="row">
			<div class="col-sm-6 col-md-3">
				<!--  -->
				<div class="mobile-collapse">
					<h4 class="text-left text-uppercase  title-under  mobile-collapse__title">Shipping AND Delivery</h4>
					<div class="v-links-list mobile-collapse__content">
						<p>
							We're dedicated to delivering your purchase as quickly and affordably as possible. We offer a range of delivery and pickup options, so you can choose the shipping method that best meets your needs.
						</p>
					</div>
				</div>
				<!-- / -->
			</div>
			<div class="col-sm-6 col-md-3">
				<!--  -->
				<div class="mobile-collapse">
					<h4 class="text-left text-uppercase  title-under  mobile-collapse__title">Payment Methods</h4>
					<div class="v-links-list mobile-collapse__content">
						<p>
							Every country and shopper has their prefered method to pay online. Offering your buyers safe and convenient payment choices can help your sale go smoothly, earn you positive Feedback, and bring them back for more.
						</p>
					</div>
				</div>
			<!-- / -->
			</div>
			<div class="divider divider--lg visible-sm"></div>
				<div class="col-sm-6 col-md-3">
					<!-- -->
					<div class="mobile-collapse">
						<h4 class="text-left text-uppercase  title-under  mobile-collapse__title text-uppercase">Contact</h4>
						<div class=" mobile-collapse__content">							
							<!-- address -->
							<address class="box-address">
								<span class="icon icon-home"></span> <?php echo $store_address; ?> <br>
								<span class="icon icon-call"></span> <b class="color-dark"><?php echo $store_contact; ?> </b><br>
								<span class="icon icon-access_time"></span> <?php echo $store_timings; ?><br>
								<span class="icon icon-markunread"></span> <a class="color link-underline" href="mailto:<?php echo $store_email; ?>"><?php echo $store_email; ?></a>
							</address>
							<!-- /address -->														
						</div>
					</div>
					<!-- / -->
			</div>
			<div class="col-sm-6 col-md-3">
				<!--  -->
				<div class="mobile-collapse">
					<h4 class="text-left text-uppercase  title-under  mobile-collapse__title">Facebook like box</h4>
					<div class="v-links-list mobile-collapse__content">
						<!--======= facebook =======-->
						<div class="fb-page" data-href="https://www.facebook.com/envato/" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/envato/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/envato/">Envato</a></blockquote></div>
						<!--======= /facebook =======-->
					</div>
				</div>
				<!-- / -->
			</div>
		</div>
		<hr class="hidden-xs">
        <div class="row" >
            <div class="col-sm-4 col-md-4  col-lg-3">
                <div class="mobile-collapse">
                	<!-- Information column -->
					<?php
                    include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_FOOTER_INFORMATION_LINKS, 'false'); ?>
                    <!-- Information column Ends -->
                </div>
            </div>
            <div class="col-sm-4 col-md-4  col-lg-3">
                <div class="mobile-collapse">
                	<!-- My Account column -->
					<?php
                    include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_FOOTER_ACCOUNT_LINKS, 'false'); ?>
                    <!-- My Account column Ends-->
                </div>
            </div>
            <div class="col-sm-4 col-md-4  col-lg-3">
                <div class="mobile-collapse">
                	<!-- Customer Care column -->
					<?php
                    include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_FOOTER_CUSTOMER_CARE_LINKS, 'false'); ?>
                    <!-- Customer Care column Ends -->
                </div>
            </div>
            <div class="divider divider--lg visible-sm visible-md"></div>
            <div class="col-sm-12 col-md-12  col-lg-3">
                <!-- subscribe-box -->
                <div class="subscribe-box">
				<?php if($display_newsletter==1){ ?>
            	<!-- Social/Newletter column -->
                    <div class="subscribe-box">
                        <div class="mobile-collapse">
                            <h4 class="text-left  title-under  mobile-collapse__title">NEWSLETTER SIGNUP</h4>
                            <div class="mobile-collapse__content">
                                <!-- Begin MailChimp Signup Form -->
                                <?php echo $newsletter_details; ?>
                                <!--End mc_embed_signup-->
                            </div>
                        </div>
                    </div>
                    <!-- /subscribe-box -->
				<?php } ?>
                    <!-- social-icon -->
                    <div class="divider divider--md"></div>
                    <div class="social-links social-links--large social-links-layout-02">
                        <?php
                            include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_FOOTER_SOCIAL_LINKS, 'false'); 
                        ?>
                    </div>
                    <!-- /social-icon -->  
                <!-- Social/Newletter column Ends -->    
            	</div>
            </div>
        </div>
	</div>
    <!-- /footer-data --> 
	<div class="divider divider-md visible-sm"></div>

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