<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2004 The zen-cart developers                           |
// |                                                                      |
// | http://www.zen-cart.com/index.php                                    |
// |                                                                      |
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
// $Id:easypopulate.php,v1.2.5.4 2005/09/26 langer $
// 
// v1.2.5.5 2006/12/01 oeginc
//
// v1.2.5.5.csv 2009/01/06 phazei
//
// v1.2.5.6.csv 2009/06/19 pickupman
//
// v1.2.5.7.csv 2009/10/29 gizmus
//
//
//*******************************
//*******************************
// C O N F I G U R A T I O N
// V A R I A B L E S
//*******************************
//*******************************


//CSV VARIABLES
$csv_deliminator = ","; // "\t" for tab
$csv_enclosure = '"'; //if want none, change to space.

/* put below
@set_time_limit(1200);
@ini_set('max_input_time','1200');
//*/
/**
* Advanced Smart Tags - activated/de-activated in Zencart Admin
*/

// only activate advanced tags if you really know what you are doing, and understand regular expressions. Disable if things go awry.
// If you wish to add your own smart-tags below, please ensure that you understand the following:
// 1) ensure that the expressions you use avoid repetitive behaviour from one upload to the next using existing data, as you may end up with this sort of thing:
//   <b><b><b><b>thing</b></b></b></b> ...etc for each update. This is caused for each output that qualifies as an input for any expression..
// 2) remember to place the tags in the order that you want them to occur, as each is done in turn and may remove characters you rely on for a later tag
// 3) the $smart_tags array above is the last to be executed, so you have all of your carriage-returns and line-breaks to play with below
// 4) make sure you escape the following metacharacters if you are using them as string literals: ^  $  \  *  +  ?  (  )  |  .  [  ]  / etc..
// The following examples should get your blood going... comment out those you do not want after enabling $strip_advanced_smart_tags = true above
// for regex help see: http://www.quanetic.com/regex.php or http://www.regular-expressions.info
$advanced_smart_tags = array(
										// replaces "Description:" at beginning of new lines with <br /> and same in bold
										"\r\nDescription:|\rDescription:|\nDescription:" => '<br /><b>Description:</b>',
										
										// replaces at beginning of description fields "Description:" with same in bold
										"^Description:" => '<b>Description:</b>',
										
										// just make "Description:" bold wherever it is...must use both lines to prevent duplicates!
										//"<b>Description:<\/b>" => 'Description:',
										//"Description:" => '<b>Description:</b>',
										
										// replaces "Specification:" at beginning of new lines with <br /> and same in bold.
										"\r\nSpecifications:|\rSpecifications:|\nSpecifications:" => '<br /><b>Specifications:</b>',
										
										// replaces at beginning of descriptions "Specifications:" with same in bold
										"^Specifications:" => '<b>Specifications:</b>',
										
										// just make "Specifications:" bold wherever it is...must use both lines to prevent duplicates!
										//"<b>Specifications:<\/b>" => 'Specifications:',
										//"Specifications:" => '<b>Specifications:</b>',
										
										// replaces in descriptions any asterisk at beginning of new line with a <br /> and a bullet.
										"\r\n\*|\r\*|\n\*" => '<br />&bull;',
										
										// replaces in descriptions any asterisk at beginning of descriptions with a bullet.
										"^\*" => '&bull;',
										
										// returns/newlines in description fields replaced with space, rather than <br /> further below
										//"\r\n|\r|\n" => ' ',
										
										// the following should produce paragraphs between double breaks, and line breaks for returns/newlines
										"^<p>" => '', // this prevents duplicates
										"^" => '<p>',
										//"^<p style=\"desc-start\">" => '', // this prevents duplicates
										//"^" => '<p style="desc-start">',
										"<\/p>$" => '', // this prevents duplicates
										"$" => '</p>',
										"\r\n\r\n|\r\r|\n\n" => '</p><p>',
										// if not using the above 5(+2) lines, use the line below instead..
										//"\r\n\r\n|\r\r|\n\n" => '<br /><br />',
										"\r\n|\r|\n" => '<br />',
										
										// ensures "Description:" followed by single <br /> is fllowed by double <br />
										"<b>Description:<\/b><br \/>" => '<br /><b>Description:</b><br /><br />',
										);
										

//*******************************
//*******************************
// E N D
// C O N F I G U R A T I O N
// V A R I A B L E S
//*******************************
//*******************************


//*******************************
//*******************************
// S T A R T
// INITIALIZATION
//*******************************

require_once ('includes/application_top.php');

@set_time_limit(1200);
@ini_set('max_input_time','1200');

/*
* Add your custom fields to this array
*
* 	these will automatically add the fields
*	in the necessary sql statement and other arrays
*	functions both import and export

*	NOTE: Currently just works on TABLE_PRODUCTS
*/
$custom_fields = array();

if(strlen(EASYPOPULATE_CONFIG_CUSTOM_FIELDS) > 0)
{
	$custom_fields = explode(',',EASYPOPULATE_CONFIG_CUSTOM_FIELDS);
}

/**
* Config translation layer..
*/
// note - not all config defines are in below...
$tempdir = EASYPOPULATE_CONFIG_TEMP_DIR;
$ep_date_format = EASYPOPULATE_CONFIG_FILE_DATE_FORMAT;
$ep_raw_time = EASYPOPULATE_CONFIG_DEFAULT_RAW_TIME;
$ep_debug_logging = ((EASYPOPULATE_CONFIG_DEBUG_LOGGING == 'true') ? true : false);
$maxrecs = EASYPOPULATE_CONFIG_SPLIT_MAX;
$price_with_tax = ((EASYPOPULATE_CONFIG_PRICE_INC_TAX == 'true') ? true : false);
$max_categories = EASYPOPULATE_CONFIG_MAX_CATEGORY_LEVELS;
$strip_smart_tags = ((EASYPOPULATE_CONFIG_SMART_TAGS == 'true') ? true : false);
// may make it optional for user to use their own names for these EP tasks..
//$active = 'Active';
//$inactive = 'Inactive';
//$deleteit = 'Delete';

// attributes array?

/**
* Test area start
*/
//error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);//test purposes only
//register_globals_vars_check ();// test purposes only
//$maxrecs = 4; // for testing
// usefull stuff: mysql_affected_rows(), mysqli_num_rows().
$ep_debug_logging_all = false; // do not comment out.. make false instead
//$sql_fail_test == true; // used to cause an sql error on new product upload - tests error handling & logs
/*
* Test area end
**/

//phazei
//** required for PHP < 5.1
if (!function_exists('fputcsv')) {
    function fputcsv(&$handle, $fields = array(), $delimiter = ',', $enclosure = '"') {
        $str = '';
        $escape_char = '\\';
        foreach ($fields as $value) {
            settype($value, 'string');
            if (strpos($value, $delimiter) !== false ||
                strpos($value, $enclosure) !== false ||
                strpos($value, "\n") !== false ||
                strpos($value, "\r") !== false ||
                strpos($value, "  ") !== false ||
                strpos($value, ' ') !== false) {
                
                $str2 = $enclosure;
                $escaped = 0;
                $len = strlen($value);
                for ($i=0;$i<$len;$i++) {
                    if ($value[$i] == $escape_char) {
                        $escaped = 1;
                    } else if (!$escaped && $value[$i] == $enclosure) {
                        $str2 .= $enclosure;
                    } else {
                        $escaped = 0;
                    }
                    $str2 .= $value[$i];
                }
                $str2 .= $enclosure;
                $str .= $str2.$delimiter;
            } else {
                $str .= $value.$delimiter;
            }
        }
        $str = substr($str,0,-1);
        $str .= "\n";
        return fwrite($handle, $str);
    }
}  

//used for froogle
function kill_breaks($thing) {
	//kills all line breaks and tabs
	if (is_array($thing)) return array_map("kill_breaks", $thing);
	return str_replace(array("\r","\n","\t")," ",$thing);
}


/**
* Initialise vars
*/

// Current EP Version
$curver = 'For ZenCart v1.5.x';

$con = mysqli_connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD);
$display_output = '';
$ep_dltype = NULL;
$ep_dlmethod = NULL;
$chmod_check = true;
$ep_stack_sql_error = false; // function returns true on any 1 error, and notifies user of an error
$specials_print = EASYPOPULATE_SPECIALS_HEADING;
$replace_quotes = false; // langer - this is probably redundant now...retain here for now..
$products_with_attributes = false; // langer - this will be redundant after html renovation
// maybe below can go in array eg $ep_processed['attributes'] = true, etc.. cold skip all post-upload tasks on check if isset var $ep_processed.
$has_attributes == false;
$has_specials == false;

// define(EASYPOPULATE_CONFIG_COL_DELIMITER, "\t");
$separator = "\t"; // only tab allowed at present

// all mods go in this array as 'name' => 'true' if exist. eg $ep_supported_mods['psd'] => true means it exists.
// langer - scan array in future to reveal if any mods for inclusion in downloads
$ep_supported_mods = array();

// config keys array - must contain any expired keys to ensure they are deleted on install or removal
$ep_keys = array('EASYPOPULATE_CONFIG_TEMP_DIR',
								'EASYPOPULATE_CONFIG_FILE_DATE_FORMAT',
								'EASYPOPULATE_CONFIG_DEFAULT_RAW_TIME',
								'EASYPOPULATE_CONFIG_CUSTOM_FIELDS',
								'EASYPOPULATE_CONFIG_SPLIT_MAX',
								'EASYPOPULATE_CONFIG_MAX_CATEGORY_LEVELS',
								'EASYPOPULATE_CONFIG_PRICE_INC_TAX',
								'EASYPOPULATE_CONFIG_ZERO_QTY_INACTIVE',
								'EASYPOPULATE_CONFIG_SMART_TAGS',
								'EASYPOPULATE_CONFIG_ADV_SMART_TAGS',
								'EASYPOPULATE_CONFIG_DEBUG_LOGGING',
								);

// default smart-tags setting when enabled. This can be added to.
$smart_tags = array("\r\n|\r|\n" => '<br />',
										);

if (substr($tempdir, -1) != '/') $tempdir .= '/';
if (substr($tempdir, 0, 1) == '/') $tempdir = substr($tempdir, 1);

$ep_debug_log_path = DIR_FS_CATALOG . $tempdir;

if ($ep_debug_logging_all == true) {
$fp = fopen($ep_debug_log_path . 'ep_debug_log.txt','w'); // new blank log file on each page impression for full testing log (too big otherwise!!)
fclose($fp);
}

/**
* Pre-flight checks start here
*/

// temp folder exists & permissions check & adjust if we can
// lets check our config is installed 1st..
// when installing, we skip these tests..
if (EASYPOPULATE_CONFIG_TEMP_DIR == 'EASYPOPULATE_CONFIG_TEMP_DIR' && ($_GET['langer'] != 'install' or $_GET['langer'] != 'installnew')) {
	// admin area config not installed
	$messageStack->add(sprintf(EASYPOPULATE_MSGSTACK_INSTALL_KEYS_FAIL, '<a href="' . zen_href_link(FILENAME_EASYPOPULATE, 'langer=installnew') . '">', '</a>'), 'warning');
} elseif ($_GET['langer'] != 'install' && $_GET['langer'] != 'installnew') {
	ep_chmod_check ($tempdir);
}

// installation start
if ($_GET['langer'] == 'install' or $_GET['langer'] == 'installnew') {
	if ($_GET['langer'] == 'installnew') {
		// remove any old config..
		remove_easypopulate();
		// install new config
		install_easypopulate();
		zen_redirect(zen_href_link(FILENAME_EASYPOPULATE, 'langer=install'));
	}
	
	$chmod_check = ep_chmod_check($tempdir);
	if ($chmod_check == false) {
		// no temp dir, so template download wont work..
		$messageStack->add(EASYPOPULATE_MSGSTACK_INSTALL_CHMOD_FAIL, 'caution');
	} else {
		// chmod success
		if (defined('EASYPOPULATE_MSGSTACK_LANGER') && strpos(EASYPOPULATE_MSGSTACK_LANGER, 'paypal@portability.com.au') == true) {
			$messageStack->add(EASYPOPULATE_MSGSTACK_LANGER, 'caution');
		} else {
			$messageStack->add('EasyPopulate support & development by <b>langer</b>. Donations are always appreciated to support continuing development: paypal@portability.com.au', 'caution');
		}
		// lets do a full download to the temp file
		$ep_dltype = 'full';
		$ep_dlmethod = 'tempfile';
		$messageStack->add(EASYPOPULATE_MSGSTACK_INSTALL_CHMOD_SUCCESS, 'success');
	}
	//zen_redirect(zen_href_link(FILENAME_EASYPOPULATE));
	
	// attempt to delete redundant files from previous versions v1.2.5.2 and lower
	// delete easypopulate_functions from admin dir
	$return = @unlink('easypopulate_functions.php');
	if($return == true) $messageStack->add(sprintf(EASYPOPULATE_MSGSTACK_INSTALL_DELETE_SUCCESS, 'easypopulate_functions.php', 'ADMIN'), 'success');
	$return = @unlink('includes/boxes/extra_boxes/populate_tools_dhtml.php');
	if($return == true) {
		$messageStack->add(sprintf(EASYPOPULATE_MSGSTACK_INSTALL_DELETE_SUCCESS, 'populate_tools_dhtml.php', '/includes/boxes/extra_boxes/'), 'success');
	} else {
		// delete populate_tools_dhtml.php from extra boxes failed. Tell user to delete it, otherwise it shows in DHTML menu.
		if (@is_file(includes/boxes/extra_boxes/populate_tools_dhtml.php)) $messageStack->add(sprintf(EASYPOPULATE_MSGSTACK_INSTALL_DELETE_FAIL, 'populate_tools_dhtml.php', '/includes/boxes/extra_boxes/'), 'caution');
	}
	
} elseif ($_GET['langer'] == 'remove') {
	remove_easypopulate();
	zen_redirect(zen_href_link(FILENAME_EASYPOPULATE));
}
// end installation/removal

