<?php /** @var array $messages @var int $page @var int $pages @var int $total */ ?>

<div class="adm-panel">
  <div class="adm-panel-head">
    <h2><?= number_format($total) ?> message<?= $total === 1 ? '' : 's' ?></h2>
  </div>

  <?php if (empty($messages)): ?>
    <div class="adm-empty">No messages yet. Enquiries from the contact form land here.</div>
  <?php else: ?>
    <div class="adm-table-wrap">
      <table class="adm-table">
        <thead><tr><th>From</th><th>Service</th><th>Received</th><th class="ta-r">Actions</th></tr></thead>
        <tbody>
          <?php foreach ($messages as $m): ?>
            <tr class="<?= (int) ($m['is_read'] ?? 0) === 0 ? 'is-unread' : '' ?>">
              <td>
                <?php if ((int) ($m['is_read'] ?? 0) === 0): ?><span class="dot-unread" title="Unread"></span><?php endif; ?>
                <strong><?= e($m['name']) ?></strong><br><span class="muted"><?= e($m['email']) ?></span>
              </td>
              <td><?= e($m['service'] ?: '—') ?></td>
              <td class="muted"><?= e(date('M j, Y · g:ia', strtotime($m['created_at']))) ?></td>
              <td class="ta-r">
                <a class="btn-adm btn-adm--sm" href="<?= url('/admin/messages/' . $m['id']) ?>">Open</a>
                <form class="inline" method="post" action="<?= url('/admin/messages/' . $m['id'] . '/delete') ?>" data-confirm="Delete this message permanently?">
                  <?= csrf_field() ?>
                  <button class="btn-adm btn-adm--sm btn-adm--danger" type="submit">Delete</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <?php if ($pages > 1): ?>
      <div class="adm-pagination">
        <?php for ($i = 1; $i <= $pages; $i++): ?>
          <a href="<?= url('/admin/messages?page=' . $i) ?>" class="<?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
      </div>
    <?php endif; ?>
  <?php endif; ?>
</div>
