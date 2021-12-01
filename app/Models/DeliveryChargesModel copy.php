<?php namespace App\Models;

use CodeIgniter\Model;

class DeliveryChargesModel extends Model
{
    protected $table      = 'tbl_delivery_charges';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['min_distance', 'max_distance','charges', 'status'];

    protected $useTimestamps = true;
    protected $createdField  = 'created';
    protected $updatedField  = 'updated';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}