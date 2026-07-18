<?php
/** @var string $content @var string $title @var array $authUser @var int $unread */
$unread   = $unread ?? 0;
$authUser = $authUser ?? [];
$ok       = \App\Core\Session::flash('admin_ok');
$err      = \App\Core\Session::flash('admin_err');
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
      <span class="adm-nav-label">Content</span>
      <a href="<?= url('/admin/services') ?>"<?= adm_active('/admin/services') ?>><svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg> Services</a>
      <a href="<?= url('/admin/destinations') ?>"<?= adm_active('/admin/destinations') ?>><svg viewBox="0 0 24 24"><path d="M21 10c0 6-9 12-9 12s-9-6-9-12a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg> Destinations</a>
      <a href="<?= url('/admin/posts') ?>"<?= adm_active('/admin/posts') ?>><svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg> Blog</a>
      <a href="<?= url('/admin/testimonials') ?>"<?= adm_active('/admin/testimonials') ?>><svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg> Testimonials</a>
      <a href="<?= url('/admin/faqs') ?>"<?= adm_active('/admin/faqs') ?>><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12" y2="17"/></svg> FAQs</a>
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
      <?php if ($err): ?><div class="adm-alert adm-alert--err"><?= e($err) ?></div><?php endif; ?>
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

    // Lightweight rich-text editor (contenteditable + hidden textarea sync)
    document.querySelectorAll('.rt').forEach(function(rt){
      var area = rt.querySelector('.rt-area');
      var target = document.getElementById(rt.getAttribute('data-target'));
      function sync(){ if(target) target.value = area.innerHTML; }
      rt.querySelectorAll('[data-cmd]').forEach(function(btn){
        btn.addEventListener('click', function(){
          var cmd = btn.getAttribute('data-cmd'), val = btn.getAttribute('data-val') || null;
          area.focus();
          if(cmd === 'createLink'){ var u = prompt('Link URL:', 'https://'); if(u){ document.execCommand('createLink', false, u); } }
          else { document.execCommand(cmd, false, val); }
          sync();
        });
      });
      area.addEventListener('input', sync);
      area.addEventListener('blur', sync);
      var form = rt.closest('form'); if(form){ form.addEventListener('submit', sync); }
    });
  })();
</script>
</body>
</html>
