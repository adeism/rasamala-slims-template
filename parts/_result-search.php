<?php
# @Author: Waris Agung Widodo <user>
# @Date:   2018-01-23T11:32:46+07:00
# @Email:  ido.alit@gmail.com
# @Filename: _result-search.php
# @Last modified by:   Ade Ismail Siregar (adeismailbox@gmail.com)
# @Last modified time: 2026-07-24T13:50:00+07:00

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
            <div class="col-12">
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

                // Clean up underscores and dashes from sort options
                $cleaned_sort_select = preg_replace_callback('/(<option[^>]*>)(.*?)(<\/option>)/i', function($matches) {
                    $label = str_replace(array('_', '-'), ' ', $matches[2]);
                    return $matches[1] . ucwords($label) . $matches[3];
                }, $sort_select ?? '');

                $raw_keywords = trim((string)($keywords ?? ''));
                $keywords_text = (strlen($raw_keywords) > 40) ? substr($raw_keywords, 0, 40) . '...' : $raw_keywords;
                $num_rows_val = themeSafeInt($engine->getNumRows());
                $has_active_keyword = (!empty($keywords_text) && $keywords_text !== '*');
                ?>

                <!-- Unified Sticky Search Info & Action Toolbar (Always Sticky on Scroll) -->
                <div class="rasamala-sticky-action-wrapper mb-4">
                    <div class="card border-0 shadow-sm p-3 rounded-3 rasamala-search-action-bar rasamala-sticky-toolbar">
                        <div class="row g-3 align-items-center">
                            <!-- Left: Found Count & Optional Keyword Badge -->
                            <div class="col-12 col-md-6 col-lg-7">
                                <div class="search-found-info text-dark fw-bold fs-6 d-flex align-items-center flex-wrap gap-1">
                                    <span><?= __('Found') ?></span>
                                    <span class="badge bg-primary rounded-pill px-2.5 py-1 fs-6 mx-1 shadow-xs"><?= number_format($num_rows_val, 0, ',', '.') ?></span>
                                    <?php if ($has_active_keyword) : ?>
                                        <span><?= __('for') ?>:</span>
                                        <span class="badge bg-light text-dark border px-2.5 py-1 rounded-pill ms-1 font-monospace fw-semibold search-keyword-badge shadow-xs">
                                            <i class="fas fa-quote-left me-1 text-primary text-xs" aria-hidden="true"></i><?= themeEscape($keywords_text) ?><i class="fas fa-quote-right ms-1 text-primary text-xs" aria-hidden="true"></i>
                                        </span>
                                    <?php else : ?>
                                        <span><?= __('titles') ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Right: Action Controls (Filter, Sort, View Mode) -->
                            <div class="col-12 col-md-6 col-lg-5">
                                <div class="row g-2 align-items-center justify-content-end">
                                    <!-- Filter Button -->
                                    <div class="col-4">
                                        <button type="button" class="btn btn-light btn-modern-filter w-100 shadow-sm border d-flex align-items-center justify-content-center py-2 px-1 text-truncate" data-bs-toggle="modal" data-bs-target="#mobileFilterModal" id="btn-open-filter-modal" aria-label="<?= themeEscape(__('Open filter options')) ?>">
                                            <i class="fas fa-filter me-1 text-primary text-xs" aria-hidden="true"></i>
                                            <span class="fw-bold fs-6 text-truncate"><?= __('Filter') ?></span>
                                            <span class="badge bg-primary rounded-pill ms-1 d-none" id="active-filter-count">0</span>
                                        </button>
                                    </div>

                                    <!-- Sort Button -->
                                    <div class="col-4">
                                        <button type="button" class="btn btn-light btn-modern-filter w-100 shadow-sm border d-flex align-items-center justify-content-center py-2 px-1 text-truncate" data-bs-toggle="modal" data-bs-target="#mobileSortModal" id="btn-open-sort-modal" aria-label="<?= themeEscape(__('Open sort options')) ?>">
                                            <i class="fas fa-sort me-1 text-primary text-xs" aria-hidden="true"></i>
                                            <span id="current-sort-label" class="fw-bold fs-6 text-truncate"><?= __('Sort by') ?></span>
                                        </button>
                                    </div>

                                    <!-- View Mode Button -->
                                    <div class="col-4">
                                        <button type="button" class="btn btn-light btn-modern-filter w-100 shadow-sm border d-flex align-items-center justify-content-center py-2 px-1 text-truncate" data-bs-toggle="modal" data-bs-target="#mobileViewModal" id="btn-open-view-modal" aria-label="<?= themeEscape(__('Change result view')) ?>">
                                            <i class="<?= themeEscape($view_options[$current_view]['icon']) ?> me-1 text-primary text-xs" aria-hidden="true"></i>
                                            <span class="fw-bold fs-6 text-truncate"><?= themeEscape($view_options[$current_view]['label']) ?></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Hidden SLiMS Sort Select for JS binding -->
                        <select class="d-none" id="search-order"><?= $cleaned_sort_select ?></select>
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

