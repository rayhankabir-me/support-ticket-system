<?php

class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function registerUser($data)
    {
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

        $existsName = $this->userModel->getByName($data['name']);
        if ($existsName) {
            JsonResponse::jsonResponse(['error' => 'Username already exists'], 400);
        }

        $existsEmail = $this->userModel->getByEmail($data['email']);
        if ($existsEmail) {
            JsonResponse::jsonResponse(['error' => 'Email already exists'], 400);
        }

        //user registration part
        try {
            $created = $this->userModel->create($data);
            if ($created) {
                JsonResponse::jsonResponse(['message' => 'User registration successful!'], 201);
            }
            return;
        } catch (Throwable $exception) {
            ThrowException::throwException($exception);
        }
    }

    public function loginUser($data)
    {
        if (empty($data['email']) || empty($data['password_hash'])) {
            JsonResponse::jsonResponse(['error' => 'Email and password required'], 400);
        }

        $user = $this->userModel->getByEmail($data['email']);
        if (!$user || $user['password_hash'] !== md5($data['password_hash'])) {
            JsonResponse::jsonResponse(['error' => 'Invalid credentials'], 401);
        }

        $token = TokenStore::generateToken($user);
        JsonResponse::jsonResponse(['token' => $token], 200);
    }

    public function logout($headers)
    {
        $inputToken = $headers['Authorization'] ?? null;
        $token = trim(str_replace('Bearer', '', $inputToken));
        if (!$token) {
            JsonResponse::jsonResponse(['error' => 'Token required..!'], 401);
        }
        TokenStore::deleteToken($token);
        JsonResponse::jsonResponse(['message' => 'Logout successful..!'], 200);
    }



}
