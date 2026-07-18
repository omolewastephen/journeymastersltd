<?php
/** @var string $content  @var string $title  @var string $description */
$title       = $title ?? config('app.name');
$description  = $description ?? 'Premium travel, study-abroad and visa consultancy in Abeokuta, Nigeria.';
$bodyClass    = $bodyClass ?? '';
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
  <title><?= e($title) ?></title>
  <meta name="description" content="<?= e($description) ?>" />
  <meta name="theme-color" content="#020255" />
  <link rel="icon" type="image/png" href="<?= asset('img/logo.png') ?>" />
  <link rel="canonical" href="<?= e(canonical_url()) ?>" />

  <meta property="og:type" content="website" />
  <meta property="og:title" content="<?= e($title) ?>" />
  <meta property="og:description" content="<?= e($description) ?>" />
  <meta property="og:image" content="<?= asset('img/logo.png') ?>" />
  <meta name="twitter:card" content="summary_large_image" />

  <link rel="preconnect" href="https://api.fontshare.com" crossorigin />
  <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="preconnect" href="https://images.unsplash.com" />
  <link href="https://api.fontshare.com/v2/css?f[]=satoshi@400,500,700,900&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link rel="stylesheet" href="<?= asset('css/design-system.css') ?>" />

  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "TravelAgency",
    "name": "<?= e(config('business.legal_name')) ?>",
    "telephone": "<?= e(biz('phone_intl')) ?>",
    "email": "<?= e(biz('email')) ?>",
    "areaServed": ["Canada","United Kingdom","Europe","New Zealand"],
    "address": { "@type": "PostalAddress", "addressLocality": "<?= e(biz('city')) ?>", "addressRegion": "<?= e(biz('region')) ?>", "addressCountry": "NG" },
    "url": "https://journeymastersltd.com"
  }
  </script>
</head>
<body class="<?= e($bodyClass) ?>">

  <a class="skip-link" href="#main">Skip to content</a>

  <div class="loader" id="loader" aria-hidden="true">
    <img src="<?= asset('img/logo-white.png') ?>" alt="" class="loader-logo" />
    <span class="loader-bar" id="loaderBar"></span>
  </div>
  <div class="scroll-prog" id="scrollProg" aria-hidden="true"></div>

  <?php require BASE_PATH . '/app/Views/partials/nav.php'; ?>

  <main id="main"><?= $content ?></main>

  <?php require BASE_PATH . '/app/Views/partials/footer.php'; ?>
  <?php require BASE_PATH . '/app/Views/partials/dock.php'; ?>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/MotionPathPlugin.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@studio-freight/lenis@1.0.42/dist/lenis.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="<?= asset('js/app.js') ?>" defer></script>
</body>
</html>
