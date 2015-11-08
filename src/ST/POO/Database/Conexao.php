<?php

namespace ST\POO\Database;

class Conexao
{
    private $hostname;
    private $username;
    private $password;
    private $port;
    private $database;

    public function __construct($hostname, $username, $password, $port, $database)
    {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->port     = $port;
        $this->database = $database;
    }

    public function connect()
    {
        return new \PDO(
            "mysql:host={$this->hostname};port={$this->port};dbname={$this->database}",
            $this->username,
            $this->password,
            array(
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"
            )
        );
    }
}
