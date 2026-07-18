<!--
# ===============================
# Classic SLiMS Template
# ===============================
# @Author: Waris Agung Widodo
# @Email:  ido.alit@gmail.com
# @Date:   2018-01-23T11:25:57+07:00
# @Last modified by:   Ade Ismail Siregar (adeismailbox@gmail.com)
# @Last modified time: 2026-07-16T13:33:16+07:00
-->
<?php
// clean request uri from xss (S-05: use parse_url for safer extraction)
$_rasamala_parsed_uri = parse_url($_SERVER['REQUEST_URI'] ?? '');
$request_uri = urlencode(strip_tags(urldecode($_rasamala_parsed_uri['path'] ?? '/')
    . (isset($_rasamala_parsed_uri['query']) ? '?' . $_rasamala_parsed_uri['query'] : '')));
$default_meta_image_src = ($sysconf['template']['dir'] ?? 'template/default') . '/default/img/logo.png';
$meta_image_src = $default_meta_image_src;
if (isset($_GET['p']) && $_GET['p'] === 'show_detail') {
    if (isset($image_src) && trim((string)$image_src) !== '') {
        $meta_image_src = (string)$image_src;
    } elseif (isset($opac) && isset($opac->image_src) && trim((string)$opac->image_src) !== '') {
        $meta_image_src = (string)$opac->image_src;
    }
}
$document_lang = (string)($_COOKIE['select_lang'] ?? $sysconf['default_lang'] ?? 'en_US');
$document_lang = preg_replace('/[^A-Za-z0-9_-]/', '', $document_lang);
$document_lang = str_replace('_', '-', $document_lang ?: 'en-US');
?>
<!DOCTYPE html>
<html lang="<?php echo themeEscape($document_lang); ?>">
<head>
    <meta charset="utf-8">
    <title><?php echo themeEscape($page_title); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, post-check=0, pre-check=0"/>
    <meta http-equiv="Expires" content="Sat, 26 Jul 1997 05:00:00 GMT"/>
    <?php echo strip_tags((string)($metadata ?? ''), '<meta><link>'); // T-02: sanitize $metadata ?>
    <?php if (isset($_GET['p']) && ($_GET['p'] == 'show_detail')): ?>
        <meta name="description" content="<?php echo themeEscape(themeExcerpt($notes ?? '', 152)); ?>">
        <meta name="keywords" content="<?php echo themeEscape(strip_tags($subject ?? '')); ?>">
    <?php else: ?>
        <meta name="description" content="<?php echo themeEscape($page_title); ?>">
        <meta name="keywords" content="<?php echo themeEscape($sysconf['library_subname']); ?>">
    <?php endif; ?>
    <meta name="csrf-token" content="<?php echo themeEscape(isset($opac) ? $opac->getCsrf() : ($_SESSION['csrf_token'] ?? '')); ?>">
    <meta name="generator" content="<?php echo themeEscape(SENAYAN_VERSION) ?>">
    <meta name="theme-color" content="#F5F5F5">

    <meta property="og:locale" content="<?php echo themeEscape(str_replace('-', '_', $sysconf['default_lang'])); ?>"/>
    <meta property="og:type" content="book"/>
    <meta property="og:title" content="<?php echo themeEscape($page_title); ?>"/>
    <?php if (isset($_GET['p']) && ($_GET['p'] == 'show_detail')): ?>
        <meta property="og:description" content="<?php echo themeEscape(themeExcerpt($notes ?? '', 152)); ?>"/>
    <?php else: ?>
        <meta property="og:description" content="<?php echo themeEscape($sysconf['library_subname']); ?>"/>
    <?php endif; ?>
    <meta property="og:url" content="//<?php echo themeEscape(($_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME']) . $request_uri); ?>"/>
    <meta property="og:site_name" content="<?php echo themeEscape($sysconf['library_name']); ?>"/>
    <meta property="og:image" content="//<?php echo themeEscape($_SERVER["SERVER_NAME"] . SWB . $meta_image_src) ?>"/>

    <meta name="twitter:card" content="summary">
    <meta name="twitter:url" content="//<?php echo themeEscape($_SERVER["SERVER_NAME"] . $request_uri); ?>"/>
    <meta name="twitter:title" content="<?php echo themeEscape($page_title); ?>"/>
    <meta property="twitter:image" content="//<?php echo themeEscape($_SERVER["SERVER_NAME"] . SWB . $meta_image_src) ?>"/>
    <!-- // load bootstrap style -->
    <link rel="stylesheet" href="<?php echo assets('css/bootstrap.min.css'); ?>">
    <!-- // font awesome -->
    <link rel="stylesheet" href="<?php echo assets('plugin/font-awesome/css/fontawesome-all.min.css'); ?>">
    <link href="<?php echo themeEscape(JWB); ?>toastr/toastr.min.css?v=<?php echo themeEscape(assetVersion(SB . 'js/toastr/toastr.min.css')); ?>" rel="stylesheet" type="text/css"/>
    <!-- CKEditor5 CSS -->
    <link rel="stylesheet" href="<?= themeEscape(JWB); ?>ckeditor5/ckeditor5.css">
    <!-- SLiMS CSS -->
    <link rel="stylesheet" href="<?= themeEscape(JWB); ?>colorbox/colorbox.css">
    <link rel="stylesheet" href="<?= themeEscape(JWB); ?>ion.rangeSlider/css/ion.rangeSlider.min.css">
    <!-- // Flag css -->
    <link rel="stylesheet" href="<?php echo assets('css/flag-icon.min.css'); ?>">
    <!-- // local font faces -->
    <link rel="stylesheet" href="<?php echo assetsVersioned('fonts/google-fonts.css'); ?>">
    <!-- // my custom style -->
    <link rel="stylesheet" href="<?php echo assetsVersioned('css/style.css'); ?>">
    <script>
      window.rasamalaColorModeDefault = <?php echo json_encode(themeColorModeDefault($sysconf), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>;
      window.rasamalaColorModeToggleVisible = <?php echo themeColorModeToggleVisible($sysconf) ? 'true' : 'false'; ?>;
      window.rasamalaDarkCssUrl = '<?php echo assetsVersioned("css/style-dark.css"); ?>';
      window.rasamalaResolveColorMode = function() {
        var fallback = window.rasamalaColorModeDefault || 'auto';

        if (window.rasamalaColorModeToggleVisible !== false) {
          try {
            var stored = window.localStorage.getItem('rasamala-color-mode');
            if (stored === 'dark' || stored === 'light') {
              return stored;
            }
          } catch (e) {}
        }

        if (fallback === 'dark' || fallback === 'light') {
          return fallback;
        }

        try {
          return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        } catch (e) {}

        return 'light';
      };
      (function() {
        try {
          if (window.rasamalaResolveColorMode() === 'dark') {
            var darkCss = document.createElement('link');
            darkCss.id = 'rasamala-dark-css';
            darkCss.rel = 'stylesheet';
            darkCss.href = window.rasamalaDarkCssUrl;
            document.head.appendChild(darkCss);
          }
        } catch (e) {}
      })();
    </script>

    <script>
      window.rasamalaAutoCoverMode = <?php echo json_encode(themeAutoCoverMode($sysconf), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>;
      window.rasamalaAutoCoverGenerator = window.rasamalaAutoCoverMode !== 'none';
    </script>

    <?php
    $effective_palette_key = strtolower((string) themeEffectiveAccentColorKey($sysconf));
    $selected_color = themeSelectedAccentColor($effective_palette_key, $sysconf);
    $selected_dark_color = themeSelectedDarkAccentColor($effective_palette_key, $sysconf);
    $ticker_speed_val = '18s';
    $ticker_speed = themeEffectiveTemplateValue('classic_ticker_speed', 'normal', $sysconf);
    if ($ticker_speed === 'fast') {
        $ticker_speed_val = '12s';
    } elseif ($ticker_speed === 'normal') {
        $ticker_speed_val = '18s';
    } elseif ($ticker_speed === 'slow') {
        $ticker_speed_val = '32s';
    } elseif ($ticker_speed === 'very_slow') {
        $ticker_speed_val = '52s';
    }

    $font_family = themeEffectiveFontFamilyKey($sysconf);
    $font_stack = 'system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif';
    if ($font_family === 'inter') {
        $font_stack = "'Inter', system-ui, BlinkMacSystemFont, 'Segoe UI', sans-serif";
    } elseif ($font_family === 'roboto') {
        $font_stack = "'Roboto', Arial, Helvetica, sans-serif";
    } elseif ($font_family === 'poppins') {
        $font_stack = "'Poppins', 'Trebuchet MS', Arial, sans-serif";
    } elseif ($font_family === 'playfair') {
        $font_stack = "'Playfair Display', Georgia, 'Times New Roman', serif";
    }
    ?>
    <style>
      :root {
        --theme-primary: <?php echo themeEscape($selected_color['primary']); ?>;
        --theme-primary-hover: <?php echo themeEscape($selected_color['hover']); ?>;
        --theme-secondary: <?php echo themeEscape($selected_color['secondary']); ?>;
        --theme-accent: <?php echo themeEscape($selected_color['accent']); ?>;
        --theme-background: <?php echo themeEscape($selected_color['background']); ?>;
        --theme-surface: <?php echo themeEscape($selected_color['surface']); ?>;
        --theme-text: <?php echo themeEscape($selected_color['text']); ?>;
        --theme-muted: <?php echo themeEscape($selected_color['muted']); ?>;
        --theme-primary-rgb: <?php echo themeEscape($selected_color['rgb']); ?>;
        --theme-accent-rgb-value: <?php echo themeEscape($selected_color['accent_rgb']); ?>;
        --theme-on-primary: <?php echo themeEscape($selected_color['on_primary']); ?>;
        --theme-on-primary-hover: <?php echo themeEscape($selected_color['on_primary_hover']); ?>;
        --theme-on-secondary: <?php echo themeEscape($selected_color['on_secondary']); ?>;
        --theme-on-accent: <?php echo themeEscape($selected_color['on_accent']); ?>;
        --theme-on-background: <?php echo themeEscape($selected_color['on_background']); ?>;
        --theme-on-surface: <?php echo themeEscape($selected_color['on_surface']); ?>;
        --theme-dark-primary: <?php echo themeEscape($selected_dark_color['primary']); ?>;
        --theme-dark-primary-hover: <?php echo themeEscape($selected_dark_color['hover']); ?>;
        --theme-dark-secondary: <?php echo themeEscape($selected_dark_color['secondary']); ?>;
        --theme-dark-accent: <?php echo themeEscape($selected_dark_color['accent']); ?>;
        --theme-dark-background: <?php echo themeEscape($selected_dark_color['background']); ?>;
        --theme-dark-surface: <?php echo themeEscape($selected_dark_color['surface']); ?>;
        --theme-dark-text: <?php echo themeEscape($selected_dark_color['text']); ?>;
        --theme-dark-muted: <?php echo themeEscape($selected_dark_color['muted']); ?>;
        --theme-dark-primary-rgb: <?php echo themeEscape($selected_dark_color['rgb']); ?>;
        --theme-dark-accent-rgb-value: <?php echo themeEscape($selected_dark_color['accent_rgb']); ?>;
        --theme-dark-on-primary: <?php echo themeEscape($selected_dark_color['on_primary']); ?>;
        --theme-dark-on-primary-hover: <?php echo themeEscape($selected_dark_color['on_primary_hover']); ?>;
        --theme-dark-on-secondary: <?php echo themeEscape($selected_dark_color['on_secondary']); ?>;
        --theme-dark-on-accent: <?php echo themeEscape($selected_dark_color['on_accent']); ?>;
        --theme-dark-on-background: <?php echo themeEscape($selected_dark_color['on_background']); ?>;
        --theme-dark-on-surface: <?php echo themeEscape($selected_dark_color['on_surface']); ?>;
        --color-primary: var(--theme-primary);
        --color-secondary: var(--theme-secondary);
        --color-accent: var(--theme-accent);
        --color-background: var(--theme-background);
        --color-surface: var(--theme-surface);
        --color-text: var(--theme-text);
        --color-muted: var(--theme-muted);
        --color-on-primary: var(--theme-on-primary);
        --color-on-secondary: var(--theme-on-secondary);
        --color-on-accent: var(--theme-on-accent);
        --rasamala-light-bg: var(--theme-background);
        --rasamala-text-primary: var(--theme-text);
        --rasamala-text-secondary: var(--theme-secondary);
        --rasamala-text-muted: var(--theme-muted);
        --rasamala-surface: var(--theme-surface);
        --rasamala-accent: <?php echo themeEscape($selected_color['accent']); ?>;
        --rasamala-accent-hover: <?php echo themeEscape($selected_color['accent_hover']); ?>;
        --rasamala-readable-accent: color-mix(in srgb, var(--theme-accent) 72%, var(--theme-text) 28%);
        --theme-accent-color: <?php echo themeEscape($selected_color['accent']); ?>;
        --theme-accent-rgb: <?php echo themeEscape($selected_color['accent_rgb']); ?>;
        --theme-accent-glow: rgba(<?php echo themeEscape($selected_color['accent_rgb']); ?>, 0.8);
        --theme-accent-glow-half: rgba(<?php echo themeEscape($selected_color['accent_rgb']); ?>, 0.4);
        --rasamala-chrome-bg: color-mix(in srgb, var(--theme-primary) 92%, #000 8%);
        --rasamala-chrome-border: color-mix(in srgb, var(--theme-primary) 38%, transparent);
        --rasamala-chrome-text: var(--theme-on-primary);
        --rasamala-chrome-text-muted: color-mix(in srgb, var(--theme-on-primary) 76%, transparent);
        --bs-body-bg: var(--theme-background);
        --bs-body-color: var(--theme-text);
        --bs-secondary-color: var(--theme-muted);
        --rasamala-font-stack: <?php echo $font_stack; ?>;
	        --ticker-speed: <?php echo themeEscape($ticker_speed_val); ?>;
	      }
	      html.rasamala-dark {
	        background-color: var(--theme-dark-background) !important;
	      }
	      body.rasamala-dark {
	        --theme-primary: var(--theme-dark-primary);
	        --theme-primary-hover: var(--theme-dark-primary-hover);
	        --theme-secondary: var(--theme-dark-secondary);
	        --theme-accent: var(--theme-dark-accent);
	        --theme-background: var(--theme-dark-background);
	        --theme-surface: var(--theme-dark-surface);
	        --theme-text: var(--theme-dark-text);
	        --theme-muted: var(--theme-dark-muted);
	        --theme-primary-rgb: var(--theme-dark-primary-rgb);
	        --theme-on-primary: var(--theme-dark-on-primary);
	        --theme-on-primary-hover: var(--theme-dark-on-primary-hover);
	        --theme-on-secondary: var(--theme-dark-on-secondary);
	        --theme-on-accent: var(--theme-dark-on-accent);
	        --theme-on-background: var(--theme-dark-on-background);
	        --theme-on-surface: var(--theme-dark-on-surface);
	        --color-primary: var(--theme-primary);
	        --color-secondary: var(--theme-secondary);
	        --color-accent: var(--theme-accent);
	        --color-background: var(--theme-background);
	        --color-surface: var(--theme-surface);
	        --color-text: var(--theme-text);
	        --color-muted: var(--theme-muted);
	        --color-on-primary: var(--theme-on-primary);
	        --color-on-secondary: var(--theme-on-secondary);
	        --color-on-accent: var(--theme-on-accent);
	        --rasamala-light-bg: var(--theme-dark-background);
	        --rasamala-text-primary: var(--theme-dark-text);
	        --rasamala-text-secondary: var(--theme-dark-muted);
	        --rasamala-text-muted: var(--theme-dark-muted);
	        --rasamala-surface: var(--theme-dark-surface);
	        --rasamala-accent: var(--theme-dark-accent);
	        --rasamala-accent-hover: color-mix(in srgb, var(--theme-dark-accent) 84%, #000 16%);
	        --rasamala-readable-accent: color-mix(in srgb, var(--theme-dark-accent) 62%, var(--theme-dark-text) 38%);
	        --theme-accent-color: var(--theme-dark-accent);
	        --theme-accent-rgb: var(--theme-dark-accent-rgb-value);
	        --theme-accent-glow: rgba(var(--theme-dark-accent-rgb-value), 0.8);
	        --theme-accent-glow-half: rgba(var(--theme-dark-accent-rgb-value), 0.4);
	        --rasamala-chrome-bg: color-mix(in srgb, var(--theme-dark-primary) 88%, #000 12%);
	        --rasamala-chrome-border: color-mix(in srgb, var(--theme-dark-primary) 38%, transparent);
	        --rasamala-chrome-text: var(--theme-on-primary);
	        --rasamala-chrome-text-muted: color-mix(in srgb, var(--theme-on-primary) 76%, transparent);
	        --rasamala-dark-surface: var(--theme-dark-surface);
	        --rasamala-dark-surface-strong: color-mix(in srgb, var(--theme-dark-surface) 88%, #000 12%);
	        --rasamala-dark-surface-soft: color-mix(in srgb, var(--theme-dark-surface) 72%, transparent);
	        --rasamala-dark-text: var(--theme-dark-text);
	        --rasamala-dark-muted: var(--theme-dark-muted);
	        --rasamala-dark-link: color-mix(in srgb, var(--theme-dark-accent) 58%, #ffffff 42%);
	        --rasamala-dark-link-strong: color-mix(in srgb, var(--theme-dark-accent) 38%, #ffffff 62%);
	        --rasamala-dark-action-bg: color-mix(in srgb, var(--theme-dark-primary) 82%, #05070a 18%);
	        --rasamala-dark-action-hover-bg: color-mix(in srgb, var(--theme-dark-primary) 82%, #ffffff 18%);
	        --rasamala-dark-action-border: color-mix(in srgb, var(--theme-dark-accent) 46%, rgba(255, 255, 255, 0.22) 54%);
	        --rasamala-dark-accent-text: var(--rasamala-dark-link);
	        --rasamala-dark-accent-text-strong: var(--rasamala-dark-link-strong);
	        --rasamala-dark-accent-bg: color-mix(in srgb, var(--theme-dark-primary) 30%, transparent 70%);
	        --rasamala-dark-accent-border: var(--rasamala-dark-action-border);
	        --bs-body-bg: var(--theme-dark-background);
	        --bs-body-color: var(--theme-dark-text);
	        --bs-secondary-color: var(--theme-dark-muted);
	        background-color: var(--theme-dark-background) !important;
	        color: var(--theme-dark-text) !important;
	      }
      body,
      button,
      input,
      select,
      textarea,
      .form-control,
      .btn,
      .dropdown-menu,
      .modal-content {
        font-family: var(--rasamala-font-stack) !important;
      }
      
      /* Legacy SLiMS/plugin output compatibility while the theme markup uses Bootstrap 5 utilities. */
      .mr-1 { margin-right: 0.25rem !important; }
      .mr-2 { margin-right: 0.5rem !important; }
      .mr-3 { margin-right: 1rem !important; }
      .mr-4 { margin-right: 1.5rem !important; }
      .mr-5 { margin-right: 3rem !important; }
      .mr-auto { margin-right: auto !important; }
      .ml-1 { margin-left: 0.25rem !important; }
      .ml-2 { margin-left: 0.5rem !important; }
      .ml-3 { margin-left: 1rem !important; }
      .ml-4 { margin-left: 1.5rem !important; }
      .ml-5 { margin-left: 3rem !important; }
      .ml-auto { margin-left: auto !important; }
      .pr-1 { padding-right: 0.25rem !important; }
      .pr-2 { padding-right: 0.5rem !important; }
      .pr-3 { padding-right: 1rem !important; }
      .pr-4 { padding-right: 1.5rem !important; }
      .pr-5 { padding-right: 3rem !important; }
      .pl-0 { padding-left: 0 !important; }
      .pl-1 { padding-left: 0.25rem !important; }
      .pl-2 { padding-left: 0.5rem !important; }
      .pl-3 { padding-left: 1rem !important; }
      .pl-4 { padding-left: 1.5rem !important; }
      .pl-5 { padding-left: 3rem !important; }
      .float-left { float: left !important; }
      .float-right { float: right !important; }
      .text-left { text-align: left !important; }
      .text-right { text-align: right !important; }
      .btn-block { display: block; width: 100%; }
      .custom-select {
        display: block;
        width: 100%;
        padding: 0.375rem 2.25rem 0.375rem 0.75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: var(--bs-body-color);
        background-color: var(--bs-body-bg);
        border: var(--bs-border-width) solid var(--bs-border-color);
        border-radius: var(--bs-border-radius);
        appearance: none;
      }
      .close {
        float: right;
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1;
        color: #000;
        text-shadow: 0 1px 0 #fff;
        opacity: .5;
        background-color: transparent;
        border: 0;
      }
      .close:hover {
        color: #000;
        text-decoration: none;
        opacity: .75;
      }
    </style>

    <?php if (!empty($sysconf['template']['classic_custom_css'] ?? '')) :
      // K-01: sanitize custom CSS — block javascript/expression/import payloads and HTML tags
      $_rasamala_custom_css = (string)($sysconf['template']['classic_custom_css'] ?? '');
      $_rasamala_custom_css = preg_replace('/<[^>]*>/', '', $_rasamala_custom_css);
      $_rasamala_custom_css = preg_replace('/(javascript|vbscript|expression)\s*[:(\/]/i', '/* blocked */', $_rasamala_custom_css);
      $_rasamala_custom_css = preg_replace('/@\s*import\b/i', '/* blocked-import */', $_rasamala_custom_css);
    ?>
    <style>
      /* Custom CSS */
      <?= $_rasamala_custom_css; ?>
    </style>
    <?php endif; ?>

    <?php
    $icon = SWB . 'webicon.ico';
    if (isset($sysconf['webicon']) && !empty($sysconf['webicon']) && $imagesDisk->isExists($path = 'default/' . $sysconf['webicon']))
    {
        $icon = SWB . 'lib/minigalnano/createthumb.php?filename=images/' . $path . '&width=130';
    }
    ?>
    <link rel="shortcut icon" href="<?= themeEscape($icon) ?>" type="image/x-icon"/>

    <!-- // load vue js -->
    <script src="<?php echo assets('js/vue.min.js'); ?>"></script>
    <!-- // load jquery library -->
    <script src="<?php echo assets('js/jquery.min.js'); ?>"></script>
    <script src="<?php echo assets('js/masonry.pkgd.min.js'); ?>"></script>
    <!-- // load bootstrap javascript -->
    <script src="<?php echo assets('js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo assetsVersioned('js/bootstrap_compat.js'); ?>"></script>
    <script src="<?php echo JWB; ?>toastr/toastr.min.js"></script>
    <!-- // load SLiMS javascript -->
    <script src="<?php echo JWB; ?>colorbox/jquery.colorbox-min.js"></script>
    <script src="<?php echo JWB . v('gui.js'); ?>"></script>
    <script src="<?php echo JWB; ?>fancywebsocket.js"></script>
    <script src="<?php echo JWB; ?>ion.rangeSlider/js/ion.rangeSlider.min.js"></script>
    <?php
    // S-03: sanitize $js — allow only script and link tags from core
    if (isset($js)):
        echo strip_tags((string)($js ?? ''), '<script><link>');
    endif;
    ?>

    <!-- R-04: Basic Content Security Policy -->
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline'; img-src 'self' data: https:; frame-src https://www.google.com https://maps.google.com;">
</head>
<?php
$background_animation = themeBackgroundAnimation();
$background_animation_enabled = $background_animation !== 'none';
$palette_switcher_show = (int) themeEffectiveTemplateValue('classic_palette_switcher_show', 1, $sysconf) === 1;
$is_homepage = !isset($_GET['p']) && !isset($_GET['search']);
$is_homepage_only_hero = $is_homepage && themeHomepageOnlyHero($sysconf);
$search_panel_style = strtolower(trim((string) themeEffectiveTemplateValue('classic_search_panel_style', 'transparent', $sysconf)));
if (!in_array($search_panel_style, ['transparent', 'solid'], true)) {
    $search_panel_style = 'transparent';
}
$body_classes = 'bg-light rasamala-theme';
$body_classes .= ' rasamala-preset-' . preg_replace('/[^a-z0-9_-]+/i', '-', themePresetKey($sysconf));
$body_classes .= ' rasamala-palette-' . preg_replace('/[^a-z0-9_-]+/i', '-', $effective_palette_key ?? 'warmgray');
if ((int) themeEffectiveTemplateValue('classic_palette_switcher_show', 1, $sysconf) === 1) {
    $body_classes .= ' rasamala-has-palette-switcher';
}
$floating_info_body_mode = themeEffectiveTemplateValue('classic_floating_info', 'libinfo', $sysconf);
if ($floating_info_body_mode == '1') {
    $floating_info_body_mode = 'libinfo';
} elseif ($floating_info_body_mode == '0') {
    $floating_info_body_mode = 'hide';
}
if (!in_array($floating_info_body_mode, ['libinfo', 'whatsapp', 'hide'], true)) {
    $floating_info_body_mode = 'libinfo';
}
$body_classes .= ' rasamala-floating-info-' . $floating_info_body_mode;
if (function_exists('themePaletteIsDark') && themePaletteIsDark($selected_color ?? [])) {
    $body_classes .= ' rasamala-palette-dark';
}
$body_classes .= ' rasamala-search-panels-' . $search_panel_style;
$current_page_class = isset($_GET['p']) ? (string)$_GET['p'] : ($is_homepage ? 'home' : 'search');
$body_classes .= ' rasamala-page-' . preg_replace('/[^a-z0-9_-]+/i', '-', strtolower($current_page_class));
if ($background_animation_enabled) {
    $body_classes .= ' rasamala-background-animation-active rasamala-background-animation-' . $background_animation;
}
if ($is_homepage_only_hero) {
    $body_classes .= ' rasamala-home-hero-only';
}
if ($is_homepage && !$is_homepage_only_hero && function_exists('themeHomepageSectionOrder') && function_exists('themeHomepageSectionEnabled')) {
    $home_visible_sections = [];
    foreach (themeHomepageSectionOrder($sysconf) as $home_section_key) {
        if (themeHomepageSectionEnabled($home_section_key, $sysconf)) {
            $home_visible_sections[] = $home_section_key;
        }
    }

    if (count($home_visible_sections) > 0 && count($home_visible_sections) <= 1) {
        $body_classes .= ' rasamala-home-few-sections';
    }
    if (count($home_visible_sections) === 1 && $home_visible_sections[0] === 'topic') {
        $body_classes .= ' rasamala-home-topic-only';
    }
}
$mobile_bottom_nav_enabled = (($sysconf['template']['classic_mobile_bottom_nav_show'] ?? 1) == 1);
$body_classes .= $mobile_bottom_nav_enabled ? ' mobile-bottom-nav-enabled' : ' mobile-bottom-nav-hidden';
?>
<body class="<?php echo themeEscape($body_classes); ?>" data-cursor-particles="<?php echo themeEscape(themeEffectiveTemplateValue('classic_cursor_particles', 'auto', $sysconf)); ?>" data-cursor-custom-icon="<?php echo themeEscape(themeEffectiveTemplateValue('classic_cursor_custom_icon', 'default', $sysconf)); ?>">
<script>
(function () {
    try {
        var mode = window.rasamalaResolveColorMode ? window.rasamalaResolveColorMode() : window.localStorage.getItem('rasamala-color-mode');
        if (mode === 'dark') {
            document.documentElement.classList.add('rasamala-dark');
            document.body.classList.add('rasamala-dark');
        }
    } catch (error) {}
}());
</script>
<?php if ($background_animation_enabled || $palette_switcher_show) :
$anim_speed = themeEffectiveTemplateValue('classic_background_animation_speed', 'normal', $sysconf);
$speed_mult = 1.0;
if ($anim_speed === 'slow') {
    $speed_mult = 1.5;
} elseif ($anim_speed === 'fast') {
    $speed_mult = 0.65;
}
?>
<div id="background-animation-layer"
     class="background-animation-layer hero-animation-layer hero-animation-<?php echo themeEscape($background_animation); ?>"
     data-animation="<?php echo themeEscape($background_animation); ?>"
     data-speed-multiplier="<?php echo themeEscape($speed_mult); ?>"
     aria-hidden="true"
     <?php echo !$background_animation_enabled ? 'hidden' : ''; ?>></div>
<?php endif; ?>
