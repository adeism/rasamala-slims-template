<?php
/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 2020-01-02 15:12
 * @File name           : tinfo.inc.php
 * @Last modified by    : Ade Ismail Siregar (adeismailbox@gmail.com)
 * @Last modified time  : 2026-07-16T15:21:55+07:00
 */

$rasamala_default_topic_items = "Literature | index.php?callnumber=8&search=search | fas fa-book ; Social Sciences | index.php?callnumber=3&search=search | fas fa-users ; Applied Sciences | index.php?callnumber=6&search=search | fas fa-flask ; Art & Recreation | index.php?callnumber=7&search=search | fas fa-paint-brush ; Language | index.php?callnumber=4&search=search | fas fa-language ; see more.. | #exampleModal | fas fa-th-large";
$rasamala_default_announcement_text = <<<HTML
<strong>Info layanan:</strong> Perpustakaan buka Senin-Jumat, pukul 08.00-16.00 WIB.
<a href="index.php?p=libinfo">Lihat informasi lengkap</a>.
HTML;
$rasamala_default_custom_css = <<<CSS
/* Custom CSS Rasamala
   Edit contoh di bawah ini sesuai kebutuhan. */

/* Contoh: ubah ukuran nama perpustakaan di navbar */
/* .navbar-lib-name {
  font-size: 14px !important;
} */

/* Contoh: beri jarak tambahan pada judul hero */
/* .hero-search-heading h1 {
  margin-bottom: 16px !important;
} */

/* Contoh: custom warna tombol utama */
/* .btn-primary {
  background-color: var(--theme-accent-color) !important;
  border-color: var(--theme-accent-color) !important;
} */
CSS;
$rasamala_default_visitor_split_steps = <<<TEXT
fas fa-id-card | Isi Identitas | Scan kartu anggota atau ketik identitas pengunjung pada kolom yang tersedia.
scan | Proses Kunjungan | Sistem akan memeriksa data dan menampilkan status kunjungan secara otomatis.
fas fa-check | Selesai | Setelah berhasil, pengunjung dapat melanjutkan aktivitas sesuai layanan yang tersedia.
TEXT;

$sysconf['template']['base'] = 'php';
$sysconf['template']['responsive'] = true;

$sysconf['template']['classic_library_name_position'] = 'navbar';
$sysconf['template']['classic_library_subname'] = 0;
$sysconf['template']['classic_popular_collection'] = 1;
$sysconf['template']['classic_popular_collection_heading_display'] = 'all';
$sysconf['template']['classic_popular_collection_title_show'] = 1;
$sysconf['template']['classic_popular_collection_subtitle_show'] = 1;
$sysconf['template']['classic_popular_collection_item'] = 6;
$sysconf['template']['classic_new_collection'] = 1;
$sysconf['template']['classic_new_collection_heading_display'] = 'all';
$sysconf['template']['classic_new_collection_title_show'] = 1;
$sysconf['template']['classic_new_collection_subtitle_show'] = 1;
$sysconf['template']['classic_new_collection_item'] = 6;
$sysconf['template']['classic_top_reader'] = 1;
$sysconf['template']['classic_top_reader_heading_display'] = 'both';
$sysconf['template']['classic_top_reader_title_show'] = 1;
$sysconf['template']['classic_top_reader_subtitle_show'] = 1;
$sysconf['template']['classic_top_reader_item'] = 5;
$sysconf['template']['classic_homepage_section_order'] = 'topic;news;popular;new-collection;top-reader;map';
$sysconf['template']['classic_map'] = 'all';
$sysconf['template']['classic_map_link'] = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.288723306273!2d106.80038831428296!3d-6.225610995493402!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f14efd9abf05%3A0x1659580cc6981749!2sPerpustakaan+Kemendikbud!5e0!3m2!1sid!2sid!4v1516601731218';
$sysconf['template']['classic_map_height'] = '420';
$sysconf['template']['classic_map_desc'] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque et nunc mi. Donec vehicula turpis a quam venenatis posuere. Aliquam nibh lectus, gravida et leo sit amet, dignissim dapibus mauris.<br>Telp. (021) 9172638<br>Fax. (021) 9172638<br>';
$sysconf['template']['classic_fb_link'] = 'https://www.facebook.com/groups/senayan.slims';
$sysconf['template']['classic_twitter_link'] = 'https://twitter.com/slims_official';
$sysconf['template']['classic_youtube_link'] = 'https://youtube.com';
$sysconf['template']['classic_instagram_link'] = 'https://instagram.com/slims.sdc';
$sysconf['template']['classic_tiktok_link'] = '';
$sysconf['template']['classic_whatsapp_link'] = '';
$sysconf['template']['classic_telegram_link'] = '';
$sysconf['template']['classic_linkedin_link'] = '';
$sysconf['template']['visitor_log_voice'] = 1;
$sysconf['template']['visitor_quote'] = 1;
$sysconf['template']['visitor_title'] = '';
$sysconf['template']['visitor_subtitle'] = 'Visitor Check-In Portal';
$sysconf['template']['visitor_theme_toggle'] = 1;
$sysconf['template']['visitor_layout_style'] = 'kiosk';
$sysconf['template']['visitor_split_title'] = 'Petunjuk Penggunaan';
$sysconf['template']['visitor_split_steps'] = $rasamala_default_visitor_split_steps;
$sysconf['template']['classic_footer_about_us'] = <<<HTML
<p>As a complete Library Management System, SLiMS (Senayan Library Management System) has many features that will help libraries and librarians to do their job easily 
and quickly. Follow <a target="_blank" rel="noopener noreferrer" href="https://slims.web.id/web/pages/about/">this link</a> to show some features provided by SLiMS.</p>
HTML;
$sysconf['template']['classic_footer_show'] = 1;
$sysconf['template']['classic_footer_search_show'] = 0;
$sysconf['template']['classic_footer_copyright'] = 'Senayan Developer Community';
$sysconf['template']['classic_prayer_times_show'] = 'both';
$sysconf['template']['classic_prayer_times_city'] = 'Jakarta';
$sysconf['template']['classic_theme_preset'] = 'simple_homepage';
$sysconf['template']['classic_topic_show'] = 1;
$sysconf['template']['classic_topic_heading_display'] = 'title';
$sysconf['template']['classic_topic_title_show'] = 1;
$sysconf['template']['classic_topic_subtitle_show'] = 0;
$sysconf['template']['classic_topic_items'] = $rasamala_default_topic_items;
$sysconf['template']['classic_search_size'] = 'medium';
$sysconf['template']['classic_homepage_only_hero'] = 0;
$sysconf['template']['classic_hero_text'] = 'Search Library Collection';
$sysconf['template']['classic_hero_text_size'] = 'small';
$sysconf['template']['classic_search_placeholder'] = 'Enter keyword to search collection...';
$sysconf['template']['classic_hero_background_animation'] = 'twinkle';
$sysconf['template']['classic_background_animation_speed'] = 'normal';
$sysconf['template']['classic_cursor_particles'] = 'auto';
$sysconf['template']['classic_cursor_custom_icon'] = 'default';
$sysconf['template']['classic_announcement_show'] = 0;
$sysconf['template']['classic_announcement_text'] = $rasamala_default_announcement_text;
$sysconf['template']['classic_announcement_style'] = 'theme';
$sysconf['template']['classic_home_display_show'] = 'below';
$sysconf['template']['classic_home_display_style'] = 'badges';
$sysconf['template']['classic_home_display_source'] = 'content';
$sysconf['template']['classic_home_display_content_filter'] = 'all';
$sysconf['template']['classic_home_display_content_detail'] = 'title';
$sysconf['template']['classic_home_display_biblio_filter'] = 'all';
$sysconf['template']['classic_home_display_custom_text'] = 'Selamat datang di perpustakaan kami!';
$sysconf['template']['classic_ticker_show'] = 'bottom';
$sysconf['template']['classic_ticker_source'] = 'content';
$sysconf['template']['classic_ticker_content_filter'] = 'all';
$sysconf['template']['classic_ticker_content_detail'] = 'title';
$sysconf['template']['classic_ticker_biblio_filter'] = 'all';
$sysconf['template']['classic_ticker_speed'] = 'normal';
$sysconf['template']['classic_ticker_custom_text'] = 'Selamat datang di perpustakaan kami!';
$sysconf['template']['classic_latest_content_show'] = 'below';
$sysconf['template']['classic_latest_content_item'] = 5;
$sysconf['template']['classic_latest_content_title_chars'] = 48;
$sysconf['template']['classic_ticker_item_limit'] = 5;
$sysconf['template']['classic_ticker_char_limit'] = 48;
$sysconf['template']['classic_home_item_limit'] = 1;
$sysconf['template']['classic_home_char_limit'] = 48;
$sysconf['template']['classic_home_content_cards_show'] = 1;
$sysconf['template']['classic_home_content_cards_source'] = 'news';
$sysconf['template']['classic_home_content_path_1'] = '';
$sysconf['template']['classic_home_content_path_2'] = '';
$sysconf['template']['classic_home_content_path_3'] = '';
$sysconf['template']['classic_parallel_title_separator'] = '=';
$sysconf['template']['classic_title_chars'] = 100;
$sysconf['template']['classic_show_author_role'] = 0;
$sysconf['template']['classic_detail_label_type'] = 'gmd';
$sysconf['template']['classic_breadcrumbs_show'] = 1;
$sysconf['template']['classic_back_to_top'] = 1;
$sysconf['template']['classic_floating_info'] = 'whatsapp';
$sysconf['template']['classic_whatsapp_number'] = '628123456789';
$sysconf['template']['classic_whatsapp_title'] = 'Layanan Chat WhatsApp';
$sysconf['template']['classic_service_hours'] = 'Senin - Jumat (08:00 - 16:00)';
$sysconf['template']['classic_whatsapp_desc'] = 'Pilih salah satu kategori pertanyaan di bawah ini untuk memulai chat dengan pustakawan kami via WhatsApp.';
$sysconf['template']['classic_whatsapp_categories'] = "Tugas Akhir | Halo, saya ingin bertanya tentang layanan tugas akhir.\nDenda | Halo, saya ingin bertanya tentang informasi denda.\nLogin | Halo, saya mengalami kendala login OPAC/akun.";
$sysconf['template']['classic_member_area'] = 1;
$sysconf['template']['classic_theme_color'] = 'warmgray';
$sysconf['template']['classic_palette_custom'] = '#0B4F54; #5C8374; #F2994A; #F4F6F8; #FFFFFF; #1C1E21; #B0B7BD | #1A2E40; #B38F4D; #D9534F; #101318; #161A22; #F4F6F8; #B6BEC8';
$sysconf['template']['classic_palette_primary'] = '#111827';
$sysconf['template']['classic_palette_secondary'] = '#475569';
$sysconf['template']['classic_palette_accent'] = '#2563eb';
$sysconf['template']['classic_palette_background'] = '#f8fafc';
$sysconf['template']['classic_palette_surface'] = '#ffffff';
$sysconf['template']['classic_palette_text'] = '#111827';
$sysconf['template']['classic_palette_muted'] = '#64748b';
$sysconf['template']['classic_color_toggle'] = 'auto_show';
$sysconf['template']['classic_palette_switcher_show'] = 1;
$sysconf['template']['classic_font_family'] = 'system';
$sysconf['template']['classic_search_result_layout'] = 'simple';
$sysconf['template']['classic_search_panel_style'] = 'transparent';
$sysconf['template']['classic_news_list_layout'] = 'title_excerpt';
$sysconf['template']['classic_custom_css'] = $rasamala_default_custom_css;
$sysconf['template']['classic_mobile_bottom_nav_show'] = 1;
$sysconf['template']['classic_auto_cover_generator'] = 'empty_missing';
$sysconf['template']['classic_language_visible_codes'] = 'id_ID, en_US';
$sysconf['template']['classic_librarian_display_mode'] = 'all';
$sysconf['template']['classic_librarian_custom_usernames'] = '';
$sysconf['template']['classic_navbar_menu'] = "Home | index.php | fas fa-home ; Information | index.php?p=libinfo | fas fa-info-circle ; News | index.php?p=news | fas fa-newspaper ; Help | index.php?p=help | fas fa-question-circle ; Librarian | index.php?p=librarian | fas fa-users ; Staff Area | index.php?p=login | fas fa-university";
$coll_type_data = [['all', __('All Collection Types')]];
if (isset($dbs) && $dbs) {
    $coll_q = $dbs->query("SELECT coll_type_id, coll_type_name FROM mst_coll_type ORDER BY coll_type_name ASC");
    if ($coll_q) {
        while ($coll_r = $coll_q->fetch_assoc()) {
            $coll_type_data[] = [$coll_r['coll_type_name'], $coll_r['coll_type_name']];
        }
    }
}
$rasamala_section_heading_display_data = [
    ['all', __('Title + Subtitle + Subject')],
    ['both', __('Title + Subtitle')],
    ['title_subject', __('Title + Subject')],
    ['title', __('Title Only')],
    ['hide', __('Hide All')]
];

