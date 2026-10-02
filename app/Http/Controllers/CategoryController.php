<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = DB::fetchAll(
            'select c.id, c.name
            from categories c
            inner join category_post cp on cp.category_id = c.id
            group by c.id
            order by c.name'
        );

        $posts = DB::fetchAll(
            'select * from (
                select
                    c.id as category_id,
                    p.id,
                    p.name,
                    p.created_at,
                    row_number() over (partition by c.id order by p.created_at desc) as rn
                from categories c
                inner join category_post cp on cp.category_id = c.id
                inner join posts p on p.id = cp.post_id
            ) t where t.rn <= 3'
        );

        foreach ($categories as &$category) {
            $category['posts'] = array_filter($posts, fn($post) => $post['category_id'] == $category['id']);
        }

        unset($category);

        $this->render('category/index.tpl', compact('categories'));
    }
}
