/*!
 * Rasamala theme - Theme Viewer / Switcher Bundle Entry Point
 */
'use strict';

document.addEventListener('DOMContentLoaded', () => {
    const query = (selector, root = document) => root.querySelector(selector);
    const queryAll = (selector, root = document) => Array.prototype.slice.call(root.querySelectorAll(selector));

    const paletteSwitcherConfig = (window.RasamalaPaletteSwitcher && window.RasamalaPaletteSwitcher.config) || null;
    if (!paletteSwitcherConfig || paletteSwitcherConfig.enabled === false) {
        try {
            window.localStorage.removeItem('rasamala-theme-palette-key');
            window.localStorage.removeItem('rasamala-theme-custom-palette');
        } catch (error) {}
        return;
    }

    const wrap = query('#rasamala-palette-switcher');
    const toggle = query('#palette-switcher-toggle');
    const panel = query('#palette-switcher-panel');
    const select = query('#palette-switcher-select');
    const swatches = query('#palette-switcher-swatches');
    const customWrap = query('#palette-switcher-custom');
    const customInput = query('#palette-switcher-custom-input');
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
    const presetSelect = query('#theme-preset-select');

    if (!wrap || !toggle || !panel || !select || !customInput || !resetButton) return;

    const palettes = paletteSwitcherConfig.palettes || {};
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

    fillSelect(presetSelect, paletteSwitcherConfig.presets);
    fillSelect(fontSelect, paletteSwitcherConfig.fonts);
    fillSelect(animationSelect, paletteSwitcherConfig.animations);
    fillSelect(animationSpeedSelect, paletteSwitcherConfig.animationSpeeds);
    fillSelect(cursorParticlesSelect, paletteSwitcherConfig.cursorParticlesOptions);
    fillSelect(cursorIconSelect, paletteSwitcherConfig.cursorIcons);

    const sectionOptions = Array.isArray(paletteSwitcherConfig.homeSections) ? paletteSwitcherConfig.homeSections : [];
    if (sectionList) {
        sectionList.textContent = '';
        sectionOptions.forEach(section => {
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
            window.setTimeout(() => { textNode.textContent = previous; }, delay);
        } else {
            const previous = button.getAttribute('title') || '';
            const previousAria = button.getAttribute('aria-label') || '';
            button.setAttribute('title', label);
            button.setAttribute('aria-label', label);
            window.setTimeout(() => {
                button.setAttribute('title', previous);
                button.setAttribute('aria-label', previousAria);
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

    const syncThemeViewerControls = (settings) => {
        const hiddenSections = settings.sectionsHidden === true || settings.sectionsHidden === '1'
            ? sectionOptions.map(section => section.key)
            : (Array.isArray(settings.hiddenSections) ? settings.hiddenSections : String(settings.hiddenSections || '').split(',').filter(Boolean));
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
        wrap.classList.toggle('is-sections-hidden', hiddenSections.length === sectionOptions.length && hiddenSections.length > 0);
        queryAll('[data-theme-viewer-section]', sectionList || document).forEach(input => {
            input.checked = hiddenSections.indexOf(input.value) === -1;
        });
    };

    const detectPreset = () => {
        if (!presetSelect) return;
        const current = currentThemeViewerSettings();
        const currentPalette = select.value;

        for (const [key, def] of Object.entries(window.RasamalaThemeDrawer.presets)) {
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

    const applyPresetDefaults = (presetKey) => {
        const def = window.RasamalaThemeDrawer.presets[presetKey];
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

    let customPaletteApplyTimer = 0;

    const applyCustomPaletteValue = (value, persist = true, shouldFocus = false, allowFallback = false) => {
        const sanitizedValue = window.RasamalaPaletteSwitcher.sanitizeInput(value);
        if (!sanitizedValue && !allowFallback) {
            return false;
        }

        const fallback = palettes.custom || palettes[paletteSwitcherConfig.currentKey] || palettes.warmgray || {};
        const fallbackValue = window.RasamalaPaletteSwitcher.sanitizeInput(paletteSwitcherConfig.customValue || '');
        const sourceValue = sanitizedValue || fallbackValue;
        const cleanValue = window.RasamalaPaletteSwitcher.normalizeInput(sourceValue, fallback.light || {}, fallback.dark || {});

        customInput.value = cleanValue;
        select.value = 'custom';
        syncControls('custom');
        window.RasamalaPaletteSwitcher.applyChoice('custom', cleanValue, persist);
        window.RasamalaThemeDrawer.applyChoice(currentThemeViewerSettings(), persist);
        if (shouldFocus) {
            customInput.focus();
        }
        detectPreset();
        return true;
    };

    const scheduleApplyCustomPaletteFromInput = (delay = 40) => {
        window.clearTimeout(customPaletteApplyTimer);
        customPaletteApplyTimer = window.setTimeout(() => {
            applyCustomPaletteValue(customInput.value, true, false);
        }, delay);
    };

    let initialKey = paletteSwitcherConfig.currentKey || 'warmgray';
    let initialCustom = window.RasamalaPaletteSwitcher.sanitizeInput(paletteSwitcherConfig.customValue || '');
    try {
        initialKey = window.localStorage.getItem(window.RasamalaPaletteSwitcher.storageKeys.key) || initialKey;
        initialCustom = window.RasamalaPaletteSwitcher.sanitizeInput(window.localStorage.getItem(window.RasamalaPaletteSwitcher.storageKeys.custom) || initialCustom);
    } catch (error) {}
    if (!palettes[initialKey]) {
        initialKey = paletteSwitcherConfig.currentKey || 'warmgray';
    }

    customInput.value = initialCustom;
    syncControls(initialKey);
    window.RasamalaPaletteSwitcher.applyChoice(initialKey, initialCustom, false);

    const initialThemeSettings = {
        font: window.RasamalaThemeDrawer.getStoredValue(window.RasamalaThemeDrawer.storageKeys.font, paletteSwitcherConfig.fontFamily || 'system'),
        animation: window.RasamalaThemeDrawer.getStoredValue(window.RasamalaThemeDrawer.storageKeys.animation, paletteSwitcherConfig.backgroundAnimation || 'none'),
        animationSpeed: window.RasamalaThemeDrawer.getStoredValue(window.RasamalaThemeDrawer.storageKeys.animationSpeed, paletteSwitcherConfig.backgroundAnimationSpeed || 'normal'),
        cursorParticles: window.RasamalaThemeDrawer.getStoredValue(window.RasamalaThemeDrawer.storageKeys.cursorParticles, paletteSwitcherConfig.cursorParticles || 'auto'),
        cursorIcon: window.RasamalaThemeDrawer.getStoredValue(window.RasamalaThemeDrawer.storageKeys.cursorIcon, paletteSwitcherConfig.cursorIcon || 'default'),
        sectionsHidden: window.RasamalaThemeDrawer.getStoredValue(window.RasamalaThemeDrawer.storageKeys.sectionsHidden, '') === '1',
        hiddenSections: window.RasamalaThemeDrawer.getStoredValue(window.RasamalaThemeDrawer.storageKeys.hiddenSections, '')
    };
    syncThemeViewerControls(initialThemeSettings);
    window.RasamalaThemeDrawer.applyChoice(initialThemeSettings, false);

    let initialPreset = paletteSwitcherConfig.currentPreset || 'simple_homepage';
    try {
        initialPreset = window.localStorage.getItem(window.RasamalaThemeDrawer.storageKeys.preset) || initialPreset;
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
        if (key === 'custom') {
            applyCustomPaletteValue(customInput.value, true, false, true);
        } else {
            window.RasamalaPaletteSwitcher.applyChoice(key, customInput.value, true);
        }
        detectPreset();
    });

    if (swatches) {
        swatches.addEventListener('click', (event) => {
            const swatch = event.target.closest('.palette-switcher-swatch');
            if (!swatch) return;
            const key = swatch.getAttribute('data-palette-key');
            syncControls(key);
            if (key === 'custom') {
                applyCustomPaletteValue(customInput.value, true, false, true);
            } else {
                window.RasamalaPaletteSwitcher.applyChoice(key, customInput.value, true);
            }
            detectPreset();
        });
    }

    customInput.addEventListener('change', () => {
        if (select.value !== 'custom') return;
        applyCustomPaletteValue(customInput.value, true);
    });

    customInput.addEventListener('paste', () => {
        select.value = 'custom';
        syncControls('custom');
        scheduleApplyCustomPaletteFromInput();
    });

    customInput.addEventListener('input', (event) => {
        if (!event.inputType || event.inputType.indexOf('insertFrom') !== 0) return;
        select.value = 'custom';
        syncControls('custom');
        scheduleApplyCustomPaletteFromInput();
    });

    resetButton.addEventListener('click', () => {
        try {
            window.localStorage.removeItem(window.RasamalaThemeDrawer.storageKeys.preset);
            window.localStorage.removeItem(window.RasamalaPaletteSwitcher.storageKeys.key);
            window.localStorage.removeItem(window.RasamalaPaletteSwitcher.storageKeys.custom);
            Object.keys(window.RasamalaThemeDrawer.storageKeys).forEach(key => window.localStorage.removeItem(window.RasamalaThemeDrawer.storageKeys[key]));
        } catch (error) {}
        const key = paletteSwitcherConfig.currentKey || 'warmgray';
        customInput.value = window.RasamalaPaletteSwitcher.sanitizeInput(paletteSwitcherConfig.customValue || '');
        syncControls(key);
        window.RasamalaPaletteSwitcher.applyChoice(key, customInput.value, false);
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
        window.RasamalaThemeDrawer.applyChoice(fallbackThemeSettings, false);
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
                window.RasamalaPaletteSwitcher.applyChoice(select.value, customInput.value, true);
                window.RasamalaThemeDrawer.applyChoice(currentThemeViewerSettings(), true);
            }
        });
    }

    [fontSelect, animationSelect, animationSpeedSelect, cursorParticlesSelect, cursorIconSelect].forEach(control => {
        if (!control) return;
        control.addEventListener('change', () => {
            const settings = currentThemeViewerSettings();
            syncThemeViewerControls(settings);
            window.RasamalaThemeDrawer.applyChoice(settings, true);
            detectPreset();
        });
    });

    if (showSectionsButton) {
        showSectionsButton.addEventListener('click', () => {
            const settings = Object.assign(currentThemeViewerSettings(), {sectionsHidden: false, hiddenSections: []});
            syncThemeViewerControls(settings);
            window.RasamalaThemeDrawer.applyChoice(settings, true);
            detectPreset();
        });
    }

    if (hideSectionsButton) {
        hideSectionsButton.addEventListener('click', () => {
            const settings = Object.assign(currentThemeViewerSettings(), {
                sectionsHidden: true,
                hiddenSections: sectionOptions.map(section => section.key)
            });
            syncThemeViewerControls(settings);
            window.RasamalaThemeDrawer.applyChoice(settings, true);
            detectPreset();
        });
    }

    if (sectionList) {
        sectionList.addEventListener('change', (event) => {
            if (!event.target.matches('[data-theme-viewer-section]')) return;
            const settings = Object.assign(currentThemeViewerSettings(), {sectionsHidden: false});
            syncThemeViewerControls(settings);
            window.RasamalaThemeDrawer.applyChoice(settings, true);
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
                if (!applyCustomPaletteValue(clipboardText, true, true)) {
                    setTemporaryButtonLabel(pastePaletteButton, (paletteSwitcherConfig.labels && paletteSwitcherConfig.labels.clipboardUnavailable) || 'Clipboard unavailable', 1800);
                    return;
                }
                setTemporaryButtonLabel(pastePaletteButton, (paletteSwitcherConfig.labels && paletteSwitcherConfig.labels.palettePasted) || 'Pasted');
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
});
