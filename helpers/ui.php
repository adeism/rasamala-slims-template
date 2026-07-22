<?php
/**
 * Helper Module for Rasamala Template
 */
if (!defined('INDEX_AUTH') || INDEX_AUTH != 1) {
  die("can not access this file directly");
}

if (!function_exists('themeExcerpt')) {
  function themeExcerpt($value, $length = 152, $end = '...')
  {
    $text = trim(strip_tags((string)($value ?? '')));
    if (strlen($text) <= $length) {
      return $text;
    }
    $length = max(0, $length - strlen($end));
    return substr($text, 0, $length) . $end;
  }
}

if (!function_exists('themeParallelTitleSeparator')) {
  function themeParallelTitleSeparator()
  {
    global $sysconf;

    $separator = trim((string)($sysconf['template']['classic_parallel_title_separator'] ?? '='));
    if ($separator === '0' || strtolower($separator) === 'none') {
      return '';
    }

    return $separator;
  }
}

if (!function_exists('themeSplitParallelTitle')) {
  function themeSplitParallelTitle($title, $separator = null)
  {
    $title = trim((string)($title ?? ''));
    $separator = $separator === null ? themeParallelTitleSeparator() : trim((string)$separator);

    if ($title === '' || $separator === '') {
      return [
        'main' => $title,
        'parallel' => '',
        'has_parallel' => false,
      ];
    }

    $separator_position = strpos($title, $separator);
    if ($separator_position === false) {
      return [
        'main' => $title,
        'parallel' => '',
        'has_parallel' => false,
      ];
    }

    $main_title = trim(substr($title, 0, $separator_position));
    $parallel_title = trim(substr($title, $separator_position + strlen($separator)));

    if ($main_title === '' || $parallel_title === '') {
      return [
        'main' => $title,
        'parallel' => '',
        'has_parallel' => false,
      ];
    }

    return [
      'main' => $main_title,
      'parallel' => $parallel_title,
      'has_parallel' => true,
    ];
  }
}

if (!function_exists('themeTitleCharacterLimit')) {
  function themeTitleCharacterLimit()
  {
    global $sysconf;

    return themeSafeInt($sysconf['template']['classic_title_chars'] ?? 100, 100, 1, 300);
  }
}

if (!function_exists('themeLimitTitleText')) {
  function themeLimitTitleText($title, $length = null, $end = '...')
  {
    $title = trim(strip_tags((string)($title ?? '')));
    $length = $length === null ? themeTitleCharacterLimit() : themeSafeInt($length, themeTitleCharacterLimit(), 1, 300);
    $end = (string)$end;

    if (function_exists('mb_strlen') && function_exists('mb_substr')) {
      if (mb_strlen($title, 'UTF-8') <= $length) {
        return $title;
      }

      $available_length = max(0, $length - mb_strlen($end, 'UTF-8'));
      return rtrim(mb_substr($title, 0, $available_length, 'UTF-8')) . $end;
    }

    if (strlen($title) <= $length) {
      return $title;
    }

    $available_length = max(0, $length - strlen($end));
    return rtrim(substr($title, 0, $available_length)) . $end;
  }
}

if (!function_exists('themeParallelTitleHtml')) {
  function themeParallelTitleHtml($title, $context = 'search', $title_length = null)
  {
    $title_parts = themeSplitParallelTitle(stripslashes((string)($title ?? '')));
    $title_length = $title_length === null ? themeTitleCharacterLimit() : themeSafeInt($title_length, themeTitleCharacterLimit(), 1, 300);
    $main_title = themeLimitTitleText($title_parts['main'], $title_length);
    $parallel_title = themeLimitTitleText($title_parts['parallel'], $title_length);

    $context = preg_replace('/[^a-z0-9_-]+/i', '-', (string)$context) ?: 'search';
    $html = '<span class="parallel-title parallel-title-' . themeEscape($context) . '">';
    $html .= '<span class="parallel-title-main">' . themeEscape($main_title) . '</span>';

    if ($title_parts['has_parallel']) {
      $html .= '<span class="parallel-title-alt"><i class="fas fa-language" aria-hidden="true"></i>' . themeEscape($parallel_title) . '</span>';
    }

    $html .= '</span>';

    return $html;
  }
}

if (!function_exists('themeCleanAuthorRoles')) {
  function themeCleanAuthorRoles($authors) {
    $authors = (string)($authors ?? '');
    // Clean SLiMS core link role format: </a> - Role
    $authors = preg_replace('/<\/a>\s*-\s*[^<]+/i', '</a>', $authors);
    // Clean generic parenthesized format: Name (Role)
    $authors = preg_replace('/\s*\([^)]+\)/', '', $authors);
    return $authors;
  }
}

if (!function_exists('themeFormatDetailAuthors')) {
  function themeFormatDetailAuthors($authors, $show_role) {
    $authors = (string)($authors ?? '');
    
    // Match each author block: link and optional role
    // Example: <a href="?author=...">Name</a> - Role<br />
    preg_match_all('/(<a[^>]+>)(.*?)(<\/a>)(?:\s*-\s*([^<]+))?/i', $authors, $matches, PREG_SET_ORDER);
    
    if (empty($matches)) {
      return $authors; // Fallback if parsing fails
    }
    
    $output = '';
    foreach ($matches as $match) {
      $link_open = $match[1];
      $name = trim($match[2]);
      $link_close = $match[3];
      $role = isset($match[4]) ? trim($match[4]) : '';
      
      // Remove any trailing html or br from role
      $role = strip_tags($role);
      
      $display_text = $name;
      if ($show_role && !empty($role)) {
        $display_text .= ' <span class="detail-author-role-text">(' . $role . ')</span>';
      }
      
      $output .= $link_open . $display_text . $link_close;
    }
    
    return $output;
  }
}

if (!function_exists('themeIsCoverPlaceholder')) {
  function themeIsCoverPlaceholder($image)
  {
    return themeCoverState($image) !== 'valid';
  }
}

