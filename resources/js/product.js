/**
 * Product details — gallery, options, qty, tabs
 */

function initProductPage() {
  const page = document.querySelector('[data-product-page]');
  if (!page) return;

  const mainImage = page.querySelector('[data-product-main-image]');
  const qtyInput = page.querySelector('[data-product-qty]');

  page.querySelectorAll('[data-product-thumb]').forEach((thumb) => {
    thumb.addEventListener('click', () => {
      const src = thumb.getAttribute('data-image');
      if (mainImage && src) {
        mainImage.style.opacity = '0.4';
        setTimeout(() => {
          mainImage.src = src;
          mainImage.style.opacity = '1';
        }, 120);
      }
      page.querySelectorAll('[data-product-thumb]').forEach((el) => {
        el.classList.toggle('border-primary', el === thumb);
        el.classList.toggle('ring-2', el === thumb);
        el.classList.toggle('ring-primary/20', el === thumb);
        el.classList.toggle('border-border', el !== thumb);
      });
    });
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
        el.classList.toggle('scale-105', active);
        el.classList.toggle('border-white', !active);
        el.classList.toggle('shadow-[0_0_0_1px_#E4E9F2]', !active);
      });
    });
  });

  page.querySelectorAll('[data-product-storage]').forEach((btn) => {
    btn.addEventListener('click', () => {
      page.querySelectorAll('[data-product-storage]').forEach((el) => {
        const active = el === btn;
        el.classList.toggle('border-primary', active);
        el.classList.toggle('bg-blue-light', active);
        el.classList.toggle('text-primary', active);
        el.classList.toggle('border-border', !active);
        el.classList.toggle('text-gray-700', !active);
      });
    });
  });

  function setQty(value) {
    if (!qtyInput) return;
    const next = Math.min(10, Math.max(1, value));
    qtyInput.value = String(next);
  }

  page.querySelector('[data-qty-minus]')?.addEventListener('click', () => {
    setQty(Number(qtyInput?.value || 1) - 1);
  });
  page.querySelector('[data-qty-plus]')?.addEventListener('click', () => {
    setQty(Number(qtyInput?.value || 1) + 1);
  });
  qtyInput?.addEventListener('change', () => {
    setQty(Number(qtyInput.value || 1));
  });

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

  page.querySelector('[data-product-wishlist]')?.addEventListener('click', (btnEvent) => {
    const btn = btnEvent.currentTarget;
    const active = btn.classList.toggle('is-wished');
    btn.classList.toggle('text-red-500', active);
    btn.classList.toggle('border-red-200', active);
    btn.querySelector('[data-wishlist-icon]')?.classList.toggle('fill-red-500', active);
  });

  page.querySelector('[data-product-share]')?.addEventListener('click', async () => {
    const url = window.location.href;
    try {
      if (navigator.share) {
        await navigator.share({ title: document.title, url });
      } else if (navigator.clipboard) {
        await navigator.clipboard.writeText(url);
        const btn = page.querySelector('[data-product-share]');
        btn?.classList.add('text-primary', 'border-primary');
        setTimeout(() => btn?.classList.remove('text-primary', 'border-primary'), 1200);
      }
    } catch {
      // user cancelled share
    }
  });

  const tabsRoot = page.querySelector('[data-product-tabs]');
  if (tabsRoot) {
    const buttons = tabsRoot.querySelectorAll('[data-tab]');
    const panels = tabsRoot.querySelectorAll('[data-tab-panel]');
    buttons.forEach((btn) => {
      btn.addEventListener('click', () => {
        const id = btn.getAttribute('data-tab');
        buttons.forEach((b) => {
          const active = b === btn;
          b.classList.toggle('text-primary', active);
          b.classList.toggle('border-primary', active);
          b.classList.toggle('text-muted-foreground', !active);
          b.classList.toggle('border-transparent', !active);
        });
        panels.forEach((panel) => {
          panel.classList.toggle('hidden', panel.getAttribute('data-tab-panel') !== id);
        });
      });
    });
  }
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initProductPage);
} else {
  initProductPage();
}
