<?php
/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 2020-01-03 08:49
 * @File name           : visitor_template.php
 * @Last modified by    : Ade Ismail Siregar (adeismailbox@gmail.com)
 * @Last modified time  : 2026-07-15T12:40:56+07:00
 */

$main_template_path = __DIR__ . '/login_template.inc.php';
include_once __DIR__ . '/classic.php';

// set default language
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
        // delete previous language cookie
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
        // create language cookie
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

$visitor_quote_enabled = ($sysconf['template']['visitor_quote'] ?? 1) == 1;
$visitor_title = themeEffectiveTemplateValue('visitor_title', '', $sysconf);
if (trim((string)$visitor_title) === '') {
    $visitor_title = $sysconf['library_name'] ?? 'SLiMS Library';
}
$visitor_subtitle = themeEffectiveTemplateValue('visitor_subtitle', 'Visitor Check-In Portal', $sysconf);
$visitor_theme_toggle_enabled = (themeEffectiveTemplateValue('visitor_theme_toggle', 1, $sysconf) == 1);
$visitor_layout_style = themeEffectiveTemplateValue('visitor_layout_style', 'kiosk', $sysconf);
$visitor_institution_select_label = trim((string)themeEffectiveTemplateValue('visitor_institution_select_label', __('Pilih Fakultas / Institusi'), $sysconf));
if ($visitor_institution_select_label === '') {
    $visitor_institution_select_label = __('Pilih Fakultas / Institusi');
}
$visitor_institution_options = themeVisitorInstitutionOptions(themeEffectiveTemplateValue('visitor_institution_options', '', $sysconf));
$visitor_other_institution_value = themeVisitorInstitutionManualValue($visitor_institution_options);

if (!function_exists('rasamalaVisitorSplitDefaultSteps')) {
    function rasamalaVisitorSplitDefaultSteps()
    {
        return [
            [
                'icon' => 'fas fa-id-card',
                'title' => 'Isi Identitas',
                'description' => 'Scan kartu anggota atau ketik identitas pengunjung pada kolom yang tersedia.'
            ],
            [
                'icon' => 'scan',
                'title' => 'Proses Kunjungan',
                'description' => 'Sistem akan memeriksa data dan menampilkan status kunjungan secara otomatis.'
            ],
            [
                'icon' => 'fas fa-check',
                'title' => 'Selesai',
                'description' => 'Setelah berhasil, pengunjung dapat melanjutkan aktivitas sesuai layanan yang tersedia.'
            ]
        ];
    }
}

