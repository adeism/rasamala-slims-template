<?php
/**
 * Main SLiMS Core Entry Point for Theme Admin Settings
 */
if (!defined('INDEX_AUTH') || INDEX_AUTH != 1) {
  die("can not access this file directly");
}

require_once __DIR__ . '/helpers/language.php';
require_once __DIR__ . '/helpers/tinfo_options_helper.php';
require_once __DIR__ . '/helpers/tinfo_defaults.php';
require_once __DIR__ . '/helpers/tinfo_options.php';
