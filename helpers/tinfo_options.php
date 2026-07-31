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
require_once __DIR__ . '/theme_feature_flags.php';

// ----------------------------------------------------------------------------
// Load Modular Theme Option Definitions
// ----------------------------------------------------------------------------
$theme = $sysconf['template']['theme'] ?? 'rasamala';

$rasamala_tinfo_option_files = [
    __DIR__ . '/options/tinfo_option_general.php',
    __DIR__ . '/options/tinfo_option_navbar.php',
    __DIR__ . '/options/tinfo_option_hero.php',
    __DIR__ . '/options/tinfo_option_content.php',
    __DIR__ . '/options/tinfo_option_footer.php',
    __DIR__ . '/options/tinfo_option_display.php',
    __DIR__ . '/options/tinfo_option_visitor.php',
];
$rasamala_tinfo_options = [];
foreach ($rasamala_tinfo_option_files as $rasamala_tinfo_option_file) {
    $rasamala_tinfo_options = array_merge(
        $rasamala_tinfo_options,
        rasamalaFilterDisabledTinfoOptions(require $rasamala_tinfo_option_file)
    );
}
$sysconf['template']['option'][$theme] = $rasamala_tinfo_options;

// ----------------------------------------------------------------------------
// Load Theme Admin Customizer UI Bootstrapper
// ----------------------------------------------------------------------------
require_once __DIR__ . '/options/tinfo_option_customizer_loader.php';
