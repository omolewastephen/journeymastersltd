<?php
$ph_eyebrow = 'Where we send people';
$ph_title   = 'Destinations';
$ph_sub     = 'Explore where we help clients study, work, attend conferences and settle.';
$ph_crumbs  = [['label' => 'Destinations']];
require BASE_PATH . '/app/Views/partials/page-hero.php';
?>

<section class="section">
  <div class="container">
    <div class="grid-auto">
      <?php foreach ($destinations as $d): ?>
        <a class="dest-card" href="<?= url('/destinations/' . $d['slug']) ?>" data-reveal>
          <img src="<?= e($d['image']) ?>" alt="<?= e($d['country']) ?>" data-fallback loading="lazy" decoding="async" />
          <div class="dest-body">
            <div class="k"><svg viewBox="0 0 24 24" width="15" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M21 10c0 6-9 12-9 12s-9-6-9-12a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg> <?= e($d['country']) ?></div>
            <h3><?= e($d['title']) ?></h3>
            <div class="dest-meta"><?php foreach (array_slice($d['highlights'], 0, 3) as $h): ?><span><?= e($h) ?></span><?php endforeach; ?></div>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php require BASE_PATH . '/app/Views/partials/cta.php'; ?>
