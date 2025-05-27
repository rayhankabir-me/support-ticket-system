<?php

//class Config {
//    private $db_host = "127.0.0.1";
//    private $db_user = "root";
//    private $db_pass = "";
//    private $db_name = "ticket_system";
//    protected $db_conn  = null;
//    public function __construct() {
//        try {
//            $db_conn = new PDO("mysql:host={{$this->>db_host}};dbname=myDB", $username, $password);
//        } catch (){
//            die();
//        }
//    }
//}


$db_host = "127.0.0.1";
$db_user = "root";
$db_pass = "ddfd";
$db_name = "ticket_system";

try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //creating user table
    $user_table = /** @lang text */
        "CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password_hash VARCHAR(255),
    role INT DEFAULT 1
)";
    $conn->exec($user_table);

} catch (PDOException $e) {
    echo json_encode([
        "error" => $e->getMessage(),
        "code" => $e->getCode(),
        "line" => $e->getLine(),
        "file" => $e->getFile()
    ]);
}

