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

    const createSortOption = (option, className, includeCheckIcon) => {
        const value = option.value || '';
        const text = normalizeSortText(option.text);
        const selected = option.selected;
        const $link = $('<a>', {
            href: '#',
            class: className,
            'data-value': value
        }).text(text);

        if (selected) {
            $link.addClass('active fw-bold');
        }

        if (includeCheckIcon && selected) {
            $('<i>', {
                class: 'fas fa-check text-primary float-end mt-1',
                'aria-hidden': 'true'
            }).appendTo($link);
        }

        return $link;
    };

    const initSortControls = () => {
        const $select = $('#search-order');
        const $desktopChips = $('#desktop-sort-chips');
        const $mobileOptions = $('#mobile-sort-options');

        if ($select.length === 0) {
            return;
        }

        $select.find('option').each(function () {
            $desktopChips.append(createSortOption(
                this,
                'sort-chip',
                false
            ));
            $mobileOptions.append(createSortOption(
                this,
                'list-group-item list-group-item-action',
                true
            ));
        });

        $(document).on('click', '#desktop-sort-chips .sort-chip', function (event) {
            event.preventDefault();
            $select.val($(this).data('value')).trigger('change');
        });

        $(document).on('click', '#mobile-sort-options a', function (event) {
            event.preventDefault();
            $select.val($(this).data('value')).trigger('change');
            hideModal('mobileSortModal');
        });
    };

    const initMobileFilter = () => {
        $('#mobileFilterModal, #mobileSortModal').appendTo('body');

        $('#mobileFilterModal').on('show.bs.modal', function () {
            $('#mobile-filter-container #search-filter input').off('change change.filter');
        });

        $('#mobileFilterModal').on('shown.bs.modal', function () {
            const slider = $('#mobile-filter-container #search-filter .input-slider').data('ionRangeSlider');

            if (slider) {
                slider.update();
            }
        });

        $('#apply-mobile-filter').on('click', function () {
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
        });
    };

    const initResponsiveFilterPosition = () => {
        const adjustFilterPosition = () => {
            if ($(window).width() <= 768) {
                if ($('#mobile-filter-container #search-filter').length === 0) {
                    $('#search-filter').appendTo('#mobile-filter-container');
                    $('#mobile-filter-container #search-filter input:not(.input-slider)').off('change');
                }
                return;
            }

            if ($('#desktop-filter-container #search-filter').length === 0) {
                $('#search-filter').appendTo('#desktop-filter-container');
                $('#desktop-filter-container #search-filter input:not(.input-slider)')
                    .off('change')
                    .on('change', function () {
                        if (typeof window.filter === 'function') {
                            window.filter($(this).attr('clear'));
                        }
                    });
            }
        };

        adjustFilterPosition();
        $(window).on('resize', adjustFilterPosition);
    };

    $(function () {
        initGridLayout();
        initAvailabilityPopover();
        initSortControls();
        initMobileFilter();
        initResponsiveFilterPosition();
    });
})(window.jQuery, window, document);
