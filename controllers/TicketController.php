<?php

require_once __DIR__ . '/../models/Ticket.php';
require_once __DIR__ . '/../middlewares/AuthMiddleware.php';
require_once __DIR__ . '/../helpers/JsonResponse.php';

class TicketController
{
    private $ticketModel;

    public function __construct()
    {
        $this->ticketModel = new Ticket();
    }

    public function submitTicket($data)
    {
        $user = AuthMiddleware::check();

        if (empty($data['title'])){
            JsonResponse::jsonResponse(['error' => 'Title is required..!'], 400);
        }

        if (empty($data['description'])){
            JsonResponse::jsonResponse(['error' => 'Description is required..!'], 400);
        }

        if(empty($data['department_id'])){
            JsonResponse::jsonResponse(['error' => 'Department is required..!'], 400);
        }

        $data['user_id'] = $user['user_id'];
        $created = $this->ticketModel->submitTicket($data);
        if ($created) {
            JsonResponse::jsonResponse(['message' => 'Ticket submitted...!'], 201);
        }
    }

    public function assignAgent($ticket_id)
    {
        $user = AuthMiddleware::check();
        AuthMiddleware::isAgent();

        $assigned = $this->ticketModel->assignAgent($ticket_id, $user['user_id']);
        if ($assigned) {
            JsonResponse::jsonResponse(['message' => 'Ticket assigned to you...!'], 200);
        }
    }

    public function changeStatus($ticket_id, $status)
    {
        AuthMiddleware::isAgent();

        $valid = [TicketStatusEnums::OPEN, TicketStatusEnums::IN_PROGRESS, TicketStatusEnums::CLOSED];
        if (!in_array($status, $valid)) {
            JsonResponse::jsonResponse(['error' => 'Invalid status...!'], 400);
        }

        $changed = $this->ticketModel->changeStatus($ticket_id, $status);
        if ($changed) {
            JsonResponse::jsonResponse(['message' => 'Status updated...!'], 200);
        }
    }

    public function addNote($ticket_id, $data)
    {
        $user = AuthMiddleware::check();

        if (empty($data['note'])) {
            JsonResponse::jsonResponse(['error' => 'Note is required...!'], 400);
        }

        $added = $this->ticketModel->addNote($ticket_id, $user['user_id'], $data['note']);
        if ($added) {
            JsonResponse::jsonResponse(['message' => 'Note added successfully...!'], 200);
        }
    }
}
