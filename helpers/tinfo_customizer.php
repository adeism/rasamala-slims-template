<?php
/**
 * Helper Module for Rasamala Template
 */
if (!defined('INDEX_AUTH') || INDEX_AUTH != 1) {
  die("can not access this file directly");
}

if (!function_exists('rasamalaTinfoCustomizeAssets')) {
  function rasamalaTinfoCustomizeAssets()
  {
    global $sysconf;

    $theme_dir = 'rasamala';
    $template_dir = $sysconf['template']['dir'] ?? 'template';
    $asset_base = (defined('SWB') ? SWB : '') . $template_dir . '/' . $theme_dir . '/assets/';
    $fontawesome_css = htmlspecialchars($asset_base . 'plugin/font-awesome/css/fontawesome-all.min.css', ENT_QUOTES, 'UTF-8');
    $flag_icon_css = htmlspecialchars($asset_base . 'css/flag-icon.min.css', ENT_QUOTES, 'UTF-8');
    $tinfo_customizer_css_path = dirname(__DIR__) . '/assets/css/tinfo-customizer.css';
    $tinfo_customizer_css_version = is_file($tinfo_customizer_css_path) ? filemtime($tinfo_customizer_css_path) : (defined('SENAYAN_VERSION') ? SENAYAN_VERSION : time());
    $tinfo_customizer_css = htmlspecialchars($asset_base . 'css/tinfo-customizer.css?v=' . $tinfo_customizer_css_version, ENT_QUOTES, 'UTF-8');
    $icon_options_json = json_encode(rasamalaTinfoTopicIconOptions(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
    $asset_base_json = json_encode($asset_base, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
    $language_options = rasamalaTinfoLanguageOptions();
    $language_options_json = json_encode($language_options, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
    include_once dirname(__DIR__) . '/theme_helpers.php';
    $preset_descriptions = [];
    if (function_exists('themePresetDefinitions')) {
      foreach (themePresetDefinitions() as $preset_key => $preset_info) {
        $preset_descriptions[$preset_key] = [
          'title' => $preset_info['label'] ?? $preset_key,
          'description' => $preset_info['description'] ?? '',
        ];
      }
    }
    $palette_definitions = [];
    if (function_exists('themeAccentPalettes')) {
      foreach (themeAccentPalettes() as $palette_key => $palette_info) {
        $palette_definitions[$palette_key] = [
          'label' => $palette_info['label'] ?? $palette_key,
          'primary' => $palette_info['primary'] ?? '#6f5b43',
          'secondary' => $palette_info['secondary'] ?? '#a58a63',
          'accent' => $palette_info['accent'] ?? '#c8a24a',
          'background' => $palette_info['background'] ?? '#f4f1ec',
          'surface' => $palette_info['surface'] ?? '#ffffff',
          'text' => $palette_info['text'] ?? '#2f2a24',
          'muted' => $palette_info['muted'] ?? '#7a7167',
        ];
      }
    }
    $preset_descriptions_json = json_encode($preset_descriptions, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
    $palette_definitions_json = json_encode($palette_definitions, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
    $default_announcement_json = json_encode("<strong>Info layanan:</strong> Perpustakaan buka Senin-Jumat, pukul 08.00-16.00 WIB.\n<a href=\"index.php?p=libinfo\">Lihat informasi lengkap</a>.", JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
    $default_custom_css_json = json_encode("/* Custom CSS Rasamala\n   Edit contoh di bawah ini sesuai kebutuhan. */\n\n/* Contoh: ubah ukuran nama perpustakaan di navbar */\n/* .navbar-lib-name {\n  font-size: 14px !important;\n} */\n\n/* Contoh: beri jarak tambahan pada judul hero */\n/* .hero-search-heading h1 {\n  margin-bottom: 16px !important;\n} */\n\n/* Contoh: custom warna tombol utama */\n/* .btn-primary {\n  background-color: var(--theme-accent-color) !important;\n  border-color: var(--theme-accent-color) !important;\n} */", JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
    $default_visitor_split_steps_json = json_encode("<div class=\"inst-step\">\n  <div class=\"inst-icon-box\"><i class=\"fas fa-id-card\"></i></div>\n  <div class=\"inst-content\">\n    <h3>1. Isi Identitas</h3>\n    <p>Scan kartu anggota atau ketik identitas pengunjung pada kolom yang tersedia.</p>\n  </div>\n</div>\n<div class=\"inst-step inst-step-featured\">\n  <div class=\"inst-icon-box\"><i class=\"fas fa-sync-alt\"></i></div>\n  <div class=\"inst-content\">\n    <h3>2. Proses Kunjungan</h3>\n    <p>Sistem akan memeriksa data dan menampilkan status kunjungan secara otomatis.</p>\n  </div>\n</div>\n<div class=\"inst-step\">\n  <div class=\"inst-icon-box\"><i class=\"fas fa-check\"></i></div>\n  <div class=\"inst-content\">\n    <h3>3. Selesai</h3>\n    <p>Setelah berhasil, pengunjung dapat melanjutkan aktivitas sesuai layanan yang tersedia.</p>\n  </div>\n</div>", JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
    $default_visitor_institution_options_json = json_encode("feb(Fakultas Ekonomi dan Bisnis UI);ff(Fakultas Farmasi UI);fh(Fakultas Hukum UI);fia(Fakultas Ilmu Administrasi UI);fib(Fakultas Ilmu Budaya UI);fik(Fakultas Ilmu Keperawatan UI);fasilkom(Fakultas Ilmu Komputer UI);fisip(Fakultas Ilmu Sosial dan Ilmu Politik UI);fk(Fakultas Kedokteran UI);fkg(Fakultas Kedokteran Gigi UI);fkm(Fakultas Kesehatan Masyarakat UI);fmipa(Fakultas Matematika dan Ilmu Pengetahuan Alam UI);fpsi(Fakultas Psikologi UI);ft(Fakultas Teknik UI);vokasi(Program Vokasi UI);other", JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);

    return <<<HTML
<link rel="stylesheet" href="{$fontawesome_css}">
<link rel="stylesheet" href="{$flag_icon_css}">
<link rel="stylesheet" href="{$tinfo_customizer_css}">
<style>
/* Custom Admin Settings Formatting Improvements */
#themeCustomiseForm input[type="text"],
#themeCustomiseForm select,
#themeCustomiseForm textarea,
input[name^="classic_"],
select[name^="classic_"],
textarea[name^="classic_"] {
    width: 100% !important;
    max-width: 720px !important;
    padding: 10px 14px !important;
    border: 1px solid #ccd0d4 !important;
    border-radius: 6px !important;
    font-size: 14px !important;
    color: #2c3338 !important;
    background-color: #ffffff !important;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06) !important;
    box-sizing: border-box !important;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out !important;
}

#themeCustomiseForm input[type="text"]:focus,
#themeCustomiseForm select:focus,
#themeCustomiseForm textarea:focus,
input[name^="classic_"]:focus,
select[name^="classic_"]:focus,
textarea[name^="classic_"]:focus {
    border-color: #22c55e !important;
    box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.25) !important;
    outline: none !important;
}

#themeCustomiseForm textarea,
textarea[name^="classic_"] {
    min-height: 120px !important;
    line-height: 1.5 !important;
}

.rasamala-palette-combined {
    min-height: 72px !important;
    font-family: Consolas, "Liberation Mono", Menlo, monospace !important;
}

.rasamala-palette-help {
    max-width: 580px;
    margin-top: 8px;
    padding: 10px 12px;
    border: 1px solid #dce6f0;
    border-radius: 6px;
    background: #f8fbff;
    color: #344054;
    font-size: 12px;
    line-height: 1.55;
}

.rasamala-palette-help code {
    display: inline-block;
    margin-top: 4px;
    padding: 3px 6px;
    border-radius: 4px;
    background: #eef4ff;
    color: #1d4ed8;
    font-size: 12px;
}

#themeCustomiseForm tr,
tr:has(input[name^="classic_"]),
tr:has(select[name^="classic_"]),
tr:has(textarea[name^="classic_"]) {
    border-bottom: 1px solid #f0f0f1 !important;
}

#themeCustomiseForm td,
tr:has(input[name^="classic_"]) td,
tr:has(select[name^="classic_"]) td,
tr:has(textarea[name^="classic_"]) td {
    padding: 14px 10px !important;
    vertical-align: middle !important;
}

.rasamala-tinfo-section-box {
    margin: 18px 0 8px;
    padding: 10px 12px;
    border-left: 4px solid #28a745;
    background: #F7FAF8;
    color: #1f2d25;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
}
.rasamala-tinfo-section-copy {
    min-width: 0;
}
.rasamala-tinfo-section-title {
    display: block;
    font-size: 13px;
    font-weight: 700;
    line-height: 1.25;
}
.rasamala-tinfo-section-desc {
    display: block;
    margin-top: 2px;
    color: #65746B;
    font-size: 11px;
    line-height: 1.35;
}
.rasamala-tinfo-section-toggle {
    flex: 0 0 auto;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    border: 1px solid #c9dfd0;
    border-radius: 999px;
    background: #ffffff;
    color: #256339;
    padding: 5px 10px;
    font-size: 11px;
    font-weight: 700;
    cursor: pointer;
}
.rasamala-tinfo-section-toggle:hover,
.rasamala-tinfo-section-toggle:focus {
    border-color: #28a745;
    background: #ecf8f0;
    outline: none;
}
.rasamala-tinfo-section-row.is-collapsed .rasamala-tinfo-section-box,
.rasamala-tinfo-section-block.is-collapsed .rasamala-tinfo-section-box {
    border-left-color: #9ca3af;
    background: #f4f6f7;
}
.rasamala-theme-viewer-row > td,
.rasamala-theme-viewer-block {
    padding-top: 0 !important;
}
.rasamala-theme-viewer {
    max-width: 920px;
    margin: 0 0 16px;
    border: 1px solid #d9e8de;
    border-radius: 10px;
    background: #ffffff;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
}
.rasamala-theme-viewer-head {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 14px;
    padding: 14px 16px;
    border-bottom: 1px solid #edf2ef;
    background: linear-gradient(135deg, #f7fbf8, #ffffff);
}
.rasamala-theme-viewer-title {
    display: block;
    font-size: 14px;
    font-weight: 800;
    color: #1f2d25;
}
.rasamala-theme-viewer-subtitle {
    display: block;
    margin-top: 3px;
    color: #66736a;
    font-size: 12px;
    line-height: 1.45;
}
.rasamala-theme-viewer-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    justify-content: flex-end;
}
.rasamala-theme-viewer-action {
    border: 1px solid #d7e3dc;
    border-radius: 999px;
    background: #ffffff;
    color: #26543a;
    padding: 6px 10px;
    font-size: 11px;
    font-weight: 700;
    cursor: pointer;
}
.rasamala-theme-viewer-action:hover,
.rasamala-theme-viewer-action:focus {
    border-color: #28a745;
    background: #ecf8f0;
    outline: none;
}
.rasamala-theme-viewer-body {
    display: grid;
    grid-template-columns: minmax(240px, 0.9fr) minmax(260px, 1.1fr);
    gap: 14px;
    padding: 16px;
}
.rasamala-theme-preview {
    border: 1px solid #e5e7eb;
    border-radius: 9px;
    overflow: hidden;
    background: var(--viewer-background, #f8fafc);
    color: var(--viewer-text, #111827);
}
.rasamala-theme-preview-navbar {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 9px 12px;
    background: var(--viewer-primary, #6f5b43);
    color: var(--viewer-on-primary, #ffffff);
    font-size: 12px;
    font-weight: 800;
}
.rasamala-theme-preview-main {
    padding: 16px;
    min-height: 180px;
    background:
        radial-gradient(circle at 18% 10%, var(--viewer-accent-soft, rgba(111, 91, 67, 0.18)), transparent 34%),
        var(--viewer-background, #f8fafc);
}
.rasamala-theme-preview-eyebrow {
    color: var(--viewer-muted, #64748b);
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
}
.rasamala-theme-preview-title {
    margin: 6px 0 10px;
    color: var(--viewer-text, #111827);
    font-size: 20px;
    line-height: 1.16;
    font-weight: 850;
}
.rasamala-theme-preview-search {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 12px;
    padding: 8px 10px;
    border: 1px solid var(--viewer-border, #e5e7eb);
    border-radius: 999px;
    background: var(--viewer-surface, #ffffff);
    color: var(--viewer-muted, #64748b);
    font-size: 12px;
}
.rasamala-theme-preview-search i {
    color: var(--viewer-accent, #c8a24a);
}
.rasamala-theme-preview-card {
    display: grid;
    grid-template-columns: 42px 1fr;
    gap: 10px;
    align-items: center;
    padding: 10px;
    border: 1px solid var(--viewer-border, #e5e7eb);
    border-radius: 8px;
    background: var(--viewer-surface, #ffffff);
}
.rasamala-theme-preview-icon {
    width: 42px;
    height: 42px;
    display: grid;
    place-items: center;
    border-radius: 50%;
    background: var(--viewer-accent-soft, rgba(111, 91, 67, 0.12));
    color: var(--viewer-accent, #c8a24a);
    font-size: 17px;
}
.rasamala-theme-preview-text strong {
    display: block;
    color: var(--viewer-text, #111827);
    font-size: 12px;
}
.rasamala-theme-preview-text span {
    display: block;
    margin-top: 2px;
    color: var(--viewer-muted, #64748b);
    font-size: 11px;
}
.rasamala-theme-viewer-swatches {
    display: grid;
    grid-template-columns: repeat(7, minmax(0, 1fr));
    gap: 6px;
    margin: 12px 16px 0;
}
.rasamala-theme-swatch {
    min-height: 38px;
    border: 1px solid rgba(15, 23, 42, 0.10);
    border-radius: 6px;
    box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.35);
}
.rasamala-theme-viewer-controls {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 12px;
    align-content: start;
}
.rasamala-theme-viewer-control {
    min-width: 0;
}
.rasamala-theme-viewer-control label {
    display: block;
    margin: 0 0 5px;
    color: #36463d;
    font-size: 11px;
    font-weight: 800;
}
.rasamala-theme-viewer-control select {
    width: 100% !important;
    max-width: none !important;
}
.rasamala-theme-viewer-status {
    grid-column: 1 / -1;
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-top: 2px;
}
.rasamala-theme-viewer-chip {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    border: 1px solid #e0e7e3;
    border-radius: 999px;
    background: #f8fbf9;
    color: #405147;
    padding: 5px 8px;
    font-size: 11px;
    font-weight: 700;
}
@media (max-width: 760px) {
    .rasamala-theme-viewer-body {
        grid-template-columns: 1fr;
    }
    .rasamala-theme-viewer-controls {
        grid-template-columns: 1fr;
    }
    .rasamala-theme-viewer-head {
        flex-direction: column;
    }
    .rasamala-theme-viewer-actions {
        justify-content: flex-start;
    }
}
.theme-preset-summary {
    margin: 8px 0 14px;
    padding: 12px 14px;
    border: 1px solid #DCEFE3;
    border-radius: 6px;
    background: #F6FBF8;
    color: #24352B;
}
.theme-preset-summary-title {
    display: block;
    font-size: 13px;
    font-weight: 700;
    margin-bottom: 4px;
}
.theme-preset-summary-desc {
    display: block;
    color: #5F6F66;
    font-size: 12px;
    line-height: 1.45;
}
#navbar-menu-builder-container,
#topic-items-builder-container,
#language-visible-builder-container {
    border: 1px solid #E0E0E0;
    background: #FFFFFF;
    padding: 15px;
    border-radius: 4px;
    margin-top: 5px;
}
.menu-builder-row,
.topic-builder-row {
    gap: 10px;
    display: flex;
    align-items: center;
    margin-bottom: 8px;
    flex-wrap: nowrap;
}
.topic-builder-item {
    border-bottom: 1px solid #F0F0F0;
    margin-bottom: 10px;
    padding-bottom: 10px;
}
.menu-builder-row input,
.topic-builder-row input {
    margin-bottom: 0 !important;
}
.menu-builder-row.is-invalid input,
.topic-builder-row.is-invalid input {
    border-color: #dc3545;
}
.navbar-menu-builder-help,
.topic-items-builder-help,
.language-visible-builder-help {
    color: #666;
    font-size: 12px;
    margin-bottom: 10px;
}
.language-visible-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 10px;
}
.language-visible-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
    gap: 8px;
}
.language-visible-option {
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 0;
    padding: 8px 10px;
    border: 1px solid #E0E0E0;
    border-radius: 6px;
    background: #FAFAFA;
    cursor: pointer;
    font-size: 12px;
}
.language-visible-option input {
    margin: 0 !important;
}
.language-visible-option-code {
    color: #777;
    font-size: 11px;
    margin-left: auto;
}
.topic-icon-preview {
    width: 42px;
    height: 38px;
    flex: 0 0 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #E0E0E0;
    border-radius: 4px;
    background: #F8F9FA;
    color: #495057;
    font-size: 22px;
    line-height: 1;
    cursor: pointer;
    transition: border-color 0.2s ease, background-color 0.2s ease, color 0.2s ease, box-shadow 0.2s ease;
}
.topic-icon-preview:hover,
.topic-builder-item.is-icon-picker-open .topic-icon-preview {
    border-color: #28a745;
    background: #ECF8F0;
    color: #155724;
    box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.12);
}
.topic-icon-preview:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.24);
}
.topic-icon-preview i {
    display: inline-block;
    font-style: normal;
    line-height: 1;
}
.topic-icon-preview img {
    max-width: 28px;
    max-height: 28px;
    object-fit: contain;
}
.topic-icon-input[readonly] {
    background: #F8F9FA;
}
.topic-icon-palette {
    display: none;
    grid-template-columns: repeat(auto-fill, minmax(112px, 1fr));
    gap: 6px;
    margin: 6px 0 0 52px;
    padding: 10px;
    max-height: 360px;
    overflow-y: auto;
    border: 1px solid #E0E0E0;
    border-radius: 4px;
    background: #F8F9FA;
}
.topic-builder-item.is-icon-picker-open .topic-icon-palette {
    display: grid;
}
.topic-icon-choice {
    display: flex;
    align-items: center;
    gap: 7px;
    min-height: 38px;
    padding: 6px 8px;
    border: 1px solid #DDE2E6;
    border-radius: 4px;
    background: #FFFFFF;
    color: #495057;
    font-size: 11px;
    line-height: 1.2;
    text-align: left;
    cursor: pointer;
}
.topic-icon-choice:hover,
.topic-icon-choice.active {
    border-color: #28a745;
    background: #ECF8F0;
    color: #155724;
}
.topic-icon-choice i {
    width: 22px;
    flex: 0 0 22px;
    font-size: 18px;
    text-align: center;
}
.topic-icon-choice-text {
    display: flex;
    flex-direction: column;
    min-width: 0;
}
.topic-icon-choice-label,
.topic-icon-choice-code {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.topic-icon-choice-code {
    color: #6c757d;
    font-size: 10px;
}
.topic-icon-custom-row {
    grid-column: 1 / -1;
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 4px;
    padding-top: 8px;
    border-top: 1px solid #E0E0E0;
}
.topic-icon-custom-label {
    flex: 0 0 auto;
    color: #666;
    font-size: 11px;
    white-space: nowrap;
}
.topic-icon-custom-input {
    min-width: 0;
    margin-bottom: 0 !important;
    font-size: 12px;
}
</style>
<script>
$(document).ready(function() {
    var topicIconOptions = {$icon_options_json};
    var topicAssetBase = {$asset_base_json};
    var languageOptions = {$language_options_json};
    var themePresetDescriptions = {$preset_descriptions_json};
    var themePaletteDefinitions = {$palette_definitions_json};
    var defaultAnnouncementText = {$default_announcement_json};
    var defaultCustomCss = {$default_custom_css_json};
    var defaultVisitorSplitSteps = {$default_visitor_split_steps_json};
    var defaultVisitorInstitutionOptions = {$default_visitor_institution_options_json};
    var quickSettingNames = [
        'classic_theme_color',
        'classic_palette_custom',
        'classic_color_toggle',
        'classic_palette_switcher_show',
        'classic_font_family',
        'classic_back_to_top',
        'classic_floating_info',
        'classic_whatsapp_number',
        'classic_whatsapp_title',
        'classic_whatsapp_desc',
        'classic_whatsapp_categories',
        'classic_navbar_menu',
        'classic_member_area',
        'classic_library_name_position',
        'classic_library_subname',
        'classic_language_visible_codes',
        'classic_mobile_bottom_nav_show',
        'classic_hero_text',
        'classic_hero_text_size',
        'classic_search_size',
        'classic_search_placeholder',
        'classic_search_result_layout',
        'classic_search_panel_style',
        'classic_news_list_layout',
        'classic_announcement_show',
        'classic_announcement_text',
        'classic_announcement_style',
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
        'classic_topic_show',
        'classic_topic_heading_display',
        'classic_topic_items',
        'classic_popular_collection',
        'classic_popular_collection_heading_display',
        'classic_popular_collection_item',
        'classic_new_collection',
        'classic_new_collection_heading_display',
        'classic_new_collection_item',
        'classic_top_reader',
        'classic_top_reader_heading_display',
        'classic_top_reader_item',
        'classic_homepage_section_order',
        'classic_map',
        'classic_map_link',
        'classic_map_height',
        'classic_map_desc',
        'classic_fb_link',
        'classic_twitter_link',
        'classic_youtube_link',
        'classic_instagram_link',
        'classic_tiktok_link',
        'classic_whatsapp_link',
        'classic_telegram_link',
        'classic_linkedin_link',
        'classic_footer_show',
        'classic_footer_about_us',
        'classic_footer_search_show',
        'classic_footer_copyright',
        'classic_hero_background_animation',
        'classic_background_animation_speed',
        'classic_cursor_particles',
        'classic_cursor_custom_icon',
        'classic_prayer_times_show',
        'classic_prayer_times_city',
        'classic_auto_cover_generator',
        'classic_title_chars',
        'classic_parallel_title_separator',
        'classic_show_author_role',
        'classic_detail_label_type',
        'classic_librarian_display_mode',
        'classic_librarian_custom_usernames',
        'visitor_layout_style',
        'visitor_title',
        'visitor_subtitle',
        'visitor_institution_select_label',
        'visitor_institution_options',
        'visitor_theme_toggle',
        'visitor_log_voice',
        'visitor_quote',
        'visitor_split_title',
        'visitor_split_steps'
    ];
    var quickSectionAnchors = [
        'classic_theme_preset',
        'classic_theme_color',
        'classic_navbar_menu',
        'classic_hero_text',
        'classic_home_display_show',
        'classic_ticker_show',
        'classic_home_content_cards_show',
        'classic_map',
        'classic_librarian_display_mode',
        'classic_footer_show',
        'classic_title_chars'
    ];

    function fillEmptyTextarea(name, value) {
        var field = $('textarea[name="' + name + '"]');
        if (field.length && field.val().trim() === '') {
            field.val(value);
        }
    }

    fillEmptyTextarea('classic_announcement_text', defaultAnnouncementText);
    fillEmptyTextarea('classic_custom_css', defaultCustomCss);

    var visitorSplitStepsField = $('textarea[name="visitor_split_steps"]');
    if (visitorSplitStepsField.length) {
        var visitorSplitStepsValue = visitorSplitStepsField.val().trim();
        if (visitorSplitStepsValue === '' || /psb\.feb\.ui\.ac\.id|Login Web PSB/i.test(visitorSplitStepsValue)) {
            visitorSplitStepsField.val(defaultVisitorSplitSteps);
        }
    }

    fillEmptyTextarea('visitor_institution_options', defaultVisitorInstitutionOptions);

    function settingField(name) {
        return $('[name="' + name + '"]');
    }

    function settingRow(name) {
        return settingField(name).closest('.form-group, tr, .row');
    }

    function builderContainerForField(name) {
        var map = {
            classic_navbar_menu: '#navbar-menu-builder-container',
            classic_topic_items: '#topic-items-builder-container',
            classic_language_visible_codes: '#language-visible-builder-container'
        };
        return map[name] ? $(map[name]) : $();
    }

    function forceBuilderSettingVisible(field) {
        var row = field.closest('.form-group, tr, .row');
        if (row.length) {
            row.show();
            row.removeAttr('data-rasamala-section-hidden');
        }

        var container = builderContainerForField(field.attr('name') || '');
        if (container.length) {
            container.show();
            container.closest('.form-group, tr, .row').show().removeAttr('data-rasamala-section-hidden');
        }
    }

    function syncBuilderSettingVisibility() {
        var preset = settingValue('classic_theme_preset') || 'simple_homepage';
        var isCustomPreset = preset === 'custom';
        var configs = [
            {name: 'classic_navbar_menu', selector: '#navbar-menu-builder-container', visible: true},
            {name: 'classic_language_visible_codes', selector: '#language-visible-builder-container', visible: true},
            {name: 'classic_topic_items', selector: '#topic-items-builder-container', visible: isCustomPreset || settingValue('classic_topic_show') === '1'}
        ];

        configs.forEach(function(config) {
            var field = settingField(config.name);
            var row = settingRow(config.name);
            var container = $(config.selector);
            if (!field.length || !container.length) return;

            var visible = !!config.visible && (isCustomPreset || isQuickSetting(config.name));
            field.hide();
            row.toggle(visible).removeAttr('data-rasamala-section-hidden');
            container.toggle(visible);
        });
    }

    function settingValue(name) {
        var field = settingField(name);
        return field.length ? String(field.val()) : '';
    }

    function settingLabel(name, fallback) {
        var field = settingField(name);
        var option = field.find('option:selected');
        if (option.length) {
            return option.text();
        }
        return fallback || settingValue(name);
    }

    function normalizeHexColor(hex, fallback) {
        var color = String(hex || '').replace('#', '');
        return /^[0-9a-f]{6}$/i.test(color) ? '#' + color.toLowerCase() : fallback;
    }

    function colorLuminance(hex) {
        var color = normalizeHexColor(hex, '#ffffff').replace('#', '');
        var channels = [0, 1, 2].map(function(index) {
            var value = parseInt(color.slice(index * 2, index * 2 + 2), 16) / 255;
            return value <= 0.03928 ? value / 12.92 : Math.pow((value + 0.055) / 1.055, 2.4);
        });
        return (0.2126 * channels[0]) + (0.7152 * channels[1]) + (0.0722 * channels[2]);
    }

    function contrastRatio(background, foreground) {
        var backgroundLuminance = colorLuminance(background);
        var foregroundLuminance = colorLuminance(foreground);
        var lighter = Math.max(backgroundLuminance, foregroundLuminance);
        var darker = Math.min(backgroundLuminance, foregroundLuminance);
        return (lighter + 0.05) / (darker + 0.05);
    }

    function readableTextColor(hex) {
        return contrastRatio(hex, '#111827') >= contrastRatio(hex, '#ffffff') ? '#111827' : '#ffffff';
    }

    function accessibleTextColor(background, preferred, fallback) {
        var candidates = [
            normalizeHexColor(preferred, ''),
            normalizeHexColor(fallback, ''),
            '#111827',
            '#ffffff'
        ];
        var seen = {};
        var bestColor = '#111827';
        var bestRatio = 0;

        candidates.forEach(function(candidate) {
            if (!candidate || seen[candidate]) return;
            seen[candidate] = true;
            var ratio = contrastRatio(background, candidate);
            if (ratio >= 4.5 && bestRatio < 4.5) {
                bestColor = candidate;
                bestRatio = ratio;
                return;
            }
            if (bestRatio < 4.5 && ratio > bestRatio) {
                bestColor = candidate;
                bestRatio = ratio;
            }
        });

        return bestColor;
    }

    function hydratePreviewPalette(palette) {
        palette = palette || {};
        var textCandidate = normalizeHexColor(palette.text, '#2f2a24');
        var mutedCandidate = normalizeHexColor(palette.muted, '#7a7167');
        palette.primary = normalizeHexColor(palette.primary, '#6f5b43');
        palette.secondary = normalizeHexColor(palette.secondary, '#a58a63');
        palette.accent = normalizeHexColor(palette.accent, '#c8a24a');
        palette.background = normalizeHexColor(palette.background, '#f4f1ec');
        palette.surface = normalizeHexColor(palette.surface, '#ffffff');
        palette.text = accessibleTextColor(palette.background, textCandidate);
        palette.muted = accessibleTextColor(palette.background, mutedCandidate, palette.text);
        palette.onSurface = accessibleTextColor(palette.surface, textCandidate, palette.text);
        palette.mutedOnSurface = accessibleTextColor(palette.surface, mutedCandidate, palette.onSurface);
        return palette;
    }

    function hexToRgb(hex) {
        hex = String(hex || '').replace('#', '');
        if (!/^[0-9a-f]{6}$/i.test(hex)) return '111, 91, 67';
        return parseInt(hex.slice(0, 2), 16) + ', ' + parseInt(hex.slice(2, 4), 16) + ', ' + parseInt(hex.slice(4, 6), 16);
    }

    function parseCustomPalettePreview(value) {
        var base = themePaletteDefinitions.minimalwhite || themePaletteDefinitions.warmgray || {};
        var segment = String(value || '').split('|')[0] || '';
        var parts = segment.split(/[;\\r\\n]+/).map(function(item) {
            return item.trim();
        }).filter(function(item) {
            return /^#?[0-9a-f]{6}$/i.test(item);
        }).slice(0, 7);
        var keys = ['primary', 'secondary', 'accent', 'background', 'surface', 'text', 'muted'];
        var palette = {label: 'Custom Palette'};
        keys.forEach(function(key, index) {
            var fallback = base[key] || (key === 'surface' ? '#ffffff' : '#111827');
            palette[key] = parts[index] ? '#' + parts[index].replace('#', '').toLowerCase() : fallback;
        });
        return hydratePreviewPalette(palette);
    }

    function currentThemePalette() {
        var key = settingValue('classic_theme_color') || 'warmgray';
        if (key === 'custom') {
            return parseCustomPalettePreview(settingValue('classic_palette_custom'));
        }
        return hydratePreviewPalette(themePaletteDefinitions[key] || themePaletteDefinitions.warmgray || {
            label: 'Warm Gray',
            primary: '#6f5b43',
            secondary: '#a58a63',
            accent: '#c8a24a',
            background: '#f4f1ec',
            surface: '#ffffff',
            text: '#2f2a24',
            muted: '#7a7167'
        });
    }

    var sectionCollapsedState = {};

    function sectionControlledRows(sectionRow) {
        var rows = $();
        var next = sectionRow.next();
        while (next.length && !next.hasClass('rasamala-tinfo-section-row') && !next.hasClass('rasamala-tinfo-section-block')) {
            rows = rows.add(next);
            next = next.next();
        }
        return rows.not('.rasamala-theme-viewer-row, .rasamala-theme-viewer-block');
    }

    function clearSectionCollapseMarks() {
        $('[data-rasamala-section-hidden="1"]').each(function() {
            $(this).removeAttr('data-rasamala-section-hidden').show();
        });
    }

    function applyTinfoSectionCollapse() {
        $('.rasamala-tinfo-section-row, .rasamala-tinfo-section-block').each(function() {
            var section = $(this);
            var anchor = section.attr('data-rasamala-section-anchor') || '';
            var isCollapsed = !!sectionCollapsedState[anchor];
            var button = section.find('.rasamala-tinfo-section-toggle');
            section.toggleClass('is-collapsed', isCollapsed);
            button.attr('aria-expanded', isCollapsed ? 'false' : 'true');
            button.find('.rasamala-tinfo-section-toggle-text').text(isCollapsed ? 'Buka' : 'Tutup');
            button.find('i').attr('class', isCollapsed ? 'fas fa-chevron-down' : 'fas fa-chevron-up');
            if (isCollapsed) {
                sectionControlledRows(section).filter(':visible').attr('data-rasamala-section-hidden', '1').hide();
            }
        });
    }

    function setAllTinfoSectionsCollapsed(collapsed) {
        $('.rasamala-tinfo-section-row, .rasamala-tinfo-section-block').each(function() {
            var anchor = $(this).attr('data-rasamala-section-anchor') || '';
            if (anchor !== '') {
                sectionCollapsedState[anchor] = collapsed;
            }
        });
        clearSectionCollapseMarks();
        syncConditionalSettings();
    }

    function insertTinfoSection(row, title, description, anchor) {
        if (!row.length) return;
        var sectionContent = $('<div class="rasamala-tinfo-section-box"></div>')
            .append(
                $('<span class="rasamala-tinfo-section-copy"></span>')
                    .append($('<span class="rasamala-tinfo-section-title"></span>').text(title))
                    .append($('<span class="rasamala-tinfo-section-desc"></span>').text(description))
            )
            .append(
                $('<button type="button" class="rasamala-tinfo-section-toggle" aria-expanded="true"></button>')
                    .attr('data-rasamala-section-toggle', anchor || '')
                    .append($('<i class="fas fa-chevron-up" aria-hidden="true"></i>'))
                    .append($('<span class="rasamala-tinfo-section-toggle-text"></span>').text('Tutup'))
            );

        if (row.is('tr')) {
            var columns = Math.max(row.children('td, th').length, 1);
            row.before($('<tr class="rasamala-tinfo-section-row"></tr>').attr('data-rasamala-section-anchor', anchor || '').append($('<td></td>').attr('colspan', columns).append(sectionContent)));
        } else {
            row.before($('<div class="rasamala-tinfo-section-block"></div>').attr('data-rasamala-section-anchor', anchor || '').append(sectionContent));
        }
    }

    function insertTinfoSections() {
        if ($('.rasamala-tinfo-section-row, .rasamala-tinfo-section-block').length) return;

        [
            ['classic_theme_preset', 'Preset tema', 'Pilih tampilan keseluruhan. Mode Custom akan membuka semua pengaturan detail.'],
            ['classic_theme_color', 'Tampilan dasar', 'Palette warna, font, tombol bantu, breadcrumbs, dan CSS tambahan.'],
            ['classic_navbar_menu', 'Navbar dan bahasa', 'Menu utama, area anggota, bahasa yang ditampilkan, dan navigasi mobile.'],
            ['classic_hero_text', 'Search, hero, dan berita', 'Teks pencarian, layout hasil pencarian, tampilan news list, animasi, cursor, dan banner pengumuman.'],
            ['classic_home_display_show', 'Info Area Search (Hero Info)', 'Konten singkat pendukung pencarian di bawah kolom pencarian (dapat berupa static badge, fading, atau ticker).'],
            ['classic_ticker_show', 'Floating Bottom Info Bar', 'Teks berjalan melayang di bagian kaki layar (viewport bottom) untuk info/pengumuman penting.'],
            ['classic_home_content_cards_show', 'Beranda', '3 latest content, topic, koleksi populer, koleksi terbaru, top reader, dan urutan section.'],
            ['classic_map', 'Peta dan sosial media', 'Atur peta lokasi, deskripsi kontak, dan link sosial media dalam satu pilihan.'],
            ['classic_footer_show', 'Footer dan waktu sholat', 'Konten footer, search footer, copyright, jadwal sholat, dan reminder.'],
            ['classic_librarian_display_mode', 'Halaman pustakawan', 'Pilih siapa saja yang tampil di index.php?p=librarian.'],
            ['classic_title_chars', 'Teks dan halaman pengunjung', 'Batas panjang judul, pemisah judul paralel, dan visitor page.']
        ].forEach(function(section) {
            insertTinfoSection(settingRow(section[0]), section[1], section[2], section[0]);
        });
    }

    function setRowsVisible(names, visible) {
        names.forEach(function(name) {
            var row = settingRow(name);
            if (row.length) row.toggle(!!visible);
        });
    }

    function isShown(name) {
        var value = settingValue(name);
        return value !== '' && value !== '0' && value !== 'hide' && value !== 'none';
    }

    function isQuickSetting(name) {
        return quickSettingNames.indexOf(name) !== -1;
    }

    function enhanceCustomPaletteFields() {
        var field = settingField('classic_palette_custom');
        if (!field.length || field.data('rasamalaPaletteReady')) return;
        var tutorial = $('<div class="rasamala-palette-help"></div>')
            .append($('<strong></strong>').text('Format: '))
            .append(document.createTextNode('Light palette | Dark palette'))
            .append($('<br>'))
            .append(document.createTextNode('Isi setiap palette dengan urutan: Primary; Secondary; Accent; Background; Surface; Text; Muted. Jika bagian setelah | dikosongkan, dark mode memakai fallback otomatis.'))
            .append($('<br>'))
            .append(document.createTextNode('Primary = warna utama/navbar/button. Secondary = warna pendamping. Accent = highlight/icon/aksen. Background = latar halaman. Surface = card/panel. Text = teks utama. Muted = teks sekunder/border.'))
            .append($('<br>'))
            .append(document.createTextNode('Untuk hasil aman, pastikan Text dan Muted punya kontras minimal WCAG AA 4.5:1 terhadap Background dan Surface. Sistem akan menormalisasi warna teks yang terlalu mirip, tetapi palette terbaik tetap memakai Background/Surface dalam keluarga terang yang sama untuk light mode dan keluarga gelap yang sama untuk dark mode.'))
            .append($('<br>'))
            .append($('<code></code>').text('Contoh: #0B4F54; #5C8374; #F2994A; #F4F6F8; #FFFFFF; #1C1E21; #B0B7BD | #1A2E40; #B38F4D; #D9534F; #101318; #161A22; #F4F6F8; #B6BEC8'));

        field
            .attr('placeholder', '#0B4F54; #5C8374; #F2994A; #F4F6F8; #FFFFFF; #1C1E21; #B0B7BD | #1A2E40; #B38F4D; #D9534F; #101318; #161A22; #F4F6F8; #B6BEC8')
            .addClass('rasamala-palette-input rasamala-palette-combined')
            .data('rasamalaPaletteReady', true);

        field.after(tutorial);
    }

    var themeViewerControls = [
        ['classic_theme_color', 'Palette Warna', 'fas fa-paint-brush'],
        ['classic_font_family', 'Font Tema', 'fas fa-font'],
        ['classic_hero_background_animation', 'Animasi Background', 'fas fa-magic'],
        ['classic_background_animation_speed', 'Kecepatan Animasi', 'fas fa-tachometer-alt'],
        ['classic_cursor_particles', 'Partikel Cursor', 'fas fa-star'],
        ['classic_cursor_custom_icon', 'Ikon Cursor', 'fas fa-mouse-pointer']
    ];

    function buildThemeViewerSelect(name) {
        var original = settingField(name);
        var select = $('<select class="rasamala-theme-viewer-select"></select>').attr('data-theme-viewer-target', name);
        original.find('option').each(function() {
            select.append($('<option></option>').attr('value', $(this).attr('value')).text($(this).text()));
        });
        select.val(original.val());
        return select;
    }

    function ensureThemeViewer() {
        return; // Disable theme viewer injection on the admin side

        var controls = $('<div class="rasamala-theme-viewer-controls"></div>');
        themeViewerControls.forEach(function(config) {
            var name = config[0];
            var label = config[1];
            var icon = config[2];
            if (!settingField(name).length) return;
            controls.append(
                $('<div class="rasamala-theme-viewer-control"></div>')
                    .append($('<label></label>').append($('<i></i>').attr('class', icon).attr('aria-hidden', 'true')).append(' ' + label))
                    .append(buildThemeViewerSelect(name))
            );
        });
        controls.append($('<div class="rasamala-theme-viewer-status"></div>'));

        var viewer = $('<div id="rasamala-theme-viewer" class="rasamala-theme-viewer"></div>')
            .append(
                $('<div class="rasamala-theme-viewer-head"></div>')
                    .append(
                        $('<span></span>')
                            .append($('<span class="rasamala-theme-viewer-title"></span>').text('Theme Viewer'))
                            .append($('<span class="rasamala-theme-viewer-subtitle"></span>').text('Ringkasan visual dan shortcut pengaturan utama: warna, font, animasi background, cursor, serta buka/tutup section tinfo.'))
                    )
                    .append(
                        $('<div class="rasamala-theme-viewer-actions"></div>')
                            .append($('<button type="button" class="rasamala-theme-viewer-action" id="rasamala-tinfo-show-all-sections"><i class="fas fa-eye" aria-hidden="true"></i> Tampilkan semua section</button>'))
                            .append($('<button type="button" class="rasamala-theme-viewer-action" id="rasamala-tinfo-hide-all-sections"><i class="fas fa-eye-slash" aria-hidden="true"></i> Tutup semua section</button>'))
                    )
            )
            .append(
                $('<div class="rasamala-theme-viewer-body"></div>')
                    .append(
                        $('<div></div>')
                            .append(
                                $('<div class="rasamala-theme-preview"></div>')
                                    .append($('<div class="rasamala-theme-preview-navbar"><i class="fas fa-book-open" aria-hidden="true"></i><span>Rasamala OPAC</span></div>'))
                                    .append(
                                        $('<div class="rasamala-theme-preview-main"></div>')
                                            .append($('<span class="rasamala-theme-preview-eyebrow"></span>').text('Preview'))
                                            .append($('<div class="rasamala-theme-preview-title"></div>').text('Search Library Collection'))
                                            .append($('<div class="rasamala-theme-preview-search"></div>').append($('<span></span>').text('Enter keyword to search collection...')).append($('<i class="fas fa-search" aria-hidden="true"></i>')))
                                            .append(
                                                $('<div class="rasamala-theme-preview-card"></div>')
                                                    .append($('<span class="rasamala-theme-preview-icon"><i class="fas fa-book" aria-hidden="true"></i></span>'))
                                                    .append($('<span class="rasamala-theme-preview-text"></span>').append($('<strong></strong>').text('Popular Collection')).append($('<span></span>').text('Surface, accent, dan typography aktif.')))
                                            )
                                    )
                            )
                            .append($('<div class="rasamala-theme-viewer-swatches"></div>'))
                    )
                    .append(controls)
            );

        if (row.is('tr')) {
            var columns = Math.max(row.children('td, th').length, 1);
            row.after($('<tr class="rasamala-theme-viewer-row"></tr>').append($('<td></td>').attr('colspan', columns).append(viewer)));
        } else {
            row.after($('<div class="rasamala-theme-viewer-block"></div>').append(viewer));
        }
    }

    function syncThemeViewer() {
        ensureThemeViewer();
        var viewer = $('#rasamala-theme-viewer');
        if (!viewer.length) return;

        var palette = currentThemePalette();
        var primary = palette.primary || '#6f5b43';
        var accent = palette.accent || primary;
        var surface = palette.surface || '#ffffff';
        var background = palette.background || '#f4f1ec';
        var text = palette.text || '#2f2a24';
        var muted = palette.muted || '#7a7167';
        var rgb = hexToRgb(accent);
        viewer.css({
            '--viewer-primary': primary,
            '--viewer-on-primary': readableTextColor(primary),
            '--viewer-accent': accent,
            '--viewer-accent-soft': 'rgba(' + rgb + ', 0.14)',
            '--viewer-background': background,
            '--viewer-surface': surface,
            '--viewer-text': text,
            '--viewer-muted': muted,
            '--viewer-border': 'rgba(' + rgb + ', 0.22)'
        });

        var fontStacks = {
            system: 'Outfit, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif',
            inter: 'Inter, system-ui, sans-serif',
            roboto: 'Roboto, system-ui, sans-serif',
            poppins: 'Poppins, system-ui, sans-serif',
            playfair: '"Playfair Display", Georgia, serif'
        };
        viewer.find('.rasamala-theme-preview').css('font-family', fontStacks[settingValue('classic_font_family')] || fontStacks.system);

        viewer.find('.rasamala-theme-viewer-select').each(function() {
            var target = $(this).attr('data-theme-viewer-target');
            $(this).val(settingValue(target));
        });
        viewer.find('[data-theme-viewer-target="classic_background_animation_speed"]').prop('disabled', settingValue('classic_hero_background_animation') === 'none');

        var swatches = viewer.find('.rasamala-theme-viewer-swatches').empty();
        [
            ['Primary', primary],
            ['Secondary', palette.secondary || primary],
            ['Accent', accent],
            ['Background', background],
            ['Surface', surface],
            ['Text', text],
            ['Muted', muted]
        ].forEach(function(item) {
            swatches.append($('<span class="rasamala-theme-swatch"></span>').attr('title', item[0] + ': ' + item[1]).css('background-color', item[1]));
        });

        var status = viewer.find('.rasamala-theme-viewer-status').empty();
        [
            ['Palette', settingLabel('classic_theme_color', palette.label)],
            ['Font', settingLabel('classic_font_family')],
            ['Animasi', settingLabel('classic_hero_background_animation')],
            ['Speed', settingValue('classic_hero_background_animation') === 'none' ? 'Off' : settingLabel('classic_background_animation_speed')],
            ['Partikel', settingLabel('classic_cursor_particles')],
            ['Cursor', settingLabel('classic_cursor_custom_icon')]
        ].forEach(function(item) {
            status.append($('<span class="rasamala-theme-viewer-chip"></span>').append($('<strong></strong>').text(item[0] + ':')).append(document.createTextNode(' ' + item[1])));
        });
    }

    function ensureThemePresetSummary() {
        var row = settingRow('classic_theme_preset');
        if (!row.length || $('#theme-preset-summary').length) return;
        var summary = $('<div id="theme-preset-summary" class="theme-preset-summary"></div>')
            .append($('<span class="theme-preset-summary-title"></span>'))
            .append($('<span class="theme-preset-summary-desc"></span>'));

        if (row.is('tr')) {
            var columns = Math.max(row.children('td, th').length, 1);
            row.after($('<tr class="theme-preset-summary-row"></tr>').append($('<td></td>').attr('colspan', columns).append(summary)));
        } else {
            row.after(summary);
        }
    }

    function syncThemePresetSummary() {
        ensureThemePresetSummary();
        var preset = settingValue('classic_theme_preset') || 'simple_homepage';
        var info = themePresetDescriptions[preset] || themePresetDescriptions.simple_homepage || {};
        $('#theme-preset-summary .theme-preset-summary-title').text(info.title || preset);
        $('#theme-preset-summary .theme-preset-summary-desc').text(info.description || '');
    }

    function syncThemePresetVisibility() {
        var preset = settingValue('classic_theme_preset') || 'simple_homepage';
        var isCustomPreset = preset === 'custom';
        var presetRow = settingRow('classic_theme_preset');
        var rows = $();

        $('select[name], input[name], textarea[name]').each(function() {
            var name = this.name || '';
            if (name === 'classic_theme_preset') return;
            if (name === 'responsive' || name.indexOf('classic_') === 0) {
                rows = rows.add($(this).closest('.form-group, tr, .row'));
            }
        });

        rows.not(presetRow).each(function() {
            var row = $(this);
            var visible = isCustomPreset;
            row.find('select[name], input[name], textarea[name]').each(function() {
                if (isQuickSetting(this.name || '')) {
                    visible = true;
                }
            });
            row.toggle(visible);
        });
        $('.rasamala-tinfo-section-row, .rasamala-tinfo-section-block').each(function() {
            var anchor = $(this).attr('data-rasamala-section-anchor') || '';
            $(this).toggle(isCustomPreset || quickSectionAnchors.indexOf(anchor) !== -1);
        });
        syncBuilderSettingVisibility();
    }

    function syncConditionalSettings() {
        clearSectionCollapseMarks();
        syncThemePresetSummary();
        syncThemePresetVisibility();
        var isCustomPreset = settingValue('classic_theme_preset') === 'custom';
        var customPaletteOn = settingValue('classic_theme_color') === 'custom';

        setRowsVisible(['classic_palette_custom'], customPaletteOn);

        var animationOn = settingValue('classic_hero_background_animation') !== 'none';
        setRowsVisible(['classic_background_animation_speed'], animationOn);

        var autoCoverField = settingField('classic_auto_cover_generator');
        if (autoCoverField.val() === '1') {
            autoCoverField.val('empty_missing');
        } else if (autoCoverField.val() === '0') {
            autoCoverField.val('none');
        }

        var prayerOn = settingValue('classic_prayer_times_show') !== 'hide' && settingValue('classic_prayer_times_show') !== '0';
        setRowsVisible(['classic_prayer_times_city'], prayerOn);

        setRowsVisible(['classic_librarian_custom_usernames'], settingValue('classic_librarian_display_mode') === 'custom');

        var homeContentCardsOn = settingValue('classic_home_content_cards_show') === '1';
        var homeContentCardsSource = settingValue('classic_home_content_cards_source') || 'news';
        setRowsVisible(['classic_home_content_cards_source'], homeContentCardsOn);
        setRowsVisible([
            'classic_home_content_path_1',
            'classic_home_content_path_2',
            'classic_home_content_path_3'
        ], homeContentCardsOn && homeContentCardsSource === 'custom');

        var visitorSplitOn = settingValue('visitor_layout_style') === 'split';
        setRowsVisible([
            'visitor_institution_select_label',
            'visitor_institution_options',
            'visitor_split_title',
            'visitor_split_steps'
        ], visitorSplitOn);

        var homeDisplayOn = isShown('classic_home_display_show');
        var homeDisplaySource = settingValue('classic_home_display_source');
        setRowsVisible(['classic_home_display_source', 'classic_home_display_style', 'classic_home_item_limit', 'classic_home_char_limit'], homeDisplayOn);
        setRowsVisible(['classic_home_display_custom_text'], homeDisplayOn && homeDisplaySource === 'custom_home');
        setRowsVisible(['classic_home_display_content_filter', 'classic_home_display_content_detail'], homeDisplayOn && homeDisplaySource === 'content');
        setRowsVisible(['classic_home_display_biblio_filter'], homeDisplayOn && homeDisplaySource === 'biblio');

        var tickerOn = isShown('classic_ticker_show');
        var tickerSource = settingValue('classic_ticker_source');
        setRowsVisible(['classic_ticker_source', 'classic_ticker_speed', 'classic_ticker_item_limit', 'classic_ticker_char_limit'], tickerOn);
        setRowsVisible(['classic_ticker_custom_text'], tickerOn && tickerSource === 'custom_ticker');
        setRowsVisible(['classic_ticker_content_filter', 'classic_ticker_content_detail'], tickerOn && tickerSource === 'content');
        setRowsVisible(['classic_ticker_biblio_filter'], tickerOn && tickerSource === 'biblio');

        var mapField = settingField('classic_map');
        if (mapField.val() === '1') {
            mapField.val('all');
        } else if (mapField.val() === '0') {
            mapField.val('hide_all');
        }

        var announcementOn = settingValue('classic_announcement_show') === '1';
        setRowsVisible(['classic_announcement_text', 'classic_announcement_style'], announcementOn);

        var topicOn = settingValue('classic_topic_show') === '1';
        setRowsVisible(['classic_topic_heading_display', 'classic_topic_items'], topicOn);
        syncBuilderSettingVisibility();

        var popularOn = settingValue('classic_popular_collection') === '1';
        setRowsVisible(['classic_popular_collection_heading_display', 'classic_popular_collection_item'], popularOn);

        var newCollectionOn = settingValue('classic_new_collection') === '1';
        setRowsVisible(['classic_new_collection_heading_display', 'classic_new_collection_item'], newCollectionOn);

        var topReaderOn = settingValue('classic_top_reader') === '1';
        setRowsVisible(['classic_top_reader_heading_display', 'classic_top_reader_item'], topReaderOn);

        var floatingInfoVal = settingValue('classic_floating_info');
        setRowsVisible([
            'classic_whatsapp_number',
            'classic_whatsapp_title',
            'classic_service_hours',
            'classic_whatsapp_desc',
            'classic_whatsapp_categories'
        ], floatingInfoVal === 'whatsapp');

        var mapMode = settingValue('classic_map');
        var mapVisible = ['1', 'all', 'hide_social'].indexOf(mapMode) !== -1;
        var socialVisible = ['1', 'all', 'hide_map'].indexOf(mapMode) !== -1;
        var mapSectionVisible = mapVisible || socialVisible;
        setRowsVisible(['classic_map_link', 'classic_map_height'], mapVisible);
        setRowsVisible(['classic_map_desc'], mapSectionVisible);
        setRowsVisible([
            'classic_fb_link',
            'classic_twitter_link',
            'classic_youtube_link',
            'classic_instagram_link',
            'classic_tiktok_link',
            'classic_whatsapp_link',
            'classic_telegram_link',
            'classic_linkedin_link'
        ], socialVisible);

        var footerOn = settingValue('classic_footer_show') === '1';
        setRowsVisible(['classic_footer_about_us', 'classic_footer_search_show', 'classic_footer_copyright'], footerOn);

        syncBuilderSettingVisibility();
        syncThemeViewer();
        applyTinfoSectionCollapse();
    }

    insertTinfoSections();
    enhanceCustomPaletteFields();
    ensureThemeViewer();
    syncConditionalSettings();
    $(document).on('change input', [
        'select[name="classic_theme_preset"]',
        'select[name="classic_theme_color"]',
        'textarea[name="classic_palette_custom"]',
        'select[name="classic_font_family"]',
        'select[name="classic_hero_background_animation"]',
        'select[name="classic_background_animation_speed"]',
        'select[name="classic_cursor_particles"]',
        'select[name="classic_cursor_custom_icon"]',
        'select[name="classic_announcement_show"]',
        'select[name="classic_home_display_show"]',
        'select[name="classic_home_display_source"]',
        'select[name="classic_home_content_cards_show"]',
        'select[name="classic_home_content_cards_source"]',
        'select[name="classic_ticker_show"]',
        'select[name="classic_ticker_source"]',
        'select[name="classic_topic_show"]',
        'select[name="classic_popular_collection"]',
        'select[name="classic_new_collection"]',
        'select[name="classic_top_reader"]',
        'select[name="classic_map"]',
        'select[name="classic_footer_show"]',
        'select[name="classic_prayer_times_show"]',
        'select[name="classic_librarian_display_mode"]',
        'select[name="classic_floating_info"]',
        'select[name="visitor_layout_style"]'
    ].join(','), syncConditionalSettings);

    $(document).on('change', '.rasamala-theme-viewer-select', function() {
        var target = $(this).attr('data-theme-viewer-target');
        settingField(target).val($(this).val()).trigger('change');
    });

    $(document).on('click', '.rasamala-tinfo-section-toggle', function() {
        var anchor = $(this).attr('data-rasamala-section-toggle') || '';
        sectionCollapsedState[anchor] = !sectionCollapsedState[anchor];
        clearSectionCollapseMarks();
        syncConditionalSettings();
    });

    $(document).on('click', '#rasamala-tinfo-show-all-sections', function() {
        setAllTinfoSectionsCollapsed(false);
    });

    $(document).on('click', '#rasamala-tinfo-hide-all-sections', function() {
        setAllTinfoSectionsCollapsed(true);
    });

    function parseLanguageCodes(value) {
        return String(value || '').split(/[,;\\s]+/).map(function(item) {
            return item.trim().toLowerCase();
        }).filter(Boolean);
    }

    function syncLanguageVisibleTextarea(container, textarea) {
        var checked = [];
        container.find('.language-visible-checkbox:checked').each(function() {
            checked.push($(this).val());
        });
        textarea.val(checked.join(', ')).trigger('change');
    }

    var languageTextarea = $('textarea[name="classic_language_visible_codes"]');
    if (languageTextarea.length && languageOptions.length) {
        languageTextarea.hide();
        var selectedLanguageCodes = parseLanguageCodes(languageTextarea.val());
        var languageContainer = $('<div id="language-visible-builder-container" class="mt-2"></div>');
        languageContainer.append($('<div class="language-visible-builder-help"></div>').text('Centang bahasa yang ingin ditampilkan di navbar dan menu bahasa mobile. Jika tidak ada yang dicentang, pilihan bahasa akan disembunyikan.'));
        var languageActions = $('<div class="language-visible-actions"></div>');
        var languageGrid = $('<div class="language-visible-grid"></div>');
        languageActions
            .append($('<button type="button" class="btn btn-light btn-sm" id="language-select-all-btn">Pilih semua</button>'))
            .append($('<button type="button" class="btn btn-light btn-sm" id="language-select-id-en-btn">Indonesia & English</button>'))
            .append($('<button type="button" class="btn btn-light btn-sm" id="language-clear-btn">Sembunyikan semua</button>'));
        languageContainer.append(languageActions).append(languageGrid);
        languageTextarea.after(languageContainer);
        forceBuilderSettingVisible(languageTextarea);

        languageOptions.forEach(function(language) {
            var code = String(language.code || '').toLowerCase();
            var isChecked = selectedLanguageCodes.length > 0 && selectedLanguageCodes.indexOf(code) !== -1;
            var checkbox = $('<input type="checkbox" class="language-visible-checkbox" />').val(code).prop('checked', isChecked);
            var option = $('<label class="language-visible-option"></label>')
                .append(checkbox)
                .append(language.flag ? $('<span></span>').addClass('flag-icon flag-icon-' + language.flag + ' flag-icon-rounded') : $('<span></span>'))
                .append($('<span></span>').text(language.name || language.code))
                .append($('<span class="language-visible-option-code"></span>').text(code));
            languageGrid.append(option);
        });

        $(document).on('change', '.language-visible-checkbox', function() {
            syncLanguageVisibleTextarea(languageContainer, languageTextarea);
        });
        $(document).on('click', '#language-select-all-btn', function() {
            languageContainer.find('.language-visible-checkbox').prop('checked', true);
            syncLanguageVisibleTextarea(languageContainer, languageTextarea);
        });
        $(document).on('click', '#language-select-id-en-btn', function() {
            languageContainer.find('.language-visible-checkbox').each(function() {
                var code = $(this).val();
                $(this).prop('checked', ['id_id', 'id', 'en_us', 'en_gb', 'en'].indexOf(code) !== -1);
            });
            syncLanguageVisibleTextarea(languageContainer, languageTextarea);
        });
        $(document).on('click', '#language-clear-btn', function() {
            languageContainer.find('.language-visible-checkbox').prop('checked', false);
            languageTextarea.val('').trigger('change');
        });
    }

    function isSafeBuilderUrl(url) {
        url = String(url || '').trim();
        if (url === '' || /[\\x00-\\x1f\\x7f|;]/.test(url)) return false;
        if (url.charAt(0) === '#') return true;
        if (url.indexOf('//') === 0) return false;
        try {
            var parsed = new URL(url, window.location.origin);
            var rawScheme = url.match(/^([a-z][a-z0-9+.-]*):/i);
            if (rawScheme) {
                return ['http:', 'https:', 'mailto:', 'tel:'].indexOf(parsed.protocol) !== -1;
            }
            return true;
        } catch (e) {
            return false;
        }
    }

    function cleanBuilderText(text) {
        return String(text || '').replace(/[|;\\r\\n]/g, ' ').replace(/\\s+/g, ' ').trim();
    }

    function cleanTopicIcon(icon) {
        return String(icon || '').replace(/[|;\\r\\n]/g, ' ').replace(/\\s+/g, ' ').trim();
    }

    function isFontAwesomeIcon(icon) {
        return /^(fa[brs]?|fas|far|fab)\\s+[a-z0-9 _-]+$/i.test(cleanTopicIcon(icon));
    }

    function isImageIcon(icon) {
        icon = cleanTopicIcon(icon);
        return /^https:\\/\\//i.test(icon) || /\\.(png|jpe?g|gif|webp|svg)$/i.test(icon);
    }

    function iconSrc(icon) {
        icon = cleanTopicIcon(icon).replace(/^\\/+/, '');
        if (/^https:\\/\\//i.test(icon)) return icon;
        return topicAssetBase + icon;
    }

    function hasIconOption(icon) {
        icon = cleanTopicIcon(icon);
        return topicIconOptions.some(function(option) {
            return option.value === icon;
        });
    }

	    function updateIconPreview(row) {
	        var icon = cleanTopicIcon(row.find('.topic-icon-input').val());
	        var preview = row.find('.topic-icon-preview');
	        preview.empty();
	        preview.attr('title', 'Pilih ikon: ' + (icon || 'fas fa-th-large'));

	        if (isFontAwesomeIcon(icon)) {
	            preview.append($('<i></i>').attr('class', icon));
        } else if (isImageIcon(icon)) {
            preview.append($('<img />').attr('src', iconSrc(icon)).attr('alt', ''));
        } else {
            preview.append($('<i></i>').attr('class', 'fas fa-th-large'));
        }
    }

	    function syncIconPalette(row) {
	        var icon = cleanTopicIcon(row.find('.topic-icon-input').val());
	        var item = row.closest('.topic-builder-item');
	        item.find('.topic-icon-choice').each(function() {
	            $(this).toggleClass('active', cleanTopicIcon($(this).attr('data-icon')) === icon);
	        });
	        item.find('.topic-icon-custom-input').val(icon);
    }

    function buildIconPalette(icon) {
        var palette = $('<div class="topic-icon-palette"></div>');
        icon = cleanTopicIcon(icon);
	        for (var i = 0; i < topicIconOptions.length; i++) {
	            var option = topicIconOptions[i];
            var choice = $('<button type="button" class="topic-icon-choice"></button>')
                .attr('data-icon', option.value)
                .attr('title', option.label + ' - ' + option.value)
                .toggleClass('active', option.value === icon);
            choice.append($('<i></i>').attr('class', option.value).attr('aria-hidden', 'true'));
            choice.append(
                $('<span class="topic-icon-choice-text"></span>')
                    .append($('<span class="topic-icon-choice-label"></span>').text(option.label))
                    .append($('<span class="topic-icon-choice-code"></span>').text(option.value))
            );
	            palette.append(choice);
	        }
	        palette.append(
	            $('<div class="topic-icon-custom-row"></div>')
	                .append($('<span class="topic-icon-custom-label"></span>').text('Custom'))
	                .append($('<input type="text" class="form-control topic-icon-custom-input" placeholder="fas fa-book atau images/icon.png" />').val(icon))
	        );

	        return palette;
    }

    var updateNavbarMenuTextarea = function() {};
    var textarea = $('textarea[name="classic_navbar_menu"]');
    if (textarea.length) {
        textarea.hide();

        function defaultMenuIcon(text, url) {
            var labelKey = cleanBuilderText(text).toLowerCase();
            var parsedP = '';
            try {
                var parsed = new URL(String(url || ''), window.location.origin);
                parsedP = parsed.searchParams.get('p') || '';
            } catch (e) {}

            var key = parsedP || (labelKey === 'home' ? 'home' : labelKey.replace(/[^a-z0-9_-]+/g, '-').replace(/^-+|-+$/g, ''));
            var icons = {
                home: 'fas fa-home',
                libinfo: 'fas fa-info-circle',
                news: 'fas fa-newspaper',
                help: 'fas fa-question-circle',
                librarian: 'fas fa-users',
                login: 'fas fa-user-shield',
                member: 'fas fa-user'
            };

            return icons[key] || 'fas fa-link';
        }

        function pushItem(items, text, url, icon) {
            text = cleanBuilderText(text);
            url = String(url || '').trim();
            if (text !== '' && isSafeBuilderUrl(url)) {
                items.push({text: text, url: url, icon: cleanTopicIcon(icon || defaultMenuIcon(text, url))});
            }
        }

        function parseMenuValue(rawVal) {
            var items = [];
            rawVal = String(rawVal || '').trim();
            if (rawVal === '') return items;

            var lines = rawVal.split(/[;\\n\\r]+/);
            for (var i = 0; i < lines.length; i++) {
                var line = lines[i].trim();
                if (line === '') continue;
                var parts = line.split('|');
                if (parts.length >= 2) {
                    pushItem(items, parts[0], parts[1], parts.slice(2).join('|'));
                }
            }
            return items;
        }

        var legacyDefaultMenu = 'Home | index.php ; Information | index.php?p=libinfo ; News | index.php?p=news ; Help | index.php?p=help ; Librarian | index.php?p=librarian';
        var plainRasamalaDefaultMenu = 'Home | index.php ; Information | index.php?p=libinfo ; News | index.php?p=news ; Help | index.php?p=help ; Librarian | index.php?p=librarian ; Staff Area | index.php?p=login';
        var rasamalaDefaultMenu = 'Home | index.php | fas fa-home ; Information | index.php?p=libinfo | fas fa-info-circle ; News | index.php?p=news | fas fa-newspaper ; Help | index.php?p=help | fas fa-question-circle ; Librarian | index.php?p=librarian | fas fa-users ; Staff Area | index.php?p=login | fas fa-university';
        var rawVal = textarea.val().trim();
        if (rawVal === legacyDefaultMenu || rawVal === plainRasamalaDefaultMenu) {
            rawVal = rasamalaDefaultMenu;
            textarea.val(rawVal);
        }
        var items = parseMenuValue(rawVal);

        var container = $('<div id="navbar-menu-builder-container" class="mt-2"></div>');
        container.append($('<div class="navbar-menu-builder-help"></div>').text('Klik icon di kiri untuk mengganti. Format disimpan sebagai nama menu, URL, dan icon Font Awesome.'));
        var rowsContainer = $('<div id="navbar-menu-rows"></div>');
        container.append(rowsContainer);
        var addBtn = $('<button type="button" class="btn btn-success btn-sm mt-2 rasamala-builder-action-btn" id="add-menu-row-btn" title="Tambah Menu">+</button>');
        container.append(addBtn);
        textarea.after(container);
        forceBuilderSettingVisible(textarea);

        var memberRow = $('select[name="classic_member_area"]').closest('.form-group, tr, .row');
        memberRow.hide();

        var extraSettings = $('<div class="navbar-menu-extra-settings mt-3 pt-3"></div>');
        var initMemberVal = $('select[name="classic_member_area"]').val();
        var memberCheckbox = $('<label class="rasamala-builder-toggle-label"></label>')
            .append($('<input type="checkbox" class="member-area-toggle" />').prop('checked', initMemberVal == 1))
            .append(' Tampilkan Area Anggota (Member Area)');
        extraSettings.append(memberCheckbox);

        container.append(extraSettings);

        $(document).on('change', '.member-area-toggle', function() {
            $('select[name="classic_member_area"]').val($(this).is(':checked') ? '1' : '0').trigger('change');
        });

        function updateTextarea() {
            var itemsList = [];
            rowsContainer.find('.menu-builder-row').each(function() {
                var row = $(this);
                var name = cleanBuilderText(row.find('.menu-name-input').val());
                var url = row.find('.menu-url-input').val().trim();
                var icon = cleanTopicIcon(row.find('.topic-icon-input').val());
                var isEmpty = name === '' && url === '' && icon === '';
                var isValid = isEmpty || (name !== '' && isSafeBuilderUrl(url));
                row.toggleClass('is-invalid', !isValid);
                if (!isEmpty && isValid) {
                    itemsList.push(name + ' | ' + url + ' | ' + (icon || defaultMenuIcon(name, url)));
                }
            });
            textarea.val(itemsList.join(' ; '));
        }
        updateNavbarMenuTextarea = updateTextarea;

        function addRow(name, url, icon) {
            icon = cleanTopicIcon(icon || defaultMenuIcon(name, url));
            var item = $('<div class="topic-builder-item menu-builder-item"></div>');
            var row = $('<div class="menu-builder-row rasamala-builder-row d-flex align-items-center mb-2"></div>');
            row.append($('<button type="button" class="topic-icon-preview" aria-label="Pilih ikon menu"></button>'));
            row.append($('<input type="text" class="form-control menu-name-input rasamala-builder-input-name" placeholder="Nama Menu" />').val(cleanBuilderText(name)));
            row.append($('<input type="text" class="form-control menu-url-input rasamala-builder-input-url" placeholder="URL" />').val(url || ''));
            row.append($('<input type="hidden" class="topic-icon-input" />').val(icon));
            row.append($('<button type="button" class="btn btn-danger btn-sm remove-menu-row-btn rasamala-builder-action-btn" title="Hapus">&times;</button>'));
            item.append(row);
            item.append(buildIconPalette(icon));
            rowsContainer.append(item);
            syncIconPalette(row);
            updateIconPreview(row);
        }

        if (items.length > 0) {
            for (var i = 0; i < items.length; i++) {
                addRow(items[i].text, items[i].url, items[i].icon);
            }
        } else {
            addRow('Home', 'index.php', 'fas fa-home');
        }

        addBtn.click(function() {
            addRow('', '', 'fas fa-link');
            updateTextarea();
        });

        $(document).on('click', '.remove-menu-row-btn', function() {
            $(this).closest('.menu-builder-item').remove();
            updateTextarea();
        });

        $(document).on('input', '.menu-name-input, .menu-url-input', function() {
            updateTextarea();
        });
    }

    var topicTextarea = $('textarea[name="classic_topic_items"]');
    if (topicTextarea.length) {
        topicTextarea.hide();

        function parseTopicValue(rawVal) {
            var items = [];
            rawVal = String(rawVal || '').trim();
            if (rawVal === '') return items;

            var lines = rawVal.split(/[;\\n\\r]+/);
            for (var i = 0; i < lines.length; i++) {
                var line = lines[i].trim();
                if (line === '') continue;
                var parts = line.split('|');
                if (parts.length >= 2) {
                    var label = cleanBuilderText(parts[0]);
                    var url = String(parts[1] || '').trim();
                    var icon = cleanTopicIcon(parts.slice(2).join('|'));
                    if (label !== '' && isSafeBuilderUrl(url)) {
                        items.push({label: label, url: url, icon: icon});
                    }
                }
            }
            return items;
        }

        var legacyDefaultTopics = 'Literature | index.php?callnumber=8&search=search | images/8-books.png ; Social Sciences | index.php?callnumber=3&search=search | images/3-diploma.png ; Applied Sciences | index.php?callnumber=6&search=search | images/6-blackboard.png ; Art & Recreation | index.php?callnumber=7&search=search | images/7-quill.png ; see more.. | #exampleModal | images/icon/grid_icon.png';
        var rasamalaDefaultTopics = 'Literature | index.php?callnumber=8&search=search | fas fa-book ; Social Sciences | index.php?callnumber=3&search=search | fas fa-users ; Applied Sciences | index.php?callnumber=6&search=search | fas fa-flask ; Art & Recreation | index.php?callnumber=7&search=search | fas fa-paint-brush ; see more.. | #exampleModal | fas fa-th-large';
        var rawTopicVal = topicTextarea.val().trim();
        if (rawTopicVal === legacyDefaultTopics) {
            rawTopicVal = rasamalaDefaultTopics;
            topicTextarea.val(rawTopicVal);
        }
        var topicRows = parseTopicValue(rawTopicVal);
        var topicContainer = $('<div id="topic-items-builder-container" class="mt-2"></div>');
        topicContainer.append($('<div class="topic-items-builder-help"></div>').text('Klik icon di kiri untuk mengganti. Pilih salah satu icon, atau isi custom class/path di dalam panel icon.'));
        var topicRowsContainer = $('<div id="topic-items-rows"></div>');
        topicContainer.append(topicRowsContainer);
        var addTopicBtn = $('<button type="button" class="btn btn-success btn-sm mt-2 rasamala-builder-action-btn" id="add-topic-row-btn" title="Tambah Topic">+</button>');
        topicContainer.append(addTopicBtn);
        topicTextarea.after(topicContainer);
        forceBuilderSettingVisible(topicTextarea);

        function updateTopicTextarea() {
            var itemsList = [];
            topicRowsContainer.find('.topic-builder-row').each(function() {
                var row = $(this);
                var label = cleanBuilderText(row.find('.topic-label-input').val());
                var url = row.find('.topic-url-input').val().trim();
                var icon = cleanTopicIcon(row.find('.topic-icon-input').val());
                var isEmpty = label === '' && url === '' && icon === '';
                var isValid = isEmpty || (label !== '' && isSafeBuilderUrl(url));
                row.toggleClass('is-invalid', !isValid);
                if (!isEmpty && isValid) {
                    itemsList.push(label + ' | ' + url + ' | ' + icon);
                }
            });
            topicTextarea.val(itemsList.join(' ; '));
        }

        function addTopicRow(label, url, icon) {
            icon = cleanTopicIcon(icon || 'fas fa-book');
            var item = $('<div class="topic-builder-item"></div>');
            var row = $('<div class="topic-builder-row rasamala-builder-row d-flex align-items-center mb-2"></div>');
            row.append($('<button type="button" class="topic-icon-preview" aria-label="Pilih ikon topic"></button>'));
            row.append($('<input type="text" class="form-control topic-label-input rasamala-builder-input-name" placeholder="Nama Topic" />').val(cleanBuilderText(label)));
            row.append($('<input type="text" class="form-control topic-url-input rasamala-builder-input-url" placeholder="URL" />').val(url || ''));
            row.append($('<input type="hidden" class="topic-icon-input" />').val(icon));
            row.append($('<button type="button" class="btn btn-danger btn-sm remove-topic-row-btn rasamala-builder-action-btn" title="Hapus">&times;</button>'));
            item.append(row);
            item.append(buildIconPalette(icon));
            topicRowsContainer.append(item);
            syncIconPalette(row);
            updateIconPreview(row);
        }

        if (topicRows.length > 0) {
            for (var j = 0; j < topicRows.length; j++) {
                addTopicRow(topicRows[j].label, topicRows[j].url, topicRows[j].icon);
            }
        } else {
            addTopicRow('Literature', 'index.php?callnumber=8&search=search', 'fas fa-book');
        }

        addTopicBtn.click(function() {
            addTopicRow('', '', 'fas fa-book');
            updateTopicTextarea();
        });

        $(document).on('click', '.remove-topic-row-btn', function() {
            $(this).closest('.topic-builder-item').remove();
            updateTopicTextarea();
        });

        $(document).on('click', '.topic-icon-preview', function(event) {
            event.stopPropagation();
            var item = $(this).closest('.topic-builder-item');
            $('.topic-builder-item').not(item).removeClass('is-icon-picker-open');
            item.toggleClass('is-icon-picker-open');
        });

        $(document).on('click', '.topic-icon-palette', function(event) {
            event.stopPropagation();
        });

        $(document).on('click', '.topic-icon-choice', function(event) {
            event.stopPropagation();
            var item = $(this).closest('.topic-builder-item');
            var row = item.find('.topic-builder-row');
            if (!row.length) {
                row = item.find('.menu-builder-row');
            }
            row.find('.topic-icon-input').val(cleanTopicIcon($(this).attr('data-icon')));
            syncIconPalette(row);
            updateIconPreview(row);
            if (item.hasClass('menu-builder-item')) {
                updateNavbarMenuTextarea();
            } else {
                updateTopicTextarea();
            }
            item.removeClass('is-icon-picker-open');
        });

        $(document).on('input', '.topic-icon-custom-input', function() {
            var item = $(this).closest('.topic-builder-item');
            var row = item.find('.topic-builder-row');
            if (!row.length) {
                row = item.find('.menu-builder-row');
            }
            row.find('.topic-icon-input').val(cleanTopicIcon($(this).val()));
            syncIconPalette(row);
            updateIconPreview(row);
            if (item.hasClass('menu-builder-item')) {
                updateNavbarMenuTextarea();
            } else {
                updateTopicTextarea();
            }
        });

        $(document).on('input', '.topic-label-input, .topic-url-input', function() {
            updateTopicTextarea();
        });

        $(document).on('click', function() {
            $('.topic-builder-item').removeClass('is-icon-picker-open');
        });
    }

    syncBuilderSettingVisibility();
});
</script>
HTML;
  }
}
