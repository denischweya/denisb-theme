/*
 * Rotating headline words. In the editor, select a word in a heading and use
 * "Rotating words" to list the words; this builds the animated version.
 */
(function () {
  'use strict';
  document.querySelectorAll('span.rot[data-words]').forEach(function (src) {
    var words = src.getAttribute('data-words').split(',').map(function (w) { return w.trim(); }).filter(Boolean);
    var first = src.textContent.trim();
    if (first && words.indexOf(first) !== 0) { words = [first].concat(words.filter(function (w) { return w !== first; })); }
    if (!words.length) return;

    var outer = document.createElement('span');
    outer.style.cssText = 'display:inline-block;color:var(--accent);min-width:4.6em;position:relative';
    var rot = document.createElement('span');
    rot.className = 'rot is-ready';
    rot.style.cssText = 'display:inline-grid;overflow:clip;overflow-clip-margin:.08em;vertical-align:bottom;padding-bottom:.04em';
    var sr = document.createElement('span');
    sr.style.cssText = 'position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0 0 0 0)';
    sr.textContent = words.join(', ');
    rot.appendChild(sr);

    function word(text, anim, base, out) {
      var s = document.createElement('span');
      s.className = out ? 'rot-word rot-out' : 'rot-word';
      s.setAttribute('aria-hidden', 'true');
      s.style.cssText = 'grid-area:1/1;display:inline-flex;white-space:nowrap';
      Array.from(text).forEach(function (c, i) {
        var ch = document.createElement('span');
        ch.style.cssText = 'display:inline-block;animation:' + anim + ' .7s cubic-bezier(.65,0,.15,1) both;animation-delay:' + (base + i * 38) + 'ms';
        ch.textContent = c;
        s.appendChild(ch);
      });
      return s;
    }
    rot.appendChild(word(words[0], 'chIn', 0, false));
    outer.appendChild(rot);
    src.replaceWith(outer);

    if (words.length < 2) return;
    var w = 0;
    setInterval(function () {
      var prev = w;
      w = (w + 1) % words.length;
      while (rot.lastChild !== sr) rot.removeChild(rot.lastChild);
      rot.appendChild(word(words[w], 'chIn', 160, false));
      rot.appendChild(word(words[prev], 'chOut', 0, true));
    }, 2800);
  });
})();
