<!-- markdownlint-disable MD013 -->

# 🌲 Rasamala Theme for SLiMS 9 Bulian

**Rasamala** adalah templat OPAC modern, cepat, dan kaya fitur untuk **SLiMS 9 Bulian**. Dikembangkan dengan pendekatan *mobile-first*, arsitektur PHP modular yang sangat rapi, serta kontrol kustomisasi visual penuh melalui **Tinfo (Pengaturan Tema)** tanpa menyentuh core SLiMS.

![Preview Rasamala](preview.png)

> **Status dokumentasi:** README ini disinkronkan dengan implementasi Rasamala per 31 Juli 2026. Nilai default dan daftar opsi diambil dari `helpers/tinfo_defaults.php`, `helpers/options/*.php`, dan konfigurasi Theme Viewer.
>
> **Catatan instalasi:** `rasamala-sw.js` bukan bagian dari folder tema. File tersebut harus berada di akar instalasi SLiMS agar service worker memiliki scope OPAC yang benar.

---

## 📑 Daftar Isi

- [⚡ Sorotan Utama Fitur & Performa](#-sorotan-utama-fitur--performa)
- [🎛️ Ringkasan Pengaturan Tema (Tinfo)](#️-ringkasan-pengaturan-tema-tinfo)
- [🔁 Sinkronisasi Theme Viewer dan Tinfo](#-sinkronisasi-theme-viewer-dan-tinfo)
- [🏆 Kampanye "Lomba Desain OPAC Pemustaka"](#-kampanye-lomba-desain-opac-pemustaka)
- [📁 Arsitektur Direktori](#-arsitektur-direktori)
- [🌐 Route OPAC Utama](#-route-opac-utama)
- [📦 Aset Lokal dan Versi Library](#-aset-lokal-dan-versi-library)
- [Keamanan & Aksesibilitas](#keamanan--aksesibilitas)
- [🚀 Cara Instalasi](#-cara-instalasi)
- [Smoke Test](#smoke-test)
- [👥 Kredit & Pengembang](#-kredit--pengembang)

---

## ⚡ Sorotan Utama Fitur & Performa

### 1. 🎨 Desain Visual, Theme Viewer & Mode Gelap

- **Kustomisasi Visual Lengkap (Tinfo):** Atur mode hero fullscreen, skema warna, logo, running text, hingga animasi latar belakang langsung dari admin SLiMS.
- **Dark / Light Mode Pintar:** Otomatis menyesuaikan preferensi OS/browser pengguna atau dikunci pada mode tertentu, lengkap dengan tombol toggle responsif.
- **Interactive Theme Viewer & AI Prompt Helper:** Pemustaka dapat menguji mode hero fullscreen (Yes/No), pilihan konten di dalam hero, section beranda, *Custom Palette*, background, tipografi, dan animasi secara *real-time* melalui menu kuas melayang (`fa-paint-brush`). Theme Viewer menyediakan prompt yang dapat disalin untuk membantu pembuatan palette/background dengan alat AI eksternal; generator AI tidak berjalan di server tema. Kontrol Cursor Icon dan Cursor Particles masih disembunyikan oleh release gate.
- **Simpan dari Theme Viewer (Admin):** Setelah login di area admin, tombol **Simpan Pengaturan Tema** muncul di Theme Viewer. Tombol ini mengirim konfigurasi preview ke form TInfo resmi dengan tetap membawa seluruh field lain, sehingga pengaturan yang tidak sedang dipreview tidak ikut terhapus.
- **Sistem Logo Perpustakaan Bersyarat Admin:** Logo perpustakaan hanya tampil jika admin mengunggah file logo di Pengaturan Sistem Admin SLiMS (`$sysconf['logo_image']`), menjaga kebersihan tampilan jika belum ada logo.

### 2. ⚡ Performa Maksimal & PWA Aman

- **Pemuatan JS Non-Blocking:** Sebagian besar script tema dan library halaman dimuat dengan atribut `defer`, termasuk bundle pencarian, Theme Viewer, animasi, dan PWA register. Script core atau partial tertentu tetap mengikuti kebutuhan kompatibilitas SLiMS, jadi klaim ini bukan berarti setiap tag script di seluruh alur core selalu `defer`.
- **Aset Berdasarkan Halaman:** Vue dan `app.js` hanya untuk halaman dengan form pencarian; Masonry, Ion Slider, highlight, serta `result_search.js` hanya untuk halaman hasil pencarian. CSS CKEditor dan Colorbox tidak lagi dimuat di OPAC publik.
- **Autocomplete JSON Ringan:** Saran judul memakai endpoint JSON kecil (maksimal 6 judul), debounce 250 ms, dan pembatalan request sebelumnya. Browser tidak lagi mengunduh serta mem-parsing halaman hasil pencarian penuh pada setiap input.
- **PWA Static-Assets-Only:** `rasamala-sw.js` berada di akar aplikasi agar scope-nya mencakup OPAC. Worker hanya menyimpan aset tema same-origin berdasarkan destination `style`, `script`, `font`, `image`, dan `manifest`; HTML, hasil pencarian, akun anggota, admin, serta endpoint API selalu memakai jaringan.
- **Default Produksi:** Theme Viewer aktif, hero fullscreen aktif dengan Topics di dalam hero, background default `Aurora Glow`, animasi `Neural Network` berkecepatan `Fast`, homepage tab aktif, dan partikel cursor nonaktif. Admin dapat mengubahnya melalui Tinfo. Release gate tetap memaksa Cursor Icon, Cursor Particles, dan Panel Background ke nilai aman masing-masing.
- **Skeleton Shimmer Loading System:** Animasi shimmer presisi saat memuat data (sampul 1:1.35, avatar, pill topik) dengan indikator top progress bar NProgress-style.

### 3. 📱 Mobile UI/UX & Engine Modal Teratas

- **Mobile Bottom Navigation (5-Tombol):** Bilah navigasi bawah seluler responsif untuk akses cepat ke Beranda, Pencarian, Keranjang, Topik, dan Area Anggota.
- **Mobile Floating Action Pill (Kiri Bawah):** Kapsul aksi melayang (*Bookmark, Keranjang, Sitasi, Bagikan*) yang otomatis di-promosikan ke `document.body` (`z-index: 1045`). Mengambang secara mulus dan stabil di atas footer.
- **Top-Level Modal Hierarchy (`z-index: 100000`):** Penanganan modal teratas untuk Sort, Filter, View Mode, Advanced Search (`#adv-modal`), dan Floating WhatsApp (`#whatsappModal`), menjamin dialog selalu muncul di atas backdrop overlay.

### 4. 🔍 Pencarian Katalog, Detail Buku & Sitasi

- **Full-Width Result Layout & Sticky Action Toolbar:** Tampilan hasil pencarian 100% *full-width* dengan toolbar melayang (*Filter, Sort by 8 pilihan, View Mode Simple/List/Grid*).
- **Status Hasil yang Konsisten:** Empty state menggunakan jumlah hasil mesin pencarian, tombol Advanced Search selalu membuka `#adv-modal`, dan status ketersediaan mengikuti angka item yang tersedia.
- **Generator Kode QR Vektor SVG Offline:** Generator QR Code 100% offline (`BaconQrCode\Writer`) tanpa ketergantungan API pihak ketiga, terintegrasi dengan **Native Mobile Web Share Sheet (`navigator.share`)**.
- **Modul Sitasi Akademis & Keranjang Buku:** Generator sitasi otomatis format **APA, Chicago, MLA, Turabian** pada detail buku, serta keranjang buku permanen (*Shopping Basket*) dengan counter AJAX real-time.
- **Global Keyboard Shortcut (`Ctrl+K` / `⌘K`):** Pintasan keyboard instan untuk memfokuskan pencarian dengan indikator visual `<kbd>`.

### 5. 🪪 Keanggotaan Digital, Buku Tamu & Widget Layanan

- **Kartu Anggota Digital Cerdas:** Mendukung QR Code & Barcode, generator inisial avatar jika foto tidak ada, serta indikator visual **border merah melingkar (`4px solid #dc3545`)** untuk anggota expired.
- **Visitor Log Kiosk & Split Layout:** Form buku tamu mode Kiosk penuh atau Split Layout 2-kolom dengan dukungan format institusi `kode(label)` dan opsi input manual (`other`). Dependensi dimuat berurutan: Vue, Axios, lalu `visitor_counter.js`.
- **Widget Layanan WhatsApp & Waktu Sholat:** Modal obrolan WhatsApp interaktif dengan template pesan otomatis, serta jadwal waktu sholat kota-kota di Indonesia lengkap dengan pop-up reminder azan.

---

## 🎛️ Ringkasan Pengaturan Tema (Tinfo)

Akses menu admin SLiMS: **System > Theme > Customize/Tinfo**.

| Kategori Pengaturan | Opsi Utama | Deskripsi Ringkas |
| --- | --- | --- |
| **Hero Fullscreen** | `Yes - Fullscreen Hero`, `No - Standard Homepage` | Mengatur apakah area pencarian memenuhi layar. Saat ada konten di bawah, indikator panah membantu pemustaka menemukan section berikutnya. Topics, info search, dan section beranda mengikuti pengaturan show/hide masing-masing. |
| **Inside Fullscreen Hero** | `None - Keep Below Search`, `Topics`, `Popular among our collections`, `New collections + updated`, `Top Reader of the Year` | Menentukan satu konten yang dirender di dalam hero saat mode fullscreen aktif. `None` mempertahankan konten di bawah search. Pada homepage standar, konten hero-inside tidak dipasang ulang. |
| **Background Style** | `None / Standard`, `Soft Gradient`, `Aurora Glow`, `Mesh Light`, `Glass Surface`, `Solid Theme`, `Minimal Surface`, `Ocean Waves (Theme Colors)`, `Custom`, serta gambar yang tersedia di `assets/images/backgrounds/` | Pilihan background diterapkan ke seluruh halaman dan tetap terlihat di bawah layer animasi. Untuk gambar tersedia `Normal`, `Crop / Cover`, `Contain`, `Stretch / Fill`, `Tile / Repeat`, `Full Width`, `Full Height`, posisi, filter, blur, dan overlay. Default produksi saat ini `Aurora Glow`; pilih `None / Standard` jika ingin background standar. |
| **Theme Viewer Home Sections** | Topics, Latest Content, Popular Collections, New Collections, Top Reader, Footer | Saat Theme Viewer aktif, section dapat disembunyikan/ditampilkan dan disusun untuk preview. Map/Social Media memiliki kontrol terpisah pada `Map Visibility`; Running Text dan Info Search juga memiliki kontrol khusus. |
| **Home Section Layout** | `Tab Mode`, `Standard Mode` | Memilih satu panel tab aktif agar halaman ringkas, atau menampilkan seluruh section beranda yang diaktifkan secara berurutan. Saat berpindah mode, pane nonaktif tetap disembunyikan sehingga kartu tidak terduplikasi. |
| **Color Palette** | `Warm Gray`, `Minimal White`, `Dark Gray`, `Warm Library`, `Contemporary Tech Library`, `Deep Emerald & Bronze`, `Kraft Paper & Charcoal Ink`, `Midnight Navy & Gold Accent`, `Modern Charcoal & Warm Saffron`, `Royal Indigo & Bright Gold`, `Scandinavian Minimalist`, `High-Contrast Digital`, `Minimal Electric Lime`, `Warm Greige & Metallic Gold`, `Custom` | Pilihan kombinasi warna siap pakai atau custom palette 14-warna. Definisi preset tersentral di `helpers/palettes/theme_color_palettes.php`. |
| **Dark / Light Mode** | `Auto`, `Default Dark`, `Default Light` (with/without toggle) | Pengaturan mode tampilan default dan tombol pengubah mode. |
| **Header & Logo** | `Navbar`, `Hero Box`, Subname, Menu Navigation | Posisi penempatan logo/nama perpustakaan dan struktur navigasi atas. |
| **Hero & Search Box** | Hero Title, Title Size, Placeholder, Search Box Size, Info Search Display, Fullscreen Placement | Seluruh kontrol hero yang berdampak langsung ke OPAC tersedia di Theme Viewer dengan preview real-time; konten Popular/New/Top Reader memakai komponen homepage yang sama agar tidak berbeda saat disimpan. |
| **Animasi & Kursor** | `None`, Floating Glyphs, Code Rain, Moving Grid, Twinkling Stars, Zen Ripples, Neural Network, Starfield Warp, Floating Embers | Animasi background dan kecepatannya tersedia di Theme Viewer/Tinfo. Cursor Icon dan Cursor Particles didefinisikan di kode, tetapi kontrolnya disembunyikan sementara melalui release gate dan dipaksa ke `default`/`none`. |
| **Simpan Theme Viewer** | Khusus sesi admin | Menyimpan palette, hero/search, info area, running text, mobile navbar, back-to-top, background treatment, layout tab, font, animasi, dan visibility section ke pengaturan template aktif. Fitur yang sedang di-release gate tidak ikut ditampilkan/disimpan dari kontrol publik. |
| **All TInfo Settings di Theme Viewer** | General, Navbar, Hero, Content, Footer, Display, Visitor/Guestbook | Theme Viewer memuat metadata langsung dari `helpers/options/*.php`. Field yang belum memiliki preview khusus tersedia di panel **All TInfo Settings** dengan pencarian, dikelompokkan per kategori, dan perubahan langsung diterapkan ke DOM preview tanpa Save. Nilai dikonfirmasi ulang melalui form TInfo agar tidak ada pengaturan yang hilang atau tertimpa. |
| **Pengumuman & Ticker** | Announcement Banner (5 style), Running Text Ticker | Banner pesan penting di atas pencarian dan running text di bagian bawah. |
| **Section Manager** | Show/Hide section, Reorder Sections, Title Format, News Display Mode | Status tampil section dapat diatur dari TInfo atau langsung dipromosikan dari checklist Theme Viewer. |
| **Peta, Medsos & Footer** | Map Embed URL, Social Media Links, Footer Search, About Us Text | Peta/lini media sosial dapat dipreview sebagai kombinasi `Map + Social`, `Map only`, `Social only`, atau disembunyikan dari Theme Viewer; URL dan deskripsi tetap mengikuti TInfo. |
| **Waktu Sholat** | `Footer + Floating Reminder`, `Footer Only`, `Reminder Only`, `Hide` | Jadwal sholat kota-kota Indonesia dan countdown pengingat azan. |
| **Visitor Log** | `Kiosk Mode`, `Split Layout`, Institution List, Panel HTML | Format buku tamu pengunjung dan instruksi pengisian. |
| **Floating Action & WA** | `WhatsApp Mode`, `Libinfo Mode`, `Hide`, Number, Hours, Template | Tombol layanan melayang dan template awal pesan WhatsApp. |

## 🔁 Sinkronisasi Theme Viewer dan Tinfo

- Definisi field admin dan field yang dibaca Theme Viewer berasal dari file yang sama di `helpers/options/*.php`; kategori yang tersedia adalah **General & Layout**, **Navigation Bar**, **Hero & Background**, **Homepage & Content**, **Footer & Social Media**, **Display & Detail Pages**, dan **Visitor / Guestbook**.
- Theme Viewer publik menerapkan perubahan sebagai preview lokal di browser. Perubahan tersebut tidak ditulis ke database secara otomatis.
- Tombol **Simpan Pengaturan Tema** hanya muncul setelah sesi admin terdeteksi. Penyimpanan dilakukan melalui form TInfo resmi agar field lain tetap dibawa dan tidak terhapus.
- `helpers/theme_feature_flags.php` menyaring field yang sedang berada dalam release gate. Saat gate aktif, nilai efektifnya adalah `classic_search_panel_style=solid`, `classic_cursor_custom_icon=default`, dan `classic_cursor_particles=none`.
- Preview yang tersimpan di browser dapat dihapus dengan membersihkan data situs untuk origin OPAC. Nilai database tetap menjadi sumber konfigurasi produksi.

---

## 🏆 Kampanye "Lomba Desain OPAC Pemustaka"

Gunakan fitur **Theme Viewer Floating OPAC** untuk menggelar kompetisi desain tema interaktif:

1. **Aktifkan Theme Viewer:** Set `Floating Theme Color Palette Menu` ke `Show`. Tombol kuas (`fa-paint-brush`) akan muncul di pojok kanan bawah OPAC publik.
2. **Pemustaka Berkreasi:** Pengunjung merancang skema warna kustom, background, tipografi, dan animasi latar yang sedang tersedia secara real-time. Kontrol cursor mengikuti release gate dan tidak dijanjikan sebagai fitur publik.
3. **Mekanisme Lomba:** Pemustaka menyalin kode palette (**Copy Palette**), mengambil screenshot/video, lalu mengunggahnya ke media sosial (Instagram/TikTok/X) dengan men-tag akun perpustakaan.
4. **Terapkan Karya Pemenang:** Admin menyalin *Palette Code* peserta pemenang ke kolom `Custom Palette Colors` di Tinfo Admin.

---

## 📁 Arsitektur Direktori

```text
rasamala/
├── index_template.inc.php       # Router/template utama OPAC publik
├── detail_template.php          # Template halaman detail bibliografi
├── biblio_list_template.php     # Template daftar katalog hasil pencarian
├── news_template.php            # Format halaman berita/informasi
├── visitor_template.php          # Halaman visitor log/kiosk
├── login_template.inc.php       # Wrapper halaman login tertentu
├── classic.php                  # Controller & Bootstrap tema Rasamala
├── tinfo.inc.php                # Entry point pengaturan tema admin
├── theme_helpers.php            # Loader helper bersama
├── helpers/                     # 📂 Helper PHP, opsi Tinfo, preset, security, dan UI
├── parts/                       # 📂 UI Partials (Header, Footer, Navbar, Search, Modals, Detail)
├── citation/                    # 📂 Modul Sitasi (APA, Chicago, MLA, Turabian)
├── assets/                      # 📂 Aset statis lokal (CSS, JS, fonts, images, manifest)
└── docs/                        # 📂 Dokumentasi & Laporan Audit Internal
```

`rasamala-sw.js` berada satu tingkat di atas folder `template/rasamala/`, yaitu di akar instalasi SLiMS. Asset khusus halaman detail berada di `assets/js/detail_page.js`; library visitor lokal yang digunakan adalah Vue, Axios, dan `visitor_counter.js`.

## 🌐 Route OPAC Utama

| Route | Fungsi |
| --- | --- |
| `index.php` | Homepage katalog |
| `index.php?search=search&keywords=...` | Hasil pencarian |
| `index.php?p=show_detail&id=...` | Detail bibliografi |
| `index.php?p=news` | Daftar berita/informasi |
| `index.php?p=librarian` | Daftar pustakawan |
| `index.php?p=visitor` | Visitor log/kiosk |
| `index.php?p=member` | Area anggota |
| `index.php?p=login` | Login staf melalui alur core SLiMS |

Halaman detail tidak memuat navbar/header sendiri; header dan footer disediakan oleh alur template utama. Karena itu, perubahan pada `detail_template.php` sebaiknya tetap dipusatkan pada konten detail dan asset detail.

## 📦 Aset Lokal dan Versi Library

Semua asset tema disimpan lokal dan tidak bergantung pada CDN untuk rendering utama.

| Library/Asset | Versi/Status | Penggunaan |
| --- | --- | --- |
| jQuery | 3.6.4 | Kompatibilitas dan helper UI |
| Vue | 3.5.39 | Koleksi homepage dan visitor UI |
| Axios | 1.19.0 | POST visitor log melalui `visitor_counter.js` |
| Bootstrap | 5.3.3 | Grid, modal, dropdown, dan komponen UI |
| Masonry | 4.2.2 | Layout hasil pencarian |
| `detail_page.js` | Asset tema lokal | Progress bar, availability popover, dan native lightbox |
| `rasamala-sw.js` | Worker root lokal | Cache aset statis tema saja |

Library yang disediakan oleh core SLiMS melalui `JWB` tetap mengikuti versi instalasi SLiMS dan tidak dikelola oleh folder tema.

---

## Keamanan & Aksesibilitas

- **SQL Prepared Statements:** Query yang menerima ID, path, filter tipe koleksi, topic, atau username menggunakan `Prepared Statement` (`$dbs->prepare`) dan menutup statement setelah dipakai. Query yang tersisa dengan `$dbs->query()` hanya berisi konstanta internal tanpa input pengguna.
- **Sanitasi Data & Proteksi XSS:** Output HTML memakai escaping UTF-8, CSS melalui `themeSanitizeCustomCss()`, HTML melalui sanitizer/HTMLPurifier, URL melalui helper allowlist, serta atribut asset core melalui whitelist.
- **Native Lightbox Aman:** Preview gambar memakai DOM API, memvalidasi protocol `http/https` dan ekstensi pada pathname, lalu menetapkan `img.src` sebagai property DOM tanpa merangkai HTML dari `href`.
- **CSP Nonce:** Inline script/style tema memakai nonce per-request. Inline script core yang dilewatkan sanitizer juga diberi nonce; `unsafe-inline`/`unsafe-eval` masih dipertahankan untuk kompatibilitas library core SLiMS yang belum dimigrasikan.
- **PWA Terbatas:** Service worker hanya menerima request `GET` same-origin untuk asset tema yang dapat dicache. HTML, API, pencarian, area anggota, dan admin tidak dicache.
- **Dependency lokal:** Library pihak ketiga disimpan lokal, sehingga tidak ada kebutuhan CDN untuk tampilan utama dan versi dapat diaudit dari header asset.
- **Aksesibilitas WCAG & WAI-ARIA:** Structure semantik HTML5 (`<main>`, `<nav>`, `<footer>`), target sentuh seluler minimum **48x48px** dengan efek touch ripple, atribut `aria-label` & `<label class="visually-hidden">` untuk screen reader, serta atribut `inert` pada modal tertutup.

---

## 🚀 Cara Instalasi

1. Pastikan instalasi Anda menggunakan **SLiMS 9 Bulian** dan PHP yang didukung oleh versi SLiMS tersebut.
2. Salin folder `rasamala` ke direktori templat SLiMS Anda: `/path/to/slims/template/rasamala`
3. Salin `rasamala-sw.js` ke akar instalasi SLiMS agar PWA dapat mengontrol halaman OPAC:

   ```text
   /path/to/slims/
   ├── rasamala-sw.js
   └── template/rasamala/
   ```

   Worker harus dapat diakses dari origin yang sama dengan OPAC, misalnya `https://example.org/slims/rasamala-sw.js`. Jangan menaruhnya hanya di `template/rasamala/assets/js/` karena scope worker akan terlalu sempit.
4. Aktifkan tema melalui admin SLiMS pada menu **System > Theme**, atau set di `sysconfig.inc.php` pada akar instalasi SLiMS:

   ```php
   $sysconf['template']['theme'] = 'rasamala';
   ```

5. Sesuaikan opsi tema melalui menu **System > Theme > Customize/Tinfo**. Theme Viewer aktif secara default, sedangkan kontrol cursor dan panel background sementara mengikuti release gate pada `helpers/theme_feature_flags.php`.
6. Setelah aktivasi atau perubahan worker, lakukan hard refresh OPAC. Jika worker versi lama masih terdaftar, unregister worker lama dari DevTools atau bersihkan data situs, lalu buka ulang OPAC.
7. Uji route homepage, pencarian, detail buku, berita, member, visitor log, Theme Viewer, dan modal peta. Jika dependensi QR `BaconQrCode` tidak tersedia, halaman detail tetap menyediakan fallback link dan tidak gagal render.

## Smoke Test

Jalankan pemeriksaan berikut setelah instalasi, perubahan TInfo, atau pembaruan asset:

1. **Aktivasi admin:** Aktifkan Rasamala dari **System > Theme**. Buka TInfo, simpan satu perubahan, lalu pastikan nilai tersimpan setelah reload.
2. **Homepage standar:** Buka `index.php`. Pastikan navbar hanya muncul sekali, search form dapat digunakan, dan section yang aktif tidak terduplikasi.
3. **Hero fullscreen:** Uji `Topics`, `Popular among our collections`, `New collections + updated`, `Top Reader of the Year`, dan `None - Keep Below Search`. Pastikan hanya satu konten yang muncul di dalam hero.
4. **Background:** Uji `None / Standard`, preset background, `Custom`, dan bila tersedia background gambar. Pastikan background tetap terbaca dalam mode light/dark.
5. **Theme Viewer:** Ubah palette, typography, layout tab, visibility section, running text, dan Map Visibility. Pastikan preview berubah tanpa reload; penyimpanan hanya terjadi melalui tombol admin.
6. **Pencarian dan detail:** Uji autocomplete, hasil `Simple/List/Grid`, filter, detail buku, QR/fallback link, availability popover, citation, bookmark, basket, share, dan native lightbox.
7. **Halaman layanan:** Uji `?p=news`, `?p=librarian`, `?p=visitor` pada layout Kiosk dan Split, `?p=member`, login, WhatsApp/Libinfo, Map/Social, footer, dan mobile bottom navigation.
8. **PWA/cache:** Di DevTools, pastikan worker terdaftar pada scope root instalasi SLiMS. Pastikan hanya asset tema yang dicache; HTML, pencarian, API, member, dan admin tetap terlihat sebagai request jaringan.
9. **Regression keamanan:** Buka console browser dan pastikan tidak ada 404 asset, error parse JSON, error `vegas`, atau error JavaScript. Uji kembali setelah hard refresh atau unregister worker lama.

---

## 👥 Kredit & Pengembang

- **Pengembang Templat Rasamala:** **Ade Ismail Siregar** ([adeismailbox@gmail.com](mailto:adeismailbox@gmail.com))
- **Basis Pengembangan:** SLiMS Default / Classic Template
- **Sistem SLiMS:** Komunitas SLiMS ([https://slims.web.id/](https://slims.web.id/))

---

## Pembaruan UI/UX Terbaru

- **Spinner pencarian stabil:** Submit ganda melalui tombol/Enter dicegah; state spinner di-reset saat halaman dipulihkan dari cache browser, navigasi gagal, atau timeout.
- **Ikon pencarian konsisten:** Spinner dan `fa-search` memakai ukuran, line-height, dan kotak ikon yang sama agar tetap berada di tengah tombol.
- **Sidebar detail terpusat:** `.detail-sidebar-col` beserta cover, heading ketersediaan, lokasi, dan jumlah eksemplar diratakan ke tengah pada desktop maupun seluler.
- **Link konten terbaru homepage:** `.latest-content-link` dipusatkan secara horizontal dan tekstual tanpa mengubah perilaku daftar yang dapat di-scroll.
- **Konten CKEditor ringkas tanpa mengubah core:** Markup core tetap menggunakan `ck-content p-5`; Rasamala menimpanya melalui `.rasamala-theme .ck-content.p-5` di `assets/css/foundation.css` dengan padding setara `p-1`.
- **Footer lebih ringkas:** Jarak luar footer menggunakan `py-1 border-top` agar tidak menyisakan ruang vertikal berlebihan.
- **Ikon bahasa selalu terlihat:** Stylesheet flag dimuat normal dan diberi versi cache agar ikon bendera pada pemilih bahasa tidak hilang ketika lazy-load gagal.
- **Homepage section tabs (opsional):** Tinfo > `Compact Homepage Sections as Tabs` dapat menggabungkan Popular Collections, New Collections, Top Reader, serta Map/Social Media menjadi tab ringkas. Saat aktif, judul/subtitle section dan subject chips di dalam pane disembunyikan agar tidak mengulang label tab; Topics dan Latest Content tetap ditampilkan normal. Tab memakai rail segmented yang ringan, state aktif kontras, navigasi keyboard kiri/kanan, dan klik terdelegasi dari root Vue agar tetap aktif setelah render ulang. Pada mobile, tab ditampilkan sebagai grid 2×2 agar seluruh pilihan terlihat tanpa scroll horizontal.
- **CSP kompatibel:** Inline script/style yang dibuat tema memakai nonce CSP; sanitizer asset core menghapus event handler dan atribut `style` dari tag asset yang diproses. `unsafe-inline` dan `unsafe-eval` masih menjadi kompatibilitas sementara untuk core/library tertentu.
- **Native lightbox detail:** Preview sampul tidak lagi menyisipkan `href` ke string HTML; URL divalidasi dan modal dibangun melalui DOM API di `assets/js/detail_page.js`.
- **PWA worker tervalidasi:** `rasamala-sw.js` menggunakan cache khusus aset statis dan tidak menyimpan respons halaman/API.
- **Dependency visitor diperbarui:** Axios lokal diperbarui ke v1.19.0; API request visitor tetap menggunakan konfigurasi Axios yang kompatibel.
- **API koleksi tahan error:** Jika endpoint koleksi populer mengembalikan HTML akibat instalasi SLiMS lama atau data peminjaman kosong, UI otomatis memakai endpoint koleksi terbaru tanpa error parsing JSON.

### Release gate sementara

Sebelum publish, fitur berikut disembunyikan dari **Theme Viewer** dan **System > Theme > Customize/Tinfo**:

| Fitur | Flag | Default saat gate aktif |
| --- | --- | --- |
| Panel Background (Transparent/Solid) | `panel_background` | `solid` |
| Cursor Icon | `cursor_icon` | `default` (browser) |
| Cursor Particles | `cursor_particles` | `none` |

Implementasi renderer, option definition, dan nilai database tetap dipertahankan. `helpers/theme_feature_flags.php` menyaring kontrol dan memaksa default aman agar konfigurasi lama atau draft `localStorage` tidak mengaktifkan fitur yang belum siap. Tidak diperlukan migrasi database.

Saat fitur sudah stabil:

1. Ubah flag terkait menjadi `true` pada `helpers/theme_feature_flags.php`.
2. Deploy file PHP/JavaScript terbaru.
3. Bersihkan cache aset dan browser, lalu uji Theme Viewer serta TInfo admin.

### Snapshot default produksi

Default instalasi baru sekarang mengikuti konfigurasi OPAC yang sedang dipakai: **Midnight Navy & Gold**, Theme Viewer aktif, mode fullscreen hero dengan Topics di dalam hero, background `Aurora Glow`, animasi `Neural Network` berkecepatan cepat, mode tab homepage, pencarian ukuran kecil dengan placeholder `silakan cari disini`, dan tombol floating `Libinfo`. Pilihan `None / Standard` tetap tersedia, tetapi bukan default produksi saat ini. Entri uji sementara dari Theme Viewer tidak dipromosikan ke default.
