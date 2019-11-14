<script type="text/javascript">
// Revolution Slider
jQuery('.tp-banner').show().revolution({
	dottedOverlay:"none",
	delay:<?php echo $slideshow_delay;?>,
	hideTimerBar:"on",
	navigationType:"none",
	minHeight:320,
	sliderLayout: 'auto',
	fullScreen:"on",
	fullScreenOffsetContainer: "<?php if($full_width_slideshow=='intro') {echo "";} else {echo "#header";}?>"
});
</script>