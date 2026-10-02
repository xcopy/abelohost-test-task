<?php

declare(strict_types= 1);

namespace App\Http\Controllers;

use Smarty\Smarty;

abstract class Controller
{
    protected Smarty $smarty;

    public function __construct()
    {
        $this->smarty = new Smarty();

        // $this->smarty->setCaching(1);
        // $this->smarty->setCacheDir(BASE_PATH . '/smarty/cache');
        $this->smarty->setTemplateDir(BASE_PATH . '/smarty/templates');
        $this->smarty->setCompileDir(BASE_PATH . '/smarty/compile');
    }

    protected function render(string $template, array $data = []): void
    {
        foreach ($data as $key => $value) {
            $this->smarty->assign($key, $value);
        }

        $this->smarty->display($template);
    }
}
