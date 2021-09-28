<?php

use Phinx\Migration\AbstractMigration;

class AddRowsToTableInstallment extends AbstractMigration
{
    public function change()
    {
      
        $table = $this->table('calculator_installment');

        $rows = [
            [
                'months' => 3,
                'percent' => 10,
                'annual_rate' => 1.1,
            ],
            [
                'months' => 3,
                'percent' => 20,
                'annual_rate' => 5.8,
            ],
            [
                'months' => 3,
                'percent' => 30,
                'annual_rate' => 9.6,
            ],
            [
                'months' => 3,
                'percent' => 40,
                'annual_rate' => 13.1,
            ],
            [
                'months' => 3,
                'percent' => 50,
                'annual_rate' => 17.2,
            ],
            [
                'months' => 6,
                'percent' => 10,
                'annual_rate' => 2.4,
            ],
            [
                'months' => 6,
                'percent' => 20,
                'annual_rate' => 6.7,
            ],
            [
                'months' => 6,
                'percent' => 30,
                'annual_rate' => 10.4,
            ],
            [
                'months' => 6,
                'percent' => 40,
                'annual_rate' => 14.9,
            ],
            [
                'months' => 6,
                'percent' => 50,
                'annual_rate' => 18.4,
            ],
            [
                'months' => 9,
                'percent' => 10,
                'annual_rate' => 3.8,
            ],
            [
                'months' => 9,
                'percent' => 20,
                'annual_rate' => 7.2,
            ],
            [
                'months' => 9,
                'percent' => 30,
                'annual_rate' => 11.2,
            ],
            [
                'months' => 9,
                'percent' => 40,
                'annual_rate' => 15.7,
            ],
            [
                'months' => 9,
                'percent' => 50,
                'annual_rate' => 19.5,
            ],
            [
                'months' => 9,
                'percent' => 10,
                'annual_rate' => 4.5,
            ],
            [
                'months' => 9,
                'percent' => 20,
                'annual_rate' => 8.4,
            ],
            [
                'months' => 9,
                'percent' => 30,
                'annual_rate' => 12.3,
            ],
            [
                'months' => 9,
                'percent' => 40,
                'annual_rate' => 16.6,
            ],
            [
                'months' => 9,
                'percent' => 50,
                'annual_rate' => 20.7,
            ],
        ];
        
        $table->insert($rows)->save();
    }
}
