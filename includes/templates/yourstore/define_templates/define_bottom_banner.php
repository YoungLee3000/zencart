<section class="<?php echo $bt_banner_mn_class; ?>">
	<?php echo ($bottom_banners_style=="1" && $homepage_layout==1) ? '<div class="container">' : ''; ?>
		<div class="row">
			<div class="<?php echo ($bottom_banners_style=="1")? "banner-carousel box-baners" : "banner-carousel-bottom box-baners"; ?> ">
			<?php
			while(!$bottom_banner_query_result->EOF) {
				$bottom_bannner_image = $bottom_banner_query_result->fields['item_image'];
				$bottom_banner_caption_un = unserialize(base64_decode($bottom_banner_query_result->fields['item_desc']));
				$bottom_banner_caption = htmlspecialchars_decode(stripslashes($bottom_banner_caption_un[$_SESSION['languages_id']]));
				$bottom_banner_link = $bottom_banner_query_result->fields['item_link'];
				?>
				<div class="<?php echo $bottom_banner_class; ?>">
					<a href="<?php echo $bottom_banner_link; ?>" class="banner zoom-in">
						<span class="figure">
							<img src="<?php echo $template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'images').'/banners/'.$bottom_bannner_image;?>" width="auto" height="auto" alt="<?php echo TEXT_BANNER; ?>" title="" />
							<?php echo $bottom_banner_caption; ?>
						</span>
					</a>
				</div>
				<?php
				$bottom_banner_query_result->MoveNext();
			} ?>
			</div>
		</div>
	<?php echo ($bottom_banners_style=="1" && $homepage_layout==1) ? '</div>' : ''; ?>
</section>
<?php  echo ($homepage_layout==2) ? '<div class="offset-top-10">&nbsp;</div>' : ''; ?>