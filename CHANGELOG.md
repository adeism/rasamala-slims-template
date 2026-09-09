# Changelog — Template Rasamala

Format: entri terbaru di atas. ID temuan merujuk ke `REVIEW-2026-09-08.md`.

## [Belum dirilis] — 2026-09-09

### Audit ulang & batch 3 (2026-09-09)

- **K-02 (sisa) — `header.php` memakai host tervalidasi.** `og:url` sebelumnya
  memakai `$_SERVER['HTTP_HOST']` mentah; kini `themeCurrentHost()`.
  Perbandingan host referer di `themeDetailHasSearchContext()` juga memakai
  host tervalidasi.
- **R-12 — URL OG/Twitter absolut.** Skema sadar-proxy via
  `themeRequestIsHttps()` + host tervalidasi (scraper menolak `//host...`).
- **Defer diperkuat.** `themeDeferInlineScripts()` kini melindungi komentar
  HTML (`<!--...-->`) agar `<script>` yang dikomentari tidak aktif kembali
  di footer; gagal regex mengembalikan input dengan aman.
- **R-04 (lengkap) — engine chat di-gate.** Include `chat.php` core kini
  memakai kondisi yang sama dengan `fancywebsocket.js` kondisional agar
  tidak ada `ReferenceError` saat chat nonaktif.
- **S-02 — penulis hyphenated aman.** Pemisah string penulis hanya pada
  hyphen ber-spasi (`preg_split('/\s+-\s+/')`); "Jean-Paul Sartre" tidak
  lagi pecah.
- **S-03 — potong teks multibyte-safe.** `themeExcerpt()`, `addEllipsis()`,
  dan atribut sitasi memakai `mb_*` dengan fallback (pola guard sama
  seperti `themeLimitTitleText()`).
- **S-18 — cek Storage defensif.** `themeHeaderFavicon()` dan
  `themeLibraryLogoHtml()` memakai `method_exists()` + `try/catch`
  (selaras `ui_cover.php`).
- **S-20 — `stripslashes()` dihapus dari jalur judul/label**
  (`ui_text`, `header`, `_other`, `navigation`); yang di `news_template`
  (konten DB, konvensi core) dipertahankan.
- **R-13 — breadcrumb news prefix-match** (tidak lagi menangkap `mynews`).
- **R-19 — `$_SERVER['PHP_SELF']` diganti** `SWB . 'index.php'` tetap.
- **S-01 — keterbatasan priming didokumentasikan** jujur di kode.
- **R-02 — README mendapat "Kebutuhan Sistem"** (SLiMS ≥ 9.6, PHP ≥ 8.1).
- **R-16 — diputuskan: `docs/` tetap tracked** (dihapus dari `.gitignore`).
- **Diverifikasi aman tanpa perubahan:** flush footer tercakup semua halaman
  (jQuery sinkron; satu-satunya `exit` dini = endpoint JSON suggest);
  `login_template` memuat `classic.php` sebelum header; CSP baru aman
  (tak ada script/fetch eksternal; QR fallback = `<img>`, tercakup
  `img-src https:`); R-18 sudah ter-guard (`if ($coll_q)`).
- **Sengaja ditunda:** R-03 (defer jQuery — risiko dependensi inline),
  R-06/R-07 (aset repo), R-08 (FOUC dark), R-10/R-11 (i18n/a11y minor),
  R-15 (redirect), S-06(d) (cache temp global — di luar model ancaman),
  R-17 (PWA), R-20 (upgrade lib — per rilis), R-21 (butuh audit visual),
  R-23, S-09/S-10/S-13 (dokumen/kosmetik).

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