/**
* START check for existance of various mods
*/

// $ep_supported_mods['psd'] = ep_field_name_exists(TABLE_PRODUCTS_DESCRIPTION,'products_short_desc') ? 'Product Short Descriptions' : NULL; // this will mean if isset, we have it, and the array has the name for html display
$ep_supported_mods['psd'] = ep_field_name_exists(TABLE_PRODUCTS_DESCRIPTION,'products_short_desc');

// others go here..

/**
* END check for existance of various mods
*/

if (EASYPOPULATE_CONFIG_ADV_SMART_TAGS == 'true') $smart_tags = array_merge($advanced_smart_tags,$smart_tags);

// maximum length for a category in this database
$category_strlen_max = zen_field_length(TABLE_CATEGORIES_DESCRIPTION, 'categories_name');

// model name length error handling
$model_varchar = zen_field_length(TABLE_PRODUCTS, 'products_model');
if (!isset($model_varchar)) {
	$messageStack->add(EASYPOPULATE_MSGSTACK_MODELSIZE_DETECT_FAIL, 'warning');
	$modelsize = 32;
} else {
	$modelsize = $model_varchar;
}
//echo $modelsize;

/**
* Pre-flight checks finish here
*/

// now to create the file layout for each download type..

// VJ product attributes begin
// this creates our attributes array
$attribute_options_array = array();

if (is_array($attribute_options_select) && (count($attribute_options_select) > 0)) {
	// this limits the size of files where there are many options/attributes
	// Maybe we can automatically creat multiple files where column count is likely to exceed 256?
	foreach ($attribute_options_select as $value) {
		$attribute_options_query = "select distinct products_options_id from " . DB_DATABASE . "." . TABLE_PRODUCTS_OPTIONS . " where products_options_name = '" . zen_db_input($value) . "'";
		$attribute_options_values = ep_query($con,$attribute_options_query);

		if ($attribute_options = mysqli_fetch_array($attribute_options_values)){
			$attribute_options_array[] = array('products_options_id' => $attribute_options['products_options_id']);
		}
	}
} else {
	$attribute_options_query = "select distinct products_options_id from " . DB_DATABASE . "." . TABLE_PRODUCTS_OPTIONS . " order by products_options_id";
	$attribute_options_values = ep_query($con,$attribute_options_query);

	while ($attribute_options = mysqli_fetch_array($attribute_options_values)){
		$attribute_options_array[] = array('products_options_id' => $attribute_options['products_options_id']);
	}
}
// VJ product attributes end


//elari check default language_id from configuration table DEFAULT_LANGUAGE
$epdlanguage_query = ep_query($con,"select languages_id, name from " . DB_DATABASE . "." . TABLE_LANGUAGES . " where code = 'en'");
if (mysqli_num_rows($epdlanguage_query)) {
	$epdlanguage = mysqli_fetch_array($epdlanguage_query);
	$epdlanguage_id   = $epdlanguage['languages_id'];
	$epdlanguage_name = $epdlanguage['name'];
} else {
	//$messageStack->add('', 'warning'); // langer - this will never occur..
	echo 'Strange but there is no default language to work... That may not happen, just in case...';
}

$langcode = array();
$languages_query = ep_query($con,"select languages_id, code from " . DB_DATABASE . "." . TABLE_LANGUAGES . " order by sort_order");
// start array at one, the rest of the code expects it that way
$ll =1;
while ($ep_languages = mysqli_fetch_array($languages_query)) {
	//will be used to return language_id en language code to report in product_name_code instead of product_name_id
	$ep_languages_array[$ll++] = array(
				'id' => $ep_languages['languages_id'],
				'code' => $ep_languages['code']
				);
}
$langcode = $ep_languages_array;

$ep_dltype = (isset($_GET['dltype'])) ? $_GET['dltype'] : $ep_dltype;

if (zen_not_null($ep_dltype)) {
	
	// if dltype is set, then create the filelayout.  Otherwise it gets read from the uploaded file
	// ep_create_filelayout($dltype); // get the right filelayout for this download. langer - redundant function call..

	// depending on the type of the download the user wanted, create a file layout for it.

	$filelayout = array();
	$fileheaders = array();
	switch($ep_dltype){
	case 'full':
	
		$fileMeta = array();

		// The file layout is dynamically made depending on the number of languages

		$filelayout[] = "v_products_model";
		$filelayout[] = "v_products_image";

			
	 	$fileMeta[] = 'v_metatags_products_name_status';
		$fileMeta[] = 'v_metatags_title_status';
		$fileMeta[] = 'v_metatags_model_status';
		$fileMeta[] = 'v_metatags_price_status';
		$fileMeta[] = 'v_metatags_title_tagline_status';

		foreach ($langcode as $key => $lang){
			$l_id = $lang['id'];
			
			
			$filelayout[] = 'v_products_name_' . $l_id;
			$filelayout[] = 'v_products_description_' . $l_id;
			if ($ep_supported_mods['psd'] == true)
				$filelayout[] = 'v_products_short_desc_' . $l_id;
			$filelayout[] = 'v_products_url_' . $l_id;

			// uncomment the head_title, head_desc, and head_keywords to use
			// Linda's Header Tag Controller 2.0

			//$filelayout[] = 'v_products_head_title_tag_'.$l_id;
			//$filelayout[] = 'v_products_head_desc_tag_'.$l_id;
			//$filelayout[] = 'v_products_head_keywords_tag_'.$l_id;
			
			$fileMeta[] = 'v_metatags_title_' . $l_id;
			$fileMeta[] = 'v_metatags_keywords_' . $l_id;
			$fileMeta[] = 'v_metatags_description_' . $l_id;
					
		}
		
		// uncomment the customer_price and customer_group to support multi-price per product contrib
		
		// langer - specials added below

		$filelayout[] = 'v_specials_price';
		$filelayout[] = 'v_specials_last_modified';
		$filelayout[] = 'v_specials_expires_date';
		$filelayout[] = 'v_products_price';
		$filelayout[] = 'v_products_weight';
		$filelayout[] = 'v_last_modified';
		$filelayout[] = 'v_date_added';
		$filelayout[] = 'v_products_quantity';

		
		if ($products_with_attributes == true) {
			//include attributes in full download if config is true
			// VJ product attribs begin

			$languages = zen_get_languages();

			$attribute_options_count = 1;
			foreach ($attribute_options_array as $attribute_options_values) {
				$key1 = 'v_attribute_options_id_' . $attribute_options_count;
				$filelayout[] = $key1;

				for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
					$l_id = $languages[$i]['id'];
					$key2 = 'v_attribute_options_name_' . $attribute_options_count . '_' . $l_id;
					$filelayout[] = $key2;
				}

				$attribute_values_query = "select products_options_values_id  from " . DB_DATABASE . "." .TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " where products_options_id = '" . (int)$attribute_options_values['products_options_id'] . "' order by products_options_values_id";
				$attribute_values_values = ep_query($con,$attribute_values_query);

				$attribute_values_count = 1;
				while ($attribute_values = mysqli_fetch_array($attribute_values_values)) {
					$key3 = 'v_attribute_values_id_' . $attribute_options_count . '_' . $attribute_values_count;
					$filelayout[] = $key3;

					$key4 = 'v_attribute_values_price_' . $attribute_options_count . '_' . $attribute_values_count;
					$filelayout[] = $key4;

					for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
						$l_id = $languages[$i]['id'];

						$key5 = 'v_attribute_values_name_' . $attribute_options_count . '_' . $attribute_values_count . '_' . $l_id;
						$filelayout[] = $key5;
					}

					$attribute_values_count++;
				}

				$attribute_options_count++;
			}
		// VJ product attribs end
		}
		
		$filelayout[] = 'v_manufacturers_name';
		
		// build the categories name section of the array based on the number of categores the user wants to have
		for($i=1;$i<$max_categories+1;$i++){
			$filelayout[] = 'v_categories_name_' . $i;
		}

		$filelayout[] = 'v_tax_class_title';
		$filelayout[] = 'v_status';
		
		/*
		*
		*	BOF Added custom fields
		*
		*/
		$custom_layout_sql = ' ';
		if(count($custom_fields) > 0)
		{
			
			foreach($custom_fields as $f)
			{
				$filelayout[] = 'v_'.$f;
				$custom_filelayout_sql .= ', p.'.$f.' as v_'.$f.' ';
			}
		}
		
		//$custom_filelayout_sql = ', p.product_is_always_free_shipping as v_product_is_always_free_shipping, p.products_glsalesaccount as v_products_glsalesaccount, p.products_family as v_products_family ';
		/*
		*
		*	EOF Added custom fields
		*
		*/
		
		
		$filelayout = array_merge($filelayout, $fileMeta);


		$filelayout_sql = "SELECT
			p.products_id as v_products_id,
			p.products_model as v_products_model,
			p.products_image as v_products_image,
			p.products_price as v_products_price,
			p.products_weight as v_products_weight,
			p.products_last_modified as v_last_modified,
			p.products_date_added as v_date_added,
			p.products_tax_class_id as v_tax_class_id,
			p.products_quantity as v_products_quantity,
			p.manufacturers_id as v_manufacturers_id,
			subc.categories_id as v_categories_id,
			p.products_status as v_status,
			p.metatags_title_status as v_metatags_title_status,
			p.metatags_products_name_status as v_metatags_products_name_status,
			p.metatags_model_status as v_metatags_model_status,
			p.metatags_price_status as v_metatags_price_status,
			p.metatags_title_tagline_status as v_metatags_title_tagline_status".
			$custom_filelayout_sql.
			" FROM
			". DB_DATABASE . ".".TABLE_PRODUCTS." as p,
			". DB_DATABASE . ".".TABLE_CATEGORIES." as subc,
			". DB_DATABASE . ".".TABLE_PRODUCTS_TO_CATEGORIES." as ptoc
			WHERE
			p.products_id = ptoc.products_id AND
			ptoc.categories_id = subc.categories_id
			";
		//echo $filelayout_sql;


		break;
	case 'priceqty':

		// uncomment the customer_price and customer_group to support multi-price per product contrib
		$filelayout[] = 'v_products_model';
		$filelayout[] = 'v_specials_price';
		$filelayout[] = 'v_specials_date_avail';
		$filelayout[] = 'v_specials_expires_date';
		$filelayout[] = 'v_products_price';
		$filelayout[] = 'v_products_quantity';
		
		/*
		$filelayout[] = 'v_customer_price_1';
		$filelayout[] = 'v_customer_group_id_1';
		$filelayout[] = 'v_customer_price_2';
		$filelayout[] = 'v_customer_group_id_2';
		$filelayout[] = 'v_customer_price_3';
		$filelayout[] = 'v_customer_group_id_3';
		$filelayout[] = 'v_customer_price_4';
		$filelayout[] = 'v_customer_group_id_4';
		$filelayout[] = 'v_last_modified';
		$filelayout[] = 'v_status';
		//*/

		$filelayout_sql = "SELECT
			p.products_id as v_products_id,
			p.products_model as v_products_model,
			p.products_price as v_products_price,
			p.products_tax_class_id as v_tax_class_id,
			p.products_quantity as v_products_quantity
			FROM
			". DB_DATABASE . ".".TABLE_PRODUCTS." as p
			";

		break;
		
	case 'modqty':

		// uncomment the customer_price and customer_group to support multi-price per product contrib
		$filelayout[] = 'v_products_model';
		$filelayout[] = 'v_products_price';
		$filelayout[] = 'v_products_quantity';
		$filelayout[] = 'v_last_modified';
		$filelayout[] = 'v_status';
		
		/*
		$filelayout[] = 'v_customer_price_1';
		$filelayout[] = 'v_customer_group_id_1';
		$filelayout[] = 'v_customer_price_2';
		$filelayout[] = 'v_customer_group_id_2';
		$filelayout[] = 'v_customer_price_3';
		$filelayout[] = 'v_customer_group_id_3';
		$filelayout[] = 'v_customer_price_4';
		$filelayout[] = 'v_customer_group_id_4';
		$filelayout[] = 'v_last_modified';
		$filelayout[] = 'v_status';
		//*/

		$filelayout_sql = "SELECT
			p.products_id as v_products_id,
			p.products_model as v_products_model,
			p.products_price as v_products_price,
			p.products_quantity as v_products_quantity,
			p.products_last_modified as v_last_modified,
			p.products_status as v_status
			FROM
			". DB_DATABASE . ".".TABLE_PRODUCTS." as p
			";

		break;

	case 'category':
		// The file layout is dynamically made depending on the number of languages
		
		$filelayout[] = 'v_products_model';

		// build the categories name section of the array based on the number of categores the user wants to have
		for($i=1;$i<$max_categories+1;$i++){
			$filelayout[] = 'v_categories_name_' . $i;
		}


		$filelayout_sql = "SELECT
			p.products_id as v_products_id,
			p.products_model as v_products_model,
			subc.categories_id as v_categories_id
			FROM
			". DB_DATABASE . ".".TABLE_PRODUCTS." as p,
			". DB_DATABASE . ".".TABLE_CATEGORIES." as subc,
			". DB_DATABASE . ".".TABLE_PRODUCTS_TO_CATEGORIES." as ptoc      
			WHERE
			p.products_id = ptoc.products_id AND
			ptoc.categories_id = subc.categories_id
			";
		break;

	case 'froogle':
		// this is going to be a little interesting because we need
		// a way to map from internal names to external names
		//
		// Before it didn't matter, but with froogle needing particular headers,
		// The file layout is dynamically made depending on the number of languages

		//phazei - made it simpler to see the mapping of headers
		
		$filetemp = array();
		
		$filetemp['product_url'] = 'v_froogle_products_url_1';
		$filetemp['name'] = 'v_froogle_products_name_1';
		$filetemp['description'] = 'v_froogle_products_description_1';
		$filetemp['price'] = 'v_products_price';
		$filetemp['image_url'] = 'v_products_fullpath_image';
		$filetemp['category'] = 'v_category_fullpath';
		$filetemp['offer_id'] = 'v_froogle_offer_id';
		$filetemp['instock'] = 'v_froogle_instock';
		$filetemp['shipping'] = 'v_froogle_shipping';
		$filetemp['brand'] = 'v_manufacturers_name';
		$filetemp['upc'] = 'v_froogle_upc';
		//$filetemp['color'] = 'v_froogle_color';
		//$filetemp['size'] = 'v_froogle_size';
		//$filetemp['quantity'] = 'v_froogle_quantitylevel';
		//$filetemp['product_id'] = 'v_froogle_product_id';
		$filetemp['manufacturer_id'] = 'v_froogle_manufacturer_id';
		//$filetemp['exp_date'] = 'v_froogle_exp_date';
		$filetemp['product_type'] = 'v_froogle_product_type';
		//$filetemp['delete'] = 'v_froogle_delete';
		$filetemp['currency'] = 'v_froogle_currency';
		
		
		$fileheaders = array_keys($filetemp);
		$filelayout = array_values($filetemp);
		
		$filelayout_sql = "SELECT
			p.products_id as v_products_id,
			p.products_model as v_products_model,
			p.products_image as v_products_image,
			p.products_price as v_products_price,
			p.products_weight as v_products_weight,
			p.products_date_added as v_date_added,
			p.products_last_modified as v_last_modified,
			p.products_tax_class_id as v_tax_class_id,
			p.products_quantity as v_products_quantity,
			p.manufacturers_id as v_manufacturers_id,
			subc.categories_id as v_categories_id".
			$custom_filelayout_sql.
			" FROM
			". DB_DATABASE . ".".TABLE_PRODUCTS." as p,
			". DB_DATABASE . ".".TABLE_CATEGORIES." as subc,
			". DB_DATABASE . ".".TABLE_PRODUCTS_TO_CATEGORIES." as ptoc
			WHERE
			p.products_id = ptoc.products_id AND
			ptoc.categories_id = subc.categories_id AND
			p.products_status = '1'
			";
		break;

