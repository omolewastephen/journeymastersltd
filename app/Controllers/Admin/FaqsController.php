<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Csrf;
use App\Core\Db;
use App\Core\Request;
use App\Core\Session;
use App\Core\Validator;

final class FaqsController extends AdminController
{
    public function index(): void
    {
        $this->admin('content/faqs/index', ['title' => 'FAQs', 'items' => Db::all('faqs', 'sort_order ASC, id ASC')]);
    }

    public function create(): void
    {
        $this->form(null);
    }

    public function edit(string $id): void
    {
        $item = Db::find('faqs', (int) $id);
        if (!$item) {
            $this->renderError(404);
            return;
        }
        $this->form($item);
    }

    private function form(?array $item): void
    {
        $this->admin('content/faqs/form', [
            'title'  => $item ? 'Edit FAQ' : 'New FAQ',
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
            Db::delete('faqs', (int) $id);
            Session::flash('admin_ok', 'FAQ deleted.');
        }
        $this->redirect('/admin/faqs');
    }

    private function save(?int $id): void
    {
        $r = new Request();
        if (!Csrf::verify($r->input('_csrf'))) {
            $this->redirect('/admin/faqs');
        }
        $v = new Validator($r->all());
        if (!$v->validate(['question' => 'required|max:255', 'answer' => 'required'])) {
            Session::flash('errs', $v->errors());
            Session::flashOld($r->all());
            $this->redirect($id ? "/admin/faqs/{$id}/edit" : '/admin/faqs/create');
        }
        $data = [
            'question'     => $r->input('question'),
            'answer'       => $r->input('answer'),
            'sort_order'   => (int) $r->input('sort_order', 0),
            'is_published' => $r->input('is_published') ? 1 : 0,
        ];
        $id ? Db::update('faqs', $id, $data) : Db::insert('faqs', $data);
        Session::flash('admin_ok', 'FAQ saved.');
        $this->redirect('/admin/faqs');
    }
}
