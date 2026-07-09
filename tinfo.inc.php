<?php
/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 2020-01-02 15:12
 * @File name           : tinfo.inc.php
 * @Last modified by    : Ade Ismail Siregar (adeismailbox@gmail.com)
 * @Last modified time  : 2026-07-09T14:59:58+07:00
 */

$rasamala_default_topic_items = "Literature | index.php?callnumber=8&search=search | fas fa-book ; Social Sciences | index.php?callnumber=3&search=search | fas fa-users ; Applied Sciences | index.php?callnumber=6&search=search | fas fa-flask ; Art & Recreation | index.php?callnumber=7&search=search | fas fa-paint-brush ; see more.. | #exampleModal | fas fa-th-large";
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

$sysconf['template']['base'] = 'php';
$sysconf['template']['responsive'] = false;

$sysconf['template']['classic_library_subname'] = 0;
$sysconf['template']['classic_popular_collection'] = 1;
$sysconf['template']['classic_popular_collection_item'] = 6;
$sysconf['template']['classic_new_collection'] = 1;
$sysconf['template']['classic_new_collection_item'] = 6;
$sysconf['template']['classic_top_reader'] = 1;
$sysconf['template']['classic_top_reader_item'] = 5;
$sysconf['template']['classic_homepage_section_order'] = 'topic;popular;new-collection;top-reader;map';
$sysconf['template']['classic_map'] = 1;
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
$sysconf['template']['classic_footer_about_us'] = <<<HTML
<p>As a complete Library Management System, SLiMS (Senayan Library Management System) has many features that will help libraries and librarians to do their job easily 
and quickly. Follow <a target="_blank" rel="noopener noreferrer" href="https://slims.web.id/web/pages/about/">this link</a> to show some features provided by SLiMS.</p>
HTML;
$sysconf['template']['classic_footer_show'] = 1;
$sysconf['template']['classic_footer_copyright'] = 'Senayan Developer Community';
$sysconf['template']['classic_topic_show'] = 1;
$sysconf['template']['classic_topic_items'] = $rasamala_default_topic_items;
$sysconf['template']['classic_search_size'] = 'medium';
$sysconf['template']['classic_homepage_only_hero'] = 0;
$sysconf['template']['classic_hero_text'] = 'Search Library Collection';
$sysconf['template']['classic_hero_text_size'] = 'small';
$sysconf['template']['classic_search_placeholder'] = 'Enter keyword to search collection...';
$sysconf['template']['classic_hero_background_animation'] = 'particles';
$sysconf['template']['classic_background_animation_speed'] = 'normal';
$sysconf['template']['classic_announcement_show'] = 0;
$sysconf['template']['classic_announcement_text'] = $rasamala_default_announcement_text;
$sysconf['template']['classic_announcement_style'] = 'info';
$sysconf['template']['classic_home_display_show'] = 'below';
$sysconf['template']['classic_home_display_source'] = 'content';
$sysconf['template']['classic_home_display_content_filter'] = 'all';
$sysconf['template']['classic_home_display_content_detail'] = 'title';
$sysconf['template']['classic_home_display_biblio_filter'] = 'all';
$sysconf['template']['classic_ticker_show'] = 0;
$sysconf['template']['classic_ticker_source'] = 'content';
$sysconf['template']['classic_ticker_content_filter'] = 'all';
$sysconf['template']['classic_ticker_content_detail'] = 'title';
$sysconf['template']['classic_ticker_biblio_filter'] = 'all';
$sysconf['template']['classic_ticker_speed'] = 'normal';
$sysconf['template']['classic_latest_content_show'] = 'below';
$sysconf['template']['classic_latest_content_item'] = 5;
$sysconf['template']['classic_latest_content_title_chars'] = 48;
$sysconf['template']['classic_ticker_item_limit'] = 5;
$sysconf['template']['classic_ticker_char_limit'] = 48;
$sysconf['template']['classic_home_item_limit'] = 5;
$sysconf['template']['classic_home_char_limit'] = 48;
$sysconf['template']['classic_parallel_title_separator'] = '=';
$sysconf['template']['classic_title_chars'] = 100;
$sysconf['template']['classic_breadcrumbs_show'] = 1;
$sysconf['template']['classic_back_to_top'] = 1;
$sysconf['template']['classic_floating_info'] = 1;
$sysconf['template']['classic_member_area'] = 1;
$sysconf['template']['classic_theme_color'] = 'warmgray';
$sysconf['template']['classic_color_toggle'] = 1;
$sysconf['template']['classic_font_family'] = 'system';
$sysconf['template']['classic_search_result_layout'] = 'simple';
$sysconf['template']['classic_custom_css'] = $rasamala_default_custom_css;
$sysconf['template']['classic_mobile_bottom_nav_show'] = 1;
$sysconf['template']['classic_language_select'] = 1;
$sysconf['template']['classic_navbar_menu'] = "Home | index.php | fas fa-home ; Information | index.php?p=libinfo | fas fa-info-circle ; News | index.php?p=news | fas fa-newspaper ; Help | index.php?p=help | fas fa-question-circle ; Librarian | index.php?p=librarian | fas fa-users ; Staff Area | index.php?p=login | fas fa-user-shield";
$coll_type_data = [['all', __('All Collection Types')]];
if (isset($dbs) && $dbs) {
    $coll_q = $dbs->query("SELECT coll_type_id, coll_type_name FROM mst_coll_type ORDER BY coll_type_name ASC");
    if ($coll_q) {
        while ($coll_r = $coll_q->fetch_assoc()) {
            $coll_type_data[] = [$coll_r['coll_type_name'], $coll_r['coll_type_name']];
        }
    }
}

