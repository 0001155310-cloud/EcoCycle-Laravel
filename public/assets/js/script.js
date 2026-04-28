const money = (value) => value.toLocaleString('pt-BR', {style:'currency', currency:'BRL'});

document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-price]').forEach(el => {
    const value = Number(el.dataset.price || 0);
    el.textContent = money(value);
  });

  const qtyInput = document.querySelector('#qty');
  const unitEl = document.querySelector('[data-unit-price]');
  const totalEl = document.querySelector('[data-product-total]');
  if (qtyInput && unitEl && totalEl) {
    const unit = Number(unitEl.dataset.unitPrice || 0);
    const update = () => totalEl.textContent = money(unit * Number(qtyInput.value || 1));
    qtyInput.addEventListener('input', update);
    update();
  }

  const cartForm = document.querySelector('#contactForm, #checkoutForm');
  if (cartForm) {
    cartForm.addEventListener('submit', (e) => {
      e.preventDefault();
      const notice = document.querySelector('.notice');
      if (notice) notice.style.display = 'block';
      cartForm.reset();
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }
});
