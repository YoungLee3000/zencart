<?php 
ob_start();
##PZENTEMPLATE_BRAND##

define('STRICT_ERROR_REPORTING', true);

require('includes/application_top.php');
require(DIR_WS_MODULES . 'prod_cat_header_code.php');
$url=$_SERVER['REQUEST_URI'];
$cancel_url= preg_replace("/pzen_template.php.*/", "pzen_template.php", $url);
$time=time();
$languages = zen_get_languages();			
$uploads_path="../includes/templates/".pzen_temp_dir(). "/images/uploads/";

//create table function
pzen_create_table_sql();
?>
<!doctype html>
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<?php if(get_pzen_options('file_favicon')){ ?>
<link rel="icon" href="<?php echo "../includes/templates/" . $template_dir . "/images/uploads/".get_pzen_options('file_favicon'); ?>" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo "../includes/templates/" . $template_dir . "/images/uploads/".get_pzen_options('file_favicon'); ?>" type="image/x-icon" />
<?php } ?>
<meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800,400italic,300italic' rel='stylesheet' type='text/css' />
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/pzen_template/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="includes/pzen_template/css/style.css">
<link rel="stylesheet" type="text/css" href="includes/pzen_template/css/tabcontent.css" />
<link rel="stylesheet" type="text/css" href="includes/pzen_template/css/mcColorPicker.css" />
<link rel="stylesheet" type="text/css" href="includes/pzen_template/css/accordian.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">

<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script src="includes/pzen_template/js/tabcontent.js" type="text/javascript"></script>
<script src="includes/pzen_template/js/mcColorPicker.js" type="text/javascript"></script>
<script src="includes/pzen_template/js/jquery.min.js" type="text/javascript"></script>
<script src="includes/pzen_template/js/custom.js" type="text/javascript"></script>
<?php if ($editor_handler != '') include ($editor_handler); ?>
</head>

<!-- body //-->
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onLoad="init()">
<div id="spiffycalendar" class="text"></div>
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->
<?php 
if(isset($_POST['frm_pzen_set_submit']))
	{
		unset($_POST['frm_pzen_set_submit']);
		if(isset($_POST['news_id']) || isset($_POST['news_image'])) {
			global $db;
			$news_ids = explode("-",zen_db_prepare_input($_POST['news_id']));
			$news_id=$news_ids[0];
			$lang_id=$news_ids[1];
			$news_image = $_FILES['news_image']['name'];
			$news_image_tmp = $_FILES['news_image']['tmp_name'];
			
			if(($news_image != NULL)) {
				$time=time();
				$flext = pathinfo($news_image, PATHINFO_EXTENSION);
				$fnl=str_replace('.'.$flext,'',$news_image);
				$news_image= $fnl.'_'.$time.".".$flext;
				$news_image_update = "UPDATE " . TABLE_BOX_NEWS_CONTENT . " SET news_image='$news_image' where box_news_id='$news_id' and languages_id='$lang_id' ";
				$news_image_update_result = $db->Execute($news_image_update);
				move_uploaded_file($news_image_tmp,pzen_temp_dir('temp_dir').'/images/news/'. $news_image);
			}
			unset($_POST['news_id']);
			unset($_POST['news_image']);
			unset($_FILES['news_image']);
		}
		foreach($_POST as $k=>$v){
			if(is_array($v)){
				foreach($v as $k1=>$v1){
					update_pzen_options($k,zen_db_prepare_input($v1),$k1);
				}
			}else{
				update_pzen_options($k,zen_db_prepare_input($v));
			}
		}
		foreach($_FILES as $k=>$v){
			pzen_fileupload($k,$k);
		}
		$messageStack->add_session(PZEN_CONFIGURATION_SAVED, 'success');
	    zen_redirect(zen_href_link(FILENAME_PZENTEMPLATE.".php",'','SSL')); 
	}
