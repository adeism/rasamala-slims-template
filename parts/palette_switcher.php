<?php
# @Author: Ade Ismail Siregar <adeismailbox@gmail.com>
# @Date:   2026-07-16T11:02:00+07:00
# @Email:  adeismailbox@gmail.com
# @Filename: palette_switcher.php
# @Last modified by:   Ade Ismail Siregar (adeismailbox@gmail.com)
# @Last modified time: 2026-07-22T12:54:00+07:00

$palette_switcher_show = (int)themeEffectiveTemplateValue('classic_palette_switcher_show', 1, $sysconf) === 1;
if (!$palette_switcher_show) {
    ?>
<template id="rasamala-palette-switcher-config"><?= themeEscape(json_encode(['enabled' => false], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT)); ?></template>
    <?php
    return;
}

if (!function_exists('rasamalaPaletteForSwitcher')) {
    function rasamalaPaletteForSwitcher($palette)
    {
        return [
            'primary' => $palette['primary'] ?? '#6f5b43',
            'hover' => $palette['hover'] ?? themeAdjustHexColor($palette['primary'] ?? '#6f5b43', -28),
            'secondary' => $palette['secondary'] ?? '#a58a63',
            'accent' => $palette['accent'] ?? '#c8a24a',
            'background' => $palette['background'] ?? '#f4f1ec',
            'surface' => $palette['surface'] ?? '#ffffff',
            'text' => $palette['text'] ?? '#2f2a24',
            'muted' => $palette['muted'] ?? '#7a7167',
            'mutedOnBackground' => $palette['muted_on_background'] ?? ($palette['muted'] ?? '#7a7167'),
            'mutedOnSurface' => $palette['muted_on_surface'] ?? ($palette['muted'] ?? '#7a7167'),
            'rgb' => $palette['rgb'] ?? themeHexToRgbString($palette['primary'] ?? '#6f5b43'),
            'accentRgb' => $palette['accent_rgb'] ?? themeHexToRgbString($palette['accent'] ?? '#c8a24a'),
            'onPrimary' => $palette['on_primary'] ?? themeReadableTextColor($palette['primary'] ?? '#6f5b43'),
            'onPrimaryHover' => $palette['on_primary_hover'] ?? themeReadableTextColor($palette['hover'] ?? '#5d4b36'),
            'onSecondary' => $palette['on_secondary'] ?? themeReadableTextColor($palette['secondary'] ?? '#a58a63'),
            'onAccent' => $palette['on_accent'] ?? themeReadableTextColor($palette['accent'] ?? '#c8a24a'),
            'onBackground' => $palette['on_background'] ?? themeReadableTextColor($palette['background'] ?? '#f4f1ec'),
            'onSurface' => $palette['on_surface'] ?? themeReadableTextColor($palette['surface'] ?? '#ffffff'),
        ];
    }
}

$palette_options = [];
$palette_presets = function_exists('themeAccentPalettes') ? themeAccentPalettes() : [];
foreach ($palette_presets as $palette_key => $palette_data) {
    $palette_options[$palette_key] = [
        'label' => $palette_data['label'] ?? ucfirst($palette_key),
        'light' => rasamalaPaletteForSwitcher(themeSelectedAccentColor($palette_key, $sysconf)),
        'dark' => rasamalaPaletteForSwitcher(themeSelectedDarkAccentColor($palette_key, $sysconf)),
    ];
}

$current_palette_key = strtolower((string)themeEffectiveAccentColorKey($sysconf));
$custom_palette_value = themeSanitizeCustomPaletteString(themeEffectiveTemplateValue('classic_palette_custom', '', $sysconf));
$palette_options['custom'] = [
    'label' => __('Custom Palette'),
    'light' => rasamalaPaletteForSwitcher(themeSelectedAccentColor('custom', $sysconf)),
    'dark' => rasamalaPaletteForSwitcher(themeSelectedDarkAccentColor('custom', $sysconf)),
];

