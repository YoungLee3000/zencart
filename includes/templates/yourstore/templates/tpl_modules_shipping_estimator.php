<?php
/**
 * Module Template - for shipping-estimator display
 *
 * @package templateSystem
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_shipping_estimator.php 18695 2011-05-04 05:24:19Z drbyte $
 */
?>
<div id="shippingEstimatorContent">
	<div class="row">
		<?php echo zen_draw_form('estimator', zen_href_link($show_in, '', $request_type), 'post'); ?>
    <?php echo zen_draw_hidden_field('scid', $selected_shipping['id']); ?>
    <?php echo zen_draw_hidden_field('action', 'submit'); ?>
    <?php
      if($_SESSION['cart']->count_contents()) {
	    if ($_SESSION['customer_id']) {
    ?>
		<div class="title-box">
			<h2 class="text-center text-uppercase title-under"><?php echo CART_SHIPPING_OPTIONS; ?></h2>
		</div>

		<?php if (!empty($totalsDisplay)) { ?>
			<div class="cartTotalsDisplay important"><?php echo $totalsDisplay; ?></div>
		<?php } ?>
		<div class="col-md-6">
			<div class="card card--padding">
			<?php
				// only display addresses if more than 1
				if ($addresses->RecordCount() > 1){
			?>
				<label class="inputLabel" for="seAddressPulldown"><?php echo CART_SHIPPING_METHOD_ADDRESS; ?></label>
				<div class="select-wrapper">
					<?php echo zen_draw_pull_down_menu('address_id', $addresses_array, $selected_address, 'onchange="return shipincart_submit();" id="seAddressPulldown"'); ?>
				</div>
			<?php
				}
			?>
				<div class="bold back" id="seShipTo"><?php echo CART_SHIPPING_METHOD_TO; ?></div>
				<address class="back"><?php echo zen_address_format($order->delivery['format_id'], $order->delivery, 1, ' ', '<br />'); ?></address>
			</div>
		</div>
		<?php
		}
		else {
		?>
			<div class="title-box">
				<h2 class="text-center text-uppercase title-under"><?php echo CART_SHIPPING_OPTIONS; ?></h2>
			</div>
			<?php if (!empty($totalsDisplay)) { ?>
				<div class="cartTotalsDisplay important"><?php echo $totalsDisplay; ?></div>
			<?php } ?>
			<?php
						if($_SESSION['cart']->get_content_type() != 'virtual'){
			?>
					<div class="col-md-6">
						<div class="card card--padding">
							<label class="inputLabel" for="country"><?php echo ENTRY_COUNTRY; ?></label>
							<div class="select-wrapper">
								<?php echo zen_get_country_list('zone_country_id', $selected_country, 'id="country" onchange="update_zone(this.form);"'); ?>
							</div>
							<!--<br class="clearBoth" />-->
							
							<label class="inputLabel" for="stateZone" id="zoneLabel"><?php echo ENTRY_STATE; ?></label>
							<div class="select-wrapper">
								<?php echo zen_draw_pull_down_menu('zone_id', zen_prepare_country_zones_pull_down($selected_country), $state_zone_id, 'id="stateZone"');?>
							</div>
							<br class="clearBoth" id="stBreak" />
							<label class="inputLabel" for="state" id="stateLabel"><?php echo $state_field_label; ?></label>
							<?php echo zen_draw_input_field('state', $selectedState, zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_state', '40') . ' id="state"') ; ?>
							<!--<br class="clearBoth" />-->
		
							<?php
								if(CART_SHIPPING_METHOD_ZIP_REQUIRED == "true"){
							?>
									<label class="inputLabel"><?php echo ENTRY_POST_CODE; ?></label>
										<?php echo  zen_draw_input_field('zip_code', $zip_code, 'class="form-control"'); ?>
										<!--<br class="clearBoth" />-->
							<?php
								}
							?>
							<?php echo  zen_image_submit(BUTTON_IMAGE_UPDATE, BUTTON_UPDATE_ALT); ?>
							<!--<br class="clearBoth" />-->
						</div>
					</div>
			<?php
					}
			?>
		<?php
			}
		?>
		<div class="col-md-6">
			<div class="card card--padding">
			<?php
				if($_SESSION['cart']->get_content_type() == 'virtual'){
			?>
				<?php echo CART_SHIPPING_METHOD_FREE_TEXT .  ' ' . CART_SHIPPING_METHOD_ALL_DOWNLOADS; ?>
			<?php
				}
				elseif ($free_shipping==1) {
			?>
				<?php echo sprintf(FREE_SHIPPING_DESCRIPTION, $currencies->format(MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER)); ?>
			<?php
				}
				else{
			?>
				<div class="table-responsive">
					<table class="table">
					<?php if ($_SESSION['customer_id'] < 1 ){ ?>
							<tr>
								<td colspan="2" class="seDisplayedAddressLabel">
									<?php echo CART_SHIPPING_QUOTE_CRITERIA; ?><strong>
									<?php echo '<span class="seDisplayedAddressInfo">' . zen_get_zone_name($selected_country, $state_zone_id, '') . ($selectedState != '' ? ' ' . $selectedState : '') . ' ' . $order->delivery['postcode'] . ' ' . zen_get_country_name($order->delivery['country_id']) . '</span>'; ?></strong>
								</td>
							</tr>
					<?php } ?>
							 <tr>
								 <th scope="col" id="seProductsHeading"><?php echo CART_SHIPPING_METHOD_TEXT; ?></th>
								 <th scope="col" id="seTotalHeading"><?php echo CART_SHIPPING_METHOD_RATES; ?></th>
							 </tr>
					<?php
								for ($i=0, $n=sizeof($quotes); $i<$n; $i++) {
									if(sizeof($quotes[$i]['methods'])==1){
										// simple shipping method
										$thisquoteid = $quotes[$i]['id'].'_'.$quotes[$i]['methods'][0]['id'];
					?>
							 <tr class="<?php echo $extra; ?>">
					<?php
										if($quotes[$i]['error']){
					?>
									 <td colspan="2"><?php echo $quotes[$i]['module']; ?>&nbsp;(<?php echo $quotes[$i]['error']; ?>)</td>
								 </tr>
					<?php
										}else{
											if($selected_shipping['id'] == $thisquoteid){
					?>
									 <td class="bold"><?php echo $quotes[$i]['module']; ?>&nbsp;(<?php echo $quotes[$i]['methods'][0]['title']; ?>)</td>
									 <td class="cartTotalDisplay bold"><?php echo $currencies->format(zen_add_tax($quotes[$i]['methods'][0]['cost'], $quotes[$i]['tax'])); ?></td>
								 </tr>
					<?php
											}else{
					?>
										<td><?php echo $quotes[$i]['module']; ?>&nbsp;(<?php echo $quotes[$i]['methods'][0]['title']; ?>)</td>
										<td class="cartTotalDisplay"><?php echo $currencies->format(zen_add_tax($quotes[$i]['methods'][0]['cost'], $quotes[$i]['tax'])); ?></td>
								 </tr>
					<?php
											}
										}
									} else {
										// shipping method with sub methods (multipickup)
										for ($j=0, $n2=sizeof($quotes[$i]['methods']); $j<$n2; $j++) {
											$thisquoteid = $quotes[$i]['id'].'_'.$quotes[$i]['methods'][$j]['id'];
					?>
							<tr class="<?php echo $extra; ?>">
					<?php
											if($quotes[$i]['error']){
					?>
									 <td colspan="2"><?php echo $quotes[$i]['module']; ?>&nbsp;(<?php echo $quotes[$i]['error']; ?>)</td>
								 </tr>
					<?php
											}else{
												if($selected_shipping['id'] == $thisquoteid){
					?>
									 <td class="bold"><?php echo $quotes[$i]['module']; ?>&nbsp;(<?php echo $quotes[$i]['methods'][$j]['title']; ?>)</td>
									 <td class="cartTotalDisplay bold"><?php echo $currencies->format(zen_add_tax($quotes[$i]['methods'][$j]['cost'], $quotes[$i]['tax'])); ?></td>
								 </tr>
					<?php
												}else{
					?>
									<td><?php echo $quotes[$i]['module']; ?>&nbsp;(<?php echo $quotes[$i]['methods'][$j]['title']; ?>)</td>
									<td class="cartTotalDisplay"><?php echo $currencies->format(zen_add_tax($quotes[$i]['methods'][$j]['cost'], $quotes[$i]['tax'])); ?></td>
								</tr>
					<?php
												}
											}
										}
        }
      }
?>
					</table>
				</div>
			<?php
				 } ?>
			</div>
		</div>
<?php
  }
?>
</form>
	</div>
</div>