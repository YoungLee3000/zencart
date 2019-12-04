<?php
if (isset($_POST['payment'])) {
	$_SESSION['payment'] = $_POST['payment'];
	echo json_encode(array('status'=>1));
	exit;
}
if (isset($_POST['shipping'])) {
	$_SESSION['shipping_num'] = $_POST['shipping'];
	echo json_encode(array('status'=>1));
	exit;
}

require(DIR_WS_CLASSES . 'shipping.php');
$shipping_modules = new shipping();
$quotes = $shipping_modules->quote();
if($_SESSION['shipping_num']=='on') $_SESSION['shipping_num'] = 0;
if(!$_SESSION['shipping_num']) $_SESSION['shipping_num'] = 0;
if(sizeof($quotes)==1) $_SESSION['shipping_num'] = 0;
$_SESSION['shipping'] = array('id' => $quotes[$_SESSION['shipping_num']]['id'],
                              'title' => ($quotes[$_SESSION['shipping_num']]['module']),
                              'cost' => $quotes[$_SESSION['shipping_num']]['methods'][0]['cost']);
require(DIR_WS_CLASSES . 'order.php');// deal $_SESSION['shipping']
$order = new order;
require(DIR_WS_CLASSES . 'order_total.php');
$order_total_modules = new order_total;
$order_total_modules->collect_posts();
$order_total_modules->pre_confirmation_check();
?>

<?php if (MODULE_ORDER_TOTAL_INSTALLED) {
$order_totals = $order_total_modules->process();
$order_total_modules->output(); ?>
<?php }
exit;
?>