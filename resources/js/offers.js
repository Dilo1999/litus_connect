/**
 * Offers page — countdown, discount filter, category/brand filters
 */

function initOffersPage() {
  const page = document.querySelector('[data-offers-page]');
  if (!page) return;

  const state = {
    cat: 'all',
    brands: [],
    minDiscount: 0,
    maxDiscount: 60,
  };

  const drawer = document.querySelector('[data-offers-drawer]');

  function pad(n) {
    return String(n).padStart(2, '0');
  }

  function initCountdowns() {
    document.querySelectorAll('[data-offer-countdown]').forEach((el) => {
      const endsAt = Number(el.getAttribute('data-ends-at') || 0);

      function tick() {
        const diff = Math.max(0, endsAt - Date.now());
        const days = Math.floor(diff / 86400000);
        const hours = Math.floor((diff % 86400000) / 3600000);
        const mins = Math.floor((diff % 3600000) / 60000);
        const secs = Math.floor((diff % 60000) / 1000);
        el.querySelector('[data-countdown-days]') && (el.querySelector('[data-countdown-days]').textContent = pad(days));
        el.querySelector('[data-countdown-hours]') && (el.querySelector('[data-countdown-hours]').textContent = pad(hours));
        el.querySelector('[data-countdown-mins]') && (el.querySelector('[data-countdown-mins]').textContent = pad(mins));
        el.querySelector('[data-countdown-secs]') && (el.querySelector('[data-countdown-secs]').textContent = pad(secs));
      }

      tick();
      setInterval(tick, 1000);
    });
  }

  function updateDiscountUI() {
    const span = 60 || 1;
    const minPct = (state.minDiscount / span) * 100;
    const maxPct = (state.maxDiscount / span) * 100;

    document.querySelectorAll('[data-discount-dual-slider]').forEach((el) => {
      el.style.setProperty('--range-min', `${minPct}%`);
      el.style.setProperty('--range-max', `${maxPct}%`);
    });
    document.querySelectorAll('[data-discount-min-range]').forEach((el) => {
      el.value = state.minDiscount;
    });
    document.querySelectorAll('[data-discount-max-range]').forEach((el) => {
      el.value = state.maxDiscount;
    });
    document.querySelectorAll('[data-discount-min]').forEach((el) => {
      el.value = state.minDiscount;
    });
    document.querySelectorAll('[data-discount-max]').forEach((el) => {
      el.value = state.maxDiscount;
    });
    document.querySelectorAll('[data-discount-label]').forEach((el) => {
      el.textContent = `${state.minDiscount}% – ${state.maxDiscount}%`;
    });
  }

  function applyFilters() {
    const cards = page.querySelectorAll('[data-offer-card]');
    let visible = 0;

    cards.forEach((card) => {
      const cat = card.getAttribute('data-cat');
      const brand = card.getAttribute('data-brand');
      const discount = Number(card.getAttribute('data-discount') || 0);
      const catOk = state.cat === 'all' || cat === state.cat;
      const brandOk = !state.brands.length || state.brands.includes(brand);
      const discountOk = discount >= state.minDiscount && discount <= state.maxDiscount;
      const show = catOk && brandOk && discountOk;
      card.classList.toggle('hidden', !show);
      if (show) visible += 1;
    });

    const empty = page.querySelector('[data-offers-empty]');
    if (empty) {
      empty.classList.toggle('hidden', visible > 0);
      empty.classList.toggle('flex', visible === 0);
    }
  }

  function syncCatButtons() {
    document.querySelectorAll('[data-offer-cat]').forEach((btn) => {
      const active = btn.getAttribute('data-offer-cat') === state.cat;
      btn.classList.toggle('bg-blue-light', active);
      btn.classList.toggle('text-primary', active);
      btn.classList.toggle('font-bold', active);
      btn.classList.toggle('text-gray-700', !active);
      btn.classList.toggle('font-medium', !active);
      btn.classList.toggle('hover:bg-gray-50', !active);
    });
  }

  document.querySelectorAll('[data-offer-cat]').forEach((btn) => {
    btn.addEventListener('click', () => {
      state.cat = btn.getAttribute('data-offer-cat') || 'all';
      syncCatButtons();
      applyFilters();
    });
  });

  document.querySelectorAll('[data-offer-brand]').forEach((input) => {
    input.addEventListener('change', () => {
      const brand = input.getAttribute('data-offer-brand');
      if (input.checked) {
        if (!state.brands.includes(brand)) state.brands.push(brand);
      } else {
        state.brands = state.brands.filter((b) => b !== brand);
      }
      document.querySelectorAll(`[data-offer-brand="${brand}"]`).forEach((el) => {
        el.checked = input.checked;
      });
      applyFilters();
    });
  });

  document.querySelectorAll('[data-discount-min-range]').forEach((input) => {
    input.addEventListener('input', () => {
      let min = Number(input.value) || 0;
      if (min > state.maxDiscount) min = state.maxDiscount;
      state.minDiscount = min;
      updateDiscountUI();
    });
  });

  document.querySelectorAll('[data-discount-max-range]').forEach((input) => {
    input.addEventListener('input', () => {
      let max = Number(input.value) || 60;
      if (max < state.minDiscount) max = state.minDiscount;
      state.maxDiscount = max;
      updateDiscountUI();
    });
  });

  document.querySelectorAll('[data-discount-apply]').forEach((btn) => {
    btn.addEventListener('click', () => {
      const sidebar = btn.closest('[data-offers-sidebar]');
      const minInput = sidebar?.querySelector('[data-discount-min]');
      const maxInput = sidebar?.querySelector('[data-discount-max]');
      let min = Number(minInput?.value) || 0;
      let max = Number(maxInput?.value) || 60;
      if (min > max) [min, max] = [max, min];
      state.minDiscount = Math.max(0, Math.min(60, min));
      state.maxDiscount = Math.max(0, Math.min(60, max));
      updateDiscountUI();
      applyFilters();
    });
  });

  document.querySelectorAll('[data-offers-reset]').forEach((btn) => {
    btn.addEventListener('click', () => {
      state.cat = 'all';
      state.brands = [];
      state.minDiscount = 0;
      state.maxDiscount = 60;
      document.querySelectorAll('[data-offer-brand]').forEach((el) => {
        el.checked = false;
      });
      syncCatButtons();
      updateDiscountUI();
      applyFilters();
    });
  });

  document.querySelector('[data-offers-mobile-filters]')?.addEventListener('click', () => {
    drawer?.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
  });
  document.querySelector('[data-offers-drawer-close]')?.addEventListener('click', () => {
    drawer?.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
  });
  document.querySelector('[data-offers-drawer-overlay]')?.addEventListener('click', () => {
    drawer?.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
  });

  initCountdowns();
  updateDiscountUI();
  syncCatButtons();
  applyFilters();
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initOffersPage);
} else {
  initOffersPage();
}
