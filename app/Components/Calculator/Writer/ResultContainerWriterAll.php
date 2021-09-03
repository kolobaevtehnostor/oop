<?php 

namespace App\Components\Calculator\Writer;

use Framework\Components\Writer\Base\ResultContainerInterface;
use Framework\Components\Singletons;

class ResultContainerWriterAll extends Singletons implements ResultContainerInterface
{
    protected $data = [];

    protected static $instance;

    public static function setData(array $attributes = []): void
    {
        $instance = static::getInstance();

        $instance->data = $attributes;
    }

    /**
     * выводит инфу
     *
     * @return array
     */
    public static function all(): array
    {
        $instance = static::getInstance();
        
        return [
            'Долг клиента за ' . $instance->data['period'] . ' мес.'  => printCurrencyRub($instance->data['costForPeriodClient']),
            'Взнос клиента в месяц'                                   => printCurrencyRub($instance->data['monthlyClientPayment']),
            'Долг продавца за ' . $instance->data['period'] . ' мес.' => printCurrencyRub($instance->data['costForPeriodClient']),
            'Взнос продавца в месяц'                                 => printCurrencyRub($instance->data['monthlySellerPayment'])
        ];
    }
}