<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Bins extends ResourceController
{

    protected $format = 'json';

    public function index()
    {
        $db = \Config\Database::connect();
        $q  = $db->query('CALL adm_Read_bins()');
        $rows = $q->getResultArray();
        if (method_exists($q,'nextResult')) $q->nextResult();
        if (method_exists($q,'freeResult'))  $q->freeResult();

        return $this->respond(['status' => 'ok', 'data' => $rows]);
    }

    public function create()
    {
        $data = $this->request->getJSON(true);
        if (empty($data['binName'])) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'message' => 'Bin name is required.',
            ]);
        }

        $model = new \App\Models\BinModel();
        $newId = $model->createBin($data['binName'], $data['binDesc'] ?? null);

        if ($newId) {
            return $this->response->setStatusCode(201)->setJSON([
                'status' => 'ok',
                'data' => [
                    'binTypeID' => $newId,
                    'binName'   => $data['binName'],
                    'binDesc'   => $data['binDesc'] ?? null,
                ],
            ]);
        }

        return $this->response->setStatusCode(500)->setJSON([
            'status' => 'error',
            'message' => 'Failed to create bin.',
        ]);
    }

    public function update($id = null)
    {
        $id = (int) ($id ?? 0);
        if ($id <= 0) {
            return $this->failValidationErrors('Invalid bin id');
        }

        $data  = $this->request->getJSON(true);
        $model = new \App\Models\BinModel();

        $ok = $model->updateBin($id, $data['binName'], $data['binDesc'] ?? null);

        if ($ok) {
            return $this->response->setJSON([
                'status' => 'ok',
                'data' => [
                    'binTypeID' => $id,
                    'binName'   => $data['binName'],
                    'binDesc'   => $data['binDesc'] ?? null,
                ],
            ]);
        }

        return $this->response->setStatusCode(500)->setJSON([
            'status' => 'error',
            'message' => 'Failed to update bin.',
        ]);
    }
    public function delete($id = null)
    {
        $id = (int)$id;
        if ($id <= 0) return $this->failValidationErrors('Invalid bin id');

        $db = \Config\Database::connect();
        $q  = $db->query('CALL adm_Delete_bin(?)', [$id]);
        if (method_exists($q,'nextResult')) $q->nextResult();
        if (method_exists($q,'freeResult'))  $q->freeResult();

        if ($db->affectedRows() > 0) return $this->respond(['status'=>'ok','success'=>true]);
        return $this->failNotFound('Bin not found');
    }
}