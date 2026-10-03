<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\View\RendererInterface;

abstract class Controller
{
    public function __construct(
        protected RendererInterface $view
    ) {}

    protected function render(string $template, array $data = []): void
    {
        $this->view->render($template, $data);
    }
}
