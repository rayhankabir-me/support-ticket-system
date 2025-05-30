<?php
require __DIR__ . '/../models/Department.php';
require_once __DIR__ . '/../middlewares/AuthMiddleware.php';

class DepartmentController
{
    private $departmentModel;

    public function __construct()
    {
        $this->departmentModel = new Department();
    }

    public function createDepartment($data)
    {
        //check if user is admin
        AuthMiddleware::checkAdmin();

        //validation part
        if (empty($data['name'])) {
            JsonResponse::jsonResponse(['error' => 'Department name is required'], 400);
        }

        try {
            $created = $this->departmentModel->create($data);
            if ($created) {
                JsonResponse::jsonResponse(['message' => 'Department created successfully!'], 201);
            }
            return;
        } catch (Throwable $exception) {
            ThrowException::throwException($exception);
        }
    }

    public function getAllDepartments()
    {
        try {
            $departments = $this->departmentModel->getAll();
            if ($departments) {
                JsonResponse::jsonResponse($departments, 200);
            }
            return;
        } catch (Throwable $exception) {
            ThrowException::throwException($exception);
        }
    }
    public function getDepartmentById($id)
    {

        if (empty($id)) {
            JsonResponse::jsonResponse(['error' => 'No department found!'], 400);
        }
        try {
            $department = $this->departmentModel->getById($id);
            if ($department) {
                JsonResponse::jsonResponse($department, 200);
            }
            return;
        } catch (Throwable $exception) {
            ThrowException::throwException($exception);
        }
    }

    public function deleteDepartment($id)
    {
        //check if user is admin
        AuthMiddleware::checkAdmin();
        try {
            $exists = $this->departmentModel->getById($id);
            if (!$exists) {
                JsonResponse::jsonResponse(['error' => 'No department found!'], 404);
            }
            $deleted = $this->departmentModel->delete($id);
            if ($deleted) {
                JsonResponse::jsonResponse(['message' => 'Department has been deleted!'], 200);
            }

        } catch (Throwable $exception) {
            throwException::throwException($exception);
        }
    }

    public function updateDepartment($id, $data) {

        //check if user is admin
        AuthMiddleware::checkAdmin();
        try {
            if (empty($id)) {
                JsonResponse::jsonResponse(['error' => 'No department found!'], 404);
            }
            $exists = $this->departmentModel->getById($id);
            if (!$exists) {
                JsonResponse::jsonResponse(['error' => 'Department not found'], 404);
            }
            if (empty($data['name'])) {
                JsonResponse::jsonResponse(['error' => 'Department name is required...!'], 400);
            }
            $updated = $this->departmentModel->update($id, $data);
            if ($updated) {
                JsonResponse::jsonResponse(['message' => 'Department has been updated!'], 200);
            }
        } catch (Throwable $exception) {
            throwException::throwException($exception);
        }
    }


}
