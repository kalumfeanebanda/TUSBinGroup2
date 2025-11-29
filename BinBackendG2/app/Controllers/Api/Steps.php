<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Steps extends ResourceController
{
    protected $format = 'json';

    public function index()
    {
        $db = \Config\Database::connect();

        $query = $db->query("CALL sp_get_steps()");
        $rows  = $query->getResultArray();

        if (method_exists($query, 'nextResult')) $query->nextResult();
        if (method_exists($query, 'freeResult')) $query->freeResult();

        $mapped = array_map(function($r) {
            return [
                'prepStepID'   => (int)$r['prepStepID'],
                'itemCodeID'   => (int)$r['itemCodeID'],
                'stepOrder'    => (int)$r['stepOrder'],
                'stepTitle'    => $r['stepDesc'],
                'stepLongDesc' => $r['stepLongDesc'],
            ];
        }, $rows);

        return $this->respond(['status'=>'ok','data'=>$mapped]);
    }

    public function create()
    {
        $input = $this->request->getJSON(true);

        $itemCodeID   = $input['itemCodeID'] ?? '';
        $stepTitle    = $input['stepTitle'] ?? '';
        $stepLongDesc = $input['stepLongDesc'] ?? '';

        if (!$itemCodeID || $stepTitle === '') {
            return $this->fail('itemCodeID and stepTitle are required', 400);
        }

        $db = \Config\Database::connect();
        $query = $db->query("CALL sp_add_step(?, ?, ?)", [
            $itemCodeID, $stepTitle, $stepLongDesc
        ]);

        if (method_exists($query, 'nextResult')) $query->nextResult();
        if (method_exists($query, 'freeResult')) $query->freeResult();

        return $this->respondCreated(['status'=>'ok','message'=>'Step added']);
    }

    public function update($id = null)
    {
        // Fix: CI sometimes passes array
        $id = is_array($id) ? $id[0] : $id;
        $id = (int)$id;

        if (!$id) return $this->fail('Missing step ID', 400);

        $input = $this->request->getJSON(true);

        $itemCodeID   = $input['itemCodeID'] ?? '';
        $stepTitle    = $input['stepTitle'] ?? '';
        $stepLongDesc = $input['stepLongDesc'] ?? '';

        if (!$itemCodeID || $stepTitle === '') {
            return $this->fail('Missing required fields', 400);
        }

        $db = \Config\Database::connect();
        $query = $db->query("CALL sp_update_step(?, ?, ?, ?)", [
            $id, $itemCodeID, $stepTitle, $stepLongDesc
        ]);

        if (method_exists($query, 'nextResult')) $query->nextResult();
        if (method_exists($query, 'freeResult')) $query->freeResult();

        return $this->respond(['status'=>'ok','message'=>'Step updated']);
    }

    public function delete($id = null)
    {
        // Fix: CI sometimes passes array
        $id = is_array($id) ? $id[0] : $id;
        $id = (int)$id;

        if (!$id) return $this->fail('Missing step ID', 400);

        $db = \Config\Database::connect();
        $query = $db->query("CALL sp_delete_step(?)", [$id]);

        if (method_exists($query, 'nextResult')) $query->nextResult();
        if (method_exists($query, 'freeResult')) $query->freeResult();

        return $this->respondDeleted(['status'=>'ok','message'=>'Step deleted']);
    }
}
