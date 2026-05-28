// navigation logic and partial loading
document.addEventListener("DOMContentLoaded", () => {
  
  // fetch partials
  const loadPartial = async (url, containerId, callback) => {
    try {
      const response = await fetch(url);
      if (!response.ok) throw new Error(`Could not load ${url}`);
      const text = await response.text();
      document.getElementById(containerId).innerHTML = text;
      if (callback) callback();
    } catch (error) {
      console.error(error);
    }
  };

  const initNavigation = () => {
    // header scroll state
    const header = document.getElementById('header');
    if (header) {
      window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
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

  // load header and footer, then initialize nav (cache busted)
  const cacheBuster = '?v=' + new Date().getTime();
  loadPartial('partials/header.html' + cacheBuster, 'site-header-container', initNavigation);
  loadPartial('partials/footer.html' + cacheBuster, 'site-footer-container');

});
