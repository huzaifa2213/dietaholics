<?php namespace App\Models;

use App\Models\BaseModel;

class UserAddressModel extends BaseModel
{
    protected $table      = 'tbl_user_addresses';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['user_id', 'name', 'phone', 'city', 'state', 'country', 'pincode', 'address_line_1', 'address_line_2', 'latitude', 'longitude', 'isDefault', 'status', 'address_type'];

    protected $useTimestamps = true;
    protected $createdField  = 'created';
    protected $updatedField  = 'updated';
    
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    
}