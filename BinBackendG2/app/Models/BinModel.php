<?php

namespace App\Models;

use CodeIgniter\Model;

class BinModel extends Model
{

    protected $table      = 'BinType';
    protected $primaryKey = 'binTypeID';
    protected $allowedFields = ['binName', 'binDesc'];


    public function createBin(string $name, string $desc = null): ?int
    {
        $db = \Config\Database::connect();

        // Prepare OUT variable
        $db->query('SET @new_id = 0');


        $db->query('CALL adm_Create_bin(?, ?, @new_id)', [$name, $desc]);

        // Retrieve the OUT variable (the new ID)
        $result = $db->query('SELECT @new_id AS id')->getRow();

        // Cleanup after stored procedure call
        if (method_exists($db, 'nextResult')) {
            $db->nextResult();
        }
        if (method_exists($db, 'freeResult')) {
            $db->freeResult();
        }

        // Return the new ID or null if failed
        return $result ? (int) $result->id : null;
    }


    public function deleteBin(int $id): bool
    {
        $db = \Config\Database::connect();
        // Call the stored procedure
        $query = $db->query('CALL adm_Delete_bin(?)', [$id]);

        // Optional but safer for MySQL SP calls with CI
        if (method_exists($query, 'nextResult')) {
            $query->nextResult();
        }
        if (method_exists($query, 'freeResult')) {
            $query->freeResult();
        }

        // Return true if at least one row was affected
        return $db->affectedRows() > 0;
    }

}