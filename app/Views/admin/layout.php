<?php
/** @var string $content @var string $title @var array $authUser @var int $unread */
$unread   = $unread ?? 0;
$authUser = $authUser ?? [];
$ok       = \App\Core\Session::flash('admin_ok');
function adm_active(string $path): string
{
    $cur = current_path();
    return ($path === '/admin' ? $cur === '/admin' : str_starts_with($cur, $path)) ? ' class="active"' : '';
}
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="robots" content="noindex, nofollow" />
  <title><?= e($title ?? 'Admin') ?> — Journey Masters Admin</title>
  <link rel="icon" type="image/png" href="<?= asset('img/logo.png') ?>" />
  <link rel="stylesheet" href="<?= asset('css/admin.css') ?>" />
</head>
<body>
<div class="adm" id="adm">
  <aside class="adm-side">
    <a href="<?= url('/admin') ?>" class="adm-brand"><img src="<?= asset('img/logo.png') ?>" alt="Journey Masters" /></a>
    <nav class="adm-nav" aria-label="Admin">
      <span class="adm-nav-label">Overview</span>
      <a href="<?= url('/admin') ?>"<?= adm_active('/admin') ?>><svg viewBox="0 0 24 24"><path d="M3 12l9-9 9 9M5 10v10h14V10"/></svg> Dashboard</a>
      <a href="<?= url('/admin/messages') ?>"<?= adm_active('/admin/messages') ?>><svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg> Messages<?php if ($unread > 0): ?><span class="adm-badge"><?= (int) $unread ?></span><?php endif; ?></a>
      <a href="<?= url('/admin/subscribers') ?>"<?= adm_active('/admin/subscribers') ?>><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/></svg> Subscribers</a>
      <span class="adm-nav-label">Content <em>soon</em></span>
      <a class="disabled" title="Coming next"><svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg> Services &amp; Pages</a>
      <span class="adm-nav-label">Account</span>
      <a href="<?= url('/admin/password') ?>"<?= adm_active('/admin/password') ?>><svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg> Change Password</a>
    </nav>
    <form action="<?= url('/admin/logout') ?>" method="post" class="adm-logout-form">
      <?= csrf_field() ?>
      <button type="submit" class="adm-logout"><svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/></svg> Log out</button>
    </form>
  </aside>

  <div class="adm-main">
    <header class="adm-top">
      <button class="adm-burger" id="admBurger" aria-label="Toggle menu"><span></span></button>
      <h1 class="adm-title"><?= e($title ?? 'Admin') ?></h1>
      <div class="adm-who">
        <a href="<?= url('/') ?>" target="_blank" rel="noopener" class="adm-view-site">View site ↗</a>
        <span class="adm-avatar"><?= e(strtoupper(substr((string) ($authUser['name'] ?? 'A'), 0, 1))) ?></span>
      </div>
    </header>

    <main class="adm-content">
      <?php if ($ok): ?><div class="adm-alert adm-alert--ok"><?= e($ok) ?></div><?php endif; ?>
      <?= $content ?>
    </main>
  </div>
</div>

<div class="adm-scrim" id="admScrim"></div>
<script>
  (function () {
    var b = document.getElementById('admBurger'), a = document.getElementById('adm'), s = document.getElementById('admScrim');
    function t(){ a.classList.toggle('nav-open'); }
    b && b.addEventListener('click', t);
    s && s.addEventListener('click', function(){ a.classList.remove('nav-open'); });
    document.querySelectorAll('[data-confirm]').forEach(function(f){
      f.addEventListener('submit', function(e){ if(!confirm(f.getAttribute('data-confirm'))) e.preventDefault(); });
    });
  })();
</script>
</body>
</html>
