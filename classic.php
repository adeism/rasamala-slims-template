<?php
# @Author: Waris Agung Widodo <user>
# @Date:   2018-01-21T11:46:42+07:00
# @Email:  ido.alit@gmail.com
# @Filename: classic.php
# @Last modified by:   Ade Ismail Siregar (adeismailbox@gmail.com)
# @Last modified time: 2026-07-22T12:10:00+07:00

// ----------------------------------------------------------------------------
// Be sure that this file not accessed directly
// ----------------------------------------------------------------------------
if (!defined('INDEX_AUTH')) {
  die("can not access this file directly");
} elseif (INDEX_AUTH != 1) {
  die("can not access this file directly");
}

include_once __DIR__ . '/theme_helpers.php';
include_once __DIR__ . '/helpers/core.php';

// ----------------------------------------------------------------------------
// Define member login state
// ----------------------------------------------------------------------------
$is_login = utility::isMemberLogin();
$member_image_name = $_SESSION['m_image'] ?? 'person.png';
$member_image_path = getImagePath($sysconf, $member_image_name, 'persons');
