<?php
# @Author: Waris Agung Widodo <user>
# @Date:   2018-01-23T11:32:46+07:00
# @Email:  ido.alit@gmail.com
# @Filename: _result-search.php
# @Last modified by:   Ade Ismail Siregar (adeismailbox@gmail.com)
# @Last modified time: 2026-07-09T09:05:13+07:00

?>

<div class="result-search apple-subpage-wrapper">
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
        <?= themeBreadcrumbsHtml(__('Search')) ?>
        <div class="row">
            <!-- Filter Sidebar (Desktop Only) -->
            <div class="col-md-3 d-none d-md-block">
                <div class="card border-0 shadow-sm p-3 rounded">
                    <h5 class="font-weight-bold mb-3 border-bottom pb-2"><i class="fas fa-filter mr-2 text-primary"></i><?= __('Filter by') ?></h5>
                    <div id="desktop-filter-container">
                        <?= $engine->getFilter($opac, true) ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-9">
                <!-- Mobile Filter & Sort Toggle Bar (Mobile Only) -->
                <div class="d-md-none mb-3">
                    <div class="row no-gutters">
                        <div class="col-6 pr-1">
                            <button type="button" class="btn btn-light btn-modern-filter btn-block shadow-sm border d-flex align-items-center justify-content-center py-2" data-toggle="modal" data-target="#mobileFilterModal">
                                <i class="fas fa-filter mr-2 text-primary"></i> <?= __('Filter') ?>
                            </button>
                        </div>
                        <div class="col-6 pl-1">
                            <button type="button" class="btn btn-light btn-modern-filter btn-block shadow-sm border d-flex align-items-center justify-content-center py-2" data-toggle="modal" data-target="#mobileSortModal">
                                <i class="fas fa-sort mr-2 text-primary"></i> <?= __('Sort by') ?>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Search Info & View Switcher Row -->
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-3 mt-1 pb-2 border-bottom search-result-toolbar">
                    <div class="text-sm">
                        <?php
                        $keywords_text = (strlen($keywords) > 30) ? substr($keywords, 0, 30) . '...' : $keywords;
                        $keywords_info = '<span class="search-keyword-info font-weight-bold" title="' . themeEscape($keywords) . '">' . themeEscape($keywords_text) . '</span>';
                        $search_result_info = '<div class="search-found-info">';
                        $search_result_info .= __('Found <strong>{biblio_list->num_rows}</strong> from your keywords') . ': <strong class="search-found-info-keywords">' . $keywords_info . '</strong>';
                        $search_result_info .= '</div>';
                        echo str_replace('{biblio_list->num_rows}', themeSafeInt($engine->getNumRows()), $search_result_info);
                        ?>
                    </div>
                    
                    <!-- View Switcher -->
                    <div class="d-flex align-items-center">
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
                        <form method="POST" action="<?= themeEscape($view_action) ?>" class="view-switcher-form">
                            <input type="hidden" name="csrf_token" value="<?= themeEscape($view_csrf) ?>"/>
                            <div class="btn-group view-switcher" role="group" aria-label="<?= themeEscape(__('View mode')) ?>">
                                <?php foreach ($view_options as $view_key => $view_option) :
                                    $is_active_view = $current_view === $view_key;
                                ?>
                                <button type="submit"
                                        name="view"
                                        value="<?= themeEscape($view_key) ?>"
                                        class="btn btn-sm btn-light border px-3 py-2 d-flex align-items-center btn-switcher <?= $is_active_view ? 'active' : '' ?>"
                                        title="<?= themeEscape($view_option['title']) ?>"
                                        aria-pressed="<?= $is_active_view ? 'true' : 'false' ?>">
                                    <i class="<?= themeEscape($view_option['icon']) ?> mr-2"></i>
                                    <span><?= themeEscape($view_option['label']) ?></span>
                                </button>
                                <?php endforeach; ?>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Desktop Sort Chips Row (Desktop Only) -->
                <div class="d-none d-md-flex align-items-center flex-wrap mb-4 bg-light p-2 rounded shadow-sm desktop-sort-bar">
                    <span class="font-weight-bold mr-3 text-xs text-uppercase tracking-wider desktop-sort-title"><i class="fas fa-sort mr-1 text-primary"></i> <?= __('Sort by') ?>:</span>
                    <select class="d-none" id="search-order"><?= $sort_select ?></select>
                    <div id="desktop-sort-chips" class="d-flex align-items-center flex-wrap desktop-sort-chips"></div>
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
        // This code modified from: https://www.seancdavis.com/posts/wait-until-all-images-loaded/
        $(document).ready(function () {
            // Images loaded is zero because we're going to process a new set of images.
            let imagesLoaded = 0;
            // Total images is still the total number of <img> elements on the page.
            let totalImages = $(".grid-item .img-thumbnail").length;

            // Step through each image in the DOM, clone it, attach an onload event
            // listener, then set its source to the source of the original image. When
            // that new image has loaded, fire the imageLoaded() callback.
            $(".grid-item .img-thumbnail").each(function (idx, img) {
                $("<img>").on("load", imageLoaded).attr("src", $(img).attr("src"));
            });

            // Do exactly as we had before -- increment the loaded count and if all are
            // loaded, call the allImagesLoaded() function.
            function imageLoaded() {
                imagesLoaded++;
                if (imagesLoaded == totalImages) {
                allImagesLoaded();
                }
            }

            function allImagesLoaded() {
                $('.biblioResult').addClass('row').masonry({ itemSelector: '.grid-item', columnWidth: '.grid-item' })
                $('.dropdown-toggle').dropdown()
            }
        });
    </script>
