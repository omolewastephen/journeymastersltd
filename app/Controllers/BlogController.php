<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\Content;

final class BlogController extends Controller
{
    public function index(): void
    {
        $this->view('blog/index', [
            'title'       => 'Insights — Journey Masters Ltd',
            'description' => 'Guides and travel intelligence on study abroad, visas, work permits and proof of funds.',
            'posts'       => Content::posts(),
        ]);
    }

    public function show(string $slug): void
    {
        $post = Content::post($slug);
        if ($post === null) {
            $this->renderError(404);
            return;
        }

        $this->view('blog/show', [
            'title'       => $post['title'] . ' — Journey Masters Ltd',
            'description' => $post['excerpt'],
            'post'        => $post,
            'related'     => Content::relatedPosts($slug, 2),
        ]);
    }
}
