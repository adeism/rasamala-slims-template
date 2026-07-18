# Rasamala Theme for SLiMS 9 Bulian

Rasamala adalah template OPAC SLiMS 9 Bulian yang dikembangkan dari default template dengan fokus pada tampilan modern, konfigurasi tema yang lebih lengkap, pengalaman mobile yang lebih rapi, dan pengaturan visual yang bisa dikelola lewat Tinfo.

Tema ini awalnya berevolusi dari `apple-theme`, lalu dirapikan dan diganti menjadi `rasamala`.

## Status

- Target aplikasi: SLiMS 9 Bulian.
- Lokasi tema: `template/rasamala`.
- Basis template: PHP template SLiMS dengan Bootstrap 5.3.3, Vue 3.5.39, markup tema utama yang sudah diarahkan ke Bootstrap 5 native, compatibility layer terbatas untuk output lama SLiMS/plugin, dan JavaScript custom yang diarahkan ke vanilla JS.
- Font Google sudah dilokalkan di `assets/fonts/google/` agar tidak bergantung pada CDN Google Fonts.
- Terakhir didokumentasikan: 2026-07-16.

## Fitur Utama

### Preset Tampilan Tema

Rasamala menyediakan pilihan keseluruhan tema lewat Tinfo:

- Simple - Search + Running Text: beranda sangat sederhana, fokus ke kotak pencarian dan running text bawah.
- Simple + Topics: beranda ringkas dengan search dan daftar topic. Teks section Topics disembunyikan agar tampil minimal.
- Full - Topics + News + Collections + Top Reader + Map + Running Text: semua section utama tampil, termasuk running text, map/contact, popular/new collection, top reader, dan animasi.
- Custom (Fully Unlocked): semua pengaturan detail dibuka.

### Dark/Light Mode

- Tinfo menyediakan enam mode: `auto - button show`, `auto - button hide`, `default dark - button show`, `default dark - button hide`, `default light - button show`, dan `default light - button hide`.
- Auto mengikuti dark/light mode sistem perangkat. Jika tombol ditampilkan dan user menekan toggle, pilihan user disimpan di browser tersebut. Jika tombol disembunyikan, mode mengikuti setting Tinfo dan mengabaikan pilihan lama di browser.
- Warna navbar, footer, search result, filter, sort, detail biblio, login/member page, topics, floating button, dropdown, dan modal sudah diarahkan agar mengikuti mode aktif.

### Aksesibilitas dan Semantik

- Dokumen mengisi atribut `lang` berdasarkan bahasa aktif/default SLiMS.
- Konten utama dibungkus dengan landmark `<main>`.
- Heading beranda disusun lebih berurutan dari hero ke section.
- Logo dekoratif, icon, ticker duplikat, dan thumbnail yang sudah punya judul teks dibuat lebih ramah screen reader.
- Iframe peta memiliki `title`.
- Link icon-only seperti social media, basket, search, dan expand detail diberi nama yang dapat dikenali.
- Modal tertutup dan ticker duplikat memakai `inert` untuk mencegah fokus tersembunyi saat audit aksesibilitas.
- Link tekstual di konten/footer diberi underline halus agar tidak bergantung hanya pada warna.

### Palette Warna dan Font Tema

- Field Floating Theme Color Palette Menu di Tinfo diganti menjadi Theme Viewer: panel preview visual untuk palette, font, animasi background, speed animasi, efek partikel cursor, ikon cursor, pilihan floating viewer OPAC, dan tombol buka/tutup semua section pengaturan.
- Setiap heading section Tinfo dapat dibuka/tutup agar pengaturan panjang lebih mudah dipantau tanpa mengubah nilai fitur OPAC.
- Theme Color Palette menyediakan preset: Warm Gray, Neon Cyan, Neon Emerald, Sunset Orange, Royal Gold, Electric Pink, Minimal White, Dark Gray, Forest Academic, Clean Blue, Warm Library, Mono Minimal, dan Custom Palette.
- Custom Palette memakai satu field dengan format `light palette | dark palette`. Setiap sisi memakai urutan `Primary; Secondary; Accent; Background; Surface; Text; Muted`. Contoh: `#0B4F54; #5C8374; #F2994A; #F4F6F8; #FFFFFF; #1C1E21; #B0B7BD | #1A2E40; #B38F4D; #D9534F; #101318; #161A22; #F4F6F8; #B6BEC8`.
- Theme Viewer di Tinfo bisa mengaktifkan floating menu OPAC di sebelah tombol Libinfo/WhatsApp. Tombol memakai Font Awesome lokal (`fa-paint-brush`) yang tersedia di tema. Pengunjung dapat memilih preset atau mengisi custom palette dengan format yang sama; pilihan ini tersimpan lokal di browser pengunjung dan tidak mengubah default global admin.
- Popup Theme Viewer OPAC menyediakan tombol Copy Prompt untuk membuat palette dengan AI, tombol Paste Palette untuk memasukkan hasil palette dari clipboard, tombol Dark/Light, pilihan Font Tema, Animasi Background, Kecepatan Animasi Background, Efek Partikel Cursor, Ikon Cursor, serta preview show/hide section beranda per browser.
- Jika Theme Viewer disembunyikan dari Tinfo, override palet di `localStorage` dihapus dan OPAC dipaksa mengikuti pengaturan tema admin.
- Input custom palette di OPAC dibatasi dan dikanonisasi: hanya kode hex 6 digit yang dipakai, maksimal 7 warna untuk light dan 7 warna untuk dark, sedangkan teks/HTML/CSS lain diabaikan sebelum disimpan ke browser.
- Dark Gray tetap memakai background terang di light mode. Custom palette yang benar-benar gelap otomatis mendapat guard kontras agar panel legacy, form, dropdown, tabel, filter, search result, member/librarian page, dan elemen plugin tetap terbaca.
- Token kontras otomatis tersedia sebagai `--theme-on-primary`, `--theme-on-secondary`, dan `--theme-on-accent` agar navbar, footer, tombol, filter aktif, dan komponen di atas warna utama tetap terbaca saat admin memakai warna terang seperti kuning/putih.
- Topic icon, animasi background, dan reminder waktu sholat memakai Accent asli, bukan Primary, sehingga palette dengan navbar/footer putih tetap menampilkan icon dan highlight yang terlihat.
- Guard dark mode di CSS memakai `Background`, `Surface`, `Text`, `Muted`, dan token `on-*` supaya custom palette ekstrem tetap terbaca.
- Komponen utama tetap kompatibel dengan `--theme-accent-color`, tetapi sekarang juga memakai token `--theme-primary`, `--theme-secondary`, `--theme-accent`, `--theme-background`, `--theme-surface`, `--theme-text`, dan `--theme-muted` agar tampilan tidak monoton.
- Pilihan font: System Default, Inter, Roboto, Poppins, dan Playfair Display.
- Font eksternal sudah disimpan lokal di folder tema.

