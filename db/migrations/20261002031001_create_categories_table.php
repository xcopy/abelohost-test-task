<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateCategoriesTable extends AbstractMigration
{
    public function up(): void
    {
        $this->table('categories')
            ->addColumn('name', 'string', ['null' => false])
            ->addColumn('description', 'string')
            ->save();
    }

    public function down(): void
    {
        $this->table('categories')
            ->drop()
            ->save();
    }
}
