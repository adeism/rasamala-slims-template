<?php
# @Author: Waris Agung Widodo <user>
# @Date:   2018-01-23T11:27:04+07:00
# @Email:  ido.alit@gmail.com
# @Filename: _home.php
# @Last modified by:   Ade Ismail Siregar (adeismailbox@gmail.com)
# @Last modified time: 2026-07-15T15:16:37+07:00

$is_homepage_only_hero = themeHomepageOnlyHero($sysconf);
$background_animation = themeBackgroundAnimation();
$background_animation_class = $background_animation !== 'none' ? ' rasamala-search-banner-bg-' . themeEscape($background_animation) : '';
$parallel_title_separator = themeParallelTitleSeparator();
$title_character_limit = themeTitleCharacterLimit();
?>

<script>
window.rasamalaParallelTitleSeparator = <?= json_encode($parallel_title_separator, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>;
window.rasamalaTitleCharacterLimit = <?= themeSafeInt($title_character_limit, 100, 1, 300); ?>;
</script>

<section id="section1" class="container-fluid position-relative rasamala-hero-section <?= $is_homepage_only_hero ? 'rasamala-hero-section-only' : '' ?>">
    <header class="c-header position-relative">
      <?php
      // ------------------------------------------------------------------------
      // include navbar
      // ------------------------------------------------------------------------
      include '_navbar.php'; ?>
    </header>

    <!-- Search form section inside its own clean wrapper below the hero book -->
    <div class="rasamala-search-banner-section py-4 <?= $is_homepage_only_hero ? 'rasamala-search-banner-hero-only' . $background_animation_class : '' ?>" id="search-section">
        <div class="container rasamala-search-hero-content">
            <?php include '_search-form.php'; ?>
        </div>
    </div>
</section>



<?php if (!$is_homepage_only_hero) : ?>
<div id="slims-home">
<?php
$home_topic_items = themeParseTopicItems($sysconf['template']['classic_topic_items'] ?? themeTopicItemsDefault());
$map_url = themeSafeHttpsUrl($sysconf['template']['classic_map_link'] ?? '');
$home_map_visible = themeShowMap($sysconf) && $map_url;
$home_social_visible = themeShowSocialMedia($sysconf);
$social_links = [
    'classic_fb_link' => 'fab fa-facebook-square',
    'classic_twitter_link' => 'fab fa-twitter-square',
    'classic_youtube_link' => 'fab fa-youtube',
    'classic_instagram_link' => 'fab fa-instagram',
    'classic_tiktok_link' => 'fab fa-tiktok',
    'classic_whatsapp_link' => 'fab fa-whatsapp',
    'classic_telegram_link' => 'fab fa-telegram-plane',
    'classic_linkedin_link' => 'fab fa-linkedin',
];

$sections = themeHomepageSectionOrder($sysconf);
$home_section_heading = function ($section_key, $title, $subtitle = '', $extra_class = '') use ($sysconf) {
    $heading_key = 'classic_' . $section_key . '_heading_display';
    $mode = strtolower(trim((string)themeEffectiveTemplateValue($heading_key, 'all', $sysconf)));

    if (in_array($mode, ['all', 'both', 'title_subject', 'title', 'hide'], true)) {
        $show_title = in_array($mode, ['all', 'both', 'title_subject', 'title'], true);
        $show_subtitle = in_array($mode, ['all', 'both'], true) && trim((string)$subtitle) !== '';
    } else {
        $title_key = 'classic_' . $section_key . '_title_show';
        $subtitle_key = 'classic_' . $section_key . '_subtitle_show';
        $show_title = (int)themeEffectiveTemplateValue($title_key, 1, $sysconf) === 1;
        $show_subtitle = (int)themeEffectiveTemplateValue($subtitle_key, 1, $sysconf) === 1 && trim((string)$subtitle) !== '';
    }

    if (!$show_title && !$show_subtitle) {
        return;
    }
    ?>
    <h2 class="mb-4 text-center rasamala-home-section-title <?= themeEscape($extra_class); ?>">
        <?php if ($show_title) : ?>
            <?= themeEscape($title); ?>
        <?php endif; ?>
        <?php if ($show_subtitle) : ?>
            <?php if ($show_title) : ?><br><?php endif; ?>
            <small class="subtitle-section"><?= themeEscape($subtitle); ?></small>
        <?php endif; ?>
    </h2>
    <?php
};

$home_content_cards = (isset($dbs) && $dbs && function_exists('themeHomeContentCards')) ? themeHomeContentCards($dbs, $sysconf) : [];

foreach ($sections as $section) {
    if ($section === 'topic' && themeHomepageSectionEnabled('topic', $sysconf) && $home_topic_items) {
        ?>
        <section class="container rasamala-home-section rasamala-home-section-topic">
            <?php $home_section_heading('topic', __('Select the topic you are interested in'), __('Choose a topic to explore the collection faster.'), 'text-thin'); ?>
            <ul class="topic d-flex flex-wrap justify-content-center px-0">
                <?php foreach ($home_topic_items as $home_topic_item) echo themeTopicItemHtml($home_topic_item); ?>
            </ul>
        </section>
        <?php
    }
    elseif ($section === 'news' && themeHomepageSectionEnabled('news', $sysconf) && !empty($home_content_cards)) {
        ?>
        <section class="container rasamala-home-section rasamala-home-content-cards-section">
            <div class="rasamala-home-content-cards">
                <?php foreach ($home_content_cards as $content_card) :
                    $card_title = $content_card['title'] ?? '';
                    $card_url = $content_card['url'] ?? '#';
                    $card_excerpt = $content_card['excerpt'] ?? '';
                    $card_image = $content_card['image_src'] ?? '';
                ?>
                <a class="rasamala-home-content-card" href="<?= themeEscape($card_url); ?>" title="<?= themeEscape($card_title); ?>">
                    <span class="rasamala-home-content-thumb" aria-hidden="<?= $card_image ? 'false' : 'true'; ?>">
                        <?php if ($card_image) : ?>
                        <img loading="lazy" src="<?= themeEscape($card_image); ?>" alt="" aria-hidden="true">
                        <?php else : ?>
                        <span class="rasamala-home-content-thumb-placeholder">
                            <i class="fas fa-newspaper" aria-hidden="true"></i>
                        </span>
                        <?php endif; ?>
                    </span>
                    <span class="rasamala-home-content-body">
                        <span class="rasamala-home-content-title"><?= themeEscape($card_title); ?></span>
                        <?php if ($card_excerpt) : ?>
                        <span class="rasamala-home-content-excerpt"><?= themeEscape($card_excerpt); ?></span>
                        <?php endif; ?>
                    </span>
                </a>
                <?php endforeach; ?>
            </div>
        </section>
        <?php
    }
    elseif ($section === 'popular' && themeHomepageSectionEnabled('popular', $sysconf)) {
        $heading_mode = strtolower(trim((string)themeEffectiveTemplateValue('classic_popular_collection_heading_display', 'all', $sysconf)));
        $show_subject = in_array($heading_mode, ['all', 'title_subject'], true);
        $section_class = ($heading_mode === 'hide' && !$show_subject) ? 'mt-3' : 'mt-5';
        ?>
        <section class="<?= themeEscape($section_class); ?> container rasamala-home-section rasamala-home-section-popular">
            <?php $home_section_heading('popular_collection', __('Popular among our collections'), __('Our library\'s line of collection that have been favoured by our users were shown here. Look for them. Borrow them. Hope you also like them')); ?>
            <?php if ($show_subject) : ?>
            <slims-group-subject url="index.php?p=api/subject/popular"></slims-group-subject>
            <?php endif; ?>
            <slims-collection url="index.php?p=api/biblio/popular" limit="<?= themeSafeInt($sysconf['template']['classic_popular_collection_item'] ?? 6, 6, 1, 100); ?>"></slims-collection>
        </section>
        <?php
    }
    elseif ($section === 'new-collection' && themeHomepageSectionEnabled('new-collection', $sysconf)) {
        $heading_mode = strtolower(trim((string)themeEffectiveTemplateValue('classic_new_collection_heading_display', 'all', $sysconf)));
        $show_subject = in_array($heading_mode, ['all', 'title_subject'], true);
        $section_class = ($heading_mode === 'hide' && !$show_subject) ? 'mt-3' : 'mt-5';
        ?>
        <section class="<?= themeEscape($section_class); ?> container rasamala-home-section rasamala-home-section-new-collection">
            <?php $home_section_heading('new_collection', __('New collections + updated'), __('These are new collections list. Hope you like them. Maybe not all of them are new. But in term of time, we make sure that these are fresh from our processing oven')); ?>
            <?php if ($show_subject) : ?>
            <slims-group-subject url="index.php?p=api/subject/latest"></slims-group-subject>
            <?php endif; ?>
            <slims-collection url="index.php?p=api/biblio/latest" limit="<?= themeSafeInt($sysconf['template']['classic_new_collection_item'] ?? 6, 6, 1, 100); ?>"></slims-collection>
        </section>
        <?php
    }
    elseif ($section === 'top-reader' && themeHomepageSectionEnabled('top-reader', $sysconf)) {
        ?>
        <section class="mt-5 rasamala-home-section rasamala-home-section-top-reader">
            <div class="container py-5">
                <?php $home_section_heading('top_reader', __('Top reader of the year'), __('Our best users, readers, so far. Continue to read if you want your name being mentioned here')); ?>
                <slims-group-member url="index.php?p=api/member/top" limit="<?= themeSafeInt($sysconf['template']['classic_top_reader_item'] ?? 5, 5, 1, 100); ?>"></slims-group-member>
            </div>
        </section>
        <?php
    }
    elseif ($section === 'map' && themeHomepageSectionEnabled('map', $sysconf) && ($home_map_visible || $home_social_visible)) {
        ?>
        <section class="my-5 container rasamala-home-section rasamala-home-section-map">
            <div class="row align-items-center">
                <?php if ($home_map_visible) : ?>
                <div class="col-md-6">
                    <iframe class="embed-responsive border-0"
                            src="<?= themeEscape($map_url); ?>"
                            title="<?= themeEscape(sprintf(__('Map location for %s'), $sysconf['library_name'] ?? __('Library'))); ?>"
                            height="<?= themeEscape(themeSafeInt($sysconf['template']['classic_map_height'] ?? 420, 420, 100, 2000)) ?>"
                            frameborder="0" loading="lazy" allowfullscreen></iframe>
                </div>
                <?php endif; ?>
                <div class="<?= $home_map_visible ? 'col-md-6' : 'col-md-12' ?> pt-8 md:pt-0 home-map-contact">
                    <h2 class="home-library-name"><?= themeEscape($sysconf['library_name']); ?></h2>
                    <div class="home-map-description"><?= themeSanitizeHtml($sysconf['template']['classic_map_desc'] ?? ''); ?></div>
                    <?php if ($home_social_visible) : ?>
                    <p class="d-flex flex-row flex-wrap pt-2 home-map-social-links">
                        <?php
                        $social_labels = [
                            'classic_fb_link' => 'Facebook',
                            'classic_twitter_link' => 'Twitter',
                            'classic_youtube_link' => 'YouTube',
                            'classic_instagram_link' => 'Instagram',
                            'classic_tiktok_link' => 'TikTok',
                            'classic_whatsapp_link' => 'WhatsApp',
                            'classic_telegram_link' => 'Telegram',
                            'classic_linkedin_link' => 'LinkedIn',
                        ];
                        foreach ($social_links as $setting_key => $icon_class) :
                            $social_url = themeSafeHttpsUrl($sysconf['template'][$setting_key] ?? '');
                            if (!$social_url) continue;
                            $social_label = $social_labels[$setting_key] ?? __('Social media');
                        ?>
                        <a target="_blank" rel="noopener noreferrer" href="<?= themeEscape($social_url) ?>" class="btn btn-primary me-2" name="button"
                           aria-label="<?= themeEscape(sprintf(__('Open %s social media'), $social_label)); ?>"
                           title="<?= themeEscape($social_label); ?>">
                            <i class="<?= themeEscape($icon_class) ?> text-white" aria-hidden="true"></i>
                        </a>
                        <?php endforeach; ?>
                    </p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
?>
</div>
<?php endif; ?>
