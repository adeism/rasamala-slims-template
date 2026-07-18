<?php
# @Author: Waris Agung Widodo <user>
# @Date:   2018-01-23T11:26:05+07:00
# @Email:  ido.alit@gmail.com
# @Filename: footer.php
# @Last modified by:   Ade Ismail Siregar (adeismailbox@gmail.com)
# @Last modified time: 2026-07-16T13:41:41+07:00
?>


<?php
$is_homepage = !isset($_GET['p']) && !isset($_GET['search']);
$show_footer = themeFooterEnabled($sysconf, $is_homepage);
if ($show_footer): ?>
<footer class="py-5 border-top">
    <div class="container">
        <?php
        $footer_search_show = ($sysconf['template']['classic_footer_search_show'] ?? 0) == 1;
        $rasamala_waktu_sholat_footer_html = '';
        $rasamala_waktu_sholat_reminder_html = '';
        include_once __DIR__ . '/waktu_sholat.php';
        $col_logo = 'col-md-3';
        $col_about = 'col-md-5';
        $col_search = 'col-md-4';
        ?>
        <div class="row py-4">
            <div class="<?= $col_logo ?>">
              <?php
              if(isset($sysconf['logo_image']) && $sysconf['logo_image'] != '' && $imagesDisk->isExists($path = 'default/'.$sysconf['logo_image'])){
                // K-02: escape src and add alt attribute
                echo '<img class="footer-brand-img" src="'.themeEscape(SWB . 'lib/minigalnano/createthumb.php?filename=images/' . $path.'&width=350').'" alt="" aria-hidden="true">';
              }
              elseif (file_exists(__DIR__ . '/../assets/images/logo.png')) {
                // S-04: add alt attribute
                echo '<img class="footer-brand-img" src="' . assets(v('images/logo.png')) . '" alt="" aria-hidden="true">';
              } else {
                ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-book mb-2 footer-book-icon" viewBox="0 0 16 16" aria-hidden="true" focusable="false">
                    <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.933-.575-2.202-.954-3.41-1.11-1.226-.157-2.484-.013-3.388.337zm11-.14c.654-.689 1.782-.886 3.11-.752 1.234.124 2.503.523 3.388.893v9.923c-.904-.35-2.162-.494-3.388-.337-1.208.156-2.477.535-3.409 1.11V2.688zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783"/>
                </svg>
              <?php } ?>
                <div class="mb-3 fw-bold footer-section-title footer-library-name"><?php echo themeEscape($sysconf['library_name']); ?></div>
                <ul class="list-unstyled">
                    <li class="mb-2"><a class="footer-link" href="index.php?p=libinfo"><?= __('Information'); ?></a></li>
                    <li class="mb-2"><a class="footer-link" href="index.php?p=services"><?= __('Services'); ?></a></li>
                    <li class="mb-2"><a class="footer-link" href="index.php?p=librarian"><?= __('Librarian'); ?></a></li>
                    <li class="mb-2"><a class="footer-link" href="index.php?p=member"><?= __('Member Area'); ?></a></li>
                </ul>
            </div>
            <div class="<?= $col_about ?> pt-4 pt-md-0">
                <h2 class="mb-3 fw-bold text-uppercase tracking-wider footer-section-title"><?= __('About Us'); ?></h2>
                <div class="footer-about-text">
                    <?= themeSanitizeHtml($sysconf['template']['classic_footer_about_us'] ?? ''); ?>
                </div>
            </div>
            <div class="<?= $col_search ?> pt-4 pt-md-0">
                <?php if ($footer_search_show) : ?>
                    <form action="index.php" class="footer-search-form">
                        <input type="hidden" ref="csrf_token" value="<?= themeEscape($_SESSION['csrf_token']??'') ?>">
                        <input type="hidden" name="csrf_token" value="<?= themeEscape($_SESSION['csrf_token']??'') ?>">
                        <div class="input-group mb-3">
                            <input name="keywords" type="text" class="form-control footer-search-input"
                                   placeholder="<?= __('start it by typing one or more keywords for title, author or subject'); ?>"
                                   aria-label="<?= themeEscape(__('start it by typing one or more keywords for title, author or subject')); ?>"
                                   aria-describedby="button-addon2">
                            <button class="btn btn-outline-secondary footer-search-btn" type="submit" value="search" name="search" id="button-addon2"><?= __('Find'); ?>
                                </button>
                        </div>
                    </form>
                <?php endif; ?>
                <?= $rasamala_waktu_sholat_footer_html; ?>
                <hr class="rasamala-divider">
                <a target="_blank" rel="noopener noreferrer" title="Support Us" class="btn btn-outline-secondary btn-sm me-2 mb-2 px-3 footer-action-btn"
                   href="https://slims.web.id/web/pages/support-us/"><i
                            class="fas fa-heart me-2 text-danger" aria-hidden="true"></i><?= __('Keep SLiMS Alive'); ?></a>
                <a target="_blank" rel="noopener noreferrer" title="Contribute" class="btn btn-outline-secondary btn-sm mb-2 px-3 footer-action-btn"
                   href="https://github.com/slims/"><i
                            class="fab fa-github me-2" aria-hidden="true"></i><?= __('Contribute'); ?></a>
            </div>
        </div>
        <hr class="rasamala-divider my-4">
        <div class="footer-bottom d-flex flex-wrap small justify-content-between align-items-center">
            <p class="footer-copyright m-0">&copy; <?php echo date('Y'); ?> &mdash; <?= themeEscape($sysconf['template']['classic_footer_copyright'] ?? 'Senayan Developer Community'); ?></p>
            <div class="footer-powered text-end"><?= __('Powered by '); ?><a class="footer-powered-link" target="_blank" rel="noopener noreferrer" href="https://slims.web.id/"><code>SLiMS</code></a></div>
        </div>
	    </div>
	</footer>
    <?= $rasamala_waktu_sholat_reminder_html; ?>
	<?php endif; ?>