$font_options = [
    'system' => __('System Default (Outfit)'),
    'inter' => __('Inter'),
    'roboto' => __('Roboto'),
    'poppins' => __('Poppins'),
    'playfair' => __('Playfair Display (Serif)'),
];
$animation_options = [
    'none' => __('None'),
    'particles' => __('Floating Glyphs'),
    'rain' => __('Code Rain'),
    'grid' => __('Moving Grid'),
    'twinkle' => __('Twinkling Stars'),
    'zen-ripples' => __('Zen Ripples'),
    'neural-network' => __('Neural Network'),
    'starfield-warp' => __('Starfield Warp'),
    'floating-embers' => __('Floating Embers'),
];
$animation_speed_options = [
    'slow' => __('Slow'),
    'normal' => __('Normal'),
    'fast' => __('Fast'),
];
$cursor_particle_options = [
    'auto' => __('Auto (Deteksi Perangkat)'),
    'low' => __('Ringan'),
    'medium' => __('Sedang'),
    'high' => __('Optimal'),
    'none' => __('Nonaktif'),
];
$cursor_icon_options = [
    'default' => __('Default Browser'),
    'neon-comet' => __('Neon Comet'),
    'pixel-sword' => __('Pixel Sword'),
    'electric-bolt' => __('Electric Bolt'),
    'ink-brush' => __('Ink Brush'),
    'rainbow-ribbon' => __('Rainbow Ribbon'),
];
$home_section_options = [
    ['key' => 'hero-info', 'label' => __('Info Area Search (Hero Info)'), 'selector' => '.latest-content-strip'],
    ['key' => 'topic', 'label' => __('Topics'), 'selector' => '.rasamala-home-section-topic'],
    ['key' => 'news', 'label' => __('Latest Content'), 'selector' => '.rasamala-home-content-cards-section'],
    ['key' => 'popular', 'label' => __('Popular Collections'), 'selector' => '.rasamala-home-section-popular'],
    ['key' => 'new-collection', 'label' => __('New Collections'), 'selector' => '.rasamala-home-section-new-collection'],
    ['key' => 'top-reader', 'label' => __('Top Reader'), 'selector' => '.rasamala-home-section-top-reader'],
    ['key' => 'map', 'label' => __('Map & Social Media'), 'selector' => '.rasamala-home-section-map'],
    ['key' => 'footer', 'label' => __('Footer'), 'selector' => 'footer'],
];

$palette_prompt = "Buat 1 custom palette OPAC perpustakaan dalam format persis berikut: #PRIMARY; #SECONDARY; #ACCENT; #BACKGROUND; #SURFACE; #TEXT; #MUTED | #DARK_PRIMARY; #DARK_SECONDARY; #DARK_ACCENT; #DARK_BACKGROUND; #DARK_SURFACE; #DARK_TEXT; #DARK_MUTED. Output hanya 1 baris kode warna hex 6 digit, tanpa markdown, tanpa bullet, tanpa nama variabel, tanpa penjelasan. Aturan wajib: untuk light palette, Background dan Surface harus sama-sama terang/soft, Text harus gelap dan memiliki contrast ratio minimal 4.5:1 terhadap Background serta Surface, Muted juga minimal 4.5:1. Untuk dark palette, Background dan Surface harus sama-sama gelap, Text harus terang dan minimal 4.5:1 terhadap keduanya, Muted juga tetap terbaca minimal 4.5:1. Primary dipakai untuk navbar/footer/tombol utama; pastikan teks putih atau hitam terbaca di atas Primary. Accent hanya untuk highlight/icon/status, bukan teks panjang. Jangan pilih Text/Muted yang mirip Background atau Surface. Jika ragu gunakan Text #111827 dan Muted #374151 untuk light, Text #f8fafc dan Muted #cbd5e1 untuk dark. Buat light palette dan dark palette yang berbeda tetapi tetap satu identitas visual. Tema visual yang diminta: [tulis konsep warna di sini].";

$top_subjects = [];
if (isset($dbs) && $dbs) {
    try {
        $q = $dbs->query("SELECT mt.topic FROM mst_topic AS mt LEFT JOIN biblio_topic AS bt ON mt.topic_id = bt.topic_id GROUP BY mt.topic_id ORDER BY COUNT(bt.biblio_id) DESC, mt.topic ASC LIMIT 50");
        if ($q) {
            while ($row = $q->fetch_row()) {
                $topic_name = trim((string)$row[0]);
                if ($topic_name !== '') {
                    $top_subjects[] = $topic_name;
                }
            }
        }
    } catch (\Exception $e) {}
}
if (empty($top_subjects)) {
    $top_subjects = [
        'Kesusastraan', 'Teknologi', 'Sains', 'Sejarah', 'Filsafat', 'Seni', 'Agama', 'Bahasa', 'Ilmu Sosial', 'Ekonomi',
        'Komputer', 'Fisika', 'Kimia', 'Matematika', 'Biologi', 'Kedokteran', 'Hukum', 'Politik', 'Pendidikan', 'Psikologi'
    ];
}

$effective_palette_key = $current_palette_key ?: strtolower((string)themeEffectiveAccentColorKey($sysconf));

