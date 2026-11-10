/*
 * Motion for the homepage and case studies: rotating headline words, scroll
 * reveals, the custom cursor and the dog that chases it. Ported from the
 * original design without behaviour changes.
 */
(function () {
  'use strict';
  var isHome = document.body.classList.contains('home');

  function setupRotator() {
    var rot = document.querySelector('.rot');
    if (!rot) return;
    var words = [];
    try { words = JSON.parse(rot.getAttribute('data-words') || '[]'); } catch (e) {}
    if (words.length < 2) return;
    var sr = rot.firstElementChild, w = 0;
    var cell = 'grid-area:1/1;display:inline-flex;white-space:nowrap';
    function word(text, anim, base, out) {
      var s = document.createElement('span');
      s.className = out ? 'rot-word rot-out' : 'rot-word';
      s.setAttribute('aria-hidden', 'true');
      s.style.cssText = cell;
      text.split('').forEach(function (c, i) {
        var ch = document.createElement('span');
        ch.style.cssText = 'display:inline-block;animation:' + anim + ' .7s cubic-bezier(.65,0,.15,1) both;animation-delay:' + (base + i * 38) + 'ms';
        ch.textContent = c;
        s.appendChild(ch);
      });
      return s;
    }
    setInterval(function () {
      var prev = w;
      w = (w + 1) % words.length;
      while (rot.lastChild !== sr) rot.removeChild(rot.lastChild);
      rot.appendChild(word(words[w], 'chIn', 160, false));
      rot.appendChild(word(words[prev], 'chOut', 0, true));
    }, 2800);
  }

  function setupReveal() {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches || !('IntersectionObserver' in window)) return;
    var els = [], io;
    if (isHome) {
      document.querySelectorAll('main section').forEach(function (sec) {
        var hero = sec.dataset.screenLabel === 'Hero';
        Array.prototype.forEach.call(sec.children, function (ch, ci) {
          var kids = Array.prototype.slice.call(ch.children);
          if (!hero && getComputedStyle(ch).display === 'grid' && kids.length >= 3 && ch.tagName !== 'FORM') {
            kids.forEach(function (k, i) { k.dataset.d = (i % 4) * 90; els.push(k); });
          } else { ch.dataset.d = hero ? ci * 120 : 0; els.push(ch); }
        });
      });
      document.querySelectorAll('#brandora figure, #work > a').forEach(function (el) { el.classList.add('rv-img'); });
    } else {
      document.querySelectorAll('main > section, main > a').forEach(function (sec) {
        if (sec.tagName === 'A') { sec.classList.add('rv-img'); sec.dataset.d = 0; els.push(sec); return; }
        Array.prototype.forEach.call(sec.children, function (ch, i) { ch.dataset.d = sec.dataset.screenLabel === 'Case hero' ? i * 110 : 0; els.push(ch); });
      });
    }
    io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (!e.isIntersecting) return;
        var el = e.target;
        el.style.transitionDelay = el.dataset.d + 'ms';
        el.classList.add('in');
        setTimeout(function () { el.style.transitionDelay = ''; }, 1400);
        io.unobserve(el);
      });
    }, { rootMargin: '0px 0px -8% 0px', threshold: isHome ? 0.08 : 0.05 });
    els.forEach(function (el) { el.classList.add('rv'); io.observe(el); });
  }

  function setupCursor() {
    if (!window.matchMedia('(pointer:fine) and (hover:hover)').matches) return;
    const ring = document.createElement('div');
    ring.className = 'cur-ring cur-hide';
    document.body.append(ring); document.documentElement.classList.add('cc');
    const sel = isHome ? 'a,button,summary,select,[role=button],label' : 'a,button,[role=button]';
    const mv = e => { ring.style.transform = 'translate(' + e.clientX + 'px,' + e.clientY + 'px)'; ring.classList.remove('cur-hide'); ring.classList.toggle('hov', !!e.target.closest(sel)); };
    const lv = () => ring.classList.add('cur-hide');
    const dn = () => ring.classList.add('down'), up = () => ring.classList.remove('down');
    window.addEventListener('mousemove', mv); document.addEventListener('mouseleave', lv); window.addEventListener('mousedown', dn); window.addEventListener('mouseup', up);
  }

  function setupDog() {
    var raf;
    const mq = '(pointer:fine) and (hover:hover) and (min-width:900px)';
    if (!window.matchMedia(mq).matches || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    const WH = '#ffffff', SH = '#ebe8e3', INK = '#161514';
    const headSvg = (o, z) => '<g class="dog-head">' +
      '<path d="M-16 1 Q-17 -14.5 0 -14.5 Q17 -14.5 16 1 Q15 13.5 0 13.5 Q-15 13.5 -16 1 Z" fill="' + WH + '"/>' +
      '<g class="dog-ear" data-s="-1" data-ox="-10" data-oy="-12"><path d="M-7 -13.5 Q-19 -16 -21 -5 Q-22.5 5 -15.5 6.5 Q-11 6 -10.5 -2 Q-10 -9 -7 -13.5 Z" fill="' + WH + '"/></g>' +
      '<g class="dog-ear" data-s="1" data-ox="10" data-oy="-12"><path d="M7 -13.5 Q19 -16 21 -5 Q22.5 5 15.5 6.5 Q11 6 10.5 -2 Q10 -9 7 -13.5 Z" fill="' + WH + '"/></g>' +
      (z ? '<path d="M' + (o - 8.5) + ' -1 Q' + (o - 6) + ' 1.4 ' + (o - 3.5) + ' -1 M' + (o + 3.5) + ' -1 Q' + (o + 6) + ' 1.4 ' + (o + 8.5) + ' -1" stroke-width="1.8"/>' :
      '<circle cx="' + (o - 6) + '" cy="-1" r="2.3" fill="' + INK + '" stroke="none"/><circle cx="' + (o - 5.3) + '" cy="-1.8" r=".7" fill="#fff" stroke="none"/>' +
      '<circle cx="' + (o + 6) + '" cy="-1" r="2.3" fill="' + INK + '" stroke="none"/><circle cx="' + (o + 6.7) + '" cy="-1.8" r=".7" fill="#fff" stroke="none"/>') +
      '<path d="M' + (o - 2.4) + ' 2.6 Q' + o + ' 1.6 ' + (o + 2.4) + ' 2.6 Q' + (o + 2) + ' 5 ' + o + ' 5.2 Q' + (o - 2) + ' 5 ' + (o - 2.4) + ' 2.6 Z" fill="' + INK + '" stroke-width="1.2"/>' +
      (z ? '<path d="M' + (o - 3) + ' 7 Q' + o + ' 8.6 ' + (o + 3) + ' 7" stroke-width="1.8"/></g>' : '<g class="dog-jaw"><path d="M' + (o - 4.5) + ' 6.4 Q' + o + ' 10.6 ' + (o + 4.5) + ' 6.4" stroke-width="2"/><path d="M' + (o - 1.6) + ' 8.4 Q' + o + ' 11.6 ' + (o + 1.6) + ' 8.4" fill="' + WH + '" stroke-width="1.6"/></g></g>');
    const legEl = (cls, far) => '<g class="' + cls + '"><path class="lo" stroke-width="9.6"/><path class="li" stroke="' + (far ? SH : WH) + '" stroke-width="5.2"/></g>';
    const run = '<g class="dog-run"><g class="dog-tail" style="transform-origin:100% 100%"><path d="M35 39 Q27 37 26 27 Q25.6 22.5 28.4 23.6 Q30.5 31 37.5 34 Z" fill="' + WH + '"/></g>' +
      legEl('lg lg1', 1) + legEl('lg lg2', 1) + legEl('lg lg0') + legEl('lg lg3') +
      '<g class="dog-body"><path d="M33 39 Q33 31 42 31 L58 31 Q67 31 67 40 Q67 51 58 51 L41 51 Q33 51 33 44 Z" fill="' + WH + '"/></g>' +
      '<g class="dog-body"><g class="dog-hd" transform="translate(72 22)">' + headSvg(4) + '</g></g></g>';
    const sit = '<g class="dog-sit"><g class="dog-tail" style="transform-origin:0% 100%"><path d="M60 52 Q68 50 70 40 Q71 36 68 37 Q66 45 59 47 Z" fill="' + WH + '"/></g>' +
      '<path d="M37 61 Q34 55 36.5 51 Q39 47 43 50 L43 61 Z" fill="' + WH + '"/><path d="M63 61 Q66 55 63.5 51 Q61 47 57 50 L57 61 Z" fill="' + WH + '"/>' +
      '<path d="M40 61 Q38 44 42 36 L58 36 Q62 44 60 61 Z" fill="' + WH + '"/>' +
      '<path d="M46 46 L46 60.5 M54 46 L54 60.5" stroke-width="2.2"/><path d="M42.5 61 L57.5 61"/>' +
      '<g transform="translate(50 20)">' + headSvg(0) + '</g></g>';
    const sleep = '<g class="dog-sleep"><path d="M31 59 Q20 61 17.5 55.5 Q16.5 52 19.5 53 Q23 57.5 31 54.5 Z" fill="' + WH + '"/>' +
      '<g class="dog-breath"><path d="M31 61 Q26 61 27 53 Q29 45 42 45 L58 45 Q67 45 67 53 L67 61 Z" fill="' + WH + '"/><path d="M38 61 Q36 55 41 53 Q46 52 47 61" stroke-width="2.2" fill="' + WH + '"/></g>' +
      '<g transform="translate(73 44) scale(.88) rotate(-6)">' + headSvg(4, 1) + '</g>' +
      '<path d="M70 61 Q70 56.5 75 56.5 L80 56.5 Q84 56.5 84 61 Z M80 61 Q80 57 85 57 L89 57 Q93 57 93 61 Z" fill="' + WH + '"/></g>';
    const svg = '<svg viewBox="0 0 100 66" fill="none" stroke="' + INK + '" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' + run + sit + sleep + '</svg>';
    const el = document.createElement('div');
    el.className = 'dog sit'; el.setAttribute('aria-hidden', 'true');
    el.innerHTML = '<div class="dog-zzz"><span>z</span><span>z</span><span>Z</span></div><div class="dog-bubble">Woof!</div><div class="dog-flip" style="transition:none;transform-origin:50% 92%">' + svg + '</div>';
    document.body.appendChild(el);
    const flip = el.querySelector('.dog-flip'), bubble = el.querySelector('.dog-bubble'), runG = el.querySelector('.dog-run'), hd = el.querySelector('.dog-hd');
    const zzz = el.querySelector('.dog-zzz'), breath = el.querySelector('.dog-breath'), sitHead = el.querySelector('.dog-sit .dog-head'), ears = el.querySelectorAll('.dog-ear');
    const bodies = el.querySelectorAll('.dog-body'), lg = [0, 1, 2, 3].map(i => el.querySelectorAll('.lg' + i + ' path'));
    const LEGS = [{ x: 38, y: 46, hind: 1 }, { x: 42, y: 45, hind: 1 }, { x: 58, y: 46, hind: 0 }, { x: 62, y: 46, hind: 0 }];
    const TROT = [0, 0.5, 0, 0.5], GALLOP = [0.1, 0, 0.5, 0.6];
    const W = 110, H = 73, DEG = 57.2958;
    const lerp = (a, b, k) => a + (b - a) * k, clamp = (x, a, b) => Math.max(a, Math.min(b, x));
    const wrap = a => { while (a > Math.PI) a -= 2 * Math.PI; while (a < -Math.PI) a += 2 * Math.PI; return a; };
    const home = () => {
      const sec = document.querySelector('[data-screen-label="Hero"]'), row = sec && sec.firstElementChild;
      if (!sec || !row) return { x: window.innerWidth - 80, y: 160 };
      const s = sec.getBoundingClientRect(), r = row.getBoundingClientRect();
      return { x: s.right + window.scrollX - W / 2, y: r.bottom + window.scrollY };
    };
    let p = home(), cx = null, cy = null, th = Math.PI, v = 0, phase = 0, mode = 'home', sitAt = 0, last = 0;
    let out = false, face = -1, faceS = -1, pitch = 0, fs = 1, mspd = 0, lastMove = 0, lmx = 0, lmy = 0, lmt = 0, alertAt = 0, look = 0, perk = 0;
    const FAST = 1.1, STILL_MS = 260;
    const onMove = e => {
      const now = performance.now();
      if (lmt) { const inst = Math.hypot(e.clientX - lmx, e.clientY - lmy) / Math.max(now - lmt, 8); mspd = mspd * 0.55 + inst * 0.45; }
      lmx = e.clientX; lmy = e.clientY; lmt = now; lastMove = now;
      cx = e.clientX; cy = e.clientY; out = false; if (mode === 'home' || mode === 'idle') mode = 'run';
    };
    const onOut = e => { if (!e.relatedTarget) { out = true; mspd = 0; } };
    const onResize = () => { if (mode === 'home') p = home(); };
    window.addEventListener('mousemove', onMove); window.addEventListener('resize', onResize); document.addEventListener('mouseout', onOut);
    const legPath = (L, a, k) => {
      const sw = Math.sin(a) * (0.2 + 0.42 * k), lift = Math.max(0, Math.cos(a)) * k;
      const u = 7.5, l = 8;
      const ua = L.hind ? sw + 0.3 + lift * 0.25 : sw - lift * 0.15;
      const la = L.hind ? sw - 0.35 - lift * 0.55 : sw - lift * 1.25;
      const kx = L.x + Math.sin(ua) * u, ky = L.y + Math.cos(ua) * u;
      const px = kx + Math.sin(la) * l, py = Math.min(61, ky + Math.cos(la) * l);
      return 'M' + L.x + ' ' + L.y + ' L' + kx.toFixed(2) + ' ' + ky.toFixed(2) + ' L' + px.toFixed(2) + ' ' + py.toFixed(2) + ' L' + (px + 1.6).toFixed(2) + ' ' + (py - lift).toFixed(2);
    };
    const tick = t => {
      const f = last ? clamp((t - last) / 16.67, 0, 3) : 1; last = t;
      const now = performance.now(), still = now - lastMove > STILL_MS;
      if (still) mspd *= Math.pow(0.8, f);
      let lookT = 0;
      if (out && mode !== 'home') { mode = 'idle'; v = 0; }
      if (mode !== 'home' && mode !== 'idle' && cx !== null) {
        const mx = cx + window.scrollX, my = cy + window.scrollY;
        const side = mx >= p.x ? 1 : -1;
        if (mspd > FAST && !still && mode !== 'alert') { mode = 'alert'; alertAt = t; }
        const maxX = document.documentElement.scrollWidth - W / 2;
        const tx = clamp(mx - side * 58, W / 2, maxX), ty = my + 34;
        const dx = tx - p.x, dy = ty - p.y, d = Math.hypot(dx, dy);
        if (mode === 'alert') {
          v *= Math.pow(0.82, f);
          p.x += Math.cos(th) * v * f; p.y += Math.sin(th) * v * f;
          face = side;
          lookT = clamp(Math.atan2(my - (p.y - 50), Math.abs(mx - p.x)), -0.55, 0.45);
          if (still && t - alertAt > 300) { mode = d > 48 ? 'run' : 'sit'; th = Math.atan2(dy, dx); sitAt = t; }
        } else {
          if (mode === 'sit' && d > 48) { mode = 'run'; th = Math.atan2(dy, dx); }
          if (mode === 'run') {
            const delta = wrap(Math.atan2(dy, dx) - th);
            const rate = (d < 40 ? 0.3 : 0.11) * f;
            th = wrap(th + clamp(delta, -rate, rate));
            const want = clamp(d * 0.05, 0.6, 4.2) * Math.max(0.25, Math.cos(delta));
            v += (want - v) * 0.08 * f;
            if (d < 7) { mode = 'sit'; sitAt = t; v = 0; face = side; }
            else {
              p.x += Math.cos(th) * v * f; p.y += Math.sin(th) * v * f;
              if (Math.abs(Math.cos(th)) > 0.2) face = Math.cos(th) > 0 ? 1 : -1;
            }
          } else { face = side; lookT = clamp(Math.atan2(my - (p.y - 50), Math.abs(mx - p.x)), -0.4, 0.3) * 0.6; }
        }
      }
      const alert = mode === 'alert', moving = mode === 'run' || (alert && v > 0.3), standing = mode === 'run' || alert;
      const k = moving ? clamp(v / 3, 0.35, 1) : 0;
      look += (lookT - look) * 0.18 * f;
      perk += ((alert ? 1 : 0) - perk) * 0.2 * f;
      faceS += (face - faceS) * (alert ? 0.3 : 0.2) * f;
      const tp = moving ? clamp(Math.atan2(Math.sin(th), Math.abs(Math.cos(th))), -0.62, 0.62) : 0;
      pitch += (tp - pitch) * 0.12 * f;
      fs += ((moving ? 1 - 0.32 * Math.abs(Math.sin(th)) : 1) - fs) * 0.12 * f;
      el.classList.toggle('sit', !standing); el.classList.toggle('run', standing);
      const sleeping = (mode === 'sit' || mode === 'idle' || mode === 'home') && now - lastMove > 5000;
      el.classList.toggle('sleep', sleeping);
      el.classList.toggle('bark', !sleeping && mode === 'sit' && t - sitAt > 250 && t - sitAt < 2750);
      if (sleeping) { breath.setAttribute('transform', 'translate(0 61) scale(1 ' + (1 + Math.sin(t * 0.0025) * 0.035).toFixed(3) + ') translate(0 -61)'); zzz.style.left = faceS < 0 ? '4%' : '74%'; }
      ears.forEach(e => e.setAttribute('transform', 'rotate(' + (-e.dataset.s * perk * (16 + Math.sin(t * 0.03) * 5)).toFixed(2) + ' ' + e.dataset.ox + ' ' + e.dataset.oy + ')'));
      if (standing) {
        if (moving) phase += (v * f) / 30;
        const gk = moving ? clamp((v - 2.4) / 1.4, 0, 1) : 0, cyc = 2 * Math.PI * phase;
        lg.forEach((els, i) => { const d = legPath(LEGS[i], moving ? 2 * Math.PI * (phase + lerp(TROT[i], GALLOP[i], gk)) : 0, k); els.forEach(e => e.setAttribute('d', d)); });
        const hop = alert ? -Math.max(0, Math.sin(clamp((t - alertAt) / 260, 0, 1) * Math.PI)) * 5 : 0;
        const bob = (moving ? -Math.abs(Math.sin(cyc * (gk > 0.5 ? 1 : 2))) * (1 + gk * 2.2) * k : 0) + hop;
        const rock = moving ? Math.sin(cyc) * gk * 4 : 0;
        runG.setAttribute('transform', 'translate(0 ' + bob.toFixed(2) + ')');
        bodies.forEach(b => b.setAttribute('transform', 'rotate(' + rock.toFixed(2) + ' 50 34)'));
        const nod = moving ? Math.sin(cyc * 2 + 1) * 1.2 * k : 0;
        hd.setAttribute('transform', 'translate(72 ' + (22 + nod).toFixed(2) + ') rotate(' + (-rock * 0.6 - pitch * 12 + look * DEG * 0.7).toFixed(2) + ')');
      } else sitHead.parentNode.setAttribute('transform', 'translate(50 20) rotate(' + (look * DEG * 0.7).toFixed(2) + ')');
      const sx = faceS * fs, dir = faceS >= 0 ? 1 : -1;
      flip.style.transform = 'rotate(' + (pitch * dir * DEG).toFixed(2) + 'deg) scaleX(' + sx.toFixed(3) + ')';
      bubble.style.left = faceS < 0 ? '25%' : '75%';
      el.style.transform = 'translate(' + (p.x - W / 2) + 'px,' + (p.y - H) + 'px)';
      raf = requestAnimationFrame(tick);
    };
    raf = requestAnimationFrame(tick);
  }

  setupRotator();
  requestAnimationFrame(setupReveal);
  setupCursor();
  if (isHome) setTimeout(setupDog, 400);
})();
