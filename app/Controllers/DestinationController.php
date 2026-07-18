<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\Content;

final class DestinationController extends Controller
{
    public function index(): void
    {
        $this->view('destinations/index', [
            'title'        => 'Destinations — Journey Masters Ltd',
            'description'  => 'Canada, the United Kingdom, Europe and beyond — explore where we help clients study, work and settle.',
            'destinations' => Content::destinations(),
        ]);
    }

    public function show(string $slug): void
    {
        $destination = Content::destination($slug);
        if ($destination === null) {
            $this->renderError(404);
            return;
        }

        $this->view('destinations/show', [
            'title'       => $destination['title'] . ' — Journey Masters Ltd',
            'description' => $destination['intro'],
            'destination' => $destination,
            'services'    => Content::servicesBySlugs($destination['services']),
        ]);
    }
}
