<?php /** @var array $services,$destinations,$testimonials,$faqs,$stats,$process,$posts */ ?>

<!-- ===================== HERO ===================== -->
<section class="hero" aria-label="Introduction">
  <img id="heroImg" class="hero-bg" src="https://images.unsplash.com/photo-1436491865332-7a61a109cc05?auto=format&fit=crop&w=2400&q=80"
       alt="Aircraft wing above a golden layer of clouds" data-fallback fetchpriority="high" decoding="async" />
  <span class="hero-glow g1" id="glow1" aria-hidden="true"></span>
  <span class="hero-glow g2" id="glow2" aria-hidden="true"></span>
  <span class="grain" aria-hidden="true"></span>
  <span class="hero-chip float-el chip-1" data-float="0.05" aria-hidden="true">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg> Visa approved
  </span>
  <span class="hero-chip float-el chip-2" data-float="-0.08" aria-hidden="true">
    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M2 12l20-8-6 20-3-8z"/></svg> Toronto · London · Schengen
  </span>
  <svg class="route-svg hero-route" viewBox="0 0 1440 900" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
    <path id="routePath" class="route" d="M-40,690 C260,560 420,760 700,600 C980,440 1180,560 1520,300" />
    <g id="routePlane" class="route-plane" opacity="0"><path d="M0,-9 L22,0 L0,9 L5,0 Z" transform="scale(1.5)"/></g>
  </svg>

  <div class="container hero-content">
    <div class="hero-copy">
      <span class="overline on-dark" data-hero="1">Abeokuta · Canada · UK · Europe · New Zealand</span>
      <h1 class="display hero-title">
        <span class="split-line"><span data-hero="2">Your journey,</span></span>
        <span class="split-line"><span data-hero="3">mastered<span class="accent">.</span></span></span>
      </h1>
      <p class="lead hero-sub" data-hero="4">Proof of funds, study admissions, work permits and visas — handled end-to-end by specialists who get the details right the first time.</p>
      <div class="hero-actions" data-hero="5">
        <a href="<?= url('/contact') ?>" class="btn btn--primary btn--lg magnetic">Book a Free Consultation
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
        <a href="<?= e(biz('whatsapp')) ?>" target="_blank" rel="noopener" class="btn btn--on-dark btn--lg magnetic">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2a10 10 0 0 0-8.6 15l-1.3 4.8 4.9-1.3A10 10 0 1 0 12 2zm4.4 12c-.2-.1-1.4-.7-1.6-.8s-.4-.1-.5.1-.6.8-.8 1-.3.2-.5 0a6.5 6.5 0 0 1-1.9-1.2 7.2 7.2 0 0 1-1.4-1.7c-.1-.3 0-.4.1-.5l.4-.5.3-.5v-.4l-.8-1.8c-.2-.5-.4-.4-.5-.4h-.5a1 1 0 0 0-.7.3 3 3 0 0 0-.9 2.2 5.2 5.2 0 0 0 1.1 2.7 11.8 11.8 0 0 0 4.6 4c.6.3 1.1.4 1.5.6a3.6 3.6 0 0 0 1.6.1c.5-.1 1.4-.6 1.6-1.1a2 2 0 0 0 .1-1.1c0-.1-.2-.2-.4-.3z"/></svg>
          WhatsApp Us</a>
      </div>
      <div class="hero-trust" data-hero="6">
        <div class="trust-item"><span class="ico"><svg viewBox="0 0 24 24" width="20" fill="none" stroke="var(--red)" stroke-width="2" aria-hidden="true"><path d="M12 2l8 4v6c0 5-3.5 8-8 10-4.5-2-8-5-8-10V6z"/><path d="M9 12l2 2 4-4"/></svg></span><div class="t"><strong>Embassy-ready</strong><br><small>documentation</small></div></div>
        <div class="trust-item"><span class="ico"><svg viewBox="0 0 24 24" width="20" fill="none" stroke="var(--red)" stroke-width="2" aria-hidden="true"><path d="M20 6L9 17l-5-5"/></svg></span><div class="t"><strong>98% visa</strong><br><small>success rate</small></div></div>
        <div class="trust-item"><span class="ico"><svg viewBox="0 0 24 24" width="20" fill="none" stroke="var(--red)" stroke-width="2" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-6 8-6s8 2 8 6"/></svg></span><div class="t"><strong>Licensed</strong><br><small>RC-registered agency</small></div></div>
      </div>
    </div>
  </div>
  <a href="#trust" class="hero-scroll">Scroll<span class="scroll-mouse"><span class="scroll-dot"></span></span></a>
