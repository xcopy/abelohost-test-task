<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\View\RendererInterface;

/**
 * Provides shared view rendering and breadcrumb behavior for controllers.
 */
abstract class Controller
{
    /**
     * @var array An array of breadcrumb items.
     */
    protected array $breadcrumbs = [
        ['label' => 'Home', 'url' => '/'], // by default
    ];

    /**
     * Creates a controller with its view renderer.
     *
     * @param RendererInterface $view Renderer used to render views.
     */
    public function __construct(
        protected RendererInterface $view
    ) {}

    /**
     * Appends a breadcrumb to the current trail.
     *
     * @param string      $label Breadcrumb text.
     * @param string|null $url   Optional destination URL.
     *
     * @return static This controller instance.
     */
    protected function addBreadcrumb(string $label, ?string $url = null): static
    {
        $this->breadcrumbs[] = compact('label', 'url');

        return $this;
    }

    /**
     * Renders a template with the current breadcrumb trail.
     *
     * @param string $template Template name or path.
     * @param array  $data     Additional template variables.
     *
     * @return void
     */
    protected function render(string $template, array $data = []): void
    {
        $this->view->render($template, array_merge($data, [
            'breadcrumbs' => $this->breadcrumbs
        ]));
    }
}
