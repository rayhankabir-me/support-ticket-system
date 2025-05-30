<?php

class ThrowException {
    public static function throwException($exception) {
        $code = $exception->getCode();
        $message = $exception->getMessage();
        $file = $exception->getFile();
        $line = $exception->getLine();

        echo json_encode([
            'code' => $code,
            'message' => $message,
            'file' => $file,
            'line' => $line
        ]);
    }
}