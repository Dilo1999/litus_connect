/**
 * LITUS Connect cart page — render & sync from localStorage
 */
import {
  getCart,
  setCartQty,
  removeFromCart,
  cartCount,
  updateCartBadge,
} from './cart-store';

function formatMvr(n) {
  return `MVR ${Number(n).toLocaleString()}`;
}

function escapeHtml(value) {
  return String(value ?? '')
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#39;');
}

function itemRow(item) {
  const price = Number(item.price) || 0;
  const qty = Number(item.qty) || 1;
  const name = escapeHtml(item.name);
  const img = escapeHtml(item.img);
  const variant = item.variant ? `<p class="text-xs text-muted-foreground mt-0.5">${escapeHtml(item.variant)}</p>` : '';
  const stock = item.inStock === false
    ? `<span class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-red-500"><span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>Out of Stock</span>`
    : `<span class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-emerald-600"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>In Stock</span>`;
  const free = item.freeDelivery !== false
    ? `<span class="text-[11px] font-semibold text-primary">Eligible for FREE Delivery</span>`
    : '';

  return `
    <div class="border-b border-border last:border-0 px-4 md:px-5 py-4 md:py-5" data-cart-item data-price="${price}" data-product-id="${escapeHtml(item.id)}">
      <div class="grid grid-cols-1 md:grid-cols-[minmax(0,1fr)_110px_140px_110px_72px] gap-4 md:gap-3 items-center">
        <div class="flex gap-3.5 min-w-0">
          <a href="/product/${escapeHtml(item.id)}" class="w-20 h-20 md:w-[88px] md:h-[88px] rounded-xl bg-[#F3F5F9] border border-border overflow-hidden shrink-0 flex items-center justify-center">
            <img src="${img}" alt="${name}" class="w-full h-full object-contain p-1.5" loading="lazy">
          </a>
          <div class="min-w-0">
            <a href="/product/${escapeHtml(item.id)}" class="text-sm font-extrabold text-[#011848] hover:text-primary transition-colors line-clamp-2">${name}</a>
            ${variant}
            <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-2">
              ${stock}
              ${free}
            </div>
          </div>
        </div>
        <div class="flex md:block items-center justify-between">
          <span class="md:hidden text-xs text-muted-foreground font-semibold">Price</span>
          <p class="text-sm font-extrabold text-[#011848] md:text-center" data-item-price>${formatMvr(price)}</p>
        </div>
        <div class="flex md:justify-center items-center justify-between">
          <span class="md:hidden text-xs text-muted-foreground font-semibold">Quantity</span>
          <div class="inline-flex items-center border border-border rounded-lg overflow-hidden bg-white">
            <button type="button" data-qty-minus class="w-9 h-9 flex items-center justify-center text-gray-500 hover:bg-[#F3F5F9] hover:text-primary transition-colors" aria-label="Decrease quantity">−</button>
            <input type="number" min="1" max="99" value="${qty}" data-qty-input class="w-10 h-9 text-center text-sm font-bold text-[#011848] outline-none border-x border-border [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
            <button type="button" data-qty-plus class="w-9 h-9 flex items-center justify-center text-gray-500 hover:bg-[#F3F5F9] hover:text-primary transition-colors" aria-label="Increase quantity">+</button>
          </div>
        </div>
        <div class="flex md:block items-center justify-between">
          <span class="md:hidden text-xs text-muted-foreground font-semibold">Total</span>
          <p class="text-sm font-extrabold text-[#011848] md:text-right" data-item-total>${formatMvr(price * qty)}</p>
        </div>
        <div class="flex md:justify-end items-center gap-1.5">
          <button type="button" data-remove-item class="w-9 h-9 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-colors flex items-center justify-center" aria-label="Remove item">✕</button>
        </div>
      </div>
    </div>
  `;
}

function emptyHtml(shopUrl) {
  return `
    <div class="px-5 py-16 text-center" data-cart-empty>
      <p class="text-base font-bold text-[#011848] mb-1">Your cart is empty</p>
      <p class="text-sm text-muted-foreground mb-5">Browse our shop and add items you love.</p>
      <a href="${shopUrl}" class="inline-flex items-center gap-2 bg-primary hover:bg-[#005266] text-white text-sm font-bold px-5 py-2.5 rounded-lg transition-colors">
        Continue Shopping
      </a>
    </div>
  `;
}