?>
<!-- body //-->
<section class="main_wrapper">
   <div class="container">
   	  <div class="content">
   		<header>
        	<div class="logo">
            	<img class="logo" title="Image" alt="Image" src="includes/pzen_template/images/logo.png" />
            </div>
			<a class="helpdoc_lnk" href="http://yourstore.perfectusinc.com/documentation/" target="_blank">Help Document</a>
        </header>
        <div class="tab-wrapper">
            <ul class="tabs" data-persist="true">
				<li><a href="#view1"><?php echo PZEN_TABS_GENERAL; ?></a></li>
				<li><a href="#view17"><?php echo PZEN_TABS_HOMEPAGE; ?></a></li> 
				<li><a href="#view2"><?php echo PZEN_TABS_HEADER; ?></a></li> 
				<li><a href="#view3"><?php echo PZEN_TABS_FOOTER; ?></a></li>
				<li><a href="#view4"><?php echo PZEN_TABS_MAINMENU; ?></a></li>
				<li><a href="#view10"><?php echo PZEN_TABS_MAINSLIDER; ?></a></li>
				<li><a href="#view12"><?php echo PZEN_TABS_TOPBANNERS; ?></a></li>	
				<li><a href="#view13"><?php echo PZEN_TABS_MIDDLEBANNERS; ?></a></li>
				<li><a href="#view14"><?php echo PZEN_TABS_BOTTOMBANNERS; ?></a></li>
				<li><a href="#view20"><?php echo PZEN_TABS_SIDEBARBANNERS; ?></a></li>
				<li><a href="#view15"><?php echo PZEN_TABS_INDEXPAGE; ?></a></li>
				<li><a href="#view16"><?php echo PZEN_TABS_NEWSBOX; ?></a></li>
				<li><a href="#view19"><?php echo PZEN_TABS_PRODUCTLISTING; ?></a></li>
				<li><a href="#view18"><?php echo PZEN_TABS_PRODUCTINFO; ?></a></li>
            </ul> 
            <div class="tabcontents"> 
                <div id="view1" class="tab-content">
					<form name='frm_pzen' action="<?php echo zen_href_link(FILENAME_PZENTEMPLATE, '', 'SSL'); ?>" method="post" enctype="multipart/form-data">
						<h1 class="tab-header"><?php echo PZEN_TABS_GENERAL ?></h1>
						<div class="sec_accordian">
							<section class="block">
								<header class="block-header">
									<h2 class="title"><?php echo PZEN_LABEL_THEME_SETTINGS; ?></h2>
								</header>
								<div class="block-content">
									<div class="rw">
										<label><?php echo PZEN_THEME_LAYOUT; ?> :</label>
										<div class="cont">
											<?php 
												$themelayout=get_pzen_options('theme_layout');
												if($themelayout==''){$themelayout=1;}
											?>
											<ul class="inline-ul">
												<li><input type="radio" name="theme_layout" value="1" <?php echo ($themelayout==1)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_THEME_DEFAULT_LAYOUT; ?></span></li>
												<li><input type="radio" name="theme_layout" value="2" <?php echo ($themelayout==2)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_THEME_DARK_LAYOUT; ?></span></li>
											</ul>
										</div>
									</div>
									<div class="rw">
										<label><?php echo PZEN_THEME_COLOR; ?> :</label>
										<div class="cont"><?php echo pzen_draw_color_inputbox('theme_color'); ?></div>
									</div>
									<div class="rw">
										<label><?php echo PZEN_LABEL_QUICKVIEW; ?> :</label>
										<div class="cont"><?php echo pzen_draw_enabledisableradio('pzen_quickview_status'); ?></div>
									</div>
									<div class="rw">
										<label><?php echo PZEN_LABEL_ADDITIONAL_IMAGE_TYPE; ?> :</label>
										<div class="cont">
											<?php 
												$prodlist_addtionalimg_type=get_pzen_options('prodlist_addtionalimg_type');
												if($prodlist_addtionalimg_type==''){$prodlist_addtionalimg_type=1;}
											?>
											<ul class="inline-ul">
												<li><input type="radio" class="lnk_action" data-tarlnk="inner_sec_addimgtype" name="prodlist_addtionalimg_type" value="1" <?php echo ($prodlist_addtionalimg_type==1)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_DEFAULT; ?></span></li>
												<li><input type="radio" class="lnk_action" data-tarlnk="inner_sec_addimgtype"  name="prodlist_addtionalimg_type" value="2" <?php echo ($prodlist_addtionalimg_type==2)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_HOVER_EFFECT; ?></span></li>
												<li><input type="radio" class="lnk_action" data-tarlnk="inner_sec_addimgtype" data-target="inner_sec_nums_addimg" name="prodlist_addtionalimg_type" value="3" <?php echo ($prodlist_addtionalimg_type==3)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_SLIDER_VIEW; ?></span></li>
											</ul>
										</div>
									</div>
									<div id="inner_sec_nums_addimg" class="inner_section inner_sec_addimgtype" style="<?php echo ($prodlist_addtionalimg_type==3)? 'display:block;' : 'display:none;'; ?>">
										<div class="rw">
											<div class="cont">
												<div class="rw_full">
													<div class="rw">
														<label><?php echo PZEN_LABEL_DISNUM_ADDITIONAL; ?> :</label>
														<div class="con">
															<?php $prodlist_nums_addimgs=(get_pzen_options('prodlist_nums_addimgs'))? get_pzen_options('prodlist_nums_addimgs') : '4'; ?>
															<input type="number" name="prodlist_nums_addimgs" value="<?php echo $prodlist_nums_addimgs; ?>" max="5" maxlength="1" size="20" style="width:60px;text-align:center;" />
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="rw">
										<label><?php echo PZEN_THEME_MODE; ?> :</label>
										<div class="cont"><?php echo pzen_draw_yesnoradio('theme_mode'); ?></div>
									</div>
								</div>
							</section>
							<section class="block">
								<header class="block-header">
									<h2 class="title"><?php echo PZEN_FONT_SETTINGS; ?></h2>
								</header>
								<div class="block-content">
									<div class="rw">
										<label><?php echo PZEN_LABEL_GENERAL_FONT_FAMILY; ?> :</label>
										<div class="cont">
											<?php $general_font_family=get_pzen_options('general_font_family'); ?>
											<?php echo pzen_generate_fontfamily_pull_down('general_font_family',$general_font_family,''); ?>
											<p class="notice"><?php echo PZEN_NOTICE_GENERAL_FONT_FAMILY; ?></p>
										</div>
									</div>
									<div class="rw">
										<label><?php echo PZEN_LABEL_BANNER_CAPTION_FONT_FAMILY; ?> :</label>
										<div class="cont">
											<?php $bannercap_font_family=get_pzen_options('bannercap_font_family'); ?>
											<?php echo pzen_generate_fontfamily_pull_down('bannercap_font_family',$bannercap_font_family,''); ?>
											<p class="notice"><?php echo PZEN_NOTICE_BANNER_CAPTION_FONT_FAMILY; ?></p>
										</div>
									</div>
									<div class="rw">
										<label><?php echo PZEN_LABEL_LATIN_EXTENDED; ?> :</label>
										<div class="cont">
											<?php $font_latin_charset_extended=get_pzen_options('font_latin_charset_extended'); 
												if($font_latin_charset_extended==''){ $font_latin_charset_extended=0;}
											?>
											<select name='font_latin_charset_extended'>
												<option <?php echo ($font_latin_charset_extended==1) ? 'selected="selected"' : '' ; ?>  value="1"><?php echo PZEN_ENABLE; ?></option>
												<option <?php echo ($font_latin_charset_extended==0) ? 'selected="selected"' : '' ; ?> value="0"><?php echo PZEN_DISABLE; ?></option>
											</select>
											<p class="notice"><?php echo PZEN_NOTICE_LATIN_EXTENDED; ?></p>
										</div>
									</div>
									<div class="rw">
										<label><?php echo PZEN_LABEL_CUSTOM_CHARSET_EXTENDED; ?> :</label>
										<div class="cont">
											<?php echo pzen_draw_inputbox('font_custom_charset'); ?>
											<p class="notice"><?php echo PZEN_NOTICE_CUSTOM_CHARSET_EXTENDED; ?></p>
										</div>
									</div>
									<div class="rw">
										<label><?php echo PZEN_THEME_FONT_SIZE; ?> :</label>
										<div class="cont">
											<?php 
												$theme_font_size=get_pzen_options('theme_font_size');
												if($theme_font_size==''){$theme_font_size=3;}
											?>
											<ul class="inline-ul">
												<li><input type="radio" name="theme_font_size" value="1" <?php echo ($theme_font_size==1)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_SMALL; ?></span></li>
												<li><input type="radio" name="theme_font_size" value="2" <?php echo ($theme_font_size==2)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_MEDIUM; ?></span></li>
												<li><input type="radio" name="theme_font_size" value="3" <?php echo ($theme_font_size==3)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_LARGE; ?></span></li>
											</ul>
										</div>
									</div>
									<div class="rw">
										<label><?php echo PZEN_THEME_BUTTON_SIZE; ?> :</label>
										<div class="cont">
											<?php 
												$theme_btn_size=get_pzen_options('theme_btn_size');
												if($theme_btn_size==''){$theme_btn_size=3;}
											?>
											<ul class="inline-ul">
												<li><input type="radio" name="theme_btn_size" value="1" <?php echo ($theme_btn_size==1)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_SMALL; ?></span></li>
												<li><input type="radio" name="theme_btn_size" value="2" <?php echo ($theme_btn_size==2)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_MEDIUM; ?></span></li>
												<li><input type="radio" name="theme_btn_size" value="3" <?php echo ($theme_btn_size==3)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_LARGE; ?></span></li>
											</ul>
										</div>
									</div>
								</div>
							</section>
							<section class="block">
								<header class="block-header">
									<h2 class="title"><?php echo PZEN_TITLE_EXTRA_SETTINGS; ?></h2>
								</header>
								<div class="block-content">
									<div class="rw">
										<label><?php echo PZEN_LABEL_PAGE_LOADER; ?> :</label>
										<div class="cont">
											<?php 
												$page_loader=get_pzen_options('page_loader');
												if($page_loader==''){$page_loader='default';}
											?>
											<ul class="inline-ul">
												<li><input type="radio" class="lnk_action" data-tarlnk="inner_sec_page_loader" name="page_loader" value="none" <?php echo ($page_loader=='none')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_NONE; ?></span></li>
												<li><input type="radio" class="lnk_action" data-tarlnk="inner_sec_page_loader"  name="page_loader" value="default" <?php echo ($page_loader=='default')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_DEFAULT; ?></span></li>
												<li><input type="radio" class="lnk_action" data-tarlnk="inner_sec_page_loader" data-target="inner_pageloader_custom" name="page_loader" value="custom" <?php echo ($page_loader=="custom")? 'checked="checked"' : '' ?> /><span><?php echo PZEN_CUSTOM; ?></span></li>
											</ul>
										</div>
									</div>
									<div id="inner_pageloader_custom" class="inner_section inner_sec_page_loader" style="<?php echo ($page_loader=='custom')? 'display:block;' : 'display:none;'; ?>">
										<div class="rw">
											<div class="cont">
												<div class="rw_full">
													<div class="rw">
														<label><?php echo PZEN_PAGE_LOADER_IMAGE; ?> :</label>
														<div class="con">
															<input type="file" value="" id="" name="page_loader_custom">
															<?php if(get_pzen_options('page_loader_custom')!=''){ ?>
															<div class="file_content">
																<img src="<?php echo $uploads_path.get_pzen_options('page_loader_custom'); ?>" height="auto" width="auto" title="Image" />
															</div>
															<?php } ?>
														</div>
													</div>
													<p class="notice">Please Upload Gif File.</p>
												</div>
											</div>
										</div>
									</div>
									<div class="rw">
										<label><?php echo PZEN_LABEL_PRODUCTS_GRID_LAYOUT; ?> :</label>
										<div class="cont">
											<?php 
												$products_grid_layouts=get_pzen_options('products_grid_layouts');
												if($products_grid_layouts==''){$products_grid_layouts='grid';}
											?>
											<ul class="inline-ul">
												<li><input type="radio" class="lnk_action" data-tarlnk="inner_sec_gridlayout" data-target="inner_gridlayout_custom" name="products_grid_layouts" value="grid" <?php echo ($products_grid_layouts=='grid')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_GRID_VIEW; ?></span></li>
												<li><input type="radio" class="lnk_action" data-tarlnk="inner_sec_gridlayout"  name="products_grid_layouts" value="masonary" <?php echo ($products_grid_layouts=="masonary")? 'checked="checked"' : '' ?> /><span><?php echo PZEN_MASONARY_VIEW; ?></span></li>
											</ul>
										</div>
									</div>
									<div id="inner_gridlayout_custom" class="inner_section inner_sec_gridlayout" style="<?php echo ($products_grid_layouts=='grid')? 'display:block;' : 'display:none;'; ?>">
										<div class="rw">
											<div class="cont">
												<div class="rw_full">
													<div class="rw">
														<label><?php echo PZEN_LABEL_NUMSOFCOLS_XL; ?> :</label>
														<div class="con">
															<?php $prodgrid_nums_cols_xl=(get_pzen_options('prodgrid_nums_cols_xl'))? get_pzen_options('prodgrid_nums_cols_xl') : '5'; ?>
															<input type="number" name="prodgrid_nums_cols_xl" value="<?php echo $prodgrid_nums_cols_xl; ?>" max="6" min='1' maxlength="1" size="20" style="width:60px;text-align:center;" />
														</div>
													</div>
													<div class="rw">
														<label><?php echo PZEN_LABEL_NUMSOFCOLS_LG; ?> :</label>
														<div class="con">
															<?php $prodgrid_nums_cols_lg=(get_pzen_options('prodgrid_nums_cols_lg'))? get_pzen_options('prodgrid_nums_cols_lg') : '3'; ?>
															<input type="number" name="prodgrid_nums_cols_lg" value="<?php echo $prodgrid_nums_cols_lg; ?>" max="6" min='1' maxlength="1" size="20" style="width:60px;text-align:center;" />
														</div>
													</div>
													<div class="rw">
														<label><?php echo PZEN_LABEL_NUMSOFCOLS_MD; ?> :</label>
														<div class="con">
															<?php $prodgrid_nums_cols_md=(get_pzen_options('prodgrid_nums_cols_md'))? get_pzen_options('prodgrid_nums_cols_md') : '2'; ?>
															<input type="number" name="prodgrid_nums_cols_md" value="<?php echo $prodgrid_nums_cols_md; ?>" max="6" min='1' maxlength="1" size="20" style="width:60px;text-align:center;" />
														</div>
													</div>
													<div class="rw">
														<label><?php echo PZEN_LABEL_NUMSOFCOLS_SM; ?> :</label>
														<div class="con">
															<?php $prodgrid_nums_cols_sm=(get_pzen_options('prodgrid_nums_cols_sm'))? get_pzen_options('prodgrid_nums_cols_sm') : '3'; ?>
															<input type="number" name="prodgrid_nums_cols_sm" value="<?php echo $prodgrid_nums_cols_sm; ?>" max="6" min='1' maxlength="1" size="20" style="width:60px;text-align:center;" />
														</div>
													</div>
													<div class="rw">
														<label><?php echo PZEN_LABEL_NUMSOFCOLS_XS; ?> :</label>
														<div class="con">
															<?php $prodgrid_nums_cols_xs=(get_pzen_options('prodgrid_nums_cols_xs'))? get_pzen_options('prodgrid_nums_cols_xs') : '2'; ?>
															<input type="number" name="prodgrid_nums_cols_xs" value="<?php echo $prodgrid_nums_cols_xs; ?>" max="6" min='1' maxlength="1" size="20" style="width:60px;text-align:center;" />
														</div>
													</div>
													<div class="rw">
														<label><?php echo PZEN_LABEL_NUMSOFCOLS_XXS; ?> :</label>
														<div class="con">
															<?php $prodgrid_nums_cols_xxs=(get_pzen_options('prodgrid_nums_cols_xxs'))? get_pzen_options('prodgrid_nums_cols_xxs') : '1'; ?>
															<input type="number" name="prodgrid_nums_cols_xxs" value="<?php echo $prodgrid_nums_cols_xxs; ?>" max="6" min='1' maxlength="1" size="20" style="width:60px;text-align:center;" />
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</section>
							<section class="block">
								<header class="block-header">
									<h2 class="title"><?php echo PZEN_STORE_CONTACT_DETAILS; ?></h2>
								</header>
								<div class="block-content">
									<div class="row noborder">
										<p class="notice"><?php echo PZEN_NOTICE_LEAVE_EMPTY_SETDEFAULT; ?></p>
									</div>
									<div class="rw">
										<label><?php echo PZEN_LABEL_ADDRESS; ?></label>
										<div class="cont"><?php echo pzen_draw_textarea('store_address'); ?></div>
									</div>
									<div class="rw">
										<label><?php echo PZEN_LABEL_CONTACT_NUMBER; ?></label>
										<div class="cont"><?php echo pzen_draw_inputbox('store_contact'); ?></div>
									</div>
									<div class="rw">
										<label><?php echo PZEN_LABEL_FAX; ?></label>
										<div class="cont"><?php echo pzen_draw_inputbox('store_fax'); ?></div>
									</div>
									<div class="rw">
										<label><?php echo PZEN_LABEL_SKYPE_ID; ?></label>
										<div class="cont"><?php echo pzen_draw_inputbox('store_skype'); ?></div>
									</div>
									<div class="rw">
										<label><?php echo PZEN_LABEL_STORE_EMAIL_ADDRESS; ?></label>
										<div class="cont"><?php echo pzen_draw_inputbox('store_email'); ?></div>
									</div>
									<div class="rw">
										<label><?php echo PZEN_LABEL_STORE_TIMINGS; ?></label>
										<div class="cont"><?php echo pzen_draw_inputbox('store_timings'); ?></div>
									</div>
								</div>
							</section>
							<section class="block">
								<header class="block-header">
									<h2 class="title"><?php echo PZEN_NEWSLETTER_SUBSCRIBE_DETAILS; ?></h2>
								</header>
								<div class="block-content">                  	
									<div class="rw">
										<label><?php echo PZEN_LABEL_NEWSLETTER_SUBSCRIBE; ?></label>
										<div class="cont">
											<?php echo pzen_draw_textarea('newsletter_details'); ?>
											<p class="notice"><?php echo PZEN_NOTICE_NEWSLETTER_DETAILS; ?></p>
										</div>
									</div>
								</div>
							</section>
							<section class="block">
								<header class="block-header">
									<h2 class="title"><?php echo PZEN_TITLE_ENABLE_DISABLE_SEC; ?></h2>
								</header>
								<div class="block-content">
									<div class="rw">
										<label><?php echo PZEN_LABEL_DISPLAYPOPUP; ?></label>
										<div class="cont"><?php echo pzen_draw_yesnoradio('display_popup_sec'); ?></div>
									</div>
									<div class="rw">
										<label><?php echo PZEN_LABEL_NEWSLETTER_SECTION; ?></label>
										<div class="cont"><?php echo pzen_draw_yesnoradio('display_newsletter'); ?></div>
									</div>
								</div>
							</section>
							<section class="block">
								<header class="block-header">
									<h2 class="title"><?php echo PZEN_TITLE_GOOGLEMAP; ?></h2>
								</header>
								<div class="block-content">                  	
									<div class="rw">
										<label><?php echo PZEN_LABEL_GOOGLEMAP; ?></label>
										<div class="cont">
											<div class="cont"><?php echo pzen_draw_textarea('google_map'); ?></div>
										</div>
									</div>
									<div class="row noborder">
										<p class="notice"><?php echo PZEN_NOTICE_GOOGLEMAP; ?></p>		
									</div>
								</div>
							</section>
							<section class="block">
								<header class="block-header">
									<h2 class="title"><?php echo PZEN_TITLE_RECAPTCHA; ?></h2>
								</header>
								<div class="block-content">
									<div class="row noborder">
										<p class="notice"><?php echo PZEN_NOTICE_RECAPTCHA; ?></p>		
									</div>
									<div class="rw">
										<label><?php echo PZEN_LABEL_SITEKEY; ?></label>
										<div class="cont">
											<div class="cont"><?php echo pzen_draw_inputbox('google_site_key'); ?></div>
										</div>
									</div>
									<div class="rw">
										<label><?php echo PZEN_LABEL_SECRETKEY; ?></label>
										<div class="cont">
											<div class="cont"><?php echo pzen_draw_inputbox('google_secret_key'); ?></div>
										</div>
									</div>
								</div>
							</section>
						</div>
						<input type="hidden" name="frm_pzen_set_submit" value="" />
					</form>
                </div>
				<div id="view17" class="tab-content">
                    <h1 class="tab-header"><?php echo PZEN_TABHEAD_HOMEPAGE_SETTINGS;?></h1>
					<form name='frm_pzen' action="<?php echo zen_href_link(FILENAME_PZENTEMPLATE, '', 'SSL'); ?>" method="post" enctype="multipart/form-data">
						<div class="sec_accordian">
							<section class="block">
								<header class="block-header">
									<h2 class="title"><?php echo PZEN_TABHEAD_HOMEPAGE_VIEW; ?></h2>
								</header>
								<div class="block-content">
									<div class="rw">
										<label><?php echo PZEN_LABEL_HOMELAYOUT; ?> :</label>
										<div class="cont">
											<?php 
												$homepglayout=get_pzen_options('homepage_layout');
												if($homepglayout==''){$homepglayout=1;}
											?>
											<ul class="inline-ul">
												<li><input type="radio" class="lnk_action" data-tarlnk="inner_sec_homepagelayout" name="homepage_layout" value="1" <?php echo ($homepglayout==1)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_HOME_FULLWIDTH; ?></span></li>
												<li><input type="radio" class="lnk_action" data-tarlnk="inner_sec_homepagelayout" data-target="inner_sec_botblk_homepg_layout" name="homepage_layout" value="2" <?php echo ($homepglayout==2)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_HOME_TWOCOLUMNS; ?></span></li>
											</ul>
										</div>
									</div>
									<div class="rw">
										<div id="inner_sec_botblk_homepg_layout" class="inner_section inner_sec_homepagelayout" style="<?php echo ($homepglayout==1)? 'display:none;' : ''; ?>">
											<div class="rw">
												<label><?php echo PZEN_LABEL_TWO_COLUMNS_SETTINGS; ?></label>
												<div class="cont">
													<div class="rw_full">
														<div class="rw">
															<label><?php echo PZEN_SIDEBAR_CATEGORYMENU_STATUS; ?> :</label>
															<div class="con">
																<?php 		
																	$sidebar_catmenu_status=get_pzen_options('sidebar_catmenu_status');		
																	if($sidebar_catmenu_status==''){$sidebar_catmenu_status=1;}		
																?>		
																<ul class="inline-ul">
																	<li><input type="radio" name="sidebar_catmenu_status" value="0" <?php echo ($sidebar_catmenu_status==0)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_NONE; ?></span></li>
																	<li><input type="radio" name="sidebar_catmenu_status" value="1" <?php echo ($sidebar_catmenu_status==1)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_SIMPLE_MENU; ?></span></li>		
																	<li><input type="radio" name="sidebar_catmenu_status" value="2" <?php echo ($sidebar_catmenu_status==2)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_MEGA_MENU; ?></span></li>		
																</ul>
															</div>
														</div>
														<div class="rw">
															<label><?php echo PZEN_SIDEBAR_CATEGORYMENU_BGCOLOR; ?> :</label>
															<div class="con">
																<?php 
																	$sidebarcat_menu_layout=get_pzen_options('sidebarcat_menu_layout');
																	if($sidebarcat_menu_layout==''){$sidebarcat_menu_layout=1;}
																?>
																<ul class="inline-ul">
																	<li><input type="radio" name="sidebarcat_menu_layout" value="1" <?php echo ($sidebarcat_menu_layout==1)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_SIDEBARCAT_DEFAULT; ?></span></li>
																	<li><input type="radio" class="lnk_action" data-tarlnk="inner_sec_homepagelayout" data-target="inner_sec_botblk_homepg_layout" name="sidebarcat_menu_layout" value="2" <?php echo ($sidebarcat_menu_layout==2)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_SIDEBARCAT_THEMECOLOR; ?></span></li>
																</ul>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</section>
							<section class="block">
								<header class="block-header">
									<h2 class="title"><?php echo PZEN_TABHEAD_HOME_RANDPROSLIDER; ?></h2>
								</header>
								<div class="block-content">
									<div class="rw">
										<label><?php echo PZEN_LABEL_RANDPROSLIDER; ?> :</label>
										<div class="cont">
												<?php echo pzen_draw_yesnoradio('home_randproslider'); ?>
												<p class="notice"><?php echo PZEN_NOTICE_BRANDSLIDER; ?></p>
										</div>
									</div>
									<div class="rw">
										<label><?php echo PZEN_LABEL_RANDOM_LAYOUT; ?></label>
										<div class="cont">
											<?php 
												$randprodstyle=get_pzen_options('rand_products_display_style');
												if($randprodstyle==''){$randprodstyle="default";}
											?>
											<ul class="inline-ul">
												<li><input type="radio" name="rand_products_display_style" value="default" <?php echo ($randprodstyle=='default')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_DEFAULT_GRID_VIEW; ?></span></li>
												<li><input type="radio" name="rand_products_display_style" value="slider" <?php echo ($randprodstyle=='slider')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_SLIDER_VIEW; ?></span></li>
											</ul>
										</div>
									</div>
									<div class="rw">
										<div class="col-md-12"><img src="includes/pzen_template/images/brandslider.jpg" width="100%" height="auto" /></div>
									</div>
							</section>
							
							<section class="block">
								<header class="block-header">
									<h2 class="title"><?php echo PZEN_SECTITLE_BRAND_INFO_TEST; ?></h2>
								</header>
								<div class="block-content">
									<div class="rw">
										<label><?php echo PZEN_LABLE_BRANDSLIDER; ?></label>
										<div class="cont">
											<?php echo pzen_draw_yesnoradio('display_brands_slider','data-target="inner_sec_brdsldtest" class="innersec_action"'); ?>
											<?php 
												$brandsld_status=get_pzen_options('display_brands_slider');
												if($brandsld_status==''){$brandsld_status=0;}
											?>
										</div>
										<div class="row">
											<div id="inner_sec_brdsldtest" class="inner_section" style="<?php echo ($brandsld_status==0)? 'display:none;': ''; ?>">
												<div class="rw">
													<label><?php echo PZEN_LABLE_SELBELOWSTYLE; ?></label>
													<div class="rw_division">
														<?php 
														$brdsldtestinfo=get_pzen_options('brands_slider_style');
														if($brdsldtestinfo==''){$brdsldtestinfo="1";}
														?>
														<div class="inline-ul col-lg-12">
															<div class="col-md-4">
																<input type="radio" name="brands_slider_style" value="1" <?php echo ($brdsldtestinfo=='1')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_DISPLAY_STYLE_1; ?></span>
															</div>
															<div class="col-md-4">
																<input type="radio" name="brands_slider_style" value="2" <?php echo ($brdsldtestinfo=='2')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_DISPLAY_STYLE_2; ?></span>
															</div>
															<div class="col-md-4">
																<input type="radio" name="brands_slider_style" value="3" <?php echo ($brdsldtestinfo=='3')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_DISPLAY_STYLE_3; ?></span>
															</div>
														</div>
														<div class="rw">
															<div class="col-md-4"><img src="includes/pzen_template/images/brands_slider_style_1.png" width="100%" height="auto" /></div>
															<div class="col-md-4"><img src="includes/pzen_template/images/brands_slider_style_2.png" width="100%" height="auto" /></div>
															<div class="col-md-4"><img src="includes/pzen_template/images/brands_slider_style_3.jpg" width="100%" height="auto" /></div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="rw">
										<label><?php echo PZEN_DISPLAY_INFO_BOXES; ?></label>
										<div class="cont">
											<?php echo pzen_draw_yesnoradio('display_info_boxes','data-target="inner_sec_infobxstatus" class="innersec_action"'); ?>
											<?php 
												$infobx_status=get_pzen_options('display_brands_slider');
												if($infobx_status==''){$infobx_status=0;}
											?>
										</div>
										<div class="row">
											<div id="inner_sec_infobxstatus" class="inner_section" style="<?php echo ($infobx_status==0)? 'display:none;': ''; ?>">
												<div class="rw">
													<label><?php echo PZEN_LABLE_SELBELOWSTYLE; ?></label>
													<div class="rw_division">
														<?php 
														$infoboxes_style=get_pzen_options('infoboxes_style');
														if($infoboxes_style==''){$infoboxes_style="display_style_1";}
														?>
														<div class="inline-ul col-lg-12">
															<div class="col-md-4">
																<input type="radio" name="infoboxes_style" value="display_style_1" <?php echo ($infoboxes_style=='display_style_1')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_DISPLAY_STYLE_1; ?></span>
																<p class="notice"><?php echo PZEN_ONLY_3_COLUMN; ?></p>
															</div>
															<div class="col-md-4">
																<input type="radio" name="infoboxes_style" value="display_style_2" <?php echo ($infoboxes_style=='display_style_2')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_DISPLAY_STYLE_2; ?></span>
																<p class="notice"><?php echo PZEN_WITHSLIDER_UNLIMITEDCOLUMNS; ?></p>
															</div>
															<div class="col-md-4">
																<input type="radio" name="infoboxes_style" value="display_style_3" <?php echo ($infoboxes_style=='display_style_3')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_DISPLAY_STYLE_3; ?></span>
																<p class="notice"><?php echo PZEN_NOTICE_INFOBOX_NEWS_TESTI_SPLIT; ?></p>
															</div>
														</div>
														<div class="rw">
															<div class="col-md-4"><img src="includes/pzen_template/images/infoboxes_style_1.jpg" width="100%" height="auto" /></div>
															<div class="col-md-4"><img src="includes/pzen_template/images/infoboxes_style_2.jpg" width="100%" height="auto" /></div>
															<div class="col-md-4"><img src="includes/pzen_template/images/info_news_testi_split.jpg" width="100%" height="auto" /></div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="rw">
										<label><?php PZEN_LABEL_TESTIMONIALS; ?></label>
										<div class="row">
											<div id="inner_sec_testimonialsstatus" class="inner_section">
												<div class="rw">
													<label><?php echo PZEN_LABEL_DISTESTI_STYLE; ?></label>
													<div class="rw_division">
														<?php 
														$testimonial_style=get_pzen_options('testimonial_style');
														if($testimonial_style==''){$testimonial_style="1";}
														?>
														<div class="inline-ul col-lg-12">
															<div class="col-md-4">
																<input type="radio" name="testimonial_style" value="1" <?php echo ($testimonial_style=='1')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_DISPLAY_STYLE_1; ?></span>
															</div>
															<div class="col-md-4">
																<input type="radio" name="testimonial_style" value="2" <?php echo ($testimonial_style=='2')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_DISPLAY_STYLE_2; ?></span>
															</div>
															<div class="col-md-4">
																<input type="radio" name="testimonial_style" value="3" <?php echo ($testimonial_style=='3')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_DISPLAY_STYLE_3; ?></span>
																<p class="notice"><?php echo PZEN_NOTICE_INFOBOX_NEWS_TESTI_SPLIT; ?></p>
															</div>
														</div>
														<div class="rw">
															<div class="col-md-4"><img src="includes/pzen_template/images/test_style_1.png" width="100%" height="auto" /></div>
															<div class="col-md-4"><img src="includes/pzen_template/images/test_style_2.png" width="100%" height="auto" /></div>
															<div class="col-md-4"><img src="includes/pzen_template/images/info_news_testi_split.jpg" width="100%" height="auto" /></div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="rw">
										<label><?php echo PZEN_DISPLAY_TESTISTYLE_1; ?></label>
										<div class="cont">
											<input type="file" id="testibg_image" name="test_background_image" size="30">
											<?php if(get_pzen_options('test_background_image')!=''){ ?>
											<div class="file_content">
												<img src="<?php echo $uploads_path.get_pzen_options('test_background_image'); ?>" title="Image" />
											</div>
											<?php } ?>
										</div>
									</div>
								</div>
							</section>
						</div>
						<input type="hidden" name="frm_pzen_set_submit" value="" />
					</form>
                </div>
                <div id="view2" class="tab-content">
                    <h1 class="tab-header"><?php echo PZEN_TABHEAD_HEADER;?></h1>
					<form name='frm_pzen' action="<?php echo zen_href_link(FILENAME_PZENTEMPLATE, '', 'SSL'); ?>" method="post" enctype="multipart/form-data">
						<div class="sec_accordian">
							<section class="block">
								<header class="block-header">
									<h2 class="title"><?php echo PZEN_TITLE_HEADER; ?></h2>
								</header>
								<div class="block-content">
									<div class="rw">
										<label><?php echo PZEN_LABEL_HEADERSTYLE; ?></label>
										<div class="cont">
											<?php 
												$headerstyle=get_pzen_options('header_style');
												if($headerstyle==''){$headerstyle="header_style_1";}
											?>
											<ul class="inline-ul">
												<li><input type="radio" name="header_style" value="header_style_1" <?php echo ($headerstyle=='header_style_1')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_HEADER_STYLE_1; ?></span></li>
												<li><input type="radio" name="header_style" value="header_style_2" <?php echo ($headerstyle=='header_style_2')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_HEADER_STYLE_2; ?></span></li>
												<li><input type="radio" name="header_style" value="header_style_3" <?php echo ($headerstyle=='header_style_3')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_HEADER_STYLE_3; ?></span></li>
												<li><input type="radio" name="header_style" value="header_style_4" <?php echo ($headerstyle=='header_style_4')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_HEADER_STYLE_4; ?></span></li>
												<li><input type="radio" name="header_style" value="header_style_5" <?php echo ($headerstyle=='header_style_5')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_HEADER_STYLE_5; ?></span></li>
												<li><input type="radio" name="header_style" value="header_style_6" <?php echo ($headerstyle=='header_style_6')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_HEADER_STYLE_6; ?></span></li>
												<li><input type="radio" name="header_style" value="header_style_7" <?php echo ($headerstyle=='header_style_7')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_HEADER_STYLE_7; ?></span></li>
												<li><input type="radio" name="header_style" value="header_style_8" <?php echo ($headerstyle=='header_style_8')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_HEADER_STYLE_8; ?></span></li>
												<li><input type="radio" name="header_style" value="header_style_9" <?php echo ($headerstyle=='header_style_9')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_HEADER_STYLE_9; ?></span></li>
												<li><input type="radio" name="header_style" value="header_style_10" <?php echo ($headerstyle=='header_style_10')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_HEADER_STYLE_10; ?></span></li>
											</ul>
										</div>
									</div>
								</div>
							</section>
							<section class="block">
								<header class="block-header">
									<h2 class="title"><?php echo PZEN_TITLE_STORELOGOS; ?></h2>
								</header>
								<div class="block-content">
									<div class="rw">
										<label><?php echo PZEN_LABEL_LOGO; ?></label>
										<div class="cont">
											<input type="file" value="logo.png" id="file_logo" name="file_logo" size="30">
											<?php if(get_pzen_options('file_logo')!=''){ ?>
											<div class="file_content">
												<img src="<?php echo $uploads_path.get_pzen_options('file_logo'); ?>" title="Site Logo" />
											</div>
											<?php } ?>
										</div>
									</div>
									<div class="rw">
										<label><?php echo PZEN_LABEL_FAVICON; ?></label>
										<div class="cont">
											<input type="file" value="file_favicon.png" id="file_favicon" name="file_favicon" size="30">
											<?php if(get_pzen_options('file_favicon')!=''){ ?>
											<div class="file_content">
												<img src="<?php echo $uploads_path.get_pzen_options('file_favicon'); ?>"  title="Site Favicon Icon" />
											</div>
											<?php } ?>
										</div>
									</div>
								</div>
							 </section>
						</div>
						<input type="hidden" name="frm_pzen_set_submit" value="" />
					</form>
                </div>
                <div id="view3" class="tab-content">
                    <h1 class="tab-header"><?php echo PZEN_TABHEAD_FOOTER;?></h1>
					<div class="sec_accordian">
						<form name='frm_pzen' action="<?php echo zen_href_link(FILENAME_PZENTEMPLATE, '', 'SSL'); ?>" method="post" enctype="multipart/form-data">
							<section class="block">
								<header class="block-header">
									<h2 class="title"><?php echo PZEN_TITLE_FOOTERSETTINGS; ?></h2>
								</header>
								<div class="block-content">
									<div class="rw">
										<label><?php echo PZEN_LABEL_FOOTERSTYLE; ?></label>
										<div class="cont">
											<?php 
												$footerstyle=get_pzen_options('footer_style');
												if($footerstyle==''){$footerstyle="footer_style_1";}
											?>
											<ul class="inline-ul">
												<li><input type="radio" name="footer_style" value="footer_style_1" <?php echo ($footerstyle=='footer_style_1')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_FOOTER_STYLE_1; ?></span></li>
												<li><input type="radio" name="footer_style" value="footer_style_2" <?php echo ($footerstyle=='footer_style_2')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_FOOTER_STYLE_2; ?></span></li>
												<li><input type="radio" name="footer_style" value="footer_style_3" <?php echo ($footerstyle=='footer_style_3')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_FOOTER_STYLE_3; ?></span></li>
												<li><input type="radio" name="footer_style" value="footer_style_4" <?php echo ($footerstyle=='footer_style_4')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_FOOTER_STYLE_4; ?></span></li>
												<li><input type="radio" name="footer_style" value="footer_style_5" <?php echo ($footerstyle=='footer_style_5')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_FOOTER_STYLE_5; ?></span></li>
												<li><input type="radio" name="footer_style" value="footer_style_6" <?php echo ($footerstyle=='footer_style_6')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_FOOTER_STYLE_6; ?></span></li>
												<li><input type="radio" name="footer_style" value="footer_style_7" <?php echo ($footerstyle=='footer_style_7')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_FOOTER_STYLE_7; ?></span></li>
												<li><input type="radio" name="footer_style" value="footer_style_8" <?php echo ($footerstyle=='footer_style_8')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_FOOTER_STYLE_8; ?></span></li>
												<li><input type="radio" name="footer_style" value="footer_style_9" <?php echo ($footerstyle=='footer_style_9')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_FOOTER_STYLE_9; ?></span></li>
												<li><input type="radio" name="footer_style" value="footer_style_10" <?php echo ($footerstyle=='footer_style_10')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_FOOTER_STYLE_10; ?></span></li>
											</ul>
										</div>
									</div>
								</div>
							</section>
							<section class="block">
								<header class="block-header">
									<h2 class="title"><?php echo PZEN_TITLE_SOCIAL_LINKS; ?></h2>
								</header>
								<div class="block-content">
									<div class="rw">
										<label><?php echo PZEN_LABEL_FACEBOOK; ?></label>
										<div class="cont">
											<?php echo pzen_draw_inputbox('facebook_link'); ?>
											<p class="notice"><?php echo PZEN_NOTICE_FACEBOOK; ?></p>
										</div>
									</div>
									<div class="rw">
										<label><?php echo PZEN_LABEL_TWITTER; ?></label>
										<div class="cont">
											<?php echo pzen_draw_inputbox('twitter_link'); ?>
											<p class="notice"><?php echo PZEN_NOTICE_TWITTER; ?></p>
										</div>
									</div>
									<div class="rw">
										<label><?php echo PZEN_LABEL_PINTEREST; ?></label>
										<div class="cont">
											<?php echo pzen_draw_inputbox('pinterest_link'); ?>
											<p class="notice"><?php echo PZEN_NOTICE_PINTEREST; ?></p>
										</div>
									</div>
									<div class="rw">
										<label><?php echo PZEN_LABEL_GOOGLEPLUS; ?></label>
										<div class="cont">
											<?php echo pzen_draw_inputbox('google_link'); ?>
											<p class="notice"><?php echo PZEN_NOTICE_GOOGLEPLUS; ?></p>
										</div>
									</div>
									<div class="rw">
										<label><?php echo PZEN_LABEL_YOUTUBE; ?></label>
										<div class="cont">
											<?php echo pzen_draw_inputbox('youtube_link'); ?>
											<p class="notice"><?php echo PZEN_NOTICE_YOUTUBE; ?></p>
										</div>
									</div>
									<div class="rw">
										<label><?php echo PZEN_LABEL_INSTAGRAM; ?></label>
										<div class="cont">
											<?php echo pzen_draw_yesnoradio('display_instagram_feed'); ?>
											<p class="notice"><?php echo PZEN_NOTICE_INSTAGRAM; ?></p>
										</div>
										
									</div>
								</div>
							 </section>
							<section class="block">
								<header class="block-header">
									<h2 class="title"><?php echo PZEN_TITLE_PAYMENTMETHODS; ?></h2>
								</header>
								<div class="block-content">
									<div class="rw">
										<label><?php echo PZEN_LABEL_PAYMENTMETHODS_IMAGE; ?></label>
										<div class="cont">
											<input type="file" value="payment_image.png" id="payment_image" name="payment_image" size="30">
											<?php if(get_pzen_options('payment_image')!=''){ ?>
											<div class="file_content">
												<img src="<?php echo $uploads_path.get_pzen_options('payment_image'); ?>" title="Payment Image" />
											</div>
											<?php } ?>
										</div>
									</div>
								</div>
							</section>
							<section class="block">
								<header class="block-header">
									<h2 class="title"><?php echo PZEN_TITLE_COPYRIGHTS; ?></h2>
								</header>
								<div class="block-content">
									<div class="rw">
										<label><?php echo PZEN_LABEL_COPYRIGHTS; ?></label>
									   <div class="cont">
											<div class="cont"><?php echo pzen_draw_textarea('store_copyright'); ?></div>
										</div>
									</div>
								</div>
							</section>
						</div>
						<input type="hidden" name="frm_pzen_set_submit" value="" />
					</form>
                </div>
				<div id="view4"class="main-menu tab-content">
					<h1 class="tab-header"><?php echo PZEN_TABHEAD_MAINMENU;?></h1>
					<form name='frm_pzen' action="<?php echo zen_href_link(FILENAME_PZENTEMPLATE, '', 'SSL'); ?>" method="post" enctype="multipart/form-data">
						<section class="block-static single-block">
								<header class="block-header">
									<h2 class="title"><?php echo PZEN_TITLE_MAINMENU; ?></h2>
								</header>
								<div class="block-content">
									<div class="row">
										<label><?php echo PZEN_LABEL_MAINMENU; ?></label>
										<div class="cont">
											<?php 
												$menutype=get_pzen_options('menu_type');
												if($menutype==''){$menutype=1;}
											?>
											<ul class="inline-ul">
												<li><input type="radio" name="menu_type" value="1" <?php echo ($menutype==1)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_SIMPLE_MENU; ?></span></li>
												<li><input type="radio" name="menu_type" value="2" <?php echo ($menutype==2)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_MEGA_MENU; ?></span></li>
											</ul>
										</div>
									</div>
								</div>
						</section>
						<div class="sec_accordian">
						<?php 
							global $languages_id, $db;
							$cat_array = array();
							$categories_query = "select c.categories_id, cd.categories_name, c.parent_id
															from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
															where c.categories_id = cd.categories_id
															and c.categories_status=1 " .
															" and cd.language_id = '" . (int)$_SESSION['languages_id'] . "' " .
															" order by c.parent_id, c.sort_order, cd.categories_name";
							$categories = $db->Execute($categories_query);
							while (!$categories->EOF) {
								$cat_array[$categories->fields['parent_id']][$categories->fields['categories_id']] = array('name' => $categories->fields['categories_name'], 'count' => 0);
								$categories->MoveNext();
							}
						?>
						<?php foreach($cat_array[0] as $k0=>$v0){ ?>
							<section class="block">
								<header class="block-header">
									<h2 class="title"><?php echo $v0['name']; ?></h2>
								</header>
								<div class="block-content">
									<div class="row">
										<label><?php echo PZEN_LABEL_BADGE; ?></label>
										<div class="cont">
											<?php 
												$badge_type=get_pzen_options('badge_type_'.$k0);
												if($badge_type==''){$badge_type=0;}
											?>
											<ul class="inline-ul">
												<li><input type="radio" name="badge_type_<?php echo $k0; ?>" value="1" <?php echo ($badge_type==1)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_NEW; ?></span></li>
												<li><input type="radio" name="badge_type_<?php echo $k0; ?>" value="2" <?php echo ($badge_type==2)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_SALE; ?></span></li>
												<li><input type="radio" name="badge_type_<?php echo $k0; ?>" value="0" <?php echo ($badge_type==0)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_NONE; ?></span></li>
											</ul>
										</div>
									</div>
									<?php /*
									<div class="row">
										<label><?php echo PZEN_LABEL_; ?>Subcategory Display Mark :</label>
										<div class="cont"><?php echo pzen_draw_yesnoradio('subcat_marked_'.$k0); ?></div>
									</div> */?>
									<div class="row">
										<label><?php echo PZEN_LABEL_SUBCATEGORY_IMAGE; ?></label>
										<div class="cont"><?php echo pzen_draw_yesnoradio('subcat_imgstatus_'.$k0); ?></div>
									</div>
									<div class="row">
										<label><?php echo PZEN_LABEL_MEGAMENU_SLIDE_BLOCK; ?></label>
										<div class="cont">
											<?php 
												$mg_blk_type=get_pzen_options('megamenu_btype_'.$k0);
												if($mg_blk_type==''){$mg_blk_type=0;}
											?>
											<ul class="inline-ul">
												<li><input class="innersec_action" type="radio" name="megamenu_btype_<?php echo $k0; ?>" value="1" data-target="inner_sec_sdblk_<?php echo $k0; ?>" <?php echo ($mg_blk_type==1)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_SPECIAL; ?></span></li>
												<li><input class="innersec_action" type="radio" name="megamenu_btype_<?php echo $k0; ?>" value="2" data-target="inner_sec_sdblk_<?php echo $k0; ?>" <?php echo ($mg_blk_type==2)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_FEATURED; ?></span></li>
												<li><input class="innersec_action" type="radio" name="megamenu_btype_<?php echo $k0; ?>" value="0" data-target="inner_sec_sdblk_<?php echo $k0; ?>" <?php echo ($mg_blk_type==0)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_NONE; ?></span></li>
											</ul>
											<div id="inner_sec_sdblk_<?php echo $k0; ?>" class="inner_section" style="<?php echo ($mg_blk_type==0)? 'display:none;': ''; ?>">
												<div class="noborder">
													<p class="notice"><?php echo PZEN_NOTICE_MEGAMENU_SLIDE_BLOCK; ?></p>
												</div>
												<?php 
													$mg_blk_type_view=get_pzen_options('megamenu_btype_view_'.$k0);
													if($mg_blk_type_view==''){$mg_blk_type_view=2;}
												?>
												<ul class="inline-ul">
													<li><input type="radio" name="megamenu_btype_view_<?php echo $k0; ?>" value="1" <?php echo ($mg_blk_type_view==1)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_DISPLAY_SLIDER; ?></span></li>
													<li><input type="radio" name="megamenu_btype_view_<?php echo $k0; ?>" value="2" <?php echo ($mg_blk_type_view==2)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_DISPLAY_WITHOUT_SLIDER; ?></span></li>
												</ul>
											</div>
										</div>
									</div>
									<div class="row">
										<label><?php echo PZEN_LABEL_MEGAMENU_BOTTOM_BLOCK; ?></label>
										<div class="cont">
											<?php echo pzen_draw_yesnoradio('megamenu_bottom_block_'.$k0,'data-target="inner_sec_botblk_'.$k0.'" class="innersec_action"'); ?>
											<?php 
													$mb_bt_block=get_pzen_options('megamenu_bottom_block_'.$k0);
													if($mb_bt_block==''){$mb_bt_block=0;}
												?>
											<div id="inner_sec_botblk_<?php echo $k0; ?>" class="inner_section" style="<?php echo ($mb_bt_block==0)? 'display:none;': ''; ?>">
												<div class="rw">
													<label><?php echo PZEN_LABEL_BANNER_CONTENT; ?></label>
													<div class="cont">
														<div class="rw_division">
															<div class="rw">
																<label><?php echo PZEN_LABEL_IMAGE; ?></label>
																<input type="file" value="" id="" name="mg_botban_cont_0_<?php echo $k0; ?>_img" size="30">
																<?php if(get_pzen_options('mg_botban_cont_0_'.$k0.'_img')!=''){ ?>
																<div class="file_content">
																	<img src="<?php echo $uploads_path.get_pzen_options('mg_botban_cont_0_'.$k0.'_img'); ?>" height="auto" width="auto" title="Image" />
																</div>
																<?php } ?>
															</div>
															<div class="rw">
																<label><?php echo PZEN_LABEL_LINK; ?></label>
																<?php echo pzen_draw_inputbox('mg_botban_cont_0_'.$k0.'_link'); ?>
															</div>
														</div>
														<div class="rw_division">
															<div class="rw">
																<label><?php echo PZEN_LABEL_IMAGE; ?></label>
																<input type="file" value="" id="" name="mg_botban_cont_1_<?php echo $k0; ?>_img" size="30">
																<?php if(get_pzen_options('mg_botban_cont_1_'.$k0.'_img')!=''){ ?>
																<div class="file_content">
																	<img src="<?php echo $uploads_path.get_pzen_options('mg_botban_cont_1_'.$k0.'_img'); ?>" height="auto" width="auto" title="Image" />
																</div>
																<?php } ?>
															</div>
															<div class="rw">
																<label><?php echo PZEN_LABEL_LINK; ?></label>
																<?php echo pzen_draw_inputbox('mg_botban_cont_1_'.$k0.'_link'); ?>
															</div>
														</div>
														
												</div>
											</div>
										</div>
									</div>
							</section>
						<?php } ?>
						</div>
						<input type="hidden" name="frm_pzen_set_submit" value="" />
					</form>
                </div>
                <div id="view10"class="tab-content">
						<?php require('pzen_slider.php'); ?> 
                </div>
				<div id="view12"class="topbanner_slider tab-content">
					<?php 
						require('pzen_topbanner.php');
					?>
                </div>
				<div id="view13"class="middlebanner_content tab-content">
                    <h1 class="tab-header"><?php echo PZEN_TABHEAD_MIDDLEBANNER;?></h1>
					<form name='frm_pzen' action="<?php echo zen_href_link(FILENAME_PZENTEMPLATE, '', 'SSL'); ?>" method="post" enctype="multipart/form-data">
						<div class="sec_accordian">
							<section class="block">
								<header class="block-header">
									<h2 class="title"><?php echo PZEN_TITLE_MIDDLEBANNER; ?></h2>
								</header>
								<div class="block-content">
									<div class="rw">
										<label><?php echo PZEN_LABEL_MIDDLEBANNER; ?></label>
										<div class="cont">
											<?php echo pzen_draw_yesnoradio('display_middle_banner','data-target="inner_sec_midbannerstatus" class="innersec_action"'); ?>
											<?php 
												$midbanner_status=get_pzen_options('display_middle_banner');
												if($midbanner_status==''){$midbanner_status=0;}
											?>
										</div>
										<div class="row">
											<div id="inner_sec_midbannerstatus" class="inner_section" style="<?php echo ($midbanner_status==0)? 'display:none;': ''; ?>">
												<div class="rw">
													<label><?php echo PZEN_LABEL_MIDDLEBANNER_SECTION; ?></label>
													<div class="rw_division">
														<div class="rw">
															<strong class="col-md-3"><?php echo PZEN_LABEL_IMAGE; ?></strong>
															<div class="col-md-9">
																<input type="file" id="middle_banner_image" name="middle_banner_image" size="30">
																<?php if(get_pzen_options('middle_banner_image')!=''){ ?>
																<div class="file_content">
																	<img src="<?php echo $uploads_path.get_pzen_options('middle_banner_image'); ?>" title="Image" />
																</div>
																<?php } ?>
															</div>
														</div>
														<div class="rw">&nbsp;</div>
														<div class="rw">
															<strong class="col-md-3"><?php echo PZEN_LABEL_CONTENT; ?></strong>
															<div class="col-md-9">
																<?php echo pzen_draw_langtextarea('middle_banner_caption'); ?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</section>
						</div>
						<input type="hidden" name="frm_pzen_set_submit" value="" />
					</form>
                </div>
				<div id="view14"class="bottombanner_slider tab-content">
					<?php 
						require('pzen_bottombanner.php');
					?> 
                </div>
				<div id="view20"class="sidebarbanner_slider tab-content">
					<?php 
						require('pzen_sidebarbanner.php');
					?> 
                </div>
				<div id="view15" class="tab-content">
                    <h1 class="tab-header"><?php echo PZEN_TABHEAD_INDEXPAGE;?></h1>
					<form name='frm_pzen' action="<?php echo zen_href_link(FILENAME_PZENTEMPLATE, '', 'SSL'); ?>" method="post" enctype="multipart/form-data">
						<input type="hidden" name="frm_pzen_set_submit" value="" />
						<div class="sec_accordian">
							<section class="block">
								<header class="block-header">
									<h2 class="title"><?php echo PZEN_TITLE_INDEXPAGE; ?></h2>
								</header>
								<div class="block-content">
									<div class="rw">
										<label><?php echo PZEN_LABEL_INDEXPAGE_LAYOUT; ?></label>
										<div class="cont">
											<?php 
												$maincatstyle=get_pzen_options('main_categories_style');
												if($maincatstyle==''){$maincatstyle="default";}
											?>
											<ul class="inline-ul">
												<li><input type="radio" name="main_categories_style" value="default" <?php echo ($maincatstyle=='default')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_DEFAULE_WITH_CATEGORYIMAGE; ?></span></li>
												<li><input type="radio" name="main_categories_style" value="custom" <?php echo ($maincatstyle=='custom')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_CUSTOMVIEW_WITH_ICONS; ?></span></li>
											</ul>
										</div>
									</div>
								</div>
							</section>
							<section class="block">
								<header class="block-header">
									<h2 class="title"><?php echo PZEN_TITLE_CATEGORY_PRODSEC; ?></h2>
								</header>
								<div class="block-content">
									<div class="row">
										<label><?php echo PZEN_LABEL_CATEGORY_PROD_SEC; ?></label>
										<div class="cont"><?php echo pzen_draw_yesnoradio('display_category'); ?></div>
									</div>
									<div class="row">
										<div class="inner_section">
											<div class="rw">
												<label><?php echo PZEN_LABEL_CATEGORY_SEL_STYLE; ?></label>
												<div class="rw_division">
													<?php 
													$display_category_style=get_pzen_options('display_category_style');
													if($display_category_style==''){$display_category_style="display_style_1";}
													?>
													<div class="inline-ul col-lg-12">
														<div class="col-md-6"><input type="radio" name="display_category_style" value="display_style_1" <?php echo ($display_category_style=='display_style_1')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_DISPLAY_STYLE_1; ?></span></div>
														<div class="col-md-6"><input type="radio" name="display_category_style" value="display_style_2" <?php echo ($display_category_style=='display_style_2')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_DISPLAYSTYLE_WITH_BANNERSLIDERS; ?></span></div>
													</div>
													<div class="rw">&nbsp;</div>
													<div class="col-lg-12">
														<div class="col-md-6"><img src="includes/pzen_template/images/category_style_1.png" width="100%" height="auto" /></div>
														<div class="col-md-6"><img src="includes/pzen_template/images/category_style_2.png" width="100%" height="auto" /></div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="rw">
										<label><?php echo PZEN_LABEL_CATEGORY_IDS; ?></label>
										<div class="cont">
											<div class="inner_section">
												<div class="rw">
													<div class="col-md-6">
														<strong><?php echo PZEN_LABEL_CATEGORY_1; ?></strong>
														<?php 
															$featured_category_1=get_pzen_options("featured_category_1");
															echo pzen_generate_categories_pull_down("featured_category_1",$featured_category_1);
														?>
													</div>
													<div class="col-md-6">
														<strong><?php echo PZEN_LABEL_CATEGORY_2; ?></strong>
														<?php 
															$featured_category_2=get_pzen_options("featured_category_2");
															echo pzen_generate_categories_pull_down("featured_category_2",$featured_category_2);
														?>
													</div>
												</div>
											</div>
											<?php //echo pzen_draw_inputbox('featured_category'); ?>
											<p class="notice"><?php echo PZEN_NOTICE_CAEGORY_IDS; ?></p> 
										</div>
									</div>
									<div class="row">
										<div class="inner_section">
											<div class="rw">
												<label><?php echo PZEN_LABEL_ONLYFOR_DISPLAY_STYLE_2; ?></label>
												<div class="col-md-6">
													<div class="rw_division">
														<div class="col-md-12"><strong><?php echo PZEN_SEL_CAT_BANNER1; ?></strong></div>
														<div class="col-md-12">&nbsp;</div>
														<div class="col-md-12">	
															<input type="file" id="category_banner_1" name="category_banner_1" size="30">
															<?php if(get_pzen_options('category_banner_1')!=''){ ?>
															<div class="file_content">
																<img src="<?php echo $uploads_path.get_pzen_options('category_banner_1'); ?>" title="Image" />
															</div>
															<?php } ?>
														</div>
														<div class="col-md-12">&nbsp;</div>
														<div class="col-md-12"><strong><?php echo PZEN_ADD_BANNER_CAPTION; ?></strong></div>
														<div class="col-md-12">&nbsp;</div>
														<div class="col-md-11">	
															<?php echo pzen_draw_langtextarea('category_caption_1','','30','6'); ?>
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="rw_division">
														<div class="col-md-12"><strong><?php echo PZEN_SEL_CAT_BANNER2; ?></strong></div>
														<div class="col-md-12">&nbsp;</div>
														<div class="col-md-12">	
															<input type="file" id="category_banner_2" name="category_banner_2" size="30">
															<?php if(get_pzen_options('category_banner_2')!=''){ ?>
															<div class="file_content">
																<img src="<?php echo $uploads_path.get_pzen_options('category_banner_2'); ?>" title="Image" />
															</div>
															<?php } ?>
														</div>
														<div class="col-md-12">&nbsp;</div>
														<div class="col-md-12"><strong><?php echo PZEN_ADD_BANNER_CAPTION; ?></strong></div>
														<div class="col-md-12">&nbsp;</div>
														<div class="col-md-11">	
															<?php echo pzen_draw_langtextarea('category_caption_2','','30','6'); ?>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</section>
							<section class="block">
								<header class="block-header">
									<h2 class="title"><?php echo PZEN_TITLE_PROD_DISPLAY_STYLE; ?></h2>
								</header>
								<div class="block-content">
									<div class="rw">
										<label><?php echo PZEN_LABEL_NEW_PRODS; ?></label>
										<div class="cont">
											<?php 
												$nprodstyle=get_pzen_options('nproducts_display_style');
												if($nprodstyle==''){$nprodstyle="default";}
											?>
											<ul class="inline-ul">
												<li><input type="radio" name="nproducts_display_style" value="default" <?php echo ($nprodstyle=='default')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_DEFAULT_GRID_VIEW; ?></span></li>
												<li><input type="radio" name="nproducts_display_style" value="slider" <?php echo ($nprodstyle=='slider')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_SLIDER_VIEW; ?></span></li>
												<li><input type="radio" name="nproducts_display_style" value="tabs" <?php echo ($nprodstyle=='tabs')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_TABS_VIEW; ?></span></li>
											</ul>
										</div>
									</div>
									<div class="rw">
										<label><?php echo PZEN_LABEL_SPECIAL_PRODS; ?></label>
										<div class="cont">
											<?php 
												$spprodstyle=get_pzen_options('sproducts_display_style');
												if($spprodstyle==''){$spprodstyle="default";}
											?>
											<ul class="inline-ul">
												<li><input type="radio" name="sproducts_display_style" value="default" <?php echo ($spprodstyle=='default')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_DEFAULT_GRID_VIEW; ?></span></li>
												<li><input type="radio" name="sproducts_display_style" value="slider" <?php echo ($spprodstyle=='slider')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_SLIDER_VIEW; ?></span></li>
												<li><input type="radio" name="sproducts_display_style" value="tabs" <?php echo ($spprodstyle=='tabs')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_TABS_VIEW; ?></span></li>
											</ul>
										</div>
									</div>
									<div class="rw">
										<label><?php echo PZEN_LABEL_FEATURED_PRODS; ?></label>
										<div class="cont">
											<?php 
												$fpprodstyle=get_pzen_options('fproducts_display_style');
												if($fpprodstyle==''){$fpprodstyle="default";}
											?>
											<ul class="inline-ul">
												<li><input type="radio" name="fproducts_display_style" value="default" <?php echo ($fpprodstyle=='default')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_DEFAULT_GRID_VIEW; ?></span></li>
												<li><input type="radio" name="fproducts_display_style" value="slider" <?php echo ($fpprodstyle=='slider')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_SLIDER_VIEW; ?></span></li>
												<li><input type="radio" name="fproducts_display_style" value="tabs" <?php echo ($fpprodstyle=='tabs')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_TABS_VIEW; ?></span></li>
											</ul>
										</div>
									</div>
									<div class="rw">
										<label><?php echo PZEN_LABEL_BESTSELL_PRODS; ?></label>
										<div class="cont">
											<?php 
												$bspprodstyle=get_pzen_options('bproducts_display_style');
												if($bspprodstyle==''){$bspprodstyle="default";}
											?>
											<ul class="inline-ul">
												<li><input type="radio" name="bproducts_display_style" value="default" <?php echo ($bspprodstyle=='default')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_DEFAULT_GRID_VIEW; ?></span></li>
												<li><input type="radio" name="bproducts_display_style" value="slider" <?php echo ($bspprodstyle=='slider')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_SLIDER_VIEW; ?></span></li>
												<li><input type="radio" name="bproducts_display_style" value="tabs" <?php echo ($bspprodstyle=='tabs')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_TABS_VIEW; ?></span></li>
											</ul>
										</div>
									</div>
									<div class="rw">
										<label><?php echo PZEN_LABEL_FEASPE_STYLE; ?></label>
										<div class="cont">
											<?php 
												$safdrodstyle=get_pzen_options('saf_display_style');
												if($safdrodstyle==''){$safdrodstyle="default";}
											?>
											<ul class="inline-ul">
												<li><input type="radio" name="saf_display_style" value="default" <?php echo ($safdrodstyle=='default')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_DEFAULT_FULLWIDTH; ?></span></li>
												<li><input type="radio" name="saf_display_style" value="split" <?php echo ($safdrodstyle=='split')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_SPLIT_VIEW; ?></span></li>
											</ul>
										</div>
									</div>
									<div class="rw">
									   <div class="inner_section">
											<div class="rw">
												<label><?php echo PZEN_LABEL_BORDER_PROD_HOMEPAGE; ?></label>
												<div class="cont">
													<div class="rw_division">
														<div class="rw">
															<label><?php echo PZEN_LABEL_BORDERWIDTH; ?></label>
															<div class="cont">
																<?php echo pzen_draw_inputbox('border_width'); ?>
																<p class="notice"><?php echo PZEN_NOTICE_BORDERWIDTH; ?> </p>
															</div>
														</div>
														<div class="rw">&nbsp;</div>
														<div class="rw">
															<label><?php echo PZEN_LABEL_BORDERCOLOR; ?></label>
															<div class="cont">
																<?php echo pzen_draw_color_inputbox('border_color'); ?>
																<p class="notice"><?php echo PZEN_NOTICE_BORDERCOLOR; ?></p>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</section>
						</div>
					</form>
                </div>
				<div id="view16" class="tab-content">
                    <h1 class="tab-header"><?php echo PZEN_TABHEAD_NEWSBOX;?></h1>
					<form name='frm_pzen' action="<?php echo zen_href_link(FILENAME_PZENTEMPLATE, '', 'SSL'); ?>" method="post" enctype="multipart/form-data">
						<section class="block-static single-block">
							<header class="block-header">
								<h2 class="title"><?php echo PZEN_LABLE_NEWSSETTINGS; ?></h2>
							</header>
							<div class="block-content">
								<div class="rw">
									<label><?php echo PZEN_LABLE_NEWSSTYLE; ?></label>
									<div class="rw_division">
										<?php 
										$newsbox_style=get_pzen_options('newsbox_style');
										if($newsbox_style==''){$newsbox_style="1";}
										?>
										<div class="inline-ul col-lg-12">
											<div class="col-md-6">
												<input type="radio" name="newsbox_style" value="1" <?php echo ($newsbox_style=='1')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_DISPLAY_STYLE_1; ?></span>
												<p class="notice"><?php echo PZEN_NOTICE_NEWSBOX_IMG1; ?></p>
											</div>
											<div class="col-md-6">
												<input type="radio" name="newsbox_style" value="2" <?php echo ($newsbox_style=='2')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_DISPLAY_STYLE_2; ?></span>
												<p class="notice"><?php echo PZEN_NOTICE_INFOBOX_NEWS_TESTI_SPLIT; ?></p>
											</div>
										</div>
										<div class="rw">
											<div class="col-md-6"><img src="includes/pzen_template/images/news-slider.jpg" width="100%" height="auto" /></div>
											<div class="col-md-6"><img src="includes/pzen_template/images/info_news_testi_split.jpg" width="100%" height="auto" /></div>
										</div>
									</div>
								</div>
								<div class="rw">
									<label><?php echo PZEN_LABEL_PARALLEX_IMAGE_STATUS; ?> :</label>
									<div class="cont">
										<?php 
											$newscont_perallax_image_status=get_pzen_options('newscont_perallax_image_status');
											if($newscont_perallax_image_status==''){$newscont_perallax_image_status=1;}
										?>
										<ul class="inline-ul">
											<li><input type="radio" class="lnk_action" data-tarlnk="inner_sec_newsparalaximgstatus" data-target="inner_sec_newsparalaximg_status" name="newscont_perallax_image_status" value="1" <?php echo ($newscont_perallax_image_status==1)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_YES; ?></span></li>
											<li><input type="radio" class="lnk_action" data-tarlnk="inner_sec_newsparalaximgstatus" name="newscont_perallax_image_status" value="0" <?php echo ($newscont_perallax_image_status==0)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_NO; ?></span></li>
										</ul>
									</div>
								</div>
								<div class="rw">
									<div id="inner_sec_newsparalaximg_status" class="inner_sec_newsparalaximgstatus" style="<?php echo ($newscont_perallax_image_status==0)? 'display:none;' : ''; ?>">
										<div class="rw">
											<label><?php echo PZEN_LABLE_NEWSCONTENT_BGIMG; ?></label>
											<div class="cont">
												<input type="file" id="newscont_perallax_image" name="newscont_perallax_image" size="30">
												<?php if(get_pzen_options('newscont_perallax_image')!=''){ ?>
												<div class="file_content">
													<img src="<?php echo $uploads_path.get_pzen_options('newscont_perallax_image'); ?>" title="Image" />
												</div>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</section>
						<section class="block-static">
							<header class="block-header">
								<h2 class="title"><?php echo PZEN_TITLE_NEWSBOX; ?></h2>
							</header>
							<div class="block-content">
								<div class="rw">
									<label><?php echo PZEN_LABEL_NEWSBOX; ?></label>
									<div class="cont">
										<?php 
											$box_news_query = "select bnc.news_title, bnc.box_news_id as boxnews_content_id, bnc.languages_id, bn.news_status
														   from (" . TABLE_BOX_NEWS_CONTENT . " bnc
														   left join " . TABLE_BOX_NEWS . " bn on bnc.box_news_id = bn.box_news_id )
														   where bnc.box_news_id = bn.box_news_id
														   and bn.news_status = '1'";
											$languages = zen_get_languages();
											$box_news_query_result = $db->Execute($box_news_query);
										?>
										<select id="news_id" name="news_id">
											<?php 
												while(!$box_news_query_result->EOF) {
													for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
														if($languages[$i]['id']==$box_news_query_result->fields['languages_id']){
															$box_news_id = $box_news_query_result->fields['boxnews_content_id'];
															$news_title = $box_news_query_result->fields['news_title'];
														?>
														<option name="news_id" value="<?php echo $box_news_id.'-'.$box_news_query_result->fields['languages_id']; ?>"><?php echo $news_title; ?> (<?php echo $languages[$i]['code']; ?>)</option>
														<?php 
														}
													}
												$box_news_query_result->MoveNext(); 
											} ?>
										</select>
									</div>
								</div>
								<div class="rw">
									<label><?php echo PZEN_LABEL_SELIMAGE; ?></label>
									<div class="cont">
										<input type="file" id="news_image" name="news_image" size="30">
									</div>
								</div>
								<p class="notice"><?php echo PZEN_NOTICE_NEWSBOX; ?></p>
								<div class="rw">
									<div class="col-md-6">
										<p class="notice"><?php echo PZEN_NOTICE_NEWSBOX_IMG1; ?></p>
										<img src="includes/pzen_template/images/news-slider.jpg" width="100%" height="auto" />
									</div>
									<div class="col-md-6">
										<p class="notice"><?php echo PZEN_NOTICE_NEWSBOX_IMG2; ?></p>
										<img src="includes/pzen_template/images/news-detail.jpg" width="100%" height="auto" />
									</div>
								</div>
							</div>
						</section>
						<input type="hidden" name="frm_pzen_set_submit" value="" />
					</form>
				</div>
				<div id="view19" class="tab-content">
                    <h1 class="tab-header"><?php echo PZEN_TABHEAD_PRODUCTLIST_SETTINGS;?></h1>
					<form name='frm_pzen' action="<?php echo zen_href_link(FILENAME_PZENTEMPLATE, '', 'SSL'); ?>" method="post" enctype="multipart/form-data">
						<div class="sec_accordian">
							<section class="block">
								<header class="block-header">
									<h2 class="title"><?php echo PZEN_TABHEAD_PRODUCTLISTPAGE_IMAGE; ?></h2>
								</header>
								<div class="block-content">
									<div class="rw">
										<label><?php echo PZEN_LABEL_PRODUCTIMAGE_LAYOUT; ?> :</label>
										<div class="cont">
											<?php 
												$prodlistview_image_layout=get_pzen_options('prodlistview_image_layout');
												if($prodlistview_image_layout==''){$prodlistview_image_layout=1;}
											?>
											<ul class="inline-ul">
												<li><input type="radio" name="prodlistview_image_layout" value="1" <?php echo ($prodlistview_image_layout==1)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_BIG_SIZE; ?></span></li>
												<li><input type="radio" name="prodlistview_image_layout" value="2" <?php echo ($prodlistview_image_layout==2)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_SMALL_SIZE; ?></span></li>
											</ul>
										</div>
									</div>
									<div class="rw">
										<label><?php echo PZEN_LABEL_PRODUCTIMAGE_EFFECT; ?> :</label>
										<div class="cont">
											<?php 
												$prodlist_image_effects=get_pzen_options('prodlist_image_effects');
												if($prodlist_image_effects==''){$prodlist_image_effects=1;}
											?>
											<ul class="inline-ul">
												<li><input type="radio" name="prodlist_image_effects" value="1" <?php echo ($prodlist_image_effects==1)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_DEFAULT; ?></span></li>
												<li><input type="radio" name="prodlist_image_effects" value="2" <?php echo ($prodlist_image_effects==2)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_ZOOM_EFFECT; ?></span></li>
											</ul>
										</div>
									</div>
								</div>
							</section>
						</div>
						<input type="hidden" name="frm_pzen_set_submit" value="" />
					</form>
                </div>
				<div id="view18" class="tab-content">
                    <h1 class="tab-header"><?php echo PZEN_TABHEAD_PRODUCTINFO_SETTINGS;?></h1>
					<form name='frm_pzen' action="<?php echo zen_href_link(FILENAME_PZENTEMPLATE, '', 'SSL'); ?>" method="post" enctype="multipart/form-data">
						<div class="sec_accordian">
							<section class="block">
								<header class="block-header">
									<h2 class="title"><?php echo PZEN_TABHEAD_PRODUCT_IMAGE; ?></h2>
								</header>
								<div class="block-content">
									<div class="rw">
										<label><?php echo PZEN_LABEL_PRODUCTIMAGE_LAYOUT; ?> :</label>
										<div class="cont">
											<?php 
												$prodinfo_image_layout=get_pzen_options('prodinfo_image_layout');
												if($prodinfo_image_layout==''){$prodinfo_image_layout=1;}
											?>
											<ul class="inline-ul">
												<li><input type="radio" name="prodinfo_image_layout" value="1" <?php echo ($prodinfo_image_layout==1)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_BIG_SIZE; ?></span></li>
												<li><input type="radio" name="prodinfo_image_layout" value="2" <?php echo ($prodinfo_image_layout==2)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_SMALL_SIZE; ?></span></li>
											</ul>
										</div>
									</div>
									<div class="rw">
										<label><?php echo PZEN_LABEL_PRODUCTIMAGE_EFFECT; ?> :</label>
										<div class="cont">
											<?php 
												$prodinfo_image_effects=get_pzen_options('prodinfo_image_effects');
												if($prodinfo_image_effects==''){$prodinfo_image_effects=1;}
											?>
											<ul class="inline-ul">
												<li><input type="radio" name="prodinfo_image_effects" value="1" <?php echo ($prodinfo_image_effects==1)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_ZOOM_EFFECT; ?></span></li>
												<li><input type="radio" name="prodinfo_image_effects" value="2" <?php echo ($prodinfo_image_effects==2)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_LIGHTBOX_EFFECT; ?></span></li>
											</ul>
										</div>
									</div>
								</div>
							</section>
						</div>
						<input type="hidden" name="frm_pzen_set_submit" value="" />
					</form>
                </div>
            </div>
        </div>
        <footer>
			<?php if((!isset($_GET['botbeid'])) && (!isset($_GET['beid'])) && (!isset($_GET['slideshow_eid'])) && (!isset($_GET['action']))){ ?>
				<input type="button" class="md-btn pzen_save_settings" name="frm_pzen_set_submit" value="<?php echo PZEN_SAVE_SETTINGS; ?>" />
			<?php } ?>
			<br/><br/>
			<div class="alert alert-danger">
            	<strong>Kindly Note : </strong>For any CSS changes in the template, please add your custom CSS in <strong>stylesheet_user_customcss.css</strong> file, which can be found under <strong>includes\templates\yourstore\css</strong> directory. Changes done in any other template defined CSS files may lost in future theme updates.
            </div>
        </footer>
   	 </div>
	</div>
</section>
<script>
	$(document).ready(function(){
		$(".pzen_save_settings").click(function(){
			$('.tab-content[style="display: block;"]').find('form[name="frm_pzen"]').submit();
		});
	});
</script>
<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<script src="includes/pzen_template/js/jquery-ui.js" type="text/javascript"></script>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
<?php ob_flush(); ?>