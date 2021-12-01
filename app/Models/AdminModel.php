<?php namespace App\Models;

use App\Models\BaseModel;

class AdminModel extends BaseModel
{
    protected $table      = 'tbl_admin';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['email', 'first_name', 'last_name', 'password', 'phone', 'image', 'status'];

    protected $useTimestamps = true;
    protected $createdField  = 'created';
    protected $updatedField  = 'updated';
    
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    
}