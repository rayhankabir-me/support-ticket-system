<?php

class TokenStore
{
    private static $tokenFile = __DIR__ . '/../files/tokens.json';

    public static function loadTokens()
    {
        if (!file_exists(self::$tokenFile)) {
            return false;
        }
        return json_decode(file_get_contents(self::$tokenFile), true);
    }

    public static function saveTokens($tokens)
    {
        file_put_contents(self::$tokenFile, json_encode($tokens, JSON_PRETTY_PRINT));
    }

    public static function generateToken($user)
    {
        $token = bin2hex(random_bytes(32));
        $tokens = self::loadTokens();
        $tokens[$token] = [
            'user_id' => $user['id'],
            'role' => $user['role'],
            'name' => $user['name'],
            'email' => $user['email'],
            'timestamp' => time()
        ];
        self::saveTokens($tokens);
        return $token;
    }

    public static function getUserByToken($token)
    {
        $tokens = self::loadTokens();
        return $tokens[$token] ?? null;
    }

    public static function deleteToken($token)
    {
        $tokens = self::loadTokens();
        if (isset($tokens[$token])) {
            unset($tokens[$token]);
            self::saveTokens($tokens);
        }
    }
}
