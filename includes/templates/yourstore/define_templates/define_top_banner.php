<?php
switch($top_banners_style){
	case 1:
		$top_ban_item_class='col-sm-4 col-md-4 col-lg-4';
		$top_ban_item_anchor_class='banner zoom-in';
		break;
	case 3:
		$top_ban_item_class='col-md-6 col-sm-6 col-xs-12';
		$top_ban_item_anchor_class='banner zoom-in';
		break;
	case 4:
		$top_ban_item_class='col-sm-4 col-md-4 col-lg-4';
		$top_ban_item_anchor_class='banner-layout-1 zoom-in';
		break;
}		
?>
<?php if($top_banners_style==2){ ?>
	<?php /*========================================= Top Banner Style 2 ==================================================*/ ?>
		<!-- col-left -->
		<div class="col-xs-12 col-sm-12 col-md-6">
			<!-- banner-slider -->
			<div class="banner-slider banner-slider-button">
				<?php
					while(!$banner_slider_query_result->EOF) {
						$banner_slider_image = $banner_slider_query_result->fields['item_image'];
						$banner_slider_caption_un = unserialize(base64_decode($banner_slider_query_result->fields['item_desc']));
						$banner_slider_caption = htmlspecialchars_decode(stripslashes($banner_slider_caption_un[$_SESSION['languages_id']]));
						$banner_slider_link = $banner_slider_query_result->fields['item_link'];
				?>
				<div>
					<a href="<?php echo $banner_slider_link; ?>" class="banner zoom-in font-size-responsive">
						<span class="figure">
							<img src="<?php echo $template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'images').'/banners/'.$banner_slider_image;?>" width="auto" height="auto" alt="<?php echo TEXT_BANNER; ?>" title="" />
							<?php echo $banner_slider_caption; ?>
						</span>
					</a>
				</div>
				<?php
					$banner_slider_query_result->MoveNext(); 
					}
				?>            
			</div>
			<!-- /banner-slider -->
		</div>
		<!-- /col-left -->
		<!-- col-right -->
		<div class="col-xs-12 col-sm-12 col-md-6">
			<div class="row">
				<?php 
					$i=1;
					while(!$top_banner_query_result->EOF) {			
					$top_bannner_image = $top_banner_query_result->fields['item_image'];
					$top_banner_caption_un = unserialize(base64_decode($top_banner_query_result->fields['item_desc']));
					$top_banner_caption = htmlspecialchars_decode(stripslashes($top_banner_caption_un[$_SESSION['languages_id']]));
					$top_banner_link = $top_banner_query_result->fields['item_link'];
				?>
				<?php if($i <= 2) { ?>
				<div class="col-sm-6 col-md-6">
					<a href="<?php echo $top_banner_link; ?>" class="banner zoom-in">
						<span class="figure">
							<img src="<?php echo $template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'images').'/banners/'.$top_bannner_image;?>" width="auto" height="auto" alt="<?php echo TEXT_BANNER; ?>" title="" />
							<?php echo $top_banner_caption; ?>
						</span>
					</a>
				</div>
			<?php } ?>
			<?php if($i==3) { ?>
			</div>
			<div class="row">
				<div class="col-md-12">
					<a href="<?php echo $top_banner_link; ?>" class="banner zoom-in">
						<span class="figure">
							<img src="<?php echo $template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'images').'/banners/'.$top_bannner_image;?>" width="auto" height="auto" alt="<?php echo TEXT_BANNER; ?>" title="" />
							<?php echo $top_banner_caption; ?>
						</span>
					</a>
				</div>
			</div>            
			<?php } ?>
			<?php 
				$i++;
				$top_banner_query_result->MoveNext(); 
				}
			?>
		</div>
	<!-- /col-right -->
	<?php /*========================================= Top Banner Style 2 ==================================================*/ ?>
<?php }else{ ?>
	<?php /*========================================= Top Banner Style 1,3,4 ==================================================*/ ?>
	<?php 
	while(!$top_banner_query_result->EOF) {
		$top_bannner_image = $top_banner_query_result->fields['item_image'];
		$top_banner_caption_un = unserialize(base64_decode($top_banner_query_result->fields['item_desc']));
		$top_banner_caption = htmlspecialchars_decode(stripslashes($top_banner_caption_un[$_SESSION['languages_id']]));
		$top_banner_link = $top_banner_query_result->fields['item_link'];
		?>
		<div class="<?php echo $top_ban_item_class; ?>">
			<a href="<?php echo $top_banner_link ?>" class="<?php echo $top_ban_item_anchor_class; ?>">
				<span class="figure">
					<img src="<?php echo $template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'images').'/banners/'.$top_bannner_image;?>" width="auto" height="auto" alt="<?php echo TEXT_BANNER; ?>" title="" />
					<?php echo $top_banner_caption; ?>
				</span>
			</a>
		</div>
	<?php $top_banner_query_result->MoveNext(); } ?>
	<?php /*========================================= Top Banner Style 1,3,4 ==================================================*/ ?>
<?php } ?>