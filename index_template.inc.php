<?php
# @Author: Waris Agung Widodo <user>
# @Date:   2018-01-21T11:36:53+07:00
# @Email:  ido.alit@gmail.com
# @Filename: index_template.inc.php
# @Last modified by:   Ade Ismail Siregar (adeismailbox@gmail.com)
# @Last modified time: 2026-07-15T15:16:37+07:00

$imagesDisk = \SLiMS\Filesystems\Storage::images();

// setup list view
$available_list_views = ['simple', 'list', 'grid'];
$list_view_default_marker = 'rasamala-simple-default-20260708';
$req_view = $_POST['view'] ?? $_GET['view'] ?? null;

if ($req_view !== null && in_array((string)$req_view, $available_list_views, true)) {
    $_SESSION['LIST_VIEW'] = (string)$req_view;
    $_SESSION['RASAMALA_LIST_VIEW_DEFAULT'] = $list_view_default_marker;
} elseif (($_SESSION['RASAMALA_LIST_VIEW_DEFAULT'] ?? '') !== $list_view_default_marker) {
    $_SESSION['LIST_VIEW'] = 'simple';
    $_SESSION['RASAMALA_LIST_VIEW_DEFAULT'] = $list_view_default_marker;
} else {
    $_SESSION['LIST_VIEW'] = in_array(($_SESSION['LIST_VIEW'] ?? ''), $available_list_views, true)
        ? $_SESSION['LIST_VIEW']
        : 'simple';
}

// ----------------------------------------------------------------------------
// load function library for classic template
// ----------------------------------------------------------------------------
include_once 'classic.php';

// ----------------------------------------------------------------------------
// load header
// ----------------------------------------------------------------------------
include 'parts/header.php';

// ----------------------------------------------------------------------------
// load content by URI
// ----------------------------------------------------------------------------
?>
<main id="main-content" class="rasamala-main" role="main">
<?php
if (isset($_GET['p']) || isset($_GET['search'])) {
  // --------------------------------------------------------------------------
  // handle result search
  if (isset($_GET['search'])) {
    // ------------------------------------------------------------------------
    // load parts result search template
    include 'parts/_result-search.php';
  } else {
    // --------------------------------------------------------------------------
    // handle member page
    if ($_GET['p'] == 'member') {
      include 'parts/_member.php';
    } else {
      include 'parts/_other.php';
    }
  }
} else {
  // --------------------------------------------------------------------------
  // not found query string: load home page
  include 'parts/_home.php';
}
?>
</main>
<?php

// ----------------------------------------------------------------------------
// load footer
// ----------------------------------------------------------------------------
include 'parts/footer.php';
