<!-- CONTENT section -->
	<div id="pageContent">
		<section class="container-fluid under-construction image-bg" data-image="images/custom/under-construction-img.jpg">
			<div class="text-center color-white">
				<div class="divider divider--xl-1"></div>
				<h1 class="font50 color-white title-bottom-md"><?php echo HEADING_TITLE; ?></h1>

				<p class="font22"><?php echo DOWN_FOR_MAINTENANCE_TEXT_INFORMATION; ?></p>

				<?php if (DISPLAY_MAINTENANCE_TIME == 'true') { ?>
				<p class="font22"><?php echo TEXT_MAINTENANCE_ON_AT_TIME . '<br />' . TEXT_DATE_TIME; ?></p>
				<?php } ?>
				<?php if (DISPLAY_MAINTENANCE_PERIOD == 'true') { ?>
				<p class="font30"><?php echo TEXT_MAINTENANCE_PERIOD . TEXT_MAINTENANCE_PERIOD_TIME; ?></p>
				<?php } ?>
				<br class="clearBoth" />
				<div class="divider divider--lg"></div>
				<h2 class=" color-white">SUBSCRIBE TO OUR NEWSLETTER</h2>
				<p>
					Sign up now to our newsletter and you'll be one of the first to know when the site is ready:
				</p>
				<div class="divider divider--xs"></div>
				<!-- subscribe-box -->
				<div class="subscribe-full-center">
					<!-- Begin MailChimp Signup Form -->
					<?php echo $newsletter_details; ?>
					<!--End mc_embed_signup-->
				</div>
				<!-- /subscribe-box -->
				<div class="divider divider--md"></div>
				<div class="social-links social-links-no-bg  social-links--large text-center">
					<ul>
						<li><a class="icon fa fa-facebook" href="http://www.facebook.com/"></a></li>
						<li><a class="icon fa fa-twitter" href="http://www.twitter.com/"></a></li>
						<li><a class="icon fa fa-google-plus" href="http://www.google.com/"></a></li>
						<li><a class="icon fa fa-instagram" href="https://instagram.com/"></a></li>
						<li><a class="icon fa fa-youtube-square" href="https://www.youtube.com/"></a></li>
					</ul>
				</div>
				<div class="divider divider--xl"></div>
			</div>
		</section>
	</div>
	<!-- End CONTENT section --> 