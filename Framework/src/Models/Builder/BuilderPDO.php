<?php

namespace Framework\Models\Builder;

use Framework\Config\DatabaseConnect;

class BuilderPDO
{
    protected $db;
   // protected $table;

    protected $querySelect = 'SELECT * ';
    protected $queryTable = '';
    protected $queryCondition = '';
    protected $execute = [];
    protected $queryString = '';

    public function __construct() 
    {
        $dbConection = DatabaseConnect::getInstance();
        $this->db = $dbConection->getConnection();
    }

    public function setQueryToTable(string $tableName): void 
    {
        $this->queryTable = 'FROM ' . $tableName;
    }

    public function findOne(): array 
    {
        //dd($this->getQuery());
        return $this->getQuery()->fetch();
    }
    
    public function findAll(): array 
    {
        return $this->getQuery()->fetchAll();
    }

    /**
     * Делает выборку
     *
     * @param string $key
     * @param string $operator
     * @param string $value
     * @return void
     */
    public function where(string $key, string $operator, string $value): void
    {
        if ($this->queryCondition == '') {
            $this->queryCondition = ' WHERE `' . $key . '` ' . $operator . ' :' . $key;
            $this->execute[$key] = $value;

            return;
        }

        $this->queryCondition .= ' AND `' . $key . '` ' . $operator . ' :' . $key;
        $this->execute[$key] = $value;
    }  
    
    /**
    * выбирает действие оператора
    *
    * @param string $expr
    * @param string $operator
    * @param string $value
    * @return bool
    */
   protected function switchOperator(string $expr, string $operator, string $value): bool
   {
       switch ($operator) {
           case '>':
               return $expr > $value;
           case '<':
               return $expr < $value;
           case '=':
               return $expr == $value;
           case '>=':
               return $expr >= $value;
           case '<=':
               return $expr <= $value;
           default:
               throw new \RuntimeException('Оператор не существует');
       }
   } 

    public function makeQueryString(): void
    {
        $this->queryString = $this->querySelect . $this->queryTable . $this->queryCondition;
    }
   
   public function getQuery()
   {
       $this->makeQueryString();
       
       $stmt = $this->db->prepare($this->queryString);
       $stmt->execute($this->execute);

       return $stmt;
   }
}