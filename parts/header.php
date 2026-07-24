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
?>
<!DOCTYPE html>
<html lang="<?php echo themeEscape($rasamala_header['document_lang']); ?>">
<head>
    <meta charset="utf-8">
    <!-- Basic CSP: unsafe-inline/unsafe-eval are retained while the theme still uses inline styles, legacy extension points, and Vue runtime template compilation. -->
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; base-uri 'self'; object-src 'none'; form-action 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline'; img-src 'self' data: https:; font-src 'self' data:; connect-src 'self'; frame-src 'self' https://www.google.com https://maps.google.com;">
    <title><?php echo themeEscape($page_title); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, post-check=0, pre-check=0"/>
    <meta http-equiv="Expires" content="Sat, 26 Jul 1997 05:00:00 GMT"/>
    <?php echo themeSanitizeMetadata($metadata ?? ''); ?>
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
    <meta property="og:url" content="//<?php echo themeEscape($rasamala_host . $rasamala_header['request_uri']); ?>"/>
    <meta property="og:site_name" content="<?php echo themeEscape($sysconf['library_name']); ?>"/>
    <meta property="og:image" content="//<?php echo themeEscape(($_SERVER['SERVER_NAME'] ?? '') . SWB . $rasamala_header['meta_image_src']) ?>"/>

    <meta name="twitter:card" content="summary">
    <meta name="twitter:url" content="//<?php echo themeEscape(($_SERVER['SERVER_NAME'] ?? '') . $rasamala_header['request_uri']); ?>"/>
    <meta name="twitter:title" content="<?php echo themeEscape($page_title); ?>"/>
    <meta property="twitter:image" content="//<?php echo themeEscape(($_SERVER['SERVER_NAME'] ?? '') . SWB . $rasamala_header['meta_image_src']) ?>"/>

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
    <link rel="stylesheet" href="<?php echo assetsVersioned('css/foundation.css'); ?>">
    <link rel="stylesheet" href="<?php echo assetsVersioned('css/opac-pages.css'); ?>">
    <link rel="stylesheet" href="<?php echo assetsVersioned('css/theme-components.css'); ?>">
    <link rel="stylesheet" href="<?php echo assetsVersioned('css/header-runtime.css'); ?>">
    <?php if (isset($_GET['p']) && $_GET['p'] === 'visitor') : ?>
    <link rel="stylesheet" href="<?php echo themeEscape(assetsVersioned('css/visitor.css')); ?>">
    <?php endif; ?>

    <template id="rasamala-header-config"><?= themeEscape(json_encode($rasamala_header['header_config'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT)); ?></template>
    <script src="<?php echo assetsVersioned('js/header_bootstrap.js'); ?>"></script>

    <?php if ($rasamala_header['custom_css'] !== '') : ?>
    <style>
      /* Custom CSS */
      <?= $rasamala_header['custom_css']; ?>
    </style>
    <?php endif; ?>

    <link rel="shortcut icon" href="<?= themeEscape($rasamala_header['icon']) ?>" type="image/x-icon"/>

    <!-- PWA Manifest & Web App Meta Tags -->
    <link rel="manifest" href="<?php echo assetsVersioned('manifest.json.php'); ?>">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="<?php echo themeEscape($sysconf['library_name'] ?? 'SLiMS OPAC'); ?>">
    <link rel="apple-touch-icon" href="<?php echo themeEscape($rasamala_header['icon']); ?>">

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
    // Core-only extension point: keep script/link tags but restrict executable attributes and asset URLs.
    if (isset($js)):
        echo themeSanitizeCoreAssetTags($js);
    endif;
    ?>
</head>
<body class="<?php echo themeEscape($rasamala_header['body_classes']); ?>" data-cursor-particles="<?php echo themeEscape(themeEffectiveTemplateValue('classic_cursor_particles', 'auto', $sysconf)); ?>" data-cursor-custom-icon="<?php echo themeEscape(themeEffectiveTemplateValue('classic_cursor_custom_icon', 'default', $sysconf)); ?>">
<a href="#main-content" class="skip-to-content"><?php echo themeEscape(__('Skip to main content')); ?></a>
<?php if ($rasamala_header['background_animation_enabled'] || $rasamala_header['palette_switcher_show']) : ?>
<div id="background-animation-layer"
     class="background-animation-layer hero-animation-layer hero-animation-<?php echo themeEscape($rasamala_header['background_animation']); ?>"
     data-animation="<?php echo themeEscape($rasamala_header['background_animation']); ?>"
     data-speed-multiplier="<?php echo themeEscape($rasamala_header['speed_mult']); ?>"
     aria-hidden="true"
     <?php echo !$rasamala_header['background_animation_enabled'] ? 'hidden' : ''; ?>></div>
<?php endif; ?>
