/*!
 * Rasamala theme - Hero Background Animation.
 */
'use strict';

document.addEventListener('DOMContentLoaded', () => {
    const query = (selector, root = document) => root.querySelector(selector);
    const queryAll = (selector, root = document) => Array.prototype.slice.call(root.querySelectorAll(selector));

    const initializeHeroAnimation = () => {
        const layer = query('#background-animation-layer') || query('#hero-animation-layer');

        if (!layer) return;

        const animation = layer.getAttribute('data-animation') || 'particles';
        const isGlobalBackground = layer.classList.contains('background-animation-layer');
        const reducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        const cpuCores = Number(window.navigator.hardwareConcurrency || 4);
        const deviceMemory = Number(window.navigator.deviceMemory || 4);
        const smallViewport = window.matchMedia && window.matchMedia('(max-width: 767px)').matches;
        const liteMode = smallViewport || cpuCores <= 4 || deviceMemory <= 4;

        const speedMult = parseFloat(layer.getAttribute('data-speed-multiplier')) || 1.0;

        if (typeof layer._rasamalaAnimationCleanup === 'function') {
            layer._rasamalaAnimationCleanup();
            layer._rasamalaAnimationCleanup = null;
        }

        layer.classList.remove('is-static');
        while (layer.firstChild) {
            layer.removeChild(layer.firstChild);
        }

        if (reducedMotion) {
            layer.classList.add('is-static');
            return;
        }

        const rootStyle = getComputedStyle(document.documentElement);
        const accentColor = rootStyle.getPropertyValue('--theme-accent-color').trim() || '#6f5b43';
        const accentRgb = rootStyle.getPropertyValue('--theme-accent-rgb').trim() || '111, 91, 67';
        const accentAlpha = (alpha) => `rgba(${accentRgb}, ${alpha})`;
        const darkHeroAnimation = ['particles', 'rain', 'twinkle', 'neural-network', 'starfield-warp', 'floating-embers'].includes(animation);
        const colors = isGlobalBackground
            ? [accentColor, accentAlpha(1), accentAlpha(0.92), accentAlpha(0.78), accentAlpha(0.62)]
            : (darkHeroAnimation
                ? [accentColor, accentAlpha(0.95), accentAlpha(0.78), accentAlpha(0.62), 'rgba(255, 255, 255, 0.88)']
                : [accentColor, accentAlpha(0.88), accentAlpha(0.68), accentAlpha(0.48)]);
        const glyphs = 'RASAMALA0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        const fragment = document.createDocumentFragment();
        const random = (min, max) => Math.random() * (max - min) + min;
        const randomInt = (min, max) => Math.floor(random(min, max + 1));
        const randomColor = () => colors[randomInt(0, colors.length - 1)];
        const randomGlyph = () => glyphs.charAt(randomInt(0, glyphs.length - 1));
        const startCanvasStage = (setupStage) => {
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            let width = 0;
            let height = 0;
            let frameId = 0;
            let stage = null;

            if (!context) return false;

            canvas.className = 'hero-animation-canvas';
            canvas.setAttribute('aria-hidden', 'true');
            canvas.style.cssText = 'position:absolute;inset:0;width:100%;height:100%;display:block;pointer-events:none;';
            layer.appendChild(canvas);

            const resize = () => {
                const dpr = Math.min(window.devicePixelRatio || 1, liteMode ? 1 : 1.35);
                width = Math.max(2, Math.floor(layer.clientWidth || window.innerWidth || 2));
                height = Math.max(2, Math.floor(layer.clientHeight || window.innerHeight || 2));
                canvas.width = Math.floor(width * dpr);
                canvas.height = Math.floor(height * dpr);
                context.setTransform(dpr, 0, 0, dpr, 0, 0);
                if (stage && typeof stage.resize === 'function') {
                    stage.resize(width, height);
                }
            };

            stage = setupStage(context, () => width, () => height);
            resize();

            const loop = () => {
                if (stage && typeof stage.frame === 'function') {
                    stage.frame(context, width, height);
                }
                frameId = window.requestAnimationFrame(loop);
            };

            frameId = window.requestAnimationFrame(loop);
            window.addEventListener('resize', resize, {passive: true});
            layer._rasamalaAnimationCleanup = () => {
                window.cancelAnimationFrame(frameId);
                window.removeEventListener('resize', resize);
            };

            return true;
        };

        if (animation === 'neural-network') {
            const started = startCanvasStage(() => {
                let nodes = [];
                const maxDistance = liteMode ? 108 : 136;
                const resize = (width, height) => {
                    const nodeCount = liteMode
                        ? Math.min(28, Math.max(14, Math.floor((width * height) / 36000)))
                        : Math.min(46, Math.max(22, Math.floor((width * height) / 24000)));
                    nodes = Array.from({length: nodeCount}, () => ({
                        x: random(0, width),
                        y: random(0, height),
                        vx: random(-0.28, 0.28),
                        vy: random(-0.28, 0.28),
                        r: random(1.3, 2.6)
                    }));
                };

                const frame = (context, width, height) => {
                    context.clearRect(0, 0, width, height);
                    for (let i = 0; i < nodes.length; i += 1) {
                        const node = nodes[i];
                        node.x += node.vx;
                        node.y += node.vy;

                        if (node.x < 0) {
                            node.x = 0;
                            node.vx *= -1;
                        } else if (node.x > width) {
                            node.x = width;
                            node.vx *= -1;
                        }
                        if (node.y < 0) {
                            node.y = 0;
                            node.vy *= -1;
                        } else if (node.y > height) {
                            node.y = height;
                            node.vy *= -1;
                        }

                        context.beginPath();
                        context.arc(node.x, node.y, node.r, 0, Math.PI * 2);
                        context.fillStyle = accentAlpha(0.68);
                        context.fill();

                        for (let j = i + 1; j < nodes.length; j += 1) {
                            const other = nodes[j];
                            const dist = Math.hypot(node.x - other.x, node.y - other.y);
                            if (dist < maxDistance) {
                                context.beginPath();
                                context.moveTo(node.x, node.y);
                                context.lineTo(other.x, other.y);
                                context.strokeStyle = accentAlpha((1 - dist / maxDistance) * 0.16);
                                context.lineWidth = 0.8;
                                context.stroke();
                            }
                        }
                    }
                };

                return {resize, frame};
            });
            if (started) return;
        }

        if (animation === 'starfield-warp') {
            const started = startCanvasStage(() => {
                let stars = [];
                const resize = (width, height) => {
                    const count = liteMode ? 80 : 160;
                    stars = Array.from({length: count}, () => ({
                        x: random(-width / 2, width / 2),
                        y: random(-height / 2, height / 2),
                        z: random(1, 1000)
                    }));
                };

                const frame = (context, width, height) => {
                    const isDark = document.body.classList.contains('rasamala-dark') || document.documentElement.classList.contains('rasamala-dark');
                    context.fillStyle = isDark ? 'rgba(0, 0, 0, 0.08)' : 'rgba(255, 255, 255, 0.08)';
                    context.fillRect(0, 0, width, height);

                    const cx = width / 2;
                    const cy = height / 2;
                    const speed = 2.4 / speedMult;

                    for (let i = 0; i < stars.length; i += 1) {
                        const star = stars[i];
                        star.z -= speed;
                        if (star.z <= 0) {
                            star.z = 1000;
                            star.x = random(-cx, cx);
                            star.y = random(-cy, cy);
                        }

                        const px = (star.x / star.z) * cx + cx;
                        const py = (star.y / star.z) * cy + cy;

                        if (px < 0 || px > width || py < 0 || py > height) {
                            star.z = 1000;
                            star.x = random(-cx, cx);
                            star.y = random(-cy, cy);
                            continue;
                        }

                        const size = ((1000 - star.z) / 1000) * 1.8 + 0.2;
                        context.beginPath();
                        context.arc(px, py, size, 0, Math.PI * 2);
                        context.fillStyle = accentColor;
                        context.fill();
                    }
                };

                return {resize, frame};
            });
            if (started) return;
        }

        if (animation === 'zen-ripples') {
            const started = startCanvasStage(() => {
                let ripples = [];
                const maxRadius = liteMode ? 180 : 260;
                const resize = (width, height) => {
                    ripples = Array.from({length: liteMode ? 3 : 5}, (_, index) => ({
                        x: random(0.2 * width, 0.8 * width),
                        y: random(0.2 * height, 0.8 * height),
                        r: (index / (liteMode ? 3 : 5)) * maxRadius,
                        dr: random(0.3, 0.6) / speedMult,
                        alpha: 1
                    }));
                };

                const frame = (context, width, height) => {
                    context.clearRect(0, 0, width, height);
                    ripples.forEach(ripple => {
                        ripple.r += ripple.dr;
                        if (ripple.r > maxRadius) {
                            ripple.r = 0;
                            ripple.x = random(0.2 * width, 0.8 * width);
                            ripple.y = random(0.2 * height, 0.8 * height);
                        }
                        ripple.alpha = 1 - ripple.r / maxRadius;
                        context.beginPath();
                        context.arc(ripple.x, ripple.y, ripple.r, 0, Math.PI * 2);
                        context.strokeStyle = accentAlpha(ripple.alpha * 0.15);
                        context.lineWidth = 1.2;
                        context.stroke();
                    });
                };

                return {resize, frame};
            });
            if (started) return;
        }

        if (animation === 'particles') {
            const count = liteMode ? 14 : 32;
            for (let i = 0; i < count; i += 1) {
                const element = document.createElement('span');
                element.className = 'hero-animation-item hero-token';
                element.style.color = randomColor();
                element.style.left = `${random(2, 98)}%`;
                element.style.top = `${random(5, 90)}%`;
                element.style.setProperty('--tx', `${random(-120, 120)}px`);
                element.style.setProperty('--ty', `${random(-120, 120)}px`);
                element.style.setProperty('--rot', `${random(-180, 180)}deg`);
                element.style.animationDuration = `${random(8, 20) * speedMult}s`;
                element.style.animationDelay = `-${random(0, 10)}s`;
                element.textContent = randomGlyph();
                fragment.appendChild(element);
            }
        } else if (animation === 'rain') {
            const columns = Math.min(liteMode ? 20 : 52, Math.floor(window.innerWidth / 28));
            for (let i = 0; i < columns; i += 1) {
                const element = document.createElement('span');
                element.className = 'hero-animation-item hero-rain-column';
                element.style.left = `${(i / columns) * 100}%`;
                element.style.fontSize = `${randomInt(10, 22)}px`;
                element.style.color = accentColor;
                element.style.animationDuration = `${random(1.2, 3.8) * speedMult}s`;
                element.style.animationDelay = `-${random(0, 4)}s`;
                element.style.opacity = random(0.24, 0.88);
 
                let content = '';
                const lines = randomInt(4, 11);
                for (let j = 0; j < lines; j += 1) {
                    content += `${randomGlyph()}\n`;
                }
                element.textContent = content;
                fragment.appendChild(element);
            }
        } else if (animation === 'grid') {
            const element = document.createElement('div');
            element.className = 'hero-animation-item hero-moving-grid';
            element.style.animationDuration = `${24 * speedMult}s`;
            fragment.appendChild(element);
        } else if (animation === 'twinkle') {
            const count = liteMode ? 24 : 64;
            for (let i = 0; i < count; i += 1) {
                const element = document.createElement('span');
                element.className = 'hero-animation-item hero-star';
                element.style.backgroundColor = randomColor();
                element.style.left = `${random(1, 99)}%`;
                element.style.top = `${random(2, 98)}%`;
                const size = random(1, 3);
                element.style.width = `${size}px`;
                element.style.height = `${size}px`;
                element.style.animationDuration = `${random(1.2, 4) * speedMult}s`;
                element.style.animationDelay = `-${random(0, 4)}s`;
                fragment.appendChild(element);
            }
        } else if (animation === 'floating-embers') {
            const count = liteMode ? 18 : 42;
            for (let i = 0; i < count; i += 1) {
                const ember = document.createElement('span');
                ember.className = 'hero-animation-item hero-ember';
                ember.style.backgroundColor = colors[i % colors.length];
                ember.style.left = `${random(1, 99)}%`;
                ember.style.bottom = `${random(-40, -10)}px`;
                ember.style.setProperty('--x-drift', `${random(-42, 42)}px`);
                const size = random(1.8, 5.2);
                ember.style.width = `${size}px`;
                ember.style.height = `${size}px`;
                ember.style.setProperty('--op', random(0.22, 0.58));
                ember.style.setProperty('--tx', `${random(-18, 18)}vw`);
                ember.style.animationDuration = `${random(11, 23) * speedMult}s`;
                ember.style.animationDelay = `-${random(0, 18)}s`;
                fragment.appendChild(ember);
            }
        }

        layer.appendChild(fragment);
    };

    window.initializeHeroAnimation = initializeHeroAnimation;
    initializeHeroAnimation();
    
    const refreshHeroAnimation = () => {
        if (window.requestAnimationFrame) {
            window.requestAnimationFrame(initializeHeroAnimation);
            return;
        }

        window.setTimeout(initializeHeroAnimation, 16);
    };
    
    document.addEventListener('rasamala:palette-changed', refreshHeroAnimation);
    document.addEventListener('rasamala:color-mode-changed', refreshHeroAnimation);
    document.addEventListener('rasamala:theme-viewer-changed', refreshHeroAnimation);
});
