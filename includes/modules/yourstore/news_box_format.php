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
$max_news_items = (((int)$max_news_items) <= 0) ? 10 : $max_news_items;
$news_box_content_length = (int)$news_box_content_length;

$languages_id = (int)zen_db_prepare_input ($_SESSION['languages_id']);
$news_box_query_raw = "SELECT n.box_news_id, nc.news_title, nc.news_content, n.news_added_date, n.news_modified_date, n.news_start_date, n.news_end_date
                         FROM " . TABLE_BOX_NEWS_CONTENT . " nc, " . TABLE_BOX_NEWS . " n 
                        WHERE n.news_status = 1 
                          AND nc.box_news_id = n.box_news_id
                          AND nc.languages_id = $languages_id 
                          AND now() >= n.news_start_date
                          AND ( n.news_end_date = '0001-01-01 00:00:00' OR  n.news_end_date = '0000-00-00 00:00:00' OR n.news_end_date is null OR now() <= n.news_end_date)
                     ORDER BY n.news_start_date DESC, n.box_news_id DESC";

if ($news_box_use_split) {
  $news_split = new splitPageResults ($news_box_query_raw, $max_news_items);
  $news_info = $db->Execute ($news_split->sql_query);
  
} else {
  $news_info = $db->Execute ($news_box_query_raw . " LIMIT $max_news_items");
  
}

$news = array ();
while (!$news_info->EOF) {
  $news[$news_info->fields['box_news_id']] =
    array (
      'title' => nl2br ($news_info->fields['news_title']),
      'start_date' => (NEWS_BOX_DATE_FORMAT == 'short') ? zen_date_short ($news_info->fields['news_start_date']) : zen_date_long ($news_info->fields['news_start_date']),
	  'news_image' => ($news_info->fields['news_image']),
	  'news_added_date' => ($news_info->fields['news_added_date']),
		'news_modified_date' => ($news_info->fields['news_modified_date']),
      
    );
  if ($news_box_content_length != 0) {
    if ($news_box_content_length == -1) {
      $news[$news_info->fields['box_news_id']]['news_content'] = $news_info->fields['news_content'];
      
    } elseif ($news_box_content_length > 0) {
      $news[$news_info->fields['box_news_id']]['news_content'] = zen_trunc_string(($news_info->fields['news_content']), $news_box_content_length);
      
    }
  }
  if ($news_info->fields['news_end_date'] != '0001-01-01 00:00:00') {
    $news[$news_info->fields['box_news_id']]['end_date'] = (NEWS_BOX_DATE_FORMAT == 'short') ? zen_date_short ($news_info->fields['news_end_date']) : zen_date_long ($news_info->fields['news_end_date']);
    
  }
  $news_info->MoveNext ();
  
}
unset ($news_info);