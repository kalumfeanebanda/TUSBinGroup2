<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\Response;

class Admin extends ResourceController
{
    use ResponseTrait;
    protected $format = 'json';

    // ======================
    // CORS Handling (Copied directly from your working Users.php)
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
    // ADMIN LOGIN
    // ======================
    public function login()
    {
        // 1. Handle CORS Pre-flight
        $response = $this->handleCors();
        if ($response) return $response;

        // 2. Get data from JSON body
        $data = $this->request->getJSON(true);

        if (empty($data['email']) || empty($data['password'])) {
            return $this->failValidationErrors('Email and password are required.');
        }

        try {
            $db = \Config\Database::connect();
            $email = trim($data['email']);
            $password = trim($data['password']);

            // CRITICAL: Fetch admin user from the 'admin_user' table
            $adminQuery = $db->query("
                SELECT admin_id, name, email, password
                FROM admin_user
                WHERE email = ?
            ", [$email]);

            $admin = $adminQuery->getRow();

            if (!$admin) {
                return $this->failUnauthorized('Invalid email or password.');
            }

            $storedHash = trim($admin->password);

            // CRITICAL: Verify password
            if (password_verify($password, $storedHash)) {

                // SUCCESS → return sanitized admin info
                return $this->respond([
                    'status' => 'ok',
                    'message' => 'Admin Login successful!',
                    'admin' => [
                        'admin_id' => $admin->admin_id,
                        'name' => $admin->name,
                        'email' => $admin->email
                    ]
                ]);

            } else {
                return $this->failUnauthorized('Invalid email or password.');
            }

        } catch (\Throwable $e) {
            log_message('error', 'Admin Login error: ' . $e->getMessage());
            return $this->failServerError('An unexpected error occurred during admin login.');
        }
    }
}