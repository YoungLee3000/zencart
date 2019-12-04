<?php
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

if (!$_SESSION['customer_id']) {
   include(DIR_WS_MODULES . zen_get_module_directory('no_account_quick.php'));
}
if($error){
   zen_redirect(zen_href_link('shopping_cart', '', 'SSL'));
}
if (!$_SESSION['customer_id']) {
  $messageStack->add_session('shopping_cart', 'Please enter the right address', 'error');
  zen_redirect(zen_href_link('shopping_cart', '', 'SSL'));
}
if (isset($_POST['comments'])) $_SESSION['comments'] = zen_db_prepare_input($_POST['comments']);
$_SESSION['sendto'] = $_SESSION['customer_default_address_id'];
$_SESSION['billto'] = $_SESSION['customer_default_address_id'];
if (isset($_POST['payment'])) {
	$_SESSION['payment'] = $_POST['payment'];
}
require(DIR_WS_CLASSES . 'shipping.php');
$shipping_modules = new shipping();
$quotes = $shipping_modules->quote();
if (isset($_POST['shipping'])) {
	$_SESSION['shipping'] = array('id' => $quotes[$_POST['shipping']]['id'],
                                 'title' => ($quotes[$_POST['shipping']]['module']),
                                 'cost' => $quotes[$_POST['shipping']]['methods'][0]['cost']);
}
unset($shipping_modules);
if (!$_SESSION['shipping']) {
  $messageStack->add_session('shopping_cart', 'Please select one shipping methods', 'error');
  zen_redirect(zen_href_link('shopping_cart', '', 'SSL'));
}
if (!$_SESSION['payment']) {
  $messageStack->add_session('shopping_cart', 'Please select one payment methods', 'error');
  zen_redirect(zen_href_link('shopping_cart'));
}

if(COWOA_ONE_OR_TWO == 'one'){//一步支付

$shipping_modules = new shipping($_SESSION['shipping']);

require(DIR_WS_CLASSES . 'payment.php');
$payment_modules = new payment($_SESSION['payment']);
$payment_modules->update_status();

require(DIR_WS_CLASSES . 'order.php');
$order = new order; //放在shipping和payment类后；收集配送和付款信息

require(DIR_WS_CLASSES . 'order_total.php');
$order_total_modules = new order_total;
$order_total_modules->collect_posts();
$order_total_modules->pre_confirmation_check();

$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_BEFORE_ORDER_TOTALS_PROCESS');
$order_totals = $order_total_modules->process();//处理订单信息
$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_AFTER_ORDER_TOTALS_PROCESS');

$confirmation = $payment_modules->confirmation();

if (isset($$_SESSION['payment']->form_action_url)) {
   echo '<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Payment Redirecting</title>
<style type="text/css">
body {text-align:center;}
#wrapper{width:411px; margin:130px auto 0; background:none repeat scroll 0 0 #FFFFFF; border:1px solid #B5B5B5;	text-align:center;	-moz-border-radius:5px 5px 5px 5px;font:13px Helvetica,Arial,sans-serif; color:#454545}
#wrapper h1{color:#5F5F5F;font-size:22px;font-weight:normal;margin:22px 0 26px;padding:0;}
#wrapper p{cmargin:0 0 12px;padding:0;}
#wrapper img{margin-bottom:35px;}
.forbid{text-align:center; font-size:16px; padding-top:10px;}
</style>
</head>
<body onload="return document.checkout_confirmation.submit();">
<div style="text-align:center;width:100%"><div id="wrapper">
<h1>Please wait while you\'re redirected</h1>
<p>Redirecting...</p>
<img src="includes/images/redirection-loader.gif" alt="loading...">
</div></div>
'. zen_draw_form('checkout_confirmation', $$_SESSION['payment']->form_action_url, 'post')
. $$_SESSION['payment']->process_button()
.'<center><input name="submit" type="image" style="margin:0 auto" src="includes/images/ie1hJo.png" ></center>
</form>
</body></html>';
//$_SESSION['cart']->reset(true);
  exit;
}

$payment_modules->before_process();
$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_AFTER_PAYMENT_MODULES_BEFOREPROCESS');

require(DIR_WS_MODULES . zen_get_module_directory('checkout_process_quick.php'));

$_SESSION['cart']->reset(true);
unset($_SESSION['sendto']);
unset($_SESSION['shipping']);
$order_total_modules->clear_posts();

$payment_modules->after_process();

zen_redirect(zen_href_link('checkout_success'));
}else{  //两步支付
zen_redirect(zen_href_link('checkout_confirmation'));
}
//=======================================
