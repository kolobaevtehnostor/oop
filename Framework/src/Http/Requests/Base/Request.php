<?php

namespace Framework\Http\Requests\Base;

class Request implements RequestInterface
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
     * @see RequestInterface
     */
    public function server(string $attributeName, $default = null)
    {
        if ($this->isByServer($attributeName)) {

            return $this->serverAttributes[$attributeName];
        }

        return $default;
    }

    /**
     * @see RequestInterface
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
     *  @see RequestInterface
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
     *  @see RequestInterface
     */
    public function isGet(): bool
    {
        return (bool) count($this->getAttributes);
    }

    /**
     *  @see RequestInterface
     */
    public function isPost(): bool
    {
        return (bool) count($this->postAttributes);
    }

    /**
     *  @see RequestInterface
     */
    public function isByGet(string $attributeName): bool
    {
        return isset($this->getAttributes[$attributeName]);
    }

    /**
     *  @see RequestInterface
     */
    public function isByPost(string $attributeName): bool
    {
        return isset($this->postAttributes[$attributeName]);
    }

    /**
     *  @see RequestInterface
     */
    public function isByServer(string $attributeName): bool
    {
        return isset($this->serverAttributes[$attributeName]);
    }

    /**
     *  @see RequestInterface
     */
    public static function getInstance(): self
    {
        if (! (self::$instance instanceof self)) {
            throw new \RuntimeException('Объект запроса не инициализирован.');
        }

        return self::$instance;
    }

    /**
     *  @see RequestInterface
     */
    public function getUrlPath(): string
    {
        $urlRequest = $this->server('REQUEST_URI');

        $url = parse_url($urlRequest);

        return $url['path'];
    } 
}