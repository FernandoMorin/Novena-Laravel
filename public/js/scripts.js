document.addEventListener('DOMContentLoaded', () => {
    const openBtn = document.querySelector('.btn-login');
    const overlay = document.querySelector('.login-overlay');
    const closeBtn = document.querySelector('.login-close');

    const loginForm = document.querySelector('.login-form');
    const registerForm = document.querySelector('.register-form');
    const tLogin = document.querySelector('.login-title-login');
    const tReg = document.querySelector('.login-title-register');

    const open = () => document.body.classList.add('login-open');
    const close = () => document.body.classList.remove('login-open');

    openBtn?.addEventListener('click', e => {
        e.preventDefault();
        open();
        loginForm.style.display = 'block';
        tLogin.style.display = 'block';
        registerForm.style.display = 'none';
        tReg.style.display = 'none';
    });

    closeBtn?.addEventListener('click', close);

    document.querySelector('.link-register')?.addEventListener('click', e => {
        e.preventDefault();
        loginForm.style.display = 'none';
        tLogin.style.display = 'none';
        registerForm.style.display = 'block';
        tReg.style.display = 'block';
    });

    document.querySelector('.link-back-login')?.addEventListener('click', e => {
        e.preventDefault();
        loginForm.style.display = 'block';
        tLogin.style.display = 'block';
        registerForm.style.display = 'none';
        tReg.style.display = 'none';
    });
});
document.addEventListener('DOMContentLoaded', () => {
    // ========== MODAL DE PRODUCTO ==========
    const cards = document.querySelectorAll('.products-grid .product-card');
    const modal = document.getElementById('product-modal');
    const modalImg = document.getElementById('modal-product-image');
    const modalName = document.getElementById('modal-product-name');
    const modalPrice = document.getElementById('modal-product-price');
    const modalDesc = document.getElementById('modal-product-description');
    const modalClose = document.querySelector('.product-modal-close');
    const modalBackdrop = document.querySelector('.product-modal-backdrop');

    const openModal = (card) => {
        if (!modal) return;
        modalImg.src = card.dataset.image || '';
        modalImg.alt = card.dataset.name || '';
        modalName.textContent = card.dataset.name || '';
        modalPrice.textContent = card.dataset.price || '';
        modalDesc.textContent = card.dataset.description || '';

        modal.setAttribute('aria-hidden', 'false');
        modal.classList.add('is-open');
        document.body.classList.add('modal-open');
    };

    const closeModal = () => {
        if (!modal) return;
        modal.setAttribute('aria-hidden', 'true');
        modal.classList.remove('is-open');
        document.body.classList.remove('modal-open');
    };

    cards.forEach(card => {
        card.addEventListener('click', () => openModal(card));
    });

    modalClose?.addEventListener('click', closeModal);
    modalBackdrop?.addEventListener('click', closeModal);

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal?.classList.contains('is-open')) {
            closeModal();
        }
    });
});
