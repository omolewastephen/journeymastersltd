<?php /** @var array $items */ ?>
<div class="adm-panel">
  <div class="adm-panel-head">
    <h2><?= count($items) ?> destination<?= count($items) === 1 ? '' : 's' ?></h2>
    <a href="<?= url('/admin/destinations/create') ?>" class="btn-adm btn-adm--primary">+ New destination</a>
  </div>
  <?php if (!$items): ?>
    <div class="adm-empty">No destinations yet. Import starter content from the dashboard, or <a class="adm-link" href="<?= url('/admin/destinations/create') ?>">add one</a>.</div>
  <?php else: ?>
    <div class="adm-table-wrap"><table class="adm-table">
      <thead><tr><th></th><th>Destination</th><th>Order</th><th>Status</th><th class="ta-r">Actions</th></tr></thead>
      <tbody>
        <?php foreach ($items as $it): ?>
          <tr>
            <td class="cell-thumb"><?php if ($it['image']): ?><img class="adm-thumb" src="<?= e(media($it['image'])) ?>" alt=""><?php endif; ?></td>
            <td><strong><?= e($it['country']) ?></strong><br><span class="muted"><?= e($it['title']) ?></span></td>
            <td class="muted"><?= (int) $it['sort_order'] ?></td>
            <td><?= pub_pill($it['is_published']) ?></td>
            <td class="ta-r">
              <a class="btn-adm btn-adm--sm" href="<?= url('/admin/destinations/' . $it['id'] . '/edit') ?>">Edit</a>
              <form class="inline" method="post" action="<?= url('/admin/destinations/' . $it['id'] . '/delete') ?>" data-confirm="Delete this destination?"><?= csrf_field() ?><button class="btn-adm btn-adm--sm btn-adm--danger">Delete</button></form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table></div>
  <?php endif; ?>
</div>