$palette_switcher_config = [
    'topSubjects' => $top_subjects,

    'enabled' => true,
    'currentPreset' => function_exists('themePresetKey') ? themePresetKey($sysconf) : 'custom',
    'presets' => [
        'simple_homepage' => themeTranslate('Simple - Search + Running Text'),
        'office' => themeTranslate('Simple + Topics'),
        'all_show' => themeTranslate('Full - Topics + News + Collections + Top Reader + Map + Running Text'),
        'custom' => themeTranslate('Custom (Fully Unlocked)')
    ],
    'currentKey' => $effective_palette_key ?: 'custom',
    'customValue' => $custom_palette_value,
    'fontFamily' => themeEffectiveTemplateValue('classic_font_family', 'system', $sysconf),
    'backgroundAnimation' => themeEffectiveTemplateValue('classic_hero_background_animation', 'neural-network', $sysconf),
    'backgroundAnimationSpeed' => themeEffectiveTemplateValue('classic_background_animation_speed', 'normal', $sysconf),
    'cursorParticles' => themeEffectiveTemplateValue('classic_cursor_particles', 'auto', $sysconf),
    'cursorIcon' => themeEffectiveTemplateValue('classic_cursor_custom_icon', 'default', $sysconf),
    'prompt' => $palette_prompt,
    'labels' => [
        'promptCopied' => __('Copied'),
        'palettePasted' => __('Pasted'),
        'clipboardUnavailable' => __('Clipboard unavailable'),
    ],
    'fonts' => $font_options,
    'animations' => $animation_options,
    'animationSpeeds' => $animation_speed_options,
    'cursorParticlesOptions' => $cursor_particle_options,
    'cursorIcons' => $cursor_icon_options,
    'palettes' => $palette_options,
    'homeSections' => $home_section_options,
];
?>

<template id="rasamala-palette-switcher-config"><?= themeEscape(json_encode($palette_switcher_config, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT)); ?></template>

