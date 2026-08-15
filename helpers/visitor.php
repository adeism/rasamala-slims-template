<?php
/**
 * Helper Module for Rasamala Template - Visitor Portal Utilities
 */
if (!defined('INDEX_AUTH') || INDEX_AUTH != 1) {
  die("can not access this file directly");
}

if (!function_exists('themeVisitorSetLanguage')) {
  function themeVisitorSetLanguage(&$sysconf, $available_languages = [])
  {
    if (isset($_GET['select_lang'])) {
        $select_lang = preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['select_lang']);
        $is_valid_lang = false;
        if (isset($available_languages) && is_array($available_languages)) {
            foreach ($available_languages as $lang_index) {
                if (($lang_index[0] ?? '') === $select_lang) {
                    $is_valid_lang = true;
                    break;
                }
            }
        }
        if ($is_valid_lang) {
            if (isset($_COOKIE['select_lang'])) {
                @setcookie('select_lang', $select_lang, [
                    'expires' => time()-14400,
                    'path' => SWB,
                    'domain' => '',
                    'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
                    'httponly' => true,
                    'samesite' => 'Lax',
                ]);
            }
            @setcookie('select_lang', $select_lang, [
                'expires' => time()+14400,
                'path' => SWB,
                'domain' => '',
                'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
            $sysconf['default_lang'] = $select_lang;
        }
    } else if (isset($_COOKIE['select_lang'])) {
        $select_lang = preg_replace('/[^a-zA-Z0-9_-]/', '', $_COOKIE['select_lang']);
        $is_valid_lang = false;
        if (isset($available_languages) && is_array($available_languages)) {
            foreach ($available_languages as $lang_index) {
                if (($lang_index[0] ?? '') === $select_lang) {
                    $is_valid_lang = true;
                    break;
                }
            }
        }
        if ($is_valid_lang) {
            $sysconf['default_lang'] = $select_lang;
        }
    }
  }
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

if (!function_exists('rasamalaVisitorSplitDefaultSteps')) {
    function rasamalaVisitorSplitDefaultSteps()
    {
        return [
            [
                'icon' => 'fas fa-book',
                'title' => 'Masuk ke Portal Perpustakaan',
                'description' => 'Buka portal perpustakaan dan masuk menggunakan akun anggota.'
            ],
            [
                'icon' => 'scan',
                'title' => 'Scan atau Ketik',
                'description' => 'Arahkan Kode QR ke alat pemindai, atau ketik nomor anggota/NPM/NIM/ID secara manual.'
            ],
            [
                'icon' => 'fas fa-check',
                'title' => 'Konfirmasi Berhasil',
                'description' => 'Setelah berhasil, layar menampilkan konfirmasi kunjungan dan informasi antrean berikutnya.'
            ]
        ];
    }
}

/**
 * Theme Viewer stores longtext values in a few different ways depending
 * on the SLiMS version (real newlines, the literal "\\n", or <br>). Keep
 * those representations equivalent before parsing the one-step-per-line
 * format.
 */
if (!function_exists('rasamalaVisitorSplitNormalizeText')) {
    function rasamalaVisitorSplitNormalizeText($raw_steps)
    {
        $raw_steps = (string)($raw_steps ?? '');
        $raw_steps = str_replace(["\\r\\n", "\\n", "\\r"], ["\n", "\n", "\r"], $raw_steps);
        // Some TInfo editors collapse textarea line breaks. The explicit
        // double-semicolon separator keeps the format reliable in that case.
        if (strpos($raw_steps, "\n") === false && strpos($raw_steps, ';;') !== false) {
            $raw_steps = str_replace(';;', "\n", $raw_steps);
        }
        return trim($raw_steps);
    }
}

if (!function_exists('rasamalaVisitorSplitSteps')) {
    function rasamalaVisitorSplitSteps($raw_steps)
    {
        $raw_steps = rasamalaVisitorSplitNormalizeText($raw_steps);

        if ($raw_steps === '') {
            return rasamalaVisitorSplitDefaultSteps();
        }
        // Do not carry the old site-specific demo copy into a general
        // library template. It is replaced by the neutral defaults below.
        if (stripos($raw_steps, 'psb.feb.ui.ac.id') !== false || stripos($raw_steps, 'Login Web PSB') !== false) {
            return rasamalaVisitorSplitDefaultSteps();
        }

        $steps = [];
        foreach (preg_split('/\r\n|\r|\n/', $raw_steps) as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }

            $parts = array_map('trim', explode('|', $line, 3));
            if (count($parts) === 1) {
                $icon = 'fas fa-info-circle';
                $title = $parts[0];
                $description = '';
            } elseif (count($parts) === 2) {
                $icon = $parts[0] !== '' ? $parts[0] : 'fas fa-info-circle';
                $title = $parts[1];
                $description = '';
            } else {
                [$icon, $title, $description] = $parts;
                $icon = $icon !== '' ? $icon : 'fas fa-info-circle';
            }

            if ($title === '' && $description === '') {
                continue;
            }

            $steps[] = [
                'icon' => $icon,
                'title' => $title !== '' ? $title : 'Info',
                'description' => $description
            ];
        }

        return $steps ?: rasamalaVisitorSplitDefaultSteps();
    }
}

if (!function_exists('rasamalaVisitorSplitDefaultHtml')) {
    function rasamalaVisitorSplitDefaultHtml()
    {
        return '<div class="inst-step">'
            . '<div class="inst-icon-box"><i class="fas fa-book"></i></div>'
            . '<div class="inst-content"><h3>1. Masuk ke Portal Perpustakaan</h3><p>Buka portal perpustakaan dan masuk menggunakan akun anggota.</p></div>'
            . '</div>'
            . '<div class="inst-step inst-step-featured">'
            . '<div class="inst-icon-box inst-icon-box-scan"><i class="fas fa-qrcode"></i></div>'
            . '<div class="inst-content"><h3>2. Scan atau Ketik</h3><p>Arahkan Kode QR ke alat pemindai, atau ketik nomor anggota/NPM/NIM/ID secara manual.</p></div>'
            . '</div>'
            . '<div class="inst-step">'
            . '<div class="inst-icon-box"><i class="fas fa-check"></i></div>'
            . '<div class="inst-content"><h3>3. Konfirmasi Berhasil</h3><p>Setelah berhasil, layar menampilkan konfirmasi kunjungan dan informasi antrean berikutnya.</p></div>'
            . '</div>';
    }
}

if (!function_exists('rasamalaVisitorSplitIcon')) {
    function rasamalaVisitorSplitIcon($icon)
    {
        $icon = preg_replace('/\s+/', ' ', trim((string)($icon ?? '')));
        if (preg_match('/^(scan|barcode|qr|qrcode)$/i', $icon)) {
            return [
                'is_scan' => true,
                'html' => '<div class="scan-anim-container" aria-hidden="true"><svg class="barcode-svg" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg"><path d="M4 4h4v56H4zM12 4h2v56h-2zM20 4h4v56h-4zM28 4h2v56h-2zM36 4h4v56h-4zM44 4h2v56h-2zM52 4h8v56h-8z"/></svg><div class="scan-laser"></div></div>'
            ];
        }

        if (preg_match('/^(fa[brs]?|fas|far|fab)\s+[a-z0-9 _-]+$/i', $icon)) {
            return [
                'is_scan' => false,
                'html' => '<i class="' . themeEscape($icon) . '" aria-hidden="true"></i>'
            ];
        }

        return [
            'is_scan' => false,
            'html' => themeEscape($icon !== '' ? $icon : 'i')
        ];
    }
}

if (!function_exists('rasamalaVisitorSplitRenderCards')) {
    function rasamalaVisitorSplitRenderCards($steps)
    {
        $html = '';
        foreach (array_values((array)$steps) as $visitor_step_index => $visitor_step) {
            $visitor_step_icon = rasamalaVisitorSplitIcon($visitor_step['icon'] ?? '');
            $visitor_step_title = preg_replace('/^\d+\s*[.)-]\s*/', '', (string)($visitor_step['title'] ?? 'Info'));
            $visitor_step_title = trim((string)$visitor_step_title);
            $html .= '<div class="inst-step' . ($visitor_step_icon['is_scan'] ? ' inst-step-featured' : '') . '">';
            $html .= '<div class="inst-icon-box' . ($visitor_step_icon['is_scan'] ? ' inst-icon-box-scan' : '') . '">' . $visitor_step_icon['html'] . '</div>';
            $html .= '<div class="inst-content">';
            $html .= '<h3>' . themeEscape(($visitor_step_index + 1) . '. ' . ($visitor_step_title !== '' ? $visitor_step_title : 'Info')) . '</h3>';
            if (trim((string)($visitor_step['description'] ?? '')) !== '') {
                $html .= '<p>' . themeSanitizeHtml($visitor_step['description']) . '</p>';
            }
            $html .= '</div></div>';
        }

        return $html;
    }
}

if (!function_exists('rasamalaVisitorSplitLegacyHtml')) {
    function rasamalaVisitorSplitLegacyHtml($raw_steps)
    {
        $html = rasamalaVisitorSplitRenderCards(rasamalaVisitorSplitSteps($raw_steps));
        return $html !== '' ? $html : rasamalaVisitorSplitDefaultHtml();
    }
}

if (!function_exists('rasamalaVisitorSplitHasHtml')) {
    function rasamalaVisitorSplitHasHtml($raw_steps)
    {
        return preg_match('/<\s*\/?\s*(div|p|ul|ol|li|h[1-6]|blockquote|table|span|strong|em|a|i|br|hr|img)\b/i', (string)$raw_steps) === 1;
    }
}

if (!function_exists('rasamalaVisitorSplitHasStepContainer')) {
    function rasamalaVisitorSplitHasStepContainer($raw_steps)
    {
        return preg_match('/class\s*=\s*(["\'])(?:(?!\1).)*\binst-step\b(?:(?!\1).)*\1/i', (string)$raw_steps) === 1;
    }
}

if (!function_exists('rasamalaVisitorSplitWrapHtml')) {
    function rasamalaVisitorSplitWrapHtml($raw_steps)
    {
        return '<div class="inst-step">'
            . '<div class="inst-icon-box"><i class="fas fa-info-circle"></i></div>'
            . '<div class="inst-content">' . $raw_steps . '</div>'
            . '</div>';
    }
}

if (!function_exists('rasamalaVisitorSplitNumberHtml')) {
    /** Add the visible sequence number when custom HTML headings omit it. */
    function rasamalaVisitorSplitNumberHtml($html)
    {
        $step_number = 0;
        return preg_replace_callback('/<h3\b([^>]*)>(.*?)<\/h3\s*>/is', function ($matches) use (&$step_number) {
            $heading = (string)($matches[2] ?? '');
            $plain_heading = trim(html_entity_decode(strip_tags($heading), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            if ($plain_heading === '') {
                return $matches[0];
            }

            if (preg_match('/^(\d+)\s*[.)-]\s*/', $plain_heading, $number_match)) {
                $step_number = max($step_number, (int)$number_match[1]);
                return $matches[0];
            }

            $step_number++;
            return '<h3' . $matches[1] . '>' . $step_number . '. ' . $heading . '</h3>';
        }, (string)$html);
    }
}

if (!function_exists('rasamalaVisitorSplitUnwrappedHtml')) {
    /**
     * Convert repeated h3 blocks into separate cards when the Theme Viewer
     * value has lost its .inst-step wrappers.
     */
    function rasamalaVisitorSplitUnwrappedHtml($html)
    {
        $html = (string)$html;
        preg_match_all('/<h3\b[^>]*>.*?<\/h3\s*>/is', $html, $heading_matches, PREG_OFFSET_CAPTURE);
        if (count($heading_matches[0]) < 2) {
            return '';
        }

        $steps = [];
        $default_icons = ['fas fa-book', 'scan', 'fas fa-check'];
        foreach ($heading_matches[0] as $index => $heading_match) {
            $heading_html = (string)$heading_match[0];
            $heading_offset = (int)$heading_match[1];
            $heading_end = $heading_offset + strlen($heading_html);
            $next_offset = isset($heading_matches[0][$index + 1])
                ? (int)$heading_matches[0][$index + 1][1]
                : strlen($html);
            $title = preg_replace('/^<h3\b[^>]*>|<\/h3\s*>$/i', '', $heading_html);
            $title = trim(strip_tags((string)$title));
            $description = trim(strip_tags(substr($html, $heading_end, max(0, $next_offset - $heading_end))));
            if ($title === '') {
                continue;
            }

            $steps[] = [
                'icon' => $default_icons[$index] ?? 'fas fa-info-circle',
                'title' => $title,
                'description' => $description,
            ];
        }

        return $steps ? rasamalaVisitorSplitRenderCards($steps) : '';
    }
}

if (!function_exists('rasamalaVisitorSplitStepsHtml')) {
    function rasamalaVisitorSplitStepsHtml($raw_steps)
    {
        $raw_steps = rasamalaVisitorSplitNormalizeText($raw_steps);
        if ($raw_steps === '') {
            return themeSanitizeHtml(rasamalaVisitorSplitDefaultHtml());
        }
        if (stripos($raw_steps, 'psb.feb.ui.ac.id') !== false || stripos($raw_steps, 'Login Web PSB') !== false) {
            return themeSanitizeHtml(rasamalaVisitorSplitDefaultHtml());
        }
        $html_steps = html_entity_decode($raw_steps, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        if (rasamalaVisitorSplitHasHtml($html_steps)) {
            $unwrapped_steps = rasamalaVisitorSplitUnwrappedHtml($html_steps);
            if ($unwrapped_steps !== '') {
                return $unwrapped_steps;
            }
        }

        // Some older Theme Viewer builds turn line breaks into <br>. Treat
        // that as the documented line-oriented format unless full step HTML
        // was supplied explicitly.
        if (!rasamalaVisitorSplitHasStepContainer($html_steps) && preg_match('/<br\s*\/?\s*>/i', $html_steps)) {
            $line_steps = preg_replace('/<br\s*\/?\s*>/i', "\n", $html_steps);
            return rasamalaVisitorSplitLegacyHtml(strip_tags((string)$line_steps));
        }

        if (rasamalaVisitorSplitHasHtml($html_steps)) {
            $html_steps = rasamalaVisitorSplitNumberHtml($html_steps);
            return themeSanitizeHtml(
                rasamalaVisitorSplitHasStepContainer($html_steps)
                    ? $html_steps
                    : rasamalaVisitorSplitWrapHtml($html_steps)
            );
        }

        return rasamalaVisitorSplitLegacyHtml($raw_steps);
    }
}
