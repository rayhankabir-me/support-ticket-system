<?php

require_once __DIR__ . '/../helpers/TokenStore.php';
require_once __DIR__ . '/../helpers/JsonResponse.php';

class AuthMiddleware
{
    public static function check()
    {
        $headers = getallheaders();
        $inputToken = $headers['Authorization'] ?? null;
        $token = trim(str_replace('Bearer', '', $inputToken));

        if (!$token) {
            JsonResponse::jsonResponse(['error' => 'Unauthorized...!'], 401);
        }

        $user = TokenStore::getUserByToken($token);
        if (!$user) {
            JsonResponse::jsonResponse(['error' => 'Invalid token...!'], 401);
        }

        return $user;
    }

    public static function checkAdmin()
    {
        $user = self::check();

        if ($user['role'] != RoleEnums::ADMIN) {
            JsonResponse::jsonResponse(['error' => 'Only admin can access this resource...!'], 403);
        }

        return $user;
    }
}
