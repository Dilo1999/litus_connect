/**
 * LITUS Connect cart page interactions
 */
function formatMvr(n) {
    return `MVR ${Number(n).toLocaleString()}`;
}

function initCartPage() {
    const root = document.querySelector('[data-cart-page]');
    if (!root) return;

    let discount = Number(root.getAttribute('data-discount') || 0);
    const delivery = Number(root.getAttribute('data-delivery') || 0);
    const freeThreshold = Number(root.getAttribute('data-free-threshold') || 5000);

    const countEl = root.querySelector('[data-cart-count]');
    const summaryCount = root.querySelector('[data-summary-count]');
    const summarySubtotal = root.querySelector('[data-summary-subtotal]');
    const summaryDiscount = root.querySelector('[data-summary-discount]');
    const summaryDelivery = root.querySelector('[data-summary-delivery]');
    const summaryTotal = root.querySelector('[data-summary-total]');
    const discountRow = root.querySelector('[data-discount-row]');
    const deliveryTitle = root.querySelector('[data-delivery-title]');
    const deliverySub = root.querySelector('[data-delivery-sub]');
    const deliveryProgress = root.querySelector('[data-delivery-progress]');
    const list = root.querySelector('[data-cart-list]');
    const actions = root.querySelector('[data-cart-actions]');
    const headerBadge = document.querySelector('[data-header] a[href*="cart"] span.absolute, header a[href$="/cart"] .absolute');

    function getItems() {
        return [...root.querySelectorAll('[data-cart-item]')];
    }

    function recalc() {
        const items = getItems();
        let subtotal = 0;
        let qtyTotal = 0;

        items.forEach((item) => {
            const price = Number(item.getAttribute('data-price') || 0);
            const input = item.querySelector('[data-qty-input]');
            let qty = Math.max(1, Math.min(99, Number(input?.value || 1)));
            if (input) input.value = String(qty);
            qtyTotal += qty;
            subtotal += price * qty;

            const totalEl = item.querySelector('[data-item-total]');
            if (totalEl) totalEl.textContent = formatMvr(price * qty);
        });

        const appliedDiscount = items.length ? discount : 0;
        const total = Math.max(0, subtotal - appliedDiscount + delivery);
        const eligible = subtotal >= freeThreshold;
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

        if (deliveryTitle) {
            deliveryTitle.textContent = eligible
                ? 'You are eligible for FREE DELIVERY!'
                : 'Almost there for FREE delivery';
        }

        if (deliverySub) {
            deliverySub.textContent = eligible
                ? `Orders over ${formatMvr(freeThreshold)} qualify for free delivery.`
                : `Add ${formatMvr(Math.max(0, freeThreshold - subtotal))} more to unlock free delivery.`;
        }

        // Update header cart badge if present
        document.querySelectorAll('header .absolute.min-w-\\[18px\\], [data-header] [class*="min-w-"]').forEach(() => {});
        const cartLink = document.querySelector('a[href$="/cart"]');
        const badge = cartLink?.querySelector('span.absolute');
        if (badge) badge.textContent = String(qtyTotal);

        if (items.length === 0 && list) {
            list.innerHTML = `
                <div class="px-5 py-16 text-center">
                    <p class="text-base font-bold text-[#011848] mb-1">Your cart is empty</p>
                    <p class="text-sm text-muted-foreground mb-5">Browse our shop and add items you love.</p>
                    <a href="/shop" class="inline-flex items-center gap-2 bg-primary hover:bg-[#0d4fc7] text-white text-sm font-bold px-5 py-2.5 rounded-lg transition-colors">
                        Continue Shopping
                    </a>
                </div>
            `;
            actions?.classList.add('hidden');
            discount = 0;
        }
    }

    root.querySelectorAll('[data-cart-item]').forEach((item) => {
        const minus = item.querySelector('[data-qty-minus]');
        const plus = item.querySelector('[data-qty-plus]');
        const input = item.querySelector('[data-qty-input]');
        const remove = item.querySelector('[data-remove-item]');

        minus?.addEventListener('click', () => {
            const next = Math.max(1, Number(input.value || 1) - 1);
            input.value = String(next);
            recalc();
        });

        plus?.addEventListener('click', () => {
            const next = Math.min(99, Number(input.value || 1) + 1);
            input.value = String(next);
            recalc();
        });

        input?.addEventListener('change', () => recalc());

        remove?.addEventListener('click', () => {
            item.remove();
            recalc();
        });
    });

    root.querySelector('[data-update-cart]')?.addEventListener('click', () => {
        recalc();
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
        recalc();
    });

    // Suggested products slider
    const suggest = root.querySelector('[data-suggest-slider]');
    if (suggest) {
        const track = suggest.querySelector('[data-suggest-track]');
        const prev = suggest.querySelector('[data-suggest-prev]');
        const next = suggest.querySelector('[data-suggest-next]');
        const amount = () => Math.max(track.clientWidth * 0.7, 240);
        prev?.addEventListener('click', () => track?.scrollBy({ left: -amount(), behavior: 'smooth' }));
        next?.addEventListener('click', () => track?.scrollBy({ left: amount(), behavior: 'smooth' }));
    }

    recalc();
}

document.addEventListener('DOMContentLoaded', initCartPage);
