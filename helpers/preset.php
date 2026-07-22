<?php
/**
 * Helper Module for Rasamala Template
 */
if (!defined('INDEX_AUTH') || INDEX_AUTH != 1) {
  die("can not access this file directly");
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
          'classic_hero_background_animation' => 'twinkle',
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
          'classic_theme_color' => 'warmgray',
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
          'classic_theme_color' => 'warmlibrary',
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
          'classic_theme_color' => 'warmlibrary',
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
          'classic_hero_background_animation' => 'twinkle',
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
          'classic_hero_background_animation' => 'twinkle',
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
          'classic_cursor_custom_icon' => 'electric-bolt',
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

if (!function_exists('themeIsHomepage')) {
  function themeIsHomepage()
  {
    return !isset($_GET['p']) && !isset($_GET['search']);
  }
}

if (!function_exists('themePresetKey')) {
  function themePresetKey($sysconf_param = null)
  {
    global $sysconf;

    $source = is_array($sysconf_param) ? $sysconf_param : $sysconf;
    $preset = strtolower(trim((string)($source['template']['classic_theme_preset'] ?? 'simple_homepage')));
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
      'classic_palette_custom',
      'classic_color_toggle',
      'classic_palette_switcher_show',
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

if (!function_exists('themeColorModeSetting')) {
  function themeColorModeSetting($sysconf_param = null)
  {
    $value = strtolower(trim((string)themeEffectiveTemplateValue('classic_color_toggle', 'auto_show', $sysconf_param)));

    if ($value === '1' || $value === 'show') {
      return 'auto_show';
    }
    if ($value === '0' || $value === 'hide') {
      return 'auto_hide';
    }

    $allowed = ['auto_show', 'auto_hide', 'dark_show', 'dark_hide', 'light_show', 'light_hide'];
    return in_array($value, $allowed, true) ? $value : 'auto_show';
  }
}

if (!function_exists('themeColorModeDefault')) {
  function themeColorModeDefault($sysconf_param = null)
  {
    $setting = themeColorModeSetting($sysconf_param);

    if (strpos($setting, 'dark_') === 0) {
      return 'dark';
    }
    if (strpos($setting, 'light_') === 0) {
      return 'light';
    }

    return 'auto';
  }
}

if (!function_exists('themeColorModeToggleVisible')) {
  function themeColorModeToggleVisible($sysconf_param = null)
  {
    return substr(themeColorModeSetting($sysconf_param), -5) === '_show';
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

if (!function_exists('themeBackgroundAnimationOptions')) {
  function themeBackgroundAnimationOptions()
  {
    return ['none', 'particles', 'rain', 'grid', 'twinkle', 'zen-ripples', 'neural-network', 'starfield-warp', 'floating-embers'];
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
