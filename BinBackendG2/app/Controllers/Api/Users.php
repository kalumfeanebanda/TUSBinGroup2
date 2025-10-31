<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Users extends ResourceController
{
    use ResponseTrait;
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
    // New Login Method for User Verification
    public function login()
    {
        // 1. Get incoming JSON data
        $data = $this->request->getJSON(true);

        // 2. Server-Side Validation: Check if fields are present
        if (empty($data['email']) || empty($data['password'])) {
            return $this->failValidationErrors('Email and password are required.');
        }

        try {
            $db = \Config\Database::connect();

            // 3. Find the user by email
            // NOTE: You must have a database stored procedure or direct query to fetch the user
            $userQuery = $db->query("
                SELECT userID, email, password_hash
                FROM tusbinright2  
                WHERE email = ?
            ", [$data['email']]);

            $user = $userQuery->getRow();

            // 4. Check if user exists
            if (!$user) {
                // Use failUnauthorized for incorrect credentials
                return $this->failUnauthorized('Invalid email or password.');
            }

            // 5. Verify the password hash
            // The stored password_hash must be retrieved from the database
            if (password_verify($data['password'], $user->password_hash)) {
                // 6. Login Successful!

                // TODO: Here you would typically generate a JWT token for session
                // management and return it to the client. For now, we return basic success.

                return $this->respond([
                    'status' => 'ok',
                    'message' => 'Login successful!',
                    'userID' => $user->userID,
                    // 'token' => 'YOUR_JWT_TOKEN_HERE'
                ]);
            } else {
                // 7. Password incorrect
                return $this->failUnauthorized('Invalid email or password.');
            }
        } catch (\Throwable $e) {
            // Log the error and return a generic server failure
            log_message('error', 'Login error: ' . $e->getMessage());
            return $this->failServerError('An unexpected error occurred during login.');
        }
    }
}
