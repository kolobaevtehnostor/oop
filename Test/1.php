<?php

trait MagicGetter
{
    protected function getReflection()
    {
        return new \ReflectionClass(static::class);
    }
    
    public function __get(string $name)
    {
        $reflection = $this->getReflection();
        
        $magicMethod = 'get'. ucfirst($name);
        
        if ($reflection->hasMethod($magicMethod)) {
            return $this->{$magicMethod}();
        }
    }
    
}

trait LravelScopes
{
    protected $builder = [];
    
    protected $instance;
    
    public function __call(string $name, $arguments)
    {
        if (static::hasScope($name)) {
            
            $instance = static::getInstance();
            
            $scope = static::getScopeMethod($name);
            
            $instance->{$scope}($this, ...$arguments);
            
            return $instance;
        }
    }
    
    public static function __callStatic(string $name, $arguments)
    {
        
        if (static::hasScope($name)) {
            
            $instance = static::getInstance();
            
            $scope = static::getScopeMethod($name);
            
            $instance->{$scope}($instance, ...$arguments);
            
            return $instance;
        }
        
    }
    
    protected static function getScopeMethod(string $name): string
    {
        return 'scope' . ucfirst($name);
    }
    
    protected static function hasScope(string $name): bool
    {
        $reflection = new \ReflectionClass(static::class);
        
        $scope = static::getScopeMethod($name);
        
        return $reflection->hasMethod($scope);
    }
    
    public static function getInstance()
    {
        if (! (static::$instance instanceof static)) {
            static::$instance = new static('sdfsdf-sdf-sdfsf', 'builder');
        }
        
        return static::$instance;
    }
    
    public static function printBuilder(): string
    {
        $instance = static::getInstance();
        
        $query = 'Найти данные где: ' . PHP_EOL;
        
        foreach ($instance->builder as $key => $value) {
            $query .= $key . ': ' . $value . PHP_EOL;
        }
        
        return $query;
    }
    
    protected function where(string $key, string $value)
    {
        $this->builder[$key] = $value;
        
        return $this;
    }
    
}

class Data
{
    use MagicGetter;
    use LravelScopes;
    
    protected $id = null;
    
    protected $type = null;
    
    public function __construct(string $id, string $type)
    {
        $this->id = $id;
        
        $this->type = $type;
    }
    
    /* не првильно вызывали. __call переопределен здесь
    если раскоментить, вызов в контексте класса byName не будет
    public function __call(string $name, $args)
    {
        if ($name == 'getData') {
            return $this->callNoData(...$args);
        }
    }
    */
    
    public function scopeById(self $query, string $id): self
    {
        return $query->where('id', $id);
    }
    
    public function scopeByName(self $query, string $name): self
    {
        return $query->where('name', $name);
    }
    
    public function scopeByAge(self $query, int $age): self
    {
        return $query->where('age', $age);
    }
    
    public function getId(): string
    {
        return $this->id;
    }
    
    public function getType(): string
    {
        return $this->type;
    }
    
    public function callNoData(string $default, string $defaultTwo): string
    {
        return $default . $defaultTwo;
    }
    
}

Data::byId('56-78-111-123')
    ->byName('John');

$data = Data::byAge(30);

echo $data->id . PHP_EOL;
echo $data->type . PHP_EOL . PHP_EOL;

echo 'Данные билдера: ' . PHP_EOL . Data::printBuilder() . PHP_EOL;