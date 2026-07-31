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
$rasamala_header = themeHeaderContext($sysconf, $imagesDisk ?? null, $is_login ?? false, $image_src ?? null, $opac ?? null);
$rasamala_host = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? '';
$rasamala_is_search_page = isset($_GET['search']);
?>
<!DOCTYPE html>
<html lang="<?= themeEscape($rasamala_header['document_lang']); ?>">
<head>
    <meta charset="utf-8">
    <!-- Cryptographic Nonce-Based CSP (SEC-01) -->
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; base-uri 'self'; object-src 'none'; form-action 'self'; script-src 'self' 'nonce-<?= themeCspNonce() ?>' 'unsafe-inline' 'unsafe-eval' https:; style-src 'self' 'nonce-<?= themeCspNonce() ?>' 'unsafe-inline' https:; img-src 'self' data: https:; font-src 'self' data: https:; connect-src 'self' https:; frame-src 'self' https://www.google.com https://maps.google.com;">
    <title><?= themeEscape($page_title); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="referrer" content="strict-origin-when-cross-origin">
    <meta http-equiv="Permissions-Policy" content="camera=(), microphone=(), geolocation=()">

    <?= themeSanitizeMetadata($metadata ?? ''); ?>
    <?php if (isset($_GET['p']) && $_GET['p'] === 'show_detail'): ?>
        <meta name="description" content="<?= themeEscape(themeExcerpt($notes ?? '', 152)); ?>">
        <meta name="keywords" content="<?= themeEscape(strip_tags($subject ?? '')); ?>">
    <?php else: ?>
        <meta name="description" content="<?= themeEscape($page_title); ?>">
        <meta name="keywords" content="<?= themeEscape($sysconf['library_subname']); ?>">
    <?php endif; ?>
    <meta name="csrf-token" content="<?= themeEscape(isset($opac) ? $opac->getCsrf() : ($_SESSION['csrf_token'] ?? '')); ?>">
    <meta name="generator" content="<?= themeEscape(SENAYAN_VERSION) ?>">
    <meta name="theme-color" content="#F5F5F5">

    <meta property="og:locale" content="<?= themeEscape(str_replace('-', '_', $sysconf['default_lang'])); ?>"/>
    <meta property="og:type" content="book"/>
    <meta property="og:title" content="<?= themeEscape($page_title); ?>"/>
    <?php if (isset($_GET['p']) && $_GET['p'] === 'show_detail'): ?>
        <meta property="og:description" content="<?= themeEscape(themeExcerpt($notes ?? '', 152)); ?>"/>
    <?php else: ?>
        <meta property="og:description" content="<?= themeEscape($sysconf['library_subname']); ?>"/>
    <?php endif; ?>
    <meta property="og:url" content="//<?= themeEscape($rasamala_host . $rasamala_header['request_uri']); ?>"/>
    <meta property="og:site_name" content="<?= themeEscape($sysconf['library_name']); ?>"/>
    <meta property="og:image" content="//<?= themeEscape(($_SERVER['SERVER_NAME'] ?? '') . SWB . $rasamala_header['meta_image_src']) ?>"/>

    <meta name="twitter:card" content="summary">
    <meta name="twitter:url" content="//<?= themeEscape(($_SERVER['SERVER_NAME'] ?? '') . $rasamala_header['request_uri']); ?>"/>
    <meta name="twitter:title" content="<?= themeEscape($page_title); ?>"/>
    <meta property="twitter:image" content="//<?= themeEscape(($_SERVER['SERVER_NAME'] ?? '') . SWB . $rasamala_header['meta_image_src']) ?>"/>

    <!-- // load bootstrap style -->
    <link rel="stylesheet" href="<?= assets('css/bootstrap.min.css'); ?>">
    <!-- // font awesome preload & optimization (PERF-04) -->
    <link rel="preload" href="<?= assets('plugin/font-awesome/css/fontawesome-all.min.css'); ?>" as="style">
    <link rel="preload" href="<?= assets('plugin/font-awesome/webfonts/fa-solid-900.woff2'); ?>" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="<?= assets('plugin/font-awesome/webfonts/fa-brands-400.woff2'); ?>" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="<?= assets('plugin/font-awesome/css/fontawesome-all.min.css'); ?>">
    <link href="<?= themeEscape(JWB); ?>toastr/toastr.min.css?v=<?= themeEscape(assetVersion(SB . 'js/toastr/toastr.min.css')); ?>" rel="stylesheet" type="text/css"/>
    <!-- Search-only filter stylesheet -->
    <?php if ($rasamala_is_search_page) : ?>
    <link rel="stylesheet" href="<?= themeEscape(JWB); ?>ion.rangeSlider/css/ion.rangeSlider.min.css">
    <?php endif; ?>
