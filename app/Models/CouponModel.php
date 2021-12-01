<?php namespace App\Models;

use CodeIgniter\Model;

class CouponModel extends Model
{
    protected $table      = 'tbl_coupons';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['coupon_code', 'image','status', 'description', 'discount_type', 'discount', 'start_date', 'end_date', 'resaturant_ids'];

    protected $useTimestamps = true;
    protected $createdField  = 'created';
    protected $updatedField  = 'updated';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}