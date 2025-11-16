<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\Response;

class Users extends ResourceController
{
    use ResponseTrait;
    protected $format = 'json';

    // ======================
    // CORS Handling
    // ======================
    protected function handleCors(): ?Response
    {
        $this->response->setHeader('Access-Control-Allow-Origin', 'http://localhost:5173');
        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
        $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With, Authorization');
        $this->response->setHeader('Access-Control-Allow-Credentials', 'true');

        if ($this->request->getMethod() === 'options') {
            return $this->response->setStatusCode(200);
        }

        return null;
    }

    // ======================
    // REGISTER
    // ======================
    public function register()
    {
        $response = $this->handleCors();
        if ($response) return $response;

        $data = $this->request->getJSON(true);

        if (empty($data['fname']) || empty($data['lname']) || empty($data['email']) || empty($data['password'])) {
            return $this->failValidationErrors('All fields are required.');
        }

        try {
            $db = \Config\Database::connect();
            $passwordHash = password_hash($data['password'], PASSWORD_BCRYPT);

            $db->query("CALL reg_Create_user(?, ?, ?, ?, @p_userID)", [
                $data['fname'],
                $data['lname'],
                $data['email'],
                $passwordHash
            ]);

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

    // ======================
    // LOGIN
    // ======================
    public function login()
    {
        $response = $this->handleCors();
        if ($response) return $response;

        $data = $this->request->getJSON(true);

        if (empty($data['email']) || empty($data['password'])) {
            return $this->failValidationErrors('Email and password are required.');
        }

        try {
            $db = \Config\Database::connect();

            // Fetch user + password hash
            $userQuery = $db->query("
                SELECT userID, fname, lname, email, password
                FROM user
                WHERE email = ?
            ", [$data['email']]);

            $user = $userQuery->getRow();

            if (!$user) {
                return $this->failUnauthorized('Invalid email or password.');
            }

            $storedHash = trim($user->password);

            if (password_verify($data['password'], $storedHash)) {

                // SUCCESS → return full user info
                return $this->respond([
                    'status' => 'ok',
                    'message' => 'Login successful!',
                    'user' => [
                        'userID' => $user->userID,
                        'fname' => $user->fname,
                        'lname' => $user->lname,
                        'email' => $user->email
                    ]
                ]);

            } else {
                return $this->failUnauthorized('Invalid email or password.');
            }

        } catch (\Throwable $e) {
            log_message('error', 'Login error: ' . $e->getMessage());
            return $this->failServerError('An unexpected error occurred during login.');
        }
    }
}
