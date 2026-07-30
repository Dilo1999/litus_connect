/**
 * LITUS Connect blog page interactions
 */
function initBlogPage() {
    const root = document.querySelector('[data-blog-page]');
    if (!root) return;

    const cards = [...root.querySelectorAll('[data-blog-card]')];
    const featured = root.querySelector('[data-blog-featured]');
    const searchInput = root.querySelector('[data-blog-search]');
    const countEl = root.querySelector('[data-blog-count]');
    const emptyEl = root.querySelector('[data-blog-empty]');
    const categoryButtons = document.querySelectorAll('[data-blog-category]');
    const tagButtons = document.querySelectorAll('[data-blog-tag]');

    let activeCategory = 'all';
    let activeTag = '';
    let query = '';

    function matches(el) {
        const category = el.getAttribute('data-category') || '';
        const title = el.getAttribute('data-title') || '';
        const tags = el.getAttribute('data-tags') || '';

        if (activeCategory !== 'all' && category !== activeCategory) return false;
        if (activeTag && !tags.includes(activeTag.toLowerCase())) return false;
        if (query && !title.includes(query) && !tags.includes(query) && !category.toLowerCase().includes(query)) {
            return false;
        }
        return true;
    }

    function applyFilters() {
        let visible = 0;

        cards.forEach((card) => {
            const show = matches(card);
            card.classList.toggle('hidden', !show);
            if (show) visible += 1;
        });

        if (featured) {
            featured.classList.toggle('hidden', !matches(featured));
        }

        if (countEl) {
            countEl.textContent = `${visible} article${visible === 1 ? '' : 's'}`;
        }

        if (emptyEl) {
            emptyEl.classList.toggle('hidden', visible > 0);
            emptyEl.classList.toggle('block', visible === 0);
        }
    }

    function setActiveCategory(key) {
        activeCategory = key;
        activeTag = '';
        categoryButtons.forEach((btn) => {
            const active = btn.getAttribute('data-blog-category') === key;
            btn.classList.toggle('bg-blue-light', active);
            btn.classList.toggle('text-primary', active);
            btn.classList.toggle('font-semibold', active);
            btn.classList.toggle('font-medium', !active);
            btn.classList.toggle('text-gray-700', !active);
        });
        tagButtons.forEach((btn) => {
            btn.classList.remove('bg-primary', 'text-white');
            btn.classList.add('bg-[#F3F5F9]', 'text-gray-600');
        });
        applyFilters();
    }

    categoryButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            setActiveCategory(btn.getAttribute('data-blog-category') || 'all');
            closeDrawer();
        });
    });

    tagButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            const tag = btn.getAttribute('data-blog-tag') || '';
            const isActive = activeTag.toLowerCase() === tag.toLowerCase();
            activeTag = isActive ? '' : tag;
            activeCategory = 'all';

            categoryButtons.forEach((c) => {
                const all = c.getAttribute('data-blog-category') === 'all';
                c.classList.toggle('bg-blue-light', all);
                c.classList.toggle('text-primary', all);
                c.classList.toggle('font-semibold', all);
                c.classList.toggle('font-medium', !all);
                c.classList.toggle('text-gray-700', !all);
            });

            tagButtons.forEach((t) => {
                const on = !isActive && t.getAttribute('data-blog-tag') === tag;
                t.classList.toggle('bg-primary', on);
                t.classList.toggle('text-white', on);
                t.classList.toggle('bg-[#F3F5F9]', !on);
                t.classList.toggle('text-gray-600', !on);
            });

            applyFilters();
            closeDrawer();
        });
    });

    if (searchInput) {
        searchInput.addEventListener('input', () => {
            query = searchInput.value.trim().toLowerCase();
            applyFilters();
        });
    }

    // Mobile drawer
    const drawer = document.querySelector('[data-blog-drawer]');
    const openBtn = root.querySelector('[data-blog-mobile-filters]');
    const closeBtn = document.querySelector('[data-blog-drawer-close]');
    const overlay = document.querySelector('[data-blog-drawer-overlay]');

    function openDrawer() {
        if (!drawer) return;
        drawer.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeDrawer() {
        if (!drawer) return;
        drawer.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    openBtn?.addEventListener('click', openDrawer);
    closeBtn?.addEventListener('click', closeDrawer);
    overlay?.addEventListener('click', closeDrawer);
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') closeDrawer();
    });

    // Decorative pagination buttons
    root.querySelectorAll('[data-blog-page-btn]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const value = btn.getAttribute('data-blog-page-btn');
            if (value === 'prev' || value === 'next') return;
            root.querySelectorAll('[data-blog-page-btn]').forEach((b) => {
                const page = b.getAttribute('data-blog-page-btn');
                if (page === 'prev' || page === 'next') return;
                const active = page === value;
                b.classList.toggle('bg-primary', active);
                b.classList.toggle('text-white', active);
                b.classList.toggle('border', !active);
                b.classList.toggle('border-border', !active);
                b.classList.toggle('bg-white', !active);
                b.classList.toggle('text-gray-700', !active);
            });
        });
    });
}

document.addEventListener('DOMContentLoaded', initBlogPage);
