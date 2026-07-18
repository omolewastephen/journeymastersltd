<?php
/** @var array|null $item @var array $errors */
$action = $item ? url('/admin/posts/' . $item['id']) : url('/admin/posts');
?>
<a class="adm-back" href="<?= url('/admin/posts') ?>">← All posts</a>

<form method="post" action="<?= $action ?>" enctype="multipart/form-data" class="adm-panel content-form">
  <?= csrf_field() ?>
  <div class="form-grid">
    <div class="form-main">
      <div class="field">
        <label for="title">Title *</label>
        <input type="text" id="title" name="title" value="<?= fv($item, 'title') ?>" required>
        <?php if (isset($errors['title'])): ?><span class="field-err"><?= e($errors['title']) ?></span><?php endif; ?>
      </div>
      <div class="field">
        <label for="excerpt">Excerpt</label>
        <textarea id="excerpt" name="excerpt" rows="2"><?= fv($item, 'excerpt') ?></textarea>
      </div>
      <div class="field">
        <label>Body</label>
        <div class="rt" data-target="postBody">
          <div class="rt-toolbar">
            <button type="button" data-cmd="bold"><b>B</b></button>
            <button type="button" data-cmd="italic"><i>I</i></button>
            <button type="button" data-cmd="formatBlock" data-val="h2">H2</button>
            <button type="button" data-cmd="formatBlock" data-val="h3">H3</button>
            <button type="button" data-cmd="insertUnorderedList">• List</button>
            <button type="button" data-cmd="createLink">Link</button>
            <button type="button" data-cmd="formatBlock" data-val="p">¶</button>
          </div>
          <div class="rt-area" contenteditable="true"><?= $item['body'] ?? '<p></p>' ?></div>
        </div>
        <textarea id="postBody" name="body" hidden><?= $item['body'] ?? '' ?></textarea>
      </div>
    </div>

    <aside class="form-side">
      <div class="side-box">
        <label class="switch">
          <input type="checkbox" name="is_published" value="1" <?= ($item['is_published'] ?? 1) ? 'checked' : '' ?>>
          <span>Published</span>
        </label>
      </div>
      <div class="field"><label for="category">Category</label><input type="text" id="category" name="category" value="<?= fv($item, 'category') ?>" placeholder="Study Abroad"></div>
      <div class="field"><label for="read_time">Read time</label><input type="text" id="read_time" name="read_time" value="<?= fv($item, 'read_time') ?>" placeholder="6 min"></div>
      <div class="field"><label for="slug">Slug <span class="muted">(auto)</span></label><input type="text" id="slug" name="slug" value="<?= fv($item, 'slug') ?>" placeholder="from title"></div>
      <div class="field">
        <label>Cover image</label>
        <?php if (!empty($item['image'])): ?><img class="img-preview" src="<?= e(media($item['image'])) ?>" alt=""><?php endif; ?>
        <input type="file" name="image" accept="image/*">
        <?php if (isset($errors['image'])): ?><span class="field-err"><?= e($errors['image']) ?></span><?php endif; ?>
      </div>
      <button type="submit" class="btn-adm btn-adm--primary btn-adm--block">Save post</button>
    </aside>
  </div>
</form>
