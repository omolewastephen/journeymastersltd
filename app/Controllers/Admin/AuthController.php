<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Request;
use App\Core\Session;

final class AuthController extends Controller
{
    private const MAX_ATTEMPTS = 5;
    private const LOCK_SECONDS = 60;

    public function showLogin(): void
    {
        if (Auth::check()) {
            $this->redirect('/admin');
        }
        // Standalone page (no admin chrome) — layout: null.
        $this->view('admin/login', [
            'title'     => 'Admin Login — Journey Masters Ltd',
            'error'     => Session::flash('login_error'),
            'oldEmail'  => Session::flash('old_email') ?? '',
        ], null);
    }

    public function login(): void
    {
        $request = new Request();

        if (!Csrf::verify($request->input('_csrf'))) {
            Session::flash('login_error', 'Your session expired. Please try again.');
            $this->redirect('/admin/login');
        }

        $throttle = Session::get('login_throttle', ['count' => 0, 'until' => 0]);
        if ($throttle['count'] >= self::MAX_ATTEMPTS && time() < $throttle['until']) {
            Session::flash('login_error', 'Too many attempts. Please wait a minute and try again.');
            $this->redirect('/admin/login');
        }

        $email    = (string) $request->input('email');
        $password = (string) $request->input('password');

        if (Auth::attempt($email, $password)) {
            Session::set('login_throttle', ['count' => 0, 'until' => 0]);
            $this->redirect('/admin');
        }

        Session::set('login_throttle', [
            'count' => ($throttle['count'] ?? 0) + 1,
            'until' => time() + self::LOCK_SECONDS,
        ]);
        Session::flash('login_error', 'Invalid email or password.');
        Session::flash('old_email', $email);
        $this->redirect('/admin/login');
    }

    public function logout(): void
    {
        Auth::logout();
        $this->redirect('/admin/login');
    }
}
