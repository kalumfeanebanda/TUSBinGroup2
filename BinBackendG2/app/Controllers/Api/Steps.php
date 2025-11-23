<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Steps extends ResourceController
{
    protected $format = 'json';

    public function index()
    {
        $db = \Config\Database::connect();

        $q = $db->query("CALL sp_get_steps()");
        $rows = $q->getResultArray();

        if (method_exists($q, 'nextResult')) $q->nextResult();
        if (method_exists($q, 'freeResult')) $q->freeResult();

        // 🔥 FIX HERE – Rename DB columns to frontend fields
        $mapped = array_map(function($r) {
            return [
                'prepStepID'   => $r['prepStepID'],
                'itemCodeID'   => $r['itemCodeID'],
                'stepOrder'    => $r['stepOrder'],
                'stepTitle'    => $r['stepDesc'],        // frontend short title
                'stepDesc'     => $r['stepLongDesc'],    // frontend long description
                'stepLongDesc' => $r['stepLongDesc']
            ];
        }, $rows);

        return $this->respond(['status'=>'ok', 'data'=>$mapped]);
    }


    public function create()
    {
        $input = $this->request->getJSON(true);

        $itemCodeID = $input['itemCodeID'] ?? null;
        $title      = $input['stepTitle'] ?? '';
        $desc       = $input['stepDesc'] ?? '';

        if (!$itemCodeID || empty($title)) {
            return $this->fail('itemCodeID and stepTitle are required', 400);
        }

        $db = \Config\Database::connect();
        $db->query("CALL sp_add_step(?, ?, ?)", [$itemCodeID, $title, $desc]);

        return $this->respondCreated(['status'=>'ok', 'message'=>'Step added']);
    }


    public function update($id = null)
    {
        $input = $this->request->getJSON(true);

        $itemCodeID = $input['itemCodeID'] ?? null;
        $title      = $input['stepTitle'] ?? '';
        $desc       = $input['stepDesc'] ?? '';

        if (!$id || !$itemCodeID || empty($title)) {
            return $this->fail('Missing required fields', 400);
        }

        $db = \Config\Database::connect();
        $db->query("CALL sp_update_step(?, ?, ?, ?)", [$id, $itemCodeID, $title, $desc]);

        return $this->respond(['status'=>'ok', 'message'=>'Step updated']);
    }


    public function delete($id = null)
    {
        if (is_null($id)) {
            return $this->fail('Missing step ID', 400);
        }

        $db = \Config\Database::connect();
        $db->query("CALL sp_delete_step(?)", [$id]);

        return $this->respondDeleted(['status'=>'ok','message'=>'Step deleted']);
    }
}
