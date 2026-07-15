<?php
# @Author: Waris Agung Widodo <user>
# @Date:   2018-01-25T10:31:54+07:00
# @Email:  ido.alit@gmail.com
# @Filename: _search-form.php
# @Last modified by:   Ade Ismail Siregar (adeismailbox@gmail.com)
# @Last modified time: 2026-07-15T08:25:01+07:00

if ($opac->invalid_token) {
    //die($opac->error('invalid CSRF token'));
}
?>
<?php
$search_size = $sysconf['template']['classic_search_size'] ?? 'medium';
if (!in_array($search_size, ['small', 'medium', 'large'], true)) {
    $search_size = 'medium';
}
$hero_text = trim((string)($sysconf['template']['classic_hero_text'] ?? ''));
$hero_text_size = $sysconf['template']['classic_hero_text_size'] ?? 'small';
if (!in_array($hero_text_size, ['small', 'medium', 'large'], true)) {
    $hero_text_size = 'small';
}
$is_homepage_search = !isset($_GET['p']) && !isset($_GET['search']);
$show_hero_text = $is_homepage_search && $hero_text !== '';
$latest_content_display = strtolower(trim((string)themeEffectiveTemplateValue('classic_home_display_show', 'below', $sysconf)));
if ($latest_content_display === '1') {
    $latest_content_display = 'below';
} elseif ($latest_content_display === 'show') {
    $latest_content_display = 'below';
} elseif ($latest_content_display === '0') {
    $latest_content_display = 'hide';
}
if (!in_array($latest_content_display, ['below', 'bottom', 'hide'], true)) {
    $latest_content_display = 'below';
}
$show_latest_content = $is_homepage_search && $latest_content_display === 'below';
$latest_content_items = [];
$ticker_items_below = [];

if (isset($dbs) && $dbs) {
    include_once __DIR__ . '/../theme_helpers.php';
    if (function_exists('themeGetDisplayItems')) {
        if ($show_latest_content) {
            $home_limit = themeSafeLimit($sysconf['template']['classic_home_item_limit'] ?? 5, 5, 1, 12);
            $raw_home_limit = (int)($sysconf['template']['classic_home_char_limit'] ?? 48);
            $home_char_limit = ($raw_home_limit === 0) ? 0 : themeSafeInt($raw_home_limit, 48, 12, 160);
            $source = $sysconf['template']['classic_home_display_source'] ?? 'content';
            $content_filter = $sysconf['template']['classic_home_display_content_filter'] ?? 'all';
            $content_detail = $sysconf['template']['classic_home_display_content_detail'] ?? 'title';
            $biblio_filter = $sysconf['template']['classic_home_display_biblio_filter'] ?? 'all';

            $latest_content_items = themeGetDisplayItems(
                $dbs,
                $source,
                $content_filter,
                $content_detail,
                $biblio_filter,
                $home_limit,
                $home_char_limit
            );
        }

        $show_ticker_below = $is_homepage_search && themeEffectiveTemplateValue('classic_ticker_show', 0, $sysconf) === 'below';
        if ($show_ticker_below) {
            $ticker_limit = themeSafeLimit($sysconf['template']['classic_ticker_item_limit'] ?? 5, 5, 1, 12);
            $raw_ticker_limit = (int)($sysconf['template']['classic_ticker_char_limit'] ?? 48);
            $ticker_char_limit = ($raw_ticker_limit === 0) ? 0 : themeSafeInt($raw_ticker_limit, 48, 12, 160);
            $source = $sysconf['template']['classic_ticker_source'] ?? 'content';
            $content_filter = $sysconf['template']['classic_ticker_content_filter'] ?? 'all';
            $content_detail = $sysconf['template']['classic_ticker_content_detail'] ?? 'title';
            $biblio_filter = $sysconf['template']['classic_ticker_biblio_filter'] ?? 'all';

            $ticker_speed = themeEffectiveTemplateValue('classic_ticker_speed', 'normal', $sysconf);
            $ticker_items_below = themeGetDisplayItems(
                $dbs,
                $source,
                $content_filter,
                $content_detail,
                $biblio_filter,
                $ticker_limit,
                $ticker_char_limit
            );
        }
    }
}
$col_class = 'col-lg-8';
$card_body_style = 'padding: 12px 24px !important;';
$input_font_style = 'font-size: 16px;';
$icon_font_style = 'font-size: 18px;';

if ($search_size === 'small') {
    $col_class = 'col-lg-8';
    $card_body_style = 'padding: 8px 16px !important;';
    $input_font_style = 'font-size: 14px;';
    $icon_font_style = 'font-size: 16px;';
} elseif ($search_size === 'large') {
    $col_class = 'col-lg-10';
    $card_body_style = 'padding: 22px 36px !important;';
    $input_font_style = 'font-size: 22px;';
    $icon_font_style = 'font-size: 26px;';
}
?>

