<?php
# @Author: Ade Ismail Siregar <adeismailbox@gmail.com>
# @Based on: SLiMS Bulian 9.8 Default Template by Waris Agung Widodo <ido.alit@gmail.com>
# @Date: 2026-08-06T07:43:00+07:00
# @Filename: login_template.inc.php

if (isset($_GET['p']) && $_GET['p'] === 'visitor') {
  // Storage API is available in newer SLiMS releases, but not in 9.5.0.
  // Keep it optional so the template can fall back to the regular images path.
  $imagesDisk = null;
  if (class_exists('\\SLiMS\\Filesystems\\Storage')) {
    $imagesDisk = \SLiMS\Filesystems\Storage::images();
  }
  include_once "classic.php";
  include "parts/header.php";
  echo '<script src="' . themeEscape(JWB . 'jquery.js') . '"></script>';
  echo $main_content;
  echo '<script src="' . themeEscape(assetsVersioned('js/motion_lifecycle.js')) . '" defer></script>';
  // Visitor counter depends on Vue and Axios. Deferred scripts retain document order.
  echo '<script src="' . themeEscape(assets('js/vue.min.js')) . '" defer></script>';
  echo '<script src="' . themeEscape(assets('js/axios.min.js')) . '" defer></script>';
  echo '<script src="' . themeEscape(assetsVersioned('js/visitor_counter.js')) . '" defer></script>';
  echo '<script src="' . themeEscape(assetsVersioned('js/color_mode.js')) . '" defer></script>';
  echo '<script src="' . themeEscape(assetsVersioned('js/service-worker-cleanup.js')) . '" defer></script>';
  $visitor_palette_switcher_show = (int)themeEffectiveTemplateValue('classic_palette_switcher_show', 0, $sysconf) === 1;
  if ($visitor_palette_switcher_show) {
    include __DIR__ . '/parts/palette_switcher.php';
    echo '<script src="' . themeEscape(assetsVersioned('js/palette_switcher.js')) . '" defer></script>';
    echo '<script src="' . themeEscape(assetsVersioned('js/theme_drawer.js')) . '" defer></script>';
    echo '<script src="' . themeEscape(assetsVersioned('js/theme_viewer.js')) . '" defer></script>';
  }
  echo '</body></html>';
} else {
  include "index_template.inc.php";
}
