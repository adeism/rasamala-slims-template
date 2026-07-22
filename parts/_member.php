<?php
/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 2019-01-30 20:58
 * @File name           : _member.php
 * @Last modified by    : Ade Ismail Siregar (adeismailbox@gmail.com)
 * @Last modified time  : 2026-07-20T15:12:05+07:00
 */

if (!function_exists('rasamalaReplaceMemberCardContent')) {
    function rasamalaReplaceMemberCardContent($content, $card_html)
    {
        $needle = '<div class="bg-white border-right border-bottom border-left p-4">';
        $start = strpos($content, $needle);
        if ($start === false) {
            return $content . "\n" . $needle . $card_html . '</div>';
        }

        $inner_start = $start + strlen($needle);
        $offset = $inner_start;
        $depth = 1;
        while ($depth > 0 && preg_match('/<\/?div\b[^>]*>/i', $content, $matches, PREG_OFFSET_CAPTURE, $offset)) {
            $tag = $matches[0][0];
            $tag_pos = $matches[0][1];
            if (preg_match('/^<\s*\/\s*div\b/i', $tag)) {
                $depth--;
            } else {
                $depth++;
            }
            $offset = $tag_pos + strlen($tag);
        }

        if ($depth !== 0) {
            return $content . "\n" . $needle . $card_html . '</div>';
        }

        $closing_start = $tag_pos;
        return substr($content, 0, $inner_start)
            . "\n" . $card_html
            . substr($content, $closing_start);
    }
}

if (!function_exists('rasamalaMemberExpiryStatus')) {
    function rasamalaMemberExpiryStatus($expiry_date)
    {
        $expiry_date = trim((string)$expiry_date);
        if ($expiry_date === '') {
            return [
                'class' => 'unknown',
                'label' => __('Status unavailable'),
                'note' => __('Expiry date is not available.'),
                'days_until' => null,
            ];
        }

        $expiry_timestamp = strtotime($expiry_date);
        if ($expiry_timestamp === false) {
            return [
                'class' => 'unknown',
                'label' => __('Status unavailable'),
                'note' => __('Expiry date is not available.'),
                'days_until' => null,
            ];
        }

        $today_start = strtotime(date('Y-m-d') . ' 00:00:00');
        $expiry_end = strtotime(date('Y-m-d', $expiry_timestamp) . ' 23:59:59');
        $days_until = (int)floor(($expiry_end - $today_start) / 86400);

        if ($days_until < 0) {
            return [
                'class' => 'expired',
                'label' => __('Expired'),
                'note' => __('Please renew your membership.'),
                'days_until' => $days_until,
            ];
        }

        if ($days_until <= 30) {
            return [
                'class' => 'warning',
                'label' => __('Almost expired'),
                'note' => $days_until === 0
                    ? __('Membership expires today.')
                    : sprintf(__('Membership expires in %d day(s).'), $days_until),
                'days_until' => $days_until,
            ];
        }

        return [
            'class' => 'active',
            'label' => __('Active'),
            'note' => __('Membership is active.'),
            'days_until' => $days_until,
        ];
    }
}

if (!function_exists('rasamalaMemberRedirect')) {
    function rasamalaMemberRedirect($url)
    {
        if (!headers_sent()) {
            header('Location: ' . $url);
            exit;
        }

        echo '<meta http-equiv="refresh" content="0;url=' . themeEscape($url) . '">';
        echo '<p><a href="' . themeEscape($url) . '">' . themeEscape(__('Continue')) . '</a></p>';
        exit;
    }
}

