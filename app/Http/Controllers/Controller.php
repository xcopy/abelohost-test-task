<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\View\RendererInterface;

abstract class Controller
{
    protected array $breadcrumbs = [];

    public function __construct(
        protected RendererInterface $view
    ) {
        // by default
        $this->breadcrumbs = [
            ['label' => 'Home', 'url' => '/'],
        ];
    }

    protected function addBreadcrumb(string $label, ?string $url = null): static
    {
        $this->breadcrumbs[] = compact('label', 'url');

        return $this;
    }

    protected function render(string $template, array $data = []): void
    {
        $this->view->render($template, array_merge($data, [
            'breadcrumbs' => $this->breadcrumbs
        ]));
    }
}
