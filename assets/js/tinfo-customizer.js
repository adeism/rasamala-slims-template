/* Rasamala Admin Customizer JS */
$(document).ready(function() {
    var config = window.rasamalaCustomizerConfig || {};
    var topicIconOptions = config.iconOptions || [];
    var topicAssetBase = config.assetBase || '';
    var languageOptions = config.languageOptions || [];
    var themePresetDescriptions = config.presets || {};
    var themePaletteDefinitions = config.palettes || {};
    var defaultAnnouncementText = (config.defaults && config.defaults.announcement) || '';
    var defaultCustomCss = (config.defaults && config.defaults.customCss) || '';
    var defaultVisitorSplitSteps = (config.defaults && config.defaults.visitorSteps) || '';
    var defaultVisitorInstitutionOptions = (config.defaults && config.defaults.visitorInstitutions) || '';

    var quickSettingNames = [
        'classic_theme_color',
        'classic_palette_custom',
        'classic_color_toggle',
        'classic_palette_switcher_show',
        'classic_font_family',
        'classic_back_to_top',
        'classic_floating_info',
        'classic_whatsapp_number',
        'classic_whatsapp_title',
        'classic_whatsapp_desc',
        'classic_whatsapp_categories',
        'classic_navbar_menu',
        'classic_member_area',
        'classic_library_name_position',
        'classic_library_subname',
        'classic_language_visible_codes',
        'classic_mobile_bottom_nav_show',
        'classic_hero_text',
        'classic_hero_text_size',
        'classic_search_size',
        'classic_search_placeholder',
        'classic_search_result_layout',
        'classic_search_panel_style',
        'classic_news_list_layout',
        'classic_announcement_show',
        'classic_announcement_text',
        'classic_announcement_style',
        'classic_home_display_show',
        'classic_home_display_style',
        'classic_home_display_source',
        'classic_home_display_custom_text',
        'classic_home_display_content_filter',
        'classic_home_display_content_detail',
        'classic_home_display_biblio_filter',
        'classic_home_item_limit',
        'classic_home_char_limit',
        'classic_ticker_show',
        'classic_ticker_source',
        'classic_ticker_custom_text',
        'classic_ticker_content_filter',
        'classic_ticker_content_detail',
        'classic_ticker_biblio_filter',
        'classic_ticker_speed',
        'classic_ticker_item_limit',
        'classic_ticker_char_limit',
        'classic_home_content_cards_show',
        'classic_home_content_cards_source',
        'classic_home_content_path_1',
        'classic_home_content_path_2',
        'classic_home_content_path_3',
        'classic_topic_show',
        'classic_topic_heading_display',
        'classic_topic_items',
        'classic_popular_collection',
        'classic_popular_collection_heading_display',
        'classic_popular_collection_item',
        'classic_new_collection',
        'classic_new_collection_heading_display',
        'classic_new_collection_item',
        'classic_top_reader',
        'classic_top_reader_heading_display',
        'classic_top_reader_item',
        'classic_homepage_section_order',
        'classic_map',
        'classic_map_link',
        'classic_map_height',
        'classic_map_desc',
        'classic_fb_link',
        'classic_twitter_link',
        'classic_youtube_link',
        'classic_instagram_link',
        'classic_tiktok_link',
        'classic_whatsapp_link',
        'classic_telegram_link',
        'classic_linkedin_link',
        'classic_footer_show',
        'classic_footer_about_us',
        'classic_footer_search_show',
        'classic_footer_copyright',
        'classic_hero_background_animation',
        'classic_background_animation_speed',
        'classic_cursor_particles',
        'classic_cursor_custom_icon',
        'classic_prayer_times_show',
        'classic_prayer_times_city',
        'classic_auto_cover_generator',
        'classic_title_chars',
        'classic_parallel_title_separator',
        'classic_show_author_role',
        'classic_detail_label_type',
        'classic_librarian_display_mode',
        'classic_librarian_custom_usernames',
        'visitor_layout_style',
        'visitor_title',
        'visitor_subtitle',
        'visitor_institution_select_label',
        'visitor_institution_options',
        'visitor_theme_toggle',
        'visitor_log_voice',
        'visitor_quote',
        'visitor_split_title',
        'visitor_split_steps'
    ];
    var quickSectionAnchors = [
        'classic_theme_preset',
        'classic_theme_color',
        'classic_navbar_menu',
        'classic_hero_text',
        'classic_home_display_show',
        'classic_ticker_show',
        'classic_home_content_cards_show',
        'classic_map',
        'classic_librarian_display_mode',
        'classic_footer_show',
        'classic_title_chars'
    ];

    function fillEmptyTextarea(name, value) {
        var field = $('textarea[name="' + name + '"]');
        if (field.length && field.val().trim() === '') {
            field.val(value);
        }
    }

    fillEmptyTextarea('classic_announcement_text', defaultAnnouncementText);
    fillEmptyTextarea('classic_custom_css', defaultCustomCss);

    var visitorSplitStepsField = $('textarea[name="visitor_split_steps"]');
    if (visitorSplitStepsField.length) {
        var visitorSplitStepsValue = visitorSplitStepsField.val().trim();
        if (visitorSplitStepsValue === '' || /psb\.feb\.ui\.ac\.id|Login Web PSB/i.test(visitorSplitStepsValue)) {
            visitorSplitStepsField.val(defaultVisitorSplitSteps);
        }
    }

    fillEmptyTextarea('visitor_institution_options', defaultVisitorInstitutionOptions);

    function settingField(name) {
        return $('[name="' + name + '"]');
    }

    function settingRow(name) {
        return settingField(name).closest('.form-group, tr, .row');
    }

    function builderContainerForField(name) {
        var map = {
            classic_navbar_menu: '#navbar-menu-builder-container',
            classic_topic_items: '#topic-items-builder-container',
            classic_language_visible_codes: '#language-visible-builder-container'
        };
        return map[name] ? $(map[name]) : $();
    }

    function forceBuilderSettingVisible(field) {
        var row = field.closest('.form-group, tr, .row');
        if (row.length) {
            row.show();
            row.removeAttr('data-rasamala-section-hidden');
        }

        var container = builderContainerForField(field.attr('name') || '');
        if (container.length) {
            container.show();
            container.closest('.form-group, tr, .row').show().removeAttr('data-rasamala-section-hidden');
        }
    }

    function syncBuilderSettingVisibility() {
        var preset = settingValue('classic_theme_preset') || 'simple_homepage';
        var isCustomPreset = preset === 'custom';
        var configs = [
            {name: 'classic_navbar_menu', selector: '#navbar-menu-builder-container', visible: true},
            {name: 'classic_language_visible_codes', selector: '#language-visible-builder-container', visible: true},
            {name: 'classic_topic_items', selector: '#topic-items-builder-container', visible: isCustomPreset || settingValue('classic_topic_show') === '1'}
        ];

        configs.forEach(function(config) {
            var field = settingField(config.name);
            var row = settingRow(config.name);
            var container = $(config.selector);
            if (!field.length || !container.length) return;

            var visible = !!config.visible && (isCustomPreset || isQuickSetting(config.name));
            field.hide();
            row.toggle(visible).removeAttr('data-rasamala-section-hidden');
            container.toggle(visible);
        });
    }

    function settingValue(name) {
        var field = settingField(name);
        return field.length ? String(field.val()) : '';
    }

    function settingLabel(name, fallback) {
        var field = settingField(name);
        var option = field.find('option:selected');
        if (option.length) {
            return option.text();
        }
        return fallback || settingValue(name);
    }

    function normalizeHexColor(hex, fallback) {
        var color = String(hex || '').replace('#', '');
        return /^[0-9a-f]{6}$/i.test(color) ? '#' + color.toLowerCase() : fallback;
    }

    function colorLuminance(hex) {
        var color = normalizeHexColor(hex, '#ffffff').replace('#', '');
        var channels = [0, 1, 2].map(function(index) {
            var value = parseInt(color.slice(index * 2, index * 2 + 2), 16) / 255;
            return value <= 0.03928 ? value / 12.92 : Math.pow((value + 0.055) / 1.055, 2.4);
        });
        return (0.2126 * channels[0]) + (0.7152 * channels[1]) + (0.0722 * channels[2]);
    }

    function contrastRatio(background, foreground) {
        var backgroundLuminance = colorLuminance(background);
        var foregroundLuminance = colorLuminance(foreground);
        var lighter = Math.max(backgroundLuminance, foregroundLuminance);
        var darker = Math.min(backgroundLuminance, foregroundLuminance);
        return (lighter + 0.05) / (darker + 0.05);
    }

    function readableTextColor(hex) {
        return contrastRatio(hex, '#111827') >= contrastRatio(hex, '#ffffff') ? '#111827' : '#ffffff';
    }

    function accessibleTextColor(background, preferred, fallback) {
        var candidates = [
            normalizeHexColor(preferred, ''),
            normalizeHexColor(fallback, ''),
            '#111827',
            '#ffffff'
        ];
        var seen = {};
        var bestColor = '#111827';
        var bestRatio = 0;

        candidates.forEach(function(candidate) {
            if (!candidate || seen[candidate]) return;
            seen[candidate] = true;
            var ratio = contrastRatio(background, candidate);
            if (ratio >= 4.5 && bestRatio < 4.5) {
                bestColor = candidate;
                bestRatio = ratio;
                return;
            }
            if (bestRatio < 4.5 && ratio > bestRatio) {
                bestColor = candidate;
                bestRatio = ratio;
            }
        });

        return bestColor;
    }

    function hydratePreviewPalette(palette) {
        palette = palette || {};
        var textCandidate = normalizeHexColor(palette.text, '#2f2a24');
        var mutedCandidate = normalizeHexColor(palette.muted, '#7a7167');
        palette.primary = normalizeHexColor(palette.primary, '#6f5b43');
        palette.secondary = normalizeHexColor(palette.secondary, '#a58a63');
        palette.accent = normalizeHexColor(palette.accent, '#c8a24a');
        palette.background = normalizeHexColor(palette.background, '#f4f1ec');
        palette.surface = normalizeHexColor(palette.surface, '#ffffff');
        palette.text = accessibleTextColor(palette.background, textCandidate);
        palette.muted = accessibleTextColor(palette.background, mutedCandidate, palette.text);
        palette.onSurface = accessibleTextColor(palette.surface, textCandidate, palette.text);
        palette.mutedOnSurface = accessibleTextColor(palette.surface, mutedCandidate, palette.onSurface);
        return palette;
    }

    function hexToRgb(hex) {
        hex = String(hex || '').replace('#', '');
        if (!/^[0-9a-f]{6}$/i.test(hex)) return '111, 91, 67';
        return parseInt(hex.slice(0, 2), 16) + ', ' + parseInt(hex.slice(2, 4), 16) + ', ' + parseInt(hex.slice(4, 6), 16);
    }

    function parseCustomPalettePreview(value) {
        var base = themePaletteDefinitions.minimalwhite || themePaletteDefinitions.warmgray || {};
        var segment = String(value || '').split('|')[0] || '';
        var parts = segment.split(/[;\r\n]+/).map(function(item) {
            return item.trim();
        }).filter(function(item) {
            return /^#?[0-9a-f]{6}$/i.test(item);
        }).slice(0, 7);
        var keys = ['primary', 'secondary', 'accent', 'background', 'surface', 'text', 'muted'];
        var palette = {label: 'Custom Palette'};
        keys.forEach(function(key, index) {
            var fallback = base[key] || (key === 'surface' ? '#ffffff' : '#111827');
            palette[key] = parts[index] ? '#' + parts[index].replace('#', '').toLowerCase() : fallback;
        });
        return hydratePreviewPalette(palette);
    }

    function currentThemePalette() {
        var key = settingValue('classic_theme_color') || 'warmgray';
        if (key === 'custom') {
            return parseCustomPalettePreview(settingValue('classic_palette_custom'));
        }
        return hydratePreviewPalette(themePaletteDefinitions[key] || themePaletteDefinitions.warmgray || {
            label: 'Warm Gray',
            primary: '#6f5b43',
            secondary: '#a58a63',
            accent: '#c8a24a',
            background: '#f4f1ec',
            surface: '#ffffff',
            text: '#2f2a24',
            muted: '#7a7167'
        });
    }

    var sectionCollapsedState = {};

    function sectionControlledRows(sectionRow) {
        var rows = $();
        var next = sectionRow.next();
        while (next.length && !next.hasClass('rasamala-tinfo-section-row') && !next.hasClass('rasamala-tinfo-section-block')) {
            rows = rows.add(next);
            next = next.next();
        }
        return rows.not('.rasamala-theme-viewer-row, .rasamala-theme-viewer-block');
    }

    function clearSectionCollapseMarks() {
        $('[data-rasamala-section-hidden="1"]').each(function() {
            $(this).removeAttr('data-rasamala-section-hidden').show();
        });
    }

    function applyTinfoSectionCollapse() {
        $('.rasamala-tinfo-section-row, .rasamala-tinfo-section-block').each(function() {
            var section = $(this);
            var anchor = section.attr('data-rasamala-section-anchor') || '';
            var isCollapsed = !!sectionCollapsedState[anchor];
            var button = section.find('.rasamala-tinfo-section-toggle');
            section.toggleClass('is-collapsed', isCollapsed);
            button.attr('aria-expanded', isCollapsed ? 'false' : 'true');
            button.find('.rasamala-tinfo-section-toggle-text').text(isCollapsed ? 'Buka' : 'Tutup');
            button.find('i').attr('class', isCollapsed ? 'fas fa-chevron-down' : 'fas fa-chevron-up');
            if (isCollapsed) {
                sectionControlledRows(section).filter(':visible').attr('data-rasamala-section-hidden', '1').hide();
            }
        });
    }

    function setAllTinfoSectionsCollapsed(collapsed) {
        $('.rasamala-tinfo-section-row, .rasamala-tinfo-section-block').each(function() {
            var anchor = $(this).attr('data-rasamala-section-anchor') || '';
            if (anchor !== '') {
                sectionCollapsedState[anchor] = collapsed;
            }
        });
        clearSectionCollapseMarks();
        syncConditionalSettings();
    }

    function insertTinfoSection(row, title, description, anchor) {
        if (!row.length) return;
        var sectionContent = $('<div class="rasamala-tinfo-section-box"></div>')
            .append(
                $('<span class="rasamala-tinfo-section-copy"></span>')
                    .append($('<span class="rasamala-tinfo-section-title"></span>').text(title))
                    .append($('<span class="rasamala-tinfo-section-desc"></span>').text(description))
            )
            .append(
                $('<button type="button" class="rasamala-tinfo-section-toggle" aria-expanded="true"></button>')
                    .attr('data-rasamala-section-toggle', anchor || '')
                    .append($('<i class="fas fa-chevron-up" aria-hidden="true"></i>'))
                    .append($('<span class="rasamala-tinfo-section-toggle-text"></span>').text('Tutup'))
            );

        if (row.is('tr')) {
            var columns = Math.max(row.children('td, th').length, 1);
            row.before($('<tr class="rasamala-tinfo-section-row"></tr>').attr('data-rasamala-section-anchor', anchor || '').append($('<td></td>').attr('colspan', columns).append(sectionContent)));
        } else {
            row.before($('<div class="rasamala-tinfo-section-block"></div>').attr('data-rasamala-section-anchor', anchor || '').append(sectionContent));
        }
    }

    function insertTinfoSections() {
        if ($('.rasamala-tinfo-section-row, .rasamala-tinfo-section-block').length) return;

        [
            ['classic_theme_preset', 'Preset tema', 'Pilih tampilan keseluruhan. Mode Custom akan membuka semua pengaturan detail.'],
            ['classic_theme_color', 'Tampilan dasar', 'Palette warna, font, tombol bantu, breadcrumbs, dan CSS tambahan.'],
            ['classic_navbar_menu', 'Navbar dan bahasa', 'Menu utama, area anggota, bahasa yang ditampilkan, dan navigasi mobile.'],
            ['classic_hero_text', 'Search, hero, dan berita', 'Teks pencarian, layout hasil pencarian, tampilan news list, animasi, cursor, dan banner pengumuman.'],
            ['classic_home_display_show', 'Info Area Search (Hero Info)', 'Konten singkat pendukung pencarian di bawah kolom pencarian (dapat berupa static badge, fading, atau ticker).'],
            ['classic_ticker_show', 'Floating Bottom Info Bar', 'Teks berjalan melayang di bagian kaki layar (viewport bottom) untuk info/pengumuman penting.'],
            ['classic_home_content_cards_show', 'Beranda', '3 latest content, topic, koleksi populer, koleksi terbaru, top reader, dan urutan section.'],
            ['classic_map', 'Peta dan sosial media', 'Atur peta lokasi, deskripsi kontak, dan link sosial media dalam satu pilihan.'],
            ['classic_footer_show', 'Footer dan waktu sholat', 'Konten footer, search footer, copyright, jadwal sholat, dan reminder.'],
            ['classic_librarian_display_mode', 'Halaman pustakawan', 'Pilih siapa saja yang tampil di index.php?p=librarian.'],
            ['classic_title_chars', 'Teks dan halaman pengunjung', 'Batas panjang judul, pemisah judul paralel, dan visitor page.']
        ].forEach(function(section) {
            insertTinfoSection(settingRow(section[0]), section[1], section[2], section[0]);
        });
    }

    function setRowsVisible(names, visible) {
        names.forEach(function(name) {
            var row = settingRow(name);
            if (row.length) row.toggle(!!visible);
        });
    }

    function isShown(name) {
        var value = settingValue(name);
        return value !== '' && value !== '0' && value !== 'hide' && value !== 'none';
    }

    function isQuickSetting(name) {
        return quickSettingNames.indexOf(name) !== -1;
    }

    function enhanceCustomPaletteFields() {
        var field = settingField('classic_palette_custom');
        if (!field.length || field.data('rasamalaPaletteReady')) return;
        var tutorial = $('<div class="rasamala-palette-help"></div>')
            .append($('<strong></strong>').text('Format: '))
            .append(document.createTextNode('Light palette | Dark palette'))
            .append($('<br>'))
            .append(document.createTextNode('Isi setiap palette dengan urutan: Primary; Secondary; Accent; Background; Surface; Text; Muted. Jika bagian setelah | dikosongkan, dark mode memakai fallback otomatis.'))
            .append($('<br>'))
            .append(document.createTextNode('Primary = warna utama/navbar/button. Secondary = warna pendamping. Accent = highlight/icon/aksen. Background = latar halaman. Surface = card/panel. Text = teks utama. Muted = teks sekunder/border.'))
            .append($('<br>'))
            .append(document.createTextNode('Untuk hasil aman, pastikan Text dan Muted punya kontras minimal WCAG AA 4.5:1 terhadap Background dan Surface. Sistem akan menormalisasi warna teks yang terlalu mirip, tetapi palette terbaik tetap memakai Background/Surface dalam keluarga terang yang sama untuk light mode dan keluarga gelap yang sama untuk dark mode.'))
            .append($('<br>'))
            .append($('<code></code>').text('Contoh: #0B4F54; #5C8374; #F2994A; #F4F6F8; #FFFFFF; #1C1E21; #B0B7BD | #1A2E40; #B38F4D; #D9534F; #101318; #161A22; #F4F6F8; #B6BEC8'));

        field
            .attr('placeholder', '#0B4F54; #5C8374; #F2994A; #F4F6F8; #FFFFFF; #1C1E21; #B0B7BD | #1A2E40; #B38F4D; #D9534F; #101318; #161A22; #F4F6F8; #B6BEC8')
            .addClass('rasamala-palette-input rasamala-palette-combined')
            .data('rasamalaPaletteReady', true);

        field.after(tutorial);
    }

    var themeViewerControls = [
        ['classic_theme_color', 'Palette Warna', 'fas fa-paint-brush'],
        ['classic_font_family', 'Font Tema', 'fas fa-font'],
        ['classic_hero_background_animation', 'Animasi Background', 'fas fa-magic'],
        ['classic_background_animation_speed', 'Kecepatan Animasi', 'fas fa-tachometer-alt'],
        ['classic_cursor_particles', 'Partikel Cursor', 'fas fa-star'],
        ['classic_cursor_custom_icon', 'Ikon Cursor', 'fas fa-mouse-pointer']
    ];

    function buildThemeViewerSelect(name) {
        var original = settingField(name);
        var select = $('<select class="rasamala-theme-viewer-select"></select>').attr('data-theme-viewer-target', name);
        original.find('option').each(function() {
            select.append($('<option></option>').attr('value', $(this).attr('value')).text($(this).text()));
        });
        select.val(original.val());
        return select;
    }

    function ensureThemeViewer() {
        return; // Disable theme viewer injection on the admin side
    }

    function syncThemeViewer() {
        ensureThemeViewer();
        var viewer = $('#rasamala-theme-viewer');
        if (!viewer.length) return;

        var palette = currentThemePalette();
        var primary = palette.primary || '#6f5b43';
        var accent = palette.accent || primary;
        var surface = palette.surface || '#ffffff';
        var background = palette.background || '#f4f1ec';
        var text = palette.text || '#2f2a24';
        var muted = palette.muted || '#7a7167';
        var rgb = hexToRgb(accent);
        viewer.css({
            '--viewer-primary': primary,
            '--viewer-on-primary': readableTextColor(primary),
            '--viewer-accent': accent,
            '--viewer-accent-soft': 'rgba(' + rgb + ', 0.14)',
            '--viewer-background': background,
            '--viewer-surface': surface,
            '--viewer-text': text,
            '--viewer-muted': muted,
            '--viewer-border': 'rgba(' + rgb + ', 0.22)'
        });

        var fontStacks = {
            system: 'Outfit, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif',
            inter: 'Inter, system-ui, sans-serif',
            roboto: 'Roboto, system-ui, sans-serif',
            poppins: 'Poppins, system-ui, sans-serif',
            playfair: '"Playfair Display", Georgia, serif'
        };
        viewer.find('.rasamala-theme-preview').css('font-family', fontStacks[settingValue('classic_font_family')] || fontStacks.system);

        viewer.find('.rasamala-theme-viewer-select').each(function() {
            var target = $(this).attr('data-theme-viewer-target');
            $(this).val(settingValue(target));
        });
        viewer.find('[data-theme-viewer-target="classic_background_animation_speed"]').prop('disabled', settingValue('classic_hero_background_animation') === 'none');

        var swatches = viewer.find('.rasamala-theme-viewer-swatches').empty();
        [
            ['Primary', primary],
            ['Secondary', palette.secondary || primary],
            ['Accent', accent],
            ['Background', background],
            ['Surface', surface],
            ['Text', text],
            ['Muted', muted]
        ].forEach(function(item) {
            swatches.append($('<span class="rasamala-theme-swatch"></span>').attr('title', item[0] + ': ' + item[1]).css('background-color', item[1]));
        });

        var status = viewer.find('.rasamala-theme-viewer-status').empty();
        [
            ['Palette', settingLabel('classic_theme_color', palette.label)],
            ['Font', settingLabel('classic_font_family')],
            ['Animasi', settingLabel('classic_hero_background_animation')],
            ['Speed', settingValue('classic_hero_background_animation') === 'none' ? 'Off' : settingLabel('classic_background_animation_speed')],
            ['Partikel', settingLabel('classic_cursor_particles')],
            ['Cursor', settingLabel('classic_cursor_custom_icon')]
        ].forEach(function(item) {
            status.append($('<span class="rasamala-theme-viewer-chip"></span>').append($('<strong></strong>').text(item[0] + ':')).append(document.createTextNode(' ' + item[1])));
        });
    }

    function ensureThemePresetSummary() {
        var row = settingRow('classic_theme_preset');
        if (!row.length || $('#theme-preset-summary').length) return;
        var summary = $('<div id="theme-preset-summary" class="theme-preset-summary"></div>')
            .append($('<span class="theme-preset-summary-title"></span>'))
            .append($('<span class="theme-preset-summary-desc"></span>'));

        if (row.is('tr')) {
            var columns = Math.max(row.children('td, th').length, 1);
            row.after($('<tr class="theme-preset-summary-row"></tr>').append($('<td></td>').attr('colspan', columns).append(summary)));
        } else {
            row.after(summary);
        }
    }

    function syncThemePresetSummary() {
        ensureThemePresetSummary();
        var preset = settingValue('classic_theme_preset') || 'simple_homepage';
        var info = themePresetDescriptions[preset] || themePresetDescriptions.simple_homepage || {};
        $('#theme-preset-summary .theme-preset-summary-title').text(info.title || preset);
        $('#theme-preset-summary .theme-preset-summary-desc').text(info.description || '');
    }

    function syncThemePresetVisibility() {
        var preset = settingValue('classic_theme_preset') || 'simple_homepage';
        var isCustomPreset = preset === 'custom';
        var presetRow = settingRow('classic_theme_preset');
        var rows = $();

        $('select[name], input[name], textarea[name]').each(function() {
            var name = this.name || '';
            if (name === 'classic_theme_preset') return;
            if (name === 'responsive' || name.indexOf('classic_') === 0) {
                rows = rows.add($(this).closest('.form-group, tr, .row'));
            }
        });

        rows.not(presetRow).each(function() {
            var row = $(this);
            var visible = isCustomPreset;
            row.find('select[name], input[name], textarea[name]').each(function() {
                if (isQuickSetting(this.name || '')) {
                    visible = true;
                }
            });
            row.toggle(visible);
        });
        $('.rasamala-tinfo-section-row, .rasamala-tinfo-section-block').each(function() {
            var anchor = $(this).attr('data-rasamala-section-anchor') || '';
            $(this).toggle(isCustomPreset || quickSectionAnchors.indexOf(anchor) !== -1);
        });
        syncBuilderSettingVisibility();
    }

    function syncConditionalSettings() {
        clearSectionCollapseMarks();
        syncThemePresetSummary();
        syncThemePresetVisibility();
        var isCustomPreset = settingValue('classic_theme_preset') === 'custom';
        var customPaletteOn = settingValue('classic_theme_color') === 'custom';

        setRowsVisible(['classic_palette_custom'], customPaletteOn);

        var animationOn = settingValue('classic_hero_background_animation') !== 'none';
        setRowsVisible(['classic_background_animation_speed'], animationOn);

        var autoCoverField = settingField('classic_auto_cover_generator');
        if (autoCoverField.val() === '1') {
            autoCoverField.val('empty_missing');
        } else if (autoCoverField.val() === '0') {
            autoCoverField.val('none');
        }

        var prayerOn = settingValue('classic_prayer_times_show') !== 'hide' && settingValue('classic_prayer_times_show') !== '0';
        setRowsVisible(['classic_prayer_times_city'], prayerOn);

        setRowsVisible(['classic_librarian_custom_usernames'], settingValue('classic_librarian_display_mode') === 'custom');

        var homeContentCardsOn = settingValue('classic_home_content_cards_show') === '1';
        var homeContentCardsSource = settingValue('classic_home_content_cards_source') || 'news';
        setRowsVisible(['classic_home_content_cards_source'], homeContentCardsOn);
        setRowsVisible([
            'classic_home_content_path_1',
            'classic_home_content_path_2',
            'classic_home_content_path_3'
        ], homeContentCardsOn && homeContentCardsSource === 'custom');

        var visitorSplitOn = settingValue('visitor_layout_style') === 'split';
        setRowsVisible([
            'visitor_institution_select_label',
            'visitor_institution_options',
            'visitor_split_title',
            'visitor_split_steps'
        ], visitorSplitOn);

        var homeDisplayOn = isShown('classic_home_display_show');
        var homeDisplaySource = settingValue('classic_home_display_source');
        setRowsVisible(['classic_home_display_source', 'classic_home_display_style', 'classic_home_item_limit', 'classic_home_char_limit'], homeDisplayOn);
        setRowsVisible(['classic_home_display_custom_text'], homeDisplayOn && homeDisplaySource === 'custom_home');
        setRowsVisible(['classic_home_display_content_filter', 'classic_home_display_content_detail'], homeDisplayOn && homeDisplaySource === 'content');
        setRowsVisible(['classic_home_display_biblio_filter'], homeDisplayOn && homeDisplaySource === 'biblio');

        var tickerOn = isShown('classic_ticker_show');
        var tickerSource = settingValue('classic_ticker_source');
        setRowsVisible(['classic_ticker_source', 'classic_ticker_speed', 'classic_ticker_item_limit', 'classic_ticker_char_limit'], tickerOn);
        setRowsVisible(['classic_ticker_custom_text'], tickerOn && tickerSource === 'custom_ticker');
        setRowsVisible(['classic_ticker_content_filter', 'classic_ticker_content_detail'], tickerOn && tickerSource === 'content');
        setRowsVisible(['classic_ticker_biblio_filter'], tickerOn && tickerSource === 'biblio');

        var mapField = settingField('classic_map');
        if (mapField.val() === '1') {
            mapField.val('all');
        } else if (mapField.val() === '0') {
            mapField.val('hide_all');
        }

        var announcementOn = settingValue('classic_announcement_show') === '1';
        setRowsVisible(['classic_announcement_text', 'classic_announcement_style'], announcementOn);

        var topicOn = settingValue('classic_topic_show') === '1';
        setRowsVisible(['classic_topic_heading_display', 'classic_topic_items'], topicOn);
        syncBuilderSettingVisibility();

        var popularOn = settingValue('classic_popular_collection') === '1';
        setRowsVisible(['classic_popular_collection_heading_display', 'classic_popular_collection_item'], popularOn);

        var newCollectionOn = settingValue('classic_new_collection') === '1';
        setRowsVisible(['classic_new_collection_heading_display', 'classic_new_collection_item'], newCollectionOn);

        var topReaderOn = settingValue('classic_top_reader') === '1';
        setRowsVisible(['classic_top_reader_heading_display', 'classic_top_reader_item'], topReaderOn);

        var floatingInfoVal = settingValue('classic_floating_info');
        setRowsVisible([
            'classic_whatsapp_number',
            'classic_whatsapp_title',
            'classic_service_hours',
            'classic_whatsapp_desc',
            'classic_whatsapp_categories'
        ], floatingInfoVal === 'whatsapp');

        var mapMode = settingValue('classic_map');
        var mapVisible = ['1', 'all', 'hide_social'].indexOf(mapMode) !== -1;
        var socialVisible = ['1', 'all', 'hide_map'].indexOf(mapMode) !== -1;
        var mapSectionVisible = mapVisible || socialVisible;
        setRowsVisible(['classic_map_link', 'classic_map_height'], mapVisible);
        setRowsVisible(['classic_map_desc'], mapSectionVisible);
        setRowsVisible([
            'classic_fb_link',
            'classic_twitter_link',
            'classic_youtube_link',
            'classic_instagram_link',
            'classic_tiktok_link',
            'classic_whatsapp_link',
            'classic_telegram_link',
            'classic_linkedin_link'
        ], socialVisible);

        var footerOn = settingValue('classic_footer_show') === '1';
        setRowsVisible(['classic_footer_about_us', 'classic_footer_search_show', 'classic_footer_copyright'], footerOn);

        syncBuilderSettingVisibility();
        syncThemeViewer();
        applyTinfoSectionCollapse();
    }

    insertTinfoSections();
    enhanceCustomPaletteFields();
    ensureThemeViewer();
    syncConditionalSettings();
    $(document).on('change input', [
        'select[name="classic_theme_preset"]',
        'select[name="classic_theme_color"]',
        'textarea[name="classic_palette_custom"]',
        'select[name="classic_font_family"]',
        'select[name="classic_hero_background_animation"]',
        'select[name="classic_background_animation_speed"]',
        'select[name="classic_cursor_particles"]',
        'select[name="classic_cursor_custom_icon"]',
        'select[name="classic_announcement_show"]',
        'select[name="classic_home_display_show"]',
        'select[name="classic_home_display_source"]',
        'select[name="classic_home_content_cards_show"]',
        'select[name="classic_home_content_cards_source"]',
        'select[name="classic_ticker_show"]',
        'select[name="classic_ticker_source"]',
        'select[name="classic_topic_show"]',
        'select[name="classic_popular_collection"]',
        'select[name="classic_new_collection"]',
        'select[name="classic_top_reader"]',
        'select[name="classic_map"]',
        'select[name="classic_footer_show"]',
        'select[name="classic_prayer_times_show"]',
        'select[name="classic_librarian_display_mode"]',
        'select[name="classic_floating_info"]',
        'select[name="visitor_layout_style"]'
    ].join(','), syncConditionalSettings);

    $(document).on('change', '.rasamala-theme-viewer-select', function() {
        var target = $(this).attr('data-theme-viewer-target');
        settingField(target).val($(this).val()).trigger('change');
    });

    $(document).on('click', '.rasamala-tinfo-section-toggle', function() {
        var anchor = $(this).attr('data-rasamala-section-toggle') || '';
        sectionCollapsedState[anchor] = !sectionCollapsedState[anchor];
        clearSectionCollapseMarks();
        syncConditionalSettings();
    });

    $(document).on('click', '#rasamala-tinfo-show-all-sections', function() {
        setAllTinfoSectionsCollapsed(false);
    });

    $(document).on('click', '#rasamala-tinfo-hide-all-sections', function() {
        setAllTinfoSectionsCollapsed(true);
    });

    function parseLanguageCodes(value) {
        return String(value || '').split(/[,;\s]+/).map(function(item) {
            return item.trim().toLowerCase();
        }).filter(Boolean);
    }

    function syncLanguageVisibleTextarea(container, textarea) {
        var checked = [];
        container.find('.language-visible-checkbox:checked').each(function() {
            checked.push($(this).val());
        });
        textarea.val(checked.join(', ')).trigger('change');
    }

    var languageTextarea = $('textarea[name="classic_language_visible_codes"]');
    if (languageTextarea.length && languageOptions.length) {
        languageTextarea.hide();
        var selectedLanguageCodes = parseLanguageCodes(languageTextarea.val());
        var languageContainer = $('<div id="language-visible-builder-container" class="mt-2"></div>');
        languageContainer.append($('<div class="language-visible-builder-help"></div>').text('Centang bahasa yang ingin ditampilkan di navbar dan menu bahasa mobile. Jika tidak ada yang dicentang, pilihan bahasa akan disembunyikan.'));
        var languageActions = $('<div class="language-visible-actions"></div>');
        var languageGrid = $('<div class="language-visible-grid"></div>');
        languageActions
            .append($('<button type="button" class="btn btn-light btn-sm" id="language-select-all-btn">Pilih semua</button>'))
            .append($('<button type="button" class="btn btn-light btn-sm" id="language-select-id-en-btn">Indonesia & English</button>'))
            .append($('<button type="button" class="btn btn-light btn-sm" id="language-clear-btn">Sembunyikan semua</button>'));
        languageContainer.append(languageActions).append(languageGrid);
        languageTextarea.after(languageContainer);
        forceBuilderSettingVisible(languageTextarea);

        languageOptions.forEach(function(language) {
            var code = String(language.code || '').toLowerCase();
            var isChecked = selectedLanguageCodes.length > 0 && selectedLanguageCodes.indexOf(code) !== -1;
            var checkbox = $('<input type="checkbox" class="language-visible-checkbox" />').val(code).prop('checked', isChecked);
            var option = $('<label class="language-visible-option"></label>')
                .append(checkbox)
                .append(language.flag ? $('<span></span>').addClass('flag-icon flag-icon-' + language.flag + ' flag-icon-rounded') : $('<span></span>'))
                .append($('<span></span>').text(language.name || language.code))
                .append($('<span class="language-visible-option-code"></span>').text(code));
            languageGrid.append(option);
        });

        $(document).on('change', '.language-visible-checkbox', function() {
            syncLanguageVisibleTextarea(languageContainer, languageTextarea);
        });
        $(document).on('click', '#language-select-all-btn', function() {
            languageContainer.find('.language-visible-checkbox').prop('checked', true);
            syncLanguageVisibleTextarea(languageContainer, languageTextarea);
        });
        $(document).on('click', '#language-select-id-en-btn', function() {
            languageContainer.find('.language-visible-checkbox').each(function() {
                var code = $(this).val();
                $(this).prop('checked', ['id_id', 'id', 'en_us', 'en_gb', 'en'].indexOf(code) !== -1);
            });
            syncLanguageVisibleTextarea(languageContainer, languageTextarea);
        });
        $(document).on('click', '#language-clear-btn', function() {
            languageContainer.find('.language-visible-checkbox').prop('checked', false);
            languageTextarea.val('').trigger('change');
        });
    }

    function isSafeBuilderUrl(url) {
        url = String(url || '').trim();
        if (url === '' || /[\x00-\x1f\x7f|;]/.test(url)) return false;
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
        return String(text || '').replace(/[|;\r\n]/g, ' ').replace(/\s+/g, ' ').trim();
    }

    function cleanTopicIcon(icon) {
        return String(icon || '').replace(/[|;\r\n]/g, ' ').replace(/\s+/g, ' ').trim();
    }

    function isFontAwesomeIcon(icon) {
        return /^(fa[brs]?|fas|far|fab)\s+[a-z0-9 _-]+$/i.test(cleanTopicIcon(icon));
    }

    function isImageIcon(icon) {
        icon = cleanTopicIcon(icon);
        return /^https:\/\//i.test(icon) || /\.(png|jpe?g|gif|webp|svg)$/i.test(icon);
    }

    function iconSrc(icon) {
        icon = cleanTopicIcon(icon).replace(/^\/+/, '');
        if (/^https:\/\//i.test(icon)) return icon;
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

            var lines = rawVal.split(/[;\n\r]+/);
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
        var rasamalaDefaultMenu = 'Home | index.php | fas fa-home ; Information | index.php?p=libinfo | fas fa-info-circle ; News | index.php?p=news | fas fa-newspaper ; Help | index.php?p=help ; Librarian | index.php?p=librarian | fas fa-users ; Staff Area | index.php?p=login | fas fa-university';
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
        var addBtn = $('<button type="button" class="btn btn-success btn-sm mt-2 rasamala-builder-action-btn" id="add-menu-row-btn" title="Tambah Menu">+</button>');
        container.append(addBtn);
        textarea.after(container);
        forceBuilderSettingVisible(textarea);

        var memberRow = $('select[name="classic_member_area"]').closest('.form-group, tr, .row');
        memberRow.hide();

        var extraSettings = $('<div class="navbar-menu-extra-settings mt-3 pt-3"></div>');
        var initMemberVal = $('select[name="classic_member_area"]').val();
        var memberCheckbox = $('<label class="rasamala-builder-toggle-label"></label>')
            .append($('<input type="checkbox" class="member-area-toggle" />').prop('checked', initMemberVal == 1))
            .append(' Tampilkan Area Anggota (Member Area)');
        extraSettings.append(memberCheckbox);

        container.append(extraSettings);

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
            var row = $('<div class="menu-builder-row rasamala-builder-row d-flex align-items-center mb-2"></div>');
            row.append($('<button type="button" class="topic-icon-preview" aria-label="Pilih ikon menu"></button>'));
            row.append($('<input type="text" class="form-control menu-name-input rasamala-builder-input-name" placeholder="Nama Menu" />').val(cleanBuilderText(name)));
            row.append($('<input type="text" class="form-control menu-url-input rasamala-builder-input-url" placeholder="URL" />').val(url || ''));
            row.append($('<input type="hidden" class="topic-icon-input" />').val(icon));
            row.append($('<button type="button" class="btn btn-danger btn-sm remove-menu-row-btn rasamala-builder-action-btn" title="Hapus">&times;</button>'));
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

            var lines = rawVal.split(/[;\n\r]+/);
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
        var addTopicBtn = $('<button type="button" class="btn btn-success btn-sm mt-2 rasamala-builder-action-btn" id="add-topic-row-btn" title="Tambah Topic">+</button>');
        topicContainer.append(addTopicBtn);
        topicTextarea.after(topicContainer);
        forceBuilderSettingVisible(topicTextarea);

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
            var row = $('<div class="topic-builder-row rasamala-builder-row d-flex align-items-center mb-2"></div>');
            row.append($('<button type="button" class="topic-icon-preview" aria-label="Pilih ikon topic"></button>'));
            row.append($('<input type="text" class="form-control topic-label-input rasamala-builder-input-name" placeholder="Nama Topic" />').val(cleanBuilderText(label)));
            row.append($('<input type="text" class="form-control topic-url-input rasamala-builder-input-url" placeholder="URL" />').val(url || ''));
            row.append($('<input type="hidden" class="topic-icon-input" />').val(icon));
            row.append($('<button type="button" class="btn btn-danger btn-sm remove-topic-row-btn rasamala-builder-action-btn" title="Hapus">&times;</button>'));
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

    syncBuilderSettingVisibility();
});
