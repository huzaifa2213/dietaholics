<?php namespace App\Models;

use App\Models\BaseModel;

class OwnerModel extends BaseModel
{
    protected $table      = 'tbl_owner';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['email', 'first_name', 'last_name', 'password', 'phone', 'image', 'status', 'reset_password_token', 'city_id', 'state_id', 'country_id', 'pincode', 'address', 'device_token'];

    protected $useTimestamps = true;
    protected $createdField  = 'created';
    protected $updatedField  = 'updated';
    
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    
}