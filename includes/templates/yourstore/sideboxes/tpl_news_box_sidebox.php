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
$layout = 1;  // 0 = Java Script Fader | 1 = Static 10 last news

$content = '<div class="sideBoxInnerContent">
				<div class="carousel-products row layout-none-xl offset-top-10" id="postsCarouselSidebox">';  
while (!$news_box_query->EOF) {
			$dateAdded = date("j", strtotime($news_box_query->fields['news_added_date']));
			$monthAdded = date("M", strtotime($news_box_query->fields['news_added_date']));
  $content .= '<div class="col-sm-3 col-xl-6">
  					<div class="recent-post-box">
  						<div class="col-lg-12 col-xl-12">
  							<a href="' . zen_href_link (FILENAME_MORE_NEWS, 'news_id=' . $news_box_query->fields['box_news_id'], 'SSL') . '">
								<span class="figure">
									<img src="'.$template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'images/news/').$news_box_query->fields['news_image'].'" alt="">
                                    <span class="figcaption label-top-left">
                                        <span>
                                            <b>'. $dateAdded.'</b>
                                        	<em>'.$monthAdded.'</em>
                                        </span>
                                    </span>
								</span>
							</a>
  						</div>
  						<div class="col-lg-12 col-xl-12">
  							<div class="recent-post-box__text">
  								<h4>
  									<a href="' . zen_href_link (FILENAME_MORE_NEWS, 'news_id=' . $news_box_query->fields['box_news_id'], 'SSL') . '">' 
  										. $news_box_query->fields['news_title']. '
  									</a>
  								</h4>
  								<p>
  									'. zen_trunc_string($news_box_query->fields['news_content'],NEWS_BOX_CONTENT_LENGTH_CENTERBOX).'
								</p>
								<a class="link-commet" href="'. zen_href_link (FILENAME_MORE_NEWS, 'news_id=' . $news_box_query->fields['box_news_id'], 'SSL').'">'.TEXT_READ_MORE.'</a>
  							</div>
  						</div>
  					</div>
  				</div>'; 
  $news_box_query->MoveNext();
  
}

$content .= '</div><div class="carousel-products__button button-bottom carousel-products__button_aside">
							<span class="btn-prev"></span>
							<span class="btn-next"></span>        
						</div>';
$content .= '</div>';