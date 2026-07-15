<?php
/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 2019-01-30 00:58
 * @File name           : detail_template.php
 * @Last modified by    : Ade Ismail Siregar (adeismailbox@gmail.com)
 * @Last modified time  : 2026-07-15T08:25:01+07:00
 */
include_once __DIR__ . '/theme_helpers.php';

global $dbs;

$biblio_id_safe = themeSafeInt($biblio_id ?? 0);
$title_attr = themeEscape(strip_tags($title ?? ''));
$setBookmarked = trim(isset($_SESSION['bookmark'][$biblio_id_safe]) ? 'bg-success text-white rounded-3 px-2 py-1' : 'text-muted px-2 py-1');
$detail_title_html = themeParallelTitleHtml($title ?? '', 'detail');
if (themeShouldGenerateBookCover($image ?? '', $sysconf)) {
    $image = themeGenerateBookCoverHtml($title ?? '');
}

$availability_html = $availability ?? '';
$detail_has_value = function ($value) {
    if (is_array($value)) {
        $value = implode(' ', $value);
    }

    $clean_value = trim(html_entity_decode(strip_tags((string) ($value ?? '')), ENT_QUOTES, 'UTF-8'));
    return $clean_value !== '' && $clean_value !== '-';
};
$detail_row = function ($label, $html, $value = null) use ($detail_has_value) {
    $check_value = $value ?? $html;
    if (!$detail_has_value($check_value)) {
        return;
    }
    ?>
                <dt class="col-sm-3"><?= themeEscape($label); ?></dt>
                <dd class="col-sm-9"><?= $html; ?></dd>
    <?php
};
$publisher_html = '';
if ($detail_has_value($publish_place ?? '')) {
    $publisher_html .= '<span itemprop="publisher" property="publisher" itemtype="http://schema.org/Organization" itemscope>' . themeEscape($publish_place) . '</span>';
}
if ($detail_has_value($publisher_name ?? '')) {
    $publisher_html .= ($publisher_html !== '' ? ' : ' : '') . '<span itemprop="publisher" property="publisher">' . themeEscape($publisher_name) . '</span>';
}
if ($detail_has_value($publish_year ?? '')) {
    $publisher_html .= ($publisher_html !== '' ? '., ' : '') . '<span itemprop="datePublished" property="datePublished">' . themeEscape($publish_year) . '</span>';
}

$subjects_inline_html = '';
if ($detail_has_value($subjects ?? '')) {
    $subject_parts = array_filter(preg_split('/\s*<br\s*\/?>\s*/i', (string) $subjects), $detail_has_value);
    $subjects_inline_html = implode(' <span class="detail-subject-separator">; </span> ', $subject_parts);
}

