(function() {
  'use strict';
  var slider = document.getElementById('hero-slider');
  if (!slider) return;
  var slides = slider.querySelectorAll('.hero__slide');
  if (slides.length < 2) return;
  var current = 0;
  setInterval(function() {
    slides[current].style.opacity = '0';
    slides[current].classList.remove('is-active');
    current = (current + 1) % slides.length;
    slides[current].style.opacity = '1';
    slides[current].classList.add('is-active');
  }, 4000);
})();
