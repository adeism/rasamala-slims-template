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

                    const basketCounter = query('#count-basket');
                    if (basketCounter) {
                        basketCounter.textContent = data.count || 0;
                    }
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

    const resizeObserver = new ResizeObserver(entries => {
        adjustTickerMarqueeSpeeds();
    });

    const tickers = document.querySelectorAll('.latest-content-ticker');
    tickers.forEach(ticker => {
        resizeObserver.observe(ticker);
        const track = ticker.querySelector('.latest-content-ticker-track');
        if (track) {
            resizeObserver.observe(track);
        }
    });

    adjustTickerMarqueeSpeeds();
});
