<?php
/**
 * APA Style citation
 * Copyright (C) 2015  Arie Nugraha (dicarve@gmail.com)
 *
 * Available data to use:
 * $author_list    : Array of authors <-- you must pre-proccess this to string first
 * $authors_string : String of authors name separated by comma if there is more than one
 * $title          : String of title
 * $publish_year   : String of publication year
 * $edition        : String of edition statement
 * $publish_place  : String of place of publication
 * $publisher_name : String of name of publisher
 * $gmd_name       : String of name of GMD/Document format
 *
 */

// Shared with the other styles in this directory; all catalog values
// below MUST go through this (K-01: stored XSS via catalog data).
if (!function_exists('rasamala_cite_e')) {
    function rasamala_cite_e($value)
    {
        return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
    }
}

?>
<div class="citation-card">
  <h3><?php echo __('Chicago Style'); ?></h3>
  <p class="citation">
    <?php if ($authors_string) : ?>
      <span class="authors"><?php echo rasamala_cite_e($authors_string) ?>.</span>
      <span class="title"><em><?php echo rasamala_cite_e($title) ?></em>.</span>
      <span class="edition"><?php echo rasamala_cite_e($edition) ?></span>
    <?php else : ?>
      <span class="title"><em><?php echo rasamala_cite_e($title) ?></em>.</span>
      <span class="edition"><?php echo rasamala_cite_e($edition) ?>.</span>
    <?php endif; ?>
    <span class="publish_place"><?php echo rasamala_cite_e($publish_place) ?>:</span>
    <span class="publisher"><?php echo rasamala_cite_e($publisher_name) ?>,</span>
    <span class="year"><?php echo rasamala_cite_e($publish_year) ?>.</span>
    <span class="gmd_name"><?php echo rasamala_cite_e($gmd_name) ?>.</span>
  </p>
</div>
