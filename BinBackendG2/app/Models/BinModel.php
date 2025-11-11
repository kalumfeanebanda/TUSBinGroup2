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


        $db->query('SET @new_id = 0');

        $call = $db->query('CALL adm_Create_bin(?, ?, @new_id)', [$name, $desc]);


        if (method_exists($call, 'nextResult')) { $call->nextResult(); }
        if (method_exists($call, 'freeResult'))  { $call->freeResult();  }


        $row = $db->query('SELECT @new_id AS id')->getRow();
        return $row ? (int)$row->id : null;
    }

    // UPDATE
    public function updateBin(int $id, string $name, ?string $desc = null): bool
    {
        $db   = \Config\Database::connect();
        $call = $db->query('CALL adm_Update_bin(?, ?, ?)', [$id, $name, $desc]);


        if (method_exists($call, 'nextResult')) { $call->nextResult(); }
        if (method_exists($call, 'freeResult'))  { $call->freeResult();  }


        return $db->affectedRows() >= 0;
    }

   //delete
    public function deleteBin(int $id): bool
    {
        $db   = \Config\Database::connect();
        $call = $db->query('CALL adm_delete_bin(?)', [$id]);

        if (method_exists($call, 'nextResult')) { $call->nextResult(); }
        if (method_exists($call, 'freeResult'))  { $call->freeResult();  }

        return $db->affectedRows() > 0;
    }
}