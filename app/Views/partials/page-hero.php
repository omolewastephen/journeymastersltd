<?php
/**
 * Inner-page hero. Expects:
 * $ph_eyebrow, $ph_title, $ph_sub (string), $ph_image (url|null), $ph_crumbs (array<label,href>)
 */
$ph_image  = $ph_image  ?? null;
$ph_crumbs = $ph_crumbs ?? [];
$ph_sub    = $ph_sub    ?? '';
?>
<section class="page-hero<?= $ph_image ? ' page-hero--image' : '' ?>">
  <?php if ($ph_image): ?>
    <img class="page-hero-bg" src="<?= e($ph_image) ?>" alt="" data-fallback fetchpriority="high" decoding="async" />
  <?php endif; ?>
  <span class="hero-glow g1" aria-hidden="true"></span>
  <span class="grain" aria-hidden="true"></span>
  <div class="container page-hero-inner">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="<?= url('/') ?>">Home</a>
      <?php foreach ($ph_crumbs as $crumb): ?>
        <span aria-hidden="true">/</span>
        <?php if (!empty($crumb['href'])): ?>
          <a href="<?= url($crumb['href']) ?>"><?= e($crumb['label']) ?></a>
        <?php else: ?>
          <span aria-current="page"><?= e($crumb['label']) ?></span>
        <?php endif; ?>
      <?php endforeach; ?>
    </nav>
    <span class="overline on-dark" data-reveal><?= e($ph_eyebrow) ?></span>
    <h1 class="h1 page-hero-title" data-reveal><?= $ph_title ?></h1>
    <?php if ($ph_sub !== ''): ?>
      <p class="lead page-hero-sub" data-reveal><?= e($ph_sub) ?></p>
    <?php endif; ?>
  </div>
</section>