</section>

<!-- ===================== TRUST MARQUEE ===================== -->
<section id="trust" class="section-sm trust-strip" aria-label="Our specialities">
  <div class="container kicker-row"><p class="kicker">Trusted for high-stakes travel &amp; migration since <?= e((string) biz('founded')) ?></p></div>
  <div class="marquee"><div class="marquee-track" aria-hidden="true">
    <span>Canada Study Permits</span><span>UK Student Visas</span><span>Schengen Conference Visas</span><span>Proof of Funds</span><span>New Zealand Work Visas</span><span>Canada Work Permits</span><span>Visit Visas</span>
    <span>Canada Study Permits</span><span>UK Student Visas</span><span>Schengen Conference Visas</span><span>Proof of Funds</span><span>New Zealand Work Visas</span><span>Canada Work Permits</span><span>Visit Visas</span>
  </div></div>
</section>

<!-- ===================== STATS ===================== -->
<section class="section stats-band" aria-label="Our track record">
  <img class="bg-map" src="<?= asset('img/map.png') ?>" alt="" loading="lazy" decoding="async" />
  <div class="container">
    <div class="stats-grid">
      <?php foreach ($stats as $stat): ?>
        <div class="stat" data-reveal><div class="num" data-count="<?= (int) $stat['value'] ?>">0<span class="suf"><?= e($stat['suffix']) ?></span></div><div class="lbl"><?= e($stat['label']) ?></div></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ===================== SERVICES ===================== -->
<section id="services" class="section bg-cloud" aria-labelledby="services-title">
  <div class="container">
    <div class="section-head">
      <div class="lede"><span class="overline" data-reveal>What we do</span>
        <h2 class="h2" id="services-title" data-reveal>Everything you need to leave — <br>handled under one roof.</h2></div>
      <p class="note" data-reveal>From the first document to the visa stamp, we manage the entire journey so nothing is left to chance.</p>
    </div>
    <div class="grid-auto">
      <?php foreach ($services as $s): ?>
        <article class="card service-card" data-reveal>
          <div class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><?= $s['icon'] ?></svg></div>
          <h3><?= e($s['title']) ?></h3>
          <p><?= e($s['summary']) ?></p>
          <a href="<?= url('/services/' . $s['slug']) ?>" class="go">Explore service <svg viewBox="0 0 24 24" width="16" fill="none" stroke="currentColor" stroke-width="2.4" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
        </article>
      <?php endforeach; ?>
      <article class="service-card service-card--cta" data-reveal>
        <h3>Not sure where to start?</h3>
        <p>Talk to a consultant and we'll map the fastest, safest route for your goal.</p>
        <a href="<?= url('/contact') ?>" class="btn btn--on-dark btn--sm magnetic">Get free advice</a>
      </article>
    </div>
  </div>
</section>

