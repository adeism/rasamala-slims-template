<?php
/**
 * Helper Module for Rasamala Template
 */
if (!defined('INDEX_AUTH') || INDEX_AUTH != 1) {
  die("can not access this file directly");
}

if (!function_exists('themeVisitorDefaultInstitutionOptions')) {
  function themeVisitorDefaultInstitutionOptions()
  {
    return [
      ['value' => 'feb', 'label' => 'Fakultas Ekonomi dan Bisnis UI', 'manual' => false],
      ['value' => 'ff', 'label' => 'Fakultas Farmasi UI', 'manual' => false],
      ['value' => 'fh', 'label' => 'Fakultas Hukum UI', 'manual' => false],
      ['value' => 'fia', 'label' => 'Fakultas Ilmu Administrasi UI', 'manual' => false],
      ['value' => 'fib', 'label' => 'Fakultas Ilmu Budaya UI', 'manual' => false],
      ['value' => 'fik', 'label' => 'Fakultas Ilmu Keperawatan UI', 'manual' => false],
      ['value' => 'fasilkom', 'label' => 'Fakultas Ilmu Komputer UI', 'manual' => false],
      ['value' => 'fisip', 'label' => 'Fakultas Ilmu Sosial dan Ilmu Politik UI', 'manual' => false],
      ['value' => 'fk', 'label' => 'Fakultas Kedokteran UI', 'manual' => false],
      ['value' => 'fkg', 'label' => 'Fakultas Kedokteran Gigi UI', 'manual' => false],
      ['value' => 'fkm', 'label' => 'Fakultas Kesehatan Masyarakat UI', 'manual' => false],
      ['value' => 'fmipa', 'label' => 'Fakultas Matematika dan Ilmu Pengetahuan Alam UI', 'manual' => false],
      ['value' => 'fpsi', 'label' => 'Fakultas Psikologi UI', 'manual' => false],
      ['value' => 'ft', 'label' => 'Fakultas Teknik UI', 'manual' => false],
      ['value' => 'vokasi', 'label' => 'Program Vokasi UI', 'manual' => false],
      ['value' => 'other', 'label' => 'Lainnya (ketik manual)', 'manual' => true],
    ];
  }
}

if (!function_exists('themeVisitorInstitutionOptionText')) {
  function themeVisitorInstitutionOptionText($value)
  {
    $value = preg_replace('/[\x00-\x1f\x7f]/', '', strip_tags((string)$value));
    $value = preg_replace('/\s+/', ' ', trim($value));

    return $value;
  }
}

if (!function_exists('themeVisitorInstitutionOptionIsManual')) {
  function themeVisitorInstitutionOptionIsManual($value, $label, $marker = '')
  {
    $marker = strtolower(themeVisitorInstitutionOptionText($marker));
    if (in_array($marker, ['1', 'yes', 'true', 'manual', 'other', 'lainnya', 'custom'], true)) {
      return true;
    }

    $hint = strtolower(str_replace(['_', '-', '(', ')'], ' ', themeVisitorInstitutionOptionText($value . ' ' . $label)));
    return preg_match('/(^|\s)(lainnya|other|manual)(\s|$)/i', $hint) === 1;
  }
}

if (!function_exists('themeVisitorInstitutionOptionMarkerIsManual')) {
  function themeVisitorInstitutionOptionMarkerIsManual($marker)
  {
    return in_array(strtolower(themeVisitorInstitutionOptionText($marker)), ['1', 'yes', 'true', 'manual', 'custom'], true);
  }
}

if (!function_exists('themeVisitorInstitutionOptionLooksCompact')) {
  function themeVisitorInstitutionOptionLooksCompact($entry)
  {
    $entry = themeVisitorInstitutionOptionText($entry);
    if (preg_match('/^([A-Za-z0-9_.-]+)\s*\(.+\)$/', $entry, $matches)
        && strtolower($matches[1] ?? '') === 'lainnya') {
      return false;
    }

    return preg_match('/^[A-Za-z0-9_.-]+\s*\(.+\)$/', $entry) === 1 || strtolower($entry) === 'other';
  }
}

if (!function_exists('themeVisitorInstitutionOptions')) {
  function themeVisitorInstitutionOptions($raw_options)
  {
    $raw_options = trim((string)($raw_options ?? ''));
    if ($raw_options === '') {
      return themeVisitorDefaultInstitutionOptions();
    }

    $options = [];
    $seen_values = [];
    $add_option = function ($value, $label = '', $marker = '') use (&$options, &$seen_values) {
      if (count($options) >= 100) {
        return;
      }

      $value = themeVisitorInstitutionOptionText($value);
      $label = themeVisitorInstitutionOptionText($label);
      if ($label === '') {
        $label = $value;
      }
      if ($value === '') {
        $value = $label;
      }
      if ($value === '' || isset($seen_values[$value])) {
        return;
      }

      $seen_values[$value] = true;
      $options[] = [
        'value' => $value,
        'label' => $label,
        'manual' => themeVisitorInstitutionOptionIsManual($value, $label, $marker),
      ];
    };
    $add_compact_entry = function ($entry) use (&$add_option) {
      $entry = themeVisitorInstitutionOptionText($entry);
      if ($entry === '') {
        return;
      }

      if (preg_match('/^([A-Za-z0-9_.-]+)\s*\((.*)\)$/', $entry, $matches)) {
        $value = themeVisitorInstitutionOptionText($matches[1] ?? '');
        $label = themeVisitorInstitutionOptionText($matches[2] ?? '');
        $add_option($value, $label !== '' ? $label : $value);
        return;
      }

      if (strtolower($entry) === 'other') {
        $add_option('other', 'Lainnya (ketik manual)', 'manual');
        return;
      }

      $add_option($entry, $entry);
    };

    foreach (preg_split('/\r\n|\r|\n/', $raw_options) as $line) {
      if (count($options) >= 100) {
        break;
      }

      $line = trim($line);
      if ($line === '') {
        continue;
      }

      $raw_tokens = array_values(array_filter(array_map('trim', explode(';', $line)), function ($token) {
        return $token !== '';
      }));
      $compact_format = false;
      foreach ($raw_tokens as $token) {
        if (themeVisitorInstitutionOptionLooksCompact($token)) {
          $compact_format = true;
          break;
        }
      }
      if ($compact_format) {
        foreach ($raw_tokens as $token) {
          $add_compact_entry($token);
        }
        continue;
      }

      if (strpos($line, ';') === false && strpos($line, '|') !== false) {
        $parts = array_map('trim', explode('|', $line, 3));
        $add_option($parts[0] ?? '', $parts[1] ?? ($parts[0] ?? ''), $parts[2] ?? '');
        continue;
      }

      $tokens = $raw_tokens;
      $token_count = count($tokens);
      for ($index = 0; $index < $token_count; $index += 2) {
        $value = $tokens[$index] ?? '';
        $label = $tokens[$index + 1] ?? $value;
        $marker = '';
        if (($index + 2) < $token_count && themeVisitorInstitutionOptionMarkerIsManual($tokens[$index + 2])) {
          $marker = $tokens[$index + 2];
          $index++;
        }

        $add_option($value, $label, $marker);
      }
    }

    return $options ?: themeVisitorDefaultInstitutionOptions();
  }
}

if (!function_exists('themeVisitorInstitutionManualValue')) {
  function themeVisitorInstitutionManualValue($options)
  {
    if (!is_array($options)) {
      return '';
    }

    foreach ($options as $option) {
      if (!empty($option['manual']) && isset($option['value'])) {
        return (string)$option['value'];
      }
    }

    return '';
  }
}
