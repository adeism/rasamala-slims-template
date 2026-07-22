/*!
 * Rasamala theme - Theme Viewer / Switcher.
 */
'use strict';

document.addEventListener('DOMContentLoaded', () => {
    const query = (selector, root = document) => root.querySelector(selector);
    const queryAll = (selector, root = document) => Array.prototype.slice.call(root.querySelectorAll(selector));

    const readJsonConfig = (id, fallback = null) => {
        const element = query(`#${id}`);
        if (!element) return fallback;

        const text = (element.content ? element.content.textContent : element.textContent) || '';
        if (!text.trim()) return fallback;

        try {
            return JSON.parse(text);
        } catch (error) {
            return fallback;
        }
    };

    const paletteSwitcherConfig = readJsonConfig('rasamala-palette-switcher-config', window.rasamalaPaletteSwitcher || null);
    const paletteStorageKey = 'rasamala-theme-palette-key';
    const paletteCustomStorageKey = 'rasamala-theme-custom-palette';
    const themeViewerStorageKeys = {
        preset: 'rasamala-theme-preset',
        font: 'rasamala-theme-font-family',
        animation: 'rasamala-theme-background-animation',
        animationSpeed: 'rasamala-theme-background-animation-speed',
        cursorParticles: 'rasamala-theme-cursor-particles',
        cursorIcon: 'rasamala-theme-cursor-icon',
        sectionsHidden: 'rasamala-theme-sections-hidden',
        hiddenSections: 'rasamala-theme-hidden-sections'
    };

    const presetDefinitions = {
        simple_homepage: {
            palette: 'darkgray',
            font: 'inter',
            animation: 'none',
            cursorParticles: 'none',
            hiddenSections: ['topic', 'news', 'popular', 'new-collection', 'top-reader', 'map', 'hero-info']
        },
        all_show: {
            palette: 'warmlibrary',
            font: 'poppins',
            animation: 'twinkle',
            cursorParticles: 'auto',
            hiddenSections: []
        },
        office: {
            palette: 'cleanblue',
            font: 'inter',
            animation: 'none',
            cursorParticles: 'none',
            hiddenSections: ['news', 'popular', 'new-collection', 'top-reader', 'map']
        },
        custom: null
    };

    const paletteKeys = ['primary', 'secondary', 'accent', 'background', 'surface', 'text', 'muted'];
    const paletteInputMaxLength = 320;
    const minimumTextContrast = 4.5;
    const fontStacks = {
        system: 'system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif',
        inter: '"Inter", system-ui, BlinkMacSystemFont, "Segoe UI", sans-serif',
        roboto: '"Roboto", Arial, Helvetica, sans-serif',
        poppins: '"Poppins", "Trebuchet MS", Arial, sans-serif',
        playfair: '"Playfair Display", Georgia, "Times New Roman", serif'
    };

    const normalizePaletteToken = (value) => {
        const color = String(value || '').trim();
        if (/^#?[0-9a-fA-F]{6}$/.test(color)) {
            return `#${color.replace('#', '').toLowerCase()}`;
        }
        return '';
    };

    const sanitizePaletteSegment = (value) => {
        const parts = String(value || '')
            .slice(0, paletteInputMaxLength)
            .split(/[;\n\r]+/)
            .slice(0, paletteKeys.length)
            .map(normalizePaletteToken);

        while (parts.length > 0 && parts[parts.length - 1] === '') {
            parts.pop();
        }

        return parts.join('; ');
    };

    const sanitizePaletteInput = (value) => {
        const segments = String(value || '').slice(0, paletteInputMaxLength).split('|');
        const light = sanitizePaletteSegment(segments[0] || '');
        const dark = sanitizePaletteSegment(segments[1] || '');

        if (light && dark) {
            return `${light} | ${dark}`;
        }

        return light;
    };

    const normalizeHex = (value, fallback) => {
        return normalizePaletteToken(value) || fallback;
    };

    const hexToRgb = (hex) => {
        const color = normalizeHex(hex, '#6f5b43').replace('#', '');
        return [
            parseInt(color.slice(0, 2), 16),
            parseInt(color.slice(2, 4), 16),
            parseInt(color.slice(4, 6), 16)
        ].join(', ');
    };

    const adjustHex = (hex, amount) => {
        const color = normalizeHex(hex, '#6f5b43').replace('#', '');
        let output = '#';
        for (let index = 0; index < 3; index += 1) {
            const channel = Math.max(0, Math.min(255, parseInt(color.slice(index * 2, index * 2 + 2), 16) + amount));
            output += channel.toString(16).padStart(2, '0');
        }
        return output;
    };

    const paletteLuminance = (hex) => {
        const color = normalizeHex(hex, '#ffffff').replace('#', '');
        const channels = [0, 1, 2].map(index => {
            const value = parseInt(color.slice(index * 2, index * 2 + 2), 16) / 255;
            return value <= 0.03928 ? value / 12.92 : Math.pow((value + 0.055) / 1.055, 2.4);
        });
        return (0.2126 * channels[0]) + (0.7152 * channels[1]) + (0.0722 * channels[2]);
    };

    const contrastRatio = (background, foreground) => {
        const backgroundLuminance = paletteLuminance(background);
        const foregroundLuminance = paletteLuminance(foreground);
        const lighter = Math.max(backgroundLuminance, foregroundLuminance);
        const darker = Math.min(backgroundLuminance, foregroundLuminance);
        return (lighter + 0.05) / (darker + 0.05);
    };

    const readableTextColor = (background, preferredDark = '#111827', preferredLight = '#ffffff') => {
        const bg = normalizeHex(background, '#ffffff');
        const dark = normalizeHex(preferredDark, '#111827');
        const light = normalizeHex(preferredLight, '#ffffff');
        return contrastRatio(bg, dark) >= contrastRatio(bg, light) ? dark : light;
    };

    const accessibleTextColor = (background, preferred = '', fallback = '', minimumRatio = minimumTextContrast) => {
        const bg = normalizeHex(background, '#ffffff');
        const candidates = [normalizePaletteToken(preferred), normalizePaletteToken(fallback), '#111827', '#ffffff'];
        const seen = new Set();
        let bestColor = '#111827';
        let bestRatio = 0;

        for (const candidate of candidates) {
            if (!candidate || seen.has(candidate)) continue;
            seen.add(candidate);
            const ratio = contrastRatio(bg, candidate);
            if (ratio >= minimumRatio) {
                return candidate;
            }
            if (ratio > bestRatio) {
                bestRatio = ratio;
                bestColor = candidate;
            }
        }

        return bestColor;
    };

    const hydratePaletteContrast = (palette) => {
        const output = Object.assign({}, palette);
        output.primary = normalizeHex(output.primary, '#6f5b43');
        output.hover = normalizeHex(output.hover, adjustHex(output.primary, -28));
        output.secondary = normalizeHex(output.secondary, '#a58a63');
        output.accent = normalizeHex(output.accent, '#c8a24a');
        output.background = normalizeHex(output.background, '#f4f1ec');
        output.surface = normalizeHex(output.surface, '#ffffff');
        const textCandidate = normalizeHex(output.text, '#2f2a24');
        const mutedCandidate = normalizeHex(output.muted, '#7a7167');
        output.text = textCandidate;
        output.muted = mutedCandidate;
        output.accentHover = normalizeHex(output.accentHover, adjustHex(output.accent, -28));
        output.rgb = output.rgb || hexToRgb(output.primary);
        output.accentRgb = output.accentRgb || hexToRgb(output.accent);
        output.onPrimary = output.onPrimary || accessibleTextColor(output.primary);
        output.onPrimaryHover = output.onPrimaryHover || accessibleTextColor(output.hover);
        output.onSecondary = output.onSecondary || accessibleTextColor(output.secondary);
        output.onAccent = output.onAccent || accessibleTextColor(output.accent);
        output.onBackground = accessibleTextColor(output.background, textCandidate);
        output.onSurface = accessibleTextColor(output.surface, textCandidate, output.onBackground);
        output.mutedOnBackground = accessibleTextColor(output.background, mutedCandidate, output.onBackground);
        output.mutedOnSurface = accessibleTextColor(output.surface, mutedCandidate, output.onSurface);
        output.text = output.onBackground;
        output.muted = output.mutedOnBackground;
        return output;
    };

    const serializePaletteSegment = (palette) => paletteKeys
        .map(key => palette[key] || '#111827')
        .join('; ');

    const normalizePaletteInputForContrast = (value, fallbackLight = {}, fallbackDark = {}) => {
        const rawValue = String(value || '');
        const hasDarkSegment = rawValue.indexOf('|') !== -1;
        const pair = parsePalettePair(rawValue, fallbackLight, fallbackDark);
        const light = serializePaletteSegment(pair.light);
        const dark = serializePaletteSegment(pair.dark);
        return hasDarkSegment ? `${light} | ${dark}` : light;
    };

    const parsePaletteSegment = (value, fallback = {}) => {
        const parts = String(value || '')
            .slice(0, paletteInputMaxLength)
            .split(/[;\n\r]+/)
            .slice(0, paletteKeys.length)
            .map(part => part.trim());
        const palette = {};
        paletteKeys.forEach((key, index) => {
            palette[key] = normalizeHex(parts[index], fallback[key] || '#ffffff');
        });
        palette.hover = adjustHex(palette.primary, -28);
        palette.accentHover = adjustHex(palette.accent, -28);
        palette.rgb = hexToRgb(palette.primary);
        palette.accentRgb = hexToRgb(palette.accent);
        return hydratePaletteContrast(palette);
    };

    const parsePalettePair = (value, fallbackLight = {}, fallbackDark = {}) => {
        const segments = String(value || '').split('|');
        const light = parsePaletteSegment(segments[0] || '', fallbackLight);
        const dark = parsePaletteSegment(segments[1] || '', fallbackDark);
        return { light, dark };
    };

    const setRootThemeVars = (light, dark) => {
        const root = document.documentElement;
        const values = {
            '--theme-primary': light.primary,
            '--theme-primary-hover': light.hover,
            '--theme-secondary': light.secondary,
            '--theme-accent': light.accent,
            '--theme-background': light.background,
            '--theme-surface': light.surface,
            '--theme-text': light.text,
            '--theme-muted': light.muted,
            '--theme-muted-on-background': light.mutedOnBackground,
            '--theme-muted-on-surface': light.mutedOnSurface,
            '--theme-primary-rgb': light.rgb,
            '--theme-accent-rgb-value': light.accentRgb,
            '--theme-on-primary': light.onPrimary,
            '--theme-on-primary-hover': light.onPrimaryHover,
            '--theme-on-secondary': light.onSecondary,
            '--theme-on-accent': light.onAccent,
            '--theme-on-background': light.onBackground,
            '--theme-on-surface': light.onSurface,
            '--theme-dark-primary': dark.primary,
            '--theme-dark-primary-hover': dark.hover,
            '--theme-dark-secondary': dark.secondary,
            '--theme-dark-accent': dark.accent,
            '--theme-dark-background': dark.background,
            '--theme-dark-surface': dark.surface,
            '--theme-dark-text': dark.text,
            '--theme-dark-muted': dark.muted,
            '--theme-dark-muted-on-background': dark.mutedOnBackground,
            '--theme-dark-muted-on-surface': dark.mutedOnSurface,
            '--theme-dark-primary-rgb': dark.rgb,
            '--theme-dark-accent-rgb-value': dark.accentRgb,
            '--theme-dark-on-primary': dark.onPrimary,
            '--theme-dark-on-primary-hover': dark.onPrimaryHover,
            '--theme-dark-on-secondary': dark.onSecondary,
            '--theme-dark-on-accent': dark.onAccent,
            '--theme-dark-on-background': dark.onBackground,
            '--theme-dark-on-surface': dark.onSurface,
            '--color-primary': 'var(--theme-primary)',
            '--color-secondary': 'var(--theme-secondary)',
            '--color-accent': 'var(--theme-accent)',
            '--color-background': 'var(--theme-background)',
            '--color-surface': 'var(--theme-surface)',
            '--color-text': 'var(--theme-on-background)',
            '--color-muted': 'var(--theme-muted-on-background)',
            '--color-on-primary': 'var(--theme-on-primary)',
            '--color-on-secondary': 'var(--theme-on-secondary)',
            '--color-on-accent': 'var(--theme-on-accent)',
            '--rasamala-light-bg': 'var(--theme-background)',
            '--rasamala-text-primary': 'var(--theme-on-background)',
            '--rasamala-text-secondary': 'var(--theme-secondary)',
            '--rasamala-text-muted': 'var(--theme-muted-on-background)',
            '--rasamala-surface': 'var(--theme-surface)',
            '--rasamala-accent': light.accent,
            '--rasamala-accent-hover': light.accentHover,
            '--rasamala-readable-accent': 'color-mix(in srgb, var(--theme-accent) 72%, var(--theme-text) 28%)',
            '--theme-accent-color': light.accent,
            '--theme-accent-rgb': light.accentRgb,
            '--theme-accent-glow': `rgba(${light.accentRgb}, 0.8)`,
            '--theme-accent-glow-half': `rgba(${light.accentRgb}, 0.4)`,
            '--rasamala-chrome-bg': 'color-mix(in srgb, var(--theme-primary) 92%, #000 8%)',
            '--rasamala-chrome-border': 'color-mix(in srgb, var(--theme-primary) 38%, transparent)',
            '--rasamala-chrome-text': 'var(--theme-on-primary)',
            '--rasamala-chrome-text-muted': 'color-mix(in srgb, var(--theme-on-primary) 76%, transparent)',
            '--bs-body-bg': 'var(--theme-background)',
            '--bs-body-color': 'var(--theme-on-background)',
            '--bs-secondary-color': 'var(--theme-muted-on-background)'
        };

        Object.entries(values).forEach(([name, value]) => {
            root.style.setProperty(name, value);
        });
    };

    const updatePaletteBodyClass = (key, light) => {
        Array.from(document.body.classList)
            .filter(name => name.indexOf('rasamala-palette-') === 0)
            .forEach(name => document.body.classList.remove(name));

        const safeKey = String(key || 'custom').replace(/[^a-z0-9_-]+/ig, '-').toLowerCase();
        document.body.classList.add(`rasamala-palette-${safeKey}`);

        if (paletteLuminance(light.background) < 0.28 || paletteLuminance(light.surface) < 0.28) {
            document.body.classList.add('rasamala-palette-dark');
        }
    };

    const applyPaletteChoice = (key, customValue, persist = true) => {
        if (!paletteSwitcherConfig || paletteSwitcherConfig.enabled === false || !paletteSwitcherConfig.palettes) return;
        const palettes = paletteSwitcherConfig.palettes;
        const selectedKey = palettes[key] ? key : (paletteSwitcherConfig.currentKey || 'warmgray');
        let cleanCustomValue = sanitizePaletteInput(customValue);
        let pair = palettes[selectedKey] || palettes.warmgray;

        if (selectedKey === 'custom') {
            const fallback = palettes.custom || palettes[paletteSwitcherConfig.currentKey] || palettes.warmgray;
            const fallbackCustomValue = sanitizePaletteInput(paletteSwitcherConfig.customValue || '');
            cleanCustomValue = normalizePaletteInputForContrast(cleanCustomValue || fallbackCustomValue, fallback.light || {}, fallback.dark || {});
            pair = parsePalettePair(cleanCustomValue, fallback.light || {}, fallback.dark || {});
        }

        pair = {
            light: hydratePaletteContrast(pair.light || {}),
            dark: hydratePaletteContrast(pair.dark || {})
        };

        setRootThemeVars(pair.light, pair.dark);
        updatePaletteBodyClass(selectedKey, pair.light);

        if (persist) {
            try {
                window.localStorage.setItem(paletteStorageKey, selectedKey);
                if (selectedKey === 'custom') {
                    window.localStorage.setItem(paletteCustomStorageKey, cleanCustomValue);
                }
            } catch (error) {}
        }

        document.dispatchEvent(new CustomEvent('rasamala:palette-changed', {
            detail: { key: selectedKey, light: pair.light, dark: pair.dark }
        }));
    };

    const optionValueExists = (options, value) => !!options && Object.prototype.hasOwnProperty.call(options, value);

    const getStoredThemeViewerValue = (key, fallback) => {
        try {
            const value = window.localStorage.getItem(key);
            return value == null || value === '' ? fallback : value;
        } catch (error) {
            return fallback;
        }
    };

    const setStoredThemeViewerValue = (key, value, fallback) => {
        try {
            if (value === fallback || value == null || value === '') {
                window.localStorage.removeItem(key);
                return;
            }
            window.localStorage.setItem(key, value);
        } catch (error) {}
    };

    const sectionOptions = () => Array.isArray(paletteSwitcherConfig && paletteSwitcherConfig.homeSections)
        ? paletteSwitcherConfig.homeSections
        : [];

    const normalizeSectionKeys = (value) => {
        const allowed = sectionOptions().map(section => section.key);
        const raw = Array.isArray(value) ? value : String(value || '').split(',');
        return raw
            .map(item => String(item || '').trim())
            .filter((item, index, items) => item && allowed.indexOf(item) !== -1 && items.indexOf(item) === index);
    };

    const backgroundSpeedMultiplier = (speed) => {
        if (speed === 'slow') return '1.5';
        if (speed === 'fast') return '0.65';
        return '1';
    };

    const ensureBackgroundAnimationLayer = () => {
        let layer = query('#background-animation-layer') || query('#hero-animation-layer');
        if (layer) return layer;

        layer = document.createElement('div');
        layer.id = 'background-animation-layer';
        layer.className = 'background-animation-layer hero-animation-layer';
        layer.setAttribute('aria-hidden', 'true');
        document.body.insertBefore(layer, document.body.firstChild);
        return layer;
    };

    const applyThemeViewerChoice = (settings, persist = true) => {
        if (!paletteSwitcherConfig || paletteSwitcherConfig.enabled === false) return;

        const font = optionValueExists(paletteSwitcherConfig.fonts, settings.font)
            ? settings.font
            : (paletteSwitcherConfig.fontFamily || 'system');
        const animation = optionValueExists(paletteSwitcherConfig.animations, settings.animation)
            ? settings.animation
            : (paletteSwitcherConfig.backgroundAnimation || 'none');
        const animationSpeed = optionValueExists(paletteSwitcherConfig.animationSpeeds, settings.animationSpeed)
            ? settings.animationSpeed
            : (paletteSwitcherConfig.backgroundAnimationSpeed || 'normal');
        const cursorParticles = optionValueExists(paletteSwitcherConfig.cursorParticlesOptions, settings.cursorParticles)
            ? settings.cursorParticles
            : (paletteSwitcherConfig.cursorParticles || 'auto');
        const cursorIcon = optionValueExists(paletteSwitcherConfig.cursorIcons, settings.cursorIcon)
            ? settings.cursorIcon
            : (paletteSwitcherConfig.cursorIcon || 'default');
        const sectionsHidden = settings.sectionsHidden === true || settings.sectionsHidden === '1';
        const hiddenSections = sectionsHidden
            ? sectionOptions().map(section => section.key)
            : normalizeSectionKeys(settings.hiddenSections);

        document.documentElement.style.setProperty('--rasamala-font-stack', fontStacks[font] || fontStacks.system);
        document.body.style.setProperty('--rasamala-font-stack', fontStacks[font] || fontStacks.system);

        document.body.classList.toggle('rasamala-opac-sections-hidden', sectionsHidden);

        const presetSelect = query('#theme-preset-select');
        const activePreset = presetSelect ? presetSelect.value : (getStoredThemeViewerValue(themeViewerStorageKeys.preset) || paletteSwitcherConfig.currentPreset || 'simple_homepage');
        const isOnlyHero = (activePreset === 'simple_homepage');
        const isOffice = (activePreset === 'office');

        document.body.classList.toggle('rasamala-home-hero-only', isOnlyHero);
        queryAll('.rasamala-hero-section').forEach(element => {
            element.classList.toggle('rasamala-hero-section-only', isOnlyHero);
        });
        queryAll('.rasamala-search-banner-section').forEach(element => {
            element.classList.toggle('rasamala-search-banner-hero-only', isOnlyHero);
        });

        // Hide/show topic heading based on preset 'office' (Simple + Topics)
        queryAll('.rasamala-home-section-topic .rasamala-home-section-title').forEach(element => {
            element.hidden = isOffice;
        });

        sectionOptions().forEach(section => {
            queryAll(section.selector).forEach(element => {
                element.hidden = hiddenSections.indexOf(section.key) !== -1;
            });
        });

        Array.from(document.body.classList)
            .filter(name => name.indexOf('rasamala-background-animation-') === 0)
            .forEach(name => document.body.classList.remove(name));

        let layer = query('#background-animation-layer') || query('#hero-animation-layer');
        if (animation === 'none') {
            document.body.classList.remove('rasamala-background-animation-active');
            if (layer) {
                if (typeof layer._rasamalaAnimationCleanup === 'function') {
                    layer._rasamalaAnimationCleanup();
                    layer._rasamalaAnimationCleanup = null;
                }
                while (layer.firstChild) layer.removeChild(layer.firstChild);
                layer.hidden = true;
                layer.setAttribute('data-animation', 'none');
            }
        } else {
            layer = ensureBackgroundAnimationLayer();
            layer.hidden = false;
            Array.from(layer.classList)
                .filter(name => name.indexOf('hero-animation-') === 0 && name !== 'hero-animation-layer')
                .forEach(name => layer.classList.remove(name));
            layer.classList.add(`hero-animation-${animation}`);
            layer.setAttribute('data-animation', animation);
            layer.setAttribute('data-speed-multiplier', backgroundSpeedMultiplier(animationSpeed));
            document.body.classList.add('rasamala-background-animation-active', `rasamala-background-animation-${animation}`);
        }

        document.body.setAttribute('data-cursor-particles', cursorParticles);
        document.body.setAttribute('data-cursor-custom-icon', cursorIcon);

        if (persist) {
            const presetSelect = query('#theme-preset-select');
            if (presetSelect) {
                setStoredThemeViewerValue(themeViewerStorageKeys.preset, presetSelect.value, paletteSwitcherConfig.currentPreset || 'simple_homepage');
            }
            setStoredThemeViewerValue(themeViewerStorageKeys.font, font, paletteSwitcherConfig.fontFamily || 'system');
            setStoredThemeViewerValue(themeViewerStorageKeys.animation, animation, paletteSwitcherConfig.backgroundAnimation || 'none');
            setStoredThemeViewerValue(themeViewerStorageKeys.animationSpeed, animationSpeed, paletteSwitcherConfig.backgroundAnimationSpeed || 'normal');
            setStoredThemeViewerValue(themeViewerStorageKeys.cursorParticles, cursorParticles, paletteSwitcherConfig.cursorParticles || 'auto');
            setStoredThemeViewerValue(themeViewerStorageKeys.cursorIcon, cursorIcon, paletteSwitcherConfig.cursorIcon || 'default');
            setStoredThemeViewerValue(themeViewerStorageKeys.sectionsHidden, sectionsHidden ? '1' : '', '');
            setStoredThemeViewerValue(themeViewerStorageKeys.hiddenSections, hiddenSections.join(','), '');
        }

        document.dispatchEvent(new CustomEvent('rasamala:theme-viewer-changed', {
            detail: {font, animation, animationSpeed, cursorParticles, cursorIcon, sectionsHidden, hiddenSections}
        }));
        document.dispatchEvent(new CustomEvent('rasamala:cursor-settings-changed', {
            detail: {cursorParticles, cursorIcon}
        }));
    };

    const initPaletteSwitcher = () => {
        if (paletteSwitcherConfig && paletteSwitcherConfig.enabled === false) {
            try {
                window.localStorage.removeItem(paletteStorageKey);
                window.localStorage.removeItem(paletteCustomStorageKey);
            } catch (error) {}
            return;
        }

        if (!paletteSwitcherConfig || !paletteSwitcherConfig.palettes) return;

        const wrap = query('#rasamala-palette-switcher');
        const toggle = query('#palette-switcher-toggle');
        const panel = query('#palette-switcher-panel');
        const select = query('#palette-switcher-select');
        const swatches = query('#palette-switcher-swatches');
        const customWrap = query('#palette-switcher-custom');
        const customInput = query('#palette-switcher-custom-input');
        const applyButton = query('#palette-switcher-apply');
        const resetButton = query('#palette-switcher-reset');
        const copyPromptButton = query('#palette-switcher-copy-prompt');
        const pastePaletteButton = query('#palette-switcher-paste-palette');
        const fontSelect = query('#theme-viewer-font-select');
        const animationSelect = query('#theme-viewer-animation-select');
        const animationSpeedSelect = query('#theme-viewer-animation-speed-select');
        const cursorParticlesSelect = query('#theme-viewer-cursor-particles-select');
        const cursorIconSelect = query('#theme-viewer-cursor-icon-select');
        const sectionList = query('#theme-viewer-section-list');
        const showSectionsButton = query('#theme-viewer-show-sections');
        const hideSectionsButton = query('#theme-viewer-hide-sections');
        if (!wrap || !toggle || !panel || !select || !customInput || !applyButton || !resetButton) return;

        const palettes = paletteSwitcherConfig.palettes;
        const fillSelect = (element, options) => {
            if (!element || !options) return;
            element.textContent = '';
            Object.keys(options).forEach(key => {
                const option = document.createElement('option');
                option.value = key;
                option.textContent = options[key] || key;
                element.appendChild(option);
            });
        };

        const presetSelect = query('#theme-preset-select');
        fillSelect(presetSelect, paletteSwitcherConfig.presets);

        const applyPresetDefaults = (presetKey) => {
            const def = presetDefinitions[presetKey];
            if (!def) return;

            if (select) {
                select.value = def.palette;
                syncControls(def.palette);
            }
            if (fontSelect) fontSelect.value = def.font;
            if (animationSelect) {
                animationSelect.value = def.animation;
                if (animationSpeedSelect) {
                    animationSpeedSelect.disabled = def.animation === 'none';
                }
            }
            if (cursorParticlesSelect) cursorParticlesSelect.value = def.cursorParticles;

            queryAll('[data-theme-viewer-section]', sectionList || document).forEach(input => {
                input.checked = def.hiddenSections.indexOf(input.value) === -1;
            });
        };

        const detectPreset = () => {
            if (!presetSelect) return;
            const current = currentThemeViewerSettings();
            const currentPalette = select.value;

            for (const [key, def] of Object.entries(presetDefinitions)) {
                if (!def) continue;
                const match = currentPalette === def.palette &&
                    current.font === def.font &&
                    current.animation === def.animation &&
                    current.cursorParticles === def.cursorParticles &&
                    JSON.stringify(current.hiddenSections.sort()) === JSON.stringify(def.hiddenSections.sort());
                if (match) {
                    presetSelect.value = key;
                    return;
                }
            }
            presetSelect.value = 'custom';
        };

        fillSelect(fontSelect, paletteSwitcherConfig.fonts);
        fillSelect(animationSelect, paletteSwitcherConfig.animations);
        fillSelect(animationSpeedSelect, paletteSwitcherConfig.animationSpeeds);
        fillSelect(cursorParticlesSelect, paletteSwitcherConfig.cursorParticlesOptions);
        fillSelect(cursorIconSelect, paletteSwitcherConfig.cursorIcons);

        if (sectionList) {
            sectionList.textContent = '';
            sectionOptions().forEach(section => {
                const label = document.createElement('label');
                const input = document.createElement('input');
                const span = document.createElement('span');
                label.className = 'palette-switcher-section-option';
                input.type = 'checkbox';
                input.value = section.key;
                input.checked = true;
                input.setAttribute('data-theme-viewer-section', section.key);
                span.textContent = section.label || section.key;
                label.appendChild(input);
                label.appendChild(span);
                sectionList.appendChild(label);
            });
        }

        Object.keys(palettes).forEach(key => {
            const item = palettes[key];
            const option = document.createElement('option');
            option.value = key;
            option.textContent = item.label || key;
            select.appendChild(option);

            if (swatches) {
                const swatch = document.createElement('button');
                swatch.type = 'button';
                swatch.className = 'palette-switcher-swatch';
                swatch.setAttribute('data-palette-key', key);
                swatch.setAttribute('aria-label', item.label || key);
                swatch.title = item.label || key;
                swatch.style.setProperty('--swatch-primary', (item.light && item.light.primary) || '#6f5b43');
                swatch.style.setProperty('--swatch-secondary', (item.light && item.light.secondary) || '#a58a63');
                swatch.style.setProperty('--swatch-accent', (item.light && item.light.accent) || '#c8a24a');
                swatches.appendChild(swatch);
            }
        });

        const setPanelOpen = (open) => {
            panel.hidden = !open;
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            wrap.classList.toggle('is-open', open);
        };

        const setTemporaryButtonLabel = (button, label, delay = 1400) => {
            if (!button || !label) return;
            const textNode = query('span', button);
            if (textNode) {
                const previous = textNode.textContent;
                textNode.textContent = label;
                window.setTimeout(() => {
                    textNode.textContent = previous;
                }, delay);
            } else {
                const previous = button.getAttribute('title') || '';
                button.setAttribute('title', label);
                window.setTimeout(() => {
                    button.setAttribute('title', previous);
                }, delay);
            }
        };

        const copyText = (text) => {
            const value = String(text || '');
            if (navigator.clipboard && navigator.clipboard.writeText) {
                return navigator.clipboard.writeText(value);
            }

            const field = document.createElement('textarea');
            field.value = value;
            field.setAttribute('readonly', 'readonly');
            field.style.position = 'fixed';
            field.style.top = '-1000px';
            document.body.appendChild(field);
            field.select();
            const copied = document.execCommand('copy');
            field.remove();

            return copied ? Promise.resolve() : Promise.reject(new Error('copy failed'));
        };

        const readText = () => {
            if (navigator.clipboard && navigator.clipboard.readText) {
                return navigator.clipboard.readText();
            }

            return Promise.reject(new Error('clipboard unavailable'));
        };

        const syncControls = (key) => {
            select.value = key;
            if (customWrap) {
                customWrap.hidden = key !== 'custom';
            }
            if (swatches) {
                queryAll('.palette-switcher-swatch', swatches).forEach(swatch => {
                    swatch.classList.toggle('is-active', swatch.getAttribute('data-palette-key') === key);
                });
            }
        };

        const syncThemeViewerControls = (settings) => {
            const hiddenSections = settings.sectionsHidden === true || settings.sectionsHidden === '1'
                ? sectionOptions().map(section => section.key)
                : normalizeSectionKeys(settings.hiddenSections);
            if (fontSelect) fontSelect.value = settings.font;
            if (animationSelect) {
                animationSelect.value = settings.animation;
                if (animationSpeedSelect) {
                    animationSpeedSelect.value = settings.animationSpeed;
                    animationSpeedSelect.disabled = settings.animation === 'none';
                }
            }
            if (cursorParticlesSelect) cursorParticlesSelect.value = settings.cursorParticles;
            if (cursorIconSelect) cursorIconSelect.value = settings.cursorIcon;
            wrap.classList.toggle('is-sections-hidden', hiddenSections.length === sectionOptions().length && hiddenSections.length > 0);
            queryAll('[data-theme-viewer-section]', sectionList || document).forEach(input => {
                input.checked = hiddenSections.indexOf(input.value) === -1;
            });
        };

        const currentThemeViewerSettings = () => ({
            font: fontSelect ? fontSelect.value : (paletteSwitcherConfig.fontFamily || 'system'),
            animation: animationSelect ? animationSelect.value : (paletteSwitcherConfig.backgroundAnimation || 'none'),
            animationSpeed: animationSpeedSelect ? animationSpeedSelect.value : (paletteSwitcherConfig.backgroundAnimationSpeed || 'normal'),
            cursorParticles: cursorParticlesSelect ? cursorParticlesSelect.value : (paletteSwitcherConfig.cursorParticles || 'auto'),
            cursorIcon: cursorIconSelect ? cursorIconSelect.value : (paletteSwitcherConfig.cursorIcon || 'default'),
            sectionsHidden: document.body.classList.contains('rasamala-opac-sections-hidden'),
            hiddenSections: queryAll('[data-theme-viewer-section]', sectionList || document)
                .filter(input => !input.checked)
                .map(input => input.value)
        });

        let initialKey = paletteSwitcherConfig.currentKey || 'warmgray';
        let initialCustom = sanitizePaletteInput(paletteSwitcherConfig.customValue || '');
        try {
            initialKey = window.localStorage.getItem(paletteStorageKey) || initialKey;
            initialCustom = sanitizePaletteInput(window.localStorage.getItem(paletteCustomStorageKey) || initialCustom);
        } catch (error) {}
        if (!palettes[initialKey]) {
            initialKey = paletteSwitcherConfig.currentKey || 'warmgray';
        }

        customInput.value = initialCustom;
        syncControls(initialKey);
        applyPaletteChoice(initialKey, initialCustom, false);

        const initialThemeViewerSettings = {
            font: getStoredThemeViewerValue(themeViewerStorageKeys.font, paletteSwitcherConfig.fontFamily || 'system'),
            animation: getStoredThemeViewerValue(themeViewerStorageKeys.animation, paletteSwitcherConfig.backgroundAnimation || 'none'),
            animationSpeed: getStoredThemeViewerValue(themeViewerStorageKeys.animationSpeed, paletteSwitcherConfig.backgroundAnimationSpeed || 'normal'),
            cursorParticles: getStoredThemeViewerValue(themeViewerStorageKeys.cursorParticles, paletteSwitcherConfig.cursorParticles || 'auto'),
            cursorIcon: getStoredThemeViewerValue(themeViewerStorageKeys.cursorIcon, paletteSwitcherConfig.cursorIcon || 'default'),
            sectionsHidden: getStoredThemeViewerValue(themeViewerStorageKeys.sectionsHidden, '') === '1',
            hiddenSections: getStoredThemeViewerValue(themeViewerStorageKeys.hiddenSections, '')
        };
        syncThemeViewerControls(initialThemeViewerSettings);
        applyThemeViewerChoice(initialThemeViewerSettings, false);

        let initialPreset = paletteSwitcherConfig.currentPreset || 'simple_homepage';
        try {
            initialPreset = window.localStorage.getItem(themeViewerStorageKeys.preset) || initialPreset;
        } catch (error) {}
        if (presetSelect) {
            presetSelect.value = initialPreset;
        }
        detectPreset();

        toggle.addEventListener('click', (event) => {
            event.preventDefault();
            setPanelOpen(panel.hidden);
        });

        wrap.addEventListener('click', (event) => {
            if (event.target.closest('[data-palette-close]')) {
                setPanelOpen(false);
            }
        });

        select.addEventListener('change', () => {
            const key = select.value;
            syncControls(key);
            if (key !== 'custom') {
                applyPaletteChoice(key, customInput.value, true);
            }
            detectPreset();
        });

        if (swatches) {
            swatches.addEventListener('click', (event) => {
                const swatch = event.target.closest('.palette-switcher-swatch');
                if (!swatch) return;
                const key = swatch.getAttribute('data-palette-key');
                syncControls(key);
                if (key !== 'custom') {
                    applyPaletteChoice(key, customInput.value, true);
                }
                detectPreset();
            });
        }

        applyButton.addEventListener('click', () => {
            const fallback = palettes.custom || palettes[paletteSwitcherConfig.currentKey] || palettes.warmgray;
            const cleanCustomValue = normalizePaletteInputForContrast(customInput.value, fallback.light || {}, fallback.dark || {});
            customInput.value = cleanCustomValue;
            applyPaletteChoice(select.value, cleanCustomValue, true);
            applyThemeViewerChoice(currentThemeViewerSettings(), true);
        });

        resetButton.addEventListener('click', () => {
            try {
                window.localStorage.removeItem(themeViewerStorageKeys.preset);
                window.localStorage.removeItem(paletteStorageKey);
                window.localStorage.removeItem(paletteCustomStorageKey);
                Object.keys(themeViewerStorageKeys).forEach(key => window.localStorage.removeItem(themeViewerStorageKeys[key]));
            } catch (error) {}
            const key = paletteSwitcherConfig.currentKey || 'warmgray';
            customInput.value = sanitizePaletteInput(paletteSwitcherConfig.customValue || '');
            syncControls(key);
            applyPaletteChoice(key, customInput.value, false);
            const fallbackThemeSettings = {
                font: paletteSwitcherConfig.fontFamily || 'system',
                animation: paletteSwitcherConfig.backgroundAnimation || 'none',
                animationSpeed: paletteSwitcherConfig.backgroundAnimationSpeed || 'normal',
                cursorParticles: paletteSwitcherConfig.cursorParticles || 'auto',
                cursorIcon: paletteSwitcherConfig.cursorIcon || 'default',
                sectionsHidden: false,
                hiddenSections: []
            };
            syncThemeViewerControls(fallbackThemeSettings);
            applyThemeViewerChoice(fallbackThemeSettings, false);
            if (presetSelect) {
                presetSelect.value = paletteSwitcherConfig.currentPreset || 'simple_homepage';
            }
            detectPreset();
        });

        if (presetSelect) {
            presetSelect.addEventListener('change', () => {
                const key = presetSelect.value;
                if (key !== 'custom') {
                    applyPresetDefaults(key);
                    applyPaletteChoice(select.value, customInput.value, true);
                    applyThemeViewerChoice(currentThemeViewerSettings(), true);
                }
            });
        }

        [fontSelect, animationSelect, animationSpeedSelect, cursorParticlesSelect, cursorIconSelect].forEach(control => {
            if (!control) return;
            control.addEventListener('change', () => {
                const settings = currentThemeViewerSettings();
                syncThemeViewerControls(settings);
                applyThemeViewerChoice(settings, true);
                detectPreset();
            });
        });

        if (showSectionsButton) {
            showSectionsButton.addEventListener('click', () => {
                const settings = Object.assign(currentThemeViewerSettings(), {sectionsHidden: false, hiddenSections: []});
                syncThemeViewerControls(settings);
                applyThemeViewerChoice(settings, true);
                detectPreset();
            });
        }

        if (hideSectionsButton) {
            hideSectionsButton.addEventListener('click', () => {
                const settings = Object.assign(currentThemeViewerSettings(), {
                    sectionsHidden: true,
                    hiddenSections: sectionOptions().map(section => section.key)
                });
                syncThemeViewerControls(settings);
                applyThemeViewerChoice(settings, true);
                detectPreset();
            });
        }

        if (sectionList) {
            sectionList.addEventListener('change', (event) => {
                if (!event.target.matches('[data-theme-viewer-section]')) return;
                const settings = Object.assign(currentThemeViewerSettings(), {sectionsHidden: false});
                syncThemeViewerControls(settings);
                applyThemeViewerChoice(settings, true);
                detectPreset();
            });
        }

        if (copyPromptButton) {
            copyPromptButton.addEventListener('click', () => {
                copyText(paletteSwitcherConfig.prompt || '').then(() => {
                    setTemporaryButtonLabel(copyPromptButton, (paletteSwitcherConfig.labels && paletteSwitcherConfig.labels.promptCopied) || 'Copied');
                }).catch(() => {
                    setTemporaryButtonLabel(copyPromptButton, (paletteSwitcherConfig.labels && paletteSwitcherConfig.labels.clipboardUnavailable) || 'Clipboard unavailable', 1800);
                });
            });
        }

        if (pastePaletteButton) {
            pastePaletteButton.addEventListener('click', () => {
                readText().then((clipboardText) => {
                    const sanitizedValue = sanitizePaletteInput(clipboardText);
                    if (!sanitizedValue) {
                        setTemporaryButtonLabel(pastePaletteButton, (paletteSwitcherConfig.labels && paletteSwitcherConfig.labels.clipboardUnavailable) || 'Clipboard unavailable', 1800);
                        return;
                    }

                    const fallback = palettes.custom || palettes[paletteSwitcherConfig.currentKey] || palettes.warmgray;
                    const cleanValue = normalizePaletteInputForContrast(sanitizedValue, fallback.light || {}, fallback.dark || {});

                    customInput.value = cleanValue;
                    syncControls('custom');
                    customInput.focus();
                    setTemporaryButtonLabel(pastePaletteButton, (paletteSwitcherConfig.labels && paletteSwitcherConfig.labels.palettePasted) || 'Pasted');
                    detectPreset();
                }).catch(() => {
                    setTemporaryButtonLabel(pastePaletteButton, (paletteSwitcherConfig.labels && paletteSwitcherConfig.labels.clipboardUnavailable) || 'Clipboard unavailable', 1800);
                });
            });
        }

        document.addEventListener('click', (event) => {
            if (panel.hidden || wrap.contains(event.target)) return;
            setPanelOpen(false);
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                setPanelOpen(false);
            }
        });
    };

    initPaletteSwitcher();
});
