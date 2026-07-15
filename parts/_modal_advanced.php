<?php
/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 2020-01-02 20:33
 * @File name           : _modal_advanced.php
 * @Last modified by    : Ade Ismail Siregar (adeismailbox@gmail.com)
 * @Last modified time  : 2026-07-15T15:16:37+07:00
 */


?>

<div class="modal fade" id="adv-modal" tabindex="-1" aria-labelledby="advancedSearchModalLabel"
     aria-hidden="true" inert>
    <div class="modal-dialog modal-lg">
        <form class="modal-content" action="index.php" method="get">
            <div class="modal-header">
                <h2 class="modal-title" id="advancedSearchModalLabel"><?=__('Advanced Search'); ?></h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label for="adv-titles"><?=__('Title'); ?></label>
                            <input type="text" name="title" class="form-control" id="adv-titles"
                                   placeholder="<?=__('Enter title'); ?>">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label for="adv-author"><?=__('Author(s)');?></label>
                            <input type="text" name="author" class="form-control" id="adv-author"
                                   placeholder="<?=__('Enter author(s) name'); ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label for="adv-subject"><?=__('Subject(s)');?></label>
                            <input type="text" name="subject" class="form-control" id="adv-subject"
                                   placeholder="<?=__('Enter subject'); ?>">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label for="adv-isbn"><?=__('ISBN/ISSN');?></label>
                            <input type="text" name="isbn" class="form-control" id="adv-isbn"
                                   placeholder="<?=__('Enter ISBN/ISSN'); ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label for="adv-publishyear"><?=__('Publish Year');?></label>
                            <input type="text" name="publishyear" class="form-control" id="adv-publishyear"
                                   placeholder="<?=__('Enter publish year'); ?>">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label for="adv-location"><?=__('Location');?></label>
                            <select id="adv-location" name="location"
                                    class="form-select"> <?= commonList('location'); ?></select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label for="adv-gmd"><?=__('GMD');?></label>
                            <select id="adv-gmd" name="gmd" class="form-select"><?= commonList('gmd'); ?></select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label for="adv-coll-type"><?=__('Collection Type');?></label>
                            <select name="colltype" class="form-select"
                                    id="adv-coll-type"><?= commonList('collection'); ?></select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="search" value="search" class="btn btn-primary"><?=__('Find Collection');?></button>
            </div>
        </form>
    </div>
</div>
