<footer class="fill-bg layout-1 <?php echo $footer_other_class; ?>">
    <!-- footer-data -->
    <div class="container inset-bottom-60">
        <div class="row" >
        	<!-- <div class="col-xl-3 visible-xl">
                <div class="footer-logo hidden-xs">
                      Logo  
                    <a class="logo" href="<?php echo zen_href_link(FILENAME_DEFAULT, '', SSL); ?>"> <img alt="<?php if($logo_image!=NULL){ echo "logo"; } ?>" src="<?php echo $template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'images').'/uploads/'.$logo_image;?>" /> </a> 
                     /Logo 
                </div>
                <div class="box-about">
                    <div class="mobile-collapse">
                        <h4 class="mobile-collapse__title visible-xs">ABOUT US</h4>
                        <div class="mobile-collapse__content">									
                            address 
                            <address class="box-address">
                                <span class="icon icon-home"></span> <?php echo $store_address; ?> <br>
                                <span class="icon icon-call"></span> <b class="color-dark"><?php echo $store_contact; ?> </b><br>
                                <span class="icon icon-markunread"></span> <a class="color" href="mailto:<?php echo $store_email; ?>"><?php echo $store_email; ?></a>
                            </address>
                             /address 									
                        </div>
                    </div>
                </div>					
            </div> -->
            <div class="col-sm-4 col-md-4 col-lg-3 col-xl-2">
                <div class="mobile-collapse">
                	<!-- Information column -->
					<?php
                    include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_FOOTER_INFORMATION_LINKS, 'false'); ?>
                    <!-- Information column Ends -->
                </div>
            </div>
            <div class="col-sm-4 col-md-4 col-lg-3 col-xl-2">
                <div class="mobile-collapse">
                	<!-- My Account column -->
					<?php
                    include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_FOOTER_ACCOUNT_LINKS, 'false'); ?>
                    <!-- My Account column Ends-->
                </div>
            </div>
            <div class="col-sm-4 col-md-4 col-lg-2  col-xl-2">
                <div class="mobile-collapse">
                	<!-- Customer Care column -->
					<?php
                    include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_FOOTER_CUSTOMER_CARE_LINKS, 'false'); ?>
                    <!-- Customer Care column Ends -->
                </div>
            </div>
            <div class="divider divider--lg visible-md visible-sm"></div>
            <div class="col-sm-9 col-md-7 col-lg-4  col-xl-3">
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
                    

                    

                    <!--About me-->
                    <div class="box-about">
                        <div class="mobile-collapse">
                            <h4 class="mobile-collapse__title visible-xs">ABOUT US</h4>

                            <div class="mobile-collapse__content">                                  
                                <address class="box-address">
                                    <!-- <span class="icon icon-home"></span> <?php echo $store_address; ?> <br> -->
                                    <!-- <span class="icon icon-call"></span> <b class="color-dark"><?php echo $store_contact; ?> </b><br> -->
                                    <span class="icon icon-markunread"></span> <a class="color" href="mailto:<?php echo $store_email; ?>"><?php echo $store_email; ?></a>
                                </address>
                            </div>
                        </div>
                    </div>
                    <!--/About me-->  

                    <!--   Logo   -->
                    <a class="logo" href="<?php echo zen_href_link(FILENAME_DEFAULT, '', SSL); ?>"> <img alt="<?php if($logo_image!=NULL){ echo "logo"; } ?>" src="<?php echo $template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'images').'/uploads/'.$logo_image;?>" /> </a> 
                    <!--  /Logo    -->
                    
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