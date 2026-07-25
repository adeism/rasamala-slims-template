<?php
/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 2019-01-29 10:43
 * @File name           : _other.php
 * @Last modified by    : Ade Ismail Siregar (adeismailbox@gmail.com)
 * @Last modified time  : 2026-07-20T15:49:02+07:00
 */

?>

<div class="result-search pb-5 rasamala-subpage-wrapper <?= ($_GET['p'] ?? '') === 'login' ? 'page-member-area' : '' ?>">
    <section id="section1" class="container-fluid">
        <header class="c-header rasamala-header-dark">
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
      $display_page_title = trim(preg_replace('/\s+/', ' ', str_replace('_', ' ', (string)($page_title ?? ''))));
      if ($display_page_title === '') {
        $display_page_title = (string)($page_title ?? '');
      }

      $breadcrumb_label = $display_page_title;
      $breadcrumb_parents = [];
      $current_p = (string)($_GET['p'] ?? '');

      if ($current_p === 'show_detail') {
        $breadcrumb_label = !empty($display_page_title) ? $display_page_title : __('Detail');
      } elseif ($current_p === 'login') {
        $breadcrumb_label = __('Staff Area');
      } elseif ($current_p === 'news') {
        $breadcrumb_label = __('Library News');
      } elseif (strpos($current_p, 'news') === 0 || strpos($current_p, 'news/') === 0 || (isset($_GET['p']) && strpos($_GET['p'], 'news') !== false)) {
        $breadcrumb_parents[] = [
          'label' => __('Library News'),
          'url' => 'index.php?p=news'
        ];
      }

      echo themeBreadcrumbsHtml($breadcrumb_label, $breadcrumb_parents);

      if ($_GET['p'] !== 'show_detail') {
        if ($_GET['p'] === 'login') {
          echo '<div class="row"><div class="col-md-8 mx-auto">';
          echo '<div class="rasamala-main-content-card p-4 shadow-sm">';
          echo '<div class="tagline">' . themeEscape(__('Librarian Login')) . '</div>';
          echo '<div class="loginInfo">' . __('Please insert your username and password given by library system administrator.') . '</div>';
          echo $main_content;
          echo '</div>';
          echo '</div></div>';
        } else {
          $title_divider = ($_GET['p'] === 'news') ? '' : '<hr class="rasamala-divider mb-4">';
          echo '<h2 class="mb-4 fw-bold detail-title">' . themeEscape($display_page_title) . '</h2>' . $title_divider;
          if ($_GET['p'] === 'librarian') {
            $librarian_content = function_exists('themeRenderLibrarianPage') ? themeRenderLibrarianPage($dbs, $sysconf) : $main_content;
            echo '<div class="d-flex flex-row flex-wrap rasamala-librarian-list">' . $librarian_content . '</div>';
          } elseif ($_GET['p'] === 'news') {
            echo '<div class="d-flex flex-column">' . $main_content . '</div>';
          } else {
            $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
            $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
            $request_uri = $_SERVER['REQUEST_URI'] ?? '';
            $current_page_url = $scheme . $host . $request_uri;
            $current_qr_svg = function_exists('themeGenerateUrlQrSvg') ? themeGenerateUrlQrSvg($current_page_url, 180) : '';

            $content_actions = '
            <div class="content-detail-action-bar d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4 pb-3 border-bottom">
                <div class="d-inline-flex align-items-center gap-2">
                    <button type="button" class="btn btn-content-share" data-url="' . themeEscape($current_page_url) . '" data-title="' . themeEscape($display_page_title) . '" title="' . themeEscape(__('Share')) . '">
                        <i class="fas fa-share-alt" aria-hidden="true"></i> <span>' . themeEscape(__('Share')) . '</span>
                    </button>
                    <button type="button" class="btn btn-content-qr" data-url="' . themeEscape($current_page_url) . '" data-title="' . themeEscape($display_page_title) . '" data-qr-svg="' . themeEscape($current_qr_svg) . '" title="Scan for Link">
                        <i class="fas fa-qrcode" aria-hidden="true"></i> <span>Scan for Link</span>
                    </button>
                </div>
            </div>';

            echo '<div class="rasamala-main-content-card p-4 shadow-sm">' . $content_actions . $main_content . '</div>';
          }
        }
      } else {
        echo $main_content;
      }
      ?>
    </section>
</div>
