<?php
/**
 * Rasamala Template - Options: Sections 4, 5, 6 (Running Text, Hero Info, Homepage Sections & Topics)
 */
if (!defined('INDEX_AUTH') || INDEX_AUTH != 1) {
  die("can not access this file directly");
}

return [
    // Section 4: Running Text Settings
    'ticker-show' => [
        'dbfield' => 'classic_ticker_show',
        'label' => themeTranslate('Running Text Position'),
        'type' => 'dropdown',
        'default' => 'bottom',
        'data' => [
            ['bottom', themeTranslate('Show')],
            [0, themeTranslate('Hide')]
        ]
    ],
    'ticker-source' => [
        'dbfield' => 'classic_ticker_source',
        'label' => themeTranslate('Running Text Source'),
        'type' => 'dropdown',
        'default' => 'content',
        'data' => [
            ['content', themeTranslate('Latest Content (News/Info)')],
            ['biblio', themeTranslate('Latest Bibliography (Books/Items)')],
            ['custom_ticker', themeTranslate('Custom Text (Manual Input)')]
        ]
    ],
    'ticker-custom-text' => [
        'dbfield' => 'classic_ticker_custom_text',
        'label' => themeTranslate('Custom Running Text'),
        'type' => 'text',
        'default' => 'Welcome to our library!'
    ],
    'ticker-content-filter' => [
        'dbfield' => 'classic_ticker_content_filter',
        'label' => themeTranslate('Running Text Content Filter'),
        'type' => 'dropdown',
        'default' => 'all',
        'data' => [
            ['all', themeTranslate('All Content')],
            ['news', themeTranslate('News Only')]
        ]
    ],
    'ticker-content-detail' => [
        'dbfield' => 'classic_ticker_content_detail',
        'label' => themeTranslate('Running Text Content Detail'),
        'type' => 'dropdown',
        'default' => 'title',
        'data' => [
            ['title', themeTranslate('Title Only')],
            ['detail', themeTranslate('Title and Content Excerpt')]
        ]
    ],
    'ticker-biblio-filter' => [
        'dbfield' => 'classic_ticker_biblio_filter',
        'label' => themeTranslate('Running Text Collection Filter'),
        'type' => 'dropdown',
        'default' => 'all',
        'data' => $coll_type_data ?? [['all', themeTranslate('All Collection Types')]]
    ],
    'ticker-speed' => [
        'dbfield' => 'classic_ticker_speed',
        'label' => themeTranslate('Running Text Speed'),
        'type' => 'dropdown',
        'default' => 'slow',
        'data' => [
            ['fast', themeTranslate('Fast (12s)')],
            ['normal', themeTranslate('Normal (18s)')],
            ['slow', themeTranslate('Slow (32s)')],
            ['very_slow', themeTranslate('Very Slow (52s)')]
        ]
    ],
    'ticker-item-limit' => [
        'dbfield' => 'classic_ticker_item_limit',
        'label' => themeTranslate('Running Text Item Limit'),
        'type' => 'text',
        'default' => 5
    ],
    'ticker-char-limit' => [
        'dbfield' => 'classic_ticker_char_limit',
        'label' => themeTranslate('Running Text Character Limit (0 for unlimited)'),
        'type' => 'text',
        'default' => 0
    ],

    // Section 5: Search Area Info Settings
    'home-display-show' => [
        'dbfield' => 'classic_home_display_show',
        'label' => themeTranslate('Hero Info Search Area Position'),
        'type' => 'dropdown',
        'default' => 'below',
        'data' => [
            ['below', themeTranslate('Show')],
            [0, themeTranslate('Hide')]
        ]
    ],
];
