<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require __DIR__ . "/../controllers/UserController.php";


$method = $_SERVER['REQUEST_METHOD'];


$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$url_parts = explode('/', trim($url, '/'));

$modelName = $url_parts[0] ?? null;
$id = $url_parts[1] ?? null;


if ($modelName === 'users') {
    if ($method === 'POST') {
        $newUser = new UserController();
        $newUser->createUser($_POST);
    }

    if ($method === 'GET' && !empty($id)) {
        $showUser = new UserController();
        $showUser->showUser($id);
    }

    if ($method === 'DELETE' && !empty($id)) {
        $deleteUser = new UserController();
        $deleteUser->deleteUser($id);
    }

    if ($method === 'PUT' && !empty($id)) {
        $updateUser = new UserController();
        $updateUser->updateUser($id, $_POST);
    }
}