<!-- Unified Filter Pop-up Modal (Slideout Drawer) -->
<div class="modal fade" id="mobileFilterModal" tabindex="-1" role="dialog" aria-labelledby="mobileFilterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout" role="document">
        <div class="modal-content border-0 h-100 shadow-lg">
            <div class="modal-header border-bottom py-3 px-4">
                <div>
                    <h5 class="modal-title fw-bold" id="mobileFilterModalLabel"><i class="fas fa-filter me-2 text-primary" aria-hidden="true"></i><?= __('Filter by') ?></h5>
                    <small class="text-muted d-block text-sm mt-1"><?= __('Refine search results by criteria') ?></small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body overflow-auto p-3 mobile-filter-modal-body">
                <div id="mobile-filter-container">
                    <?= rasamalaSearchFilterHtml($engine->getFilter($opac, true)) ?>
                </div>
            </div>
            <div class="modal-footer border-top p-3 bg-light">
                <div class="row w-100 g-2">
                    <div class="col-6">
                        <button type="button" class="btn btn-outline-secondary w-100 py-2.5 fw-bold rounded-pill btn-modal-action" id="reset-mobile-filter">
                            <i class="fas fa-undo me-1" aria-hidden="true"></i><?= __('Reset') ?>
                        </button>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-primary w-100 py-2.5 fw-bold rounded-pill shadow-sm btn-modal-action" id="apply-mobile-filter">
                            <i class="fas fa-check me-1" aria-hidden="true"></i><?= __('Apply Filter') ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Unified Sort Pop-up Modal -->
<div class="modal fade" id="mobileSortModal" tabindex="-1" role="dialog" aria-labelledby="mobileSortModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 rounded-3 shadow-lg">
            <div class="modal-header border-bottom py-3 px-4">
                <div>
                    <h5 class="modal-title fw-bold" id="mobileSortModalLabel"><i class="fas fa-sort me-2 text-primary" aria-hidden="true"></i><?= __('Sort by') ?></h5>
                    <small class="text-muted d-block text-sm mt-1"><?= __('Choose sorting order for search results') ?></small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="list-group list-group-flush search-sort-modal-options" id="mobile-sort-options"></div>
            </div>
        </div>
    </div>
</div>

<!-- Unified View Mode Pop-up Modal (Simple, List, Grid) -->
<div class="modal fade" id="mobileViewModal" tabindex="-1" role="dialog" aria-labelledby="mobileViewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 rounded-3 shadow-lg">
            <div class="modal-header border-bottom py-3 px-4">
                <div>
                    <h5 class="modal-title fw-bold" id="mobileViewModalLabel"><i class="fas fa-th-large me-2 text-primary" aria-hidden="true"></i><?= __('View Mode') ?></h5>
                    <small class="text-muted d-block text-sm mt-1"><?= __('Choose display layout style') ?></small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <form method="POST" action="<?= themeEscape($view_action) ?>" class="m-0" id="search-view-mode-form">
                    <input type="hidden" name="csrf_token" value="<?= themeEscape($view_csrf) ?>"/>
                    <input type="hidden" name="view" id="search-view-input-value" value=""/>
                    <div class="list-group list-group-flush search-view-modal-options">
                        <?php 
                        $view_descriptions = [
                            'simple' => __('Compact list view without cover thumbnails'),
                            'list' => __('Detailed list view with book cover thumbnails'),
                            'grid' => __('Modern card grid view layout'),
                        ];
                        foreach ($view_options as $view_key => $view_option) : 
                            $is_active = ($current_view === $view_key);
                            $view_desc = $view_descriptions[$view_key] ?? '';
                            $url_params = array_merge($_GET, ['view' => $view_key, 'csrf_token' => $view_csrf]);
                            $direct_url = $_SERVER['PHP_SELF'] . '?' . http_build_query($url_params);
                        ?>
                        <a href="<?= themeEscape($direct_url) ?>" data-view-value="<?= themeEscape($view_key) ?>" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between p-3 border-bottom search-view-option-item <?= $is_active ? 'active bg-light text-dark' : '' ?>" role="button">
                            <div class="d-flex align-items-center">
                                <div class="view-option-icon-box rounded-circle me-3 d-flex align-items-center justify-content-center <?= $is_active ? 'bg-primary text-white' : 'bg-light text-primary' ?>" style="width: 42px; height: 42px; min-width: 42px;">
                                    <i class="<?= themeEscape($view_option['icon']) ?> fs-5" aria-hidden="true"></i>
                                </div>
                                <div class="text-start">
                                    <div class="fw-bold fs-6 <?= $is_active ? 'text-primary' : 'text-dark' ?>"><?= themeEscape($view_option['label']) ?></div>
                                    <?php if ($view_desc) : ?>
                                    <small class="text-muted d-block mt-1"><?= themeEscape($view_desc) ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php if ($is_active) : ?>
                            <i class="fas fa-check-circle text-primary fs-5 ms-2" aria-hidden="true"></i>
                            <?php endif; ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?= themeEscape(assetsVersioned('js/result_search.js')); ?>"></script>
