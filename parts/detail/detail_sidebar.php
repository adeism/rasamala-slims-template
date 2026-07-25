<?php
/**
 * Book Detail Component - Left Sidebar (Cover, Call Number Tags, Side Availability)
 */
if (!defined('INDEX_AUTH') || INDEX_AUTH != 1) {
  die("can not access this file directly");
}
?>
<div class="col-md-3 mb-4 text-center text-md-left detail-sidebar-col">
    <div class="detail-cover-wrapper">
        <div class="detail-cover">
          <?= themeSanitizeHtml($image); ?>
        </div>
        <?= themeDetailCallNumberTags($dbs ?? null, $biblio_id_safe, $call_number ?? ''); ?>
    </div>
    <div class="detail-side-availability">
        <div class="detail-avail-heading-row d-flex align-items-center justify-content-between mb-2">
            <h5 class="detail-side-heading mb-0"><?= __('Availability'); ?></h5>
        </div>
        <?php
        $availability_output = themeDetailAvailabilityHtml($dbs ?? null, $biblio_id_safe, $availability_html);
        echo themeDetailHasValue($availability_output) ? $availability_output : '<p class="text-muted">' . themeEscape(__('No copy data')) . '</p>';
        ?>

        <!-- Desktop QR Code Box below Availability -->
        <div class="detail-qr-card-desktop d-none d-md-block mt-4 text-center">
            <div class="detail-qr-box p-3">
                <div class="detail-qr-img-wrap mb-2">
                    <?= $qrcode_svg ?? ''; ?>
                </div>
                <span class="detail-qr-label text-muted d-block small fw-bold">
                    <i class="fas fa-qrcode me-1 text-primary"></i> Scan for Link
                </span>
            </div>
        </div>
    </div>
</div>
