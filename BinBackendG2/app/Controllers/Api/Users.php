<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;

class Users extends ResourceController
{
    protected $format = 'json';

    // GET /api/users
    public function index()
    {
        $db = \Config\Database::connect();
        $q  = $db->query('CALL adm_Read_users()');
        $rows = $q->getResultArray();

        if (method_exists($q, 'nextResult')) $q->nextResult();
        if (method_exists($q, 'freeResult')) $q->freeResult();

        return $this->respond(['status' => 'ok', 'data' => $rows]);
    }

    // POST /api/users
    public function create()
    {
        $data = $this->request->getJSON(true);
        if (empty($data['fname']) || empty($data['lname']) || empty($data['email']) || empty($data['password'])) {
            return $this->failValidationErrors('All fields are required.');
        }

        $model = new UserModel();
        $newId = $model->createUser(
            $data['fname'],
            $data['lname'],
            $data['email'],
            $data['password']
        );

        if ($newId) {
            return $this->respondCreated([
                'status' => 'ok',
                'data' => [
                    'userID' => $newId,
                    'fname'  => $data['fname'],
                    'lname'  => $data['lname'],
                    'email'  => $data['email'],
                ],
            ]);
        }

        return $this->failServerError('Failed to create user.');
    }

    // PUT /api/users/{id}
    public function update($id = null)
    {
        $id = (int) ($id ?? 0);
        if ($id <= 0) return $this->failValidationErrors('Invalid user ID');

        $data = $this->request->getJSON(true);
        $model = new UserModel();

        $ok = $model->updateUser(
            $id,
            $data['fname'],
            $data['lname'],
            $data['email'],
            $data['password'] ?? null
        );

        if ($ok) {
            return $this->respond([
                'status' => 'ok',
                'data' => [
                    'userID' => $id,
                    'fname'  => $data['fname'],
                    'lname'  => $data['lname'],
                    'email'  => $data['email'],
                ],
            ]);
        }

        return $this->failServerError('Failed to update user.');
    }

    // DELETE /api/users/{id}
    public function delete($id = null)
    {
        $id = (int) $id;
        if ($id <= 0) return $this->failValidationErrors('Invalid user ID');

        $db = \Config\Database::connect();
        $q  = $db->query('CALL adm_Delete_user(?)', [$id]);

        if (method_exists($q, 'nextResult')) $q->nextResult();
        if (method_exists($q, 'freeResult')) $q->freeResult();

        if ($db->affectedRows() > 0)
            return $this->respond(['status' => 'ok', 'success' => true]);

        return $this->failNotFound('User not found.');
    }
}
