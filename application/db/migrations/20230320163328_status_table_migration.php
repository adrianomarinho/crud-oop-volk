<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class StatusTableMigration extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('status');

        $table
            ->addColumn('nome', 'string', ['limit' => 255])
            ->addTimestamps();

        $table->create();

        $builder = $this->getQueryBuilder();
        $builder
            ->insert(['id', 'nome'])
            ->into('status')
            ->values(['id' => 1, 'nome' => 'EM_ANDAMENTO'])
            ->values(['id' => 2, 'nome' => 'PROCESSADO'])
            ->values(['id' => 3, 'nome' => 'CANCELADO'])
            ->execute();
    }
}
