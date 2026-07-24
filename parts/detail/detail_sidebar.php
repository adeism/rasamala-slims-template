<?php
/**
 * Book Detail Component - Left Sidebar (Cover, Call Number Tags, Side Availability)
 */
if (!defined('INDEX_AUTH') || INDEX_AUTH != 1) {
  die("can not access this file directly");
}
?>
<div class="col-md-3 mb-4 text-center text-md-left">
    <div class="p-4 bg-rasamala-light rounded mb-3 detail-cover-wrapper">
        <div class="shadow-sm detail-cover mb-3">
          <?= themeSanitizeHtml($image); ?>
        </div>
        <?= themeDetailCallNumberTags($dbs ?? null, $biblio_id_safe, $call_number ?? ''); ?>
    </div>
    <div class="detail-side-availability">
        <h5 class="detail-side-heading"><?= __('Availability'); ?></h5>
        <?php
        $availability_output = themeDetailAvailabilityHtml($dbs ?? null, $biblio_id_safe, $availability_html);
        echo themeDetailHasValue($availability_output) ? $availability_output : '<p class="text-muted">' . themeEscape(__('No copy data')) . '</p>';
        ?>
    </div>
</div>
