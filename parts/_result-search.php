<?php
# @Author: Waris Agung Widodo <user>
# @Date:   2018-01-23T11:32:46+07:00
# @Email:  ido.alit@gmail.com
# @Filename: _result-search.php
# @Last modified by:   Ade Ismail Siregar (adeismailbox@gmail.com)
# @Last modified time: 2026-07-20T10:51:24+07:00

if (!function_exists('rasamalaSearchFilterHtml')) {
    function rasamalaSearchFilterHtml($html)
    {
        $html = (string)$html;
        $html = preg_replace('/class="list-group\s+list-group-flush"/i', 'class="rasamala-filter-list"', $html);
        $html = preg_replace('/class="([^"]*)\blist-group-item\b([^"]*)"/i', 'class="$1rasamala-filter-facet$2"', $html);
        $html = preg_replace('/\s*\bborder-top-0\b/i', '', $html);
        $html = preg_replace('/\s*\bborder-left\b|\s*\bborder-right\b/i', '', $html);

        return $html;
    }
}
?>

<div class="result-search rasamala-subpage-wrapper">
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
        <?= themeBreadcrumbsHtml(__('Search')) ?>
        <div class="row">
            <!-- Filter Sidebar (Desktop Only) -->
            <div class="col-md-3 d-none d-md-block">
                <div class="card filter-panel-card border-0 shadow-sm p-3 rounded">
                    <h5 class="filter-panel-title fw-bold mb-3 border-bottom pb-2"><i class="fas fa-filter me-2" aria-hidden="true"></i><?= __('Filter by') ?></h5>
                    <div id="desktop-filter-container">
                        <?= rasamalaSearchFilterHtml($engine->getFilter($opac, true)) ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-9">
                <?php
                $view_csrf = $opac->getCsrf();
                $view_options = [
                    'simple' => [
                        'label' => __('Simple'),
                        'title' => __('Simple View'),
                        'icon' => 'fas fa-align-left',
                    ],
                    'list' => [
                        'label' => __('List'),
                        'title' => __('List View'),
                        'icon' => 'fas fa-list',
                    ],
                    'grid' => [
                        'label' => __('Grid'),
                        'title' => __('Grid View'),
                        'icon' => 'fas fa-th-large',
                    ],
                ];
                $default_layout = $sysconf['template']['classic_search_result_layout'] ?? 'simple';
                $default_layout = is_scalar($default_layout) ? (string)$default_layout : 'simple';
                if (!isset($view_options[$default_layout])) {
                    $default_layout = 'simple';
                }
                $current_view = $_SESSION['LIST_VIEW'] ?? $default_layout;
                $current_view = is_scalar($current_view) ? (string)$current_view : $default_layout;
                if (!isset($view_options[$current_view])) {
                    $current_view = $default_layout;
                }
                $view_action = $_SERVER['PHP_SELF'] . '?' . http_build_query(array_merge(
                    ['csrf_token' => $view_csrf],
                    array_filter($_GET, fn($key) => $key !== 'csrf_token', ARRAY_FILTER_USE_KEY)
                ));
                ?>
                <!-- Mobile Filter & Sort Toggle Bar (Mobile Only) -->
                <div class="d-md-none mb-3">
                    <div class="row g-0">
                        <div class="col-4 pe-1">
                            <button type="button" class="btn btn-light btn-modern-filter w-100 shadow-sm border d-flex align-items-center justify-content-center py-2" data-bs-toggle="modal" data-bs-target="#mobileFilterModal" aria-label="<?= themeEscape(__('Open filter options')) ?>">
                                <i class="fas fa-filter me-1 text-primary" aria-hidden="true"></i> <?= __('Filter') ?>
                            </button>
                        </div>
                        <div class="col-4 px-1">
                            <button type="button" class="btn btn-light btn-modern-filter w-100 shadow-sm border d-flex align-items-center justify-content-center py-2" data-bs-toggle="modal" data-bs-target="#mobileSortModal" aria-label="<?= themeEscape(__('Open sort options')) ?>">
                                <i class="fas fa-sort me-1 text-primary" aria-hidden="true"></i> <?= __('Sort') ?>
                            </button>
                        </div>
                        <div class="col-4 ps-1">
                            <div class="dropdown w-100">
                                <button type="button" class="btn btn-light btn-modern-filter w-100 shadow-sm border d-flex align-items-center justify-content-center py-2 dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label="<?= themeEscape(__('Change result view')) ?>">
                                    <i class="<?= themeEscape($view_options[$current_view]['icon']) ?> me-1 text-primary" aria-hidden="true"></i> <?= themeEscape($view_options[$current_view]['label']) ?>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end shadow-sm border search-view-menu">
                                    <form method="POST" action="<?= themeEscape($view_action) ?>" class="m-0">
                                        <input type="hidden" name="csrf_token" value="<?= themeEscape($view_csrf) ?>"/>
                                        <?php foreach ($view_options as $view_key => $view_option) : ?>
                                        <button type="submit" name="view" value="<?= themeEscape($view_key) ?>" class="dropdown-item d-flex align-items-center py-2 <?= $current_view === $view_key ? 'active' : '' ?>">
                                            <i class="<?= themeEscape($view_option['icon']) ?> me-2" aria-hidden="true"></i>
                                            <span><?= themeEscape($view_option['label']) ?></span>
                                        </button>
                                        <?php endforeach; ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Search Info Row -->
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-3 mt-1 pb-2 border-bottom search-result-toolbar">
                    <div class="text-sm">
                        <?php
                        $keywords_text = (strlen($keywords) > 30) ? substr($keywords, 0, 30) . '...' : $keywords;
                        $keywords_info = '<span class="search-keyword-info fw-bold" title="' . themeEscape($keywords) . '">' . themeEscape($keywords_text) . '</span>';
                        $search_result_info = '<div class="search-found-info">';
                        $search_result_info .= __('Found <strong>{biblio_list->num_rows}</strong> from your keywords') . ': <strong class="search-found-info-keywords">' . $keywords_info . '</strong>';
                        $search_result_info .= '</div>';
                        echo str_replace('{biblio_list->num_rows}', themeSafeInt($engine->getNumRows()), $search_result_info);
                        ?>
                    </div>
                </div>

                <!-- Desktop Sort & View Row (Desktop Only) -->
                <div class="d-none d-md-flex align-items-center justify-content-between mb-4 bg-light p-2 rounded shadow-sm desktop-sort-bar">
                    <div class="d-flex align-items-center flex-wrap">
                        <span class="fw-bold me-3 text-xs text-uppercase tracking-wider desktop-sort-title"><i class="fas fa-sort me-1 text-primary"></i> <?= __('Sort by') ?>:</span>
                        <?php
                        // Clean up underscores and dashes from option text in PHP
                        $cleaned_sort_select = preg_replace_callback('/(<option[^>]*>)(.*?)(<\/option>)/i', function($matches) {
                            $label = str_replace(array('_', '-'), ' ', $matches[2]);
                            return $matches[1] . ucwords($label) . $matches[3];
                        }, $sort_select);
                        ?>
                        <select class="d-none" id="search-order"><?= $cleaned_sort_select ?></select>
                        <div id="desktop-sort-chips" class="d-flex align-items-center flex-wrap desktop-sort-chips"></div>
                    </div>
                    
                    <!-- View Switcher Dropdown (Desktop) -->
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light border px-3 py-2 d-flex align-items-center dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="<?= themeEscape($view_options[$current_view]['icon']) ?> me-2 text-primary"></i>
                            <span><?= themeEscape($view_options[$current_view]['label']) ?></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end shadow-sm border search-view-menu">
                            <form method="POST" action="<?= themeEscape($view_action) ?>" class="m-0">
                                <input type="hidden" name="csrf_token" value="<?= themeEscape($view_csrf) ?>"/>
                                <?php foreach ($view_options as $view_key => $view_option) : ?>
                                <button type="submit" name="view" value="<?= themeEscape($view_key) ?>" class="dropdown-item d-flex align-items-center py-2 <?= $current_view === $view_key ? 'active fw-bold' : '' ?>">
                                    <i class="<?= themeEscape($view_option['icon']) ?> me-2" aria-hidden="true"></i>
                                    <span><?= themeEscape($view_option['label']) ?></span>
                                </button>
                                <?php endforeach; ?>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="wrapper">
                    <?php
                    if (ENVIRONMENT == 'development' && !empty($engine->getError())) echo '<div class="alert alert-danger mt-2 text-center">' . themeEscape($engine->getError()) . '</div>';
                    // catch empty list
                    if (trim(strip_tags($main_content)) === '') {
                        echo '<div class="d-flex justify-content-center border-top pt-4">
                                <img src="'.assets('images/empty.svg').'" alt="'.themeEscape(__('No result illustration')).'" />
                              </div>
                              <div class="text-center text-danger"><strong>'.__('No Result').'.</strong> '.__('Please try again').'</div>';
                    } else {
                        echo $main_content;
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Mobile Filter Modal (Tokopedia/Shopee style slideout) -->
<div class="modal fade" id="mobileFilterModal" tabindex="-1" role="dialog" aria-labelledby="mobileFilterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout" role="document">
        <div class="modal-content border-0 h-100">
            <div class="modal-header border-bottom py-3">
                <h5 class="modal-title fw-bold" id="mobileFilterModalLabel"><i class="fas fa-filter me-2 text-primary" aria-hidden="true"></i><?= __('Filter') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body overflow-auto p-3 mobile-filter-modal-body">
                <!-- Mobile filter form container -->
                <div id="mobile-filter-container"></div>
            </div>
            <div class="modal-footer border-top p-2 bg-light">
                <div class="row w-100 g-0">
                    <div class="col-6 pe-2">
                        <button type="button" class="btn btn-outline-secondary w-100 py-2 fw-bold btn-modal-action" id="reset-mobile-filter"><?= __('Reset') ?></button>
                    </div>
                    <div class="col-6 ps-2">
                        <button type="button" class="btn btn-primary w-100 py-2 fw-bold btn-modal-action" id="apply-mobile-filter"><?= __('Apply Filter') ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Sort Modal (Tokopedia/Shopee style sheet modal) -->
<div class="modal fade" id="mobileSortModal" tabindex="-1" role="dialog" aria-labelledby="mobileSortModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 rounded-3">
            <div class="modal-header border-bottom py-3">
                <h5 class="modal-title fw-bold" id="mobileSortModalLabel"><i class="fas fa-sort me-2 text-primary" aria-hidden="true"></i><?= __('Sort by') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="list-group list-group-flush" id="mobile-sort-options"></div>
            </div>
        </div>
    </div>
</div>

<script src="<?= themeEscape(assetsVersioned('js/result_search.js')); ?>"></script>
