<?php
# @Author: Waris Agung Widodo <user>
# @Date:   2026-07-16T10:08:00+07:00
# @Email:  ido.alit@gmail.com
# @Filename: mobile_bottom_nav.php
# @Last modified by:   Ade Ismail Siregar (adeismailbox@gmail.com)
# @Last modified time: 2026-07-16T10:08:00+07:00

// Bottom Navigation Bar for Mobile
$basket_count = isset($_SESSION['m_mark_biblio']) ? count($_SESSION['m_mark_biblio']) : 0;
$current_p = $_GET['p'] ?? 'home';

// Icon map for menus
$icon_map = [
    'home' => 'fas fa-home',
    'libinfo' => 'fas fa-info-circle',
    'news' => 'fas fa-newspaper',
    'help' => 'fas fa-question-circle',
    'librarian' => 'fas fa-users',
    'login' => 'fas fa-university',
    'member' => 'fas fa-user',
    'basket' => 'fas fa-shopping-basket',
    'language' => 'fas fa-language',
];

$mobile_language_links = [];
$current_mobile_language = [
    'code' => '',
    'name' => __('Language'),
];
if (!empty($available_languages)) {
    $select_lang = $_COOKIE['select_lang'] ?? $sysconf['default_lang'];
    foreach ($available_languages as $lang_index) {
        $lang_code = $lang_index[0] ?? '';
        if (function_exists('themeLanguageIsVisible') && !themeLanguageIsVisible($lang_code, $sysconf)) {
            continue;
        }
        $lang_name = $lang_index[1] ?? $lang_code;
        $code_arr = explode('_', (string)$lang_code);
        $code_flag = strtolower($code_arr[1] ?? $code_arr[0] ?? '');
        $code_flag = preg_replace('/[^a-z]/', '', $code_flag);
        $is_active_lang = $lang_code === $select_lang;

        if ($current_mobile_language['code'] === '') {
            $current_mobile_language = [
                'code' => $code_flag,
                'name' => $lang_name,
            ];
        }

        if ($is_active_lang) {
            $current_mobile_language = [
                'code' => $code_flag,
                'name' => $lang_name,
            ];
        }

        $mobile_language_links[] = [
            'code' => $lang_code,
            'flag' => $code_flag,
            'name' => $lang_name,
            'active' => $is_active_lang,
        ];
    }
}

// Build bottom navigation items based on main_menus configured for top navbar
$bottom_items = [];
if (isset($main_menus) && is_array($main_menus)) {
    $bottom_items = $main_menus;
}

// Add Member Area to bottom items if it's enabled and not already in main menus
$has_member_in_main = false;
foreach ($bottom_items as $item) {
    if ($item['key'] === 'member') {
        $has_member_in_main = true;
        break;
    }
}
if (!$has_member_in_main && ($sysconf['template']['classic_member_area'] ?? 1) == 1) {
    $bottom_items[] = [
        'key' => 'member',
        'text' => __('Member Area'),
        'url' => 'index.php?p=member'
    ];
}

if (!empty($mobile_language_links)) {
    $bottom_items[] = [
        'key' => 'language',
        'text' => __('Language'),
        'url' => '#',
    ];
}

// Distribute items to primary bottom nav bar and bottom sheet menu
$primary_bottom_nav = [];
$sheet_bottom_nav = [];
$total_nav_count = count($bottom_items);

if ($basket_count > 0) {
    if ($total_nav_count <= 4) {
        $primary_bottom_nav = $bottom_items;
        $primary_bottom_nav[] = [
            'key' => 'basket',
            'text' => __('Basket'),
            'url' => 'index.php?p=member&sec=title_basket',
            'badge' => $basket_count
        ];
    } else {
        $primary_bottom_nav = array_slice($bottom_items, 0, 4);
        $primary_bottom_nav[] = [
            'key' => 'more',
            'text' => __('More'),
            'url' => '#',
            'badge' => $basket_count
        ];
        $sheet_bottom_nav = array_slice($bottom_items, 4);
        $sheet_bottom_nav[] = [
            'key' => 'basket',
            'text' => __('Basket') . ' (' . $basket_count . ')',
            'url' => 'index.php?p=member&sec=title_basket',
            'badge' => $basket_count
        ];
    }
} else {
    if ($total_nav_count <= 5) {
        $primary_bottom_nav = $bottom_items;
    } else {
        $primary_bottom_nav = array_slice($bottom_items, 0, 4);
        $primary_bottom_nav[] = [
            'key' => 'more',
            'text' => __('More'),
            'url' => '#'
        ];
        $sheet_bottom_nav = array_slice($bottom_items, 4);
    }
}
?>

