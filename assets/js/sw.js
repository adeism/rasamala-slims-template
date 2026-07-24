/*!
 * Service Worker for Rasamala SLiMS PWA
 */
const CACHE_NAME = 'rasamala-opac-v1';
const ASSETS_TO_CACHE = [
    '../css/bootstrap.min.css',
    '../css/foundation.css',
    '../css/opac-pages.css',
    '../css/theme-components.css',
    '../css/theme-dark.css',
    './jquery.min.js',
    './bootstrap.bundle.min.js',
    './vue.min.js',
    './app.js',
    './app_jquery.js',
    '../fonts/google-fonts.css'
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(ASSETS_TO_CACHE).catch(() => {});
        }).then(() => self.skipWaiting())
    );
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((keys) => {
            return Promise.all(
                keys.map((key) => {
                    if (key !== CACHE_NAME) {
                        return caches.delete(key);
                    }
                })
            );
        }).then(() => self.clients.claim())
    );
});

self.addEventListener('fetch', (event) => {
    if (event.request.method !== 'GET') return;

    const url = new URL(event.request.url);

    // Network-first strategy for navigation / HTML / PHP requests
    if (event.request.mode === 'navigate' || url.pathname.endsWith('.php')) {
        event.respondWith(
            fetch(event.request).catch(() => {
                return caches.match(event.request);
            })
        );
    } else {
        // Cache-first strategy for static assets
        event.respondWith(
            caches.match(event.request).then((cachedResponse) => {
                if (cachedResponse) {
                    return cachedResponse;
                }
                return fetch(event.request).then((networkResponse) => {
                    if (networkResponse && networkResponse.status === 200 && networkResponse.type === 'basic') {
                        const responseToCache = networkResponse.clone();
                        caches.open(CACHE_NAME).then((cache) => {
                            cache.put(event.request, responseToCache);
                        });
                    }
                    return networkResponse;
                }).catch(() => {});
            })
        );
    }
});
