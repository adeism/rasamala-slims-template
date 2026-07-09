<?php
/**
 * Shared helpers for templates that can be loaded before classic.php.
 *
 * @Last modified by    : Ade Ismail Siregar (adeismailbox@gmail.com)
 * @Last modified time  : 2026-07-09T14:04:51+07:00
 */
if (!defined('INDEX_AUTH') || INDEX_AUTH != 1) {
  die("can not access this file directly");
}

if (!function_exists('themeEscape')) {
  function themeEscape($value)
  {
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
  }
}

if (!function_exists('themeSafeInt')) {
  function themeSafeInt($value, $default = 0, $min = 0, $max = PHP_INT_MAX)
  {
    $int = filter_var($value, FILTER_VALIDATE_INT);
    if ($int === false) {
      $int = $default;
    }
    return max($min, min($max, (int)$int));
  }
}

if (!function_exists('themeSafeLimit')) {
  function themeSafeLimit($value, $default = 5, $min = 1, $max = 50)
  {
    return themeSafeInt($value, $default, $min, $max);
  }
}

if (!function_exists('themeSafeYear')) {
  function themeSafeYear($value)
  {
    $year = (string)$value;
    return preg_match('/^\d{4}$/', $year) ? $year : date('Y');
  }
}

if (!function_exists('themeSafeHttpsUrl')) {
  function themeSafeHttpsUrl($url)
  {
    $url = trim((string)($url ?? ''));
    $parts = parse_url($url);
    if (!$url || !is_array($parts) || strtolower($parts['scheme'] ?? '') !== 'https' || empty($parts['host'])) {
      return '';
    }
    return $url;
  }
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

if (!function_exists('themeBackgroundAnimationOptions')) {
  function themeBackgroundAnimationOptions()
  {
    return ['none', 'particles', 'constellation', 'rain', 'waves', 'grid'];
  }
}

if (!function_exists('themeBackgroundAnimation')) {
  function themeBackgroundAnimation()
  {
    global $sysconf;

    $animation = strtolower(trim((string)($sysconf['template']['classic_hero_background_animation'] ?? 'particles')));
    if (!in_array($animation, themeBackgroundAnimationOptions(), true)) {
      return 'particles';
    }

    return $animation;
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

if (!function_exists('themeSafeHref')) {
  function themeSafeHref($url, $fallback = '#')
  {
    $url = trim((string)($url ?? ''));
    $scheme = strtolower((string)parse_url($url, PHP_URL_SCHEME));
    if ($scheme === 'javascript' || $scheme === 'data') {
      return $fallback;
    }
    return $url !== '' ? $url : $fallback;
  }
}

if (!function_exists('themeTopicItemsDefault')) {
  function themeTopicItemsDefault()
  {
    return 'Literature | index.php?callnumber=8&search=search | fas fa-book ; Social Sciences | index.php?callnumber=3&search=search | fas fa-users ; Applied Sciences | index.php?callnumber=6&search=search | fas fa-flask ; Art & Recreation | index.php?callnumber=7&search=search | fas fa-paint-brush ; see more.. | #exampleModal | fas fa-th-large';
  }
}

if (!function_exists('themeTopicItemsLegacyDefault')) {
  function themeTopicItemsLegacyDefault()
  {
    return 'Literature | index.php?callnumber=8&search=search | images/8-books.png ; Social Sciences | index.php?callnumber=3&search=search | images/3-diploma.png ; Applied Sciences | index.php?callnumber=6&search=search | images/6-blackboard.png ; Art & Recreation | index.php?callnumber=7&search=search | images/7-quill.png ; see more.. | #exampleModal | images/icon/grid_icon.png';
  }
}

if (!function_exists('themeNormalizeTopicIcon')) {
  function themeNormalizeTopicIcon($icon)
  {
    $icon = trim(strip_tags((string)($icon ?? '')));
    if ($icon === '') {
      return [
        'type' => 'font',
        'value' => 'fas fa-th-large',
      ];
    }

    if (preg_match('/^(fa[brs]?|fas|far|fab)\s+[a-z0-9 _-]+$/i', $icon)) {
      return [
        'type' => 'font',
        'value' => preg_replace('/\s+/', ' ', $icon),
      ];
    }

    if (themeSafeHttpsUrl($icon)) {
      return [
        'type' => 'image_url',
        'value' => $icon,
      ];
    }

    $icon = ltrim($icon, '/');
    if (preg_match('/\.\.|[\x00-\x1f\x7f]/', $icon) || !preg_match('/\.(png|jpe?g|gif|webp|svg)$/i', $icon)) {
      return [
        'type' => 'font',
        'value' => 'fas fa-th-large',
      ];
    }

    return [
      'type' => 'image',
      'value' => $icon,
    ];
  }
}

if (!function_exists('themeNormalizeTopicItem')) {
  function themeNormalizeTopicItem($label, $url, $icon)
  {
    $label = trim(preg_replace('/[|;\r\n]+/', ' ', strip_tags((string)$label)));
    $url = themeSafeMenuUrl($url);

    if ($label === '' || $url === '') {
      return null;
    }

    return [
      'label' => $label,
      'url' => $url,
      'icon' => themeNormalizeTopicIcon($icon),
    ];
  }
}

if (!function_exists('themeParseTopicItems')) {
  function themeParseTopicItems($raw)
  {
    $raw = trim((string)($raw ?? ''));
    if ($raw === themeTopicItemsLegacyDefault()) {
      $raw = themeTopicItemsDefault();
    }
    $items = [];

    if ($raw !== '') {
      $lines = preg_split('/[;\n\r]+/', $raw);
      foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '') {
          continue;
        }

        $parts = array_map('trim', explode('|', $line, 3));
        if (count($parts) < 2) {
          continue;
        }

        $item = themeNormalizeTopicItem($parts[0], $parts[1], $parts[2] ?? '');
        if ($item) {
          $items[] = $item;
        }
      }
    }

    if (!$items && $raw !== themeTopicItemsDefault()) {
      return themeParseTopicItems(themeTopicItemsDefault());
    }

    return $items;
  }
}

if (!function_exists('themeTopicIconHtml')) {
  function themeTopicIconHtml($icon)
  {
    $type = $icon['type'] ?? 'image';
    $value = $icon['value'] ?? 'images/icon/grid_icon.png';

    if ($type === 'font') {
      return '<i class="' . themeEscape($value) . ' topic-icon-fa mb-3 mx-auto" aria-hidden="true"></i>';
    }

    $src = $type === 'image_url' ? $value : (function_exists('assets') ? assets($value) : $value);
    return '<img src="' . themeEscape($src) . '" width="80" class="mb-3 mx-auto topic-icon-img" alt="">';
  }
}

if (!function_exists('themeTopicItemHtml')) {
  function themeTopicItemHtml($item)
  {
    $url = $item['url'] ?? '#';
    $modal_attrs = '';
    if (strpos($url, '#') === 0 && strlen($url) > 1) {
      $modal_attrs = ' data-toggle="modal" data-target="' . themeEscape($url) . '"';
    }

    return '<li class="d-flex justify-content-center align-items-center m-2">'
      . '<a href="' . themeEscape(themeSafeHref($url)) . '" class="d-flex flex-column"' . $modal_attrs . '>'
      . themeTopicIconHtml($item['icon'] ?? [])
      . '<span>' . themeEscape(__($item['label'] ?? '')) . '</span>'
      . '</a>'
      . '</li>';
  }
}

if (!function_exists('themeBreadcrumbsEnabled')) {
  function themeBreadcrumbsEnabled()
  {
    global $sysconf;

    return (string)($sysconf['template']['classic_breadcrumbs_show'] ?? 1) !== '0';
  }
}

if (!function_exists('themeBreadcrumbCurrentLabel')) {
  function themeBreadcrumbCurrentLabel($label = '')
  {
    $label = trim(html_entity_decode(strip_tags((string)($label ?? '')), ENT_QUOTES, 'UTF-8'));
    if ($label !== '') {
      return $label;
    }

    if (isset($_GET['search'])) {
      return __('Search Result');
    }

    $page = strtolower(trim((string)($_GET['p'] ?? '')));
    $labels = [
      'libinfo' => __('Information'),
      'news' => __('News'),
      'help' => __('Help'),
      'librarian' => __('Librarian'),
      'member' => __('Member Area'),
      'login' => __('Staff Area'),
      'show_detail' => __('Detail'),
    ];

    if (isset($labels[$page])) {
      return $labels[$page];
    }

    $page = str_replace(['_', '-'], ' ', $page);
    return $page !== '' ? ucwords($page) : __('Page');
  }
}

if (!function_exists('themeSafeLocalUrl')) {
  function themeSafeLocalUrl($url)
  {
    $url = trim((string)($url ?? ''));
    if ($url === '' || preg_match('/[\x00-\x1f\x7f]/', $url) || strpos($url, '//') === 0) {
      return '';
    }

    $parts = parse_url($url);
    if ($parts === false || !empty($parts['scheme']) || !empty($parts['host'])) {
      return '';
    }

    return $url;
  }
}

if (!function_exists('themeRememberSearchBreadcrumb')) {
  function themeRememberSearchBreadcrumb()
  {
    if (!isset($_GET['search'])) {
      return;
    }

    $query_string = trim((string)($_SERVER['QUERY_STRING'] ?? ''));
    $_SESSION['RASAMALA_LAST_SEARCH_URL'] = $query_string !== ''
      ? 'index.php?' . preg_replace('/[\x00-\x1f\x7f]/', '', $query_string)
      : 'index.php?search=Search';
  }
}

if (!function_exists('themeDetailHasSearchContext')) {
  function themeDetailHasSearchContext()
  {
    if (($_GET['p'] ?? '') !== 'show_detail') {
      return false;
    }

    if (array_key_exists('keywords', $_GET)) {
      return true;
    }

    $referer = trim((string)($_SERVER['HTTP_REFERER'] ?? ''));
    if ($referer === '') {
      return false;
    }

    $referer_parts = parse_url($referer);
    $current_host = $_SERVER['HTTP_HOST'] ?? '';
    if (!is_array($referer_parts) || (($referer_parts['host'] ?? $current_host) !== $current_host)) {
      return false;
    }

    parse_str($referer_parts['query'] ?? '', $referer_query);
    return isset($referer_query['search']);
  }
}

if (!function_exists('themeSearchBreadcrumbUrl')) {
  function themeSearchBreadcrumbUrl()
  {
    $session_url = themeSafeLocalUrl($_SESSION['RASAMALA_LAST_SEARCH_URL'] ?? '');
    if ($session_url !== '' && (strpos($session_url, 'search=') !== false || strpos($session_url, 'keywords=') !== false)) {
      return $session_url;
    }

    if (array_key_exists('keywords', $_GET)) {
      return 'index.php?' . http_build_query([
        'keywords' => (string)($_GET['keywords'] ?? ''),
        'search' => 'Search',
      ]);
    }

    return 'index.php?search=Search';
  }
}

if (!function_exists('themeBreadcrumbsHtml')) {
  function themeBreadcrumbsHtml($label = '', $parents = [])
  {
    if (!themeBreadcrumbsEnabled()) {
      return '';
    }

    themeRememberSearchBreadcrumb();

    $current_label = themeBreadcrumbCurrentLabel($label);
    $home_label = __('Home');
    $parents = is_array($parents) ? $parents : [];

    if (themeDetailHasSearchContext()) {
      array_unshift($parents, [
        'label' => __('Search'),
        'url' => themeSearchBreadcrumbUrl(),
      ]);
    }

    $html = '<nav class="rasamala-breadcrumbs" aria-label="' . themeEscape(__('Breadcrumbs')) . '">';
    $html .= '<a class="rasamala-breadcrumb-link" href="index.php"><i class="fas fa-home" aria-hidden="true"></i><span>' . themeEscape($home_label) . '</span></a>';

    foreach ($parents as $parent) {
      $parent_label = trim(strip_tags((string)($parent['label'] ?? '')));
      $parent_url = themeSafeLocalUrl($parent['url'] ?? '');
      if ($parent_label === '' || $parent_url === '') {
        continue;
      }

      $html .= '<i class="fas fa-chevron-right rasamala-breadcrumb-separator" aria-hidden="true"></i>';
      $html .= '<a class="rasamala-breadcrumb-link" href="' . themeEscape($parent_url) . '">' . themeEscape($parent_label) . '</a>';
    }

    $html .= '<i class="fas fa-chevron-right rasamala-breadcrumb-separator" aria-hidden="true"></i>';
    $html .= '<span class="rasamala-breadcrumb-current" aria-current="page">' . themeEscape($current_label) . '</span>';
    $html .= '</nav>';

    return $html;
  }
}

if (!function_exists('themeAccentPalettes')) {
  function themeAccentPalettes()
  {
    return [
      'warmgray' => [
        'primary' => '#6f5b43',
        'hover' => '#5d4b36',
        'rgb' => '111, 91, 67',
      ],
      'cyan' => [
        'primary' => '#0057b8',
        'hover' => '#004494',
        'rgb' => '0, 87, 184',
      ],
      'emerald' => [
        'primary' => '#047857',
        'hover' => '#065f46',
        'rgb' => '4, 120, 87',
      ],
      'orange' => [
        'primary' => '#b45309',
        'hover' => '#92400e',
        'rgb' => '180, 83, 9',
      ],
      'gold' => [
        'primary' => '#7a5d00',
        'hover' => '#604900',
        'rgb' => '122, 93, 0',
      ],
      'pink' => [
        'primary' => '#be185d',
        'hover' => '#9d174d',
        'rgb' => '190, 24, 93',
      ],
    ];
  }
}

if (!function_exists('themeSelectedAccentColor')) {
  function themeSelectedAccentColor($color)
  {
    $palettes = themeAccentPalettes();
    $key = strtolower((string)($color ?? 'warmgray'));

    return $palettes[$key] ?? $palettes['warmgray'];
  }
}

if (!function_exists('themeNavbarMenuDefault')) {
  function themeNavbarMenuDefault()
  {
    return 'Home | index.php | fas fa-home ; Information | index.php?p=libinfo | fas fa-info-circle ; News | index.php?p=news | fas fa-newspaper ; Help | index.php?p=help | fas fa-question-circle ; Librarian | index.php?p=librarian | fas fa-users ; Staff Area | index.php?p=login | fas fa-user-shield';
  }
}

if (!function_exists('themeNavbarMenuLegacyDefault')) {
  function themeNavbarMenuLegacyDefault()
  {
    return 'Home | index.php ; Information | index.php?p=libinfo ; News | index.php?p=news ; Help | index.php?p=help ; Librarian | index.php?p=librarian';
  }
}

if (!function_exists('themeNavbarMenuPlainDefault')) {
  function themeNavbarMenuPlainDefault()
  {
    return 'Home | index.php ; Information | index.php?p=libinfo ; News | index.php?p=news ; Help | index.php?p=help ; Librarian | index.php?p=librarian ; Staff Area | index.php?p=login';
  }
}

if (!function_exists('themeSafeMenuUrl')) {
  function themeSafeMenuUrl($url)
  {
    $url = trim((string)($url ?? ''));
    if ($url === '' || preg_match('/[\x00-\x1f\x7f]/', $url)) {
      return '';
    }

    if ($url[0] === '#') {
      return $url;
    }

    $parts = parse_url($url);
    if ($parts === false) {
      return '';
    }

    $scheme = strtolower((string)($parts['scheme'] ?? ''));
    if ($scheme !== '') {
      return in_array($scheme, ['http', 'https', 'mailto', 'tel'], true) ? $url : '';
    }

    if (strpos($url, '//') === 0) {
      return '';
    }

    return $url;
  }
}

if (!function_exists('themeNavbarMenuKey')) {
  function themeNavbarMenuKey($label, $url)
  {
    $label_key = strtolower(trim((string)$label));
    $menu_key = $label_key === 'home' ? 'home' : preg_replace('/[^a-z0-9_-]+/i', '-', $label_key);
    $parsed_url = parse_url((string)$url);

    if (isset($parsed_url['query'])) {
      parse_str($parsed_url['query'], $query_params);
      if (!empty($query_params['p'])) {
        $menu_key = preg_replace('/[^a-z0-9_-]+/i', '-', strtolower((string)$query_params['p']));
      }
    }

    return trim((string)$menu_key, '-') ?: 'menu';
  }
}

if (!function_exists('themeNormalizeNavbarMenuItem')) {
  function themeNormalizeNavbarMenuItem($label, $url, $icon = '')
  {
    $label = trim(strip_tags((string)$label));
    $url = themeSafeMenuUrl($url);

    if ($label === '' || $url === '') {
      return null;
    }

    $key = themeNavbarMenuKey($label, $url);
    $icon = trim((string)$icon);
    if ($icon === '') {
      $default_icons = [
        'home' => 'fas fa-home',
        'libinfo' => 'fas fa-info-circle',
        'news' => 'fas fa-newspaper',
        'help' => 'fas fa-question-circle',
        'librarian' => 'fas fa-users',
        'login' => 'fas fa-user-shield',
        'member' => 'fas fa-user',
      ];
      $icon = $default_icons[$key] ?? 'fas fa-link';
    }

    return [
      'key' => $key,
      'text' => $label,
      'url' => $url,
      'icon' => themeNormalizeTopicIcon($icon),
    ];
  }
}

if (!function_exists('themeNavbarMenuIconClass')) {
  function themeNavbarMenuIconClass($item, $fallback = 'fas fa-link')
  {
    $icon = $item['icon'] ?? [];
    if (is_array($icon) && ($icon['type'] ?? '') === 'font' && !empty($icon['value'])) {
      return $icon['value'];
    }

    return $fallback;
  }
}

if (!function_exists('themeParseNavbarMenus')) {
  function themeParseNavbarMenus($raw)
  {
    $raw = trim((string)($raw ?? ''));
    if ($raw === themeNavbarMenuLegacyDefault() || $raw === themeNavbarMenuPlainDefault()) {
      $raw = themeNavbarMenuDefault();
    }
    $menus = [];

    if ($raw !== '') {
      $lines = preg_split('/[;\n\r]+/', $raw);
      foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '') {
          continue;
        }

        $parts = array_map('trim', explode('|', $line, 3));
        if (count($parts) < 2) {
          continue;
        }

        $item = themeNormalizeNavbarMenuItem($parts[0], $parts[1], $parts[2] ?? '');
        if ($item) {
          $menus[] = $item;
        }
      }
    }

    if (!$menus && $raw !== themeNavbarMenuDefault()) {
      return themeParseNavbarMenus(themeNavbarMenuDefault());
    }

    return $menus;
  }
}

