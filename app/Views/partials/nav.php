<?php
$links = [
    '/services'     => 'Services',
    '/destinations' => 'Destinations',
    '/about'        => 'About',
    '/blog'         => 'Insights',
];
?>
<header class="nav" id="nav">
  <div class="container nav-inner">
    <a href="<?= url('/') ?>" class="nav-logo" aria-label="<?= e(config('business.legal_name')) ?> — home">
      <img src="<?= asset('img/logo-white.png') ?>" alt="<?= e(config('business.legal_name')) ?>" class="logo-light" />
      <img src="<?= asset('img/logo.png') ?>" alt="<?= e(config('business.legal_name')) ?>" class="logo-dark" />
    </a>

    <nav aria-label="Primary">
      <ul class="nav-links">
        <?php foreach ($links as $href => $label): ?>
          <li><a href="<?= url($href) ?>"<?= nav_current($href) ?>><?= e($label) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </nav>

    <div class="nav-cta">
      <a href="tel:<?= e(biz('phone_intl')) ?>" class="nav-phone">
        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.9.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
        <?= e(biz('phone')) ?>
      </a>
      <a href="<?= url('/contact') ?>" class="btn btn--primary btn--sm magnetic">Free Consultation</a>
      <button class="nav-burger" id="burger" aria-label="Open menu" aria-expanded="false"><span></span></button>
    </div>
  </div>
</header>

<div class="drawer" id="drawer">
  <div class="drawer-scrim" data-close></div>
  <div class="drawer-panel" role="dialog" aria-modal="true" aria-label="Menu">
    <div class="drawer-head">
      <img src="<?= asset('img/logo.png') ?>" alt="" />
      <button class="drawer-close" data-close aria-label="Close menu">&times;</button>
    </div>
    <?php foreach ($links as $href => $label): ?>
      <a href="<?= url($href) ?>" data-close><?= e($label) ?></a>
    <?php endforeach; ?>
    <a href="<?= url('/contact') ?>" class="btn btn--primary" data-close>Free Consultation</a>
    <a href="<?= e(biz('whatsapp')) ?>" target="_blank" rel="noopener" class="btn btn--ghost">WhatsApp Us</a>
  </div>
</div>
