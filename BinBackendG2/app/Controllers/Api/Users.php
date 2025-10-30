<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Users extends ResourceController
{
    protected $format = 'json';

    public function register()
    {
        $data = $this->request->getJSON(true);

        if (empty($data['fname']) || empty($data['lname']) || empty($data['email']) || empty($data['password'])) {
            return $this->failValidationErrors('All fields are required.');
        }

        try {
            $db = \Config\Database::connect();
            $passwordHash = password_hash($data['password'], PASSWORD_BCRYPT);

            // Prepare OUT parameter
            $db->query("CALL reg_Create_user(?, ?, ?, ?, @p_userID)", [
                $data['fname'],
                $data['lname'],
                $data['email'],
                $passwordHash
            ]);

            // Get the output value (new user ID)
            $query = $db->query("SELECT @p_userID AS userID");
            $result = $query->getRow();

            return $this->respondCreated([
                'status' => 'ok',
                'message' => 'User registered successfully!',
                'userID' => $result->userID
            ]);
        } catch (\Throwable $e) {
            return $this->failServerError($e->getMessage());
        }
    }
}
