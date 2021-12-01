<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderDetailsModel extends Model
{
    protected $table      = 'tbl_order_details';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['product_id', 'product_price',  'order_id', 'product_quantity', 'status', 'extra_note'];

    protected $useTimestamps = true;
    protected $createdField  = 'created';
    protected $updatedField  = 'updated';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    
}
