<?php /** @var array $items */ ?>
<div class="adm-panel">
  <div class="adm-panel-head">
    <h2><?= count($items) ?> post<?= count($items) === 1 ? '' : 's' ?></h2>
    <a href="<?= url('/admin/posts/create') ?>" class="btn-adm btn-adm--primary">+ New post</a>
  </div>
  <?php if (!$items): ?>
    <div class="adm-empty">No posts yet. <a class="adm-link" href="<?= url('/admin/posts/create') ?>">Write your first post</a>, or import starter content from the dashboard.</div>
  <?php else: ?>
    <div class="adm-table-wrap"><table class="adm-table">
      <thead><tr><th></th><th>Title</th><th>Category</th><th>Status</th><th class="ta-r">Actions</th></tr></thead>
      <tbody>
        <?php foreach ($items as $it): ?>
          <tr>
            <td class="cell-thumb"><?php if ($it['image']): ?><img class="adm-thumb" src="<?= e(media($it['image'])) ?>" alt=""><?php endif; ?></td>
            <td><strong><?= e($it['title']) ?></strong><br><span class="muted">/blog/<?= e($it['slug']) ?></span></td>
            <td><?= e($it['category'] ?: '—') ?></td>
            <td><?= pub_pill($it['is_published']) ?></td>
            <td class="ta-r">
              <a class="btn-adm btn-adm--sm" href="<?= url('/admin/posts/' . $it['id'] . '/edit') ?>">Edit</a>
              <form class="inline" method="post" action="<?= url('/admin/posts/' . $it['id'] . '/delete') ?>" data-confirm="Delete this post?"><?= csrf_field() ?><button class="btn-adm btn-adm--sm btn-adm--danger">Delete</button></form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table></div>
  <?php endif; ?>
</div>
