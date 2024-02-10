<?php

class DataBase
{
    private $servername;
    private $username;
    private $password;
    private $databasename;
    public $conn;

    public function __construct($servername, $username, $password, $databasename)
    {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->databasename = $databasename;
    }

    public function connect()
    {
        $this->conn = null;

        try {
            $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->databasename);
        } catch (Exception $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
