<?php

namespace App\Models;

use CodeIgniter\Model;

class DriversReviewModel extends Model
{
    protected $table      = 'tbl_drivers_review';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['driver_id', 'order_id', 'customer_id', 'review', 'message', 'status'];

    protected $useTimestamps = true;
    protected $createdField  = 'created';
    protected $updatedField  = 'updated';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    


}
