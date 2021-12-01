<?php namespace App\Models;

use App\Models\BaseModel;

class RestaurantModel extends BaseModel
{
    protected $table      = 'tbl_restaurants';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['name', 'phone', 'email', 'address', 'pincode', 'country_id', 'state_id', 'city_id', 'latitude', 'longitude', 'owner_id', 'opening_time', 'closing_time', 'is_available', 'status', 'banner_image', 'profile_image', 'discount', 'discount_type', 'average_price', 'slug_url', 'is_featured'];

    protected $useTimestamps = true;
    protected $createdField  = 'created';
    protected $updatedField  = 'updated';
    protected $deletedField  = 'deleted';
    
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    
}