<?php include __DIR__ . '/chat_widget.php'; ?>

<!-- // Load modal -->
<?php include "_modal_topic.php"; ?>
<?php include "_modal_advanced.php"; ?>
<?php include "_modal_social_media.php"; ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.modal[aria-hidden="true"]').forEach(function (modal) {
    modal.setAttribute('inert', '');
  });

  document.addEventListener('show.bs.modal', function (event) {
    event.target.removeAttribute('inert');
  });

  document.addEventListener('hidden.bs.modal', function (event) {
    event.target.setAttribute('inert', '');
  });
});
</script>

<!-- // Load highlight -->
<script src="<?= themeEscape(JWB); ?>highlight.js"></script>
<?php if(isset($engine) && $searchableInJsArray = $this->generateKeywords($engine->searchable_fields)) : ?>
<script>
  // T-03: re-encode to ensure safe JS output with HEX_TAG
  $('.card-body > *').highlight(<?= json_encode(json_decode($searchableInJsArray), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>);
</script>
<?php endif; ?>

<!-- // load our vue app.js -->
<script src="<?php echo assets(v('js/app.js')); ?>"></script>
<script src="<?php echo assets(v('js/color_mode.js')); ?>"></script>
<script src="<?php echo assets(v('js/hero_animation.js')); ?>"></script>
<script src="<?php echo assets(v('js/theme_viewer.js')); ?>"></script>
<script src="<?php echo assets(v('js/app_jquery.js')); ?>"></script>
<script src="<?php echo assetsVersioned('js/cursor-icons.js'); ?>"></script>
<script src="<?php echo assetsVersioned('js/cursor-particles.js'); ?>"></script>

<?php include __DIR__ . '/mobile_bottom_nav.php'; ?>
<?php include __DIR__ . '/bottom_info_bar.php'; ?>
<?php include __DIR__ . '/floating_actions.php'; ?>
<?php include __DIR__ . '/palette_switcher.php'; ?>


</body>
</html>