Prompt aman untuk membuat Custom Palette dengan AI:

```text
Buat 1 custom palette OPAC perpustakaan dalam format persis berikut:
Primary; Secondary; Accent; Background; Surface; Text; Muted | Dark Primary; Dark Secondary; Dark Accent; Dark Background; Dark Surface; Dark Text; Dark Muted

Aturan:
- Output hanya 1 baris kode warna hex 6 digit, tanpa penjelasan, tanpa bullet, tanpa nama variabel.
- Gunakan tanda titik koma dan spasi antar warna: #000000; #111111; ...
- Gunakan tanda | untuk memisahkan light palette dan dark palette.
- Text wajib kontras minimal 4.5:1 terhadap Background dan Surface pada mode yang sama.
- Dark Text wajib terang jika Dark Background/Dark Surface gelap.
- Light Text wajib gelap jika Light Background/Light Surface terang.
- Primary dipakai untuk navbar/tombol utama, jadi pastikan cocok dengan warna teks otomatis di atasnya.
- Accent hanya untuk highlight, jangan jadikan semua teks utama mengikuti Accent.
- Muted untuk teks sekunder dan border, tetap harus terbaca.

Tema visual yang diminta: [isi konsep warna di sini, misal: modern academic green, minimal white, cyber neon, royal archive].
```

Contoh output AI yang benar dan bisa langsung ditempel ke `Custom Palette Colors`:

```text
#2F5D50; #8C6A3F; #D5A021; #F6F4EE; #FFFFFF; #1F2A24; #68746D | #5C8374; #C6A15B; #E7C66C; #07110E; #12231E; #F5F3EA; #9FB0A8
```

### Navbar

- Menu navbar bisa dikonfigurasi dari Tinfo.
- Setiap menu bisa memakai Font Awesome icon.
- Menu default mencakup Home, Information, News, Help, Librarian, dan Staff Area.
- Staff Area diarahkan ke `index.php?p=login`.
- Area Anggota bisa show/hide.
- Logo dan nama perpustakaan bisa ditempatkan di navbar atau dipindahkan ke atas search box dalam satu baris untuk desktop. Di mobile, logo dan nama tetap kembali ke navbar agar header tetap jelas. Jika dipindahkan ke hero, menu navbar desktop otomatis berada di tengah.
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
- Zen Ripples.
- Neural Network.
- Starfield Warp.
- Floating Embers.

Kecepatan animasi bisa diatur. Efek dibuat ringan dan mengikuti warna aksen tema, dengan penyesuaian dark/light mode. Animasi baru dibuat dengan elemen DOM ringan dan jumlah elemen otomatis dikurangi di mobile/perangkat rendah. Jika Floating Theme Color Palette Menu mengubah palette dari OPAC, animasi digambar ulang agar langsung mengikuti warna tema aktif.

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
- Running text/ticker memakai warna area yang sama dengan navbar dan footer agar konsisten di light/dark mode maupun custom palette.
- Waktu sholat dapat ditampilkan di footer.
- Komponen non-footer seperti chat, mobile bottom nav, running text bawah, floating info, WhatsApp, dark/light toggle, dan back to top dipisah ke file part khusus.
- Menu floating palet warna dipisah ke `parts/palette_switcher.php`.

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

Fitur ini diterapkan pada halaman beranda, hasil pencarian, dan detail bibliografi. Warna cover otomatis mengikuti theme color palette, termasuk palette yang dipilih dari Floating Theme Color Palette Menu.

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
- Floating palette button tampil di sebelah tombol Libinfo/WhatsApp; jika tombol info disembunyikan, palette kembali ke posisi tombol floating utama.

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
│   ├── bottom_info_bar.php
│   ├── chat_widget.php
│   ├── floating_actions.php
│   ├── mobile_bottom_nav.php
│   ├── palette_switcher.php
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
