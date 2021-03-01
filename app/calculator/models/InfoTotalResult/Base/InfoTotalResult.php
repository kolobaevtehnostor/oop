<?php
/** Абстрактный класс калькулятор */ 

namespace App\Calculator\Models\InfoTotalResult\Base;

abstract class InfoTotalResult
{
    protected $allResultsCalculate = [];
    
    abstract protected function printResult(): array ;
        
    public function printResultJson()
    {
        if (empty($this->printResult())) {
            return '';
        }
        
        return json_encode($this->printResult(), JSON_UNESCAPED_UNICODE);
    }

    /**
     * Добавляет результат расчета
     * на данном этапе и его название
     *
     * @param string $name
     * @param string $param
     * @return void
     */
    public function addResultsCalculate(string $name, string $param): void
    {
        $this->allResultsCalculate[] = [
            'name' => $name,
            'value' => $param
        ];
    }

    /**
     * Записывает результат расчетов
     *
     * @param array $resultsCalculate
     * @return void
     */
    public function setResultsCalculate(array $resultsCalculate): void
    {
        foreach ($resultsCalculate as $resultCalculate) {
            $this->addResultsCalculate(key($resultCalculate), current ($resultCalculate));
        }
    }
}