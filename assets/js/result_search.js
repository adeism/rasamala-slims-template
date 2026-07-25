/*!
 * Rasamala search result interactions.
 */
'use strict';

(function ($, window, document) {
    if (!$) {
        return;
    }

    const getBootstrapModal = (modalEl) => {
        if (!modalEl || !window.bootstrap || !window.bootstrap.Modal) {
            return null;
        }

        return window.bootstrap.Modal.getInstance(modalEl) || new window.bootstrap.Modal(modalEl);
    };

    const hideModal = (modalId) => {
        const modal = getBootstrapModal(document.getElementById(modalId));

        if (modal) {
            modal.hide();
        }
    };

    const normalizeSortText = (text) => {
        const label = String(text || '').replace(/[_-]/g, ' ').trim();

        return label ? label.charAt(0).toUpperCase() + label.slice(1) : '';
    };

    const closestElement = (target, selector) => {
        const element = target && target.nodeType === 1 ? target : target && target.parentElement;

        return element && element.closest ? element.closest(selector) : null;
    };

    const initGridLayout = () => {
        const $items = $('.biblioResult .grid-item');

        if ($items.length === 0 || !$.fn.masonry) {
            return;
        }

        const $grid = $('.biblioResult').addClass('row').masonry({
            itemSelector: '.grid-item',
            columnWidth: '.grid-item',
            percentPosition: true
        });

        $items.find('img').each(function () {
            const image = new Image();

            image.onload = image.onerror = function () {
                $grid.masonry('layout');
            };
            image.src = $(this).attr('src') || '';
        });

        if ($.fn.dropdown) {
            $('.dropdown-toggle').dropdown();
        }
    };

    const initAvailabilityPopover = () => {
        let activePopover = null;
        let activePinned = false;

        const closeActive = () => {
            if (activePopover) {
                activePopover.classList.remove('show');
            }
            activePopover = null;
            activePinned = false;
        };

        const openPopover = (popover, pinned) => {
            if (!popover) {
                return;
            }

            if (activePopover && activePopover !== popover) {
                activePopover.classList.remove('show');
            }

            popover.classList.add('show');
            activePopover = popover;
            activePinned = !!pinned;
        };

        document.addEventListener('click', (event) => {
            const badge = closestElement(event.target, '.biblio-avail-badge');

            if (badge) {
                const wrap = badge.closest('.biblio-avail-wrap');
                const popover = wrap ? wrap.querySelector('.biblio-avail-popover') : null;

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

            if (activePopover && !closestElement(event.target, '.biblio-avail-popover')) {
                closeActive();
            }
        });

        document.addEventListener('mouseover', (event) => {
            if (activePinned) {
                return;
            }

            const badge = closestElement(event.target, '.biblio-avail-badge');
            if (!badge) {
                return;
            }

            const wrap = badge.closest('.biblio-avail-wrap');
            const popover = wrap ? wrap.querySelector('.biblio-avail-popover') : null;
            openPopover(popover, false);
        });

        document.addEventListener('mouseout', (event) => {
            const wrap = closestElement(event.target, '.biblio-avail-wrap');
            if (!wrap || activePinned) {
                return;
            }

            if (event.relatedTarget && wrap.contains(event.relatedTarget)) {
                return;
            }

            const popover = wrap.querySelector('.biblio-avail-popover');
            if (popover && activePopover === popover) {
                closeActive();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeActive();
            }
        });
    };

    const getSortIcon = (value, text) => {
        const val = String(value || '').toLowerCase();
        const txt = String(text || '').toLowerCase();

        if (val.indexOf('title') !== -1 || txt.indexOf('title') !== -1 || txt.indexOf('judul') !== -1) {
            return (val.indexOf('desc') !== -1 || txt.indexOf('z-a') !== -1 || txt.indexOf('desc') !== -1) ? 'fas fa-sort-alpha-up' : 'fas fa-sort-alpha-down';
        }
        if (val.indexOf('year') !== -1 || txt.indexOf('year') !== -1 || txt.indexOf('tahun') !== -1 || txt.indexOf('publish') !== -1) {
            return 'fas fa-calendar-alt';
        }
        if (val.indexOf('date') !== -1 || val.indexOf('time') !== -1 || txt.indexOf('update') !== -1 || txt.indexOf('terbaru') !== -1) {
            return 'fas fa-clock';
        }
        if (val.indexOf('author') !== -1 || txt.indexOf('author') !== -1 || txt.indexOf('pengarang') !== -1) {
            return 'fas fa-user-edit';
        }
        return 'fas fa-sort-amount-down';
    };

    const createSortOption = (option) => {
        const value = option.value || '';
        const text = normalizeSortText(option.text);
        const selected = option.selected;
        const iconClass = getSortIcon(value, text);

        const $item = $('<a>', {
            href: '#',
            class: `list-group-item list-group-item-action search-control-option search-sort-option-item ${selected ? 'active' : ''}`,
            'data-value': value,
            'role': 'button'
        });

        const $left = $('<div>', { class: 'search-control-option-main' });
        const $iconBox = $('<div>', {
            class: 'search-control-option-icon sort-option-icon-box'
        }).append($('<i>', { class: iconClass, 'aria-hidden': 'true' }));

        const $textWrap = $('<div>', { class: 'search-control-option-text' });
        const $title = $('<div>', { class: 'search-control-option-title' }).text(text);
        $textWrap.append($title);
        $left.append($iconBox).append($textWrap);

        $item.append($left);

        if (selected) {
            $item.append($('<i>', { class: 'fas fa-check-circle search-control-option-check', 'aria-hidden': 'true' }));
        }

        return $item;
    };

    const updateSortLabel = () => {
        const $select = $('#search-order');
        if ($select.length === 0) return;
        const $selected = $select.find('option:selected');
        if ($selected.length > 0) {
            const cleanText = normalizeSortText($selected.text());
            if (cleanText) {
                $('#current-sort-label').text(cleanText);
            }
        }
    };

    const updateActiveFilterBadge = () => {
        const $checked = $('#mobile-filter-container #search-filter input[type="checkbox"]:checked, #mobile-filter-container #search-filter input[type="radio"]:checked');
        const count = $checked.length;
        const $badge = $('#active-filter-count');

        if (count > 0) {
            $badge.text(count).removeClass('d-none');
            $('#btn-open-filter-modal').addClass('is-active').attr('aria-pressed', 'true');
        } else {
            $badge.addClass('d-none');
            $('#btn-open-filter-modal').removeClass('is-active').attr('aria-pressed', 'false');
        }
    };

    const initSortControls = () => {
        const $select = $('#search-order');
        const $mobileOptions = $('#mobile-sort-options');

        if ($select.length === 0) {
            return;
        }

        $mobileOptions.empty();
        $select.find('option').each(function () {
            $mobileOptions.append(createSortOption(this));
        });

        updateSortLabel();

        $(document).on('click', '#mobile-sort-options a', function (event) {
            event.preventDefault();
            const val = $(this).data('value');
            $select.val(val).trigger('change');

            $('#mobile-sort-options a').removeClass('active').find('.search-control-option-check').remove();

            $(this).addClass('active');
            $('<i>', { class: 'fas fa-check-circle search-control-option-check', 'aria-hidden': 'true' }).appendTo($(this));

            updateSortLabel();
            hideModal('mobileSortModal');
        });
    };

    const initMobileFilter = () => {
        $('#mobileFilterModal, #mobileSortModal, #mobileViewModal').appendTo('body');

        updateActiveFilterBadge();

        $(document).on('change', '#mobile-filter-container #search-filter input', function () {
            updateActiveFilterBadge();
        });

        $('#mobileFilterModal').on('show.bs.modal', function () {
            $('#mobile-filter-container #search-filter input').off('change.filter');
            updateActiveFilterBadge();
        });

        $('#mobileFilterModal').on('shown.bs.modal', function () {
            const slider = $('#mobile-filter-container #search-filter .input-slider').data('ionRangeSlider');

            if (slider) {
                slider.update();
            }
        });

        $('#apply-mobile-filter').on('click', function () {
            updateActiveFilterBadge();
            hideModal('mobileFilterModal');

            if (typeof window.filter === 'function') {
                window.filter();
            }
        });

        $('#reset-mobile-filter').on('click', function () {
            const $filter = $('#mobile-filter-container #search-filter');
            const $slider = $filter.find('.input-slider');
            const slider = $slider.data('ionRangeSlider');

            $filter.find('input[type="checkbox"]').prop('checked', false);
            $filter.find('input[type="radio"]').prop('checked', false);

            if (slider) {
                const minVal = $slider.data('min');
                const maxVal = $slider.data('max');

                slider.update({
                    from: minVal,
                    to: maxVal
                });

                $filter.find('.js-input-from').val(minVal);
                $filter.find('.js-input-to').val(maxVal);
            }

            updateActiveFilterBadge();
        });
    };

    const initResponsiveFilterPosition = () => {
        // Filter remains inside the pop-up modal on all screen sizes
        if ($('#mobile-filter-container #search-filter').length > 0) {
            $('#mobile-filter-container #search-filter input:not(.input-slider)').off('change');
        }
    };

    const initResultLoadingState = () => {
        const triggerLoading = (scrollUp = false) => {
            $('.result-search .wrapper').addClass('is-loading');
            if (window.RasamalaProgressBar && typeof window.RasamalaProgressBar.start === 'function') {
                window.RasamalaProgressBar.start();
            }
            if (scrollUp) {
                const $toolbar = $('.rasamala-search-action-bar, .result-search');
                if ($toolbar.length > 0) {
                    const top = Math.max(0, $toolbar.offset().top - 80);
                    $('html, body').animate({ scrollTop: top }, 250);
                }
            }
        };

        // 1. Pagination links click (Page 2, 3, Next, Prev, First, Last)
        $(document).on('click', '.pagination a, .pagingList a, .page-link, .page-item a', function () {
            const href = $(this).attr('href');
            if (href && href !== '#' && !href.startsWith('javascript:')) {
                triggerLoading(true);
            }
        });

        // 2. View mode switcher click
        $(document).on('click', '.search-view-option-item', function (event) {
            const href = $(this).attr('href');
            const viewVal = $(this).data('view-value');

            hideModal('mobileViewModal');
            triggerLoading(false);

            if (href && href !== '#' && !href.startsWith('javascript:')) {
                event.preventDefault();
                window.location.href = href;
            } else if (viewVal) {
                event.preventDefault();
                $('#search-view-input-value').val(viewVal);
                const formEl = document.getElementById('search-view-mode-form');
                if (formEl) {
                    formEl.submit();
                }
            }
        });

        $(document).on('submit', '#search-view-mode-form, .search-view-menu form', function () {
            hideModal('mobileViewModal');
            triggerLoading(false);
        });

        // 3. Desktop / Mobile Sort & Filter actions
        $(document).on('change', '#search-order', function () {
            triggerLoading(true);
        });

        $(document).on('click', '#apply-mobile-filter', function () {
            triggerLoading(true);
        });

        // 4. Detail links inside search results
        $(document).on('click', '.biblioResult a, .biblio-item a, .biblio-title-link, .result-item a', function () {
            const href = $(this).attr('href');
            const target = $(this).attr('target');
            if (href && href !== '#' && !href.startsWith('javascript:') && target !== '_blank' && !$(this).data('bs-toggle')) {
                triggerLoading(false);
            }
        });
    };

    $(function () {
        initGridLayout();
        initAvailabilityPopover();
        initSortControls();
        initMobileFilter();
        initResponsiveFilterPosition();
        initResultLoadingState();
    });
})(window.jQuery, window, document);
