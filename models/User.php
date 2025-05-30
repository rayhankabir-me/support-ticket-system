<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../helpers/ThrowException.php';
require_once __DIR__ . '/../Enums/RoleEnums.php';

class User
{
    private $db_connection;
    private $get_connection;

    public function __construct()
    {
        try {
            $this->db_connection = new Database();
            $this->get_connection = $this->db_connection->getConnection();

            $user_table = /** @lang text */
                "CREATE TABLE IF NOT EXISTS users (
                    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(100) UNIQUE,
                    email VARCHAR(100) UNIQUE,
                    password_hash VARCHAR(255),
                    role INT DEFAULT ".RoleEnums::USER."
                )";
            $this->get_connection->exec($user_table);
        } catch (Throwable $err) {
            http_response_code(500);
            ThrowException::throwException($err);
        }
    }

    public function create($data)
    {
        try {
            $stmt = $this->get_connection->prepare(
                "/** @lang text */ INSERT INTO users (name, email, password_hash, role) 
                 VALUES (:name, :email, :password_hash, :role)"
            );
            return $stmt->execute([
                ':name' => $data['name'],
                ':email' => $data['email'],
                ':password_hash' => md5($data['password_hash']),
                ':role' => $data['role'],
            ]);
        } catch (Throwable $err) {
            http_response_code(500);
            ThrowException::throwException($err);
            return false;
        }
    }

    public function show($id)
    {
        try {
            $stmt = $this->get_connection->prepare("/** @lang text */ SELECT * FROM users WHERE id = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Throwable $err) {
            http_response_code(500);
            ThrowException::throwException($err);
            return false;
        }
    }

    public function delete($id) {

        try {
            $stmt = $this->get_connection->prepare("/** @lang text */ DELETE FROM users WHERE id = :id");
            return $stmt->execute([':id' => $id]);
        } catch (Throwable $err) {
            http_response_code(500);
            ThrowException::throwException($err);
            return false;
        }
    }

    public function update($id, $data) {
        try {
            $stmt = $this->get_connection->prepare("/** @lang text */ UPDATE users SET name = :name, email = :email, password_hash = :password_hash, role = :role WHERE id = :id");
            return $stmt->execute([
                ':id' => $id,
                ':name' => $data['name'],
                ':email' => $data['email'],
                ':password_hash' => md5($data['password_hash']),
                ':role' => $data['role'],
            ]);
        } catch (Throwable $err) {
            http_response_code(500);
            ThrowException::throwException($err);
            return false;
        }
    }
}