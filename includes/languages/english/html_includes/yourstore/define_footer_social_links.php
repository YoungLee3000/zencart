<ul>
    <?php if($facebook_link != NULL) {?>
    <li>
        <a class="icon fa fa-facebook" href="https://www.facebook.com/<?php echo $facebook_link;?>" target="_blank">
        </a>
    </li>
    <?php } ?>
    <?php if($twitter_link != NULL) {?>
    <li>
        <a class="icon fa fa-twitter" href="https://www.twitter.com/<?php echo $twitter_link;?>" target="_blank"></a>
    </li>
    <?php } ?>
    <?php if($pinterest_link != NULL) {?>
    <li>
        <a class="icon fa fa-pinterest" href="https://pinterest.com/<?php echo $pinterest_link;?>" target="_blank">
        </a>
    </li>
    <?php } ?>
    <?php if($google_link != NULL) {?>
    <li>
        <a class="icon fa fa-google-plus" href="<?php echo $google_link; ?>" target="_blank"></a>
    </li>
    <?php } ?>
    <?php if($youtube_link != NULL) {?>
    <li>
        <a class="icon fa fa-youtube" href="<?php echo $youtube_link; ?>" target="_blank"></a>
    </li>
    <?php } ?>
</ul>
