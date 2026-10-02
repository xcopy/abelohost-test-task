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
