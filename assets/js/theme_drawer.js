/*!
 * Rasamala theme - Floating Theme Viewer / Drawer Interactivity Module
 */
'use strict';

(function(window, document) {
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

    const getConfig = () => readJsonConfig('rasamala-palette-switcher-config', window.rasamalaPaletteSwitcher || null);
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

    const fontStacks = {
        system: 'system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif',
        inter: '"Inter", system-ui, BlinkMacSystemFont, "Segoe UI", sans-serif',
        roboto: '"Roboto", Arial, Helvetica, sans-serif',
        poppins: '"Poppins", "Trebuchet MS", Arial, sans-serif',
        playfair: '"Playfair Display", Georgia, "Times New Roman", serif'
    };

    const optionValueExists = (options, value) => !!options && Object.prototype.hasOwnProperty.call(options, value);

    const getStoredValue = (key, fallback) => {
        try {
            const value = window.localStorage.getItem(key);
            return value == null || value === '' ? fallback : value;
        } catch (error) {
            return fallback;
        }
    };

    const setStoredValue = (key, value, fallback) => {
        try {
            if (value === fallback || value == null || value === '') {
                window.localStorage.removeItem(key);
                return;
            }
            window.localStorage.setItem(key, value);
        } catch (error) {}
    };

    const sectionOptions = () => {
        const config = getConfig();
        return Array.isArray(config && config.homeSections) ? config.homeSections : [];
    };

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
        const paletteSwitcherConfig = getConfig();
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
        const activePreset = presetSelect ? presetSelect.value : (getStoredValue(themeViewerStorageKeys.preset) || paletteSwitcherConfig.currentPreset || 'simple_homepage');
        const isOnlyHero = (activePreset === 'simple_homepage');
        const isOffice = (activePreset === 'office');

        document.body.classList.toggle('rasamala-home-hero-only', isOnlyHero);
        queryAll('.rasamala-hero-section').forEach(element => {
            element.classList.toggle('rasamala-hero-section-only', isOnlyHero);
        });
        queryAll('.rasamala-search-banner-section').forEach(element => {
            element.classList.toggle('rasamala-search-banner-hero-only', isOnlyHero);
        });

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
                setStoredValue(themeViewerStorageKeys.preset, presetSelect.value, paletteSwitcherConfig.currentPreset || 'simple_homepage');
            }
            setStoredValue(themeViewerStorageKeys.font, font, paletteSwitcherConfig.fontFamily || 'system');
            setStoredValue(themeViewerStorageKeys.animation, animation, paletteSwitcherConfig.backgroundAnimation || 'none');
            setStoredValue(themeViewerStorageKeys.animationSpeed, animationSpeed, paletteSwitcherConfig.backgroundAnimationSpeed || 'normal');
            setStoredValue(themeViewerStorageKeys.cursorParticles, cursorParticles, paletteSwitcherConfig.cursorParticles || 'auto');
            setStoredValue(themeViewerStorageKeys.cursorIcon, cursorIcon, paletteSwitcherConfig.cursorIcon || 'default');
            setStoredValue(themeViewerStorageKeys.sectionsHidden, sectionsHidden ? '1' : '', '');
            setStoredValue(themeViewerStorageKeys.hiddenSections, hiddenSections.join(','), '');
        }

        document.dispatchEvent(new CustomEvent('rasamala:theme-viewer-changed', {
            detail: {font, animation, animationSpeed, cursorParticles, cursorIcon, sectionsHidden, hiddenSections}
        }));
        document.dispatchEvent(new CustomEvent('rasamala:cursor-settings-changed', {
            detail: {cursorParticles, cursorIcon}
        }));
    };

    window.RasamalaThemeDrawer = {
        getConfig: getConfig,
        get config() { return getConfig(); },
        storageKeys: themeViewerStorageKeys,
        presets: presetDefinitions,
        applyChoice: applyThemeViewerChoice,
        getStoredValue: getStoredValue,
        setStoredValue: setStoredValue
    };

})(window, document);
