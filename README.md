# Rasamala Theme for SLiMS 9 Bulian

Rasamala adalah template OPAC SLiMS 9 Bulian yang dikembangkan dari default template dengan fokus pada tampilan modern, konfigurasi tema yang lebih lengkap, pengalaman mobile yang lebih rapi, dan pengaturan visual yang bisa dikelola lewat Tinfo.

Tema ini awalnya berevolusi dari `apple-theme`, lalu dirapikan dan diganti menjadi `rasamala`.

## Status

- Target aplikasi: SLiMS 9 Bulian.
- Lokasi tema: `template/rasamala`.
- Basis template: PHP template SLiMS dengan Bootstrap 5.3.3, Vue 3.5.39, markup tema utama yang sudah diarahkan ke Bootstrap 5 native, compatibility layer terbatas untuk output lama SLiMS/plugin, dan JavaScript custom yang diarahkan ke vanilla JS.
- Font Google sudah dilokalkan di `assets/fonts/google/` agar tidak bergantung pada CDN Google Fonts.
- Terakhir didokumentasikan: 2026-07-15.

## Fitur Utama

### Preset Tampilan Tema

Rasamala menyediakan pilihan keseluruhan tema lewat Tinfo:

- Simple - Search + Running Text: beranda sangat sederhana, fokus ke kotak pencarian dan running text bawah.
- Simple + Topics: beranda ringkas dengan search dan daftar topic. Teks section Topics disembunyikan agar tampil minimal.
- Full - Topics + News + Collections + Top Reader + Map + Running Text: semua section utama tampil, termasuk running text, map/contact, popular/new collection, top reader, dan animasi.
- Custom (Fully Unlocked): semua pengaturan detail dibuka.

### Dark/Light Mode

- Toggle dark/light mode di OPAC.
- Tinfo hanya mengatur apakah tombol toggle ditampilkan atau disembunyikan.
- Warna navbar, footer, search result, filter, sort, detail biblio, login/member page, topics, floating button, dropdown, dan modal sudah diarahkan agar mengikuti mode aktif.

### Palette Warna dan Font Tema

- Theme Color Palette menyediakan preset: Warm Gray, Neon Cyan, Neon Emerald, Sunset Orange, Royal Gold, Electric Pink, Minimal White, Dark Gray, Forest Academic, Clean Blue, Warm Library, Mono Minimal, dan Custom Palette.
- Custom Palette memungkinkan pengisian kode warna sendiri untuk Primary, Secondary, Accent Highlight, Page Background, Surface/Card, Main Text, dan Muted Text/Border.
- Dark Gray tetap memakai background terang di light mode. Custom palette yang benar-benar gelap otomatis mendapat guard kontras agar panel legacy, form, dropdown, tabel, filter, search result, member/librarian page, dan elemen plugin tetap terbaca.
- Komponen utama tetap kompatibel dengan `--theme-accent-color`, tetapi sekarang juga memakai token `--theme-primary`, `--theme-secondary`, `--theme-accent`, `--theme-background`, `--theme-surface`, `--theme-text`, dan `--theme-muted` agar tampilan tidak monoton.
- Pilihan font: System Default, Inter, Roboto, Poppins, dan Playfair Display.
- Font eksternal sudah disimpan lokal di folder tema.

### Navbar

- Menu navbar bisa dikonfigurasi dari Tinfo.
- Setiap menu bisa memakai Font Awesome icon.
- Menu default mencakup Home, Information, News, Help, Librarian, dan Staff Area.
- Staff Area diarahkan ke `index.php?p=login`.
- Area Anggota bisa show/hide.
- Subnama perpustakaan bisa show/hide.
- Bahasa yang tampil bisa dibatasi melalui daftar kode bahasa.
- Mobile bottom navigation bisa show/hide. Jika disembunyikan, burger menu tetap tersedia di mobile.

### Hero Search

- Teks judul search bisa diubah.
- Ukuran judul hero bisa dipilih.
- Placeholder search bisa diubah.
- Ukuran search box bisa dipilih.
- Mode beranda sederhana dapat menampilkan navbar dan search bar sebagai fokus utama.
- Search options/Search By dibuka sebagai overlay halus agar tidak menggeser layout.

### Background Animation

Animasi background dapat dipakai di semua halaman, tidak hanya beranda:

- None.
- Floating Glyphs.
- Constellation Lines.
- Code Rain.
- Ambient Waves.
- Moving Grid.
- Floating Bubbles.
- Twinkling Stars.
- Gradient Orbs.

Kecepatan animasi bisa diatur. Efek dibuat ringan dan mengikuti warna aksen tema, dengan penyesuaian dark/light mode.

### Cursor Icon dan Partikel

- Cursor custom dipisahkan di `assets/js/cursor-icons.js`.
- Efek partikel dipisahkan di `assets/js/cursor-particles.js`.
- Mode partikel: Auto, Ringan, Sedang, Optimal, dan Nonaktif.
- Pilihan icon cursor: Default Browser, Neon Comet, Fire Phoenix, Pixel Sword, Galaxy Orb, Electric Bolt, Ink Brush, Cyber Drone, Rainbow Ribbon, Ghost Spirit, dan Crystal Shard.
- Auto mode mendeteksi perangkat agar lebih ringan di perangkat rendah.
- Pada light mode cursor mengikuti warna tema; pada dark mode mempertahankan warna icon bawaan.

### Announcement dan Running Text

- Banner pengumuman bisa show/hide.
- Isi pengumuman mendukung HTML yang disanitasi.
- Gaya announcement: theme adaptive, info, warning, danger, success.
- Running text bisa mengambil data dari latest content, latest bibliography, atau teks kustom.
- Running text mendukung filter news/all content, filter collection type, jumlah item, batas karakter, dan kecepatan.
- Running text bawah tetap menjadi quick setting Tinfo dan dapat diatur pada semua preset tanpa harus memilih Custom.
- Running text bisa tampil sebagai ticker bawah dan tetap ada saat pindah halaman.
- Running text pendek otomatis dibuat bergerak dari sisi kanan ke kiri agar loop tetap rapi pada layar desktop maupun mobile.
- Running text juga tampil di halaman Visitor/Buku Tamu saat fitur Running Text diaktifkan.

### Info di Bawah Search Box

- Info area search dapat ditampilkan atau disembunyikan.
- Info area search tetap menjadi quick setting Tinfo dan dapat diatur pada semua preset tanpa harus memilih Custom.
- Sumber data: latest content, latest bibliography, atau teks kustom.
- Gaya tampilan: badges/pills, fading slideshow, atau horizontal ticker.
- Mendukung batas jumlah item dan batas karakter.

### Latest Content di Beranda

- Beranda bisa menampilkan 3 latest content card.
- Sumber data: news saja, all content, atau custom path.
- Jika tidak ada gambar, tema membuat thumbnail placeholder yang seragam.
- Tampilan mengikuti warna dan spacing tema.

### Topics Beranda

- Section topics bisa show/hide.
- Item topic dikelola dari Tinfo.
- Setiap topic memiliki label, URL, dan Font Awesome icon.
- Pemilih icon di Tinfo dibuat visual agar icon bisa dipilih langsung.
- Judul/subtitle section dapat diatur: title + subtitle + subject, title + subtitle, title + subject, title only, atau hide all.

### Section Beranda

Section beranda dapat dikontrol dan diurutkan:

- Topics.
- News/content cards.
- Popular collections.
- New collections.
- Top reader.
- Map/contact.

Setiap section utama mendukung pengaturan tampilan teks section sesuai opsi Tinfo: title + subtitle + subject, title + subtitle, title + subject, title only, atau hide all.
Jika hanya sedikit section yang tampil, misalnya topic saja, beranda otomatis diseimbangkan ke tengah viewport agar mode minimal tidak terlihat menggantung di atas. Pada desktop, area topic-only dapat memuat hingga 6 topic dalam satu baris bila ruang layar cukup.

### Peta dan Sosial Media

Section peta dan sosial media memiliki opsi:

- Tampilkan peta dan sosial media.
- Sembunyikan peta dan sosial media.
- Sembunyikan peta.
- Sembunyikan sosial media.

Link sosial media yang didukung:

- Facebook.
- Twitter/X.
- YouTube.
- Instagram.
- TikTok.
- WhatsApp.
- Telegram.
- LinkedIn.

### Footer

- Footer bisa show/hide.
- Search form footer bisa show/hide.
- Teks About Us dan Copyright bisa diubah.
- Link `Powered by SLiMS` diarahkan ke `https://slims.web.id/`.
- Footer mengikuti warna navbar dan warna aksen tema.
- Waktu sholat dapat ditampilkan di footer.

