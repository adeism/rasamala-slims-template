<?php
/**
 * Helper Module for Rasamala Template
 */
if (!defined('INDEX_AUTH') || INDEX_AUTH != 1) {
  die("can not access this file directly");
}

require_once __DIR__ . '/language.php';

if (!defined('CURRENT_TEMPLATE_DIR')) {
  global $sysconf;
  $tpl_dir = $sysconf['template']['dir'] ?? 'template';
  $tpl_theme = $sysconf['template']['theme'] ?? 'rasamala';
  define('CURRENT_TEMPLATE_DIR', $tpl_dir . '/' . $tpl_theme . '/');
}

if (!function_exists('assets')) {
  function assets($path = '')
  {
    if (!defined('CURRENT_TEMPLATE_DIR')) {
      global $sysconf;
      $tpl_dir = $sysconf['template']['dir'] ?? 'template';
      $tpl_theme = $sysconf['template']['theme'] ?? 'rasamala';
      define('CURRENT_TEMPLATE_DIR', $tpl_dir . '/' . $tpl_theme . '/');
    }
    return CURRENT_TEMPLATE_DIR . 'assets/' . $path;
  }
}

if (!function_exists('assetVersion')) {
  function assetVersion($absolute_path)
  {
    return is_file($absolute_path) ? filemtime($absolute_path) : (defined('SENAYAN_VERSION') ? SENAYAN_VERSION : '9.5.1');
  }
}

if (!function_exists('assetsVersioned')) {
  function assetsVersioned($path = '')
  {
    return assets($path) . '?v=' . assetVersion(__DIR__ . '/../assets/' . ltrim($path, '/'));
  }
}

