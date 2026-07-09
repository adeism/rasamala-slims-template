<?php
/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 2019-01-30 00:58
 * @File name           : detail_template.php
 * @Last modified by    : Ade Ismail Siregar (adeismailbox@gmail.com)
 * @Last modified time  : 2026-07-09T09:16:12+07:00
 */
include_once __DIR__ . '/theme_helpers.php';

$biblio_id_safe = themeSafeInt($biblio_id ?? 0);
$title_attr = themeEscape(strip_tags($title ?? ''));
$setBookmarked = trim(isset($_SESSION['bookmark'][$biblio_id_safe]) ? 'bg-success text-white rounded-lg px-2 py-1' : 'text-muted px-2 py-1');
$detail_title_html = themeParallelTitleHtml($title ?? '', 'detail');
?>

<div class="container">
    <div class="detail-record p-4 p-md-5">
        <div class="row">
            <div class="col-md-3 mb-4 text-center text-md-left">
                <div class="p-4 bg-apple-light rounded mb-3 detail-cover-wrapper">
                    <div class="shadow-sm detail-cover">
                      <?= themeSanitizeHtml($image); ?>
                    </div>
                </div>
                <div class="d-flex flex-row justify-content-center justify-content-md-start text-sm my-3">
                    <a href="#" data-id="<?= $biblio_id_safe ?>" data-detail="true" class="bookMarkBook text-decoration-none <?= themeEscape($setBookmarked) ?> font-weight-bolder mr-3 detail-link-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-postcard-heart mr-1" viewBox="0 0 16 16">
                            <path d="M8 4.5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7Zm3.5.878c1.482-1.42 4.795 1.392 0 4.622-4.795-3.23-1.482-6.043 0-4.622ZM2.5 5a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3Zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3Zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3Z"/>
                            <path fill-rule="evenodd" d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H2Z"/>
                        </svg>
                        <?= themeEscape(in_array($biblio_id_safe, $_SESSION['bookmark']??[]) ? __('Bookmarked') : __('Bookmark')) ?>
                    </a>
                    <a href="javascript:void(0)" data-toggle="modal" data-id="<?= $biblio_id_safe ?>" data-title="<?= $title_attr ?>" data-target="#mediaSocialModal" class="text-decoration-none font-weight-bold px-2 py-1 detail-link-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-share mr-1" viewBox="0 0 16 16">
                            <path d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5zm-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3z"/>
                        </svg>
                        <?= themeEscape(__('Share')) ?>
                    </a>
                </div>
            </div>
            <div class="col-md-9 p-0 px-md-4">
                <p class="lead mb-2 detail-gmd-label"><i class="fas fa-bookmark text-success mr-2"></i> <?= themeEscape($gmd_name); ?></p>
                <blockquote class="blockquote border-0 p-0 m-0 mb-3">
                    <h3 class="mb-2 font-weight-bold detail-title"><?= $detail_title_html; ?></h3>
                    <footer class="blockquote-footer bg-transparent border-0 p-0 m-0 mt-1 detail-author-footer"><?= themeSanitizeHtml(str_replace("<br />", '; ', $authors ?? '')); ?></footer>
                </blockquote>
                <hr class="apple-divider">
                <p class="detail-description">
              <?= $notes ? themeSanitizeHtml($notes) : '<i>'.themeEscape(__('Description Not Available')).'</i>'; ?>
            </p>
            <hr class="apple-divider">

            <h5 class="mt-4 mb-1"><?= __('Availability'); ?></h5>
            <?= ($availability) ? themeSanitizeHtml($availability) : '<p class="text-muted">' . themeEscape(__('No copy data')) . '</p>'; ?>
            <h5 class="mt-4 mb-1"><?= __('Detail Information'); ?></h5>
            <dl class="row">
                <dt class="col-sm-3"><?= __('Series Title'); ?></dt>
                <dd class="col-sm-9">
                    <div itemprop="alternativeHeadline"
                         property="alternativeHeadline"><?php echo themeEscape(($series_title) ? $series_title : '-'); ?></div>
                </dd>

                <dt class="col-sm-3"><?= __('Call Number'); ?></dt>
                <dd class="col-sm-9">
                    <div><?php echo themeEscape(($call_number) ? $call_number : '-'); ?></div>
                </dd>
                <dt class="col-sm-3"><?= __('Publisher'); ?></dt>
                <dd class="col-sm-9">
                    <span itemprop="publisher" property="publisher" itemtype="http://schema.org/Organization"
                          itemscope><?php echo themeEscape($publish_place) ?></span> :
                    <span itemprop="publisher" property="publisher"><?php echo themeEscape($publisher_name) ?></span>.,
                    <span itemprop="datePublished" property="datePublished"><?php echo themeEscape($publish_year) ?></span>
                </dd>
                <dt class="col-sm-3"><?= __('Collation'); ?></dt>
                <dd class="col-sm-9">
                    <div itemprop="numberOfPages"
                         property="numberOfPages"><?php echo themeEscape(($collation) ? $collation : '-'); ?></div>
                </dd>
                <dt class="col-sm-3"><?= __('Language'); ?></dt>
                <dd class="col-sm-9">
                    <div>
                        <meta itemprop="inLanguage" property="inLanguage"
                              content="<?php echo themeEscape($language_name) ?>"/><?php echo themeEscape($language_name) ?></div>
                </dd>
                <dt class="col-sm-3"><?= __('ISBN/ISSN'); ?></dt>
                <dd class="col-sm-9">
                    <div itemprop="isbn" property="isbn"><?php echo themeEscape(($isbn_issn) ? $isbn_issn : '-'); ?></div>
                </dd>
                <dt class="col-sm-3"><?= __('Classification'); ?></dt>
                <dd class="col-sm-9">
                    <div><?php echo themeEscape(($classification) ? $classification : '-'); ?></div>
                </dd>
                <dt class="col-sm-3"><?= __('Content Type'); ?></dt>
                <dd class="col-sm-9">
                    <div itemprop="bookFormat"
                         property="bookFormat"><?php echo themeEscape(($content_type) ? $content_type : '-'); ?></div>
                </dd>
                <dt class="col-sm-3"><?= __('Media Type'); ?></dt>
                <dd class="col-sm-9">
                    <div itemprop="bookFormat"
                         property="bookFormat"><?php echo themeEscape(($media_type) ? $media_type : '-'); ?></div>
                </dd>
                <dt class="col-sm-3"><?= __('Carrier Type'); ?></dt>
                <dd class="col-sm-9">
                    <div itemprop="bookFormat"
                         property="bookFormat"><?php echo themeEscape(($carrier_type) ? $carrier_type : '-'); ?></div>
                </dd>
                <dt class="col-sm-3"><?= __('Edition'); ?></dt>
                <dd class="col-sm-9">
                    <div itemprop="bookEdition" property="bookEdition"><?php echo themeEscape(($edition) ? $edition : '-'); ?></div>
                </dd>
                <dt class="col-sm-3"><?= __('Subject(s)'); ?></dt>
                <dd class="col-sm-9">
                    <div class="s-subject" itemprop="keywords"
                         property="keywords"><?php echo ($subjects) ? themeSanitizeHtml($subjects) : '-'; ?></div>
                </dd>
                <dt class="col-sm-3"><?= __('Specific Detail Info'); ?></dt>
                <dd class="col-sm-9">
                    <div><?php echo themeEscape(($spec_detail_info) ? $spec_detail_info : '-'); ?></div>
                </dd>
                <dt class="col-sm-3"><?= __('Statement of Responsibility'); ?></dt>
                <dd class="col-sm-9">
                    <div itemprop="author" property="author"><?php echo themeEscape(($sor) ? $sor : '-'); ?></div>
                </dd>
            </dl>

          <?php if (count($biblio_custom) > 0) {
            ; ?>
              <h5 class="mt-4 mb-1"><?= __('Other Information'); ?></h5>
              <dl class="row">
                <?php foreach ($biblio_custom as $item) { ?>
                    <dt class="col-sm-3"><?= themeEscape($item['label']); ?></dt>
                    <dd class="col-sm-9">
                        <div itemprop="alternativeHeadline"
                             property="alternativeHeadline"><?php echo themeEscape(($item['value']) ? $item['value'] : '-'); ?></div>
                    </dd>
                <?php }; ?>
              </dl>
          <?php }; ?>

            <h5 class="mt-4 mb-1"><?= __('Other version/related'); ?></h5>
            <div>
              <?php echo ($related) ? themeSanitizeHtml($related) : '<p class="text-muted">' . themeEscape(__('No other version available')) . '</p>'; ?>
            </div>

            <h5 id="attachment" class="mt-4 mb-1"><?= __('File Attachment'); ?></h5>
            <div itemprop="associatedMedia">
              <?= !$file_att ? '<i>'.themeEscape(__('No Data')).'</i>' : themeSanitizeHtml($file_att) ; ?>
            </div>

            <h5 id="comment" class="mt-4 mb-1"><?= __('Comments'); ?></h5>
          <?php echo showComment($biblio_id_safe); ?>
          <?php if(!isset($_SESSION['mid']) && $sysconf['comment']['enable']) : ?>
              <hr class="apple-divider">
              <a href="index.php?p=member" class="btn btn-outline-primary"><?= themeEscape(__('You must be logged in to post a comment')); ?></a>
          <?php endif; ?>
        </div>
    </div>
</div>
</div>
