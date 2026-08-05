<?php
/**
 * Dynamic PWA Web App Manifest for SLiMS Rasamala Theme
 */
if (!defined('INDEX_AUTH')) {
    define('INDEX_AUTH', 1);
}

$sysconf = [];
$sysconf_path = dirname(__DIR__, 3) . '/config/sysconfig.inc.php';
if (is_file($sysconf_path)) {
    @include $sysconf_path;
}

$library_name = trim((string)($sysconf['library_name'] ?? 'SLiMS Library OPAC'));
$library_subname = trim((string)($sysconf['library_subname'] ?? 'Senayan Library Management System'));
$short_name = mb_strimwidth($library_name, 0, 20, '');

$icon_url = '../../../webicon.ico';
if (!empty($sysconf['webicon'])) {
    $icon_url = '../../../images/default/' . rawurlencode($sysconf['webicon']);
} elseif (is_file(dirname(__DIR__, 3) . '/images/default/logo.png')) {
    $icon_url = '../../../images/default/logo.png';
}

$icon_type = preg_match('/\.ico$/i', $icon_url) ? 'image/x-icon' : 'image/png';

header('Content-Type: application/manifest+json; charset=utf-8');
header('Cache-Control: public, max-age=86400');

echo json_encode([
    'name' => $library_name,
    'short_name' => $short_name ?: 'SLiMS OPAC',
    'description' => $library_subname,
    'start_url' => '../../../index.php',
    'scope' => '../../../',
    'display' => 'standalone',
    'background_color' => '#0f172a',
    'theme_color' => '#0f172a',
    'orientation' => 'any',
    'icons' => [
        [
            'src' => $icon_url,
            'sizes' => 'any',
            'type' => $icon_type,
            'purpose' => 'any'
        ]
    ]
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
