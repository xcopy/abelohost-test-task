<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DB;

class PostController extends Controller
{
    public function show(int $id)
    {
        $post = DB::fetch('select * from posts where id = ?', [$id]);

        if ($post === null) {
            http_response_code(404);
            throw new \Exception('Page not found'); // todo
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

        $this->render('post/show.tpl', compact('post', 'similarPosts'));
    }
}
