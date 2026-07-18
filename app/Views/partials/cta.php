<?php
$cta_title = $cta_title ?? "Let's get your journey moving.";
$cta_sub   = $cta_sub   ?? 'Book a free consultation today. No obligation — just clear, expert advice on your best route abroad.';
?>
<section class="section">
  <div class="container">
    <div class="cta-band">
      <img class="bg-map" src="<?= asset('img/map.png') ?>" alt="" loading="lazy" decoding="async" />
      <div class="cta-band-inner" data-reveal>
        <span class="overline on-dark">Ready when you are</span>
        <h2 class="h2"><?= e($cta_title) ?></h2>
        <p class="lead"><?= e($cta_sub) ?></p>
        <div class="cta-actions">
          <a href="tel:<?= e(biz('phone_intl')) ?>" class="btn btn--primary btn--lg magnetic">Call <?= e(biz('phone')) ?></a>
          <a href="<?= e(biz('whatsapp')) ?>" target="_blank" rel="noopener" class="btn btn--on-dark btn--lg magnetic">WhatsApp Us</a>
          <a href="<?= url('/contact') ?>" class="btn btn--on-dark btn--lg magnetic">Book consultation</a>
        </div>
      </div>
    </div>
  </div>
</section>
