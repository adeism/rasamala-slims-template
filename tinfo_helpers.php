<?php
/**
 * Helper output for Rasamala theme customization fields.
 *
 * @Last modified by    : Ade Ismail Siregar (adeismailbox@gmail.com)
 * @Last modified time  : 2026-07-13T09:28:31+07:00
 */
if (!defined('INDEX_AUTH') || INDEX_AUTH != 1) {
  die("can not access this file directly");
}

if (!function_exists('rasamalaTinfoTopicIconOptions')) {
  function rasamalaTinfoTopicIconOptions()
  {
    return [
      ['value' => 'fas fa-book', 'label' => 'Book'],
      ['value' => 'fas fa-bookmark', 'label' => 'Bookmark'],
      ['value' => 'fas fa-users', 'label' => 'Users'],
      ['value' => 'fas fa-user', 'label' => 'User'],
      ['value' => 'fas fa-user-circle', 'label' => 'Profile'],
      ['value' => 'fas fa-user-secret', 'label' => 'Staff/Admin'],
      ['value' => 'fas fa-id-card', 'label' => 'ID Card'],
      ['value' => 'fas fa-flask', 'label' => 'Science'],
      ['value' => 'fas fa-paint-brush', 'label' => 'Art'],
      ['value' => 'fas fa-th-large', 'label' => 'Grid'],
      ['value' => 'fas fa-th', 'label' => 'Tiles'],
      ['value' => 'fas fa-list', 'label' => 'List'],
      ['value' => 'fas fa-align-left', 'label' => 'Simple List'],
      ['value' => 'fas fa-bars', 'label' => 'Menu'],
      ['value' => 'fas fa-desktop', 'label' => 'Computer'],
      ['value' => 'fas fa-university', 'label' => 'University'],
      ['value' => 'fas fa-building', 'label' => 'Building'],
      ['value' => 'fas fa-graduation-cap', 'label' => 'Education'],
      ['value' => 'fas fa-globe', 'label' => 'Globe'],
      ['value' => 'fas fa-history', 'label' => 'History'],
      ['value' => 'fas fa-map', 'label' => 'Map'],
      ['value' => 'fas fa-map-marker-alt', 'label' => 'Location'],
      ['value' => 'fas fa-language', 'label' => 'Language'],
      ['value' => 'fas fa-calculator', 'label' => 'Calculator'],
      ['value' => 'fas fa-archive', 'label' => 'Archive'],
      ['value' => 'fas fa-folder-open', 'label' => 'Folder'],
      ['value' => 'fas fa-database', 'label' => 'Database'],
      ['value' => 'fas fa-newspaper', 'label' => 'News'],
      ['value' => 'fas fa-file-alt', 'label' => 'Document'],
      ['value' => 'fas fa-file-pdf', 'label' => 'PDF'],
      ['value' => 'fas fa-print', 'label' => 'Print'],
      ['value' => 'fas fa-info-circle', 'label' => 'Info'],
      ['value' => 'fas fa-search', 'label' => 'Search'],
      ['value' => 'fas fa-filter', 'label' => 'Filter'],
      ['value' => 'fas fa-sort', 'label' => 'Sort'],
      ['value' => 'fas fa-sliders-h', 'label' => 'Advanced'],
      ['value' => 'fas fa-star', 'label' => 'Star'],
      ['value' => 'fas fa-heart', 'label' => 'Heart'],
      ['value' => 'fas fa-thumbs-up', 'label' => 'Like'],
      ['value' => 'fas fa-leaf', 'label' => 'Leaf'],
      ['value' => 'fas fa-lightbulb', 'label' => 'Idea'],
      ['value' => 'fas fa-cog', 'label' => 'Settings'],
      ['value' => 'fas fa-wrench', 'label' => 'Tools'],
      ['value' => 'fas fa-tags', 'label' => 'Tags'],
      ['value' => 'fas fa-link', 'label' => 'Link'],
      ['value' => 'fas fa-external-link-alt', 'label' => 'External Link'],
      ['value' => 'fas fa-share-alt', 'label' => 'Share'],
      ['value' => 'fas fa-download', 'label' => 'Download'],
      ['value' => 'fas fa-upload', 'label' => 'Upload'],
      ['value' => 'fas fa-shopping-basket', 'label' => 'Basket'],
      ['value' => 'fas fa-calendar-alt', 'label' => 'Calendar'],
      ['value' => 'fas fa-clock', 'label' => 'Clock'],
      ['value' => 'fas fa-bell', 'label' => 'Bell'],
      ['value' => 'fas fa-bullhorn', 'label' => 'Announcement'],
      ['value' => 'fas fa-comments', 'label' => 'Comments'],
      ['value' => 'fas fa-envelope', 'label' => 'Email'],
      ['value' => 'fas fa-phone', 'label' => 'Phone'],
      ['value' => 'fas fa-rss', 'label' => 'RSS'],
      ['value' => 'fas fa-question', 'label' => 'Question'],
      ['value' => 'fas fa-question-circle', 'label' => 'Help'],
      ['value' => 'fas fa-exclamation-circle', 'label' => 'Alert'],
      ['value' => 'fas fa-check-circle', 'label' => 'Available'],
      ['value' => 'fas fa-times-circle', 'label' => 'Unavailable'],
      ['value' => 'fas fa-lock', 'label' => 'Locked'],
      ['value' => 'fas fa-unlock', 'label' => 'Unlocked'],
      ['value' => 'fas fa-key', 'label' => 'Key'],
      ['value' => 'fas fa-shield-alt', 'label' => 'Security'],
      ['value' => 'fas fa-sign-in-alt', 'label' => 'Login'],
      ['value' => 'fas fa-home', 'label' => 'Home'],
      ['value' => 'fas fa-wifi', 'label' => 'Wi-Fi'],
      ['value' => 'fab fa-facebook', 'label' => 'Facebook'],
      ['value' => 'fab fa-twitter', 'label' => 'Twitter'],
      ['value' => 'fab fa-instagram', 'label' => 'Instagram'],
      ['value' => 'fab fa-youtube', 'label' => 'YouTube'],
      ['value' => 'fab fa-whatsapp', 'label' => 'WhatsApp'],
      ['value' => 'fab fa-telegram', 'label' => 'Telegram'],
      ['value' => 'fab fa-github', 'label' => 'GitHub'],
      ['value' => 'fab fa-linkedin', 'label' => 'LinkedIn'],
      ['value' => 'fas fa-ellipsis-h', 'label' => 'More'],
    ];
  }
}

