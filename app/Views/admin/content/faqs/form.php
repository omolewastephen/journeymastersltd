<?php
/** @var array|null $item @var array $errors */
$action = $item ? url('/admin/faqs/' . $item['id']) : url('/admin/faqs');
?>
<a class="adm-back" href="<?= url('/admin/faqs') ?>">← All FAQs</a>

<form method="post" action="<?= $action ?>" class="adm-panel adm-panel--narrow adm-form">
  <?= csrf_field() ?>
  <div class="field">
    <label for="question">Question *</label>
    <input type="text" id="question" name="question" value="<?= fv($item, 'question') ?>" required>
    <?php if (isset($errors['question'])): ?><span class="field-err"><?= e($errors['question']) ?></span><?php endif; ?>
  </div>
  <div class="field">
    <label for="answer">Answer *</label>
    <textarea id="answer" name="answer" rows="4" required><?= fv($item, 'answer') ?></textarea>
    <?php if (isset($errors['answer'])): ?><span class="field-err"><?= e($errors['answer']) ?></span><?php endif; ?>
  </div>
  <div class="field-row">
    <div class="field"><label for="sort_order">Order</label><input type="number" id="sort_order" name="sort_order" value="<?= fv($item, 'sort_order', '0') ?>"></div>
    <label class="switch"><input type="checkbox" name="is_published" value="1" <?= ($item['is_published'] ?? 1) ? 'checked' : '' ?>><span>Published</span></label>
  </div>
  <button type="submit" class="btn-adm btn-adm--primary">Save FAQ</button>
</form>
