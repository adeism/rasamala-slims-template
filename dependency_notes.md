# Rasamala Dependency Notes

Last modified by: Ade Ismail Siregar (adeismailbox@gmail.com)  
Last modified time: 2026-07-08T10:55:01+07:00

## Keputusan Tahap 7

- Vue lokal yang dibundel theme adalah Vue.js v2.6.11.
- Vue 2 tetap dipakai dengan scope terbatas pada tahap ini. Migrasi ke Vue 3 ditunda karena berisiko menyentuh komponen async yang sudah stabil dan belum ada regression test browser lengkap.
- Custom JavaScript theme diarahkan ke vanilla JS ketika aman. `assets/js/app_jquery.js` sudah dipindah ke DOM API dan `fetch()` untuk handler custom seperti basket, bookmark, modal share, oembed, mobile menu, chat toggle, back-to-top, dan paging cleanup.
- jQuery tetap dimuat karena masih dibutuhkan dependency lama: Bootstrap 4 JS, Colorbox/SLiMS plugin, IonRangeSlider, dan beberapa integrasi hasil pencarian yang masih plugin-based.
- Bridge `window.jQuery` di `assets/js/app_jquery.js` hanya dipertahankan untuk event `shown.bs.collapse` dan `hidden.bs.collapse` dari Bootstrap 4.
- Bootstrap lokal tidak seragam versi: CSS v4.2.1 dan JS v4.6.2. Ini perlu dicatat sebagai kandidat cleanup lanjutan, bukan diganti mendadak pada tahap ini.
- Dependency sample yang sebelumnya tidak dipakai production sudah dibersihkan pada Tahap 4: Tailwind sample, Vegas, sample hero, dan gambar slide lama.

## Arah Berikutnya

- Saat ada regression test browser, pertimbangkan menyamakan Bootstrap CSS/JS ke satu versi.
- Saat komponen Vue disentuh lagi, prioritaskan pengurangan scope atau migrasi kecil ke vanilla JS sebelum menambah framework baru.
- Hindari menambahkan Alpine.js atau dependency frontend baru kecuali ada kebutuhan UI yang jelas dan sulit dicapai dengan vanilla JS.
