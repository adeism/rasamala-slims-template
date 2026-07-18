<?php
# @Author: Waris Agung Widodo <user>
# @Date:   2026-07-16T11:02:00+07:00
# @Email:  ido.alit@gmail.com
# @Filename: palette_switcher.php
# @Last modified by:   Ade Ismail Siregar (adeismailbox@gmail.com)
# @Last modified time: 2026-07-16T15:30:11+07:00

$palette_switcher_show = (int)themeEffectiveTemplateValue('classic_palette_switcher_show', 1, $sysconf) === 1;
if (!$palette_switcher_show) {
    ?>
<script>
window.rasamalaPaletteSwitcher = { enabled: false };
(function () {
    try {
        window.localStorage.removeItem('rasamala-theme-palette-key');
        window.localStorage.removeItem('rasamala-theme-custom-palette');
        window.localStorage.removeItem('rasamala-theme-font-family');
        window.localStorage.removeItem('rasamala-theme-background-animation');
        window.localStorage.removeItem('rasamala-theme-background-animation-speed');
        window.localStorage.removeItem('rasamala-theme-cursor-particles');
        window.localStorage.removeItem('rasamala-theme-cursor-icon');
        window.localStorage.removeItem('rasamala-theme-sections-hidden');
        window.localStorage.removeItem('rasamala-theme-hidden-sections');
    } catch (error) {}
}());
</script>
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
            'rgb' => $palette['rgb'] ?? themeHexToRgbString($palette['primary'] ?? '#6f5b43'),
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

$palette_prompt = "Buat 1 custom palette OPAC perpustakaan dalam format persis berikut: #PRIMARY; #SECONDARY; #ACCENT; #BACKGROUND; #SURFACE; #TEXT; #MUTED | #DARK_PRIMARY; #DARK_SECONDARY; #DARK_ACCENT; #DARK_BACKGROUND; #DARK_SURFACE; #DARK_TEXT; #DARK_MUTED. Output hanya 1 baris kode warna hex 6 digit, tanpa markdown, tanpa bullet, tanpa nama variabel, tanpa penjelasan. Pastikan Primary cocok untuk navbar/footer and tombol utama, Surface cocok untuk card/input, Background untuk halaman, Text kontras minimal WCAG AA terhadap Background/Surface, Muted tetap terbaca, Accent tidak dipakai untuk teks panjang. Buat light palette dan dark palette yang berbeda tetapi tetap satu identitas visual. Tema visual yang diminta: [tulis konsep warna di sini].";

$palette_switcher_config = [
    'enabled' => true,
    'currentPreset' => function_exists('themePresetKey') ? themePresetKey($sysconf) : 'simple_homepage',
    'presets' => [
        'simple_homepage' => __('Simple - Search + Running Text'),
        'office' => __('Simple + Topics'),
        'all_show' => __('Full - Topics + News + Collections + Top Reader + Map + Running Text'),
        'custom' => __('Custom (Fully Unlocked)')
    ],
    'currentKey' => $effective_palette_key ?? 'warmgray',
    'customValue' => themeEffectiveTemplateValue('classic_palette_custom_colors', '', $sysconf),
    'fontFamily' => themeEffectiveTemplateValue('classic_font_family', 'system', $sysconf),
    'backgroundAnimation' => themeEffectiveTemplateValue('classic_background_animation', 'none', $sysconf),
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

<script>
window.rasamalaPaletteSwitcher = <?= json_encode($palette_switcher_config, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>;
</script>

<div class="rasamala-palette-switcher" id="rasamala-palette-switcher">
    <button type="button"
            id="palette-switcher-toggle"
            class="btn-palette-switcher shadow-lg <?= !empty($latest_content_ticker_items ?? []) ? 'has-latest-content-ticker' : '' ?>"
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
        <label class="palette-switcher-label" for="theme-preset-select"><?= themeEscape(__('Pilihan Keseluruhan Tema')); ?></label>
        <select id="theme-preset-select" class="form-control palette-switcher-select"></select>
        <div class="palette-switcher-grid">
            <div class="palette-switcher-field">
                <label class="palette-switcher-label" for="palette-switcher-select"><?= themeEscape(__('Palette')); ?></label>
                <select id="palette-switcher-select" class="form-control palette-switcher-select"></select>
            </div>
            <div class="palette-switcher-field">
                <label class="palette-switcher-label" for="theme-viewer-animation-select"><?= themeEscape(__('Animasi Background')); ?></label>
                <select id="theme-viewer-animation-select" class="form-control palette-switcher-select"></select>
            </div>
            <div class="palette-switcher-field">
                <label class="palette-switcher-label" for="theme-viewer-animation-speed-select"><?= themeEscape(__('Kecepatan Animasi Background')); ?></label>
                <select id="theme-viewer-animation-speed-select" class="form-control palette-switcher-select"></select>
            </div>
            <div class="palette-switcher-field">
                <label class="palette-switcher-label" for="theme-viewer-cursor-particles-select"><?= themeEscape(__('Efek Partikel Cursor')); ?></label>
                <select id="theme-viewer-cursor-particles-select" class="form-control palette-switcher-select"></select>
            </div>
            <div class="palette-switcher-field">
                <label class="palette-switcher-label" for="theme-viewer-font-select"><?= themeEscape(__('Font Tema')); ?></label>
                <select id="theme-viewer-font-select" class="form-control palette-switcher-select"></select>
            </div>
            <div class="palette-switcher-field">
                <label class="palette-switcher-label" for="theme-viewer-cursor-icon-select"><?= themeEscape(__('Ikon Cursor')); ?></label>
                <select id="theme-viewer-cursor-icon-select" class="form-control palette-switcher-select"></select>
            </div>
        </div>
        <div class="palette-switcher-section-tools" aria-label="<?= themeEscape(__('Section Beranda')); ?>">
            <div class="d-flex justify-content-between align-items-center mb-1" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                <span class="palette-switcher-label palette-switcher-section-label" style="margin: 0; font-weight: 700;"><?= themeEscape(__('Section Beranda')); ?></span>
                <div style="display: flex; gap: 4px;">
                    <button type="button" 
                            class="palette-switcher-tool-btn" 
                            id="theme-viewer-show-sections" 
                            style="width: 26px; height: 26px; padding: 0; min-height: 26px; border-radius: 6px;" 
                            title="<?= themeEscape(__('Show all sections')); ?>"
                            aria-label="<?= themeEscape(__('Show all sections')); ?>">
                        <i class="fas fa-eye" style="font-size: 11px;" aria-hidden="true"></i>
                    </button>
                    <button type="button" 
                            class="palette-switcher-tool-btn" 
                            id="theme-viewer-hide-sections" 
                            style="width: 26px; height: 26px; padding: 0; min-height: 26px; border-radius: 6px;" 
                            title="<?= themeEscape(__('Hide all sections')); ?>"
                            aria-label="<?= themeEscape(__('Hide all sections')); ?>">
                        <i class="fas fa-eye-slash" style="font-size: 11px;" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            <div class="palette-switcher-section-list" id="theme-viewer-section-list"></div>
        </div>
        <div class="palette-switcher-custom" id="palette-switcher-custom" hidden>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
                <label class="palette-switcher-label" for="palette-switcher-custom-input" style="margin: 0;"><?= themeEscape(__('Custom Palette Colors')); ?></label>
                <button type="button"
                        id="palette-switcher-apply"
                        class="btn btn-primary btn-sm"
                        style="padding: 4px 10px; font-size: 11px; border-radius: 4px; display: inline-flex; align-items: center; gap: 4px; background: var(--theme-accent) !important; color: var(--theme-on-accent) !important; border-color: var(--theme-accent) !important; font-weight: bold;"
                        title="<?= themeEscape(__('Apply')); ?>"
                        aria-label="<?= themeEscape(__('Apply')); ?>">
                    <i class="fas fa-check" style="color: var(--theme-on-accent) !important; font-size: 10px;" aria-hidden="true"></i>
                    <span><?= themeEscape(__('Apply')); ?></span>
                </button>
            </div>
            <textarea id="palette-switcher-custom-input"
                      class="form-control palette-switcher-custom-input"
                      rows="4"
                      maxlength="320"
                      autocomplete="off"
                      spellcheck="false"
                      style="margin-top: 6px;"></textarea>
            <div class="palette-switcher-help" style="font-size: 10px; line-height: 1.3; margin-top: 4px;"><?= themeEscape(__('Format: Light palette | Dark palette. Urutan tiap sisi: Primary; Secondary; Accent; Background; Surface; Text; Muted. Hanya kode hex 6 digit yang dipakai.')); ?></div>
        </div>
        <div class="palette-switcher-actions-compact" style="display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 18px; padding-top: 12px; border-top: 1px solid color-mix(in srgb, var(--theme-muted) 16%, transparent); width: 100%;">
            <button type="button"
                    id="palette-color-mode-toggle"
                    class="palette-switcher-tool-btn"
                    title="<?= themeEscape(__('Toggle dark/light mode')); ?>"
                    data-dark-title="<?= themeEscape(__('Dark mode')); ?>"
                    data-light-title="<?= themeEscape(__('Light mode')); ?>"
                    aria-label="<?= themeEscape(__('Toggle dark/light mode')); ?>"
                    aria-pressed="false">
                <i class="fas fa-moon" aria-hidden="true"></i>
            </button>
            <button type="button"
                    id="palette-switcher-copy-prompt"
                    class="palette-switcher-tool-btn"
                    title="<?= themeEscape(__('Copy Prompt')); ?>"
                    aria-label="<?= themeEscape(__('Copy Prompt')); ?>">
                <i class="fas fa-copy" aria-hidden="true"></i>
            </button>
            <button type="button"
                    id="palette-switcher-paste-palette"
                    class="palette-switcher-tool-btn"
                    title="<?= themeEscape(__('Paste Palette')); ?>"
                    aria-label="<?= themeEscape(__('Paste Palette')); ?>">
                <i class="fas fa-paste" aria-hidden="true"></i>
            </button>
            <button type="button"
                    id="palette-switcher-reset"
                    class="palette-switcher-tool-btn"
                    title="<?= themeEscape(__('Reset')); ?>"
                    aria-label="<?= themeEscape(__('Reset')); ?>">
                <i class="fas fa-undo" aria-hidden="true"></i>
            </button>
        </div>

    </div>
</div>