### Widget Waktu Sholat

File khusus: `parts/waktu_sholat.php`.

Fitur:

- Mode Footer + Floating Reminder.
- Footer only.
- Floating reminder only.
- Hide.
- Pilihan kota Indonesia.
- Tampilan next prayer ringkas, misalnya `Ashar (Jakarta) 15:20`.
- Reminder floating muncul menjelang waktu sholat dengan countdown sederhana.

Catatan: fitur waktu sholat mengambil data waktu dari layanan eksternal saat tersedia.

### Search Result

- Default view bisa dipilih: Simple, List, atau Grid.
- Simple view dibuat minimalis: judul, pengarang, dan jumlah ketersediaan.
- Label ketersediaan diganti icon dan angka.
- Warna ketersediaan: hijau jika tersedia, merah jika 0.
- Hover/klik angka ketersediaan menampilkan detail item.
- Popover ketersediaan dibuat agar hanya satu muncul pada satu waktu.
- Background panel pencarian bisa bergaya transparent atau solid, mencakup filter, sort, dan card hasil pencarian.
- Pada mobile, modal Filter dan Sort selalu solid walaupun panel pencarian diset transparent agar pilihan tetap mudah dibaca.
- Pagination distandarkan agar lebih sederhana dan mengikuti warna tema.
- Dropdown filter/advanced search disesuaikan dark/light mode.

### Detail Bibliografi

- Field kosong tidak ditampilkan.
- Other version/related dan file attachment tidak tampil jika tidak ada data.
- Bookmark dan Share dipindah ke area atas judul agar lebih bersih.
- Label atas judul bisa memakai GMD atau Collection Type.
- Author role bisa show/hide.
- Judul paralel dapat dipisah berdasarkan karakter tertentu, default `=`.
- Batas karakter judul utama dapat diatur.
- Subject tampil satu baris dan dipisah titik koma.
- Availability dipindah ke bawah cover.
- Availability diringkas menjadi format tersedia/total per lokasi.
- Jika lebih dari satu lokasi, call number menampilkan keterangan lokasi.
- Detail item tetap bisa dilihat melalui popover tanpa membuat halaman terlalu panjang.

### Auto Generate Cover

Auto cover untuk buku/koleksi bisa diatur:

- No cover and missing files.
- No cover only.
- Disable.

Fitur ini diterapkan pada halaman beranda, hasil pencarian, dan detail bibliografi.

### News dan Content

- Tampilan list berita bisa dipilih:
  - Title and Excerpt.
  - Title Only.
  - Title, Excerpt, and Thumbnail.
- Mode title only dibuat lebih compact, tanggal di bawah kiri, dan judul dapat diklik langsung.
- Gambar pada detail content/news dibatasi agar tidak melewati area baca.
- Thumbnail placeholder disediakan jika gambar tidak ada.

### Librarian Page

- Halaman `index.php?p=librarian` dirapikan.
- Jika foto pustakawan tidak ada/hilang, tema membuat avatar inisial.
- Email dan social tidak menampilkan label jika datanya kosong.
- Tinfo dapat memilih pustakawan yang ditampilkan:
  - Semua.
  - Pustakawan + Pustakawan Senior.
  - Pustakawan Senior saja.
  - Custom username.
- Mode custom mendukung override posisi:
  `user1(kepala perpustakaan);user2(bagian informasi)`.

### Visitor Log Page

- Visitor log memakai styling Rasamala.
- Voice visitor log bisa enable/disable.
- Quote/salam visitor bisa enable/disable.
- Judul dan subtitle visitor bisa diatur.
- Toggle dark mode visitor bisa enable/disable.
- Layout visitor: Kiosk Mode atau Split Layout.
- Konten panel kanan Split Layout bisa diatur dari Tinfo: judul dan daftar langkah.
- Format langkah Split Layout: `ikon | judul | deskripsi`, satu langkah per baris. Ikon mendukung Font Awesome, misalnya `fas fa-lock`, atau keyword khusus `scan` untuk animasi pemindai.
- Running text bawah mengikuti pengaturan Running Text utama.

### Floating Buttons

