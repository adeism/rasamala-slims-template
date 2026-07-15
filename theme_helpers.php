<?php
/**
 * Shared helpers for templates that can be loaded before classic.php.
 *
 * @Last modified by    : Ade Ismail Siregar (adeismailbox@gmail.com)
 * @Last modified time  : 2026-07-15T14:59:12+07:00
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

if (!function_exists('themeLanguageIsVisible')) {
  function themeLanguageIsVisible($lang_code, $sysconf)
  {
    $lang_code = strtolower(trim((string)$lang_code));
    if ($lang_code === '') {
      return false;
    }

    $visible_raw = trim((string)($sysconf['template']['classic_language_visible_codes'] ?? ''));
    if ($visible_raw === '') {
      return false;
    }

    $visible_codes = array_filter(array_map(function ($item) {
      return strtolower(trim($item));
    }, preg_split('/[,;\s]+/', $visible_raw)));

    return in_array($lang_code, $visible_codes, true);
  }
}

if (!function_exists('themePresetDefinitions')) {
  function themePresetDefinitions()
  {
    return [
      'simple_homepage' => [
        'label' => 'Simple - Search + Running Text',
        'description' => 'Preset paling sederhana: beranda fokus pencarian dengan running text bawah sebagai info singkat. Fitur lain tetap ringan.',
        'footer_home' => false,
        'settings' => [
          'classic_homepage_only_hero' => 1,
          'classic_topic_show' => 0,
          'classic_popular_collection' => 0,
          'classic_new_collection' => 0,
          'classic_top_reader' => 0,
          'classic_homepage_section_order' => '',
          'classic_map' => 'hide_all',
          'classic_home_display_show' => 0,
          'classic_ticker_show' => 0,
          'classic_footer_show' => 1,
          'classic_theme_color' => 'darkgray',
          'classic_font_family' => 'inter',
          'classic_hero_background_animation' => 'none',
          'classic_cursor_particles' => 'none',
        ],
      ],
      'all_show' => [
        'label' => 'Full - Topics + News + Collections + Top Reader + Map + Running Text',
        'description' => 'Preset paling lengkap: semua section utama, latest content, topic, koleksi populer/terbaru, top reader, map, ticker, footer, dan animasi.',
        'footer_home' => true,
        'settings' => [
          'classic_homepage_only_hero' => 0,
          'classic_topic_show' => 1,
          'classic_popular_collection' => 1,
          'classic_new_collection' => 1,
          'classic_top_reader' => 1,
          'classic_homepage_section_order' => 'topic;news;popular;new-collection;top-reader;map',
          'classic_map' => 'all',
          'classic_home_display_show' => 'below',
          'classic_ticker_show' => 'bottom',
          'classic_footer_show' => 1,
          'classic_theme_color' => 'warmlibrary',
          'classic_font_family' => 'poppins',
          'classic_hero_background_animation' => 'constellation',
          'classic_cursor_particles' => 'auto',
        ],
      ],
      'simple_topics' => [
        'label' => 'Topic-Focused Directory',
        'description' => 'Direktori pencarian yang berfokus pada kategori dan ikon subjek pustaka. Koleksi buku dan peta disembunyikan.',
        'footer_home' => false,
        'settings' => [
          'classic_homepage_only_hero' => 0,
          'classic_topic_show' => 1,
          'classic_popular_collection' => 0,
          'classic_new_collection' => 0,
          'classic_top_reader' => 0,
          'classic_homepage_section_order' => 'topic',
          'classic_map' => 'hide_all',
          'classic_home_display_show' => 0,
          'classic_ticker_show' => 0,
          'classic_footer_show' => 1,
          'classic_theme_color' => 'emerald',
          'classic_font_family' => 'inter',
          'classic_hero_background_animation' => 'bubbles',
        ],
      ],
      'simple_topics_footer' => [
        'label' => 'Classic Directory with Footer',
        'description' => 'Tampilan direktori subjek kategori klasik lengkap dengan tautan footer informasi perpustakaan.',
        'footer_home' => true,
        'settings' => [
          'classic_homepage_only_hero' => 0,
          'classic_topic_show' => 1,
          'classic_popular_collection' => 0,
          'classic_new_collection' => 0,
          'classic_top_reader' => 0,
          'classic_homepage_section_order' => 'topic',
          'classic_map' => 'hide_all',
          'classic_home_display_show' => 0,
          'classic_ticker_show' => 0,
          'classic_footer_show' => 1,
          'classic_theme_color' => 'orange',
          'classic_font_family' => 'poppins',
          'classic_hero_background_animation' => 'bubbles',
        ],
      ],
      'fun' => [
        'label' => 'Modern Interactive Portal',
        'description' => 'Portal dinamis interaktif dengan ornamen modern, korsel koleksi aktif, font tebal, dan partikel cursor melayang.',
        'footer_home' => true,
        'settings' => [
          'classic_homepage_only_hero' => 0,
          'classic_topic_show' => 1,
          'classic_popular_collection' => 1,
          'classic_new_collection' => 1,
          'classic_top_reader' => 1,
          'classic_homepage_section_order' => 'topic;news;popular;new-collection;top-reader',
          'classic_map' => 'hide_all',
          'classic_home_display_show' => 'below',
          'classic_ticker_show' => 0,
          'classic_footer_show' => 1,
          'classic_theme_color' => 'pink',
          'classic_font_family' => 'poppins',
          'classic_hero_background_animation' => 'glow',
          'classic_cursor_particles' => 'medium',
        ],
      ],
      'office' => [
        'label' => 'Simple + Topics',
        'description' => 'Preset ringkas: search utama ditambah daftar topic saja. Teks section Topics disembunyikan agar tampil seperti direktori sederhana.',
        'footer_home' => false,
        'settings' => [
          'classic_homepage_only_hero' => 0,
          'classic_topic_show' => 1,
          'classic_topic_heading_display' => 'hide',
          'classic_popular_collection' => 0,
          'classic_new_collection' => 0,
          'classic_top_reader' => 0,
          'classic_homepage_section_order' => 'topic',
          'classic_map' => 'hide_all',
          'classic_home_display_show' => 'below',
          'classic_ticker_show' => 0,
          'classic_footer_show' => 1,
          'classic_theme_color' => 'cleanblue',
          'classic_font_family' => 'inter',
          'classic_hero_background_animation' => 'waves',
          'classic_cursor_particles' => 'none',
        ],
      ],
      'academic' => [
        'label' => 'Academic & Research Portal',
        'description' => 'Desain portal prestisius untuk sekolah tinggi/universitas. Menonjolkan daftar bacaan, peringkat pembaca terbaik, dan peta kampus.',
        'footer_home' => true,
        'settings' => [
          'classic_homepage_only_hero' => 0,
          'classic_topic_show' => 1,
          'classic_popular_collection' => 0,
          'classic_new_collection' => 1,
          'classic_top_reader' => 1,
          'classic_homepage_section_order' => 'topic;news;new-collection;top-reader;map',
          'classic_map' => 'all',
          'classic_home_display_show' => 'below',
          'classic_ticker_show' => 0,
          'classic_footer_show' => 1,
          'classic_theme_color' => 'forest',
          'classic_font_family' => 'playfair',
          'classic_hero_background_animation' => 'constellation',
        ],
      ],
      'minimalist' => [
        'label' => 'Minimalist Modern Portal',
        'description' => 'Tema ultra-bersih dengan transisi warna halus, font sans-serif tipis, dan efek orbs melayang yang estetik.',
        'footer_home' => true,
        'settings' => [
          'classic_homepage_only_hero' => 0,
          'classic_topic_show' => 0,
          'classic_popular_collection' => 0,
          'classic_new_collection' => 0,
          'classic_top_reader' => 0,
          'classic_homepage_section_order' => '',
          'classic_map' => 'hide_all',
          'classic_home_display_show' => 'below',
          'classic_ticker_show' => 0,
          'classic_footer_show' => 1,
          'classic_theme_color' => 'monominimal',
          'classic_font_family' => 'roboto',
          'classic_hero_background_animation' => 'glow',
          'classic_cursor_particles' => 'low',
        ],
      ],
      'minimal_white' => [
        'label' => 'Minimal White Portal',
        'description' => 'Portal putih minimalis dengan kontras teks tegas, surface bersih, dan aksen biru kecil agar tampilan sangat ringan.',
        'footer_home' => true,
        'settings' => [
          'classic_homepage_only_hero' => 0,
          'classic_topic_show' => 1,
          'classic_popular_collection' => 0,
          'classic_new_collection' => 1,
          'classic_top_reader' => 0,
          'classic_homepage_section_order' => 'topic;news;new-collection',
          'classic_map' => 'hide_all',
          'classic_home_display_show' => 'below',
          'classic_ticker_show' => 0,
          'classic_footer_show' => 1,
          'classic_theme_color' => 'minimalwhite',
          'classic_font_family' => 'inter',
          'classic_hero_background_animation' => 'none',
          'classic_cursor_particles' => 'none',
        ],
      ],
      'dark_gray' => [
        'label' => 'Dark Gray Portal',
        'description' => 'Portal dark gray netral yang tidak kebiruan, cocok untuk tampilan modern dan nyaman dibaca pada layar gelap.',
        'footer_home' => true,
        'settings' => [
          'classic_homepage_only_hero' => 0,
          'classic_topic_show' => 1,
          'classic_popular_collection' => 1,
          'classic_new_collection' => 1,
          'classic_top_reader' => 0,
          'classic_homepage_section_order' => 'topic;news;popular;new-collection',
          'classic_map' => 'hide_all',
          'classic_home_display_show' => 'below',
          'classic_ticker_show' => 'bottom',
          'classic_footer_show' => 1,
          'classic_theme_color' => 'darkgray',
          'classic_font_family' => 'inter',
          'classic_hero_background_animation' => 'twinkle',
          'classic_background_animation_speed' => 'slow',
          'classic_cursor_particles' => 'low',
        ],
      ],
      'futuristic' => [
        'label' => 'Futuristic Digital Portal',
        'description' => 'Desain gelap sci-fi dengan partikel laser neon, animasi hujan kode siber, dan interaksi pointer modern.',
        'footer_home' => true,
        'settings' => [
          'classic_homepage_only_hero' => 0,
          'classic_topic_show' => 1,
          'classic_popular_collection' => 1,
          'classic_new_collection' => 1,
          'classic_top_reader' => 1,
          'classic_homepage_section_order' => 'topic;news;popular;new-collection;top-reader',
          'classic_map' => 'hide_all',
          'classic_home_display_show' => 'below',
          'classic_ticker_show' => 'bottom',
          'classic_footer_show' => 1,
          'classic_theme_color' => 'darkgray',
          'classic_font_family' => 'poppins',
          'classic_hero_background_animation' => 'rain',
          'classic_cursor_particles' => 'high',
          'classic_cursor_custom_icon' => 'cyber-drone',
        ],
      ],
      'custom' => [
        'label' => 'Custom (Fully Unlocked)',
        'description' => 'Membuka penuh seluruh konfigurasi tema secara mendalam. Nilai khusus setiap kolom input akan digunakan langsung.',
        'footer_home' => null,
        'settings' => [],
      ],
    ];
  }
}

if (!function_exists('themePresetKey')) {
  function themePresetKey($sysconf_param = null)
  {
    global $sysconf;

    $source = is_array($sysconf_param) ? $sysconf_param : $sysconf;
    $preset = strtolower(trim((string)($source['template']['classic_theme_preset'] ?? 'simple_homepage')));
    $aliases = [
      'simple_topics' => 'office',
      'simple_topics_footer' => 'office',
      'minimalist' => 'simple_homepage',
      'minimal_white' => 'simple_homepage',
      'dark_gray' => 'simple_homepage',
      'fun' => 'all_show',
      'academic' => 'all_show',
      'futuristic' => 'all_show',
    ];
    $preset = $aliases[$preset] ?? $preset;
    $definitions = themePresetDefinitions();

    return array_key_exists($preset, $definitions) ? $preset : 'simple_homepage';
  }
}

if (!function_exists('themePresetDefinition')) {
  function themePresetDefinition($sysconf_param = null)
  {
    $definitions = themePresetDefinitions();
    return $definitions[themePresetKey($sysconf_param)];
  }
}

if (!function_exists('themePresetQuickSettingKeys')) {
  function themePresetQuickSettingKeys()
  {
    return [
      'classic_theme_color',
      'classic_palette_primary',
      'classic_palette_secondary',
      'classic_palette_accent',
      'classic_palette_background',
      'classic_palette_surface',
      'classic_palette_text',
      'classic_palette_muted',
      'classic_color_toggle',
      'classic_font_family',
      'classic_search_result_layout',
      'classic_search_panel_style',
      'classic_news_list_layout',
      'classic_home_display_show',
      'classic_home_display_style',
      'classic_home_display_source',
      'classic_home_display_custom_text',
      'classic_home_display_content_filter',
      'classic_home_display_content_detail',
      'classic_home_display_biblio_filter',
      'classic_home_item_limit',
      'classic_home_char_limit',
      'classic_ticker_show',
      'classic_ticker_source',
      'classic_ticker_custom_text',
      'classic_ticker_content_filter',
      'classic_ticker_content_detail',
      'classic_ticker_biblio_filter',
      'classic_ticker_speed',
      'classic_ticker_item_limit',
      'classic_ticker_char_limit',
      'classic_home_content_cards_show',
      'classic_home_content_cards_source',
      'classic_home_content_path_1',
      'classic_home_content_path_2',
      'classic_home_content_path_3',
      'classic_hero_background_animation',
      'classic_background_animation_speed',
      'classic_cursor_particles',
      'classic_cursor_custom_icon',
      'classic_prayer_times_show',
      'classic_prayer_times_city',
      'classic_auto_cover_generator',
      'classic_show_author_role',
      'classic_detail_label_type',
      'classic_librarian_display_mode',
      'classic_librarian_custom_usernames',
    ];
  }
}

if (!function_exists('themePresetUsesManualSetting')) {
  function themePresetUsesManualSetting($key)
  {
    return in_array((string)$key, themePresetQuickSettingKeys(), true);
  }
}

if (!function_exists('themePresetIsCustom')) {
  function themePresetIsCustom($sysconf_param = null)
  {
    return themePresetKey($sysconf_param) === 'custom';
  }
}

if (!function_exists('themeEffectiveTemplateValue')) {
  function themeEffectiveTemplateValue($key, $default = null, $sysconf_param = null)
  {
    global $sysconf;

    $source = is_array($sysconf_param) ? $sysconf_param : $sysconf;
    $definition = themePresetDefinition($source);
    if (!themePresetIsCustom($source) && !themePresetUsesManualSetting($key) && array_key_exists($key, $definition['settings'])) {
      return $definition['settings'][$key];
    }

    return $source['template'][$key] ?? $default;
  }
}

if (!function_exists('themeHomepageOnlyHero')) {
  function themeHomepageOnlyHero($sysconf_param = null)
  {
    return (int)themeEffectiveTemplateValue('classic_homepage_only_hero', 0, $sysconf_param) === 1;
  }
}

if (!function_exists('themeHomepageSectionOrder')) {
  function themeHomepageSectionOrder($sysconf_param = null)
  {
    $order_raw = (string)themeEffectiveTemplateValue('classic_homepage_section_order', 'topic;popular;new-collection;top-reader;map', $sysconf_param);
    $sections = array_filter(array_map(function ($item) {
      return strtolower(trim(str_replace(' ', '', $item)));
    }, explode(';', $order_raw)));

    return $sections;
  }
}

if (!function_exists('themeHomepageSectionEnabled')) {
  function themeHomepageSectionEnabled($section, $sysconf_param = null)
  {
    $section = strtolower(trim((string)$section));
    switch ($section) {
      case 'topic':
        return (int)themeEffectiveTemplateValue('classic_topic_show', 1, $sysconf_param) === 1;
      case 'news':
        return (int)themeEffectiveTemplateValue('classic_home_content_cards_show', 1, $sysconf_param) === 1;
      case 'popular':
        return (int)themeEffectiveTemplateValue('classic_popular_collection', 1, $sysconf_param) === 1;
      case 'new-collection':
        return (int)themeEffectiveTemplateValue('classic_new_collection', 1, $sysconf_param) === 1;
      case 'top-reader':
        return (int)themeEffectiveTemplateValue('classic_top_reader', 1, $sysconf_param) === 1;
      case 'map':
        return themeShowMap($sysconf_param) || themeShowSocialMedia($sysconf_param);
      default:
        return false;
    }
  }
}

if (!function_exists('themeFooterEnabled')) {
  function themeFooterEnabled($sysconf_param = null, $is_homepage = false)
  {
    $footer_show = (int)themeEffectiveTemplateValue('classic_footer_show', 1, $sysconf_param) === 1;
    if (!$footer_show) {
      return false;
    }

    if ($is_homepage && !themePresetIsCustom($sysconf_param)) {
      $definition = themePresetDefinition($sysconf_param);
      return (bool)$definition['footer_home'];
    }

    return !($is_homepage && themeHomepageOnlyHero($sysconf_param));
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

if (!function_exists('themeMapSocialMode')) {
  function themeMapSocialMode($sysconf)
  {
    $mode = themeEffectiveTemplateValue('classic_map', 'all', $sysconf);
    if ($mode === 1 || $mode === true || $mode === '1' || $mode === 'show') {
      return 'all';
    }
    if ($mode === 0 || $mode === false || $mode === '0' || $mode === 'hide') {
      return 'hide_all';
    }

    $mode = strtolower(trim((string)$mode));
    $valid_modes = ['all', 'hide_all', 'hide_map', 'hide_social'];
    return in_array($mode, $valid_modes, true) ? $mode : 'all';
  }
}

if (!function_exists('themeShowMap')) {
  function themeShowMap($sysconf)
  {
    return in_array(themeMapSocialMode($sysconf), ['all', 'hide_social'], true);
  }
}

if (!function_exists('themeShowSocialMedia')) {
  function themeShowSocialMedia($sysconf)
  {
    return in_array(themeMapSocialMode($sysconf), ['all', 'hide_map'], true);
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
    return ['none', 'particles', 'constellation', 'rain', 'waves', 'grid', 'bubbles', 'twinkle', 'glow'];
  }
}

if (!function_exists('themeBackgroundAnimation')) {
  function themeBackgroundAnimation()
  {
    global $sysconf;

    $animation = strtolower(trim((string)themeEffectiveTemplateValue('classic_hero_background_animation', 'particles', $sysconf)));
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
    return 'Literature | index.php?callnumber=8&search=search | fas fa-book ; Social Sciences | index.php?callnumber=3&search=search | fas fa-users ; Applied Sciences | index.php?callnumber=6&search=search | fas fa-flask ; Art & Recreation | index.php?callnumber=7&search=search | fas fa-paint-brush ; Language | index.php?callnumber=4&search=search | fas fa-language ; see more.. | #exampleModal | fas fa-th-large';
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
      $modal_attrs = ' data-bs-toggle="modal" data-bs-target="' . themeEscape($url) . '"';
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
        'label' => 'Warm Gray',
        'primary' => '#6f5b43',
        'hover' => '#5d4b36',
        'secondary' => '#a58a63',
        'accent' => '#c8a24a',
        'background' => '#f4f1ec',
        'surface' => '#ffffff',
        'text' => '#2f2a24',
        'muted' => '#7a7167',
        'rgb' => '111, 91, 67',
      ],
      'cyan' => [
        'label' => 'Neon Cyan',
        'primary' => '#0891b2',
        'hover' => '#0e7490',
        'secondary' => '#164e63',
        'accent' => '#22d3ee',
        'background' => '#ecfeff',
        'surface' => '#ffffff',
        'text' => '#083344',
        'muted' => '#4b6b75',
        'rgb' => '8, 145, 178',
      ],
      'emerald' => [
        'label' => 'Neon Emerald',
        'primary' => '#047857',
        'hover' => '#065f46',
        'secondary' => '#0f766e',
        'accent' => '#22c55e',
        'background' => '#f3faf7',
        'surface' => '#ffffff',
        'text' => '#17251f',
        'muted' => '#5f7169',
        'rgb' => '4, 120, 87',
      ],
      'orange' => [
        'label' => 'Sunset Orange',
        'primary' => '#b45309',
        'hover' => '#92400e',
        'secondary' => '#7c3aed',
        'accent' => '#f97316',
        'background' => '#fff8f1',
        'surface' => '#ffffff',
        'text' => '#30251d',
        'muted' => '#7a6a5d',
        'rgb' => '180, 83, 9',
      ],
      'gold' => [
        'label' => 'Royal Gold',
        'primary' => '#1e3a5f',
        'hover' => '#172f4d',
        'secondary' => '#8a6f1f',
        'accent' => '#d4af37',
        'background' => '#f7f3e8',
        'surface' => '#ffffff',
        'text' => '#1f2937',
        'muted' => '#6f654c',
        'rgb' => '30, 58, 95',
      ],
      'pink' => [
        'label' => 'Electric Pink',
        'primary' => '#be185d',
        'hover' => '#9d174d',
        'secondary' => '#7c3aed',
        'accent' => '#ec4899',
        'background' => '#fff5f9',
        'surface' => '#ffffff',
        'text' => '#331827',
        'muted' => '#7b6470',
        'rgb' => '190, 24, 93',
      ],
      'minimalwhite' => [
        'label' => 'Minimal White',
        'primary' => '#0f172a',
        'hover' => '#020617',
        'secondary' => '#64748b',
        'accent' => '#2563eb',
        'background' => '#ffffff',
        'surface' => '#ffffff',
        'text' => '#0f172a',
        'muted' => '#64748b',
        'rgb' => '15, 23, 42',
      ],
      'darkgray' => [
        'label' => 'Dark Gray',
        'primary' => '#374151',
        'hover' => '#1f2937',
        'secondary' => '#6b7280',
        'accent' => '#0ea5e9',
        'background' => '#f3f4f6',
        'surface' => '#ffffff',
        'text' => '#111827',
        'muted' => '#5f6875',
        'rgb' => '55, 65, 81',
      ],
      'forest' => [
        'label' => 'Forest Academic',
        'primary' => '#14532d',
        'hover' => '#0f3f22',
        'secondary' => '#64748b',
        'accent' => '#c8a24a',
        'background' => '#f7f8f3',
        'surface' => '#ffffff',
        'text' => '#1f2933',
        'muted' => '#65705f',
        'rgb' => '20, 83, 45',
      ],
      'cleanblue' => [
        'label' => 'Clean Blue',
        'primary' => '#1d4ed8',
        'hover' => '#1e40af',
        'secondary' => '#0f766e',
        'accent' => '#38bdf8',
        'background' => '#f8fafc',
        'surface' => '#ffffff',
        'text' => '#172033',
        'muted' => '#64748b',
        'rgb' => '29, 78, 216',
      ],
      'warmlibrary' => [
        'label' => 'Warm Library',
        'primary' => '#7f1d1d',
        'hover' => '#641818',
        'secondary' => '#3f6212',
        'accent' => '#b7791f',
        'background' => '#fff7ed',
        'surface' => '#fffdf8',
        'text' => '#2f1f1a',
        'muted' => '#7c6256',
        'rgb' => '127, 29, 29',
      ],
      'monominimal' => [
        'label' => 'Mono Minimal',
        'primary' => '#27272a',
        'hover' => '#18181b',
        'secondary' => '#71717a',
        'accent' => '#52525b',
        'background' => '#fafafa',
        'surface' => '#ffffff',
        'text' => '#18181b',
        'muted' => '#71717a',
        'rgb' => '39, 39, 42',
      ],
    ];
  }
}

if (!function_exists('themeNormalizeHexColor')) {
  function themeNormalizeHexColor($value, $fallback)
  {
    $value = trim((string)$value);
    if (preg_match('/^#?[0-9a-fA-F]{6}$/', $value)) {
      return '#' . strtolower(ltrim($value, '#'));
    }

    return $fallback;
  }
}

if (!function_exists('themeHexToRgbString')) {
  function themeHexToRgbString($hex)
  {
    $hex = ltrim(themeNormalizeHexColor($hex, '#6f5b43'), '#');
    return hexdec(substr($hex, 0, 2)) . ', ' . hexdec(substr($hex, 2, 2)) . ', ' . hexdec(substr($hex, 4, 2));
  }
}

if (!function_exists('themeHexColorLuminance')) {
  function themeHexColorLuminance($hex)
  {
    $hex = ltrim(themeNormalizeHexColor($hex, '#ffffff'), '#');
    $channels = [];
    for ($i = 0; $i < 3; $i++) {
      $value = hexdec(substr($hex, $i * 2, 2)) / 255;
      $channels[] = ($value <= 0.03928) ? ($value / 12.92) : pow(($value + 0.055) / 1.055, 2.4);
    }

    return (0.2126 * $channels[0]) + (0.7152 * $channels[1]) + (0.0722 * $channels[2]);
  }
}

if (!function_exists('themePaletteIsDark')) {
  function themePaletteIsDark($palette)
  {
    if (!is_array($palette)) {
      return false;
    }

    $background_luminance = themeHexColorLuminance($palette['background'] ?? '#ffffff');
    $surface_luminance = themeHexColorLuminance($palette['surface'] ?? '#ffffff');

    return $background_luminance < 0.28 || $surface_luminance < 0.28;
  }
}

if (!function_exists('themeAdjustHexColor')) {
  function themeAdjustHexColor($hex, $amount = -22)
  {
    $hex = ltrim(themeNormalizeHexColor($hex, '#6f5b43'), '#');
    $result = '#';
    for ($i = 0; $i < 3; $i++) {
      $channel = hexdec(substr($hex, $i * 2, 2));
      $channel = max(0, min(255, $channel + (int)$amount));
      $result .= str_pad(dechex($channel), 2, '0', STR_PAD_LEFT);
    }
    return $result;
  }
}

if (!function_exists('themeSelectedAccentColor')) {
  function themeSelectedAccentColor($color, $sysconf_param = null)
  {
    global $sysconf;

    $palettes = themeAccentPalettes();
    $key = strtolower((string)($color ?? 'warmgray'));
    if ($key === 'custom') {
      $source = is_array($sysconf_param) ? $sysconf_param : $sysconf;
      $base = $palettes['minimalwhite'];
      $primary = themeNormalizeHexColor($source['template']['classic_palette_primary'] ?? '', $base['primary']);
      $palette = [
        'label' => 'Custom Palette',
        'primary' => $primary,
        'hover' => themeAdjustHexColor($primary, -28),
        'secondary' => themeNormalizeHexColor($source['template']['classic_palette_secondary'] ?? '', $base['secondary']),
        'accent' => themeNormalizeHexColor($source['template']['classic_palette_accent'] ?? '', $base['accent']),
        'background' => themeNormalizeHexColor($source['template']['classic_palette_background'] ?? '', $base['background']),
        'surface' => themeNormalizeHexColor($source['template']['classic_palette_surface'] ?? '', $base['surface']),
        'text' => themeNormalizeHexColor($source['template']['classic_palette_text'] ?? '', $base['text']),
        'muted' => themeNormalizeHexColor($source['template']['classic_palette_muted'] ?? '', $base['muted']),
      ];
      $palette['rgb'] = themeHexToRgbString($palette['primary']);
      return $palette;
    }

    return $palettes[$key] ?? $palettes['warmgray'];
  }
}

if (!function_exists('themeEffectiveAccentColorKey')) {
  function themeEffectiveAccentColorKey($sysconf_param = null)
  {
    return (string)themeEffectiveTemplateValue('classic_theme_color', 'warmgray', $sysconf_param);
  }
}

if (!function_exists('themeEffectiveFontFamilyKey')) {
  function themeEffectiveFontFamilyKey($sysconf_param = null)
  {
    return (string)themeEffectiveTemplateValue('classic_font_family', 'system', $sysconf_param);
  }
}

if (!function_exists('themeNavbarMenuDefault')) {
  function themeNavbarMenuDefault()
  {
    return 'Home | index.php | fas fa-home ; Information | index.php?p=libinfo | fas fa-info-circle ; News | index.php?p=news | fas fa-newspaper ; Help | index.php?p=help | fas fa-question-circle ; Librarian | index.php?p=librarian | fas fa-users ; Staff Area | index.php?p=login | fas fa-university';
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
    if ($icon === 'fas fa-user-shield') {
      $icon = 'fas fa-university';
    }
    if ($icon === '') {
      $default_icons = [
        'home' => 'fas fa-home',
        'libinfo' => 'fas fa-info-circle',
        'news' => 'fas fa-newspaper',
        'help' => 'fas fa-question-circle',
        'librarian' => 'fas fa-users',
        'login' => 'fas fa-university',
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
  function themeGenerateBookCoverHtml($title)
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
    if (mb_strlen($display_title, 'UTF-8') > 40) {
      $display_title = mb_substr($display_title, 0, 37, 'UTF-8') . '...';
    }
    
    $html = '<div class="book-cover-placeholder book-cover-gradient-' . $gradient_index . '">';
    $html .= '<div class="book-cover-content">';
    $html .= '<div class="book-cover-header-text">' . themeEscape(__('COLLECTION')) . '</div>';
    $html .= '<div class="book-cover-title-text">' . themeEscape($display_title) . '</div>';
    $html .= '<div class="book-cover-footer-text">FEB UI</div>';
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