$rasamala_member_area_config = [
    'reserveDirectDatabase' => !empty($sysconf['reserve_direct_database']),
    'urls' => [
        'basket' => 'index.php?p=member&sec=title_basket',
        'member' => 'index.php?p=member',
        'bookmark' => 'index.php?p=member&sec=bookmark',
    ],
    'labels' => [
        'confirm' => __('Confirm'),
        'cancel' => __('Cancel'),
        'close' => __('Close'),
        'clearBasketTitle' => __('Clear Basket'),
        'clearBasketMessage' => __('Clear your title(s) basket?'),
        'clearingBasket' => __('Clearing basket...'),
        'basketCleared' => __('Basket data cleared!'),
        'basketClearFailed' => __('Failed to clear basket.'),
        'removeBasketTitle' => __('Remove from Basket'),
        'removeBasketMessage' => __('Remove selected title(s) from basket?'),
        'removingBasket' => __('Removing selected titles...'),
        'basketRemoved' => __('Selected basket data removed!'),
        'basketRemoveFailed' => __('Failed to remove selected titles.'),
        'reservationSending' => __('Please wait, your reservation is being sent...'),
        'reservationInfo' => __('Please wait. your reservation is being sent'),
        'reservationSent' => __('Reservation request sent'),
        'reservationEmailSent' => __('Reservation e-mail sent'),
        'unexpectedError' => __('Unexpected error occurred.'),
        'removeBookmarkTitle' => __('Remove Bookmark'),
        'removeBookmarkMessage' => __('Remove this bookmark?'),
        'removingBookmark' => __('Removing bookmark...'),
        'bookmarkRemoveFailed' => __('Unexcpected error. Please tell it to the librarian'),
        'printMemberCard' => __('Print Member Card'),
    ],
];

