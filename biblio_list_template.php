<?php
/**
 * Template for Biblio List
 * name of memberID text field must be: memberID
 * name of institution text field must be: institution
 *
 * Copyright (C) 2015 Arie Nugraha (dicarve@gmail.com)
 * Create by Eddy Subratha (eddy.subratha@slims.web.id)
 * @Last modified by    : Ade Ismail Siregar (adeismailbox@gmail.com)
 * @Last modified time  : 2026-07-09T09:16:12+07:00
 *
 * Slims 8 (Akasia)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 */
use SLiMS\Url;
include_once __DIR__ . '/theme_helpers.php';
$label_cache = array();
/**
 *
 * Format bibliographic item list for OPAC display
 *
 * @param   object $dbs
 * @param   array $biblio_detail
 * @param   int $n
 * @param   array $settings
 * @param   array $return_back
 *
 * @return string
 */
function biblio_list_format($dbs, $biblio_detail, $n, $settings = array(), &$return_back = array()) {
    global $label_cache, $sysconf;
    // init output var
    $output     = '';

    $title      = (string)($biblio_detail['title'] ?? '');
    $biblio_id  = themeSafeInt($biblio_detail['biblio_id'] ?? 0);
    $keywords   = (string)($settings['keywords'] ?? '');
    $detail_url_raw = SWB.'index.php?p=show_detail&id='.$biblio_id.'&keywords='.urlencode($keywords);
    $cite_url_raw   = SWB.'index.php?p=cite&id='.$biblio_id.'&keywords='.urlencode($keywords);
    $detail_url = themeEscape($detail_url_raw);
    $cite_url   = themeEscape($cite_url_raw);
    $title_search_html = themeParallelTitleHtml($title, 'search');
    $title_grid_html = themeParallelTitleHtml($title, 'grid');
    $title_attr = themeEscape(str_replace('{title}', substr(strip_tags($title), 0, 50), __('Citation for: {title}')));
    $current_view = $_POST['view'] ?? $_SESSION['LIST_VIEW'] ?? 'simple';
    if (!in_array($current_view, ['simple', 'list', 'grid'], true)) {
        $current_view = 'simple';
    }
    // $title_link = '<a href="'.$detail_url.'" class="titleField" itemprop="name" property="name" title="'.__('View record detail description for this title').'">'.$title.'</a>';

    // image thumbnail
    $thumb_url = '';
    if ($current_view !== 'simple') {
        $images_loc = 'images/docs/'.basename((string)($biblio_detail['image'] ?? ''));
        if(($biblio_detail['image'] ?? '') == '' || ($biblio_detail['image'] ?? '') == NULL){
            $images_loc = 'images/default/image.png';
        }
        $thumb_url = './lib/minigalnano/createthumb.php?filename='.urlencode($images_loc).'&width=240';
    }

    // notes
    $notes = '';
    $custom_field = '';
    $grid_item_content = '';
    $i = 0;
    $expand = true;
    if ($current_view !== 'simple') {
        $notes = themeSanitizeHtml(getNotes($dbs, $biblio_id));
    }
    if ($current_view !== 'simple' && $settings['enable_custom_frontpage'] AND $settings['custom_fields']) {
        $custom_field = '<dl class="row text-sm">';
        foreach ($settings['custom_fields'] as $field => $field_opts) {
            if ($field_opts[0] == 1) {
                $field_value = (trim($biblio_detail[$field]??'') !== '' ? $biblio_detail[$field] : '-');
                $custom_field .= '<dt class="col-sm-3">'.themeEscape($field_opts[1]).'</dt><dd class="col-sm-9">'.themeEscape($field_value).'</dd>';
                $grid_item_content .= '<li class="list-group-item"><label>'.themeEscape($field_opts[1]).'</label><span class="text-right">'.themeEscape($field_value).'</span></li>';
                $i++;
            }
        }
        $custom_field .= '</dl>';
    }
    if ($current_view !== 'simple' && empty($notes)) {
        $notes = $custom_field;
        $expand = false;
    }

    // availability
    $simple_item_data = ['items' => [], 'total' => 0, 'available' => 0];
    if ($current_view === 'simple') {
        $simple_item_data = rasamalaGetItemsAndAvailability($dbs, $biblio_id);
        $availability = $simple_item_data['available'];
    } else {
        $availability = getAvailability($dbs, $biblio_id, $sysconf);
    }
    $class_avail = ($availability > 0) ? '' : 'text-danger';

    // authors
    $_authors = isset($biblio_detail['author'])?$biblio_detail['author']:biblio_list_model::getAuthors($dbs, $biblio_id, true);
    $_authors_string = '';
    $_authors_plain = themeEscape('-');
    if ($_authors) {
        if (!is_array($_authors)) {
            $_authors = explode('-', $_authors);
        }
        $_author_names = [];
        foreach ($_authors as $a) {
            $a = trim($a);
            if ($a === '') {
                continue;
            }
            $_author_names[] = $a;
            $_authors_string .= '<a href="index.php?author='.urlencode($a).'&search=Search" itemprop="name" property="name" class="btn btn-outline-secondary btn-rounded">'.themeEscape($a).'</a>';
        }
        if ($_author_names) {
            $_authors_plain = themeEscape(implode('; ', $_author_names));
        }
    }

    if ($current_view === 'simple'):
        $availability_icon = $availability > 0 ? 'fas fa-check-circle' : 'fas fa-times-circle';
        $availability_status_class = $availability > 0 ? 'biblio-avail-ok' : 'biblio-avail-no';
        $availability_title = $availability > 0 ? __('Available') : __('Not Available');
        $item_rows = '';

        foreach ($simple_item_data['items'] as $item) {
            $item_code = themeEscape($item['item_code'] ?? '-');
            $call_number = themeEscape($item['call_number'] ?? '-');
            $location = themeEscape($item['location_name'] ?? '-');
            $status_icon = ((int)($item['is_available'] ?? 0) === 1)
                ? '<i class="fas fa-check-circle biblio-avail-row-ok" aria-label="'.themeEscape(__('Available')).'"></i>'
                : '<i class="fas fa-times-circle biblio-avail-row-no" aria-label="'.themeEscape(__('Not Available')).'"></i>';
            $item_rows .= '<tr><td>'.$item_code.'</td><td>'.$call_number.'</td><td>'.$location.'</td><td class="text-center">'.$status_icon.'</td></tr>';
        }

        $output .= '<article id="card-' . $biblio_id . '" class="biblio-simple-item">';
        $output .= '<div class="biblio-simple-main">';
        $output .= '<a title="'.themeEscape(__('View record detail description for this title')).'" class="biblio-simple-title" href="'.$detail_url.'">'.$title_search_html.'</a>';
        $output .= '<div class="biblio-simple-author">'.$_authors_plain.'</div>';
        $output .= '</div>';
        $output .= '<div class="biblio-simple-availability biblio-avail-wrap '.$class_avail.'" aria-label="'.themeEscape(__('Availability')).'">';
        $output .= '<button type="button" class="biblio-avail-badge '.$availability_status_class.'" title="'.themeEscape($availability_title).'">';
        $output .= '<i class="'.$availability_icon.'" aria-hidden="true"></i>';
        $output .= '<span class="biblio-simple-availability-count">'.themeSafeInt($availability).'</span>';
        $output .= '</button>';
        if ($item_rows !== '') {
            $output .= '<div class="biblio-avail-popover" role="dialog" aria-label="'.themeEscape(__('Item Detail')).'">';
            $output .= '<div class="biblio-avail-popover-title">'.themeEscape(__('Item Detail')).' ('.themeSafeInt($simple_item_data['total']).')</div>';
            $output .= '<table class="biblio-avail-popover-table">';
            $output .= '<thead><tr><th>'.themeEscape(__('Code')).'</th><th>'.themeEscape(__('Call Number')).'</th><th>'.themeEscape(__('Location')).'</th><th class="text-center">'.themeEscape(__('Status')).'</th></tr></thead>';
            $output .= '<tbody>'.$item_rows.'</tbody>';
            $output .= '</table>';
            $output .= '</div>';
        }
        $output .= '</div>';
        $output .= '</article>';

    elseif ($current_view === 'list'):

        $output .= '<div id="card-' . $biblio_id . '" class="card item border-0 elevation-1 mb-6">';
        $output .= '<div class="card-body">';
        $output .= '<div class="row">';
        $output .= '<div class="col-12 col-md-2">';
        $output .= '<img loading="lazy" src="'.themeEscape($thumb_url).'" alt="cover" class="img-fluid rounded '.($availability > 0 ?: 'not-available').'" title="' . themeEscape($availability > 0 ? '' :  __('Items is not available')) . '"/>';
        $output .= '</div>'; // -- close col-2
        $output .= '<div class="col-12 col-md-8">';
        $output .= '<h5><a title="'.themeEscape(__('View record detail description for this title')).'" class="card-link" href="'.$detail_url.'">'.$title_search_html.'</a></h5>';
        $output .= createButton($biblio_id, $biblio_detail['title']);
        $output .= '<div class="d-flex authors flex-wrap py-2">';
        $output .= $_authors_string;
        $output .= '</div>'; // -- close d-flex authors flex-wrap
        $output .= '<p>'.$notes.'</p>';
        $output .= '<div id="expand-'.$biblio_id.'" class="collapse py-2 collapse-detail">'.$custom_field.'</div>';
        $output .= '</div>'; // -- close col-8
        $output .= '<div class="col-md-2 d-none d-md-block">';
        $output .= '<div class="card availability cursor-pointer">';
        $output .= '<div class="card-body pt-3 pb-2 px-1">';
        $output .= '<div class="d-flex availability-content flex-column">';
        $output .= '<span class="label">'.__('Availability').'</span>';
        $output .= '<span class="value '.$class_avail.'">'.themeSafeInt($availability).'</span>';
        $output .= '</div>'; // -- close d-flex flex-column
        $output .= '<div class="add-to-chart add-to-chart-button align-items-center justify-content-center flex-column" data-biblio="'.$biblio_id.'">';
        $output .= '<span class="label">'. __('Add to basket') .'</span>';
        $output .= '<span class="value"><i class="fas fa-plus"></i></span>';
        $output .= '</div>'; // -- close d-flex flex-column
        $output .= '</div>'; // -- close card-body pt-3 pb-2 px-1
        $output .= '</div>'; // -- close card availability
        //  $output .= '<a class="btn btn-outline-primary btn-block mt-2 btn-sm" href="'.$detail_url.'">'.__('View Detail').'</a>';
        $output .= '<a class="btn btn-outline-secondary btn-block mt-2 btn-sm" href="'.themeEscape($detail_url_raw.'&MARC=true').'" title="'.themeEscape(__('Download detail data in MARC')).'" target="_blank" rel="noopener noreferrer">'.themeEscape(__('MARC Download')).'</a>';
        $output .= '<a class="btn btn-outline-secondary btn-block mt-2 btn-sm openPopUp citationLink" href="'.$cite_url.'" title="'.$title_attr.'" target="_blank" rel="noopener noreferrer">'.themeEscape(__('Cite')).'</a>';
        $output .= '</div>'; // -- close col-2
        $output .= '</div>'; // -- close row
        if ($i > 0 && $expand) {
            $output .= '<div class="expand"><a id="btn-expand-'.$biblio_id.'" class="d-flex justify-content-center text-decoration-none py-2" data-toggle="collapse" href="#expand-'.$biblio_id.'" role="button" aria-expanded="false" aria-controls="expand-'.$biblio_id.'"><i class="fas fa-angle-double-down"></i></a></div>';
        }
        $output .= '</div>';
        $output .= '</div>';

    else:

        $output .= '<div class="col-md-3 px-2 grid-item">';
        $output .= '<div class="card p-0 mb-3">';
        $__ = '__';
        $title_cite = $title_attr;
        $marc_url = themeEscape($detail_url_raw.'&MARC=true');
        $add_to_basket_text = themeEscape(__('Add to basket'));
        $marc_text = themeEscape(__('MARC Download'));
        $cite_text = themeEscape(__('Cite'));
        $output .= <<<HTML
<div class="grid-item--menu dropdown">
    <a class="dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false" data-display="static">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
            <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
        </svg>
    </a>
    <div class="dropdown-menu dropdown-menu-right text-sm">
        <a class="dropdown-item text-left px-3" href="{$marc_url}">{$marc_text}</a>
        <a class="dropdown-item text-left px-3 openPopUp citationLink" href="{$cite_url}" title="{$title_cite}">{$cite_text}</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item text-left px-3 add-to-chart-button" data-biblio="{$biblio_id}" href="#">{$add_to_basket_text}</a>
    </div>
</div>
HTML;
        $output .= '<div class="p-4 d-flex justify-content-center align-items-center bg-apple-light">';
        $output .= '<img loading="lazy" src="'.themeEscape($thumb_url).'" class="img-fluid img-thumbnail shadow '.($availability > 0 ?: 'not-available').'" title="' . themeEscape($availability > 0 ? '' :  __('Items is not available')) . '"/>';
        $output .= '</div>';
        $output .= '<div class="card-body p-2">';
        $output .= '<a href="'.$detail_url.'" class="text-sm text-decoration-none grid-item--title m-0">'.$title_grid_html.'</a>';
        $output .= '</div>';
        $output .= '<ul class="list-group list-group-flush">';
        $output .= $grid_item_content;
        if ($availability < 1) {
            $output .= '<li class="list-group-item text-danger"><span></span><span class="text-center">'.__('Item Not Available').'</span></li>';
        }
        $output .= '</ul>';
        $output .= '</div>';
        $output .= '</div>';

    endif;

    // debug
    // $output .= '<code>'.json_encode($biblio_detail).'</code>';

    return $output;
}

