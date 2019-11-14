<?php if($display_main_slideshow==1) { ?>
		<!-- Slider section --> 
		<section class="<?php echo $slider_layout_class; ?> <?php echo $slideshow_section_class; ?> " id="slider">
			<?php if($slideshow_container_class!=''){?><div class="<?php echo $slideshow_container_class; ?>"><?php } ?>
				<!--
					#################################
					- THEMEPUNCH BANNER -
					#################################
					--> 
				<!-- START REVOLUTION SLIDER 3.1 rev5 fullwidth mode -->
				<h2 class="hidden">Slider Section</h2>
				<div class="tp-banner-container <?php echo ($homepage_layout==2)? 'slider-layout-2':''; ?>">
					<div class="tp-banner">
						<ul>
							<?php if($full_width_slideshow!='layer'){?>
							<?php
                                while(!$slideshow_query_result->EOF) {
                                    $slider_image = $slideshow_query_result->fields['slideshow_image'];
                                    $slider_caption_un=unserialize(base64_decode($slideshow_query_result->fields['slideshow_caption']));
                                    $slider_caption = htmlspecialchars_decode(stripslashes($slider_caption_un[$_SESSION['languages_id']]));
									$trans_style = $slideshow_query_result->fields['trans_style'];
									$data_masterspeed = $slideshow_query_result->fields['data_masterspeed'];
									$data_delay = $slideshow_query_result->fields['data_delay'];
									$data_slotamount = $slideshow_query_result->fields['data_slotamount'];
									$in_animation_class = $slideshow_query_result->fields['in_animation_class'];
									$out_animation_class = $slideshow_query_result->fields['out_animation_class'];
									$ease_in = $slideshow_query_result->fields['ease_in'];
									$ease_out = $slideshow_query_result->fields['ease_out'];
									$data_x = $slideshow_query_result->fields['data_x'];
									$data_y = $slideshow_query_result->fields['data_y'];
									$data_hoffset = $slideshow_query_result->fields['data_hoffset'];
									$data_voffset = $slideshow_query_result->fields['data_voffset'];
							?>
							<!-- SLIDES -->
							<li data-transition="<?php echo $trans_style; ?>" <?php if($data_delay != NULL) { ?>data-delay="<?php echo $data_delay; ?>"<?php } ?> data-slotamount="<?php echo $data_slotamount; ?>" data-masterspeed="<?php echo $data_masterspeed; ?>" data-saveperformance="off"  data-title="Slide">
								<!-- MAIN IMAGE --> 
								<img src="<?php echo $template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'images/slider/').$slider_image;?>"  alt="slide1"  data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" >
								<?php if ($full_width_slideshow != 'intro') { ?>
								<!-- LAYERS --> 
								<!-- TEXT -->
								<div class="tp-caption <?php echo $in_animation_class."&nbsp;".$out_animation_class ?>" 
									data-x="<?php echo $data_x; ?>"              
									data-y="<?php echo $data_y; ?>"    
									data-voffset="<?php echo $data_voffset; ?>"
									data-hoffset="<?php echo $data_hoffset; ?>"
									data-speed="600" 
									data-start="900" 
									data-easing="<?php echo $ease_in; ?>" 
									data-endeasing="<?php echo $ease_out; ?>"
									style="z-index: 2;">
									<?php echo $slider_caption; ?>
								</div>
								<?php } ?>
							</li>
							<?php
                                $slideshow_query_result->MoveNext();
                                }
                            ?>
							<?php }else{ ?>
								<?php include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_MAIN_LAYER_SLIDESHOW, 'false');?>
							<?php } ?>
						</ul>
					</div>
				</div>
			<?php if($slideshow_container_class!=''){?></div><?php } ?>
		</section>
	<!-- END REVOLUTION SLIDER -->
<?php } ?>