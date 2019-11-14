<?php 
##PZENTEMPLATE_BRAND##

global $db;
global $template_dir, $messageStack; 

/************************************************************************************
******************************** Insert Item *******************************************
************************************************************************************/
if(isset($_REQUEST['submit_pzen_banner']))
{
	$item_desc_ar = zen_db_prepare_input($_POST['item_desc']);
	$item_type = zen_db_prepare_input($_POST['item_type']);
	$item_status = zen_db_prepare_input($_POST['item_status']);
	$image_name = zen_db_prepare_input($_FILES['item_image']['name']);
	$item_link = zen_db_prepare_input($_POST['item_link']);
	$sres=$db->Execute("SELECT MAX(sort_order) as maxid FROM ". TABLE_PZEN_TOPBANNER." where item_type=".$item_type) or die(mysql_error());
	$maxid=$sres->fields['maxid']+1;
	if(!is_dir("../includes/templates/" . $template_dir . "/images/banners/"))
	{
		mkdir("../includes/templates/" . $template_dir . "/images/banners/");
	}
	if($image_name!='')
	{
	   $ext = pathinfo($image_name, PATHINFO_EXTENSION);
	   $onlyname=str_replace('.'.$ext,'',$image_name);
	   $prod_image= $onlyname.'_'.$time.".".$ext;
	   move_uploaded_file($_FILES['item_image']['tmp_name'],"../includes/templates/" . $template_dir . "/images/banners/" .$prod_image);
	}
	else
	{
		 $prod_image='';
	}
	
	$sql_data_array = array(
					'sort_order' =>  $maxid,
					'item_type' => 	zen_db_prepare_input($item_type),
					'item_image' => zen_db_prepare_input($prod_image),
					'item_link' =>  zen_db_prepare_input($item_link),
					'item_desc' =>  base64_encode(serialize($item_desc_ar)),
					'item_status' => $item_status);
					
	zen_db_perform(TABLE_PZEN_TOPBANNER, $sql_data_array);
	$messageStack->add_session(PZEN_SUCCESS_ITEM_INSERTED, 'success');
	zen_redirect(zen_href_link(FILENAME_PZENTEMPLATE.".php",'','SSL'));
}

/************************************************************************************
******************************** Update Item *******************************************
************************************************************************************/ 
if(isset($_REQUEST['update_pzen_banner']))
{
	$item_desc_ar = zen_db_prepare_input($_POST['item_desc']);
	$item_status = zen_db_prepare_input($_POST['item_status']);
	$item_type = zen_db_prepare_input($_POST['item_type']);
	$item_link = zen_db_prepare_input($_POST['item_link']);
	$image_name = zen_db_prepare_input($_FILES['item_image']['name']);
	$sort_order = zen_db_prepare_input($_POST['sort_order']);
	$beid=$_REQUEST['beid'];
	$sres=$db->Execute("SELECT MAX(sort_order) as maxid, item_image FROM ".TABLE_PZEN_TOPBANNER." where id='".(int)$beid."'") or die(mysql_error());
	if(!is_dir("../includes/templates/" . $template_dir . "/images/banners/"))
	{	
		mkdir("../includes/templates/" . $template_dir . "/images/banners/");
	}
	if($image_name!='')
	{
		 $exist_image_name="../includes/templates/" . $template_dir . "/images/banners/".$sres->fields['item_image'];
		 if(file_exists($exist_image_name))
		 {
			  unlink($exist_image_name);   
		 }
		 $ext = pathinfo($image_name, PATHINFO_EXTENSION);
		 $onlyname=str_replace('.'.$ext,'',$image_name);
		 $prod_image= $onlyname.'_'.$time.".".$ext;
		 move_uploaded_file($_FILES['item_image']['tmp_name'],"../includes/templates/" . $template_dir . "/images/banners/" .$prod_image);
	  }
	  else
	  {
		 $prod_image=$sres->fields['item_image'];	
	  }
	  
	$sql_data_array = array(
					'sort_order'=>zen_db_prepare_input($sort_order),
					'item_type' => 	zen_db_prepare_input($item_type),
					'item_image' => zen_db_prepare_input($prod_image),
					'item_link' =>  zen_db_prepare_input($item_link),
					'item_desc' =>  base64_encode(serialize($item_desc_ar)),
					'item_status' => $item_status);
					
	zen_db_perform(TABLE_PZEN_TOPBANNER, $sql_data_array, 'update', "id='" .(int)$beid. "'" );
	
	$messageStack->add_session(PZEN_SUCCESS_ITEM_UPDATED, 'success');
	zen_redirect(zen_href_link(FILENAME_PZENTEMPLATE.".php",'','SSL'));
}
if(isset($_REQUEST['brid']))
  {
	  $id=$_REQUEST['brid'];
	  $item_type=$_REQUEST['itype'];
	  $checkchildres =$db->Execute("select * FROM ".TABLE_PZEN_TOPBANNER." where id='".$id."'");
	  $filen='../includes/templates/'.$template_dir.'/images/banners/'.$checkchildres->fields['item_image'];
	  if(file_exists($filen))
	  {
		  unlink($filen);	
	  }
	  $rs=$db->Execute("delete FROM ".TABLE_PZEN_TOPBANNER." where id='".$id."'");
	  $messageStack->add_session(PZEN_SUCCESS_ITEM_DELETED, 'success');
	  zen_redirect(zen_href_link(FILENAME_PZENTEMPLATE.".php",'','SSL'));
  }
