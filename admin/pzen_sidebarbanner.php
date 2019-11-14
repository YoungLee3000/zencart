<?php 
##PZENTEMPLATE_BRAND##

global $db;
global $template_dir, $messageStack; 

/************************************************************************************
******************************** Insert Item *******************************************
************************************************************************************/
if(isset($_REQUEST['submit_pzen_sidebarbanner']))
{
	//$sidebitem_desc_ar = zen_db_prepare_input($_POST['sidebitem_desc']);
	$sidebitem_type = zen_db_prepare_input($_POST['sidebitem_type']);
	$sidebitem_status = zen_db_prepare_input($_POST['sidebitem_status']);
	$image_name = zen_db_prepare_input($_FILES['sidebitem_image']['name']);
	$sidebitem_link = zen_db_prepare_input($_POST['sidebitem_link']);
	$sres=$db->Execute("SELECT MAX(sort_order) as maxid FROM ". TABLE_PZEN_SIDEBARBANNER." where item_type=".$sidebitem_type) or die(mysql_error());
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
	   move_uploaded_file($_FILES['sidebitem_image']['tmp_name'],"../includes/templates/" . $template_dir . "/images/banners/" .$prod_image);
	}
	else
	{
		 $prod_image='';
	}
	
	$sql_data_array = array(
					'sort_order' =>  $maxid,
					'item_type' => 	zen_db_prepare_input($sidebitem_type),
					'item_image' => zen_db_prepare_input($prod_image),
					'item_link' =>  zen_db_prepare_input($sidebitem_link),
					//'item_desc' =>  base64_encode(serialize($sidebitem_desc_ar)),
					'item_status' => $sidebitem_status);
					
	zen_db_perform(TABLE_PZEN_SIDEBARBANNER, $sql_data_array);
	$messageStack->add_session(PZEN_SUCCESS_ITEM_INSERTED, 'success');
	zen_redirect(zen_href_link(FILENAME_PZENTEMPLATE.".php",'','SSL'));
}

/************************************************************************************
******************************** Update Item *******************************************
************************************************************************************/ 
if(isset($_REQUEST['update_pzen_sidebarbanner']))
{
	//$sidebitem_desc_ar = zen_db_prepare_input($_POST['sidebitem_desc']);
	$sidebitem_status = zen_db_prepare_input($_POST['sidebitem_status']);
	$sidebitem_type = zen_db_prepare_input($_POST['sidebitem_type']);
	$sidebitem_link = zen_db_prepare_input($_POST['sidebitem_link']);
	$image_name = zen_db_prepare_input($_FILES['sidebitem_image']['name']);
	$sort_order = zen_db_prepare_input($_POST['sort_order']);
	$sidebeid=$_REQUEST['sidebeid'];
	$sres=$db->Execute("SELECT MAX(sort_order) as maxid, item_image FROM ".TABLE_PZEN_SIDEBARBANNER." where id='".(int)$sidebeid."'") or die(mysql_error());
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
		 move_uploaded_file($_FILES['sidebitem_image']['tmp_name'],"../includes/templates/" . $template_dir . "/images/banners/" .$prod_image);
	  }
	  else
	  {
		 $prod_image=$sres->fields['item_image'];	
	  }
	  
	$sql_data_array = array(
					'sort_order'=>zen_db_prepare_input($sort_order),
					'item_type' => 	zen_db_prepare_input($sidebitem_type),
					'item_image' => zen_db_prepare_input($prod_image),
					'item_link' =>  zen_db_prepare_input($sidebitem_link),
					//'item_desc' =>  base64_encode(serialize($sidebitem_desc_ar)),
					'item_status' => $sidebitem_status);
					
	zen_db_perform(TABLE_PZEN_SIDEBARBANNER, $sql_data_array, 'update', "id='" .(int)$sidebeid. "'" );
	
	$messageStack->add_session(PZEN_SUCCESS_ITEM_UPDATED, 'success');
	zen_redirect(zen_href_link(FILENAME_PZENTEMPLATE.".php",'','SSL'));
}
if(isset($_REQUEST['sidebrid']))
  {
	  $id=$_REQUEST['sidebrid'];
	  $sidebitem_type=$_REQUEST['itype'];
	  $checkchildres =$db->Execute("select * FROM ".TABLE_PZEN_SIDEBARBANNER." where id='".$id."'");
	  $filen='../includes/templates/'.$template_dir.'/images/banners/'.$checkchildres->fields['item_image'];
	  if(file_exists($filen))
	  {
		  unlink($filen);	
	  }
	  $rs=$db->Execute("delete FROM ".TABLE_PZEN_SIDEBARBANNER." where id='".$id."'");
	  $messageStack->add_session(PZEN_SUCCESS_ITEM_DELETED, 'success');
	  zen_redirect(zen_href_link(FILENAME_PZENTEMPLATE.".php",'','SSL'));
  }
