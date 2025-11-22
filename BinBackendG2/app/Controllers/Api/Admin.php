<?php
namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\Response;

class Admin extends ResourceController
{
    use ResponseTrait;
    protected $format = 'json';

    // ======================
    // CORS Handling
    // ======================
    protected function handleCors(): ?Response
    {
        // SAME AS Users.php !!!
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
        // Debug: verify Admin controller is actually hit
        log_message('error', '🔥 Admin::login() CALLED');

        // 1. Handle CORS Pre-flight
        $response = $this->handleCors();
        if ($response) return $response;

        // 2. Get JSON body
        $data = $this->request->getJSON(true);

        if (empty($data['email']) || empty($data['password'])) {
            return $this->failValidationErrors('Email and password are required.');
        }

        try {
            $db = \Config\Database::connect();

            $email = strtolower(trim($data['email']));
            $password = trim($data['password']);

            // Debug: show email being searched
            log_message('error', '🔍 Searching admin email: ' . $email);

            // Case-insensitive email match
            $adminQuery = $db->query("
                SELECT admin_id, name, email, password
                FROM admin_user
                WHERE LOWER(email) = LOWER(?)
            ", [$email]);

            $admin = $adminQuery->getRow();

            if (!$admin) {
                log_message('error', '❌ Admin NOT found');
                return $this->failUnauthorized('Invalid email or password.');
            }

            $storedHash = trim($admin->password);

            // Debug: found admin
            log_message('error', '✅ Admin found: ' . $admin->email);

            if (password_verify($password, $storedHash)) {

                log_message('error', '🔐 Password verified successfully');

                return $this->respond([
                    'status' => 'ok',
                    'message' => 'Admin Login successful!',
                    'admin' => [
                        'admin_id' => $admin->admin_id,
                        'name'     => $admin->name,
                        'email'    => $admin->email
                    ]
                ]);
            } else {
                log_message('error', '❌ Password does NOT match');
                return $this->failUnauthorized('Invalid email or password.');
            }

        } catch (\Throwable $e) {
            log_message('error', 'Admin Login error: ' . $e->getMessage());
            return $this->failServerError('An unexpected error occurred during admin login.');
        }
    }
}
