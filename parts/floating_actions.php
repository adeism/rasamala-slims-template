<?php
# @Author: Waris Agung Widodo <user>
# @Date:   2026-07-16T10:08:00+07:00
# @Email:  ido.alit@gmail.com
# @Filename: floating_actions.php
# @Last modified by:   Ade Ismail Siregar (adeismailbox@gmail.com)
# @Last modified time: 2026-07-16T11:52:09+07:00

if (!function_exists('rasamalaWhatsappDefaultCategories')) {
    function rasamalaWhatsappDefaultCategories()
    {
        return "Tugas Akhir | Halo, saya ingin bertanya tentang layanan tugas akhir.\n"
            . "Denda | Halo, saya ingin bertanya tentang informasi denda.\n"
            . "Login | Halo, saya mengalami kendala login OPAC/akun.";
    }
}

if (!function_exists('rasamalaParseWhatsappCategories')) {
    function rasamalaParseWhatsappCategories($raw)
    {
        $raw = trim((string)$raw);
        if ($raw === '') {
            $raw = rasamalaWhatsappDefaultCategories();
        }

        $categories = [];
        $lines = preg_split('/\R+/', $raw);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || strpos($line, '|') === false) {
                continue;
            }

            [$title, $message] = array_map('trim', explode('|', $line, 2));
            if ($title === '' || $message === '') {
                continue;
            }

            $categories[] = [
                'title' => $title,
                'message' => $message,
            ];
        }

        if (!empty($categories)) {
            return $categories;
        }

        // Backward compatible fallback for old one-line "title | message title | message" values.
        $parts = explode('|', $raw);
        $num_parts = count($parts);
        if ($num_parts < 2) {
            return [];
        }

        $current_title = trim($parts[0]);
        for ($i = 1; $i < $num_parts; $i++) {
            $content = $parts[$i];
            if ($i < $num_parts - 1) {
                $boundary_pos = false;
                foreach (['.', '?', '!', "\n"] as $punctuation) {
                    $pos = strrpos($content, $punctuation);
                    if ($pos !== false && ($boundary_pos === false || $pos > $boundary_pos)) {
                        $boundary_pos = $pos;
                    }
                }

                if ($boundary_pos !== false) {
                    $message = trim(substr($content, 0, $boundary_pos + 1));
                    $next_title = trim(substr($content, $boundary_pos + 1));
                } else {
                    $content_trimmed = trim($content);
                    $last_space = strrpos($content_trimmed, ' ');
                    if ($last_space !== false) {
                        $message = trim(substr($content_trimmed, 0, $last_space));
                        $next_title = trim(substr($content_trimmed, $last_space));
                    } else {
                        $message = '';
                        $next_title = $content_trimmed;
                    }
                }
            } else {
                $message = trim($content);
                $next_title = '';
            }

            if ($current_title !== '' && $message !== '') {
                $categories[] = [
                    'title' => $current_title,
                    'message' => $message,
                ];
            }
            $current_title = $next_title;
        }

        return $categories;
    }
}

$latest_content_ticker_items = $latest_content_ticker_items ?? [];
$show_back_to_top = themeEffectiveTemplateValue('classic_back_to_top', 1, $sysconf);
$floating_info_mode = themeEffectiveTemplateValue('classic_floating_info', 'libinfo', $sysconf);
// Fallback for legacy values
if ($floating_info_mode == '1') {
    $floating_info_mode = 'libinfo';
} elseif ($floating_info_mode == '0') {
    $floating_info_mode = 'hide';
}

$show_floating_libinfo = ($floating_info_mode === 'libinfo');
$show_floating_whatsapp = ($floating_info_mode === 'whatsapp');
$show_color_toggle = themeColorModeToggleVisible($sysconf);

$libinfo_title = __('Library Information');
$libinfo_desc = '';
if ($show_floating_libinfo && isset($dbs) && $dbs) {
    $libinfo_query = $dbs->query("SELECT content_title, content_desc FROM content WHERE content_path='libinfo' AND is_draft=0 LIMIT 1");
    if ($libinfo_query && $libinfo_query->num_rows > 0) {
        $libinfo_data = $libinfo_query->fetch_assoc();
        $libinfo_title = $libinfo_data['content_title'];
        $libinfo_desc = $libinfo_data['content_desc'];
    }
}
?>

<?php if ($show_color_toggle): ?>
    <button id="color-mode-toggle"
            class="btn-color-mode-toggle shadow-lg <?= !empty($latest_content_ticker_items) ? 'has-latest-content-ticker' : '' ?>"
            title="<?= themeEscape(__('Dark mode')) ?>"
            data-dark-title="<?= themeEscape(__('Dark mode')) ?>"
            data-light-title="<?= themeEscape(__('Light mode')) ?>"
            aria-label="<?= themeEscape(__('Toggle dark/light mode')) ?>"
            aria-pressed="false">
        <i class="fas fa-moon" aria-hidden="true"></i>
    </button>
<?php endif; ?>

