<?php namespace App\Models;

use CodeIgniter\Model;

class DeviceTokenModel extends Model
{
    protected $table      = 'tbl_device_token';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['user_id', 'device_token', 'is_last_login','status'];

    protected $useTimestamps = true;
    protected $createdField  = 'created';
    protected $updatedField  = 'updated';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}