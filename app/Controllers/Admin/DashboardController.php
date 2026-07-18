<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Repositories\Content;
use App\Repositories\Messages;
use App\Repositories\Subscribers;

final class DashboardController extends AdminController
{
    public function index(): void
    {
        $this->admin('dashboard', [
            'title'  => 'Dashboard',
            'stats'  => [
                'messages'    => Messages::count(),
                'unread'      => Messages::unreadCount(),
                'subscribers' => Subscribers::count(),
                'services'    => count(Content::services()),
            ],
            'recent' => Messages::recent(6),
        ]);
    }
}