<?php endif; ?>

<?php if(($_SESSION['LIST_VIEW'] ?? 'simple') === 'simple'): ?>
    <script>
    (function () {
        var activePopover = null;

        document.addEventListener('click', function (event) {
            var badge = event.target.closest('.biblio-avail-badge');

            if (badge) {
                var wrap = badge.closest('.biblio-avail-wrap');
                var popover = wrap ? wrap.querySelector('.biblio-avail-popover') : null;

                if (popover) {
                    event.preventDefault();
                    event.stopPropagation();

                    if (activePopover && activePopover !== popover) {
                        activePopover.classList.remove('show');
                    }

                    popover.classList.toggle('show');
                    activePopover = popover.classList.contains('show') ? popover : null;
                    return;
                }
            }

            if (activePopover && !event.target.closest('.biblio-avail-popover')) {
                activePopover.classList.remove('show');
                activePopover = null;
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
                <h5 class="modal-title font-weight-bold" id="mobileFilterModalLabel"><i class="fas fa-filter mr-2 text-primary"></i><?= __('Filter') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body overflow-auto p-3 mobile-filter-modal-body">
                <!-- Mobile filter form container -->
                <div id="mobile-filter-container"></div>
            </div>
            <div class="modal-footer border-top p-2 bg-light">
                <div class="row w-100 no-gutters">
                    <div class="col-6 pr-2">
                        <button type="button" class="btn btn-outline-secondary btn-block py-2 font-weight-bold btn-modal-action" id="reset-mobile-filter"><?= __('Reset') ?></button>
                    </div>
                    <div class="col-6 pl-2">
                        <button type="button" class="btn btn-primary btn-block py-2 font-weight-bold btn-modal-action" id="apply-mobile-filter"><?= __('Apply Filter') ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Sort Modal (Tokopedia/Shopee style sheet modal) -->
<div class="modal fade" id="mobileSortModal" tabindex="-1" role="dialog" aria-labelledby="mobileSortModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 rounded-lg">
            <div class="modal-header border-bottom py-3">
                <h5 class="modal-title font-weight-bold" id="mobileSortModalLabel"><i class="fas fa-sort mr-2 text-primary"></i><?= __('Sort by') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
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
        var text = $(this).text();
        var isActive = $(this).prop('selected') ? 'active font-weight-bold' : '';
        
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
        var text = $(this).text();
        var selected = $(this).prop('selected') ? 'active font-weight-bold' : '';
        var checkIcon = $(this).prop('selected') ? '<i class="fas fa-check text-primary float-right mt-1"></i>' : '';
        
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
        // Initialize year stepper adjusters
        initYearSteppers();
    }

    function initYearSteppers() {
        $('#search-filter .js-input-from, #search-filter .js-input-to').each(function() {
            var $input = $(this);
            if ($input.parent().hasClass('year-input-wrapper')) {
                return;
            }
            $input.wrap('<div class="year-input-wrapper"></div>');
            var $wrapper = $input.parent();
            $wrapper.append(
                '<div class="year-adjust-buttons">' +
                '  <button type="button" class="btn-year-up"><i class="fas fa-chevron-up"></i></button>' +
                '  <button type="button" class="btn-year-down"><i class="fas fa-chevron-down"></i></button>' +
                '</div>'
            );
            
            var $slider = $('#search-filter .input-slider');
            var min = parseInt($slider.data('min'), 10) || 0;
            var max = parseInt($slider.data('max'), 10) || 9999;
            
            $wrapper.find('.btn-year-up').on('click', function(e) {
                e.preventDefault();
                var val = parseInt($input.val(), 10) || min;
                if (val < max) {
                    $input.val(val + 1).trigger('input').trigger('change');
                }
            });
            
            $wrapper.find('.btn-year-down').on('click', function(e) {
                e.preventDefault();
                var val = parseInt($input.val(), 10) || min;
                if (val > min) {
                    $input.val(val - 1).trigger('input').trigger('change');
                }
            });
        });
    }

    // Adjust position on load and on resize
    adjustFilterPosition();
    $(window).on('resize', function() {
        adjustFilterPosition();
    });
});
</script>
