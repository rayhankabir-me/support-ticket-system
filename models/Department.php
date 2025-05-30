<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../helpers/ThrowException.php';

class Department
{
    private $db_connection;
    private $get_connection;

    public function __construct()
    {
        try {
            $this->db_connection = new Database();
            $this->get_connection = $this->db_connection->getConnection();

            $department_table = /** @lang text */
                "CREATE TABLE IF NOT EXISTS departments (
                    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(100) UNIQUE
                )";
            $this->get_connection->exec($department_table);
        } catch (Throwable $err) {
            http_response_code(500);
            ThrowException::throwException($err);
        }
    }

    public function create($data)
    {
        try {
            $stmt = $this->get_connection->prepare(
                "/** @lang text */ INSERT INTO departments (name) 
                 VALUES (:name)"
            );
            return $stmt->execute([
                ':name' => $data['name'],
            ]);
        } catch (Throwable $err) {
            http_response_code(500);
            ThrowException::throwException($err);
            return false;
        }
    }

    public function getAll()
    {
        try {
            $stmt = $this->get_connection->prepare("/** @lang text */ SELECT * FROM departments");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $err) {
            http_response_code(500);
            ThrowException::throwException($err);
            return false;
        }
    }
    public function getById($id)
    {
        try {
            $stmt = $this->get_connection->prepare("/** @lang text */ SELECT * FROM departments WHERE id = :id");
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
            $stmt = $this->get_connection->prepare("/** @lang text */ DELETE FROM departments WHERE id = :id");
            return $stmt->execute([':id' => $id]);
        } catch (Throwable $err) {
            http_response_code(500);
            ThrowException::throwException($err);
            return false;
        }
    }

    public function update($id, $data) {
        try {
            $stmt = $this->get_connection->prepare("/** @lang text */ UPDATE departments SET name = :name WHERE id = :id");
            return $stmt->execute([
                ':id' => $id,
                ':name' => $data['name'],
            ]);
        } catch (Throwable $err) {
            http_response_code(500);
            ThrowException::throwException($err);
            return false;
        }
    }

}