if (!function_exists('themeAutoCoverMode')) {
  function themeAutoCoverMode($sysconf_param = null)
  {
    global $sysconf;

    $source = is_array($sysconf_param) ? $sysconf_param : $sysconf;
    $mode = strtolower(trim((string)themeEffectiveTemplateValue('classic_auto_cover_generator', 'empty_missing', $source)));
    $legacy_on = ['1', 'true', 'yes', 'on', 'all', 'both'];
    $legacy_off = ['0', 'false', 'no', 'off', 'disable', 'disabled'];

    if (in_array($mode, $legacy_on, true)) {
      return 'empty_missing';
    }
    if (in_array($mode, $legacy_off, true)) {
      return 'none';
    }
    if (!in_array($mode, ['empty_missing', 'empty_only', 'none'], true)) {
      return 'empty_missing';
    }

    return $mode;
  }
}

if (!function_exists('themeCoverState')) {
  function themeCoverState($image)
  {
    $image = trim((string)($image ?? ''));
    if ($image === '') {
      return 'empty';
    }

    $lower_image = strtolower($image);
    $empty_patterns = ['default/image.png', 'images/default/image.png', 'no-image', 'no-cover'];
    foreach ($empty_patterns as $pattern) {
      if (strpos($lower_image, $pattern) !== false) {
        return 'empty';
      }
    }

    $missing_patterns = ['notfound', 'not-found', 'file-not-found'];
    foreach ($missing_patterns as $pattern) {
      if (strpos($lower_image, $pattern) !== false) {
        return 'missing';
      }
    }

    $src = '';
    if (preg_match('/src=["\'](.*?)["\']/i', $image, $matches)) {
      $src = html_entity_decode($matches[1]);
    } else {
      $src = $image;
    }

    if (!empty($src)) {
      if (stripos($src, 'createthumb.php') !== false) {
        if (preg_match('/filename=(.*?)(&|$)/i', $src, $fn_matches)) {
          $src = urldecode($fn_matches[1]);
        }
      }

      $src = str_replace('\\', '/', trim($src));
      if (filter_var($src, FILTER_VALIDATE_URL) && stripos($src, 'images/docs/') === false) {
        return 'valid';
      }

      if (strpos($src, '/') === false && $src !== '') {
        $src = 'images/docs/' . basename($src);
      }

      $src = ltrim($src, './');
      $docs_pos = stripos($src, 'images/docs/');
      if ($docs_pos !== false) {
        $relative_path = substr($src, $docs_pos);
        $abs_path = dirname(__DIR__, 2) . '/' . $relative_path;
        if (!file_exists($abs_path)) {
          return 'missing';
        }
      }
    }

    return 'valid';
  }
}

if (!function_exists('themeShouldGenerateBookCover')) {
  function themeShouldGenerateBookCover($image, $sysconf_param = null)
  {
    $mode = themeAutoCoverMode($sysconf_param);
    if ($mode === 'none') {
      return false;
    }

    $state = themeCoverState($image);
    if ($mode === 'empty_only') {
      return $state === 'empty';
    }

    return in_array($state, ['empty', 'missing'], true);
  }
}

if (!function_exists('themeGenerateBookCoverHtml')) {
  function themeGenerateBookCoverHtml($title, $authors = '')
  {
    $clean_title = trim(strip_tags((string)($title ?? '')));
    $title_hash = 0;
    $len = mb_strlen($clean_title, 'UTF-8');
    for ($i = 0; $i < $len; $i++) {
      $char = mb_substr($clean_title, $i, 1, 'UTF-8');
      // Convert UTF-8 character to its code point
      $code = unpack('V', iconv('UTF-8', 'UTF-32LE', $char))[1];
      $title_hash = $code + (($title_hash << 5) - $title_hash);
    }
    $gradient_index = abs($title_hash) % 6;
    
    $display_title = $clean_title;
    if (mb_strlen($display_title, 'UTF-8') > 45) {
      $display_title = mb_substr($display_title, 0, 42, 'UTF-8') . '...';
    }
    
    $clean_authors = '';
    if (!empty($authors)) {
      // If it contains links, parse them out
      if (strpos($authors, '<a') !== false) {
        preg_match_all('/<a[^>]*>(.*?)<\/a>/i', $authors, $matches);
        if (!empty($matches[1])) {
          $clean_authors = implode('; ', array_map('trim', $matches[1]));
        } else {
          $clean_authors = trim(strip_tags($authors));
        }
      } else {
        $clean_authors = trim(strip_tags($authors));
      }
      
      // Clean roles or dates if appended with dash
      $clean_authors = preg_replace('/\s*-\s*[^;]+/i', '', $clean_authors);
      
      // Limit authors length on cover
      if (mb_strlen($clean_authors, 'UTF-8') > 36) {
        $clean_authors = mb_substr($clean_authors, 0, 33, 'UTF-8') . '...';
      }
    }
    
    $html = '<div class="book-cover-placeholder book-cover-gradient-' . $gradient_index . '">';
    $html .= '<div class="book-cover-content">';
    $html .= '<div class="book-cover-title-text">' . themeEscape($display_title) . '</div>';
    if (!empty($clean_authors) && $clean_authors !== '-') {
      $html .= '<div class="book-cover-author-text">' . themeEscape($clean_authors) . '</div>';
    }
    $html .= '</div>';
    $html .= '</div>';
    
    return $html;
  }
}

