<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateCategoryPostTable extends AbstractMigration
{
    public function up(): void
    {
        $this->table('category_post', ['id' => false, 'primary_key' => ['category_id', 'post_id']])
            ->addColumn('category_id', 'integer', ['signed' => false, 'null' => false])
            ->addColumn('post_id', 'integer', ['signed' => false, 'null' => false])
            ->addForeignKey('category_id', 'categories')
            ->addForeignKey('post_id', 'posts')
            ->save();
    }

    public function down(): void
    {
        $this->table('category_post')
            ->drop()
            ->save();
    }
}