function getNotes($dbs, $biblio_id)
{
    $biblio_id = themeSafeInt($biblio_id);
    $query = $dbs->query('SELECT notes FROM biblio WHERE biblio_id = ' . $biblio_id);
    $data = $query->fetch_row();
    return addEllipsis($data[0] ?? '', 400);
}

function addEllipsis($string, $length, $end='…')
{
    if (strlen($string??'') > $length)
    {
        $length -= strlen($end);
        $string  = substr($string, 0, $length);
        $string .= $end;
    }

    return $string;
}

function getAvailability($dbs, $biblio_id, $sysconf)
{
    $biblio_id = themeSafeInt($biblio_id);
    // get total number of this biblio items/copies
    $_item_q = $dbs->query('SELECT COUNT(*) FROM item WHERE biblio_id='.$biblio_id);
    $_item_c = $_item_q->fetch_row();
    // get total number of currently borrowed copies
    $_borrowed_q = $dbs->query('SELECT COUNT(*) FROM loan AS l INNER JOIN item AS i'
        .' ON l.item_code=i.item_code WHERE l.is_lent=1 AND l.is_return=0 AND i.biblio_id='.$biblio_id);
    $_borrowed_c = $_borrowed_q->fetch_row();
    // total available
    $_total_avail = $_item_c[0]-$_borrowed_c[0];

    return $_total_avail;
}

