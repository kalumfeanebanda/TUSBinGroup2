<?php namespace App\Controllers\Api;

// =========================================================
// UNIVERSAL DYNAMIC CORS HANDLER — runs before CodeIgniter
// =========================================================
if (isset($_SERVER['HTTP_ORIGIN'])) {
    $origin = $_SERVER['HTTP_ORIGIN'];

    // Automatically allow any localhost or 127.0.0.1 port (for Vue dev)
    if (preg_match('/^http:\/\/(localhost|127\.0\.0\.1):\d+$/', $origin)) {
        header("Access-Control-Allow-Origin: $origin");
    } else {
        // Fallback for production (you can later restrict this)
        header("Access-Control-Allow-Origin: *");
    }

    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, X-Requested-With, Authorization");
}

// Stop OPTIONS requests early (browser preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// =========================================================
// CODEIGNITER CONTROLLER
// =========================================================
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\Response;

class Users extends ResourceController
{
    use ResponseTrait;
    protected $format = 'json';

    // Optional internal CORS handling (CodeIgniter response layer)
    protected function handleCors(): ?Response
    {
        $origin = $this->request->getHeaderLine('Origin');

        if (preg_match('/^http:\/\/(localhost|127\.0\.0\.1):\d+$/', $origin)) {
            $this->response->setHeader('Access-Control-Allow-Origin', $origin);
        } else {
            $this->response->setHeader('Access-Control-Allow-Origin', '*');
        }

        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
        $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With, Authorization');
        $this->response->setHeader('Access-Control-Allow-Credentials', 'true');

        if ($this->request->getMethod() === 'options') {
            return $this->response->setStatusCode(200);
        }

        return null;
    }

    // REGISTER USER
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
            return $this->failServerError('Registration failed: ' . $e->getMessage());
        }
    }

    // LOGIN METHOD
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