if (isset($main_content)) {
    // Escaping session variables to prevent XSS (F10)
    // Using regular expressions for more robust matching of TD cells containing raw session values
    $escape_session_var = function ($session_val, &$content) {
        $session_val = trim((string)$session_val);
        if ($session_val === '') return;
        $escaped = htmlspecialchars($session_val, ENT_QUOTES, 'UTF-8');
        // Match td with any attributes, containing precisely the raw session value
        $pattern = '/(<td\b[^>]*>)' . preg_quote($session_val, '/') . '(<\/td>)/i';
        $content = preg_replace($pattern, '$1' . addcslashes($escaped, '$') . '$2', $content);
    };

    if (isset($_SESSION['m_name'])) {
        $escape_session_var($_SESSION['m_name'], $main_content);
        $main_content = str_replace(
            'Hi, ' . $_SESSION['m_name'] . ' <a',
            'Hi, ' . htmlspecialchars($_SESSION['m_name'], ENT_QUOTES, 'UTF-8') . ' <a',
            $main_content
        );
    }
    if (isset($_SESSION['mid'])) {
        $escape_session_var($_SESSION['mid'], $main_content);
    }
    if (isset($_SESSION['m_email'])) {
        $escape_session_var($_SESSION['m_email'], $main_content);
    }
    if (isset($_SESSION['m_member_type'])) {
        $escape_session_var($_SESSION['m_member_type'], $main_content);
        $main_content = str_replace(
            'text-green"></i>' . $_SESSION['m_member_type'],
            'text-green"></i>' . htmlspecialchars($_SESSION['m_member_type'], ENT_QUOTES, 'UTF-8'),
            $main_content
        );
    }
    if (isset($_SESSION['m_register_date'])) {
        $escape_session_var($_SESSION['m_register_date'], $main_content);
    }
    if (isset($_SESSION['m_expire_date'])) {
        $escape_session_var($_SESSION['m_expire_date'], $main_content);
    }
    if (isset($_SESSION['m_institution'])) {
        $escape_session_var($_SESSION['m_institution'], $main_content);
    }

    // Accessible labels (F9)
    $member_id_label = __('Member ID');
    $password_label = __('Password');
    $main_content = str_replace(
        '<div class="fieldLabel">' . $member_id_label . '</div>' . "\n" . '                <div class="login_input"><input class="form-control" type="text" name="memberID"',
        '<label class="fieldLabel d-block" for="memberID">' . $member_id_label . '</label>' . "\n" . '                <div class="login_input"><input class="form-control" id="memberID" type="text" name="memberID"',
        $main_content
    );
    $main_content = str_replace(
        '<div class="fieldLabel marginTop">' . $password_label . '</div>' . "\n" . '                <div class="login_input"><input class="form-control" type="password" name="memberPassWord"',
        '<label class="fieldLabel marginTop d-block" for="memberPassWord">' . $password_label . '</label>' . "\n" . '                <div class="login_input"><input class="form-control" id="memberPassWord" type="password" name="memberPassWord"',
        $main_content
    );

    $curr_pass_label = __('Current Password');
    $new_pass_label = __('New Password');
    $conf_pass_label = __('Confirm Password');
    $main_content = str_replace(
        '<td class="key alterCell" width="20%"><strong>' . $curr_pass_label . '</strong></td><td class="value alterCell2"><input type="password" name="currPass"',
        '<td class="key alterCell" width="20%"><label for="currPass" class="m-0 font-weight-bold">' . $curr_pass_label . '</label></td><td class="value alterCell2"><input type="password" id="currPass" name="currPass"',
        $main_content
    );
    $main_content = str_replace(
        '<td class="key alterCell" width="20%"><strong>' . $new_pass_label . '</strong></td><td class="value alterCell2"><input type="password" name="newPass"',
        '<td class="key alterCell" width="20%"><label for="newPass" class="m-0 font-weight-bold">' . $new_pass_label . '</label></td><td class="value alterCell2"><input type="password" id="newPass" name="newPass"',
        $main_content
    );
    $main_content = str_replace(
        '<td class="key alterCell" width="20%"><strong>' . $conf_pass_label . '</strong></td><td class="value alterCell2"><input type="password" name="newPass2"',
        '<td class="key alterCell" width="20%"><label for="newPass2" class="m-0 font-weight-bold">' . $conf_pass_label . '</label></td><td class="value alterCell2"><input type="password" id="newPass2" name="newPass2"',
        $main_content
    );

    // Replace JS script tags to remove blocking confirms/alerts; behavior is handled by assets/js/member_area.js.
    $script_tag_open = '<scr' . 'ipt type="text\/javascript">';
    $script_tag_close = '<\/scr' . 'ipt>';
    $pattern = '/' . $script_tag_open . '\s*\$\(document\)\.ready\(function \(\) \{\s*\$\(\'\.clearAll\'\).+?' . $script_tag_close . '/s';
    $main_content = preg_replace($pattern, '', $main_content);

    // Inject "My Card" tab link
    $my_card_active = (isset($_GET['sec']) && $_GET['sec'] === 'my_card') ? 'active' : '';
    $my_card_text = '<i class="fas fa-id-card mr-2" aria-hidden="true"></i>' . __('My Card');

    $my_account_label = __('My Account');
    $my_account_label_icon = '<i class="fas fa-user-circle mr-2" aria-hidden="true"></i>' . $my_account_label;
    $main_content = str_replace('sec=my_account">' . $my_account_label . '</a>', 'sec=my_account">' . $my_account_label_icon . '</a>', $main_content);

    // Append the My Card tab right after the My Account tab using robust regex callback
    $main_content = preg_replace_callback(
        '/(<li\s+class="nav-item">[^<]*<a\s+[^>]*href=["\'][^"\']*sec=my_account[^"\']*["\'][^>]*>.*?<\/a>[^<]*<\/li>)/is',
        function($matches) use ($my_card_active, $my_card_text) {
            return $matches[1] . "\n" . '                    <li class="nav-item"><a class="nav-link ' . $my_card_active . '" href="index.php?p=member&sec=my_card">' . $my_card_text . '</a></li>';
        },
        $main_content
    );

    // Fix "Current Loan" redirection loop when default page is my_card
    $main_content = str_replace('href="index.php?p=member"', 'href="index.php?p=member&amp;sec=current_loan"', $main_content);
    $main_content = str_replace("href='index.php?p=member'", "href='index.php?p=member&amp;sec=current_loan'", $main_content);
    $main_content = str_replace('href="index.php?p=member&amp;sec="', 'href="index.php?p=member&amp;sec=current_loan"', $main_content);

    // Replace SLiMS core membercard references with my_card
    $main_content = str_replace('sec=membercard', 'sec=my_card', $main_content);

    // Strip target="_blank" from links containing sec=my_card or sec=membercard to prevent opening in a new tab
    $main_content = preg_replace_callback('/<a\s+[^>]*href=["\'][^"\']*(?:sec=my_card|sec=membercard)[^"\']*["\'][^>]*>/i', function($matches) {
        return str_replace(['target="_blank"', "target='_blank'"], '', $matches[0]);
    }, $main_content);

    // If active section is my_card, inject digital card HTML/JS content
    if (isset($_GET['sec']) && $_GET['sec'] === 'my_card') {
        $member_image_session = preg_replace('/[^a-zA-Z0-9._-]/', '', basename((string)($_SESSION['m_image'] ?? '')));
        $has_custom_image = $member_image_session !== '' && file_exists(IMGBS . 'persons/' . $member_image_session);
        $member_image = $has_custom_image ? $member_image_session : 'person.png';
        $member_image_url = SWB . 'images/persons/' . $member_image;

        $card_fields = explode(',', strtolower(str_replace(' ', '', $sysconf['template']['classic_card_show_fields'] ?? 'name,member_id,institution,member_type')));
        $show_name = in_array('name', $card_fields);
        $show_member_id = in_array('member_id', $card_fields);
        $show_institution = in_array('institution', $card_fields);
        $show_member_type = in_array('member_type', $card_fields);
        $expiry_date_display = trim((string)($_SESSION['m_expire_date'] ?? ''));
        $expiry_status = rasamalaMemberExpiryStatus($expiry_date_display);
        $expiry_status_class = preg_replace('/[^a-z0-9_-]/i', '', $expiry_status['class']);
        $expiry_status_label = (string)$expiry_status['label'];
        $expiry_status_note = (string)$expiry_status['note'];
        $expiry_status_aria = sprintf(
            '%s: %s. %s',
            __('Membership status'),
            $expiry_status_label,
            $expiry_status_note
        );

        $member_code_value = trim((string)($_SESSION['mid'] ?? ''));
        $card_code_type = strtolower(trim((string)($sysconf['template']['classic_card_code_type'] ?? 'qr')));
        if (!in_array($card_code_type, ['qr', 'barcode'], true)) {
            $card_code_type = 'qr';
        }

        $card_code_class = 'empty';
        $card_code_html = '<span class="member-card-code-empty">' . __('No member ID data') . '</span>';
        if ($member_code_value !== '' && $card_code_type === 'barcode') {
            $barcode_encoding = $sysconf['barcode_encoding'] ?? 'code128';
            if (is_array($barcode_encoding)) {
                $barcode_encoding = reset($barcode_encoding);
            }
            $barcode_encoding = preg_replace('/[^a-zA-Z0-9_-]/', '', (string)$barcode_encoding);
            if ($barcode_encoding === '') {
                $barcode_encoding = 'code128';
            }

            $barcode_url = SWB . 'lib/phpbarcode/barcode.php?code=' . rawurlencode($member_code_value)
                . '&encoding=' . rawurlencode($barcode_encoding)
                . '&scale=2&mode=png&act=show';
            $card_code_class = 'barcode';
            $card_code_html = '<img class="member-card-barcode-img" src="' . themeEscape($barcode_url) . '" alt="' . themeEscape(sprintf(__('Barcode for %s'), $member_code_value)) . '">';
        } elseif ($member_code_value !== '') {
            $qrcode_svg = '';
            try {
                $renderer = new BaconQrCode\Renderer\ImageRenderer(
                    new BaconQrCode\Renderer\RendererStyle\RendererStyle(280),
                    new BaconQrCode\Renderer\Image\SvgImageBackEnd()
                );
                $writer = new BaconQrCode\Writer($renderer);
                $qrcode_svg = $writer->writeString($member_code_value);
                $qrcode_svg = preg_replace('/<\?xml[^>]*\?>/', '', $qrcode_svg);
            } catch (Exception $e) {
                $qrcode_svg = '<!-- Error generating QR Code: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . ' -->';
            }
            $card_code_class = 'qr';
            $card_code_html = $qrcode_svg;
        }
        $is_member_active = ($expiry_status_class === 'active');
        $avatar_status_class = $is_member_active ? '' : ' is-inactive is-expired';

        $avatar_html = '';
        if ($has_custom_image) {
            $avatar_html = '<img src="' . themeEscape($member_image_url) . '" alt="Member Photo" class="rasamala-digital-card-avatar' . $avatar_status_class . '">';
        } else {
            $name = $_SESSION['m_name'] ?? '';
            $words = explode(' ', trim($name));
            $initials = '';
            if (count($words) >= 2) {
                $initials = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
            } elseif (count($words) == 1 && !empty($words[0])) {
                $initials = strtoupper(substr($words[0], 0, 2));
            } else {
                $initials = 'M';
            }
            $avatar_html = '<div class="initials-avatar rasamala-digital-card-initials' . $avatar_status_class . '">' . htmlspecialchars($initials, ENT_QUOTES, 'UTF-8') . '</div>';
        }

        $card_html = '<div id="digital-card-page" class="py-0 text-center">';
        $card_html .= '
        <div id="card-container" class="card rasamala-digital-card">
            <div class="header rasamala-digital-card-header">
                <div class="rasamala-digital-card-orb rasamala-digital-card-orb-top"></div>
                <div class="rasamala-digital-card-orb rasamala-digital-card-orb-bottom"></div>
                <div class="rasamala-digital-card-library-name">' . htmlspecialchars($sysconf['library_name'] ?? 'SLiMS Library', ENT_QUOTES, 'UTF-8') . '</div>
                <div class="rasamala-digital-card-library-subname">' . htmlspecialchars($sysconf['library_subname'] ?? '', ENT_QUOTES, 'UTF-8') . '</div>
                ' . $avatar_html . '
            </div>

            <div class="body rasamala-digital-card-body">';

        if ($show_name) {
            $card_html .= '
                <h3 class="rasamala-digital-card-name">' . htmlspecialchars($_SESSION['m_name'] ?? '', ENT_QUOTES, 'UTF-8') . '</h3>';
        }

        if ($show_member_id) {
            $card_html .= '
                <p class="rasamala-digital-card-id">' . htmlspecialchars($_SESSION['mid'] ?? '', ENT_QUOTES, 'UTF-8') . '</p>';
        }

        if ($show_member_type) {
            $card_html .= '
                <p class="rasamala-digital-card-type">' . htmlspecialchars($_SESSION['m_member_type'] ?? '', ENT_QUOTES, 'UTF-8') . '</p>';
        }

        if ($show_institution) {
            $card_html .= '
                <p class="rasamala-digital-card-institution">' . htmlspecialchars($_SESSION['m_institution'] ?? '', ENT_QUOTES, 'UTF-8') . '</p>';
        }

        if (!$is_member_active) {
            $card_html .= '
                <div class="member-card-expiry-status member-card-expiry-status--' . htmlspecialchars($expiry_status_class, ENT_QUOTES, 'UTF-8') . '" role="status" aria-label="' . htmlspecialchars($expiry_status_aria, ENT_QUOTES, 'UTF-8') . '">
                    <span class="member-card-expiry-status-label">' . htmlspecialchars($expiry_status_label, ENT_QUOTES, 'UTF-8') . '</span>
                    <span class="member-card-expiry-status-note">' . htmlspecialchars($expiry_status_note, ENT_QUOTES, 'UTF-8') . '</span>
                </div>';
        }

        $card_html .= '
                <div class="member-card-code-wrap"><div id="member-card-code" class="rasamala-card-code rasamala-digital-card-code rasamala-card-code--' . htmlspecialchars($card_code_class, ENT_QUOTES, 'UTF-8') . '">' . $card_code_html . '</div></div>
            </div>

            <div class="card-footer rasamala-digital-card-footer">
                ' . __('Expiry Date') . ': ' . htmlspecialchars($expiry_date_display !== '' ? $expiry_date_display : '-', ENT_QUOTES, 'UTF-8') . '
            </div>
        </div>

        <div class="rasamala-digital-card-actions">
            <button id="fullscreen-btn" class="btn btn-success mx-1"><i class="fas fa-expand mr-2" aria-hidden="true"></i>' . __('Fullscreen') . '</button>
            <button id="minimize-btn" class="btn btn-danger mx-1 rasamala-digital-card-minimize"><i class="fas fa-compress mr-2" aria-hidden="true"></i>' . __('Minimize') . '</button>
            <button id="print-btn" class="btn btn-primary mx-1"><i class="fas fa-print mr-2" aria-hidden="true"></i>' . __('Print') . '</button>
        </div>';

        $card_html .= '
        </div>';

        // Replace the main member content container with only the card html to prevent current loans showing on my_card
        $main_content = rasamalaReplaceMemberCardContent($main_content, $card_html);
    }
}
?>

