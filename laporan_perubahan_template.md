# Laporan Perubahan Template MPKP SLiMS 9

Laporan ini menyajikan daftar lengkap file template yang diubah dan fitur-fitur baru yang telah diimplementasikan sejak awal sesi chat untuk menyempurnakan tampilan, navigasi, dan filter pencarian secara konsisten baik pada **Mobile View** maupun **Desktop View**.

---

## Daftar File yang Diubah

Seluruh perubahan difokuskan pada folder template MPKP:
`mpkp/template/default/`

Berikut adalah daftar file yang telah dimodifikasi:

1. **[`mpkp/template/default/tinfo.inc.php`](file:///var/www/html/slims/s951dev/mpkp/template/default/tinfo.inc.php)**
   - Mengembalikan fungsionalitas Vegas slideshow background dengan dukungan pengaturan dinamis (diaktifkan secara default).
   - Mendefinisikan konfigurasi bawaan `$sysconf['template']['classic_library_disableslide'] = 0;`, `$sysconf['template']['classic_footer_show'] = 1;`, `$sysconf['template']['classic_topic_show'] = 1;`, `$sysconf['template']['classic_search_size'] = 'medium';`, `$sysconf['template']['classic_homepage_only_hero'] = 0;`, `$sysconf['template']['classic_hero_text_size'] = 'small';`, `$sysconf['template']['classic_back_to_top'] = 1;`, `$sysconf['template']['classic_floating_info'] = 1;`, dan `$sysconf['template']['classic_navbar_menu']` (Daftar Menu).
   - Menambahkan pengaturan baru **"Show/Hide Slideshow"**, **"Show/Hide Footer"**, **"Show/Hide Topic List"** (Pilih Subjek), **"Search Box Size"** (Ukuran Kotak Pencarian), **"Only Navbar & Hero Searchbar on Homepage"** (Homepage Minimal), **"Hero Text Size"** (Ukuran Judul Hero), **"Back to Top Button"** (Tombol Kembali ke Atas), **"Floating Info Button"** (Tombol Informasi Mengambang), dan **"Navbar Menus"** (Konfigurasi Menu Link Navigasi) ke halaman kustomisasi tema di admin SLiMS.
2. **[`mpkp/template/default/parts/_home.php`](file:///var/www/html/slims/s951dev/mpkp/template/default/parts/_home.php)**
   - Mengatur ulang tinggi dan spasi vertikal agar area di antara navbar dan search box lebih rapat dan padat setelah slideshow dihilangkan.
   - Membungkus kontainer bagian "Pilih subjek yang menarik bagi Anda" (`<section class="mt-5 container">`) dengan kondisional PHP agar merespons konfigurasi toggle dari admin SLiMS.
   - Membungkus seluruh container bagian bawah beranda (`#slims-home`) dengan kondisional PHP checking for `!($sysconf['template']['classic_homepage_only_hero'] ?? 0)` untuk menyembunyikan semua elemen di bawah search box jika opsi beranda minimal diaktifkan.
   - Mengubah struktur hero section menjadi layout flexbox (`d-flex flex-column justify-content-center`) setinggi satu layar penuh (`min-height: 100vh`) dengan warna background gelap senada dengan gradasi warna navbar, serta memposisikan kotak pencarian tepat di tengah vertikal dan horizontal layar saat opsi beranda minimal diaktifkan.
   - Menambahkan container latar belakang (`#hero-particle-container`) beserta animasi CSS dan engine JavaScript partikel melayang (huruf dan angka berterbangan dengan aneka warna neon pastel dan efek text-shadow glow) di latar belakang hero section.
   - Meningkatkan `z-index` header dari `2` menjadi `10` ketika opsi beranda minimal diaktifkan agar navbar tidak tertutup oleh tumpang tindih container form pencarian yang memiliki layout flex/margin, sehingga tautan/menu navigasi tetap dapat diklik dengan normal.
   - Membaca opsi ukuran font judul hero (`classic_hero_text_size`) dan menerapkan kalkulasi font dinamis menggunakan `clamp()` responsif untuk mobile dan desktop agar mencegah teks meluap di HP.
3. **[`mpkp/template/default/parts/_search-form.php`](file:///var/www/html/slims/s951dev/mpkp/template/default/parts/_search-form.php)**
   - Menambahkan perhitungan ukuran kotak pencarian dinamis (lebar kolom col-lg, padding dalam, serta ukuran font kolom input & ikon) berdasarkan opsi **Search Box Size** yang disetel di admin.
   - Mengintegrasikan icon pencarian spesifik (Advanced Search - `fas fa-sliders-h`) langsung ke dalam kotak input pencarian, di sebelah ikon kaca pembesar.
   - Menghapus tombol teks link eksternal "Pencarian Spesifik" yang sebelumnya berada di bawah form pencarian.
   - Menghilangkan margin-top negatif (`mt-0`) pada wrapper search box ketika opsi beranda minimal aktif agar vertical centering kotak pencarian di tengah layar tidak tergeser.
   - Menambahkan positioning `position-relative` and stack level `z-index: 2` pada wrapper search box agar form input pencarian tetap interaktif dan selalu berada di atas layer partikel melayang.
4. **[`mpkp/template/default/assets/js/app.js`](file:///var/www/html/slims/s951dev/mpkp/template/default/assets/js/app.js)**
   - Mengatur fitur *autofocus* pada kolom input pencarian saat halaman dimuat.
   - Mencegah pop-up panduan otomatis muncul sebelum kolom input benar-benar diklik/difokuskan oleh pengguna secara manual.
5. **[`mpkp/template/default/parts/footer.php`](file:///var/www/html/slims/s951dev/mpkp/template/default/parts/footer.php)**
   - Menambahkan bilah navigasi bawah (**Mobile Bottom Navigation Bar**) yang *thumbs-friendly* (Beranda, Info, Berita, Member, Staff) khusus untuk viewport mobile.
   - Membungkus blok kontainer utama `<footer>` dengan kondisional PHP untuk mendukung pengaturan show/hide dari halaman admin SLiMS.
   - Menambahkan aturan kondisional untuk menyembunyikan footer di halaman beranda ketika opsi beranda minimal diaktifkan, namun tetap menampilkan bottom nav bar mobile untuk kemudahan navigasi perangkat genggam.
   - Menambahkan **Floating Info Button** database-backed yang mengambil konten `libinfo` dari tabel `content` untuk dimuat dalam popup modal glassmorphic.
   - Menambahkan tombol **Back to Top** yang terintegrasi dengan tombol Info, meluncur (spring-out) ke atas dari belakang tombol Info saat scroll di atas 300px agar tidak tumpang tindih.
6. **[`mpkp/template/default/parts/_result-search.php`](file:///var/www/html/slims/s951dev/mpkp/template/default/parts/_result-search.php)**
   - Menyembunyikan menu pilihan Sort by bawaan desktop pada mobile agar tidak duplikat dengan tombol modal.
   - Mengubah select dropdown Sort by bawaan pada desktop menjadi bersembunyi (`d-none`), lalu menyediakan kontainer `#desktop-sort-chips` untuk diisi deretan chip horizontal.
   - Menambahkan Javascript untuk membaca pilihan sortir secara dinamis dan menampilkannya sebagai chip interaktif ("Paling Relevan", "Judul", dll.) baik untuk desktop maupun mobile.
   - Menyediakan kontainer pembungkus `#desktop-filter-container` di sidebar desktop.
   - Mengimplementasikan fungsi responsif `adjustFilterPosition()` yang memindahkan form filter secara otomatis ke kontainer laci mobile (`#mobile-filter-container`) saat layar menyusut ($\le 768$px) dan mengembalikannya ke desktop sidebar (`#desktop-filter-container`) saat layar melebar ($> 768$px) secara real-time pada event *resize* jendela peramban.
   - Menambahkan tombol "Atur Ulang" (Reset) dan "Terapkan" (Apply Filter) secara berdampingan di bagian footer modal filter mobile.
   - Menambahkan fungsi Javascript untuk meriset/mengosongkan pilihan filter (checkbox/radio) dan mengembalikan range slider tahun penerbitan ke batas minimum & maksimum secara instan.
   - Menata ulang header hasil pencarian: memisahkan jumlah hasil pencarian & tombol rubah view (List/Grid) pada baris atas, serta memindahkan menu Sort by & chips ke baris khusus di bawahnya agar tampilan rapi dan tidak tumpang tindih saat chip baris baru terbungkus (wrapped).
7. **[`mpkp/template/default/assets/css/style.css`](file:///var/www/html/slims/s951dev/mpkp/template/default/assets/css/style.css)**
   - Menambahkan gaya untuk bilah navigasi bawah mobile.
   - Menghapus gambar latar belakang kaca pembesar bawaan SLiMS di search box agar tidak terjadi duplikasi ikon.
   - Mengubah modal filter mobile menjadi **fullscreen** penuh (lebar 100% tanpa border-radius).
   - Mendesain ulang elemen checkbox/radio filter bawaan menjadi **chip/tag modern ala Shopee/Tokopedia secara global** yang mengalir secara horizontal (*inline-block*) dengan warna latar belakang biru muda saat aktif.
   - Menambahkan gaya chip khusus untuk tombol sortir desktop (`.sort-chip`) agar senada dengan filter.
   - Mengamankan tampilan range slider tahun penerbitan agar tidak berantakan dengan membatasi ruang lingkup pembungkusan tag chip.
   - Mengatur agar opsi tambahan yang muncul ketika klik "Lihat Lebih Banyak" dapat mengalir menyatu dengan tag chip di atasnya secara rapi, serta menyembunyikan tautan "Lihat Lebih Banyak" itu sendiri secara otomatis ketika statusnya sudah terbuka (*expanded*).
   - Menyembunyikan tombol kirim/submit filter bawaan SLiMS yang terduplikasi di dalam form filter.
   - Mengatur standardisasi skala font di mobile view untuk hasil pencarian dan modal filter demi tercapainya konsistensi visual terbaik.
   - Menghapus `!important` pada aturan `font-size` untuk `.header-caption h2` di query mobile agar ukuran judul hero dinamis (`clamp`) dapat dirender di HP.
   - Menambahkan style transisi jin keluar teko (`Genie Modal Transition`) untuk `#libinfoModal` yang bersumber dari bottom-right button.
   - Menambahkan style visual untuk tombol mengambang info dan back-to-top serta animasi `wiggleBounce`.
   - Mengimplementasikan Flexbox sticky footer (`min-height: 100vh` pada body dan `margin-top: auto` pada footer) untuk menjaga posisi footer tetap berada di bagian paling bawah layar jika tinggi konten halaman relatif sedikit (misal: halaman kosong/hasil pencarian nihil).
8. **[`mpkp/api/v1/controllers/BiblioController.php`](file:///var/www/html/slims/s951dev/mpkp/api/v1/controllers/BiblioController.php)**
   - Mengubah method `getLatest()` agar dinamis membaca konfigurasi jumlah tampilan koleksi baru dari database settings (`classic_new_collection_item`).
   - Memperbaiki method `getPopular()` agar dinamis membaca konfigurasi jumlah tampilan koleksi populer (`classic_popular_collection_item`).
   - Mengubah string nama cache `biblio_popular` menjadi dinamis berdasarkan jumlah limit (misal: `biblio_popular_8`) agar perubahan limit pada pengaturan instan ter-render tanpa tertahan oleh cache lama.
   - Menambahkan handling pengaman SQL query ketika array hasil koleksi terpopuler kosong untuk menghindari error syntax database (empty NOT IN list).
9. **[`mpkp/template/default/parts/_navbar.php`](file:///var/www/html/slims/s951dev/mpkp/template/default/parts/_navbar.php)**
   - Menambahkan logic pendefinisian `$is_hero_only` di bagian atas serta style override `background: transparent !important;` pada header dan navbar ketika opsi beranda minimal aktif agar transparan 100% tanpa bayangan atau gradient yang menghalangi latar belakang.
   - Mengganti array `$main_menus` statis dengan parser dinamis yang memecah konfigurasi menu `classic_navbar_menu` dari pengaturan admin. Parser mendukung pemisah semicolon `;`, baris baru `\n`, serta fallback pemisahan otomatis berbasis spasi (`[Label] | [URL] [Label] | [URL]`) jika sistem SLiMS menghapus karakter baris baru saat disimpan.
   - Mengubah struktur data dari array asosiatif menjadi array sekuensial terindeks guna mencegah duplikasi target URL (seperti `Librarian | index.php?p=librarian` dan `Halo | index.php?p=librarian`) saling menimpa satu sama lain, sehingga seluruh tautan yang dikonfigurasi tetap tampil secara utuh.
   - Mengintegrasikan fungsi penerjemah bawaan SLiMS `__()` pada parser menu teks agar menu default tetap terjemahkan secara dinamis ketika bahasa OPAC diganti.
   - Menambahkan logic ekstraksi parameter query halaman `p` pada url menu guna memastikan menu kustom yang dikonfigurasi tetap mendapatkan styling sorotan tab aktif (`active`) ketika diakses.
   - Mengimplementasikan penyaringan XSS dengan enkoding entitas HTML (`htmlspecialchars`) pada teks dan tautan menu, serta pencegahan injeksi protokol berbahaya (seperti `javascript:`).

---

## Ringkasan Perubahan Berdasarkan Fitur

### A. Tampilan Form Pencarian & Autofokus
- Ikon spesifik filter diletakkan manis di dalam search box sebelah kanan.
- Kolom pencarian langsung fokus begitu halaman dibuka tanpa memunculkan dropdown panduan secara otomatis (pop-up hanya muncul saat diklik).

### B. Mobile Navigation (Thumbs-Friendly)
- Menu navigasi utama dipindahkan ke bagian paling bawah layar agar mudah dijangkau oleh jempol pengguna saat memegang HP dengan satu tangan.

### C. Konsistensi Tampilan Filter & Sort (Desktop & Mobile)
- **Responsive Layout Switcher (Perbaikan)**: Form filter berpindah secara dinamis dan aman antara desktop sidebar dan modal mobile saat browser diperkecil/diperbesar tanpa membuat data filter hilang/kosong.
- **Filter Tag Global**: Filter di sidebar desktop dan modal mobile kini seragam berupa **chips/tags horizontal** tanpa checkbox kaku.
- **Sorting Modern**: Baik di mobile maupun desktop, dropdown pilihan sortir telah digantikan oleh **chip horizontal interaktif** ("Paling Relevan", "Judul", "Penulis", dsb) yang akan disorot biru muda saat terpilih.
- **Laci Filter Fullscreen & Reset**: Khusus mobile, filter terbuka fullscreen dengan tombol **Atur Ulang** (pembersih input + range slider tahun) dan tombol **Terapkan** secara berdampingan.
- Slider tahun penerbitan tertata rapi di kedua perangkat.

### D. Pengaturan Ukuran Search Box (3 Opsi) & Jumlah Tampilan Koleksi
- Opsi konfigurasi **"Search Box Size"** ditambahkan di halaman admin SLiMS, berisi opsi **Small** (Kecil), **Medium** (Sedang/Standar), dan **Large** (Besar).
- Lebar kotak, padding card-body, ukuran font input teks, dan ikon advanced search berubah dinamis menyesuaikan setelan admin.
- Jumlah item koleksi baru dan koleksi populer di homepage kini sepenuhnya dinamis mengikuti konfigurasi **"Popular Collection Item"** dan **"New Collection Item"** yang disimpan di pengaturan kustomisasi tema di admin SLiMS.

### E. Konfigurasi Show/Hide Layout & Minimal Homepage (Centered + Dark Background)
- Pilihan pengaturan **"Show/Hide Footer"**, **"Show/Hide Topic List"** (Pilih Subjek), dan **"Only Navbar & Hero Searchbar on Homepage"** ditambahkan di halaman admin SLiMS.
- Bagian footer, daftar subjek, dan seluruh bagian beranda lainnya akan merespons setelan di admin secara otomatis tanpa perlu memodifikasi kode sumber.
- Saat opsi minimal diaktifkan, tampilan homepage bertransisi menjadi halaman pencarian modern satu layar penuh (`100vh`) dengan gradasi warna gelap senada dengan navbar, kotak pencarian serta judulnya berada tepat di tengah (centered), dan footer disembunyikan secara elegan.
- Visual navbar dipercantik dengan efek teks glow dan garis neon cyan (`#22d3ee`), toggler selaras, serta dropdown card gelap (`#0f172a`) yang modern agar menyatu utuh dengan atmosfer visual hero.

### F. Konsistensi Tipografi Mobile & Ukuran Font Hero Title (3 Opsi)
- Ukuran teks diselaraskan agar seimbang antara judul buku (15px), nama penulis (11px), detail metadata (12px), teks filter (14px), dan chip tag (12px).
- Opsi konfigurasi **"Hero Text Size"** (Kecil, Sedang, Besar) diterapkan secara dinamis menggunakan responsive `clamp()`. Modifikasi CSS menyingkirkan pembatas statis `!important` di smartphone agar teks judul membesar/mengecil sesuai setelan.

### G. Fitur Back to Top & Floating Info dengan Animasi Jin Keluar dari Teko
- **Tombol Floating Info**: Tombol info yang selalu melayang di pojok kanan bawah dengan animasi bergoyang (`wiggleBounce`) berkala. Ketika diklik, tombol memuat konten dinamis halaman `libinfo` dari database SLiMS.
- **Animasi Jin Keluar Teko (Genie Transition)**: Animasi transisi kustom yang menarik di mana modal mekar, memutar, dan meregang keluar secara organik langsung dari titik tombol Info, serta menyedot kembali ke dalam tombol ketika ditutup.
- **Tombol Back to Top Dinamis**: Tombol kembali ke atas yang bersembunyi di dalam tombol Info dan meluncur ke atas (spring-out) dengan efek memutar saat halaman di-scroll ke bawah melewati 300px, mencegah adanya tumpang tuntih visual (overlap) di antara keduanya.
- **Kompatibilitas Mobile**: Tombol diposisikan secara dinamis naik ke atas area navigasi bawah perangkat seluler agar tidak menghalangi menu jempol di HP.

### H. Penataan Ulang Header Hasil Pencarian & View Switcher (Desktop & Mobile)
- **Struktur Dua Baris**: Membagi header pencarian menjadi baris hasil pencarian + tombol rubah view di bagian atas, dan baris daftar Sort by chips di bagian bawah.
- **Desain Tombol Rubah View Baru**: Tombol rubah view diperbarui dengan gaya modern (`btn-light border shadow-sm px-3 py-2`) lengkap dengan label teks "Grid" atau "List" di samping ikonnya, dengan sudut melengkung `8px` agar lebih premium dan nyaman diklik.
- **Sortir Rapi**: Memindahkan chips sortir ke kontainer khusus abu-abu tipis (`bg-light p-2 rounded shadow-sm`) agar memanjang 100% lebar layar, menghilangkan masalah pembungkusan (wrapping) yang tidak beraturan dan membuat layout terlihat seimbang dan bersih.

### I. Sticky Footer (Penjaga Kaki Halaman)
- Menambahkan layout Flexbox modern (`display: flex; flex-direction: column; min-height: 100vh;`) di seluruh struktur template.
- Footer secara otomatis bergeser dan menempel di batas terbawah layar (`margin-top: auto`) pada kondisi isi konten halaman sangat minim (seperti pada pencarian nihil atau halaman info ringkas) demi menjaga kerapian tata letak.

### J. Pengaturan Menu Navigasi Dinamis (Tambah/Kurangi Menu)
- Pilihan pengaturan **"Navbar Menus"** ditambahkan di halaman admin SLiMS.
- Pengaturan menu menggunakan input baris dinamis (key-value) dengan 2 kolom input di setiap barisnya: untuk Nama Menu dan URL Menu.
- **Implementasi Khusus Folder Template**: Fitur ini diimplementasikan sepenuhnya di dalam folder template melalui skrip transformasi DOM (JavaScript) pada file [tinfo.inc.php](file:///var/www/html/slims/s951dev/mpkp/template/default/tinfo.inc.php). Ketika halaman kustomisasi dibuka, skrip secara otomatis menyembunyikan textarea bawaan SLiMS dan menggantinya dengan antarmuka visual baris menu interaktif.
- Administrator dapat menambahkan baris baru ("Tambah Menu") atau menghapus baris ("Hapus") secara visual dengan mudah melalui tombol interaktif.
- Nilai dari kolom input tersebut otomatis digabung menggunakan pemisah ` ; ` secara real-time dan disimpan ke database secara transparan.
- Administrator dapat menambah, merubah, atau mengurangi tautan menu kapan saja tanpa menyentuh kode PHP dasar template, serta tetap mendukung banyak menu yang mengarah ke target subhalaman yang sama.
- Menu default tetap kompatibel dengan lokalisasi peramban bahasa OPAC secara otomatis.

### K. Pengaturan Tampilan Menu Member Area (Area Anggota)
- Pilihan pengaturan **"Member Area in Navbar"** (Tampilkan/Sembunyikan Area Anggota di Navbar) ditambahkan di halaman admin SLiMS.
- Membungkus layout tombol Member Area (baik saat berstatus login maupun logout) di file [parts/_navbar.php](file:///var/www/html/slims/s951dev/mpkp/template/default/parts/_navbar.php) dengan blok kondisional PHP untuk merespons setelan dinamis dari admin.

### L. Pengaturan Tampilan Pilihan Bahasa (Bendera Bahasa)
- Pilihan pengaturan **"Language Selection in Navbar"** (Tampilkan/Sembunyikan Pilihan Bahasa di Navbar) ditambahkan di halaman admin SLiMS.
- Membungkus layout pilihan bahasa (flag icon) di file [parts/_navbar.php](file:///var/www/html/slims/s951dev/mpkp/template/default/parts/_navbar.php) dengan blok kondisional PHP untuk merespons setelan dinamis dari admin.

### M. Pilihan Aksen Warna Tema Dinamis (Theme Accent Color Switcher)
- Pilihan pengaturan **"Theme Accent Color"** (Warna Aksen Tema) ditambahkan di halaman kustomisasi tema SLiMS. Pilihan warna meliputi: Neon Cyan (Default), Neon Emerald, Sunset Orange, Royal Gold, dan Electric Pink.
- Mendefinisikan CSS Custom Properties (Variables) di dalam `<head>` pada file [parts/header.php](file:///var/www/html/slims/s951dev/mpkp/template/default/parts/header.php) yang memetakan warna aksen terpilih secara dinamis.
- Mengubah semua pewarnaan statis (`#22d3ee`) pada navigasi hover, efek glow, underline transition, dan sub-header di file [parts/_navbar.php](file:///var/www/html/slims/s951dev/mpkp/template/default/parts/_navbar.php) serta modal dialog info dan tombol melayang di file [parts/footer.php](file:///var/www/html/slims/s951dev/mpkp/template/default/parts/footer.php) agar menggunakan variabel CSS tersebut.
- Mengintegrasikan pembacaan CSS variable secara real-time pada generator partikel JavaScript di file [parts/_home.php](file:///var/www/html/slims/s951dev/mpkp/template/default/parts/_home.php) untuk mewarnai partikel neon latar belakang sesuai dengan aksen tema yang dipilih.
