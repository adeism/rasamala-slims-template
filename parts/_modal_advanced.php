<?php
/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 2020-01-02 20:33
 * @File name           : _modal_advanced.php
 * @Last modified by    : Ade Ismail Siregar (adeismailbox@gmail.com)
 * @Last modified time  : 2026-07-16T13:20:41+07:00
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
                <div class="row g-2">
                    <div class="col-12 col-md-6">
                        <div class="mb-2">
                            <label for="adv-titles" class="visually-hidden"><?=__('Title'); ?></label>
                            <input type="text" name="title" class="form-control" id="adv-titles"
                                   aria-label="<?=__('Title'); ?>"
                                   placeholder="<?=__('Title'); ?>">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="mb-2">
                            <label for="adv-author" class="visually-hidden"><?=__('Author(s)');?></label>
                            <input type="text" name="author" class="form-control" id="adv-author"
                                   aria-label="<?=__('Author(s)');?>"
                                   placeholder="<?=__('Author(s)'); ?>">
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-6">
                        <div class="mb-2">
                            <label for="adv-subject" class="visually-hidden"><?=__('Subject(s)');?></label>
                            <input type="text" name="subject" class="form-control" id="adv-subject"
                                   aria-label="<?=__('Subject(s)');?>"
                                   placeholder="<?=__('Subject(s)'); ?>">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="mb-2">
                            <label for="adv-isbn" class="visually-hidden"><?=__('ISBN/ISSN');?></label>
                            <input type="text" name="isbn" class="form-control" id="adv-isbn"
                                   aria-label="<?=__('ISBN/ISSN');?>"
                                   placeholder="<?=__('ISBN/ISSN'); ?>">
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-6">
                        <div class="mb-2">
                            <label for="adv-publishyear" class="visually-hidden"><?=__('Publish Year');?></label>
                            <input type="text" name="publishyear" class="form-control" id="adv-publishyear"
                                   aria-label="<?=__('Publish Year');?>"
                                   placeholder="<?=__('Publish Year'); ?>">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="mb-2">
                            <label for="adv-location" class="visually-hidden"><?=__('Location');?></label>
                            <select id="adv-location" name="location"
                                    class="form-select" aria-label="<?=__('Location');?>"> <?= commonList('location'); ?></select>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-6">
                        <div class="mb-2 mb-md-0">
                            <label for="adv-gmd" class="visually-hidden"><?=__('GMD');?></label>
                            <select id="adv-gmd" name="gmd" class="form-select" aria-label="<?=__('GMD');?>"><?= commonList('gmd'); ?></select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="mb-0">
                            <label for="adv-coll-type" class="visually-hidden"><?=__('Collection Type');?></label>
                            <select name="colltype" class="form-select"
                                    id="adv-coll-type" aria-label="<?=__('Collection Type');?>"><?= commonList('collection'); ?></select>
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
