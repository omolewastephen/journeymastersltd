<?php
$ph_eyebrow = 'Insights';
$ph_title   = 'Guides &amp; travel intelligence';
$ph_sub     = 'Practical, honest guidance on study abroad, visas, work permits and proof of funds.';
$ph_crumbs  = [['label' => 'Insights']];
require BASE_PATH . '/app/Views/partials/page-hero.php';
?>

<section class="section">
  <div class="container">
    <div class="grid-auto">
      <?php foreach ($posts as $p): ?>
        <a class="card post-card" href="<?= url('/blog/' . $p['slug']) ?>" data-reveal>
          <div class="thumb"><img src="<?= e($p['image']) ?>" alt="" data-fallback loading="lazy" decoding="async"></div>
          <div class="body"><div class="meta"><?= e($p['category']) ?> · <?= e($p['read']) ?></div><h3><?= e($p['title']) ?></h3><p class="excerpt"><?= e($p['excerpt']) ?></p></div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php require BASE_PATH . '/app/Views/partials/cta.php'; ?>
