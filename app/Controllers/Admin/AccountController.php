<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\Request;
use App\Core\Session;
use App\Core\Validator;
use App\Repositories\Users;

final class AccountController extends AdminController
{
    public function edit(): void
    {
        $this->admin('password', [
            'title'  => 'Change Password',
            'errors' => Session::flash('pw_errors') ?: [],
        ]);
    }

    public function update(): void
    {
        $request = new Request();

        if (!Csrf::verify($request->input('_csrf'))) {
            $this->redirect('/admin/password');
        }

        $validator = new Validator($request->all());
        $validator->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:8',
            'confirm_password' => 'required',
        ], [
            'current_password' => 'Current password',
            'new_password'     => 'New password',
            'confirm_password' => 'Confirmation',
        ]);
        $errors = $validator->errors();

        $user = Auth::user();
        if (!isset($errors['current_password']) && $user && !password_verify((string) $request->input('current_password'), (string) $user['password'])) {
            $errors['current_password'] = 'Your current password is incorrect.';
        }
        if (!isset($errors['new_password']) && $request->input('new_password') !== $request->input('confirm_password')) {
            $errors['confirm_password'] = 'Passwords do not match.';
        }

        if ($errors !== []) {
            Session::flash('pw_errors', $errors);
            $this->redirect('/admin/password');
        }

        Users::updatePassword((int) $user['id'], password_hash((string) $request->input('new_password'), PASSWORD_DEFAULT));
        Session::flash('admin_ok', 'Password updated successfully.');
        $this->redirect('/admin/password');
    }
}
