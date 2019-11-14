<?php
//placeholder21// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright(c) 2003 The zen-cart developers                           |
// |                                                                      |
// | http://www.zen-cart.com/index.php                                    |
// |                                                                      |
// | Portions Copyright(c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
// $Id: categories_ul_generator.php 2004-07-11  DrByteZen $
//      based on site_map.php v1.0.1 by networkdad 2004-06-04
//


class zen_categories_ul_generator_megamenu {
    var $root_category_id = 0,
    $max_level = 0,
    $data = array(),
    $parent_group_start_string = '<ul%s>',
    $parent_group_end_string = '</ul>',
    $child_start_string = '<li%s>',
    $child_end_string = '</li>',
    $spacer_string = '
',
    $spacer_multiplier = 1;
    
    var $document_types_list = ' (3) ';
    // acceptable format example: ' (3, 4, 9, 22, 18) '
    
    function zen_categories_ul_generator_megamenu($load_from_database = true)
    {
        global $languages_id, $db;
        $this->data = array();
        $categories_query = "select c.categories_id, c.categories_image, cd.categories_name, c.parent_id
										from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
										where c.categories_id = cd.categories_id
										and c.categories_status=1 " .
        								" and cd.language_id = '" . (int)$_SESSION['languages_id'] . "' " .
        								" order by c.parent_id, c.sort_order, cd.categories_name";
        $categories = $db->Execute($categories_query);
        while (!$categories->EOF) {
            $this->data[$categories->fields['parent_id']][$categories->fields['categories_id']] = array('name' => $categories->fields['categories_name'], 'categories_image' => $categories->fields['categories_image'], 'count' => 0);
            $categories->MoveNext();
        }
    }
    
    function buildBranch($parent_id, $level, $submenu=true, $parent_link='')
    {

		if($level==1){
			$result = sprintf($this->parent_group_start_string, ($submenu==true) ? ' class="dropdown-menu megamenu level'. ($level) . '" role="menu" ' : '' );
		}else if($level!=0){
			$result = sprintf($this->parent_group_start_string, ($submenu==true) ? ' class="megamenu__submenu level'. ($level) . '"' : '' );
        }
		$result.='<li class="dl-back"><a href="#"><span class="icon icon-chevron_left"></span>back</a></li>';
        if (($this->data[$parent_id])) {
            foreach($this->data[$parent_id] as $category_id => $category) {
                $category_link = $parent_link . $category_id;
                if (($this->data[$category_id])) {
					if($level==0){
						$result .= sprintf($this->child_start_string, ($submenu==true) ? ' class="submenu dropdown dropdown-mega-menu"' : '');
					}else if($level==1){
						$result .= sprintf($this->child_start_string, ($submenu==true) ? ' class="col-sm-3"' : '');
					}else{
						$result .= sprintf($this->child_start_string, ($submenu==true) ? ' class=" level'. ($level) . '"' : '');
					}
                } else {
					if($level==0){
						$result .= sprintf($this->child_start_string, ($submenu==true) ? ' class="dropdown dropdown-mega-menu"' : '');
					}else if($level==1){
						$result .= sprintf($this->child_start_string, ($submenu==true) ? ' class="col-sm-3"' : '');
					}else{
						$result .= sprintf($this->child_start_string, ($submenu==true) ? ' class=" level'. ($level) . '"' : '');
					}
                }
                $result .= str_repeat($this->spacer_string, $this->spacer_multiplier * 1);
				
				//generate link
				if($level==0){
					$result .='<span class="dropdown-toggle extra-arrow"></span><a class="dropdown-toggle" data-toggle="dropdown" href="' . zen_href_link(FILENAME_DEFAULT, 'cPath=' . $category_link, 'SSL') . '">';
				}else if($level==1){
					$result .='<a class="megamenu__subtitle" href="' . zen_href_link(FILENAME_DEFAULT, 'cPath=' . $category_link, 'SSL') . '">';
				}else{
					$result .='<a href="' . zen_href_link(FILENAME_DEFAULT, 'cPath=' . $category_link, 'SSL') . '">';
				}
				
				//generate title 
				if($level==0){
					global $this_is_home_page;
					$homepage_layout=(get_pzen_options('homepage_layout')) ? get_pzen_options('homepage_layout') : '1' ;
					if($homepage_layout==2){ $result .= '<span class="icon icon-navigate_next pull-right"></span>';}
					$result .= '<span class="act-underline">'.$category['name'].'[BADGE ID="'.$category_id.'"]</span>';
				}else if($level==1){
					$result .= "<span>".$category['name']."</span>";
					 $imgstatus=(get_pzen_options("subcat_imgstatus_".$parent_id)=='' || get_pzen_options("subcat_imgstatus_".$parent_id)==1 ) ? 1 : 0;
					if ($category['categories_image'] && $imgstatus==1){
						$result .= '<span class="megamenu__category-image hidden-xs">'.zen_image(DIR_WS_IMAGES . $category['categories_image'], '', PZEN_MEGAMENU_CATEGORY_IMAGE_WIDTH, PZEN_MEGAMENU_CATEGORY_IMAGE_HEIGHT,'class="img-responsive"').'</span>';
					}
				}else{
					$result .= $category['name'];
				}	
				
                $result .= '</a>';
				  
                if (($this->data[$category_id]) && (($this->max_level == '0') || ($this->max_level > $level))) {
                    $result .= $this->buildBranch($category_id, $level+1, $submenu, $category_link . '_');
                }
                $result .= $this->child_end_string;
            }
        }
        if($level!=0){
			if($level==1){
					$result .='[MEGAMENU--SIDE-BLOCK ID="'.$parent_id.'"]';
					$result .='[MEGAMENU-BOTTOM-BLOCK ID="'.$parent_id.'"]';
			}
			$result .= $this->parent_group_end_string;
		}
        return $result;
    }
    
    function buildTree($submenu=false)
    {
        return $this->buildBranch($this->root_category_id, '', $submenu);
    }
}
?>