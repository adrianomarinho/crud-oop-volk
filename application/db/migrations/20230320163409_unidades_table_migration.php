<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UnidadesTableMigration extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('unidades');

        $table
            ->addColumn('nome', 'string', ['limit' => 255])
            ->addTimestamps();

        $table->create();

        $builder = $this->getQueryBuilder();
        $builder
            ->insert(['nome'])
            ->into('unidades')
            ->values(['nome' => 'Unidade de São Luis'])
            ->values(['nome' => 'Unidade de Blumenau'])
            ->values(['nome' => 'Unidade de São Paulo'])
            ->values(['nome' => 'Unidade do Rio de Janeiro'])
            ->execute();
    }
}
