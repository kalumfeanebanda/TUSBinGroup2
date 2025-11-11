<?php
namespace App\Models;
use CodeIgniter\Model;

class ItemcodeModel extends Model
{
    protected $DBGroup = 'default';

    public function addItemCode($itemID, $codeType, $codeValue)
    {
        return $this->db->query("CALL AddItemCode(?, ?, ?)", [$itemID, $codeType, $codeValue]);
    }

    public function getAllItemCodes()
    {
        return $this->db->query("CALL GetAllItemCodes()")->getResultArray();
    }

    public function getItemCodeByID($codeID)
    {
        return $this->db->query("CALL GetItemCodeByID(?)", [$codeID])->getRowArray();
    }

    public function updateItemCode($codeID, $itemID, $codeType, $codeValue)
    {
        return $this->db->query("CALL UpdateItemCode(?, ?, ?, ?)", [$codeID, $itemID, $codeType, $codeValue]);
    }

    public function deleteItemCode($codeID)
    {
        return $this->db->query("CALL DeleteItemCode(?)", [$codeID]);
    }
}
