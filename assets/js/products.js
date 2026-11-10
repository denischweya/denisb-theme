/* Theme and plugin filter on the products page. */
(function () {
  'use strict';
  var b = document.querySelectorAll('.filters button'), it = document.querySelectorAll('.products li'), c = document.getElementById('count');
  if (!b.length || !c) return;
  var label = { all: 'products', theme: 'themes', plugin: 'plugins' };
  function f(t, p) {
    var n = 0;
    it.forEach(function (l) { var s = t === 'all' || l.dataset.type === t; l.hidden = !s; if (s) n++; });
    b.forEach(function (x) { x.setAttribute('aria-pressed', x.dataset.f === t ? 'true' : 'false'); });
    c.textContent = 'Showing ' + n + ' ' + label[t];
    if (p) history.replaceState(null, '', t === 'all' ? location.pathname : '#' + t + 's');
  }
  b.forEach(function (x) { x.addEventListener('click', function () { f(x.dataset.f, true); }); });
  var h = location.hash;
  if (h === '#themes') f('theme'); else if (h === '#plugins') f('plugin');
})();
