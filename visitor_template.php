<?php
/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 2020-01-03 08:49
 * @File name           : visitor_template.php
 * @Last modified by    : Ade Ismail Siregar (adeismailbox@gmail.com)
 * @Last modified time  : 2026-07-15T11:59:23+07:00
 */

$main_template_path = __DIR__ . '/login_template.inc.php';
include_once __DIR__ . '/classic.php';

// set default language
if (isset($_GET['select_lang'])) {
    $select_lang = trim(strip_tags($_GET['select_lang']));
    // delete previous language cookie
    if (isset($_COOKIE['select_lang'])) {
        #@setcookie('select_lang', $select_lang, time()-14400, SWB);
        #@setcookie('select_lang', $select_lang, time()-14400, SWB, "", FALSE, TRUE);

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
    #@setcookie('select_lang', $select_lang, time()+14400, SWB);
    #@setcookie('select_lang', $select_lang, time()+14400, SWB, "", FALSE, TRUE);

    @setcookie('select_lang', $select_lang, [
        'expires' => time()+14400,
        'path' => SWB,
        'domain' => '',
        'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);



    $sysconf['default_lang'] = $select_lang;
} else if (isset($_COOKIE['select_lang'])) {
    $sysconf['default_lang'] = trim(strip_tags($_COOKIE['select_lang']));
}

$visitor_quote_enabled = ($sysconf['template']['visitor_quote'] ?? 1) == 1;
$visitor_title = themeEffectiveTemplateValue('visitor_title', '', $sysconf);
if (trim((string)$visitor_title) === '') {
    $visitor_title = $sysconf['library_name'] ?? 'SLiMS Library';
}
$visitor_subtitle = themeEffectiveTemplateValue('visitor_subtitle', 'Visitor Check-In Portal', $sysconf);
$visitor_theme_toggle_enabled = (themeEffectiveTemplateValue('visitor_theme_toggle', 1, $sysconf) == 1);
$visitor_layout_style = themeEffectiveTemplateValue('visitor_layout_style', 'kiosk', $sysconf);

if (!function_exists('rasamalaVisitorSplitDefaultSteps')) {
    function rasamalaVisitorSplitDefaultSteps()
    {
        return [
            [
                'icon' => 'fas fa-lock',
                'title' => 'Login Web PSB',
                'description' => 'Buka <span class="highlight">psb.feb.ui.ac.id</span> dan login di area anggota untuk memunculkan Kode QR.'
            ],
            [
                'icon' => 'scan',
                'title' => 'Scan atau Ketik',
                'description' => 'Arahkan Kode QR di HP Anda ke alat pemindai, <span class="highlight">ATAU</span> ketik NPM/ID Anda secara manual di kolom sebelah kiri.'
            ],
            [
                'icon' => 'fas fa-check',
                'title' => 'Konfirmasi Sukses',
                'description' => 'Setelah scan berhasil, layar akan menampilkan data check-in sukses dan portal siap kembali untuk antrean berikutnya.'
            ]
        ];
    }
}

if (!function_exists('rasamalaVisitorSplitSteps')) {
    function rasamalaVisitorSplitSteps($raw_steps)
    {
        $raw_steps = trim((string)($raw_steps ?? ''));
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

$visitor_split_title = trim((string)themeEffectiveTemplateValue('visitor_split_title', 'Petunjuk Penggunaan', $sysconf));
if ($visitor_split_title === '') {
    $visitor_split_title = 'Petunjuk Penggunaan';
}
$visitor_split_description = trim((string)themeEffectiveTemplateValue('visitor_split_description', '', $sysconf));
$visitor_split_steps = rasamalaVisitorSplitSteps(themeEffectiveTemplateValue('visitor_split_steps', '', $sysconf));

?>
<style>
/* Kiosk Mode Visitor Styles */
.visitor-bg-gradient {
  background: linear-gradient(135deg, #f5f6f8 0%, #e2e5e9 100%) !important;
}
body.rasamala-dark .visitor-bg-gradient {
  background: linear-gradient(135deg, #0c0f14 0%, #151922 100%) !important;
}

.visitor-kiosk-card {
  width: 90% !important;
  max-width: 500px !important;
  background: rgba(255, 255, 255, 0.95) !important;
  backdrop-filter: blur(20px) !important;
  border: 1px solid rgba(255, 255, 255, 0.4) !important;
  border-radius: 20px !important;
  box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15) !important;
  transition: all 0.3s ease !important;
  margin: auto !important;
}

body.rasamala-dark .visitor-kiosk-card {
  background: rgba(20, 24, 32, 0.95) !important;
  border-color: rgba(255, 255, 255, 0.08) !important;
  box-shadow: 0 20px 50px rgba(0, 0, 0, 0.35) !important;
}

.visitor-kiosk-card .visitor-welcome-title {
  color: var(--rasamala-accent) !important;
  font-size: 26px !important;
  letter-spacing: -0.02em !important;
}

.visitor-kiosk-card .visitor-subtitle {
  font-size: 14px !important;
  letter-spacing: 0.05em !important;
  text-transform: uppercase !important;
  font-weight: 600 !important;
  opacity: 0.6 !important;
}

.visitor-input {
  background: rgba(0, 0, 0, 0.02) !important;
  border: 1.5px solid rgba(0, 0, 0, 0.08) !important;
  border-radius: 12px !important;
  padding: 14px 20px !important;
  font-size: 16px !important;
  height: auto !important;
  color: var(--rasamala-text-primary) !important;
  transition: all 0.25s ease !important;
}

body.rasamala-dark .visitor-input {
  background: rgba(255, 255, 255, 0.03) !important;
  border-color: rgba(255, 255, 255, 0.1) !important;
}

.visitor-input:focus {
  border-color: var(--rasamala-accent) !important;
  box-shadow: 0 0 0 4px rgba(var(--theme-accent-rgb), 0.12) !important;
  background: transparent !important;
}

.visitor-label {
  font-size: 12px !important;
  letter-spacing: 0.08em !important;
  color: var(--rasamala-text-secondary) !important;
}

.btn-visitor-checkin {
  border-radius: 12px !important;
  font-weight: 700 !important;
  padding: 14px !important;
  font-size: 16px !important;
  background-color: var(--rasamala-accent) !important;
  border-color: var(--rasamala-accent) !important;
  transition: all 0.25s ease !important;
  letter-spacing: 0.02em !important;
}

.btn-visitor-checkin:hover, .btn-visitor-checkin:focus {
  background-color: var(--rasamala-accent-hover) !important;
  border-color: var(--rasamala-accent-hover) !important;
  transform: translateY(-1px) !important;
}

.btn-visitor-checkin:disabled {
  opacity: 0.6 !important;
  transform: none !important;
}

/* Feedback Layout */
.feedback-container {
  min-height: 180px !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
}

.feedback-card {
  width: 100% !important;
  border-radius: 14px !important;
  padding: 24px !important;
  transition: all 0.3s ease !important;
}

.feedback-success {
  background: rgba(40, 167, 69, 0.08) !important;
  border: 1px solid rgba(40, 167, 69, 0.2) !important;
  color: #28a745 !important;
}

.feedback-danger {
  background: rgba(220, 53, 69, 0.08) !important;
  border: 1px solid rgba(220, 53, 69, 0.2) !important;
  color: #dc3545 !important;
}

.feedback-warning {
  background: rgba(255, 193, 7, 0.08) !important;
  border: 1px solid rgba(255, 193, 7, 0.2) !important;
  color: #ffc107 !important;
}

.feedback-info {
  background: rgba(23, 162, 184, 0.08) !important;
  border: 1px solid rgba(23, 162, 184, 0.2) !important;
  color: #17a2b8 !important;
}

.visitor-avatar-wrap {
  width: 100px !important;
  height: 100px !important;
  border: 4px solid #ffffff !important;
  border-radius: 50% !important;
  overflow: hidden !important;
  margin-left: auto !important;
  margin-right: auto !important;
}

body.rasamala-dark .visitor-avatar-wrap {
  border-color: rgba(255, 255, 255, 0.15) !important;
}

.visitor-feedback-text {
  font-size: 20px !important;
  color: inherit !important;
  line-height: 1.3 !important;
}

.visitor-clock {
  font-family: monospace, sans-serif !important;
  font-size: 42px !important;
  font-weight: 700 !important;
  letter-spacing: 0.05em !important;
  color: var(--rasamala-accent) !important;
  text-shadow: 0 0 12px rgba(var(--theme-accent-rgb), 0.18) !important;
  text-align: center !important;
  margin: 4px auto !important;
  display: inline-block !important;
}

.visitor-toggle-btn {
  position: absolute !important;
  right: 0 !important;
  bottom: 12px !important;
  opacity: 0.25 !important;
  color: var(--rasamala-text-secondary) !important;
  background: transparent !important;
  border: none !important;
  padding: 4px 8px !important;
  transition: all 0.25s ease !important;
  font-size: 14px !important;
  cursor: pointer !important;
}

.visitor-toggle-btn:hover {
  opacity: 0.9 !important;
  color: var(--rasamala-accent) !important;
}

/* Split Layout Custom Styles (Following Theme) */
.main-split-container {
  display: flex;
  flex-direction: row;
  gap: 40px;
  max-width: 1000px;
  width: 92%;
  margin: 40px auto !important;
  align-items: stretch;
  z-index: 10;
}
.left-form-section, .right-instruction-section {
  flex: 1;
  background: rgba(255, 255, 255, 0.95) !important;
  backdrop-filter: blur(20px) !important;
  border: 1px solid rgba(255, 255, 255, 0.4) !important;
  padding: 40px !important;
  border-radius: 20px !important;
  box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15) !important;
  display: flex;
  flex-direction: column;
  justify-content: center;
  transition: all 0.3s ease !important;
}
body.rasamala-dark .left-form-section,
body.rasamala-dark .right-instruction-section {
  background: rgba(20, 24, 32, 0.95) !important;
  border-color: rgba(255, 255, 255, 0.08) !important;
  box-shadow: 0 20px 50px rgba(0, 0, 0, 0.35) !important;
}

/* Tabs styling */
.tabs {
  display: flex;
  margin-bottom: 30px;
  border-bottom: 2px solid rgba(0,0,0,0.06);
  justify-content: center;
  gap: 20px;
}
body.rasamala-dark .tabs {
  border-bottom-color: rgba(255, 255, 255, 0.08);
}
.tab-link {
  background: none;
  border: none;
  color: var(--rasamala-text-secondary);
  padding: 12px 20px;
  cursor: pointer;
  font-size: 16px;
  font-weight: 600;
  transition: all 0.2s ease;
  border-bottom: 4px solid transparent;
  margin-bottom: -2px;
}
.tab-link.active {
  color: var(--rasamala-accent);
  border-bottom-color: var(--rasamala-accent);
}
.tab-link:focus {
  outline: none;
}

/* Instructions */
.inst-title {
  font-size: 22px;
  font-weight: 700;
  margin-bottom: 10px;
  color: var(--rasamala-text-primary);
  text-align: center;
}
.inst-description {
  color: var(--rasamala-text-secondary);
  font-size: 13px;
  line-height: 1.6;
  text-align: center;
  margin: 0 auto 24px;
  max-width: 430px;
}
.inst-steps {
  display: flex;
  flex-direction: column;
  gap: 20px;
}
.inst-step {
  display: flex;
  align-items: flex-start;
  gap: 16px;
  padding: 15px;
  border-radius: 12px;
  background: rgba(var(--theme-accent-rgb), 0.03);
  border: 1px solid transparent;
  transition: all 0.25s ease;
}
.inst-step:hover {
  border-color: rgba(0,0,0,0.08);
  background: rgba(255,255,255,0.5);
}
.inst-step-featured {
  border-color: var(--rasamala-accent);
  background: rgba(var(--theme-accent-rgb), 0.06);
}
body.rasamala-dark .inst-step:hover {
  border-color: rgba(255,255,255,0.08);
  background: rgba(255,255,255,0.02);
}
.inst-icon-box {
  flex-shrink: 0;
  width: 44px;
  height: 44px;
  background: var(--rasamala-accent);
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  color: white;
  box-shadow: 0 4px 10px rgba(var(--theme-accent-rgb), 0.25);
}
.inst-icon-box i {
  font-size: 18px;
  line-height: 1;
}
.inst-icon-box-scan {
  background: transparent;
  box-shadow: none;
  overflow: hidden;
  color: var(--rasamala-accent);
}
.inst-content h3 {
  font-size: 16px;
  font-weight: 700;
  margin-bottom: 6px;
  color: var(--rasamala-text-primary);
}
.inst-content p {
  font-size: 13px;
  color: var(--rasamala-text-secondary);
  line-height: 1.5;
}
.highlight {
  color: var(--rasamala-accent);
  font-weight: 700;
}

/* Scan laser animation theme colors */
.scan-anim-container {
  position: relative;
  width: 50px;
  height: 50px;
  display: flex;
  justify-content: center;
  align-items: center;
}
.barcode-svg {
  width: 100%;
  height: auto;
  fill: var(--rasamala-text-primary);
  opacity: 0.2;
}
.scan-laser {
  position: absolute;
  width: 100%;
  height: 2px;
  background: var(--rasamala-accent);
  box-shadow: 0 0 8px var(--rasamala-accent), 0 0 15px var(--rasamala-accent);
  top: 0;
  animation: laserMove 2.5s ease-in-out infinite alternate;
}
@keyframes laserMove { 0% { top: 10%; opacity: 0.7; } 100% { top: 90%; opacity: 1; } }

@media (max-width: 900px) {
  .main-split-container {
    flex-direction: column;
    gap: 20px;
    margin-top: 20px;
    margin-bottom: 40px;
  }
}
</style>

<div class="visitor-bg-gradient"></div>

<?php if ($visitor_layout_style === 'split') : ?>
<div class="d-flex align-items-center justify-content-center min-vh-100 w-100 visitor-backdrop" id="visitor-counter">
    <main class="main-split-container">
        
        <section class="left-form-section">
            <div class="text-center mb-4">
                <h2 class="fw-bold visitor-welcome-title mb-2"><?= themeEscape($visitor_title); ?></h2>
                <p class="text-muted visitor-subtitle mb-0"><?= themeEscape($visitor_subtitle); ?></p>
            </div>

            <!-- Form and Feedback Area -->
            <div class="visitor-card-body position-relative">
                <!-- Checking status card (Success/Error/Warning) -->
                <div v-if="textInfo !== ''" class="feedback-container mb-4">
                    <div class="feedback-card d-flex flex-column align-items-center" :class="'feedback-' + textInfoType">
                        <div class="visitor-avatar-wrap mb-3 shadow-sm">
                            <img :src="image" alt="avatar" class="img-fluid rounded-circle visitor-avatar-img" @error="onImageError">
                        </div>
                        <h4 class="fw-bold mb-2 visitor-feedback-text" v-text="textInfo"></h4>
                        <p class="text-xs text-muted mb-0"><?= themeEscape(__('Auto resetting in 5 seconds...')) ?></p>
                    </div>
                </div>

                <!-- Input Form Tabs -->
                <div v-show="textInfo === ''">
                    <nav class="tabs" role="tablist">
                        <button type="button" class="tab-link" :class="{ active: activeTab === 'member' }" @click="activeTab = 'member'" role="tab"><?= __('Member') ?></button>
                        <button type="button" class="tab-link" :class="{ active: activeTab === 'non-member' }" @click="activeTab = 'non-member'" role="tab"><?= __('Non-Member') ?></button>
                    </nav>

                    <!-- Member Tab Form -->
                    <form v-show="activeTab === 'member'" @submit.prevent="onSubmit" :aria-busy="isSubmitting ? 'true' : 'false'">
                        <div class="mb-3 text-start mb-4">
                            <input v-model="memberId" ref="memberId" autofocus type="text" class="form-control form-control-lg visitor-input" id="member-id-input-split"
                                   placeholder="<?= themeEscape(__('Enter your member ID')) ?>" autocomplete="off">
                        </div>
                        <p class="instruction-text text-muted text-center text-xs mb-3"><?= __('Pastikan kursor aktif di kolom sebelum scan / ketik.') ?></p>
                        <button type="submit" class="btn btn-primary w-100 btn-lg btn-visitor-checkin shadow-sm" :disabled="isSubmitting">
                            <i class="fas fa-sign-in-alt me-2" v-if="!isSubmitting"></i>
                            <span>{{ isSubmitting ? submittingLabel : submitLabel }}</span>
                        </button>
                    </form>

                    <!-- Non-Member Tab Form -->
                    <form v-show="activeTab === 'non-member'" @submit.prevent="onSubmit" :aria-busy="isSubmitting ? 'true' : 'false'">
                        <div class="mb-3 text-start mb-4">
                            <input v-model="memberId" ref="nonMemberNameInput" type="text" class="form-control form-control-lg visitor-input mb-3"
                                   placeholder="<?= themeEscape(__('Nama Lengkap')) ?>" autocomplete="off">
                            
                            <select v-model="selectInstitution" class="form-control form-control-lg visitor-input mb-3">
                                <option value="" disabled selected><?= __('Pilih Fakultas / Institusi') ?></option>
                                <option value="FEB">Fakultas Ekonomi dan Bisnis UI</option>
                                <option value="FF">Fakultas Farmasi UI</option>
                                <option value="FH">Fakultas Hukum UI</option>
                                <option value="FIA">Fakultas Ilmu Administrasi UI</option>
                                <option value="FIB">Fakultas Ilmu Budaya UI</option>
                                <option value="FIK">Fakultas Ilmu Keperawatan UI</option>
                                <option value="Fasilkom">Fakultas Ilmu Komputer UI</option>
                                <option value="FISIP">Fakultas Ilmu Sosial dan Ilmu Politik UI</option>
                                <option value="FK">Fakultas Kedokteran UI</option>
                                <option value="FKG">Fakultas Kedokteran Gigi UI</option>
                                <option value="FKM">Fakultas Kesehatan Masyarakat UI</option>
                                <option value="FMIPA">Fakultas Matematika dan Ilmu Pengetahuan Alam UI</option>
                                <option value="FPsi">Fakultas Psikologi UI</option>
                                <option value="FT">Fakultas Teknik UI</option>
                                <option value="Vokasi">Program Vokasi UI</option>
                                <option value="Lainnya">Lainnya (ketik manual)</option>
                            </select>

                            <input v-show="selectInstitution === 'Lainnya'" v-model="manualInstitution" type="text" class="form-control form-control-lg visitor-input"
                                   placeholder="<?= themeEscape(__('Tulis Nama Institusi...')) ?>" autocomplete="off">
                        </div>
                        <p class="instruction-text text-muted text-center text-xs mb-3"><?= __('Isi data diri untuk pengunjung non-member') ?></p>
                        <button type="submit" class="btn btn-primary w-100 btn-lg btn-visitor-checkin shadow-sm" :disabled="isSubmitting">
                            <i class="fas fa-sign-in-alt me-2" v-if="!isSubmitting"></i>
                            <span>{{ isSubmitting ? submittingLabel : submitLabel }}</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Footer Clock & Toggle -->
            <div class="mt-4 pt-3 border-top visitor-card-footer text-center position-relative">
                <div class="visitor-clock fw-bold" v-text="currentTime"></div>
                <?php if ($visitor_theme_toggle_enabled) : ?>
                <button type="button" id="color-mode-toggle-desktop" class="visitor-toggle-btn" title="<?= themeEscape(__('Toggle Color Mode')) ?>">
                    <i class="fas fa-moon"></i>
                </button>
                <?php endif; ?>
            </div>
        </section>

        <section class="right-instruction-section">
            <h2 class="inst-title"><?= themeEscape($visitor_split_title); ?></h2>
            <?php if ($visitor_split_description !== '') : ?>
            <div class="inst-description"><?= themeSanitizeHtml($visitor_split_description); ?></div>
            <?php endif; ?>
            <div class="inst-steps">
                <?php foreach ($visitor_split_steps as $visitor_step_index => $visitor_step) : ?>
                <?php $visitor_step_icon = rasamalaVisitorSplitIcon($visitor_step['icon'] ?? ''); ?>
                <div class="inst-step<?= $visitor_step_icon['is_scan'] ? ' inst-step-featured' : ''; ?>">
                    <div class="inst-icon-box<?= $visitor_step_icon['is_scan'] ? ' inst-icon-box-scan' : ''; ?>"><?= $visitor_step_icon['html']; ?></div>
                    <div class="inst-content">
                        <h3><?= themeEscape(($visitor_step_index + 1) . '. ' . ($visitor_step['title'] ?? 'Info')); ?></h3>
                        <?php if (trim((string)($visitor_step['description'] ?? '')) !== '') : ?>
                        <p><?= themeSanitizeHtml($visitor_step['description']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
</div>
<?php else : ?>
<div class="d-flex align-items-center justify-content-center min-vh-100 w-100 visitor-backdrop" id="visitor-counter">
    <div class="visitor-kiosk-card p-4 p-md-5 text-center shadow-lg">
        <!-- Header -->
        <div class="mb-4">
            <h2 class="fw-bold visitor-welcome-title mb-2"><?= themeEscape($visitor_title); ?></h2>
            <p class="text-muted visitor-subtitle mb-0"><?= themeEscape($visitor_subtitle); ?></p>
        </div>

        <!-- Form and Feedback Area -->
        <div class="visitor-card-body position-relative">
            <!-- Checking status card (Success/Error/Warning) -->
            <div v-if="textInfo !== ''" class="feedback-container mb-4">
                <div class="feedback-card d-flex flex-column align-items-center" :class="'feedback-' + textInfoType">
                    <div class="visitor-avatar-wrap mb-3 shadow-sm">
                        <img :src="image" alt="avatar" class="img-fluid rounded-circle visitor-avatar-img" @error="onImageError">
                    </div>
                    <h4 class="fw-bold mb-2 visitor-feedback-text" v-text="textInfo"></h4>
                    <p class="text-xs text-muted mb-0"><?= themeEscape(__('Auto resetting in 5 seconds...')) ?></p>
                </div>
            </div>

            <!-- Input Form -->
            <form v-show="textInfo === ''" @submit.prevent="onSubmit" :aria-busy="isSubmitting ? 'true' : 'false'">
                <div class="mb-3 text-start mb-4">
                    <input v-model="memberId" ref="memberId" autofocus type="text" class="form-control form-control-lg visitor-input" id="member-id-input"
                           placeholder="<?= themeEscape(__('Enter your member ID')) ?>" autocomplete="off">
                </div>
                <div class="mb-3 text-start mb-4">
                    <input v-model="institution" type="text" class="form-control form-control-lg visitor-input" id="institution-input"
                           placeholder="<?= themeEscape(__('Enter your institution')) ?>" autocomplete="off">
                    <small class="form-text text-muted mt-2 text-center w-100 d-block"><?= themeEscape(__('Enough fill your member ID if you are member of ').$sysconf['library_name']); ?></small>
                </div>
                <button type="submit" class="btn btn-primary w-100 btn-lg btn-visitor-checkin mt-2 shadow-sm" :disabled="isSubmitting">
                    <i class="fas fa-sign-in-alt me-2" v-if="!isSubmitting"></i>
                    <span>{{ isSubmitting ? submittingLabel : submitLabel }}</span>
                </button>
            </form>
        </div>

        <!-- Footer Clock & Toggle -->
        <div class="mt-4 pt-3 border-top visitor-card-footer text-center position-relative">
            <div class="visitor-clock fw-bold" v-text="currentTime"></div>
            <?php if ($visitor_theme_toggle_enabled) : ?>
            <button type="button" id="color-mode-toggle-desktop" class="visitor-toggle-btn" title="<?= themeEscape(__('Toggle Color Mode')) ?>">
                <i class="fas fa-moon"></i>
            </button>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<script src="<?php echo themeEscape($sysconf['template']['dir'].'/'.$sysconf['template']['theme'].'/assets/js/axios.min.js'); ?>"></script>
<script>
    Vue.createApp({
        data() {
            return {
                memberId: '',
                institution: '',
                textInfo: '',
                textInfoType: 'info',
                isSubmitting: false,
                submitLabel: <?= json_encode(__('Check In')) ?>,
                submittingLabel: <?= json_encode(__('Checking in...')) ?>,
                image: './images/persons/photo.png',
                quotesEnabled: <?= json_encode($visitor_quote_enabled) ?>,
                quoteFallback: {
                    content: "Sing penting madhiang.",
                    author: "Pai-Jo"
                },
                localQuotes: [
                    {
                        content: <?= json_encode(__('Libraries store the memory of a community and open the door to its future.')) ?>,
                        author: <?= json_encode($sysconf['library_name']) ?>
                    },
                    {
                        content: <?= json_encode(__('Reading is a quiet way to travel farther than the room you are in.')) ?>,
                        author: 'Rasamala'
                    },
                    {
                        content: <?= json_encode(__('Good information helps people make better decisions.')) ?>,
                        author: <?= json_encode($sysconf['library_name']) ?>
                    },
                    {
                        content: <?= json_encode(__('A library grows each time someone finds what they need.')) ?>,
                        author: 'Rasamala'
                    }
                ],
                quotes: {
                    content: "Sing penting madhiang.",
                    author: "Pai-Jo"
                },
                activeTab: 'member',
                selectInstitution: '',
                manualInstitution: '',
                currentTime: '',
                timeout: null,
                csrfName: <?= json_encode(\Volnix\CSRF\CSRF::getTokenName()) ?>,
                csrfToken: <?= json_encode(\Volnix\CSRF\CSRF::getToken()) ?>
            }
        },
        watch: {
            selectInstitution: function(val) {
                if (val !== 'Lainnya') {
                    this.institution = val;
                } else {
                    this.institution = this.manualInstitution;
                }
            },
            manualInstitution: function(val) {
                if (this.selectInstitution === 'Lainnya') {
                    this.institution = val;
                }
            },
            activeTab: function(val) {
                this.memberId = '';
                this.institution = '';
                this.selectInstitution = '';
                this.manualInstitution = '';
                this.$nextTick(() => {
                    if (val === 'member' && this.$refs.memberId) {
                        this.$refs.memberId.focus();
                    } else if (val === 'non-member' && this.$refs.nonMemberNameInput) {
                        this.$refs.nonMemberNameInput.focus();
                    }
                });
            }
        },
        mounted() {
            if (this.$refs.memberId) {
                this.$refs.memberId.focus()
            }
            this.updateTime()
            setInterval(this.updateTime, 1000)
            if (this.quotesEnabled) {
                this.getQuotes()
            }
            document.addEventListener('click', (e) => {
                if (this.textInfo === '') {
                    if (e.target.closest('input, select, button, .tab-link')) {
                        return
                    }
                    if (this.activeTab === 'member' && this.$refs.memberId) {
                        this.$refs.memberId.focus()
                    } else if (this.activeTab === 'non-member' && this.$refs.nonMemberNameInput) {
                        this.$refs.nonMemberNameInput.focus()
                    }
                }
            })
        },
        methods: {
            updateTime: function() {
                const now = new Date()
                this.currentTime = now.toTimeString().split(' ')[0]
            },
            onImageError: function() {
                this.image = './images/persons/photo.png'
            },
            getQuotes: function() {
                if (!this.quotesEnabled) {
                    this.quotes = this.quoteFallback
                    this.textInfo = ''
                    this.textInfoType = 'info'
                    return
                }
                const quotes = this.localQuotes && this.localQuotes.length ? this.localQuotes : [this.quoteFallback]
                this.quotes = quotes[Math.floor(Math.random() * quotes.length)] || this.quoteFallback
                this.textInfo = ''
                this.textInfoType = 'info'
            },
            plainText: function(message) {
                return String(message || '').replace(/<[^>]*>/g, '').replace(/\s+/g, ' ').trim()
            },
            responseType: function(response) {
                const type = response && response.type ? String(response.type).toLowerCase() : ''
                if (['success', 'info', 'warning', 'danger'].indexOf(type) !== -1) {
                    return type
                }
                if (type === 'error') {
                    return 'danger'
                }
                return response && response.status === false ? 'danger' : 'info'
            },
            safeImageName: function(image) {
                return String(image || 'photo.png').replace(/[^a-zA-Z0-9._-]/g, '') || 'photo.png'
            },
            onSubmit: function() {
                if (this.memberId === '' || this.isSubmitting) {
                    this.resetForm()
                    return
                }
                this.isSubmitting = true
                let url = 'index.php?p=visitor<?= trim(isset($_GET['room']) ? '&room=' . simbio_security::xssFree($_GET['room']) : '')  ?>'
                let data = new FormData()
                data.append('memberID', this.memberId)
                data.append('institution', this.institution)
                data.append('counter', 1)
                data.append(this.csrfName, this.csrfToken)

                axios({
                    url: url,
                    method: 'post',
                    data: data,
                    headers: {'Content-Type': 'multipart/form-data', 'X-Requested-With': 'XMLHttpRequest' }
                })
                    .then(res => {
                        this.textInfo = this.plainText(res.data.message)
                        this.textInfoType = this.responseType(res.data)
                        this.image = `./images/persons/${this.safeImageName(res.data.image)}`
                        if (res.data.new_token) {
                            this.csrfToken = res.data.new_token
                        }
                        <?php if ($sysconf['template']['visitor_log_voice']) : ?>
                            this.textToSpeech(this.textInfo)
                        <?php endif; ?>
                    })
                    .catch(err => {
                        // R-02: removed console.log to avoid leaking error details in production
                        this.textInfo = this.plainText((err.response && err.response.data && err.response.data.message) || <?= json_encode(__('Check in failed')) ?>)
                        this.textInfoType = 'danger'
                        if (err.response && err.response.data.new_token) {
                            this.csrfToken = err.response.data.new_token
                        }
                    })
                    .finally(() => {
                        this.isSubmitting = false
                        this.resetForm()
                        clearTimeout(this.timeout)
                        this.timeout = setTimeout(() => {
                            this.getQuotes()
                        }, 5000)
                    })
            },
            resetForm: function () {
                this.memberId = ''
                this.institution = ''
                this.selectInstitution = ''
                this.manualInstitution = ''
                this.$nextTick(() => {
                    if (this.activeTab === 'member' && this.$refs.memberId) {
                        this.$refs.memberId.focus()
                    } else if (this.activeTab === 'non-member' && this.$refs.nonMemberNameInput) {
                        this.$refs.nonMemberNameInput.focus()
                    }
                })
            },
            // R-01: fix var shadowing — use distinct variable name
            textToSpeech: function(text) {
                var utterance = new SpeechSynthesisUtterance(text);
                var voices = speechSynthesis.getVoices();
                utterance['volume'] = 1;
                utterance['rate'] = 1;
                utterance['pitch'] = 1;
                utterance['lang'] = <?= json_encode(str_replace('_', '-', $sysconf['default_lang'])) ?>;
                utterance['voice'] = null;
                speechSynthesis.cancel();
                speechSynthesis.speak(utterance);
            }
        }
    }).mount('#visitor-counter');
</script>