- Back to top button bisa show/hide.
- Floating info button bisa mode Libinfo, WhatsApp, atau hide.
- WhatsApp mode mendukung nomor, judul layanan, jam layanan, deskripsi, dan kategori pesan.
- Floating button mengikuti warna accent dan dark/light mode.

### Custom CSS

Tinfo menyediakan field Custom CSS Tambahan dengan template default. Gunakan ini untuk penyesuaian kecil tanpa mengubah file CSS utama.

## Instalasi

1. Letakkan folder `rasamala` di:

   ```text
   template/rasamala
   ```

2. Aktifkan tema dari konfigurasi SLiMS:

   ```php
   $sysconf['template']['theme'] = 'rasamala';
   ```

3. Buka Tinfo/Pengaturan Tema untuk menyesuaikan preset, warna, navbar, beranda, footer, search result, dan fitur lain.

4. Jika memakai cache browser/opcache, bersihkan cache setelah mengganti file tema.

## Struktur File Penting

```text
rasamala/
├── index_template.inc.php       # entry template OPAC
├── tinfo.inc.php                # definisi pengaturan tema
├── tinfo_helpers.php            # UI helper Tinfo
├── theme_helpers.php            # helper umum tema
├── classic.php                  # loader/helper kompatibilitas klasik
├── biblio_list_template.php     # tampilan hasil pencarian
├── detail_template.php          # tampilan detail bibliografi
├── news_template.php            # tampilan news/content
├── visitor_template.php         # tampilan visitor log
├── parts/
│   ├── header.php
│   ├── footer.php
│   ├── _home.php
│   ├── _navbar.php
│   ├── _search-form.php
│   ├── _result-search.php
│   ├── _other.php
│   ├── _member.php
│   └── waktu_sholat.php
└── assets/
    ├── css/style.css
    ├── js/app.js
    ├── js/app_jquery.js
    ├── js/cursor-icons.js
    ├── js/cursor-particles.js
    ├── fonts/
    └── flags/
```

## Dependency dan Aset Lokal

- Google Fonts sudah disimpan lokal.
- Font Awesome mengikuti aset yang tersedia di instalasi SLiMS/theme.
- Vue 3.5.39 dimuat lokal melalui `assets/js/vue.min.js`.
- JavaScript custom baru diarahkan ke vanilla JS bila memungkinkan.
- Bootstrap 5.3.3 dimuat lokal melalui `assets/css/bootstrap.min.css` dan `assets/js/bootstrap.bundle.min.js`.
- `assets/js/bootstrap_compat.js` dipakai untuk memetakan atribut lama Bootstrap 4 seperti `data-toggle` ke `data-bs-toggle`.
- Beberapa class utility Bootstrap 4 lama masih diberi compatibility CSS agar template/core lama tetap rapi.
- jQuery masih dimuat karena beberapa dependency lama SLiMS/plugin masih membutuhkannya, seperti Colorbox, IonRangeSlider, dan integrasi lama lain.
- Peta menggunakan iframe URL yang diatur di Tinfo.
- Waktu sholat dapat membutuhkan koneksi ke layanan eksternal.

## Catatan Keamanan

- Output teks memakai helper escape/sanitize tema.
- Custom HTML seperti announcement dan footer about diproses melalui sanitasi HTML.
- URL menu/navbar/topic dibatasi melalui helper validasi.
- Perubahan sebaiknya tetap dilakukan di dalam folder tema agar tidak menyentuh core SLiMS.

## Panduan Maintenance

- Setiap update fitur, perubahan perilaku, atau penambahan opsi Tinfo wajib memperbarui README ini.
- Jika perubahan memengaruhi dependency, perbarui juga `dependency_notes.md`.
- Jika perubahan memengaruhi daftar pekerjaan, perbarui `todo.md` atau file catatan terkait.
- Pertahankan perubahan di dalam folder `template/rasamala` kecuali memang ada instruksi eksplisit untuk menyentuh core SLiMS.
- Untuk file PHP, jalankan `php -l` pada file yang diubah.
- Untuk file JavaScript, jalankan `node --check` bila memungkinkan.
- Jalankan `git diff --check` sebelum commit untuk menghindari whitespace error.

## Kredit

- Basis awal template: SLiMS classic/default template.
- Pengembangan Rasamala: Ade Ismail Siregar (adeismailbox@gmail.com).
- SLiMS: https://slims.web.id/
