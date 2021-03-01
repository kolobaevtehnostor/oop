<?php

namespace App\Calculator\Models;

class Grid 
{
    public $amount;
    public $period;
    public $downPayment;

    public $percentThreeMonths = [
        3 => [
            50 => 17.2,
            10 => 1.1,
            20 => 5.8,
            30 => 9.6,
            40 => 13.1,
        ],
        6 => [
            50 => 2.4,
            10 => 6.7,
            20 => 10.4,
            30 => 14.9,
            40 => 18.4,
        ],
        9 => [
            50 => 3.8,
            10 => 7.2,
            20 => 11.2,
            30 => 15.7,
            40 => 19.5,
        ],
        12 => [
            50 => 4.5,
            10 => 8.4,
            20 => 12.3,
            30 => 16.6,
            40 => 20.7,
        ],
    ];

    public function __construct(int $amount, int $period, int $downPayment) 
    {
        $this->downPayment = $downPayment;
        $this->period = $period;
        $this->amount = $amount;
    }

    protected function getPreparedPercentThreeMonths(): array
    {
        ksort($this->percentThreeMonths);

        foreach ($this->percentThreeMonths as $selectedPeriod => $percents) {
            if ($this->period <= $selectedPeriod) {
                ksort($this->percentThreeMonths[$selectedPeriod]);

                return $this->percentThreeMonths[$selectedPeriod];
            }
        }

        return [];
    }

    public function getPercent(): float
    {
        if ($this->downPayment >= $this->amount) {
            return -1;
        }

        $percentSum = $this->amount / 100 * $this->downPayment;
        $preparedPercentThreeMonths = $this->getPreparedPercentThreeMonths();
        
        if (empty($preparedPercentThreeMonths)) {
            return -1;
        }
        
        foreach ($preparedPercentThreeMonths as $key => $percent) {
            if ($percentSum <= $key) {
                return $percent;
            }
        }

        return end($preparedPercentThreeMonths);
    }

}