# Changelog — Template Rasamala

Format: entri terbaru di atas. ID temuan merujuk ke `REVIEW-2026-09-08.md`.

## [Belum dirilis] — 2026-09-09

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
