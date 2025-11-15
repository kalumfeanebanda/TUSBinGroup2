<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Items extends ResourceController
{
    protected $format = 'json';

    public function index()
    {
        $db = \Config\Database::connect();
        $q = $db->query("CALL sp_get_items()");
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

    public function update($id = null)
    {
        $input = $this->request->getJSON(true);
        $name = $input['itemName'] ?? '';
        $desc = $input['itemDesc'] ?? '';

        $db = \Config\Database::connect();
        $db->query("CALL sp_update_item(?, ?, ?)", [$id, $name, $desc]);

        return $this->respond(['status'=>'ok','message'=>'Item updated']);
    }

    public function delete($id = null)
    {
        $db = \Config\Database::connect();
        $db->query("CALL sp_delete_item(?)", [$id]);

        return $this->respondDeleted(['status'=>'ok','message'=>'Item deleted']);
    }


    public function searchNames()
    {
        $q = trim((string)$this->request->getGet('q'));
        if ($q === '') {
            return $this->response->setStatusCode(400)->setJSON(['message' => 'Missing q']);
        }

        $db  = \Config\Database::connect();
        $res = $db->query("CALL sp_SearchItemName(?)", [$q]);
        $rows = $res->getResultArray();


        $conn = $db->connID;
        while ($conn->more_results() && $conn->next_result()) {
            if ($tmp = $conn->store_result()) { $tmp->free(); }
        }


        $payload = array_map(fn($r) => [
            'itemID'   => (int)$r['itemID'],
            'itemName' => $r['itemName'],
        ], $rows);

        return $this->response->setJSON($payload);
    }



    public function resultP($id = null)
    {
        $itemID = (int)$id;
        if ($itemID <= 0) {
            return $this->response->setStatusCode(400)->setJSON(['message' => 'Invalid item id']);
        }

        $db   = \Config\Database::connect();
        $res1 = $db->query("CALL sp_ResultPageGenerate(?)", [$itemID]);

        // header row (Item + BinType + ruleNote)
        $header = $res1->getRowArray() ?: null;

        // second result set: steps
        $conn = $db->connID;
        $conn->next_result();
        $stepsRes = $conn->store_result();

        $prepSteps = [];
        if ($stepsRes) {
            while ($row = $stepsRes->fetch_assoc()) {
                $prepSteps[] = [
                    'stepOrder' => (int)$row['stepOrder'],
                    'stepDesc'  => $row['stepDesc'],
                ];
            }
            $stepsRes->free();
        }


        while ($conn->more_results() && $conn->next_result()) {
            if ($tmp = $conn->store_result()) { $tmp->free(); }
        }

        if (!$header) {
            return $this->response->setStatusCode(404)->setJSON(['message' => 'Item not found']);
        }

        return $this->response->setJSON([
            'itemID'   => (int)$header['itemID'],
            'itemName' => $header['itemName'],
            'itemDesc' => $header['itemDesc'],
            'createdAt'=> $header['createdAt'],
            'recommendedBin' => $header['binTypeID'] ? [
                'binTypeID' => (int)$header['binTypeID'],
                'binName'   => $header['binName'],
                'binDesc'   => $header['binDesc'],
            ] : null,
            'ruleNote'  => $header['ruleNote'] ?? '',
            'prepSteps' => $prepSteps,
        ]);
    }
}
