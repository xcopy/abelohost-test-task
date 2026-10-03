<?php

declare(strict_types=1);

namespace App\View;

interface RendererInterface
{
    /**
     * Renders a template file and output its result.
     *
     * @param string $template The template name or path to render.
     * @param array $data The variables passed to the template.
     *
     * @return void
     */
    public function render(string $template, array $data = []): void;
}