if (!function_exists('rasamalaVisitorSplitSteps')) {
    function rasamalaVisitorSplitSteps($raw_steps)
    {
        $raw_steps = trim((string)($raw_steps ?? ''));
        if (stripos($raw_steps, 'psb.feb.ui.ac.id') !== false || stripos($raw_steps, 'Login Web PSB') !== false) {
            $raw_steps = '';
        }

        if ($raw_steps === '') {
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
            . '<div class="inst-icon-box"><i class="fas fa-id-card"></i></div>'
            . '<div class="inst-content"><h3>1. Isi Identitas</h3><p>Scan kartu anggota atau ketik identitas pengunjung pada kolom yang tersedia.</p></div>'
            . '</div>'
            . '<div class="inst-step inst-step-featured">'
            . '<div class="inst-icon-box"><i class="fas fa-sync-alt"></i></div>'
            . '<div class="inst-content"><h3>2. Proses Kunjungan</h3><p>Sistem akan memeriksa data dan menampilkan status kunjungan secara otomatis.</p></div>'
            . '</div>'
            . '<div class="inst-step">'
            . '<div class="inst-icon-box"><i class="fas fa-check"></i></div>'
            . '<div class="inst-content"><h3>3. Selesai</h3><p>Setelah berhasil, pengunjung dapat melanjutkan aktivitas sesuai layanan yang tersedia.</p></div>'
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

if (!function_exists('rasamalaVisitorSplitLegacyHtml')) {
    function rasamalaVisitorSplitLegacyHtml($raw_steps)
    {
        $html = '';
        foreach (rasamalaVisitorSplitSteps($raw_steps) as $visitor_step_index => $visitor_step) {
            $visitor_step_icon = rasamalaVisitorSplitIcon($visitor_step['icon'] ?? '');
            $html .= '<div class="inst-step' . ($visitor_step_icon['is_scan'] ? ' inst-step-featured' : '') . '">';
            $html .= '<div class="inst-icon-box' . ($visitor_step_icon['is_scan'] ? ' inst-icon-box-scan' : '') . '">' . $visitor_step_icon['html'] . '</div>';
            $html .= '<div class="inst-content">';
            $html .= '<h3>' . themeEscape(($visitor_step_index + 1) . '. ' . ($visitor_step['title'] ?? 'Info')) . '</h3>';
            if (trim((string)($visitor_step['description'] ?? '')) !== '') {
                $html .= '<p>' . themeSanitizeHtml($visitor_step['description']) . '</p>';
            }
            $html .= '</div></div>';
        }

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

if (!function_exists('rasamalaVisitorSplitStepsHtml')) {
    function rasamalaVisitorSplitStepsHtml($raw_steps)
    {
        $raw_steps = trim((string)($raw_steps ?? ''));
        if (stripos($raw_steps, 'psb.feb.ui.ac.id') !== false || stripos($raw_steps, 'Login Web PSB') !== false) {
            $raw_steps = '';
        }
        if ($raw_steps === '') {
            return themeSanitizeHtml(rasamalaVisitorSplitDefaultHtml());
        }
        $html_steps = html_entity_decode($raw_steps, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        if (rasamalaVisitorSplitHasHtml($html_steps)) {
            return themeSanitizeHtml(
                rasamalaVisitorSplitHasStepContainer($html_steps)
                    ? $html_steps
                    : rasamalaVisitorSplitWrapHtml($html_steps)
            );
        }

        return rasamalaVisitorSplitLegacyHtml($raw_steps);
    }
}

$visitor_split_title = trim((string)themeEffectiveTemplateValue('visitor_split_title', 'Petunjuk Penggunaan', $sysconf));
if ($visitor_split_title === '') {
    $visitor_split_title = 'Petunjuk Penggunaan';
}
$visitor_split_steps_html = rasamalaVisitorSplitStepsHtml(themeEffectiveTemplateValue('visitor_split_steps', '', $sysconf));

$visitor_ticker_items = [];
$visitor_ticker_speed = themeEffectiveTemplateValue('classic_ticker_speed', 'normal', $sysconf);
$visitor_ticker_setting = strtolower(trim((string)themeEffectiveTemplateValue('classic_ticker_show', 0, $sysconf)));
$visitor_ticker_enabled = !in_array($visitor_ticker_setting, ['', '0', 'hide', 'none'], true);

if ($visitor_ticker_enabled && isset($dbs) && $dbs && function_exists('themeGetDisplayItems')) {
    $visitor_ticker_limit = themeSafeLimit($sysconf['template']['classic_ticker_item_limit'] ?? 5, 5, 1, 12);
    $raw_visitor_ticker_limit = (int)($sysconf['template']['classic_ticker_char_limit'] ?? 48);
    $visitor_ticker_char_limit = ($raw_visitor_ticker_limit === 0) ? 0 : themeSafeInt($raw_visitor_ticker_limit, 48, 12, 160);
    $visitor_ticker_source = $sysconf['template']['classic_ticker_source'] ?? 'content';
    $visitor_ticker_content_filter = $sysconf['template']['classic_ticker_content_filter'] ?? 'all';
    $visitor_ticker_content_detail = $sysconf['template']['classic_ticker_content_detail'] ?? 'title';
    $visitor_ticker_biblio_filter = $sysconf['template']['classic_ticker_biblio_filter'] ?? 'all';

    $visitor_ticker_items = themeGetDisplayItems(
        $dbs,
        $visitor_ticker_source,
        $visitor_ticker_content_filter,
        $visitor_ticker_content_detail,
        $visitor_ticker_biblio_filter,
        $visitor_ticker_limit,
        $visitor_ticker_char_limit
    );
}

?>

<div class="visitor-bg-gradient"></div>

<h1 class="visually-hidden"><?= themeEscape($visitor_title); ?></h1>

<?php if ($visitor_layout_style === 'split') : ?>
<div class="d-flex align-items-center justify-content-center min-vh-100 w-100 visitor-backdrop <?= !empty($visitor_ticker_items) ? 'visitor-has-running-text' : ''; ?>" id="visitor-counter">
    <main class="main-split-container">
        
        <section class="left-form-section">
            <div class="text-center mb-4">
                <h2 class="fw-bold visitor-welcome-title mb-2"><?= themeEscape($visitor_title); ?></h2>
                <p class="text-muted visitor-subtitle mb-0"><?= themeEscape($visitor_subtitle); ?></p>
            </div>

            <!-- Form and Feedback Area -->
            <div class="visitor-card-body position-relative">
                <!-- Checking status card (Success/Error/Warning) -->
                <div v-if="textInfo !== ''" class="feedback-container mb-4" role="status" aria-live="polite" aria-atomic="true">
                    <div class="feedback-card d-flex flex-column align-items-center" :class="'feedback-' + textInfoType">
                        <div class="visitor-avatar-wrap mb-3 shadow-sm">
                            <img :src="image" alt="<?= themeEscape(__('Visitor profile photo')) ?>" class="img-fluid rounded-circle visitor-avatar-img" @error="onImageError">
                        </div>
                        <h4 class="fw-bold mb-2 visitor-feedback-text" v-text="textInfo"></h4>
                        <p class="text-xs text-muted mb-0"><?= themeEscape(__('Auto resetting in 5 seconds...')) ?></p>
                    </div>
                </div>

                <!-- Input Form Tabs -->
                <div v-show="textInfo === ''">
                    <nav class="tabs" role="tablist">
                        <button type="button" id="visitor-tab-member" class="tab-link" :class="{ active: activeTab === 'member' }" @click="activeTab = 'member'" role="tab" aria-controls="visitor-panel-member" :aria-selected="activeTab === 'member' ? 'true' : 'false'"><?= __('Member') ?></button>
                        <button type="button" id="visitor-tab-non-member" class="tab-link" :class="{ active: activeTab === 'non-member' }" @click="activeTab = 'non-member'" role="tab" aria-controls="visitor-panel-non-member" :aria-selected="activeTab === 'non-member' ? 'true' : 'false'"><?= __('Non-Member') ?></button>
                    </nav>

                    <!-- Member Tab Form -->
                    <form id="visitor-panel-member" v-show="activeTab === 'member'" @submit.prevent="onSubmit" :aria-busy="isSubmitting ? 'true' : 'false'" role="tabpanel" aria-labelledby="visitor-tab-member">
                        <div class="mb-3 text-start mb-4">
                            <input v-model="memberId" ref="memberId" autofocus type="text" class="form-control form-control-lg visitor-input" id="member-id-input-split"
                                   placeholder="<?= themeEscape(__('Enter your member ID')) ?>" aria-label="<?= themeEscape(__('Enter your member ID')) ?>" autocomplete="off">
                        </div>
                        <p class="instruction-text text-muted text-center text-xs mb-3"><?= __('Pastikan kursor aktif di kolom sebelum scan / ketik.') ?></p>
                        <button type="submit" class="btn btn-primary w-100 btn-lg btn-visitor-checkin shadow-sm" :disabled="isSubmitting">
                            <i class="fas fa-sign-in-alt me-2" v-if="!isSubmitting" aria-hidden="true"></i>
                            <span>{{ isSubmitting ? submittingLabel : submitLabel }}</span>
                        </button>
                    </form>

                    <!-- Non-Member Tab Form -->
                    <form id="visitor-panel-non-member" v-show="activeTab === 'non-member'" @submit.prevent="onSubmit" :aria-busy="isSubmitting ? 'true' : 'false'" role="tabpanel" aria-labelledby="visitor-tab-non-member">
                        <div class="mb-3 text-start mb-4">
                            <input v-model="visitorName" ref="nonMemberNameInput" type="text" class="form-control form-control-lg visitor-input mb-3"
                                   placeholder="<?= themeEscape(__('Nama Lengkap')) ?>" aria-label="<?= themeEscape(__('Nama Lengkap')) ?>" autocomplete="off">
                            
                            <select v-model="selectInstitution" class="form-control form-control-lg visitor-input mb-3" aria-label="<?= themeEscape($visitor_institution_select_label) ?>">
                                <option value="" disabled selected><?= themeEscape($visitor_institution_select_label) ?></option>
                                <?php foreach ($visitor_institution_options as $visitor_institution_option) : ?>
                                <option value="<?= themeEscape($visitor_institution_option['value']); ?>"><?= themeEscape($visitor_institution_option['label']); ?></option>
                                <?php endforeach; ?>
                            </select>

                            <input v-show="isManualInstitutionSelected()" v-model="manualInstitution" type="text" class="form-control form-control-lg visitor-input"
                                   placeholder="<?= themeEscape(__('Tulis Nama Institusi...')) ?>" aria-label="<?= themeEscape(__('Tulis Nama Institusi...')) ?>" autocomplete="off">
                        </div>
                        <p class="instruction-text text-muted text-center text-xs mb-3"><?= __('Isi data diri untuk pengunjung non-member') ?></p>
                        <button type="submit" class="btn btn-primary w-100 btn-lg btn-visitor-checkin shadow-sm" :disabled="isSubmitting">
                            <i class="fas fa-sign-in-alt me-2" v-if="!isSubmitting" aria-hidden="true"></i>
                            <span>{{ isSubmitting ? submittingLabel : submitLabel }}</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Footer Clock & Toggle -->
            <div class="mt-4 pt-3 border-top visitor-card-footer text-center position-relative">
                <div class="visitor-clock fw-bold" v-text="currentTime"></div>
                <?php if ($visitor_theme_toggle_enabled) : ?>
                <button type="button" id="color-mode-toggle-desktop" class="visitor-toggle-btn" title="<?= themeEscape(__('Dark mode')) ?>" data-dark-title="<?= themeEscape(__('Dark mode')) ?>" data-light-title="<?= themeEscape(__('Light mode')) ?>" aria-label="<?= themeEscape(__('Toggle dark/light mode')) ?>" aria-pressed="false">
                    <i class="fas fa-moon" aria-hidden="true"></i>
                </button>
                <?php endif; ?>
            </div>
        </section>

        <section class="right-instruction-section">
            <h2 class="inst-title"><?= themeEscape($visitor_split_title); ?></h2>
            <div class="inst-steps">
                <?= $visitor_split_steps_html; ?>
            </div>
        </section>
    </main>
</div>
<?php else : ?>
<div class="d-flex align-items-center justify-content-center min-vh-100 w-100 visitor-backdrop <?= !empty($visitor_ticker_items) ? 'visitor-has-running-text' : ''; ?>" id="visitor-counter">
    <div class="visitor-kiosk-card p-4 p-md-5 text-center shadow-lg">
        <!-- Header -->
        <div class="mb-4">
            <h2 class="fw-bold visitor-welcome-title mb-2"><?= themeEscape($visitor_title); ?></h2>
            <p class="text-muted visitor-subtitle mb-0"><?= themeEscape($visitor_subtitle); ?></p>
        </div>

        <!-- Form and Feedback Area -->
        <div class="visitor-card-body position-relative">
            <!-- Checking status card (Success/Error/Warning) -->
            <div v-if="textInfo !== ''" class="feedback-container mb-4" role="status" aria-live="polite" aria-atomic="true">
                <div class="feedback-card d-flex flex-column align-items-center" :class="'feedback-' + textInfoType">
                    <div class="visitor-avatar-wrap mb-3 shadow-sm">
                        <img :src="image" alt="<?= themeEscape(__('Visitor profile photo')) ?>" class="img-fluid rounded-circle visitor-avatar-img" @error="onImageError">
                    </div>
                    <h4 class="fw-bold mb-2 visitor-feedback-text" v-text="textInfo"></h4>
                    <p class="text-xs text-muted mb-0"><?= themeEscape(__('Auto resetting in 5 seconds...')) ?></p>
                </div>
            </div>

            <!-- Input Form -->
            <form v-show="textInfo === ''" @submit.prevent="onSubmit" :aria-busy="isSubmitting ? 'true' : 'false'">
                <div class="mb-3 text-start mb-4">
                    <input v-model="memberId" ref="memberId" autofocus type="text" class="form-control form-control-lg visitor-input" id="member-id-input"
                           placeholder="<?= themeEscape(__('Enter your member ID')) ?>" aria-label="<?= themeEscape(__('Enter your member ID')) ?>" autocomplete="off">
                </div>
                <div class="mb-3 text-start mb-4">
                    <input v-model="institution" type="text" class="form-control form-control-lg visitor-input" id="institution-input"
                           placeholder="<?= themeEscape(__('Enter your institution')) ?>" aria-label="<?= themeEscape(__('Enter your institution')) ?>" autocomplete="off">
                    <small class="form-text text-muted mt-2 text-center w-100 d-block"><?= themeEscape(__('Enough fill your member ID if you are member of ').$sysconf['library_name']); ?></small>
                </div>
                <button type="submit" class="btn btn-primary w-100 btn-lg btn-visitor-checkin mt-2 shadow-sm" :disabled="isSubmitting">
                    <i class="fas fa-sign-in-alt me-2" v-if="!isSubmitting" aria-hidden="true"></i>
                    <span>{{ isSubmitting ? submittingLabel : submitLabel }}</span>
                </button>
            </form>
        </div>

        <!-- Footer Clock & Toggle -->
        <div class="mt-4 pt-3 border-top visitor-card-footer text-center position-relative">
            <div class="visitor-clock fw-bold" v-text="currentTime"></div>
            <?php if ($visitor_theme_toggle_enabled) : ?>
            <button type="button" id="color-mode-toggle-desktop" class="visitor-toggle-btn" title="<?= themeEscape(__('Dark mode')) ?>" data-dark-title="<?= themeEscape(__('Dark mode')) ?>" data-light-title="<?= themeEscape(__('Light mode')) ?>" aria-label="<?= themeEscape(__('Toggle dark/light mode')) ?>" aria-pressed="false">
                <i class="fas fa-moon" aria-hidden="true"></i>
            </button>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if (!empty($visitor_ticker_items)) : ?>
<div class="latest-content-ticker visitor-latest-content-ticker" data-speed="<?= themeEscape($visitor_ticker_speed); ?>" role="status">
    <div class="latest-content-ticker-track">
        <div class="latest-content-ticker-group">
            <?php foreach ($visitor_ticker_items as $visitor_ticker_item) : ?>
                <a class="latest-content-ticker-item"
                   href="<?= themeEscape($visitor_ticker_item['url']); ?>"
                   title="<?= themeEscape($visitor_ticker_item['title']); ?>">
                    <i class="fas fa-volume-up latest-content-icon" aria-hidden="true"></i>
                    <span class="latest-content-title"><?= themeEscape($visitor_ticker_item['display_title']); ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<?php
$visitor_room_query = trim(isset($_GET['room']) ? '&room=' . simbio_security::xssFree($_GET['room']) : '');
$visitor_counter_script = function_exists('assetsVersioned')
    ? assetsVersioned('js/visitor_counter.js')
    : $sysconf['template']['dir'] . '/' . $sysconf['template']['theme'] . '/assets/js/visitor_counter.js';
$visitor_js_config = [
    'submitLabel' => __('Check In'),
    'submittingLabel' => __('Checking in...'),
    'failureMessage' => __('Check in failed'),
    'defaultImage' => './images/persons/photo.png',
    'feedbackResetDelay' => 5000,
    'quickFeedbackResetDelay' => 1800,
    'quotesEnabled' => $visitor_quote_enabled,
    'quoteFallback' => [
        'content' => 'Sing penting madhiang.',
        'author' => 'Pai-Jo',
    ],
    'localQuotes' => [
        [
            'content' => __('Libraries store the memory of a community and open the door to its future.'),
            'author' => $sysconf['library_name'] ?? 'SLiMS Library',
        ],
        [
            'content' => __('Reading is a quiet way to travel farther than the room you are in.'),
            'author' => 'Rasamala',
        ],
        [
            'content' => __('Good information helps people make better decisions.'),
            'author' => $sysconf['library_name'] ?? 'SLiMS Library',
        ],
        [
            'content' => __('A library grows each time someone finds what they need.'),
            'author' => 'Rasamala',
        ],
    ],
    'csrfName' => \Volnix\CSRF\CSRF::getTokenName(),
    'csrfToken' => \Volnix\CSRF\CSRF::getToken(),
    'visitorUrl' => 'index.php?p=visitor' . $visitor_room_query,
    'otherInstitutionValue' => $visitor_other_institution_value,
    'voiceEnabled' => !empty($sysconf['template']['visitor_log_voice']),
    'speechLang' => str_replace('_', '-', $sysconf['default_lang']),
];
?>
<script id="rasamala-visitor-config" type="application/json"><?= json_encode($visitor_js_config, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?></script>
<script src="<?php echo themeEscape($sysconf['template']['dir'].'/'.$sysconf['template']['theme'].'/assets/js/axios.min.js'); ?>"></script>
<script src="<?= themeEscape($visitor_counter_script); ?>"></script>
