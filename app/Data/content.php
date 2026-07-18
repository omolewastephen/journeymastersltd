<?php
/**
 * Editable site content. Mirrors the eventual MySQL tables so the array-backed
 * repository can be swapped for PDO queries later with no view changes.
 * Icons are inline SVG paths rendered inside a <svg viewBox="0 0 24 24">.
 */

return [

    /* ---------------------------------------------------------------- STATS */
    'stats' => [
        ['value' => 42,   'suffix' => '+',    'label' => 'Countries served'],
        ['value' => 7500, 'suffix' => '+',    'label' => 'Visas & permits processed'],
        ['value' => 5200, 'suffix' => '+',    'label' => 'Happy clients'],
        ['value' => 9,    'suffix' => ' yrs', 'label' => 'Of trusted experience'],
    ],

    /* -------------------------------------------------------------- PROCESS */
    'process' => [
        ['n' => '01', 'title' => 'Free consultation',      'desc' => 'We assess your goal, budget and eligibility, then recommend the best route.'],
        ['n' => '02', 'title' => 'Documentation',          'desc' => 'We prepare proof of funds, admissions and a complete, credible file.'],
        ['n' => '03', 'title' => 'Submission & interview',  'desc' => 'We lodge your application and coach you through biometrics and interviews.'],
        ['n' => '04', 'title' => 'Approval & travel',       'desc' => 'Visa granted — we brief you on next steps and you\'re cleared for takeoff.'],
    ],

    /* ------------------------------------------------------------- SERVICES */
    'services' => [
        [
            'slug'     => 'proof-of-funds',
            'title'    => 'Proof of Funds',
            'tagline'  => 'Verifiable, embassy-ready financial documentation.',
            'icon'     => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 10h18M7 15h4"/>',
            'summary'  => 'Account funding, new accounts, investment certificates, sponsorship statements & financial support letters — verifiable and embassy-ready.',
            'overview' => [
                'A convincing proof of funds is often the single biggest reason applications succeed or fail. We arrange legitimate, verifiable financial documentation through proper channels so it withstands consular scrutiny — never anything fraudulent.',
                'Whether you need to top up an existing account, open a new one, or produce a sponsorship statement, we structure it correctly for your destination and visa category.',
            ],
            'benefits' => [
                'Funding for existing accounts',
                'Opening & structuring new accounts',
                'Investment certificates',
                'Sponsorship account statements',
                'Financial support documentation',
                'Guidance on the amount required per country',
            ],
            'requirements' => [
                'Valid international passport',
                'Target country and programme',
                'Intended travel/study timeline',
                'Any existing bank details (optional)',
            ],
            'timeline' => [
                ['title' => 'Assessment', 'desc' => 'We confirm the exact amount and format your embassy expects.'],
                ['title' => 'Arrangement', 'desc' => 'We put the funds and paperwork in place through proper channels.'],
                ['title' => 'Verification', 'desc' => 'You receive documents that are genuine and independently verifiable.'],
            ],
            'image' => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?auto=format&fit=crop&w=1200&q=80',
            'faqs'  => [
                ['q' => 'Is the proof of funds genuine and verifiable?', 'a' => 'Yes. Everything is arranged through proper, legitimate channels so it withstands consular verification. We never provide fraudulent documents.'],
                ['q' => 'How much do I need to show?', 'a' => 'It depends on your destination and programme. We calculate the exact figure during your free consultation.'],
            ],
        ],
        [
            'slug'     => 'study-admission',
            'title'    => 'Study Admission',
            'tagline'  => 'Placements into top institutions in Canada, the UK & Europe.',
            'icon'     => '<path d="M22 10L12 5 2 10l10 5 10-5z"/><path d="M6 12v5c0 1 2.7 2.5 6 2.5s6-1.5 6-2.5v-5"/>',
            'summary'  => 'Placements into top institutions across Canada, the UK and Europe — course matching, applications and offer letters.',
            'overview' => [
                'We match you to the right course and institution for your profile and budget, then manage the entire application through to your offer letter.',
                'Our admissions specialists know what each school looks for, so your application is positioned to succeed the first time.',
            ],
            'benefits' => [
                'Course & institution matching',
                'Full application management',
                'Statement of purpose guidance',
                'Offer-letter follow-through',
                'Scholarship & funding advice',
                'Canada, UK & Europe coverage',
            ],
            'requirements' => [
                'Academic transcripts & certificates',
                'International passport',
                'CV / résumé (where relevant)',
                'English proficiency results (if available)',
            ],
            'timeline' => [
                ['title' => 'Profiling', 'desc' => 'We shortlist courses and schools that fit your goals and budget.'],
                ['title' => 'Application', 'desc' => 'We prepare and submit strong applications on your behalf.'],
                ['title' => 'Offer', 'desc' => 'We follow up until your offer letter is issued.'],
            ],
            'image' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=1200&q=80',
            'faqs'  => [
                ['q' => 'Can you help with scholarships?', 'a' => 'Yes — where you qualify, we identify scholarship and funding options and guide your applications.'],
                ['q' => 'Do I need IELTS?', 'a' => 'Many institutions require English proficiency, but requirements vary. We advise you based on your chosen school.'],
            ],
        ],
        [
            'slug'     => 'visa-processing',
            'title'    => 'Visa Processing',
            'tagline'  => 'Flawless study-visa applications for Canada, UK & Europe.',
            'icon'     => '<rect x="5" y="3" width="14" height="18" rx="2"/><circle cx="12" cy="9" r="2.5"/><path d="M8 16h8"/>',
            'summary'  => 'Canada, UK & Europe study visas — flawless applications, biometrics guidance and interview preparation.',
            'overview' => [
                'A single missing document can cost you a year. We build a complete, credible visa application and coach you through every step — biometrics, medicals and the interview.',
                'Refused before? We review what went wrong and rebuild a stronger case.',
            ],
            'benefits' => [
                'Complete application preparation',
                'Document checklist & review',
                'Biometrics & medicals guidance',
                'Interview preparation & coaching',
                'Re-application after refusal',
                'Canada, UK & Europe study visas',
            ],
            'requirements' => [
                'Admission / offer letter',
                'Proof of funds',
                'Valid international passport',
                'Academic & identity documents',
            ],
            'timeline' => [
                ['title' => 'File build', 'desc' => 'We assemble a complete, consistent application file.'],
                ['title' => 'Submission', 'desc' => 'We lodge the application and book biometrics.'],
                ['title' => 'Interview prep', 'desc' => 'We coach you so you walk in confident and prepared.'],
            ],
            'image' => 'https://images.unsplash.com/photo-1569098644584-210bcd375b59?auto=format&fit=crop&w=1200&q=80',
            'faqs'  => [
                ['q' => 'Do you help after a refusal?', 'a' => 'Absolutely. Many clients come to us post-refusal. We diagnose the issue and rebuild a credible application.'],
                ['q' => 'How long does it take?', 'a' => 'It varies by country and season — typically a few weeks to a couple of months. We give you a realistic timeline upfront.'],
            ],
        ],
        [
            'slug'     => 'canada-work-permit',
            'title'    => 'Canada Work Permit',
            'tagline'  => 'Employer-backed and open work-permit pathways.',
            'icon'     => '<rect x="3" y="7" width="18" height="13" rx="2"/><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>',
            'summary'  => 'Employer-backed and open work permit pathways with complete documentation and eligibility screening.',
            'overview' => [
                'We screen your eligibility across Canada\'s work-permit pathways and prepare a complete, compliant application.',
                'From employer-backed permits to open work permits, we guide you end to end.',
            ],
            'benefits' => [
                'Eligibility screening',
                'Employer-backed permit support',
                'Open work permit guidance',
                'Complete documentation',
                'Relocation guidance',
                'Family accompaniment advice',
            ],
            'requirements' => [
                'Valid international passport',
                'Job offer / LMIA (where applicable)',
                'Work history & references',
                'Proof of funds',
            ],
            'timeline' => [
                ['title' => 'Screening', 'desc' => 'We confirm the pathway you qualify for.'],
                ['title' => 'Preparation', 'desc' => 'We compile a compliant, complete application.'],
                ['title' => 'Submission', 'desc' => 'We lodge it and track it to decision.'],
            ],
            'image' => 'https://images.unsplash.com/photo-1517935706615-2717063c2225?auto=format&fit=crop&w=1200&q=80',
            'faqs'  => [
                ['q' => 'Do I need a job offer first?', 'a' => 'Some pathways require one, others don\'t. We assess your best route during the consultation.'],
                ['q' => 'Can my family come with me?', 'a' => 'In many cases yes. We advise on spouse and dependant options.'],
            ],
        ],
        [
            'slug'     => 'new-zealand-work-visa',
            'title'    => 'New Zealand Work Visa',
            'tagline'  => 'Accredited-employer work visa support.',
            'icon'     => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c3 3.5 3 14 0 18M12 3c-3 3.5-3 14 0 18"/>',
            'summary'  => 'Accredited-employer work visa support with job-offer verification and relocation guidance.',
            'overview' => [
                'New Zealand\'s accredited-employer work visa opens a clear route to living and working there. We verify your job offer and manage the application.',
                'We guide you through relocation so the move is smooth and stress-free.',
            ],
            'benefits' => [
                'Accredited-employer pathway support',
                'Job-offer verification',
                'Complete application handling',
                'Relocation guidance',
                'Family visa advice',
                'Honest eligibility screening',
            ],
            'requirements' => [
                'Valid international passport',
                'Job offer from an accredited employer',
                'Relevant work experience',
                'Proof of funds',
            ],
            'timeline' => [
                ['title' => 'Verification', 'desc' => 'We confirm your job offer and employer accreditation.'],
                ['title' => 'Application', 'desc' => 'We prepare and submit your work-visa application.'],
                ['title' => 'Relocation', 'desc' => 'We brief you on arrival and settling in.'],
            ],
            'image' => 'https://images.unsplash.com/photo-1507699622108-4be3abd695ad?auto=format&fit=crop&w=1200&q=80',
            'faqs'  => [
                ['q' => 'Do I need an accredited employer?', 'a' => 'The main pathway requires an accredited-employer job offer. We help verify this before you apply.'],
                ['q' => 'How long is the visa valid?', 'a' => 'Validity depends on your role and employer. We confirm the details for your specific case.'],
            ],
        ],
        [
            'slug'     => 'visit-visa',
            'title'    => 'Visit Visa',
            'tagline'  => 'Tourist & family-visit visas with credible applications.',
            'icon'     => '<path d="M17 2l1.5 4.5L23 8l-4.5 1.5L17 14l-1.5-4.5L11 8l4.5-1.5z"/><path d="M6 12l1 3 3 1-3 1-1 3-1-3-3-1 3-1z"/>',
            'summary'  => 'Tourist and family-visit visas with strong, credible applications that satisfy consular requirements.',
            'overview' => [
                'A visit visa needs to demonstrate genuine intent and strong ties. We build applications that satisfy consular officers.',
                'Whether it\'s tourism or visiting family, we present your case clearly and credibly.',
            ],
            'benefits' => [
                'Tourist visa applications',
                'Family-visit visas',
                'Invitation-letter handling',
                'Strong ties documentation',
                'Itinerary & accommodation guidance',
                'Interview preparation',
            ],
            'requirements' => [
                'Valid international passport',
                'Proof of funds',
                'Purpose of visit / invitation',
                'Ties to home country',
            ],
            'timeline' => [
                ['title' => 'Planning', 'desc' => 'We map your purpose, dates and documents.'],
                ['title' => 'Application', 'desc' => 'We prepare a credible, complete submission.'],
                ['title' => 'Decision', 'desc' => 'We prepare you for any interview and track the outcome.'],
            ],
            'image' => 'https://images.unsplash.com/photo-1488085061387-422e29b40080?auto=format&fit=crop&w=1200&q=80',
            'faqs'  => [
                ['q' => 'Can you help with an invitation letter?', 'a' => 'Yes. We guide the invitation process and ensure it supports your application.'],
                ['q' => 'How do I show strong ties?', 'a' => 'We help you assemble the right evidence of your commitments at home.'],
            ],
        ],
        [
            'slug'     => 'conference-visa',
            'title'    => 'Conference Visa',
            'tagline'  => 'Canada & Schengen conference and business-event visas.',
            'icon'     => '<rect x="9" y="3" width="6" height="11" rx="3"/><path d="M6 11a6 6 0 0 0 12 0M12 17v4M9 21h6"/>',
            'summary'  => 'Canada & Schengen conference and business-event visas — invitation handling and full application support.',
            'overview' => [
                'Attending a conference abroad on a deadline? We handle invitation letters and the full application for Canada and Schengen events.',
                'We move fast without cutting corners, so your paperwork is credible and complete.',
            ],
            'benefits' => [
                'Canada conference visas',
                'Schengen conference visas',
                'Invitation-letter handling',
                'Business-event documentation',
                'Fast, deadline-aware processing',
                'Interview preparation',
            ],
            'requirements' => [
                'Valid international passport',
                'Conference invitation / registration',
                'Proof of funds',
                'Employment / business details',
            ],
            'timeline' => [
                ['title' => 'Invitation', 'desc' => 'We handle the invitation and registration paperwork.'],
                ['title' => 'Application', 'desc' => 'We prepare and submit your conference visa.'],
                ['title' => 'Decision', 'desc' => 'We track it and prep you for any interview.'],
            ],
            'image' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=1200&q=80',
            'faqs'  => [
                ['q' => 'Which countries do you cover?', 'a' => 'Canada and the Schengen area are our core conference-visa destinations.'],
                ['q' => 'Can you work to a tight deadline?', 'a' => 'Yes — conference visas are often time-sensitive and we process them accordingly.'],
            ],
        ],
    ],

    /* --------------------------------------------------------- DESTINATIONS */
    'destinations' => [
        [
            'slug'      => 'canada',
            'country'   => 'Canada',
            'title'     => 'Study, Work & Settle in Canada',
            'image'     => 'https://images.unsplash.com/photo-1503614472-8c93d56e92ce?auto=format&fit=crop&w=1400&q=80',
            'duration'  => 'Study · Work · PR pathways',
            'intro'     => 'Canada remains the top choice for Nigerians seeking world-class education, generous work rights and clear routes to permanent residence.',
            'highlights'=> ['Post-graduation work permits', 'Clear PR pathways', 'Affordable, high-quality education', 'Welcoming to families'],
            'requirements' => ['Admission / job offer', 'Proof of funds', 'Valid passport', 'Biometrics & medicals'],
            'services'  => ['study-admission', 'visa-processing', 'canada-work-permit', 'proof-of-funds'],
            'gallery'   => [
                'https://images.unsplash.com/photo-1517935706615-2717063c2225?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1519832979-6fa011b87667?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1609825488888-3a766db05542?auto=format&fit=crop&w=800&q=80',
            ],
        ],
        [
            'slug'      => 'united-kingdom',
            'country'   => 'United Kingdom',
            'title'     => 'World-class Education in the UK',
            'image'     => 'https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?auto=format&fit=crop&w=1400&q=80',
            'duration'  => 'Study · Graduate route',
            'intro'     => 'Globally respected universities, a two-year graduate work route and a short flight home make the UK a favourite for Nigerian students.',
            'highlights'=> ['Prestigious universities', 'Graduate work route', 'One-year Master\'s options', 'Rich Nigerian community'],
            'requirements' => ['Admission / CAS', 'Proof of funds', 'Valid passport', 'English proficiency'],
            'services'  => ['study-admission', 'visa-processing', 'proof-of-funds'],
            'gallery'   => [
                'https://images.unsplash.com/photo-1486299267070-83823f5448dd?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1520986606214-8b456906c813?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1471623320832-752e8bbf8413?auto=format&fit=crop&w=800&q=80',
            ],
        ],
        [
            'slug'      => 'europe',
            'country'   => 'Europe & Schengen',
            'title'     => 'Study & Conferences across Europe',
            'image'     => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=1400&q=80',
            'duration'  => 'Study · Schengen · Conference',
            'intro'     => 'From affordable tuition to Schengen mobility, Europe offers world-class study and conference opportunities across dozens of countries.',
            'highlights'=> ['Low / no tuition options', 'Schengen mobility', 'Conference & business visas', 'Diverse programmes in English'],
            'requirements' => ['Admission / invitation', 'Proof of funds', 'Valid passport', 'Travel insurance'],
            'services'  => ['study-admission', 'visa-processing', 'conference-visa', 'proof-of-funds'],
            'gallery'   => [
                'https://images.unsplash.com/photo-1499856871958-5b9627545d1a?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1467269204594-9661b134dd2b?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1541849546-216549ae216d?auto=format&fit=crop&w=800&q=80',
            ],
        ],
    ],

    /* ----------------------------------------------------------- TESTIMONIALS */
    'testimonials' => [
        ['name' => 'Adaeze O.',  'role' => 'Study Permit · Canada',          'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=200&q=80', 'quote' => 'My Canada study permit was approved in weeks. They handled my proof of funds and admission so professionally — I never once felt lost.'],
        ['name' => 'Tunde A.',   'role' => 'Student Visa · United Kingdom',   'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=200&q=80', 'quote' => 'After two rejections elsewhere, Journey Masters rebuilt my UK application from scratch. Approved. I\'m now doing my Master\'s in Manchester.'],
        ['name' => 'Grace E.',   'role' => 'Work Visa · New Zealand',         'avatar' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=200&q=80', 'quote' => 'The New Zealand work visa felt impossible until I met this team. Clear steps, honest advice, and constant updates. Forever grateful.'],
        ['name' => 'Ibrahim K.', 'role' => 'Conference Visa · Schengen',      'avatar' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=200&q=80', 'quote' => 'Needed a Schengen conference visa on a tight deadline. They sorted the invitation and paperwork fast. Smooth, premium service.'],
    ],

    /* ------------------------------------------------------------------ FAQ */
    'faqs' => [
        ['q' => 'Is proof of funds from your service genuine and verifiable?', 'a' => 'Yes. We arrange legitimate, verifiable financial documentation through proper channels so it withstands consular scrutiny. We never provide anything fraudulent.'],
        ['q' => 'How long does a study visa take?', 'a' => 'It varies by country and season — typically a few weeks to a couple of months. During your consultation we give you a realistic, honest timeline for your specific case.'],
        ['q' => 'Do you help if I\'ve been refused before?', 'a' => 'Absolutely. Many of our clients come to us after a refusal. We review what went wrong and rebuild a stronger, credible application.'],
        ['q' => 'Where is your office?', 'a' => 'We\'re based in Abeokuta, Ogun State, Nigeria, and serve clients nationwide. Call 0707 171 2755 or message us on WhatsApp to book a visit.'],
        ['q' => 'How much do your services cost?', 'a' => 'Fees depend on the service and destination. Your initial consultation is free, and we\'ll give you clear, itemised pricing before any commitment.'],
    ],

    /* ----------------------------------------------------------------- BLOG */
    'posts' => [
        [
            'slug'    => 'canada-study-permit-2025-checklist',
            'title'   => 'Canada Study Permit 2025: the complete checklist',
            'category'=> 'Study Abroad',
            'read'    => '6 min',
            'date'    => '2025-01-14',
            'image'   => 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?auto=format&fit=crop&w=1200&q=80',
            'excerpt' => 'Everything you need — from proof of funds to biometrics — in the right order.',
            'body'    => [
                'Applying for a Canada study permit is straightforward when you tackle it in the right order. This guide walks you through each document and milestone.',
                'Start with your admission letter, then your proof of funds, then biometrics. Getting these three right removes most of the risk from your application.',
                'Book a free consultation and we\'ll build your file with you, step by step.',
            ],
        ],
        [
            'slug'    => 'why-visa-applications-get-refused',
            'title'   => 'Why visa applications get refused (and how to avoid it)',
            'category'=> 'Visas',
            'read'    => '5 min',
            'date'    => '2025-02-03',
            'image'   => 'https://images.unsplash.com/photo-1541746972996-4e0b0f43e02a?auto=format&fit=crop&w=1200&q=80',
            'excerpt' => 'The five most common mistakes we fix for clients every single week.',
            'body'    => [
                'Most refusals come down to a handful of avoidable mistakes: weak proof of funds, inconsistent documents, and unclear intent.',
                'We break down each one and show you how to present a credible, consistent application.',
            ],
        ],
        [
            'slug'    => 'new-zealand-work-visas-2025',
            'title'   => 'New Zealand work visas: is 2025 your year?',
            'category'=> 'Work Abroad',
            'read'    => '7 min',
            'date'    => '2025-03-09',
            'image'   => 'https://images.unsplash.com/photo-1521295121783-8a321d551ad2?auto=format&fit=crop&w=1200&q=80',
            'excerpt' => 'Accredited-employer pathways explained, plus who qualifies right now.',
            'body'    => [
                'New Zealand\'s accredited-employer work visa is one of the clearest routes to working abroad in 2025.',
                'Here\'s who qualifies, what you need, and how we help verify your job offer before you apply.',
            ],
        ],
    ],
];
