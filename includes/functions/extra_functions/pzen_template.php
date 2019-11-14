<?php
/**
 * Youreshop - Responsive Zencart Template
 *
 * @package theme-admin
 * @license http://www.gnu.org/copyleft/gpl.html   GNU Public License V2.0
 * @version $Id: theme.php 1.0 2012-10-10 11:50:04Z $ 
 */

if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}
	
	global $pzen_temp_data;
	global $pzen_menu;
	
	if (function_exists('zen_register_admin_page')) {
		if (!zen_page_key_exists('FILENAME_PZENTEMPLATE')) {
			// Add Color menu to Tools menu
			zen_register_admin_page('FILENAME_PZENTEMPLATE', 'BOX_TOOLS_SETTINGS','FILENAME_PZENTEMPLATE', '', 'tools', 'Y', 20);
		}
	}
	$pzen_temp_data = get_pzen_template_data();
	
	function get_pzen_template_data(){
		global $db;
		$res_ar = array();
		$tr_qry = "SELECT * FROM ".TABLE_PZENTEMPLATE;
		$res = $db->Execute($tr_qry);
		while (!$res->EOF) {
			$res_ar[$res->fields['opt_name'].'__'.$res->fields['lang_id']] = $res->fields;
			$res->MoveNext();
		}
		return $res_ar;
	}
	
	function get_pzen_options($name, $lang_id=0)
	{
		global $pzen_temp_data, $db;
		$res = $pzen_temp_data[$name.'__'.$lang_id];
		return $res['opt_value'];
	}
	
	function update_pzen_options($name,$value,$lang_id)
	{
		global $db;
		$chk_keys = "select * from ".TABLE_PZENTEMPLATE." WHERE opt_name='".$name."' and lang_id='".$lang_id."'";
		$res_chk_keys = $db->Execute($chk_keys);
		$numsrows_chek_keys = $res_chk_keys->RecordCount();
		if($numsrows_chek_keys==0)
		{
			 $tr_qry = "INSERT INTO ".TABLE_PZENTEMPLATE."(lang_id,opt_name,opt_value) VALUES('".$lang_id."','".$name."','".$value."')";
		}else
		{
			 $tr_qry = "UPDATE ".TABLE_PZENTEMPLATE." set opt_value='".$value."'  WHERE opt_name='".$name."' and lang_id='".$lang_id."'";
		}
		$tr_config = $db->Execute($tr_qry);
		return array("$name"=>"$value");
	}
	
	function pzen_categories_list(){
		require_once (DIR_WS_CLASSES . 'pzen_categories_ul_generator.php');
		$zen_CategoriesUL = new pzen_categories_ul_generator;
		$menulist = $zen_CategoriesUL->buildTree(true);
		if($menulist){
			$pzen_menu = $menulist;
			$pzen_menu['catul_ar'] = $zen_CategoriesUL;
		}
		return $pzen_menu;
	}
	/**================================================================
	** Mega Menu
	**================================================================*/
	function pzen_megamenu(){
		global $languages_id, $db, $pzen_menu;
		$cat_array = array();
		
		$menulist = $pzen_menu['megamenu'];
		$zen_CategoriesUL = $pzen_menu['catul_ar'];
		$cat_array = $zen_CategoriesUL->data;
				
		foreach($cat_array[0] as $k0=>$v0){
			/**================================================================================================
			**Add menuitem marked
			**===============================================================================================*/
			$subcat_marked=$bdg_type=get_pzen_options("subcat_marked_".$k0);
			if($subcat_marked==1){
				$menulist = str_replace('[MEGAMENU__SUBMENU--MARKED]','megamenu__submenu--marked',$menulist);
			}else{
				$menulist = str_replace('[MG-MARKED ID="'.$k0.'"]','',$menulist);
			}
			
			/**================================================================================================
			**Main Category badge
			**===============================================================================================*/
			global $this_is_home_page;
			$homepage_layout=(get_pzen_options('homepage_layout')) ? get_pzen_options('homepage_layout') : '1' ;
			$bdg_type=get_pzen_options("badge_type_".$k0);
			if($bdg_type==1){
				$menulist = str_replace('[BADGE ID="'.$k0.'"]','<span class="badge badge--menu '.(($homepage_layout==2)? 'pull-right' : '').'">'.PZEN_BADGE_NEW.'</span>',$menulist);
			}else if($bdg_type==2){
				$menulist = str_replace('[BADGE ID="'.$k0.'"]','<span class="badge badge--menu badge--color '.(($homepage_layout==2)? 'pull-right' : '').'">'.PZEN_BADGE_SALE.'</span>',$menulist);
			}else{
				$menulist = str_replace('[BADGE ID="'.$k0.'"]','',$menulist);
			}
			
			/**================================================================================================
			**Add megamenu side block content
			**===============================================================================================*/
			$sideblock_type=get_pzen_options("megamenu_btype_".$k0);
			if($sideblock_type==1){
				$sideblock=generate_specialspro_block($k0);
				$menulist = str_replace('[MEGAMENU--SIDE-BLOCK ID="'.$k0.'"]',$sideblock,$menulist);
			}else if($sideblock_type==2){
				$sideblock=generate_featuredpro_block($k0);
				$menulist = str_replace('[MEGAMENU--SIDE-BLOCK ID="'.$k0.'"]',$sideblock,$menulist);
			}else{
				$menulist = str_replace('[MEGAMENU--SIDE-BLOCK ID="'.$k0.'"]','',$menulist);
			}
			
			
			/**================================================================================================
			**Add megamenu bottom block content
			**===============================================================================================*/
			$bottomblock=get_pzen_options("megamenu_bottom_block_".$k0);
			
			$bottomblock_cont=generate_banners($k0);
			
			if($bottomblock==1){$menulist = str_replace('[MEGAMENU-BOTTOM-BLOCK ID="'.$k0.'"]',$bottomblock_cont,$menulist);}
			else{$menulist = str_replace('[MEGAMENU-BOTTOM-BLOCK ID="'.$k0.'"]','',$menulist);}
		}
	
		$menulist = str_replace("</li>\n</ul>\n</li>\n</ul>\n","</li>\n</ul>\n",$menulist);
		echo $menulist;
		
	}
	/**================================================================
	** Generate cagegories wise featured block
	**================================================================*/
	function generate_featuredpro_block($id){
		global $db;
		$productsInCategory = zen_get_categories_products_list($id);
		$list_of_products='';
		if (is_array($productsInCategory) && sizeof($productsInCategory) > 0) {
			// build products-list string to insert into SQL query
			foreach($productsInCategory as $key => $value) {
			  $list_of_products .= $key . ', ';
			}
			$list_of_products = substr($list_of_products, 0, -2); // remove trailing comma
			$featured_products_query = "select distinct p.products_id, p.products_image, pd.products_name, p.master_categories_id
										from (" . TABLE_PRODUCTS . " p
										left join " . TABLE_FEATURED . " f on p.products_id = f.products_id
										left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id)
										where p.products_id = f.products_id
										and p.products_id = pd.products_id
										and p.products_status = 1 and f.status = 1
										and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
										and p.products_id in (" . $list_of_products . ")";
		}
		if ($featured_products_query != '') $featured_products = $db->ExecuteRandomMulti($featured_products_query,2);
		$num_products_count = ($featured_products_query == '') ? 0 : $featured_products->RecordCount();
		$sideblock_type_view=get_pzen_options("megamenu_btype_view_".$id);
		if($num_products_count>0){
			if($sideblock_type_view==1){
			//with slider
				$html='
					<li class="col-sm-3 hidden-xs">
						<a class="megamenu__subtitle" href="'.zen_href_link(FILENAME_FEATURED_PRODUCTS, '', 'SSL').'"><span>Featured</span></a>
						<div class="carousel-products" id="megaMenuCarousel1">
							
					';		
				while (!$featured_products->EOF) {
					$products_price = zen_get_products_display_price($featured_products->fields['products_id']);
					$html.='<div>
							<div class="product">
								<div class="product__inside">
									<!-- product image -->
									<div class="product__inside__image">
										<a href="'.zen_href_link(zen_get_info_page($featured_products->fields['products_id']), 'cPath=' . $productsInCategory[$featured_products->fields['products_id']] . '&products_id=' . $featured_products->fields['products_id'], 'SSL').'">'.zen_image(DIR_WS_IMAGES . $featured_products->fields['products_image'], $featured_products->fields['products_name'], IMAGE_FEATURED_PRODUCTS_LISTING_WIDTH, IMAGE_FEATURED_PRODUCTS_LISTING_HEIGHT).'</a>
									</div>
									<!-- /product image --> 
									<!-- product name -->
									<div class="product__inside__name">
										<h2><a href="'.zen_href_link(zen_get_info_page($featured_products->fields['products_id']), 'cPath=' . $productsInCategory[$featured_products->fields['products_id']] . '&products_id=' . $featured_products->fields['products_id'], 'SSL').'">'.$featured_products->fields['products_name'].'</a></h2>
									</div>
									<!-- /product name --> 
									<!-- product price -->
									<div class="price-box">'.$products_price.'</div>
									<!-- /product price --> 
								</div>
							</div>
							</div>';
					$featured_products->MoveNextRandom();
				}
				$html.='
							
						</div>
				</li>';
			}else{
			//without slider
				$html='
				<li class="col-sm-3 hidden-xs">
					<a class="megamenu__subtitle" href="'.zen_href_link(FILENAME_FEATURED_PRODUCTS, '', 'SSL').'"><span>Featured</span></a>
					<div class="vertical-carousel special-carousel">
					';		
			while (!$featured_products->EOF) {
				$products_price = zen_get_products_display_price($featured_products->fields['products_id']);
				$html.='<div class="vertical-carousel__item">
							<div class="vertical-carousel__item__image pull-left"><a href="'.zen_href_link(zen_get_info_page($featured_products->fields['products_id']), 'cPath=' . $productsInCategory[$featured_products->fields['products_id']] . '&products_id=' . $featured_products->fields['products_id'], 'SSL').'">'.zen_image(DIR_WS_IMAGES . $featured_products->fields['products_image'], $featured_products->fields['products_name'], IMAGE_FEATURED_PRODUCTS_LISTING_WIDTH, IMAGE_FEATURED_PRODUCTS_LISTING_HEIGHT).'</a></div>
							<div class="product__label product__label--sale"> <span>Sale</span></div>
							<div class="vertical-carousel__item__title">
								<h2><a href="'.zen_href_link(zen_get_info_page($featured_products->fields['products_id']), 'cPath=' . $productsInCategory[$featured_products->fields['products_id']] . '&products_id=' . $featured_products->fields['products_id'], 'SSL').'">'.$featured_products->fields['products_name'].'</a></h2>
							</div>
							<div class="price-box">'.$products_price.'</div>
						</div>
					';
				$featured_products->MoveNextRandom();
			}
				$html.='
					</div>
				</li>';
			
			}
			return $html;
		}
	}
	/**================================================================
	** Generate cagegories wise special block
	**================================================================*/	
	function generate_specialspro_block($id){
		global $db;
		$productsInCategory = zen_get_categories_products_list($id);
		$list_of_products='';
		if (is_array($productsInCategory) && sizeof($productsInCategory) > 0) {
			// build products-list string to insert into SQL query
			foreach($productsInCategory as $key => $value) {
			  $list_of_products .= $key . ', ';
			}
			$list_of_products = substr($list_of_products, 0, -2); // remove trailing comma
			$specials_index_query = "select distinct p.products_id, p.products_image, pd.products_name, p.master_categories_id
                             from (" . TABLE_PRODUCTS . " p
                             left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id
                             left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id )
                             where p.products_id = s.products_id
                             and p.products_id = pd.products_id
                             and p.products_status = '1' and s.status = '1'
                             and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                             and p.products_id in (" . $list_of_products . ")";
		}
		if ($specials_index_query != '') $specials_products = $db->ExecuteRandomMulti($specials_index_query,2);
		$num_products_count = ($specials_index_query == '') ? 0 : $specials_products->RecordCount();
		$sideblock_type_view=get_pzen_options("megamenu_btype_view_".$id);
		if($num_products_count>0){
			if($sideblock_type_view==1){
			//with slider
				$html='
					<li class="col-sm-3 hidden-xs">
						<a class="megamenu__subtitle" href="'.zen_href_link(FILENAME_SPECIALS, '', 'SSL').'"><span>Specials</span></a>
						<div class="carousel-products" id="megaMenuCarousel1">
							
					';		
				while (!$specials_products->EOF) {
					$products_price = zen_get_products_display_price($specials_products->fields['products_id']);
					$html.='<div>
							<div class="product">
								<div class="product__inside">
									<!-- product image -->
									<div class="product__inside__image">
										<a href="'.zen_href_link(zen_get_info_page($specials_products->fields['products_id']), 'cPath=' . $productsInCategory[$specials_products->fields['products_id']] . '&products_id=' . $specials_products->fields['products_id'], 'SSL').'">'.zen_image(DIR_WS_IMAGES . $specials_products->fields['products_image'], $specials_products->fields['products_name'], IMAGE_specials_products_LISTING_WIDTH, IMAGE_specials_products_LISTING_HEIGHT).'</a>
									</div>
									<!-- /product image --> 
									<!-- product name -->
									<div class="product__inside__name">
										<h2><a href="'.zen_href_link(zen_get_info_page($specials_products->fields['products_id']), 'cPath=' . $productsInCategory[$specials_products->fields['products_id']] . '&products_id=' . $specials_products->fields['products_id'], 'SSL').'">'.$specials_products->fields['products_name'].'</a></h2>
									</div>
									<!-- /product name --> 
									<!-- product price -->
									<div class="price-box">'.$products_price.'</div>
									<!-- /product price --> 
								</div>
							</div>
							</div>';
					$specials_products->MoveNextRandom();
				}
				$html.='
							
						</div>
				</li>';
			}else{
			//without slider
				$html='
				<li class="col-sm-3 hidden-xs">
					<a class="megamenu__subtitle" href="'.zen_href_link(FILENAME_SPECIALS, '', 'SSL').'"><span>Specials</span></a>
					<div class="vertical-carousel special-carousel">
					';		
			while (!$specials_products->EOF) {
				$products_price = zen_get_products_display_price($specials_products->fields['products_id']);
				$html.='<div class="vertical-carousel__item">
							<div class="vertical-carousel__item__image pull-left"><a href="'.zen_href_link(zen_get_info_page($specials_products->fields['products_id']), 'cPath=' . $productsInCategory[$specials_products->fields['products_id']] . '&products_id=' . $specials_products->fields['products_id'], 'SSL').'">'.zen_image(DIR_WS_IMAGES . $specials_products->fields['products_image'], $specials_products->fields['products_name'], IMAGE_specials_products_LISTING_WIDTH, IMAGE_specials_products_LISTING_HEIGHT).'</a></div>
							<div class="product__label product__label--sale"> <span>Sale</span></div>
							<div class="vertical-carousel__item__title">
								<h2><a href="'.zen_href_link(zen_get_info_page($specials_products->fields['products_id']), 'cPath=' . $productsInCategory[$specials_products->fields['products_id']] . '&products_id=' . $specials_products->fields['products_id'], 'SSL').'">'.$specials_products->fields['products_name'].'</a></h2>
							</div>
							<div class="price-box">'.$products_price.'</div>
						</div>
					';
				$specials_products->MoveNextRandom();
			}
				$html.='
					</div>
				</li>';
			
			}
			return $html;
		}
	}
	function generate_banners($id){
		global $template, $current_page_base;
		$uploaddir_path=$template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'images/uploads/');
		$html='';
		$html.='<li class="col-sm-12 hidden-xs">
					<div class="row">
						<div class="col-sm-6"> <a class="discolor-hover" href="'.get_pzen_options('mg_botban_cont_0_'.$id.'_link').'"><img alt="" src="'.$uploaddir_path.get_pzen_options('mg_botban_cont_0_'.$id.'_img').'" class="img-responsive"></a> </div>
						<div class="col-sm-6"> <a class="discolor-hover" href="'.get_pzen_options('mg_botban_cont_1_'.$id.'_link').'"><img alt="" src="'.$uploaddir_path.get_pzen_options('mg_botban_cont_1_'.$id.'_img').'" class="img-responsive"></a> </div>
					</div>
				</li>';
		return $html;
	}