<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Request;
use App\Core\Session;
use App\Core\Validator;
use App\Repositories\Messages;

final class ContactController extends Controller
{
    public function show(): void
    {
        $this->view('pages/contact', [
            'title'       => 'Contact Us — Journey Masters Ltd',
            'description' => 'Book a free consultation. Call, WhatsApp or send us a message — we\'re based in Abeokuta, Ogun State, Nigeria.',
            'services'    => \App\Repositories\Content::services(),
        ]);
    }

    public function submit(): void
    {
        $request = new Request();

        // 1. CSRF
        if (!Csrf::verify($request->input('_csrf'))) {
            Session::flash('error', 'Your session expired. Please try again.');
            $this->redirect('/contact');
        }

        // 2. Honeypot (silent bot trap)
        if ($request->input('website') !== '' && $request->input('website') !== null) {
            $this->redirect('/contact#form');
        }

        // 3. Validate
        $validator = new Validator($request->all());
        $ok = $validator->validate([
            'name'    => 'required|min:2|max:120',
            'email'   => 'required|email|max:180',
            'phone'   => 'required|phone',
            'service' => 'required|max:120',
            'message' => 'required|min:10|max:2000',
        ]);

        if (!$ok) {
            Session::flash('errors', $validator->errors());
            Session::flashOld($request->all());
            $this->redirect('/contact#form');
        }

        // 4. Persist (DB when enabled) + notify
        Messages::store([
            'name'    => $request->input('name'),
            'email'   => $request->input('email'),
            'phone'   => $request->input('phone'),
            'service' => $request->input('service'),
            'message' => $request->input('message'),
            'ip'      => $request->ip(),
        ]);

        $this->sendMail($request);

        Session::flash('success', 'Thank you — your message is on its way. We\'ll be in touch shortly.');
        Session::clearOld();
        $this->redirect('/contact#form');
    }

    private function sendMail(Request $request): void
    {
        $to      = config('mail.to');
        $subject = config('mail.subject');
        $body    = "New enquiry from journeymastersltd.com\n\n"
            . 'Name: '    . $request->input('name') . "\n"
            . 'Email: '   . $request->input('email') . "\n"
            . 'Phone: '   . $request->input('phone') . "\n"
            . 'Service: ' . $request->input('service') . "\n\n"
            . "Message:\n" . $request->input('message') . "\n";

        $headers = 'From: ' . config('mail.from') . "\r\n"
            . 'Reply-To: ' . $request->input('email') . "\r\n"
            . 'Content-Type: text/plain; charset=UTF-8';

        // mail() is a no-op on many local setups; wrapped so it never fatals.
        if (function_exists('mail') && !config('app.debug')) {
            @mail($to, $subject, $body, $headers);
        }
    }
}