if(isset($_REQUEST['beid']))
{
  $beid=$_REQUEST['beid'];
  $itype=$_REQUEST['itype'];
  $query_result = $db->Execute('SELECT * from '.TABLE_PZEN_TOPBANNER.' where id="'.$beid.'"');
  $item_image="../includes/templates/".$template_dir."/images/banners/".$query_result->fields['item_image'];
  $item_type=$query_result->fields['item_type'];
  $item_status=$query_result->fields['item_status'];
  $sort_order=$query_result->fields['sort_order'];
  $item_link=$query_result->fields['item_link'];
  $item_desc=unserialize(base64_decode($query_result->fields['item_desc']));
}
if(isset($_GET['action']) && $_GET['action']=='bnew') {
	$item_type=$_GET['itype'];
}
?>
<h1 class="tab-header"><?php echo PZEN_TABHEAD_TOP_BANNERS; ?></h1>
<form name='frm_pzen' action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="frm_pzen_set_submit" value="" />
	<section class="block-static single-block">
		<header class="block-header">
			<h2 class="title"><?php echo PZEN_TITLE_TOP_BANNERS; ?></h2>
		</header>
		<div class="block-content">
			<div class="row">
				<label><?php echo PZEN_LABEL_TOP_BANNERS_STATUS; ?></label>
				<div class="cont"><?php echo pzen_draw_yesnoradio('display_top_banners'); ?></div>
			</div>
			<div class="row">
				<label><?php echo PZEN_LABEL_TOP_BANNERS_LAYOUT; ?></label>
				<div class="cont">
					<?php 
						$top_banners_layout=get_pzen_options('top_banners_layout');
						if($top_banners_layout==''){$top_banners_layout=1;}
					?>
					<ul class="inline-ul">
						<li><input type="radio" name="top_banners_layout" value="1" <?php echo ($top_banners_layout==1)? 'checked="checked"' : '' ?> /><span><?php echo PZEN_TOPBANNER_BOXVIEW; ?></span></li>
						<li><input type="radio" name="top_banners_layout" value="2" <?php echo ($top_banners_layout=='2')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_TOPBANNER_FULLWIDTH; ?></span></li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="inner_section">
					<div class="rw">
						<label><?php echo PZEN_LABEL_TOP_BANNERS_STYLE; ?></label>
						<div class="rw_division">
							<?php 
							$topbannersstyle=get_pzen_options('top_banners_style');
							if($topbannersstyle==''){$topbannersstyle="1";}
							?>
							<div class="inline-ul col-lg-12">
								<div class="col-md-6"><input type="radio" name="top_banners_style" value="1" <?php echo ($topbannersstyle=='1')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_BANNER_STYLE_1; ?> </span></div>
								<div class="col-md-6"><input type="radio" name="top_banners_style" value="2" <?php echo ($topbannersstyle=='2')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_BANNER_STYLE_2; ?> </span></div>
							</div>
							<div class="col-lg-12">
								<div class="col-md-6"><img src="includes/pzen_template/images/top-banner-style-1.jpg" width="100%" height="auto" /></div>
								<div class="col-md-6"><img src="includes/pzen_template/images/top-banner-style-2.jpg" width="100%" height="auto" /></div>
							</div>
							<div class="rw">&nbsp;</div>
							<div class="inline-ul col-lg-12">
								<div class="col-md-6"><input type="radio" name="top_banners_style" value="3" <?php echo ($topbannersstyle=='3')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_BANNER_STYLE_3; ?></span></div>
								<div class="col-md-6"><input type="radio" name="top_banners_style" value="4" <?php echo ($topbannersstyle=='4')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_DISPLAY_STYLE_4; ?></span></div>
							</div>
							<div class="col-lg-12">
								<div class="col-md-6"><img src="includes/pzen_template/images/top-banner-style-3.jpg" width="100%" height="auto" /></div>
								<div class="col-md-6"><img src="includes/pzen_template/images/top-banner-style-4.jpg" width="100%" height="auto" /></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</form>
