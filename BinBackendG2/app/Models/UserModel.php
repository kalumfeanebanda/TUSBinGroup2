<?php

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table         = 'Users';
    protected $primaryKey    = 'userID';
    protected $allowedFields = ['fname', 'lname', 'email', 'password'];

    // CREATE
    public function createUser(string $fname, string $lname, string $email, string $password): ?int
    {
        $db = \Config\Database::connect();
        $db->query('SET @new_id = 0');

        $call = $db->query('CALL adm_Create_user(?, ?, ?, ?, @new_id)', [$fname, $lname, $email, $password]);

        if (method_exists($call, 'nextResult')) { $call->nextResult(); }
        if (method_exists($call, 'freeResult'))  { $call->freeResult();  }

        $row = $db->query('SELECT @new_id AS id')->getRow();
        return $row ? (int)$row->id : null;
    }

    // READ ALL
    public function getAllUsers()
    {
        $db = \Config\Database::connect();
        $query = $db->query('CALL adm_Read_users()');
        $data = $query->getResultArray();

        if (method_exists($query, 'nextResult')) { $query->nextResult(); }
        if (method_exists($query, 'freeResult'))  { $query->freeResult();  }

        return $data;
    }

    // UPDATE
    public function updateUser(int $id, string $fname, string $lname, string $email, string $password): bool
    {
        $db = \Config\Database::connect();
        $call = $db->query('CALL adm_Update_user(?, ?, ?, ?, ?)', [$id, $fname, $lname, $email, $password]);

        if (method_exists($call, 'nextResult')) { $call->nextResult(); }
        if (method_exists($call, 'freeResult'))  { $call->freeResult();  }

        return $db->affectedRows() >= 0;
    }

    // DELETE
    public function deleteUser(int $id): bool
    {
        $db = \Config\Database::connect();
        $call = $db->query('CALL adm_Delete_user(?)', [$id]);

        if (method_exists($call, 'nextResult')) { $call->nextResult(); }
        if (method_exists($call, 'freeResult'))  { $call->freeResult();  }

        return $db->affectedRows() > 0;
    }
}