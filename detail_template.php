<?php
/**
 * Book Detail Page Template Entry Point
 */
include_once __DIR__ . '/theme_helpers.php';
require_once __DIR__ . '/helpers/detail.php';

global $dbs;

$biblio_id_safe = themeSafeInt($biblio_id ?? 0);
$title_attr = themeEscape(strip_tags($title ?? ''));
$setBookmarked = trim(isset($_SESSION['bookmark'][$biblio_id_safe]) ? 'bg-success text-white rounded-3 px-2 py-1' : 'text-muted px-2 py-1');
$detail_title_html = themeParallelTitleHtml($title ?? '', 'detail');
if (themeShouldGenerateBookCover($image ?? '', $sysconf)) {
    $image = themeGenerateBookCoverHtml($title ?? '', $authors ?? '');
}

$availability_html = $availability ?? '';
$publisher_html = '';
if (themeDetailHasValue($publish_place ?? '')) {
    $publisher_html .= '<span itemprop="publisher" property="publisher" itemtype="http://schema.org/Organization" itemscope>' . themeEscape($publish_place) . '</span>';
}
if (themeDetailHasValue($publisher_name ?? '')) {
    $publisher_html .= ($publisher_html !== '' ? ' : ' : '') . '<span itemprop="publisher" property="publisher">' . themeEscape($publisher_name) . '</span>';
}
if (themeDetailHasValue($publish_year ?? '')) {
    $publisher_html .= ($publisher_html !== '' ? '., ' : '') . '<span itemprop="datePublished" property="datePublished">' . themeEscape($publish_year) . '</span>';
}

$subjects_inline_html = '';
if (themeDetailHasValue($subjects ?? '')) {
    $subject_parts = array_filter(preg_split('/\s*<br\s*\/?>\s*/i', (string) $subjects), 'themeDetailHasValue');
    $subjects_inline_html = implode(' <span class="detail-subject-separator">; </span> ', $subject_parts);
}

// Generate QR Code for Current Detail Page URL
$detail_share_url = SWB . 'index.php?p=show_detail&id=' . $biblio_id_safe;
$qrcode_svg = '';
if (class_exists('BaconQrCode\Writer')) {
    try {
        $renderer = new BaconQrCode\Renderer\ImageRenderer(
            new BaconQrCode\Renderer\RendererStyle\RendererStyle(160, 1),
            new BaconQrCode\Renderer\Image\SvgImageBackEnd()
        );
        $writer = new BaconQrCode\Writer($renderer);
        $qrcode_svg = $writer->writeString($detail_share_url);
        $qrcode_svg = preg_replace('/<\?xml[^>]*\?>/', '', $qrcode_svg);
    } catch (Exception $e) {
        $qrcode_svg = '';
    }
}
if (empty($qrcode_svg)) {
    $qr_api_url = 'https://api.qrserver.com/v1/create-qr-code/?size=160x160&data=' . rawurlencode($detail_share_url);
    $qrcode_svg = '<img src="' . themeEscape($qr_api_url) . '" alt="QR Code" class="img-fluid rounded" style="max-width: 140px; height: auto;">';
}
?>

<div class="detail-record">
    <div class="row detail-main-row">
        <?php include __DIR__ . '/parts/detail/detail_sidebar.php'; ?>
        <?php include __DIR__ . '/parts/detail/detail_fields.php'; ?>
    </div>
</div>

<!-- Mobile QR Code Pop-up Modal -->
<div class="modal fade" id="detailQrModal" tabindex="-1" aria-labelledby="detailQrModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content rounded-4 border-0 text-center p-3">
      <div class="modal-header border-0 pb-0 justify-content-between align-items-center">
        <h6 class="modal-title fw-bold" id="detailQrModalLabel"><i class="fas fa-qrcode text-primary me-2"></i>Link QR</h6>
        <button type="button" class="close btn-close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close" style="font-size: 1.5rem; line-height: 1; background: none; border: 0; outline: none; opacity: 0.7;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body py-4">
        <div class="detail-qr-modal-img mx-auto mb-3" style="max-width: 180px;">
          <?= $qrcode_svg; ?>
        </div>
        <p class="small text-muted mb-0 fw-bold"><?= themeEscape(strip_tags($title ?? '')); ?></p>
      </div>
    </div>
  </div>
</div>

<script>
(function () {
    var button = document.querySelector('[data-detail-avail-more]');
    if (button) {
        button.addEventListener('click', function () {
            document.querySelectorAll('[data-avail-hidden="1"]').forEach(function (row) {
                row.classList.remove('detail-avail-row-hidden');
                row.removeAttribute('data-avail-hidden');
            });
            button.style.display = 'none';
        });
    }

    document.addEventListener('click', function (event) {
        var clickedRow = event.target.closest('.detail-avail-row');
        document.querySelectorAll('.detail-avail-popover.show').forEach(function (popover) {
            if (!clickedRow || !clickedRow.contains(popover)) {
                popover.classList.remove('show');
            }
        });

        if (!clickedRow) return;
        var popover = clickedRow.querySelector('.detail-avail-popover');
        if (popover) {
            popover.classList.toggle('show');
        }
    });
})();
</script>
