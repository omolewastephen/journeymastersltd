<?php /** @var array $items */ ?>
<div class="adm-panel">
  <div class="adm-panel-head">
    <h2><?= count($items) ?> service<?= count($items) === 1 ? '' : 's' ?></h2>
    <a href="<?= url('/admin/services/create') ?>" class="btn-adm btn-adm--primary">+ New service</a>
  </div>
  <?php if (!$items): ?>
    <div class="adm-empty">No services yet. Import starter content from the dashboard, or <a class="adm-link" href="<?= url('/admin/services/create') ?>">add one</a>.</div>
  <?php else: ?>
    <div class="adm-table-wrap"><table class="adm-table">
      <thead><tr><th>Title</th><th>Order</th><th>Status</th><th class="ta-r">Actions</th></tr></thead>
      <tbody>
        <?php foreach ($items as $it): ?>
          <tr>
            <td><strong><?= e($it['title']) ?></strong><br><span class="muted">/services/<?= e($it['slug']) ?></span></td>
            <td class="muted"><?= (int) $it['sort_order'] ?></td>
            <td><?= pub_pill($it['is_published']) ?></td>
            <td class="ta-r">
              <a class="btn-adm btn-adm--sm" href="<?= url('/admin/services/' . $it['id'] . '/edit') ?>">Edit</a>
              <form class="inline" method="post" action="<?= url('/admin/services/' . $it['id'] . '/delete') ?>" data-confirm="Delete this service?"><?= csrf_field() ?><button class="btn-adm btn-adm--sm btn-adm--danger">Delete</button></form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table></div>
  <?php endif; ?>
</div>
