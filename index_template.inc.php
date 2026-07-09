<?php
# @Author: Waris Agung Widodo <user>
# @Date:   2018-01-21T11:36:53+07:00
# @Email:  ido.alit@gmail.com
# @Filename: index_template.inc.php
# @Last modified by:   Ade Ismail Siregar (adeismailbox@gmail.com)
# @Last modified time: 2026-07-08T15:48:00+07:00

$imagesDisk = \SLiMS\Filesystems\Storage::images();

//$a = get_defined_vars();
//$a['sysconf'] = null;
//$a['main_content'] = null;
//echo '<pre>'; print_r($a); echo '</pre>'; die();
//echo '<pre>'; print_r($_SESSION); echo '</pre>'; die();

// setup list view
$available_list_views = ['simple', 'list', 'grid'];
$list_view_default_marker = 'rasamala-simple-default-20260708';
if (
  isset($_POST['view'], $_POST['csrf_token'], $_GET['csrf_token'])
  && in_array($_POST['view'], $available_list_views, true)
  && hash_equals((string)$_GET['csrf_token'], (string)$_POST['csrf_token'])
) {
  $_SESSION['LIST_VIEW'] = $_POST['view'];
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

// ----------------------------------------------------------------------------
// load footer
// ----------------------------------------------------------------------------
include 'parts/footer.php';