<?php 
/************************************************************************************
******************************** Display Item *******************************************
************************************************************************************/
?>
<?php if((!isset($_GET['beid'])) && ($_GET['action']!='bnew') ){ ?>
<?php /**************************************** Topbar Slider ****************************************/ ?>
<section class="block-static slides_block single-block">
    <header class="block-header">
        <h2 class="title"><?php echo PZEN_SLIDER; ?> <a class="action_new" href="<?php echo zen_href_link(FILENAME_PZENTEMPLATE, "action=bnew&itype=1", 'SSL'); ?>" >
        	<button title="<?php echo PZEN_ADD_ITEM; ?>" class="md-btn" type="button"><?php echo PZEN_ADD_ITEM; ?></button></a></h2>
    </header>
    <div class="block-content">
    	<?php 
		global $db;
		$result_1 = $db->Execute("SELECT * FROM ".TABLE_PZEN_TOPBANNER." where item_type='1' group by `sort_order` order by `sort_order`");
		$i=1; ?>
        <form id="sort-form-1" name='sort-form-1' action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
         	<input style="display:none;" type="checkbox" value="1" name="pautoSubmit" id="pautoSubmit" checked='checked' />
            <ul id="sortable-list" class="parentsortable-list-1">
            <?php 
			$porder=array();
            if ($result_1->RecordCount() > 0) {
				while (!$result_1->EOF) {
					$item_image="../includes/templates/".$template_dir."/images/banners/".$result_1->fields['item_image'];
					?>
					<li class="item"  id="<?php echo $result_1->fields['id']; ?>">
					<table border="0" width="100%" align="center" class="slide-item" style='border-collapse: collapse;margin-top:0;float:left;'>
					<tr>
						<td width="5%" class="slide_numb" align="center"><?php echo $i++; ?></td>
						<td width="5%" align="center">&nbsp;</td>
						<td width="30%" align="center"><?php echo "<div style='max-width:236px;width:100%;display:inline-block;'><img style='height: auto; max-width: 100%; max-height: 90px; margin: 2px 10px;' src='".$item_image."' alt='Item Image' /></div>"; ?></td>
						<td width="20%" align="center"><?php echo ($result_1->fields['item_status'])? "<img src='includes/".FILENAME_PZENTEMPLATE."/images/enable.png'  height='20' width='20' alt='enable' />" : "<img src='includes/".FILENAME_PZENTEMPLATE."/images/desable.png' height='20' width='20' alt='desable' />"; ?></td>
						<td width="30%" align="right" class="action_cont">
								<a href='<?php echo zen_href_link(FILENAME_PZENTEMPLATE, zen_get_all_get_params(array('beid')) . 'beid=' .$result_1->fields['id'], 'SSL'); ?>' class="md-btn" title="<?php echo PZEN_EDIT_ITEM; ?>"><?php echo PZEN_EDIT_ITEM; ?></a>
								 <a href='<?php echo zen_href_link(FILENAME_PZENTEMPLATE, zen_get_all_get_params(array('brid')) . 'brid=' .$result_1->fields['id'], 'SSL'); ?>' class="md-btn" title="<?php echo PZEN_DELETE_ITEM; ?>"><?php echo PZEN_DELETE_ITEM; ?></a>
								
						</td>
						<td width="5%" class="drageble_cont">
							&nbsp;      
						</tr>
					</table>
					<?php $porder[] = $result_1->fields['id']; ?>
					</li>
                <?php 
                $result_1->MoveNext();
                }
			}
			else{
				echo "<li>".PZEN_ITEM_NOTEXIST."</li>";		
			}
            ?>
        </ul>
        <input type="hidden" name="psort_order_1" id="psort_order_1" value="<?php echo implode(',',$porder); ?>" />
        </form>
	</div>
</section>
<?php /**************************************** Topbar Banners ****************************************/ ?>
<section class="block-static slides_block single-block">
    <header class="block-header">
        <h2 class="title"><?php echo PZEN_BANNER; ?> <a class="action_new" href="<?php echo zen_href_link(FILENAME_PZENTEMPLATE, "action=bnew&itype=2", 'SSL'); ?>" >
        	<button title="<?php echo PZEN_ADD_ITEM; ?>" class="md-btn" type="button"><?php echo PZEN_ADD_ITEM; ?></button></a></h2>
    </header>
    <div class="block-content">
    	<?php 
		global $db;
		$result = $db->Execute("SELECT * FROM ".TABLE_PZEN_TOPBANNER." where item_type='2' group by `sort_order` order by `sort_order`");
		$i=1; ?>
        <form id="sort-form-2" name='sort-form-2' action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
         	<input style="display:none;" type="checkbox" value="1" name="pautoSubmit" id="pautoSubmit" checked='checked' />
            <ul id="sortable-list" class="parentsortable-list-2">
            <?php 
			$porder=array();
            if ($result->RecordCount() > 0) {
				while (!$result->EOF) {
					$item_image="../includes/templates/".$template_dir."/images/banners/".$result->fields['item_image'];
					?>
					<li class="item"  id="<?php echo $result->fields['id']; ?>">
					<table border="0" width="100%" align="center" class="slide-item" style='border-collapse: collapse;margin-top:0;float:left;'>
					<tr>
						<td width="5%" class="slide_numb" align="center"><?php echo $i++; ?></td>
						<td width="5%" align="center">&nbsp;</td>
						<td width="30%" align="center"><?php echo "<div style='max-width:236px;width:100%;display:inline-block;'><img style='height: auto; max-width: 100%; max-height: 90px; margin: 2px 10px;' src='".$item_image."' alt='Item Image' /></div>"; ?></td>
						<td width="20%" align="center"><?php echo ($result->fields['item_status'])? "<img src='includes/".FILENAME_PZENTEMPLATE."/images/enable.png'  height='20' width='20' alt='enable' />" : "<img src='includes/".FILENAME_PZENTEMPLATE."/images/desable.png' height='20' width='20' alt='desable' />"; ?></td>
						<td width="30%" align="right" class="action_cont">
								<a href='<?php echo zen_href_link(FILENAME_PZENTEMPLATE, zen_get_all_get_params(array('beid')) . 'beid=' .$result->fields['id'], 'SSL'); ?>' class="md-btn" title="<?php echo PZEN_EDIT_ITEM; ?>"><?php echo PZEN_EDIT_ITEM; ?></a>
								<a href='<?php echo zen_href_link(FILENAME_PZENTEMPLATE, zen_get_all_get_params(array('brid')) . 'brid=' .$result->fields['id'], 'SSL'); ?>' class="md-btn" title="<?php echo PZEN_DELETE_ITEM; ?>"><?php echo PZEN_DELETE_ITEM; ?></a>
						</td>
						<td width="5%" class="drageble_cont">
							&nbsp;      
						</tr>
					</table>
					<?php $porder[] = $result->fields['id']; ?>
					</li>
                <?php 
                $result->MoveNext();
                }
			}
			else{
				echo "<li>".PZEN_ITEM_NOTEXIST."</li>";	
			}
            ?>
        </ul>
        <input type="hidden" name="psort_order_2" id="psort_order_2" value="<?php echo implode(',',$porder); ?>" />
        </form>
	</div>
</section>
<?php } ?>
<?php 
/************************************************************************************
******************************** Edit Item *******************************************
************************************************************************************/
?>	
<?php if(isset($_GET['action']) || isset($_GET['beid'])){ ?>
<form name='frm_pzen_banner' action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
	<section class="block-static single-block">
		<header class="block-header">
			<h2 class="title"><?php echo (isset($_GET['action']) && $_GET['action']=='bnew' )? PZEN_ADD_ITEM : PZEN_EDIT_ITEM; ?></h2>
		</header>
		<div class="block-content">
			
			<div class="row" <?php if(isset($_GET['beid'])){ echo "style='display:none;'"; } ?> >
				<label><?php echo PZEN_ITEM_TYPE; ?></label>
				<div class="cont">
					<?php echo pzen_draw_selectbox("item_type",array("1"=>"Slide","2"=>"Banner"),$item_type); ?>
				</div>
			</div>
			<div class="row">
				<label><?php echo PZEN_IMAGE; ?></label>
				<div class="cont">
					<input type="file" name="item_image" id="item_image"  /><?php if(isset($_REQUEST['beid'])){ echo "<span class='edited_slide'><img src='$item_image' alt='item_image' /></span>"; } ?>
				</div>
			</div>
			<div class="row">
				<label><?php echo PZEN_CONTENT; ?></label>
				<div class="cont">
					<?php
						// modified code for multi-language support
							for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
							  echo '<br />' . zen_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;';
							  echo zen_draw_textarea_field('item_desc[' . $languages[$i]['id'] . ']', 'Desc', 52 , 10,  $item_desc[$languages[$i]['id']] ,' class="noEditor md-input"', true);
							}
						// end modified code for multi-language support
					?>
				</div>
			</div>
			<div class="row">
					<label><?php echo PZEN_LINK; ?></label>
					<div class="cont">
						<input type="text" name="item_link" class="md-input md-input-link" id="item_link" value="<?php if(isset($_REQUEST['beid'])){ echo $item_link; } ?>" />
					</div>
				</div>
			<div class="row">
				<label><?php echo PZEN_STATUS; ?></label>
				<div class="cont">
					<?php if($item_status==''){$item_status=1;} ?>
					<ul class="inline-ul">
						<li><input type="radio" name="item_status" value="1" <?php echo ($item_status==0)? '' : 'checked="checked"';  ?>  /><span><?php echo PZEN_ENABLE; ?></span></li>
						<li><input type="radio" name="item_status" value="0" <?php echo ($item_status==0)? 'checked="checked"' : '';  ?> /><span><?php echo PZEN_DISABLE; ?></span></li>
					</ul>
				</div>
			</div>
			<div class="row">
				<?php if(isset($_REQUEST['beid'])){ ?>
					<input type="submit" name="update_pzen_banner" class="md-btn" value="<?php echo PZEN_UPDATE; ?>" />
					<input type='hidden' name='beid' value="<?php if(isset($_REQUEST['beid'])) echo $_REQUEST['beid']; ?>" /> 
					<input type='hidden' name='sort_order' value="<?php if(isset($sort_order)) echo $sort_order ?>" /> 
				<?php }else{?>
					<input type="submit" class="md-btn" name="submit_pzen_banner" value="<?php echo PZEN_SAVE; ?>" /><?php } ?>
					<input type="reset" class="md-btn" onclick="reset_function()" name="cancel_mzen_slide" value="<?php echo PZEN_CANCEL; ?>" />
			</div>
		</div>
	 </section>
