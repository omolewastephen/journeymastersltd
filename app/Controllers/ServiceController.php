<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\Content;

final class ServiceController extends Controller
{
    public function index(): void
    {
        $this->view('services/index', [
            'title'       => 'Our Services — Journey Masters Ltd',
            'description' => 'Proof of funds, study admission, visa processing, work permits and more — handled end-to-end by specialists.',
            'services'    => Content::services(),
        ]);
    }

    public function show(string $slug): void
    {
        $service = Content::service($slug);
        if ($service === null) {
            $this->renderError(404);
            return;
        }

        $this->view('services/show', [
            'title'       => $service['title'] . ' — Journey Masters Ltd',
            'description' => $service['summary'],
            'service'     => $service,
            'others'      => array_values(array_filter(
                Content::services(),
                fn ($s) => $s['slug'] !== $slug
            )),
        ]);
    }
}
