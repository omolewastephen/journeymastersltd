<?php
/** @var array|null $item @var array $errors */
$action = $item ? url('/admin/testimonials/' . $item['id']) : url('/admin/testimonials');
?>
<a class="adm-back" href="<?= url('/admin/testimonials') ?>">← All testimonials</a>

<form method="post" action="<?= $action ?>" enctype="multipart/form-data" class="adm-panel adm-panel--narrow adm-form">
  <?= csrf_field() ?>
  <div class="field">
    <label for="name">Name *</label>
    <input type="text" id="name" name="name" value="<?= fv($item, 'name') ?>" required>
    <?php if (isset($errors['name'])): ?><span class="field-err"><?= e($errors['name']) ?></span><?php endif; ?>
  </div>
  <div class="field"><label for="role">Role / context</label><input type="text" id="role" name="role" value="<?= fv($item, 'role') ?>" placeholder="Study Permit · Canada"></div>
  <div class="field">
    <label for="quote">Quote *</label>
    <textarea id="quote" name="quote" rows="4" required><?= fv($item, 'quote') ?></textarea>
    <?php if (isset($errors['quote'])): ?><span class="field-err"><?= e($errors['quote']) ?></span><?php endif; ?>
  </div>
  <div class="field">
    <label>Avatar</label>
    <?php if (!empty($item['avatar'])): ?><img class="img-preview round" src="<?= e(media($item['avatar'])) ?>" alt=""><?php endif; ?>
    <input type="file" name="avatar" accept="image/*">
    <?php if (isset($errors['avatar'])): ?><span class="field-err"><?= e($errors['avatar']) ?></span><?php endif; ?>
  </div>
  <div class="field-row">
    <div class="field"><label for="rating">Rating</label><input type="number" id="rating" name="rating" min="1" max="5" value="<?= fv($item, 'rating', '5') ?>"></div>
    <div class="field"><label for="sort_order">Order</label><input type="number" id="sort_order" name="sort_order" value="<?= fv($item, 'sort_order', '0') ?>"></div>
  </div>
  <label class="switch"><input type="checkbox" name="is_published" value="1" <?= ($item['is_published'] ?? 1) ? 'checked' : '' ?>><span>Published</span></label>
  <button type="submit" class="btn-adm btn-adm--primary">Save testimonial</button>
</form>