if (!function_exists('themeGetDisplayItems')) {
  function themeGetDisplayItems($dbs, $source, $content_filter, $content_detail, $biblio_filter, $limit, $char_limit)
  {
    $limit = themeSafeLimit($limit, 5, 1, 12);
    
    $raw_char_limit = (int)$char_limit;
    if ($raw_char_limit === 0) {
      $char_limit = 0;
    } else {
      $char_limit = themeSafeInt($char_limit, 48, 12, 160);
    }
    
    $items = [];

    if (!$dbs) {
      return $items;
    }

    $limit_text = static function ($text) use ($char_limit) {
      $text = trim(strip_tags((string)($text ?? '')));
      if ($char_limit <= 0) {
        return $text;
      }
      $suffix = '...';
      $available_length = max(0, $char_limit - strlen($suffix));

      if (function_exists('mb_strlen') && function_exists('mb_substr')) {
        if (mb_strlen($text, 'UTF-8') <= $char_limit) {
          return $text;
        }
        return rtrim(mb_substr($text, 0, $available_length, 'UTF-8')) . $suffix;
      }

      if (strlen($text) <= $char_limit) {
        return $text;
      }
      return rtrim(substr($text, 0, $available_length)) . $suffix;
    };

    if ($source === 'custom_home' || $source === 'custom_ticker') {
      global $sysconf;
      $custom_key = ($source === 'custom_home') ? 'classic_home_display_custom_text' : 'classic_ticker_custom_text';
      $custom_val = trim((string)($sysconf['template'][$custom_key] ?? ''));
      if ($custom_val === '') {
        $custom_val = 'Selamat datang di perpustakaan kami!';
      }
      $items[] = [
        'title' => $custom_val,
        'display_title' => $limit_text($custom_val),
        'url' => '#'
      ];
      return $items;
    }

    if ($source === 'content') {
      $where = "COALESCE(is_draft,0)=0 AND content_title<>'' AND content_path<>'' AND (publish_date IS NULL OR publish_date <= CURDATE())";
      if ($content_filter === 'news') {
        $where .= " AND COALESCE(is_news,0)=1";
      }

      $sql = "SELECT content_title, content_desc, content_path, publish_date, input_date, last_update
              FROM content
              WHERE {$where}
              ORDER BY COALESCE(publish_date, DATE(last_update), DATE(input_date)) DESC,
                       last_update DESC,
                       input_date DESC,
                       content_id DESC
              LIMIT " . $limit;

      $query = $dbs->query($sql);
      if ($query) {
        while ($row = $query->fetch_assoc()) {
          $path = trim((string)($row['content_path'] ?? ''));
          if (!preg_match('/^[a-z0-9_-]{1,20}$/i', $path)) {
            continue;
          }

          $full_title = $row['content_title'] ?? '';
          $display = $full_title;
          if ($content_detail === 'detail') {
            $desc = trim(strip_tags($row['content_desc'] ?? ''));
            if ($desc !== '') {
              $display .= ': ' . $desc;
            }
          }

          $items[] = [
            'title' => $full_title,
            'display_title' => $limit_text($display),
            'url' => 'index.php?p=' . rawurlencode($path)
          ];
        }
      }
    } else {
      $where = "COALESCE(b.opac_hide,0)=0 AND b.title<>''";
      $join = "";
      if ($biblio_filter !== 'all') {
        $escaped_filter = $dbs->real_escape_string($biblio_filter);
        $join = " LEFT JOIN item AS i ON b.biblio_id=i.biblio_id
                  LEFT JOIN mst_coll_type AS ct ON i.coll_type_id=ct.coll_type_id";
        $where .= " AND ct.coll_type_name='{$escaped_filter}'";
      }

      $sql = "SELECT DISTINCT b.biblio_id, b.title, b.last_update
              FROM biblio AS b
              {$join}
              WHERE {$where}
              ORDER BY b.last_update DESC, b.biblio_id DESC
              LIMIT " . $limit;

      $query = $dbs->query($sql);
      if ($query) {
        while ($row = $query->fetch_assoc()) {
          $full_title = $row['title'] ?? '';
          $items[] = [
            'title' => $full_title,
            'display_title' => $limit_text($full_title),
            'url' => 'index.php?p=show_detail&id=' . urlencode($row['biblio_id'])
          ];
        }
      }
    }

    return $items;
  }
}

if (!function_exists('themeContentPathInput')) {
  function themeContentPathInput($raw)
  {
    $raw = trim((string)($raw ?? ''));
    if ($raw === '') {
      return '';
    }

    if (strpos($raw, '?') === 0) {
      $raw = 'index.php' . $raw;
    }

    $parts = parse_url($raw);
    if ($parts !== false && isset($parts['query'])) {
      parse_str((string)$parts['query'], $query);
      if (isset($query['p']) && is_scalar($query['p']) && trim((string)$query['p']) !== '') {
        $raw = (string)$query['p'];
      }
    } elseif (preg_match('/(?:^|[?&])p=([^&]+)/', $raw, $matches)) {
      $raw = rawurldecode($matches[1]);
    }

    $raw = trim($raw, " \t\n\r\0\x0B/");
    if (!preg_match('/^[a-z0-9_-]{1,50}$/i', $raw)) {
      return '';
    }

    return $raw;
  }
}

if (!function_exists('themeSafeContentImageSrc')) {
  function themeSafeContentImageSrc($src)
  {
    $src = trim(html_entity_decode((string)($src ?? ''), ENT_QUOTES, 'UTF-8'));
    if ($src === '' || preg_match('/[\x00-\x1f\x7f]/', $src)) {
      return '';
    }

    $lower = strtolower($src);
    if (strpos($lower, 'javascript:') === 0 || strpos($lower, 'vbscript:') === 0) {
      return '';
    }

    if (strpos($lower, 'data:') === 0 && !preg_match('/^data:image\/(?:png|jpe?g|gif|webp|svg\+xml);/i', $src)) {
      return '';
    }

    if (strpos($lower, 'data:') === 0) {
      return $src;
    }

    if (strpos($src, '//') === 0) {
      return '';
    }

    $parts = parse_url($src);
    if ($parts === false) {
      return '';
    }

    $scheme = strtolower((string)($parts['scheme'] ?? ''));
    if ($scheme === 'http') {
      if (themeRequestIsHttps() || empty($parts['host']) || !themeUrlHostIsCurrent($parts['host'])) {
        return '';
      }
    } elseif ($scheme !== '' && $scheme !== 'https') {
      return '';
    }

    return $src;
  }
}

if (!function_exists('themeContentFirstImageSrc')) {
  function themeContentFirstImageSrc($html)
  {
    $html = (string)($html ?? '');
    if ($html === '') {
      return '';
    }

    if (preg_match('/<img\b[^>]*(?:src|data-src)=["\']([^"\']+)["\'][^>]*>/i', $html, $matches)) {
      return themeSafeContentImageSrc($matches[1]);
    }

    return '';
  }
}

if (!function_exists('themeHomeContentExcerpt')) {
  function themeHomeContentExcerpt($html, $limit = 110)
  {
    $text = trim(preg_replace('/\s+/', ' ', strip_tags((string)($html ?? ''))));
    $limit = themeSafeInt($limit, 110, 20, 260);
    if ($text === '') {
      return '';
    }

    $suffix = '...';
    $available_length = max(0, $limit - strlen($suffix));
    if (function_exists('mb_strlen') && function_exists('mb_substr')) {
      if (mb_strlen($text, 'UTF-8') <= $limit) {
        return $text;
      }
      return rtrim(mb_substr($text, 0, $available_length, 'UTF-8')) . $suffix;
    }

    if (strlen($text) <= $limit) {
      return $text;
    }

    return rtrim(substr($text, 0, $available_length)) . $suffix;
  }
}

