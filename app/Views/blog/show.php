<?php
/** @var array $post  @var array $related */
$ph_eyebrow = $post['category'] . ' · ' . $post['read'];
$ph_title   = e($post['title']);
$ph_sub     = $post['excerpt'];
$ph_image   = $post['image'];
$ph_crumbs  = [['label' => 'Insights', 'href' => '/blog'], ['label' => $post['category']]];
require BASE_PATH . '/app/Views/partials/page-hero.php';
?>

<section class="section">
  <div class="container article-wrap">
    <article class="prose article" data-reveal>
      <p class="article-meta"><?= e(date('F j, Y', strtotime($post['date']))) ?> · <?= e($post['read']) ?> read</p>
      <?php if (is_array($post['body'])): ?>
        <?php foreach ($post['body'] as $para): ?><p><?= e($para) ?></p><?php endforeach; ?>
      <?php else: ?>
        <?= $post['body'] /* admin-authored rich text */ ?>
      <?php endif; ?>
      <div class="article-share">
        <a href="<?= e(biz('whatsapp')) ?>" target="_blank" rel="noopener" class="btn btn--primary magnetic">Talk to a consultant</a>
      </div>
    </article>
  </div>
</section>

<?php if (!empty($related)): ?>
<section class="section bg-cloud">
  <div class="container">
    <div class="section-intro"><span class="overline" data-reveal>Keep reading</span><h2 class="h2" data-reveal>Related insights</h2></div>
    <div class="grid-auto">
      <?php foreach ($related as $p): ?>
        <a class="card post-card" href="<?= url('/blog/' . $p['slug']) ?>" data-reveal>
          <div class="thumb"><img src="<?= e($p['image']) ?>" alt="" data-fallback loading="lazy" decoding="async"></div>
          <div class="body"><div class="meta"><?= e($p['category']) ?> · <?= e($p['read']) ?></div><h3><?= e($p['title']) ?></h3><p class="excerpt"><?= e($p['excerpt']) ?></p></div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>