<?php
$has_ticker_active = !empty($latest_content_ticker_items) || (function_exists('themeEffectiveTemplateValue') && themeEffectiveTemplateValue('classic_ticker_show', 0, $sysconf) === 'bottom');
?>
<div class="rasamala-palette-switcher" id="rasamala-palette-switcher">
    <button type="button"
            id="palette-switcher-toggle"
            class="btn-palette-switcher shadow-lg <?= $has_ticker_active ? 'has-latest-content-ticker' : '' ?>"
            aria-label="<?= themeEscape(__('Open theme palette menu')); ?>"
            aria-expanded="false"
            aria-controls="palette-switcher-panel">
        <i class="fas fa-paint-brush palette-switcher-icon" aria-hidden="true"></i>
    </button>
    <div id="palette-switcher-panel" class="palette-switcher-panel" hidden>
        <div class="palette-switcher-header">
            <strong><?= themeEscape(__('Theme Viewer')); ?></strong>
            <div class="palette-switcher-header-actions">
                <button type="button" class="palette-switcher-close" data-palette-close aria-label="<?= themeEscape(__('Close')); ?>">&times;</button>
            </div>
        </div>
        <label class="palette-switcher-label" for="theme-preset-select"><?= themeEscape(themeTranslate('Overall Theme Preset')); ?></label>
        <select id="theme-preset-select" class="form-control palette-switcher-select"></select>
        <div class="palette-switcher-grid">
            <div class="palette-switcher-field">
                <label class="palette-switcher-label" for="palette-switcher-select"><?= themeEscape(themeTranslate('Palette')); ?></label>
                <select id="palette-switcher-select" class="form-control palette-switcher-select"></select>
            </div>
            <div class="palette-switcher-field">
                <label class="palette-switcher-label" for="theme-viewer-font-select"><?= themeEscape(themeTranslate('Theme Font')); ?></label>
                <select id="theme-viewer-font-select" class="form-control palette-switcher-select"></select>
            </div>
            <div class="palette-switcher-field">
                <label class="palette-switcher-label" for="theme-viewer-animation-select"><?= themeEscape(themeTranslate('Background Animation')); ?></label>
                <select id="theme-viewer-animation-select" class="form-control palette-switcher-select"></select>
            </div>
            <div class="palette-switcher-field">
                <label class="palette-switcher-label" for="theme-viewer-animation-speed-select"><?= themeEscape(themeTranslate('Animation Speed')); ?></label>
                <select id="theme-viewer-animation-speed-select" class="form-control palette-switcher-select"></select>
            </div>
            <div class="palette-switcher-field">
                <label class="palette-switcher-label" for="theme-viewer-cursor-particles-select"><?= themeEscape(themeTranslate('Cursor Particles')); ?></label>
                <select id="theme-viewer-cursor-particles-select" class="form-control palette-switcher-select"></select>
            </div>
            <div class="palette-switcher-field">
                <label class="palette-switcher-label" for="theme-viewer-cursor-icon-select"><?= themeEscape(themeTranslate('Cursor Icon')); ?></label>
                <select id="theme-viewer-cursor-icon-select" class="form-control palette-switcher-select"></select>
            </div>
        </div>
        <div class="palette-switcher-section-tools" aria-label="<?= themeEscape(themeTranslate('Home Section')); ?>">
            <div class="d-flex justify-content-between align-items-center mb-1 palette-switcher-section-head">
                <span class="palette-switcher-label palette-switcher-section-label palette-switcher-label-flush"><?= themeEscape(themeTranslate('Home Section')); ?></span>
                <div class="palette-switcher-section-actions">
                    <button type="button" 
                            class="palette-switcher-tool-btn palette-switcher-tool-btn-compact" 
                            id="theme-viewer-show-sections" 
                            title="<?= themeEscape(__('Show all sections')); ?>"
                            aria-label="<?= themeEscape(__('Show all sections')); ?>">
                        <i class="fas fa-eye palette-switcher-tool-icon-small" aria-hidden="true"></i>
                    </button>
                    <button type="button" 
                            class="palette-switcher-tool-btn palette-switcher-tool-btn-compact" 
                            id="theme-viewer-hide-sections" 
                            title="<?= themeEscape(__('Hide all sections')); ?>"
                            aria-label="<?= themeEscape(__('Hide all sections')); ?>">
                        <i class="fas fa-eye-slash palette-switcher-tool-icon-small" aria-hidden="true"></i>
                    </button>
                    <button type="button"
                            id="palette-color-mode-toggle"
                            class="palette-switcher-tool-btn palette-switcher-tool-btn-compact"
                            title="<?= themeEscape(__('Toggle dark/light mode')); ?>"
                            data-dark-title="<?= themeEscape(__('Dark mode')); ?>"
                            data-light-title="<?= themeEscape(__('Light mode')); ?>"
                            aria-label="<?= themeEscape(__('Toggle dark/light mode')); ?>"
                            aria-pressed="false">
                        <i class="fas fa-moon palette-switcher-tool-icon-small" aria-hidden="true"></i>
                    </button>
                    <button type="button"
                            id="palette-switcher-reset"
                            class="palette-switcher-tool-btn palette-switcher-tool-btn-compact"
                            title="<?= themeEscape(__('Reset')); ?>"
                            aria-label="<?= themeEscape(__('Reset')); ?>">
                        <i class="fas fa-undo palette-switcher-tool-icon-small" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            <div class="palette-switcher-section-list" id="theme-viewer-section-list"></div>
        </div>
        <div class="palette-switcher-custom" id="palette-switcher-custom" hidden>
            <div class="palette-switcher-custom-head mb-1">
                <label class="palette-switcher-label palette-switcher-label-flush" for="palette-switcher-custom-input"><?= themeEscape(__('Custom Palette Colors')); ?></label>
            </div>
            <textarea id="palette-switcher-custom-input"
                      class="form-control palette-switcher-custom-input palette-switcher-custom-textarea"
                      rows="4"
                      maxlength="320"
                      autocomplete="off"
                      spellcheck="false"></textarea>
            <div class="palette-switcher-help palette-switcher-format-help mt-2">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                    <span class="fw-bold text-xs"><i class="fas fa-magic text-primary me-1" aria-hidden="true"></i><?= themeEscape(__('Generate Warna via AI (ChatGPT/Gemini/AI Lainnya):')); ?></span>
                    <div class="palette-switcher-custom-actions d-inline-flex align-items-center gap-1">
                        <button type="button"
                                id="palette-switcher-copy-prompt"
                                class="palette-switcher-tool-btn btn-prompt-action"
                                title="<?= themeEscape(__('Copy Prompt')); ?>"
                                aria-label="<?= themeEscape(__('Copy Prompt')); ?>">
                            <i class="fas fa-copy" aria-hidden="true"></i><?= themeEscape(__('Copy Prompt')); ?>
                        </button>
                        <button type="button"
                                id="palette-switcher-paste-palette"
                                class="palette-switcher-tool-btn btn-prompt-action"
                                title="<?= themeEscape(__('Paste Palette')); ?>"
                                aria-label="<?= themeEscape(__('Paste Palette')); ?>">
                            <i class="fas fa-paste" aria-hidden="true"></i><?= themeEscape(__('Paste Palette')); ?>
                        </button>
                    </div>
                </div>
                <div class="palette-switcher-ai-hint text-xs mb-2 p-2 rounded bg-light border">
                    <i class="fas fa-lightbulb text-warning me-1" aria-hidden="true"></i>
                    <span><strong>Langkah Singkat:</strong> Klik <u>Copy Prompt</u> ➔ Paste di ChatGPT/Gemini ➔ Salin balasan AI ➔ Klik <u>Paste Palette</u>.</span>
                </div>
                <div class="text-muted text-xs mb-1"><?= themeEscape(__('Atau isi manual dengan format:')); ?></div>
                <code class="palette-switcher-format-code d-block">#1e3a8a;#3b82f6;#10b981;#f3f4f6;#ffffff;#1f2937;#4b5563 | #0f172a;#1e293b;#10b981;#0f172a;#1e293b;#f9fafb;#94a3b8</code>
            </div>
        </div>

    </div>
</div>
