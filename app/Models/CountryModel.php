<?php namespace App\Models;

use CodeIgniter\Model;

class CountryModel extends Model
{
    protected $table      = 'tbl_country';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['name','status'];

    protected $useTimestamps = true;
    protected $createdField  = 'created';
    protected $updatedField  = 'updated';
    protected $deletedField  = 'deleted';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}