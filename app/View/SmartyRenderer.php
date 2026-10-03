<?php

declare(strict_types=1);

namespace App\View;

use Smarty\Smarty;

class SmartyRenderer implements RendererInterface
{
    private Smarty $smarty;

    public function __construct()
    {
        $this->smarty = new Smarty();
        // $this->smarty->setCaching(1);
        // $this->smarty->setCacheDir(BASE_PATH . '/smarty/cache');
        $this->smarty->setTemplateDir(BASE_PATH . '/smarty/templates');
        $this->smarty->setCompileDir(BASE_PATH . '/smarty/compile');
    }

    /**
     * @inheritDoc
     */
    public function render(string $template, array $data = []): void
    {
        $this->smarty->assign($data);
        $this->smarty->display($template);
    }
}
