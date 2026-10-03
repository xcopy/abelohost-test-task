<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DB;
use App\Http\Exceptions\NotFoundException;

class PostController extends Controller
{
    public function show(int $id)
    {
        $post = DB::fetch('select * from posts where id = ?', [$id]);

        if ($post === null) {
            throw new NotFoundException();
        }

        $similarPosts = DB::fetchAll(
            'select distinct p.*
            from posts p
            inner join category_post cp on cp.post_id = p.id
            where cp.category_id in (
                select category_id
                from category_post
                where post_id = ?
            )
            and p.id != ?
            order by p.created_at desc
            limit 3',
            [$post['id'], $post['id']]
        );

        $categories = DB::fetchAll(
            'select c.*
            from categories c
            inner join category_post cp on cp.category_id = c.id
            and cp.post_id = ?',
            [$post['id']]
        );

        $this->addBreadcrumb($post['name']);

        $this->render('post/show', compact('categories', 'post', 'similarPosts'));
    }
}
