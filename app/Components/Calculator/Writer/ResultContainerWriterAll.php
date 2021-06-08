<?php 

namespace App\Components\Calculator\Writer;

use App\Components\Calculator\Writer\Base\ResultContainerInterface;

class ResultContainerWriterAll implements ResultContainerInterface
{
    protected $data = [];

    public function setData(array $attributes = []): array
    {
        $this->data = $attributes;
    }

    /**
     * выводит инфу
     *
     * @return array
     */
    public function all(): array
    {
        return $this->data;
    }
}