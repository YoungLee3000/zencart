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


class pzen_categories_ul_generator {
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
    
    function __construct($load_from_database = true)
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
    
    function buildBranch($parent_id, $level = 0, $submenu=true, $parent_link='')
    {
		$level = (int)$level;
        $pzen_mn['simple'] = sprintf($this->parent_group_start_string, ($submenu==true) ? ' role="menu" class="megamenu__submenu image-links-level-'. ($level+1).' level'. ($level+1) . '"' : '' );
		$pzen_mn['css_categories'] = sprintf($this->parent_group_start_string, ($submenu==true) ? ' id="accordion-1" class="expander-list accordion level'. ($level+1) . '"' : '' );
		
		if($level==1){
			$pzen_mn['megamenu'] = sprintf($this->parent_group_start_string, ($submenu==true) ? ' class="dropdown-menu megamenu level'. ($level) . '" role="menu" ' : '' );
		}else if($level!=0){
			$pzen_mn['megamenu'] = sprintf($this->parent_group_start_string, ($submenu==true) ? ' class="megamenu__submenu level'. ($level) . '"' : '' );
        }
        $pzen_mn['megamenu'].='<li class="dl-back"><a href="#"><span class="icon icon-chevron_left"></span>back</a></li>';
        if (($this->data[$parent_id])) {
            foreach($this->data[$parent_id] as $category_id => $category) {
                $category_link = $parent_link . $category_id;
				$cat_lnk = zen_href_link(FILENAME_DEFAULT, 'cPath=' . $category_link, 'SSL');
                if (($this->data[$category_id])) {
					//css Categories
					$pzen_mn['css_categories'] .= sprintf($this->child_start_string, ($submenu==true) ? ' class="submenu"' : '');
					//Megamenu
					if($level==0){
						$pzen_mn['megamenu'] .= sprintf($this->child_start_string, ($submenu==true) ? ' class="submenu dropdown dropdown-mega-menu"' : '');
					}else if($level==1){
						$pzen_mn['megamenu'] .= sprintf($this->child_start_string, ($submenu==true) ? ' class="col-sm-3"' : '');
					}else{
						$pzen_mn['megamenu'] .= sprintf($this->child_start_string, ($submenu==true) ? ' class=" level'. ($level) . '"' : '');
					}
					
					//Simple Menu
                    $pzen_mn['simple'] .= sprintf($this->child_start_string, ($submenu==true) ? ' class="submenu level'. ($level+1).'"' : ' class="level'. ($level+1).'"');
					$pzen_mn['simple'] .= str_repeat($this->spacer_string, $this->spacer_multiplier * 1) . '<a class="wdmn" href="' . $cat_lnk  . '">';
					$pzen_mn['simple'] .= $category['name'];
					$pzen_mn['simple'] .= '</a>';
					$pzen_mn['simple'] .='<span class="name mobmn"><span class="expander">-</span>';				
					$pzen_mn['simple'] .= str_repeat($this->spacer_string, $this->spacer_multiplier * 1) . '<a class="dropdown-toggle1" data-toggle="dropdown1" href="' . $cat_lnk . '">';
					$pzen_mn['simple'] .= $category['name'];
					$pzen_mn['simple'] .= '</a>';
					$pzen_mn['simple'] .= '</span>';
					
										
                } else {
					
					//Css Categories
					if (($this->data[$category_id]) && ($submenu==false)) {
						$pzen_mn['css_categories'] .= sprintf($this->parent_start_string, ($submenu==true) ? ' id="accordion-1" class="accordion level'.($level+1) . '"' : '');
						$pzen_mn['css_categories'] .= sprintf($this->child_start_string, ($submenu==true) ? ' class="submenu"' : '');
					}else{
						$pzen_mn['css_categories'] .= sprintf($this->child_start_string, '');
					}
					
					//Megamenu 
					if($level==0){
						$pzen_mn['megamenu'] .= sprintf($this->child_start_string, ($submenu==true) ? ' class="dropdown dropdown-mega-menu"' : '');
					}else if($level==1){
						$pzen_mn['megamenu'] .= sprintf($this->child_start_string, ($submenu==true) ? ' class="col-sm-3"' : '');
					}else{
						$pzen_mn['megamenu'] .= sprintf($this->child_start_string, ($submenu==true) ? ' class=" level'. ($level) . '"' : '');
					}
					
					//Simple Menu
                    $pzen_mn['simple'] .= sprintf($this->child_start_string, ' class="level'. ($level+1).'"');
					$pzen_mn['simple'] .= str_repeat($this->spacer_string, $this->spacer_multiplier * 1) . '<a href="' . $cat_lnk . '">';
					$pzen_mn['simple'] .= $category['name'];
					$pzen_mn['simple'] .= '</a>';
                }
				
				//Css Categories
				if ($level == 0) {
				   $pzen_mn['css_categories'] .= $this->root_start_string;
				}
				$pzen_mn['css_categories'] .= str_repeat($this->spacer_string, $this->spacer_multiplier * 1) . '<a href="' . $cat_lnk . '">';
				$pzen_mn['css_categories'] .= $category['name'];
				$pzen_mn['css_categories'] .= '</a>';
				if ($level == 0) {
					$pzen_mn['css_categories'] .= $this->root_end_string;
				}
				if (($this->data[$category_id])) {
					$pzen_mn['css_categories'] .= $this->parent_end_string;
				}
				
				//Megamenu
				$pzen_mn['megamenu'] .= str_repeat($this->spacer_string, $this->spacer_multiplier * 1);
				//generate link
				if($level==0){
					$pzen_mn['megamenu'] .='<span class="dropdown-toggle extra-arrow"></span><a class="dropdown-toggle" data-toggle="dropdown" href="' . $cat_lnk . '">';
				}else if($level==1){
					$pzen_mn['megamenu'] .='<a class="megamenu__subtitle" href="' . $cat_lnk . '">';
				}else{
					$pzen_mn['megamenu'] .='<a href="' . $cat_lnk . '">';
				}
				
				//generate title 
				if($level==0){
					global $this_is_home_page;
					$homepage_layout=(get_pzen_options('homepage_layout')) ? get_pzen_options('homepage_layout') : '1' ;
					if($homepage_layout==2){ $pzen_mn['megamenu'] .= '<span class="icon icon-navigate_next pull-right"></span>';}
					$pzen_mn['megamenu'] .= '<span class="act-underline">'.$category['name'].'[BADGE ID="'.$category_id.'"]</span>';
				}else if($level==1){
					$pzen_mn['megamenu'] .= "<span>".$category['name']."</span>";
					 $imgstatus=(get_pzen_options("subcat_imgstatus_".$parent_id)=='' || get_pzen_options("subcat_imgstatus_".$parent_id)==1 ) ? 1 : 0;
					if ($category['categories_image'] && $imgstatus==1){
						$pzen_mn['megamenu'] .= '<span class="megamenu__category-image hidden-xs">'.zen_image(DIR_WS_IMAGES . $category['categories_image'], '', PZEN_MEGAMENU_CATEGORY_IMAGE_WIDTH, PZEN_MEGAMENU_CATEGORY_IMAGE_HEIGHT,'class="img-responsive"').'</span>';
					}
				}else{
					$pzen_mn['megamenu'] .= $category['name'];
				}	
				
                $pzen_mn['megamenu'] .= '</a>';
				
				
				  
                if (($this->data[$category_id]) && (($this->max_level == '0') || ($this->max_level > $level+1))) {
					$rs_sub = $this->buildBranch($category_id, $level+1, $submenu, $category_link . '_');
                    $pzen_mn['simple'] .= $rs_sub['simple'];
					$pzen_mn['megamenu'] .= $rs_sub['megamenu'];
					$pzen_mn['css_categories'] .= $rs_sub['css_categories'];
                }
                $pzen_mn['simple'] .= $this->child_end_string;
				$pzen_mn['megamenu'] .= $this->child_end_string;
            }
        }
		
		//Megamenu
		if($level!=0){
			if($level==1){
					$pzen_mn['megamenu'] .='[MEGAMENU--SIDE-BLOCK ID="'.$parent_id.'"]';
					$pzen_mn['megamenu'] .='[MEGAMENU-BOTTOM-BLOCK ID="'.$parent_id.'"]';
			}
			$pzen_mn['megamenu'] .= $this->parent_group_end_string;
		}
        
        $pzen_mn['simple'] .= $this->parent_group_end_string;
		$pzen_mn['css_categories'] .= $this->parent_group_end_string;
		
        return $pzen_mn;
    }
    
    function buildTree($submenu=false)
    {
        return $this->buildBranch($this->root_category_id, '', $submenu);
    }
}
?>