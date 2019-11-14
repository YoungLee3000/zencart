<?php
if (ZX_AJAX_CART_STATUS == 'true') {
	if(ZX_AJAX_CART_JQUERY == 'true') echo '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>';
?>
<script src="<?php echo DIR_WS_TEMPLATES.$template_dir ; ?>/jscript/jquery.form.min.js"></script>
<script language="javascript">
function showview(c){var b="#"+c;jQuery(b).show()}function hideview(c){var b="#"+c;jQuery(b).hide()}/*function closecart(){jQuery("#carttopcontainer").fadeOut(400)}*/function startHover(){jQuery("#carttopcontainer").fadeIn(600)}function endHover(){jQuery("#carttopcontainer").fadeOut(600)}function showRequest(c,b,a){var d=jQuery.param(c);document.getElementById("loadBar").innerHTML='<?php echo zen_image(DIR_WS_TEMPLATE_IMAGES . 'bar-loading.gif', 'Loading...'); ?>';return true}function strpos(b,c,d){var a=(b+"").indexOf(c,(d||0));return a===-1?false:a}function showResponse(a,b){var c=strpos(a,"Warning",5);if(c>0){document.getElementById("loadBar").innerHTML="";document.getElementById("button_cart").innerHTML='<br /><?php echo TEXT_AJAX_CART_ERROR_NOT_ADDED; ?>'}else{document.getElementById("loadBar").innerHTML="";}}$(document).ready(function(){var a={target:"#topcartinner",url:"add_to_cart.php",type:"POST",beforeSubmit:showRequest,success:showResponse};$("#cart_quantity").submit(function(){$(this).ajaxSubmit(a);return false})});
function zenajxcart(a){jQuery.ajax({type:"POST",url:"ajx_cart.php",data:"products_id="+a,success:function(b){"success"==b.status?(jQuery(".ajax-cart-content-header").html(b.cart)):"error"==b.status},dataType:"json"})}
</script>
<?php } ?>