if (!function_exists('themeHomeContentFallbackTitle')) {
  function themeHomeContentFallbackTitle($path)
  {
    $path = themeContentPathInput($path);
    $labels = [
      'news' => __('News'),
      'libinfo' => __('Information'),
      'help' => __('Help'),
      'librarian' => __('Librarian'),
      'member' => __('Member Area'),
      'login' => __('Staff Area'),
    ];

    $label_key = strtolower($path);
    if (isset($labels[$label_key])) {
      return $labels[$label_key];
    }

    $title = trim(str_replace(['-', '_'], ' ', $path));
    return $title !== '' ? ucwords($title) : __('Content');
  }
}

if (!function_exists('themeHomeContentCardFromRow')) {
  function themeHomeContentCardFromRow($row, $fallback_path = '')
  {
    $path = themeContentPathInput($row['content_path'] ?? $fallback_path);
    if ($path === '') {
      return null;
    }

    $title = trim(strip_tags((string)($row['content_title'] ?? '')));
    if ($title === '') {
      $title = themeHomeContentFallbackTitle($path);
    }

    $date = trim((string)($row['publish_date'] ?? ''));
    if ($date === '' || $date === '0000-00-00') {
      $date = trim((string)($row['last_update'] ?? ($row['input_date'] ?? '')));
    }

    return [
      'title' => $title,
      'excerpt' => themeHomeContentExcerpt($row['content_desc'] ?? ''),
      'url' => 'index.php?p=' . rawurlencode($path),
      'path' => $path,
      'image_src' => themeContentFirstImageSrc($row['content_desc'] ?? ''),
      'date' => $date,
    ];
  }
}

if (!function_exists('themeHomeContentFallbackCard')) {
  function themeHomeContentFallbackCard($path)
  {
    $path = themeContentPathInput($path);
    if ($path === '') {
      return null;
    }

    return [
      'title' => themeHomeContentFallbackTitle($path),
      'excerpt' => '',
      'url' => 'index.php?p=' . rawurlencode($path),
      'path' => $path,
      'image_src' => '',
      'date' => '',
    ];
  }
}

if (!function_exists('themeHomeContentCards')) {
  function themeHomeContentCards($dbs, $sysconf_param = null)
  {
    if (!$dbs) {
      return [];
    }

    $source = is_array($sysconf_param) ? $sysconf_param : ($GLOBALS['sysconf'] ?? []);
    if ((string)themeEffectiveTemplateValue('classic_home_content_cards_show', 1, $source) === '0') {
      return [];
    }

    $mode = strtolower(trim((string)themeEffectiveTemplateValue('classic_home_content_cards_source', 'news', $source)));
    if (!in_array($mode, ['news', 'all', 'custom'], true)) {
      $mode = 'news';
    }

    $items = [];
    $escape = static function ($value) use ($dbs) {
      if (method_exists($dbs, 'real_escape_string')) {
        return $dbs->real_escape_string($value);
      }
      if (method_exists($dbs, 'escape_string')) {
        return $dbs->escape_string($value);
      }
      return addslashes($value);
    };

    if ($mode === 'custom') {
      foreach (['classic_home_content_path_1', 'classic_home_content_path_2', 'classic_home_content_path_3'] as $key) {
        $path = themeContentPathInput(themeEffectiveTemplateValue($key, '', $source));
        if ($path === '') {
          continue;
        }

        $escaped_path = $escape($path);
        $sql = "SELECT content_title, content_desc, content_path, publish_date, input_date, last_update
                FROM content
                WHERE COALESCE(is_draft,0)=0
                  AND content_path='{$escaped_path}'
                  AND content_path<>''
                  AND (publish_date IS NULL OR publish_date <= CURDATE())
                ORDER BY COALESCE(publish_date, DATE(last_update), DATE(input_date)) DESC,
                         last_update DESC,
                         input_date DESC,
                         content_id DESC
                LIMIT 1";
        $query = $dbs->query($sql);
        $card = null;
        if ($query && ($row = $query->fetch_assoc())) {
          $card = themeHomeContentCardFromRow($row, $path);
        }
        if (!$card) {
          $card = themeHomeContentFallbackCard($path);
        }
        if ($card) {
          $items[] = $card;
        }
      }

      return array_slice($items, 0, 3);
    }

    $where = "COALESCE(is_draft,0)=0 AND content_title<>'' AND content_path<>'' AND (publish_date IS NULL OR publish_date <= CURDATE())";
    if ($mode === 'news') {
      $where .= " AND COALESCE(is_news,0)=1";
    }

    $sql = "SELECT content_title, content_desc, content_path, publish_date, input_date, last_update
            FROM content
            WHERE {$where}
            ORDER BY COALESCE(publish_date, DATE(last_update), DATE(input_date)) DESC,
                     last_update DESC,
                     input_date DESC,
                     content_id DESC
            LIMIT 3";
    $query = $dbs->query($sql);
    if ($query) {
      while ($row = $query->fetch_assoc()) {
        $card = themeHomeContentCardFromRow($row);
        if ($card) {
          $items[] = $card;
        }
      }
    }

    return $items;
  }
}

if (!function_exists('themeLibrarianInitials')) {
  function themeLibrarianInitials($name)
  {
    $name = trim(preg_replace('/\s+/', ' ', strip_tags((string)($name ?? ''))));
    if ($name === '') {
      return 'U';
    }

    $parts = preg_split('/\s+/', $name);
    $letters = '';
    foreach ($parts as $part) {
      $part = trim($part);
      if ($part === '') {
        continue;
      }
      $letters .= function_exists('mb_substr') ? mb_substr($part, 0, 1, 'UTF-8') : substr($part, 0, 1);
      if ((function_exists('mb_strlen') ? mb_strlen($letters, 'UTF-8') : strlen($letters)) >= 2) {
        break;
      }
    }

    if ($letters === '') {
      $letters = function_exists('mb_substr') ? mb_substr($name, 0, 2, 'UTF-8') : substr($name, 0, 2);
    }

    return function_exists('mb_strtoupper') ? mb_strtoupper($letters, 'UTF-8') : strtoupper($letters);
  }
}

