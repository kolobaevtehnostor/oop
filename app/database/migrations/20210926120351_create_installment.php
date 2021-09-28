<?php

use Phinx\Migration\AbstractMigration;

class CreateInstallment extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('calculator_installment');

        $table->addColumn('months', 'integer')
              ->addColumn('percent', 'float')
              ->addColumn('annual_rate', 'float')
              ->addTimestamps('created_at')
              ->create();
    }
}
