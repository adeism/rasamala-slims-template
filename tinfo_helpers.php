<?php
/**
 * Helper output for Rasamala theme customization fields.
 *
 * @Last modified by    : Ade Ismail Siregar (adeismailbox@gmail.com)
 * @Last modified time  : 2026-07-09T15:02:26+07:00
 */
if (!defined('INDEX_AUTH') || INDEX_AUTH != 1) {
  die("can not access this file directly");
}

if (!function_exists('rasamalaTinfoTopicIconOptions')) {
  function rasamalaTinfoTopicIconOptions()
  {
    return [
      ['value' => 'fas fa-book', 'label' => 'Book'],
      ['value' => 'fas fa-users', 'label' => 'Users'],
      ['value' => 'fas fa-flask', 'label' => 'Science'],
      ['value' => 'fas fa-paint-brush', 'label' => 'Art'],
      ['value' => 'fas fa-th-large', 'label' => 'Grid'],
      ['value' => 'fas fa-desktop', 'label' => 'Computer'],
      ['value' => 'fas fa-university', 'label' => 'University'],
      ['value' => 'fas fa-graduation-cap', 'label' => 'Education'],
      ['value' => 'fas fa-globe', 'label' => 'Globe'],
      ['value' => 'fas fa-history', 'label' => 'History'],
      ['value' => 'fas fa-map', 'label' => 'Map'],
      ['value' => 'fas fa-language', 'label' => 'Language'],
      ['value' => 'fas fa-calculator', 'label' => 'Calculator'],
      ['value' => 'fas fa-archive', 'label' => 'Archive'],
      ['value' => 'fas fa-newspaper', 'label' => 'News'],
      ['value' => 'fas fa-info-circle', 'label' => 'Info'],
      ['value' => 'fas fa-search', 'label' => 'Search'],
      ['value' => 'fas fa-star', 'label' => 'Star'],
      ['value' => 'fas fa-leaf', 'label' => 'Leaf'],
      ['value' => 'fas fa-lightbulb', 'label' => 'Idea'],
      ['value' => 'fas fa-cog', 'label' => 'Settings'],
      ['value' => 'fas fa-tags', 'label' => 'Tags'],
      ['value' => 'fas fa-ellipsis-h', 'label' => 'More'],
    ];
  }
}

