<?php
require __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../middlewares/AuthMiddleware.php';

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function createUser($data)
    {
        //check if user is admin
        AuthMiddleware::isAdmin();

        //validation part
        if (empty($data['name'])) {
            JsonResponse::jsonResponse(['error' => 'Username is required'], 400);
        }
        if (empty($data['email'])) {
            JsonResponse::jsonResponse(['error' => 'Email is required'], 400);
        }
        if (empty($data['password_hash'])) {
            JsonResponse::jsonResponse(['error' => 'Password is required'], 400);
        }
        if (empty($data['role'])) {
            $data['role'] = RoleEnums::USER;
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

        //check if user is admin
        AuthMiddleware::isAdmin();
        try {
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
