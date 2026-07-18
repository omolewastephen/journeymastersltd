<?php
/** @var array $services */
use App\Core\Session;

$errors  = Session::flash('errors') ?: [];
$success = Session::flash('success');
$error   = Session::flash('error');

$ph_eyebrow = 'Contact';
$ph_title   = "Let's plan your journey";
$ph_sub     = 'Book a free consultation. Call, WhatsApp or send a message — we respond quickly.';
$ph_crumbs  = [['label' => 'Contact']];
require BASE_PATH . '/app/Views/partials/page-hero.php';
?>

<section class="section" id="form">
  <div class="container split split--cta contact-layout">
    <!-- Form -->
    <div data-reveal="left">
      <span class="overline">Send a message</span>
      <h2 class="h2">Request a consultation</h2>
      <p>Tell us where you're headed and we'll map the best route. Fields marked * are required.</p>

      <?php if ($success): ?><div class="alert alert--ok"><?= e($success) ?></div><?php endif; ?>
      <?php if ($error): ?><div class="alert alert--err"><?= e($error) ?></div><?php endif; ?>

      <form class="contact-form" action="<?= url('/contact') ?>" method="post" novalidate>
        <?= csrf_field() ?>
        <!-- Honeypot -->
        <div class="hp" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>

        <div class="field">
          <label for="name">Full name *</label>
          <input type="text" id="name" name="name" value="<?= old('name') ?>" required>
          <?php if (isset($errors['name'])): ?><span class="field-err"><?= e($errors['name']) ?></span><?php endif; ?>
        </div>

        <div class="field-row">
          <div class="field">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" value="<?= old('email') ?>" required>
            <?php if (isset($errors['email'])): ?><span class="field-err"><?= e($errors['email']) ?></span><?php endif; ?>
          </div>
          <div class="field">
            <label for="phone">Phone *</label>
            <input type="tel" id="phone" name="phone" value="<?= old('phone') ?>" required>
            <?php if (isset($errors['phone'])): ?><span class="field-err"><?= e($errors['phone']) ?></span><?php endif; ?>
          </div>
        </div>

        <div class="field">
          <label for="service">Service of interest *</label>
          <select id="service" name="service" required>
            <option value="">Select a service…</option>
            <?php foreach ($services as $s): ?>
              <option value="<?= e($s['title']) ?>" <?= Session::old('service') === $s['title'] ? 'selected' : '' ?>><?= e($s['title']) ?></option>
            <?php endforeach; ?>
            <option value="Other">Something else</option>
          </select>
          <?php if (isset($errors['service'])): ?><span class="field-err"><?= e($errors['service']) ?></span><?php endif; ?>
        </div>

        <div class="field">
          <label for="message">Your message *</label>
          <textarea id="message" name="message" rows="5" required><?= old('message') ?></textarea>
          <?php if (isset($errors['message'])): ?><span class="field-err"><?= e($errors['message']) ?></span><?php endif; ?>
        </div>

        <button type="submit" class="btn btn--primary btn--lg magnetic">Send message
          <svg viewBox="0 0 24 24" width="18" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4z"/></svg>
        </button>
      </form>
    </div>

    <!-- Info -->
    <aside class="contact-info" data-reveal="right">
      <div class="info-card">
        <span class="info-ico"><svg viewBox="0 0 24 24" width="22" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2A19.8 19.8 0 0 1 3.1 4.2 2 2 0 0 1 5 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/></svg></span>
        <div><div class="info-label">Call us</div><a href="tel:<?= e(biz('phone_intl')) ?>" class="info-value"><?= e(biz('phone')) ?></a></div>
      </div>
      <div class="info-card">
        <span class="info-ico"><svg viewBox="0 0 24 24" width="22" fill="currentColor" aria-hidden="true"><path d="M12 2a10 10 0 0 0-8.6 15l-1.3 4.8 4.9-1.3A10 10 0 1 0 12 2z"/></svg></span>
        <div><div class="info-label">WhatsApp</div><a href="<?= e(biz('whatsapp')) ?>" target="_blank" rel="noopener" class="info-value">Chat with us</a></div>
      </div>
      <div class="info-card">
        <span class="info-ico"><svg viewBox="0 0 24 24" width="22" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg></span>
        <div><div class="info-label">Email</div><a href="mailto:<?= e(biz('email')) ?>" class="info-value"><?= e(biz('email')) ?></a></div>
      </div>
      <div class="info-card">
        <span class="info-ico"><svg viewBox="0 0 24 24" width="22" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M21 10c0 6-9 12-9 12s-9-6-9-12a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></span>
        <div><div class="info-label">Office</div><span class="info-value"><?= e(biz('address')) ?></span></div>
      </div>
      <div class="info-card">
        <span class="info-ico"><svg viewBox="0 0 24 24" width="22" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></span>
        <div><div class="info-label">Business hours</div><span class="info-value">Mon–Sat · 9am – 6pm</span></div>
      </div>
    </aside>
  </div>
</section>

<!-- Map -->
<section class="section-sm">
  <div class="container">
    <div class="map-frame" data-reveal>
      <iframe title="Journey Masters Ltd office location" src="https://www.google.com/maps?q=Abeokuta,Ogun+State,Nigeria&output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
  </div>
</section>
