<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class ItemBin extends ResourceController
{
    protected $format = 'json';

    // CREATE
    public function create()
    {
        $data = $this->request->getPost();

        // Required validation
        if (empty($data['itemID']) || empty($data['binTypeID'])) {
            return $this->failValidationErrors("itemID and binTypeID are required.");
        }

        $this->model->addItemBin(
            $data['itemID'],
            $data['binTypeID'],
            $data['ruleNote'] ?? null
        );

        return $this->respondCreated(['message' => 'ItemBin created successfully']);
    }

    // READ all
    public function index()
    {
        $data = $this->model->getAllItemBin();
        return $this->respond($data);
    }

    // READ one (composite key)
    public function show($itemID = null, $binTypeID = null)
    {
        $data = $this->model->getItemBin($itemID, $binTypeID);
        return $data ? $this->respond($data) : $this->failNotFound('ItemBin entry not found');
    }

    // UPDATE
    public function update($itemID = null, $binTypeID = null)
    {
        $data = $this->request->getRawInput();

        if (!isset($data['ruleNote'])) {
            return $this->failValidationErrors("ruleNote is required to update.");
        }

        $this->model->updateItemBin(
            $itemID,
            $binTypeID,
            $data['ruleNote']
        );

        return $this->respond(['message' => 'ItemBin updated successfully']);
    }

    // DELETE
    public function delete($itemID = null, $binTypeID = null)
    {
        $this->model->deleteItemBin($itemID, $binTypeID);
        return $this->respondDeleted(['message' => 'ItemBin deleted successfully']);
    }
}
