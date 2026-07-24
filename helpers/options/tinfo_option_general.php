<?php
/**
 * Rasamala Template - Options: Section 1 (General & Layout Settings)
 */
if (!defined('INDEX_AUTH') || INDEX_AUTH != 1) {
  die("can not access this file directly");
}

return [
    'theme-preset' => [
        'dbfield' => 'classic_theme_preset',
        'label' => themeTranslate('Overall Theme Preset'),
        'type' => 'dropdown',
        'default' => 'custom',
        'data' => [
            ['simple_homepage', themeTranslate('Simple - Search + Running Text')],
            ['office', themeTranslate('Simple + Topics')],
            ['all_show', themeTranslate('Full - Topics + News + Collections + Top Reader + Map + Running Text')],
            ['custom', themeTranslate('Custom (Fully Unlocked)')]
        ]
    ],
    'theme-color' => [
        'dbfield' => 'classic_theme_color',
        'label' => themeTranslate('Theme Color Palette'),
        'type' => 'dropdown',
        'default' => 'custom',
        'data' => [
            ['warmgray', themeTranslate('Warm Gray (Default)')],
            ['minimalwhite', themeTranslate('Minimal White')],
            ['darkgray', themeTranslate('Dark Gray')],
            ['cleanblue', themeTranslate('Clean Blue')],
            ['warmlibrary', themeTranslate('Warm Library')],
            ['custom', themeTranslate('Custom Palette')]
        ]
    ],
    'palette-custom' => [
        'dbfield' => 'classic_palette_custom',
        'label' => themeTranslate('Custom Palette Colors'),
        'type' => 'longtext',
        'default' => '#0B4F54; #5C8374; #F2994A; #F4F6F8; #FFFFFF; #1C1E21; #B0B7BD | #1A2E40; #B38F4D; #D9534F; #101318; #161A22; #F4F6F8; #B6BEC8',
    ],
    'color-toggle' => [
        'dbfield' => 'classic_color_toggle',
        'label' => themeTranslate('Dark/Light Mode Button'),
        'type' => 'dropdown',
        'default' => 'auto_show',
        'data' => [
            ['auto_show', themeTranslate('Auto - Show Button (System Mode)')],
            ['auto_hide', themeTranslate('Auto - Hide Button (System Mode)')],
            ['dark_show', themeTranslate('Default Dark - Show Button')],
            ['dark_hide', themeTranslate('Default Dark - Hide Button')],
            ['light_show', themeTranslate('Default Light - Show Button')],
            ['light_hide', themeTranslate('Default Light - Hide Button')]
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
        'label' => themeTranslate('Theme Font'),
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
        'label' => themeTranslate('Back to Top Button'),
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
        'label' => __('Deskripsi Singkat WhatsApp (Format: nama_orang; pesan singkat)'),
        'type' => 'longtext',
        'default' => 'Pustakawan; Halo, silakan ketik pesan Anda langsung di kolom bawah. Agar kami dapat membantu lebih cepat, tuliskan nama, nomor anggota (jika ada), lalu pertanyaan Anda.'
    ],
    'whatsapp-categories' => [
        'dbfield' => 'classic_whatsapp_categories',
        'label' => __('Template Pesan WhatsApp (pisahkan field dengan titik koma, contoh: Nama; Nomor Anggota (opsional); Pertanyaan)'),
        'type' => 'longtext',
        'default' => 'Nama; Nomor Anggota (opsional); Pertanyaan'
    ],
];
