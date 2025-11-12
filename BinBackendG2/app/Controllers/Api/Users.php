<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\Response;
class Users extends ResourceController
{
    use ResponseTrait;
    protected $format = 'json';
// 1. ADDED CORS HANDLER METHOD (Essential for connection)
    // =========================================================
    protected function handleCors(): ?Response
    {
        // Set headers to allow Vue frontend (localhost:5173) to communicate with API (localhost:8080)
        $this->response->setHeader('Access-Control-Allow-Origin', 'http://localhost:5173');
        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
        $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With, Authorization');
        $this->response->setHeader('Access-Control-Allow-Credentials', 'true');

        // Handle the OPTIONS (preflight) request from the browser
        if ($this->request->getMethod() === 'options') {
            return $this->response->setStatusCode(200);
        }

        return null; // Continue processing the request
    }


    public function register()
    {
        // === NEW CORS CALL START ===
        $response = $this->handleCors();
        if ($response) return $response; // Stops execution if it was an OPTIONS request
        // === NEW CORS CALL END ===
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
        // === NEW CORS CALL START ===
        $response = $this->handleCors();
        if ($response) return $response; // Stops execution if it was an OPTIONS request
        // === NEW CORS CALL END ===
        // 1. Get incoming JSON data
        $data = $this->request->getJSON(true);

        // 2. Server-Side Validation: Check if fields are present
        if (empty($data['email']) || empty($data['password'])) {
            return $this->failValidationErrors('Email and password are required.');
        }

        try {
            $db = \Config\Database::connect();

            // 3. Find the user by email and get the HASHED 'password' column
            // We select the 'password' column directly now.
            $userQuery = $db->query("
        SELECT userID, email, password  
        FROM user                     
        WHERE email = ?
    ", [$data['email']]);

            $user = $userQuery->getRow();

            // 4. Check if user was found in the database
            if (!$user) {
                // User not found -> Invalid credentials
                return $this->failUnauthorized('Invalid email or password.');
            }

            // --- CRITICAL CHANGE: CLEAN THE HASH IN PHP ---
            // Explicitly trim the hash to guarantee no leading/trailing whitespace before verifying.
            $storedHash = trim($user->password);
            // ----------------------------------------------

            // 5. Verify the password hash
            // We use the CLEAN HASH stored in $storedHash against the plain text password from the request
            if (password_verify($data['password'], $storedHash)) {

                // 6. Login Successful!

                return $this->respond([
                    'status' => 'ok',
                    'message' => 'Login successful!',
                    'userID' => $user->userID,
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
