<!--
# ===============================
# Classic SLiMS Template
# ===============================
# @Author: Waris Agung Widodo
# @Email:  ido.alit@gmail.com
# @Date:   2018-01-23T11:25:57+07:00
# @Last modified by:   Ade Ismail Siregar (adeismailbox@gmail.com)
# @Last modified time: 2026-07-09T14:45:38+07:00
-->
<?php
// clean request uri from xss
$request_uri = urlencode(strip_tags(urldecode($_SERVER['REQUEST_URI'])));
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
    <?php echo $metadata;?>
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
    <meta property="og:url" content="//<?php echo themeEscape($_SERVER["SERVER_NAME"] . $request_uri); ?>"/>
    <meta property="og:site_name" content="<?php echo themeEscape($sysconf['library_name']); ?>"/>
    <?php if (isset($_GET['p']) && ($_GET['p'] == 'show_detail')): ?>
        <meta property="og:image" content="//<?php echo themeEscape($_SERVER["SERVER_NAME"] . SWB . $image_src) ?>"/>
    <?php else: ?>
        <meta property="og:image"
              content="//<?php echo themeEscape($_SERVER["SERVER_NAME"] . SWB . $sysconf['template']['dir']); ?>/default/img/logo.png"/>
    <?php endif; ?>

    <meta name="twitter:card" content="summary">
    <meta name="twitter:url" content="//<?php echo themeEscape($_SERVER["SERVER_NAME"] . $request_uri); ?>"/>
    <meta name="twitter:title" content="<?php echo themeEscape($page_title); ?>"/>
    <?php if (isset($_GET['p']) && ($_GET['p'] == 'show_detail')): ?>
        <meta property="twitter:image" content="//<?php echo themeEscape($_SERVER["SERVER_NAME"] . SWB . $image_src) ?>"/>
    <?php else: ?>
        <meta property="twitter:image"
              content="//<?php echo themeEscape($_SERVER["SERVER_NAME"] . SWB . $sysconf['template']['dir']); ?>/default/img/logo.png"/>
    <?php endif; ?>
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
    <!-- // my custom style -->
    <link rel="stylesheet" href="<?php echo assetsVersioned('css/style.css'); ?>">

    <?php
    $selected_color = themeSelectedAccentColor($sysconf['template']['classic_theme_color'] ?? 'warmgray');
    $ticker_speed_val = '32s';
    $ticker_speed = $sysconf['template']['classic_ticker_speed'] ?? 'normal';
    if ($ticker_speed === 'slow') {
        $ticker_speed_val = '48s';
    } elseif ($ticker_speed === 'fast') {
        $ticker_speed_val = '18s';
    }

    $font_family = $sysconf['template']['classic_font_family'] ?? 'system';
    $font_link = '';
    $font_css = '';
    if ($font_family === 'inter') {
        $font_link = '<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700&display=swap" rel="stylesheet">';
        $font_css = "body, button, input, select, textarea, .form-control { font-family: 'Inter', sans-serif !important; }";
    } elseif ($font_family === 'roboto') {
        $font_link = '<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">';
        $font_css = "body, button, input, select, textarea, .form-control { font-family: 'Roboto', sans-serif !important; }";
    } elseif ($font_family === 'poppins') {
        $font_link = '<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">';
        $font_css = "body, button, input, select, textarea, .form-control { font-family: 'Poppins', sans-serif !important; }";
    } elseif ($font_family === 'playfair') {
        $font_link = '<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">';
        $font_css = "body, button, input, select, textarea, .form-control { font-family: 'Playfair Display', serif !important; }";
    }
    if (!empty($font_link)) {
        echo $font_link;
    }
    ?>
    <style>
      :root {
        --apple-text-secondary: <?php echo themeEscape($selected_color['primary']); ?>;
        --apple-accent: <?php echo themeEscape($selected_color['primary']); ?>;
        --apple-accent-hover: <?php echo themeEscape($selected_color['hover']); ?>;
        --theme-accent-color: <?php echo themeEscape($selected_color['primary']); ?>;
        --theme-accent-rgb: <?php echo themeEscape($selected_color['rgb']); ?>;
        --theme-accent-glow: rgba(<?php echo themeEscape($selected_color['rgb']); ?>, 0.8);
        --theme-accent-glow-half: rgba(<?php echo themeEscape($selected_color['rgb']); ?>, 0.4);
        --ticker-speed: <?php echo themeEscape($ticker_speed_val); ?>;
      }
      <?php if (!empty($font_css)) { echo $font_css; } ?>
    </style>

    <?php if (!empty($sysconf['template']['classic_custom_css'] ?? '')) : ?>
    <style>
      /* Custom CSS Injection */
      <?= $sysconf['template']['classic_custom_css']; ?>
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
    <script src="<?php echo JWB; ?>toastr/toastr.min.js"></script>
    <!-- // load SLiMS javascript -->
    <script src="<?php echo JWB; ?>colorbox/jquery.colorbox-min.js"></script>
    <script src="<?php echo JWB . v('gui.js'); ?>"></script>
    <script src="<?php echo JWB; ?>fancywebsocket.js"></script>
    <script src="<?php echo JWB; ?>ion.rangeSlider/js/ion.rangeSlider.min.js"></script>
    <?php
    if (isset($js)):
        echo $js;
    endif;
    ?>

</head>
<?php
$background_animation = themeBackgroundAnimation();
$background_animation_enabled = $background_animation !== 'none';
$body_classes = 'bg-light rasamala-theme';
if ($background_animation_enabled) {
    $body_classes .= ' rasamala-background-animation-active rasamala-background-animation-' . $background_animation;
}
$mobile_bottom_nav_enabled = (($sysconf['template']['classic_mobile_bottom_nav_show'] ?? 1) == 1);
$body_classes .= $mobile_bottom_nav_enabled ? ' mobile-bottom-nav-enabled' : ' mobile-bottom-nav-hidden';
?>
<body class="<?php echo themeEscape($body_classes); ?>">
<script>
(function () {
    try {
        if (window.localStorage.getItem('rasamala-color-mode') === 'dark') {
            document.body.classList.add('rasamala-dark');
        }
    } catch (error) {}
}());
</script>
<?php if ($background_animation_enabled) :
$anim_speed = $sysconf['template']['classic_background_animation_speed'] ?? 'normal';
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
