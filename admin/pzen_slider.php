<?php 
##PZENTEMPLATE_BRAND##

global $db;
global $template_dir, $messageStack;

if(isset($_REQUEST['submit_pzen_slide']))
 {
	$slideshow_caption = zen_db_prepare_input($_POST['slideshow_caption']);
	$trans_style = zen_db_prepare_input(trim($_POST['trans_style']));
	$data_masterspeed = zen_db_prepare_input(trim($_POST['data_masterspeed']));
	$data_delay = zen_db_prepare_input(trim($_POST['data_delay']));
	$data_slotamount = zen_db_prepare_input(trim($_POST['data_slotamount']));
	
	$in_animation_class = zen_db_prepare_input(trim($_POST['in_animation_class']));
	$out_animation_class = zen_db_prepare_input(trim($_POST['out_animation_class']));
	$ease_in = zen_db_prepare_input(trim($_POST['ease_in']));
	$ease_out = zen_db_prepare_input(trim($_POST['ease_out']));
	$data_x = zen_db_prepare_input(trim($_POST['data_x']));
	$data_y = zen_db_prepare_input(trim($_POST['data_y']));
	$data_hoffset = zen_db_prepare_input(trim($_POST['data_hoffset']));;
	$data_voffset = zen_db_prepare_input(trim($_POST['data_voffset']));;
	$slide_status = zen_db_prepare_input($_POST['slide_status']);
	$image_name = zen_db_prepare_input($_FILES['slideshow_image']['name']);
	$sres=$db->Execute("SELECT MAX(sort_order) as maxid FROM ". TABLE_PZEN_SLIDER) or die(mysql_error());
	$maxid=$sres->fields['maxid']+1;
	if(!is_dir("../includes/templates/" . $template_dir . "/images/slider/"))
	{
		mkdir("../includes/templates/" . $template_dir . "/images/slider/");
	}
	if($image_name!='')
	{
	   $ext = pathinfo($image_name, PATHINFO_EXTENSION);
	   $onlyname=str_replace('.'.$ext,'',$image_name);
	   $prod_image= $onlyname.'_'.$time.".".$ext;
	   move_uploaded_file($_FILES['slideshow_image']['tmp_name'],"../includes/templates/" . $template_dir . "/images/slider/" .$prod_image);
	}
	else
	{
		 $prod_image='';
	}
	
	$sql_data_array = array( 'sort_order' =>  $maxid,
							'slideshow_image' => zen_db_prepare_input($prod_image),
							'slideshow_caption'=> base64_encode(serialize($slideshow_caption)),
							'trans_style'=> $trans_style,
							'data_masterspeed'=> $data_masterspeed,
							'data_delay'=> $data_delay,
							'data_slotamount'=> $data_slotamount,
							'in_animation_class'=> $in_animation_class,
							'out_animation_class'=> $out_animation_class,
							'ease_in'=> $ease_in,
							'ease_out'=> $ease_out,
							'data_x'=> $data_x,
							'data_y'=> $data_y,
							'data_hoffset'=> $data_hoffset,
							'data_voffset'=> $data_voffset,
							'slide_status' => $slide_status);
	zen_db_perform(TABLE_PZEN_SLIDER, $sql_data_array);

	$messageStack->add_session(PZEN_SUCCESS_SLIDE_INSERTED, 'success');
	zen_redirect(zen_href_link(FILENAME_PZENTEMPLATE.".php",'','SSL'));
 }
