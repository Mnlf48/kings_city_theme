(function() {
  'use strict';

  var cfg        = window.kcTeamBuilder || {};
  var roleCatalog    = cfg.roleCatalog    || [];
  var currencyRates  = cfg.currencyRates  || { PHP: 1 };
  var currentCurr    = cfg.defaultCurr    || 'PHP';
  var ajaxUrl        = cfg.ajaxUrl        || '';

  var selectedTeam = [];

  var modal        = document.getElementById('tb-modal');
  var btnAddMember = document.getElementById('btn-add-member');
  var btnGetStarted= document.getElementById('btn-get-started');
  var btnCloseModal= document.getElementById('tb-modal-close');
  var modalRoles   = document.getElementById('tb-modal-roles');
  var emptyState   = document.getElementById('tb-empty');
  var rolesList    = document.getElementById('tb-roles-list');
  var rolesInner   = document.getElementById('tb-roles-inner');
  var tbSummary    = document.getElementById('tb-summary');
  var tbTotalSize  = document.getElementById('tb-total-size');
  var tbTotalBase  = document.getElementById('tb-total-base');
  var tbFinalTotal = document.getElementById('tb-final-total');
  var tbSavingsBox = document.getElementById('tb-savings');
  var tbSaveAmount = document.getElementById('tb-save-amount');

  if (!modal) return;

  function formatCurrency(numPhp) {
    var rate = currencyRates[currentCurr] || 1;
    var converted = Math.round(numPhp * rate);
    return currentCurr + ' ' + converted.toLocaleString('en-US');
  }

  function renderCatalog() {
    var ht = '';
    roleCatalog.forEach(function(c) {
      ht += '<div class="tb-cat-title">' + c.cat + '</div>';
      c.roles.forEach(function(r) {
        ht += '<div class="tb-role-card">'
          + '<div style="color: var(--color-accent); margin-top: 4px;">'
          + '<svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>'
          + '</div>'
          + '<div class="tb-role-info"><strong>' + r.name + '</strong><span>' + r.desc + '</span></div>'
          + '<button type="button" class="btn-add-role" data-id="' + r.id + '">+ Add</button>'
          + '</div>';
      });
    });
    modalRoles.innerHTML = ht;

    modalRoles.querySelectorAll('.btn-add-role').forEach(function(btn) {
      btn.addEventListener('click', function(e) {
        addRoleToTeam(e.target.dataset.id);
        closeModal();
      });
    });
  }

  function getRoleData(id) {
    for (var i = 0; i < roleCatalog.length; i++) {
      var r = roleCatalog[i].roles.find(function(x) { return x.id === id; });
      if (r) return r;
    }
    return null;
  }

  function addRoleToTeam(id) {
    var d = getRoleData(id);
    if (!d) return;
    var ex = selectedTeam.find(function(t) { return t.id === id; });
    if (ex) {
      ex.count++;
    } else {
      selectedTeam.push({ id: id, name: d.name, base: d.base, level: 1, count: 1 });
    }
    renderTeam();
  }

  function removeRole(id) {
    selectedTeam = selectedTeam.filter(function(t) { return t.id !== id; });
    renderTeam();
  }

  function renderTeam() {
    if (selectedTeam.length === 0) {
      emptyState.style.display = 'flex';
      rolesList.style.display = 'none';
      tbSummary.style.display = 'none';
      updateTotals();
      return;
    }
    emptyState.style.display = 'none';
    rolesList.style.display = 'block';
    tbSummary.style.display = 'block';

    var ht = '';
    selectedTeam.forEach(function(t) {
      var price = t.base * t.level;
      ht += '<div class="tbr-item" data-id="' + t.id + '">'
        + '<div class="tbr-name">'
        + '<div style="color: var(--color-accent); margin-top: 4px;">'
        + '<svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>'
        + '</div>'
        + '<div style="display:flex; flex-direction:column;"><strong>' + t.name + '</strong>'
        + '<span style="font-size:0.75rem; color:var(--color-text-muted);">Dedicated Offshore Talent</span></div>'
        + '</div>'
        + '<div class="tbr-level">'
        + '<select class="level-sel">'
        + '<option value="1"' + (t.level == 1 ? ' selected' : '') + '>Junior</option>'
        + '<option value="1.3"' + (t.level == 1.3 ? ' selected' : '') + '>Mid-Level</option>'
        + '<option value="1.7"' + (t.level == 1.7 ? ' selected' : '') + '>Senior</option>'
        + '</select></div>'
        + '<div class="tbr-count"><div class="tbr-count-ctl">'
        + '<button type="button" class="count-minus">-</button>'
        + '<input type="text" value="' + t.count + '" readonly>'
        + '<button type="button" class="count-plus">+</button>'
        + '</div></div>'
        + '<div class="tbr-price">' + formatCurrency(price) + '<span style="color:var(--color-text-muted);font-weight:500;font-size:0.75rem;">/mo</span></div>'
        + '<div class="tbr-remove"><button type="button" class="btn-rem" title="Remove">&times;</button></div>'
        + '</div>';
    });
    rolesInner.innerHTML = ht;

    rolesInner.querySelectorAll('.tbr-item').forEach(function(item) {
      var id = item.dataset.id;
      var t = selectedTeam.find(function(x) { return x.id === id; });

      item.querySelector('.btn-rem').addEventListener('click', function() { removeRole(id); });
      item.querySelector('.level-sel').addEventListener('change', function(e) {
        t.level = parseFloat(e.target.value);
        renderTeam();
      });
      item.querySelector('.count-minus').addEventListener('click', function() {
        if (t.count > 1) { t.count--; renderTeam(); }
      });
      item.querySelector('.count-plus').addEventListener('click', function() {
        t.count++; renderTeam();
      });
    });

    updateTotals();
  }

  function updateTotals() {
    var size = 0, baseTotal = 0;
    selectedTeam.forEach(function(t) {
      size += t.count;
      baseTotal += (t.base * t.level) * t.count;
    });
    tbTotalSize.textContent = size;
    tbTotalBase.textContent = formatCurrency(baseTotal);
    tbFinalTotal.textContent = formatCurrency(baseTotal);
    if (size > 0) {
      var savings = (baseTotal * 2.5) - baseTotal;
      tbSaveAmount.textContent = '~ ' + formatCurrency(savings);
      tbSavingsBox.style.display = 'flex';
    } else {
      tbSavingsBox.style.display = 'none';
    }
  }

  function openModal()  { modal.setAttribute('aria-hidden', 'false'); document.body.classList.add('modal-open'); }
  function closeModal() { modal.setAttribute('aria-hidden', 'true');  document.body.classList.remove('modal-open'); }

  if (btnAddMember)  btnAddMember.addEventListener('click', openModal);
  if (btnGetStarted) btnGetStarted.addEventListener('click', openModal);
  if (btnCloseModal) btnCloseModal.addEventListener('click', closeModal);
  modal.addEventListener('click', function(e) { if (e.target === modal) closeModal(); });

  document.querySelectorAll('.curr-btn').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
      document.querySelectorAll('.curr-btn').forEach(function(b) {
        b.classList.remove('is-active');
        b.style.background = 'transparent';
        b.style.color = 'var(--color-primary)';
      });
      e.target.classList.add('is-active');
      e.target.style.background = 'var(--color-secondary)';
      e.target.style.color = 'var(--color-primary)';
      currentCurr = e.target.dataset.curr;
      renderTeam();
    });
  });

  renderCatalog();

  var quoteForm = document.getElementById('quote-form');
  if (quoteForm) {
    quoteForm.addEventListener('submit', function(e) {
      e.preventDefault();
      if (!quoteForm.reportValidity()) return;
      if (selectedTeam.length === 0) {
        alert('Please add at least one role to your team before requesting a quote.');
        return;
      }

      var teamListForSubmit = selectedTeam.map(function(t) {
        var levelLabel = t.level == 1.3 ? 'Mid' : t.level == 1.7 ? 'Senior' : 'Junior';
        return { title: t.name, level: levelLabel, headcount: t.count, monthly: formatCurrency((t.base * t.level) * t.count) };
      });

      document.getElementById('team_json').value = JSON.stringify(teamListForSubmit);
      document.getElementById('currency_used').value = currentCurr;
      document.getElementById('total_est').value = document.getElementById('tb-final-total').innerText;

      var submitBtn = quoteForm.querySelector('button[type="submit"]');
      var originalText = submitBtn.innerText;
      submitBtn.innerText = 'Submitting...';
      submitBtn.disabled = true;

      var formData = new FormData(quoteForm);
      formData.append('action', 'submit_quote');

      fetch(ajaxUrl, { method: 'POST', body: formData })
        .then(function(res) { return res.json(); })
        .then(function(res) {
          submitBtn.innerText = originalText;
          submitBtn.disabled = false;
          var popup   = document.getElementById('kc-quote-popup');
          var title   = document.getElementById('kc-quote-popup-title');
          var message = document.getElementById('kc-quote-popup-message');
          var icon    = document.getElementById('kc-quote-popup-icon');
          if (res.success) {
            title.innerText = 'Quote Request Received!';
            title.style.color = '#10b981';
            icon.className = 'fa-solid fa-check-circle';
            icon.style.color = '#10b981';
            message.innerText = res.data.message || 'Our team will review your requirements.';
            popup.dataset.success = 'true';
          } else {
            title.innerText = 'Notice';
            title.style.color = 'var(--color-primary)';
            icon.className = 'fa-solid fa-circle-exclamation';
            icon.style.color = 'var(--color-accent-red)';
            message.innerText = res.data.message || 'An error occurred.';
            popup.dataset.success = 'false';
          }
          popup.style.display = 'flex';
        })
        .catch(function() {
          submitBtn.innerText = originalText;
          submitBtn.disabled = false;
          alert('An error occurred. Please try again.');
        });
    });
  }

  var quotePopupCloseBtn = document.getElementById('kc-quote-popup-close-btn');
  if (quotePopupCloseBtn) {
    quotePopupCloseBtn.addEventListener('click', function() {
      var popup = document.getElementById('kc-quote-popup');
      popup.style.display = 'none';
      if (popup.dataset.success === 'true') {
        var qf = document.getElementById('quote-form');
        if (qf) qf.reset();
        selectedTeam = [];
        renderTeam();
        var pricingSection = document.getElementById('pricing-section');
        if (pricingSection) pricingSection.scrollIntoView({ behavior: 'smooth' });
        popup.dataset.success = 'false';
      }
    });
  }

})();
