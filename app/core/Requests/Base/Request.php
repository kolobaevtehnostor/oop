<?php

namespace App\Core\Requests\Base;

class Request
{
    protected static $instance;
    
    protected $serverAttributes = [];

    protected $getAttributes = [];

    protected $postAttributes = [];

    public function __construct(array $serverData, $getQuery, $postBody) 
    {
        $this->serverAttributes = $serverData;

        $this->getAttributes = $getQuery;

        $this->postAttributes = $postBody;

        self::$instance = $this;
    }

    /**
     * @return mixed
     */
    public function server(string $attributeName, $default = null)
    {
        if ($this->isByServer($attributeName)) {

            return $this->serverAttributes[$attributeName];
        }

        return $default;
    }

    /**
     * @return mixed
     */
    public function get(string $attributeName, $default = null)
    {
        if (! $this->isGet()) {
            
            return $default;
        }

        if (! $this->isByGet($attributeName)) {
            
            return $default;
        }

        return $this->getAttributes[$attributeName];
    }

    /**
     * @return mixed
     */
    public function post(string $attributeName, $default = null)
    {
        if (! $this->isPost()) {
            
            return $default;
        }

        if (! $this->isByPost($attributeName)) {

            return $default;
        }
        
        return $this->postAttributes[$attributeName];
    }

    /**
     * Есть ли get
     *
     * @return boolean
     */
    public function isGet(): bool
    {
        return (bool) count($this->getAttributes);
    }

    /**
     * Есть ли post
     *
     * @return boolean
     */
    public function isPost(): bool
    {
        return (bool) count($this->postAttributes);
    }

    /**
     * Проверяет присутствие в get
     *
     * @param string $attributeName
     * @return boolean
     */
    public function isByGet(string $attributeName): bool
    {
        return isset($this->getAttributes[$attributeName]);
    }

    /**
     * Проверяет присутствие в post
     *
     * @param string $attributeName
     * @return boolean
     */
    public function isByPost(string $attributeName): bool
    {
        return isset($this->postAttributes[$attributeName]);
    }

    /**
     * Проверяет присутствие в server
     *
     * @param string $attributeName
     * @return boolean
     */
    public function isByServer(string $attributeName): bool
    {
        return isset($this->serverAttributes[$attributeName]);
    }

    /**
     * @return self
     * @throws RuntimeException
     */
    public static function getInstance(): self
    {
        if (! (self::$instance instanceof self)) {
            throw new \RuntimeException('Объект запроса не инициализирован.');
        }

        return self::$instance;
    }

}