<?php
# @Author: Waris Agung Widodo <user>
# @Date:   2026-07-10T14:33:58+07:00
# @Email:  ido.alit@gmail.com
# @Filename: waktu_sholat.php
# @Last modified by:   Ade Ismail Siregar (adeismailbox@gmail.com)
# @Last modified time: 2026-07-11T10:26:50+07:00

if (!function_exists('rasamalaWaktuSholatFetchTimings')) {
    function rasamalaWaktuSholatFetchTimings($city)
    {
        $today = date('Y-m-d');
        if (isset($_SESSION['prayer_cache'])
            && ($_SESSION['prayer_cache']['date'] ?? '') === $today
            && ($_SESSION['prayer_cache']['city'] ?? '') === $city) {
            return $_SESSION['prayer_cache']['timings'] ?? null;
        }

        $url = 'https://api.aladhan.com/v1/timingsByCity?city=' . urlencode($city) . '&country=Indonesia&method=11';
        $response = false;

        if (function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            curl_close($ch);
        }

        if (!$response && ini_get('allow_url_fopen')) {
            $ctx = stream_context_create([
                'http' => [
                    'timeout' => 3,
                    'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)\r\n"
                ]
            ]);
            $response = @file_get_contents($url, false, $ctx);
        }

        if (!$response) {
            return null;
        }

        $data = json_decode($response, true);
        if (!isset($data['code'], $data['data']['timings']) || $data['code'] !== 200) {
            return null;
        }

        $_SESSION['prayer_cache'] = [
            'date' => $today,
            'city' => $city,
            'timings' => $data['data']['timings']
        ];

        return $data['data']['timings'];
    }
}

if (!function_exists('rasamalaWaktuSholatData')) {
    function rasamalaWaktuSholatData($sysconf)
    {
        $widget_type = themeEffectiveTemplateValue('classic_prayer_times_show', 'both', $sysconf);
        if ($widget_type == 1 || $widget_type === '1') {
            $widget_type = 'both';
        } elseif ($widget_type == 0 || $widget_type === '0') {
            $widget_type = 'hide';
        }

        $show_footer_times = ($widget_type === 'both' || $widget_type === 'footer');
        $show_reminder_toast = ($widget_type === 'both' || $widget_type === 'floating');
        $test_mode = false;
        $city = $sysconf['template']['classic_prayer_times_city'] ?? 'Jakarta';
        $result = [
            'show_footer_times' => $show_footer_times,
            'show_reminder_toast' => false,
            'city' => $city,
            'next_prayer' => null,
            'minutes_until' => null,
        ];

        if ($widget_type === 'hide') {
            return $result;
        }

        $timings = rasamalaWaktuSholatFetchTimings($city);
        if (!$timings) {
            return $result;
        }

        $names = [
            'Imsak' => 'Imsak',
            'Fajr' => 'Subuh',
            'Dhuhr' => 'Dzuhur',
            'Asr' => 'Ashar',
            'Maghrib' => 'Maghrib',
            'Isha' => 'Isya'
        ];
        $current_minutes = (int)date('H') * 60 + (int)date('i');
        $prayers = [];

        foreach ($names as $key => $display_name) {
            if (!isset($timings[$key])) {
                continue;
            }

            $time = preg_replace('/[^0-9:]/', '', $timings[$key]);
            $parts = explode(':', $time);
            if (count($parts) !== 2) {
                continue;
            }

            $minutes = (int)$parts[0] * 60 + (int)$parts[1];
            $prayers[] = [
                'name' => $display_name,
                'time' => $time,
                'minutes' => $minutes
            ];
        }

        usort($prayers, function ($a, $b) {
            return $a['minutes'] <=> $b['minutes'];
        });

        foreach ($prayers as $prayer) {
            if ($prayer['minutes'] >= $current_minutes) {
                $result['next_prayer'] = $prayer;
                break;
            }
        }

        if (!$result['next_prayer'] && !empty($prayers)) {
            $result['next_prayer'] = $prayers[0];
        }

        if ($result['next_prayer']) {
            $minutes_until = $result['next_prayer']['minutes'] - $current_minutes;
            if ($minutes_until < 0) {
                $minutes_until += 1440;
            }
            $result['minutes_until'] = $minutes_until;
            $result['show_reminder_toast'] = $show_reminder_toast && ($minutes_until <= 10 || $test_mode);
        }

        return $result;
    }
}

if (!function_exists('rasamalaWaktuSholatFooterHtml')) {
    function rasamalaWaktuSholatFooterHtml($data, $footer_search_show = false)
    {
        if (empty($data['show_footer_times']) || empty($data['next_prayer'])) {
            return '';
        }

        $next_prayer = $data['next_prayer'];
        $class = 'footer-next-prayer' . ($footer_search_show ? ' mt-2' : '');
        return '<div class="' . themeEscape($class) . '">'
            . themeEscape($next_prayer['name']) . ' (' . themeEscape($data['city']) . ') <strong>' . themeEscape($next_prayer['time']) . '</strong>'
            . '</div>';
    }
}

if (!function_exists('rasamalaWaktuSholatReminderHtml')) {
    function rasamalaWaktuSholatReminderHtml($data)
    {
        if (empty($data['show_reminder_toast']) || empty($data['next_prayer'])) {
            return '';
        }

        $next_prayer = $data['next_prayer'];
        $seconds_until = max(0, (int)($data['minutes_until'] ?? 0) * 60);
        ob_start();
        ?>
        <div class="prayer-reminder-toast" role="status" aria-live="polite" data-prayer-countdown="<?= themeEscape($seconds_until); ?>">
            <div class="prayer-reminder-icon">
                <i class="fas fa-mosque" aria-hidden="true"></i>
            </div>
            <div class="prayer-reminder-text">
                <strong><?= themeEscape($next_prayer['name']) ?> (<?= themeEscape($data['city']) ?>) <span class="prayer-reminder-countdown">-<?= themeEscape(sprintf('%d:00', (int)($data['minutes_until'] ?? 0))); ?></span></strong>
            </div>
            <button type="button" class="prayer-reminder-close" aria-label="<?= themeEscape(__('Close')) ?>">&times;</button>
        </div>
        <script>
        (function () {
            var reminder = document.querySelector('.prayer-reminder-toast');
            if (!reminder) return;
            var counter = reminder.querySelector('.prayer-reminder-countdown');
            var secondsLeft = parseInt(reminder.getAttribute('data-prayer-countdown') || '0', 10);
            var renderCountdown = function () {
                if (!counter) return;
                secondsLeft = Math.max(0, secondsLeft);
                var minutes = Math.floor(secondsLeft / 60);
                var seconds = secondsLeft % 60;
                counter.textContent = '-' + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
            };
            renderCountdown();
            window.setInterval(function () {
                secondsLeft -= 1;
                renderCountdown();
            }, 1000);
            var close = reminder.querySelector('.prayer-reminder-close');
            if (close) {
                close.addEventListener('click', function () {
                    reminder.classList.add('is-hidden');
                });
            }
        })();
        </script>
        <?php
        return ob_get_clean();
    }
}
