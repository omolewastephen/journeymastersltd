<?php /** @var array $subscribers */ ?>

<div class="adm-panel">
  <div class="adm-panel-head">
    <h2><?= number_format(count($subscribers)) ?> subscriber<?= count($subscribers) === 1 ? '' : 's' ?></h2>
    <?php if (!empty($subscribers)): ?>
      <a class="btn-adm btn-adm--sm" href="<?= url('/admin/subscribers/export') ?>">Export CSV</a>
    <?php endif; ?>
  </div>

  <?php if (empty($subscribers)): ?>
    <div class="adm-empty">No subscribers yet. Newsletter sign-ups appear here.</div>
  <?php else: ?>
    <div class="adm-table-wrap">
      <table class="adm-table">
        <thead><tr><th>Email</th><th>Subscribed</th><th class="ta-r">Actions</th></tr></thead>
        <tbody>
          <?php foreach ($subscribers as $s): ?>
            <tr>
              <td><a href="mailto:<?= e($s['email']) ?>"><?= e($s['email']) ?></a></td>
              <td class="muted"><?= e(date('M j, Y', strtotime($s['created_at']))) ?></td>
              <td class="ta-r">
                <form class="inline" method="post" action="<?= url('/admin/subscribers/' . $s['id'] . '/delete') ?>" data-confirm="Remove this subscriber?">
                  <?= csrf_field() ?>
                  <button class="btn-adm btn-adm--sm btn-adm--danger" type="submit">Remove</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>
