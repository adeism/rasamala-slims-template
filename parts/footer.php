<?php
# @Author: Waris Agung Widodo <user>
# @Date:   2018-01-23T11:26:05+07:00
# @Email:  ido.alit@gmail.com
# @Filename: footer.php
# @Last modified by:   Ade Ismail Siregar (adeismailbox@gmail.com)
# @Last modified time: 2026-07-09T14:04:51+07:00
?>


<?php
$is_homepage = !isset($_GET['p']) && !isset($_GET['search']);
$is_hero_only = ($sysconf['template']['classic_homepage_only_hero'] ?? 0) == 1;
$show_footer = ($sysconf['template']['classic_footer_show'] ?? 1) && !($is_homepage && $is_hero_only);
?>
<?php if ($show_footer): ?>
<footer class="py-5 border-top">
    <div class="container">
        <div class="row py-4">
            <div class="col-md-3">
              <?php
              if(isset($sysconf['logo_image']) && $sysconf['logo_image'] != '' && $imagesDisk->isExists($path = 'default/'.$sysconf['logo_image'])){
                echo '<img class="footer-brand-img" src="'.SWB . 'lib/minigalnano/createthumb.php?filename=images/' . $path.'&width=350">';
              }
              elseif (file_exists(__DIR__ . '/../assets/images/logo.png')) {
                echo '<img class="footer-brand-img" src="' . assets(v('images/logo.png')) . '">';
              } else {
                ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-book mb-2 footer-book-icon" viewBox="0 0 16 16">
                    <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.933-.575-2.202-.954-3.41-1.11-1.226-.157-2.484-.013-3.388.337zm11-.14c.654-.689 1.782-.886 3.11-.752 1.234.124 2.503.523 3.388.893v9.923c-.904-.35-2.162-.494-3.388-.337-1.208.156-2.477.535-3.409 1.11V2.688zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783"/>
                </svg>
              <?php } ?>
                <div class="mb-3 font-weight-bold footer-section-title footer-library-name"><?php echo themeEscape($sysconf['library_name']); ?></div>
                <ul class="list-unstyled">
                    <li class="mb-2"><a class="footer-link" href="index.php?p=libinfo"><?= __('Information'); ?></a></li>
                    <li class="mb-2"><a class="footer-link" href="index.php?p=services"><?= __('Services'); ?></a></li>
                    <li class="mb-2"><a class="footer-link" href="index.php?p=librarian"><?= __('Librarian'); ?></a></li>
                    <li class="mb-2"><a class="footer-link" href="index.php?p=member"><?= __('Member Area'); ?></a></li>
                </ul>
            </div>
            <div class="col-md-5 pt-4 pt-md-0">
                <h6 class="mb-3 font-weight-bold text-uppercase tracking-wider footer-section-title"><?= __('About Us'); ?></h6>
                <div class="footer-about-text">
                    <?= themeSanitizeHtml($sysconf['template']['classic_footer_about_us'] ?? ''); ?>
                </div>
            </div>
            <div class="col-md-4 pt-4 pt-md-0">
                <h6 class="mb-3 font-weight-bold text-uppercase tracking-wider footer-section-title"><?= __('Search'); ?></h6>
                <div class="mb-3 detail-link-btn"><?= __('start it by typing one or more keywords for title, author or subject'); ?></div>
                <form action="index.php">
                    <input type="hidden" ref="csrf_token" value="<?= themeEscape($_SESSION['csrf_token']??'') ?>">
                    <input type="hidden" name="csrf_token" value="<?= themeEscape($_SESSION['csrf_token']??'') ?>">
                    <div class="input-group mb-3">
                        <input name="keywords" type="text" class="form-control footer-search-input"
                               placeholder="<?= __('Enter keywords'); ?>"
                               aria-label="Enter keywords"
                               aria-describedby="button-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary footer-search-btn" type="submit" value="search" name="search"
                                    id="button-addon2"><?= __('Find'); ?>
                            </button>
                        </div>
                    </div>
                </form>
                <hr class="apple-divider">
                <a target="_blank" rel="noopener noreferrer" title="Support Us" class="btn btn-outline-secondary btn-sm mr-2 mb-2 px-3 footer-action-btn"
                   href="https://slims.web.id/web/pages/support-us/"><i
                            class="fas fa-heart mr-2 text-danger"></i><?= __('Keep SLiMS Alive'); ?></a>
                <a target="_blank" rel="noopener noreferrer" title="Contribute" class="btn btn-outline-secondary btn-sm mb-2 px-3 footer-action-btn"
                   href="https://github.com/slims/"><i
                            class="fab fa-github mr-2"></i><?= __('Contribute'); ?></a>
            </div>
        </div>
        <hr class="apple-divider my-4">
        <div class="d-flex flex-wrap font-weight-light small justify-content-between align-items-center">
            <p class="m-0">&copy; <?php echo date('Y'); ?> &mdash; <?= themeEscape($sysconf['template']['classic_footer_copyright'] ?? 'Senayan Developer Community'); ?></p>
            <div class="text-right"><?= __('Powered by '); ?><code>SLiMS</code></div>
        </div>
    </div>
