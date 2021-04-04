<?php

namespace App\Core\Requests;

use App\Core\Requests\Base\Request;
use App\Exceptions\BadRequestException;
class UrlRequest extends Request
{
    protected $allowAttributes = [
        'url',
        'query'
    ];

    public function __construct() 
    {
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('?', $url);
        $data['url'] = $url[0];
        $data['query'] = $_GET;

        parent::__construct($data);
    }

    /**
     * Возвращает URl
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->getAttribute('url');
    }

    /**
     * Возвращает $_get параметры
     *
     * @return mixed
     */
    public function getParam(string $key)
    {
        if (! isset($this->getAttribute('query')[$key])) {
            
            throw new BadRequestException('Ошибка запроса нет параметра <b>' . $key . '</b>');
        }

        return $this->getAttribute('query')[$key];
    }


}