<?php
/** @var array $stats  @var array $process */
$ph_eyebrow = 'About us';
$ph_title   = 'A credibility partner for the journey abroad';
$ph_sub     = 'Journey Masters Ltd helps Nigerians study, work and travel abroad with confidence — from proof of funds to the visa stamp.';
$ph_crumbs  = [['label' => 'About']];
require BASE_PATH . '/app/Views/partials/page-hero.php';
?>

<!-- Story -->
<section class="section">
  <div class="container split split--media">
    <div class="about-media" data-reveal="left">
      <div class="media-frame"><img class="about-img" src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1100&q=80" alt="The team at work" data-fallback loading="lazy" decoding="async" /></div>
      <div class="card float-stat"><div class="mini-stat"><span class="ico"><svg viewBox="0 0 24 24" width="22" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 2l8 4v6c0 5-3.5 8-8 10-4.5-2-8-5-8-10V6z"/><path d="M9 12l2 2 4-4"/></svg></span><div><div class="v">Since <?= e((string) biz('founded')) ?></div><div class="l">serving travellers</div></div></div></div>
    </div>
    <div class="about-copy" data-reveal="right">
      <span class="overline">Our story</span>
      <h2 class="h2">Built to get the details right</h2>
      <p>Relocation is one of the biggest decisions a person makes — and one wrong document can cost a year. We founded Journey Masters Ltd in <?= e((string) biz('founded')) ?>, in <?= e(biz('city')) ?>, to give people a steady, expert hand through the process.</p>
      <p>Today we're trusted for high-stakes travel and migration: proof of funds, study admissions, work permits and visas for Canada, the UK, Europe and New Zealand — handled end to end.</p>
      <a href="<?= url('/contact') ?>" class="btn btn--dark magnetic">Talk to us</a>
    </div>
  </div>
</section>

<!-- Mission / Vision / Values -->
<section class="section bg-cloud">
  <div class="container">
    <div class="section-intro"><span class="overline" data-reveal>What drives us</span><h2 class="h2" data-reveal>Mission, vision &amp; values</h2></div>
    <div class="grid-auto">
      <article class="card value-card" data-reveal>
        <div class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="4"/><circle cx="12" cy="12" r="0.6" fill="currentColor"/></svg></div>
        <h3>Mission</h3>
        <p>To make travelling, studying and working abroad accessible and stress-free — with honest, expert guidance every step of the way.</p>
      </article>
      <article class="card value-card" data-reveal>
        <div class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg></div>
        <h3>Vision</h3>
        <p>To be the most trusted travel and migration partner in Nigeria — the name people recommend to family and friends.</p>
      </article>
      <article class="card value-card" data-reveal>
        <div class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 2l8 4v6c0 5-3.5 8-8 10-4.5-2-8-5-8-10V6z"/><path d="M9 12l2 2 4-4"/></svg></div>
        <h3>Values</h3>
        <p>Integrity, transparency and genuine care. We never cut corners and never over-promise — your success is our reputation.</p>
      </article>
    </div>
  </div>
</section>

<!-- Stats -->
<section class="section stats-band" aria-label="Track record">
  <img class="bg-map" src="<?= asset('img/map.png') ?>" alt="" loading="lazy" decoding="async" />
  <div class="container">
    <div class="stats-grid">
      <?php foreach ($stats as $stat): ?>
        <div class="stat" data-reveal><div class="num" data-count="<?= (int) $stat['value'] ?>">0<span class="suf"><?= e($stat['suffix']) ?></span></div><div class="lbl"><?= e($stat['label']) ?></div></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Process -->
<section class="section section--dark">
  <div class="container">
    <div class="section-intro"><span class="overline on-dark" data-reveal>How we work</span><h2 class="h2" data-reveal>Four calm steps from enquiry to departure.</h2></div>
    <div class="grid-auto steps">
      <?php foreach ($process as $step): ?>
        <div class="step" data-reveal><span class="idx"><?= e($step['n']) ?></span><h3><?= e($step['title']) ?></h3><p><?= e($step['desc']) ?></p></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php require BASE_PATH . '/app/Views/partials/cta.php'; ?>