$sysconf['template']['option'][$sysconf['template']['theme']] = [
    // -------------------------------------------------------------
    // Section 1: General & Layout Settings
    // -------------------------------------------------------------

    'theme-preset' => [
        'dbfield' => 'classic_theme_preset',
        'label' => __('Pilihan Keseluruhan Tema'),
        'type' => 'dropdown',
        'default' => 'simple_homepage',
        'data' => [
            ['simple_homepage', __('Simple - Search + Running Text')],
            ['office', __('Simple + Topics')],
            ['all_show', __('Full - Topics + News + Collections + Top Reader + Map + Running Text')],
            ['custom', __('Custom (Fully Unlocked)')]
        ]
    ],
    'theme-color' => [
        'dbfield' => 'classic_theme_color',
        'label' => __('Theme Color Palette'),
        'type' => 'dropdown',
        'default' => 'warmgray',
        'data' => [
            ['warmgray', __('Warm Gray (Default)')],
            ['cyan', __('Neon Cyan')],
            ['emerald', __('Neon Emerald')],
            ['orange', __('Sunset Orange')],
            ['gold', __('Royal Gold')],
            ['pink', __('Electric Pink')],
            ['minimalwhite', __('Minimal White')],
            ['darkgray', __('Dark Gray')],
            ['forest', __('Forest Academic')],
            ['cleanblue', __('Clean Blue')],
            ['warmlibrary', __('Warm Library')],
            ['monominimal', __('Mono Minimal')],
            ['custom', __('Custom Palette')]
        ]
    ],
    'palette-custom' => [
        'dbfield' => 'classic_palette_custom',
        'label' => __('Custom Palette Colors'),
        'type' => 'longtext',
        'default' => '#0B4F54; #5C8374; #F2994A; #F4F6F8; #FFFFFF; #1C1E21; #B0B7BD | #1A2E40; #B38F4D; #D9534F; #101318; #161A22; #F4F6F8; #B6BEC8',
    ],
    'color-toggle' => [
        'dbfield' => 'classic_color_toggle',
        'label' => __('Tombol Dark/Light Mode'),
        'type' => 'dropdown',
        'default' => 'auto_show',
        'data' => [
            ['auto_show', __('Auto - Button Show (Mengikuti Sistem Perangkat)')],
            ['auto_hide', __('Auto - Button Hide (Mengikuti Sistem Perangkat)')],
            ['dark_show', __('Default Dark - Button Show')],
            ['dark_hide', __('Default Dark - Button Hide')],
            ['light_show', __('Default Light - Button Show')],
            ['light_hide', __('Default Light - Button Hide')]
        ]
    ],
    'palette-switcher-show' => [
        'dbfield' => 'classic_palette_switcher_show',
        'label' => __('Theme Viewer'),
        'type' => 'dropdown',
        'default' => 1,
        'data' => [
            [1, __('Show')],
            [0, __('Hide')]
        ]
    ],
    'font-family' => [
        'dbfield' => 'classic_font_family',
        'label' => __('Font Tema'),
        'type' => 'dropdown',
        'default' => 'system',
        'data' => [
            ['system', __('System Default (Outfit)')],
            ['inter', __('Inter')],
            ['roboto', __('Roboto')],
            ['poppins', __('Poppins')],
            ['playfair', __('Playfair Display (Serif)')]
        ]
    ],
    'back-to-top' => [
        'dbfield' => 'classic_back_to_top',
        'label' => __('Tombol Kembali ke Atas'),
        'type' => 'dropdown',
        'default' => 1,
        'data' => [
            [1, __('Show')],
            [0, __('Hide')]
        ]
    ],
    'floating-info' => [
        'dbfield' => 'classic_floating_info',
        'label' => __('Tombol Info Melayang'),
        'type' => 'dropdown',
        'default' => 'whatsapp',
        'data' => [
            ['libinfo', __('Show Library Info (Libinfo)')],
            ['whatsapp', __('WhatsApp Mode')],
            ['hide', __('Hide')]
        ]
    ],
    'whatsapp-number' => [
        'dbfield' => 'classic_whatsapp_number',
        'label' => __('Nomor WhatsApp (dengan Kode Negara)'),
        'type' => 'text',
        'default' => '628123456789'
    ],
    'whatsapp-title' => [
        'dbfield' => 'classic_whatsapp_title',
        'label' => __('Judul Layanan WhatsApp'),
        'type' => 'text',
        'default' => 'Layanan Chat WhatsApp'
    ],
    'service-hours' => [
        'dbfield' => 'classic_service_hours',
        'label' => __('Jam Layanan'),
        'type' => 'text',
        'default' => 'Senin - Jumat (08:00 - 16:00)'
    ],
    'whatsapp-desc' => [
        'dbfield' => 'classic_whatsapp_desc',
        'label' => __('Deskripsi Singkat WhatsApp'),
        'type' => 'text',
        'default' => 'Pilih salah satu kategori pertanyaan di bawah ini untuk memulai chat dengan pustakawan kami via WhatsApp.'
    ],
    'whatsapp-categories' => [
        'dbfield' => 'classic_whatsapp_categories',
        'label' => __('Kategori Pertanyaan WhatsApp (Format: Kategori | Template Pesan)'),
        'type' => 'longtext',
        'default' => "Tugas Akhir | Halo, saya ingin bertanya tentang layanan tugas akhir.\nDenda | Halo, saya ingin bertanya tentang informasi denda.\nLogin | Halo, saya mengalami kendala login OPAC/akun."
    ],
    'custom-css' => [
        'dbfield' => 'classic_custom_css',
        'label' => __('Custom CSS Tambahan'),
        'type' => 'longtext',
        'default' => $rasamala_default_custom_css,
        'width' => '100',
        'max' => 10000
    ],

    // -------------------------------------------------------------
    // Section 2: Navigation Bar Options
    // -------------------------------------------------------------
    'navbar-menu' => [
        'dbfield' => 'classic_navbar_menu',
        'label' => __('Menu Navbar'),
        'type' => 'longtext',
        'default' => "Home | index.php | fas fa-home ; Information | index.php?p=libinfo | fas fa-info-circle ; News | index.php?p=news | fas fa-newspaper ; Help | index.php?p=help | fas fa-question-circle ; Librarian | index.php?p=librarian | fas fa-users ; Staff Area | index.php?p=login | fas fa-university",
        'width' => '100',
        'max' => 2000
    ],
    'member-area' => [
        'dbfield' => 'classic_member_area',
        'label' => __('Area Anggota di Navbar'),
        'type' => 'dropdown',
        'default' => 1,
        'data' => [
            [1, __('Show')],
            [0, __('Hide')]
        ]
    ],
    'library-name-position' => [
        'dbfield' => 'classic_library_name_position',
        'label' => __('Posisi Logo & Nama Perpustakaan (Desktop View)'),
        'type' => 'dropdown',
        'default' => 'navbar',
        'data' => [
            ['navbar', __('Logo & nama di Navbar (default)')],
            ['hero', __('Logo & nama di atas Search Box (Desktop)')]
        ]
    ],
    'subtitle' => [
        'dbfield' => 'classic_library_subname',
        'label' => __('Subnama Perpustakaan di Navbar'),
        'type' => 'dropdown',
        'default' => 0,
        'data' => [
            [1, __('Show')],
            [0, __('Hide')]
        ]
    ],
    'language-visible-codes' => [
        'dbfield' => 'classic_language_visible_codes',
        'label' => __('Bahasa yang Ditampilkan'),
        'type' => 'longtext',
        'default' => 'id_ID, en_US',
        'width' => '100',
        'max' => 1000
    ],
    'mobile-bottom-nav-show' => [
        'dbfield' => 'classic_mobile_bottom_nav_show',
        'label' => __('Navbar Mobile Bawah'),
        'type' => 'dropdown',
        'default' => 1,
        'data' => [
            [1, __('Show')],
            [0, __('Hide')]
        ]
    ],

    // -------------------------------------------------------------
    // Section 3: Hero & Search Bar Settings
    // -------------------------------------------------------------
    'hero-text' => [
        'dbfield' => 'classic_hero_text',
        'label' => __('Teks Judul Search'),
        'type' => 'text',
        'default' => 'Search Library Collection'
    ],
    'hero-text-size' => [
        'dbfield' => 'classic_hero_text_size',
        'label' => __('Ukuran Teks Judul Search'),
        'type' => 'dropdown',
        'default' => 'small',
        'data' => [
            ['small', __('Small')],
            ['medium', __('Medium')],
            ['large', __('Large')]
        ]
    ],
    'search-size' => [
        'dbfield' => 'classic_search_size',
        'label' => __('Ukuran Search Box'),
        'type' => 'dropdown',
        'default' => 'medium',
        'data' => [
            ['small', __('Small')],
            ['medium', __('Medium')],
            ['large', __('Large')]
        ]
    ],
    'search-placeholder' => [
        'dbfield' => 'classic_search_placeholder',
        'label' => __('Placeholder Search'),
        'type' => 'text',
        'default' => 'Enter keyword to search collection...'
    ],
    'hero-background-animation' => [
        'dbfield' => 'classic_hero_background_animation',
        'label' => __('Animasi Background'),
        'type' => 'dropdown',
        'default' => 'twinkle',
        'data' => [
            ['none', __('None')],
            ['particles', __('Floating Glyphs')],
            ['rain', __('Code Rain')],
            ['grid', __('Moving Grid')],
            ['twinkle', __('Twinkling Stars')],
            ['zen-ripples', __('Zen Ripples')],
            ['neural-network', __('Neural Network')],
            ['starfield-warp', __('Starfield Warp')],
            ['floating-embers', __('Floating Embers')]
        ]
    ],
    'background-animation-speed' => [
        'dbfield' => 'classic_background_animation_speed',
        'label' => __('Kecepatan Animasi Background'),
        'type' => 'dropdown',
        'default' => 'normal',
        'data' => [
            ['slow', __('Slow')],
            ['normal', __('Normal')],
            ['fast', __('Fast')]
        ]
    ],
    'cursor-particles' => [
        'dbfield' => 'classic_cursor_particles',
        'label' => __('Efek Partikel Cursor'),
        'type' => 'dropdown',
        'default' => 'auto',
        'data' => [
            ['auto', __('Auto (Deteksi Perangkat)')],
            ['low', __('Ringan')],
            ['medium', __('Sedang')],
            ['high', __('Optimal')],
            ['none', __('Nonaktif')]
        ]
    ],
    'cursor-custom-icon' => [
        'dbfield' => 'classic_cursor_custom_icon',
        'label' => __('Ikon Cursor'),
        'type' => 'dropdown',
        'default' => 'default',
        'data' => [
            ['default', __('Default Browser')],
            ['neon-comet', __('Neon Comet')],
            ['pixel-sword', __('Pixel Sword')],
            ['electric-bolt', __('Electric Bolt')],
            ['ink-brush', __('Ink Brush')],
            ['rainbow-ribbon', __('Rainbow Ribbon')]
        ]
    ],
    'announcement-show' => [
        'dbfield' => 'classic_announcement_show',
        'label' => __('Banner Pengumuman'),
        'type' => 'dropdown',
        'default' => 0,
        'data' => [
            [1, __('Show')],
            [0, __('Hide')]
        ]
    ],
    'announcement-text' => [
        'dbfield' => 'classic_announcement_text',
        'label' => __('Isi Pengumuman / HTML'),
        'type' => 'longtext',
        'default' => $rasamala_default_announcement_text
    ],
    'announcement-style' => [
        'dbfield' => 'classic_announcement_style',
        'label' => __('Gaya Banner Pengumuman'),
        'type' => 'dropdown',
        'default' => 'theme',
        'data' => [
            ['theme', __('Theme Adaptive / Auto')],
            ['info', __('Info (Blue)')],
            ['warning', __('Warning (Yellow)')],
            ['danger', __('Danger (Red)')],
            ['success', __('Success (Green)')]
        ]
    ],

    // -------------------------------------------------------------
    // Section 4: Running Text Settings
    // -------------------------------------------------------------
    'ticker-show' => [
        'dbfield' => 'classic_ticker_show',
        'label' => __('Posisi Running Text'),
        'type' => 'dropdown',
        'default' => 'bottom',
        'data' => [
            ['bottom', __('Show')],
            [0, __('Hide')]
        ]
    ],
    'ticker-source' => [
        'dbfield' => 'classic_ticker_source',
        'label' => __('Sumber Running Text'),
        'type' => 'dropdown',
        'default' => 'content',
        'data' => [
            ['content', __('Latest Content (News/Info)')],
            ['biblio', __('Latest Bibliography (Books/Items)')],
            ['custom_ticker', __('Custom Text (Ketik Manual)')]
        ]
    ],
    'ticker-custom-text' => [
        'dbfield' => 'classic_ticker_custom_text',
        'label' => __('Teks Kustom Running Text (Jika memilih Custom Text)'),
        'type' => 'text',
        'default' => 'Selamat datang di perpustakaan kami!'
    ],
    'ticker-content-filter' => [
        'dbfield' => 'classic_ticker_content_filter',
        'label' => __('Filter Konten Running Text'),
        'type' => 'dropdown',
        'default' => 'all',
        'data' => [
            ['all', __('All Content')],
            ['news', __('News Only')]
        ]
    ],
    'ticker-content-detail' => [
        'dbfield' => 'classic_ticker_content_detail',
        'label' => __('Detail Konten Running Text'),
        'type' => 'dropdown',
        'default' => 'title',
        'data' => [
            ['title', __('Title Only')],
            ['detail', __('Title and Content Excerpt')]
        ]
    ],
    'ticker-biblio-filter' => [
        'dbfield' => 'classic_ticker_biblio_filter',
        'label' => __('Filter Koleksi Running Text'),
        'type' => 'dropdown',
        'default' => 'all',
        'data' => $coll_type_data
    ],
    'ticker-speed' => [
        'dbfield' => 'classic_ticker_speed',
        'label' => __('Kecepatan Running Text'),
        'type' => 'dropdown',
        'default' => 'normal',
        'data' => [
            ['fast', __('Fast (12s)')],
            ['normal', __('Normal (18s)')],
            ['slow', __('Slow (32s)')],
            ['very_slow', __('Very Slow (52s)')]
        ]
    ],
    'ticker-item-limit' => [
        'dbfield' => 'classic_ticker_item_limit',
        'label' => __('Jumlah Item Running Text'),
        'type' => 'text',
        'default' => 5
    ],
    'ticker-char-limit' => [
        'dbfield' => 'classic_ticker_char_limit',
        'label' => __('Batas Karakter Running Text (0 untuk tampilkan semua / tidak terbatas)'),
        'type' => 'text',
        'default' => 48
    ],

    // -------------------------------------------------------------
    // Section 5: Search Area Info Settings
    // -------------------------------------------------------------
    'home-display-show' => [
        'dbfield' => 'classic_home_display_show',
        'label' => __('Posisi Info Area Search (Hero Info)'),
        'type' => 'dropdown',
        'default' => 'below',
        'data' => [
            ['below', __('Show')],
            [0, __('Hide')]
        ]
    ],
    'home-display-style' => [
        'dbfield' => 'classic_home_display_style',
        'label' => __('Gaya Tampilan Info Search'),
        'type' => 'dropdown',
        'default' => 'badges',
        'data' => [
            ['badges', __('Static Badges/Pills')],
            ['fade', __('Fading Slideshow')],
            ['ticker', __('Horizontal Ticker (Running Text)')]
        ]
    ],
    'home-display-source' => [
        'dbfield' => 'classic_home_display_source',
        'label' => __('Sumber Info Area Search'),
        'type' => 'dropdown',
        'default' => 'content',
        'data' => [
            ['content', __('Latest Content (News/Info)')],
            ['biblio', __('Latest Bibliography (Books/Items)')],
            ['custom_home', __('Custom Text (Ketik Manual)')]
        ]
    ],
    'home-display-custom-text' => [
        'dbfield' => 'classic_home_display_custom_text',
        'label' => __('Teks Kustom Info Search (Jika memilih Custom Text)'),
        'type' => 'text',
        'default' => 'Selamat datang di perpustakaan kami!'
    ],
    'home-display-content-filter' => [
        'dbfield' => 'classic_home_display_content_filter',
        'label' => __('Filter Konten Info Search'),
        'type' => 'dropdown',
        'default' => 'all',
        'data' => [
            ['all', __('All Content')],
            ['news', __('News Only')]
        ]
    ],
    'home-display-content-detail' => [
        'dbfield' => 'classic_home_display_content_detail',
        'label' => __('Detail Konten Info Search'),
        'type' => 'dropdown',
        'default' => 'title',
        'data' => [
            ['title', __('Title Only')],
            ['detail', __('Title and Content Excerpt')]
        ]
    ],
    'home-display-biblio-filter' => [
        'dbfield' => 'classic_home_display_biblio_filter',
        'label' => __('Filter Koleksi Info Search'),
        'type' => 'dropdown',
        'default' => 'all',
        'data' => $coll_type_data
    ],
    'home-item-limit' => [
        'dbfield' => 'classic_home_item_limit',
        'label' => __('Jumlah Item Info Search'),
        'type' => 'text',
        'default' => 1
    ],
    'home-char-limit' => [
        'dbfield' => 'classic_home_char_limit',
        'label' => __('Batas Karakter Info Search (0 untuk tampilkan semua / tidak terbatas)'),
        'type' => 'text',
        'default' => 48
    ],

    // -------------------------------------------------------------
    // Section 6: Homepage Sections & Topics
    // -------------------------------------------------------------
    'home-content-cards-show' => [
        'dbfield' => 'classic_home_content_cards_show',
        'label' => __('News/Content in Homepage'),
        'type' => 'dropdown',
        'default' => 1,
        'data' => [
            [1, __('Show')],
            [0, __('Hide')]
        ]
    ],
    'home-content-cards-source' => [
        'dbfield' => 'classic_home_content_cards_source',
        'label' => __('Source of News/Content'),
        'type' => 'dropdown',
        'default' => 'news',
        'data' => [
            ['news', __('News Saja')],
            ['all', __('All Content')],
            ['custom', __('Custom Path')]
        ]
    ],
    'home-content-path-1' => [
        'dbfield' => 'classic_home_content_path_1',
        'label' => __('Custom Content Path 1 (contoh: news)'),
        'type' => 'text',
        'default' => ''
    ],
    'home-content-path-2' => [
        'dbfield' => 'classic_home_content_path_2',
        'label' => __('Custom Content Path 2'),
        'type' => 'text',
        'default' => ''
    ],
    'home-content-path-3' => [
        'dbfield' => 'classic_home_content_path_3',
        'label' => __('Custom Content Path 3'),
        'type' => 'text',
        'default' => ''
    ],
    'topic-show' => [
        'dbfield' => 'classic_topic_show',
        'label' => __('Section Topics Beranda'),
        'type' => 'dropdown',
        'default' => 1,
        'data' => [
            [1, __('Show')],
            [0, __('Hide')]
        ]
    ],
    'topic-heading-display' => [
        'dbfield' => 'classic_topic_heading_display',
        'label' => __('Teks Section Topics'),
        'type' => 'dropdown',
        'default' => 'title',
        'data' => $rasamala_section_heading_display_data
    ],
    'topic-items' => [
        'dbfield' => 'classic_topic_items',
        'label' => __('Daftar Topics Beranda'),
        'type' => 'longtext',
        'default' => $rasamala_default_topic_items,
        'width' => '100',
        'max' => 4000
    ],
    'popular-collection' => [
        'dbfield' => 'classic_popular_collection',
        'label' => __('Section Koleksi Populer'),
        'type' => 'dropdown',
        'default' => 1,
        'data' => [
            [1, __('Show')],
            [0, __('Hide')]
        ]
    ],
    'popular-collection-heading-display' => [
        'dbfield' => 'classic_popular_collection_heading_display',
        'label' => __('Teks Section Koleksi Populer'),
        'type' => 'dropdown',
        'default' => 'all',
        'data' => $rasamala_section_heading_display_data
    ],
    'popular-collection-item' => [
        'dbfield' => 'classic_popular_collection_item',
        'label' => __('Jumlah Koleksi Populer'),
        'type' => 'text',
        'default' => 6
    ],
    'new-collection' => [
        'dbfield' => 'classic_new_collection',
        'label' => __('Section Koleksi Terbaru'),
        'type' => 'dropdown',
        'default' => 1,
        'data' => [
            [1, __('Show')],
            [0, __('Hide')]
        ]
    ],
    'new-collection-heading-display' => [
        'dbfield' => 'classic_new_collection_heading_display',
        'label' => __('Teks Section Koleksi Terbaru'),
        'type' => 'dropdown',
        'default' => 'all',
        'data' => $rasamala_section_heading_display_data
    ],
    'new-collection-item' => [
        'dbfield' => 'classic_new_collection_item',
        'label' => __('Jumlah Koleksi Terbaru'),
        'type' => 'text',
        'default' => 6
    ],
    'top-reader' => [
        'dbfield' => 'classic_top_reader',
        'label' => __('Section Top Reader'),
        'type' => 'dropdown',
        'default' => 1,
        'data' => [
            [1, __('Show')],
            [0, __('Hide')]
        ]
    ],
    'top-reader-heading-display' => [
        'dbfield' => 'classic_top_reader_heading_display',
        'label' => __('Teks Section Top Reader'),
        'type' => 'dropdown',
        'default' => 'both',
        'data' => $rasamala_section_heading_display_data
    ],
    'top-reader-item' => [
        'dbfield' => 'classic_top_reader_item',
        'label' => __('Jumlah Top Reader'),
        'type' => 'text',
        'default' => 5
    ],
    'homepage-section-order' => [
        'dbfield' => 'classic_homepage_section_order',
        'label' => __('Urutan Section Beranda'),
        'type' => 'text',
        'default' => 'topic;news;popular;new-collection;top-reader;map'
    ],

    // -------------------------------------------------------------
    // Section 7: Maps & Contact Info
    // -------------------------------------------------------------
    'map' => [
        'dbfield' => 'classic_map',
        'label' => __('Section Peta & Sosial Media'),
        'type' => 'dropdown',
        'default' => 'all',
        'data' => [
            ['all', __('Tampilkan Peta dan Sosial Media')],
            ['hide_all', __('Sembunyikan Peta dan Sosial Media')],
            ['hide_map', __('Sembunyikan Peta')],
            ['hide_social', __('Sembunyikan Sosial Media')]
        ]
    ],
    'map-link' => [
        'dbfield' => 'classic_map_link',
        'label' => __('Link Iframe Peta'),
        'type' => 'text',
        'default' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.288723306273!2d106.80038831428296!3d-6.225610995493402!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f14efd9abf05%3A0x1659580cc6981749!2sPerpustakaan+Kemendikbud!5e0!3m2!1sid!2sid!4v1516601731218'
    ],
    'map-height' => [
        'dbfield' => 'classic_map_height',
        'label' => __('Tinggi Peta (px)'),
        'type' => 'text',
        'default' => '420'
    ],
    'map-desc' => [
        'dbfield' => 'classic_map_desc',
        'label' => __('Deskripsi Peta / Kontak'),
        'type' => 'longtext',
        'default' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque et nunc mi. Donec vehicula turpis a quam venenatis posuere. Aliquam nibh lectus, gravida et leo sit amet, dignissim dapibus mauris.<br>Telp. (021) 9172638<br>Fax. (021) 9172638<br>'
    ],

    // -------------------------------------------------------------
    // Section 8: Social Media Links
    // -------------------------------------------------------------
    'fb-link' => [
        'dbfield' => 'classic_fb_link',
        'label' => __('Facebook Link'),
        'type' => 'text',
        'default' => 'https://www.facebook.com/groups/senayan.slims'
    ],
    'twitter-link' => [
        'dbfield' => 'classic_twitter_link',
        'label' => __('Twitter Link'),
        'type' => 'text',
        'default' => 'https://twitter.com/slims_official'
    ],
    'youtube-link' => [
        'dbfield' => 'classic_youtube_link',
        'label' => __('YouTube Link'),
        'type' => 'text',
        'default' => 'https://youtube.com'
    ],
    'instagram-link' => [
        'dbfield' => 'classic_instagram_link',
        'label' => __('Instagram Link'),
        'type' => 'text',
        'default' => 'https://instagram.com/slims.sdc'
    ],
    'tiktok-link' => [
        'dbfield' => 'classic_tiktok_link',
        'label' => __('TikTok Link'),
        'type' => 'text',
        'default' => ''
    ],
    'whatsapp-link' => [
        'dbfield' => 'classic_whatsapp_link',
        'label' => __('WhatsApp Link'),
        'type' => 'text',
        'default' => ''
    ],
    'telegram-link' => [
        'dbfield' => 'classic_telegram_link',
        'label' => __('Telegram Link'),
        'type' => 'text',
        'default' => ''
    ],
    'linkedin-link' => [
        'dbfield' => 'classic_linkedin_link',
        'label' => __('LinkedIn Link'),
        'type' => 'text',
        'default' => ''
    ],

    // -------------------------------------------------------------
    // Section 9: Footer Settings
    // -------------------------------------------------------------
    'footer-show' => [
        'dbfield' => 'classic_footer_show',
        'label' => __('Footer'),
        'type' => 'dropdown',
        'default' => 1,
        'data' => [
            [1, __('Show')],
            [0, __('Hide')]
        ]
    ],
    'footer-about-us' => [
        'dbfield' => 'classic_footer_about_us',
        'label' => __('Tentang Kami di Footer'),
        'type' => 'longtext',
        'default' => '<p>As a complete Library Management System, SLiMS (Senayan Library Management System) has many features that will help libraries and librarians to do their job easily and quickly. Follow <a target="_blank" rel="noopener noreferrer" href="https://slims.web.id/web/pages/about/">this link</a> to show some features provided by SLiMS.</p>'
    ],
    'footer-search-show' => [
        'dbfield' => 'classic_footer_search_show',
        'label' => __('Search Form di Footer'),
        'type' => 'dropdown',
        'default' => 0,
        'data' => [
            [0, __('Hide')],
            [1, __('Show')]
        ]
    ],
    'footer-copyright' => [
        'dbfield' => 'classic_footer_copyright',
        'label' => __('Teks Copyright Footer'),
        'type' => 'text',
        'default' => 'Senayan Developer Community'
    ],
    'prayer-times-show' => [
        'dbfield' => 'classic_prayer_times_show',
        'label' => __('Widget Waktu Sholat'),
        'type' => 'dropdown',
        'default' => 'both',
        'data' => [
            ['both', __('Footer + Floating Reminder')],
            ['footer', __('Footer Only')],
            ['floating', __('Floating Reminder Only (10 Minutes)')],
            ['hide', __('Hide')]
        ]
    ],
    'prayer-times-city' => [
        'dbfield' => 'classic_prayer_times_city',
        'label' => __('Kota Waktu Sholat'),
        'type' => 'dropdown',
        'default' => 'Jakarta',
        'data' => [
            ['Jakarta', 'Jakarta'],
            ['Bandung', 'Bandung'],
            ['Surabaya', 'Surabaya'],
            ['Medan', 'Medan'],
            ['Semarang', 'Semarang'],
            ['Makassar', 'Makassar'],
            ['Yogyakarta', 'Yogyakarta'],
            ['Palembang', 'Palembang'],
            ['Denpasar', 'Denpasar'],
            ['Balikpapan', 'Balikpapan'],
            ['Pekanbaru', 'Pekanbaru'],
            ['Banjarmasin', 'Banjarmasin'],
            ['Depok', 'Depok'],
            ['Tangerang', 'Tangerang'],
            ['Bekasi', 'Bekasi'],
            ['Bogor', 'Bogor'],
            ['Malang', 'Malang'],
            ['Solo', 'Surakarta (Solo)'],
            ['Padang', 'Padang'],
            ['Banda Aceh', 'Banda Aceh'],
            ['Pontianak', 'Pontianak'],
            ['Samarinda', 'Samarinda'],
            ['Manado', 'Manado'],
            ['Ambon', 'Ambon'],
            ['Jayapura', 'Jayapura']
        ]
    ],

    // -------------------------------------------------------------
    // Section 10: Librarian Page Settings
    // -------------------------------------------------------------
    'librarian-display-mode' => [
        'dbfield' => 'classic_librarian_display_mode',
        'label' => __('Pustakawan yang Ditampilkan'),
        'type' => 'dropdown',
        'default' => 'all',
        'data' => [
            ['all', __('Semua')],
            ['librarian_senior', __('Pustakawan + Pustakawan Senior')],
            ['senior', __('Pustakawan Senior Saja')],
            ['custom', __('Custom Username')]
        ]
    ],
    'librarian-custom-usernames' => [
        'dbfield' => 'classic_librarian_custom_usernames',
        'label' => __('Username Custom Pustakawan (contoh: user1(kepala perpustakaan);user2(bagian informasi))'),
        'type' => 'text',
        'default' => ''
    ],

    // -------------------------------------------------------------
    // Section 11: Book Detail & Search Results Settings
    // -------------------------------------------------------------
    'search-result-layout' => [
        'dbfield' => 'classic_search_result_layout',
        'label' => __('Tampilan Default Hasil Pencarian'),
        'type' => 'dropdown',
        'default' => 'simple',
        'data' => [
            ['simple', __('Simple')],
            ['list', __('List')],
            ['grid', __('Grid')]
        ]
    ],
    'search-panel-style' => [
        'dbfield' => 'classic_search_panel_style',
        'label' => __('Gaya Background Panel'),
        'type' => 'dropdown',
        'default' => 'transparent',
        'data' => [
            ['transparent', __('Transparent')],
            ['solid', __('Solid')]
        ]
    ],
    'news-list-layout' => [
        'dbfield' => 'classic_news_list_layout',
        'label' => __('Tampilan List Berita / Informasi'),
        'type' => 'dropdown',
        'default' => 'title_excerpt',
        'data' => [
            ['title_excerpt', __('Title and Excerpt')],
            ['title_only', __('Title Only')],
            ['title_excerpt_thumbnail', __('Title, Excerpt, and Thumbnail')]
        ]
    ],
    'auto-cover-generator' => [
        'dbfield' => 'classic_auto_cover_generator',
        'label' => __('Auto Generate Cover Buku Kosong'),
        'type' => 'dropdown',
        'default' => 'empty_missing',
        'data' => [
            ['empty_missing', __('No cover and missing files')],
            ['empty_only', __('No cover only')],
            ['none', __('Disable')]
        ]
    ],
    'breadcrumbs-show' => [
        'dbfield' => 'classic_breadcrumbs_show',
        'label' => __('Breadcrumbs Navigation'),
        'type' => 'dropdown',
        'default' => 1,
        'data' => [
            [1, __('Show')],
            [0, __('Hide')]
        ]
    ],
    'detail-label-type' => [
        'dbfield' => 'classic_detail_label_type',
        'label' => __('Label di Atas Judul Buku (Halaman Detail)'),
        'type' => 'dropdown',
        'default' => 'gmd',
        'data' => [
            ['gmd', 'GMD (General Material Designation)'],
            ['coll_type', __('Collection Type')]
        ]
    ],
    'show-author-role' => [
        'dbfield' => 'classic_show_author_role',
        'label' => __('Tampilkan Peran/Tipe Pengarang (misal: Personal Name)'),
        'type' => 'dropdown',
        'default' => 0,
        'data' => [
            [1, __('Show')],
            [0, __('Hide')]
        ]
    ],
    'title-chars' => [
        'dbfield' => 'classic_title_chars',
        'label' => __('Batas Karakter Judul Utama (Halaman Detail Buku & Hasil Pencarian)'),
        'type' => 'text',
        'default' => 100,
        'width' => '10',
        'max' => 4
    ],
    'parallel-title-separator' => [
        'dbfield' => 'classic_parallel_title_separator',
        'label' => __('Karakter Pemisah Judul Paralel (Halaman Detail Buku & Hasil Pencarian)'),
        'type' => 'text',
        'default' => '=',
        'width' => '10',
        'max' => 12
    ],

    // -------------------------------------------------------------
    // Section 12: Visitor Log Page Settings
    // -------------------------------------------------------------
    'visitor-log-voice' => [
        'dbfield' => 'visitor_log_voice',
        'label' => __('Suara Visitor Log'),
        'type' => 'dropdown',
        'default' => 1,
        'data' => [
            [1, __('Enable')],
            [0, __('Disable')]
        ]
    ],
    'visitor-quote' => [
        'dbfield' => 'visitor_quote',
        'label' => __('Kutipan Salam Visitor Page'),
        'type' => 'dropdown',
        'default' => 1,
        'data' => [
            [1, __('Enable')],
            [0, __('Disable')]
        ]
    ],
    'visitor-title' => [
        'dbfield' => 'visitor_title',
        'label' => __('Judul Utama Halaman Kiosk (Kosongkan untuk default nama perpustakaan)'),
        'type' => 'text',
        'default' => ''
    ],
    'visitor-subtitle' => [
        'dbfield' => 'visitor_subtitle',
        'label' => __('Sub-judul Halaman Kiosk Visitor'),
        'type' => 'text',
        'default' => 'Visitor Check-In Portal'
    ],
    'visitor-theme-toggle' => [
        'dbfield' => 'visitor_theme_toggle',
        'label' => __('Tombol Toggle Mode Gelap di Halaman Visitor'),
        'type' => 'dropdown',
        'default' => 1,
        'data' => [
            [1, __('Enable')],
            [0, __('Disable')]
        ]
    ],
    'visitor-layout-style' => [
        'dbfield' => 'visitor_layout_style',
        'label' => __('Desain Halaman Visitor (Buku Tamu)'),
        'type' => 'dropdown',
        'default' => 'kiosk',
        'data' => [
            ['kiosk', __('Kiosk Mode (Kartu Tengah dengan Jam Besar)')],
            ['split', __('Split Layout (Form Kiri & Petunjuk Kanan)')]
        ]
    ],
    'visitor-split-title' => [
        'dbfield' => 'visitor_split_title',
        'label' => __('Judul Petunjuk Layout Split Visitor'),
        'type' => 'text',
        'default' => 'Petunjuk Penggunaan'
    ],
    'visitor-split-steps' => [
        'dbfield' => 'visitor_split_steps',
        'label' => __('Langkah Petunjuk Layout Split Visitor (format: ikon | judul | deskripsi, satu langkah per baris. Ikon bisa Font Awesome atau "scan".)'),
        'type' => 'longtext',
        'default' => $rasamala_default_visitor_split_steps,
        'width' => '100',
        'max' => 5000
    ],
];

