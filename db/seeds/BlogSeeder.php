<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class BlogSeeder extends AbstractSeed
{
    public function run(): void
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0');
        $this->table('category_post')->truncate();
        $this->table('categories')->truncate();
        $this->table('posts')->truncate();
        $this->execute('SET FOREIGN_KEY_CHECKS = 1');

        $json = file_get_contents('https://dummyjson.com/posts?limit=101');
        $data = json_decode($json, true);

        $categories = [];
        $posts = [];

        foreach ($data['posts'] as $post) {
            foreach ($post['tags'] as $tag) {
                $categories[$tag] = [
                    'name' => $tag,
                    'description' => "Articles about $tag",
                ];
            }
        }

        $this->table('categories')
            ->insert($categories)
            ->saveData();

        foreach ($data['posts'] as $post) {
            $posts[] = [
                'name' => $post['title'],
                'description' => mb_substr($post['body'], 0, 100) . '...',
                'body' => $post['body'],
            ];
        }

        $this->table('posts')
            ->insert($posts)
            ->saveData();
    }
}
