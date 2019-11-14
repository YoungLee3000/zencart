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
        </div>
    </div>
</div>
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