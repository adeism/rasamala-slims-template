<?php
# @Author: Waris Agung Widodo <user>
# @Date:   2018-01-23T11:32:46+07:00
# @Email:  ido.alit@gmail.com
# @Filename: _result-search.php
# @Last modified by:   Ade Ismail Siregar (adeismailbox@gmail.com)
# @Last modified time: 2026-07-15T09:44:10+07:00

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
                        <?= $engine->getFilter($opac, true) ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-9">
                <?php
                $view_csrf = $opac->getCsrf();
                $default_layout = $sysconf['template']['classic_search_result_layout'] ?? 'simple';
                $current_view = $_SESSION['LIST_VIEW'] ?? $default_layout;
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
                $view_action = $_SERVER['PHP_SELF'] . '?' . http_build_query(array_merge(
                    ['csrf_token' => $view_csrf],
                    array_filter($_GET, fn($key) => $key !== 'csrf_token', ARRAY_FILTER_USE_KEY)
                ));
                ?>
                <!-- Mobile Filter & Sort Toggle Bar (Mobile Only) -->
                <div class="d-md-none mb-3">
                    <div class="row g-0">
                        <div class="col-4 pe-1">
                            <button type="button" class="btn btn-light btn-modern-filter w-100 shadow-sm border d-flex align-items-center justify-content-center py-2" data-bs-toggle="modal" data-bs-target="#mobileFilterModal">
                                <i class="fas fa-filter me-1 text-primary"></i> <?= __('Filter') ?>
                            </button>
                        </div>
                        <div class="col-4 px-1">
                            <button type="button" class="btn btn-light btn-modern-filter w-100 shadow-sm border d-flex align-items-center justify-content-center py-2" data-bs-toggle="modal" data-bs-target="#mobileSortModal">
                                <i class="fas fa-sort me-1 text-primary"></i> <?= __('Sort') ?>
                            </button>
                        </div>
                        <div class="col-4 ps-1">
                            <div class="dropdown w-100">
                                <button type="button" class="btn btn-light btn-modern-filter w-100 shadow-sm border d-flex align-items-center justify-content-center py-2 dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="<?= themeEscape($view_options[$current_view]['icon']) ?> me-1 text-primary"></i> <?= themeEscape($view_options[$current_view]['label']) ?>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end shadow-sm border" style="min-width: 140px;">
                                    <form method="POST" action="<?= themeEscape($view_action) ?>" class="m-0">
                                        <input type="hidden" name="csrf_token" value="<?= themeEscape($view_csrf) ?>"/>
                                        <?php foreach ($view_options as $view_key => $view_option) : ?>
                                        <button type="submit" name="view" value="<?= themeEscape($view_key) ?>" class="dropdown-item d-flex align-items-center py-2 <?= $current_view === $view_key ? 'active' : '' ?>">
                                            <i class="<?= themeEscape($view_option['icon']) ?> me-2"></i>
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
                        <div class="dropdown-menu dropdown-menu-end shadow-sm border" style="min-width: 140px;">
                            <form method="POST" action="<?= themeEscape($view_action) ?>" class="m-0">
                                <input type="hidden" name="csrf_token" value="<?= themeEscape($view_csrf) ?>"/>
                                <?php foreach ($view_options as $view_key => $view_option) : ?>
                                <button type="submit" name="view" value="<?= themeEscape($view_key) ?>" class="dropdown-item d-flex align-items-center py-2 <?= $current_view === $view_key ? 'active fw-bold' : '' ?>">
                                    <i class="<?= themeEscape($view_option['icon']) ?> me-2"></i>
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
                                <img src="'.assets('images/empty.svg').'" />
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
<?php if(($_SESSION['LIST_VIEW'] ?? 'simple') === 'grid'): ?>
    <script>
        $(document).ready(function () {
            var $grid = $('.biblioResult').addClass('row').masonry({
                itemSelector: '.grid-item',
                columnWidth: '.grid-item',
                percentPosition: true
            });

            var images = $(".grid-item img");
            if (images.length > 0) {
                images.each(function (idx, img) {
                    var tempImg = new Image();
                    tempImg.onload = tempImg.onerror = function() {
                        $grid.masonry('layout');
                    };
                    tempImg.src = $(img).attr("src");
                });
            }

            $('.dropdown-toggle').dropdown();
        });
    </script>
<?php endif; ?>

<?php if(($_SESSION['LIST_VIEW'] ?? 'simple') === 'simple'): ?>
    <script>
    (function () {
        var activePopover = null;
        var activePinned = false;

        function closeActive() {
            if (activePopover) {
                activePopover.classList.remove('show');
            }
            activePopover = null;
            activePinned = false;
        }

        function openPopover(popover, pinned) {
            if (!popover) {
                return;
            }

            if (activePopover && activePopover !== popover) {
                activePopover.classList.remove('show');
            }

            popover.classList.add('show');
            activePopover = popover;
            activePinned = !!pinned;
        }

        document.addEventListener('click', function (event) {
            var badge = event.target.closest('.biblio-avail-badge');

            if (badge) {
                var wrap = badge.closest('.biblio-avail-wrap');
                var popover = wrap ? wrap.querySelector('.biblio-avail-popover') : null;

                if (popover) {
                    event.preventDefault();
                    event.stopPropagation();

                    if (activePopover === popover && activePinned) {
                        closeActive();
                    } else {
                        openPopover(popover, true);
                    }

                    return;
                }
            }

            if (activePopover && !event.target.closest('.biblio-avail-popover')) {
                closeActive();
            }
        });

        document.addEventListener('mouseover', function (event) {
            if (activePinned) {
                return;
            }

            var badge = event.target.closest('.biblio-avail-badge');
            if (!badge) {
                return;
            }

            var wrap = badge.closest('.biblio-avail-wrap');
            var popover = wrap ? wrap.querySelector('.biblio-avail-popover') : null;
            openPopover(popover, false);
        });

        document.addEventListener('mouseout', function (event) {
            var wrap = event.target.closest('.biblio-avail-wrap');
            if (!wrap || activePinned) {
                return;
            }

            if (event.relatedTarget && wrap.contains(event.relatedTarget)) {
                return;
            }

            var popover = wrap.querySelector('.biblio-avail-popover');
            if (popover && activePopover === popover) {
                closeActive();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeActive();
            }
        });
    })();
    </script>
