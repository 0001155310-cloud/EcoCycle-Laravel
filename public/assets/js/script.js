const money = (value) => value.toLocaleString('pt-BR', {style:'currency', currency:'BRL'});

document.addEventListener('DOMContentLoaded', () => {
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('sidebarOverlay');
  const menuToggle = document.getElementById('menuToggle');
  const closeMenu = document.getElementById('closeMenu');

  const openSidebar = () => {
    sidebar?.classList.add('open');
    overlay?.classList.add('on');
    document.body.classList.add('menu-open');
  };

  const closeSidebar = () => {
    sidebar?.classList.remove('open');
    overlay?.classList.remove('on');
    document.body.classList.remove('menu-open');
  };

  menuToggle?.addEventListener('click', openSidebar);
  closeMenu?.addEventListener('click', closeSidebar);
  overlay?.addEventListener('click', closeSidebar);
  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') closeSidebar();
  });

  document.querySelectorAll('.metric-card, .card.card-animate, .project-item').forEach((el, index) => {
    el.animate([
      { opacity: 0, transform: 'translateY(18px)' },
      { opacity: 1, transform: 'translateY(0)' }
    ], {
      duration: 500,
      delay: index * 70,
      fill: 'forwards'
    });
  });

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
