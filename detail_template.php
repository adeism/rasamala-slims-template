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
?>

<div class="detail-record">
    <div class="row detail-main-row">
        <?php include __DIR__ . '/parts/detail/detail_sidebar.php'; ?>
        <?php include __DIR__ . '/parts/detail/detail_fields.php'; ?>
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
