<?php namespace App\Models;

use App\Models\BaseModel;

class UserModel extends BaseModel
{
    protected $table      = 'tbl_users';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['is_social_login', 'social_id', 'fullname', 'email', 'phone', 'password', 'image', 'status', 'token', 'city_id', 'state_id', 'country_id', 'pincode', 'address', 'device_token', 'last_login_date', 'otp', 'user_type', 'latitude', 'longitude', 'identity_number', 'identity_image', 'license_number', 'license_image', 'gender', 'age', 'date_of_birth', 'is_available', 'wallet_amount'];

    protected $useTimestamps = true;
    protected $createdField  = 'created';
    protected $updatedField  = 'updated';
    protected $deletedField  = 'deleted';
    
    protected $validationRules    = [
        // 'fullname'     => 'required|alpha_numeric_space|min_length[3]',
        // 'email'        => 'required|valid_email|is_unique[users.email]',
        // 'phone'     => 'required|min_length[8]',
        // 'password' => 'required|min_length[8]'
    ];
    protected $validationMessages = [
        // 'fullname'        => [
        //     'is_unique' => 'Sorry. That email has already been taken. Please choose another.'
        // ]
    ];
    protected $skipValidation     = false;

    
}