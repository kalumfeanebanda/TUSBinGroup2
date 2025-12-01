<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class ItemCodes extends ResourceController
{
    protected $format = 'json';

    public function index()
    {
        $db = \Config\Database::connect();
        $q  = $db->query("CALL sp_get_itemcodes()");
        $rows = $q->getResultArray();

        if (method_exists($q, 'nextResult')) $q->nextResult();
        if (method_exists($q, 'freeResult')) $q->freeResult();

        return $this->respond(['status' => 'ok', 'data' => $rows]);
    }

    public function create()
    {
        $input = $this->request->getJSON(true);
        $itemID    = (int)($input['itemID'] ?? 0);
        $codeValue = $input['codeValue'] ?? '';

        $db = \Config\Database::connect();
        $db->query("CALL sp_add_itemcode(?, ?)", [$itemID, $codeValue]);

        return $this->respondCreated(['status' => 'ok', 'message' => 'ItemCode added']);
    }

    public function update($id = null)
    {
        $input = $this->request->getJSON(true);
        $itemID    = (int)($input['itemID'] ?? 0);
        $codeValue = $input['codeValue'] ?? '';

        $db = \Config\Database::connect();
        $db->query("CALL sp_update_itemcode(?, ?, ?)", [$id, $itemID, $codeValue]);

        return $this->respond(['status' => 'ok', 'message' => 'ItemCode updated']);
    }

    public function delete($id = null)
    {
        $db = \Config\Database::connect();
        $db->query("CALL sp_delete_itemcode(?)", [$id]);

        return $this->respondDeleted(['status' => 'ok', 'message' => 'ItemCode deleted']);
    }
}
