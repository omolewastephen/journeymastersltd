/* =============================================================================
   JOURNEY MASTERS LTD — Interaction layer
   Lenis smooth scroll · GSAP reveals + route-line plane · counters · Swiper · nav
   Degrades gracefully: if a library is missing or reduced-motion is on,
   content is fully visible and usable.
   ============================================================================= */
(function () {
  'use strict';

  const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const hasGSAP = typeof window.gsap !== 'undefined';
  const FLAT = /[?&](flat|debug)/.test(location.search); // static render for screenshots/QA
  const $  = (s, c = document) => c.querySelector(s);
  const $$ = (s, c = document) => Array.from((c || document).querySelectorAll(s));

  /* ---------------------------------------------------------------- Loader -- */
  function runLoader() {
    const loader = $('#loader');
    const bar = $('#loaderBar');
    if (!loader) return Promise.resolve();
    return new Promise((resolve) => {
      if (prefersReduced || !hasGSAP || FLAT) {
        loader.style.display = 'none';
        return resolve();
      }
      gsap.timeline({ onComplete: resolve })
        .to(bar, { width: '100%', duration: 1.0, ease: 'power2.inOut' })
        .to(loader, { yPercent: -100, duration: 0.7, ease: 'power4.inOut' }, '+=0.1')
        .set(loader, { display: 'none' });
    });
  }

  /* --------------------------------------------------------- Smooth scroll -- */
  function initLenis() {
    if (prefersReduced || typeof window.Lenis === 'undefined') return null;
    const lenis = new Lenis({ duration: 1.1, easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)), smoothWheel: true });
    function raf(time) { lenis.raf(time); requestAnimationFrame(raf); }
    requestAnimationFrame(raf);
    if (hasGSAP && window.ScrollTrigger) {
      lenis.on('scroll', ScrollTrigger.update);
      gsap.ticker.add((t) => lenis.raf(t * 1000));
      gsap.ticker.lagSmoothing(0);
    }
    // Anchor links → lenis
    $$('a[href^="#"]').forEach((a) => {
      a.addEventListener('click', (e) => {
        const id = a.getAttribute('href');
        if (id.length > 1 && $(id)) { e.preventDefault(); lenis.scrollTo(id, { offset: -80 }); }
      });
    });
    return lenis;
  }

  /* ------------------------------------------------------------ Nav state -- */
  function initNav() {
    const nav = $('#nav');
    const prog = $('#scrollProg');
    const onScroll = () => {
      nav.classList.toggle('is-stuck', window.scrollY > 40);
      if (prog) {
        const h = document.documentElement.scrollHeight - window.innerHeight;
        prog.style.width = (h > 0 ? Math.min(window.scrollY / h, 1) * 100 : 0) + '%';
      }
    };
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });

    // Mobile drawer
    const burger = $('#burger');
    const drawer = $('#drawer');
    const open = () => { drawer.classList.add('open'); burger.setAttribute('aria-expanded', 'true'); document.body.style.overflow = 'hidden'; };
    const close = () => { drawer.classList.remove('open'); burger.setAttribute('aria-expanded', 'false'); document.body.style.overflow = ''; };
    burger && burger.addEventListener('click', open);
    $$('[data-close]', drawer).forEach((el) => el.addEventListener('click', close));
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') close(); });

    // Scrollspy → active nav link
    const links = new Map($$('.nav-links a').map((a) => [a.getAttribute('href').slice(1), a]));
    const sections = ['services', 'destinations', 'process', 'about', 'blog'].map((id) => $('#' + id)).filter(Boolean);
    if (window.IntersectionObserver && sections.length) {
      const spy = new IntersectionObserver((entries) => {
        entries.forEach((e) => {
          if (e.isIntersecting) {
            $$('.nav-links a[aria-current]').forEach((a) => a.removeAttribute('aria-current'));
            const link = links.get(e.target.id);
            if (link) link.setAttribute('aria-current', 'true');
          }
        });
      }, { rootMargin: '-45% 0px -50% 0px' });
      sections.forEach((s) => spy.observe(s));
    }
  }

  /* ---------------------------------------------------- Broken-image guard -- */
  function initImageFallbacks() {
    $$('img[data-fallback]').forEach((img) => {
      img.addEventListener('error', () => {
        const host = img.closest('.dest-card') || img.parentElement;
        img.style.display = 'none';
        if (host && host.classList.contains('dest-card')) host.classList.add('noimg');
        else if (host) host.style.background = 'linear-gradient(135deg,#0a1466,#020255)';
      });
    });
  }

  /* ----------------------------------------------- Reveals: set + animate -- */
  // prepStates runs while the loader still covers the page, so reveal targets are
  // hidden BEFORE they can flash. initReveals then animates them to their natural
  // state — never 0 -> 0, and no-JS users always see everything (nothing hidden by CSS).
  function prepStates() {
    if (prefersReduced || !hasGSAP || FLAT) return;
    gsap.set($$('[data-hero]'), { y: 40, opacity: 0 });
    $$('[data-reveal]').forEach((el) => {
      const t = el.getAttribute('data-reveal');
      const v = { opacity: 0, y: 40 };
      if (t === 'left') { v.x = -46; v.y = 0; }
      else if (t === 'right') { v.x = 46; v.y = 0; }
      else if (t === 'scale') { v.scale = 0.94; v.y = 0; }
      else if (t === 'blur') { v.filter = 'blur(14px)'; v.y = 24; }
      gsap.set(el, v);
    });
  }

  function initReveals() {
    if (prefersReduced || !hasGSAP || !window.ScrollTrigger || FLAT) {
      $$('[data-reveal],[data-hero]').forEach((el) => el.classList.add('reveal-in'));
      return;
    }
    gsap.registerPlugin(ScrollTrigger);

    // Hero intro (states already set by prepStates)
    const heroItems = $$('[data-hero]').sort((a, b) => a.dataset.hero - b.dataset.hero);
    gsap.to(heroItems, { y: 0, opacity: 1, duration: 1, ease: 'power3.out', stagger: 0.12, delay: 0.15 });

    // Scroll reveals — animate only the props prepStates set, back to natural
    $$('[data-reveal]').forEach((el) => {
      const t = el.getAttribute('data-reveal');
      const to = { opacity: 1, duration: 0.9, ease: 'power3.out', scrollTrigger: { trigger: el, start: 'top 85%' } };
      if (t === 'left' || t === 'right') to.x = 0;
      else if (t === 'scale') to.scale = 1;
      else if (t === 'blur') { to.filter = 'blur(0px)'; to.y = 0; }
      else to.y = 0;
      gsap.to(el, to);
    });

    // Parallax hero image
    const heroImg = $('#heroImg');
    if (heroImg) gsap.to(heroImg, { yPercent: 12, ease: 'none', scrollTrigger: { trigger: '.hero', start: 'top top', end: 'bottom top', scrub: true } });
  }

  /* --------------------------------------------------- Route line + plane -- */
  function initRouteLine() {
    const path = $('#routePath');
    const plane = $('#routePlane');
    if (!path) return;
    const len = path.getTotalLength();
    path.style.strokeDasharray = len;
    path.style.strokeDashoffset = len;

    if (prefersReduced || !hasGSAP || !window.ScrollTrigger) { path.style.strokeDashoffset = 0; return; }
    gsap.registerPlugin(ScrollTrigger, MotionPathPlugin);

    // Draw the line as the hero enters view
    gsap.to(path, { strokeDashoffset: 0, duration: 2.4, ease: 'power2.inOut', delay: 0.5 });

    // Fly the plane along the path (starts hidden via opacity="0" in the SVG,
    // so it never flashes at the viewBox origin before MotionPath aligns it)
    if (plane && window.MotionPathPlugin) {
      gsap.to(plane, { opacity: 1, duration: 0.3, delay: 0.5 });
      gsap.to(plane, {
        duration: 2.4, delay: 0.5, ease: 'power2.inOut',
        motionPath: { path: path, align: path, alignOrigin: [0.5, 0.5], autoRotate: true },
      });
    }
  }

  /* ----------------------------------------------------------- Counters ---- */
  function initCounters() {
    const nums = $$('[data-count]');
    if (!nums.length) return;
    const animate = (el) => {
      const target = parseInt(el.getAttribute('data-count'), 10);
      const suffix = el.querySelector('.suf') ? el.querySelector('.suf').outerHTML : '';
      const dur = 1800; const start = performance.now();
      const step = (now) => {
        const p = Math.min((now - start) / dur, 1);
        const eased = 1 - Math.pow(1 - p, 3);
        const val = Math.round(target * eased).toLocaleString('en-US');
        el.innerHTML = val + suffix;
        if (p < 1) requestAnimationFrame(step);
      };
      requestAnimationFrame(step);
    };
    if (prefersReduced || !window.IntersectionObserver) { nums.forEach(animate); return; }
    const io = new IntersectionObserver((entries) => {
      entries.forEach((e) => { if (e.isIntersecting) { animate(e.target); io.unobserve(e.target); } });
    }, { threshold: 0.5 });
    nums.forEach((n) => io.observe(n));
  }

  /* ------------------------------------------------------------- Swiper ----- */
  function initSwiper() {
    if (typeof window.Swiper === 'undefined' || !$('.testimonials')) return;
    new Swiper('.testimonials', {
      slidesPerView: 1, spaceBetween: 24, grabCursor: true,
      pagination: { el: '.swiper-pagination', clickable: true },
      autoplay: prefersReduced ? false : { delay: 5000, disableOnInteraction: false },
      breakpoints: { 720: { slidesPerView: 2 }, 1080: { slidesPerView: 3 } },
    });
  }

  /* ------------------------------------------------------------- FAQ -------- */
  // Native <details>/<summary> handles clicks, keyboard and AT by itself;
  // JS only adds accordion behaviour (opening one closes the others).
  function initFaq() {
    const faqs = $$('.faq');
    faqs.forEach((d) => {
      d.addEventListener('toggle', () => {
        if (d.open) faqs.forEach((o) => { if (o !== d && o.open) o.open = false; });
      });
    });
  }

  /* -------------------------------------------------------- Newsletter ------ */
  function initNewsletter() {
    const form = $('#newsForm');
    if (!form) return;
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      const input = $('input[type="email"]', form);
      const btn = $('button[type="submit"]', form);
      if (input && !input.checkValidity()) { input.reportValidity(); return; }
      if (btn) { btn.textContent = 'Subscribed ✓'; btn.disabled = true; }
      if (input) input.disabled = true;
    });
  }

  /* --------------------------------------------------------- Magnetic btns -- */
  function initMagnetic() {
    if (prefersReduced || !hasGSAP || window.matchMedia('(pointer: coarse)').matches) return;
    $$('.magnetic').forEach((el) => {
      el.addEventListener('mousemove', (e) => {
        const r = el.getBoundingClientRect();
        const x = e.clientX - r.left - r.width / 2;
        const y = e.clientY - r.top - r.height / 2;
        gsap.to(el, { x: x * 0.3, y: y * 0.4, duration: 0.6, ease: 'power3.out' });
      });
      el.addEventListener('mouseleave', () => gsap.to(el, { x: 0, y: 0, duration: 0.6, ease: 'elastic.out(1,0.4)' }));
    });
  }

  /* -------------------------------------------------- Hero glow parallax --- */
  function initHeroParallax() {
    if (prefersReduced || !hasGSAP) return;
    const hero = $('.hero');
    const g1 = $('#glow1'), g2 = $('#glow2');
    const floats = $$('.float-el');

    // Idle drift (px props) — composes with mouse (percent props) without conflict
    if (g1) gsap.to(g1, { x: -22, y: 26, duration: 7, ease: 'sine.inOut', repeat: -1, yoyo: true });
    if (g2) gsap.to(g2, { x: 18, y: -22, duration: 8, ease: 'sine.inOut', repeat: -1, yoyo: true });
    floats.forEach((f, i) => gsap.to(f, { y: i % 2 ? 12 : -12, duration: 4 + i, ease: 'sine.inOut', repeat: -1, yoyo: true }));

    // Mouse parallax (percent props)
    if (hero && !window.matchMedia('(pointer: coarse)').matches) {
      hero.addEventListener('mousemove', (e) => {
        const cx = e.clientX / window.innerWidth - 0.5;
        const cy = e.clientY / window.innerHeight - 0.5;
        if (g1) gsap.to(g1, { xPercent: cx * 34, yPercent: cy * 34, duration: 1, overwrite: 'auto' });
        if (g2) gsap.to(g2, { xPercent: -cx * 26, yPercent: -cy * 26, duration: 1, overwrite: 'auto' });
        floats.forEach((f) => {
          const d = parseFloat(f.dataset.float) || 0.06;
          gsap.to(f, { xPercent: cx * d * 260, yPercent: cy * d * 260, duration: 1, overwrite: 'auto' });
        });
      });
    }
  }

  /* -------------------------------------------------------------- Boot ------ */
  function boot() {
    $('#year') && ($('#year').textContent = new Date().getFullYear());
    initNav();
    initImageFallbacks();
    initFaq();
    initNewsletter();
    initCounters();
    initSwiper();
    initReveals();
    initRouteLine();
    initMagnetic();
    initHeroParallax();
    initLenis();
  }

  document.addEventListener('DOMContentLoaded', () => {
    if (FLAT) { const h = $('.hero'); if (h) h.style.minHeight = '680px'; } // QA: stop 100svh filling tall capture windows
    prepStates();                 // hide reveal/hero targets while loader covers the page
    runLoader().then(boot);
  });
})();
