<?php
/** @var array $service  @var array $others */
$ph_eyebrow = 'Service';
$ph_title   = e($service['title']);
$ph_sub     = $service['tagline'];
$ph_image   = $service['image'];
$ph_crumbs  = [['label' => 'Services', 'href' => '/services'], ['label' => $service['title']]];
require BASE_PATH . '/app/Views/partials/page-hero.php';
?>

<section class="section">
  <div class="container detail-layout">
    <div class="detail-main">
      <!-- Overview -->
      <div class="prose" data-reveal>
        <span class="overline">Overview</span>
        <h2 class="h2">What this covers</h2>
        <?php foreach ($service['overview'] as $p): ?><p><?= e($p) ?></p><?php endforeach; ?>
      </div>

      <!-- Benefits -->
      <div class="detail-block" data-reveal>
        <h3 class="h3">What you get</h3>
        <ul class="check-list">
          <?php foreach ($service['benefits'] as $b): ?>
            <li><svg viewBox="0 0 24 24" width="20" fill="none" stroke="currentColor" stroke-width="2.4" aria-hidden="true"><path d="M20 6L9 17l-5-5"/></svg><?= e($b) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <!-- Requirements -->
      <div class="detail-block" data-reveal>
        <h3 class="h3">What you'll need</h3>
        <ul class="req-list">
          <?php foreach ($service['requirements'] as $r): ?><li><?= e($r) ?></li><?php endforeach; ?>
        </ul>
      </div>

      <!-- Timeline -->
      <div class="detail-block" data-reveal>
        <h3 class="h3">How it works</h3>
        <ol class="timeline">
          <?php foreach ($service['timeline'] as $i => $t): ?>
            <li class="timeline-item"><span class="timeline-dot"><?= $i + 1 ?></span><div><h4><?= e($t['title']) ?></h4><p><?= e($t['desc']) ?></p></div></li>
          <?php endforeach; ?>
        </ol>
      </div>

      <!-- FAQ -->
      <?php if (!empty($service['faqs'])): ?>
        <div class="detail-block" data-reveal>
          <h3 class="h3">Frequently asked</h3>
          <?php foreach ($service['faqs'] as $i => $faq): ?>
            <details class="faq"<?= $i === 0 ? ' open' : '' ?>>
              <summary><span><?= e($faq['q']) ?></span><span class="ic" aria-hidden="true"><svg viewBox="0 0 24 24" width="16" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M12 5v14M5 12h14"/></svg></span></summary>
              <div class="ans"><p><?= e($faq['a']) ?></p></div>
            </details>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <!-- Sidebar -->
    <aside class="detail-aside">
      <div class="aside-card" data-reveal="right">
        <span class="tag"><span class="dot"></span>Pricing</span>
        <h3 class="h3">Transparent, itemised</h3>
        <p>Fees depend on your destination and case. Your initial consultation is <strong>free</strong> — we give you clear, itemised pricing before any commitment.</p>
        <a href="<?= url('/contact') ?>" class="btn btn--primary magnetic">Request a quote</a>
        <a href="<?= e(biz('whatsapp')) ?>" target="_blank" rel="noopener" class="btn btn--ghost magnetic">Ask on WhatsApp</a>
      </div>
      <div class="aside-card aside-card--dark" data-reveal="right">
        <h3 class="h3">Other services</h3>
        <ul class="aside-links">
          <?php foreach (array_slice($others, 0, 5) as $o): ?>
            <li><a href="<?= url('/services/' . $o['slug']) ?>"><?= e($o['title']) ?> <span aria-hidden="true">→</span></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </aside>
  </div>
</section>

<?php require BASE_PATH . '/app/Views/partials/cta.php'; ?>