// VJ product attributes begin
	case 'attrib':
		
		$filelayout[] = 'v_products_model';

		$languages = zen_get_languages();

		$attribute_options_count = 1;
		foreach ($attribute_options_array as $attribute_options_values) {
			$key1 = 'v_attribute_options_id_' . $attribute_options_count;
			$filelayout[] = $key1;

			for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
				$l_id = $languages[$i]['id'];

				$key2 = 'v_attribute_options_name_' . $attribute_options_count . '_' . $l_id;
				$filelayout[] = $key2;
			}

			$attribute_values_query = "select products_options_values_id  from " . DB_DATABASE . "." . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " where products_options_id = '" . (int)$attribute_options_values['products_options_id'] . "' order by products_options_values_id";
			$attribute_values_values = ep_query($con,$attribute_values_query);

			$attribute_values_count = 1;
			while ($attribute_values = mysqli_fetch_array($attribute_values_values)) {
				$key3 = 'v_attribute_values_id_' . $attribute_options_count . '_' . $attribute_values_count;
				$filelayout[] = $key3;

				$key4 = 'v_attribute_values_price_' . $attribute_options_count . '_' . $attribute_values_count;
				$filelayout[] = $key4;

				for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
					$l_id = $languages[$i]['id'];

					$key5 = 'v_attribute_values_name_' . $attribute_options_count . '_' . $attribute_values_count . '_' . $l_id;
					$filelayout[] = $key5;
				}

				$attribute_values_count++;
			}

			$attribute_options_count++;
		}

		$filelayout_sql = "SELECT
			p.products_id as v_products_id,
			p.products_model as v_products_model
			FROM
			". DB_DATABASE . "." . TABLE_PRODUCTS ." as p
			";

		break;
// VJ product attributes end
	}

	$filelayout = array_flip($filelayout);
	$fileheaders = array_flip($fileheaders);
	$filelayout_count = count($filelayout);

}

//*******************************
//*******************************
// E N D
// INITIALIZATION
//*******************************
//*******************************

