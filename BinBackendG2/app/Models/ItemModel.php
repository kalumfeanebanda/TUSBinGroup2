<?php namespace App\Models;

use CodeIgniter\Model;

class ItemModel extends Model
{
    public function createItem($name, $desc)
    {
        $db = \Config\Database::connect();
        $q  = $db->query("CALL adm_Create_item(?,?)", [$name, $desc]);
        $row = $q->getRowArray();

        if (method_exists($q,'nextResult')) $q->nextResult();
        if (method_exists($q,'freeResult')) $q->freeResult();

        return $row['id'] ?? null;
    }

    public function updateItem($id, $name, $desc)
    {
        $db = \Config\Database::connect();
        $db->query("CALL adm_Update_item(?,?,?)", [$id, $name, $desc]);
    }
}

