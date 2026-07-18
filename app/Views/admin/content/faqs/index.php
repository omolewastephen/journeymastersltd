<?php /** @var array $items */ ?>
<div class="adm-panel">
  <div class="adm-panel-head">
    <h2><?= count($items) ?> FAQ<?= count($items) === 1 ? '' : 's' ?></h2>
    <a href="<?= url('/admin/faqs/create') ?>" class="btn-adm btn-adm--primary">+ New FAQ</a>
  </div>
  <?php if (!$items): ?>
    <div class="adm-empty">No FAQs yet. <a class="adm-link" href="<?= url('/admin/faqs/create') ?>">Add one</a>.</div>
  <?php else: ?>
    <div class="adm-table-wrap"><table class="adm-table">
      <thead><tr><th>Question</th><th>Order</th><th>Status</th><th class="ta-r">Actions</th></tr></thead>
      <tbody>
        <?php foreach ($items as $it): ?>
          <tr>
            <td><strong><?= e($it['question']) ?></strong></td>
            <td class="muted"><?= (int) $it['sort_order'] ?></td>
            <td><?= pub_pill($it['is_published']) ?></td>
            <td class="ta-r">
              <a class="btn-adm btn-adm--sm" href="<?= url('/admin/faqs/' . $it['id'] . '/edit') ?>">Edit</a>
              <form class="inline" method="post" action="<?= url('/admin/faqs/' . $it['id'] . '/delete') ?>" data-confirm="Delete this FAQ?"><?= csrf_field() ?><button class="btn-adm btn-adm--sm btn-adm--danger">Delete</button></form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table></div>
  <?php endif; ?>
</div>