if (!function_exists('rasamalaTinfoLanguageOptions')) {
  function rasamalaTinfoLanguageOptions()
  {
    $language_names = [
      'ar_SA' => ['Arabic', 'العربية'],
      'bn_BD' => ['Bengali', 'বাংলা'],
      'de_DE' => ['German', 'Deutsch'],
      'en_US' => ['English', 'English'],
      'es_ES' => ['Spanish', 'Español'],
      'fa_IR' => ['Persian', 'فارسی'],
      'id_ID' => ['Indonesian', 'Indonesia'],
      'ja_JP' => ['Japanese', '日本語'],
      'ms_MY' => ['Malay', 'Bahasa Melayu'],
      'pt_BR' => ['Brazilian Portuguese', 'Português do Brasil'],
      'ru_RU' => ['Russian', 'Русский'],
      'th_TH' => ['Thai', 'ไทย'],
      'tr_TR' => ['Turkish', 'Türkçe'],
      'ur_PK' => ['Urdu', 'اردو'],
    ];
    $languages = [];
    $locale_dir = realpath(__DIR__ . '/../../../lib/lang/locale');

    if ($locale_dir && is_dir($locale_dir)) {
      $locale_codes = glob($locale_dir . '/*', GLOB_ONLYDIR);
      sort($locale_codes);
      foreach ($locale_codes as $locale_path) {
        $lang_code = basename($locale_path);
        if (!preg_match('/^[a-z]{2}_[A-Z]{2}$/', $lang_code)) {
          continue;
        }

        $lang_name = $language_names[$lang_code][0] ?? str_replace('_', '-', $lang_code);
        $native_name = $language_names[$lang_code][1] ?? '';
        $languages[] = [$lang_code, $lang_name, $native_name];
      }
    }

    $language_options = [];
    foreach ($languages as $language_item) {
      $lang_code = $language_item[0] ?? '';
      $lang_name = $language_item[1] ?? $lang_code;
      $native_name = $language_item[2] ?? '';
      if ($lang_code === '') {
        continue;
      }

      $code_arr = explode('_', (string)$lang_code);
      $flag_code = strtolower($code_arr[1] ?? $code_arr[0] ?? '');
      $flag_code = preg_replace('/[^a-z]/', '', $flag_code);
      $label = trim((string)$native_name) !== '' && $native_name !== $lang_name ? $lang_name . ' / ' . $native_name : $lang_name;
      $language_options[] = [
        'code' => $lang_code,
        'name' => $label,
        'flag' => $flag_code,
      ];
    }

    return $language_options;
  }
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
    $icon_options_json = json_encode(rasamalaTinfoTopicIconOptions(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
    $asset_base_json = json_encode($asset_base, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
    $language_options = rasamalaTinfoLanguageOptions();
    $language_options_json = json_encode($language_options, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
    include_once __DIR__ . '/theme_helpers.php';
    $preset_descriptions = [];
    if (function_exists('themePresetDefinitions')) {
      foreach (themePresetDefinitions() as $preset_key => $preset_info) {
        $preset_descriptions[$preset_key] = [
          'title' => $preset_info['label'] ?? $preset_key,
          'description' => $preset_info['description'] ?? '',
        ];
      }
    }
    $preset_descriptions_json = json_encode($preset_descriptions, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
    $default_announcement_json = json_encode("<strong>Info layanan:</strong> Perpustakaan buka Senin-Jumat, pukul 08.00-16.00 WIB.\n<a href=\"index.php?p=libinfo\">Lihat informasi lengkap</a>.", JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
    $default_custom_css_json = json_encode("/* Custom CSS Rasamala\n   Edit contoh di bawah ini sesuai kebutuhan. */\n\n/* Contoh: ubah ukuran nama perpustakaan di navbar */\n/* .navbar-lib-name {\n  font-size: 14px !important;\n} */\n\n/* Contoh: beri jarak tambahan pada judul hero */\n/* .hero-search-heading h1 {\n  margin-bottom: 16px !important;\n} */\n\n/* Contoh: custom warna tombol utama */\n/* .btn-primary {\n  background-color: var(--theme-accent-color) !important;\n  border-color: var(--theme-accent-color) !important;\n} */", JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);

    return <<<HTML
<link rel="stylesheet" href="{$fontawesome_css}">
<link rel="stylesheet" href="{$flag_icon_css}">
<style>
/* Custom Admin Settings Formatting Improvements */
#themeCustomiseForm input[type="text"],
#themeCustomiseForm select,
#themeCustomiseForm textarea,
input[name^="classic_"],
select[name^="classic_"],
textarea[name^="classic_"] {
    width: 100% !important;
    max-width: 580px !important;
    padding: 8px 12px !important;
    border: 1px solid #ccd0d4 !important;
    border-radius: 6px !important;
    font-size: 13px !important;
    color: #2c3338 !important;
    background-color: #ffffff !important;
    box-shadow: 0 1px 2px rgba(0,0,0,0.04) !important;
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
    var defaultAnnouncementText = {$default_announcement_json};
    var defaultCustomCss = {$default_custom_css_json};
    var quickSettingNames = [
        'classic_theme_color',
        'classic_color_toggle',
        'classic_font_family',
        'classic_search_result_layout',
        'classic_search_panel_style',
        'classic_news_list_layout',
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
        'classic_librarian_custom_usernames'
    ];
    var quickSectionAnchors = [
        'classic_theme_preset',
        'classic_theme_color',
        'classic_hero_text',
        'classic_home_content_cards_show',
        'classic_librarian_display_mode',
        'classic_footer_show'
    ];

    function fillEmptyTextarea(name, value) {
        var field = $('textarea[name="' + name + '"]');
        if (field.length && field.val().trim() === '') {
            field.val(value);
        }
    }

    fillEmptyTextarea('classic_announcement_text', defaultAnnouncementText);
    fillEmptyTextarea('classic_custom_css', defaultCustomCss);

    function settingField(name) {
        return $('[name="' + name + '"]');
    }

    function settingRow(name) {
        return settingField(name).closest('.form-group, tr, .row');
    }

    function settingValue(name) {
        var field = settingField(name);
        return field.length ? String(field.val()) : '';
    }

    function insertTinfoSection(row, title, description, anchor) {
        if (!row.length) return;
        var sectionContent = $('<div class="rasamala-tinfo-section-box"></div>')
            .append($('<span class="rasamala-tinfo-section-title"></span>').text(title))
            .append($('<span class="rasamala-tinfo-section-desc"></span>').text(description));

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
            ['classic_theme_color', 'Tampilan dasar', 'Warna, font, tombol bantu, breadcrumbs, dan CSS tambahan.'],
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
    }

    function syncConditionalSettings() {
        syncThemePresetSummary();
        syncThemePresetVisibility();
        var isCustomPreset = settingValue('classic_theme_preset') === 'custom';

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

        if (!isCustomPreset) {
            return;
        }

        var mapField = settingField('classic_map');
        if (mapField.val() === '1') {
            mapField.val('all');
        } else if (mapField.val() === '0') {
            mapField.val('hide_all');
        }

        var announcementOn = settingValue('classic_announcement_show') === '1';
        setRowsVisible(['classic_announcement_text', 'classic_announcement_style'], announcementOn);

        var homeDisplayOn = isShown('classic_home_display_show');
        var homeDisplaySource = settingValue('classic_home_display_source');
        setRowsVisible(['classic_home_display_source', 'classic_home_display_style', 'classic_home_item_limit', 'classic_home_char_limit'], homeDisplayOn);
        setRowsVisible(['classic_home_display_content_filter', 'classic_home_display_content_detail'], homeDisplayOn && homeDisplaySource === 'content');
        setRowsVisible(['classic_home_display_biblio_filter'], homeDisplayOn && homeDisplaySource === 'biblio');

        var tickerOn = isShown('classic_ticker_show');
        var tickerSource = settingValue('classic_ticker_source');
        setRowsVisible(['classic_ticker_source', 'classic_ticker_speed', 'classic_ticker_item_limit', 'classic_ticker_char_limit'], tickerOn);
        setRowsVisible(['classic_ticker_content_filter', 'classic_ticker_content_detail'], tickerOn && tickerSource === 'content');
        setRowsVisible(['classic_ticker_biblio_filter'], tickerOn && tickerSource === 'biblio');

        var topicOn = settingValue('classic_topic_show') === '1';
        setRowsVisible(['classic_topic_heading_display', 'classic_topic_items'], topicOn);

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

    }

    insertTinfoSections();
    syncConditionalSettings();
    $(document).on('change input', [
        'select[name="classic_theme_preset"]',
        'select[name="classic_hero_background_animation"]',
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
        'select[name="classic_floating_info"]'
    ].join(','), syncConditionalSettings);

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
        var addBtn = $('<button type="button" class="btn btn-success btn-sm mt-2" id="add-menu-row-btn" title="Tambah Menu" style="padding: 4px 12px; cursor: pointer; font-weight: bold; font-size: 14px;">+</button>');
        container.append(addBtn);
        textarea.after(container);

        var memberRow = $('select[name="classic_member_area"]').closest('.form-group, tr, .row');
        memberRow.hide();

        var extraSettings = $('<div class="navbar-menu-extra-settings mt-3 pt-3" style="border-top: 1px solid #E0E0E0; display: flex; gap: 20px; align-items: center; justify-content: flex-start; flex-wrap: wrap;"></div>');
        var initMemberVal = $('select[name="classic_member_area"]').val();
        var memberCheckbox = $('<label style="font-weight: 500; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 0; user-select: none;"></label>')
            .append($('<input type="checkbox" class="member-area-toggle" style="margin: 0 !important; cursor: pointer; width: auto; height: auto;" />').prop('checked', initMemberVal == 1))
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
            var row = $('<div class="menu-builder-row d-flex align-items-center mb-2"></div>');
            row.append($('<button type="button" class="topic-icon-preview" aria-label="Pilih ikon menu"></button>'));
            row.append($('<input type="text" class="form-control menu-name-input" placeholder="Nama Menu" style="width: 34%; margin-right: 10px; display: inline-block;" />').val(cleanBuilderText(name)));
            row.append($('<input type="text" class="form-control menu-url-input" placeholder="URL" style="width: 42%; margin-right: 10px; display: inline-block;" />').val(url || ''));
            row.append($('<input type="hidden" class="topic-icon-input" />').val(icon));
            row.append($('<button type="button" class="btn btn-danger btn-sm remove-menu-row-btn" title="Hapus" style="padding: 4px 12px; cursor: pointer; display: inline-block; font-weight: bold; font-size: 14px;">&times;</button>'));
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
        var addTopicBtn = $('<button type="button" class="btn btn-success btn-sm mt-2" id="add-topic-row-btn" title="Tambah Topic" style="padding: 4px 12px; cursor: pointer; font-weight: bold; font-size: 14px;">+</button>');
        topicContainer.append(addTopicBtn);
        topicTextarea.after(topicContainer);

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
            var row = $('<div class="topic-builder-row d-flex align-items-center mb-2"></div>');
            row.append($('<button type="button" class="topic-icon-preview" aria-label="Pilih ikon topic"></button>'));
            row.append($('<input type="text" class="form-control topic-label-input" placeholder="Nama Topic" style="width: 34%; margin-right: 10px; display: inline-block;" />').val(cleanBuilderText(label)));
            row.append($('<input type="text" class="form-control topic-url-input" placeholder="URL" style="width: 42%; margin-right: 10px; display: inline-block;" />').val(url || ''));
            row.append($('<input type="hidden" class="topic-icon-input" />').val(icon));
            row.append($('<button type="button" class="btn btn-danger btn-sm remove-topic-row-btn" title="Hapus" style="padding: 4px 12px; cursor: pointer; display: inline-block; font-weight: bold; font-size: 14px;">&times;</button>'));
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
});
</script>
HTML;
  }
}