$sysconf['template']['option'][$sysconf['template']['theme']] = [
    // -------------------------------------------------------------
    // Section 1: General & Layout Settings
    // -------------------------------------------------------------
    'responsive' => [
        'dbfield' => 'responsive',
        'label' => __('Enable this theme for mobile?'),
        'type' => 'dropdown',
        'default' => 0,
        'data' => [
            [1, __('Yes, please!')],
            [0, __('No, I want use lighweight theme')]
        ]
    ],
    'theme-color' => [
        'dbfield' => 'classic_theme_color',
        'label' => __('Theme Accent Color'),
        'type' => 'dropdown',
        'default' => 'warmgray',
        'data' => [
            ['warmgray', __('Warm Gray (Default)')],
            ['cyan', __('Neon Cyan')],
            ['emerald', __('Neon Emerald')],
            ['orange', __('Sunset Orange')],
            ['gold', __('Royal Gold')],
            ['pink', __('Electric Pink')]
        ]
    ],
    'color-toggle' => [
        'dbfield' => 'classic_color_toggle',
        'label' => __('Dark/Light Mode Toggle'),
        'type' => 'dropdown',
        'default' => 1,
        'data' => [
            [1, __('Show')],
            [0, __('Hide')]
        ]
    ],
    'font-family' => [
        'dbfield' => 'classic_font_family',
        'label' => __('Theme Font Family'),
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
    'breadcrumbs-show' => [
        'dbfield' => 'classic_breadcrumbs_show',
        'label' => __('Breadcrumbs'),
        'type' => 'dropdown',
        'default' => 1,
        'data' => [
            [1, __('Show')],
            [0, __('Hide')]
        ]
    ],
    'back-to-top' => [
        'dbfield' => 'classic_back_to_top',
        'label' => __('Back to Top Button'),
        'type' => 'dropdown',
        'default' => 1,
        'data' => [
            [1, __('Show')],
            [0, __('Hide')]
        ]
    ],
    'floating-info' => [
        'dbfield' => 'classic_floating_info',
        'label' => __('Floating Info Button'),
        'type' => 'dropdown',
        'default' => 1,
        'data' => [
            [1, __('Show')],
            [0, __('Hide')]
        ]
    ],
    'custom-css' => [
        'dbfield' => 'classic_custom_css',
        'label' => __('Custom CSS'),
        'type' => 'longtext',
        'default' => $rasamala_default_custom_css,
        'width' => '100',
        'max' => 10000
    ],

    // -------------------------------------------------------------
    // Section 2: Navbar Options
    // -------------------------------------------------------------
    'navbar-menu' => [
        'dbfield' => 'classic_navbar_menu',
        'label' => __('Navbar Menus'),
        'type' => 'longtext',
        'default' => "Home | index.php | fas fa-home ; Information | index.php?p=libinfo | fas fa-info-circle ; News | index.php?p=news | fas fa-newspaper ; Help | index.php?p=help | fas fa-question-circle ; Librarian | index.php?p=librarian | fas fa-users ; Staff Area | index.php?p=login | fas fa-user-shield",
        'width' => '100',
        'max' => 2000
    ],
    'member-area' => [
        'dbfield' => 'classic_member_area',
        'label' => __('Member Area in Navbar'),
        'type' => 'dropdown',
        'default' => 1,
        'data' => [
            [1, __('Show')],
            [0, __('Hide')]
        ]
    ],
    'language-select' => [
        'dbfield' => 'classic_language_select',
        'label' => __('Language Selection in Navbar'),
        'type' => 'dropdown',
        'default' => 1,
        'data' => [
            [1, __('Show')],
            [0, __('Hide')]
        ]
    ],
    'mobile-bottom-nav-show' => [
        'dbfield' => 'classic_mobile_bottom_nav_show',
        'label' => __('Mobile Bottom Navigation Bar'),
        'type' => 'dropdown',
        'default' => 1,
        'data' => [
            [1, __('Show')],
            [0, __('Hide')]
        ]
    ],

    // -------------------------------------------------------------
    // Section 3: Hero & Search Settings
    // -------------------------------------------------------------
    'homepage-only-hero' => [
        'dbfield' => 'classic_homepage_only_hero',
        'label' => __('Simple Homepage'),
        'type' => 'dropdown',
        'default' => 0,
        'data' => [
            [1, __('Yes')],
            [0, __('No')]
        ]
    ],
    'hero-text' => [
        'dbfield' => 'classic_hero_text',
        'label' => __('Text on top search'),
        'type' => 'text',
        'default' => 'Search Library Collection'
    ],
    'hero-text-size' => [
        'dbfield' => 'classic_hero_text_size',
        'label' => __('Text on top search size'),
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
        'label' => __('Search Box Size'),
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
        'label' => __('Search Placeholder Text'),
        'type' => 'text',
        'default' => 'Enter keyword to search collection...'
    ],
    'search-result-layout' => [
        'dbfield' => 'classic_search_result_layout',
        'label' => __('Default Search Result Layout'),
        'type' => 'dropdown',
        'default' => 'simple',
        'data' => [
            ['simple', __('Simple')],
            ['list', __('List')],
            ['grid', __('Grid')]
        ]
    ],
    'hero-background-animation' => [
        'dbfield' => 'classic_hero_background_animation',
        'label' => __('Background Animation'),
        'type' => 'dropdown',
        'default' => 'particles',
        'data' => [
            ['none', __('None')],
            ['particles', __('Floating Glyphs')],
            ['constellation', __('Constellation Lines')],
            ['rain', __('Code Rain')],
            ['waves', __('Ambient Waves')],
            ['grid', __('Moving Grid')]
        ]
    ],
    'background-animation-speed' => [
        'dbfield' => 'classic_background_animation_speed',
        'label' => __('Background Animation Speed'),
        'type' => 'dropdown',
        'default' => 'normal',
        'data' => [
            ['slow', __('Slow')],
            ['normal', __('Normal')],
            ['fast', __('Fast')]
        ]
    ],
    'announcement-show' => [
        'dbfield' => 'classic_announcement_show',
        'label' => __('Show Announcement Banner'),
        'type' => 'dropdown',
        'default' => 0,
        'data' => [
            [1, __('Show')],
            [0, __('Hide')]
        ]
    ],
    'announcement-text' => [
        'dbfield' => 'classic_announcement_text',
        'label' => __('Announcement Text / HTML'),
        'type' => 'longtext',
        'default' => $rasamala_default_announcement_text
    ],
    'announcement-style' => [
        'dbfield' => 'classic_announcement_style',
        'label' => __('Announcement Banner Style'),
        'type' => 'dropdown',
        'default' => 'info',
        'data' => [
            ['info', __('Info (Blue)')],
            ['warning', __('Warning (Yellow)')],
            ['danger', __('Danger (Red)')],
            ['success', __('Success (Green)')]
        ]
    ],

    // -------------------------------------------------------------
    // Section 4: Ticker / Running Text Settings
    // -------------------------------------------------------------
    'ticker-show' => [
        'dbfield' => 'classic_ticker_show',
        'label' => __('Ticker Display Position'),
        'type' => 'dropdown',
        'default' => 0,
        'data' => [
            ['bottom', __('Bottom Screen')],
            ['below', __('Below Search Box')],
            [0, __('Hide')]
        ]
    ],
    'ticker-source' => [
        'dbfield' => 'classic_ticker_source',
        'label' => __('Ticker Display Source'),
        'type' => 'dropdown',
        'default' => 'content',
        'data' => [
            ['content', __('Latest Content (News/Info)')],
            ['biblio', __('Latest Bibliography (Books/Items)')]
        ]
    ],
    'ticker-content-filter' => [
        'dbfield' => 'classic_ticker_content_filter',
        'label' => __('Ticker Content Filter'),
        'type' => 'dropdown',
        'default' => 'all',
        'data' => [
            ['all', __('All Content')],
            ['news', __('News Only')]
        ]
    ],
    'ticker-content-detail' => [
        'dbfield' => 'classic_ticker_content_detail',
        'label' => __('Ticker Content Detail'),
        'type' => 'dropdown',
        'default' => 'title',
        'data' => [
            ['title', __('Title Only')],
            ['detail', __('Title and Content Excerpt')]
        ]
    ],
    'ticker-biblio-filter' => [
        'dbfield' => 'classic_ticker_biblio_filter',
        'label' => __('Ticker Bibliography Filter'),
        'type' => 'dropdown',
        'default' => 'all',
        'data' => $coll_type_data
    ],
    'ticker-speed' => [
        'dbfield' => 'classic_ticker_speed',
        'label' => __('Ticker Animation Speed'),
        'type' => 'dropdown',
        'default' => 'normal',
        'data' => [
            ['slow', __('Slow (48s)')],
            ['normal', __('Normal (32s)')],
            ['fast', __('Fast (18s)')]
        ]
    ],
    'ticker-item-limit' => [
        'dbfield' => 'classic_ticker_item_limit',
        'label' => __('Ticker Item Count'),
        'type' => 'text',
        'default' => 5
    ],
    'ticker-char-limit' => [
        'dbfield' => 'classic_ticker_char_limit',
        'label' => __('Ticker Character Limit'),
        'type' => 'text',
        'default' => 48
    ],

    // -------------------------------------------------------------
    // Section 5: Homepage Display (Below Search Box) Settings
    // -------------------------------------------------------------
    'home-display-show' => [
        'dbfield' => 'classic_home_display_show',
        'label' => __('Homepage Display Position'),
        'type' => 'dropdown',
        'default' => 'below',
        'data' => [
            ['below', __('Below Search Box')],
            ['bottom', __('Bottom Screen')],
            [0, __('Hide')]
        ]
    ],
    'home-display-source' => [
        'dbfield' => 'classic_home_display_source',
        'label' => __('Homepage Display Source'),
        'type' => 'dropdown',
        'default' => 'content',
        'data' => [
            ['content', __('Latest Content (News/Info)')],
            ['biblio', __('Latest Bibliography (Books/Items)')]
        ]
    ],
    'home-display-content-filter' => [
        'dbfield' => 'classic_home_display_content_filter',
        'label' => __('Homepage Display Content Filter'),
        'type' => 'dropdown',
        'default' => 'all',
        'data' => [
            ['all', __('All Content')],
            ['news', __('News Only')]
        ]
    ],
    'home-display-content-detail' => [
        'dbfield' => 'classic_home_display_content_detail',
        'label' => __('Homepage Display Content Detail'),
        'type' => 'dropdown',
        'default' => 'title',
        'data' => [
            ['title', __('Title Only')],
            ['detail', __('Title and Content Excerpt')]
        ]
    ],
    'home-display-biblio-filter' => [
        'dbfield' => 'classic_home_display_biblio_filter',
        'label' => __('Homepage Display Bibliography Filter'),
        'type' => 'dropdown',
        'default' => 'all',
        'data' => $coll_type_data
    ],
    'home-item-limit' => [
        'dbfield' => 'classic_home_item_limit',
        'label' => __('Homepage Display Item Count'),
        'type' => 'text',
        'default' => 5
    ],
    'home-char-limit' => [
        'dbfield' => 'classic_home_char_limit',
        'label' => __('Homepage Display Character Limit'),
        'type' => 'text',
        'default' => 48
    ],

    // -------------------------------------------------------------
    // Section 6: Homepage Sections & Topics
    // -------------------------------------------------------------
    'subtitle' => [
        'dbfield' => 'classic_library_subname',
        'label' => __('Library Sub Name'),
        'type' => 'dropdown',
        'default' => 0,
        'data' => [
            [1, __('Show')],
            [0, __('Hide')]
        ]
    ],
    'topic-show' => [
        'dbfield' => 'classic_topic_show',
        'label' => __('Homepage Topics Section'),
        'type' => 'dropdown',
        'default' => 1,
        'data' => [
            [1, __('Show')],
            [0, __('Hide')]
        ]
    ],
    'topic-items' => [
        'dbfield' => 'classic_topic_items',
        'label' => __('Homepage Topics'),
        'type' => 'longtext',
        'default' => $rasamala_default_topic_items,
        'width' => '100',
        'max' => 4000
    ],
    'popular-collection' => [
        'dbfield' => 'classic_popular_collection',
        'label' => __('Popular Collection Section'),
        'type' => 'dropdown',
        'default' => 1,
        'data' => [
            [1, __('Show')],
            [0, __('Hide')]
        ]
    ],
    'popular-collection-item' => [
        'dbfield' => 'classic_popular_collection_item',
        'label' => __('Popular Items Count'),
        'type' => 'text',
        'default' => 6
    ],
    'new-collection' => [
        'dbfield' => 'classic_new_collection',
        'label' => __('New Collection Section'),
        'type' => 'dropdown',
        'default' => 1,
        'data' => [
            [1, __('Show')],
            [0, __('Hide')]
        ]
    ],
    'new-collection-item' => [
        'dbfield' => 'classic_new_collection_item',
        'label' => __('New Collection Items Count'),
        'type' => 'text',
        'default' => 6
    ],
    'top-reader' => [
        'dbfield' => 'classic_top_reader',
        'label' => __('Top Reader Section'),
        'type' => 'dropdown',
        'default' => 1,
        'data' => [
            [1, __('Show')],
            [0, __('Hide')]
        ]
    ],
    'top-reader-item' => [
        'dbfield' => 'classic_top_reader_item',
        'label' => __('Top Reader Items Count'),
        'type' => 'text',
        'default' => 5
    ],
    'homepage-section-order' => [
        'dbfield' => 'classic_homepage_section_order',
        'label' => __('Homepage Section Order'),
        'type' => 'text',
        'default' => 'topic;popular;new-collection;top-reader;map'
    ],

    // -------------------------------------------------------------
    // Section 7: Maps & Contact Info
    // -------------------------------------------------------------
    'map' => [
        'dbfield' => 'classic_map',
        'label' => __('Maps Section'),
        'type' => 'dropdown',
        'default' => 1,
        'data' => [
            [1, __('Show')],
            [0, __('Hide')]
        ]
    ],
    'map-link' => [
        'dbfield' => 'classic_map_link',
        'label' => __('Map Iframe Link'),
        'type' => 'text',
        'default' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.288723306273!2d106.80038831428296!3d-6.225610995493402!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f14efd9abf05%3A0x1659580cc6981749!2sPerpustakaan+Kemendikbud!5e0!3m2!1sid!2sid!4v1516601731218'
    ],
    'map-height' => [
        'dbfield' => 'classic_map_height',
        'label' => __('Map Height (px)'),
        'type' => 'text',
        'default' => '420'
    ],
    'map-desc' => [
        'dbfield' => 'classic_map_desc',
        'label' => __('Map Description / Contact Info'),
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
        'label' => __('Show Footer'),
        'type' => 'dropdown',
        'default' => 1,
        'data' => [
            [1, __('Show')],
            [0, __('Hide')]
        ]
    ],
    'footer-about-us' => [
        'dbfield' => 'classic_footer_about_us',
        'label' => __('Footer About Us'),
        'type' => 'longtext',
        'default' => '<p>As a complete Library Management System, SLiMS (Senayan Library Management System) has many features that will help libraries and librarians to do their job easily and quickly. Follow <a target="_blank" rel="noopener noreferrer" href="https://slims.web.id/web/pages/about/">this link</a> to show some features provided by SLiMS.</p>'
    ],
    'footer-copyright' => [
        'dbfield' => 'classic_footer_copyright',
        'label' => __('Footer Copyright Text'),
        'type' => 'text',
        'default' => 'Senayan Developer Community'
    ],

    // -------------------------------------------------------------
    // Section 10: Metadata & General Text Limits
    // -------------------------------------------------------------
    'title-chars' => [
        'dbfield' => 'classic_title_chars',
        'label' => __('Title Character Limit'),
        'type' => 'text',
        'default' => 100,
        'width' => '10',
        'max' => 4
    ],
    'parallel-title-separator' => [
        'dbfield' => 'classic_parallel_title_separator',
        'label' => __('Parallel Title Separator'),
        'type' => 'text',
        'default' => '=',
        'width' => '10',
        'max' => 12
    ],

    // -------------------------------------------------------------
    // Section 11: Visitor Page Settings
    // -------------------------------------------------------------
    'visitor-log-voice' => [
        'dbfield' => 'visitor_log_voice',
        'label' => __('Visitor Log Voice'),
        'type' => 'dropdown',
        'default' => 1,
        'data' => [
            [1, __('Enable')],
            [0, __('Disable')]
        ]
    ],
    'visitor-quote' => [
        'dbfield' => 'visitor_quote',
        'label' => __('Visitor Page Greeting Quote'),
        'type' => 'dropdown',
        'default' => 1,
        'data' => [
            [1, __('Enable')],
            [0, __('Disable')]
        ]
    ],
];

if (isset($_GET['customize']) && $_GET['customize'] == 'public' && isset($_GET['theme']) && $_GET['theme'] == 'rasamala') {
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
