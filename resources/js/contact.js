/**
 * LITUS Connect contact page — FAQ accordion
 */
function initContactFaq() {
    const root = document.querySelector('[data-contact-page]');
    if (!root) return;

    root.querySelectorAll('[data-faq-item]').forEach((item) => {
        const toggle = item.querySelector('[data-faq-toggle]');
        const panel = item.querySelector('[data-faq-panel]');
        const chevron = item.querySelector('[data-faq-chevron]');
        if (!toggle || !panel) return;

        const sync = (open) => {
            item.setAttribute('data-open', String(open));
            panel.classList.toggle('hidden', !open);
            chevron?.classList.toggle('rotate-180', open);
        };

        sync(item.getAttribute('data-open') === 'true');

        toggle.addEventListener('click', () => {
            const willOpen = item.getAttribute('data-open') !== 'true';

            root.querySelectorAll('[data-faq-item]').forEach((other) => {
                if (other === item) return;
                other.setAttribute('data-open', 'false');
                other.querySelector('[data-faq-panel]')?.classList.add('hidden');
                other.querySelector('[data-faq-chevron]')?.classList.remove('rotate-180');
            });

            sync(willOpen);
        });
    });
}

document.addEventListener('DOMContentLoaded', initContactFaq);
