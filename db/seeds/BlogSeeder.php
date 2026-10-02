<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class BlogSeeder extends AbstractSeed
{
    public function run(): void
    {
        $this->execute('set foreign_key_checks = 0');
        $this->table('category_post')->truncate();
        $this->table('categories')->truncate();
        $this->table('posts')->truncate();
        $this->execute('set foreign_key_checks = 1');

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
                'tags' => join(',', $post['tags']),
            ];
        }

        // add temp. column
        $this->execute('alter table posts add column tags varchar(255)');

        $this->table('posts')
            ->insert($posts)
            ->saveData();

        $pivot = [];

        foreach ($this->fetchAll('select id, tags from posts') as $post) {
            $tags = explode(',', $post['tags']);
            $tags = array_map(fn($tag) => "'$tag'", $tags);

            $categories = $this->fetchAll(sprintf('select id from categories where name in (%s)', join(',', $tags)));

            foreach ($categories as $category) {
                $pivot[] = [
                    'category_id' => $category['id'],
                    'post_id' => $post['id'],
                ];
            }
        }

        $this->table('category_post')
            ->insert($pivot)
            ->saveData();

        // drop temp. column
        $this->execute('alter table posts drop column tags');
    }
}