if (!function_exists('themeAllowedHtmlTags')) {
  function themeAllowedHtmlTags()
  {
    global $sysconf;

    return $sysconf['content']['allowable_tags'] ?? '<p><a><cite><code><em><strong><blockquote><fieldset><legend><h3><hr><br><table><tr><td><th><thead><tbody><tfoot><div><span><img><ul><ol><li><i>';
  }
}

if (!function_exists('themeAllowedHtmlElements')) {
  function themeAllowedHtmlElements()
  {
    preg_match_all('/<\s*([a-z0-9]+)/i', themeAllowedHtmlTags(), $matches);
    $elements = array_map('strtolower', $matches[1] ?? []);

    return array_values(array_diff(array_unique($elements), ['object', 'param']));
  }
}

if (!function_exists('themeLoadHtmlPurifier')) {
  function themeLoadHtmlPurifier()
  {
    if (class_exists('HTMLPurifier') && class_exists('HTMLPurifier_Config')) {
      return true;
    }

    $purifier = defined('LIB')
      ? LIB . 'ezyang/htmlpurifier/library/HTMLPurifier.auto.php'
      : __DIR__ . '/../../lib/ezyang/htmlpurifier/library/HTMLPurifier.auto.php';

    if (is_file($purifier)) {
      require_once $purifier;
    }

    return class_exists('HTMLPurifier') && class_exists('HTMLPurifier_Config');
  }
}

