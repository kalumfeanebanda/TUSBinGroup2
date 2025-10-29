<?php

namespace App\Models;

use CodeIgniter\Model;

class BinModel extends Model
{
    protected $table         = 'BinType';
    protected $primaryKey    = 'binTypeID';
    protected $allowedFields = ['binName', 'binDesc'];

    // CREATE
    public function createBin(string $name, ?string $desc = null): ?int
    {
        $db = \Config\Database::connect();

        // OUT var
        $db->query('SET @new_id = 0');

        // CALL SP  (make sure the name matches your DB exactly)
        $call = $db->query('CALL adm_Create_bin(?, ?, @new_id)', [$name, $desc]);

        // VERY IMPORTANT: clear SP result sets on the query object
        if (method_exists($call, 'nextResult')) { $call->nextResult(); }
        if (method_exists($call, 'freeResult'))  { $call->freeResult();  }

        // Now it's safe to read the OUT var
        $row = $db->query('SELECT @new_id AS id')->getRow();
        return $row ? (int)$row->id : null;
    }

    // UPDATE
    public function updateBin(int $id, string $name, ?string $desc = null): bool
    {
        $db   = \Config\Database::connect();
        $call = $db->query('CALL adm_Update_bin(?, ?, ?)', [$id, $name, $desc]);

        // Clear SP result sets
        if (method_exists($call, 'nextResult')) { $call->nextResult(); }
        if (method_exists($call, 'freeResult'))  { $call->freeResult();  }

        // 0 rows affected can still be a valid "no-change" update
        return $db->affectedRows() >= 0;
    }

    // DELETE (you already had this right; just keep it consistent)
    public function deleteBin(int $id): bool
    {
        $db   = \Config\Database::connect();
        $call = $db->query('CALL adm_delete_bin(?)', [$id]);

        if (method_exists($call, 'nextResult')) { $call->nextResult(); }
        if (method_exists($call, 'freeResult'))  { $call->freeResult();  }

        return $db->affectedRows() > 0;
    }
}