<?php endif; ?>

<!-- Mobile Filter Modal (Tokopedia/Shopee style slideout) -->
<div class="modal fade" id="mobileFilterModal" tabindex="-1" role="dialog" aria-labelledby="mobileFilterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout" role="document">
        <div class="modal-content border-0 h-100">
            <div class="modal-header border-bottom py-3">
                <h5 class="modal-title fw-bold" id="mobileFilterModalLabel"><i class="fas fa-filter me-2 text-primary"></i><?= __('Filter') ?></h5>
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
                <h5 class="modal-title fw-bold" id="mobileSortModalLabel"><i class="fas fa-sort me-2 text-primary"></i><?= __('Sort by') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="list-group list-group-flush" id="mobile-sort-options"></div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Populate desktop sort options as chips
    $('#search-order option').each(function() {
        var value = $(this).val();
        var text = $(this).text().replace(/[_-]/g, ' ');
        text = text.charAt(0).toUpperCase() + text.slice(1);
        var isActive = $(this).prop('selected') ? 'active fw-bold' : '';
        
        $('#desktop-sort-chips').append(
            '<a href="#" class="sort-chip ' + isActive + '" data-value="' + value + '">' + text + '</a>'
        );
    });
    
    // Handle clicking desktop sort chip
    $(document).on('click', '#desktop-sort-chips .sort-chip', function(e) {
        e.preventDefault();
        var val = $(this).data('value');
        $('#search-order').val(val).trigger('change');
    });

    // Populate mobile sort options from the desktop select dropdown
    $('#search-order option').each(function() {
        var value = $(this).val();
        var text = $(this).text().replace(/[_-]/g, ' ');
        text = text.charAt(0).toUpperCase() + text.slice(1);
        var selected = $(this).prop('selected') ? 'active fw-bold' : '';
        var checkIcon = $(this).prop('selected') ? '<i class="fas fa-check text-primary float-end mt-1"></i>' : '';
        
        $('#mobile-sort-options').append(
            '<a href="#" class="list-group-item list-group-item-action ' + selected + '" data-value="' + value + '">' + 
            text + checkIcon + '</a>'
        );
    });
    
    // Handle clicking mobile sort option
    $(document).on('click', '#mobile-sort-options a', function(e) {
        e.preventDefault();
        var val = $(this).data('value');
        $('#search-order').val(val).trigger('change');
    });

    // Mobile filter modal handlers to prevent auto-submit on change and fix range slider width
    $('#mobileFilterModal').on('show.bs.modal', function() {
        $('#mobile-filter-container #search-filter input').off('change change.filter');
    });

    $('#mobileFilterModal').on('shown.bs.modal', function () {
        var slider = $('#mobile-filter-container #search-filter .input-slider').data("ionRangeSlider");
        if (slider) {
            slider.update();
        }
    });

    // When clicking mobile filter apply, trigger SLiMS filter function
    $('#apply-mobile-filter').on('click', function() {
        if (typeof filter === 'function') {
            filter();
        }
    });
    
    // Handle clicking reset button in mobile filter modal
    $('#reset-mobile-filter').on('click', function() {
        // Uncheck all checkboxes and radios
        $('#mobile-filter-container #search-filter input[type="checkbox"]').prop('checked', false);
        $('#mobile-filter-container #search-filter input[type="radio"]').prop('checked', false);
        
        // Reset the ionRangeSlider if it exists
        var slider = $('#mobile-filter-container #search-filter .input-slider').data("ionRangeSlider");
        if (slider) {
            var minVal = $('#mobile-filter-container #search-filter .input-slider').data('min');
            var maxVal = $('#mobile-filter-container #search-filter .input-slider').data('max');
            slider.update({
                from: minVal,
                to: maxVal
            });
            
            // Also update the input boxes if any (like js-input-from and js-input-to)
            $('#mobile-filter-container #search-filter .js-input-from').val(minVal);
            $('#mobile-filter-container #search-filter .js-input-to').val(maxVal);
        }
    });

    // Dynamic responsive filter position adjustment
    function adjustFilterPosition() {
        if ($(window).width() <= 768) {
            // Move to mobile modal if not already there
            if ($('#mobile-filter-container #search-filter').length === 0) {
                $('#search-filter').appendTo('#mobile-filter-container');
                // Disable SLiMS auto-submit on change for mobile view
                $('#mobile-filter-container #search-filter input:not(.input-slider)').off('change');
            }
        } else {
            // Move back to desktop sidebar if not already there
            if ($('#desktop-filter-container #search-filter').length === 0) {
                $('#search-filter').appendTo('#desktop-filter-container');
                // Re-bind SLiMS auto-submit on change for desktop view
                $('#desktop-filter-container #search-filter input:not(.input-slider)').off('change').on('change', function() {
                    if (typeof filter === 'function') {
                        filter($(this).attr('clear'));
                    }
                });
            }
        }
    }

    // Adjust position on load and on resize
    adjustFilterPosition();
    $(window).on('resize', function() {
        adjustFilterPosition();
    });
});
</script>
