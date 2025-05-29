<?php
class JsonResource
{
    public static function JsonResponse($data, $status = 200)
    {
        http_response_code($status);
        echo json_encode($data);
        exit;
    }
}

