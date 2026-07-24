<?php
/**
 * Helper Module for Rasamala Template - Admin Customizer Assets Loader
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

    $tinfo_customizer_js_path = dirname(__DIR__) . '/assets/js/tinfo-customizer.js';
    $tinfo_customizer_js_version = is_file($tinfo_customizer_js_path) ? filemtime($tinfo_customizer_js_path) : (defined('SENAYAN_VERSION') ? SENAYAN_VERSION : time());
    $tinfo_customizer_js = htmlspecialchars($asset_base . 'js/tinfo-customizer.js?v=' . $tinfo_customizer_js_version, ENT_QUOTES, 'UTF-8');

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

    $customizer_config = [
      'assetBase' => $asset_base,
      'iconOptions' => rasamalaTinfoTopicIconOptions(),
      'languageOptions' => rasamalaTinfoLanguageOptions(),
      'presets' => $preset_descriptions,
      'palettes' => $palette_definitions,
      'defaults' => [
        'announcement' => "<strong>Info layanan:</strong> Perpustakaan buka Senin-Jumat, pukul 08.00-16.00 WIB.\n<a href=\"index.php?p=libinfo\">Lihat informasi lengkap</a>.",
        'customCss' => "/* Custom CSS Rasamala\n   Edit contoh di bawah ini sesuai kebutuhan. */\n\n/* Contoh: ubah ukuran nama perpustakaan di navbar */\n/* .navbar-lib-name {\n  font-size: 14px !important;\n} */\n\n/* Contoh: beri jarak tambahan pada judul hero */\n/* .hero-search-heading h1 {\n  margin-bottom: 16px !important;\n} */\n\n/* Contoh: custom warna tombol utama */\n/* .btn-primary {\n  background-color: var(--theme-accent-color) !important;\n  border-color: var(--theme-accent-color) !important;\n} */",
        'visitorSteps' => "<div class=\"inst-step\">\n  <div class=\"inst-icon-box\"><i class=\"fas fa-id-card\"></i></div>\n  <div class=\"inst-content\">\n    <h3>1. Isi Identitas</h3>\n    <p>Scan kartu anggota atau ketik identitas pengunjung pada kolom yang tersedia.</p>\n  </div>\n</div>\n<div class=\"inst-step inst-step-featured\">\n  <div class=\"inst-icon-box\"><i class=\"fas fa-sync-alt\"></i></div>\n  <div class=\"inst-content\">\n    <h3>2. Proses Kunjungan</h3>\n    <p>Sistem akan memeriksa data dan menampilkan status kunjungan secara otomatis.</p>\n  </div>\n</div>\n<div class=\"inst-step\">\n  <div class=\"inst-icon-box\"><i class=\"fas fa-check\"></i></div>\n  <div class=\"inst-content\">\n    <h3>3. Selesai</h3>\n    <p>Setelah berhasil, pengunjung dapat melanjutkan aktivitas sesuai layanan yang tersedia.</p>\n  </div>\n</div>",
        'visitorInstitutions' => "feb(Fakultas Ekonomi dan Bisnis UI);ff(Fakultas Farmasi UI);fh(Fakultas Hukum UI);fia(Fakultas Ilmu Administrasi UI);fib(Fakultas Ilmu Budaya UI);fik(Fakultas Ilmu Keperawatan UI);fasilkom(Fakultas Ilmu Komputer UI);fisip(Fakultas Ilmu Sosial dan Ilmu Politik UI);fk(Fakultas Kedokteran UI);fkg(Fakultas Kedokteran Gigi UI);fkm(Fakultas Kesehatan Masyarakat UI);fmipa(Fakultas Matematika dan Ilmu Pengetahuan Alam UI);fpsi(Fakultas Psikologi UI);ft(Fakultas Teknik UI);vokasi(Program Vokasi UI);other"
      ]
    ];

    $config_json = json_encode($customizer_config, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);

    return <<<HTML
<link rel="stylesheet" href="{$fontawesome_css}">
<link rel="stylesheet" href="{$flag_icon_css}">
<link rel="stylesheet" href="{$tinfo_customizer_css}">
<script>window.rasamalaCustomizerConfig = {$config_json};</script>
<script src="{$tinfo_customizer_js}"></script>
HTML;
  }
}
