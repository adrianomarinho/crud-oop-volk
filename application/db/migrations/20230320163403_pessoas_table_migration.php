<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class PessoasTableMigration extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('pessoas');

        $table
            ->addColumn('nome', 'string', ['limit' => 255])
            ->addTimestamps();

        $table->create();

        $builder = $this->getQueryBuilder();
        $builder
            ->insert(['nome'])
            ->into('pessoas')
            ->values(['nome' => 'Adriano'])
            ->values(['nome' => 'Gabriel'])
            ->values(['nome' => 'Victor'])
            ->values(['nome' => 'Anderson'])
            ->execute();
    }
}
