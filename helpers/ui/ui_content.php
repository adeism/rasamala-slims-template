<?php
/**
 * UI Helper Module - Content, News & Biblio Card Display Utilities
 */
if (!defined('INDEX_AUTH') || INDEX_AUTH != 1) {
  die("can not access this file directly");
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
