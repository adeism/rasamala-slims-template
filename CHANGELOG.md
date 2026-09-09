# Changelog — Template Rasamala

Format: entri terbaru di atas. ID temuan merujuk ke `REVIEW-2026-09-08.md`.

## [Belum dirilis] — 2026-09-09

### Keamanan & Performa — batch 2 (2026-09-09)

- **T-01 (final) — script inline core di-defer ke footer.** Mekanisme nonce
  saja diganti `themeDeferInlineScripts()` + `themeFlushDeferredInlineScripts()`
  (`parts/footer.php`): isi script tetap verbatim (scope global & urutan utuh)
  sehingga kode core yang bergantung jQuery kini berjalan setelah pustaka
  dimuat. `themeInjectCspNonceToScripts()` dipertahankan sebagai alias
  kompatibilitas.
- **CSP tahap 1 diperketat.** `https:` generik dihapus dari `script-src` dan
  `connect-src`; pemuatan script pihak ketiga kini hanya lewat allowlist
  eksplisit (`chat`, `maps`, `recaptcha`, dsb.).
- **S-04 — thumbnail tidak lagi double-encode.** `getImagePath()` menghapus
  `urlencode()` awal yang menghasilkan URL `%2520` dan 404.
- **S-05 — `news_template.php` diperkuat.** Guard akses langsung yang
  men-defeat-diri-sendiri diganti `die()` standar; cookie `select_lang` hanya
  diterima bila cocok dengan bahasa yang dikenal; query isi berita di-memo
  per-request (mitigasi N+1).
- **S-06 — jadwal sholat memakai jam kota.** Helper baru
  `rasamalaWaktuSholatNow()` memakai `classic_prayer_times_timezone`
  (default `Asia/Jakarta`); timeout API 1→4 detik; `innerHTML` → `textContent`;
  variabel `$test_mode` mati dihapus.
- **S-08 — baris popover ketersediaan dibatasi 50** (`helpers/detail.php`,
  `biblio_list_template.php`) dengan baris "+N" agar DOM tidak meledak pada
  biblio dengan ribuan eksemplar.
- **S-11/S-12 — status login & bookmark disatukan.** Helper baru
  `themeIsMemberLoggedIn()` (`utility::isMemberLogin()` + fallback sesi) dan
  `themeIsBookmarked()` (toleran dua bentuk sesi bookmark) dipakai di
  navbar, member layout, mobile nav, halaman detail, daftar biblio, dan
  classic; inkonsistensi tombol komentar/bookmark antar-halaman hilang.
- **S-14 — `_search-form.php`.** Variabel ticker diinisialisasi (bebas warning
  PHP 8 bila `$dbs` tak tersedia); gaya pengumuman memakai allowlist kelas
  Bootstrap.
- **S-16 — status sampul di-memo per-request** (`themeCoverState()`,
  cap 500) agar tampilan daftar/grid tidak mengulang Storage API + I/O
  filesystem per item.
- **S-19 — daftar bahasa kosong = tampilkan semua** (fail-open yang
  terdokumentasi) alih-alih menyembunyikan seluruh pemilih bahasa.
- **Performa footer.** `fancywebsocket.js` hanya dimuat saat chat OPAC aktif;
  `service-worker-cleanup.js` berjalan sekali per browser (flag
  `localStorage`) alih-alih tiap pemuatan halaman.
- **Tidak diubah (keputusan sadar).** S-07 (Theme Viewer butuh semua nilai
  TInfo; sudah ter-escape), info perpustakaan floating (satu SELECT baris
  tunggal terindeks — diabaikan, biaya ~0,1 ms), `getImagePath()` tetap
  memanggil `showDetailImage.php` untuk file lokal (di-cache browser 7 hari).

### Keamanan (Security)

- **K-01 — XSS template sitasi diperbaiki.** Seluruh variabel katalog di
  `citation/apa|chicago|mla|turabian_style_template.php` kini di-escape melalui
  helper baru `rasamala_cite_e()` (guard `function_exists`, aman di-include
  bersamaan). Nama direktori tema pada link CSS sitasi juga disanitasi.
- **K-02 — Host-header injection diperbaiki.** `detail_template.php` dan
  `parts/_other.php` tidak lagi memakai `$_SERVER['HTTP_HOST']` mentah untuk
  QR code/tautan bagikan; kini memakai helper baru `themeCurrentHost()`
  (validasi ketat hostname/IPv4/IPv6 + fallback aman) dan skema memakai
  `themeRequestIsHttps()` yang sadar reverse-proxy (juga menutup S-15).
- **T-03 — `themeSanitizeMetadata()` ditulis ulang** memakai allowlist atribut:
  `<meta http-equiv="refresh">` dan URL `javascript:`/`vbscript:`/`data:`
  tanpa quote kini ditolak; hanya relasi `<link>` dokumentasional yang lolos.
- **T-02 — `csrf_token` tidak lagi bocor** ke URL pemilih bahasa di navbar.

### Perbaikan Bug (Fixed)

- **T-01 — `themeInjectCspNonceToScripts()` tidak lagi me-rewrite isi script.**
  Fungsi ini hanya menyuntik atribut `nonce`; pembungkusan `DOMContentLoaded`
  yang merusak deklarasi `const`/`let`/`class` lintas-script telah dihapus.
- **T-04 — `getRandomBiblio()` ditulis ulang** dengan indexed random sampling
  (`WHERE biblio_id >= ? … LIMIT 1` per probe, dedup, bounded attempts):
  biblio tanpa penulis tidak lagi hilang, hasil benar-benar acak, dan tetap
  murah di katalog besar (tanpa `ORDER BY RAND()` penuh).
- **T-05 — Query topik kompatibel MySQL strict.** `getPopularTopic()` dan
  `getLatestTopic()` memakai `GROUP BY mt.topic_id, mt.topic` (sebelumnya
  `GROUP BY bt.topic_id` → error 1055 pada `ONLY_FULL_GROUP_BY`).
- **T-06 — Endpoint suggest memakai duck-typing** (`method_exists($dbs,
  'prepare')`) alih-alih `instanceof mysqli` agar tidak mati diam-diam pada
  rilis SLiMS dengan kelas wrapper DB berbeda.
- **R-01 — Operator bitwise `&` diganti `&&`** pada logika `et al.`
  sitasi APA/MLA.

### Catatan

- Perilaku visual tidak berubah; seluruh perubahan bersifat internal kecuali
  output sitasi yang kini ter-escape (dampak yang diinginkan).
- Lihat `REVIEW-2026-09-08.md` §10 untuk checklist smoke test yang disarankan
  sebelum rilis.
