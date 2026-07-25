/**
 * TechZone storefront interactions
 * - Sticky header shadow
 * - Mobile menu
 * - Categories dropdown
 * - Hero slider
 * - Product card wishlist / add to cart
 * - Newsletter subscribe
 */

function initHeader() {
  const header = document.querySelector('[data-header]');
  if (!header) return;

  const onScroll = () => {
    const scrolled = window.scrollY > 60;
    header.classList.toggle('shadow-[0_2px_24px_rgba(7,22,46,0.10)]', scrolled);
    header.classList.toggle('border-b', !scrolled);
  };

  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();
}

function initMobileMenu() {
  const toggle = document.querySelector('[data-mobile-menu-toggle]');
  const menu = document.querySelector('[data-mobile-menu]');
  if (!toggle || !menu) return;

  const iconOpen = toggle.querySelector('[data-mobile-menu-icon="open"]');
  const iconClose = toggle.querySelector('[data-mobile-menu-icon="close"]');

  toggle.addEventListener('click', () => {
    const open = toggle.getAttribute('aria-expanded') === 'true';
    const next = !open;
    toggle.setAttribute('aria-expanded', String(next));
    menu.classList.toggle('hidden', !next);
    iconOpen?.classList.toggle('hidden', next);
    iconClose?.classList.toggle('hidden', !next);
  });
}

function initCategoriesDropdown() {
  const root = document.querySelector('[data-categories-dropdown]');
  if (!root) return;

  const toggle = root.querySelector('[data-categories-toggle]');
  const panel = root.querySelector('[data-categories-panel]');
  const chevron = root.querySelector('[data-categories-chevron]');
  if (!toggle || !panel) return;

  const setOpen = (open) => {
    toggle.setAttribute('aria-expanded', String(open));
    panel.classList.toggle('hidden', !open);
    chevron?.classList.toggle('rotate-180', open);
  };

  root.addEventListener('mouseenter', () => setOpen(true));
  root.addEventListener('mouseleave', () => setOpen(false));
  toggle.addEventListener('click', () => {
    const open = toggle.getAttribute('aria-expanded') === 'true';
    setOpen(!open);
  });
}

function initHeroSlider() {
  const slider = document.querySelector('[data-hero-slider]');
  if (!slider) return;

  const slides = [...slider.querySelectorAll('[data-hero-slide]')];
  const dots = [...slider.querySelectorAll('[data-hero-dot]')];
  const prevBtn = slider.querySelector('[data-hero-prev]');
  const nextBtn = slider.querySelector('[data-hero-next]');
  const bgEl = document.getElementById('hero-slide-bgs');
  const backgrounds = bgEl ? JSON.parse(bgEl.textContent || '[]') : [];

  let index = 0;
  let timer;

  const show = (i) => {
    index = (i + slides.length) % slides.length;

    slides.forEach((slide, idx) => {
      slide.classList.toggle('hidden', idx !== index);
      slide.classList.toggle('flex', idx === index);
    });

    dots.forEach((dot, idx) => {
      const active = idx === index;
      dot.classList.toggle('w-8', active);
      dot.classList.toggle('bg-white', active);
      dot.classList.toggle('w-1.5', !active);
      dot.classList.toggle('bg-white/35', !active);
    });

    if (backgrounds[index]) {
      slider.style.background = backgrounds[index];
    }

    const img = slides[index]?.querySelector('[data-hero-image]');
    if (img) {
      img.classList.remove('animate-fade-slide');
      void img.offsetWidth;
      img.classList.add('animate-fade-slide');
    }
  };

  const start = () => {
    clearInterval(timer);
    timer = setInterval(() => show(index + 1), 5000);
  };

  prevBtn?.addEventListener('click', () => {
    show(index - 1);
    start();
  });
  nextBtn?.addEventListener('click', () => {
    show(index + 1);
    start();
  });
  dots.forEach((dot) => {
    dot.addEventListener('click', () => {
      show(Number(dot.getAttribute('data-hero-dot')));
      start();
    });
  });

  show(0);
  start();
}

function initProductCards() {
  document.querySelectorAll('[data-product-card]').forEach((card) => {
    const wishBtn = card.querySelector('[data-wishlist-toggle]');
    const addBtn = card.querySelector('[data-add-to-cart]');

    wishBtn?.addEventListener('click', () => {
      const active = wishBtn.classList.toggle('is-wished');
      wishBtn.classList.toggle('bg-red-50', active);
      wishBtn.classList.toggle('border-red-200', active);
      wishBtn.classList.toggle('text-red-500', active);
      wishBtn.classList.toggle('bg-white', !active);
      wishBtn.classList.toggle('border-border', !active);
      wishBtn.classList.toggle('text-gray-600', !active);
      wishBtn.querySelector('[data-wishlist-icon]')?.classList.toggle('fill-red-500', active);
    });

    addBtn?.addEventListener('click', () => {
      const def = addBtn.querySelector('[data-cart-default]');
      const added = addBtn.querySelector('[data-cart-added]');
      addBtn.classList.add('bg-emerald-500', 'text-white');
      addBtn.classList.remove('bg-primary/10', 'text-primary');
      def?.classList.add('hidden');
      added?.classList.remove('hidden');

      setTimeout(() => {
        addBtn.classList.remove('bg-emerald-500', 'text-white');
        addBtn.classList.add('bg-primary/10', 'text-primary');
        def?.classList.remove('hidden');
        added?.classList.add('hidden');
      }, 1800);
    });
  });
}

function initNewsletter() {
  const root = document.querySelector('[data-newsletter]');
  if (!root) return;

  const form = root.querySelector('[data-newsletter-form]');
  const success = root.querySelector('[data-newsletter-success]');
  const input = root.querySelector('[data-newsletter-email]');
  const submit = root.querySelector('[data-newsletter-submit]');

  const subscribe = () => {
    if (!input?.value.trim()) return;
    form?.classList.add('hidden');
    success?.classList.remove('hidden');
    success?.classList.add('flex');
    input.value = '';
  };

  submit?.addEventListener('click', subscribe);
  input?.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
      e.preventDefault();
      subscribe();
    }
  });
}

function initStorefront() {
  initHeader();
  initMobileMenu();
  initCategoriesDropdown();
  initHeroSlider();
  initProductCards();
  initNewsletter();
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initStorefront);
} else {
  initStorefront();
}
