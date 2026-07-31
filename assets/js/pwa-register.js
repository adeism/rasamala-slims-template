/* Register the root-scoped, static-assets-only Rasamala service worker. */
(function () {
    'use strict';

    if (!('serviceWorker' in navigator) || window.location.protocol === 'file:') return;

    const register = function () {
        const scopeUrl = new URL('./', window.location.href);
        const workerUrl = new URL('rasamala-sw.js', scopeUrl);
        const legacyScope = new URL('template/rasamala/assets/js/', scopeUrl).href;

        navigator.serviceWorker.register(workerUrl.href, { scope: scopeUrl.pathname }).catch(function () {
            // PWA support is progressive enhancement; catalog browsing must stay unaffected.
        });

        navigator.serviceWorker.getRegistrations().then(function (registrations) {
            registrations.forEach(function (registration) {
                if (registration.scope === legacyScope) registration.unregister();
            });
        }).catch(function () {});
    };

    if (document.readyState === 'complete') {
        register();
    } else {
        window.addEventListener('load', register, { once: true });
    }
}());
