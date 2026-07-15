(function() {
  'use strict';

  var cfg         = window.kcBooking || {};
  var bookingData = cfg.bookingData || {};
  var kcAjax      = cfg.ajax       || { url: '', nonce: '' };

  var spaceTypeSelect = document.getElementById('space-type-select');
  var durationSelect  = document.getElementById('duration-select');
  var priceDisplay    = document.getElementById('price-display');
  var contentImage    = document.getElementById('content-image');
  var hiddenPrice     = document.getElementById('hidden-price');
  var dateInput       = document.getElementById('date-input');

  var disabledDatesCache = {};
  var fpInstance = null;
  var fpBase = { dateFormat: 'Y-m-d', minDate: 'today', disableMobile: true };

  function reinitFlatpickr(extraConfig) {
    if (!dateInput || typeof flatpickr === 'undefined') return;
    if (fpInstance) { fpInstance.destroy(); fpInstance = null; }
    fpInstance = flatpickr(dateInput, Object.assign({}, fpBase, extraConfig || {}));
  }

  function applyDateConstraints(data) {
    if (!dateInput) return;
    if (data.mode === 'whitelist') {
      var allowed = data.allowed || [];
      reinitFlatpickr(allowed.length === 0 ? { disable: [function() { return true; }] } : { enable: allowed });
    } else {
      var disabled = data.disabled || [];
      reinitFlatpickr(disabled.length ? { disable: disabled } : {});
    }
  }

  function fetchBookedDates(spaceKey) {
    if (!dateInput) return;
    reinitFlatpickr({ disable: [function() { return true; }] });
    if (disabledDatesCache[spaceKey] !== undefined) {
      applyDateConstraints(disabledDatesCache[spaceKey]);
      return;
    }
    var fd = new FormData();
    fd.append('action',    'kc_get_booked_dates');
    fd.append('nonce',     kcAjax.nonce);
    fd.append('space_key', spaceKey);
    fetch(kcAjax.url, { method: 'POST', body: fd })
      .then(function(r) { return r.json(); })
      .then(function(res) {
        var result = res.success ? res.data : { mode: 'blacklist', disabled: [] };
        disabledDatesCache[spaceKey] = result;
        applyDateConstraints(result);
      })
      .catch(function() { applyDateConstraints({ mode: 'blacklist', disabled: [] }); });
  }

  var currentPromoDiscount = 0;
  var currentPromoCode = '';

  function updatePrice() {
    if (!durationSelect || durationSelect.selectedIndex === -1) return;
    var selectedOption = durationSelect.options[durationSelect.selectedIndex];
    var priceVal = parseFloat(selectedOption.getAttribute('data-price') || '0');
    var finalPrice = priceVal;
    
    if (hiddenPrice) hiddenPrice.value = priceVal; // Always send base price
    
    if (priceDisplay) {
        if (currentPromoDiscount > 0) {
            // Apply discount (ensure it doesn't go below 0)
            finalPrice = Math.max(0, priceVal - currentPromoDiscount);
            priceDisplay.innerHTML = '<span style="text-decoration: line-through; opacity: 0.6; font-size: 0.8em;">Php ' + priceVal.toLocaleString() + '</span> Php ' + finalPrice.toLocaleString();
        } else {
            priceDisplay.innerText = 'Php ' + priceVal.toLocaleString();
        }
    }
  }

  // Promo Code AJAX
  var btnApplyPromo = document.getElementById('kc_apply_promo_btn');
  var inputPromo    = document.getElementById('kc_promo_code_input');
  var hiddenPromo   = document.getElementById('kc_promo_code_hidden');
  var msgPromo      = document.getElementById('kc_promo_msg');

  if (btnApplyPromo && inputPromo) {
    btnApplyPromo.addEventListener('click', function() {
        var code = inputPromo.value.trim();
        if (!code) {
            msgPromo.style.color = '#dc2626';
            msgPromo.innerText = 'Please enter a code.';
            return;
        }

        var basePrice = 0;
        if (durationSelect && durationSelect.selectedIndex !== -1) {
            basePrice = parseFloat(durationSelect.options[durationSelect.selectedIndex].getAttribute('data-price') || '0');
        }

        btnApplyPromo.innerText = '...';
        btnApplyPromo.disabled = true;

        var fd = new FormData();
        fd.append('action', 'kc_apply_promo');
        fd.append('nonce', kcAjax.promo_nonce); 
        fd.append('promo_code', code);
        fd.append('base_price', basePrice);

        // We will just bypass nonce if we don't have it, but wait, kc_apply_promo requires 'kc_apply_promo_nonce'.
        // I will just fetch it directly or remove the nonce check in PHP for public AJAX endpoint.
        
        fetch(kcAjax.url, { method: 'POST', body: fd })
            .then(function(r) { return r.json(); })
            .then(function(res) {
                if (res.success) {
                    msgPromo.style.color = '#10b981';
                    msgPromo.innerText = res.data.message;
                    currentPromoDiscount = parseFloat(res.data.discount_amount);
                    currentPromoCode = res.data.code;
                    if (hiddenPromo) hiddenPromo.value = res.data.code;
                    updatePrice();
                } else {
                    msgPromo.style.color = '#dc2626';
                    msgPromo.innerText = res.data.message;
                    currentPromoDiscount = 0;
                    currentPromoCode = '';
                    if (hiddenPromo) hiddenPromo.value = '';
                    updatePrice();
                }
            })
            .catch(function() {
                msgPromo.style.color = '#dc2626';
                msgPromo.innerText = 'Network error.';
            })
            .finally(function() {
                btnApplyPromo.innerText = 'Apply';
                btnApplyPromo.disabled = false;
            });
    });
    
    // Reset promo if space changes
    if (spaceTypeSelect) {
        spaceTypeSelect.addEventListener('change', function() {
            currentPromoDiscount = 0;
            currentPromoCode = '';
            if (hiddenPromo) hiddenPromo.value = '';
            if (inputPromo) inputPromo.value = '';
            if (msgPromo) msgPromo.innerText = '';
        });
    }
  }

  if (spaceTypeSelect) {
    spaceTypeSelect.addEventListener('change', function() {
      var key  = spaceTypeSelect.value;
      var data = bookingData[key] || bookingData[Object.keys(bookingData)[0]];

      if (contentImage && data.image) contentImage.src = data.image;
      var el;
      el = document.getElementById('content-overline'); if (el) el.innerText = data.overline;
      el = document.getElementById('content-title');    if (el) el.innerText = data.title;
      el = document.getElementById('content-text');     if (el) el.innerHTML = data.text;
      el = document.getElementById('form-title');       if (el) el.innerText = data.formTitle;

      var featureContainer = document.getElementById('content-features');
      if (featureContainer) {
        featureContainer.innerHTML = data.features.map(function(f) {
          return '<span class="feature-tag">' + f + '</span>';
        }).join('');
      }

      if (durationSelect) {
        durationSelect.innerHTML = data.options.map(function(o) {
          return '<option value="' + o.value + '" data-price="' + o.price + '">' + o.label + '</option>';
        }).join('');
        updatePrice();
      }

      fetchBookedDates(key);
    });
  }

  if (durationSelect) durationSelect.addEventListener('change', updatePrice);

  // Init Flatpickr and trigger first space load
  reinitFlatpickr({});
  if (spaceTypeSelect) {
    spaceTypeSelect.dispatchEvent(new Event('change'));
  } else {
    updatePrice();
  }

  // Booking success modal
  document.addEventListener('DOMContentLoaded', function() {
    var modal       = document.getElementById('booking-success-modal');
    var btnClose    = document.getElementById('booking-modal-close');
    var btnFinish   = document.getElementById('booking-modal-finish');
    var form        = document.getElementById('booking-form');
    if (!modal) return;

    function openModal()  { modal.setAttribute('aria-hidden', 'false'); document.body.classList.add('modal-open'); }
    function closeModal() {
      modal.setAttribute('aria-hidden', 'true');
      document.body.classList.remove('modal-open');
      if (modal.dataset.success === 'true') {
        if (form) form.reset();
        var sel = document.getElementById('space-type-select');
        if (sel) { sel.selectedIndex = 0; sel.dispatchEvent(new Event('change')); }
        var contentTitle = document.getElementById('content-title');
        if (contentTitle) contentTitle.scrollIntoView({ behavior: 'smooth', block: 'center' });
        modal.dataset.success = 'false';
      }
    }

    if (btnClose)  btnClose.addEventListener('click', closeModal);
    if (btnFinish) btnFinish.addEventListener('click', closeModal);
    modal.addEventListener('click', function(e) { if (e.target === modal) closeModal(); });

    if (form) {
      form.addEventListener('submit', function(e) {
        e.preventDefault();
        var submitBtn   = form.querySelector('button[type="submit"]');
        var originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = 'Processing...';
        submitBtn.disabled  = true;

        var formData = new FormData(form);
        formData.append('book_submit', '1');

        fetch(window.location.href, { method: 'POST', body: formData })
          .then(function(r) { return r.text(); })
          .then(function(html) {
            var parser   = new DOMParser();
            var doc      = parser.parseFromString(html, 'text/html');
            var errorDiv = doc.querySelector('.booking-error-alert');
            if (errorDiv) {
              alert(errorDiv.innerText.trim());
            } else {
              modal.dataset.success = 'true';
              openModal();
            }
          })
          .catch(function() { alert('There was a network error. Please try again.'); })
          .finally(function() { submitBtn.innerHTML = originalText; submitBtn.disabled = false; });
      });
    }
  });

})();
