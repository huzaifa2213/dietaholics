<?php namespace App\Models;

use CodeIgniter\Model;

class EarningModel extends Model
{
    protected $table      = 'tbl_earnings';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['order_id', 'restaurent_id','admin_charge_amount', 'owners_amount', 'total_amount', 'status','payment_status', 'payment_date'];

    protected $useTimestamps = true;
    protected $createdField  = 'created';
    protected $updatedField  = 'updated';
    protected $deletedField  = 'deleted';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}