<!-- Flag icons are visible in the header, so load their stylesheet normally. -->
<link rel="stylesheet" href="<?= assetsVersioned('css/flag-icon.min.css'); ?>">
    <!-- // local font faces -->
    <link rel="stylesheet" href="<?= assetsVersioned('fonts/google-fonts.css'); ?>">
    <!-- // my custom style -->
    <link rel="stylesheet" href="<?= assetsVersioned('css/foundation.css'); ?>">
    <link rel="stylesheet" href="<?= assetsVersioned('css/opac-pages.css'); ?>">
    <link rel="stylesheet" href="<?= assetsVersioned('css/theme-components.css'); ?>">
    <link rel="stylesheet" href="<?= assetsVersioned('css/header-runtime.css'); ?>">
    <?php if (isset($_GET['p']) && $_GET['p'] === 'visitor') : ?>
    <link rel="stylesheet" href="<?= themeEscape(assetsVersioned('css/visitor.css')); ?>">
    <?php endif; ?>

    <template id="rasamala-header-config"><?= themeEscape(json_encode($rasamala_header['header_config'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT)); ?></template>

    <?php if ($rasamala_header['custom_css'] !== '') : ?>
    <style nonce="<?= themeCspNonce(); ?>">
      /* Custom CSS */
      <?= themeSanitizeCustomCss($rasamala_header['custom_css']); ?>
    </style>
    <?php endif; ?>

    <link rel="shortcut icon" href="<?= themeEscape($rasamala_header['icon']) ?>" type="image/x-icon"/>

    <!-- PWA Manifest & Web App Meta Tags -->
    <link rel="manifest" href="<?= assetsVersioned('manifest.json.php'); ?>">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="<?= themeEscape($sysconf['library_name'] ?? 'SLiMS OPAC'); ?>">
    <link rel="apple-touch-icon" href="<?= themeEscape($rasamala_header['icon']); ?>">

    <?php
    // Store core extension JS tags for footer deferred output
    $rasamala_core_extension_js = '';
    if (isset($js)):
        $rasamala_core_extension_js = themeSanitizeCoreAssetTags($js);
    endif;
    ?>
</head>
<body class="<?= themeEscape($rasamala_header['body_classes']); ?>" data-cursor-particles="<?= themeEscape(themeEffectiveTemplateValue('classic_cursor_particles', 'none', $sysconf)); ?>" data-cursor-custom-icon="<?= themeEscape(themeEffectiveTemplateValue('classic_cursor_custom_icon', 'default', $sysconf)); ?>">
<a href="#main-content" class="skip-to-content"><?= themeEscape(__('Skip to main content')); ?></a>
<?php if ($rasamala_header['background_animation_enabled'] || $rasamala_header['palette_switcher_show']) : ?>
<div id="background-animation-layer"
     class="background-animation-layer hero-animation-layer hero-animation-<?= themeEscape($rasamala_header['background_animation']); ?>"
     data-animation="<?= themeEscape($rasamala_header['background_animation']); ?>"
     data-speed-multiplier="<?= themeEscape($rasamala_header['speed_mult']); ?>"
     aria-hidden="true"
     <?= !$rasamala_header['background_animation_enabled'] ? 'hidden' : ''; ?>></div>
<?php endif; ?>
<div id="rasamala-background-image-layer" class="rasamala-background-image-layer" aria-hidden="true"></div>
<div id="rasamala-theme-wave-layer" class="rasamala-theme-wave-layer" aria-hidden="true">
    <svg class="rasamala-theme-wave-svg" viewBox="0 0 1440 320" preserveAspectRatio="none" focusable="false">
        <path class="rasamala-theme-wave-back" d="M0,192L48,197.3C96,203,192,213,288,229.3C384,245,480,267,576,250.7C672,235,768,181,864,181.3C960,181,1056,235,1152,234.7C1248,235,1344,181,1392,154.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        <path class="rasamala-theme-wave-front" d="M0,256L48,245.3C96,235,192,213,288,192C384,171,480,149,576,165.3C672,181,768,235,864,250.7C960,267,1056,245,1152,224C1248,203,1344,181,1392,170.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
    </svg>
</div>