if(isset($_REQUEST['sidebeid']))
{
  $sidebeid=$_REQUEST['sidebeid'];
  $itype=$_REQUEST['itype'];
  $query_result = $db->Execute('SELECT * from '.TABLE_PZEN_SIDEBARBANNER.' where id="'.$sidebeid.'"');
  $sidebitem_image="../includes/templates/".$template_dir."/images/banners/".$query_result->fields['item_image'];
  $sidebitem_type=$query_result->fields['item_type'];
  $sidebitem_status=$query_result->fields['item_status'];
  $sort_order=$query_result->fields['sort_order'];
  $sidebitem_link=$query_result->fields['item_link'];
  $bot=($query_result->fields['item_desc']);
  //$sidebitem_desc=unserialize(base64_decode($query_result->fields['item_desc']));
}
if(isset($_GET['action']) && $_GET['action']=='sidebnew') {
	$sidebitem_type=$_GET['itype'];
}

?>
<h1 class="tab-header"><?php echo PZEN_TABHEAD_SIDEBARBANNER; ?></h1>
<?php 
/************************************************************************************
******************************** Display Item *******************************************
************************************************************************************/
?>
<?php if((!isset($_GET['sidebeid'])) && ($_GET['action']!='sidebnew') ){ ?>

<?php /**************************************** Bottom Banners ****************************************/ ?>
<section class="block-static slides_block single-block">
    <header class="block-header">
        <h2 class="title"><?php echo PZEN_BANNER; ?> <a class="action_new" href="<?php echo zen_href_link(FILENAME_PZENTEMPLATE, "action=sidebnew&itype=2", 'SSL'); ?>" >
        	<button title="<?php echo PZEN_ADD_ITEM; ?>" class="md-btn" type="button"><?php echo PZEN_ADD_ITEM; ?></button></a></h2>
    </header>
    <div class="block-content">
    	<?php 
		global $db;
		$result = $db->Execute("SELECT * FROM ".TABLE_PZEN_SIDEBARBANNER." where item_type='2' group by `sort_order` order by `sort_order`");
		$i=1; ?>
        <form id="sort-sidebform-2" name='sort-sidebform-2' action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
         	<input style="display:none;" type="checkbox" value="1" name="pautoSubmit" id="pautoSubmit" checked='checked' />
            <ul id="sortable-list" class="parentsortable-sideb-list-2">
            <?php 
			$porder=array();
            if ($result->RecordCount() > 0) {
				while (!$result->EOF) {
					$sidebitem_image="../includes/templates/".$template_dir."/images/banners/".$result->fields['item_image'];
					?>
					<li class="item"  id="<?php echo $result->fields['id']; ?>">
					<table border="0" width="100%" align="center" class="slide-item" style='border-collapse: collapse;margin-top:0;float:left;'>
					<tr>
						<td width="5%" class="slide_numb" align="center"><?php echo $i++; ?></td>
						<td width="5%" align="center">&nbsp;</td>
						<td width="30%" align="center"><?php echo "<div style='max-width:236px;width:100%;display:inline-block;'><img style='height: auto; max-width: 100%; max-height: 90px; margin: 2px 10px;' src='".$sidebitem_image."' alt='Item Image' /></div>"; ?></td>
						<td width="20%" align="center"><?php echo ($result->fields['item_status'])? "<img src='includes/".FILENAME_PZENTEMPLATE."/images/enable.png'  height='20' width='20' alt='enable' />" : "<img src='includes/".FILENAME_PZENTEMPLATE."/images/desable.png' height='20' width='20' alt='desable' />"; ?></td>
						<td width="30%" align="right" class="action_cont">
								<a href='<?php echo zen_href_link(FILENAME_PZENTEMPLATE, zen_get_all_get_params(array('sidebeid')) . 'sidebeid=' .$result->fields['id'], 'SSL'); ?>' class="md-btn" title="<?php echo PZEN_EDIT_ITEM; ?>"><?php echo PZEN_EDIT_ITEM; ?></a>
								 <a href='<?php echo zen_href_link(FILENAME_PZENTEMPLATE, zen_get_all_get_params(array('sidebrid')) . 'sidebrid=' .$result->fields['id'], 'SSL'); ?>' class="md-btn" title="<?php echo PZEN_DELETE_ITEM; ?>"><?php echo PZEN_DELETE_ITEM; ?></a>
								
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
        <input type="hidden" name="psort_sideb_order_2" id="psort_sideb_order_2" value="<?php echo implode(',',$porder); ?>" />
        </form>
	</div>
</section>
<?php } ?>
<?php 
/************************************************************************************
******************************** Edit Item *******************************************
************************************************************************************/
?>	
<form name='frm_pzen_banner' action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
<?php if(isset($_GET['action']) || isset($_GET['sidebeid'])){ ?>
<section class="block-static single-block">
    <header class="block-header">
        <h2 class="title"><?php echo (isset($_GET['action']) && $_GET['action']=='sidebnew' )? PZEN_ADD_ITEM : PZEN_EDIT_ITEM; ?></h2>
    </header>
    <div class="block-content">
        <div class="row">
            <label><?php echo PZEN_IMAGE; ?></label>
            <div class="cont">
				<input type="file" name="sidebitem_image" id="sidebitem_image"  /><?php if(isset($_REQUEST['sidebeid'])){ echo "<span class='edited_slide'><img src='$sidebitem_image' alt='sidebitem_image' /></span>"; } ?>
            </div>
        </div>
		<div class="row">
				<label><?php echo PZEN_LINK; ?></label>
				<div class="cont">
					<input type="text" name="sidebitem_link" class="md-input md-input-link" id="sidebitem_link" value="<?php if(isset($_REQUEST['sidebeid'])){ echo $sidebitem_link; } ?>"  />
				</div>
			</div>
        <div class="row">
            <label><?php echo PZEN_STATUS; ?></label>
            <div class="cont">
				<?php if($sidebitem_status==''){$sidebitem_status=1;} ?>
            	<ul class="inline-ul">
                    <li><input type="radio" name="sidebitem_status" value="1" <?php echo ($sidebitem_status==0)? '' : 'checked="checked"';  ?>  /><span><?php echo PZEN_ENABLE; ?></span></li>
                    <li><input type="radio" name="sidebitem_status" value="0" <?php echo ($sidebitem_status==0)? 'checked="checked"' : '';  ?> /><span><?php echo PZEN_DISABLE; ?></span></li>
                </ul>
			</div>
        </div>
		<input type="hidden" name="sidebitem_type" value="2" />
        <div class="row">
        	<?php if(isset($_REQUEST['sidebeid'])){ ?>
				<input type="submit" name="update_pzen_sidebarbanner" class="md-btn" value="<?php echo PZEN_UPDATE; ?>" />
				<input type='hidden' name='sidebeid' value="<?php if(isset($_REQUEST['sidebeid'])) echo $_REQUEST['sidebeid']; ?>" /> 
				<input type='hidden' name='sort_order' value="<?php if(isset($sort_order)) echo $sort_order ?>" /> 
			<?php }else{?>
				<input type="submit" class="md-btn" name="submit_pzen_sidebarbanner" value="<?php echo PZEN_SAVE; ?>" /><?php } ?>
				<input type="reset" class="md-btn" onclick="reset_function()" name="cancel_mzen_slide" value="<?php echo PZEN_CANCEL; ?>" />
        </div>
    </div>
 </section>
 <?php } ?>
 </form>
<script type="text/javascript">
/********************************************************* Drag and drop sorting for slides   ***************************************/
function reset_function(){
	window.location="<?php echo $cancel_url; ?>";	
}
// for parent slide sorting
jQuery(document).ready(function() {
	/* grab important elements */
	var sortInput_3 = jQuery('#psort_sideb_order_2');
	//alert(JSON.stringify(sortInput));
	var submit = jQuery('#pautoSubmit');
	var messageBox = jQuery('#message-box');
	var list_3 = jQuery('.parentsortable-sideb-list-2');
	if(list_3.children('li').size()>1){
		/* create requesting function to avoid duplicate code */
		var request_3 = function(){
			jQuery.ajax({
				beforeSend: function() {
					messageBox.text('Updating the sort order in the database.');
				},
				complete: function() {
					var xmlhttp
					var table_name="<?php echo TABLE_PZEN_SIDEBARBANNER; ?>";
					var po_list=document.getElementById('psort_sideb_order_2').value;
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
				data: 'sort_order=' + sortInput_3[0].value + '&ajax=' + submit[0].checked + '&do_submit=1&byajax=1', //need [0]?
				type: 'post',
				url: '<?php echo $_SERVER["REQUEST_URI"]; ?>'
			});
		};
		var fnSubmit_3 = function(save) {
			var sortOrder = [];
			list_3.children('li').each(function(){
				sortOrder.push(jQuery(this).data('id'));
			});
			sortInput_3.val(sortOrder.join(','));
				console.log(sortInput_3.val());
			if(save) {
				request_3();
			}
		};
	/* store values */
		list_3.children('li').each(function() {
			var li = jQuery(this);
				li.data('id',li.attr('id')).attr('id','');
		});
		list_3.disableSelection();
	/* sortables */
		list_3.sortable({
			containment: "parent",
			opacity: 0.7,
			update: function() {
				fnSubmit_3(submit[0].checked);
			}
		});
	
		/* ajax form submission */
		jQuery('#sort--sideb-form-2').bind('submit',function(e) {
			if(e) e.preventDefault();
				fnSubmit_3(true);
		});
	}
});
</script>