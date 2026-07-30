/**
 * LITUS Connect storefront interactions
 * - Sticky header shadow
 * - Mobile menu
 * - Categories dropdown
 * - Hero slider
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
  const closeButton = menu.querySelector('[data-mobile-menu-close]');
  let previouslyFocused = null;

  const setOpen = (open) => {
    if (open) previouslyFocused = document.activeElement;
    toggle.setAttribute('aria-expanded', String(open));
    menu.classList.toggle('hidden', !open);
    menu.setAttribute('aria-hidden', String(!open));
    iconOpen?.classList.toggle('hidden', open);
    iconClose?.classList.toggle('hidden', !open);
    document.body.classList.toggle('overflow-hidden', open);
    document.documentElement.classList.toggle('overflow-hidden', open);

    if (open) {
      requestAnimationFrame(() => closeButton?.focus());
    } else if (previouslyFocused instanceof HTMLElement) {
      previouslyFocused.focus();
      previouslyFocused = null;
    }
  };

  toggle.addEventListener('click', () => {
    setOpen(toggle.getAttribute('aria-expanded') !== 'true');
  });

  closeButton?.addEventListener('click', () => setOpen(false));

  menu.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', () => setOpen(false));
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') setOpen(false);
  });

  window.addEventListener('resize', () => {
    if (window.innerWidth >= 768) setOpen(false);
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
  let touchStartX = 0;

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

  slider.addEventListener('touchstart', (event) => {
    touchStartX = event.touches[0]?.clientX ?? 0;
  }, { passive: true });

  slider.addEventListener('touchend', (event) => {
    const touchEndX = event.changedTouches[0]?.clientX ?? touchStartX;
    const distance = touchEndX - touchStartX;
    if (Math.abs(distance) < 45) return;
    show(index + (distance < 0 ? 1 : -1));
    start();
  }, { passive: true });

  show(0);
  start();
}

function initBrandSlider() {
  const root = document.querySelector('[data-brands-slider]');
  if (!root) return;

  const track = root.querySelector('[data-brands-track]');
  const prev = root.querySelector('[data-brands-prev]');
  const next = root.querySelector('[data-brands-next]');
  if (!track) return;

  const scrollByAmount = () => Math.max(track.clientWidth * 0.55, 180);

  prev?.addEventListener('click', () => {
    track.scrollBy({ left: -scrollByAmount(), behavior: 'smooth' });
  });

  next?.addEventListener('click', () => {
    track.scrollBy({ left: scrollByAmount(), behavior: 'smooth' });
  });
}

function initPromoSlider() {
  const root = document.querySelector('[data-promo-slider]');
  if (!root) return;

  const track = root.querySelector('[data-promo-track]');
  const slides = [...root.querySelectorAll('[data-promo-slide]')];
  const dots = [...root.querySelectorAll('[data-promo-dot]')];
  if (!track || slides.length < 2) return;

  const mobileQuery = window.matchMedia('(max-width: 767px)');
  const reducedMotionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
  let index = 0;
  let timer;
  let scrollFrame;

  const updateDots = () => {
    dots.forEach((dot, dotIndex) => {
      const active = dotIndex === index;
      dot.classList.toggle('w-6', active);
      dot.classList.toggle('bg-primary', active);
      dot.classList.toggle('w-2', !active);
      dot.classList.toggle('bg-gray-300', !active);
      dot.setAttribute('aria-current', String(active));
    });
  };

  const goTo = (nextIndex, smooth = true) => {
    index = (nextIndex + slides.length) % slides.length;
    const trackRect = track.getBoundingClientRect();
    const slideRect = slides[index].getBoundingClientRect();
    const left = track.scrollLeft + slideRect.left - trackRect.left;
    track.scrollTo({ left, behavior: smooth ? 'smooth' : 'auto' });
    updateDots();
  };

  const stop = () => clearInterval(timer);
  const start = () => {
    stop();
    if (!mobileQuery.matches || reducedMotionQuery.matches || document.hidden) return;
    timer = setInterval(() => goTo(index + 1), 3500);
  };

  dots.forEach((dot) => {
    dot.addEventListener('click', () => {
      goTo(Number(dot.getAttribute('data-promo-dot')));
      start();
    });
  });

  track.addEventListener('scroll', () => {
    cancelAnimationFrame(scrollFrame);
    scrollFrame = requestAnimationFrame(() => {
      const trackCenter = track.getBoundingClientRect().left + track.clientWidth / 2;
      index = slides.reduce((closest, slide, slideIndex) => {
        const rect = slide.getBoundingClientRect();
        const distance = Math.abs(rect.left + rect.width / 2 - trackCenter);
        return distance < closest.distance ? { index: slideIndex, distance } : closest;
      }, { index: 0, distance: Number.POSITIVE_INFINITY }).index;
      updateDots();
    });
  }, { passive: true });

  track.addEventListener('touchstart', stop, { passive: true });
  track.addEventListener('touchend', start, { passive: true });
  track.addEventListener('pointerenter', stop);
  track.addEventListener('pointerleave', start);

  const handleViewportChange = () => {
    if (!mobileQuery.matches) {
      stop();
      track.scrollTo({ left: 0, behavior: 'auto' });
      index = 0;
      updateDots();
      return;
    }
    goTo(index, false);
    start();
  };

  mobileQuery.addEventListener('change', handleViewportChange);
  document.addEventListener('visibilitychange', start);
  handleViewportChange();
}

function initTestimonialsSlider() {
  const root = document.querySelector('[data-testimonials-slider]');
  if (!root) return;

  const track = root.querySelector('[data-testimonials-track]');
  const slides = [...root.querySelectorAll('[data-testimonial-slide]')];
  const dots = [...root.querySelectorAll('[data-testimonial-dot]')];
  if (!track || slides.length < 2) return;

  const mobileQuery = window.matchMedia('(max-width: 767px)');
  const reducedMotionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
  let index = 0;
  let timer;
  let scrollFrame;

  const updateDots = () => {
    dots.forEach((dot, dotIndex) => {
      const active = dotIndex === index;
      dot.classList.toggle('w-6', active);
      dot.classList.toggle('bg-primary', active);
      dot.classList.toggle('w-2', !active);
      dot.classList.toggle('bg-gray-300', !active);
      dot.setAttribute('aria-current', String(active));
    });
  };

  const goTo = (nextIndex, smooth = true) => {
    index = (nextIndex + slides.length) % slides.length;
    const trackRect = track.getBoundingClientRect();
    const slideRect = slides[index].getBoundingClientRect();
    track.scrollTo({
      left: track.scrollLeft + slideRect.left - trackRect.left,
      behavior: smooth ? 'smooth' : 'auto',
    });
    updateDots();
  };

  const stop = () => clearInterval(timer);
  const start = () => {
    stop();
    if (!mobileQuery.matches || reducedMotionQuery.matches || document.hidden) return;
    timer = setInterval(() => goTo(index + 1), 4500);
  };

  dots.forEach((dot) => {
    dot.addEventListener('click', () => {
      goTo(Number(dot.getAttribute('data-testimonial-dot')));
      start();
    });
  });

  track.addEventListener('scroll', () => {
    cancelAnimationFrame(scrollFrame);
    scrollFrame = requestAnimationFrame(() => {
      const trackCenter = track.getBoundingClientRect().left + track.clientWidth / 2;
      index = slides.reduce((closest, slide, slideIndex) => {
        const rect = slide.getBoundingClientRect();
        const distance = Math.abs(rect.left + rect.width / 2 - trackCenter);
        return distance < closest.distance ? { index: slideIndex, distance } : closest;
      }, { index: 0, distance: Number.POSITIVE_INFINITY }).index;
      updateDots();
    });
  }, { passive: true });

  track.addEventListener('touchstart', stop, { passive: true });
  track.addEventListener('touchend', start, { passive: true });
  track.addEventListener('pointerenter', stop);
  track.addEventListener('pointerleave', start);

  const handleViewportChange = () => {
    if (!mobileQuery.matches) {
      stop();
      track.scrollTo({ left: 0, behavior: 'auto' });
      index = 0;
      updateDots();
      return;
    }
    goTo(index, false);
    start();
  };

  mobileQuery.addEventListener('change', handleViewportChange);
  document.addEventListener('visibilitychange', start);
  handleViewportChange();
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
  initPromoSlider();
  initTestimonialsSlider();
  initBrandSlider();
  initNewsletter();
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initStorefront);
} else {
  initStorefront();
}
