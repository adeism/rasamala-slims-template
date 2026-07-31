<?php
/**
 * Rasamala Background Style definitions.
 *
 * Keep the style keys and labels in one place so TInfo, Theme Viewer, and the
 * runtime resolver expose the same options. The actual visual declarations
 * remain in the theme stylesheet; the custom style is safely injected with a
 * CSP nonce by the header helper.
 */
if (!defined('INDEX_AUTH') || INDEX_AUTH != 1) {
  die("can not access this file directly");
}

return [
  'none' => [
    'label' => 'None / Standard',
  ],
  'soft-gradient' => [
    'label' => 'Soft Gradient',
  ],
  'aurora-glow' => [
    'label' => 'Aurora Glow',
  ],
  'mesh-light' => [
    'label' => 'Mesh Light',
  ],
  'glass-surface' => [
    'label' => 'Glass Surface',
  ],
  'solid-theme' => [
    'label' => 'Solid Theme',
  ],
  'minimal-surface' => [
    'label' => 'Minimal Surface',
  ],
  // Reserve the generated key for bg-ocean-waves.svg so this asset uses the
  // theme-colored SVG layer instead of a fixed blue image.
  'image-bg-ocean-waves' => [
    'label' => 'Ocean Waves (Theme Colors)',
    'theme_waves' => true,
  ],
  'custom' => [
    'label' => 'Custom Background Style',
    'custom' => true,
  ],
];
