<?php
/**
 * Shared helpers for Rasamala template.
 * Main entry point loading modular helper files from helpers/
 *
 * @Last modified by    : Ade Ismail Siregar (adeismailbox@gmail.com)
 * @Last modified time  : 2026-07-22T12:26:00+07:00
 */
if (!defined('INDEX_AUTH') || INDEX_AUTH != 1) {
  die("can not access this file directly");
}

require_once __DIR__ . '/helpers/security.php';
require_once __DIR__ . '/helpers/palette.php';
require_once __DIR__ . '/helpers/preset.php';
require_once __DIR__ . '/helpers/navigation.php';
require_once __DIR__ . '/helpers/visitor.php';
require_once __DIR__ . '/helpers/core.php';
require_once __DIR__ . '/helpers/ui.php';
