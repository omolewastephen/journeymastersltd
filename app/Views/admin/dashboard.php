<?php /** @var array $stats @var array $recent */ ?>

<div class="stat-cards">
  <a href="<?= url('/admin/messages') ?>" class="stat-card">
    <div class="stat-card-ico ico-red"><svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg></div>
    <div class="stat-card-n"><?= number_format($stats['messages']) ?></div>
    <div class="stat-card-l">Total messages</div>
  </a>
  <a href="<?= url('/admin/messages') ?>" class="stat-card">
    <div class="stat-card-ico ico-amber"><svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.7 21a2 2 0 0 1-3.4 0"/></svg></div>
    <div class="stat-card-n"><?= number_format($stats['unread']) ?></div>
    <div class="stat-card-l">Unread</div>
  </a>
  <a href="<?= url('/admin/subscribers') ?>" class="stat-card">
    <div class="stat-card-ico ico-navy"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
    <div class="stat-card-n"><?= number_format($stats['subscribers']) ?></div>
    <div class="stat-card-l">Subscribers</div>
  </a>
  <div class="stat-card">
    <div class="stat-card-ico ico-green"><svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="M22 4L12 14.01l-3-3"/></svg></div>
    <div class="stat-card-n"><?= number_format($stats['services']) ?></div>
    <div class="stat-card-l">Live services</div>
  </div>
</div>

<div class="adm-panel adm-tools">
  <div>
    <h2>Content library</h2>
    <p class="muted">Import the starter services, destinations, blog posts, testimonials &amp; FAQs into the database so you can edit them from the menu. Your leads and login are never touched.</p>
  </div>
  <form method="post" action="<?= url('/admin/tools/seed') ?>" data-confirm="Import starter content into the CMS tables? (Existing content entries are replaced; messages, subscribers and users are untouched.)">
    <?= csrf_field() ?>
    <button type="submit" class="btn-adm btn-adm--primary">Import / reset starter content</button>
  </form>
</div>

<div class="adm-panel">
  <div class="adm-panel-head">
    <h2>Recent enquiries</h2>
    <a href="<?= url('/admin/messages') ?>" class="adm-link">View all →</a>
  </div>
  <?php if (empty($recent)): ?>
    <div class="adm-empty">No messages yet. Enquiries from the contact form will appear here.</div>
  <?php else: ?>
    <div class="adm-table-wrap">
      <table class="adm-table">
        <thead><tr><th>Name</th><th>Service</th><th>Received</th><th></th></tr></thead>
        <tbody>
          <?php foreach ($recent as $m): ?>
            <tr class="<?= (int) ($m['is_read'] ?? 0) === 0 ? 'is-unread' : '' ?>">
              <td><strong><?= e($m['name']) ?></strong><br><span class="muted"><?= e($m['email']) ?></span></td>
              <td><?= e($m['service'] ?: '—') ?></td>
              <td class="muted"><?= e(date('M j, g:ia', strtotime($m['created_at']))) ?></td>
              <td><a class="adm-link" href="<?= url('/admin/messages/' . $m['id']) ?>">Open</a></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>