if (!function_exists('themeLibrarianImageUrl')) {
  function themeLibrarianImageUrl($image)
  {
    $image = trim((string)($image ?? ''));
    if ($image === '') {
      return '';
    }

    if (filter_var($image, FILTER_VALIDATE_URL) && preg_match('/^https?:\/\//i', $image)) {
      return $image;
    }

    if (preg_match('/[\/\\\\]/', $image)) {
      return '';
    }

    $base_path = defined('IMGBS') ? IMGBS : dirname(__DIR__, 2) . '/images/';
    $image_path = rtrim($base_path, '/\\') . DIRECTORY_SEPARATOR . 'persons' . DIRECTORY_SEPARATOR . $image;
    if (!is_file($image_path)) {
      return '';
    }

    return SWB . 'lib/minigalnano/createthumb.php?filename=images/persons/' . rawurlencode($image) . '&width=240';
  }
}

if (!function_exists('themeLibrarianCustomUsernames')) {
  function themeLibrarianCustomUsernames($raw)
  {
    $items = preg_split('/[;\r\n]+/', (string)($raw ?? ''));
    $entries = [];
    foreach ($items as $item) {
      $item = trim($item);
      if ($item === '' || preg_match('/[\x00-\x1f\x7f]/', $item)) {
        continue;
      }

      $username = $item;
      $position = '';
      if (preg_match('/^(.+?)\(([^()]*)\)\s*$/', $item, $matches)) {
        $username = trim($matches[1]);
        $position = trim($matches[2]);
      }

      if ($username === '') {
        continue;
      }

      $entries[$username] = [
        'username' => $username,
        'position' => $position,
      ];
    }

    return array_values($entries);
  }
}

if (!function_exists('themeLibrarianFieldRow')) {
  function themeLibrarianFieldRow($label, $value_html, $value_class = 'span7')
  {
    $value_html = trim((string)$value_html);
    if ($value_html === '') {
      return '';
    }

    return '<div class="row-fluid">'
      . '<div class="span3 key">' . themeEscape($label) . '</div>'
      . '<div class="' . themeEscape($value_class) . '">' . $value_html . '</div>'
      . '</div>';
  }
}

if (!function_exists('themeRenderLibrarianCard')) {
  function themeRenderLibrarianCard($librarian, $sysconf_param = null)
  {
    $source = is_array($sysconf_param) ? $sysconf_param : ($GLOBALS['sysconf'] ?? []);
    $realname = trim((string)($librarian['realname'] ?? ''));
    $username = trim((string)($librarian['username'] ?? ''));
    $name = $realname !== '' ? $realname : $username;
    $position_override = trim((string)($librarian['_position_override'] ?? ''));
    $position = $position_override !== '' ? $position_override : ($source['system_user_type'][$librarian['user_type'] ?? ''] ?? '');
    $email = trim((string)($librarian['email'] ?? ''));
    $image_url = themeLibrarianImageUrl($librarian['user_image'] ?? '');

    $html = '<div class="row-fluid librarian rasamala-librarian-card">';
    $html .= '<div class="span2">';
    $html .= '<div class="librarian-image">';
    if ($image_url !== '') {
      $html .= '<img src="' . themeEscape($image_url) . '" alt="' . themeEscape($name) . '" loading="lazy">';
    } else {
      $html .= '<div class="rasamala-librarian-initials" aria-label="' . themeEscape($name) . '">' . themeEscape(themeLibrarianInitials($name)) . '</div>';
    }
    $html .= '</div>';
    $html .= '</div>';

    $html .= '<div class="span8">';
    $html .= themeLibrarianFieldRow(__('Name'), themeEscape($name));
    $html .= themeLibrarianFieldRow(__('Position'), themeEscape($position));
    if ($email !== '') {
      $email_html = filter_var($email, FILTER_VALIDATE_EMAIL)
        ? '<a href="mailto:' . themeEscape($email) . '">' . themeEscape($email) . '</a>'
        : themeEscape($email);
      $html .= themeLibrarianFieldRow(__('E-Mail'), $email_html);
    }

    $social_items = [];
    $social_data = [];
    if (!empty($librarian['social_media'])) {
      // S-02: restrict unserialize to prevent PHP Object Injection
      $unserialized = @unserialize($librarian['social_media'], ['allowed_classes' => false]);
      if (is_array($unserialized)) {
        $social_data = $unserialized;
      }
    }
    foreach (($source['social'] ?? []) as $id => $social_label) {
      if (!isset($social_data[$id])) {
        continue;
      }
      $social_value = trim((string)$social_data[$id]);
      if ($social_value === '') {
        continue;
      }
      $social_items[] = '<li><span class="librarian-social-label">' . themeEscape($social_label) . '</span><span class="librarian-social-value">' . themeEscape($social_value) . '</span></li>';
    }
    if ($social_items) {
      $html .= themeLibrarianFieldRow(__('Social'), '<ul class="librarian-social">' . implode('', $social_items) . '</ul>', 'span9');
    }

    $html .= '</div>';
    $html .= '</div>';

    return $html;
  }
}

if (!function_exists('themeRenderLibrarianPage')) {
  function themeRenderLibrarianPage($dbs, $sysconf_param = null)
  {
    if (!$dbs) {
      return '<p>' . themeEscape(__('No librarian data yet')) . '</p>';
    }

    $source = is_array($sysconf_param) ? $sysconf_param : ($GLOBALS['sysconf'] ?? []);
    $mode = strtolower(trim((string)themeEffectiveTemplateValue('classic_librarian_display_mode', 'librarian_senior', $source)));
    if (!in_array($mode, ['all', 'librarian_senior', 'senior', 'custom'], true)) {
      $mode = 'librarian_senior';
    }

    $escape = static function ($value) use ($dbs) {
      if (method_exists($dbs, 'real_escape_string')) {
        return $dbs->real_escape_string($value);
      }
      if (method_exists($dbs, 'escape_string')) {
        return $dbs->escape_string($value);
      }
      return addslashes($value);
    };

    $where = '1=1';
    $order = 'user_type DESC, realname ASC, username ASC';
    if ($mode === 'librarian_senior') {
      $where = 'user_type IN (1,2)';
    } elseif ($mode === 'senior') {
      $where = 'user_type=2';
    } elseif ($mode === 'custom') {
      $custom_entries = themeLibrarianCustomUsernames(themeEffectiveTemplateValue('classic_librarian_custom_usernames', '', $source));
      if (!$custom_entries) {
        return '<p class="rasamala-librarian-empty">' . themeEscape(__('No librarian data yet')) . '</p>';
      }
      $usernames = array_map(static function ($entry) {
        return $entry['username'];
      }, $custom_entries);
      $escaped_usernames = array_map($escape, $usernames);
      $quoted_usernames = "'" . implode("','", $escaped_usernames) . "'";
      $where = 'username IN (' . $quoted_usernames . ')';
      $order = 'FIELD(username, ' . $quoted_usernames . ')';
      $position_overrides = [];
      foreach ($custom_entries as $entry) {
        if ($entry['position'] !== '') {
          $position_overrides[$entry['username']] = $entry['position'];
        }
      }
    }

    $sql = "SELECT user_id, username, realname, user_type, user_image, email, social_media
            FROM user
            WHERE {$where}
            ORDER BY {$order}";
    $query = $dbs->query($sql);
    if (!$query || $query->num_rows < 1) {
      return '<p class="rasamala-librarian-empty">' . themeEscape(__('No librarian data yet')) . '</p>';
    }

    $html = '';
    while ($librarian = $query->fetch_assoc()) {
      if ($mode === 'custom' && isset($position_overrides[$librarian['username'] ?? ''])) {
        $librarian['_position_override'] = $position_overrides[$librarian['username']];
      }
      $html .= themeRenderLibrarianCard($librarian, $source);
    }

    return $html;
  }
}

