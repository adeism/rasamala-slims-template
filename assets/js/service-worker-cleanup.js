/* Remove service workers and caches shipped by older Rasamala releases. */
(function () {
    'use strict';

    const isRasamalaWorker = function (registration) {
        const worker = registration.installing || registration.waiting || registration.active;
        if (!worker || !worker.scriptURL) return false;

        try {
            const pathname = new URL(worker.scriptURL, window.location.href).pathname;
            return pathname.endsWith('/rasamala-sw.js')
                || pathname.endsWith('/template/rasamala/assets/js/sw.js');
        } catch (error) {
            return false;
        }
    };

    const unregisterWorkers = function () {
        if (!('serviceWorker' in navigator)) return Promise.resolve();

        return navigator.serviceWorker.getRegistrations().then(function (registrations) {
            return Promise.all(registrations.filter(isRasamalaWorker).map(function (registration) {
                return registration.unregister();
            }));
        });
    };

    const removeCaches = function () {
        if (!('caches' in window)) return Promise.resolve();

        return window.caches.keys().then(function (keys) {
            return Promise.all(keys.filter(function (key) {
                return key.indexOf('rasamala-static-') === 0
                    || key.indexOf('rasamala-opac-') === 0;
            }).map(function (key) {
                return window.caches.delete(key);
            }));
        });
    };

    const FLAG_KEY = 'rasamala-sw-cleanup-v1';

    // Run once per browser: after a successful pass there is nothing left
    // that could re-register the retired workers, so skip the
    // getRegistrations()/caches.keys() round-trips on later page loads.
    const alreadyCleaned = function () {
        try {
            return window.localStorage && window.localStorage.getItem(FLAG_KEY) === '1';
        } catch (error) {
            return false;
        }
    };

    const markCleaned = function () {
        try {
            if (window.localStorage) window.localStorage.setItem(FLAG_KEY, '1');
        } catch (error) {
            // Private mode etc: simply run again next visit.
        }
    };

    const cleanup = function () {
        if (alreadyCleaned()) return;
        Promise.all([unregisterWorkers(), removeCaches()]).then(markCleaned, function () {
            // Cleanup is best-effort and must never block catalog browsing.
        });
    };

    if (document.readyState === 'complete') {
        cleanup();
    } else {
        window.addEventListener('load', cleanup, { once: true });
    }
}());
