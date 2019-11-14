<!--Insta Feed-->
    <section class="content fullwidth hidden-xs">
        <div class="container">
            <div class="row">
                <div class="instafeed-wrapper">
                    <h3 class="title-vertical"><span>INSTAGRAM FEED</span></h3>
                    <div id="instafeed" class="instafeed"></div>
                </div>
            </div>
        </div>
    </section>
	<script src="<?php  echo $template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'external/instafeed').'/instafeed.min.js'?>" type="text/javascript"></script>
	<script type="text/javascript">
	// Instagram Feed
			var feed = new Instafeed({
				get: 'user',
				userId: '2324131028',
				clientId: '422b4d6cf31747f7990a723ca097f64e',
				limit: 28,
				sortBy: 'most-liked',
				resolution: "standard_resolution",
				accessToken: '2324131028.422b4d6.d6d71d31431a4e8fbf6cb1efa1a2dfdc',
			template: '<a href="{{link}}" target="_blank"><img src="{{image}}" /></a>'
			});
			feed.run();
	</script>
    <!--Insta Feed Ends-->