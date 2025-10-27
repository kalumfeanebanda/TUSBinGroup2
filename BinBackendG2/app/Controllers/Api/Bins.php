<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Bins extends ResourceController
{

    protected $format = 'json';

    public function index(){
        $db   = \Config\Database::connect();
        $q    = $db->query("CALL adm_Read_bins();");
        $rows = $q->getResultArray();

        // flush extra result sets after CALL
        while ($db->connID->more_results() && $db->connID->next_result()) {}

        return $this->respond(['data' => $rows]);
    }

    public function delete($id = null)
    {
        $id = (int)$id;
        if ($id <= 0) {
            return $this->failValidationErrors('Invalid bin id');
        }

        try {
            $db = \Config\Database::connect();
            $q = $db->query('CALL adm_Delete_bin(?)', [$id]);

            // flush extra result sets after CALL
            while ($db->connID->more_results() && $db->connID->next_result()) {
            }


            if ($db->affectedRows() > 0) {
                return $this->respond(['success' => true]);
            }
            return $this->failNotFound('Bin not found');
        } catch (\Throwable $e) {
            return $this->failServerError($e->getMessage());
        }
    }

}