if (!function_exists('themeHeaderRequestUri')) {
  function themeHeaderRequestUri()
  {
    $parsed_uri = parse_url($_SERVER['REQUEST_URI'] ?? '');
    $raw_path = $parsed_uri['path'] ?? '/';
    $raw_query = isset($parsed_uri['query']) ? '?' . $parsed_uri['query'] : '';

    return preg_replace('/[^a-zA-Z0-9\/=?&_.-]/', '', strip_tags(urldecode($raw_path . $raw_query)));
  }
}

if (!function_exists('themeHeaderDocumentLang')) {
  function themeHeaderDocumentLang($sysconf_param = null)
  {
    global $sysconf;

    $source = is_array($sysconf_param) ? $sysconf_param : $sysconf;
    $document_lang = (string)($_COOKIE['select_lang'] ?? $source['default_lang'] ?? 'en_US');
    $document_lang = preg_replace('/[^A-Za-z0-9_-]/', '', $document_lang);

    return str_replace('_', '-', $document_lang ?: 'en-US');
  }
}

if (!function_exists('themeHeaderMetaImageSrc')) {
  function themeHeaderMetaImageSrc($sysconf_param = null, $image_src = null, $opac = null)
  {
    global $sysconf;

    $source = is_array($sysconf_param) ? $sysconf_param : $sysconf;
    $meta_image_src = ($source['template']['dir'] ?? 'template/default') . '/default/img/logo.png';
    if (isset($_GET['p']) && $_GET['p'] === 'show_detail') {
      if (trim((string)$image_src) !== '') {
        $meta_image_src = (string)$image_src;
      } elseif (isset($opac) && isset($opac->image_src) && trim((string)$opac->image_src) !== '') {
        $meta_image_src = (string)$opac->image_src;
      }
    }

    return $meta_image_src;
  }
}

if (!function_exists('themeHeaderTickerSpeedValue')) {
  function themeHeaderTickerSpeedValue($sysconf_param = null)
  {
    $ticker_speed = themeEffectiveTemplateValue('classic_ticker_speed', 'normal', $sysconf_param);
    if ($ticker_speed === 'fast') {
      return '12s';
    }
    if ($ticker_speed === 'slow') {
      return '32s';
    }
    if ($ticker_speed === 'very_slow') {
      return '52s';
    }

    return '18s';
  }
}

if (!function_exists('themeHeaderFontStack')) {
  function themeHeaderFontStack($sysconf_param = null)
  {
    $font_family = themeEffectiveFontFamilyKey($sysconf_param);
    if ($font_family === 'inter') {
      return "'Inter', system-ui, BlinkMacSystemFont, 'Segoe UI', sans-serif";
    }
    if ($font_family === 'roboto') {
      return "'Roboto', Arial, Helvetica, sans-serif";
    }
    if ($font_family === 'poppins') {
      return "'Poppins', 'Trebuchet MS', Arial, sans-serif";
    }
    if ($font_family === 'playfair') {
      return "'Playfair Display', Georgia, 'Times New Roman', serif";
    }

    return 'system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif';
  }
}

if (!function_exists('themeHeaderFavicon')) {
  function themeHeaderFavicon($sysconf_param = null, $imagesDisk = null)
  {
    global $sysconf;

    $source = is_array($sysconf_param) ? $sysconf_param : $sysconf;
    if (!$imagesDisk) {
      $imagesDisk = $GLOBALS['imagesDisk'] ?? null;
    }

    $icon = SWB . 'webicon.ico';
    if (!empty($source['webicon']) && $imagesDisk && $imagesDisk->isExists($path = 'default/' . $source['webicon'])) {
      $icon = SWB . 'lib/minigalnano/createthumb.php?filename=images/' . $path . '&width=130';
    }

    return $icon;
  }
}

if (!function_exists('themeHeaderBackgroundSpeedMultiplier')) {
  function themeHeaderBackgroundSpeedMultiplier($sysconf_param = null)
  {
    $anim_speed = themeEffectiveTemplateValue('classic_background_animation_speed', 'normal', $sysconf_param);
    if ($anim_speed === 'slow') {
      return 1.5;
    }
    if ($anim_speed === 'fast') {
      return 0.65;
    }

    return 1.0;
  }
}

