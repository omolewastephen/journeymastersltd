<footer class="footer">
  <div class="container section-sm">
    <div class="footer-grid">
      <div class="footer-brand">
        <img class="footer-logo" src="<?= asset('img/logo-white.png') ?>" alt="<?= e(config('business.legal_name')) ?>" loading="lazy" decoding="async" />
        <p>Premium travel, study-abroad and visa consultancy based in <?= e(biz('city')) ?>, <?= e(biz('region')) ?> — trusted to handle the details that matter.</p>
        <div class="soc">
          <a href="<?= e(biz('facebook')) ?>" target="_blank" rel="noopener" aria-label="Facebook"><svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M13 22v-8h3l1-4h-4V8c0-1 .5-2 2-2h2V2h-3c-3 0-5 2-5 5v3H6v4h3v8z"/></svg></a>
          <a href="<?= e(biz('whatsapp')) ?>" target="_blank" rel="noopener" aria-label="WhatsApp"><svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2a10 10 0 0 0-8.6 15l-1.3 4.8 4.9-1.3A10 10 0 1 0 12 2zm0 18a8 8 0 0 1-4-1.1l-.3-.2-2.9.8.8-2.8-.2-.3A8 8 0 1 1 12 20z"/></svg></a>
          <a href="tel:<?= e(biz('phone_intl')) ?>" aria-label="Call"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2A19.8 19.8 0 0 1 3.1 4.2 2 2 0 0 1 5 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/></svg></a>
        </div>
      </div>

      <nav aria-label="Services">
        <h3 class="f-title">Services</h3>
        <ul class="footer-list">
          <?php foreach (\App\Repositories\Content::services() as $s): ?>
            <li><a href="<?= url('/services/' . $s['slug']) ?>"><?= e($s['title']) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </nav>

      <nav aria-label="Company">
        <h3 class="f-title">Company</h3>
        <ul class="footer-list">
          <li><a href="<?= url('/about') ?>">About Us</a></li>
          <li><a href="<?= url('/destinations') ?>">Destinations</a></li>
          <li><a href="<?= url('/blog') ?>">Insights</a></li>
          <li><a href="<?= url('/contact') ?>">Contact</a></li>
        </ul>
      </nav>

      <div>
        <h3 class="f-title">Get in touch</h3>
        <address>
          <p class="addr-line"><?= e(biz('address')) ?></p>
          <a href="tel:<?= e(biz('phone_intl')) ?>"><?= e(biz('phone')) ?></a><br>
          <a href="mailto:<?= e(biz('email')) ?>"><?= e(biz('email')) ?></a>
        </address>
        <div class="footer-cta"><a href="<?= url('/contact') ?>" class="btn btn--primary magnetic">Book consultation</a></div>
      </div>
    </div>

    <div class="footer-bottom">
      <span>© <?= date('Y') ?> <?= e(config('business.legal_name')) ?>. All rights reserved.</span>
      <span class="legal-links"><a href="<?= url('/') ?>">Privacy</a><a href="<?= url('/') ?>">Terms</a><a href="<?= url('/sitemap.xml') ?>">Sitemap</a></span>
    </div>
  </div>
</footer>
