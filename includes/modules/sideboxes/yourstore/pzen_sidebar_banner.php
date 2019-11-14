<?php
$show_pzen_sidebar_banner = true;

if ($show_pzen_sidebar_banner == true) {
	$page_query = "SELECT * FROM ".TABLE_PZEN_SIDEBARBANNER." where item_status='1' group by `sort_order` order by `sort_order`";
	$page_query = $db->Execute($page_query);
	if ($page_query->RecordCount()>0) {
      $title =  '';
      $box_id =  'sidebar_banner';
      $rows = 0;
      while (!$page_query->EOF) {
        $rows++;
        $page_query_list[$rows]['id'] = $page_query->fields['id'];
		$page_query_list[$rows]['image'] = $page_query->fields['item_image'];
		$page_query_list[$rows]['link'] = $page_query->fields['item_link'];

        $page_query->MoveNext();
      }
      $left_corner = false;
      $right_corner = false;
      $right_arrow = false;
      $title_link = false;
      require($template->get_template_dir('tpl_pzen_sidebarbanner.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_pzen_sidebarbanner.php');
      require($template->get_template_dir($column_box_default, DIR_WS_TEMPLATE, $current_page_base,'common') . '/' . $column_box_default);
    }
}	
//EOF	