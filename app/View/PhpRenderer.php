<?php

declare(strict_types=1);

namespace App\View;

class PhpRenderer implements RendererInterface
{
    /**
     * @inheritDoc
     */
    public function render(string $template, array $data = []): void
    {
        // example
        throw new \Exception('Not implemented');
    }
}
