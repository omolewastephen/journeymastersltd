<?php
/** @var array $destination  @var array $services */
$ph_eyebrow = $destination['country'];
$ph_title   = e($destination['title']);
$ph_sub     = $destination['intro'];
$ph_image   = $destination['image'];
$ph_crumbs  = [['label' => 'Destinations', 'href' => '/destinations'], ['label' => $destination['country']]];
require BASE_PATH . '/app/Views/partials/page-hero.php';
?>

<section class="section">
  <div class="container split split--faq">
    <div class="detail-block" data-reveal="left">
      <span class="overline">Highlights</span>
      <h2 class="h2">Why <?= e($destination['country']) ?></h2>
      <ul class="check-list">
        <?php foreach ($destination['highlights'] as $h): ?>
          <li><svg viewBox="0 0 24 24" width="20" fill="none" stroke="currentColor" stroke-width="2.4" aria-hidden="true"><path d="M20 6L9 17l-5-5"/></svg><?= e($h) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div class="detail-block" data-reveal="right">
      <h3 class="h3">General requirements</h3>
      <ul class="req-list">
        <?php foreach ($destination['requirements'] as $r): ?><li><?= e($r) ?></li><?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>

<!-- Gallery -->
<?php if (!empty($destination['gallery'])): ?>
<section class="section-sm">
  <div class="container">
    <div class="gallery-grid" data-reveal>
      <?php foreach ($destination['gallery'] as $img): ?>
        <div class="gallery-item"><img src="<?= e($img) ?>" alt="<?= e($destination['country']) ?>" data-fallback loading="lazy" decoding="async"></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- Related services -->
<section class="section bg-cloud">
  <div class="container">
    <div class="section-intro"><span class="overline" data-reveal>How we help</span><h2 class="h2" data-reveal>Services for <?= e($destination['country']) ?></h2></div>
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
