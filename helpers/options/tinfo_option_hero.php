<?php
/**
 * Rasamala Template - Options: Section 3 (Hero & Search Bar Settings)
 */
if (!defined('INDEX_AUTH') || INDEX_AUTH != 1) {
  die("can not access this file directly");
}

return [
    'hero-text' => [
        'dbfield' => 'classic_hero_text',
        'label' => themeTranslate('Search Title Text'),
        'type' => 'text',
        'default' => 'Search Library Collection'
    ],
    'hero-text-size' => [
        'dbfield' => 'classic_hero_text_size',
        'label' => themeTranslate('Search Title Text Size'),
        'type' => 'dropdown',
        'default' => 'small',
        'data' => [
            ['small', themeTranslate('Small')],
            ['medium', themeTranslate('Medium')],
            ['large', themeTranslate('Large')]
        ]
    ],
    'search-size' => [
        'dbfield' => 'classic_search_size',
        'label' => themeTranslate('Search Box Size'),
        'type' => 'dropdown',
        'default' => 'medium',
        'data' => [
            ['small', themeTranslate('Small')],
            ['medium', themeTranslate('Medium')],
            ['large', themeTranslate('Large')]
        ]
    ],
    'search-placeholder' => [
        'dbfield' => 'classic_search_placeholder',
        'label' => themeTranslate('Search Placeholder'),
        'type' => 'text',
        'default' => 'Enter keyword to search collection...'
    ],
    'hero-background-animation' => [
        'dbfield' => 'classic_hero_background_animation',
        'label' => themeTranslate('Background Animation'),
        'type' => 'dropdown',
        'default' => 'neural-network',
        'data' => [
            ['none', themeTranslate('None')],
            ['particles', themeTranslate('Floating Glyphs')],
            ['rain', themeTranslate('Code Rain')],
            ['grid', themeTranslate('Moving Grid')],
            ['twinkle', themeTranslate('Twinkling Stars')],
            ['zen-ripples', themeTranslate('Zen Ripples')],
            ['neural-network', themeTranslate('Neural Network')],
            ['starfield-warp', themeTranslate('Starfield Warp')],
            ['floating-embers', themeTranslate('Floating Embers')]
        ]
    ],
    'background-animation-speed' => [
        'dbfield' => 'classic_background_animation_speed',
        'label' => themeTranslate('Background Animation Speed'),
        'type' => 'dropdown',
        'default' => 'normal',
        'data' => [
            ['slow', themeTranslate('Slow')],
            ['normal', themeTranslate('Normal')],
            ['fast', themeTranslate('Fast')]
        ]
    ],
    'cursor-particles' => [
        'dbfield' => 'classic_cursor_particles',
        'label' => themeTranslate('Cursor Particle Effect'),
        'type' => 'dropdown',
        'default' => 'auto',
        'data' => [
            ['auto', themeTranslate('Auto (Device Detection)')],
            ['low', themeTranslate('Light')],
            ['medium', themeTranslate('Medium')],
            ['high', themeTranslate('Optimal')],
            ['none', themeTranslate('Disabled')]
        ]
    ],
    'cursor-custom-icon' => [
        'dbfield' => 'classic_cursor_custom_icon',
        'label' => themeTranslate('Cursor Icon'),
        'type' => 'dropdown',
        'default' => 'default',
        'data' => [
            ['default', themeTranslate('Default Browser')],
            ['neon-comet', themeTranslate('Neon Comet')],
            ['pixel-sword', themeTranslate('Pixel Sword')],
            ['electric-bolt', themeTranslate('Electric Bolt')],
            ['ink-brush', themeTranslate('Ink Brush')],
            ['rainbow-ribbon', themeTranslate('Rainbow Ribbon')]
        ]
    ],
];