</footer>
<?php endif; ?>

<?php if ($sysconf['chat_system']['enabled'] && $sysconf['chat_system']['opac']) : ?>
    <div id="show-pchat2" class="shadow rounded floating-chat-trigger">
        <button title="Chat" class="btn btn-primary"><i class="fas fa-comments mr-2"></i><?= __('Chat'); ?></button>
    </div>
<?php endif; ?>

<?php
// Chat Engine
include LIB . "contents/chat.php"; ?>

<!-- // Load modal -->
<?php include "_modal_topic.php"; ?>
<?php include "_modal_advanced.php"; ?>
<?php include "_modal_social_media.php"; ?>

<!-- // Load highlight -->
<script src="<?= themeEscape(JWB); ?>highlight.js"></script>
<?php if(isset($engine) && $searchableInJsArray = $this->generateKeywords($engine->searchable_fields)) : ?>
<script>
  $('.card-body > *').highlight(<?= $searchableInJsArray ?>);
</script>
<?php endif; ?>

<!-- // load our vue app.js -->
<script src="<?php echo assets(v('js/app.js')); ?>"></script>
<script src="<?php echo assets(v('js/app_jquery.js')); ?>"></script>

<?php
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
    'login' => 'fas fa-user-shield',
    'member' => 'fas fa-user',
    'basket' => 'fas fa-shopping-basket',
    'language' => 'fas fa-language',
];

