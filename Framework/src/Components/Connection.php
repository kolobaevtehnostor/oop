<?php

namespace Framework\Components;

use Framework\Config\DatabaseConnect;
use Framework\Models\Builder\PDO\Builder;

class Connection {
    
    protected $db;
    protected $builder;

    public function __construct() 
    {
        $this->db = DatabaseConnect::getInstance()->getConnection();
    }

    public function select(Builder $builder): self
    {
        $this->builder = $builder;

        return $this;
    }

    public function one(): array 
    {
        return $this->getQuery()->fetch();
    }
    
    public function all(): array 
    {
        return $this->getQuery()->fetchAll();
    }

    protected function getQuery()
    {
        $safeSql = $this->builder->getSafeSql();
        
        $stmt = $this->db->prepare($safeSql['query']);
        $stmt->execute($safeSql['whereData']);
        
        return $stmt;
    }
}