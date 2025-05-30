<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require __DIR__ . "/../helpers/JsonResponse.php";
require __DIR__ . "/../controllers/UserController.php";
require __DIR__ . "/../controllers/AuthController.php";
require __DIR__ . "/../controllers/DepartmentController.php";


$method = $_SERVER['REQUEST_METHOD'];


$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$url_parts = explode('/', trim($url, '/'));

$modelName = $url_parts[0] ?? null;
$id = $url_parts[1] ?? null;

//users apis
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

//auth apis
if ($modelName === "register") {
    if ($method === 'POST') {
        $newUser = new AuthController();
        $newUser->registerUser($_POST);
    }
}
if ($modelName === "login") {
    if ($method === 'POST') {
        $loginUser = new AuthController();
        $loginUser->loginUser($_POST);
    }
}

if ($modelName === "logout") {
    if ($method === 'POST') {
        $headers = getallheaders();
        $logoutUser = new AuthController();
        $logoutUser->logout($headers);
    }
}

//departments apis
if ($modelName === "departments") {
    if ($method === 'GET' && empty($id)) {
        $allDepartments = new DepartmentController();
        $allDepartments->getAllDepartments();
    }
    if ($method === 'POST') {
        $newDepartment = new DepartmentController();
        $newDepartment->createDepartment($_POST);
    }
    if ($method === 'GET' && !empty($id)) {
        $getDepartment = new DepartmentController();
        $getDepartment->getDepartmentById($id);
    }
    if ($method === 'DELETE' && !empty($id)) {
        $deleteDepartment = new DepartmentController();
        $deleteDepartment->deleteDepartment($id);
    }
    if ($method === 'PUT' && !empty($id)) {
        parse_str(file_get_contents("php://input"), $input);
        $updateDepartment = new DepartmentController();
        $updateDepartment->updateDepartment($id, $input);
    }
}