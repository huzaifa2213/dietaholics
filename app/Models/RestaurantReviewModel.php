<?php namespace App\Models;

use CodeIgniter\Model;

class RestaurantReviewModel extends Model
{
    protected $table      = 'tbl_restaurants_review';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['restaurant_id', 'customer_id','status', 'order_id', 'review', 'message'];

    protected $useTimestamps = true;
    protected $createdField  = 'created';
    protected $updatedField  = 'updated';
   // protected $deletedField  = 'deleted';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}