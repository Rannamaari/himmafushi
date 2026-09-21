const body = document.body;
const header = document.querySelector('[data-site-header]');
const searchOverlay = document.querySelector('[data-search-overlay]');
const searchInput = document.querySelector('#site-search-input');
const mobileNavigation = document.querySelector('[data-mobile-navigation]');
const newsletterPopup = document.querySelector('[data-newsletter-popup]');

const setBodyLock = () => body.classList.toggle('is-locked', !searchOverlay?.hidden || !mobileNavigation?.hidden || !newsletterPopup?.hidden);
const closeDropdowns = () => { document.querySelectorAll('[data-dropdown]').forEach((menu) => { menu.hidden = true; }); document.querySelectorAll('[data-menu-toggle]').forEach((button) => button.setAttribute('aria-expanded', 'false')); };
const closeSearch = () => { if (!searchOverlay) return; searchOverlay.hidden = true; document.querySelector('[data-search-open]')?.setAttribute('aria-expanded', 'false'); setBodyLock(); };
const closeMobileNavigation = () => { if (!mobileNavigation) return; mobileNavigation.hidden = true; document.querySelector('[data-mobile-open]')?.setAttribute('aria-expanded', 'false'); setBodyLock(); };

document.querySelectorAll('[data-menu-toggle]').forEach((button) => button.addEventListener('click', () => { const menu = document.getElementById(button.dataset.menuToggle); const willOpen = menu.hidden; closeDropdowns(); menu.hidden = !willOpen; button.setAttribute('aria-expanded', String(willOpen)); }));
document.querySelector('[data-search-open]')?.addEventListener('click', () => { closeDropdowns(); searchOverlay.hidden = false; document.querySelector('[data-search-open]').setAttribute('aria-expanded', 'true'); setBodyLock(); window.requestAnimationFrame(() => searchInput?.focus()); });
document.querySelector('[data-search-close]')?.addEventListener('click', closeSearch);
document.querySelector('[data-mobile-open]')?.addEventListener('click', () => { mobileNavigation.hidden = false; document.querySelector('[data-mobile-open]').setAttribute('aria-expanded', 'true'); setBodyLock(); });
document.querySelector('[data-mobile-close]')?.addEventListener('click', closeMobileNavigation);
mobileNavigation?.querySelectorAll('a').forEach((link) => link.addEventListener('click', closeMobileNavigation));
document.addEventListener('click', (event) => { if (!event.target.closest('[data-site-header]')) closeDropdowns(); if (event.target === searchOverlay) closeSearch(); });
document.addEventListener('keydown', (event) => { if (event.key === 'Escape') { closeDropdowns(); closeSearch(); closeMobileNavigation(); } });

if (newsletterPopup) {
    const success = newsletterPopup.dataset.newsletterSuccess === 'true';
    const errors = newsletterPopup.dataset.newsletterErrors === 'true';
    const dismissedAt = Number(localStorage.getItem('newsletter:dismissed-at') || 0);
    const recentlyDismissed = Date.now() - dismissedAt < 7 * 24 * 60 * 60 * 1000;
    const alreadySubscribed = localStorage.getItem('newsletter:subscribed') === 'true';
    const openNewsletter = () => { newsletterPopup.hidden = false; setBodyLock(); window.requestAnimationFrame(() => newsletterPopup.querySelector('input[type="email"]')?.focus()); };
    const closeNewsletter = () => { newsletterPopup.hidden = true; localStorage.setItem('newsletter:dismissed-at', String(Date.now())); setBodyLock(); };

    if (success) {
        localStorage.setItem('newsletter:subscribed', 'true');
        openNewsletter();
    } else if (errors) {
        openNewsletter();
    } else if (!alreadySubscribed && !recentlyDismissed) {
        window.setTimeout(openNewsletter, 4500);
    }

    newsletterPopup.querySelector('[data-newsletter-close]')?.addEventListener('click', closeNewsletter);
    newsletterPopup.addEventListener('click', (event) => { if (event.target === newsletterPopup) closeNewsletter(); });
    document.addEventListener('keydown', (event) => { if (event.key === 'Escape' && !newsletterPopup.hidden) closeNewsletter(); });
}

const navigation = document.querySelector('[data-desktop-nav]');
const indicator = document.querySelector('[data-nav-indicator]');
const positionIndicator = (link) => { if (!navigation || !indicator || !link) return; const navBox = navigation.getBoundingClientRect(); const linkBox = link.getBoundingClientRect(); indicator.style.width = `${linkBox.width}px`; indicator.style.transform = `translateX(${linkBox.left - navBox.left}px)`; indicator.classList.add('is-visible'); };
const activeLink = navigation?.querySelector('.is-active');
positionIndicator(activeLink);
navigation?.querySelectorAll('.desktop-nav-link').forEach((link) => link.addEventListener('mouseenter', () => positionIndicator(link)));
navigation?.addEventListener('mouseleave', () => activeLink ? positionIndicator(activeLink) : indicator?.classList.remove('is-visible'));
const updateHeader = () => header?.classList.toggle('is-scrolled', window.scrollY > 64);
window.addEventListener('scroll', updateHeader, { passive: true });
window.addEventListener('resize', () => positionIndicator(navigation?.querySelector('.is-active')));
updateHeader();

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
const observedAds = document.querySelectorAll('[data-ad-impression]');
if (observedAds.length && 'IntersectionObserver' in window) {
    const adObserver = new IntersectionObserver((entries) => entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        const element = entry.target;
        const storageKey = `ad-viewed:${element.dataset.adKey}`;
        if (!sessionStorage.getItem(storageKey)) {
            sessionStorage.setItem(storageKey, '1');
            fetch(element.dataset.adImpression, { method: 'POST', credentials: 'same-origin', headers: { 'X-CSRF-TOKEN': csrfToken, Accept: 'application/json' } }).catch(() => sessionStorage.removeItem(storageKey));
        }
        adObserver.unobserve(element);
    }), { threshold: .5 });
    observedAds.forEach((advertisement) => adObserver.observe(advertisement));
}