<?php if ($show_floating_libinfo): ?>
    <button id="floating-info-btn" class="btn-floating-info shadow-lg <?= !empty($latest_content_ticker_items) ? 'has-latest-content-ticker' : '' ?>" data-bs-toggle="modal" data-bs-target="#libinfoModal" title="Library Info" aria-label="<?= themeEscape(__('Library Information')) ?>">
        <i class="fas fa-info-circle" aria-hidden="true"></i>
    </button>

    <div class="modal fade" id="libinfoModal" tabindex="-1" role="dialog" aria-labelledby="libinfoModalLabel" aria-hidden="true" inert>
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content libinfo-modal-content">
                <div class="modal-header libinfo-modal-header">
                    <h5 class="modal-title fw-bold text-uppercase tracking-wider libinfo-modal-title" id="libinfoModalLabel">
                        <?= htmlspecialchars($libinfo_title, ENT_QUOTES, 'UTF-8') ?>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= themeEscape(__('Close')) ?>"></button>
                </div>
                <div class="modal-body libinfo-modal-body">
                    <div class="libinfo-content libinfo-modal-desc">
                        <?= themeSanitizeHtml($libinfo_desc) ?>
                    </div>
                </div>
                <div class="modal-footer libinfo-modal-footer">
                    <button type="button" class="btn btn-outline-cyan libinfo-modal-btn" data-bs-dismiss="modal">
                        <?= __('Close') ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php elseif ($show_floating_whatsapp): ?>
    <?php
    $wa_title = themeEffectiveTemplateValue('classic_whatsapp_title', 'Layanan Chat WhatsApp', $sysconf);
    $wa_hours = themeEffectiveTemplateValue('classic_service_hours', 'Senin - Jumat (08:00 - 16:00)', $sysconf);
    $wa_desc = themeEffectiveTemplateValue('classic_whatsapp_desc', 'Pilih salah satu kategori pertanyaan di bawah ini untuk memulai chat dengan pustakawan kami via WhatsApp.', $sysconf);
    $wa_num = preg_replace('/[^0-9]/', '', themeEffectiveTemplateValue('classic_whatsapp_number', '628123456789', $sysconf));
    $parsed_categories = rasamalaParseWhatsappCategories(themeEffectiveTemplateValue('classic_whatsapp_categories', '', $sysconf));
    ?>
    <button id="floating-whatsapp-btn" class="btn-floating-whatsapp shadow-lg <?= !empty($latest_content_ticker_items) ? 'has-latest-content-ticker' : '' ?>" data-bs-toggle="modal" data-bs-target="#whatsappModal" title="WhatsApp Chat" aria-label="WhatsApp Chat">
        <i class="fab fa-whatsapp" aria-hidden="true"></i>
    </button>

    <div class="modal fade" id="whatsappModal" tabindex="-1" role="dialog" aria-labelledby="whatsappModalLabel" aria-hidden="true" inert>
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content whatsapp-modal-content">
                <div class="modal-header whatsapp-modal-header d-flex align-items-center justify-content-between">
                    <div class="d-flex flex-column text-start">
                        <span class="whatsapp-modal-name"><?= htmlspecialchars($wa_title, ENT_QUOTES, 'UTF-8') ?></span>
                        <?php if (!empty($wa_hours)) : ?>
                        <span class="whatsapp-modal-status"><i class="far fa-clock me-1" style="font-size: 11px;" aria-hidden="true"></i> Jam Layanan: <?= htmlspecialchars($wa_hours, ENT_QUOTES, 'UTF-8') ?></span>
                        <?php endif; ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white m-0" data-bs-dismiss="modal" aria-label="<?= themeEscape(__('Close')) ?>"></button>
                </div>
                <div class="modal-body whatsapp-modal-body">
                    <div class="whatsapp-chat-container d-flex flex-column">
                        <div class="chat-bubble-incoming d-flex flex-column">
                            <div class="chat-bubble-author">Pustakawan</div>
                            <div class="chat-bubble-text"><?= htmlspecialchars($wa_desc, ENT_QUOTES, 'UTF-8') ?></div>
                        </div>

                        <div class="whatsapp-quick-reply-label mb-2 text-center text-xs text-muted">Pilih Kategori Pertanyaan (Mulai Chat):</div>

                        <div class="whatsapp-categories-list d-flex flex-column gap-2">
                            <?php foreach ($parsed_categories as $cat) : ?>
                                <?php $wa_url = 'https://wa.me/' . $wa_num . '?text=' . urlencode($cat['message']); ?>
                                <a href="<?= themeEscape($wa_url); ?>" target="_blank" rel="noopener noreferrer" class="chat-bubble-outgoing whatsapp-quick-reply">
                                    <span><?= themeEscape($cat['title']); ?></span>
                                    <i class="fab fa-whatsapp" aria-hidden="true"></i>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if ($show_back_to_top): ?>
    <button id="back-to-top" title="Go to top" class="btn-back-to-top shadow-lg <?= ($show_floating_libinfo || $show_floating_whatsapp) ? 'has-floating-info' : '' ?> <?= !empty($latest_content_ticker_items) ? 'has-latest-content-ticker' : '' ?>" aria-label="<?= themeEscape(__('Go to top')) ?>">
        <i class="fas fa-chevron-up" aria-hidden="true"></i>
    </button>
<?php endif; ?>
