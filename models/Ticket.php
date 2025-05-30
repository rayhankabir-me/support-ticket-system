<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../helpers/ThrowException.php';
require_once __DIR__ . '/../Enums/TicketStatusEnums.php';

class Ticket
{
    private $db_connection;
    private $get_connection;

    public function __construct()
    {
        try {

            $this->db_connection = new Database();
            $this->get_connection = $this->db_connection->getConnection();

            $ticket_table = "/** @lang text */ CREATE TABLE IF NOT EXISTS tickets (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255),
                description TEXT,
                status INT UNSIGNED DEFAULT ".TicketStatusEnums::OPEN.",
                user_id INT UNSIGNED,
                department_id INT UNSIGNED,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                assigned_agent_id INT UNSIGNED DEFAULT NULL
            )";

            $ticket_notes_table = "/** @lang text */ CREATE TABLE IF NOT EXISTS ticket_notes (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                ticket_id INT UNSIGNED,
                user_id INT UNSIGNED,
                note TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";

            $this->get_connection->exec($ticket_table);
            $this->get_connection->exec($ticket_notes_table);

        } catch (Throwable $e) {
            ThrowException::throwException($e);
        }
    }

    public function submitTicket($data)
    {
        try {
            $stmt = $this->get_connection->prepare("/** @lang text */ INSERT INTO tickets (title, description, user_id, department_id) VALUES (:title, :description, :user_id, :department_id)");
            return $stmt->execute([
                ':title' => $data['title'],
                ':description' => $data['description'],
                ':user_id' => $data['user_id'],
                ':department_id' => $data['department_id']
            ]);
        } catch (Throwable $e) {
            ThrowException::throwException($e);
            return false;
        }
    }

    public function assignAgent($ticket_id, $agent_id)
    {
        try {
            $stmt = $this->get_connection->prepare("/** @lang text */ UPDATE tickets SET assigned_agent_id = :agent_id WHERE id = :ticket_id");
            return $stmt->execute([
                ':agent_id' => $agent_id,
                ':ticket_id' => $ticket_id
            ]);
        } catch (Throwable $e) {
            ThrowException::throwException($e);
            return false;
        }
    }

    public function changeStatus($ticket_id, $status)
    {
        try {
            $stmt = $this->get_connection->prepare("/** @lang text */ UPDATE tickets SET status = :status WHERE id = :ticket_id");
            return $stmt->execute([
                ':status' => $status,
                ':ticket_id' => $ticket_id
            ]);
        } catch (Throwable $e) {
            ThrowException::throwException($e);
            return false;
        }
    }

    public function addNote($ticket_id, $user_id, $note)
    {
        try {
            $stmt = $this->get_connection->prepare("/** @lang text */ INSERT INTO ticket_notes (ticket_id, user_id, note) VALUES (:ticket_id, :user_id, :note)");
            return $stmt->execute([
                ':ticket_id' => $ticket_id,
                ':user_id' => $user_id,
                ':note' => $note
            ]);
        } catch (Throwable $e) {
            ThrowException::throwException($e);
            return false;
        }
    }
}