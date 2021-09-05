<?php

namespace Framework;

use Framework\Components\Singletons;

class Log extends Singletons
{
    protected $path = ROOT_PATH . 'storage/logs/';
    protected $fileName;

    public function __construct()
    {
        $this->fileName = date('d-m-Y') . '.log';
    }

    /**
     * Undocumented function
     *
     * @param string $message
     * @return void
     */
    public static function info(string $message = 'Запрос', string $channel = '', string $defaultChannel = 'info/'): void
    {
        $instance = static::getInstance();

        $instance->write($message, $channel, $defaultChannel);
    }

    /**
     * Undocumented function
     *
     * @param string $message
     * @return void
     */
    public static function error(string $message = 'Ошибка', string $channel = '', string $defaultChannel = 'error/'): void
    {
        $instance = static::getInstance();

        $instance->write($message, $channel, $defaultChannel);
    }

    /**
     * Записываем в файл
     *
     * @return void
     */
    public function write(string $message, string $channel, string $defaultChannel): void
    {
        $this->path = $this->path . $defaultChannel . $channel;
        
        if (! file_exists($this->path)) {
            mkdir($this->path, 0777, true);
        }

        file_put_contents($this->path . '/' .  $this->fileName, '[' .  date('d.m.Y H:i:s') . '] ' . $message . "\n", FILE_APPEND); 
    }
}
