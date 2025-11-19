<?php namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    // Define the table this model interacts with
    protected $table = 'admin_user';

    // Define the primary key
    protected $primaryKey = 'admin_id';

    // Specify the fields that can be read/written
    protected $allowedFields = ['email', 'password', 'name'];

    // Define the return type as an object (standard practice)
    protected $returnType = 'object';
}