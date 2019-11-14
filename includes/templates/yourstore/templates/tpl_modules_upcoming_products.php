<?php
/**
 * Module Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_upcoming_products.php 6422 2007-05-31 00:51:40Z ajeh $
 */
?>
<!-- bof: upcoming_products -->
<div class="centerBoxWrapper slider-view" id="upcomingProducts">
	<div class="title-with-button">
		<div class='carousel-products__button pull-right'> <span class='btn-prev'></span> <span class='btn-next'></span> </div>
		<h2 class="text-left text-uppercase title-default pull-left"><?php echo TABLE_HEADING_UPCOMING_PRODUCTS; ?></h2>
	</div>
    <div id="upcoming-products" class="product-listing carousel-products row">
<?php
    for($i=0; $i < sizeof($expectedItems); $i++) { 
		
		if (!isset($productsInCategory[$expectedItems[$i]['products_id']])) $productsInCategory[$expectedItems[$i]['products_id']] = zen_get_generated_category_path_rev($expectedItems[$i]['master_categories_id']);
						
		$cPath = $productsInCategory[$expectedItems[$i]['products_id']];
		$expectedItems[$i]['cPath'] = $cPath;
				
		//set Infopagelink
		$zen_get_info_page = zen_get_info_page($expectedItems[$i]['products_id']);
		$expectedItems[$i]['zen_get_info_page'] = $zen_get_info_page;

		$product_content = pzen_get_product_content($expectedItems[$i], '', 'ar');
				//print_r($product_content);
				//print_r($expectedItems[$i]);
		//echo ($i%4==0)? '<div class="row">' : '';
		echo '<div class="col-xs-12 centerBoxContentsUpcoming back col-sm-6 col-md-3 col-lg-3 col-xl-3">
			<div class="product">
				<div class="product__inside">
					<div class="product__inside__image">
						'.$product_content['products_image'].'
					</div>
					<div class="product__inside__name">
						<h2 class="product_title"><a href="' . zen_href_link(zen_get_info_page($expectedItems[$i]['products_id']), 'cPath=' . $productsInCategory[$expectedItems[$i]['products_id']] . '&products_id=' . $expectedItems[$i]['products_id'], 'SSL') . '">' . $product_content['products_name'] . '</a>
						</h2>
					</div> 
				</div>
			 </div>
		</div>	 
		';
	//echo ($i%4==3 || ($i==(sizeof($expectedItems)-1)))? '</div>' : '';
	?>
    
	  <?php
    }
?>
	</div>
</div>
<!-- eof: upcoming_products -->
