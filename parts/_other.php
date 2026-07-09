<?php
/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 2019-01-29 10:43
 * @File name           : _other.php
 * @Last modified by    : Ade Ismail Siregar (adeismailbox@gmail.com)
 * @Last modified time  : 2026-07-09T08:17:12+07:00
 */

?>

<div class="result-search pb-5 apple-subpage-wrapper">
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

    <section class="container mt-5">
      <?php
      echo themeBreadcrumbsHtml(($_GET['p'] ?? '') === 'show_detail' ? __('Detail') : ($page_title ?? ''));
      if ($_GET['p'] !== 'show_detail') {
        echo '<h2 class="mb-4 font-weight-bold detail-title">' . themeEscape($page_title) . '</h2><hr class="apple-divider mb-4">';
        if ($_GET['p'] === 'librarian') {
          echo '<div class="d-flex flex-row flex-wrap">' . $main_content . '</div>';
        } elseif ($_GET['p'] === 'news') {
          echo '<div class="d-flex flex-column">' . $main_content . '</div>';
        } else {
          echo '<div class="apple-main-content-card p-4 shadow-sm">' . $main_content . '</div>';
        }
      } else {
        echo $main_content;
      }
      ?>
    </section>
</div>
