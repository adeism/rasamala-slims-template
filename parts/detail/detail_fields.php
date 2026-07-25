<?php
/**
 * Book Detail Component - Main Record Meta, Fields & Related Content
 */
if (!defined('INDEX_AUTH') || INDEX_AUTH != 1) {
  die("can not access this file directly");
}
?>
<div class="col-md-9 px-3 px-md-4 detail-content-col">
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
            if (themeDetailHasValue($coll_type_name)) {
                $display_label = $coll_type_name;
            }
        }
        ?>
        <p class="lead mb-0 detail-gmd-label"><i class="fas fa-bookmark text-success me-2"></i> <?= themeEscape($display_label); ?></p>
        <div class="detail-actions">
            <a href="index.php?p=member&sec=bookmark" data-id="<?= $biblio_id_safe ?>" data-detail="true" class="bookMarkBook btn-theme-bookmark <?= themeEscape($setBookmarked) ?>">
                <i class="<?= in_array($biblio_id_safe, $_SESSION['bookmark']??[]) ? 'fas' : 'far' ?> fa-bookmark" aria-hidden="true"></i>
                <span id="label-<?= $biblio_id_safe ?>"><?= themeEscape(in_array($biblio_id_safe, $_SESSION['bookmark']??[]) ? __('Bookmarked') : __('Bookmark')) ?></span>
            </a>
            <a href="index.php?p=sharelink&id=<?= $biblio_id_safe ?>" data-bs-toggle="modal" data-id="<?= $biblio_id_safe ?>" data-title="<?= $title_attr ?>" data-bs-target="#mediaSocialModal" class="btn-theme-share detail-share-btn">
                <i class="fas fa-share-alt" aria-hidden="true"></i>
                <span><?= themeEscape(__('Share')) ?></span>
            </a>
        </div>
    </div>
    <blockquote class="detail-title-block">
        <h3 class="mb-2 fw-bold detail-title"><?= $detail_title_html; ?></h3>
        <?php
        $show_author_role = themeEffectiveTemplateValue('classic_show_author_role', 1, $sysconf) ? true : false;
        $formatted_authors = themeFormatDetailAuthors($authors ?? '', $show_author_role);
        ?>
        <div class="detail-author-footer"><?= themeSanitizeHtml($formatted_authors); ?></div>
    </blockquote>
    <?php if (themeDetailHasValue($notes ?? '')): ?>
    <div class="detail-notes-box mb-4">
        <div class="detail-notes-header">
            <i class="fas fa-align-left" aria-hidden="true"></i><?= __('Description'); ?>
        </div>
        <div class="detail-notes-content">
            <?= themeDetailNotesHtml($notes); ?>
        </div>
    </div>
    <?php else: ?>
    <p class="detail-notes-empty">
        <i class="fas fa-info-circle" aria-hidden="true"></i><?= __('Description Not Available'); ?>
    </p>
    <?php endif; ?>

    <h5 class="detail-section-heading detail-section-heading-info"><?= __('Detail Information'); ?></h5>
    <dl class="row detail-info-list">
        <?php
        themeDetailRow(__('Series Title'), '<div itemprop="alternativeHeadline" property="alternativeHeadline">' . themeEscape($series_title ?? '') . '</div>', $series_title ?? '');
        themeDetailRow(__('Publisher'), $publisher_html, implode(' ', [$publish_place ?? '', $publisher_name ?? '', $publish_year ?? '']));
        themeDetailRow(__('Collation'), '<div itemprop="numberOfPages" property="numberOfPages">' . themeEscape($collation ?? '') . '</div>', $collation ?? '');
        themeDetailRow(__('Language'), '<div><meta itemprop="inLanguage" property="inLanguage" content="' . themeEscape($language_name ?? '') . '"/>' . themeEscape($language_name ?? '') . '</div>', $language_name ?? '');
        themeDetailRow(__('ISBN/ISSN'), '<div itemprop="isbn" property="isbn">' . themeEscape($isbn_issn ?? '') . '</div>', $isbn_issn ?? '');
        themeDetailRow(__('Classification'), '<div>' . themeEscape($classification ?? '') . '</div>', $classification ?? '');
        themeDetailRow(__('Content Type'), '<div itemprop="bookFormat" property="bookFormat">' . themeEscape($content_type ?? '') . '</div>', $content_type ?? '');
        themeDetailRow(__('Media Type'), '<div itemprop="bookFormat" property="bookFormat">' . themeEscape($media_type ?? '') . '</div>', $media_type ?? '');
        themeDetailRow(__('Carrier Type'), '<div itemprop="bookFormat" property="bookFormat">' . themeEscape($carrier_type ?? '') . '</div>', $carrier_type ?? '');
        themeDetailRow(__('Edition'), '<div itemprop="bookEdition" property="bookEdition">' . themeEscape($edition ?? '') . '</div>', $edition ?? '');
        themeDetailRow(__('Subject(s)'), '<div class="s-subject detail-subject-inline" itemprop="keywords" property="keywords">' . themeSanitizeHtml($subjects_inline_html) . '</div>', $subjects ?? '');
        themeDetailRow(__('Specific Detail Info'), '<div>' . themeEscape($spec_detail_info ?? '') . '</div>', $spec_detail_info ?? '');
        themeDetailRow(__('Statement of Responsibility'), '<div itemprop="author" property="author">' . themeEscape($sor ?? '') . '</div>', $sor ?? '');
        ?>
    </dl>

    <?php
    $visible_custom_fields = array_filter($biblio_custom ?? [], function ($item) {
        return themeDetailHasValue($item['value'] ?? '');
    });
    if (count($visible_custom_fields) > 0) {
      ; ?>
        <h5 class="detail-section-heading detail-section-heading-other"><?= __('Other Information'); ?></h5>
        <dl class="row detail-info-list">
          <?php foreach ($visible_custom_fields as $item) { ?>
              <dt class="col-sm-3"><?= themeEscape($item['label']); ?></dt>
              <dd class="col-sm-9">
                  <div itemprop="alternativeHeadline"
                       property="alternativeHeadline"><?php echo themeEscape($item['value']); ?></div>
              </dd>
          <?php }; ?>
        </dl>
    <?php }; ?>

    <?php if (themeDetailHasValue($related ?? '')) : ?>
        <h5 class="detail-section-heading detail-section-heading-related"><?= __('Other version/related'); ?></h5>
        <div>
          <?php echo themeSanitizeHtml($related); ?>
        </div>
    <?php endif; ?>

    <?php if (themeDetailHasValue($file_att ?? '')) : ?>
        <h5 id="attachment" class="detail-section-heading detail-section-heading-attachment"><?= __('File Attachment'); ?></h5>
        <div itemprop="associatedMedia">
          <?= themeSanitizeHtml($file_att); ?>
        </div>
    <?php endif; ?>

    <h5 id="comment" class="detail-section-heading detail-section-heading-comment"><?= __('Comments'); ?></h5>
    <?php echo showComment($biblio_id_safe); ?>
    <?php if(!isset($_SESSION['mid']) && $sysconf['comment']['enable']) : ?>
        <hr class="rasamala-divider">
        <a href="index.php?p=member" class="btn btn-outline-primary"><?= themeEscape(__('You must be logged in to post a comment')); ?></a>
    <?php endif; ?>
</div>