function initCartPage() {
  const root = document.querySelector('[data-cart-page]');
  if (!root) return;

  let discount = Number(root.getAttribute('data-discount') || 0);
  const delivery = Number(root.getAttribute('data-delivery') || 0);
  const freeThreshold = Number(root.getAttribute('data-free-threshold') || 5000);
  const shopUrl = root.getAttribute('data-shop-url') || '/shop';

  const countEl = root.querySelector('[data-cart-count]');
  const summaryCount = root.querySelector('[data-summary-count]');
  const summarySubtotal = root.querySelector('[data-summary-subtotal]');
  const summaryDiscount = root.querySelector('[data-summary-discount]');
  const summaryDelivery = root.querySelector('[data-summary-delivery]');
  const summaryTotal = root.querySelector('[data-summary-total]');
  const discountRow = root.querySelector('[data-discount-row]');
  const deliveryLead = root.querySelector('[data-delivery-lead]');
  const deliveryHighlight = root.querySelector('[data-delivery-highlight]');
  const deliverySub = root.querySelector('[data-delivery-sub]');
  const deliveryProgress = root.querySelector('[data-delivery-progress]');
  const deliveryThreshold = root.querySelector('[data-delivery-threshold]');
  const list = root.querySelector('[data-cart-list]');
  const actions = root.querySelector('[data-cart-actions]');

  function updateSummary(items) {
    let subtotal = 0;
    let qtyTotal = 0;

    items.forEach((item) => {
      const price = Number(item.price) || 0;
      const qty = Math.max(1, Math.min(99, Number(item.qty) || 1));
      qtyTotal += qty;
      subtotal += price * qty;
    });

    const appliedDiscount = items.length ? discount : 0;
    const total = Math.max(0, subtotal - appliedDiscount + delivery);
    const remaining = Math.max(0, freeThreshold - subtotal);
    const eligible = remaining <= 0;
    const progress = freeThreshold > 0 ? Math.min(100, Math.round((subtotal / freeThreshold) * 100)) : 100;

    if (countEl) countEl.textContent = String(qtyTotal);
    if (summaryCount) summaryCount.textContent = String(qtyTotal);
    if (summarySubtotal) summarySubtotal.textContent = formatMvr(subtotal);
    if (summaryDiscount) summaryDiscount.textContent = `- ${formatMvr(appliedDiscount)}`;
    if (summaryTotal) summaryTotal.textContent = formatMvr(total);
    if (summaryDelivery) summaryDelivery.textContent = delivery > 0 ? formatMvr(delivery) : 'FREE';
    if (discountRow) discountRow.classList.toggle('hidden', appliedDiscount <= 0 || items.length === 0);

    if (deliveryProgress) {
      deliveryProgress.style.width = `${progress}%`;
      deliveryProgress.classList.toggle('bg-emerald-500', eligible);
      deliveryProgress.classList.toggle('bg-primary', !eligible);
    }

    if (deliveryLead) {
      deliveryLead.textContent = eligible ? 'You are eligible for' : 'Almost there for';
    }

    if (deliveryHighlight) {
      deliveryHighlight.textContent = 'FREE DELIVERY!';
      deliveryHighlight.classList.toggle('text-emerald-600', eligible);
      deliveryHighlight.classList.toggle('text-primary', !eligible);
    }

    if (deliverySub) {
      deliverySub.textContent = `Add ${formatMvr(remaining)} more to get free delivery.`;
    }

    if (deliveryThreshold) {
      deliveryThreshold.textContent = formatMvr(freeThreshold);
      deliveryThreshold.classList.toggle('text-emerald-600', eligible);
      deliveryThreshold.classList.toggle('text-primary', !eligible);
    }

    updateCartBadge();
  }

  function bindItemEvents() {
    list?.querySelectorAll('[data-cart-item]').forEach((row) => {
      const id = row.getAttribute('data-product-id');
      const input = row.querySelector('[data-qty-input]');

      row.querySelector('[data-qty-minus]')?.addEventListener('click', () => {
        const next = Math.max(1, Number(input?.value || 1) - 1);
        setCartQty(id, next);
        render();
      });

      row.querySelector('[data-qty-plus]')?.addEventListener('click', () => {
        const next = Math.min(99, Number(input?.value || 1) + 1);
        setCartQty(id, next);
        render();
      });

      input?.addEventListener('change', () => {
        setCartQty(id, Number(input.value || 1));
        render();
      });

      row.querySelector('[data-remove-item]')?.addEventListener('click', () => {
        removeFromCart(id);
        render();
      });
    });
  }

  function render() {
    const items = getCart();

    if (!list) return;

    if (!items.length) {
      list.innerHTML = emptyHtml(shopUrl);
      actions?.classList.add('hidden');
      discount = 0;
      root.setAttribute('data-discount', '0');
      updateSummary([]);
      return;
    }

    list.innerHTML = items.map(itemRow).join('');
    actions?.classList.remove('hidden');
    bindItemEvents();
    updateSummary(items);
  }

  root.querySelector('[data-update-cart]')?.addEventListener('click', () => {
    render();
    const btn = root.querySelector('[data-update-cart]');
    if (!btn) return;
    const original = btn.innerHTML;
    btn.innerHTML = '<span>Cart updated</span>';
    setTimeout(() => {
      btn.innerHTML = original;
    }, 1200);
  });

  const couponInput = root.querySelector('[data-coupon-input]');
  const couponMsg = root.querySelector('[data-coupon-msg]');
  root.querySelector('[data-coupon-apply]')?.addEventListener('click', () => {
    const code = (couponInput?.value || '').trim().toUpperCase();
    if (!code) return;

    if (code === 'WELCOME10') {
      discount = 10000;
      root.setAttribute('data-discount', String(discount));
      const codeEl = root.querySelector('[data-discount-code]');
      if (codeEl) codeEl.textContent = code;
      if (couponMsg) {
        couponMsg.textContent = 'Coupon applied successfully!';
        couponMsg.className = 'text-xs font-semibold mt-2 text-emerald-600';
        couponMsg.classList.remove('hidden');
      }
    } else {
      discount = 0;
      root.setAttribute('data-discount', '0');
      if (couponMsg) {
        couponMsg.textContent = 'Invalid coupon code.';
        couponMsg.className = 'text-xs font-semibold mt-2 text-red-500';
        couponMsg.classList.remove('hidden');
      }
    }
    updateSummary(getCart());
  });

  const suggest = root.querySelector('[data-suggest-slider]');
  if (suggest) {
    const track = suggest.querySelector('[data-suggest-track]');
    const prev = suggest.querySelector('[data-suggest-prev]');
    const next = suggest.querySelector('[data-suggest-next]');
    const amount = () => Math.max(track.clientWidth * 0.7, 240);
    prev?.addEventListener('click', () => track?.scrollBy({ left: -amount(), behavior: 'smooth' }));
    next?.addEventListener('click', () => track?.scrollBy({ left: amount(), behavior: 'smooth' }));
  }

  render();
  void cartCount;
}

document.addEventListener('DOMContentLoaded', initCartPage);