<!-- ===================== ABOUT / WHY US ===================== -->
<section id="about" class="section" aria-labelledby="about-title">
  <div class="container split split--media">
    <div class="about-media" data-reveal="left">
      <div class="media-frame"><img class="about-img" src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=1100&q=80" alt="Consultants advising a client" data-fallback loading="lazy" decoding="async" /></div>
      <div class="card float-stat"><div class="mini-stat"><span class="ico"><svg viewBox="0 0 24 24" width="22" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 2l8 4v6c0 5-3.5 8-8 10-4.5-2-8-5-8-10V6z"/><path d="M9 12l2 2 4-4"/></svg></span><div><div class="v">98%</div><div class="l">approval rate</div></div></div></div>
    </div>
    <div class="about-copy" data-reveal="right">
      <span class="overline">Why Journey Masters</span>
      <h2 class="h2" id="about-title">A steady hand for the biggest move of your life.</h2>
      <p>Relocation is stressful, and one wrong document can cost you a year. We combine deep consular know-how with genuine care — so your file is complete, credible and submitted with confidence.</p>
      <ul class="feature-list">
        <li class="feature"><span class="ico"><svg viewBox="0 0 24 24" width="20" fill="none" stroke="var(--navy)" stroke-width="2" aria-hidden="true"><path d="M20 6L9 17l-5-5"/></svg></span><div><h3>Specialists, not generalists</h3><p>Dedicated experts per country and visa type.</p></div></li>
        <li class="feature"><span class="ico"><svg viewBox="0 0 24 24" width="20" fill="none" stroke="var(--navy)" stroke-width="2" aria-hidden="true"><path d="M12 6v6l4 2"/><circle cx="12" cy="12" r="9"/></svg></span><div><h3>Transparent timelines</h3><p>Clear milestones and honest expectations, always.</p></div></li>
        <li class="feature"><span class="ico"><svg viewBox="0 0 24 24" width="20" fill="none" stroke="var(--navy)" stroke-width="2" aria-hidden="true"><path d="M12 2a10 10 0 1 0 10 10"/><path d="M22 4L12 14l-3-3"/></svg></span><div><h3>End-to-end accountability</h3><p>One team owns your case from enquiry to boarding.</p></div></li>
      </ul>
      <a href="<?= url('/about') ?>" class="btn btn--dark magnetic">More about us</a>
    </div>
  </div>
</section>

<!-- ===================== PROCESS ===================== -->
<section id="process" class="section section--dark" aria-labelledby="process-title">
  <div class="container">
    <div class="section-intro"><span class="overline on-dark" data-reveal>How it works</span>
      <h2 class="h2" id="process-title" data-reveal>Four calm steps from enquiry to departure.</h2></div>
    <div class="grid-auto steps">
      <?php foreach ($process as $step): ?>
        <div class="step" data-reveal><span class="idx"><?= e($step['n']) ?></span><h3><?= e($step['title']) ?></h3><p><?= e($step['desc']) ?></p></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ===================== DESTINATIONS ===================== -->
<section id="destinations" class="section" aria-labelledby="destinations-title">
  <div class="container">
    <div class="section-head">
      <div class="lede"><span class="overline" data-reveal>Where we send people</span><h2 class="h2" id="destinations-title" data-reveal>Featured destinations</h2></div>
      <a href="<?= url('/destinations') ?>" class="btn btn--ghost magnetic" data-reveal>View all destinations</a>
    </div>
    <div class="grid-auto">
      <?php foreach ($destinations as $d): ?>
        <a class="dest-card" href="<?= url('/destinations/' . $d['slug']) ?>" data-reveal>
          <img src="<?= e($d['image']) ?>" alt="<?= e($d['country']) ?>" data-fallback loading="lazy" decoding="async" />
          <div class="dest-body">
            <div class="k"><svg viewBox="0 0 24 24" width="15" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M21 10c0 6-9 12-9 12s-9-6-9-12a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg> <?= e($d['country']) ?></div>
            <h3><?= e($d['title']) ?></h3>
            <div class="dest-meta"><?php foreach (array_slice($d['highlights'], 0, 3) as $h): ?><span><?= e($h) ?></span><?php endforeach; ?></div>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ===================== TESTIMONIALS ===================== -->
<section class="section bg-cloud" aria-labelledby="stories-title">
  <div class="container">
    <div class="section-intro"><span class="overline" data-reveal>Client stories</span><h2 class="h2" id="stories-title" data-reveal>Journeys we're proud of.</h2></div>
    <div class="swiper testimonials" data-reveal>
      <div class="swiper-wrapper">
        <?php foreach ($testimonials as $t): ?>
          <div class="swiper-slide"><figure class="quote-card">
            <div class="stars" aria-label="5 out of 5 stars">★★★★★</div>
            <blockquote><?= e($t['quote']) ?></blockquote>
            <figcaption class="who"><img src="<?= e($t['avatar']) ?>" alt="" data-fallback loading="lazy" decoding="async"><div><div class="n"><?= e($t['name']) ?></div><div class="r"><?= e($t['role']) ?></div></div></figcaption>
          </figure></div>
        <?php endforeach; ?>
      </div>
      <div class="swiper-pagination"></div>
    </div>
  </div>
