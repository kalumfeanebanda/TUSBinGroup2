<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Items extends ResourceController
{
    protected $format = 'json';

    public function index()
    {
        $db = \Config\Database::connect();
        $q = $db->query("CALL sp_read_items()");
        $rows = $q->getResultArray();

        if (method_exists($q, 'nextResult')) $q->nextResult();
        if (method_exists($q, 'freeResult')) $q->freeResult();

        return $this->respond(['status'=>'ok', 'data'=>$rows]);
    }

    public function create()
    {
        $input = $this->request->getJSON(true);
        $name = $input['itemName'] ?? '';
        $desc = $input['itemDesc'] ?? '';

        $db = \Config\Database::connect();
        $db->query("CALL sp_add_item(?, ?)", [$name, $desc]);

        return $this->respondCreated(['status'=>'ok','message'=>'Item added']);
    }

    public function update($id)
    {
        $input = $this->request->getJSON(true);
        $name = $input['itemName'] ?? '';
        $desc = $input['itemDesc'] ?? '';

        $db = \Config\Database::connect();
        $db->query("CALL sp_update_item(?, ?, ?)", [$id, $name, $desc]);

        return $this->respond(['status'=>'ok','message'=>'Item updated']);
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->query("CALL sp_delete_item(?)", [$id]);

        return $this->respondDeleted(['status'=>'ok','message'=>'Item deleted']);
    }
}

