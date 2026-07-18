<?php /** @var array $items */ ?>
<div class="adm-panel">
  <div class="adm-panel-head">
    <h2><?= count($items) ?> testimonial<?= count($items) === 1 ? '' : 's' ?></h2>
    <a href="<?= url('/admin/testimonials/create') ?>" class="btn-adm btn-adm--primary">+ New testimonial</a>
  </div>
  <?php if (!$items): ?>
    <div class="adm-empty">No testimonials yet. <a class="adm-link" href="<?= url('/admin/testimonials/create') ?>">Add one</a>.</div>
  <?php else: ?>
    <div class="adm-table-wrap"><table class="adm-table">
      <thead><tr><th></th><th>Name</th><th>Role</th><th>Status</th><th class="ta-r">Actions</th></tr></thead>
      <tbody>
        <?php foreach ($items as $it): ?>
          <tr>
            <td class="cell-thumb"><?php if ($it['avatar']): ?><img class="adm-avatar-sm" src="<?= e(media($it['avatar'])) ?>" alt=""><?php else: ?><span class="adm-avatar sm"><?= e(strtoupper(substr($it['name'], 0, 1))) ?></span><?php endif; ?></td>
            <td><strong><?= e($it['name']) ?></strong></td>
            <td class="muted"><?= e($it['role'] ?: '—') ?></td>
            <td><?= pub_pill($it['is_published']) ?></td>
            <td class="ta-r">
              <a class="btn-adm btn-adm--sm" href="<?= url('/admin/testimonials/' . $it['id'] . '/edit') ?>">Edit</a>
              <form class="inline" method="post" action="<?= url('/admin/testimonials/' . $it['id'] . '/delete') ?>" data-confirm="Delete this testimonial?"><?= csrf_field() ?><button class="btn-adm btn-adm--sm btn-adm--danger">Delete</button></form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table></div>
  <?php endif; ?>
</div>
