<?php namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table      = 'tbl_notification';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['title','status', 'description', 'type', 'type_id', 'user_id'];

    protected $useTimestamps = true;
    protected $createdField  = 'created';
    protected $updatedField  = 'updated';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}