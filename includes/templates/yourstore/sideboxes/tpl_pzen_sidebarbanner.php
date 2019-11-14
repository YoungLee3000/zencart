<?php
$content = '';
$content.='<div id="' . str_replace('_', '-', $box_id . 'Content') . '" class="bannerAsid nav-dot hidden-sm  hidden-xs">';
	for ($i=1; $i<=sizeof($page_query_list); $i++) {
		if ($page_query_list[$i]['image'] != '') {
			$content.='<div class="text-center">';
			if($page_query_list[$i]['link']){
				$content.='<a href="'.$page_query_list[$i]['link'].'" target="_blank">';
			}
			$content.=zen_image(DIR_WS_TEMPLATE.'images/banners/'.$page_query_list[$i]['image'], $page_query_list[$i]['name'], PZEN_SIDEBAR_BANNER_IMAGE_WIDTH, PZEN_SIDEBAR_BANNER_IMAGE_HEIGHT, 'class="img-responsive-inline"');
			if($page_query_list[$i]['link']){
				$content.='</a>';
			}
			$content.='</div>';
		}
		else {
			$content.='<div class="text-center">';
			$content .= zen_image(DIR_WS_IMAGES . 'no_picture.gif', $page_query_list[$i]['name'], PZEN_SIDEBAR_BANNER_IMAGE_WIDTH, PZEN_SIDEBAR_BANNER_IMAGE_HEIGHT, 'class="img-responsive-inline"');
			$content.='</div>';
		}
	}
$content.='
		</div>
		';
//EOF