<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Csrf;
use App\Core\Request;
use App\Core\Session;
use App\Support\ContentSeeder;

final class ToolsController extends AdminController
{
    public function seed(): void
    {
        if (!Csrf::verify((new Request())->input('_csrf'))) {
            $this->redirect('/admin');
        }
        $r = ContentSeeder::run();
        if (!empty($r['ok'])) {
            Session::flash('admin_ok', "Starter content imported — {$r['services']} services, {$r['destinations']} destinations, {$r['posts']} posts, {$r['testimonials']} testimonials, {$r['faqs']} FAQs. You can now edit them below.");
        } else {
            Session::flash('admin_err', $r['error'] ?? 'Content import failed.');
        }
        $this->redirect('/admin');
    }
}
