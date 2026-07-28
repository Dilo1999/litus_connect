/**
 * Shared cart store (localStorage)
 */
const CART_KEY = 'litus_connect_cart';

export function getCart() {
  try {
    const raw = localStorage.getItem(CART_KEY);
    const items = raw ? JSON.parse(raw) : [];
    return Array.isArray(items) ? items : [];
  } catch {
    return [];
  }
}

export function saveCart(items) {
  localStorage.setItem(CART_KEY, JSON.stringify(items));
  updateCartBadge();
  window.dispatchEvent(new CustomEvent('cart:updated', { detail: { items } }));
}

export function cartCount(items = getCart()) {
  return items.reduce((sum, item) => sum + Number(item.qty || 0), 0);
}

export function addToCart(product, qty = 1) {
  if (!product?.id) return getCart();

  const items = getCart();
  const id = String(product.id);
  const existing = items.find((item) => String(item.id) === id);
  const amount = Math.max(1, Math.min(99, Number(qty) || 1));

  if (existing) {
    existing.qty = Math.min(99, Number(existing.qty || 0) + amount);
  } else {
    items.push({
      id: product.id,
      name: product.name || 'Product',
      price: Number(product.price) || 0,
      img: product.img || '',
      variant: product.variant || '',
      qty: amount,
      inStock: product.inStock !== false,
      freeDelivery: product.freeDelivery !== false,
    });
  }

  saveCart(items);
  return items;
}

export function setCartQty(id, qty) {
  const items = getCart();
  const item = items.find((row) => String(row.id) === String(id));
  if (!item) return items;

  item.qty = Math.max(1, Math.min(99, Number(qty) || 1));
  saveCart(items);
  return items;
}

export function removeFromCart(id) {
  const items = getCart().filter((row) => String(row.id) !== String(id));
  saveCart(items);
  return items;
}

export function clearCart() {
  saveCart([]);
}

export function updateCartBadge() {
  const count = cartCount();
  document.querySelectorAll('[data-cart-badge]').forEach((badge) => {
    badge.textContent = String(count);
    badge.classList.toggle('hidden', count <= 0);
  });
}

export function productFromCard(card) {
  if (!card) return null;
  return {
    id: card.getAttribute('data-product-id'),
    name: card.getAttribute('data-product-name'),
    price: card.getAttribute('data-product-price'),
    img: card.getAttribute('data-product-img'),
    variant: card.getAttribute('data-product-variant') || '',
    inStock: card.getAttribute('data-product-instock') !== '0',
  };
}

export function flashAddButton(btn) {
  if (!btn) return;
  const def = btn.querySelector('[data-cart-default]');
  const added = btn.querySelector('[data-cart-added]');
  const label = btn.querySelector('[data-add-label]');

  if (label) {
    const original = label.textContent;
    label.textContent = 'Added!';
    btn.classList.add('bg-emerald-600');
    btn.classList.remove('bg-primary', 'hover:bg-[#005266]');
    setTimeout(() => {
      label.textContent = original;
      btn.classList.remove('bg-emerald-600');
      btn.classList.add('bg-primary', 'hover:bg-[#005266]');
    }, 1600);
    return;
  }

  if (def && added) {
    def.classList.add('hidden');
    added.classList.remove('hidden');

    const softBtn = btn.classList.contains('bg-primary/10') || btn.classList.contains('text-primary');
    if (softBtn) {
      btn.classList.add('bg-emerald-500', 'text-white');
      btn.classList.remove('bg-primary/10', 'text-primary');
    } else {
      btn.classList.add('bg-emerald-600');
      btn.classList.remove('bg-primary', 'hover:bg-[#005266]');
    }

    setTimeout(() => {
      def.classList.remove('hidden');
      added.classList.add('hidden');
      if (softBtn) {
        btn.classList.remove('bg-emerald-500', 'text-white');
        btn.classList.add('bg-primary/10', 'text-primary');
      } else {
        btn.classList.remove('bg-emerald-600');
        btn.classList.add('bg-primary', 'hover:bg-[#005266]');
      }
    }, 1600);
    return;
  }

  // Icon-only cart button without an "added" icon
  if (def) {
    btn.classList.add('bg-emerald-600');
    btn.classList.remove('bg-primary', 'hover:bg-[#005266]');
    setTimeout(() => {
      btn.classList.remove('bg-emerald-600');
      btn.classList.add('bg-primary', 'hover:bg-[#005266]');
    }, 1600);
  }
}

document.addEventListener('DOMContentLoaded', updateCartBadge);

/** Global add-to-cart via event delegation (avoids double-binding) */
document.addEventListener('click', (e) => {
  const pdpBtn = e.target.closest('[data-product-add-cart]');
  if (pdpBtn) {
    if (pdpBtn.disabled) return;
    e.preventDefault();
    const page = pdpBtn.closest('[data-product-page]');
    if (!page) return;
    const qtyInput = page.querySelector('[data-product-qty]');
    const qty = Number(qtyInput?.value || 1);
    const color = page.querySelector('[data-selected-color]')?.textContent?.trim();
    const storage = page.querySelector('[data-selected-storage]')?.textContent?.trim();
    const variant = [storage, color].filter(Boolean).join(' · ');
    addToCart({
      id: page.getAttribute('data-product-id'),
      name: page.getAttribute('data-product-name'),
      price: page.getAttribute('data-product-price'),
      img: page.getAttribute('data-product-img'),
      variant,
      inStock: page.getAttribute('data-product-instock') !== '0',
    }, qty);
    flashAddButton(pdpBtn);
    return;
  }

  const btn = e.target.closest('[data-add-to-cart]');
  if (!btn || btn.disabled) return;
  e.preventDefault();
  e.stopPropagation();
  const card = btn.closest('[data-product-card], [data-offer-card]');
  const product = productFromCard(card);
  if (!product?.id) return;
  addToCart(product, 1);
  flashAddButton(btn);
});

