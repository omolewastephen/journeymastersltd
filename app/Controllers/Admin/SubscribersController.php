<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Csrf;
use App\Core\Request;
use App\Core\Session;
use App\Repositories\Subscribers;

final class SubscribersController extends AdminController
{
    public function index(): void
    {
        $this->admin('subscribers/index', [
            'title'       => 'Subscribers',
            'subscribers' => Subscribers::all(),
        ]);
    }

    public function destroy(string $id): void
    {
        if (!Csrf::verify((new Request())->input('_csrf'))) {
            $this->redirect('/admin/subscribers');
        }
        Subscribers::delete((int) $id);
        Session::flash('admin_ok', 'Subscriber removed.');
        $this->redirect('/admin/subscribers');
    }

    public function export(): void
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="subscribers-' . date('Y-m-d') . '.csv"');
        $out = fopen('php://output', 'w');
        fputcsv($out, ['Email', 'IP address', 'Subscribed at']);
        foreach (Subscribers::all() as $s) {
            fputcsv($out, [$s['email'], $s['ip_address'] ?? '', $s['created_at'] ?? '']);
        }
        fclose($out);
        exit;
    }
}
