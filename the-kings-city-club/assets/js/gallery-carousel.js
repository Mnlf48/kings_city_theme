(function() {
  'use strict';
  var gallery = document.getElementById('gallery-carousel');
  if (!gallery) return;

  var autoScrollInterval;

  function getScrollAmount() {
    var card = gallery.querySelector('.gallery-card');
    return card ? card.clientWidth + parseInt(getComputedStyle(gallery).gap || 0) : 320;
  }

  function scrollGallery(direction) {
    var scrollAmount = getScrollAmount();
    var halfWidth = gallery.scrollWidth / 2;

    if (direction > 0) {
      if (gallery.scrollLeft + gallery.clientWidth >= gallery.scrollWidth - 4) {
        gallery.style.scrollBehavior = 'auto';
        gallery.scrollLeft = 0;
        void gallery.offsetWidth;
        gallery.style.scrollBehavior = 'smooth';
        gallery.scrollBy({ left: scrollAmount });
      } else if (gallery.scrollLeft >= halfWidth) {
        gallery.style.scrollBehavior = 'auto';
        gallery.scrollLeft -= halfWidth;
        void gallery.offsetWidth;
        gallery.style.scrollBehavior = 'smooth';
        gallery.scrollBy({ left: scrollAmount });
      } else {
        gallery.style.scrollBehavior = 'smooth';
        gallery.scrollBy({ left: scrollAmount });
      }
    } else {
      if (gallery.scrollLeft <= 4) {
        gallery.style.scrollBehavior = 'auto';
        gallery.scrollLeft = halfWidth - scrollAmount;
        void gallery.offsetWidth;
        gallery.style.scrollBehavior = 'smooth';
        gallery.scrollBy({ left: -scrollAmount });
      } else {
        gallery.style.scrollBehavior = 'smooth';
        gallery.scrollBy({ left: scrollAmount * direction });
      }
    }
    resetAutoScroll();
  }

  function startAutoScroll() {
    autoScrollInterval = setInterval(function() {
      var scrollAmount = getScrollAmount();
      if (gallery.scrollLeft >= gallery.scrollWidth / 2) {
        gallery.style.scrollBehavior = 'auto';
        gallery.scrollLeft = 0;
        void gallery.offsetWidth;
        gallery.style.scrollBehavior = 'smooth';
        gallery.scrollBy({ left: scrollAmount });
      } else {
        gallery.style.scrollBehavior = 'smooth';
        gallery.scrollBy({ left: scrollAmount });
      }
    }, 3500);
  }

  function resetAutoScroll() {
    clearInterval(autoScrollInterval);
    startAutoScroll();
  }

  gallery.addEventListener('mouseenter', function() { clearInterval(autoScrollInterval); });
  gallery.addEventListener('mouseleave', startAutoScroll);
  gallery.addEventListener('touchstart', function() { clearInterval(autoScrollInterval); });
  gallery.addEventListener('touchend', startAutoScroll);

  startAutoScroll();

  // Expose scrollGallery globally for onclick="scrollGallery(1)" nav buttons
  window.scrollGallery = scrollGallery;
})();