if(isset($_REQUEST['update_pzen_slide']))
{
	global $db;
	$slideshow_caption = zen_db_prepare_input($_POST['slideshow_caption']);
	
	$trans_style = zen_db_prepare_input(trim($_POST['trans_style']));
	$data_masterspeed = zen_db_prepare_input(trim($_POST['data_masterspeed']));
	$data_delay = zen_db_prepare_input(trim($_POST['data_delay']));
	$data_slotamount = zen_db_prepare_input(trim($_POST['data_slotamount']));
	
	$in_animation_class = zen_db_prepare_input(trim($_POST['in_animation_class']));
	$out_animation_class = zen_db_prepare_input(trim($_POST['out_animation_class']));
	$ease_in = zen_db_prepare_input(trim($_POST['ease_in']));
	$ease_out = zen_db_prepare_input(trim($_POST['ease_out']));
	$data_x = zen_db_prepare_input(trim($_POST['data_x']));
	$data_y = zen_db_prepare_input(trim($_POST['data_y']));
	$data_hoffset = zen_db_prepare_input(trim($_POST['data_hoffset']));;
	$data_voffset = zen_db_prepare_input(trim($_POST['data_voffset']));;
	$slide_status = zen_db_prepare_input($_POST['slide_status']);
	
	$image_name = zen_db_prepare_input($_FILES['slideshow_image']['name']);
	$sort_order = zen_db_prepare_input($_POST['sort_order']);
	 
	$slideshow_eid=$_REQUEST['slideshow_eid'];
	 
	$sres=$db->Execute("SELECT MAX(sort_order) as maxid, slideshow_image FROM ".TABLE_PZEN_SLIDER." where id='".$slideshow_eid."'") or die(mysql_error());
	$maxid=$sres->fields['maxid']+1;
	if(!is_dir("../includes/templates/" . $template_dir . "/images/slider/"))
	{
		mkdir("../includes/templates/" . $template_dir . "/images/slider/");
	}
	if($image_name!='')
	{
		$exist_image_name="../includes/templates/" . $template_dir . "/images/slider/".$sres->fields['slideshow_image'];
		if(file_exists($exist_image_name)){unlink($exist_image_name);}
		$ext = pathinfo($image_name, PATHINFO_EXTENSION);
		$onlyname=str_replace('.'.$ext,'',$image_name);
		$prod_image= $onlyname.'_'.$time.".".$ext;
		move_uploaded_file($_FILES['slideshow_image']['tmp_name'],"../includes/templates/" . $template_dir . "/images/slider/" .$prod_image);
	}else{
		$prod_image=$sres->fields['slideshow_image'];	
	}
	
	$sql_data_array = array(
		'sort_order'=>zen_db_prepare_input($sort_order),
		'slideshow_image' => zen_db_prepare_input($prod_image),
		'slideshow_caption'=> base64_encode(serialize($slideshow_caption)),
		'trans_style'=> $trans_style,
		'data_masterspeed'=> $data_masterspeed,
		'data_delay'=> $data_delay,
		'data_slotamount'=> $data_slotamount,
		'in_animation_class'=> $in_animation_class,
		'out_animation_class'=> $out_animation_class,
		'ease_in'=> $ease_in,
		'ease_out'=> $ease_out,
		'data_x'=> $data_x,
		'data_y'=> $data_y,
		'data_hoffset'=> $data_hoffset,
		'data_voffset'=> $data_voffset,  
		'slide_status' => $slide_status);
		
		zen_db_perform(TABLE_PZEN_SLIDER, $sql_data_array, 'update', "id = '" . (int)$slideshow_eid . "'" );
		
	$messageStack->add_session(PZEN_SUCCESS_SLIDE_UPDATED, 'success');
	zen_redirect(zen_href_link(FILENAME_PZENTEMPLATE.".php",'','SSL'));
}
if(isset($_GET['slideshow_rid']))
  {
	  $id=$_REQUEST['slideshow_rid'];
	  $checkchildres =$db->Execute("select * FROM ".TABLE_PZEN_SLIDER." where id='".$id."'");
	  $filen='../includes/templates/'.$template_dir.'/images/slider/'.$checkchildres->fields['slideshow_image'];
	  if(file_exists($filen))
	  {
		  unlink($filen);	
	  }
	  $rs=$db->Execute("delete FROM ".TABLE_PZEN_SLIDER." where id='".$id."'");
	  $messageStack->add_session(PZEN_SUCCESS_SLIDE_DELETED, 'success');
	  zen_redirect(zen_href_link(FILENAME_PZENTEMPLATE.".php",'','SSL'));
  }
