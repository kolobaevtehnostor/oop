<?php

namespace Framework\Console;

use  Framework\Http\Requests\Base\RequestInterface;

class ConsoleInputHandler implements RequestInterface
{
    
    protected static $instance;
    
    protected $serverAttributes = [];

    protected $postAttributes = [];

    protected $comandName = 'help';

    public function __construct(array $serverData, array $argv = [])
    {
        $this->setPostAttributes($argv);

        if (! empty($argv[1]) /* && array_key_exists($argv[1], $commandsAlias)*/) {
            $this->setComandName($argv[1]);
        }

        $this->serverAttributes = $serverData;
    }
    
    /**
     * Устанавливает класс команды
     *
     * @param string $comandName
     * @return void
     */
    public function setComandName(?string $comandName = ''): void
    {
        $this->comandName = $comandName;
    }
    
    /**
     * Возвращает класс команды
     *
     * @param string $comandName
     * @return string
     */
    public function getComandName(): string
    {
        return $this->comandName;
    }

    /**
     * Записывает в массв опций
     * 
     * @param array $argv
     * @return void
     */
    protected function setPostAttributes(array $argv = []): void
    {
        foreach ($argv as $arg) {
            $option = explode("=", $arg);
        
            if ('-' == substr($arg, 0, 1)) {
                $this->postAttributes[$option[0]] = true;
            }
        
            if (isset($option[1])) {
                $this->postAttributes[$option[0]] = $option[1];
            }
        }
    }

    /**
     *  @see RequestInterface
     */
    public function server(string $attributeName, $default = null)
    {
        if ($this->isByServer($attributeName)) {

            return $this->serverAttributes[$attributeName];
        }

        return $default;
    }

    /**
     *  @see RequestInterface
     */
    public function get(string $attributeName, $default = null)
    {
        return $default;
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
        return false;
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
        return false;
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
        return '';
    } 
}