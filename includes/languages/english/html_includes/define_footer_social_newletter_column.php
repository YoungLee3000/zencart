<div class="social-newsletter">
	<div class="social-links">
		<h3 class="title">CONNECT WITH US</h3>
		<ul class="social list-inline list-unstyled">
			<?php if($facebook_link != NULL) {?>
			<li>
				<a class="fa fa-facebook" href="https://www.facebook.com/<?php echo $facebook_link;?>" target="_blank">
				</a>
			</li>
			<?php } ?>
			<?php if($twitter_link != NULL) {?>
			<li>
				<a class="fa fa-twitter" href="https://www.twitter.com/<?php echo $twitter_link;?>" target="_blank"></a>
			</li>
			<?php } ?>
			<?php if($pinterest_link != NULL) {?>
			<li>
				<a class="fa fa-pinterest" href="https://pinterest.com/<?php echo $pinterest_link;?>" target="_blank">
				</a>
			</li>
			<?php } ?>
			<?php if($google_link != NULL) {?>
			<li>
				<a class="fa fa-google-plus" href="<?php echo $google_link; ?>" target="_blank"></a>
			</li>
			<?php } ?>
			<?php if($youtube_link != NULL) {?>
			<li>
				<a class="fa fa-youtube" href="<?php echo $youtube_link; ?>" target="_blank"></a>
			</li>
			<?php } ?>
		</ul>
	</div>
	
	<div class="newsletter">
		<div class="input-group">
			<!-- Begin MailChimp Signup Form -->
			<?php echo $newsletter_details; ?>
			<!--End mc_embed_signup-->
		</div>
	</div>
	
</div>