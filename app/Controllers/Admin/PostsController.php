<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Csrf;
use App\Core\Db;
use App\Core\Request;
use App\Core\Session;
use App\Core\Upload;
use App\Core\Validator;

final class PostsController extends AdminController
{
    public function index(): void
    {
        $this->admin('content/posts/index', ['title' => 'Blog Posts', 'items' => Db::all('posts', 'published_at DESC, id DESC')]);
    }

    public function create(): void
    {
        $this->form(null);
    }

    public function edit(string $id): void
    {
        $item = Db::find('posts', (int) $id);
        if (!$item) {
            $this->renderError(404);
            return;
        }
        $this->form($item);
    }

    private function form(?array $item): void
    {
        $this->admin('content/posts/form', [
            'title'  => $item ? 'Edit Post' : 'New Post',
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
            Db::delete('posts', (int) $id);
            Session::flash('admin_ok', 'Post deleted.');
        }
        $this->redirect('/admin/posts');
    }

    private function save(?int $id): void
    {
        $r = new Request();
        if (!Csrf::verify($r->input('_csrf'))) {
            $this->redirect('/admin/posts');
        }
        $v      = new Validator($r->all());
        $errors = $v->validate(['title' => 'required|max:220', 'excerpt' => 'max:500']) ? [] : $v->errors();

        $upload = Upload::image($_FILES['image'] ?? [], 'blog');
        if (isset($upload['error'])) {
            $errors['image'] = $upload['error'];
        }
        if ($errors !== []) {
            Session::flash('errs', $errors);
            Session::flashOld($r->all());
            $this->redirect($id ? "/admin/posts/{$id}/edit" : '/admin/posts/create');
        }

        $slug = slugify($r->input('slug') ?: $r->input('title'));
        $data = [
            'title'        => $r->input('title'),
            'slug'         => $slug,
            'category'     => $r->input('category'),
            'excerpt'      => $r->input('excerpt'),
            'body'         => (string) $r->input('body'), // rich-text HTML (admin-authored)
            'read_time'    => $r->input('read_time') ?: '5 min',
            'is_published' => $r->input('is_published') ? 1 : 0,
            'published_at' => $r->input('published_at') ?: date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s'),
        ];
        if (!empty($upload['path'])) {
            $data['image'] = $upload['path'];
        }
        if ($id) {
            Db::update('posts', $id, $data);
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            Db::insert('posts', $data);
        }
        Session::flash('admin_ok', 'Post saved.');
        $this->redirect('/admin/posts');
    }
}