<?php if ($is_login) : ?>

    <?php
    if (isset($_GET['sec']) && $_GET['sec'] === 'membercard') {
        rasamalaMemberRedirect('index.php?p=member&sec=my_card');
    }
    $member_sec = isset($_GET['sec']) ? trim($_GET['sec']) : 'current_loan';
    $default_page = $sysconf['template']['classic_member_default_page'] ?? 'current_loan';
    if (!isset($_GET['sec']) && $default_page !== 'current_loan') {
        rasamalaMemberRedirect('index.php?p=member&sec=' . urlencode($default_page));
    }
    ?>
    <template id="rasamala-member-area-config"><?= themeEscape(json_encode($rasamala_member_area_config, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT)); ?></template>
    <div class="member-area rasamala-subpage-wrapper member-sec-<?= htmlspecialchars($member_sec, ENT_QUOTES, 'UTF-8') ?>">
        <section id="section1" class="container-fluid">
            <header class="c-header rasamala-header-dark">
              <?php
              // ----------------------------------------------------------------------
              // include navbar part
              // ----------------------------------------------------------------------
              include '_navbar.php'; ?>
            </header>
        </section>

        <div class="container py-5">
          <div class="rasamala-main-content-card p-4 shadow-sm">
             <?php echo $main_content; ?>
          </div>
        </div>

    </div>
    <script src="<?php echo assetsVersioned('js/member_area.js'); ?>"></script>

<?php else: ?>

    <div class="result-search page-member-area rasamala-subpage-wrapper">
        <section id="section1" class="container-fluid">
            <header class="c-header rasamala-header-dark">
              <?php
              // ----------------------------------------------------------------------
              // include navbar part
              // ----------------------------------------------------------------------
              include '_navbar.php'; ?>
            </header>
          <?php
          // ------------------------------------------------------------------------
          // include search form part
          // ------------------------------------------------------------------------
          include '_search-form.php'; ?>
        </section>

        <div class="container py-5">
          <div class="row">
              <div class="col-md-8 mx-auto">
                <div class="rasamala-main-content-card p-4 shadow-sm">
                  <?php echo $main_content; ?>
                </div>
              </div>
          </div>
        </div>
    </div>

<?php endif; ?>
