<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=shopping_cart.<br />
 * Displays shopping-cart contents
 *
 * @package templateSystem
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_shopping_cart_default.php 15881 2010-04-11 16:32:39Z wilt $
 */
?>
<div class="centerColumn" id="shoppingCartDefault">
<?php
  if ($flagHasCartContents) {
?>

<?php
  if ($_SESSION['cart']->count_contents() > 0) {
?>
<!--<div class="forward"><?php //echo TEXT_VISITORS_CART; ?></div>-->
<?php
  }
?>
<div class="title-box">
		<h2 class="text-center text-uppercase title-under"><?php echo TEXT_SHOPPING_CART; ?></h2>
</div>

<?php if ($messageStack->size('shopping_cart') > 0) echo $messageStack->output('shopping_cart'); ?>

<?php echo zen_draw_form('cart_quantity', zen_href_link(FILENAME_SHOPPING_CART, 'action=update_product', $request_type)); ?>
<!--<div id="cartInstructionsDisplay" class="content"><?php //echo TEXT_INFORMATION; ?></div>-->
<?php if (!empty($totalsDisplay)) { ?>
  <!--<div class="cartTotalsDisplay important"><?php //echo $totalsDisplay; ?></div>-->

<?php } ?>

<?php  if ($flagAnyOutOfStock) { ?>

<?php    if (STOCK_ALLOW_CHECKOUT == 'true') {  ?>

          <div class="alert alert-danger alert-dismissable"><?php echo OUT_OF_STOCK_CAN_CHECKOUT; ?></div>
      <?php    
        } 
        else { 
        ?>
            <div class="alert alert-danger alert-dismissable"><?php echo OUT_OF_STOCK_CANT_CHECKOUT; ?></div>

        <?php    
            } //endif STOCK_ALLOW_CHECKOUT 
          ?>
    <?php 
      } //endif flagAnyOutOfStock 
    ?>
</form>
<div class="cart-container">
    <div class="table-responsive table-container">
        <table class="table table-bordered">
             <tr class="tableHeading">
                <th scope="col" id="scProductsHeading"><?php echo TABLE_HEADING_PRODUCTS_IMAGE; ?></th>
                <th scope="col" id="scProductsHeading"><?php echo TABLE_HEADING_PRODUCTS_NAME; ?></th>
                <th scope="col" id="scUnitHeading"><?php echo TABLE_HEADING_PRICE; ?></th>
                <th scope="col" id="scQuantityHeading"><?php echo TABLE_HEADING_QUANTITY; ?></th>
                <th scope="col" id="scUpdateQuantity"><?php echo TABLE_HEADING_UPDATE; ?></th>
                <th scope="col" id="scRemoveHeading"><?php echo TABLE_HEADING_DELETE; ?></th>
                <th scope="col" id="scTotalHeading"><?php echo TABLE_HEADING_TOTAL; ?></th>
             </tr>
                 <!-- Loop through all products /-->
            <?php
                foreach ($productArray as $product) {
            ?>
             <tr class="<?php echo $product['rowClass']; ?>">
                <td class="cartProductDisplay img" valign="middle" width="20%" padding="0">
                    <span id="cartImage" class="back">
                        <?php echo $product['productsImage']; ?>
                    </span>
               </td>
               <td class="details">
               		<div class="product-desc">
                        <h5 class="shopping-cart-table__product-name text-left text-uppercase">
                            <a href="<?php echo $product['linkProductsName']; ?>"><?php echo $product['productsName']; ?></a>
                        </h5>
                        <span class="alert-text bold"> <?php echo $product['flagStockCheck']; ?> </span>
                        <?php
                          echo $product['attributeHiddenField'];
                          if (isset($product['attributes']) && is_array($product['attributes'])) {
                          echo '<div class="cartAttribsList">';
                          echo '<ul class="shopping-cart-table__list-parameters">';
                            reset($product['attributes']);
                            foreach ($product['attributes'] as $option => $value) {
                        ?>
                        <li><?php echo $value['products_options_name'] . TEXT_OPTION_DIVIDER . nl2br($value['products_options_values_name']); ?></li>
                        <?php
                            }
                          echo '</ul>';
                          echo '</div>';
                          }
                        ?>
                  	</div>
               </td>
               <td class="cartUnitDisplay">
									<div class="shopping-cart-table__product-price unit-price">
										<?php echo $product['productsPriceEach']; ?>
									</div>
							 </td>
               <td class="cartQuantity">
									<div class="shopping-cart-table__input">
										<?php
											if ($product['flagShowFixedQuantity']) {
												echo $product['showFixedQuantityAmount'] . '<span class="alert-text bold">' . $product['flagStockCheck'] . '</span>' . $product['showMinUnits'];
											} else {
												echo $product['quantityField'] . '<span class="alert-text bold">' . $product['flagStockCheck'] . '</span>' . $product['showMinUnits'];
											}
										?>
									</div>
              </td>
              <td class="cartQuantityUpdate">
                <?php
                  if ($product['buttonUpdate'] == '') {
                   echo '' ;
                  } else {
                    echo $product['buttonUpdate'];
                  }
                    //echo zen_image_submit(ICON_IMAGE_UPDATE, ICON_UPDATE_ALT);
                ?>
               </td>
               <td class="cartRemoveItemDisplay">
                <?php
                  if ($product['buttonDelete']) {
                ?>
                	<a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART, 'action=remove_product&product_id=' . $product['id'], 'SSL'); ?>">
                    	<?php echo zen_image($template->get_template_dir(ICON_IMAGE_TRASH, DIR_WS_TEMPLATE, $current_page_base,'images/icons'). '/' . ICON_IMAGE_TRASH, ICON_TRASH_ALT); ?>
                  	</a>
                <?php
                  }
                  /*if ($product['checkBoxDelete'] ) {
                    echo zen_draw_checkbox_field('cart_delete[]', $product['id']);
                  }*/
                ?>
                </td>
               <td class="cartTotalDisplay">
									<div class="shopping-cart-table__product-price unit-price">
										<?php echo $product['productsPrice']; ?>
									</div>
							 </td>
             </tr>
                <?php
                  } // end foreach ($productArray as $product)
                ?>
             <!-- Finished loop through all products /-->
    	</table>
    </div>
    <div id="cartSubTotal">
			<div class="shopping-cart-table__product-price unit-price">
				<strong><?php echo SUB_TITLE_SUB_TOTAL; ?></strong>
				<?php echo $cartShowTotal; ?>
			</div>
		</div>
	<div class="divider divider--xs"> 
  </div>
	<!--bof shopping cart buttons-->
