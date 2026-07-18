<?php /** @var array $m */ ?>

<a class="adm-back" href="<?= url('/admin/messages') ?>">← All messages</a>

<div class="msg-view">
  <div class="msg-main adm-panel">
    <div class="msg-head">
      <span class="adm-avatar lg"><?= e(strtoupper(substr($m['name'], 0, 1))) ?></span>
      <div>
        <h2><?= e($m['name']) ?></h2>
        <p class="muted"><?= e(date('l, F j, Y \a\t g:ia', strtotime($m['created_at']))) ?></p>
      </div>
    </div>
    <div class="msg-body"><?= nl2br(e($m['message'])) ?></div>
    <div class="msg-actions">
      <a class="btn-adm btn-adm--primary" href="mailto:<?= e($m['email']) ?>?subject=Re: Your enquiry with Journey Masters Ltd">Reply by email</a>
      <a class="btn-adm" href="tel:<?= e($m['phone']) ?>">Call <?= e($m['phone']) ?></a>
      <form class="inline" method="post" action="<?= url('/admin/messages/' . $m['id'] . '/delete') ?>" data-confirm="Delete this message permanently?">
        <?= csrf_field() ?>
        <button class="btn-adm btn-adm--danger" type="submit">Delete</button>
      </form>
    </div>
  </div>

  <aside class="msg-meta adm-panel">
    <h3>Details</h3>
    <dl>
      <dt>Email</dt><dd><a href="mailto:<?= e($m['email']) ?>"><?= e($m['email']) ?></a></dd>
      <dt>Phone</dt><dd><a href="tel:<?= e($m['phone']) ?>"><?= e($m['phone'] ?: '—') ?></a></dd>
      <dt>Service</dt><dd><?= e($m['service'] ?: '—') ?></dd>
      <dt>IP address</dt><dd class="muted"><?= e($m['ip_address'] ?: '—') ?></dd>
      <dt>Status</dt><dd><span class="pill pill--ok">Read</span></dd>
    </dl>
  </aside>
</div>
