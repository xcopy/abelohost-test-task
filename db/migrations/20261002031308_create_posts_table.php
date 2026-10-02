<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePostsTable extends AbstractMigration
{
    public function up(): void
    {
        $this->table('posts')
            ->addColumn('name', 'string', ['null' => false])
            ->addColumn('description', 'text', ['null' => false])
            ->addColumn('body', 'text', ['null' => false])
            ->addColumn('image_url', 'string')
            ->addColumn('views', 'integer', ['null' => false, 'default'=> 0])
            ->addTimestamps()
            ->save();
    }

    public function down(): void
    {
        $this->table('posts')
            ->drop()
            ->save();
    }
}
