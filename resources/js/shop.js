/**
 * Shop / Mobile Phones — filters, sort, grid/list, pagination
 * Matches LITUS Connect shop layout
 */

function productAttrs(p) {
  return `data-product-card data-product-id="${p.id}" data-product-name="${String(p.name).replace(/"/g, '&quot;')}" data-product-price="${p.price}" data-product-img="${String(p.img).replace(/"/g, '&quot;')}" data-product-instock="${p.inStock ? '1' : '0'}"`;
}

function initShop() {
  const page = document.querySelector('[data-shop-page]');
  if (!page) return;

  const catalogEl = document.getElementById('shop-catalog');
  const configEl = document.getElementById('shop-config');
  const products = catalogEl ? JSON.parse(catalogEl.textContent || '[]') : [];
  const config = configEl ? JSON.parse(configEl.textContent || '{}') : {};
  const PER_PAGE = config.perPage || 12;
  const MAX_PRICE = config.maxPrice || 600000;
  const MIN_PRICE = config.minPrice ?? 0;
  const isMobilePhones = config.mode === 'mobile-phones'
    || config.mode === 'category'
    || page.getAttribute('data-shop-mode') === 'mobile-phones'
    || page.getAttribute('data-shop-mode') === 'category';

  const state = {
    cats: [],
    series: 'all',
    brands: [],
    minPrice: MIN_PRICE,
    maxPrice: MAX_PRICE,
    minRating: 0,
    inStockOnly: false,
    outOfStockOnly: false,
    sortBy: 'Popularity',
    viewMode: 'grid',
    page: 1,
  };

  const gridEl = page.querySelector('[data-shop-grid]');
  const listEl = page.querySelector('[data-shop-list]');
  const emptyEl = page.querySelector('[data-shop-empty]');
  const paginationEl = page.querySelector('[data-shop-pagination]');
  const chipsEl = page.querySelector('[data-shop-chips]');
  const rangeEl = page.querySelector('[data-shop-range]');
  const totalEl = page.querySelector('[data-shop-total]');
  const drawer = document.querySelector('[data-shop-drawer]');

  function formatPrice(n) {
    return `MVR ${Number(n).toLocaleString()}`;
  }

  function formatNumber(n) {
    return Number(n).toLocaleString();
  }

  function parsePrice(value) {
    const n = Number(String(value ?? '').replace(/[^\d.]/g, ''));
    return Number.isFinite(n) ? n : 0;
  }

  function clampPrice(value, min, max) {
    return Math.min(max, Math.max(min, value));
  }

  function updatePriceUI() {
    const span = MAX_PRICE - MIN_PRICE || 1;
    const minPct = ((state.minPrice - MIN_PRICE) / span) * 100;
    const maxPct = ((state.maxPrice - MIN_PRICE) / span) * 100;

    document.querySelectorAll('[data-price-dual-slider]').forEach((el) => {
      el.style.setProperty('--range-min', `${minPct}%`);
      el.style.setProperty('--range-max', `${maxPct}%`);
    });

    document.querySelectorAll('[data-filter-min-price]').forEach((input) => {
      input.value = formatNumber(state.minPrice);
    });
    document.querySelectorAll('[data-filter-max-price]').forEach((input) => {
      input.value = formatNumber(state.maxPrice);
    });
    document.querySelectorAll('[data-filter-price-min-range]').forEach((input) => {
      input.value = state.minPrice;
    });
    document.querySelectorAll('[data-filter-price-max-range]').forEach((input) => {
      input.value = state.maxPrice;
    });
    document.querySelectorAll('[data-filter-price-range]').forEach((input) => {
      input.value = state.maxPrice;
    });
    document.querySelectorAll('[data-filter-price-label]').forEach((el) => {
      el.textContent = `${formatPrice(state.minPrice)} – ${formatPrice(state.maxPrice)}`;
    });
  }

  function stars(rating) {
    let html = '<div class="flex gap-0.5">';
    const r = Math.round(rating);
    for (let i = 1; i <= 5; i += 1) {
      const filled = i <= r;
      html += `<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" class="${filled ? 'fill-amber-400 text-amber-400' : 'fill-gray-200 text-gray-200'}"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>`;
    }
    return `${html}</div>`;
  }

  function badgeHtml(badge) {
    if (!badge) return '';
    let color = 'bg-primary';
    if (isMobilePhones) {
      if (badge === 'SALE') color = 'bg-red-500';
      else if (badge === 'NEW') color = 'bg-violet-600';
    }
    return `<span class="absolute top-3 left-3 text-white text-[10px] font-bold px-2.5 py-1 rounded-md ${color} tracking-wide uppercase">${badge}</span>`;
  }

  function getFiltered() {
    let list = [...products];

    if (isMobilePhones) {
      if (state.series && state.series !== 'all') {
        list = list.filter((p) => p.series === state.series);
      }
    } else if (state.cats.length) {
      list = list.filter((p) => state.cats.includes(p.cat));
    }

    if (state.brands.length) list = list.filter((p) => state.brands.includes(p.brand));
    list = list.filter((p) => p.price >= state.minPrice && p.price <= state.maxPrice);
    if (state.minRating > 0) list = list.filter((p) => p.rating >= state.minRating);

    if (state.inStockOnly && !state.outOfStockOnly) list = list.filter((p) => p.inStock);
    if (state.outOfStockOnly && !state.inStockOnly) list = list.filter((p) => !p.inStock);

    switch (state.sortBy) {
      case 'Price: Low to High':
        list.sort((a, b) => a.price - b.price);
        break;
      case 'Price: High to Low':
        list.sort((a, b) => b.price - a.price);
        break;
      case 'Top Rated':
        list.sort((a, b) => b.rating - a.rating);
        break;
      case 'Newest':
        list.sort((a, b) => b.id - a.id);
        break;
      case 'Popularity':
      default:
        list.sort((a, b) => b.reviews - a.reviews);
        break;
    }

    return list;
  }

  function productUrl(id) {
    return `/product/${id}`;
  }

  function gridCard(p) {
    if (isMobilePhones) {
      return `
        <div class="bg-white rounded-xl border border-border hover:shadow-md transition-all duration-200 group overflow-hidden flex flex-col" ${productAttrs(p)}>
          <div class="relative p-5 bg-white min-h-[190px] flex items-center justify-center">
            ${badgeHtml(p.badge)}
            ${!p.inStock ? '<div class="absolute inset-0 bg-white/65 flex items-center justify-center z-10"><span class="bg-gray-800 text-white text-xs font-bold px-3 py-1.5 rounded-lg">Out of Stock</span></div>' : ''}
            <a href="${productUrl(p.id)}" class="absolute inset-0 z-0" aria-label="${p.name}"></a>
            <img src="${p.img}" alt="${p.name}" class="relative z-10 pointer-events-none h-36 w-full object-contain group-hover:scale-105 transition-transform duration-300" loading="lazy">
          </div>
          <div class="px-4 pb-4 flex flex-col flex-1">
            <a href="${productUrl(p.id)}" class="text-sm font-bold text-[#011848] line-clamp-2 mb-2 leading-snug min-h-[2.5rem] hover:text-primary transition-colors">${p.name}</a>
            <div class="flex items-center gap-1.5 mb-2.5">
              ${stars(p.rating)}
              <span class="text-[11px] text-gray-400">(${p.reviews})</span>
            </div>
            <div class="mt-auto flex items-end justify-between gap-2">
              <div class="flex items-baseline gap-2 flex-wrap">
                <span class="text-base font-extrabold text-primary">${formatPrice(p.price)}</span>
                ${p.original ? `<span class="text-xs text-gray-400 line-through">${formatPrice(p.original)}</span>` : ''}
              </div>
              <button type="button" data-add-to-cart ${!p.inStock ? 'disabled' : ''} class="relative z-10 w-9 h-9 flex-shrink-0 rounded-lg border border-border bg-white flex items-center justify-center transition-all ${!p.inStock ? 'text-gray-300 cursor-not-allowed' : 'text-primary hover:bg-primary hover:text-white hover:border-primary'}" aria-label="Add to cart">
                ${!p.inStock ? '' : `
                  <span data-cart-default>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                  </span>
                  <span data-cart-added class="hidden text-emerald-600 text-xs font-bold">✓</span>
                `}
              </button>
            </div>
          </div>
        </div>
      `;
    }

    return `
      <div class="bg-white rounded-xl border border-border hover:shadow-md transition-all duration-200 group overflow-hidden flex flex-col" ${productAttrs(p)}>
        <div class="relative p-5 bg-white min-h-[190px] flex items-center justify-center">
          ${badgeHtml(p.badge)}
          ${!p.inStock ? '<div class="absolute inset-0 bg-white/65 flex items-center justify-center z-10"><span class="bg-gray-800 text-white text-xs font-bold px-3 py-1.5 rounded-lg">Out of Stock</span></div>' : ''}
          <a href="${productUrl(p.id)}" class="absolute inset-0 z-0" aria-label="${p.name}"></a>
          <img src="${p.img}" alt="${p.name}" class="relative z-10 pointer-events-none h-36 w-full object-contain group-hover:scale-105 transition-transform duration-300" loading="lazy">
        </div>
        <div class="px-4 pb-4 flex flex-col flex-1">
          <a href="${productUrl(p.id)}" class="text-sm font-bold text-[#011848] line-clamp-2 mb-2 leading-snug min-h-[2.5rem] hover:text-primary transition-colors">${p.name}</a>
          <div class="flex items-center gap-1.5 mb-2.5">
            ${stars(p.rating)}
            <span class="text-[11px] text-gray-400">(${p.reviews})</span>
          </div>
          <div class="flex items-baseline gap-2 mb-4">
            <span class="text-base font-extrabold text-primary">${formatPrice(p.price)}</span>
            ${p.original ? `<span class="text-xs text-gray-400 line-through">${formatPrice(p.original)}</span>` : ''}
          </div>
          <button type="button" data-add-to-cart ${!p.inStock ? 'disabled' : ''} class="mt-auto w-full py-2.5 rounded-lg text-sm font-semibold border border-border bg-white transition-all flex items-center justify-center gap-2 ${!p.inStock ? 'text-gray-400 cursor-not-allowed' : 'text-[#011848] hover:border-primary hover:text-primary'}">
            ${!p.inStock ? 'Out of Stock' : `
              <span data-cart-default class="inline-flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                Add to Cart
              </span>
              <span data-cart-added class="hidden text-emerald-600">Added!</span>
            `}
          </button>
        </div>
      </div>
    `;
  }

  function listCard(p) {
    return `
      <div class="bg-white rounded-xl border border-border hover:shadow-md transition-all flex overflow-hidden group" ${productAttrs(p)}>
        <a href="${productUrl(p.id)}" class="relative w-36 sm:w-44 flex-shrink-0 bg-[#f7f9fc] flex items-center justify-center p-4">
          ${badgeHtml(p.badge)}
          ${!p.inStock ? '<div class="absolute inset-0 bg-white/65 flex items-center justify-center z-10"><span class="bg-gray-800 text-white text-[10px] font-bold px-2 py-1 rounded-lg">Out of Stock</span></div>' : ''}
          <img src="${p.img}" alt="${p.name}" class="h-28 w-28 object-contain group-hover:scale-105 transition-transform" loading="lazy">
        </a>
        <div class="flex-1 p-4 sm:p-5 flex flex-col justify-between min-w-0">
          <div>
            <p class="text-[11px] font-bold text-muted-foreground uppercase tracking-wider mb-1">${p.brand}${p.series || p.cat ? ` · ${p.series || p.cat}` : ''}</p>
            <a href="${productUrl(p.id)}" class="font-bold text-sm sm:text-base text-[#0B1426] mb-2 hover:text-primary transition-colors inline-block">${p.name}</a>
            <div class="flex items-center gap-2 mb-2">${stars(p.rating)}<span class="text-xs text-muted-foreground">(${p.reviews})</span></div>
          </div>
          <div class="flex flex-wrap items-center justify-between gap-3 mt-3">
            <div class="flex items-baseline gap-2">
              <span class="text-lg font-extrabold text-primary">${formatPrice(p.price)}</span>
              ${p.original ? `<span class="text-sm text-muted-foreground line-through">${formatPrice(p.original)}</span>` : ''}
            </div>
            <button type="button" data-add-to-cart ${!p.inStock ? 'disabled' : ''} class="inline-flex items-center gap-1.5 text-sm font-semibold ${!p.inStock ? 'text-gray-400' : 'text-primary hover:text-[#0d4fc7]'}">
              ${!p.inStock ? 'Out of Stock' : '<span data-cart-default>Add to Cart</span><span data-cart-added class="hidden text-emerald-600">Added!</span>'}
            </button>
          </div>
        </div>
      </div>
    `;
  }

  function bindCardActions() {
    // Add-to-cart is handled globally via cart-store.js event delegation
  }

  function renderChips() {
    const chips = [];
    if (isMobilePhones && state.series && state.series !== 'all') {
      chips.push({ key: 'series', label: state.series });
    }
    state.cats.forEach((c) => chips.push({ key: `cat:${c}`, label: c }));
    state.brands.forEach((b) => chips.push({ key: `brand:${b}`, label: b }));
    if (state.minPrice > MIN_PRICE || state.maxPrice < MAX_PRICE) {
      chips.push({ key: 'price', label: `${formatPrice(state.minPrice)} – ${formatPrice(state.maxPrice)}` });
    }
    if (state.inStockOnly) chips.push({ key: 'stock', label: 'In Stock' });
    if (state.outOfStockOnly) chips.push({ key: 'oos', label: 'Out of Stock' });
    if (state.minRating > 0) chips.push({ key: 'rating', label: `${state.minRating}+ Stars` });

    if (!chips.length) {
      chipsEl.classList.add('hidden');
      chipsEl.innerHTML = '';
      return;
    }

    chipsEl.classList.remove('hidden');
    chipsEl.innerHTML =
      chips
        .map(
          (c) =>
            `<button type="button" data-chip-remove="${c.key}" class="flex items-center gap-1.5 text-xs font-bold bg-blue-light text-primary px-3 py-1.5 rounded-full hover:bg-blue-100 transition-colors">${c.label} <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg></button>`
        )
        .join('') +
      `<button type="button" data-shop-reset class="text-xs font-bold text-red-500 hover:text-red-600 px-2 py-1.5">Clear all</button>`;

    chipsEl.querySelectorAll('[data-chip-remove]').forEach((btn) => {
      btn.addEventListener('click', () => {
        const key = btn.getAttribute('data-chip-remove');
        if (key === 'price') {
          state.minPrice = MIN_PRICE;
          state.maxPrice = MAX_PRICE;
        } else if (key === 'stock') state.inStockOnly = false;
        else if (key === 'oos') state.outOfStockOnly = false;
        else if (key === 'rating') state.minRating = 0;
        else if (key === 'series') state.series = 'all';
        else if (key.startsWith('cat:')) state.cats = state.cats.filter((x) => x !== key.slice(4));
        else if (key.startsWith('brand:')) state.brands = state.brands.filter((x) => x !== key.slice(6));
        state.page = 1;
        syncControls();
        render();
      });
    });
    chipsEl.querySelectorAll('[data-shop-reset]').forEach((btn) => btn.addEventListener('click', resetFilters));
  }

  function renderPagination(totalPages) {
    if (totalPages <= 1) {
      paginationEl.innerHTML = '';
      return;
    }

    let html = '';
    const maxShown = 6;
    for (let i = 1; i <= totalPages; i += 1) {
      if (totalPages > maxShown && i === maxShown && i < totalPages) {
        html += `<span class="min-w-10 h-10 flex items-center justify-center text-sm text-gray-400">…</span>`;
        html += `<button type="button" data-page="${totalPages}" class="min-w-10 h-10 px-3 rounded-lg text-sm font-bold transition-all border border-border text-gray-600 hover:border-primary hover:text-primary bg-white">${totalPages}</button>`;
        break;
      }
      if (totalPages > maxShown && i > maxShown) break;
      const active = i === state.page;
      html += `<button type="button" data-page="${i}" class="min-w-10 h-10 px-3 rounded-lg text-sm font-bold transition-all border ${active ? 'bg-primary text-white border-primary' : 'border-border text-gray-600 hover:border-primary hover:text-primary bg-white'}">${i}</button>`;
    }
    html += `<button type="button" data-page-next class="min-w-10 h-10 px-3 rounded-lg border border-border bg-white text-gray-500 hover:border-primary hover:text-primary disabled:opacity-40" ${state.page === totalPages ? 'disabled' : ''} aria-label="Next">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
    </button>`;

    paginationEl.innerHTML = html;

    paginationEl.querySelector('[data-page-next]')?.addEventListener('click', () => {
      state.page = Math.min(totalPages, state.page + 1);
      render();
      window.scrollTo({ top: page.offsetTop - 80, behavior: 'smooth' });
    });
    paginationEl.querySelectorAll('[data-page]').forEach((btn) => {
      btn.addEventListener('click', () => {
        state.page = Number(btn.getAttribute('data-page'));
        render();
        window.scrollTo({ top: page.offsetTop - 80, behavior: 'smooth' });
      });
    });
  }

  function render() {
    const filtered = getFiltered();
    const totalPages = Math.max(1, Math.ceil(filtered.length / PER_PAGE));
    if (state.page > totalPages) state.page = totalPages;

    const start = (state.page - 1) * PER_PAGE;
    const pageItems = filtered.slice(start, start + PER_PAGE);

    if (totalEl) totalEl.textContent = String(filtered.length);
    if (rangeEl) {
      const from = filtered.length ? start + 1 : 0;
      const to = Math.min(start + PER_PAGE, filtered.length);
      rangeEl.textContent = filtered.length ? `${from}–${to}` : '0';
    }

    renderChips();

    if (!pageItems.length) {
      gridEl.classList.add('hidden');
      listEl.classList.add('hidden');
      listEl.classList.remove('flex');
      emptyEl.classList.remove('hidden');
      emptyEl.classList.add('flex');
      paginationEl.innerHTML = '';
      return;
    }

    emptyEl.classList.add('hidden');
    emptyEl.classList.remove('flex');

    if (state.viewMode === 'grid') {
      gridEl.classList.remove('hidden');
      listEl.classList.add('hidden');
      listEl.classList.remove('flex');
      gridEl.innerHTML = pageItems.map(gridCard).join('');
      bindCardActions(gridEl);
    } else {
      listEl.classList.remove('hidden');
      listEl.classList.add('flex');
      gridEl.classList.add('hidden');
      listEl.innerHTML = pageItems.map(listCard).join('');
      bindCardActions(listEl);
    }

    renderPagination(totalPages);
  }

  function syncControls() {
    document.querySelectorAll('[data-filter-cat]').forEach((input) => {
      input.checked = state.cats.includes(input.getAttribute('data-filter-cat'));
    });
    document.querySelectorAll('[data-filter-series]').forEach((btn) => {
      const key = btn.getAttribute('data-filter-series');
      const active = state.series === key;
      btn.classList.toggle('bg-blue-light', active);
      btn.classList.toggle('text-primary', active);
      btn.classList.toggle('font-bold', active);
      btn.classList.toggle('text-gray-700', !active);
      btn.classList.toggle('font-medium', !active);
      btn.classList.toggle('hover:bg-gray-50', !active);
    });
    document.querySelectorAll('[data-filter-brand]').forEach((input) => {
      input.checked = state.brands.includes(input.getAttribute('data-filter-brand'));
    });
    updatePriceUI();
    document.querySelectorAll('[data-filter-rating]').forEach((btn) => {
      const r = Number(btn.getAttribute('data-filter-rating'));
      const active = state.minRating === r;
      btn.classList.toggle('bg-blue-light', active);
      btn.querySelector('[data-rating-dot]')?.classList.toggle('opacity-0', !active);
    });
    document.querySelectorAll('[data-filter-instock]').forEach((input) => {
      input.checked = state.inStockOnly;
    });
    document.querySelectorAll('[data-filter-outofstock]').forEach((input) => {
      input.checked = state.outOfStockOnly;
    });
  }

  function resetFilters() {
    state.cats = [];
    state.series = 'all';
    state.brands = [];
    state.minPrice = MIN_PRICE;
    state.maxPrice = MAX_PRICE;
    state.minRating = 0;
    state.inStockOnly = false;
    state.outOfStockOnly = false;
    state.page = 1;
    syncControls();
    render();
  }

  function applyAndRender(fn) {
    fn();
    state.page = 1;
    syncControls();
    render();
  }

  // Section toggles
  document.querySelectorAll('[data-filter-toggle]').forEach((btn) => {
    btn.addEventListener('click', () => {
      const section = btn.closest('[data-filter-section]');
      const body = section?.querySelector('[data-filter-body]');
      const chevron = section?.querySelector('[data-filter-chevron]');
      if (!body) return;
      const nowHidden = body.classList.toggle('hidden');
      chevron?.classList.toggle('rotate-180', nowHidden);
    });
  });

  // View more categories
  document.querySelectorAll('[data-categories-more]').forEach((btn) => {
    btn.addEventListener('click', () => {
      const list = btn.closest('[data-filter-body]')?.querySelector('[data-category-list]');
      const hidden = list?.querySelectorAll('[data-category-item].hidden') || [];
      if (hidden.length) {
        hidden.forEach((el) => el.classList.remove('hidden'));
        btn.textContent = 'View Less';
      } else {
        list?.querySelectorAll('[data-category-item]').forEach((el, i) => {
          if (i >= 6) el.classList.add('hidden');
        });
        btn.textContent = 'View More';
      }
    });
  });

  // View more brands
  document.querySelectorAll('[data-brands-more]').forEach((btn) => {
    btn.addEventListener('click', () => {
      const body = btn.closest('[data-filter-body]');
      const hidden = body?.querySelectorAll('[data-brand-item].hidden') || [];
      if (hidden.length) {
        hidden.forEach((el) => el.classList.remove('hidden'));
        btn.textContent = 'View Less';
      } else {
        body?.querySelectorAll('[data-brand-item]').forEach((el, i) => {
          if (i >= 6) el.classList.add('hidden');
        });
        btn.textContent = 'View More';
      }
    });
  });

  document.querySelectorAll('[data-filter-series]').forEach((btn) => {
    btn.addEventListener('click', () => {
      const key = btn.getAttribute('data-filter-series') || 'all';
      applyAndRender(() => {
        state.series = key;
      });
    });
  });

  document.querySelectorAll('[data-filter-cat]').forEach((input) => {
    input.addEventListener('change', () => {
      const cat = input.getAttribute('data-filter-cat');
      applyAndRender(() => {
        if (input.checked) {
          if (!state.cats.includes(cat)) state.cats.push(cat);
        } else {
          state.cats = state.cats.filter((c) => c !== cat);
        }
        document.querySelectorAll(`[data-filter-cat="${cat}"]`).forEach((el) => {
          el.checked = input.checked;
        });
      });
    });
  });

  document.querySelectorAll('[data-filter-brand]').forEach((input) => {
    input.addEventListener('change', () => {
      const brand = input.getAttribute('data-filter-brand');
      applyAndRender(() => {
        if (input.checked) {
          if (!state.brands.includes(brand)) state.brands.push(brand);
        } else {
          state.brands = state.brands.filter((b) => b !== brand);
        }
        document.querySelectorAll(`[data-filter-brand="${brand}"]`).forEach((el) => {
          el.checked = input.checked;
        });
      });
    });
  });

  document.querySelectorAll('[data-filter-price-min-range]').forEach((input) => {
    input.addEventListener('input', () => {
      let min = Number(input.value) || MIN_PRICE;
      if (min > state.maxPrice) min = state.maxPrice;
      state.minPrice = clampPrice(min, MIN_PRICE, MAX_PRICE);
      updatePriceUI();
    });
  });

  document.querySelectorAll('[data-filter-price-max-range]').forEach((input) => {
    input.addEventListener('input', () => {
      let max = Number(input.value) || MAX_PRICE;
      if (max < state.minPrice) max = state.minPrice;
      state.maxPrice = clampPrice(max, MIN_PRICE, MAX_PRICE);
      updatePriceUI();
    });
  });

  document.querySelectorAll('[data-filter-price-range]').forEach((input) => {
    input.addEventListener('input', () => {
      state.maxPrice = clampPrice(Number(input.value) || MAX_PRICE, MIN_PRICE, MAX_PRICE);
      if (state.maxPrice < state.minPrice) state.minPrice = state.maxPrice;
      updatePriceUI();
    });
  });

  document.querySelectorAll('[data-filter-min-price], [data-filter-max-price]').forEach((input) => {
    input.addEventListener('blur', () => {
      const isMin = input.hasAttribute('data-filter-min-price');
      let value = parsePrice(input.value);
      if (isMin) {
        value = clampPrice(value, MIN_PRICE, state.maxPrice);
        state.minPrice = value;
      } else {
        value = clampPrice(value, state.minPrice, MAX_PRICE);
        state.maxPrice = value;
      }
      updatePriceUI();
    });
  });

  document.querySelectorAll('[data-filter-price-apply]').forEach((btn) => {
    btn.addEventListener('click', () => {
      const sidebar = btn.closest('[data-shop-sidebar]');
      const minInput = sidebar?.querySelector('[data-filter-min-price]');
      const maxInput = sidebar?.querySelector('[data-filter-max-price]');
      applyAndRender(() => {
        let min = parsePrice(minInput?.value);
        let max = parsePrice(maxInput?.value);
        if (min > max) [min, max] = [max, min];
        state.minPrice = clampPrice(min || MIN_PRICE, MIN_PRICE, MAX_PRICE);
        state.maxPrice = clampPrice(max || MAX_PRICE, MIN_PRICE, MAX_PRICE);
      });
    });
  });

  document.querySelectorAll('[data-filter-rating]').forEach((btn) => {
    btn.addEventListener('click', () => {
      const r = Number(btn.getAttribute('data-filter-rating'));
      applyAndRender(() => {
        state.minRating = state.minRating === r ? 0 : r;
      });
    });
  });

  document.querySelectorAll('[data-filter-instock]').forEach((input) => {
    input.addEventListener('change', () => {
      applyAndRender(() => {
        state.inStockOnly = input.checked;
        document.querySelectorAll('[data-filter-instock]').forEach((el) => {
          el.checked = input.checked;
        });
      });
    });
  });

  document.querySelectorAll('[data-filter-outofstock]').forEach((input) => {
    input.addEventListener('change', () => {
      applyAndRender(() => {
        state.outOfStockOnly = input.checked;
        document.querySelectorAll('[data-filter-outofstock]').forEach((el) => {
          el.checked = input.checked;
        });
      });
    });
  });

  document.querySelectorAll('[data-shop-reset]').forEach((btn) => {
    btn.addEventListener('click', resetFilters);
  });

  page.querySelector('[data-shop-sort]')?.addEventListener('change', (e) => {
    state.sortBy = e.target.value;
    state.page = 1;
    render();
  });

  page.querySelectorAll('[data-shop-view]').forEach((btn) => {
    btn.addEventListener('click', () => {
      state.viewMode = btn.getAttribute('data-shop-view');
      page.querySelectorAll('[data-shop-view]').forEach((b) => {
        const active = b.getAttribute('data-shop-view') === state.viewMode;
        b.classList.toggle('bg-primary', active);
        b.classList.toggle('text-white', active);
        b.classList.toggle('text-gray-500', !active);
      });
      render();
    });
  });

  document.querySelector('[data-shop-mobile-filters]')?.addEventListener('click', () => {
    drawer?.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
  });
  document.querySelector('[data-shop-drawer-close]')?.addEventListener('click', () => {
    drawer?.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
  });
  document.querySelector('[data-shop-drawer-overlay]')?.addEventListener('click', () => {
    drawer?.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
  });

  syncControls();
  render();
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initShop);
} else {
  initShop();
}