if (!function_exists('rasamalaTinfoCustomizeAssets')) {
  function rasamalaTinfoCustomizeAssets()
  {
    global $sysconf;

    $theme_dir = 'rasamala';
    $template_dir = $sysconf['template']['dir'] ?? 'template';
    $asset_base = (defined('SWB') ? SWB : '') . $template_dir . '/' . $theme_dir . '/assets/';
    $fontawesome_css = htmlspecialchars($asset_base . 'plugin/font-awesome/css/fontawesome-all.min.css', ENT_QUOTES, 'UTF-8');
    $icon_options_json = json_encode(rasamalaTinfoTopicIconOptions(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
    $asset_base_json = json_encode($asset_base, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
    $default_announcement_json = json_encode("<strong>Info layanan:</strong> Perpustakaan buka Senin-Jumat, pukul 08.00-16.00 WIB.\n<a href=\"index.php?p=libinfo\">Lihat informasi lengkap</a>.", JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
    $default_custom_css_json = json_encode("/* Custom CSS Rasamala\n   Edit contoh di bawah ini sesuai kebutuhan. */\n\n/* Contoh: ubah ukuran nama perpustakaan di navbar */\n/* .navbar-lib-name {\n  font-size: 14px !important;\n} */\n\n/* Contoh: beri jarak tambahan pada judul hero */\n/* .hero-search-heading h1 {\n  margin-bottom: 16px !important;\n} */\n\n/* Contoh: custom warna tombol utama */\n/* .btn-primary {\n  background-color: var(--theme-accent-color) !important;\n  border-color: var(--theme-accent-color) !important;\n} */", JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);

    return <<<HTML
<link rel="stylesheet" href="{$fontawesome_css}">
<style>
#navbar-menu-builder-container,
#topic-items-builder-container {
    border: 1px solid #E0E0E0;
    background: #FFFFFF;
    padding: 15px;
    border-radius: 4px;
    margin-top: 5px;
}
.menu-builder-row,
.topic-builder-row {
    gap: 10px;
    display: flex;
    align-items: center;
    margin-bottom: 8px;
    flex-wrap: nowrap;
}
.topic-builder-item {
    border-bottom: 1px solid #F0F0F0;
    margin-bottom: 10px;
    padding-bottom: 10px;
}
.menu-builder-row input,
.topic-builder-row input {
    margin-bottom: 0 !important;
}
.menu-builder-row.is-invalid input,
.topic-builder-row.is-invalid input {
    border-color: #dc3545;
}
.navbar-menu-builder-help,
.topic-items-builder-help {
    color: #666;
    font-size: 12px;
    margin-bottom: 10px;
}
.topic-icon-preview {
    width: 42px;
    height: 38px;
    flex: 0 0 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #E0E0E0;
    border-radius: 4px;
    background: #F8F9FA;
    color: #495057;
    font-size: 22px;
    line-height: 1;
    cursor: pointer;
    transition: border-color 0.2s ease, background-color 0.2s ease, color 0.2s ease, box-shadow 0.2s ease;
}
.topic-icon-preview:hover,
.topic-builder-item.is-icon-picker-open .topic-icon-preview {
    border-color: #28a745;
    background: #ECF8F0;
    color: #155724;
    box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.12);
}
.topic-icon-preview:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.24);
}
.topic-icon-preview i {
    display: inline-block;
    font-style: normal;
    line-height: 1;
}
.topic-icon-preview img {
    max-width: 28px;
    max-height: 28px;
    object-fit: contain;
}
.topic-icon-input[readonly] {
    background: #F8F9FA;
}
.topic-icon-palette {
    display: none;
    grid-template-columns: repeat(auto-fill, minmax(112px, 1fr));
    gap: 6px;
    margin: 6px 0 0 52px;
    padding: 10px;
    border: 1px solid #E0E0E0;
    border-radius: 4px;
    background: #F8F9FA;
}
.topic-builder-item.is-icon-picker-open .topic-icon-palette {
    display: grid;
}
.topic-icon-choice {
    display: flex;
    align-items: center;
    gap: 7px;
    min-height: 38px;
    padding: 6px 8px;
    border: 1px solid #DDE2E6;
    border-radius: 4px;
    background: #FFFFFF;
    color: #495057;
    font-size: 11px;
    line-height: 1.2;
    text-align: left;
    cursor: pointer;
}
.topic-icon-choice:hover,
.topic-icon-choice.active {
    border-color: #28a745;
    background: #ECF8F0;
    color: #155724;
}
.topic-icon-choice i {
    width: 22px;
    flex: 0 0 22px;
    font-size: 18px;
    text-align: center;
}
.topic-icon-choice-text {
    display: flex;
    flex-direction: column;
    min-width: 0;
}
.topic-icon-choice-label,
.topic-icon-choice-code {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.topic-icon-choice-code {
    color: #6c757d;
    font-size: 10px;
}
.topic-icon-custom-row {
    grid-column: 1 / -1;
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 4px;
    padding-top: 8px;
    border-top: 1px solid #E0E0E0;
}
.topic-icon-custom-label {
    flex: 0 0 auto;
    color: #666;
    font-size: 11px;
    white-space: nowrap;
}
.topic-icon-custom-input {
    min-width: 0;
    margin-bottom: 0 !important;
    font-size: 12px;
}
</style>
<script>
$(document).ready(function() {
    var topicIconOptions = {$icon_options_json};
    var topicAssetBase = {$asset_base_json};
    var defaultAnnouncementText = {$default_announcement_json};
    var defaultCustomCss = {$default_custom_css_json};

    function fillEmptyTextarea(name, value) {
        var field = $('textarea[name="' + name + '"]');
        if (field.length && field.val().trim() === '') {
            field.val(value);
        }
    }

    fillEmptyTextarea('classic_announcement_text', defaultAnnouncementText);
    fillEmptyTextarea('classic_custom_css', defaultCustomCss);

    function isSafeBuilderUrl(url) {
        url = String(url || '').trim();
        if (url === '' || /[\\x00-\\x1f\\x7f|;]/.test(url)) return false;
        if (url.charAt(0) === '#') return true;
        if (url.indexOf('//') === 0) return false;
        try {
            var parsed = new URL(url, window.location.origin);
            var rawScheme = url.match(/^([a-z][a-z0-9+.-]*):/i);
            if (rawScheme) {
                return ['http:', 'https:', 'mailto:', 'tel:'].indexOf(parsed.protocol) !== -1;
            }
            return true;
        } catch (e) {
            return false;
        }
    }

    function cleanBuilderText(text) {
        return String(text || '').replace(/[|;\\r\\n]/g, ' ').replace(/\\s+/g, ' ').trim();
    }

    function cleanTopicIcon(icon) {
        return String(icon || '').replace(/[|;\\r\\n]/g, ' ').replace(/\\s+/g, ' ').trim();
    }

    function isFontAwesomeIcon(icon) {
        return /^(fa[brs]?|fas|far|fab)\\s+[a-z0-9 _-]+$/i.test(cleanTopicIcon(icon));
    }

    function isImageIcon(icon) {
        icon = cleanTopicIcon(icon);
        return /^https:\\/\\//i.test(icon) || /\\.(png|jpe?g|gif|webp|svg)$/i.test(icon);
    }

    function iconSrc(icon) {
        icon = cleanTopicIcon(icon).replace(/^\\/+/, '');
        if (/^https:\\/\\//i.test(icon)) return icon;
        return topicAssetBase + icon;
    }

    function hasIconOption(icon) {
        icon = cleanTopicIcon(icon);
        return topicIconOptions.some(function(option) {
            return option.value === icon;
        });
    }

	    function updateIconPreview(row) {
	        var icon = cleanTopicIcon(row.find('.topic-icon-input').val());
	        var preview = row.find('.topic-icon-preview');
	        preview.empty();
	        preview.attr('title', 'Pilih ikon: ' + (icon || 'fas fa-th-large'));

	        if (isFontAwesomeIcon(icon)) {
	            preview.append($('<i></i>').attr('class', icon));
        } else if (isImageIcon(icon)) {
            preview.append($('<img />').attr('src', iconSrc(icon)).attr('alt', ''));
        } else {
            preview.append($('<i></i>').attr('class', 'fas fa-th-large'));
        }
    }

	    function syncIconPalette(row) {
	        var icon = cleanTopicIcon(row.find('.topic-icon-input').val());
	        var item = row.closest('.topic-builder-item');
	        item.find('.topic-icon-choice').each(function() {
	            $(this).toggleClass('active', cleanTopicIcon($(this).attr('data-icon')) === icon);
	        });
	        item.find('.topic-icon-custom-input').val(icon);
    }

    function buildIconPalette(icon) {
        var palette = $('<div class="topic-icon-palette"></div>');
        icon = cleanTopicIcon(icon);
	        for (var i = 0; i < topicIconOptions.length; i++) {
	            var option = topicIconOptions[i];
            var choice = $('<button type="button" class="topic-icon-choice"></button>')
                .attr('data-icon', option.value)
                .attr('title', option.label + ' - ' + option.value)
                .toggleClass('active', option.value === icon);
            choice.append($('<i></i>').attr('class', option.value).attr('aria-hidden', 'true'));
            choice.append(
                $('<span class="topic-icon-choice-text"></span>')
                    .append($('<span class="topic-icon-choice-label"></span>').text(option.label))
                    .append($('<span class="topic-icon-choice-code"></span>').text(option.value))
            );
	            palette.append(choice);
	        }
	        palette.append(
	            $('<div class="topic-icon-custom-row"></div>')
	                .append($('<span class="topic-icon-custom-label"></span>').text('Custom'))
	                .append($('<input type="text" class="form-control topic-icon-custom-input" placeholder="fas fa-book atau images/icon.png" />').val(icon))
	        );

	        return palette;
    }

    var updateNavbarMenuTextarea = function() {};
    var textarea = $('textarea[name="classic_navbar_menu"]');
    if (textarea.length) {
        textarea.hide();

        function defaultMenuIcon(text, url) {
            var labelKey = cleanBuilderText(text).toLowerCase();
            var parsedP = '';
            try {
                var parsed = new URL(String(url || ''), window.location.origin);
                parsedP = parsed.searchParams.get('p') || '';
            } catch (e) {}

            var key = parsedP || (labelKey === 'home' ? 'home' : labelKey.replace(/[^a-z0-9_-]+/g, '-').replace(/^-+|-+$/g, ''));
            var icons = {
                home: 'fas fa-home',
                libinfo: 'fas fa-info-circle',
                news: 'fas fa-newspaper',
                help: 'fas fa-question-circle',
                librarian: 'fas fa-users',
                login: 'fas fa-user-shield',
                member: 'fas fa-user'
            };

            return icons[key] || 'fas fa-link';
        }

        function pushItem(items, text, url, icon) {
            text = cleanBuilderText(text);
            url = String(url || '').trim();
            if (text !== '' && isSafeBuilderUrl(url)) {
                items.push({text: text, url: url, icon: cleanTopicIcon(icon || defaultMenuIcon(text, url))});
            }
        }

        function parseMenuValue(rawVal) {
            var items = [];
            rawVal = String(rawVal || '').trim();
            if (rawVal === '') return items;

            var lines = rawVal.split(/[;\\n\\r]+/);
            for (var i = 0; i < lines.length; i++) {
                var line = lines[i].trim();
                if (line === '') continue;
                var parts = line.split('|');
                if (parts.length >= 2) {
                    pushItem(items, parts[0], parts[1], parts.slice(2).join('|'));
                }
            }
            return items;
        }

        var legacyDefaultMenu = 'Home | index.php ; Information | index.php?p=libinfo ; News | index.php?p=news ; Help | index.php?p=help ; Librarian | index.php?p=librarian';
        var plainRasamalaDefaultMenu = 'Home | index.php ; Information | index.php?p=libinfo ; News | index.php?p=news ; Help | index.php?p=help ; Librarian | index.php?p=librarian ; Staff Area | index.php?p=login';
        var rasamalaDefaultMenu = 'Home | index.php | fas fa-home ; Information | index.php?p=libinfo | fas fa-info-circle ; News | index.php?p=news | fas fa-newspaper ; Help | index.php?p=help | fas fa-question-circle ; Librarian | index.php?p=librarian | fas fa-users ; Staff Area | index.php?p=login | fas fa-user-shield';
        var rawVal = textarea.val().trim();
        if (rawVal === legacyDefaultMenu || rawVal === plainRasamalaDefaultMenu) {
            rawVal = rasamalaDefaultMenu;
            textarea.val(rawVal);
        }
        var items = parseMenuValue(rawVal);

        var container = $('<div id="navbar-menu-builder-container" class="mt-2"></div>');
        container.append($('<div class="navbar-menu-builder-help"></div>').text('Klik icon di kiri untuk mengganti. Format disimpan sebagai nama menu, URL, dan icon Font Awesome.'));
        var rowsContainer = $('<div id="navbar-menu-rows"></div>');
        container.append(rowsContainer);
        var addBtn = $('<button type="button" class="btn btn-success btn-sm mt-2" id="add-menu-row-btn" title="Tambah Menu" style="padding: 4px 12px; cursor: pointer; font-weight: bold; font-size: 14px;">+</button>');
        container.append(addBtn);
        textarea.after(container);

        var langRow = $('select[name="classic_language_select"]').closest('.form-group, tr, .row');
        var memberRow = $('select[name="classic_member_area"]').closest('.form-group, tr, .row');
        langRow.hide();
        memberRow.hide();

        var extraSettings = $('<div class="navbar-menu-extra-settings mt-3 pt-3" style="border-top: 1px solid #E0E0E0; display: flex; gap: 20px; align-items: center; justify-content: flex-start; flex-wrap: wrap;"></div>');
        var initLangVal = $('select[name="classic_language_select"]').val();
        var langCheckbox = $('<label style="font-weight: 500; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 0; user-select: none;"></label>')
            .append($('<input type="checkbox" class="lang-select-toggle" style="margin: 0 !important; cursor: pointer; width: auto; height: auto;" />').prop('checked', initLangVal == 1))
            .append(' Tampilkan Pilihan Bahasa (Language Selection)');
        extraSettings.append(langCheckbox);

        var initMemberVal = $('select[name="classic_member_area"]').val();
        var memberCheckbox = $('<label style="font-weight: 500; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 0; user-select: none;"></label>')
            .append($('<input type="checkbox" class="member-area-toggle" style="margin: 0 !important; cursor: pointer; width: auto; height: auto;" />').prop('checked', initMemberVal == 1))
            .append(' Tampilkan Area Anggota (Member Area)');
        extraSettings.append(memberCheckbox);

        container.append(extraSettings);

        $(document).on('change', '.lang-select-toggle', function() {
            $('select[name="classic_language_select"]').val($(this).is(':checked') ? '1' : '0').trigger('change');
        });

        $(document).on('change', '.member-area-toggle', function() {
            $('select[name="classic_member_area"]').val($(this).is(':checked') ? '1' : '0').trigger('change');
        });

        function updateTextarea() {
            var itemsList = [];
            rowsContainer.find('.menu-builder-row').each(function() {
                var row = $(this);
                var name = cleanBuilderText(row.find('.menu-name-input').val());
                var url = row.find('.menu-url-input').val().trim();
                var icon = cleanTopicIcon(row.find('.topic-icon-input').val());
                var isEmpty = name === '' && url === '' && icon === '';
                var isValid = isEmpty || (name !== '' && isSafeBuilderUrl(url));
                row.toggleClass('is-invalid', !isValid);
                if (!isEmpty && isValid) {
                    itemsList.push(name + ' | ' + url + ' | ' + (icon || defaultMenuIcon(name, url)));
                }
            });
            textarea.val(itemsList.join(' ; '));
        }
        updateNavbarMenuTextarea = updateTextarea;

        function addRow(name, url, icon) {
            icon = cleanTopicIcon(icon || defaultMenuIcon(name, url));
            var item = $('<div class="topic-builder-item menu-builder-item"></div>');
            var row = $('<div class="menu-builder-row d-flex align-items-center mb-2"></div>');
            row.append($('<button type="button" class="topic-icon-preview" aria-label="Pilih ikon menu"></button>'));
            row.append($('<input type="text" class="form-control menu-name-input" placeholder="Nama Menu" style="width: 34%; margin-right: 10px; display: inline-block;" />').val(cleanBuilderText(name)));
            row.append($('<input type="text" class="form-control menu-url-input" placeholder="URL" style="width: 42%; margin-right: 10px; display: inline-block;" />').val(url || ''));
            row.append($('<input type="hidden" class="topic-icon-input" />').val(icon));
            row.append($('<button type="button" class="btn btn-danger btn-sm remove-menu-row-btn" title="Hapus" style="padding: 4px 12px; cursor: pointer; display: inline-block; font-weight: bold; font-size: 14px;">&times;</button>'));
            item.append(row);
            item.append(buildIconPalette(icon));
            rowsContainer.append(item);
            syncIconPalette(row);
            updateIconPreview(row);
        }

        if (items.length > 0) {
            for (var i = 0; i < items.length; i++) {
                addRow(items[i].text, items[i].url, items[i].icon);
            }
        } else {
            addRow('Home', 'index.php', 'fas fa-home');
        }

        addBtn.click(function() {
            addRow('', '', 'fas fa-link');
            updateTextarea();
        });

        $(document).on('click', '.remove-menu-row-btn', function() {
            $(this).closest('.menu-builder-item').remove();
            updateTextarea();
        });

        $(document).on('input', '.menu-name-input, .menu-url-input', function() {
            updateTextarea();
        });
    }

    var topicTextarea = $('textarea[name="classic_topic_items"]');
    if (topicTextarea.length) {
        topicTextarea.hide();

        function parseTopicValue(rawVal) {
            var items = [];
            rawVal = String(rawVal || '').trim();
            if (rawVal === '') return items;

            var lines = rawVal.split(/[;\\n\\r]+/);
            for (var i = 0; i < lines.length; i++) {
                var line = lines[i].trim();
                if (line === '') continue;
                var parts = line.split('|');
                if (parts.length >= 2) {
                    var label = cleanBuilderText(parts[0]);
                    var url = String(parts[1] || '').trim();
                    var icon = cleanTopicIcon(parts.slice(2).join('|'));
                    if (label !== '' && isSafeBuilderUrl(url)) {
                        items.push({label: label, url: url, icon: icon});
                    }
                }
            }
            return items;
        }

        var legacyDefaultTopics = 'Literature | index.php?callnumber=8&search=search | images/8-books.png ; Social Sciences | index.php?callnumber=3&search=search | images/3-diploma.png ; Applied Sciences | index.php?callnumber=6&search=search | images/6-blackboard.png ; Art & Recreation | index.php?callnumber=7&search=search | images/7-quill.png ; see more.. | #exampleModal | images/icon/grid_icon.png';
        var rasamalaDefaultTopics = 'Literature | index.php?callnumber=8&search=search | fas fa-book ; Social Sciences | index.php?callnumber=3&search=search | fas fa-users ; Applied Sciences | index.php?callnumber=6&search=search | fas fa-flask ; Art & Recreation | index.php?callnumber=7&search=search | fas fa-paint-brush ; see more.. | #exampleModal | fas fa-th-large';
        var rawTopicVal = topicTextarea.val().trim();
        if (rawTopicVal === legacyDefaultTopics) {
            rawTopicVal = rasamalaDefaultTopics;
            topicTextarea.val(rawTopicVal);
        }
        var topicRows = parseTopicValue(rawTopicVal);
        var topicContainer = $('<div id="topic-items-builder-container" class="mt-2"></div>');
        topicContainer.append($('<div class="topic-items-builder-help"></div>').text('Klik icon di kiri untuk mengganti. Pilih salah satu icon, atau isi custom class/path di dalam panel icon.'));
        var topicRowsContainer = $('<div id="topic-items-rows"></div>');
        topicContainer.append(topicRowsContainer);
        var addTopicBtn = $('<button type="button" class="btn btn-success btn-sm mt-2" id="add-topic-row-btn" title="Tambah Topic" style="padding: 4px 12px; cursor: pointer; font-weight: bold; font-size: 14px;">+</button>');
        topicContainer.append(addTopicBtn);
        topicTextarea.after(topicContainer);

        function updateTopicTextarea() {
            var itemsList = [];
            topicRowsContainer.find('.topic-builder-row').each(function() {
                var row = $(this);
                var label = cleanBuilderText(row.find('.topic-label-input').val());
                var url = row.find('.topic-url-input').val().trim();
                var icon = cleanTopicIcon(row.find('.topic-icon-input').val());
                var isEmpty = label === '' && url === '' && icon === '';
                var isValid = isEmpty || (label !== '' && isSafeBuilderUrl(url));
                row.toggleClass('is-invalid', !isValid);
                if (!isEmpty && isValid) {
                    itemsList.push(label + ' | ' + url + ' | ' + icon);
                }
            });
            topicTextarea.val(itemsList.join(' ; '));
        }

        function addTopicRow(label, url, icon) {
            icon = cleanTopicIcon(icon || 'fas fa-book');
            var item = $('<div class="topic-builder-item"></div>');
            var row = $('<div class="topic-builder-row d-flex align-items-center mb-2"></div>');
            row.append($('<button type="button" class="topic-icon-preview" aria-label="Pilih ikon topic"></button>'));
            row.append($('<input type="text" class="form-control topic-label-input" placeholder="Nama Topic" style="width: 34%; margin-right: 10px; display: inline-block;" />').val(cleanBuilderText(label)));
            row.append($('<input type="text" class="form-control topic-url-input" placeholder="URL" style="width: 42%; margin-right: 10px; display: inline-block;" />').val(url || ''));
            row.append($('<input type="hidden" class="topic-icon-input" />').val(icon));
            row.append($('<button type="button" class="btn btn-danger btn-sm remove-topic-row-btn" title="Hapus" style="padding: 4px 12px; cursor: pointer; display: inline-block; font-weight: bold; font-size: 14px;">&times;</button>'));
            item.append(row);
            item.append(buildIconPalette(icon));
            topicRowsContainer.append(item);
            syncIconPalette(row);
            updateIconPreview(row);
        }

        if (topicRows.length > 0) {
            for (var j = 0; j < topicRows.length; j++) {
                addTopicRow(topicRows[j].label, topicRows[j].url, topicRows[j].icon);
            }
        } else {
            addTopicRow('Literature', 'index.php?callnumber=8&search=search', 'fas fa-book');
        }

        addTopicBtn.click(function() {
            addTopicRow('', '', 'fas fa-book');
            updateTopicTextarea();
        });

        $(document).on('click', '.remove-topic-row-btn', function() {
            $(this).closest('.topic-builder-item').remove();
            updateTopicTextarea();
        });

        $(document).on('click', '.topic-icon-preview', function(event) {
            event.stopPropagation();
            var item = $(this).closest('.topic-builder-item');
            $('.topic-builder-item').not(item).removeClass('is-icon-picker-open');
            item.toggleClass('is-icon-picker-open');
        });

        $(document).on('click', '.topic-icon-palette', function(event) {
            event.stopPropagation();
        });

        $(document).on('click', '.topic-icon-choice', function(event) {
            event.stopPropagation();
            var item = $(this).closest('.topic-builder-item');
            var row = item.find('.topic-builder-row');
            if (!row.length) {
                row = item.find('.menu-builder-row');
            }
            row.find('.topic-icon-input').val(cleanTopicIcon($(this).attr('data-icon')));
            syncIconPalette(row);
            updateIconPreview(row);
            if (item.hasClass('menu-builder-item')) {
                updateNavbarMenuTextarea();
            } else {
                updateTopicTextarea();
            }
            item.removeClass('is-icon-picker-open');
        });

        $(document).on('input', '.topic-icon-custom-input', function() {
            var item = $(this).closest('.topic-builder-item');
            var row = item.find('.topic-builder-row');
            if (!row.length) {
                row = item.find('.menu-builder-row');
            }
            row.find('.topic-icon-input').val(cleanTopicIcon($(this).val()));
            syncIconPalette(row);
            updateIconPreview(row);
            if (item.hasClass('menu-builder-item')) {
                updateNavbarMenuTextarea();
            } else {
                updateTopicTextarea();
            }
        });

        $(document).on('input', '.topic-label-input, .topic-url-input', function() {
            updateTopicTextarea();
        });

        $(document).on('click', function() {
            $('.topic-builder-item').removeClass('is-icon-picker-open');
        });
    }
});
</script>
HTML;
  }
}
