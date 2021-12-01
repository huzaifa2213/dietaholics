<?php namespace App\Models;

use CodeIgniter\Model;

class SubcategoryModel extends Model
{
    protected $table      = 'tbl_subcategories';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['title', 'image','status', 'category_id', 'description', 'discount', 'restaurant_id', 'type', 'discount_type', 'price'];

    protected $useTimestamps = true;
    protected $createdField  = 'created';
    protected $updatedField  = 'updated';
    protected $deletedField  = 'deleted';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}