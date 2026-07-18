<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\View;
use App\Repositories\Messages;

/**
 * Base for all authenticated admin controllers. Guards every action.
 */
abstract class AdminController extends Controller
{
    public function __construct()
    {
        if (!Auth::check()) {
            $this->redirect('/admin/login');
        }
    }

    /** Render an admin view inside the admin chrome. */
    protected function admin(string $view, array $data = []): void
    {
        $data['authUser'] = Auth::user();
        $data['unread']   = Messages::unreadCount();
        echo View::render('admin/' . $view, $data, 'admin/layout');
    }
}
