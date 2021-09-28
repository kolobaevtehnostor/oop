<?php

namespace Framework\Config;

use Framework\Components\Singletons;
use Framework\Log;

class DatabaseConnect extends Singletons
{
    protected $host;
    protected $dbname;
    protected $username;
    protected $password;

    protected $bd;

    public function __construct(string $pathConfig = ROOT_PATH . 'app/config/database.php') 
    {
        require_once $pathConfig;

        $this->host = $host;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Подключаемся
     *
     * @return void
     */
    public function connect(): void
    {
        try {
            $this->bd = new \PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            Log::info('Подклюение к ' . $this->dbname . ' на ' . $this->host . ' прошло успешно.');
        } catch (\PDOException $e) {
            die("Неудалось подключиться к $dbname :" . $e->getMessage());
        }
    }

    public function getConnection(): \PDO
    {
        return $this->bd;
    }
}