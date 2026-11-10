/* Light, dark and system colour themes, remembered per browser. */
(function () {
  'use strict';
  var root = document.documentElement;
  var buttons = document.querySelectorAll('[data-t]');
  function apply(t) {
    if (t === 'system') root.removeAttribute('data-theme'); else root.setAttribute('data-theme', t);
    try { localStorage.setItem('dbTheme', t); } catch (e) {}
    buttons.forEach(function (b) {
      var on = b.dataset.t === t;
      b.setAttribute('aria-pressed', on ? 'true' : 'false');
      if (b.parentElement.hasAttribute('data-tt')) {
        b.style.background = on ? 'var(--surface3)' : 'transparent';
        b.style.color = on ? 'var(--fg)' : 'var(--muted)';
      }
    });
  }
  var saved = 'system';
  try { saved = localStorage.getItem('dbTheme') || 'system'; } catch (e) {}
  apply(saved);
  buttons.forEach(function (b) { b.addEventListener('click', function () { apply(b.dataset.t); }); });
})();
