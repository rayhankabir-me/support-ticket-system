<?php
class JsonResponse
{
    public static function jsonResponse($data, $status = 200)
    {
        http_response_code($status);
        echo json_encode($data);
        exit;
    }
}

