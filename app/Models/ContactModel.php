<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactModel extends Model
{
    protected $table      = 'tbl_contact_us';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['fullname', 'email', 'subject', 'message', 'status'];

    protected $useTimestamps = true;
    protected $createdField  = 'created';
    protected $updatedField  = 'updated';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    
}
