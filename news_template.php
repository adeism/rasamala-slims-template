<?php
/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 2019-01-31 17:30
 * @File name           : news_template.php
 */

function news_list_tpl($title, $path, $date, $summary) {
  global $sysconf;
  if (isset($_COOKIE['select_lang'])) $sysconf['default_lang'] = trim(strip_tags($_COOKIE['select_lang']));
  ?>

  <div class="card shadow-sm mb-4 apple-main-content-card">
      <div class="card-body p-4">
          <div class="content-date mb-2 detail-link-btn"><i class="far fa-clock mr-2"></i><?= \Carbon\Carbon::parse($date)->locale($sysconf['default_lang'])->isoFormat('dddd, LL') ?></div>
          <h3 class="content-title mb-3 font-weight-bold news-card-title"><?php echo $title ?></h3>
          <p class="content-summary mb-3 detail-description"><?php echo $summary ?>...</p>
          <div class="content-readmore d-flex justify-content-end"><a class="btn btn-primary btn-sm btn-news-readmore" href="<?php echo SWB.'index.php?p='.$path ?>"><?php echo __('Read More') ?></a></div>
      </div>
  </div>

  <?php
}