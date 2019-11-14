<script type="text/javascript">
<?php if(!$this_is_home_page && $products_grid_layouts == 'masonary'){ ?>
<!-- Masonary JS Ends -->
$(window).load(function() {  
    var $container = $('.product-grid, #special-listing');
    $container.masonry({
        columnWidth: '.product-grid .grid-list, .product-grid .specialsListBoxContents',
		gutter: <?php echo $gutter_space; ?>,
  		itemSelector: '.product-grid .grid-list, .product-grid .specialsListBoxContents',
		isAnimated: true,
		percentPosition: true,
    });
});
<?php } ?>
$j(document).ready(function() {
	<?php if($current_page=='product_info' || $current_page=='document_general_info' || $current_page=='document_product_info' || $current_page=='product_music_info'){?>
	<?php if($prodinfo_image_effects==1 ){ echo 'elevateZoom();'; } ?>
	productCarousel($j("#mobileGallery"),1,1,1,2,2,1);
	thumbnailsCarousel($j(".product-images-carousel ul"));
	<?php } ?>
	productCarousel($j('#megaMenuCarousel1.carousel-products'),1,1,1,1,1);
	<?php if($carouselCategoryOne_slides!=''){?>
	productCarousel($j('#carouselCategoryOne'),<?php echo $carouselCategoryOne_slides; ?>);
	<?php } ?>
	<?php if($carouselCategoryTwo_slides!=''){?>
	productCarousel($j('#carouselCategoryTwo'),<?php echo $carouselCategoryTwo_slides; ?>);
	<?php } ?>
	<?php if($carouselСategoriesOne_slides!=''){?>
	productCarousel($j('#carouselСategoriesOne'),<?php echo $carouselСategoriesOne_slides; ?>);
	<?php } ?>
	<?php if($carouselСategoriesTwo_slides!=''){?>
	productCarousel($j('#carouselСategoriesTwo'),<?php echo $carouselСategoriesTwo_slides; ?>);
	<?php } ?>
	<?php if($slider_blog_slides!=''){?>
	productCarousel($j('.slider-blog'),<?php echo $slider_blog_slides; ?>);
	<?php } ?>
	<?php if($slider_blog_layout1_slides!=''){?>
	productCarousel($j('.slider-blog-layout1'),<?php echo $slider_blog_layout1_slides; ?>);
	<?php } ?>
	productCarousel($j('.banner-slider'),1,1,1,1,1);
	productCarousel($j('.banner-carousel-1'),4,4,3,2,1);
	<?php if($postsCarousel_slides!=''){?>
	productCarousel($j('#postsCarousel'),<?php echo $postsCarousel_slides; ?>);
	<?php } ?>
	bannerCarousel($j('.banner-carousel'));
	bannerCarouselBottom($j('.banner-carousel-bottom'),2,2,2,2,1);
	bannerCarousel($j('.category-carousel'));
	brandsCarousel($j('.brands-carousel'));
	<?php if($carouselFeatured_slides!=''){?>
	productCarousel($j('#carouselFeatured'),<?php echo $carouselFeatured_slides; ?>);
	<?php } ?>
	<?php if($carouselSpecials_slides!=''){?>
	productCarousel($j('#carouselSpecials'),<?php echo $carouselSpecials_slides; ?>);
	<?php } ?>
	<?php if($carouselNew_slides!=''){?>
	productCarousel($j('#carouselNew'),<?php echo $carouselNew_slides; ?>);
	<?php } ?>
	<?php if($carouselHeader_slides!=''){?>
	productCarousel($j('#carouselHeader'),<?php echo $carouselHeader_slides; ?>);
	<?php } ?>
	<?php if($carouselBestSeller_slides!=''){?>
	productCarousel($j('#carouselBestSeller'),<?php echo $carouselBestSeller_slides; ?>);
	<?php } ?>
	productCarousel($j('#carouselAlsoPurchased'),6,4,4,2,1);
	productCarousel($j('#upcoming-products'),5,4,4,2,1);
	productCarousel($j('#carouselRelated'),6,4,4,2,1);
	verticalCarousel($j('.vertical-carousel-1'),2);
	verticalCarousel($j('.whatsNewSidebox'),3);
	verticalCarousel($j('.featuredSidebox'),2);
	verticalCarousel($j('.specialsSidebox'),2);
	testimonialsAsid($j('.testimonialsAsid'),1,1,1,1,1);//TESTIMONIALS
	productCarousel($j('#postsCarouselSidebox'),1,1,1,1,1); //recent post sidebox
 });
</script>