<?php if($display_brands_slider==1){ ?>
	<!-- Brands Slider Wrapper -->
	<section class="<?php echo $brands_slider_class; ?>">
        <?php echo ($homepage_layout==1)? '<div class="container">' : ''; ?>
            <div class="row">
				<div class="brands-carousel">
                    <?php 
                        while (!$manufactureimage->EOF) {
                        //print_r($manufactureimage);
                            $manufacturers_image = $manufactureimage->fields['manufacturers_image'];
                            $manufacturers_id = $manufactureimage->fields['manufacturers_id'];
							$manufacturers_name = $manufactureimage->fields['manufacturers_name'];
                    ?>
                    <div>
                        <a href="<?php echo zen_href_link("index&manufacturers_id=".$manufacturers_id, '', 'SSL'); ?>">
                        	<img src="images/<?php echo $manufacturers_image;?>" width="auto" height="auto" alt="<?php echo TEXT_BRAND; ?>" title="" />
                        </a>
                    </div>
                    <?php $manufactureimage->MoveNext();
                        } ?>
                </div>
			</div>
		<?php echo ($homepage_layout==1)? '</div>' : ''; ?>
	</section>
	<!-- Brands Slider Wrapper Ends -->
<?php } ?>