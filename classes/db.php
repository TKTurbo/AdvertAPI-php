<?php

class db
{
    private $host;
    private $user;
    private $pass;
    private $db;
    public $pdo;
    public $query;

    public function __construct($host, $user, $pass, $db)
    {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->db = $db;
    }

    public function connect()
    {
        $dsn = "mysql:host=$this->host;dbname=$this->db";
        try {
            return $this->pdo = new PDO($dsn, $this->user, $this->pass);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function query($sql, $array = [])
    {
        $this->query = $this->pdo->prepare($sql);
        $this->query->execute($array);
    }

    public function get($amount = null) {
        if($amount === 'all'){
            return $this->query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return $this->query->fetch(PDO::FETCH_ASSOC);
        }
    }

    public function close()
    {
        $this->pdo = null;
    }
}
