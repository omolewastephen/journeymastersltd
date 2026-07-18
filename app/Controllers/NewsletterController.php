<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Database;
use App\Core\Request;
use App\Core\Session;
use App\Repositories\Messages;

final class NewsletterController extends Controller
{
    public function subscribe(): void
    {
        $request = new Request();
        $email   = (string) $request->input('email');

        if (!Csrf::verify($request->input('_csrf'))) {
            Session::flash('news_error', 'Session expired — please try again.');
            $this->back();
        }

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Session::flash('news_error', 'Please enter a valid email address.');
            $this->back();
        }

        $row = ['email' => $email, 'ip' => $request->ip(), 'created_at' => date('Y-m-d H:i:s')];

        $pdo = Database::connection();
        if ($pdo !== null) {
            $stmt = $pdo->prepare('INSERT IGNORE INTO subscribers (email, ip_address, created_at) VALUES (:email, :ip, :created_at)');
            $stmt->execute($row);
        } else {
            Messages::appendSubscriber($row);
        }

        Session::flash('news_success', 'You\'re subscribed — welcome aboard!');
        $this->back();
    }
}
