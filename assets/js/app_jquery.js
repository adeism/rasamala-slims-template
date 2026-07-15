/*!
 * Rasamala theme interactions.
 *
 * @Last modified by    : Ade Ismail Siregar (adeismailbox@gmail.com)
 * @Last modified time  : 2026-07-15T12:27:50+07:00
 */
'use strict';

document.addEventListener('DOMContentLoaded', () => {
    const query = (selector, root = document) => root.querySelector(selector);
    const queryAll = (selector, root = document) => Array.prototype.slice.call(root.querySelectorAll(selector));

    const colorModeStorageKey = 'rasamala-color-mode';
    const applyColorMode = (mode) => {
        const isDarkMode = mode === 'dark';

        document.documentElement.classList.toggle('rasamala-dark', isDarkMode);
        document.body.classList.toggle('rasamala-dark', isDarkMode);

        // Dynamically load or remove dark mode CSS link
        let darkLink = document.getElementById('rasamala-dark-css');
        if (isDarkMode) {
            if (!darkLink && window.rasamalaDarkCssUrl) {
                darkLink = document.createElement('link');
                darkLink.id = 'rasamala-dark-css';
                darkLink.rel = 'stylesheet';
                darkLink.href = window.rasamalaDarkCssUrl;
                document.head.appendChild(darkLink);
            }
        } else {
            if (darkLink) {
                darkLink.remove();
            }
        }

        const activeToggles = queryAll('#color-mode-toggle, #color-mode-toggle-nav, #color-mode-toggle-desktop');
        activeToggles.forEach(toggle => {
            toggle.setAttribute('aria-pressed', isDarkMode ? 'true' : 'false');
            toggle.setAttribute(
                'title',
                isDarkMode
                    ? (toggle.getAttribute('data-light-title') || 'Light mode')
                    : (toggle.getAttribute('data-dark-title') || 'Dark mode')
            );

            const icon = query('i', toggle);
            if (icon) {
                icon.classList.toggle('fa-moon', !isDarkMode);
                icon.classList.toggle('fa-sun', isDarkMode);
            }
        });
    };
    const getStoredColorMode = () => {
        try {
            return window.localStorage.getItem(colorModeStorageKey) || (document.body.classList.contains('rasamala-dark') ? 'dark' : 'light');
        } catch (error) {
            return document.body.classList.contains('rasamala-dark') ? 'dark' : 'light';
        }
    };

    applyColorMode(getStoredColorMode());

    document.addEventListener('click', (event) => {
        const toggle = event.target.closest('#color-mode-toggle, #color-mode-toggle-nav, #color-mode-toggle-desktop');
        if (!toggle) return;

        event.preventDefault();

        const nextMode = document.body.classList.contains('rasamala-dark') ? 'light' : 'dark';

        try {
            window.localStorage.setItem(colorModeStorageKey, nextMode);
        } catch (error) {}

        applyColorMode(nextMode);
    });

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

    const initializeHeroAnimation = () => {
        const layer = query('#background-animation-layer') || query('#hero-animation-layer');

        if (!layer) return;

        const animation = layer.getAttribute('data-animation') || 'particles';
        const isGlobalBackground = layer.classList.contains('background-animation-layer');
        const reducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        const cpuCores = Number(window.navigator.hardwareConcurrency || 4);
        const deviceMemory = Number(window.navigator.deviceMemory || 4);
        const smallViewport = window.matchMedia && window.matchMedia('(max-width: 767px)').matches;
        const liteMode = smallViewport || cpuCores <= 4 || deviceMemory <= 4;

        if (reducedMotion) {
            layer.classList.add('is-static');
            return;
        }

        const speedMult = parseFloat(layer.getAttribute('data-speed-multiplier')) || 1.0;

        const rootStyle = getComputedStyle(document.documentElement);
        const accentColor = rootStyle.getPropertyValue('--theme-accent-color').trim() || '#6f5b43';
        const accentRgb = rootStyle.getPropertyValue('--theme-accent-rgb').trim() || '111, 91, 67';
        const accentAlpha = (alpha) => `rgba(${accentRgb}, ${alpha})`;
        const darkHeroAnimation = ['particles', 'constellation', 'rain', 'bubbles', 'twinkle', 'glow'].includes(animation);
        const colors = isGlobalBackground
            ? [accentColor, accentAlpha(1), accentAlpha(0.92), accentAlpha(0.78), accentAlpha(0.62)]
            : (darkHeroAnimation
                ? [accentColor, accentAlpha(0.95), accentAlpha(0.78), accentAlpha(0.62), 'rgba(255, 255, 255, 0.88)']
                : [accentColor, accentAlpha(0.88), accentAlpha(0.68), accentAlpha(0.48)]);
        const glyphs = 'RASAMALA0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        const fragment = document.createDocumentFragment();
        const random = (min, max) => Math.random() * (max - min) + min;
        const randomInt = (min, max) => Math.floor(random(min, max + 1));
        const randomColor = () => colors[randomInt(0, colors.length - 1)];
        const randomGlyph = () => glyphs.charAt(randomInt(0, glyphs.length - 1));

        if (animation === 'particles') {
            const particleCount = liteMode ? (isGlobalBackground ? 26 : 18) : (isGlobalBackground ? 42 : 28);
            for (let i = 0; i < particleCount; i += 1) {
                const token = document.createElement('span');
                const size = isGlobalBackground ? random(14, 38) : random(12, 32);

                token.className = 'hero-token';
                token.textContent = randomGlyph();
                token.style.left = `${random(0, 100)}%`;
                token.style.top = `${random(0, 100)}%`;
                token.style.fontSize = `${size}px`;
                token.style.color = randomColor();
                token.style.textShadow = 'none';
                token.style.setProperty('--tx', `${random(-28, 28)}vw`);
                token.style.setProperty('--ty', `${random(-22, 22)}vh`);
                token.style.setProperty('--rot', `${random(-120, 120)}deg`);
                token.style.animationDuration = `${random(16, 30) * speedMult}s`;
                token.style.animationDelay = `-${random(0, 20)}s`;
                fragment.appendChild(token);
            }
        }

        if (animation === 'rain') {
            const rainCount = liteMode ? (isGlobalBackground ? 12 : 8) : (isGlobalBackground ? 18 : 12);
            for (let i = 0; i < rainCount; i += 1) {
                const column = document.createElement('span');
                const length = randomInt(6, 11);
                const text = Array.from({length}, randomGlyph).join('\n');

                column.className = 'hero-rain-column';
                column.textContent = text;
                column.style.left = `${random(0, 100)}%`;
                column.style.color = randomColor();
                column.style.fontSize = `${isGlobalBackground ? random(12, 18) : random(11, 16)}px`;
                column.style.animationDuration = `${random(14, 26) * speedMult}s`;
                column.style.animationDelay = `-${random(0, 18)}s`;
                fragment.appendChild(column);
            }
        }

        if (animation === 'constellation') {
            const lineCount = liteMode ? (isGlobalBackground ? 12 : 8) : (isGlobalBackground ? 20 : 14);
            const nodeCount = liteMode ? (isGlobalBackground ? 16 : 10) : (isGlobalBackground ? 28 : 18);
            for (let i = 0; i < lineCount; i += 1) {
                const line = document.createElement('span');
                line.className = 'hero-line';
                line.style.left = `${random(0, 100)}%`;
                line.style.top = `${random(0, 100)}%`;
                line.style.width = `${random(70, 190)}px`;
                line.style.color = randomColor();
                line.style.setProperty('--angle', `${random(-68, 68)}deg`);
                line.style.animationDuration = `${random(10, 18) * speedMult}s`;
                line.style.animationDelay = `-${random(0, 9)}s`;
                fragment.appendChild(line);
            }

            for (let i = 0; i < nodeCount; i += 1) {
                const node = document.createElement('span');
                node.className = 'hero-node';
                node.style.left = `${random(0, 100)}%`;
                node.style.top = `${random(0, 100)}%`;
                node.style.color = randomColor();
                node.style.setProperty('--tx', `${random(-18, 18)}px`);
                node.style.setProperty('--ty', `${random(-18, 18)}px`);
                node.style.animationDuration = `${random(12, 22) * speedMult}s`;
                node.style.animationDelay = `-${random(0, 10)}s`;
                fragment.appendChild(node);
            }
        }

        if (animation === 'bubbles') {
            const bubbleCount = liteMode ? (isGlobalBackground ? 12 : 8) : (isGlobalBackground ? 22 : 14);
            for (let i = 0; i < bubbleCount; i += 1) {
                const bubble = document.createElement('span');
                const size = random(12, 48);
                const opacity = random(0.12, 0.36);

                bubble.className = 'hero-bubble';
                bubble.style.left = `${random(0, 100)}%`;
                bubble.style.bottom = `-${size}px`;
                bubble.style.width = `${size}px`;
                bubble.style.height = `${size}px`;
                bubble.style.background = `radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.22) 0%, rgba(${accentRgb}, 0.08) 50%, rgba(${accentRgb}, 0.25) 100%)`;
                bubble.style.border = `1px solid rgba(${accentRgb}, 0.18)`;
                bubble.style.setProperty('--op', opacity);
                bubble.style.setProperty('--tx', `${random(-12, 12)}vw`);
                bubble.style.animationDuration = `${random(14, 28) * speedMult}s`;
                bubble.style.animationDelay = `-${random(0, 16)}s`;
                fragment.appendChild(bubble);
            }
        }

        if (animation === 'twinkle') {
            const starCount = liteMode ? (isGlobalBackground ? 25 : 18) : (isGlobalBackground ? 50 : 35);
            for (let i = 0; i < starCount; i += 1) {
                const star = document.createElement('span');
                const size = random(2, 5);

                star.className = 'hero-star';
                star.style.left = `${random(0, 100)}%`;
                star.style.top = `${random(0, 100)}%`;
                star.style.width = `${size}px`;
                star.style.height = `${size}px`;
                star.style.background = `radial-gradient(circle, #ffffff 0%, rgba(${accentRgb}, 0.6) 40%, rgba(${accentRgb}, 0) 100%)`;
                star.style.boxShadow = `0 0 ${size * 2}px rgba(${accentRgb}, 0.4)`;
                star.style.animationDuration = `${random(3, 8) * speedMult}s`;
                star.style.animationDelay = `-${random(0, 8)}s`;
                fragment.appendChild(star);
            }
        }

        if (animation === 'glow') {
            const orbCount = 3;
            for (let i = 0; i < orbCount; i += 1) {
                const orb = document.createElement('span');

                orb.className = `hero-orb hero-orb-${i + 1}`;
                orb.style.background = `radial-gradient(circle, rgba(${accentRgb}, 0.26) 0%, rgba(${accentRgb}, 0.08) 48%, rgba(${accentRgb}, 0) 70%)`;
                orb.style.animationDuration = `${(25 + i * 8) * speedMult}s`;
                fragment.appendChild(orb);
            }
        }

        layer.appendChild(fragment);
    };

    initializeHeroAnimation();

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
            if (!track) return;

            const groups = Array.prototype.slice.call(track.querySelectorAll('.latest-content-ticker-group'));
            const baseGroup = groups[0];
            if (!baseGroup) return;

            groups.slice(1).forEach(group => group.remove());
            ticker.classList.remove('is-edge-marquee');
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
                clone.setAttribute('data-ticker-clone', 'true');
                track.appendChild(clone);
                cloneCount += 1;
            }

            const distance = baseGroupWidth;
            if (distance > 0) {
                const duration = Math.max(distance / speedPxS, shouldStartFromEdge ? 14 : 8);
                ticker.style.setProperty('--ticker-distance', `-${distance}px`);
                track.style.animationDuration = `${duration}s`;
            }
        });
    };

    adjustTickerMarqueeSpeeds();
    window.addEventListener('resize', adjustTickerMarqueeSpeeds);
    if (document.fonts) {
        document.fonts.ready.then(adjustTickerMarqueeSpeeds);
    }

});