<?php if (($sysconf['template']['classic_mobile_bottom_nav_show'] ?? 1) == 1) : ?>
<div class="mobile-bottom-nav d-md-none">
    <?php
    foreach ($primary_bottom_nav as $item) {
        $key = $item['key'];
        $url = themeEscape(themeSafeHref($item['url'] ?? '#'));
        $text = themeEscape(__($item['text'] ?? ''));
        $icon = themeEscape(themeNavbarMenuIconClass($item, $icon_map[$key] ?? 'fas fa-link'));

        // Active state detection
        $active_class = '';
        if ($key === 'more' || $key === 'language') {
            $active_class = '';
        } elseif ($key === 'home') {
            $active_class = ($current_p === 'home' && !isset($_GET['search'])) ? 'active' : '';
        } elseif ($key === 'basket') {
            $active_class = ($current_p === 'member' && ($_GET['sec'] ?? '') === 'title_basket') ? 'active' : '';
        } else {
            $active_class = ($current_p === $key) ? 'active' : '';
        }

        $item_id = $key === 'more' ? 'id="mobile-more-btn"' : '';
        $trigger_attr = ($key === 'more' || $key === 'language') ? 'data-mobile-more-trigger="1"' : '';
        $badge = themeSafeInt($item['badge'] ?? 0);
        ?>
        <a href="<?= $url ?>" <?= $item_id ?> <?= $trigger_attr ?> class="nav-item <?= themeEscape($active_class) ?>">
            <div class="position-relative">
                <?php if ($key === 'language' && !empty($current_mobile_language['code'])): ?>
                <span class="flag-icon flag-icon-<?= themeEscape($current_mobile_language['code']) ?> flag-icon-rounded mobile-bottom-language-flag" aria-hidden="true"></span>
                <?php else: ?>
                <i class="<?= $icon ?>" aria-hidden="true"></i>
                <?php endif; ?>
                <?php if ($badge > 0): ?>
                    <span class="badge text-bg-danger position-absolute basket-badge-mobile"><?= themeEscape($badge) ?></span>
                <?php endif; ?>
            </div>
            <span><?= $text ?></span>
        </a>
        <?php
    }
    ?>
</div>
<?php endif; ?>

<?php if (!empty($sheet_bottom_nav) || !empty($mobile_language_links)): ?>
<!-- Mobile More Menu Overlay Bottom Sheet -->
<div id="mobile-more-menu-overlay" class="mobile-more-menu-overlay d-md-none">
    <div class="mobile-more-menu-sheet">
        <div class="mobile-more-menu-header">
            <span class="mobile-more-menu-title"><?= themeEscape(__('More Menu')) ?></span>
            <button id="close-mobile-more-menu" class="mobile-more-menu-close" aria-label="<?= themeEscape(__('Close')) ?>">&times;</button>
        </div>
        <div class="mobile-more-menu-body">
            <?php
            foreach ($sheet_bottom_nav as $item) {
                $key = $item['key'];
                if ($key === 'language') {
                    continue;
                }
                $url = themeEscape(themeSafeHref($item['url'] ?? '#'));
                $text = themeEscape(__($item['text'] ?? ''));
                $icon = themeEscape(themeNavbarMenuIconClass($item, $icon_map[$key] ?? 'fas fa-link'));

                $active_class = '';
                if ($key === 'basket') {
                    $active_class = ($current_p === 'member' && ($_GET['sec'] ?? '') === 'title_basket') ? 'text-primary' : '';
                } else {
                    $active_class = ($current_p === $key) ? 'text-primary' : '';
                }

                ?>
                <a href="<?= $url ?>" class="mobile-more-item <?= themeEscape($active_class) ?>">
                    <i class="<?= $icon ?>" aria-hidden="true"></i> <?= $text ?>
                </a>
                <?php
            }
            ?>
            <?php if (!empty($mobile_language_links)): ?>
            <div class="mobile-language-section">
                <div class="mobile-language-title">
                    <i class="fas fa-language" aria-hidden="true"></i>
                    <span><?= themeEscape(__('Select Language')); ?></span>
                </div>
                <div class="mobile-language-select-wrap">
                    <?php if (!empty($current_mobile_language['code'])): ?>
                    <span class="flag-icon flag-icon-<?= themeEscape($current_mobile_language['code']); ?> flag-icon-rounded mobile-language-current-flag" aria-hidden="true"></span>
                    <?php endif; ?>
                    <select class="form-control mobile-language-select" aria-label="<?= themeEscape(__('Select Language')); ?>" onchange="if (this.value) window.location.href = 'index.php?select_lang=' + encodeURIComponent(this.value);">
                        <?php foreach ($mobile_language_links as $mobile_language): ?>
                        <option value="<?= themeEscape($mobile_language['code']); ?>" <?= $mobile_language['active'] ? 'selected' : '' ?>>
                            <?= themeEscape($mobile_language['name']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>
