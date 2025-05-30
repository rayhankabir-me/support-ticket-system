<?php

class Database {
    private $db_host = "127.0.0.1";
    private $db_user = "root";
    private $db_pass = "";
    private $db_name = "ticket_system";
    protected $db_conn  = null;
    public function __construct() {
        try {
            $this->db_conn = new PDO("mysql:host={$this->db_host};dbname={$this->db_name}", $this->db_user, $this->db_pass);
            $this->db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new PDOException($e);
        }
    }

    public function getConnection() {
        return $this->db_conn;
    }
}