</section>

<!-- ===================== FAQ ===================== -->
<section class="section" aria-labelledby="faq-title">
  <div class="container split split--faq">
    <div class="faq-intro" data-reveal="left">
      <span class="overline">Answers</span>
      <h2 class="h2" id="faq-title">Frequently asked questions</h2>
      <p>Still unsure about something? Our consultants are one message away.</p>
      <a href="<?= e(biz('whatsapp')) ?>" target="_blank" rel="noopener" class="btn btn--primary magnetic">Ask on WhatsApp</a>
    </div>
    <div data-reveal="right">
      <?php foreach ($faqs as $i => $faq): ?>
        <details class="faq"<?= $i === 0 ? ' open' : '' ?>>
          <summary><span><?= e($faq['q']) ?></span><span class="ic" aria-hidden="true"><svg viewBox="0 0 24 24" width="16" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M12 5v14M5 12h14"/></svg></span></summary>
          <div class="ans"><p><?= e($faq['a']) ?></p></div>
        </details>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ===================== BLOG ===================== -->
<section id="blog" class="section bg-cloud" aria-labelledby="blog-title">
  <div class="container">
    <div class="section-head">
      <div class="lede"><span class="overline" data-reveal>Insights</span><h2 class="h2" id="blog-title" data-reveal>Guides &amp; travel intelligence</h2></div>
      <a href="<?= url('/blog') ?>" class="btn btn--ghost magnetic" data-reveal>Read the blog</a>
    </div>
    <div class="grid-auto">
      <?php foreach ($posts as $p): ?>
        <a class="card post-card" href="<?= url('/blog/' . $p['slug']) ?>" data-reveal>
          <div class="thumb"><img src="<?= e($p['image']) ?>" alt="" data-fallback loading="lazy" decoding="async"></div>
          <div class="body"><div class="meta"><?= e($p['category']) ?> · <?= e($p['read']) ?></div><h3><?= e($p['title']) ?></h3><p class="excerpt"><?= e($p['excerpt']) ?></p></div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ===================== NEWSLETTER / CTA ===================== -->
<section id="contact" class="section" aria-labelledby="contact-title">
  <div class="container">
    <div class="cta-band">
      <img class="bg-map" src="<?= asset('img/map.png') ?>" alt="" loading="lazy" decoding="async" />
      <div class="split split--cta">
        <div>
          <span class="overline on-dark">Ready when you are</span>
          <h2 class="h2" id="contact-title">Let's get your journey moving.</h2>
          <p class="lead">Book a free consultation today. No obligation — just clear, expert advice on your best route abroad.</p>
          <div class="cta-actions">
            <a href="tel:<?= e(biz('phone_intl')) ?>" class="btn btn--primary btn--lg magnetic">Call <?= e(biz('phone')) ?></a>
            <a href="<?= url('/contact') ?>" class="btn btn--on-dark btn--lg magnetic">Book consultation</a>
          </div>
        </div>
        <div class="newsletter-card">
          <h3>Join our newsletter</h3>
          <p>Visa updates, scholarship alerts &amp; travel tips. No spam.</p>
          <?php if ($msg = \App\Core\Session::flash('news_success')): ?><p class="form-note form-note--ok"><?= e($msg) ?></p><?php endif; ?>
          <?php if ($msg = \App\Core\Session::flash('news_error')): ?><p class="form-note form-note--err"><?= e($msg) ?></p><?php endif; ?>
          <form class="newsletter-form" action="<?= url('/newsletter') ?>" method="post">
            <?= csrf_field() ?>
            <label class="sr-only" for="newsEmail">Email address</label>
            <input class="input" id="newsEmail" name="email" type="email" required placeholder="Your email address" autocomplete="email" />
            <button class="btn btn--primary" type="submit">Subscribe</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
