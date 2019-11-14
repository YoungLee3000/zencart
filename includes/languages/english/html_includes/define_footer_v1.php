<footer class="<?php echo $footer_other_class; ?>">
    <!-- footer-data -->
    <div class="container inset-bottom-60">
        <div class="row" >
			<?php if($display_newsletter==1){ ?>
            <div class="col-sm-12 col-md-5 col-lg-6 border-sep-right">
            	<!-- Social/Newletter column -->
				<?php
                include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_FOOTER_NEWSLETTER_COLUMN, 'false'); ?>
                <!-- Social/Newletter column Ends -->    
            </div>
			<?php } ?>
            <div class="col-sm-12 col-md-7 col-lg-6 border-sep-left">
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
    <!-- social-icon -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="social-links social-links--large">
                	<?php
                    	include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_FOOTER_SOCIAL_LINKS, 'false'); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- /social-icon -->
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
    <a href="#" class="btn btn--ys btn--full visible-xs" id="backToTop">Back to top <span class="icon icon-expand_less"></span></a>
</footer>