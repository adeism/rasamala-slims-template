<?php
# @Author: Waris Agung Widodo <user>
# @Date:   2018-01-25T10:31:54+07:00
# @Email:  ido.alit@gmail.com
# @Filename: _search-form.php
# @Last modified by:   Ade Ismail Siregar (adeismailbox@gmail.com)
# @Last modified time: 2026-07-08T15:13:46+07:00

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
$latest_content_display = strtolower(trim((string)($sysconf['template']['classic_home_display_show'] ?? 'below')));
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
            $home_char_limit = themeSafeInt($sysconf['template']['classic_home_char_limit'] ?? 48, 48, 12, 160);
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

        $show_ticker_below = $is_homepage_search && ($sysconf['template']['classic_ticker_show'] ?? 0) === 'below';
        if ($show_ticker_below) {
            $ticker_limit = themeSafeLimit($sysconf['template']['classic_ticker_item_limit'] ?? 5, 5, 1, 12);
            $ticker_char_limit = themeSafeInt($sysconf['template']['classic_ticker_char_limit'] ?? 48, 48, 12, 160);
            $source = $sysconf['template']['classic_ticker_source'] ?? 'content';
            $content_filter = $sysconf['template']['classic_ticker_content_filter'] ?? 'all';
            $content_detail = $sysconf['template']['classic_ticker_content_detail'] ?? 'title';
            $biblio_filter = $sysconf['template']['classic_ticker_biblio_filter'] ?? 'all';

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

<div class="search position-relative search-size-<?= themeEscape($search_size) ?> <?= ($sysconf['template']['classic_homepage_only_hero'] ?? 0) == 1 ? 'mt-0' : '' ?>" id="search-wraper">
    <div class="container">
        <div class="row">
            <div class="<?= themeEscape($col_class) ?> mx-auto">
                <?php if (($sysconf['template']['classic_announcement_show'] ?? 0) == 1 && !empty($sysconf['template']['classic_announcement_text'])) : ?>
                <div class="alert alert-<?= themeEscape($sysconf['template']['classic_announcement_style'] ?? 'info'); ?> alert-dismissible fade show shadow-sm px-4 mb-4 text-center rounded-lg" role="alert">
                    <?= themeSanitizeHtml($sysconf['template']['classic_announcement_text']); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="top: 50%; transform: translateY(-50%); right: 15px; padding: 0;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php endif; ?>
                <?php if ($show_hero_text) : ?>
                <div class="hero-search-heading hero-search-heading-<?= themeEscape($hero_text_size) ?> text-center">
                    <h1><?= themeEscape($hero_text); ?></h1>
                </div>
                <?php endif; ?>
                <div class="card border-0 shadow-sm rounded-pill">
                    <div class="card-body">
                        <form id="search-form" class="d-flex align-items-center" action="index.php" method="get" @submit.prevent="searchSubmit">
                            <input type="hidden" name="search" value="search">
                            <input ref="keywords" value="<?= themeEscape(getQuery('keywords')) ?>" v-model.trim="keywords"
                                   @focus="searchOnFocus" @blur="searchOnBlur" @click="show = true" type="text" id="search-input"
                                   name="keywords" class="input-transparent flex-grow-1" autocomplete="off"
                                   placeholder="<?= themeEscape(__($sysconf['template']['classic_search_placeholder'] ?? 'Enter keyword to search collection...'));?>"/>
                            <div class="d-flex align-items-center ml-2">
                                <!-- Advanced Search Icon -->
                                <a href="javascript:void(0)" class="mr-3" data-toggle="modal" data-target="#adv-modal" title="<?= themeEscape(__('Advanced Search')) ?>" aria-label="<?= themeEscape(__('Advanced Search')) ?>">
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
                <?php if (!empty($ticker_items_below) && $show_ticker_below) : ?>
                <div class="latest-content-ticker mt-3 mb-2" role="status">
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

                <?php if (!empty($latest_content_items) && $latest_content_display === 'below') : ?>
                <div class="latest-content-strip">
                    <ul class="latest-content-list">
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
                </div>
                <?php endif; ?>
                <transition name="slide-fade">
                    <div v-if="show" class="advanced-wraper shadow-sm mt-3 p-4" id="advanced-wraper" v-click-outside="hideSearch">
                        <p class="label mb-3 font-weight-bold search-suggest-label">
                            <?= __('Search by :');?>
                            <i @click="hideSearch" @keyup.enter="hideSearch" role="button" tabindex="0" aria-label="<?= themeEscape(__('Close')) ?>" class="far fa-times-circle float-right text-danger cursor-pointer search-clear-history-icon"></i>
                        </p>
                        <div class="d-flex flex-wrap">
                            <a v-bind:class="{'btn-primary text-white': searchBy === 'keywords', 'btn-outline-secondary': searchBy !== 'keywords' }"
                               @click="searchOnClick('keywords')" class="btn mr-2 mb-2 btn-sm px-3 search-type-btn"><?= __('ALL')?></a>
                            <a v-bind:class="{'btn-primary text-white': searchBy === 'author', 'btn-outline-secondary': searchBy !== 'author' }"
                               @click="searchOnClick('author')" class="btn mr-2 mb-2 btn-sm px-3 search-type-btn"><?= __('Author');?></a>
                            <a v-bind:class="{'btn-primary text-white': searchBy === 'subject', 'btn-outline-secondary': searchBy !== 'subject' }"
                               @click="searchOnClick('subject')" class="btn mr-2 mb-2 btn-sm px-3 search-type-btn"><?= __('Subject');?></a>
                            <a v-bind:class="{'btn-primary text-white': searchBy === 'isbn', 'btn-outline-secondary': searchBy !== 'isbn' }"
                               @click="searchOnClick('isbn')" class="btn mr-2 mb-2 btn-sm px-3 search-type-btn"><?= __('ISBN/ISSN');?></a>
                            <button class="btn btn-light mr-2 mb-2 btn-sm px-3 search-type-btn" disabled><?= __('OR TRY'); ?></button>
                            <a class="btn btn-outline-primary mr-2 mb-2 btn-sm px-3 search-type-btn" data-toggle="modal" data-target="#adv-modal"><?= __('Advanced Search');?></a>
                        </div>
                        <p v-if="lastKeywords.length > 0" class="label mt-3 mb-2 font-weight-bold search-suggest-label"><?= __('Last search:');?></p>
                        <a :href="historySearchUrl(k)"
                           class="d-flex align-items-center justify-content-between py-2 text-decoration-none"
                           v-for="k in lastKeywords" :key="k">
                           <span>
                               <i class="far fa-clock mr-2"></i>
                               <span class="font-italic text-sm">{{tmpObj[k].text}}</span>
                           </span>
                           <i class="fas fa-angle-right"></i>
                        </a>
                    </div>
                </transition>
            </div>
        </div>
    </div>
</div>
