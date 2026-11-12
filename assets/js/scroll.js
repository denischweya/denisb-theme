/*
 * Scrolling screenshots: tall images in the "Scrolling screenshot" image
 * styles scroll to the bottom on hover (see variations.css). The duration
 * grows with the image's height so the speed stays the same.
 */
(function () {
  'use strict';
  document.querySelectorAll('.is-style-db-scroll img, .is-style-db-scroll-card img').forEach(function (img) {
    function set() {
      var ratio = img.naturalHeight / img.naturalWidth;
      if (!ratio || ratio < 1.5) return;
      var figure = img.closest('.wp-block-image');
      figure.classList.add('is-scrollable');
      figure.style.setProperty('--project-scroll-duration', Math.round(ratio * 2.05) + 's');
    }
    if (img.complete) set(); else img.addEventListener('load', set);
  });
})();