if (!function_exists('themeHeaderBodyClasses')) {
  function themeHeaderBodyClasses($sysconf_param, $selected_color, $effective_palette_key, $background_animation, $is_login)
  {
    $is_homepage = !isset($_GET['p']) && !isset($_GET['search']);
    $is_homepage_only_hero = $is_homepage && themeHomepageOnlyHero($sysconf_param);
    $palette_switcher_show = (int)themeEffectiveTemplateValue('classic_palette_switcher_show', 1, $sysconf_param) === 1;
    $search_panel_style = strtolower(trim((string)themeEffectiveTemplateValue('classic_search_panel_style', 'transparent', $sysconf_param)));
    if (!in_array($search_panel_style, ['transparent', 'solid'], true)) {
      $search_panel_style = 'transparent';
    }

    $body_classes = 'bg-light rasamala-theme';
    $body_classes .= ' rasamala-preset-' . preg_replace('/[^a-z0-9_-]+/i', '-', themePresetKey($sysconf_param));
    $body_classes .= ' rasamala-palette-' . preg_replace('/[^a-z0-9_-]+/i', '-', $effective_palette_key ?: 'warmgray');
    if ($palette_switcher_show) {
      $body_classes .= ' rasamala-has-palette-switcher';
    }

    $floating_info_body_mode = themeEffectiveTemplateValue('classic_floating_info', 'libinfo', $sysconf_param);
    if ($floating_info_body_mode == '1') {
      $floating_info_body_mode = 'libinfo';
    } elseif ($floating_info_body_mode == '0') {
      $floating_info_body_mode = 'hide';
    }
    if (!in_array($floating_info_body_mode, ['libinfo', 'whatsapp', 'hide'], true)) {
      $floating_info_body_mode = 'libinfo';
    }
    $body_classes .= ' rasamala-floating-info-' . $floating_info_body_mode;

    if (function_exists('themePaletteIsDark') && themePaletteIsDark($selected_color ?? [])) {
      $body_classes .= ' rasamala-palette-dark';
    }

    $body_classes .= ' rasamala-search-panels-' . $search_panel_style;
    $current_page_class = isset($_GET['p']) ? (string)$_GET['p'] : ($is_homepage ? 'home' : 'search');
    $body_classes .= ' rasamala-page-' . preg_replace('/[^a-z0-9_-]+/i', '-', strtolower($current_page_class));

    if ($background_animation !== 'none') {
      $body_classes .= ' rasamala-background-animation-active rasamala-background-animation-' . $background_animation;
    }
    if ($is_homepage_only_hero) {
      $body_classes .= ' rasamala-home-hero-only';
    }
    if (!$is_login) {
      $body_classes .= ' rasamala-debug-hidden';
    }

    if ($is_homepage && !$is_homepage_only_hero && function_exists('themeHomepageSectionOrder') && function_exists('themeHomepageSectionEnabled')) {
      $home_visible_sections = [];
      foreach (themeHomepageSectionOrder($sysconf_param) as $home_section_key) {
        if (themeHomepageSectionEnabled($home_section_key, $sysconf_param)) {
          $home_visible_sections[] = $home_section_key;
        }
      }

      if (count($home_visible_sections) > 0 && count($home_visible_sections) <= 1) {
        $body_classes .= ' rasamala-home-few-sections';
      }
      if (count($home_visible_sections) === 1 && $home_visible_sections[0] === 'topic') {
        $body_classes .= ' rasamala-home-topic-only';
      }
    }

    $mobile_bottom_nav_enabled = (($sysconf_param['template']['classic_mobile_bottom_nav_show'] ?? 1) == 1);
    $body_classes .= $mobile_bottom_nav_enabled ? ' mobile-bottom-nav-enabled' : ' mobile-bottom-nav-hidden';

    return $body_classes;
  }
}

if (!function_exists('themeHeaderRuntimeConfig')) {
  function themeHeaderRuntimeConfig($sysconf_param, $selected_color, $selected_dark_color, $font_stack, $ticker_speed_val, $is_login)
  {
    return [
      'colorModeDefault' => themeColorModeDefault($sysconf_param),
      'colorModeToggleVisible' => themeColorModeToggleVisible($sysconf_param),
      'darkCssUrl' => assetsVersioned('css/theme-dark.css'),
      'autoCoverMode' => themeAutoCoverMode($sysconf_param),
      'debugHiderEnabled' => !$is_login,
      'themeVars' => [
        '--theme-primary' => $selected_color['primary'],
        '--theme-primary-hover' => $selected_color['hover'],
        '--theme-secondary' => $selected_color['secondary'],
        '--theme-accent' => $selected_color['accent'],
        '--theme-background' => $selected_color['background'],
        '--theme-surface' => $selected_color['surface'],
        '--theme-text' => $selected_color['text'],
        '--theme-muted' => $selected_color['muted'],
        '--theme-muted-on-background' => $selected_color['muted_on_background'] ?? $selected_color['muted'],
        '--theme-muted-on-surface' => $selected_color['muted_on_surface'] ?? $selected_color['muted'],
        '--theme-primary-rgb' => $selected_color['rgb'],
        '--theme-accent-rgb-value' => $selected_color['accent_rgb'],
        '--theme-on-primary' => $selected_color['on_primary'],
        '--theme-on-primary-hover' => $selected_color['on_primary_hover'],
        '--theme-on-secondary' => $selected_color['on_secondary'],
        '--theme-on-accent' => $selected_color['on_accent'],
        '--theme-on-background' => $selected_color['on_background'],
        '--theme-on-surface' => $selected_color['on_surface'],
        '--theme-dark-primary' => $selected_dark_color['primary'],
        '--theme-dark-primary-hover' => $selected_dark_color['hover'],
        '--theme-dark-secondary' => $selected_dark_color['secondary'],
        '--theme-dark-accent' => $selected_dark_color['accent'],
        '--theme-dark-background' => $selected_dark_color['background'],
        '--theme-dark-surface' => $selected_dark_color['surface'],
        '--theme-dark-text' => $selected_dark_color['text'],
        '--theme-dark-muted' => $selected_dark_color['muted'],
        '--theme-dark-muted-on-background' => $selected_dark_color['muted_on_background'] ?? $selected_dark_color['muted'],
        '--theme-dark-muted-on-surface' => $selected_dark_color['muted_on_surface'] ?? $selected_dark_color['muted'],
        '--theme-dark-primary-rgb' => $selected_dark_color['rgb'],
        '--theme-dark-accent-rgb-value' => $selected_dark_color['accent_rgb'],
        '--theme-dark-on-primary' => $selected_dark_color['on_primary'],
        '--theme-dark-on-primary-hover' => $selected_dark_color['on_primary_hover'],
        '--theme-dark-on-secondary' => $selected_dark_color['on_secondary'],
        '--theme-dark-on-accent' => $selected_dark_color['on_accent'],
        '--theme-dark-on-background' => $selected_dark_color['on_background'],
        '--theme-dark-on-surface' => $selected_dark_color['on_surface'],
        '--color-primary' => 'var(--theme-primary)',
        '--color-secondary' => 'var(--theme-secondary)',
        '--color-accent' => 'var(--theme-accent)',
        '--color-background' => 'var(--theme-background)',
        '--color-surface' => 'var(--theme-surface)',
        '--color-text' => 'var(--theme-on-background)',
        '--color-muted' => 'var(--theme-muted-on-background)',
        '--color-on-primary' => 'var(--theme-on-primary)',
        '--color-on-secondary' => 'var(--theme-on-secondary)',
        '--color-on-accent' => 'var(--theme-on-accent)',
        '--rasamala-light-bg' => 'var(--theme-background)',
        '--rasamala-text-primary' => 'var(--theme-on-background)',
        '--rasamala-text-secondary' => 'var(--theme-secondary)',
        '--rasamala-text-muted' => 'var(--theme-muted-on-background)',
        '--rasamala-surface' => 'var(--theme-surface)',
        '--rasamala-accent' => $selected_color['accent'],
        '--rasamala-accent-hover' => $selected_color['accent_hover'],
        '--rasamala-readable-accent' => 'color-mix(in srgb, var(--theme-accent) 72%, var(--theme-text) 28%)',
        '--theme-accent-color' => $selected_color['accent'],
        '--theme-accent-rgb' => $selected_color['accent_rgb'],
        '--theme-accent-glow' => 'rgba(' . $selected_color['accent_rgb'] . ', 0.8)',
        '--theme-accent-glow-half' => 'rgba(' . $selected_color['accent_rgb'] . ', 0.4)',
        '--rasamala-chrome-bg' => 'color-mix(in srgb, var(--theme-primary) 92%, #000 8%)',
        '--rasamala-chrome-border' => 'color-mix(in srgb, var(--theme-primary) 38%, transparent)',
        '--rasamala-chrome-text' => 'var(--theme-on-primary)',
        '--rasamala-chrome-text-muted' => 'color-mix(in srgb, var(--theme-on-primary) 76%, transparent)',
        '--bs-body-bg' => 'var(--theme-background)',
        '--bs-body-color' => 'var(--theme-on-background)',
        '--bs-secondary-color' => 'var(--theme-muted-on-background)',
        '--rasamala-font-stack' => $font_stack,
        '--ticker-speed' => $ticker_speed_val,
      ],
    ];
  }
}

