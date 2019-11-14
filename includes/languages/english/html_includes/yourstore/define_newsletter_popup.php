<!-- Modal (newsletter) -->		
		<div class="modal  modal--bg fade"  id="newsletterModal" data-pause=2000>
		  <div class="modal-dialog white-modal">
		    <div class="modal-content modal-md <?php if ($theme_layout==2){echo 'dark-bg';} ?>">
		      <div class="modal-bg-image bottom-right"> 
			      <img src="<?php echo $template->get_template_dir
                                    ('',DIR_WS_TEMPLATE, $current_page_base,'images').'/uploads/newsletter-bg.png';?>" alt="" class="img-responsive"> 
			  </div>
		      <div class="modal-block">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="icon icon-clear"></span></button>
			      </div>
			      <div class="modal-newsletter text-center">
					<img class="logo img-responsive1" alt="<?php if($logo_image!=NULL){ echo "logo"; } ?>" src="<?php echo $template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'images').'/uploads/'.$logo_image;?>" />
			        <h2 class="text-uppercase modal-title">JOIN US NOW!</h2>
			        <p class="color-dark">And get hot news about the theme</p>
			        <p class="color font24 custom-font font-lighter">
			           	YOURStore 
			        </p>
					<?php if($display_newsletter==1){ ?>
					<div class="subscribe-box">
						<?php echo $newsletter_details; ?>
			        </div>
					<?php } ?>
					<div class="checkbox-group form-group-top clearfix">
			            <input type="checkbox" id="nomorepopbox">
			            <label for="nomorepopbox"> 
							<span class="check"></span>
			               	<span class="box"></span>
							&nbsp;&nbsp;DON&#39;T SHOW THIS POPUP AGAIN
			            </label>
			        </div>
			      </div>
		      </div>
		    </div>
		  </div>
		</div>
		<!-- / Modal (newsletter) -->