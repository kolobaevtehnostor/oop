<?php

use Phinx\Migration\AbstractMigration;

class CreategrLoan extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('calculator_loan');

        $table->addColumn('months', 'integer')
              ->addColumn('percent', 'float')
              ->addColumn('annual_rate', 'float')
              ->addTimestamps('created_at')
              ->create();
    }
}
