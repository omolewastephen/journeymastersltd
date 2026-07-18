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

final class DestinationsController extends AdminController
{
    public function index(): void
    {
        $this->admin('content/destinations/index', ['title' => 'Destinations', 'items' => Db::all('destinations', 'sort_order ASC, id ASC')]);
    }

    public function create(): void
    {
        $this->form(null);
    }

    public function edit(string $id): void
    {
        $item = Db::find('destinations', (int) $id);
        if (!$item) {
            $this->renderError(404);
            return;
        }
        $this->form($item);
    }

    private function form(?array $item): void
    {
        $this->admin('content/destinations/form', [
            'title'    => $item ? 'Edit Destination' : 'New Destination',
            'item'     => $item,
            'services' => Db::all('services', 'sort_order ASC'),
            'errors'   => Session::flash('errs') ?: [],
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
            Db::delete('destinations', (int) $id);
            Session::flash('admin_ok', 'Destination deleted.');
        }
        $this->redirect('/admin/destinations');
    }

    private function save(?int $id): void
    {
        $r = new Request();
        if (!Csrf::verify($r->input('_csrf'))) {
            $this->redirect('/admin/destinations');
        }
        $v      = new Validator($r->all());
        $errors = $v->validate(['country' => 'required|max:120', 'title' => 'required|max:200']) ? [] : $v->errors();

        $upload = Upload::image($_FILES['image'] ?? [], 'destinations');
        if (isset($upload['error'])) {
            $errors['image'] = $upload['error'];
        }
        if ($errors !== []) {
            Session::flash('errs', $errors);
            Session::flashOld($r->all());
            $this->redirect($id ? "/admin/destinations/{$id}/edit" : '/admin/destinations/create');
        }

        $json     = fn ($v) => json_encode($v, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $related  = array_values(array_filter((array) $r->input('related_services', [])));
        $data = [
            'country'          => $r->input('country'),
            'title'            => $r->input('title'),
            'slug'             => slugify($r->input('slug') ?: $r->input('country')),
            'intro'            => $r->input('intro'),
            'duration'         => $r->input('duration'),
            'highlights'       => $json(Fields::lines((string) $r->input('highlights'))),
            'requirements'     => $json(Fields::lines((string) $r->input('requirements'))),
            'related_services' => $json($related),
            'gallery'          => $json(Fields::lines((string) $r->input('gallery'))),
            'sort_order'       => (int) $r->input('sort_order', 0),
            'is_published'     => $r->input('is_published') ? 1 : 0,
            'updated_at'       => date('Y-m-d H:i:s'),
        ];
        if (!empty($upload['path'])) {
            $data['image'] = $upload['path'];
        }
        if ($id) {
            Db::update('destinations', $id, $data);
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            Db::insert('destinations', $data);
        }
        Session::flash('admin_ok', 'Destination saved.');
        $this->redirect('/admin/destinations');
    }
}
