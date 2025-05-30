<?php
require __DIR__ . '/../models/User.php';
require __DIR__ . '/../helpers/JsonResponse.php';

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function createUser($data)
    {

        if (empty($data['name'])) {
            JsonResponse::jsonResponse(['error' => 'Username is required'], 400);
        }
        try {
            $created = $this->userModel->create($data);
            if ($created) {
                JsonResponse::jsonResponse(['message' => 'User created successfully!'], 201);
            }
            return;
        } catch (Throwable $exception) {
            ThrowException::throwException($exception);
        }
    }

    public function showUser($id)
    {

        if (empty($id)) {
            JsonResponse::jsonResponse(['error' => 'No user found!'], 400);
        }
        try {
            $user = $this->userModel->show($id);
            if ($user) {
                JsonResponse::jsonResponse($user, 200);
            }
            return;
        } catch (Throwable $exception) {
            ThrowException::throwException($exception);
        }
    }

    public function deleteUser($id)
    {
        try {
//            if (!$this->isAdmin()) {
//            response_json(['error' => 'Unauthorized'], 403);
//            }
            $exists = $this->userModel->show($id);
            if (!$exists) {
                JsonResponse::jsonResponse(['error' => 'No user found!'], 404);
            }
            $deleted = $this->userModel->delete($id);
            if ($deleted) {
                JsonResponse::jsonResponse(['message' => 'User has been deleted!'], 200);
            }

        } catch (Throwable $exception) {
            throwException::throwException($exception);
        }
    }

    public function updateUser($id, $data) {
        try {
//            if (!$this->isAdmin()) {
//                response_json(['error' => 'Unauthorized'], 403);
//            }
            if (empty($id)) {
                JsonResponse::jsonResponse(['error' => 'No user found!'], 404);
            }
            $exists = $this->userModel->show($id);
            if (!$exists) {
                JsonResponse::jsonResponse(['error' => 'User not found'], 404);
            }
            $updated = $this->userModel->update($id, $data);
            if ($updated) {
                JsonResponse::jsonResponse(['message' => 'User has been updated!'], 200);
            }
        } catch (Throwable $exception) {
            throwException::throwException($exception);
        }
    }


}
