<?php
// -----
// Part of the News Box Manager plugin, re-structured for Zen Cart v1.5.1 and later by lat9.
// Copyright (C) 2015, Vinos de Frutas Tropicales
//
// +----------------------------------------------------------------------+
// | Do Not Remove: Coded for Zen-Cart by geeks4u.com                     |
// | Dedicated to Memory of Amelita "Emmy" Abordo Gelarderes              |
// +----------------------------------------------------------------------+
//
?>
<div class="centerColumn" id="newsArchiveDefault">
  <div class="title-box">
    <h2 class="title-under text-uppercase text-center"><?php echo HEADING_TITLE; ?></h2>  
  </div>
  
<?php
if (count ($news) == 0) {
?>
  <div class="alert alert-info"><?php echo TEXT_NO_NEWS_CURRENTLY; ?></div>
<?php
} else {
?>
  <div class="newsArchiveContent">
  <?php
    foreach ($news as $news_id => $news_item) {
      $news_content = '';
      if (isset ($news_item['news_content'])) {
        $news_content = ' <div class="news-content">' . $news_item['news_content'] . '</div>';
        
      }
  ?>
    <div class="post">
      <div class="post__title_block">
        <a href="<?php echo zen_href_link (FILENAME_MORE_NEWS, 'news_id=' . $news_id, 'SSL'); ?>">
          <figure>
            <img class="img-responsive" src="<?php echo $template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'images').'/news/'.$news_item['news_image'];?>" alt="<?php echo $news_item['title']; ?>">
          </figure>
        </a>
        <div class="pull-left">
          <time>
            <?php 
              $dateAdded = date("j", strtotime($news_item['news_added_date']));
              $monthAdded = date("M", strtotime($news_item['news_added_date']));
            ?>
            <span>
              <?php echo $dateAdded;?>
            </span>
            <?php echo $monthAdded;?>
          </time>
        </div>
        <div class="pull-left">
          <h2 class="post__title text-uppercase">
            <a href="<?php echo zen_href_link (FILENAME_MORE_NEWS, 'news_id=' . $news_id, 'SSL'); ?>">
              <?php echo $news_item['title']; ?>
            </a>
          </h2>
          <div class="post__meta">
            <span class="post__meta__item">
              <?php 
                $dateUpdated = date("j", strtotime($news_item['news_modified_date']));
                $monthUpdated = date("M", strtotime($news_item['news_modified_date']));
                $yearUpdated = date("Y", strtotime($news_item['news_modified_date']));
              ?>
              <span class="last_modified autor"><?php echo TEXT_NEWS_LAST_UPDATED .'<strong>'.$monthUpdated ."&nbsp;". $dateUpdated . ',&nbsp;' . $yearUpdated.'</strong>'; ?></span>
            </span>
          </div>
        </div>
  
      </div>
      <?php echo $news_content; ?>
    </div>
  <?php
    }
  }
  ?>
  </div>
  <div class="clearBoth"></div>
  <div class="pageresult_bottom filters-row">
    <div class="navSplitPagesLinks forward filters-row__pagination">
      <ul class="pagination">
        <?php echo TEXT_RESULT_PAGE . ' ' . $news_split->display_links (MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params (array ('page', 'info', 'x', 'y', 'main_page')), $paginateAsUL); ?>
      </ul>
    </div>
    <div class="navSplitPagesResult">
      <?php echo $news_split->display_count (TEXT_DISPLAY_NUMBER_OF_NEWS_ARTICLES); ?>
    </div>
  </div>
  <div class="newsArchive-links">
    <div class="buttonRow back btn btn--ys">
      <?php echo zen_back_link() . zen_image_button (BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) . '</a>'; ?>
    </div>
  </div>
</div>