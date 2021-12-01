<?php namespace App\Models;

use CodeIgniter\Model;

class PagesModel extends Model
{
    protected $table      = 'tbl_pages';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['title', 'description','status'];

    protected $useTimestamps = true;
    protected $createdField  = 'created';
    protected $updatedField  = 'updated';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}