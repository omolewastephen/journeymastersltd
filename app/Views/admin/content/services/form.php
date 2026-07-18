<?php
/** @var array|null $item @var array $errors */
$dec = fn ($v) => is_array($v) ? $v : (json_decode((string) $v, true) ?: []);
$overviewT = \App\Support\Fields::linesToText($dec($item['overview'] ?? []));
$benefitsT = \App\Support\Fields::linesToText($dec($item['benefits'] ?? []));
$reqT      = \App\Support\Fields::linesToText($dec($item['requirements'] ?? []));
$timelineT = \App\Support\Fields::pairsToText($dec($item['timeline'] ?? []), 'title', 'desc');
$sfaqsT    = \App\Support\Fields::pairsToText($dec($item['faqs'] ?? []), 'q', 'a');
$action    = $item ? url('/admin/services/' . $item['id']) : url('/admin/services');
?>
<a class="adm-back" href="<?= url('/admin/services') ?>">← All services</a>

<form method="post" action="<?= $action ?>" enctype="multipart/form-data" class="adm-panel content-form">
  <?= csrf_field() ?>
  <div class="form-grid">
    <div class="form-main">
      <div class="field">
        <label for="title">Title *</label>
        <input type="text" id="title" name="title" value="<?= fv($item, 'title') ?>" required>
        <?php if (isset($errors['title'])): ?><span class="field-err"><?= e($errors['title']) ?></span><?php endif; ?>
      </div>
      <div class="field"><label for="tagline">Tagline</label><input type="text" id="tagline" name="tagline" value="<?= fv($item, 'tagline') ?>"></div>
      <div class="field"><label for="summary">Summary <span class="muted">(card text)</span></label><textarea id="summary" name="summary" rows="2"><?= fv($item, 'summary') ?></textarea></div>
      <div class="field"><label for="overview">Overview <span class="muted">(one paragraph per line)</span></label><textarea id="overview" name="overview" rows="4"><?= e($overviewT) ?></textarea></div>
      <div class="field"><label for="benefits">What you get <span class="muted">(one per line)</span></label><textarea id="benefits" name="benefits" rows="5"><?= e($benefitsT) ?></textarea></div>
      <div class="field"><label for="requirements">Requirements <span class="muted">(one per line)</span></label><textarea id="requirements" name="requirements" rows="4"><?= e($reqT) ?></textarea></div>
      <div class="field"><label for="timeline">Timeline <span class="muted">(one step per line, "Title | Description")</span></label><textarea id="timeline" name="timeline" rows="3" placeholder="Assessment | We confirm what your embassy expects."><?= e($timelineT) ?></textarea></div>
      <div class="field"><label for="faqs">FAQs <span class="muted">(one per line, "Question | Answer")</span></label><textarea id="faqs" name="faqs" rows="3" placeholder="Is it verifiable? | Yes, entirely."><?= e($sfaqsT) ?></textarea></div>
    </div>

    <aside class="form-side">
      <label class="switch"><input type="checkbox" name="is_published" value="1" <?= ($item['is_published'] ?? 1) ? 'checked' : '' ?>><span>Published</span></label>
      <div class="field"><label for="slug">Slug <span class="muted">(auto)</span></label><input type="text" id="slug" name="slug" value="<?= fv($item, 'slug') ?>"></div>
      <div class="field"><label for="sort_order">Order</label><input type="number" id="sort_order" name="sort_order" value="<?= fv($item, 'sort_order', '0') ?>"></div>
      <div class="field">
        <label>Image</label>
        <?php if (!empty($item['image'])): ?><img class="img-preview" src="<?= e(media($item['image'])) ?>" alt=""><?php endif; ?>
        <input type="file" name="image" accept="image/*">
        <?php if (isset($errors['image'])): ?><span class="field-err"><?= e($errors['image']) ?></span><?php endif; ?>
      </div>
      <div class="field"><label for="icon">Icon SVG paths <span class="muted">(advanced)</span></label><textarea id="icon" name="icon" rows="2" class="mono"><?= fv($item, 'icon') ?></textarea></div>
      <button type="submit" class="btn-adm btn-adm--primary btn-adm--block">Save service</button>
    </aside>
  </div>
</form>
