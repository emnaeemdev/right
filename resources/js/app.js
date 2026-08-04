import './bootstrap';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

document.addEventListener('DOMContentLoaded', () => {
    initHeroAnimation();
    initScrollReveals();
    initCounters();
    initTimeline();
    initMobileNav();
    initMobileAboutMenu();
    initNavDropdown();
    initContentTabs();
});

function initHeroAnimation() {
    const checkPath = document.querySelector('#hero-check-path');
    if (!checkPath) return;

    const length = checkPath.getTotalLength();
    checkPath.style.strokeDasharray = length;
    checkPath.style.strokeDashoffset = length;

    gsap.to(checkPath, {
        strokeDashoffset: 0,
        duration: 1.5,
        ease: 'power2.inOut',
        delay: 0.3,
    });

    gsap.from('.hero-text > *', {
        opacity: 0,
        y: 30,
        duration: 0.8,
        stagger: 0.15,
        ease: 'power2.out',
        delay: 0.2,
    });
}

function initScrollReveals() {
    document.querySelectorAll('.reveal').forEach((el) => {
        ScrollTrigger.create({
            trigger: el,
            start: 'top 85%',
            onEnter: () => el.classList.add('reveal-visible'),
            once: true,
        });
    });
}

function initCounters() {
    document.querySelectorAll('[data-counter]').forEach((el) => {
        const target = parseInt(el.dataset.counter, 10);
        const obj = { val: 0 };

        ScrollTrigger.create({
            trigger: el,
            start: 'top 85%',
            onEnter: () => {
                gsap.to(obj, {
                    val: target,
                    duration: 2,
                    ease: 'power1.out',
                    onUpdate: () => {
                        el.textContent = Math.round(obj.val).toLocaleString();
                    },
                });
            },
            once: true,
        });
    });
}

function initTimeline() {
    const line = document.querySelector('#timeline-progress');
    if (!line) return;

    gsap.fromTo(line, { scaleX: 0 }, {
        scaleX: 1,
        ease: 'none',
        scrollTrigger: {
            trigger: '#process-timeline',
            start: 'top 70%',
            end: 'bottom 40%',
            scrub: 1,
        },
    });
}

function initMobileNav() {
    const toggle = document.getElementById('mobile-nav-toggle');
    const menu = document.getElementById('mobile-nav-menu');
    if (!toggle || !menu) return;

    toggle.addEventListener('click', () => {
        menu.classList.toggle('hidden');
        toggle.setAttribute('aria-expanded', menu.classList.contains('hidden') ? 'false' : 'true');
    });
}

function initMobileAboutMenu() {
    const toggle = document.getElementById('mobile-about-toggle');
    const submenu = document.getElementById('mobile-about-submenu');
    const chevron = document.querySelector('[data-mobile-about-chevron]');

    if (!toggle || !submenu) return;

    toggle.addEventListener('click', () => {
        const isHidden = submenu.classList.toggle('hidden');
        toggle.setAttribute('aria-expanded', isHidden ? 'false' : 'true');
        chevron?.classList.toggle('rotate-180', !isHidden);
    });
}

function initNavDropdown() {
    document.querySelectorAll('[data-nav-dropdown]').forEach((dropdown) => {
        const toggle = dropdown.querySelector('.nav-dropdown-toggle');

        if (!toggle) return;

        toggle.addEventListener('click', (event) => {
            event.preventDefault();
            event.stopPropagation();

            const isOpen = dropdown.classList.toggle('is-open');
            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');

            document.querySelectorAll('[data-nav-dropdown].is-open').forEach((other) => {
                if (other === dropdown) return;

                other.classList.remove('is-open');
                other.querySelector('.nav-dropdown-toggle')?.setAttribute('aria-expanded', 'false');
            });
        });
    });

    document.addEventListener('click', () => {
        document.querySelectorAll('[data-nav-dropdown].is-open').forEach((dropdown) => {
            dropdown.classList.remove('is-open');
            dropdown.querySelector('.nav-dropdown-toggle')?.setAttribute('aria-expanded', 'false');
        });
    });

    document.addEventListener('keydown', (event) => {
        if (event.key !== 'Escape') return;

        document.querySelectorAll('[data-nav-dropdown].is-open').forEach((dropdown) => {
            dropdown.classList.remove('is-open');
            dropdown.querySelector('.nav-dropdown-toggle')?.setAttribute('aria-expanded', 'false');
        });
    });
}

function initContentTabs() {
    document.querySelectorAll('.content-tabs[role="tablist"]').forEach((tablist) => {
        const tabs = tablist.querySelectorAll('[data-content-tab]');
        const panels = document.querySelectorAll('[data-content-panel]');

        if (!tabs.length || !panels.length) return;

        const activate = (name) => {
            tabs.forEach((tab) => {
                const isActive = tab.dataset.contentTab === name;
                tab.classList.toggle('is-active', isActive);
                tab.setAttribute('aria-selected', isActive ? 'true' : 'false');
            });

            panels.forEach((panel) => {
                const isActive = panel.dataset.contentPanel === name;
                panel.classList.toggle('hidden', !isActive);
                panel.classList.toggle('is-active', isActive);
                panel.toggleAttribute('hidden', !isActive);
            });

            if (name === 'videos') {
                history.replaceState(null, '', '#videos');
            } else if (window.location.hash === '#videos') {
                history.replaceState(null, '', window.location.pathname);
            }
        };

        tabs.forEach((tab) => {
            tab.addEventListener('click', () => activate(tab.dataset.contentTab));
        });

        if (window.location.hash === '#videos') {
            activate('videos');
        }
    });
}
