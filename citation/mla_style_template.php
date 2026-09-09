<?php
/**
 * APA Style citation
 * Copyright (C) 2015  Arie Nugraha (dicarve@gmail.com)
 * Modification by Drajat Hasan 2023 (drajathasan20@gmail.com)
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

//  set pre-processor variable
$author_list = [];
$authors_string = '';

// iterate some author data
foreach ($authors as $order => $data) {
  // chunk author name as an array based on space
  $chunk_name = explode(' ', $data['author_name']);
  // get last key order
  $last_chunkname_order = array_key_last($chunk_name);
  // set lastname
  $last_name = $chunk_name[$last_chunkname_order];
  // set first name
  $first_name = $chunk_name[0]??'';

  // Check everthing first name ended with comma or not
  if (!str_ends_with(trim($first_name), ',')) {
    unset($chunk_name[$last_chunkname_order]); // remote last chunkname
    if ($order > 0 && count($authors) > 2) continue; // don't make it pain, just say it et al if author > 2
    // Process for inverting name
    $author_list[] = $last_name . ', ' . implode(', ', array_map(fn($name) => ucfirst($name) . '', $chunk_name)) . '.';
  } else {
    // Same as above
    if ($order > 0 && count($authors) > 2) continue;
    unset($chunk_name[0]);
    // if author have comma/before it already inverted
    $author_list[] = $first_name . ' ' . implode(', ', array_map(fn($name) => ucfirst($name) . '', $chunk_name)) . '.';
  }
}

// glue all author data into one string
$authors_string = implode(', ', $author_list) . (count($authors) > 2 ? ' et al.' : '');

?>
<div class="citation-card">
  <h3><?php echo __('MLA Style'); ?></h3>
  <p class="citation text-justify">
    <?php if ($authors_string) : ?>
      <span class="authors"><?php echo rasamala_cite_e($authors_string) ?></span>
      <span class="title">"<?php echo rasamala_cite_e($title) ?>".</span>
      <span class="edition"><em><?php echo rasamala_cite_e($edition) ?></em></span>
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