// ----------------------------------------------------------------------------
// Get popular title by loan
// ----------------------------------------------------------------------------
if (!function_exists('getPopularBiblio')) {
  function getPopularBiblio($dbs, $limit = 5)
  {
    $limit = themeSafeLimit($limit);

    $stmt = $dbs->prepare("SELECT b.biblio_id, b.title, b.image, COUNT(*) AS total
            FROM loan AS l
            LEFT JOIN item AS i ON l.item_code=i.item_code
            LEFT JOIN biblio AS b ON i.biblio_id=b.biblio_id
            WHERE b.title IS NOT NULL
            GROUP BY b.biblio_id
            ORDER BY total DESC
            LIMIT ?");
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $query = $stmt->get_result();
    $return = array();
    while ($data = $query->fetch_assoc()) {
      $return[] = $data;
    }
    $stmt->close();

    if ($query->num_rows < $limit) {
      $need = $limit - $query->num_rows;
      if ($need < 0) {
        $need = $limit;
      }

      $existing_ids = array_filter(array_column($return, 'biblio_id'));
      $exclude_sql = '';
      if (!empty($existing_ids)) {
        $exclude_sql = " WHERE biblio_id NOT IN (" . implode(',', array_map('intval', $existing_ids)) . ")";
      }

      $sql = "SELECT biblio_id, title, image FROM biblio{$exclude_sql} ORDER BY last_update DESC LIMIT ?";
      $stmt = $dbs->prepare($sql);
      $stmt->bind_param("i", $need);
      $stmt->execute();
      $query = $stmt->get_result();
      while ($data = $query->fetch_assoc()) {
        $return[] = $data;
      }
      $stmt->close();
    }

    return $return;
  }
}

// ----------------------------------------------------------------------------
// Get popular topic by loan
// ----------------------------------------------------------------------------
if (!function_exists('getPopularTopic')) {
  function getPopularTopic($dbs, $limit = 5)
  {
    $limit = themeSafeLimit($limit);

    $stmt = $dbs->prepare("SELECT mt.topic, COUNT(*) AS total
            FROM loan AS l
            LEFT JOIN item AS i ON l.item_code=i.item_code
            LEFT JOIN biblio AS b ON i.biblio_id=b.biblio_id
            LEFT JOIN biblio_topic AS bt ON i.biblio_id=bt.biblio_id
            LEFT JOIN mst_topic AS mt ON bt.topic_id=mt.topic_id
            WHERE mt.topic IS NOT NULL
            GROUP BY mt.topic_id, mt.topic
            ORDER BY total DESC
            LIMIT ?");
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $query = $stmt->get_result();
    $return = array();
    while ($data = $query->fetch_row()) {
      $return[] = $data[0];
    }
    $stmt->close();

    if ($query->num_rows < $limit) {
      $need = $limit - $query->num_rows;
      if ($need < 0) {
        $need = $limit;
      }

      $existing_topics = array_filter($return);
      $exclude_sql = '';
      if (!empty($existing_topics)) {
        $topic_placeholders = implode(',', array_fill(0, count($existing_topics), '?'));
        $exclude_sql = " AND mt.topic NOT IN (" . $topic_placeholders . ")";
      }

      $sql = "SELECT mt.topic, COUNT(*) AS total
              FROM biblio_topic AS bt
              LEFT JOIN mst_topic AS mt ON bt.topic_id=mt.topic_id
              WHERE mt.topic IS NOT NULL{$exclude_sql}
              GROUP BY mt.topic_id, mt.topic
              ORDER BY total DESC
              LIMIT ?";
      $stmt = $dbs->prepare($sql);
      if (!$stmt) {
        return $return;
      }
      if (!empty($existing_topics)) {
        $bind_types = str_repeat('s', count($existing_topics)) . 'i';
        $bind_values = array_values($existing_topics);
        $bind_values[] = $need;
        $bind_parameters = [$bind_types];
        foreach ($bind_values as $parameter_index => $parameter_value) {
          $bind_parameters[] = &$bind_values[$parameter_index];
        }
        call_user_func_array([$stmt, 'bind_param'], $bind_parameters);
      } else {
        $stmt->bind_param('i', $need);
      }
      $stmt->execute();
      $query = $stmt->get_result();
      while ($data = $query->fetch_row()) {
        $return[] = $data[0];
      }
      $stmt->close();
    }

    return $return;
  }
}

// ----------------------------------------------------------------------------
// Get latest update collection
// ----------------------------------------------------------------------------
if (!function_exists('getLatestBiblio')) {
  function getLatestBiblio($dbs, $limit = 5)
  {
    $limit = themeSafeLimit($limit);

    $sql = "SELECT biblio_id, title, image
            FROM biblio
            ORDER BY last_update DESC
            LIMIT ?";
    $stmt = $dbs->prepare($sql);
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $query = $stmt->get_result();
    $return = array();
    while ($data = $query->fetch_assoc()) {
      $return[] = $data;
    }
    $stmt->close();

    return $return;
  }
}

// ----------------------------------------------------------------------------
// Get random collection
// ----------------------------------------------------------------------------
if (!function_exists('getRandomBiblio')) {
  function getRandomBiblio($dbs, $limit = 5)
  {
    $limit = themeSafeLimit($limit);

    $return = array();
    $seen = array();

    // Rewritten (T-04): the old GROUP BY biblio_author.biblio_id collapsed
    // every author-less biblio into a single NULL group (those titles never
    // appeared), returned a sequential slice instead of random rows, and
    // applied a biblio-row COUNT as an offset over author groups.
    $max_query = $dbs->query("SELECT MAX(biblio_id) AS max_id FROM biblio");
    $max_id = 0;
    if ($max_query) {
      $row = $max_query->fetch_row();
      $max_id = (int)($row[0] ?? 0);
    }
    if ($max_id < 1) {
      return $return;
    }

    // Indexed random sampling: pick a random id, then take the next existing
    // row. Each probe is an indexed range scan, so this stays cheap even on
    // large catalogs (unlike ORDER BY RAND() over the whole table).
    $sql = "SELECT b.biblio_id, b.title, b.image,
                   GROUP_CONCAT(DISTINCT ma.author_name ORDER BY ma.author_name SEPARATOR ' - ') AS author
            FROM biblio AS b
            LEFT JOIN biblio_author AS ba ON ba.biblio_id=b.biblio_id
            LEFT JOIN mst_author AS ma ON ma.author_id=ba.author_id
            WHERE b.biblio_id >= ?
            GROUP BY b.biblio_id, b.title, b.image
            ORDER BY b.biblio_id ASC
            LIMIT 1";
    $stmt = $dbs->prepare($sql);
    if (!$stmt) {
      return $return;
    }

    $attempts = 0;
    $max_attempts = $limit * 10 + 10; // bounded: sparse/deleted id ranges
    while (count($return) < $limit && $attempts < $max_attempts) {
      $attempts++;
      $rand_id = function_exists('random_int') ? random_int(1, $max_id) : mt_rand(1, $max_id);
      $stmt->bind_param("i", $rand_id);
      $stmt->execute();
      $query = $stmt->get_result();
      if (!$query) {
        continue;
      }
      $data = $query->fetch_assoc();
      if (!$data || isset($seen[(int)$data['biblio_id']])) {
        continue;
      }
      $seen[(int)$data['biblio_id']] = true;
      $return[] = $data;
    }
    $stmt->close();

    return $return;
  }
}

// ----------------------------------------------------------------------------
// Get latest update topics
// ----------------------------------------------------------------------------
if (!function_exists('getLatestTopic')) {
  function getLatestTopic($dbs, $limit = 5)
  {
    $limit = themeSafeLimit($limit);

    $sql = "SELECT mt.topic
            FROM biblio_topic AS bt
            LEFT JOIN biblio AS b ON bt.biblio_id=b.biblio_id
            LEFT JOIN mst_topic AS mt ON mt.topic_id=bt.topic_id
            WHERE mt.topic IS NOT NULL
            GROUP BY mt.topic_id, mt.topic
            ORDER BY max(b.last_update) DESC
            LIMIT ?";

    $stmt = $dbs->prepare($sql);
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $query = $stmt->get_result();
    $return = array();
    while ($data = $query->fetch_row()) {
      $return[] = $data[0];
    }
    $stmt->close();

    return $return;
  }
}

// ----------------------------------------------------------------------------
// Get topics from biblio
// ----------------------------------------------------------------------------
if (!function_exists('getTopic')) {
  function getTopic($dbs, $biblio_id)
  {
    $biblio_id = themeSafeInt($biblio_id);

    $stmt = $dbs->prepare("SELECT topic FROM biblio_topic AS bt JOIN mst_topic AS mt ON bt.topic_id=mt.topic_id WHERE bt.biblio_id=?");
    $stmt->bind_param("i", $biblio_id);
    $stmt->execute();
    $query = $stmt->get_result();
    $return = array();
    while ($data = $query->fetch_row()) {
      $return[] = $data[0];
    }
    $stmt->close();

    return $return;
  }
}

// ----------------------------------------------------------------------------
// Get active members
// ----------------------------------------------------------------------------
if (!function_exists('getActiveMembers')) {
  function getActiveMembers($dbs, $year, $limit = 3)
  {
    $year = themeSafeYear($year);
    $limit = themeSafeLimit($limit, 3, 1, 20);

    $sql = "SELECT m.member_name, mm.member_type_name, m.member_image, COUNT(*) AS total, GROUP_CONCAT(i.biblio_id SEPARATOR ';') AS biblio_id
            FROM loan AS l
            LEFT JOIN member AS m ON l.member_id=m.member_id
            LEFT JOIN mst_member_type AS mm ON m.member_type_id=mm.member_type_id
            LEFT JOIN item As i ON l.item_code=i.item_code
            WHERE
              l.loan_date LIKE ? AND
              m.member_name IS NOT NULL
            GROUP BY m.member_id
            ORDER BY total DESC
            LIMIT ?";

    $stmt = $dbs->prepare($sql);
    $like_year = $year . '-%';
    $stmt->bind_param("si", $like_year, $limit);
    $stmt->execute();
    $query = $stmt->get_result();
    $return = array();
    if ($query) {
      while ($data = $query->fetch_assoc()) {
        $title = array_unique(explode(';', $data['biblio_id']));
        $return[] = array(
          'name' => $data['member_name'],
          'type' => $data['member_type_name'],
          'image' => $data['member_image'],
          'total' => $data['total'],
          'total_title' => count($title),
          'order' => $data['total']+count($title));
      }
    }
    $stmt->close();

    usort($return, function ($a, $b) {
      return $b['order'] <=> $a['order'];
    });

    return $return;
  }
}

// ----------------------------------------------------------------------------
// Get thumbnail image url
// ----------------------------------------------------------------------------
if (!function_exists('getImagePath')) {
  function getImagePath($sysconf, $image, $path = 'docs')
  {
    $path = basename($path);
    $image = basename($image);

    $thumb_url = '';
    // Encoded exactly once (S-04): the filename parameter below is urlencoded
    // again, so pre-encoding here produced %2520-style thumbnail 404s.
    $images_loc = 'images/' . $path . '/' . $image;
    $img_status = pathinfo('images/' . $path . '/' . $image);
    if(isset($img_status['extension'])){
      $thumb_url = './lib/minigalnano/createthumb.php?filename=' . urlencode($images_loc) . '&width=120';
    }else{
      $thumb_url = './lib/minigalnano/createthumb.php?filename=images/default/image.png&width=120';   
    }

    return $thumb_url;
  }
}

// ----------------------------------------------------------------------------
// Truncate a string only at a whitespace
// ----------------------------------------------------------------------------
if (!function_exists('truncate')) {
  function truncate($text, $length)
  {
    $length = abs((int)$length);
    if (strlen($text) > $length) {
      $text = preg_replace("/^(.{1,$length})(\s.*|$)/s", '\\1...', $text);
    }
    return ($text);
  }
}

// ----------------------------------------------------------------------------
// Get query params value
// ----------------------------------------------------------------------------
if (!function_exists('getQuery')) {
  function getQuery($key, $optional = '')
  {
    return isset($_GET[$key]) ? utility::filterData($key, 'get', true, true, true) : $optional;
  }
}

if (!function_exists('themeGenerateUrlQrSvg')) {
  function themeGenerateUrlQrSvg($url = '', $size = 180)
  {
    $url = trim((string)$url);
    if ($url === '') {
      return '';
    }

    if (class_exists('BaconQrCode\Writer')) {
      try {
        $renderer = new \BaconQrCode\Renderer\ImageRenderer(
          new \BaconQrCode\Renderer\RendererStyle\RendererStyle((int)$size, 1),
          new \BaconQrCode\Renderer\Image\SvgImageBackEnd()
        );
        $writer = new \BaconQrCode\Writer($renderer);
        $qrcode_svg = $writer->writeString($url);
        return preg_replace('/<\?xml[^>]*\?>/', '', $qrcode_svg);
      } catch (\Exception $e) {
        // Fallback
      }
    }

    return '';
  }
}
