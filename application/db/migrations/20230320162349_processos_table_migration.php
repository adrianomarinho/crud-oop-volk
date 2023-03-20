<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ProcessosTableMigration extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('processos');

        $table
            ->addColumn('nome', 'string', ['limit' => 255])
            ->addColumn('pessoa_id', 'integer')
            ->addColumn('unidade_id', 'integer')
            ->addColumn('status_id', 'integer')
            ->addColumn('id_queue', 'integer')
            ->addTimestamps()
            ->addIndex(['id'], ['unique' => true]);

        $table->create();
    }
}
