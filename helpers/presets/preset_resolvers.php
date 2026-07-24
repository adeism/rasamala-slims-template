<?php
/**
 * Helper Module for Rasamala Template - Theme Preset Value Resolvers
 */
if (!defined('INDEX_AUTH') || INDEX_AUTH != 1) {
  die("can not access this file directly");
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
