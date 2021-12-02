<?php namespace App\Models;


use CodeIgniter\Model;

class DriverCompanyModel extends Model
{
    protected $table      = 'tbl_drivers_company';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['company_name', 'owner_name', 'owner_mobile_number', 'restaurant_id', 'identity_number', 'owner_id_number', 'company_email_id', 'status', 'license_number', 'company_contact_number', 'address','password','owner_id'];

    protected $useTimestamps = true;
    protected $createdField  = 'created';
    protected $updatedField  = 'updated';
    
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    
}