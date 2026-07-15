<!--
# ===============================
# Classic SLiMS Template
# ===============================
# @Author: Waris Agung Widodo
# @Email:  ido.alit@gmail.com
# @Date:   2018-01-23T11:25:57+07:00
# @Last modified by:   Ade Ismail Siregar (adeismailbox@gmail.com)
# @Last modified time: 2026-07-13T09:28:31+07:00
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
?>
<!DOCTYPE html>
<html>
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
      window.rasamalaDarkCssUrl = '<?php echo assetsVersioned("css/style-dark.css"); ?>';
      (function() {
        try {
          if (window.localStorage.getItem('rasamala-color-mode') === 'dark') {
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
    $selected_color = themeSelectedAccentColor(themeEffectiveAccentColorKey($sysconf));
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
        --rasamala-text-secondary: <?php echo themeEscape($selected_color['primary']); ?>;
        --rasamala-accent: <?php echo themeEscape($selected_color['primary']); ?>;
        --rasamala-accent-hover: <?php echo themeEscape($selected_color['hover']); ?>;
        --theme-accent-color: <?php echo themeEscape($selected_color['primary']); ?>;
        --theme-accent-rgb: <?php echo themeEscape($selected_color['rgb']); ?>;
        --theme-accent-glow: rgba(<?php echo themeEscape($selected_color['rgb']); ?>, 0.8);
        --theme-accent-glow-half: rgba(<?php echo themeEscape($selected_color['rgb']); ?>, 0.4);
        --rasamala-font-stack: <?php echo $font_stack; ?>;
        --ticker-speed: <?php echo themeEscape($ticker_speed_val); ?>;
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
$is_homepage = !isset($_GET['p']) && !isset($_GET['search']);
$is_homepage_only_hero = $is_homepage && themeHomepageOnlyHero($sysconf);
$search_panel_style = strtolower(trim((string) themeEffectiveTemplateValue('classic_search_panel_style', 'transparent', $sysconf)));
if (!in_array($search_panel_style, ['transparent', 'solid'], true)) {
    $search_panel_style = 'transparent';
}
$body_classes = 'bg-light rasamala-theme';
$body_classes .= ' rasamala-preset-' . preg_replace('/[^a-z0-9_-]+/i', '-', themePresetKey($sysconf));
$body_classes .= ' rasamala-search-panels-' . $search_panel_style;
$current_page_class = isset($_GET['p']) ? (string)$_GET['p'] : ($is_homepage ? 'home' : 'search');
$body_classes .= ' rasamala-page-' . preg_replace('/[^a-z0-9_-]+/i', '-', strtolower($current_page_class));
if ($background_animation_enabled) {
    $body_classes .= ' rasamala-background-animation-active rasamala-background-animation-' . $background_animation;
}
if ($is_homepage_only_hero) {
    $body_classes .= ' rasamala-home-hero-only';
}
$mobile_bottom_nav_enabled = (($sysconf['template']['classic_mobile_bottom_nav_show'] ?? 1) == 1);
$body_classes .= $mobile_bottom_nav_enabled ? ' mobile-bottom-nav-enabled' : ' mobile-bottom-nav-hidden';
?>
<body class="<?php echo themeEscape($body_classes); ?>" data-cursor-particles="<?php echo themeEscape(themeEffectiveTemplateValue('classic_cursor_particles', 'auto', $sysconf)); ?>" data-cursor-custom-icon="<?php echo themeEscape(themeEffectiveTemplateValue('classic_cursor_custom_icon', 'default', $sysconf)); ?>">
<script>
(function () {
    try {
        if (window.localStorage.getItem('rasamala-color-mode') === 'dark') {
            document.documentElement.classList.add('rasamala-dark');
            document.body.classList.add('rasamala-dark');
        }
    } catch (error) {}
}());
</script>
<?php if ($background_animation_enabled) :
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
     aria-hidden="true"></div>
<?php endif; ?>