$ep_dlmethod = isset($_GET['download']) ? $_GET['download'] : $ep_dlmethod;
if ($ep_dlmethod == 'stream' or  $ep_dlmethod == 'tempfile'){
	//*******************************
	//*******************************
	// DOWNLOAD FILE
	//*******************************
	//*******************************
	$filestring = ""; // this holds the csv file we want to download

	//if ($_GET['dltype']=='froogle'){
		// set the things froogle wants at the top of the file
//    $filestring .= " html_escaped=YES\n";
//    $filestring .= " updates_only=NO\n";
//    $filestring .= " product_type=OTHER\n";
//    $filestring .= " quoted=YES\n";
	//}
	$result = ep_query($con,$filelayout_sql);


	// Here we need to allow for the mapping of internal field names to external field names
	// default to all headers named like the internal ones
	// the field mapping array only needs to cover those fields that need to have their name changed
	if (count($fileheaders) != 0 ) {
		$filelayout_header = $fileheaders; // if they gave us fileheaders for the dl, then use them; langer - (froogle only??)
	} else {
		$filelayout_header = $filelayout; // if no mapping was spec'd use the internal field names for header names
	}
	//We prepare the table heading with layout values

	$filestring = array();
	$filestring[] = array_keys($filelayout_header);
	
	///////
	$num_of_langs = count($langcode);
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		// if the filelayout says we need a products_name, get it
		// build the long full froogle image path
		
		// check for a large image else use medium else use small else no link
		// thanks to Tim Kroeger - www.breakmyzencart.com
		$products_image = (($row['v_products_image'] == PRODUCTS_IMAGE_NO_IMAGE) ? '' : $row['v_products_image']);
		$products_image_extension = substr($products_image, strrpos($products_image, '.'));
		$products_image_base = preg_replace($products_image_extension . '$', '', $products_image);
		$products_image_medium = $products_image_base . IMAGE_SUFFIX_MEDIUM . $products_image_extension;
		$products_image_large = $products_image_base . IMAGE_SUFFIX_LARGE . $products_image_extension;
		if (!file_exists(DIR_FS_CATALOG_IMAGES . 'large/' . $products_image_large)) {
			if (!file_exists(DIR_FS_CATALOG_IMAGES . 'medium/' . $products_image_medium)) {
				$image_url = (($products_image == '') ? '' : DIR_WS_CATALOG_IMAGES . $products_image);
			} else {
				$image_url = DIR_WS_CATALOG_IMAGES . 'medium/' . $products_image_medium;
			}
		} else {
			$image_url = DIR_WS_CATALOG_IMAGES . 'large/' . $products_image_large;
		}
		
		$row['v_products_fullpath_image'] = $image_url;
		
		// Other froogle defaults go here for now
		$row['v_froogle_instock']     = 'Y';
		$row['v_froogle_shipping']    = '';
		$row['v_froogle_upc']       = '';
//		$row['v_froogle_color']     = '';
//		$row['v_froogle_size']      = '';
//		$row['v_froogle_quantitylevel']   = '';
		$row['v_froogle_manufacturer_id'] = '';
//		$row['v_froogle_exp_date']    = '';
		$row['v_froogle_product_type']    = 'OTHER';
//		$row['v_froogle_delete']    = '';
		$row['v_froogle_currency']    = 'usd';
		$row['v_froogle_offer_id']    = $row['v_products_model'];
//		$row['v_froogle_product_id']    = $row['v_products_model'];

		// names and descriptions require that we loop thru all languages that are turned on in the store
		foreach ($langcode as $key => $lang){
			$lid = $lang['id'];

			//metaData start
				$sqlMeta = "SELECT * FROM " . DB_DATABASE . "."  . TABLE_META_TAGS_PRODUCTS_DESCRIPTION . " WHERE 
							products_id = " . $row['v_products_id'] . " AND
							language_id = '" . $lid . "' LIMIT 1 ";
				$resultMeta = ep_query($con,$sqlMeta);
				$rowMeta = mysqli_fetch_array($resultMeta);
				$row['v_metatags_title_' . $lid] = $rowMeta['metatags_title'];
				$row['v_metatags_keywords_' . $lid] = $rowMeta['metatags_keywords'];
				$row['v_metatags_description_' . $lid] = $rowMeta['metatags_description'];
			//metaData end


			// for each language, get the description and set the vals
			$sql2 = "SELECT * FROM ". DB_DATABASE . "." .TABLE_PRODUCTS_DESCRIPTION." WHERE
					products_id = " . $row['v_products_id'] . " AND
					language_id = '" . $lid . "' LIMIT 1 ";
			$result2 = ep_query($con,$sql2);
			$row2 =  mysqli_fetch_array($result2);

			// I'm only doing this for the first language, since right now froogle is US only.. Fix later! langer - is this still relevant?
			// adding url for froogle, but it should be available no matter what
			
				if ($num_of_langs == 1) {
					$row['v_froogle_products_url_' . $lid] = zen_catalog_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $row['v_products_id']);
				} else {
					$row['v_froogle_products_url_' . $lid] = zen_catalog_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $row['v_products_id'] . '&language=' . $lid);
				}

			$row['v_products_name_' . $lid] = $row2['products_name'];
			$row['v_products_description_' . $lid]  = $row2['products_description'];
			if ($ep_supported_mods['psd'] == true) {
				$row['v_products_short_desc_' . $lid]   = $row2['products_short_desc'];
			}
			$row['v_products_url_' . $lid]    = $row2['products_url'];

			// froogle advanced format needs the quotes around the name and desc

			$row['v_froogle_products_name_' . $lid] = '"' . html_entity_decode(strip_tags(str_replace('"','""',$row2['products_name']))) . '"';
			$row['v_froogle_products_description_' . $lid] = '"' . html_entity_decode(strip_tags(str_replace('"','""',$row2['products_description']))) . '"';
			/*
			$row['v_froogle_products_name_' . $lid] = '"' . html_entity_decode(removeTags(str_replace('"','""',$row2['products_name']))) . '"';
			$row['v_froogle_products_description_' . $lid] = '"' . html_entity_decode(removeTags(str_replace('"','""',$row2['products_description']))) . '"';
			*/
			// support for Linda's Header Controller 2.0 here
			if (isset($filelayout['v_products_head_title_tag_' . $lid])){
				$row['v_products_head_title_tag_' . $lid]   = $row2['products_head_title_tag'];
				$row['v_products_head_desc_tag_' . $lid]  = $row2['products_head_desc_tag'];
				$row['v_products_head_keywords_tag_' . $lid]  = $row2['products_head_keywords_tag'];
			}
			// end support for Header Controller 2.0
		}
		
		// langer - specials
		if (isset($filelayout['v_specials_price'])) {
			
			$specials_query = ep_query($con,"SELECT
						specials_new_products_price,
						specials_date_available,
						expires_date
				FROM
						". DB_DATABASE . "." .TABLE_SPECIALS."
				WHERE
				products_id = " . $row['v_products_id']);
					
			if (mysqli_num_rows($specials_query)) {
				// we have a special
				$ep_specials = mysqli_fetch_array($specials_query);
				$row['v_specials_price'] = $ep_specials['specials_new_products_price'];
				$row['v_specials_date_avail'] = $ep_specials['specials_date_available'];
				$row['v_specials_expires_date'] = $ep_specials['expires_date'];
			} else {
				$row['v_specials_price'] = '';
				$row['v_specials_date_avail'] = '';
				$row['v_specials_expires_date'] = '';
			}
		}
		// langer - end specials
		
		// for the categories, we need to keep looping until we find the root category

		// start with v_categories_id
		// Get the category description
		// set the appropriate variable name
		// if parent_id is not null, then follow it up.
		// we'll populate an aray first, then decide where it goes in the
		$thecategory_id = $row['v_categories_id'];
		$fullcategory = ''; // this will have the entire category stack for froogle
		for( $categorylevel=1; $categorylevel<$max_categories+1; $categorylevel++){
			if (!empty($thecategory_id)){
				$sql2 = "SELECT categories_name
					FROM ". DB_DATABASE . "." .TABLE_CATEGORIES_DESCRIPTION."
					WHERE 
						categories_id = " . $thecategory_id . " AND
						language_id = " . $epdlanguage_id ;
				$result2 = ep_query($con,$sql2);
				$row2 =  mysqli_fetch_array($result2);
				// only set it if we found something
				$temprow['v_categories_name_' . $categorylevel] = $row2['categories_name'];
				// now get the parent ID if there was one
				$sql3 = "SELECT parent_id
					FROM ". DB_DATABASE . "." .TABLE_CATEGORIES."
					WHERE
						categories_id = " . $thecategory_id;
				$result3 = ep_query($con,$sql3);
				$row3 =  mysqli_fetch_array($result3);
				$theparent_id = $row3['parent_id'];
				if ($theparent_id != ''){
					// there was a parent ID, lets set thecategoryid to get the next level
					$thecategory_id = $theparent_id;
				} else {
					// we have found the top level category for this item,
					$thecategory_id = false;
				}
				//$fullcategory .= " > " . $row2['categories_name'];
				$fullcategory = $row2['categories_name'] . " > " . $fullcategory;
			} else {
				$temprow['v_categories_name_' . $categorylevel] = '';
			}
		}
		// now trim off the last ">" from the category stack
		$row['v_category_fullpath'] = substr($fullcategory,0,strlen($fullcategory)-3);

		// temprow has the old style low to high level categories.
		$newlevel = 1;
		// let's turn them into high to low level categories
		for( $categorylevel=6; $categorylevel>0; $categorylevel--){
			if ($temprow['v_categories_name_' . $categorylevel] != ''){
				$row['v_categories_name_' . $newlevel++] = $temprow['v_categories_name_' . $categorylevel];
			}
		}
		// if the filelayout says we need a manufacturers name, get it
		if (isset($filelayout['v_manufacturers_name'])){
			if ($row['v_manufacturers_id'] != ''){
				$sql2 = "SELECT manufacturers_name
					FROM ". DB_DATABASE . "." .TABLE_MANUFACTURERS."
					WHERE
					manufacturers_id = " . $row['v_manufacturers_id']
					;
				$result2 = ep_query($con,$sql2);
				$row2 =  mysqli_fetch_array($result2);
				$row['v_manufacturers_name'] = $row2['manufacturers_name'];
			}
		}


		// If you have other modules that need to be available, put them here

		// VJ product attribs begin
		if (isset($filelayout['v_attribute_options_id_1'])){
			$languages = zen_get_languages();

			$attribute_options_count = 1;
			foreach ($attribute_options_array as $attribute_options) {
				$row['v_attribute_options_id_' . $attribute_options_count]  = $attribute_options['products_options_id'];

				for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
					$lid = $languages[$i]['id'];

					$attribute_options_languages_query = "select products_options_name from " . DB_DATABASE . "." . TABLE_PRODUCTS_OPTIONS . " where products_options_id = '" . (int)$attribute_options['products_options_id'] . "' and language_id = '" . (int)$lid . "'";
					$attribute_options_languages_values = ep_query($con,$attribute_options_languages_query);

					$attribute_options_languages = mysqli_fetch_array($attribute_options_languages_values);

					$row['v_attribute_options_name_' . $attribute_options_count . '_' . $lid] = $attribute_options_languages['products_options_name'];
				}

				$attribute_values_query = "select products_options_values_id from " . DB_DATABASE . "." . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " where products_options_id = '" . (int)$attribute_options['products_options_id'] . "' order by products_options_values_id";
				$attribute_values_values = ep_query($con,$attribute_values_query);

				$attribute_values_count = 1;
				while ($attribute_values = mysqli_fetch_array($attribute_values_values)) {
					$row['v_attribute_values_id_' . $attribute_options_count . '_' . $attribute_values_count]   = $attribute_values['products_options_values_id'];

					$attribute_values_price_query = "select options_values_price, price_prefix from " . DB_DATABASE . "." . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . (int)$row['v_products_id'] . "' and options_id = '" . (int)$attribute_options['products_options_id'] . "' and options_values_id = '" . (int)$attribute_values['products_options_values_id'] . "'";
					$attribute_values_price_values = ep_query($con,$attribute_values_price_query);

					$attribute_values_price = mysqli_fetch_array($attribute_values_price_values);

					$row['v_attribute_values_price_' . $attribute_options_count . '_' . $attribute_values_count]  = $attribute_values_price['price_prefix'] . $attribute_values_price['options_values_price'];

					for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
						$lid = $languages[$i]['id'];

						$attribute_values_languages_query = "select products_options_values_name from " . DB_DATABASE . "." . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . (int)$attribute_values['products_options_values_id'] . "' and language_id = '" . (int)$lid . "'";
						$attribute_values_languages_values = ep_query($con,$attribute_values_languages_query);

						$attribute_values_languages = mysqli_fetch_array($attribute_values_languages_values);

						$row['v_attribute_values_name_' . $attribute_options_count . '_' . $attribute_values_count . '_' . $lid] = $attribute_values_languages['products_options_values_name'];
					}

					$attribute_values_count++;
				}

				$attribute_options_count++;
			}
		}
		// VJ product attribs end

		// this is for the separate price per customer module
		if (isset($filelayout['v_customer_price_1'])){
			$sql2 = "SELECT
					customers_group_price,
					customers_group_id
				FROM
					". DB_DATABASE . "." .TABLE_PRODUCTS_GROUPS."
				WHERE
				products_id = " . $row['v_products_id'] . "
				ORDER BY
				customers_group_id"
				;
			$result2 = ep_query($con,$sql2);
			$ll = 1;
			$row2 =  mysqli_fetch_array($result2);
			while( $row2 ){
				$row['v_customer_group_id_' . $ll]  = $row2['customers_group_id'];
				$row['v_customer_price_' . $ll]   = $row2['customers_group_price'];
				$row2 = mysqli_fetch_array($result2);
				$ll++;
			}
		}
		if ($ep_dltype == 'froogle'){
			// For froogle, we check the specials prices for any applicable specials, and use that price
			// by grabbing the specials id descending, we always get the most recently added special price
			// I'm checking status because I think you can turn off specials
			$sql2 = "SELECT
					specials_new_products_price
				FROM
					". DB_DATABASE . "." .TABLE_SPECIALS."
				WHERE
				products_id = " . $row['v_products_id'] . " and
				status = 1 and
				expires_date < CURRENT_TIMESTAMP
				ORDER BY
					specials_id DESC"
				;
			$result2 = ep_query($con,$sql2);
			$ll = 1;
			$row2 =  mysqli_fetch_array($result2);
			if (!empty($row2)){
				// reset the products price to our special price if there is one for this product
				$row['v_products_price']  = $row2['specials_new_products_price'];
			}
		}

		//elari -
		//We check the value of tax class and title instead of the id
		//Then we add the tax to price if $price_with_tax is set to 1
		$row_tax_multiplier     = ep_get_tax_class_rate($row['v_tax_class_id']);
		$row['v_tax_class_title']   = zen_get_tax_class_title($row['v_tax_class_id']);
		$row['v_products_price']  = round($row['v_products_price'] + ($price_with_tax * $row['v_products_price'] * $row_tax_multiplier / 100),2);


		// Now set the status to a word the user specd in the config vars
		
		// disabled below to make uploads & downloads consistant - Numeric only
		/*if ( $row['v_status'] == '1' ){
			$row['v_status'] = $active;
		} else {
			$row['v_status'] = $inactive;
		} */

		$tempcsvrow = array(); 
		foreach( $filelayout as $key => $value ){
			// only specific keys are used
			$tempcsvrow[] = $row[$key];
		}
		$filestring[] = $tempcsvrow;
		
	}
	
	
	//$EXPORT_TIME=time();
	$FILE_EXT = "csv";
	$EXPORT_TIME = strftime('%Y%b%d-%H%I');
	switch ($ep_dltype) {
		case 'full':
		$EXPORT_TIME = "Full-EP" . $EXPORT_TIME;
		break;
		case 'priceqty':
		$EXPORT_TIME = "PriceQty-EP" . $EXPORT_TIME;
		break;
		case 'modqty':
		$EXPORT_TIME = "ModifiedDate-EP" . $EXPORT_TIME;
		break;
		case 'category':
		$EXPORT_TIME = "Category-EP" . $EXPORT_TIME;
		break;
		case 'froogle': {
			$EXPORT_TIME = "Froogle-EP" . $EXPORT_TIME;
			$csv_deliminator = "\t";
			$csv_enclosure = ' ';
			$FILE_EXT = "txt";
			$filestring = array_map("kill_breaks", $filestring);
		}
		break;
		case 'attrib':
		$EXPORT_TIME = "Attributes-EP" . $EXPORT_TIME;
		break;
	}

	// now either stream it to them or put it in the temp directory
	if ($ep_dlmethod == 'stream'){
		//*******************************
		// STREAM FILE
		//*******************************
		header("Content-type: application/csv");
		header("Content-disposition: attachment; filename=$EXPORT_TIME.$FILE_EXT");
		// Changed if using SSL, helps prevent program delay/timeout (add to backup.php also)
		//  header("Pragma: no-cache");
		if ($request_type== 'NONSSL'){
			header("Pragma: no-cache");
		} else {
			header("Pragma: ");
		}
		header("Expires: 0");
		
		$fp = fopen("php://output", "w+"); //no str_putcsv function...
		foreach ($filestring as $line) {
			fputcsv($fp, $line, $csv_deliminator, $csv_enclosure);
		}
		
		die();
	} else {
		//*******************************
		// PUT FILE IN TEMP DIR
		//*******************************
		$tmpfpath = DIR_FS_CATALOG . '' . $tempdir . "$EXPORT_TIME.$FILE_EXT";
		$fp = fopen( $tmpfpath, "w+");
		foreach ($filestring as $line) {
			fputcsv($fp, $line, $csv_deliminator, $csv_enclosure);
		}
		fclose($fp);
		$messageStack->add(sprintf(EASYPOPULATE_MSGSTACK_FILE_EXPORT_SUCCESS, $EXPORT_TIME.'.'.$FILE_EXT." &nbsp;&nbsp;&nbsp;", $tempdir), 'success');
		//the note includes the .txt in the languages file, didn't want to change that file too
	}
}

//*******************************
//*******************************
// DOWNLOADING ENDS HERE
//*******************************
//*******************************


//*******************************
//*******************************
// UPLOADING OF FILES STARTS HERE
//*******************************
//*******************************

