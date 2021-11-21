<?php

namespace Framework\Components;

use Framework\Config\DatabaseConnect;
use Framework\Models\Builder\PDO\Builder;

class Connection {
    
    protected $db;
    protected $builder;
    protected $modelDtoClass;

    public function __construct() 
    {
        $this->db = DatabaseConnect::getInstance()->getConnection();
    }

    public function select(Builder $builder, string $modelDtoClass): self
    {
        $this->builder = $builder;
        $this->modelDtoClass = $modelDtoClass;

        return $this;
    }

    public function one() 
    {
        return $this->getQuery()->fetchAll(\PDO::FETCH_CLASS, $this->modelDtoClass)[0];
    }
    
    public function all(): array 
    {
        return $this->getQuery()->fetchAll(\PDO::FETCH_CLASS, $this->modelDtoClass);
    }

    protected function getQuery()
    {
        $command = $this->builder->getSafeSql();
        
        $statement = $this->db->prepare($command->getSql());
        $statement->execute($command->getBindings());
        
        return $statement;
    }
}