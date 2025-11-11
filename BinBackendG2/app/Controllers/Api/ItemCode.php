<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class ItemCode extends ResourceController{
    protected $format = 'json';
    // CREATE
    public function create()
    {
        $data = $this->request->getPost();
        $this->model->addItemCode($data['itemID'], $data['codeType'], $data['codeValue']);
        return $this->respondCreated(['message' => 'ItemCode added successfully']);
    }

    // READ all
    public function index()
    {
        $data = $this->model->getAllItemCodes();
        return $this->respond($data);
    }

    // READ one
    public function show($id = null)
    {
        $data = $this->model->getItemCodeByID($id);
        return $data ? $this->respond($data) : $this->failNotFound('ItemCode not found');
    }

    // UPDATE
    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        $this->model->updateItemCode($id, $data['itemID'], $data['codeType'], $data['codeValue']);
        return $this->respond(['message' => 'ItemCode updated successfully']);
    }

    // DELETE
    public function delete($id = null)
    {
        $this->model->deleteItemCode($id);
        return $this->respondDeleted(['message' => 'ItemCode deleted successfully']);
    }

}