</form>
 <?php } ?>
<script type="text/javascript">
/********************************************************* Drag and drop sorting for slides   ***************************************/
function reset_function(){
	window.location="<?php echo $cancel_url; ?>";	
}
// for parent slide sorting
jQuery(document).ready(function() {
	/*************************************************** sortting list 1 **************************************/
	/* grab important elements */
	var sortInput_1 = jQuery('#psort_order_1');
	//alert(JSON.stringify(sortInput));
	var submit = jQuery('#pautoSubmit');
	var messageBox = jQuery('#message-box');
	var list_1 = jQuery('.parentsortable-list-1');
	/* create requesting function to avoid duplicate code */
	if(list_1.children('li').size()>1){
		var request_1 = function(){
			jQuery.ajax({
				beforeSend: function() {
					messageBox.text('Updating the sort order in the database.');
				},
				complete: function() {
					var xmlhttp
					var table_name="<?php echo TABLE_PZEN_TOPBANNER; ?>";
					var po_list=document.getElementById('psort_order_1').value;
					if (window.XMLHttpRequest)
						{
							xmlhttp=new XMLHttpRequest();
						}
						else
						{
							xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
						}
						xmlhttp.onreadystatechange=function()
						{
							if (xmlhttp.readyState==4 && xmlhttp.status==200)
							{
								//	alert(xmlhttp.responseText);
							}
						}
						xmlhttp.open("POST","pzen_slide_ajax.php?o_list="+po_list+"&tname="+table_name,true);
						xmlhttp.send();
				},
				data: 'sort_order=' + sortInput_1[0].value + '&ajax=' + submit[0].checked + '&do_submit=1&byajax=1', //need [0]?
				type: 'post',
				url: '<?php echo $_SERVER["REQUEST_URI"]; ?>'
			});
		};
		
		var fnSubmit_1 = function(save) {
			var sortOrder = [];
			list_1.children('li').each(function(){
				sortOrder.push(jQuery(this).data('id'));
			});
			sortInput_1.val(sortOrder.join(','));
				console.log(sortInput_1.val());
			if(save) {
				request_1();
			}
		};
	/* store values */
		list_1.children('li').each(function() {
			var li = jQuery(this);
				li.data('id',li.attr('id')).attr('id','');
		});
		list_1.disableSelection();
	/* sortables */
		list_1.sortable({
			containment: "parent",
			opacity: 0.7,
			update: function() {
				fnSubmit_1(submit[0].checked);
			}
		});
		/* ajax form submission */
		jQuery('#sort-form-1').bind('submit',function(e) {
			if(e) e.preventDefault();
				fnSubmit_1(true);
		});
	}
	/*************************************************** sortting list 2 **************************************/
	/* grab important elements */
	var sortInput_2 = jQuery('#psort_order_2');
	//alert(JSON.stringify(sortInput));
	var submit = jQuery('#pautoSubmit');
	var messageBox = jQuery('#message-box');
	var list_2 = jQuery('.parentsortable-list-2');
	/* create requesting function to avoid duplicate code */
	if(list_2.children('li').size()>1){
		var request_2 = function(){
			jQuery.ajax({
				beforeSend: function() {
					messageBox.text('Updating the sort order in the database.');
				},
				complete: function() {
					var xmlhttp
					var table_name="<?php echo TABLE_PZEN_TOPBANNER; ?>";
					var po_list=document.getElementById('psort_order_2').value;
					if (window.XMLHttpRequest)
						{
							xmlhttp=new XMLHttpRequest();
						}
						else
						{
							xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
						}
						xmlhttp.onreadystatechange=function()
						{
							if (xmlhttp.readyState==4 && xmlhttp.status==200)
							{
								//	alert(xmlhttp.responseText);
							}
						}
						xmlhttp.open("POST","pzen_slide_ajax.php?o_list="+po_list+"&tname="+table_name,true);
						xmlhttp.send();
				},
				data: 'sort_order=' + sortInput_2[0].value + '&ajax=' + submit[0].checked + '&do_submit=1&byajax=1', //need [0]?
				type: 'post',
				url: '<?php echo $_SERVER["REQUEST_URI"]; ?>'
			});
		};
		var fnSubmit_2 = function(save) {
			var sortOrder = [];
			list_2.children('li').each(function(){
				sortOrder.push(jQuery(this).data('id'));
			});
			sortInput_2.val(sortOrder.join(','));
				console.log(sortInput_2.val());
			if(save) {
				request_2();
			}
		};
		/* store values */
		list_2.children('li').each(function() {
			var li = jQuery(this);
				li.data('id',li.attr('id')).attr('id','');
		});
		list_2.disableSelection();
		/* sortables */
		list_2.sortable({
			containment: "parent",
			opacity: 0.7,
			update: function() {
				fnSubmit_2(submit[0].checked);
			}
		});
		/* ajax form submission */
		jQuery('#sort-form-2').bind('submit',function(e) {
			if(e) e.preventDefault();
				fnSubmit_2(true);
		});
	}
});
</script>