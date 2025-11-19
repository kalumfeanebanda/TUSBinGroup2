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
                FROM users
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



    // GET /api/users
    public function index()
    {
        $db = \Config\Database::connect();
        $q = $db->query('CALL adm_Read_users()');
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
                    'fname' => $data['fname'],
                    'lname' => $data['lname'],
                    'email' => $data['email'],
                ],
            ]);
        }

        return $this->failServerError('Failed to create user.');
    }

    // PUT /api/users/{id}
    public function update($id = null)
    {
        $id = (int)($id ?? 0);
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
                    'fname' => $data['fname'],
                    'lname' => $data['lname'],
                    'email' => $data['email'],
                ],
            ]);


        }

        return $this->failServerError('Failed to update user.');
    }

    // DELETE /api/users/{id}
    public function delete($id = null)
    {
        $id = (int)$id;
        if ($id <= 0) return $this->failValidationErrors('Invalid user ID');

        $db = \Config\Database::connect();
        $q = $db->query('CALL adm_Delete_user(?)', [$id]);


        if (method_exists($q, 'nextResult')) $q->nextResult();
        if (method_exists($q, 'freeResult')) $q->freeResult();

        if ($db->affectedRows() > 0)
            return $this->respond(['status' => 'ok', 'success' => true]);

        return $this->failNotFound('User not found.');
    }



}