$rasamala_is_public_customizer = isset($_GET['customize']) && $_GET['customize'] == 'public';
$rasamala_requested_theme = strtolower(trim((string)($_GET['theme'] ?? '')));
$rasamala_current_theme = strtolower(trim((string)($sysconf['template']['theme'] ?? '')));
$rasamala_is_theme_context = $rasamala_requested_theme === ''
  || $rasamala_requested_theme === 'rasamala'
  || $rasamala_current_theme === 'rasamala'
  || basename(__DIR__) === 'rasamala';

if ($rasamala_is_public_customizer && $rasamala_is_theme_context) {
  include_once __DIR__ . '/tinfo_helpers.php';
  if (function_exists('rasamalaTinfoCustomizeAssets')) {
    echo rasamalaTinfoCustomizeAssets();
  } else {
  echo <<<'HTML'
<style>
#navbar-menu-builder-container {
    border: 1px solid #E0E0E0;
    background: #FFFFFF;
    padding: 15px;
    border-radius: 4px;
    margin-top: 5px;
}
.menu-builder-row input {
    margin-bottom: 0 !important;
}
.menu-builder-row.is-invalid input {
    border-color: #dc3545;
}
.navbar-menu-builder-help {
    color: #666;
    font-size: 12px;
    margin-bottom: 10px;
}
#topic-items-builder-container {
    border: 1px solid #E0E0E0;
    background: #FFFFFF;
    padding: 15px;
    border-radius: 4px;
    margin-top: 5px;
}
.topic-builder-row input {
    margin-bottom: 0 !important;
}
.topic-builder-row.is-invalid input {
    border-color: #dc3545;
}
.topic-items-builder-help {
    color: #666;
    font-size: 12px;
    margin-bottom: 10px;
}
</style>
<script>
$(document).ready(function() {
    var textarea = $('textarea[name="classic_navbar_menu"]');
    if (textarea.length) {
        // Hide the default textarea
        textarea.hide();
        
        function isSafeMenuUrl(url) {
            url = String(url || '').trim();
            if (url === '' || /[\x00-\x1f\x7f|;]/.test(url)) return false;
            if (url.charAt(0) === '#') return true;
            if (url.indexOf('//') === 0) return false;
            try {
                var parsed = new URL(url, window.location.origin);
                var rawScheme = url.match(/^([a-z][a-z0-9+.-]*):/i);
                if (rawScheme) {
                    return ['http:', 'https:', 'mailto:', 'tel:'].indexOf(parsed.protocol) !== -1;
                }
                return true;
            } catch (e) {
                return false;
            }
        }

        function cleanMenuName(name) {
            return String(name || '').replace(/[|;\r\n]/g, ' ').replace(/\s+/g, ' ').trim();
        }

        function pushItem(items, text, url) {
            text = cleanMenuName(text);
            url = String(url || '').trim();
            if (text !== '' && isSafeMenuUrl(url)) {
                items.push({text: text, url: url});
            }
        }

        function parseMenuValue(rawVal) {
            var items = [];
            rawVal = String(rawVal || '').trim();
            if (rawVal === '') return items;

            var lines = rawVal.split(/[;\n\r]+/);
            for (var i = 0; i < lines.length; i++) {
                var line = lines[i].trim();
                if (line === '') continue;
                var parts = line.split('|');
                if (parts.length >= 2) {
                    pushItem(items, parts[0], parts.slice(1).join('|'));
                }
            }
            return items;
        }

        // Parse the initial value
        var legacyDefaultMenu = 'Home | index.php ; Information | index.php?p=libinfo ; News | index.php?p=news ; Help | index.php?p=help ; Librarian | index.php?p=librarian';
        var rasamalaDefaultMenu = 'Home | index.php ; Information | index.php?p=libinfo ; News | index.php?p=news ; Help | index.php?p=help ; Librarian | index.php?p=librarian ; Staff Area | index.php?p=login';
        var rawVal = textarea.val().trim();
        if (rawVal === legacyDefaultMenu) {
            rawVal = rasamalaDefaultMenu;
            textarea.val(rawVal);
        }
        var items = parseMenuValue(rawVal);
        
        // Create container for builder
        var container = $('<div id="navbar-menu-builder-container" class="mt-2"></div>');
        container.append($('<div class="navbar-menu-builder-help"></div>').text('Format: nama menu dan URL. URL boleh relatif, http(s), mailto, tel, atau anchor #.'));
        var rowsContainer = $('<div id="navbar-menu-rows"></div>');
        container.append(rowsContainer);
        
        var addBtn = $('<button type="button" class="btn btn-success btn-sm mt-2" id="add-menu-row-btn" title="Tambah Menu" style="padding: 4px 12px; cursor: pointer; font-weight: bold; font-size: 14px;">+</button>');
        container.append(addBtn);
        
        textarea.after(container);
        
        function updateTextarea() {
            var itemsList = [];
            rowsContainer.find('.menu-builder-row').each(function() {
                var row = $(this);
                var name = cleanMenuName(row.find('.menu-name-input').val());
                var url = row.find('.menu-url-input').val().trim();
                var isEmpty = name === '' && url === '';
                var isValid = isEmpty || (name !== '' && isSafeMenuUrl(url));
                row.toggleClass('is-invalid', !isValid);
                if (!isEmpty && isValid) {
                    itemsList.push(name + ' | ' + url);
                }
            });
            textarea.val(itemsList.join(' ; '));
        }
        
        function addRow(name, url) {
            name = name || '';
            url = url || '';
            var row = $('<div class="menu-builder-row d-flex align-items-center mb-2" style="gap: 10px; display: flex; align-items: center; margin-bottom: 8px;"></div>');
            row.append($('<input type="text" class="form-control menu-name-input" placeholder="Nama Menu" style="width: 40%; margin-right: 10px; display: inline-block;" />').val(cleanMenuName(name)));
            row.append($('<input type="text" class="form-control menu-url-input" placeholder="URL" style="width: 40%; margin-right: 10px; display: inline-block;" />').val(url));
            row.append($('<button type="button" class="btn btn-danger btn-sm remove-menu-row-btn" title="Hapus" style="padding: 4px 12px; cursor: pointer; display: inline-block; font-weight: bold; font-size: 14px;">&times;</button>'));
            rowsContainer.append(row);
        }
        
        // Populate initial rows
        if (items.length > 0) {
            for (var i = 0; i < items.length; i++) {
                addRow(items[i].text, items[i].url);
            }
        } else {
            addRow('Home', 'index.php');
        }
        
        // Add row action
        addBtn.click(function() {
            addRow('', '');
            updateTextarea();
        });
        
        // Remove row action
        $(document).on('click', '.remove-menu-row-btn', function() {
            $(this).closest('.menu-builder-row').remove();
            updateTextarea();
        });
        
        // Change input action
        $(document).on('input', '.menu-name-input, .menu-url-input', function() {
            updateTextarea();
        });
    }

    var topicTextarea = $('textarea[name="classic_topic_items"]');
    if (topicTextarea.length) {
        topicTextarea.hide();

        function isSafeTopicUrl(url) {
            url = String(url || '').trim();
            if (url === '' || /[\x00-\x1f\x7f|;]/.test(url)) return false;
            if (url.charAt(0) === '#') return true;
            if (url.indexOf('//') === 0) return false;
            try {
                var parsed = new URL(url, window.location.origin);
                var rawScheme = url.match(/^([a-z][a-z0-9+.-]*):/i);
                if (rawScheme) {
                    return ['http:', 'https:', 'mailto:', 'tel:'].indexOf(parsed.protocol) !== -1;
                }
                return true;
            } catch (e) {
                return false;
            }
        }

        function cleanTopicText(text) {
            return String(text || '').replace(/[|;\r\n]/g, ' ').replace(/\s+/g, ' ').trim();
        }

        function cleanTopicIcon(icon) {
            return String(icon || '').replace(/[|;\r\n]/g, ' ').replace(/\s+/g, ' ').trim();
        }

        function parseTopicValue(rawVal) {
            var items = [];
            rawVal = String(rawVal || '').trim();
            if (rawVal === '') return items;

            var lines = rawVal.split(/[;\n\r]+/);
            for (var i = 0; i < lines.length; i++) {
                var line = lines[i].trim();
                if (line === '') continue;
                var parts = line.split('|');
                if (parts.length >= 2) {
                    var label = cleanTopicText(parts[0]);
                    var url = String(parts[1] || '').trim();
                    var icon = cleanTopicIcon(parts.slice(2).join('|'));
                    if (label !== '' && isSafeTopicUrl(url)) {
                        items.push({label: label, url: url, icon: icon});
                    }
                }
            }
            return items;
        }

        var legacyDefaultTopics = 'Literature | index.php?callnumber=8&search=search | images/8-books.png ; Social Sciences | index.php?callnumber=3&search=search | images/3-diploma.png ; Applied Sciences | index.php?callnumber=6&search=search | images/6-blackboard.png ; Art & Recreation | index.php?callnumber=7&search=search | images/7-quill.png ; see more.. | #exampleModal | images/icon/grid_icon.png';
        var rasamalaDefaultTopics = 'Literature | index.php?callnumber=8&search=search | fas fa-book ; Social Sciences | index.php?callnumber=3&search=search | fas fa-users ; Applied Sciences | index.php?callnumber=6&search=search | fas fa-flask ; Art & Recreation | index.php?callnumber=7&search=search | fas fa-paint-brush ; see more.. | #exampleModal | fas fa-th-large';
        var rawTopicVal = topicTextarea.val().trim();
        if (rawTopicVal === legacyDefaultTopics) {
            rawTopicVal = rasamalaDefaultTopics;
            topicTextarea.val(rawTopicVal);
        }
        var topicRows = parseTopicValue(rawTopicVal);
        var topicContainer = $('<div id="topic-items-builder-container" class="mt-2"></div>');
        topicContainer.append($('<div class="topic-items-builder-help"></div>').text('Format: nama topic, URL, dan ikon. Gunakan Font Awesome bawaan tema, contoh: fas fa-book, fas fa-users, fas fa-flask. Path gambar tema tetap didukung bila diperlukan.'));
        var topicRowsContainer = $('<div id="topic-items-rows"></div>');
        topicContainer.append(topicRowsContainer);
        var addTopicBtn = $('<button type="button" class="btn btn-success btn-sm mt-2" id="add-topic-row-btn" title="Tambah Topic" style="padding: 4px 12px; cursor: pointer; font-weight: bold; font-size: 14px;">+</button>');
        topicContainer.append(addTopicBtn);
        topicTextarea.after(topicContainer);

        function updateTopicTextarea() {
            var itemsList = [];
            topicRowsContainer.find('.topic-builder-row').each(function() {
                var row = $(this);
                var label = cleanTopicText(row.find('.topic-label-input').val());
                var url = row.find('.topic-url-input').val().trim();
                var icon = cleanTopicIcon(row.find('.topic-icon-input').val());
                var isEmpty = label === '' && url === '' && icon === '';
                var isValid = isEmpty || (label !== '' && isSafeTopicUrl(url));
                row.toggleClass('is-invalid', !isValid);
                if (!isEmpty && isValid) {
                    itemsList.push(label + ' | ' + url + ' | ' + icon);
                }
            });
            topicTextarea.val(itemsList.join(' ; '));
        }

        function addTopicRow(label, url, icon) {
            var row = $('<div class="topic-builder-row d-flex align-items-center mb-2" style="gap: 10px; display: flex; align-items: center; margin-bottom: 8px;"></div>');
            row.append($('<input type="text" class="form-control topic-label-input" placeholder="Nama Topic" style="width: 30%; margin-right: 10px; display: inline-block;" />').val(cleanTopicText(label)));
            row.append($('<input type="text" class="form-control topic-url-input" placeholder="URL" style="width: 32%; margin-right: 10px; display: inline-block;" />').val(url || ''));
            row.append($('<input type="text" class="form-control topic-icon-input" placeholder="Ikon" style="width: 28%; margin-right: 10px; display: inline-block;" />').val(cleanTopicIcon(icon)));
            row.append($('<button type="button" class="btn btn-danger btn-sm remove-topic-row-btn" title="Hapus" style="padding: 4px 12px; cursor: pointer; display: inline-block; font-weight: bold; font-size: 14px;">&times;</button>'));
            topicRowsContainer.append(row);
        }

        if (topicRows.length > 0) {
            for (var j = 0; j < topicRows.length; j++) {
                addTopicRow(topicRows[j].label, topicRows[j].url, topicRows[j].icon);
            }
        } else {
            addTopicRow('Literature', 'index.php?callnumber=8&search=search', 'fas fa-book');
        }

        addTopicBtn.click(function() {
            addTopicRow('', '', '');
            updateTopicTextarea();
        });

        $(document).on('click', '.remove-topic-row-btn', function() {
            $(this).closest('.topic-builder-row').remove();
            updateTopicTextarea();
        });

        $(document).on('input', '.topic-label-input, .topic-url-input, .topic-icon-input', function() {
            updateTopicTextarea();
        });
    }
});
</script>
HTML;
  }
}