function rasamalaGetItemsAndAvailability($dbs, $biblio_id)
{
    $biblio_id = themeSafeInt($biblio_id);
    $items = [];
    $total = 0;
    $available = 0;
    $sql = "SELECT i.item_code, i.call_number, ml.location_name,
                   CASE
                       WHEN IFNULL(mis.no_loan, 0)=1 THEN 0
                       WHEN EXISTS(
                           SELECT 1 FROM loan AS l
                           WHERE l.item_code=i.item_code
                             AND l.is_lent=1
                             AND l.is_return=0
                       ) THEN 0
                       ELSE 1
                   END AS is_available
            FROM item AS i
            LEFT JOIN mst_location AS ml ON i.location_id=ml.location_id
            LEFT JOIN mst_item_status AS mis ON i.item_status_id=mis.item_status_id
            WHERE i.biblio_id=".$biblio_id."
            ORDER BY i.call_number ASC, i.item_code ASC";
    $query = $dbs->query($sql);

    if ($query) {
        while ($row = $query->fetch_assoc()) {
            $row['is_available'] = themeSafeInt($row['is_available'] ?? 0);
            $items[] = $row;
            $total++;
            if ($row['is_available'] > 0) {
                $available++;
            }
        }
    }

    return [
        'items' => $items,
        'total' => $total,
        'available' => $available,
    ];
}

