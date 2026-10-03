<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DB;
use App\Http\Exceptions\NotFoundException;

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
                    p.views,
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

        $this->addBreadcrumb('Categories');

        $this->render('category/index', compact('categories'));
    }

    public function show(int $id)
    {
        $category = DB::fetch('select * from categories where id = ?', [$id]);

        if ($category === null) {
            throw new NotFoundException();
        }

        $perPage = 10;
        $page = max(1, (int) ($_GET['page'] ?? 1));

        $totalCount = DB::query(
            'select count(*)
            from posts p
            inner join category_post cp on cp.post_id = p.id
            where cp.category_id = ?',
            [$category['id']]
        )->fetchColumn();

        $totalPages = ceil($totalCount / $perPage);

        // re-calculate page based on totals (page should be <= total pages)
        $page = min($page, $totalPages > 0 ? $totalPages : 1);
        $offset = ($page - 1) * $perPage;

        $sort = $_GET['sort'] ?? 'created_at';
        $sort = in_array($sort, ['created_at', 'views']) ? $sort : 'created_at';
        $direction = strtolower($_GET['direction'] ?? 'desc');
        $direction = $direction === 'asc' ? 'asc' : 'desc';

        $posts = DB::fetchAll(
            "select p.*
            from posts p
            inner join category_post cp on cp.post_id = p.id
            where cp.category_id = ?
            order by p.$sort $direction
            limit $perPage offset $offset",
            [$category['id']]
        );

        $this->addBreadcrumb($category['name']);

        $this->render('category/show', compact(
            'category',
            'posts',
            'page',
            'totalCount',
            'totalPages',
            'sort',
            'direction'
        ));
    }
}