if (!function_exists('themePurifierAllowedHtml')) {
  function themePurifierAllowedHtml()
  {
    $safe_attrs = [
      'a' => 'href|title|target|rel',
      'blockquote' => 'cite|class',
      'code' => 'class',
      'div' => 'class',
      'fieldset' => 'class',
      'h3' => 'class',
      'hr' => 'class',
      'img' => 'src|alt|title|width|height|class',
      'li' => 'class',
      'ol' => 'class',
      'p' => 'class',
      'pre' => 'class',
      'span' => 'class',
      'table' => 'class|summary',
      'tbody' => 'class',
      'td' => 'class|colspan|rowspan',
      'tfoot' => 'class',
      'th' => 'class|colspan|rowspan|scope',
      'thead' => 'class',
      'tr' => 'class',
      'ul' => 'class',
    ];

    return implode(',', array_map(function ($element) use ($safe_attrs) {
      return isset($safe_attrs[$element]) ? $element . '[' . $safe_attrs[$element] . ']' : $element;
    }, themeAllowedHtmlElements()));
  }
}

if (!function_exists('themeSanitizeHtml')) {
  function themeSanitizeHtml($html)
  {
    $html = (string)($html ?? '');
    if (themeLoadHtmlPurifier()) {
      $config = HTMLPurifier_Config::createDefault();
      $config->set('Core.Encoding', 'UTF-8');
      $config->set('Cache.DefinitionImpl', null);
      $config->set('HTML.Allowed', themePurifierAllowedHtml());
      $config->set('Attr.AllowedFrameTargets', ['_blank']);
      $config->set('URI.AllowedSchemes', ['http' => true, 'https' => true, 'mailto' => true, 'tel' => true]);

      foreach (['HTML.TargetBlank', 'HTML.TargetNoopener', 'HTML.TargetNoreferrer'] as $directive) {
        if ($config->def->info[$directive] ?? false) {
          $config->set($directive, true);
        }
      }

      return (new HTMLPurifier($config))->purify($html);
    }

    $html = preg_replace('#<\s*(script|style|iframe|object|embed)\b[^>]*>.*?<\s*/\s*\1\s*>#is', '', $html);
    $html = preg_replace('#<\s*/?\s*(script|style|iframe|object|embed)\b[^>]*>#is', '', $html);
    $html = preg_replace('/\s+on[a-z]+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $html);
    $html = preg_replace('/\s+style\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $html);
    $html = preg_replace('/\s+(href|src)\s*=\s*(["\'])\s*(javascript:|data:)[^"\']*\2/i', ' $1="#"', $html);
    $html = preg_replace('/\s+(href|src)\s*=\s*(javascript:|data:)[^\s>]*/i', ' $1="#"', $html);

    return strip_tags($html, themeAllowedHtmlTags());
  }
}

if (!function_exists('themeGetDisplayItems')) {
  function themeGetDisplayItems($dbs, $source, $content_filter, $content_detail, $biblio_filter, $limit, $char_limit)
  {
    $limit = themeSafeLimit($limit, 5, 1, 12);
    $char_limit = themeSafeInt($char_limit, 48, 12, 160);
    $items = [];

    if (!$dbs) {
      return $items;
    }

    $limit_text = static function ($text) use ($char_limit) {
      $text = trim(strip_tags((string)($text ?? '')));
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