$mobile_language_links = [];
$current_mobile_language = [
    'code' => '',
    'name' => __('Language'),
];
if (($sysconf['template']['classic_language_select'] ?? 1) == 1 && !empty($available_languages)) {
    $select_lang = $_COOKIE['select_lang'] ?? $sysconf['default_lang'];
    foreach ($available_languages as $lang_index) {
        $lang_code = $lang_index[0] ?? '';
        $lang_name = $lang_index[1] ?? $lang_code;
        $code_arr = explode('_', (string)$lang_code);
        $code_flag = strtolower($code_arr[1] ?? $code_arr[0] ?? '');
        $code_flag = preg_replace('/[^a-z]/', '', $code_flag);
        $is_active_lang = $lang_code === $select_lang;

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
                <span class="flag-icon flag-icon-<?= themeEscape($current_mobile_language['code']) ?> flag-icon-rounded mobile-bottom-language-flag"></span>
                <?php else: ?>
                <i class="<?= $icon ?>"></i>
                <?php endif; ?>
                <?php if ($badge > 0): ?>
                    <span class="badge badge-danger position-absolute basket-badge-mobile"><?= themeEscape($badge) ?></span>
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
                    <i class="<?= $icon ?>"></i> <?= $text ?>
                </a>
                <?php
            }
            ?>
            <?php if (!empty($mobile_language_links)): ?>
            <div class="mobile-language-section">
                <div class="mobile-language-title">
                    <i class="fas fa-language"></i>
                    <span><?= themeEscape(__('Select Language')); ?></span>
                </div>
                <div class="mobile-language-select-wrap">
                    <?php if (!empty($current_mobile_language['code'])): ?>
                    <span class="flag-icon flag-icon-<?= themeEscape($current_mobile_language['code']); ?> flag-icon-rounded mobile-language-current-flag"></span>
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

<?php
$show_home_display_footer = ($sysconf['template']['classic_home_display_show'] ?? 'below') === 'bottom';
$show_ticker_footer = ($sysconf['template']['classic_ticker_show'] ?? 0) === 'bottom';

$latest_content_ticker_items = [];
$home_display_footer_items = [];

include_once __DIR__ . '/../theme_helpers.php';

if ($dbs && function_exists('themeGetDisplayItems')) {
    if ($show_ticker_footer) {
        $ticker_limit = themeSafeLimit($sysconf['template']['classic_ticker_item_limit'] ?? 5, 5, 1, 12);
        $ticker_char_limit = themeSafeInt($sysconf['template']['classic_ticker_char_limit'] ?? 48, 48, 12, 160);
        $source = $sysconf['template']['classic_ticker_source'] ?? 'content';
        $content_filter = $sysconf['template']['classic_ticker_content_filter'] ?? 'all';
        $content_detail = $sysconf['template']['classic_ticker_content_detail'] ?? 'title';
        $biblio_filter = $sysconf['template']['classic_ticker_biblio_filter'] ?? 'all';

        $latest_content_ticker_items = themeGetDisplayItems(
            $dbs,
            $source,
            $content_filter,
            $content_detail,
            $biblio_filter,
            $ticker_limit,
            $ticker_char_limit
        );
    }

    if ($show_home_display_footer) {
        $home_limit = themeSafeLimit($sysconf['template']['classic_home_item_limit'] ?? 5, 5, 1, 12);
        $home_char_limit = themeSafeInt($sysconf['template']['classic_home_char_limit'] ?? 48, 48, 12, 160);
        $source = $sysconf['template']['classic_home_display_source'] ?? 'content';
        $content_filter = $sysconf['template']['classic_home_display_content_filter'] ?? 'all';
        $content_detail = $sysconf['template']['classic_home_display_content_detail'] ?? 'title';
        $biblio_filter = $sysconf['template']['classic_home_display_biblio_filter'] ?? 'all';

        $home_display_footer_items = themeGetDisplayItems(
            $dbs,
            $source,
            $content_filter,
            $content_detail,
            $biblio_filter,
            $home_limit,
            $home_char_limit
        );
    }
}
?>

<?php if (!empty($latest_content_ticker_items)) : ?>
    <div class="latest-content-ticker" role="status">
        <div class="latest-content-ticker-track">
            <?php for ($ticker_repeat = 0; $ticker_repeat < 2; $ticker_repeat++) : ?>
                <div class="latest-content-ticker-group" <?= $ticker_repeat === 1 ? 'aria-hidden="true"' : '' ?>>
                    <?php foreach ($latest_content_ticker_items as $latest_content_ticker_item) : ?>
                        <a class="latest-content-ticker-item"
                           href="<?= themeEscape($latest_content_ticker_item['url']); ?>"
                           title="<?= themeEscape($latest_content_ticker_item['title']); ?>">
                            <i class="fas fa-volume-up latest-content-icon" aria-hidden="true"></i>
                            <span class="latest-content-title"><?= themeEscape($latest_content_ticker_item['display_title']); ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endfor; ?>
        </div>
    </div>
<?php endif; ?>

<?php if (!empty($home_display_footer_items)) : ?>
    <div class="latest-content-strip">
        <ul class="latest-content-list">
            <?php foreach ($home_display_footer_items as $item) : ?>
                <li>
                    <a class="latest-content-link"
                       href="<?= themeEscape($item['url']); ?>"
                       title="<?= themeEscape($item['title']); ?>">
                        <i class="fas fa-volume-up latest-content-icon" aria-hidden="true"></i>
                        <span class="latest-content-title"><?= themeEscape($item['display_title']); ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php
$show_back_to_top = $sysconf['template']['classic_back_to_top'] ?? 1;
$show_floating_info = $sysconf['template']['classic_floating_info'] ?? 1;
$show_color_toggle = (int)($sysconf['template']['classic_color_toggle'] ?? 1) === 1;

$libinfo_title = __('Library Information');
$libinfo_desc = '';
if ($show_floating_info && isset($dbs) && $dbs) {
    $libinfo_query = $dbs->query("SELECT content_title, content_desc FROM content WHERE content_path='libinfo' AND is_draft=0 LIMIT 1");
    if ($libinfo_query && $libinfo_query->num_rows > 0) {
        $libinfo_data = $libinfo_query->fetch_assoc();
        $libinfo_title = $libinfo_data['content_title'];
        $libinfo_desc = $libinfo_data['content_desc'];
    }
}
?>

<?php if ($show_color_toggle): ?>
    <button id="color-mode-toggle"
            class="btn-color-mode-toggle shadow-lg <?= !empty($latest_content_ticker_items) ? 'has-latest-content-ticker' : '' ?>"
            title="<?= themeEscape(__('Dark mode')) ?>"
            data-dark-title="<?= themeEscape(__('Dark mode')) ?>"
            data-light-title="<?= themeEscape(__('Light mode')) ?>"
            aria-label="<?= themeEscape(__('Toggle dark/light mode')) ?>"
            aria-pressed="false">
        <i class="fas fa-moon" aria-hidden="true"></i>
    </button>
<?php endif; ?>

<?php if ($show_floating_info): ?>
    <button id="floating-info-btn" class="btn-floating-info shadow-lg <?= !empty($latest_content_ticker_items) ? 'has-latest-content-ticker' : '' ?>" data-toggle="modal" data-target="#libinfoModal" title="Library Info" aria-label="<?= themeEscape(__('Library Information')) ?>">
        <i class="fas fa-info-circle"></i>
    </button>

    <div class="modal fade" id="libinfoModal" tabindex="-1" role="dialog" aria-labelledby="libinfoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content libinfo-modal-content">
                <div class="modal-header libinfo-modal-header">
                    <h5 class="modal-title font-weight-bold text-uppercase tracking-wider libinfo-modal-title" id="libinfoModalLabel">
                        <?= htmlspecialchars($libinfo_title, ENT_QUOTES, 'UTF-8') ?>
                    </h5>
                    <button type="button" class="close libinfo-modal-close" data-dismiss="modal" aria-label="<?= themeEscape(__('Close')) ?>">
                        <span aria-hidden="true" class="libinfo-modal-close-icon">&times;</span>
                    </button>
                </div>
                <div class="modal-body libinfo-modal-body">
                    <div class="libinfo-content libinfo-modal-desc">
                        <?= themeSanitizeHtml($libinfo_desc) ?>
                    </div>
                </div>
                <div class="modal-footer libinfo-modal-footer">
                    <button type="button" class="btn btn-outline-cyan libinfo-modal-btn" data-dismiss="modal">
                        <?= __('Close') ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if ($show_back_to_top): ?>
    <button id="back-to-top" title="Go to top" class="btn-back-to-top shadow-lg <?= $show_floating_info ? 'has-floating-info' : '' ?> <?= !empty($latest_content_ticker_items) ? 'has-latest-content-ticker' : '' ?>" aria-label="<?= themeEscape(__('Go to top')) ?>">
        <i class="fas fa-chevron-up"></i>
    </button>
<?php endif; ?>


</body>
</html>
