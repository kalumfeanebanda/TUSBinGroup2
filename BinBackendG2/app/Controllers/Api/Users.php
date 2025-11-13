<?php namespace App\Controllers\Api;

//  Ensure CORS headers are sent immediately before CodeIgniter runs anything
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, X-Requested-With, Authorization");
}

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\Response;

class Users extends ResourceController
{
    use ResponseTrait;
    protected $format = 'json';

    // ✅UNIVERSAL CORS HANDLER
    protected function handleCors(): ?Response
    {
        // Allow multiple localhost ports (Vue dev server ports)
        $allowedOrigins = [
            'http://localhost:5173',
            'http://localhost:5174',
            'http://localhost:5175',
            'http://localhost:5176',
            'http://127.0.0.1:5173',
            'http://127.0.0.1:5174',
            'http://127.0.0.1:5175',
            'http://127.0.0.1:5176'
        ];

        $origin = $this->request->getHeaderLine('Origin');

        if (in_array($origin, $allowedOrigins, true)) {
            $this->response->setHeader('Access-Control-Allow-Origin', $origin);
            $this->response->setHeader('Vary', 'Origin');
        } else {
            // For local development you can safely use '*'
            $this->response->setHeader('Access-Control-Allow-Origin', '*');
        }

        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
        $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With, Authorization');
        $this->response->setHeader('Access-Control-Allow-Credentials', 'true');

        // Handle preflight OPTIONS request
        if ($this->request->getMethod() === 'options') {
            return $this->response->setStatusCode(200);
        }

        return null;
    }

    // ✅ REGISTER USER
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

            // Call stored procedure
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
            return $this->failServerError('Registration failed: ' . $e->getMessage());
        }
    }

    // ✅ LOGIN METHOD
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

            $userQuery = $db->query("
                SELECT userID, email, password  
                FROM user                     
                WHERE email = ?
            ", [$data['email']]);

            $user = $userQuery->getRow();

            if (!$user) {
                return $this->failUnauthorized('Invalid email or password.');
            }

            $storedHash = trim($user->password);

            if (password_verify($data['password'], $storedHash)) {
                return $this->respond([
                    'status' => 'ok',
                    'message' => 'Login successful!',
                    'userID' => $user->userID,
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
