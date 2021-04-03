<?php

namespace App\Core\Requests;

use App\Core\Requests\Base\Request;

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

    public function getUrl()
    {
        return $this->getAttribute('url');
    }


}