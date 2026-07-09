<?php
# @Author: Waris Agung Widodo <user>
# @Date:   2018-01-25T10:25:29+07:00
# @Email:  ido.alit@gmail.com
# @Filename: _navbar.php
# @Last modified by:   Ade Ismail Siregar (adeismailbox@gmail.com)
# @Last modified time: 2026-07-09T14:45:38+07:00

$is_homepage = !isset($_GET['p']) && !isset($_GET['search']);
$is_hero_only = $is_homepage && (($sysconf['template']['classic_homepage_only_hero'] ?? 0) == 1);

$menu_raw = $sysconf['template']['classic_navbar_menu'] ?? themeNavbarMenuDefault();
$main_menus = themeParseNavbarMenus($menu_raw);

?>

<nav class="navbar navbar-expand-lg navbar-light bg-transparent">
    <a class="navbar-brand d-inline-flex align-items-center" href="index.php">
        <?php
        if(isset($sysconf['logo_image']) && $sysconf['logo_image'] != '' && $imagesDisk->isExists($path = 'default/'.$sysconf['logo_image'])){
            echo '<img class="navbar-brand-img" src="'.themeEscape(SWB . 'lib/minigalnano/createthumb.php?filename=images/' . $path.'&width=350').'" alt="'.themeEscape($sysconf['library_name']).'">';
        }
        elseif (file_exists(__DIR__ . '/../assets/images/logo.png')) {
            echo '<img class="navbar-brand-img-small" src="'.themeEscape(assets('images/logo.png')).'" alt="'.themeEscape($sysconf['library_name']).'">';
        } else {
        ?>
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-book navbar-book-icon" viewBox="0 0 16 16">
            <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.933-.575-2.202-.954-3.41-1.11-1.226-.157-2.484-.013-3.388.337zm11-.14c.654-.689 1.782-.886 3.11-.752 1.234.124 2.503.523 3.388.893v9.923c-.904-.35-2.162-.494-3.388-.337-1.208.156-2.477.535-3.409 1.11V2.688zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783"/>
        </svg>
        <?php } ?>
        <div class="d-inline-flex flex-column ml-1 navbar-brand-text">
            <span class="navbar-lib-name"><?php echo themeEscape($sysconf['library_name']); ?></span>
            <?php if ($sysconf['template']['classic_library_subname']) : ?>
            <span class="navbar-lib-subname"><?php echo themeEscape($sysconf['library_subname']); ?></span>
            <?php endif; ?>
        </div>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <?php
          foreach ($main_menus as $main_menu) {
            $active = '';
            $key = $main_menu['key'];
            if (isset($_GET['p'])) {
              if ($key === $_GET['p']) $active = 'active';
            } elseif ($key === 'home') {
              $active = 'active';
            }

            $safe_url = themeEscape(themeSafeMenuUrl($main_menu['url']) ?: '#');
            $safe_text = themeEscape(__($main_menu['text']));
            $safe_active = themeEscape($active);
            $safe_icon = themeEscape(themeNavbarMenuIconClass($main_menu, 'fas fa-link'));

            $menu_str = <<<HTML
<li class="nav-item {$safe_active}">
    <a class="nav-link" href="{$safe_url}"><i class="{$safe_icon} navbar-menu-icon" aria-hidden="true"></i><span>{$safe_text}</span></a>
</li>
HTML;
            echo $menu_str;
          }
          ?>
          <?php
          $menu_member_active = isset($_GET['p']) && $_GET['p'] === 'member' ? 'active' : '';
          if (($sysconf['template']['classic_member_area'] ?? 1) == 1) {
            if ($is_login) {
              ?>
                <li class="nav-item <?= $menu_member_active; ?>">
                    <a class="nav-link" href="index.php?p=member&sec=title_basket">
                        <i class="fas fa-shopping-basket"></i>
                      <?php
                      $count_basket = count($_SESSION['m_mark_biblio']);
                      ?>
                    <sup id="count-basket" class="badge badge-danger"><?php echo themeEscape(themeSafeInt($count_basket)); ?></sup>
                    </a>
                </li>
                <li class="nav-item dropdown <?= $menu_member_active; ?>">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-full ml-2 mr-2 navbar-user-avatar"
                             src="<?php echo themeEscape($member_image_path); ?>"
                             alt="<?= htmlspecialchars(sprintf(__('Avatar of %s'), $_SESSION['m_name'] ?? __('Member')), ENT_QUOTES, 'UTF-8') ?>">
                      <?php echo themeEscape($_SESSION['m_name'] ?? ''); ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="index.php?p=member"><i class="fas fa-user-circle mr-3"></i> <?= themeEscape(__('Profile'));?></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="index.php?p=member&sec=bookmark"><i class="fas fa-bookmark mr-3"></i> <?= themeEscape(__('Bookmark'));?></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="index.php?p=member&logout=1"><i class="fas fa-sign-out-alt mr-3"></i> <?= themeEscape(__('Logout')); ?></a>
                    </div>
                </li>
            <?php } else { ?>
                <li class="nav-item <?= $menu_member_active; ?>">
                    <a class="nav-link" href="index.php?p=member"><?= themeEscape(__('Member Area')) ?></a>
                </li>
            <?php }
          } ?>
            <?php if (($sysconf['template']['classic_language_select'] ?? 1) == 1) { ?>
            <li class="nav-item dropdown">
              <?php
              $langstr = '';
              $current_lang = '';
              $select_lang = isset($_COOKIE['select_lang'])?$_COOKIE['select_lang']:$sysconf['default_lang'];
              // require_once(LANG . 'localisation.php');
              foreach ($available_languages??[] AS $lang_index) {
                $selected = null;
                $lang_code = $lang_index[0];
                $lang_name = $lang_index[1];
                $code_arr = explode('_', $lang_code);
                $code_flag = strtolower($code_arr[1]);
                if ($lang_code == $select_lang) {
                  $current_lang = [
                    'name' => $lang_name,
                    'code' => $code_flag
                  ];
                }
                $safe_lang_code = themeEscape($lang_code);
                $safe_code_flag = themeEscape(preg_replace('/[^a-z]/', '', $code_flag));
                $safe_lang_name = themeEscape($lang_name);
                $langstr .= <<<HTML
    <a class="dropdown-item" href="index.php?select_lang={$safe_lang_code}">
        <span class="flag-icon flag-icon-{$safe_code_flag} mr-2 flag-icon-rounded"></span> {$safe_lang_name}
    </a>
HTML;
              }
              ?>
                <a class="nav-link dropdown-toggle cursor-pointer" type="button" id="languageMenuButton"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="flag-icon flag-icon-<?= themeEscape($current_lang['code'] ?? '') ?> flag-icon-rounded"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="dropdownMenuButton">
                    <h6 class="dropdown-header"><?= themeEscape(__('Select Language')); ?> : </h6>
                  <?= $langstr; ?>
                </div>
            </li>
            <?php } ?>
        </ul>
    </div>
</nav>
