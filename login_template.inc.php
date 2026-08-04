<?php
/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 2019-01-29 22:16
 * @File name           : login_template.inc.php
 * @Last modified by    : Ade Ismail Siregar (adeismailbox@gmail.com)
 * @Last modified time  : 2026-07-09T10:16:23+07:00
 */

if (isset($_GET['p']) && $_GET['p'] === 'visitor') {
  $imagesDisk = \SLiMS\Filesystems\Storage::images();
  include_once "classic.php";
  include "parts/header.php";
  echo $main_content;
  echo '<script src="' . themeEscape(assetsVersioned('js/motion_lifecycle.js')) . '" defer></script>';
  // Visitor counter depends on Vue and Axios. Deferred scripts retain document order.
  echo '<script src="' . themeEscape(assets('js/vue.min.js')) . '" defer></script>';
  echo '<script src="' . themeEscape(assets('js/axios.min.js')) . '" defer></script>';
  echo '<script src="' . themeEscape(assetsVersioned('js/visitor_counter.js')) . '" defer></script>';
  echo '<script src="' . themeEscape(assetsVersioned('js/color_mode.js')) . '" defer></script>';
  echo '<script src="' . themeEscape(assetsVersioned('js/service-worker-cleanup.js')) . '" defer></script>';
  echo '</body></html>';
} else {
  include "index_template.inc.php";
}
