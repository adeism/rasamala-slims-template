/*!
 * Rasamala cursor icon renderer.
 *
 * @Last modified by    : Ade Ismail Siregar (adeismailbox@gmail.com)
 * @Last modified time  : 2026-07-11T10:54:36+07:00
 */
(function () {
  'use strict';

  var MODES = [
    { id: 'neon-comet', label: 'Neon Comet', color: '#22d3ee', accent: '#7c5cff' },
    { id: 'fire-phoenix', label: 'Fire Phoenix', color: '#ff6b2c', accent: '#ffd166' },
    { id: 'pixel-sword', label: 'Pixel Sword', color: '#a3e635', accent: '#4ade80' },
    { id: 'galaxy-orb', label: 'Galaxy Orb', color: '#c084fc', accent: '#60a5fa' },
    { id: 'electric-bolt', label: 'Electric Bolt', color: '#fde047', accent: '#38bdf8' },
    { id: 'ink-brush', label: 'Ink Brush', color: '#f472b6', accent: '#e2e8f0' },
    { id: 'cyber-drone', label: 'Cyber Drone', color: '#34d399', accent: '#22d3ee' },
    { id: 'rainbow-ribbon', label: 'Rainbow Ribbon', color: '#f472b6', accent: '#22d3ee' },
    { id: 'ghost-spirit', label: 'Ghost Spirit', color: '#a5b4fc', accent: '#e0e7ff' },
    { id: 'crystal-shard', label: 'Crystal Shard', color: '#67e8f9', accent: '#f0abfc' }
  ];
  var LEGACY_MODE_MAP = {
    rocket: 'neon-comet',
    wand: 'electric-bolt',
    book: 'pixel-sword',
    sparkles: 'galaxy-orb'
  };

  function hexToRgb(hex) {
    var c = String(hex || '').replace('#', '');
    if (c.length === 3) c = c.split('').map(function (char) { return char + char; }).join('');
    var n = parseInt(c, 16);
    if (Number.isNaN(n)) return [255, 255, 255];
    return [(n >> 16) & 255, (n >> 8) & 255, n & 255];
  }

  function cssAccentRgb() {
    var raw = getComputedStyle(document.documentElement).getPropertyValue('--theme-accent-rgb').trim();
    if (!raw) return [111, 91, 67];
    return raw.split(',').map(function (part) { return parseInt(part.trim(), 10) || 0; }).slice(0, 3);
  }

  function rgbString(rgb) {
    return 'rgb(' + rgb[0] + ',' + rgb[1] + ',' + rgb[2] + ')';
  }

  MODES.forEach(function (mode) {
    mode.rgb = hexToRgb(mode.color);
    mode.rgbA = hexToRgb(mode.accent);
  });

  function rgba(rgb, alpha) {
    alpha = Math.max(0, Math.min(1, alpha));
    return 'rgba(' + rgb[0] + ',' + rgb[1] + ',' + rgb[2] + ',' + alpha + ')';
  }

  function findMode(modeId) {
    modeId = LEGACY_MODE_MAP[modeId] || modeId;
    for (var index = 0; index < MODES.length; index += 1) {
      if (MODES[index].id === modeId) return { mode: MODES[index], index: index };
    }
    return { mode: MODES[0], index: 0 };
  }

  function rainbowRgb(t) {
    var h = (((t % 1) + 1) % 1) * 6;
    var i = h | 0;
    var f = h - i;
    var q = 1 - f;
    var r;
    var g;
    var b;

    switch (i % 6) {
      case 0: r = 1; g = f; b = 0; break;
      case 1: r = q; g = 1; b = 0; break;
      case 2: r = 0; g = 1; b = f; break;
      case 3: r = 0; g = q; b = 1; break;
      case 4: r = f; g = 0; b = 1; break;
      default: r = 1; g = 0; b = q;
    }

    return [(r * 255) | 0, (g * 255) | 0, (b * 255) | 0];
  }

  function pointerIsFine() {
    return window.matchMedia && window.matchMedia('(pointer: fine)').matches;
  }

  function reducedMotion() {
    return window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  }

  function deviceQuality() {
    var cores = navigator.hardwareConcurrency || 4;
    var memory = navigator.deviceMemory || 4;
    var saveData = !!(navigator.connection && navigator.connection.saveData);
    var isMobile = /Mobi|Android|iPhone|iPad/i.test(navigator.userAgent) ||
      (navigator.maxTouchPoints > 1 && Math.min(screen.width, screen.height) < 900);

    if (saveData || isMobile || memory <= 2 || cores <= 2) return 0;
    if (memory <= 4 || cores <= 4) return 1;
    return 2;
  }

  function injectStyles() {
    if (document.getElementById('rasamala-cursor-icon-style')) return;

    var style = document.createElement('style');
    style.id = 'rasamala-cursor-icon-style';
    style.textContent = [
      'body.rasamala-custom-cursor-active,',
      'body.rasamala-custom-cursor-active a,',
      'body.rasamala-custom-cursor-active button,',
      'body.rasamala-custom-cursor-active [role="button"],',
      'body.rasamala-custom-cursor-active label,',
      'body.rasamala-custom-cursor-active .cursor-pointer { cursor: none !important; }',
      'body.rasamala-custom-cursor-active input,',
      'body.rasamala-custom-cursor-active textarea,',
      'body.rasamala-custom-cursor-active select,',
      'body.rasamala-custom-cursor-active iframe { cursor: auto !important; }',
      '#rasamala-cursor-icon-canvas { position: fixed; inset: 0; width: 100%; height: 100%; z-index: 2147483646; pointer-events: none; }'
    ].join('\n');
    document.head.appendChild(style);
  }

  function init() {
    var body = document.body;
    if (!body || reducedMotion() || !pointerIsFine()) return;

    var modeId = body.getAttribute('data-cursor-custom-icon') || 'default';
    if (modeId === 'default' || modeId === 'none' || modeId === '0') return;

    var modeData = findMode(modeId);
    var mode = modeData.mode;
    var modeIndex = modeData.index;
    var themeRgb = cssAccentRgb();
    var canvas = document.createElement('canvas');
    var context = canvas.getContext('2d', { alpha: true, desynchronized: true });
    if (!context) return;
    var width = 0;
    var height = 0;
    var dpr = 1;
    var mouseX = window.innerWidth / 2;
    var mouseY = window.innerHeight / 2;
    var smoothX = mouseX;
    var smoothY = mouseY;
    var velocityX = 0;
    var velocityY = 0;
    var speed = 0;
    var time = 0;
    var angle = 0;
    var visible = true;
    var quality = deviceQuality();
    var maxDpr = quality === 0 ? 1 : quality === 1 ? 1.15 : 1.35;
    var frameInterval = quality === 0 ? 1000 / 30 : quality === 1 ? 1000 / 45 : 1000 / 60;
    var lastFrame = 0;

    injectStyles();
    canvas.id = 'rasamala-cursor-icon-canvas';
    canvas.setAttribute('aria-hidden', 'true');
    document.body.appendChild(canvas);
    document.body.classList.add('rasamala-custom-cursor-active');

    window.RasamalaCursorModes = MODES;
    window.RasamalaCursorState = {
      modeId: mode.id,
      modeIndex: modeIndex,
      mode: mode,
      x: smoothX,
      y: smoothY,
      speed: speed
    };

    function resize() {
      width = window.innerWidth;
      height = window.innerHeight;
      dpr = Math.min(window.devicePixelRatio || 1, maxDpr);
      canvas.width = Math.max(1, (width * dpr) | 0);
      canvas.height = Math.max(1, (height * dpr) | 0);
      context.setTransform(dpr, 0, 0, dpr, 0, 0);
    }

    function glow(x, y, radius, rgb, alpha) {
      var gradient = context.createRadialGradient(x, y, 0, x, y, radius);
      gradient.addColorStop(0, rgba(rgb, alpha));
      gradient.addColorStop(1, rgba(rgb, 0));
      context.fillStyle = gradient;
      context.beginPath();
      context.arc(x, y, radius, 0, Math.PI * 2);
      context.fill();
    }

    function currentPalette() {
      if (document.body.classList.contains('rasamala-dark')) {
        return {
          rgb: mode.rgb,
          rgbA: mode.rgbA,
          color: mode.color,
          accent: mode.accent,
          isDark: true
        };
      }

      themeRgb = cssAccentRgb();
      return {
        rgb: themeRgb,
        rgbA: themeRgb,
        color: rgbString(themeRgb),
        accent: rgbString(themeRgb),
        isDark: false
      };
    }

    function drawShape() {
      var x = smoothX;
      var y = smoothY;
      var moveAngle = Math.atan2(velocityY || 0.001, velocityX || 0.001);
      var pulse = 1 + Math.sin(time * 0.006) * 0.07;
      var palette = currentPalette();

      context.save();

      if (mode.id === 'neon-comet') {
        glow(x, y, 28 * pulse, palette.rgb, 0.38);
        context.fillStyle = '#fff';
        context.beginPath();
        context.arc(x, y, 4.5 * pulse, 0, Math.PI * 2);
        context.fill();
        context.strokeStyle = rgba(palette.rgb, 0.9);
        context.lineWidth = 2;
        context.beginPath();
        context.arc(x, y, 10 * pulse, 0, Math.PI * 2);
        context.stroke();
      } else if (mode.id === 'fire-phoenix') {
        glow(x, y, 32 * pulse, palette.rgb, 0.36);
        context.translate(x, y);
        context.rotate(moveAngle + Math.PI / 2);
        context.fillStyle = palette.color;
        context.beginPath();
        context.moveTo(0, -20 * pulse);
        context.bezierCurveTo(12, -2, 8, 16, 0, 18);
        context.bezierCurveTo(-8, 16, -12, -2, 0, -20 * pulse);
        context.fill();
        context.fillStyle = '#fff7ed';
        context.beginPath();
        context.ellipse(0, -3, 3.5, 8, 0, 0, Math.PI * 2);
        context.fill();
      } else if (mode.id === 'pixel-sword') {
        context.translate(x, y);
        context.rotate(moveAngle + Math.PI / 4);
        context.fillStyle = '#e2e8f0';
        context.fillRect(-2, -24, 4, 20);
        context.fillStyle = palette.color;
        context.fillRect(-2, -4, 4, 8);
        context.fillRect(-6, 0, 12, 4);
        context.fillStyle = '#ca8a04';
        context.fillRect(-2, 8, 4, 12);
      } else if (mode.id === 'galaxy-orb') {
        glow(x, y, 30 * pulse, palette.rgb, 0.3);
        context.translate(x, y);
        context.rotate(angle);
        context.fillStyle = palette.color;
        context.beginPath();
        context.arc(0, 0, 12 * pulse, 0, Math.PI * 2);
        context.fill();
        context.fillStyle = '#fff';
        context.beginPath();
        context.arc(-3, -3, 4, 0, Math.PI * 2);
        context.fill();
        context.strokeStyle = palette.accent;
        context.lineWidth = 1.5;
        context.beginPath();
        context.ellipse(0, 0, 22, 8, 0.4, 0, Math.PI * 2);
        context.stroke();
      } else if (mode.id === 'electric-bolt') {
        glow(x, y, 26 * pulse, palette.rgb, 0.35);
        context.translate(x, y);
        context.rotate(moveAngle);
        context.strokeStyle = palette.color;
        context.lineWidth = 2.2;
        context.beginPath();
        context.moveTo(-14, 0);
        context.lineTo(-8, -5);
        context.lineTo(-3, 4);
        context.lineTo(4, -4);
        context.lineTo(12, 2);
        context.stroke();
        context.fillStyle = '#fff';
        context.beginPath();
        context.arc(0, 0, 3 * pulse, 0, Math.PI * 2);
        context.fill();
      } else if (mode.id === 'ink-brush') {
        context.translate(x, y);
        context.rotate(moveAngle + Math.PI / 2);
        context.fillStyle = '#1e1b4b';
        context.fillRect(-2.5, -2, 5, 18);
        context.fillStyle = palette.color;
        context.beginPath();
        context.moveTo(-5, -2);
        context.quadraticCurveTo(0, -22 * pulse, 5, -2);
        context.closePath();
        context.fill();
        context.fillStyle = '#f8fafc';
        context.fillRect(-3.5, 16, 7, 5);
      } else if (mode.id === 'cyber-drone') {
        glow(x, y, 26 * pulse, palette.rgb, 0.28);
        context.translate(x, y);
        context.strokeStyle = palette.accent;
        context.lineWidth = 1.4;
        context.beginPath();
        context.arc(0, 0, 16, 0, Math.PI * 2);
        context.stroke();
        context.beginPath();
        context.arc(0, 0, 10, angle, angle + 3.5);
        context.stroke();
        context.fillStyle = 'rgba(15,23,42,0.9)';
        context.strokeStyle = palette.color;
        context.lineWidth = 2;
        context.beginPath();
        context.rect(-7, -5, 14, 10);
        context.fill();
        context.stroke();
      } else if (mode.id === 'rainbow-ribbon') {
        context.translate(x, y);
        for (var i = 0; i < 6; i += 1) {
          var dotColor = palette.isDark ? rainbowRgb(time * 0.0015 + i / 6) : palette.rgb;
          var dotAngle = angle + i * (Math.PI * 2 / 6);
          context.fillStyle = rgba(dotColor, palette.isDark ? 1 : 0.78 - (i * 0.06));
          context.beginPath();
          context.arc(Math.cos(dotAngle) * 7, Math.sin(dotAngle) * 7, 3, 0, Math.PI * 2);
          context.fill();
        }
        context.fillStyle = palette.isDark ? '#fff' : palette.color;
        context.beginPath();
        context.arc(0, 0, 4 * pulse, 0, Math.PI * 2);
        context.fill();
      } else if (mode.id === 'ghost-spirit') {
        glow(x, y, 30 * pulse, palette.rgb, 0.22);
        context.translate(x, y);
        context.globalAlpha = 0.82;
        context.fillStyle = rgba(palette.rgbA, 0.75);
        context.beginPath();
        context.ellipse(0, Math.sin(time * 0.005) * 2, 11 * pulse, 14 * pulse, 0, Math.PI, 0);
        context.lineTo(11 * pulse, 12);
        context.quadraticCurveTo(5, 18, 0, 12);
        context.quadraticCurveTo(-5, 18, -11 * pulse, 12);
        context.closePath();
        context.fill();
        context.globalAlpha = 1;
        context.fillStyle = '#1e1b4b';
        context.beginPath();
        context.arc(-3.5, -2, 2, 0, Math.PI * 2);
        context.arc(3.5, -2, 2, 0, Math.PI * 2);
        context.fill();
      } else if (mode.id === 'crystal-shard') {
        glow(x, y, 28 * pulse, palette.rgb, 0.33);
        context.translate(x, y);
        context.rotate(angle * 0.6 + moveAngle * 0.15);
        context.fillStyle = palette.color;
        context.strokeStyle = 'rgba(255,255,255,0.75)';
        context.lineWidth = 1.1;
        context.beginPath();
        context.moveTo(0, -16 * pulse);
        context.lineTo(9 * pulse, -1 * pulse);
        context.lineTo(5 * pulse, 14 * pulse);
        context.lineTo(-7 * pulse, 9 * pulse);
        context.lineTo(-10 * pulse, -5 * pulse);
        context.closePath();
        context.fill();
        context.stroke();
      }

      context.restore();
    }

    function frame(timestamp) {
      requestAnimationFrame(frame);
      if (!visible) return;
      if (timestamp - lastFrame < frameInterval) return;
      lastFrame = timestamp;

      time = timestamp || 0;
      smoothX += (mouseX - smoothX) * 0.35;
      smoothY += (mouseY - smoothY) * 0.35;
      velocityX *= 0.88;
      velocityY *= 0.88;
      speed = Math.hypot(velocityX, velocityY);
      angle += 0.035 + speed * 0.0015;

      window.RasamalaCursorState.x = smoothX;
      window.RasamalaCursorState.y = smoothY;
      window.RasamalaCursorState.speed = speed;

      context.clearRect(0, 0, width, height);
      drawShape();
    }

    function onMove(event) {
      velocityX = event.clientX - mouseX;
      velocityY = event.clientY - mouseY;
      mouseX = event.clientX;
      mouseY = event.clientY;
    }

    function setVisible(nextVisible) {
      visible = nextVisible;
      canvas.style.opacity = visible ? '1' : '0';
    }

    window.addEventListener('resize', resize, { passive: true });
    document.addEventListener('mousemove', onMove, { passive: true });
    document.addEventListener('mouseleave', function () { setVisible(false); }, { passive: true });
    document.addEventListener('mouseenter', function () { setVisible(true); }, { passive: true });
    document.addEventListener('visibilitychange', function () { setVisible(!document.hidden); });

    resize();
    requestAnimationFrame(frame);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init, { once: true });
  } else {
    init();
  }
}());
