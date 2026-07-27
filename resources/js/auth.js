/**
 * Auth pages — password visibility toggle
 */
function initAuthPages() {
  document.querySelectorAll('[data-password-toggle]').forEach((btn) => {
    const wrap = btn.closest('div.relative');
    const input = wrap?.querySelector('[data-password-input]') || wrap?.querySelector('input[type="password"], input[type="text"]');
    const showIcon = btn.querySelector('[data-eye-show]');
    const hideIcon = btn.querySelector('[data-eye-hide]');
    if (!input) return;

    btn.addEventListener('click', () => {
      const isPassword = input.getAttribute('type') === 'password';
      input.setAttribute('type', isPassword ? 'text' : 'password');
      showIcon?.classList.toggle('hidden', isPassword);
      hideIcon?.classList.toggle('hidden', !isPassword);
      btn.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
    });
  });
}

document.addEventListener('DOMContentLoaded', initAuthPages);
