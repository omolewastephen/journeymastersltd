<?php $title = $title ?? 'Page not found'; ?>
<section class="section error-section">
  <div class="container error-inner">
    <span class="overline">Error <?= e((string) ($code ?? 404)) ?></span>
    <h1 class="display error-code">Off the map<span class="accent">.</span></h1>
    <p class="lead">The page you're looking for has taken a different route. Let's get you back on track.</p>
    <div class="cta-actions">
      <a href="<?= url('/') ?>" class="btn btn--primary btn--lg magnetic">Back to home</a>
      <a href="<?= url('/contact') ?>" class="btn btn--ghost btn--lg magnetic">Contact us</a>
    </div>
  </div>
</section>
