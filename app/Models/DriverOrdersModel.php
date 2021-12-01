<?php namespace App\Models;

use CodeIgniter\Model;

class DriverOrdersModel extends Model
{
    protected $table      = 'tbl_driver_orders';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['order_id', 'driver_id','driver_status', 'status'];

    protected $useTimestamps = true;
    protected $createdField  = 'created';
    protected $updatedField  = 'updated';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}