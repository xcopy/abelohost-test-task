<?php

declare(strict_types=1);

namespace App\View;

class TwigRenderer implements RendererInterface
{
    public function __construct()
    {
        // example
        // $this->twig = new Environment(...);
        throw new \Exception('Not implemented');
    }

    /**
     * @inheritDoc
     */
    public function render(string $template, array $data = []): void
    {
        // example
        // echo $this->twig->render($template, $data);
        throw new \Exception('Not implemented');
    }
}
