<?php

namespace App\Models;

use CodeIgniter\Model;

class BinModel extends Model
{

    protected $table      = 'BinType';
    protected $primaryKey = 'binTypeID';

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