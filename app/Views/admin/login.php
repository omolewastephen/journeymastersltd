<?php /** @var string $error @var string $oldEmail */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="robots" content="noindex, nofollow" />
  <title><?= e($title ?? 'Admin Login') ?></title>
  <link rel="icon" type="image/png" href="<?= asset('img/logo.png') ?>" />
  <link rel="stylesheet" href="<?= asset('css/admin.css') ?>" />
</head>
<body class="adm-auth">
  <div class="adm-auth-card">
    <img class="adm-auth-logo" src="<?= asset('img/logo.png') ?>" alt="Journey Masters Ltd" />
    <h1>Welcome back</h1>
    <p class="adm-auth-sub">Sign in to manage the Journey Masters website.</p>

    <?php if (!empty($error)): ?>
      <div class="adm-alert adm-alert--err"><?= e($error) ?></div>
    <?php endif; ?>

    <form method="post" action="<?= url('/admin/login') ?>" class="adm-auth-form">
      <?= csrf_field() ?>
      <div class="field">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?= e($oldEmail ?? '') ?>" autocomplete="username" required autofocus />
      </div>
      <div class="field">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" autocomplete="current-password" required />
      </div>
      <button type="submit" class="btn-adm btn-adm--primary btn-adm--block">Sign in</button>
    </form>
    <a class="adm-auth-back" href="<?= url('/') ?>">← Back to website</a>
  </div>
</body>
</html>
