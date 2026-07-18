<?php /** @var array $errors */ ?>

<div class="adm-panel adm-panel--narrow">
  <div class="adm-panel-head"><h2>Change your password</h2></div>
  <p class="muted mb">Use at least 8 characters. You'll stay logged in after changing it.</p>

  <form method="post" action="<?= url('/admin/password') ?>" class="adm-form">
    <?= csrf_field() ?>
    <div class="field">
      <label for="current_password">Current password</label>
      <input type="password" id="current_password" name="current_password" autocomplete="current-password" required />
      <?php if (isset($errors['current_password'])): ?><span class="field-err"><?= e($errors['current_password']) ?></span><?php endif; ?>
    </div>
    <div class="field">
      <label for="new_password">New password</label>
      <input type="password" id="new_password" name="new_password" autocomplete="new-password" required />
      <?php if (isset($errors['new_password'])): ?><span class="field-err"><?= e($errors['new_password']) ?></span><?php endif; ?>
    </div>
    <div class="field">
      <label for="confirm_password">Confirm new password</label>
      <input type="password" id="confirm_password" name="confirm_password" autocomplete="new-password" required />
      <?php if (isset($errors['confirm_password'])): ?><span class="field-err"><?= e($errors['confirm_password']) ?></span><?php endif; ?>
    </div>
    <button type="submit" class="btn-adm btn-adm--primary">Update password</button>
  </form>
</div>
