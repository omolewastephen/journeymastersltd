<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Csrf;
use App\Core\Db;
use App\Core\Request;
use App\Core\Session;
use App\Core\Upload;
use App\Core\Validator;

final class TestimonialsController extends AdminController
{
    public function index(): void
    {
        $this->admin('content/testimonials/index', ['title' => 'Testimonials', 'items' => Db::all('testimonials', 'sort_order ASC, id ASC')]);
    }

    public function create(): void
    {
        $this->form(null);
    }

    public function edit(string $id): void
    {
        $item = Db::find('testimonials', (int) $id);
        if (!$item) {
            $this->renderError(404);
            return;
        }
        $this->form($item);
    }

    private function form(?array $item): void
    {
        $this->admin('content/testimonials/form', [
            'title'  => $item ? 'Edit Testimonial' : 'New Testimonial',
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
            Db::delete('testimonials', (int) $id);
            Session::flash('admin_ok', 'Testimonial deleted.');
        }
        $this->redirect('/admin/testimonials');
    }

    private function save(?int $id): void
    {
        $r = new Request();
        if (!Csrf::verify($r->input('_csrf'))) {
            $this->redirect('/admin/testimonials');
        }
        $v      = new Validator($r->all());
        $errors = $v->validate(['name' => 'required|max:120', 'quote' => 'required']) ? [] : $v->errors();

        $upload = Upload::image($_FILES['avatar'] ?? [], 'testimonials');
        if (isset($upload['error'])) {
            $errors['avatar'] = $upload['error'];
        }
        if ($errors !== []) {
            Session::flash('errs', $errors);
            Session::flashOld($r->all());
            $this->redirect($id ? "/admin/testimonials/{$id}/edit" : '/admin/testimonials/create');
        }

        $data = [
            'name'         => $r->input('name'),
            'role'         => $r->input('role'),
            'quote'        => $r->input('quote'),
            'rating'       => min(5, max(1, (int) $r->input('rating', 5))),
            'sort_order'   => (int) $r->input('sort_order', 0),
            'is_published' => $r->input('is_published') ? 1 : 0,
        ];
        if (!empty($upload['path'])) {
            $data['avatar'] = $upload['path'];
        }
        $id ? Db::update('testimonials', $id, $data) : Db::insert('testimonials', $data);
        Session::flash('admin_ok', 'Testimonial saved.');
        $this->redirect('/admin/testimonials');
    }
}
