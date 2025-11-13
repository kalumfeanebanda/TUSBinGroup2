<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;

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

            // 3. Find the user by email and get the HASHED 'password' column
            $userQuery = $db->query("
 SELECT userID, email, TRIM(password) as password_hash_trimmed 
        FROM user                     
        WHERE email = ?
    ", [$data['email']]);

            $user = $userQuery->getRow();

            // 4. Check if user was found in the database
            if (!$user) {
                // User not found -> Invalid credentials
                return $this->failUnauthorized('Invalid email or password.');
            }

            // 5. Verify the password hash
            // We use the HASH stored in $user->password against the plain text password from the request
            if (password_verify($data['password'], $user->password_hash_trimmed)) {

                // 6. Login Successful!
                // TODO: Here you would typically generate a JWT token for session management

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



