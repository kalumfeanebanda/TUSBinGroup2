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

}