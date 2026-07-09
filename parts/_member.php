<?php
/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 2019-01-30 20:58
 * @File name           : _member.php
 * @Last modified by    : Ade Ismail Siregar (adeismailbox@gmail.com)
 * @Last modified time  : 2026-07-09T09:05:13+07:00
 */

?>

<?php if ($is_login) : ?>

    <div class="member-area apple-subpage-wrapper">
        <section id="section1" class="container-fluid">
            <header class="c-header apple-header-dark">
              <?php
              // ----------------------------------------------------------------------
              // include navbar part
              // ----------------------------------------------------------------------
              include '_navbar.php'; ?>
            </header>
        </section>

        <div class="container py-5">
          <?= themeBreadcrumbsHtml(__('Member Area')) ?>
          <div class="apple-main-content-card p-4 shadow-sm">
             <?php echo $main_content; ?>
          </div>
        </div>

    </div>

<?php else: ?>

    <div class="result-search page-member-area apple-subpage-wrapper">
        <section id="section1" class="container-fluid">
            <header class="c-header apple-header-dark">
              <?php
              // ----------------------------------------------------------------------
              // include navbar part
              // ----------------------------------------------------------------------
              include '_navbar.php'; ?>
            </header>
          <?php
          // ------------------------------------------------------------------------
          // include search form part
          // ------------------------------------------------------------------------
          include '_search-form.php'; ?>
        </section>

        <div class="container py-5">
          <?= themeBreadcrumbsHtml(__('Member Area')) ?>
          <div class="row">
              <div class="col-md-8 mx-auto">
                <div class="apple-main-content-card p-4 shadow-sm">
                  <?php echo $main_content; ?>
                </div>
              </div>
          </div>
        </div>
    </div>

<?php endif; ?>
