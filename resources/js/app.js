import Alpine from 'alpinejs';

window.Alpine = Alpine;

document.addEventListener('alpine:init', () => {
    Alpine.store('toast', {
        show: false,
        type: 'success', // 'success' | 'error' | 'warning' | 'info'
        message: '',
        notify(message, type = 'success') {
            this.message = message;
            this.type = type;
            this.show = true;
            setTimeout(() => {
                this.show = false;
            }, 4500);
        },
        close() {
            this.show = false;
        }
    });
});

// Lightweight Scroll-Reveal Controller using native IntersectionObserver
function initScrollObserver() {
    if (!('IntersectionObserver' in window)) {
        document.querySelectorAll('.scroll-reveal').forEach(el => el.classList.add('revealed'));
        return;
    }

    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
                obs.unobserve(entry.target);
            }
        });
    }, {
        root: null,
        rootMargin: '0px 0px -30px 0px',
        threshold: 0.05
    });

    document.querySelectorAll('.scroll-reveal:not(.revealed)').forEach(el => {
        observer.observe(el);
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initScrollObserver);
} else {
    initScrollObserver();
}

window.initScrollObserver = initScrollObserver;

Alpine.start();
