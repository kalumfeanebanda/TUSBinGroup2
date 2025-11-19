<?php namespace App\Models;

use CodeIgniter\Model;

class ItemBinModel extends Model
{
    protected $table = 'itembin';
    protected $primaryKey = 'itemID';  // CI4 requires a PK, even if composite
    protected $allowedFields = ['itemID', 'binTypeID', 'ruleNote'];
    public $useAutoIncrement = false;

    // Get all mappings
    public function getAllItemBin()
    {
        return $this->findAll();
    }

    // Get single mapping
    public function getItemBin($itemID, $binTypeID)
    {
        return $this->where('itemID', $itemID)
            ->where('binTypeID', $binTypeID)
            ->first();
    }

    // Add mapping
    public function addItemBin($itemID, $binTypeID, $ruleNote)
    {
        return $this->insert([
            'itemID' => $itemID,
            'binTypeID' => $binTypeID,
            'ruleNote' => $ruleNote
        ]);
    }

    // Update mapping
    public function updateItemBin($itemID, $binTypeID, $ruleNote)
    {
        return $this->where('itemID', $itemID)
            ->where('binTypeID', $binTypeID)
            ->set(['ruleNote' => $ruleNote])
            ->update();
    }

    // Delete mapping
    public function deleteItemBin($itemID, $binTypeID)
    {
        return $this->where('itemID', $itemID)
            ->where('binTypeID', $binTypeID)
            ->delete();
    }
}
