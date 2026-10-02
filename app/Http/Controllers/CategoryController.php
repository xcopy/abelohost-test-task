<?php

declare(strict_types= 1);

namespace App\Http\Controllers;

class CategoryController extends Controller
{
    public function index()
    {
        $this->render('category/index.tpl');
    }
}
