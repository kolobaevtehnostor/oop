<?php

namespace Framework\Views\Base;

class BaseView
{
    const RESOURCES_BASE_FOLDER = 'resources';

    protected $fileName;

    protected $basePath;

    protected $filePath;

    protected $output;
    
    protected function __construct(string $fileName, array $attributes = [])
    {
        $this->fileName = $fileName;

        $this->setVariables($attributes);
    }

    /**
     * Определяет основной путь
     *
     * @return void
     */
    protected function defineBasePath(): void
    {
        $this->basePath = ROOT_PATH . static::RESOURCES_BASE_FOLDER . '/' . 'views' . '/' ;
    }
    
    /**
     * Определяет путь к файлу шаблона
     *
     * @param string $defaultLayoutPath
     * @return void
     */
    protected function defineLayoutPath(string $defaultLayoutPath = 'layouts/main.php'): void
    {
        $this->layout = $this->basePath . $defaultLayoutPath;
    }
    
    /**
     * Определяет путь к файлу
     *
     * @return void
     */
    protected function defineFilePath(): void
    {
        $this->filePath = $this->basePath . $this->fileName . '.php';
    }

     /**
     * Устанавливает переданные 
     * атрибуты в переменные
     *
     * @param array $attributes
     * @return void
     */
    
    protected function setVariablesAttribute(array $attributes = []): void
    {
        foreach ($attributes as $key => $value) {

            $this->$key = $value;
        }
    }

    /**
     * Устанавливает все
     * важные переменные
     *
     * @param array $attributes
     * @return void
     */
    protected function setVariables(array $attributes = []): void 
    {
        $this->defineBasePath();

        $this->defineLayoutPath();

        $this->defineFilePath();

        $this->setVariablesAttribute($attributes);
    }

    /**
     * Возвращает отображение
     *
     * @return BaseView
     */
    protected function create(): BaseView
    {
        if (! file_exists($this->filePath)) {
            throw new \RuntimeException('Файл не существует');
        }

        ob_start();
        include $this->filePath;
        $this->content = ob_get_clean();
        
        ob_start();
        include $this->layout;
        $this->output = ob_get_clean();

        return $this;
    }
    
    /**
     * Возвращает созданную вью
     *
     * @param string $fileName
     * @param array $attributes
     * @return string
     */
    public static function compose(string $fileName, array $attributes): BaseView
    {
        $instance = new static($fileName, $attributes);

        return $instance->create();
    }

    public function __toString(): string
    {
        return $this->output;
    }
    
}