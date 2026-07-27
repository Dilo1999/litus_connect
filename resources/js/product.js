/**
 * Product details — gallery, options, qty, tabs, zoom
 */

function initProductPage() {
  const page = document.querySelector('[data-product-page]');
  if (!page) return;

  const mainImage = page.querySelector('[data-product-main-image]');
  const qtyInput = page.querySelector('[data-product-qty]');
  const zoomModal = document.querySelector('[data-zoom-modal]');
  const zoomImage = document.querySelector('[data-zoom-image]');

  function setActiveThumbs(activeThumb) {
    page.querySelectorAll('[data-product-thumb]').forEach((el) => {
      const active = el.getAttribute('data-image') === activeThumb.getAttribute('data-image');
      el.classList.toggle('border-primary', active);
      el.classList.toggle('ring-2', active);
      el.classList.toggle('ring-primary/15', active);
      el.classList.toggle('border-border', !active);
    });
  }

  function setMainImage(src) {
    if (!mainImage || !src) return;
    mainImage.style.opacity = '0.4';
    setTimeout(() => {
      mainImage.src = src;
      mainImage.style.opacity = '1';
      if (zoomImage) zoomImage.src = src;
    }, 120);
  }

  page.querySelectorAll('[data-product-thumb]').forEach((thumb) => {
    thumb.addEventListener('click', () => {
      setMainImage(thumb.getAttribute('data-image'));
      setActiveThumbs(thumb);
    });
  });

  function openZoom() {
    if (!zoomModal || !mainImage) return;
    if (zoomImage) zoomImage.src = mainImage.src;
    zoomModal.classList.remove('hidden');
    zoomModal.classList.add('flex');
    document.body.classList.add('overflow-hidden');
  }

  function closeZoom() {
    if (!zoomModal) return;
    zoomModal.classList.add('hidden');
    zoomModal.classList.remove('flex');
    document.body.classList.remove('overflow-hidden');
  }

  document.querySelectorAll('[data-product-zoom-trigger]').forEach((el) => {
    el.addEventListener('click', openZoom);
  });
  document.querySelector('[data-zoom-close]')?.addEventListener('click', closeZoom);
  zoomModal?.addEventListener('click', (e) => {
    if (e.target === zoomModal) closeZoom();
  });
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeZoom();
  });

  page.querySelectorAll('[data-product-color]').forEach((btn) => {
    btn.addEventListener('click', () => {
      const name = btn.getAttribute('data-product-color');
      const label = page.querySelector('[data-selected-color]');
      if (label && name) label.textContent = name;
      page.querySelectorAll('[data-product-color]').forEach((el) => {
        const active = el === btn;
        el.classList.toggle('border-primary', active);
        el.classList.toggle('ring-2', active);
        el.classList.toggle('ring-primary/20', active);
        el.classList.toggle('border-white', !active);
        el.classList.toggle('shadow-[0_0_0_1px_#E4E9F2]', !active);
      });
    });
  });

  page.querySelectorAll('[data-product-storage]').forEach((btn) => {
    btn.addEventListener('click', () => {
      const value = btn.getAttribute('data-product-storage');
      const label = page.querySelector('[data-selected-storage]');
      if (label && value) label.textContent = value;
      page.querySelectorAll('[data-product-storage]').forEach((el) => {
        const active = el === btn;
        el.classList.toggle('border-primary', active);
        el.classList.toggle('text-primary', active);
        el.classList.toggle('ring-1', active);
        el.classList.toggle('ring-primary/20', active);
        el.classList.toggle('border-border', !active);
        el.classList.toggle('text-gray-700', !active);
      });
    });
  });

  function setQty(value) {
    if (!qtyInput) return;
    qtyInput.value = String(Math.min(10, Math.max(1, value)));
  }

  page.querySelector('[data-qty-minus]')?.addEventListener('click', () => {
    setQty(Number(qtyInput?.value || 1) - 1);
  });
  page.querySelector('[data-qty-plus]')?.addEventListener('click', () => {
    setQty(Number(qtyInput?.value || 1) + 1);
  });
  qtyInput?.addEventListener('change', () => setQty(Number(qtyInput.value || 1)));

  const addBtn = page.querySelector('[data-product-add-cart]');
  const addLabel = addBtn?.querySelector('[data-add-label]');
  addBtn?.addEventListener('click', () => {
    if (addBtn.disabled || !addLabel) return;
    const original = addLabel.textContent;
    addLabel.textContent = 'Added!';
    addBtn.classList.add('bg-emerald-600');
    addBtn.classList.remove('bg-primary', 'hover:bg-[#0d4fc7]');
    setTimeout(() => {
      addLabel.textContent = original;
      addBtn.classList.remove('bg-emerald-600');
      addBtn.classList.add('bg-primary', 'hover:bg-[#0d4fc7]');
    }, 1600);
  });

  page.querySelector('[data-product-buy-now]')?.addEventListener('click', (e) => {
    if (e.currentTarget.disabled) return;
    addBtn?.click();
  });

  page.querySelectorAll('[data-product-wishlist]').forEach((btn) => {
    btn.addEventListener('click', () => {
      const active = btn.classList.toggle('is-wished');
      btn.classList.toggle('text-red-500', active);
      btn.classList.toggle('border-red-200', active);
      btn.querySelector('[data-wishlist-icon]')?.classList.toggle('fill-red-500', active);
    });
  });

  const showMoreBtn = page.querySelector('[data-show-more-desc]');
  showMoreBtn?.addEventListener('click', () => {
    const preview = page.querySelector('[data-desc-preview]');
    const full = page.querySelector('[data-desc-full]');
    const expanded = !full?.classList.contains('hidden');
    preview?.classList.toggle('hidden', !expanded);
    full?.classList.toggle('hidden', expanded);
    showMoreBtn.textContent = expanded ? 'Show More' : 'Show Less';
  });

  function activateTab(id) {
    const tabsRoot = page.querySelector('[data-product-tabs]');
    if (!tabsRoot) return;
    tabsRoot.querySelectorAll('[data-tab]').forEach((b) => {
      const active = b.getAttribute('data-tab') === id;
      b.classList.toggle('text-primary', active);
      b.classList.toggle('border-primary', active);
      b.classList.toggle('text-muted-foreground', !active);
      b.classList.toggle('border-transparent', !active);
    });
    tabsRoot.querySelectorAll('[data-tab-panel]').forEach((panel) => {
      panel.classList.toggle('hidden', panel.getAttribute('data-tab-panel') !== id);
    });
    tabsRoot.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }

  const tabsRoot = page.querySelector('[data-product-tabs]');
  tabsRoot?.querySelectorAll('[data-tab]').forEach((btn) => {
    btn.addEventListener('click', () => activateTab(btn.getAttribute('data-tab')));
  });

  page.querySelectorAll('[data-tab-jump]').forEach((btn) => {
    btn.addEventListener('click', () => activateTab(btn.getAttribute('data-tab-jump')));
  });

  page.querySelectorAll('[data-add-to-cart]:not([disabled])').forEach((btn) => {
    if (btn.hasAttribute('data-product-add-cart')) return;
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();
      const def = btn.querySelector('[data-cart-default]');
      const added = btn.querySelector('[data-cart-added]');
      if (!def || !added) return;
      def.classList.add('hidden');
      added.classList.remove('hidden');
      setTimeout(() => {
        def.classList.remove('hidden');
        added.classList.add('hidden');
      }, 1400);
    });
  });
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initProductPage);
} else {
  initProductPage();
}
