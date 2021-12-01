<?php namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table      = 'tbl_categories';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['title', 'image','status', 'is_featured', 'slug_url'];

    protected $useTimestamps = true;
    protected $createdField  = 'created';
    protected $updatedField  = 'updated';
    protected $deletedField  = 'deleted';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}