<?php
/** @var array|null $item @var array $errors @var array $services */
$dec = fn ($v) => is_array($v) ? $v : (json_decode((string) $v, true) ?: []);
$highlightsT = \App\Support\Fields::linesToText($dec($item['highlights'] ?? []));
$reqT        = \App\Support\Fields::linesToText($dec($item['requirements'] ?? []));
$galleryT    = \App\Support\Fields::linesToText($dec($item['gallery'] ?? []));
$related     = $dec($item['related_services'] ?? []);
$action      = $item ? url('/admin/destinations/' . $item['id']) : url('/admin/destinations');
?>
<a class="adm-back" href="<?= url('/admin/destinations') ?>">← All destinations</a>

<form method="post" action="<?= $action ?>" enctype="multipart/form-data" class="adm-panel content-form">
  <?= csrf_field() ?>
  <div class="form-grid">
    <div class="form-main">
      <div class="field-row">
        <div class="field">
          <label for="country">Country / region *</label>
          <input type="text" id="country" name="country" value="<?= fv($item, 'country') ?>" required>
          <?php if (isset($errors['country'])): ?><span class="field-err"><?= e($errors['country']) ?></span><?php endif; ?>
        </div>
        <div class="field"><label for="duration">Label</label><input type="text" id="duration" name="duration" value="<?= fv($item, 'duration') ?>" placeholder="Study · Work · PR"></div>
      </div>
      <div class="field">
        <label for="title">Heading *</label>
        <input type="text" id="title" name="title" value="<?= fv($item, 'title') ?>" required>
        <?php if (isset($errors['title'])): ?><span class="field-err"><?= e($errors['title']) ?></span><?php endif; ?>
      </div>
      <div class="field"><label for="intro">Intro</label><textarea id="intro" name="intro" rows="3"><?= fv($item, 'intro') ?></textarea></div>
      <div class="field"><label for="highlights">Highlights <span class="muted">(one per line)</span></label><textarea id="highlights" name="highlights" rows="4"><?= e($highlightsT) ?></textarea></div>
      <div class="field"><label for="requirements">Requirements <span class="muted">(one per line)</span></label><textarea id="requirements" name="requirements" rows="4"><?= e($reqT) ?></textarea></div>
      <div class="field"><label for="gallery">Gallery image URLs <span class="muted">(one per line)</span></label><textarea id="gallery" name="gallery" rows="3" class="mono"><?= e($galleryT) ?></textarea></div>
    </div>

    <aside class="form-side">
      <label class="switch"><input type="checkbox" name="is_published" value="1" <?= ($item['is_published'] ?? 1) ? 'checked' : '' ?>><span>Published</span></label>
      <div class="field"><label for="slug">Slug <span class="muted">(auto)</span></label><input type="text" id="slug" name="slug" value="<?= fv($item, 'slug') ?>"></div>
      <div class="field"><label for="sort_order">Order</label><input type="number" id="sort_order" name="sort_order" value="<?= fv($item, 'sort_order', '0') ?>"></div>
      <div class="field">
        <label>Cover image</label>
        <?php if (!empty($item['image'])): ?><img class="img-preview" src="<?= e(media($item['image'])) ?>" alt=""><?php endif; ?>
        <input type="file" name="image" accept="image/*">
        <?php if (isset($errors['image'])): ?><span class="field-err"><?= e($errors['image']) ?></span><?php endif; ?>
      </div>
      <div class="field">
        <label>Related services</label>
        <div class="check-group">
          <?php foreach ($services as $s): ?>
            <label class="check"><input type="checkbox" name="related_services[]" value="<?= e($s['slug']) ?>" <?= in_array($s['slug'], $related, true) ? 'checked' : '' ?>> <?= e($s['title']) ?></label>
          <?php endforeach; ?>
        </div>
      </div>
      <button type="submit" class="btn-adm btn-adm--primary btn-adm--block">Save destination</button>
    </aside>
  </div>
</form>
