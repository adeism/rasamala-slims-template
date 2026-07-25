<?php
/**
 * Unified Modal Dialogs for Rasamala Template
 * Includes: Advanced Search Modal, Topic Directory Modal, Social Share Modal
 */
if (!defined('INDEX_AUTH') || INDEX_AUTH != 1) {
  die("can not access this file directly");
}
?>

<!-- Advanced Search Modal -->
<div class="modal fade" id="adv-modal" tabindex="-1" aria-labelledby="advancedSearchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form class="modal-content border-0 rounded-4 shadow-lg" action="index.php" method="get">
            <div class="modal-header border-0 pb-0 px-4 pt-4 justify-content-between align-items-center">
                <h5 class="modal-title fw-bold d-flex align-items-center" id="advancedSearchModalLabel">
                    <i class="fas fa-sliders-h me-2" style="color: var(--rasamala-accent);" aria-hidden="true"></i><?= __('Advanced Search'); ?>
                </h5>
                <button type="button" class="btn-close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <div class="form-group mb-0">
                            <label for="adv-titles" class="form-label text-muted small fw-bold mb-1"><?= __('Title'); ?></label>
                            <input type="text" name="title" class="form-control" id="adv-titles"
                                   aria-label="<?= __('Title'); ?>"
                                   placeholder="<?= __('Title'); ?>">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group mb-0">
                            <label for="adv-author" class="form-label text-muted small fw-bold mb-1"><?= __('Author(s)'); ?></label>
                            <input type="text" name="author" class="form-control" id="adv-author"
                                   aria-label="<?= __('Author(s)'); ?>"
                                   placeholder="<?= __('Author(s)'); ?>">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group mb-0">
                            <label for="adv-subject" class="form-label text-muted small fw-bold mb-1"><?= __('Subject(s)'); ?></label>
                            <input type="text" name="subject" class="form-control" id="adv-subject"
                                   aria-label="<?= __('Subject(s)'); ?>"
                                   placeholder="<?= __('Subject(s)'); ?>">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group mb-0">
                            <label for="adv-isbn" class="form-label text-muted small fw-bold mb-1"><?= __('ISBN/ISSN'); ?></label>
                            <input type="text" name="isbn" class="form-control" id="adv-isbn"
                                   aria-label="<?= __('ISBN/ISSN'); ?>"
                                   placeholder="<?= __('ISBN/ISSN'); ?>">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group mb-0">
                            <label for="adv-publishyear" class="form-label text-muted small fw-bold mb-1"><?= __('Publish Year'); ?></label>
                            <input type="text" name="publishyear" class="form-control" id="adv-publishyear"
                                   aria-label="<?= __('Publish Year'); ?>"
                                   placeholder="<?= __('Publish Year'); ?>">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group mb-0">
                            <label for="adv-location" class="form-label text-muted small fw-bold mb-1"><?= __('Location'); ?></label>
                            <select id="adv-location" name="location"
                                    class="form-select" aria-label="<?= __('Location'); ?>"><?= commonList('location'); ?></select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group mb-0">
                            <label for="adv-gmd" class="form-label text-muted small fw-bold mb-1"><?= __('GMD / Media'); ?></label>
                            <select id="adv-gmd" name="gmd" class="form-select" aria-label="<?= __('GMD / Media'); ?>"><?= commonList('gmd'); ?></select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group mb-0">
                            <label for="adv-coll-type" class="form-label text-muted small fw-bold mb-1"><?= __('Collection Type'); ?></label>
                            <select name="colltype" class="form-select"
                                    id="adv-coll-type" aria-label="<?= __('Collection Type'); ?>"><?= commonList('collection'); ?></select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 px-4 pb-4 pt-0 justify-content-end">
                <button type="submit" name="search" value="search" class="btn btn-primary rounded-pill px-4 py-2 fw-bold d-inline-flex align-items-center">
                    <i class="fas fa-search me-2" aria-hidden="true"></i><?= __('Find Collection'); ?>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Topic Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="topicModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="topicModalLabel"><?= __('Select the topic you are interested in'); ?></h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="topic d-flex flex-wrap justify-content-center p-0">
                    <li class="d-flex justify-content-center align-items-center m-2">
                        <a href="index.php?callnumber=0&search=search" class="d-flex flex-column">
                            <i class="fas fa-desktop topic-icon-fa mb-3 mx-auto" aria-hidden="true"></i>
                            <span><?= __('Computer Science, Information & General Works'); ?></span>
                        </a>
                    </li>
                    <li class="d-flex justify-content-center align-items-center m-2">
                        <a href="index.php?callnumber=1&search=search" class="d-flex flex-column">
                            <i class="fas fa-lightbulb topic-icon-fa mb-3 mx-auto" aria-hidden="true"></i>
                            <span><?= __('Philosophy & Psychology'); ?></span>
                        </a>
                    </li>
                    <li class="d-flex justify-content-center align-items-center m-2">
                        <a href="index.php?callnumber=2&search=search" class="d-flex flex-column">
                            <i class="fas fa-heart topic-icon-fa mb-3 mx-auto" aria-hidden="true"></i>
                            <span><?= __('Religion'); ?></span>
                        </a>
                    </li>
                    <li class="d-flex justify-content-center align-items-center m-2">
                        <a href="index.php?callnumber=3&search=search" class="d-flex flex-column">
                            <i class="fas fa-users topic-icon-fa mb-3 mx-auto" aria-hidden="true"></i>
                            <span><?= __('Social Sciences'); ?></span>
                        </a>
                    </li>
                    <li class="d-flex justify-content-center align-items-center m-2">
                        <a href="index.php?callnumber=4&search=search" class="d-flex flex-column">
                            <i class="fas fa-language topic-icon-fa mb-3 mx-auto" aria-hidden="true"></i>
                            <span><?= __('Language'); ?></span>
                        </a>
                    </li>
                    <li class="d-flex justify-content-center align-items-center m-2">
                        <a href="index.php?callnumber=5&search=search" class="d-flex flex-column">
                            <i class="fas fa-calculator topic-icon-fa mb-3 mx-auto" aria-hidden="true"></i>
                            <span><?= __('Pure Science'); ?></span>
                        </a>
                    </li>
                    <li class="d-flex justify-content-center align-items-center m-2">
                        <a href="index.php?callnumber=6&search=search" class="d-flex flex-column">
                            <i class="fas fa-flask topic-icon-fa mb-3 mx-auto" aria-hidden="true"></i>
                            <span><?= __('Applied Sciences'); ?></span>
                        </a>
                    </li>
                    <li class="d-flex justify-content-center align-items-center m-2">
                        <a href="index.php?callnumber=7&search=search" class="d-flex flex-column">
                            <i class="fas fa-paint-brush topic-icon-fa mb-3 mx-auto" aria-hidden="true"></i>
                            <span><?= __('Art & Recreation'); ?></span>
                        </a>
                    </li>
                    <li class="d-flex justify-content-center align-items-center m-2">
                        <a href="index.php?callnumber=8&search=search" class="d-flex flex-column">
                            <i class="fas fa-book topic-icon-fa mb-3 mx-auto" aria-hidden="true"></i>
                            <span><?= __('Literature'); ?></span>
                        </a>
                    </li>
                    <li class="d-flex justify-content-center align-items-center m-2">
                        <a href="index.php?callnumber=9&search=search" class="d-flex flex-column">
                            <i class="fas fa-history topic-icon-fa mb-3 mx-auto" aria-hidden="true"></i>
                            <span><?= __('History & Geography'); ?></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Social Share Modal -->
<div class="modal fade social-share-modal" id="mediaSocialModal" tabindex="-1" role="dialog" aria-labelledby="mediaSocialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xs vertical-align-center" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="mediaSocialModalLabel"><?= __('Where do you want to share?') ?></h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="mediaSocialModalBody" class="modal-body">
            </div>
        </div>
    </div>
</div>
