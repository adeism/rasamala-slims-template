<?php
/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 2019-01-31 17:30
 * @File name           : news_template.php
 * @Last modified by    : Ade Ismail Siregar (adeismailbox@gmail.com)
 * @Last modified time  : 2026-07-15T15:16:37+07:00
 */

if (!function_exists('rasamalaNewsFirstImageSrc')) {
  function rasamalaNewsFirstImageSrc($html)
  {
    $html = html_entity_decode((string)$html, ENT_QUOTES, 'UTF-8');
    $patterns = [
      '/<img\b[^>]*(?:src|data-src)\s*=\s*([\'"])(.*?)\1/i',
      '/<img\b[^>]*(?:src|data-src)\s*=\s*([^\s>]+)/i',
    ];

    foreach ($patterns as $pattern) {
      if (!preg_match($pattern, $html, $matches)) {
        continue;
      }

      $src = trim($matches[2] ?? $matches[1] ?? '', " \t\n\r\0\x0B\"'");
      if ($src !== '' && !preg_match('/^\s*(javascript:|data:text\/html)/i', $src)) {
        return $src;
      }
    }

    return '';
  }
}

if (!function_exists('rasamalaNewsRawContentByPath')) {
  function rasamalaNewsRawContentByPath($path)
  {
    global $dbs;

    $path = trim((string)$path);
    if ($path === '' || !isset($dbs) || !$dbs || !method_exists($dbs, 'query')) {
      return '';
    }

    $safe_path = method_exists($dbs, 'escape_string') ? $dbs->escape_string($path) : addslashes($path);
    $query = $dbs->query("SELECT content_desc FROM content WHERE content_path='{$safe_path}' AND COALESCE(is_draft,0)=0 LIMIT 1");
    if (!$query || !method_exists($query, 'fetch_assoc')) {
      return '';
    }

    $row = $query->fetch_assoc();
    return is_array($row) ? stripslashes($row['content_desc'] ?? '') : '';
  }
}

function news_list_tpl($title, $path, $date, $summary) {
  global $sysconf;
  if (isset($_COOKIE['select_lang'])) $sysconf['default_lang'] = trim(strip_tags($_COOKIE['select_lang']));

  $news_layout = function_exists('themeEffectiveTemplateValue')
    ? themeEffectiveTemplateValue('classic_news_list_layout', 'title_excerpt', $sysconf)
    : ($sysconf['template']['classic_news_list_layout'] ?? 'title_excerpt');
  $news_layout = in_array($news_layout, ['title_excerpt', 'title_only', 'title_excerpt_thumbnail'], true) ? $news_layout : 'title_excerpt';

  $escape = function ($value) {
    return function_exists('themeEscape')
      ? themeEscape($value)
      : htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
  };

  $raw_summary = html_entity_decode((string)$summary, ENT_QUOTES, 'UTF-8');
  $raw_content = $raw_summary;
  $thumbnail_src = rasamalaNewsFirstImageSrc($raw_content);
  if ($news_layout === 'title_excerpt_thumbnail' && $thumbnail_src === '') {
    $database_content = rasamalaNewsRawContentByPath($path);
    if ($database_content !== '') {
      $thumbnail_src = rasamalaNewsFirstImageSrc($database_content);
      if (trim(strip_tags($raw_content)) === '') {
        $raw_content = $database_content;
      }
    }
  }

  $summary_without_images = preg_replace('/<img\b[^>]*>/i', ' ', $raw_content);
  $excerpt = trim(preg_replace('/\s+/', ' ', strip_tags($summary_without_images)));
  if (function_exists('mb_strlen') && mb_strlen($excerpt, 'UTF-8') > 220) {
    $excerpt = rtrim(mb_substr($excerpt, 0, 220, 'UTF-8')) . '...';
  } elseif (strlen($excerpt) > 220) {
    $excerpt = rtrim(substr($excerpt, 0, 220)) . '...';
  }

  $show_excerpt = $news_layout !== 'title_only' && $excerpt !== '';
  $show_thumbnail = $news_layout === 'title_excerpt_thumbnail' && $thumbnail_src !== '';
  $show_readmore = $news_layout !== 'title_only';
  $news_url = SWB . 'index.php?p=' . $path;
  $date_html = '';
  if (!empty($date)) {
    try {
      $date_format = $news_layout === 'title_only' ? 'D MMM YYYY' : 'dddd, LL';
      $date_html = \Carbon\Carbon::parse($date)->locale($sysconf['default_lang'])->isoFormat($date_format);
    } catch (\Exception $exception) {
      $date_html = (string)$date;
    }
  }
  ?>

  <div class="card shadow-sm mb-4 rasamala-main-content-card news-list-card news-list-card--<?= $escape($news_layout) ?><?= $show_thumbnail ? ' has-thumbnail' : '' ?>">
      <div class="card-body p-4 news-list-body">
          <?php if ($show_thumbnail) : ?>
          <a class="news-list-thumbnail" href="<?= $escape($news_url) ?>" aria-label="<?= $escape($title) ?>">
              <img loading="lazy" src="<?= $escape($thumbnail_src) ?>" alt="" aria-hidden="true">
          </a>
          <?php endif; ?>
          <div class="news-list-content">
              <h3 class="content-title mb-2 fw-bold news-card-title">
                  <a href="<?= $escape($news_url) ?>"><?= $escape($title) ?></a>
              </h3>
              <?php if ($show_excerpt) : ?>
              <p class="content-summary mb-3 detail-description news-list-summary"><?= $escape($excerpt) ?></p>
              <?php endif; ?>
              <div class="news-list-footer">
                  <?php if ($date_html !== '') : ?>
                  <div class="content-date detail-link-btn news-list-date"><i class="far fa-clock me-2"></i><?= $escape($date_html) ?></div>
                  <?php endif; ?>
                  <?php if ($show_readmore) : ?>
                  <a class="btn btn-primary btn-sm btn-news-readmore" href="<?= $escape($news_url) ?>"><?php echo __('Read More') ?></a>
                  <?php endif; ?>
              </div>
          </div>
      </div>
  </div>

  <?php
}
