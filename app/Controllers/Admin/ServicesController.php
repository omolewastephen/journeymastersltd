<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Csrf;
use App\Core\Db;
use App\Core\Request;
use App\Core\Session;
use App\Core\Upload;
use App\Core\Validator;
use App\Support\Fields;

final class ServicesController extends AdminController
{
    public function index(): void
    {
        $this->admin('content/services/index', ['title' => 'Services', 'items' => Db::all('services', 'sort_order ASC, id ASC')]);
    }

    public function create(): void
    {
        $this->form(null);
    }

    public function edit(string $id): void
    {
        $item = Db::find('services', (int) $id);
        if (!$item) {
            $this->renderError(404);
            return;
        }
        $this->form($item);
    }

    private function form(?array $item): void
    {
        $this->admin('content/services/form', [
            'title'  => $item ? 'Edit Service' : 'New Service',
            'item'   => $item,
            'errors' => Session::flash('errs') ?: [],
        ]);
    }

    public function store(): void
    {
        $this->save(null);
    }

    public function update(string $id): void
    {
        $this->save((int) $id);
    }

    public function destroy(string $id): void
    {
        if (Csrf::verify((new Request())->input('_csrf'))) {
            Db::delete('services', (int) $id);
            Session::flash('admin_ok', 'Service deleted.');
        }
        $this->redirect('/admin/services');
    }

    private function save(?int $id): void
    {
        $r = new Request();
        if (!Csrf::verify($r->input('_csrf'))) {
            $this->redirect('/admin/services');
        }
        $v      = new Validator($r->all());
        $errors = $v->validate(['title' => 'required|max:160', 'summary' => 'max:600']) ? [] : $v->errors();

        $upload = Upload::image($_FILES['image'] ?? [], 'services');
        if (isset($upload['error'])) {
            $errors['image'] = $upload['error'];
        }
        if ($errors !== []) {
            Session::flash('errs', $errors);
            Session::flashOld($r->all());
            $this->redirect($id ? "/admin/services/{$id}/edit" : '/admin/services/create');
        }

        $json = fn ($v) => json_encode($v, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $data = [
            'title'        => $r->input('title'),
            'slug'         => slugify($r->input('slug') ?: $r->input('title')),
            'tagline'      => $r->input('tagline'),
            'summary'      => $r->input('summary'),
            'overview'     => $json(Fields::lines((string) $r->input('overview'))),
            'icon'         => (string) $r->input('icon'),
            'benefits'     => $json(Fields::lines((string) $r->input('benefits'))),
            'requirements' => $json(Fields::lines((string) $r->input('requirements'))),
            'timeline'     => $json(Fields::pairs((string) $r->input('timeline'), 'title', 'desc')),
            'faqs'         => $json(Fields::pairs((string) $r->input('faqs'), 'q', 'a')),
            'sort_order'   => (int) $r->input('sort_order', 0),
            'is_published' => $r->input('is_published') ? 1 : 0,
            'updated_at'   => date('Y-m-d H:i:s'),
        ];
        if (!empty($upload['path'])) {
            $data['image'] = $upload['path'];
        }
        if ($id) {
            Db::update('services', $id, $data);
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            Db::insert('services', $data);
        }
        Session::flash('admin_ok', 'Service saved.');
        $this->redirect('/admin/services');
    }
}
