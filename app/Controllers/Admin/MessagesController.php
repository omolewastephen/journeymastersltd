<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Csrf;
use App\Core\Request;
use App\Core\Session;
use App\Repositories\Messages;

final class MessagesController extends AdminController
{
    private const PER_PAGE = 15;

    public function index(): void
    {
        $page  = max(1, (int) (new Request())->input('page', 1));
        $total = Messages::count();
        $this->admin('messages/index', [
            'title'    => 'Messages',
            'messages' => Messages::paginate($page, self::PER_PAGE),
            'page'     => $page,
            'perPage'  => self::PER_PAGE,
            'total'    => $total,
            'pages'    => (int) ceil($total / self::PER_PAGE),
        ]);
    }

    public function show(string $id): void
    {
        $message = Messages::find((int) $id);
        if ($message === null) {
            $this->renderError(404);
            return;
        }
        Messages::markRead((int) $id);
        $this->admin('messages/show', ['title' => 'Message from ' . $message['name'], 'm' => $message]);
    }

    public function destroy(string $id): void
    {
        if (!Csrf::verify((new Request())->input('_csrf'))) {
            $this->redirect('/admin/messages');
        }
        Messages::delete((int) $id);
        Session::flash('admin_ok', 'Message deleted.');
        $this->redirect('/admin/messages');
    }
}