</div>


<!-- ** BEGIN PAYPAL EXPRESS CHECKOUT ** -->
<?php  // the tpl_ec_button template only displays EC option if cart contents >0 and value >0
if (defined('MODULE_PAYMENT_PAYPALWPP_STATUS') && MODULE_PAYMENT_PAYPALWPP_STATUS == 'True') {
  include(DIR_FS_CATALOG . DIR_WS_MODULES . 'payment/paypal/tpl_ec_button.php');
}
?>
<!-- ** END PAYPAL EXPRESS CHECKOUT ** -->

<?php
      if (SHOW_SHIPPING_ESTIMATOR_BUTTON == '2') {
/**
 * load the shipping estimator code if needed
 */
?>
	<div class="shippingEstimatorCont">
      <?php require(DIR_WS_MODULES . zen_get_module_directory('shipping_estimator.php')); ?>

<?php
      }
?>
<div class="clearBoth"></div>
<?php if (COWOA_STATUS == 'true') { ?> 
<!--quick shopping-->
<?php echo zen_draw_form('no_account', zen_href_link('quick_shopping', '', 'SSL'), 'post', 'onsubmit="return check_form(no_account);"') . zen_draw_hidden_field('action', 'process') . zen_draw_hidden_field('email_pref_html', 'email_format'); ?>
<?php if (!$_SESSION['customer_id']) { ?>
<div id="withOutAccount">
	<h2>Non - Paiement Par Compte</h2>
	<p>Pour une expérience pratique, nous offrons l'option de vérifier sans créer un compte.</p>
	<p>Si vous avez notre compte, vous pouvez Clic <a href="<?php echo zen_href_link('login');?>" rel="nofollow" style="color:red;"><em>Page de connexion</em></a>, Ou  <a href="<?php echo zen_href_link('create_account');?>" rel="nofollow" style="color:red;">Créer un compte</a>
  </p>
	<p class="forward"><a href="<?php echo zen_href_link('password_forgotten');?>" style="color:red;">Vous avez perdu votre mot de passe?</a></p>
</div>
<?php } ?>

<div class="clearBoth"></div>
<!--address-->
<?php 
if (!$_SESSION['customer_id']) {
/*
 * Set flags for template use:
 */
  $selected_country = (isset($_POST['zone_country_id']) && $_POST['zone_country_id'] != '') ? $country : SHOW_CREATE_ACCOUNT_DEFAULT_COUNTRY;
  $flag_show_pulldown_states = ((($process == true || $entry_state_has_zones == true) && $zone_name == '') || ACCOUNT_STATE_DRAW_INITIAL_DROPDOWN == 'true' || $error_state_input) ? true : false;
  $flag_show_pulldown_states = true;
  $state = ($flag_show_pulldown_states) ? ($state == '' ? '&nbsp;' : $state) : $zone_name;
  $state_field_label = ($flag_show_pulldown_states) ? '' : ENTRY_STATE;
  if (!isset($email_format)) $email_format = (ACCOUNT_EMAIL_PREFERENCE == '1' ? 'HTML' : 'TEXT');
  if (!isset($newsletter))   $newsletter = (ACCOUNT_NEWSLETTER_STATUS == '1' ? false : true);
  require($template->get_template_dir('tpl_modules_no_account.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_no_account.php'); 
}else{
  echo '<fieldset><legend><div>Your Shipping Address</div></legend>';
  echo '<div style="padding:5px;">'.zen_address_label($_SESSION['customer_id'], (isset($_SESSION['sendto'])?$_SESSION['sendto']:$_SESSION['customer_default_address_id']), true, ' ', '<br />').'</div>';
  echo '<div class="forward buttonRow"><a href="' . zen_href_link('checkout_shipping_address', '', 'SSL') . '" class='. 
  '"btn btn--ys btn--sm'. '" >' . zen_image_button(BUTTON_IMAGE_CHANGE_ADDRESS, BUTTON_CHANGE_ADDRESS_ALT) . '</a></div>';
  echo '</fieldset>';
}
?>
<fieldset>
<legend><div>Note Spéciale ou Note de Commande</div></legend>
<?php echo zen_draw_textarea_field('comments', '100', '5','', 'id="sp_comments"' . 'onblur="' . "cooki('sp_comments')" . '"'); ?>
</fieldset>
<div class="clearBoth"></div>
<!--end address-->
<!--payment-->
<div class="back" style="width:100%;">
<?php
require(DIR_WS_CLASSES . 'payment.php');
$payment_modules = new payment;	
?>
<fieldset id="paymentSelect">
<legend><div>Mode de Paiement</div></legend>
<!-- <br class="clearBoth" /> -->
<?php $selection = $payment_modules->selection();
      if (sizeof($selection) == 0) {?>
<p class="important"><span class="alert">Sorry, we are not accepting payments from your region at this time.</span><br />Please contact us for alternate arrangements.</p>
<?php }
$radio_buttons = 0;
for ($i=0, $n=sizeof($selection); $i<$n; $i++) {
if (sizeof($selection) > 1) {
    if (empty($selection[$i]['noradio'])) { 
    echo zen_draw_radio_field('payment', $selection[$i]['id'], ($selection[$i]['id'] == $_SESSION['payment'] ? true : false), 'id="pmt-'.$selection[$i]['id'].'"'); 
    } 
} else {
echo zen_draw_hidden_field('payment', $selection[$i]['id'], 'id="pmt-'.$selection[$i]['id'].'"'); 
}?>

<label for="pmt-<?php echo $selection[$i]['id']; ?>" class="radioButtonLabel"><?php echo $selection[$i]['module']; ?></label>
<br class="clearBoth">
<?php if (isset($selection[$i]['error'])){?>
<div><?php echo $selection[$i]['error']; ?></div>
<?php } elseif (isset($selection[$i]['fields']) && is_array($selection[$i]['fields'])) {?>
<div class="ccinfo">
<?php for ($j=0, $n2=sizeof($selection[$i]['fields']); $j<$n2; $j++) {?>
<label <?php echo (isset($selection[$i]['fields'][$j]['tag']) ? 'for="'.$selection[$i]['fields'][$j]['tag'] . '" ' : ''); ?>class="inputLabelPayment"><?php echo $selection[$i]['fields'][$j]['title']; ?></label><?php echo $selection[$i]['fields'][$j]['field']; ?>
<?php }?>
</div>
<?php }
$radio_buttons++;?>
<?php }//eof: for $selection?>
</fieldset>
</div>
<!--end payment-->
<div class="clearBoth"></div>
<!--shipping-->
<?php
//require(DIR_WS_CLASSES . 'shipping.php');
$shipping_modules = new shipping();
$quotes = $shipping_modules->quote();
?>
<fieldset id="shippingSelect">
<legend><div>Procédé de Transport:</div></legend>
<?php
$radio_buttons = 0;
for ($i=0, $n=sizeof($quotes); $i<$n; $i++) {
for ($j=0, $n2=sizeof($quotes[$i]['methods']); $j<$n2; $j++) {
$checked = (($quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'] == $_SESSION['shipping']['id']) ? true : false);
?>
<span>

<?php if (sizeof($quotes) > 1 && sizeof($quotes[0]) > 1) {
    echo zen_draw_radio_field('shipping', $i, $checked, 'id="ship-'.$quotes[$i]['id'] . '-' . str_replace(' ', '-', $quotes[$i]['methods'][$j]['id']) .'"'); ?>
<?php }else{ 
   echo '<input type="hidden" name="shipping" value="'.$i.'" />'; 
      }	
?>


<label for="ship-<?php echo $quotes[$i]['id'] . '-' . str_replace(' ', '-', $quotes[$i]['methods'][$j]['id']); ?>" class="checkboxLabel" ><?php echo $quotes[$i]['module']; ?></label>
<div class="important forward"><?php echo $currencies->format($quotes[$i]['methods'][$j]['cost']); ?></div>
</span>
<br class="clearBoth" />
<?php
$radio_buttons++;
}     
}
?>
</fieldset>
<!--end shipping-->
<div class="clearBoth"></div>
<!--total-->
<fieldset>
<legend id="checkoutPaymentHeadingTotal"><div>Votre Nombre Total</div></legend>
<div id="checkoutOrderTotals">
<img style="float:right;" src="<?php echo DIR_WS_TEMPLATE;?>images/home_loading.gif">
</div>
</fieldset>
<script>
	$(document).ready(function(){
$("#checkoutOrderTotals").load('<?php echo zen_href_link('ajax_order_total');?>');
$("#paymentSelect input:radio").click(function(){
	 $("#checkoutOrderTotals").html('<img style="float:right;" src="<?php echo DIR_WS_TEMPLATE;?>images/home_loading.gif">');
	 $.post("<?php echo zen_href_link('ajax_order_total');?>",{payment:$(this).val()},
		     function(data){
               $("#checkoutOrderTotals").load('<?php echo zen_href_link('ajax_order_total');?>');
			 }, "json");
});
$("#shippingSelect input:radio").click(function(){
	$("#checkoutOrderTotals").html('<img style="float:right;" src="<?php echo DIR_WS_TEMPLATE;?>images/home_loading.gif">');
	 $.post("<?php echo zen_href_link('ajax_order_total');?>",{shipping:$(this).val()},
		     function(data){
               $("#checkoutOrderTotals").load('<?php echo zen_href_link('ajax_order_total');?>');
			 }, "json");
});
	});
</script>
<!--end total-->
<div class="buttonRow forward"><?php echo zen_image_submit(BUTTON_IMAGE_CONFIRM_ORDER, BUTTON_CONFIRM_ORDER_ALT); ?></div>
</form>
<!--end quick shopping-->
<?php }?>

<?php
  } else {
?>

<!-- <h2 id="cartEmptyText"><?php echo TEXT_CART_EMPTY; ?></h2> -->
<h6 id="cartEmptyText" style="float: left;"><?php echo TEXT_CART_EMPTY; ?></h2>
<?php
	$show_display_shopping_cart_empty = $db->Execute(SQL_SHOW_SHOPPING_CART_EMPTY);
	while (!$show_display_shopping_cart_empty->EOF) {
	?>
	<?php
	  if ($show_display_shopping_cart_empty->fields['configuration_key'] == 'SHOW_SHOPPING_CART_EMPTY_FEATURED_PRODUCTS') { ?>
	<?php
	/**
	 * display the Featured Products Center Box
	 */
	?>
		<?php //require($template->get_template_dir('tpl_modules_featured_products.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_featured_products.php'); ?>
	<?php } ?>
	<?php
	  if ($show_display_shopping_cart_empty->fields['configuration_key'] == 'SHOW_SHOPPING_CART_EMPTY_SPECIALS_PRODUCTS') { ?>
	<?php
	/**
	 * display the Special Products Center Box
	 */
	?>
	<?php //require($template->get_template_dir('tpl_modules_specials_default.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_specials_default.php'); ?>
	<?php } ?>

	<?php
	  if ($show_display_shopping_cart_empty->fields['configuration_key'] == 'SHOW_SHOPPING_CART_EMPTY_NEW_PRODUCTS') { ?>
	<?php
	/**
	 * display the New Products Center Box
	 */
	?>
	<?php //require($template->get_template_dir('tpl_modules_whats_new.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_whats_new.php'); ?>
	<?php } ?>

	<?php
	  if ($show_display_shopping_cart_empty->fields['configuration_key'] == 'SHOW_SHOPPING_CART_EMPTY_UPCOMING') {
		//include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_UPCOMING_PRODUCTS));
	  }
	?>
	<?php
	  $show_display_shopping_cart_empty->MoveNext();
	} // !EOF
	?>
<?php
  }
?>
</div>
</div>
</div>
<script src="<?php  echo $template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'jscript').'/jquery.cookie.js'?>" type="text/javascript"></script>
<script type="text/javascript">
  function cooki(v){
      var value = $('#' + v).val();
      if (value != ''){
          $.cookie(v,value,{expires:1});
      }
  }
  $(function (){
      var company = $.cookie('company');
      var firstname = $.cookie('firstname');
      var lastname = $.cookie('lastname');
      var street_address = $.cookie('street-address');
      var suburb = $.cookie('suburb');
      var city = $.cookie('city');
      var state = $.cookie('state');
      var email_address = $.cookie('email-address');
      var postcode = $.cookie('postcode');
      var telephone = $.cookie('telephone');
      var customers_referral = $.cookie('customers_referral');
      var sp_comments = $.cookie('sp_comments');
      if (company != '' && company != 'undefined' && company != 'null') {
        $('#company').val(company);
      }
      if (firstname != '' && firstname != 'undefined' && firstname != 'null') {
        $('#firstname').val(firstname);
      }
      if (lastname != '' && lastname != 'undefined' && lastname != 'null') {
        $('#lastname').val(lastname);
      }
      if (street_address != '' && street_address != 'undefined' && street_address != 'null') {
        $('#street-address').val(street_address);
      }
      if (suburb != '' && suburb != 'undefined' && suburb != 'null') {
        $('#suburb').val(suburb);
      }
      if ( city != '' && city != 'undefined' && city != 'null') {
        $('#city').val(city);
      }
      if ( state != '' && state != 'undefined' && state != 'null') {
        $('#state').val(state);
      }
      if ( email_address != '' && email_address != 'undefined' && email_address != 'null') {
        $('#email-address').val(email_address);
      }
      if ( postcode != '' && postcode != 'undefined' && postcode != 'null') {
        $('#postcode').val(postcode);
      }
      if (telephone != '' && telephone != 'undefined' && telephone != 'null') {
        $('#telephone').val(telephone);
      }
      if (customers_referral != '' && customers_referral != 'undefined' && customers_referral != 'null') {
        $('#customers_referral').val(customers_referral);
      }
      if (sp_comments != '' && sp_comments != 'undefined' && sp_comments != 'null') {
        $('#sp_comments').val(sp_comments);
      }
  });
</script>