$detail_callnumber_tags = function ($dbs, $biblio_id, $fallback_call_number = '') use ($detail_has_value) {
    $call_numbers = [];
    $location_names = [];
    if ($dbs && method_exists($dbs, 'query')) {
        $biblio_id = themeSafeInt($biblio_id);
        $query = $dbs->query("SELECT DISTINCT i.call_number, ml.location_name, i.site
            FROM item AS i
            LEFT JOIN mst_location AS ml ON i.location_id=ml.location_id
            WHERE i.biblio_id=".$biblio_id."
            ORDER BY ml.location_name ASC, i.call_number ASC");
        if ($query) {
            while ($row = $query->fetch_assoc()) {
                $call_number = trim($row['call_number'] ?? '');
                if ($detail_has_value($call_number)) {
                    $location = trim($row['location_name'] ?? '');
                    if ($location === '') {
                        $location = __('Location name is not set');
                    }
                    if (trim($row['site'] ?? '') !== '') {
                        $location .= ' (' . trim($row['site']) . ')';
                    }
                    $call_numbers[] = [
                        'call_number' => $call_number,
                        'location' => $location,
                    ];
                    $location_names[$location] = true;
                }
            }
        }
    }

    if (!$call_numbers && $detail_has_value($fallback_call_number)) {
        $call_numbers[] = [
            'call_number' => trim((string) $fallback_call_number),
            'location' => '',
        ];
    }

    if (!$call_numbers) {
        return '';
    }

    $has_multiple_locations = count($location_names) > 1;
    $seen = [];
    $output = '<div class="detail-callnumber-strip">';
    $output .= '<div class="detail-callnumber-label">' . themeEscape(__('Call Number')) . '</div>';
    foreach ($call_numbers as $item) {
        $display_call_number = $item['call_number'];
        if ($has_multiple_locations && $item['location'] !== '') {
            $display_call_number .= ' - ' . $item['location'];
        }
        if (isset($seen[$display_call_number])) {
            continue;
        }
        $seen[$display_call_number] = true;
        $output .= '<span class="detail-callnumber-tag" title="' . themeEscape(__('Call Number')) . '">' . themeEscape($display_call_number) . '</span>';
    }
    $output .= '</div>';

    return $output;
};

$detail_availability_html = function ($dbs, $biblio_id, $fallback_html) use ($detail_has_value) {
    if (!$dbs || !method_exists($dbs, 'query')) {
        return $detail_has_value($fallback_html) ? themeSanitizeHtml($fallback_html) : '';
    }

    $biblio_id = themeSafeInt($biblio_id);
    $sql = "SELECT i.item_code, i.call_number, ml.location_name, i.site,
                   mis.item_status_name, IFNULL(mis.no_loan, 0) AS no_loan,
                   CASE
                       WHEN EXISTS (
                           SELECT 1 FROM loan AS l
                           WHERE l.item_code=i.item_code
                             AND l.is_lent=1
                             AND l.is_return=0
                       ) THEN 1
                       ELSE 0
                   END AS is_onloan
            FROM item AS i
            LEFT JOIN mst_location AS ml ON i.location_id=ml.location_id
            LEFT JOIN mst_item_status AS mis ON i.item_status_id=mis.item_status_id
            WHERE i.biblio_id=".$biblio_id."
            ORDER BY ml.location_name ASC, i.call_number ASC, i.item_code ASC";
    $query = $dbs->query($sql);
    if (!$query || $query->num_rows < 1) {
        return '';
    }

    $locations = [];
    while ($item = $query->fetch_assoc()) {
        $location = trim($item['location_name'] ?? '');
        if ($location === '') {
            $location = __('Location name is not set');
        }
        if (trim($item['site'] ?? '') !== '') {
            $location .= ' (' . trim($item['site']) . ')';
        }

        $key = md5($location);
        if (!isset($locations[$key])) {
            $locations[$key] = [
                'name' => $location,
                'total' => 0,
                'available' => 0,
                'call_numbers' => [],
                'statuses' => [],
                'items' => [],
            ];
        }

        $is_available = themeSafeInt($item['is_onloan'] ?? 0) < 1 && themeSafeInt($item['no_loan'] ?? 0) < 1;
        $status = $is_available ? __('Available') : trim($item['item_status_name'] ?? '');
        if (!$is_available && themeSafeInt($item['is_onloan'] ?? 0) > 0) {
            $status = __('Currently On Loan');
        } elseif ($status === '') {
            $status = __('Not Available');
        }

        $call_number = trim($item['call_number'] ?? '');
        if ($call_number !== '') {
            $locations[$key]['call_numbers'][$call_number] = true;
        }

        $locations[$key]['total']++;
        $locations[$key]['available'] += $is_available ? 1 : 0;
        $locations[$key]['statuses'][$status] = ($locations[$key]['statuses'][$status] ?? 0) + 1;
        $locations[$key]['items'][] = [
            'item_code' => $item['item_code'] ?? '-',
            'call_number' => $call_number !== '' ? $call_number : '-',
            'is_available' => $is_available,
            'status' => $status,
        ];
    }

    $max_location_rows = 3;
    $location_index = 0;
    $total_locations = count($locations);
    $output = '<div class="detail-avail-rows">';
    foreach ($locations as $location) {
        $location_index++;
        $hidden_attr = $location_index > $max_location_rows ? ' style="display:none;" data-avail-hidden="1"' : '';
        $count_class = $location['available'] > 0 ? 'avail-count-ok' : 'avail-count-no';
        $item_rows = '';

        foreach ($location['items'] as $item) {
            $item_code = themeEscape($item['item_code'] ?? '-');
            $call_number = themeEscape($item['call_number'] ?? '-');
            $item_location = themeEscape($location['name']);
            $is_available = !empty($item['is_available']);
            $status_icon = $is_available ? 'fas fa-check-circle avail-badge-ok' : 'fas fa-times-circle avail-badge-no';
            $status_text = $is_available ? __('Available') : ($item['status'] ?? __('Not Available'));
            $item_rows .= '<tr>';
            $item_rows .= '<td>' . $item_code . '</td>';
            $item_rows .= '<td>' . $call_number . '</td>';
            $item_rows .= '<td>' . $item_location . '</td>';
            $item_rows .= '<td class="text-center"><i class="' . themeEscape($status_icon) . '" title="' . themeEscape($status_text) . '" aria-label="' . themeEscape($status_text) . '"></i></td>';
            $item_rows .= '</tr>';
        }

        $output .= '<div class="detail-avail-row biblio-avail-wrap" tabindex="0"' . $hidden_attr . '>';
        $output .= '<div class="avail-loc-callno"><span class="avail-loc-name">' . themeEscape($location['name']) . '</span></div>';
        $output .= '<span class="avail-count ' . themeEscape($count_class) . '">';
        $output .= '<i class="' . ($location['available'] > 0 ? 'fas fa-check-circle' : 'fas fa-times-circle') . '" aria-hidden="true"></i> ';
        $output .= themeSafeInt($location['available']) . '/' . themeSafeInt($location['total']);
        $output .= '</span>';

        if ($item_rows !== '') {
            $output .= '<div class="biblio-avail-popover detail-avail-popover">';
            $output .= '<div class="detail-avail-popover-title">' . themeEscape(__('Item Detail')) . ' (' . themeSafeInt($location['total']) . ') - ' . themeEscape($location['name']) . '</div>';
            $output .= '<table class="detail-avail-popover-table">';
            $output .= '<thead><tr><th>' . themeEscape(__('Code')) . '</th><th>' . themeEscape(__('Call Number')) . '</th><th>' . themeEscape(__('Location')) . '</th><th class="text-center">' . themeEscape(__('Status')) . '</th></tr></thead>';
            $output .= '<tbody>' . $item_rows . '</tbody>';
            $output .= '</table>';
            $output .= '</div>';
        }
        $output .= '</div>';
    }
    $output .= '</div>';

    if ($total_locations > $max_location_rows) {
        $output .= '<div class="detail-avail-more">';
        $output .= '<button type="button" class="btn btn-link btn-sm p-0 detail-avail-more-btn" data-detail-avail-more>';
        $output .= '<i class="fas fa-chevron-down me-1" aria-hidden="true"></i>' . themeEscape(sprintf(__('Show %d more locations'), $total_locations - $max_location_rows));
        $output .= '</button>';
        $output .= '</div>';
    }

    return $output;
};
?>

<div class="container">
    <div class="detail-record p-4 p-md-5">
        <div class="row">
            <div class="col-md-3 mb-4 text-center text-md-left">
                <div class="p-4 bg-rasamala-light rounded mb-3 detail-cover-wrapper">
                    <div class="shadow-sm detail-cover mb-3">
                      <?= themeSanitizeHtml($image); ?>
                    </div>
                    <?= $detail_callnumber_tags($dbs ?? null, $biblio_id_safe, $call_number ?? ''); ?>
                </div>
                <div class="detail-side-availability">
                    <h5 class="detail-side-heading"><?= __('Availability'); ?></h5>
                    <?php
                    $availability_output = $detail_availability_html($dbs ?? null, $biblio_id_safe, $availability_html);
                    echo $detail_has_value($availability_output) ? $availability_output : '<p class="text-muted">' . themeEscape(__('No copy data')) . '</p>';
                    ?>
                </div>
            </div>
            <div class="col-md-9 px-3 px-md-4">
                <div class="detail-meta-row">
                    <?php
                    $label_type = themeEffectiveTemplateValue('classic_detail_label_type', 'gmd', $sysconf);
                    $display_label = $gmd_name; // Fallback
                    if ($label_type === 'coll_type') {
                        $coll_type_name = '';
                        if ($dbs && method_exists($dbs, 'query')) {
                            $coll_query = $dbs->query("SELECT GROUP_CONCAT(DISTINCT mct.coll_type_name ORDER BY mct.coll_type_name SEPARATOR ', ') AS coll_type_name
                                FROM item AS i
                                LEFT JOIN mst_coll_type AS mct ON i.coll_type_id = mct.coll_type_id
                                WHERE i.biblio_id = " . $biblio_id_safe);
                            if ($coll_query && $coll_query->num_rows > 0) {
                                $coll_data = $coll_query->fetch_assoc();
                                $coll_type_name = trim($coll_data['coll_type_name'] ?? '');
                            }
                        }
                        if ($detail_has_value($coll_type_name)) {
                            $display_label = $coll_type_name;
                        }
                    }
                    ?>
                    <p class="lead mb-0 detail-gmd-label"><i class="fas fa-bookmark text-success me-2"></i> <?= themeEscape($display_label); ?></p>
                    <div class="detail-actions">
                        <a href="#" data-id="<?= $biblio_id_safe ?>" data-detail="true" class="bookMarkBook text-decoration-none <?= themeEscape($setBookmarked) ?> fw-bolder detail-link-btn">
                            <i class="<?= in_array($biblio_id_safe, $_SESSION['bookmark']??[]) ? 'fas' : 'far' ?> fa-bookmark" aria-hidden="true"></i>
                            <?= themeEscape(in_array($biblio_id_safe, $_SESSION['bookmark']??[]) ? __('Bookmarked') : __('Bookmark')) ?>
                        </a>
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-id="<?= $biblio_id_safe ?>" data-title="<?= $title_attr ?>" data-bs-target="#mediaSocialModal" class="text-decoration-none fw-bold detail-link-btn">
                            <i class="fas fa-share-alt" aria-hidden="true"></i>
                            <?= themeEscape(__('Share')) ?>
                        </a>
                    </div>
                </div>
                <blockquote class="blockquote border-0 p-0 m-0 mb-3">
                    <h3 class="mb-2 fw-bold detail-title"><?= $detail_title_html; ?></h3>
                    <?php
                    $show_author_role = themeEffectiveTemplateValue('classic_show_author_role', 1, $sysconf) ? true : false;
                    $formatted_authors = themeFormatDetailAuthors($authors ?? '', $show_author_role);
                    ?>
                    <div class="blockquote-footer bg-transparent border-0 p-0 m-0 mt-2 detail-author-footer"><?= themeSanitizeHtml($formatted_authors); ?></div>
                </blockquote>
                <?php if ($detail_has_value($notes ?? '')): ?>
                <div class="detail-notes-box mb-4">
                    <div class="detail-notes-header">
                        <i class="fas fa-align-left" aria-hidden="true"></i><?= __('Description'); ?>
                    </div>
                    <div class="detail-notes-content">
                        <?= themeSanitizeHtml($notes); ?>
                    </div>
                </div>
                <?php else: ?>
                <p class="detail-notes-empty">
                    <i class="fas fa-info-circle" aria-hidden="true"></i><?= __('Description Not Available'); ?>
                </p>
                <?php endif; ?>

            <h5 class="mt-4 mb-1"><?= __('Detail Information'); ?></h5>
            <dl class="row">
                <?php
                $detail_row(__('Series Title'), '<div itemprop="alternativeHeadline" property="alternativeHeadline">' . themeEscape($series_title ?? '') . '</div>', $series_title ?? '');
                $detail_row(__('Publisher'), $publisher_html, implode(' ', [$publish_place ?? '', $publisher_name ?? '', $publish_year ?? '']));
                $detail_row(__('Collation'), '<div itemprop="numberOfPages" property="numberOfPages">' . themeEscape($collation ?? '') . '</div>', $collation ?? '');
                $detail_row(__('Language'), '<div><meta itemprop="inLanguage" property="inLanguage" content="' . themeEscape($language_name ?? '') . '"/>' . themeEscape($language_name ?? '') . '</div>', $language_name ?? '');
                $detail_row(__('ISBN/ISSN'), '<div itemprop="isbn" property="isbn">' . themeEscape($isbn_issn ?? '') . '</div>', $isbn_issn ?? '');
                $detail_row(__('Classification'), '<div>' . themeEscape($classification ?? '') . '</div>', $classification ?? '');
                $detail_row(__('Content Type'), '<div itemprop="bookFormat" property="bookFormat">' . themeEscape($content_type ?? '') . '</div>', $content_type ?? '');
                $detail_row(__('Media Type'), '<div itemprop="bookFormat" property="bookFormat">' . themeEscape($media_type ?? '') . '</div>', $media_type ?? '');
                $detail_row(__('Carrier Type'), '<div itemprop="bookFormat" property="bookFormat">' . themeEscape($carrier_type ?? '') . '</div>', $carrier_type ?? '');
                $detail_row(__('Edition'), '<div itemprop="bookEdition" property="bookEdition">' . themeEscape($edition ?? '') . '</div>', $edition ?? '');
                $detail_row(__('Subject(s)'), '<div class="s-subject detail-subject-inline" itemprop="keywords" property="keywords">' . themeSanitizeHtml($subjects_inline_html) . '</div>', $subjects ?? '');
                $detail_row(__('Specific Detail Info'), '<div>' . themeEscape($spec_detail_info ?? '') . '</div>', $spec_detail_info ?? '');
                $detail_row(__('Statement of Responsibility'), '<div itemprop="author" property="author">' . themeEscape($sor ?? '') . '</div>', $sor ?? '');
                ?>
            </dl>

          <?php
          $visible_custom_fields = array_filter($biblio_custom ?? [], function ($item) use ($detail_has_value) {
              return $detail_has_value($item['value'] ?? '');
          });
          if (count($visible_custom_fields) > 0) {
            ; ?>
              <h5 class="mt-4 mb-1"><?= __('Other Information'); ?></h5>
              <dl class="row">
                <?php foreach ($visible_custom_fields as $item) { ?>
                    <dt class="col-sm-3"><?= themeEscape($item['label']); ?></dt>
                    <dd class="col-sm-9">
                        <div itemprop="alternativeHeadline"
                             property="alternativeHeadline"><?php echo themeEscape($item['value']); ?></div>
                    </dd>
                <?php }; ?>
              </dl>
          <?php }; ?>

            <?php if ($detail_has_value($related ?? '')) : ?>
                <h5 class="mt-4 mb-1"><?= __('Other version/related'); ?></h5>
                <div>
                  <?php echo themeSanitizeHtml($related); ?>
                </div>
            <?php endif; ?>

            <?php if ($detail_has_value($file_att ?? '')) : ?>
                <h5 id="attachment" class="mt-4 mb-1"><?= __('File Attachment'); ?></h5>
                <div itemprop="associatedMedia">
                  <?= themeSanitizeHtml($file_att); ?>
                </div>
            <?php endif; ?>

            <h5 id="comment" class="mt-4 mb-1"><?= __('Comments'); ?></h5>
          <?php echo showComment($biblio_id_safe); ?>
          <?php if(!isset($_SESSION['mid']) && $sysconf['comment']['enable']) : ?>
              <hr class="rasamala-divider">
              <a href="index.php?p=member" class="btn btn-outline-primary"><?= themeEscape(__('You must be logged in to post a comment')); ?></a>
          <?php endif; ?>
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
                row.style.display = '';
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