<div class="search position-relative search-size-<?= themeEscape($search_size) ?> <?= themeHomepageOnlyHero($sysconf) ? 'mt-0' : '' ?>" id="search-wraper">
    <div class="container">
        <div class="row">
            <div class="<?= themeEscape($col_class) ?> mx-auto">
                <?php if ((int)themeEffectiveTemplateValue('classic_announcement_show', 0, $sysconf) === 1 && !empty($sysconf['template']['classic_announcement_text'])) : ?>
                <div class="alert alert-<?= themeEscape($sysconf['template']['classic_announcement_style'] ?? 'info'); ?> alert-dismissible fade show shadow-sm px-4 mb-4 text-center rounded-3" role="alert">
                    <?= themeSanitizeHtml($sysconf['template']['classic_announcement_text']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="top: 50%; transform: translateY(-50%); right: 15px; padding: 0; position: absolute;"></button>
                </div>
                <?php endif; ?>
                <?php if ($show_hero_text) : ?>
                <div class="hero-search-heading hero-search-heading-<?= themeEscape($hero_text_size) ?> text-center">
                    <h1><?= themeEscape($hero_text); ?></h1>
                </div>
                <?php endif; ?>
                <div class="position-relative">
                    <div class="card border-0 shadow-sm rounded-pill">
                        <div class="card-body">
                            <form id="search-form" class="d-flex align-items-center" action="index.php" method="get" @submit.prevent="searchSubmit">
                                <input type="hidden" name="search" value="search">
                                <input ref="keywords" value="<?= themeEscape(getQuery('keywords')) ?>" v-model.trim="keywords"
                                       type="text" id="search-input"
                                       name="keywords" class="input-transparent flex-grow-1" autocomplete="off"
                                       placeholder="<?= themeEscape(__($sysconf['template']['classic_search_placeholder'] ?? 'Enter keyword to search collection...'));?>"/>
                                <div class="d-flex align-items-center ms-2">
                                    <!-- Advanced Search Icon -->
                                    <a href="javascript:void(0)" class="me-3" data-bs-toggle="modal" data-bs-target="#adv-modal" title="<?= themeEscape(__('Advanced Search')) ?>" aria-label="<?= themeEscape(__('Advanced Search')) ?>">
                                        <i class="fas fa-sliders-h"></i>
                                    </a>
                                    <!-- Search Button -->
                                    <button type="submit" class="btn p-0 border-0 bg-transparent" aria-label="<?= themeEscape(__('Search')) ?>">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php if (!empty($ticker_items_below) && $show_ticker_below) : ?>
                <div class="latest-content-ticker mt-3 mb-2" data-speed="<?= themeEscape($ticker_speed); ?>" role="status">
                    <div class="latest-content-ticker-track">
                        <?php for ($ticker_repeat = 0; $ticker_repeat < 2; $ticker_repeat++) : ?>
                            <div class="latest-content-ticker-group" <?= $ticker_repeat === 1 ? 'aria-hidden="true"' : '' ?>>
                                <?php foreach ($ticker_items_below as $ticker_item) : ?>
                                    <a class="latest-content-ticker-item"
                                       href="<?= themeEscape($ticker_item['url']); ?>"
                                       title="<?= themeEscape($ticker_item['title']); ?>">
                                        <i class="fas fa-volume-up latest-content-icon" aria-hidden="true"></i>
                                        <span class="latest-content-title"><?= themeEscape($ticker_item['display_title']); ?></span>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (!empty($latest_content_items) && $latest_content_display === 'below') : 
                    $home_display_style = themeEffectiveTemplateValue('classic_home_display_style', 'badges', $sysconf);
                ?>
                <div class="latest-content-strip latest-content-style-<?= themeEscape($home_display_style); ?>">
                    <?php if ($home_display_style === 'fade') : ?>
                        <div class="latest-content-fade-slider" id="hero-info-fade-slider">
                            <?php foreach ($latest_content_items as $index => $latest_content_item) : ?>
                            <div class="latest-content-fade-item <?= $index === 0 ? 'active' : '' ?>">
                                <a class="latest-content-link"
                                   href="<?= themeEscape($latest_content_item['url']); ?>"
                                   title="<?= themeEscape($latest_content_item['title']); ?>">
                                    <i class="fas fa-volume-up latest-content-icon" aria-hidden="true"></i>
                                    <span class="latest-content-title"><?= themeEscape($latest_content_item['display_title']); ?></span>
                                </a>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var slider = document.getElementById('hero-info-fade-slider');
                            if (!slider) return;
                            var items = slider.querySelectorAll('.latest-content-fade-item');
                            if (items.length <= 1) return;
                            var activeIndex = 0;
                            setInterval(function() {
                                items[activeIndex].classList.remove('active');
                                activeIndex = (activeIndex + 1) % items.length;
                                items[activeIndex].classList.add('active');
                            }, 4000);
                        });
                        </script>
                    <?php elseif ($home_display_style === 'ticker') : ?>
                        <div class="latest-content-ticker mt-1 mb-1" data-speed="normal" role="status">
                            <div class="latest-content-ticker-track">
                                <?php for ($ticker_repeat = 0; $ticker_repeat < 2; $ticker_repeat++) : ?>
                                    <div class="latest-content-ticker-group" <?= $ticker_repeat === 1 ? 'aria-hidden="true"' : '' ?>>
                                        <?php foreach ($latest_content_items as $ticker_item) : ?>
                                            <a class="latest-content-ticker-item"
                                               href="<?= themeEscape($ticker_item['url']); ?>"
                                               title="<?= themeEscape($ticker_item['title']); ?>">
                                                <i class="fas fa-volume-up latest-content-icon" aria-hidden="true"></i>
                                                <span class="latest-content-title"><?= themeEscape($ticker_item['display_title']); ?></span>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    <?php else : 
                        $scroll_class = (count($latest_content_items) > 3) ? 'scrollable' : '';
                    ?>
                        <ul class="latest-content-list <?= $scroll_class; ?>">
                            <?php foreach ($latest_content_items as $latest_content_item) : ?>
                            <li>
                                <a class="latest-content-link"
                                   href="<?= themeEscape($latest_content_item['url']); ?>"
                                   title="<?= themeEscape($latest_content_item['title']); ?>">
                                    <i class="fas fa-volume-up latest-content-icon" aria-hidden="true"></i>
                                    <span class="latest-content-title"><?= themeEscape($latest_content_item['display_title']); ?></span>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
