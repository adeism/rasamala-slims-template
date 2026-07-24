<?php
/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 2020-01-02 15:12
 * @File name           : tinfo_options.inc.php
 */
if (!defined('INDEX_AUTH') || INDEX_AUTH != 1) {
  die("can not access this file directly");
}

require_once __DIR__ . '/language.php';

// ----------------------------------------------------------------------------
// Load Modular Theme Option Definitions
// ----------------------------------------------------------------------------
$theme = $sysconf['template']['theme'] ?? 'rasamala';

$sysconf['template']['option'][$theme] = array_merge(
    require __DIR__ . '/options/tinfo_option_general.php',
    require __DIR__ . '/options/tinfo_option_navbar.php',
    require __DIR__ . '/options/tinfo_option_hero.php',
    require __DIR__ . '/options/tinfo_option_content.php',
    require __DIR__ . '/options/tinfo_option_footer.php',
    require __DIR__ . '/options/tinfo_option_display.php',
    require __DIR__ . '/options/tinfo_option_visitor.php'
);

// ----------------------------------------------------------------------------
// Load Theme Admin Customizer UI Bootstrapper
// ----------------------------------------------------------------------------
require_once __DIR__ . '/options/tinfo_option_customizer_loader.php';