if ( isset($_POST['localfile']) || isset($_FILES['usrfl']) ) {
	
	$display_output .= EASYPOPULATE_DISPLAY_HEADING;
	
	//*******************************
	//*******************************
	// UPLOAD AND INSERT FILE
	//*******************************
	//*******************************

	if ( isset($_FILES['usrfl']) ) {
		// move the uploaded file to where we can work with it
		$file = ep_get_uploaded_file('usrfl');
		// langer - this copies the file to our temp dir. This is required so it can be read into file array.
		// user not protected from uploading and overwriting a duplicate named file, too bad
		
		//$new_file_prefix = 'uploaded-'.strftime('%y%m%d-%H%I%S').'-';
		if (is_uploaded_file($file['tmp_name'])) {
			ep_copy_uploaded_file($file, DIR_FS_CATALOG . $tempdir);
		}
		$display_output .= sprintf(EASYPOPULATE_DISPLAY_UPLOADED_FILE_SPEC, $file['tmp_name'], $file['name'], $file['size']);
		
	}
	
	if ( isset($_POST['localfile']) ){
		//file is already in temp directory...
		$file['name'] = $_POST['localfile'];
		$display_output .= sprintf(EASYPOPULATE_DISPLAY_LOCAL_FILE_SPEC, $file['name']);
	}
	
	$file_location = DIR_FS_CATALOG . $tempdir . $file['name'];
	
	//*******************************
	//*******************************
	// PROCESS UPLOAD FILE
	//*******************************
	//*******************************
	
	// these are the fields that will be defaulted to the current values in the database if they are not found in the incoming file
	// langer - why not qry products table and use result array??
	$default_these = array(
		'v_products_image',
		// redundant image mods removed
		'v_categories_id',
		'v_products_price',
		'v_products_quantity',
		'v_products_weight',
		'v_date_added',

		'v_date_avail',
		'v_instock',
		'v_tax_class_title',
		'v_manufacturers_name',
		'v_manufacturers_id',
		'v_products_dim_type',
		'v_products_length',
		'v_products_width',
		'v_products_height',	
	);
	/*
	*	BOF Custom Fields
	*/
		$custom_these = array();
		if(count($custom_fields) > 0)
		{
			foreach($custom_fields as $f)
			{
				$custom_these[] = 'v_'.$f;	
			}
			
			$default_these = array_merge($default_these,$custom_these);
		}
		//print_r($default_these);
		
	/*
	*	EOF Custom Fields
	*/

	// BEGIN PROCESSING DATA
	//FOR CSV - these lines eliminate TONS of worthless code
	if (!file_exists($file_location)) {
		$display_output .="<b>ERROR: file doesn't exist</b>";
	} else if ( !($handle = fopen($file_location, "r"))) {
		$display_output .="<b>ERROR: Can't open file</b>";
	} else if($filelayout = array_flip(fgetcsv($handle, 0, $csv_deliminator, $csv_enclosure))) {
	while ($items = fgetcsv($handle, 0, $csv_deliminator, $csv_enclosure)) {
	//foreach ($readed as $file_row)

		// langer - we now have all of our fields for this product in $items[1], $items[2] etc where the array key is the column number
		//echo "DESC:".$items[$filelayout['v_products_description_1']].":END<br />";
		
		//echo 'MODEL'.$items[$filelayout['v_products_model']].'END<br />';
		// all headings in $filelayout['columnheading'] = columnnumber, and row values are in $items[$filelayout] = 'value'
		
		// langer - inputs: $items array (file data by column #); $filelayout array (headings by column #)
		
		// now do a query to get the record's current contents
		$sql = "SELECT
			p.products_id as v_products_id,
			p.products_model as v_products_model,
			p.products_image as v_products_image,
			p.products_price as v_products_price,
			p.products_weight as v_products_weight,
			p.products_date_added as v_date_added,
			p.products_date_available as v_date_avail,
			p.products_tax_class_id as v_tax_class_id,
			p.products_quantity as v_products_quantity,
			p.manufacturers_id as v_manufacturers_id,
			subc.categories_id as v_categories_id".
			$custom_filelayout_sql.
			" FROM
			". DB_DATABASE . "." .TABLE_PRODUCTS." as p,
			". DB_DATABASE . "." .TABLE_CATEGORIES." as subc,
			". DB_DATABASE . "." .TABLE_PRODUCTS_TO_CATEGORIES." as ptoc
			WHERE
			p.products_id = ptoc.products_id AND
			p.products_model = '" . zen_db_input($items[$filelayout['v_products_model']]) . "' AND
			ptoc.categories_id = subc.categories_id
			";
			//echo $sql;
		$result = ep_query($con,$sql);

		$product_is_new = true;
		
		// langer - inputs: $items array (file data by column #); $filelayout array (headings by column #); $row (current db TABLE_PRODUCTS data by heading name)
		
		while ( $row = mysqli_fetch_array($result) ) {
			$product_is_new = false;
						
			/*
			* Get current products descriptions and categories for this model from database
			* $row at present consists of current product data for above fields only (in $sql)
			*/
			
			// since we have a row, the item already exists.
			// let's check and delete it if requested     
			if ($items[$filelayout['v_status']] == 9) {
				$display_output .= sprintf(EASYPOPULATE_DISPLAY_RESULT_DELETED, $items[$filelayout['v_products_model']]);
				ep_remove_product($items[$filelayout['v_products_model']]);
				continue 2;
			}
			
			// Let's get all the data we need and fill in all the fields that need to be defaulted to the current values
			// for each language, get the description and set the vals
			foreach ($langcode as $key => $lang){
				
				$sql2 = "SELECT *
					FROM ". DB_DATABASE . "." .TABLE_PRODUCTS_DESCRIPTION."
					WHERE
						products_id = " . $row['v_products_id'] . " AND
						language_id = '" . $lang['id'] . "' LIMIT 1
					";
				$result2 = ep_query($con,$sql2);
				$row2 =  mysqli_fetch_array($result2);
				// Need to report from ......_name_1 not ..._name_0
				$row['v_products_name_' . $lang['id']]    = $row2['products_name'];// name assigned
				$row['v_products_description_' . $lang['id']]   = $row2['products_description'];// description assigned
				// if short descriptions exist
				if ($ep_supported_mods['psd'] == true) {
					$row['v_products_short_desc_' . $lang['id']]  = $row2['products_short_desc'];
				}
				$row['v_products_url_' . $lang['id']]     = $row2['products_url'];// url assigned
	
				// support for Linda's Header Controller 2.0 here
				// if (array_key_exists($filelayout['v_products_head_title_tag_' . $lang['id']])) // langer - is this better?!?
				if (isset($filelayout['v_products_head_title_tag_' . $lang['id']])) {
					$row['v_products_head_title_tag_' . $lang['id']] = $row2['products_head_title_tag'];
					$row['v_products_head_desc_tag_' . $lang['id']] = $row2['products_head_desc_tag'];
					$row['v_products_head_keywords_tag_' . $lang['id']] = $row2['products_head_keywords_tag'];
				}
				// end support for Header Controller 2.0
			}
			// table descriptions values by each language assigned into array $row
			
			// langer - outputs: $items array (file data by column #); $filelayout array (headings by column #); $row (current db TABLE_PRODUCTS & TABLE_PRODUCTS_DESCRIPTION data by heading name)
			
			
			/**
			* Categories start.
			*/
			
			// start with v_categories_id
			// Get the category description
			// set the appropriate variable name
			// if parent_id is not null, then follow it up.
			$thecategory_id = $row['v_categories_id'];// master category id
	
			for($categorylevel=1; $categorylevel<$max_categories+1; $categorylevel++){
				if (!empty($thecategory_id)){
					$sql2 = "SELECT categories_name
						FROM ". DB_DATABASE . "." .TABLE_CATEGORIES_DESCRIPTION."
						WHERE
							categories_id = " . $thecategory_id . " AND
							language_id = " . $epdlanguage_id ;
					$result2 = ep_query($con,$sql2);
					$row2 = mysqli_fetch_array($result2);
					// only set it if we found something
					$temprow['v_categories_name_' . $categorylevel] = $row2['categories_name'];
					
					// now get the parent ID if there was one
					$sql3 = "SELECT parent_id
						FROM ". DB_DATABASE . "." .TABLE_CATEGORIES."
						WHERE
							categories_id = " . $thecategory_id;
					$result3 = ep_query($con,$sql3);
					$row3 =  mysqli_fetch_array($result3);
					$theparent_id = $row3['parent_id'];
					if ($theparent_id != ''){
						// there was a parent ID, lets set thecategoryid to get the next level
						$thecategory_id = $theparent_id;
					} else {
						// we have found the top level category for this item,
						$thecategory_id = false;
					}
				} else {
						$temprow['v_categories_name_' . $categorylevel] = '';
				}
			}
			// temprow has the old style low to high level categories.
			$newlevel = 1;
			// let's turn them into high to low level categories
			for( $categorylevel=$max_categories+1; $categorylevel>0; $categorylevel--){
				if ($temprow['v_categories_name_' . $categorylevel] != ''){
					$row['v_categories_name_' . $newlevel++] = $temprow['v_categories_name_' . $categorylevel];
				}
			}
			/**
			* Categories path for existing product retrieved from db in $row array
			*/
			
			/**
			* retrieve current manufacturer name from db for this product if exist
			*/
			if ($row['v_manufacturers_id'] != ''){
				$sql2 = "SELECT manufacturers_name
					FROM ". DB_DATABASE . "." .TABLE_MANUFACTURERS."
					WHERE
					manufacturers_id = " . $row['v_manufacturers_id']
					;
				$result2 = ep_query($con,$sql2);
				$row2 =  mysqli_fetch_array($result2);
				$row['v_manufacturers_name'] = $row2['manufacturers_name'];
			}
			
			/**
			* get tax info for this product
			*/
			//We check the value of tax class and title instead of the id
			//Then we add the tax to price if $price_with_tax is set to true
			$row_tax_multiplier = ep_get_tax_class_rate($row['v_tax_class_id']);
			$row['v_tax_class_title'] = zen_get_tax_class_title($row['v_tax_class_id']);
			if ($price_with_tax){
				$row['v_products_price'] = round($row['v_products_price'] + ($row['v_products_price'] * $row_tax_multiplier / 100),2);
			}
			
			
			/**
			* langer - the following defaults all of our current data from our db ($row array) to our update variables (called internal variables here)
			* for each $default_these - this limits it just to TABLE_PRODUCTS fields defined in this array!
			* eg $v_products_price = $row['v_products_price'];
			* perhaps we should build onto this array with each $row assignment routing above, so as to default all data to existing database
			*/
			
			// now create the internal variables that will be used
			// the $$thisvar is on purpose: it creates a variable named what ever was in $thisvar and sets the value
			// sets them to $row value, which is the existing value for these fields in the database
			foreach ($default_these as $thisvar){
				$$thisvar = $row[$thisvar];
			}
			
		}
		/**
		* langer - We have now set our PRODUCT_TABLE vars for existing products, and got our default descriptions & categories in $row still
		* new products start here!
		*/
		
		/**
		* langer - let's have some data error checking..
		* inputs: $items; $filelayout; $product_is_new (no reliance on $row)
		*/
		if ($items[$filelayout['v_status']] == 9 && zen_not_null($items[$filelayout['v_products_model']])) {
			// new delete got this far, so cant exist in db. Cant delete what we don't have...
			$display_output .= sprintf(EASYPOPULATE_DISPLAY_RESULT_DELETE_NOT_FOUND, $items[$filelayout['v_products_model']]);
			continue;
		}
		if ($product_is_new == true) {
			if (!zen_not_null(trim($items[$filelayout['v_categories_name_1']])) && zen_not_null($items[$filelayout['v_products_model']])) {
			// let's skip this new product without a master category..
			$display_output .= sprintf(EASYPOPULATE_DISPLAY_RESULT_CATEGORY_NOT_FOUND, $items[$filelayout['v_products_model']], ' new');
			continue;
			} else {
				// minimum test for new product - model(already tested below), name, price, category, taxclass(?), status (defaults to active)
				// to add
			}
		} else { // not new product
			if (!zen_not_null(trim($items[$filelayout['v_categories_name_1']])) && isset($filelayout['v_categories_name_1'])) {
				// let's skip this existing product without a master category but has the column heading
				// or should we just update it to result of $row (it's current category..)??
				$display_output .= sprintf(EASYPOPULATE_DISPLAY_RESULT_CATEGORY_NOT_FOUND, $items[$filelayout['v_products_model']], '');
				foreach ($items as $col => $langer) {
					if ($col == $filelayout['v_products_model']) continue;
					$display_output .= print_el($langer);
				}
				continue;
			}
		}
		/*
		* End data checking
		**/
		
		
		/**
		* langer - assign to our vars any new data from $items (from our file)
		* output is: $v_products_model = "modelofthing", $v_products_description_1 = "descofthing", etc for each file heading
		* any existing (default) data assigned above is overwritten here with the new vals from file
		*/
		
		// this is an important loop.  What it does is go thru all the fields in the incoming file and set the internal vars.
		// Internal vars not set here are either set in the loop above for existing records, or not set at all (null values)
		// the array values are handled separately, although they will set variables in this loop, we won't use them.
		// $key is column heading name, $value is column number for the heading..
		// langer - this would appear to over-write our defaults with null values in $items if they exist
		// in other words, if we have a file heading, then you want all listed models updated in this field
		// add option here - update all null values, or ignore null values???
		foreach($filelayout as $key => $value){
			$$key = $items[$value];
		}
	
		// so how to handle these?  we shouldn't build the array unless it's been giving to us.
		// The assumption is that if you give us names and descriptions, then you give us name and description for all applicable languages
		foreach ($langcode as $lang){
			$l_id = $lang['id'];
			
			//metaTags
			if ( isset($filelayout['v_metatags_title_' . $l_id ]) ) { 
				$v_metatags_title[$l_id] = $items[$filelayout['v_metatags_title_' . $l_id]];
				$v_metatags_keywords[$l_id] = $items[$filelayout['v_metatags_keywords_' . $l_id]];
				$v_metatags_description[$l_id] = $items[$filelayout['v_metatags_description_' . $l_id]];
			}
			//metaTags
			
			
			if (isset($filelayout['v_products_name_' . $l_id ])){ // do for each language in our upload file if exist
				// convert language names from _1, _2, etc; into arrays [1], [2], etc
				$v_products_name[$l_id] = smart_tags($items[$filelayout['v_products_name_' . $l_id]],$smart_tags,$cr_replace,false);
				//$v_products_description[$l_id] = smart_tags($items[$filelayout['v_products_description_' . $l_id ]],$smart_tags,$cr_replace,$strip_smart_tags);
				$v_products_description[$l_id] = $items[$filelayout['v_products_description_' . $l_id ]];
				// if short descriptions exist
				if ($ep_supported_mods['psd'] == true) {
					$v_products_short_desc[$l_id] = smart_tags($items[$filelayout['v_products_short_desc_' . $l_id ]],$smart_tags,$cr_replace,$strip_smart_tags);
				}
				$v_products_url[$l_id] = smart_tags($items[$filelayout['v_products_url_' . $l_id ]],$smart_tags,$cr_replace,false);
				
				// support for Linda's Header Controller 2.0 here
				if (isset($filelayout['v_products_head_title_tag_' . $l_id])){
					$v_products_head_title_tag[$l_id] = $items[$filelayout['v_products_head_title_tag_' . $l_id]];
					$v_products_head_desc_tag[$l_id] = $items[$filelayout['v_products_head_desc_tag_' . $l_id]];
					$v_products_head_keywords_tag[$l_id] = $items[$filelayout['v_products_head_keywords_tag_' . $l_id]];
				}
				// end support for Header Controller 2.0
			}
		}
		//elari... we get the tax_clas_id from the tax_title - from zencart??
		//on screen will still be displayed the tax_class_title instead of the id....
		if (isset($v_tax_class_title)){
			//$v_tax_class_id = ep_get_tax_title_class_id($v_tax_class_title);
			$v_tax_class_id = 1;
		}
		//we check the tax rate of this tax_class_id
		$row_tax_multiplier = ep_get_tax_class_rate($v_tax_class_id);
	
		//And we recalculate price without the included tax...
		//Since it seems display is made before, the displayed price will still include tax
		//This is same problem for the tax_clas_id that display tax_class_title
		if ($price_with_tax == true){
			$v_products_price = round( $v_products_price / (1 + ( $row_tax_multiplier * $price_with_tax/100) ), 4);
		}
	
		// if they give us one category, they give us all 6 categories
		// langer - this does not appear to support more than 7 categories??
		unset ($v_categories_name); // default to not set.
		
		//echo 'max cat len: '.$category_strlen_max.'<br/>';
		if (isset($filelayout['v_categories_name_1'])) { // does category 1 column exist in our file..
			
			$category_strlen_long = FALSE;// checks cat length does not exceed db, else exclude product from upload
			$newlevel = 1;
			for($categorylevel=6; $categorylevel>0; $categorylevel--) {
				if ($items[$filelayout['v_categories_name_' . $categorylevel]] != '') {
					if (strlen($items[$filelayout['v_categories_name_' . $categorylevel]]) > $category_strlen_max) $category_strlen_long = TRUE;
					$v_categories_name[$newlevel++] = $items[$filelayout['v_categories_name_' . $categorylevel]]; // adding the category name values to $v_categories_name array
				}// null categories are not assigned
			}
			while( $newlevel < $max_categories+1){
				$v_categories_name[$newlevel++] = ''; // default the remaining items to nothing
			}
			if ($category_strlen_long == TRUE) {
				$display_output .= sprintf(EASYPOPULATE_DISPLAY_RESULT_CATEGORY_NAME_LONG, $v_products_model, $category_strlen_max);
				continue;
			}
		}
		
		// langer - if null, make products qty = 1. Why?? make it 0
		if (trim($v_products_quantity) == '') {
			$v_products_quantity = 0;
		}
		
		// default the stock if they spec'd it or if it's blank
		$v_db_status = '1'; // default to active
		if ($v_status == '0'){
			// they told us to deactivate this item
			$v_db_status = '0';
		}
		if (EASYPOPULATE_CONFIG_ZERO_QTY_INACTIVE == 'true' && $v_products_quantity == 0) {
			// if they said that zero qty products should be deactivated, let's deactivate if the qty is zero
			$v_db_status = '0';
		}
	
		if ($v_manufacturer_id == '') {
			$v_manufacturer_id = "1";
		}
	
		if (trim($v_products_image) == '') {
			$v_products_image = PRODUCTS_IMAGE_NO_IMAGE;
		}
	
		if (strlen($v_products_model) > $modelsize ){
			$display_output .= sprintf(EASYPOPULATE_DISPLAY_RESULT_MODEL_NAME_LONG, $v_products_model);
			continue;
		}
	
		// OK, we need to convert the manufacturer's name into id's for the database
		if ( isset($v_manufacturers_name) && $v_manufacturers_name != '' ){
			$sql = "SELECT man.manufacturers_id as manID
				FROM ". DB_DATABASE . "." .TABLE_MANUFACTURERS." as man
				WHERE
					man.manufacturers_name = '" . zen_db_input($v_manufacturers_name) . "' LIMIT 1";
			$result = ep_query($con,$sql);
			if ( $row =  mysqli_fetch_array($result) ){
				$v_manufacturer_id = $row['manID'];
			} else {
				//It is set to autoincrement, do not need to fetch max id
				$sql = "INSERT INTO " . DB_DATABASE . "." . TABLE_MANUFACTURERS . "( manufacturers_name, date_added, last_modified )
														VALUES ( '" . zen_db_input($v_manufacturers_name) . "',	CURRENT_TIMESTAMP, CURRENT_TIMESTAMP )";
				$result = ep_query($con,$sql);
				$v_manufacturer_id = mysqli_insert_id($con);
			}
		}
		// if the categories names are set then try to update them
		if (isset($v_categories_name_1)) {
			// start from the highest possible category and work our way down from the parent
			$v_categories_id = 0;
			$theparent_id = 0;
			for ( $categorylevel=$max_categories+1; $categorylevel>0; $categorylevel-- ){
				$thiscategoryname = $v_categories_name[$categorylevel];
				if ( $thiscategoryname != ''){
					// we found a category name in this field
	
					// now the subcategory
					$sql = "SELECT cat.categories_id AS catID FROM ". DB_DATABASE . "." .TABLE_CATEGORIES." AS cat, ". DB_DATABASE . "." .TABLE_CATEGORIES_DESCRIPTION." AS des WHERE
							cat.categories_id = des.categories_id AND
							des.language_id = $epdlanguage_id AND
							cat.parent_id = " . $theparent_id . " AND
							des.categories_name = '" . zen_db_input($thiscategoryname) . "' LIMIT 1";
					$result = ep_query($con,$sql);
					if ( $row = mysqli_fetch_array($result) ){ // langer - null result here where len of $v_categories_name[] exceeds maximum in database
						$thiscategoryid = $row['catID'];
					} else {
						// to add, we need to put stuff in categories and categories_description
						$sql = "INSERT INTO ". DB_DATABASE . "." .TABLE_CATEGORIES." ( parent_id, sort_order, date_added, last_modified )
								VALUES ( $theparent_id, 0, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP )";
						$result = ep_query($con,$sql);
						
						$thiscategoryid = mysqli_insert_id($con);
						
						$sql = "INSERT INTO ". DB_DATABASE . "." .TABLE_CATEGORIES_DESCRIPTION."( categories_id, language_id, categories_name, categories_description )
								VALUES ( $thiscategoryid, '$epdlanguage_id', '".zen_db_input($thiscategoryname)."', '' )";
						$result = ep_query($con,$sql);
					}
					// the current catid is the next level's parent
					$theparent_id = $thiscategoryid;
					$v_categories_id = $thiscategoryid; // keep setting this, we need the lowest level category ID later
				}
			}
		}
		
		// insert new, or update existing, product
		if ($v_products_model != "") {
			//   products_model exists!
			
			// First we check to see if this is a product in the current db.
			$result = ep_query($con,"SELECT `products_id` FROM ". DB_DATABASE . "." .TABLE_PRODUCTS." WHERE (products_model = '" . zen_db_input($v_products_model) . "') LIMIT 1 ");
			
			//$v_date_avail = ($v_date_avail == true) ? date("Y-m-d H:i:s",strtotime($v_date_avail)) : "";
			$v_date_avail =  date("Y-m-d H:i:s") ;
			if ( $row = mysqli_fetch_array($result) ) {
				//UPDATING PRODUCT
				
				$v_products_id = $row['products_id'];
				
				// if date added is null, let's keep the existing date in db..
				if (!$v_date_added && $row['v_date_added']) { $v_date_added = $row['v_date_added']; }
				$v_date_added = ($v_date_added) ? "'".date("Y-m-d H:i:s",strtotime($v_date_added))."'" : "CURRENT_TIMESTAMP";
				
				/*
				*	BOF Custom Fields
				*/
				
				$custom_query = '';
				if(count($custom_fields) > 0)
				{
					foreach($custom_fields as $f)
					{
						$custom_input = $items[$filelayout['v_'.$f]];
						$custom_query .= ", ".$f."='".zen_db_input($custom_input)."' ";	
					}
					
					
				}
				
				//$custom_query =", product_is_always_free_shipping ='". zen_db_input($v_product_is_always_free_shipping)."',								products_glsalesaccount ='".zen_db_input($v_products_glsalesaccount)."',								products_family ='".zen_db_input($v_products_family)."' ";
				
				/*
				*	EOF Custom Fields
				*/
				if ($v_db_status == '') {
					$v_db_status = "1";
				}
				if ($v_metatags_title_status == '') {
					$v_metatags_title_status = "0";
				}
				if ($v_metatags_products_name_status == '') {
					$v_metatags_products_name_status = "0";
				}
				if ($v_metatags_model_status == '') {
					$v_metatags_model_status = "0";
				}
				if ($v_metatags_price_status == '') {
					$v_metatags_price_status = "0";
				}
				if ($v_metatags_title_tagline_status == '') {
					$v_metatags_title_tagline_status = "0";
				}
				$query = "UPDATE " . DB_DATABASE . "." . TABLE_PRODUCTS . " SET
						products_price					=	'" . zen_db_input($v_products_price)."' ,
						products_image					=	'" . zen_db_input($v_products_image)."' ,
						products_weight					=	'" . zen_db_input($v_products_weight)."' ,
						products_tax_class_id			=	'" . zen_db_input($v_tax_class_id)."' ,
						products_date_available			=	'" . $v_date_avail."' ,
						products_date_added				=	$v_date_added ,
						products_last_modified			=	CURRENT_TIMESTAMP ,
						products_quantity				=	'" . zen_db_input($v_products_quantity) . "' ,
						master_categories_id			=	'" . zen_db_input($v_categories_id) . "' ,
						manufacturers_id				=	'" . $v_manufacturer_id . "',
						products_status					=	'" . zen_db_input($v_db_status) . "',
						metatags_title_status			=	'" . zen_db_input($v_metatags_title_status)."',
						metatags_products_name_status	=	'" . zen_db_input($v_metatags_products_name_status)."',
						metatags_model_status			=	'" . zen_db_input($v_metatags_model_status)."',
						metatags_price_status			=	'" . zen_db_input($v_metatags_price_status)."',
						metatags_title_tagline_status	=	'" . zen_db_input($v_metatags_title_tagline_status)."'".
						$custom_query.
						"WHERE ( `products_id` = '". $v_products_id . "' ) ";

				if ( ep_query($con,$query) ) {
					$display_output .= sprintf(EASYPOPULATE_DISPLAY_RESULT_UPDATE_PRODUCT, $v_products_model);
					foreach ($items as $col => $langer) {
						if ($col == $filelayout['v_products_model']) continue;
						$display_output .= print_el($langer);
					}
				} else {
					$display_output .= sprintf(EASYPOPULATE_DISPLAY_RESULT_UPDATE_PRODUCT_FAIL, $v_products_model);
				}
			} else {
				/*
				*	BOF Custom Fields
				*/
				$custom_query = '';
				if(count($custom_fields) > 0)
				{
					foreach($custom_fields as $f)
					{
						//$custom_input = 
						$custom_query .= ", ".$f."='".zen_db_input($custom_input)."' ";	
					}
					
					
				}
				
				//$custom_query =", product_is_always_free_shipping ='". zen_db_input($v_product_is_always_free_shipping)."',								products_glsalesaccount ='".zen_db_input($v_products_glsalesaccount)."',								products_family ='".zen_db_input($v_products_family)."' ";
				
				/*
				*	EOF Custom Fields
				*/
				
				//NEW PRODUCT
				//   insert into products
				$v_date_added = ($v_date_added) ? "'".date("Y-m-d H:i:s",strtotime($v_date_added))."'" : "CURRENT_TIMESTAMP";
	
				$query = "INSERT INTO " . DB_DATABASE . "." . TABLE_PRODUCTS . " SET
						products_model					=	'" . zen_db_input($v_products_model)."' ,
						products_price					=	'" . zen_db_input($v_products_price)."' ,
						products_image					=	'" . zen_db_input($v_products_image)."' ,
						products_weight					=	'" . zen_db_input($v_products_weight)."' ,
						products_tax_class_id			=	'" . zen_db_input($v_tax_class_id)."' ,
						products_date_available			=	'" . $v_date_avail."' ,
						products_date_added				=	$v_date_added ,
						products_last_modified			=	CURRENT_TIMESTAMP ,
						products_quantity				=	'" . zen_db_input($v_products_quantity) . "' ,
						master_categories_id			=	'" . zen_db_input($v_categories_id) . "' ,
						manufacturers_id				=	'" . $v_manufacturer_id . "',
						products_status					=	'" . zen_db_input($v_db_status) . "',
						metatags_title_status			=	'" . zen_db_input($v_metatags_title_status)."',
						metatags_products_name_status	=	'" . zen_db_input($v_metatags_products_name_status)."',
						metatags_model_status			=	'" . zen_db_input($v_metatags_model_status)."',
						metatags_price_status			=	'" . zen_db_input($v_metatags_price_status)."',
						metatags_title_tagline_status	=	'" . zen_db_input($v_metatags_title_tagline_status)."' ".
						
						$custom_query;
	
				//echo 'New product SQL:'.$query.'<br />';

				if ( ep_query($con,$query) ) {
					$v_products_id = mysqli_insert_id($con);
					$display_output .= sprintf(EASYPOPULATE_DISPLAY_RESULT_NEW_PRODUCT, $v_products_model);
				} else {
					$display_output .= sprintf(EASYPOPULATE_DISPLAY_RESULT_NEW_PRODUCT_FAIL, $v_products_model);
					continue; // langer - any new categories however have been created by now..Adding into product table needs to be 1st action?
				}
				foreach ($items as $col => $langer) {
					if ($col == $filelayout['v_products_model']) continue;
					$display_output .= print_el($langer);
				}
					
			}
			
			
			//*************************
			// Product Meta Start
			//*************************
			
			if (isset($v_metatags_title)){
			foreach ( $v_metatags_title as $key => $metaData ) {
				$sql = "SELECT `products_id` FROM ". DB_DATABASE . "." .TABLE_META_TAGS_PRODUCTS_DESCRIPTION." WHERE (`products_id` = '$v_products_id' AND `language_id` = '$key') LIMIT 1 ";
				$result = ep_query($con,$sql);
				if ($row = mysqli_fetch_array($result)) {
					//UPDATE
					$sql = "UPDATE ". DB_DATABASE . "." .TABLE_META_TAGS_PRODUCTS_DESCRIPTION." SET 
						`metatags_title`		=	'" . zen_db_input($v_metatags_title[$key])."',
						`metatags_keywords`		=	'" . zen_db_input($v_metatags_keywords[$key])."',
						`metatags_description`	=	'" . zen_db_input($v_metatags_description[$key])."'
						WHERE (`products_id` = '$v_products_id' AND `language_id` = '$key') ";
				} else {
					//NEW
					$sql = "INSERT INTO ". DB_DATABASE . "." .TABLE_META_TAGS_PRODUCTS_DESCRIPTION." SET 
						`metatags_title`		=	'" . zen_db_input($v_metatags_title[$key])."',
						`metatags_keywords`		=	'" . zen_db_input($v_metatags_keywords[$key])."',
						`metatags_description`	=	'" . zen_db_input($v_metatags_description[$key])."',
						`products_id` 			= 	'$v_products_id',
						`language_id` 			=	'$key' ";
				}
				$result = ep_query($con,$sql);
			}
			}
			
			
			
			//*************************
			// Products Descriptions Start
			//*************************
			
			// the following is common in both the updating an existing product and creating a new product
			if (isset($v_products_name)){
				foreach( $v_products_name as $key => $name){
				if ($name != ''){
					
					$ep_supported_mods_sql = "";
					if ($ep_supported_mods['psd'] == true) {
						$ep_supported_mods_sql = " products_short_desc		=	'".zen_db_input($v_products_short_desc[$key])."', ";
					}
					
					$sql = "SELECT * FROM ". DB_DATABASE . "." .TABLE_PRODUCTS_DESCRIPTION." WHERE products_id = '$v_products_id' AND	language_id =  '$key'   LIMIT 1 ";
					$result = ep_query($con,$sql);
					
					if (mysqli_num_rows($result) == 0) {
						// new product description
						//$result = ep_query($con,$sql);
						$sql ="INSERT INTO ". DB_DATABASE . "." .TABLE_PRODUCTS_DESCRIPTION." SET
									products_id				=	'".$v_products_id."',
									language_id				=	'".$key."',
									products_name			=	'".zen_db_input($name)."',
									products_description	=	'".zen_db_input($v_products_description[$key])."',
									".$ep_supported_mods_sql."
									products_url			=	'".zen_db_input($v_products_url[$key])."'
									";

						// langer - the following is redundant - one SQL string is now contructed with various optional mods
						// support for Linda's Header Controller 2.0
						if (isset($v_products_head_title_tag)){
							// override the sql if we're using Linda's contrib
							$sql =
								"INSERT INTO ". DB_DATABASE . "." .TABLE_PRODUCTS_DESCRIPTION."
									(products_id,
									language_id,
									products_name,
									products_description,
									products_url,
									products_head_title_tag,
									products_head_desc_tag,
									products_head_keywords_tag)
									VALUES (
										'" . $v_products_id . "',
										" . $key . ",
										'" . zen_db_input($name) . "',
										'" . zen_db_input($v_products_description[$key]) . "',
										'". $v_products_url[$key] . "',
										'". $v_products_head_title_tag[$key] . "',
										'". $v_products_head_desc_tag[$key] . "',
										'". $v_products_head_keywords_tag[$key] . "')";
						}
						// end support for Linda's Header Controller 2.0
						//echo 'New product desc:'.$sql.'<br />';
						$result = ep_query($con,$sql);
					} else {
						// already in the description, let's just update it
						$sql ="UPDATE ". DB_DATABASE . "." .TABLE_PRODUCTS_DESCRIPTION." SET
									products_name			=	'".zen_db_input($name)."',
									products_description	=	'".zen_db_input($v_products_description[$key])."',
									".$ep_supported_mods_sql."
									products_url			=	'".zen_db_input($v_products_url[$key])."'
								WHERE products_id = '$v_products_id' AND language_id = '$key'";

								
						// langer - below is redundant.
						// support for Lindas Header Controller 2.0
						if (isset($v_products_head_title_tag)){
							// override the sql if we're using Linda's contrib
							$sql =
								"UPDATE ". DB_DATABASE . "." .TABLE_PRODUCTS_DESCRIPTION." SET
									products_name='" . zen_db_input($name) . "',
									products_description = '" . zen_db_input($v_products_description[$key]) . "',
									products_url = '" . $v_products_url[$key] ."',
									products_head_title_tag = '" . $v_products_head_title_tag[$key] ."',
									products_head_desc_tag = '" . $v_products_head_desc_tag[$key] ."',
									products_head_keywords_tag = '" . $v_products_head_keywords_tag[$key] ."'
								WHERE
									products_id = '$v_products_id' AND
									language_id = '$key'";
						}
						// end support for Linda's Header Controller 2.0
						//echo 'existing product desc:'.$sql.'<br />';
						$result = ep_query($con,$sql);
					}
			}
			}
			}
			
			//*************************
			// Products Descriptions End
			//*************************
			
			// langer - Assign product to category if linked
			
			if (isset($v_categories_id)){
				//find out if this product is listed in the category given
				$result_incategory = ep_query($con,'SELECT
							'. DB_DATABASE . "." .TABLE_PRODUCTS_TO_CATEGORIES.'.products_id,
							'. DB_DATABASE . "." .TABLE_PRODUCTS_TO_CATEGORIES.'.categories_id
							FROM
								'. DB_DATABASE . "." .TABLE_PRODUCTS_TO_CATEGORIES.'
							WHERE
							'. DB_DATABASE . "." .TABLE_PRODUCTS_TO_CATEGORIES.'.products_id='.$v_products_id.' AND
							'. DB_DATABASE . "." .TABLE_PRODUCTS_TO_CATEGORIES.'.categories_id='.$v_categories_id);
	
				if (mysqli_num_rows($result_incategory) == 0) {
					// nope, this is a new category for this product

					$res1 = ep_query($con,'INSERT INTO '. DB_DATABASE . "." .TABLE_PRODUCTS_TO_CATEGORIES.' (products_id, categories_id)
								VALUES ("' . $v_products_id . '", "' . $v_categories_id . '")');

					$parent_category_id = $v_categories_id;
					while ($parent_category_id != 0){
						$result_parent_category = ep_query($con,"SELECT cat.parent_id AS catID FROM ". DB_DATABASE . "." .TABLE_CATEGORIES." AS cat, ". DB_DATABASE . "." .TABLE_CATEGORIES_DESCRIPTION." AS des WHERE
							cat.categories_id = des.categories_id AND
							des.language_id = $epdlanguage_id AND
							cat.categories_id = " . $parent_category_id . " LIMIT 1");
						if ( $row_cat = mysqli_fetch_array($result_parent_category) ){ 
							$parent_category_id = $row_cat['catID'];
						}
						if ($parent_category_id != 0){
							ep_query($con,'INSERT INTO '. DB_DATABASE . "." .TABLE_PRODUCTS_TO_CATEGORIES.' (products_id, categories_id)
								VALUES ("' . $v_products_id . '", "' . $parent_category_id . '")');
						}
					}	
					 
					
				} else {
					// already in this category, nothing to do!
				}
					
			}
			
			///************************
			// VJ product attribs begin
			//*************************
			
			if (isset($v_attribute_options_id_1)){
				$has_attributes = true;
				$attribute_rows = 1; // master row count
	
				$languages = zen_get_languages();
	
				// product options count
				$attribute_options_count = 1;
				$v_attribute_options_id_var = 'v_attribute_options_id_' . $attribute_options_count;
				
				// langer - isset & not empty $v_attribute_options_id_1 or v_attribute_options_id_2 etc
				while (isset($$v_attribute_options_id_var) && $$v_attribute_options_id_var != '') {
					// langer - above was: && !empty($$v_attribute_options_id_var)) - this broke because 0 is a legitimate options id value
					// which appears to be not required unless user removes it...
					
					// remove product attribute options linked to this product before proceeding further
					// this is useful for removing attributes linked to a product
					$attributes_clean_query = "delete from " . DB_DATABASE . "." . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . (int)$v_products_id . "' and options_id = '" . (int)$$v_attribute_options_id_var . "'";
					ep_query($con,$attributes_clean_query);
	
					$attribute_options_query = "select products_options_name from " . DB_DATABASE . "." . TABLE_PRODUCTS_OPTIONS . " where products_options_id = '" . (int)$$v_attribute_options_id_var . "'";
					$attribute_options_values = ep_query($con,$attribute_options_query);
	
					// option table update begin
					// langer - does once initially for each model, for all options and languages in upload file
					if ($attribute_rows == 1) {
						// insert into options table if no option exists
						if (mysqli_num_rows($attribute_options_values) <= 0) {
							for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
								$lid = $languages[$i]['id'];
	
								$v_attribute_options_name_var = 'v_attribute_options_name_' . $attribute_options_count . '_' . $lid;
	
								if (isset($$v_attribute_options_name_var)) {
									$attribute_options_insert_query = "insert into ". DB_DATABASE . "."  . TABLE_PRODUCTS_OPTIONS . " (products_options_id, language_id, products_options_name) values ('" . (int)$$v_attribute_options_id_var . "', '" . (int)$lid . "', '" . zen_db_input($$v_attribute_options_name_var) . "')";
									$attribute_options_insert = ep_query($con,$attribute_options_insert_query);
								}
							}
						} else { // update options table, if options already exists
							for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
								$lid = $languages[$i]['id'];
	
								$v_attribute_options_name_var = 'v_attribute_options_name_' . $attribute_options_count . '_' . $lid;
	
								if (isset($$v_attribute_options_name_var)) {
									$attribute_options_update_lang_query = "select products_options_name from " . DB_DATABASE . "." . TABLE_PRODUCTS_OPTIONS . " where products_options_id = '" . (int)$$v_attribute_options_id_var . "' and language_id ='" . (int)$lid . "'";
									$attribute_options_update_lang_values = ep_query($con,$attribute_options_update_lang_query);
	
									// if option name doesn't exist for particular language, insert value
									if (mysqli_num_rows($attribute_options_update_lang_values) <= 0) {
										$attribute_options_lang_insert_query = "insert into " . DB_DATABASE . "."  . TABLE_PRODUCTS_OPTIONS . " (products_options_id, language_id, products_options_name) values ('" . (int)$$v_attribute_options_id_var . "', '" . (int)$lid . "', '" . zen_db_input($$v_attribute_options_name_var) . "')";
										$attribute_options_lang_insert = ep_query($con,$attribute_options_lang_insert_query);
									} else { // if option name exists for particular language, update table
										$attribute_options_update_query = "update " . DB_DATABASE . "." . TABLE_PRODUCTS_OPTIONS . " set products_options_name = '" . zen_db_input($$v_attribute_options_name_var) . "' where products_options_id ='" . (int)$$v_attribute_options_id_var . "' and language_id = '" . (int)$lid . "'";
										$attribute_options_update = ep_query($con,$attribute_options_update_query);
									}
								}
							}
						}
					}
					// option table update end
	
					// product option values count
					$attribute_values_count = 1;
					$v_attribute_values_id_var = 'v_attribute_values_id_' . $attribute_options_count . '_' . $attribute_values_count;
	
					// while (isset($$v_attribute_values_id_var) && !empty($$v_attribute_values_id_var))
					// langer - allowed for 0 value for attributes id also (like options id)... just in case it is possible
					while (isset($$v_attribute_values_id_var) && $$v_attribute_values_id_var != '') {
						$attribute_values_query = "SELECT products_options_values_name FROM " . DB_DATABASE . "." . TABLE_PRODUCTS_OPTIONS_VALUES . " WHERE products_options_values_id = '" . (int)$$v_attribute_values_id_var . "'";
						$attribute_values_values = ep_query($con,$attribute_values_query);
	
						// options_values table update begin
						// langer - does once initially for each model, for all attributes and languages in upload file
						if ($attribute_rows == 1) {
							// insert into options_values table if no option exists
							if (mysqli_num_rows($attribute_values_values) <= 0) {
								for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
									$lid = $languages[$i]['id'];
	
									$v_attribute_values_name_var = 'v_attribute_values_name_' . $attribute_options_count . '_' . $attribute_values_count . '_' . $lid;
	
									if (isset($$v_attribute_values_name_var)) {
										$attribute_values_insert_query = "insert into " . DB_DATABASE . "." . TABLE_PRODUCTS_OPTIONS_VALUES . " (products_options_values_id, language_id, products_options_values_name) values ('" . (int)$$v_attribute_values_id_var . "', '" . (int)$lid . "', '" . zen_db_input($$v_attribute_values_name_var) . "')";
										$attribute_values_insert = ep_query($con,$attribute_values_insert_query);
									}
								}
	
								// insert values to pov2po table
								$attribute_values_pov2po_query = "insert into " . DB_DATABASE . "." . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " (products_options_id, products_options_values_id) values ('" . (int)$$v_attribute_options_id_var . "', '" . (int)$$v_attribute_values_id_var . "')";
								$attribute_values_pov2po = ep_query($con,$attribute_values_pov2po_query);
							} else { // update options table, if options already exists
								for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
									$lid = $languages[$i]['id'];
	
									$v_attribute_values_name_var = 'v_attribute_values_name_' . $attribute_options_count . '_' . $attribute_values_count . '_' . $lid;
	
									if (isset($$v_attribute_values_name_var)) {
										$attribute_values_update_lang_query = "select products_options_values_name from " . DB_DATABASE . "." . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . (int)$$v_attribute_values_id_var . "' and language_id ='" . (int)$lid . "'";
										$attribute_values_update_lang_values = ep_query($con,$attribute_values_update_lang_query);
	
										// if options_values name doesn't exist for particular language, insert value
										if (mysqli_num_rows($attribute_values_update_lang_values) <= 0) {
											$attribute_values_lang_insert_query = "insert into " . DB_DATABASE . "." . TABLE_PRODUCTS_OPTIONS_VALUES . " (products_options_values_id, language_id, products_options_values_name) values ('" . (int)$$v_attribute_values_id_var . "', '" . (int)$lid . "', '" . zen_db_input($$v_attribute_values_name_var) . "')";
											$attribute_values_lang_insert = ep_query($con,$attribute_values_lang_insert_query);
										} else { // if options_values name exists for particular language, update table
											$attribute_values_update_query = "update " . DB_DATABASE . "." . TABLE_PRODUCTS_OPTIONS_VALUES . " set products_options_values_name = '" . zen_db_input($$v_attribute_values_name_var) . "' where products_options_values_id ='" . (int)$$v_attribute_values_id_var . "' and language_id = '" . (int)$lid . "'";
											$attribute_values_update = ep_query($con,$attribute_values_update_query);
										}
									}
								}
							}
						}
						// options_values table update end
	
						// options_values price update begin
						$v_attribute_values_price_var = 'v_attribute_values_price_' . $attribute_options_count . '_' . $attribute_values_count;
	
						if (isset($$v_attribute_values_price_var) && ($$v_attribute_values_price_var != '')) {
							$attribute_prices_query = "select options_values_price, price_prefix from " . DB_DATABASE . "." . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . (int)$v_products_id . "' and options_id ='" . (int)$$v_attribute_options_id_var . "' and options_values_id = '" . (int)$$v_attribute_values_id_var . "'";
							$attribute_prices_values = ep_query($con,$attribute_prices_query);
	
							$attribute_values_price_prefix = ($$v_attribute_values_price_var < 0) ? '-' : '+';
	
							// options_values_prices table update begin
							// insert into options_values_prices table if no price exists
							if (mysqli_num_rows($attribute_prices_values) <= 0) {
								$attribute_prices_insert_query = "insert into " . DB_DATABASE . "." . TABLE_PRODUCTS_ATTRIBUTES . " (products_id, options_id, options_values_id, options_values_price, price_prefix) values ('" . (int)$v_products_id . "', '" . (int)$$v_attribute_options_id_var . "', '" . (int)$$v_attribute_values_id_var . "', '" . (float)$$v_attribute_values_price_var . "', '" . zen_db_input($attribute_values_price_prefix) . "')";
								$attribute_prices_insert = ep_query($con,$attribute_prices_insert_query);
							} else { // update options table, if options already exists
								$attribute_prices_update_query = "update " . DB_DATABASE . "." . TABLE_PRODUCTS_ATTRIBUTES . " set options_values_price = '" . $$v_attribute_values_price_var . "', price_prefix = '" . $attribute_values_price_prefix . "' where products_id = '" . (int)$v_products_id . "' and options_id = '" . (int)$$v_attribute_options_id_var . "' and options_values_id ='" . (int)$$v_attribute_values_id_var . "'";
								$attribute_prices_update = ep_query($con,$attribute_prices_update_query);
							}
						}
						// options_values price update end
	
						$attribute_values_count++;
						$v_attribute_values_id_var = 'v_attribute_values_id_' . $attribute_options_count . '_' . $attribute_values_count;
					}
	
					$attribute_options_count++;
					$v_attribute_options_id_var = 'v_attribute_options_id_' . $attribute_options_count;
				}
	
				$attribute_rows++;
				
			}
			
			
			//*************************
			// VJ product attribs end
			//*************************
			
			/**
			* Specials
			* if a null value in specials price, do not add or update. If price = 0, let's delete it
			*/
			if (isset($v_specials_price) && zen_not_null($v_specials_price)) {
				if ($v_specials_price >= $v_products_price) {
					$specials_print .= sprintf(EASYPOPULATE_SPECIALS_PRICE_FAIL, $v_products_model, substr(strip_tags($v_products_name[$epdlanguage_id]), 0, 10));
					//available function: zen_set_specials_status($specials_id, $status)
					// could alternatively make status inactive, and still upload..
					continue;
				}
				// column is in upload file, and price is in field (not empty)
				// if null (set further above), set forever, else get raw date
				$has_specials == true;
				$v_specials_date_avail = ($v_specials_date_avail == true) ? date("Y-m-d H:i:s",strtotime($v_specials_date_avail)) : "0001-01-01";
				$v_specials_expires_date = ($v_specials_expires_date == true) ? date("Y-m-d H:i:s",strtotime($v_specials_expires_date)) : "0001-01-01";
				
				//Check if this product already has a special
				$special = ep_query($con,  "SELECT products_id
																FROM " . DB_DATABASE . "." . TABLE_SPECIALS . "
																WHERE products_id = ". $v_products_id);
																
				if (mysqli_num_rows($special) == 0) {
					// not in db..
					if ($v_specials_price == '0') {
						// delete requested, but is not a special
						$specials_print .= sprintf(EASYPOPULATE_SPECIALS_DELETE_FAIL, $v_products_model, substr(strip_tags($v_products_name[$epdlanguage_id]), 0, 10));
						continue;
					}
					
								// insert new into specials
								$sql =  "INSERT INTO " . DB_DATABASE . "." . TABLE_SPECIALS . "
												(products_id,
												specials_new_products_price,
												specials_date_added,
												specials_date_available,
												expires_date,
												status)
												VALUES (
														'" . (int)$v_products_id . "',
														'" . $v_specials_price . "',
														now(),
														'" . $v_specials_date_avail . "',
														'" . $v_specials_expires_date . "',
														'1')";
								$result = ep_query($con,$sql);
								$specials_print .= sprintf(EASYPOPULATE_SPECIALS_NEW, $v_products_model, substr(strip_tags($v_products_name[$epdlanguage_id]), 0, 10), $v_products_price , $v_specials_price);
								
				} else {
					// existing product
					
					if ($v_specials_price == '0') {
						// delete of existing requested
						$db->Execute("delete from " . TABLE_SPECIALS . "
									 where products_id = '" . (int)$v_products_id . "'");
						$specials_print .= sprintf(EASYPOPULATE_SPECIALS_DELETE, $v_products_model);
						continue;
					}
								// just make an update
								$sql =  "UPDATE " . DB_DATABASE . "." . TABLE_SPECIALS . " SET
												specials_new_products_price = '" . $v_specials_price . "',
												specials_last_modified = now(),
												specials_date_available = '" . $v_specials_date_avail . "',
												expires_date = '" . $v_specials_expires_date . "',
												status = '1'
												WHERE products_id = '" . (int)$v_products_id . "'";
								//echo $sql . "<br>";
								ep_query($con,$sql);
								$specials_print .= sprintf(EASYPOPULATE_SPECIALS_UPDATE, $v_products_model, substr(strip_tags($v_products_name[$epdlanguage_id]), 0, 10), $v_products_price , $v_specials_price);
				}
				// we still have our special here..
			}
			// end specials for this product
		
		} else {
			// this record is missing the product_model
			$display_output .= EASYPOPULATE_DISPLAY_RESULT_NO_MODEL;
			foreach ($items as $col => $langer) {
				if ($col == $filelayout['v_products_model']) continue;
				$display_output .= print_el($langer);
			}
		}
		// end of row insertion code
	}
	
	$display_output .= EASYPOPULATE_DISPLAY_RESULT_UPLOAD_COMPLETE;
	
	}
	
	/**
	* Post-upload tasks start
	*/
		
	// update price sorter
	ep_update_prices();
	
	// specials status = 0 if date_expires is past..
	if ($has_specials == true) {
		// specials were in upload
		zen_expire_specials();
	}
		
	// update attributes sort order when all processed
	if ($has_attributes == true) {
		// attributes were in upload
		ep_update_attributes_sort_order();
	}
	
	/**
	* Post-upload tasks end
	*/
	
}

// END FILE UPLOADS

// if we had an SQL error anywhere, let's tell the user..maybe they can sort out why
if ($ep_stack_sql_error == true) $messageStack->add(EASYPOPULATE_MSGSTACK_ERROR_SQL, 'caution');

/**
* this is a rudimentary date integrity check for references to any non-existant product_id entries
* this check ought to be last, so it checks the tasks just performed as a quality check of EP...
* langer - to add: data present in table products, but not in descriptions.. user will need product info, and decide to add description, or delete product
*/
if ($_GET['dross'] == 'delete') {
	// let's delete data debris as requested...
	ep_purge_dross();
	// now check it is really gone...
	$dross = ep_get_dross();
	if (zen_not_null($dross)) {
		$string = "Product debris corresponding to the following product_id(s) cannot be deleted by EasyPopulate:\n";
		foreach ($dross as $products_id => $langer) {
			$string .= $products_id . "\n";
		}
		$string .= "It is recommended that you delete this corrupted data using phpMyAdmin.\n\n";
		write_debug_log($string);
		$messageStack->add(EASYPOPULATE_MSGSTACK_DROSS_DELETE_FAIL, 'caution');
	} else {
		$messageStack->add(EASYPOPULATE_MSGSTACK_DROSS_DELETE_SUCCESS, 'success');
	}
} else { // elseif ($_GET['dross'] == 'check')
	// we can choose a config option: check always, or only on clicking a button
	// default action when not deleting existing debris is to check for it and alert when discovered..
	$dross = ep_get_dross();
	if (zen_not_null($dross)) {
		$messageStack->add(sprintf(EASYPOPULATE_MSGSTACK_DROSS_DETECTED, count($dross), zen_href_link(FILENAME_EASYPOPULATE, 'dross=delete')), 'caution');
	}
}

/**
* Changes planned for below
* 1) 1 input field for local and server updating
* 2) default to update directly from HDD, with option to upload to temp, or update from temp
* 3) List temp files with upload, delete, etc options
* 4) Auto detecting of mods - display list of (only) installed mods, with check-box to include in download
* 5) may consider an auto-splitting feature if it can be done.
*     Will detect speed of server, safe_mode etc and determine what splitting level is required (can be over-ridden of course)
*/

// all html templating is now below here.
?>
<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
	<title><?php echo TITLE; ?></title>
	<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
	<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
	<script language="javascript" src="includes/menu.js"></script>
	<script language="javascript" src="includes/general.js"></script>
	<script type="text/javascript">
		<!--
		function init()
		{
		cssjsmenu('navbar');
		if (document.getElementById)
		{
		var kill = document.getElementById('hoverJS');
		kill.disabled = true;
		}
		}
		// -->
	</script>
</head>
<body onLoad="init()">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
	<table border="0" width="100%" cellspacing="2" cellpadding="2">
		<tr>
<!-- body_text //-->
			<td width="100%" valign="top">
<?php
				echo zen_draw_separator('pixel_trans.gif', '1', '10');
?>
				<table border="0" width="100%" cellspacing="0" cellpadding="0">
					<tr>
						<td class="pageHeading"><?php echo "Easy Populate $curver"; ?></td>
					</tr>
				</table>
<?php
				echo zen_draw_separator('pixel_trans.gif', '1', '10');
?>
				<table border="0" width="100%" cellspacing="0" cellpadding="0">
					<tr>
						<td valign="top">
				
							<table width="70%" border="0" cellpadding="8" valign="top">
								<tr>
									<td width="100%">
										<p>
											<form ENCTYPE="multipart/form-data" ACTION="easypopulate.php" METHOD="POST">
												<div align = "left">
													<b>Upload EP File</b><br />
													<input TYPE="hidden" name="MAX_FILE_SIZE" value="100000000">
													<input name="usrfl" type="file" size="50">
													<input type="submit" name="buttoninsert" value="Insert into db">
													<br />
												</div>
											</form>
											<br>
											<form ENCTYPE="multipart/form-data" ACTION="easypopulate.php" METHOD="POST">
												<div align = "left">
													<b>Import from Temp Dir (<? echo $tempdir; ?>)</b><br />
													<input TYPE="text" name="localfile" size="50">
													<input type="submit" name="buttoninsert" value="Insert into db">
													<br />
												</div>
											</form>
										</p>
										<b>Download EP and Froogle Files</b>
										<br /><br />
										<!-- Download file links -  Add your custom fields here -->
										<a href="easypopulate.php?download=stream&dltype=full">Download <b>Complete</b> .csv file to edit</a>
<?php if ($products_with_attributes == true) { ?>
										<span class="fieldRequired"> (Attributes Included)</span>
<?php } else { ?>
										<span class="fieldRequired"> (Attributes Not Included)</span>
<?php } ?>
										<br />
										<a href="easypopulate.php?download=stream&dltype=priceqty">Download <b>Model/Price/Qty</b> .csv file to edit</a><br />
										<a href="easypopulate.php?download=stream&dltype=modqty">Download <b>Model/Price/Qty/Last Modified/Status</b> .csv file to edit</a><br />
										<a href="easypopulate.php?download=stream&dltype=category">Download <b>Model/Category</b> .csv file to edit</a><br />
										<a href="easypopulate.php?download=stream&dltype=froogle">Download <b>Froogle</b> tab-delimited .txt file</a><br />
										<a href="easypopulate.php?download=stream&dltype=attrib">Download <b>Model/Attributes</b> .csv file</a>
										<br /><br />
										<b>Create EP and Froogle Files in Temp Dir: <a href="../<?=$tempdir ?>"><?=$tempdir ?></a></b>
										<br /><br />
										<a href="easypopulate.php?download=tempfile&dltype=full">Create <b>Complete</b> .csv file in temp dir</a>
<?php if ($products_with_attributes == true) { ?>
										<span class="fieldRequired"> (Attributes Included)</span>
<?php } else { ?>
										<span class="fieldRequired"> (Attributes Not Included)</span>
<?php } ?>
										<br />
										<a href="easypopulate.php?download=tempfile&dltype=priceqty">Create <b>Model/Price/Qty</b> .csv file in temp dir</a><br />
										<a href="easypopulate.php?download=tempfile&dltype=modqty">Create <b>Model/Price/Qty/Last Modified/Status</b> .csv file in temp dir</a><br />
										<a href="easypopulate.php?download=tempfile&dltype=category">Create <b>Model/Category</b> .csv file in temp dir</a><br />
										<a href="easypopulate.php?download=tempfile&dltype=froogle">Create <b>Froogle</b> tab-delimited .txt file in temp dir</a><br />
										<a href="easypopulate.php?download=tempfile&dltype=attrib">Create <b>Model/Attributes</b> .csv file in temp dir</a><br />
									</td>
								</tr>
							</table>
<?php
							echo '<br />' . $printsplit; // our files splitting matrix
							echo $display_output; // upload results
							if (strlen($specials_print) > strlen(EASYPOPULATE_SPECIALS_HEADING)) {
								echo '<br />' . $specials_print . EASYPOPULATE_SPECIALS_FOOTER; // specials summary
							}
							
							include(DIR_FS_CATALOG . $tempdir . 'fileList.php');
?>

						</td>
					</tr>
				</table>
	
			</td>
<!-- body_text_eof //-->
		</tr>
	</table>
<!-- body_eof //-->
	<br />
<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>