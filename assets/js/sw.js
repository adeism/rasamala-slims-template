/*
 * Retired worker kept only to clean up registrations from Rasamala releases
 * that registered a worker below assets/js (which could not control OPAC).
 * New installations use /rasamala-sw.js instead.
 */
const LEGACY_CACHE_PREFIX = 'rasamala-opac-';

self.addEventListener('install', function (event) {
    event.waitUntil(self.skipWaiting());
});

self.addEventListener('activate', function (event) {
    event.waitUntil(
        caches.keys().then(function (keys) {
            return Promise.all(keys.map(function (key) {
                return key.indexOf(LEGACY_CACHE_PREFIX) === 0 ? caches.delete(key) : undefined;
            }));
        }).then(function () {
            return self.registration.unregister();
        })
    );
});
