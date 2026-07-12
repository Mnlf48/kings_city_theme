// navigation logic
(() => {

  const initNavigation = () => {
    // header scroll state
    const header = document.getElementById('header');
    if (header) {
      window.addEventListener('scroll', () => {
        if (window.scrollY > 10) {
          header.classList.add('is-scrolled');
        } else {
          header.classList.remove('is-scrolled');
        }
      });
    }

    // mobile drawer toggle
    const mobileToggle = document.querySelector('.nav-mobile-toggle');
    const navDrawer = document.getElementById('nav-drawer');
    const overlay = document.querySelector('.nav-drawer__overlay');
    const drawerCloseBtn = document.querySelector('.nav-drawer__close');

    if (mobileToggle && navDrawer && overlay) {
      const toggleMenu = () => {
        const isExpanded = mobileToggle.getAttribute('aria-expanded') === 'true';
        mobileToggle.setAttribute('aria-expanded', !isExpanded);
        mobileToggle.classList.toggle('is-active');
        navDrawer.classList.toggle('is-open');
        overlay.classList.toggle('is-visible');
        document.body.style.overflow = isExpanded ? '' : 'hidden';
        navDrawer.setAttribute('aria-hidden', isExpanded);
      };

      mobileToggle.addEventListener('click', toggleMenu);
      overlay.addEventListener('click', toggleMenu);
      if (drawerCloseBtn) {
        drawerCloseBtn.addEventListener('click', toggleMenu);
      }
    }

    // mega menu toggle (desktop)
    const megaMenuParent = document.querySelector('.has-mega-menu');
    const megaMenuLink = megaMenuParent?.querySelector('.nav-desktop__link');
    
    if (megaMenuLink) {
      megaMenuLink.addEventListener('click', (e) => {
        e.preventDefault();
        megaMenuParent.classList.toggle('is-active');
      });

      // close mega menu when clicking outside
      document.addEventListener('click', (e) => {
        if (!megaMenuParent.contains(e.target)) {
          megaMenuParent.classList.remove('is-active');
        }
      });
    }

    // mobile submenu toggle
    const submenuToggle = document.querySelector('.submenu-toggle');
    const submenu = document.querySelector('.nav-drawer__submenu');
    
    if (submenuToggle && submenu) {
      submenuToggle.addEventListener('click', () => {
        submenuToggle.classList.toggle('is-active');
        submenu.classList.toggle('is-active');
      });
    }
  };

  // initialize nav
  if (document.readyState === 'loading') {
    document.addEventListener("DOMContentLoaded", initNavigation);
  } else {
    initNavigation();
  }
})();

// ── Scroll-to-top page transition ──
(function () {
  var origin = window.location.origin;

  // Walk up the DOM from the clicked element.
  // Returns an internal URL string if found, otherwise null.
  function findNavHref(el) {
    var node = el;
    while (node && node !== document) {
      // <a> tag — check if internal
      if (node.tagName === 'A') {
        var href = node.getAttribute('href');
        if (!href || href.startsWith('#') || /^(mailto:|tel:|javascript:)/i.test(href) || node.target === '_blank') return null;
        try {
          var u = new URL(href, origin);
          return u.origin === origin ? u.href : null;
        } catch (e) { return null; }
      }
      // any element with onclick="window.location.href='...'"
      var oc = node.getAttribute && node.getAttribute('onclick');
      if (oc) {
        var m = oc.match(/window\.location\.href\s*=\s*['"]([^'"]+)['"]/);
        if (m) {
          try {
            var u2 = new URL(m[1], origin);
            return u2.origin === origin ? u2.href : null;
          } catch (e) {}
        }
      }
      node = node.parentElement;
    }
    return null;
  }

  function scrollToTopThenGo(href) {
    if (window.scrollY === 0) { window.location.href = href; return; }

    window.scrollTo({ top: 0, behavior: 'smooth' });

    var lastY    = window.scrollY;
    var stable   = 0;
    var deadline = Date.now() + 1500;

    function poll() {
      var currentY = window.scrollY;
      if (currentY === lastY) { stable++; } else { stable = 0; }
      lastY = currentY;
      if (stable >= 3 || Date.now() > deadline) {
        window.location.href = href;
      } else {
        requestAnimationFrame(poll);
      }
    }
    requestAnimationFrame(poll);
  }

  // Capture phase: fires before inline onclick handlers,
  // so we can stop the article's onclick from double-navigating.
  document.addEventListener('click', function (e) {
    if (e.ctrlKey || e.metaKey || e.shiftKey || e.altKey) return;
    var href = findNavHref(e.target);
    if (!href) return;
    e.preventDefault();
    e.stopPropagation();
    scrollToTopThenGo(href);
  }, true);
})();