if(isset($_GET['slideshow_eid']))
{
	$slideshow_eid=$_REQUEST['slideshow_eid'];
	$query_result = $db->Execute('SELECT * from '.TABLE_PZEN_SLIDER.' where id="'.$slideshow_eid.'"');
	$slideshow_image="../includes/templates/".$template_dir."/images/slider/".$query_result->fields['slideshow_image'];
	$slide_status=$query_result->fields['slide_status'];
	$sort_order=$query_result->fields['sort_order'];
	$slideshow_caption = unserialize(base64_decode($query_result->fields['slideshow_caption']));
	$trans_style = $query_result->fields['trans_style'];
	$data_masterspeed = $query_result->fields['data_masterspeed'];
	$data_delay = $query_result->fields['data_delay'];
	$data_slotamount = $query_result->fields['data_slotamount'];
	
	$in_animation_class = $query_result->fields['in_animation_class'];
	$out_animation_class = $query_result->fields['out_animation_class'];
	$ease_in = $query_result->fields['ease_in'];
	$ease_out = $query_result->fields['ease_out'];
	$data_x = $query_result->fields['data_x'];
	$data_y = $query_result->fields['data_y'];
	$data_hoffset = $query_result->fields['data_hoffset'];
	$data_voffset = $query_result->fields['data_voffset'];
}
$mainslider_style=get_pzen_options('full_width_slideshow');
?>
<h1 class="tab-header"><?php echo PZEN_TABHEAD_MAINSLIDER; ?></h1>
<form name='frm_pzen' action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="frm_pzen_set_submit" value="" />
	<section class="block-static single-block">
		<header class="block-header">
			<h2 class="title"><?php echo PZEN_TITLE_MAINSLIDER; ?></h2>
		</header>
		<div class="block-content">
			<div class="row">
				<label><?php echo PZEN_LABEL_DISPLAY_MAINSLIDESHOW; ?></label>
				<div class="cont"><?php echo pzen_draw_yesnoradio('display_main_slideshow'); ?></div>
			</div>
			<div class="row">
				<div class="inner_section">
					<div class="rw">
						<label><?php echo PZEN_LABEL_SLIDESHOW_STYLE; ?></label>
						<div class="rw_division">
							<?php 
							if($mainslider_style==''){$mainslider_style="full_width";}
							?>
							<div class="inline-ul col-lg-12">
								<div class="col-md-3">
									<input type="radio" name="full_width_slideshow" value="full_width" <?php echo ($mainslider_style=='full_width')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_FULLWIDTH; ?></span>
								</div>
								<div class="col-md-3">
									<input type="radio" name="full_width_slideshow" value="large" <?php echo ($mainslider_style=='large')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_LARGE; ?> </span>
								</div>
								<div class="col-md-3">
									<input type="radio" name="full_width_slideshow" value="intro" <?php echo ($mainslider_style=='intro')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_INTROSTYLE; ?> </span>
									<p class="notice"><?php echo PZEN_NOTICE_INTROSTYLE; ?> </p>
								</div>
								<div class="col-md-3">
									<input type="radio" name="full_width_slideshow" value="layer" <?php echo ($mainslider_style=='layer')? 'checked="checked"' : '' ?> /><span><?php echo PZEN_LAYERSSTYLE; ?> </span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php if($mainslider_style=='layer'){ ?>
			<div class="row">
				<div class="alert alert-warning alert-dismissable larger"><?php echo PZEN_NOTICE_LAYERSTYLE; ?></div>
			</div>
			<?php } ?>
			<?php if($mainslider_style!='layer'){ ?>
			<div class="row">
				<label><?php echo PZEN_LABEL_SLIDESHOW_DELAY; ?> </label>
				<div class="cont">
					<?php echo pzen_draw_inputbox('slideshow_delay'); ?>
					<p class="notice"> <?php echo PZEN_NOTICE_SLIDESHOW_DELAY; ?></p>
				</div>
			</div>
			<?php } ?>
		</div>
	</section>
