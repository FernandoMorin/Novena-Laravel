document.addEventListener('DOMContentLoaded', () => {
    // ========== OVERLAY DE LOGIN / REGISTRO ==========
    const loginForm = document.querySelector('.login-form');
    const registerForm = document.querySelector('.register-form');
    const tLogin = document.querySelector('.login-title-login');
    const tReg = document.querySelector('.login-title-register');

    const showLogin = () => {
        loginForm.style.display = 'block';
        tLogin.style.display = 'block';
        registerForm.style.display = 'none';
        tReg.style.display = 'none';
    };

    const showRegister = () => {
        loginForm.style.display = 'none';
        tLogin.style.display = 'none';
        registerForm.style.display = 'block';
        tReg.style.display = 'block';
    };

    // Cualquier botón con .btn-login o data-open-login abre el overlay (header, carrito...).
    document.querySelectorAll('.btn-login, [data-open-login]').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            if (!loginForm) return;
            showLogin();
            document.body.classList.add('login-open');
        });
    });

    document.querySelector('.login-close')?.addEventListener('click', () => document.body.classList.remove('login-open'));

    document.querySelector('.link-register')?.addEventListener('click', e => {
        e.preventDefault();
        showRegister();
    });

    document.querySelector('.link-back-login')?.addEventListener('click', e => {
        e.preventDefault();
        showLogin();
    });

    // ========== AVISOS (toasts de Bootstrap) ==========
    document.querySelectorAll('.toast').forEach(el => bootstrap.Toast.getOrCreateInstance(el, { delay: 4000 }).show());

    // ========== ANIMACIÓN DE ENTRADA AL HACER SCROLL ==========
    // Los elementos con data-reveal="left|right|up" entran deslizándose cuando aparecen en pantalla.
    const revealables = document.querySelectorAll('[data-reveal]');

    if (!('IntersectionObserver' in window)) {
        revealables.forEach(el => el.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            entry.target.classList.add('is-visible');
            observer.unobserve(entry.target); // solo se anima la primera vez
        });
    }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

    revealables.forEach(el => observer.observe(el));
});
