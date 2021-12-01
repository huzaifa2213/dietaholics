<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table      = 'tbl_orders';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['address_id', 'user_id', 'restaurent_id', 'total_price', 'status', 'tip_price', 'discount_price', 'wallet_price', 'grand_total', 'payment_type', 'payment_status', 'order_status', 'signature', 'isReviewed', 'refund_amount', 'promo_code', 'admin_charge', 'delivery_charges', 'address', 'city', 'state', 'coutry', 'pincode', 'latitude', 'longitude', 'name', 'email', 'phone', 'transaction_id'];

    protected $useTimestamps = true;
    protected $createdField  = 'created';
    protected $updatedField  = 'updated';
    protected $deletedField  = 'deleted';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    
}
