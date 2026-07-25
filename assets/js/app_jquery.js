/*!
 * Rasamala theme interactions.
 */
'use strict';

document.addEventListener('DOMContentLoaded', () => {
    const query = (selector, root = document) => root.querySelector(selector);
    const queryAll = (selector, root = document) => Array.prototype.slice.call(root.querySelectorAll(selector));

    const csrfToken = () => {
        const metaToken = query('meta[name="csrf-token"]');
        const inputToken = query('input[name="csrf_token"]');

        return (metaToken && metaToken.getAttribute('content')) || (inputToken && inputToken.value) || '';
    };

    const notify = (type, message, options = {}) => {
        const text = message || 'Request failed';

        if (window.toastr && typeof window.toastr[type] === 'function') {
            if (Object.keys(options).length > 0) {
                window.toastr[type](text, '', options);
                return;
            }

            window.toastr[type](text);
            return;
        }

        if (type === 'error') {
            console.error(text);
        }
    };

    const redirectWithToast = (message, url) => {
        const redirect = () => {
            window.location.replace(url);
        };

        if (window.toastr) {
            notify('error', message, {
                timeOut: 2000,
                onHidden: redirect
            });
            return;
        }

        console.error(message || 'Request failed');
        redirect();
    };

    const postForm = (url, data) => {
        const body = new URLSearchParams();

        Object.keys(data).forEach((key) => {
            const value = data[key];

            if (Array.isArray(value)) {
                value.forEach((item) => body.append(`${key}[]`, item));
                return;
            }

            body.append(key, value);
        });

        return fetch(url, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body
        }).then((response) => response.text().then((text) => {
            let payload = {};

            if (text) {
                try {
                    payload = JSON.parse(text);
                } catch (error) {
                    payload = {message: text};
                }
            }

            if (!response.ok) {
                const requestError = new Error(payload.message || 'Request failed');
                requestError.payload = payload;
                throw requestError;
            }

            return payload;
        }));
    };

    const stripHtml = (value) => {
        const temporary = document.createElement('div');
        temporary.innerHTML = String(value || '');

        return temporary.textContent || temporary.innerText || '';
    };

    const resizeFitHeightImages = () => {
        queryAll('.fit-height').forEach((image) => {
            const width = image.getBoundingClientRect().width || image.offsetWidth;

            if (width > 0) {
                image.style.height = `${(width * 83) / 65}px`;
            }
        });
    };

    resizeFitHeightImages();
    window.addEventListener('resize', resizeFitHeightImages);

    if (window.toastr) {
        window.toastr.options = {
            closeButton: false,
            debug: false,
            newestOnTop: false,
            progressBar: false,
            positionClass: 'toast-bottom-right',
            preventDuplicates: false,
            onclick: null,
            showDuration: '300',
            hideDuration: '1000',
            timeOut: '5000',
            extendedTimeOut: '1000',
            showEasing: 'swing',
            hideEasing: 'linear',
            showMethod: 'fadeIn',
            hideMethod: 'fadeOut'
        };
    }

    queryAll('.add-to-chart-button').forEach((button) => {
        button.addEventListener('click', (event) => {
            event.preventDefault();

            postForm('index.php?p=member', {
                biblio: [button.getAttribute('data-biblio') || ''],
                callback: 'json',
                csrf_token: csrfToken()
            })
                .then((data) => {
                    notify(data.status ? 'success' : 'error', data.message);

                    const newCount = typeof data.count !== 'undefined' ? data.count : 0;
                    queryAll('#count-basket, .count-basket, #count-basket-mobile, .basket-badge-mobile').forEach((basketCounter) => {
                        basketCounter.textContent = newCount;
                    });
                })
                .catch((error) => {
                    console.error('ERROR!', error);
                    redirectWithToast((error.payload && error.payload.message) || error.message, 'index.php?p=member');
                });
        });
    });

    queryAll('.bookMarkBook').forEach((button) => {
        button.addEventListener('click', (event) => {
            event.preventDefault();

            if (button.classList.contains('bg-success')) return;

            const id = button.getAttribute('data-id') || '';

            postForm('index.php?p=member&sec=bookmark', {
                bookmark_id: id,
                callback: 'json',
                csrf_token: csrfToken()
            })
                .then((res) => {
                    const successClasses = button.hasAttribute('data-detail')
                        ? ['bg-success', 'text-white', 'rounded-3', 'px-2', 'py-1']
                        : ['bg-success', 'text-white', 'rounded-3'];
                    const label = document.getElementById(`label-${id}`);

                    button.classList.remove('text-muted');
                    button.classList.add(...successClasses);

                    if (label) {
                        label.textContent = res.label || '';
                    }

                    notify('success', res.message);
                })
                .catch((error) => {
                    redirectWithToast(
                        (error.payload && error.payload.message) || error.message,
                        `index.php?p=member&destination=${encodeURIComponent(`${window.location.href}#card-${id}`)}`
                    );
                });
        });
    });

    queryAll('a[data-bs-target="#mediaSocialModal"]').forEach((link) => {
        link.addEventListener('click', () => {
            const modalBody = query('#mediaSocialModalBody');
            const id = encodeURIComponent(link.getAttribute('data-id') || '');
            const title = encodeURIComponent(stripHtml(link.getAttribute('data-title')).replace(/["']/g, ''));
            const iframe = document.createElement('iframe');

            if (!modalBody) return;

            iframe.src = `?p=sharelink&id=${id}&title=${title}`;
            iframe.className = 'w-100';
            iframe.style.height = '5.5rem';

            modalBody.textContent = '';
            modalBody.appendChild(iframe);
        });
    });

    document.addEventListener('click', (e) => {
        const shareBtn = e.target.closest('.btn-news-share, .btn-content-share');
        if (shareBtn) {
            e.preventDefault();
            const url = shareBtn.getAttribute('data-url') || window.location.href;
            const title = shareBtn.getAttribute('data-title') || document.title;

            if (navigator.share) {
                navigator.share({ title: title, url: url }).catch(() => {});
            } else {
                const modalTarget = document.querySelector('a[data-bs-target="#mediaSocialModal"], button[data-bs-target="#mediaSocialModal"]');
                if (modalTarget) {
                    modalTarget.setAttribute('data-url', url);
                    modalTarget.setAttribute('data-title', title);
                    modalTarget.click();
                } else if (navigator.clipboard) {
                    navigator.clipboard.writeText(url).then(() => {
                        alert('Link berhasil disalin!');
                    });
                }
            }
        }

        const qrBtn = e.target.closest('.btn-news-qr, .btn-content-qr');
        if (qrBtn) {
            e.preventDefault();
            const url = qrBtn.getAttribute('data-url') || window.location.href;
            const title = qrBtn.getAttribute('data-title') || document.title;

            const qrImgWrap = document.getElementById('contentQrModalImage');
            const qrTitle = document.getElementById('contentQrModalTitle');
            const qrInput = document.getElementById('contentQrModalInput');
            const qrLink = document.getElementById('contentQrModalLink');

            if (qrImgWrap) {
                const qrSvg = qrBtn.getAttribute('data-qr-svg');
                if (qrSvg && qrSvg.trim() !== '') {
                    qrImgWrap.innerHTML = qrSvg;
                } else {
                    const apiQr = 'https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=' + encodeURIComponent(url);
                    qrImgWrap.innerHTML = `<img src="${apiQr}" alt="QR Code" class="img-fluid rounded" style="max-width:160px; height:auto;">`;
                }
            }
            if (qrTitle) qrTitle.textContent = title;
            if (qrInput) qrInput.value = url;
            if (qrLink) qrLink.href = url;

            const modalEl = document.getElementById('contentQrModal');
            if (modalEl) {
                if (window.bootstrap && window.bootstrap.Modal) {
                    const modalObj = window.bootstrap.Modal.getOrCreateInstance(modalEl);
                    modalObj.show();
                } else if (window.jQuery && window.jQuery.fn.modal) {
                    window.jQuery(modalEl).modal('show');
                }
            }
        }

        const closeBtn = e.target.closest('[data-bs-dismiss="modal"], [data-dismiss="modal"], .btn-close');
        if (closeBtn) {
            const modalEl = closeBtn.closest('.modal');
            if (modalEl) {
                if (window.bootstrap && window.bootstrap.Modal) {
                    const modalObj = window.bootstrap.Modal.getInstance(modalEl) || window.bootstrap.Modal.getOrCreateInstance(modalEl);
                    if (modalObj) {
                        modalObj.hide();
                    }
                }
                if (window.jQuery && window.jQuery.fn.modal) {
                    window.jQuery(modalEl).modal('hide');
                }
                modalEl.classList.remove('show');
                modalEl.style.display = 'none';
                modalEl.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
                document.querySelectorAll('.modal-backdrop').forEach((el) => el.remove());
            }
        }

        if (e.target.classList && e.target.classList.contains('modal')) {
            const modalEl = e.target;
            if (window.bootstrap && window.bootstrap.Modal) {
                const modalObj = window.bootstrap.Modal.getInstance(modalEl);
                if (modalObj) modalObj.hide();
            }
            if (window.jQuery && window.jQuery.fn.modal) {
                window.jQuery(modalEl).modal('hide');
            }
            modalEl.classList.remove('show');
            modalEl.style.display = 'none';
            modalEl.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
            document.querySelectorAll('.modal-backdrop').forEach((el) => el.remove());
        }

        const detailQrBtnMobile = e.target.closest('.detail-qr-btn-mobile');
        if (detailQrBtnMobile) {
            e.preventDefault();
            const modalEl = document.getElementById('detailQrModal');
            if (modalEl) {
                if (window.bootstrap && window.bootstrap.Modal) {
                    const modalObj = window.bootstrap.Modal.getOrCreateInstance(modalEl);
                    modalObj.show();
                } else if (window.jQuery && window.jQuery.fn.modal) {
                    window.jQuery(modalEl).modal('show');
                }
                modalEl.classList.add('show');
                modalEl.style.display = 'block';
            }
        }
    });

    queryAll('oembed').forEach((element) => {
        const rawUrl = String(element.getAttribute('url') || '').replace('watch?v=', 'embed/');

        try {
            const urlSrc = new URL(rawUrl, window.location.origin);
            const mediaFigure = query('figure.media');

            if ((urlSrc.protocol !== 'https:' && urlSrc.protocol !== 'http:') || !mediaFigure) return;

            const iframe = document.createElement('iframe');

            iframe.src = urlSrc.href;
            iframe.frameBorder = '0';
            iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share';
            iframe.allowFullscreen = true;
            iframe.style.width = '100%';
            iframe.style.height = `${window.innerHeight - 200}px`;

            mediaFigure.appendChild(iframe);
        } catch (error) {
            return;
        }
    });

    const setCollapseIcon = (target, expanded) => {
        const id = target && target.getAttribute('id');
        const toggleButton = id ? document.getElementById(`btn-${id}`) : null;
        const icon = toggleButton ? query('i', toggleButton) : null;

        if (!icon) return;

        icon.classList.toggle('fa-angle-double-down', !expanded);
        icon.classList.toggle('fa-angle-double-up', expanded);
    };

    document.addEventListener('shown.bs.collapse', (event) => setCollapseIcon(event.target, true));
    document.addEventListener('hidden.bs.collapse', (event) => setCollapseIcon(event.target, false));

    if (window.jQuery) {
        const jq = window.jQuery;

        jq('.collapse-detail')
            .on('shown.bs.collapse', (event) => setCollapseIcon(event.target, true))
            .on('hidden.bs.collapse', (event) => setCollapseIcon(event.target, false));
    }

    const showChatButton = query('#show-pchat');
    const hideChatButton = query('#show-pchat2');
    const setChatVisibility = (visible) => {
        queryAll('.s-chat').forEach((element) => {
            element.style.display = visible ? '' : 'none';
        });

        if (hideChatButton) {
            hideChatButton.style.display = visible ? 'none' : '';
        }
    };

    if (showChatButton) {
        showChatButton.addEventListener('click', () => setChatVisibility(false));
    }

    if (hideChatButton) {
        hideChatButton.addEventListener('click', () => setChatVisibility(true));
    }

    const mobileMoreButtons = queryAll('[data-mobile-more-trigger]');
    const mobileMoreOverlay = query('#mobile-more-menu-overlay');
    const closeMobileMoreButton = query('#close-mobile-more-menu');
    const closeMobileMore = () => {
        if (mobileMoreOverlay) {
            mobileMoreOverlay.classList.remove('active');
        }

        document.body.classList.remove('overflow-hidden');
    };

    if (mobileMoreButtons.length && mobileMoreOverlay) {
        mobileMoreButtons.forEach((mobileMoreButton) => mobileMoreButton.addEventListener('click', (event) => {
            event.preventDefault();
            mobileMoreOverlay.classList.add('active');
            document.body.classList.add('overflow-hidden');
        }));

        mobileMoreOverlay.addEventListener('click', (event) => {
            if (event.target === mobileMoreOverlay) {
                closeMobileMore();
            }
        });
    }

    if (closeMobileMoreButton) {
        closeMobileMoreButton.addEventListener('click', closeMobileMore);
    }

    const backToTopButton = query('#back-to-top');

    if (backToTopButton) {
        const toggleBackToTop = () => {
            backToTopButton.classList.toggle('visible', window.pageYOffset > 300);
        };

        toggleBackToTop();
        window.addEventListener('scroll', toggleBackToTop, {passive: true});

        backToTopButton.addEventListener('click', (event) => {
            event.preventDefault();
            window.scrollTo({top: 0, behavior: 'smooth'});
        });
    }

    queryAll('.biblioPaging .pagingList').forEach((list) => {
        const walker = document.createTreeWalker(list, NodeFilter.SHOW_TEXT);
        const textNodes = [];

        while (walker.nextNode()) {
            textNodes.push(walker.currentNode);
        }

        textNodes.forEach((node) => {
            node.nodeValue = node.nodeValue.replace(/\u00a0/g, '');
        });
    });

    // Dynamic Running Text/Marquee Speed Adjustments (Constant speed in px/s)
    const adjustTickerMarqueeSpeeds = () => {
        const tickers = document.querySelectorAll('.latest-content-ticker');
        tickers.forEach(ticker => {
            const track = ticker.querySelector('.latest-content-ticker-track');
            const baseGroup = ticker.querySelector('.latest-content-ticker-group');

            if (!track || !baseGroup) return;

            ticker.style.setProperty('--ticker-start-gap', '0px');
            ticker.style.setProperty('--ticker-distance', '-50%');

            const speedKey = ticker.getAttribute('data-speed') || 'normal';
            let speedPxS = 65; // default normal
            if (speedKey === 'fast') {
                speedPxS = 110;
            } else if (speedKey === 'normal') {
                speedPxS = 65;
            } else if (speedKey === 'slow') {
                speedPxS = 36;
            } else if (speedKey === 'very_slow') {
                speedPxS = 20;
            }

            const tickerWidth = Math.max(ticker.clientWidth, 1);
            const baseContentWidth = Math.max(baseGroup.scrollWidth, 1);
            const shouldStartFromEdge = baseContentWidth < tickerWidth * 1.25;

            if (shouldStartFromEdge) {
                ticker.classList.add('is-edge-marquee');
                ticker.style.setProperty('--ticker-start-gap', `${tickerWidth}px`);
            }

            const baseGroupWidth = Math.max(baseGroup.scrollWidth, 1);
            const minimumTrackWidth = tickerWidth + (baseGroupWidth * 2);
            let cloneCount = 0;
            while (track.scrollWidth < minimumTrackWidth && cloneCount < 12) {
                const clone = baseGroup.cloneNode(true);
                clone.setAttribute('aria-hidden', 'true');
                clone.setAttribute('inert', '');
                clone.setAttribute('data-ticker-clone', 'true');
                track.appendChild(clone);
                cloneCount++;
            }

            const trackWidth = track.scrollWidth;
            ticker.style.setProperty('--ticker-distance', `-${baseGroupWidth}px`);
            const duration = (baseGroupWidth + (shouldStartFromEdge ? tickerWidth : 0)) / speedPxS;
            ticker.style.setProperty('--ticker-duration', `${duration}s`);
        });
    };

    const tickers = document.querySelectorAll('.latest-content-ticker');
    if ('ResizeObserver' in window) {
        const resizeObserver = new ResizeObserver(() => {
            adjustTickerMarqueeSpeeds();
        });

        tickers.forEach(ticker => {
            resizeObserver.observe(ticker);
            const track = ticker.querySelector('.latest-content-ticker-track');
            if (track) {
                resizeObserver.observe(track);
            }
        });
    } else {
        window.addEventListener('resize', adjustTickerMarqueeSpeeds);
        window.addEventListener('orientationchange', adjustTickerMarqueeSpeeds);
    }

    adjustTickerMarqueeSpeeds();

    // Simplify pagination by replacing text with FontAwesome icons
    const simplifyPagination = () => {
        const firstLinks = document.querySelectorAll('.pagingList .first_link');
        const prevLinks = document.querySelectorAll('.pagingList .prev_link');
        const nextLinks = document.querySelectorAll('.pagingList .next_link');
        const lastLinks = document.querySelectorAll('.pagingList .last_link');

        firstLinks.forEach(link => {
            const text = link.textContent.trim();
            link.setAttribute('title', text);
            link.setAttribute('aria-label', text);
            link.innerHTML = '<i class="fas fa-angle-double-left" aria-hidden="true"></i>';
        });

        prevLinks.forEach(link => {
            const text = link.textContent.trim();
            link.setAttribute('title', text);
            link.setAttribute('aria-label', text);
            link.innerHTML = '<i class="fas fa-chevron-left" aria-hidden="true"></i>';
        });

        nextLinks.forEach(link => {
            const text = link.textContent.trim();
            link.setAttribute('title', text);
            link.setAttribute('aria-label', text);
            link.innerHTML = '<i class="fas fa-chevron-right" aria-hidden="true"></i>';
        });

        lastLinks.forEach(link => {
            const text = link.textContent.trim();
            link.setAttribute('title', text);
            link.setAttribute('aria-label', text);
            link.innerHTML = '<i class="fas fa-angle-double-right" aria-hidden="true"></i>';
        });
    };
    simplifyPagination();
});

// Top Page Progress Bar Manager
(function () {
    const RasamalaProgressBar = {
        bar: null,
        timer: null,
        progress: 0,
        init() {
            if (this.bar) return;
            const el = document.createElement('div');
            el.id = 'rasamala-page-progress-bar';
            el.className = 'rasamala-page-progress-bar';
            el.setAttribute('role', 'progressbar');
            el.setAttribute('aria-hidden', 'true');
            document.body.appendChild(el);
            this.bar = el;
        },
        start() {
            this.init();
            if (!this.bar) return;
            clearTimeout(this.timer);
            this.progress = 15;
            this.bar.style.width = '15%';
            this.bar.classList.add('active');

            const trickle = () => {
                if (this.progress < 88) {
                    this.progress += Math.floor(Math.random() * 8) + 3;
                    this.bar.style.width = Math.min(this.progress, 88) + '%';
                    this.timer = setTimeout(trickle, 200);
                }
            };
            this.timer = setTimeout(trickle, 120);
        },
        done() {
            if (!this.bar) return;
            clearTimeout(this.timer);
            this.bar.style.width = '100%';
            this.timer = setTimeout(() => {
                this.bar.classList.remove('active');
                setTimeout(() => {
                    this.bar.style.width = '0%';
                }, 300);
            }, 200);
        }
    };

    window.RasamalaProgressBar = RasamalaProgressBar;

    document.addEventListener('click', (event) => {
        const link = event.target && event.target.closest ? event.target.closest('a') : null;
        if (!link) return;

        const href = link.getAttribute('href');
        const target = link.getAttribute('target');
        const hasModal = link.hasAttribute('data-bs-toggle') || link.hasAttribute('data-toggle');

        if (!href || href === '#' || href.startsWith('javascript:') || href.startsWith('mailto:') || href.startsWith('tel:') || target === '_blank' || hasModal) {
            return;
        }

        RasamalaProgressBar.start();

        const isPaging = link.closest('.pagingList') || link.closest('.pagination') || link.classList.contains('page-link');
        const isBiblioLink = link.closest('.biblioResult') || link.closest('.biblio-item') || link.classList.contains('biblio-title-link');

        if (isPaging || isBiblioLink) {
            const wrapper = document.querySelector('.result-search .wrapper');
            if (wrapper) {
                wrapper.classList.add('is-loading');
                const toolbar = document.querySelector('.search-result-toolbar') || document.querySelector('.result-search');
                if (toolbar) {
                    toolbar.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        }
    });

    window.addEventListener('beforeunload', () => {
        RasamalaProgressBar.start();
    });
})();
