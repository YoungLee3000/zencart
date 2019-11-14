<?php
// -----
// Part of the News Box Manager plugin, re-structured for Zen Cart v1.5.1 and later by lat9.
// Copyright (C) 2015, Vinos de Frutas Tropicales
//
// +----------------------------------------------------------------------+
// | Do Not Remove: Coded for Zen-Cart by geeks4u.com                     |
// | Dedicated to Memory of Amelita "Emmy" Abordo Gelarderes              |
// +----------------------------------------------------------------------+
//
$max_news_items = (int)NEWS_BOX_SHOW_CENTERBOX;
$news_box_content_length = NEWS_BOX_CONTENT_LENGTH_CENTERBOX;
if ($max_news_items > 0) {
  $news_box_use_split = false;
  include (DIR_WS_MODULES . zen_get_module_directory (FILENAME_NEWS_BOX_FORMAT));
  
if (count ($news) > 0) {
	if($latest_newsbox_style==1){
?>
<section class="<?php echo ($homepage_layout==1)? "content" : "content-sm"; ?> <?php echo ($test_background_image!='' && $newscont_perallax_image_status==1 ) ? 'fixed-bg news-parallax-bg' : '' ; ?>">
	<?php echo ($homepage_layout==1)? '<div class="container">' : ''; ?>
        <div class="row">
            <div class="col-lg-12">
                <!-- title -->
                <div class="title-with-button">
                    <div class="carousel-products__button pull-right">
                        <span class="btn-prev"></span>
                        <span class="btn-next"></span>        
                    </div>
                    <h2 class="<?php echo $news_title_class; ?>"><?php echo BOX_HEADING_NEWS_BOX; ?></h2>
                </div>
                <!-- /title -->
                <!-- carousel-new -->
                <div class="carousel-products row" id="postsCarousel">
                	<?php
					foreach ($news as $news_id => $news_item) {
						$news_content = '';
						if (isset ($news_item['news_content'])) {
							$news_content = $news_item['news_content'] ;
						}
					?>
                    <!-- slide-->
                    <div class="col-sm-3 col-xl-6">
                        <!--  -->
                        <div class="recent-post-box">
                            <div class="col-lg-12 col-xl-6">
                                <a href="<?php echo zen_href_link (FILENAME_MORE_NEWS, 'news_id=' . $news_id, 'SSL'); ?>">
                                    <span class="figure">
                                        <img src="<?php echo $template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'images').'/news/'.$news_item['news_image'];?>" alt="">
                                        <span class="figcaption label-top-left">
                                            <span>
												<?php 
													$dateAdded = date("j", strtotime($news_item['news_added_date']));
													$monthAdded = date("M", strtotime($news_item['news_added_date']));
												?> 
                                                <b><?php echo $dateAdded;?></b>
                                                <em><?php echo $monthAdded;?></em>
                                            </span>
                                        </span>
                                    </span>
                                </a>
                            </div>
                            <div class="col-lg-12 col-xl-6">
                                <div class="recent-post-box__text">
                                    <h4>
                                    	<a href="<?php echo zen_href_link (FILENAME_MORE_NEWS, 'news_id=' . $news_id, 'SSL'); ?>">
                                        	<?php echo $news_item['title']; ?>
                                        </a>
                                   	</h4>
                                    <p>
										<?php echo htmlspecialchars_decode(stripslashes($news_content)); ?>
                                    </p>
                                    <a class="link-commet" href="<?php echo zen_href_link (FILENAME_MORE_NEWS, 'news_id=' . $news_id, 'SSL'); ?>"><?php echo TEXT_READ_MORE; ?></a>
                                </div>
                            </div>
                        </div>
                        <!-- / -->
                    </div>
                    <!-- /slide -->
                    <?php
						}
  					?>
				</div>
         	</div>
       	</div>
   	<?php echo ($homepage_layout==1)? '</div>' : ''; ?>
</section>
<?php }else{ ?>
	<h2 class="text-left text-uppercase title-under"><?php echo BOX_HEADING_NEWS_BOX; ?></h2>
	<?php
	$i=0;
	foreach($news as $news_id => $news_item) {
		$news_content = '';
		if (isset ($news_item['news_content'])) { $news_content = $news_item['news_content'] ; }
	?>
	<div class="recent-post-box recent-post-col row">
		<div class="col-xs-6 col-sm-12 col-md-6">
			 <a href="<?php echo zen_href_link (FILENAME_MORE_NEWS, 'news_id=' . $news_id, 'SSL'); ?>">
				<span class="figure">
					<img src="<?php echo $template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'images').'/news/'.$news_item['news_image'];?>" alt="<?php echo $news_item['title']; ?>" title="<?php echo $news_item['title']; ?>">
					<span class="figcaption label-top-left">
						<span>
							<?php 
								$dateAdded = date("j", strtotime($news_item['news_added_date']));
								$monthAdded = date("M", strtotime($news_item['news_added_date']));
							?> 
							<b><?php echo $dateAdded;?></b>
							<em><?php echo $monthAdded;?></em>
						</span>
					</span>
				</span>									
			</a>
		</div>
		<div class="col-xs-6 col-sm-12 col-md-6">
			<div class="recent-post-box__text">
				<h4><a href="<?php echo zen_href_link (FILENAME_MORE_NEWS, 'news_id=' . $news_id, 'SSL'); ?>"><?php echo $news_item['title']; ?></a></h4>
				<p><?php echo $news_content; ?></p>
				 <a class="link-commet" href="<?php echo zen_href_link (FILENAME_MORE_NEWS, 'news_id=' . $news_id); ?>"><?php echo TEXT_READ_MORE; ?></a>
			</div>
		</div>
	</div>
	<!-- / -->
	<div class="divider divider--sm"></div>
	<?php 
	if($i==1) break;
	$i++;
	} 
	?>
	<a class="btn btn-top btn--ys btn--xl" href="<?php echo zen_href_link (FILENAME_NEWS_ARCHIVE, '', 'SSL'); ?>"><?php echo TEXT_SEE_ALL; ?> </a>	
	<?php 
	}
  }
} 