</form>
<?php if($mainslider_style!='layer'){ ?>
<?php if((!isset($_GET['slideshow_eid'])) && ($_GET['action']!='slideshow_new')){ ?>
<section class="block-static slides_block">
    <header class="block-header">
        <h2 class="title"><?php echo PZEN_SLIDES_LIST; ?>
		<?php if($mainslider_style!='layer'){ ?>
		<a class="action_new" href="<?php echo zen_href_link(FILENAME_PZENTEMPLATE,"action=slideshow_new", 'SSL'); ?>" ><button title="Add Slide" class="md-btn" type="button"><?php echo PZEN_ADD_SLIDE; ?></button></a>
		<?php } ?>
	</h2>
    </header>
    <div class="block-content">
    	 <?php 
		 global $db;
    	$result = $db->Execute("SELECT * FROM ".TABLE_PZEN_SLIDER." group by `sort_order` order by `sort_order`");
    $i=1;
    ?>
        <form id="sort_form_mainslider" name='sort_form_mainslider' action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
         	<input style="display:none;" type="checkbox" value="1" name="pautoSubmit" id="pautoSubmit" checked='checked' />
            <ul id="sortable-list" class="sort_list_mainslider">
            <?php 
            $porder=array();
            if ($result->RecordCount() > 0) {
				while (!$result->EOF) {
                $slideshow_image="../includes/templates/".$template_dir."/images/slider/".$result->fields['slideshow_image'];
                ?>
                <li class="item" title="<?php echo $result->fields['slide_title']; ?>" id="<?php echo $result->fields['id']; ?>">
                <table border="0" width="100%" align="center" class="slide-item" style='border-collapse: collapse;margin-top:0;float:left;'>
                <tr>
                    <td width="5%" class="slide_numb" align="center"><?php echo $i++; ?></td>
                    <td width="5%" align="center"><?php echo $result->fields['slide_title']; ?></td>
                    <td width="30%" align="center"><?php echo "<div style='max-width:236px;width:100%;display:inline-block;'><img style='height: auto; max-width: 100%; max-height: 90px; margin: 2px 10px;' src='".$slideshow_image."' alt=".$result->fields['slide_title']." /></div>"; ?></td>
                    <td width="20%" align="center"><?php echo ($result->fields['slide_status'])? "<img src='includes/".FILENAME_PZENTEMPLATE."/images/enable.png'  height='20' width='20' alt='enable' />" : "<img src='includes/".FILENAME_PZENTEMPLATE."/images/desable.png' height='20' width='20' alt='desable' />"; ?></td>
                    <td width="30%" align="right" class="action_cont">
						<a href='<?php echo zen_href_link(FILENAME_PZENTEMPLATE, zen_get_all_get_params(array('slideshow_eid')) . 'slideshow_eid=' .$result->fields['id'], 'SSL'); ?>' class="md-btn" title="<?php echo PZEN_EDIT_SLIDE; ?>"><?php echo PZEN_EDIT_SLIDE; ?></a>
						<a href='<?php echo zen_href_link(FILENAME_PZENTEMPLATE, zen_get_all_get_params(array('slideshow_rid')) . 'slideshow_rid=' .$result->fields['id'], 'SSL'); ?>' class="md-btn" title="<?php echo PZEN_DELETE_SLIDE; ?>"><?php echo PZEN_DELETE_SLIDE; ?></a>
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
				echo "<li>".PZEN_SLIDE_NOTEXIST."</li>";	
			}
            ?>
        </ul>
        <input type="hidden" name="psort_mainslider_order" id="psort_mainslider_order" value="<?php echo implode(',',$porder); ?>" />
        </form>
	</div>
</section>
<?php } ?>
<?php if(isset($_GET['action']) || isset($_GET['slideshow_eid'])){ ?>
<form name='frm_pzen' action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
	<section class="block">
		<header class="block-header">
			<h2 class="title"><?php echo (isset($_GET['action']) && $_GET['action']=='slideshow_new' )? 'Add Slide' : 'Edit Slide'; ?></h2>
		</header>
		<div class="block-content">
			<div class="row">
				<label><?php echo PZEN_LABEL_ADD_SLIDESHOW_IMAGE; ?></label>
				<div class="cont">
					<input type="file" name="slideshow_image" id="slideshow_image"  /><?php if(isset($_GET['slideshow_eid'])){ echo "<span class='edited_slide'><img src='$slideshow_image' alt='slideshow_image' /></span>"; } ?>
				</div>
			</div>
			<div class="row">
				<label><?php echo PZEN_LABEL_SLIDESHOW_TRANS_STYLE; ?></label>
				<div class="cont">
					<?php
					$trans_style_ar=array(
						"slideup"=>"Slide To Top",
						"slidedown"=>"Slide To Bottom",
						"slideright"=>"Slide To Right",
						"slideleft"=>"Slide To Left",
						"slidehorizontal"=>"Slide Horizontal (depending on Next/Previous)",
						"slidevertical"=>"Slide Vertical (depending on Next/Previous)",
						"boxslide"=>"Slide Boxes",
						"slotslide-horizontal"=>"Slide Slots Horizontal",
						"slotslide-vertical"=>"Slide Slots Vertical",
						"boxfade"=>"Fade Boxes",
						"slotfade-horizontal"=>"Fade Slots Horizontal",
						"slotfade-vertical"=>"Fade Slots Vertical",
						"fadefromright"=>"Fade and Slide from Right",
						"fadefromleft"=>"Fade and Slide from Left",
						"fadefromtop"=>"Fade and Slide from Top",
						"fadefrombottom"=>"Fade and Slide from Bottom",
						"fadetoleftfadefromright"=>"Fade To Left and Fade From Right",
						"fadetorightfadefromleft"=>"Fade To Right and Fade From Left",
						"fadetotopfadefrombottom"=>"Fade To Top and Fade From Bottom",
						"fadetobottomfadefromtop"=>"Fade To Bottom and Fade From Top",
						"parallaxtoright"=>"Parallax to Right",
						"parallaxtoleft"=>"Parallax to Left",
						"parallaxtotop"=>"Parallax to Top",
						"scaledownfromright"=>"Zoom Out and Fade From Right",
						"scaledownfromleft"=>"Zoom Out and Fade From Left",
						"scaledownfromtop"=>"Zoom Out and Fade From Top",
						"scaledownfrombottom"=>"Zoom Out and Fade From Bottom",
						"zoomout"=>"ZoomOut",
						"zoomin"=>"ZoomIn",
						"slotzoom-horizontal"=>"Zoom Slots Horizontal",
						"slotzoom-vertical"=>"Zoom Slots Vertical",
						"fade"=>"Fade",
						"random-static"=>"Random Flat",
						"random"=>"Random Flat and Premium",
						"curtain-1"=>"Curtain from Left",
						"curtain-2"=>"Curtain from Right",
						"curtain-3"=>"Curtain from Middle",
						"3dcurtain-horizontal"=>"3D Curtain Horizontal",
						"3dcurtain-vertical"=>"3D Curtain Vertical",
						"cube"=>"Cube Vertical",
						"cube-horizontal"=>"Cube Horizontal",
						"incube"=>"In Cube Vertical",
						"incube-horizontal"=>"In Cube Horizontal",
						"turnoff"=>"TurnOff Horizontal",
						"turnoff-vertical"=>"TurnOff Vertical",
						"papercut"=>"Paper Cut",
						"flyin"=>"Fly In",
						"random-premium"=>"Random Premium",
					);
					?>
					<?php echo pzen_draw_selectbox("trans_style",$trans_style_ar,$trans_style); ?>
				</div>
			</div>
			<div class="row">
				<label><?php echo PZEN_LABEL_SLIDESHOW_DATAMASTERSPEED; ?></label>
				<div class="cont">
					<?php echo pzen_draw_inputbox('data_masterspeed', $data_masterspeed,10); ?>
					<p class="notice"><?php echo PZEN_NOTICE_SLIDESHOW_DATAMASTERSPEED; ?></p>
				</div>
			</div>
			<div class="row">
				<label><?php echo PZEN_LABEL_SLIDESHOW_DELAY_BY_SLIDES; ?></label>
				<div class="cont">
					<?php echo pzen_draw_inputbox('data_delay', $data_delay,10); ?>
					<p class="notice"><?php echo PZEN_NOTICE_SLIDESHOW_DELAY_BY_SLIDES; ?></p>
				</div>
			</div>
			<div class="row">
				<label><?php echo PZEN_LABEL_SLIDESHOW_SLOTAMOUNT_BY_SLIDES; ?></label>
				<div class="cont">
					<?php echo pzen_draw_inputbox('data_slotamount', $data_slotamount,10); ?>
					<p class="notice"><?php echo PZEN_NOTICE_SLIDESHOW_SLOTAMOUNT_BY_SLIDES; ?></p>
				</div>
			</div>
			<div class="row">
				<label><?php echo PZEN_LABEL_SLIDESHOW_CAPTIONS; ?></label>
				<div class="cont">
					<?php
						// modified code for multi-language support
							for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
							  echo '<br />' . zen_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;';
							  echo zen_draw_textarea_field('slideshow_caption[' . $languages[$i]['id'] . ']', 'Desc', 38 , 5,  $slideshow_caption[$languages[$i]['id']] ,' class="noEditor md-input"', true);
							}
						// end modified code for multi-language support
					?>				
				</div>
			</div>
			<div class="row">
				<label><?php echo PZEN_LABEL_SLIDESHOW_TRANSTYLE_IMAGE_STARTEND; ?></label>
				<div class="cont">
					<?php
					$animation_inclass_ar=array(
						"sft"=>"Short from Top",
						"sfb"=>"Short from Bottom",
						"sfr"=>"Short from Right",
						"sfl"=>"Short from Left",
						"lft"=>"Long from Top",
						"lfb"=>"Long from Bottom",
						"lfr"=>"Long from Right",
						"lfl"=>"Long from Left",
						"skewfromleft"=>"Skew from Left",
						"skewfromright"=>"Skew from Right",
						"skewfromleftshort"=>"Skew Short from Left",
						"skewfromrightshort"=>"Skew Short from Right",
						"fade"=>"Fade",
						"randomrotate"=>"Fade in, Rotate from a Random position and Degree",
					);
					?>
					<?php echo pzen_draw_selectbox("in_animation_class",$animation_inclass_ar,$in_animation_class); ?>
					<p class="notice"><?php echo PZEN_NOTICE_SLIDESHOW_TRANSTYLE_IMAGE_STARTEND; ?></p>
				</div>
			</div>
			<div class="row">
				<label><?php echo PZEN_LABEL_SLIDESHOW_TRANSTYLE_IMAGE_TOPBOTTOM; ?></label>
				<div class="cont">
					<?php
					$animation_outclass_ar=array(
						"stt"=>"Short to Top",
						"stb"=>"Short to Bottom",
						"str"=>"Short to Right",
						"stl"=>"Short to Left",
						"ltt"=>"Long to Top",
						"ltb"=>"Long to Bottom",
						"ltr"=>"Long to Right",
						"ltl"=>"Long to Left",
						"skewtoleft"=>"Skew to Left",
						"skewtoright"=>"Skew to Right",
						"skewtoleftshort"=>"Skew Short to Left",
						"skewtorightshort"=>"Skew Short to Right",
						"fadeout"=>"Fade Out",
						"randomrotateout"=>"Fade in, Rotate from a Random position and Degree",
					);
					?>
					<?php echo pzen_draw_selectbox("out_animation_class",$animation_outclass_ar,$out_animation_class); ?>
					<p class="notice"><?php echo PZEN_NOTICE_SLIDESHOW_TRANSTYLE_IMAGE_TOPBOTTOM; ?></p>
				</div>
			</div>
			<div class="row">
				<label><?php echo PZEN_LABEL_SLIDESHOW_EASEIN_CAPTION; ?></label>
				<div class="cont">
					<?php
					$easein_ar=array(
						"default"=>"Default",
						"Linear.easeNone"=>"Linear.easeNone",
						"Power0.easeInOut"=>"Power0.easeInOut",
						"Power0.easeOut"=>"Power0.easeOut",
						"Power1.easeInOut"=>"Power1.easeInOut",
						"Power1.easeOut"=>"Power1.easeOut",
						"Power2.easeInOut"=>"Power2.easeInOut",
						"Power2.easeOut"=>"Power2.easeOut",
						"Power3.easeInOut"=>"Power3.easeInOut",
						"Power3.easeOut"=>"Power3.easeOut",
						"Power4.easeInOut"=>"Power4.easeInOut",
						"Power4.easeOut"=>"Power4.easeOut",
						"Quad.easeInOut"=>"Quad.easeInOut",
						"Quad.easeOut"=>"Quad.easeOut",
						"Cubic.easeInOut"=>"Cubic.easeInOut",
						"Cubic.easeOut"=>"Cubic.easeOut",
						"Quart.easeInOut"=>"Quart.easeInOut",
						"Quart.easeOut"=>"Quart.easeOut",
						"Quint.easeInOut"=>"Quint.easeInOut",
						"Quint.easeOut"=>"Quint.easeOut",
						"Strong.easeInOut"=>"Strong.easeInOut",
						"Strong.easeOut"=>"Strong.easeOut",
						"Back.easeInOut"=>"Back.easeInOut",
						"Back.easeOut"=>"Back.easeOut",
						"Bounce.easeInOut"=>"Bounce.easeInOut",
						"Bounce.easeOut"=>"Bounce.easeOut",
						"Circ.easeInOut"=>"Circ.easeInOut",
						"Circ.easeOut"=>"Circ.easeOut",
						"Elastic.easeInOut"=>"Elastic.easeInOut",
						"Elastic.easeOut"=>"Elastic.easeOut",
						"Expo.easeInOut"=>"Expo.easeInOut",
						"Expo.easeOut"=>"Expo.easeOut",
						"Sine.easeInOut"=>"Sine.easeInOut",
						"Sine.easeOut"=>"Sine.easeOut",
						"SlowMo.ease"=>"SlowMo.ease",
					);
					?>
					<?php echo pzen_draw_selectbox("ease_in",$easein_ar,$ease_in); ?>
					<p class="notice"><?php echo PZEN_NOTICE_SLIDESHOW_EASEIN_CAPTION; ?></p>
				</div>
			</div>
			<div class="row">
				<label><?php echo PZEN_LABEL_SLIDESHOW_EASEOUT_CAPTION; ?></label>
				<div class="cont">
					<?php
					$easeout_ar=array(
						"default"=>"Default",
						"Linear.easeNone"=>"Linear.easeNone",
						"Power0.easeInOut"=>"Power0.easeInOut",
						"Power0.easeIn"=>"Power0.easeIn",
						"Power1.easeInOut"=>"Power1.easeInOut",
						"Power1.easeIn"=>"Power1.easeIn",
						"Power2.easeInOut"=>"Power2.easeInOut",
						"Power2.easeIn"=>"Power2.easeIn",
						"Power3.easeInOut"=>"Power3.easeInOut",
						"Power3.easeIn"=>"Power3.easeIn",
						"Power4.easeInOut"=>"Power4.easeInOut",
						"Power4.easeIn"=>"Power4.easeIn",
						"Quad.easeInOut"=>"Quad.easeInOut",
						"Quad.easeIn"=>"Quad.easeIn",
						"Cubic.easeInOut"=>"Cubic.easeInOut",
						"Cubic.easeIn"=>"Cubic.easeIn",
						"Quart.easeInOut"=>"Quart.easeInOut",
						"Quart.easeIn"=>"Quart.easeIn",
						"Quint.easeInOut"=>"Quint.easeInOut",
						"Quint.easeIn"=>"Quint.easeIn",
						"Strong.easeInOut"=>"Strong.easeInOut",
						"Strong.easeIn"=>"Strong.easeIn",
						"Back.easeInOut"=>"Back.easeInOut",
						"Back.easeIn"=>"Back.easeIn",
						"Bounce.easeInOut"=>"Bounce.easeInOut",
						"Bounce.easeIn"=>"Bounce.easeIn",
						"Circ.easeInOut"=>"Circ.easeInOut",
						"Circ.easeIn"=>"Circ.easeIn",
						"Elastic.easeInOut"=>"Elastic.easeInOut",
						"Elastic.easeIn"=>"Elastic.easeIn",
						"Expo.easeInOut"=>"Expo.easeInOut",
						"Expo.easeIn"=>"Expo.easeIn",
						"Sine.easeInOut"=>"Sine.easeInOut",
						"Sine.easeIn"=>"Sine.easeIn",
						"SlowMo.ease"=>"SlowMo.ease",
					);
					?>
					<?php echo pzen_draw_selectbox("ease_out",$easeout_ar,$ease_out); ?>
					<p class="notice"><?php echo PZEN_NOTICE_SLIDESHOW_EASEOUT_CAPTION; ?></p>
				</div>
			</div>
			<div class="row">
				<label><?php echo PZEN_LABEL_SLIDESHOW_DATAX_CAPTION; ?></label>
				<div class="cont">
					<?php echo pzen_draw_inputbox("data_x",$data_x,10); ?>
					<p class="notice"><?php echo PZEN_NOTICE_SLIDESHOW_DATAX_CAPTION; ?></p>				
				</div>
			</div>
			<div class="row">
				<label><?php echo PZEN_LABEL_SLIDESHOW_DATAY_CAPTION; ?></label>
				<div class="cont">
					<?php echo pzen_draw_inputbox("data_y",$data_y,10); ?>
					<p class="notice"><?php echo PZEN_NOTICE_SLIDESHOW_DATAY_CAPTION; ?></p>				
				</div>
			</div>
			<div class="row">
				<label><?php echo PZEN_LABEL_SLIDESHOW_DATAHOFFSET_CAPTION; ?></label>
				<div class="cont">
					<?php echo pzen_draw_inputbox("data_hoffset",$data_hoffset,10); ?>
					<p class="notice"><?php echo PZEN_NOTICE_SLIDESHOW_DATAHOFFSET_CAPTION; ?></p>				
				</div>
			</div>
			<div class="row">
				<label><?php echo PZEN_LABEL_SLIDESHOW_DATAVOFFSET_CAPTION; ?></label>
				<div class="cont">
					<?php echo pzen_draw_inputbox("data_voffset",$data_voffset,10); ?>
					<p class="notice"><?php echo PZEN_NOTICE_SLIDESHOW_DATAVOFFSET_CAPTION; ?></p>				
				</div>
			</div>
			<div class="row">
				<label><?php echo PZEN_STATUS; ?></label>
				<div class="cont">
					<?php if($banner_status==''){$banner_status=1;} ?>
					<ul class="inline-ul">
						<li><input type="radio" name="slide_status" value="1" <?php echo ($slide_status==0)? '' : 'checked="checked"';  ?>  /><span><?php echo PZEN_ENABLE; ?></span></li>
						<li><input type="radio" name="slide_status" value="0" <?php echo ($slide_status==0)? 'checked="checked"' : '';  ?> /><span><?php echo PZEN_DISABLE; ?></span></li>
					</ul>
				</div>
			</div>
			<div class="row">
				<?php if(isset($_REQUEST['slideshow_eid'])){ ?>
				<input type="submit" name="update_pzen_slide" class="md-btn" value="<?php echo PZEN_UPDATE; ?>" />
				<input type='hidden' name='slideshow_eid' value="<?php if(isset($_REQUEST['slideshow_eid'])) echo $_REQUEST['slideshow_eid']; ?>" />
				<input type='hidden' name='sort_order' value="<?php if($sort_order) echo $sort_order; ?>" /> 
				<?php }else{?>
				<input type="submit" class="md-btn" name="submit_pzen_slide" value="<?php echo PZEN_SAVE; ?>" /><?php } ?>
				<input type="reset" class="md-btn" onclick="reset_function()" name="cancel_pzen_slide" value="<?php echo PZEN_CANCEL; ?>" />
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
	/* grab important elements */
	var sortInput_mainslider = jQuery('#psort_mainslider_order');
	//alert(JSON.stringify(sortInput));
	var submit = jQuery('#pautoSubmit');
	var messageBox = jQuery('#message-box');
	var list_mainslider = jQuery('.sort_list_mainslider');
	if(list_mainslider.children('li').size()>1){
		/* create requesting function to avoid duplicate code */
		var request_mainslider = function(){
			jQuery.ajax({
				beforeSend: function() {
					messageBox.text('Updating the sort order in the database.');
				},
				complete: function() {
					var xmlhttp
					var table_name="<?php echo TABLE_PZEN_SLIDER; ?>";
					var po_list=document.getElementById('psort_mainslider_order').value;
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
				data: 'sort_order=' + sortInput_mainslider[0].value + '&ajax=' + submit[0].checked + '&do_submit=1&byajax=1', //need [0]?
				type: 'post',
				url: '<?php echo $_SERVER["REQUEST_URI"]; ?>'
			});
		};
		var fnSubmit_mainslider = function(save) {
			var sortOrder = [];
			list_mainslider.children('li').each(function(){
				sortOrder.push(jQuery(this).data('id'));
			});
			sortInput_mainslider.val(sortOrder.join(','));
				console.log(sortInput_mainslider.val());
			if(save) {
				request_mainslider();
			}
		};
	/* store values */
		list_mainslider.children('li').each(function() {
			var li = jQuery(this);
				li.data('id',li.attr('id')).attr('id','');
		});
		list_mainslider.disableSelection();
	/* sortables */
		list_mainslider.sortable({
			containment: "parent",
			opacity: 0.7,
			update: function() {
				fnSubmit_mainslider(submit[0].checked);
			}
		});
		
	/* ajax form submission */
		jQuery('#sort_form_mainslider').bind('submit',function(e) {
			if(e) e.preventDefault();
				fnSubmit_mainslider(true);
		});
	}
});
</script>
<?php } ?>