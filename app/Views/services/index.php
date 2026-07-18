<?php
$ph_eyebrow = 'What we do';
$ph_title   = 'Services that clear the way';
$ph_sub     = 'From the first document to the visa stamp, we handle every step — so nothing is left to chance.';
$ph_crumbs  = [['label' => 'Services']];
require BASE_PATH . '/app/Views/partials/page-hero.php';
?>

<section class="section">
  <div class="container">
    <div class="grid-auto">
      <?php foreach ($services as $s): ?>
        <article class="card service-card" data-reveal>
          <div class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><?= $s['icon'] ?></svg></div>
          <h3><?= e($s['title']) ?></h3>
          <p><?= e($s['summary']) ?></p>
          <a href="<?= url('/services/' . $s['slug']) ?>" class="go">Explore service <svg viewBox="0 0 24 24" width="16" fill="none" stroke="currentColor" stroke-width="2.4" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php require BASE_PATH . '/app/Views/partials/cta.php'; ?>
