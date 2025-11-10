<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

// This controller manages CRUD operations for the 'Steps' resource.
// It mirrors the logic of Items.php but uses stored procedures specific to 'Steps'.

class Steps extends ResourceController
{
    protected $format = 'json';

    /**
     * Retrieves a list of all steps.
     * Corresponds to: GET /api/steps
     * Uses stored procedure: CALL sp_get_steps()
     */
    public function index()
    {
        $db = \Config\Database::connect();

        // Execute the stored procedure to get all steps
        // NOTE: The stored procedure 'sp_get_steps()' must alias 'prepStepID' as 'prepStepId'
        // and map the DB's 'stepDesc' column to both 'stepTitle' and 'stepDesc' for the frontend.
        $q = $db->query("CALL sp_get_steps()");
        $rows = $q->getResultArray();

        // Handle multiple results/cleanup if necessary (common for stored procedure calls)
        if (method_exists($q, 'nextResult')) $q->nextResult();
        if (method_exists($q, 'freeResult')) $q->freeResult();

        return $this->respond(['status'=>'ok', 'data'=>$rows]);
    }

    /**
     * Creates a new step.
     * Corresponds to: POST /api/steps
     * Uses stored procedure: CALL sp_add_step(?)
     */
    public function create()
    {
        // Get JSON input from the request body
        $input = $this->request->getJSON(true);
        $title = $input['stepTitle'] ?? ''; // This is the data we want to save
        // REMOVED: $desc = $input['stepDesc'] ?? ''; // This second field is ignored

        // Simple validation to ensure required fields are present
        if (empty($title)) {
            return $this->fail('Step title is required', 400);
        }

        $db = \Config\Database::connect();
        // CHANGED: The SP call now only uses ONE parameter, mapping stepTitle to the DB's stepDesc column.
        $db->query("CALL sp_add_step(?)", [$title]);

        return $this->respondCreated(['status'=>'ok','message'=>'Step added']);
    }

    /**
     * Updates an existing step.
     * Corresponds to: PUT /api/steps/{id}
     * Uses stored procedure: CALL sp_update_step(?, ?)
     */
    public function update($id = null)
    {
        // Get JSON input from the request body
        $input = $this->request->getJSON(true);
        $title = $input['stepTitle'] ?? ''; // This is the data we want to save
        // REMOVED: $desc = $input['stepDesc'] ?? ''; // This second field is ignored

        // Simple validation
        if (is_null($id) || empty($title)) {
            return $this->fail('Invalid request or missing step ID/title', 400);
        }

        $db = \Config\Database::connect();
        // CHANGED: The SP call now uses TWO parameters: the ID (prepStepId) and the data (stepTitle).
        $db->query("CALL sp_update_step(?, ?)", [$id, $title]);

        return $this->respond(['status'=>'ok','message'=>'Step updated']);
    }

    /**
     * Deletes a step.
     * Corresponds to: DELETE /api/steps/{id}
     * Uses stored procedure: CALL sp_delete_step(?)
     */
    public function delete($id = null)
    {
        if (is_null($id)) {
            return $this->fail('Missing step ID', 400);
        }

        $db = \Config\Database::connect();
        // The ID parameter ($id) here represents the prepStepId sent from the frontend.
        $db->query("CALL sp_delete_step(?)", [$id]);

        return $this->respondDeleted(['status'=>'ok','message'=>'Step deleted']);
    }
}