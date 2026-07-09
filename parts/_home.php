<?php
# @Author: Waris Agung Widodo <user>
# @Date:   2018-01-23T11:27:04+07:00
# @Email:  ido.alit@gmail.com
# @Filename: _home.php
# @Last modified by:   Ade Ismail Siregar (adeismailbox@gmail.com)
# @Last modified time: 2026-07-09T10:13:26+07:00

$is_homepage_only_hero = (($sysconf['template']['classic_homepage_only_hero'] ?? 0) == 1);
$background_animation = themeBackgroundAnimation();
$background_animation_class = $background_animation !== 'none' ? ' apple-search-banner-bg-' . themeEscape($background_animation) : '';
$parallel_title_separator = themeParallelTitleSeparator();
$title_character_limit = themeTitleCharacterLimit();
?>

<script>
window.rasamalaParallelTitleSeparator = <?= json_encode($parallel_title_separator, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>;
window.rasamalaTitleCharacterLimit = <?= themeSafeInt($title_character_limit, 100, 1, 300); ?>;
</script>

<section id="section1" class="container-fluid position-relative apple-hero-section <?= $is_homepage_only_hero ? 'apple-hero-section-only' : '' ?>">
    <header class="c-header position-relative">
      <?php
      // ------------------------------------------------------------------------
      // include navbar
      // ------------------------------------------------------------------------
      include '_navbar.php'; ?>
    </header>

    <!-- Search form section inside its own clean wrapper below the hero book -->
    <div class="apple-search-banner-section py-4 <?= $is_homepage_only_hero ? 'apple-search-banner-hero-only' . $background_animation_class : '' ?>" id="search-section">
        <div class="container apple-search-hero-content">
            <?php include '_search-form.php'; ?>
        </div>
    </div>
</section>



<?php if (!$is_homepage_only_hero) : ?>
<div id="slims-home">
<?php
$home_topic_items = themeParseTopicItems($sysconf['template']['classic_topic_items'] ?? themeTopicItemsDefault());
$map_url = themeSafeHttpsUrl($sysconf['template']['classic_map_link'] ?? '');
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

$section_order_raw = $sysconf['template']['classic_homepage_section_order'] ?? 'topic;popular;new-collection;top-reader;map';
$sections = explode(';', strtolower(str_replace(' ', '', $section_order_raw)));

foreach ($sections as $section) {
    if ($section === 'topic' && ($sysconf['template']['classic_topic_show'] ?? 1) && $home_topic_items) {
        ?>
        <section class="mt-5 container">
            <h4 class="text-center text-thin mt-5 mb-4"><?php echo __('Select the topic you are interested in'); ?></h4>
            <ul class="topic d-flex flex-wrap justify-content-center px-0">
                <?php foreach ($home_topic_items as $home_topic_item) echo themeTopicItemHtml($home_topic_item); ?>
            </ul>
        </section>
        <?php
    }
    elseif ($section === 'popular' && ($sysconf['template']['classic_popular_collection'] ?? 1)) {
        ?>
        <section class="mt-5 container">
            <h4 class=" mb-4">
                <?php echo __('Popular among our collections'); ?>
                <br>
                <small class="subtitle-section"><?php echo __('Our library\'s line of collection that have been favoured by our users were shown here. Look for them. Borrow them. Hope you also like them');?></small>
            </h4>
            <slims-group-subject url="index.php?p=api/subject/popular"></slims-group-subject>
            <slims-collection url="index.php?p=api/biblio/popular" limit="<?= themeSafeInt($sysconf['template']['classic_popular_collection_item'] ?? 6, 6, 1, 100); ?>"></slims-collection>
        </section>
        <?php
    }
    elseif ($section === 'new-collection' && ($sysconf['template']['classic_new_collection'] ?? 1)) {
        ?>
        <section class="mt-5 container">
            <h4 class=" mb-4">
                <?php echo __('New collections + updated');?>
                <br>
                <small class="subtitle-section"><?php echo __('These are new collections list. Hope you like them. Maybe not all of them are new. But in term of time, we make sure that these are fresh from our processing oven');?></small>
            </h4>
            <slims-group-subject url="index.php?p=api/subject/latest"></slims-group-subject>
            <slims-collection url="index.php?p=api/biblio/latest" limit="<?= themeSafeInt($sysconf['template']['classic_new_collection_item'] ?? 6, 6, 1, 100); ?>"></slims-collection>
        </section>
        <?php
    }
    elseif ($section === 'top-reader' && ($sysconf['template']['classic_top_reader'] ?? 1)) {
        ?>
        <section class="mt-5 bg-apple-light">
            <div class="container py-5">
                <h4 class="mb-4">
                    <?php echo __('Top reader of the year');?>
                    <br>
                    <small class="subtitle-section"><?php echo __('Our best users, readers, so far. Continue to read if you want your name being mentioned here');?></small>
                </h4>
                <slims-group-member url="index.php?p=api/member/top" limit="<?= themeSafeInt($sysconf['template']['classic_top_reader_item'] ?? 5, 5, 1, 100); ?>"></slims-group-member>
            </div>
        </section>
        <?php
    }
    elseif ($section === 'map' && ($sysconf['template']['classic_map'] ?? 0) && $map_url) {
        ?>
        <section class="my-5 container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <iframe class="embed-responsive border-0"
                            src="<?= themeEscape($map_url); ?>"
                            height="<?= themeEscape(themeSafeInt($sysconf['template']['classic_map_height'] ?? 420, 420, 100, 2000)) ?>" frameborder="0" allowfullscreen></iframe>
                </div>
                <div class="col-md-6 pt-8 md:pt-0">
                    <h4 class="home-library-name"><?= themeEscape($sysconf['library_name']); ?></h4>
                    <p><?= themeSanitizeHtml($sysconf['template']['classic_map_desc'] ?? ''); ?></p>
                    <p class="d-flex flex-row pt-2">
                        <?php foreach ($social_links as $setting_key => $icon_class) :
                            $social_url = themeSafeHttpsUrl($sysconf['template'][$setting_key] ?? '');
                            if (!$social_url) continue;
                        ?>
                        <a target="_blank" rel="noopener noreferrer" href="<?= themeEscape($social_url) ?>" class="btn btn-primary mr-2" name="button"><i class="<?= themeEscape($icon_class) ?> text-white"></i></a>
                        <?php endforeach; ?>
                    </p>
                </div>
            </div>
        </section>
        <?php
    }
}
?>
</div>
<?php endif; ?>