if (!function_exists('themeHeaderContext')) {
  function themeHeaderContext($sysconf_param = null, $imagesDisk = null, $is_login = false, $image_src = null, $opac = null)
  {
    global $sysconf;

    $source = is_array($sysconf_param) ? $sysconf_param : $sysconf;
    $effective_palette_key = strtolower((string)themeEffectiveAccentColorKey($source));
    $selected_color = themeSelectedAccentColor($effective_palette_key, $source);
    $selected_dark_color = themeSelectedDarkAccentColor($effective_palette_key, $source);
    $font_stack = themeHeaderFontStack($source);
    $ticker_speed_val = themeHeaderTickerSpeedValue($source);
    $is_login = !empty($is_login);
    $background_animation = themeBackgroundAnimation();
    $palette_switcher_show = (int)themeEffectiveTemplateValue('classic_palette_switcher_show', 1, $source) === 1;

    return [
      'request_uri' => themeHeaderRequestUri(),
      'meta_image_src' => themeHeaderMetaImageSrc($source, $image_src, $opac),
      'document_lang' => themeHeaderDocumentLang($source),
      'selected_color' => $selected_color,
      'selected_dark_color' => $selected_dark_color,
      'header_config' => themeHeaderRuntimeConfig($source, $selected_color, $selected_dark_color, $font_stack, $ticker_speed_val, $is_login),
      'custom_css' => themeSanitizeCustomCss($source['template']['classic_custom_css'] ?? ''),
      'icon' => themeHeaderFavicon($source, $imagesDisk),
      'body_classes' => themeHeaderBodyClasses($source, $selected_color, $effective_palette_key, $background_animation, $is_login),
      'background_animation' => $background_animation,
      'background_animation_enabled' => $background_animation !== 'none',
      'palette_switcher_show' => $palette_switcher_show,
      'speed_mult' => themeHeaderBackgroundSpeedMultiplier($source),
    ];
  }
}

if (!function_exists('themeLibraryLogoHtml')) {
  function themeLibraryLogoHtml($sysconf, $imagesDisk = null, $class = 'navbar-brand-img')
  {
    $html = '';
    $logo_image = $sysconf['logo_image'] ?? '';

    if (!$imagesDisk) {
        $imagesDisk = $GLOBALS['imagesDisk'] ?? null;
    }

    if ($logo_image !== '' && $imagesDisk && $imagesDisk->isExists($path = 'default/' . $logo_image)) {
        $src = themeEscape(SWB . 'lib/minigalnano/createthumb.php?filename=images/' . $path . '&width=350');
        $html = '<img class="' . themeEscape($class) . '" src="' . $src . '" alt="" aria-hidden="true">';
    } elseif (file_exists(dirname(__DIR__) . '/assets/images/logo.png')) {
        $src = themeEscape(assetsVersioned('images/logo.png'));
        $html = '<img class="' . themeEscape($class) . '" src="' . $src . '" alt="" aria-hidden="true">';
    } else {
        if ($class === 'hero-library-logo') {
            $html = '<span class="hero-library-logo-fallback"><i class="fas fa-book-open" aria-hidden="true"></i></span>';
        } else {
            $width = ($class === 'footer-brand-img') ? 22 : 18;
            $height = ($class === 'footer-brand-img') ? 22 : 18;
            $svg_class = ($class === 'footer-brand-img') ? 'mb-2 footer-book-icon' : 'navbar-book-icon';
            $html = '<svg xmlns="http://www.w3.org/2000/svg" width="' . $width . '" height="' . $height . '" fill="currentColor" class="bi bi-book ' . $svg_class . '" viewBox="0 0 16 16" aria-hidden="true" focusable="false">';
            $html .= '<path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.933-.575-2.202-.954-3.41-1.11-1.226-.157-2.484-.013-3.388.337zm11-.14c.654-.689 1.782-.886 3.11-.752 1.234.124 2.503.523 3.388.893v9.923c-.904-.35-2.162-.494-3.388-.337-1.208.156-2.477.535-3.409 1.11V2.688zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783"/>';
            $html .= '</svg>';
        }
    }

    return $html;
  }
}
