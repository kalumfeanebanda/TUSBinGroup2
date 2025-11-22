<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Steps extends ResourceController
{
    protected $format = 'json';

    /**
     * GET /api/steps
     * Returns all preparation steps
     */
    public function index()
    {
        $db = \Config\Database::connect();

        // Updated stored procedure (must return itemCodeID)
        $q = $db->query("CALL sp_get_steps()");
        $rows = $q->getResultArray();

        // Cleanup for stored procedures
        if (method_exists($q, 'nextResult')) $q->nextResult();
        if (method_exists($q, 'freeResult')) $q->freeResult();

        return $this->respond([
            'status' => 'ok',
            'data'   => $rows
        ]);
    }

    /**
     * POST /api/steps
     * Creates a new step
     */
    public function create()
    {
        $input = $this->request->getJSON(true);

        $itemCodeID = $input['itemCodeID'] ?? null;
        $title      = $input['stepTitle'] ?? '';
        $desc       = $input['stepDesc'] ?? '';

        if (!$itemCodeID) {
            return $this->failValidationErrors("itemCodeID is required.");
        }
        if (!$title) {
            return $this->failValidationErrors("Step title is required.");
        }

        $db = \Config\Database::connect();

        // Updated stored procedure: now accepts itemCodeID, title, description
        $db->query("CALL sp_add_step(?, ?, ?)", [
            $itemCodeID,
            $title,
            $desc
        ]);

        return $this->respondCreated([
            'status'  => 'ok',
            'message' => 'Step created successfully'
        ]);
    }

    /**
     * PUT /api/steps/{id}
     * Updates existing step
     */
    public function update($id = null)
    {
        if (!$id) {
            return $this->failValidationErrors("Missing step ID.");
        }

        $input = $this->request->getJSON(true);

        $itemCodeID = $input['itemCodeID'] ?? null;
        $title      = $input['stepTitle'] ?? '';
        $desc       = $input['stepDesc'] ?? '';

        if (!$itemCodeID) {
            return $this->failValidationErrors("itemCodeID is required.");
        }
        if (!$title) {
            return $this->failValidationErrors("Step title is required.");
        }

        $db = \Config\Database::connect();

        // Updated stored procedure: ID, itemCodeID, title, desc
        $db->query("CALL sp_update_step(?, ?, ?, ?)", [
            $id,
            $itemCodeID,
            $title,
            $desc
        ]);

        return $this->respond([
            'status'  => 'ok',
            'message' => 'Step updated successfully'
        ]);
    }

    /**
     * DELETE /api/steps/{id}
     * Deletes a step
     */
    public function delete($id = null)
    {
        if (!$id) {
            return $this->failValidationErrors("Missing step ID.");
        }

        $db = \Config\Database::connect();

        // Stored procedure unchanged
        $db->query("CALL sp_delete_step(?)", [$id]);

        return $this->respondDeleted([
            'status'  => 'ok',
            'message' => 'Step deleted successfully'
        ]);
    }
}