function createButton(int $biblio_id, string $title)
{
    $biblio_id = themeSafeInt($biblio_id);
    $commentUrlCondition = (utility::isMemberLogin() ? 
                                Url::getSlimsBaseUri('?p=show_detail&id=' . $biblio_id . '#comment') : 
                                Url::getSlimsBaseUri('?p=member&destination=' . Url::getSlimsBaseUri('?p=show_detail&id=' . $biblio_id . '#comment')->encode()));

    list($comment,$bookmark,$share) = [__('Comment'), (in_array($biblio_id, $_SESSION['bookmark']??[]) ? __('Bookmarked') : __('Bookmark')),__('Share')];

    $setBookmarked = trim(isset($_SESSION['bookmark'][$biblio_id]) ? 'bg-success text-white rounded-lg' : 'text-muted');
    $commentUrlCondition = themeEscape((string)$commentUrlCondition);
    $comment = themeEscape($comment);
    $bookmark = themeEscape($bookmark);
    $share = themeEscape($share);
    $title_attr = themeEscape($title);
    return <<<HTML
    <div class="d-flex flex-row text-xs my-1">
        <a href="{$commentUrlCondition}" class="text-decoration-none font-weight-bolder mr-1 px-2 py-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-left-dots" viewBox="0 0 16 16">
                <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                <path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
            </svg>
            {$comment}
        </a>
        <a href="javascript:void(0)" data-id="{$biblio_id}" class="bookMarkBook text-decoration-none font-weight-bolder mr-1 px-2 py-1 {$setBookmarked}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-postcard-heart" viewBox="0 0 16 16">
                <path d="M8 4.5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7Zm3.5.878c1.482-1.42 4.795 1.392 0 4.622-4.795-3.23-1.482-6.043 0-4.622ZM2.5 5a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3Zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3Zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3Z"/>
                <path fill-rule="evenodd" d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H2Z"/>
            </svg>
            <label id="label-{$biblio_id}" class="m-0 cursor-pointer">{$bookmark}</label>
        </a>
        <a href="javascript:void(0)" data-id="{$biblio_id}" data-title="{$title_attr}" data-toggle="modal" data-target="#mediaSocialModal" class="text-decoration-none font-weight-bolder mr-1 px-2 py-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-share" viewBox="0 0 16 16">
                <path d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l-6.718-3.12A2.5 2.5 0 0 1 11 2.5zm-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3z"/>
            </svg>
            {$share}
        </a>
    </div>
    HTML;
}
